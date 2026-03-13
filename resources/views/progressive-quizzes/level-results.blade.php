@extends('layouts.main')

@section('title', 'Level ' . $level->level_number . ' Results - ' . $progressiveQuiz->title)

@section('meta_description', 'Results for Level ' . $level->level_number . ' of ' . $progressiveQuiz->title)

@push('styles')
<style>
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
        --success: #22c55e;
        --danger: #ef4444;
        --warning: var(--bright-amber);
        --white: var(--pure-white);
        --shadow-sm: 0 2px 8px rgba(10, 29, 68, 0.08);
        --shadow-md: 0 4px 12px rgba(10, 29, 68, 0.12);
        --shadow-lg: 0 8px 24px rgba(10, 29, 68, 0.15);
        --radius: 12px;
        --radius-lg: 16px;
        --radius-xl: 24px;
        --radius-full: 9999px;
        --transition: all 0.3s ease;
    }

    .results-page {
        background-color: var(--ivory);
        min-height: calc(100vh - 200px);
        padding: 40px 0 60px;
    }

    /* ===== HERO BANNER ===== */
    .results-hero {
        background: linear-gradient(135deg, var(--prussian-blue) 0%, var(--regal-navy) 50%, var(--dark-slate) 100%);
        border-radius: var(--radius-xl);
        padding: 40px;
        margin-bottom: 32px;
        color: var(--white);
        box-shadow: var(--shadow-lg);
        position: relative;
        overflow: hidden;
        text-align: center;
    }

    .results-hero::before {
        content: '';
        position: absolute;
        top: -60px;
        right: -60px;
        width: 280px;
        height: 280px;
        background: rgba(251, 198, 12, 0.08);
        border-radius: 50%;
        pointer-events: none;
    }

    .results-hero::after {
        content: '';
        position: absolute;
        bottom: -60px;
        left: -60px;
        width: 240px;
        height: 240px;
        background: rgba(90, 209, 228, 0.08);
        border-radius: 50%;
        pointer-events: none;
    }

    .hero-icon {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        margin: 0 auto 20px;
        position: relative;
        z-index: 1;
    }

    .hero-icon.passed {
        background: rgba(34, 197, 94, 0.2);
        border: 3px solid rgba(34, 197, 94, 0.5);
        color: #86efac;
    }

    .hero-icon.failed {
        background: rgba(239, 68, 68, 0.2);
        border: 3px solid rgba(239, 68, 68, 0.5);
        color: #fca5a5;
    }

    .hero-badge {
        display: inline-block;
        padding: 5px 16px;
        border-radius: var(--radius-full);
        font-size: 0.8rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        margin-bottom: 14px;
        position: relative;
        z-index: 1;
    }

    .hero-badge.passed {
        background: rgba(34, 197, 94, 0.2);
        border: 1px solid rgba(34, 197, 94, 0.4);
        color: #86efac;
    }

    .hero-badge.failed {
        background: rgba(239, 68, 68, 0.2);
        border: 1px solid rgba(239, 68, 68, 0.4);
        color: #fca5a5;
    }

    .hero-title {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 8px;
        position: relative;
        z-index: 1;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    .hero-subtitle {
        font-size: 1rem;
        opacity: 0.8;
        position: relative;
        z-index: 1;
        margin-bottom: 0;
    }

    /* ===== SCORE RING ===== */
    .score-ring-wrapper {
        position: relative;
        z-index: 1;
        margin: 24px auto 0;
        width: 160px;
        height: 160px;
    }

    .score-ring-svg {
        transform: rotate(-90deg);
        width: 160px;
        height: 160px;
    }

    .score-ring-bg {
        fill: none;
        stroke: rgba(255,255,255,0.15);
        stroke-width: 10;
    }

    .score-ring-fill {
        fill: none;
        stroke-width: 10;
        stroke-linecap: round;
        transition: stroke-dashoffset 1.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .score-ring-fill.passed {
        stroke: #86efac;
    }

    .score-ring-fill.failed {
        stroke: #fca5a5;
    }

    .score-ring-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        color: var(--white);
    }

    .score-ring-pct {
        font-size: 2rem;
        font-weight: 800;
        line-height: 1;
        display: block;
    }

    .score-ring-label {
        font-size: 0.75rem;
        opacity: 0.75;
        display: block;
        margin-top: 2px;
    }

    /* ===== STATS GRID ===== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 28px;
    }

    @media (max-width: 768px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 480px) {
        .stats-grid { grid-template-columns: 1fr 1fr; }
    }

    .stat-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 20px;
        text-align: center;
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(10, 29, 68, 0.06);
        transition: var(--transition);
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: var(--radius);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        margin: 0 auto 12px;
    }

    .stat-icon.blue   { background: rgba(24, 56, 110, 0.1); color: var(--regal-navy); }
    .stat-icon.green  { background: rgba(34, 197, 94, 0.1); color: #16a34a; }
    .stat-icon.red    { background: rgba(239, 68, 68, 0.1); color: #dc2626; }
    .stat-icon.amber  { background: rgba(251, 198, 12, 0.15); color: #b45309; }
    .stat-icon.teal   { background: rgba(90, 209, 228, 0.15); color: var(--dark-slate); }

    .stat-value {
        font-size: 1.7rem;
        font-weight: 800;
        color: var(--prussian-blue);
        line-height: 1;
        margin-bottom: 4px;
    }

    .stat-label {
        font-size: 0.8rem;
        color: var(--khaki-beige);
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    /* ===== ANSWER REVIEW ===== */
    .section-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
    }

    .section-icon {
        width: 40px;
        height: 40px;
        border-radius: var(--radius);
        background: rgba(24, 56, 110, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--regal-navy);
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .section-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--prussian-blue);
        margin: 0;
    }

    .answer-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 22px 24px;
        margin-bottom: 14px;
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(10, 29, 68, 0.06);
        border-left: 4px solid transparent;
        transition: var(--transition);
    }

    .answer-card:hover {
        box-shadow: var(--shadow-md);
    }

    .answer-card.correct {
        border-left-color: #22c55e;
    }

    .answer-card.incorrect {
        border-left-color: #ef4444;
    }

    .answer-card-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 12px;
    }

    .question-num {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--khaki-beige);
        flex-shrink: 0;
        margin-top: 2px;
    }

    .question-text {
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--prussian-blue);
        flex: 1;
        line-height: 1.5;
        margin: 0;
    }

    .result-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 12px;
        border-radius: var(--radius-full);
        font-size: 0.78rem;
        font-weight: 700;
        flex-shrink: 0;
        white-space: nowrap;
    }

    .result-badge.correct {
        background: rgba(34, 197, 94, 0.1);
        color: #16a34a;
        border: 1px solid rgba(34, 197, 94, 0.3);
    }

    .result-badge.incorrect {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .answer-detail {
        display: flex;
        gap: 8px;
        font-size: 0.875rem;
        align-items: baseline;
        padding: 6px 0 0;
    }

    .answer-detail-label {
        font-weight: 600;
        color: var(--khaki-beige);
        white-space: nowrap;
    }

    .answer-detail-value {
        color: var(--prussian-blue);
    }

    .answer-detail-value.correct-ans {
        color: #16a34a;
        font-weight: 600;
    }

    .points-chip {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: rgba(251, 198, 12, 0.12);
        color: #b45309;
        border: 1px solid rgba(251, 198, 12, 0.3);
        padding: 2px 10px;
        border-radius: var(--radius-full);
        font-size: 0.78rem;
        font-weight: 700;
        margin-left: auto;
    }

    .explanation-box {
        margin-top: 10px;
        padding: 10px 14px;
        background: rgba(90, 209, 228, 0.08);
        border-radius: var(--radius);
        border-left: 3px solid var(--sky-blue);
        font-size: 0.85rem;
        color: var(--dark-slate);
        line-height: 1.6;
    }

    .explanation-box strong {
        color: var(--prussian-blue);
    }

    /* ===== ACTION PANEL ===== */
    .action-panel {
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 28px;
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(10, 29, 68, 0.06);
        margin-bottom: 28px;
    }

    .action-panel-title {
        font-size: 1rem;
        font-weight: 700;
        color: var(--prussian-blue);
        margin-bottom: 18px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary-custom {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, var(--prussian-blue), var(--regal-navy));
        color: var(--white);
        padding: 12px 24px;
        border-radius: var(--radius-full);
        font-weight: 700;
        font-size: 0.95rem;
        text-decoration: none;
        transition: var(--transition);
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(10, 29, 68, 0.3);
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(10, 29, 68, 0.4);
        color: var(--white);
        text-decoration: none;
    }

    .btn-accent-custom {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, var(--bright-amber), var(--light-gold));
        color: var(--prussian-blue);
        padding: 12px 24px;
        border-radius: var(--radius-full);
        font-weight: 700;
        font-size: 0.95rem;
        text-decoration: none;
        transition: var(--transition);
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(251, 198, 12, 0.3);
    }

    .btn-accent-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(251, 198, 12, 0.4);
        color: var(--prussian-blue);
        text-decoration: none;
    }

    .btn-outline-custom {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: transparent;
        color: var(--prussian-blue);
        padding: 11px 22px;
        border-radius: var(--radius-full);
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        transition: var(--transition);
        border: 2px solid rgba(10, 29, 68, 0.2);
    }

    .btn-outline-custom:hover {
        background: rgba(10, 29, 68, 0.06);
        border-color: rgba(10, 29, 68, 0.35);
        color: var(--prussian-blue);
        text-decoration: none;
        transform: translateY(-1px);
    }

    .action-buttons {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    /* ===== NEXT LEVEL CARD ===== */
    .next-level-card {
        background: linear-gradient(135deg, rgba(24,56,110,0.05), rgba(46,92,97,0.05));
        border: 1px solid rgba(24, 56, 110, 0.12);
        border-radius: var(--radius-lg);
        padding: 22px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        transition: var(--transition);
    }

    .next-level-card:hover {
        box-shadow: var(--shadow-md);
        border-color: rgba(24, 56, 110, 0.25);
    }

    .next-level-info {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .next-level-icon {
        width: 52px;
        height: 52px;
        background: linear-gradient(135deg, var(--prussian-blue), var(--regal-navy));
        border-radius: var(--radius);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        color: var(--bright-amber);
        flex-shrink: 0;
    }

    .next-level-label {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--khaki-beige);
        margin-bottom: 4px;
    }

    .next-level-name {
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--prussian-blue);
        margin: 0;
    }

    .next-level-meta {
        font-size: 0.82rem;
        color: var(--khaki-beige);
        margin-top: 3px;
    }

    /* ===== FAILED STATE ===== */
    .retry-card {
        background: rgba(239, 68, 68, 0.05);
        border: 1px solid rgba(239, 68, 68, 0.15);
        border-radius: var(--radius-lg);
        padding: 22px 24px;
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .retry-card-icon {
        width: 52px;
        height: 52px;
        background: rgba(239, 68, 68, 0.1);
        border-radius: var(--radius);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        color: #ef4444;
        flex-shrink: 0;
    }

    .retry-card-text h5 {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--prussian-blue);
        margin-bottom: 4px;
    }

    .retry-card-text p {
        font-size: 0.85rem;
        color: var(--khaki-beige);
        margin: 0;
    }

    /* ===== BREADCRUMB ===== */
    .breadcrumb-nav {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.85rem;
        color: var(--khaki-beige);
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .breadcrumb-nav a {
        color: var(--regal-navy);
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s;
    }

    .breadcrumb-nav a:hover { color: var(--prussian-blue); text-decoration: underline; }
    .breadcrumb-nav .separator { opacity: 0.5; }
    .breadcrumb-nav .current { color: var(--prussian-blue); font-weight: 600; }

    /* ===== PROGRESS BAR ===== */
    .mini-progress {
        height: 8px;
        background: rgba(10, 29, 68, 0.08);
        border-radius: var(--radius-full);
        overflow: hidden;
        margin-top: 8px;
    }

    .mini-progress-fill {
        height: 100%;
        border-radius: var(--radius-full);
        transition: width 1s ease;
    }

    .mini-progress-fill.passed { background: linear-gradient(90deg, #22c55e, #86efac); }
    .mini-progress-fill.failed { background: linear-gradient(90deg, #ef4444, #fca5a5); }

    /* ===== ANIMATIONS ===== */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .fade-in-up {
        animation: fadeInUp 0.5s ease forwards;
    }

    .fade-in-up:nth-child(1) { animation-delay: 0.05s; }
    .fade-in-up:nth-child(2) { animation-delay: 0.1s; }
    .fade-in-up:nth-child(3) { animation-delay: 0.15s; }
    .fade-in-up:nth-child(4) { animation-delay: 0.2s; }

    @keyframes confettiFall {
        0%   { transform: translateY(-20px) rotate(0deg); opacity: 1; }
        100% { transform: translateY(60px) rotate(360deg); opacity: 0; }
    }

    .confetti-dot {
        position: absolute;
        width: 8px;
        height: 8px;
        border-radius: 2px;
        animation: confettiFall 2s ease-in forwards;
    }
</style>
@endpush

@section('content')
@php
    $passed       = $levelAttempt->passed;
    $percentage   = round($levelAttempt->percentage ?? 0);
    $minPct       = $level->getRawOriginal('min_percentage') ?? ($progressiveQuiz->pass_percentage ?? 0);
    $timeTaken    = $levelAttempt->time_taken_formatted ?? 'N/A';
    $circumference = 2 * M_PI * 65; // radius=65
    $offset       = $circumference - ($percentage / 100) * $circumference;
@endphp

<div class="results-page">
    <div class="container">

        {{-- BREADCRUMB --}}
        <nav class="breadcrumb-nav">
            <a href="{{ route('progressive-quizzes.index') }}">Progressive Quizzes</a>
            <span class="separator"><i class="fas fa-chevron-right" style="font-size:0.65rem;"></i></span>
            <a href="{{ route('progressive-quizzes.show', $progressiveQuiz->slug) }}">{{ $progressiveQuiz->title }}</a>
            <span class="separator"><i class="fas fa-chevron-right" style="font-size:0.65rem;"></i></span>
            <span class="current">Level {{ $level->level_number }} Results</span>
        </nav>

        {{-- HERO RESULTS BANNER --}}
        <div class="results-hero fade-in-up">

            {{-- Confetti dots for passed --}}
            @if($passed)
                <div class="confetti-dot" style="top:10%;left:15%;background:#FBC60C;animation-delay:0.1s;"></div>
                <div class="confetti-dot" style="top:20%;left:80%;background:#5AD1E4;animation-delay:0.3s;"></div>
                <div class="confetti-dot" style="top:5%;left:50%;background:#86efac;animation-delay:0.5s;"></div>
                <div class="confetti-dot" style="top:15%;left:35%;background:#FBC60C;animation-delay:0.7s;"></div>
                <div class="confetti-dot" style="top:25%;left:65%;background:#fca5a5;animation-delay:0.2s;"></div>
            @endif

            <div class="hero-icon {{ $passed ? 'passed' : 'failed' }}">
                <i class="fas fa-{{ $passed ? 'trophy' : 'redo' }}"></i>
            </div>

            <div class="hero-badge {{ $passed ? 'passed' : 'failed' }}">
                {{ $passed ? '✓ Level Passed' : '✗ Level Not Passed' }}
            </div>

            <h1 class="hero-title">Level {{ $level->level_number }}: {{ $level->title }}</h1>
            <p class="hero-subtitle">
                @if($passed)
                    Great work! You scored {{ $percentage }}% and cleared the {{ $minPct }}% pass mark.
                @else
                    You scored {{ $percentage }}%. You need {{ $minPct }}% to pass this level.
                @endif
            </p>

            {{-- Score Ring --}}
            <div class="score-ring-wrapper">
                <svg class="score-ring-svg" viewBox="0 0 160 160">
                    <circle class="score-ring-bg" cx="80" cy="80" r="65"/>
                    <circle
                        class="score-ring-fill {{ $passed ? 'passed' : 'failed' }}"
                        cx="80" cy="80" r="65"
                        stroke-dasharray="{{ $circumference }}"
                        stroke-dashoffset="{{ $circumference }}"
                        id="scoreRingCircle"
                    />
                </svg>
                <div class="score-ring-text">
                    <span class="score-ring-pct" id="scoreRingPct">0%</span>
                    <span class="score-ring-label">Score</span>
                </div>
            </div>

            {{-- Mini progress bar below ring --}}
            <div style="max-width:220px;margin:16px auto 0;position:relative;z-index:1;">
                <div style="display:flex;justify-content:space-between;font-size:0.75rem;opacity:0.75;margin-bottom:4px;">
                    <span>0%</span>
                    <span>Pass: {{ $minPct }}%</span>
                    <span>100%</span>
                </div>
                <div class="mini-progress">
                    <div class="mini-progress-fill {{ $passed ? 'passed' : 'failed' }}" id="miniProgressFill" style="width:0%"></div>
                </div>
            </div>
        </div>

        {{-- STATS GRID --}}
        <div class="stats-grid">
            <div class="stat-card fade-in-up">
                <div class="stat-icon blue"><i class="fas fa-question-circle"></i></div>
                <div class="stat-value">{{ $totalQuestions }}</div>
                <div class="stat-label">Questions</div>
            </div>
            <div class="stat-card fade-in-up">
                <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
                <div class="stat-value">{{ $correctAnswers }}</div>
                <div class="stat-label">Correct</div>
            </div>
            <div class="stat-card fade-in-up">
                <div class="stat-icon red"><i class="fas fa-times-circle"></i></div>
                <div class="stat-value">{{ $totalQuestions - $correctAnswers }}</div>
                <div class="stat-label">Incorrect</div>
            </div>
            <div class="stat-card fade-in-up">
                <div class="stat-icon amber"><i class="fas fa-star"></i></div>
                <div class="stat-value">{{ $earnedPoints }}<span style="font-size:1rem;font-weight:500;color:var(--khaki-beige);">/{{ $totalPoints }}</span></div>
                <div class="stat-label">Points</div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">

                {{-- ACTIONS --}}
                <div class="action-panel fade-in-up">
                    <div class="action-panel-title">
                        <i class="fas fa-compass"></i> What's Next?
                    </div>

                    @if($passed && $nextLevel)
                        {{-- Passed & next level exists --}}
                        <div class="next-level-card mb-4">
                            <div class="next-level-info">
                                <div class="next-level-icon">
                                    <i class="fas fa-unlock-alt"></i>
                                </div>
                                <div>
                                    <div class="next-level-label">Unlocked</div>
                                    <div class="next-level-name">Level {{ $nextLevel->level_number }}: {{ $nextLevel->title }}</div>
                                    <div class="next-level-meta">
                                        {{ $nextLevel->question_count }} questions
                                        @if($nextLevel->getRawOriginal('min_percentage'))
                                            &bull; {{ $nextLevel->getRawOriginal('min_percentage') }}% to pass
                                        @endif
                                        @if($nextLevel->time_limit)
                                            &bull; {{ $nextLevel->time_limit }} min
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('progressive-quizzes.take', ['progressiveQuiz' => $progressiveQuiz->id, 'level' => $nextLevel->id]) }}"
                               class="btn-accent-custom">
                                <i class="fas fa-play"></i> Start Level {{ $nextLevel->level_number }}
                            </a>
                        </div>

                        <div class="action-buttons">
                            <a href="{{ route('progressive-quizzes.show', $progressiveQuiz->slug) }}" class="btn-outline-custom">
                                <i class="fas fa-list"></i> Quiz Overview
                            </a>
                        </div>

                    @elseif($passed && !$nextLevel)
                        {{-- Passed final level --}}
                        <div class="next-level-card mb-4" style="background:rgba(34,197,94,0.04);border-color:rgba(34,197,94,0.2);">
                            <div class="next-level-info">
                                <div class="next-level-icon" style="background:linear-gradient(135deg,#16a34a,#22c55e);">
                                    <i class="fas fa-medal"></i>
                                </div>
                                <div>
                                    <div class="next-level-label" style="color:#16a34a;">All Levels Complete!</div>
                                    <div class="next-level-name">You've finished the entire quiz</div>
                                    <div class="next-level-meta">View your overall score and results</div>
                                </div>
                            </div>
                            <a href="{{ route('progressive-quizzes.results', $progressiveQuiz) }}" class="btn-accent-custom">
                                <i class="fas fa-trophy"></i> Final Results
                            </a>
                        </div>

                        <div class="action-buttons">
                            <a href="{{ route('progressive-quizzes.show', $progressiveQuiz->slug) }}" class="btn-outline-custom">
                                <i class="fas fa-list"></i> Quiz Overview
                            </a>
                        </div>

                    @else
                        {{-- Failed --}}
                        <div class="retry-card mb-4">
                            <div class="retry-card-icon"><i class="fas fa-exclamation-triangle"></i></div>
                            <div class="retry-card-text">
                                <h5>You didn't reach the pass mark</h5>
                                <p>You need {{ $minPct }}% to unlock the next level. Review the answers below and try again.</p>
                            </div>
                        </div>

                        <div class="action-buttons">
                            <a href="{{ route('progressive-quizzes.show', $progressiveQuiz->slug) }}" class="btn-primary-custom">
                                <i class="fas fa-redo"></i> Try Again
                            </a>
                            <a href="{{ route('progressive-quizzes.show', $progressiveQuiz->slug) }}" class="btn-outline-custom">
                                <i class="fas fa-list"></i> Quiz Overview
                            </a>
                        </div>
                    @endif
                </div>

                {{-- ANSWER REVIEW --}}
                @if($progressiveQuiz->show_answers)
                <div class="fade-in-up">
                    <div class="section-header">
                        <div class="section-icon"><i class="fas fa-list-check"></i></div>
                        <h2 class="section-title">Answer Review</h2>
                    </div>

                    @forelse($answers as $index => $answer)
                        @php $q = $answer->question; @endphp
                        <div class="answer-card {{ $answer->is_correct ? 'correct' : 'incorrect' }}">
                            <div class="answer-card-header">
                                <span class="question-num">Q{{ $index + 1 }}</span>
                                <p class="question-text">{{ $q->question_text ?? 'Question not found' }}</p>
                                <span class="result-badge {{ $answer->is_correct ? 'correct' : 'incorrect' }}">
                                    <i class="fas fa-{{ $answer->is_correct ? 'check' : 'times' }}"></i>
                                    {{ $answer->is_correct ? 'Correct' : 'Incorrect' }}
                                </span>
                            </div>

                            <div style="display:flex;flex-wrap:wrap;gap:6px 0;padding-left:36px;">
                                @if($answer->answer_text)
                                    <div class="answer-detail" style="width:100%;">
                                        <span class="answer-detail-label">Your answer:</span>
                                        <span class="answer-detail-value">{{ $answer->answer_text }}</span>
                                        <span class="points-chip">
                                            <i class="fas fa-star" style="font-size:0.65rem;"></i>
                                            {{ $answer->points_earned }}/{{ $q->points ?? 0 }} pts
                                        </span>
                                    </div>
                                @endif

                                @if(!$answer->is_correct && $q)
                                    @php
                                        $correctText = null;
                                        if (in_array($q->question_type, ['single_choice','true_false','multiple_choice','image_selection'])) {
                                            $correctOptions = $q->options->where('is_correct', true);
                                            $correctText = $correctOptions->pluck('option_text')->implode(', ');
                                        } elseif ($q->question_type === 'fill_blank') {
                                            $correctText = $q->fillBlanks->pluck('correct_answer')->implode(' / ');
                                        }
                                    @endphp
                                    @if($correctText)
                                        <div class="answer-detail" style="width:100%;">
                                            <span class="answer-detail-label">Correct answer:</span>
                                            <span class="answer-detail-value correct-ans">{{ $correctText }}</span>
                                        </div>
                                    @endif
                                @endif
                            </div>

                            @if($q && $q->explanation && $progressiveQuiz->show_results)
                                <div class="explanation-box" style="margin-left:36px;margin-top:10px;">
                                    <strong><i class="fas fa-lightbulb" style="color:var(--bright-amber);margin-right:6px;"></i>Explanation:</strong>
                                    {{ $q->explanation }}
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="answer-card" style="text-align:center;color:var(--khaki-beige);padding:32px;">
                            <i class="fas fa-inbox" style="font-size:2rem;margin-bottom:10px;display:block;"></i>
                            No answer records found for this level attempt.
                        </div>
                    @endforelse
                </div>
                @else
                    <div class="action-panel fade-in-up" style="text-align:center;color:var(--khaki-beige);">
                        <i class="fas fa-eye-slash" style="font-size:2rem;margin-bottom:10px;display:block;"></i>
                        <p style="margin:0;font-size:0.9rem;">Answer review is not enabled for this quiz.</p>
                    </div>
                @endif

            </div>

            {{-- SIDEBAR --}}
            <div class="col-lg-4">

                {{-- Level Summary --}}
                <div class="action-panel fade-in-up" style="margin-bottom:20px;">
                    <div class="action-panel-title">
                        <i class="fas fa-layer-group"></i> Level Summary
                    </div>
                    <div style="display:flex;flex-direction:column;gap:12px;">
                        <div style="display:flex;justify-content:space-between;align-items:center;font-size:0.9rem;">
                            <span style="color:var(--khaki-beige);font-weight:500;">Level</span>
                            <span style="font-weight:700;color:var(--prussian-blue);">{{ $level->level_number }} — {{ $level->title }}</span>
                        </div>
                        <div style="height:1px;background:rgba(10,29,68,0.06);"></div>
                        <div style="display:flex;justify-content:space-between;align-items:center;font-size:0.9rem;">
                            <span style="color:var(--khaki-beige);font-weight:500;">Questions</span>
                            <span style="font-weight:700;color:var(--prussian-blue);">{{ $totalQuestions }}</span>
                        </div>
                        <div style="display:flex;justify-content:space-between;align-items:center;font-size:0.9rem;">
                            <span style="color:var(--khaki-beige);font-weight:500;">Score</span>
                            <span style="font-weight:700;color:var(--prussian-blue);">{{ $earnedPoints }} / {{ $totalPoints }} pts</span>
                        </div>
                        <div style="display:flex;justify-content:space-between;align-items:center;font-size:0.9rem;">
                            <span style="color:var(--khaki-beige);font-weight:500;">Accuracy</span>
                            <span style="font-weight:700;color:var(--prussian-blue);">{{ $percentage }}%</span>
                        </div>
                        <div style="display:flex;justify-content:space-between;align-items:center;font-size:0.9rem;">
                            <span style="color:var(--khaki-beige);font-weight:500;">Pass mark</span>
                            <span style="font-weight:700;color:var(--prussian-blue);">{{ $minPct }}%</span>
                        </div>
                        <div style="display:flex;justify-content:space-between;align-items:center;font-size:0.9rem;">
                            <span style="color:var(--khaki-beige);font-weight:500;">Time taken</span>
                            <span style="font-weight:700;color:var(--prussian-blue);">{{ $timeTaken }}</span>
                        </div>
                        <div style="display:flex;justify-content:space-between;align-items:center;font-size:0.9rem;">
                            <span style="color:var(--khaki-beige);font-weight:500;">Status</span>
                            <span class="result-badge {{ $passed ? 'correct' : 'incorrect' }}">
                                <i class="fas fa-{{ $passed ? 'check' : 'times' }}"></i>
                                {{ $passed ? 'Passed' : 'Failed' }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Quiz Levels Overview --}}
                <div class="action-panel fade-in-up">
                    <div class="action-panel-title">
                        <i class="fas fa-map-signs"></i> All Levels
                    </div>
                    @php
                        $allLevels = $progressiveQuiz->levels;
                        $user = Auth::user();
                        // Build completion map from DB
                        $completedLevelIds = \App\Models\ProgressiveLevelAttempt::whereHas('quizAttempt', function($q) use ($progressiveQuiz, $user) {
                            $q->where('progressive_quiz_id', $progressiveQuiz->id)
                              ->where('user_id', $user->id);
                        })->where('status', 'completed')->where('passed', true)
                          ->pluck('progressive_level_id')->toArray();
                    @endphp
                    <div style="display:flex;flex-direction:column;gap:10px;">
                        @foreach($allLevels as $lvl)
                            @php
                                $isCurrentLevel = $lvl->id === $level->id;
                                $isCompleted    = in_array($lvl->id, $completedLevelIds);
                                $isUnlocked     = $lvl->level_number === 1 || in_array($progressiveQuiz->getLevelByNumber($lvl->level_number - 1)?->id, $completedLevelIds);
                            @endphp
                            <div style="display:flex;align-items:center;gap:12px;padding:10px 12px;border-radius:var(--radius);
                                        background:{{ $isCurrentLevel ? 'rgba(24,56,110,0.07)' : 'transparent' }};
                                        border:1px solid {{ $isCurrentLevel ? 'rgba(24,56,110,0.15)' : 'transparent' }};">
                                <div style="width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:0.85rem;font-weight:700;flex-shrink:0;
                                    background:{{ $isCompleted ? 'rgba(34,197,94,0.15)' : ($isCurrentLevel ? 'rgba(24,56,110,0.15)' : 'rgba(10,29,68,0.06)') }};
                                    color:{{ $isCompleted ? '#16a34a' : ($isCurrentLevel ? 'var(--prussian-blue)' : 'var(--khaki-beige)') }};">
                                    @if($isCompleted) <i class="fas fa-check"></i>
                                    @elseif(!$isUnlocked) <i class="fas fa-lock" style="font-size:0.7rem;"></i>
                                    @else {{ $lvl->level_number }} @endif
                                </div>
                                <div style="flex:1;min-width:0;">
                                    <div style="font-size:0.85rem;font-weight:{{ $isCurrentLevel ? '700' : '600' }};color:{{ $isCurrentLevel ? 'var(--prussian-blue)' : ($isUnlocked ? 'var(--prussian-blue)' : 'var(--khaki-beige)') }};white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                        {{ $lvl->title }}
                                    </div>
                                    <div style="font-size:0.75rem;color:var(--khaki-beige);">{{ $lvl->question_count }} questions</div>
                                </div>
                                @if($isCurrentLevel)
                                    <span style="font-size:0.7rem;font-weight:700;color:var(--regal-navy);background:rgba(24,56,110,0.1);padding:2px 8px;border-radius:var(--radius-full);">Current</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const targetPct  = {{ $percentage }};
    const circumference = {{ round($circumference, 4) }};
    const circle     = document.getElementById('scoreRingCircle');
    const pctText    = document.getElementById('scoreRingPct');
    const progressFill = document.getElementById('miniProgressFill');

    // Animate score ring
    if (circle) {
        const offset = circumference - (targetPct / 100) * circumference;
        setTimeout(() => {
            circle.style.strokeDashoffset = offset;
        }, 300);
    }

    // Animate mini progress bar
    if (progressFill) {
        setTimeout(() => {
            progressFill.style.width = targetPct + '%';
        }, 300);
    }

    // Animate counter
    if (pctText) {
        let current = 0;
        const step  = Math.max(1, Math.floor(targetPct / 60));
        const timer = setInterval(() => {
            current = Math.min(current + step, targetPct);
            pctText.textContent = current + '%';
            if (current >= targetPct) clearInterval(timer);
        }, 20);
    }
});
</script>
@endpush
@endsection