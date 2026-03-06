@extends('layouts.main')

@section('title', App\Helpers\TranslationHelper::trans('contact.title'))

@section('meta_description', App\Helpers\TranslationHelper::trans('contact.meta_description'))

@section('content')
<style>
    /* Root Variables - Your Beautiful Colors */
    :root {
        --bright-amber: #FBC60C;
        --khaki-beige: #9F9A87;
        --pure-white: #FEFDFE;
        --prussian-blue: #0A1D44;
        --regal-navy: #18386E;
        --sky-blue: #5AD1E4;
        --pale-slate: #CBD1DA;
        --dark-slate: #2E5C61;
        --ivory: #F9F7E9;
        --light-gold: #EBD789;
        
        /* Extended Palette */
        --primary: var(--regal-navy);
        --primary-dark: var(--prussian-blue);
        --primary-light: var(--dark-slate);
        --secondary: var(--sky-blue);
        --accent: var(--bright-amber);
        --accent-soft: var(--light-gold);
        --success: var(--sky-blue);
        --warning: var(--bright-amber);
        
        /* Text Colors */
        --text-primary: #0A1D44;
        --text-secondary: #2E5C61;
        --text-muted: #5f5f5f;
        --text-light: #FEFDFE;
        
        /* Gradients */
        --gradient-1: linear-gradient(135deg, #0A1D44 0%, #18386E 50%, #2E5C61 100%);
        --gradient-2: linear-gradient(45deg, #FBC60C 0%, #EBD789 50%, #F9F7E9 100%);
        --gradient-3: linear-gradient(135deg, #5AD1E4 0%, #CBD1DA 50%, #FEFDFE 100%);
        
        /* Shadows */
        --shadow-sm: 0 2px 8px rgba(10, 29, 68, 0.08);
        --shadow-md: 0 4px 12px rgba(10, 29, 68, 0.12);
        --shadow-lg: 0 8px 24px rgba(10, 29, 68, 0.15);
        --shadow-hover: 0 12px 28px rgba(251, 198, 12, 0.2);
        
        /* Border Radius */
        --radius-sm: 8px;
        --radius-md: 12px;
        --radius-lg: 16px;
        --radius-xl: 24px;
        --radius-full: 9999px;
        
        /* Transitions */
        --transition: all 0.3s ease;
    }

    /* Hero Section */
    .contact-page-hero {
        position: relative;
        background: var(--gradient-1);
        padding: 100px 0;
        overflow: hidden;
        color: var(--pure-white);
    }

    .contact-page-particles {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    .contact-page-particle {
        position: absolute;
        background: rgba(251, 198, 12, 0.1);
        border-radius: 50%;
    }

    .contact-page-particle:nth-child(1) {
        width: 300px;
        height: 300px;
        top: -100px;
        right: -100px;
        animation: contact-page-float 8s ease-in-out infinite;
    }

    .contact-page-particle:nth-child(2) {
        width: 200px;
        height: 200px;
        bottom: -50px;
        left: -50px;
        background: rgba(90, 209, 228, 0.1);
        animation: contact-page-float 10s ease-in-out infinite reverse;
    }

    .contact-page-particle:nth-child(3) {
        width: 150px;
        height: 150px;
        top: 30%;
        left: 20%;
        background: rgba(235, 215, 137, 0.1);
        animation: contact-page-float 12s ease-in-out infinite;
    }

    .contact-page-hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
        max-width: 800px;
        margin: 0 auto;
    }

    .contact-page-hero-badge {
        display: inline-block;
        padding: 8px 20px;
        background: rgba(254, 253, 254, 0.2);
        border-radius: var(--radius-full);
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 25px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(251, 198, 12, 0.3);
        animation: contact-page-fadeInDown 1s ease-out;
        color: var(--pure-white);
    }

    .contact-page-hero-title {
        font-size: clamp(2.5rem, 8vw, 4rem) !important;
        font-weight: 800 !important;
        margin-bottom: 20px !important;
        line-height: 1.1 !important;
        text-shadow: 0 2px 10px rgba(10, 29, 68, 0.3);
        animation: contact-page-fadeInUp 1s ease-out 0.2s both;
        color: var(--pure-white) !important;
    }

    .contact-page-hero-title span {
        color: var(--bright-amber) !important;
    }

    .contact-page-hero-text {
        font-size: clamp(1.1rem, 3vw, 1.3rem) !important;
        opacity: 0.95;
        line-height: 1.8 !important;
        max-width: 700px;
        margin: 0 auto;
        animation: contact-page-fadeInUp 1s ease-out 0.4s both;
        color: var(--ivory) !important;
    }

    /* Contact Section */
    .contact-page-section {
        padding: 80px 0;
        background: var(--ivory);
    }

    .contact-page-grid {
        display: grid;
        grid-template-columns: 1fr 1.2fr;
        gap: 40px;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Contact Info Cards */
    .contact-page-info-wrapper {
        display: flex;
        flex-direction: column;
        gap: 30px;
    }

    .contact-page-info-card {
        background: var(--pure-white);
        border-radius: var(--radius-lg);
        padding: 40px;
        box-shadow: var(--shadow-lg);
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(251, 198, 12, 0.1);
    }

    .contact-page-info-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 5px;
        height: 100%;
        background: var(--gradient-2);
    }

    .contact-page-info-icon {
        width: 60px;
        height: 60px;
        background: var(--gradient-1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 25px;
        color: var(--pure-white);
        font-size: 1.5rem;
        transition: var(--transition);
    }

    .contact-page-info-card:hover .contact-page-info-icon {
        background: var(--gradient-2);
        color: var(--prussian-blue);
        transform: scale(1.1);
    }

    .contact-page-info-title {
        font-size: 1.8rem !important;
        font-weight: 700 !important;
        margin-bottom: 15px !important;
        color: var(--text-primary) !important;
    }

    .contact-page-info-description {
        color: var(--text-muted) !important;
        line-height: 1.8 !important;
        margin-bottom: 30px !important;
    }

    .contact-page-info-list {
        list-style: none;
        padding: 0;
        margin-bottom: 30px;
    }

    .contact-page-info-list li {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 20px;
        color: var(--text-muted);
        font-size: 1rem;
        transition: var(--transition);
    }

    .contact-page-info-list li:hover {
        transform: translateX(5px);
    }

    .contact-page-info-list li i {
        width: 40px;
        height: 40px;
        background: var(--ivory);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--bright-amber);
        font-size: 1.1rem;
        transition: var(--transition);
    }

    .contact-page-info-list li:hover i {
        background: var(--gradient-2);
        color: var(--prussian-blue);
    }

    .contact-page-info-list li a,
    .contact-page-info-list li span {
        color: var(--text-muted);
        text-decoration: none;
        flex: 1;
    }

    .contact-page-info-list li a:hover {
        color: var(--bright-amber);
    }

    .contact-page-info-highlights {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid rgba(251, 198, 12, 0.2);
    }

    .contact-page-info-highlights h4 {
        font-size: 1.1rem !important;
        font-weight: 600 !important;
        color: var(--text-primary) !important;
        margin-bottom: 15px !important;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .contact-page-info-highlights h4 i {
        color: var(--bright-amber);
    }

    .contact-page-info-highlights ul {
        list-style: none;
        padding: 0;
    }

    .contact-page-info-highlights ul li {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
        color: var(--text-muted);
    }

    .contact-page-info-highlights ul li i {
        color: var(--sky-blue);
    }

    /* Business Hours */
    .contact-page-hours-card {
        background: var(--pure-white);
        border-radius: var(--radius-lg);
        padding: 40px;
        box-shadow: var(--shadow-lg);
        border: 1px solid rgba(251, 198, 12, 0.1);
    }

    .contact-page-hours-title {
        font-size: 1.5rem !important;
        font-weight: 700 !important;
        margin-bottom: 25px !important;
        color: var(--text-primary) !important;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .contact-page-hours-title i {
        color: var(--bright-amber);
    }

    .contact-page-hours-grid {
        display: grid;
        gap: 15px;
    }

    .contact-page-hours-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid rgba(251, 198, 12, 0.2);
    }

    .contact-page-hours-item:last-child {
        border-bottom: none;
    }

    .contact-page-hours-day {
        font-weight: 600;
        color: var(--text-primary);
    }

    .contact-page-hours-time {
        color: var(--bright-amber);
        font-weight: 500;
    }

    .contact-page-hours-note {
        margin-top: 20px;
        padding: 15px;
        background: var(--ivory);
        border-radius: var(--radius-md);
        color: var(--text-muted);
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 10px;
        border-left: 4px solid var(--bright-amber);
    }

    .contact-page-hours-note i {
        color: var(--bright-amber);
    }

    /* Social Links */
    .contact-page-social-card {
        background: var(--pure-white);
        border-radius: var(--radius-lg);
        padding: 30px;
        box-shadow: var(--shadow-lg);
        text-align: center;
        border: 1px solid rgba(251, 198, 12, 0.1);
    }

    .contact-page-social-title {
        font-size: 1.3rem !important;
        font-weight: 700 !important;
        margin-bottom: 20px !important;
        color: var(--text-primary) !important;
    }

    .contact-page-social-grid {
        display: flex;
        justify-content: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    .contact-page-social-link {
        width: 50px;
        height: 50px;
        background: var(--ivory);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--bright-amber);
        font-size: 1.3rem;
        transition: var(--transition);
        text-decoration: none;
    }

    .contact-page-social-link:hover {
        background: var(--gradient-2);
        color: var(--prussian-blue);
        transform: translateY(-5px);
    }

    /* Contact Form */
    .contact-page-form-container {
        background: var(--pure-white);
        border-radius: var(--radius-lg);
        padding: 50px;
        box-shadow: var(--shadow-lg);
        border: 1px solid rgba(251, 198, 12, 0.1);
    }

    .contact-page-form-header {
        margin-bottom: 35px;
        text-align: center;
    }

    .contact-page-form-title {
        font-size: 2rem !important;
        font-weight: 700 !important;
        margin-bottom: 10px !important;
        color: var(--text-primary) !important;
    }

    .contact-page-form-title span {
        color: var(--bright-amber);
    }

    .contact-page-form-subtitle {
        color: var(--text-muted) !important;
        font-size: 1rem !important;
    }

    .contact-page-form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 0;
    }

    .contact-page-form-group {
        margin-bottom: 20px;
        width: 100%;
    }

    .contact-page-form-label {
        display: block !important;
        margin-bottom: 8px !important;
        font-weight: 600 !important;
        color: var(--text-primary) !important;
        font-size: 0.95rem !important;
        text-align: left !important;
    }

    .contact-page-form-label i {
        color: var(--bright-amber);
        margin-right: 5px;
    }

    .contact-page-form-label .required {
        color: var(--bright-amber);
        margin-left: 3px;
    }

    .contact-page-form-control {
        width: 100% !important;
        padding: 14px 18px !important;
        border: 2px solid var(--pale-slate) !important;
        border-radius: var(--radius-md) !important;
        font-size: 1rem !important;
        transition: var(--transition) !important;
        background: var(--pure-white) !important;
        color: var(--text-primary) !important;
        height: auto !important;
        line-height: 1.5 !important;
    }

    .contact-page-form-control:focus {
        outline: none !important;
        border-color: var(--bright-amber) !important;
        box-shadow: 0 0 0 4px rgba(251, 198, 12, 0.1) !important;
    }

    .contact-page-form-control.is-invalid {
        border-color: var(--bright-amber) !important;
    }

    .contact-page-invalid-feedback {
        color: var(--bright-amber) !important;
        font-size: 0.85rem !important;
        margin-top: 5px !important;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    textarea.contact-page-form-control {
        resize: vertical;
        min-height: 150px;
    }

    select.contact-page-form-control {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23FBC60C' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 15px center;
        padding-right: 45px !important;
    }

    .contact-page-submit-btn {
        background: var(--gradient-1) !important;
        color: var(--pure-white) !important;
        border: none !important;
        padding: 16px 40px !important;
        border-radius: var(--radius-full) !important;
        font-size: 1.1rem !important;
        font-weight: 600 !important;
        cursor: pointer !important;
        transition: var(--transition) !important;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        position: relative;
        overflow: hidden;
    }

    .contact-page-submit-btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(251, 198, 12, 0.3);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .contact-page-submit-btn:hover::before {
        width: 300px;
        height: 300px;
    }

    .contact-page-submit-btn:hover {
        background: var(--gradient-2) !important;
        color: var(--prussian-blue) !important;
        transform: translateY(-3px);
        box-shadow: var(--shadow-hover);
    }

    .contact-page-submit-btn i {
        font-size: 1rem;
        transition: transform 0.3s ease;
    }

    .contact-page-submit-btn:hover i {
        transform: translateX(5px);
    }

    .contact-page-submit-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    /* Success Message */
    .contact-page-alert-success {
        background: var(--gradient-2);
        color: var(--prussian-blue);
        padding: 20px 30px;
        border-radius: var(--radius-lg);
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 15px;
        animation: contact-page-slideInDown 0.5s ease-out;
        box-shadow: var(--shadow-lg);
        border: 1px solid rgba(251, 198, 12, 0.3);
    }

    .contact-page-alert-success i {
        font-size: 2rem;
        color: var(--prussian-blue);
    }

    .contact-page-alert-success-content {
        flex: 1;
    }

    .contact-page-alert-success-content h4 {
        font-size: 1.2rem !important;
        margin-bottom: 5px !important;
        font-weight: 600 !important;
        color: var(--prussian-blue) !important;
    }

    .contact-page-alert-success-content p {
        opacity: 0.9;
        font-size: 0.95rem;
        color: var(--prussian-blue) !important;
    }

    .contact-page-alert-close {
        background: rgba(255, 255, 255, 0.3);
        border: none;
        color: var(--prussian-blue);
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: var(--transition);
    }

    .contact-page-alert-close:hover {
        background: rgba(255, 255, 255, 0.5);
        transform: scale(1.1);
    }

    /* Map Section */
    .contact-page-map-section {
        padding: 0 0 80px;
        background: var(--ivory);
    }

    .contact-page-map-container {
        max-width: 1200px;
        margin: 0 auto;
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-lg);
        height: 400px;
        border: 1px solid rgba(251, 198, 12, 0.2);
    }

    .contact-page-map-container iframe {
        width: 100%;
        height: 100%;
        border: none;
    }

    /* Loading Spinner */
    .contact-page-spinner {
        display: inline-block;
        width: 16px;
        height: 16px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        border-top-color: var(--bright-amber);
        animation: contact-page-spin 0.8s linear infinite;
    }

    @keyframes contact-page-spin {
        to {
            transform: rotate(360deg);
        }
    }

    /* Animations */
    @keyframes contact-page-float {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-20px);
        }
    }

    @keyframes contact-page-fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes contact-page-fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes contact-page-slideInDown {
        from {
            transform: translateY(-100%);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .contact-page-grid {
            grid-template-columns: 1fr;
            gap: 30px;
            padding: 0 20px;
        }

        .contact-page-map-container {
            margin: 0 20px;
        }
    }

    @media (max-width: 768px) {
        .contact-page-hero {
            padding: 60px 0;
        }

        .contact-page-info-card,
        .contact-page-hours-card,
        .contact-page-social-card,
        .contact-page-form-container {
            padding: 30px;
        }

        .contact-page-form-row {
            grid-template-columns: 1fr;
            gap: 0;
        }

        .contact-page-info-title {
            font-size: 1.5rem !important;
        }

        .contact-page-form-title {
            font-size: 1.8rem !important;
        }

        .contact-page-map-container {
            height: 300px;
        }

        .contact-page-hours-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 5px;
        }

        .contact-page-hours-time {
            align-self: flex-start;
        }
    }

    @media (max-width: 576px) {
        .contact-page-info-card,
        .contact-page-hours-card,
        .contact-page-social-card,
        .contact-page-form-container {
            padding: 25px 20px;
        }

        .contact-page-info-list li {
            flex-direction: column;
            align-items: flex-start;
            text-align: left;
            gap: 8px;
        }

        .contact-page-info-list li i {
            width: 35px;
            height: 35px;
            font-size: 1rem;
        }

        .contact-page-info-list li a,
        .contact-page-info-list li span {
            width: 100%;
            word-break: break-word;
        }

        .contact-page-info-highlights ul li {
            font-size: 0.9rem;
        }

        .contact-page-form-title {
            font-size: 1.5rem !important;
        }

        .contact-page-submit-btn {
            padding: 14px 30px !important;
            font-size: 1rem !important;
        }

        .contact-page-alert-success {
            flex-direction: column;
            text-align: center;
            padding: 20px;
        }

        .contact-page-alert-success i {
            margin-bottom: 10px;
        }

        .contact-page-alert-close {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .contact-page-map-container {
            height: 250px;
            margin: 0 15px;
        }

        .contact-page-social-grid {
            gap: 10px;
        }

        .contact-page-social-link {
            width: 45px;
            height: 45px;
            font-size: 1.2rem;
        }
    }

    /* Extra Small Devices */
    @media (max-width: 380px) {
        .contact-page-info-card,
        .contact-page-hours-card,
        .contact-page-social-card,
        .contact-page-form-container {
            padding: 20px 15px;
        }

        .contact-page-info-icon {
            width: 50px;
            height: 50px;
            font-size: 1.3rem;
        }

        .contact-page-info-title {
            font-size: 1.3rem !important;
        }

        .contact-page-info-description {
            font-size: 0.9rem !important;
        }

        .contact-page-info-list li {
            font-size: 0.9rem;
        }

        .contact-page-info-list li i {
            width: 30px;
            height: 30px;
            font-size: 0.9rem;
        }

        .contact-page-form-control {
            padding: 12px 15px !important;
            font-size: 0.9rem !important;
        }

        .contact-page-submit-btn {
            padding: 12px 25px !important;
        }

        .contact-page-map-container {
            height: 200px;
        }
    }
</style>

<!-- Hero Section -->
<section class="contact-page-hero">
    <div class="contact-page-particles">
        <div class="contact-page-particle"></div>
        <div class="contact-page-particle"></div>
        <div class="contact-page-particle"></div>
    </div>
    
    <div class="container">
        <div class="contact-page-hero-content">
            <span class="contact-page-hero-badge">{{ App\Helpers\TranslationHelper::trans('contact.hero_badge') }}</span>
            <h1 class="contact-page-hero-title">{!! App\Helpers\TranslationHelper::trans('contact.hero_title') !!}</h1>
            <p class="contact-page-hero-text">
                {{ App\Helpers\TranslationHelper::trans('contact.hero_description') }}
            </p>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-page-section">
    <div class="container">
        <!-- Success Message -->
        @if(session('success'))
            <div class="contact-page-alert-success" id="successAlert">
                <i class="fas fa-check-circle"></i>
                <div class="contact-page-alert-success-content">
                    <h4>{{ App\Helpers\TranslationHelper::trans('contact.success_title') }}</h4>
                    <p>{{ session('success') }}</p>
                </div>
                <button class="contact-page-alert-close" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif
        
        <div class="contact-page-grid">
            <!-- Left Column - Contact Information -->
            <div class="contact-page-info-wrapper">
                <!-- Main Contact Card -->
                <div class="contact-page-info-card" data-aos="fade-right">
                    <div class="contact-page-info-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <h2 class="contact-page-info-title">{{ App\Helpers\TranslationHelper::trans('contact.contact_card_title') }}</h2>
                    <p class="contact-page-info-description">
                        {{ App\Helpers\TranslationHelper::trans('contact.contact_card_description') }}
                    </p>
                    
                    <ul class="contact-page-info-list">
                        <li>
                            <i class="fas fa-phone"></i>
                            <a href="tel:+18335338228">{{ App\Helpers\TranslationHelper::trans('contact.contact_phone') }}</a>
                        </li>
                        <li>
                            <i class="far fa-envelope"></i>
                            <a href="mailto:contact@educonecx.com">{{ App\Helpers\TranslationHelper::trans('contact.contact_email') }}</a>
                        </li>
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ App\Helpers\TranslationHelper::trans('contact.contact_address') }}</span>
                        </li>
                    </ul>

                    <div class="contact-page-info-highlights">
                        <h4><i class="fas fa-star"></i> {{ App\Helpers\TranslationHelper::trans('contact.highlights_title') }}</h4>
                        <ul>
                            <li><i class="fas fa-check-circle"></i> {{ App\Helpers\TranslationHelper::trans('contact.highlight_1') }}</li>
                            <li><i class="fas fa-check-circle"></i> {{ App\Helpers\TranslationHelper::trans('contact.highlight_2') }}</li>
                            <li><i class="fas fa-check-circle"></i> {{ App\Helpers\TranslationHelper::trans('contact.highlight_3') }}</li>
                            <li><i class="fas fa-check-circle"></i> {{ App\Helpers\TranslationHelper::trans('contact.highlight_4') }}</li>
                            <li><i class="fas fa-check-circle"></i> {{ App\Helpers\TranslationHelper::trans('contact.highlight_5') }}</li>
                        </ul>
                    </div>
                </div>

                <!-- Business Hours Card -->
                <div class="contact-page-hours-card" data-aos="fade-right" data-aos-delay="100">
                    <h3 class="contact-page-hours-title">
                        <i class="fas fa-clock"></i>
                        {{ App\Helpers\TranslationHelper::trans('contact.hours_title') }}
                    </h3>
                    <div class="contact-page-hours-grid">
                        <div class="contact-page-hours-item">
                            <span class="contact-page-hours-day">{{ App\Helpers\TranslationHelper::trans('contact.hours_weekday') }}</span>
                            <span class="contact-page-hours-time">{{ App\Helpers\TranslationHelper::trans('contact.hours_weekday_time') }}</span>
                        </div>
                        <div class="contact-page-hours-item">
                            <span class="contact-page-hours-day">{{ App\Helpers\TranslationHelper::trans('contact.hours_saturday') }}</span>
                            <span class="contact-page-hours-time">{{ App\Helpers\TranslationHelper::trans('contact.hours_saturday_time') }}</span>
                        </div>
                        <div class="contact-page-hours-item">
                            <span class="contact-page-hours-day">{{ App\Helpers\TranslationHelper::trans('contact.hours_sunday') }}</span>
                            <span class="contact-page-hours-time">{{ App\Helpers\TranslationHelper::trans('contact.hours_sunday_time') }}</span>
                        </div>
                    </div>
                    <div class="contact-page-hours-note">
                        <i class="fas fa-info-circle"></i>
                        <span>{{ App\Helpers\TranslationHelper::trans('contact.hours_note') }}</span>
                    </div>
                </div>

                <!-- Social Media Card -->
                <div class="contact-page-social-card" data-aos="fade-right" data-aos-delay="200">
                    <h3 class="contact-page-social-title">{{ App\Helpers\TranslationHelper::trans('contact.social_title') }}</h3>
                    <div class="contact-page-social-grid">
                        <a href="https://www.facebook.com/profile.php?id=61584601012851" target="_blank" class="contact-page-social-link">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://www.tiktok.com/@educonecx.officia" target="_blank" class="contact-page-social-link">
                            <i class="fab fa-tiktok"></i>
                        </a>
                        <a href="https://www.instagram.com/educonecx/" target="_blank" class="contact-page-social-link">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://www.youtube.com/@EDUCONECX" target="_blank" class="contact-page-social-link">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="https://wa.me/18335338228" target="_blank" class="contact-page-social-link">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Right Column - Contact Form -->
            <div class="contact-page-form-container" data-aos="fade-left">
                <div class="contact-page-form-header">
                    <h2 class="contact-page-form-title">{!! App\Helpers\TranslationHelper::trans('contact.form_title') !!}</h2>
                    <p class="contact-page-form-subtitle">{{ App\Helpers\TranslationHelper::trans('contact.form_subtitle') }}</p>
                </div>
                
                <form action="{{ route('contact.submit') }}" method="POST" id="contactForm">
                    @csrf
                    
                    <div class="contact-page-form-row">
                        <div class="contact-page-form-group">
                            <label for="first_name" class="contact-page-form-label">
                                <i class="fas fa-user"></i> {{ App\Helpers\TranslationHelper::trans('contact.form_first_name') }} <span class="required">{{ App\Helpers\TranslationHelper::trans('contact.required') }}</span>
                            </label>
                            <input 
                                type="text" 
                                class="contact-page-form-control @error('first_name') is-invalid @enderror" 
                                id="first_name" 
                                name="first_name" 
                                placeholder="{{ App\Helpers\TranslationHelper::trans('contact.form_placeholder_first_name') }}"
                                value="{{ old('first_name') }}"
                                required
                            >
                            @error('first_name')
                                <div class="contact-page-invalid-feedback">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="contact-page-form-group">
                            <label for="last_name" class="contact-page-form-label">
                                <i class="fas fa-user"></i> {{ App\Helpers\TranslationHelper::trans('contact.form_last_name') }} <span class="required">{{ App\Helpers\TranslationHelper::trans('contact.required') }}</span>
                            </label>
                            <input 
                                type="text" 
                                class="contact-page-form-control @error('last_name') is-invalid @enderror" 
                                id="last_name" 
                                name="last_name" 
                                placeholder="{{ App\Helpers\TranslationHelper::trans('contact.form_placeholder_last_name') }}"
                                value="{{ old('last_name') }}"
                                required
                            >
                            @error('last_name')
                                <div class="contact-page-invalid-feedback">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="contact-page-form-group">
                        <label for="email" class="contact-page-form-label">
                            <i class="fas fa-envelope"></i> {{ App\Helpers\TranslationHelper::trans('contact.form_email') }} <span class="required">{{ App\Helpers\TranslationHelper::trans('contact.required') }}</span>
                        </label>
                        <input 
                            type="email" 
                            class="contact-page-form-control @error('email') is-invalid @enderror" 
                            id="email" 
                            name="email" 
                            placeholder="{{ App\Helpers\TranslationHelper::trans('contact.form_placeholder_email') }}"
                            value="{{ old('email') }}"
                            required
                        >
                        @error('email')
                            <div class="contact-page-invalid-feedback">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <div class="contact-page-form-group">
                        <label for="phone" class="contact-page-form-label">
                            <i class="fas fa-phone"></i> {{ App\Helpers\TranslationHelper::trans('contact.form_phone') }}
                        </label>
                        <input 
                            type="tel" 
                            class="contact-page-form-control @error('phone') is-invalid @enderror" 
                            id="phone" 
                            name="phone" 
                            placeholder="{{ App\Helpers\TranslationHelper::trans('contact.form_placeholder_phone') }}"
                            value="{{ old('phone') }}"
                        >
                        @error('phone')
                            <div class="contact-page-invalid-feedback">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <div class="contact-page-form-group">
                        <label for="subject" class="contact-page-form-label">
                            <i class="fas fa-tag"></i> {{ App\Helpers\TranslationHelper::trans('contact.form_subject') }}
                        </label>
                        <select class="contact-page-form-control" id="subject" name="subject">
                            <option value="">{{ App\Helpers\TranslationHelper::trans('contact.form_subject_select') }}</option>
                            <option value="course-inquiry">{{ App\Helpers\TranslationHelper::trans('contact.form_subject_course') }}</option>
                            <option value="partnership">{{ App\Helpers\TranslationHelper::trans('contact.form_subject_partnership') }}</option>
                            <option value="technical-support">{{ App\Helpers\TranslationHelper::trans('contact.form_subject_support') }}</option>
                            <option value="billing">{{ App\Helpers\TranslationHelper::trans('contact.form_subject_billing') }}</option>
                            <option value="other">{{ App\Helpers\TranslationHelper::trans('contact.form_subject_other') }}</option>
                        </select>
                    </div>
                    
                    <div class="contact-page-form-group">
                        <label for="message" class="contact-page-form-label">
                            <i class="fas fa-comment"></i> {{ App\Helpers\TranslationHelper::trans('contact.form_message') }} <span class="required">{{ App\Helpers\TranslationHelper::trans('contact.required') }}</span>
                        </label>
                        <textarea 
                            class="contact-page-form-control @error('message') is-invalid @enderror" 
                            id="message" 
                            name="message" 
                            rows="5" 
                            placeholder="{{ App\Helpers\TranslationHelper::trans('contact.form_placeholder_message') }}"
                            required
                        >{{ old('message') }}</textarea>
                        @error('message')
                            <div class="contact-page-invalid-feedback">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <button type="submit" class="contact-page-submit-btn" id="submitBtn">
                        <span>{{ App\Helpers\TranslationHelper::trans('contact.form_submit') }}</span>
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="contact-page-map-section">
    <div class="container">
        <div class="contact-page-map-container" data-aos="fade-up">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3593.210407431367!2d-80.192964684382!3d25.761989583629!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x88d9b682b0b1b1b1%3A0x1b1b1b1b1b1b1b1b!2s1200%20Brickell%20Ave%2C%20Miami%2C%20FL%2033131%2C%20USA!5e0!3m2!1sen!2sus!4v1620000000000!5m2!1sen!2sus" 
                allowfullscreen="" 
                loading="lazy"
                title="EDUCONECX Location"
            ></iframe>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contactForm');
    const submitBtn = document.getElementById('submitBtn');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            // Show loading state
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span>{{ App\Helpers\TranslationHelper::trans('contact.form_submitting') }}</span> <i class="fas fa-spinner fa-spin"></i>';
            submitBtn.disabled = true;
            
            // Form will submit normally, but we show loading state
            // The page will reload with success/error messages
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 5000); // Timeout after 5 seconds in case of error
        });
    }
    
    // Auto-hide success message after 5 seconds
    const successAlert = document.getElementById('successAlert');
    if (successAlert) {
        setTimeout(() => {
            successAlert.style.transition = 'opacity 0.5s ease';
            successAlert.style.opacity = '0';
            setTimeout(() => {
                successAlert.remove();
            }, 500);
        }, 5000);
    }
    
    // Phone number formatting (optional)
    const phoneInput = document.getElementById('phone');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 0) {
                if (value.length <= 3) {
                    value = value;
                } else if (value.length <= 6) {
                    value = value.slice(0, 3) + '-' + value.slice(3);
                } else {
                    value = value.slice(0, 3) + '-' + value.slice(3, 6) + '-' + value.slice(6, 10);
                }
                e.target.value = value;
            }
        });
    }
    
    // Form validation enhancement
    const inputs = form.querySelectorAll('.contact-page-form-control');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.hasAttribute('required') && !this.value) {
                this.classList.add('is-invalid');
            } else if (this.type === 'email' && this.value) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(this.value)) {
                    this.classList.add('is-invalid');
                } else {
                    this.classList.remove('is-invalid');
                }
            } else if (this.value) {
                this.classList.remove('is-invalid');
            }
        });
        
        input.addEventListener('input', function() {
            if (this.classList.contains('is-invalid') && this.value) {
                this.classList.remove('is-invalid');
            }
        });
    });
});
</script>
@endsection