@extends('layouts.admin')

@section('title', 'Review Details')
@section('page-title', 'Review Details')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="form-card">
            <div class="d-flex justify-content-between mb-3">
                <h5>Review Information</h5>
                <span class="badge bg-{{ $review->status == 'approved' ? 'success' : ($review->status == 'pending' ? 'warning' : 'danger') }}">
                    {{ ucfirst($review->status) }}
                </span>
            </div>
            
            <table class="table">
                <tr>
                    <th style="width: 150px;">User:</th>
                    <td>{{ $review->user->name }} ({{ $review->user->email }})</td>
                </tr>
                <tr>
                    <th>Course:</th>
                    <td>{{ $review->course->title }}</td>
                </tr>
                <tr>
                    <th>Rating:</th>
                    <td>
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $review->rating)
                                <i class="fas fa-star text-warning"></i>
                            @else
                                <i class="far fa-star text-warning"></i>
                            @endif
                        @endfor
                    </td>
                </tr>
                <tr>
                    <th>Title:</th>
                    <td>{{ $review->title }}</td>
                </tr>
                <tr>
                    <th>Content:</th>
                    <td>{{ $review->content }}</td>
                </tr>
                <tr>
                    <th>Date:</th>
                    <td>{{ $review->created_at->format('F d, Y h:i A') }}</td>
                </tr>
            </table>
            
            @if($review->status == 'pending')
            <div class="mt-3">
                <form action="{{ route('admin.reviews.approve', $review) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check"></i> Approve Review
                    </button>
                </form>
                <form action="{{ route('admin.reviews.reject', $review) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-times"></i> Reject Review
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection