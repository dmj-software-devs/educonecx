@extends('layouts.main')

@section('title', 'Portal 101 - ' . (App\Helpers\TranslationHelper::trans('quiz.title') ?? 'Quizzes'))

@section('meta_description', App\Helpers\TranslationHelper::trans('quiz.meta_description'))

@push('styles')
<style>
    /* ===== ROOT VARIABLES - YOUR BEAUTIFUL LOGO COLORS ===== */
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
        --danger: #EBD789;
        --dark: var(--prussian-blue);
        --dark-light: var(--regal-navy);
        --gray: var(--khaki-beige);
        --gray-light: var(--pale-slate);
        --light: var(--ivory);
        --white: var(--pure-white);
        
        /* Text Colors */
        --text-primary: #0A1D44;
        --text-secondary: #2E5C61;
        --text-muted: #5f5f5f;
        --text-light: #FEFDFE;
        
        /* Gradients with your colors */
        --gradient-1: linear-gradient(135deg, #0A1D44 0%, #18386E 50%, #2E5C61 100%);
        --gradient-2: linear-gradient(45deg, #FBC60C 0%, #EBD789 50%, #F9F7E9 100%);
        --gradient-3: linear-gradient(135deg, #5AD1E4 0%, #CBD1DA 50%, #FEFDFE 100%);
        --gradient-4: linear-gradient(135deg, #2E5C61 0%, #18386E 100%);
        
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

    /* ===== ANIMATIONS ===== */
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    @keyframes slideInRight {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }

    @keyframes slideOutRight {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }

    /* ===== HERO SECTION ===== */
    .quiz-hero {
        position: relative;
        background: var(--gradient-1);
        padding: 80px 0;
        overflow: hidden;
        color: var(--pure-white);
        margin-bottom: 40px;
    }

    @media (max-width: 768px) {
        .quiz-hero {
            padding: 60px 0;
        }
    }

    @media (max-width: 576px) {
        .quiz-hero {
            padding: 50px 0;
        }
    }

    .quiz-hero-particles {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    .quiz-hero-particle {
        position: absolute;
        background: rgba(251, 198, 12, 0.1);
        border-radius: 50%;
    }

    .quiz-hero-particle:nth-child(1) {
        width: 300px;
        height: 300px;
        top: -100px;
        right: -100px;
        animation: float 8s ease-in-out infinite;
    }

    @media (max-width: 768px) {
        .quiz-hero-particle:nth-child(1) {
            width: 200px;
            height: 200px;
            top: -50px;
            right: -50px;
        }
    }

    .quiz-hero-particle:nth-child(2) {
        width: 200px;
        height: 200px;
        bottom: -50px;
        left: -50px;
        background: rgba(90, 209, 228, 0.1);
        animation: float 10s ease-in-out infinite reverse;
    }

    @media (max-width: 768px) {
        .quiz-hero-particle:nth-child(2) {
            width: 150px;
            height: 150px;
            bottom: -30px;
            left: -30px;
        }
    }

    .quiz-hero-particle:nth-child(3) {
        width: 150px;
        height: 150px;
        top: 30%;
        left: 20%;
        background: rgba(235, 215, 137, 0.1);
        animation: float 12s ease-in-out infinite;
    }

    @media (max-width: 768px) {
        .quiz-hero-particle:nth-child(3) {
            width: 100px;
            height: 100px;
        }
    }

    .quiz-hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
        max-width: 800px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .quiz-hero-badge {
        display: inline-block;
        padding: 8px 20px;
        background: rgba(254, 253, 254, 0.2);
        border-radius: var(--radius-full);
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 20px;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(251, 198, 12, 0.3);
        color: var(--pure-white);
    }

    @media (max-width: 576px) {
        .quiz-hero-badge {
            font-size: 0.8rem;
            padding: 6px 16px;
        }
    }

    .quiz-hero-title {
        font-size: clamp(1.8rem, 6vw, 3rem);
        font-weight: 800;
        margin-bottom: 15px;
        line-height: 1.2;
        color: var(--pure-white);
    }

    .quiz-hero-title span {
        color: var(--bright-amber);
    }

    .quiz-hero-subtitle {
        font-size: clamp(1rem, 3vw, 1.5rem);
        opacity: 0.95;
        margin-bottom: 30px;
        color: var(--ivory);
        font-weight: 500;
        letter-spacing: 1px;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    .quiz-hero-subtitle i {
        color: var(--bright-amber);
        margin: 0 10px;
        font-size: 0.9em;
    }

    /* ===== STATISTICS CARDS - HIDDEN IN ACCORDION ===== */
    .quiz-stats-section {
        margin-bottom: 40px;
    }

    .quiz-stats-header {
        display: flex;
        align-items: center;
        gap: 15px;
        cursor: pointer;
        padding: 20px;
        background: var(--pure-white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--pale-slate);
        transition: var(--transition);
        margin-bottom: 20px;
    }

    .quiz-stats-header:hover {
        border-color: var(--bright-amber);
        box-shadow: var(--shadow-hover);
    }

    .quiz-stats-header i {
        color: var(--bright-amber);
        font-size: 1.5rem;
    }

    .quiz-stats-header h2 {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
        flex: 1;
    }

    .quiz-stats-header .chevron {
        color: var(--bright-amber);
        transition: transform 0.3s ease;
    }

    .quiz-stats-header .chevron.rotated {
        transform: rotate(180deg);
    }

    .quiz-stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
        margin-top: 20px;
    }

    @media (max-width: 992px) {
        .quiz-stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .quiz-stats-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
    }

    .quiz-stat-card {
        background: var(--pure-white);
        border-radius: var(--radius-lg);
        padding: 30px 25px;
        box-shadow: var(--shadow-lg);
        display: flex;
        align-items: center;
        transition: var(--transition);
        border: 1px solid rgba(251, 198, 12, 0.1);
        position: relative;
        overflow: hidden;
    }

    .quiz-stat-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-hover);
        border-color: var(--bright-amber);
    }

    .quiz-stat-card::before {
        content: '';
        position: absolute;
        top: -2px;
        left: -2px;
        right: -2px;
        bottom: -2px;
        background: var(--gradient-2);
        border-radius: var(--radius-lg);
        opacity: 0;
        transition: opacity 0.3s;
        z-index: -1;
    }

    .quiz-stat-card:hover::before {
        opacity: 0.2;
    }

    .quiz-stat-icon {
        width: 70px;
        height: 70px;
        background: var(--gradient-1);
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 20px;
        flex-shrink: 0;
    }

    @media (max-width: 768px) {
        .quiz-stat-icon {
            width: 60px;
            height: 60px;
        }
    }

    .quiz-stat-icon i {
        font-size: 28px;
        color: var(--pure-white);
    }

    @media (max-width: 768px) {
        .quiz-stat-icon i {
            font-size: 24px;
        }
    }

    .quiz-stat-details {
        flex: 1;
    }

    .quiz-stat-details h3 {
        font-size: 2rem !important;
        font-weight: 700 !important;
        color: var(--prussian-blue) !important;
        margin: 0 0 5px 0 !important;
        line-height: 1.2 !important;
    }

    @media (max-width: 768px) {
        .quiz-stat-details h3 {
            font-size: 1.8rem !important;
        }
    }

    .quiz-stat-details p {
        margin: 0 !important;
        color: var(--text-muted) !important;
        font-size: 0.95rem !important;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* ===== SEARCH AND FILTER ===== */
    .quiz-search-section {
        margin-bottom: 40px;
    }

    .quiz-search-form {
        max-width: 700px;
        margin: 0 auto;
        position: relative;
    }

    .quiz-search-wrapper {
        display: flex;
        background: var(--pure-white);
        border-radius: var(--radius-full);
        box-shadow: var(--shadow-lg);
        overflow: hidden;
        border: 2px solid transparent;
        transition: var(--transition);
        border: 1px solid rgba(251, 198, 12, 0.1);
    }

    .quiz-search-wrapper:focus-within {
        border-color: var(--bright-amber);
        box-shadow: var(--shadow-hover);
    }

    .quiz-search-input {
        flex: 1;
        padding: 16px 25px;
        border: none;
        font-size: 1rem;
        outline: none;
        background: transparent;
        color: var(--text-primary);
    }

    @media (max-width: 768px) {
        .quiz-search-input {
            padding: 14px 20px;
        }
    }

    .quiz-search-input::placeholder {
        color: var(--text-muted);
        opacity: 0.7;
    }

    .quiz-type-select {
        width: 160px;
        padding: 16px 20px;
        border: none;
        border-left: 2px solid var(--pale-slate);
        background: var(--pure-white);
        font-size: 0.95rem;
        color: var(--text-primary);
        cursor: pointer;
        outline: none;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23FBC60C' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 15px center;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .quiz-type-select {
            width: 140px;
            padding: 14px 15px;
        }
    }

    @media (max-width: 576px) {
        .quiz-type-select {
            width: 100%;
            border-left: none;
            border-top: 2px solid var(--pale-slate);
        }
    }

    .quiz-search-btn {
        padding: 0 30px;
        background: var(--gradient-1);
        border: none;
        color: var(--pure-white);
        font-size: 1rem;
        font-weight: 500;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    @media (max-width: 768px) {
        .quiz-search-btn {
            padding: 0 20px;
        }
    }

    .quiz-search-btn:hover {
        background: var(--gradient-2);
        color: var(--prussian-blue);
    }

    /* ===== QUIZZES GRID ===== */
    .quiz-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
        margin-bottom: 40px;
    }

    @media (max-width: 1200px) {
        .quiz-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .quiz-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
    }

    /* ===== QUIZ CARDS ===== */
    .quiz-card {
        background: var(--pure-white);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-lg);
        transition: var(--transition);
        height: 100%;
        display: flex;
        flex-direction: column;
        position: relative;
        border: 1px solid rgba(251, 198, 12, 0.1);
    }

    .quiz-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-hover);
        border-color: var(--bright-amber);
    }

    .quiz-card-header {
        padding: 20px;
        background: var(--gradient-1);
        color: var(--pure-white);
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        overflow: hidden;
    }

    .quiz-card-header::after {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 150px;
        height: 150px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        pointer-events: none;
    }

    .quiz-type-badge {
        background: rgba(255, 255, 255, 0.2);
        padding: 6px 15px;
        border-radius: var(--radius-full);
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        backdrop-filter: blur(5px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        position: relative;
        z-index: 2;
        color: var(--pure-white);
    }

    /* Time removed from quiz card header */

    .quiz-card-body {
        padding: 25px;
        flex: 1;
    }

    @media (max-width: 768px) {
        .quiz-card-body {
            padding: 20px;
        }
    }

    .quiz-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 12px;
        color: var(--prussian-blue);
        line-height: 1.4;
    }

    @media (max-width: 768px) {
        .quiz-title {
            font-size: 1.2rem;
        }
    }

    .quiz-description {
        color: var(--text-muted);
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 20px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Meta items updated - removed question count and pass percentage */
    .quiz-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 15px;
    }

    .quiz-meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
        color: var(--text-muted);
        background: var(--ivory);
        padding: 6px 12px;
        border-radius: var(--radius-sm);
        border: 1px solid rgba(251, 198, 12, 0.1);
    }

    .quiz-meta-item i {
        color: var(--bright-amber);
        width: 16px;
        font-size: 0.9rem;
    }

    @media (max-width: 576px) {
        .quiz-meta {
            flex-direction: column;
            gap: 10px;
        }
        
        .quiz-meta-item {
            width: 100%;
        }
    }

    .quiz-card-footer {
        padding: 20px 25px;
        background: var(--ivory);
        border-top: 1px solid rgba(251, 198, 12, 0.2);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    @media (max-width: 576px) {
        .quiz-card-footer {
            flex-direction: column;
            gap: 15px;
            align-items: flex-start;
            padding: 20px;
        }
    }

    .quiz-start-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: var(--gradient-1);
        color: var(--pure-white);
        border-radius: var(--radius-full);
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        transition: var(--transition);
        border: none;
        cursor: pointer;
        box-shadow: var(--shadow-md);
    }

    @media (max-width: 576px) {
        .quiz-start-btn {
            width: 100%;
            justify-content: center;
        }
    }

    .quiz-start-btn:hover {
        background: var(--gradient-2);
        color: var(--prussian-blue);
        transform: translateX(5px);
        box-shadow: var(--shadow-hover);
    }

    .quiz-start-btn i {
        font-size: 0.8rem;
        transition: var(--transition);
    }

    .quiz-start-btn:hover i {
        transform: translateX(5px);
    }

    .quiz-login-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: transparent;
        color: var(--prussian-blue);
        border: 2px solid var(--prussian-blue);
        border-radius: var(--radius-full);
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        transition: var(--transition);
    }

    @media (max-width: 576px) {
        .quiz-login-btn {
            width: 100%;
            justify-content: center;
        }
    }

    .quiz-login-btn:hover {
        background: var(--prussian-blue);
        color: var(--pure-white);
        transform: translateX(5px);
        border-color: var(--bright-amber);
    }

    .quiz-attempts {
        font-size: 0.85rem;
        color: var(--text-muted);
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .quiz-attempts i {
        color: var(--bright-amber);
        font-size: 0.8rem;
    }

    /* ===== EMPTY STATE ===== */
    .quiz-empty-state {
        text-align: center;
        padding: 80px 20px;
        background: var(--pure-white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-lg);
        grid-column: 1 / -1;
        border: 1px solid rgba(251, 198, 12, 0.1);
    }

    @media (max-width: 768px) {
        .quiz-empty-state {
            padding: 60px 20px;
        }
    }

    @media (max-width: 576px) {
        .quiz-empty-state {
            padding: 40px 15px;
        }
    }

    .quiz-empty-icon {
        width: 120px;
        height: 120px;
        background: var(--ivory);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px;
        font-size: 3rem;
        color: var(--bright-amber);
        animation: float 6s ease-in-out infinite;
        position: relative;
        border: 2px solid var(--bright-amber);
    }

    @media (max-width: 576px) {
        .quiz-empty-icon {
            width: 100px;
            height: 100px;
            font-size: 2.5rem;
        }
    }

    .quiz-empty-state h3 {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 10px;
        color: var(--prussian-blue);
    }

    @media (max-width: 576px) {
        .quiz-empty-state h3 {
            font-size: 1.5rem;
        }
    }

    .quiz-empty-state p {
        color: var(--text-muted);
        font-size: 1.1rem;
        margin-bottom: 25px;
    }

    @media (max-width: 576px) {
        .quiz-empty-state p {
            font-size: 1rem;
        }
    }

    .quiz-clear-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 12px 30px;
        background: var(--gradient-1);
        color: var(--pure-white);
        border-radius: var(--radius-full);
        text-decoration: none;
        font-weight: 600;
        transition: var(--transition);
        box-shadow: var(--shadow-md);
        border: none;
    }

    @media (max-width: 576px) {
        .quiz-clear-btn {
            width: 100%;
            justify-content: center;
        }
    }

    .quiz-clear-btn:hover {
        background: var(--gradient-2);
        color: var(--prussian-blue);
        transform: translateY(-3px);
        box-shadow: var(--shadow-hover);
    }

    .quiz-clear-btn i {
        transition: var(--transition);
    }

    .quiz-clear-btn:hover i {
        transform: rotate(180deg);
    }

    /* ===== PAGINATION ===== */
    .quiz-pagination {
        margin-top: 40px;
        display: flex;
        justify-content: center;
    }

    .pagination {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        justify-content: center;
    }

    .page-item {
        list-style: none;
    }

    .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 40px;
        padding: 0 10px;
        background: var(--pure-white);
        border: 2px solid var(--pale-slate);
        border-radius: var(--radius-md);
        color: var(--text-primary);
        text-decoration: none;
        transition: var(--transition);
        font-weight: 600;
    }

    @media (max-width: 576px) {
        .page-link {
            min-width: 36px;
            height: 36px;
            font-size: 0.9rem;
        }
    }

    .page-link:hover {
        background: var(--gradient-2);
        color: var(--prussian-blue);
        border-color: transparent;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .active .page-link {
        background: var(--gradient-1);
        color: var(--pure-white);
        border-color: transparent;
    }

    .disabled .page-link {
        background: var(--ivory);
        color: var(--text-muted);
        pointer-events: none;
        border-color: var(--pale-slate);
        opacity: 0.6;
    }

    /* ===== UTILITY CLASSES ===== */
    .position-relative { position: relative; }
    .overflow-hidden { overflow: hidden; }
    .text-center { text-align: center; }
    
    /* Accordion content hidden by default */
    .accordion-content {
        display: none;
    }

    /* ===== ANIMATION ON SCROLL ===== */
    .quiz-card {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.5s ease, transform 0.5s ease;
    }

    .quiz-card.visible {
        opacity: 1;
        transform: translateY(0);
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="quiz-hero">
    <div class="quiz-hero-particles">
        <div class="quiz-hero-particle"></div>
        <div class="quiz-hero-particle"></div>
        <div class="quiz-hero-particle"></div>
    </div>

    <div class="container">
        <div class="quiz-hero-content" data-aos="fade-up">
            <span class="quiz-hero-badge">{{ App\Helpers\TranslationHelper::trans('quiz.hero_badge') ?? 'Portal 101' }}</span>
            <h1 class="quiz-hero-title">{{ App\Helpers\TranslationHelper::trans('quiz.hero_title') ?? 'Knowledge Portal' }}</h1>
            <div class="quiz-hero-subtitle">
                <i class="fas fa-lightbulb"></i>
                {{ App\Helpers\TranslationHelper::trans('quiz.hero_subtitle') ?? 'Right Knowledge is Light' }}
                <i class="fas fa-lightbulb"></i>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="quiz-main">
    <div class="container">
        <!-- Statistics Section - Hidden in Accordion -->
        <div class="quiz-stats-section">
            <div class="quiz-stats-header" onclick="toggleStatsAccordion()">
                <i class="fas fa-chart-bar"></i>
                <h2>{{ App\Helpers\TranslationHelper::trans('quiz.statistics_title') ?? 'Quiz Statistics' }}</h2>
                <i class="fas fa-chevron-down chevron" id="statsChevron"></i>
            </div>
            <div class="accordion-content" id="statsAccordion">
                <div class="quiz-stats-grid">
                    <div class="quiz-stat-card" data-aos="fade-up">
                        <div class="quiz-stat-icon">
                            <i class="fas fa-puzzle-piece"></i>
                        </div>
                        <div class="quiz-stat-details">
                            <h3>{{ $totalQuizzes ?? 24 }}</h3>
                            <p>{{ App\Helpers\TranslationHelper::trans('quiz.stat_total_quizzes') ?? 'Total Quizzes' }}</p>
                        </div>
                    </div>

                    <div class="quiz-stat-card" data-aos="fade-up" data-aos-delay="100">
                        <div class="quiz-stat-icon">
                            <i class="fas fa-question-circle"></i>
                        </div>
                        <div class="quiz-stat-details">
                            <h3>{{ $totalQuestions ?? 156 }}</h3>
                            <p>{{ App\Helpers\TranslationHelper::trans('quiz.stat_total_questions') ?? 'Total Questions' }}</p>
                        </div>
                    </div>

                    <div class="quiz-stat-card" data-aos="fade-up" data-aos-delay="200">
                        <div class="quiz-stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="quiz-stat-details">
                            <h3>{{ $totalAttempts ?? 1250 }}</h3>
                            <p>{{ App\Helpers\TranslationHelper::trans('quiz.stat_total_attempts') ?? 'Total Attempts' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Filter -->
        <div class="quiz-search-section">
            <form action="{{ route('quiz') }}" method="GET" class="quiz-search-form">
                <div class="quiz-search-wrapper">
                    <input type="text" 
                           name="search" 
                           class="quiz-search-input" 
                           placeholder="{{ App\Helpers\TranslationHelper::trans('quiz.search_placeholder') }}" 
                           value="{{ request('search') }}">
                    
                    <select name="type" class="quiz-type-select">
                        <option value="">{{ App\Helpers\TranslationHelper::trans('quiz.filter_all_types') }}</option>
                        <option value="standalone" {{ request('type') == 'standalone' ? 'selected' : '' }}>{{ App\Helpers\TranslationHelper::trans('quiz.filter_standalone') }}</option>
                        <option value="course" {{ request('type') == 'course' ? 'selected' : '' }}>{{ App\Helpers\TranslationHelper::trans('quiz.filter_course') }}</option>
                        <option value="lesson" {{ request('type') == 'lesson' ? 'selected' : '' }}>{{ App\Helpers\TranslationHelper::trans('quiz.filter_lesson') }}</option>
                    </select>
                    
                    <button class="quiz-search-btn" type="submit">
                        <i class="fas fa-search"></i>
                        <span>{{ App\Helpers\TranslationHelper::trans('quiz.search_button') }}</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Quizzes Grid -->
        <div class="quiz-grid">
            @forelse($quizzes ?? [] as $quiz)
                <div class="quiz-card" data-aos="fade-up" data-aos-delay="{{ min($loop->index * 50, 300) }}">
                    <div class="quiz-card-header">
                        <span class="quiz-type-badge">
                            @if($quiz->type == 'standalone')
                                {{ App\Helpers\TranslationHelper::trans('quiz.filter_standalone') }}
                            @elseif($quiz->type == 'course')
                                {{ App\Helpers\TranslationHelper::trans('quiz.filter_course') }}
                            @elseif($quiz->type == 'lesson')
                                {{ App\Helpers\TranslationHelper::trans('quiz.filter_lesson') }}
                            @else
                                {{ ucfirst($quiz->type) }}
                            @endif
                        </span>
                        <!-- Time limit removed from header -->
                    </div>
                    
                    <div class="quiz-card-body">
                        <h5 class="quiz-title">{{ $quiz->title }}</h5>
                        
                        @if($quiz->description)
                            <p class="quiz-description">{{ Str::limit($quiz->description, 100) }}</p>
                        @endif
                        
                        <!-- Meta items updated - only attempts info remains -->
                        <div class="quiz-meta">
                            <!-- Questions count removed -->
                            <!-- Pass percentage removed -->
                            <div class="quiz-meta-item">
                                <i class="fas fa-redo"></i>
                                <span>
                                    @if($quiz->attempts_allowed == 0)
                                        {{ App\Helpers\TranslationHelper::trans('quiz.attempts_unlimited') }}
                                    @else
                                        {{ App\Helpers\TranslationHelper::trans('quiz.attempts_allowed', ['count' => $quiz->attempts_allowed]) }}
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="quiz-card-footer">
                        @auth
                            <a href="{{ route('quizzes.show', $quiz->slug) }}" class="quiz-start-btn">
                                <span>{{ App\Helpers\TranslationHelper::trans('quiz.btn_start') }}</span> <i class="fas fa-arrow-right"></i>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="quiz-login-btn">
                                <span>{{ App\Helpers\TranslationHelper::trans('quiz.btn_login') }}</span> <i class="fas fa-sign-in-alt"></i>
                            </a>
                        @endauth
                        
                        <span class="quiz-attempts">
                            <i class="fas fa-users"></i>
                            {{ App\Helpers\TranslationHelper::trans('quiz.attempts_count', ['count' => $quiz->total_attempts ?? 0]) }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="quiz-empty-state" data-aos="fade-up">
                    <div class="quiz-empty-icon">
                        <i class="fas fa-puzzle-piece"></i>
                    </div>
                    <h3>{{ App\Helpers\TranslationHelper::trans('quiz.empty_title') }}</h3>
                    <p>{{ App\Helpers\TranslationHelper::trans('quiz.empty_description') }}</p>
                    @if(request('search') || request('type'))
                        <a href="{{ route('quiz') }}" class="quiz-clear-btn">
                            <i class="fas fa-times"></i>
                            <span>{{ App\Helpers\TranslationHelper::trans('quiz.btn_clear') }}</span>
                        </a>
                    @endif
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if(isset($quizzes) && method_exists($quizzes, 'links') && $quizzes->hasPages())
            <div class="quiz-pagination">
                {{ $quizzes->withQueryString()->links() }}
            </div>
        @endif
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check if user prefers reduced motion
        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        
        // Auto-submit filter when type changes
        const typeSelect = document.querySelector('.quiz-type-select');
        if (typeSelect) {
            typeSelect.addEventListener('change', function() {
                this.form.submit();
            });
        }

        // Smooth scroll to quizzes when searching
        const searchForm = document.querySelector('.quiz-search-form');
        if (searchForm) {
            searchForm.addEventListener('submit', function() {
                setTimeout(() => {
                    const firstQuiz = document.querySelector('.quiz-card');
                    if (firstQuiz) {
                        firstQuiz.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }, 100);
            });
        }

        // Live search with debounce
        const searchInput = document.querySelector('.quiz-search-input');
        let debounceTimer;

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    if (this.value.length > 2 || this.value.length === 0) {
                        this.form.submit();
                    }
                }, prefersReducedMotion ? 0 : 500);
            });
        }

        // Animation on scroll for quiz cards
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        // Observe all quiz cards
        document.querySelectorAll('.quiz-card').forEach(el => {
            observer.observe(el);
        });

        // Observe stat cards for animation
        document.querySelectorAll('.quiz-stat-card').forEach(el => {
            observer.observe(el);
        });

        // Animation pause for reduced motion
        if (prefersReducedMotion) {
            const animatedElements = document.querySelectorAll('.quiz-hero-particle, .quiz-empty-icon');
            animatedElements.forEach(element => {
                if (element.style) {
                    element.style.animation = 'none';
                }
            });
        }

        // Touch optimizations for mobile
        if ('ontouchstart' in window) {
            const touchElements = document.querySelectorAll('.quiz-start-btn, .quiz-login-btn, .quiz-clear-btn, .page-link');
            
            touchElements.forEach(element => {
                element.addEventListener('touchstart', function() {
                    this.style.opacity = '0.7';
                }, { passive: true });
                
                element.addEventListener('touchend', function() {
                    this.style.opacity = '1';
                }, { passive: true });
                
                element.addEventListener('touchcancel', function() {
                    this.style.opacity = '1';
                }, { passive: true });
            });
        }

        // Hide stats accordion by default
        const statsAccordion = document.getElementById('statsAccordion');
        if (statsAccordion) {
            statsAccordion.style.display = 'none';
        }
    });

    // Toggle statistics accordion
    function toggleStatsAccordion() {
        const accordion = document.getElementById('statsAccordion');
        const chevron = document.getElementById('statsChevron');
        
        if (accordion) {
            if (accordion.style.display === 'none' || !accordion.style.display) {
                accordion.style.display = 'block';
                if (chevron) {
                    chevron.classList.remove('fa-chevron-down');
                    chevron.classList.add('fa-chevron-up');
                }
            } else {
                accordion.style.display = 'none';
                if (chevron) {
                    chevron.classList.remove('fa-chevron-up');
                    chevron.classList.add('fa-chevron-down');
                }
            }
        }
    }

    // Make function globally available
    window.toggleStatsAccordion = toggleStatsAccordion;
</script>
@endpush