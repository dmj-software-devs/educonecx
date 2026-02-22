@extends('layouts.admin')

@section('title', 'Backup')
@section('page-title', 'Backup')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="form-card text-center">
            <i class="fas fa-database fa-4x mb-3 text-primary"></i>
            <h5>Create Database Backup</h5>
            <p>Create a backup of your database to protect your data.</p>
            <form action="{{ route('admin.backup.create') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-download"></i> Create Backup Now
                </button>
            </form>
        </div>
    </div>
</div>

<div class="table-container mt-4">
    <h5>Existing Backups</h5>
    <table class="table">
        <thead>
            <tr>
                <th>File Name</th>
                <th>Size</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($backups as $backup)
            <tr>
                <td>{{ $backup['name'] }}</td>
                <td>{{ $backup['size'] }}</td>
                <td>{{ $backup['date'] }}</td>
                <td>
                    <a href="{{ route('admin.backup.download', $backup['name']) }}" class="btn btn-sm btn-success">
                        <i class="fas fa-download"></i>
                    </a>
                    <form action="{{ route('admin.backup.destroy', $backup['name']) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this backup?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">No backups found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection