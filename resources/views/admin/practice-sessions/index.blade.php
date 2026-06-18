@extends('layouts.admin')
@section('title', 'Practice Session Management')
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
<style>
.practice-admin{background:#f6f8fb;min-height:calc(100vh - 80px);padding:8px 0 32px}.practice-admin-hero{background:linear-gradient(135deg,#0A1D44,#18386E 62%,#2E5C61);border-radius:24px;color:#fff;padding:28px;margin-bottom:24px;box-shadow:0 18px 42px rgba(10,29,68,.18)}.practice-admin-hero h1{font-weight:900;margin:0}.practice-admin-filter{background:#fff;border:1px solid rgba(10,29,68,.08);border-radius:18px;padding:16px;box-shadow:0 10px 28px rgba(10,29,68,.07);margin-bottom:22px}.metric-card{background:#fff;border:1px solid rgba(10,29,68,.08);border-radius:20px;padding:20px;height:100%;box-shadow:0 10px 28px rgba(10,29,68,.07)}.metric-card span{color:#6b7280;font-size:.82rem;font-weight:800;text-transform:uppercase;letter-spacing:.06em}.metric-card strong{display:block;color:#0A1D44;font-size:2rem;line-height:1.1;margin-top:8px}.dashboard-card{background:#fff;border:1px solid rgba(10,29,68,.08);border-radius:20px;box-shadow:0 10px 28px rgba(10,29,68,.07);overflow:hidden}.dashboard-card-header{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:18px 20px;border-bottom:1px solid rgba(10,29,68,.08);background:linear-gradient(180deg,#fff,#f9fafb)}.dashboard-card-header h3{font-size:1.05rem;font-weight:900;color:#0A1D44;margin:0}.dashboard-card-body{padding:20px}.badge-soft{border-radius:999px;padding:.45rem .7rem;font-weight:800}.badge-practice{background:#e8f2ff;color:#1d4ed8}.badge-exam{background:#fff4cf;color:#a16207}.badge-success-soft{background:#dcfce7;color:#166534}.table-responsive{border-radius:14px}.dataTables_wrapper .row{gap:8px 0}@media(max-width:768px){.practice-admin-hero{padding:22px}.metric-card strong{font-size:1.55rem}.dashboard-card-body{padding:14px}}
</style>
@endpush
@section('content')
<div class="practice-admin">
<div class="container-fluid">
    <div class="practice-admin-hero">
        <p class="mb-1 text-uppercase fw-bold opacity-75">SaaS Admin Dashboard</p>
        <h1>Practice Session Management</h1>
        <p class="mb-0 opacity-75">Monitor purchases, usage, session balances, and recent learner activity.</p>
    </div>

    <form method="GET" class="practice-admin-filter row g-3 align-items-end">
        <div class="col-lg-4"><label class="form-label fw-bold">Quick filters</label><div class="d-flex flex-wrap gap-2"><a class="btn btn-outline-primary" href="?range=today">Today</a><a class="btn btn-outline-primary" href="?range=week">Week</a><a class="btn btn-outline-primary" href="?range=month">Month</a></div></div>
        <div class="col-lg-5"><label class="form-label fw-bold" for="userSearch">User Search</label><input id="userSearch" name="user" value="{{ request('user') }}" class="form-control" placeholder="Search by name or email"></div>
        <div class="col-lg-3"><button class="btn btn-primary w-100">Apply Filters</button></div>
    </form>

    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl"><div class="metric-card"><span>Total Minutes Used</span><strong>{{ $stats['total_minutes_used'] }}</strong></div></div>
        <div class="col-sm-6 col-xl"><div class="metric-card"><span>Purchased Minutes</span><strong>{{ $stats['total_purchased_minutes'] }}</strong></div></div>
        <div class="col-sm-6 col-xl"><div class="metric-card"><span>Monthly Usage</span><strong>{{ $stats['monthly_usage'] }}</strong></div></div>
        <div class="col-sm-6 col-xl"><div class="metric-card"><span>Practice Sessions</span><strong>{{ $stats['practice_usage'] }}</strong></div></div>
        <div class="col-sm-6 col-xl"><div class="metric-card"><span>Exam Sessions</span><strong>{{ $stats['exam_usage'] }}</strong></div></div>
    </div>

    <div class="dashboard-card mb-4"><div class="dashboard-card-header"><h3>Adjust User Practice Time</h3><span class="badge badge-soft badge-success-soft">Admin action</span></div><div class="dashboard-card-body">
        <form method="POST" action="{{ route('admin.practice-sessions.adjust') }}" class="row g-3">@csrf
            <div class="col-lg-4"><select name="user_id" class="form-control" required>@foreach($users as $user)<option value="{{ $user->id }}">{{ $user->name }} — {{ $user->email }}</option>@endforeach</select></div>
            <div class="col-md-2"><select name="action" class="form-control"><option value="add">Add minutes</option><option value="remove">Remove minutes</option></select></div>
            <div class="col-md-2"><input name="minutes" type="number" min="1" class="form-control" placeholder="Minutes" required></div>
            <div class="col-md-3"><input name="reason" class="form-control" placeholder="Reason"></div>
            <div class="col-md-1"><button class="btn btn-primary w-100">Save</button></div>
        </form>
    </div></div>

    <div class="row g-4 mb-4">
        <div class="col-xl-8"><div class="dashboard-card"><div class="dashboard-card-header"><h3>User Balances</h3><span class="badge badge-soft badge-practice">Session Balance</span></div><div class="dashboard-card-body"><div class="table-responsive"><table id="balancesTable" class="table table-hover align-middle"><thead><tr><th>User</th><th>Monthly Allocated</th><th>Monthly Used</th><th>Purchased</th><th>Available</th><th>Reset Date</th></tr></thead><tbody>@foreach($balances as $balance)<tr><td><strong>{{ $balance->user?->name }}</strong><br><small class="text-muted">{{ $balance->user?->email }}</small></td><td>{{ $balance->monthly_minutes_allocated }}</td><td>{{ $balance->monthly_minutes_used }}</td><td>{{ $balance->purchased_minutes }}</td><td><span class="badge badge-soft badge-success-soft">{{ $balance->total_available_minutes }} min</span></td><td>{{ optional($balance->monthly_reset_date)->format('M d, Y') }}</td></tr>@endforeach</tbody></table></div>{{ $balances->links() }}</div></div></div>
        <div class="col-xl-4"><div class="dashboard-card h-100"><div class="dashboard-card-header"><h3>Top Users</h3></div><div class="dashboard-card-body">@forelse($topUsers as $row)<div class="d-flex justify-content-between border-bottom py-2"><span>{{ $row->user?->name }}</span><strong>{{ $row->total_minutes }} min</strong></div>@empty<p class="text-muted mb-0">No usage yet.</p>@endforelse</div></div></div>
    </div>

    <div class="row g-4">
        <div class="col-xl-6"><div class="dashboard-card"><div class="dashboard-card-header"><h3>Session Purchases</h3></div><div class="dashboard-card-body"><div class="table-responsive"><table id="purchasesTable" class="table table-hover align-middle"><thead><tr><th>User</th><th>Total</th><th>Details</th></tr></thead><tbody>@foreach($recentPurchases as $order)<tr><td>{{ $order->user?->name }}</td><td><span class="badge badge-soft badge-success-soft">${{ number_format((float) $order->total, 2) }}</span></td><td>{{ $order->notes ?: 'Practice session purchase' }}</td></tr>@endforeach</tbody></table></div></div></div></div>
        <div class="col-xl-6"><div class="dashboard-card"><div class="dashboard-card-header"><h3>Usage Logs & Recent Activity</h3></div><div class="dashboard-card-body"><div class="table-responsive"><table id="usageTable" class="table table-hover align-middle"><thead><tr><th>User</th><th>Mode</th><th>Minutes</th><th>Source</th><th>When</th></tr></thead><tbody>@foreach($recentUsage as $log)<tr><td>{{ $log->user?->name }}</td><td><span class="badge badge-soft {{ $log->session_type === 'exam' ? 'badge-exam' : 'badge-practice' }}">{{ ucfirst($log->session_type) }}</span></td><td>{{ $log->minutes_used }}</td><td>{{ $log->source }}</td><td>{{ optional($log->created_at)->format('M d, Y g:i A') }}</td></tr>@endforeach</tbody></table></div></div></div></div>
    </div>
</div>
</div>
@endsection
@push('scripts')
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<script>document.addEventListener('DOMContentLoaded',()=>{['#balancesTable','#purchasesTable','#usageTable'].forEach(id=>{if(window.jQuery&&jQuery.fn.DataTable){jQuery(id).DataTable({responsive:true,pageLength:10,order:[]});}});});</script>
@endpush
