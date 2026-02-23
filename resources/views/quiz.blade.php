@extends('layouts.main')

@section('title', 'Quiz - EDUCONECX | Test Your Knowledge')

@section('meta_description', 'Explore our interactive quizzes, test your knowledge, and track your progress with EDUCONECX.')

@section('content')
<style>
    /* Quiz Page Specific Styles - Scoped to prevent conflicts */
    :root {
        --quiz-primary: #4361ee;
        --quiz-primary-dark: #3a56d4;
        --quiz-primary-light: #4895ef;
        --quiz-secondary: #4cc9f0;
        --quiz-accent: #f72585;
        --quiz-success: #06d6a0;
        --quiz-warning: #ffd166;
        --quiz-danger: #ef476f;
        --quiz-dark: #1e1e2f;
        --quiz-gray: #6c757d;
        --quiz-gray-light: #e9ecef;
        --quiz-light: #f8f9fa;
        --quiz-white: #ffffff;
        --quiz-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --quiz-gradient-hover: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        --quiz-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        --quiz-shadow-hover: 0 15px 40px rgba(67, 97, 238, 0.15);
        --quiz-radius: 12px;
        --quiz-radius-lg: 20px;
        --quiz-radius-sm: 8px;
        --quiz-radius-full: 9999px;
        --quiz-transition: all 0.3s ease;
    }

    /* Main Container */
    .quiz-container {
        background: var(--quiz-light);
        min-height: 100vh;
        padding: 50px 0;
    }

    /* Hero Section */
    .quiz-hero {
        text-align: center;
        margin-bottom: 50px;
    }

    .quiz-hero h1 {
        font-size: 2.5rem !important;
        font-weight: 700 !important;
        color: var(--quiz-dark) !important;
        margin-bottom: 15px !important;
        background: var(--quiz-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .quiz-hero p {
        font-size: 1.1rem !important;
        color: var(--quiz-gray) !important;
        max-width: 600px;
        margin: 0 auto !important;
    }

    /* Statistics Cards */
    .quiz-stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
        margin-bottom: 40px;
    }

    .quiz-stat-card {
        background: var(--quiz-white);
        border-radius: var(--quiz-radius-lg);
        padding: 30px 25px;
        box-shadow: var(--quiz-shadow);
        display: flex;
        align-items: center;
        transition: var(--quiz-transition);
        position: relative;
        overflow: hidden;
    }

    .quiz-stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: var(--quiz-gradient);
        transform: translateX(-100%);
        transition: var(--quiz-transition);
    }

    .quiz-stat-card:hover::before {
        transform: translateX(0);
    }

    .quiz-stat-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--quiz-shadow-hover);
    }

    .quiz-stat-icon {
        width: 70px;
        height: 70px;
        background: var(--quiz-gradient);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 20px;
        flex-shrink: 0;
    }

    .quiz-stat-icon i {
        font-size: 28px;
        color: var(--quiz-white);
    }

    .quiz-stat-details {
        flex: 1;
    }

    .quiz-stat-details h3 {
        font-size: 2rem !important;
        font-weight: 700 !important;
        color: var(--quiz-dark) !important;
        margin: 0 0 5px 0 !important;
        line-height: 1.2 !important;
    }

    .quiz-stat-details p {
        margin: 0 !important;
        color: var(--quiz-gray) !important;
        font-size: 0.95rem !important;
        font-weight: 500;
    }

    /* Search and Filter */
    .quiz-search-section {
        margin-bottom: 40px;
    }

    .quiz-search-form {
        max-width: 700px;
        margin: 0 auto;
    }

    .quiz-search-wrapper {
        display: flex;
        background: var(--quiz-white);
        border-radius: var(--quiz-radius-full);
        box-shadow: var(--quiz-shadow);
        overflow: hidden;
        border: 2px solid transparent;
        transition: var(--quiz-transition);
    }

    .quiz-search-wrapper:focus-within {
        border-color: var(--quiz-primary);
        box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1);
    }

    .quiz-search-input {
        flex: 1;
        padding: 15px 25px;
        border: none;
        font-size: 1rem;
        outline: none;
    }

    .quiz-search-input::placeholder {
        color: var(--quiz-gray);
        opacity: 0.7;
    }

    .quiz-type-select {
        width: 160px;
        padding: 15px 20px;
        border: none;
        border-left: 2px solid var(--quiz-gray-light);
        background: var(--quiz-white);
        font-size: 0.95rem;
        color: var(--quiz-dark);
        cursor: pointer;
        outline: none;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236c757d' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 15px center;
    }

    .quiz-search-btn {
        padding: 0 30px;
        background: var(--quiz-gradient);
        border: none;
        color: var(--quiz-white);
        font-size: 1rem;
        font-weight: 500;
        cursor: pointer;
        transition: var(--quiz-transition);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .quiz-search-btn:hover {
        background: var(--quiz-gradient-hover);
    }

    .quiz-search-btn i {
        font-size: 1rem;
    }

    /* Quizzes Grid */
    .quiz-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
        margin-bottom: 40px;
    }

    /* Quiz Cards */
    .quiz-card {
        background: var(--quiz-white);
        border-radius: var(--quiz-radius-lg);
        overflow: hidden;
        box-shadow: var(--quiz-shadow);
        transition: var(--quiz-transition);
        height: 100%;
        display: flex;
        flex-direction: column;
        border: 1px solid var(--quiz-gray-light);
    }

    .quiz-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--quiz-shadow-hover);
        border-color: transparent;
    }

    .quiz-card-header {
        padding: 20px;
        background: var(--quiz-gradient);
        color: var(--quiz-white);
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        overflow: hidden;
    }

    .quiz-card-header::after {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 150px;
        height: 150px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        pointer-events: none;
    }

    .quiz-type-badge {
        background: rgba(255, 255, 255, 0.2);
        padding: 6px 15px;
        border-radius: var(--quiz-radius-full);
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        backdrop-filter: blur(5px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        position: relative;
        z-index: 2;
    }

    .quiz-time {
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 5px;
        background: rgba(0, 0, 0, 0.2);
        padding: 5px 12px;
        border-radius: var(--quiz-radius-full);
        position: relative;
        z-index: 2;
    }

    .quiz-time i {
        font-size: 0.8rem;
    }

    .quiz-card-body {
        padding: 25px;
        flex: 1;
    }

    .quiz-title {
        font-size: 1.25rem !important;
        font-weight: 600 !important;
        margin-bottom: 12px !important;
        color: var(--quiz-dark) !important;
        line-height: 1.4 !important;
    }

    .quiz-description {
        color: var(--quiz-gray) !important;
        font-size: 0.95rem !important;
        line-height: 1.6 !important;
        margin-bottom: 20px !important;
    }

    .quiz-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-top: 15px;
    }

    .quiz-meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
        color: var(--quiz-gray);
        background: var(--quiz-light);
        padding: 6px 12px;
        border-radius: var(--quiz-radius-sm);
    }

    .quiz-meta-item i {
        color: var(--quiz-primary);
        width: 16px;
        font-size: 0.9rem;
    }

    .quiz-card-footer {
        padding: 20px 25px;
        background: var(--quiz-light);
        border-top: 1px solid var(--quiz-gray-light);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .quiz-start-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: var(--quiz-gradient);
        color: var(--quiz-white);
        border-radius: var(--quiz-radius-full);
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        transition: var(--quiz-transition);
        border: none;
        cursor: pointer;
    }

    .quiz-start-btn:hover {
        transform: translateX(5px);
        box-shadow: var(--quiz-shadow);
        color: var(--quiz-white);
    }

    .quiz-start-btn i {
        font-size: 0.8rem;
    }

    .quiz-login-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: transparent;
        color: var(--quiz-primary);
        border: 2px solid var(--quiz-primary);
        border-radius: var(--quiz-radius-full);
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        transition: var(--quiz-transition);
    }

    .quiz-login-btn:hover {
        background: var(--quiz-primary);
        color: var(--quiz-white);
        transform: translateX(5px);
    }

    .quiz-attempts {
        font-size: 0.85rem;
        color: var(--quiz-gray);
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .quiz-attempts i {
        color: var(--quiz-primary);
    }

    /* Empty State */
    .quiz-empty-state {
        text-align: center;
        padding: 80px 20px;
        background: var(--quiz-white);
        border-radius: var(--quiz-radius-lg);
        box-shadow: var(--quiz-shadow);
    }

    .quiz-empty-icon {
        width: 100px;
        height: 100px;
        background: var(--quiz-light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px;
        font-size: 3rem;
        color: var(--quiz-gray);
    }

    .quiz-empty-state h3 {
        font-size: 1.8rem !important;
        font-weight: 600 !important;
        color: var(--quiz-dark) !important;
        margin-bottom: 15px !important;
    }

    .quiz-empty-state p {
        color: var(--quiz-gray) !important;
        font-size: 1.1rem !important;
        margin-bottom: 25px !important;
    }

    .quiz-clear-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 30px;
        background: var(--quiz-gradient);
        color: var(--quiz-white);
        border-radius: var(--quiz-radius-full);
        text-decoration: none;
        font-weight: 500;
        transition: var(--quiz-transition);
        border: none;
    }

    .quiz-clear-btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--quiz-shadow);
        color: var(--quiz-white);
    }

    /* Pagination */
    .quiz-pagination {
        margin-top: 40px;
        display: flex;
        justify-content: center;
    }

    .pagination {
        gap: 5px;
    }

    .page-item .page-link {
        border: none;
        padding: 10px 15px;
        color: var(--quiz-gray);
        background: var(--quiz-white);
        border-radius: var(--quiz-radius-sm);
        box-shadow: var(--quiz-shadow);
        transition: var(--quiz-transition);
    }

    .page-item .page-link:hover {
        background: var(--quiz-gradient);
        color: var(--quiz-white);
        transform: translateY(-2px);
    }

    .page-item.active .page-link {
        background: var(--quiz-gradient);
        color: var(--quiz-white);
    }

    .page-item.disabled .page-link {
        background: var(--quiz-light);
        color: var(--quiz-gray);
        opacity: 0.6;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .quiz-stats-grid,
        .quiz-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .quiz-container {
            padding: 30px 0;
        }

        .quiz-hero h1 {
            font-size: 2rem !important;
        }

        .quiz-stats-grid,
        .quiz-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .quiz-search-wrapper {
            flex-direction: column;
            border-radius: var(--quiz-radius);
        }

        .quiz-search-input,
        .quiz-type-select,
        .quiz-search-btn {
            width: 100%;
            border-radius: 0;
        }

        .quiz-type-select {
            border-left: none;
            border-top: 2px solid var(--quiz-gray-light);
        }

        .quiz-stat-card {
            padding: 25px;
        }

        .quiz-stat-icon {
            width: 60px;
            height: 60px;
        }

        .quiz-stat-icon i {
            font-size: 24px;
        }

        .quiz-stat-details h3 {
            font-size: 1.8rem !important;
        }

        .quiz-card-footer {
            flex-direction: column;
            gap: 15px;
            align-items: flex-start;
        }

        .quiz-start-btn,
        .quiz-login-btn {
            width: 100%;
            justify-content: center;
        }
    }

    /* Animations */
    @keyframes quiz-fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .quiz-card {
        animation: quiz-fadeInUp 0.5s ease-out;
        animation-fill-mode: both;
    }

    .quiz-card:nth-child(1) { animation-delay: 0.1s; }
    .quiz-card:nth-child(2) { animation-delay: 0.2s; }
    .quiz-card:nth-child(3) { animation-delay: 0.3s; }
    .quiz-card:nth-child(4) { animation-delay: 0.4s; }
    .quiz-card:nth-child(5) { animation-delay: 0.5s; }
    .quiz-card:nth-child(6) { animation-delay: 0.6s; }
