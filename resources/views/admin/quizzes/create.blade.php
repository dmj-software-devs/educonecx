@extends('layouts.admin')

@section('title', 'Create Quiz')
@section('page-title', 'Create Quiz')

@section('content')
<div class="form-card">
    <form action="{{ route('admin.quizzes.store') }}" method="POST">
        @csrf
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Type</label>
                <select name="type" class="form-control" required>
                    <option value="standalone">Standalone</option>
                    <option value="course">Course</option>
                    <option value="lesson">Lesson</option>
                </select>
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Course</label>
                <select name="course_id" class="form-control">
                    <option value="">Select Course</option>
                    @foreach($courses ?? [] as $course)
                    <option value="{{ $course->id }}">{{ $course->title }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Time Limit (minutes)</label>
                <input type="number" name="time_limit" class="form-control" min="1">
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Attempts Allowed</label>
                <input type="number" name="attempts_allowed" class="form-control" value="1" min="0">
                <small class="text-muted">0 = unlimited</small>
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Pass Percentage</label>
                <input type="number" name="pass_percentage" class="form-control" value="70" min="0" max="100">
            </div>
            
            <div class="col-md-12 mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>
            
            <div class="col-md-6 mb-3">
                <div class="form-check">
                    <input type="checkbox" name="shuffle_questions" class="form-check-input" value="1">
                    <label class="form-check-label">Shuffle Questions</label>
                </div>
            </div>
            
            <div class="col-md-6 mb-3">
                <div class="form-check">
                    <input type="checkbox" name="randomize_options" class="form-check-input" value="1">
                    <label class="form-check-label">Randomize Options</label>
                </div>
            </div>
            
            <div class="col-md-6 mb-3">
                <div class="form-check">
                    <input type="checkbox" name="show_results" class="form-check-input" value="1" checked>
                    <label class="form-check-label">Show Results</label>
                </div>
            </div>
            
            <div class="col-md-6 mb-3">
                <div class="form-check">
                    <input type="checkbox" name="show_answers" class="form-check-input" value="1">
                    <label class="form-check-label">Show Correct Answers</label>
                </div>
            </div>
            
            <div class="col-md-12 mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control" required>
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                </select>
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary">Create Quiz</button>
    </form>
</div>
@endsection