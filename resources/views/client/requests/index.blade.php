@extends('layouts.main')
@section('title', 'Specimen Requests')
@section('content')
<div class="container py-5">
    <h1>Specimen Requests</h1>
    @include('partials.flash')
    <div class="table-responsive">
        <table class="table">
            <thead><tr><th>#</th><th>Status</th><th>Payment</th><th>Total</th><th>Date</th><th></th></tr></thead>
            <tbody>
            @forelse($requests as $request)
                <tr>
                    <td>{{ $request->request_number ?? $request->id }}</td>
                    <td>{{ ucfirst(str_replace('_',' ', $request->status)) }}</td>
                    <td>{{ ucfirst($request->payment_status) }}</td>
                    <td>${{ number_format($request->quoted_amount, 2) }}</td>
                    <td>{{ $request->created_at?->format('M d, Y') }}</td>
                    <td><a class="btn btn-sm btn-primary" href="{{ route('client.requests.show', $request) }}">View</a></td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted">No specimen requests yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $requests->links() }}
</div>
@endsection
