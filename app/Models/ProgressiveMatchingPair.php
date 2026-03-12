<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProgressiveMatchingPair extends Model
{
    use HasFactory;

    protected $table = 'progressive_matching_pairs';

    protected $fillable = [
        'progressive_question_id',
        'left_item',
        'right_item',
        'sort_order'
    ];

    protected $casts = [
        'sort_order' => 'integer'
    ];

    public function question()
    {
        return $this->belongsTo(ProgressiveQuestion::class, 'progressive_question_id');
    }
}