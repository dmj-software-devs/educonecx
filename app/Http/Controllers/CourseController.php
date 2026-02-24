<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        // Base query with relationships - FIXED: removed 'reviews' and added proper relationship counts
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
                    $q->orWhere('price', 0)
                        ->orWhere(function ($q2) {
                            $q2->whereNotNull('sale_price')
                                ->where('sale_price', 0);
                        });
                }
                if (in_array('paid', $filters['price'])) {
                    $q->orWhere('price', '>', 0)
                        ->where(function ($q2) {
                            $q2->whereNull('sale_price')
                                ->orWhere('sale_price', '>', 0);
                        });
                }
            });
        }

        // Apply sorting
        switch ($filters['sort']) {
            case 'newest_first':
                $query->latest('published_at');
                break;
            case 'oldest_first':
                $query->oldest('published_at');
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
                $query->latest('published_at');
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

        // Paginate results (12 per page)
        $perPage = 12;
        $paginatedCourses = $query->paginate($perPage);

        // Add query parameters to pagination links
        $paginatedCourses->appends($request->query());

        return view('courses', compact('paginatedCourses', 'categories', 'filters'));
    }

    /**
     * Filter courses via AJAX
     */
    public function filter(Request $request)
    {
        $filters = [
            'keyword' => $request->input('keyword', ''),
            'categories' => $request->input('categories', []),
            'price' => $request->input('price', []),
            'sort' => $request->input('sort', 'newest_first'),
        ];

        // Base query with relationships - FIXED: removed 'reviews' and added proper relationship counts
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
                    $q->orWhere('price', 0)
                        ->orWhere(function ($q2) {
                            $q2->whereNotNull('sale_price')
                                ->where('sale_price', 0);
                        });
                }
                if (in_array('paid', $filters['price'])) {
                    $q->orWhere('price', '>', 0)
                        ->where(function ($q2) {
                            $q2->whereNull('sale_price')
                                ->orWhere('sale_price', '>', 0);
                        });
                }
            });
        }

        switch ($filters['sort']) {
            case 'newest_first':
                $query->latest('published_at');
                break;
            case 'oldest_first':
                $query->oldest('published_at');
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
                $query->latest('published_at');
        }

        // Get paginated results
        $courses = $query->paginate(12);

        // Generate HTML for response
        $html = view('partials.course-list', ['courses' => $courses])->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => $courses->total(),
            'pagination' => (string) $courses->links()
        ]);
    }

    /**
     * Display the specified course
     */
    public function show($slug)
    {
        $course = Course::published()
            ->with([
                'category',
                'instructor',
                'approvedRatings.user',
                'sections.lessons'
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

        // Get related courses (same category, excluding current)
        $relatedCourses = Course::published()
            ->with(['category', 'instructor'])
            ->withCount('approvedRatings as reviews_count')
            ->withCount('students as total_students')
            ->withCount('lessons as lessons_count')
            ->where('category_id', $course->category_id)
            ->where('id', '!=', $course->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('course-single', compact('course', 'relatedCourses', 'ratingDistribution'));
    }

    /**
     * Display courses by category
     */
    public function category($slug)
    {
        $category = Category::where('slug', $slug)
            ->active()
            ->firstOrFail();

        $courses = Course::published()
            ->with(['category', 'instructor'])
            ->withCount('approvedRatings as reviews_count')
            ->withCount('students as total_students')
            ->withCount('lessons as lessons_count')
            ->where('category_id', $category->id)
            ->latest('published_at')
            ->paginate(12);

        // Get all categories for sidebar
        $categories = Category::active()
            ->withCount('courses')
            ->orderBy('sort_order')
            ->get();

        return view('courses-category', compact('courses', 'category', 'categories'));
    }

    /**
     * Get course rating summary
     */
    public function getRatingSummary($courseId)
    {
        $course = Course::findOrFail($courseId);

        $summary = [
            'average' => $course->average_rating,
            'total' => $course->total_reviews,
            'distribution' => [
                5 => $course->approvedRatings()->where('rating', 5)->count(),
                4 => $course->approvedRatings()->where('rating', 4)->count(),
                3 => $course->approvedRatings()->where('rating', 3)->count(),
                2 => $course->approvedRatings()->where('rating', 2)->count(),
                1 => $course->approvedRatings()->where('rating', 1)->count(),
            ]
        ];

        return response()->json($summary);
    }

    /**
     * Get course reviews
     */
    public function getReviews($courseId)
    {
        $course = Course::findOrFail($courseId);

        $reviews = $course->approvedRatings()
            ->with('user')
            ->latest()
            ->paginate(10);

        return response()->json($reviews);
    }
}
