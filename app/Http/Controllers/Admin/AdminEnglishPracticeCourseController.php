<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EnglishPracticeCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminEnglishPracticeCourseController extends Controller
{
    public function index()
    {
        $courses = EnglishPracticeCourse::withCount('lessons')
            ->orderBy('sort_order')
            ->latest()
            ->paginate(20);

        return view('admin.english-practice-courses.index', compact('courses'));
    }

    public function create()
    {
        return view('admin.english-practice-courses.create', ['course' => new EnglishPracticeCourse()]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedCourseData($request);
        $data['slug'] = $this->uniqueSlug($data['title']);
        $data['created_by'] = $request->user()->id;

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('english-practice/thumbnails', 'public');
        }

        $course = EnglishPracticeCourse::create($data);

        return redirect()->route('admin.english-practice-courses.edit', $course)
            ->with('success', 'English practice course created. Add modules and lessons next.');
    }

    public function edit(EnglishPracticeCourse $englishPracticeCourse)
    {
        $course = $englishPracticeCourse->load(['modules.lessons', 'lessons.module']);

        return view('admin.english-practice-courses.edit', compact('course'));
    }

    public function update(Request $request, EnglishPracticeCourse $englishPracticeCourse)
    {
        $data = $this->validatedCourseData($request, $englishPracticeCourse);
        $data['slug'] = $this->uniqueSlug($data['title'], $englishPracticeCourse->id);

        if ($request->hasFile('thumbnail')) {
            if ($englishPracticeCourse->thumbnail) {
                Storage::disk('public')->delete($englishPracticeCourse->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('english-practice/thumbnails', 'public');
        }

        $englishPracticeCourse->update($data);

        return redirect()->route('admin.english-practice-courses.edit', $englishPracticeCourse)
            ->with('success', 'English practice course updated.');
    }

    public function destroy(EnglishPracticeCourse $englishPracticeCourse)
    {
        $englishPracticeCourse->delete();

        return redirect()->route('admin.english-practice-courses.index')
            ->with('success', 'English practice course deleted.');
    }

    public function reorderLessons(Request $request, EnglishPracticeCourse $course)
    {
        foreach ($request->input('lessons', []) as $position => $lessonId) {
            $course->lessons()->whereKey($lessonId)->update(['sort_order' => $position + 1]);
        }

        return response()->json(['success' => true]);
    }

    public function reorderModules(Request $request, EnglishPracticeCourse $course)
    {
        foreach ($request->input('modules', []) as $position => $moduleId) {
            $course->modules()->whereKey($moduleId)->update(['sort_order' => $position + 1]);
        }

        return response()->json(['success' => true]);
    }

    private function validatedCourseData(Request $request, ?EnglishPracticeCourse $course = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'level' => ['nullable', 'string', 'max:80'],
            'thumbnail' => ['nullable', 'image', 'max:5120'],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: Str::random(8);
        $slug = $base;
        $counter = 2;

        while (EnglishPracticeCourse::where('slug', $slug)->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))->exists()) {
            $slug = $base . '-' . $counter++;
        }

        return $slug;
    }
}
