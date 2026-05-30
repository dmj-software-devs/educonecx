@extends('layouts.main')

@section('title', 'EDUCONECX Academy - Practice English with AI Avatar')

@push('styles')
<style>
    .academy-rect.hero-section,
    .academy-rect .hero-section,
    .academy-rect .hero-section::before,
    .academy-rect .hero-section::after {
        border-radius: 0 !important;
    }

    .academy-rect.hero-section::before,
    .academy-rect.hero-section::after {
        border-radius: 0 !important;
        clip-path: none !important;
    }

    .academy-rect,
    .academy-rect .btn,
    .academy-rect .card,
    .academy-rect .form-control {
        border-radius: 6px !important;
    }
</style>
@endpush

@section('content')
<section class="hero-section py-5 academy-rect">
    <div class="container">
        <div class="text-center">
            <h1 class="hero-title">EDUCONECX Academy</h1>
            <p class="hero-text">Practice English in real time with an AI avatar.</p>
        </div>
    </div>
</section>

<section class="py-5 academy-rect">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <h3 class="section-title mb-3">Choose Practice Scenario</h3>
                        <div class="row g-3" id="scenarioCards"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body" id="scenarioPreview">
                        <h4 class="card-title">Select a scenario to preview</h4>
                        <p class="text-muted mb-0">Category, level, practice text, and sample questions will appear here.</p>
                    </div>
                </div>

                <button type="button" id="startPracticeBtn" class="btn btn-primary btn-lg" disabled>Practice with AI Avatar</button>
                <p id="statusMessage" class="mt-3 mb-0"></p>

                @if(!empty($missingHeyGenConfig))
                    <div class="alert alert-warning mt-3 mb-0">
                        <strong>HeyGen setup required:</strong>
                        Missing {{ implode(', ', $missingHeyGenConfig) }}.
                        Add HEYGEN_API_KEY, HEYGEN_AVATAR_ID, HEYGEN_VOICE_ID, HEYGEN_CONTEXT_ID to <code>.env</code>, then run <code>php artisan config:clear</code>.
                    </div>
                @endif


                <div id="feedbackArea" class="card shadow-sm border-0 mt-4 d-none">
                    <div class="card-body">
                        <h4 class="card-title">Session Feedback</h4>
                        <p class="mb-0" id="feedbackText">Feedback and score will appear here after session completion.</p>
                    </div>
                </div>
            </div>
        </div>

        <div id="avatarSessionArea" class="academy-liveavatar-section mt-4 d-none">
            <div class="academy-liveavatar-card">
                <div class="academy-liveavatar-header">
                    <div>
                        <h4 class="academy-liveavatar-title">Live Avatar Session</h4>
                        <p class="academy-liveavatar-status" id="avatarSessionStatus">Initializing...</p>
                    </div>
                    <a id="openLiveAvatarLink" href="#" target="_blank" rel="noopener" class="btn btn-outline-primary d-none">
                        Open in New Tab
                    </a>
                </div>

                <div id="avatarMount" class="academy-liveavatar-frame-wrap">
                    <div class="academy-liveavatar-placeholder">
                        LiveAvatar will appear here.
                    </div>
                </div>

                <div id="liveAvatarDebug" class="academy-liveavatar-debug"></div>
            </div>
        </div>

        <div id="practiceEvaluationArea" class="academy-evaluation-section mt-4">
            <div class="academy-evaluation-card">
                <div class="academy-evaluation-header">
                    <div>
                        <h4 class="academy-liveavatar-title">Evaluate My Speaking</h4>
                        <p class="academy-liveavatar-status mb-0">Record your voice for pronunciation evaluation after or during your LiveAvatar practice.</p>
                    </div>
                </div>
                <div class="academy-evaluation-body">
                    <div class="alert alert-info mb-3">
                        HeyGen/LiveAvatar remains the live avatar, voice, real-time conversation, and roleplay system. OpenAI is used only after your recording for transcription, evaluation, scoring, and progress tracking.
                    </div>
                    {{-- TODO: If LiveAvatar provides native scoring/evaluation APIs, replace or reduce OpenAI evaluation to avoid duplicate cost. --}}
                    <div class="academy-recording-controls">
                        <button type="button" id="startRecordingBtn" class="btn btn-primary" disabled>Start Recording</button>
                        <button type="button" id="stopRecordingBtn" class="btn btn-outline-danger" disabled>Stop Recording</button>
                        <button type="button" id="evaluateSpeakingBtn" class="btn btn-success" disabled>Evaluate My Speaking</button>
                    </div>
                    <audio id="audioPreview" class="academy-audio-preview mt-3 d-none" controls></audio>
                    <p id="recordingHelp" class="small text-muted mt-2 mb-0">If your browser blocks simultaneous microphone access, please finish the avatar practice first, then record your answer for evaluation.</p>

                    <label for="practiceTranscript" class="form-label fw-semibold mt-4">Optional: edit transcript before evaluation</label>
                    <textarea id="practiceTranscript" class="form-control" rows="5" placeholder="Optional fallback: type or paste what you said if you cannot record audio."></textarea>
                    <div class="d-flex align-items-center gap-3 mt-3 flex-wrap">
                        <button type="button" id="evaluatePracticeBtn" class="btn btn-outline-primary" disabled>Evaluate Text Only</button>
                        <span id="evaluationStatus" class="small text-muted">Select a scenario, then record your voice for pronunciation evaluation.</span>
                    </div>
                    <div id="evaluationResult" class="academy-evaluation-result mt-4 d-none"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    const categories = @json($categories);
    const missingHeyGenConfig = @json($missingHeyGenConfig ?? []);
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

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

    let selectedScenario = null;
    let academySessionId = null;
    let liveAvatarToken = null;
    let liveAvatarClient = null;
    let mediaRecorder = null;
    let audioChunks = [];
    let recordedBlob = null;
    let activeStream = null;

    const setEvaluationStatus = (message, className = 'small text-muted') => {
        evaluationStatus.textContent = message;
        evaluationStatus.className = className;
    };

    const updateEvaluationButtons = () => {
        const hasScenario = Boolean(selectedScenario);
        startRecordingBtn.disabled = !hasScenario || Boolean(mediaRecorder && mediaRecorder.state === 'recording');
        stopRecordingBtn.disabled = !(mediaRecorder && mediaRecorder.state === 'recording');
        evaluateSpeakingBtn.disabled = !hasScenario || !recordedBlob;
        evaluatePracticeBtn.disabled = !hasScenario;
    };

    const updateScenarioPreview = (scenario) => {
        selectedScenario = scenario;
        startBtn.disabled = !selectedScenario;
        updateEvaluationButtons();

        if (!selectedScenario) {
            setEvaluationStatus('Select a scenario, then record your voice for pronunciation evaluation.');
            scenarioPreview.innerHTML = `
                <h4 class="card-title">Select a scenario to preview</h4>
                <p class="text-muted mb-0">Category, level, practice text, and sample questions will appear here.</p>
            `;
            return;
        }

        setEvaluationStatus('Ready to record your voice for pronunciation evaluation.');

        scenarioPreview.innerHTML = `
            <h4 class="card-title">${selectedScenario.title}</h4>
            <p class="mb-1"><strong>Category:</strong> ${selectedScenario.category.title}</p>
            <p class="mb-1"><strong>Level:</strong> ${selectedScenario.level ?? 'General'}</p>
            <p class="mb-1"><strong>Description:</strong> ${selectedScenario.description ?? '-'}</p>
            <p class="mb-2"><strong>Practice Text:</strong> ${selectedScenario.practice_text}</p>
            <p class="mb-1"><strong>Sample Questions:</strong></p>
            <ul>${(selectedScenario.sample_questions || []).map(question => `<li>${question}</li>`).join('')}</ul>
        `;
    };

    const allScenarios = categories.flatMap(category =>
        (category.scenarios || []).map(scenario => ({ ...scenario, category }))
    );

    allScenarios.forEach((scenario) => {
        const wrapper = document.createElement('div');
        wrapper.className = 'col-12';
        wrapper.innerHTML = `
            <button class="btn btn-outline-primary w-100 text-start scenario-btn" data-slug="${scenario.slug}">
                <strong>${scenario.title}</strong><br>
                <small>${scenario.category.title} • ${scenario.level ?? 'General'}</small>
            </button>
        `;
        scenarioCards.appendChild(wrapper);
    });

    scenarioCards.addEventListener('click', function (event) {
        const button = event.target.closest('.scenario-btn');
        if (!button) return;

        document.querySelectorAll('.scenario-btn').forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');

        const scenario = allScenarios.find(item => item.slug === button.dataset.slug);
        updateScenarioPreview(scenario);
    });

    const escapeHtml = (value) => String(value ?? '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');

    const renderScore = (label, value) => `
        <div class="academy-score-pill">
            <span>${label}</span>
            <strong>${value === null || value === undefined ? 'N/A' : `${Number(value).toFixed(1)}/10`}</strong>
        </div>
    `;

    const renderList = (title, items) => `
        <div class="academy-evaluation-list">
            <h5>${title}</h5>
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
                    <h5>Transcript</h5>
                    <p class="mb-0">${escapeHtml(evaluation.transcript)}</p>
                </div>
            ` : ''}
            <div class="academy-score-grid">
                ${renderScore('Pronunciation', evaluation.pronunciation_score)}
                ${renderScore('Grammar', evaluation.grammar_score)}
                ${renderScore('Fluency', evaluation.fluency_score)}
                ${renderScore('Vocabulary', evaluation.vocabulary_score)}
                ${renderScore('Overall', evaluation.overall_score)}
            </div>
            ${evaluation.pronunciation_feedback
                ? `<div class="academy-evaluation-panel mt-3"><h5>Pronunciation Feedback</h5><p class="mb-0">${escapeHtml(evaluation.pronunciation_feedback)}</p></div>`
                : ''}
            ${evaluation.pronunciation_note
                ? `<div class="alert alert-warning mt-3 mb-0">${escapeHtml(evaluation.pronunciation_note)}</div>`
                : ''}
            <div class="academy-evaluation-panel mt-3">
                <h5>Corrections</h5>
                ${renderCorrections(evaluation.corrections)}
            </div>
            <div class="row g-3 mt-1">
                <div class="col-md-6">${renderList('Strengths', evaluation.strengths)}</div>
                <div class="col-md-6">${renderList('Weaknesses', evaluation.weaknesses)}</div>
            </div>
            <div class="academy-evaluation-panel mt-3">
                <h5>Feedback</h5>
                <p class="mb-0">${escapeHtml(evaluation.feedback)}</p>
            </div>
            <div class="mt-3">${renderList('Next Steps', evaluation.next_steps)}</div>
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
                setEvaluationStatus('Recording stopped', 'small text-success');
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
            statusMessage.textContent = 'Please select a scenario first.';
            return;
        }

        statusMessage.classList.remove('text-danger');
        statusMessage.textContent = 'Creating LiveAvatar embed...';
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

            academySessionId = null;

            const openLiveAvatarLink = document.getElementById('openLiveAvatarLink');
            const liveAvatarDebug = document.getElementById('liveAvatarDebug');

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

            statusMessage.textContent = 'LiveAvatar embed created successfully.';
            avatarSessionStatus.textContent = 'LiveAvatar loaded. Click Chat now and allow microphone access.';

            liveAvatarDebug.innerHTML = `
    <strong>Embed URL:</strong> <a href="${data.embed_url}" target="_blank" rel="noopener">${data.embed_url}</a><br>
    <strong>Avatar ID:</strong> ${data.avatar_id || '-'}<br>
    <strong>Voice ID:</strong> ${data.voice_id || '-'}<br>
    <strong>Context ID:</strong> ${data.context_id || '-'}<br>
    <strong>Note:</strong> If Chat now fails, check LiveAvatar avatar/context/voice compatibility and billing.
`;

            setTimeout(() => {
                avatarSessionArea.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 300);

            console.log('LiveAvatar iframe inserted:', data.embed_url);
        } catch (error) {
            console.error('LiveAvatar embed error:', error);
            statusMessage.textContent = error.message || 'Unable to load LiveAvatar.';
            statusMessage.classList.add('text-danger');
        } finally {
            startBtn.disabled = false;
        }
    });

    if (missingHeyGenConfig.length) {
        startBtn.disabled = true;
        statusMessage.textContent = `HeyGen is not configured yet (${missingHeyGenConfig.join(', ')} missing).`;
    } else if (!allScenarios.length) {
        scenarioCards.innerHTML = '<div class="col-12"><div class="alert alert-warning mb-0">No practice scenarios are available yet. Please run database seeding.</div></div>';
        statusMessage.textContent = 'No scenarios found. Ask admin to run migrations and seeders.';
    } else {
        const firstScenario = allScenarios[0];
        const firstButton = scenarioCards.querySelector('.scenario-btn');
        if (firstButton) {
            firstButton.classList.add('active');
        }
        updateScenarioPreview(firstScenario);
    }
