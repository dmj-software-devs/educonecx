<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $table = 'subscription_plans';

    protected $fillable = [
        'name',
        'description',
        'price',
        'duration_days',
        'features',
        'is_popular',
        'status',
        'sort_order'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'duration_days' => 'integer',
        'features' => 'array',
        'is_popular' => 'boolean',
        'sort_order' => 'integer'
    ];

    protected $appends = [
        'formatted_price',
        'features_list',
        'duration_text'
    ];

    // Relationships
    public function subscriptions()
    {
        return $this->hasMany(UserSubscription::class, 'plan_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'subscription_id');
    }

    // Accessors
    public function getFormattedPriceAttribute()
    {
        return '$' . number_format($this->price, 2);
    }

    public function getFeaturesListAttribute()
    {
        if (is_string($this->features)) {
            return json_decode($this->features, true) ?? [];
        }
        return $this->features ?? [];
    }

    public function getDurationTextAttribute()
    {
        $days = $this->duration_days;
        
        if ($days >= 365) {
            $years = floor($days / 365);
            return $years . ' ' . ($years > 1 ? 'Years' : 'Year');
        } elseif ($days >= 30) {
            $months = floor($days / 30);
            return $months . ' ' . ($months > 1 ? 'Months' : 'Month');
        } else {
            return $days . ' ' . ($days > 1 ? 'Days' : 'Day');
        }
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopePopular($query)
    {
        return $query->where('is_popular', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('price');
    }

    // Methods
    public function calculateEndDate($startDate = null)
    {
        $startDate = $startDate ?? now();
        return $startDate->copy()->addDays($this->duration_days);
    }
}