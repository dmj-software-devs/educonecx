@extends('layouts.admin')

@section('title', 'Courses')
@section('page-title', 'Course Management')

@section('content')
<!-- Header Section -->
<div class="header-section">
    <div class="header-content">
        <h2>Courses</h2>
        <p>Manage and organize your learning content</p>
    </div>
    <div class="header-actions">
        <a href="{{ route('admin.courses.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> New Course
        </a>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-tags"></i> Categories
        </a>
    </div>
</div>

<!-- Stats Summary -->
<div class="row g-4 mb-4">
    <!-- ... existing stats ... -->
    <div class="col-lg-3 col-md-6">
        <div class="stat-mini-card">
            <div class="stat-mini-icon bg-soft-success">
                <i class="fas fa-gift text-success"></i>
            </div>
            <div class="stat-mini-content">
                <span class="stat-mini-label">Free Courses</span>
                <span class="stat-mini-value">{{ $courses->where('is_free', true)->count() ?? 0 }}</span>
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
                <input type="text" id="searchInput" class="form-control" placeholder="Search courses...">
            </div>
        </div>
        <div class="col-lg-2 col-md-6">
            <label class="form-label">Category</label>
            <select id="categoryFilter" class="form-select">
                <option value="">All Categories</option>
                @foreach($categories ?? [] as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-2 col-md-6">
            <label class="form-label">Status</label>
            <select id="statusFilter" class="form-select">
                <option value="">All Status</option>
                <option value="published">Published</option>
                <option value="draft">Draft</option>
                <option value="archived">Archived</option>
            </select>
        </div>
        <div class="col-lg-2 col-md-6">
            <label class="form-label">Sort By</label>
            <select id="sortFilter" class="form-select">
                <option value="latest">Latest</option>
                <option value="oldest">Oldest</option>
                <option value="title_asc">Title A-Z</option>
                <option value="title_desc">Title Z-A</option>
                <option value="students_desc">Most Students</option>
                <option value="students_asc">Least Students</option>
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

<!-- Courses Table -->
<div class="table-wrapper">
    <table class="modern-table" id="coursesTable">
        <thead>
            <tr>
                <th width="50">#</th>
                <th>Course Details</th>
                <th>Category</th>
                <th>Pricing</th>
                <th>Status</th>
                <th>Students</th>
                <!-- <th>Rating</th> -->
                <th width="120">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($courses ?? [] as $course)
            <tr class="course-row" data-category="{{ $course->category_id }}" data-status="{{ $course->status }}">
                <td class="text-muted">#{{ $course->id }}</td>
                <td>
                    <div class="course-info">
                        @if($course->thumbnail)
                        <img src="{{ $course->thumbnail_url }}" alt="" class="course-thumb">
                        @else
                        <div class="course-thumb-placeholder">
                            <i class="fas fa-book"></i>
                        </div>
                        @endif
                        <div class="course-meta">
                            <a href="{{ route('admin.courses.edit', $course) }}" class="course-title">
                                {{ $course->title }}
                            </a>
                            <div class="course-subtitle">
                                <span><i class="far fa-clock"></i> {{ $course->duration ?? 'N/A' }}</span>
                                <span><i class="far fa-file-alt"></i> {{ $course->lessons_count ?? 0 }} lessons</span>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <span class="category-badge">
                        {{ $course->category->name ?? 'Uncategorized' }}
                    </span>
                </td>
                <td>
                    <div class="pricing-info">
                        @if($course->is_free)
                        <span class="free-badge">
                            <i class="fas fa-gift"></i> Free
                        </span>
                        @elseif($course->has_discount)
                        <span class="original-price">${{ number_format($course->price, 2) }}</span>
                        <span class="sale-price">${{ number_format($course->sale_price, 2) }}</span>
                        <span class="discount-badge">-{{ $course->discount_percentage }}%</span>
                        @else
                        <span class="current-price">${{ number_format($course->price, 2) }}</span>
                        @endif
                    </div>
                </td>
                <td>
                    @php
                    $statusColors = [
                    'published' => 'success',
                    'draft' => 'warning',
                    'archived' => 'secondary'
                    ];
                    $statusColor = $statusColors[$course->status] ?? 'secondary';
                    @endphp
                    <span class="status-badge status-{{ $statusColor }}">
                        {{ ucfirst($course->status) }}
                    </span>
                </td>
                <td>
                    <div class="students-count">
                        <i class="fas fa-user-graduate"></i>
                        {{ number_format($course->total_students) }}
                    </div>
                </td>
                <!-- <td>
                    <div class="rating">
                        <span class="stars">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <=round($course->average_rating))
                                <i class="fas fa-star"></i>
                                @else
                                <i class="far fa-star"></i>
                                @endif
                                @endfor
                        </span>
                        <span class="rating-value">({{ number_format($course->average_rating, 1) }})</span>
                    </div>
                </td> -->
                <td>
                    <div class="action-buttons">
                        <a href="{{ route('admin.courses.edit', $course) }}" class="action-btn edit-btn" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="{{ route('admin.courses.show', $course) }}" class="action-btn view-btn" title="View">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.courses.lessons', $course) }}" class="action-btn lessons-btn" title="Lessons">
                            <i class="fas fa-list"></i>
                        </a>
                        <button type="button" class="action-btn delete-btn"
                            onclick="confirmDelete({{ $course->id }}, '{{ $course->title }}')"
                            title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                        <form id="delete-form-{{ $course->id }}"
                            action="{{ route('admin.courses.destroy', $course) }}"
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
                        <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                        <h5>No Courses Found</h5>
                        <p class="text-muted">Get started by creating your first course</p>
                        <a href="{{ route('admin.courses.create') }}" class="btn btn-primary mt-2">
                            <i class="fas fa-plus-circle"></i> Create New Course
                        </a>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
