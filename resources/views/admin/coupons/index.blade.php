@extends('layouts.admin')

@section('title', 'Coupons')
@section('page-title', 'Coupons')

@section('content')
<div class="table-container">
    <div class="d-flex justify-content-between mb-3">
        <h5>All Coupons</h5>
        <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Add New
        </a>
    </div>
    
    <table class="table data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Code</th>
                <th>Type</th>
                <th>Value</th>
                <th>Used</th>
                <th>Valid Until</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($coupons ?? [] as $coupon)
            <tr>
                <td>{{ $coupon->id }}</td>
                <td>{{ $coupon->code }}</td>
                <td>{{ ucfirst($coupon->discount_type) }}</td>
                <td>
                    @if($coupon->discount_type == 'percentage')
                        {{ $coupon->discount_value }}%
                    @else
                        ${{ number_format($coupon->discount_value, 2) }}
                    @endif
                </td>
                <td>{{ $coupon->total_used }} / {{ $coupon->usage_limit ?? '∞' }}</td>
                <td>{{ $coupon->end_date ? $coupon->end_date->format('M d, Y') : 'Never' }}</td>
                <td>{{ ucfirst($coupon->status) }}</td>
                <td>
                    <a href="{{ route('admin.coupons.edit', $coupon) }}" class="btn btn-sm btn-info">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection