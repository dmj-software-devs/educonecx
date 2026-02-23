@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Overview')

@section('content')
<!-- Welcome Section -->
<div class="welcome-section">
    <div class="welcome-content">
        <h2>Welcome back, {{ Auth::user()->name }}!</h2>
        <p>Here's what's happening with your platform today.</p>
    </div>
    <div class="welcome-actions">
        <a href="{{ route('admin.courses.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> New Course
        </a>
        <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-download"></i> Export Report
        </a>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row g-4">
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stats-card stats-card-primary">
            <div class="stats-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stats-content">
                <div class="stats-label">Total Users</div>
                <div class="stats-value">{{ number_format($totalUsers) }}</div>
                <div class="stats-change positive">
                    <i class="fas fa-arrow-up"></i> {{ $newUsersToday }} new today
                </div>
            </div>
            <div class="stats-footer">
                <a href="{{ route('admin.users.index') }}">View All Users <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stats-card stats-card-success">
            <div class="stats-icon">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div class="stats-content">
                <div class="stats-label">Total Courses</div>
                <div class="stats-value">{{ number_format($totalCourses) }}</div>
                <div class="stats-change neutral">
                    <i class="fas fa-star"></i> {{ $popularCourses->count() }} popular
                </div>
            </div>
            <div class="stats-footer">
                <a href="{{ route('admin.courses.index') }}">View All Courses <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stats-card stats-card-info">
            <div class="stats-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stats-content">
                <div class="stats-label">Total Orders</div>
                <div class="stats-value">{{ number_format($totalOrders) }}</div>
                <div class="stats-change warning">
                    <i class="fas fa-clock"></i> {{ $pendingOrders }} pending
                </div>
            </div>
            <div class="stats-footer">
                <a href="{{ route('admin.orders.index') }}">View All Orders <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stats-card stats-card-warning">
            <div class="stats-icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stats-content">
                <div class="stats-label">Total Revenue</div>
                <div class="stats-value">${{ number_format($totalRevenue, 2) }}</div>
                <div class="stats-change positive">
                    <i class="fas fa-calendar"></i> ${{ number_format($revenueToday, 2) }} today
                </div>
            </div>
            <div class="stats-footer">
                <a href="{{ route('admin.analytics') }}">View Analytics <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</div>

<!-- Secondary Metrics Row -->
<div class="row g-4 mt-2">
    <div class="col-xl-2 col-lg-4 col-md-4 col-6">
        <div class="metric-card">
            <div class="metric-icon bg-soft-primary">
                <i class="fas fa-user-graduate text-primary"></i>
            </div>
            <div class="metric-content">
                <h4>{{ number_format($totalStudents) }}</h4>
                <span>Students</span>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-4 col-md-4 col-6">
        <div class="metric-card">
            <div class="metric-icon bg-soft-success">
                <i class="fas fa-chalkboard-teacher text-success"></i>
            </div>
            <div class="metric-content">
                <h4>{{ number_format($totalInstructors) }}</h4>
                <span>Instructors</span>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-4 col-md-4 col-6">
        <div class="metric-card">
            <div class="metric-icon bg-soft-info">
                <i class="fas fa-play-circle text-info"></i>
            </div>
            <div class="metric-content">
                <h4>{{ number_format($activeEnrollments) }}</h4>
                <span>Active Enrollments</span>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-4 col-md-4 col-6">
        <div class="metric-card">
            <div class="metric-icon bg-soft-success">
                <i class="fas fa-check-circle text-success"></i>
            </div>
            <div class="metric-content">
                <h4>{{ number_format($completedCourses) }}</h4>
                <span>Completed</span>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-4 col-md-4 col-6">
        <div class="metric-card">
            <div class="metric-icon bg-soft-warning">
                <i class="fas fa-puzzle-piece text-warning"></i>
            </div>
            <div class="metric-content">
                <h4>{{ number_format($totalQuizAttempts) }}</h4>
                <span>Quiz Attempts</span>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-4 col-md-4 col-6">
        <div class="metric-card">
            <div class="metric-icon bg-soft-success">
                <i class="fas fa-trophy text-success"></i>
            </div>
            <div class="metric-content">
                <h4>{{ number_format($passedQuizzes) }}</h4>
                <span>Passed</span>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row g-4 mt-3">
    <div class="col-xl-6">
        <div class="chart-card">
            <div class="chart-header">
                <div>
                    <h5>Orders Overview</h5>
                    <p class="text-muted">Last 30 days performance</p>
                </div>
                <div class="chart-actions">
                    <span class="badge bg-light text-dark me-2">
                        <span class="dot bg-primary"></span> Orders
                    </span>
                    <span class="badge bg-light text-dark">
                        <span class="dot bg-danger"></span> Revenue
                    </span>
                </div>
            </div>
            <div class="chart-body">
                <canvas id="ordersChart" height="300"></canvas>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="chart-card">
            <div class="chart-header">
                <div>
                    <h5>Enrollments Overview</h5>
                    <p class="text-muted">Daily enrollments trend</p>
                </div>
                <div class="chart-actions">
                    <span class="badge bg-light text-dark">
                        <span class="dot bg-info"></span> Enrollments
                    </span>
                </div>
            </div>
            <div class="chart-body">
                <canvas id="enrollmentsChart" height="300"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Popular Courses & Top Rated -->
