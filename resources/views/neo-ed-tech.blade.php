@extends('layouts.main')

@section('title', App\Helpers\TranslationHelper::trans('neo.title'))

@section('meta_description', App\Helpers\TranslationHelper::trans('neo.meta_description'))

@push('styles')
<style>
    /* Root Variables */
    :root {
        --primary: #4361ee;
        --primary-dark: #3a56d4;
        --primary-light: #4895ef;
        --secondary: #4cc9f0;
        --accent: #f72585;
        --success: #06d6a0;
        --warning: #ffd166;
        --danger: #ef476f;
        --dark: #1e1e2f;
        --dark-light: #2d2d44;
        --gray: #6c757d;
        --gray-light: #e9ecef;
        --light: #f8f9fa;
        --white: #ffffff;
        --black: #000000;
        --gradient-1: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
        --gradient-2: linear-gradient(135deg, #f72585 0%, #b5179e 100%);
        --gradient-3: linear-gradient(135deg, #4cc9f0 0%, #4361ee 100%);
        --shadow-sm: 0 5px 15px rgba(0, 0, 0, 0.05);
        --shadow-md: 0 10px 30px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 20px 40px rgba(0, 0, 0, 0.15);
        --shadow-hover: 0 30px 50px rgba(67, 97, 238, 0.2);
        --border-radius-sm: 8px;
        --border-radius-md: 12px;
        --border-radius-lg: 20px;
        --border-radius-xl: 30px;
        --border-radius-full: 9999px;
        --transition: all 0.3s ease;
        --transition-slow: all 0.5s ease;
    }

    /* Hide default site header and footer for this page */
    body .main-header,
    body header:not(.neo-header),
    body .site-header,
    body #header,
    body .header-area {
        display: none !important;
    }
    
    body .main-footer,
    body footer:not(.neo-footer),
    body .site-footer,
    body #footer,
    body .footer-area {
        display: none !important;
    }

    /* Reset body styles for this page */
    body {
        background: var(--white);
        padding-top: 0 !important;
        margin-top: 0 !important;
        overflow-x: hidden;
    }

    /* Ensure main content starts from top */
    main {
        margin-top: 0 !important;
        padding-top: 0 !important;
    }

    /* Animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(40px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInRight {
        from {
            opacity: 0;
            transform: translateX(40px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    /* Header/Navbar Styles */
    .neo-header {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        z-index: 9999;
        transition: var(--transition);
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .neo-header.scrolled {
        box-shadow: var(--shadow-md);
    }

    .neo-header .container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 15px 30px;
        max-width: 1400px;
        margin: 0 auto;
        width: 100%;
    }

    @media (max-width: 768px) {
        .neo-header .container {
            padding: 15px 20px;
        }
    }

    .logo {
        flex-shrink: 0;
    }

    .logo img {
        height: 50px;
        width: auto;
    }

    @media (max-width: 576px) {
        .logo img {
            height: 40px;
        }
    }

    .nav-menu {
        display: flex;
        align-items: center;
        gap: 40px;
    }

    @media (max-width: 768px) {
        .nav-menu {
            position: fixed;
            top: 0;
            right: -100%;
            width: 80%;
            max-width: 400px;
            height: 100vh;
            background: var(--white);
            flex-direction: column;
            justify-content: flex-start;
            padding: 100px 30px 30px;
            transition: right 0.3s ease;
            box-shadow: var(--shadow-lg);
            z-index: 9999;
        }

        .nav-menu.active {
            right: 0;
        }
    }

    @media (max-width: 576px) {
        .nav-menu {
            width: 85%;
            padding: 80px 20px 20px;
        }
    }

    .nav-links {
        display: flex;
        gap: 30px;
    }

    @media (max-width: 768px) {
        .nav-links {
            flex-direction: column;
            width: 100%;
            gap: 20px;
        }
    }

    .nav-links a {
        color: var(--dark);
        font-weight: 500;
        font-size: 1rem;
        transition: var(--transition);
        position: relative;
        text-decoration: none;
    }

    @media (max-width: 768px) {
        .nav-links a {
            font-size: 1.1rem;
            padding: 10px 0;
            display: block;
        }
    }

    .nav-links a:hover,
    .nav-links a.active {
        color: var(--primary);
    }

    .nav-links a::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 0;
        height: 2px;
        background: var(--gradient-1);
        transition: var(--transition);
    }

    @media (max-width: 768px) {
        .nav-links a::after {
            bottom: 5px;
        }
    }

    .nav-links a:hover::after,
    .nav-links a.active::after {
        width: 100%;
    }

    .contact-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 12px 30px;
        background: var(--gradient-1);
        color: var(--white);
        border-radius: var(--border-radius-full);
        font-weight: 600;
        font-size: 0.95rem;
        transition: var(--transition);
        box-shadow: var(--shadow-sm);
        text-decoration: none;
    }

    @media (max-width: 768px) {
        .contact-btn {
            width: 100%;
            text-align: center;
            margin-top: 20px;
        }
    }

    .contact-btn:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-hover);
        color: var(--white);
    }

    .mobile-menu-btn {
        display: none;
        flex-direction: column;
        gap: 6px;
        cursor: pointer;
        z-index: 10000;
    }

    @media (max-width: 768px) {
        .mobile-menu-btn {
            display: flex;
        }
    }

    .mobile-menu-btn span {
        width: 30px;
        height: 3px;
        background: var(--dark);
        border-radius: var(--border-radius-full);
        transition: var(--transition);
    }

    .mobile-menu-btn.active span:nth-child(1) {
        transform: rotate(45deg) translate(8px, 8px);
    }

    .mobile-menu-btn.active span:nth-child(2) {
        opacity: 0;
    }

    .mobile-menu-btn.active span:nth-child(3) {
        transform: rotate(-45deg) translate(8px, -8px);
    }

    /* Hero Section - Updated with background image */
    .neo-hero {
        position: relative;
        min-height: 100vh;
        display: flex;
        align-items: center;
        background-image: url('https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=1920&q=80');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        overflow: hidden;
        padding: 120px 0 60px;
        margin-top: 0;
    }

    /* Add overlay for better text readability */
    .neo-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(67, 97, 238, 0.9) 0%, rgba(58, 12, 163, 0.9) 100%);
        z-index: 1;
    }

    /* Keep the grid pattern but adjust opacity */
    .neo-hero::after {
        content: '';
        position: absolute;
        inset: 0;
        background-image: 
            linear-gradient(rgba(255, 255, 255, 0.03) 2px, transparent 2px),
            linear-gradient(90deg, rgba(255, 255, 255, 0.03) 2px, transparent 2px),
            linear-gradient(rgba(255, 255, 255, 0.02) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255, 255, 255, 0.02) 1px, transparent 1px);
        background-position: -2px -2px, -2px -2px, -1px -1px, -1px -1px;
        background-size: 200px 200px, 200px 200px, 40px 40px, 40px 40px;
        opacity: 0.5;
        pointer-events: none;
        z-index: 2;
    }

    @media (max-width: 768px) {
        .neo-hero {
            padding: 100px 0 50px;
            min-height: 90vh;
        }
    }

    @media (max-width: 576px) {
        .neo-hero {
            padding: 80px 0 40px;
            min-height: 85vh;
        }
    }

    .neo-hero-particles {
        position: absolute;
        inset: 0;
        z-index: 3;
    }

    .neo-hero-particle {
        position: absolute;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        pointer-events: none;
    }

    .neo-hero-particle:nth-child(1) {
        width: 300px;
        height: 300px;
        top: -100px;
        right: -100px;
        animation: float 8s ease-in-out infinite;
    }

    @media (max-width: 768px) {
        .neo-hero-particle:nth-child(1) {
            width: 200px;
            height: 200px;
            top: -50px;
            right: -50px;
        }
    }

    .neo-hero-particle:nth-child(2) {
        width: 200px;
        height: 200px;
        bottom: -50px;
        left: -50px;
        animation: float 10s ease-in-out infinite reverse;
    }

    @media (max-width: 768px) {
        .neo-hero-particle:nth-child(2) {
            width: 150px;
            height: 150px;
            bottom: -30px;
            left: -30px;
        }
    }

    .neo-hero-particle:nth-child(3) {
        width: 150px;
        height: 150px;
        top: 50%;
        left: 20%;
        animation: float 12s ease-in-out infinite;
    }

    @media (max-width: 768px) {
        .neo-hero-particle:nth-child(3) {
            width: 100px;
            height: 100px;
        }
    }

    .neo-hero-particle:nth-child(4) {
        width: 100px;
        height: 100px;
        top: 20%;
        right: 30%;
        animation: float 15s ease-in-out infinite;
    }

    .neo-hero-content {
        position: relative;
        z-index: 4;
        color: var(--white);
        max-width: 900px;
        padding: 0 20px;
    }

    .neo-hero-title {
        font-size: clamp(2rem, 8vw, 4.5rem);
        font-weight: 800;
        line-height: 1.1;
        margin-bottom: 20px;
        text-shadow: 0 2px 20px rgba(0, 0, 0, 0.3);
    }

    .neo-hero-title span {
        background: linear-gradient(135deg, #fff, #ffd700);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        display: inline-block;
    }

    .neo-hero-subtitle {
        font-size: clamp(1rem, 3vw, 1.3rem);
        margin-bottom: 40px;
        opacity: 0.9;
        max-width: 700px;
    }

    @media (max-width: 768px) {
        .neo-hero-subtitle {
            margin-bottom: 30px;
        }
    }

    .neo-hero-buttons {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        margin-bottom: 40px;
    }

    @media (max-width: 768px) {
        .neo-hero-buttons {
            flex-direction: column;
            gap: 15px;
        }
    }

    .neo-hero-buttons .btn {
        min-width: 200px;
        position: relative;
        overflow: hidden;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 14px 30px;
        border-radius: var(--border-radius-full);
        font-weight: 600;
        font-size: 1rem;
        transition: var(--transition);
        cursor: pointer;
    }

    @media (max-width: 768px) {
        .neo-hero-buttons .btn {
            width: 100%;
            min-width: auto;
            padding: 14px 20px;
        }
    }

    .neo-hero-buttons .btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
        z-index: -1;
    }

    .neo-hero-buttons .btn:hover::before {
        width: 300px;
        height: 300px;
    }

    .neo-hero-buttons .btn-primary {
        background: var(--white);
        color: var(--primary);
        border: 2px solid var(--white);
    }

    .neo-hero-buttons .btn-secondary {
        background: transparent;
        color: var(--white);
        border: 2px solid var(--white);
    }

    .neo-hero-buttons .btn-secondary:hover {
        background: var(--white);
        color: var(--primary);
    }

    .neo-divider {
        width: 100%;
        height: 2px;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.5), transparent);
        margin: 40px 0;
    }

    .neo-trust-badge {
        display: flex;
        align-items: center;
        gap: 40px;
        flex-wrap: wrap;
    }

    @media (max-width: 768px) {
        .neo-trust-badge {
            flex-direction: column;
            align-items: flex-start;
            gap: 20px;
        }
    }

    .neo-counter {
        font-size: 1.5rem;
        font-weight: 600;
    }

    .neo-counter .number {
        font-size: 2.5rem;
        font-weight: 800;
        margin-right: 5px;
    }

    @media (max-width: 576px) {
        .neo-counter .number {
            font-size: 2rem;
        }
    }

    .neo-avatar-group {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
    }

    .neo-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 2px solid var(--white);
        margin-left: -10px;
        transition: var(--transition);
        object-fit: cover;
    }

    .neo-avatar:first-child {
        margin-left: 0;
    }

    .neo-avatar:hover {
        transform: translateY(-3px);
        z-index: 10;
    }

    @media (max-width: 576px) {
        .neo-avatar {
            width: 35px;
            height: 35px;
        }
    }

    /* Services Section */
    .neo-services {
        padding: 80px 0;
        background: var(--white);
    }

    @media (max-width: 768px) {
        .neo-services {
            padding: 60px 0;
        }
    }

    @media (max-width: 576px) {
        .neo-services {
            padding: 50px 0;
        }
    }

    .neo-section-header {
        text-align: center;
        margin-bottom: 60px;
        padding: 0 20px;
    }

    @media (max-width: 768px) {
        .neo-section-header {
            margin-bottom: 40px;
        }
    }

    .neo-section-subtitle {
        display: inline-block;
        color: var(--primary);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 15px;
        font-size: 0.9rem;
    }

    @media (max-width: 576px) {
        .neo-section-subtitle {
            font-size: 0.8rem;
        }
    }

    .neo-section-title {
        font-size: clamp(1.8rem, 5vw, 3rem);
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 20px;
    }

    .neo-section-title span {
        background: var(--gradient-1);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .neo-section-description {
        max-width: 800px;
        margin: 0 auto;
        color: var(--gray);
        font-size: 1.1rem;
        line-height: 1.8;
    }

    @media (max-width: 768px) {
        .neo-section-description {
            font-size: 1rem;
        }
    }

    .neo-services-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        margin-top: 50px;
        padding: 0 20px;
    }

    @media (max-width: 1024px) {
        .neo-services-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
    }

    @media (max-width: 768px) {
        .neo-services-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
    }

    .neo-service-card {
        background: var(--white);
        border-radius: var(--border-radius-lg);
        padding: 40px 30px;
        box-shadow: var(--shadow-md);
        transition: var(--transition);
        border: 1px solid rgba(0, 0, 0, 0.05);
        position: relative;
        overflow: hidden;
        height: 100%;
    }

    @media (max-width: 768px) {
        .neo-service-card {
            padding: 30px 25px;
        }
    }

    @media (max-width: 576px) {
        .neo-service-card {
            padding: 30px 20px;
        }
    }

    .neo-service-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--gradient-1);
        transform: scaleX(0);
        transition: var(--transition);
    }

    .neo-service-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-hover);
    }

    .neo-service-card:hover::before {
        transform: scaleX(1);
    }

    .neo-service-icon {
        width: 70px;
        height: 70px;
        background: var(--gradient-1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 25px;
        color: var(--white);
        font-size: 1.8rem;
        transition: var(--transition);
    }

    @media (max-width: 768px) {
        .neo-service-icon {
            width: 60px;
            height: 60px;
            font-size: 1.5rem;
            margin-bottom: 20px;
        }
    }

    .neo-service-card:hover .neo-service-icon {
        transform: rotateY(180deg) scale(1.1);
    }

    .neo-service-title {
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 15px;
    }

    @media (max-width: 768px) {
        .neo-service-title {
            font-size: 1.2rem;
        }
    }

    .neo-service-text {
        color: var(--gray);
        line-height: 1.6;
        margin-bottom: 25px;
        font-size: 0.95rem;
    }

    .neo-service-list {
        list-style: none;
        padding: 0;
    }

    .neo-service-list li {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 12px;
        color: var(--dark);
        font-size: 0.95rem;
    }

    .neo-service-list i {
        color: var(--success);
        font-size: 1rem;
        flex-shrink: 0;
    }

    @media (max-width: 576px) {
        .neo-service-list li {
            font-size: 0.9rem;
        }
    }

    /* About Section */
    .neo-about {
        padding: 80px 0;
        background: var(--light);
    }

    @media (max-width: 768px) {
        .neo-about {
            padding: 60px 0;
        }
    }

    @media (max-width: 576px) {
        .neo-about {
            padding: 50px 0;
        }
    }

    .neo-about-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: center;
        padding: 0 20px;
    }

    @media (max-width: 1024px) {
        .neo-about-grid {
            gap: 40px;
        }
    }

    @media (max-width: 768px) {
        .neo-about-grid {
            grid-template-columns: 1fr;
            gap: 40px;
        }
    }

    .neo-about-content p {
        color: var(--gray);
        line-height: 1.8;
        margin-bottom: 20px;
    }

    .neo-about-features {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin: 30px 0;
    }

    @media (max-width: 768px) {
        .neo-about-features {
            grid-template-columns: 1fr;
            gap: 15px;
        }
    }

    .neo-about-feature {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .neo-about-feature i {
        color: var(--success);
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .neo-about-cards {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    @media (max-width: 768px) {
        .neo-about-cards {
            grid-template-columns: 1fr;
            gap: 15px;
        }
    }

    .neo-about-card {
        background: var(--white);
        padding: 30px;
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-md);
        transition: var(--transition);
    }

    @media (max-width: 768px) {
        .neo-about-card {
            padding: 25px;
        }
    }

    .neo-about-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-hover);
    }

    .neo-about-card-icon {
        width: 50px;
        height: 50px;
        background: var(--gradient-1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        font-size: 1.3rem;
        margin-bottom: 20px;
    }

    .neo-about-card h3 {
        font-size: 1.2rem;
        margin-bottom: 10px;
    }

    .neo-about-card p {
        color: var(--gray);
        font-size: 0.95rem;
        line-height: 1.6;
    }

    /* Testimonials Section */
    .neo-testimonials {
        padding: 80px 0;
        background: var(--white);
    }

    @media (max-width: 768px) {
        .neo-testimonials {
            padding: 60px 0;
        }
    }

    @media (max-width: 576px) {
        .neo-testimonials {
            padding: 50px 0;
        }
    }

    .neo-testimonials-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 30px;
        margin-top: 50px;
        padding: 0 20px;
    }

    @media (max-width: 768px) {
        .neo-testimonials-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
    }

    .neo-testimonial-card {
        background: var(--white);
        padding: 40px;
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-md);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    @media (max-width: 768px) {
        .neo-testimonial-card {
            padding: 30px;
        }
    }

    @media (max-width: 576px) {
        .neo-testimonial-card {
            padding: 30px 20px;
        }
    }

    .neo-testimonial-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-hover);
    }

    .neo-testimonial-card::before {
        content: '"';
        position: absolute;
        top: 20px;
        right: 30px;
        font-size: 8rem;
        font-family: serif;
        color: var(--primary);
        opacity: 0.1;
        line-height: 1;
    }

    .neo-testimonial-rating {
        color: #ffd700;
        font-size: 1.1rem;
        margin-bottom: 20px;
    }

    .neo-testimonial-text {
        color: var(--gray);
        line-height: 1.8;
        margin-bottom: 25px;
        position: relative;
        z-index: 1;
        font-size: 0.95rem;
    }

    .neo-testimonial-author {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .neo-author-image {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        overflow: hidden;
        border: 3px solid var(--primary);
        flex-shrink: 0;
    }

    @media (max-width: 576px) {
        .neo-author-image {
            width: 50px;
            height: 50px;
        }
    }

    .neo-author-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .neo-author-info h4 {
        font-size: 1.1rem;
        margin-bottom: 5px;
    }

    .neo-author-info p {
        color: var(--gray);
        font-size: 0.9rem;
    }

    /* Contact Section */
    .neo-contact {
        padding: 80px 0;
        background: var(--gradient-1);
        color: var(--white);
        position: relative;
        overflow: hidden;
    }

    @media (max-width: 768px) {
        .neo-contact {
            padding: 60px 0;
        }
    }

    @media (max-width: 576px) {
        .neo-contact {
            padding: 50px 0;
        }
    }

    .neo-contact::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: 
            linear-gradient(rgba(255, 255, 255, 0.05) 2px, transparent 2px),
            linear-gradient(90deg, rgba(255, 255, 255, 0.05) 2px, transparent 2px);
        background-size: 50px 50px;
        opacity: 0.3;
    }

    .neo-contact-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        position: relative;
        z-index: 1;
        padding: 0 20px;
    }

    @media (max-width: 1024px) {
        .neo-contact-grid {
            gap: 40px;
        }
    }

    @media (max-width: 768px) {
        .neo-contact-grid {
            grid-template-columns: 1fr;
            gap: 40px;
        }
    }

    .neo-contact-info {
        padding-right: 40px;
    }

    @media (max-width: 768px) {
        .neo-contact-info {
            padding-right: 0;
        }
    }

    .neo-contact-title {
        font-size: clamp(2rem, 5vw, 2.5rem);
        font-weight: 800;
        margin-bottom: 20px;
        line-height: 1.2;
    }

    .neo-contact-title span {
        background: linear-gradient(135deg, #fff, #ffd700);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .neo-contact-text {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 40px;
        line-height: 1.8;
    }

    @media (max-width: 768px) {
        .neo-contact-text {
            font-size: 1rem;
            margin-bottom: 30px;
        }
    }

    .neo-contact-details {
        display: flex;
        flex-direction: column;
        gap: 25px;
    }

    .neo-contact-item {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .neo-contact-icon {
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        backdrop-filter: blur(5px);
        -webkit-backdrop-filter: blur(5px);
        flex-shrink: 0;
    }

    .neo-contact-item h3 {
        font-size: 1.1rem;
        margin-bottom: 5px;
        opacity: 0.9;
    }

    .neo-contact-item p {
        font-size: 1rem;
        font-weight: 600;
    }

    .neo-contact-form {
        background: var(--white);
        padding: 40px;
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-lg);
    }

    @media (max-width: 768px) {
        .neo-contact-form {
            padding: 30px;
        }
    }

    @media (max-width: 576px) {
        .neo-contact-form {
            padding: 30px 20px;
        }
    }

    .neo-form-title {
        color: var(--dark);
        font-size: 1.5rem;
        margin-bottom: 30px;
        text-align: center;
    }

    .neo-form-group {
        margin-bottom: 20px;
    }

    .neo-form-group label {
        display: block;
        margin-bottom: 8px;
        color: var(--dark);
        font-weight: 500;
        font-size: 0.95rem;
    }

    .neo-form-control {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid var(--gray-light);
        border-radius: var(--border-radius-md);
        font-size: 0.95rem;
        transition: var(--transition);
        font-family: 'Inter', sans-serif;
    }

    .neo-form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
    }

    select.neo-form-control {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236c757d' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 15px center;
        background-size: 16px;
    }

    textarea.neo-form-control {
        resize: vertical;
        min-height: 120px;
    }

    .neo-form-submit {
        width: 100%;
        padding: 14px;
        background: var(--gradient-1);
        color: var(--white);
        border: none;
        border-radius: var(--border-radius-md);
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
    }

    .neo-form-submit:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-hover);
    }

    /* Footer */
    .neo-footer {
        background: var(--dark);
        color: var(--white);
        padding: 60px 0 30px;
    }

    @media (max-width: 768px) {
        .neo-footer {
            padding: 50px 0 30px;
        }
    }

    .neo-footer-grid {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 2fr;
        gap: 40px;
        margin-bottom: 40px;
        padding: 0 20px;
    }

    @media (max-width: 1024px) {
        .neo-footer-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 30px;
        }
    }

    @media (max-width: 768px) {
        .neo-footer-grid {
            grid-template-columns: 1fr;
            gap: 30px;
        }
    }

    .neo-footer-logo img {
        height: 50px;
        width: auto;
        margin-bottom: 20px;
    }

    .neo-footer-about {
        opacity: 0.8;
        line-height: 1.8;
        font-size: 0.95rem;
        margin-bottom: 25px;
    }

    .neo-footer-title {
        font-size: 1.2rem;
        margin-bottom: 25px;
        position: relative;
        padding-bottom: 15px;
    }

    .neo-footer-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 2px;
        background: var(--gradient-1);
    }

    .neo-footer-links {
        list-style: none;
        padding: 0;
    }

    .neo-footer-links li {
        margin-bottom: 12px;
    }

    .neo-footer-links a {
        color: rgba(255, 255, 255, 0.8);
        transition: var(--transition);
        font-size: 0.95rem;
        text-decoration: none;
        display: inline-block;
    }

    .neo-footer-links a:hover {
        color: var(--primary);
        padding-left: 5px;
    }

    .neo-footer-contact p {
        display: flex;
        align-items: center;
        gap: 10px;
        color: rgba(255, 255, 255, 0.8);
        margin-bottom: 15px;
        font-size: 0.95rem;
    }

    .neo-footer-contact i {
        width: 20px;
        color: var(--primary);
        flex-shrink: 0;
    }

    .neo-social-links {
        display: flex;
        gap: 15px;
        margin-top: 25px;
        flex-wrap: wrap;
    }

    .neo-social-link {
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        transition: var(--transition);
        text-decoration: none;
    }

    .neo-social-link:hover {
        background: var(--gradient-1);
        transform: translateY(-5px);
        color: var(--white);
    }

    .neo-footer-bottom {
        text-align: center;
        padding-top: 30px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.9rem;
    }

    .neo-footer-bottom a {
        color: rgba(255, 255, 255, 0.6);
        margin: 0 10px;
        text-decoration: none;
    }

    .neo-footer-bottom a:hover {
        color: var(--primary);
    }

    /* Animations Classes */
    .fade-in {
        animation: fadeIn 1s ease forwards;
    }

    .fade-in-up {
        animation: fadeInUp 1s ease forwards;
    }

    .fade-in-right {
        animation: fadeInRight 1s ease forwards;
    }

    [data-aos] {
        opacity: 0;
        transition-property: opacity, transform;
    }

    [data-aos].aos-animate {
        opacity: 1;
    }

    [data-aos="fade-up"] {
        transform: translateY(40px);
    }

    [data-aos="fade-up"].aos-animate {
        transform: translateY(0);
    }

    [data-aos="fade-right"] {
        transform: translateX(-40px);
    }

    [data-aos="fade-right"].aos-animate {
        transform: translateX(0);
    }

    [data-aos="fade-left"] {
        transform: translateX(40px);
    }

    [data-aos="fade-left"].aos-animate {
        transform: translateX(0);
    }

    [data-aos="zoom-in"] {
        transform: scale(0.9);
    }

    [data-aos="zoom-in"].aos-animate {
        transform: scale(1);
    }

    /* Body menu open state */
    body.menu-open {
        overflow: hidden;
    }
