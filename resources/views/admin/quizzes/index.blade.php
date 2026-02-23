@extends('layouts.admin')

@section('title', 'Quizzes')
@section('title', 'Quizzes')
@section('page-title', 'Quiz Management')

@section('content')
<!-- Header Section -->
<div class="header-section">
    <div class="header-content">
        <h2>Quizzes</h2>
        <p>Manage and organize your quizzes</p>
    </div>
    <div class="header-actions">
        <a href="{{ route('admin.quizzes.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> New Quiz
        </a>
    </div>
</div>

<!-- Stats Summary -->
<div class="row g-4 mb-4">
    <div class="col-lg-3 col-md-6">
        <div class="stat-mini-card">
            <div class="stat-mini-icon bg-soft-primary">
                <i class="fas fa-puzzle-piece text-primary"></i>
            </div>
            <div class="stat-mini-content">
                <span class="stat-mini-label">Total Quizzes</span>
                <span class="stat-mini-value">{{ $quizzes->total() ?? 0 }}</span>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="stat-mini-card">
            <div class="stat-mini-icon bg-soft-success">
                <i class="fas fa-check-circle text-success"></i>
            </div>
            <div class="stat-mini-content">
                <span class="stat-mini-label">Published</span>
                <span class="stat-mini-value">{{ $quizzes->where('status', 'published')->count() ?? 0 }}</span>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="stat-mini-card">
            <div class="stat-mini-icon bg-soft-warning">
                <i class="fas fa-clock text-warning"></i>
            </div>
            <div class="stat-mini-content">
                <span class="stat-mini-label">Draft</span>
                <span class="stat-mini-value">{{ $quizzes->where('status', 'draft')->count() ?? 0 }}</span>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="stat-mini-card">
            <div class="stat-mini-icon bg-soft-info">
                <i class="fas fa-question-circle text-info"></i>
            </div>
            <div class="stat-mini-content">
                <span class="stat-mini-label">Total Questions</span>
                <span class="stat-mini-value">{{ number_format($quizzes->sum('total_questions') ?? 0) }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Filters Section -->
<div class="filters-section">
    <div class="row g-3 align-items-end">
        <div class="col-lg-3 col-md-6">
            <label class="form-label">Search</label>
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" class="form-control" placeholder="Search quizzes...">
            </div>
        </div>
        <div class="col-lg-2 col-md-6">
            <label class="form-label">Type</label>
            <select id="typeFilter" class="form-select">
                <option value="">All Types</option>
                <option value="standalone">Standalone</option>
                <option value="course">Course Quiz</option>
                <option value="lesson">Lesson Quiz</option>
            </select>
        </div>
        <div class="col-lg-2 col-md-6">
            <label class="form-label">Status</label>
            <select id="statusFilter" class="form-select">
                <option value="">All Status</option>
                <option value="published">Published</option>
                <option value="draft">Draft</option>
            </select>
        </div>
        <div class="col-lg-2 col-md-6">
            <label class="form-label">Sort By</label>
            <select id="sortFilter" class="form-select">
                <option value="latest">Latest</option>
                <option value="oldest">Oldest</option>
                <option value="title_asc">Title A-Z</option>
                <option value="title_desc">Title Z-A</option>
                <option value="questions_desc">Most Questions</option>
                <option value="attempts_desc">Most Attempts</option>
            </select>
        </div>
        <div class="col-lg-3 col-md-12">
            <div class="filter-actions">
                <button id="applyFilters" class="btn btn-primary w-100">
                    <i class="fas fa-filter"></i> Apply Filters
                </button>
                <button id="resetFilters" class="btn btn-outline-secondary">
                    <i class="fas fa-redo"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Quizzes Table -->
<div class="table-wrapper">
    <table class="modern-table" id="quizzesTable">
        <thead>
            <tr>
                <th width="50">#</th>
                <th>Quiz Details</th>
                <th>Type</th>
                <th>Course</th>
                <th>Questions</th>
                <th>Stats</th>
                <th>Status</th>
                <th width="140">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($quizzes ?? [] as $quiz)
            <tr class="quiz-row" data-type="{{ $quiz->type }}" data-status="{{ $quiz->status }}">
                <td class="text-muted">#{{ $quiz->id }}</td>
                <td>
                    <div class="quiz-info">
                        <div class="quiz-icon">
                            <i class="fas fa-puzzle-piece"></i>
                        </div>
                        <div class="quiz-meta">
                            <a href="{{ route('admin.quizzes.edit', $quiz) }}" class="quiz-title">
                                {{ $quiz->title }}
                            </a>
                            <div class="quiz-subtitle">
                                <span><i class="far fa-clock"></i> {{ $quiz->time_limit ? $quiz->time_limit . ' min' : 'No limit' }}</span>
                                <span><i class="fas fa-percent"></i> Pass: {{ $quiz->pass_percentage ?? 0 }}%</span>
                                <span><i class="fas fa-redo"></i> {{ $quiz->attempts_allowed == 0 ? 'Unlimited' : $quiz->attempts_allowed . ' attempts' }}</span>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <span class="type-badge type-{{ $quiz->type }}">
                        @if($quiz->type == 'standalone')
                            <i class="fas fa-puzzle-piece"></i> Standalone
                        @elseif($quiz->type == 'course')
                            <i class="fas fa-book"></i> Course
                        @else
                            <i class="fas fa-play-circle"></i> Lesson
                        @endif
                    </span>
                </td>
                <td>
                    @if($quiz->course)
                        <div class="course-link">
                            <i class="fas fa-book-open"></i>
                            <span>{{ Str::limit($quiz->course->title, 20) }}</span>
                        </div>
                    @else
                        <span class="text-muted">—</span>
                    @endif
                </td>
                <td>
                    <div class="questions-count">
                        <span class="count">{{ $quiz->total_questions ?? 0 }}</span>
                        <small>questions</small>
                    </div>
                </td>
                <td>
                    <div class="quiz-stats">
                        <div class="stat-item" title="Total Attempts">
                            <i class="fas fa-users"></i>
                            <span>{{ number_format($quiz->total_attempts ?? 0) }}</span>
                        </div>
                        <div class="stat-item" title="Average Score">
                            <i class="fas fa-chart-line"></i>
                            <span>{{ $quiz->average_score ?? 0 }}%</span>
                        </div>
                    </div>
                </td>
                <td>
                    @php
                        $statusColors = [
                            'published' => 'success',
                            'draft' => 'warning'
                        ];
                        $statusColor = $statusColors[$quiz->status] ?? 'secondary';
                    @endphp
                    <span class="status-badge status-{{ $statusColor }}">
                        {{ ucfirst($quiz->status) }}
                    </span>
                </td>
                <td>
                    <div class="action-buttons">
                        <a href="{{ route('admin.quizzes.questions', $quiz) }}" class="action-btn questions-btn" title="Manage Questions">
                            <i class="fas fa-list"></i>
                        </a>
                        <a href="{{ route('admin.quizzes.edit', $quiz) }}" class="action-btn edit-btn" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button type="button" class="action-btn delete-btn" 
                                onclick="confirmDelete({{ $quiz->id }}, '{{ $quiz->title }}')"
                                title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                        <form id="delete-form-{{ $quiz->id }}" 
                              action="{{ route('admin.quizzes.destroy', $quiz) }}" 
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
                <td colspan="8" class="text-center py-5">
                    <div class="empty-state">
                        <i class="fas fa-puzzle-piece fa-3x text-muted mb-3"></i>
                        <h5>No Quizzes Found</h5>
                        <p class="text-muted">Get started by creating your first quiz</p>
                        <a href="{{ route('admin.quizzes.create') }}" class="btn btn-primary mt-2">
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
<div class="pagination-wrapper">
    {{ $quizzes->links() }}
</div>
@endif

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">Delete Quiz</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong id="deleteQuizTitle"></strong>?</p>
                <p class="text-danger small">This action cannot be undone. All questions and attempt data will be permanently deleted.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete Quiz</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
:root {
    --primary: #017bfe;
    --secondary: #6c5ce7;
    --success: #00b894;
    --danger: #e74c3c;
    --warning: #f39c12;
    --info: #3498db;
    --dark: #2c3e50;
}

/* Header Section */
.header-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    flex-wrap: wrap;
    gap: 20px;
}

