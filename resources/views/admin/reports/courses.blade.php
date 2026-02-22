@extends('layouts.admin')

@section('title', 'Courses Report')
@section('page-title', 'Courses Report')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="stat-card">
            <h6>Total Courses</h6>
            <h3>{{ $totalCourses }}</h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <h6>Total Enrollments</h6>
            <h3>{{ $totalEnrollments }}</h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <h6>Average Rating</h6>
            <h3>{{ number_format($averageRating, 2) }} / 5</h3>
        </div>
    </div>
</div>

<div class="table-container mt-4">
    <h5>Most Popular Courses</h5>
    <table class="table">
        <thead>
            <tr>
                <th>Course</th>
                <th>Enrollments</th>
            </tr>
        </thead>
        <tbody>
            @foreach($popularCourses as $course)
            <tr>
                <td>{{ $course->title }}</td>
                <td>{{ $course->enrollments_count }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="table-container mt-4">
    <h5>Highest Rated Courses</h5>
    <table class="table">
        <thead>
            <tr>
                <th>Course</th>
                <th>Average Rating</th>
            </tr>
        </thead>
        <tbody>
            @foreach($topRatedCourses as $course)
            <tr>
                <td>{{ $course->title }}</td>
                <td>{{ number_format($course->avg_rating, 2) }} / 5</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection