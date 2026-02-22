@extends('layouts.admin')

@section('title', 'Edit Quiz')
@section('page-title', 'Edit Quiz')

@section('content')
<div class="form-card">
    <form action="{{ route('admin.quizzes.update', $quiz) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="{{ $quiz->title }}" required>
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Type</label>
                <select name="type" class="form-control" required>
                    <option value="standalone" {{ $quiz->type == 'standalone' ? 'selected' : '' }}>Standalone</option>
                    <option value="course" {{ $quiz->type == 'course' ? 'selected' : '' }}>Course</option>
                    <option value="lesson" {{ $quiz->type == 'lesson' ? 'selected' : '' }}>Lesson</option>
                </select>
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Course</label>
                <select name="course_id" class="form-control">
                    <option value="">Select Course</option>
                    @foreach($courses ?? [] as $course)
                    <option value="{{ $course->id }}" {{ $quiz->course_id == $course->id ? 'selected' : '' }}>
                        {{ $course->title }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Time Limit (minutes)</label>
                <input type="number" name="time_limit" class="form-control" value="{{ $quiz->time_limit }}" min="1">
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Attempts Allowed</label>
                <input type="number" name="attempts_allowed" class="form-control" value="{{ $quiz->attempts_allowed }}" min="0">
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Pass Percentage</label>
                <input type="number" name="pass_percentage" class="form-control" value="{{ $quiz->pass_percentage }}" min="0" max="100">
            </div>
            
            <div class="col-md-12 mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ $quiz->description }}</textarea>
            </div>
            
            <div class="col-md-6 mb-3">
                <div class="form-check">
                    <input type="checkbox" name="shuffle_questions" class="form-check-input" value="1" {{ $quiz->shuffle_questions ? 'checked' : '' }}>
                    <label class="form-check-label">Shuffle Questions</label>
                </div>
            </div>
            
            <div class="col-md-6 mb-3">
                <div class="form-check">
                    <input type="checkbox" name="randomize_options" class="form-check-input" value="1" {{ $quiz->randomize_options ? 'checked' : '' }}>
                    <label class="form-check-label">Randomize Options</label>
                </div>
            </div>
            
            <div class="col-md-6 mb-3">
                <div class="form-check">
                    <input type="checkbox" name="show_results" class="form-check-input" value="1" {{ $quiz->show_results ? 'checked' : '' }}>
                    <label class="form-check-label">Show Results</label>
                </div>
            </div>
            
            <div class="col-md-6 mb-3">
                <div class="form-check">
                    <input type="checkbox" name="show_answers" class="form-check-input" value="1" {{ $quiz->show_answers ? 'checked' : '' }}>
                    <label class="form-check-label">Show Correct Answers</label>
                </div>
            </div>
            
            <div class="col-md-12 mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control" required>
                    <option value="draft" {{ $quiz->status == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ $quiz->status == 'published' ? 'selected' : '' }}>Published</option>
                </select>
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary">Update Quiz</button>
    </form>
</div>
@endsection