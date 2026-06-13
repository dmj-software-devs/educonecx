@extends('layouts.main')

@section('title', $course->title)

@push('styles')
<style>
    .course-player-page { background: #F9F7E9; min-height: 100vh; padding: 46px 0; color: #0A1D44; }
    .course-player-shell { display: grid; grid-template-columns: minmax(0, 1.45fr) minmax(280px, 0.75fr); gap: 24px; align-items: start; }
    .course-panel { background: #fff; border: 1px solid rgba(10,29,68,.09); border-radius: 20px; box-shadow: 0 14px 32px rgba(10,29,68,.08); overflow: hidden; }
    .course-panel-body { padding: 22px; }
    .lesson-video-wrapper { position: relative; width: 100%; aspect-ratio: 16 / 9; background: #000; border-radius: 18px; overflow: hidden; }
    .lesson-video-wrapper video, .lesson-video-wrapper iframe { width: 100%; height: 100%; display: block; object-fit: contain; border: 0; }
    .course-progress-bar { height: 12px; background: #eef2f7; border-radius: 999px; overflow: hidden; }
    .course-progress-fill { height: 100%; background: linear-gradient(90deg, #FBC60C, #2E5C61); border-radius: inherit; }
    .lesson-list { display: flex; flex-direction: column; gap: 10px; }
    .lesson-item { border: 1px solid rgba(10,29,68,.09); border-radius: 14px; padding: 14px; text-decoration: none; color: #0A1D44; background: #fff; display: flex; justify-content: space-between; gap: 12px; }
    .lesson-item.active { border-color: #FBC60C; background: rgba(251,198,12,.12); }
    .lesson-item.completed { border-color: rgba(46,92,97,.28); }
    .simple-btn { border-radius: 999px; padding: 10px 16px; font-weight: 800; }
    .btn-navy { background: #0A1D44; color: #fff; } .btn-navy:hover { color: #fff; background: #18386E; }
    .btn-yellow { background: #FBC60C; color: #0A1D44; } .btn-yellow:hover { background: #e7b505; color: #0A1D44; }
    .resume-message { border-radius: 14px; background: rgba(251,198,12,.16); padding: 12px 14px; margin: 14px 0; }
    @media (max-width: 991px) { .course-player-shell { grid-template-columns: 1fr; } .course-player-page { padding: 24px 0; } .course-panel-body { padding: 16px; } }
</style>
@endpush

@section('content')
<div class="course-player-page">
    <div class="container">
        <div class="mb-4">
            <a href="{{ route('educonecx.academy.index') }}" class="btn btn-outline-secondary simple-btn mb-3"><i class="fas fa-arrow-left"></i> Practice Room</a>
            <h1 class="fw-bold mb-2">{{ $course->title }}</h1>
            <p class="text-muted mb-3">{{ $course->description }}</p>
            <div class="d-flex flex-wrap align-items-center gap-3">
                <div style="min-width:220px; flex:1; max-width:420px;">
                    <div class="course-progress-bar"><div class="course-progress-fill" style="width: {{ $progressPercent }}%"></div></div>
                </div>
                <strong>{{ $progressPercent }}% Completed</strong>
                <span class="text-muted">{{ $completedCount }} of {{ $lessons->count() }} lessons</span>
            </div>
        </div>

        <div class="course-player-shell">
            <main class="course-panel">
                <div class="course-panel-body">
                    <h2 class="fw-bold mb-2">{{ $selectedLesson->title }}</h2>
                    @if($selectedLesson->description)<p class="text-muted">{{ $selectedLesson->description }}</p>@endif

                    @php
                        $videoUrl = $selectedLesson->video_source_url;
                        $resumeSeconds = optional($selectedLesson->userProgress)->watched_seconds ?? 0;
                        $isCompleted = optional($selectedLesson->userProgress)->is_completed ?? false;
                        $canResume = $resumeSeconds > 5 && ! $isCompleted;
                    @endphp

                    <div class="lesson-video-wrapper">
                        @if(in_array($selectedLesson->video_type, ['upload', 'url']) && $videoUrl)
                            <video id="lessonVideo" controls playsinline preload="metadata">
                                <source src="{{ $videoUrl }}" type="video/mp4">
                            </video>
                        @elseif($videoUrl)
                            <iframe src="{{ $videoUrl }}" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                        @else
                            <div class="d-flex h-100 align-items-center justify-content-center text-white">No video added yet.</div>
                        @endif
                    </div>

                    @if($canResume)
                        <div id="resumeMessage" class="resume-message">
                            Continue from <strong id="resumeTime"></strong>
                            <button type="button" id="startBeginningBtn" class="btn btn-sm btn-outline-dark ms-2">Start from Beginning</button>
                        </div>
                    @endif

                    <div id="courseCompletedMessage" class="alert alert-success mt-3 d-none">Course completed. Great work!</div>

                    <div class="d-flex flex-wrap align-items-center gap-2 mt-4">
                        <a href="{{ route('educonecx.academy.index', ['lesson_id' => $selectedLesson->id]) }}" class="btn btn-yellow simple-btn"><i class="fas fa-microphone-alt"></i> Practice This Lesson</a>
                        @if($nextLesson)
                            <a href="{{ route('practice-room.courses.show', [$course, 'lesson' => $nextLesson->id]) }}" class="btn btn-navy simple-btn">Next Lesson</a>
                        @endif
                        <label class="ms-auto d-flex align-items-center gap-2 fw-semibold">
                            <input type="checkbox" id="autoplayNext" checked> Autoplay next lesson
                        </label>
                    </div>
                </div>
            </main>

            <aside class="course-panel">
                <div class="course-panel-body">
                    <h3 class="fw-bold mb-3">Lessons</h3>
                    <div class="lesson-list">
                        @foreach($lessons as $lesson)
                            @php($completed = optional($lesson->userProgress)->is_completed)
                            <a class="lesson-item {{ $lesson->id === $selectedLesson->id ? 'active' : '' }} {{ $completed ? 'completed' : '' }}" href="{{ route('practice-room.courses.show', [$course, 'lesson' => $lesson->id]) }}">
                                <span><strong>{{ $lesson->title }}</strong><br><small class="text-muted">{{ $lesson->module?->title ?? 'Watch Lesson' }}</small></span>
                                <span>{{ $completed ? 'Completed' : 'Watch' }}</span>
                            </a>
                        @endforeach
                    </div>
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
