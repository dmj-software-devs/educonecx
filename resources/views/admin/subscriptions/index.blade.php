@extends('layouts.admin')

@section('title', 'User Subscriptions')
@section('page-title', 'User Subscriptions')

@section('content')
<div class="table-container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Manage User Subscriptions</h5>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.subscriptions.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add Manual Subscription
            </a>
            <a href="{{ route('admin.subscriptions.export', request()->query()) }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-file-csv"></i> Export CSV
            </a>
        </div>
    </div>

    <form method="GET" action="{{ route('admin.subscriptions.index') }}" class="row g-2 mb-4">
        <div class="col-md-3">
            <select name="user_id" class="form-select form-select-sm">
                <option value="">All Students</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="plan_id" class="form-select form-select-sm">
                <option value="">All Plans</option>
                @foreach($plans as $plan)
                    <option value="{{ $plan->id }}" {{ request('plan_id') == $plan->id ? 'selected' : '' }}>{{ $plan->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="status" class="form-select form-select-sm">
                <option value="">All Statuses</option>
                @foreach($statuses as $status)
                    <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <input type="date" name="date_from" class="form-control form-control-sm" value="{{ request('date_from') }}" placeholder="From">
        </div>
        <div class="col-md-2">
            <input type="date" name="date_to" class="form-control form-control-sm" value="{{ request('date_to') }}" placeholder="To">
        </div>
        <div class="col-md-1 d-grid">
            <button class="btn btn-dark btn-sm" type="submit">Filter</button>
        </div>
    </form>

    <table class="table data-table align-middle">
        <thead>
            <tr>
                <th>#</th>
                <th>Student</th>
                <th>Plan</th>
                <th>Start</th>
                <th>End</th>
                <th>Status</th>
                <th>Payment</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($subscriptions as $subscription)
                <tr>
                    <td>{{ $subscription->id }}</td>
                    <td>
                        <div>{{ $subscription->user->name ?? 'N/A' }}</div>
                        <small class="text-muted">{{ $subscription->user->email ?? '-' }}</small>
                    </td>
                    <td>{{ $subscription->plan->name ?? 'N/A' }}</td>
                    <td>{{ optional($subscription->start_date)->format('M d, Y') }}</td>
                    <td>{{ optional($subscription->end_date)->format('M d, Y') }}</td>
                    <td>
                        <span class="badge bg-{{ $subscription->status === 'active' ? 'success' : ($subscription->status === 'pending' ? 'warning' : 'secondary') }}">
                            {{ ucfirst($subscription->status) }}
                        </span>
                    </td>
                    <td>{{ ucfirst($subscription->payment_status) }}</td>
                    <td class="d-flex gap-1">
                        <a href="{{ route('admin.subscriptions.show', $subscription) }}" class="btn btn-sm btn-success" title="View">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.subscriptions.edit', $subscription) }}" class="btn btn-sm btn-info" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.subscriptions.destroy', $subscription) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this subscription and related subscription enrollments?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">No subscriptions found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-3">
        {{ $subscriptions->links() }}
    </div>
</div>
@endsection
