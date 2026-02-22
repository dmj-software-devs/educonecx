@extends('layouts.admin')

@section('title', 'Create Course')
@section('page-title', 'Create Course')

@section('content')
<div class="form-card">
    <form action="{{ route('admin.courses.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-control">
                    <option value="">Select Category</option>
                    @foreach($categories ?? [] as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Price</label>
                <input type="number" name="price" class="form-control" step="0.01" required>
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Sale Price</label>
                <input type="number" name="sale_price" class="form-control" step="0.01">
            </div>
            
            <div class="col-md-12 mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="5" required></textarea>
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Thumbnail</label>
                <input type="file" name="thumbnail" class="form-control">
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control" required>
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                    <option value="archived">Archived</option>
                </select>
            </div>
            
            <div class="col-md-12 mb-3">
                <label class="form-label">Tags</label>
                <select name="tags[]" class="form-control select2" multiple>
                    @foreach($tags ?? [] as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary">Create Course</button>
    </form>
</div>
@endsection