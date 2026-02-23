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
     * Enroll in a course
     */
    public function enroll($courseId)
    {
        $course = Course::published()->findOrFail($courseId);
        
        // Check if user is already enrolled
        if ($course->is_enrolled) {
            return redirect()->back()->with('error', 'You are already enrolled in this course.');
        }

        // Create enrollment
        $enrollment = Enrollment::create([
            'user_id' => Auth::id(),
            'course_id' => $course->id,
            'enrollment_date' => now(),
            'status' => 'active',
            'progress' => 0
        ]);

        // Update total students count
        $course->increment('total_students');

        return redirect()->route('courses.learning', $course->slug)
            ->with('success', 'Successfully enrolled in the course!');
    }

    /**
     * Enroll in a course via AJAX
     */
    public function enrollAjax($courseId)
    {
        try {
            $course = Course::published()->findOrFail($courseId);
            
            // Check if user is already enrolled
            if ($course->is_enrolled) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are already enrolled in this course.'
                ], 400);
            }

            DB::beginTransaction();

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

        // Check if user is enrolled
        if (!$course->is_enrolled) {
            return redirect()->route('courses.show', $course->slug)
                ->with('error', 'Please enroll in the course first.');
        }

        // Get user's progress for this course
        $enrollment = $course->enrollments()
            ->where('user_id', Auth::id())
            ->first();

        return view('course-learning', compact('course', 'enrollment'));
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
        if (!$course->is_enrolled) {
            return response()->json(['error' => 'Not enrolled'], 403);
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

        return response()->json([
            'success' => true,
            'progress' => $progress
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

        Enrollment::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->update([
                'progress' => $progress,
                'completed_at' => $progress >= 100 ? now() : null,
                'last_accessed' => now()
            ]);

        // Generate certificate if course is completed
        if ($progress >= 100) {
            $this->generateCertificate($courseId, $userId);
        }
    }

    /**
     * Generate certificate for completed course
     */
    private function generateCertificate($courseId, $userId)
    {
        $enrollment = Enrollment::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->first();

        if ($enrollment && !$enrollment->certificate_generated) {
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