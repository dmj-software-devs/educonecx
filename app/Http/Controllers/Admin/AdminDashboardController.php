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
use Carbon\Carbon;

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
    public function analytics(Request $request)
    {
        // Get date range from request or use defaults
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : now()->endOfMonth();

        // Your existing queries
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
            ->whereBetween('created_at', [$startDate, $endDate])
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

        // NEW: Add summary stats
        $totalRevenue = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('total');

        $totalOrders = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $newUsers = User::whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $completions = Enrollment::whereNotNull('completed_at')
            ->whereBetween('updated_at', [$startDate, $endDate])
            ->count();

        // NEW: Add completion rates data
        $completionRates = Course::select(
            'courses.id',
            'courses.title',
            DB::raw('COUNT(enrollments.id) as total_enrollments'),
            DB::raw('SUM(CASE WHEN enrollments.completed_at IS NOT NULL THEN 1 ELSE 0 END) as completions')
        )
            ->leftJoin('enrollments', 'courses.id', '=', 'enrollments.course_id')
            ->groupBy('courses.id', 'courses.title')
            ->orderBy('completions', 'desc')
            ->having('total_enrollments', '>', 0)
            ->take(10)
            ->get();

        // NEW: Add user growth data for chart
        $userGrowth = User::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total')
        )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        return view('admin.analytics', compact(
            'usersByRole',
            'coursesByLevel',
            'coursesByStatus',
            'ordersByStatus',
            'monthlyRevenue',
            'popularCategories',
            // New variables
            'totalRevenue',
            'totalOrders',
            'newUsers',
            'completions',
            'completionRates',
            'userGrowth',
            'startDate',
            'endDate'
        ));
    }

    // In App\Http\Controllers\Admin\AdminDashboardController.php

    /**
     * Export analytics data as CSV
     */
    public function export(Request $request)
    {
        // Get date range from request or use defaults
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : now()->endOfMonth();

        // Get data for export
        $usersByRole = User::select('role', DB::raw('COUNT(*) as count'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('role')
            ->get();

        $coursesByLevel = Course::select('level', DB::raw('COUNT(*) as count'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('level')
            ->get();

        $ordersByStatus = Order::select('payment_status', DB::raw('COUNT(*) as count'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('payment_status')
            ->get();

        $monthlyRevenue = Order::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('SUM(total) as total')
        )
            ->where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Generate CSV
        $filename = "analytics-export-{$startDate->format('Y-m-d')}-{$endDate->format('Y-m-d')}.csv";

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($usersByRole, $coursesByLevel, $ordersByStatus, $monthlyRevenue, $startDate, $endDate) {
            $file = fopen('php://output', 'w');

            // Add header
            fputcsv($file, ['Analytics Export', $startDate->format('Y-m-d') . ' to ' . $endDate->format('Y-m-d')]);
            fputcsv($file, []); // Empty line

            // Users by Role
            fputcsv($file, ['USERS BY ROLE']);
            fputcsv($file, ['Role', 'Count']);
            foreach ($usersByRole as $item) {
                fputcsv($file, [$item->role, $item->count]);
            }
            fputcsv($file, []); // Empty line

            // Courses by Level
            fputcsv($file, ['COURSES BY LEVEL']);
            fputcsv($file, ['Level', 'Count']);
            foreach ($coursesByLevel as $item) {
                fputcsv($file, [$item->level, $item->count]);
            }
            fputcsv($file, []); // Empty line

            // Orders by Status
            fputcsv($file, ['ORDERS BY STATUS']);
            fputcsv($file, ['Status', 'Count']);
            foreach ($ordersByStatus as $item) {
                fputcsv($file, [$item->payment_status, $item->count]);
            }
            fputcsv($file, []); // Empty line

            // Monthly Revenue
            fputcsv($file, ['MONTHLY REVENUE']);
            fputcsv($file, ['Month', 'Revenue']);
            foreach ($monthlyRevenue as $item) {
                fputcsv($file, [$item->month, '$' . number_format($item->total, 2)]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
