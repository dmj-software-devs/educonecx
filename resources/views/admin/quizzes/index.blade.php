@extends('layouts.admin')

@section('title', 'Quizzes')
@section('page-title', 'Quizzes')

@section('content')
<div class="table-container">
    <div class="d-flex justify-content-between mb-3">
        <h5>All Quizzes</h5>
        <a href="{{ route('admin.quizzes.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Add New
        </a>
    </div>
    
    <table class="table data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Type</th>
                <th>Course</th>
                <th>Questions</th>
                <th>Attempts</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($quizzes ?? [] as $quiz)
            <tr>
                <td>{{ $quiz->id }}</td>
                <td>{{ $quiz->title }}</td>
                <td>{{ ucfirst($quiz->type) }}</td>
                <td>{{ $quiz->course->title ?? 'N/A' }}</td>
                <td>{{ $quiz->total_questions }}</td>
                <td>{{ $quiz->total_attempts }}</td>
                <td>{{ ucfirst($quiz->status) }}</td>
                <td>
                    <a href="{{ route('admin.quizzes.questions', $quiz) }}" class="btn btn-sm btn-success">
                        <i class="fas fa-list"></i>
                    </a>
                    <a href="{{ route('admin.quizzes.edit', $quiz) }}" class="btn btn-sm btn-info">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('admin.quizzes.destroy', $quiz) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection