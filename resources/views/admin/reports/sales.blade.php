@extends('layouts.admin')

@section('title', 'Sales Report')
@section('page-title', 'Sales Report')

@section('content')
<div class="form-card mb-4">
    <form method="GET" class="row">
        <div class="col-md-4">
            <label>Start Date</label>
            <input type="date" name="start_date" class="form-control" value="{{ $startDate->format('Y-m-d') }}">
        </div>
        <div class="col-md-4">
            <label>End Date</label>
            <input type="date" name="end_date" class="form-control" value="{{ $endDate->format('Y-m-d') }}">
        </div>
        <div class="col-md-4">
            <label>&nbsp;</label>
            <button type="submit" class="btn btn-primary form-control">Apply Filter</button>
        </div>
    </form>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="stat-card">
            <h6>Total Revenue</h6>
            <h3>${{ number_format($totalRevenue, 2) }}</h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <h6>Total Orders</h6>
            <h3>{{ $totalOrders }}</h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <h6>Average Order Value</h6>
            <h3>${{ number_format($averageOrderValue, 2) }}</h3>
        </div>
    </div>
</div>

<div class="table-container mt-4">
    <h5>Daily Sales</h5>
    <table class="table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Orders</th>
                <th>Revenue</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dailySales as $sale)
            <tr>
                <td>{{ $sale->date }}</td>
                <td>{{ $sale->count }}</td>
                <td>${{ number_format($sale->total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="table-container mt-4">
    <h5>Top Selling Courses</h5>
    <table class="table">
        <thead>
            <tr>
                <th>Course</th>
                <th>Sales</th>
                <th>Revenue</th>
            </tr>
        </thead>
        <tbody>
            @foreach($topCourses as $course)
            <tr>
                <td>{{ $course->title }}</td>
                <td>{{ $course->total_sales }}</td>
                <td>${{ number_format($course->total_revenue, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection