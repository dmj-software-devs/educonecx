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
        'lifetime_granted',
        'lifetime_purchased',
        'lifetime_used',
    ];

    protected $casts = [
        'balance' => 'integer',
        'lifetime_granted' => 'integer',
        'lifetime_purchased' => 'integer',
        'lifetime_used' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
