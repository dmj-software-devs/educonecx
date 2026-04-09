@extends('layouts.admin')

@section('title', 'Edit Subscription')
@section('page-title', 'Edit Subscription')

@section('content')
<div class="table-container" style="max-width: 900px;">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Edit Subscription #{{ $subscription->id }}</h5>
        <a href="{{ route('admin.subscriptions.show', $subscription) }}" class="btn btn-outline-secondary btn-sm">Back</a>
    </div>

    <form action="{{ route('admin.subscriptions.update', $subscription) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Student</label>
            <input type="text" class="form-control" value="{{ $subscription->user->name }} ({{ $subscription->user->email }})" disabled>
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Subscription Plan</label>
                <select name="plan_id" class="form-select @error('plan_id') is-invalid @enderror" required>
                    @foreach($plans as $plan)
                        <option value="{{ $plan->id }}" {{ old('plan_id', $subscription->plan_id) == $plan->id ? 'selected' : '' }}>
                            {{ $plan->name }} ({{ $plan->formatted_price }} / {{ $plan->duration_text }})
                        </option>
                    @endforeach
                </select>
                @error('plan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">Status</label>
                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                    @foreach(['active', 'pending', 'expired', 'cancelled'] as $status)
                        <option value="{{ $status }}" {{ old('status', $subscription->status) === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">Start Date</label>
                <input type="date" name="start_date" value="{{ old('start_date', optional($subscription->start_date)->toDateString()) }}" class="form-control @error('start_date') is-invalid @enderror" required>
                @error('start_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">End Date</label>
                <input type="date" name="end_date" value="{{ old('end_date', optional($subscription->end_date)->toDateString()) }}" class="form-control @error('end_date') is-invalid @enderror" required>
                @error('end_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">Payment Status</label>
                <select name="payment_status" class="form-select @error('payment_status') is-invalid @enderror" required>
                    @foreach(['paid', 'pending', 'failed'] as $payment)
                        <option value="{{ $payment }}" {{ old('payment_status', $subscription->payment_status) === $payment ? 'selected' : '' }}>{{ ucfirst($payment) }}</option>
                    @endforeach
                </select>
                @error('payment_status') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 d-flex align-items-center">
                <div class="form-check mt-4">
                    <input type="checkbox" class="form-check-input" name="auto_renew" id="autoRenew" value="1" {{ old('auto_renew', $subscription->auto_renew) ? 'checked' : '' }}>
                    <label class="form-check-label" for="autoRenew">Enable Auto Renew</label>
                </div>
            </div>
        </div>

        <div class="mt-3">
            <button class="btn btn-primary" type="submit"><i class="fas fa-save"></i> Update Subscription</button>
        </div>
    </form>
</div>
@endsection
