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
     * Enroll in a course (handles both free and paid courses)
     */
    public function enroll($courseId)
    {
        $course = Course::published()->findOrFail($courseId);

        // Check if user is already enrolled
        if ($course->is_enrolled) {
            return redirect()->back()->with('error', 'You are already enrolled in this course.');
        }

        // For paid courses, redirect to checkout
        if (!$course->is_free) {
            return redirect()->route('checkout', $course)
                ->with('info', 'Please complete the payment to enroll in this course.');
        }

        // For free courses, create enrollment directly
        DB::beginTransaction();

        try {
            // Create enrollment
            Enrollment::create([
                'user_id' => Auth::id(),
                'course_id' => $course->id,
                'enrollment_date' => now(),
                'status' => 'active',
                'progress' => 0
            ]);

            // Update total students count
            $course->increment('total_students');

            DB::commit();

            return redirect()->route('courses.learning', $course->slug)
                ->with('success', 'Successfully enrolled in the course! Start learning now.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to enroll. Please try again.');
        }
    }

    /**
     * Enroll in a course via AJAX (handles both free and paid courses)
     */
    public function enrollAjax($courseId)
    {
        try {
            $course = Course::published()->findOrFail($courseId);

            // Check if user is already enrolled
            if ($course->is_enrolled) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are already enrolled in this course.',
                    'redirect_url' => route('courses.learning', $course->slug)
                ]);
            }

            // For paid courses, return checkout URL
            if (!$course->is_free) {
                return response()->json([
                    'success' => false,
                    'redirect_to_checkout' => true,
                    'checkout_url' => route('checkout', $course),
                    'message' => 'Please complete the payment to enroll.'
                ]);
            }

            DB::beginTransaction();

            // Create enrollment for free course
            Enrollment::create([
                'user_id' => Auth::id(),
                'course_id' => $course->id,
                'enrollment_date' => now(),
                'status' => 'active',
                'progress' => 0
            ]);

            // Update total students count
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

        // Check if user has access (enrolled or purchased)
        $enrollment = Enrollment::where('user_id', Auth::id())
            ->where('course_id', $course->id)
            ->where('status', 'active')
            ->first();

        // If not enrolled, check if they've purchased it
        if (!$enrollment && !$course->is_free) {
            // Check if user has purchased this course
            $hasPurchased = \App\Models\Order::where('user_id', Auth::id())
                ->whereHas('items', function ($query) use ($course) {
                    $query->where('course_id', $course->id);
                })
                ->where('payment_status', 'paid')
                ->exists();

            if ($hasPurchased) {
                // Create enrollment after successful purchase
                $enrollment = Enrollment::create([
                    'user_id' => Auth::id(),
                    'course_id' => $course->id,
                    'enrollment_date' => now(),
                    'status' => 'active',
                    'progress' => 0
                ]);

                // Increment total students count
                $course->increment('total_students');
            }
        }

        // If still no enrollment, redirect to course page
        if (!$enrollment) {
            return redirect()->route('courses.show', $course->slug)
                ->with('error', 'Please enroll or purchase this course to access the content.');
        }

        // Get course progress for enrolled user
        $progress = $enrollment->progress;
        $completedLessons = LessonProgress::where('user_id', Auth::id())
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

        $enrollment = Enrollment::where('user_id', Auth::id())
            ->where('course_id', $courseId)
            ->where('status', 'active')
            ->first();

        $hasPurchased = false;

        if (!$enrollment && !$course->is_free) {
            $hasPurchased = \App\Models\Order::where('user_id', Auth::id())
                ->whereHas('items', function ($query) use ($course) {
                    $query->where('course_id', $course->id);
                })
                ->where('payment_status', 'paid')
                ->exists();
        }

        return response()->json([
            'success' => true,
            'is_enrolled' => $enrollment ? true : false,
            'has_purchased' => $hasPurchased,
            'is_free' => $course->is_free,
            'redirect_url' => $enrollment ? route('courses.learning', $course->slug) : null
        ]);
    }
}
