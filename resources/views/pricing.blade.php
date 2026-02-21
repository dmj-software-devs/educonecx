@extends('layouts.main')

@section('title', 'Pricing - EDUCONECX')

@section('meta_description', 'Choose the perfect learning plan for your journey. From free access to premium features, find the option that fits your goals and budget.')

@push('styles')
<style>
    /* Pricing Header */
    .pricing-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 80px 0;
        text-align: center;
        margin-bottom: 60px;
    }
    
    .pricing-title {
        font-size: 48px;
        margin-bottom: 20px;
        animation: slideUp 0.8s ease-out;
    }
    
    .pricing-subtitle {
        font-size: 18px;
        opacity: 0.9;
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.6;
        animation: slideUp 0.8s ease-out 0.2s both;
    }
    
    /* Pricing Section */
    .pricing-section {
        padding: 0 0 80px;
    }
    
    .pricing-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .pricing-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        transition: all 0.3s;
        position: relative;
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    
    .pricing-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }
    
    .pricing-card.popular {
        border: 2px solid var(--primary-color);
        transform: scale(1.05);
        z-index: 2;
    }
    
    .pricing-card.popular:hover {
        transform: scale(1.05) translateY(-10px);
    }
    
    .popular-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        background: var(--primary-color);
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(1,123,254,0.4);
        }
        70% {
            box-shadow: 0 0 0 10px rgba(1,123,254,0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(1,123,254,0);
        }
    }
    
    .pricing-header-card {
        padding: 40px 30px;
        text-align: center;
        border-bottom: 1px solid #eee;
    }
    
    .plan-name {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 15px;
        color: var(--text-color);
    }
    
    .plan-price {
        font-size: 48px;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 15px;
    }
    
    .plan-price small {
        font-size: 16px;
        font-weight: 400;
        color: #999;
    }
    
    .plan-description {
        color: #666;
        font-size: 14px;
        line-height: 1.6;
        margin-bottom: 20px;
    }
    
    .pricing-body {
        padding: 30px;
        flex: 1;
    }
    
    .feature-list {
        list-style: none;
        padding: 0;
        margin: 0 0 30px;
    }
    
    .feature-item {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 15px;
        color: #555;
        font-size: 15px;
    }
    
    .feature-item i {
        color: var(--primary-color);
        font-size: 14px;
        width: 20px;
    }
    
    .pricing-footer {
        padding: 0 30px 40px;
        text-align: center;
    }
    
    .btn-plan {
        display: inline-block;
        width: 100%;
        padding: 15px 30px;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s;
        background: transparent;
        color: var(--primary-color);
        border: 2px solid var(--primary-color);
    }
    
    .btn-plan:hover {
        background: var(--primary-color);
        color: white;
        transform: translateY(-2px);
    }
    
    .btn-plan.popular-btn {
        background: var(--primary-color);
        color: white;
    }
    
    .btn-plan.popular-btn:hover {
        background: var(--primary-hover);
        border-color: var(--primary-hover);
    }
    
    /* Free Plan Specific */
    .pricing-card.free .plan-price {
        color: #28a745;
    }
    
    .pricing-card.free .feature-item i {
        color: #28a745;
    }
    
    .pricing-card.free .btn-plan {
        border-color: #28a745;
        color: #28a745;
    }
    
    .pricing-card.free .btn-plan:hover {
        background: #28a745;
        color: white;
    }
    
    /* VIP Plan Specific */
    .pricing-card.vip .plan-price {
        color: #6f42c1;
    }
    
    .pricing-card.vip .feature-item i {
        color: #6f42c1;
    }
    
    .pricing-card.vip .btn-plan {
        border-color: #6f42c1;
        color: #6f42c1;
    }
    
    .pricing-card.vip .btn-plan:hover {
        background: #6f42c1;
        color: white;
    }
    
    /* Guarantee Section */
    .guarantee-section {
        background: #f8f9fa;
        padding: 60px 0;
        margin-top: 60px;
        text-align: center;
    }
    
    .guarantee-content {
        max-width: 800px;
        margin: 0 auto;
    }
    
    .guarantee-icon {
        font-size: 60px;
        color: var(--primary-color);
        margin-bottom: 20px;
    }
    
    .guarantee-title {
        font-size: 28px;
        margin-bottom: 15px;
        color: var(--text-color);
    }
    
    .guarantee-text {
        color: #666;
        line-height: 1.8;
        font-size: 16px;
    }
    
    /* FAQ Section */
    .faq-pricing-section {
        padding: 60px 0;
        background: white;
    }
    
    .faq-pricing-title {
        text-align: center;
        font-size: 32px;
        margin-bottom: 40px;
        color: var(--text-color);
    }
    
    .faq-pricing-grid {
        max-width: 800px;
        margin: 0 auto;
    }
    
    .faq-pricing-item {
        background: #f8f9fa;
        border-radius: 10px;
        margin-bottom: 15px;
        overflow: hidden;
    }
    
    .faq-pricing-question {
        padding: 20px;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 600;
        color: var(--text-color);
    }
    
    .faq-pricing-answer {
        padding: 0 20px 20px;
        color: #666;
        line-height: 1.6;
        display: none;
    }
    
    .faq-pricing-item.active .faq-pricing-answer {
        display: block;
    }
    
    .faq-pricing-question i {
        transition: transform 0.3s;
    }
    
    .faq-pricing-item.active .faq-pricing-question i {
        transform: rotate(180deg);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .pricing-header {
            padding: 60px 0;
        }
        
        .pricing-title {
            font-size: 36px;
        }
        
        .pricing-grid {
            grid-template-columns: 1fr;
            padding: 0 20px;
            gap: 20px;
        }
        
        .pricing-card.popular {
            transform: scale(1);
        }
        
        .pricing-card.popular:hover {
            transform: translateY(-10px);
        }
        
        .plan-price {
            font-size: 40px;
        }
        
        .guarantee-title {
            font-size: 24px;
        }
    }
