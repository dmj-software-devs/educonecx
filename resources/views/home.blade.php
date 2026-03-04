@extends('layouts.main')

@section('title', 'Empower Your Learning Journey Today - EDUCONECX')

@section('meta_description', 'EDUCONECX is an international AI-powered educational platform that empowers learners worldwide with practical language and digital business skills.')

@push('styles')
<style>
    /* Root Variables - Your Beautiful Logo Colors */
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
        
        /* Extended Palette - Fixed for better readability */
        --primary: var(--regal-navy);
        --primary-dark: var(--prussian-blue);
        --primary-light: var(--dark-slate);
        --secondary: var(--sky-blue);
        --accent: var(--bright-amber);
        --accent-soft: var(--light-gold);
        --success: var(--sky-blue);
        --warning: var(--bright-amber);
        --danger: #EBD789;
        --dark: var(--prussian-blue);
        --dark-light: var(--regal-navy);
        --gray: var(--khaki-beige);
        --gray-light: var(--pale-slate);
        --light: var(--ivory);
        --white: var(--pure-white);
        --black: var(--prussian-blue);
        
        /* Text Colors - Enhanced for readability */
        --text-primary: #0A1D44;
        --text-secondary: #2E5C61;
        --text-muted: #5f5f5f;
        --text-light: #FEFDFE;
        
        /* Gradients */
        --gradient-liquid-1: linear-gradient(135deg, #0A1D44 0%, #18386E 50%, #2E5C61 100%);
        --gradient-liquid-2: linear-gradient(45deg, #FBC60C 0%, #EBD789 50%, #F9F7E9 100%);
        --gradient-liquid-3: linear-gradient(135deg, #5AD1E4 0%, #CBD1DA 50%, #FEFDFE 100%);
        
        /* Shadows - Softer for better contrast */
        --shadow-sm: 0 2px 8px rgba(10, 29, 68, 0.08);
        --shadow-md: 0 4px 12px rgba(10, 29, 68, 0.12);
        --shadow-lg: 0 8px 24px rgba(10, 29, 68, 0.15);
        --shadow-hover: 0 12px 28px rgba(251, 198, 12, 0.2);
        
        /* Border Radius - Simple but elegant */
        --radius-sm: 8px;
        --radius-md: 12px;
        --radius-lg: 16px;
        --radius-xl: 24px;
        --radius-full: 9999px;
        
        /* Transitions */
        --transition: all 0.3s ease;
    }

    /* Base Styles */
    body {
        color: var(--text-primary);
        line-height: 1.6;
    }

    /* Section Headers - Clean */
    .section-header {
        text-align: center;
        margin-bottom: 50px;
    }

    .section-subtitle {
        display: inline-block;
        background: var(--gradient-liquid-2);
        color: var(--prussian-blue);
        padding: 6px 18px;
        border-radius: var(--radius-full);
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 15px;
    }

    .section-title {
        font-size: clamp(2rem, 5vw, 2.8rem);
        font-weight: 700;
        color: var(--prussian-blue);
        line-height: 1.2;
    }

    .section-title span {
        color: var(--bright-amber);
    }

    /* Hero Section */
    .hero {
        position: relative;
        min-height: 100vh;
        display: flex;
        align-items: center;
        background: var(--gradient-liquid-1);
        overflow: hidden;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        color: var(--pure-white);
        text-align: center;
        max-width: 800px;
        margin: 0 auto;
        padding: 100px 0;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 15px;
        background: rgba(255, 255, 255, 0.15);
        padding: 8px 20px 8px 12px;
        border-radius: var(--radius-full);
        margin-bottom: 30px;
        backdrop-filter: blur(10px);
    }

    .avatar-group {
        display: flex;
        align-items: center;
    }

    .avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        border: 2px solid var(--bright-amber);
        margin-left: -8px;
        object-fit: cover;
    }

    .avatar:first-child {
        margin-left: 0;
    }

    .stars {
        color: var(--bright-amber);
        font-size: 0.9rem;
    }

    .rating-text {
        font-size: 0.8rem;
        opacity: 0.9;
    }

    .hero-title {
        font-size: clamp(2.5rem, 8vw, 4rem);
        font-weight: 800;
        line-height: 1.1;
        margin-bottom: 20px;
    }

    .hero-title-gradient {
        color: var(--bright-amber);
    }

    .hero-text {
        font-size: 1.2rem;
        margin-bottom: 30px;
        opacity: 0.95;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    .hero-features {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        justify-content: center;
        margin-bottom: 30px;
    }

    .hero-feature {
        display: flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.1);
        padding: 6px 16px;
        border-radius: var(--radius-full);
        font-size: 0.95rem;
    }

    .hero-feature i {
        color: var(--bright-amber);
    }

    /* Buttons */
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 28px;
        border-radius: var(--radius-full);
        font-weight: 600;
        font-size: 1rem;
        transition: var(--transition);
        text-decoration: none;
        cursor: pointer;
        border: none;
    }

    .btn-primary {
        background: var(--gradient-liquid-2);
        color: var(--prussian-blue);
    }

    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-hover);
    }

    .btn-secondary {
        background: transparent;
        color: var(--pure-white);
        border: 2px solid var(--pure-white);
    }

    .btn-secondary:hover {
        background: var(--pure-white);
        color: var(--prussian-blue);
        transform: translateY(-3px);
    }

    /* Process Cards - Clean and Readable */
    .process-section {
        padding: 80px 0;
        background: var(--ivory);
    }

    .process-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        margin-top: 40px;
    }

    .process-card {
        background: var(--pure-white);
        padding: 40px 30px;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        text-align: center;
        transition: var(--transition);
        border: 1px solid rgba(251, 198, 12, 0.1);
    }

    .process-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-lg);
        border-color: var(--bright-amber);
    }

    .process-icon {
        width: 80px;
        height: 80px;
        background: var(--gradient-liquid-1);
        color: var(--pure-white);
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin: 0 auto 25px;
    }

    .process-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--prussian-blue);
        margin-bottom: 15px;
    }

    .process-text {
        color: var(--text-muted);
        font-size: 0.95rem;
        line-height: 1.6;
    }

    /* Features Cards - Clean */
    .features-section {
        padding: 80px 0;
        background: var(--pure-white);
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 30px;
        margin-top: 40px;
    }

    .feature-card {
        background: var(--pure-white);
        padding: 40px 30px;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        text-align: center;
        transition: var(--transition);
        border: 1px solid rgba(90, 209, 228, 0.1);
    }

    .feature-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-lg);
        border-color: var(--sky-blue);
    }

    .feature-icon {
        width: 80px;
        height: 80px;
        background: var(--gradient-liquid-1);
        color: var(--pure-white);
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin: 0 auto 25px;
    }

    .feature-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--prussian-blue);
        margin-bottom: 15px;
    }

    .feature-text {
        color: var(--text-muted);
        font-size: 0.95rem;
        line-height: 1.6;
    }

    /* Course Cards - Clean */
    .courses-section {
        padding: 80px 0;
        background: var(--ivory);
    }

    .grid-3 {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        margin-top: 40px;
    }

    .course-card {
        background: var(--pure-white);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-md);
        transition: var(--transition);
        height: 100%;
        border: 1px solid rgba(251, 198, 12, 0.1);
    }

    .course-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-lg);
        border-color: var(--bright-amber);
    }

    .course-image {
        position: relative;
        height: 200px;
        overflow: hidden;
    }

    .course-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .course-category {
        position: absolute;
        top: 15px;
        right: 15px;
        background: var(--gradient-liquid-1);
        color: var(--pure-white);
        padding: 4px 12px;
        border-radius: var(--radius-full);
        font-size: 0.75rem;
        font-weight: 600;
    }

    .course-discount-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background: var(--gradient-liquid-2);
        color: var(--prussian-blue);
        padding: 4px 12px;
        border-radius: var(--radius-full);
        font-size: 0.75rem;
        font-weight: 700;
    }

    .course-content {
        padding: 25px;
    }

    .course-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 12px;
        font-size: 0.8rem;
        color: var(--text-muted);
    }

    .course-meta i {
        color: var(--bright-amber);
        margin-right: 5px;
    }

    .course-title {
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 10px;
        line-height: 1.4;
    }

    .course-title a {
        color: var(--prussian-blue);
        text-decoration: none;
    }

    .course-title a:hover {
        color: var(--bright-amber);
    }

    .course-content p {
        color: var(--text-muted);
        font-size: 0.9rem;
        margin-bottom: 15px;
        line-height: 1.5;
    }

    .course-stats {
        display: flex;
        gap: 20px;
        font-size: 0.8rem;
        color: var(--text-muted);
        margin-bottom: 15px;
    }

    .course-stats i {
        color: var(--bright-amber);
        margin-right: 5px;
    }

    .course-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 15px;
        border-top: 1px solid var(--pale-slate);
    }

    .course-price {
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--prussian-blue);
    }

    .course-price small {
        font-size: 0.9rem;
        font-weight: 400;
        color: var(--text-muted);
        text-decoration: line-through;
        margin-left: 8px;
    }

    .course-btn {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: var(--gradient-liquid-1);
        color: var(--pure-white);
        padding: 8px 16px;
        border-radius: var(--radius-full);
        font-size: 0.9rem;
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
    }

    .course-btn:hover {
        background: var(--gradient-liquid-2);
        color: var(--prussian-blue);
        transform: translateX(5px);
    }

    /* Offer Banner */
    .offer-banner {
        background: var(--gradient-liquid-1);
        padding: 50px 0;
        color: var(--pure-white);
    }

    .offer-content {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 30px;
        flex-wrap: wrap;
    }

    .offer-content i {
        font-size: 3rem;
        color: var(--bright-amber);
    }

    .offer-content h3 {
        font-size: 2rem;
        font-weight: 700;
    }

    .offer-content p {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--light-gold);
    }

    /* Stats Section */
    .stats-section {
        padding: 60px 0;
        background: var(--gradient-liquid-1);
        color: var(--pure-white);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 30px;
        text-align: center;
    }

    .stats-item {
        padding: 20px;
    }

    .stats-icon {
        font-size: 2.5rem;
        color: var(--bright-amber);
        margin-bottom: 15px;
    }

    .stats-number {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 5px;
    }

    .stats-label {
        font-size: 1rem;
        opacity: 0.9;
    }

    /* About Section */
    .about-section {
        padding: 80px 0;
        background: var(--pure-white);
    }

    .about-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 50px;
        align-items: center;
    }

    .about-content p {
        color: var(--text-muted);
        margin-bottom: 20px;
        line-height: 1.7;
    }

    .about-content strong {
        color: var(--prussian-blue);
    }

    .about-features {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
        margin: 30px 0;
    }

    .about-feature {
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--prussian-blue);
    }

    .about-feature i {
        color: var(--bright-amber);
    }

    .about-image {
        position: relative;
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-lg);
    }

    .about-image img {
        width: 100%;
        height: auto;
        display: block;
    }

    .experience-badge {
        position: absolute;
        bottom: 20px;
        right: 20px;
        background: var(--gradient-liquid-2);
        color: var(--prussian-blue);
        padding: 20px;
        border-radius: var(--radius-md);
        text-align: center;
    }

    .experience-badge .years {
        display: block;
        font-size: 2rem;
        font-weight: 800;
        line-height: 1;
    }

    .experience-badge .text {
        font-size: 0.9rem;
    }

    /* Testimonials Section */
    .testimonials-section {
        padding: 80px 0;
        background: var(--ivory);
    }

    .testimonials-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 30px;
        margin-top: 40px;
    }

    .testimonial-card {
        background: var(--pure-white);
        padding: 35px;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        border: 1px solid rgba(251, 198, 12, 0.1);
    }

    .testimonial-card:hover {
        box-shadow: var(--shadow-lg);
        border-color: var(--bright-amber);
    }

    .testimonial-rating {
        color: var(--bright-amber);
        margin-bottom: 20px;
    }

    .testimonial-text {
        color: var(--text-muted);
        font-size: 1rem;
        line-height: 1.7;
        margin-bottom: 25px;
        font-style: italic;
    }

    .testimonial-author {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .author-image {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        overflow: hidden;
        border: 3px solid var(--bright-amber);
    }

    .author-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .author-info h4 {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--prussian-blue);
        margin-bottom: 5px;
    }

    .author-info p {
        color: var(--text-muted);
        font-size: 0.9rem;
    }

    /* CTA Section */
    .cta-section {
        padding: 80px 0;
        background: var(--gradient-liquid-1);
        color: var(--pure-white);
        text-align: center;
    }

    .cta-content {
        max-width: 600px;
        margin: 0 auto;
    }

    .cta-badge {
        display: inline-block;
        background: rgba(255, 255, 255, 0.15);
        padding: 8px 20px;
        border-radius: var(--radius-full);
        font-size: 0.9rem;
        margin-bottom: 30px;
    }

    .cta-title {
        font-size: clamp(2rem, 5vw, 2.8rem);
        font-weight: 800;
        margin-bottom: 20px;
    }

    .cta-title span {
        color: var(--bright-amber);
    }

    .cta-text {
        font-size: 1.1rem;
        margin-bottom: 30px;
        opacity: 0.95;
    }

    .cta-buttons {
        display: flex;
        gap: 20px;
        justify-content: center;
        flex-wrap: wrap;
    }

    /* FAQ Section */
    .faq-section {
        padding: 80px 0;
        background: var(--pure-white);
    }

    .faq-grid {
        max-width: 800px;
        margin: 40px auto 0;
    }

    .faq-item {
        background: var(--ivory);
        border-radius: var(--radius-lg);
        margin-bottom: 15px;
        overflow: hidden;
        border: 1px solid rgba(251, 198, 12, 0.1);
    }

    .faq-question {
        padding: 18px 25px;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 600;
        color: var(--prussian-blue);
    }

    .faq-question:hover {
        background: var(--gradient-liquid-2);
        color: var(--prussian-blue);
    }

    .faq-question i {
        color: var(--bright-amber);
        transition: transform 0.3s;
    }

    .faq-item.active .faq-question {
        background: var(--gradient-liquid-2);
    }

    .faq-item.active .faq-question i {
        transform: rotate(180deg);
    }

    .faq-answer {
        padding: 0 25px 18px;
        display: none;
        color: var(--text-muted);
        line-height: 1.7;
    }

    .faq-item.active .faq-answer {
        display: block;
    }

    /* Carousel Section */
    .carousel-section {
        position: relative;
        margin-top: -80px;
        padding-bottom: 60px;
        z-index: 10;
    }

    .carousel-mask {
        overflow: hidden;
        mask-image: linear-gradient(to right, transparent 0%, black 20%, black 80%, transparent 100%);
        -webkit-mask-image: linear-gradient(to right, transparent 0%, black 20%, black 80%, transparent 100%);
    }

    .carousel-track {
        display: flex;
        gap: 20px;
        animation: marquee 40s linear infinite;
        width: fit-content;
    }

    @keyframes marquee {
        from { transform: translateX(0); }
        to { transform: translateX(-50%); }
    }

    .carousel-item {
        flex-shrink: 0;
        width: 220px;
        height: 300px;
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-lg);
    }

    .carousel-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    @media (min-width: 768px) {
        .carousel-item {
            width: 280px;
            height: 380px;
        }
    }

    /* Logo Cloud */
    /* Logo Cloud - Fixed for full-width sliding */