</style>
@endpush

@section('content')
<!-- Custom Header for NEO ED-TECH Page -->
<header class="neo-header" id="neoHeader">
    <div class="container">
        <a href="{{ route('home') }}" class="logo">
            <img src="https://educonecx-com-745290.hostingersite.com/wp-content/uploads/2025/09/3b85279c-87ba-4749-a941-aa670bd0f3a7.png" alt="NEO ED-TECH Logo" loading="lazy">
        </a>

        <div class="mobile-menu-btn" id="mobileMenuBtn">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <nav class="nav-menu" id="navMenu">
            <div class="nav-links">
                <a href="{{ route('home') }}">{{ App\Helpers\TranslationHelper::trans('neo.nav_home') }}</a>
                <a href="#services">{{ App\Helpers\TranslationHelper::trans('neo.nav_services') }}</a>
                <a href="#about">{{ App\Helpers\TranslationHelper::trans('neo.nav_about') }}</a>
                <a href="#testimonials">{{ App\Helpers\TranslationHelper::trans('neo.nav_testimonials') }}</a>
                <a href="#contact">{{ App\Helpers\TranslationHelper::trans('neo.nav_contact') }}</a>
            </div>
            <a href="#contact" class="contact-btn">{{ App\Helpers\TranslationHelper::trans('neo.nav_btn') }}</a>
        </nav>
    </div>
