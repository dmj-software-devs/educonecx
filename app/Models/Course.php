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
        'discount_start_date',
        'discount_end_date',
        'is_free',
        'course_type',
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
        'total_reviews',
        'seo_title',
        'seo_description',
        'seo_keywords'
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
        'updated_at' => 'datetime',
        'total_students' => 'integer',
        'total_lessons' => 'integer',
        'total_quizzes' => 'integer',
        'total_duration' => 'integer',
        'average_rating' => 'float',
        'total_reviews' => 'integer'
    ];

    protected $appends = [
        'thumbnail_url',
        'video_intro_url',
        'current_price',
        'has_discount',
        'discount_percentage',
        'formatted_duration',
        'duration_hours',
        'is_paid',
        'instructor_name',
        'category_name',
        'rating_stars',
        'total_enrollments',
        'access_type_label'
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
            ->withPivot('progress', 'completed_at', 'enrollment_date', 'expiry_date', 'access_type')
            ->withTimestamps();
    }

    public function ratings()
    {
        return $this->hasMany(CourseRating::class);
    }

    public function approvedRatings()
    {
        return $this->ratings()->where('is_approved', true);
    }

    public function lessonProgress()
    {
        return $this->hasMany(LessonProgress::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Accessors
    public function getThumbnailUrlAttribute(): string
    {
        if ($this->thumbnail) {
            if (str_starts_with($this->thumbnail, 'storage/')) {
                return asset($this->thumbnail);
            }
            return Storage::url($this->thumbnail);
        }
        return asset('images/course-placeholder.jpg');
    }

    public function getVideoIntroUrlAttribute(): ?string
    {
        return $this->video_intro ? Storage::url($this->video_intro) : null;
    }

    public function getCurrentPriceAttribute(): float
    {
        if ($this->is_free) {
            return 0;
        }

        if ($this->has_discount) {
            return (float) $this->sale_price;
        }

        return (float) $this->price;
    }

    public function getHasDiscountAttribute(): bool
    {
        if ($this->is_free || !$this->sale_price) {
            return false;
        }

        $now = now();
        if ($this->discount_start_date && $this->discount_end_date) {
            return $now >= $this->discount_start_date && $now <= $this->discount_end_date;
        }

        return false;
    }

    public function getDiscountPercentageAttribute(): int
    {
        if (!$this->has_discount || $this->price == 0) {
            return 0;
        }
        return (int) round((($this->price - $this->sale_price) / $this->price) * 100);
    }


    public function getDurationHoursAttribute(): int
    {
        if (!empty($this->duration)) {
            return max(1, (int) ceil((float) $this->duration));
        }

        if (!empty($this->total_duration)) {
            return max(1, (int) ceil($this->total_duration / 3600));
        }

        return 1;
    }

    public function getFormattedDurationAttribute(): string
    {
        if (!$this->total_duration) {
            return 'N/A';
        }

        $hours = floor($this->total_duration / 3600);
        $minutes = floor(($this->total_duration % 3600) / 60);

        if ($hours > 0) {
            return $hours . 'h ' . $minutes . 'm';
        }
        return $minutes . ' minutes';
    }

    public function getIsPaidAttribute(): bool
    {
        return !$this->is_free;
    }

    public function getInstructorNameAttribute(): string
    {
        return $this->instructor ? $this->instructor->name : 'Unknown Instructor';
    }

    public function getCategoryNameAttribute(): string
    {
        return $this->category ? $this->category->name : 'Uncategorized';
    }

    public function getRatingStarsAttribute(): array
    {
        $stars = [];
        for ($i = 1; $i <= 5; $i++) {
            $stars[] = [
                'filled' => $i <= round($this->average_rating ?? 0),
                'value' => $i
            ];
        }
        return $stars;
    }

    public function getTotalEnrollmentsAttribute(): int
    {
        return $this->enrollments()->count();
    }

    public function getAccessTypeLabelAttribute(): string
    {
        return $this->is_free ? 'Free' : 'Subscription Required';
    }

    // Check if user has access via subscription
    public function hasSubscriptionAccess($userId = null)
    {
        $userId = $userId ?? auth()->id();
        if (!$userId) return false;
        
        // Check the same paid subscription columns used by User::has_active_subscription.
        return UserSubscription::where('user_id', $userId)
            ->where('status', 'active')
            ->where('payment_status', 'paid')
            ->where('end_date', '>', now())
            ->exists();
    }

    // Check if user can access this course
    public function canUserAccess($userId = null)
    {
        $userId = $userId ?? auth()->id();
        if (!$userId) return false;
        
        // Free courses are accessible to everyone
        if ($this->is_free) {
            return true;
        }
        
        // Subscription enrollments only grant access until their expiry date.
        // Non-subscription enrollments, such as free/purchased access, remain valid while active.
        $hasCurrentEnrollment = $this->enrollments()
            ->where('user_id', $userId)
            ->where('status', 'active')
            ->where(function ($query) {
                $query->where('access_type', '!=', 'subscription')
                    ->orWhere('expiry_date', '>', now());
            })
            ->exists();

        if ($hasCurrentEnrollment) {
            return true;
        }
        
        // Check if user has active subscription within the paid subscription window.
        return $this->hasSubscriptionAccess($userId);
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeArchived($query)
    {
        return $query->where('status', 'archived');
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
        return $query->where('is_free', false);
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

    public function scopeWithFilters($query, array $filters)
    {
        if (!empty($filters['search'])) {
            $query->search($filters['search']);
        }

        if (!empty($filters['category'])) {
            $query->byCategory($filters['category']);
        }

        if (!empty($filters['level'])) {
            $query->byLevel($filters['level']);
        }

        if (!empty($filters['price'])) {
            if ($filters['price'] === 'free') {
                $query->free();
            } elseif ($filters['price'] === 'paid') {
                $query->paid();
            }
        }

        if (!empty($filters['sort'])) {
            switch ($filters['sort']) {
                case 'latest':
                    $query->latest();
                    break;
                case 'oldest':
                    $query->oldest();
                    break;
                case 'price_low':
                    $query->orderByRaw('CASE WHEN is_free = 1 THEN 0 ELSE COALESCE(sale_price, price) END ASC');
                    break;
                case 'price_high':
                    $query->orderByRaw('CASE WHEN is_free = 1 THEN 0 ELSE COALESCE(sale_price, price) END DESC');
                    break;
                case 'popular':
                    $query->orderBy('total_students', 'desc');
                    break;
                case 'rated':
                    $query->orderBy('average_rating', 'desc');
                    break;
            }
        }

        return $query;
    }

    // Methods
    public function updateStats()
    {
        $this->total_lessons = $this->lessons()->count();
        $this->total_duration = $this->lessons()->sum('video_duration');
        $this->total_students = $this->enrollments()->count();
        $this->average_rating = $this->approvedRatings()->avg('rating') ?? 0;
        $this->total_reviews = $this->approvedRatings()->count();
        $this->save();
    }

    public function isEnrolled($userId = null)
    {
        $userId = $userId ?? auth()->id();
        if (!$userId) return false;

        return $this->enrollments()
            ->where('user_id', $userId)
            ->where('status', 'active')
            ->exists();
    }

    public function getUserProgress($userId = null)
    {
        $userId = $userId ?? auth()->id();
        if (!$userId) return 0;

        $completedLessons = LessonProgress::where('user_id', $userId)
            ->where('course_id', $this->id)
            ->where('status', 'completed')
            ->count();

        if ($this->total_lessons == 0) return 0;

        return round(($completedLessons / $this->total_lessons) * 100);
    }

    // Boot method
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($course) {
            if (empty($course->slug)) {
                $course->slug = Str::slug($course->title);
            }
        });

        static::updating(function ($course) {
            if ($course->isDirty('title')) {
                $course->slug = Str::slug($course->title);
            }
        });

        static::deleting(function ($course) {
            if ($course->thumbnail) {
                Storage::disk('public')->delete($course->thumbnail);
            }
            if ($course->video_intro) {
                Storage::disk('public')->delete($course->video_intro);
            }
        });
    }
}