@if($courses instanceof \Illuminate\Pagination\LengthAwarePaginator && $courses->hasPages())
<div class="pagination-wrapper">
    {{ $courses->links() }}
</div>
@endif

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong id="deleteCourseTitle"></strong>?</p>
                <p class="text-danger small">This action cannot be undone. All associated lessons and enrollments will also be deleted.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete Course</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
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
        color: #2c3e50;
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

    .header-actions .btn {
        padding: 10px 20px;
        font-weight: 500;
    }

    .header-actions .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        border: none;
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
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .stat-mini-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
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
        color: #2c3e50;
        line-height: 1.2;
    }

    /* Filters Section */
    .filters-section {
        background: white;
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
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

    .form-control,
    .form-select {
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 10px 12px;
        font-size: 0.95rem;
        transition: all 0.3s;
    }

    .form-control:focus,
    .form-select:focus {
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
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
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

    /* Course Info */
    .course-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .course-thumb {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        object-fit: cover;
    }

    .course-thumb-placeholder {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        background: #f1f3f5;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #adb5bd;
        font-size: 1.2rem;
    }

    .course-meta {
        flex: 1;
        min-width: 200px;
    }

    .course-title {
        font-weight: 600;
        color: #2c3e50;
        text-decoration: none;
        font-size: 1rem;
        display: block;
        margin-bottom: 4px;
    }

    .course-title:hover {
        color: var(--primary);
    }

    .course-subtitle {
        display: flex;
        gap: 15px;
        font-size: 0.85rem;
        color: #6c757d;
    }

    .course-subtitle span i {
        margin-right: 4px;
        font-size: 0.75rem;
    }

    /* Category Badge */
    .category-badge {
        background: #f1f3f5;
        color: #495057;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
        white-space: nowrap;
    }

    /* Pricing Info */
    .pricing-info {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .original-price {
        color: #6c757d;
        text-decoration: line-through;
        font-size: 0.85rem;
    }

    .sale-price {
        color: var(--danger);
        font-weight: 600;
        font-size: 1rem;
    }

    .current-price {
        font-weight: 600;
        color: #2c3e50;
        font-size: 1rem;
    }

    .discount-badge {
        background: rgba(231, 76, 60, 0.1);
        color: var(--danger);
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
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

    .status-secondary {
        background: rgba(108, 117, 125, 0.1);
        color: #6c757d;
    }

    /* Students Count */
    .students-count {
        display: flex;
        align-items: center;
        gap: 6px;
        color: #6c757d;
        font-size: 0.9rem;
    }

    .students-count i {
        color: var(--primary);
        font-size: 0.9rem;
    }

    /* Rating */
    .rating {
        display: flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .stars {
        color: #f1c40f;
        font-size: 0.85rem;
    }

    .stars i {
        margin-right: 2px;
    }

    .rating-value {
        color: #6c757d;
        font-size: 0.85rem;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 6px;
    }

    .action-btn {
        width: 32px;
        height: 32px;
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

    .edit-btn {
        background: var(--primary);
    }

    .edit-btn:hover {
        background: #0056b3;
        box-shadow: 0 4px 8px rgba(1, 123, 254, 0.2);
    }

    .view-btn {
        background: var(--info);
    }

    .view-btn:hover {
        background: #2980b9;
        box-shadow: 0 4px 8px rgba(52, 152, 219, 0.2);
    }

    .lessons-btn {
        background: var(--success);
    }

    .lessons-btn:hover {
        background: #00997a;
        box-shadow: 0 4px 8px rgba(0, 184, 148, 0.2);
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

    .pagination {
        display: flex;
        gap: 5px;
        list-style: none;
        padding: 0;
    }

    .pagination .page-item .page-link {
        border: 1px solid #e9ecef;
        padding: 8px 14px;
        border-radius: 8px;
        color: #6c757d;
        text-decoration: none;
        transition: all 0.3s;
    }

    .pagination .page-item.active .page-link {
        background: var(--primary);
        border-color: var(--primary);
        color: white;
    }

    .pagination .page-item .page-link:hover {
        background: #f8f9fa;
        color: var(--primary);
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
            flex: 1;
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

        .course-subtitle {
            flex-direction: column;
            gap: 4px;
        }

        .action-buttons {
            flex-wrap: wrap;
        }
    }

    @media (max-width: 576px) {
        .course-info {
            flex-direction: column;
            align-items: flex-start;
        }

        .course-meta {
            min-width: auto;
        }

        .pricing-info {
            flex-direction: column;
            align-items: flex-start;
        }
    }

    .free-badge {
        background: rgba(0, 184, 148, 0.1);
        color: var(--success);
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .free-badge i {
        font-size: 0.9rem;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize filters
        let currentFilters = {
            search: '',
            category: '',
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
            $('#categoryFilter').val('');
            $('#statusFilter').val('');
            $('#sortFilter').val('latest');
            applyFilters();
        });

        function applyFilters() {
            currentFilters.search = $('#searchInput').val().toLowerCase();
            currentFilters.category = $('#categoryFilter').val();
            currentFilters.status = $('#statusFilter').val();
            currentFilters.sort = $('#sortFilter').val();

            filterAndSortTable();
        }

        function filterAndSortTable() {
            let rows = $('#coursesTable tbody tr').get();

            // Filter rows
            let filteredRows = rows.filter(row => {
                let $row = $(row);
                let title = $row.find('.course-title').text().toLowerCase();
                let category = $row.data('category')?.toString() || '';
                let status = $row.data('status') || '';

                // Search filter
                if (currentFilters.search && !title.includes(currentFilters.search)) {
                    return false;
                }

                // Category filter
                if (currentFilters.category && category !== currentFilters.category) {
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

                switch (currentFilters.sort) {
                    case 'title_asc':
                        return $a.find('.course-title').text().localeCompare($b.find('.course-title').text());
                    case 'title_desc':
                        return $b.find('.course-title').text().localeCompare($a.find('.course-title').text());
                    case 'students_desc':
                        let studentsA = parseInt($a.find('.students-count').text().replace(/[^0-9]/g, '')) || 0;
                        let studentsB = parseInt($b.find('.students-count').text().replace(/[^0-9]/g, '')) || 0;
                        return studentsB - studentsA;
                    case 'students_asc':
                        studentsA = parseInt($a.find('.students-count').text().replace(/[^0-9]/g, '')) || 0;
                        studentsB = parseInt($b.find('.students-count').text().replace(/[^0-9]/g, '')) || 0;
                        return studentsA - studentsB;
                    case 'oldest':
                        return $a.find('td:first').text().replace('#', '') - $b.find('td:first').text().replace('#', '');
                    default: // latest
                        return $b.find('td:first').text().replace('#', '') - $a.find('td:first').text().replace('#', '');
                }
            });

            // Rebuild tbody
            let tbody = $('#coursesTable tbody');
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
    function confirmDelete(courseId, courseTitle) {
        $('#deleteCourseTitle').text(courseTitle);
        $('#deleteModal').modal('show');

        $('#confirmDeleteBtn').off('click').on('click', function() {
            $(`#delete-form-${courseId}`).submit();
        });
    }
</script>
@endpush