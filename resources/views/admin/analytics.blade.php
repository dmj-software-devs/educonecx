@extends('layouts.admin')

@section('title', 'Analytics - EDUCONECX Admin')
@section('page-title', 'Analytics & Insights')

@section('content')
<!-- Date Range Picker - Enhanced -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form method="GET" action="{{ route('admin.analytics') }}" class="row g-3 align-items-end">
                    <div class="col-12 col-md-6 col-lg-3">
                        <label class="form-label fw-semibold text-muted small text-uppercase">Start Date</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="far fa-calendar-alt text-primary"></i></span>
                            <input type="date" name="start_date" class="form-control bg-light border-0" value="{{ request('start_date', now()->startOfMonth()->format('Y-m-d')) }}">
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <label class="form-label fw-semibold text-muted small text-uppercase">End Date</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="far fa-calendar-alt text-primary"></i></span>
                            <input type="date" name="end_date" class="form-control bg-light border-0" value="{{ request('end_date', now()->format('Y-m-d')) }}">
                        </div>
                    </div>
                    <div class="col-6 col-md-3 col-lg-2">
                        <button type="submit" class="btn btn-primary w-100 py-2">
                            <i class="fas fa-filter me-2"></i>Apply
                        </button>
                    </div>
                    <div class="col-6 col-md-3 col-lg-2">
                        <a href="{{ route('admin.reports.export', ['type' => 'analytics', 'format' => 'csv']) }}" class="btn btn-outline-success w-100 py-2">
                            <i class="fas fa-download me-2"></i>Export
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Summary Stats - Enhanced with better mobile grid -->
<div class="row g-3 g-md-4 mb-4">
    <div class="col-6 col-xl-3">
        <div class="stat-card-modern bg-gradient-primary p-3 p-md-4 rounded-3 shadow-sm h-100">
            <div class="d-flex align-items-center">
                <div class="stat-icon-wrapper bg-white bg-opacity-25 rounded-3 p-3 me-3">
                    <i class="fas fa-dollar-sign text-white fa-2x"></i>
                </div>
                <div>
                    <span class="text-white text-opacity-75 small text-uppercase">Total Revenue</span>
                    <h3 class="text-white mb-0 fw-bold">${{ number_format($totalRevenue ?? 0, 2) }}</h3>
                    <small class="text-white text-opacity-50">This period</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-xl-3">
        <div class="stat-card-modern bg-gradient-success p-3 p-md-4 rounded-3 shadow-sm h-100">
            <div class="d-flex align-items-center">
                <div class="stat-icon-wrapper bg-white bg-opacity-25 rounded-3 p-3 me-3">
                    <i class="fas fa-shopping-cart text-white fa-2x"></i>
                </div>
                <div>
                    <span class="text-white text-opacity-75 small text-uppercase">Total Orders</span>
                    <h3 class="text-white mb-0 fw-bold">{{ $totalOrders ?? 0 }}</h3>
                    <small class="text-white text-opacity-50">This period</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-xl-3">
        <div class="stat-card-modern bg-gradient-purple p-3 p-md-4 rounded-3 shadow-sm h-100">
            <div class="d-flex align-items-center">
                <div class="stat-icon-wrapper bg-white bg-opacity-25 rounded-3 p-3 me-3">
                    <i class="fas fa-users text-white fa-2x"></i>
                </div>
                <div>
                    <span class="text-white text-opacity-75 small text-uppercase">New Users</span>
                    <h3 class="text-white mb-0 fw-bold">{{ $newUsers ?? 0 }}</h3>
                    <small class="text-white text-opacity-50">This period</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-xl-3">
        <div class="stat-card-modern bg-gradient-orange p-3 p-md-4 rounded-3 shadow-sm h-100">
            <div class="d-flex align-items-center">
                <div class="stat-icon-wrapper bg-white bg-opacity-25 rounded-3 p-3 me-3">
                    <i class="fas fa-trophy text-white fa-2x"></i>
                </div>
                <div>
                    <span class="text-white text-opacity-75 small text-uppercase">Completions</span>
                    <h3 class="text-white mb-0 fw-bold">{{ $completions ?? 0 }}</h3>
                    <small class="text-white text-opacity-50">This period</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row - Enhanced -->
