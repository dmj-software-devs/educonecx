@extends('layouts.admin')

@section('title', 'Practice Credits - ' . $user->name)
@section('page-title', 'Practice Credits')

@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="row g-3 mb-4">
    <div class="col-md-3"><div class="card p-3"><span>Current Balance</span><h3>{{ $wallet->balance }}</h3></div></div>
    <div class="col-md-3"><div class="card p-3"><span>Lifetime Granted</span><h3>{{ $wallet->lifetime_granted }}</h3></div></div>
    <div class="col-md-3"><div class="card p-3"><span>Lifetime Purchased</span><h3>{{ $wallet->lifetime_purchased }}</h3></div></div>
    <div class="col-md-3"><div class="card p-3"><span>Lifetime Used</span><h3>{{ $wallet->lifetime_used }}</h3></div></div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="table-container">
            <h5>Add Credits for {{ $user->name }}</h5>
            <form method="POST" action="{{ route('admin.practice-credits.add', $user) }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Amount</label>
                    <input type="number" name="amount" min="1" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Optional admin note"></textarea>
                </div>
                <button class="btn btn-success" type="submit"><i class="fas fa-plus"></i> Add Credits</button>
            </form>
        </div>
    </div>
    <div class="col-md-6">
        <div class="table-container">
            <h5>Subtract Credits</h5>
            <form method="POST" action="{{ route('admin.practice-credits.subtract', $user) }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Amount</label>
                    <input type="number" name="amount" min="1" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Optional admin note"></textarea>
                </div>
                <button class="btn btn-danger" type="submit"><i class="fas fa-minus"></i> Subtract Credits</button>
            </form>
        </div>
    </div>
</div>

<div class="table-container">
    <div class="d-flex justify-content-between mb-3">
        <h5>Credit Transactions</h5>
        <a href="{{ route('admin.practice-credits.index') }}" class="btn btn-secondary btn-sm">Back</a>
    </div>
    <table class="table data-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Type</th>
                <th>Amount</th>
                <th>Before</th>
                <th>After</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $transaction)
                <tr>
                    <td>{{ optional($transaction->created_at)->format('M d, Y g:i A') }}</td>
                    <td>{{ Str::headline($transaction->type) }}</td>
                    <td class="{{ $transaction->amount >= 0 ? 'text-success' : 'text-danger' }}">{{ $transaction->amount >= 0 ? '+' : '' }}{{ $transaction->amount }}</td>
                    <td>{{ $transaction->balance_before }}</td>
                    <td>{{ $transaction->balance_after }}</td>
                    <td>{{ $transaction->description ?: '—' }}</td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-muted">No transactions found.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $transactions->links() }}
</div>
@endsection
