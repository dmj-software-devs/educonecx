<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProgressiveQuestionOption extends Model
{
    use HasFactory;

    protected $table = 'progressive_question_options';

    protected $fillable = [
        'progressive_question_id',
        'option_text',
        'image',
        'is_correct',
        'sort_order'
    ];

    protected $casts = [
        'is_correct' => 'boolean',
        'sort_order' => 'integer'
    ];

    public function question()
    {
        return $this->belongsTo(ProgressiveQuestion::class, 'progressive_question_id');
    }

    public function answers()
    {
        return $this->hasMany(ProgressiveAnswer::class, 'progressive_question_option_id');
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }
}