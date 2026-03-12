<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProgressiveAnswer extends Model
{
    use HasFactory;

    protected $table = 'progressive_answers';

    protected $fillable = [
        'progressive_level_attempt_id',
        'progressive_question_id',
        'progressive_question_option_id',
        'answer_text',
        'is_correct',
        'points_earned',
        'time_spent'
    ];

    protected $casts = [
        'is_correct' => 'boolean',
        'points_earned' => 'integer',
        'time_spent' => 'integer'
    ];

    // Relationships
    public function levelAttempt()
    {
        return $this->belongsTo(ProgressiveLevelAttempt::class, 'progressive_level_attempt_id');
    }

    public function question()
    {
        return $this->belongsTo(ProgressiveQuestion::class, 'progressive_question_id');
    }

    public function selectedOption()
    {
        return $this->belongsTo(ProgressiveQuestionOption::class, 'progressive_question_option_id');
    }
}