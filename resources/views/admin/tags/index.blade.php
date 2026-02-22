@extends('layouts.admin')

@section('title', 'Tags')
@section('page-title', 'Tags')

@section('content')
<div class="table-container">
    <div class="d-flex justify-content-between mb-3">
        <h5>All Tags</h5>
        <a href="{{ route('admin.tags.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Add New
        </a>
    </div>
    
    <table class="table data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Courses</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tags ?? [] as $tag)
            <tr>
                <td>{{ $tag->id }}</td>
                <td>{{ $tag->name }}</td>
                <td>{{ $tag->slug }}</td>
                <td>{{ $tag->courses_count }}</td>
                <td>{{ $tag->created_at->format('M d, Y') }}</td>
                <td>
                    <a href="{{ route('admin.tags.edit', $tag) }}" class="btn btn-sm btn-info">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('admin.tags.destroy', $tag) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection