@extends('layouts.main')

@section('title', 'All-Access Pass - One-Time Payment for All Courses')

@section('meta_description', 'Get unlimited access to all paid courses with a single one-time payment. Lifetime access to all current and future courses.')

@push('styles')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --success-gradient: linear-gradient(135deg, #06d6a0 0%, #1b9e6d 100%);
        --warning-gradient: linear-gradient(135deg, #f72585 0%, #b5179e 100%);
    }

    .all-access-hero {
        position: relative;
        background: var(--primary-gradient);
        padding: 80px 0;
        overflow: hidden;
        color: white;
    }

    .all-access-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('/images/pattern.png') repeat;
        opacity: 0.1;
    }

    .all-access-content {
        position: relative;
        z-index: 2;
    }

    .all-access-badge {
        display: inline-block;
        padding: 8px 20px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 20px;
        backdrop-filter: blur(10px);
    }

    .all-access-title {
        font-size: clamp(2.5rem, 6vw, 3.5rem);
        font-weight: 800;
        margin-bottom: 20px;
        line-height: 1.2;
    }

    .all-access-subtitle {
        font-size: 1.2rem;
        opacity: 0.95;
        margin-bottom: 30px;
        max-width: 700px;
    }

    .pricing-card {
        background: white;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        max-width: 500px;
        margin: 0 auto;
        position: relative;
        border: 2px solid transparent;
        transition: all 0.3s ease;
    }

    .pricing-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 30px 60px rgba(102,126,234,0.25);
        border-color: #667eea;
    }

    .pricing-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 40px 30px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .pricing-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 300px;
        height: 300px;
        background: rgba(102,126,234,0.05);
        border-radius: 50%;
    }

    .pricing-icon {
        width: 80px;
        height: 80px;
        background: var(--primary-gradient);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        color: white;
        font-size: 2.5rem;
        box-shadow: 0 10px 20px rgba(102,126,234,0.3);
    }

    .pricing-name {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 15px;
        color: #333;
    }

    .pricing-price {
        font-size: 4rem;
        font-weight: 800;
        color: #667eea;
        margin-bottom: 10px;
        line-height: 1;
    }

    .pricing-price small {
        font-size: 1rem;
        font-weight: 400;
        color: #6c757d;
    }

    .pricing-description {
        color: #6c757d;
        font-size: 1rem;
        max-width: 300px;
        margin: 0 auto;
    }

    .pricing-body {
        padding: 30px;
    }

    .feature-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .feature-item {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 15px;
        color: #4a5568;
        font-size: 1rem;
    }

    .feature-item i {
        color: #06d6a0;
        font-size: 1.1rem;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(6, 214, 160, 0.1);
        border-radius: 50%;
    }

    .pricing-footer {
        padding: 0 30px 40px;
        text-align: center;
    }

    .btn-purchase {
        display: inline-block;
        width: 100%;
        padding: 16px 30px;
        background: var(--primary-gradient);
        color: white;
        border: none;
        border-radius: 50px;
        font-size: 1.2rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 10px 20px rgba(102,126,234,0.3);
        position: relative;
        overflow: hidden;
    }

    .btn-purchase::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .btn-purchase:hover::before {
        width: 300px;
        height: 300px;
    }

    .btn-purchase:hover {
        transform: translateY(-3px);
        box-shadow: 0 20px 40px rgba(102,126,234,0.4);
    }

    .btn-purchase:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
    }

    .guarantee-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #f8f9fa;
        padding: 10px 20px;
        border-radius: 50px;
        margin-top: 20px;
        font-size: 0.95rem;
        color: #4a5568;
        border: 1px solid #e9ecef;
    }

    .guarantee-badge i {
        color: #06d6a0;
    }

    .benefits-section {
        background: white;
        border-radius: 24px;
        padding: 40px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        margin-top: 40px;
    }

    .benefits-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 30px;
        color: #333;
        text-align: center;
    }

    .benefits-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 25px;
    }

    .benefit-item {
        text-align: center;
        padding: 25px;
        border-radius: 16px;
        background: #f8f9fa;
        transition: all 0.3s ease;
    }

    .benefit-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        background: white;
    }

    .benefit-icon {
        width: 60px;
        height: 60px;
        background: var(--primary-gradient);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
        color: white;
        font-size: 1.5rem;
    }

    .benefit-title {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 10px;
        color: #333;
    }

    .benefit-text {
        color: #6c757d;
        font-size: 0.95rem;
        line-height: 1.6;
    }

    .comparison-section {
        margin-top: 60px;
    }

    .comparison-table {
        background: white;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    .comparison-table table {
        width: 100%;
        border-collapse: collapse;
    }

    .comparison-table th {
        background: var(--primary-gradient);
        color: white;
        padding: 20px;
        font-size: 1.1rem;
        font-weight: 600;
    }

    .comparison-table td {
        padding: 15px 20px;
        border-bottom: 1px solid #e9ecef;
    }

    .comparison-table tr:last-child td {
        border-bottom: none;
    }

    .comparison-table .feature-name {
        font-weight: 600;
        color: #333;
    }

    .comparison-table .feature-check {
        color: #06d6a0;
        font-size: 1.2rem;
    }

    .comparison-table .feature-times {
        color: #f72585;
        font-size: 1.2rem;
    }

    .payment-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.8);
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }

    .payment-modal.show {
        display: flex;
        animation: fadeIn 0.3s ease;
    }

    .payment-modal-content {
        background: white;
        border-radius: 24px;
        padding: 40px;
        max-width: 500px;
        width: 90%;
        position: relative;
    }

    .payment-modal-close {
        position: absolute;
        top: 15px;
        right: 15px;
        width: 40px;
        height: 40px;
        background: #f8f9fa;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        color: #333;
        transition: all 0.3s ease;
    }

    .payment-modal-close:hover {
        background: #f72585;
        color: white;
        transform: rotate(90deg);
    }

    .card-element {
        padding: 15px;
        border: 2px solid #e9ecef;
        border-radius: 12px;
        margin: 20px 0;
        transition: all 0.3s ease;
    }

    .card-element.StripeElement--focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102,126,234,0.1);
    }

    .card-element.StripeElement--invalid {
        border-color: #f72585;
    }

    .card-errors {
        color: #f72585;
        font-size: 0.9rem;
        margin-top: 10px;
        min-height: 20px;
    }

    .btn-pay {
        width: 100%;
        padding: 16px;
        background: var(--primary-gradient);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-pay:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(102,126,234,0.3);
    }

    .btn-pay:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @media (max-width: 768px) {
        .all-access-hero {
            padding: 60px 0;
        }
        
        .pricing-card {
            margin: 0 20px;
        }
        
        .benefits-section {
            padding: 30px 20px;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="all-access-hero">
    <div class="container">
        <div class="all-access-content text-center" data-aos="fade-up">
            <span class="all-access-badge">
                <i class="fas fa-crown"></i> One Payment. Lifetime Access.
            </span>
            <h1 class="all-access-title">All-Access Pass</h1>
            <p class="all-access-subtitle mx-auto">
                Get unlimited access to ALL our paid courses with a single one-time payment. 
                No subscriptions, no recurring fees — just lifetime learning.
            </p>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Pricing Card -->
                <div class="pricing-card" data-aos="fade-up">
                    <div class="pricing-header">
                        <div class="pricing-icon">
                            <i class="fas fa-crown"></i>
                        </div>
                        <h2 class="pricing-name">{{ $plan['name'] }}</h2>
                        <div class="pricing-price">
                            ${{ number_format($plan['price'], 2) }}
                            <small>one-time</small>
                        </div>
                        <p class="pricing-description">{{ $plan['description'] }}</p>
                    </div>
                    
                    <div class="pricing-body">
                        <ul class="feature-list">
                            @foreach($plan['features'] as $feature)
                            <li class="feature-item">
                                <i class="fas fa-check"></i>
                                {{ $feature }}
                            </li>
                            @endforeach
                            <li class="feature-item">
                                <i class="fas fa-check"></i>
                                <strong>{{ \App\Models\Course::where('is_free', false)->count() }}+ paid courses included</strong>
                            </li>
                            <li class="feature-item">
                                <i class="fas fa-check"></i>
                                All future courses automatically included
                            </li>
                        </ul>
                    </div>
                    
                    <div class="pricing-footer">
                        @auth
                            @if(auth()->user()->has_all_access)
                                <button class="btn-purchase" disabled>
                                    <i class="fas fa-check-circle"></i> Already Have Access
                                </button>
                                <div class="guarantee-badge">
                                    <i class="fas fa-check-circle"></i>
                                    You already have all-access! Start learning now.
                                </div>
                            @else
                                <button class="btn-purchase" id="purchaseBtn">
                                    <i class="fas fa-lock"></i> Get All-Access Now
                                </button>
                                <!-- <div class="guarantee-badge">
                                    <i class="fas fa-shield-alt"></i>
                                    30-Day Money-Back Guarantee
                                </div> -->
                            @endif
                        @else
                            <a href="{{ route('login') }}?redirect={{ url()->current() }}" class="btn-purchase">
                                <i class="fas fa-sign-in-alt"></i> Login to Purchase
                            </a>
                            <!-- <div class="guarantee-badge">
                                <i class="fas fa-shield-alt"></i>
                                30-Day Money-Back Guarantee
                            </div> -->
                        @endauth
                    </div>
                </div>

                <!-- Benefits Section -->
                <div class="benefits-section" data-aos="fade-up">
                    <h3 class="benefits-title">What's Included</h3>
                    <div class="benefits-grid">
                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <i class="fas fa-infinity"></i>
                            </div>
                            <h4 class="benefit-title">Lifetime Access</h4>
                            <p class="benefit-text">One payment, lifetime access to all courses. No recurring fees, ever.</p>
                        </div>
                        
                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <i class="fas fa-rocket"></i>
                            </div>
                            <h4 class="benefit-title">Future Courses</h4>
                            <p class="benefit-text">All new courses added in the future are automatically included.</p>
                        </div>
                        
                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <i class="fas fa-certificate"></i>
                            </div>
                            <h4 class="benefit-title">Certificates</h4>
                            <p class="benefit-text">Earn a certificate of completion for every course you finish.</p>
                        </div>
                        
                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <i class="fas fa-headset"></i>
                            </div>
                            <h4 class="benefit-title">Priority Support</h4>
                            <p class="benefit-text">Get priority support for all your questions and issues.</p>
                        </div>
                    </div>
                </div>

                <!-- Comparison Table -->
                <div class="comparison-section" data-aos="fade-up">
                    <h3 class="benefits-title">Compare Your Options</h3>
                    <div class="comparison-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Features</th>
                                    <th>Individual Courses</th>
                                    <th>All-Access Pass</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="feature-name">Access to one course</td>
                                    <td><i class="fas fa-check feature-check"></i></td>
                                    <td><i class="fas fa-check feature-check"></i></td>
                                </tr>
                                <tr>
                                    <td class="feature-name">Access to all courses</td>
                                    <td><i class="fas fa-times feature-times"></i></td>
                                    <td><i class="fas fa-check feature-check"></i></td>
                                </tr>
                                <tr>
                                    <td class="feature-name">Future courses included</td>
                                    <td><i class="fas fa-times feature-times"></i></td>
                                    <td><i class="fas fa-check feature-check"></i></td>
                                </tr>
                                <tr>
                                    <td class="feature-name">One-time payment</td>
                                    <td><i class="fas fa-check feature-check"></i> per course</td>
                                    <td><i class="fas fa-check feature-check"></i> one payment</td>
                                </tr>
                                <tr>
                                    <td class="feature-name">Total cost for 10 courses</td>
                                    <td>${{ number_format(\App\Models\Course::where('is_free', false)->sum('price'), 2) }}+</td>
                                    <td class="text-primary fw-bold">${{ number_format($plan['price'], 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Payment Modal -->
<div class="payment-modal" id="paymentModal">
    <div class="payment-modal-content">
        <button class="payment-modal-close" id="closeModal">&times;</button>
        <h3 class="text-center mb-4">Complete Your Purchase</h3>
        
        <form id="paymentForm">
            @csrf
            <div class="mb-3">
                <label class="form-label">Card Details</label>
                <div id="cardElement" class="card-element"></div>
                <div id="cardErrors" class="card-errors" role="alert"></div>
            </div>
            
            <button type="submit" class="btn-pay" id="submitBtn">
                <i class="fas fa-lock"></i> Pay ${{ number_format($plan['price'], 2) }}
            </button>
        </form>
        
        <p class="text-center text-muted small mt-3">
            <i class="fas fa-shield-alt"></i> Your payment is secure and encrypted
        </p>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const stripe = Stripe('{{ config('services.stripe.key') }}');
        const elements = stripe.elements();
        
        const card = elements.create('card', {
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
        
        card.mount('#cardElement');
        
        const purchaseBtn = document.getElementById('purchaseBtn');
        const paymentModal = document.getElementById('paymentModal');
        const closeBtn = document.getElementById('closeModal');
        const paymentForm = document.getElementById('paymentForm');
        const submitBtn = document.getElementById('submitBtn');
        const cardErrors = document.getElementById('cardErrors');
        
        if (purchaseBtn) {
            purchaseBtn.addEventListener('click', function() {
                paymentModal.classList.add('show');
            });
        }
        
        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                paymentModal.classList.remove('show');
            });
        }
        
        // Close modal when clicking outside
        paymentModal.addEventListener('click', function(e) {
            if (e.target === paymentModal) {
                paymentModal.classList.remove('show');
            }
        });
        
        // Handle form submission
        paymentForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            
            try {
                const { paymentMethod, error } = await stripe.createPaymentMethod({
                    type: 'card',
                    card: card,
                });
                
                if (error) {
                    cardErrors.textContent = error.message;
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-lock"></i> Pay ${{ number_format($plan['price'], 2) }}';
                } else {
                    // Send payment method to server
                    const response = await fetch('{{ route('payment.all-access.process') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            payment_method_id: paymentMethod.id
                        })
                    });
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        // Show success message and redirect
                        showNotification('Payment successful! Redirecting...', 'success');
                        setTimeout(() => {
                            window.location.href = data.redirect_url;
                        }, 1500);
                    } else {
                        cardErrors.textContent = data.error || 'Payment failed. Please try again.';
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '<i class="fas fa-lock"></i> Pay ${{ number_format($plan['price'], 2) }}';
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                cardErrors.textContent = 'An error occurred. Please try again.';
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-lock"></i> Pay ${{ number_format($plan['price'], 2) }}';
            }
        });
        
        // Card validation
        card.on('change', function(event) {
            if (event.error) {
                cardErrors.textContent = event.error.message;
            } else {
                cardErrors.textContent = '';
            }
        });
        
        // Notification function
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.textContent = message;
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 15px 25px;
                background: ${type === 'success' ? '#06d6a0' : '#f72585'};
                color: white;
                border-radius: 50px;
                box-shadow: 0 5px 20px rgba(0,0,0,0.2);
                z-index: 10000;
                animation: slideIn 0.3s ease;
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, 3000);
        }
        
        // Add keyframe animations
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            @keyframes slideOut {
                from {
                    transform: translateX(0);
                    opacity: 1;
                }
                to {
                    transform: translateX(100%);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    });
</script>
@endpush