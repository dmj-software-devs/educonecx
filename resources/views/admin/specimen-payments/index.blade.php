@extends('layouts.admin')
@section('title', 'Specimen Payments')
@section('page-title', 'Specimen Payments')
@section('content')
<div class="table-container">
    <form class="mb-3" method="GET">
        <input name="search" value="{{ request('search') }}" placeholder="Search order, request, customer" class="form-control" style="max-width:360px;display:inline-block">
        <select name="status" class="form-control" style="max-width:160px;display:inline-block">
            @foreach(['all','pending','paid','failed','refunded'] as $status)
                <option value="{{ $status }}" @selected(request('status','all')===$status)>{{ ucfirst($status) }}</option>
            @endforeach
        </select>
        <button class="btn btn-primary">Filter</button>
    </form>
    <table class="table data-table">
        <thead><tr><th>Order</th><th>Request</th><th>Client</th><th>Total</th><th>Status</th><th>Date</th><th></th></tr></thead>
        <tbody>
        @forelse($payments as $payment)
            <tr>
                <td>{{ $payment->order_number }}</td>
                <td>{{ $payment->specimenRequest?->request_number ?? $payment->specimen_request_id }}</td>
                <td>{{ $payment->user?->name ?? $payment->user?->email ?? 'N/A' }}</td>
                <td>${{ number_format($payment->total, 2) }}</td>
                <td>{{ ucfirst($payment->payment_status) }}</td>
                <td>{{ $payment->created_at?->format('M d, Y') }}</td>
                <td><a class="btn btn-sm btn-success" href="{{ route('admin.specimen-payments.show', $payment) }}"><i class="fas fa-eye"></i></a></td>
            </tr>
        @empty
            <tr><td colspan="7" class="text-center">No specimen delivery payments found.</td></tr>
        @endforelse
        </tbody>
    </table>
    {{ $payments->links() }}
</div>
@endsection
