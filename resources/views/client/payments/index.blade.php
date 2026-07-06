@extends('layouts.main')
@section('title', 'My Delivery Payments')
@section('content')
<div class="container py-5">
    <h1>My Delivery Payments</h1>
    @include('partials.flash')
    <div class="table-responsive">
        <table class="table">
            <thead><tr><th>Order</th><th>Request</th><th>Amount</th><th>Status</th><th>Transaction</th><th>Date</th></tr></thead>
            <tbody>
            @forelse($payments as $payment)
                <tr>
                    <td>{{ $payment->order_number }}</td>
                    <td>{{ $payment->specimenRequest?->request_number ?? $payment->specimen_request_id }}</td>
                    <td>${{ number_format($payment->total, 2) }}</td>
                    <td>{{ ucfirst($payment->payment_status) }}</td>
                    <td>{{ $payment->transaction_id ?: 'N/A' }}</td>
                    <td>{{ $payment->created_at?->format('M d, Y') }}</td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted">No payments yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $payments->links() }}
</div>
@endsection