</style>

<div class="quiz-container">
    <div class="container">
        <!-- Hero Section -->
        <div class="quiz-hero">
            <h1>Test Your Knowledge</h1>
            <p>Challenge yourself with our interactive quizzes and track your progress</p>
        </div>

        <!-- Statistics Cards -->
        <div class="quiz-stats-grid">
            <div class="quiz-stat-card">
                <div class="quiz-stat-icon">
                    <i class="fas fa-puzzle-piece"></i>
                </div>
                <div class="quiz-stat-details">
                    <h3>{{ $totalQuizzes ?? 24 }}</h3>
                    <p>Total Quizzes</p>
                </div>
            </div>

            <div class="quiz-stat-card">
                <div class="quiz-stat-icon">
                    <i class="fas fa-question-circle"></i>
                </div>
                <div class="quiz-stat-details">
                    <h3>{{ $totalQuestions ?? 156 }}</h3>
                    <p>Total Questions</p>
                </div>
            </div>

            <div class="quiz-stat-card">
                <div class="quiz-stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="quiz-stat-details">
                    <h3>{{ $totalAttempts ?? 1250 }}</h3>
                    <p>Total Attempts</p>
                </div>
            </div>
        </div>

        <!-- Search and Filter -->
        <div class="quiz-search-section">
            <form action="{{ route('quiz') }}" method="GET" class="quiz-search-form">
                <div class="quiz-search-wrapper">
                    <input type="text" 
                           name="search" 
                           class="quiz-search-input" 
                           placeholder="Search for quizzes..." 
                           value="{{ request('search') }}">
                    
                    <select name="type" class="quiz-type-select">
                        <option value="">All Types</option>
                        <option value="standalone" {{ request('type') == 'standalone' ? 'selected' : '' }}>Standalone</option>
                        <option value="course" {{ request('type') == 'course' ? 'selected' : '' }}>Course Quiz</option>
                        <option value="lesson" {{ request('type') == 'lesson' ? 'selected' : '' }}>Lesson Quiz</option>
                    </select>
                    
                    <button class="quiz-search-btn" type="submit">
                        <i class="fas fa-search"></i>
                        <span>Search</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Quizzes Grid -->
        <div class="quiz-grid">
            @forelse($quizzes ?? [] as $quiz)
                <div class="quiz-card">
                    <div class="quiz-card-header">
                        <span class="quiz-type-badge">
                            {{ ucfirst($quiz->type) }}
                        </span>
                        @if($quiz->time_limit)
                            <span class="quiz-time">
                                <i class="far fa-clock"></i>
                                {{ $quiz->time_limit }} min
                            </span>
                        @endif
                    </div>
                    
                    <div class="quiz-card-body">
                        <h5 class="quiz-title">{{ $quiz->title }}</h5>
                        
                        @if($quiz->description)
                            <p class="quiz-description">{{ Str::limit($quiz->description, 100) }}</p>
                        @endif
                        
                        <div class="quiz-meta">
                            <div class="quiz-meta-item">
                                <i class="fas fa-question-circle"></i>
                                <span>{{ $quiz->questions_count ?? 0 }} Questions</span>
                            </div>
                            <div class="quiz-meta-item">
                                <i class="fas fa-trophy"></i>
                                <span>Pass: {{ $quiz->pass_percentage }}%</span>
                            </div>
                            <div class="quiz-meta-item">
                                <i class="fas fa-redo"></i>
                                <span>{{ $quiz->attempts_allowed == 0 ? 'Unlimited' : $quiz->attempts_allowed . ' attempts' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="quiz-card-footer">
                        @auth
                            <a href="{{ route('quizzes.show', $quiz->slug) }}" class="quiz-start-btn">
                                Start Quiz <i class="fas fa-arrow-right"></i>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="quiz-login-btn">
                                Login to Start <i class="fas fa-sign-in-alt"></i>
                            </a>
                        @endauth
                        
                        <span class="quiz-attempts">
                            <i class="fas fa-users"></i>
                            {{ $quiz->total_attempts ?? 0 }} attempts
                        </span>
                    </div>
                </div>
            @empty
                <div class="quiz-empty-state">
                    <div class="quiz-empty-icon">
                        <i class="fas fa-puzzle-piece"></i>
                    </div>
                    <h3>No Quizzes Found</h3>
                    <p>We couldn't find any quizzes matching your search criteria.</p>
                    @if(request('search') || request('type'))
                        <a href="{{ route('quiz') }}" class="quiz-clear-btn">
                            <i class="fas fa-times"></i>
                            Clear Filters
                        </a>
                    @endif
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if(isset($quizzes) && method_exists($quizzes, 'links') && $quizzes->hasPages())
            <div class="quiz-pagination">
                {{ $quizzes->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit filter when type changes
    const typeSelect = document.querySelector('.quiz-type-select');
    if (typeSelect) {
        typeSelect.addEventListener('change', function() {
            this.form.submit();
        });
    }

    // Animate statistics cards on scroll
    const statCards = document.querySelectorAll('.quiz-stat-card');
    const quizCards = document.querySelectorAll('.quiz-card');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });

    statCards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'all 0.5s ease';
        observer.observe(card);
    });

    // Add hover effect to quiz cards
    quizCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Smooth scroll to quizzes when searching
    const searchForm = document.querySelector('.quiz-search-form');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            // Don't prevent default, just add smooth scroll after submission
            setTimeout(() => {
                const firstQuiz = document.querySelector('.quiz-card');
                if (firstQuiz) {
                    firstQuiz.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }, 100);
        });
    }

    // Live search with debounce (optional enhancement)
    const searchInput = document.querySelector('.quiz-search-input');
    let debounceTimer;

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                if (this.value.length > 2 || this.value.length === 0) {
                    this.form.submit();
                }
            }, 500);
        });
    }
});
</script>
@endsection