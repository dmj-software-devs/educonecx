<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        'is_free',
        'course_type',
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
        'is_free' => 'boolean',
        'featured' => 'boolean',
        'popular' => 'boolean',
        'discount_start_date' => 'datetime',
        'discount_end_date' => 'datetime',
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    protected $appends = [
        'thumbnail_url',
        'excerpt',
        'is_paid',
        'formatted_price',
        'display_price',
        'current_price',
        'has_discount',
        'discount_percentage',
        'video_intro_url',
        'duration_hours',
        'total_lessons_count',
        'average_rating_formatted'
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

    // Accessors
    public function getIsPaidAttribute(): bool
    {
        return !$this->is_free;
    }

    public function getFormattedPriceAttribute(): string
    {
        if ($this->is_free) {
            return 'Free';
        }

        $price = $this->current_price;
        return '$' . number_format($price, 2);
    }

    // In your Course model, modify the thumbnail_url accessor:
    public function getThumbnailUrlAttribute(): string
    {
        if ($this->thumbnail) {
            // Check if the path already includes 'public/'
            if (strpos($this->thumbnail, 'public/') === 0) {
                return Storage::url(str_replace('public/', '', $this->thumbnail));
            }
            return Storage::url($this->thumbnail);
        }

        return asset('images/course-placeholder.jpg');
    }

    public function getExcerptAttribute(): string
    {
        if (isset($this->attributes['excerpt']) && !empty($this->attributes['excerpt'])) {
            return $this->attributes['excerpt'];
        }

        return Str::limit(strip_tags($this->description ?? ''), 120, '...');
    }

    public function getIsEnrolledAttribute(): bool
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

    public function getUserProgressAttribute(): int
    {
        if (!auth()->check()) {
            return 0;
        }

        $enrollment = $this->user_enrollment;
        return $enrollment ? $enrollment->progress : 0;
    }

    public function getDisplayPriceAttribute(): string
    {
        if ($this->is_free) {
            return 'Free';
        }

        if ($this->has_discount) {
            return '$' . number_format($this->sale_price, 2);
        }

        return '$' . number_format($this->price, 2);
    }

    public function getCurrentPriceAttribute(): float
    {
        if ($this->is_free) {
            return 0;
        }

        if ($this->sale_price && $this->discount_start_date && $this->discount_end_date) {
            $now = now();
            if ($now >= $this->discount_start_date && $now <= $this->discount_end_date) {
                return (float) $this->sale_price;
            }
        }
        return (float) $this->price;
    }

    public function getHasDiscountAttribute(): bool
    {
        if ($this->is_free) {
            return false;
        }

        $now = now();
        return $this->sale_price &&
            $this->discount_start_date &&
            $this->discount_end_date &&
            $now >= $this->discount_start_date &&
            $now <= $this->discount_end_date;
    }

    public function getDiscountPercentageAttribute(): int
    {
        if (!$this->has_discount || $this->price == 0) {
            return 0;
        }
        return (int) round((($this->price - $this->sale_price) / $this->price) * 100);
    }

    public function getVideoIntroUrlAttribute(): ?string
    {
        return $this->video_intro ? Storage::url($this->video_intro) : null;
    }

    public function getDurationHoursAttribute(): float
    {
        // Calculate total duration from lessons in hours
        $totalMinutes = $this->lessons()->sum('duration');
        return round($totalMinutes / 60, 1);
    }

    public function getTotalLessonsCountAttribute(): int
    {
        return $this->lessons()->count();
    }

    public function getAverageRatingFormattedAttribute(): string
    {
        return number_format($this->average_rating ?? 0, 1);
    }

    public function getProgressForUserAttribute($userId = null): int
    {
        $userId = $userId ?? auth()->id();
        if (!$userId) return 0;

        $enrollment = $this->enrollments()->where('user_id', $userId)->first();
        return $enrollment ? $enrollment->progress : 0;
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
        return $query->where('is_free', true);
    }

    public function scopePaid($query)
    {
        return $query->where('course_type', 'paid');
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeByLevel($query, $level)
    {
        return $query->where('level', $level);
    }

    public function scopeSearch($query, $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('title', 'LIKE', "%{$keyword}%")
                ->orWhere('description', 'LIKE', "%{$keyword}%")
                ->orWhere('excerpt', 'LIKE', "%{$keyword}%");
        });
    }

    // Boot method
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($course) {
            if (empty($course->slug) && !empty($course->title)) {
                $course->slug = Str::slug($course->title);
            }

            // Auto-calculate is_free based on course_type or price
            if (isset($course->course_type)) {
                $course->is_free = $course->course_type === 'free';
            } elseif (isset($course->price)) {
                $course->is_free = $course->price == 0;
            }
        });

        static::updating(function ($course) {
            if ($course->isDirty('title') && empty($course->slug)) {
                $course->slug = Str::slug($course->title);
            }

            // Auto-calculate is_free based on course_type or price
            if ($course->isDirty('course_type')) {
                $course->is_free = $course->course_type === 'free';
            } elseif ($course->isDirty('price')) {
                $course->is_free = $course->price == 0;
            }
        });
    }
}
