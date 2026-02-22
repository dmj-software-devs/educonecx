<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'course_id', 'enrollment_id', 'certificate_number',
        'issue_date', 'expiry_date', 'pdf_url'
    ];

    protected $casts = [
        'issue_date' => 'date',
        'expiry_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($certificate) {
            if (empty($certificate->certificate_number)) {
                $certificate->certificate_number = 'CERT-' . strtoupper(uniqid());
            }
        });
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    // Accessors
    public function getPdfUrlAttribute($value)
    {
        return $value ? asset('storage/' . $value) : null;
    }

    public function getIsExpiredAttribute()
    {
        return $this->expiry_date && now()->gt($this->expiry_date);
    }

    public function getIsValidAttribute()
    {
        return !$this->is_expired;
    }
}