<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PracticeUsageLog extends Model
{
    protected $table = 'avatar_usage_logs';

    protected $fillable = ['user_id','academy_session_id','session_type','started_at','ended_at','minutes_used','credits_consumed','source'];
    protected $casts = ['started_at' => 'datetime', 'ended_at' => 'datetime'];

    public function user() { return $this->belongsTo(User::class); }
    public function session() { return $this->belongsTo(AcademySession::class, 'academy_session_id'); }
}