<div class="row g-4 mt-3">
    <div class="col-xl-6">
        <div class="data-card">
            <div class="data-card-header">
                <div>
                    <h5><i class="fas fa-fire text-warning me-2"></i>Popular Courses</h5>
                    <p class="text-muted">Most enrolled courses</p>
                </div>
                <a href="{{ route('admin.courses.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Course</th>
                            <th>Instructor</th>
                            <th>Enrollments</th>
                            <th>Rating</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($popularCourses as $course)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($course->thumbnail)
                                        <img src="{{ $course->thumbnail_url }}" alt="" class="course-thumbnail me-2">
                                    @else
                                        <div class="course-thumbnail-placeholder me-2">
                                            <i class="fas fa-book"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <a href="{{ route('admin.courses.edit', $course->id) }}" class="fw-semibold text-dark">
                                            {{ Str::limit($course->title, 30) }}
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $course->instructor->name ?? 'N/A' }}</td>
                            <td>
                                <span class="badge bg-info bg-opacity-10 text-info px-3 py-2">
                                    {{ number_format($course->enrollments_count) }}
                                </span>
                            </td>
                            <td>
                                <div class="rating">
                                    <span class="text-warning">★</span>
                                    <span class="fw-semibold">{{ number_format($course->average_rating, 1) }}</span>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4">
                                <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                                <p class="text-muted">No courses found</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-xl-6">
        <div class="data-card">
            <div class="data-card-header">
                <div>
                    <h5><i class="fas fa-star text-warning me-2"></i>Top Rated Courses</h5>
                    <p class="text-muted">Highest rated courses</p>
                </div>
                <a href="{{ route('admin.courses.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Course</th>
                            <th>Instructor</th>
                            <th>Rating</th>
                            <th>Reviews</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topRatedCourses as $course)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($course->thumbnail)
                                        <img src="{{ $course->thumbnail_url }}" alt="" class="course-thumbnail me-2">
                                    @else
                                        <div class="course-thumbnail-placeholder me-2">
                                            <i class="fas fa-book"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <a href="{{ route('admin.courses.edit', $course->id) }}" class="fw-semibold text-dark">
                                            {{ Str::limit($course->title, 30) }}
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $course->instructor->name ?? 'N/A' }}</td>
                            <td>
                                <div class="rating">
                                    <span class="text-warning">★</span>
                                    <span class="fw-semibold">{{ number_format($course->avg_rating, 1) }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
                                    {{ number_format($course->total_reviews) }} reviews
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4">
                                <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                                <p class="text-muted">No courses with reviews</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities -->
<div class="row g-4 mt-3">
    <div class="col-xl-4">
        <div class="data-card">
            <div class="data-card-header">
                <div>
                    <h5><i class="fas fa-user-plus text-primary me-2"></i>Recent Users</h5>
                    <p class="text-muted">Latest registered users</p>
                </div>
                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="recent-list">
                @forelse($recentUsers as $user)
                <div class="recent-item">
                    <div class="recent-item-avatar">
                        <div class="avatar-circle" style="background: {{ 'hsla(' . (crc32($user->email) % 360) . ', 70%, 60%, 0.2)' }}">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    </div>
                    <div class="recent-item-content">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-1">{{ $user->name }}</h6>
                                <p class="text-muted small mb-1">{{ $user->email }}</p>
                                <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'instructor' ? 'success' : 'info') }} bg-opacity-10 text-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'instructor' ? 'success' : 'info') }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </div>
                            <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-4">
                    <i class="fas fa-user-slash fa-2x text-muted mb-2"></i>
                    <p class="text-muted">No recent users</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
    
    <div class="col-xl-4">
        <div class="data-card">
            <div class="data-card-header">
                <div>
                    <h5><i class="fas fa-shopping-bag text-success me-2"></i>Recent Orders</h5>
                    <p class="text-muted">Latest order activity</p>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="recent-list">
                @forelse($recentOrders as $order)
                <div class="recent-item">
                    <div class="recent-item-avatar">
                        <div class="avatar-circle bg-soft-success">
                            <i class="fas fa-shopping-cart text-success"></i>
                        </div>
                    </div>
                    <div class="recent-item-content">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-1">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="text-dark">
                                        {{ $order->order_number }}
                                    </a>
                                </h6>
                                <p class="text-muted small mb-1">{{ $order->user->name ?? 'N/A' }}</p>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="fw-semibold">${{ number_format($order->total, 2) }}</span>
                                    <span class="badge bg-{{ $order->status_color }} bg-opacity-10 text-{{ $order->status_color }}">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </div>
                            </div>
                            <small class="text-muted">{{ $order->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-4">
                    <i class="fas fa-shopping-bag fa-2x text-muted mb-2"></i>
                    <p class="text-muted">No recent orders</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
    
    <div class="col-xl-4">
        <div class="data-card">
            <div class="data-card-header">
                <div>
                    <h5><i class="fas fa-star text-warning me-2"></i>Recent Reviews</h5>
                    <p class="text-muted">Latest course reviews</p>
                </div>
                <a href="{{ route('admin.reviews.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="recent-list">
                @forelse($recentReviews as $review)
                <div class="recent-item">
                    <div class="recent-item-avatar">
                        <div class="avatar-circle bg-soft-warning">
                            <i class="fas fa-user text-warning"></i>
                        </div>
                    </div>
                    <div class="recent-item-content">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-1">{{ $review->user->name }}</h6>
                                <p class="text-muted small mb-1">
                                    on <span class="fw-semibold">{{ Str::limit($review->course->title, 20) }}</span>
                                </p>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rating-stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <i class="fas fa-star text-warning"></i>
                                            @else
                                                <i class="far fa-star text-warning"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="fw-semibold">{{ $review->rating }}/5</span>
                                </div>
                            </div>
                            <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                        </div>
                        @if($review->content)
                        <p class="review-excerpt mt-2">"{{ Str::limit($review->content, 60) }}"</p>
                        @endif
                    </div>
                </div>
                @empty
                <div class="text-center py-4">
                    <i class="fas fa-star fa-2x text-muted mb-2"></i>
                    <p class="text-muted">No recent reviews</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Welcome Section */
.welcome-section {
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    border-radius: 20px;
    padding: 30px;
    margin-bottom: 30px;
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
}

.welcome-content h2 {
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 5px;
}

.welcome-content p {
    margin: 0;
    opacity: 0.9;
}

.welcome-actions {
    display: flex;
    gap: 12px;
}

.welcome-actions .btn-primary {
    background: white;
    color: var(--primary);
    border: none;
    padding: 10px 20px;
    font-weight: 600;
}

.welcome-actions .btn-primary:hover {
    background: rgba(255,255,255,0.9);
    transform: translateY(-2px);
}

.welcome-actions .btn-outline-primary {
    border: 2px solid white;
    color: white;
    padding: 10px 20px;
    font-weight: 600;
}

.welcome-actions .btn-outline-primary:hover {
    background: white;
    color: var(--primary);
    transform: translateY(-2px);
}

/* Stats Cards */
.stats-card {
    background: white;
    border-radius: 16px;
    padding: 24px;
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 24px rgba(0,0,0,0.1);
}

.stats-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200px;
    height: 200px;
    border-radius: 50%;
    opacity: 0.1;
    transition: all 0.5s ease;
}

.stats-card:hover::before {
    transform: scale(1.2);
}

.stats-card-primary::before {
    background: var(--primary);
}

.stats-card-success::before {
    background: var(--success);
}

.stats-card-info::before {
    background: var(--info);
}

.stats-card-warning::before {
    background: var(--warning);
}

.stats-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    margin-bottom: 20px;
}

