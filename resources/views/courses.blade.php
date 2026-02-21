@extends('layouts.main')

@section('title', 'All Courses - EDUCONECX')

@section('meta_description', 'Browse our comprehensive collection of courses in business, technology, design, and more. Start your learning journey today with EDUCONECX.')

@push('styles')
<style>
    /* Courses Archive Styles */
    .courses-archive {
        padding: 40px 0;
    }
    
    .archive-header {
        margin-bottom: 30px;
    }
    
    .archive-title {
        font-size: 36px;
        margin-bottom: 10px;
        color: var(--text-color);
    }
    
    .archive-description {
        color: #666;
        font-size: 18px;
    }
    
    /* Course Filter Sidebar */
    .course-filter-sidebar {
        background: #fff;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .filter-widget {
        margin-bottom: 30px;
    }
    
    .filter-widget-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid var(--primary-color);
    }
    
    .filter-search {
        position: relative;
    }
    
    .filter-search input {
        width: 100%;
        padding: 12px 40px 12px 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
    }
    
    .filter-search button {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #666;
        cursor: pointer;
    }
    
    .filter-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .filter-list li {
        margin-bottom: 10px;
    }
    
    .filter-list label {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        font-size: 15px;
        color: #555;
    }
    
    .filter-list input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }
    
    .filter-count {
        margin-left: auto;
        color: #999;
        font-size: 13px;
    }
    
    .clear-filters {
        display: inline-block;
        padding: 10px 20px;
        background: #f8f9fa;
        color: #666;
        border-radius: 5px;
        text-decoration: none;
        font-size: 14px;
        transition: all 0.3s;
    }
    
    .clear-filters:hover {
        background: #e9ecef;
        color: var(--primary-color);
    }
    
    .clear-filters i {
        margin-right: 5px;
    }
    
    /* Mobile Filter Toggle */
    .mobile-filter-toggle {
        display: none;
        margin-bottom: 20px;
    }
    
    .filter-toggle-btn {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        padding: 15px;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
    }
    
    .filter-toggle-btn i {
        transition: transform 0.3s;
    }
    
    .filter-toggle-btn.active i {
        transform: rotate(180deg);
    }
    
    /* Sort Bar */
    .sort-bar {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 20px;
    }
    
    .sort-select {
        padding: 10px 30px 10px 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
        background: #fff;
        cursor: pointer;
        min-width: 200px;
    }
    
    /* Course Grid */
    .course-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 30px;
        margin-bottom: 40px;
    }
    
    .course-card {
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        transition: all 0.3s;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .course-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    }
    
    .course-thumbnail {
        position: relative;
        padding-top: 56.25%; /* 16:9 Aspect Ratio */
        overflow: hidden;
    }
    
    .course-thumbnail img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s;
    }
    
    .course-card:hover .course-thumbnail img {
        transform: scale(1.05);
    }
    
    .course-bookmark {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 2;
    }
    
    .bookmark-btn {
        width: 35px;
        height: 35px;
        background: rgba(255,255,255,0.9);
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: #666;
        transition: all 0.3s;
    }
    
    .bookmark-btn:hover {
        background: var(--primary-color);
        color: #fff;
    }
    
    .course-content {
        padding: 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    
    .course-ratings {
        display: flex;
        align-items: center;
        gap: 5px;
        margin-bottom: 10px;
    }
    
    .stars {
        color: #ffc107;
    }
    
    .rating-count {
        color: #999;
        font-size: 13px;
    }
    
    .course-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 10px;
        line-height: 1.4;
    }
    
    .course-title a {
        color: var(--text-color);
        text-decoration: none;
        transition: color 0.3s;
    }
    
    .course-title a:hover {
        color: var(--primary-color);
    }
    
    .course-meta {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
        color: #666;
        font-size: 14px;
    }
    
    .course-meta i {
        margin-right: 5px;
    }
    
    .course-instructor {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: auto;
        margin-bottom: 15px;
        padding-top: 15px;
        border-top: 1px solid #eee;
    }
    
    .instructor-avatar {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background: var(--primary-color);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 14px;
    }
    
    .instructor-info {
        flex: 1;
    }
    
    .instructor-name {
        font-weight: 600;
        font-size: 14px;
        color: var(--text-color);
        text-decoration: none;
    }
    
    .instructor-name:hover {
        color: var(--primary-color);
    }
    
    .course-category {
        font-size: 13px;
        color: #999;
    }
    
    .course-footer {
        padding: 15px 20px;
        border-top: 1px solid #eee;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .course-price {
        font-size: 20px;
        font-weight: 700;
        color: var(--primary-color);
    }
    
    .course-price.free {
        color: #28a745;
    }
    
    .price-label {
        font-size: 12px;
        font-weight: 400;
        color: #999;
        display: block;
    }
    
    .enroll-btn {
        display: inline-block;
        padding: 8px 20px;
        background: var(--primary-color);
        color: #fff;
        border-radius: 5px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s;
    }
    
    .enroll-btn:hover {
        background: var(--primary-hover);
    }
    
    .enroll-btn.view-details {
        background: transparent;
        color: var(--primary-color);
        border: 1px solid var(--primary-color);
    }
    
    .enroll-btn.view-details:hover {
        background: var(--primary-color);
        color: #fff;
    }
    
    /* No Results */
    .no-results {
        text-align: center;
        padding: 60px 20px;
        background: #f8f9fa;
        border-radius: 10px;
    }
    
    .no-results i {
        font-size: 60px;
        color: #ccc;
        margin-bottom: 20px;
    }
    
    .no-results h3 {
        font-size: 24px;
        margin-bottom: 10px;
        color: var(--text-color);
    }
    
    .no-results p {
        color: #666;
        margin-bottom: 20px;
    }
    
    .reset-btn {
        display: inline-block;
        padding: 10px 30px;
        background: var(--primary-color);
        color: #fff;
        border-radius: 5px;
        text-decoration: none;
    }
    
    /* Pagination */
    .pagination {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 40px;
    }
    
    .pagination a,
    .pagination span {
        display: inline-block;
        padding: 8px 15px;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 5px;
        color: var(--text-color);
        text-decoration: none;
        transition: all 0.3s;
    }
    
    .pagination a:hover {
        background: var(--primary-color);
        color: #fff;
        border-color: var(--primary-color);
    }
    
    .pagination .active span {
        background: var(--primary-color);
        color: #fff;
        border-color: var(--primary-color);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .archive-title {
            font-size: 28px;
        }
        
        .course-filter-sidebar {
            display: none;
        }
        
        .course-filter-sidebar.active {
            display: block;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1000;
            overflow-y: auto;
            border-radius: 0;
        }
        
        .mobile-filter-toggle {
            display: block;
        }
        
        .sort-bar {
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .sort-select {
            width: 100%;
        }
        
        .course-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
    }
</style>
@endpush

@section('content')
<div class="container courses-archive">
    <!-- Header -->
    <div class="archive-header animate-on-scroll">
        <h1 class="archive-title">All Courses</h1>
        <p class="archive-description">Browse our comprehensive collection of courses and start your learning journey today.</p>
    </div>

    <!-- Mobile Filter Toggle -->
    <div class="mobile-filter-toggle">
        <button class="filter-toggle-btn" id="filterToggle">
            <span>Filter Courses</span>
            <i class="fas fa-chevron-down"></i>
        </button>
    </div>

    <div class="row">
        <!-- Filter Sidebar -->
        <div class="col-md-3">
            <div class="course-filter-sidebar" id="filterSidebar">
                <div class="filter-widget">
                    <h3 class="filter-widget-title">Search</h3>
                    <div class="filter-search">
                        <form id="searchForm" method="GET" action="{{ route('courses') }}">
                            <input type="text" name="keyword" placeholder="Search courses..." value="{{ $filters['keyword'] ?? '' }}">
                            <button type="submit"><i class="fas fa-search"></i></button>
                        </form>
                    </div>
                </div>

                <div class="filter-widget">
                    <h3 class="filter-widget-title">Categories</h3>
                    <ul class="filter-list" id="categoryFilter">
                        @foreach($categories as $category)
                        <li>
                            <label>
                                <input type="checkbox" name="categories[]" value="{{ $category['id'] }}" 
                                    {{ in_array($category['id'], $filters['categories'] ?? []) ? 'checked' : '' }}>
                                {{ $category['name'] }}
                                <span class="filter-count">({{ $category['count'] }})</span>
                            </label>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="filter-widget">
                    <h3 class="filter-widget-title">Price</h3>
                    <ul class="filter-list" id="priceFilter">
                        <li>
                            <label>
                                <input type="checkbox" name="price[]" value="free" 
                                    {{ in_array('free', $filters['price'] ?? []) ? 'checked' : '' }}>
                                Free
                            </label>
                        </li>
                        <li>
                            <label>
                                <input type="checkbox" name="price[]" value="paid" 
                                    {{ in_array('paid', $filters['price'] ?? []) ? 'checked' : '' }}>
                                Paid
                            </label>
                        </li>
                    </ul>
                </div>

                <div class="filter-widget">
                    <a href="{{ route('courses') }}" class="clear-filters">
                        <i class="fas fa-times"></i> Clear All Filters
                    </a>
                </div>
            </div>
        </div>

        <!-- Courses Grid -->
        <div class="col-md-9">
            <!-- Sort Bar -->
            <div class="sort-bar">
                <form id="sortForm" method="GET" action="{{ route('courses') }}">
                    <select name="sort" class="sort-select" id="sortSelect">
                        <option value="newest_first" {{ ($filters['sort'] ?? '') == 'newest_first' ? 'selected' : '' }}>Release Date (newest first)</option>
                        <option value="oldest_first" {{ ($filters['sort'] ?? '') == 'oldest_first' ? 'selected' : '' }}>Release Date (oldest first)</option>
                        <option value="course_title_az" {{ ($filters['sort'] ?? '') == 'course_title_az' ? 'selected' : '' }}>Course Title (a-z)</option>
                        <option value="course_title_za" {{ ($filters['sort'] ?? '') == 'course_title_za' ? 'selected' : '' }}>Course Title (z-a)</option>
                    </select>
                    
                    <!-- Preserve other filters -->
                    @if(!empty($filters['keyword']))
                        <input type="hidden" name="keyword" value="{{ $filters['keyword'] }}">
                    @endif
                    @if(!empty($filters['categories']))
                        @foreach($filters['categories'] as $category)
                            <input type="hidden" name="categories[]" value="{{ $category }}">
                        @endforeach
                    @endif
                    @if(!empty($filters['price']))
                        @foreach($filters['price'] as $price)
                            <input type="hidden" name="price[]" value="{{ $price }}">
                        @endforeach
                    @endif
                </form>
            </div>

            <!-- Courses Container -->
            <div id="coursesContainer">
                @include('partials.course-list', ['courses' => $paginatedCourses])
            </div>

            <!-- Pagination -->
            @if($paginatedCourses instanceof \Illuminate\Pagination\LengthAwarePaginator && $paginatedCourses->hasPages())
                <div class="pagination">
                    {{ $paginatedCourses->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mobile filter toggle
    const filterToggle = document.getElementById('filterToggle');
    const filterSidebar = document.getElementById('filterSidebar');
    
    if (filterToggle) {
        filterToggle.addEventListener('click', function() {
            this.classList.toggle('active');
            filterSidebar.classList.toggle('active');
            
            if (filterSidebar.classList.contains('active')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        });
    }
    
    // Close filter sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
        if (window.innerWidth <= 768) {
            if (!filterSidebar.contains(event.target) && !filterToggle.contains(event.target)) {
                filterSidebar.classList.remove('active');
                filterToggle.classList.remove('active');
                document.body.style.overflow = '';
            }
        }
    });
    
    // Handle filter changes with AJAX
    const filterInputs = document.querySelectorAll('#categoryFilter input, #priceFilter input');
    const searchForm = document.getElementById('searchForm');
    const sortSelect = document.getElementById('sortSelect');
    
    function updateCourses() {
        // Collect filter values
        const categories = [];
        document.querySelectorAll('#categoryFilter input:checked').forEach(input => {
            categories.push(input.value);
        });
        
        const prices = [];
        document.querySelectorAll('#priceFilter input:checked').forEach(input => {
            prices.push(input.value);
        });
        
        const keyword = document.querySelector('input[name="keyword"]')?.value || '';
        const sort = sortSelect.value;
        
        // Build URL with filters
        let url = '{{ route('courses') }}?';
        const params = new URLSearchParams();
        
        if (keyword) params.append('keyword', keyword);
        if (sort) params.append('sort', sort);
        categories.forEach(cat => params.append('categories[]', cat));
        prices.forEach(price => params.append('price[]', price));
        
        // For AJAX, we'll use a special endpoint
        fetch('{{ route('courses.filter') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                keyword: keyword,
                categories: categories,
                price: prices,
                sort: sort
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('coursesContainer').innerHTML = data.html;
            }
        });
    }
    
    // Debounce function to limit AJAX calls
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
    
    const debouncedUpdate = debounce(updateCourses, 500);
    
    // Event listeners
    filterInputs.forEach(input => {
        input.addEventListener('change', debouncedUpdate);
    });
    
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            debouncedUpdate();
        });
    }
    
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            // For sort changes, we can either use AJAX or submit the form
            // Using AJAX for smoother experience
            debouncedUpdate();
        });
    }
});
</script>
@endpush