.header-content h2 {
    font-size: 1.8rem;
    font-weight: 700;
    margin: 0 0 5px;
    color: var(--dark);
}

.header-content p {
    margin: 0;
    color: #6c757d;
    font-size: 0.95rem;
}

.header-actions {
    display: flex;
    gap: 12px;
}

.header-actions .btn-primary {
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    border: none;
    padding: 12px 24px;
    font-weight: 500;
}

.header-actions .btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 16px rgba(1, 123, 254, 0.2);
}

/* Mini Stats Cards */
.stat-mini-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 15px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
}

.stat-mini-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.1);
}

.stat-mini-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
}

.bg-soft-primary {
    background: rgba(1, 123, 254, 0.1);
}

.bg-soft-success {
    background: rgba(0, 184, 148, 0.1);
}

.bg-soft-warning {
    background: rgba(243, 156, 18, 0.1);
}

.bg-soft-info {
    background: rgba(52, 152, 219, 0.1);
}

.stat-mini-content {
    flex: 1;
}

.stat-mini-label {
    display: block;
    font-size: 0.85rem;
    color: #6c757d;
    margin-bottom: 5px;
}

.stat-mini-value {
    display: block;
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--dark);
    line-height: 1.2;
}

/* Filters Section */
.filters-section {
    background: white;
    border-radius: 12px;
    padding: 24px;
    margin-bottom: 24px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.search-box {
    position: relative;
}

.search-box i {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #adb5bd;
    font-size: 0.9rem;
}

.search-box .form-control {
    padding-left: 35px;
}

.form-label {
    font-weight: 500;
    font-size: 0.9rem;
    color: #495057;
    margin-bottom: 8px;
}

.form-control, .form-select {
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 10px 12px;
    font-size: 0.95rem;
    transition: all 0.3s;
}

.form-control:focus, .form-select:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(1, 123, 254, 0.1);
    outline: none;
}

