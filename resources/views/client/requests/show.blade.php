@extends('layouts.main')
@section('title', 'Specimen Request')
@section('content')
<div class="container py-5">
    @include('partials.flash')
    <h1>Specimen Request #{{ $request->request_number ?? $request->id }}</h1>
    <div class="card p-4 mb-4">
        <p><strong>Status:</strong> {{ ucfirst(str_replace('_',' ', $request->status)) }}</p>
        <p><strong>Payment:</strong> {{ ucfirst($request->payment_status) }}</p>
        <p><strong>Amount:</strong> ${{ number_format($request->quoted_amount, 2) }}</p>
        <p><strong>Pickup:</strong> {{ $request->pickup_address ?: 'N/A' }}</p>
        <p><strong>Delivery:</strong> {{ $request->delivery_address ?: 'N/A' }}</p>
        <p><strong>Specimen Type:</strong> {{ $request->specimen_type ?: 'N/A' }}</p>
    </div>
    <div class="d-flex gap-2">
        @if($request->canClientPay())
            <a class="btn btn-success" href="{{ route('client.requests.pay', $request) }}">Pay Now</a>
        @endif
        @if($request->isPaid() && $request->status !== 'completed')
            <a class="btn btn-primary" href="{{ route('client.requests.confirm', $request) }}">Confirm Delivery</a>
        @endif
        <a class="btn btn-outline-secondary" href="{{ route('client.requests.index') }}">Back</a>
    </div>
</div>
@endsection
