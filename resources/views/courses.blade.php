@extends('layouts.main')

@section('title', 'All Courses - EDUCONECX | Browse Our Learning Programs')

@section('meta_description', 'Browse our comprehensive collection of courses in business, technology, design, language, and more. Start your learning journey today with EDUCONECX.')

@push('styles')
<style>
    /* Hero Section */
    .courses-hero {
        position: relative;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 80px 0;
        overflow: hidden;
        color: var(--white);
    }

    .courses-hero-particles {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    .courses-hero-particle {
        position: absolute;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .courses-hero-particle:nth-child(1) {
        width: 300px;
        height: 300px;
        top: -100px;
        right: -100px;
        animation: float 8s ease-in-out infinite;
    }

    .courses-hero-particle:nth-child(2) {
        width: 200px;
        height: 200px;
        bottom: -50px;
        left: -50px;
        animation: float 10s ease-in-out infinite reverse;
    }

    .courses-hero-particle:nth-child(3) {
        width: 150px;
        height: 150px;
        top: 30%;
        left: 20%;
        animation: float 12s ease-in-out infinite;
    }

    .courses-hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
        max-width: 800px;
        margin: 0 auto;
    }

    .courses-hero-badge {
        display: inline-block;
        padding: 8px 20px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: var(--border-radius-full);
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 20px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .courses-hero-title {
        font-size: clamp(2rem, 6vw, 3rem);
        font-weight: 800;
        margin-bottom: 15px;
        line-height: 1.2;
    }

    .courses-hero-text {
        font-size: 1.2rem;
        opacity: 0.9;
        margin-bottom: 30px;
    }

    .courses-hero-search {
        max-width: 600px;
        margin: 0 auto;
        position: relative;
    }

    .courses-hero-search input {
        width: 100%;
        padding: 18px 60px 18px 25px;
        border: none;
        border-radius: 50px;
        font-size: 1rem;
        box-shadow: var(--shadow-lg);
        transition: var(--transition);
    }

    .courses-hero-search input:focus {
        outline: none;
        box-shadow: 0 10px 40px rgba(0,0,0,0.2);
    }

    .courses-hero-search button {
        position: absolute;
        right: 5px;
        top: 5px;
        width: 50px;
        height: 50px;
        background: var(--gradient-1);
        border: none;
        border-radius: 50%;
        color: var(--white);
        font-size: 1.2rem;
        cursor: pointer;
        transition: var(--transition);
    }

    .courses-hero-search button:hover {
        transform: scale(1.1);
    }

    /* Main Content */
    .courses-main {
        padding: 60px 0;
        background: var(--light);
    }

    /* Filter Sidebar */
    .filter-sidebar {
        background: var(--white);
        border-radius: var(--border-radius-lg);
        padding: 30px;
        box-shadow: var(--shadow-sm);
        position: sticky;
        top: 100px;
        transition: var(--transition);
    }

    .filter-sidebar.sticky {
        box-shadow: var(--shadow-lg);
    }

    .filter-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 2px solid var(--light);
    }

    .filter-header h3 {
        font-size: 1.3rem;
        font-weight: 700;
        margin: 0;
    }

    .filter-header h3 i {
        color: var(--primary);
        margin-right: 10px;
    }

    .clear-filters {
        color: var(--gray);
        font-size: 0.9rem;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 5px;
        transition: var(--transition);
    }

    .clear-filters:hover {
        color: var(--danger);
    }

    .filter-section {
        margin-bottom: 30px;
    }

    .filter-section-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 15px;
        color: var(--dark);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .filter-section-title i {
        color: var(--primary);
        font-size: 1rem;
    }

    .filter-options {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .filter-option {
        margin-bottom: 12px;
    }

    .filter-option label {
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        font-size: 0.95rem;
        color: var(--gray);
        transition: var(--transition);
    }

    .filter-option label:hover {
        color: var(--primary);
    }

    .filter-option input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: var(--primary);
    }

    .filter-count {
        margin-left: auto;
        background: var(--light);
        padding: 2px 8px;
        border-radius: 20px;
        font-size: 0.8rem;
        color: var(--gray);
    }

    .price-range {
        padding: 10px 0;
    }

    .price-inputs {
        display: flex;
        gap: 10px;
        margin-bottom: 15px;
    }

    .price-input {
        flex: 1;
    }

    .price-input label {
        display: block;
        font-size: 0.8rem;
        color: var(--gray);
        margin-bottom: 5px;
    }

    .price-input input {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid var(--gray-light);
        border-radius: var(--border-radius-sm);
        font-size: 0.9rem;
    }

    .price-input input:focus {
        outline: none;
        border-color: var(--primary);
    }

    /* Rating Stars */
    .rating-stars {
        display: flex;
        gap: 2px;
        color: #ffc107;
    }

    .rating-stars i {
        font-size: 0.9rem;
    }

    .rating-count {
        color: var(--gray);
        font-size: 0.8rem;
        margin-left: 5px;
    }

    /* Sort Bar */
    .sort-bar {
        background: var(--white);
        border-radius: var(--border-radius-lg);
        padding: 15px 20px;
        margin-bottom: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        box-shadow: var(--shadow-sm);
    }

    .results-count {
        color: var(--gray);
        font-size: 0.95rem;
    }

    .results-count strong {
        color: var(--dark);
        font-size: 1.1rem;
    }

    .sort-select {
        padding: 10px 35px 10px 15px;
        border: 1px solid var(--gray-light);
        border-radius: var(--border-radius-md);
        font-size: 0.95rem;
        background: var(--white);
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23666' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 10px center;
    }

    .sort-select:focus {
        outline: none;
        border-color: var(--primary);
    }

    /* Course Grid */
    .course-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 30px;
        margin-bottom: 40px;
    }

    .course-card {
        background: var(--white);
        border-radius: var(--border-radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        height: 100%;
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .course-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-lg);
    }

    .course-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        z-index: 2;
        padding: 5px 15px;
        background: var(--gradient-1);
        color: var(--white);
        border-radius: var(--border-radius-full);
        font-size: 0.8rem;
        font-weight: 600;
        box-shadow: var(--shadow-md);
    }

    .course-badge.free {
        background: var(--success);
    }

    .course-badge.popular {
        background: var(--accent);
    }

    .course-bookmark {
        position: absolute;
        top: 15px;
        right: 15px;
        z-index: 2;
    }

    .bookmark-btn {
        width: 40px;
        height: 40px;
        background: var(--white);
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: var(--gray);
        transition: var(--transition);
        box-shadow: var(--shadow-md);
    }

    .bookmark-btn:hover {
        background: var(--primary);
        color: var(--white);
        transform: scale(1.1);
    }

    .bookmark-btn.active {
        background: var(--primary);
        color: var(--white);
    }

    .course-thumbnail {
        position: relative;
        overflow: hidden;
        aspect-ratio: 16/9;
    }

    .course-thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition-slow);
    }

    .course-card:hover .course-thumbnail img {
        transform: scale(1.1);
    }

    .course-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom, transparent 0%, rgba(0,0,0,0.8) 100%);
        opacity: 0;
        transition: var(--transition);
        display: flex;
        align-items: flex-end;
        padding: 20px;
    }

    .course-card:hover .course-overlay {
        opacity: 1;
    }

    .course-preview {
        color: var(--white);
        font-size: 0.9rem;
    }

    .course-preview i {
        margin-right: 5px;
    }

    .course-content {
        padding: 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .course-meta-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .course-category {
        font-size: 0.8rem;
        color: var(--primary);
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
    }

    .course-rating {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .course-rating .stars {
        color: #ffc107;
        font-size: 0.9rem;
    }

    .course-rating .rating-value {
        font-weight: 600;
        color: var(--dark);
    }

    .course-rating .rating-count {
        color: var(--gray);
        font-size: 0.8rem;
    }

    .course-title {
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 10px;
        line-height: 1.4;
    }

    .course-title a {
        color: var(--dark);
        text-decoration: none;
        transition: var(--transition);
    }

    .course-title a:hover {
        color: var(--primary);
    }

    .course-description {
        color: var(--gray);
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 15px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .course-meta {
        display: flex;
        gap: 15px;
        margin-bottom: 15px;
        color: var(--gray);
        font-size: 0.9rem;
        flex-wrap: wrap;
    }

    .course-meta i {
        color: var(--primary);
        margin-right: 5px;
    }

    .course-instructor {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: auto;
        margin-bottom: 15px;
        padding-top: 15px;
        border-top: 1px solid var(--gray-light);
    }

    .instructor-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--gradient-1);
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 1rem;
    }

    .instructor-info {
        flex: 1;
    }

    .instructor-name {
        font-weight: 600;
        font-size: 0.95rem;
        color: var(--dark);
        text-decoration: none;
        transition: var(--transition);
    }

    .instructor-name:hover {
        color: var(--primary);
    }

    .instructor-title {
        font-size: 0.8rem;
        color: var(--gray);
    }

    .course-footer {
        padding: 15px 20px;
        border-top: 1px solid var(--gray-light);
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: var(--light);
    }

    .course-price {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary);
    }

    .course-price.free {
        color: var(--success);
    }

    .price-label {
        font-size: 0.7rem;
        font-weight: 400;
        color: var(--gray);
        display: block;
        line-height: 1;
    }

    .course-price small {
        font-size: 0.9rem;
        font-weight: 400;
        color: var(--gray);
        text-decoration: line-through;
        margin-left: 5px;
    }

    .enroll-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: var(--gradient-1);
        color: var(--white);
        border-radius: var(--border-radius-full);
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        transition: var(--transition);
        border: none;
        cursor: pointer;
    }

    .enroll-btn:hover {
        transform: translateX(5px);
        box-shadow: var(--shadow-md);
    }

    .enroll-btn i {
        font-size: 0.8rem;
    }

    /* No Results */
    .no-results {
        text-align: center;
        padding: 60px 20px;
        background: var(--white);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-sm);
    }

    .no-results-icon {
        width: 120px;
        height: 120px;
        background: var(--light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px;
        font-size: 3rem;
        color: var(--gray);
    }

    .no-results h3 {
        font-size: 1.8rem;
        margin-bottom: 10px;
        color: var(--dark);
    }

    .no-results p {
        color: var(--gray);
        margin-bottom: 25px;
        font-size: 1.1rem;
    }

    .reset-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 12px 30px;
        background: var(--gradient-1);
        color: var(--white);
        border-radius: var(--border-radius-full);
        text-decoration: none;
        font-weight: 600;
        transition: var(--transition);
    }

    .reset-btn:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-lg);
    }

    /* Pagination */
    .pagination {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-top: 40px;
        flex-wrap: wrap;
    }

    .pagination .page-item {
        list-style: none;
    }

    .pagination .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 40px;
        padding: 0 10px;
        background: var(--white);
        border: 1px solid var(--gray-light);
        border-radius: var(--border-radius-md);
        color: var(--dark);
        text-decoration: none;
        transition: var(--transition);
        font-weight: 500;
    }

    .pagination .page-link:hover {
        background: var(--primary);
        color: var(--white);
        border-color: var(--primary);
    }

    .pagination .active .page-link {
        background: var(--primary);
        color: var(--white);
        border-color: var(--primary);
    }

    .pagination .disabled .page-link {
        background: var(--light);
        color: var(--gray);
        pointer-events: none;
        border-color: var(--gray-light);
    }

    /* Mobile Filter */
    .mobile-filter-toggle {
        display: none;
        margin-bottom: 20px;
    }

    .filter-toggle-btn {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        padding: 15px 20px;
        background: var(--white);
        border: none;
        border-radius: var(--border-radius-md);
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        box-shadow: var(--shadow-sm);
    }

    .filter-toggle-btn i {
        transition: var(--transition);
    }

    .filter-toggle-btn.active i {
        transform: rotate(180deg);
    }

    /* Loading Spinner */
    .loading-spinner {
        display: none;
        text-align: center;
        padding: 40px;
    }

    .loading-spinner.show {
        display: block;
    }

    .spinner {
        width: 50px;
        height: 50px;
        border: 4px solid var(--light);
        border-top-color: var(--primary);
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Responsive */
    @media (max-width: 992px) {
        .filter-sidebar {
            position: fixed;
            top: 0;
            left: -100%;
            width: 300px;
            height: 100vh;
            z-index: 9999;
            border-radius: 0;
            overflow-y: auto;
            transition: left 0.3s ease;
        }

        .filter-sidebar.active {
            left: 0;
        }

        .mobile-filter-toggle {
            display: block;
        }

        .course-grid {
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        }
    }

    @media (max-width: 768px) {
        .courses-hero {
            padding: 60px 0;
        }

        .courses-hero-title {
            font-size: 2rem;
        }

        .courses-hero-text {
            font-size: 1rem;
        }

        .sort-bar {
            flex-direction: column;
            align-items: stretch;
        }

        .sort-select {
            width: 100%;
        }

        .course-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
    <!-- Hero Section -->
    <section class="courses-hero">
        <div class="courses-hero-particles">
            <div class="courses-hero-particle"></div>
            <div class="courses-hero-particle"></div>
            <div class="courses-hero-particle"></div>
        </div>
        
        <div class="container">
            <div class="courses-hero-content" data-aos="fade-up">
                <span class="courses-hero-badge">Start Learning Today</span>
                <h1 class="courses-hero-title">Browse Our Course Library</h1>
                <p class="courses-hero-text">
                    Discover expert-led courses designed to help you master new skills and advance your career
                </p>
                
                <form id="searchForm" method="GET" action="{{ route('courses') }}" class="courses-hero-search">
                    <input type="text" name="keyword" placeholder="What do you want to learn?" value="{{ $filters['keyword'] ?? '' }}">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="courses-main">
        <div class="container">
            <!-- Mobile Filter Toggle -->
            <div class="mobile-filter-toggle">
                <button class="filter-toggle-btn" id="filterToggle">
                    <span><i class="fas fa-sliders-h"></i> Filter Courses</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
            </div>

            <div class="row">
                <!-- Filter Sidebar -->
                <div class="col-lg-3">
                    <div class="filter-sidebar" id="filterSidebar">
                        <div class="filter-header">
                            <h3><i class="fas fa-filter"></i> Filters</h3>
                            <a href="{{ route('courses') }}" class="clear-filters">
                                <i class="fas fa-times"></i> Clear All
                            </a>
                        </div>

                        <!-- Categories Filter -->
                        <div class="filter-section">
                            <h4 class="filter-section-title">
                                <i class="fas fa-folder"></i> Categories
                            </h4>
                            <ul class="filter-options" id="categoryFilter">
                                @foreach($categories as $category)
                                <li class="filter-option">
                                    <label>
                                        <input type="checkbox" name="categories[]" value="{{ $category['id'] }}" 
                                            {{ in_array($category['id'], $filters['categories'] ?? []) ? 'checked' : '' }}>
                                        {{ $category['name'] }}
                                        <span class="filter-count">{{ $category['count'] }}</span>
                                    </label>
                                </li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Price Filter -->
                        <div class="filter-section">
                            <h4 class="filter-section-title">
                                <i class="fas fa-tag"></i> Price
                            </h4>
                            <ul class="filter-options" id="priceFilter">
                                <li class="filter-option">
                                    <label>
                                        <input type="checkbox" name="price[]" value="free" 
                                            {{ in_array('free', $filters['price'] ?? []) ? 'checked' : '' }}>
                                        Free Courses
                                        <span class="filter-count">{{ \App\Models\Course::published()->free()->count() }}</span>
                                    </label>
                                </li>
                                <li class="filter-option">
                                    <label>
                                        <input type="checkbox" name="price[]" value="paid" 
                                            {{ in_array('paid', $filters['price'] ?? []) ? 'checked' : '' }}>
                                        Paid Courses
                                        <span class="filter-count">{{ \App\Models\Course::published()->paid()->count() }}</span>
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Courses Grid -->
                <div class="col-lg-9">
                    <!-- Sort Bar -->
                    <div class="sort-bar" data-aos="fade-up">
                        <div class="results-count">
                            Showing <strong>{{ $paginatedCourses->firstItem() ?? 0 }}</strong> - <strong>{{ $paginatedCourses->lastItem() ?? 0 }}</strong> of <strong>{{ $paginatedCourses->total() }}</strong> courses
                        </div>
                        
                        <form id="sortForm" method="GET" action="{{ route('courses') }}">
                            <select name="sort" class="sort-select" id="sortSelect">
                                <option value="newest_first" {{ ($filters['sort'] ?? '') == 'newest_first' ? 'selected' : '' }}>Most Recent</option>
                                <option value="oldest_first" {{ ($filters['sort'] ?? '') == 'oldest_first' ? 'selected' : '' }}>Oldest First</option>
                                <option value="course_title_az" {{ ($filters['sort'] ?? '') == 'course_title_az' ? 'selected' : '' }}>Course Title (A-Z)</option>
                                <option value="course_title_za" {{ ($filters['sort'] ?? '') == 'course_title_za' ? 'selected' : '' }}>Course Title (Z-A)</option>
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

                    <!-- Loading Spinner -->
                    <div class="loading-spinner" id="loadingSpinner">
                        <div class="spinner"></div>
                    </div>

                    <!-- Courses Container -->
                    <div id="coursesContainer">
                        @if($paginatedCourses->count() > 0)
                            <div class="course-grid">
                                @foreach($paginatedCourses as $course)
                                    <div class="course-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                                        @if($course->featured)
                                            <span class="course-badge popular">Popular</span>
                                        @elseif($course->price == 0 || ($course->sale_price == 0))
                                            <span class="course-badge free">Free</span>
                                        @endif
                                        
                                        <div class="course-bookmark">
                                            <button class="bookmark-btn" data-course-id="{{ $course->id }}">
                                                <i class="far fa-bookmark"></i>
                                            </button>
                                        </div>
                                        
                                        <div class="course-thumbnail">
                                            <img src="{{ $course->thumbnail_url }}" alt="{{ $course->title }}">
                                            <div class="course-overlay">
                                                <span class="course-preview"><i class="far fa-play-circle"></i> Preview Course</span>
                                            </div>
                                        </div>
                                        
                                        <div class="course-content">
                                            <div class="course-meta-top">
                                                <span class="course-category">{{ $course->category->name ?? 'General' }}</span>
                                                <div class="course-rating">
                                                    <span class="stars">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            @if($i <= floor($course->average_rating))
                                                                <i class="fas fa-star"></i>
                                                            @elseif($i - 0.5 <= $course->average_rating)
                                                                <i class="fas fa-star-half-alt"></i>
                                                            @else
                                                                <i class="far fa-star"></i>
                                                            @endif
                                                        @endfor
                                                    </span>
                                                    <span class="rating-value">{{ number_format($course->average_rating, 1) }}</span>
                                                    <span class="rating-count">({{ $course->total_reviews }})</span>
                                                </div>
                                            </div>
                                            
                                            <h3 class="course-title">
                                                <a href="{{ route('courses.show', $course->slug) }}">{{ $course->title }}</a>
                                            </h3>
                                            
                                            <p class="course-description">{{ $course->excerpt }}</p>
                                            
                                            <div class="course-meta">
                                                <span><i class="far fa-clock"></i> {{ $course->duration }} hours</span>
                                                <span><i class="fas fa-signal"></i> {{ $course->level }}</span>
                                                <span><i class="fas fa-video"></i> {{ $course->total_lessons }} lessons</span>
                                            </div>
                                            
                                            <div class="course-instructor">
                                                <div class="instructor-avatar">
                                                    {{ substr($course->instructor->name ?? 'EA', 0, 1) }}
                                                </div>
                                                <div class="instructor-info">
                                                    <span class="instructor-name">{{ $course->instructor->name ?? 'EDUCONECX ACADEMY' }}</span>
                                                    <div class="instructor-title">Expert Instructor</div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="course-footer">
                                            <div class="course-price {{ $course->price == 0 ? 'free' : '' }}">
                                                @if($course->hasDiscount)
                                                    ${{ number_format($course->sale_price, 2) }}
                                                    <small>${{ number_format($course->price, 2) }}</small>
                                                @elseif($course->price > 0)
                                                    ${{ number_format($course->price, 2) }}
                                                @else
                                                    Free
                                                @endif
                                                <span class="price-label">one-time payment</span>
                                            </div>
                                            <a href="{{ route('courses.show', $course->slug) }}" class="enroll-btn">
                                                View Details <i class="fas fa-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Pagination -->
                            @if($paginatedCourses->hasPages())
                                <div class="pagination">
                                    {{ $paginatedCourses->appends(request()->query())->links() }}
                                </div>
                            @endif
                        @else
                            <!-- No Results -->
                            <div class="no-results" data-aos="fade-up">
                                <div class="no-results-icon">
                                    <i class="fas fa-search"></i>
                                </div>
                                <h3>No Courses Found</h3>
                                <p>We couldn't find any courses matching your criteria. Try adjusting your filters.</p>
                                <a href="{{ route('courses') }}" class="reset-btn">
                                    <i class="fas fa-redo-alt"></i> Reset All Filters
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mobile filter toggle
    const filterToggle = document.getElementById('filterToggle');
    const filterSidebar = document.getElementById('filterSidebar');
    let filterOverlay = null;
    
    if (filterToggle) {
        filterToggle.addEventListener('click', function() {
            this.classList.toggle('active');
            filterSidebar.classList.toggle('active');
            
            if (filterSidebar.classList.contains('active')) {
                // Create overlay
                filterOverlay = document.createElement('div');
                filterOverlay.className = 'filter-overlay';
                filterOverlay.style.cssText = `
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(0,0,0,0.5);
                    z-index: 9998;
                    opacity: 0;
                    transition: opacity 0.3s;
                `;
                document.body.appendChild(filterOverlay);
                
                // Fade in overlay
                setTimeout(() => {
                    filterOverlay.style.opacity = '1';
                }, 10);
                
                // Close on overlay click
                filterOverlay.addEventListener('click', closeFilterSidebar);
                
                document.body.style.overflow = 'hidden';
            } else {
                closeFilterSidebar();
            }
        });
    }
    
    function closeFilterSidebar() {
        filterToggle?.classList.remove('active');
        filterSidebar?.classList.remove('active');
        
        if (filterOverlay) {
            filterOverlay.style.opacity = '0';
            setTimeout(() => {
                filterOverlay?.remove();
                filterOverlay = null;
            }, 300);
        }
        
        document.body.style.overflow = '';
    }
    
    // Close filter sidebar on window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 992 && filterSidebar?.classList.contains('active')) {
            closeFilterSidebar();
        }
    });
    
    // Bookmark functionality
    const bookmarkBtns = document.querySelectorAll('.bookmark-btn');
    
    bookmarkBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const courseId = this.dataset.courseId;
            
            // Check if user is logged in
            @auth
                // Toggle active class
                this.classList.toggle('active');
                
                // Update icon
                const icon = this.querySelector('i');
                if (this.classList.contains('active')) {
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                    
                    // Here you can make an AJAX call to add to wishlist
                    fetch(`/wishlist/add/${courseId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    });
                    
                    showNotification('Course added to bookmarks', 'success');
                } else {
                    icon.classList.remove('fas');
                    icon.classList.add('far');
                    
                    // Here you can make an AJAX call to remove from wishlist
                    fetch(`/wishlist/remove/${courseId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    });
                    
                    showNotification('Course removed from bookmarks', 'info');
                }
            @else
                // Redirect to login
                window.location.href = '{{ route("login") }}';
            @endauth
        });
    });
    
    // Notification function
    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.style.cssText = `
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: ${type === 'success' ? '#28a745' : '#17a2b8'};
            color: white;
            padding: 12px 24px;
            border-radius: 50px;
            box-shadow: var(--shadow-lg);
            z-index: 10000;
            animation: slideIn 0.3s ease;
        `;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 3000);
    }
    
    // Filter handling
    const filterInputs = document.querySelectorAll('#categoryFilter input, #priceFilter input');
    const sortSelect = document.getElementById('sortSelect');
    const searchForm = document.getElementById('searchForm');
    const sortForm = document.getElementById('sortForm');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const coursesContainer = document.getElementById('coursesContainer');
    
    let filterTimeout;
    
    function updateCourses() {
        // Show loading spinner
        loadingSpinner.classList.add('show');
        
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
        const sort = sortSelect?.value || 'newest_first';
        
        // Build URL with filters
        const params = new URLSearchParams();
        
        if (keyword) params.append('keyword', keyword);
        if (sort) params.append('sort', sort);
        categories.forEach(cat => params.append('categories[]', cat));
        prices.forEach(price => params.append('price[]', price));
        
        // Make AJAX request
        fetch(`{{ route('courses.filter') }}?${params.toString()}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                coursesContainer.innerHTML = data.html;
                // Reinitialize bookmark buttons for new content
                initializeBookmarkButtons();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Fallback to form submission
            searchForm?.submit();
        })
        .finally(() => {
            loadingSpinner.classList.remove('show');
        });
    }
    
    function initializeBookmarkButtons() {
        document.querySelectorAll('.bookmark-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                // Add bookmark logic here (same as above)
                @auth
                    this.classList.toggle('active');
                    const icon = this.querySelector('i');
                    if (this.classList.contains('active')) {
                        icon.classList.remove('far');
                        icon.classList.add('fas');
                        showNotification('Course added to bookmarks', 'success');
                    } else {
                        icon.classList.remove('fas');
                        icon.classList.add('far');
                        showNotification('Course removed from bookmarks', 'info');
                    }
                @else
                    window.location.href = '{{ route("login") }}';
                @endauth
            });
        });
    }
    
    // Debounced update function
    function debounce(func, wait) {
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(filterTimeout);
                func(...args);
            };
            clearTimeout(filterTimeout);
            filterTimeout = setTimeout(later, wait);
        };
    }
    
    const debouncedUpdate = debounce(updateCourses, 500);
    
    // Event listeners for filters
    filterInputs.forEach(input => {
        input.addEventListener('change', debouncedUpdate);
    });
    
    // Sort change
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            updateCourses();
        });
    }
    
    // Search form submission
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            updateCourses();
        });
    }
    
    // Add animation styles
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
});
</script>
@endpush