.filter-actions {
    display: flex;
    gap: 8px;
}

.filter-actions .btn-primary {
    background: var(--primary);
    border: none;
    padding: 10px;
}

.filter-actions .btn-outline-secondary {
    padding: 10px 15px;
}

/* Table Wrapper */
.table-wrapper {
    background: white;
    border-radius: 12px;
    padding: 4px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    overflow-x: auto;
}

/* Modern Table */
.modern-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 1200px;
}

.modern-table thead th {
    background: #f8f9fa;
    padding: 16px 20px;
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #6c757d;
    border-bottom: 2px solid #e9ecef;
    white-space: nowrap;
}

.modern-table tbody td {
    padding: 20px;
    border-bottom: 1px solid #f1f3f5;
    vertical-align: middle;
}

.modern-table tbody tr:hover {
    background: #f8f9fa;
}

/* Quiz Info */
.quiz-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.quiz-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: linear-gradient(135deg, rgba(1, 123, 254, 0.1), rgba(108, 92, 231, 0.1));
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
    font-size: 1.3rem;
}

.quiz-meta {
    flex: 1;
    min-width: 200px;
}

.quiz-title {
    font-weight: 600;
    color: var(--dark);
    text-decoration: none;
    font-size: 1rem;
    display: block;
    margin-bottom: 4px;
}

.quiz-title:hover {
    color: var(--primary);
}

.quiz-subtitle {
    display: flex;
    gap: 15px;
    font-size: 0.85rem;
    color: #6c757d;
}

.quiz-subtitle span i {
    margin-right: 4px;
    font-size: 0.75rem;
}

/* Type Badge */
.type-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 500;
    white-space: nowrap;
}

.type-standalone {
    background: rgba(1, 123, 254, 0.1);
    color: var(--primary);
}

.type-course {
    background: rgba(0, 184, 148, 0.1);
    color: var(--success);
}

.type-lesson {
    background: rgba(243, 156, 18, 0.1);
    color: var(--warning);
}

/* Course Link */
.course-link {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #6c757d;
    font-size: 0.9rem;
}

.course-link i {
    color: var(--primary);
    font-size: 0.9rem;
}

/* Questions Count */
.questions-count {
    text-align: center;
}

.questions-count .count {
    display: block;
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--dark);
    line-height: 1.2;
}

.questions-count small {
    font-size: 0.75rem;
    color: #6c757d;
}

/* Quiz Stats */
.quiz-stats {
    display: flex;
    gap: 12px;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 4px;
    color: #6c757d;
    font-size: 0.85rem;
}

.stat-item i {
    font-size: 0.85rem;
}

.stat-item span {
    font-weight: 500;
}

/* Status Badge */
.status-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 500;
    white-space: nowrap;
}

.status-success {
    background: rgba(0, 184, 148, 0.1);
    color: var(--success);
}

.status-warning {
    background: rgba(243, 156, 18, 0.1);
    color: var(--warning);
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 6px;
}

.action-btn {
    width: 34px;
    height: 34px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-decoration: none;
    transition: all 0.3s;
    border: none;
    cursor: pointer;
}

.action-btn:hover {
    transform: translateY(-2px);
}

.questions-btn {
    background: var(--success);
}

.questions-btn:hover {
    background: #00997a;
    box-shadow: 0 4px 8px rgba(0, 184, 148, 0.2);
}

.edit-btn {
    background: var(--primary);
}

.edit-btn:hover {
    background: #0056b3;
    box-shadow: 0 4px 8px rgba(1, 123, 254, 0.2);
}

.delete-btn {
    background: var(--danger);
}

.delete-btn:hover {
    background: #c0392b;
    box-shadow: 0 4px 8px rgba(231, 76, 60, 0.2);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 40px;
}

.empty-state i {
    color: #dee2e6;
}

.empty-state h5 {
    color: #495057;
    margin-bottom: 8px;
}

