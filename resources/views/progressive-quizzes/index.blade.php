@extends('layouts.main')
@php
    use App\Models\ProgressiveLevelAttempt;
@endphp
@section('title', 'Progressive Quizzes - ' . (App\Helpers\TranslationHelper::trans('progressive-quiz.title') ?? 'Level-Based Quizzes'))

@section('meta_description', App\Helpers\TranslationHelper::trans('progressive-quiz.meta_description'))

@push('styles')
<style>
    /* ===== ROOT VARIABLES - YOUR BEAUTIFUL LOGO COLORS ===== */
    :root {
        --bright-amber: #FBC60C;
        --khaki-beige: #9F9A87;
        --pure-white: #FEFDFE;
        --prussian-blue: #0A1D44;
        --regal-navy: #18386E;
        --sky-blue: #5AD1E4;
        --pale-slate: #CBD1DA;
        --dark-slate: #2E5C61;
        --ivory: #F9F7E9;
        --light-gold: #EBD789;
        
        /* Extended Palette */
        --primary: var(--regal-navy);
        --primary-dark: var(--prussian-blue);
        --primary-light: var(--dark-slate);
        --secondary: var(--sky-blue);
        --accent: var(--bright-amber);
        --accent-soft: var(--light-gold);
        --success: var(--sky-blue);
        --warning: var(--bright-amber);
        --danger: #ef4444;
        --dark: var(--prussian-blue);
        --dark-light: var(--regal-navy);
        --gray: var(--khaki-beige);
        --gray-light: var(--pale-slate);
        --light: var(--ivory);
        --white: var(--pure-white);
        
        /* Text Colors */
        --text-primary: #0A1D44;
        --text-secondary: #2E5C61;
        --text-muted: #5f5f5f;
        --text-light: #FEFDFE;
        
        /* Gradients */
        --gradient-1: linear-gradient(135deg, #0A1D44 0%, #18386E 50%, #2E5C61 100%);
        --gradient-2: linear-gradient(45deg, #FBC60C 0%, #EBD789 50%, #F9F7E9 100%);
        --gradient-3: linear-gradient(135deg, #5AD1E4 0%, #CBD1DA 50%, #FEFDFE 100%);
        
        /* Shadows */
        --shadow-sm: 0 2px 8px rgba(10, 29, 68, 0.08);
        --shadow-md: 0 4px 12px rgba(10, 29, 68, 0.12);
        --shadow-lg: 0 8px 24px rgba(10, 29, 68, 0.15);
        --shadow-hover: 0 12px 28px rgba(251, 198, 12, 0.2);
        
        /* Border Radius */
        --radius-sm: 8px;
        --radius-md: 12px;
        --radius-lg: 16px;
        --radius-xl: 24px;
        --radius-full: 9999px;
        
        /* Transitions */
        --transition: all 0.3s ease;
    }

    /* ===== HERO SECTION ===== */
    .progressive-hero {
        position: relative;
        background: var(--gradient-1);
        padding: 60px 0;
        overflow: hidden;
        color: var(--pure-white);
        margin-bottom: 40px;
    }

    .hero-particles {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    .hero-particle {
        position: absolute;
        background: rgba(251, 198, 12, 0.1);
        border-radius: 50%;
    }

    .hero-particle:nth-child(1) {
        width: 300px;
        height: 300px;
        top: -100px;
        right: -100px;
        animation: float 8s ease-in-out infinite;
    }

    .hero-particle:nth-child(2) {
        width: 200px;
        height: 200px;
        bottom: -50px;
        left: -50px;
        background: rgba(90, 209, 228, 0.1);
        animation: float 10s ease-in-out infinite reverse;
    }

    .hero-particle:nth-child(3) {
        width: 150px;
        height: 150px;
        top: 30%;
        left: 20%;
        background: rgba(235, 215, 137, 0.1);
        animation: float 12s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }

    .hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
        max-width: 800px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .hero-badge {
        display: inline-block;
        padding: 8px 20px;
        background: rgba(254, 253, 254, 0.2);
        border-radius: var(--radius-full);
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 20px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(251, 198, 12, 0.3);
    }

    .hero-title {
        font-size: clamp(1.8rem, 6vw, 3rem);
        font-weight: 800;
        margin-bottom: 15px;
        line-height: 1.2;
    }

    .hero-title span {
        color: var(--bright-amber);
    }

    .hero-subtitle {
        font-size: clamp(1rem, 3vw, 1.2rem);
        opacity: 0.95;
        margin-bottom: 30px;
    }

    /* ===== STATISTICS CARDS ===== */
    .stats-section {
        margin-bottom: 40px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
    }

    @media (max-width: 992px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }

    .stat-card {
        background: var(--pure-white);
        border-radius: var(--radius-lg);
        padding: 30px 25px;
        box-shadow: var(--shadow-lg);
        display: flex;
        align-items: center;
        transition: var(--transition);
        border: 1px solid rgba(251, 198, 12, 0.1);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-hover);
        border-color: var(--bright-amber);
    }

    .stat-icon {
        width: 70px;
        height: 70px;
        background: var(--gradient-1);
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 20px;
    }

    .stat-icon i {
        font-size: 28px;
        color: var(--pure-white);
    }

    .stat-content {
        flex: 1;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: var(--prussian-blue);
        margin-bottom: 5px;
        line-height: 1.2;
    }

    .stat-label {
        color: var(--text-muted);
        font-size: 0.95rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* ===== SEARCH SECTION ===== */
    .search-section {
        margin-bottom: 40px;
    }

    .search-form {
        max-width: 600px;
        margin: 0 auto;
    }

    .search-wrapper {
        display: flex;
        background: var(--pure-white);
        border-radius: var(--radius-full);
        box-shadow: var(--shadow-lg);
        overflow: hidden;
        border: 2px solid transparent;
        transition: var(--transition);
    }

    .search-wrapper:focus-within {
        border-color: var(--bright-amber);
        box-shadow: var(--shadow-hover);
    }

    .search-input {
        flex: 1;
        padding: 16px 25px;
        border: none;
        font-size: 1rem;
        outline: none;
        background: transparent;
    }

    .search-btn {
        padding: 0 30px;
        background: var(--gradient-1);
        border: none;
        color: var(--pure-white);
        font-size: 1rem;
        font-weight: 500;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .search-btn:hover {
        background: var(--gradient-2);
        color: var(--prussian-blue);
    }

    /* ===== QUIZZES GRID ===== */
    .quizzes-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
        margin-bottom: 40px;
    }

    @media (max-width: 1200px) {
        .quizzes-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .quizzes-grid {
            grid-template-columns: 1fr;
        }
    }

    /* ===== QUIZ CARD ===== */
    .quiz-card {
        background: var(--pure-white);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-lg);
        transition: var(--transition);
        height: 100%;
        display: flex;
        flex-direction: column;
        border: 1px solid rgba(251, 198, 12, 0.1);
    }

    .quiz-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-hover);
        border-color: var(--bright-amber);
    }

    .quiz-image {
        height: 160px;
        background: var(--gradient-1);
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .quiz-image i {
        font-size: 4rem;
        color: rgba(255, 255, 255, 0.2);
    }

    .quiz-level-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: var(--bright-amber);
        color: var(--prussian-blue);
        padding: 6px 15px;
        border-radius: var(--radius-full);
        font-size: 0.8rem;
        font-weight: 700;
        box-shadow: var(--shadow-md);
    }

    .quiz-body {
        padding: 25px;
        flex: 1;
    }

    .quiz-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 10px;
        color: var(--prussian-blue);
        line-height: 1.4;
    }

    .quiz-description {
        color: var(--text-muted);
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 20px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .quiz-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 20px;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--text-muted);
        font-size: 0.9rem;
    }

    .meta-item i {
        color: var(--bright-amber);
        width: 16px;
    }

    .quiz-progress {
        margin-bottom: 20px;
    }

    .progress-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 5px;
        font-size: 0.85rem;
        color: var(--text-muted);
    }

    .progress-bar {
        height: 6px;
        background: var(--pale-slate);
        border-radius: var(--radius-full);
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: var(--gradient-2);
        border-radius: var(--radius-full);
    }

    .quiz-footer {
        padding: 20px 25px;
        background: var(--ivory);
        border-top: 1px solid rgba(251, 198, 12, 0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .btn-start {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: var(--gradient-1);
        color: var(--pure-white);
        border-radius: var(--radius-full);
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        transition: var(--transition);
        border: none;
        cursor: pointer;
    }

    .btn-start:hover {
        background: var(--gradient-2);
        color: var(--prussian-blue);
        transform: translateX(5px);
    }

    .btn-login {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: transparent;
        color: var(--prussian-blue);
        border: 2px solid var(--prussian-blue);
        border-radius: var(--radius-full);
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        transition: var(--transition);
    }

    .btn-login:hover {
        background: var(--prussian-blue);
        color: var(--pure-white);
        border-color: var(--bright-amber);
    }

    .attempts-info {
        font-size: 0.85rem;
        color: var(--text-muted);
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .attempts-info i {
        color: var(--bright-amber);
    }

    /* ===== EMPTY STATE ===== */
    .empty-state {
        text-align: center;
        padding: 80px 20px;
        background: var(--pure-white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-lg);
        grid-column: 1 / -1;
    }

    .empty-icon {
        width: 120px;
        height: 120px;
        background: var(--ivory);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px;
        font-size: 3rem;
        color: var(--bright-amber);
        animation: float 6s ease-in-out infinite;
        border: 2px solid var(--bright-amber);
    }

    .empty-state h3 {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 10px;
        color: var(--prussian-blue);
    }

    .empty-state p {
        color: var(--text-muted);
        font-size: 1.1rem;
        margin-bottom: 25px;
    }

    .btn-clear {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 12px 30px;
        background: var(--gradient-1);
        color: var(--pure-white);
        border-radius: var(--radius-full);
        text-decoration: none;
        font-weight: 600;
        transition: var(--transition);
    }

    .btn-clear:hover {
        background: var(--gradient-2);
        color: var(--prussian-blue);
    }

    /* ===== PAGINATION ===== */
    .pagination-wrapper {
        margin-top: 40px;
        display: flex;
        justify-content: center;
    }

    .pagination {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        justify-content: center;
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
        background: var(--pure-white);
        border: 2px solid var(--pale-slate);
        border-radius: var(--radius-md);
        color: var(--text-primary);
        text-decoration: none;
        transition: var(--transition);
        font-weight: 600;
    }

    .page-link:hover {
        background: var(--gradient-2);
        color: var(--prussian-blue);
        border-color: transparent;
        transform: translateY(-2px);
    }

    .active .page-link {
        background: var(--gradient-1);
        color: var(--pure-white);
        border-color: transparent;
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="progressive-hero">
    <div class="hero-particles">
        <div class="hero-particle"></div>
        <div class="hero-particle"></div>
        <div class="hero-particle"></div>
    </div>

    <div class="container">
        <div class="hero-content" data-aos="fade-up">
            <span class="hero-badge">{{ App\Helpers\TranslationHelper::trans('progressive-quiz.hero_badge') ?? 'Progressive Learning' }}</span>
            <h1 class="hero-title">{{ App\Helpers\TranslationHelper::trans('progressive-quiz.hero_title') ?? 'Master Skills Level by Level' }}</h1>
            <p class="hero-subtitle">{{ App\Helpers\TranslationHelper::trans('progressive-quiz.hero_subtitle') ?? 'Challenge yourself with our progressive quizzes. Complete levels to unlock the next stage!' }}</p>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="progressive-main">
    <div class="container">
        <!-- Statistics Cards -->
        <div class="stats-section">
            <div class="stats-grid">
                <div class="stat-card" data-aos="fade-up">
                    <div class="stat-icon">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">{{ $totalQuizzes ?? 0 }}</div>
                        <div class="stat-label">{{ App\Helpers\TranslationHelper::trans('progressive-quiz.total_quizzes') ?? 'Total Quizzes' }}</div>
                    </div>
                </div>

                <div class="stat-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-icon">
                        <i class="fas fa-stairs"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">{{ $totalLevels ?? 0 }}</div>
                        <div class="stat-label">{{ App\Helpers\TranslationHelper::trans('progressive-quiz.total_levels') ?? 'Total Levels' }}</div>
                    </div>
                </div>

                <div class="stat-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">{{ $totalAttempts ?? 0 }}</div>
                        <div class="stat-label">{{ App\Helpers\TranslationHelper::trans('progressive-quiz.total_attempts') ?? 'Total Attempts' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search Section -->
        <div class="search-section">
            <form action="{{ route('progressive-quizzes.index') }}" method="GET" class="search-form">
                <div class="search-wrapper">
                    <input type="text" 
                           name="search" 
                           class="search-input" 
                           placeholder="{{ App\Helpers\TranslationHelper::trans('progressive-quiz.search_placeholder') ?? 'Search progressive quizzes...' }}" 
                           value="{{ request('search') }}">
                    
                    <button class="search-btn" type="submit">
                        <i class="fas fa-search"></i>
                        <span>{{ App\Helpers\TranslationHelper::trans('progressive-quiz.search_button') ?? 'Search' }}</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Quizzes Grid -->
        <div class="quizzes-grid">
            @forelse($quizzes as $quiz)
                @php
                    $user = Auth::user();
                    $progress = 0;
                    $currentLevel = null;
                    $completedLevels = 0;
                    
                    if ($user) {
                        $attempt = $quiz->getUserAttempt($user->id);
                        if ($attempt) {
                            $completedLevels = $attempt->levelAttempts()
                                ->where('status', ProgressiveLevelAttempt::STATUS_COMPLETED)
                                ->count();
                            $progress = $quiz->total_levels > 0 ? round(($completedLevels / $quiz->total_levels) * 100) : 0;
                            $currentLevel = $attempt->current_level_number;
                        }
                    }
                @endphp

                <div class="quiz-card" data-aos="fade-up" data-aos-delay="{{ min($loop->index * 50, 300) }}">
                    <div class="quiz-image">
                        @if($quiz->featured_image)
                            <img src="{{ $quiz->featured_image_url }}" alt="{{ $quiz->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <i class="fas fa-layer-group"></i>
                        @endif
                        <span class="quiz-level-badge">{{ $quiz->total_levels }} {{ Str::plural('Level', $quiz->total_levels) }}</span>
                    </div>
                    
                    <div class="quiz-body">
                        <h3 class="quiz-title">{{ $quiz->title }}</h3>
                        
                        @if($quiz->description)
                            <p class="quiz-description">{{ Str::limit($quiz->description, 100) }}</p>
                        @endif
                        
                        <div class="quiz-meta">
                            <div class="meta-item">
                                <i class="fas fa-question-circle"></i>
                                <span>{{ $quiz->total_questions }} {{ Str::plural('Question', $quiz->total_questions) }}</span>
                            </div>
                            
                            <div class="meta-item">
                                <i class="fas fa-clock"></i>
                                <span>{{ $quiz->time_limit_formatted }}</span>
                            </div>
                            
                            <div class="meta-item">
                                <i class="fas fa-percent"></i>
                                <span>{{ $quiz->pass_percentage }}% Pass</span>
                            </div>
                        </div>

                        @if($user && $attempt)
                            <div class="quiz-progress">
                                <div class="progress-header">
                                    <span>Progress</span>
                                    <span>{{ $progress }}%</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: {{ $progress }}%;"></div>
                                </div>
                                @if($currentLevel)
                                    <small class="text-muted mt-1 d-block">Current: Level {{ $currentLevel }}</small>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="quiz-footer">
                        @auth
                            @php
                                $canAttempt = $quiz->canAttempt($user->id);
                                $attempt = $quiz->getUserAttempt($user->id);
                            @endphp

                            @if($attempt)
                                <a href="{{ route('progressive-quizzes.continue', $quiz) }}" class="btn-start">
                                    <i class="fas fa-play-circle"></i>
                                    <span>{{ App\Helpers\TranslationHelper::trans('progressive-quiz.btn_continue') ?? 'Continue' }}</span>
                                </a>
                            @elseif($canAttempt)
                                <form action="{{ route('progressive-quizzes.start', $quiz) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-start">
                                        <i class="fas fa-play"></i>
                                        <span>{{ App\Helpers\TranslationHelper::trans('progressive-quiz.btn_start') ?? 'Start' }}</span>
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('progressive-quizzes.show', $quiz->slug) }}" class="btn-start" style="opacity: 0.6; pointer-events: none;">
                                    <i class="fas fa-lock"></i>
                                    <span>{{ App\Helpers\TranslationHelper::trans('progressive-quiz.btn_max_attempts') ?? 'Max Attempts' }}</span>
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn-login">
                                <i class="fas fa-sign-in-alt"></i>
                                <span>{{ App\Helpers\TranslationHelper::trans('progressive-quiz.btn_login') ?? 'Login to Start' }}</span>
                            </a>
                        @endauth
                        
                        <span class="attempts-info">
                            <i class="fas fa-redo"></i>
                            @if($quiz->attempts_allowed == 0)
                                {{ App\Helpers\TranslationHelper::trans('progressive-quiz.unlimited_attempts') ?? 'Unlimited' }}
                            @else
                                {{ $quiz->attempts_allowed }} {{ Str::plural('attempt', $quiz->attempts_allowed) }}
                            @endif
                        </span>
                    </div>
                </div>
            @empty
                <div class="empty-state" data-aos="fade-up">
                    <div class="empty-icon">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <h3>{{ App\Helpers\TranslationHelper::trans('progressive-quiz.empty_title') ?? 'No Progressive Quizzes Found' }}</h3>
                    <p>{{ App\Helpers\TranslationHelper::trans('progressive-quiz.empty_description') ?? 'Check back later for new progressive quizzes!' }}</p>
                    @if(request('search'))
                        <a href="{{ route('progressive-quizzes.index') }}" class="btn-clear">
                            <i class="fas fa-times"></i>
                            <span>{{ App\Helpers\TranslationHelper::trans('progressive-quiz.btn_clear') ?? 'Clear Search' }}</span>
                        </a>
                    @endif
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($quizzes instanceof \Illuminate\Pagination\LengthAwarePaginator && $quizzes->hasPages())
            <div class="pagination-wrapper">
                {{ $quizzes->withQueryString()->links() }}
            </div>
        @endif
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check if user prefers reduced motion
        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        
        // Search with debounce
        const searchInput = document.querySelector('.search-input');
        let debounceTimer;

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    if (this.value.length > 2 || this.value.length === 0) {
                        this.form.submit();
                    }
                }, prefersReducedMotion ? 0 : 500);
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

        document.querySelectorAll('.quiz-card, .stat-card').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            observer.observe(el);
        });

        // Animation pause for reduced motion
        if (prefersReducedMotion) {
            document.querySelectorAll('.hero-particle, .empty-icon').forEach(element => {
                if (element.style) {
                    element.style.animation = 'none';
                }
            });
        }
    });
</script>
@endpush