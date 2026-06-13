<?php

namespace App\Http\Controllers;

use App\Models\EnglishPracticeCourse;
use App\Models\EnglishPracticeLesson;
use App\Services\PracticeCreditService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EnglishPracticeCourseController extends Controller
{
    public function show(Request $request, EnglishPracticeCourse $course, PracticeCreditService $creditService): View
    {
        abort_unless($request->user()?->canAccessPracticeRoom() || $request->user()?->isAdmin(), 403);
        $creditService->grantSignupCredits($request->user());

        abort_unless($course->status === 'published', 404);

        $course->load([
            'modules' => fn ($query) => $query->where('status', 'published')->orderBy('sort_order'),
            'modules.lessons' => fn ($query) => $query->where('status', 'published')->orderBy('sort_order'),
            'lessons' => fn ($query) => $query->where('status', 'published')->orderBy('sort_order'),
            'lessons.module',
            'lessons.userProgress',
        ]);

        $lessons = $course->lessons;
        abort_if($lessons->isEmpty(), 404, 'This course does not have published lessons yet.');

        $selectedLesson = $request->filled('lesson')
            ? $lessons->firstWhere('id', (int) $request->query('lesson'))
            : null;
        $selectedLesson ??= $lessons->first(fn ($lesson) => ! optional($lesson->userProgress)->is_completed) ?: $lessons->first();
        $selectedLesson->load('userProgress');

        $nextLesson = $lessons->skipUntil(fn ($lesson) => $lesson->id === $selectedLesson->id)->skip(1)->first();
        $completedCount = $lessons->filter(fn ($lesson) => optional($lesson->userProgress)->is_completed)->count();
        $progressPercent = $lessons->count() > 0 ? round(($completedCount / $lessons->count()) * 100) : 0;

        return view('educonecx-academy.course-show', compact(
            'course',
            'lessons',
            'selectedLesson',
            'nextLesson',
            'completedCount',
            'progressPercent'
        ));
    }
}
