@extends('layouts.admin')
@section('title', 'Practice Session Management')
@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Practice Session Management</h1>
    <div class="row g-3 mb-4">
        <div class="col-md-2"><div class="card p-3"><span>Total Practice Minutes Used</span><strong>{{ $stats['total_minutes_used'] }}</strong></div></div>
        <div class="col-md-2"><div class="card p-3"><span>Total Purchased Minutes</span><strong>{{ $stats['total_purchased_minutes'] }}</strong></div></div>
        <div class="col-md-2"><div class="card p-3"><span>Monthly Usage</span><strong>{{ $stats['monthly_usage'] }}</strong></div></div>
        <div class="col-md-3"><div class="card p-3"><span>Practice vs Exam Usage</span><strong>{{ $stats['practice_usage'] }} / {{ $stats['exam_usage'] }}</strong></div></div>
    </div>

    <div class="card mb-4"><div class="card-body">
        <h3>Adjust User Practice Time</h3>
        <form method="POST" action="{{ route('admin.practice-sessions.adjust') }}" class="row g-2">@csrf
            <div class="col-md-4"><select name="user_id" class="form-control" required>@foreach($users as $user)<option value="{{ $user->id }}">{{ $user->name }} — {{ $user->email }}</option>@endforeach</select></div>
            <div class="col-md-2"><select name="action" class="form-control"><option value="add">Add minutes</option><option value="remove">Remove minutes</option></select></div>
            <div class="col-md-2"><input name="minutes" type="number" min="1" class="form-control" placeholder="Minutes" required></div>
            <div class="col-md-3"><input name="reason" class="form-control" placeholder="Reason"></div>
            <div class="col-md-1"><button class="btn btn-primary">Save</button></div>
        </form>
    </div></div>

    <div class="card mb-4"><div class="card-body"><h3>User Balances</h3>
        <table class="table"><thead><tr><th>User</th><th>Monthly Allocated</th><th>Monthly Used</th><th>Purchased</th><th>Available</th><th>Reset Date</th></tr></thead><tbody>
        @foreach($balances as $balance)<tr><td>{{ $balance->user?->name }}<br><small>{{ $balance->user?->email }}</small></td><td>{{ $balance->monthly_minutes_allocated }}</td><td>{{ $balance->monthly_minutes_used }}</td><td>{{ $balance->purchased_minutes }}</td><td>{{ $balance->total_available_minutes }}</td><td>{{ optional($balance->monthly_reset_date)->format('M d, Y') }}</td></tr>@endforeach
        </tbody></table>{{ $balances->links() }}
    </div></div>

    <div class="row g-4"><div class="col-md-4"><div class="card"><div class="card-body"><h3>Top Users</h3><ul>@foreach($topUsers as $row)<li>{{ $row->user?->name }} — {{ $row->total_minutes }} minutes</li>@endforeach</ul></div></div></div>
    <div class="col-md-4"><div class="card"><div class="card-body"><h3>Purchased Sessions</h3><table class="table"><thead><tr><th>User</th><th>Total</th><th>Details</th></tr></thead><tbody>@foreach($recentPurchases as $order)<tr><td>{{ $order->user?->name }}</td><td>${{ number_format((float) $order->total, 2) }}</td><td>{{ $order->notes ?: 'Practice session purchase' }}</td></tr>@endforeach</tbody></table></div></div></div>
    <div class="col-md-4"><div class="card"><div class="card-body"><h3>Usage History</h3><table class="table"><thead><tr><th>User</th><th>Type</th><th>Minutes</th><th>Source</th><th>When</th></tr></thead><tbody>@foreach($recentUsage as $log)<tr><td>{{ $log->user?->name }}</td><td>{{ ucfirst($log->session_type) }}</td><td>{{ $log->minutes_used }}</td><td>{{ $log->source }}</td><td>{{ optional($log->created_at)->format('M d, Y g:i A') }}</td></tr>@endforeach</tbody></table></div></div></div></div>
</div>
@endsection
