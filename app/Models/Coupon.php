<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'description', 'discount_type', 'discount_value',
        'min_order_amount', 'max_discount_amount', 'usage_limit',
        'usage_per_user', 'total_used', 'start_date', 'end_date',
        'status', 'created_by'
    ];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'max_discount_amount' => 'decimal:2',
        'usage_limit' => 'integer',
        'usage_per_user' => 'integer',
        'total_used' => 'integer',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relationships
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_coupons');
    }

    // Scopes
    public function scopeActive($query)
    {
        $now = now();
        return $query->where('status', 'active')
            ->where(function($q) use ($now) {
                $q->whereNull('start_date')->orWhere('start_date', '<=', $now);
            })
            ->where(function($q) use ($now) {
                $q->whereNull('end_date')->orWhere('end_date', '>=', $now);
            });
    }

    // Accessors
    public function getIsValidAttribute()
    {
        $now = now();
        
        if ($this->status !== 'active') return false;
        if ($this->start_date && $now->lt($this->start_date)) return false;
        if ($this->end_date && $now->gt($this->end_date)) return false;
        if ($this->usage_limit && $this->total_used >= $this->usage_limit) return false;
        
        return true;
    }

    public function getDiscountTextAttribute()
    {
        if ($this->discount_type === 'percentage') {
            return $this->discount_value . '% off';
        } else {
            return '$' . number_format($this->discount_value, 2) . ' off';
        }
    }
}