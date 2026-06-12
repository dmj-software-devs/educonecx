@extends('layouts.admin')

@section('title', 'Practice Credits')
@section('page-title', 'Practice Credits')

@section('content')
<div class="table-container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5>Practice Credit Management</h5>
        <form method="GET" action="{{ route('admin.practice-credits.index') }}" class="d-flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Search name or email">
            <button class="btn btn-primary btn-sm" type="submit"><i class="fas fa-search"></i> Search</button>
        </form>
    </div>

    <table class="table data-table">
        <thead>
            <tr>
                <th>User</th>
                <th>Email</th>
                <th>Balance</th>
                <th>Granted</th>
                <th>Purchased</th>
                <th>Used</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                @php($wallet = $user->practiceCredits)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $wallet->balance ?? 0 }}</td>
                    <td>{{ $wallet->lifetime_granted ?? 0 }}</td>
                    <td>{{ $wallet->lifetime_purchased ?? 0 }}</td>
                    <td>{{ $wallet->lifetime_used ?? 0 }}</td>
                    <td>
                        <a href="{{ route('admin.practice-credits.show', $user) }}" class="btn btn-sm btn-success"><i class="fas fa-coins"></i> Manage</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $users->links() }}
</div>
@endsection
