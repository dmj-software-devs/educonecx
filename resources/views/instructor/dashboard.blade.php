@extends('layouts.main')

@section('title', 'Instructor Dashboard')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Instructor Dashboard</h1>
    <p>Welcome, {{ Auth::user()->name }}!</p>
    
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5>My Courses</h5>
                    <p>View and manage your courses</p>
                    <a href="{{ route('instructor.courses.index') }}" class="btn btn-primary">Manage Courses</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5>My Quizzes</h5>
                    <p>View and manage your quizzes</p>
                    <a href="{{ route('instructor.quizzes.index') }}" class="btn btn-primary">Manage Quizzes</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5>Students</h5>
                    <p>View your enrolled students</p>
                    <a href="{{ route('instructor.students') }}" class="btn btn-primary">View Students</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5>Earnings</h5>
                    <p>View your earnings</p>
                    <a href="{{ route('instructor.earnings') }}" class="btn btn-primary">View Earnings</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection