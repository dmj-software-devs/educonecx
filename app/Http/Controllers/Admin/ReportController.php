<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Course;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Show reports dashboard.
     */
    public function index()
    {
        return view('admin.reports.index');
    }

    /**
     * Sales report.
     */
    public function sales(Request $request)
    {
        $startDate = $request->start_date ?? now()->startOfMonth();
        $endDate = $request->end_date ?? now()->endOfMonth();

        $orders = Order::with('items.course')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('payment_status', 'paid')
            ->get();

        $totalRevenue = $orders->sum('total');
        $totalOrders = $orders->count();
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        // Daily sales
        $dailySales = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count'),
            DB::raw('SUM(total) as total')
        )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('payment_status', 'paid')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Top selling courses
        $topCourses = Course::select('courses.id', 'courses.title')
            ->selectRaw('COUNT(order_items.id) as total_sales')
            ->selectRaw('SUM(order_items.total) as total_revenue')
            ->join('order_items', 'courses.id', '=', 'order_items.course_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->where('orders.payment_status', 'paid')
            ->groupBy('courses.id', 'courses.title')
            ->orderBy('total_revenue', 'desc')
            ->take(10)
            ->get();

        return view('admin.reports.sales', compact(
            'startDate',
            'endDate',
            'totalRevenue',
            'totalOrders',
            'averageOrderValue',
            'dailySales',
            'topCourses'
        ));
    }

    /**
     * Students report.
     */
    public function students(Request $request)
    {
        $startDate = $request->start_date ?? now()->startOfMonth();
        $endDate = $request->end_date ?? now()->endOfMonth();

        // New registrations
        $newStudents = User::where('role', 'student')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        // Total students
        $totalStudents = User::where('role', 'student')->count();

        // Active students (with enrollments in last 30 days)
        $activeStudents = User::where('role', 'student')
            ->whereHas('enrollments', function ($q) {
                $q->where('last_accessed', '>=', now()->subDays(30));
            })
            ->count();

        // Student growth by month
        $studentGrowth = User::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
            ->where('role', 'student')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->take(12)
            ->get();

        // Top students by course completions
        $topStudents = User::select('users.id', 'users.name', 'users.email')
            ->selectRaw('COUNT(enrollments.id) as total_enrollments')
            ->selectRaw('SUM(CASE WHEN enrollments.completed_at IS NOT NULL THEN 1 ELSE 0 END) as completions')
            ->join('enrollments', 'users.id', '=', 'enrollments.user_id')
            ->where('users.role', 'student')
            ->groupBy('users.id', 'users.name', 'users.email')
            ->orderBy('completions', 'desc')
            ->take(20)
            ->get();

        return view('admin.reports.students', compact(
            'startDate',
            'endDate',
            'newStudents',
            'totalStudents',
            'activeStudents',
            'studentGrowth',
            'topStudents'
        ));
    }

    /**
     * Courses report.
     */
    public function courses(Request $request)
    {
        $startDate = $request->start_date ?? now()->startOfMonth();
        $endDate = $request->end_date ?? now()->endOfMonth();

        $courses = Course::withCount(['enrollments', 'reviews'])
            ->withAvg('reviews as avg_rating', 'rating')
            ->where('status', 'published')
            ->get();

        $totalCourses = $courses->count();
        $totalEnrollments = $courses->sum('enrollments_count');
        $averageRating = $courses->avg('avg_rating');

        // Most popular courses
        $popularCourses = Course::withCount('enrollments')
            ->where('status', 'published')
            ->orderBy('enrollments_count', 'desc')
            ->take(10)
            ->get();

        // Highest rated courses
        $topRatedCourses = Course::withAvg(['reviews' => function ($query) {
            $query->where('status', 'approved');
        }], 'rating')
            ->where('status', 'published')
            ->having('reviews_avg_rating', '>', 0)
            ->orderBy('reviews_avg_rating', 'desc')
            ->take(10)
            ->get();

        return view('admin.reports.courses', compact(
            'startDate',
            'endDate',
            'totalCourses',
            'totalEnrollments',
            'averageRating',
            'popularCourses',
            'topRatedCourses'
        ));
    }

    /**
     * Quizzes report.
     */
    public function quizzes(Request $request)
    {
        $startDate = $request->start_date ?? now()->startOfMonth();
        $endDate = $request->end_date ?? now()->endOfMonth();

        $quizzes = Quiz::withCount('attempts')
            ->withAvg('attempts as avg_score', 'percentage')
            ->get();

        $totalQuizzes = $quizzes->count();
        $totalAttempts = $quizzes->sum('attempts_count');
        $averageScore = $quizzes->avg('avg_score');

        // Most attempted quizzes
        $popularQuizzes = Quiz::withCount('attempts')
            ->orderBy('attempts_count', 'desc')
            ->take(10)
            ->get();

        // Quizzes with highest pass rates
        $quizPassRates = Quiz::withCount(['attempts as attempts' => function ($query) {
            $query->where('status', 'completed');
        }])
            ->withCount(['attempts as passes' => function ($query) {
                $query->where('status', 'completed')
                    ->where('passed', 1);
            }])
            ->having('attempts', '>', 0)
            ->get()
            ->map(function ($quiz) {
                $quiz->pass_rate = $quiz->attempts > 0
                    ? round(($quiz->passes / $quiz->attempts) * 100, 2)
                    : 0;
                return $quiz;
            })
            ->sortByDesc('pass_rate')
            ->take(10)
            ->values();

        return view('admin.reports.quizzes', compact(
            'startDate',
            'endDate',
            'totalQuizzes',
            'totalAttempts',
            'averageScore',
            'popularQuizzes',
            'quizPassRates'
        ));
    }

    /**
     * Export report.
     */
    // In App\Http\Controllers\Admin\ReportController.php
    public function export($type, $format)
    {
        switch ($type) {
            case 'analytics':
                // Redirect to analytics export or handle here
                return app(AdminDashboardController::class)->export(request());
            case 'sales':
                // Handle sales export
                break;
            case 'students':
                // Handle students export
                break;
            case 'courses':
                // Handle courses export
                break;
            case 'quizzes':
                // Handle quizzes export
                break;
            default:
                return back()->with('error', 'Invalid export type');
        }

        return back()->with('info', 'Export functionality coming soon.');
    }
}
