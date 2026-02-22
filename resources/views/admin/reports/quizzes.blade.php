@extends('layouts.admin')

@section('title', 'Quizzes Report')
@section('page-title', 'Quizzes Report')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="stat-card">
            <h6>Total Quizzes</h6>
            <h3>{{ $totalQuizzes }}</h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <h6>Total Attempts</h6>
            <h3>{{ $totalAttempts }}</h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <h6>Average Score</h6>
            <h3>{{ number_format($averageScore, 2) }}%</h3>
        </div>
    </div>
</div>

<div class="table-container mt-4">
    <h5>Most Attempted Quizzes</h5>
    <table class="table">
        <thead>
            <tr>
                <th>Quiz</th>
                <th>Attempts</th>
            </tr>
        </thead>
        <tbody>
            @foreach($popularQuizzes as $quiz)
            <tr>
                <td>{{ $quiz->title }}</td>
                <td>{{ $quiz->attempts_count }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="table-container mt-4">
    <h5>Highest Pass Rates</h5>
    <table class="table">
        <thead>
            <tr>
                <th>Quiz</th>
                <th>Attempts</th>
                <th>Passes</th>
                <th>Pass Rate</th>
            </tr>
        </thead>
        <tbody>
            @foreach($quizPassRates as $quiz)
            <tr>
                <td>{{ $quiz->title }}</td>
                <td>{{ $quiz->attempts }}</td>
                <td>{{ $quiz->passes }}</td>
                <td>{{ $quiz->pass_rate }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection