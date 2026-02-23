<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'description',
        'thumbnail',
        'video_intro',
        'price',
        'sale_price',
        'discount_percent',
        'discount_start_date',
        'discount_end_date',
        'duration',
        'level',
        'language',
        'prerequisites',
        'what_you_will_learn',
        'requirements',
        'target_audience',
        'material_includes',
        'featured',
        'popular',
        'status',
        'published_at',
        'created_by',
        'category_id',
        'total_students',
        'total_lessons',
        'total_quizzes',
        'total_duration',
        'average_rating',
        'total_reviews'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'featured' => 'boolean',
        'popular' => 'boolean',
        'discount_start_date' => 'datetime',
        'discount_end_date' => 'datetime',
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relationships
    public function instructor()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'course_tags');
    }

    public function sections()
    {
        return $this->hasMany(Section::class)->orderBy('sort_order');
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('sort_order');
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }



    // Add these helper methods
    public function getIsEnrolledAttribute()
    {
        if (!auth()->check()) {
            return false;
        }

        return $this->enrollments()
            ->where('user_id', auth()->id())
            ->where('status', 'active')
            ->exists();
    }

    public function getUserEnrollmentAttribute()
    {
        if (!auth()->check()) {
            return null;
        }

        return $this->enrollments()
            ->where('user_id', auth()->id())
            ->first();
    }

    public function getUserProgressAttribute()
    {
        if (!auth()->check()) {
            return 0;
        }

        $enrollment = $this->user_enrollment;
        return $enrollment ? $enrollment->progress : 0;
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'enrollments')
            ->withPivot('progress', 'completed_at', 'enrollment_date')
            ->withTimestamps();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function wishlistedBy()
    {
        return $this->belongsToMany(User::class, 'wishlist')->withTimestamps();
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopePopular($query)
    {
        return $query->where('popular', true);
    }

    public function scopeFree($query)
    {
        return $query->where(function ($q) {
            $q->where('price', 0)
                ->orWhere(function ($q2) {
                    $q2->whereNotNull('sale_price')
                        ->where('sale_price', 0);
                });
        });
    }

    public function scopePaid($query)
    {
        return $query->where('price', '>', 0)
            ->where(function ($q) {
                $q->whereNull('sale_price')
                    ->orWhere('sale_price', '>', 0);
            });
    }

    // Accessors
    public function getCurrentPriceAttribute()
    {
        if ($this->sale_price && $this->discount_start_date && $this->discount_end_date) {
            $now = now();
            if ($now >= $this->discount_start_date && $now <= $this->discount_end_date) {
                return $this->sale_price;
            }
        }
        return $this->price;
    }

    public function getHasDiscountAttribute()
    {
        $now = now();
        return $this->sale_price &&
            $this->discount_start_date &&
            $this->discount_end_date &&
            $now >= $this->discount_start_date &&
            $now <= $this->discount_end_date;
    }

    public function getDiscountPercentageAttribute()
    {
        if (!$this->hasDiscount || $this->price == 0) {
            return 0;
        }
        return round((($this->price - $this->sale_price) / $this->price) * 100);
    }

    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail ? asset('storage/' . $this->thumbnail) : asset('images/course-placeholder.jpg');
    }

    public function getVideoIntroUrlAttribute()
    {
        return $this->video_intro ? asset('storage/' . $this->video_intro) : null;
    }

    public function getProgressForUserAttribute($userId = null)
    {
        $userId = $userId ?? auth()->id();
        if (!$userId) return 0;

        $enrollment = $this->enrollments()->where('user_id', $userId)->first();
        return $enrollment ? $enrollment->progress : 0;
    }

   
}
