@extends('layouts.main')

@section('title', 'Checkout - ' . $course->title)

@section('content')
<div class="checkout-container">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="checkout-form">
                    <h2>Checkout</h2>
                    
                    <div class="order-summary">
                        <h3>Order Summary</h3>
                        <div class="order-item">
                            <span>{{ $course->title }}</span>
                            <span>${{ number_format($course->current_price, 2) }}</span>
                        </div>
                        <div class="order-total">
                            <strong>Total</strong>
                            <strong>${{ number_format($course->current_price, 2) }}</strong>
                        </div>
                    </div>

                    <form action="{{ route('payment.process') }}" method="POST">
                        @csrf
                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                        
                        <div class="payment-methods">
                            <h3>Payment Method</h3>
                            
                            <div class="payment-option">
                                <input type="radio" name="payment_method" id="stripe" value="stripe" checked>
                                <label for="stripe">
                                    <i class="fab fa-cc-stripe"></i>
                                    Credit/Debit Card (Stripe)
                                </label>
                            </div>
                            
                            <div class="payment-option">
                                <input type="radio" name="payment_method" id="paypal" value="paypal">
                                <label for="paypal">
                                    <i class="fab fa-paypal"></i>
                                    PayPal
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn-pay">
                            Pay ${{ number_format($course->current_price, 2) }}
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="checkout-sidebar">
                    <div class="course-thumb">
                        <img src="{{ $course->thumbnail_url }}" alt="{{ $course->title }}">
                    </div>
                    <h4>{{ $course->title }}</h4>
                    <p>{{ Str::limit($course->excerpt, 100) }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.checkout-container {
    padding: 60px 0;
    background: #f8f9fa;
    min-height: 100vh;
}

.checkout-form {
    background: white;
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.checkout-form h2 {
    margin-bottom: 30px;
    font-weight: 700;
}

.order-summary {
    background: #f8f9fa;
    padding: 25px;
    border-radius: 15px;
    margin-bottom: 30px;
}

.order-summary h3 {
    margin-bottom: 20px;
    font-size: 1.2rem;
}

.order-item {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid #dee2e6;
}

.order-total {
    display: flex;
    justify-content: space-between;
    padding: 15px 0;
    font-size: 1.2rem;
}

.payment-methods {
    margin-bottom: 30px;
}

.payment-methods h3 {
    margin-bottom: 20px;
    font-size: 1.2rem;
}

.payment-option {
    margin-bottom: 15px;
    padding: 15px;
    border: 1px solid #dee2e6;
    border-radius: 10px;
    transition: all 0.3s;
}

.payment-option:hover {
    border-color: #667eea;
    background: rgba(102, 126, 234, 0.05);
}

.payment-option input[type="radio"] {
    margin-right: 10px;
}

.payment-option label {
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 10px;
}

.payment-option i {
    font-size: 1.5rem;
    color: #667eea;
}

.btn-pay {
    width: 100%;
    padding: 16px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
}

.btn-pay:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
}

.checkout-sidebar {
    background: white;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    position: sticky;
    top: 100px;
}

.course-thumb {
    border-radius: 15px;
    overflow: hidden;
    margin-bottom: 20px;
}

.course-thumb img {
    width: 100%;
    height: auto;
}

.checkout-sidebar h4 {
    margin-bottom: 10px;
    font-weight: 600;
}

.checkout-sidebar p {
    color: #6c757d;
    font-size: 0.95rem;
    line-height: 1.6;
}
</style>
@endsection