.stats-card-primary .stats-icon {
    background: rgba(1, 123, 254, 0.1);
    color: var(--primary);
}

.stats-card-success .stats-icon {
    background: rgba(0, 184, 148, 0.1);
    color: var(--success);
}

.stats-card-info .stats-icon {
    background: rgba(52, 152, 219, 0.1);
    color: var(--info);
}

.stats-card-warning .stats-icon {
    background: rgba(243, 156, 18, 0.1);
    color: var(--warning);
}

.stats-label {
    font-size: 0.9rem;
    color: #6c757d;
    margin-bottom: 8px;
}

.stats-value {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 8px;
    line-height: 1.2;
}

.stats-change {
    font-size: 0.85rem;
    display: flex;
    align-items: center;
    gap: 5px;
}

.stats-change.positive {
    color: var(--success);
}

.stats-change.neutral {
    color: var(--info);
}

.stats-change.warning {
    color: var(--warning);
}

.stats-footer {
    margin-top: 20px;
    padding-top: 15px;
    border-top: 1px solid #e9ecef;
}

.stats-footer a {
    color: #6c757d;
    text-decoration: none;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: color 0.3s;
}

.stats-footer a:hover {
    color: var(--primary);
}

/* Metric Cards */
.metric-card {
    background: white;
    border-radius: 12px;
    padding: 16px;
    display: flex;
    align-items: center;
    gap: 12px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
}

