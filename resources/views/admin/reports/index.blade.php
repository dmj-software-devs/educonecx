@extends('layouts.admin')

@section('title', 'Reports')
@section('page-title', 'Reports')

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="stat-card text-center">
            <i class="fas fa-chart-line fa-3x mb-3 text-primary"></i>
            <h5>Sales Report</h5>
            <p>View sales analytics and revenue</p>
            <a href="{{ route('admin.reports.sales') }}" class="btn btn-primary btn-sm">View Report</a>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card text-center">
            <i class="fas fa-users fa-3x mb-3 text-success"></i>
            <h5>Students Report</h5>
            <p>Student enrollment and activity</p>
            <a href="{{ route('admin.reports.students') }}" class="btn btn-success btn-sm">View Report</a>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card text-center">
            <i class="fas fa-book fa-3x mb-3 text-info"></i>
            <h5>Courses Report</h5>
            <p>Course performance analytics</p>
            <a href="{{ route('admin.reports.courses') }}" class="btn btn-info btn-sm">View Report</a>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card text-center">
            <i class="fas fa-question-circle fa-3x mb-3 text-warning"></i>
            <h5>Quizzes Report</h5>
            <p>Quiz attempt statistics</p>
            <a href="{{ route('admin.reports.quizzes') }}" class="btn btn-warning btn-sm">View Report</a>
        </div>
    </div>
</div>
@endsection