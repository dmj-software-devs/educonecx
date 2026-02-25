@extends('layouts.main')

@section('title', 'Checkout - ' . $course->title)

@section('content')
<div class="checkout-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <!-- Simple Header -->
                <div class="checkout-header text-center mb-3">
                    <h4 class="checkout-title">Complete Your Purchase</h4>
                    <p class="checkout-subtitle">Secure checkout</p>
                </div>

                <!-- Compact Checkout Card -->
                <div class="checkout-card">
                    <!-- Course Info Strip -->
                    <div class="course-strip">
                        <div class="course-strip-image">
                            <img src="{{ $course->thumbnail_url ?? 'https://via.placeholder.com/100x100' }}" alt="{{ $course->title }}">
                            @if(($course->sale_price ?? 0) > 0 && $course->sale_price < $course->price)
                                <span class="course-strip-badge">-{{ round((1 - $course->sale_price/$course->price) * 100) }}%</span>
                            @endif
                        </div>
                        <div class="course-strip-info">
                            <div class="course-strip-category">{{ $course->category->name ?? 'Course' }}</div>
                            <h5 class="course-strip-title">{{ Str::limit($course->title, 40) }}</h5>
                            <div class="course-strip-price">
                                @if(($course->sale_price ?? 0) > 0 && $course->sale_price < $course->price)
                                    <span class="current-price">${{ number_format($course->sale_price, 2) }}</span>
                                    <span class="original-price">${{ number_format($course->price, 2) }}</span>
                                @else
                                    <span class="current-price">${{ number_format($course->price, 2) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Payment Form -->
                    <div class="payment-form">
                        <form action="{{ route('payment.process') }}" method="POST" id="paymentForm">
                            @csrf
                            <input type="hidden" name="course_id" value="{{ $course->id }}">
                            
                            <!-- Order Summary -->
                            <div class="order-summary">
                                <div class="summary-row">
                                    <span>Subtotal:</span>
                                    <span>${{ number_format($course->price, 2) }}</span>
                                </div>
                                @if(($course->sale_price ?? 0) > 0 && $course->sale_price < $course->price)
                                <div class="summary-row discount">
                                    <span>Discount:</span>
                                    <span>-${{ number_format($course->price - $course->sale_price, 2) }}</span>
                                </div>
                                @endif
                                <div class="summary-total">
                                    <span><strong>Total:</strong></span>
                                    <span class="total-amount">${{ number_format($course->current_price ?? $course->price, 2) }}</span>
                                </div>
                            </div>

                            <!-- Payment Methods -->
                            <div class="payment-methods">
                                <label class="payment-option">
                                    <input type="radio" name="payment_method" value="stripe" checked>
                                    <span class="payment-option-content">
                                        <span class="payment-icon">
                                            <i class="fab fa-cc-stripe"></i>
                                        </span>
                                        <span class="payment-details">
                                            <span class="payment-name">Credit/Debit Card</span>
                                            <span class="payment-desc">Pay with Stripe</span>
                                        </span>
                                        <span class="payment-check"></span>
                                    </span>
                                </label>

                                <label class="payment-option">
                                    <input type="radio" name="payment_method" value="paypal">
                                    <span class="payment-option-content">
                                        <span class="payment-icon">
                                            <i class="fab fa-paypal"></i>
                                        </span>
                                        <span class="payment-details">
                                            <span class="payment-name">PayPal</span>
                                            <span class="payment-desc">Fast & secure payment</span>
                                        </span>
                                        <span class="payment-check"></span>
                                    </span>
                                </label>
                            </div>

                            <!-- Pay Button -->
                            <button type="submit" class="btn-pay" id="payButton">
                                <span class="btn-text">Pay ${{ number_format($course->current_price ?? $course->price, 2) }}</span>
                                <span class="btn-loader" style="display: none;">
                                    <i class="fas fa-spinner fa-spin"></i> Processing...
                                </span>
                            </button>

                            <!-- Security Badges -->
                            <div class="security-badges">
                                <div class="security-item">
                                    <i class="fas fa-lock"></i>
                                    <span>Secure SSL</span>
                                </div>
                                <div class="security-item">
                                    <i class="fas fa-shield-alt"></i>
                                    <span>Encrypted</span>
                                </div>
                                <div class="security-item">
                                    <i class="fas fa-undo-alt"></i>
                                    <span>30-day refund</span>
                                </div>
                            </div>

                            <!-- Cancel Link -->
                            <a href="{{ route('courses.show', $course->slug) }}" class="btn-cancel">
                                Cancel and go back
                            </a>
                        </form>
                    </div>
                </div>

                <!-- Trust Badges (Small) -->
                <div class="trust-badges text-center mt-3">
                    <span class="trust-text">We accept:</span>
                    <div class="trust-icons">
                        <i class="fab fa-cc-visa"></i>
                        <i class="fab fa-cc-mastercard"></i>
                        <i class="fab fa-cc-amex"></i>
                        <i class="fab fa-cc-paypal"></i>
                        <i class="fab fa-cc-stripe"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Compact Checkout Page */
.checkout-page {
    min-height: 100vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 20px 0;
    display: flex;
    align-items: center;
    position: relative;
}

.checkout-page::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('/images/pattern.png') repeat;
    opacity: 0.1;
}

.checkout-header {
    position: relative;
    z-index: 1;
}

.checkout-title {
    font-size: 1.4rem;
    font-weight: 700;
    color: white;
    margin-bottom: 5px;
}

.checkout-subtitle {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.9);
}

