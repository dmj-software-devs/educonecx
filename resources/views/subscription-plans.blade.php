@extends('layouts.main')

@section('title', 'Subscription Plans - EDUCONECX | Choose Your Plan')

@section('meta_description', 'Choose the perfect subscription plan for your learning journey. Get unlimited access to all paid courses with a single subscription.')

@push('styles')
<style>
    /* Hero Section - Matching main layout */
    .pricing-hero {
        background: var(--gradient-hero);
        position: relative;
        color: var(--pure-white);
        min-height: 50vh;
        display: flex;
        align-items: center;
        overflow: hidden;
        padding: 60px 0;
    }

    .pricing-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: var(--gradient-hero-overlay);
        z-index: 1;
    }

    .pricing-hero .container {
        position: relative;
        z-index: 2;
    }

    .pricing-hero-content {
        text-align: center;
        max-width: 800px;
        margin: 0 auto;
    }

    .pricing-hero-badge {
        display: inline-block;
        padding: 8px 24px;
        background: rgba(251, 198, 12, 0.2);
        border-radius: 30px;
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 25px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(251, 198, 12, 0.3);
        color: var(--bright-amber);
        animation: fadeInDown 0.8s ease-out;
    }

    .pricing-hero-title {
        font-size: clamp(2.5rem, 8vw, 4rem);
        font-weight: 800;
        margin-bottom: 20px;
        line-height: 1.1;
        color: var(--pure-white) !important;
        text-shadow: 0 2px 10px rgba(10, 29, 68, 0.3);
        animation: fadeInUp 0.8s ease-out 0.2s both;
    }

    .pricing-hero-text {
        font-size: clamp(1.1rem, 3vw, 1.3rem);
        opacity: 0.95;
        line-height: 1.8;
        max-width: 700px;
        margin: 0 auto;
        color: var(--pure-white) !important;
        animation: fadeInUp 0.8s ease-out 0.4s both;
    }

    /* Pricing Section */
    .pricing-section {
        padding: 80px 0;
        background: #f8fafc;
        position: relative;
    }

    .pricing-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 30px;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* Clean rectangular cards with better contrast */
    .pricing-card {
        background: #ffffff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        border: 1px solid #eef2f6;
        position: relative;
    }

    .pricing-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(10, 29, 68, 0.12);
        border-color: var(--bright-amber);
    }

    .pricing-card.popular {
        border: 2px solid var(--bright-amber);
        box-shadow: 0 15px 35px rgba(251, 198, 12, 0.15);
        transform: scale(1.02);
        z-index: 2;
    }

    .pricing-card.popular:hover {
        transform: scale(1.02) translateY(-5px);
        box-shadow: 0 25px 45px rgba(251, 198, 12, 0.2);
    }

    .popular-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        background: var(--bright-amber);
        color: var(--prussian-blue);
        padding: 6px 18px;
        border-radius: 30px;
        font-size: 0.8rem;
        font-weight: 700;
        box-shadow: 0 5px 15px rgba(251, 198, 12, 0.3);
        z-index: 3;
        letter-spacing: 0.5px;
    }

    .pricing-card-header {
        padding: 35px 30px 25px;
        text-align: center;
        background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
        border-bottom: 1px solid #eef2f6;
    }

    .plan-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, var(--prussian-blue) 0%, var(--regal-navy) 100%);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        color: var(--bright-amber);
        font-size: 2rem;
        box-shadow: 0 10px 20px rgba(10, 29, 68, 0.15);
    }

    .plan-name {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 10px;
        color: var(--prussian-blue);
    }

    .plan-price {
        font-size: 2.8rem;
        font-weight: 800;
        color: var(--regal-navy);
        margin-bottom: 10px;
        line-height: 1;
    }

    .plan-price small {
        font-size: 1rem;
        font-weight: 500;
        color: #64748b;
    }

    .plan-description {
        color: #64748b;
        font-size: 0.95rem;
        line-height: 1.6;
        max-width: 250px;
        margin: 0 auto;
    }

    .pricing-card-body {
        padding: 30px;
        flex: 1;
        background: #ffffff;
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
        color: #334155;
        font-size: 0.95rem;
        transition: all 0.2s ease;
    }

    .feature-item:hover {
        transform: translateX(5px);
        color: var(--prussian-blue);
    }

    .feature-item i {
        color: var(--bright-amber);
        font-size: 1rem;
        width: 20px;
        text-align: center;
        flex-shrink: 0;
    }

    .pricing-card-footer {
        padding: 0 30px 35px;
        text-align: center;
        background: #ffffff;
    }

    .btn-plan {
        display: inline-block;
        width: 100%;
        padding: 14px 25px;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        background: transparent;
        color: var(--prussian-blue);
        border: 2px solid var(--bright-amber);
        cursor: pointer;
        letter-spacing: 0.3px;
    }

    .btn-plan:hover {
        background: var(--bright-amber);
        color: var(--prussian-blue);
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(251, 198, 12, 0.3);
        border-color: var(--bright-amber);
    }

    .btn-plan.popular-btn {
        background: var(--bright-amber);
        color: var(--prussian-blue);
        border: 2px solid var(--bright-amber);
        font-weight: 700;
    }

    .btn-plan.popular-btn:hover {
        background: #e5b50a;
        border-color: #e5b50a;
        box-shadow: 0 10px 20px rgba(251, 198, 12, 0.4);
    }

    /* Active Subscription Banner */
    .active-subscription-banner {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border-radius: 16px;
        padding: 20px 30px;
        margin-bottom: 40px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 20px;
        box-shadow: 0 15px 30px rgba(16, 185, 129, 0.2);
        color: white;
    }

    .banner-content {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .banner-icon {
        width: 48px;
        height: 48px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .banner-text h3 {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 5px;
        color: white;
    }

    .banner-text p {
        margin: 0;
        opacity: 0.9;
        font-size: 0.95rem;
        color: white;
    }

    .banner-btn {
        background: white;
        color: #059669;
        padding: 12px 30px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .banner-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        color: #047857;
    }

    /* FAQ Section */
    .faq-section {
        padding: 80px 0;
        background: #f8fafc;
        position: relative;
    }

    .section-header {
        text-align: center;
        margin-bottom: 50px;
    }

    .section-subtitle {
        color: var(--bright-amber);
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
        color: var(--prussian-blue);
    }

    .faq-grid {
        max-width: 800px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .faq-item {
        background: #ffffff;
        border-radius: 16px;
        margin-bottom: 15px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.03);
        border: 1px solid #eef2f6;
        transition: all 0.3s ease;
    }

    .faq-item:hover {
        box-shadow: 0 10px 25px rgba(10, 29, 68, 0.08);
        border-color: var(--bright-amber);
    }

    .faq-question {
        padding: 20px 25px;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 600;
        color: var(--prussian-blue);
        font-size: 1.1rem;
        transition: all 0.3s ease;
        background: #ffffff;
    }

    .faq-question:hover {
        background: #f8fafc;
    }

    .faq-question i {
        color: var(--bright-amber);
        transition: all 0.3s ease;
        font-size: 1rem;
    }

    .faq-item.active .faq-question i {
        transform: rotate(180deg);
    }

    .faq-answer {
        padding: 0 25px 25px;
        color: #64748b;
        line-height: 1.8;
        display: none;
        border-top: 1px solid #eef2f6;
        margin-top: 5px;
        background: #ffffff;
    }

    .faq-item.active .faq-answer {
        display: block;
        animation: fadeIn 0.5s ease-out;
    }

    /* Guarantee Section */
    .guarantee-section {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        padding: 80px 0;
        text-align: center;
        position: relative;
        border-top: 1px solid #eef2f6;
        border-bottom: 1px solid #eef2f6;
    }

    .guarantee-content {
        max-width: 800px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .guarantee-icon {
        width: 90px;
        height: 90px;
        background: rgba(251, 198, 12, 0.1);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 30px;
        font-size: 2.5rem;
        color: var(--bright-amber);
        border: 1px solid rgba(251, 198, 12, 0.2);
    }

    .guarantee-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 15px;
        color: var(--prussian-blue);
    }

    .guarantee-text {
        color: #64748b;
        line-height: 1.8;
        font-size: 1.1rem;
    }

    .guarantee-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 10px 25px;
        border-radius: 12px;
        margin-top: 30px;
        font-weight: 600;
        border: none;
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);
    }

    /* Comparison Table */
    .comparison-section {
        padding: 80px 0;
        background: #ffffff;
    }

    .comparison-table {
        background: #ffffff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(10, 29, 68, 0.08);
        border: 1px solid #eef2f6;
        max-width: 1000px;
        margin: 0 auto;
    }

    .comparison-row {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr;
        border-bottom: 1px solid #eef2f6;
    }

    .comparison-row:last-child {
        border-bottom: none;
    }

    .comparison-row.header {
        background: var(--prussian-blue);
        color: white;
        font-weight: 600;
    }

    .comparison-cell {
        padding: 18px 20px;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #334155;
    }

    .comparison-cell:first-child {
        text-align: left;
        justify-content: flex-start;
        font-weight: 500;
        color: var(--prussian-blue);
        padding-left: 25px;
    }

    .comparison-row.header .comparison-cell {
        color: white;
        font-weight: 600;
        padding: 18px 20px;
    }

    .comparison-cell i.fa-check {
        color: #10b981;
        font-size: 1.2rem;
    }

    .comparison-cell i.fa-times {
        color: #94a3b8;
        font-size: 1.2rem;
    }

    @media (max-width: 768px) {
        .comparison-row {
            grid-template-columns: 1fr;
            gap: 10px;
            padding: 20px;
        }

        .comparison-cell {
            padding: 10px;
            justify-content: flex-start;
        }

        .comparison-cell:first-child {
            font-weight: 700;
            color: var(--bright-amber);
            padding-left: 10px;
        }

        .comparison-row.header {
            display: none;
        }
    }

    /* Animations */
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
            transform: translateY(-5px);
        }
    }

    @media (max-width: 768px) {
        .pricing-hero {
            min-height: 40vh;
            padding: 40px 0;
        }
        
        .pricing-grid {
            grid-template-columns: 1fr;
            gap: 25px;
        }
        
        .plan-price {
            font-size: 2.5rem;
        }
        
        .faq-question {
            padding: 18px 20px;
            font-size: 1rem;
        }
        
        .active-subscription-banner {
            padding: 20px;
        }
        
        .banner-content {
            flex: 1 1 100%;
        }
        
        .banner-btn {
            width: 100%;
            justify-content: center;
        }

        .pricing-card-header {
            padding: 30px 25px 20px;
        }

        .pricing-card-body {
            padding: 25px;
        }

        .pricing-card-footer {
            padding: 0 25px 30px;
        }
    }

    @media (max-width: 576px) {
        .pricing-hero {
            padding: 30px 0;
        }
        
        .pricing-card-header {
            padding: 25px 20px 15px;
        }
        
        .plan-icon {
            width: 60px;
            height: 60px;
            font-size: 1.8rem;
            border-radius: 14px;
        }
        
        .plan-name {
            font-size: 1.6rem;
        }
        
        .pricing-card-body {
            padding: 20px;
        }
        
        .pricing-card-footer {
            padding: 0 20px 25px;
        }
        
        .btn-plan {
            padding: 12px 20px;
            font-size: 0.95rem;
        }

        .popular-badge {
            top: 15px;
            right: 15px;
            padding: 5px 15px;
            font-size: 0.75rem;
        }
    }

    /* Loading State */
    .btn-plan.loading {
        pointer-events: none;
        opacity: 0.8;
        position: relative;
    }

    .btn-plan.loading i {
        animation: spin 1s infinite linear;
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="pricing-hero">
    <div class="container">
        <div class="pricing-hero-content">
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
                            <span>{{ $feature }}</span>
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

<!-- Plan Comparison Section -->
<!-- <section class="comparison-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-subtitle">Compare Plans</span>
            <h2 class="section-title">Find Your Perfect Match</h2>
        </div>

        <div class="comparison-table" data-aos="fade-up">
            <div class="comparison-row header">
                <div class="comparison-cell">Features</div>
                <div class="comparison-cell">Basic</div>
                <div class="comparison-cell">Pro</div>
                <div class="comparison-cell">Enterprise</div>
            </div>
            <div class="comparison-row">
                <div class="comparison-cell">Access to All Paid Courses</div>
                <div class="comparison-cell"><i class="fas fa-check"></i></div>
                <div class="comparison-cell"><i class="fas fa-check"></i></div>
                <div class="comparison-cell"><i class="fas fa-check"></i></div>
            </div>
            <div class="comparison-row">
                <div class="comparison-cell">Certificate of Completion</div>
                <div class="comparison-cell"><i class="fas fa-check"></i></div>
                <div class="comparison-cell"><i class="fas fa-check"></i></div>
                <div class="comparison-cell"><i class="fas fa-check"></i></div>
            </div>
            <div class="comparison-row">
                <div class="comparison-cell">Progress Tracking</div>
                <div class="comparison-cell"><i class="fas fa-check"></i></div>
                <div class="comparison-cell"><i class="fas fa-check"></i></div>
                <div class="comparison-cell"><i class="fas fa-check"></i></div>
            </div>
            <div class="comparison-row">
                <div class="comparison-cell">Priority Support</div>
                <div class="comparison-cell"><i class="fas fa-times"></i></div>
                <div class="comparison-cell"><i class="fas fa-check"></i></div>
                <div class="comparison-cell"><i class="fas fa-check"></i></div>
            </div>
            <div class="comparison-row">
                <div class="comparison-cell">1-on-1 Mentoring</div>
                <div class="comparison-cell"><i class="fas fa-times"></i></div>
                <div class="comparison-cell"><i class="fas fa-times"></i></div>
                <div class="comparison-cell"><i class="fas fa-check"></i></div>
            </div>
            <div class="comparison-row">
                <div class="comparison-cell">Downloadable Resources</div>
                <div class="comparison-cell"><i class="fas fa-check"></i></div>
                <div class="comparison-cell"><i class="fas fa-check"></i></div>
                <div class="comparison-cell"><i class="fas fa-check"></i></div>
            </div>
        </div>
    </div>
</section> -->

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
        // Check if user prefers reduced motion
        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        
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

        // Animation on scroll with reduced motion support
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    if (!prefersReducedMotion) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    } else {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'none';
                    }
                }
            });
        }, observerOptions);

        // Apply initial styles and observe pricing cards (only if not reduced motion)
        if (!prefersReducedMotion) {
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

            // Observe comparison table
            const comparisonTable = document.querySelector('.comparison-table');
            if (comparisonTable) {
                comparisonTable.style.opacity = '0';
                comparisonTable.style.transform = 'translateY(20px)';
                comparisonTable.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                observer.observe(comparisonTable);
            }
        }

        // Add loading state to plan buttons on click
        const planButtons = document.querySelectorAll('.btn-plan');
        planButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                if (!this.classList.contains('processing') && !this.classList.contains('loading')) {
                    this.classList.add('processing', 'loading');
                    const originalContent = this.innerHTML;
                    this.innerHTML = '<i class="fas fa-spinner"></i> Processing...';
                    
                    // Store original content to restore if needed (though we're navigating away)
                    this.dataset.originalContent = originalContent;
                }
            });
        });
    });
</script>
@endpush