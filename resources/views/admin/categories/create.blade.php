@extends('layouts.admin')

@section('title', 'Create Category')
@section('page-title', 'Create Category')

@section('content')
<div class="form-card">
    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Slug (Optional)</label>
                <input type="text" name="slug" class="form-control">
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Parent Category</label>
                <select name="parent_id" class="form-control">
                    <option value="">None</option>
                    @foreach($categories ?? [] as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Icon (Font Awesome)</label>
                <input type="text" name="icon" class="form-control" placeholder="fas fa-folder">
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Image</label>
                <input type="file" name="image" class="form-control">
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control" required>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Sort Order</label>
                <input type="number" name="sort_order" class="form-control" value="0">
            </div>
            
            <div class="col-md-12 mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary">Create Category</button>
    </form>
</div>
@endsection