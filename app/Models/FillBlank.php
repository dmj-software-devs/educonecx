<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FillBlank extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id', 'correct_answer', 'case_sensitive', 'sort_order'
    ];

    protected $casts = [
        'case_sensitive' => 'boolean',
        'sort_order' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relationships
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}