.metric-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.1);
}

.metric-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

.bg-soft-primary {
    background: rgba(1, 123, 254, 0.1);
}

.bg-soft-success {
    background: rgba(0, 184, 148, 0.1);
}

.bg-soft-info {
    background: rgba(52, 152, 219, 0.1);
}

.bg-soft-warning {
    background: rgba(243, 156, 18, 0.1);
}

.metric-content h4 {
    font-size: 1.3rem;
    font-weight: 700;
    margin: 0;
    line-height: 1.2;
}

.metric-content span {
    font-size: 0.8rem;
    color: #6c757d;
}

/* Chart Cards */
.chart-card {
    background: white;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
}

.chart-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
    flex-wrap: wrap;
    gap: 15px;
}

.chart-header h5 {
    margin: 0;
    font-size: 1.2rem;
    font-weight: 600;
}

.chart-header p {
    margin: 5px 0 0;
    font-size: 0.9rem;
}

.chart-actions .badge {
    padding: 8px 12px;
    font-weight: 500;
}

.chart-actions .dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    display: inline-block;
    margin-right: 6px;
}

.dot.bg-primary {
    background: var(--primary);
}

.dot.bg-danger {
    background: var(--danger);
}

.dot.bg-info {
    background: var(--info);
}

.chart-body {
    position: relative;
    height: 300px;
}

/* Data Cards */
.data-card {
    background: white;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
}

.data-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
}

.data-card-header h5 {
    margin: 0;
    font-size: 1.2rem;
    font-weight: 600;
}

.data-card-header p {
    margin: 5px 0 0;
    font-size: 0.9rem;
}

/* Table Styles */
.table {
    margin: 0;
}

.table thead th {
    border-top: none;
    border-bottom: 2px solid #e9ecef;
    font-weight: 600;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #6c757d;
    padding: 12px;
}

