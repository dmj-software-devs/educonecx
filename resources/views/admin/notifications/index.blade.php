@extends('layouts.admin')

@section('title', 'Notifications')
@section('page-title', 'Notifications')

@section('content')
<div class="table-container">
    <div class="d-flex justify-content-between mb-3">
        <h5>All Notifications</h5>
        <form action="{{ route('admin.notifications.mark-all-read') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fas fa-check-double"></i> Mark All as Read
            </button>
        </form>
    </div>
    
    <div class="list-group">
        @foreach($notifications as $notification)
        <div class="list-group-item {{ !$notification->is_read ? 'list-group-item-primary' : '' }}">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6>{{ $notification->title }}</h6>
                    <p>{{ $notification->message }}</p>
                    <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                </div>
                <form action="{{ route('admin.notifications.destroy', $notification) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    
    <div class="mt-3">
        {{ $notifications->links() }}
    </div>
</div>
@endsection