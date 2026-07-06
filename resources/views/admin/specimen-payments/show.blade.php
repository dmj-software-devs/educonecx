@extends('layouts.admin')
@section('title', 'Specimen Payment')
@section('page-title', 'Specimen Payment')
@section('content')
<div class="table-container p-4">
    <h3>{{ $payment->order_number }}</h3>
    <p><strong>Client:</strong> {{ $payment->user?->name ?? $payment->user?->email ?? 'N/A' }}</p>
    <p><strong>Request:</strong> {{ $payment->specimenRequest?->request_number ?? $payment->specimen_request_id }}</p>
    <p><strong>Total:</strong> ${{ number_format($payment->total, 2) }}</p>
    <p><strong>Status:</strong> {{ ucfirst($payment->payment_status) }}</p>
    <p><strong>Transaction:</strong> {{ $payment->transaction_id ?: 'N/A' }}</p>
    <p><strong>Stripe Session:</strong> {{ $payment->stripe_session_id ?: 'N/A' }}</p>
    <a class="btn btn-secondary" href="{{ route('admin.specimen-payments.index') }}">Back</a>
</div>
@endsection
