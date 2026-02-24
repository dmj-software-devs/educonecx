@extends('layouts.admin')

@section('title', 'Search Results - EDUCONECX Admin')
@section('page-title', 'Search Results')

@section('content')
<!-- Search Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                    <div>
                        <h4 class="mb-1">
                            <i class="fas fa-search text-primary me-2"></i>
                            Results for "{{ $query }}"
                        </h4>
                        <p class="text-muted mb-0">
                            Found <span class="fw-bold text-primary">{{ $totalCount }}</span> {{ Str::plural('result', $totalCount) }}
                        </p>
                    </div>
                    <div class="d-flex gap-2">
                        <!-- Quick filter chips -->
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-outline-primary btn-sm filter-btn active" data-filter="all">
                                All <span class="badge bg-primary bg-opacity-10 text-primary ms-1">{{ $totalCount }}</span>
                            </button>
                            <button type="button" class="btn btn-outline-primary btn-sm filter-btn" data-filter="users">
                                Users <span class="badge bg-primary bg-opacity-10 text-primary ms-1">{{ $results['users']->count() }}</span>
                            </button>
                            <button type="button" class="btn btn-outline-primary btn-sm filter-btn" data-filter="courses">
                                Courses <span class="badge bg-primary bg-opacity-10 text-primary ms-1">{{ $results['courses']->count() }}</span>
                            </button>
                            <button type="button" class="btn btn-outline-primary btn-sm filter-btn" data-filter="orders">
                                Orders <span class="badge bg-primary bg-opacity-10 text-primary ms-1">{{ $results['orders']->count() }}</span>
                            </button>
                            <button type="button" class="btn btn-outline-primary btn-sm filter-btn" data-filter="quizzes">
                                Quizzes <span class="badge bg-primary bg-opacity-10 text-primary ms-1">{{ $results['quizzes']->count() }}</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Results Sections -->
