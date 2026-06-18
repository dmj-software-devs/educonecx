<?php

namespace App\Http\Controllers;

use App\Models\EnglishPracticeLesson;
use App\Models\EnglishPracticeLessonProgress;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EnglishPracticeProgressController extends Controller
{
    public function update(Request $request, EnglishPracticeLesson $lesson): JsonResponse
    {
        abort_unless($lesson->status === 'published' && $lesson->course?->status === 'published', 404);

        $data = $request->validate([
            'watched_seconds' => ['required', 'integer', 'min:0'],
            'duration_seconds' => ['nullable', 'integer', 'min:0'],
            'is_completed' => ['nullable', 'boolean'],
        ]);

        $duration = $data['duration_seconds'] ?: $lesson->duration_seconds;
        $watched = $data['watched_seconds'];
        $percent = $duration > 0 ? min(100, round(($watched / $duration) * 100, 2)) : 0;
        $isCompleted = $request->boolean('is_completed') || $percent > 90;

        $progress = EnglishPracticeLessonProgress::firstOrNew([
            'user_id' => $request->user()->id,
            'english_practice_lesson_id' => $lesson->id,
        ]);

        $progress->watched_seconds = $watched;
        $progress->duration_seconds = $duration;
        $progress->progress_percent = $isCompleted ? 100 : $percent;
        $progress->is_completed = $isCompleted;
        $progress->completed_at = $isCompleted ? ($progress->completed_at ?: now()) : $progress->completed_at;
        $progress->last_watched_at = now();
        $progress->save();

        return response()->json([
            'success' => true,
            'progress_percent' => (float) $progress->progress_percent,
            'is_completed' => (bool) $progress->is_completed,
        ]);
    }
}
