@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-body text-center">
                    @if(Auth::user()->avatar)
                        <img src="{{ Auth::user()->avatar }}" alt="" class="rounded-circle mb-3" style="width: 100px; height: 100px; object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 100px; height: 100px; font-size: 2rem;">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    @endif
                    <h5>{{ Auth::user()->name }}</h5>
                    <p class="text-muted">{{ Auth::user()->email }}</p>
                    <a href="{{ route('profile') }}" class="btn btn-outline-primary btn-sm">Edit Profile</a>
                </div>
            </div>
            
            <div class="card">
                <div class="list-group list-group-flush">
                    <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action active">
                        <i class="fas fa-home me-2"></i> Dashboard
                    </a>
                    <a href="{{ route('my-courses') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-book me-2"></i> My Courses
                    </a>
                    <a href="{{ route('my-quizzes') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-question-circle me-2"></i> My Quizzes
                    </a>
                    <a href="{{ route('certificates') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-certificate me-2"></i> Certificates
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-9">
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h6>Enrolled Courses</h6>
                            <h3>{{ $stats['enrolled_courses'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h6>Completed</h6>
                            <h3>{{ $stats['completed_courses'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <h6>Quizzes Taken</h6>
                            <h3>{{ $stats['quizzes_taken'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <h6>Certificates</h6>
                            <h3>{{ $stats['certificates_earned'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Recent Courses</h5>
                </div>
                <div class="list-group list-group-flush">
                    @foreach($recentCourses as $enrollment)
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6>{{ $enrollment->course->title }}</h6>
                                <div class="progress" style="height: 5px; width: 200px;">
                                    <div class="progress-bar" style="width: {{ $enrollment->progress }}%"></div>
                                </div>
                            </div>
                            <a href="{{ route('courses.learn', $enrollment->course) }}" class="btn btn-sm btn-primary">Continue</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Recent Quiz Attempts</h5>
                </div>
                <div class="list-group list-group-flush">
                    @foreach($recentQuizzes as $attempt)
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6>{{ $attempt->quiz->title }}</h6>
                                <small class="text-muted">Score: {{ $attempt->percentage }}%</small>
                            </div>
                            <span class="badge bg-{{ $attempt->passed ? 'success' : 'danger' }}">
                                {{ $attempt->passed ? 'Passed' : 'Failed' }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Recommended Courses</h5>
                </div>
                <div class="row g-4 p-3">
                    @foreach($recommendedCourses as $course)
                    <div class="col-md-4">
                        <div class="card h-100">
                            <img src="{{ $course->thumbnail_url }}" class="card-img-top" alt="">
                            <div class="card-body">
                                <h6>{{ $course->title }}</h6>
                                <p class="text-muted small">{{ Str::limit($course->excerpt, 50) }}</p>
                            </div>
                            <div class="card-footer bg-transparent">
                                <a href="{{ route('courses.show', $course->slug) }}" class="btn btn-sm btn-outline-primary w-100">View Course</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection