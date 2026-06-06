@extends('layouts.main')

@section('title', App\Helpers\TranslationHelper::trans('academy.title'))

@section('meta_description', App\Helpers\TranslationHelper::trans('academy.meta_description'))

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
        
        /* Gradients with your colors */
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
        --transition-slow: all 0.5s ease;
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

    /* Hero Section */
    .academy-hero {
        position: relative;
        background: var(--gradient-1);
        padding: 120px 0;
        overflow: hidden;
        color: var(--pure-white);
    }

    @media (max-width: 992px) {
        .academy-hero {
            padding: 100px 0;
        }
    }

    @media (max-width: 768px) {
        .academy-hero {
            padding: 80px 0;
        }
    }

    @media (max-width: 576px) {
        .academy-hero {
            padding: 60px 0;
        }
    }

    .academy-hero-particles {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    .academy-hero-particle {
        position: absolute;
        background: rgba(251, 198, 12, 0.1);
        border-radius: 50%;
    }

    .academy-hero-particle:nth-child(1) {
        width: 400px;
        height: 400px;
        top: -200px;
        right: -100px;
        animation: float 10s ease-in-out infinite;
    }

    @media (max-width: 768px) {
        .academy-hero-particle:nth-child(1) {
            width: 250px;
            height: 250px;
            top: -100px;
            right: -50px;
        }
    }

    .academy-hero-particle:nth-child(2) {
        width: 300px;
        height: 300px;
        bottom: -150px;
        left: -100px;
        background: rgba(90, 209, 228, 0.1);
        animation: float 12s ease-in-out infinite reverse;
    }

    @media (max-width: 768px) {
        .academy-hero-particle:nth-child(2) {
            width: 200px;
            height: 200px;
            bottom: -80px;
            left: -50px;
        }
    }

    .academy-hero-particle:nth-child(3) {
        width: 200px;
        height: 200px;
        top: 30%;
        left: 20%;
        background: rgba(235, 215, 137, 0.1);
        animation: float 8s ease-in-out infinite;
    }

    @media (max-width: 768px) {
        .academy-hero-particle:nth-child(3) {
            width: 150px;
            height: 150px;
        }
    }

    .academy-hero-particle:nth-child(4) {
        width: 150px;
        height: 150px;
        bottom: 20%;
        right: 15%;
        background: rgba(10, 29, 68, 0.1);
        animation: float 9s ease-in-out infinite reverse;
    }

    @media (max-width: 768px) {
        .academy-hero-particle:nth-child(4) {
            width: 100px;
            height: 100px;
        }
    }

    .academy-hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
        max-width: 900px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .academy-hero-badge {
        display: inline-block;
        padding: 8px 20px;
        background: rgba(254, 253, 254, 0.2);
        border-radius: var(--radius-full);
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 25px;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(251, 198, 12, 0.3);
        animation: fadeInDown 1s ease-out;
        color: var(--pure-white);
    }

    @media (max-width: 576px) {
        .academy-hero-badge {
            font-size: 0.8rem;
            padding: 6px 16px;
            margin-bottom: 20px;
        }
    }

    .academy-hero-title {
        font-size: clamp(2rem, 8vw, 4rem);
        font-weight: 800;
        margin-bottom: 20px;
        line-height: 1.1;
        text-shadow: 0 2px 10px rgba(10, 29, 68, 0.3);
        animation: fadeInUp 1s ease-out 0.2s both;
    }

    @media (max-width: 576px) {
        .academy-hero-title {
            margin-bottom: 15px;
        }
    }

    .academy-hero-title span {
        color: var(--bright-amber);
    }

    .academy-hero-text {
        font-size: clamp(1rem, 3vw, 1.3rem);
        opacity: 0.95;
        line-height: 1.8;
        max-width: 700px;
        margin: 0 auto 40px;
        animation: fadeInUp 1s ease-out 0.4s both;
        color: var(--ivory);
    }

    @media (max-width: 576px) {
        .academy-hero-text {
            margin-bottom: 30px;
            line-height: 1.6;
        }
    }

    .academy-hero-stats {
        display: flex;
        justify-content: center;
        gap: 60px;
        flex-wrap: wrap;
        animation: fadeInUp 1s ease-out 0.6s both;
    }

    @media (max-width: 768px) {
        .academy-hero-stats {
            gap: 30px;
        }
    }

    @media (max-width: 576px) {
        .academy-hero-stats {
            gap: 20px;
        }
    }

    .hero-stat-item {
        text-align: center;
    }

    .hero-stat-number {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 5px;
        background: linear-gradient(135deg, var(--bright-amber), var(--light-gold));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    @media (max-width: 768px) {
        .hero-stat-number {
            font-size: 1.5rem;
        }
    }

    @media (max-width: 576px) {
        .hero-stat-number {
            font-size: 1.3rem;
        }
    }

    .hero-stat-label {
        font-size: 0.95rem;
        opacity: 0.8;
        color: var(--ivory);
    }

    @media (max-width: 576px) {
        .hero-stat-label {
            font-size: 0.8rem;
        }
    }


    .english-course-structure {
        background: var(--ivory);
        padding: 80px 0;
    }

    .english-course-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
    }

    .english-course-card {
        background: var(--pure-white);
        border: 1px solid rgba(10, 29, 68, .08);
        border-radius: var(--radius-lg);
        padding: 22px;
        box-shadow: var(--shadow-sm);
    }

    .english-course-card span {
        display: inline-flex;
        width: 40px;
        height: 40px;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        background: var(--gradient-2);
        color: var(--prussian-blue);
        font-weight: 900;
        margin-bottom: 12px;
    }

    .english-course-card h3 {
        color: var(--prussian-blue);
        font-weight: 800;
        font-size: 1.05rem;
    }

    .english-course-card p {
        color: var(--text-muted);
        margin-bottom: 14px;
    }

    .english-course-card a {
        color: var(--prussian-blue);
        font-weight: 800;
        text-decoration: none;
    }

    @media (max-width: 900px) {
        .english-course-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }

    @media (max-width: 520px) {
        .english-course-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px; }
        .english-course-card { padding: 16px; }
    }

    /* Section Header */
    .section-header {
        text-align: center;
        margin-bottom: 50px;
        padding: 0 20px;
    }

    @media (max-width: 768px) {
        .section-header {
            margin-bottom: 35px;
        }
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

    @media (max-width: 576px) {
        .section-subtitle {
            font-size: 0.8rem;
            letter-spacing: 1px;
        }
    }

    .section-title {
        font-size: clamp(1.8rem, 5vw, 2.5rem);
        font-weight: 800;
        margin-bottom: 15px;
        color: var(--prussian-blue);
    }

    .section-title span {
        color: var(--bright-amber);
    }

    .section-description {
        color: var(--text-muted);
        max-width: 700px;
        margin: 0 auto;
        font-size: 1.1rem;
        line-height: 1.8;
    }

    @media (max-width: 768px) {
        .section-description {
            font-size: 1rem;
        }
    }

    /* Features Section */
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
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 30px;
        margin-top: 50px;
        padding: 0 20px;
    }

    @media (max-width: 768px) {
        .features-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
    }

    @media (max-width: 576px) {
        .features-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
    }

    .feature-card {
        background: var(--pure-white);
        padding: 40px 30px;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        transition: var(--transition);
        text-align: center;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(251, 198, 12, 0.1);
        height: 100%;
    }

    @media (max-width: 768px) {
        .feature-card {
            padding: 30px 20px;
        }
    }

    .feature-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: var(--gradient-2);
        transform: translateX(-100%);
        transition: var(--transition);
    }

    .feature-card:hover::before {
        transform: translateX(0);
    }

    .feature-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-hover);
        border-color: var(--bright-amber);
    }

    .feature-icon {
        width: 80px;
        height: 80px;
        background: var(--gradient-1);
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px;
        color: var(--pure-white);
        font-size: 2rem;
        transition: var(--transition);
    }

    @media (max-width: 768px) {
        .feature-icon {
            width: 70px;
            height: 70px;
            font-size: 1.8rem;
            margin-bottom: 20px;
        }
    }

    .feature-card:hover .feature-icon {
        transform: scale(1.1);
        background: var(--gradient-2);
        color: var(--prussian-blue);
    }

    .feature-title {
        font-size: 1.3rem;
        margin-bottom: 15px;
        font-weight: 700;
        color: var(--prussian-blue);
    }

    @media (max-width: 768px) {
        .feature-title {
            font-size: 1.2rem;
            margin-bottom: 12px;
        }
    }

    .feature-text {
        color: var(--text-muted);
        line-height: 1.6;
        font-size: 0.95rem;
    }

    /* Categories Section */
    .categories-section {
        padding: 80px 0;
        background: var(--ivory);
    }

    @media (max-width: 768px) {
        .categories-section {
            padding: 60px 0;
        }
    }

    @media (max-width: 576px) {
        .categories-section {
            padding: 50px 0;
        }
    }

    .category-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 30px;
        margin-top: 50px;
        padding: 0 20px;
    }

    @media (max-width: 992px) {
        .category-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .category-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
    }

    .category-card {
        background: var(--pure-white);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-md);
        transition: var(--transition);
        height: 100%;
        position: relative;
        border: 1px solid rgba(251, 198, 12, 0.1);
        display: flex;
        flex-direction: column;
    }

    .category-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-hover);
        border-color: var(--bright-amber);
    }

    .category-image {
        position: relative;
        overflow: hidden;
        aspect-ratio: 16/9;
    }

    .category-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition-slow);
    }

    .category-card:hover .category-image img {
        transform: scale(1.1);
    }

    .category-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom, transparent 0%, rgba(10, 29, 68, 0.8) 100%);
        opacity: 0;
        transition: var(--transition);
        display: flex;
        align-items: flex-end;
        padding: 20px;
    }

    .category-card:hover .category-overlay {
        opacity: 1;
    }

    .category-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        padding: 5px 15px;
        background: var(--gradient-2);
        color: var(--prussian-blue);
        border-radius: var(--radius-full);
        font-size: 0.8rem;
        font-weight: 600;
        z-index: 2;
        box-shadow: var(--shadow-md);
    }

    @media (max-width: 576px) {
        .category-badge {
            top: 15px;
            right: 15px;
            padding: 4px 12px;
            font-size: 0.7rem;
        }
    }

    .category-icon {
        position: absolute;
        bottom: 20px;
        left: 20px;
        width: 50px;
        height: 50px;
        background: var(--gradient-2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--prussian-blue);
        font-size: 1.5rem;
        transform: translateY(20px);
        opacity: 0;
        transition: var(--transition);
        box-shadow: var(--shadow-lg);
    }

    @media (max-width: 576px) {
        .category-icon {
            width: 40px;
            height: 40px;
            font-size: 1.2rem;
        }
    }

    .category-card:hover .category-icon {
        transform: translateY(0);
        opacity: 1;
    }

    .category-content {
        padding: 25px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    @media (max-width: 768px) {
        .category-content {
            padding: 20px;
        }
    }

    .category-name {
        font-size: 0.9rem;
        color: var(--bright-amber);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 10px;
        font-weight: 600;
    }

    .category-title {
        font-size: 1.4rem;
        margin-bottom: 15px;
        font-weight: 700;
        line-height: 1.3;
        color: var(--prussian-blue);
    }

    @media (max-width: 768px) {
        .category-title {
            font-size: 1.3rem;
        }
    }

    .category-description {
        color: var(--text-muted);
        line-height: 1.8;
        margin-bottom: 20px;
        flex: 1;
        font-size: 0.95rem;
    }

    .category-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid rgba(251, 198, 12, 0.2);
    }

    @media (max-width: 576px) {
        .category-meta {
            gap: 15px;
        }
    }

    .category-meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--text-muted);
        font-size: 0.9rem;
    }

    .category-meta-item i {
        color: var(--bright-amber);
        flex-shrink: 0;
    }

    .category-link {
        color: var(--prussian-blue);
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: var(--transition);
        margin-top: auto;
    }

    .category-link:hover {
        gap: 12px;
        color: var(--bright-amber);
    }

    /* Learning Paths Section */
    .paths-section {
        padding: 80px 0;
        background: var(--pure-white);
    }

    @media (max-width: 768px) {
        .paths-section {
            padding: 60px 0;
        }
    }

    @media (max-width: 576px) {
        .paths-section {
            padding: 50px 0;
        }
    }

    .paths-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        margin-top: 50px;
        padding: 0 20px;
    }

    @media (max-width: 768px) {
        .paths-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
    }

    .path-card {
        background: var(--pure-white);
        border-radius: var(--radius-lg);
        padding: 40px 30px;
        box-shadow: var(--shadow-md);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(90, 209, 228, 0.1);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    @media (max-width: 768px) {
        .path-card {
            padding: 30px 25px;
        }
    }

    .path-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 100px;
        height: 100px;
        background: var(--gradient-1);
        border-radius: 50%;
        transform: translate(50px, -50px);
        opacity: 0.1;
        transition: var(--transition);
    }

    .path-card:hover::before {
        transform: translate(30px, -30px) scale(1.5);
        opacity: 0.15;
    }

    .path-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-hover);
        border-color: var(--sky-blue);
    }

    .path-icon {
        width: 70px;
        height: 70px;
        background: var(--gradient-1);
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 25px;
        color: var(--pure-white);
        font-size: 1.8rem;
        transition: var(--transition);
    }

    @media (max-width: 768px) {
        .path-icon {
            width: 60px;
            height: 60px;
            font-size: 1.5rem;
            margin-bottom: 20px;
        }
    }

    .path-card:hover .path-icon {
        transform: scale(1.1);
        background: var(--gradient-2);
        color: var(--prussian-blue);
    }

    .path-title {
        font-size: 1.4rem;
        margin-bottom: 15px;
        font-weight: 700;
        color: var(--prussian-blue);
    }

    @media (max-width: 768px) {
        .path-title {
            font-size: 1.3rem;
        }
    }

    .path-description {
        color: var(--text-muted);
        line-height: 1.8;
        margin-bottom: 20px;
        flex: 1;
        font-size: 0.95rem;
    }

    .path-features {
        list-style: none;
        margin-bottom: 25px;
    }

    .path-features li {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 12px;
        color: var(--text-muted);
        font-size: 0.95rem;
    }

    .path-features li i {
        color: var(--bright-amber);
        font-size: 1rem;
        flex-shrink: 0;
    }

    .path-level {
        display: inline-block;
        padding: 6px 16px;
        background: var(--ivory);
        border-radius: var(--radius-full);
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--prussian-blue);
        border: 1px solid rgba(251, 198, 12, 0.2);
        align-self: flex-start;
    }

    /* CTA Section */
    .academy-cta {
        padding: 80px 0;
        background: var(--gradient-1);
        color: var(--pure-white);
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    @media (max-width: 768px) {
        .academy-cta {
            padding: 60px 0;
        }
    }

    @media (max-width: 576px) {
        .academy-cta {
            padding: 50px 0;
        }
    }

    .academy-cta::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: rgba(251, 198, 12, 0.1);
        border-radius: 50%;
        animation: float 10s ease-in-out infinite;
    }

    .academy-cta::after {
        content: '';
        position: absolute;
        bottom: -50%;
        left: -10%;
        width: 300px;
        height: 300px;
        background: rgba(90, 209, 228, 0.1);
        border-radius: 50%;
        animation: float 8s ease-in-out infinite reverse;
    }

    .academy-cta-content {
        position: relative;
        z-index: 2;
        max-width: 700px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .academy-cta h2 {
        font-size: clamp(1.8rem, 5vw, 3rem);
        margin-bottom: 20px;
        color: var(--pure-white);
    }

    .academy-cta h2 span {
        color: var(--bright-amber);
    }

    .academy-cta p {
        font-size: 1.2rem;
        opacity: 0.95;
        margin-bottom: 30px;
        color: var(--ivory);
    }

    @media (max-width: 768px) {
        .academy-cta p {
            font-size: 1.1rem;
        }
    }

    @media (max-width: 576px) {
        .academy-cta p {
            font-size: 1rem;
        }
    }

    .academy-cta-buttons {
        display: flex;
        gap: 20px;
        justify-content: center;
        flex-wrap: wrap;
    }

    @media (max-width: 576px) {
        .academy-cta-buttons {
            flex-direction: column;
            gap: 15px;
        }
    }

    .academy-cta-buttons .btn {
        min-width: 200px;
        padding: 14px 28px;
    }

    @media (max-width: 768px) {
        .academy-cta-buttons .btn {
            min-width: 150px;
            padding: 12px 24px;
        }
    }

    @media (max-width: 576px) {
        .academy-cta-buttons .btn {
            min-width: auto;
            width: 100%;
        }
    }

    .academy-cta-buttons .btn-primary {
        background: var(--gradient-2);
        color: var(--prussian-blue);
        border: 2px solid transparent;
    }

    .academy-cta-buttons .btn-primary:hover {
        background: transparent;
        color: var(--pure-white);
        border: 2px solid var(--bright-amber);
        transform: translateY(-3px);
    }

    .academy-cta-buttons .btn-secondary {
        border: 2px solid var(--pure-white);
        color: var(--pure-white);
        background: transparent;
    }

    .academy-cta-buttons .btn-secondary:hover {
        background: var(--pure-white);
        color: var(--prussian-blue);
        border-color: var(--pure-white);
        transform: translateY(-3px);
    }

    /* Button Styles */
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
        border: 2px solid transparent;
    }

    @media (max-width: 576px) {
        .btn {
            padding: 10px 24px;
            font-size: 0.95rem;
        }
    }

    /* Container Padding */
    .container {
        padding-left: 20px;
        padding-right: 20px;
    }

    @media (max-width: 576px) {
        .container {
            padding-left: 15px;
            padding-right: 15px;
        }
    }

    /* Animation pauses on hover for accessibility */
    @media (prefers-reduced-motion: reduce) {
        .academy-hero-particle,
        .academy-cta::before,
        .academy-cta::after,
        .feature-card,
        .category-card,
        .path-card,
        .btn {
            animation: none;
            transition: none;
        }
        
        .feature-card:hover,
        .category-card:hover,
        .path-card:hover,
        .btn:hover {
            transform: none;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="academy-hero">
    <div class="academy-hero-particles">
        <div class="academy-hero-particle"></div>
        <div class="academy-hero-particle"></div>
        <div class="academy-hero-particle"></div>
        <div class="academy-hero-particle"></div>
    </div>

    <div class="container">
        <div class="academy-hero-content">
            <span class="academy-hero-badge">{{ App\Helpers\TranslationHelper::trans('academy.hero_badge') }}</span>
            <h1 class="academy-hero-title" style="line-height: 100px;">{!! App\Helpers\TranslationHelper::trans('academy.hero_title') !!}</h1>
            <p class="academy-hero-text">
                {{ App\Helpers\TranslationHelper::trans('academy.hero_description') }}
            </p>

            <div class="academy-hero-stats">
                <div class="hero-stat-item">
                    <div class="hero-stat-number">50+</div>
                    <div class="hero-stat-label">{{ App\Helpers\TranslationHelper::trans('academy.hero_stat_1') }}</div>
                </div>
                <div class="hero-stat-item">
                    <div class="hero-stat-number">10K+</div>
                    <div class="hero-stat-label">{{ App\Helpers\TranslationHelper::trans('academy.hero_stat_2') }}</div>
                </div>
                <div class="hero-stat-item">
                    <div class="hero-stat-number">15+</div>
                    <div class="hero-stat-label">{{ App\Helpers\TranslationHelper::trans('academy.hero_stat_3') }}</div>
                </div>
                <div class="hero-stat-item">
                    <div class="hero-stat-number">4.9</div>
                    <div class="hero-stat-label">{{ App\Helpers\TranslationHelper::trans('academy.hero_stat_4') }}</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-subtitle">{{ App\Helpers\TranslationHelper::trans('academy.features_subtitle') }}</span>
            <h2 class="section-title">{!! App\Helpers\TranslationHelper::trans('academy.features_title') !!}</h2>
            <p class="section-description">
                {{ App\Helpers\TranslationHelper::trans('academy.features_description') }}
            </p>
        </div>

        <div class="features-grid">
            <div class="feature-card" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-icon">
                    <i class="fas fa-robot"></i>
                </div>
                <h3 class="feature-title">{{ App\Helpers\TranslationHelper::trans('academy.feature_1_title') }}</h3>
                <p class="feature-text">{{ App\Helpers\TranslationHelper::trans('academy.feature_1_text') }}</p>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <h3 class="feature-title">{{ App\Helpers\TranslationHelper::trans('academy.feature_2_title') }}</h3>
                <p class="feature-text">{{ App\Helpers\TranslationHelper::trans('academy.feature_2_text') }}</p>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-icon">
                    <i class="fas fa-award"></i>
                </div>
                <h3 class="feature-title">{{ App\Helpers\TranslationHelper::trans('academy.feature_3_title') }}</h3>
                <p class="feature-text">{{ App\Helpers\TranslationHelper::trans('academy.feature_3_text') }}</p>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="400">
                <div class="feature-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3 class="feature-title">{{ App\Helpers\TranslationHelper::trans('academy.feature_4_title') }}</h3>
                <p class="feature-text">{{ App\Helpers\TranslationHelper::trans('academy.feature_4_text') }}</p>
            </div>
        </div>
    </div>
</section>


<!-- English Course Structure -->
<section class="english-course-structure">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-subtitle">English Course</span>
            <h2 class="section-title">English Course → Modules → Lessons → Videos</h2>
            <p class="section-description">A ready structure for incoming English lesson videos, with direct practice access for every lesson.</p>
        </div>
        <div class="english-course-grid">
            <div class="english-course-card"><span>1</span><h3>Course</h3><p>English speaking course workspace for structured learning.</p><a href="{{ route('courses') }}">View Courses <i class="fas fa-arrow-right"></i></a></div>
            <div class="english-course-card"><span>2</span><h3>Module</h3><p>Modules group lessons by level, topic, and learning goal.</p><a href="{{ route('courses') }}">Browse Modules <i class="fas fa-arrow-right"></i></a></div>
            <div class="english-course-card"><span>3</span><h3>Lesson</h3><p>Lessons include descriptions, learning notes, and video URLs.</p><a href="{{ route('courses') }}">Open Lessons <i class="fas fa-arrow-right"></i></a></div>
            <div class="english-course-card"><span>4</span><h3>Video + Practice</h3><p>Watch a lesson video, then open the Practice Room to practice that lesson.</p><a href="{{ route('educonecx.academy.index') }}">Practice This Lesson <i class="fas fa-arrow-right"></i></a></div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="categories-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-subtitle">{{ App\Helpers\TranslationHelper::trans('academy.categories_subtitle') }}</span>
            <h2 class="section-title">{!! App\Helpers\TranslationHelper::trans('academy.categories_title') !!}</h2>
            <p class="section-description">
                {{ App\Helpers\TranslationHelper::trans('academy.categories_description') }}
            </p>
        </div>

        <div class="category-grid">
            @forelse($categories ?? [] as $category)
            <div class="category-card" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                <div class="category-image">
                    <img src="{{ $category->image_url ?? 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=600&h=400&fit=crop' }}" alt="{{ $category->name }}" loading="lazy">
                    <div class="category-overlay"></div>

                    @if(isset($category->courses) && $category->courses->count() > 5)
                    <span class="category-badge">{{ App\Helpers\TranslationHelper::trans('academy.category_badge_popular') }}</span>
                    @endif

                    @if($loop->first)
                    <span class="category-badge">{{ App\Helpers\TranslationHelper::trans('academy.category_badge_featured') }}</span>
                    @endif

                    <div class="category-icon">
                        <i class="{{ $category->icon_class ?? 'fas fa-book-open' }}"></i>
                    </div>
                </div>
                <div class="category-content">
                    <div class="category-name">{{ $category->name }}</div>
                    <h3 class="category-title">{{ $category->description ? Str::limit($category->description, 60) : App\Helpers\TranslationHelper::trans('academy.category_default_title', ['name' => $category->name]) }}</h3>
                    <p class="category-description">
                        {{ $category->description ?? App\Helpers\TranslationHelper::trans('academy.category_default_description', ['name' => $category->name]) }}
                    </p>
                    <div class="category-meta">
                        <div class="category-meta-item">
                            <i class="far fa-clock"></i>
                            <span>{{ App\Helpers\TranslationHelper::trans('academy.category_hours', ['count' => isset($category->courses) ? $category->courses->sum('duration') : 20]) }}</span>
                        </div>
                        <div class="category-meta-item">
                            <i class="fas fa-signal"></i>
                            <span>{{ App\Helpers\TranslationHelper::trans('academy.category_all_levels') }}</span>
                        </div>
                        <div class="category-meta-item">
                            <i class="fas fa-video"></i>
                            <span>{{ App\Helpers\TranslationHelper::trans('academy.category_courses', ['count' => isset($category->courses) ? $category->courses->count() : 10]) }}</span>
                        </div>
                    </div>
                    <a href="{{ route('courses', ['category' => $category->slug ?? '#']) }}" class="category-link">
                        {{ App\Helpers\TranslationHelper::trans('academy.category_link', ['name' => $category->name]) }} <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            @empty
            <!-- Sample categories for demonstration -->
            <div class="category-card" data-aos="fade-up" data-aos-delay="100">
                <div class="category-image">
                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=600&h=400&fit=crop" alt="{{ App\Helpers\TranslationHelper::trans('academy.category_business_name') }}" loading="lazy">
                    <div class="category-overlay"></div>
                    <span class="category-badge">{{ App\Helpers\TranslationHelper::trans('academy.category_badge_featured') }}</span>
                    <div class="category-icon">
                        <i class="fas fa-briefcase"></i>
                    </div>
                </div>
                <div class="category-content">
                    <div class="category-name">{{ App\Helpers\TranslationHelper::trans('academy.category_business_name') }}</div>
                    <h3 class="category-title">{{ App\Helpers\TranslationHelper::trans('academy.category_business_title') }}</h3>
                    <p class="category-description">
                        {{ App\Helpers\TranslationHelper::trans('academy.category_business_description') }}
                    </p>
                    <div class="category-meta">
                        <div class="category-meta-item">
                            <i class="far fa-clock"></i>
                            <span>{{ App\Helpers\TranslationHelper::trans('academy.category_hours', ['count' => 45]) }}</span>
                        </div>
                        <div class="category-meta-item">
                            <i class="fas fa-signal"></i>
                            <span>{{ App\Helpers\TranslationHelper::trans('academy.category_all_levels') }}</span>
                        </div>
                        <div class="category-meta-item">
                            <i class="fas fa-video"></i>
                            <span>{{ App\Helpers\TranslationHelper::trans('academy.category_courses', ['count' => 12]) }}</span>
                        </div>
                    </div>
                    <a href="{{ route('courses') }}" class="category-link">
                        {{ App\Helpers\TranslationHelper::trans('academy.category_link', ['name' => App\Helpers\TranslationHelper::trans('academy.category_business_name')]) }} <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="category-card" data-aos="fade-up" data-aos-delay="200">
                <div class="category-image">
                    <img src="https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?w=600&h=400&fit=crop" alt="{{ App\Helpers\TranslationHelper::trans('academy.category_english_name') }}" loading="lazy">
                    <div class="category-overlay"></div>
                    <span class="category-badge">{{ App\Helpers\TranslationHelper::trans('academy.category_badge_popular') }}</span>
                    <div class="category-icon">
                        <i class="fas fa-language"></i>
                    </div>
                </div>
                <div class="category-content">
                    <div class="category-name">{{ App\Helpers\TranslationHelper::trans('academy.category_english_name') }}</div>
                    <h3 class="category-title">{{ App\Helpers\TranslationHelper::trans('academy.category_english_title') }}</h3>
                    <p class="category-description">
                        {{ App\Helpers\TranslationHelper::trans('academy.category_english_description') }}
                    </p>
                    <div class="category-meta">
                        <div class="category-meta-item">
                            <i class="far fa-clock"></i>
                            <span>{{ App\Helpers\TranslationHelper::trans('academy.category_hours', ['count' => 50]) }}</span>
                        </div>
                        <div class="category-meta-item">
                            <i class="fas fa-signal"></i>
                            <span>{{ App\Helpers\TranslationHelper::trans('academy.category_all_levels') }}</span>
                        </div>
                        <div class="category-meta-item">
                            <i class="fas fa-video"></i>
                            <span>{{ App\Helpers\TranslationHelper::trans('academy.category_courses', ['count' => 15]) }}</span>
                        </div>
                    </div>
                    <a href="{{ route('courses') }}" class="category-link">
                        {{ App\Helpers\TranslationHelper::trans('academy.category_link', ['name' => App\Helpers\TranslationHelper::trans('academy.category_english_name')]) }} <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="category-card" data-aos="fade-up" data-aos-delay="300">
                <div class="category-image">
                    <img src="https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?w=600&h=400&fit=crop" alt="{{ App\Helpers\TranslationHelper::trans('academy.category_finance_name') }}" loading="lazy">
                    <div class="category-overlay"></div>
                    <div class="category-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
                <div class="category-content">
                    <div class="category-name">{{ App\Helpers\TranslationHelper::trans('academy.category_finance_name') }}</div>
                    <h3 class="category-title">{{ App\Helpers\TranslationHelper::trans('academy.category_finance_title') }}</h3>
                    <p class="category-description">
                        {{ App\Helpers\TranslationHelper::trans('academy.category_finance_description') }}
                    </p>
                    <div class="category-meta">
                        <div class="category-meta-item">
                            <i class="far fa-clock"></i>
                            <span>{{ App\Helpers\TranslationHelper::trans('academy.category_hours', ['count' => 32]) }}</span>
                        </div>
                        <div class="category-meta-item">
                            <i class="fas fa-signal"></i>
                            <span>{{ App\Helpers\TranslationHelper::trans('academy.category_all_levels') }}</span>
                        </div>
                        <div class="category-meta-item">
                            <i class="fas fa-video"></i>
                            <span>{{ App\Helpers\TranslationHelper::trans('academy.category_courses', ['count' => 8]) }}</span>
                        </div>
                    </div>
                    <a href="{{ route('courses') }}" class="category-link">
                        {{ App\Helpers\TranslationHelper::trans('academy.category_link', ['name' => App\Helpers\TranslationHelper::trans('academy.category_finance_name')]) }} <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="category-card" data-aos="fade-up" data-aos-delay="400">
                <div class="category-image">
                    <img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?w=600&h=400&fit=crop" alt="{{ App\Helpers\TranslationHelper::trans('academy.category_technology_name') }}" loading="lazy">
                    <div class="category-overlay"></div>
                    <div class="category-icon">
                        <i class="fas fa-code"></i>
                    </div>
                </div>
                <div class="category-content">
                    <div class="category-name">{{ App\Helpers\TranslationHelper::trans('academy.category_technology_name') }}</div>
                    <h3 class="category-title">{{ App\Helpers\TranslationHelper::trans('academy.category_technology_title') }}</h3>
                    <p class="category-description">
                        {{ App\Helpers\TranslationHelper::trans('academy.category_technology_description') }}
                    </p>
                    <div class="category-meta">
                        <div class="category-meta-item">
                            <i class="far fa-clock"></i>
                            <span>{{ App\Helpers\TranslationHelper::trans('academy.category_hours', ['count' => 40]) }}</span>
                        </div>
                        <div class="category-meta-item">
                            <i class="fas fa-signal"></i>
                            <span>{{ App\Helpers\TranslationHelper::trans('academy.category_all_levels') }}</span>
                        </div>
                        <div class="category-meta-item">
                            <i class="fas fa-video"></i>
                            <span>{{ App\Helpers\TranslationHelper::trans('academy.category_courses', ['count' => 10]) }}</span>
                        </div>
                    </div>
                    <a href="{{ route('courses') }}" class="category-link">
                        {{ App\Helpers\TranslationHelper::trans('academy.category_link', ['name' => App\Helpers\TranslationHelper::trans('academy.category_technology_name')]) }} <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Learning Paths Section -->
<section class="paths-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-subtitle">{{ App\Helpers\TranslationHelper::trans('academy.paths_subtitle') }}</span>
            <h2 class="section-title">{!! App\Helpers\TranslationHelper::trans('academy.paths_title') !!}</h2>
            <p class="section-description">
                {{ App\Helpers\TranslationHelper::trans('academy.paths_description') }}
            </p>
        </div>

        <div class="paths-grid">
            @forelse($learningPaths ?? [] as $path)
            <div class="path-card" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                <div class="path-icon">
                    <i class="{{ $path->icon_class ?? 'fas fa-graduation-cap' }}"></i>
                </div>
                <h3 class="path-title">{{ $path->name }}</h3>
                <p class="path-description">
                    {{ $path->description ?? App\Helpers\TranslationHelper::trans('academy.path_default_description', ['name' => $path->name]) }}
                </p>
                <ul class="path-features">
                    @php
                    $features = isset($path->courses) ? $path->courses->take(4) : [];
                    @endphp

                    @forelse($features as $course)
                    <li><i class="fas fa-check-circle"></i> {{ $course->title }}</li>
                    @empty
                    <li><i class="fas fa-check-circle"></i> {{ App\Helpers\TranslationHelper::trans('academy.path_default_feature_1', ['name' => $path->name ?? 'Business']) }}</li>
                    <li><i class="fas fa-check-circle"></i> {{ App\Helpers\TranslationHelper::trans('academy.path_default_feature_2', ['name' => $path->name ?? 'Business']) }}</li>
                    <li><i class="fas fa-check-circle"></i> {{ App\Helpers\TranslationHelper::trans('academy.path_default_feature_3') }}</li>
                    <li><i class="fas fa-check-circle"></i> {{ App\Helpers\TranslationHelper::trans('academy.path_default_feature_4') }}</li>
                    @endforelse
                </ul>
                <span class="path-level">
                    {{ App\Helpers\TranslationHelper::trans('academy.path_courses_count', [
                        'count' => isset($path->courses) ? $path->courses->count() : 12,
                        'hours' => isset($path->courses) ? $path->courses->sum('duration') : 40
                    ]) }}
                </span>
            </div>
            @empty
            <!-- Fallback learning paths if none exist in database -->
            <div class="path-card" data-aos="fade-up" data-aos-delay="100">
                <div class="path-icon">
                    <i class="fas fa-briefcase"></i>
                </div>
                <h3 class="path-title">{{ App\Helpers\TranslationHelper::trans('academy.path_business_title') }}</h3>
                <p class="path-description">
                    {{ App\Helpers\TranslationHelper::trans('academy.path_business_description') }}
                </p>
                <ul class="path-features">
                    <li><i class="fas fa-check-circle"></i> {{ App\Helpers\TranslationHelper::trans('academy.path_business_feature_1') }}</li>
                    <li><i class="fas fa-check-circle"></i> {{ App\Helpers\TranslationHelper::trans('academy.path_business_feature_2') }}</li>
                    <li><i class="fas fa-check-circle"></i> {{ App\Helpers\TranslationHelper::trans('academy.path_business_feature_3') }}</li>
                    <li><i class="fas fa-check-circle"></i> {{ App\Helpers\TranslationHelper::trans('academy.path_business_feature_4') }}</li>
                </ul>
                <span class="path-level">{{ App\Helpers\TranslationHelper::trans('academy.path_courses_count', ['count' => 12, 'hours' => 45]) }}</span>
            </div>

            <div class="path-card" data-aos="fade-up" data-aos-delay="200">
                <div class="path-icon">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <h3 class="path-title">{{ App\Helpers\TranslationHelper::trans('academy.path_finance_title') }}</h3>
                <p class="path-description">
                    {{ App\Helpers\TranslationHelper::trans('academy.path_finance_description') }}
                </p>
                <ul class="path-features">
                    <li><i class="fas fa-check-circle"></i> {{ App\Helpers\TranslationHelper::trans('academy.path_finance_feature_1') }}</li>
                    <li><i class="fas fa-check-circle"></i> {{ App\Helpers\TranslationHelper::trans('academy.path_finance_feature_2') }}</li>
                    <li><i class="fas fa-check-circle"></i> {{ App\Helpers\TranslationHelper::trans('academy.path_finance_feature_3') }}</li>
                    <li><i class="fas fa-check-circle"></i> {{ App\Helpers\TranslationHelper::trans('academy.path_finance_feature_4') }}</li>
                </ul>
                <span class="path-level">{{ App\Helpers\TranslationHelper::trans('academy.path_courses_count', ['count' => 8, 'hours' => 32]) }}</span>
            </div>

            <div class="path-card" data-aos="fade-up" data-aos-delay="300">
                <div class="path-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <h3 class="path-title">{{ App\Helpers\TranslationHelper::trans('academy.path_english_title') }}</h3>
                <p class="path-description">
                    {{ App\Helpers\TranslationHelper::trans('academy.path_english_description') }}
                </p>
                <ul class="path-features">
                    <li><i class="fas fa-check-circle"></i> {{ App\Helpers\TranslationHelper::trans('academy.path_english_feature_1') }}</li>
                    <li><i class="fas fa-check-circle"></i> {{ App\Helpers\TranslationHelper::trans('academy.path_english_feature_2') }}</li>
                    <li><i class="fas fa-check-circle"></i> {{ App\Helpers\TranslationHelper::trans('academy.path_english_feature_3') }}</li>
                    <li><i class="fas fa-check-circle"></i> {{ App\Helpers\TranslationHelper::trans('academy.path_english_feature_4') }}</li>
                </ul>
                <span class="path-level">{{ App\Helpers\TranslationHelper::trans('academy.path_courses_count', ['count' => 15, 'hours' => 50]) }}</span>
            </div>

            <div class="path-card" data-aos="fade-up" data-aos-delay="400">
                <div class="path-icon">
                    <i class="fas fa-code"></i>
                </div>
                <h3 class="path-title">{{ App\Helpers\TranslationHelper::trans('academy.path_technology_title') }}</h3>
                <p class="path-description">
                    {{ App\Helpers\TranslationHelper::trans('academy.path_technology_description') }}
                </p>
                <ul class="path-features">
                    <li><i class="fas fa-check-circle"></i> {{ App\Helpers\TranslationHelper::trans('academy.path_technology_feature_1') }}</li>
                    <li><i class="fas fa-check-circle"></i> {{ App\Helpers\TranslationHelper::trans('academy.path_technology_feature_2') }}</li>
                    <li><i class="fas fa-check-circle"></i> {{ App\Helpers\TranslationHelper::trans('academy.path_technology_feature_3') }}</li>
                    <li><i class="fas fa-check-circle"></i> {{ App\Helpers\TranslationHelper::trans('academy.path_technology_feature_4') }}</li>
                </ul>
                <span class="path-level">{{ App\Helpers\TranslationHelper::trans('academy.path_courses_count', ['count' => 10, 'hours' => 40]) }}</span>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="academy-cta">
    <div class="container">
        <div class="academy-cta-content" data-aos="zoom-in">
            <h2>{!! App\Helpers\TranslationHelper::trans('academy.cta_title') !!}</h2>
            <p>{{ App\Helpers\TranslationHelper::trans('academy.cta_description') }}</p>
            <div class="academy-cta-buttons">
                <a href="{{ route('courses') }}" class="btn btn-primary">
                    <i class="fas fa-play-circle"></i> {{ App\Helpers\TranslationHelper::trans('academy.cta_btn_courses') }}
                </a>
                <a href="{{ route('contact') }}" class="btn btn-secondary">
                    <i class="fas fa-calendar-alt"></i> {{ App\Helpers\TranslationHelper::trans('academy.cta_btn_contact') }}
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // AOS initialization with mobile optimization
        if (typeof AOS !== 'undefined') {
            AOS.init({
                duration: window.innerWidth < 768 ? 400 : 800,
                once: true,
                offset: window.innerWidth < 768 ? 20 : 50,
                disable: window.innerWidth < 576 // Disable on very small screens for performance
            });
        }

        // Handle touch events for mobile
        if ('ontouchstart' in window) {
            const touchElements = document.querySelectorAll('.btn, .feature-card, .category-card, .path-card, .category-link');
            
            touchElements.forEach(element => {
                element.addEventListener('touchstart', function() {
                    this.style.opacity = '0.8';
                }, { passive: true });
                
                element.addEventListener('touchend', function() {
                    this.style.opacity = '1';
                }, { passive: true });
                
                element.addEventListener('touchcancel', function() {
                    this.style.opacity = '1';
                }, { passive: true });
            });
        }

        // Animation pause for users who prefer reduced motion
        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        
        if (prefersReducedMotion) {
            const animatedElements = document.querySelectorAll('.academy-hero-particle, .academy-cta::before, .academy-cta::after');
            
            animatedElements.forEach(element => {
                if (element.style) {
                    element.style.animation = 'none';
                }
            });
        }

        // Lazy loading for images
        if ('loading' in HTMLImageElement.prototype) {
            const images = document.querySelectorAll('img[loading="lazy"]');
            images.forEach(img => {
                img.loading = 'lazy';
            });
        }

        // Header scroll effect
        const header = document.querySelector('header');
        
        if (header) {
            let scrollTimeout;
            
            window.addEventListener('scroll', function() {
                if (!scrollTimeout) {
                    scrollTimeout = setTimeout(function() {
                        if (window.scrollY > 50) {
                            header.classList.add('scrolled');
                        } else {
                            header.classList.remove('scrolled');
                        }
                        scrollTimeout = null;
                    }, 10);
                }
            });
        }
    });

    // Window resize handler for AOS
    let resizeTimeout;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(function() {
            if (typeof AOS !== 'undefined') {
                if (window.innerWidth < 576) {
                    AOS.init({ disable: true });
                } else {
                    AOS.init({ 
                        disable: false,
                        duration: window.innerWidth < 768 ? 400 : 800,
                        offset: window.innerWidth < 768 ? 20 : 50
                    });
                }
            }
        }, 250);
    });
</script>
@endpush