/* Compact Card */
.checkout-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
    position: relative;
    z-index: 2;
    max-width: 400px;
    margin: 0 auto;
}

/* Course Strip */
.course-strip {
    display: flex;
    gap: 12px;
    padding: 16px;
    background: linear-gradient(145deg, #f8f9fa, #ffffff);
    border-bottom: 1px solid #e9ecef;
}

.course-strip-image {
    position: relative;
    width: 70px;
    height: 70px;
    flex-shrink: 0;
}

.course-strip-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 12px;
}

.course-strip-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background: linear-gradient(135deg, #f72585, #b5179e);
    color: white;
    font-size: 0.65rem;
    font-weight: 600;
    padding: 3px 6px;
    border-radius: 20px;
    border: 2px solid white;
}

.course-strip-info {
    flex: 1;
    min-width: 0;
}

.course-strip-category {
    font-size: 0.7rem;
    color: #667eea;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 600;
    margin-bottom: 3px;
}

.course-strip-title {
    font-size: 0.95rem;
    font-weight: 600;
    color: #1e1e2f;
    margin-bottom: 5px;
    line-height: 1.3;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.course-strip-price {
    display: flex;
    align-items: center;
    gap: 6px;
}

.course-strip-price .current-price {
    font-size: 1.1rem;
    font-weight: 700;
    color: #667eea;
}

.course-strip-price .original-price {
    font-size: 0.8rem;
    color: #6c757d;
    text-decoration: line-through;
}

/* Payment Form */
.payment-form {
    padding: 20px;
}

/* Order Summary */
.order-summary {
    background: #f8f9fa;
    border-radius: 16px;
    padding: 15px;
    margin-bottom: 20px;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 8px;
    font-size: 0.9rem;
    color: #6c757d;
}

.summary-row.discount {
    color: #06d6a0;
}

.summary-total {
    display: flex;
    justify-content: space-between;
    padding-top: 8px;
    margin-top: 8px;
    border-top: 2px dashed #dee2e6;
    font-size: 1rem;
    color: #1e1e2f;
}

.total-amount {
    font-weight: 700;
    color: #667eea;
    font-size: 1.2rem;
}

/* Payment Methods */
.payment-methods {
    margin-bottom: 20px;
}

.payment-option {
    display: block;
    margin-bottom: 10px;
    cursor: pointer;
}

.payment-option input[type="radio"] {
    display: none;
}

.payment-option-content {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    border: 2px solid #e9ecef;
    border-radius: 14px;
    transition: all 0.2s ease;
    position: relative;
}

.payment-option input[type="radio"]:checked + .payment-option-content {
    border-color: #667eea;
    background: rgba(102, 126, 234, 0.05);
}

.payment-icon {
    width: 40px;
    height: 40px;
    background: white;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    color: #667eea;
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.05);
}

