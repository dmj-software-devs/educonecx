@extends('layouts.admin')
@section('title', 'Add English Practice Lesson')
@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
    <div>
        <h1 class="page-title mb-1">Add Lesson</h1>
        <p class="text-muted mb-0">{{ $course->title }} · Add a video lesson for learners.</p>
    </div>
    <a href="{{ route('admin.english-practice-courses.edit', $course) }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left"></i> Back to Course</a>
</div>
@if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
<form action="{{ route('admin.english-practice-courses.lessons.store', $course) }}" method="POST" enctype="multipart/form-data">@include('admin.english-practice-lessons._form')</form>
@endsection
