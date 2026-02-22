@extends('layouts.main')

@section('title', 'My Courses - EDUCONECX | Your Learning Journey')

@section('meta_description', 'Track your progress, continue learning, and manage all your enrolled courses in one place on EDUCONECX.')

@push('styles')
<style>
    /* My Courses Container */
    .courses-container {
        padding: 40px 0;
        background: var(--light);
        min-height: calc(100vh - 400px);
    }

    /* Page Header */
    .page-header {
        margin-bottom: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--dark);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .page-title i {
        color: var(--primary);
        font-size: 2rem;
    }

    .page-actions {
        display: flex;
        gap: 15px;
    }

    .search-box {
        position: relative;
        min-width: 300px;
    }

    .search-input {
        width: 100%;
        padding: 12px 20px 12px 45px;
        border: 2px solid var(--gray-light);
        border-radius: var(--border-radius-full);
        font-size: 0.95rem;
        transition: var(--transition);
        background: var(--white);
    }

    .search-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1);
    }

    .search-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gray);
        font-size: 1rem;
    }

    .filter-btn {
        padding: 12px 25px;
        background: var(--white);
        border: 2px solid var(--gray-light);
        border-radius: var(--border-radius-full);
        color: var(--dark);
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        transition: var(--transition);
    }

    .filter-btn:hover {
        border-color: var(--primary);
        color: var(--primary);
    }

    /* Sidebar */
    .courses-sidebar {
        background: var(--white);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-lg);
        overflow: hidden;
        position: sticky;
        top: 100px;
    }

    .sidebar-header {
        padding: 20px;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-bottom: 1px solid var(--gray-light);
    }

    .sidebar-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--dark);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .sidebar-title i {
        color: var(--primary);
    }

    .sidebar-nav {
        padding: 15px;
    }

    .nav-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 15px;
        border-radius: var(--border-radius-md);
        color: var(--gray);
        text-decoration: none;
        transition: var(--transition);
        margin-bottom: 5px;
    }

    .nav-item i {
        width: 20px;
        font-size: 1.1rem;
        transition: var(--transition);
    }

    .nav-item:hover {
        background: var(--light);
        color: var(--primary);
        transform: translateX(5px);
    }

    .nav-item.active {
        background: var(--gradient-1);
        color: var(--white);
        box-shadow: var(--shadow-md);
    }

    .nav-item.active i {
        color: var(--white);
    }

    .nav-item span {
        flex: 1;
        font-weight: 500;
    }

    .nav-badge {
        background: rgba(255, 255, 255, 0.2);
        padding: 2px 8px;
        border-radius: var(--border-radius-full);
        font-size: 0.75rem;
    }

    /* Filter Section */
    .filter-section {
        margin-bottom: 30px;
        background: var(--white);
        border-radius: var(--border-radius-lg);
        padding: 20px;
        box-shadow: var(--shadow-md);
    }

    .filter-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }

    .filter-select {
        padding: 12px 15px;
        border: 2px solid var(--gray-light);
        border-radius: var(--border-radius-md);
        font-size: 0.95rem;
        color: var(--dark);
        background: var(--white);
        cursor: pointer;
        transition: var(--transition);
    }

    .filter-select:focus {
        outline: none;
        border-color: var(--primary);
    }

    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: var(--white);
        border-radius: var(--border-radius-lg);
        padding: 20px;
        box-shadow: var(--shadow-md);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: var(--gradient-1);
        transform: translateX(-100%);
        transition: var(--transition);
    }

    .stat-card:hover::before {
        transform: translateX(0);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }

    .stat-icon {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        margin-bottom: 15px;
    }

    .stat-card.enrolled .stat-icon {
        background: rgba(67, 97, 238, 0.1);
        color: #4361ee;
    }

    .stat-card.completed .stat-icon {
        background: rgba(6, 214, 160, 0.1);
        color: #06d6a0;
    }

    .stat-card.progress .stat-icon {
        background: rgba(247, 37, 133, 0.1);
        color: #f72585;
    }

    .stat-card.hours .stat-icon {
        background: rgba(76, 201, 240, 0.1);
        color: #4cc9f0;
    }

    .stat-value {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 5px;
    }

    .stat-label {
        color: var(--gray);
        font-size: 0.9rem;
        font-weight: 500;
    }

    /* Course Grid */
    .course-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
        margin-bottom: 30px;
    }

    .course-card {
        background: var(--white);
        border-radius: var(--border-radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-lg);
        transition: var(--transition);
        display: flex;
        flex-direction: column;
        height: 100%;
        position: relative;
    }

    .course-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-hover);
    }

    .course-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        z-index: 2;
        padding: 5px 15px;
        background: var(--gradient-1);
        color: var(--white);
        border-radius: var(--border-radius-full);
        font-size: 0.75rem;
        font-weight: 600;
        box-shadow: var(--shadow-md);
    }

    .course-badge.completed {
        background: var(--success);
    }

    .course-badge.in-progress {
        background: var(--primary);
    }

    .course-image {
        position: relative;
        overflow: hidden;
        aspect-ratio: 16/9;
    }

    .course-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition-slow);
    }

    .course-card:hover .course-image img {
        transform: scale(1.1);
    }

    .course-content {
        padding: 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .course-meta {
        display: flex;
        gap: 15px;
        margin-bottom: 10px;
        color: var(--gray);
        font-size: 0.85rem;
    }

    .course-meta i {
        color: var(--primary);
        margin-right: 5px;
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

    .course-progress {
        margin-top: auto;
        padding-top: 15px;
    }

    .progress-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
        font-size: 0.9rem;
    }

    .progress-percentage {
        font-weight: 600;
        color: var(--primary);
    }

    .progress-bar-custom {
        height: 8px;
        background: var(--gray-light);
        border-radius: 4px;
        overflow: hidden;
        margin-bottom: 10px;
    }

    .progress-fill {
        height: 100%;
        background: var(--gradient-1);
        border-radius: 4px;
        transition: width 0.3s ease;
    }

    .progress-fill.completed {
        background: var(--success);
    }

    .course-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 15px;
    }

    .continue-btn {
        padding: 10px 20px;
        background: var(--gradient-1);
        color: var(--white);
        border-radius: var(--border-radius-full);
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .continue-btn:hover {
        transform: translateX(5px);
        box-shadow: var(--shadow-md);
    }

    .certificate-btn {
        padding: 8px 15px;
        background: transparent;
        color: var(--success);
        border: 2px solid var(--success);
        border-radius: var(--border-radius-full);
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 500;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .certificate-btn:hover {
        background: var(--success);
        color: var(--white);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: var(--white);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-md);
    }

    .empty-icon {
        width: 100px;
        height: 100px;
        background: var(--light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px;
        font-size: 3rem;
        color: var(--gray);
        animation: float 6s ease-in-out infinite;
    }

    .empty-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 10px;
    }

    .empty-text {
        color: var(--gray);
        margin-bottom: 25px;
        font-size: 1.1rem;
        max-width: 400px;
        margin-left: auto;
        margin-right: auto;
    }

    .empty-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 15px 35px;
        background: var(--gradient-1);
        color: var(--white);
        border-radius: var(--border-radius-full);
        text-decoration: none;
        font-weight: 600;
        transition: var(--transition);
    }

    .empty-btn:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-lg);
    }

    /* Pagination */
    .pagination {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-top: 30px;
    }

    .page-item {
        list-style: none;
    }

    .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 40px;
        padding: 0 10px;
        background: var(--white);
        border: 2px solid var(--gray-light);
        border-radius: var(--border-radius-md);
        color: var(--dark);
        text-decoration: none;
        transition: var(--transition);
        font-weight: 500;
    }

    .page-link:hover {
        background: var(--primary);
        color: var(--white);
        border-color: var(--primary);
    }

    .page-item.active .page-link {
        background: var(--primary);
        color: var(--white);
        border-color: var(--primary);
    }

    .page-item.disabled .page-link {
        background: var(--light);
        color: var(--gray);
        pointer-events: none;
        border-color: var(--gray-light);
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .course-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .search-box {
            width: 100%;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .filter-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
    <!-- Courses Container -->
    <div class="courses-container">
        <div class="container">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-lg-3 mb-4 mb-lg-0">
                    <div class="courses-sidebar" data-aos="fade-right">
                        <div class="sidebar-header">
                            <h3 class="sidebar-title">
                                <i class="fas fa-user"></i>
                                My Learning
                            </h3>
                        </div>

                        <div class="sidebar-nav">
                            <a href="{{ route('dashboard') }}" class="nav-item">
                                <i class="fas fa-home"></i>
                                <span>Dashboard</span>
                            </a>
                            <a href="{{ route('my-courses') }}" class="nav-item active">
                                <i class="fas fa-book"></i>
                                <span>My Courses</span>
                                @if(($enrollments->total() ?? 0) > 0)
                                    <span class="nav-badge">{{ $enrollments->total() }}</span>
                                @endif
                            </a>
                            <a href="{{ route('my-quizzes') }}" class="nav-item">
                                <i class="fas fa-question-circle"></i>
                                <span>My Quizzes</span>
                            </a>
                            <a href="{{ route('certificates') }}" class="nav-item">
                                <i class="fas fa-certificate"></i>
                                <span>Certificates</span>
                            </a>
                        </div>

                        <!-- Quick Stats -->
                        <div class="sidebar-header" style="border-radius: 0; border-top: 1px solid var(--gray-light);">
                            <h3 class="sidebar-title">
                                <i class="fas fa-chart-line"></i>
                                Quick Stats
                            </h3>
                        </div>
                        <div class="p-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Total Courses</span>
                                <span class="fw-bold">{{ $enrollments->total() ?? 0 }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Completed</span>
                                <span class="fw-bold text-success">{{ $completedCount ?? 0 }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">In Progress</span>
                                <span class="fw-bold text-primary">{{ $inProgressCount ?? 0 }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">Average Progress</span>
                                <span class="fw-bold">{{ $averageProgress ?? 0 }}%</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-lg-9">
                    <!-- Page Header -->
                    <div class="page-header" data-aos="fade-up">
                        <h1 class="page-title">
                            <i class="fas fa-book-open"></i>
                            My Courses
                        </h1>
                        
                        <div class="page-actions">
                            <div class="search-box">
                                <i class="fas fa-search search-icon"></i>
                                <input type="text" class="search-input" placeholder="Search your courses..." id="searchCourses">
                            </div>
                            <button class="filter-btn" id="filterToggle">
                                <i class="fas fa-filter"></i>
                                Filter
                            </button>
                        </div>
                    </div>

                    <!-- Stats Cards -->
                    <div class="stats-grid" data-aos="fade-up">
                        <div class="stat-card enrolled">
                            <div class="stat-icon">
                                <i class="fas fa-book-open"></i>
                            </div>
                            <div class="stat-value">{{ $enrollments->total() ?? 0 }}</div>
                            <div class="stat-label">Total Courses</div>
                        </div>

                        <div class="stat-card completed">
                            <div class="stat-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="stat-value">{{ $completedCount ?? 0 }}</div>
                            <div class="stat-label">Completed</div>
                        </div>

                        <div class="stat-card progress">
                            <div class="stat-icon">
                                <i class="fas fa-spinner"></i>
                            </div>
                            <div class="stat-value">{{ $inProgressCount ?? 0 }}</div>
                            <div class="stat-label">In Progress</div>
                        </div>

                        <div class="stat-card hours">
                            <div class="stat-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="stat-value">{{ $totalHours ?? 0 }}</div>
                            <div class="stat-label">Hours Spent</div>
                        </div>
                    </div>

                    <!-- Filter Section -->
                    <div class="filter-section" id="filterSection" style="display: none;" data-aos="fade-up">
                        <div class="filter-grid">
                            <select class="filter-select" id="statusFilter">
                                <option value="">All Status</option>
                                <option value="in-progress">In Progress</option>
                                <option value="completed">Completed</option>
                                <option value="not-started">Not Started</option>
                            </select>
                            <select class="filter-select" id="categoryFilter">
                                <option value="">All Categories</option>
                                <option value="business">Business</option>
                                <option value="technology">Technology</option>
                                <option value="language">Language</option>
                            </select>
                            <select class="filter-select" id="sortFilter">
                                <option value="recent">Most Recent</option>
                                <option value="progress">Progress</option>
                                <option value="title">Title A-Z</option>
                            </select>
                        </div>
                    </div>

                    <!-- Course Grid -->
                    @if(($enrollments ?? collect())->count() > 0)
                        <div class="course-grid" id="courseGrid">
                            @foreach($enrollments as $enrollment)
                                <div class="course-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                                    @php
                                        $progress = $enrollment->progress ?? 0;
                                        $status = $progress >= 100 ? 'completed' : ($progress > 0 ? 'in-progress' : 'not-started');
                                    @endphp
                                    
                                    <span class="course-badge {{ $status }}">
                                        {{ $status === 'completed' ? 'Completed' : ($status === 'in-progress' ? 'In Progress' : 'Not Started') }}
                                    </span>
                                    
                                    <div class="course-image">
                                        <img src="{{ $enrollment->course->thumbnail_url ?? 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80' }}" 
                                             alt="{{ $enrollment->course->title ?? 'Course' }}">
                                    </div>
                                    
                                    <div class="course-content">
                                        <div class="course-meta">
                                            <span>
                                                <i class="fas fa-signal"></i>
                                                {{ $enrollment->course->level ?? 'All Levels' }}
                                            </span>
                                            <span>
                                                <i class="fas fa-video"></i>
                                                {{ $enrollment->course->lessons_count ?? 12 }} Lessons
                                            </span>
                                        </div>
                                        
                                        <h3 class="course-title">
                                            <a href="{{ route('courses.show', $enrollment->course->slug ?? '#') }}">
                                                {{ $enrollment->course->title ?? 'Course Title' }}
                                            </a>
                                        </h3>
                                        
                                        <div class="course-progress">
                                            <div class="progress-header">
                                                <span>Progress</span>
                                                <span class="progress-percentage">{{ $progress }}%</span>
                                            </div>
                                            <div class="progress-bar-custom">
                                                <div class="progress-fill {{ $status === 'completed' ? 'completed' : '' }}" 
                                                     style="width: {{ $progress }}%"></div>
                                            </div>
                                        </div>
                                        
                                        <div class="course-footer">
                                            @if($status === 'completed')
                                                <a href="{{ route('certificates.show', $enrollment->course->id ?? '#') }}" 
                                                   class="certificate-btn">
                                                    <i class="fas fa-award"></i>
                                                    Certificate
                                                </a>
                                                <a href="{{ route('courses.learn', $enrollment->course->slug ?? '#') }}" 
                                                   class="continue-btn">
                                                    Review <i class="fas fa-redo-alt"></i>
                                                </a>
                                            @else
                                                <a href="{{ route('courses.learn', $enrollment->course->slug ?? '#') }}" 
                                                   class="continue-btn">
                                                    Continue <i class="fas fa-arrow-right"></i>
                                                </a>
                                                <span class="text-muted small">
                                                    {{ $enrollment->last_activity ?? 'Last activity: ' . now()->subDays(rand(1, 10))->format('M d') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        @if($enrollments->hasPages())
                            <div class="pagination">
                                {{ $enrollments->appends(request()->query())->links() }}
                            </div>
                        @endif
                    @else
                        <!-- Empty State -->
                        <div class="empty-state" data-aos="fade-up">
                            <div class="empty-icon">
                                <i class="fas fa-book-open"></i>
                            </div>
                            <h2 class="empty-title">No Courses Yet</h2>
                            <p class="empty-text">
                                You haven't enrolled in any courses yet. Start your learning journey today!
                            </p>
                            <a href="{{ route('courses') }}" class="empty-btn">
                                Browse Courses <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filter toggle
        const filterToggle = document.getElementById('filterToggle');
        const filterSection = document.getElementById('filterSection');
        
        if (filterToggle) {
            filterToggle.addEventListener('click', function() {
                if (filterSection.style.display === 'none') {
                    filterSection.style.display = 'block';
                    filterSection.style.animation = 'slideInRight 0.3s ease';
                } else {
                    filterSection.style.display = 'none';
                }
            });
        }

        // Search functionality
        const searchInput = document.getElementById('searchCourses');
        const courseCards = document.querySelectorAll('.course-card');
        
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase().trim();
                
                courseCards.forEach(card => {
                    const title = card.querySelector('.course-title').textContent.toLowerCase();
                    const meta = card.querySelector('.course-meta').textContent.toLowerCase();
                    
                    if (title.includes(searchTerm) || meta.includes(searchTerm)) {
                        card.style.display = 'flex';
                        card.style.animation = 'fadeIn 0.5s ease';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        }

        // Filter functionality
        const statusFilter = document.getElementById('statusFilter');
        const categoryFilter = document.getElementById('categoryFilter');
        const sortFilter = document.getElementById('sortFilter');
        
        function applyFilters() {
            const status = statusFilter?.value;
            const category = categoryFilter?.value;
            
            courseCards.forEach(card => {
                let show = true;
                
                if (status) {
                    const badge = card.querySelector('.course-badge').textContent.toLowerCase();
                    if (status === 'in-progress' && !badge.includes('progress')) show = false;
                    if (status === 'completed' && !badge.includes('completed')) show = false;
                    if (status === 'not-started' && !badge.includes('not')) show = false;
                }
                
                if (category && show) {
                    const meta = card.querySelector('.course-meta').textContent.toLowerCase();
                    if (!meta.includes(category)) show = false;
                }
                
                card.style.display = show ? 'flex' : 'none';
            });
        }
        
        if (statusFilter) statusFilter.addEventListener('change', applyFilters);
        if (categoryFilter) categoryFilter.addEventListener('change', applyFilters);
        
        if (sortFilter) {
            sortFilter.addEventListener('change', function() {
                const sortBy = this.value;
                const grid = document.getElementById('courseGrid');
                const cards = Array.from(courseCards);
                
                cards.sort((a, b) => {
                    if (sortBy === 'title') {
                        const titleA = a.querySelector('.course-title').textContent;
                        const titleB = b.querySelector('.course-title').textContent;
                        return titleA.localeCompare(titleB);
                    } else if (sortBy === 'progress') {
                        const progressA = parseInt(a.querySelector('.progress-percentage').textContent);
                        const progressB = parseInt(b.querySelector('.progress-percentage').textContent);
                        return progressB - progressA;
                    } else {
                        // Default: recent - assume they're in order
                        return 0;
                    }
                });
                
                grid.innerHTML = '';
                cards.forEach(card => grid.appendChild(card));
            });
        }

        // Animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe course cards
        document.querySelectorAll('.course-card, .stat-card, .filter-section').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            observer.observe(el);
        });
    });
</script>
@endpush