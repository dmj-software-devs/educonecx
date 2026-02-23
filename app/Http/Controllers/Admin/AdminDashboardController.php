<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\Order;
use App\Models\Enrollment;
use App\Models\Review;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    /**
     * Show admin dashboard with real data
     */
    public function index()
    {
        // Get statistics
        $totalUsers = User::count();
        $totalStudents = User::where('role', 'student')->count();
        $totalInstructors = User::where('role', 'instructor')->count();
        $totalCourses = Course::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total');

        // Get recent data
        $recentUsers = User::latest()
            ->take(5)
            ->get();

        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        $recentCourses = Course::with('instructor')
            ->latest()
            ->take(5)
            ->get();

        // Get chart data for last 30 days
        $ordersChartData = $this->getOrdersChartData();
        $enrollmentsChartData = $this->getEnrollmentsChartData();

        // Get course statistics
        $popularCourses = Course::withCount('enrollments')
            ->orderBy('enrollments_count', 'desc')
            ->take(5)
            ->get();

        $topRatedCourses = Course::withAvg('reviews as avg_rating', 'rating')
            ->having('avg_rating', '>', 0)
            ->orderBy('avg_rating', 'desc')
            ->take(5)
            ->get();

        // Get user statistics
        $newUsersToday = User::whereDate('created_at', today())->count();
        $activeEnrollments = Enrollment::where('status', 'active')->count();
        $completedCourses = Enrollment::whereNotNull('completed_at')->count();

        // Get revenue statistics
        $revenueToday = Order::whereDate('created_at', today())
            ->where('payment_status', 'paid')
            ->sum('total');

        $revenueThisMonth = Order::whereMonth('created_at', now()->month)
            ->where('payment_status', 'paid')
            ->sum('total');

        $pendingOrders = Order::where('payment_status', 'pending')->count();

        // Get recent reviews
        $recentReviews = Review::with(['user', 'course'])
            ->latest()
            ->take(5)
            ->get();

        // Get quiz statistics
        $totalQuizAttempts = QuizAttempt::count();
        $passedQuizzes = QuizAttempt::where('passed', true)->count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalStudents',
            'totalInstructors',
            'totalCourses',
            'totalOrders',
            'totalRevenue',
            'recentUsers',
            'recentOrders',
            'recentCourses',
            'ordersChartData',
            'enrollmentsChartData',
            'popularCourses',
            'topRatedCourses',
            'newUsersToday',
            'activeEnrollments',
            'completedCourses',
            'revenueToday',
            'revenueThisMonth',
            'pendingOrders',
            'recentReviews',
            'totalQuizAttempts',
            'passedQuizzes'
        ));
    }

    /**
     * Get orders chart data for last 30 days
     */
    private function getOrdersChartData()
    {
        $data = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count'),
            DB::raw('SUM(CASE WHEN payment_status = "paid" THEN total ELSE 0 END) as revenue')
        )
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $labels = [];
        $orderCounts = [];
        $revenues = [];

        foreach ($data as $item) {
            $labels[] = $item->date;
            $orderCounts[] = $item->count;
            $revenues[] = $item->revenue;
        }

        return [
            'labels' => $labels,
            'orders' => $orderCounts,
            'revenues' => $revenues
        ];
    }

    /**
     * Get enrollments chart data for last 30 days
     */
    private function getEnrollmentsChartData()
    {
        $data = Enrollment::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $labels = [];
        $enrollments = [];

        foreach ($data as $item) {
            $labels[] = $item->date;
            $enrollments[] = $item->count;
        }

        return [
            'labels' => $labels,
            'enrollments' => $enrollments
        ];
    }

    /**
     * Show analytics page
     */
    public function analytics()
    {
        // Get detailed analytics data
        $usersByRole = User::select('role', DB::raw('COUNT(*) as count'))
            ->groupBy('role')
            ->get();

        $coursesByLevel = Course::select('level', DB::raw('COUNT(*) as count'))
            ->groupBy('level')
            ->get();

        $coursesByStatus = Course::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();

        $ordersByStatus = Order::select('payment_status', DB::raw('COUNT(*) as count'))
            ->groupBy('payment_status')
            ->get();

        $monthlyRevenue = Order::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total) as total')
        )
            ->where('payment_status', 'paid')
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        $popularCategories = Course::select('category_id', DB::raw('COUNT(*) as count'))
            ->with('category')
            ->groupBy('category_id')
            ->orderBy('count', 'desc')
            ->take(10)
            ->get();

        return view('admin.analytics', compact(
            'usersByRole',
            'coursesByLevel',
            'coursesByStatus',
            'ordersByStatus',
            'monthlyRevenue',
            'popularCategories'
        ));
    }
}
