@extends('layouts.admin')

@section('title', 'User Details')
@section('page-title', 'User Details: ' . $user->name)

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="stat-card text-center">
            <div class="user-avatar" style="width: 100px; height: 100px; margin: 0 auto 15px;">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <h4>{{ $user->name }}</h4>
            <p class="text-muted">{{ $user->email }}</p>
            <p><span class="badge bg-primary">{{ ucfirst($user->role) }}</span></p>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="table-container">
            <h5>Statistics</h5>
            <div class="row">
                <div class="col-md-3">
                    <div class="stat-card">
                        <h6>Enrollments</h6>
                        <h3>{{ $stats['total_enrollments'] ?? 0 }}</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <h6>Completed</h6>
                        <h3>{{ $stats['completed_courses'] ?? 0 }}</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <h6>Orders</h6>
                        <h3>{{ $stats['total_orders'] ?? 0 }}</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <h6>Total Spent</h6>
                        <h3>${{ number_format($stats['total_spent'] ?? 0, 2) }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="table-container">
            <h5>Recent Enrollments</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>Course</th>
                        <th>Progress</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($enrollments ?? [] as $enrollment)
                    <tr>
                        <td>{{ $enrollment->course->title }}</td>
                        <td>{{ $enrollment->progress }}%</td>
                        <td>{{ ucfirst($enrollment->status) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="table-container">
            <h5>Recent Orders</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders ?? [] as $order)
                    <tr>
                        <td>{{ $order->order_number }}</td>
                        <td>${{ number_format($order->total, 2) }}</td>
                        <td>{{ ucfirst($order->payment_status) }}</td>
                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection