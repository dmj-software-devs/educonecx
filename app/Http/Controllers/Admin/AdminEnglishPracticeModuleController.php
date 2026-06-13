<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EnglishPracticeCourse;
use App\Models\EnglishPracticeCourseModule;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminEnglishPracticeModuleController extends Controller
{
    public function store(Request $request, EnglishPracticeCourse $course)
    {
        $course->modules()->create($this->validatedData($request));

        return redirect()->route('admin.english-practice-courses.edit', $course)
            ->with('success', 'Module added.');
    }

    public function update(Request $request, EnglishPracticeCourseModule $module)
    {
        $module->update($this->validatedData($request));

        return redirect()->route('admin.english-practice-courses.edit', $module->course)
            ->with('success', 'Module updated.');
    }

    public function destroy(EnglishPracticeCourseModule $module)
    {
        $course = $module->course;
        $module->lessons()->update(['english_practice_course_module_id' => null]);
        $module->delete();

        return redirect()->route('admin.english-practice-courses.edit', $course)
            ->with('success', 'Module deleted. Lessons were kept without a module.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', Rule::in(['draft', 'published'])],
        ]);
    }
}
