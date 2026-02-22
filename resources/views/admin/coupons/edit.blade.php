@extends('layouts.admin')

@section('title', 'Edit Coupon')
@section('page-title', 'Edit Coupon')

@section('content')
<div class="form-card">
    <form action="{{ route('admin.coupons.update', $coupon) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Coupon Code</label>
                <input type="text" name="code" class="form-control" value="{{ $coupon->code }}" required>
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Discount Type</label>
                <select name="discount_type" class="form-control" required>
                    <option value="percentage" {{ $coupon->discount_type == 'percentage' ? 'selected' : '' }}>Percentage</option>
                    <option value="fixed" {{ $coupon->discount_type == 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                </select>
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Discount Value</label>
                <input type="number" name="discount_value" class="form-control" step="0.01" value="{{ $coupon->discount_value }}" required>
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Min Order Amount</label>
                <input type="number" name="min_order_amount" class="form-control" step="0.01" value="{{ $coupon->min_order_amount }}">
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Max Discount Amount</label>
                <input type="number" name="max_discount_amount" class="form-control" step="0.01" value="{{ $coupon->max_discount_amount }}">
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Usage Limit</label>
                <input type="number" name="usage_limit" class="form-control" value="{{ $coupon->usage_limit }}" min="1">
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Usage Per User</label>
                <input type="number" name="usage_per_user" class="form-control" value="{{ $coupon->usage_per_user }}" min="1">
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label">Start Date</label>
                <input type="date" name="start_date" class="form-control" value="{{ $coupon->start_date ? $coupon->start_date->format('Y-m-d') : '' }}">
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label">End Date</label>
                <input type="date" name="end_date" class="form-control" value="{{ $coupon->end_date ? $coupon->end_date->format('Y-m-d') : '' }}">
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control" required>
                    <option value="active" {{ $coupon->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $coupon->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            
            <div class="col-md-12 mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ $coupon->description }}</textarea>
            </div>
            
            <div class="col-md-12 mb-3">
                <label class="form-label">Applicable Courses</label>
                <select name="courses[]" class="form-control select2" multiple>
                    @foreach($courses ?? [] as $course)
                    <option value="{{ $course->id }}" {{ $coupon->courses->contains($course->id) ? 'selected' : '' }}>
                        {{ $course->title }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary">Update Coupon</button>
    </form>
</div>
@endsection