@extends('layouts.main')

@section('title', 'My Courses')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="list-group list-group-flush">
                    <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-home me-2"></i> Dashboard
                    </a>
                    <a href="{{ route('my-courses') }}" class="list-group-item list-group-item-action active">
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
            <h2 class="mb-4">My Courses</h2>
            
            <div class="row">
                @foreach($enrollments as $enrollment)
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="{{ $enrollment->course->thumbnail_url }}" class="img-fluid rounded-start" alt="" style="height: 100%; object-fit: cover;">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $enrollment->course->title }}</h5>
                                    <div class="progress mb-2" style="height: 5px;">
                                        <div class="progress-bar" style="width: {{ $enrollment->progress }}%"></div>
                                    </div>
                                    <p class="small">{{ $enrollment->progress }}% Complete</p>
                                    <a href="{{ route('courses.learn', $enrollment->course) }}" class="btn btn-primary btn-sm">Continue Learning</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="mt-4">
                {{ $enrollments->links() }}
            </div>
        </div>
    </div>
</div>
@endsection