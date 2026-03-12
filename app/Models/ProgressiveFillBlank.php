<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProgressiveFillBlank extends Model
{
    use HasFactory;

    protected $table = 'progressive_fill_blanks';

    protected $fillable = [
        'progressive_question_id',
        'correct_answer',
        'case_sensitive',
        'sort_order'
    ];

    protected $casts = [
        'case_sensitive' => 'boolean',
        'sort_order' => 'integer'
    ];

    public function question()
    {
        return $this->belongsTo(ProgressiveQuestion::class, 'progressive_question_id');
    }
}