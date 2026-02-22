@extends('layouts.main')

@section('title', 'Dashboard - EDUCONECX | Your Learning Hub')

@section('meta_description', 'Access your courses, track your progress, and manage your learning journey on your EDUCONECX dashboard.')

@push('styles')
<style>
    /* Dashboard Container */
    .dashboard-container {
        padding: 40px 0;
        background: var(--light);
        min-height: calc(100vh - 400px);
    }

    /* Welcome Section */
    .welcome-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: var(--border-radius-lg);
        padding: 40px;
        margin-bottom: 30px;
        color: var(--white);
        position: relative;
        overflow: hidden;
    }

    .welcome-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 10s ease-in-out infinite;
    }

    .welcome-section::after {
        content: '';
        position: absolute;
        bottom: -50%;
        left: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 8s ease-in-out infinite reverse;
    }

    .welcome-content {
        position: relative;
        z-index: 2;
    }

    .welcome-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .welcome-text {
        font-size: 1.1rem;
        opacity: 0.9;
        max-width: 600px;
    }

    /* Sidebar */
    .dashboard-sidebar {
        background: var(--white);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-lg);
        overflow: hidden;
        position: sticky;
        top: 100px;
    }

    .profile-card {
        padding: 30px;
        text-align: center;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-bottom: 1px solid var(--gray-light);
    }

    .profile-avatar {
        width: 120px;
        height: 120px;
        margin: 0 auto 20px;
        position: relative;
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid var(--white);
        box-shadow: var(--shadow-md);
        transition: var(--transition);
    }

    .profile-avatar:hover img {
        transform: scale(1.05);
    }

    .avatar-placeholder {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: var(--gradient-1);
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        font-weight: 600;
        margin: 0 auto 20px;
        border: 4px solid var(--white);
        box-shadow: var(--shadow-md);
        transition: var(--transition);
    }

    .avatar-placeholder:hover {
        transform: scale(1.05);
    }

    .profile-name {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 5px;
    }

    .profile-email {
        color: var(--gray);
        font-size: 0.9rem;
        margin-bottom: 20px;
        word-break: break-all;
    }

    .profile-edit-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 25px;
        background: var(--gradient-1);
        color: var(--white);
        border-radius: var(--border-radius-full);
        text-decoration: none;
        font-size: 0.95rem;
        font-weight: 500;
        transition: var(--transition);
        border: none;
        cursor: pointer;
    }

    .profile-edit-btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    /* Sidebar Navigation */
    .sidebar-nav {
        padding: 20px;
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
        padding: 25px;
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
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
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

    .stat-card.quizzes .stat-icon {
        background: rgba(76, 201, 240, 0.1);
        color: #4cc9f0;
    }

    .stat-card.certificates .stat-icon {
        background: rgba(247, 37, 133, 0.1);
        color: #f72585;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 5px;
    }

    .stat-label {
        color: var(--gray);
        font-size: 0.9rem;
        font-weight: 500;
    }

    /* Section Cards */
    .section-card {
        background: var(--white);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-md);
        margin-bottom: 30px;
        overflow: hidden;
    }

    .section-header {
        padding: 20px 25px;
        border-bottom: 1px solid var(--gray-light);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }

    .section-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--dark);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title i {
        color: var(--primary);
    }

    .view-all-link {
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 5px;
        transition: var(--transition);
    }

    .view-all-link:hover {
        gap: 10px;
    }

    /* Course Items */
    .course-item {
        padding: 20px 25px;
        border-bottom: 1px solid var(--gray-light);
        transition: var(--transition);
    }

    .course-item:hover {
        background: var(--light);
    }

    .course-item:last-child {
        border-bottom: none;
    }

    .course-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .course-details {
        flex: 1;
    }

    .course-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 10px;
        color: var(--dark);
    }

    .course-title a {
        color: var(--dark);
        text-decoration: none;
        transition: var(--transition);
    }

    .course-title a:hover {
        color: var(--primary);
    }

    .course-meta {
        display: flex;
        gap: 20px;
        color: var(--gray);
        font-size: 0.9rem;
    }

    .course-meta i {
        color: var(--primary);
        margin-right: 5px;
    }

    .progress-container {
        min-width: 200px;
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
    }

    .progress-fill {
        height: 100%;
        background: var(--gradient-1);
        border-radius: 4px;
        transition: width 0.3s ease;
    }

    .continue-btn {
        padding: 8px 20px;
        background: var(--gradient-1);
        color: var(--white);
        border-radius: var(--border-radius-full);
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        transition: var(--transition);
        white-space: nowrap;
    }

    .continue-btn:hover {
        transform: translateX(5px);
        box-shadow: var(--shadow-md);
    }

    /* Quiz Items */
    .quiz-item {
        padding: 15px 25px;
        border-bottom: 1px solid var(--gray-light);
        transition: var(--transition);
    }

    .quiz-item:hover {
        background: var(--light);
    }

    .quiz-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }

    .quiz-title {
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .quiz-score {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .score-badge {
        padding: 5px 12px;
        border-radius: var(--border-radius-full);
        font-size: 0.85rem;
        font-weight: 600;
    }

    .score-badge.passed {
        background: rgba(6, 214, 160, 0.1);
        color: #06d6a0;
    }

    .score-badge.failed {
        background: rgba(239, 71, 111, 0.1);
        color: #ef476f;
    }

    .score-value {
        font-weight: 600;
        color: var(--dark);
    }

    /* Course Grid */
    .course-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        padding: 20px;
    }

    .recommended-card {
        background: var(--white);
        border-radius: var(--border-radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        height: 100%;
        display: flex;
        flex-direction: column;
        border: 1px solid var(--gray-light);
    }

    .recommended-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-lg);
        border-color: transparent;
    }

    .card-image {
        position: relative;
        overflow: hidden;
        aspect-ratio: 16/9;
    }

    .card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition-slow);
    }

    .recommended-card:hover .card-image img {
        transform: scale(1.1);
    }

    .card-category {
        position: absolute;
        top: 15px;
        right: 15px;
        padding: 4px 12px;
        background: var(--gradient-1);
        color: var(--white);
        border-radius: var(--border-radius-full);
        font-size: 0.75rem;
        font-weight: 600;
        z-index: 2;
    }

    .card-content {
        padding: 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .card-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 10px;
        line-height: 1.4;
    }

    .card-title a {
        color: var(--dark);
        text-decoration: none;
        transition: var(--transition);
    }

    .card-title a:hover {
        color: var(--primary);
    }

    .card-excerpt {
        color: var(--gray);
        font-size: 0.9rem;
        line-height: 1.6;
        margin-bottom: 15px;
        flex: 1;
    }

    .card-footer {
        padding: 0 20px 20px;
    }

    .card-btn {
        display: block;
        padding: 10px;
        background: transparent;
        color: var(--primary);
        border: 2px solid var(--primary);
        border-radius: var(--border-radius-full);
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 600;
        text-align: center;
        transition: var(--transition);
    }

    .card-btn:hover {
        background: var(--primary);
        color: var(--white);
        transform: translateY(-2px);
    }

    /* Empty States */
    .empty-state {
        padding: 40px;
        text-align: center;
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        background: var(--light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 2rem;
        color: var(--gray);
    }

    .empty-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 10px;
    }

    .empty-text {
        color: var(--gray);
        margin-bottom: 20px;
    }

    .empty-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 10px 25px;
        background: var(--gradient-1);
        color: var(--white);
        border-radius: var(--border-radius-full);
        text-decoration: none;
        font-weight: 500;
        transition: var(--transition);
    }

    .empty-btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .course-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .welcome-section {
            padding: 30px 20px;
        }

        .welcome-title {
            font-size: 1.5rem;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .course-grid {
            grid-template-columns: 1fr;
        }

        .course-info {
            flex-direction: column;
            align-items: flex-start;
        }

        .progress-container {
            width: 100%;
        }

        .quiz-info {
            flex-direction: column;
            align-items: flex-start;
        }

        .section-header {
            flex-direction: column;
            align-items: flex-start;
        }
    }

    /* Animations */
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }

    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
