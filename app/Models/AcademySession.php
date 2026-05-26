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
        'heygen_session_id',
        'heygen_avatar_id',
        'heygen_voice_id',
        'heygen_context_id',
        'status',
        'score',
        'feedback',
        'transcript',
        'dynamic_instructions',
        'config_source',
        'raw_response',
        'started_at',
        'ended_at',
    ];

    protected $casts = [
        'config_source' => 'array',
        'raw_response' => 'array',
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
