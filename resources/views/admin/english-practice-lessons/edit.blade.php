@extends('layouts.admin')
@section('title', 'Edit English Practice Lesson')
@section('content')
<h1 class="page-title mb-1">Edit Lesson</h1>
<p class="text-muted mb-4">{{ $course->title }} / {{ $lesson->title }}</p>
@if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
<div class="form-card bg-white"><form action="{{ route('admin.english-practice-lessons.update', $lesson) }}" method="POST" enctype="multipart/form-data">@include('admin.english-practice-lessons._form')</form></div>
@endsection
