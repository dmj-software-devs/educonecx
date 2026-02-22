@extends('layouts.admin')

@section('title', 'Edit Category')
@section('page-title', 'Edit Category')

@section('content')
<div class="form-card">
    <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Slug</label>
                <input type="text" name="slug" class="form-control" value="{{ $category->slug }}">
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Parent Category</label>
                <select name="parent_id" class="form-control">
                    <option value="">None</option>
                    @foreach($categories ?? [] as $cat)
                    <option value="{{ $cat->id }}" {{ $category->parent_id == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Icon</label>
                <input type="text" name="icon" class="form-control" value="{{ $category->icon }}">
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Image</label>
                <input type="file" name="image" class="form-control">
                @if($category->image)
                <img src="{{ asset('storage/' . $category->image) }}" alt="" style="width: 100px; margin-top: 10px;">
                @endif
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control" required>
                    <option value="active" {{ $category->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $category->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Sort Order</label>
                <input type="number" name="sort_order" class="form-control" value="{{ $category->sort_order }}">
            </div>
            
            <div class="col-md-12 mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ $category->description }}</textarea>
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary">Update Category</button>
    </form>
</div>
@endsection