<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'section_id',
        'title',
        'slug',
        'description',
        'content',
        'video_url',
        'video_type',
        'video_duration',
        'video_thumbnail',
        'attachment',
        'is_preview',
        'is_free',
        'sort_order',
        'status'
    ];

    protected $casts = [
        'is_preview' => 'boolean',
        'is_free' => 'boolean',
        'video_duration' => 'integer',
        'sort_order' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    protected $appends = [
        'video_url_full',
        'attachment_url',
        'thumbnail_url',
        'duration_formatted',
        'is_completed',
        'progress'
    ];

    // Relationships
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function progress()
    {
        return $this->hasMany(LessonProgress::class);
    }

    public function userProgress()
    {
        return $this->hasOne(LessonProgress::class)->where('user_id', auth()->id());
    }

    // Accessors
    public function getVideoUrlFullAttribute()
    {
        if ($this->video_type === 'local' && $this->video_url) {
            return Storage::url($this->video_url);
        }
        return $this->video_url;
    }

    public function getAttachmentUrlAttribute()
    {
        return $this->attachment ? Storage::url($this->attachment) : null;
    }

    public function getThumbnailUrlAttribute()
    {
        if ($this->video_thumbnail) {
            return Storage::url($this->video_thumbnail);
        }
        return asset('images/lesson-placeholder.jpg');
    }

    public function getDurationFormattedAttribute()
    {
        if (!$this->video_duration) {
            return '00:00';
        }

        $hours = floor($this->video_duration / 3600);
        $minutes = floor(($this->video_duration % 3600) / 60);
        $seconds = $this->video_duration % 60;

        if ($hours > 0) {
            return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
        }
        return sprintf('%02d:%02d', $minutes, $seconds);
    }

    public function getIsCompletedAttribute()
    {
        if (!auth()->check()) return false;
        
        $progress = $this->progress()
            ->where('user_id', auth()->id())
            ->first();
            
        return $progress && $progress->status === 'completed';
    }

    public function getProgressAttribute()
    {
        if (!auth()->check()) return 0;
        
        $progress = $this->progress()
            ->where('user_id', auth()->id())
            ->first();
            
        return $progress ? $progress->progress : 0;
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopePreview($query)
    {
        return $query->where('is_preview', true);
    }

    public function scopeFree($query)
    {
        return $query->where('is_free', true);
    }

    // Methods
    public function markAsCompleted($userId = null)
    {
        $userId = $userId ?? auth()->id();
        if (!$userId) return false;

        $progress = LessonProgress::updateOrCreate(
            [
                'user_id' => $userId,
                'lesson_id' => $this->id,
                'course_id' => $this->course_id
            ],
            [
                'status' => 'completed',
                'progress' => 100,
                'completed_at' => now()
            ]
        );

        // Update course progress
        if ($this->course) {
            $totalLessons = $this->course->lessons()->count();
            $completedLessons = LessonProgress::where('user_id', $userId)
                ->where('course_id', $this->course_id)
                ->where('status', 'completed')
                ->count();

            $progress = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;

            Enrollment::where('user_id', $userId)
                ->where('course_id', $this->course_id)
                ->update([
                    'progress' => $progress,
                    'completed_at' => $progress >= 100 ? now() : null
                ]);
        }

        return $progress;
    }

    public function updateProgress($secondsWatched, $userId = null)
    {
        $userId = $userId ?? auth()->id();
        if (!$userId) return false;

        if (!$this->video_duration) return false;

        $progress = min(round(($secondsWatched / $this->video_duration) * 100), 100);
        
        $lessonProgress = LessonProgress::updateOrCreate(
            [
                'user_id' => $userId,
                'lesson_id' => $this->id,
                'course_id' => $this->course_id
            ],
            [
                'watched_seconds' => $secondsWatched,
                'last_position' => $secondsWatched,
                'progress' => $progress,
                'status' => $progress >= 90 ? 'completed' : 'in_progress',
                'completed_at' => $progress >= 90 ? now() : null
            ]
        );

        // Auto-mark as completed if watched 90%
        if ($progress >= 90 && $lessonProgress->status !== 'completed') {
            $this->markAsCompleted($userId);
        }

        return $lessonProgress;
    }

    // Boot method
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($lesson) {
            if (empty($lesson->slug)) {
                $lesson->slug = Str::slug($lesson->title);
            }
        });

        static::deleting(function ($lesson) {
            // Delete related files
            if ($lesson->video_url && $lesson->video_type === 'local') {
                Storage::disk('public')->delete($lesson->video_url);
            }
            if ($lesson->video_thumbnail) {
                Storage::disk('public')->delete($lesson->video_thumbnail);
            }
            if ($lesson->attachment) {
                Storage::disk('public')->delete($lesson->attachment);
            }
        });
    }
}