<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Section;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    /**
     * Display a listing of the courses.
     */
    public function index(Request $request)
    {
        $query = Course::with(['category', 'instructor']);

        // Apply filters
        if ($request->filled('search')) {
            $query->where('title', 'LIKE', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Apply sorting
        switch ($request->get('sort', 'latest')) {
            case 'latest':
                $query->latest();
                break;
            case 'oldest':
                $query->oldest();
                break;
            case 'title_asc':
                $query->orderBy('title');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
            case 'students_desc':
                $query->orderBy('total_students', 'desc');
                break;
            case 'students_asc':
                $query->orderBy('total_students');
                break;
        }

        $courses = $query->paginate(15);
        $categories = Category::all();

        return view('admin.courses.index', compact('courses', 'categories'));
    }

    /**
     * Show the form for creating a new course.
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.courses.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created course in storage.
     */
    public function store(Request $request)
    {
        // Validate only the fields that exist in your form
        $validated = $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'course_type' => 'required|in:free,paid',
            'price' => 'nullable|numeric|min:0',
            'description' => 'required|min:50',
            'excerpt' => 'nullable|max:500',
            'level' => 'nullable|in:beginner,intermediate,advanced,all-levels',
            'language' => 'nullable|string|max:50',
            'prerequisites' => 'nullable|string',
            'what_you_will_learn' => 'nullable|string',
            'requirements' => 'nullable|string',
            'target_audience' => 'nullable|string',
            'material_includes' => 'nullable|string',
            'featured' => 'nullable|boolean',
            'popular' => 'nullable|boolean',
            'status' => 'required|in:draft,published,archived',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'video_intro' => 'nullable|mimetypes:video/mp4,video/webm|max:51200',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'seo_title' => 'nullable|max:255',
            'seo_description' => 'nullable|max:500',
            'seo_keywords' => 'nullable|max:500'
        ]);

        DB::beginTransaction();

        try {
            // Set is_free based on course_type
            $validated['is_free'] = $validated['course_type'] === 'free';

            // IMPORTANT FIX: Set price to null for free courses
            if ($validated['course_type'] === 'free') {
                $validated['price'] = null;
            }

            // Generate slug
            $validated['slug'] = Str::slug($validated['title']);

            // Set created_by
            $validated['created_by'] = auth()->id();

            // Handle thumbnail upload
            if ($request->hasFile('thumbnail')) {
                $path = $request->file('thumbnail')->store('courses/thumbnails', 'public');
                $validated['thumbnail'] = $path;
            }

            // Handle intro video upload
            if ($request->hasFile('video_intro')) {
                $path = $request->file('video_intro')->store('courses/videos', 'public');
                $validated['video_intro'] = $path;
            }

            // Create course
            $course = Course::create($validated);

            // Sync tags
            if ($request->has('tags')) {
                $course->tags()->sync($request->tags);
            }

            DB::commit();

            if ($request->has('save_and_continue')) {
                return redirect()->route('admin.courses.edit', $course)
                    ->with('success', 'Course created successfully. Continue editing.');
            }

            return redirect()->route('admin.courses.index')
                ->with('success', 'Course created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create course: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified course.
     */
    public function show(Course $course)
    {
        $course->load(['category', 'instructor', 'tags', 'sections.lessons' => function ($q) {
            $q->orderBy('sort_order');
        }]);

        return view('admin.courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified course.
     */
    public function edit(Course $course)
    {
        $categories = Category::all();
        $tags = Tag::all();
        $course->load('tags');

        return view('admin.courses.edit', compact('course', 'categories', 'tags'));
    }

    /**
     * Update the specified course in storage.
     */
    public function update(Request $request, Course $course)
    {
        // Validate only the fields that exist in your form
        $validated = $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'course_type' => 'required|in:free,paid',
            'price' => 'nullable|numeric|min:0',
            'description' => 'required|min:50',
            'excerpt' => 'nullable|max:500',
            'level' => 'nullable|in:beginner,intermediate,advanced,all-levels',
            'language' => 'nullable|string|max:50',
            'prerequisites' => 'nullable|string',
            'what_you_will_learn' => 'nullable|string',
            'requirements' => 'nullable|string',
            'target_audience' => 'nullable|string',
            'material_includes' => 'nullable|string',
            'featured' => 'nullable|boolean',
            'popular' => 'nullable|boolean',
            'status' => 'required|in:draft,published,archived',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'video_intro' => 'nullable|mimetypes:video/mp4,video/webm|max:51200',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'seo_title' => 'nullable|max:255',
            'seo_description' => 'nullable|max:500',
            'seo_keywords' => 'nullable|max:500'
        ]);

        DB::beginTransaction();

        try {
            // Set is_free based on course_type
            $validated['is_free'] = $validated['course_type'] === 'free';

            // IMPORTANT FIX: Set price to null for free courses
            if ($validated['course_type'] === 'free') {
                $validated['price'] = null;
            }

            // Handle thumbnail upload
            if ($request->hasFile('thumbnail')) {
                // Delete old thumbnail
                if ($course->thumbnail) {
                    Storage::disk('public')->delete($course->thumbnail);
                }
                $path = $request->file('thumbnail')->store('courses/thumbnails', 'public');
                $validated['thumbnail'] = $path;
            }

            // Handle intro video upload
            if ($request->hasFile('video_intro')) {
                // Delete old video
                if ($course->video_intro) {
                    Storage::disk('public')->delete($course->video_intro);
                }
                $path = $request->file('video_intro')->store('courses/videos', 'public');
                $validated['video_intro'] = $path;
            }

            // Update course
            $course->update($validated);

            // Sync tags
            if ($request->has('tags')) {
                $course->tags()->sync($request->tags);
            } else {
                $course->tags()->sync([]);
            }

            DB::commit();

            if ($request->has('save_and_continue')) {
                return redirect()->route('admin.courses.edit', $course)
                    ->with('success', 'Course updated successfully.');
            }

            return redirect()->route('admin.courses.index')
                ->with('success', 'Course updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update course: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified course from storage.
     */
    public function destroy(Course $course)
    {
        DB::beginTransaction();

        try {
            // Delete related files
            if ($course->thumbnail) {
                Storage::disk('public')->delete($course->thumbnail);
            }
            if ($course->video_intro) {
                Storage::disk('public')->delete($course->video_intro);
            }

            // Delete course (cascade will handle sections and lessons)
            $course->delete();

            DB::commit();

            return redirect()->route('admin.courses.index')
                ->with('success', 'Course deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete course: ' . $e->getMessage());
        }
    }

    /**
     * Display lessons management page.
     */
    public function lessons(Course $course)
    {
        $course->load(['sections' => function ($q) {
            $q->orderBy('sort_order');
        }, 'sections.lessons' => function ($q) {
            $q->orderBy('sort_order');
        }]);

        return view('admin.courses.lessons', compact('course'));
    }

    /**
     * Store a newly created section.
     */
    public function storeSection(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable'
        ]);

        DB::beginTransaction();

        try {
            $validated['course_id'] = $course->id;
            $validated['sort_order'] = Section::where('course_id', $course->id)->count() + 1;

            $section = Section::create($validated);

            DB::commit();

            return redirect()->route('admin.courses.lessons', $course)
                ->with('success', 'Section created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create section: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified section.
     */
    public function updateSection(Request $request, Section $section)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable'
        ]);

        DB::beginTransaction();

        try {
            $section->update($validated);
            DB::commit();

            return redirect()->route('admin.courses.lessons', $section->course_id)
                ->with('success', 'Section updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update section: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified section.
     */
    public function destroySection(Section $section)
    {
        DB::beginTransaction();

        try {
            $courseId = $section->course_id;
            $section->delete();
            DB::commit();

            return redirect()->route('admin.courses.lessons', $courseId)
                ->with('success', 'Section deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete section: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created lesson.
     */
    public function storeLesson(Request $request, Course $course)
    {
        $validated = $request->validate([
            'section_id' => 'required|exists:sections,id',
            'title' => 'required|max:255',
            'description' => 'nullable',
            'content' => 'nullable',
            'video_url' => 'nullable|required_without:video_file|url',
            'video_file' => 'nullable|required_without:video_url|file|mimetypes:video/mp4,video/webm|max:512000',
            'video_type' => 'nullable|in:youtube,vimeo,local,external',
            'video_duration' => 'nullable|integer|min:0',
            'video_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'attachment' => 'nullable|file|max:10240',
            'is_preview' => 'nullable|boolean',
            'is_free' => 'nullable|boolean',
            'status' => 'required|in:draft,published'
        ]);

        DB::beginTransaction();

        try {
            $validated['course_id'] = $course->id;
            $validated['slug'] = Str::slug($validated['title']);

            if (!isset($validated['sort_order'])) {
                $validated['sort_order'] = Lesson::where('section_id', $validated['section_id'])->count() + 1;
            }

            // Handle video file upload
            if ($request->hasFile('video_file')) {
                $path = $request->file('video_file')->store('lessons/videos', 'public');
                $validated['video_url'] = $path;
                $validated['video_type'] = 'local';
            }

            // Handle video thumbnail upload
            if ($request->hasFile('video_thumbnail')) {
                $path = $request->file('video_thumbnail')->store('lessons/thumbnails', 'public');
                $validated['video_thumbnail'] = $path;
            }

            // Handle attachment upload
            if ($request->hasFile('attachment')) {
                $path = $request->file('attachment')->store('lessons/attachments', 'public');
                $validated['attachment'] = $path;
            }

            $lesson = Lesson::create($validated);

            // Update section stats
            $section = Section::find($validated['section_id']);
            $section->updateStats();

            DB::commit();

            return redirect()->route('admin.courses.lessons', $course)
                ->with('success', 'Lesson created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create lesson: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Update the specified lesson.
     */
    public function updateLesson(Request $request, Lesson $lesson)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'content' => 'nullable',
            'video_url' => 'nullable|url',
            'video_file' => 'nullable|file|mimetypes:video/mp4,video/webm|max:512000',
            'video_type' => 'nullable|in:youtube,vimeo,local,external',
            'video_duration' => 'nullable|integer|min:0',
            'video_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'attachment' => 'nullable|file|max:10240',
            'is_preview' => 'nullable|boolean',
            'is_free' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
            'status' => 'required|in:draft,published'
        ]);

        DB::beginTransaction();

        try {
            $validated['slug'] = Str::slug($validated['title']);

            // Handle video file upload
            if ($request->hasFile('video_file')) {
                // Delete old video
                if ($lesson->video_url && $lesson->video_type === 'local') {
                    Storage::disk('public')->delete($lesson->video_url);
                }
                $path = $request->file('video_file')->store('lessons/videos', 'public');
                $validated['video_url'] = $path;
                $validated['video_type'] = 'local';
            }

            // Handle video thumbnail upload
            if ($request->hasFile('video_thumbnail')) {
                // Delete old thumbnail
                if ($lesson->video_thumbnail) {
                    Storage::disk('public')->delete($lesson->video_thumbnail);
                }
                $path = $request->file('video_thumbnail')->store('lessons/thumbnails', 'public');
                $validated['video_thumbnail'] = $path;
            }

            // Handle attachment upload
            if ($request->hasFile('attachment')) {
                // Delete old attachment
                if ($lesson->attachment) {
                    Storage::disk('public')->delete($lesson->attachment);
                }
                $path = $request->file('attachment')->store('lessons/attachments', 'public');
                $validated['attachment'] = $path;
            }

            $oldSectionId = $lesson->section_id;
            $lesson->update($validated);

            // Update stats for old and new sections
            if ($oldSectionId != $lesson->section_id) {
                Section::find($oldSectionId)->updateStats();
            }
            Section::find($lesson->section_id)->updateStats();

            DB::commit();

            return redirect()->route('admin.courses.lessons', $lesson->course_id)
                ->with('success', 'Lesson updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update lesson: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified lesson.
     */
    public function destroyLesson(Lesson $lesson)
    {
        DB::beginTransaction();

        try {
            $courseId = $lesson->course_id;
            $sectionId = $lesson->section_id;

            $lesson->delete();

            // Update section stats
            Section::find($sectionId)->updateStats();

            DB::commit();

            return redirect()->route('admin.courses.lessons', $courseId)
                ->with('success', 'Lesson deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete lesson: ' . $e->getMessage());
        }
    }

    /**
     * Reorder sections.
     */
    public function reorderSections(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*.id' => 'required|exists:sections,id',
            'order.*.order' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();

        try {
            foreach ($request->order as $item) {
                Section::where('id', $item['id'])->update(['sort_order' => $item['order']]);
            }
            DB::commit();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Reorder lessons.
     */
    public function reorderLessons(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*.id' => 'required|exists:lessons,id',
            'order.*.order' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();

        try {
            foreach ($request->order as $item) {
                Lesson::where('id', $item['id'])->update(['sort_order' => $item['order']]);
            }
            DB::commit();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Clone a course.
     */
    public function clone(Course $course)
    {
        DB::beginTransaction();

        try {
            $newCourse = $course->replicate();
            $newCourse->title = $course->title . ' (Copy)';
            $newCourse->slug = Str::slug($newCourse->title);
            $newCourse->status = 'draft';
            $newCourse->created_by = auth()->id();
            $newCourse->total_students = 0;
            $newCourse->average_rating = 0;
            $newCourse->total_reviews = 0;
            $newCourse->save();

            // Clone tags
            $newCourse->tags()->sync($course->tags->pluck('id'));

            // Clone sections and lessons
            foreach ($course->sections as $section) {
                $newSection = $section->replicate();
                $newSection->course_id = $newCourse->id;
                $newSection->save();

                foreach ($section->lessons as $lesson) {
                    $newLesson = $lesson->replicate();
                    $newLesson->course_id = $newCourse->id;
                    $newLesson->section_id = $newSection->id;
                    $newLesson->save();
                }
            }

            DB::commit();

            return redirect()->route('admin.courses.edit', $newCourse)
                ->with('success', 'Course cloned successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to clone course: ' . $e->getMessage());
        }
    }

    /**
     * Get lesson data for editing (AJAX)
     */
    public function editLessonData(Lesson $lesson)
    {
        try {
            $lesson->load('section');

            return response()->json([
                'id' => $lesson->id,
                'section_id' => $lesson->section_id,
                'title' => $lesson->title,
                'description' => $lesson->description,
                'content' => $lesson->content,
                'video_type' => $lesson->video_type,
                'video_url' => $lesson->video_url,
                'video_duration' => $lesson->video_duration,
                'video_thumbnail' => $lesson->video_thumbnail,
                'attachment' => $lesson->attachment,
                'is_preview' => (bool)$lesson->is_preview,
                'is_free' => (bool)$lesson->is_free,
                'sort_order' => $lesson->sort_order,
                'status' => $lesson->status
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to load lesson data'], 500);
        }
    }
}
