@extends('layouts.admin')

@section('title', 'Edit Course')
@section('page-title', 'Edit Course')

@section('content')
<div class="form-card">
    <form action="{{ route('admin.courses.update', $course) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="{{ $course->title }}" required>
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-control">
                    <option value="">Select Category</option>
                    @foreach($categories ?? [] as $category)
                    <option value="{{ $category->id }}" {{ $course->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Price</label>
                <input type="number" name="price" class="form-control" step="0.01" value="{{ $course->price }}" required>
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Sale Price</label>
                <input type="number" name="sale_price" class="form-control" step="0.01" value="{{ $course->sale_price }}">
            </div>
            
            <div class="col-md-12 mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="5" required>{{ $course->description }}</textarea>
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Thumbnail</label>
                <input type="file" name="thumbnail" class="form-control">
                @if($course->thumbnail)
                <img src="{{ $course->thumbnail_url }}" alt="" style="width: 100px; margin-top: 10px;">
                @endif
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control" required>
                    <option value="draft" {{ $course->status == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ $course->status == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="archived" {{ $course->status == 'archived' ? 'selected' : '' }}>Archived</option>
                </select>
            </div>
            
            <div class="col-md-12 mb-3">
                <label class="form-label">Tags</label>
                <select name="tags[]" class="form-control select2" multiple>
                    @foreach($tags ?? [] as $tag)
                    <option value="{{ $tag->id }}" {{ $course->tags->contains($tag->id) ? 'selected' : '' }}>
                        {{ $tag->name }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary">Update Course</button>
    </form>
</div>
@endsection