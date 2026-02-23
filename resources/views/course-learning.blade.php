@extends('layouts.main')

@section('title', $course->title . ' - Learning')

@section('content')
<div class="learning-container">
    <div class="learning-header">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1>{{ $course->title }}</h1>
                    <div class="progress-info">
                        <span>Your Progress: {{ $enrollment->progress }}%</span>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ $enrollment->progress }}%"></div>
                        </div>
                    </div>
                </div>
                <a href="{{ route('courses.show', $course->slug) }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Back to Course
                </a>
            </div>
        </div>
    </div>

    <div class="learning-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="video-player">
                        <!-- Video player will go here -->
                        <div class="placeholder-player">
                            <i class="fas fa-play-circle"></i>
                            <p>Select a lesson to start learning</p>
                        </div>
                    </div>
                    
                    <div class="lesson-content">
                        <!-- Lesson content will load here -->
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="curriculum-sidebar">
                        <h3>Course Curriculum</h3>
                        @foreach($course->sections as $section)
                            <div class="section-item">
                                <div class="section-header">
                                    <h4>{{ $section->title }}</h4>
                                    <span>{{ $section->lessons->count() }} lessons</span>
                                </div>
                                <div class="section-lessons">
                                    @foreach($section->lessons as $lesson)
                                        <div class="lesson-item" data-lesson-id="{{ $lesson->id }}">
                                            <i class="fas fa-play-circle"></i>
                                            <span>{{ $lesson->title }}</span>
                                            <span class="lesson-duration">{{ $lesson->duration_formatted }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.learning-container {
    min-height: 100vh;
    background: #f8f9fa;
}

.learning-header {
    background: white;
    padding: 20px 0;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    position: sticky;
    top: 0;
    z-index: 100;
}

.learning-header h1 {
    font-size: 1.5rem;
    margin: 0 0 10px 0;
}

.progress-info {
    display: flex;
    align-items: center;
    gap: 15px;
}

.progress-bar {
    width: 200px;
    height: 8px;
    background: #e9ecef;
    border-radius: 4px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    transition: width 0.3s ease;
}

.btn-back {
    padding: 10px 20px;
    background: #f8f9fa;
    color: #333;
    text-decoration: none;
    border-radius: 5px;
    transition: all 0.3s;
}

.btn-back:hover {
    background: #e9ecef;
}

.learning-content {
    padding: 40px 0;
}

.video-player {
    background: #000;
    border-radius: 10px;
    overflow: hidden;
    margin-bottom: 20px;
    aspect-ratio: 16/9;
    display: flex;
    align-items: center;
    justify-content: center;
}

.placeholder-player {
    text-align: center;
    color: white;
}

.placeholder-player i {
    font-size: 4rem;
    margin-bottom: 15px;
    opacity: 0.5;
}

.curriculum-sidebar {
    background: white;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    position: sticky;
    top: 100px;
}

.curriculum-sidebar h3 {
    margin-bottom: 20px;
    font-size: 1.2rem;
}

.section-item {
    margin-bottom: 15px;
    border: 1px solid #e9ecef;
    border-radius: 5px;
    overflow: hidden;
}

.section-header {
    background: #f8f9fa;
    padding: 12px 15px;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.section-header h4 {
    margin: 0;
    font-size: 1rem;
}

.section-lessons {
    padding: 10px;
}

.lesson-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px;
    cursor: pointer;
    border-radius: 5px;
    transition: background 0.3s;
}

.lesson-item:hover {
    background: #f8f9fa;
}

.lesson-item i {
    color: #667eea;
    font-size: 0.9rem;
}

.lesson-item span {
    flex: 1;
    font-size: 0.95rem;
}

.lesson-duration {
    font-size: 0.8rem;
    color: #6c757d;
}
</style>
@endsection