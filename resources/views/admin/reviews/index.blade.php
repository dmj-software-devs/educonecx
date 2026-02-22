@extends('layouts.admin')

@section('title', 'Reviews')
@section('page-title', 'Reviews')

@section('content')
<div class="table-container">
    <table class="table data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Course</th>
                <th>Rating</th>
                <th>Title</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reviews ?? [] as $review)
            <tr>
                <td>{{ $review->id }}</td>
                <td>{{ $review->user->name ?? 'N/A' }}</td>
                <td>{{ $review->course->title ?? 'N/A' }}</td>
                <td>{{ $review->rating }}/5</td>
                <td>{{ $review->title }}</td>
                <td>{{ ucfirst($review->status) }}</td>
                <td>{{ $review->created_at->format('M d, Y') }}</td>
                <td>
                    <a href="{{ route('admin.reviews.show', $review) }}" class="btn btn-sm btn-success">
                        <i class="fas fa-eye"></i>
                    </a>
                    @if($review->status == 'pending')
                    <form action="{{ route('admin.reviews.approve', $review) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success">
                            <i class="fas fa-check"></i>
                        </button>
                    </form>
                    <form action="{{ route('admin.reviews.reject', $review) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-warning">
                            <i class="fas fa-times"></i>
                        </button>
                    </form>
                    @endif
                    <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="d-inline">
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