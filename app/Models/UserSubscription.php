<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserSubscription extends Model
{
    use HasFactory;

    protected $table = 'user_subscriptions';

    protected $fillable = [
        'user_id',
        'plan_id',
        'order_id',
        'start_date',
        'end_date',
        'status',
        'payment_status',
        'auto_renew'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'auto_renew' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    protected $appends = [
        'is_active',
        'is_expired',
        'days_remaining',
        'progress_percentage'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'plan_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Accessors
    public function getIsActiveAttribute()
    {
        return $this->status === 'active' && $this->end_date > now();
    }

    public function getIsExpiredAttribute()
    {
        return $this->end_date <= now();
    }

    public function getDaysRemainingAttribute()
    {
        if ($this->end_date <= now()) {
            return 0;
        }
        return now()->diffInDays($this->end_date);
    }

    public function getProgressPercentageAttribute()
    {
        $total = $this->start_date->diffInDays($this->end_date);
        $elapsed = $this->start_date->diffInDays(now());
        
        if ($total <= 0) return 100;
        
        $percentage = round(($elapsed / $total) * 100);
        return min($percentage, 100);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where('end_date', '>', now());
    }

    public function scopeExpired($query)
    {
        return $query->where('end_date', '<=', now());
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Methods
    public function activate()
    {
        $this->update([
            'status' => 'active',
            'payment_status' => 'paid'
        ]);
        
        // Auto-enroll user in all paid courses
        $this->user->enrollInAllPaidCourses($this->id);
    }

    public function expire()
    {
        $this->update([
            'status' => 'expired'
        ]);
        
        // Expire all subscription-based enrollments
        Enrollment::where('user_id', $this->user_id)
            ->where('access_type', 'subscription')
            ->update([
                'status' => 'expired',
                'expiry_date' => now()
            ]);
    }

    public function cancel()
    {
        $this->update([
            'status' => 'cancelled',
            'auto_renew' => false
        ]);
    }

    public function renew()
    {
        if ($this->plan) {
            $newEndDate = $this->end_date->copy()->addDays($this->plan->duration_days);
            
            $this->update([
                'end_date' => $newEndDate,
                'status' => 'active'
            ]);
            
            // Reactivate all subscription enrollments
            Enrollment::where('user_id', $this->user_id)
                ->where('access_type', 'subscription')
                ->update([
                    'status' => 'active',
                    'expiry_date' => $newEndDate
                ]);
        }
    }

    public function hasAccessToCourse($courseId)
    {
        if (!$this->is_active) {
            return false;
        }
        
        $course = Course::find($courseId);
        if (!$course) {
            return false;
        }
        
        // User can access all paid courses with active subscription
        return !$course->is_free;
    }
}