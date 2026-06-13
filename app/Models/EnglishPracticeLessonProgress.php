<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnglishPracticeLessonProgress extends Model
{
    use HasFactory;

    protected $table = 'english_practice_lesson_progress';

    protected $fillable = [
        'user_id',
        'english_practice_lesson_id',
        'watched_seconds',
        'duration_seconds',
        'progress_percent',
        'is_completed',
        'completed_at',
        'last_watched_at',
    ];

    protected $casts = [
        'watched_seconds' => 'integer',
        'duration_seconds' => 'integer',
        'progress_percent' => 'decimal:2',
        'is_completed' => 'boolean',
        'completed_at' => 'datetime',
        'last_watched_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lesson()
    {
        return $this->belongsTo(EnglishPracticeLesson::class, 'english_practice_lesson_id');
    }
}
