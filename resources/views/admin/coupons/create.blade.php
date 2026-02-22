@extends('layouts.admin')

@section('title', 'Create Coupon')
@section('page-title', 'Create Coupon')

@section('content')
<div class="form-card">
    <form action="{{ route('admin.coupons.store') }}" method="POST">
        @csrf
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Coupon Code</label>
                <input type="text" name="code" class="form-control" required>
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Discount Type</label>
                <select name="discount_type" class="form-control" required>
                    <option value="percentage">Percentage</option>
                    <option value="fixed">Fixed Amount</option>
                </select>
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Discount Value</label>
                <input type="number" name="discount_value" class="form-control" step="0.01" required>
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Min Order Amount</label>
                <input type="number" name="min_order_amount" class="form-control" step="0.01">
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Max Discount Amount</label>
                <input type="number" name="max_discount_amount" class="form-control" step="0.01">
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Usage Limit</label>
                <input type="number" name="usage_limit" class="form-control" min="1">
                <small class="text-muted">Leave empty for unlimited</small>
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Usage Per User</label>
                <input type="number" name="usage_per_user" class="form-control" value="1" min="1">
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label">Start Date</label>
                <input type="date" name="start_date" class="form-control">
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label">End Date</label>
                <input type="date" name="end_date" class="form-control">
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control" required>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            
            <div class="col-md-12 mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>
            
            <div class="col-md-12 mb-3">
                <label class="form-label">Applicable Courses</label>
                <select name="courses[]" class="form-control select2" multiple>
                    @foreach($courses ?? [] as $course)
                    <option value="{{ $course->id }}">{{ $course->title }}</option>
                    @endforeach
                </select>
                <small class="text-muted">Leave empty to apply to all courses</small>
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary">Create Coupon</button>
    </form>
</div>
@endsection