.table tbody td {
    padding: 16px 12px;
    vertical-align: middle;
    border-bottom: 1px solid #f1f3f5;
}

.course-thumbnail {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    object-fit: cover;
}

.course-thumbnail-placeholder {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #adb5bd;
}

/* Recent List */
.recent-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.recent-item {
    display: flex;
    gap: 12px;
    padding: 12px;
    border-radius: 12px;
    transition: background 0.3s;
}

.recent-item:hover {
    background: #f8f9fa;
}

.recent-item-avatar {
    flex-shrink: 0;
}

.avatar-circle {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 1.2rem;
}

.recent-item-content {
    flex: 1;
    min-width: 0;
}

.review-excerpt {
    font-size: 0.9rem;
    color: #6c757d;
    margin: 8px 0 0;
    font-style: italic;
    background: #f8f9fa;
    padding: 8px 12px;
    border-radius: 8px;
}

.rating-stars {
    display: inline-flex;
    gap: 2px;
    font-size: 0.85rem;
}

/* Badge Styles */
.badge {
    font-weight: 500;
    padding: 4px 8px;
}

/* Responsive */
@media (max-width: 768px) {
    .welcome-section {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .welcome-actions {
        width: 100%;
    }
    
    .welcome-actions .btn {
        flex: 1;
    }
    
    .stats-card {
        padding: 20px;
    }
    
    .stats-value {
        font-size: 1.5rem;
    }
    
    .chart-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .data-card-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }
}

@media (max-width: 576px) {
    .welcome-content h2 {
        font-size: 1.4rem;
    }
    
    .metric-card {
        padding: 12px;
    }
    
    .metric-icon {
        width: 40px;
        height: 40px;
        font-size: 16px;
    }
    
    .metric-content h4 {
        font-size: 1.1rem;
    }
    
    .recent-item {
        flex-direction: column;
    }
    
    .recent-item-avatar {
        align-self: flex-start;
    }
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Orders Chart
    const ordersCtx = document.getElementById('ordersChart').getContext('2d');
    new Chart(ordersCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($ordersChartData['labels']) !!},
            datasets: [
                {
                    label: 'Orders',
                    data: {!! json_encode($ordersChartData['orders']) !!},
                    borderColor: '#017bfe',
                    backgroundColor: 'rgba(1, 123, 254, 0.1)',
                    tension: 0.4,
                    fill: true,
                    yAxisID: 'y'
                },
                {
                    label: 'Revenue ($)',
                    data: {!! json_encode($ordersChartData['revenues']) !!},
                    borderColor: '#e74c3c',
                    backgroundColor: 'rgba(231, 76, 60, 0.1)',
                    tension: 0.4,
                    fill: true,
                    yAxisID: 'y1'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#2c3e50',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: 'rgba(255,255,255,0.1)',
                    borderWidth: 1,
                    padding: 12,
                    cornerRadius: 8
                }
            },
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    grid: {
                        color: 'rgba(0,0,0,0.05)',
                        drawBorder: false
                    },
                    ticks: {
                        stepSize: 1
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    grid: {
                        drawOnChartArea: false,
                    },
                    ticks: {
                        callback: function(value) {
                            return '$' + value;
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        maxRotation: 45,
                        minRotation: 45
                    }
                }
            }
        }
    });
    
    // Enrollments Chart
    const enrollmentsCtx = document.getElementById('enrollmentsChart').getContext('2d');
    new Chart(enrollmentsCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($enrollmentsChartData['labels']) !!},
            datasets: [{
                label: 'Enrollments',
                data: {!! json_encode($enrollmentsChartData['enrollments']) !!},
                backgroundColor: 'rgba(52, 152, 219, 0.5)',
                borderColor: '#3498db',
                borderWidth: 2,
                borderRadius: 6,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#2c3e50',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: 'rgba(255,255,255,0.1)',
                    borderWidth: 1,
                    padding: 12,
                    cornerRadius: 8
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.05)',
                        drawBorder: false
                    },
                    ticks: {
                        stepSize: 1
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        maxRotation: 45,
                        minRotation: 45
                    }
                }
            }
        }
    });
});
</script>
@endpush