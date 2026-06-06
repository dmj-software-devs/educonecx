<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPracticeCredit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'balance',
        'lifetime_used',
        'lifetime_granted',
    ];

    protected $casts = [
        'balance' => 'integer',
        'lifetime_used' => 'integer',
        'lifetime_granted' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