</script>
<style>
    .academy-liveavatar-section {
        width: 100%;
        margin-top: 32px;
        margin-bottom: 48px;
        position: relative;
        z-index: 2;
    }

    .academy-liveavatar-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        box-shadow: 0 12px 30px rgba(0,0,0,0.08);
        border-radius: 10px;
        overflow: hidden;
    }

    .academy-liveavatar-header {
        padding: 16px 20px;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
    }

    .academy-liveavatar-title {
        margin: 0;
        font-size: 20px;
        font-weight: 700;
    }

    .academy-liveavatar-status {
        margin: 4px 0 0;
        color: #6b7280;
        font-size: 14px;
    }

    .academy-liveavatar-frame-wrap {
        width: 100%;
        height: 680px;
        min-height: 680px;
        background: #000;
        overflow: hidden;
    }

    .academy-liveavatar-frame-wrap iframe {
        width: 100% !important;
        height: 680px !important;
        border: 0 !important;
        display: block !important;
        background: #000;
    }

    .academy-liveavatar-debug {
        padding: 12px 20px;
        background: #f9fafb;
        border-top: 1px solid #e5e7eb;
        font-size: 13px;
        color: #6b7280;
        word-break: break-all;
    }

    .academy-liveavatar-placeholder {
        color: #fff;
        min-height: 680px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #111;
    }


    .academy-evaluation-section {
        width: 100%;
        margin-bottom: 48px;
    }

    .academy-evaluation-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        box-shadow: 0 12px 30px rgba(0,0,0,0.08);
        border-radius: 10px;
        overflow: hidden;
    }

    .academy-evaluation-header,
    .academy-evaluation-body {
        padding: 20px;
    }

    .academy-evaluation-header {
        border-bottom: 1px solid #e5e7eb;
    }


    .academy-recording-controls {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        align-items: center;
    }

    .academy-audio-preview {
        width: 100%;
        display: block;
    }

    .academy-score-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 12px;
    }

    .academy-score-pill,
    .academy-evaluation-panel,
    .academy-evaluation-list,
    .academy-correction-item {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 14px;
    }

    .academy-score-pill span {
        display: block;
        color: #6b7280;
        font-size: 13px;
        margin-bottom: 4px;
    }

    .academy-score-pill strong {
        color: #111827;
        font-size: 22px;
    }

    .academy-evaluation-list h5,
    .academy-evaluation-panel h5 {
        font-size: 16px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .academy-corrections {
        display: grid;
        gap: 12px;
    }

    @media (max-width: 768px) {
        .academy-liveavatar-frame-wrap {
            height: 520px;
            min-height: 520px;
        }

        .academy-liveavatar-frame-wrap iframe {
            height: 520px !important;
        }

        .academy-liveavatar-header {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

@endsection
