<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProgressiveLevel extends Model
{
    use HasFactory;

    protected $table = 'progressive_levels';

    protected $fillable = [
        'progressive_quiz_id',
        'level_number',
        'title',
        'description',
        'question_count',
        'pass_required',
        'min_percentage',
        'time_limit',
        'unlock_message',
        'badge_icon',
        'sort_order'
    ];

    protected $casts = [
        'pass_required' => 'boolean',
        'level_number' => 'integer',
        'question_count' => 'integer',
        'min_percentage' => 'integer',
        'time_limit' => 'integer',
        'sort_order' => 'integer'
    ];

    // Relationships
    public function quiz()
    {
        return $this->belongsTo(ProgressiveQuiz::class, 'progressive_quiz_id');
    }

    public function questions()
    {
        return $this->hasMany(ProgressiveQuestion::class)->orderBy('sort_order');
    }

    public function levelAttempts()
    {
        return $this->hasMany(ProgressiveLevelAttempt::class);
    }

    // Helper Methods
    public function getBadgeIconUrlAttribute()
    {
        return $this->badge_icon ? asset('storage/' . $this->badge_icon) : null;
    }

    public function getTimeLimitAttribute($value)
    {
        return $value ?? $this->quiz->time_limit;
    }

    public function getMinPercentageAttribute($value)
    {
        return $value ?? $this->quiz->pass_percentage;
    }

    public function isUnlocked($userId = null)
    {
        $userId = $userId ?? auth()->id();
        if (!$userId) return false;

        if ($this->level_number == 1) return true;

        $previousLevel = $this->quiz->getLevelByNumber($this->level_number - 1);
        if (!$previousLevel) return false;

        $attempt = $this->quiz->getUserAttempt($userId);
        if (!$attempt) return false;

        $previousLevelAttempt = $attempt->levelAttempts()
            ->where('progressive_level_id', $previousLevel->id)
            ->first();

        return $previousLevelAttempt && $previousLevelAttempt->status === 'completed';
    }

    public function getUserAttempt($userId = null)
    {
        $userId = $userId ?? auth()->id();
        if (!$userId) return null;

        $quizAttempt = $this->quiz->getUserAttempt($userId);
        if (!$quizAttempt) return null;

        return $quizAttempt->levelAttempts()
            ->where('progressive_level_id', $this->id)
            ->first();
    }

    public function updateQuestionCount()
    {
        $this->question_count = $this->questions()->count();
        $this->save();
    }
}