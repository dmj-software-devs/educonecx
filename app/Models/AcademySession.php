<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademySession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'academy_category_id',
        'academy_scenario_id',
        'session_type',
        'heygen_session_id',
        'liveavatar_embed_id',
        'liveavatar_embed_url',
        'heygen_avatar_id',
        'heygen_voice_id',
        'heygen_context_id',
        'avatar_name',
        'avatar_image_url',
        'context_name',
        'status',
        'score',
        'credits_used',
        'duration_seconds',
        'evaluation_used',
        'recording_used',
        'attempt_locked',
        'feedback',
        'transcript',
        'audio_path',
        'grammar_score',
        'fluency_score',
        'vocabulary_score',
        'pronunciation_score',
        'overall_score',
        'corrections',
        'strengths',
        'weaknesses',
        'next_steps',
        'ai_evaluation',
        'evaluated_at',
        'dynamic_instructions',
        'config_source',
        'raw_response',
        'started_at',
        'ended_at',
    ];

    protected $casts = [
        'config_source' => 'array',
        'raw_response' => 'array',
        'evaluation_used' => 'boolean',
        'recording_used' => 'boolean',
        'attempt_locked' => 'boolean',
        'corrections' => 'array',
        'strengths' => 'array',
        'weaknesses' => 'array',
        'next_steps' => 'array',
        'ai_evaluation' => 'array',
        'evaluated_at' => 'datetime',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    public function scenario()
    {
        return $this->belongsTo(AcademyScenario::class, 'academy_scenario_id');
    }

    public function category()
    {
        return $this->belongsTo(AcademyCategory::class, 'academy_category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
