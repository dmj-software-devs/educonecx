@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="stat-card">
            <h3>Total Users</h3>
            <h2>{{ $totalUsers ?? 0 }}</h2>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <h3>Total Courses</h3>
            <h2>{{ $totalCourses ?? 0 }}</h2>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <h3>Total Orders</h3>
            <h2>{{ $totalOrders ?? 0 }}</h2>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <h3>Total Revenue</h3>
            <h2>${{ number_format($totalRevenue ?? 0, 2) }}</h2>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="table-container">
            <h5>Recent Users</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Joined</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentUsers ?? [] as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>{{ $user->created_at->format('M d, Y') }}</td>
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
                        <th>Customer</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOrders ?? [] as $order)
                    <tr>
                        <td>{{ $order->order_number }}</td>
                        <td>{{ $order->user->name ?? 'N/A' }}</td>
                        <td>${{ number_format($order->total, 2) }}</td>
                        <td>{{ ucfirst($order->payment_status) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection