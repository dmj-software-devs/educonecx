<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LessonProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'course_id', 
        'lesson_id', 
        'status', 
        'progress',
        'watched_seconds',
        'last_position',
        'completed_at', 
        'last_accessed'
    ];

    protected $casts = [
        'progress' => 'integer',
        'watched_seconds' => 'integer',
        'last_position' => 'integer',
        'completed_at' => 'datetime',
        'last_accessed' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    // Scopes
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeNotStarted($query)
    {
        return $query->where('status', 'not_started');
    }

    // Accessors
    public function getIsCompletedAttribute()
    {
        return $this->status === 'completed';
    }

    public function getProgressPercentageAttribute()
    {
        return $this->progress . '%';
    }

    // Methods
    public function markAsCompleted()
    {
        $this->update([
            'status' => 'completed',
            'progress' => 100,
            'completed_at' => now()
        ]);
    }
}