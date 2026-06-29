<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecimenRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id','request_number','pickup_address','delivery_address','specimen_type','status','quoted_amount','payment_status','paid_at','completed_at','recipient_name','delivery_notes','signature','notes'
    ];

    protected $casts = [
        'quoted_amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function payments()
    {
        return $this->hasMany(Order::class, 'specimen_request_id');
    }

    public function latestPayment()
    {
        return $this->hasOne(Order::class, 'specimen_request_id')->latestOfMany();
    }

    public function isPaid(): bool
    {
        return $this->payment_status === 'paid' || $this->payments()->where('payment_status', 'paid')->exists();
    }

    public function canClientPay(): bool
    {
        return in_array($this->status, ['in_transit', 'delivered'], true) && ! $this->isPaid();
    }
}
