@extends('layouts.admin')

@section('title', 'Add Manual Subscription')
@section('page-title', 'Add Manual Subscription')

@section('content')
<div class="table-container" style="max-width: 900px;">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Create Subscription for Offline/Manual Payment</h5>
        <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-outline-secondary btn-sm">Back</a>
    </div>

    <form action="{{ route('admin.subscriptions.store') }}" method="POST">
        @csrf

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Student</label>
                <select name="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                    <option value="">Select student</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
                @error('user_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">Subscription Plan</label>
                <select name="plan_id" class="form-select @error('plan_id') is-invalid @enderror" required>
                    <option value="">Select plan</option>
                    @foreach($plans as $plan)
                        <option value="{{ $plan->id }}" {{ old('plan_id') == $plan->id ? 'selected' : '' }}>
                            {{ $plan->name }} ({{ $plan->formatted_price }} / {{ $plan->duration_text }})
                        </option>
                    @endforeach
                </select>
                @error('plan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">Start Date</label>
                <input type="date" name="start_date" value="{{ old('start_date', now()->toDateString()) }}" class="form-control @error('start_date') is-invalid @enderror" required>
                @error('start_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">End Date</label>
                <input type="date" name="end_date" value="{{ old('end_date', now()->addDays(30)->toDateString()) }}" class="form-control @error('end_date') is-invalid @enderror" required>
                @error('end_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">Subscription Status</label>
                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                    @foreach(['active', 'pending', 'expired', 'cancelled'] as $status)
                        <option value="{{ $status }}" {{ old('status', 'active') === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">Payment Status</label>
                <select name="payment_status" class="form-select @error('payment_status') is-invalid @enderror" required>
                    @foreach(['paid', 'pending', 'failed'] as $status)
                        <option value="{{ $status }}" {{ old('payment_status', 'paid') === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
                @error('payment_status') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-12">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="auto_renew" id="autoRenew" value="1" {{ old('auto_renew') ? 'checked' : '' }}>
                    <label class="form-check-label" for="autoRenew">Enable Auto Renew</label>
                </div>
            </div>
        </div>

        <div class="alert alert-info mt-3 mb-0">
            If status is set to <strong>Active</strong>, this user will immediately get access to all paid courses via subscription enrollments.
        </div>

        <div class="mt-3">
            <button class="btn btn-primary" type="submit"><i class="fas fa-check"></i> Create Subscription</button>
        </div>
    </form>
</div>
@endsection
