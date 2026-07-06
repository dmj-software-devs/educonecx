<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'name',
        'email',
        'password',
        'avatar',
        'phone',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'bio',
        'role',
        'status',
        'google_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    protected $appends = [
        'has_active_subscription',
        'active_subscription'
    ];

    // Existing relationships
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'enrollments')
            ->withPivot('progress', 'completed_at', 'enrollment_date', 'access_type')
            ->withTimestamps();
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function quizAttempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function specimenRequests()
    {
        return $this->hasMany(SpecimenRequest::class, 'client_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function wishlist()
    {
        return $this->belongsToMany(Course::class, 'wishlist')->withTimestamps();
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }


    public function academySessions()
    {
        return $this->hasMany(AcademySession::class);
    }

    public function englishPracticeLessonProgress()
    {
        return $this->hasMany(EnglishPracticeLessonProgress::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // New subscription relationships
    public function subscriptions()
    {
        return $this->hasMany(UserSubscription::class);
    }

    public function activeSubscriptions()
    {
        return $this->subscriptions()
            ->where('status', 'active')
            ->where('payment_status', 'paid')
            ->where('end_date', '>', now());
    }

    // Accessors
    public function getHasActiveSubscriptionAttribute()
    {
        return $this->activeSubscriptions()->exists();
    }

    public function getActiveSubscriptionAttribute()
    {
        return $this->activeSubscriptions()->first();
    }

    // Check if user can access the Practice Room using the same access paths
    // that unlock paid courses: a valid subscription or an existing paid-course
    // enrollment created after payment.
    public function canAccessPracticeRoom(): bool
    {
        if ($this->has_active_subscription || $this->hasAvailablePracticeTime()) {
            return true;
        }

        return $this->enrollments()
            ->where('status', 'active')
            ->where('access_type', '!=', 'subscription')
            ->whereHas('course', fn ($query) => $query->where('is_free', false))
            ->exists();
    }

    public function canStartPaidPracticeSession(): bool
    {
        return $this->canAccessPracticeRoom();
    }

    public function hasAvailablePracticeTime(): bool
    {
        $balance = $this->relationLoaded('practiceBalance')
            ? $this->practiceBalance
            : $this->practiceBalance()->first();

        return (int) ($balance?->computed_available_minutes ?? 0) > 0;
    }

    // Check if user can access a course
    public function canAccessCourse($courseId)
    {
        $course = Course::find($courseId);
        if (!$course) return false;

        // Free courses are accessible to everyone
        if ($course->is_free) {
            return true;
        }

        // Check if user is enrolled (via subscription)
        $isEnrolled = $this->enrollments()
            ->where('course_id', $courseId)
            ->where('status', 'active')
            ->exists();

        if ($isEnrolled) {
            return true;
        }

        // Check if user has active subscription (for paid courses)
        return $this->has_active_subscription;
    }

    // Get all accessible course IDs
    public function getAccessibleCourseIds()
    {
        $enrolledCourseIds = $this->enrollments()
            ->where('status', 'active')
            ->where('access_type', '!=', 'subscription')
            ->pluck('course_id')
            ->toArray();

        if ($this->has_active_subscription) {
            // If user has subscription, they can access all paid courses
            $paidCourseIds = Course::where('is_free', false)
                ->pluck('id')
                ->toArray();

            return array_unique(array_merge($enrolledCourseIds, $paidCourseIds));
        }

        // If no subscription, they can only access free courses they're enrolled in
        return $enrolledCourseIds;
    }

    // Auto-enroll in all paid courses when subscription is activated
    public function enrollInAllPaidCourses($subscriptionId = null)
    {
        $paidCourses = Course::where('is_free', false)->get();

        foreach ($paidCourses as $course) {
            // Check if already enrolled
            $existingEnrollment = Enrollment::where('user_id', $this->id)
                ->where('course_id', $course->id)
                ->first();

            if (!$existingEnrollment) {
                Enrollment::create([
                    'user_id' => $this->id,
                    'course_id' => $course->id,
                    'access_type' => 'subscription',
                    'enrollment_date' => now(),
                    'expiry_date' => $this->active_subscription->end_date ?? now()->addYear(),
                    'status' => 'active',
                    'progress' => 0
                ]);

                $course->increment('total_students');
            } elseif ($existingEnrollment->access_type === 'subscription') {
                // Update expiry date for existing subscription enrollment
                $existingEnrollment->update([
                    'expiry_date' => $this->active_subscription->end_date ?? now()->addYear(),
                    'status' => 'active'
                ]);
            }
        }
    }




    public function practiceCredit()
    {
        return $this->hasOne(UserPracticeCredit::class);
    }

    public function practiceCredits()
    {
        return $this->practiceCredit();
    }

    public function practiceCreditTransactions()
    {
        return $this->hasMany(PracticeCreditTransaction::class);
    }

    public function practiceBalance()
    {
        return $this->hasOne(UserPracticeBalance::class);
    }

    public function practiceUsageLogs()
    {
        return $this->hasMany(PracticeUsageLog::class);
    }

    public function academyAvatarSetting()
    {
        return $this->hasOne(AcademyUserAvatarSetting::class);
    }

    // Helper methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isInstructor()
    {
        return $this->role === 'instructor';
    }

    public function isStudent()
    {
        return $this->role === 'student';
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            // Check if it's a full URL (Google avatar) or a local path
            if (filter_var($this->avatar, FILTER_VALIDATE_URL)) {
                return $this->avatar;
            }
            // If it's a local path, make sure to use asset()
            return asset('storage/' . $this->avatar);
        }

        // Default UI Avatar
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }
}
