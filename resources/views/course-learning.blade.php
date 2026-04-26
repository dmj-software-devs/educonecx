@extends('layouts.main')

@section('title', $course->title . ' - Learning')

@section('content')
<div class="learning-container">
    <!-- Header -->
    <div class="learning-header">
        <div class="container">
            <div class="learning-header-content">
                <div class="learning-header-left">
                    <h1 class="learning-title">{{ $course->title }}</h1>
                    <div class="learning-progress">
                        <span class="progress-text">Your Progress: {{ $enrollment->progress }}%</span>
                        <div class="progress-bar-container">
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: {{ $enrollment->progress }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="{{ route('courses.show', $course->slug) }}" class="learning-back-btn">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to Course</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="learning-main">
        <div class="container">
            <div class="learning-grid">
                <!-- Video Player Section -->
                <div class="learning-video-section">
                    <div class="video-player-container" id="videoContainer">
                        <div class="video-player" id="videoPlayer">
                            <div class="video-placeholder">
                                <i class="fas fa-play-circle"></i>
                                <p>Select a lesson to start learning</p>
                            </div>
                        </div>
                    </div>

                    <!-- Lesson Navigation Controls -->
                    <div class="lesson-nav-controls" id="lessonNavControls" style="display: none;">
                        <button class="lesson-nav-btn" id="prevLessonBtn" onclick="navigateLesson('prev')" disabled title="Previous lesson (← key)">
                            <i class="fas fa-step-backward"></i>
                            <span class="lesson-nav-label">
                                <small>Previous</small>
                                <strong id="prevLessonName">Previous Lesson</strong>
                            </span>
                        </button>

                        <div class="lesson-nav-center">
                            <div class="current-lesson-indicator">
                                <span id="lessonNavCurrent">1</span> / <span id="lessonNavTotal">1</span>
                                <span class="lesson-elapsed-timer" id="lessonElapsedTime" title="Time on this lesson">00:00</span>
                            </div>
                            <div class="lesson-nav-title" id="currentLessonNavTitle">Lesson Title</div>
                        </div>

                        <button class="lesson-nav-btn lesson-nav-btn--next" id="nextLessonBtn" onclick="navigateLesson('next')" disabled title="Next lesson (→ key)">
                            <span class="lesson-nav-label">
                                <small>Next</small>
                                <strong id="nextLessonName">Next Lesson</strong>
                            </span>
                            <i class="fas fa-step-forward"></i>
                        </button>
                    </div>

                    <!-- Autoplay Toggle -->
                    <div class="autoplay-toggle-container">
                        <div class="autoplay-toggle-wrap" id="autoplayToggleWrap">
                            <i class="fas fa-forward autoplay-icon"></i>
                            <span class="autoplay-label">Autoplay</span>
                            <button class="autoplay-switch" id="autoplaySwitch" role="switch" aria-checked="true">
                                <span class="autoplay-switch-thumb"></span>
                            </button>
                            <span class="autoplay-status" id="autoplayStatus">On</span>
                        </div>
                    </div>

                    <div class="lesson-content-container" id="lessonContent">
                        <div class="lesson-content-placeholder">
                            <i class="fas fa-book-open"></i>
                            <h3>Ready to Start Learning?</h3>
                            <p>Choose a lesson from the curriculum to begin your learning journey.</p>
                        </div>
                    </div>
                </div>

                <!-- Curriculum Sidebar -->
                <div class="learning-sidebar">
                    <div class="curriculum-container">
                        <div class="curriculum-header">
                            <h3>Course Curriculum</h3>
                            <span class="lessons-count">{{ $course->sections->sum(fn($s) => $s->lessons->count()) }} lessons</span>
                        </div>

                        @foreach($course->sections as $sectionIndex => $section)
                        <div class="curriculum-section">
                            <div class="section-header" data-section="{{ $sectionIndex }}">
                                <div class="section-title">
                                    <i class="fas fa-chevron-right"></i>
                                    <h4>{{ $section->title }}</h4>
                                </div>
                                <span class="section-meta">{{ $section->lessons->count() }} lessons</span>
                            </div>

                            <div class="section-lessons" id="section-{{ $sectionIndex }}">
                                @foreach($section->lessons as $lessonIndex => $lesson)
                                @php
                                    $isCompleted = in_array($lesson->id, $completedLessons ?? []);
                                    $isCurrent = false;
                                    if (request()->has('lesson')) {
                                        $isCurrent = request()->get('lesson') == $lesson->id;
                                    } elseif ($currentLesson ?? null) {
                                        $isCurrent = $currentLesson->id == $lesson->id;
                                    }
                                @endphp
                                <div class="lesson-item {{ $isCompleted ? 'completed' : '' }} {{ $isCurrent ? 'current' : '' }}"
                                    data-lesson-id="{{ $lesson->id }}"
                                    data-lesson-title="{{ $lesson->title }}"
                                    data-lesson-duration="{{ $lesson->duration_formatted }}"
                                    data-video-url="{{ $lesson->video_url_full ?? '' }}"
                                    data-video-type="{{ $lesson->video_type ?? 'youtube' }}"
                                    data-content="{{ $lesson->content ?? '' }}"
                                    data-description="{{ $lesson->description ?? '' }}"
                                    data-is-preview="{{ $lesson->is_preview ? 'true' : 'false' }}"
                                    data-attachment="{{ $lesson->attachment_url ?? '' }}">
                                    <div class="lesson-status">
                                        @if($isCompleted)
                                            <i class="fas fa-check-circle"></i>
                                        @elseif($isCurrent)
                                            <i class="fas fa-play-circle"></i>
                                        @else
                                            <i class="fas fa-circle"></i>
                                        @endif
                                    </div>
                                    <div class="lesson-info">
                                        <span class="lesson-title">{{ $lesson->title }}</span>
                                        <span class="lesson-duration">{{ $lesson->duration_formatted }}</span>
                                    </div>
                                    @if($lesson->is_preview)
                                        <span class="preview-badge">Preview</span>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach

                        <!-- Course Stats -->
                        <div class="course-stats">
                            <div class="stat-item">
                                <i class="fas fa-check-circle"></i>
                                <div>
                                    <span class="stat-value">{{ count($completedLessons) }}/{{ $course->lessons->count() }}</span>
                                    <span class="stat-label">Lessons Completed</span>
                                </div>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-clock"></i>
                                <div>
                                    <span class="stat-value">{{ $enrollment->updated_at->diffForHumans() }}</span>
                                    <span class="stat-label">Last Accessed</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Lesson Completion Modal -->
<div class="modal fade" id="lessonCompleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">🎉 Lesson Completed!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Great job! You've completed this lesson.</p>
                <div class="next-lesson-suggestion" id="nextLessonSuggestion"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Stay Here</button>
                <button type="button" class="btn btn-primary" id="continueToNextLesson" style="display: none;">
                    <i class="fas fa-arrow-right"></i> Next Lesson
                </button>
                <a href="{{ route('courses.show', $course->slug) }}" class="btn btn-success" id="courseCompletedBtn" style="display: none;">
                    View Certificate
                </a>
            </div>
        </div>
    </div>
</div>

<style>
/* ============================================================
   ROOT VARIABLES
============================================================ */
:root {
    --bright-amber: #FBC60C;
    --khaki-beige:  #9F9A87;
    --pure-white:   #FEFDFE;
    --prussian-blue:#0A1D44;
    --regal-navy:   #18386E;
    --sky-blue:     #5AD1E4;
    --pale-slate:   #CBD1DA;
    --dark-slate:   #2E5C61;
    --ivory:        #F9F7E9;
    --light-gold:   #EBD789;

    --text-primary:   #0A1D44;
    --text-secondary: #2E5C61;
    --text-muted:     #5f5f5f;

    --gradient-1: linear-gradient(135deg, #0A1D44 0%, #18386E 50%, #2E5C61 100%);
    --gradient-2: linear-gradient(45deg,  #FBC60C 0%, #EBD789 50%, #F9F7E9 100%);
    --gradient-3: linear-gradient(135deg, #5AD1E4 0%, #CBD1DA 50%, #FEFDFE 100%);

    --shadow-sm:    0 2px 8px  rgba(10,29,68,0.08);
    --shadow-md:    0 4px 12px rgba(10,29,68,0.12);
    --shadow-lg:    0 8px 24px rgba(10,29,68,0.15);
    --shadow-hover: 0 12px 28px rgba(251,198,12,0.2);

    --radius-sm:   8px;
    --radius-md:   12px;
    --radius-lg:   16px;
    --radius-full: 9999px;
    --transition:  all 0.3s ease;
}

/* ============================================================
   PAGE
============================================================ */
.learning-container {
    min-height: 100vh;
    background: linear-gradient(135deg, var(--ivory) 0%, var(--pure-white) 100%);
}

/* ============================================================
   HEADER
============================================================ */
.learning-header {
    background: var(--pure-white);
    padding: 20px 0;
    box-shadow: var(--shadow-md);
    position: sticky; top: 0; z-index: 100;
    border-bottom: 2px solid rgba(251,198,12,0.25);
}
.learning-header-content {
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: 20px;
}
.learning-header-left { flex: 1; min-width: 280px; }
.learning-title { font-size: 1.5rem; font-weight: 700; margin: 0 0 15px 0; color: var(--text-primary); line-height: 1.3; }
.learning-progress { display: flex; align-items: center; gap: 15px; flex-wrap: wrap; }
.progress-text { font-size: .95rem; font-weight: 500; color: var(--text-secondary); min-width: 120px; }
.progress-bar-container { flex: 1; min-width: 200px; }
.progress-bar { width: 100%; height: 8px; background: var(--pale-slate); border-radius: var(--radius-full); overflow: hidden; }
.progress-fill {
    height: 100%; background: var(--gradient-1);
    transition: width .5s cubic-bezier(.34,1.56,.64,1);
    border-radius: var(--radius-full); position: relative; overflow: hidden;
}
.progress-fill::after {
    content:''; position:absolute; inset:0;
    background:linear-gradient(90deg,transparent,rgba(255,255,255,.3),transparent);
    animation:shimmer 2s infinite;
}
@keyframes shimmer { 0%{transform:translateX(-100%)} 100%{transform:translateX(100%)} }

.learning-back-btn {
    display:inline-flex; align-items:center; gap:8px; padding:12px 24px;
    background:var(--ivory); color:var(--text-primary); text-decoration:none;
    border-radius:var(--radius-full); transition:var(--transition);
    border:1px solid rgba(251,198,12,.2); font-weight:500;
}
.learning-back-btn:hover { background:var(--gradient-2); color:var(--prussian-blue); transform:translateX(-5px); border-color:transparent; }
.learning-back-btn i { font-size:.9rem; transition:var(--transition); }
.learning-back-btn:hover i { transform:translateX(-3px); }

/* ============================================================
   LAYOUT
============================================================ */
.learning-main { padding: 40px 0; }
.learning-grid { display:grid; grid-template-columns:1fr 380px; gap:30px; }
.learning-video-section { min-width:0; }

/* ============================================================
   ██╗   ██╗██╗██████╗ ███████╗ ██████╗     ██████╗ ██╗      █████╗ ██╗   ██╗███████╗██████╗ 
   ██║   ██║██║██╔══██╗██╔════╝██╔═══██╗    ██╔══██╗██║     ██╔══██╗╚██╗ ██╔╝██╔════╝██╔══██╗
   ██║   ██║██║██║  ██║█████╗  ██║   ██║    ██████╔╝██║     ███████║ ╚████╔╝ █████╗  ██████╔╝
   ╚██╗ ██╔╝██║██║  ██║██╔══╝  ██║   ██║    ██╔═══╝ ██║     ██╔══██║  ╚██╔╝  ██╔══╝  ██╔══██╗
    ╚████╔╝ ██║██████╔╝███████╗╚██████╔╝    ██║     ███████╗██║  ██║   ██║   ███████╗██║  ██║
     ╚═══╝  ╚═╝╚═════╝ ╚══════╝ ╚═════╝     ╚═╝     ╚══════╝╚═╝  ╚═╝   ╚═╝   ╚══════╝╚═╝  ╚═╝
============================================================ */

/* --- Container --- */
.video-player-container {
    background: #060d1a;
    border-radius: 14px;
    overflow: hidden;
    margin-bottom: 16px;
    aspect-ratio: 16/9;
    position: relative;
    user-select: none;
    box-shadow:
        0 0 0 1px rgba(251,198,12,.1),
        0 4px 20px rgba(0,0,0,.4),
        0 20px 60px rgba(0,0,0,.35);
}
.video-player {
    width: 100%; height: 100%;
    display: flex; align-items: center; justify-content: center;
    position: relative;
}
.video-placeholder {
    text-align: center; color: rgba(255,255,255,.7); padding: 40px;
    pointer-events: none;
}
.video-placeholder i { font-size: 5rem; margin-bottom: 16px; color: var(--bright-amber); opacity: .35; display: block; }
.video-placeholder p { font-size: 1rem; opacity: .6; margin: 0; }

/* Fullscreen CSS */
.video-player-container:-webkit-full-screen,
.video-player-container:fullscreen {
    width: 100vw; height: 100vh;
    background: #000; border-radius: 0;
}
.video-player-container:-webkit-full-screen .video-player,
.video-player-container:fullscreen .video-player { height: 100vh; }
.video-player-container:-webkit-full-screen iframe,
.video-player-container:fullscreen iframe,
.video-player-container:-webkit-full-screen video,
.video-player-container:fullscreen video {
    width: 100vw; height: 100vh; object-fit: contain;
}

/* --- Media wrap fills container --- */
.vp-media-wrap { position: absolute; inset: 0; z-index: 5; }
.vp-media-wrap iframe,
.vp-media-wrap video { width: 100%; height: 100%; display: block; border: none; }

/* Right-click shield — pointer-events none so hover still fires on container */
.vp-shield {
    position: absolute; inset: 0; z-index: 6;
    background: transparent; pointer-events: none;
}

/* --- Ambient glow at bottom (cinematic depth) --- */
.video-player-container::after {
    content: '';
    position: absolute; bottom: 0; left: 0; right: 0;
    height: 40%;
    background: linear-gradient(to top, rgba(6,13,26,.9) 0%, transparent 100%);
    z-index: 7; pointer-events: none;
    opacity: 0;
    transition: opacity .3s ease;
}
.video-player-container:hover::after { opacity: 1; }

/* --- Loading spinner --- */
.vp-spinner {
    position: absolute; top: 50%; left: 50%;
    transform: translate(-50%,-50%);
    width: 52px; height: 52px; z-index: 30;
}
.vp-spinner::before,
.vp-spinner::after {
    content: ''; position: absolute; inset: 0;
    border-radius: 50%; border: 2.5px solid transparent;
}
.vp-spinner::before {
    border-top-color: var(--bright-amber);
    border-right-color: rgba(251,198,12,.25);
    animation: vp-spin .7s linear infinite;
}
.vp-spinner::after {
    inset: 8px;
    border-top-color: rgba(251,198,12,.4);
    animation: vp-spin 1.1s linear infinite reverse;
}
@keyframes vp-spin { to { transform: rotate(360deg); } }

/* --- Lesson title overlay (top bar) --- */
.vp-title-bar {
    position: absolute; top: 0; left: 0; right: 0;
    z-index: 25;
    padding: 18px 20px 40px;
    background: linear-gradient(to bottom, rgba(6,13,26,.85) 0%, transparent 100%);
    opacity: 0;
    transform: translateY(-6px);
    transition: opacity .28s ease, transform .28s ease;
    pointer-events: none;
}
.video-player-container:hover .vp-title-bar,
.video-player-container.vp-paused .vp-title-bar { opacity: 1; transform: translateY(0); }
.vp-title-bar-inner {
    display: flex; align-items: center; gap: 10px;
}
.vp-title-bar-badge {
    background: var(--bright-amber); color: var(--prussian-blue);
    font-size: .6rem; font-weight: 800;
    text-transform: uppercase; letter-spacing: .1em;
    padding: 3px 8px; border-radius: 4px; flex-shrink: 0;
}
.vp-title-bar-text {
    font-size: .88rem; font-weight: 600; color: rgba(255,255,255,.9);
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}

/* --- Big centre play / pause button --- */
.vp-centre-btn {
    position: absolute; top: 50%; left: 50%;
    transform: translate(-50%,-50%) scale(.85);
    width: 80px; height: 80px; border-radius: 50%;
    background: rgba(251,198,12,.92);
    border: none; cursor: pointer; z-index: 28;
    display: flex; align-items: center; justify-content: center;
    font-size: 2rem; color: var(--prussian-blue);
    opacity: 0; pointer-events: none;
    transition: transform .2s cubic-bezier(.34,1.56,.64,1), opacity .2s ease, background .15s ease;
}
.vp-centre-btn.visible {
    opacity: 1; pointer-events: all;
    transform: translate(-50%,-50%) scale(1);
    animation: vpPulse 2.5s ease infinite;
}
.vp-centre-btn:hover { background: var(--bright-amber); transform: translate(-50%,-50%) scale(1.1) !important; animation: none !important; }
@keyframes vpPulse {
    0%,100% { box-shadow: 0 0 0 0 rgba(251,198,12,.45); }
    50%      { box-shadow: 0 0 0 22px rgba(251,198,12,0); }
}

/* --- Keyboard shortcut flash --- */
.vp-flash {
    position: absolute; top: 50%; left: 50%;
    transform: translate(-50%,-50%);
    background: rgba(0,0,0,.7);
    color: #fff; font-size: 1rem; font-weight: 700;
    padding: 12px 24px; border-radius: 40px;
    pointer-events: none; z-index: 50;
    opacity: 0;
    transition: opacity .15s ease;
    white-space: nowrap;
}
.vp-flash.show { opacity: 1; }

/* ============================================================
   CONTROL BAR — The crown jewel
============================================================ */
.vp-controls {
    position: absolute; bottom: 0; left: 0; right: 0; z-index: 30;
    padding: 0 18px 16px;
    background: linear-gradient(
        to top,
        rgba(4,10,24,.98) 0%,
        rgba(4,10,24,.82) 40%,
        rgba(4,10,24,.3)  75%,
        transparent       100%
    );
    opacity: 0;
    transform: translateY(6px);
    transition: opacity .25s ease, transform .25s ease;
    pointer-events: none;
}
.video-player-container:hover .vp-controls,
.video-player-container.vp-paused .vp-controls,
.video-player-container.vp-show .vp-controls {
    opacity: 1; transform: translateY(0); pointer-events: all;
}

/* Progress track */
.vp-prog-wrap {
    position: relative;
    padding: 10px 0 8px;
    cursor: pointer;
    margin-bottom: 6px;
}
/* Hover zone is taller than visible track */
.vp-prog-bg {
    position: relative; height: 4px;
    background: rgba(255,255,255,.18);
    border-radius: 99px; overflow: visible;
    transition: height .15s ease, transform .15s ease;
}
.vp-prog-wrap:hover .vp-prog-bg {
    height: 6px;
    transform: scaleY(1);
}
/* Buffer bar */
.vp-prog-buffer {
    position: absolute; top: 0; left: 0; height: 100%;
    background: rgba(255,255,255,.28);
    border-radius: 99px;
    width: 0%; transition: width .4s ease;
}
/* Played bar */
.vp-prog-played {
    position: absolute; top: 0; left: 0; height: 100%;
    background: linear-gradient(90deg, var(--bright-amber), #ffd94d);
    border-radius: 99px;
    width: 0%;
    transition: width .1s linear;
    box-shadow: 0 0 8px rgba(251,198,12,.5);
}
/* Scrub thumb */
.vp-prog-thumb {
    position: absolute; top: 50%;
    width: 14px; height: 14px;
    background: var(--bright-amber);
    border-radius: 50%;
    transform: translate(-50%,-50%) scale(0);
    border: 2px solid #fff;
    box-shadow: 0 2px 8px rgba(251,198,12,.6);
    transition: transform .15s cubic-bezier(.34,1.56,.64,1);
    left: 0%;
    pointer-events: none;
}
.vp-prog-wrap:hover .vp-prog-thumb { transform: translate(-50%,-50%) scale(1); }

/* Hover time tooltip */
.vp-prog-tip {
    position: absolute;
    bottom: calc(100% + 16px);
    transform: translateX(-50%);
    background: rgba(4,10,24,.95);
    border: 1px solid rgba(251,198,12,.25);
    color: #fff;
    font-size: .7rem; font-weight: 700;
    padding: 4px 9px; border-radius: 6px;
    pointer-events: none; white-space: nowrap;
    opacity: 0; transition: opacity .12s ease;
    font-variant-numeric: tabular-nums;
    letter-spacing: .03em;
}
.vp-prog-tip::after {
    content: '';
    position: absolute; top: 100%; left: 50%;
    transform: translateX(-50%);
    border: 4px solid transparent;
    border-top-color: rgba(4,10,24,.95);
}
.vp-prog-wrap:hover .vp-prog-tip { opacity: 1; }
/* Hidden range input over the track for accessibility + drag */
.vp-seek-input {
    position: absolute; inset: 0;
    width: 100%; height: 100%;
    opacity: 0; cursor: pointer;
    margin: 0; padding: 0;
    -webkit-appearance: none; appearance: none;
}

/* Controls row */
.vp-row {
    display: flex; align-items: center; gap: 2px;
}
.vp-spacer { flex: 1; }

/* --- Buttons --- */
.vp-btn {
    background: none; border: none; cursor: pointer;
    color: rgba(255,255,255,.82);
    width: 38px; height: 38px; border-radius: 50%;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: .9rem; flex-shrink: 0; position: relative;
    transition: background .15s, color .15s, transform .12s;
}
.vp-btn:hover {
    background: rgba(255,255,255,.12);
    color: #fff; transform: scale(1.08);
}
/* Play/pause — featured */
.vp-btn.vp-play {
    width: 44px; height: 44px;
    background: rgba(251,198,12,.15);
    border: 1.5px solid rgba(251,198,12,.4);
    color: var(--bright-amber); font-size: 1rem;
    margin-right: 2px;
}
.vp-btn.vp-play:hover {
    background: var(--bright-amber);
    color: var(--prussian-blue);
    border-color: transparent;
    transform: scale(1.06);
}
/* Skip buttons */
.vp-skip-label {
    font-size: .58rem; font-weight: 800;
    line-height: 1; display: block;
    font-variant-numeric: tabular-nums;
}

/* Volume cluster */
.vp-vol-cluster { display: flex; align-items: center; gap: 4px; }
.vp-vol-wrap {
    overflow: hidden;
    width: 0; opacity: 0;
    transition: width .22s ease, opacity .22s ease;
    display: flex; align-items: center;
}
.vp-vol-cluster:hover .vp-vol-wrap,
.vp-vol-cluster:focus-within .vp-vol-wrap { width: 72px; opacity: 1; }
.vp-vol-slider {
    -webkit-appearance: none; appearance: none;
    width: 66px; height: 4px; border-radius: 99px; outline: none; cursor: pointer;
    background: linear-gradient(
        to right,
        rgba(255,255,255,.88) 0%,
        rgba(255,255,255,.88) var(--vp, 100%),
        rgba(255,255,255,.2)  var(--vp, 100%),
        rgba(255,255,255,.2)  100%
    );
}
.vp-vol-slider::-webkit-slider-thumb {
    -webkit-appearance: none; width: 13px; height: 13px;
    border-radius: 50%; background: #fff; cursor: pointer;
}
.vp-vol-slider::-moz-range-thumb {
    width: 13px; height: 13px; border-radius: 50%;
    background: #fff; cursor: pointer; border: none;
}

/* Time display */
.vp-time {
    font-size: .75rem; color: rgba(255,255,255,.8);
    white-space: nowrap; font-variant-numeric: tabular-nums;
    font-weight: 500; letter-spacing: .025em; padding: 0 6px;
}
.vp-time-sep { opacity: .4; margin: 0 1px; }

/* Speed button */
.vp-speed-btn {
    background: rgba(255,255,255,.1);
    border: 1px solid rgba(255,255,255,.2);
    color: rgba(255,255,255,.85);
    border-radius: 6px; padding: 5px 9px;
    font-size: .72rem; font-weight: 800;
    cursor: pointer; outline: none;
    transition: background .15s, color .15s;
    white-space: nowrap;
    font-variant-numeric: tabular-nums;
}
.vp-speed-btn:hover { background: rgba(255,255,255,.2); color: #fff; }

/* Tooltip via data-tip */
.vp-btn[data-tip]::after,
.vp-speed-btn[data-tip]::after {
    content: attr(data-tip);
    position: absolute; bottom: calc(100% + 8px); left: 50%;
    transform: translateX(-50%);
    background: rgba(4,10,24,.95);
    border: 1px solid rgba(255,255,255,.1);
    color: #fff; font-size: .65rem; font-weight: 600;
    padding: 4px 9px; border-radius: 6px;
    white-space: nowrap; pointer-events: none;
    opacity: 0; transition: opacity .14s ease;
    letter-spacing: .02em;
    z-index: 100;
}
.vp-btn:hover[data-tip]::after,
.vp-speed-btn:hover[data-tip]::after { opacity: 1; }

/* Embed-only bar — YouTube / Vimeo (no custom controls, just fullscreen) */
.vp-embed-bar {
    position: absolute; bottom: 0; left: 0; right: 0; z-index: 30;
    padding: 12px 16px;
    display: flex; justify-content: flex-end;
    background: linear-gradient(to top, rgba(4,10,24,.75) 0%, transparent 100%);
    opacity: 0; transition: opacity .25s ease; pointer-events: none;
}
.video-player-container:hover .vp-embed-bar { opacity: 1; pointer-events: all; }

/* ============================================================
   AUTOPLAY NEXT — full-overlay countdown (cinematic)
============================================================ */
.vp-autoplay-overlay {
    position: absolute; inset: 0; z-index: 50;
    background: rgba(4,10,24,.88);
    backdrop-filter: blur(6px);
    display: flex; flex-direction: column;
    align-items: center; justify-content: center; gap: 20px;
    opacity: 0; pointer-events: none;
    transition: opacity .35s ease;
}
.vp-autoplay-overlay.visible { opacity: 1; pointer-events: all; }
.vp-autoplay-label {
    font-size: .75rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .12em; color: rgba(255,255,255,.55);
}
.vp-autoplay-title {
    font-size: 1.15rem; font-weight: 700; color: #fff;
    max-width: 380px; text-align: center; line-height: 1.4;
    padding: 0 24px;
}
/* Circular countdown ring */
.vp-countdown-ring {
    position: relative; width: 76px; height: 76px;
}
.vp-countdown-ring svg {
    position: absolute; inset: 0;
    transform: rotate(-90deg);
}
.vp-countdown-track {
    fill: none; stroke: rgba(255,255,255,.12); stroke-width: 3;
}
.vp-countdown-arc {
    fill: none; stroke: var(--bright-amber); stroke-width: 3;
    stroke-linecap: round;
    stroke-dasharray: 213; stroke-dashoffset: 0;
    transition: stroke-dashoffset 1s linear;
    filter: drop-shadow(0 0 5px rgba(251,198,12,.6));
}
.vp-countdown-num {
    position: absolute; inset: 0;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.6rem; font-weight: 800; color: var(--bright-amber);
    font-variant-numeric: tabular-nums;
}
.vp-autoplay-actions { display: flex; gap: 12px; }
.vp-ap-play-now {
    background: var(--bright-amber); color: var(--prussian-blue);
    border: none; border-radius: var(--radius-full);
    padding: 11px 24px; font-size: .88rem; font-weight: 700;
    cursor: pointer; transition: transform .15s, box-shadow .15s;
    display: flex; align-items: center; gap: 8px;
}
.vp-ap-play-now:hover { transform: scale(1.04); box-shadow: 0 4px 18px rgba(251,198,12,.45); }
.vp-ap-cancel {
    background: rgba(255,255,255,.1);
    border: 1.5px solid rgba(255,255,255,.25);
    color: rgba(255,255,255,.8); border-radius: var(--radius-full);
    padding: 11px 22px; font-size: .88rem; font-weight: 600;
    cursor: pointer; transition: background .15s;
}
.vp-ap-cancel:hover { background: rgba(255,255,255,.18); color: #fff; }

/* ============================================================
   AUTOPLAY TOGGLE — pill switch
============================================================ */
.autoplay-toggle-container {
    display: flex; justify-content: flex-end; margin-bottom: 16px;
}
.autoplay-toggle-wrap {
    display: inline-flex; align-items: center; gap: 10px;
    background: var(--pure-white); border: 1.5px solid rgba(10,29,68,.1);
    border-radius: var(--radius-full); padding: 9px 18px;
    box-shadow: var(--shadow-sm); cursor: pointer; user-select: none;
    transition: var(--transition);
}
.autoplay-toggle-wrap:hover { box-shadow: var(--shadow-md); border-color: rgba(251,198,12,.4); }
.autoplay-toggle-wrap.is-on { border-color: rgba(251,198,12,.35); }
.autoplay-icon { font-size: .85rem; color: var(--text-muted); transition: color .25s; }
.autoplay-toggle-wrap.is-on .autoplay-icon { color: var(--bright-amber); }
.autoplay-label { font-size: .85rem; font-weight: 600; color: var(--text-primary); }
.autoplay-switch {
    position: relative; width: 42px; height: 23px;
    border-radius: 99px; background: var(--pale-slate);
    border: none; cursor: pointer; transition: background .25s;
    flex-shrink: 0; outline: none;
}
.autoplay-switch:focus-visible { outline: 2px solid var(--bright-amber); }
.autoplay-switch[aria-checked="true"] { background: var(--bright-amber); }
.autoplay-switch-thumb {
    position: absolute; top: 3px; left: 3px;
    width: 17px; height: 17px; border-radius: 50%;
    background: #fff; box-shadow: 0 1px 4px rgba(0,0,0,.25);
    transition: transform .25s cubic-bezier(.34,1.56,.64,1);
}
.autoplay-switch[aria-checked="true"] .autoplay-switch-thumb { transform: translateX(19px); }
.autoplay-status {
    font-size: .78rem; font-weight: 700; min-width: 22px;
    color: var(--pale-slate); transition: color .25s;
}
.autoplay-toggle-wrap.is-on .autoplay-status { color: var(--dark-slate); }

/* ============================================================
   LESSON NAV CONTROLS
============================================================ */
.lesson-nav-controls {
    display: flex; align-items: center; justify-content: space-between; gap: 12px;
    background: var(--pure-white); border-radius: var(--radius-lg);
    padding: 14px 20px; margin-bottom: 16px;
    box-shadow: var(--shadow-md); border: 1px solid rgba(251,198,12,.15);
}
.lesson-nav-btn {
    display: flex; align-items: center; gap: 10px; padding: 10px 18px;
    background: var(--ivory); color: var(--text-primary);
    border: 1.5px solid rgba(10,29,68,.1); border-radius: var(--radius-md);
    cursor: pointer; transition: var(--transition); font-size: .9rem; min-width: 160px; flex-shrink: 0;
}
.lesson-nav-btn:hover:not(:disabled) {
    background: var(--gradient-1); color: var(--pure-white);
    border-color: transparent; transform: translateY(-2px); box-shadow: var(--shadow-md);
}
.lesson-nav-btn:disabled { opacity: .35; cursor: not-allowed; pointer-events: none; }
.lesson-nav-btn--next { justify-content: flex-end; text-align: right; }
.lesson-nav-btn i { font-size: 1rem; flex-shrink: 0; color: var(--bright-amber); transition: var(--transition); }
.lesson-nav-btn:hover:not(:disabled) i { color: var(--pure-white); }
.lesson-nav-label { display: flex; flex-direction: column; gap: 2px; overflow: hidden; }
.lesson-nav-label small { font-size: .7rem; text-transform: uppercase; letter-spacing: .08em; opacity: .6; font-weight: 600; }
.lesson-nav-label strong { font-size: .82rem; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 110px; display: block; }
.lesson-nav-center { flex: 1; text-align: center; min-width: 0; }
.current-lesson-indicator {
    font-size: .8rem; color: var(--text-muted); font-weight: 500; margin-bottom: 4px;
    display: flex; align-items: center; justify-content: center; gap: 8px;
}
.lesson-elapsed-timer {
    font-size: .75rem; background: rgba(251,198,12,.15); color: var(--text-secondary);
    padding: 1px 8px; border-radius: var(--radius-full); font-variant-numeric: tabular-nums;
    font-weight: 600; border: 1px solid rgba(251,198,12,.25);
}
.lesson-nav-title { font-size: .92rem; font-weight: 600; color: var(--text-primary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

/* ============================================================
   LESSON CONTENT
============================================================ */
.lesson-content-container {
    background: var(--pure-white); border-radius: var(--radius-lg);
    padding: 30px; box-shadow: var(--shadow-md); border: 1px solid rgba(251,198,12,.1);
}
.lesson-content-placeholder { text-align: center; padding: 40px 20px; }
.lesson-content-placeholder i { font-size: 4rem; color: var(--bright-amber); margin-bottom: 20px; opacity: .5; }
.lesson-content-placeholder h3 { font-size: 1.3rem; color: var(--text-primary); margin-bottom: 10px; }
.lesson-content-placeholder p { color: var(--text-muted); max-width: 400px; margin: 0 auto; }
.lesson-content { padding: 20px; }
.lesson-content h2 { color: var(--text-primary); margin-bottom: 20px; font-size: 1.5rem; }
.lesson-content-body { color: var(--text-secondary); line-height: 1.8; }
.lesson-content-body img { max-width: 100%; border-radius: var(--radius-md); margin: 20px 0; }
.lesson-content-body pre { background: var(--ivory); padding: 15px; border-radius: var(--radius-md); overflow-x: auto; }
.lesson-content-body code { background: var(--ivory); padding: 2px 5px; border-radius: 4px; font-family: monospace; }
.lesson-attachment { margin-top: 30px; padding-top: 20px; border-top: 1px solid rgba(251,198,12,.2); }
.lesson-attachment .btn {
    display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px;
    background: var(--gradient-1); color: var(--pure-white);
    border-radius: var(--radius-full); text-decoration: none;
    transition: var(--transition); border: none; cursor: pointer;
}
.lesson-attachment .btn:hover { transform: translateY(-2px); box-shadow: var(--shadow-hover); }
.completion-toggle {
    margin-top: 30px; padding: 20px; background: var(--ivory);
    border-radius: var(--radius-md); display: flex; align-items: center; gap: 12px;
}
.completion-toggle input[type="checkbox"] { width: 20px; height: 20px; cursor: pointer; accent-color: var(--bright-amber); }
.completion-toggle label { cursor: pointer; color: var(--text-primary); font-weight: 500; font-size: 1rem; }

/* ============================================================
   SIDEBAR
============================================================ */
.learning-sidebar { position: sticky; top: 120px; align-self: start; }
.curriculum-container { background: var(--pure-white); border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-md); border: 1px solid rgba(251,198,12,.1); }
.curriculum-header { padding: 20px; background: var(--gradient-1); display: flex; align-items: center; justify-content: space-between; }
.curriculum-header h3 { margin: 0; font-size: 1.2rem; font-weight: 600; color: var(--pure-white); }
.lessons-count { font-size: .9rem; padding: 4px 12px; background: rgba(255,255,255,.2); border-radius: var(--radius-full); color: var(--pure-white); }
.curriculum-section { border-bottom: 1px solid rgba(251,198,12,.1); }
.curriculum-section:last-child { border-bottom: none; }
.section-header { padding: 15px 20px; background: var(--ivory); cursor: pointer; display: flex; align-items: center; justify-content: space-between; transition: var(--transition); }
.section-header:hover { background: rgba(251,198,12,.05); }
.section-title { display: flex; align-items: center; gap: 10px; }
.section-title i { color: var(--bright-amber); font-size: .8rem; transition: var(--transition); }
.section-header.active .section-title i { transform: rotate(90deg); }
.section-title h4 { margin: 0; font-size: 1rem; font-weight: 600; color: var(--text-primary); }
.section-meta { font-size: .85rem; color: var(--text-muted); background: var(--pure-white); padding: 4px 10px; border-radius: var(--radius-full); }
.section-lessons { display: none; padding: 10px; background: var(--pure-white); }
.section-lessons.show { display: block; animation: slideDown .3s ease; }
@keyframes slideDown { from{opacity:0;transform:translateY(-10px)} to{opacity:1;transform:translateY(0)} }

.lesson-item { display: flex; align-items: center; gap: 12px; padding: 12px 15px; cursor: pointer; border-radius: var(--radius-md); transition: var(--transition); margin-bottom: 5px; border: 1px solid transparent; }
.lesson-item:hover { background: var(--ivory); border-color: rgba(251,198,12,.2); }
.lesson-item.current { background: rgba(251,198,12,.1); border-color: var(--bright-amber); }
.lesson-item.completed { opacity: .8; }
.lesson-status { width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; }
.lesson-status i { font-size: 1rem; }
.lesson-status .fa-check-circle { color: var(--sky-blue); }
.lesson-status .fa-play-circle  { color: var(--bright-amber); }
.lesson-status .fa-circle { color: var(--pale-slate); font-size: .6rem; }
.lesson-info { flex: 1; display: flex; flex-direction: column; gap: 4px; }
.lesson-title  { font-size: .95rem; font-weight: 500; color: var(--text-primary); line-height: 1.4; }
.lesson-duration { font-size: .8rem; color: var(--text-muted); }
.preview-badge { background: var(--bright-amber); color: var(--prussian-blue); padding: 2px 8px; border-radius: var(--radius-full); font-size: .7rem; font-weight: 600; }

.course-stats { padding: 20px; background: var(--gradient-1); border-top: 1px solid rgba(251,198,12,.2); }
.stat-item { display: flex; align-items: center; gap: 15px; margin-bottom: 15px; padding: 10px; background: rgba(255,255,255,.1); border-radius: var(--radius-md); backdrop-filter: blur(5px); }
.stat-item:last-child { margin-bottom: 0; }
.stat-item i { font-size: 1.5rem; color: var(--bright-amber); }
.stat-item div { flex: 1; }
.stat-value { display: block; font-size: 1.2rem; font-weight: 700; color: var(--pure-white); margin-bottom: 2px; }
.stat-label { font-size: .85rem; color: var(--ivory); opacity: .9; }

/* ============================================================
   NOTIFICATIONS
============================================================ */
.learning-notification {
    position: fixed; bottom: 20px; right: 20px; padding: 15px 25px;
    border-radius: var(--radius-full); box-shadow: var(--shadow-lg); z-index: 10000;
    animation: slideIn .3s ease; font-weight: 500;
    display: flex; align-items: center; gap: 10px;
    max-width: 400px; border-left: 4px solid var(--bright-amber);
}
.learning-notification.success { background: var(--gradient-1); color: var(--pure-white); }
.learning-notification.error   { background: var(--gradient-2); color: var(--prussian-blue); }
.learning-notification.info    { background: var(--gradient-3); color: var(--prussian-blue); }
@keyframes slideIn  { from{transform:translateX(100%);opacity:0} to{transform:translateX(0);opacity:1} }
@keyframes slideOut { from{transform:translateX(0);opacity:1}   to{transform:translateX(100%);opacity:0} }

/* ============================================================
   MODAL
============================================================ */
.modal-content { border-radius: var(--radius-lg); border: none; box-shadow: var(--shadow-lg); }
.modal-header { background: var(--gradient-1); color: var(--pure-white); border-radius: var(--radius-lg) var(--radius-lg) 0 0; padding: 20px; }
.modal-header .btn-close { filter: brightness(0) invert(1); }
.modal-header .modal-title { color: var(--pure-white); }
.modal-body { padding: 25px; }
.modal-footer { padding: 20px; border-top: 1px solid rgba(251,198,12,.2); }
.modal-footer .btn { padding: 10px 25px; border-radius: var(--radius-full); font-weight: 500; transition: var(--transition); border: none; cursor: pointer; }
.modal-footer .btn-primary { background: var(--bright-amber); color: var(--prussian-blue); }
.modal-footer .btn-primary:hover { transform: translateY(-2px); box-shadow: var(--shadow-hover); }
.modal-footer .btn-success { background: var(--sky-blue); color: var(--pure-white); }
.modal-footer .btn-success:hover { transform: translateY(-2px); box-shadow: var(--shadow-hover); }
.modal-footer .btn-secondary { background: var(--pale-slate); color: var(--text-primary); }
.modal-footer .btn-secondary:hover { background: var(--khaki-beige); }
.next-lesson-suggestion { background: var(--ivory); padding: 15px; border-radius: var(--radius-md); margin-top: 15px; }
.next-lesson-suggestion p { margin: 0; color: var(--text-primary); }
.next-lesson-suggestion strong { color: var(--bright-amber); }

/* ============================================================
   RESPONSIVE
============================================================ */
@media (max-width: 992px) {
    .learning-grid { grid-template-columns: 1fr; }
    .learning-sidebar { position: static; margin-top: 30px; }
    .curriculum-container { max-width: 600px; margin: 0 auto; }
}
@media (max-width: 768px) {
    .learning-header-content { flex-direction: column; align-items: flex-start; }
    .learning-back-btn { width: 100%; justify-content: center; }
    .learning-progress { flex-direction: column; align-items: flex-start; width: 100%; }
    .progress-bar-container { width: 100%; }
    .lesson-content-container { padding: 20px; }
    .lesson-nav-controls { padding: 10px 12px; gap: 8px; }
    .lesson-nav-btn { min-width: 0; padding: 8px 12px; }
    .lesson-nav-label strong { max-width: 70px; }
    .vp-vol-cluster { display: none; }
    .vp-speed-btn { display: none; }
}
@media (max-width: 576px) {
    .learning-header { padding: 15px 0; }
    .learning-title { font-size: 1.2rem; }
    .lesson-nav-label small { display: none; }
    .lesson-nav-center { display: none; }
    .lesson-nav-btn { flex: 1; }
    .lesson-nav-btn--next { justify-content: flex-end; }
    .learning-notification { left: 20px; right: 20px; max-width: none; }
    .autoplay-toggle-wrap { padding: 8px 14px; }
}
@media (max-width: 380px) {
    .learning-title { font-size: 1.1rem; }
    .section-title { flex-wrap: wrap; }
    .lesson-item { flex-wrap: wrap; }
    .lesson-info { width: 100%; }
}
</style>

{{-- YouTube IFrame API --}}
<script src="https://www.youtube.com/iframe_api"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ====================================================
       COURSE STATE
    ==================================================== */
    const courseData = {
        id: {{ $course->id }},
        completedLessons: @json($completedLessons),
        totalLessons: {{ $course->lessons->count() }}
    };
    if (!Array.isArray(courseData.completedLessons)) courseData.completedLessons = [];

    let currentLessonId  = {{ request()->get('lesson') ?? ($currentLesson->id ?? 'null') }};
    const videoPlayer    = document.getElementById('videoPlayer');
    const videoContainer = document.getElementById('videoContainer');
    const lessonContent  = document.getElementById('lessonContent');

    /* ====================================================
       AUTOPLAY TOGGLE
    ==================================================== */
    const AUTOPLAY_KEY   = 'lms_autoplay_v1';
    let   autoplayOn     = localStorage.getItem(AUTOPLAY_KEY) !== 'false';

    const autoplayWrap   = document.getElementById('autoplayToggleWrap');
    const autoplaySwitch = document.getElementById('autoplaySwitch');
    const autoplayStatus = document.getElementById('autoplayStatus');

    function syncAutoplayUI() {
        autoplaySwitch.setAttribute('aria-checked', autoplayOn ? 'true' : 'false');
        autoplayStatus.textContent = autoplayOn ? 'On' : 'Off';
        autoplayWrap.classList.toggle('is-on', autoplayOn);
    }
    function setAutoplay(value) {
        autoplayOn = !!value;
        localStorage.setItem(AUTOPLAY_KEY, autoplayOn ? 'true' : 'false');
        syncAutoplayUI();
        if (!autoplayOn) cancelAutoAdvance();
    }
    autoplayWrap.addEventListener('click', function (e) {
        e.stopPropagation();
        setAutoplay(!autoplayOn);
        notify(autoplayOn ? '▶️ Autoplay on' : '⏸ Autoplay off', 'info');
    });
    autoplaySwitch.addEventListener('click', e => e.stopPropagation());
    syncAutoplayUI();

    /* ====================================================
       MODAL
    ==================================================== */
    const modalEl = document.getElementById('lessonCompleteModal');
    const modal = {
        show() {
            modalEl.classList.add('show'); modalEl.style.display = 'block';
            modalEl.removeAttribute('aria-hidden'); document.body.classList.add('modal-open');
            if (!document.querySelector('.modal-backdrop')) {
                const bd = document.createElement('div'); bd.className = 'modal-backdrop fade show';
                document.body.appendChild(bd);
            }
        },
        hide() {
            modalEl.classList.remove('show'); modalEl.style.display = 'none';
            modalEl.setAttribute('aria-hidden', 'true'); document.body.classList.remove('modal-open');
            document.querySelector('.modal-backdrop')?.remove();
        }
    };
    document.querySelectorAll('[data-bs-dismiss="modal"]').forEach(b => b.addEventListener('click', () => modal.hide()));

    /* ====================================================
       HELPERS
    ==================================================== */
    function ytId(url) {
        try {
            const parsed = new URL(url, window.location.origin);
            const host = parsed.hostname.replace('www.', '');

            if (host === 'youtu.be') {
                const id = parsed.pathname.replace('/', '').trim();
                return id || null;
            }

            if (host.endsWith('youtube.com')) {
                const idFromQuery = parsed.searchParams.get('v');
                if (idFromQuery) return idFromQuery;

                const pathParts = parsed.pathname.split('/').filter(Boolean);
                const markerIndex = pathParts.findIndex(part => ['embed', 'shorts', 'live', 'v'].includes(part));
                if (markerIndex !== -1 && pathParts[markerIndex + 1]) {
                    return pathParts[markerIndex + 1];
                }
            }
        } catch (_) {}

        const m = url.match(/^.*(youtu\.be\/|v\/|u\/\w\/|embed\/|shorts\/|live\/|watch\?v=|&v=)([^#&?]{11})/);
        return m ? m[2] : null;
    }

    function resolveVideoUrl(url, type = 'youtube') {
        if (!url) return '';
        if (type !== 'local') return url;
        if (/^(https?:)?\/\//i.test(url) || url.startsWith('/')) return url;

        const clean = url.replace(/^storage\//, '');
        return `/storage/${clean}`;
    }
    function vimId(url) { const m = url.match(/vimeo\.com\/(?:video\/)?(\d+)/); return m ? m[1] : null; }
    function esc(t)  { const d = document.createElement('div'); d.textContent = t; return d.innerHTML; }
    function fmt(s)  { if (!isFinite(s)||isNaN(s)) return '0:00'; return `${Math.floor(s/60)}:${String(Math.floor(s%60)).padStart(2,'0')}`; }
    function notify(msg, type = 'success') {
        document.querySelectorAll('.learning-notification').forEach(n => n.remove());
        const n = document.createElement('div'); n.className = `learning-notification ${type}`;
        const ic = { success:'fa-check-circle', error:'fa-exclamation-circle', info:'fa-info-circle' };
        n.innerHTML = `<i class="fas ${ic[type]||ic.info}"></i><span>${msg}</span>`;
        document.body.appendChild(n);
        setTimeout(() => { n.style.animation = 'slideOut .3s ease'; setTimeout(() => n.remove(), 300); }, 3200);
    }
    function flashMsg(msg) {
        const f = videoPlayer.querySelector('.vp-flash'); if (!f) return;
        f.textContent = msg; f.classList.add('show');
        clearTimeout(f._t); f._t = setTimeout(() => f.classList.remove('show'), 750);
    }

    /* ====================================================
       LESSON LIST HELPERS
    ==================================================== */
    const allLessons  = () => Array.from(document.querySelectorAll('.lesson-item'));
    const lessonIdx   = id => allLessons().findIndex(el => el.dataset.lessonId == id);
    const nextLesson  = id => { const a=allLessons(),i=lessonIdx(id); return i>=0&&i<a.length-1?a[i+1]:null; };

    /* ====================================================
       VIDEO ENDED
    ==================================================== */
    function onVideoEnded() {
        if (!courseData.completedLessons.includes(parseInt(currentLessonId)))
            markLessonAsCompleted(currentLessonId);

        const next = nextLesson(currentLessonId);
        if (next && autoplayOn) {
            showAutoplayOverlay(next);
        } else {
            showCompletionModal(currentLessonId);
        }
    }

    /* ====================================================
       AUTOPLAY OVERLAY (in-player countdown)
    ==================================================== */
    let _advTimer = null;

    function showAutoplayOverlay(nextEl) {
        // Remove any existing overlay
        videoPlayer.querySelector('.vp-autoplay-overlay')?.remove();

        const circumference = 213; // 2π × 34
        let secs = 7;

        const overlay = document.createElement('div');
        overlay.className = 'vp-autoplay-overlay';
        overlay.innerHTML = `
            <div class="vp-autoplay-label">Up Next</div>
            <div class="vp-autoplay-title">${esc(nextEl.dataset.lessonTitle || 'Next Lesson')}</div>
            <div class="vp-countdown-ring">
                <svg viewBox="0 0 76 76" xmlns="http://www.w3.org/2000/svg">
                    <circle class="vp-countdown-track" cx="38" cy="38" r="34"/>
                    <circle class="vp-countdown-arc"  cx="38" cy="38" r="34"
                            stroke-dasharray="${circumference}"
                            stroke-dashoffset="0"/>
                </svg>
                <div class="vp-countdown-num" id="vpCountNum">${secs}</div>
            </div>
            <div class="vp-autoplay-actions">
                <button class="vp-ap-play-now" id="vpPlayNow">
                    <i class="fas fa-play"></i> Play Now
                </button>
                <button class="vp-ap-cancel" id="vpCancelAp">Cancel</button>
            </div>
        `;
        videoPlayer.appendChild(overlay);
        // Trigger fade-in after paint
        requestAnimationFrame(() => requestAnimationFrame(() => overlay.classList.add('visible')));

        const arc    = overlay.querySelector('.vp-countdown-arc');
        const numEl  = overlay.querySelector('#vpCountNum');
        const total  = secs;

        overlay.querySelector('#vpPlayNow').onclick = () => {
            cancelAutoAdvance();
            modal.hide();
            window.loadLesson(nextEl.dataset.lessonId);
        };
        overlay.querySelector('#vpCancelAp').onclick = () => {
            cancelAutoAdvance();
            showCompletionModal(currentLessonId);
        };

        // Tick immediately then interval
        const tick = () => {
            secs--;
            if (numEl) numEl.textContent = secs;
            const offset = circumference - (circumference * ((total - secs) / total));
            if (arc) arc.style.strokeDashoffset = offset;
            if (secs <= 0) {
                cancelAutoAdvance();
                modal.hide();
                window.loadLesson(nextEl.dataset.lessonId);
            }
        };
        _advTimer = setInterval(tick, 1000);
    }

    window.cancelAutoAdvance = function () {
        if (_advTimer) { clearInterval(_advTimer); _advTimer = null; }
        videoPlayer.querySelector('.vp-autoplay-overlay')?.remove();
    };

    /* ====================================================
       YT MANAGEMENT
    ==================================================== */
    let _ytPlayer = null, _ytInterval = null;
    function destroyYT() {
        if (_ytInterval) { clearInterval(_ytInterval); _ytInterval = null; }
        if (_ytPlayer)   { try { _ytPlayer.destroy(); } catch(_) {} _ytPlayer = null; }
    }

    /* ====================================================
       PROGRESS SCRUBBER (custom — no range input)
    ==================================================== */
    function buildProgressBar(vid) {
        // Returns { wrap, updatePlayed, updateBuffer }
        const wrap = document.createElement('div'); wrap.className = 'vp-prog-wrap';
        wrap.innerHTML = `
            <div class="vp-prog-bg">
                <div class="vp-prog-buffer"></div>
                <div class="vp-prog-played"></div>
                <div class="vp-prog-thumb"></div>
            </div>
            <div class="vp-prog-tip"></div>
            <input type="range" class="vp-seek-input" min="0" max="1000" value="0" step="1">
        `;
        const played = wrap.querySelector('.vp-prog-played');
        const buffer = wrap.querySelector('.vp-prog-buffer');
        const thumb  = wrap.querySelector('.vp-prog-thumb');
        const tip    = wrap.querySelector('.vp-prog-tip');
        const input  = wrap.querySelector('.vp-seek-input');

        function updatePlayed() {
            if (!vid.duration) return;
            const pct = (vid.currentTime / vid.duration) * 100;
            played.style.width = pct + '%';
            thumb.style.left   = pct + '%';
            input.value = (pct / 100) * 1000;
        }
        function updateBuffer() {
            if (!vid.duration || !vid.buffered.length) return;
            const pct = (vid.buffered.end(vid.buffered.length-1) / vid.duration) * 100;
            buffer.style.width = pct + '%';
        }

        wrap.addEventListener('mousemove', e => {
            const r = wrap.getBoundingClientRect();
            const f = Math.max(0, Math.min(1, (e.clientX - r.left) / r.width));
            tip.textContent = fmt(f * (vid.duration || 0));
            tip.style.left  = (f * 100) + '%';
        });

        input.oninput = function () {
            if (vid.duration) vid.currentTime = (this.value / 1000) * vid.duration;
        };
        vid.addEventListener('timeupdate',    updatePlayed);
        vid.addEventListener('durationchange', updatePlayed);
        vid.addEventListener('progress',      updateBuffer);

        return wrap;
    }

    /* ====================================================
       BUILD LOCAL VIDEO CONTROLS
    ==================================================== */
    const SPEEDS = [0.5, 0.75, 1, 1.25, 1.5, 2];
    let _speedIdx = 2; // default 1×

    function buildControls(vid) {
        const bar = document.createElement('div'); bar.className = 'vp-controls';

        // Progress
        const progBar = buildProgressBar(vid);
        bar.appendChild(progBar);

        // Row
        const row = document.createElement('div'); row.className = 'vp-row';
        row.innerHTML = `
            <button class="vp-btn vp-play" data-tip="Play (Space)"><i class="fas fa-play"></i></button>
            <button class="vp-btn vp-skip-back" data-tip="−10s (Shift+←)">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12.5 3a9 9 0 1 0 9 9h-2a7 7 0 1 1-7-7V7l-4-4 4-4v2.05A9 9 0 0 1 12.5 3Z"/>
                    <text x="7" y="15" font-size="7" font-weight="800" fill="currentColor" font-family="sans-serif">10</text>
                </svg>
            </button>
            <button class="vp-btn vp-skip-fwd" data-tip="+10s (Shift+→)">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M11.5 3a9 9 0 1 1-9 9h2a7 7 0 1 0 7-7V7l4-4-4-4v2.05A9 9 0 0 0 11.5 3Z"/>
                    <text x="7" y="15" font-size="7" font-weight="800" fill="currentColor" font-family="sans-serif">10</text>
                </svg>
            </button>
            <div class="vp-vol-cluster">
                <button class="vp-btn vp-mute" data-tip="Mute (M)"><i class="fas fa-volume-up"></i></button>
                <div class="vp-vol-wrap">
                    <input type="range" class="vp-vol-slider" min="0" max="100" value="100" step="1">
                </div>
            </div>
            <span class="vp-time">
                <span class="vp-cur">0:00</span>
                <span class="vp-time-sep"> / </span>
                <span class="vp-dur">0:00</span>
            </span>
            <div class="vp-spacer"></div>
            <button class="vp-speed-btn" data-tip="Speed">1×</button>
            <button class="vp-btn vp-fs" data-tip="Fullscreen (F)"><i class="fas fa-expand"></i></button>
        `;
        bar.appendChild(row);

        const playBtn  = row.querySelector('.vp-play');
        const skipBack = row.querySelector('.vp-skip-back');
        const skipFwd  = row.querySelector('.vp-skip-fwd');
        const muteBtn  = row.querySelector('.vp-mute');
        const volEl    = row.querySelector('.vp-vol-slider');
        const curEl    = row.querySelector('.vp-cur');
        const durEl    = row.querySelector('.vp-dur');
        const speedBtn = row.querySelector('.vp-speed-btn');
        const fsBtn    = row.querySelector('.vp-fs');

        /* sync functions */
        const sPlay = () => { playBtn.innerHTML = vid.paused ? '<i class="fas fa-play"></i>' : '<i class="fas fa-pause"></i>'; };
        const sMute = () => { muteBtn.innerHTML = (vid.muted||vid.volume===0) ? '<i class="fas fa-volume-mute"></i>' : '<i class="fas fa-volume-up"></i>'; };
        const sVol  = () => { const p=Math.round(vid.volume*100); volEl.value=p; volEl.style.setProperty('--vp',p+'%'); };
        const sTime = () => { curEl.textContent=fmt(vid.currentTime); durEl.textContent=fmt(vid.duration||0); };
        const sFs   = () => { fsBtn.innerHTML = document.fullscreenElement ? '<i class="fas fa-compress"></i>' : '<i class="fas fa-expand"></i>'; };

        /* wiring */
        playBtn.onclick  = () => { vid.paused ? vid.play() : vid.pause(); };
        muteBtn.onclick  = () => { vid.muted=!vid.muted; sMute(); sVol(); };
        volEl.oninput    = function () { vid.volume=this.value/100; vid.muted=+this.value===0; sMute(); volEl.style.setProperty('--vp',this.value+'%'); };
        skipBack.onclick = () => { vid.currentTime=Math.max(0,vid.currentTime-10); flashMsg('−10s'); };
        skipFwd.onclick  = () => { vid.currentTime=Math.min(vid.duration||Infinity,vid.currentTime+10); flashMsg('+10s'); };
        fsBtn.onclick    = toggleFullscreen;

        speedBtn.onclick = () => {
            _speedIdx = (_speedIdx + 1) % SPEEDS.length;
            vid.playbackRate = SPEEDS[_speedIdx];
            speedBtn.textContent = SPEEDS[_speedIdx] + '×';
            flashMsg(SPEEDS[_speedIdx] + '×');
        };

        vid.addEventListener('play',          sPlay);
        vid.addEventListener('pause',         sPlay);
        vid.addEventListener('volumechange',  () => { sMute(); sVol(); });
        vid.addEventListener('timeupdate',    sTime);
        vid.addEventListener('durationchange',sTime);
        document.addEventListener('fullscreenchange', sFs);

        sPlay(); sMute(); sVol(); sTime();
        return bar;
    }

    /* ====================================================
       FULLSCREEN
    ==================================================== */
    function toggleFullscreen() {
        if (!document.fullscreenElement) videoContainer.requestFullscreen().catch(console.error);
        else document.exitFullscreen();
    }
    document.addEventListener('fullscreenchange', () => {
        videoContainer.querySelectorAll('.vp-fs').forEach(b => {
            b.innerHTML = document.fullscreenElement ? '<i class="fas fa-compress"></i>' : '<i class="fas fa-expand"></i>';
        });
    });

    /* ====================================================
       LOAD VIDEO
    ==================================================== */
    function loadVideo(url, type = 'youtube', lessonTitle = '') {
        destroyYT();
        cancelAutoAdvance();
        videoContainer.classList.remove('vp-paused', 'vp-show');
        videoPlayer.innerHTML = '';
        url = resolveVideoUrl(url, type);

        const isYT  = type==='youtube' || url.includes('youtube.com') || url.includes('youtu.be');
        const isVim = type==='vimeo'   || url.includes('vimeo.com');

        /* ---- Title bar (shared) ---- */
        function makeTitleBar(title) {
            const tb = document.createElement('div'); tb.className = 'vp-title-bar';
            tb.innerHTML = `<div class="vp-title-bar-inner">
                <span class="vp-title-bar-badge">Now Playing</span>
                <span class="vp-title-bar-text">${esc(title)}</span>
            </div>`;
            return tb;
        }

        /* ---- Flash element (shared) ---- */
        function makeFlash() {
            const f = document.createElement('div'); f.className = 'vp-flash';
            return f;
        }

        /* ---- YOUTUBE ---- */
        if (isYT) {
            const vid = ytId(url);
            if (!vid) { showVideoPlaceholder('Invalid YouTube URL'); return; }

            const spinner = document.createElement('div'); spinner.className = 'vp-spinner';
            videoPlayer.appendChild(spinner);
            videoPlayer.appendChild(makeTitleBar(lessonTitle));
            videoPlayer.appendChild(makeFlash());

            const wrap = document.createElement('div'); wrap.className = 'vp-media-wrap'; wrap.id = 'yt-' + Date.now();
            videoPlayer.appendChild(wrap);

            const eb = document.createElement('div'); eb.className = 'vp-embed-bar';
            eb.innerHTML = `<button class="vp-btn vp-fs" data-tip="Fullscreen (F)"><i class="fas fa-expand"></i></button>`;
            eb.querySelector('.vp-fs').onclick = toggleFullscreen;
            videoPlayer.appendChild(eb);

            function initYT() {
                if (typeof YT==='undefined'||!YT.Player) { setTimeout(initYT, 200); return; }
                spinner.remove();
                _ytPlayer = new YT.Player(wrap.id, {
                    videoId: vid,
                    playerVars: { autoplay:1, rel:0, modestbranding:1, iv_load_policy:3, fs:1 },
                    events: {
                        onReady(e) {
                            e.target.playVideo();
                            _ytInterval = setInterval(() => {
                                try { const t=e.target.getCurrentTime(); if(t>0) updateVideoProgress(t); } catch(_){}
                            }, 5000);
                        },
                        onStateChange(e) { if (e.data === 0) onVideoEnded(); }
                    }
                });
                setTimeout(() => {
                    const iframe = wrap.querySelector('iframe');
                    if (iframe) Object.assign(iframe.style, { width:'100%', height:'100%', border:'none', position:'absolute', inset:'0' });
                }, 400);
            }
            initYT();

        /* ---- VIMEO ---- */
        } else if (isVim) {
            const vid = vimId(url);
            if (!vid) { showVideoPlaceholder('Invalid Vimeo URL'); return; }

            const mw  = document.createElement('div'); mw.className = 'vp-media-wrap';
            const ifr = document.createElement('iframe');
            ifr.src = `https://player.vimeo.com/video/${vid}?autoplay=1&byline=0&portrait=0&title=0`;
            ifr.allow = 'autoplay; fullscreen; picture-in-picture'; ifr.allowFullscreen = true;
            mw.appendChild(ifr); videoPlayer.appendChild(mw);

            videoPlayer.appendChild(makeTitleBar(lessonTitle));
            videoPlayer.appendChild(makeFlash());

            const eb = document.createElement('div'); eb.className = 'vp-embed-bar';
            eb.innerHTML = `<button class="vp-btn vp-fs" data-tip="Fullscreen"><i class="fas fa-expand"></i></button>`;
            eb.querySelector('.vp-fs').onclick = toggleFullscreen;
            videoPlayer.appendChild(eb);

            let vmHandler;
            window.addEventListener('message', vmHandler = function (e) {
                try {
                    const d = typeof e.data==='string' ? JSON.parse(e.data) : e.data;
                    if (d.event==='finish') { window.removeEventListener('message', vmHandler); onVideoEnded(); }
                    if (d.method==='getCurrentTime'&&d.value>0) updateVideoProgress(d.value);
                } catch (_) {}
            });
            ifr.onload = () => {
                ifr.contentWindow.postMessage(JSON.stringify({method:'addEventListener',value:'finish'}), '*');
                setInterval(() => ifr.contentWindow.postMessage(JSON.stringify({method:'getCurrentTime'}), '*'), 5000);
            };

        /* ---- LOCAL / SELF-HOSTED ---- */
        } else {
            const mw = document.createElement('div'); mw.className = 'vp-media-wrap';

            const vid = document.createElement('video');
            vid.src = url; vid.autoplay = true; vid.playsInline = true;
            vid.disablePictureInPicture = true; vid.disableRemotePlayback = true;
            vid.setAttribute('controlsList', 'nodownload noplaybackrate noremoteplayback nofullscreen');
            vid.style.cssText = 'width:100%;height:100%;object-fit:contain;background:#000;';

            /* Right-click shield — captures contextmenu, otherwise pointer-events:none */
            const shield = document.createElement('div'); shield.className = 'vp-shield';
            shield.addEventListener('contextmenu', e => {
                e.preventDefault();
                shield.style.pointerEvents = 'auto';
                setTimeout(() => { shield.style.pointerEvents = 'none'; }, 80);
            });

            mw.appendChild(vid); mw.appendChild(shield);
            videoPlayer.appendChild(mw);

            /* Title bar */
            videoPlayer.appendChild(makeTitleBar(lessonTitle));

            /* Big centre play */
            const bp = document.createElement('button'); bp.className = 'vp-centre-btn';
            bp.innerHTML = '<i class="fas fa-play"></i>';
            bp.onclick = () => vid.play();
            videoPlayer.appendChild(bp);

            /* Flash */
            videoPlayer.appendChild(makeFlash());

            /* Controls */
            videoPlayer.appendChild(buildControls(vid));

            /* Paused state class */
            vid.addEventListener('pause', () => { bp.classList.add('visible'); videoContainer.classList.add('vp-paused'); });
            vid.addEventListener('play',  () => { bp.classList.remove('visible'); videoContainer.classList.remove('vp-paused'); });

            /* Initially paused because autoplay may be blocked */
            vid.addEventListener('loadedmetadata', () => {
                if (vid.paused) { bp.classList.add('visible'); videoContainer.classList.add('vp-paused'); }
            });

            /* Auto-hide controls after 3s */
            let _hideTimer = null;
            function resetHideTimer() {
                videoContainer.classList.add('vp-show');
                clearTimeout(_hideTimer);
                if (!vid.paused) _hideTimer = setTimeout(() => videoContainer.classList.remove('vp-show'), 3000);
            }
            videoContainer.addEventListener('mousemove', resetHideTimer);
            videoContainer.addEventListener('click',     resetHideTimer);
            vid.addEventListener('play', () => { resetHideTimer(); });

            /* Progress tracking */
            let lastProg = 0;
            vid.addEventListener('timeupdate', () => {
                const now = Date.now(); if (now - lastProg > 5000) { lastProg = now; updateVideoProgress(vid.currentTime); }
            });
            vid.addEventListener('ended', onVideoEnded);

            /* Keyboard shortcuts */
            document.addEventListener('keydown', function vpKey(e) {
                const tag = document.activeElement.tagName.toLowerCase();
                if (tag==='input'||tag==='textarea'||tag==='select') return;
                if (e.code==='Space')                          { e.preventDefault(); vid.paused?vid.play():vid.pause(); }
                if (e.code==='KeyM')                           { vid.muted=!vid.muted; flashMsg(vid.muted?'🔇 Muted':'🔊 Unmuted'); }
                if (e.code==='KeyF')                           { toggleFullscreen(); }
                if (e.code==='ArrowRight' && e.shiftKey)       { e.preventDefault(); vid.currentTime=Math.min(vid.duration||0,vid.currentTime+10); flashMsg('+10s'); }
                if (e.code==='ArrowLeft'  && e.shiftKey)       { e.preventDefault(); vid.currentTime=Math.max(0,vid.currentTime-10); flashMsg('−10s'); }
                if (e.code==='ArrowUp'    && !e.shiftKey)      { e.preventDefault(); /* handled by lesson nav */ }
                if (e.code==='ArrowDown'  && !e.shiftKey)      { e.preventDefault(); /* handled by lesson nav */ }
            });
        }
    }

    /* ====================================================
       PROGRESS API
    ==================================================== */
    function updateVideoProgress(seconds) {
        if (!currentLessonId) return;
        fetch(`/lessons/${currentLessonId}/progress`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json', 'Content-Type': 'application/json' },
            body: JSON.stringify({ seconds: Math.round(seconds) })
        }).catch(() => {});
    }

    /* ====================================================
       MARK COMPLETE / INCOMPLETE
    ==================================================== */
    function markLessonAsCompleted(lessonId) {
        fetch(`/lessons/${lessonId}/complete`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json', 'Content-Type': 'application/json' },
            body: JSON.stringify({ completed: true })
        })
        .then(r => { if (!r.ok) throw new Error(r.status); return r.json(); })
        .then(data => {
            if (data.success) {
                updateLessonUI(lessonId, true);
                updateProgress(data.progress, data.completed_count, data.total_lessons);
                if (!courseData.completedLessons.includes(parseInt(lessonId))) courseData.completedLessons.push(parseInt(lessonId));
                if (data.certificate_url) window.lastCertificateUrl = data.certificate_url;
                notify('✅ Lesson completed!', 'success');
            } else {
                notify(data.message || 'Error saving progress', 'error');
                const cb = document.getElementById('markCompleteCheckbox'); if (cb) cb.checked = false;
            }
        })
        .catch(err => { notify('Error: ' + err.message, 'error'); const cb = document.getElementById('markCompleteCheckbox'); if (cb) cb.checked = false; });
    }

    function markLessonAsIncomplete(lessonId) {
        fetch(`/lessons/${lessonId}/complete`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json', 'Content-Type': 'application/json' },
            body: JSON.stringify({ completed: false })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                updateLessonUI(lessonId, false);
                updateProgress(data.progress, data.completed_count, data.total_lessons);
                const i = courseData.completedLessons.indexOf(parseInt(lessonId)); if (i > -1) courseData.completedLessons.splice(i, 1);
                notify('Lesson marked incomplete', 'info');
            }
        })
        .catch(() => { notify('Error updating progress', 'error'); const cb = document.getElementById('markCompleteCheckbox'); if (cb) cb.checked = true; });
    }

    window.toggleLessonComplete = function (lessonId) {
        const cb = document.getElementById('markCompleteCheckbox');
        (cb ? cb.checked : true) ? markLessonAsCompleted(lessonId) : markLessonAsIncomplete(lessonId);
    };

    /* ====================================================
       UI UPDATERS
    ==================================================== */
    function updateLessonUI(lessonId, done) {
        const el = document.querySelector(`[data-lesson-id="${lessonId}"]`); if (!el) return;
        const ic = el.querySelector('.lesson-status i');
        if (done) { el.classList.add('completed'); if (ic) ic.className='fas fa-check-circle'; }
        else      { el.classList.remove('completed'); if (ic) ic.className='fas fa-circle'; }
    }
    function updateProgress(progress, completed, total) {
        const fill = document.querySelector('.progress-fill');
        const text = document.querySelector('.progress-text');
        const stat = document.querySelector('.stat-value');
        if (fill) fill.style.width = progress + '%';
        if (text) text.textContent = `Your Progress: ${progress}%`;
        if (stat) stat.textContent = `${completed}/${total}`;
    }
    function showVideoPlaceholder(msg) {
        videoPlayer.innerHTML = `<div class="video-placeholder"><i class="fas fa-play-circle"></i><p>${msg}</p></div>`;
    }

    /* ====================================================
       COMPLETION MODAL
    ==================================================== */
    function showCompletionModal(lessonId) {
        const next = nextLesson(lessonId);
        const sug  = document.getElementById('nextLessonSuggestion');
        const cont = document.getElementById('continueToNextLesson');
        const done = document.getElementById('courseCompletedBtn');
        if (!sug||!cont||!done) return;

        if (next) {
            sug.innerHTML = `<p>Next up: <strong>${esc(next.dataset.lessonTitle||'Next Lesson')}</strong></p><p class="mt-2" style="opacity:.75;font-size:.9rem;">Duration: ${next.dataset.lessonDuration||'N/A'}</p>`;
            cont.style.display = 'inline-block'; done.style.display = 'none';
            cont.onclick = () => { modal.hide(); window.loadLesson(next.dataset.lessonId); };
        } else {
            const allDone = courseData.completedLessons.length >= courseData.totalLessons;
            if (allDone) {
                const cert = window.lastCertificateUrl;
                sug.innerHTML = `<p>🎉 You've completed the entire course!</p>${cert?'<p class="mt-2">Your certificate is ready.</p>':''}`;
                cont.style.display = 'none';
                done.innerHTML = cert ? '<i class="fas fa-certificate"></i> View Certificate' : 'Course Completed! 🎉';
                done.href = cert || "{{ route('courses.show', $course->slug) }}";
                done.style.display = 'inline-block';
            } else {
                sug.innerHTML = '<p>Great job! Keep going 💪</p>';
                cont.style.display = 'none'; done.style.display = 'none';
            }
        }
        modal.show();
    }

    /* ====================================================
       LOAD LESSON CONTENT
    ==================================================== */
    function loadLessonContent(title, content, attachment) {
        const isDone = courseData.completedLessons.includes(parseInt(currentLessonId));
        const att = attachment?.trim()
            ? `<div class="lesson-attachment"><a href="${attachment}" target="_blank" class="btn"><i class="fas fa-download"></i> Download Attachment</a></div>` : '';
        lessonContent.innerHTML = `
            <div class="lesson-content">
                <h2>${esc(title)}</h2>
                <div class="lesson-content-body">${content||'<p>No additional content for this lesson.</p>'}</div>
                ${att}
                <div class="completion-toggle">
                    <input type="checkbox" id="markCompleteCheckbox" ${isDone?'checked':''}
                           onchange="toggleLessonComplete(${currentLessonId})">
                    <label for="markCompleteCheckbox">Mark this lesson as completed</label>
                </div>
            </div>`;
    }

    /* ====================================================
       NAV CONTROLS
    ==================================================== */
    function updateNavControls(lessonId) {
        const bar = document.getElementById('lessonNavControls'); if (!bar) return;
        const all = allLessons(), idx = lessonIdx(lessonId), cur = all[idx];
        bar.style.display = 'flex';
        document.getElementById('lessonNavCurrent').textContent = idx + 1;
        document.getElementById('lessonNavTotal').textContent   = all.length;
        const nt = document.getElementById('currentLessonNavTitle');
        if (nt && cur) nt.textContent = cur.dataset.lessonTitle || 'Lesson';
        const pb = document.getElementById('prevLessonBtn'), nb = document.getElementById('nextLessonBtn');
        const pn = document.getElementById('prevLessonName'), nn = document.getElementById('nextLessonName');
        pb.disabled = idx <= 0; if (pn) pn.textContent = idx>0 ? (all[idx-1].dataset.lessonTitle||'Previous') : 'Previous Lesson';
        nb.disabled = idx >= all.length-1; if (nn) nn.textContent = idx<all.length-1 ? (all[idx+1].dataset.lessonTitle||'Next') : 'Next Lesson';
    }

    window.navigateLesson = function (dir) {
        const all = allLessons(), idx = lessonIdx(currentLessonId);
        const t = dir==='prev' ? idx-1 : idx+1;
        if (t >= 0 && t < all.length) window.loadLesson(all[t].dataset.lessonId);
    };

    /* ====================================================
       CORE: LOAD LESSON
    ==================================================== */
    window.loadLesson = function (lessonId) {
        cancelAutoAdvance();
        const el = document.querySelector(`[data-lesson-id="${lessonId}"]`); if (!el) return;

        document.querySelectorAll('.lesson-item').forEach(l => l.classList.remove('current'));
        el.classList.add('current');
        currentLessonId = parseInt(lessonId);
        el.scrollIntoView({ behavior: 'smooth', block: 'nearest' });

        const sec = el.closest('.section-lessons');
        if (sec && !sec.classList.contains('show')) { sec.classList.add('show'); sec.previousElementSibling?.classList.add('active'); }

        fetch('/save-current-lesson', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify({ course_id: courseData.id, lesson_id: lessonId })
        }).catch(() => {});

        const url   = el.dataset.videoUrl;
        const title = el.dataset.lessonTitle || 'Lesson';
        if (url?.trim()) loadVideo(url, el.dataset.videoType, title);
        else showVideoPlaceholder('No video available for this lesson');

        loadLessonContent(title, el.dataset.content || el.dataset.description || '', el.dataset.attachment);
        updateNavControls(lessonId);
        startTimer();

        const pu = new URL(window.location); pu.searchParams.set('lesson', lessonId); window.history.pushState({}, '', pu);
    };

    /* ====================================================
       ELAPSED TIMER
    ==================================================== */
    let timerStart = null, timerInt = null;
    function startTimer() {
        timerStart = Date.now();
        if (timerInt) clearInterval(timerInt);
        timerInt = setInterval(() => {
            const s  = Math.floor((Date.now() - timerStart) / 1000);
            const el = document.getElementById('lessonElapsedTime');
            if (el) el.textContent = String(Math.floor(s/60)).padStart(2,'0') + ':' + String(s%60).padStart(2,'0');
        }, 1000);
    }

    /* ====================================================
       CURRICULUM ACCORDION
    ==================================================== */
    document.querySelectorAll('.section-header').forEach((h, i) => {
        const sec = document.getElementById(`section-${i}`);
        const hasCur = sec?.querySelector(`[data-lesson-id="${currentLessonId}"]`);
        if (hasCur || (!currentLessonId && i===0)) { h.classList.add('active'); sec?.classList.add('show'); }
        h.addEventListener('click', function () {
            const c = document.getElementById(`section-${this.dataset.section}`); if (!c) return;
            this.classList.toggle('active'); c.classList.toggle('show');
        });
    });

    /* ====================================================
       LESSON CLICK
    ==================================================== */
    document.querySelectorAll('.lesson-item').forEach(item => {
        item.addEventListener('click', () => { if (item.dataset.lessonId) window.loadLesson(item.dataset.lessonId); });
    });

    /* ====================================================
       KEYBOARD LESSON NAV
    ==================================================== */
    document.addEventListener('keydown', e => {
        const tag = document.activeElement.tagName.toLowerCase();
        if (tag==='input'||tag==='textarea'||tag==='select') return;
        if ((e.key==='ArrowRight'||e.key==='ArrowDown') && !e.shiftKey) { e.preventDefault(); window.navigateLesson('next'); }
        if ((e.key==='ArrowLeft' ||e.key==='ArrowUp')   && !e.shiftKey) { e.preventDefault(); window.navigateLesson('prev'); }
    });

    /* ====================================================
       RESPONSIVE SIDEBAR
    ==================================================== */
    function handleResize() { const sb=document.querySelector('.learning-sidebar'); if(sb) sb.style.position=window.innerWidth<=992?'static':'sticky'; }
    window.addEventListener('resize', handleResize); handleResize();

    /* ====================================================
       BROWSER BACK / FORWARD
    ==================================================== */
    window.addEventListener('popstate', () => {
        const id = new URLSearchParams(window.location.search).get('lesson');
        if (id) window.loadLesson(id);
        else { const f=document.querySelector('.lesson-item'); f?.dataset.lessonId ? window.loadLesson(f.dataset.lessonId) : showVideoPlaceholder('Select a lesson to start learning'); }
    });

    /* ====================================================
       INITIAL LOAD
    ==================================================== */
    const startId = currentLessonId || document.querySelector('.lesson-item')?.dataset.lessonId;
    if (startId) window.loadLesson(startId);

    setTimeout(() => {
        const done = courseData.completedLessons.length, total = courseData.totalLessons;
        notify(
            done===0     ? '👋 Welcome! First lesson is ready.' :
            done===total ? '🎉 Course complete — reviewing lessons.' :
                           `▶️ Welcome back! ${done}/${total} lessons done.`,
            'info'
        );
    }, 900);

});
</script>
@endsection
