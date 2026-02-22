<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MatchingPair extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id', 'left_item', 'right_item', 'sort_order'
    ];

    protected $casts = [
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