<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'description', 'course_id', 'section_id', 'lesson_id',
        'type', 'time_limit', 'attempts_allowed', 'pass_percentage',
        'shuffle_questions', 'show_results', 'show_answers', 'randomize_options',
        'status', 'created_by', 'total_questions', 'total_attempts', 'average_score'
    ];

    protected $casts = [
        'shuffle_questions' => 'boolean',
        'show_results' => 'boolean',
        'show_answers' => 'boolean',
        'randomize_options' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
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

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function questions()
    {
        return $this->hasMany(Question::class)->orderBy('sort_order');
    }

    public function attempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeStandalone($query)
    {
        return $query->where('type', 'standalone');
    }

    public function scopeCourseQuizzes($query)
    {
        return $query->where('type', 'course');
    }

    // Helper methods
    public function getTimeLimitFormattedAttribute()
    {
        if (!$this->time_limit) return 'No limit';
        
        $hours = floor($this->time_limit / 60);
        $minutes = $this->time_limit % 60;
        
        if ($hours > 0) {
            return $hours . ' hour' . ($hours > 1 ? 's' : '') . ($minutes > 0 ? ' ' . $minutes . ' min' : '');
        }
        
        return $minutes . ' minute' . ($minutes > 1 ? 's' : '');
    }

    public function getUserAttemptsAttribute($userId = null)
    {
        $userId = $userId ?? auth()->id();
        if (!$userId) return 0;
        
        return $this->attempts()->where('user_id', $userId)->count();
    }

    public function getUserBestScoreAttribute($userId = null)
    {
        $userId = $userId ?? auth()->id();
        if (!$userId) return 0;
        
        return $this->attempts()
                    ->where('user_id', $userId)
                    ->where('status', 'completed')
                    ->max('score') ?? 0;
    }

    public function getUserLastAttemptAttribute($userId = null)
    {
        $userId = $userId ?? auth()->id();
        if (!$userId) return null;
        
        return $this->attempts()
                    ->where('user_id', $userId)
                    ->latest()
                    ->first();
    }

    public function getCanAttemptAttribute($userId = null)
    {
        $userId = $userId ?? auth()->id();
        if (!$userId) return false;
        
        if ($this->attempts_allowed == 0) return true;
        
        $attemptCount = $this->attempts()
                             ->where('user_id', $userId)
                             ->where('status', 'completed')
                             ->count();
        
        return $attemptCount < $this->attempts_allowed;
    }
}