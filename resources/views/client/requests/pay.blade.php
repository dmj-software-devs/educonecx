@extends('layouts.main')
@section('title', 'Pay for Specimen Delivery')
@section('content')
<div class="container py-5">
    @include('partials.flash')
    <h1>Pay for Specimen Delivery</h1>
    <div class="card p-4 mb-4">
        <p><strong>Request:</strong> #{{ $request->request_number ?? $request->id }}</p>
        <p><strong>Status:</strong> {{ ucfirst(str_replace('_',' ', $request->status)) }}</p>
        <p><strong>Amount Due:</strong> ${{ number_format($request->quoted_amount, 2) }}</p>
        <p class="text-muted">Payment is required before delivery confirmation.</p>
    </div>
    <form method="POST" action="{{ route('client.requests.checkout', $request) }}">
        @csrf
        <button class="btn btn-success" type="submit">Continue to Secure Stripe Checkout</button>
        <a class="btn btn-outline-secondary" href="{{ route('client.requests.show', $request) }}">Cancel</a>
    </form>
</div>
@endsection
