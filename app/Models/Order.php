<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'order_number', 'subtotal', 'discount_amount', 'coupon_code',
        'total', 'payment_method', 'payment_status', 'transaction_id',
        'billing_name', 'billing_email', 'billing_phone', 'billing_address',
        'billing_city', 'billing_state', 'billing_country', 'billing_postal', 'notes'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = 'ORD-' . strtoupper(uniqid());
            }
        });
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    // Scopes
    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    public function scopePending($query)
    {
        return $query->where('payment_status', 'pending');
    }

    public function scopeFailed($query)
    {
        return $query->where('payment_status', 'failed');
    }

    // Accessors
    public function getStatusColorAttribute()
    {
        return [
            'pending' => 'warning',
            'paid' => 'success',
            'failed' => 'danger',
            'refunded' => 'info'
        ][$this->payment_status] ?? 'secondary';
    }

    public function getStatusBadgeAttribute()
    {
        return '<span class="badge badge-' . $this->status_color . '">' . ucfirst($this->payment_status) . '</span>';
    }
}