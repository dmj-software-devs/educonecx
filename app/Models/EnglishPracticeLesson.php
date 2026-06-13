<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class EnglishPracticeLesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'english_practice_course_id',
        'english_practice_course_module_id',
        'title',
        'slug',
        'description',
        'video_type',
        'video_path',
        'video_url',
        'thumbnail',
        'duration_seconds',
        'sort_order',
        'is_free',
        'status',
    ];

    protected $casts = [
        'duration_seconds' => 'integer',
        'sort_order' => 'integer',
        'is_free' => 'boolean',
    ];

    public function course()
    {
        return $this->belongsTo(EnglishPracticeCourse::class, 'english_practice_course_id');
    }

    public function module()
    {
        return $this->belongsTo(EnglishPracticeCourseModule::class, 'english_practice_course_module_id');
    }

    public function progress()
    {
        return $this->hasMany(EnglishPracticeLessonProgress::class, 'english_practice_lesson_id');
    }

    public function userProgress()
    {
        return $this->hasOne(EnglishPracticeLessonProgress::class, 'english_practice_lesson_id')->where('user_id', auth()->id());
    }

    public function getVideoSourceUrlAttribute(): ?string
    {
        if ($this->video_type === 'upload' && $this->video_path) {
            return Storage::url($this->video_path);
        }

        return $this->video_url;
    }

    public function getThumbnailUrlAttribute(): string
    {
        return $this->thumbnail ? Storage::url($this->thumbnail) : asset('images/lesson-placeholder.jpg');
    }
}