.payment-details {
    flex: 1;
}

.payment-name {
    display: block;
    font-weight: 600;
    color: #1e1e2f;
    font-size: 0.9rem;
    margin-bottom: 2px;
}

.payment-desc {
    display: block;
    font-size: 0.75rem;
    color: #6c757d;
}

.payment-check {
    width: 20px;
    height: 20px;
    border: 2px solid #e9ecef;
    border-radius: 50%;
    transition: all 0.2s ease;
}

.payment-option input[type="radio"]:checked + .payment-option-content .payment-check {
    border-color: #667eea;
    background: #667eea;
    box-shadow: inset 0 0 0 4px white;
}

/* Pay Button */
.btn-pay {
    width: 100%;
    padding: 14px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border: none;
    border-radius: 14px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    margin-bottom: 15px;
    position: relative;
    overflow: hidden;
}

.btn-pay:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
}

.btn-pay:active {
    transform: translateY(0);
}

.btn-pay:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none;
}

/* Security Badges */
.security-badges {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-bottom: 15px;
}

.security-item {
    display: flex;
    align-items: center;
    gap: 4px;
    color: #6c757d;
    font-size: 0.75rem;
}

.security-item i {
    color: #06d6a0;
    font-size: 0.8rem;
}

/* Cancel Button */
.btn-cancel {
    display: block;
    text-align: center;
    color: #6c757d;
    text-decoration: none;
    font-size: 0.85rem;
    padding: 8px;
    border-radius: 20px;
    transition: all 0.2s ease;
}

.btn-cancel:hover {
    color: #f72585;
    background: rgba(247, 37, 133, 0.05);
}

/* Trust Badges */
.trust-badges {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    color: white;
}

.trust-text {
    font-size: 0.8rem;
    opacity: 0.9;
}

.trust-icons {
    display: flex;
    gap: 8px;
}

.trust-icons i {
    font-size: 1.2rem;
    color: white;
    opacity: 0.8;
    transition: all 0.2s ease;
}

.trust-icons i:hover {
    opacity: 1;
    transform: scale(1.1);
}

/* Loading State */
.btn-loader {
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

/* Animations */
@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(15px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.checkout-card {
    animation: slideUp 0.3s ease;
}

/* Responsive */
@media (max-width: 576px) {
    .checkout-page {
        padding: 15px 0;
    }
    
    .checkout-title {
        font-size: 1.3rem;
    }
    
    .course-strip {
        padding: 12px;
    }
    
    .course-strip-image {
        width: 60px;
        height: 60px;
    }
    
    .payment-form {
        padding: 15px;
    }
    
    .payment-icon {
        width: 36px;
        height: 36px;
        font-size: 1.2rem;
    }
    
    .payment-name {
        font-size: 0.85rem;
    }
    
    .payment-desc {
        font-size: 0.7rem;
    }
    
    .security-badges {
        gap: 10px;
        flex-wrap: wrap;
    }
    
    .trust-icons i {
        font-size: 1rem;
    }
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentForm = document.getElementById('paymentForm');
    const payButton = document.getElementById('payButton');
    
    if (paymentForm) {
        paymentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const selectedMethod = document.querySelector('input[name="payment_method"]:checked');
            if (!selectedMethod) {
                showNotification('Please select a payment method', 'error');
                return;
            }
            
            const btnText = payButton.querySelector('.btn-text');
            const btnLoader = payButton.querySelector('.btn-loader');
            
            btnText.style.display = 'none';
            btnLoader.style.display = 'inline-flex';
            payButton.disabled = true;
            
            setTimeout(() => {
                paymentForm.submit();
            }, 500);
        });
    }
    
    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.style.cssText = `
            position: fixed;
            bottom: 20px;
            left: 20px;
            right: 20px;
            max-width: 300px;
            margin: 0 auto;
            padding: 12px 20px;
            background: ${type === 'success' ? '#06d6a0' : '#f72585'};
            color: white;
            border-radius: 30px;
            font-weight: 500;
            font-size: 0.9rem;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            z-index: 9999;
            animation: slideUp 0.3s ease;
        `;
        notification.textContent = message;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.animation = 'slideDown 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
});
</script>
@endpush