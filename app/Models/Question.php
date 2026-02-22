<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id', 'question_text', 'question_type', 'image', 'audio_file',
        'video_file', 'points', 'sort_order', 'explanation'
    ];

    protected $casts = [
        'points' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relationships
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function options()
    {
        return $this->hasMany(QuestionOption::class)->orderBy('sort_order');
    }

    public function fillBlanks()
    {
        return $this->hasMany(FillBlank::class)->orderBy('sort_order');
    }

    public function matchingPairs()
    {
        return $this->hasMany(MatchingPair::class)->orderBy('sort_order');
    }

    public function answers()
    {
        return $this->hasMany(QuizAnswer::class);
    }

    // Helper methods
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

    public function getCorrectAnswersTextAttribute()
    {
        switch ($this->question_type) {
            case 'multiple_choice':
            case 'single_choice':
            case 'true_false':
                return $this->correct_options->pluck('option_text')->implode(', ');
            
            case 'fill_blank':
                return $this->fillBlanks->pluck('correct_answer')->implode(', ');
            
            default:
                return 'See answer key';
        }
    }

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
                if (strtolower($blank->correct_answer) === strtolower($answer)) {
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
}