</header>

<!-- Hero Section - Updated with background image -->
<section class="neo-hero" id="hero">
    <div class="neo-hero-particles">
        <div class="neo-hero-particle"></div>
        <div class="neo-hero-particle"></div>
        <div class="neo-hero-particle"></div>
        <div class="neo-hero-particle"></div>
    </div>

    <div class="container">
        <div class="neo-hero-content" data-aos="fade-up">
            <h1 class="neo-hero-title">
                {!! App\Helpers\TranslationHelper::trans('neo.hero_title') !!}
            </h1>

            <p class="neo-hero-subtitle">
                {{ App\Helpers\TranslationHelper::trans('neo.hero_subtitle') }}
            </p>

            <div class="neo-hero-buttons">
                <a href="#contact" class="btn btn-primary">
                    {{ App\Helpers\TranslationHelper::trans('neo.hero_btn_consultation') }}
                    <i class="fas fa-arrow-right"></i>
                </a>
                <a href="#services" class="btn btn-secondary">
                    {{ App\Helpers\TranslationHelper::trans('neo.hero_btn_services') }}
                    <i class="fas fa-play-circle"></i>
                </a>
            </div>

            <div class="neo-divider"></div>

            <div class="neo-trust-badge">
                <div class="neo-counter">
                    <span class="number" data-target="800">800</span>
                    <span>{{ App\Helpers\TranslationHelper::trans('neo.hero_counter') }}</span>
                </div>

                <div class="neo-avatar-group">
                    <img src="https://images.unsplash.com/photo-1494790108777-78fdb682e5c7?w=40&h=40&fit=crop" alt="Client" class="neo-avatar" loading="lazy">
                    <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=40&h=40&fit=crop" alt="Client" class="neo-avatar" loading="lazy">
                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=40&h=40&fit=crop" alt="Client" class="neo-avatar" loading="lazy">
                    <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=40&h=40&fit=crop" alt="Client" class="neo-avatar" loading="lazy">
                    <img src="https://images.unsplash.com/photo-1502823403499-6ccfcf4fb453?w=40&h=40&fit=crop" alt="Client" class="neo-avatar" loading="lazy">
                    <img src="https://images.unsplash.com/photo-1524504388940-b1c1722653e1?w=40&h=40&fit=crop" alt="Client" class="neo-avatar" loading="lazy">
                    <img src="https://images.unsplash.com/photo-1527203561188-dae1bc1a417f?w=40&h=40&fit=crop" alt="Client" class="neo-avatar" loading="lazy">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="neo-services" id="services">
    <div class="container">
        <div class="neo-section-header" data-aos="fade-up">
            <span class="neo-section-subtitle">{{ App\Helpers\TranslationHelper::trans('neo.services_subtitle') }}</span>
            <h2 class="neo-section-title">{!! App\Helpers\TranslationHelper::trans('neo.services_title') !!}</h2>
            <p class="neo-section-description">
                {{ App\Helpers\TranslationHelper::trans('neo.services_description') }}
            </p>
        </div>

        <div class="neo-services-grid">
            <!-- Social Media Management -->
            <div class="neo-service-card" data-aos="fade-up" data-aos-delay="100">
                <div class="neo-service-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3 class="neo-service-title">{{ App\Helpers\TranslationHelper::trans('neo.service_1_title') }}</h3>
                <p class="neo-service-text">{{ App\Helpers\TranslationHelper::trans('neo.service_1_text') }}</p>
                <ul class="neo-service-list">
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_1_feature_1') }}</li>
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_1_feature_2') }}</li>
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_1_feature_3') }}</li>
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_1_feature_4') }}</li>
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_1_feature_5') }}</li>
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_1_feature_6') }}</li>
                </ul>
            </div>

            <!-- Content Studio -->
            <div class="neo-service-card" data-aos="fade-up" data-aos-delay="200">
                <div class="neo-service-icon">
                    <i class="fas fa-camera"></i>
                </div>
                <h3 class="neo-service-title">{{ App\Helpers\TranslationHelper::trans('neo.service_2_title') }}</h3>
                <p class="neo-service-text">{{ App\Helpers\TranslationHelper::trans('neo.service_2_text') }}</p>
                <ul class="neo-service-list">
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_2_feature_1') }}</li>
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_2_feature_2') }}</li>
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_2_feature_3') }}</li>
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_2_feature_4') }}</li>
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_2_feature_5') }}</li>
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_2_feature_6') }}</li>
                </ul>
            </div>

            <!-- Paid Growth -->
            <div class="neo-service-card" data-aos="fade-up" data-aos-delay="300">
                <div class="neo-service-icon">
                    <i class="fas fa-rocket"></i>
                </div>
                <h3 class="neo-service-title">{{ App\Helpers\TranslationHelper::trans('neo.service_3_title') }}</h3>
                <p class="neo-service-text">{{ App\Helpers\TranslationHelper::trans('neo.service_3_text') }}</p>
                <ul class="neo-service-list">
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_3_feature_1') }}</li>
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_3_feature_2') }}</li>
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_3_feature_3') }}</li>
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_3_feature_4') }}</li>
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_3_feature_5') }}</li>
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_3_feature_6') }}</li>
                </ul>
            </div>

            <!-- Website & Funnels -->
            <div class="neo-service-card" data-aos="fade-up" data-aos-delay="400">
                <div class="neo-service-icon">
                    <i class="fas fa-globe"></i>
                </div>
                <h3 class="neo-service-title">{{ App\Helpers\TranslationHelper::trans('neo.service_4_title') }}</h3>
                <p class="neo-service-text">{{ App\Helpers\TranslationHelper::trans('neo.service_4_text') }}</p>
                <ul class="neo-service-list">
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_4_feature_1') }}</li>
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_4_feature_2') }}</li>
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_4_feature_3') }}</li>
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_4_feature_4') }}</li>
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_4_feature_5') }}</li>
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_4_feature_6') }}</li>
                </ul>
            </div>

            <!-- SEO & Local Presence -->
            <div class="neo-service-card" data-aos="fade-up" data-aos-delay="500">
                <div class="neo-service-icon">
                    <i class="fas fa-search"></i>
                </div>
                <h3 class="neo-service-title">{{ App\Helpers\TranslationHelper::trans('neo.service_5_title') }}</h3>
                <p class="neo-service-text">{{ App\Helpers\TranslationHelper::trans('neo.service_5_text') }}</p>
                <ul class="neo-service-list">
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_5_feature_1') }}</li>
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_5_feature_2') }}</li>
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_5_feature_3') }}</li>
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_5_feature_4') }}</li>
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_5_feature_5') }}</li>
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_5_feature_6') }}</li>
                </ul>
            </div>

            <!-- Digital Automation -->
            <div class="neo-service-card" data-aos="fade-up" data-aos-delay="600">
                <div class="neo-service-icon">
                    <i class="fas fa-robot"></i>
                </div>
                <h3 class="neo-service-title">{{ App\Helpers\TranslationHelper::trans('neo.service_6_title') }}</h3>
                <p class="neo-service-text">{{ App\Helpers\TranslationHelper::trans('neo.service_6_text') }}</p>
                <ul class="neo-service-list">
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_6_feature_1') }}</li>
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_6_feature_2') }}</li>
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_6_feature_3') }}</li>
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_6_feature_4') }}</li>
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_6_feature_5') }}</li>
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_6_feature_6') }}</li>
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_6_feature_7') }}</li>
                </ul>
            </div>

            <!-- Analytics & Reporting -->
            <div class="neo-service-card" data-aos="fade-up" data-aos-delay="700">
                <div class="neo-service-icon">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <h3 class="neo-service-title">{{ App\Helpers\TranslationHelper::trans('neo.service_7_title') }}</h3>
                <p class="neo-service-text">{{ App\Helpers\TranslationHelper::trans('neo.service_7_text') }}</p>
                <ul class="neo-service-list">
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_7_feature_1') }}</li>
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_7_feature_2') }}</li>
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_7_feature_3') }}</li>
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_7_feature_4') }}</li>
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_7_feature_5') }}</li>
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_7_feature_6') }}</li>
                </ul>
            </div>

            <!-- Branding & Design -->
            <div class="neo-service-card" data-aos="fade-up" data-aos-delay="800">
                <div class="neo-service-icon">
                    <i class="fas fa-palette"></i>
                </div>
                <h3 class="neo-service-title">{{ App\Helpers\TranslationHelper::trans('neo.service_8_title') }}</h3>
                <p class="neo-service-text">{{ App\Helpers\TranslationHelper::trans('neo.service_8_text') }}</p>
                <ul class="neo-service-list">
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_8_feature_1') }}</li>
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_8_feature_2') }}</li>
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_8_feature_3') }}</li>
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_8_feature_4') }}</li>
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_8_feature_5') }}</li>
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_8_feature_6') }}</li>
                </ul>
            </div>

            <!-- Influencer & Partnerships -->
            <div class="neo-service-card" data-aos="fade-up" data-aos-delay="900">
                <div class="neo-service-icon">
                    <i class="fas fa-handshake"></i>
                </div>
                <h3 class="neo-service-title">{{ App\Helpers\TranslationHelper::trans('neo.service_9_title') }}</h3>
                <p class="neo-service-text">{{ App\Helpers\TranslationHelper::trans('neo.service_9_text') }}</p>
                <ul class="neo-service-list">
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_9_feature_1') }}</li>
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_9_feature_2') }}</li>
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_9_feature_3') }}</li>
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_9_feature_4') }}</li>
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_9_feature_5') }}</li>
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_9_feature_6') }}</li>
                </ul>
            </div>

            <!-- Training & Playbooks -->
            <div class="neo-service-card" data-aos="fade-up" data-aos-delay="1000">
                <div class="neo-service-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <h3 class="neo-service-title">{{ App\Helpers\TranslationHelper::trans('neo.service_10_title') }}</h3>
                <p class="neo-service-text">{{ App\Helpers\TranslationHelper::trans('neo.service_10_text') }}</p>
                <ul class="neo-service-list">
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_10_feature_1') }}</li>
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_10_feature_2') }}</li>
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_10_feature_3') }}</li>
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_10_feature_4') }}</li>
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_10_feature_5') }}</li>
                    <li><i class="fas fa-check"></i> {{ App\Helpers\TranslationHelper::trans('neo.service_10_feature_6') }}</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="neo-about" id="about">
    <div class="container">
        <div class="neo-about-grid">
            <div class="neo-about-content" data-aos="fade-right">
                <span class="neo-section-subtitle">{{ App\Helpers\TranslationHelper::trans('neo.about_subtitle') }}</span>
                <h2 class="neo-section-title">{!! App\Helpers\TranslationHelper::trans('neo.about_title') !!}</h2>
                <p>{{ App\Helpers\TranslationHelper::trans('neo.about_text_1') }}</p>
                
                <h3 style="font-size: 1.5rem; margin: 30px 0 15px;">Who We Are</h3>
                <p>{{ App\Helpers\TranslationHelper::trans('neo.about_text_2') }}</p>
                
                <div class="neo-divider" style="background: linear-gradient(90deg, transparent, var(--primary), transparent); margin: 30px 0;"></div>
                
                <div class="neo-about-features">
                    <div class="neo-about-feature">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ App\Helpers\TranslationHelper::trans('neo.about_feature_1') }}</span>
                    </div>
                    <div class="neo-about-feature">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ App\Helpers\TranslationHelper::trans('neo.about_feature_2') }}</span>
                    </div>
                    <div class="neo-about-feature">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ App\Helpers\TranslationHelper::trans('neo.about_feature_3') }}</span>
                    </div>
                    <div class="neo-about-feature">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ App\Helpers\TranslationHelper::trans('neo.about_feature_4') }}</span>
                    </div>
                </div>
            </div>

            <div class="neo-about-cards" data-aos="fade-left">
                <div class="neo-about-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="neo-about-card-icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <h3>{{ App\Helpers\TranslationHelper::trans('neo.about_card_1_title') }}</h3>
                    <p>{{ App\Helpers\TranslationHelper::trans('neo.about_card_1_text') }}</p>
                </div>

                <div class="neo-about-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="neo-about-card-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h3>{{ App\Helpers\TranslationHelper::trans('neo.about_card_2_title') }}</h3>
                    <p>{{ App\Helpers\TranslationHelper::trans('neo.about_card_2_text') }}</p>
                </div>

                <div class="neo-about-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="neo-about-card-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3>{{ App\Helpers\TranslationHelper::trans('neo.about_card_3_title') }}</h3>
                    <p>{{ App\Helpers\TranslationHelper::trans('neo.about_card_3_text') }}</p>
                </div>

                <div class="neo-about-card" data-aos="fade-up" data-aos-delay="400">
                    <div class="neo-about-card-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3>{{ App\Helpers\TranslationHelper::trans('neo.about_card_4_title') }}</h3>
                    <p>{{ App\Helpers\TranslationHelper::trans('neo.about_card_4_text') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="neo-testimonials" id="testimonials">
    <div class="container">
        <div class="neo-section-header" data-aos="fade-up">
            <span class="neo-section-subtitle">{{ App\Helpers\TranslationHelper::trans('neo.testimonials_subtitle') }}</span>
            <h2 class="neo-section-title">{!! App\Helpers\TranslationHelper::trans('neo.testimonials_title') !!}</h2>
            <p class="neo-section-description">
                {{ App\Helpers\TranslationHelper::trans('neo.testimonials_description') }}
            </p>
        </div>

        <div class="neo-testimonials-grid">
            <!-- Testimonial 1 -->
            <div class="neo-testimonial-card" data-aos="fade-up" data-aos-delay="100">
                <div class="neo-testimonial-rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="neo-testimonial-text">
                    "{{ App\Helpers\TranslationHelper::trans('neo.testimonial_1_text') }}"
                </p>
                <div class="neo-testimonial-author">
                    <div class="neo-author-image">
<img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=60&h=60&fit=crop&auto=format" alt="User Profile Photo" loading="lazy">                    </div>
                    <div class="neo-author-info">
                        <h4>{{ App\Helpers\TranslationHelper::trans('neo.testimonial_1_name') }}</h4>
                        <p>{{ App\Helpers\TranslationHelper::trans('neo.testimonial_1_role') }}</p>
                    </div>
                </div>
            </div>

            <!-- Testimonial 2 -->
            <div class="neo-testimonial-card" data-aos="fade-up" data-aos-delay="200">
                <div class="neo-testimonial-rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="neo-testimonial-text">
                    "{{ App\Helpers\TranslationHelper::trans('neo.testimonial_2_text') }}"
                </p>
                <div class="neo-testimonial-author">
                    <div class="neo-author-image">
                        <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=60&h=60&fit=crop" alt="Michael Rodriguez" loading="lazy">
                    </div>
                    <div class="neo-author-info">
                        <h4>{{ App\Helpers\TranslationHelper::trans('neo.testimonial_2_name') }}</h4>
                        <p>{{ App\Helpers\TranslationHelper::trans('neo.testimonial_2_role') }}</p>
                    </div>
                </div>
            </div>

            <!-- Testimonial 3 -->
            <div class="neo-testimonial-card" data-aos="fade-up" data-aos-delay="300">
                <div class="neo-testimonial-rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="neo-testimonial-text">
                    "{{ App\Helpers\TranslationHelper::trans('neo.testimonial_3_text') }}"
                </p>
                <div class="neo-testimonial-author">
                    <div class="neo-author-image">
                        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=60&h=60&fit=crop" alt="Emma Thompson" loading="lazy">
                    </div>
                    <div class="neo-author-info">
                        <h4>{{ App\Helpers\TranslationHelper::trans('neo.testimonial_3_name') }}</h4>
                        <p>{{ App\Helpers\TranslationHelper::trans('neo.testimonial_3_role') }}</p>
                    </div>
                </div>
            </div>

            <!-- Testimonial 4 -->
            <div class="neo-testimonial-card" data-aos="fade-up" data-aos-delay="400">
                <div class="neo-testimonial-rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="neo-testimonial-text">
                    "{{ App\Helpers\TranslationHelper::trans('neo.testimonial_4_text') }}"
                </p>
                <div class="neo-testimonial-author">
                    <div class="neo-author-image">
                        <img src="https://images.unsplash.com/photo-1524504388940-b1c1722653e1?w=60&h=60&fit=crop" alt="Jessica Davis" loading="lazy">
                    </div>
                    <div class="neo-author-info">
                        <h4>{{ App\Helpers\TranslationHelper::trans('neo.testimonial_4_name') }}</h4>
                        <p>{{ App\Helpers\TranslationHelper::trans('neo.testimonial_4_role') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="neo-contact" id="contact">
    <div class="container">
        <div class="neo-contact-grid">
            <div class="neo-contact-info" data-aos="fade-right">
                <h2 class="neo-contact-title">{!! App\Helpers\TranslationHelper::trans('neo.contact_title') !!}</h2>
                <p class="neo-contact-text">
                    {{ App\Helpers\TranslationHelper::trans('neo.contact_text') }}
                </p>

                <div class="neo-contact-details">
                    <div class="neo-contact-item">
                        <div class="neo-contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <h3>{{ App\Helpers\TranslationHelper::trans('neo.contact_email_label') }}</h3>
                            <p>{{ App\Helpers\TranslationHelper::trans('neo.contact_email') }}</p>
                        </div>
                    </div>

                    <!-- <div class="neo-contact-item">
                        <div class="neo-contact-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div>
                            <h3>{{ App\Helpers\TranslationHelper::trans('neo.contact_phone_label') }}</h3>
                            <p>{{ App\Helpers\TranslationHelper::trans('neo.contact_phone') }}</p>
                        </div>
                    </div> -->

                    <div class="neo-contact-item">
                        <div class="neo-contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <h3>{{ App\Helpers\TranslationHelper::trans('neo.contact_address_label') }}</h3>
                            <p>{{ App\Helpers\TranslationHelper::trans('neo.contact_address') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="neo-contact-form" data-aos="fade-left">
                <h3 class="neo-form-title">{{ App\Helpers\TranslationHelper::trans('neo.contact_form_title') }}</h3>
                
                <form id="contactForm" method="POST" action="{{ route('contact.submit') }}">
    @csrf
    
    <!-- Add this hidden field to identify the form type -->
    <input type="hidden" name="form_type" value="neo">
    
    <div class="neo-form-group">
        <label for="first_name">{{ App\Helpers\TranslationHelper::trans('neo.contact_form_first_name') }}</label>
        <input type="text" id="first_name" name="first_name" class="neo-form-control" placeholder="John" required>
    </div>

    <div class="neo-form-group">
        <label for="last_name">{{ App\Helpers\TranslationHelper::trans('neo.contact_form_last_name') }}</label>
        <input type="text" id="last_name" name="last_name" class="neo-form-control" placeholder="Doe">
    </div>

    <div class="neo-form-group">
        <label for="email">{{ App\Helpers\TranslationHelper::trans('neo.contact_form_email') }}</label>
        <input type="email" id="email" name="email" class="neo-form-control" placeholder="john@company.com" required>
    </div>

    <div class="neo-form-group">
        <label for="company">{{ App\Helpers\TranslationHelper::trans('neo.contact_form_company') }}</label>
        <input type="text" id="company" name="company" class="neo-form-control" placeholder="Your Company Name">
    </div>

    <div class="neo-form-group">
        <label for="service">{{ App\Helpers\TranslationHelper::trans('neo.contact_form_service') }}</label>
        <select id="service" name="service" class="neo-form-control">
            <option value="">{{ App\Helpers\TranslationHelper::trans('neo.contact_form_service_select') }}</option>
            <option value="Social Media Management">{{ App\Helpers\TranslationHelper::trans('neo.service_1_title') }}</option>
            <option value="Content Studio">{{ App\Helpers\TranslationHelper::trans('neo.service_2_title') }}</option>
            <option value="Paid Growth">{{ App\Helpers\TranslationHelper::trans('neo.service_3_title') }}</option>
            <option value="Website & Funnels">{{ App\Helpers\TranslationHelper::trans('neo.service_4_title') }}</option>
            <option value="SEO & Local Presence">{{ App\Helpers\TranslationHelper::trans('neo.service_5_title') }}</option>
            <option value="Digital Automation">{{ App\Helpers\TranslationHelper::trans('neo.service_6_title') }}</option>
            <option value="Analytics & Reporting">{{ App\Helpers\TranslationHelper::trans('neo.service_7_title') }}</option>
            <option value="Branding & Design">{{ App\Helpers\TranslationHelper::trans('neo.service_8_title') }}</option>
            <option value="Influencer & Partnerships">{{ App\Helpers\TranslationHelper::trans('neo.service_9_title') }}</option>
            <option value="Training & Playbooks">{{ App\Helpers\TranslationHelper::trans('neo.service_10_title') }}</option>
        </select>
    </div>

    <div class="neo-form-group">
        <label for="message">{{ App\Helpers\TranslationHelper::trans('neo.contact_form_message') }}</label>
        <textarea id="message" name="message" class="neo-form-control" placeholder="Tell us about your project and goals..." required></textarea>
    </div>

    <button type="submit" class="neo-form-submit">{{ App\Helpers\TranslationHelper::trans('neo.contact_form_submit') }}</button>
</form>
            </div>
        </div>
    </div>
</section>

<!-- Custom Footer for NEO ED-TECH Page -->
<footer class="neo-footer">
    <div class="container">
        <div class="neo-footer-grid">
            <div class="neo-footer-col">
                <div class="neo-footer-logo">
                    <img src="https://educonecx-com-745290.hostingersite.com/wp-content/uploads/2025/09/3b85279c-87ba-4749-a941-aa670bd0f3a7.png" alt="NEO ED-TECH" loading="lazy">
                </div>
                <p class="neo-footer-about">
                    {{ App\Helpers\TranslationHelper::trans('neo.footer_about') }}
                </p>
            </div>

            <div class="neo-footer-col">
                <h4 class="neo-footer-title">{{ App\Helpers\TranslationHelper::trans('neo.footer_services_title') }}</h4>
                <ul class="neo-footer-links">
                    <li><a href="#services">{{ App\Helpers\TranslationHelper::trans('neo.service_1_title') }}</a></li>
                    <li><a href="#services">{{ App\Helpers\TranslationHelper::trans('neo.service_2_title') }}</a></li>
                    <li><a href="#services">{{ App\Helpers\TranslationHelper::trans('neo.service_3_title') }}</a></li>
                    <li><a href="#services">{{ App\Helpers\TranslationHelper::trans('neo.service_4_title') }}</a></li>
                    <li><a href="#services">{{ App\Helpers\TranslationHelper::trans('neo.service_5_title') }}</a></li>
                </ul>
            </div>

            <div class="neo-footer-col">
                <h4 class="neo-footer-title">&nbsp;</h4>
                <ul class="neo-footer-links">
                    <li><a href="#services">{{ App\Helpers\TranslationHelper::trans('neo.service_6_title') }}</a></li>
                    <li><a href="#services">{{ App\Helpers\TranslationHelper::trans('neo.service_7_title') }}</a></li>
                    <li><a href="#services">{{ App\Helpers\TranslationHelper::trans('neo.service_8_title') }}</a></li>
                    <li><a href="#services">{{ App\Helpers\TranslationHelper::trans('neo.service_9_title') }}</a></li>
                    <li><a href="#services">{{ App\Helpers\TranslationHelper::trans('neo.service_10_title') }}</a></li>
                </ul>
            </div>

            <div class="neo-footer-col">
                <h4 class="neo-footer-title">{{ App\Helpers\TranslationHelper::trans('neo.footer_contact_title') }}</h4>
                <div class="neo-footer-contact">
                    <p><i class="fas fa-envelope"></i> {{ App\Helpers\TranslationHelper::trans('neo.contact_email') }}</p>
                    <!-- <p><i class="fas fa-phone"></i> {{ App\Helpers\TranslationHelper::trans('neo.contact_phone') }}</p> -->
                    <p><i class="fas fa-map-marker-alt"></i> {{ App\Helpers\TranslationHelper::trans('neo.contact_address') }}</p>
                </div>

                <div class="neo-social-links">
                    <!-- <a href="https://www.facebook.com/profile.php?id=61584601012851" class="neo-social-link" target="_blank">
                        <i class="fab fa-facebook-f"></i>
                    </a> -->
                    <a href="https://www.tiktok.com/@educonecx.official04?_r=1&_t=ZP-94pVYyt1sQI" class="neo-social-link" target="_blank">
                        <i class="fab fa-tiktok"></i>
                    </a>
                    <!-- <a href="https://www.instagram.com/educonecx/" class="neo-social-link" target="_blank">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://www.youtube.com/@EDUCONECX" class="neo-social-link" target="_blank">
                        <i class="fab fa-youtube"></i>
                    </a>
                    <a href="https://wa.me/18335338228" class="neo-social-link" target="_blank">
                        <i class="fab fa-whatsapp"></i>
                    </a> -->
                </div>
            </div>
        </div>

        <div class="neo-footer-bottom">
            <p>{!! App\Helpers\TranslationHelper::trans('neo.footer_copyright') !!} <a href="{{ route('privacy') }}">{{ App\Helpers\TranslationHelper::trans('neo.footer_privacy') }}</a> | <a href="{{ route('terms') }}">{{ App\Helpers\TranslationHelper::trans('neo.footer_terms') }}</a></p>
        </div>
    </div>
</footer>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const navMenu = document.getElementById('navMenu');
        const body = document.body;

        if (mobileMenuBtn && navMenu) {
            mobileMenuBtn.addEventListener('click', function() {
                this.classList.toggle('active');
                navMenu.classList.toggle('active');
                body.classList.toggle('menu-open');
            });

            // Close menu when clicking on a link
            navMenu.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', () => {
                    mobileMenuBtn.classList.remove('active');
                    navMenu.classList.remove('active');
                    body.classList.remove('menu-open');
                });
            });

            // Close menu when clicking outside
            document.addEventListener('click', (e) => {
                if (!navMenu.contains(e.target) && !mobileMenuBtn.contains(e.target) && navMenu.classList.contains('active')) {
                    mobileMenuBtn.classList.remove('active');
                    navMenu.classList.remove('active');
                    body.classList.remove('menu-open');
                }
            });
        }

        // Header scroll effect
        const header = document.getElementById('neoHeader');
        let scrollTimeout;
        
        window.addEventListener('scroll', () => {
            if (!scrollTimeout) {
                scrollTimeout = setTimeout(() => {
                    if (window.scrollY > 50) {
                        header.classList.add('scrolled');
                    } else {
                        header.classList.remove('scrolled');
                    }
                    scrollTimeout = null;
                }, 10);
            }
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const headerOffset = 80;
                    const elementPosition = target.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Counter animation
        const counter = document.querySelector('.neo-counter .number');
        if (counter) {
            const target = parseInt(counter.getAttribute('data-target'));
            const duration = 2000;
            const start = 0;
            const increment = target / (duration / 16);
            let current = start;

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const timer = setInterval(() => {
                            current += increment;
                            if (current >= target) {
                                counter.textContent = target + '+';
                                clearInterval(timer);
                            } else {
                                counter.textContent = Math.floor(current) + '+';
                            }
                        }, 16);
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.5 });

            observer.observe(counter.parentElement);
        }

        // Form submission with AJAX
        const contactForm = document.getElementById('contactForm');
        if (contactForm) {
            contactForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.textContent;
                submitBtn.disabled = true;
                submitBtn.textContent = '{{ App\Helpers\TranslationHelper::trans('neo.contact_form_submitting') }}';

                const formData = new FormData(this);

                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Thank you for your message. We will get back to you soon!');
                        this.reset();
                    } else {
                        alert(data.message || 'Something went wrong. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Something went wrong. Please try again.');
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                });
            });
        }

        // Parallax effect for hero particles (disable on mobile for performance)
        if (window.innerWidth > 768) {
            document.addEventListener('mousemove', (e) => {
                const particles = document.querySelectorAll('.neo-hero-particle');
                const mouseX = e.clientX / window.innerWidth - 0.5;
                const mouseY = e.clientY / window.innerHeight - 0.5;

                particles.forEach((particle, index) => {
                    const speed = (index + 1) * 20;
                    const x = mouseX * speed;
                    const y = mouseY * speed;
                    particle.style.transform = `translate(${x}px, ${y}px)`;
                });
            });
        }

        // Active nav link on scroll
        const sections = document.querySelectorAll('section[id]');
        const navLinks = document.querySelectorAll('.nav-links a');
        
        function updateActiveNavLink() {
            let current = '';
            const scrollPosition = window.scrollY + 100;

            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionBottom = sectionTop + section.offsetHeight;
                
                if (scrollPosition >= sectionTop && scrollPosition < sectionBottom) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active');
                const href = link.getAttribute('href').substring(1);
                if (href === current) {
                    link.classList.add('active');
                }
            });
        }

        window.addEventListener('scroll', updateActiveNavLink);
        updateActiveNavLink();

        // Touch optimizations
        if ('ontouchstart' in window) {
            const buttons = document.querySelectorAll('.btn, .contact-btn, .neo-social-link, .neo-form-submit');
            
            buttons.forEach(button => {
                button.addEventListener('touchstart', function() {
                    this.style.opacity = '0.8';
                }, { passive: true });
                
                button.addEventListener('touchend', function() {
                    this.style.opacity = '1';
                }, { passive: true });
                
                button.addEventListener('touchcancel', function() {
                    this.style.opacity = '1';
                }, { passive: true });
            });
        }

        // Lazy loading for images
        if ('loading' in HTMLImageElement.prototype) {
            const images = document.querySelectorAll('img[loading="lazy"]');
            images.forEach(img => {
                img.loading = 'lazy';
            });
        }

        // Reduced motion preference
        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        
        if (prefersReducedMotion) {
            const animatedElements = document.querySelectorAll('.neo-hero-particle, [data-aos]');
            animatedElements.forEach(element => {
                if (element.style) {
                    element.style.animation = 'none';
                }
                if (element.hasAttribute('data-aos')) {
                    element.setAttribute('data-aos', '');
                }
            });
        }
    });

    // Initialize AOS with mobile optimization
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: window.innerWidth < 768 ? 400 : 1000,
            once: true,
            offset: window.innerWidth < 768 ? 20 : 100,
            easing: 'ease-in-out',
            disable: window.innerWidth < 576
        });
    }

    // Handle window resize
    let resizeTimeout;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(function() {
            if (window.innerWidth > 768) {
                // Re-enable parallax on desktop
            }
            
            // Update AOS
            if (typeof AOS !== 'undefined') {
                AOS.refresh();
            }
        }, 250);
    });
</script>
@endpush