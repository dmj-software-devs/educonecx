@extends('layouts.admin')

@section('title', 'Create English Practice Course')

@section('content')
<h1 class="page-title mb-4">Create English Practice Course</h1>
@if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
<div class="form-card bg-white">
    <form action="{{ route('admin.english-practice-courses.store') }}" method="POST" enctype="multipart/form-data">
        @include('admin.english-practice-courses._form')
    </form>
</div>
@endsection
