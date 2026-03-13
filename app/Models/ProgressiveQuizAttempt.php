<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProgressiveQuizAttempt extends Model
{
    use HasFactory;

    protected $table = 'progressive_quiz_attempts';

    protected $fillable = [
        'progressive_quiz_id',
        'user_id',
        'attempt_number',
        'current_level_id',
        'current_level_number',
        'status',
        'started_at',
        'completed_at',
        'overall_score',
        'overall_percentage',
        'passed',
        'time_taken'
    ];

    protected $casts = [
        'attempt_number' => 'integer',
        'current_level_number' => 'integer',
        'overall_score' => 'integer',
        'overall_percentage' => 'decimal:2',
        'passed' => 'boolean',
        'time_taken' => 'integer',
        'started_at' => 'datetime',
        'completed_at' => 'datetime'
    ];

    // Relationships
    public function quiz()
    {
        return $this->belongsTo(ProgressiveQuiz::class, 'progressive_quiz_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function currentLevel()
    {
        return $this->belongsTo(ProgressiveLevel::class, 'current_level_id');
    }

    public function levelAttempts()
    {
        return $this->hasMany(ProgressiveLevelAttempt::class);
    }

    // Scopes
    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // Helper Methods
    public function getCurrentLevel()
    {
        if ($this->current_level_id) {
            return ProgressiveLevel::find($this->current_level_id);
        }
        
        return $this->quiz->getLevelByNumber($this->current_level_number);
    }

    public function getLevelAttempt($levelId)
    {
        return $this->levelAttempts()
            ->where('progressive_level_id', $levelId)
            ->first();
    }

    public function getCurrentLevelAttempt()
    {
        return $this->levelAttempts()
            ->where('progressive_level_id', $this->current_level_id)
            ->first();
    }

    public function hasCompletedLevel($levelNumber)
    {
        $level = $this->quiz->getLevelByNumber($levelNumber);
        if (!$level) return false;

        $attempt = $this->getLevelAttempt($level->id);
        return $attempt && $attempt->status === ProgressiveLevelAttempt::STATUS_COMPLETED;
    }

    public function getNextLevel()
    {
        $nextLevelNumber = $this->current_level_number + 1;
        return $this->quiz->getLevelByNumber($nextLevelNumber);
    }

    public function canProceedToNextLevel()
    {
        $currentLevelAttempt = $this->getCurrentLevelAttempt();
        
        if (!$currentLevelAttempt) {
            return true; // Haven't started current level yet
        }

        if ($currentLevelAttempt->status === ProgressiveLevelAttempt::STATUS_COMPLETED) {
            $nextLevel = $this->getNextLevel();
            return $nextLevel !== null;
        }

        return false;
    }

    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    public function getProgressPercentage()
    {
        $totalLevels = $this->quiz->total_levels;
        if ($totalLevels == 0) return 0;

        $completedLevels = $this->levelAttempts()
            ->where('status', ProgressiveLevelAttempt::STATUS_COMPLETED)
            ->count();

        return round(($completedLevels / $totalLevels) * 100);
    }

    public function getTimeTakenFormattedAttribute()
    {
        if (!$this->time_taken) return 'N/A';
        
        $hours = floor($this->time_taken / 3600);
        $minutes = floor(($this->time_taken % 3600) / 60);
        $seconds = $this->time_taken % 60;
        
        if ($hours > 0) {
            return sprintf('%d:%02d:%02d', $hours, $minutes, $seconds);
        }
        
        return sprintf('%d:%02d', $minutes, $seconds);
    }
}