<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Certificate;
use App\Models\LessonProgress;

class EnrollmentController extends Controller
{
    /**
     * Enroll in a course (handles free courses and subscription-based enrollment)
     */
    public function enroll($courseId)
    {
        $course = Course::published()->findOrFail($courseId);
        $user = Auth::user();

        // Check if user is already enrolled
        if ($course->isEnrolled($user->id)) {
            return redirect()->route('courses.learning', $course->slug)
                ->with('info', 'You are already enrolled in this course.');
        }

        // For paid courses, check subscription
        if (!$course->is_free) {
            if (!$user->has_active_subscription) {
                return redirect()->route('subscription.plans')
                    ->with('error', 'This course requires an active subscription. Please purchase a subscription to access all paid courses.');
            }
            
            // Create enrollment with subscription access
            return $this->createEnrollment($course, $user, 'subscription');
        }

        // For free courses
        return $this->createEnrollment($course, $user, 'purchased');
    }

    /**
     * Create enrollment record
     */
    private function createEnrollment($course, $user, $accessType)
    {
        DB::beginTransaction();

        try {
            Enrollment::create([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'access_type' => $accessType,
                'enrollment_date' => now(),
                'expiry_date' => $accessType === 'subscription' ? $user->active_subscription->end_date : null,
                'status' => 'active',
                'progress' => 0
            ]);

            $course->increment('total_students');

            DB::commit();

            $message = $accessType === 'subscription' 
                ? 'Successfully enrolled using your subscription! Start learning now.'
                : 'Successfully enrolled in the course! Start learning now.';

            return redirect()->route('courses.learning', $course->slug)
                ->with('success', $message);
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to enroll. Please try again.');
        }
    }

