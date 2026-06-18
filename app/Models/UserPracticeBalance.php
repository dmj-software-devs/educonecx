<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPracticeBalance extends Model
{
    protected $table = 'user_practice_sessions';

    protected $fillable = ['user_id','monthly_minutes_allocated','monthly_minutes_used','purchased_minutes','total_available_minutes','last_reset_at','monthly_reset_date'];
    protected $casts = ['last_reset_at' => 'datetime', 'monthly_reset_date' => 'datetime'];

    public function user() { return $this->belongsTo(User::class); }

    public function recalculateAvailableMinutes(): int
    {
        return max(0, ((int) $this->monthly_minutes_allocated - (int) $this->monthly_minutes_used) + (int) $this->purchased_minutes);
    }

    public function getComputedAvailableMinutesAttribute(): int
    {
        return $this->recalculateAvailableMinutes();
    }
}
