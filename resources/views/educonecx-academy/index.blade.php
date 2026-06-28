@extends('layouts.main')

@section('title', 'Practice Room')

@push('styles')
<style>
    .academy-page {
        --academy-navy: #0A1D44;
        --academy-navy-2: #18386E;
        --academy-teal: #2E5C61;
        --academy-yellow: #FBC60C;
        --academy-yellow-soft: #EBD789;
        --academy-ivory: #F9F7E9;
        --academy-white: #FEFDFE;
        --academy-muted: #6B7280;
        --academy-border: rgba(10, 29, 68, 0.09);
        --academy-shadow: 0 18px 40px rgba(10, 29, 68, 0.10);
        --academy-soft-shadow: 0 8px 22px rgba(10, 29, 68, 0.07);
        background: linear-gradient(180deg, var(--academy-ivory) 0%, var(--academy-white) 52%, #fff 100%);
        color: var(--academy-navy);
        padding-bottom: 56px;
    }

    .academy-page * {
        box-sizing: border-box;
    }

    .academy-hero {
        background: radial-gradient(circle at top right, rgba(251, 198, 12, 0.28), transparent 34%),
                    linear-gradient(135deg, var(--academy-navy) 0%, var(--academy-navy-2) 54%, var(--academy-teal) 100%);
        color: var(--academy-white);
        padding: 76px 0 88px;
        position: relative;
        overflow: hidden;
    }

    .academy-hero::after {
        content: '';
        position: absolute;
        width: 360px;
        height: 360px;
        left: -130px;
        bottom: -180px;
        border-radius: 50%;
        background: rgba(90, 209, 228, 0.12);
    }

    .academy-page.academy-exam-active {
        background: linear-gradient(180deg, #07142f 0%, #0A1D44 34%, #f8fafc 34%, #fff 100%);
    }

    .academy-page.academy-exam-active .academy-hero {
        background: radial-gradient(circle at top right, rgba(251, 198, 12, 0.38), transparent 30%),
                    linear-gradient(135deg, #060d22 0%, #0A1D44 48%, #7a5b00 100%);
        padding: 54px 0 64px;
    }

    .academy-page.academy-exam-active .academy-hero-subtitle {
        max-width: 760px;
    }

    .academy-page.academy-exam-active .academy-main {
        margin-top: -28px;
    }

    .academy-page.academy-exam-active [data-hide-during-exam] {
        display: none !important;
    }

    .academy-back-practice-btn {
        display: none;
    }

    .academy-page.academy-exam-active .academy-back-practice-btn {
        display: inline-flex;
    }

    .academy-hero-content {
        position: relative;
        z-index: 1;
        max-width: 820px;
    }

    .academy-kicker {
        color: var(--academy-yellow);
        font-size: 0.82rem;
        font-weight: 800;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        margin-bottom: 14px;
    }

    .academy-hero-title {
        color: var(--academy-white);
        font-size: clamp(2.25rem, 5vw, 4.2rem);
        font-weight: 900;
        line-height: 1.02;
        margin-bottom: 16px;
    }

    .academy-hero-subtitle {
        color: rgba(254, 253, 254, 0.88);
        font-size: 1.16rem;
        max-width: 650px;
        margin-bottom: 24px;
    }

    .academy-badge-row,
    .academy-step-row,
    .academy-action-row,
    .academy-recording-controls {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .academy-hero-badge,
    .academy-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border-radius: 999px;
        font-weight: 800;
        font-size: 0.82rem;
    }

    .academy-hero-badge {
        color: var(--academy-white);
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.18);
        padding: 9px 14px;
        backdrop-filter: blur(7px);
    }

    .academy-main {
        margin-top: -42px;
        position: relative;
        z-index: 2;
    }

    .academy-grid {
        display: grid;
        grid-template-columns: minmax(280px, 0.85fr) minmax(0, 1.45fr);
        gap: 24px;
        align-items: stretch;
    }

    .academy-card,
    .academy-livecoach-card,
    .academy-evaluation-card {
        background: var(--academy-white);
        border: 1px solid var(--academy-border);
        border-radius: 18px;
        box-shadow: var(--academy-soft-shadow);
        overflow: hidden;
    }

    .academy-card-header,
    .academy-livecoach-header,
    .academy-evaluation-header {
        padding: 22px 24px;
        border-bottom: 1px solid var(--academy-border);
        background: linear-gradient(145deg, #fff, var(--academy-ivory));
    }

    .academy-card-title,
    .academy-livecoach-title {
        margin: 0;
        color: var(--academy-navy);
        font-size: 1.2rem;
        font-weight: 850;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .academy-card-title i,
    .academy-livecoach-title i {
        color: var(--academy-yellow);
    }

    .academy-card-subtitle,
    .academy-livecoach-status {
        color: var(--academy-muted);
        margin: 7px 0 0;
        font-size: 0.92rem;
    }

    .academy-card-body,
    .academy-evaluation-body {
        padding: 24px;
    }



    .english-course-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
    }

    .english-course-card {
        background: #fff;
        border: 1px solid rgba(10, 29, 68, 0.08);
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 8px 22px rgba(10, 29, 68, 0.07);
        display: flex;
        flex-direction: column;
        min-height: 100%;
    }

    .english-course-thumb {
        width: 100%;
        aspect-ratio: 16 / 9;
        max-height: 180px;
        overflow: hidden;
        background: var(--academy-ivory);
    }

    .english-course-thumb img,
    .english-course-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
    }

    .english-course-thumb img {
        object-fit: cover;
        display: block;
    }

    .english-course-placeholder {
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--academy-navy), var(--academy-teal));
        color: var(--academy-white);
        text-align: center;
    }

    .english-course-placeholder strong {
        color: var(--academy-yellow);
        font-size: 1rem;
        letter-spacing: .08em;
    }

    .english-course-placeholder span {
        color: rgba(255, 255, 255, .86);
        font-weight: 800;
    }

    .english-course-body {
        padding: 16px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        flex: 1;
    }

    .english-course-level {
        display: inline-flex;
        width: fit-content;
        padding: 5px 10px;
        border-radius: 999px;
        background: rgba(251, 198, 12, 0.18);
        color: var(--academy-navy);
        font-size: 0.76rem;
        font-weight: 850;
        text-transform: capitalize;
    }

    .english-course-title {
        font-size: 1.05rem;
        font-weight: 900;
        color: var(--academy-navy);
        margin: 0;
        line-height: 1.25;
    }

    .english-course-desc {
        color: var(--academy-muted);
        font-size: .9rem;
        line-height: 1.45;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 42px;
        margin: 0;
    }

    .english-course-progress {
        height: 8px;
        border-radius: 999px;
        background: #eef2f7;
        overflow: hidden;
    }

    .english-course-progress-bar {
        height: 100%;
        background: linear-gradient(135deg, var(--academy-yellow), var(--academy-yellow-soft));
        border-radius: 999px;
    }

    .english-course-meta {
        color: var(--academy-muted);
        font-size: .82rem;
        margin: 0;
    }

    .english-course-card .academy-btn-primary {
        width: 100%;
        justify-content: center;
        border-radius: 999px;
        background: var(--academy-yellow);
        border-color: var(--academy-yellow);
        color: var(--academy-navy);
    }

    .practice-lesson-context {
        border: 1px solid rgba(251, 198, 12, 0.35);
        background: rgba(251, 198, 12, 0.12);
        border-radius: 16px;
        padding: 16px 18px;
        margin-bottom: 18px;
    }

    .academy-setup-grid {
        display: grid;
        grid-template-columns: minmax(220px, 0.8fr) minmax(0, 1.2fr);
        gap: 18px;
        align-items: stretch;
    }

    .academy-coach-preview {
        min-height: 230px;
        background: var(--academy-ivory);
        border: 1px solid rgba(251, 198, 12, 0.28);
        border-radius: 16px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .academy-coach-preview img,
    .academy-media-frame img {
        width: 100%;
        height: 100%;
        min-height: 230px;
        object-fit: cover;
        display: block;
        background: #F9F7E9;
    }

    .academy-coach-preview i {
        color: var(--academy-navy);
        font-size: 4rem;
    }


    .academy-coach-card {
        background: linear-gradient(180deg, #fff, var(--academy-ivory));
        border: 1px solid rgba(251, 198, 12, 0.24);
        border-radius: 22px;
        padding: 18px;
        box-shadow: var(--academy-soft-shadow);
    }

    .academy-coach-photo {
        min-height: 300px;
        border-radius: 20px;
        margin-bottom: 18px;
    }

    .academy-coach-placeholder {
        width: 100%;
        min-height: 300px;
        background: linear-gradient(135deg, rgba(10, 29, 68, 0.08), rgba(251, 198, 12, 0.18));
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .academy-coach-info h3 {
        color: var(--academy-navy);
        font-size: 1.45rem;
        font-weight: 900;
        margin: 0;
    }

    .academy-coach-info p {
        color: var(--academy-teal);
        font-weight: 800;
        margin: 2px 0 10px;
    }

    .academy-coach-focus {
        margin-top: 18px;
        border-top: 1px solid rgba(10, 29, 68, 0.08);
        padding-top: 16px;
    }

    .academy-coach-focus span {
        color: var(--academy-muted);
        font-weight: 850;
        font-size: 0.86rem;
    }

    .academy-coach-focus ul {
        list-style: none;
        padding: 0;
        margin: 12px 0 0;
        display: grid;
        gap: 8px;
    }

    .academy-coach-focus li {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--academy-navy);
        font-weight: 750;
    }

    .academy-coach-focus i {
        color: var(--academy-teal);
    }

    .academy-config-list {
        display: grid;
        gap: 12px;
    }

    .academy-config-item {
        background: var(--academy-ivory);
        border: 1px solid rgba(10, 29, 68, 0.07);
        border-radius: 14px;
        padding: 14px 16px;
    }

    .academy-config-item span {
        color: var(--academy-muted);
        display: block;
        font-size: 0.78rem;
        font-weight: 800;
        letter-spacing: 0.04em;
        margin-bottom: 5px;
        text-transform: uppercase;
    }

    .academy-config-item strong {
        color: var(--academy-navy);
        font-size: 1rem;
    }

    .academy-detail-card {
        min-height: 100%;
    }

    .academy-detail-title {
        font-size: clamp(1.55rem, 3vw, 2.25rem);
        font-weight: 900;
        line-height: 1.12;
        margin-bottom: 14px;
        color: var(--academy-navy);
    }

    .academy-pill {
        padding: 7px 11px;
        color: var(--academy-navy);
        background: var(--academy-ivory);
        border: 1px solid rgba(251, 198, 12, 0.35);
    }

    .academy-practice-text,
    .academy-question-list {
        background: var(--academy-ivory);
        border: 1px solid rgba(10, 29, 68, 0.07);
        border-radius: 14px;
        padding: 16px;
    }

    .academy-practice-text h5,
    .academy-question-list h5 {
        color: var(--academy-navy);
        font-size: 0.9rem;
        font-weight: 850;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin-bottom: 8px;
    }

    .academy-btn-primary,
    .academy-page .btn.academy-btn-primary {
        background: linear-gradient(135deg, var(--academy-yellow), var(--academy-yellow-soft));
        color: var(--academy-navy);
        border: 0;
        border-radius: 999px;
        font-weight: 850;
        box-shadow: 0 10px 20px rgba(251, 198, 12, 0.25);
        padding: 12px 22px;
    }

    .academy-btn-navy,
    .academy-page .btn.academy-btn-navy {
        background: linear-gradient(135deg, var(--academy-navy), var(--academy-navy-2));
        color: #fff;
        border: 0;
        border-radius: 999px;
        font-weight: 850;
        padding: 12px 22px;
    }

    .academy-btn-soft,
    .academy-page .btn.academy-btn-soft {
        background: #fff;
        color: var(--academy-navy-2);
        border: 1px solid rgba(24, 56, 110, 0.22);
        border-radius: 999px;
        font-weight: 750;
        padding: 11px 20px;
    }

    .academy-btn-danger,
    .academy-page .btn.academy-btn-danger {
        background: #fff1f2;
        color: #be123c;
        border: 1px solid rgba(225, 29, 72, 0.22);
        border-radius: 999px;
        font-weight: 800;
        padding: 11px 20px;
    }

    .academy-page .btn:disabled,
    .academy-page button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none !important;
        box-shadow: none !important;
    }

    .academy-status-message {
        min-height: 24px;
        color: var(--academy-teal);
        font-weight: 700;
    }

    .academy-livecoach-section,
    .academy-evaluation-section {
        margin-top: 28px;
    }

    .academy-livecoach-card,
    .academy-evaluation-card {
        box-shadow: var(--academy-shadow);
    }

    .academy-livecoach-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 18px;
    }

    .academy-status-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: var(--academy-yellow);
        box-shadow: 0 0 0 6px rgba(251, 198, 12, 0.16);
        display: inline-block;
        margin-right: 8px;
    }

    .academy-livecoach-frame-wrap {
        width: 100%;
        height: 680px;
        min-height: 680px;
        background: #050505;
        border-radius: 0 0 18px 18px;
        overflow: hidden;
    }

    .academy-livecoach-frame-wrap iframe {
        width: 100% !important;
        height: 680px !important;
        border: 0 !important;
        display: block !important;
        background: #050505;
    }

    .academy-livecoach-placeholder {
        min-height: 680px;
        color: rgba(255, 255, 255, 0.78);
        background: radial-gradient(circle at center, #1f2937 0%, #050505 72%);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 12px;
        text-align: center;
        padding: 28px;
    }

    .academy-livecoach-placeholder i {
        color: var(--academy-yellow);
        font-size: 2.5rem;
    }

    .academy-step-row {
        align-items: stretch;
        margin: 18px 0 22px;
    }

    .academy-step {
        flex: 1 1 180px;
        background: var(--academy-ivory);
        border: 1px solid rgba(10, 29, 68, 0.07);
        border-radius: 14px;
        padding: 14px;
        display: flex;
        gap: 10px;
        align-items: flex-start;
    }

    .academy-step-number {
        background: var(--academy-yellow);
        color: var(--academy-navy);
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 900;
        flex: 0 0 auto;
    }

    .academy-info-box {
        border-radius: 14px;
        border: 1px solid rgba(90, 209, 228, 0.24);
        background: rgba(90, 209, 228, 0.10);
        color: var(--academy-teal);
        padding: 14px 16px;
        margin-bottom: 18px;
    }

    .academy-recording-controls {
        margin-bottom: 14px;
    }

    .academy-audio-preview {
        width: 100%;
        display: block;
        margin-top: 14px;
    }

    .academy-textarea {
        border-radius: 14px;
        border: 1px solid rgba(10, 29, 68, 0.14);
        padding: 14px;
    }

    .academy-score-grid {
        display: grid;
        grid-template-columns: repeat(5, minmax(120px, 1fr));
        gap: 12px;
    }

    .academy-score-box,
    .academy-evaluation-panel,
    .academy-evaluation-list,
    .academy-correction-item {
        background: var(--academy-white);
        border: 1px solid rgba(10, 29, 68, 0.09);
        border-radius: 14px;
        padding: 16px;
        box-shadow: 0 6px 18px rgba(10, 29, 68, 0.05);
    }

    .academy-score-box {
        background: linear-gradient(145deg, #fff, var(--academy-ivory));
    }

    .academy-score-box--overall {
        background: linear-gradient(135deg, var(--academy-navy), var(--academy-navy-2));
        color: #fff;
    }

    .academy-score-box span {
        display: block;
        color: var(--academy-muted);
        font-size: 0.76rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin-bottom: 4px;
    }

    .academy-score-box--overall span {
        color: rgba(255, 255, 255, 0.74);
    }

    .academy-score-box strong {
        color: var(--academy-navy);
        font-size: 1.5rem;
        font-weight: 900;
    }

    .academy-score-box--overall strong {
        color: var(--academy-yellow);
        font-size: 1.9rem;
    }

    .academy-evaluation-result {
        background: #fff;
        border: 1px solid rgba(10, 29, 68, 0.08);
        border-radius: 18px;
        padding: 18px;
        box-shadow: var(--academy-soft-shadow);
    }

    .academy-evaluation-list h5,
    .academy-evaluation-panel h5 {
        color: var(--academy-navy);
        font-size: 0.96rem;
        font-weight: 850;
        margin-bottom: 10px;
    }

    .academy-corrections {
        display: grid;
        gap: 12px;
    }



    .academy-intro-card { margin-bottom: 24px; }
    .academy-intro-grid { display: grid; grid-template-columns: minmax(0, 1fr) minmax(280px, .75fr); gap: 22px; align-items: center; }
    .academy-intro-title { color: var(--academy-navy); font-weight: 900; margin-bottom: 8px; }
    .academy-media-frame { width: 100%; aspect-ratio: 16 / 9; min-height: 240px; border-radius: 18px; overflow: hidden; background: var(--academy-ivory); border: 1px solid rgba(251, 198, 12, .24); }
    .academy-media-frame video { width: 100%; height: 100%; object-fit: cover; display: block; }
    .academy-actions-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 18px; margin-bottom: 24px; }
    .academy-action-card { width: 100%; min-width: 0; background: #fff; border: 1px solid var(--academy-border); border-radius: 18px; padding: 22px; box-shadow: var(--academy-soft-shadow); display: flex; flex-direction: column; gap: 14px; min-height: 100%; }
    .academy-action-card h3 { color: var(--academy-navy); font-size: 1.12rem; font-weight: 900; margin: 0; }
    .academy-action-card p { color: var(--academy-muted); margin: 0; line-height: 1.5; overflow-wrap: anywhere; }
    .academy-action-icon { width: 48px; height: 48px; border-radius: 15px; display: inline-flex; align-items: center; justify-content: center; background: var(--academy-ivory); color: var(--academy-navy); font-size: 1.2rem; }
    .academy-action-card .btn { width: 100%; justify-content: center; margin-top: auto; }
    .academy-practice-time-value { display: block; color: var(--academy-navy); font-size: clamp(1.8rem, 5vw, 2.6rem); font-weight: 950; line-height: 1; }
    .academy-exam-rules { background: #fff; border: 1px solid rgba(10, 29, 68, .1); border-radius: 18px; padding: 20px; box-shadow: var(--academy-soft-shadow); }
    .academy-exam-rules h3 { color: var(--academy-navy); font-weight: 900; font-size: 1.1rem; }
    .academy-exam-rules li { margin-bottom: 8px; }
    .academy-history-list { display: grid; gap: 12px; }
    .academy-history-item { border: 1px solid var(--academy-border); border-radius: 14px; padding: 14px; background: #fff; display: flex; justify-content: space-between; gap: 12px; flex-wrap: wrap; }
    .academy-history-item strong { color: var(--academy-navy); }
    .academy-fallback-note { font-size: .78rem; color: var(--academy-muted); margin-top: 8px; }

    @media (max-width: 992px) {
        .academy-grid,
        .academy-setup-grid {
            grid-template-columns: 1fr;
        }

        .english-course-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .english-course-thumb {
            max-height: 160px;
        }

        .academy-score-grid {
            grid-template-columns: repeat(auto-fit, minmax(145px, 1fr));
        }

        .academy-actions-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .academy-intro-grid { grid-template-columns: 1fr; }
    }

    @media (max-width: 576px) {
        .english-course-grid {
            grid-template-columns: 1fr;
        }

        .english-course-thumb {
            max-height: 140px;
        }
    }

    @media (max-width: 768px) {
        .academy-hero {
            padding: 56px 0 72px;
        }

        .academy-card-header,
        .academy-livecoach-header,
        .academy-evaluation-header,
        .academy-card-body,
        .academy-evaluation-body {
            padding: 18px;
        }

        .academy-livecoach-header {
            align-items: stretch;
            flex-direction: column;
        }

        .academy-livecoach-frame-wrap,
        .academy-livecoach-placeholder {
            height: 520px;
            min-height: 520px;
        }

        .academy-livecoach-frame-wrap iframe {
            height: 520px !important;
        }

        .academy-actions-grid { grid-template-columns: 1fr; }
        .academy-action-card { padding: 18px; }
        .academy-media-frame { min-height: 190px; }
        .academy-coach-photo, .academy-coach-placeholder { min-height: 220px; }

        .academy-action-row .btn,
        .academy-recording-controls .btn,
        #openSessionLink {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
<div class="academy-page">
    <section class="academy-hero">
        <div class="container academy-hero-content">
            <div class="academy-kicker" id="academyHeroKicker">Interactive English Speaking Practice</div>
            <h1 class="academy-hero-title">Practice Room</h1>
            <p class="academy-hero-subtitle" id="academyHeroSubtitle">Practice English in real time with your English Coach, Olivia Clarcke, then receive guided feedback on pronunciation, grammar, fluency, vocabulary, and speaking confidence.</p>
            <div class="academy-badge-row">
                <span class="academy-hero-badge"><i class="fas fa-chalkboard-teacher"></i> Olivia Clarcke</span>
                <span class="academy-hero-badge"><i class="fas fa-microphone-alt"></i> Speaking Practice</span>
                <span class="academy-hero-badge"><i class="fas fa-chart-line"></i> Performance Feedback</span>
                <button type="button" id="backToPracticeBtn" class="btn academy-btn-soft academy-back-practice-btn"><i class="fas fa-arrow-left"></i> Back to Practice</button>
            </div>
        </div>
    </section>

    <main class="academy-main">
        <div class="container">
            @guest
                <div class="alert alert-warning">Please login to access the Practice Room.</div>
            @endguest

            @php
                $currentPracticeConfig = $currentAvatarConfig ?? [];
                $canStartPractice = ! empty($currentPracticeConfig['avatar_id'])
                    && empty($missingHeyGenConfig);
                $isPaidMember = (bool) ($canAccessPracticeRoom ?? $isPaidMember ?? false);
                $practiceMinutesAvailable = (int) ($practiceMinutesAvailable ?? $practiceMinutesAvailableJs ?? 0);
                $practiceCreditValue = (float) ($practiceCreditValue ?? round($practiceMinutesAvailable * ($practiceCreditValuePerMinute ?? (4 / 15)), 2));
                $subscriptionIncludedPracticeCredits = (float) ($subscriptionIncludedPracticeCredits ?? 4);
                $subscriptionIncludedPracticeMinutes = (int) ($subscriptionIncludedPracticeMinutes ?? 15);
                $practiceMinutesAvailableJs = $practiceMinutesAvailable;
                $canStartPracticeSession = $isPaidMember && $canStartPractice && $practiceMinutesAvailable > 0;
                $canStartExamSession = $isPaidMember && $canStartPractice && $practiceMinutesAvailable > 0;
                $coachImage = $practiceCoachImage
                    ?? data_get($currentAvatarConfig, 'avatar_image_url')
                    ?? data_get($currentAvatarConfig, 'image_url')
                    ?? asset('images/academy/victoria-clarke.jpg');
                $isCoachImageUrl = ! empty($coachImage) && (
                    str_starts_with($coachImage, 'http://') ||
                    str_starts_with($coachImage, 'https://') ||
                    str_starts_with($coachImage, '/')
                );
                $coachImage = $isCoachImageUrl ? $coachImage : null;
                $examImage = $examCoachImage ?? null;
                $isExamImageUrl = ! empty($examImage) && (
                    str_starts_with($examImage, 'http://') ||
                    str_starts_with($examImage, 'https://') ||
                    str_starts_with($examImage, '/')
                );
                $examImage = $isExamImageUrl ? $examImage : null;
            @endphp


            <section class="academy-card academy-intro-card" aria-labelledby="practice-area-heading" data-hide-during-exam>
                <div class="academy-card-body">
                    <div class="academy-intro-grid">
                        <div>
                            <span class="academy-kicker" style="color:var(--academy-teal)">Practice Area</span>
                            <h2 id="practice-area-heading" class="academy-intro-title">Choose how you want to learn today</h2>
                            <p class="academy-card-subtitle mb-3">Start a guided conversation or take a formal speaking exam. Everything is timed, clean, and focused.</p>
                            <div class="academy-badge-row">
                                <span class="academy-pill"><i class="fas fa-user-graduate"></i> Practice Sessions</span>
                                <!-- <span class="academy-pill"><i class="fas fa-wallet"></i> ${{ number_format($practiceCreditValue, 2) }} Credits Left</span> -->
                                <span class="academy-pill"><i class="fas fa-stopwatch"></i> {{ $practiceMinutesAvailable }} Minutes Remaining</span>
                            </div>
                        </div>
                        <div class="academy-media-frame" aria-label="Olivia avatar card">
                            @if(! empty($introVideoUrl))
                                <video src="{{ $introVideoUrl }}" controls playsinline preload="metadata" @if($isCoachImageUrl) poster="{{ $coachImage }}" @endif></video>
                            @elseif($isCoachImageUrl)
                                <img src="{{ $coachImage }}" alt="Olivia Clarcke welcomes you to the Practice Room" loading="lazy">
                            @else
                                <div class="academy-coach-placeholder"><i class="fas fa-user-tie"></i></div>
                            @endif
                        </div>
                    </div>
                </div>
            </section>


            <section class="academy-actions-grid" aria-label="Practice Room actions" data-hide-during-exam>
                <article class="academy-action-card" style="border-top:6px solid #2f80ed;background:linear-gradient(160deg,#eef6ff 0%,#fff 58%)">
                    <span class="academy-action-icon" style="background:#2f80ed;color:#fff"><i class="fas fa-comments"></i></span>
                    <h3>Practice Mode</h3>
                    <p>Friendly live coaching with Olivia.</p>
                    <button type="button" id="startPracticeBtn" class="btn academy-btn-primary btn-lg" {{ ! $canStartPracticeSession ? 'disabled' : '' }}>
                        <i class="fas fa-play"></i> Start Practice
                    </button>
                    <span id="statusMessage" class="academy-status-message d-block mt-3" role="status" aria-live="polite"></span>
                </article>
                <article class="academy-action-card" style="border-top:6px solid #d4a017;background:linear-gradient(160deg,#fff7db 0%,#fff 60%)">
                    <span class="academy-action-icon" style="background:#d4a017;color:#fff"><i class="fas fa-clipboard-check"></i></span>
                    <h3>Exam Mode</h3>
                    <p>Timed assessment with automatic scorecard.</p>
                    <button type="button" id="showExamRulesBtn" class="btn academy-btn-navy btn-lg" {{ ! $canStartExamSession ? 'disabled' : '' }}>
                        <i class="fas fa-award"></i> Start Exam
                    </button>
                </article>
                <article class="academy-action-card">
                    <span class="academy-action-icon"><i class="fas fa-wallet"></i></span>
                    <h3>Practice Credits Available</h3>
                    <!-- <span class="academy-practice-time-value">$<span id="practiceCreditValueJsValue">{{ number_format($practiceCreditValue, 2) }}</span></span> -->
                    <p>
                        <strong><span id="practiceMinutesAvailableJsValue">{{ $practiceMinutesAvailable }}</span> Minutes Left</strong><br>
                        <!-- ${{ number_format($subscriptionIncludedPracticeCredits, 2) }} subscription credits = {{ $subscriptionIncludedPracticeMinutes }} minutes. Add-on sessions remain $10 for 30 minutes. -->
                    </p>
                    <div id="practiceTimeWarning" class="alert alert-warning mt-3 mb-0 {{ $practiceMinutesAvailable <= 0 ? '' : 'd-none' }}">
                        You have used all of your available practice sessions. Please purchase additional practice sessions to continue learning with your English Coach.
                    </div>
                </article>
            </section>


            <section class="academy-card mb-4" aria-labelledby="purchase-sessions-heading" data-hide-during-exam>
                <div class="academy-card-header"><h2 id="purchase-sessions-heading" class="academy-card-title"><i class="fas fa-shopping-bag"></i> Purchase Sessions</h2>
                <!-- <p class="academy-card-subtitle">Practice Sessions • 1 Session = $10 / 30 Minutes</p> -->
            </div>
                <div class="academy-card-body">
                    <div class="academy-action-row justify-content-between" style="gap:18px">
                        <div>
                            <div class="small text-muted fw-semibold">Quantity</div>
                            <div class="academy-action-row mt-2" aria-label="Practice session quantity selector">
                                <button type="button" class="btn academy-btn-soft" id="decreasePackageQty" aria-label="Decrease quantity">−</button>
                                <strong class="fs-4"><span id="packageQty">1</span></strong>
                                <button type="button" class="btn academy-btn-soft" id="increasePackageQty" aria-label="Increase quantity">+</button>
                            </div>
                        </div>
                        <div class="text-md-end">
                            <div class="small text-muted fw-semibold">Dynamic total</div>
                            <strong id="packageTotal" class="display-6 d-block" style="color:var(--academy-navy)">$10</strong>
                        </div>
                        <button type="button" class="btn academy-btn-primary btn-lg" id="purchasePracticeSessionsBtn"><i class="fas fa-lock"></i> Purchase</button>
                    </div>
                </div>
            </section>

            @if(! $isPaidMember)
                <section class="academy-card mb-4" id="freeDemoCard" data-hide-during-exam>
                    <div class="academy-card-header"><h2 class="academy-card-title"><i class="fas fa-user"></i> Guided Onboarding Demo</h2></div>
                    <div class="academy-card-body">
                        <p class="mb-3"><strong>Olivia:</strong> Hello, what is your name?</p>
                        <button type="button" id="startFreeDemoBtn" class="btn academy-btn-primary mb-3"><i class="fas fa-video"></i> Start Guided Avatar Demo</button>
                        <div id="freeDemoAvatarFrame" class="academy-livecoach-frame-wrap d-none mb-3"></div>
                        <div class="academy-action-row"><input id="freeDemoName" class="form-control" style="max-width:320px" placeholder="Your name"><button id="freeDemoSubmit" type="button" class="btn academy-btn-primary">Continue Demo</button></div>
                        <div id="freeDemoMessage" class="alert alert-info mt-3 d-none"></div>
                        <a href="{{ route('subscription.plans') }}" class="btn academy-btn-navy mt-3">Upgrade Membership</a>
                    </div>
                </section>
            @endif

            <section class="academy-card mb-4" data-hide-during-exam>
                <div class="academy-card-header">
                    <h2 class="academy-card-title"><i class="fas fa-chalkboard-teacher"></i> Current Coach</h2>
                    <p class="academy-card-subtitle">Meet your English Coach and prepare for a focused speaking practice session.</p>
                </div>
                <div class="academy-card-body">
                    <div class="academy-setup-grid">
                        <div class="academy-coach-card">
                            <div class="academy-coach-preview academy-coach-photo" id="coachPhotoWrap">
                                @if($isCoachImageUrl)
                                    <img src="{{ $coachImage }}" alt="Olivia Clarcke, English Coach" loading="lazy">
                                @else
                                    <div class="academy-coach-placeholder"><i class="fas fa-user-tie"></i></div>
                                @endif
                            </div>
                            <div class="academy-coach-info">
                                <h3 id="coachName">Olivia Clarcke</h3>
                                <p id="coachTitle">English Coach</p>
                                <strong id="coachSpecialty">Speaking Practice Specialist</strong>
                            </div>
                            <div class="academy-coach-focus">
                                <span>Helping learners improve:</span>
                                <ul>
                                    <li><i class="fas fa-check"></i> Pronunciation</li>
                                    <li><i class="fas fa-check"></i> Fluency</li>
                                    <li><i class="fas fa-check"></i> Vocabulary</li>
                                    <li><i class="fas fa-check"></i> Confidence</li>
                                    <li><i class="fas fa-check"></i> Conversation Skills</li>
                                </ul>
                            </div>
                        </div>
                        <div class="academy-config-list">
                            <div class="academy-config-item">
                                <span>Conversation Focus</span>
                                <strong>English Speaking Practice</strong>
                            </div>
                            <div class="academy-config-item">
                                <span>Coaching Style</span>
                                <strong>{{ $currentPracticeConfig['preferred_language'] ?: 'English' }}{{ $currentPracticeConfig['speaking_level'] ? ' • ' . $currentPracticeConfig['speaking_level'] : '' }}{{ $currentPracticeConfig['tutor_style'] ? ' • ' . $currentPracticeConfig['tutor_style'] : '' }}</strong>
                            </div>

                            @if(! $canStartPractice)
                                <div class="alert alert-warning mb-0">
                                    Please choose your English Coach and conversation focus from Coach Settings before starting practice.
                                </div>
                            @endif

                            @if(!empty($missingHeyGenConfig))
                                <div class="alert alert-warning mb-0">
                                    Your Practice Room is not ready yet. Please contact support to complete the setup.
                                </div>
                            @endif

                            <!-- <div class="academy-action-row mt-2">
                                <a href="{{ route('dashboard.educonecx-academy.index') }}#coach-settings" class="btn academy-btn-soft">
                                    <i class="fas fa-sliders-h"></i> Coach Settings
                                </a>
                                <span id="statusMessage" class="academy-status-message"></span>
                            </div> -->
                        </div>
                    </div>
                </div>
            </section>

            <section id="coachSessionArea" class="academy-livecoach-section d-none">
                <div class="academy-livecoach-card">
                    <div class="academy-livecoach-header">
                        <div>
                            <h2 class="academy-livecoach-title"><i class="fas fa-video"></i> Speaking Session</h2>
                            <p class="academy-livecoach-status" id="coachSessionStatus"><span class="academy-status-dot"></span>Start a live speaking session with Olivia Clarcke and practice real-world English conversations.</p>
                        </div>
                        <div class="d-flex flex-wrap gap-2 justify-content-end">
                            <span id="currentTopicBadge" class="academy-pill">Current Topic: General English</span>
                            <span id="practiceTimeRemainingBadge" class="academy-pill">Practice Credits Left: ${{ number_format($practiceCreditValue, 2) }} ({{ $practiceMinutesAvailable }} Minutes)</span>
                            <a id="openSessionLink" href="#" target="_blank" rel="noopener" class="btn academy-btn-soft d-none">
                                <i class="fas fa-external-link-alt"></i> Open Session
                            </a>
                            <button type="button" id="endSessionBtn" class="btn academy-btn-soft d-none"><i class="fas fa-stop-circle"></i> End Session</button>
                        </div>
                    </div>

                    <div id="coachMount" class="academy-livecoach-frame-wrap">
                        <div class="academy-livecoach-placeholder">
                            <i class="fas fa-chalkboard-teacher"></i>
                            <strong>Your Speaking Session will appear here.</strong>
                            <span>Confirm your practice setup and click “Start Practice”.</span>
                        </div>
                    </div>

                </div>
            </section>

            <section id="practiceEvaluationArea" class="academy-evaluation-section">
                <div class="academy-evaluation-card">
                    <div class="academy-evaluation-header">
                        <h2 class="academy-livecoach-title"><i class="fas fa-microphone-alt"></i> Performance Review</h2>
                        <p class="academy-livecoach-status mb-0">Receive detailed feedback on your pronunciation, fluency, grammar, vocabulary, and speaking confidence.</p>
                    </div>
                    <div class="academy-evaluation-body">
                        <div class="academy-step-row">
                            <div class="academy-step"><span class="academy-step-number">1</span><div><strong>Practice with your coach</strong><br><span class="text-muted">Use Olivia’s real-world conversation prompts.</span></div></div>
                            <div class="academy-step"><span class="academy-step-number">2</span><div><strong>Record your answer</strong><br><span class="text-muted">Capture your response in the browser.</span></div></div>
                            <div class="academy-step"><span class="academy-step-number">3</span><div><strong>Get a feedback report</strong><br><span class="text-muted">Review scores, strengths, and next steps.</span></div></div>
                        </div>

                        <div class="academy-info-box">
                            <i class="fas fa-info-circle"></i>
                            Complete your conversation with Olivia Clarcke, then record a short response to receive your performance review.
                        </div>

                        <div class="academy-recording-controls d-none">
                            <button type="button" id="evaluateSpeakingBtn" class="btn academy-btn-navy" disabled><i class="fas fa-clipboard-check"></i> Get Performance Review</button>
                        </div>
                        <audio id="audioPreview" class="academy-audio-preview d-none" controls></audio>
                        <p id="recordingHelp" class="small text-muted mt-2 mb-0">Exam recordings are handled automatically. Practice Mode does not require recording.</p>

                        <label for="practiceTranscript" class="form-label fw-semibold mt-4">Optional transcript for a text-only review</label>
                        <textarea id="practiceTranscript" class="form-control academy-textarea" rows="5" placeholder="Optional fallback: type or paste what you said if you cannot record audio."></textarea>
                        <div class="academy-action-row mt-3">
                            <button type="button" id="evaluatePracticeBtn" class="btn academy-btn-soft" disabled><i class="fas fa-keyboard"></i> Review Text Only</button>
                            <span id="evaluationStatus" class="small text-muted">Start a speaking session, then record your voice for pronunciation feedback.</span>
                        </div>
                        <div id="evaluationResult" class="academy-evaluation-result mt-4 d-none"></div>
                    </div>
                </div>
            </section>


            @if($practiceLessonContext)
                <div class="practice-lesson-context" data-hide-during-exam>
                    <div class="d-flex flex-wrap justify-content-between gap-2 align-items-center">
                        <div>
                            <strong><i class="fas fa-bullseye"></i> You are practicing: {{ $practiceLessonContext->title }}</strong>
                            @if($practiceLessonContext->description)
                                <p class="mb-0 mt-1 text-muted">{{ \Illuminate\Support\Str::limit(strip_tags($practiceLessonContext->description), 140) }}</p>
                            @endif
                        </div>
                        <a href="{{ route('practice-room.courses.show', [$practiceLessonContext->course, 'lesson' => $practiceLessonContext->id]) }}" class="btn academy-btn-soft">Watch Lesson</a>
                    </div>
                </div>
            @endif

            <section class="academy-card mt-4" data-hide-during-exam>
                <div class="academy-card-header">
                    <div>
                        <h2 class="academy-card-title"><i class="fas fa-book-open"></i> English Courses</h2>
                        <p class="academy-card-subtitle">Watch short lessons and continue your speaking practice.</p>
                    </div>
                </div>
                <div class="academy-card-body">
                    @if(($englishPracticeCourses ?? collect())->isNotEmpty())
                        <div class="english-course-grid">
                            @foreach($englishPracticeCourses as $course)
                                <article class="english-course-card">
                                    <div class="english-course-thumb">
                                        @if($course->thumbnail)
                                            <img src="{{ $course->thumbnail_url }}" alt="{{ $course->title }}">
                                        @else
                                            <div class="english-course-placeholder">
                                                <div>
                                                    <i class="fas fa-comments fa-2x mb-2"></i><br>
                                                    <strong>EDUCONECX</strong><br>
                                                    <span>English Practice</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="english-course-body">
                                        @if($course->level)<span class="english-course-level">{{ $course->level }}</span>@endif
                                        <h3 class="english-course-title">{{ $course->title }}</h3>
                                        <p class="english-course-desc">{{ \Illuminate\Support\Str::limit(strip_tags($course->description), 120) }}</p>
                                        <div>
                                            <div class="d-flex justify-content-between small fw-semibold mb-1">
                                                <span>Progress</span>
                                                <span>{{ $course->user_course_progress_percent }}%</span>
                                            </div>
                                            <div class="english-course-progress"><div class="english-course-progress-bar" style="width: {{ $course->user_course_progress_percent }}%"></div></div>
                                            @if($course->published_lessons_count)
                                                <p class="english-course-meta mt-2">{{ $course->user_completed_lessons_count }} of {{ $course->published_lessons_count }} completed</p>
                                            @endif
                                        </div>
                                        <a href="{{ route('practice-room.courses.show', $course) }}" class="btn academy-btn-primary mt-auto">
                                            {{ $course->user_has_progress ? 'Continue' : 'Start' }}
                                        </a>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-video fa-2x mb-3 text-muted"></i>
                            <h3>No English practice courses available yet.</h3>
                            <p class="text-muted mb-0">Please check back soon.</p>
                        </div>
                    @endif
                </div>
            </section>

            <section class="academy-card mt-4" data-hide-during-exam>
                <div class="academy-card-header">
                    <div>
                        <h2 class="academy-card-title"><i class="fas fa-history"></i> Practice History</h2>
                        <p class="academy-card-subtitle">Open this section when you want to review recent practice and exam results.</p>
                    </div>
                    <button class="btn academy-btn-soft" type="button" data-bs-toggle="collapse" data-bs-target="#practiceHistoryCollapse" aria-expanded="false" aria-controls="practiceHistoryCollapse">Practice History</button>
                </div>
                <div class="collapse" id="practiceHistoryCollapse">
                    <div class="academy-card-body academy-history-list">
                        @forelse($recentAcademySessions as $session)
                            <div class="academy-history-item">
                                <div>
                                    <strong>{{ ucfirst($session->session_type ?? 'practice') }} • {{ optional($session->created_at)->format('M d, Y') }}</strong><br>
                                    <span class="text-muted">{{ $session->scenario->title ?? $session->context_name ?? 'Speaking Session' }}</span>
                                    <div class="small text-muted mt-1">
                                        Duration: {{ $session->duration_seconds ? ceil($session->duration_seconds / 60) . ' min' : 'Active session' }}
                                        · Minutes consumed: {{ $session->duration_seconds ? ceil($session->duration_seconds / 60) : 0 }}
                                        @if($session->transcript) · Transcript saved @endif
                                        @if($session->feedback) · Feedback saved @endif
                                    </div>
                                </div>
                                <div><span class="academy-pill">{{ is_null($session->overall_score) ? 'Pending score' : number_format($session->overall_score, 1) . '/10' }}</span></div>
                            </div>
                        @empty
                            <p class="text-muted mb-0">No Practice History yet. Start Practice to create your first session.</p>
                        @endforelse
                    </div>
                </div>
            </section>
        </div>
    </main>
</div>



<script>
    const missingHeyGenConfig = @json($missingHeyGenConfig ?? []);
    const currentPracticeConfig = @json($currentAvatarConfig ?? []);
    const coachImages = {
        practice: { url: @json($isCoachImageUrl ? $coachImage : null), exists: @json($isCoachImageUrl), name: 'Olivia Clarcke', title: 'English Coach', specialty: 'Speaking Practice Specialist' },
        exam: { url: @json($isExamImageUrl ? $examImage : ($isCoachImageUrl ? $coachImage : null)), exists: @json($isExamImageUrl || $isCoachImageUrl), name: @json((config('services.heygen.exam_avatar_id') || $examCoachImage !== $practiceCoachImage) ? 'Olivia' : ($currentPracticeConfig['avatar_name'] ?? 'Olivia Clarcke')), title: 'Assessment Supervisor', specialty: 'English Speaking Exam' },
    };
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const practiceMinuteRequirement = 30;
    const examMinuteRequirement = 30;
    const isPaidMember = @json($isPaidMember ?? false);
    let practiceMinutesAvailableJs = @json($practiceMinutesAvailableJs);

    const academyPage = document.querySelector('.academy-page');
    const heroKicker = document.getElementById('academyHeroKicker');
    const heroSubtitle = document.getElementById('academyHeroSubtitle');
    const startBtn = document.getElementById('startPracticeBtn');
    const showExamRulesBtn = document.getElementById('showExamRulesBtn');
    const backToPracticeBtn = document.getElementById('backToPracticeBtn');
    const practiceMinutesAvailableJsValue = document.getElementById('practiceMinutesAvailableJsValue');
    const practiceCreditValueJsValue = document.getElementById('practiceCreditValueJsValue');
    const practiceTimeWarning = document.getElementById('practiceTimeWarning');
    const coachPhotoWrap = document.getElementById('coachPhotoWrap');
    const coachName = document.getElementById('coachName');
    const coachTitle = document.getElementById('coachTitle');
    const coachSpecialty = document.getElementById('coachSpecialty');
    const statusMessage = document.getElementById('statusMessage');
    const coachSessionArea = document.getElementById('coachSessionArea');
    const coachSessionStatus = document.getElementById('coachSessionStatus');
    const currentTopicBadge = document.getElementById('currentTopicBadge');
    const practiceTimeRemainingBadge = document.getElementById('practiceTimeRemainingBadge');
    const endSessionBtn = document.getElementById('endSessionBtn');
    const coachMount = document.getElementById('coachMount');
    const practiceTranscript = document.getElementById('practiceTranscript');
    const evaluatePracticeBtn = document.getElementById('evaluatePracticeBtn');
    const automaticExamRecorder = { addEventListener: () => {}, disabled: true };
    const automaticExamStopper = { addEventListener: () => {}, disabled: true };
    const automaticExamRetry = { addEventListener: () => {}, disabled: true };
    const evaluateSpeakingBtn = document.getElementById('evaluateSpeakingBtn');
    const audioPreview = document.getElementById('audioPreview');
    const evaluationStatus = document.getElementById('evaluationStatus');
    const evaluationResult = document.getElementById('evaluationResult');

    let academySessionId = null;
    let mediaRecorder = null;
    let audioChunks = [];
    let recordedBlob = null;
    let activeStream = null;
    let sessionMode = 'practice';
    let examSubmitted = false;
    let recordingTimer = null;
    let recordingSeconds = 0;
    let sessionStartedAt = null;
    let sessionLimitTimer = null;
    let sessionCountdownTimer = null;
    let shouldEvaluateAfterRecordingStops = false;
    let activeSessionEnded = false;
    let transcriptActive = false;
    let demoSessionLocked = false;

    const hasPracticeConfig = Boolean(currentPracticeConfig.avatar_id && !missingHeyGenConfig.length);

    const sessionCost = (mode) => mode === 'exam' ? examMinuteRequirement : practiceMinuteRequirement;
    const hasPracticeTimeFor = () => practiceMinutesAvailableJs > 0;

    const updatePracticeTimeDisplay = (balance = practiceMinutesAvailableJs, creditValue = null) => {
        practiceMinutesAvailableJs = Number(balance ?? 0);
        const resolvedCreditValue = creditValue === null ? (practiceMinutesAvailableJs * (4 / 15)) : Number(creditValue ?? 0);
        if (practiceMinutesAvailableJsValue) {
            practiceMinutesAvailableJsValue.textContent = `${practiceMinutesAvailableJs}`;
        }
        if (practiceCreditValueJsValue) {
            practiceCreditValueJsValue.textContent = resolvedCreditValue.toFixed(2);
        }
        if (practiceTimeRemainingBadge) practiceTimeRemainingBadge.textContent = `Practice Credits Left: $${resolvedCreditValue.toFixed(2)} (${practiceMinutesAvailableJs} Minutes)`;
        if (practiceTimeWarning) {
            practiceTimeWarning.classList.toggle('d-none', practiceMinutesAvailableJs > 0);
        }
        if (startBtn) {
            startBtn.disabled = !hasPracticeConfig || !hasPracticeTimeFor('practice');
        }
        if (showExamRulesBtn) {
            showExamRulesBtn.disabled = !hasPracticeConfig || !hasPracticeTimeFor('exam');
        }
    };

    const refreshPracticeTimeBalance = async () => {
        try {
            const response = await fetch("{{ route('educonecx.academy.practice-time') }}", {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                cache: 'no-store',
            });

            const data = await response.json();

            if (response.ok && data.success && typeof data.practice_minutes_available !== 'undefined') {
                updatePracticeTimeDisplay(data.practice_minutes_available, data.practice_credit_value);
            }
        } catch (error) {
            console.warn('Unable to refresh Practice Room practice time.', error);
        }
    };

    const setEvaluationStatus = (message, className = 'small text-muted') => {
        if (!evaluationStatus) return;
        evaluationStatus.textContent = message;
        evaluationStatus.className = className;
    };

    const setStatusMessage = (message, isError = false) => {
        if (!statusMessage) {
            console.warn('Practice Room status message element is missing.', message);
            return;
        }

        statusMessage.textContent = message;
        statusMessage.classList.toggle('text-danger', isError);
    };

    const updateEvaluationButtons = () => {
        const isRecording = Boolean(mediaRecorder && mediaRecorder.state === 'recording');
        const locked = sessionMode === 'exam' && examSubmitted;
        automaticExamRecorder.disabled = true;
        automaticExamStopper.disabled = !isRecording || locked;
        automaticExamRetry.disabled = true;
        evaluateSpeakingBtn.disabled = !hasPracticeConfig || !recordedBlob || locked;
        evaluatePracticeBtn.disabled = sessionMode !== 'exam' || !hasPracticeConfig || locked;
    };

    const escapeHtml = (value) => String(value ?? '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');

    const renderScore = (label, value, isOverall = false) => `
        <div class="academy-score-box ${isOverall ? 'academy-score-box--overall' : ''}">
            <span>${label}</span>
            <strong>${value === null || value === undefined ? 'N/A' : `${Number(value).toFixed(1)}/10`}</strong>
        </div>
    `;

    const renderList = (title, items, icon = 'fa-circle-check') => `
        <div class="academy-evaluation-list">
            <h5><i class="fas ${icon}"></i> ${title}</h5>
            ${(items || []).length
                ? `<ul>${items.map(item => `<li>${escapeHtml(item)}</li>`).join('')}</ul>`
                : '<p class="text-muted mb-0">No items provided.</p>'}
        </div>
    `;

    const renderCorrections = (corrections) => {
        if (!corrections || !corrections.length) {
            return '<p class="text-muted mb-0">No grammar corrections needed. Great work!</p>';
        }

        return `<div class="academy-corrections">${corrections.map(item => `
            <div class="academy-correction-item">
                <p class="mb-1"><strong>Original:</strong> ${escapeHtml(item.original)}</p>
                <p class="mb-1"><strong>Corrected:</strong> ${escapeHtml(item.corrected)}</p>
                <p class="mb-0 text-muted">${escapeHtml(item.explanation)}</p>
            </div>
        `).join('')}</div>`;
    };

    const renderEvaluation = (evaluation) => {
        if (evaluation.transcript) {
            practiceTranscript.value = evaluation.transcript;
        }

        evaluationResult.classList.remove('d-none');
        evaluationResult.innerHTML = `
            ${evaluation.transcript ? `
                <div class="academy-evaluation-panel mb-3">
                    <h5><i class="fas fa-align-left"></i> Transcript</h5>
                    <p class="mb-0">${escapeHtml(evaluation.transcript)}</p>
                </div>
            ` : ''}
            <div class="academy-score-grid">
                ${renderScore('Overall', evaluation.overall_score, true)}
                ${renderScore('Pronunciation', evaluation.pronunciation_score)}
                ${renderScore('Grammar', evaluation.grammar_score)}
                ${renderScore('Fluency', evaluation.fluency_score)}
                ${renderScore('Vocabulary', evaluation.vocabulary_score)}
                ${renderScore('Confidence', evaluation.confidence_score)}
            </div>
            ${evaluation.pronunciation_feedback
                ? `<div class="academy-evaluation-panel mt-3"><h5><i class="fas fa-volume-up"></i> Pronunciation Feedback</h5><p class="mb-0">${escapeHtml(evaluation.pronunciation_feedback)}</p></div>`
                : ''}
            ${evaluation.pronunciation_note
                ? `<div class="alert alert-warning mt-3 mb-0">${escapeHtml(evaluation.pronunciation_note)}</div>`
                : ''}
            <div class="academy-evaluation-panel mt-3">
                <h5><i class="fas fa-edit"></i> Corrections</h5>
                ${renderCorrections(evaluation.corrections)}
            </div>
            <div class="row g-3 mt-1">
                <div class="col-md-6">${renderList('Strengths', evaluation.strengths, 'fa-circle-check')}</div>
                <div class="col-md-6">${renderList('Weaknesses', evaluation.weaknesses, 'fa-triangle-exclamation')}</div>
            </div>
            <div class="academy-evaluation-panel mt-3">
                <h5><i class="fas fa-comment-dots"></i> Feedback</h5>
                <p class="mb-0">${escapeHtml(evaluation.feedback)}</p>
            </div>
            <div class="mt-3">${renderList('Next Steps', evaluation.next_steps, 'fa-route')}</div>
        `;
    };

    const stopMicrophone = () => {
        if (activeStream) {
            activeStream.getTracks().forEach(track => track.stop());
            activeStream = null;
        }
    };

    const stopMediaRecorder = (evaluateExam = false) => {
        shouldEvaluateAfterRecordingStops = Boolean(evaluateExam && sessionMode === 'exam');
        if (mediaRecorder && mediaRecorder.state === 'recording') {
            mediaRecorder.stop();
            return true;
        }
        stopMicrophone();
        return false;
    };

    const stopTranscript = () => {
        transcriptActive = false;
        if (practiceTranscript) practiceTranscript.readOnly = sessionMode === 'exam';
    };

    const clearSessionTimers = () => {
        if (sessionLimitTimer) {
            clearTimeout(sessionLimitTimer);
            sessionLimitTimer = null;
        }
        if (sessionCountdownTimer) {
            clearInterval(sessionCountdownTimer);
            sessionCountdownTimer = null;
        }
        if (recordingTimer) {
            clearInterval(recordingTimer);
            recordingTimer = null;
        }
    };

    const closeAvatarTransport = () => {
        document.querySelectorAll('#coachMount iframe, #freeDemoAvatarFrame iframe').forEach(frame => {
            try { frame.src = 'about:blank'; } catch (_) {}
            frame.remove();
        });
        window.dispatchEvent(new CustomEvent('academy-avatar-force-stop'));
    };

    const destroyAvatarSession = (message = 'Session ended.') => {
        closeAvatarTransport();
        if (coachMount) {
            coachMount.innerHTML = `<div class="academy-livecoach-placeholder"><i class="fas fa-check-circle"></i><strong>${escapeHtml(message)}</strong></div>`;
        }
    };

    const terminateLiveSessionResources = (options = {}) => {
        const evaluateExam = Boolean(options.evaluateExam);
        const keepTranscript = Boolean(options.keepTranscript);
        const stoppedForEvaluation = stopMediaRecorder(evaluateExam);
        stopMicrophone();
        if (!keepTranscript && sessionMode !== 'exam') {
            if (practiceTranscript) practiceTranscript.value = '';
        }
        stopTranscript();
        clearSessionTimers();
        closeAvatarTransport();
        updateEvaluationButtons();
        return stoppedForEvaluation;
    };

    const resetRecording = () => {
        if (recordingTimer) {
            clearInterval(recordingTimer);
            recordingTimer = null;
        }
        recordingSeconds = 0;
        recordedBlob = null;
        audioChunks = [];
        if (audioPreview.src) {
            URL.revokeObjectURL(audioPreview.src);
        }
        audioPreview.removeAttribute('src');
        audioPreview.load();
        audioPreview.classList.add('d-none');
        setEvaluationStatus('Recording reset. You can start again.', 'small text-muted');
        updateEvaluationButtons();
    };

    const startAutomaticExamRecording = async () => {
        if (!hasPracticeConfig || sessionMode !== 'exam') {
            return;
        }

        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            setEvaluationStatus('Audio recording is not supported in this browser.', 'small text-danger');
            return;
        }

        try {
            resetRecording();
            activeStream = await navigator.mediaDevices.getUserMedia({ audio: true });
            mediaRecorder = new MediaRecorder(activeStream);

            mediaRecorder.addEventListener('dataavailable', event => {
                if (event.data && event.data.size > 0) {
                    audioChunks.push(event.data);
                }
            });

            mediaRecorder.addEventListener('stop', () => {
                if (recordingTimer) {
                    clearInterval(recordingTimer);
                    recordingTimer = null;
                }
                recordedBlob = new Blob(audioChunks, { type: 'audio/webm' });
                audioPreview.src = URL.createObjectURL(recordedBlob);
                audioPreview.classList.add('d-none');
                if (activeStream) {
                    activeStream.getTracks().forEach(track => track.stop());
                }
                activeStream = null;
                transcriptActive = false;
                setEvaluationStatus('Recording stopped. Preparing your exam evaluation.', 'small text-muted');
                updateEvaluationButtons();

                if (shouldEvaluateAfterRecordingStops && sessionMode === 'exam') {
                    shouldEvaluateAfterRecordingStops = false;
                    evaluateSpeakingBtn.click();
                }
            });

            mediaRecorder.start();
            recordingTimer = setInterval(() => {
                recordingSeconds += 1;
                setEvaluationStatus(`Exam recording in progress... ${String(Math.floor(recordingSeconds / 60)).padStart(2, '0')}:${String(recordingSeconds % 60).padStart(2, '0')}`, 'small text-danger');
            }, 1000);
            setEvaluationStatus('Exam recording in progress... 00:00', 'small text-danger');
            updateEvaluationButtons();
        } catch (error) {
            console.error('Automatic exam recording error:', error);
            setEvaluationStatus('Please allow microphone access so the exam can be recorded automatically.', 'small text-danger');
            if (activeStream) {
                activeStream.getTracks().forEach(track => track.stop());
                activeStream = null;
            }
            updateEvaluationButtons();
        }
    };

    automaticExamRecorder.addEventListener('click', startAutomaticExamRecording);

    automaticExamStopper.addEventListener('click', function () {
        if (mediaRecorder && mediaRecorder.state === 'recording') {
            mediaRecorder.stop();
        }
    });

    automaticExamRetry.addEventListener('click', function () {
        if (sessionMode === 'exam' && examSubmitted) {
            setEvaluationStatus('This exam attempt is locked after final submission.', 'small text-danger');
            return;
        }
        resetRecording();
    });

    evaluateSpeakingBtn.addEventListener('click', async function () {
        if (!recordedBlob) {
            setEvaluationStatus('Please record your voice before requesting pronunciation evaluation.', 'small text-danger');
            return;
        }

        setEvaluationStatus('Uploading audio...', 'small text-muted');
        evaluateSpeakingBtn.disabled = true;
        automaticExamRecorder.disabled = true;

        try {
            const formData = new FormData();
            formData.append('audio', recordedBlob, 'practice.webm');
            formData.append('academy_session_id', academySessionId || '');
            formData.append('session_type', sessionMode);

            setEvaluationStatus('Preparing your performance review...', 'small text-muted');

            const response = await fetch("{{ route('educonecx.academy.session.evaluate.audio') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: formData,
            });

            const data = await response.json();

            if (!response.ok || !data.success) {
                const validationMessage = data.errors ? Object.values(data.errors).flat().join(' ') : null;
                throw new Error(validationMessage || data.message || 'Unable to evaluate this recording right now.');
            }

            renderEvaluation(data.evaluation);
            if (sessionMode === 'exam') {
                examSubmitted = true;
                setEvaluationStatus('Exam submitted. This attempt is now locked.', 'small text-success');
            } else {
                setEvaluationStatus('Evaluation complete', 'small text-success');
            }
        } catch (error) {
            console.error('review service audio evaluation error:', error);
            setEvaluationStatus(error.message || 'Unable to evaluate this recording right now.', 'small text-danger');
        } finally {
            updateEvaluationButtons();
        }
    });

    evaluatePracticeBtn.addEventListener('click', async function () {
        const transcript = practiceTranscript.value.trim();
        if (transcript.length < 10) {
            setEvaluationStatus('Please enter at least 10 characters from your practice.', 'small text-danger');
            return;
        }

        setEvaluationStatus('Preparing your performance review...', 'small text-muted');
        evaluatePracticeBtn.disabled = true;

        try {
            const response = await fetch("{{ route('educonecx.academy.session.evaluate') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    academy_session_id: academySessionId,
                    transcript,
                    session_type: sessionMode,
                }),
            });

            const data = await response.json();

            if (!response.ok || !data.success) {
                const validationMessage = data.errors ? Object.values(data.errors).flat().join(' ') : null;
                throw new Error(validationMessage || data.message || 'Unable to prepare your feedback report right now.');
            }

            renderEvaluation(data.evaluation);
            if (sessionMode === 'exam') {
                examSubmitted = true;
                setEvaluationStatus('Exam submitted. This attempt is now locked.', 'small text-success');
            } else {
                setEvaluationStatus('Evaluation complete', 'small text-success');
            }
        } catch (error) {
            console.error('review service text evaluation error:', error);
            setEvaluationStatus(error.message || 'Unable to prepare your feedback report right now.', 'small text-danger');
        } finally {
            updateEvaluationButtons();
        }
    });

    const updateModeMessaging = () => {
        const isExam = sessionMode === 'exam';
        const coach = coachImages[isExam ? 'exam' : 'practice'];
        coachName.textContent = coach.name;
        coachTitle.textContent = coach.title;
        coachSpecialty.textContent = coach.specialty;
        coachPhotoWrap.innerHTML = coach.exists
            ? `<img src="${coach.url}" alt="${coach.name}, ${coach.title}" loading="lazy">`
            : '<div class="academy-coach-placeholder"><i class="fas fa-user-tie"></i></div>';
        academyPage?.classList.toggle('academy-exam-active', isExam);
        if (heroKicker) heroKicker.textContent = isExam ? 'Formal Speaking Assessment' : 'Interactive English Speaking Practice';
        document.querySelector('.academy-hero-title').textContent = isExam ? 'English Speaking Exam' : 'Practice Room';
        if (heroSubtitle) {
            heroSubtitle.textContent = isExam
                ? 'Focus only on your timed assessment. The extra practice cards, purchases, courses, and history are hidden so the page stays clean while Olivia supervises your exam.'
                : 'Practice English in real time with your English Coach, Olivia Clarcke, then receive guided feedback on pronunciation, grammar, fluency, vocabulary, and speaking confidence.';
        }
        coachSessionStatus.innerHTML = isExam
            ? '<span class="academy-status-dot"></span>Start a formal English Speaking Exam with Olivia, Assessment Supervisor.'
            : '<span class="academy-status-dot"></span>Start a live speaking session with Olivia Clarcke and practice real-world English conversations.';
        document.querySelectorAll('.academy-step-row .academy-step:first-child strong').forEach(el => {
            el.textContent = isExam ? 'Complete your exam response' : 'Practice with your coach';
        });
        document.querySelector('.academy-info-box').innerHTML = isExam
            ? '<i class="fas fa-info-circle"></i> Complete your exam with Olivia. Recording, transcript, timer, and AI evaluation run automatically; after submission, the attempt is locked.'
            : '<i class="fas fa-info-circle"></i> Complete your conversation with Olivia Clarcke, then record a short response to receive your performance review.';
    };

    const startSpeakingSession = async (mode = 'practice') => {
        if (!hasPracticeConfig) {
            setStatusMessage('Please complete your Coach Settings before starting.', true);
            return;
        }

        if (!hasPracticeTimeFor(mode)) {
            setStatusMessage('You have used all of your available practice sessions. Please purchase additional practice sessions to continue learning with your English Coach.', true);
            updatePracticeTimeDisplay();
            return;
        }

        sessionMode = mode;
        activeSessionEnded = false;
        examSubmitted = false;
        transcriptActive = mode === 'exam';
        if (practiceTranscript) practiceTranscript.readOnly = mode === 'exam';
        resetRecording();
        updateModeMessaging();

        setStatusMessage(mode === 'exam' ? 'Preparing your English Speaking Exam...' : 'Preparing your Speaking Session...');
        coachSessionStatus.innerHTML = '<span class="academy-status-dot"></span>Preparing your session...';
        startBtn.disabled = true;
        showExamRulesBtn.disabled = true;

        try {
            const response = await fetch("{{ route('educonecx.academy.liveavatar.embed') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ session_type: mode }),
            });

            const responseText = await response.text();
            let data = {};

            try {
                data = responseText ? JSON.parse(responseText) : {};
            } catch (e) {
                throw new Error('Server returned an unexpected response. Please refresh and try again.');
            }

            if (!response.ok || !data.success) {
                if (data.type === 'insufficient_practice_time') {
                    updatePracticeTimeDisplay(data.balance, data.practice_credit_value);
                    throw new Error(data.message || 'You have used all of your available practice sessions. Please purchase additional practice sessions to continue learning with your English Coach.');
                }
                throw new Error(data.message || 'Unable to load your speaking session.');
            }

            academySessionId = data.academy_session_id || null;
            sessionStartedAt = Date.now();
            clearSessionTimers();
            const maxMinutes = Math.min(sessionCost(mode), Number(data.max_minutes || practiceMinutesAvailableJs || 0));
            if (maxMinutes > 0) {
                const deadline = Date.now() + (maxMinutes * 60 * 1000);
                sessionLimitTimer = setTimeout(() => endActiveSession(true), maxMinutes * 60 * 1000);
                sessionCountdownTimer = setInterval(() => {
                    const secondsLeft = Math.max(0, Math.ceil((deadline - Date.now()) / 1000));
                    if (practiceTimeRemainingBadge) practiceTimeRemainingBadge.textContent = `Session Time Left: ${Math.floor(secondsLeft / 60)}:${String(secondsLeft % 60).padStart(2, '0')}`;
                    if (secondsLeft <= 0) endActiveSession(true);
                }, 1000);
            }
            if (mode === 'exam') {
                setTimeout(() => startAutomaticExamRecording(), 500);
            }
            if (typeof data.practice_minutes_available !== 'undefined') {
                updatePracticeTimeDisplay(data.practice_minutes_available, data.practice_credit_value);
            }
            const openSessionLink = document.getElementById('openSessionLink');
            const currentTopic = @json($practiceLessonContext?->title ?? 'General English');
            if (currentTopicBadge) currentTopicBadge.textContent = `Current Topic: ${mode === 'exam' ? 'Speaking Assessment' : currentTopic}`;

            if (!data.embed_url) {
                throw new Error('Speaking session link missing.');
            }

            coachSessionArea.classList.remove('d-none');
            coachMount.innerHTML = `
                <iframe
                    src="${data.embed_url}"
                    title="Speaking Session"
                    allow="microphone; camera; autoplay; fullscreen; clipboard-read; clipboard-write"
                    allowfullscreen
                    loading="eager"
                ></iframe>
            `;

            openSessionLink.href = data.embed_url;
            openSessionLink.classList.remove('d-none');
            endSessionBtn?.classList.remove('d-none');

            setStatusMessage(mode === 'exam' ? 'English Speaking Exam is ready.' : 'Speaking Session is ready.');
            coachSessionStatus.innerHTML = mode === 'exam'
                ? '<span class="academy-status-dot"></span>Olivia is ready. Complete the exam carefully before final submission.'
                : '<span class="academy-status-dot"></span>Your English Coach is ready. Click Chat Now and allow microphone access to begin your speaking session.';
            setEvaluationStatus(mode === 'exam' ? 'Recording starts automatically for Exam Mode. Your AI evaluation is generated when the exam ends.' : 'Practice Mode is for live coaching only. No performance report will be generated.');
            updateEvaluationButtons();

            setTimeout(() => {
                coachSessionArea.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 300);
        } catch (error) {
            console.error('speaking session embed error:', error);
            if (mode === 'exam') {
                sessionMode = 'practice';
                updateModeMessaging();
            }
            setStatusMessage(error.message || 'Unable to load your speaking session.', true);
            coachSessionStatus.innerHTML = '<span class="academy-status-dot"></span>Ready';
        } finally {
            updatePracticeTimeDisplay();
        }
    };

    const endActiveSession = async (limitReached = false) => {
        if (!academySessionId || activeSessionEnded) return;
        activeSessionEnded = true;
        const endingSessionId = academySessionId;
        const durationSeconds = sessionStartedAt ? Math.max(1, Math.ceil((Date.now() - sessionStartedAt) / 1000)) : 60;
        const shouldAutoEvaluateExam = sessionMode === 'exam';
        const stoppedRecorder = terminateLiveSessionResources({ evaluateExam: shouldAutoEvaluateExam, keepTranscript: shouldAutoEvaluateExam });
        destroyAvatarSession(limitReached ? 'Practice time ended.' : 'Session ended.');
        endSessionBtn?.classList.add('d-none');

        try {
            const response = await fetch(@json(route('educonecx.academy.session.end')), {
                method:'POST',
                headers:{'Content-Type':'application/json','X-CSRF-TOKEN':csrfToken,'Accept':'application/json'},
                body: JSON.stringify({
                    academy_session_id: endingSessionId,
                    duration_seconds: durationSeconds,
                    status: limitReached ? 'limit_reached' : 'ended',
                    transcript: practiceTranscript?.value || ''
                })
            });
            const data = await response.json().catch(() => ({}));
            if (typeof data.practice_minutes_available !== 'undefined') updatePracticeTimeDisplay(data.practice_minutes_available, data.practice_credit_value);
        } catch (error) {
            console.error('session end error:', error);
        }

        if (limitReached) {
            setStatusMessage('You have used all of your available practice sessions. Please purchase additional practice sessions to continue learning with your English Coach.', true);
            coachSessionStatus.innerHTML = '<span class="academy-status-dot"></span>Practice time ended. Purchase additional Practice Sessions to continue.';
        }

        if (shouldAutoEvaluateExam && recordedBlob && !stoppedRecorder) {
            evaluateSpeakingBtn?.click();
        }
    };


    const returnToPracticeMode = async () => {
        const wasExamSessionActive = sessionMode === 'exam' && academySessionId && !activeSessionEnded;

        if (wasExamSessionActive) {
            await endActiveSession(false);
        }

        sessionMode = 'practice';
        examSubmitted = false;
        transcriptActive = false;
        shouldEvaluateAfterRecordingStops = false;
        if (practiceTranscript) practiceTranscript.readOnly = false;
        resetRecording();
        updateModeMessaging();
        coachSessionArea?.classList.add('d-none');
        endSessionBtn?.classList.add('d-none');

        const openSessionLink = document.getElementById('openSessionLink');
        openSessionLink?.classList.add('d-none');
        if (openSessionLink) openSessionLink.href = '#';

        if (coachMount) {
            coachMount.innerHTML = `
                <div class="academy-livecoach-placeholder">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <strong>Your Speaking Session will appear here.</strong>
                    <span>Confirm your practice setup and click “Start Practice”.</span>
                </div>
            `;
        }

        setStatusMessage('Practice mode is ready.');
        setEvaluationStatus('Start a speaking session, then record your voice for pronunciation feedback.');
        updatePracticeTimeDisplay();
    };

    endSessionBtn?.addEventListener('click', () => endActiveSession(false));
    startBtn?.addEventListener('click', () => startSpeakingSession('practice'));
    showExamRulesBtn?.addEventListener('click', () => startSpeakingSession('exam'));
    backToPracticeBtn?.addEventListener('click', () => returnToPracticeMode());

    let packageQty = 1;
    const updatePackageTotal = () => {
        document.getElementById('packageQty') && (document.getElementById('packageQty').textContent = packageQty);
        document.getElementById('packageTotal') && (document.getElementById('packageTotal').textContent = `$${packageQty * 10}`);
    };
    document.getElementById('decreasePackageQty')?.addEventListener('click', () => { packageQty = Math.max(1, packageQty - 1); updatePackageTotal(); });
    document.getElementById('increasePackageQty')?.addEventListener('click', () => { packageQty += 1; updatePackageTotal(); });
    document.getElementById('purchasePracticeSessionsBtn')?.addEventListener('click', async () => {
        const response = await fetch(@json(route('educonecx.academy.practice-sessions.purchase')), {method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':csrfToken,'Accept':'application/json'}, body: JSON.stringify({quantity: packageQty})});
        const data = await response.json();
        if (data.checkout_url) window.location.href = data.checkout_url; else setStatusMessage(data.message || 'Unable to start checkout.', true);
    });

    document.getElementById('startFreeDemoBtn')?.addEventListener('click', async () => {
        const frame = document.getElementById('freeDemoAvatarFrame');
        const button = document.getElementById('startFreeDemoBtn');
        button.disabled = true;
        try {
            const response = await fetch(@json(route('educonecx.academy.liveavatar.free-demo')), {method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':csrfToken,'Accept':'application/json'}, body: JSON.stringify({})});
            const data = await response.json();
            if (!response.ok || !data.success || !data.embed_url) throw new Error(data.message || 'Unable to start the guided avatar demo.');
            frame.classList.remove('d-none');
            demoSessionLocked = false;
            frame.innerHTML = `<iframe src="${data.embed_url}" title="Olivia guided onboarding demo" allow="autoplay; fullscreen" sandbox="allow-scripts allow-same-origin allow-popups allow-forms" allowfullscreen loading="eager"></iframe>`;
        } catch (error) {
            button.disabled = false;
            setStatusMessage(error.message || 'Unable to start the guided avatar demo.', true);
        }
    });
    document.getElementById('freeDemoSubmit')?.addEventListener('click', () => {
        const name = (document.getElementById('freeDemoName')?.value || '').trim() || 'there';
        const box = document.getElementById('freeDemoMessage');
        box.textContent = `Hello ${name}, thank you for joining our platform. I am Olivia Clarcke your English Coach. I can help you improve your English speaking, listening, pronunciation, vocabulary, and confidence through interactive practice sessions. Upgrade your membership to unlock full access and start practicing with me.`;
        box.classList.remove('d-none');
        document.getElementById('freeDemoName').disabled = true;
        document.getElementById('freeDemoSubmit').disabled = true;
        demoSessionLocked = true;
        const frame = document.getElementById('freeDemoAvatarFrame');
        if (frame) {
            frame.querySelectorAll('iframe').forEach(iframe => { try { iframe.src = 'about:blank'; } catch (_) {} iframe.remove(); });
            frame.innerHTML = '<div class="academy-livecoach-placeholder"><i class="fas fa-lock"></i><strong>Demo session ended.</strong><span>Upgrade Membership to continue.</span><a class="btn academy-btn-primary mt-3" href="{{ route('subscription.plans') }}">Upgrade Membership</a></div>';
        }
    });

    updatePracticeTimeDisplay();
    refreshPracticeTimeBalance();

    if (missingHeyGenConfig.length) {
        setStatusMessage('Practice Room is not ready yet. Please contact support to complete setup.', true);
    } else if (!hasPracticeConfig) {
        setStatusMessage('Please complete your Coach Settings before starting practice.', true);
    } else {
        setStatusMessage('Ready to start your speaking session.');
        setEvaluationStatus('Start a speaking session, then record your voice for pronunciation feedback.');
    }

    updateEvaluationButtons();
</script>
@endsection
