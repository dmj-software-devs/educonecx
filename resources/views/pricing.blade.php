@extends('layouts.main')

@section('title', 'Pricing Plans - EDUCONECX | Choose Your Learning Path')

@section('meta_description', 'Choose the perfect learning plan for your journey. From free access to premium features, find the option that fits your goals and budget.')

@push('styles')
<style>
    /* Hero Section */
    .pricing-hero {
        position: relative;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 100px 0;
        overflow: hidden;
        color: var(--white);
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
        top: -100px;
        right: -100px;
        animation: float 8s ease-in-out infinite;
    }

    .pricing-hero-particle:nth-child(2) {
        width: 200px;
        height: 200px;
        bottom: -50px;
        left: -50px;
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
        border-radius: var(--border-radius-full);
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

    /* Toggle Section */
    .pricing-toggle-section {
        margin-top: -40px;
        position: relative;
        z-index: 10;
        margin-bottom: 60px;
    }

    .pricing-toggle-container {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 20px;
        background: var(--white);
        padding: 15px 30px;
        border-radius: 60px;
        box-shadow: var(--shadow-lg);
        max-width: 400px;
        margin: 0 auto;
    }

    .toggle-label {
        font-weight: 600;
        color: var(--gray);
        transition: var(--transition);
        cursor: pointer;
    }

    .toggle-label.active {
        color: var(--primary);
    }

    .toggle-switch {
        width: 60px;
        height: 30px;
        background: var(--gray-light);
        border-radius: 30px;
        position: relative;
        cursor: pointer;
        transition: var(--transition);
    }

    .toggle-switch::before {
        content: '';
        position: absolute;
        width: 26px;
        height: 26px;
        background: var(--white);
        border-radius: 50%;
        top: 2px;
        left: 2px;
        transition: var(--transition);
        box-shadow: var(--shadow-sm);
    }

    .toggle-switch.monthly::before {
        transform: translateX(0);
    }

    .toggle-switch.yearly::before {
        transform: translateX(30px);
    }

    .toggle-switch.monthly {
        background: var(--primary);
    }

    .toggle-badge {
        background: var(--success);
        color: var(--white);
        padding: 4px 10px;
        border-radius: var(--border-radius-full);
        font-size: 0.7rem;
        font-weight: 600;
        margin-left: 10px;
    }

    /* Pricing Section */
    .pricing-section {
        padding: 60px 0;
        background: var(--light);
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
        background: var(--white);
        border-radius: var(--border-radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-lg);
        transition: var(--transition);
        position: relative;
        display: flex;
        flex-direction: column;
        height: 100%;
        border: 2px solid transparent;
    }

    .pricing-card:hover {
        transform: translateY(-15px);
        box-shadow: var(--shadow-hover);
    }

    .pricing-card.popular {
        border-color: var(--primary);
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
        background: var(--gradient-1);
        color: var(--white);
        padding: 8px 20px;
        border-radius: var(--border-radius-full);
        font-size: 0.85rem;
        font-weight: 600;
        animation: pulse 2s infinite;
        box-shadow: var(--shadow-md);
        z-index: 3;
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(67, 97, 238, 0.4);
        }

        70% {
            box-shadow: 0 0 0 15px rgba(67, 97, 238, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(67, 97, 238, 0);
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
        background: rgba(67, 97, 238, 0.05);
        border-radius: 50%;
    }

    .plan-icon {
        width: 70px;
        height: 70px;
        background: var(--gradient-1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        color: var(--white);
        font-size: 2rem;
        box-shadow: var(--shadow-md);
    }

    .plan-name {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 15px;
        color: var(--dark);
    }

    .plan-price {
        font-size: 3rem;
        font-weight: 800;
        color: var(--primary);
        margin-bottom: 10px;
        line-height: 1;
    }

    .plan-price small {
        font-size: 1rem;
        font-weight: 400;
        color: var(--gray);
    }

    .plan-price .original-price {
        font-size: 1.2rem;
        color: var(--gray);
        text-decoration: line-through;
        margin-left: 10px;
        font-weight: 400;
    }

    .plan-description {
        color: var(--gray);
        font-size: 0.95rem;
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
        color: var(--gray);
        font-size: 0.95rem;
        transition: var(--transition);
    }

    .feature-item:hover {
        transform: translateX(5px);
        color: var(--dark);
    }

    .feature-item i {
        color: var(--primary);
        font-size: 1rem;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(67, 97, 238, 0.1);
        border-radius: 50%;
        padding: 4px;
    }

    .feature-item.disabled {
        opacity: 0.5;
    }

    .feature-item.disabled i {
        color: var(--gray);
        background: var(--light);
    }

    .pricing-card-footer {
        padding: 0 30px 40px;
        text-align: center;
    }

    .btn-plan {
        display: inline-block;
        width: 100%;
        padding: 16px 30px;
        border-radius: var(--border-radius-full);
        font-size: 1.1rem;
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
        background: transparent;
        color: var(--primary);
        border: 2px solid var(--primary);
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
        background: var(--primary);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
        z-index: -1;
    }

    .btn-plan:hover::before {
        width: 300px;
        height: 300px;
    }

    .btn-plan:hover {
        color: var(--white);
        border-color: var(--primary);
    }

    .btn-plan.popular-btn {
        background: var(--primary);
        color: var(--white);
    }

    .btn-plan.popular-btn::before {
        background: rgba(255, 255, 255, 0.2);
    }

    .btn-plan.popular-btn:hover {
        background: var(--primary-dark);
        border-color: var(--primary-dark);
    }

    /* Free Plan Specific */
    .pricing-card.free .plan-icon {
        background: var(--success);
    }

    .pricing-card.free .plan-price {
        color: var(--success);
    }

    .pricing-card.free .feature-item i {
        color: var(--success);
        background: rgba(40, 167, 69, 0.1);
    }

    .pricing-card.free .btn-plan {
        border-color: var(--success);
        color: var(--success);
    }

    .pricing-card.free .btn-plan::before {
        background: var(--success);
    }

    /* Pro Plan Specific */
    .pricing-card.pro .plan-icon {
        background: var(--primary);
    }

    .pricing-card.pro .plan-price {
        color: var(--primary);
    }

    /* VIP Plan Specific */
    .pricing-card.vip .plan-icon {
        background: linear-gradient(135deg, #6f42c1 0%, #8e44ad 100%);
    }

    .pricing-card.vip .plan-price {
        color: #6f42c1;
    }

    .pricing-card.vip .feature-item i {
        color: #6f42c1;
        background: rgba(111, 66, 193, 0.1);
    }

    .pricing-card.vip .btn-plan {
        border-color: #6f42c1;
        color: #6f42c1;
    }

    .pricing-card.vip .btn-plan::before {
        background: #6f42c1;
    }

    /* Enterprise Card */
    .enterprise-card {
        background: var(--gradient-1);
        color: var(--white);
        padding: 40px;
        border-radius: var(--border-radius-lg);
        text-align: center;
        max-width: 800px;
        margin: 60px auto 0;
        position: relative;
        overflow: hidden;
    }

    .enterprise-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 10s ease-in-out infinite;
    }

    .enterprise-card h3 {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 15px;
        position: relative;
        z-index: 2;
    }

    .enterprise-card p {
        font-size: 1.2rem;
        opacity: 0.9;
        margin-bottom: 25px;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
        position: relative;
        z-index: 2;
    }

    .enterprise-btn {
        display: inline-block;
        padding: 15px 40px;
        background: var(--white);
        color: var(--primary);
        border-radius: var(--border-radius-full);
        text-decoration: none;
        font-weight: 600;
        font-size: 1.1rem;
        transition: var(--transition);
        position: relative;
        z-index: 2;
    }

    .enterprise-btn:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-lg);
        background: transparent;
        color: var(--white);
        border: 2px solid var(--white);
        padding: 13px 38px;
    }

    /* Guarantee Section */
    .guarantee-section {
        background: var(--white);
        padding: 80px 0;
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
        background: rgba(67, 97, 238, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 30px;
        font-size: 3rem;
        color: var(--primary);
        animation: float 6s ease-in-out infinite;
    }

    .guarantee-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 20px;
        color: var(--dark);
    }

    .guarantee-text {
        color: var(--gray);
        line-height: 1.8;
        font-size: 1.1rem;
    }

    .guarantee-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--success);
        color: var(--white);
        padding: 8px 20px;
        border-radius: var(--border-radius-full);
        margin-top: 30px;
        font-weight: 600;
    }

    /* FAQ Section */
    .faq-pricing-section {
        padding: 80px 0;
        background: var(--light);
    }

    .section-header {
        text-align: center;
        margin-bottom: 50px;
    }

    .section-subtitle {
        color: var(--primary);
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
        color: var(--dark);
    }

    .faq-pricing-grid {
        max-width: 800px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .faq-pricing-item {
        background: var(--white);
        border-radius: var(--border-radius-lg);
        margin-bottom: 15px;
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
    }

    .faq-pricing-item:hover {
        box-shadow: var(--shadow-md);
    }

    .faq-pricing-question {
        padding: 22px 25px;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 600;
        color: var(--dark);
        font-size: 1.1rem;
        transition: var(--transition);
    }

    .faq-pricing-question:hover {
        background: rgba(67, 97, 238, 0.02);
    }

    .faq-pricing-question i {
        color: var(--primary);
        transition: var(--transition);
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--light);
        border-radius: 50%;
    }

    .faq-pricing-item.active .faq-pricing-question i {
        transform: rotate(180deg);
        background: var(--primary);
        color: var(--white);
    }

    .faq-pricing-answer {
        padding: 0 25px 25px;
        color: var(--gray);
        line-height: 1.8;
        display: none;
        border-top: 1px solid var(--gray-light);
        margin-top: 5px;
    }

    .faq-pricing-item.active .faq-pricing-answer {
        display: block;
        animation: fadeIn 0.5s ease-out;
    }

    /* Comparison Table */
    .comparison-section {
        padding: 60px 0;
        background: var(--white);
    }

    .comparison-table {
        max-width: 1000px;
        margin: 0 auto;
        overflow-x: auto;
        padding: 0 20px;
    }

    .comparison-table table {
        width: 100%;
        border-collapse: collapse;
        background: var(--white);
        border-radius: var(--border-radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-lg);
    }

    .comparison-table th {
        background: var(--gradient-1);
        color: var(--white);
        padding: 20px;
        font-size: 1.1rem;
        font-weight: 600;
        text-align: center;
    }

    .comparison-table td {
        padding: 15px 20px;
        border-bottom: 1px solid var(--gray-light);
        color: var(--gray);
    }

    .comparison-table tr:last-child td {
        border-bottom: none;
    }

    .comparison-table .feature-name {
        font-weight: 600;
        color: var(--dark);
    }

    .comparison-table .feature-check {
        color: var(--success);
        font-size: 1.2rem;
    }

    .comparison-table .feature-times {
        color: var(--danger);
        font-size: 1.2rem;
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

        .pricing-toggle-container {
            padding: 12px 20px;
        }

        .pricing-grid {
            grid-template-columns: 1fr;
            gap: 30px;
        }

        .plan-price {
            font-size: 2.5rem;
        }

        .guarantee-title {
            font-size: 2rem;
        }

        .faq-pricing-question {
            padding: 18px 20px;
            font-size: 1rem;
        }

        .enterprise-card {
            padding: 30px 20px;
            margin: 40px 20px 0;
        }

        .enterprise-card h3 {
            font-size: 1.8rem;
        }

        .enterprise-card p {
            font-size: 1rem;
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
        <div class="pricing-hero-content">
            <span class="pricing-hero-badge">Simple & Transparent Pricing</span>
            <h1 class="pricing-hero-title">Choose Your Learning Path</h1>
            <p class="pricing-hero-text">
                Select the perfect plan for your journey. From free access to premium features,
                find the option that fits your goals and budget.
            </p>
        </div>
    </div>
</section>

<!-- Billing Toggle -->
<div class="pricing-toggle-section">
    <div class="pricing-toggle-container" data-aos="fade-up">
        <span class="toggle-label active" id="monthlyLabel">Monthly</span>
        <div class="toggle-switch monthly" id="billingToggle"></div>
        <span class="toggle-label" id="yearlyLabel">Yearly <span class="toggle-badge">Save 20%</span></span>
    </div>
</div>

<!-- Pricing Section -->
<section class="pricing-section">
    <div class="container">
        <div class="pricing-grid">
            @foreach($plans as $key => $plan)
            <div class="pricing-card 
                        {{ $key }} 
                        {{ ($plan['popular'] ?? false) ? 'popular' : '' }}
                        {{ ($plan['highlight'] ?? false) ? 'popular' : '' }}
                    " data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">

                @if($plan['popular'] ?? false)
                <div class="popular-badge">Most Popular</div>
                @endif

                <div class="pricing-card-header">
                    <div class="plan-icon">
                        @if($key == 'free')
                        <i class="fas fa-gift"></i>
                        @elseif($key == 'pro')
                        <i class="fas fa-rocket"></i>
                        @elseif($key == 'vip')
                        <i class="fas fa-crown"></i>
                        @else
                        <i class="fas fa-user"></i>
                        @endif
                    </div>
                    <h2 class="plan-name">{{ $plan['name'] }}</h2>
                    <div class="plan-price monthly-price">
                        @if($plan['price'] == 0)
                        Free
                        @else
                        ${{ $plan['price'] }}<small>/month</small>
                        @if(isset($plan['original_price']))
                        <span class="original-price">${{ $plan['original_price'] }}</span>
                        @endif
                        @endif
                    </div>
                    <div class="plan-price yearly-price" style="display: none;">
                        @if($plan['price'] == 0)
                        Free
                        @else
                        ${{ $plan['price'] * 12 * 0.8 }}<small>/year</small>
                        @if(isset($plan['original_price']))
                        <span class="original-price">${{ $plan['original_price'] * 12 }}</span>
                        @endif
                        @endif
                    </div>
                    <p class="plan-description">{{ $plan['description'] }}</p>
                </div>

                <div class="pricing-card-body">
                    <ul class="feature-list">
                        @foreach($plan['features'] as $feature)
                        <li class="feature-item">
                            <i class="fas fa-check"></i>
                            {{ $feature }}
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="pricing-card-footer">
                    <a href="{{ $plan['button_url'] }}"
                        class="btn-plan {{ ($plan['highlight'] ?? false) ? 'popular-btn' : '' }}">
                        {{ $plan['button_text'] }}
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Enterprise Section -->
        <div class="enterprise-card" data-aos="fade-up">
            <h3>Need a Custom Solution?</h3>
            <p>Contact our sales team for enterprise pricing and custom plans for your organization.</p>
            <a href="{{ route('contact') }}" class="enterprise-btn">
                <i class="fas fa-headset"></i> Contact Sales
            </a>
        </div>
    </div>
</section>

<!-- Feature Comparison -->
<section class="comparison-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-subtitle">Compare Plans</span>
            <h2 class="section-title">Find the Perfect Fit</h2>
        </div>

        <div class="comparison-table" data-aos="fade-up">
            <table>
                <thead>
                    <tr>
                        <th>Features</th>
                        <th>Free</th>
                        <th>Pro</th>
                        <th>VIP</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="feature-name">Course Access</td>
                        <td><i class="fas fa-check feature-check"></i> Limited</td>
                        <td><i class="fas fa-check feature-check"></i> Full</td>
                        <td><i class="fas fa-check feature-check"></i> Full + VIP</td>
                    </tr>
                    <tr>
                        <td class="feature-name">AI Companion</td>
                        <td><i class="fas fa-times feature-times"></i></td>
                        <td><i class="fas fa-check feature-check"></i> Basic</td>
                        <td><i class="fas fa-check feature-check"></i> Premium</td>
                    </tr>
                    <tr>
                        <td class="feature-name">Certificates</td>
                        <td><i class="fas fa-times feature-times"></i></td>
                        <td><i class="fas fa-check feature-check"></i> Included</td>
                        <td><i class="fas fa-check feature-check"></i> Included</td>
                    </tr>
                    <tr>
                        <td class="feature-name">Priority Support</td>
                        <td><i class="fas fa-times feature-times"></i></td>
                        <td><i class="fas fa-times feature-times"></i></td>
                        <td><i class="fas fa-check feature-check"></i> 24/7</td>
                    </tr>
                    <tr>
                        <td class="feature-name">Download Resources</td>
                        <td><i class="fas fa-times feature-times"></i></td>
                        <td><i class="fas fa-check feature-check"></i> Limited</td>
                        <td><i class="fas fa-check feature-check"></i> Unlimited</td>
                    </tr>
                </tbody>
            </table>
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
                We're confident you'll love our courses. If you're not completely satisfied within the first 30 days,
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
<section class="faq-pricing-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-subtitle">Got Questions?</span>
            <h2 class="section-title">Frequently Asked Questions</h2>
        </div>

        <div class="faq-pricing-grid" data-aos="fade-up">
            <!-- FAQ Item 1 -->
            <div class="faq-pricing-item">
                <div class="faq-pricing-question">
                    <span>Can I switch plans later?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-pricing-answer">
                    <p>Yes, you can upgrade or downgrade your plan at any time. Changes will be reflected in your next billing cycle. If you upgrade, you'll get immediate access to new features.</p>
                </div>
            </div>

            <!-- FAQ Item 2 -->
            <div class="faq-pricing-item">
                <div class="faq-pricing-question">
                    <span>What payment methods do you accept?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-pricing-answer">
                    <p>We accept all major credit cards (Visa, MasterCard, American Express, Discover) and PayPal. All payments are processed securely through Stripe, ensuring your financial information remains protected.</p>
                </div>
            </div>

            <!-- FAQ Item 3 -->
            <div class="faq-pricing-item">
                <div class="faq-pricing-question">
                    <span>Is there a free trial?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-pricing-answer">
                    <p>Yes! We offer a 3-day free trial on all paid plans. You can explore our courses and features risk-free before committing. No credit card required for the trial.</p>
                </div>
            </div>

            <!-- FAQ Item 4 -->
            <div class="faq-pricing-item">
                <div class="faq-pricing-question">
                    <span>Can I cancel my subscription?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-pricing-answer">
                    <p>Absolutely. You can cancel your subscription at any time from your dashboard. Your access will continue until the end of your billing period, and you won't be charged again.</p>
                </div>
            </div>

            <!-- FAQ Item 5 -->
            <div class="faq-pricing-item">
                <div class="faq-pricing-question">
                    <span>Do you offer student or group discounts?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-pricing-answer">
                    <p>Yes, we offer special pricing for students and groups. Please contact our sales team at <a href="mailto:sales@educonecx.com">sales@educonecx.com</a> for more information and custom quotes.</p>
                </div>
            </div>

            <!-- FAQ Item 6 -->
            <div class="faq-pricing-item">
                <div class="faq-pricing-question">
                    <span>What happens after I cancel?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-pricing-answer">
                    <p>After cancellation, you'll retain access to your courses until the end of your current billing period. Your progress and certificates will be saved if you decide to resubscribe later.</p>
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
        const faqItems = document.querySelectorAll('.faq-pricing-item');

        faqItems.forEach(item => {
            const question = item.querySelector('.faq-pricing-question');

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

        // Billing Toggle (Monthly/Yearly)
        const billingToggle = document.getElementById('billingToggle');
        const monthlyLabel = document.getElementById('monthlyLabel');
        const yearlyLabel = document.getElementById('yearlyLabel');
        const monthlyPrices = document.querySelectorAll('.monthly-price');
        const yearlyPrices = document.querySelectorAll('.yearly-price');

        let isMonthly = true;

        function updateBilling() {
            if (isMonthly) {
                monthlyPrices.forEach(price => price.style.display = 'block');
                yearlyPrices.forEach(price => price.style.display = 'none');
                billingToggle.classList.remove('yearly');
                billingToggle.classList.add('monthly');
                monthlyLabel.classList.add('active');
                yearlyLabel.classList.remove('active');
            } else {
                monthlyPrices.forEach(price => price.style.display = 'none');
                yearlyPrices.forEach(price => price.style.display = 'block');
                billingToggle.classList.remove('monthly');
                billingToggle.classList.add('yearly');
                monthlyLabel.classList.remove('active');
                yearlyLabel.classList.add('active');
            }
        }

        billingToggle.addEventListener('click', () => {
            isMonthly = !isMonthly;
            updateBilling();
        });

        monthlyLabel.addEventListener('click', () => {
            isMonthly = true;
            updateBilling();
        });

        yearlyLabel.addEventListener('click', () => {
            isMonthly = false;
            updateBilling();
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
        const faqElements = document.querySelectorAll('.faq-pricing-item');
        faqElements.forEach(item => {
            item.style.opacity = '0';
            item.style.transform = 'translateY(20px)';
            item.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            observer.observe(item);
        });
    });
</script>
@endpush