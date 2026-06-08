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

    .academy-coach-preview img {
        width: 100%;
        height: 100%;
        min-height: 230px;
        object-fit: cover;
        display: block;
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
    .academy-media-frame video, .academy-media-frame img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .academy-actions-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 18px; margin-bottom: 24px; }
    .academy-action-card { width: 100%; min-width: 0; background: #fff; border: 1px solid var(--academy-border); border-radius: 18px; padding: 22px; box-shadow: var(--academy-soft-shadow); display: flex; flex-direction: column; gap: 14px; min-height: 100%; }
    .academy-action-card h3 { color: var(--academy-navy); font-size: 1.12rem; font-weight: 900; margin: 0; }
    .academy-action-card p { color: var(--academy-muted); margin: 0; line-height: 1.5; overflow-wrap: anywhere; }
    .academy-action-icon { width: 48px; height: 48px; border-radius: 15px; display: inline-flex; align-items: center; justify-content: center; background: var(--academy-ivory); color: var(--academy-navy); font-size: 1.2rem; }
    .academy-action-card .btn { width: 100%; justify-content: center; margin-top: auto; }
    .academy-credit-value { display: block; color: var(--academy-navy); font-size: clamp(1.8rem, 5vw, 2.6rem); font-weight: 950; line-height: 1; }
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

        .academy-score-grid {
            grid-template-columns: repeat(auto-fit, minmax(145px, 1fr));
        }

        .academy-actions-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .academy-intro-grid { grid-template-columns: 1fr; }
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
            <div class="academy-kicker">Interactive English Speaking Practice</div>
            <h1 class="academy-hero-title">Practice Room</h1>
            <p class="academy-hero-subtitle">Practice English in real time with your English Coach, Victoria Clarke, then receive guided feedback on pronunciation, grammar, fluency, vocabulary, and speaking confidence.</p>
            <div class="academy-badge-row">
                <span class="academy-hero-badge"><i class="fas fa-chalkboard-teacher"></i> Victoria Clarke</span>
                <span class="academy-hero-badge"><i class="fas fa-microphone-alt"></i> Speaking Practice</span>
                <span class="academy-hero-badge"><i class="fas fa-chart-line"></i> Performance Feedback</span>
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
                    && ! empty($currentPracticeConfig['context_id'])
                    && empty($missingHeyGenConfig);
                $coachImage = $practiceCoachImage
                    ?? data_get($currentAvatarConfig, 'avatar_image_url')
                    ?? data_get($currentAvatarConfig, 'image_url')
                    ?? asset('images/academy/victoria-clarke.jpg');
                $examImage = $examCoachImage ?? null;
            @endphp


            <section class="academy-card academy-intro-card">
                <div class="academy-card-body">
                    <div class="academy-intro-grid">
                        <div>
                            <h2 class="academy-intro-title">Welcome to the Practice Room</h2>
                            <p class="academy-card-subtitle mb-3">Choose a friendly practice session for learning, or start a formal English Speaking Exam when you are ready to be assessed.</p>
                            <div class="academy-badge-row">
                                <span class="academy-pill"><i class="fas fa-user-graduate"></i> Practice for improvement</span>
                                <span class="academy-pill"><i class="fas fa-lock"></i> Exam attempts lock after submission</span>
                            </div>
                        </div>
                        <div class="academy-media-frame">
                            @if(! empty($introVideoUrl))
                                <video src="{{ $introVideoUrl }}" controls playsinline preload="metadata" @if(! empty($coachImage)) poster="{{ $coachImage }}" @endif></video>
                            @elseif(! empty($coachImage))
                                <img src="{{ $coachImage }}" alt="Victoria Clarke welcomes you to the Practice Room" loading="lazy">
                            @else
                                <div class="academy-coach-placeholder"><i class="fas fa-user-tie"></i></div>
                            @endif
                        </div>
                    </div>
                </div>
            </section>

            <section class="academy-actions-grid" aria-label="Practice Room actions">
                <article class="academy-action-card">
                    <span class="academy-action-icon"><i class="fas fa-comments"></i></span>
                    <h3>Start Practice</h3>
                    <p>Learn with Victoria Clarke in a friendly session. You may retry recordings before requesting your performance review.</p>
                    <button type="button" id="startPracticeBtn" class="btn academy-btn-primary btn-lg" {{ ! $canStartPractice ? 'disabled' : '' }}>
                        <i class="fas fa-play"></i> Start Practice
                    </button>
                </article>
                <article class="academy-action-card">
                    <span class="academy-action-icon"><i class="fas fa-clipboard-check"></i></span>
                    <h3>Take Exam</h3>
                    <p>Begin a formal English Speaking Exam with Olivia. Final submissions are saved and locked in your dashboard.</p>
                    <button type="button" id="showExamRulesBtn" class="btn academy-btn-navy btn-lg" {{ ! $canStartPractice ? 'disabled' : '' }}>
                        <i class="fas fa-award"></i> Take Exam
                    </button>
                </article>
                <article class="academy-action-card">
                    <span class="academy-action-icon"><i class="fas fa-coins"></i></span>
                    <h3>Credits Available</h3>
                    <span class="academy-credit-value">{{ $creditsAvailable }}</span>
                    <p>Your current balance is shown here. Pricing options will be added later.</p>
                </article>
            </section>

            <section id="examRulesArea" class="academy-exam-rules mb-4 d-none">
                <h3>English Speaking Exam Rules</h3>
                <ul class="mb-3">
                    <li>This is a formal speaking assessment.</li>
                    <li>You must complete your response before submission.</li>
                    <li>Once submitted, you cannot retry or edit the attempt.</li>
                    <li>Your score will be saved in your dashboard.</li>
                    <li>Make sure your microphone works before starting.</li>
                </ul>
                <button type="button" id="confirmExamBtn" class="btn academy-btn-primary" data-bs-toggle="modal" data-bs-target="#examConfirmModal"><i class="fas fa-play"></i> Start Exam</button>
            </section>

            <section class="academy-card mb-4">
                <div class="academy-card-header">
                    <h2 class="academy-card-title"><i class="fas fa-chalkboard-teacher"></i> Current Practice Setup</h2>
                    <p class="academy-card-subtitle">Meet your English Coach and prepare for a focused speaking practice session.</p>
                </div>
                <div class="academy-card-body">
                    <div class="academy-setup-grid">
                        <div class="academy-coach-card">
                            <div class="academy-coach-preview academy-coach-photo" id="coachPhotoWrap">
                                @if(! empty($coachImage))
                                    <img src="{{ $coachImage }}" alt="Victoria Clarke, English Coach" loading="lazy">
                                @else
                                    <div class="academy-coach-placeholder"><i class="fas fa-user-tie"></i></div>
                                @endif
                            </div>
                            <div class="academy-coach-info">
                                <h3 id="coachName">Victoria Clarke</h3>
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

                            <div class="academy-action-row mt-2">
                                <a href="{{ route('dashboard.educonecx-academy.index') }}#coach-settings" class="btn academy-btn-soft">
                                    <i class="fas fa-sliders-h"></i> Coach Settings
                                </a>
                                <span id="statusMessage" class="academy-status-message"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="coachSessionArea" class="academy-livecoach-section d-none">
                <div class="academy-livecoach-card">
                    <div class="academy-livecoach-header">
                        <div>
                            <h2 class="academy-livecoach-title"><i class="fas fa-video"></i> Speaking Session</h2>
                            <p class="academy-livecoach-status" id="coachSessionStatus"><span class="academy-status-dot"></span>Start a live speaking session with Victoria Clarke and practice real-world English conversations.</p>
                        </div>
                        <a id="openSessionLink" href="#" target="_blank" rel="noopener" class="btn academy-btn-soft d-none">
                            <i class="fas fa-external-link-alt"></i> Open Session
                        </a>
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
                        <h2 class="academy-livecoach-title"><i class="fas fa-microphone-alt"></i> Speaking Performance Review</h2>
                        <p class="academy-livecoach-status mb-0">Receive detailed feedback on your pronunciation, fluency, grammar, vocabulary, and speaking confidence.</p>
                    </div>
                    <div class="academy-evaluation-body">
                        <div class="academy-step-row">
                            <div class="academy-step"><span class="academy-step-number">1</span><div><strong>Practice with your coach</strong><br><span class="text-muted">Use Victoria’s real-world conversation prompts.</span></div></div>
                            <div class="academy-step"><span class="academy-step-number">2</span><div><strong>Record your answer</strong><br><span class="text-muted">Capture your response in the browser.</span></div></div>
                            <div class="academy-step"><span class="academy-step-number">3</span><div><strong>Get a feedback report</strong><br><span class="text-muted">Review scores, strengths, and next steps.</span></div></div>
                        </div>

                        <div class="academy-info-box">
                            <i class="fas fa-info-circle"></i>
                            Complete your conversation with Victoria Clarke, then record a short response to receive your performance review.
                        </div>

                        <div class="academy-recording-controls">
                            <button type="button" id="startRecordingBtn" class="btn academy-btn-primary" disabled><i class="fas fa-microphone-alt"></i> Start Recording</button>
                            <button type="button" id="stopRecordingBtn" class="btn academy-btn-danger" disabled><i class="fas fa-stop"></i> Stop Recording</button>
                            <button type="button" id="retryRecordingBtn" class="btn academy-btn-soft" disabled><i class="fas fa-redo"></i> Retry Recording</button>
                            <button type="button" id="evaluateSpeakingBtn" class="btn academy-btn-navy" disabled><i class="fas fa-clipboard-check"></i> Get Performance Review</button>
                        </div>
                        <audio id="audioPreview" class="academy-audio-preview d-none" controls></audio>
                        <p id="recordingHelp" class="small text-muted mt-2 mb-0">If your browser blocks simultaneous microphone access, please finish the speaking session first, then record your answer for evaluation.</p>

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


            <section class="academy-card mt-4">
                <div class="academy-card-header">
                    <div>
                        <h2 class="academy-card-title"><i class="fas fa-book-open"></i> Academy Course Area</h2>
                        <p class="academy-card-subtitle">Prepared space for upcoming English course videos and lesson practice.</p>
                    </div>
                </div>
                <div class="academy-card-body">
                    <div class="academy-actions-grid mb-0">
                        <article class="academy-action-card">
                            <span class="academy-action-icon"><i class="fas fa-graduation-cap"></i></span>
                            <h3>Course title</h3>
                            <p>English Speaking Foundations</p>
                        </article>
                        <article class="academy-action-card">
                            <span class="academy-action-icon"><i class="fas fa-layer-group"></i></span>
                            <h3>Module title</h3>
                            <p>Clear Pronunciation and Confident Conversation</p>
                        </article>
                        <article class="academy-action-card">
                            <span class="academy-action-icon"><i class="fas fa-video"></i></span>
                            <h3>Lesson title</h3>
                            <p>Lesson practice video</p>
                            <a href="{{ route('educonecx.academy.index') }}" class="btn academy-btn-soft">Practice This Lesson</a>
                        </article>
                    </div>
                </div>
            </section>

            <section class="academy-card mt-4">
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
                                <div><strong>{{ ucfirst($session->session_type ?? 'practice') }} • {{ optional($session->created_at)->format('M d, Y') }}</strong><br><span class="text-muted">{{ $session->scenario->title ?? $session->context_name ?? 'Speaking Session' }}</span></div>
                                <div><span class="academy-pill">{{ is_null($session->overall_score) ? 'In progress' : number_format($session->overall_score, 1) . '/10' }}</span></div>
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



    <div class="modal fade" id="examConfirmModal" tabindex="-1" aria-labelledby="examConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="examConfirmModalLabel">Are you ready to start the exam?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Olivia will supervise a formal English Speaking Exam. After your final performance review is submitted, the attempt will be locked.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn academy-btn-soft" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="startExamBtn" class="btn academy-btn-primary" data-bs-dismiss="modal">Start Exam</button>
                </div>
            </div>
        </div>
    </div>

<script>
    const missingHeyGenConfig = @json($missingHeyGenConfig ?? []);
    const currentPracticeConfig = @json($currentAvatarConfig ?? []);
    const coachImages = {
        practice: { url: @json($coachImage), exists: @json(! empty($coachImage)), name: 'Victoria Clarke', title: 'English Coach', specialty: 'Speaking Practice Specialist' },
        exam: { url: @json($examImage), exists: @json(! empty($examImage)), name: 'Olivia', title: 'Assessment Supervisor', specialty: 'English Speaking Exam' },
    };
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const startBtn = document.getElementById('startPracticeBtn');
    const showExamRulesBtn = document.getElementById('showExamRulesBtn');
    const startExamBtn = document.getElementById('startExamBtn');
    const examRulesArea = document.getElementById('examRulesArea');
    const coachPhotoWrap = document.getElementById('coachPhotoWrap');
    const coachName = document.getElementById('coachName');
    const coachTitle = document.getElementById('coachTitle');
    const coachSpecialty = document.getElementById('coachSpecialty');
    const statusMessage = document.getElementById('statusMessage');
    const coachSessionArea = document.getElementById('coachSessionArea');
    const coachSessionStatus = document.getElementById('coachSessionStatus');
    const coachMount = document.getElementById('coachMount');
    const practiceTranscript = document.getElementById('practiceTranscript');
    const evaluatePracticeBtn = document.getElementById('evaluatePracticeBtn');
    const startRecordingBtn = document.getElementById('startRecordingBtn');
    const stopRecordingBtn = document.getElementById('stopRecordingBtn');
    const retryRecordingBtn = document.getElementById('retryRecordingBtn');
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

    const hasPracticeConfig = Boolean(currentPracticeConfig.avatar_id && currentPracticeConfig.context_id && !missingHeyGenConfig.length);

    const setEvaluationStatus = (message, className = 'small text-muted') => {
        evaluationStatus.textContent = message;
        evaluationStatus.className = className;
    };

    const setStatusMessage = (message, isError = false) => {
        statusMessage.textContent = message;
        statusMessage.classList.toggle('text-danger', isError);
    };

    const updateEvaluationButtons = () => {
        const isRecording = Boolean(mediaRecorder && mediaRecorder.state === 'recording');
        const locked = sessionMode === 'exam' && examSubmitted;
        startRecordingBtn.disabled = !hasPracticeConfig || isRecording || locked;
        stopRecordingBtn.disabled = !isRecording || locked;
        retryRecordingBtn.disabled = !hasPracticeConfig || isRecording || !recordedBlob || locked;
        evaluateSpeakingBtn.disabled = !hasPracticeConfig || !recordedBlob || locked;
        evaluatePracticeBtn.disabled = !hasPracticeConfig || locked;
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

    startRecordingBtn.addEventListener('click', async function () {
        if (!hasPracticeConfig) {
            setEvaluationStatus('Please complete your coach settings before recording.', 'small text-danger');
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
                audioPreview.classList.remove('d-none');
                if (activeStream) {
                    activeStream.getTracks().forEach(track => track.stop());
                }
                activeStream = null;
                setEvaluationStatus('Recording stopped. Ready for your performance review.', 'small text-success');
                updateEvaluationButtons();
            });

            mediaRecorder.start();
            recordingTimer = setInterval(() => {
                recordingSeconds += 1;
                setEvaluationStatus(`Recording... ${String(Math.floor(recordingSeconds / 60)).padStart(2, '0')}:${String(recordingSeconds % 60).padStart(2, '0')}`, 'small text-danger');
            }, 1000);
            setEvaluationStatus('Recording... 00:00', 'small text-danger');
            updateEvaluationButtons();
        } catch (error) {
            console.error('Audio recording error:', error);
            setEvaluationStatus('Please allow microphone access, then try recording again.', 'small text-danger');
            if (activeStream) {
                activeStream.getTracks().forEach(track => track.stop());
                activeStream = null;
            }
            updateEvaluationButtons();
        }
    });

    stopRecordingBtn.addEventListener('click', function () {
        if (mediaRecorder && mediaRecorder.state === 'recording') {
            mediaRecorder.stop();
        }
    });

    retryRecordingBtn.addEventListener('click', function () {
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
        startRecordingBtn.disabled = true;

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
        document.querySelector('.academy-hero-title').textContent = isExam ? 'English Speaking Exam' : 'Practice Room';
        coachSessionStatus.innerHTML = isExam
            ? '<span class="academy-status-dot"></span>Start a formal English Speaking Exam with Olivia, Assessment Supervisor.'
            : '<span class="academy-status-dot"></span>Start a live speaking session with Victoria Clarke and practice real-world English conversations.';
        document.querySelectorAll('.academy-step-row .academy-step:first-child strong').forEach(el => {
            el.textContent = isExam ? 'Complete your exam response' : 'Practice with your coach';
        });
        document.querySelector('.academy-info-box').innerHTML = isExam
            ? '<i class="fas fa-info-circle"></i> Complete your exam with Olivia. You may retry recording before final submission only; after submission, the attempt is locked.'
            : '<i class="fas fa-info-circle"></i> Complete your conversation with Victoria Clarke, then record a short response to receive your performance review.';
    };

    const startSpeakingSession = async (mode = 'practice') => {
        if (!hasPracticeConfig) {
            setStatusMessage('Please complete your Coach Settings before starting.', true);
            return;
        }

        sessionMode = mode;
        examSubmitted = false;
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
                throw new Error(data.message || 'Unable to load your speaking session.');
            }

            academySessionId = data.academy_session_id || null;
            const openSessionLink = document.getElementById('openSessionLink');

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

            setStatusMessage(mode === 'exam' ? 'English Speaking Exam is ready.' : 'Speaking Session is ready.');
            coachSessionStatus.innerHTML = mode === 'exam'
                ? '<span class="academy-status-dot"></span>Olivia is ready. Complete the exam carefully before final submission.'
                : '<span class="academy-status-dot"></span>Your English Coach is ready. Click Chat Now and allow microphone access to begin your speaking session.';
            setEvaluationStatus(mode === 'exam' ? 'Record your exam response when ready. Final submission will lock the attempt.' : 'Ready to record your voice for pronunciation feedback.');
            updateEvaluationButtons();

            setTimeout(() => {
                coachSessionArea.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 300);
        } catch (error) {
            console.error('speaking session embed error:', error);
            setStatusMessage(error.message || 'Unable to load your speaking session.', true);
            coachSessionStatus.innerHTML = '<span class="academy-status-dot"></span>Ready';
        } finally {
            startBtn.disabled = !hasPracticeConfig;
            showExamRulesBtn.disabled = !hasPracticeConfig;
        }
    };

    startBtn?.addEventListener('click', () => startSpeakingSession('practice'));
    showExamRulesBtn?.addEventListener('click', () => {
        examRulesArea.classList.toggle('d-none');
        if (!examRulesArea.classList.contains('d-none')) {
            examRulesArea.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });
    startExamBtn?.addEventListener('click', () => startSpeakingSession('exam'));

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
