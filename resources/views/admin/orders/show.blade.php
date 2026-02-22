@extends('layouts.admin')

@section('title', 'Order Details')
@section('page-title', 'Order Details: ' . $order->order_number)

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="form-card">
            <h5>Order Information</h5>
            <table class="table">
                <tr>
                    <th>Order Number:</th>
                    <td>{{ $order->order_number }}</td>
                </tr>
                <tr>
                    <th>Date:</th>
                    <td>{{ $order->created_at->format('F d, Y h:i A') }}</td>
                </tr>
                <tr>
                    <th>Payment Method:</th>
                    <td>{{ ucfirst($order->payment_method) }}</td>
                </tr>
                <tr>
                    <th>Payment Status:</th>
                    <td>{{ ucfirst($order->payment_status) }}</td>
                </tr>
                <tr>
                    <th>Transaction ID:</th>
                    <td>{{ $order->transaction_id ?? 'N/A' }}</td>
                </tr>
            </table>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="form-card">
            <h5>Billing Information</h5>
            <table class="table">
                <tr>
                    <th>Name:</th>
                    <td>{{ $order->billing_name }}</td>
                </tr>
                <tr>
                    <th>Email:</th>
                    <td>{{ $order->billing_email }}</td>
                </tr>
                <tr>
                    <th>Phone:</th>
                    <td>{{ $order->billing_phone ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Address:</th>
                    <td>{{ $order->billing_address ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>City/State:</th>
                    <td>{{ $order->billing_city ?? '' }} {{ $order->billing_state ?? '' }}</td>
                </tr>
                <tr>
                    <th>Country:</th>
                    <td>{{ $order->billing_country ?? 'N/A' }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="table-container">
            <h5>Order Items</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>Course</th>
                        <th>Price</th>
                        <th>Discount</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->course_title }}</td>
                        <td>${{ number_format($item->price, 2) }}</td>
                        <td>${{ number_format($item->discount_amount, 2) }}</td>
                        <td>${{ number_format($item->total, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Subtotal:</th>
                        <td>${{ number_format($order->subtotal, 2) }}</td>
                    </tr>
                    <tr>
                        <th colspan="3" class="text-end">Discount:</th>
                        <td>${{ number_format($order->discount_amount, 2) }}</td>
                    </tr>
                    <tr>
                        <th colspan="3" class="text-end">Total:</th>
                        <td><strong>${{ number_format($order->total, 2) }}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

@if($order->payment_status == 'paid')
<div class="row mt-4">
    <div class="col-md-12">
        <form action="{{ route('admin.orders.refund', $order) }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-warning" onclick="return confirm('Process refund for this order?')">
                <i class="fas fa-undo"></i> Process Refund
            </button>
        </form>
    </div>
</div>
@endif
@endsection