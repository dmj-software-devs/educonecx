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

                <div id="avatarSessionArea" class="card shadow-sm border-0 mt-4 d-none" style="display:none;">
                    <div class="card-body">
                        <h4 class="card-title">Live Avatar Session</h4>
                        <p class="text-muted" id="avatarSessionStatus">Initializing...</p>
                        <div id="avatarMount" class="border rounded p-0 overflow-hidden" style="width:100%; min-height:560px; background:#000;"></div>
                        <div id="liveAvatarDebug" class="small text-muted mt-2"></div>
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
    const avatarMount = document.getElementById('avatarMount');

    let selectedScenario = null;
    let academySessionId = null;
    let liveAvatarToken = null;
    let liveAvatarClient = null;

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

            const avatarSessionArea = document.getElementById('avatarSessionArea');
            const avatarMount = document.getElementById('avatarMount');

            if (!data.embed_url) {
                throw new Error('LiveAvatar embed URL missing from response.');
            }

            avatarSessionArea.classList.remove('d-none');
            avatarSessionArea.style.display = 'block';
            avatarSessionArea.style.visibility = 'visible';
            avatarSessionArea.style.opacity = '1';

            avatarMount.classList.remove('d-none');
            avatarMount.style.display = 'block';
            avatarMount.style.visibility = 'visible';
            avatarMount.style.opacity = '1';
            avatarMount.style.width = '100%';
            avatarMount.style.minHeight = '560px';
            avatarMount.style.background = '#000';
            avatarMount.style.padding = '0';
            avatarMount.style.overflow = 'hidden';

            avatarMount.innerHTML = '';

            const iframe = document.createElement('iframe');
            iframe.src = data.embed_url;
            iframe.title = 'LiveAvatar Embed';
            iframe.allow = 'microphone; camera; autoplay; fullscreen; clipboard-read; clipboard-write';
            iframe.allowFullscreen = true;
            iframe.style.width = '100%';
            iframe.style.height = '560px';
            iframe.style.minHeight = '560px';
            iframe.style.border = '0';
            iframe.style.display = 'block';
            iframe.style.background = '#000';

            iframe.onload = function () {
                console.log('LiveAvatar iframe loaded successfully:', data.embed_url);
                avatarSessionStatus.textContent = 'LiveAvatar loaded. Please allow microphone access.';
            };

            iframe.onerror = function () {
                console.error('LiveAvatar iframe failed to load:', data.embed_url);
                avatarSessionStatus.textContent = 'LiveAvatar iframe failed to load. Use the fallback link below.';
            };

            avatarMount.appendChild(iframe);

            const fallback = document.createElement('div');
            fallback.className = 'p-3 bg-light border-top';
            fallback.innerHTML = `
                <p class="mb-2">If the avatar does not appear, open it directly:</p>
                <a href="${data.embed_url}" target="_blank" rel="noopener" class="btn btn-primary">
                    Open LiveAvatar Session
                </a>
            `;
            avatarMount.appendChild(fallback);

            statusMessage.textContent = 'LiveAvatar embed created successfully.';
            avatarSessionStatus.textContent = 'Loading LiveAvatar iframe...';

            document.getElementById('liveAvatarDebug').innerHTML = `
                <strong>Embed URL:</strong> ${data.embed_url}<br>
                <strong>Avatar ID:</strong> ${data.avatar_id || '-'}<br>
                <strong>Context ID:</strong> ${data.context_id || '-'}
            `;

            console.log('LiveAvatar embed response:', data);
            console.log('avatarSessionArea display:', window.getComputedStyle(avatarSessionArea).display);
            console.log('avatarMount display:', window.getComputedStyle(avatarMount).display);
            console.log('iframe src:', iframe.src);

            setTimeout(() => {
                avatarSessionArea.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 300);
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
@endsection
