<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProgressiveQuiz extends Model
{
    use HasFactory;

    protected $table = 'progressive_quizzes';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'featured_image',
        'total_questions',
        'total_levels',
        'time_limit',
        'attempts_allowed',
        'pass_percentage',
        'shuffle_questions',
        'show_results',
        'show_answers',
        'status',
        'created_by'
    ];

    protected $casts = [
        'shuffle_questions' => 'boolean',
        'show_results' => 'boolean',
        'show_answers' => 'boolean',
        'total_questions' => 'integer',
        'total_levels' => 'integer',
        'time_limit' => 'integer',
        'attempts_allowed' => 'integer',
        'pass_percentage' => 'integer'
    ];

    // Relationships
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function levels()
    {
        return $this->hasMany(ProgressiveLevel::class)->orderBy('level_number');
    }

    public function questions()
    {
        return $this->hasMany(ProgressiveQuestion::class);
    }

    public function attempts()
    {
        return $this->hasMany(ProgressiveQuizAttempt::class);
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    // Helper Methods
    public function updateCounts()
    {
        $this->total_levels = $this->levels()->count();
        $this->total_questions = $this->questions()->count();
        $this->save();
    }

    public function getUserAttempt($userId = null)
    {
        $userId = $userId ?? auth()->id();
        if (!$userId) return null;

        return $this->attempts()
            ->where('user_id', $userId)
            ->where('status', 'in_progress')
            ->latest()
            ->first();
    }

    public function getUserCompletedAttempts($userId = null)
    {
        $userId = $userId ?? auth()->id();
        if (!$userId) return 0;

        return $this->attempts()
            ->where('user_id', $userId)
            ->where('status', 'completed')
            ->count();
    }

    public function canAttempt($userId = null)
    {
        $userId = $userId ?? auth()->id();
        if (!$userId) return false;

        if ($this->attempts_allowed == 0) return true;

        $completedAttempts = $this->attempts()
            ->where('user_id', $userId)
            ->where('status', 'completed')
            ->count();

        return $completedAttempts < $this->attempts_allowed;
    }

    public function getFirstLevel()
    {
        return $this->levels()->orderBy('level_number')->first();
    }

    public function getLevelByNumber($levelNumber)
    {
        return $this->levels()->where('level_number', $levelNumber)->first();
    }

    public function getFeaturedImageUrlAttribute()
    {
        return $this->featured_image ? asset('storage/' . $this->featured_image) : null;
    }

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

    public function getProgressStats($userId = null)
    {
        $userId = $userId ?? auth()->id();
        if (!$userId) return null;

        $attempt = $this->getUserAttempt($userId);
        
        if (!$attempt) {
            return [
                'current_level' => 1,
                'levels_completed' => 0,
                'total_levels' => $this->total_levels,
                'percentage' => 0
            ];
        }

        $completedLevels = $attempt->levelAttempts()
            ->where('status', 'completed')
            ->count();

        return [
            'current_level' => $attempt->current_level_number,
            'levels_completed' => $completedLevels,
            'total_levels' => $this->total_levels,
            'percentage' => $this->total_levels > 0 ? round(($completedLevels / $this->total_levels) * 100) : 0
        ];
    }
}