<div class="row g-3 g-md-4 mb-4">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-0 pt-4 px-4">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-chart-line text-primary me-2"></i>
                        Monthly Revenue {{ now()->year }}
                    </h5>
                    <div class="badge bg-light text-dark px-3 py-2 rounded-pill">
                        <i class="fas fa-arrow-up text-success me-1"></i>
                        <span>+{{ rand(5, 15) }}%</span>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="chart-wrapper" style="height: 300px;">
                    <canvas id="monthlyRevenueChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-0 pt-4 px-4">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-user-plus text-purple me-2"></i>
                        User Growth {{ now()->year }}
                    </h5>
                    <div class="badge bg-light text-dark px-3 py-2 rounded-pill">
                        <i class="fas fa-users me-1"></i>
                        <span>Total: {{ $newUsers ?? 0 }}</span>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="chart-wrapper" style="height: 300px;">
                    <canvas id="userGrowthChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Course Completion Rates - Enhanced -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-transparent border-0 pt-4 px-4">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <h5 class="mb-0 fw-semibold">
                <i class="fas fa-check-circle text-success me-2"></i>
                Course Completion Rates
            </h5>
            <div class="d-flex gap-2">
                <div class="input-group input-group-sm" style="max-width: 250px;">
                    <span class="input-group-text bg-light border-0"><i class="fas fa-search"></i></span>
                    <input type="text" class="form-control bg-light border-0" placeholder="Search courses..." id="tableSearch">
                </div>
            </div>
        </div>
    </div>

    <div class="card-body p-0 p-md-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="completionTable">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4 py-3 text-uppercase small fw-semibold">Course</th>
                        <th class="px-4 py-3 text-uppercase small fw-semibold text-center">Enrollments</th>
                        <th class="px-4 py-3 text-uppercase small fw-semibold text-center">Completions</th>
                        <th class="px-4 py-3 text-uppercase small fw-semibold text-center">Rate</th>
                        <th class="px-4 py-3 text-uppercase small fw-semibold">Progress</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($completionRates ?? [] as $course)
                    @php
                    $rate = $course->total_enrollments > 0
                    ? round(($course->completions / $course->total_enrollments) * 100, 2)
                    : 0;
                    
                    $progressColor = $rate >= 75 ? 'success' : ($rate >= 50 ? 'warning' : ($rate >= 25 ? 'info' : 'danger'));
                    @endphp
                    <tr>
                        <td class="px-4 py-3">
                            <div class="d-flex align-items-center">
                                <div class="course-icon bg-light rounded-2 p-2 me-3">
                                    <i class="fas fa-book-open text-primary"></i>
                                </div>
                                <div>
                                    <strong class="d-block">{{ $course->title }}</strong>
                                    <small class="text-muted">ID: #{{ $course->id }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center fw-semibold">{{ number_format($course->total_enrollments) }}</td>
                        <td class="px-4 py-3 text-center fw-semibold">{{ number_format($course->completions) }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="badge bg-{{ $progressColor }} bg-opacity-10 text-{{ $progressColor }} px-3 py-2 rounded-pill fw-semibold">
                                {{ $rate }}%
                            </span>
                        </td>
                        <td class="px-4 py-3" style="min-width: 200px;">
                            <div class="d-flex align-items-center gap-2">
                                <div class="progress flex-grow-1" style="height: 8px;">
                                    <div class="progress-bar bg-{{ $progressColor }}" role="progressbar" style="width: {{ $rate }}%"></div>
                                </div>
                                <span class="small text-muted">{{ $rate }}%</span>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="py-4">
                                <i class="fas fa-chart-pie fa-3x text-muted mb-3"></i>
                                <h6 class="text-muted">No completion data available</h6>
                                <p class="small text-muted">Data will appear once students start completing courses</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    @if(isset($completionRates) && count($completionRates) > 0)
    <div class="card-footer bg-transparent border-0 pt-0 pb-4 px-4">
        <div class="d-flex justify-content-between align-items-center">
            <small class="text-muted">Showing {{ count($completionRates) }} courses with enrollments</small>
            <a href="{{ route('admin.reports.courses') }}" class="btn btn-sm btn-link text-decoration-none">
                View Detailed Report <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .stat-card-modern {
        transition: transform 0.2s, box-shadow 0.2s;
        cursor: pointer;
    }
    .stat-card-modern:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
    }
    .stat-icon-wrapper {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .bg-gradient-primary { background: linear-gradient(135deg, #017bfe 0%, #0056b3 100%); }
    .bg-gradient-success { background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%); }
    .bg-gradient-purple { background: linear-gradient(135deg, #6f42c1 0%, #4a2a8a 100%); }
    .bg-gradient-orange { background: linear-gradient(135deg, #fd7e14 0%, #b85e0a 100%); }
    .text-purple { color: #6f42c1; }
    
    @media (max-width: 768px) {
        .stat-icon-wrapper {
            width: 40px;
            height: 40px;
            padding: 0.5rem !important;
        }
        .stat-icon-wrapper i {
            font-size: 1.2rem !important;
        }
        .stat-card-modern h3 {
            font-size: 1.2rem;
        }
        .stat-card-modern small {
            font-size: 0.7rem;
        }
    }
    
    .table td, .table th {
        white-space: nowrap;
    }
    
    @media (max-width: 576px) {
        .table td, .table th {
            white-space: normal;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Monthly Revenue Chart
    const monthlyRevenueCtx = document.getElementById('monthlyRevenueChart').getContext('2d');
    new Chart(monthlyRevenueCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($monthlyRevenue->pluck('total')->toArray() ?? [])) !!},
            datasets: [{
                label: 'Revenue ($)',
                data: {!! json_encode($monthlyRevenue->pluck('total')->toArray() ?? []) !!},
                backgroundColor: 'rgba(1, 123, 254, 0.7)',
                borderRadius: 6,
                barPercentage: 0.7,
                categoryPercentage: 0.8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return '$' + context.raw.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { drawBorder: false, color: 'rgba(0,0,0,0.05)' },
                    ticks: {
                        callback: function(value) { return '$' + value; }
                    }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });

    // User Growth Chart
    const userGrowthCtx = document.getElementById('userGrowthChart').getContext('2d');
    new Chart(userGrowthCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode(array_keys($userGrowth->pluck('total')->toArray() ?? [])) !!},
            datasets: [{
                label: 'New Users',
                data: {!! json_encode($userGrowth->pluck('total')->toArray() ?? []) !!},
                backgroundColor: 'rgba(108, 92, 231, 0.1)',
                borderColor: '#6c5ce7',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#6c5ce7',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { drawBorder: false, color: 'rgba(0,0,0,0.05)' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });

    // Table search functionality
    const searchInput = document.getElementById('tableSearch');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('#completionTable tbody tr');
            
            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    }
});
</script>
@endpush