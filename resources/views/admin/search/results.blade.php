@extends('layouts.admin')

@section('title', 'Search Results')
@section('page-title', 'Search Results for "{{ $query }}"')

@section('content')
<div class="alert alert-info">
    Found {{ $totalCount }} results for "{{ $query }}"
</div>

@if($results['users']->count() > 0)
<div class="table-container">
    <h5>Users</h5>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results['users'] as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ ucfirst($user->role) }}</td>
                <td>
                    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-success">View</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

@if($results['courses']->count() > 0)
<div class="table-container">
    <h5>Courses</h5>
    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results['courses'] as $course)
            <tr>
                <td>{{ $course->title }}</td>
                <td>{{ $course->category->name ?? 'N/A' }}</td>
                <td>${{ number_format($course->price, 2) }}</td>
                <td>
                    <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-sm btn-info">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

@if($results['orders']->count() > 0)
<div class="table-container">
    <h5>Orders</h5>
    <table class="table">
        <thead>
            <tr>
                <th>Order #</th>
                <th>Customer</th>
                <th>Amount</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results['orders'] as $order)
            <tr>
                <td>{{ $order->order_number }}</td>
                <td>{{ $order->user->name ?? 'N/A' }}</td>
                <td>${{ number_format($order->total, 2) }}</td>
                <td>
                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-success">View</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

@if($results['quizzes']->count() > 0)
<div class="table-container">
    <h5>Quizzes</h5>
    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Type</th>
                <th>Questions</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results['quizzes'] as $quiz)
            <tr>
                <td>{{ $quiz->title }}</td>
                <td>{{ ucfirst($quiz->type) }}</td>
                <td>{{ $quiz->total_questions }}</td>
                <td>
                    <a href="{{ route('admin.quizzes.edit', $quiz) }}" class="btn btn-sm btn-info">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

@if($totalCount == 0)
<div class="text-center py-5">
    <i class="fas fa-search fa-4x text-muted mb-3"></i>
    <h5>No results found</h5>
    <p>Try different keywords or browse categories</p>
</div>
@endif
@endsection