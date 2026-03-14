@extends('layouts.main')

@section('title', $quiz->title . ' - Progressive Quiz')

@section('meta_description', $quiz->description)

@push('styles')
<style>
    /* ===== PROGRESSIVE QUIZ SHOW PAGE STYLES ===== */
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
        --primary: var(--regal-navy);
        --accent: var(--bright-amber);
        --success: var(--sky-blue);
        --danger: #ef4444;
        --gray-100: var(--ivory);
        --gray-200: var(--pale-slate);
        --gray-300: var(--khaki-beige);
        --gray-400: #5f5f5f;
        --white: var(--pure-white);
        --shadow-sm: 0 2px 8px rgba(10, 29, 68, 0.08);
        --shadow-md: 0 4px 12px rgba(10, 29, 68, 0.12);
        --shadow-lg: 0 8px 24px rgba(10, 29, 68, 0.15);
        --radius: 12px;
        --radius-lg: 16px;
        --radius-full: 9999px;
        --transition: all 0.3s ease;
    }

    /* ===== MAIN CONTAINER ===== */
    .progressive-container {
        background-color: var(--gray-100);
        min-height: 60vh;
        padding: 40px 0;
    }

    /* ===== MARKETING BANNER ===== */
    .marketing-banner {
        background: linear-gradient(135deg, var(--primary) 0%, var(--dark-slate) 100%);
        border-radius: var(--radius-lg);
        padding: 20px 32px;
        margin-bottom: 24px;
        color: var(--white);
        box-shadow: var(--shadow-lg);
        display: flex;
        align-items: center;
        gap: 20px;
        animation: slideInFade 1s ease-out;
        border: 1px solid rgba(251, 198, 12, 0.3);
    }

    .banner-icon {
        font-size: 3rem;
        color: var(--accent);
        animation: pulse 2s infinite;
    }

    .banner-text {
        font-size: 1.3rem;
        font-weight: 600;
        margin: 0;
        line-height: 1.4;
    }

    .banner-text span {
        color: var(--accent);
        font-weight: 700;
    }

    @keyframes slideInFade {
        0% { opacity: 0; transform: translateY(-20px); }
        100% { opacity: 1; transform: translateY(0); }
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
        transition: var(--transition);
        padding: 8px 0;
    }

    .back-link:hover {
        color: var(--accent);
        transform: translateX(-5px);
    }

    .back-link i {
        font-size: 14px;
    }

    /* ===== QUIZ HEADER ===== */
    .quiz-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--dark-slate) 100%);
        border-radius: var(--radius-lg);
        padding: 40px;
        margin-bottom: 32px;
        color: var(--white);
        box-shadow: var(--shadow-lg);
        position: relative;
        overflow: hidden;
    }

    .quiz-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(251, 198, 12, 0.1);
        border-radius: 50%;
    }

    .quiz-header::after {
        content: '';
        position: absolute;
        bottom: -50%;
        left: -10%;
        width: 250px;
        height: 250px;
        background: rgba(90, 209, 228, 0.1);
        border-radius: 50%;
    }

    .quiz-header h1 {
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 15px;
        position: relative;
        z-index: 1;
        color: var(--white);
    }

    .quiz-header p {
        font-size: 1.1rem;
        opacity: 0.95;
        margin-bottom: 0;
        max-width: 800px;
        position: relative;
        z-index: 1;
    }

    @media (max-width: 768px) {
        .quiz-header {
            padding: 30px;
        }
        .quiz-header h1 {
            font-size: 1.8rem;
        }
        .quiz-header p {
            font-size: 1rem;
        }
    }

    @media (max-width: 576px) {
        .quiz-header {
            padding: 25px;
        }
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
        padding: 18px 50px;
        background: var(--accent);
        color: var(--primary);
        border: none;
        border-radius: var(--radius-full);
        font-size: 1.3rem;
        font-weight: 700;
        cursor: pointer;
        transition: var(--transition);
        text-decoration: none;
        box-shadow: var(--shadow-lg);
        border: 2px solid var(--white);
    }

    .btn-start-top:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(251, 198, 12, 0.4);
        background: var(--white);
        color: var(--primary);
    }

    .btn-start-top i {
        font-size: 1.4rem;
    }

    @media (max-width: 768px) {
        .btn-start-top {
            padding: 16px 40px;
            font-size: 1.2rem;
        }
    }

    @media (max-width: 576px) {
        .btn-start-top {
            width: 100%;
            padding: 16px 20px;
            font-size: 1.1rem;
        }
    }

    /* ===== ACCORDION STYLES ===== */
    .accordion-section {
        background: var(--white);
        border-radius: var(--radius-lg);
        margin-bottom: 20px;
        box-shadow: var(--shadow-md);
        border: 1px solid rgba(251, 198, 12, 0.1);
        overflow: hidden;
    }

    .accordion-header {
        padding: 20px 24px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--dark-slate) 100%);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: var(--transition);
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

    .accordion-header.collapsed i {
        transform: rotate(180deg);
    }

    .accordion-content {
        padding: 24px;
        background: var(--white);
        border-top: 1px solid var(--gray-200);
    }

    .accordion-content.collapsed {
        display: none;
    }

    /* ===== STATISTICS GRID ===== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 20px;
    }

    .stat-card {
        background: var(--white);
        border-radius: var(--radius);
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(251, 198, 12, 0.1);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        background: var(--primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .stat-icon i {
        font-size: 22px;
        color: var(--white);
    }

    .stat-content {
        flex: 1;
    }

    .stat-value {
        font-size: 1.6rem;
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
            padding: 15px;
        }
        .stat-value {
            font-size: 1.4rem;
        }
    }

    /* ===== LEVELS LIST ===== */
    .levels-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .level-item {
        background: var(--gray-100);
        border-radius: var(--radius);
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 20px;
        transition: var(--transition);
        border: 2px solid transparent;
    }

    .level-item:hover {
        border-color: var(--accent);
        transform: translateX(5px);
        box-shadow: var(--shadow-md);
    }

    .level-item.completed {
        background: rgba(90, 209, 228, 0.1);
        border-left: 4px solid var(--success);
    }

    .level-item.current {
        background: rgba(251, 198, 12, 0.1);
        border-left: 4px solid var(--accent);
    }

    .level-item.locked {
        opacity: 0.6;
        background: var(--gray-200);
    }

    .level-number {
        width: 50px;
        height: 50px;
        background: var(--primary);
        color: var(--white);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .level-content {
        flex: 1;
    }

    .level-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 5px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .level-badge {
        font-size: 0.7rem;
        padding: 3px 8px;
        border-radius: var(--radius-full);
        background: var(--success);
        color: var(--white);
    }

    .level-description {
        color: var(--gray-400);
        font-size: 0.95rem;
        margin-bottom: 5px;
    }

    .level-meta {
        display: flex;
        gap: 15px;
        font-size: 0.85rem;
        color: var(--gray-300);
    }

    .level-meta i {
        color: var(--accent);
        margin-right: 5px;
    }

    .level-status {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .status-badge {
        padding: 5px 12px;
        border-radius: var(--radius-full);
        font-size: 0.8rem;
        font-weight: 600;
    }

    .status-badge.completed {
        background: rgba(90, 209, 228, 0.1);
        color: var(--success);
    }

    .status-badge.current {
        background: rgba(251, 198, 12, 0.1);
        color: var(--accent);
    }

    .status-badge.locked {
        background: var(--gray-200);
        color: var(--gray-300);
    }

    /* ===== PROGRESS CARD ===== */
    .progress-card {
        background: linear-gradient(135deg, var(--primary) 0%, var(--dark-slate) 100%);
        border-radius: var(--radius-lg);
        padding: 25px;
        color: var(--white);
        margin-bottom: 20px;
    }

    .progress-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .progress-title i {
        color: var(--accent);
    }

    .progress-bar-container {
        margin-bottom: 15px;
    }

    .progress-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
        font-size: 0.9rem;
    }

    .progress-bar-custom {
        height: 10px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: var(--radius-full);
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: var(--accent);
        border-radius: var(--radius-full);
        transition: width 0.5s ease;
    }

    .current-level {
        display: flex;
        justify-content: space-between;
        font-size: 0.95rem;
        padding-top: 10px;
        border-top: 1px solid rgba(255, 255, 255, 0.2);
    }

    /* ===== START CARD ===== */
    .start-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 25px;
        box-shadow: var(--shadow-md);
        border: 1px solid rgba(251, 198, 12, 0.1);
        text-align: center;
        margin-bottom: 20px;
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
        color: var(--dark-slate);
        font-size: 0.95rem;
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
        font-size: 0.95rem;
        text-align: left;
    }

    .btn-start {
        width: 100%;
        padding: 16px 20px;
        background: var(--primary);
        color: var(--white);
        border: none;
        border-radius: var(--radius);
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        text-decoration: none;
    }

    .btn-start:hover {
        background: var(--dark-slate);
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .btn-continue {
        width: 100%;
        padding: 16px 20px;
        background: var(--accent);
        color: var(--primary);
        border: none;
        border-radius: var(--radius);
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        text-decoration: none;
        margin-bottom: 10px;
    }

    .btn-continue:hover {
        background: var(--white);
        border: 2px solid var(--accent);
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .btn-spinner {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        border-top-color: var(--white);
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    .warnings {
        margin-top: 20px;
        text-align: left;
    }

    .warning-item {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 8px;
        color: var(--gray-400);
        font-size: 0.9rem;
    }

    .warning-item i {
        color: var(--accent);
        width: 18px;
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
        padding: 12px 0;
        border-bottom: 1px dashed var(--gray-200);
        color: var(--gray-400);
        font-size: 0.95rem;
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
        font-size: 0.95rem;
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

    /* ===== RESPONSIVE ===== */
    @media (max-width: 992px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .progressive-container {
            padding: 20px 0;
        }
        .quiz-header {
            padding: 30px;
        }
        .quiz-header h1 {
            font-size: 1.8rem;
        }
        .marketing-banner {
            padding: 16px 20px;
        }
        .banner-text {
            font-size: 1.1rem;
        }
        .banner-icon {
            font-size: 2.5rem;
        }
        .level-item {
            flex-direction: column;
            align-items: flex-start;
            padding: 15px;
        }
        .level-status {
            align-self: flex-end;
        }
    }

    @media (max-width: 576px) {
        .quiz-header {
            padding: 25px;
        }
        .quiz-header h1 {
            font-size: 1.5rem;
        }
        .stats-grid {
            grid-template-columns: 1fr;
        }
        .stat-card {
            padding: 15px;
        }
        .stat-value {
            font-size: 1.4rem;
        }
        .marketing-banner {
            flex-direction: column;
            text-align: center;
        }
        .banner-text {
            font-size: 1rem;
        }
    }
</style>
@endpush

@section('content')
<div class="progressive-container">
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
        <a href="{{ route('progressive-quizzes.index') }}" class="back-link">
            <i class="fas fa-arrow-left"></i>
            Back to Progressive Quizzes
        </a>

        <!-- Start Quiz Button - Top Position (if no attempt in progress) -->
        @auth
            @if($canAttempt && !$attempt)
                <div class="start-quiz-top text-center">
                    <form action="{{ route('progressive-quizzes.start', $quiz) }}" method="POST" id="startQuizFormTop" style="display: inline-block;">
                        @csrf
                        <button type="submit" class="btn-start-top" id="startQuizBtnTop">
                            <i class="fas fa-play"></i>
                            <span>Start Progressive Quiz</span>
                        </button>
                    </form>
                </div>
            @endif
        @endauth

        <!-- Quiz Header -->
        <div class="quiz-header">
            <h1>{{ $quiz->title }}</h1>
            @if($quiz->description)
                <p>{{ $quiz->description }}</p>
            @endif
        </div>

        <div class="row g-4">
            <!-- Left Column - Quiz Details and Levels -->
            <div class="col-lg-8">
                <!-- Quiz Details Card - Collapsible -->
                <div class="accordion-section">
                    <div class="accordion-header" onclick="toggleAccordion(this)">
                        <h4>
                            <i class="fas fa-info-circle"></i>
                            Quiz Details
                        </h4>
                        <i class="fas fa-chevron-up"></i>
                    </div>
                    <div class="accordion-content">
                        <div class="stats-grid">
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-layer-group"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="stat-value">{{ $quiz->total_levels }}</div>
                                    <div class="stat-label">Total Levels</div>
                                </div>
                            </div>

                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-question-circle"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="stat-value">{{ $totalQuestions }}</div>
                                    <div class="stat-label">Total Questions</div>
                                </div>
                            </div>

                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="stat-value">{{ $quiz->time_limit_formatted }}</div>
                                    <div class="stat-label">Time Limit</div>
                                </div>
                            </div>

                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-percent"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="stat-value">{{ $quiz->pass_percentage }}%</div>
                                    <div class="stat-label">Pass Percentage</div>
                                </div>
                            </div>
                        </div>

                        <div class="details-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px;">
                            <div class="detail-item" style="background: var(--gray-100); padding: 12px; border-radius: 8px;">
                                <div class="label" style="font-size: 0.7rem; color: var(--gray-300); text-transform: uppercase;">Shuffle Questions</div>
                                <div class="value" style="font-weight: 600;">{{ $quiz->shuffle_questions ? 'Yes' : 'No' }}</div>
                            </div>

                            <div class="detail-item" style="background: var(--gray-100); padding: 12px; border-radius: 8px;">
                                <div class="label" style="font-size: 0.7rem; color: var(--gray-300); text-transform: uppercase;">Attempts Allowed</div>
                                <div class="value" style="font-weight: 600;">{{ $quiz->attempts_allowed == 0 ? 'Unlimited' : $quiz->attempts_allowed }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Levels List -->
<!-- Levels List -->
<div class="accordion-section">
    <div class="accordion-header" onclick="toggleAccordion(this)">
        <h4>
            <i class="fas fa-layer-group"></i>
            Quiz Levels
        </h4>
        <i class="fas fa-chevron-up"></i>
    </div>
    <div class="accordion-content">
        <div class="levels-list">
            @foreach($quiz->levels as $level)
                @php
                    $status = $levelStatuses[$level->id] ?? 'locked';
                    $isCompleted = $status == 'completed';
                    $isCurrent = $status == 'in_progress';
                    $isLocked = $status == 'locked';
                    $isAvailable = $status == 'available';
                    
                    // Check if level can be retried (completed and user has attempts left)
                    $canRetry = $isCompleted && $canAttempt;
                @endphp
                
                <div class="level-item {{ $isCompleted ? 'completed' : ($isCurrent ? 'current' : ($isLocked ? 'locked' : '')) }}">
                    <div class="level-number">{{ $level->level_number }}</div>
                    <div class="level-content">
                        <div class="level-title">
                            {{ $level->title }}
                            @if($isCompleted)
                                <span class="level-badge">Completed</span>
                            @elseif($isCurrent)
                                <span class="level-badge" style="background: var(--accent);">In Progress</span>
                            @endif
                        </div>
                        
                        @if($level->description)
                            <div class="level-description">{{ $level->description }}</div>
                        @endif
                        
                        <div class="level-meta">
                            <span><i class="fas fa-question-circle"></i> {{ $level->question_count }} Questions</span>
                            <span><i class="fas fa-percent"></i> {{ $level->min_percentage }}% to pass</span>
                            @if($level->time_limit)
                                <span><i class="fas fa-clock"></i> {{ $level->time_limit }} min</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="level-status">
                        @auth
                            @if($isCurrent && $attempt)
                                <a href="{{ route('progressive-quizzes.take', ['progressiveQuiz' => $quiz->id, 'level' => $level->id]) }}" 
                                   class="btn-continue-small" 
                                   style="padding: 8px 16px; background: var(--accent); color: var(--primary); border-radius: var(--radius-full); text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 5px;">
                                    <i class="fas fa-play"></i> Continue
                                </a>
                                
                            @elseif($isCompleted)
                                <span class="status-badge completed" style="display: inline-flex; align-items: center; gap: 5px;">
                                    <i class="fas fa-check-circle"></i> Completed
                                </span>
                                @if($canRetry)
                                    <form action="{{ route('progressive-quizzes.start', $quiz) }}" method="POST" style="display: inline-block; margin-left: 10px;">
                                        @csrf
                                        <input type="hidden" name="level_id" value="{{ $level->id }}">
                                        <button type="submit" class="btn-retry-small" style="padding: 6px 12px; background: transparent; border: 2px solid var(--success); color: var(--success); border-radius: var(--radius-full); font-size: 0.8rem; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 5px;">
                                            <i class="fas fa-redo"></i> Retry
                                        </button>
                                    </form>
                                @endif
                                
                            @elseif($isAvailable)
                                <span class="status-badge available" style="display: inline-flex; align-items: center; gap: 5px; background: rgba(90, 209, 228, 0.1); color: var(--sky-blue);">
                                    <i class="fas fa-unlock"></i> Available
                                </span>
                                @if($attempt)
                                    <a href="{{ route('progressive-quizzes.take', ['progressiveQuiz' => $quiz->id, 'level' => $level->id]) }}" 
                                       class="btn-start-small" 
                                       style="padding: 8px 16px; background: var(--primary); color: var(--white); border-radius: var(--radius-full); text-decoration: none; font-weight: 600; margin-left: 10px; display: inline-flex; align-items: center; gap: 5px;">
                                        <i class="fas fa-play"></i> Start
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="btn-start-small" style="padding: 8px 16px; background: var(--primary); color: var(--white); border-radius: var(--radius-full); text-decoration: none; font-weight: 600; margin-left: 10px; display: inline-flex; align-items: center; gap: 5px;">
                                        <i class="fas fa-sign-in-alt"></i> Login
                                    </a>
                                @endif
                                
                            @elseif($isLocked)
                                <span class="status-badge locked" style="display: inline-flex; align-items: center; gap: 5px;">
                                    <i class="fas fa-lock"></i> Locked
                                </span>
                            @endif
                        @else
                            @if($level->level_number == 1)
                                <span class="status-badge available" style="background: rgba(90, 209, 228, 0.1); color: var(--sky-blue);">
                                    <i class="fas fa-unlock"></i> Available
                                </span>
                                <a href="{{ route('login') }}" class="btn-start-small" style="padding: 8px 16px; background: var(--primary); color: var(--white); border-radius: var(--radius-full); text-decoration: none; font-weight: 600; margin-left: 10px;">
                                    <i class="fas fa-sign-in-alt"></i> Login
                                </a>
                            @else
                                <span class="status-badge locked">
                                    <i class="fas fa-lock"></i> Locked
                                </span>
                            @endif
                        @endauth
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
</div>

            <!-- Right Column - Progress and Start Quiz -->
            <div class="col-lg-4">
                <!-- Progress Card (if attempt in progress OR quiz completed) -->
                @auth
                    @if($attempt || $quizCompleted)
                        <div class="progress-card">
                            <div class="progress-title">
                                <i class="fas fa-chart-line"></i>
                                Your Progress
                            </div>
                            <div class="progress-bar-container">
                                <div class="progress-header">
                                    <span>Overall Completion</span>
                                    <span>{{ $overallProgress }}%</span>
                                </div>
                                <div class="progress-bar-custom">
                                    <div class="progress-fill" style="width: {{ $overallProgress }}%;"></div>
                                </div>
                            </div>
                            @if($attempt)
                                <div class="current-level">
                                    <span>Current Level:</span>
                                    <strong>Level {{ $currentLevel ? $currentLevel->level_number : $attempt->current_level_number }}</strong>
                                </div>
                            @elseif($quizCompleted && $lastCompletedAttempt)
                                <div class="current-level">
                                    <span>Status:</span>
                                    <strong style="color: {{ $lastCompletedAttempt->passed ? '#22c55e' : '#ef4444' }};">
                                        {{ $lastCompletedAttempt->passed ? '✓ Passed' : '✗ Not Passed' }}
                                        ({{ round($lastCompletedAttempt->overall_percentage ?? 0) }}%)
                                    </strong>
                                </div>
                            @endif
                        </div>
                    @endif
                @endauth

                <!-- Start Quiz Card -->
                <div class="start-card">
                    <h4 style="font-size: 1.2rem; font-weight: 600; color: var(--primary); margin-bottom: 20px; text-align: center;">
                        <i class="fas fa-play-circle" style="color: var(--accent); margin-right: 8px;"></i>
                        Ready to Begin?
                    </h4>
                    
                    @auth
                        @if($attempt)
                            <form action="{{ route('progressive-quizzes.continue', $quiz) }}" method="GET">
                                <button type="submit" class="btn-continue">
                                    <i class="fas fa-play-circle"></i>
                                    Continue Level {{ $currentLevel ? $currentLevel->level_number : $attempt->current_level_number }}
                                </button>
                            </form>
                            <small style="color: var(--gray-300); display: block; text-align: center;">
                                You have an ongoing attempt
                            </small>
                        @elseif($quizCompleted)
                            {{-- Quiz is fully completed — show results link and optional re-attempt --}}
                            <a href="{{ route('progressive-quizzes.results', $quiz) }}" class="btn-continue" style="margin-bottom: 12px; background: linear-gradient(135deg, #16a34a, #22c55e);">
                                <i class="fas fa-trophy"></i>
                                View Results
                            </a>
                            @if($canAttempt)
                                <form action="{{ route('progressive-quizzes.restart', $quiz) }}" method="POST" style="margin-top: 8px;">
                                    @csrf
                                    <button type="submit" class="btn-start" style="background: linear-gradient(135deg, var(--primary), var(--dark-slate));">
                                        <i class="fas fa-redo"></i>
                                        <span>Re-attempt Quiz</span>
                                    </button>
                                </form>
                                <small style="color: var(--gray-300); display: block; text-align: center; margin-top: 6px;">
                                    @if($quiz->attempts_allowed == 0)
                                        Unlimited attempts available
                                    @else
                                        @php $usedAttempts = \App\Models\ProgressiveQuizAttempt::where('progressive_quiz_id', $quiz->id)->where('user_id', Auth::id())->where('status','completed')->count(); @endphp
                                        {{ $usedAttempts }} of {{ $quiz->attempts_allowed }} attempts used
                                    @endif
                                </small>
                            @else
                                <small style="color: var(--gray-300); display: block; text-align: center; margin-top: 8px;">
                                    Maximum attempts reached
                                </small>
                            @endif
                        @elseif($canAttempt)
                            <div class="alert-info">
                                <i class="fas fa-info-circle"></i>
                                <span>
                                    @if($quiz->attempts_allowed == 0)
                                        Unlimited attempts available
                                    @else
                                        You have {{ $quiz->attempts_allowed }} attempts total
                                    @endif
                                </span>
                            </div>
                            
                            <form action="{{ route('progressive-quizzes.start', $quiz) }}" method="POST" id="startQuizForm">
                                @csrf
                                <button type="submit" class="btn-start" id="startQuizBtn">
                                    <i class="fas fa-play"></i>
                                    <span>Start Quiz</span>
                                </button>
                            </form>
                            
                            <div class="warnings">
                                @if($quiz->time_limit)
                                    <div class="warning-item">
                                        <i class="fas fa-hourglass-half"></i>
                                        You have {{ $quiz->time_limit }} minutes total across all levels
                                    </div>
                                @endif
                                
                                @if($quiz->shuffle_questions)
                                    <div class="warning-item">
                                        <i class="fas fa-random"></i>
                                        Questions are shuffled
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="alert-warning">
                                <i class="fas fa-exclamation-triangle"></i>
                                <span>You have reached the maximum number of attempts for this quiz.</span>
                            </div>
                        @endif
                    @else
                        <div class="alert-info">
                            <i class="fas fa-lock"></i>
                            <span>Please login to start this quiz</span>
                        </div>
                        
                        <a href="{{ route('login') }}" class="btn-start">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>Login to Start</span>
                        </a>
                        
                        <div class="login-prompt">
                            <p>Don't have an account? <a href="{{ route('register') }}">Register here</a></p>
                        </div>
                    @endauth
                </div>

                <!-- Quiz Rules Card -->
                <div class="accordion-section">
                    <div class="accordion-header" onclick="toggleAccordion(this)">
                        <h4>
                            <i class="fas fa-gavel"></i>
                            Quiz Rules
                        </h4>
                        <i class="fas fa-chevron-up"></i>
                    </div>
                    <div class="accordion-content">
                        <ul class="rules-list">
                            <li>
                                <i class="fas fa-check-circle"></i>
                                Complete each level to unlock the next
                            </li>
                            <li>
                                <i class="fas fa-check-circle"></i>
                                You must pass each level to progress
                            </li>
                            @if($quiz->time_limit)
                            <li>
                                <i class="fas fa-check-circle"></i>
                                Total time limit: {{ $quiz->time_limit }} minutes
                            </li>
                            @endif
                            <li>
                                <i class="fas fa-check-circle"></i>
                                All questions are required
                            </li>
                            <li>
                                <i class="fas fa-check-circle"></i>
                                Passing score: {{ $quiz->pass_percentage }}% overall
                            </li>
                            <li>
                                <i class="fas fa-check-circle"></i>
                                Results shown after each level
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

    // Confirmation before starting quiz
    const startForms = document.querySelectorAll('#startQuizForm, #startQuizFormTop');
    const startBtns = document.querySelectorAll('#startQuizBtn, #startQuizBtnTop');
    
    startForms.forEach((form, index) => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const quizTitle = @json($quiz->title);
            const totalLevels = {{ $quiz->total_levels }};
            const totalQuestions = {{ $totalQuestions }};
            
            const confirmation = confirm(
                `Ready to start "${quizTitle}"?` +
                `\n\n📊 ${totalLevels} Levels` +
                `\n📝 ${totalQuestions} Total Questions` +
                `\n\n⚠️ This will begin Level 1. Complete it to unlock the next level.` +
                `\n\nClick OK to begin your progressive quiz journey!`
            );
            
            if (confirmation) {
                if (startBtns[index]) {
                    startBtns[index].innerHTML = '<span class="btn-spinner"></span> Starting...';
                    startBtns[index].disabled = true;
                }
                this.submit();
            }
        });
    });
});
</script>
@endpush