/* Pagination */
.pagination-wrapper {
    margin-top: 24px;
    display: flex;
    justify-content: flex-end;
}

/* Responsive */
@media (max-width: 768px) {
    .header-section {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .header-actions {
        width: 100%;
    }
    
    .header-actions .btn {
        width: 100%;
    }
    
    .filters-section {
        padding: 16px;
    }
    
    .filter-actions {
        flex-direction: column;
    }
    
    .filter-actions .btn-outline-secondary {
        width: 100%;
    }
    
    .stat-mini-card {
        padding: 16px;
    }
    
    .stat-mini-value {
        font-size: 1.3rem;
    }
    
    .quiz-subtitle {
        flex-direction: column;
        gap: 4px;
    }
    
    .quiz-stats {
        flex-direction: column;
        gap: 4px;
    }
    
    .action-buttons {
        flex-wrap: wrap;
    }
}

@media (max-width: 576px) {
    .quiz-info {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .quiz-meta {
        min-width: auto;
    }
    
    .type-badge {
        font-size: 0.75rem;
        padding: 4px 8px;
    }
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize filters
    let currentFilters = {
        search: '',
        type: '',
        status: '',
        sort: 'latest'
    };
    
    // Search functionality
    $('#searchInput').on('keyup', function(e) {
        if (e.key === 'Enter') {
            applyFilters();
        }
    });
    
    // Apply filters
    $('#applyFilters').click(function() {
        applyFilters();
    });
    
    // Reset filters
    $('#resetFilters').click(function() {
        $('#searchInput').val('');
        $('#typeFilter').val('');
        $('#statusFilter').val('');
        $('#sortFilter').val('latest');
        applyFilters();
    });
    
    function applyFilters() {
        currentFilters.search = $('#searchInput').val().toLowerCase();
        currentFilters.type = $('#typeFilter').val();
        currentFilters.status = $('#statusFilter').val();
        currentFilters.sort = $('#sortFilter').val();
        
        filterAndSortTable();
    }
    
    function filterAndSortTable() {
        let rows = $('#quizzesTable tbody tr').get();
        
        // Filter rows
        let filteredRows = rows.filter(row => {
            let $row = $(row);
            let title = $row.find('.quiz-title').text().toLowerCase();
            let type = $row.data('type') || '';
            let status = $row.data('status') || '';
            
            // Search filter
            if (currentFilters.search && !title.includes(currentFilters.search)) {
                return false;
            }
            
            // Type filter
            if (currentFilters.type && type !== currentFilters.type) {
                return false;
            }
            
            // Status filter
            if (currentFilters.status && status !== currentFilters.status) {
                return false;
            }
            
            return true;
        });
        
        // Sort rows
        filteredRows.sort((a, b) => {
            let $a = $(a);
            let $b = $(b);
            
            switch(currentFilters.sort) {
                case 'title_asc':
                    return $a.find('.quiz-title').text().localeCompare($b.find('.quiz-title').text());
                case 'title_desc':
                    return $b.find('.quiz-title').text().localeCompare($a.find('.quiz-title').text());
                case 'questions_desc':
                    let questionsA = parseInt($a.find('.questions-count .count').text()) || 0;
                    let questionsB = parseInt($b.find('.questions-count .count').text()) || 0;
                    return questionsB - questionsA;
                case 'attempts_desc':
                    let attemptsA = parseInt($a.find('.stat-item span:first').text().replace(/[^0-9]/g, '')) || 0;
                    let attemptsB = parseInt($b.find('.stat-item span:first').text().replace(/[^0-9]/g, '')) || 0;
                    return attemptsB - attemptsA;
                case 'oldest':
                    return $a.find('td:first').text().replace('#', '') - $b.find('td:first').text().replace('#', '');
                default: // latest
                    return $b.find('td:first').text().replace('#', '') - $a.find('td:first').text().replace('#', '');
            }
        });
        
        // Rebuild tbody
        let tbody = $('#quizzesTable tbody');
        tbody.empty();
        
        if (filteredRows.length) {
            tbody.append(filteredRows);
        } else {
            tbody.append(`
                <tr>
                    <td colspan="8" class="text-center py-5">
                        <div class="empty-state">
                            <i class="fas fa-search fa-3x text-muted mb-3"></i>
                            <h5>No Results Found</h5>
                            <p class="text-muted">Try adjusting your filters</p>
                        </div>
                    </td>
                </tr>
            `);
        }
    }
});

// Delete confirmation
function confirmDelete(quizId, quizTitle) {
    $('#deleteQuizTitle').text(quizTitle);
    $('#deleteModal').modal('show');
    
    $('#confirmDeleteBtn').off('click').on('click', function() {
        $(`#delete-form-${quizId}`).submit();
    });
}
</script>
@endpush