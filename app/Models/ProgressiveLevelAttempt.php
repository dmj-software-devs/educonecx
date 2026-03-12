<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProgressiveLevelAttempt extends Model
{
    use HasFactory;

    protected $table = 'progressive_level_attempts';

    protected $fillable = [
        'progressive_quiz_attempt_id',
        'progressive_level_id',
        'level_number',
        'status',
        'score',
        'percentage',
        'passed',
        'time_taken',
        'started_at',
        'completed_at'
    ];

    protected $casts = [
        'level_number' => 'integer',
        'score' => 'integer',
        'percentage' => 'decimal:2',
        'passed' => 'boolean',
        'time_taken' => 'integer',
        'started_at' => 'datetime',
        'completed_at' => 'datetime'
    ];

    // Status constants
    const STATUS_LOCKED = 'locked';
    const STATUS_AVAILABLE = 'available';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED = 'failed';

    // Relationships
    public function quizAttempt()
    {
        return $this->belongsTo(ProgressiveQuizAttempt::class, 'progressive_quiz_attempt_id');
    }

    public function level()
    {
        return $this->belongsTo(ProgressiveLevel::class, 'progressive_level_id');
    }

    public function answers()
    {
        return $this->hasMany(ProgressiveAnswer::class);
    }

    // Helper Methods
    public function start()
    {
        $this->status = self::STATUS_IN_PROGRESS;
        $this->started_at = now();
        $this->save();
    }

    public function complete($score, $passed)
    {
        $this->status = self::STATUS_COMPLETED;
        $this->score = $score;
        $this->percentage = $this->level->questions->sum('points') > 0 
            ? round(($score / $this->level->questions->sum('points')) * 100, 2) 
            : 0;
        $this->passed = $passed;
        $this->completed_at = now();
        
        if ($this->started_at) {
            $this->time_taken = now()->diffInSeconds($this->started_at);
        }
        
        $this->save();
    }

    public function fail()
    {
        $this->status = self::STATUS_FAILED;
        $this->completed_at = now();
        
        if ($this->started_at) {
            $this->time_taken = now()->diffInSeconds($this->started_at);
        }
        
        $this->save();
    }

    public function isCompleted()
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function isInProgress()
    {
        return $this->status === self::STATUS_IN_PROGRESS;
    }

    public function isAvailable()
    {
        return $this->status === self::STATUS_AVAILABLE;
    }

    public function getTimeTakenFormattedAttribute()
    {
        if (!$this->time_taken) return 'N/A';
        
        $minutes = floor($this->time_taken / 60);
        $seconds = $this->time_taken % 60;
        
        if ($minutes > 0) {
            return $minutes . ':' . str_pad($seconds, 2, '0', STR_PAD_LEFT);
        }
        
        return $seconds . ' seconds';
    }

    public function getQuestions()
    {
        return $this->level->questions()->orderBy('sort_order')->get();
    }

    public function getUnansweredQuestions()
    {
        $answeredQuestionIds = $this->answers()->pluck('progressive_question_id')->toArray();
        
        return $this->level->questions()
            ->whereNotIn('id', $answeredQuestionIds)
            ->orderBy('sort_order')
            ->get();
    }

    public function getAnswerForQuestion($questionId)
    {
        return $this->answers()
            ->where('progressive_question_id', $questionId)
            ->first();
    }
}