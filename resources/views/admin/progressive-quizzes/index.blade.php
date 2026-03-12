@extends('layouts.admin')

@section('title', 'Progressive Quizzes')
@section('page-title', 'Progressive Quiz Management')

@section('content')
<!-- Header Section -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Progressive Quizzes</h2>
        <p class="text-muted mb-0">Create quizzes with progressive levels/stages</p>
    </div>
    <div>
        <a href="{{ route('admin.progressive-quizzes.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> New Progressive Quiz
        </a>
    </div>
</div>

<!-- Stats Summary -->
<div class="row g-4 mb-4">
    <div class="col-lg-3 col-md-6">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-primary bg-opacity-10 text-primary rounded-3 p-3 me-3">
                    <i class="fas fa-layer-group fa-2x"></i>
                </div>
                <div>
                    <span class="text-muted text-uppercase small fw-bold">Total Quizzes</span>
                    <h3 class="mb-0 fw-bold">{{ $quizzes->total() }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-success bg-opacity-10 text-success rounded-3 p-3 me-3">
                    <i class="fas fa-check-circle fa-2x"></i>
                </div>
                <div>
                    <span class="text-muted text-uppercase small fw-bold">Published</span>
                    <h3 class="mb-0 fw-bold">{{ $quizzes->where('status', 'published')->count() }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-warning bg-opacity-10 text-warning rounded-3 p-3 me-3">
                    <i class="fas fa-clock fa-2x"></i>
                </div>
                <div>
                    <span class="text-muted text-uppercase small fw-bold">Draft</span>
                    <h3 class="mb-0 fw-bold">{{ $quizzes->where('status', 'draft')->count() }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-info bg-opacity-10 text-info rounded-3 p-3 me-3">
                    <i class="fas fa-chart-line fa-2x"></i>
                </div>
                <div>
                    <span class="text-muted text-uppercase small fw-bold">Total Levels</span>
                    <h3 class="mb-0 fw-bold">{{ $quizzes->sum('total_levels') }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quizzes Table -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="50">#</th>
                        <th>Quiz Details</th>
                        <th width="80">Levels</th>
                        <th width="100">Questions</th>
                        <th width="120">Settings</th>
                        <th width="100">Status</th>
                        <th width="140">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($quizzes as $quiz)
                    <tr>
                        <td class="text-muted">#{{ $quiz->id }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($quiz->featured_image)
                                    <img src="{{ $quiz->featured_image_url }}" class="rounded-3 me-3" width="48" height="48" style="object-fit: cover;" alt="">
                                @else
                                    <div class="bg-light rounded-3 d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                                        <i class="fas fa-layer-group text-primary"></i>
                                    </div>
                                @endif
                                <div>
                                    <a href="{{ route('admin.progressive-quizzes.levels', $quiz) }}" class="text-dark fw-bold text-decoration-none">
                                        {{ $quiz->title }}
                                    </a>
                                    <div class="small text-muted">
                                        <span class="me-3"><i class="far fa-clock me-1"></i> {{ $quiz->time_limit_formatted }}</span>
                                        <span class="me-3"><i class="fas fa-percent me-1"></i> Pass: {{ $quiz->pass_percentage }}%</span>
                                        <span><i class="fas fa-redo me-1"></i> {{ $quiz->attempts_allowed == 0 ? 'Unlimited' : $quiz->attempts_allowed . ' attempts' }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="text-center">
                                <span class="fw-bold fs-5">{{ $quiz->total_levels }}</span>
                                <small class="d-block text-muted">levels</small>
                            </div>
                        </td>
                        <td>
                            <div class="text-center">
                                <span class="fw-bold fs-5">{{ $quiz->total_questions }}</span>
                                <small class="d-block text-muted">questions</small>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                @if($quiz->shuffle_questions)
                                    <span class="badge bg-info" title="Shuffle Questions" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-random"></i>
                                    </span>
                                @endif
                                @if($quiz->show_results)
                                    <span class="badge bg-success" title="Show Results" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-chart-bar"></i>
                                    </span>
                                @endif
                                @if($quiz->show_answers)
                                    <span class="badge bg-warning" title="Show Answers" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-check-circle"></i>
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td>
                            @php
                                $statusClasses = [
                                    'published' => 'success',
                                    'draft' => 'warning',
                                    'archived' => 'secondary'
                                ];
                                $statusClass = $statusClasses[$quiz->status] ?? 'secondary';
                            @endphp
                            <span class="badge bg-{{ $statusClass }} bg-opacity-10 text-{{ $statusClass }} px-3 py-2 rounded-pill">
                                {{ ucfirst($quiz->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.progressive-quizzes.levels', $quiz) }}" class="btn btn-sm btn-info text-white" title="Manage Levels">
                                    <i class="fas fa-layer-group"></i>
                                </a>
                                <a href="{{ route('admin.progressive-quizzes.edit', $quiz) }}" class="btn btn-sm btn-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" 
                                        onclick="confirmDelete({{ $quiz->id }}, '{{ addslashes($quiz->title) }}')"
                                        title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <form id="delete-form-{{ $quiz->id }}" 
                                      action="{{ route('admin.progressive-quizzes.destroy', $quiz) }}" 
                                      method="POST" 
                                      class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="py-5">
                                <i class="fas fa-layer-group fa-3x text-muted mb-3"></i>
                                <h5>No Progressive Quizzes Found</h5>
                                <p class="text-muted mb-3">Create your first progressive quiz with levels</p>
                                <a href="{{ route('admin.progressive-quizzes.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus-circle"></i> Create New Quiz
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($quizzes instanceof \Illuminate\Pagination\LengthAwarePaginator && $quizzes->hasPages())
        <div class="d-flex justify-content-end mt-3">
            {{ $quizzes->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">Delete Progressive Quiz</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong id="deleteQuizTitle"></strong>?</p>
                <p class="text-danger small">This action cannot be undone. All levels, questions, and attempt data will be permanently deleted.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete Quiz</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(id, title) {
    document.getElementById('deleteQuizTitle').textContent = title;
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
    
    document.getElementById('confirmDeleteBtn').onclick = function() {
        document.getElementById('delete-form-' + id).submit();
    };
}

// Auto-hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
});
</script>
@endpush

@push('styles')
<style>
/* Additional styles specific to progressive quizzes */
.stat-icon {
    transition: transform 0.2s;
}

.stat-card:hover .stat-icon {
    transform: scale(1.1);
}

.btn-info {
    background-color: #3498db;
    border-color: #3498db;
}

.btn-info:hover {
    background-color: #2980b9;
    border-color: #2980b9;
}

.badge {
    font-weight: 500;
    transition: all 0.2s;
}

.table > :not(caption) > * > * {
    padding: 1rem 0.75rem;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .stat-card .card-body {
        padding: 1rem;
    }
    
    .stat-icon {
        padding: 0.5rem !important;
    }
    
    .stat-icon i {
        font-size: 1.2rem;
    }
    
    .table > :not(caption) > * > * {
        padding: 0.75rem 0.5rem;
    }
}
</style>
@endpush