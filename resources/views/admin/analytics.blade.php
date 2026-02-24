@extends('layouts.admin')

@section('title', 'Analytics - EDUCONECX Admin')
@section('page-title', 'Analytics')

@section('content')
<!-- Date Range Picker -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.analytics') }}" class="row align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">Start Date</label>
                        <input type="date" name="start_date" class="form-control" value="{{ request('start_date', now()->startOfMonth()->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">End Date</label>
                        <input type="date" name="end_date" class="form-control" value="{{ request('end_date', now()->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Apply Filter</button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('admin.reports.export', ['type' => 'analytics', 'format' => 'csv']) }}" class="btn btn-outline-success w-100">
                            <i class="fas fa-download"></i> Export
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Summary Stats -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue">
            <i class="fas fa-dollar-sign"></i>
        </div>
        <div class="stat-content">
            <h3>${{ number_format($totalRevenue ?? 0, 2) }}</h3>
            <p>Total Revenue</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon green">
            <i class="fas fa-shopping-cart"></i>
        </div>
        <div class="stat-content">
            <h3>{{ $totalOrders ?? 0 }}</h3>
            <p>Total Orders</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon purple">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-content">
            <h3>{{ $newUsers ?? 0 }}</h3>
            <p>New Users</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon orange">
            <i class="fas fa-trophy"></i>
        </div>
        <div class="stat-content">
            <h3>{{ $completions ?? 0 }}</h3>
            <p>Course Completions</p>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row">
    <div class="col-lg-6">
        <div class="chart-container">
            <div class="chart-header">
                <h5>Monthly Revenue {{ now()->year }}</h5>
            </div>
            <div class="chart-wrapper">
                <canvas id="monthlyRevenueChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="chart-container">
            <div class="chart-header">
                <h5>User Growth {{ now()->year }}</h5>
            </div>
            <div class="chart-wrapper">
                <canvas id="userGrowthChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Course Completion Rates -->
<div class="table-container">
    <div class="table-header">
        <h5>Course Completion Rates</h5>
    </div>

    <div class="table-responsive">
        <table class="table data-table">
            <thead>
                <tr>
                    <th>Course</th>
                    <th>Total Enrollments</th>
                    <th>Completions</th>
                    <th>Completion Rate</th>
                    <th>Progress</th>
                </tr>
            </thead>
            <tbody>
                @foreach($completionRates as $course)
                @php
                $rate = $course->total_enrollments > 0
                ? round(($course->completions / $course->total_enrollments) * 100, 2)
                : 0;
                @endphp
                <tr>
                    <td>
                        <strong>{{ $course->title }}</strong>
                    </td>
                    <td>{{ $course->total_enrollments }}</td>
                    <td>{{ $course->completions }}</td>
                    <td>{{ $rate }}%</td>
                    <td style="width: 200px;">
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $rate }}%"></div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Monthly Revenue Chart
    const monthlyRevenueCtx = document.getElementById('monthlyRevenueChart').getContext('2d');
    new Chart(monthlyRevenueCtx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Revenue ($)',
                data: {
                    {
                        json_encode($monthlyRevenue - > pluck('total'))
                    }
                },
                backgroundColor: 'rgba(1, 123, 254, 0.7)',
                borderColor: '#017bfe',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value;
                        }
                    }
                }
            }
        }
    });

    // User Growth Chart
    const userGrowthCtx = document.getElementById('userGrowthChart').getContext('2d');
    new Chart(userGrowthCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'New Users',
                data: {
                    {
                        json_encode($userGrowth - > pluck('total'))
                    }
                },
                backgroundColor: 'rgba(108, 92, 231, 0.1)',
                borderColor: '#6c5ce7',
                borderWidth: 2,
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>
@endpush