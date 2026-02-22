@extends('layouts.admin')

@section('title', 'Courses')
@section('page-title', 'Courses')

@section('content')
<div class="table-container">
    <div class="d-flex justify-content-between mb-3">
        <h5>All Courses</h5>
        <a href="{{ route('admin.courses.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Add New
        </a>
    </div>
    
    <table class="table data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Category</th>
                <th>Price</th>
                <th>Status</th>
                <th>Students</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($courses ?? [] as $course)
            <tr>
                <td>{{ $course->id }}</td>
                <td>{{ $course->title }}</td>
                <td>{{ $course->category->name ?? 'Uncategorized' }}</td>
                <td>${{ number_format($course->price, 2) }}</td>
                <td>{{ ucfirst($course->status) }}</td>
                <td>{{ $course->total_students }}</td>
                <td>
                    <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-sm btn-info">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" class="d-inline">
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