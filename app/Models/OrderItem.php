<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'item_type',
        'course_id',
        'item_name',
        'price',
        'total'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'total' => 'decimal:2'
    ];

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Accessors
    public function getItemNameAttribute()
    {
        return $this->attributes['item_name'] ?? 'Item';
    }

    public function getItemTypeAttribute()
    {
        return $this->attributes['item_type'] ?? 'unknown';
    }

    public function getItemTypeLabelAttribute()
    {
        $labels = [
            'course' => 'Course',
            'all_access' => 'All-Access Pass'
        ];
        return $labels[$this->item_type] ?? ucfirst($this->item_type);
    }
}