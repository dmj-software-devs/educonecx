@extends('layouts.main')

@section('title', 'Subscription Plans - EDUCONECX | Choose Your Plan')

@section('meta_description', 'Choose the perfect subscription plan for your learning journey. Get unlimited access to all paid courses with a single subscription.')

@push('styles')
<style>
    /* Hero Section */
    .pricing-hero {
        position: relative;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 100px 0;
        overflow: hidden;
        color: #ffffff;
    }

    .pricing-hero-particles {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    .pricing-hero-particle {
        position: absolute;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .pricing-hero-particle:nth-child(1) {
        width: 300px;
        height: 300px;
        top: -150px;
        right: -150px;
        animation: float 8s ease-in-out infinite;
    }

    .pricing-hero-particle:nth-child(2) {
        width: 200px;
        height: 200px;
        bottom: -100px;
        left: -100px;
        animation: float 10s ease-in-out infinite reverse;
    }

    .pricing-hero-particle:nth-child(3) {
        width: 150px;
        height: 150px;
        top: 30%;
        left: 20%;
        animation: float 12s ease-in-out infinite;
    }

    .pricing-hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
        max-width: 800px;
        margin: 0 auto;
    }

    .pricing-hero-badge {
        display: inline-block;
        padding: 8px 20px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 25px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        animation: fadeInDown 1s ease-out;
    }

    .pricing-hero-title {
        font-size: clamp(2.5rem, 8vw, 4rem);
        font-weight: 800;
        margin-bottom: 20px;
        line-height: 1.1;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        animation: fadeInUp 1s ease-out 0.2s both;
    }

    .pricing-hero-text {
        font-size: clamp(1.1rem, 3vw, 1.3rem);
        opacity: 0.9;
        line-height: 1.8;
        max-width: 700px;
        margin: 0 auto;
        animation: fadeInUp 1s ease-out 0.4s both;
    }

    /* Pricing Section */
    .pricing-section {
        padding: 80px 0;
        background: linear-gradient(135deg, #f5f7ff 0%, #f0f3ff 100%);
    }

    .pricing-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 30px;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .pricing-card {
        background: #ffffff;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        position: relative;
        display: flex;
        flex-direction: column;
        height: 100%;
        border: 2px solid transparent;
    }

    .pricing-card:hover {
        transform: translateY(-15px);
        box-shadow: 0 20px 60px rgba(102, 126, 234, 0.2);
    }

    .pricing-card.popular {
        border-color: #667eea;
        transform: scale(1.05);
        z-index: 2;
    }

    .pricing-card.popular:hover {
        transform: scale(1.05) translateY(-15px);
    }

    .popular-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #ffffff;
        padding: 8px 20px;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        animation: pulse 2s infinite;
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        z-index: 3;
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(102, 126, 234, 0.4);
        }
        70% {
            box-shadow: 0 0 0 15px rgba(102, 126, 234, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(102, 126, 234, 0);
        }
    }

    .pricing-card-header {
        padding: 40px 30px;
        text-align: center;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        position: relative;
        overflow: hidden;
    }

    .pricing-card-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200px;
        height: 200px;
        background: rgba(102, 126, 234, 0.05);
        border-radius: 50%;
    }

    .plan-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px;
        color: #ffffff;
        font-size: 2.5rem;
        box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
    }

    .plan-name {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 15px;
        color: #1e1e2f;
    }

    .plan-price {
        font-size: 3rem;
        font-weight: 800;
        color: #667eea;
        margin-bottom: 10px;
        line-height: 1;
    }

    .plan-price small {
        font-size: 1rem;
        font-weight: 400;
        color: #6c757d;
    }

    .plan-description {
        color: #6c757d;
        font-size: 1rem;
        line-height: 1.6;
        max-width: 250px;
        margin: 0 auto;
    }

    .pricing-card-body {
        padding: 30px;
        flex: 1;
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
        margin-bottom: 16px;
        color: #6c757d;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .feature-item:hover {
        transform: translateX(5px);
        color: #1e1e2f;
    }

    .feature-item i {
        color: #06d6a0;
        font-size: 1rem;
        width: 20px;
        text-align: center;
    }

    .pricing-card-footer {
        padding: 0 30px 40px;
        text-align: center;
    }

    .btn-plan {
        display: inline-block;
        width: 100%;
        padding: 16px 30px;
        border-radius: 50px;
        font-size: 1.1rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        background: transparent;
        color: #667eea;
        border: 2px solid #667eea;
        position: relative;
        overflow: hidden;
        z-index: 1;
    }

    .btn-plan::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
        z-index: -1;
    }

    .btn-plan:hover::before {
        width: 300px;
        height: 300px;
    }

    .btn-plan:hover {
        color: #ffffff;
        border-color: #667eea;
    }

    .btn-plan.popular-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #ffffff;
    }

    .btn-plan.popular-btn::before {
        background: rgba(255, 255, 255, 0.2);
    }

    .btn-plan.popular-btn:hover {
        background: #5a67d8;
        border-color: #5a67d8;
    }

    /* Active Subscription Banner */
    .active-subscription-banner {
        background: linear-gradient(135deg, #06d6a0 0%, #05b587 100%);
        color: #ffffff;
        padding: 20px;
        border-radius: 16px;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 20px;
    }

    .banner-content {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .banner-icon {
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .banner-text h3 {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .banner-text p {
        margin: 0;
        opacity: 0.9;
        font-size: 0.95rem;
    }

    .banner-btn {
        background: #ffffff;
        color: #06d6a0;
        padding: 12px 30px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .banner-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    /* FAQ Section */
    .faq-section {
        padding: 80px 0;
        background: #ffffff;
    }

    .section-header {
        text-align: center;
        margin-bottom: 50px;
    }

    .section-subtitle {
        color: #667eea;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 0.9rem;
        margin-bottom: 10px;
        display: block;
    }

    .section-title {
        font-size: clamp(2rem, 5vw, 2.5rem);
        font-weight: 800;
        margin-bottom: 15px;
        color: #1e1e2f;
    }

    .faq-grid {
        max-width: 800px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .faq-item {
        background: #f8f9fa;
        border-radius: 16px;
        margin-bottom: 15px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
        transition: all 0.3s ease;
    }

    .faq-item:hover {
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    }

    .faq-question {
        padding: 22px 25px;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 600;
        color: #1e1e2f;
        font-size: 1.1rem;
        transition: all 0.3s ease;
    }

    .faq-question:hover {
        background: rgba(102, 126, 234, 0.02);
    }

    .faq-question i {
        color: #667eea;
        transition: all 0.3s ease;
    }

    .faq-item.active .faq-question i {
        transform: rotate(180deg);
    }

    .faq-answer {
        padding: 0 25px 25px;
        color: #6c757d;
        line-height: 1.8;
        display: none;
        border-top: 1px solid #e9ecef;
        margin-top: 5px;
    }

    .faq-item.active .faq-answer {
        display: block;
        animation: fadeIn 0.5s ease-out;
    }

    /* Guarantee Section */
    .guarantee-section {
        background: linear-gradient(135deg, #f5f7ff 0%, #f0f3ff 100%);
        padding: 60px 0;
        text-align: center;
    }

    .guarantee-content {
        max-width: 800px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .guarantee-icon {
        width: 100px;
        height: 100px;
        background: rgba(102, 126, 234, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 30px;
        font-size: 3rem;
        color: #667eea;
        animation: float 6s ease-in-out infinite;
    }

    .guarantee-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 15px;
        color: #1e1e2f;
    }

    .guarantee-text {
        color: #6c757d;
        line-height: 1.8;
        font-size: 1.1rem;
    }

    .guarantee-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #06d6a0;
        color: #ffffff;
        padding: 8px 20px;
        border-radius: 50px;
        margin-top: 30px;
        font-weight: 600;
    }

    /* Animations */
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .pricing-card.popular {
            transform: scale(1);
        }
        .pricing-card.popular:hover {
            transform: translateY(-15px);
        }
    }

    @media (max-width: 768px) {
        .pricing-hero {
            padding: 60px 0;
        }
        .pricing-grid {
            grid-template-columns: 1fr;
        }
        .plan-price {
            font-size: 2.5rem;
        }
        .faq-question {
            padding: 18px 20px;
            font-size: 1rem;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="pricing-hero">
    <div class="pricing-hero-particles">
        <div class="pricing-hero-particle"></div>
        <div class="pricing-hero-particle"></div>
        <div class="pricing-hero-particle"></div>
    </div>

    <div class="container">
        <div class="pricing-hero-content" data-aos="fade-up">
            <span class="pricing-hero-badge">Simple & Transparent Pricing</span>
            <h1 class="pricing-hero-title">Choose Your Learning Path</h1>
            <p class="pricing-hero-text">
                Get unlimited access to ALL paid courses with a single subscription. 
                Learn at your own pace, track your progress, and earn certificates.
            </p>
        </div>
    </div>
</section>

<!-- Pricing Section -->
<section class="pricing-section">
    <div class="container">
        @auth
            @if(Auth::user()->has_active_subscription)
            <div class="active-subscription-banner" data-aos="fade-up">
                <div class="banner-content">
                    <div class="banner-icon">
                        <i class="fas fa-crown"></i>
                    </div>
                    <div class="banner-text">
                        <h3>You Have an Active Subscription!</h3>
                        <p>You already have access to all paid courses. Continue learning and exploring.</p>
                    </div>
                </div>
                <a href="{{ route('dashboard') }}" class="banner-btn">
                    Go to Dashboard <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            @endif
        @endauth

        <div class="pricing-grid">
            @foreach($plans as $plan)
            <div class="pricing-card {{ $plan->is_popular ? 'popular' : '' }}" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                @if($plan->is_popular)
                <div class="popular-badge">Most Popular</div>
                @endif

                <div class="pricing-card-header">
                    <div class="plan-icon">
                        @if($loop->first)
                        <i class="fas fa-gem"></i>
                        @elseif($loop->last)
                        <i class="fas fa-crown"></i>
                        @else
                        <i class="fas fa-rocket"></i>
                        @endif
                    </div>
                    <h2 class="plan-name">{{ $plan->name }}</h2>
                    <div class="plan-price">
                        ${{ number_format($plan->price, 2) }}<small>/{{ $plan->duration_text }}</small>
                    </div>
                    <p class="plan-description">{{ $plan->description }}</p>
                </div>

                <div class="pricing-card-body">
                    <ul class="feature-list">
                        @foreach($plan->features_list as $feature)
                        <li class="feature-item">
                            <i class="fas fa-check-circle"></i>
                            {{ $feature }}
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="pricing-card-footer">
                    @auth
                        @if(Auth::user()->has_active_subscription)
                            <a href="{{ route('dashboard') }}" class="btn-plan">
                                Already Active <i class="fas fa-check"></i>
                            </a>
                        @else
                            <a href="{{ route('subscription.checkout', $plan->id) }}" class="btn-plan {{ $plan->is_popular ? 'popular-btn' : '' }}">
                                Get Started <i class="fas fa-arrow-right"></i>
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}?redirect={{ route('subscription.checkout', $plan->id) }}" class="btn-plan {{ $plan->is_popular ? 'popular-btn' : '' }}">
                            Login to Subscribe <i class="fas fa-arrow-right"></i>
                        </a>
                    @endauth
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Money-Back Guarantee Section -->
<section class="guarantee-section">
    <div class="container">
        <div class="guarantee-content" data-aos="zoom-in">
            <div class="guarantee-icon">
                <i class="fas fa-shield-alt"></i>
            </div>
            <h2 class="guarantee-title">30-Day Money-Back Guarantee</h2>
            <p class="guarantee-text">
                We're confident you'll love our platform. If you're not completely satisfied within the first 30 days,
                we'll refund your full subscription amount — no questions asked.
            </p>
            <div class="guarantee-badge">
                <i class="fas fa-check-circle"></i>
                100% Risk-Free
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="faq-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-subtitle">Got Questions?</span>
            <h2 class="section-title">Frequently Asked Questions</h2>
        </div>

        <div class="faq-grid" data-aos="fade-up">
            <!-- FAQ Item 1 -->
            <div class="faq-item">
                <div class="faq-question">
                    <span>What does the subscription include?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Your subscription gives you unlimited access to ALL paid courses on our platform. You can learn at your own pace, track your progress, earn certificates upon completion, and get access to new courses as they're added.</p>
                </div>
            </div>

            <!-- FAQ Item 2 -->
            <div class="faq-item">
                <div class="faq-question">
                    <span>How does the subscription work?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Once you purchase a subscription, you get immediate access to all paid courses. You can enroll in as many courses as you want, and your progress is saved automatically. The subscription is valid for the duration you selected (e.g., 1 year).</p>
                </div>
            </div>

            <!-- FAQ Item 3 -->
            <div class="faq-item">
                <div class="faq-question">
                    <span>What payment methods do you accept?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>We accept all major credit cards (Visa, MasterCard, American Express, Discover) and PayPal. All payments are processed securely through Stripe, ensuring your financial information remains protected.</p>
                </div>
            </div>

            <!-- FAQ Item 4 -->
            <div class="faq-item">
                <div class="faq-question">
                    <span>Can I cancel my subscription?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Absolutely! You can cancel your subscription at any time from your dashboard. However, please note that we don't offer partial refunds for unused time. Your access will continue until the end of your subscription period.</p>
                </div>
            </div>

            <!-- FAQ Item 5 -->
            <div class="faq-item">
                <div class="faq-question">
                    <span>What happens after my subscription expires?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>After your subscription expires, you'll lose access to paid courses. However, any progress you've made and certificates you've earned will be saved. You can renew your subscription at any time to regain access.</p>
                </div>
            </div>

            <!-- FAQ Item 6 -->
            <div class="faq-item">
                <div class="faq-question">
                    <span>Do free courses require a subscription?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>No! Free courses are always accessible to everyone, regardless of subscription status. You can enroll in free courses anytime without any payment.</p>
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
        const faqItems = document.querySelectorAll('.faq-item');

        faqItems.forEach(item => {
            const question = item.querySelector('.faq-question');

            question.addEventListener('click', () => {
                // Close other items
                faqItems.forEach(otherItem => {
                    if (otherItem !== item && otherItem.classList.contains('active')) {
                        otherItem.classList.remove('active');
                    }
                });

                // Toggle current item
                item.classList.toggle('active');
            });
        });

        // Animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Apply initial styles and observe pricing cards
        const pricingCards = document.querySelectorAll('.pricing-card');
        pricingCards.forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            observer.observe(card);
        });

        // Observe FAQ items
        const faqElements = document.querySelectorAll('.faq-item');
        faqElements.forEach(item => {
            item.style.opacity = '0';
            item.style.transform = 'translateY(20px)';
            item.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            observer.observe(item);
        });
    });
</script>
@endpush