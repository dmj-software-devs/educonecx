{{-- resources/views/checkout-stripe.blade.php --}}
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

                    <div class="payment-section">
                        <h3>Payment Details</h3>
                        
                        <!-- Stripe Elements will be inserted here -->
                        <div id="stripe-card-element" class="stripe-card-element">
                            <!-- Stripe Elements will create form elements here -->
                        </div>
                        
                        <div id="stripe-errors" class="stripe-errors" role="alert"></div>
                        
                        <button id="stripe-pay-button" class="btn-pay" data-course-id="{{ $course->id }}">
                            Pay ${{ number_format($course->current_price, 2) }}
                        </button>

                        <div class="payment-loader" style="display: none;">
                            <div class="spinner"></div>
                            <p>Processing your payment...</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="checkout-sidebar">
                    <div class="course-thumb">
                        <img src="{{ $course->thumbnail_url }}" alt="{{ $course->title }}">
                    </div>
                    <h4>{{ $course->title }}</h4>
                    <p>{{ Str::limit($course->excerpt, 100) }}</p>
                    
                    <div class="secure-payment-badge">
                        <i class="fas fa-lock"></i>
                        <span>Secure payment powered by Stripe</span>
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
        
        const courseId = this.dataset.courseId;
        
        try {
            // Create payment intent on server
            const response = await fetch('{{ route("stripe.create-checkout-session") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    course_id: courseId
                }),
            });
            
            const data = await response.json();
            
            if (data.error) {
                throw new Error(data.error);
            }
            
            // Redirect to Stripe Checkout
            if (data.checkout_url) {
                window.location.href = data.checkout_url;
            } else if (data.session_id) {
                // Use redirectToCheckout for embedded flow
                const result = await stripe.redirectToCheckout({
                    sessionId: data.session_id,
                });
                
                if (result.error) {
                    throw new Error(result.error.message);
                }
            } else if (data.redirect_url) {
                // Free course redirect
                window.location.href = data.redirect_url;
            }
            
        } catch (error) {
            // Re-enable button and hide loader
            payButton.disabled = false;
            loader.style.display = 'none';
            
            // Show error
            const displayError = document.getElementById('stripe-errors');
            displayError.textContent = error.message;
            
            console.error('Payment error:', error);
        }
    });
});
</script>

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

.payment-section {
    margin-bottom: 30px;
}

.payment-section h3 {
    margin-bottom: 20px;
    font-size: 1.2rem;
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
    color: #dc3545;
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
    margin-bottom: 20px;
}

.secure-payment-badge {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 10px;
    color: #28a745;
    font-size: 0.95rem;
}

.secure-payment-badge i {
    font-size: 1.2rem;
}
</style>
@endsection