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
                    <div class="video-player-container">
                        <div class="video-player" id="videoPlayer">
                            <div class="video-placeholder">
                                <i class="fas fa-play-circle"></i>
                                <p>Select a lesson to start learning</p>
                            </div>
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
                                            $isCurrent = ($currentLesson ?? null) && $currentLesson->id == $lesson->id;
                                        @endphp
                                        <div class="lesson-item {{ $isCompleted ? 'completed' : '' }} {{ $isCurrent ? 'current' : '' }}" 
                                             data-lesson-id="{{ $lesson->id }}"
                                             data-lesson-title="{{ $lesson->title }}"
                                             data-lesson-duration="{{ $lesson->duration_formatted }}"
                                             data-video-url="{{ $lesson->video_url ?? '' }}"
                                             data-content="{{ $lesson->content ?? '' }}">
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
                                    <span class="stat-value">{{ $completedLessonsCount ?? 0 }}/{{ $totalLessonsCount ?? 0 }}</span>
                                    <span class="stat-label">Lessons Completed</span>
                                </div>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-clock"></i>
                                <div>
                                    <span class="stat-value">{{ $totalTimeSpent ?? '0h' }}</span>
                                    <span class="stat-label">Time Spent</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Root Variables - Your Beautiful Colors */
    :root {
        --bright-amber: #FBC60C;
        --khaki-beige: #9F9A87;
        --pure-white: #FEFDFE;
        --prussian-blue: #0A1D44;
        --regal-navy: #18386E;
        --sky-blue: #5AD1E4;
        --pale-slate: #CBD1DA;
        --dark-slate: #2E5C61;
        --ivory: #F9F7E9;
        --light-gold: #EBD789;
        
        /* Extended Palette */
        --primary: var(--regal-navy);
        --primary-dark: var(--prussian-blue);
        --primary-light: var(--dark-slate);
        --secondary: var(--sky-blue);
        --accent: var(--bright-amber);
        --accent-soft: var(--light-gold);
        --success: var(--sky-blue);
        --warning: var(--bright-amber);
        
        /* Text Colors */
        --text-primary: #0A1D44;
        --text-secondary: #2E5C61;
        --text-muted: #5f5f5f;
        --text-light: #FEFDFE;
        
        /* Gradients */
        --gradient-1: linear-gradient(135deg, #0A1D44 0%, #18386E 50%, #2E5C61 100%);
        --gradient-2: linear-gradient(45deg, #FBC60C 0%, #EBD789 50%, #F9F7E9 100%);
        --gradient-3: linear-gradient(135deg, #5AD1E4 0%, #CBD1DA 50%, #FEFDFE 100%);
        
        /* Shadows */
        --shadow-sm: 0 2px 8px rgba(10, 29, 68, 0.08);
        --shadow-md: 0 4px 12px rgba(10, 29, 68, 0.12);
        --shadow-lg: 0 8px 24px rgba(10, 29, 68, 0.15);
        --shadow-hover: 0 12px 28px rgba(251, 198, 12, 0.2);
        
        /* Border Radius */
        --radius-sm: 8px;
        --radius-md: 12px;
        --radius-lg: 16px;
        --radius-xl: 24px;
        --radius-full: 9999px;
        
        /* Transitions */
        --transition: all 0.3s ease;
    }

    /* Main Container */
    .learning-container {
        min-height: 100vh;
        background: linear-gradient(135deg, var(--ivory) 0%, var(--pure-white) 100%);
    }

    /* Header */
    .learning-header {
        background: var(--pure-white);
        padding: 20px 0;
        box-shadow: var(--shadow-md);
        position: sticky;
        top: 0;
        z-index: 100;
        border-bottom: 2px solid var(--gradient-2);
    }

    .learning-header-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 20px;
    }

    .learning-header-left {
        flex: 1;
        min-width: 280px;
    }

    .learning-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0 0 15px 0;
        color: var(--text-primary);
        line-height: 1.3;
    }

    /* Progress Bar */
    .learning-progress {
        display: flex;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    .progress-text {
        font-size: 0.95rem;
        font-weight: 500;
        color: var(--text-secondary);
        min-width: 120px;
    }

    .progress-bar-container {
        flex: 1;
        min-width: 200px;
    }

    .progress-bar {
        width: 100%;
        height: 8px;
        background: var(--pale-slate);
        border-radius: var(--radius-full);
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: var(--gradient-1);
        transition: width 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        border-radius: var(--radius-full);
        position: relative;
        overflow: hidden;
    }

    .progress-fill::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        animation: progress-shimmer 2s infinite;
    }

    @keyframes progress-shimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }

    /* Back Button */
    .learning-back-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        background: var(--ivory);
        color: var(--text-primary);
        text-decoration: none;
        border-radius: var(--radius-full);
        transition: var(--transition);
        border: 1px solid rgba(251, 198, 12, 0.2);
        font-weight: 500;
    }

    .learning-back-btn:hover {
        background: var(--gradient-2);
        color: var(--prussian-blue);
        transform: translateX(-5px);
        border-color: transparent;
    }

    .learning-back-btn i {
        font-size: 0.9rem;
        transition: var(--transition);
    }

    .learning-back-btn:hover i {
        transform: translateX(-3px);
    }

    /* Main Content */
    .learning-main {
        padding: 40px 0;
    }

    .learning-grid {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 30px;
    }

    /* Video Player Section */
    .learning-video-section {
        min-width: 0;
    }

    .video-player-container {
        background: var(--prussian-blue);
        border-radius: var(--radius-lg);
        overflow: hidden;
        margin-bottom: 20px;
        aspect-ratio: 16/9;
        box-shadow: var(--shadow-lg);
        border: 1px solid rgba(251, 198, 12, 0.2);
    }

    .video-player {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .video-placeholder {
        text-align: center;
        color: var(--pure-white);
        padding: 40px;
    }

    .video-placeholder i {
        font-size: 5rem;
        margin-bottom: 20px;
        color: var(--bright-amber);
        opacity: 0.5;
    }

    .video-placeholder p {
        font-size: 1.1rem;
        opacity: 0.8;
    }

    /* Lesson Content */
    .lesson-content-container {
        background: var(--pure-white);
        border-radius: var(--radius-lg);
        padding: 30px;
        box-shadow: var(--shadow-md);
        border: 1px solid rgba(251, 198, 12, 0.1);
    }

    .lesson-content-placeholder {
        text-align: center;
        padding: 40px 20px;
    }

    .lesson-content-placeholder i {
        font-size: 4rem;
        color: var(--bright-amber);
        margin-bottom: 20px;
        opacity: 0.5;
    }

    .lesson-content-placeholder h3 {
        font-size: 1.3rem;
        color: var(--text-primary);
        margin-bottom: 10px;
    }

    .lesson-content-placeholder p {
        color: var(--text-muted);
        max-width: 400px;
        margin: 0 auto;
    }

    /* Curriculum Sidebar */
    .learning-sidebar {
        position: sticky;
        top: 120px;
        align-self: start;
    }

    .curriculum-container {
        background: var(--pure-white);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-md);
        border: 1px solid rgba(251, 198, 12, 0.1);
    }

    .curriculum-header {
        padding: 20px;
        background: var(--gradient-1);
        color: var(--pure-white);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .curriculum-header h3 {
        margin: 0;
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--pure-white);
    }

    .lessons-count {
        font-size: 0.9rem;
        padding: 4px 12px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: var(--radius-full);
        backdrop-filter: blur(5px);
    }

    /* Curriculum Sections */
    .curriculum-section {
        border-bottom: 1px solid rgba(251, 198, 12, 0.1);
    }

    .curriculum-section:last-child {
        border-bottom: none;
    }

    .section-header {
        padding: 15px 20px;
        background: var(--ivory);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: var(--transition);
    }

    .section-header:hover {
        background: rgba(251, 198, 12, 0.05);
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title i {
        color: var(--bright-amber);
        font-size: 0.8rem;
        transition: var(--transition);
    }

    .section-header.active .section-title i {
        transform: rotate(90deg);
    }

    .section-title h4 {
        margin: 0;
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-primary);
    }

    .section-meta {
        font-size: 0.85rem;
        color: var(--text-muted);
        background: var(--pure-white);
        padding: 4px 10px;
        border-radius: var(--radius-full);
    }

    .section-lessons {
        display: none;
        padding: 10px;
        background: var(--pure-white);
    }

    .section-lessons.show {
        display: block;
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Lesson Items */
    .lesson-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 15px;
        cursor: pointer;
        border-radius: var(--radius-md);
        transition: var(--transition);
        margin-bottom: 5px;
        border: 1px solid transparent;
    }

    .lesson-item:hover {
        background: var(--ivory);
        border-color: rgba(251, 198, 12, 0.2);
    }

    .lesson-item.current {
        background: rgba(251, 198, 12, 0.1);
        border-color: var(--bright-amber);
    }

    .lesson-item.completed {
        opacity: 0.8;
    }

    .lesson-status {
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .lesson-status i {
        font-size: 1rem;
    }

    .lesson-status .fa-check-circle {
        color: var(--sky-blue);
    }

    .lesson-status .fa-play-circle {
        color: var(--bright-amber);
    }

    .lesson-status .fa-circle {
        color: var(--pale-slate);
        font-size: 0.6rem;
    }

    .lesson-info {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .lesson-title {
        font-size: 0.95rem;
        font-weight: 500;
        color: var(--text-primary);
        line-height: 1.4;
    }

    .lesson-duration {
        font-size: 0.8rem;
        color: var(--text-muted);
    }

    /* Course Stats */
    .course-stats {
        padding: 20px;
        background: var(--gradient-1);
        border-top: 1px solid rgba(251, 198, 12, 0.2);
    }

    .stat-item {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
        padding: 10px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: var(--radius-md);
        backdrop-filter: blur(5px);
    }

    .stat-item:last-child {
        margin-bottom: 0;
    }

    .stat-item i {
        font-size: 1.5rem;
        color: var(--bright-amber);
    }

    .stat-item div {
        flex: 1;
    }

    .stat-value {
        display: block;
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--pure-white);
        margin-bottom: 2px;
    }

    .stat-label {
        font-size: 0.85rem;
        color: var(--ivory);
        opacity: 0.9;
    }

    /* Notification */
    .learning-notification {
        position: fixed;
        bottom: 20px;
        right: 20px;
        padding: 15px 25px;
        border-radius: var(--radius-full);
        box-shadow: var(--shadow-lg);
        z-index: 10000;
        animation: slideIn 0.3s ease;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 10px;
        max-width: 400px;
        border-left: 4px solid var(--bright-amber);
    }

    .learning-notification.success {
        background: var(--gradient-1);
        color: var(--pure-white);
    }

    .learning-notification.error {
        background: var(--gradient-2);
        color: var(--prussian-blue);
    }

    .learning-notification.info {
        background: var(--gradient-3);
        color: var(--prussian-blue);
    }

    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }

    /* Responsive */
    @media (max-width: 992px) {
        .learning-grid {
            grid-template-columns: 1fr;
        }

        .learning-sidebar {
            position: static;
            margin-top: 30px;
        }

        .curriculum-container {
            max-width: 600px;
            margin: 0 auto;
        }
    }

    @media (max-width: 768px) {
        .learning-header-content {
            flex-direction: column;
            align-items: flex-start;
        }

        .learning-back-btn {
            width: 100%;
            justify-content: center;
        }

        .learning-progress {
            flex-direction: column;
            align-items: flex-start;
            width: 100%;
        }

        .progress-bar-container {
            width: 100%;
        }

        .lesson-content-container {
            padding: 20px;
        }
    }

    @media (max-width: 576px) {
        .learning-header {
            padding: 15px 0;
        }

        .learning-title {
            font-size: 1.2rem;
        }

        .video-placeholder i {
            font-size: 3rem;
        }

        .video-placeholder p {
            font-size: 0.95rem;
        }

        .lesson-content-placeholder i {
            font-size: 3rem;
        }

        .lesson-content-placeholder h3 {
            font-size: 1.1rem;
        }

        .lesson-content-placeholder p {
            font-size: 0.9rem;
        }

        .section-header {
            padding: 12px 15px;
        }

        .section-title h4 {
            font-size: 0.95rem;
        }

        .lesson-item {
            padding: 10px 12px;
        }

        .lesson-title {
            font-size: 0.9rem;
        }

        .course-stats {
            padding: 15px;
        }

        .stat-item {
            padding: 8px;
        }

        .stat-item i {
            font-size: 1.2rem;
        }

        .stat-value {
            font-size: 1rem;
        }

        .stat-label {
            font-size: 0.8rem;
        }

        .learning-notification {
            left: 20px;
            right: 20px;
            max-width: none;
        }
    }

    @media (max-width: 380px) {
        .learning-title {
            font-size: 1.1rem;
        }

        .section-title {
            flex-wrap: wrap;
        }

        .section-meta {
            margin-left: 0;
        }

        .lesson-item {
            flex-wrap: wrap;
        }

        .lesson-info {
            width: 100%;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ========== CURRICULUM ACCORDION ==========
    const sectionHeaders = document.querySelectorAll('.section-header');
    
    sectionHeaders.forEach((header, index) => {
        // Open first section by default
        if (index === 0) {
            header.classList.add('active');
            const sectionId = header.dataset.section;
            document.getElementById(`section-${sectionId}`).classList.add('show');
        }

        header.addEventListener('click', function() {
            const sectionId = this.dataset.section;
            const content = document.getElementById(`section-${sectionId}`);
            
            // Toggle active class
            this.classList.toggle('active');
            
            // Toggle content with animation
            if (content.classList.contains('show')) {
                content.classList.remove('show');
            } else {
                content.classList.add('show');
            }
        });
    });

    // ========== LESSON SELECTION ==========
    const lessonItems = document.querySelectorAll('.lesson-item');
    const videoPlayer = document.querySelector('.video-player');
    const lessonContent = document.getElementById('lessonContent');
    
    lessonItems.forEach(lesson => {
        lesson.addEventListener('click', function() {
            const lessonId = this.dataset.lessonId;
            const lessonTitle = this.dataset.lessonTitle;
            const videoUrl = this.dataset.videoUrl;
            const content = this.dataset.content;
            
            // Remove current class from all lessons
            lessonItems.forEach(l => l.classList.remove('current'));
            
            // Add current class to clicked lesson
            this.classList.add('current');
            
            // Load video if available
            if (videoUrl) {
                loadVideo(videoUrl);
            } else {
                showVideoPlaceholder();
            }
            
            // Load lesson content
            if (content) {
                loadLessonContent(lessonTitle, content);
            } else {
                showLessonPlaceholder(lessonTitle);
            }
            
            // Mark lesson as completed (you would typically call an API here)
            // markLessonAsCompleted(lessonId);
        });
    });

    // ========== VIDEO PLAYER FUNCTIONS ==========
    function loadVideo(url) {
        if (!url) {
            showVideoPlaceholder();
            return;
        }

        let videoHtml = '';

        if (url.includes('youtube.com') || url.includes('youtu.be')) {
            const videoId = extractYoutubeId(url);
            if (videoId) {
                videoHtml = `<iframe src="https://www.youtube.com/embed/${videoId}?autoplay=1" frameborder="0" allowfullscreen allow="autoplay" style="width:100%; height:100%;"></iframe>`;
            }
        } else if (url.includes('vimeo.com')) {
            const vimeoId = extractVimeoId(url);
            if (vimeoId) {
                videoHtml = `<iframe src="https://player.vimeo.com/video/${vimeoId}?autoplay=1" frameborder="0" allowfullscreen allow="autoplay" style="width:100%; height:100%;"></iframe>`;
            }
        } else {
            videoHtml = `<video src="${url}" controls autoplay style="width:100%; height:100%;"></video>`;
        }

        if (videoHtml) {
            videoPlayer.innerHTML = videoHtml;
        } else {
            showVideoPlaceholder();
        }
    }

    function showVideoPlaceholder() {
        videoPlayer.innerHTML = `
            <div class="video-placeholder">
                <i class="fas fa-play-circle"></i>
                <p>No video available for this lesson</p>
            </div>
        `;
    }

    function extractYoutubeId(url) {
        const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/;
        const match = url.match(regExp);
        return (match && match[2].length === 11) ? match[2] : null;
    }

    function extractVimeoId(url) {
        const regExp = /vimeo\.com\/(?:video\/)?(\d+)/;
        const match = url.match(regExp);
        return match ? match[1] : null;
    }

    // ========== LESSON CONTENT FUNCTIONS ==========
    function loadLessonContent(title, content) {
        lessonContent.innerHTML = `
            <div class="lesson-content">
                <h2>${title}</h2>
                <div class="lesson-content-body">
                    ${content}
                </div>
            </div>
        `;
    }

    function showLessonPlaceholder(title) {
        lessonContent.innerHTML = `
            <div class="lesson-content-placeholder">
                <i class="fas fa-book-open"></i>
                <h3>${title}</h3>
                <p>This lesson is ready for you. Start learning now!</p>
            </div>
        `;
    }

    // ========== MARK LESSON AS COMPLETED ==========
    function markLessonAsCompleted(lessonId) {
        fetch(`/courses/lesson/${lessonId}/complete`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update progress bar
                const progressFill = document.querySelector('.progress-fill');
                if (progressFill) {
                    progressFill.style.width = data.progress + '%';
                }
                
                // Update progress text
                const progressText = document.querySelector('.progress-text');
                if (progressText) {
                    progressText.textContent = `Your Progress: ${data.progress}%`;
                }
                
                // Update completed lessons count
                const statValue = document.querySelector('.stat-value');
                if (statValue) {
                    statValue.textContent = `${data.completed}/${data.total}`;
                }
                
                // Show notification
                showNotification('Lesson completed!', 'success');
            }
        })
        .catch(error => {
            console.error('Error marking lesson as completed:', error);
        });
    }

    // ========== NOTIFICATION SYSTEM ==========
    function showNotification(message, type = 'success') {
        const existingNotifications = document.querySelectorAll('.learning-notification');
        existingNotifications.forEach(notification => notification.remove());

        const notification = document.createElement('div');
        notification.className = `learning-notification ${type}`;

        const icon = document.createElement('i');
        icon.className = type === 'success' ? 'fas fa-check-circle' : 
                        type === 'error' ? 'fas fa-exclamation-circle' : 
                        'fas fa-info-circle';
        notification.appendChild(icon);

        const textSpan = document.createElement('span');
        textSpan.textContent = message;
        notification.appendChild(textSpan);

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    // ========== ADD SLIDE OUT ANIMATION ==========
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);

    // ========== RESPONSIVE SIDEBAR ==========
    function handleResize() {
        const sidebar = document.querySelector('.learning-sidebar');
        if (window.innerWidth <= 992) {
            sidebar.style.position = 'static';
        } else {
            sidebar.style.position = 'sticky';
        }
    }

    window.addEventListener('resize', handleResize);
    handleResize();

    console.log('Learning page initialized');
});
</script>
@endsection