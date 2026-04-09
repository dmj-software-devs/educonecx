@extends('layouts.admin')

@section('title', 'Subscription Details')
@section('page-title', 'Subscription Details')

@section('content')
<div class="table-container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Subscription #{{ $subscription->id }}</h5>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.subscriptions.edit', $subscription) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i> Edit</a>
            <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-outline-secondary btn-sm">Back</a>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-md-4"><strong>Student:</strong><br>{{ $subscription->user->name }}<br><small>{{ $subscription->user->email }}</small></div>
        <div class="col-md-4"><strong>Plan:</strong><br>{{ $subscription->plan->name ?? 'N/A' }}</div>
        <div class="col-md-4"><strong>Price:</strong><br>{{ $subscription->plan->formatted_price ?? '-' }}</div>
        <div class="col-md-4"><strong>Start Date:</strong><br>{{ optional($subscription->start_date)->format('M d, Y') }}</div>
        <div class="col-md-4"><strong>End Date:</strong><br>{{ optional($subscription->end_date)->format('M d, Y') }}</div>
        <div class="col-md-4"><strong>Auto Renew:</strong><br>{{ $subscription->auto_renew ? 'Yes' : 'No' }}</div>
        <div class="col-md-4"><strong>Status:</strong><br>{{ ucfirst($subscription->status) }}</div>
        <div class="col-md-4"><strong>Payment Status:</strong><br>{{ ucfirst($subscription->payment_status) }}</div>
        <div class="col-md-4"><strong>Created:</strong><br>{{ optional($subscription->created_at)->format('M d, Y h:i A') }}</div>
    </div>

    <div class="d-flex flex-wrap gap-2 mb-4">
        @if($subscription->status !== 'cancelled')
            <form action="{{ route('admin.subscriptions.cancel', $subscription) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Cancel this subscription now?')">
                    <i class="fas fa-ban"></i> Cancel Subscription
                </button>
            </form>
        @endif

        <form action="{{ route('admin.subscriptions.renew', $subscription) }}" method="POST" class="d-flex gap-2 align-items-center">
            @csrf
            <input type="number" min="1" name="duration_days" class="form-control form-control-sm" placeholder="Days to extend" style="max-width: 160px;">
            <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-sync"></i> Renew</button>
        </form>
    </div>

    <h6>Courses unlocked via subscription</h6>
    <table class="table data-table align-middle">
        <thead>
            <tr>
                <th>Course</th>
                <th>Progress</th>
                <th>Status</th>
                <th>Expiry Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($enrollments as $enrollment)
                <tr>
                    <td>{{ $enrollment->course->title ?? 'N/A' }}</td>
                    <td>{{ $enrollment->progress }}%</td>
                    <td>{{ ucfirst($enrollment->status) }}</td>
                    <td>{{ optional($enrollment->expiry_date)->format('M d, Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-3">No subscription enrollments found for this user.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
