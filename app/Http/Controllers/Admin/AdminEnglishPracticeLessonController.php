<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EnglishPracticeCourse;
use App\Models\EnglishPracticeLesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminEnglishPracticeLessonController extends Controller
{
    public function create(EnglishPracticeCourse $course)
    {
        $course->load('modules');
        $lesson = new EnglishPracticeLesson(['status' => 'published', 'video_type' => 'upload']);

        return view('admin.english-practice-lessons.create', compact('course', 'lesson'));
    }

    public function store(Request $request, EnglishPracticeCourse $course)
    {
        $data = $this->validatedLessonData($request, $course);
        $data['slug'] = $this->uniqueSlug($course, $data['title']);

        $this->handleUploads($request, $data);
        $course->lessons()->create($data);

        return redirect()->route('admin.english-practice-courses.edit', $course)
            ->with('success', 'Lesson added.');
    }

    public function edit(EnglishPracticeLesson $lesson)
    {
        $lesson->load('course.modules');
        $course = $lesson->course;

        return view('admin.english-practice-lessons.edit', compact('lesson', 'course'));
    }

    public function update(Request $request, EnglishPracticeLesson $lesson)
    {
        $course = $lesson->course;
        $data = $this->validatedLessonData($request, $course);
        $data['slug'] = $this->uniqueSlug($course, $data['title'], $lesson->id);

        $this->handleUploads($request, $data, $lesson);
        $lesson->update($data);

        return redirect()->route('admin.english-practice-courses.edit', $course)
            ->with('success', 'Lesson updated.');
    }

    public function destroy(EnglishPracticeLesson $lesson)
    {
        $course = $lesson->course;
        if ($lesson->video_path) {
            Storage::disk('public')->delete($lesson->video_path);
        }
        if ($lesson->thumbnail) {
            Storage::disk('public')->delete($lesson->thumbnail);
        }
        $lesson->delete();

        return redirect()->route('admin.english-practice-courses.edit', $course)
            ->with('success', 'Lesson deleted.');
    }

    private function validatedLessonData(Request $request, EnglishPracticeCourse $course): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'english_practice_course_module_id' => ['nullable', Rule::exists('english_practice_course_modules', 'id')->where('english_practice_course_id', $course->id)],
            'video_type' => ['required', Rule::in(['upload', 'url', 'youtube', 'vimeo'])],
            'video_file' => ['nullable', 'file', 'mimes:mp4,webm,mov', 'max:307200'],
            'video_url' => ['nullable', 'url', 'max:2048'],
            'thumbnail' => ['nullable', 'image', 'max:5120'],
            'duration_seconds' => ['nullable', 'integer', 'min:0'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_free' => ['nullable', 'boolean'],
            'status' => ['required', Rule::in(['draft', 'published'])],
        ]);
    }

    private function handleUploads(Request $request, array &$data, ?EnglishPracticeLesson $lesson = null): void
    {
        $data['is_free'] = $request->boolean('is_free');

        if ($request->hasFile('video_file')) {
            if ($lesson?->video_path) {
                Storage::disk('public')->delete($lesson->video_path);
            }
            $data['video_path'] = $request->file('video_file')->store('english-practice/videos', 'public');
        }

        if ($request->hasFile('thumbnail')) {
            if ($lesson?->thumbnail) {
                Storage::disk('public')->delete($lesson->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('english-practice/thumbnails', 'public');
        }
    }

    private function uniqueSlug(EnglishPracticeCourse $course, string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: Str::random(8);
        $slug = $base;
        $counter = 2;

        while ($course->lessons()->where('slug', $slug)->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))->exists()) {
            $slug = $base . '-' . $counter++;
        }

        return $slug;
    }
}
