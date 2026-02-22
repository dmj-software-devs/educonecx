@extends('layouts.admin')

@section('title', 'Create Tag')
@section('page-title', 'Create Tag')

@section('content')
<div class="form-card">
    <form action="{{ route('admin.tags.store') }}" method="POST">
        @csrf
        
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Slug (Optional)</label>
            <input type="text" name="slug" class="form-control">
        </div>
        
        <button type="submit" class="btn btn-primary">Create Tag</button>
    </form>
</div>
@endsection