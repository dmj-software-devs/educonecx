@extends('layouts.main')

@section('title', 'My Quizzes')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="list-group list-group-flush">
                    <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-home me-2"></i> Dashboard
                    </a>
                    <a href="{{ route('my-courses') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-book me-2"></i> My Courses
                    </a>
                    <a href="{{ route('my-quizzes') }}" class="list-group-item list-group-item-action active">
                        <i class="fas fa-question-circle me-2"></i> My Quizzes
                    </a>
                    <a href="{{ route('certificates') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-certificate me-2"></i> Certificates
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-9">
            <h2 class="mb-4">My Quiz Attempts</h2>
            
            <div class="card">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Quiz</th>
                                <th>Attempt</th>
                                <th>Score</th>
                                <th>Result</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attempts as $attempt)
                            <tr>
                                <td>{{ $attempt->quiz->title }}</td>
                                <td>{{ $attempt->attempt_number }}</td>
                                <td>{{ $attempt->percentage }}%</td>
                                <td>
                                    <span class="badge bg-{{ $attempt->passed ? 'success' : 'danger' }}">
                                        {{ $attempt->passed ? 'Passed' : 'Failed' }}
                                    </span>
                                </td>
                                <td>{{ $attempt->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('quizzes.results', ['quiz' => $attempt->quiz, 'attempt' => $attempt]) }}" class="btn btn-sm btn-info">View</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="mt-4">
                {{ $attempts->links() }}
            </div>
        </div>
    </div>
</div>
@endsection