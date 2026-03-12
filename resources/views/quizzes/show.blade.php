@extends('layouts.main')

@section('title', App\Helpers\TranslationHelper::trans('quiz-show.page_title', ['title' => $quiz->title]))

@section('meta_description', $quiz->description ?? App\Helpers\TranslationHelper::trans('quiz-show.meta_description'))

@push('styles')
<style>
    /* ===== CLEAN, PROFESSIONAL QUIZ PAGE STYLES ===== */
    /* Using your beautiful logo colors but simplified */
    :root {
        --primary: #18386E;
        --primary-light: #2E5C61;
        --accent: #FBC60C;
        --accent-soft: #EBD789;
        --success: #5AD1E4;
        --danger: #ef4444;
        --gray-100: #F9F7E9;
        --gray-200: #CBD1DA;
        --gray-300: #9F9A87;
        --gray-400: #5f5f5f;
        --white: #FEFDFE;
        --shadow-sm: 0 2px 4px rgba(10, 29, 68, 0.08);
        --shadow-md: 0 4px 12px rgba(10, 29, 68, 0.12);
        --radius: 12px;
    }

    /* ===== MAIN CONTAINER ===== */
    .quiz-container {
        background-color: var(--gray-100);
        min-height: 60vh;
        padding: 40px 0;
    }

    /* ===== MARKETING BANNER ===== */
    .marketing-banner {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        border-radius: var(--radius);
        padding: 20px 32px;
        margin-bottom: 24px;
        color: var(--white);
        box-shadow: var(--shadow-md);
        display: flex;
        align-items: center;
        gap: 16px;
        animation: slideInFade 1s ease-out;
        border: 1px solid rgba(251, 198, 12, 0.3);
    }

    .banner-icon {
        font-size: 2.5rem;
        color: var(--accent);
        animation: pulse 2s infinite;
    }

    .banner-text {
        font-size: 1.2rem;
        font-weight: 600;
        margin: 0;
        line-height: 1.4;
    }

    .banner-text span {
        color: var(--accent);
        font-weight: 700;
    }

    @keyframes slideInFade {
        0% {
            opacity: 0;
            transform: translateY(-20px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }

    /* ===== BACK LINK ===== */
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 24px;
        color: var(--primary);
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s;
        padding: 8px 0;
    }

    .back-link:hover {
        color: var(--accent);
    }

    .back-link i {
        font-size: 14px;
    }

    /* ===== QUIZ HEADER ===== */
    .quiz-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        border-radius: var(--radius);
        padding: 32px;
        margin-bottom: 32px;
        color: var(--white);
        box-shadow: var(--shadow-md);
    }

    .quiz-header h1 {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 8px;
        color: var(--white);
    }

    .quiz-header p {
        font-size: 1rem;
        opacity: 0.9;
        margin-bottom: 0;
        max-width: 800px;
    }

    @media (max-width: 768px) {
        .quiz-header h1 {
            font-size: 1.5rem;
        }
    }

    /* ===== START QUIZ BUTTON TOP ===== */
    .start-quiz-top {
        margin-bottom: 32px;
    }

    .btn-start-top {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        padding: 16px 40px;
        background: var(--accent);
        color: var(--primary);
        border: none;
        border-radius: 50px;
        font-size: 1.2rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        box-shadow: var(--shadow-md);
        border: 2px solid var(--white);
    }

    .btn-start-top:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(251, 198, 12, 0.4);
        background: var(--white);
        color: var(--primary);
    }

    .btn-start-top i {
        font-size: 1.3rem;
    }

    /* ===== ACCORDION STYLES ===== */
    .accordion-section {
        background: var(--white);
        border-radius: var(--radius);
        margin-bottom: 20px;
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(251, 198, 12, 0.1);
        overflow: hidden;
    }

    .accordion-header {
        padding: 20px 24px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.3s ease;
        border-left: 4px solid var(--accent);
    }

    .accordion-header:hover {
        background: var(--primary);
    }

    .accordion-header h4 {
        margin: 0;
        color: var(--white);
        font-size: 1.1rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .accordion-header i {
        color: var(--accent);
        transition: transform 0.3s ease;
    }

    .accordion-header.collapsed i.fa-chevron-up {
        transform: rotate(180deg);
    }

    .accordion-content {
        padding: 24px;
        background: var(--white);
        border-top: 1px solid var(--gray-200);
        display: block;
    }

    .accordion-content.collapsed {
        display: none;
    }

    /* ===== STATISTICS GRID ===== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 32px;
    }

    .stat-card {
        background: var(--white);
        border-radius: var(--radius);
        padding: 20px 16px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(251, 198, 12, 0.1);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        background: var(--primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .stat-icon i {
        font-size: 20px;
        color: var(--white);
    }

    .stat-content {
        flex: 1;
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary);
        line-height: 1.2;
        margin-bottom: 2px;
    }

    .stat-label {
        font-size: 0.8rem;
        color: var(--gray-300);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    @media (max-width: 992px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 576px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .stat-card {
            padding: 16px;
        }
        
        .stat-value {
            font-size: 1.25rem;
        }
    }

    /* ===== CARD STYLES ===== */
    .info-card {
        background: var(--white);
        border-radius: var(--radius);
        padding: 24px;
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(251, 198, 12, 0.1);
        height: 100%;
    }

    .card-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 2px solid var(--accent-soft);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .card-title i {
        color: var(--accent);
    }

    /* ===== DETAILS GRID ===== */
    .details-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }

    .detail-item {
        background: var(--gray-100);
        padding: 12px;
        border-radius: 8px;
        border: 1px solid rgba(251, 198, 12, 0.1);
    }

    .detail-item .label {
        font-size: 0.7rem;
        color: var(--gray-300);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }

    .detail-item .value {
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--primary);
    }

    .type-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        background: var(--primary);
        color: var(--white);
    }

    /* ===== ATTEMPTS TABLE ===== */
    .table-responsive {
        overflow-x: auto;
    }

    .attempts-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.9rem;
    }

    .attempts-table th {
        text-align: left;
        padding: 12px;
        background: var(--gray-100);
        color: var(--primary);
        font-weight: 600;
        border-bottom: 2px solid var(--accent-soft);
    }

    .attempts-table td {
        padding: 12px;
        border-bottom: 1px solid var(--gray-200);
        color: var(--gray-400);
    }

    .attempts-table tr:last-child td {
        border-bottom: none;
    }

    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .status-badge.success {
        background: rgba(90, 209, 228, 0.1);
        color: var(--primary-light);
    }

    .status-badge.danger {
        background: rgba(239, 68, 68, 0.1);
        color: var(--danger);
    }

    .best-score {
        margin-top: 20px;
        padding: 16px;
        background: linear-gradient(135deg, var(--accent-soft) 0%, var(--accent) 100%);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-weight: 600;
        color: var(--primary);
    }

    .best-score strong {
        background: var(--white);
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 1rem;
    }

    /* ===== START CARD ===== */
    .start-card {
        text-align: center;
    }

    .alert-info {
        background: rgba(90, 209, 228, 0.1);
        border: 1px solid var(--success);
        border-radius: 8px;
        padding: 12px 16px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--primary-light);
        font-size: 0.9rem;
        text-align: left;
    }

    .alert-warning {
        background: rgba(251, 198, 12, 0.1);
        border: 1px solid var(--accent);
        border-radius: 8px;
        padding: 12px 16px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
        color: #b85e00;
        font-size: 0.9rem;
        text-align: left;
    }

    .btn-start {
        width: 100%;
        padding: 14px 20px;
        background: var(--primary);
        color: var(--white);
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-start:hover {
        background: var(--primary-light);
    }

    .btn-secondary {
        width: 100%;
        padding: 14px 20px;
        background: var(--accent);
        color: var(--primary);
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: opacity 0.2s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-secondary:hover {
        opacity: 0.9;
    }

    .btn-spinner {
        display: inline-block;
        width: 18px;
        height: 18px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        border-top-color: var(--white);
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    .warnings {
        margin-top: 16px;
        text-align: left;
    }

    .warning-item {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 8px;
        color: var(--gray-400);
        font-size: 0.85rem;
    }

    .warning-item i {
        color: var(--accent);
        width: 16px;
    }

    /* ===== RULES LIST ===== */
    .rules-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .rules-list li {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px dashed var(--gray-200);
        color: var(--gray-400);
        font-size: 0.9rem;
    }

    .rules-list li:last-child {
        border-bottom: none;
    }

    .rules-list li i {
        color: var(--success);
        width: 18px;
    }

    /* ===== LOGIN PROMPT ===== */
    .login-prompt {
        text-align: center;
        margin-top: 20px;
        font-size: 0.9rem;
        color: var(--gray-300);
    }

    .login-prompt a {
        color: var(--accent);
        font-weight: 600;
        text-decoration: none;
    }

    .login-prompt a:hover {
        text-decoration: underline;
    }

    /* ===== RESPONSIVE SPACING ===== */
    @media (max-width: 768px) {
        .quiz-container {
            padding: 20px 0;
        }
        
        .quiz-header {
            padding: 24px;
        }
        
        .info-card {
            padding: 20px;
        }
        
        .details-grid {
            grid-template-columns: 1fr;
        }
        
        .marketing-banner {
            padding: 16px 20px;
        }
        
        .banner-text {
            font-size: 1rem;
        }
        
        .banner-icon {
            font-size: 2rem;
        }
    }

    @media (max-width: 576px) {
        .quiz-header h1 {
            font-size: 1.25rem;
        }
        
        .stat-card {
            padding: 12px;
        }
        
        .stat-icon {
            width: 40px;
            height: 40px;
        }
        
        .stat-icon i {
            font-size: 16px;
        }
    }
</style>
@endpush

@section('content')
<div class="quiz-container">
    <div class="container">
        <!-- Marketing Banner -->
        <div class="marketing-banner">
            <div class="banner-icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="banner-text">
                <span>$ Take the Quiz. Hit the Recommended Score. Compete for Weekly Cash Rewards.</span>
            </div>
        </div>

        <!-- Back Link -->
        <a href="{{ route('quiz') }}" class="back-link">
            <i class="fas fa-arrow-left"></i>
            {{ App\Helpers\TranslationHelper::trans('quiz-show.back_to_quizzes') }}
        </a>

        <!-- Start Quiz Button - Top Position -->
        @auth
            @if(isset($canAttempt) && $canAttempt)
                <div class="start-quiz-top text-center">
                    <form action="{{ route('quizzes.start', $quiz) }}" method="POST" id="startQuizFormTop" style="display: inline-block;">
                        @csrf
                        <button type="submit" class="btn-start-top" id="startQuizBtnTop">
                            <i class="fas fa-play"></i>
                            <span>{{ App\Helpers\TranslationHelper::trans('quiz-show.start_quiz_now') }}</span>
                        </button>
                    </form>
                </div>
            @endif
        @endauth

        <!-- Quiz Header -->
        <!-- <div class="quiz-header">
            <h1>{{ $quiz->title }}</h1>
            @if($quiz->description)
                <p>{{ $quiz->description }}</p>
            @endif
        </div> -->

        <!-- Statistics Cards -->
        <!-- <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-question-circle"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $quiz->questions_count ?? $quiz->questions->count() }}</div>
                    <div class="stat-label">{{ App\Helpers\TranslationHelper::trans('quiz-show.total_questions') }}</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $quiz->time_limit ? $quiz->time_limit . ' ' . App\Helpers\TranslationHelper::trans('quiz-show.min') : '∞' }}</div>
                    <div class="stat-label">{{ App\Helpers\TranslationHelper::trans('quiz-show.time_limit') }}</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-trophy"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $quiz->pass_percentage }}%</div>
                    <div class="stat-label">{{ App\Helpers\TranslationHelper::trans('quiz-show.pass_percentage') }}</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-redo"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $quiz->attempts_allowed == 0 ? '∞' : $quiz->attempts_allowed }}</div>
                    <div class="stat-label">{{ App\Helpers\TranslationHelper::trans('quiz-show.attempts_allowed') }}</div>
                </div>
            </div>
        </div> -->

        <div class="row g-4">
            <!-- Left Column - Details and Attempts (Collapsible) -->
            <div class="col-lg-8">
                <!-- Quiz Details Card - Collapsible -->
                <div class="accordion-section">
                    <div class="accordion-header" onclick="toggleAccordion(this)">
                        <h4>
                            <i class="fas fa-info-circle"></i>
                            {{ App\Helpers\TranslationHelper::trans('quiz-show.quiz_details') }}
                        </h4>
                        <i class="fas fa-chevron-up"></i>
                    </div>
                    <div class="accordion-content">
                        <div class="details-grid">
                            <div class="detail-item">
                                <div class="label">{{ App\Helpers\TranslationHelper::trans('quiz-show.type') }}</div>
                                <div class="value">
                                    <span class="type-badge">
                                        @if($quiz->type == 'standalone')
                                            {{ App\Helpers\TranslationHelper::trans('quiz-show.standalone') }}
                                        @elseif($quiz->type == 'course')
                                            {{ App\Helpers\TranslationHelper::trans('quiz-show.course') }}
                                        @elseif($quiz->type == 'lesson')
                                            {{ App\Helpers\TranslationHelper::trans('quiz-show.lesson') }}
                                        @else
                                            {{ ucfirst($quiz->type) }}
                                        @endif
                                    </span>
                                </div>
                            </div>

                            <div class="detail-item">
                                <div class="label">{{ App\Helpers\TranslationHelper::trans('quiz-show.shuffle_questions') }}</div>
                                <div class="value">{{ $quiz->shuffle_questions ? App\Helpers\TranslationHelper::trans('quiz-show.yes') : App\Helpers\TranslationHelper::trans('quiz-show.no') }}</div>
                            </div>

                            <div class="detail-item">
                                <div class="label">{{ App\Helpers\TranslationHelper::trans('quiz-show.randomize_options') }}</div>
                                <div class="value">{{ $quiz->randomize_options ? App\Helpers\TranslationHelper::trans('quiz-show.yes') : App\Helpers\TranslationHelper::trans('quiz-show.no') }}</div>
                            </div>

                            <div class="detail-item">
                                <div class="label">{{ App\Helpers\TranslationHelper::trans('quiz-show.show_results') }}</div>
                                <div class="value">{{ $quiz->show_results ? App\Helpers\TranslationHelper::trans('quiz-show.yes') : App\Helpers\TranslationHelper::trans('quiz-show.no') }}</div>
                            </div>

                            <div class="detail-item">
                                <div class="label">{{ App\Helpers\TranslationHelper::trans('quiz-show.show_answers') }}</div>
                                <div class="value">{{ $quiz->show_answers ? App\Helpers\TranslationHelper::trans('quiz-show.yes') : App\Helpers\TranslationHelper::trans('quiz-show.no') }}</div>
                            </div>

                            <div class="detail-item">
                                <div class="label">{{ App\Helpers\TranslationHelper::trans('quiz-show.category') }}</div>
                                <div class="value">{{ $quiz->category ?? App\Helpers\TranslationHelper::trans('quiz-show.general') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User's Previous Attempts - Collapsible -->
                @if(isset($attempts) && $attempts->count() > 0)
                <div class="accordion-section">
                    <div class="accordion-header" onclick="toggleAccordion(this)">
                        <h4>
                            <i class="fas fa-history"></i>
                            {{ App\Helpers\TranslationHelper::trans('quiz-show.your_attempts') }}
                        </h4>
                        <i class="fas fa-chevron-up"></i>
                    </div>
                    <div class="accordion-content">
                        <div class="table-responsive">
                            <table class="attempts-table">
                                <thead>
                                    <tr>
                                        <th>{{ App\Helpers\TranslationHelper::trans('quiz-show.attempt') }}</th>
                                        <th>{{ App\Helpers\TranslationHelper::trans('quiz-show.score') }}</th>
                                        <th>{{ App\Helpers\TranslationHelper::trans('quiz-show.percentage') }}</th>
                                        <th>{{ App\Helpers\TranslationHelper::trans('quiz-show.status') }}</th>
                                        <th>{{ App\Helpers\TranslationHelper::trans('quiz-show.date') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($attempts as $attempt)
                                    <tr>
                                        <td>#{{ $attempt->attempt_number }}</td>
                                        <td>{{ $attempt->score }}/{{ $quiz->questions->sum('points') }}</td>
                                        <td>{{ $attempt->percentage }}%</td>
                                        <td>
                                            <span class="status-badge {{ $attempt->passed ? 'success' : 'danger' }}">
                                                {{ $attempt->passed ? App\Helpers\TranslationHelper::trans('quiz-show.passed') : App\Helpers\TranslationHelper::trans('quiz-show.failed') }}
                                            </span>
                                        </td>
                                        <td>{{ $attempt->completed_at ? $attempt->completed_at->format('M d, Y') : App\Helpers\TranslationHelper::trans('quiz-show.in_progress') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        @if(isset($bestScore) && $bestScore > 0)
                        <div class="best-score">
                            <span><i class="fas fa-trophy" style="margin-right: 8px;"></i> {{ App\Helpers\TranslationHelper::trans('quiz-show.best_score') }}</span>
                            <strong>{{ $bestScore }} {{ App\Helpers\TranslationHelper::trans('quiz-show.points') }}</strong>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Column - Start Quiz and Rules -->
            <div class="col-lg-4">
                <!-- Start Quiz Card (Bottom) -->
                <!-- <div class="info-card start-card mb-4">
                    <h4 class="card-title">
                        <i class="fas fa-play-circle"></i>
                        {{ App\Helpers\TranslationHelper::trans('quiz-show.ready_to_start') }}
                    </h4>
                    
                    @auth
                        @if(isset($canAttempt) && $canAttempt)
                            <div class="alert-info">
                                <i class="fas fa-info-circle"></i>
                                <span>
                                    @if($quiz->attempts_allowed == 0)
                                        {{ App\Helpers\TranslationHelper::trans('quiz-show.unlimited_attempts') }}
                                    @else
                                        {{ App\Helpers\TranslationHelper::trans('quiz-show.attempts_remaining', ['count' => $quiz->attempts_allowed - ($attempts->count() ?? 0)]) }}
                                    @endif
                                </span>
                            </div>
                            
                            <form action="{{ route('quizzes.start', $quiz) }}" method="POST" id="startQuizForm">
                                @csrf
                                <button type="submit" class="btn-start" id="startQuizBtn">
                                    <i class="fas fa-play"></i>
                                    <span>{{ App\Helpers\TranslationHelper::trans('quiz-show.start_quiz_now') }}</span>
                                </button>
                            </form>
                            
                            <div class="warnings">
                                @if($quiz->time_limit)
                                    <div class="warning-item">
                                        <i class="fas fa-hourglass-half"></i>
                                        {{ App\Helpers\TranslationHelper::trans('quiz-show.time_warning', ['time' => $quiz->time_limit]) }}
                                    </div>
                                @endif
                                
                                @if($quiz->shuffle_questions)
                                    <div class="warning-item">
                                        <i class="fas fa-random"></i>
                                        {{ App\Helpers\TranslationHelper::trans('quiz-show.shuffle_warning') }}
                                    </div>
                                @endif
                                
                                @if($quiz->randomize_options)
                                    <div class="warning-item">
                                        <i class="fas fa-shuffle"></i>
                                        {{ App\Helpers\TranslationHelper::trans('quiz-show.randomize_warning') }}
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="alert-warning">
                                <i class="fas fa-exclamation-triangle"></i>
                                <span>{{ App\Helpers\TranslationHelper::trans('quiz-show.max_attempts_reached') }}</span>
                            </div>
                            
                            @if($quiz->show_results && $quiz->show_answers)
                                <a href="{{ route('quizzes.results', $quiz) }}" class="btn-secondary">
                                    <i class="fas fa-chart-bar"></i>
                                    <span>{{ App\Helpers\TranslationHelper::trans('quiz-show.view_results') }}</span>
                                </a>
                            @endif
                        @endif
                    @else
                        <div class="alert-info">
                            <i class="fas fa-lock"></i>
                            <span>{{ App\Helpers\TranslationHelper::trans('quiz-show.login_required') }}</span>
                        </div>
                        
                        <a href="{{ route('login') }}" class="btn-start">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>{{ App\Helpers\TranslationHelper::trans('quiz-show.login_to_start') }}</span>
                        </a>
                        
                        <div class="login-prompt">
                            <p>{{ App\Helpers\TranslationHelper::trans('quiz-show.no_account') }} <a href="{{ route('register') }}">{{ App\Helpers\TranslationHelper::trans('quiz-show.register_here') }}</a></p>
                        </div>
                    @endauth
                </div> -->

                <!-- Quiz Rules Card - Collapsible -->
                <div class="accordion-section">
                    <div class="accordion-header" onclick="toggleAccordion(this)">
                        <h4>
                            <i class="fas fa-gavel"></i>
                            {{ App\Helpers\TranslationHelper::trans('quiz-show.quiz_rules') }}
                        </h4>
                        <i class="fas fa-chevron-up"></i>
                    </div>
                    <div class="accordion-content">
                        <ul class="rules-list">
                            <li>
                                <i class="fas fa-check-circle"></i>
                                {{ App\Helpers\TranslationHelper::trans('quiz-show.rule_read_carefully') }}
                            </li>
                            <li>
                                <i class="fas fa-check-circle"></i>
                                {{ App\Helpers\TranslationHelper::trans('quiz-show.rule_no_pause') }}
                            </li>
                            @if($quiz->time_limit)
                            <li>
                                <i class="fas fa-check-circle"></i>
                                {{ App\Helpers\TranslationHelper::trans('quiz-show.rule_timer_starts') }}
                            </li>
                            @endif
                            <li>
                                <i class="fas fa-check-circle"></i>
                                {{ App\Helpers\TranslationHelper::trans('quiz-show.rule_all_required') }}
                            </li>
                            @if($quiz->pass_percentage)
                            <li>
                                <i class="fas fa-check-circle"></i>
                                {{ App\Helpers\TranslationHelper::trans('quiz-show.rule_pass_percentage', ['percentage' => $quiz->pass_percentage]) }}
                            </li>
                            @endif
                            <li>
                                <i class="fas fa-check-circle"></i>
                                {{ App\Helpers\TranslationHelper::trans('quiz-show.rule_results_after') }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Accordion functionality
    window.toggleAccordion = function(header) {
        const content = header.nextElementSibling;
        const icon = header.querySelector('i.fa-chevron-up, i.fa-chevron-down');
        
        if (content.classList.contains('collapsed')) {
            content.classList.remove('collapsed');
            header.classList.remove('collapsed');
            if (icon) {
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
            }
        } else {
            content.classList.add('collapsed');
            header.classList.add('collapsed');
            if (icon) {
                icon.classList.remove('fa-chevron-up');
                icon.classList.add('fa-chevron-down');
            }
        }
    };

    // Initially collapse all accordion sections
    document.querySelectorAll('.accordion-content').forEach(content => {
        content.classList.add('collapsed');
    });
    document.querySelectorAll('.accordion-header').forEach(header => {
        header.classList.add('collapsed');
        const icon = header.querySelector('i.fa-chevron-up');
        if (icon) {
            icon.classList.remove('fa-chevron-up');
            icon.classList.add('fa-chevron-down');
        }
    });

    // Confirmation before starting quiz (for both top and bottom buttons)
    const startForms = document.querySelectorAll('#startQuizForm, #startQuizFormTop');
    const startBtns = document.querySelectorAll('#startQuizBtn, #startQuizBtnTop');
    
    startForms.forEach((form, index) => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const quizTitle = @json($quiz->title);
            const questionsCount = {{ $quiz->questions_count ?? $quiz->questions->count() }};
            const timeLimit = {{ $quiz->time_limit ?? 'null' }};
            
            let timeWarning = '';
            if (timeLimit) {
                timeWarning = `\n\n⏱️ {{ App\Helpers\TranslationHelper::trans('quiz-show.confirm_time_warning', ['time' => $quiz->time_limit]) }}`;
            }
            
            const confirmation = confirm(
                `{{ App\Helpers\TranslationHelper::trans('quiz-show.confirm_start') }} "${quizTitle}"?` +
                `\n\n📝 {{ App\Helpers\TranslationHelper::trans('quiz-show.confirm_questions') }}: ${questionsCount}` +
                timeWarning +
                `\n\n⚠️ {{ App\Helpers\TranslationHelper::trans('quiz-show.confirm_no_pause') }}` +
                `\n\n{{ App\Helpers\TranslationHelper::trans('quiz-show.confirm_begin') }}`
            );
            
            if (confirmation) {
                if (startBtns[index]) {
                    startBtns[index].innerHTML = '<span class="btn-spinner"></span> {{ App\Helpers\TranslationHelper::trans('quiz-show.starting') }}';
                    startBtns[index].disabled = true;
                }
                this.submit();
            }
        });
    });
});
</script>
@endpush