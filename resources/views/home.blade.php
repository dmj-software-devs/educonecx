@extends('layouts.main')

@section('title', App\Helpers\TranslationHelper::trans('home.title', [], 'en') ?? 'Empower Your Learning Journey Today - EDUCONECX')

@section('meta_description', App\Helpers\TranslationHelper::trans('home.meta_description', [], 'en') ?? 'EDUCONECX is an international AI-powered educational platform that empowers learners worldwide with practical language and digital business skills.')

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

    @media (max-width: 768px) {
        .section-header {
            margin-bottom: 35px;
        }
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

    @media (max-width: 576px) {
        .section-subtitle {
            font-size: 0.75rem;
            padding: 5px 14px;
        }
    }

    .section-title {
        font-size: clamp(1.8rem, 5vw, 2.8rem);
        font-weight: 700;
        color: var(--prussian-blue);
        line-height: 1.2;
    }

    .section-title span {
        color: var(--bright-amber);
    }

    /* Hero Section - Updated with background image */
    .hero {
        position: relative;
        min-height: 100vh;
        display: flex;
        align-items: center;
        background-image: url('/images/hero-image.jpeg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        overflow: hidden;
        padding: 80px 0;
    }

    /* Add overlay for better text readability */
    .hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(10, 29, 68, 0.7); /* Prussian blue overlay */
        z-index: 1;
    }

    @media (max-width: 768px) {
        .hero {
            min-height: 80vh;
            padding: 60px 0;
        }
    }

    @media (max-width: 576px) {
        .hero {
            min-height: 70vh;
            padding: 40px 0;
        }
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

    @media (max-width: 768px) {
        .hero-content {
            padding: 60px 0;
        }
    }

    @media (max-width: 576px) {
        .hero-content {
            padding: 40px 0;
        }
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
        flex-wrap: wrap;
        justify-content: center;
    }

    @media (max-width: 576px) {
        .hero-badge {
            gap: 10px;
            padding: 6px 15px 6px 10px;
            margin-bottom: 20px;
        }
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

    @media (max-width: 576px) {
        .avatar {
            width: 30px;
            height: 30px;
            border-width: 2px;
        }
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
        font-size: clamp(2rem, 8vw, 4rem);
        font-weight: 800;
        line-height: 1.1;
        margin-bottom: 20px;
    }

    @media (max-width: 576px) {
        .hero-title {
            margin-bottom: 15px;
        }
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

    @media (max-width: 768px) {
        .hero-text {
            font-size: 1.1rem;
            margin-bottom: 25px;
        }
    }

    @media (max-width: 576px) {
        .hero-text {
            font-size: 1rem;
            margin-bottom: 20px;
        }
    }

    .hero-features {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        justify-content: center;
        margin-bottom: 30px;
    }

    @media (max-width: 576px) {
        .hero-features {
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }
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

    @media (max-width: 576px) {
        .hero-feature {
            width: 100%;
            justify-content: center;
            font-size: 0.9rem;
            padding: 8px 16px;
        }
    }

    .hero-feature i {
        color: var(--bright-amber);
    }

    .hero-buttons {
        display: flex;
        gap: 20px;
        justify-content: center;
        flex-wrap: wrap;
    }

    @media (max-width: 576px) {
        .hero-buttons {
            gap: 15px;
            flex-direction: column;
            align-items: center;
        }
        
        .hero-buttons .btn {
            width: 100%;
            max-width: 280px;
        }
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

    @media (max-width: 768px) {
        .btn {
            padding: 10px 24px;
            font-size: 0.95rem;
        }
    }

    @media (max-width: 576px) {
        .btn {
            padding: 12px 24px;
            width: 100%;
        }
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

    @media (max-width: 768px) {
        .process-section {
            padding: 60px 0;
        }
    }

    @media (max-width: 576px) {
        .process-section {
            padding: 50px 0;
        }
    }

    .process-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        margin-top: 40px;
    }

    @media (max-width: 992px) {
        .process-grid {
            gap: 20px;
        }
    }

    @media (max-width: 768px) {
        .process-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
    }

    @media (max-width: 576px) {
        .process-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
    }

    .process-card {
        background: var(--pure-white);
        padding: 40px 30px;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        text-align: center;
        transition: var(--transition);
        border: 1px solid rgba(251, 198, 12, 0.1);
        height: 100%;
    }

    @media (max-width: 768px) {
        .process-card {
            padding: 30px 20px;
        }
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

    @media (max-width: 768px) {
        .process-icon {
            width: 70px;
            height: 70px;
            font-size: 1.8rem;
            margin-bottom: 20px;
        }
    }

    .process-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--prussian-blue);
        margin-bottom: 15px;
    }

    @media (max-width: 768px) {
        .process-title {
            font-size: 1.2rem;
            margin-bottom: 12px;
        }
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

    @media (max-width: 768px) {
        .features-section {
            padding: 60px 0;
        }
    }

    @media (max-width: 576px) {
        .features-section {
            padding: 50px 0;
        }
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 30px;
        margin-top: 40px;
    }

    @media (max-width: 576px) {
        .features-grid {
            gap: 20px;
        }
    }

    .feature-card {
        background: var(--pure-white);
        padding: 40px 30px;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        text-align: center;
        transition: var(--transition);
        border: 1px solid rgba(90, 209, 228, 0.1);
        height: 100%;
    }

    @media (max-width: 768px) {
        .feature-card {
            padding: 30px 20px;
        }
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

    @media (max-width: 768px) {
        .feature-icon {
            width: 70px;
            height: 70px;
            font-size: 1.8rem;
            margin-bottom: 20px;
        }
    }

    .feature-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--prussian-blue);
        margin-bottom: 15px;
    }

    @media (max-width: 768px) {
        .feature-title {
            font-size: 1.2rem;
            margin-bottom: 12px;
        }
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

    @media (max-width: 768px) {
        .courses-section {
            padding: 60px 0;
        }
    }

    @media (max-width: 576px) {
        .courses-section {
            padding: 50px 0;
        }
    }

    .grid-3 {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        margin-top: 40px;
    }

    @media (max-width: 992px) {
        .grid-3 {
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
    }

    @media (max-width: 576px) {
        .grid-3 {
            grid-template-columns: 1fr;
            gap: 20px;
        }
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

    @media (max-width: 576px) {
        .course-image {
            height: 180px;
        }
    }

    .course-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }

    .course-card:hover .course-image img {
        transform: scale(1.05);
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
        z-index: 2;
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
        z-index: 2;
    }

    .course-content {
        padding: 25px;
    }

    @media (max-width: 768px) {
        .course-content {
            padding: 20px;
        }
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

    @media (max-width: 768px) {
        .course-title {
            font-size: 1.1rem;
        }
    }

    .course-title a {
        color: var(--prussian-blue);
        text-decoration: none;
        transition: var(--transition);
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
        flex-wrap: wrap;
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
        flex-wrap: wrap;
        gap: 10px;
    }

    .course-price {
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--prussian-blue);
    }

    @media (max-width: 576px) {
        .course-price {
            font-size: 1.2rem;
        }
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

    @media (max-width: 768px) {
        .offer-banner {
            padding: 40px 0;
        }
    }

    @media (max-width: 576px) {
        .offer-banner {
            padding: 30px 0;
        }
    }

    .offer-content {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 30px;
        flex-wrap: wrap;
    }

    @media (max-width: 768px) {
        .offer-content {
            flex-direction: column;
            gap: 20px;
            text-align: center;
        }
    }

    .offer-content i {
        font-size: 3rem;
        color: var(--bright-amber);
    }

    @media (max-width: 768px) {
        .offer-content i {
            font-size: 2.5rem;
        }
    }

    .offer-content h3 {
        font-size: 2rem;
        font-weight: 700;
    }

    @media (max-width: 768px) {
        .offer-content h3 {
            font-size: 1.8rem;
        }
    }

    .offer-content p {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--light-gold);
    }

    @media (max-width: 768px) {
        .offer-content p {
            font-size: 1.3rem;
        }
    }

    @media (max-width: 576px) {
        .offer-content p {
            font-size: 1.1rem;
        }
    }

    /* Stats Section */
    .stats-section {
        padding: 60px 0;
        background: var(--gradient-liquid-1);
        color: var(--pure-white);
    }

    @media (max-width: 768px) {
        .stats-section {
            padding: 50px 0;
        }
    }

    @media (max-width: 576px) {
        .stats-section {
            padding: 40px 0;
        }
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 30px;
        text-align: center;
    }

    @media (max-width: 576px) {
        .stats-grid {
            gap: 20px;
        }
    }

    .stats-item {
        padding: 20px;
    }

    @media (max-width: 576px) {
        .stats-item {
            padding: 15px;
        }
    }

    .stats-icon {
        font-size: 2.5rem;
        color: var(--bright-amber);
        margin-bottom: 15px;
    }

    @media (max-width: 768px) {
        .stats-icon {
            font-size: 2.2rem;
        }
    }

    .stats-number {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 5px;
    }

    @media (max-width: 768px) {
        .stats-number {
            font-size: 2.2rem;
        }
    }

    @media (max-width: 576px) {
        .stats-number {
            font-size: 2rem;
        }
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

    @media (max-width: 768px) {
        .about-section {
            padding: 60px 0;
        }
    }

    @media (max-width: 576px) {
        .about-section {
            padding: 50px 0;
        }
    }

    .about-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 50px;
        align-items: center;
    }

    @media (max-width: 992px) {
        .about-grid {
            gap: 30px;
        }
    }

    @media (max-width: 768px) {
        .about-grid {
            grid-template-columns: 1fr;
            gap: 40px;
        }
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

    @media (max-width: 576px) {
        .about-features {
            grid-template-columns: 1fr;
            gap: 12px;
        }
    }

    .about-feature {
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--prussian-blue);
    }

    .about-feature i {
        color: var(--bright-amber);
        font-size: 1.1rem;
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

    @media (max-width: 576px) {
        .experience-badge {
            bottom: 10px;
            right: 10px;
            padding: 15px;
        }
    }

    .experience-badge .years {
        display: block;
        font-size: 2rem;
        font-weight: 800;
        line-height: 1;
    }

    @media (max-width: 576px) {
        .experience-badge .years {
            font-size: 1.5rem;
        }
    }

    .experience-badge .text {
        font-size: 0.9rem;
    }

    @media (max-width: 576px) {
        .experience-badge .text {
            font-size: 0.8rem;
        }
    }

    /* Testimonials Section */
    .testimonials-section {
        padding: 80px 0;
        background: var(--ivory);
    }

    @media (max-width: 768px) {
        .testimonials-section {
            padding: 60px 0;
        }
    }

    @media (max-width: 576px) {
        .testimonials-section {
            padding: 50px 0;
        }
    }

    .testimonials-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        margin-top: 40px;
    }

    @media (max-width: 768px) {
        .testimonials-grid {
            gap: 20px;
        }
    }

    .testimonial-card {
        background: var(--pure-white);
        padding: 35px;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        border: 1px solid rgba(251, 198, 12, 0.1);
        height: 100%;
    }

    @media (max-width: 768px) {
        .testimonial-card {
            padding: 25px;
        }
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
        flex-shrink: 0;
    }

    @media (max-width: 576px) {
        .author-image {
            width: 50px;
            height: 50px;
        }
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

    @media (max-width: 768px) {
        .cta-section {
            padding: 60px 0;
        }
    }

    @media (max-width: 576px) {
        .cta-section {
            padding: 50px 0;
        }
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
        font-size: clamp(1.8rem, 5vw, 2.8rem);
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

    @media (max-width: 768px) {
        .cta-text {
            font-size: 1rem;
        }
    }

    .cta-buttons {
        display: flex;
        gap: 20px;
        justify-content: center;
        flex-wrap: wrap;
    }

    @media (max-width: 576px) {
        .cta-buttons {
            flex-direction: column;
            gap: 15px;
        }
        
        .cta-buttons .btn {
            width: 100%;
        }
    }

    /* FAQ Section */
    .faq-section {
        padding: 80px 0;
        background: var(--pure-white);
    }

    @media (max-width: 768px) {
        .faq-section {
            padding: 60px 0;
        }
    }

    @media (max-width: 576px) {
        .faq-section {
            padding: 50px 0;
        }
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
        transition: var(--transition);
    }

    @media (max-width: 576px) {
        .faq-question {
            padding: 15px 20px;
            font-size: 0.95rem;
        }
    }

    .faq-question:hover {
        background: var(--gradient-liquid-2);
        color: var(--prussian-blue);
    }

    .faq-question i {
        color: var(--bright-amber);
        transition: transform 0.3s;
        flex-shrink: 0;
        margin-left: 15px;
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

    @media (max-width: 576px) {
        .faq-answer {
            padding: 0 20px 15px;
            font-size: 0.9rem;
        }
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

    @media (max-width: 768px) {
        .carousel-section {
            margin-top: -60px;
            padding-bottom: 40px;
        }
    }

    @media (max-width: 576px) {
        .carousel-section {
            margin-top: -40px;
            padding-bottom: 30px;
        }
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
        padding: 10px 0;
    }

    @media (max-width: 768px) {
        .carousel-track {
            animation-duration: 30s;
            gap: 15px;
        }
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

    @media (min-width: 768px) {
        .carousel-item {
            width: 280px;
            height: 380px;
        }
    }

    @media (max-width: 576px) {
        .carousel-item {
            width: 180px;
            height: 250px;
        }
    }

    .carousel-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }

    .carousel-item:hover img {
        transform: scale(1.05);
    }

    /* Logo Cloud */
    .logo-cloud-section {
        padding: 50px 0;
        background: var(--pure-white);
        width: 100%;
        overflow: hidden;
    }

    @media (max-width: 768px) {
        .logo-cloud-section {
            padding: 40px 0;
        }
    }

    @media (max-width: 576px) {
        .logo-cloud-section {
            padding: 30px 0;
        }
    }

    .logo-cloud-title {
        text-align: center;
        color: var(--text-muted);
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 30px;
    }

    @media (max-width: 576px) {
        .logo-cloud-title {
            font-size: 0.75rem;
            margin-bottom: 20px;
        }
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
        padding-left: 20px;
    }

    @media (max-width: 768px) {
        .logo-track {
            gap: 30px;
            animation-duration: 35s;
        }
    }

    @media (max-width: 576px) {
        .logo-track {
            gap: 25px;
            animation-duration: 30s;
        }
    }

    .logo-item {
        flex-shrink: 0;
        filter: grayscale(100%) opacity(0.6);
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 120px;
    }

    @media (max-width: 768px) {
        .logo-item {
            min-width: 100px;
        }
    }

    @media (max-width: 576px) {
        .logo-item {
            min-width: 80px;
        }
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

    @media (max-width: 768px) {
        .logo-item img {
            height: 30px;
        }
    }

    @media (max-width: 576px) {
        .logo-item img {
            height: 25px;
        }
    }

    .logo-item span {
        font-size: 1.1rem;
        font-weight: 600;
        white-space: nowrap;
        color: var(--prussian-blue);
    }

    @media (max-width: 768px) {
        .logo-item span {
            font-size: 1rem;
        }
    }

    @media (max-width: 576px) {
        .logo-item span {
            font-size: 0.9rem;
        }
    }

    /* Responsive Spacing */
    @media (max-width: 768px) {
        .container {
            padding-left: 20px;
            padding-right: 20px;
        }
    }

    @media (max-width: 576px) {
        .container {
            padding-left: 15px;
            padding-right: 15px;
        }
    }

    /* Pause animation on hover for accessibility */
    .carousel-track:hover,
    .logo-track:hover {
        animation-play-state: paused;
    }

    /* Ensure buttons have proper touch targets on mobile */
    @media (max-width: 576px) {
        .btn,
        .course-btn,
        .faq-question {
            min-height: 44px;
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
                    <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=40&h=40&fit=crop" alt="Student" class="avatar" loading="lazy">
                    <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=40&h=40&fit=crop" alt="Student" class="avatar" loading="lazy">
                    <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=40&h=40&fit=crop" alt="Student" class="avatar" loading="lazy">
                </div>
                <div>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <span class="rating-text">{{ App\Helpers\TranslationHelper::trans('home.hero_rating_text') }}</span>
                </div>
            </div>

            <h1 class="hero-title">
                {{ App\Helpers\TranslationHelper::trans('home.hero_title_1') }} <span class="hero-title-gradient">{{ App\Helpers\TranslationHelper::trans('home.hero_title_highlight') }}</span><br>
                {{ App\Helpers\TranslationHelper::trans('home.hero_title_2') }}
            </h1>

            <p class="hero-text">
                {{ App\Helpers\TranslationHelper::trans('home.hero_description') }}
            </p>

            <div class="hero-features">
                <div class="hero-feature">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ App\Helpers\TranslationHelper::trans('home.hero_feature_ai') }}</span>
                </div>
                <div class="hero-feature">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ App\Helpers\TranslationHelper::trans('home.hero_feature_expert') }}</span>
                </div>
                <div class="hero-feature">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ App\Helpers\TranslationHelper::trans('home.hero_feature_practical') }}</span>
                </div>
            </div>

            <div class="hero-buttons">
                <a href="{{ route('academy') }}" class="btn btn-primary">
                    <i class="fas fa-graduation-cap"></i> {{ App\Helpers\TranslationHelper::trans('home.hero_btn_academy') }}
                </a>
                <a href="{{ route('courses') }}" class="btn btn-secondary">
                    <i class="fas fa-play-circle"></i> {{ App\Helpers\TranslationHelper::trans('home.hero_btn_courses') }}
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
                <img src="{{ $image }}" alt="Course preview" loading="lazy">
            </div>
            @endforeach

            @foreach($courseImages as $image)
            <div class="carousel-item">
                <img src="{{ $image }}" alt="Course preview" loading="lazy">
            </div>
            @endforeach
        </div>
    </div>
</section>



<!-- Process Section -->
<section class="process-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-subtitle">{{ App\Helpers\TranslationHelper::trans('home.process_subtitle') }}</span>
            <h2 class="section-title">{!! App\Helpers\TranslationHelper::trans('home.process_title') !!}</h2>
        </div>

        <div class="process-grid">
            <div class="process-card" data-aos="fade-up" data-aos-delay="100">
                <div class="process-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h3 class="process-title">{{ App\Helpers\TranslationHelper::trans('home.process_1_title') }}</h3>
                <p class="process-text">{{ App\Helpers\TranslationHelper::trans('home.process_1_desc') }}</p>
            </div>

            <div class="process-card" data-aos="fade-up" data-aos-delay="200">
                <div class="process-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <h3 class="process-title">{{ App\Helpers\TranslationHelper::trans('home.process_2_title') }}</h3>
                <p class="process-text">{{ App\Helpers\TranslationHelper::trans('home.process_2_desc') }}</p>
            </div>

            <div class="process-card" data-aos="fade-up" data-aos-delay="300">
                <div class="process-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h3 class="process-title">{{ App\Helpers\TranslationHelper::trans('home.process_3_title') }}</h3>
                <p class="process-text">{{ App\Helpers\TranslationHelper::trans('home.process_3_desc') }}</p>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-subtitle">{{ App\Helpers\TranslationHelper::trans('home.features_subtitle') }}</span>
            <h2 class="section-title">{!! App\Helpers\TranslationHelper::trans('home.features_title') !!}</h2>
        </div>

        <div class="features-grid">
            <div class="feature-card" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-icon">
                    <i class="fas fa-brain"></i>
                </div>
                <h3 class="feature-title">{{ App\Helpers\TranslationHelper::trans('home.feature_1_title') }}</h3>
                <p class="feature-text">{{ App\Helpers\TranslationHelper::trans('home.feature_1_desc') }}</p>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-icon">
                    <i class="fas fa-language"></i>
                </div>
                <h3 class="feature-title">{{ App\Helpers\TranslationHelper::trans('home.feature_2_title') }}</h3>
                <p class="feature-text">{{ App\Helpers\TranslationHelper::trans('home.feature_2_desc') }}</p>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3 class="feature-title">{{ App\Helpers\TranslationHelper::trans('home.feature_3_title') }}</h3>
                <p class="feature-text">{{ App\Helpers\TranslationHelper::trans('home.feature_3_desc') }}</p>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="400">
                <div class="feature-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3 class="feature-title">{{ App\Helpers\TranslationHelper::trans('home.feature_4_title') }}</h3>
                <p class="feature-text">{{ App\Helpers\TranslationHelper::trans('home.feature_4_desc') }}</p>
            </div>
        </div>
    </div>
</section>

<!-- Offer Banner -->
<section class="offer-banner" data-aos="fade-up">
    <div class="container">
        <div class="offer-content">
            <i class="fas fa-gift"></i>
            <h3>{{ App\Helpers\TranslationHelper::trans('home.offer_title') }}</h3>
            <p>{{ App\Helpers\TranslationHelper::trans('home.offer_description') }}</p>
            <a href="{{ route('academy') }}" class="btn btn-primary">{{ App\Helpers\TranslationHelper::trans('home.offer_btn') }}</a>
        </div>
    </div>
</section>

<!-- Courses Section -->
<section class="courses-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-subtitle">{{ App\Helpers\TranslationHelper::trans('home.courses_subtitle') }}</span>
            <h2 class="section-title">{!! App\Helpers\TranslationHelper::trans('home.courses_title') !!}</h2>
        </div>

        <div class="grid-3">
            @forelse($featuredCourses ?? [] as $course)
            <div class="course-card" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                <div class="course-image">
                    <img src="{{ $course->thumbnail_url ?? 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400&h=250&fit=crop' }}" alt="{{ $course->title }}" loading="lazy">
                    <span class="course-category">{{ $course->category->name ?? App\Helpers\TranslationHelper::trans('common.general') }}</span>
                    @if(isset($course->hasDiscount) && $course->hasDiscount)
                    <span class="course-discount-badge">-{{ $course->discount_percentage ?? 20 }}%</span>
                    @endif
                </div>
                <div class="course-content">
                    <div class="course-meta">
                        <span><i class="far fa-clock"></i> {{ App\Helpers\TranslationHelper::trans('home.course_hours', ['hours' => $course->duration ?? '10']) }}</span>
                        <span><i class="fas fa-signal"></i> {{ $course->level ?? __('common.beginner') }}</span>
                    </div>
                    <h3 class="course-title">
                        <a href="{{ route('courses.show', $course->slug ?? '#') }}">{{ $course->title ?? App\Helpers\TranslationHelper::trans('home.course_title_placeholder') }}</a>
                    </h3>
                    <p>{{ Str::limit($course->excerpt ?? App\Helpers\TranslationHelper::trans('home.course_desc_placeholder'), 80) }}</p>

                    @if(isset($course->total_students) && $course->total_students > 0)
                    <div class="course-stats">
                        <span><i class="fas fa-users"></i> {{ App\Helpers\TranslationHelper::trans('home.course_students', ['count' => number_format($course->total_students)]) }}</span>
                        @if(isset($course->average_rating) && $course->average_rating > 0)
                        <span>
                            <i class="fas fa-star"></i>
                            {{ App\Helpers\TranslationHelper::trans('home.course_rating', ['rating' => number_format($course->average_rating, 1)]) }}
                        </span>
                        @endif
                    </div>
                    @endif

                    <div class="course-footer">
                        <div class="course-price">
                            @if(isset($course->hasDiscount) && $course->hasDiscount)
                            ${{ number_format($course->sale_price ?? 19.99, 2) }}
                            <small>${{ number_format($course->price ?? 29.99, 2) }}</small>
                            @elseif(isset($course->price) && $course->price > 0)
                            ${{ number_format($course->price, 2) }}
                            @else
                            {{ App\Helpers\TranslationHelper::trans('home.course_free') }}
                            @endif
                        </div>
                        <a href="{{ route('courses.show', $course->slug ?? '#') }}" class="course-btn">
                            {{ isset($course->price) && $course->price > 0 ? App\Helpers\TranslationHelper::trans('home.course_enroll') : App\Helpers\TranslationHelper::trans('home.course_start') }}
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <!-- Sample courses for demonstration -->
            <div class="course-card" data-aos="fade-up" data-aos-delay="100">
                <div class="course-image">
                    <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400&h=250&fit=crop" alt="Business English" loading="lazy">
                    <span class="course-category">{{ App\Helpers\TranslationHelper::trans('common.language') }}</span>
                    <span class="course-discount-badge">-20%</span>
                </div>
                <div class="course-content">
                    <div class="course-meta">
                        <span><i class="far fa-clock"></i> {{ App\Helpers\TranslationHelper::trans('home.course_hours', ['hours' => '20']) }}</span>
                        <span><i class="fas fa-signal"></i> {{ App\Helpers\TranslationHelper::trans('common.intermediate') }}</span>
                    </div>
                    <h3 class="course-title">
                        <a href="#">{{ App\Helpers\TranslationHelper::trans('home.course_1_title') }}</a>
                    </h3>
                    <p>{{ App\Helpers\TranslationHelper::trans('home.course_1_desc') }}</p>

                    <div class="course-stats">
                        <span><i class="fas fa-users"></i> {{ App\Helpers\TranslationHelper::trans('home.course_students', ['count' => '1,234']) }}</span>
                        <span><i class="fas fa-star"></i> {{ App\Helpers\TranslationHelper::trans('home.course_rating', ['rating' => '4.8']) }}</span>
                    </div>

                    <div class="course-footer">
                        <div class="course-price">
                            $39.99
                            <small>$49.99</small>
                        </div>
                        <a href="#" class="course-btn">
                            {{ App\Helpers\TranslationHelper::trans('home.course_enroll') }} <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="course-card" data-aos="fade-up" data-aos-delay="200">
                <div class="course-image">
                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=400&h=250&fit=crop" alt="Digital Marketing" loading="lazy">
                    <span class="course-category">{{ App\Helpers\TranslationHelper::trans('common.business') }}</span>
                </div>
                <div class="course-content">
                    <div class="course-meta">
                        <span><i class="far fa-clock"></i> {{ App\Helpers\TranslationHelper::trans('home.course_hours', ['hours' => '15']) }}</span>
                        <span><i class="fas fa-signal"></i> {{ App\Helpers\TranslationHelper::trans('common.beginner') }}</span>
                    </div>
                    <h3 class="course-title">
                        <a href="#">{{ App\Helpers\TranslationHelper::trans('home.course_2_title') }}</a>
                    </h3>
                    <p>{{ App\Helpers\TranslationHelper::trans('home.course_2_desc') }}</p>

                    <div class="course-stats">
                        <span><i class="fas fa-users"></i> {{ App\Helpers\TranslationHelper::trans('home.course_students', ['count' => '2,567']) }}</span>
                        <span><i class="fas fa-star"></i> {{ App\Helpers\TranslationHelper::trans('home.course_rating', ['rating' => '4.9']) }}</span>
                    </div>

                    <div class="course-footer">
                        <div class="course-price">
                            $29.99
                        </div>
                        <a href="#" class="course-btn">
                            {{ App\Helpers\TranslationHelper::trans('home.course_enroll') }} <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="course-card" data-aos="fade-up" data-aos-delay="300">
                <div class="course-image">
                    <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=400&h=250&fit=crop" alt="French Language" loading="lazy">
                    <span class="course-category">{{ App\Helpers\TranslationHelper::trans('common.language') }}</span>
                </div>
                <div class="course-content">
                    <div class="course-meta">
                        <span><i class="far fa-clock"></i> {{ App\Helpers\TranslationHelper::trans('home.course_hours', ['hours' => '25']) }}</span>
                        <span><i class="fas fa-signal"></i> {{ App\Helpers\TranslationHelper::trans('common.all_levels') }}</span>
                    </div>
                    <h3 class="course-title">
                        <a href="#">{{ App\Helpers\TranslationHelper::trans('home.course_3_title') }}</a>
                    </h3>
                    <p>{{ App\Helpers\TranslationHelper::trans('home.course_3_desc') }}</p>

                    <div class="course-stats">
                        <span><i class="fas fa-users"></i> {{ App\Helpers\TranslationHelper::trans('home.course_students', ['count' => '3,892']) }}</span>
                        <span><i class="fas fa-star"></i> {{ App\Helpers\TranslationHelper::trans('home.course_rating', ['rating' => '4.7']) }}</span>
                    </div>

                    <div class="course-footer">
                        <div class="course-price">
                            $44.99
                        </div>
                        <a href="#" class="course-btn">
                            {{ App\Helpers\TranslationHelper::trans('home.course_enroll') }} <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforelse
        </div>

        <div style="text-align: center; margin-top: 40px;">
            <a href="{{ route('courses') }}" class="btn btn-primary">
                {{ App\Helpers\TranslationHelper::trans('home.course_view_all') }} <i class="fas fa-arrow-right"></i>
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
                <div class="stats-label">{{ App\Helpers\TranslationHelper::trans('home.stats_students') }}</div>
            </div>
            <div class="stats-item" data-aos="zoom-in" data-aos-delay="200">
                <div class="stats-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <div class="stats-number" data-target="50">50+</div>
                <div class="stats-label">{{ App\Helpers\TranslationHelper::trans('home.stats_instructors') }}</div>
            </div>
            <div class="stats-item" data-aos="zoom-in" data-aos-delay="300">
                <div class="stats-icon">
                    <i class="fas fa-globe"></i>
                </div>
                <div class="stats-number" data-target="15">15+</div>
                <div class="stats-label">{{ App\Helpers\TranslationHelper::trans('home.stats_countries') }}</div>
            </div>
            <div class="stats-item" data-aos="zoom-in" data-aos-delay="400">
                <div class="stats-icon">
                    <i class="fas fa-award"></i>
                </div>
                <div class="stats-number" data-target="4.9">4.9</div>
                <div class="stats-label">{{ App\Helpers\TranslationHelper::trans('home.stats_rating') }}</div>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="about-section">
    <div class="container">
        <div class="about-grid">
            <div class="about-content" data-aos="fade-right">
                <span class="section-subtitle">{{ App\Helpers\TranslationHelper::trans('home.about_subtitle') }}</span>
                <h2 class="section-title">{!! App\Helpers\TranslationHelper::trans('home.about_title') !!}</h2>
                <p>{!! App\Helpers\TranslationHelper::trans('home.about_description_1') !!}</p>
                <p>{!! App\Helpers\TranslationHelper::trans('home.about_description_2') !!}</p>
                <div class="about-features">
                    <div class="about-feature">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ App\Helpers\TranslationHelper::trans('home.about_feature_1') }}</span>
                    </div>
                    <div class="about-feature">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ App\Helpers\TranslationHelper::trans('home.about_feature_2') }}</span>
                    </div>
                    <div class="about-feature">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ App\Helpers\TranslationHelper::trans('home.about_feature_3') }}</span>
                    </div>
                    <div class="about-feature">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ App\Helpers\TranslationHelper::trans('home.about_feature_4') }}</span>
                    </div>
                </div>
                <a href="{{ route('about') }}" class="btn btn-primary">
                    {{ App\Helpers\TranslationHelper::trans('home.about_btn') }} <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="about-image" data-aos="fade-left">
                <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&q=80" alt="About EDUCONECX" loading="lazy">
                <div class="experience-badge">
                    <span class="years">5+</span>
                    <span class="text">{{ App\Helpers\TranslationHelper::trans('home.about_experience') }}</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="testimonials-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-subtitle">{{ App\Helpers\TranslationHelper::trans('home.testimonials_subtitle') }}</span>
            <h2 class="section-title">{!! App\Helpers\TranslationHelper::trans('home.testimonials_title') !!}</h2>
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
                    "{{ App\Helpers\TranslationHelper::trans('home.testimonial_1_text') }}"
                </p>
                <div class="testimonial-author">
                    <div class="author-image">
                        <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=60&h=60&fit=crop" alt="Sarah M." loading="lazy">
                    </div>
                    <div class="author-info">
                        <h4>{{ App\Helpers\TranslationHelper::trans('home.testimonial_1_name') }}</h4>
                        <p>{{ App\Helpers\TranslationHelper::trans('home.testimonial_1_role') }}</p>
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
                    "{{ App\Helpers\TranslationHelper::trans('home.testimonial_2_text') }}"
                </p>
                <div class="testimonial-author">
                    <div class="author-image">
                        <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=60&h=60&fit=crop" alt="Daniel K." loading="lazy">
                    </div>
                    <div class="author-info">
                        <h4>{{ App\Helpers\TranslationHelper::trans('home.testimonial_2_name') }}</h4>
                        <p>{{ App\Helpers\TranslationHelper::trans('home.testimonial_2_role') }}</p>
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
                    "{{ App\Helpers\TranslationHelper::trans('home.testimonial_3_text') }}"
                </p>
                <div class="testimonial-author">
                    <div class="author-image">
                        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=60&h=60&fit=crop" alt="Aisha R." loading="lazy">
                    </div>
                    <div class="author-info">
                        <h4>{{ App\Helpers\TranslationHelper::trans('home.testimonial_3_name') }}</h4>
                        <p>{{ App\Helpers\TranslationHelper::trans('home.testimonial_3_role') }}</p>
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
            <div class="cta-badge">{{ App\Helpers\TranslationHelper::trans('home.cta_badge') }}</div>
            <h2 class="cta-title">
                {!! App\Helpers\TranslationHelper::trans('home.cta_title') !!}
            </h2>
            <p class="cta-text">
                {{ App\Helpers\TranslationHelper::trans('home.cta_description') }}
            </p>
            <div class="cta-buttons">
                <a href="{{ route('academy') }}" class="btn btn-primary">
                    <i class="fas fa-graduation-cap"></i> {{ App\Helpers\TranslationHelper::trans('home.cta_btn_start') }}
                </a>
                <a href="{{ route('contact') }}" class="btn btn-secondary">
                    <i class="fas fa-headset"></i> {{ App\Helpers\TranslationHelper::trans('home.cta_btn_advisor') }}
                </a>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="faq-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-subtitle">{{ App\Helpers\TranslationHelper::trans('home.faq_subtitle') }}</span>
            <h2 class="section-title">{!! App\Helpers\TranslationHelper::trans('home.faq_title') !!}</h2>
        </div>

        <div class="faq-grid">
            <div class="faq-item" data-aos="fade-up">
                <div class="faq-question">
                    <span>{{ App\Helpers\TranslationHelper::trans('home.faq_1_q') }}</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>{{ App\Helpers\TranslationHelper::trans('home.faq_1_a') }}</p>
                </div>
            </div>

            <div class="faq-item" data-aos="fade-up" data-aos-delay="100">
                <div class="faq-question">
                    <span>{{ App\Helpers\TranslationHelper::trans('home.faq_2_q') }}</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>{{ App\Helpers\TranslationHelper::trans('home.faq_2_a') }}</p>
                </div>
            </div>

    

            <div class="faq-item" data-aos="fade-up" data-aos-delay="300">
                <div class="faq-question">
                    <span>{{ App\Helpers\TranslationHelper::trans('home.faq_4_q') }}</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>{{ App\Helpers\TranslationHelper::trans('home.faq_4_a') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // FAQ Accordion
        const faqItems = document.querySelectorAll('.faq-item');
        
        faqItems.forEach(item => {
            const question = item.querySelector('.faq-question');
            
            question.addEventListener('click', () => {
                const wasActive = item.classList.contains('active');
                
                // Close all FAQ items
                faqItems.forEach(faq => {
                    faq.classList.remove('active');
                });
                
                // Open clicked item if it wasn't active
                if (!wasActive) {
                    item.classList.add('active');
                }
            });
        });

        // Counter Animation with Intersection Observer
        function animateValue(element, start, end, duration) {
            if (start === end) return;
            
            const range = end - start;
            const increment = range / (duration / 16);
            let current = start;
            const target = element.getAttribute('data-target');
            const hasPlus = element.textContent.includes('+');

            const timer = setInterval(() => {
                current += increment;
                
                if (current >= end) {
                    element.textContent = end.toLocaleString() + (hasPlus ? '+' : '');
                    clearInterval(timer);
                } else {
                    element.textContent = Math.floor(current).toLocaleString() + (hasPlus ? '+' : '');
                }
            }, 16);
        }

        // Stats Observer
        const statsObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const statsNumbers = document.querySelectorAll('.stats-number');
                    
                    statsNumbers.forEach(stat => {
                        const targetValue = parseFloat(stat.getAttribute('data-target'));
                        const currentValue = parseFloat(stat.textContent.replace(/[+,]/g, ''));
                        
                        if (!isNaN(targetValue) && !isNaN(currentValue)) {
                            animateValue(stat, 0, targetValue, 2000);
                        }
                    });
                    
                    statsObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        const statsSection = document.querySelector('.stats-section');
        if (statsSection) statsObserver.observe(statsSection);

        // Header scroll effect
        const header = document.querySelector('header');
        
        if (header) {
            window.addEventListener('scroll', () => {
                if (window.scrollY > 50) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
            });
        }

        // AOS initialization with mobile optimization
        if (typeof AOS !== 'undefined') {
            AOS.init({
                duration: window.innerWidth < 768 ? 400 : 800,
                once: true,
                offset: window.innerWidth < 768 ? 20 : 50,
                disable: window.innerWidth < 576 // Disable on very small screens for performance
            });
        }

        // Pause carousel animations on hover for accessibility
        const carouselTrack = document.querySelector('.carousel-track');
        const logoTrack = document.querySelector('.logo-track');
        
        if (carouselTrack) {
            carouselTrack.addEventListener('mouseenter', () => {
                carouselTrack.style.animationPlayState = 'paused';
            });
            
            carouselTrack.addEventListener('mouseleave', () => {
                carouselTrack.style.animationPlayState = 'running';
            });
        }
        
        if (logoTrack) {
            logoTrack.addEventListener('mouseenter', () => {
                logoTrack.style.animationPlayState = 'paused';
            });
            
            logoTrack.addEventListener('mouseleave', () => {
                logoTrack.style.animationPlayState = 'running';
            });
        }

        // Handle touch events for mobile
        if ('ontouchstart' in window) {
            document.querySelectorAll('.btn, .course-btn, .faq-question').forEach(element => {
                element.addEventListener('touchstart', function() {
                    // Add active state for touch feedback
                    this.style.opacity = '0.8';
                });
                
                element.addEventListener('touchend', function() {
                    this.style.opacity = '1';
                });
            });
        }
    });

    // Lazy loading for images
    if ('loading' in HTMLImageElement.prototype) {
        // Browser supports native lazy loading
        const images = document.querySelectorAll('img[loading="lazy"]');
        images.forEach(img => {
            img.loading = 'lazy';
        });
    } else {
        // Fallback for browsers that don't support lazy loading
        // You could implement a library like lazysizes here
    }
</script>
@endpush