.logo-cloud-section {
    padding: 50px 0;
    background: var(--pure-white);
    width: 100%;
    overflow: hidden;
}

.logo-cloud-title {
    text-align: center;
    color: var(--text-muted);
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin-bottom: 30px;
}

.logo-cloud {
    width: 100%;
    overflow: hidden;
    position: relative;
    mask-image: linear-gradient(to right, transparent 0%, black 10%, black 90%, transparent 100%);
    -webkit-mask-image: linear-gradient(to right, transparent 0%, black 10%, black 90%, transparent 100%);
}

.logo-track {
    display: flex;
    gap: 50px;
    animation: marquee 45s linear infinite;
    width: max-content;
    /* This ensures the track takes the full width of its content */
    padding-left: 20px;
    /* Add some padding to prevent items from touching the edges */
}

@keyframes marquee {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}

.logo-item {
    flex-shrink: 0;
    filter: grayscale(100%) opacity(0.6);
    transition: var(--transition);
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 120px;
    /* Ensure consistent width for text fallback */
}

.logo-item:hover {
    filter: grayscale(0%) opacity(1);
}

.logo-item img {
    height: 40px;
    width: auto;
    max-width: 120px;
    object-fit: contain;
}

.logo-item span {
    font-size: 1.1rem;
    font-weight: 600;
    white-space: nowrap;
    color: var(--prussian-blue);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .logo-track {
        gap: 30px;
        animation-duration: 35s;
        /* Slightly faster on mobile */
    }
    
    .logo-item {
        min-width: 100px;
    }
    
    .logo-item img {
        height: 30px;
    }
    
    .logo-item span {
        font-size: 1rem;
    }
}
    /* Responsive */
    @media (max-width: 1024px) {
        .grid-3 {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .process-grid {
            grid-template-columns: 1fr;
        }

        .grid-3 {
            grid-template-columns: 1fr;
        }

        .about-grid {
            grid-template-columns: 1fr;
            gap: 30px;
        }

        .about-features {
            grid-template-columns: 1fr;
        }

        .testimonials-grid {
            grid-template-columns: 1fr;
        }

        .hero-buttons .btn {
            min-width: 200px;
        }

        .offer-content {
            flex-direction: column;
            gap: 15px;
            text-align: center;
        }
    }

    @media (max-width: 576px) {
        .hero-features {
            flex-direction: column;
            align-items: center;
        }

        .hero-feature {
            width: 100%;
            justify-content: center;
        }

        .cta-buttons {
            flex-direction: column;
        }

        .cta-buttons .btn {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <div class="hero-content" data-aos="fade-up">
            <div class="hero-badge">
                <div class="avatar-group">
                    <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=40&h=40&fit=crop" alt="Student" class="avatar">
                    <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=40&h=40&fit=crop" alt="Student" class="avatar">
                    <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=40&h=40&fit=crop" alt="Student" class="avatar">
                </div>
                <div>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <span class="rating-text">10,000+ students</span>
                </div>
            </div>

            <h1 class="hero-title">
                Empower Your <span class="hero-title-gradient">Learning</span><br>
                Journey Today
            </h1>

            <p class="hero-text">
                Join thousands of learners worldwide and master practical language
                and digital business skills with our AI-powered platform.
            </p>

            <div class="hero-features">
                <div class="hero-feature">
                    <i class="fas fa-check-circle"></i>
                    <span>AI-Powered Learning</span>
                </div>
                <div class="hero-feature">
                    <i class="fas fa-check-circle"></i>
                    <span>Expert Instructors</span>
                </div>
                <div class="hero-feature">
                    <i class="fas fa-check-circle"></i>
                    <span>Practical Skills</span>
                </div>
            </div>

            <div class="hero-buttons">
                <a href="{{ route('academy') }}" class="btn btn-primary">
                    <i class="fas fa-graduation-cap"></i> Join Academy
                </a>
                <a href="{{ route('courses') }}" class="btn btn-secondary">
                    <i class="fas fa-play-circle"></i> Explore Courses
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Course Carousel Section -->
<section class="carousel-section">
    <div class="carousel-mask">
        <div class="carousel-track">
            @php
            $courseImages = [
                'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400&h=600&fit=crop',
                'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=400&h=600&fit=crop',
                'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=400&h=600&fit=crop',
                'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=400&h=600&fit=crop',
                'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?w=400&h=600&fit=crop',
                'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=400&h=600&fit=crop',
            ];
            @endphp

            @foreach($courseImages as $image)
            <div class="carousel-item">
                <img src="{{ $image }}" alt="Course">
            </div>
            @endforeach

            @foreach($courseImages as $image)
            <div class="carousel-item">
                <img src="{{ $image }}" alt="Course">
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Logo Cloud Section -->
<section class="logo-cloud-section">
    <div class="container">
        <p class="logo-cloud-title">Trusted by students from</p>
        <div class="logo-cloud">
            <div class="logo-track">
                <!-- Harvard -->
                <div class="logo-item">
                    @php
                        $harvardPath = public_path('storage/home-page-svgs/Harvard_shield_wreath.svg');
                    @endphp
                    @if(file_exists($harvardPath))
                        <img src="{{ asset('storage/home-page-svgs/Harvard_shield_wreath.svg') }}" alt="Harvard University" style="height: 40px;">
                    @else
                        <span style="font-weight: 600; color: var(--prussian-blue);">Harvard</span>
                    @endif
                </div>
                
                <!-- Stanford -->
                <div class="logo-item">
                    @php
                        $stanfordPath = public_path('storage/home-page-svgs/Stanford_University_seal_2003.svg');
                    @endphp
                    @if(file_exists($stanfordPath))
                        <img src="{{ asset('storage/home-page-svgs/Stanford_University_seal_2003.svg') }}" alt="Stanford University" style="height: 40px;">
                    @else
                        <span style="font-weight: 600; color: var(--prussian-blue);">Stanford</span>
                    @endif
                </div>
                
                <!-- MIT -->
                <div class="logo-item">
                    @php
                        $mitPath = public_path('storage/home-page-svgs/MIT_seal.svg');
                    @endphp
                    @if(file_exists($mitPath))
                        <img src="{{ asset('storage/home-page-svgs/MIT_seal.svg') }}" alt="MIT" style="height: 40px;">
                    @else
                        <span style="font-weight: 600; color: var(--prussian-blue);">MIT</span>
                    @endif
                </div>
                
                <!-- Cambridge -->
                <div class="logo-item">
                    @php
                        $cambridgePath = public_path('storage/home-page-pngs/University_of_Cambridge_seal.png');
                    @endphp
                    @if(file_exists($cambridgePath))
                        <img src="{{ asset('storage/home-page-pngs/University_of_Cambridge_seal.png') }}" alt="University of Cambridge" style="height: 40px;">
                    @else
                        <span style="font-weight: 600; color: var(--prussian-blue);">Cambridge</span>
                    @endif
                </div>
                
                <!-- Oxford -->
                <div class="logo-item">
                    @php
                        $oxfordPath = public_path('storage/home-page-pngs/Oxford-University-Circlet.png');
                    @endphp
                    @if(file_exists($oxfordPath))
                        <img src="{{ asset('storage/home-page-pngs/Oxford-University-Circlet.png') }}" alt="University of Oxford" style="height: 40px;">
                    @else
                        <span style="font-weight: 600; color: var(--prussian-blue);">Oxford</span>
                    @endif
                </div>
                
                <!-- Duplicate for seamless looping -->
                <!-- Harvard (duplicate) -->
                <div class="logo-item">
                    @if(file_exists($harvardPath))
                        <img src="{{ asset('storage/home-page-svgs/Harvard_shield_wreath.svg') }}" alt="Harvard University" style="height: 40px;">
                    @else
                        <span style="font-weight: 600; color: var(--prussian-blue);">Harvard</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Process Section -->
<section class="process-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-subtitle">How It Works</span>
            <h2 class="section-title">Your <span>Learning Journey</span> in 3 Simple Steps</h2>
        </div>

        <div class="process-grid">
            <div class="process-card" data-aos="fade-up" data-aos-delay="100">
                <div class="process-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h3 class="process-title">Create Account</h3>
                <p class="process-text">Sign up for free and get instant access to our platform with a 3-day trial period.</p>
            </div>

            <div class="process-card" data-aos="fade-up" data-aos-delay="200">
                <div class="process-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <h3 class="process-title">Choose Your Path</h3>
                <p class="process-text">Select from our curated courses in language learning or digital business skills.</p>
            </div>

            <div class="process-card" data-aos="fade-up" data-aos-delay="300">
                <div class="process-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h3 class="process-title">Start Learning</h3>
                <p class="process-text">Begin your journey with AI-powered guidance and expert instructor support.</p>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-subtitle">Why Choose Us</span>
            <h2 class="section-title">Learning Experience <span>Like Never Before</span></h2>
        </div>

        <div class="features-grid">
            <div class="feature-card" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-icon">
                    <i class="fas fa-brain"></i>
                </div>
                <h3 class="feature-title">AI-Powered Learning</h3>
                <p class="feature-text">Personalized learning paths powered by advanced AI technology adapt to your pace and style.</p>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-icon">
                    <i class="fas fa-language"></i>
                </div>
                <h3 class="feature-title">Multiple Languages</h3>
                <p class="feature-text">Courses available in English, French, Haitian Creole, and Spanish for global accessibility.</p>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3 class="feature-title">Practical Skills</h3>
                <p class="feature-text">Learn real-world skills that you can apply immediately in your career or business.</p>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="400">
                <div class="feature-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3 class="feature-title">Expert Instructors</h3>
                <p class="feature-text">Learn from industry experts with years of practical experience in their fields.</p>
            </div>
        </div>
    </div>
</section>

<!-- Offer Banner -->
<section class="offer-banner" data-aos="fade-up">
    <div class="container">
        <div class="offer-content">
            <i class="fas fa-gift"></i>
            <h3>Limited Time Offer</h3>
            <p>Unlimited Access To All Courses – Only $22</p>
            <a href="#" class="btn btn-primary">Get Started Now</a>
        </div>
    </div>
</section>

<!-- Courses Section -->
<section class="courses-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-subtitle">Our Courses</span>
            <h2 class="section-title">Featured <span>Learning Paths</span></h2>
        </div>

        <div class="grid-3">
            @forelse($featuredCourses as $course)
            <div class="course-card" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                <div class="course-image">
                    <img src="{{ $course->thumbnail_url }}" alt="{{ $course->title }}">
                    <span class="course-category">{{ $course->category->name ?? 'General' }}</span>
                    @if($course->hasDiscount)
                    <span class="course-discount-badge">-{{ $course->discount_percentage }}%</span>
                    @endif
                </div>
                <div class="course-content">
                    <div class="course-meta">
                        <span><i class="far fa-clock"></i> {{ $course->duration }} Hours</span>
                        <span><i class="fas fa-signal"></i> {{ $course->level }}</span>
                    </div>
                    <h3 class="course-title">
                        <a href="{{ route('courses.show', $course->slug) }}">{{ $course->title }}</a>
                    </h3>
                    <p>{{ Str::limit($course->excerpt, 80) }}</p>

                    @if($course->total_students > 0)
                    <div class="course-stats">
                        <span><i class="fas fa-users"></i> {{ number_format($course->total_students) }} students</span>
                        @if($course->average_rating > 0)
                        <span>
                            <i class="fas fa-star"></i>
                            {{ number_format($course->average_rating, 1) }}
                        </span>
                        @endif
                    </div>
                    @endif

                    <div class="course-footer">
                        <div class="course-price">
                            @if($course->hasDiscount)
                            ${{ number_format($course->sale_price, 2) }}
                            <small>${{ number_format($course->price, 2) }}</small>
                            @elseif($course->price > 0)
                            ${{ number_format($course->price, 2) }}
                            @else
                            Free
                            @endif
                        </div>
                        <a href="{{ route('courses.show', $course->slug) }}" class="course-btn">
                            {{ $course->price > 0 ? 'Enroll' : 'Start' }}
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center" style="grid-column: 1/-1;">
                <p>No featured courses available at the moment.</p>
            </div>
            @endforelse
        </div>

        <div style="text-align: center; margin-top: 40px;">
            <a href="{{ route('courses') }}" class="btn btn-primary">
                View All Courses <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="container">
        <div class="stats-grid">
            <div class="stats-item" data-aos="zoom-in" data-aos-delay="100">
                <div class="stats-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stats-number" data-target="10000">10,000+</div>
                <div class="stats-label">Students Enrolled</div>
            </div>
            <div class="stats-item" data-aos="zoom-in" data-aos-delay="200">
                <div class="stats-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <div class="stats-number" data-target="50">50+</div>
                <div class="stats-label">Expert Instructors</div>
            </div>
            <div class="stats-item" data-aos="zoom-in" data-aos-delay="300">
                <div class="stats-icon">
                    <i class="fas fa-globe"></i>
                </div>
                <div class="stats-number" data-target="15">15+</div>
                <div class="stats-label">Countries</div>
            </div>
            <div class="stats-item" data-aos="zoom-in" data-aos-delay="400">
                <div class="stats-icon">
                    <i class="fas fa-award"></i>
                </div>
                <div class="stats-number" data-target="4.9">4.9</div>
                <div class="stats-label">Average Rating</div>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="about-section">
    <div class="container">
        <div class="about-grid">
            <div class="about-content" data-aos="fade-right">
                <span class="section-subtitle">About Us</span>
                <h2 class="section-title">Empowering learners,<br><span>connecting futures</span></h2>
                <p><strong>EDUCONECX</strong> is an international AI-powered educational platform that empowers learners worldwide with practical language and digital business skills.</p>
                <p>Our mission is to help individuals break through language barriers and thrive in today's global digital economy. We combine cutting-edge technology with expert instruction to create an unparalleled learning experience.</p>
                <div class="about-features">
                    <div class="about-feature">
                        <i class="fas fa-check-circle"></i>
                        <span>AI-Powered Learning Paths</span>
                    </div>
                    <div class="about-feature">
                        <i class="fas fa-check-circle"></i>
                        <span>Multi-Language Support</span>
                    </div>
                    <div class="about-feature">
                        <i class="fas fa-check-circle"></i>
                        <span>Practical Skills Focus</span>
                    </div>
                    <div class="about-feature">
                        <i class="fas fa-check-circle"></i>
                        <span>Expert Instructors</span>
                    </div>
                </div>
                <a href="{{ route('about') }}" class="btn btn-primary">
                    Learn More About Us <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="about-image" data-aos="fade-left">
                <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&q=80" alt="About EDUCONECX">
                <div class="experience-badge">
                    <span class="years">5+</span>
                    <span class="text">Years of Excellence</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="testimonials-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-subtitle">Testimonials</span>
            <h2 class="section-title">What Our <span>Students Say</span></h2>
        </div>

        <div class="testimonials-grid">
            <div class="testimonial-card" data-aos="fade-up" data-aos-delay="100">
                <div class="testimonial-rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="testimonial-text">
                    "The Academy made learning so easy! Courses are practical and well-structured.
                    I was able to learn at my own pace even with slow internet."
                </p>
                <div class="testimonial-author">
                    <div class="author-image">
                        <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=40&h=40&fit=crop" alt="Sarah M.">
                    </div>
                    <div class="author-info">
                        <h4>Sarah M.</h4>
                        <p>Business Student</p>
                    </div>
                </div>
            </div>

            <div class="testimonial-card" data-aos="fade-up" data-aos-delay="200">
                <div class="testimonial-rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="testimonial-text">
                    "Their guidance is a game-changer. The daily insights and AI companion keep me
                    motivated and focused. It feels personal and uplifting."
                </p>
                <div class="testimonial-author">
                    <div class="author-image">
                        <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=200&q=80" alt="Daniel K.">
                    </div>
                    <div class="author-info">
                        <h4>Daniel K.</h4>
                        <p>Graduate Student</p>
                    </div>
                </div>
            </div>

            <div class="testimonial-card" data-aos="fade-up" data-aos-delay="300">
                <div class="testimonial-rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="testimonial-text">
                    "One platform for everything I need. Instead of jumping between sites, I can
                    access courses, guidance, and digital services all in one place."
                </p>
                <div class="testimonial-author">
                    <div class="author-image">
                        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=200&q=80" alt="Aisha R.">
                    </div>
                    <div class="author-info">
                        <h4>Aisha R.</h4>
                        <p>Entrepreneur</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <div class="cta-content" data-aos="zoom-in">
            <div class="cta-badge">Join 10,000+ Students Worldwide</div>
            <h2 class="cta-title">
                Ready to Start Your <span>Learning Journey?</span>
            </h2>
            <p class="cta-text">
                Join thousands of students worldwide and transform your skills with our AI-powered platform.
            </p>
            <div class="cta-buttons">
                <a href="{{ route('academy') }}" class="btn btn-primary">
                    <i class="fas fa-graduation-cap"></i> Get Started Free
                </a>
                <a href="{{ route('contact') }}" class="btn btn-secondary">
                    <i class="fas fa-headset"></i> Talk to Advisor
                </a>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="faq-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-subtitle">FAQ</span>
            <h2 class="section-title">Frequently Asked <span>Questions</span></h2>
        </div>

        <div class="faq-grid">
            <div class="faq-item" data-aos="fade-up">
                <div class="faq-question">
                    <span>What is EDUCONECX?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>EDUCONECX is an innovative online educational platform that combines AI-powered learning with specialized training programs. We offer both free and premium educational content designed to accelerate your professional development in language skills and digital business.</p>
                </div>
            </div>

            <div class="faq-item" data-aos="fade-up" data-aos-delay="100">
                <div class="faq-question">
                    <span>In which languages are the courses available?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Our courses are available in English, French, Haitian Creole, and Spanish to serve our diverse international community of learners.</p>
                </div>
            </div>

            <div class="faq-item" data-aos="fade-up" data-aos-delay="200">
                <div class="faq-question">
                    <span>How do I get started?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Getting started is simple: create your account, select your preferred course, and begin with our 3-day free trial to explore the platform risk-free.</p>
                </div>
            </div>

            <div class="faq-item" data-aos="fade-up" data-aos-delay="300">
                <div class="faq-question">
                    <span>Can I access courses on mobile?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Yes! Our platform is fully responsive and optimized for all devices. You can access your courses on desktop, tablet, or smartphone anytime, anywhere.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    // FAQ Accordion
    document.querySelectorAll('.faq-question').forEach(question => {
        question.addEventListener('click', () => {
            const faqItem = question.parentElement;
            const wasActive = faqItem.classList.contains('active');

            document.querySelectorAll('.faq-item').forEach(item => {
                item.classList.remove('active');
            });

            if (!wasActive) {
                faqItem.classList.add('active');
            }
        });
    });

    // Counter Animation
    function animateValue(element, start, end, duration) {
        if (start === end) return;
        const range = end - start;
        const increment = range / (duration / 16);
        let current = start;

        const timer = setInterval(() => {
            current += increment;
            if (current >= end) {
                element.textContent = end.toLocaleString() + (element.textContent.includes('+') ? '+' : '');
                clearInterval(timer);
            } else {
                element.textContent = Math.floor(current).toLocaleString() + (element.textContent.includes('+') ? '+' : '');
            }
        }, 16);
    }

    // Stats Observer
    const statsObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                document.querySelectorAll('.stats-number').forEach(stat => {
                    const value = parseFloat(stat.getAttribute('data-target'));
                    animateValue(stat, 0, value, 2000);
                });
                statsObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    const statsSection = document.querySelector('.stats-section');
    if (statsSection) statsObserver.observe(statsSection);

    // Header scroll effect
    window.addEventListener('scroll', () => {
        const header = document.querySelector('header');
        if (header) {
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        }
    });

    // AOS initialization
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            once: true,
            offset: 50
        });
    }
</script>
@endpush