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

    .academy-debug {
        margin: 0;
        padding: 14px 20px;
        background: #f9fafb;
        border-top: 1px solid #e5e7eb;
        color: var(--academy-muted);
        font-size: 0.84rem;
        word-break: break-all;
    }

    .academy-debug summary {
        color: var(--academy-navy);
        cursor: pointer;
        font-weight: 850;
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

    @media (max-width: 992px) {
        .academy-grid,
        .academy-setup-grid {
            grid-template-columns: 1fr;
        }

        .academy-score-grid {
            grid-template-columns: repeat(auto-fit, minmax(145px, 1fr));
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
            @endphp

            <section class="academy-card mb-4">
                <div class="academy-card-header">
                    <h2 class="academy-card-title"><i class="fas fa-chalkboard-teacher"></i> Current Practice Setup</h2>
                    <p class="academy-card-subtitle">Meet your English Coach and prepare for a focused speaking practice session.</p>
                </div>
                <div class="academy-card-body">
                    <div class="academy-setup-grid">
                        <div class="academy-coach-card">
                            <div class="academy-coach-preview academy-coach-photo">
                                @if(! empty($currentPracticeConfig['avatar_image_url']))
                                    <img src="{{ $currentPracticeConfig['avatar_image_url'] }}" alt="Victoria Clarke, English Coach" loading="lazy">
                                @else
                                    <div class="academy-coach-placeholder"><i class="fas fa-user-tie"></i></div>
                                @endif
                            </div>
                            <div class="academy-coach-info">
                                <h3>Victoria Clarke</h3>
                                <p>English Coach</p>
                                <strong>Speaking Practice Specialist</strong>
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
                                <strong>{{ $currentPracticeConfig['context_name'] ?: 'Personalized English speaking practice' }}</strong>
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
                                <button type="button" id="startPracticeBtn" class="btn academy-btn-primary btn-lg" {{ ! $canStartPractice ? 'disabled' : '' }}>
                                    <i class="fas fa-play"></i> Start Practice
                                </button>
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

                    <div id="liveCoachDebug"></div>
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
        </div>
    </main>
</div>

<script>
    const missingHeyGenConfig = @json($missingHeyGenConfig ?? []);
    const currentPracticeConfig = @json($currentAvatarConfig ?? []);
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const appDebug = @json(config('app.debug'));

    const startBtn = document.getElementById('startPracticeBtn');
    const statusMessage = document.getElementById('statusMessage');
    const coachSessionArea = document.getElementById('coachSessionArea');
    const coachSessionStatus = document.getElementById('coachSessionStatus');
    const coachMount = document.getElementById('coachMount');
    const practiceTranscript = document.getElementById('practiceTranscript');
    const evaluatePracticeBtn = document.getElementById('evaluatePracticeBtn');
    const startRecordingBtn = document.getElementById('startRecordingBtn');
    const stopRecordingBtn = document.getElementById('stopRecordingBtn');
    const evaluateSpeakingBtn = document.getElementById('evaluateSpeakingBtn');
    const audioPreview = document.getElementById('audioPreview');
    const evaluationStatus = document.getElementById('evaluationStatus');
    const evaluationResult = document.getElementById('evaluationResult');
    const liveCoachDebug = document.getElementById('liveCoachDebug');

    let academySessionId = null;
    let mediaRecorder = null;
    let audioChunks = [];
    let recordedBlob = null;
    let activeStream = null;

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
        startRecordingBtn.disabled = !hasPracticeConfig || Boolean(mediaRecorder && mediaRecorder.state === 'recording');
        stopRecordingBtn.disabled = !(mediaRecorder && mediaRecorder.state === 'recording');
        evaluateSpeakingBtn.disabled = !hasPracticeConfig || !recordedBlob;
        evaluatePracticeBtn.disabled = !hasPracticeConfig;
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
            recordedBlob = null;
            audioChunks = [];
            audioPreview.classList.add('d-none');
            activeStream = await navigator.mediaDevices.getUserMedia({ audio: true });
            mediaRecorder = new MediaRecorder(activeStream);

            mediaRecorder.addEventListener('dataavailable', event => {
                if (event.data && event.data.size > 0) {
                    audioChunks.push(event.data);
                }
            });

            mediaRecorder.addEventListener('stop', () => {
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
            setEvaluationStatus('Recording...', 'small text-danger');
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
            setEvaluationStatus('Evaluation complete', 'small text-success');
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
                }),
            });

            const data = await response.json();

            if (!response.ok || !data.success) {
                const validationMessage = data.errors ? Object.values(data.errors).flat().join(' ') : null;
                throw new Error(validationMessage || data.message || 'Unable to prepare your feedback report right now.');
            }

            renderEvaluation(data.evaluation);
            setEvaluationStatus('Evaluation complete', 'small text-success');
        } catch (error) {
            console.error('review service text evaluation error:', error);
            setEvaluationStatus(error.message || 'Unable to prepare your feedback report right now.', 'small text-danger');
        } finally {
            updateEvaluationButtons();
        }
    });

    startBtn?.addEventListener('click', async function () {
        if (!hasPracticeConfig) {
            setStatusMessage('Please complete your Coach Settings before starting practice.', true);
            return;
        }

        setStatusMessage('Preparing your Speaking Session...');
        coachSessionStatus.innerHTML = '<span class="academy-status-dot"></span>Preparing your coach...';
        startBtn.disabled = true;

        try {
            const response = await fetch("{{ route('educonecx.academy.liveavatar.embed') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({}),
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

            setStatusMessage('Speaking Session is ready.');
            coachSessionStatus.innerHTML = '<span class="academy-status-dot"></span>Your English Coach is ready. Click Chat Now and allow microphone access to begin your speaking session.';
            setEvaluationStatus('Ready to record your voice for pronunciation feedback.');
            updateEvaluationButtons();

            liveCoachDebug.innerHTML = '';

            setTimeout(() => {
                coachSessionArea.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 300);
        } catch (error) {
            console.error('speaking session embed error:', error);
            setStatusMessage(error.message || 'Unable to load your speaking session.', true);
            coachSessionStatus.innerHTML = '<span class="academy-status-dot"></span>Ready';
        } finally {
            startBtn.disabled = !hasPracticeConfig;
        }
    });

    if (missingHeyGenConfig.length) {
        setStatusMessage(`Practice Room is not ready yet (${missingHeyGenConfig.join(', ')} missing).`, true);
    } else if (!hasPracticeConfig) {
        setStatusMessage('Please complete your Coach Settings before starting practice.', true);
    } else {
        setStatusMessage('Ready to start your speaking session.');
        setEvaluationStatus('Start a speaking session, then record your voice for pronunciation feedback.');
    }

    updateEvaluationButtons();
</script>
@endsection
