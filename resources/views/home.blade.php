@extends('layouts.main')

@section('title', 'Empower Your Learning Journey Today - EDUCONECX')

@section('meta_description', 'EDUCONECX is an international AI-powered educational platform that empowers learners worldwide with practical language and digital business skills.')

@push('styles')
<style>
    /* Root Variables - Retaining your color scheme */
    :root {
        --primary: #4361ee;
        --secondary: #3f37c9;
        --success: #4cc9f0;
        --danger: #f72585;
        --warning: #f8961e;
        --info: #4895ef;
        --light: #f8f9fa;
        --dark: #212529;
        --gray: #6c757d;
        --gray-light: #e9ecef;
        --white: #ffffff;
        --gradient-1: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
        --gradient-2: linear-gradient(135deg, #f72585 0%, #b5179e 100%);
        --gradient-3: linear-gradient(135deg, #4cc9f0 0%, #4361ee 100%);
        --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.1);
        --shadow-md: 0 5px 15px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 30px rgba(0, 0, 0, 0.15);
        --border-radius-sm: 4px;
        --border-radius-md: 8px;
        --border-radius-lg: 12px;
        --border-radius-xl: 20px;
        --border-radius-full: 9999px;
        --transition: all 0.3s ease;
        --transition-slow: all 0.5s ease;
    }

    /* Animations */
    @keyframes float {

        0%,
        100% {
            transform: translateY(0) rotate(0deg);
        }

        50% {
            transform: translateY(-20px) rotate(5deg);
        }
    }

    @keyframes float-slow {

        0%,
        100% {
            transform: translateY(0) rotate(0deg);
        }

        50% {
            transform: translateY(-10px) rotate(2deg);
        }
    }

    @keyframes pulse {

        0%,
        100% {
            transform: scale(1);
            opacity: 1;
        }

        50% {
            transform: scale(1.05);
            opacity: 0.8;
        }
    }

    @keyframes shimmer {
        0% {
            background-position: -1000px 0;
        }

        100% {
            background-position: 1000px 0;
        }
    }

    @keyframes marquee {
        from {
            transform: translateX(0);
        }

        to {
            transform: translateX(-50%);
        }
    }

    @keyframes ticker-scroll {
        from {
            transform: translateX(0);
        }

        to {
            transform: translateX(calc(-100% / 3));
        }
    }

    @keyframes rotateY {
        from {
            transform: rotateY(0deg);
        }

        to {
            transform: rotateY(360deg);
        }
    }

    /* Hero Section - Updated with inspiration styles */
    .hero {
        position: relative;
        min-height: 100vh;
        display: flex;
        align-items: center;
        background: var(--gradient-1);
        overflow: hidden;
    }

    .hero::before {
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
    }

    .hero-particles {
        position: absolute;
        inset: 0;
        z-index: 1;
    }

    .hero-particle {
        position: absolute;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        pointer-events: none;
    }

    .hero-particle:nth-child(1) {
        width: 300px;
        height: 300px;
        top: -100px;
        right: -100px;
        animation: float 8s ease-in-out infinite;
    }

    .hero-particle:nth-child(2) {
        width: 200px;
        height: 200px;
        bottom: -50px;
        left: -50px;
        animation: float 10s ease-in-out infinite reverse;
    }

    .hero-particle:nth-child(3) {
        width: 150px;
        height: 150px;
        top: 50%;
        left: 20%;
        animation: float 12s ease-in-out infinite;
    }

    .hero-particle:nth-child(4) {
        width: 100px;
        height: 100px;
        top: 20%;
        right: 30%;
        animation: float 15s ease-in-out infinite;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        color: var(--white);
        text-align: center;
        max-width: 900px;
        margin: 0 auto;
        padding: 120px 0 80px;
    }

    .hero-badge-wrapper {
        display: flex;
        justify-content: center;
        margin-bottom: 30px;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        padding: 8px 20px 8px 8px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-radius: var(--border-radius-full);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .avatar-group {
        display: flex;
        align-items: center;
    }

    .avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: 2px solid var(--primary);
        margin-left: -8px;
        transition: var(--transition);
    }

    .avatar:first-child {
        margin-left: 0;
    }

    .avatar:hover {
        transform: translateY(-3px);
        z-index: 10;
    }

    .rating-badge {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .stars {
        display: flex;
        gap: 2px;
        color: #ffd700;
        font-size: 0.8rem;
    }

    .rating-text {
        font-size: 0.75rem;
        opacity: 0.9;
    }

    .hero-title {
        font-size: clamp(2.5rem, 8vw, 4.5rem);
        font-weight: 800;
        line-height: 1.1;
        margin-bottom: 20px;
        text-shadow: 0 2px 20px rgba(0, 0, 0, 0.3);
    }

    .hero-title-gradient {
        background: linear-gradient(135deg, #fff, #ffd700);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        display: inline-block;
    }

    .hero-text {
        font-size: clamp(1.1rem, 3vw, 1.3rem);
        margin-bottom: 40px;
        opacity: 0.9;
        max-width: 700px;
        margin-left: auto;
        margin-right: auto;
    }

    .hero-features {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
        margin-bottom: 30px;
    }

    .hero-feature {
        display: flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.1);
        padding: 8px 16px;
        border-radius: var(--border-radius-full);
        backdrop-filter: blur(5px);
    }

    .hero-feature i {
        color: var(--success);
        font-size: 0.9rem;
    }

    .hero-buttons {
        display: flex;
        gap: 20px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .hero-buttons .btn {
        min-width: 200px;
        position: relative;
        overflow: hidden;
    }

    .hero-buttons .btn::before {
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
    }

    .hero-buttons .btn:hover::before {
        width: 300px;
        height: 300px;
    }

    .hero-buttons .btn-secondary {
        border-color: var(--white);
        color: var(--white);
    }

    .hero-buttons .btn-secondary:hover {
        background: var(--white);
        color: var(--primary);
    }

    /* Carousel Section - New from inspiration */
    .carousel-section {
        position: relative;
        margin-top: -100px;
        padding-bottom: 60px;
        perspective: 1000px;
        z-index: 10;
    }

    .carousel-container {
        transform-style: preserve-3d;
        transform: rotateX(15deg) translateY(20px);
    }

    .carousel-gradient {
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse 60% 50% at 50% 60%, rgba(67, 97, 238, 0.15) 0%, rgba(67, 97, 238, 0.05) 40%, transparent 70%);
        pointer-events: none;
        z-index: 5;
    }

    .carousel-mask {
        overflow: hidden;
        mask-image: linear-gradient(to right, transparent 0%, black 20%, black 80%, transparent 100%);
        -webkit-mask-image: linear-gradient(to right, transparent 0%, black 20%, black 80%, transparent 100%);
    }

    .carousel-track {
        display: flex;
        gap: 20px;
        animation: marquee 30s linear infinite;
        width: fit-content;
    }

    .carousel-item {
        flex-shrink: 0;
        width: 180px;
        height: 260px;
        border-radius: var(--border-radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-lg);
        transition: var(--transition);
    }

    .carousel-item:hover {
        transform: translateY(-10px) scale(1.05);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    }

    .carousel-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition-slow);
    }

    .carousel-item:hover img {
        transform: scale(1.1);
    }

    @media (min-width: 768px) {
        .carousel-item {
            width: 260px;
            height: 377px;
        }

        .carousel-container {
            transform: rotateX(20deg) translateY(40px);
        }
    }

    /* Logo Cloud Section */
    .logo-cloud-section {
        padding: 40px 0;
        background: var(--white);
    }

    .logo-cloud-title {
        text-align: center;
        color: var(--gray);
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 30px;
    }

    .logo-cloud {
        overflow: hidden;
        mask-image: linear-gradient(to right, transparent 0%, black 10%, black 90%, transparent 100%);
        -webkit-mask-image: linear-gradient(to right, transparent 0%, black 10%, black 90%, transparent 100%);
    }

    .logo-track {
        display: flex;
        gap: 40px;
        animation: marquee 35s linear infinite;
        width: fit-content;
    }

    .logo-item {
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        filter: brightness(0) opacity(0.4);
        transition: var(--transition);
    }

    .logo-item:hover {
        filter: brightness(0) opacity(0.6);
    }

    .logo-item img {
        height: 25px;
        width: auto;
        object-fit: contain;
    }

    /* Process Section - New from inspiration */
    .process-section {
        padding: 80px 0;
        background: var(--white);
    }

    .process-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        margin-top: 50px;
    }

    .process-card {
        text-align: center;
        padding: 30px;
        border-radius: var(--border-radius-lg);
        background: var(--white);
        box-shadow: var(--shadow-md);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }

    .process-card::before {
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

    .process-card:hover::before {
        transform: scaleX(1);
    }

    .process-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-lg);
    }

    .process-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 25px;
        background: var(--gradient-1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        font-size: 2rem;
        transition: var(--transition);
    }

    .process-card:hover .process-icon {
        transform: rotateY(180deg);
    }

    .process-title {
        font-size: 1.2rem;
        margin-bottom: 15px;
    }

    .process-text {
        color: var(--gray);
        font-size: 0.95rem;
        line-height: 1.6;
    }

    .process-line {
        position: absolute;
        top: 50%;
        right: -30px;
        width: 60px;
        height: 2px;
        background: linear-gradient(90deg, var(--primary), transparent);
    }

    .process-card:last-child .process-line {
        display: none;
    }

    @media (max-width: 768px) {
        .process-grid {
            grid-template-columns: 1fr;
        }

        .process-line {
            display: none;
        }
    }

    /* Feature Cards Grid - Enhanced */
    .features-section {
        padding: 80px 0;
        background: var(--light);
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 30px;
        margin-top: 50px;
    }

    .feature-card {
        background: var(--white);
        padding: 40px 30px;
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .feature-card::before {
        content: '';
        position: absolute;
        inset: 0;
        background: var(--gradient-1);
        opacity: 0;
        transition: var(--transition);
        z-index: 0;
    }

    .feature-card:hover::before {
        opacity: 0.05;
    }

    .feature-icon {
        width: 80px;
        height: 80px;
        background: var(--gradient-1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px;
        color: var(--white);
        font-size: 2rem;
        position: relative;
        z-index: 1;
        transition: var(--transition);
    }

    .feature-card:hover .feature-icon {
        transform: rotateY(180deg) scale(1.1);
    }

    .feature-title,
    .feature-text {
        position: relative;
        z-index: 1;
    }

    .feature-title {
        font-size: 1.3rem;
        margin-bottom: 15px;
    }

    .feature-text {
        color: var(--gray);
        line-height: 1.6;
    }

    /* Courses Section - Enhanced with inspiration elements */
    .courses-section {
        padding: 80px 0;
        background: var(--white);
    }

    .section-header {
        text-align: center;
        margin-bottom: 60px;
    }

    .section-subtitle {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--gradient-1);
        color: var(--white);
        padding: 6px 16px;
        border-radius: var(--border-radius-full);
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 20px;
    }

    .section-title {
        font-size: clamp(2rem, 5vw, 3rem);
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 20px;
    }

    .section-title span {
        background: var(--gradient-1);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .course-card {
        background: var(--white);
        border-radius: var(--border-radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-md);
        transition: var(--transition);
        height: 100%;
        position: relative;
    }

    .course-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-lg);
    }

    .course-image {
        position: relative;
        overflow: hidden;
        aspect-ratio: 16/9;
    }

    .course-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition-slow);
    }

    .course-card:hover .course-image img {
        transform: scale(1.1);
    }

    .course-category {
        position: absolute;
        top: 15px;
        right: 15px;
        padding: 5px 15px;
        background: var(--gradient-1);
        color: var(--white);
        border-radius: var(--border-radius-full);
        font-size: 0.8rem;
        font-weight: 600;
        z-index: 2;
    }

    .course-discount-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        padding: 5px 12px;
        background: var(--gradient-2);
        color: var(--white);
        border-radius: var(--border-radius-full);
        font-size: 0.8rem;
        font-weight: 700;
        z-index: 2;
        animation: pulse 2s ease-in-out infinite;
    }

    .course-content {
        padding: 25px;
    }

    .course-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 15px;
        color: var(--gray);
        font-size: 0.85rem;
    }

    .course-meta i {
        color: var(--primary);
        margin-right: 5px;
    }

    .course-title {
        font-size: 1.2rem;
        margin-bottom: 12px;
        line-height: 1.4;
        font-weight: 700;
    }

    .course-title a {
        color: var(--dark);
        transition: var(--transition);
    }

    .course-title a:hover {
        color: var(--primary);
    }

    .course-stats {
        display: flex;
        gap: 20px;
        margin: 15px 0;
        font-size: 0.85rem;
        color: var(--gray);
    }

    .course-stats i {
        color: var(--warning);
        margin-right: 5px;
    }

    .course-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid var(--gray-light);
    }

    .course-price {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary);
    }

    .course-price small {
        font-size: 0.9rem;
        font-weight: 400;
        color: var(--gray);
        text-decoration: line-through;
        margin-left: 5px;
    }

    .course-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: var(--gradient-1);
        color: var(--white);
        border-radius: var(--border-radius-full);
        font-size: 0.9rem;
        font-weight: 600;
        transition: var(--transition);
        border: none;
        cursor: pointer;
    }

    .course-btn:hover {
        transform: translateX(5px);
        box-shadow: var(--shadow-md);
    }

    .course-btn i {
        transition: var(--transition);
    }

    .course-btn:hover i {
        transform: translateX(3px);
    }

    /* Testimonials Section - Enhanced with slider */
    .testimonials-section {
        padding: 80px 0;
        background: var(--light);
    }

    .testimonials-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 30px;
        margin-top: 50px;
    }

    .testimonial-card {
        background: var(--white);
        padding: 35px;
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-md);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }

    .testimonial-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-lg);
    }

    .testimonial-card::before {
        content: '"';
        position: absolute;
        top: 10px;
        right: 20px;
        font-size: 8rem;
        font-family: serif;
        color: var(--primary);
        opacity: 0.1;
        line-height: 1;
    }

    .testimonial-rating {
        color: #ffd700;
        font-size: 1.1rem;
        margin-bottom: 20px;
    }

    .testimonial-text {
        font-size: 1rem;
        line-height: 1.7;
        margin-bottom: 25px;
        color: var(--gray);
        position: relative;
        z-index: 1;
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
        border: 3px solid var(--primary);
        transition: var(--transition);
    }

    .testimonial-card:hover .author-image {
        transform: scale(1.1);
    }

    .author-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .author-info h4 {
        font-size: 1.1rem;
        margin-bottom: 5px;
    }

    .author-info p {
        color: var(--gray);
        font-size: 0.9rem;
    }

    /* Stats Section - Enhanced */
    .stats-section {
        padding: 60px 0;
        background: var(--gradient-1);
        color: var(--white);
        position: relative;
        overflow: hidden;
    }

    .stats-section::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(255, 255, 255, 0.05) 2px, transparent 2px),
            linear-gradient(90deg, rgba(255, 255, 255, 0.05) 2px, transparent 2px);
        background-size: 50px 50px;
        opacity: 0.3;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 40px;
        text-align: center;
        position: relative;
        z-index: 1;
    }

    .stats-item {
        padding: 20px;
        transition: var(--transition);
    }

    .stats-item:hover {
        transform: translateY(-10px);
    }

    .stats-icon {
        font-size: 2.5rem;
        margin-bottom: 15px;
        opacity: 0.9;
        animation: float-slow 3s ease-in-out infinite;
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

    /* CTA Section - Enhanced */
    .cta-section {
        padding: 100px 0;
        background: var(--gradient-1);
        color: var(--white);
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .cta-section::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(255, 255, 255, 0.05) 2px, transparent 2px),
            linear-gradient(90deg, rgba(255, 255, 255, 0.05) 2px, transparent 2px);
        background-size: 100px 100px;
        opacity: 0.3;
    }

    .cta-content {
        position: relative;
        z-index: 2;
        max-width: 700px;
        margin: 0 auto;
    }

    .cta-badge {
        display: inline-block;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        padding: 8px 20px;
        border-radius: var(--border-radius-full);
        font-size: 0.9rem;
        margin-bottom: 30px;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .cta-title {
        font-size: clamp(2rem, 5vw, 3rem);
        font-weight: 800;
        margin-bottom: 20px;
    }

    .cta-title span {
        background: linear-gradient(135deg, #fff, #ffd700);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .cta-text {
        font-size: 1.2rem;
        margin-bottom: 30px;
        opacity: 0.9;
    }

    .cta-buttons {
        display: flex;
        gap: 20px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .cta-buttons .btn {
        min-width: 200px;
        position: relative;
        overflow: hidden;
    }

    .cta-buttons .btn-primary {
        background: var(--white);
        color: var(--primary);
    }

    .cta-buttons .btn-primary:hover {
        background: transparent;
        color: var(--white);
        border-color: var(--white);
    }

    .cta-buttons .btn-secondary {
        border-color: var(--white);
        color: var(--white);
    }

    .cta-buttons .btn-secondary:hover {
        background: var(--white);
        color: var(--primary);
    }

    .cta-particles {
        position: absolute;
        inset: 0;
        z-index: 1;
    }

    .cta-particle {
        position: absolute;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .cta-particle:nth-child(1) {
        width: 200px;
        height: 200px;
        top: -50px;
        right: -50px;
        animation: float 8s ease-in-out infinite;
    }

    .cta-particle:nth-child(2) {
        width: 150px;
        height: 150px;
        bottom: -50px;
        left: -50px;
        animation: float 10s ease-in-out infinite reverse;
    }

    /* FAQ Section - Enhanced */
    .faq-section {
        padding: 80px 0;
        background: var(--white);
    }

    .faq-grid {
        max-width: 800px;
        margin: 50px auto 0;
    }

    .faq-item {
        background: var(--light);
        border-radius: var(--border-radius-lg);
        margin-bottom: 20px;
        overflow: hidden;
        transition: var(--transition);
    }

    .faq-item:hover {
        transform: translateX(5px);
        box-shadow: var(--shadow-md);
    }

    .faq-question {
        padding: 20px 25px;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 600;
        transition: var(--transition);
    }

    .faq-question:hover {
        background: var(--gradient-1);
        color: var(--white);
    }

    .faq-question:hover i {
        color: var(--white);
    }

    .faq-question i {
        transition: var(--transition);
        color: var(--primary);
    }

    .faq-item.active .faq-question {
        background: var(--gradient-1);
        color: var(--white);
    }

    .faq-item.active .faq-question i {
        color: var(--white);
        transform: rotate(180deg);
    }

    .faq-answer {
        padding: 0 25px 20px;
        display: none;
        color: var(--gray);
        line-height: 1.8;
    }

    .faq-item.active .faq-answer {
        display: block;
        animation: fadeIn 0.5s ease;
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
    @media (max-width: 768px) {
        .hero-stats {
            gap: 30px;
        }

        .stat-number {
            font-size: 2rem;
        }

        .process-line {
            display: none;
        }

        .testimonials-grid {
            grid-template-columns: 1fr;
        }

        .cta-buttons .btn {
            min-width: 150px;
        }

        .carousel-item {
            width: 130px;
            height: 189px;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero">
    <div class="hero-particles">
        <div class="hero-particle"></div>
        <div class="hero-particle"></div>
        <div class="hero-particle"></div>
        <div class="hero-particle"></div>
    </div>

    <div class="container">
        <div class="hero-content" data-aos="fade-up">
            <div class="hero-badge-wrapper">
                <div class="hero-badge">
                    <div class="avatar-group">
                        <img src="https://images.unsplash.com/photo-1494790108777-78fdb682e5c7?w=32&h=32&fit=crop" alt="Student" class="avatar">
                        <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=32&h=32&fit=crop" alt="Student" class="avatar">
                        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=32&h=32&fit=crop" alt="Student" class="avatar">
                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=32&h=32&fit=crop" alt="Student" class="avatar">
                    </div>
                    <div class="rating-badge">
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

<!-- Course Carousel Section (New) -->
<section class="carousel-section">
    <div class="carousel-gradient"></div>
    <div class="carousel-container">
        <div class="carousel-mask">
            <div class="carousel-track">
                <!-- Repeat these items for infinite scroll effect -->
                @php
                $courseImages = [
                'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400&h=600&fit=crop',
                'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=400&h=600&fit=crop',
                'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=400&h=600&fit=crop',
                'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=400&h=600&fit=crop',
                'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?w=400&h=600&fit=crop',
                'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=400&h=600&fit=crop',
                'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=400&h=600&fit=crop',
                'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=400&h=600&fit=crop',
                ];
                @endphp

                @foreach($courseImages as $index => $image)
                <div class="carousel-item" data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">
                    <img src="{{ $image }}" alt="Course {{ $index + 1 }}">
                </div>
                @endforeach

                <!-- Duplicate for seamless loop -->
                @foreach($courseImages as $index => $image)
                <div class="carousel-item">
                    <img src="{{ $image }}" alt="Course {{ $index + 1 }}">
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Logo Cloud Section (New) -->
<section class="logo-cloud-section">
    <div class="container">
        <p class="logo-cloud-title">Trusted by students from</p>
        <div class="logo-cloud">
            <div class="logo-track">
                <div class="logo-item">
                    <img src="{{ asset('storage/home-page-svgs/Harvard_shield_wreath.svg') }}" alt="Harvard">
                </div>
                <div class="logo-item">
                    <img src="{{ asset('storage/home-page-svgs/Stanford_University_seal_2003.svg') }}" alt="Stanford">
                </div>
                <div class="logo-item">
                    <img src="{{ asset('storage/home-page-svgs/MIT_seal.svg') }}" alt="MIT">
                </div>
                <div class="logo-item">
                    <img src="{{ asset('storage/home-page-pngs/University_of_Cambridge_seal.png') }}" alt="Cambridge">
                </div>
                <div class="logo-item">
                    <img src="{{ asset('storage/home-page-pngs/Oxford-University-Circlet.png') }}" alt="Oxford">
                </div>

                <div class="logo-item">
                    <img src="{{ asset('storage/home-page-pngs/Harvard_shield_wreath.png') }}" alt="Harvard">
                </div>
                <div class="logo-item">
                    <img src="{{ asset('storage/home-page-pngs/Stanford_University_seal_2003.png') }}" alt="Stanford">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Process Section (New) -->
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
                <div class="process-line"></div>
            </div>

            <div class="process-card" data-aos="fade-up" data-aos-delay="200">
                <div class="process-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <h3 class="process-title">Choose Your Path</h3>
                <p class="process-text">Select from our curated courses in language learning or digital business skills.</p>
                <div class="process-line"></div>
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

<style>
    .offer-banner {
        background: var(--gradient-2);
        padding: 40px 0;
        color: var(--white);
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .offer-banner::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(255, 255, 255, 0.1) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255, 255, 255, 0.1) 1px, transparent 1px);
        background-size: 30px 30px;
        opacity: 0.3;
    }

    .offer-content {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 30px;
        flex-wrap: wrap;
        position: relative;
        z-index: 1;
    }

    .offer-content i {
        font-size: 3rem;
        animation: pulse 2s ease-in-out infinite;
    }

    .offer-content h3 {
        font-size: 1.8rem;
        font-weight: 700;
    }

    .offer-content p {
        font-size: 1.3rem;
        font-weight: 600;
    }

    .offer-content .btn {
        background: var(--white);
        color: var(--primary);
        position: relative;
        overflow: hidden;
    }

    .offer-content .btn:hover {
        background: transparent;
        color: var(--white);
        border-color: var(--white);
    }

    @media (max-width: 768px) {
        .offer-content {
            flex-direction: column;
            gap: 15px;
        }

        .offer-content h3 {
            font-size: 1.5rem;
        }

        .offer-content p {
            font-size: 1.1rem;
        }
    }
</style>

<!-- Courses Section -->
<section class="courses-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-subtitle">Our Courses</span>
            <h2 class="section-title">Featured <span>Learning Paths</span></h2>
        </div>

        <div class="grid grid-3">
            @forelse($featuredCourses as $course)
            <!-- Course Card -->
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
                        <span><i class="fas fa-language"></i> {{ $course->language }}</span>
                    </div>
                    <h3 class="course-title">
                        <a href="{{ route('courses.show', $course->slug) }}">{{ $course->title }}</a>
                    </h3>
                    <p>{{ Str::limit($course->excerpt, 100) }}</p>

                    @if($course->total_students > 0)
                    <div class="course-stats">
                        <span><i class="fas fa-users"></i> {{ number_format($course->total_students) }} students</span>
                        @if($course->average_rating > 0)
                        <span>
                            <i class="fas fa-star" style="color: #ffd700;"></i>
                            {{ number_format($course->average_rating, 1) }} ({{ $course->total_reviews }})
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
                            {{ $course->price > 0 ? 'Enroll Now' : 'Start Learning' }}
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center">
                <p>No featured courses available at the moment.</p>
            </div>
            @endforelse
        </div>

        <div style="text-align: center; margin-top: 50px;">
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
                <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="About EDUCONECX">
                <div class="experience-badge">
                    <span class="years">5+</span>
                    <span class="text">Years of Excellence</span>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .about-section {
        padding: 80px 0;
        background: var(--white);
    }

    .about-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: center;
    }

    .about-content p {
        margin-bottom: 20px;
        color: var(--gray);
        line-height: 1.8;
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
        color: var(--dark);
    }

    .about-feature i {
        color: var(--success);
        font-size: 1.1rem;
    }

    .about-image {
        position: relative;
        border-radius: var(--border-radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-lg);
    }

    .about-image img {
        width: 100%;
        height: auto;
        display: block;
        transition: var(--transition-slow);
    }

    .about-image:hover img {
        transform: scale(1.05);
    }

    .experience-badge {
        position: absolute;
        bottom: 30px;
        right: 30px;
        background: var(--gradient-1);
        color: var(--white);
        padding: 20px;
        border-radius: var(--border-radius-lg);
        text-align: center;
        box-shadow: var(--shadow-lg);
        animation: float-slow 6s ease-in-out infinite;
    }

    .experience-badge .years {
        display: block;
        font-size: 2rem;
        font-weight: 800;
        line-height: 1;
    }

    .experience-badge .text {
        font-size: 0.9rem;
        opacity: 0.9;
    }

    @media (max-width: 768px) {
        .about-grid {
            grid-template-columns: 1fr;
            gap: 40px;
        }

        .about-features {
            grid-template-columns: 1fr;
        }

        .experience-badge {
            bottom: 20px;
            right: 20px;
            padding: 15px;
        }

        .experience-badge .years {
            font-size: 1.5rem;
        }
    }
</style>

<!-- Testimonials Section -->
<section class="testimonials-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-subtitle">Testimonials</span>
            <h2 class="section-title">What Our <span>Students Say</span></h2>
        </div>

        <div class="testimonials-grid">
            <!-- Testimonial 1 -->
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
                    I was able to learn at my own pace even with slow internet. The AI companion
                    kept me motivated throughout my journey."
                </p>
                <div class="testimonial-author">
                    <div class="author-image">
                        <img src="https://images.unsplash.com/photo-1494790108777-78fdb682e5c7?ixlib=rb-1.2.1&auto=format&fit=crop&w=200&q=80" alt="Sarah M.">
                    </div>
                    <div class="author-info">
                        <h4>Sarah M.</h4>
                        <p>Business Student</p>
                    </div>
                </div>
            </div>

            <!-- Testimonial 2 -->
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
                    motivated and focused. It feels personal and uplifting. I've learned more in 3
                    months than in years of traditional learning."
                </p>
                <div class="testimonial-author">
                    <div class="author-image">
                        <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&auto=format&fit=crop&w=200&q=80" alt="Daniel K.">
                    </div>
                    <div class="author-info">
                        <h4>Daniel K.</h4>
                        <p>Graduate Student</p>
                    </div>
                </div>
            </div>

            <!-- Testimonial 3 -->
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
                    access courses, guidance, and digital services all in one place. The community
                    support is incredible!"
                </p>
                <div class="testimonial-author">
                    <div class="author-image">
                        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-1.2.1&auto=format&fit=crop&w=200&q=80" alt="Aisha R.">
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
    <div class="cta-particles">
        <div class="cta-particle"></div>
        <div class="cta-particle"></div>
        <div class="cta-particle"></div>
    </div>

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
            <!-- FAQ Item 1 -->
            <div class="faq-item" data-aos="fade-up">
                <div class="faq-question">
                    <span>What is EDUCONECX?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>EDUCONECX is an innovative online educational platform that combines AI-powered learning with specialized training programs. We offer both free and premium educational content designed to accelerate your professional development in language skills and digital business.</p>
                </div>
            </div>

            <!-- FAQ Item 2 -->
            <div class="faq-item" data-aos="fade-up" data-aos-delay="100">
                <div class="faq-question">
                    <span>In which languages are the courses available?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Our courses are available in English, French, Haitian Creole, and Spanish to serve our diverse international community of learners. We're constantly working to add more languages to make education accessible to everyone.</p>
                </div>
            </div>

            <!-- FAQ Item 3 -->
            <div class="faq-item" data-aos="fade-up" data-aos-delay="200">
                <div class="faq-question">
                    <span>How do I get started?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Getting started is simple: create your account, select your preferred course, and begin with our 3-day free trial to explore the platform risk-free. No credit card required for the trial period.</p>
                </div>
            </div>

            <!-- FAQ Item 4 -->
            <div class="faq-item" data-aos="fade-up" data-aos-delay="300">
                <div class="faq-question">
                    <span>Can I access courses on mobile?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Yes! Our platform is fully responsive and optimized for all devices. You can access your courses on desktop, tablet, or smartphone anytime, anywhere. We're also developing dedicated mobile apps for an even better experience.</p>
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

            // Close all FAQ items
            document.querySelectorAll('.faq-item').forEach(item => {
                item.classList.remove('active');
                const icon = item.querySelector('.faq-question i');
                if (icon) {
                    icon.classList.remove('fa-chevron-up');
                    icon.classList.add('fa-chevron-down');
                }
            });

            // If it wasn't active before, open it
            if (!wasActive) {
                faqItem.classList.add('active');
                const icon = question.querySelector('i');
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
            }
        });
    });

    // Counter Animation for Stats
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

    // Intersection Observer for stats animation
    const observerOptions = {
        threshold: 0.5,
        rootMargin: '0px'
    };

    const statsObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const statNumbers = document.querySelectorAll('.stats-number');
                statNumbers.forEach(stat => {
                    const value = parseFloat(stat.getAttribute('data-target'));
                    const text = stat.textContent;
                    const hasPlus = text.includes('+');
                    const start = 0;
                    animateValue(stat, start, value, 2000);
                });
                statsObserver.unobserve(entry.target);
            }
        });
    }, observerOptions);

    const statsSection = document.querySelector('.stats-section');
    if (statsSection) {
        statsObserver.observe(statsSection);
    }

    // Parallax effect for hero particles
    document.addEventListener('mousemove', (e) => {
        const particles = document.querySelectorAll('.hero-particle');
        const mouseX = e.clientX / window.innerWidth - 0.5;
        const mouseY = e.clientY / window.innerHeight - 0.5;

        particles.forEach((particle, index) => {
            const speed = (index + 1) * 20;
            const x = mouseX * speed;
            const y = mouseY * speed;
            particle.style.transform = `translate(${x}px, ${y}px)`;
        });
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Navbar background change on scroll
    window.addEventListener('scroll', () => {
        const header = document.querySelector('header');
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });

    // Lazy loading for images
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.add('loaded');
                    imageObserver.unobserve(img);
                }
            });
        });

        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }

    // Initialize AOS (Animate On Scroll) if available
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100
        });
    }
</script>
@endpush