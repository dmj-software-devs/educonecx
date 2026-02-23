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

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with(['category', 'instructor'])->latest()->paginate(15);
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.courses.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lte:price',
            'description' => 'required|min:50',
            'level' => 'nullable|in:beginner,intermediate,advanced',
            'featured' => 'nullable|boolean',
            'popular' => 'nullable|boolean',
            'status' => 'required|in:draft,published,archived'
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['created_by'] = auth()->id();

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('courses/thumbnails', 'public');
            $validated['thumbnail'] = $path;
        }

        if ($request->hasFile('video_intro')) {
            $path = $request->file('video_intro')->store('courses/videos', 'public');
            $validated['video_intro'] = $path;
        }

        $course = Course::create($validated);

        if ($request->has('tags')) {
            $course->tags()->sync($request->tags);
        }

        if ($request->has('save_and_continue')) {
            return redirect()->route('admin.courses.edit', $course)
                            ->with('success', 'Course created successfully. Continue editing.');
        }

        return redirect()->route('admin.courses.index')
                        ->with('success', 'Course created successfully');
    }

    public function show(Course $course)
    {
        // Load course with relationships for preview
        $course->load(['category', 'instructor', 'tags', 'sections.lessons']);
        return view('admin.courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        $categories = Category::all();
        $tags = Tag::all();
        $course->load('tags');
        return view('admin.courses.edit', compact('course', 'categories', 'tags'));
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lte:price',
            'description' => 'required|min:50',
            'level' => 'nullable|in:beginner,intermediate,advanced',
            'featured' => 'nullable|boolean',
            'popular' => 'nullable|boolean',
            'status' => 'required|in:draft,published,archived'
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('courses/thumbnails', 'public');
            $validated['thumbnail'] = $path;
        }

        if ($request->hasFile('video_intro')) {
            $path = $request->file('video_intro')->store('courses/videos', 'public');
            $validated['video_intro'] = $path;
        }

        $course->update($validated);

        if ($request->has('tags')) {
            $course->tags()->sync($request->tags);
        } else {
            $course->tags()->sync([]);
        }

        if ($request->has('save_and_continue')) {
            return redirect()->route('admin.courses.edit', $course)
                            ->with('success', 'Course updated successfully.');
        }

        return redirect()->route('admin.courses.index')
                        ->with('success', 'Course updated successfully');
    }

    public function destroy(Course $course)
    {
        // Delete associated files
        if ($course->thumbnail) {
            Storage::disk('public')->delete($course->thumbnail);
        }
        if ($course->video_intro) {
            Storage::disk('public')->delete($course->video_intro);
        }
        
        $course->delete();
        
        return redirect()->route('admin.courses.index')
                        ->with('success', 'Course deleted successfully');
    }

    public function lessons(Course $course)
    {
        $course->load('sections.lessons');
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

        $validated['course_id'] = $course->id;
        $validated['sort_order'] = Section::where('course_id', $course->id)->count() + 1;

        Section::create($validated);

        return redirect()->route('admin.courses.lessons', $course)
                        ->with('success', 'Section created successfully');
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

        $section->update($validated);

        return redirect()->route('admin.courses.lessons', $section->course_id)
                        ->with('success', 'Section updated successfully');
    }

    /**
     * Remove the specified section.
     */
    public function destroySection(Section $section)
    {
        $courseId = $section->course_id;
        $section->delete();

        return redirect()->route('admin.courses.lessons', $courseId)
                        ->with('success', 'Section deleted successfully');
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
            'video_url' => 'nullable|url',
            'video_type' => 'nullable|in:youtube,vimeo,local,external',
            'duration' => 'nullable|integer|min:0',
            'sort_order' => 'nullable|integer',
            'is_preview' => 'nullable|boolean',
            'is_free' => 'nullable|boolean'
        ]);

        $validated['course_id'] = $course->id;
        $validated['slug'] = Str::slug($validated['title']);
        
        if (!isset($validated['sort_order'])) {
            $validated['sort_order'] = Lesson::where('section_id', $validated['section_id'])->count() + 1;
        }

        Lesson::create($validated);

        return redirect()->route('admin.courses.lessons', $course)
                        ->with('success', 'Lesson created successfully');
    }

    /**
     * Update the specified lesson.
     */
    public function updateLesson(Request $request, Lesson $lesson)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'video_url' => 'nullable|url',
            'video_type' => 'nullable|in:youtube,vimeo,local,external',
            'duration' => 'nullable|integer|min:0',
            'sort_order' => 'nullable|integer',
            'is_preview' => 'nullable|boolean',
            'is_free' => 'nullable|boolean'
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        $lesson->update($validated);

        return redirect()->route('admin.courses.lessons', $lesson->course_id)
                        ->with('success', 'Lesson updated successfully');
    }

    /**
     * Remove the specified lesson.
     */
    public function destroyLesson(Lesson $lesson)
    {
        $courseId = $lesson->course_id;
        $lesson->delete();

        return redirect()->route('admin.courses.lessons', $courseId)
                        ->with('success', 'Lesson deleted successfully');
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

        foreach ($request->order as $item) {
            Section::where('id', $item['id'])->update(['sort_order' => $item['order']]);
        }

        return response()->json(['success' => true]);
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

        foreach ($request->order as $item) {
            Lesson::where('id', $item['id'])->update(['sort_order' => $item['order']]);
        }

        return response()->json(['success' => true]);
    }
}