@extends('layouts.admin')

@section('title', 'Students Report')
@section('page-title', 'Students Report')

@section('content')
<div class="form-card mb-4">
    <form method="GET" class="row">
        <div class="col-md-4">
            <label>Start Date</label>
            <input type="date" name="start_date" class="form-control" value="{{ $startDate->format('Y-m-d') }}">
        </div>
        <div class="col-md-4">
            <label>End Date</label>
            <input type="date" name="end_date" class="form-control" value="{{ $endDate->format('Y-m-d') }}">
        </div>
        <div class="col-md-4">
            <label>&nbsp;</label>
            <button type="submit" class="btn btn-primary form-control">Apply Filter</button>
        </div>
    </form>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="stat-card">
            <h6>New Students</h6>
            <h3>{{ $newStudents }}</h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <h6>Total Students</h6>
            <h3>{{ $totalStudents }}</h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <h6>Active Students</h6>
            <h3>{{ $activeStudents }}</h3>
        </div>
    </div>
</div>

<div class="table-container mt-4">
    <h5>Student Growth (Last 12 Months)</h5>
    <table class="table">
        <thead>
            <tr>
                <th>Year</th>
                <th>Month</th>
                <th>New Students</th>
            </tr>
        </thead>
        <tbody>
            @foreach($studentGrowth as $growth)
            <tr>
                <td>{{ $growth->year }}</td>
                <td>{{ date('F', mktime(0, 0, 0, $growth->month, 1)) }}</td>
                <td>{{ $growth->count }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="table-container mt-4">
    <h5>Top Students by Completion</h5>
    <table class="table">
        <thead>
            <tr>
                <th>Student</th>
                <th>Email</th>
                <th>Enrollments</th>
                <th>Completions</th>
                <th>Completion Rate</th>
            </tr>
        </thead>
        <tbody>
            @foreach($topStudents as $student)
            <tr>
                <td>{{ $student->name }}</td>
                <td>{{ $student->email }}</td>
                <td>{{ $student->total_enrollments }}</td>
                <td>{{ $student->completions }}</td>
                <td>
                    @if($student->total_enrollments > 0)
                        {{ round(($student->completions / $student->total_enrollments) * 100, 2) }}%
                    @else
                        0%
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection