@extends('layouts.main')

@section('title', 'EDUCONECX Academy - Practice English with AI Avatar')

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
    .academy-liveavatar-card,
    .academy-evaluation-card {
        background: var(--academy-white);
        border: 1px solid var(--academy-border);
        border-radius: 18px;
        box-shadow: var(--academy-soft-shadow);
        overflow: hidden;
    }

    .academy-card-header,
    .academy-liveavatar-header,
    .academy-evaluation-header {
        padding: 22px 24px;
        border-bottom: 1px solid var(--academy-border);
        background: linear-gradient(145deg, #fff, var(--academy-ivory));
    }

    .academy-card-title,
    .academy-liveavatar-title {
        margin: 0;
        color: var(--academy-navy);
        font-size: 1.2rem;
        font-weight: 850;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .academy-card-title i,
    .academy-liveavatar-title i {
        color: var(--academy-yellow);
    }

    .academy-card-subtitle,
    .academy-liveavatar-status {
        color: var(--academy-muted);
        margin: 7px 0 0;
        font-size: 0.92rem;
    }

    .academy-card-body,
    .academy-evaluation-body {
        padding: 24px;
    }

    .academy-scenario-list {
        display: grid;
        gap: 12px;
        max-height: 540px;
        overflow-y: auto;
        padding-right: 4px;
    }

    .academy-scenario-card {
        width: 100%;
        text-align: left;
        border: 1px solid rgba(10, 29, 68, 0.10);
        background: #fff;
        color: var(--academy-navy);
        border-radius: 14px;
        padding: 15px 16px;
        transition: all 0.18s ease;
        cursor: pointer;
    }

    .academy-scenario-card:hover,
    .academy-scenario-card.active {
        transform: translateY(-1px);
        box-shadow: 0 10px 20px rgba(10, 29, 68, 0.10);
        border-color: rgba(251, 198, 12, 0.75);
    }

    .academy-scenario-card.active {
        background: linear-gradient(135deg, var(--academy-yellow), var(--academy-yellow-soft));
        color: var(--academy-navy);
    }

    .academy-scenario-title {
        display: block;
        font-weight: 850;
        font-size: 0.96rem;
        margin-bottom: 6px;
    }

    .academy-scenario-meta {
        color: var(--academy-muted);
        font-size: 0.8rem;
    }

    .academy-scenario-card.active .academy-scenario-meta {
        color: rgba(10, 29, 68, 0.74);
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

    .academy-liveavatar-section,
    .academy-evaluation-section {
        margin-top: 28px;
    }

    .academy-liveavatar-card,
    .academy-evaluation-card {
        box-shadow: var(--academy-shadow);
    }

    .academy-liveavatar-header {
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

    .academy-liveavatar-frame-wrap {
        width: 100%;
        height: 680px;
        min-height: 680px;
        background: #050505;
        border-radius: 0 0 18px 18px;
        overflow: hidden;
    }

    .academy-liveavatar-frame-wrap iframe {
        width: 100% !important;
        height: 680px !important;
        border: 0 !important;
        display: block !important;
        background: #050505;
    }

    .academy-liveavatar-placeholder {
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

    .academy-liveavatar-placeholder i {
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
        .academy-grid {
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
        .academy-liveavatar-header,
        .academy-evaluation-header,
        .academy-card-body,
        .academy-evaluation-body {
            padding: 18px;
        }

        .academy-liveavatar-header {
            align-items: stretch;
            flex-direction: column;
        }

        .academy-liveavatar-frame-wrap,
        .academy-liveavatar-placeholder {
            height: 520px;
            min-height: 520px;
        }

        .academy-liveavatar-frame-wrap iframe {
            height: 520px !important;
        }

        .academy-action-row .btn,
        .academy-recording-controls .btn,
        #openLiveAvatarLink {
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
            <div class="academy-kicker">AI-powered English practice</div>
            <h1 class="academy-hero-title">EDUCONECX Academy</h1>
            <p class="academy-hero-subtitle">Practice English in real time with an AI avatar, then record your answer for pronunciation, grammar, fluency, vocabulary, and overall feedback.</p>
            <div class="academy-badge-row">
                <span class="academy-hero-badge"><i class="fas fa-user-astronaut"></i> Live Avatar</span>
                <span class="academy-hero-badge"><i class="fas fa-microphone-alt"></i> Speaking Practice</span>
                <span class="academy-hero-badge"><i class="fas fa-chart-line"></i> AI Feedback</span>
            </div>
        </div>
    </section>

    <main class="academy-main">
        <div class="container">
            @guest
                <div class="alert alert-warning">Please login to access EDUCONECX Academy.</div>
            @endguest

            <div class="academy-card mb-4">
                <div class="academy-card-body d-flex align-items-center justify-content-between gap-3 flex-wrap">
                    <div>
                        <h2 class="academy-card-title mb-2"><i class="fas fa-user-cog"></i> Your Academy Preferences</h2>
                        <div class="academy-badge-row">
                            <span class="academy-pill"><i class="fas fa-user-astronaut"></i> Current Avatar: {{ $avatarSetting?->avatar_name ?: 'Default LiveAvatar' }}</span>
                            <span class="academy-pill"><i class="fas fa-comments"></i> Current Scenario Context: {{ $avatarSetting?->context_name ?: 'Default context' }}</span>
                        </div>
                        @if(config('app.debug'))
                            <details class="academy-debug mt-3">
                                <summary>Preference Debug Info</summary>
                                <div class="mt-2">
                                    avatar_id: {{ $avatarSetting?->heygen_avatar_id ?: '-' }}<br>
                                    context_id: {{ $avatarSetting?->heygen_context_id ?: '-' }}<br>
                                    voice_id: {{ $avatarSetting?->heygen_voice_id ?: '-' }}
                                </div>
                            </details>
                        @endif
                    </div>
                    <a href="{{ route('dashboard.educonecx-academy.index') }}" class="btn academy-btn-soft"><i class="fas fa-sliders-h"></i> Manage Preferences</a>
                </div>
            </div>

            <div class="academy-grid">
                <section class="academy-card">
                    <div class="academy-card-header">
                        <h2 class="academy-card-title"><i class="fas fa-tasks"></i> Practice Scenarios</h2>
                        <p class="academy-card-subtitle">Choose a scenario to start a focused English conversation.</p>
                    </div>
                    <div class="academy-card-body">
                        <div class="academy-scenario-list" id="scenarioCards"></div>
                    </div>
                </section>

                <section class="academy-card academy-detail-card">
                    <div class="academy-card-header">
                        <h2 class="academy-card-title"><i class="fas fa-graduation-cap"></i> Scenario Details</h2>
                        <p class="academy-card-subtitle">Review the objective, practice text, and sample prompts before launching the avatar.</p>
                    </div>
                    <div class="academy-card-body">
                        <div id="scenarioPreview">
                            <h3 class="academy-detail-title">Select a scenario to preview</h3>
                            <p class="text-muted mb-0">Category, level, practice text, and sample questions will appear here.</p>
                        </div>

                        <div class="academy-action-row mt-4">
                            <button type="button" id="startPracticeBtn" class="btn academy-btn-primary btn-lg" disabled>
                                <i class="fas fa-play"></i> Practice with AI Avatar
                            </button>
                            <span id="statusMessage" class="academy-status-message"></span>
                        </div>

                        @if(!empty($missingHeyGenConfig))
                            <div class="alert alert-warning mt-3 mb-0">
                                <strong>HeyGen setup required:</strong>
                                Missing {{ implode(', ', $missingHeyGenConfig) }}.
                                Add HEYGEN_API_KEY, HEYGEN_AVATAR_ID, HEYGEN_VOICE_ID, HEYGEN_CONTEXT_ID to <code>.env</code>, then run <code>php artisan config:clear</code>.
                            </div>
                        @endif
                    </div>
                </section>
            </div>

            <section id="avatarSessionArea" class="academy-liveavatar-section d-none">
                <div class="academy-liveavatar-card">
                    <div class="academy-liveavatar-header">
                        <div>
                            <h2 class="academy-liveavatar-title"><i class="fas fa-video"></i> Live Avatar Session</h2>
                            <p class="academy-liveavatar-status" id="avatarSessionStatus"><span class="academy-status-dot"></span>Ready</p>
                        </div>
                        <a id="openLiveAvatarLink" href="#" target="_blank" rel="noopener" class="btn academy-btn-soft d-none">
                            <i class="fas fa-external-link-alt"></i> Open in New Tab
                        </a>
                    </div>

                    <div id="avatarMount" class="academy-liveavatar-frame-wrap">
                        <div class="academy-liveavatar-placeholder">
                            <i class="fas fa-user-astronaut"></i>
                            <strong>LiveAvatar will appear here.</strong>
                            <span>Select a scenario and click “Practice with AI Avatar”.</span>
                        </div>
                    </div>

                    <div id="liveAvatarDebug"></div>
                </div>
            </section>

            <section id="practiceEvaluationArea" class="academy-evaluation-section">
                <div class="academy-evaluation-card">
                    <div class="academy-evaluation-header">
                        <h2 class="academy-liveavatar-title"><i class="fas fa-microphone-alt"></i> Evaluate My Speaking</h2>
                        <p class="academy-liveavatar-status mb-0">Record your voice after practice and receive pronunciation, grammar, fluency, vocabulary, and overall scoring.</p>
                    </div>
                    <div class="academy-evaluation-body">
                        <div class="academy-step-row">
                            <div class="academy-step"><span class="academy-step-number">1</span><div><strong>Practice with avatar</strong><br><span class="text-muted">Use the LiveAvatar roleplay prompt.</span></div></div>
                            <div class="academy-step"><span class="academy-step-number">2</span><div><strong>Record your answer</strong><br><span class="text-muted">Capture your response in the browser.</span></div></div>
                            <div class="academy-step"><span class="academy-step-number">3</span><div><strong>Get AI feedback</strong><br><span class="text-muted">Review scores and next steps.</span></div></div>
                        </div>

                        <div class="academy-info-box">
                            <i class="fas fa-info-circle"></i>
                            HeyGen/LiveAvatar powers the live avatar conversation. OpenAI is used only after recording for evaluation and progress tracking.
                        </div>
                        {{-- TODO: If LiveAvatar provides native scoring/evaluation APIs, replace or reduce OpenAI evaluation to avoid duplicate cost. --}}

                        <div class="academy-recording-controls">
                            <button type="button" id="startRecordingBtn" class="btn academy-btn-primary" disabled><i class="fas fa-microphone-alt"></i> Start Recording</button>
                            <button type="button" id="stopRecordingBtn" class="btn academy-btn-danger" disabled><i class="fas fa-stop"></i> Stop Recording</button>
                            <button type="button" id="evaluateSpeakingBtn" class="btn academy-btn-navy" disabled><i class="fas fa-magic"></i> Evaluate My Speaking</button>
                        </div>
                        <audio id="audioPreview" class="academy-audio-preview d-none" controls></audio>
                        <p id="recordingHelp" class="small text-muted mt-2 mb-0">If your browser blocks simultaneous microphone access, please finish the avatar practice first, then record your answer for evaluation.</p>

                        <label for="practiceTranscript" class="form-label fw-semibold mt-4">Optional transcript for text-only evaluation</label>
                        <textarea id="practiceTranscript" class="form-control academy-textarea" rows="5" placeholder="Optional fallback: type or paste what you said if you cannot record audio."></textarea>
                        <div class="academy-action-row mt-3">
                            <button type="button" id="evaluatePracticeBtn" class="btn academy-btn-soft" disabled><i class="fas fa-keyboard"></i> Evaluate Text Only</button>
                            <span id="evaluationStatus" class="small text-muted">Select a scenario, then record your voice for pronunciation evaluation.</span>
                        </div>
                        <div id="evaluationResult" class="academy-evaluation-result mt-4 d-none"></div>
                    </div>
                </div>
            </section>
        </div>
    </main>
</div>

<script>
    const categories = @json($categories);
    const missingHeyGenConfig = @json($missingHeyGenConfig ?? []);
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const appDebug = @json(config('app.debug'));

    const scenarioCards = document.getElementById('scenarioCards');
    const scenarioPreview = document.getElementById('scenarioPreview');
    const startBtn = document.getElementById('startPracticeBtn');
    const statusMessage = document.getElementById('statusMessage');
    const avatarSessionArea = document.getElementById('avatarSessionArea');
    const avatarSessionStatus = document.getElementById('avatarSessionStatus');
    const avatarMount = document.getElementById('avatarMount');
    const practiceTranscript = document.getElementById('practiceTranscript');
    const evaluatePracticeBtn = document.getElementById('evaluatePracticeBtn');
    const startRecordingBtn = document.getElementById('startRecordingBtn');
    const stopRecordingBtn = document.getElementById('stopRecordingBtn');
    const evaluateSpeakingBtn = document.getElementById('evaluateSpeakingBtn');
    const audioPreview = document.getElementById('audioPreview');
    const evaluationStatus = document.getElementById('evaluationStatus');
    const evaluationResult = document.getElementById('evaluationResult');
    const liveAvatarDebug = document.getElementById('liveAvatarDebug');

    let selectedScenario = null;
    let academySessionId = null;
    let mediaRecorder = null;
    let audioChunks = [];
    let recordedBlob = null;
    let activeStream = null;

    const setEvaluationStatus = (message, className = 'small text-muted') => {
        evaluationStatus.textContent = message;
        evaluationStatus.className = className;
    };

    const setStatusMessage = (message, isError = false) => {
        statusMessage.textContent = message;
        statusMessage.classList.toggle('text-danger', isError);
    };

    const updateEvaluationButtons = () => {
        const hasScenario = Boolean(selectedScenario);
        startRecordingBtn.disabled = !hasScenario || Boolean(mediaRecorder && mediaRecorder.state === 'recording');
        stopRecordingBtn.disabled = !(mediaRecorder && mediaRecorder.state === 'recording');
        evaluateSpeakingBtn.disabled = !hasScenario || !recordedBlob;
        evaluatePracticeBtn.disabled = !hasScenario;
    };

    const escapeHtml = (value) => String(value ?? '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');

    const updateScenarioPreview = (scenario) => {
        selectedScenario = scenario;
        startBtn.disabled = !selectedScenario;
        updateEvaluationButtons();

        if (!selectedScenario) {
            setEvaluationStatus('Select a scenario, then record your voice for pronunciation evaluation.');
            scenarioPreview.innerHTML = `
                <h3 class="academy-detail-title">Select a scenario to preview</h3>
                <p class="text-muted mb-0">Category, level, practice text, and sample questions will appear here.</p>
            `;
            return;
        }

        setEvaluationStatus('Ready to record your voice for pronunciation evaluation.');

        const questions = (selectedScenario.sample_questions || [])
            .map(question => `<li>${escapeHtml(question)}</li>`)
            .join('');

        scenarioPreview.innerHTML = `
            <h3 class="academy-detail-title">${escapeHtml(selectedScenario.title)}</h3>
            <div class="academy-badge-row mb-3">
                <span class="academy-pill"><i class="fas fa-layer-group"></i> ${escapeHtml(selectedScenario.category.title)}</span>
                <span class="academy-pill"><i class="fas fa-signal"></i> ${escapeHtml(selectedScenario.level ?? 'General')}</span>
            </div>
            <p class="text-muted">${escapeHtml(selectedScenario.description ?? 'Practice a realistic English conversation with your AI avatar.')}</p>
            <div class="academy-practice-text mb-3">
                <h5>Practice Text</h5>
                <p class="mb-0">${escapeHtml(selectedScenario.practice_text ?? '-')}</p>
            </div>
            <div class="academy-question-list">
                <h5>Sample Questions</h5>
                ${questions ? `<ul class="mb-0">${questions}</ul>` : '<p class="text-muted mb-0">No sample questions provided.</p>'}
            </div>
        `;
    };

    const allScenarios = categories.flatMap(category =>
        (category.scenarios || []).map(scenario => ({ ...scenario, category }))
    );

    allScenarios.forEach((scenario) => {
        const wrapper = document.createElement('div');
        wrapper.innerHTML = `
            <button class="academy-scenario-card scenario-btn" data-slug="${escapeHtml(scenario.slug)}">
                <span class="academy-scenario-title">${escapeHtml(scenario.title)}</span>
                <span class="academy-scenario-meta"><i class="fas fa-layer-group"></i> ${escapeHtml(scenario.category.title)} • ${escapeHtml(scenario.level ?? 'General')}</span>
            </button>
        `;
        scenarioCards.appendChild(wrapper.firstElementChild);
    });

    scenarioCards.addEventListener('click', function (event) {
        const button = event.target.closest('.scenario-btn');
        if (!button) return;

        document.querySelectorAll('.scenario-btn').forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');

        const scenario = allScenarios.find(item => item.slug === button.dataset.slug);
        updateScenarioPreview(scenario);
    });

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
            <div class="mt-3">${renderList('Next Steps', evaluation.next_steps, 'fa-arrow-right')}</div>
        `;
    };

    startRecordingBtn.addEventListener('click', async function () {
        if (!selectedScenario) {
            setEvaluationStatus('Please select a scenario first.', 'small text-danger');
            return;
        }

        if (!navigator.mediaDevices || !window.MediaRecorder) {
            setEvaluationStatus('Audio recording is not supported in this browser.', 'small text-danger');
            return;
        }

        try {
            activeStream = await navigator.mediaDevices.getUserMedia({ audio: true });
            audioChunks = [];
            recordedBlob = null;
            audioPreview.classList.add('d-none');
            audioPreview.removeAttribute('src');

            const options = MediaRecorder.isTypeSupported('audio/webm') ? { mimeType: 'audio/webm' } : undefined;
            mediaRecorder = new MediaRecorder(activeStream, options);

            mediaRecorder.addEventListener('dataavailable', (event) => {
                if (event.data && event.data.size > 0) {
                    audioChunks.push(event.data);
                }
            });

            mediaRecorder.addEventListener('stop', () => {
                recordedBlob = new Blob(audioChunks, { type: mediaRecorder.mimeType || 'audio/webm' });
                audioPreview.src = URL.createObjectURL(recordedBlob);
                audioPreview.classList.remove('d-none');
                activeStream.getTracks().forEach(track => track.stop());
                activeStream = null;
                setEvaluationStatus('Recording stopped. Ready for AI evaluation.', 'small text-success');
                updateEvaluationButtons();
            });

            mediaRecorder.start();
            setEvaluationStatus('Recording...', 'small text-danger');
            updateEvaluationButtons();
        } catch (error) {
            console.error('Audio recording error:', error);
            setEvaluationStatus('Please finish the avatar practice first, then record your answer for evaluation.', 'small text-danger');
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
        if (!selectedScenario) {
            setEvaluationStatus('Please select a scenario first.', 'small text-danger');
            return;
        }

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
            formData.append('scenario_slug', selectedScenario.slug);
            formData.append('academy_session_id', academySessionId || '');

            setEvaluationStatus('Evaluating with OpenAI...', 'small text-muted');

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
            console.error('OpenAI audio evaluation error:', error);
            setEvaluationStatus(error.message || 'Unable to evaluate this recording right now.', 'small text-danger');
        } finally {
            updateEvaluationButtons();
        }
    });

    evaluatePracticeBtn.addEventListener('click', async function () {
        if (!selectedScenario) {
            setEvaluationStatus('Please select a scenario first.', 'small text-danger');
            return;
        }

        const transcript = practiceTranscript.value.trim();
        if (transcript.length < 10) {
            setEvaluationStatus('Please enter at least 10 characters from your practice.', 'small text-danger');
            return;
        }

        setEvaluationStatus('Evaluating with OpenAI...', 'small text-muted');
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
                    scenario_slug: selectedScenario.slug,
                    transcript,
                }),
            });

            const data = await response.json();

            if (!response.ok || !data.success) {
                const validationMessage = data.errors ? Object.values(data.errors).flat().join(' ') : null;
                throw new Error(validationMessage || data.message || 'Unable to get AI feedback right now.');
            }

            renderEvaluation(data.evaluation);
            setEvaluationStatus('Evaluation complete', 'small text-success');
        } catch (error) {
            console.error('OpenAI text evaluation error:', error);
            setEvaluationStatus(error.message || 'Unable to get AI feedback right now.', 'small text-danger');
        } finally {
            updateEvaluationButtons();
        }
    });

    startBtn.addEventListener('click', async function () {
        if (!selectedScenario) {
            setStatusMessage('Please select a scenario first.', true);
            return;
        }

        setStatusMessage('Creating LiveAvatar embed...');
        avatarSessionStatus.innerHTML = '<span class="academy-status-dot"></span>Loading LiveAvatar...';
        startBtn.disabled = true;

        try {
            const response = await fetch("{{ route('educonecx.academy.liveavatar.embed') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ scenario_slug: selectedScenario.slug }),
            });

            const responseText = await response.text();
            let data = {};

            try {
                data = responseText ? JSON.parse(responseText) : {};
                console.log('LiveAvatar embed response:', data);
            } catch (e) {
                throw new Error('Server returned an unexpected response. Please refresh and try again.');
            }

            if (!response.ok || !data.success) {
                throw new Error(data.message || 'Unable to load LiveAvatar.');
            }

            academySessionId = data.academy_session_id || null;

            const openLiveAvatarLink = document.getElementById('openLiveAvatarLink');

            if (!data.embed_url) {
                throw new Error('LiveAvatar embed URL missing.');
            }

            avatarSessionArea.classList.remove('d-none');

            avatarMount.innerHTML = `
                <iframe
                    src="${data.embed_url}"
                    title="LiveAvatar Embed"
                    allow="microphone; camera; autoplay; fullscreen; clipboard-read; clipboard-write"
                    allowfullscreen
                    loading="eager"
                ></iframe>
            `;

            openLiveAvatarLink.href = data.embed_url;
            openLiveAvatarLink.classList.remove('d-none');

            setStatusMessage('LiveAvatar embed created successfully.');
            avatarSessionStatus.innerHTML = '<span class="academy-status-dot"></span>Connected. Click Chat now and allow microphone access.';

            if (appDebug) {
                liveAvatarDebug.innerHTML = `
                    <details class="academy-debug">
                        <summary>Developer Debug Info</summary>
                        <div class="mt-2">
                            <strong>Embed URL:</strong> <a href="${data.embed_url}" target="_blank" rel="noopener">${data.embed_url}</a><br>
                            <strong>Avatar ID:</strong> ${data.avatar_id || '-'}<br>
                            <strong>Voice ID:</strong> ${data.voice_id || '-'}<br>
                            <strong>Context ID:</strong> ${data.context_id || '-'}<br>
                            <strong>Note:</strong> If Chat now fails, check LiveAvatar avatar/context/voice compatibility and billing.
                        </div>
                    </details>
                `;
            } else {
                liveAvatarDebug.innerHTML = '';
            }

            setTimeout(() => {
                avatarSessionArea.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 300);

            console.log('LiveAvatar iframe inserted:', data.embed_url);
        } catch (error) {
            console.error('LiveAvatar embed error:', error);
            setStatusMessage(error.message || 'Unable to load LiveAvatar.', true);
            avatarSessionStatus.innerHTML = '<span class="academy-status-dot"></span>Ready';
        } finally {
            startBtn.disabled = false;
        }
    });

    if (missingHeyGenConfig.length) {
        startBtn.disabled = true;
        setStatusMessage(`HeyGen is not configured yet (${missingHeyGenConfig.join(', ')} missing).`, true);
    } else if (!allScenarios.length) {
        scenarioCards.innerHTML = '<div class="alert alert-warning mb-0">No practice scenarios are available yet. Please run database seeding.</div>';
        setStatusMessage('No scenarios found. Ask admin to run migrations and seeders.', true);
    } else {
        const firstScenario = allScenarios[0];
        const firstButton = scenarioCards.querySelector('.scenario-btn');
        if (firstButton) {
            firstButton.classList.add('active');
        }
        updateScenarioPreview(firstScenario);
    }
</script>
@endsection