<div class="search-results-container">
    @if($totalCount == 0)
    <div class="card border-0 shadow-sm">
        <div class="card-body text-center py-5">
            <div class="empty-state py-5">
                <div class="empty-state-icon mb-4">
                    <i class="fas fa-search fa-4x text-muted opacity-25"></i>
                </div>
                <h5 class="mb-2">No results found</h5>
                <p class="text-muted mb-4">We couldn't find any matches for "{{ $query }}"</p>
                <div class="suggestions">
                    <p class="small text-muted mb-2">Suggestions:</p>
                    <ul class="list-unstyled">
                        <li class="mb-1"><i class="fas fa-circle text-primary me-2" style="font-size: 8px;"></i>Check your spelling</li>
                        <li class="mb-1"><i class="fas fa-circle text-primary me-2" style="font-size: 8px;"></i>Try more general keywords</li>
                        <li class="mb-1"><i class="fas fa-circle text-primary me-2" style="font-size: 8px;"></i>Try different keywords</li>
                    </ul>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary mt-4">
                    <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                </a>
            </div>
        </div>
    </div>
    @else
    <!-- Users Section -->
    @if($results['users']->count() > 0)
    <div class="result-section mb-4" data-section="users">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0 pt-4 px-4">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">
                        <i class="fas fa-users text-primary me-2"></i>
                        Users
                        <span class="badge bg-light text-dark ms-2">{{ $results['users']->count() }}</span>
                    </h5>
                    <a href="{{ route('admin.users.index') }}?search={{ $query }}" class="btn btn-sm btn-link text-decoration-none">
                        View All <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="px-4 py-3">User</th>
                                <th class="px-4 py-3">Role</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3 text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($results['users'] as $user)
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar-sm bg-primary bg-opacity-10 rounded-2 p-2 me-3">
                                            <i class="fas fa-user text-primary"></i>
                                        </div>
                                        <div>
                                            <strong class="d-block">{{ $user->name }}</strong>
                                            <small class="text-muted">{{ $user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="badge bg-{{ $user->role == 'admin' ? 'danger' : ($user->role == 'instructor' ? 'info' : 'secondary') }} bg-opacity-10 text-{{ $user->role == 'admin' ? 'danger' : ($user->role == 'instructor' ? 'info' : 'secondary') }} px-3 py-2 rounded-pill">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="badge bg-{{ $user->status == 'active' ? 'success' : 'warning' }} bg-opacity-10 text-{{ $user->status == 'active' ? 'success' : 'warning' }} px-3 py-2 rounded-pill">
                                        {{ ucfirst($user->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-end">
                                    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Courses Section -->
    @if($results['courses']->count() > 0)
    <div class="result-section mb-4" data-section="courses">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0 pt-4 px-4">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">
                        <i class="fas fa-book text-success me-2"></i>
                        Courses
                        <span class="badge bg-light text-dark ms-2">{{ $results['courses']->count() }}</span>
                    </h5>
                    <a href="{{ route('admin.courses.index') }}?search={{ $query }}" class="btn btn-sm btn-link text-decoration-none">
                        View All <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="px-4 py-3">Course</th>
                                <th class="px-4 py-3">Category</th>
                                <th class="px-4 py-3">Price</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3 text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($results['courses'] as $course)
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="d-flex align-items-center">
                                        @if($course->thumbnail)
                                        <img src="{{ asset('storage/'.$course->thumbnail) }}" alt="{{ $course->title }}" class="rounded-2 me-3" style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                        <div class="course-icon bg-success bg-opacity-10 rounded-2 p-2 me-3">
                                            <i class="fas fa-book text-success"></i>
                                        </div>
                                        @endif
                                        <div>
                                            <strong class="d-block">{{ $course->title }}</strong>
                                            <small class="text-muted">{{ Str::limit($course->excerpt, 50) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">{{ $course->category->name ?? 'N/A' }}</td>
                                <td class="px-4 py-3 fw-semibold">${{ number_format($course->price, 2) }}</td>
                                <td class="px-4 py-3">
                                    <span class="badge bg-{{ $course->status == 'published' ? 'success' : 'secondary' }} bg-opacity-10 text-{{ $course->status == 'published' ? 'success' : 'secondary' }} px-3 py-2 rounded-pill">
                                        {{ ucfirst($course->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-end">
                                    <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('admin.courses.show', $course) }}" class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Orders Section -->
    @if($results['orders']->count() > 0)
    <div class="result-section mb-4" data-section="orders">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0 pt-4 px-4">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">
                        <i class="fas fa-shopping-cart text-warning me-2"></i>
                        Orders
                        <span class="badge bg-light text-dark ms-2">{{ $results['orders']->count() }}</span>
                    </h5>
                    <a href="{{ route('admin.orders.index') }}?search={{ $query }}" class="btn btn-sm btn-link text-decoration-none">
                        View All <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="px-4 py-3">Order #</th>
                                <th class="px-4 py-3">Customer</th>
                                <th class="px-4 py-3">Amount</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Date</th>
                                <th class="px-4 py-3 text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($results['orders'] as $order)
                            <tr>
                                <td class="px-4 py-3 fw-semibold">{{ $order->order_number }}</td>
                                <td class="px-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-secondary bg-opacity-10 rounded-2 p-2 me-2">
                                            <i class="fas fa-user text-secondary"></i>
                                        </div>
                                        <span>{{ $order->user->name ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 fw-semibold text-success">${{ number_format($order->total, 2) }}</td>
                                <td class="px-4 py-3">
                                    <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }} bg-opacity-10 text-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }} px-3 py-2 rounded-pill">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">{{ $order->created_at->format('M d, Y') }}</td>
                                <td class="px-4 py-3 text-end">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Quizzes Section -->
    @if($results['quizzes']->count() > 0)
    <div class="result-section mb-4" data-section="quizzes">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0 pt-4 px-4">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">
                        <i class="fas fa-question-circle text-info me-2"></i>
                        Quizzes
                        <span class="badge bg-light text-dark ms-2">{{ $results['quizzes']->count() }}</span>
                    </h5>
                    <a href="{{ route('admin.quizzes.index') }}?search={{ $query }}" class="btn btn-sm btn-link text-decoration-none">
                        View All <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="px-4 py-3">Quiz Title</th>
                                <th class="px-4 py-3">Type</th>
                                <th class="px-4 py-3">Questions</th>
                                <th class="px-4 py-3">Duration</th>
                                <th class="px-4 py-3 text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($results['quizzes'] as $quiz)
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-info bg-opacity-10 rounded-2 p-2 me-3">
                                            <i class="fas fa-puzzle-piece text-info"></i>
                                        </div>
                                        <strong>{{ $quiz->title }}</strong>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded-pill">
                                        {{ ucfirst($quiz->type) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">{{ $quiz->total_questions }}</td>
                                <td class="px-4 py-3">{{ $quiz->duration ?? 'N/A' }} mins</td>
                                <td class="px-4 py-3 text-end">
                                    <a href="{{ route('admin.quizzes.edit', $quiz) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('admin.quizzes.show', $quiz) }}" class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endif
</div>
@endsection

@push('styles')
<style>
    .search-results-container {
        animation: fadeIn 0.3s ease;
    }
    
    .result-section {
        transition: opacity 0.3s ease;
    }
    
    .result-section.hidden {
        display: none;
    }
    
    .empty-state-icon {
        opacity: 0.5;
    }
    
    .filter-btn.active {
        background-color: var(--bs-primary);
        color: white;
    }
    
    .filter-btn.active .badge {
        background-color: rgba(255,255,255,0.2) !important;
        color: white !important;
    }
    
    .user-avatar-sm {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .course-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    @media (max-width: 768px) {
        .btn-group {
            flex-wrap: wrap;
        }
        
        .btn-group .btn {
            margin-bottom: 5px;
        }
        
        .table td, .table th {
            white-space: nowrap;
        }
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filter functionality
        const filterBtns = document.querySelectorAll('.filter-btn');
        const sections = document.querySelectorAll('.result-section');
        
        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                // Update active state
                filterBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                const filter = this.dataset.filter;
                
                // Show/hide sections
                if (filter === 'all') {
                    sections.forEach(section => section.classList.remove('hidden'));
                } else {
                    sections.forEach(section => {
                        if (section.dataset.section === filter) {
                            section.classList.remove('hidden');
                        } else {
                            section.classList.add('hidden');
                        }
                    });
                }
            });
        });
        
        // Highlight search terms
        const searchTerm = "{{ $query }}";
        if (searchTerm.length > 0) {
            const tables = document.querySelectorAll('.table');
            tables.forEach(table => {
                const cells = table.querySelectorAll('td');
                cells.forEach(cell => {
                    const text = cell.textContent;
                    const regex = new RegExp(`(${searchTerm})`, 'gi');
                    if (regex.test(text)) {
                        cell.innerHTML = text.replace(regex, '<mark class="bg-warning bg-opacity-25 p-1 rounded">$1</mark>');
                    }
                });
            });
        }
    });
</script>
@endpush