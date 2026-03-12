<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProgressiveQuestion extends Model
{
    use HasFactory;

    protected $table = 'progressive_questions';

    protected $fillable = [
        'progressive_quiz_id',
        'progressive_level_id',
        'question_text',
        'question_type',
        'points',
        'explanation',
        'image',
        'audio_file',
        'video_file',
        'sort_order'
    ];

    protected $casts = [
        'points' => 'integer',
        'sort_order' => 'integer'
    ];

    // Relationships
    public function quiz()
    {
        return $this->belongsTo(ProgressiveQuiz::class, 'progressive_quiz_id');
    }

    public function level()
    {
        return $this->belongsTo(ProgressiveLevel::class, 'progressive_level_id');
    }

    public function options()
    {
        return $this->hasMany(ProgressiveQuestionOption::class)->orderBy('sort_order');
    }

    public function fillBlanks()
    {
        return $this->hasMany(ProgressiveFillBlank::class)->orderBy('sort_order');
    }

    public function matchingPairs()
    {
        return $this->hasMany(ProgressiveMatchingPair::class)->orderBy('sort_order');
    }

    public function answers()
    {
        return $this->hasMany(ProgressiveAnswer::class);
    }

    // Accessors
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    public function getAudioUrlAttribute()
    {
        return $this->audio_file ? asset('storage/' . $this->audio_file) : null;
    }

    public function getVideoUrlAttribute()
    {
        return $this->video_file ? asset('storage/' . $this->video_file) : null;
    }

    public function getCorrectOptionsAttribute()
    {
        return $this->options()->where('is_correct', true)->get();
    }

    // Validation Methods
    public function validateAnswer($answer)
    {
        switch ($this->question_type) {
            case 'multiple_choice':
                return $this->validateMultipleChoice($answer);
            case 'single_choice':
            case 'true_false':
                return $this->validateSingleChoice($answer);
            case 'fill_blank':
                return $this->validateFillBlank($answer);
            case 'matching':
                return $this->validateMatching($answer);
            case 'image_selection':
                return $this->validateImageSelection($answer);
            default:
                return false;
        }
    }

    protected function validateMultipleChoice($selectedOptions)
    {
        $correctOptions = $this->options()->where('is_correct', true)->pluck('id')->toArray();

        if (!is_array($selectedOptions)) {
            return false;
        }

        $selected = array_map('intval', $selectedOptions);
        sort($selected);
        sort($correctOptions);

        return $selected == $correctOptions;
    }

    protected function validateSingleChoice($selectedOption)
    {
        $correctOption = $this->options()->where('is_correct', true)->first();
        return $correctOption && $correctOption->id == $selectedOption;
    }

    protected function validateFillBlank($answer)
    {
        $answer = trim($answer);
        $blanks = $this->fillBlanks;

        foreach ($blanks as $blank) {
            if ($blank->case_sensitive) {
                if ($blank->correct_answer === $answer) {
                    return true;
                }
            } else {
                if (strtolower(trim($blank->correct_answer)) === strtolower($answer)) {
                    return true;
                }
            }
        }

        return false;
    }

    protected function validateMatching($matches)
    {
        $pairs = $this->matchingPairs;
        $correct = true;

        foreach ($pairs as $pair) {
            $key = 'pair_' . $pair->id;
            if (!isset($matches[$key]) || $matches[$key] !== $pair->right_item) {
                $correct = false;
                break;
            }
        }

        return $correct;
    }

    protected function validateImageSelection($selectedOptions)
    {
        $correctOptions = $this->options()->where('is_correct', true)->pluck('id')->toArray();

        if (!is_array($selectedOptions)) {
            $selectedOptions = [$selectedOptions];
        }

        $selected = array_map('intval', $selectedOptions);
        sort($selected);
        sort($correctOptions);

        return $selected == $correctOptions;
    }
}