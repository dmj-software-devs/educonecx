<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademyScenario extends Model
{
    use HasFactory;

    protected $fillable = [
        'academy_category_id',
        'title',
        'slug',
        'level',
        'description',
        'practice_text',
        'avatar_instructions',
        'sample_questions',
        'video_url',
        'audio_url',
        'heygen_avatar_id',
        'heygen_voice_id',
        'heygen_context_id',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'sample_questions' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(AcademyCategory::class, 'academy_category_id');
    }

    public function sessions()
    {
        return $this->hasMany(AcademySession::class)->orderByDesc('created_at');
    }
}
