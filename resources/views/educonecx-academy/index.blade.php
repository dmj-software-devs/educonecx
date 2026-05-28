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
            <div class="col-lg-5">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <h3 class="section-title mb-3">Choose Practice Scenario</h3>
                        <div class="row g-3" id="scenarioCards"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
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

                <div id="avatarSessionArea" class="card shadow-sm border-0 mt-4 d-none">
                    <div class="card-body">
                        <h4 class="card-title">Live Avatar Session</h4>
                        <p class="text-muted" id="avatarSessionStatus">Initializing...</p>
                        <div id="avatarMount" class="border rounded p-3" style="min-height: 280px; background:#f8f9fa;">
                            {{-- TODO(LiveAvatar SDK): Replace this placeholder with official LiveAvatar Web SDK renderer mount call. --}}
                        </div>
                    </div>
                </div>

                <div id="feedbackArea" class="card shadow-sm border-0 mt-4 d-none">
                    <div class="card-body">
                        <h4 class="card-title">Session Feedback</h4>
                        <p class="mb-0" id="feedbackText">Feedback and score will appear here after session completion.</p>
                    </div>
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

    let selectedScenario = null;
    let academySessionId = null;
    let liveAvatarToken = null;

    const updateScenarioPreview = (scenario) => {
        selectedScenario = scenario;
        startBtn.disabled = !selectedScenario;

        if (!selectedScenario) {
            scenarioPreview.innerHTML = `
                <h4 class="card-title">Select a scenario to preview</h4>
                <p class="text-muted mb-0">Category, level, practice text, and sample questions will appear here.</p>
            `;
            return;
        }

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

    startBtn.addEventListener('click', async function () {
        if (!selectedScenario) {
            statusMessage.textContent = 'Please select a scenario first.';
            return;
        }

        statusMessage.textContent = 'Requesting LiveAvatar session token...';
        startBtn.disabled = true;

        try {
            const response = await fetch("{{ route('educonecx.academy.liveavatar.token') }}", {
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
            } catch (e) {
                throw new Error('Server returned an unexpected response. Please refresh and try again.');
            }

            if (!response.ok || !data.success) {
                throw new Error(data.message || 'Unable to generate LiveAvatar token.');
            }

            liveAvatarToken = data.token;
            academySessionId = null;
            avatarSessionArea.classList.remove('d-none');

            statusMessage.textContent = 'Token generation success. Ready to initialize LiveAvatar SDK.';
            avatarSessionStatus.textContent = 'SDK initialization pending...';

            const avatarMount = document.getElementById('avatarMount');
            avatarMount.innerHTML = `
                <div class="small text-muted">
                    <p class="mb-1"><strong>Token:</strong> Generated ✅</p>
                    <p class="mb-1"><strong>Endpoint:</strong> ${data.endpoint_url || 'https://api.liveavatar.com/v1/sessions/token'}</p>
                    <p class="mb-1"><strong>Avatar:</strong> ${data.avatar_id || '-'}</p>
                    <p class="mb-1"><strong>Voice:</strong> ${data.voice_id || '-'}</p>
                    <p class="mb-0"><strong>Context:</strong> ${data.context_id || '-'}</p>
                </div>
                <hr>
                <p class="mb-1"><strong>SDK init status:</strong> TODO</p>
                <p class="mb-1"><strong>Avatar mount status:</strong> Placeholder rendered ✅</p>
                <p class="mb-0"><strong>Microphone/audio:</strong> TODO (connect via official LiveAvatar Web SDK)</p>
            `;

            // TODO(LiveAvatar SDK): Initialize official Web SDK with server token/config response.
            // Example placeholder flow:
            // 1) create SDK client with token/config from backend
            // 2) mount avatar into #avatarMount
            // 3) request/connect microphone/audio
            // 4) start realtime interaction from frontend
            avatarSessionStatus.textContent = 'SDK placeholder ready. Implement official LiveAvatar Web SDK initialization here.';
        } catch (error) {
            statusMessage.textContent = error.message || 'Unable to generate LiveAvatar token.';
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
@endsection
