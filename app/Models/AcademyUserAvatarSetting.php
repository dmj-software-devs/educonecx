<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademyUserAvatarSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'heygen_avatar_id',
        'heygen_voice_id',
        'heygen_context_id',
        'preferred_language',
        'speaking_level',
        'tutor_style',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