    /**
     * Enroll in a course via AJAX
     */
    public function enrollAjax($courseId)
    {
        try {
            $course = Course::published()->findOrFail($courseId);
            $user = Auth::user();

            // Check if user is already enrolled
            if ($course->isEnrolled($user->id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are already enrolled in this course.',
                    'redirect_url' => route('courses.learning', $course->slug)
                ]);
            }

            // For paid courses, check subscription
            if (!$course->is_free) {
                if (!$user->has_active_subscription) {
                    return response()->json([
                        'success' => false,
                        'redirect_to_subscription' => true,
                        'subscription_url' => route('subscription.plans'),
                        'message' => 'This course requires a subscription. Please purchase a subscription to access all paid courses.'
                    ]);
                }
                
                // Create enrollment with subscription
                DB::beginTransaction();
                
                Enrollment::create([
                    'user_id' => $user->id,
                    'course_id' => $course->id,
                    'access_type' => 'subscription',
                    'enrollment_date' => now(),
                    'expiry_date' => $user->active_subscription->end_date,
                    'status' => 'active',
                    'progress' => 0
                ]);

                $course->increment('total_students');
                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Successfully enrolled using your subscription!',
                    'redirect_url' => route('courses.learning', $course->slug)
                ]);
            }

            // For free courses
            DB::beginTransaction();

            Enrollment::create([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'access_type' => 'purchased',
                'enrollment_date' => now(),
                'status' => 'active',
                'progress' => 0
            ]);

            $course->increment('total_students');
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Successfully enrolled in the course!',
                'redirect_url' => route('courses.learning', $course->slug)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while enrolling. Please try again.'
            ], 500);
        }
    }

    /**
     * Display the course learning page
     */
    public function learning($slug)
    {
        $course = Course::where('slug', $slug)
            ->with(['sections.lessons', 'instructor'])
            ->firstOrFail();

        $user = Auth::user();

        // Check if user has access
        if (!$course->canUserAccess($user->id)) {
            if (!$course->is_free && !$user->has_active_subscription) {
                return redirect()->route('subscription.plans')
                    ->with('error', 'This course requires an active subscription. Please purchase a subscription to access.');
            }
            return redirect()->route('courses.show', $course->slug)
                ->with('error', 'You do not have access to this course.');
        }

        // Get enrollment
        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        // If no enrollment but user has subscription and course is paid, create enrollment
        if (!$enrollment && !$course->is_free && $user->has_active_subscription) {
            $enrollment = Enrollment::create([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'access_type' => 'subscription',
                'enrollment_date' => now(),
                'expiry_date' => $user->active_subscription->end_date,
                'status' => 'active',
                'progress' => 0
            ]);
            $course->increment('total_students');
        }

        // Get course progress
        $progress = $enrollment ? $enrollment->progress : 0;
        $completedLessons = LessonProgress::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->where('status', 'completed')
            ->pluck('lesson_id')
            ->toArray();

        return view('course-learning', compact('course', 'enrollment', 'progress', 'completedLessons'));
    }

    /**
     * Update lesson progress
     */
    public function updateProgress(Request $request, $courseId, $lessonId)
    {
        $request->validate([
            'progress' => 'required|integer|min:0|max:100',
            'status' => 'sometimes|in:in_progress,completed'
        ]);

        $course = Course::findOrFail($courseId);

        // Check if user is enrolled
        $enrollment = Enrollment::where('user_id', Auth::id())
            ->where('course_id', $courseId)
            ->where('status', 'active')
            ->first();

        if (!$enrollment) {
            return response()->json(['error' => 'Not enrolled in this course'], 403);
        }

        // Update or create lesson progress
        $progress = LessonProgress::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'course_id' => $courseId,
                'lesson_id' => $lessonId
            ],
            [
                'progress' => $request->progress,
                'status' => $request->status ?? 'in_progress',
                'last_accessed' => now(),
                'completed_at' => $request->status === 'completed' ? now() : null
            ]
        );

        // Update overall course progress
        $this->updateCourseProgress($courseId);

        // Get updated progress
        $updatedEnrollment = Enrollment::where('user_id', Auth::id())
            ->where('course_id', $courseId)
            ->first();

        return response()->json([
            'success' => true,
            'progress' => $progress,
            'course_progress' => $updatedEnrollment->progress,
            'is_completed' => $updatedEnrollment->progress >= 100
        ]);
    }

    /**
     * Update overall course progress
     */
    private function updateCourseProgress($courseId)
    {
        $userId = Auth::id();
        $course = Course::find($courseId);

        $totalLessons = $course->lessons()->count();
        $completedLessons = LessonProgress::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->where('status', 'completed')
            ->count();

        $progress = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;

        $enrollment = Enrollment::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->first();

        if ($enrollment) {
            $enrollment->update([
                'progress' => $progress,
                'completed_at' => $progress >= 100 ? now() : null,
                'last_accessed' => now()
            ]);

            // Generate certificate if course is completed and not already generated
            if ($progress >= 100 && !$enrollment->certificate_generated) {
                $this->generateCertificate($courseId, $userId, $enrollment);
            }
        }
    }

    /**
     * Generate certificate for completed course
     */
    private function generateCertificate($courseId, $userId, $enrollment = null)
    {
        if (!$enrollment) {
            $enrollment = Enrollment::where('user_id', $userId)
                ->where('course_id', $courseId)
                ->first();
        }

        if ($enrollment && !$enrollment->certificate_generated) {
            // Check if certificate already exists
            $existingCertificate = Certificate::where('user_id', $userId)
                ->where('course_id', $courseId)
                ->first();

            if (!$existingCertificate) {
                // Create certificate record
                Certificate::create([
                    'user_id' => $userId,
                    'course_id' => $courseId,
                    'enrollment_id' => $enrollment->id,
                    'issue_date' => now(),
                    'certificate_number' => 'CERT-' . strtoupper(uniqid())
                ]);

                $enrollment->update(['certificate_generated' => true]);
            }
        }
    }

    /**
     * Get user's progress for a course
     */
    public function getProgress($courseId)
    {
        $course = Course::findOrFail($courseId);

        $enrollment = Enrollment::where('user_id', Auth::id())
            ->where('course_id', $courseId)
            ->first();

        if (!$enrollment) {
            return response()->json(['error' => 'Not enrolled'], 403);
        }

        $completedLessons = LessonProgress::where('user_id', Auth::id())
            ->where('course_id', $courseId)
            ->where('status', 'completed')
            ->count();

        $totalLessons = $course->lessons()->count();

        return response()->json([
            'success' => true,
            'progress' => $enrollment->progress,
            'completed_lessons' => $completedLessons,
            'total_lessons' => $totalLessons,
            'certificate_generated' => $enrollment->certificate_generated
        ]);
    }

    /**
     * Check enrollment status
     */
    public function checkStatus($courseId)
    {
        $course = Course::findOrFail($courseId);
        $user = Auth::user();

        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $courseId)
            ->where('status', 'active')
            ->first();

        $hasSubscription = $user->has_active_subscription;

        return response()->json([
            'success' => true,
            'is_enrolled' => $enrollment ? true : false,
            'has_subscription' => $hasSubscription,
            'can_access' => $course->canUserAccess($user->id),
            'is_free' => $course->is_free,
            'redirect_url' => $enrollment ? route('courses.learning', $course->slug) : null
        ]);
    }
}