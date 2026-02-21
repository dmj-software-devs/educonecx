<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class CourseController extends Controller
{
    /**
     * Sample course data - In a real application, this would come from a database
     */
    private function getCourses()
    {
        return [
            [
                'id' => 1,
                'title' => 'Smartphone Videography Masterclass',
                'slug' => 'smartphone-videography-masterclass',
                'excerpt' => 'Learn professional video creation using just your smartphone.',
                'description' => 'Master the art of creating professional videos using only your smartphone. This comprehensive course covers lighting, composition, audio, and editing techniques.',
                'price' => 22.00,
                'sale_price' => null,
                'thumbnail' => 'https://via.placeholder.com/400x225',
                'categories' => [42],
                'category_names' => ['Videography'],
                'instructor' => 'EDUCONECX ACADEMY',
                'instructor_avatar' => 'EA',
                'students_count' => 0,
                'rating' => 0,
                'reviews_count' => 0,
                'featured' => true,
                'created_at' => '2026-01-15',
            ],
            [
                'id' => 2,
                'title' => 'Comment Bâtir Une Entreprise Familiale Internationale Très Rentable',
                'slug' => 'comment-batir-une-entreprise-familiale-internationale-tres-rentable',
                'excerpt' => 'Learn how to build a profitable international family business.',
                'description' => 'Discover the strategies and techniques to build and scale a profitable international family business. Learn from real-world examples and expert insights.',
                'price' => 22.00,
                'sale_price' => null,
                'thumbnail' => 'https://via.placeholder.com/400x225',
                'categories' => [8],
                'category_names' => ['Business & Finance'],
                'instructor' => 'EDUCONECX ACADEMY',
                'instructor_avatar' => 'EA',
                'students_count' => 3,
                'rating' => 0,
                'reviews_count' => 0,
                'featured' => false,
                'created_at' => '2026-01-10',
            ],
            [
                'id' => 3,
                'title' => 'LE SYSTÈME DE RÉUSSITE CANVA',
                'slug' => 'le-systeme-de-reussite-canva',
                'excerpt' => 'Master Canva and create stunning professional designs.',
                'description' => 'Learn the complete Canva system to create professional designs for social media, marketing, and business. From basics to advanced techniques.',
                'price' => 22.00,
                'sale_price' => null,
                'thumbnail' => 'https://via.placeholder.com/400x225',
                'categories' => [7],
                'category_names' => ['Digital Skills & Technology'],
                'instructor' => 'EDUCONECX ACADEMY',
                'instructor_avatar' => 'EA',
                'students_count' => 0,
                'rating' => 0,
                'reviews_count' => 0,
                'featured' => false,
                'created_at' => '2026-01-05',
            ],
            [
                'id' => 4,
                'title' => 'The Canva Success System',
                'slug' => 'canva-success-system',
                'excerpt' => 'Master Canva and create stunning professional designs.',
                'description' => 'A comprehensive guide to mastering Canva for business and personal projects. Learn design principles, templates, and advanced features.',
                'price' => 22.00,
                'sale_price' => null,
                'thumbnail' => 'https://via.placeholder.com/400x225',
                'categories' => [7],
                'category_names' => ['Digital Skills & Technology'],
                'instructor' => 'EDUCONECX ACADEMY',
                'instructor_avatar' => 'EA',
                'students_count' => 6,
                'rating' => 0,
                'reviews_count' => 0,
                'featured' => true,
                'created_at' => '2026-01-01',
            ],
        ];
    }

    /**
     * Get course categories
     */
    private function getCategories()
    {
        return [
            ['id' => 8, 'name' => 'Business & Finance', 'slug' => 'business-finance', 'count' => 1],
            ['id' => 7, 'name' => 'Digital Skills & Technology', 'slug' => 'digital-skills-technology', 'count' => 2],
            ['id' => 9, 'name' => 'Personal Growth & Mindset', 'slug' => 'personal-growth-mindset', 'count' => 0],
            ['id' => 42, 'name' => 'Videography', 'slug' => 'videography', 'count' => 1],
        ];
    }

    /**
     * Display a listing of courses
     */
    public function index(Request $request)
    {
        $courses = $this->getCourses();
        $categories = $this->getCategories();
        
        // Get filter parameters
        $filters = [
            'keyword' => $request->input('keyword', ''),
            'categories' => $request->input('categories', []),
            'price' => $request->input('price', []),
            'sort' => $request->input('sort', 'newest_first'),
        ];

        // Filter courses based on criteria
        $filteredCourses = $this->filterCourses($courses, $filters);
        
        // Sort courses
        $filteredCourses = $this->sortCourses($filteredCourses, $filters['sort']);
        
        // Paginate results (12 per page as in WordPress)
        $perPage = 12;
        $currentPage = $request->input('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        
        $paginatedCourses = new LengthAwarePaginator(
            array_slice($filteredCourses, $offset, $perPage),
            count($filteredCourses),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('courses', compact('paginatedCourses', 'categories', 'filters'));
    }

    /**
     * Filter courses based on criteria
     */
    private function filterCourses($courses, $filters)
    {
        return array_filter($courses, function ($course) use ($filters) {
            // Filter by keyword
            if (!empty($filters['keyword'])) {
                $keyword = strtolower($filters['keyword']);
                $titleMatch = strpos(strtolower($course['title']), $keyword) !== false;
                $descMatch = strpos(strtolower($course['description']), $keyword) !== false;
                if (!$titleMatch && !$descMatch) {
                    return false;
                }
            }

            // Filter by categories
            if (!empty($filters['categories'])) {
                $categoryMatch = false;
                foreach ($filters['categories'] as $catId) {
                    if (in_array($catId, $course['categories'])) {
                        $categoryMatch = true;
                        break;
                    }
                }
                if (!$categoryMatch) {
                    return false;
                }
            }

            // Filter by price
            if (!empty($filters['price'])) {
                if (in_array('free', $filters['price']) && $course['price'] > 0) {
                    return false;
                }
                if (in_array('paid', $filters['price']) && $course['price'] == 0) {
                    return false;
                }
            }

            return true;
        });
    }

    /**
     * Sort courses
     */
    private function sortCourses($courses, $sortBy)
    {
        usort($courses, function ($a, $b) use ($sortBy) {
            switch ($sortBy) {
                case 'newest_first':
                    return strtotime($b['created_at']) - strtotime($a['created_at']);
                case 'oldest_first':
                    return strtotime($a['created_at']) - strtotime($b['created_at']);
                case 'course_title_az':
                    return strcmp($a['title'], $b['title']);
                case 'course_title_za':
                    return strcmp($b['title'], $a['title']);
                default:
                    return 0;
            }
        });

        return $courses;
    }

    /**
     * Filter courses via AJAX
     */
    public function filter(Request $request)
    {
        $courses = $this->getCourses();
        
        $filters = [
            'keyword' => $request->input('keyword', ''),
            'categories' => $request->input('categories', []),
            'price' => $request->input('price', []),
            'sort' => $request->input('sort', 'newest_first'),
        ];

        $filteredCourses = $this->filterCourses($courses, $filters);
        $filteredCourses = $this->sortCourses($filteredCourses, $filters['sort']);

        // Return HTML for AJAX response
        $html = view('partials.course-list', ['courses' => $filteredCourses])->render();
        
        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => count($filteredCourses)
        ]);
    }

    /**
     * Display the specified course
     */
    public function show($slug)
    {
        $courses = $this->getCourses();
        $course = collect($courses)->firstWhere('slug', $slug);
        
        if (!$course) {
            abort(404);
        }

        return view('course-single', compact('course'));
    }

    /**
     * Display courses by category
     */
    public function category($slug)
    {
        $categories = $this->getCategories();
        $category = collect($categories)->firstWhere('slug', $slug);
        
        if (!$category) {
            abort(404);
        }

        $courses = $this->getCourses();
        $filteredCourses = array_filter($courses, function ($course) use ($category) {
            return in_array($category['id'], $course['categories']);
        });

        return view('courses-category', [
            'courses' => $filteredCourses,
            'category' => $category,
            'allCategories' => $categories
        ]);
    }
}