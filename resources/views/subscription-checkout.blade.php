@extends('layouts.main')

@section('title', 'Subscription Checkout - ' . $plan->name)

@section('content')
<div class="checkout-container">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="checkout-form">
                    <h2>Complete Your Subscription</h2>
                    
                    <div class="order-summary">
                        <h3>Order Summary</h3>
                        <div class="order-item">
                            <div>
                                <strong>{{ $plan->name }}</strong>
                                <p class="text-muted small mb-0">{{ $plan->description }}</p>
                            </div>
                            <span>${{ number_format($plan->price, 2) }}</span>
                        </div>
                        
                        @if($plan->features_list)
                        <div class="features-preview mt-3">
                            <small class="text-muted">What's included:</small>
                            <ul class="feature-list-small">
                                @foreach($plan->features_list as $feature)
                                <li><i class="fas fa-check text-success"></i> {{ $feature }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        
                        <div class="order-total">
                            <strong>Total</strong>
                            <strong>${{ number_format($plan->price, 2) }}</strong>
                        </div>
                        
                        <div class="subscription-notice">
                            <i class="fas fa-info-circle"></i>
                            <span>This is a one-time payment for {{ $plan->duration_text }} of unlimited access to all paid courses.</span>
                        </div>
                    </div>

                    <div class="payment-section">
                        <h3>Payment Details</h3>
                        
                        <!-- Stripe Elements will be inserted here -->
                        <div id="stripe-card-element" class="stripe-card-element">
                            <!-- Stripe Elements will create form elements here -->
                        </div>
                        
                        <div id="stripe-errors" class="stripe-errors" role="alert"></div>
                        
                        <button id="stripe-pay-button" class="btn-pay" data-plan-id="{{ $plan->id }}">
                            Pay ${{ number_format($plan->price, 2) }} & Get Unlimited Access
                        </button>

                        <div class="payment-loader" style="display: none;">
                            <div class="spinner"></div>
                            <p>Processing your payment...</p>
                        </div>
                        
                        <div class="payment-terms mt-3 text-center">
                            <small class="text-muted">
                                By completing this purchase, you agree to our 
                                <a href="{{ route('terms') }}" target="_blank">Terms of Service</a> and 
                                <a href="{{ route('privacy') }}" target="_blank">Privacy Policy</a>.
                                <br>
                                You'll get instant access to all paid courses upon successful payment.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="checkout-sidebar">
                    <div class="plan-summary">
                        <div class="plan-icon-large">
                            <i class="fas fa-crown"></i>
                        </div>
                        <h3>{{ $plan->name }}</h3>
                        <div class="plan-price-large">
                            ${{ number_format($plan->price, 2) }}
                            <small>/{{ $plan->duration_text }}</small>
                        </div>
                    </div>
                    
                    <div class="benefits-box">
                        <h4>What you'll get:</h4>
                        <ul class="benefits-list">
                            <li>
                                <i class="fas fa-check-circle text-success"></i>
                                <span>Unlimited access to ALL paid courses</span>
                            </li>
                            <li>
                                <i class="fas fa-check-circle text-success"></i>
                                <span>New courses added regularly</span>
                            </li>
                            <li>
                                <i class="fas fa-check-circle text-success"></i>
                                <span>Learn at your own pace</span>
                            </li>
                            <li>
                                <i class="fas fa-check-circle text-success"></i>
                                <span>Certificate of completion for each course</span>
                            </li>
                            <li>
                                <i class="fas fa-check-circle text-success"></i>
                                <span>Priority support</span>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="secure-payment-badge">
                        <i class="fas fa-lock"></i>
                        <div>
                            <strong>Secure payment</strong>
                            <span>Powered by Stripe</span>
                        </div>
                    </div>
                    
                    <div class="guarantee-badge">
                        <i class="fas fa-shield-alt"></i>
                        <div>
                            <strong>30-Day Money-Back Guarantee</strong>
                            <span>Not satisfied? Get a full refund.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Stripe.js -->
<script src="https://js.stripe.com/v3/"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Stripe
    const stripe = Stripe('{{ config('services.stripe.key') }}');
    const elements = stripe.elements();
    
    // Create card Element and mount it
    const cardElement = elements.create('card', {
        style: {
            base: {
                fontSize: '16px',
                color: '#424770',
                '::placeholder': {
                    color: '#aab7c4',
                },
            },
        },
    });
    
    cardElement.mount('#stripe-card-element');
    
    // Handle validation errors
    cardElement.on('change', function(event) {
        const displayError = document.getElementById('stripe-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });
    
    // Handle form submission
    const payButton = document.getElementById('stripe-pay-button');
    const loader = document.querySelector('.payment-loader');
    
    payButton.addEventListener('click', async function(event) {
        event.preventDefault();
        
        // Disable button and show loader
        payButton.disabled = true;
        loader.style.display = 'block';
        
        const planId = this.dataset.planId;
        
        try {
            // Create payment intent on server
            const response = await fetch('{{ route("subscription.process") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    plan_id: planId,
                    payment_method_id: 'card' // This will be handled by Stripe
                }),
            });
            
            const data = await response.json();
            
            if (data.error) {
                throw new Error(data.error);
            }
            
            if (data.success && data.redirect_url) {
                // Show success message
                showNotification('Payment successful! Redirecting...', 'success');
                
                // Redirect to success page
                setTimeout(() => {
                    window.location.href = data.redirect_url;
                }, 1500);
            } else if (data.requires_action) {
                // Handle 3D Secure authentication
                const result = await stripe.handleCardAction(data.payment_intent_client_secret);
                
                if (result.error) {
                    throw new Error(result.error.message);
                } else {
                    // The card action has been handled, confirm the payment
                    const confirmResponse = await fetch('{{ route("subscription.process") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({
                            plan_id: planId,
                            payment_intent_id: result.paymentIntent.id
                        }),
                    });
                    
                    const confirmData = await confirmResponse.json();
                    
                    if (confirmData.success) {
                        window.location.href = confirmData.redirect_url;
                    } else {
                        throw new Error(confirmData.error || 'Payment failed');
                    }
                }
            } else {
                throw new Error('Unexpected response from server');
            }
            
        } catch (error) {
            // Re-enable button and hide loader
            payButton.disabled = false;
            loader.style.display = 'none';
            
            // Show error
            const displayError = document.getElementById('stripe-errors');
            displayError.textContent = error.message;
            
            console.error('Payment error:', error);
            
            // Show notification
            showNotification(error.message, 'error');
        }
    });
    
    // Simple notification function
    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.innerHTML = `
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
            <span>${message}</span>
        `;
        
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${type === 'success' ? '#06d6a0' : '#f72585'};
            color: white;
            padding: 15px 25px;
            border-radius: 50px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
            z-index: 10000;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideIn 0.3s ease;
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
    
    // Add animation styles
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
    `;
    document.head.appendChild(style);
});
</script>

<style>
.checkout-container {
    padding: 60px 0;
    background: linear-gradient(135deg, #f5f7ff 0%, #f0f3ff 100%);
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
    color: #1e1e2f;
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
    color: #1e1e2f;
}

.order-item {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 15px 0;
    border-bottom: 1px solid #dee2e6;
}

.order-item > span {
    font-weight: 600;
    color: #667eea;
    font-size: 1.2rem;
}

.feature-list-small {
    list-style: none;
    padding: 0;
    margin: 10px 0 0;
}

.feature-list-small li {
    margin-bottom: 5px;
    font-size: 0.9rem;
    color: #6c757d;
}

.feature-list-small i {
    margin-right: 8px;
    font-size: 0.8rem;
}

.order-total {
    display: flex;
    justify-content: space-between;
    padding: 20px 0 10px;
    font-size: 1.3rem;
    border-top: 2px solid #dee2e6;
    margin-top: 10px;
}

.order-total strong:last-child {
    color: #667eea;
}

.subscription-notice {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 15px;
    background: rgba(102, 126, 234, 0.1);
    border-radius: 10px;
    margin-top: 15px;
    font-size: 0.95rem;
    color: #1e1e2f;
}

.subscription-notice i {
    color: #667eea;
    font-size: 1.2rem;
}

.payment-section {
    margin-bottom: 30px;
}

.payment-section h3 {
    margin-bottom: 20px;
    font-size: 1.2rem;
    color: #1e1e2f;
}

.stripe-card-element {
    padding: 15px;
    border: 1px solid #dee2e6;
    border-radius: 10px;
    margin-bottom: 15px;
    background: white;
    transition: all 0.3s;
}

.stripe-card-element:focus-within {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.stripe-errors {
    color: #f72585;
    font-size: 0.9rem;
    margin-bottom: 15px;
    min-height: 20px;
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
    position: relative;
}

.btn-pay:hover:not(:disabled) {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
}

.btn-pay:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.payment-loader {
    text-align: center;
    margin-top: 20px;
}

.spinner {
    border: 3px solid #f3f3f3;
    border-top: 3px solid #667eea;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 1s linear infinite;
    margin: 0 auto 10px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.checkout-sidebar {
    background: white;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    position: sticky;
    top: 100px;
}

.plan-summary {
    text-align: center;
    padding-bottom: 20px;
    border-bottom: 1px solid #dee2e6;
    margin-bottom: 20px;
}

.plan-icon-large {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 15px;
    color: white;
    font-size: 2.5rem;
}

.plan-summary h3 {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 10px;
    color: #1e1e2f;
}

.plan-price-large {
    font-size: 2.5rem;
    font-weight: 800;
    color: #667eea;
    line-height: 1;
}

.plan-price-large small {
    font-size: 0.9rem;
    font-weight: 400;
    color: #6c757d;
}

.benefits-box {
    margin-bottom: 20px;
}

.benefits-box h4 {
    font-size: 1rem;
    margin-bottom: 15px;
    color: #1e1e2f;
}

.benefits-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.benefits-list li {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 12px;
    font-size: 0.95rem;
    color: #6c757d;
}

.benefits-list i {
    font-size: 1rem;
    flex-shrink: 0;
}

.secure-payment-badge,
.guarantee-badge {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 15px;
}

.secure-payment-badge {
    background: #f8f9fa;
    color: #28a745;
}

.guarantee-badge {
    background: rgba(6, 214, 160, 0.1);
    color: #06d6a0;
}

.secure-payment-badge i,
.guarantee-badge i {
    font-size: 1.5rem;
}

.secure-payment-badge div,
.guarantee-badge div {
    display: flex;
    flex-direction: column;
}

.secure-payment-badge strong,
.guarantee-badge strong {
    font-size: 1rem;
    margin-bottom: 2px;
}

.secure-payment-badge span,
.guarantee-badge span {
    font-size: 0.8rem;
    opacity: 0.8;
}

.payment-terms a {
    color: #667eea;
    text-decoration: none;
}

.payment-terms a:hover {
    text-decoration: underline;
}

@media (max-width: 768px) {
    .checkout-form {
        padding: 25px;
    }
    
    .order-item {
        flex-direction: column;
        gap: 10px;
    }
    
    .order-item > span {
        align-self: flex-start;
    }
    
    .checkout-sidebar {
        margin-top: 30px;
        position: static;
    }
}
</style>
@endsection