<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'course_id', 'order_id', 'enrollment_date', 'expiry_date',
        'status', 'progress', 'completed_at', 'certificate_generated',
        'certificate_url', 'last_accessed'
    ];

    protected $casts = [
        'enrollment_date' => 'datetime',
        'expiry_date' => 'datetime',
        'completed_at' => 'datetime',
        'last_accessed' => 'datetime',
        'progress' => 'integer',
        'certificate_generated' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function certificate()
    {
        return $this->hasOne(Certificate::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCompleted($query)
    {
        return $query->whereNotNull('completed_at');
    }

    public function scopeInProgress($query)
    {
        return $query->whereNull('completed_at')->where('status', 'active');
    }

    // Accessors
    public function getIsCompletedAttribute()
    {
        return !is_null($this->completed_at);
    }

    public function getIsExpiredAttribute()
    {
        return $this->expiry_date && now()->gt($this->expiry_date);
    }

    public function getRemainingDaysAttribute()
    {
        if (!$this->expiry_date) return null;
        
        $days = now()->diffInDays($this->expiry_date, false);
        return $days > 0 ? $days : 0;
    }
}