@extends('layouts.main')

@section('title', $course->title)

@push('styles')
<style>
    .practice-course-page {
        background: linear-gradient(180deg, #F9F7E9 0%, #fff 100%);
        min-height: 100vh;
        padding: 42px 0 64px;
        color: #0A1D44;
    }

    .practice-course-header,
    .practice-course-video-card,
    .lesson-list-card {
        background: #fff;
        border-radius: 20px;
        border: 1px solid rgba(10, 29, 68, 0.08);
        box-shadow: 0 12px 30px rgba(10, 29, 68, 0.08);
    }

    .practice-course-header {
        padding: 22px;
        margin-bottom: 24px;
    }

    .practice-course-kicker {
        color: #FBC60C;
        font-size: .78rem;
        font-weight: 900;
        letter-spacing: .11em;
        text-transform: uppercase;
        margin-bottom: 6px;
    }

    .practice-course-title {
        color: #0A1D44;
        font-size: clamp(1.7rem, 4vw, 2.6rem);
        font-weight: 950;
        line-height: 1.05;
        margin-bottom: 10px;
    }

    .practice-course-description {
        color: #6B7280;
        max-width: 760px;
        margin-bottom: 18px;
        line-height: 1.55;
    }

    .course-progress-track {
        height: 10px;
        background: #eef2f7;
        border-radius: 999px;
        overflow: hidden;
    }

    .course-progress-fill {
        height: 100%;
        background: linear-gradient(135deg, #FBC60C, #EBD789);
        border-radius: 999px;
    }

    .practice-course-layout {
        display: grid;
        grid-template-columns: minmax(0, 1.48fr) minmax(300px, .78fr);
        gap: 24px;
        align-items: start;
    }

    .practice-course-video-card,
    .lesson-list-card {
        padding: 22px;
    }

    .lesson-info-panel {
        background: #ffffff;
        border-left: 4px solid #FBC60C;
        border-radius: 12px;
        padding: 20px;
        margin-top: 18px;
    }

    .lesson-current-box {
        background: #ffffff !important;
    }

    .practice-card-label {
        color: #FBC60C;
        font-size: .78rem;
        font-weight: 900;
        letter-spacing: .1em;
        text-transform: uppercase;
        margin-bottom: 8px;
    }

    .lesson-current-title {
        color: #0A1D44;
        font-size: clamp(1.35rem, 3vw, 2rem);
        font-weight: 900;
        margin-bottom: 8px;
    }

    .lesson-current-description {
        color: #6B7280;
        line-height: 1.55;
        margin-bottom: 18px;
    }

    .lesson-video-wrapper {
        width: 100%;
        aspect-ratio: 16 / 9;
        background: #050505;
        border-radius: 18px;
        overflow: hidden;
        position: relative;
    }

    .lesson-video-wrapper video,
    .lesson-video-wrapper iframe {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: contain;
        background: #050505;
        border: 0;
    }

    .lesson-video-empty {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgba(255, 255, 255, .84);
        text-align: center;
        padding: 24px;
    }

    .resume-message {
        border-radius: 14px;
        background: rgba(251, 198, 12, .16);
        border: 1px solid rgba(251, 198, 12, .26);
        padding: 12px 14px;
        margin: 16px 0 0;
        color: #0A1D44;
    }

    .practice-course-actions {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        margin-top: 22px;
    }

    .practice-course-actions-main {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .simple-btn {
        border-radius: 999px;
        padding: 10px 18px;
        font-weight: 850;
    }

    .btn-navy { background: #0A1D44; color: #fff; }
    .btn-navy:hover { color: #fff; background: #18386E; }
    .btn-yellow { background: #FBC60C; color: #0A1D44; }
    .btn-yellow:hover { background: #e7b505; color: #0A1D44; }

    .autoplay-card {
        border: 1px solid rgba(10, 29, 68, .08);
        background: #F9F7E9;
        border-radius: 16px;
        padding: 12px 14px;
        min-width: 250px;
    }

    .autoplay-card .form-check-label {
        font-weight: 850;
        color: #0A1D44;
    }

    .autoplay-card small {
        color: #6B7280;
        display: block;
        margin-top: 2px;
    }

    .lesson-list-card-title {
        color: #0A1D44;
        font-weight: 900;
        margin-bottom: 16px;
    }

    .lesson-list {
        display: grid;
        gap: 12px;
        max-height: 720px;
        overflow-y: auto;
        padding-right: 4px;
    }

    .lesson-section-header {
        background: #0A1D44;
        color: #FFFFFF;
        border-radius: 14px;
        padding: 12px 14px;
        font-weight: 900;
        width: 100%;
    }

    .lesson-list-item {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        padding: 14px;
        border-radius: 14px;
        border: 1px solid rgba(10, 29, 68, 0.08);
        background: #fff;
        color: #0A1D44;
        text-decoration: none;
        transition: transform .2s ease, border-color .2s ease, background .2s ease;
    }

    .lesson-list-item:hover {
        color: #0A1D44;
        transform: translateY(-1px);
        border-color: rgba(251, 198, 12, .45);
    }

    .lesson-list-item.active {
        background: #1A6FD4;
        border-color: #1A6FD4;
        color: #FFFFFF;
    }

    .lesson-list-item.active:hover,
    .lesson-list-item.active .lesson-list-meta {
        color: #FFFFFF;
    }

    .lesson-number {
        width: 34px;
        height: 34px;
        flex: 0 0 34px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(10, 29, 68, .08);
        color: #0A1D44;
        font-weight: 900;
    }

    .lesson-list-item.active .lesson-number {
        background: #FFFFFF;
        color: #1A6FD4;
    }

    .lesson-list-title {
        font-weight: 900;
        line-height: 1.25;
        margin-bottom: 4px;
    }

    .lesson-list-meta {
        color: #6B7280;
        font-size: .84rem;
        line-height: 1.35;
    }

    .lesson-status-badge {
        border-radius: 999px;
        padding: 5px 9px;
        font-size: .72rem;
        font-weight: 850;
        white-space: nowrap;
    }

    .lesson-status-completed { background: rgba(30, 122, 64, .13); color: #1e7a40; }
    .lesson-status-progress { background: rgba(251, 198, 12, .2); color: #0A1D44; }
    .lesson-status-not-started { background: #eef2f7; color: #6B7280; }

    @media (max-width: 768px) {
        .practice-course-page { padding: 24px 0 48px; }
        .practice-course-layout { grid-template-columns: 1fr; }
        .practice-course-header,
        .practice-course-video-card,
        .lesson-list-card { padding: 18px; }
        .practice-course-layout { display: flex; flex-direction: column; }
        .practice-course-video-card { display: flex; flex-direction: column; }
        .lesson-video-wrapper { order: 1; }
        .mobile-lesson-nav { order: 2; display: flex; }
        .practice-course-actions { order: 3; flex-direction: column; align-items: stretch; margin-top: 12px; }
        .autoplay-card { order: 1; }
        .practice-course-actions-main { order: 2; flex-direction: column; }
        .lesson-list-card { order: 2; }
        .lesson-info-panel { order: 4; margin-top: 14px; }
        .practice-course-actions .btn,
        .autoplay-card { width: 100%; }
        .lesson-list-item { align-items: flex-start; }
    }

    .mobile-lesson-nav {
        display: none;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-top: 12px;
    }

    @media (max-width: 768px) {
        .mobile-lesson-nav { display: flex; }
    }
</style>
@endpush

@section('content')
@php
    $videoUrl = $selectedLesson->video_source_url;
    $resumeSeconds = optional($selectedLesson->userProgress)->watched_seconds ?? 0;
    $isCompleted = optional($selectedLesson->userProgress)->is_completed ?? false;
    $canResume = $resumeSeconds > 5 && ! $isCompleted;
@endphp

<div class="practice-course-page">
    <div class="container">
        <header class="practice-course-header">
            <a href="{{ route('educonecx.academy.index') }}" class="btn btn-outline-secondary simple-btn mb-3"><i class="fas fa-arrow-left"></i> Back to Practice Room</a>
            <div class="practice-course-kicker">{{ $course->level ? ucfirst($course->level) . ' Course' : 'English Practice Course' }}</div>
            <h1 class="practice-course-title">{{ $course->title }}</h1>
            @if($course->description)
                <p class="practice-course-description">{{ $course->description }}</p>
            @endif
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-2">
                <strong>Progress: {{ $progressPercent }}%</strong>
                <span class="text-muted">Completed {{ $completedCount }} of {{ $lessons->count() }} lessons</span>
            </div>
            <div class="course-progress-track"><div class="course-progress-fill" style="width: {{ $progressPercent }}%"></div></div>
        </header>

        <div class="practice-course-layout">
            <main class="practice-course-video-card">
                <div class="lesson-video-wrapper">
                    @if(in_array($selectedLesson->video_type, ['upload', 'url']) && $videoUrl)
                        <video
                            id="lessonVideo"
                            controls
                            playsinline
                            preload="metadata"
                            controlsList="nodownload noplaybackrate"
                            disablePictureInPicture
                            oncontextmenu="return false;"
                        >
                            <source src="{{ $videoUrl }}" type="video/mp4">
                        </video>
                    @elseif($videoUrl)
                        <iframe src="{{ $videoUrl }}" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    @else
                        <div class="lesson-video-empty">
                            <div>
                                <i class="fas fa-video-slash fa-2x mb-3"></i>
                                <div>Video lesson is not available yet.</div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="mobile-lesson-nav">
                    @if($previousLesson)
                        <a href="{{ route('practice-room.courses.show', [$course, 'lesson' => $previousLesson->id]) }}" class="btn btn-outline-secondary simple-btn">Previous</a>
                    @else
                        <span></span>
                    @endif
                    <strong>{{ $lessons->search(fn ($lesson) => $lesson->id === $selectedLesson->id) + 1 }} / {{ $lessons->count() }}</strong>
                    @if($nextLesson)
                        <a href="{{ route('practice-room.courses.show', [$course, 'lesson' => $nextLesson->id]) }}" class="btn btn-outline-secondary simple-btn">Next</a>
                    @else
                        <span></span>
                    @endif
                </div>

                @if($canResume)
                    <div id="resumeMessage" class="resume-message">
                        Continue from <strong id="resumeTime"></strong>
                        <button type="button" id="startBeginningBtn" class="btn btn-sm btn-outline-dark ms-2">Start from beginning</button>
                    </div>
                @endif

                <div id="courseCompletedMessage" class="alert alert-success mt-3 d-none">Course completed. Great work!</div>

                <div class="practice-course-actions">
                    <div class="practice-course-actions-main">
                        <!-- Practice room shortcut hidden per client request.
                        <a href="{{ route('educonecx.academy.index', ['lesson_id' => $selectedLesson->id]) }}" class="btn btn-yellow simple-btn"><i class="fas fa-microphone-alt"></i> Practice This Lesson</a>
                        -->
                        <button type="button" id="markCompletedBtn" class="btn btn-yellow simple-btn"><i class="fas fa-check"></i> Mark as Completed</button>
                        @if($nextLesson)
                            <a href="{{ route('practice-room.courses.show', [$course, 'lesson' => $nextLesson->id]) }}" class="btn btn-navy simple-btn d-none d-md-inline-flex">Next Lesson</a>
                        @endif
                    </div>
                    <div class="autoplay-card">
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" id="autoplayNext" checked>
                            <label class="form-check-label" for="autoplayNext">Autoplay next lesson</label>
                            <small>Automatically continue when this lesson ends.</small>
                        </div>
                    </div>
                </div>

                <div class="lesson-info-panel lesson-current-box">
                    <div class="practice-card-label">Current Lesson</div>
                    <h2 class="lesson-current-title">{{ $selectedLesson->title }}</h2>
                    @if($selectedLesson->description)
                        <p class="lesson-current-description mb-0">{{ $selectedLesson->description }}</p>
                    @endif
                </div>
            </main>

            <aside class="lesson-list-card">
                <h3 class="lesson-list-card-title">Lessons</h3>
                <div class="lesson-list">
                    @php $currentModuleKey = null; @endphp
                    @foreach($lessons as $lesson)
                        @php
                            $progress = $lesson->userProgress;
                            $completed = optional($progress)->is_completed;
                            $started = optional($progress)->watched_seconds > 0;
                            $statusClass = $completed ? 'lesson-status-completed' : ($started ? 'lesson-status-progress' : 'lesson-status-not-started');
                            $statusText = $completed ? 'Completed' : ($started ? 'In Progress' : 'Not Started');
                            $moduleKey = $lesson->module?->id ?: 'unassigned';
                            $moduleTitle = $lesson->module?->title ?: 'Course Lessons';
                            $lessonMeta = ($lesson->duration_seconds ?? 0) > 0 ? gmdate($lesson->duration_seconds >= 3600 ? 'H:i:s' : 'i:s', $lesson->duration_seconds) : '';
                        @endphp
                        @if($moduleKey !== $currentModuleKey)
                            <div class="lesson-section-header">{{ $moduleTitle }}</div>
                            @php $currentModuleKey = $moduleKey; @endphp
                        @endif
                        <a class="lesson-list-item {{ $lesson->id === $selectedLesson->id ? 'active' : '' }}" href="{{ route('practice-room.courses.show', [$course, 'lesson' => $lesson->id]) }}">
                            <span class="lesson-number">{{ $loop->iteration }}</span>
                            <span class="flex-grow-1">
                                <span class="lesson-list-title d-block">{{ $lesson->title }}</span>
                                @if(($lesson->duration_seconds ?? 0) > 0)
                                    <span class="lesson-list-meta lesson-duration d-block">{{ $lessonMeta }}</span>
                                @endif
                            </span>
                            <span class="text-end">
                                <span class="lesson-status-badge {{ $statusClass }}">{{ $statusText }}</span>
                                <span class="d-block small fw-semibold mt-2">Watch</span>
                            </span>
                        </a>
                    @endforeach
                </div>
            </aside>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    const video = document.getElementById('lessonVideo');
    if (!video) return;

    const progressUrl = @json(route('practice-room.lessons.progress', $selectedLesson));
    const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
    const resumeSeconds = {{ (int) $resumeSeconds }};
    const shouldResume = {{ $canResume ? 'true' : 'false' }};
    const nextUrl = @json($nextLesson ? route('practice-room.courses.show', [$course, 'lesson' => $nextLesson->id]) : null);
    const autoplayToggle = document.getElementById('autoplayNext');
    const completedMessage = document.getElementById('courseCompletedMessage');
    const markCompletedBtn = document.getElementById('markCompletedBtn');
    let lastSavedAt = 0;

    function formatTime(seconds) {
        seconds = Math.max(0, Math.floor(seconds || 0));
        const minutes = Math.floor(seconds / 60);
        const remainingSeconds = seconds % 60;
        return String(minutes).padStart(2, '0') + ':' + String(remainingSeconds).padStart(2, '0');
    }

    const resumeTime = document.getElementById('resumeTime');
    if (resumeTime) resumeTime.textContent = formatTime(resumeSeconds);

    video.addEventListener('loadedmetadata', function () {
        if (shouldResume && resumeSeconds < video.duration) {
            video.currentTime = resumeSeconds;
        }
    }, { once: true });

    async function saveProgress(isCompleted = false, useBeacon = false) {
        if (!video.duration && !isCompleted) return;
        const payload = {
            watched_seconds: Math.floor(video.currentTime || 0),
            duration_seconds: Math.floor(video.duration || {{ (int) ($selectedLesson->duration_seconds ?? 0) }}),
            is_completed: Boolean(isCompleted)
        };

        if (useBeacon && navigator.sendBeacon) {
            const body = new Blob([JSON.stringify({...payload, _token: csrf})], { type: 'application/json' });
            navigator.sendBeacon(progressUrl, body);
            return;
        }

        await fetch(progressUrl, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf },
            body: JSON.stringify(payload),
            keepalive: true
        });
    }

    video.addEventListener('timeupdate', function () {
        if (video.currentTime - lastSavedAt >= 10) {
            lastSavedAt = video.currentTime;
            saveProgress(false).catch(() => {});
        }
    });

    video.addEventListener('pause', () => saveProgress(false).catch(() => {}));
    window.addEventListener('beforeunload', () => saveProgress(false, true));
    markCompletedBtn?.addEventListener('click', async function () {
        markCompletedBtn.disabled = true;
        await saveProgress(true).catch(() => { markCompletedBtn.disabled = false; });
        markCompletedBtn.innerHTML = '<i class="fas fa-check"></i> Completed';
    });

    video.addEventListener('ended', async function () {
        await saveProgress(true).catch(() => {});
        if (nextUrl && autoplayToggle?.checked) {
            window.location.href = nextUrl;
        } else if (!nextUrl && completedMessage) {
            completedMessage.classList.remove('d-none');
        }
    });

    document.getElementById('startBeginningBtn')?.addEventListener('click', function () {
        video.currentTime = 0;
        document.getElementById('resumeMessage')?.classList.add('d-none');
        saveProgress(false).catch(() => {});
    });
})();
</script>
@endpush