</style>
@endpush

@section('content')
    <!-- Dashboard Container -->
    <div class="dashboard-container">
        <div class="container">
            <!-- Welcome Section -->
            <div class="welcome-section" data-aos="fade-up">
                <div class="welcome-content">
                    <h1 class="welcome-title">Welcome back, {{ Auth::user()->first_name ?? Auth::user()->name }}! 👋</h1>
                    <p class="welcome-text">Continue your learning journey and track your progress from your personal dashboard.</p>
                </div>
            </div>

            <div class="row">
                <!-- Sidebar -->
                <div class="col-lg-3 mb-4 mb-lg-0">
                    <div class="dashboard-sidebar" data-aos="fade-right">
                        <div class="profile-card">
                            @if(Auth::user()->avatar)
                                <div class="profile-avatar">
                                    <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}">
                                </div>
                            @else
                                <div class="avatar-placeholder">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                            @endif
                            
                            <h3 class="profile-name">{{ Auth::user()->name }}</h3>
                            <p class="profile-email">{{ Auth::user()->email }}</p>
                            
                            <a href="{{ route('profile') }}" class="profile-edit-btn">
                                <i class="fas fa-user-edit"></i>
                                Edit Profile
                            </a>
                        </div>

                        <div class="sidebar-nav">
                            <a href="{{ route('dashboard') }}" class="nav-item active">
                                <i class="fas fa-home"></i>
                                <span>Dashboard</span>
                            </a>
                            <a href="{{ route('my-courses') }}" class="nav-item">
                                <i class="fas fa-book"></i>
                                <span>My Courses</span>
                                @if(($stats['enrolled_courses'] ?? 0) > 0)
                                    <span class="nav-badge">{{ $stats['enrolled_courses'] }}</span>
                                @endif
                            </a>
                            <a href="{{ route('my-quizzes') }}" class="nav-item">
                                <i class="fas fa-question-circle"></i>
                                <span>My Quizzes</span>
                                @if(($stats['quizzes_taken'] ?? 0) > 0)
                                    <span class="nav-badge">{{ $stats['quizzes_taken'] }}</span>
                                @endif
                            </a>
                            <a href="{{ route('certificates') }}" class="nav-item">
                                <i class="fas fa-certificate"></i>
                                <span>Certificates</span>
                                @if(($stats['certificates_earned'] ?? 0) > 0)
                                    <span class="nav-badge">{{ $stats['certificates_earned'] }}</span>
                                @endif
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-lg-9">
                    <!-- Stats Cards -->
                    <div class="stats-grid" data-aos="fade-up">
                        <div class="stat-card enrolled">
                            <div class="stat-icon">
                                <i class="fas fa-book-open"></i>
                            </div>
                            <div class="stat-value">{{ $stats['enrolled_courses'] ?? 0 }}</div>
                            <div class="stat-label">Enrolled Courses</div>
                        </div>

                        <div class="stat-card completed">
                            <div class="stat-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="stat-value">{{ $stats['completed_courses'] ?? 0 }}</div>
                            <div class="stat-label">Completed</div>
                        </div>

                        <div class="stat-card quizzes">
                            <div class="stat-icon">
                                <i class="fas fa-puzzle-piece"></i>
                            </div>
                            <div class="stat-value">{{ $stats['quizzes_taken'] ?? 0 }}</div>
                            <div class="stat-label">Quizzes Taken</div>
                        </div>

                        <div class="stat-card certificates">
                            <div class="stat-icon">
                                <i class="fas fa-award"></i>
                            </div>
                            <div class="stat-value">{{ $stats['certificates_earned'] ?? 0 }}</div>
                            <div class="stat-label">Certificates</div>
                        </div>
                    </div>

                    <!-- Recent Courses -->
                    <div class="section-card" data-aos="fade-up">
                        <div class="section-header">
                            <h2 class="section-title">
                                <i class="fas fa-clock"></i>
                                Recent Courses
                            </h2>
                            @if(($recentCourses ?? collect())->count() > 0)
                                <a href="{{ route('my-courses') }}" class="view-all-link">
                                    View All <i class="fas fa-arrow-right"></i>
                                </a>
                            @endif
                        </div>

                        @if(($recentCourses ?? collect())->count() > 0)
                            <div class="course-list">
                                @foreach($recentCourses as $enrollment)
                                    <div class="course-item">
                                        <div class="course-info">
                                            <div class="course-details">
                                                <h3 class="course-title">
                                                    <a href="{{ route('courses.learn', $enrollment->course->slug ?? '#') }}">
                                                        {{ $enrollment->course->title ?? 'Course Title' }}
                                                    </a>
                                                </h3>
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
                                            </div>
                                            <div class="progress-container">
                                                <div class="progress-header">
                                                    <span>Progress</span>
                                                    <span class="progress-percentage">{{ $enrollment->progress ?? 0 }}%</span>
                                                </div>
                                                <div class="progress-bar-custom">
                                                    <div class="progress-fill" style="width: {{ $enrollment->progress ?? 0 }}%"></div>
                                                </div>
                                            </div>
                                            <a href="{{ route('courses.learn', $enrollment->course->slug ?? '#') }}" class="continue-btn">
                                                Continue <i class="fas fa-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-book-open"></i>
                                </div>
                                <h3 class="empty-title">No courses yet</h3>
                                <p class="empty-text">Start your learning journey by enrolling in a course.</p>
                                <a href="{{ route('courses') }}" class="empty-btn">
                                    Browse Courses <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Recent Quiz Attempts -->
                    <div class="section-card" data-aos="fade-up">
                        <div class="section-header">
                            <h2 class="section-title">
                                <i class="fas fa-puzzle-piece"></i>
                                Recent Quiz Attempts
                            </h2>
                            @if(($recentQuizzes ?? collect())->count() > 0)
                                <a href="{{ route('my-quizzes') }}" class="view-all-link">
                                    View All <i class="fas fa-arrow-right"></i>
                                </a>
                            @endif
                        </div>

                        @if(($recentQuizzes ?? collect())->count() > 0)
                            <div class="quiz-list">
                                @foreach($recentQuizzes as $attempt)
                                    <div class="quiz-item">
                                        <div class="quiz-info">
                                            <div>
                                                <h4 class="quiz-title">{{ $attempt->quiz->title ?? 'Quiz Title' }}</h4>
                                                <small class="text-muted">
                                                    <i class="far fa-calendar"></i>
                                                    {{ \Carbon\Carbon::parse($attempt->created_at ?? now())->format('M d, Y') }}
                                                </small>
                                            </div>
                                            <div class="quiz-score">
                                                <span class="score-badge {{ ($attempt->passed ?? false) ? 'passed' : 'failed' }}">
                                                    {{ ($attempt->passed ?? false) ? 'Passed' : 'Failed' }}
                                                </span>
                                                <span class="score-value">{{ $attempt->percentage ?? 0 }}%</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-puzzle-piece"></i>
                                </div>
                                <h3 class="empty-title">No quiz attempts yet</h3>
                                <p class="empty-text">Test your knowledge by taking a quiz.</p>
                                <a href="#" class="empty-btn">
                                    Browse Quizzes <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Recommended Courses -->
                    <div class="section-card" data-aos="fade-up">
                        <div class="section-header">
                            <h2 class="section-title">
                                <i class="fas fa-star"></i>
                                Recommended for You
                            </h2>
                        </div>

                        @if(($recommendedCourses ?? collect())->count() > 0)
                            <div class="course-grid">
                                @foreach($recommendedCourses as $course)
                                    <div class="recommended-card">
                                        <div class="card-image">
                                            <img src="{{ $course->thumbnail_url ?? 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80' }}" 
                                                 alt="{{ $course->title ?? 'Course' }}">
                                            <span class="card-category">{{ $course->category ?? 'Course' }}</span>
                                        </div>
                                        <div class="card-content">
                                            <h3 class="card-title">
                                                <a href="{{ route('courses.show', $course->slug ?? '#') }}">
                                                    {{ $course->title ?? 'Course Title' }}
                                                </a>
                                            </h3>
                                            <p class="card-excerpt">
                                                {{ Str::limit($course->excerpt ?? 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 60) }}
                                            </p>
                                        </div>
                                        <div class="card-footer">
                                            <a href="{{ route('courses.show', $course->slug ?? '#') }}" class="card-btn">
                                                View Course
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-star"></i>
                                </div>
                                <h3 class="empty-title">No recommendations yet</h3>
                                <p class="empty-text">Complete more courses to get personalized recommendations.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animate stats cards on scroll
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

        // Observe stat cards
        document.querySelectorAll('.stat-card, .section-card, .recommended-card').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            observer.observe(el);
        });

        // Add hover effect to nav items
        const navItems = document.querySelectorAll('.nav-item');
        navItems.forEach(item => {
            item.addEventListener('mouseenter', function() {
                if (!this.classList.contains('active')) {
                    this.style.backgroundColor = 'var(--light)';
                }
            });
            
            item.addEventListener('mouseleave', function() {
                if (!this.classList.contains('active')) {
                    this.style.backgroundColor = '';
                }
            });
        });
    });
</script>
@endpush