</style>
@endpush

@section('content')
    <!-- Pricing Header -->
    <section class="pricing-header">
        <div class="container">
            <h1 class="pricing-title">📚 Academy Pricing Plans</h1>
            <p class="pricing-subtitle">Choose the plan that fits your learning journey. Upgrade anytime.</p>
        </div>
    </section>
    
    <!-- Pricing Section -->
    <section class="pricing-section">
        <div class="container">
            <div class="pricing-grid">
                @foreach($plans as $key => $plan)
                    <div class="pricing-card 
                        {{ $key }} 
                        {{ $plan['popular'] ?? false ? 'popular' : '' }}
                        {{ $plan['highlight'] ? 'popular' : '' }}
                    ">
                        @if($plan['popular'] ?? false)
                            <div class="popular-badge">Most Popular</div>
                        @endif
                        
                        <div class="pricing-header-card">
                            <h2 class="plan-name">{{ $plan['name'] }}</h2>
                            <div class="plan-price">
                                @if($plan['price'] == 0)
                                    Free
                                @else
                                    ${{ $plan['price'] }}<small>/month</small>
                                @endif
                            </div>
                            <p class="plan-description">{{ $plan['description'] }}</p>
                        </div>
                        
                        <div class="pricing-body">
                            <ul class="feature-list">
                                @foreach($plan['features'] as $feature)
                                    <li class="feature-item">
                                        <i class="fas fa-check"></i>
                                        {{ $feature }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        
                        <div class="pricing-footer">
                            <a href="{{ $plan['button_url'] }}" 
                               class="btn-plan {{ $plan['highlight'] ? 'popular-btn' : '' }}">
                                {{ $plan['button_text'] }}
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    
    <!-- Money-Back Guarantee Section -->
    <section class="guarantee-section">
        <div class="container">
            <div class="guarantee-content">
                <div class="guarantee-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h2 class="guarantee-title">30-Day Money-Back Guarantee</h2>
                <p class="guarantee-text">
                    We're confident you'll love our courses. If you're not completely satisfied within the first 30 days, we'll refund your full subscription amount — no questions asked.
                </p>
            </div>
        </div>
    </section>
    
    <!-- FAQ Section -->
    <section class="faq-pricing-section">
        <div class="container">
            <h2 class="faq-pricing-title">Frequently Asked Questions</h2>
            
            <div class="faq-pricing-grid">
                <!-- FAQ Item 1 -->
                <div class="faq-pricing-item">
                    <div class="faq-pricing-question">
                        <span>Can I switch plans later?</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-pricing-answer">
                        <p>Yes, you can upgrade or downgrade your plan at any time. Changes will be reflected in your next billing cycle.</p>
                    </div>
                </div>
                
                <!-- FAQ Item 2 -->
                <div class="faq-pricing-item">
                    <div class="faq-pricing-question">
                        <span>What payment methods do you accept?</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-pricing-answer">
                        <p>We accept all major credit cards (Visa, MasterCard, American Express) and PayPal. All payments are processed securely through Stripe.</p>
                    </div>
                </div>
                
                <!-- FAQ Item 3 -->
                <div class="faq-pricing-item">
                    <div class="faq-pricing-question">
                        <span>Is there a free trial?</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-pricing-answer">
                        <p>Yes! We offer a 3-day free trial on all paid plans. You can explore our courses and features risk-free before committing.</p>
                    </div>
                </div>
                
                <!-- FAQ Item 4 -->
                <div class="faq-pricing-item">
                    <div class="faq-pricing-question">
                        <span>Can I cancel my subscription?</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-pricing-answer">
                        <p>Absolutely. You can cancel your subscription at any time from your dashboard. Your access will continue until the end of your billing period.</p>
                    </div>
                </div>
                
                <!-- FAQ Item 5 -->
                <div class="faq-pricing-item">
                    <div class="faq-pricing-question">
                        <span>Do you offer student or group discounts?</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-pricing-answer">
                        <p>Yes, we offer special pricing for students and groups. Please contact our sales team for more information.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // FAQ Accordion functionality
        const faqItems = document.querySelectorAll('.faq-pricing-question');
        
        faqItems.forEach(question => {
            question.addEventListener('click', () => {
                const faqItem = question.parentElement;
                faqItem.classList.toggle('active');
                
                const icon = question.querySelector('i');
                if (faqItem.classList.contains('active')) {
                    icon.classList.remove('fa-chevron-down');
                    icon.classList.add('fa-chevron-up');
                } else {
                    icon.classList.remove('fa-chevron-up');
                    icon.classList.add('fa-chevron-down');
                }
            });
        });
    });
</script>
@endpush