<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id', 'section_id', 'title', 'slug', 'description', 'content',
        'video_url', 'video_type', 'video_duration', 'attachment', 'is_preview',
        'is_free', 'sort_order', 'status'
    ];

    protected $casts = [
        'is_preview' => 'boolean',
        'is_free' => 'boolean',
        'video_duration' => 'integer',
        'sort_order' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($lesson) {
            if (empty($lesson->slug)) {
                $lesson->slug = Str::slug($lesson->title);
            }
        });
    }

    // Relationships
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function progress()
    {
        return $this->hasMany(LessonProgress::class);
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

    // Accessors
    public function getVideoUrlAttribute($value)
    {
        if ($this->video_type === 'local' && $value) {
            return asset('storage/' . $value);
        }
        return $value;
    }

    public function getAttachmentUrlAttribute()
    {
        return $this->attachment ? asset('storage/' . $this->attachment) : null;
    }

    public function getDurationFormattedAttribute()
    {
        $minutes = floor($this->video_duration / 60);
        $seconds = $this->video_duration % 60;
        
        if ($minutes > 0) {
            return $minutes . ':' . str_pad($seconds, 2, '0', STR_PAD_LEFT);
        }
        
        return $seconds . ' sec';
    }

    public function getUserProgressAttribute($userId = null)
    {
        $userId = $userId ?? auth()->id();
        if (!$userId) return null;
        
        return $this->progress()->where('user_id', $userId)->first();
    }

    public function getIsCompletedAttribute($userId = null)
    {
        $userId = $userId ?? auth()->id();
        if (!$userId) return false;
        
        $progress = $this->progress()->where('user_id', $userId)->first();
        return $progress && $progress->status === 'completed';
    }
}