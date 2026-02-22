@extends('layouts.admin')

@section('title', 'Edit Tag')
@section('page-title', 'Edit Tag')

@section('content')
<div class="form-card">
    <form action="{{ route('admin.tags.update', $tag) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="{{ $tag->name }}" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Slug</label>
            <input type="text" name="slug" class="form-control" value="{{ $tag->slug }}">
        </div>
        
        <button type="submit" class="btn btn-primary">Update Tag</button>
    </form>
</div>
@endsection