<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class CourseController extends Controller
{
    /**
     * Display a listing of courses
     */
    public function index(Request $request)
    {
        // Get filter parameters
        $filters = [
            'keyword' => $request->input('keyword', ''),
            'categories' => $request->input('categories', []),
            'price' => $request->input('price', []),
            'sort' => $request->input('sort', 'newest_first'),
        ];

        // Base query with relationships
        $query = Course::published()
            ->with(['category', 'instructor'])
            ->withCount('approvedRatings as reviews_count')
            ->withCount('students as total_students')
            ->withCount('lessons as lessons_count');

        // Filter by keyword
        if (!empty($filters['keyword'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('title', 'like', '%' . $filters['keyword'] . '%')
                    ->orWhere('description', 'like', '%' . $filters['keyword'] . '%')
                    ->orWhere('excerpt', 'like', '%' . $filters['keyword'] . '%');
            });
        }

        // Filter by categories
        if (!empty($filters['categories'])) {
            $query->whereIn('category_id', $filters['categories']);
        }

        // Filter by price
        if (!empty($filters['price'])) {
            $query->where(function ($q) use ($filters) {
                if (in_array('free', $filters['price'])) {
                    $q->orWhere('is_free', true);
                }
                if (in_array('paid', $filters['price'])) {
                    $q->orWhere('is_free', false);
                }
            });
        }

        // Apply sorting
        switch ($filters['sort']) {
            case 'newest_first':
                $query->latest('created_at');
                break;
            case 'oldest_first':
                $query->oldest('created_at');
                break;
            case 'course_title_az':
                $query->orderBy('title', 'asc');
                break;
            case 'course_title_za':
                $query->orderBy('title', 'desc');
                break;
            case 'popular':
                $query->orderBy('total_students', 'desc');
                break;
            case 'top_rated':
                $query->orderBy('average_rating', 'desc');
                break;
            default:
                $query->latest('created_at');
        }

        // Get active categories with course counts
        $categories = Category::active()
            ->withCount('courses')
            ->orderBy('sort_order')
            ->get()
            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'count' => $category->courses_count,
                    'icon' => $category->icon_class,
                ];
            });

        // Get course counts for stats
        $freeCoursesCount = Course::published()->free()->count();
        $paidCoursesCount = Course::published()->paid()->count();

        // Paginate results (12 per page)
        $perPage = 12;
        $paginatedCourses = $query->paginate($perPage);

        // Add query parameters to pagination links
        $paginatedCourses->appends($request->query());

        // Check if user has active subscription
        $hasActiveSubscription = Auth::check() ? Auth::user()->has_active_subscription : false;

        return view('courses', compact(
            'paginatedCourses', 
            'categories', 
            'filters', 
            'freeCoursesCount', 
            'paidCoursesCount',
            'hasActiveSubscription'
        ));
    }

    /**
     * Filter courses via AJAX
     */
    public function filter(Request $request)
    {
        try {
            $filters = [
                'keyword' => $request->input('keyword', ''),
                'categories' => $request->input('categories', []),
                'price' => $request->input('price', []),
                'sort' => $request->input('sort', 'newest_first'),
            ];

            // Base query with relationships
            $query = Course::published()
                ->with(['category', 'instructor'])
                ->withCount('approvedRatings as reviews_count')
                ->withCount('students as total_students')
                ->withCount('lessons as lessons_count');

            // Apply filters (same logic as index method)
            if (!empty($filters['keyword'])) {
                $query->where(function ($q) use ($filters) {
                    $q->where('title', 'like', '%' . $filters['keyword'] . '%')
                        ->orWhere('description', 'like', '%' . $filters['keyword'] . '%')
                        ->orWhere('excerpt', 'like', '%' . $filters['keyword'] . '%');
                });
            }

            if (!empty($filters['categories'])) {
                $query->whereIn('category_id', $filters['categories']);
            }

            if (!empty($filters['price'])) {
                $query->where(function ($q) use ($filters) {
                    if (in_array('free', $filters['price'])) {
                        $q->orWhere('is_free', true);
                    }
                    if (in_array('paid', $filters['price'])) {
                        $q->orWhere('is_free', false);
                    }
                });
            }

            switch ($filters['sort']) {
                case 'newest_first':
                    $query->latest('created_at');
                    break;
                case 'oldest_first':
                    $query->oldest('created_at');
                    break;
                case 'course_title_az':
                    $query->orderBy('title', 'asc');
                    break;
                case 'course_title_za':
                    $query->orderBy('title', 'desc');
                    break;
                case 'popular':
                    $query->orderBy('total_students', 'desc');
                    break;
                case 'top_rated':
                    $query->orderBy('average_rating', 'desc');
                    break;
                default:
                    $query->latest('created_at');
            }

            // Get paginated results
            $courses = $query->paginate(12);

            // Check if user has active subscription for the response
            $hasActiveSubscription = Auth::check() ? Auth::user()->has_active_subscription : false;

            // Generate HTML for response
            $html = view('partials.course-list', [
                'courses' => $courses,
                'hasActiveSubscription' => $hasActiveSubscription
            ])->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'count' => $courses->total(),
                'pagination' => (string) $courses->links()
            ]);
        } catch (\Exception $e) {
            Log::error('Course filter error: ' . $e->getMessage() . ' in ' . $e->getFile() . ' at line ' . $e->getLine());
            
            return response()->json([
                'success' => false,
                'message' => 'Error filtering courses: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified course
     */
    public function show($slug)
    {
        try {
            $course = Course::published()
                ->with([
                    'category',
                    'instructor',
                    'approvedRatings' => function($query) {
                        $query->with('user')->latest();
                    },
                    'sections' => function($query) {
                        $query->orderBy('sort_order');
                    },
                    'sections.lessons' => function($query) {
                        $query->orderBy('sort_order');
                    }
                ])
                ->withCount('approvedRatings as reviews_count')
                ->withCount('students as total_students')
                ->withCount('lessons as lessons_count')
                ->where('slug', $slug)
                ->firstOrFail();

            // Get rating distribution
            $ratingDistribution = [
                5 => $course->approvedRatings()->where('rating', 5)->count(),
                4 => $course->approvedRatings()->where('rating', 4)->count(),
                3 => $course->approvedRatings()->where('rating', 3)->count(),
                2 => $course->approvedRatings()->where('rating', 2)->count(),
                1 => $course->approvedRatings()->where('rating', 1)->count(),
            ];

            // Calculate average rating
            $totalRatings = array_sum($ratingDistribution);
            $weightedSum = 0;
            foreach ($ratingDistribution as $rating => $count) {
                $weightedSum += $rating * $count;
            }
            $course->average_rating = $totalRatings > 0 ? round($weightedSum / $totalRatings, 1) : 0;

            // Get related courses (same category, excluding current)
            $relatedCourses = Course::published()
                ->with(['category', 'instructor'])
                ->withCount('approvedRatings as reviews_count')
                ->withCount('students as total_students')
                ->withCount('lessons as lessons_count')
                ->where('category_id', $course->category_id)
                ->where('id', '!=', $course->id)
                ->latest('created_at')
                ->take(3)
                ->get();

            // Check if user is enrolled
            $isEnrolled = false;
            $hasActiveSubscription = false;
            
            if (Auth::check()) {
                $isEnrolled = $course->students()->where('user_id', Auth::id())->exists();
                $hasActiveSubscription = Auth::user()->has_active_subscription;
            }

            return view('course-single', compact('course', 'relatedCourses', 'ratingDistribution', 'isEnrolled', 'hasActiveSubscription'));
            
        } catch (\Exception $e) {
            Log::error('Course show error: ' . $e->getMessage());
            abort(404, 'Course not found');
        }
    }

    /**
     * Display courses by category
     */
    public function category($slug)
    {
        try {
            $category = Category::where('slug', $slug)
                ->active()
                ->firstOrFail();

            $filters = [
                'sort' => request()->input('sort', 'newest_first'),
            ];

            $query = Course::published()
                ->with(['category', 'instructor'])
                ->withCount('approvedRatings as reviews_count')
                ->withCount('students as total_students')
                ->withCount('lessons as lessons_count')
                ->where('category_id', $category->id);

            // Apply sorting
            switch ($filters['sort']) {
                case 'newest_first':
                    $query->latest('created_at');
                    break;
                case 'oldest_first':
                    $query->oldest('created_at');
                    break;
                case 'course_title_az':
                    $query->orderBy('title', 'asc');
                    break;
                case 'course_title_za':
                    $query->orderBy('title', 'desc');
                    break;
                case 'popular':
                    $query->orderBy('total_students', 'desc');
                    break;
                case 'top_rated':
                    $query->orderBy('average_rating', 'desc');
                    break;
                default:
                    $query->latest('created_at');
            }

            $courses = $query->paginate(12);

            // Get all categories for sidebar
            $categories = Category::active()
                ->withCount('courses')
                ->orderBy('sort_order')
                ->get();

            return view('courses-category', compact('courses', 'category', 'categories', 'filters'));

        } catch (\Exception $e) {
            Log::error('Course category error: ' . $e->getMessage());
            abort(404, 'Category not found');
        }
    }

    /**
     * Get course rating summary
     */
    public function getRatingSummary($courseId)
    {
        try {
            $course = Course::findOrFail($courseId);

            $ratingDistribution = [
                5 => $course->approvedRatings()->where('rating', 5)->count(),
                4 => $course->approvedRatings()->where('rating', 4)->count(),
                3 => $course->approvedRatings()->where('rating', 3)->count(),
                2 => $course->approvedRatings()->where('rating', 2)->count(),
                1 => $course->approvedRatings()->where('rating', 1)->count(),
            ];

            $totalRatings = array_sum($ratingDistribution);
            $weightedSum = 0;
            foreach ($ratingDistribution as $rating => $count) {
                $weightedSum += $rating * $count;
            }
            $average = $totalRatings > 0 ? round($weightedSum / $totalRatings, 1) : 0;

            $summary = [
                'average' => $average,
                'total' => $totalRatings,
                'distribution' => $ratingDistribution
            ];

            return response()->json($summary);
            
        } catch (\Exception $e) {
            Log::error('Get rating summary error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error getting rating summary'
            ], 500);
        }
    }

    /**
     * Get course reviews
     */
    public function getReviews($courseId)
    {
        try {
            $course = Course::findOrFail($courseId);

            $reviews = $course->approvedRatings()
                ->with('user')
                ->latest()
                ->paginate(10);

            return response()->json($reviews);
            
        } catch (\Exception $e) {
            Log::error('Get reviews error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error getting reviews'
            ], 500);
        }
    }

    /**
     * Rate a course
     */
    public function rate(Request $request, $courseId)
    {
        try {
            $request->validate([
                'rating' => 'required|integer|min:1|max:5',
                'review' => 'nullable|string|max:1000'
            ]);

            $course = Course::findOrFail($courseId);
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please login to rate this course'
                ], 401);
            }

            // Check if user is enrolled
            if (!$course->students()->where('user_id', $user->id)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You must be enrolled in this course to rate it'
                ], 403);
            }

            // Create or update rating
            $rating = $course->ratings()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'rating' => $request->rating,
                    'review' => $request->review,
                    'is_approved' => false // Require admin approval
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Thank you for your rating! It will be visible after admin approval.',
                'rating' => $rating
            ]);

        } catch (\Exception $e) {
            Log::error('Rate course error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error submitting rating: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Complete or incomplete a lesson
     */
    public function completeLesson(Request $request, $lessonId)
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please login to mark lessons as complete'
                ], 401);
            }

            $request->validate([
                'completed' => 'required|boolean'
            ]);

            $lesson = Lesson::with('section.course')->findOrFail($lessonId);
            $course = $lesson->section->course;
            
            // Check if user is enrolled in the course
            if (!$course->students()->where('user_id', $user->id)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You must be enrolled in this course to mark lessons as complete'
                ], 403);
            }

            $completed = $request->completed;

            if ($completed) {
                // Mark as completed
                $lesson->markAsCompleted($user->id);
                $message = 'Lesson marked as completed';
            } else {
                // Mark as incomplete
                LessonProgress::where('user_id', $user->id)
                    ->where('lesson_id', $lessonId)
                    ->delete();
                
                // Update enrollment progress
                $totalLessons = $course->lessons()->count();
                $completedLessons = LessonProgress::where('user_id', $user->id)
                    ->where('course_id', $course->id)
                    ->where('status', 'completed')
                    ->count();
                
                $progress = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;
                
                Enrollment::where('user_id', $user->id)
                    ->where('course_id', $course->id)
                    ->update([
                        'progress' => $progress,
                        'completed_at' => $progress >= 100 ? now() : null
                    ]);
                
                $message = 'Lesson marked as incomplete';
            }

            // Get updated progress
            $totalLessons = $course->lessons()->count();
            $completedLessons = LessonProgress::where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->where('status', 'completed')
                ->count();
            
            $overallProgress = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;

            // Check if all lessons are completed and generate certificate
            $certificate = null;
            if ($overallProgress >= 100) {
                // Check if certificate already exists
                $existingCertificate = Certificate::where('user_id', $user->id)
                    ->where('course_id', $course->id)
                    ->first();

                if (!$existingCertificate) {
                    // Get the enrollment
                    $enrollment = Enrollment::where('user_id', $user->id)
                        ->where('course_id', $course->id)
                        ->first();

                    if ($enrollment) {
                        // Generate unique certificate number
                        $certificateNumber = $this->generateCertificateNumber($user, $course);

                        // Create certificate
                        $certificate = Certificate::create([
                            'user_id' => $user->id,
                            'course_id' => $course->id,
                            'enrollment_id' => $enrollment->id,
                            'certificate_number' => $certificateNumber,
                            'issue_date' => now(),
                            'expiry_date' => $enrollment->expiry_date,
                        ]);

                        // Update enrollment to mark certificate as generated
                        $enrollment->update([
                            'certificate_generated' => 1,
                            'completed_at' => now()
                        ]);
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'completed' => $completed,
                'progress' => $overallProgress,
                'completed_count' => $completedLessons,
                'total_lessons' => $totalLessons,
                'certificate_generated' => $certificate ? true : false,
                'certificate_url' => $certificate ? route('certificates.show', $certificate->id) : null
            ]);

        } catch (\Exception $e) {
            Log::error('Complete lesson error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error updating lesson progress: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate unique certificate number
     */
    private function generateCertificateNumber($user, $course)
    {
        $prefix = 'EDU';
        $year = now()->year;
        $month = now()->format('m');
        $userId = str_pad($user->id, 4, '0', STR_PAD_LEFT);
        $courseId = str_pad($course->id, 4, '0', STR_PAD_LEFT);
        $random = strtoupper(Str::random(4));
        
        $number = "{$prefix}-{$year}{$month}-{$userId}-{$courseId}-{$random}";
        
        // Ensure uniqueness
        while (Certificate::where('certificate_number', $number)->exists()) {
            $random = strtoupper(Str::random(4));
            $number = "{$prefix}-{$year}{$month}-{$userId}-{$courseId}-{$random}";
        }
        
        return $number;
    }

    /**
     * Get lesson data for AJAX requests
     */
    public function getLessonData($lessonId)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
            }

            $lesson = Lesson::with('section.course')->findOrFail($lessonId);
            
            // Check if user has access
            if (!$lesson->section->course->canUserAccess($user->id)) {
                return response()->json(['success' => false, 'message' => 'No access'], 403);
            }

            // Get user progress for this lesson
            $progress = LessonProgress::where('user_id', $user->id)
                ->where('lesson_id', $lessonId)
                ->first();

            return response()->json([
                'success' => true,
                'lesson' => [
                    'id' => $lesson->id,
                    'title' => $lesson->title,
                    'content' => $lesson->content,
                    'video_url' => $lesson->video_url_full,
                    'video_type' => $lesson->video_type,
                    'duration' => $lesson->duration_formatted,
                    'attachment' => $lesson->attachment_url,
                    'is_completed' => $lesson->is_completed,
                    'progress' => $progress ? $progress->progress : 0,
                    'last_position' => $progress ? $progress->last_position : 0
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Get lesson data error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error loading lesson data'
            ], 500);
        }
    }

    /**
     * Update video progress
     */
    public function updateLessonProgress(Request $request, $lessonId)
    {
        try {
            $request->validate([
                'seconds' => 'required|numeric|min:0'
            ]);

            $user = Auth::user();
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
            }

            $lesson = Lesson::findOrFail($lessonId);
            
            $progress = $lesson->updateProgress($request->seconds, $user->id);

            return response()->json([
                'success' => true,
                'progress' => $progress->progress,
                'status' => $progress->status
            ]);

        } catch (\Exception $e) {
            Log::error('Update lesson progress error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error updating progress'
            ], 500);
        }
    }

    /**
     * Learning page for enrolled courses
     */
    public function learn($slug)
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return redirect()->route('login');
            }

            $course = Course::where('slug', $slug)
                ->with([
                    'sections' => function($query) {
                        $query->orderBy('sort_order');
                    },
                    'sections.lessons' => function($query) {
                        $query->orderBy('sort_order');
                    }
                ])
                ->firstOrFail();

            // Check if user can access this course
            if (!$course->canUserAccess($user->id)) {
                if (!$course->is_free && !$user->has_active_subscription) {
                    return redirect()->route('subscription.plans')
                        ->with('error', 'This course requires an active subscription. Please purchase a subscription to access.');
                }
                return redirect()->route('courses.show', $course->slug)
                    ->with('error', 'You do not have access to this course.');
            }

            // Get or create enrollment
            $enrollment = Enrollment::where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->first();

            if (!$enrollment) {
                // Create enrollment automatically if user has subscription
                $enrollment = Enrollment::create([
                    'user_id' => $user->id,
                    'course_id' => $course->id,
                    'access_type' => 'subscription',
                    'enrollment_date' => now(),
                    'expiry_date' => $user->active_subscription->end_date ?? null,
                    'status' => 'active',
                    'progress' => 0
                ]);
                $course->increment('total_students');
            }

            // Get user's completed lessons
            $completedLessons = LessonProgress::where('user_id', $user->id)
                ->whereIn('lesson_id', $course->lessons()->pluck('id'))
                ->where('status', 'completed')
                ->pluck('lesson_id')
                ->toArray();

            // Get current lesson from session or first incomplete lesson
            $currentLesson = null;
            if (session()->has('current_lesson_' . $course->id)) {
                $currentLessonId = session('current_lesson_' . $course->id);
                $currentLesson = $course->lessons->firstWhere('id', $currentLessonId);
            }
            
            if (!$currentLesson) {
                // Find first incomplete lesson
                foreach ($course->sections as $section) {
                    foreach ($section->lessons as $lesson) {
                        if (!in_array($lesson->id, $completedLessons)) {
                            $currentLesson = $lesson;
                            break 2;
                        }
                    }
                }
                
                // If all completed, get last lesson
                if (!$currentLesson && $course->lessons->isNotEmpty()) {
                    $currentLesson = $course->lessons->last();
                }
            }

            // Calculate stats
            $totalLessonsCount = $course->lessons()->count();
            $completedLessonsCount = count($completedLessons);
            
            // Calculate total time spent (simplified - you can enhance this)
            $totalTimeSpent = '0h';

            return view('course-learning', compact(
                'course', 
                'enrollment', 
                'completedLessons',
                'currentLesson',
                'totalLessonsCount',
                'completedLessonsCount',
                'totalTimeSpent'
            ));

        } catch (\Exception $e) {
            Log::error('Course learn error: ' . $e->getMessage());
            abort(404, 'Course not found');
        }
    }
}