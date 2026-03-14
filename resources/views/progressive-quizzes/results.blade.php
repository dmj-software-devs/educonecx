@extends('layouts.main')

@section('title', $progressiveQuiz->title . ' — Final Results')

@section('meta_description', 'Final results for ' . $progressiveQuiz->title)

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
    .breadcrumb-nav a { color: var(--regal-navy); text-decoration: none; font-weight: 500; transition: color 0.2s; }
    .breadcrumb-nav a:hover { color: var(--prussian-blue); text-decoration: underline; }
    .breadcrumb-nav .separator { opacity: 0.5; }
    .breadcrumb-nav .current { color: var(--prussian-blue); font-weight: 600; }

    /* ===== HERO ===== */
    .results-hero {
        background: linear-gradient(135deg, var(--prussian-blue) 0%, var(--regal-navy) 50%, var(--dark-slate) 100%);
        border-radius: var(--radius-xl);
        padding: 48px 40px;
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
        top: -80px; right: -80px;
        width: 320px; height: 320px;
        background: rgba(251, 198, 12, 0.07);
        border-radius: 50%;
        pointer-events: none;
    }

    .results-hero::after {
        content: '';
        position: absolute;
        bottom: -80px; left: -80px;
        width: 280px; height: 280px;
        background: rgba(90, 209, 228, 0.07);
        border-radius: 50%;
        pointer-events: none;
    }

    .hero-trophy {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.8rem;
        margin: 0 auto 20px;
        position: relative;
        z-index: 1;
    }

    .hero-trophy.passed {
        background: rgba(251, 198, 12, 0.2);
        border: 3px solid rgba(251, 198, 12, 0.5);
        color: var(--bright-amber);
    }

    .hero-trophy.failed {
        background: rgba(239, 68, 68, 0.2);
        border: 3px solid rgba(239, 68, 68, 0.4);
        color: #fca5a5;
    }

    .hero-status-badge {
        display: inline-block;
        padding: 5px 18px;
        border-radius: var(--radius-full);
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        margin-bottom: 14px;
        position: relative;
        z-index: 1;
    }

    .hero-status-badge.passed {
        background: rgba(34, 197, 94, 0.2);
        border: 1px solid rgba(34, 197, 94, 0.4);
        color: #86efac;
    }

    .hero-status-badge.failed {
        background: rgba(239, 68, 68, 0.2);
        border: 1px solid rgba(239, 68, 68, 0.4);
        color: #fca5a5;
    }

    .hero-title {
        font-size: 2.2rem;
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

    /* Score ring */
    .score-ring-wrapper {
        position: relative;
        z-index: 1;
        margin: 28px auto 0;
        width: 170px;
        height: 170px;
    }

    .score-ring-svg {
        transform: rotate(-90deg);
        width: 170px;
        height: 170px;
    }

    .score-ring-bg {
        fill: none;
        stroke: rgba(255,255,255,0.12);
        stroke-width: 12;
    }

    .score-ring-fill {
        fill: none;
        stroke-width: 12;
        stroke-linecap: round;
        transition: stroke-dashoffset 1.6s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .score-ring-fill.passed { stroke: var(--bright-amber); }
    .score-ring-fill.failed { stroke: #fca5a5; }

    .score-ring-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        color: var(--white);
    }

    .score-ring-pct {
        font-size: 2.2rem;
        font-weight: 800;
        line-height: 1;
        display: block;
    }

    .score-ring-label {
        font-size: 0.72rem;
        opacity: 0.7;
        display: block;
        margin-top: 3px;
        letter-spacing: 0.04em;
        text-transform: uppercase;
    }

    /* ===== STATS GRID ===== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 28px;
    }

    @media (max-width: 768px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }

    .stat-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 22px 16px;
        text-align: center;
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(10, 29, 68, 0.06);
        transition: var(--transition);
    }

    .stat-card:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: var(--radius);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        margin: 0 auto 12px;
    }

    .stat-icon.blue   { background: rgba(24,56,110,0.1);  color: var(--regal-navy); }
    .stat-icon.green  { background: rgba(34,197,94,0.1);  color: #16a34a; }
    .stat-icon.amber  { background: rgba(251,198,12,0.15); color: #b45309; }
    .stat-icon.teal   { background: rgba(90,209,228,0.15); color: var(--dark-slate); }
    .stat-icon.navy   { background: rgba(10,29,68,0.08);  color: var(--prussian-blue); }

    .stat-value {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--prussian-blue);
        line-height: 1;
        margin-bottom: 4px;
    }

    .stat-label {
        font-size: 0.78rem;
        color: var(--khaki-beige);
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    /* ===== PANEL ===== */
    .panel {
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 26px;
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(10, 29, 68, 0.06);
        margin-bottom: 24px;
    }

    .panel-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--prussian-blue);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .panel-title-icon {
        width: 36px;
        height: 36px;
        border-radius: var(--radius);
        background: rgba(24,56,110,0.08);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--regal-navy);
        font-size: 1rem;
        flex-shrink: 0;
    }

    /* ===== LEVEL BREAKDOWN CARDS ===== */
    .level-breakdown-card {
        border: 1px solid rgba(10,29,68,0.08);
        border-radius: var(--radius-lg);
        padding: 20px 22px;
        margin-bottom: 14px;
        border-left: 4px solid transparent;
        transition: var(--transition);
    }

    .level-breakdown-card:hover { box-shadow: var(--shadow-md); }
    .level-breakdown-card.passed { border-left-color: var(--success); }
    .level-breakdown-card.failed { border-left-color: var(--danger); }

    .level-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 14px;
    }

    .level-card-info {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .level-num-badge {
        width: 44px;
        height: 44px;
        border-radius: var(--radius);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        font-weight: 800;
        flex-shrink: 0;
    }

    .level-num-badge.passed { background: rgba(34,197,94,0.12); color: #16a34a; }
    .level-num-badge.failed { background: rgba(239,68,68,0.1);  color: #dc2626; }

    .level-card-name {
        font-size: 1rem;
        font-weight: 700;
        color: var(--prussian-blue);
        margin: 0 0 3px;
    }

    .level-card-meta {
        font-size: 0.82rem;
        color: var(--khaki-beige);
    }

    .result-chip {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 14px;
        border-radius: var(--radius-full);
        font-size: 0.8rem;
        font-weight: 700;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .result-chip.passed { background: rgba(34,197,94,0.1); color: #16a34a; border: 1px solid rgba(34,197,94,0.3); }
    .result-chip.failed { background: rgba(239,68,68,0.1);  color: #dc2626; border: 1px solid rgba(239,68,68,0.3); }

    .level-progress-bar {
        height: 6px;
        background: rgba(10,29,68,0.07);
        border-radius: var(--radius-full);
        overflow: hidden;
    }

    .level-progress-fill {
        height: 100%;
        border-radius: var(--radius-full);
        transition: width 1.2s ease;
    }

    .level-progress-fill.passed { background: linear-gradient(90deg, #22c55e, #86efac); }
    .level-progress-fill.failed { background: linear-gradient(90deg, #ef4444, #fca5a5); }

    .level-stats-row {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        margin-top: 10px;
    }

    .level-stat-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.82rem;
    }

    .level-stat-item i { font-size: 0.75rem; }
    .level-stat-item .val { font-weight: 700; color: var(--prussian-blue); }
    .level-stat-item .lbl { color: var(--khaki-beige); }

    /* ===== OVERALL SCORE BAR ===== */
    .overall-score-bar {
        height: 12px;
        background: rgba(10,29,68,0.07);
        border-radius: var(--radius-full);
        overflow: hidden;
        margin: 10px 0 6px;
    }

    .overall-score-fill {
        height: 100%;
        border-radius: var(--radius-full);
        transition: width 1.4s ease;
    }

    .overall-score-fill.passed { background: linear-gradient(90deg, var(--bright-amber), var(--light-gold)); }
    .overall-score-fill.failed { background: linear-gradient(90deg, #ef4444, #fca5a5); }

    /* ===== BUTTONS ===== */
    .btn-primary-custom {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, var(--prussian-blue), var(--regal-navy));
        color: var(--white);
        padding: 13px 26px;
        border-radius: var(--radius-full);
        font-weight: 700;
        font-size: 0.95rem;
        text-decoration: none;
        transition: var(--transition);
        box-shadow: 0 4px 12px rgba(10,29,68,0.3);
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(10,29,68,0.4);
        color: var(--white);
        text-decoration: none;
    }

    .btn-accent-custom {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, var(--bright-amber), var(--light-gold));
        color: var(--prussian-blue);
        padding: 13px 26px;
        border-radius: var(--radius-full);
        font-weight: 700;
        font-size: 0.95rem;
        text-decoration: none;
        transition: var(--transition);
        box-shadow: 0 4px 12px rgba(251,198,12,0.3);
    }

    .btn-accent-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(251,198,12,0.4);
        color: var(--prussian-blue);
        text-decoration: none;
    }

    .btn-outline-custom {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: transparent;
        color: var(--prussian-blue);
        padding: 12px 22px;
        border-radius: var(--radius-full);
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        transition: var(--transition);
        border: 2px solid rgba(10,29,68,0.2);
    }

    .btn-outline-custom:hover {
        background: rgba(10,29,68,0.05);
        border-color: rgba(10,29,68,0.35);
        color: var(--prussian-blue);
        text-decoration: none;
        transform: translateY(-1px);
    }

    .action-buttons { display: flex; gap: 12px; flex-wrap: wrap; }

    /* ===== SIDEBAR SUMMARY ROW ===== */
    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.88rem;
        padding: 8px 0;
        border-bottom: 1px solid rgba(10,29,68,0.05);
    }

    .summary-row:last-child { border-bottom: none; }
    .summary-row .lbl { color: var(--khaki-beige); font-weight: 500; }
    .summary-row .val { font-weight: 700; color: var(--prussian-blue); }

    /* ===== CONFETTI ===== */
    @keyframes confettiFall {
        0%   { transform: translateY(-20px) rotate(0deg); opacity: 1; }
        100% { transform: translateY(70px) rotate(420deg); opacity: 0; }
    }

    .confetti-dot {
        position: absolute;
        width: 9px;
        height: 9px;
        border-radius: 2px;
        animation: confettiFall 2.2s ease-in forwards;
    }

    /* ===== FADE IN ===== */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .fade-in-up { animation: fadeInUp 0.5s ease forwards; opacity: 0; }
    .fade-in-up:nth-child(1) { animation-delay: 0.05s; }
    .fade-in-up:nth-child(2) { animation-delay: 0.1s;  }
    .fade-in-up:nth-child(3) { animation-delay: 0.15s; }
    .fade-in-up:nth-child(4) { animation-delay: 0.2s;  }
</style>
@endpush

@section('content')
@php
    $overallPct    = round($attempt->overall_percentage ?? 0);
    $totalLevels   = count($levelStats);
    $passedLevels  = collect($levelStats)->where('passed', true)->count();
    $totalCorrect  = collect($levelStats)->sum('correct');
    $timeTaken     = $attempt->time_taken_formatted ?? 'N/A';
    $circumference = 2 * M_PI * 70;
    $offset        = $circumference - ($overallPct / 100) * $circumference;
    $minPct        = $progressiveQuiz->pass_percentage ?? 0;
@endphp

<div class="results-page">
    <div class="container">

        {{-- BREADCRUMB --}}
        <nav class="breadcrumb-nav">
            <a href="{{ route('progressive-quizzes.index') }}">Progressive Quizzes</a>
            <span class="separator"><i class="fas fa-chevron-right" style="font-size:0.65rem;"></i></span>
            <a href="{{ route('progressive-quizzes.show', $progressiveQuiz->slug) }}">{{ $progressiveQuiz->title }}</a>
            <span class="separator"><i class="fas fa-chevron-right" style="font-size:0.65rem;"></i></span>
            <span class="current">Final Results</span>
        </nav>

        {{-- HERO --}}
        <div class="results-hero fade-in-up">

            @if($passed)
                <div class="confetti-dot" style="top:8%;left:12%;background:#FBC60C;animation-delay:0.1s;"></div>
                <div class="confetti-dot" style="top:15%;left:78%;background:#5AD1E4;animation-delay:0.35s;"></div>
                <div class="confetti-dot" style="top:5%;left:48%;background:#86efac;animation-delay:0.55s;"></div>
                <div class="confetti-dot" style="top:20%;left:30%;background:#FBC60C;animation-delay:0.75s;"></div>
                <div class="confetti-dot" style="top:10%;left:62%;background:#fca5a5;animation-delay:0.2s;"></div>
                <div class="confetti-dot" style="top:25%;left:88%;background:#EBD789;animation-delay:0.45s;"></div>
            @endif

            <div class="hero-trophy {{ $passed ? 'passed' : 'failed' }}">
                <i class="fas fa-{{ $passed ? 'trophy' : 'redo' }}"></i>
            </div>

            <div class="hero-status-badge {{ $passed ? 'passed' : 'failed' }}">
                {{ $passed ? '🏆 Quiz Completed — Passed!' : '✗ Quiz Completed — Not Passed' }}
            </div>

            <h1 class="hero-title">{{ $progressiveQuiz->title }}</h1>
            <p class="hero-subtitle">
                @if($passed)
                    Congratulations! You passed with {{ $overallPct }}% — above the {{ $minPct }}% requirement.
                @else
                    You scored {{ $overallPct }}%. The pass mark is {{ $minPct }}%. Keep practising!
                @endif
            </p>

            {{-- Score ring --}}
            <div class="score-ring-wrapper">
                <svg class="score-ring-svg" viewBox="0 0 170 170">
                    <circle class="score-ring-bg"   cx="85" cy="85" r="70"/>
                    <circle class="score-ring-fill {{ $passed ? 'passed' : 'failed' }}"
                            cx="85" cy="85" r="70"
                            stroke-dasharray="{{ round($circumference, 4) }}"
                            stroke-dashoffset="{{ round($circumference, 4) }}"
                            id="scoreRingCircle"/>
                </svg>
                <div class="score-ring-text">
                    <span class="score-ring-pct" id="scoreRingPct">0%</span>
                    <span class="score-ring-label">Overall</span>
                </div>
            </div>

            {{-- Pass mark indicator --}}
            <div style="max-width:240px;margin:18px auto 0;position:relative;z-index:1;">
                <div style="display:flex;justify-content:space-between;font-size:0.75rem;opacity:0.7;margin-bottom:5px;">
                    <span>0%</span>
                    <span>Pass: {{ $minPct }}%</span>
                    <span>100%</span>
                </div>
                <div style="height:8px;background:rgba(255,255,255,0.12);border-radius:var(--radius-full);overflow:hidden;">
                    <div id="heroProgressFill" style="height:100%;border-radius:var(--radius-full);width:0%;transition:width 1.4s ease;
                         background:{{ $passed ? 'linear-gradient(90deg,#FBC60C,#EBD789)' : 'linear-gradient(90deg,#ef4444,#fca5a5)' }};">
                    </div>
                </div>
            </div>
        </div>

        {{-- STATS ROW --}}
        <div class="stats-grid">
            <div class="stat-card fade-in-up">
                <div class="stat-icon blue"><i class="fas fa-layer-group"></i></div>
                <div class="stat-value">{{ $totalLevels }}</div>
                <div class="stat-label">Total Levels</div>
            </div>
            <div class="stat-card fade-in-up">
                <div class="stat-icon green"><i class="fas fa-check-double"></i></div>
                <div class="stat-value">{{ $passedLevels }}<span style="font-size:1rem;font-weight:500;color:var(--khaki-beige);">/{{ $totalLevels }}</span></div>
                <div class="stat-label">Levels Passed</div>
            </div>
            <div class="stat-card fade-in-up">
                <div class="stat-icon amber"><i class="fas fa-star"></i></div>
                <div class="stat-value">{{ $attempt->overall_score ?? 0 }}<span style="font-size:1rem;font-weight:500;color:var(--khaki-beige);">/{{ $totalPoints }}</span></div>
                <div class="stat-label">Points</div>
            </div>
            <div class="stat-card fade-in-up">
                <div class="stat-icon teal"><i class="fas fa-check-circle"></i></div>
                <div class="stat-value">{{ $totalCorrect }}<span style="font-size:1rem;font-weight:500;color:var(--khaki-beige);">/{{ $totalQuestions }}</span></div>
                <div class="stat-label">Correct Answers</div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">

                {{-- LEVEL BREAKDOWN --}}
                <div class="panel fade-in-up">
                    <div class="panel-title">
                        <div class="panel-title-icon"><i class="fas fa-layer-group"></i></div>
                        Level Breakdown
                    </div>

                    @forelse($levelStats as $levelNum => $stat)
                        @php
                            $lvl        = $stat['level'];
                            $lvlAttempt = $stat['attempt'];
                            $lvlPct     = round($lvlAttempt->percentage ?? 0);
                            $isPassed   = $stat['passed'];
                        @endphp
                        <div class="level-breakdown-card {{ $isPassed ? 'passed' : 'failed' }}">
                            <div class="level-card-header">
                                <div class="level-card-info">
                                    <div class="level-num-badge {{ $isPassed ? 'passed' : 'failed' }}">
                                        {{ $levelNum }}
                                    </div>
                                    <div>
                                        <p class="level-card-name">{{ $lvl->title }}</p>
                                        <div class="level-card-meta">Level {{ $levelNum }} &bull; {{ $stat['questions'] }} questions</div>
                                    </div>
                                </div>
                                <span class="result-chip {{ $isPassed ? 'passed' : 'failed' }}">
                                    <i class="fas fa-{{ $isPassed ? 'check' : 'times' }}"></i>
                                    {{ $isPassed ? 'Passed' : 'Failed' }}
                                </span>
                            </div>

                            {{-- Progress bar --}}
                            <div class="level-progress-bar">
                                <div class="level-progress-fill {{ $isPassed ? 'passed' : 'failed' }} level-bar"
                                     data-pct="{{ $lvlPct }}"
                                     style="width:0%;">
                                </div>
                            </div>

                            <div class="level-stats-row">
                                <div class="level-stat-item">
                                    <i class="fas fa-percent" style="color:var(--regal-navy);"></i>
                                    <span class="val">{{ $lvlPct }}%</span>
                                    <span class="lbl">Score</span>
                                </div>
                                <div class="level-stat-item">
                                    <i class="fas fa-check" style="color:#16a34a;"></i>
                                    <span class="val">{{ $stat['correct'] }}/{{ $stat['questions'] }}</span>
                                    <span class="lbl">Correct</span>
                                </div>
                                <div class="level-stat-item">
                                    <i class="fas fa-star" style="color:#b45309;"></i>
                                    <span class="val">{{ $stat['score'] }} pts</span>
                                    <span class="lbl">Earned</span>
                                </div>
                                @if($lvlAttempt->time_taken)
                                    <div class="level-stat-item">
                                        <i class="fas fa-clock" style="color:var(--dark-slate);"></i>
                                        <span class="val">{{ $lvlAttempt->time_taken_formatted }}</span>
                                        <span class="lbl">Time</span>
                                    </div>
                                @endif
                                <div class="level-stat-item" style="margin-left:auto;">
                                    <a href="{{ route('progressive-quizzes.level-results', ['progressiveQuiz' => $progressiveQuiz->id, 'level' => $lvl->id]) }}"
                                       style="font-size:0.82rem;color:var(--regal-navy);font-weight:600;text-decoration:none;display:flex;align-items:center;gap:4px;">
                                        <i class="fas fa-eye"></i> Review
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div style="text-align:center;padding:32px;color:var(--khaki-beige);">
                            <i class="fas fa-inbox" style="font-size:2rem;margin-bottom:10px;display:block;"></i>
                            No level data found.
                        </div>
                    @endforelse
                </div>

                {{-- ACTIONS --}}
                <div class="panel fade-in-up">
                    <div class="panel-title">
                        <div class="panel-title-icon"><i class="fas fa-compass"></i></div>
                        What's Next?
                    </div>

                    @if($passed)
                        <p style="font-size:0.9rem;color:var(--khaki-beige);margin-bottom:20px;">
                            Outstanding work completing all levels! Explore more quizzes or head back to your dashboard.
                        </p>
                        <div class="action-buttons">
                            <a href="{{ route('progressive-quizzes.index') }}" class="btn-accent-custom">
                                <i class="fas fa-search"></i> More Quizzes
                            </a>
                            <a href="{{ route('dashboard') }}" class="btn-outline-custom">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                            @if($canAttempt)
                                <form action="{{ route('progressive-quizzes.restart', $progressiveQuiz) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn-outline-custom" style="border-color:var(--accent);color:var(--prussian-blue);">
                                        <i class="fas fa-redo"></i> Re-attempt
                                    </button>
                                </form>
                            @endif
                        </div>
                    @else
                        <p style="font-size:0.9rem;color:var(--khaki-beige);margin-bottom:20px;">
                            You didn't reach the {{ $minPct }}% pass mark this time. Review the level breakdowns above and try again.
                        </p>
                        <div class="action-buttons">
                            @if($canAttempt)
                                <form action="{{ route('progressive-quizzes.restart', $progressiveQuiz) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn-primary-custom">
                                        <i class="fas fa-redo"></i> Try Again
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('progressive-quizzes.show', $progressiveQuiz->slug) }}" class="btn-primary-custom" style="opacity:0.6;pointer-events:none;">
                                    <i class="fas fa-lock"></i> Max Attempts Reached
                                </a>
                            @endif
                            <a href="{{ route('progressive-quizzes.index') }}" class="btn-outline-custom">
                                <i class="fas fa-list"></i> All Quizzes
                            </a>
                        </div>
                    @endif
                </div>

            </div>

            {{-- SIDEBAR --}}
            <div class="col-lg-4">

                {{-- Quiz Summary --}}
                <div class="panel fade-in-up" style="margin-bottom:20px;">
                    <div class="panel-title">
                        <div class="panel-title-icon"><i class="fas fa-chart-bar"></i></div>
                        Quiz Summary
                    </div>

                    <div class="summary-row">
                        <span class="lbl">Quiz</span>
                        <span class="val" style="max-width:180px;text-align:right;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $progressiveQuiz->title }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="lbl">Overall Score</span>
                        <span class="val">{{ $attempt->overall_score ?? 0 }} / {{ $totalPoints }} pts</span>
                    </div>
                    <div class="summary-row">
                        <span class="lbl">Percentage</span>
                        <span class="val">{{ $overallPct }}%</span>
                    </div>
                    <div class="summary-row">
                        <span class="lbl">Pass Mark</span>
                        <span class="val">{{ $minPct }}%</span>
                    </div>
                    <div class="summary-row">
                        <span class="lbl">Levels Completed</span>
                        <span class="val">{{ $totalLevels }} / {{ $progressiveQuiz->total_levels }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="lbl">Correct Answers</span>
                        <span class="val">{{ $totalCorrect }} / {{ $totalQuestions }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="lbl">Time Taken</span>
                        <span class="val">{{ $timeTaken }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="lbl">Attempt #</span>
                        <span class="val">{{ $attempt->attempt_number }}</span>
                    </div>
                    <div class="summary-row" style="padding-top:12px;">
                        <span class="lbl">Result</span>
                        <span class="result-chip {{ $passed ? 'passed' : 'failed' }}">
                            <i class="fas fa-{{ $passed ? 'check' : 'times' }}"></i>
                            {{ $passed ? 'Passed' : 'Failed' }}
                        </span>
                    </div>

                    {{-- Overall bar --}}
                    <div style="margin-top:16px;">
                        <div style="display:flex;justify-content:space-between;font-size:0.78rem;color:var(--khaki-beige);margin-bottom:5px;">
                            <span>Overall Progress</span>
                            <span>{{ $overallPct }}%</span>
                        </div>
                        <div class="overall-score-bar">
                            <div class="overall-score-fill {{ $passed ? 'passed' : 'failed' }}"
                                 id="overallBarFill"
                                 style="width:0%;">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Level Scores Summary --}}
                <div class="panel fade-in-up">
                    <div class="panel-title">
                        <div class="panel-title-icon"><i class="fas fa-map-signs"></i></div>
                        Level Scores
                    </div>

                    @foreach($levelStats as $levelNum => $stat)
                        @php $lvlPct = round($stat['attempt']->percentage ?? 0); @endphp
                        <div style="margin-bottom:14px;">
                            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:5px;">
                                <div style="display:flex;align-items:center;gap:8px;">
                                    <span style="width:24px;height:24px;border-radius:50%;background:{{ $stat['passed'] ? 'rgba(34,197,94,0.12)' : 'rgba(239,68,68,0.1)' }};
                                               color:{{ $stat['passed'] ? '#16a34a' : '#dc2626' }};display:inline-flex;align-items:center;justify-content:center;
                                               font-size:0.7rem;font-weight:800;flex-shrink:0;">
                                        @if($stat['passed']) <i class="fas fa-check"></i> @else {{ $levelNum }} @endif
                                    </span>
                                    <span style="font-size:0.85rem;font-weight:600;color:var(--prussian-blue);">{{ $stat['level']->title }}</span>
                                </div>
                                <span style="font-size:0.85rem;font-weight:700;color:{{ $stat['passed'] ? '#16a34a' : '#dc2626' }};">{{ $lvlPct }}%</span>
                            </div>
                            <div style="height:5px;background:rgba(10,29,68,0.07);border-radius:var(--radius-full);overflow:hidden;">
                                <div class="sidebar-level-bar"
                                     data-pct="{{ $lvlPct }}"
                                     style="height:100%;border-radius:var(--radius-full);width:0%;transition:width 1.2s ease;
                                            background:{{ $stat['passed'] ? 'linear-gradient(90deg,#22c55e,#86efac)' : 'linear-gradient(90deg,#ef4444,#fca5a5)' }};">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const targetPct    = {{ $overallPct }};
    const circumference = {{ round($circumference, 4) }};

    // Score ring animation
    const circle = document.getElementById('scoreRingCircle');
    if (circle) {
        const offset = circumference - (targetPct / 100) * circumference;
        setTimeout(() => { circle.style.strokeDashoffset = offset; }, 300);
    }

    // Hero progress bar
    const heroBar = document.getElementById('heroProgressFill');
    if (heroBar) {
        setTimeout(() => { heroBar.style.width = targetPct + '%'; }, 300);
    }

    // Overall sidebar bar
    const overallBar = document.getElementById('overallBarFill');
    if (overallBar) {
        setTimeout(() => { overallBar.style.width = targetPct + '%'; }, 400);
    }

    // Counter animation
    const pctText = document.getElementById('scoreRingPct');
    if (pctText) {
        let current = 0;
        const step  = Math.max(1, Math.floor(targetPct / 60));
        const timer = setInterval(() => {
            current = Math.min(current + step, targetPct);
            pctText.textContent = current + '%';
            if (current >= targetPct) clearInterval(timer);
        }, 20);
    }

    // Level breakdown bars
    setTimeout(() => {
        document.querySelectorAll('.level-bar').forEach(el => {
            el.style.width = el.dataset.pct + '%';
        });
        document.querySelectorAll('.sidebar-level-bar').forEach(el => {
            el.style.width = el.dataset.pct + '%';
        });
    }, 500);
});
</script>
@endpush
@endsection