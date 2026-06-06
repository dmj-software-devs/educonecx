<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PracticeCreditTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'academy_session_id',
        'type',
        'amount',
        'balance_after',
        'description',
        'meta',
    ];

    protected $casts = [
        'amount' => 'integer',
        'balance_after' => 'integer',
        'meta' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function academySession()
    {
        return $this->belongsTo(AcademySession::class);
    }
}
