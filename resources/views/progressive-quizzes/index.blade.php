@extends('layouts.main')
@php
    use App\Models\ProgressiveLevelAttempt;
@endphp
@section('title', App\Helpers\TranslationHelper::trans('progressive-quizzes.title'))

@section('meta_description', App\Helpers\TranslationHelper::trans('progressive-quizzes.meta_description'))

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
        --danger: #ef4444;
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
    .progressive-hero {
        position: relative;
        background: var(--gradient-1);
        padding: 80px 0;
        overflow: hidden;
        color: var(--pure-white);
        margin-bottom: 40px;
    }

    @media (max-width: 768px) {
        .progressive-hero {
            padding: 60px 0;
        }
    }

    @media (max-width: 576px) {
        .progressive-hero {
            padding: 50px 0;
        }
    }

    .hero-particles {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    .hero-particle {
        position: absolute;
        background: rgba(251, 198, 12, 0.1);
        border-radius: 50%;
    }

    .hero-particle:nth-child(1) {
        width: 300px;
        height: 300px;
        top: -100px;
        right: -100px;
        animation: float 8s ease-in-out infinite;
    }

    @media (max-width: 768px) {
        .hero-particle:nth-child(1) {
            width: 200px;
            height: 200px;
            top: -50px;
            right: -50px;
        }
    }

    .hero-particle:nth-child(2) {
        width: 200px;
        height: 200px;
        bottom: -50px;
        left: -50px;
        background: rgba(90, 209, 228, 0.1);
        animation: float 10s ease-in-out infinite reverse;
    }

    @media (max-width: 768px) {
        .hero-particle:nth-child(2) {
            width: 150px;
            height: 150px;
            bottom: -30px;
            left: -30px;
        }
    }

    .hero-particle:nth-child(3) {
        width: 150px;
        height: 150px;
        top: 30%;
        left: 20%;
        background: rgba(235, 215, 137, 0.1);
        animation: float 12s ease-in-out infinite;
    }

    @media (max-width: 768px) {
        .hero-particle:nth-child(3) {
            width: 100px;
            height: 100px;
        }
    }

    .hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
        max-width: 800px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .hero-badge {
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
        .hero-badge {
            font-size: 0.8rem;
            padding: 6px 16px;
        }
    }

    .hero-title {
        font-size: clamp(1.8rem, 6vw, 3rem);
        font-weight: 800;
        margin-bottom: 15px;
        line-height: 1.2;
        color: var(--pure-white);
    }

    .hero-title span {
        color: var(--bright-amber);
    }

    .hero-subtitle {
        font-size: clamp(1rem, 3vw, 1.5rem);
        opacity: 0.95;
        margin-bottom: 30px;
        color: var(--ivory);
        font-weight: 500;
        letter-spacing: 1px;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    .hero-subtitle i {
        color: var(--bright-amber);
        margin: 0 10px;
        font-size: 0.9em;
    }

    /* ===== STATISTICS CARDS - HIDDEN IN ACCORDION ===== */
    .stats-section {
        margin-bottom: 40px;
    }

    .stats-header {
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

    .stats-header:hover {
        border-color: var(--bright-amber);
        box-shadow: var(--shadow-hover);
    }

    .stats-header i {
        color: var(--bright-amber);
        font-size: 1.5rem;
    }

    .stats-header h2 {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
        flex: 1;
    }

    .stats-header .chevron {
        color: var(--bright-amber);
        transition: transform 0.3s ease;
    }

    .stats-header .chevron.rotated {
        transform: rotate(180deg);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
        margin-top: 20px;
    }

    @media (max-width: 992px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
    }

    .stat-card {
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

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-hover);
        border-color: var(--bright-amber);
    }

    .stat-card::before {
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

    .stat-card:hover::before {
        opacity: 0.2;
    }

    .stat-icon {
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
        .stat-icon {
            width: 60px;
            height: 60px;
        }
    }

    .stat-icon i {
        font-size: 28px;
        color: var(--pure-white);
    }

    @media (max-width: 768px) {
        .stat-icon i {
            font-size: 24px;
        }
    }

    .stat-content {
        flex: 1;
    }

    .stat-value {
        font-size: 2rem !important;
        font-weight: 700 !important;
        color: var(--prussian-blue) !important;
        margin: 0 0 5px 0 !important;
        line-height: 1.2 !important;
    }

    @media (max-width: 768px) {
        .stat-value {
            font-size: 1.8rem !important;
        }
    }

    .stat-label {
        margin: 0 !important;
        color: var(--text-muted) !important;
        font-size: 0.95rem !important;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* ===== SEARCH SECTION ===== */
    .search-section {
        margin-bottom: 40px;
    }

    .search-form {
        max-width: 700px;
        margin: 0 auto;
        position: relative;
    }

    .search-wrapper {
        display: flex;
        background: var(--pure-white);
        border-radius: var(--radius-full);
        box-shadow: var(--shadow-lg);
        overflow: hidden;
        border: 2px solid transparent;
        transition: var(--transition);
        border: 1px solid rgba(251, 198, 12, 0.1);
    }

    .search-wrapper:focus-within {
        border-color: var(--bright-amber);
        box-shadow: var(--shadow-hover);
    }

    .search-input {
        flex: 1;
        padding: 16px 25px;
        border: none;
        font-size: 1rem;
        outline: none;
        background: transparent;
        color: var(--text-primary);
    }

    @media (max-width: 768px) {
        .search-input {
            padding: 14px 20px;
        }
    }

    .search-input::placeholder {
        color: var(--text-muted);
        opacity: 0.7;
    }

    .search-btn {
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
        .search-btn {
            padding: 0 20px;
        }
    }

    .search-btn:hover {
        background: var(--gradient-2);
        color: var(--prussian-blue);
    }

    /* ===== QUIZZES GRID ===== */
    .quizzes-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
        margin-bottom: 40px;
    }

    @media (max-width: 1200px) {
        .quizzes-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .quizzes-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
    }

    /* ===== QUIZ CARD ===== */
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

    .quiz-image {
        height: 160px;
        background: var(--gradient-1);
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .quiz-image::after {
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

    .quiz-image i {
        font-size: 4rem;
        color: rgba(255, 255, 255, 0.2);
        z-index: 2;
    }

    .quiz-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: 1;
    }

    .quiz-level-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(255, 255, 255, 0.2);
        color: var(--pure-white);
        padding: 6px 15px;
        border-radius: var(--radius-full);
        font-size: 0.8rem;
        font-weight: 700;
        backdrop-filter: blur(5px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        z-index: 3;
    }

    .quiz-body {
        padding: 25px;
        flex: 1;
    }

    @media (max-width: 768px) {
        .quiz-body {
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

    .quiz-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 15px;
    }

    .meta-item {
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

    .meta-item i {
        color: var(--bright-amber);
        width: 16px;
        font-size: 0.9rem;
    }

    @media (max-width: 576px) {
        .quiz-meta {
            flex-direction: column;
            gap: 10px;
        }
        
        .meta-item {
            width: 100%;
        }
    }

    .quiz-progress {
        margin-top: 15px;
    }

    .progress-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 5px;
        font-size: 0.85rem;
        color: var(--text-muted);
    }

    .progress-bar {
        height: 6px;
        background: var(--pale-slate);
        border-radius: var(--radius-full);
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: var(--gradient-2);
        border-radius: var(--radius-full);
        transition: width 0.3s ease;
    }

    .quiz-footer {
        padding: 20px 25px;
        background: var(--ivory);
        border-top: 1px solid rgba(251, 198, 12, 0.2);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    @media (max-width: 576px) {
        .quiz-footer {
            flex-direction: column;
            gap: 15px;
            align-items: flex-start;
            padding: 20px;
        }
    }

    .btn-start {
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
        .btn-start {
            width: 100%;
            justify-content: center;
        }
    }

    .btn-start:hover {
        background: var(--gradient-2);
        color: var(--prussian-blue);
        transform: translateX(5px);
        box-shadow: var(--shadow-hover);
    }

    .btn-start i {
        font-size: 0.8rem;
        transition: var(--transition);
    }

    .btn-start:hover i {
        transform: translateX(5px);
    }

    .btn-login {
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
        .btn-login {
            width: 100%;
            justify-content: center;
        }
    }

    .btn-login:hover {
        background: var(--prussian-blue);
        color: var(--pure-white);
        transform: translateX(5px);
        border-color: var(--bright-amber);
    }

    .attempts-info {
        font-size: 0.85rem;
        color: var(--text-muted);
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .attempts-info i {
        color: var(--bright-amber);
        font-size: 0.8rem;
    }

    /* ===== EMPTY STATE ===== */
    .empty-state {
        text-align: center;
        padding: 80px 20px;
        background: var(--pure-white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-lg);
        grid-column: 1 / -1;
        border: 1px solid rgba(251, 198, 12, 0.1);
    }

    @media (max-width: 768px) {
        .empty-state {
            padding: 60px 20px;
        }
    }

    @media (max-width: 576px) {
        .empty-state {
            padding: 40px 15px;
        }
    }

    .empty-icon {
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
        .empty-icon {
            width: 100px;
            height: 100px;
            font-size: 2.5rem;
        }
    }

    .empty-state h3 {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 10px;
        color: var(--prussian-blue);
    }

    @media (max-width: 576px) {
        .empty-state h3 {
            font-size: 1.5rem;
        }
    }

    .empty-state p {
        color: var(--text-muted);
        font-size: 1.1rem;
        margin-bottom: 25px;
    }

    @media (max-width: 576px) {
        .empty-state p {
            font-size: 1rem;
        }
    }

    .btn-clear {
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
        .btn-clear {
            width: 100%;
            justify-content: center;
        }
    }

    .btn-clear:hover {
        background: var(--gradient-2);
        color: var(--prussian-blue);
        transform: translateY(-3px);
        box-shadow: var(--shadow-hover);
    }

    .btn-clear i {
        transition: var(--transition);
    }

    .btn-clear:hover i {
        transform: rotate(180deg);
    }

    /* ===== PAGINATION ===== */
    .pagination-wrapper {
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
    .quiz-card, .stat-card {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.5s ease, transform 0.5s ease;
    }

    .quiz-card.visible, .stat-card.visible {
        opacity: 1;
        transform: translateY(0);
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="progressive-hero">
    <div class="hero-particles">
        <div class="hero-particle"></div>
        <div class="hero-particle"></div>
        <div class="hero-particle"></div>
    </div>

    <div class="container">
        <div class="quiz-hero-content text-center" data-aos="fade-up">
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
<section class="progressive-main">
    <div class="container">
        <!-- Statistics Section - Hidden in Accordion -->
        <div class="stats-section">
            <div class="stats-header" onclick="toggleStatsAccordion()">
                <i class="fas fa-chart-bar"></i>
                <h2>{{ App\Helpers\TranslationHelper::trans('quiz.statistics_title') ?? 'Quiz Statistics' }}</h2>
                <i class="fas fa-chevron-down chevron" id="statsChevron"></i>
            </div>
            <div class="accordion-content" id="statsAccordion">
                <div class="stats-grid">
                    <div class="stat-card" data-aos="fade-up">
                        <div class="stat-icon">
                            <i class="fas fa-layer-group"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-value">{{ $totalQuizzes ?? 0 }}</div>
                            <div class="stat-label">{{ App\Helpers\TranslationHelper::trans('progressive-quizzes.total_quizzes') ?? 'Total Quizzes' }}</div>
                        </div>
                    </div>

                    <div class="stat-card" data-aos="fade-up" data-aos-delay="100">
                        <div class="stat-icon">
                            <i class="fas fa-stairs"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-value">{{ $totalLevels ?? 0 }}</div>
                            <div class="stat-label">{{ App\Helpers\TranslationHelper::trans('progressive-quizzes.total_levels') ?? 'Total Levels' }}</div>
                        </div>
                    </div>

                    <div class="stat-card" data-aos="fade-up" data-aos-delay="200">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-value">{{ $totalAttempts ?? 0 }}</div>
                            <div class="stat-label">{{ App\Helpers\TranslationHelper::trans('progressive-quizzes.total_attempts') ?? 'Total Attempts' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search Section -->
        <div class="search-section">
            <form action="{{ route('progressive-quizzes.index') }}" method="GET" class="search-form">
                <div class="search-wrapper">
                    <input type="text" 
                           name="search" 
                           class="search-input" 
                           placeholder="{{ App\Helpers\TranslationHelper::trans('progressive-quizzes.search_placeholder') ?? 'Search progressive quizzes...' }}" 
                           value="{{ request('search') }}"
                           aria-label="{{ App\Helpers\TranslationHelper::trans('progressive-quizzes.aria_label_search') }}">
                    
                    <button class="search-btn" type="submit">
                        <i class="fas fa-search"></i>
                        <span>{{ App\Helpers\TranslationHelper::trans('progressive-quizzes.search_button') ?? 'Search' }}</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Quizzes Grid -->
        <div class="quizzes-grid">
            @forelse($quizzes as $quiz)
                @php
                    $user = Auth::user();
                    $progress = 0;
                    $currentLevel = null;
                    $completedLevels = 0;
                    
                    if ($user) {
                        $attempt = $quiz->getUserAttempt($user->id);
                        if ($attempt) {
                            $completedLevels = $attempt->levelAttempts()
                                ->where('status', ProgressiveLevelAttempt::STATUS_COMPLETED)
                                ->count();
                            $progress = $quiz->total_levels > 0 ? round(($completedLevels / $quiz->total_levels) * 100) : 0;
                            $currentLevel = $attempt->current_level_number;
                        }
                    }
                @endphp

                <div class="quiz-card" data-aos="fade-up" data-aos-delay="{{ min($loop->index * 50, 300) }}" aria-label="{{ App\Helpers\TranslationHelper::trans('progressive-quizzes.aria_label_quiz_card') }}">
                    <div class="quiz-image">
                        @if($quiz->featured_image)
                            <img src="{{ $quiz->featured_image_url }}" alt="{{ $quiz->title }}">
                        @else
                            <i class="fas fa-layer-group"></i>
                        @endif
                        <span class="quiz-level-badge">{{ $quiz->total_levels }} {{ Str::plural(App\Helpers\TranslationHelper::trans('progressive-quizzes.level') ?? 'Level', $quiz->total_levels) }}</span>
                    </div>
                    
                    <div class="quiz-body">
                        <h3 class="quiz-title">{{ $quiz->title }}</h3>
                        
                        @if($quiz->description)
                            <p class="quiz-description">{{ Str::limit($quiz->description, 100) }}</p>
                        @endif
                        
                        <div class="quiz-meta">
                            <div class="meta-item">
                                <i class="fas fa-question-circle"></i>
                                <span>{{ $quiz->total_questions }} {{ Str::plural(App\Helpers\TranslationHelper::trans('progressive-quizzes.question') ?? 'Question', $quiz->total_questions) }}</span>
                            </div>
                            
                            <!-- <div class="meta-item">
                                <i class="fas fa-clock"></i>
                                <span>{{ $quiz->time_limit_formatted }}</span>
                            </div> -->
                            
                            <!-- <div class="meta-item">
                                <i class="fas fa-percent"></i>
                                <span>{{ $quiz->pass_percentage }}% {{ App\Helpers\TranslationHelper::trans('progressive-quizzes.pass_percentage') ?? 'Pass' }}</span>
                            </div> -->
                        </div>

                        @if($user && $attempt)
                            <div class="quiz-progress" aria-label="{{ App\Helpers\TranslationHelper::trans('progressive-quizzes.aria_label_progress') }}">
                                <div class="progress-header">
                                    <span>{{ App\Helpers\TranslationHelper::trans('progressive-quizzes.progress') ?? 'Progress' }}</span>
                                    <span>{{ $progress }}%</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: {{ $progress }}%;"></div>
                                </div>
                                @if($currentLevel)
                                    <small class="text-muted mt-1 d-block">{{ App\Helpers\TranslationHelper::trans('progressive-quizzes.current_level') ?? 'Current Level' }}: {{ $currentLevel }}</small>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="quiz-footer">
                        @auth
                            @php
                                $canAttempt = $quiz->canAttempt($user->id);
                                $attempt = $quiz->getUserAttempt($user->id);
                            @endphp

                            @if($attempt && $attempt->status !== 'completed')
                                <a href="{{ route('progressive-quizzes.continue', $quiz) }}" class="btn-start">
                                    <i class="fas fa-play-circle"></i>
                                    <span>{{ App\Helpers\TranslationHelper::trans('progressive-quizzes.btn_continue') ?? 'Continue' }}</span>
                                </a>
                            @elseif($canAttempt)
                                <form action="{{ route('progressive-quizzes.start', $quiz) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-start">
                                        <i class="fas fa-play"></i>
                                        <span>{{ App\Helpers\TranslationHelper::trans('progressive-quizzes.btn_start') ?? 'Start' }}</span>
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('progressive-quizzes.show', $quiz->slug) }}" class="btn-start" style="opacity: 0.6; pointer-events: none;" aria-disabled="true">
                                    <i class="fas fa-lock"></i>
                                    <span>{{ App\Helpers\TranslationHelper::trans('progressive-quizzes.btn_max_attempts') ?? 'Max Attempts Reached' }}</span>
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn-login">
                                <i class="fas fa-sign-in-alt"></i>
                                <span>{{ App\Helpers\TranslationHelper::trans('progressive-quizzes.btn_login') ?? 'Login to Start' }}</span>
                            </a>
                        @endauth
                        
                        <span class="attempts-info">
                            <i class="fas fa-redo"></i>
                            @if($quiz->attempts_allowed == 0)
                                {{ App\Helpers\TranslationHelper::trans('progressive-quizzes.unlimited_attempts') ?? 'Unlimited Attempts' }}
                            @else
                                {{ $quiz->attempts_allowed }} {{ Str::plural(App\Helpers\TranslationHelper::trans('progressive-quizzes.attempt') ?? 'Attempt', $quiz->attempts_allowed) }}
                            @endif
                        </span>
                    </div>
                </div>
            @empty
                <div class="empty-state" data-aos="fade-up">
                    <div class="empty-icon">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    @if(request('search'))
                        <h3>{{ App\Helpers\TranslationHelper::trans('progressive-quizzes.empty_search_title') ?? 'No Results Found' }}</h3>
                        <p>{{ App\Helpers\TranslationHelper::trans('progressive-quizzes.empty_search_description') ?? 'Try adjusting your search criteria' }}</p>
                        <a href="{{ route('progressive-quizzes.index') }}" class="btn-clear">
                            <i class="fas fa-times"></i>
                            <span>{{ App\Helpers\TranslationHelper::trans('progressive-quizzes.btn_clear') ?? 'Clear Search' }}</span>
                        </a>
                    @else
                        <h3>{{ App\Helpers\TranslationHelper::trans('progressive-quizzes.empty_title') ?? 'No Quizzes Available' }}</h3>
                        <p>{{ App\Helpers\TranslationHelper::trans('progressive-quizzes.empty_description') ?? 'Check back later for new progressive quizzes' }}</p>
                    @endif
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($quizzes instanceof \Illuminate\Pagination\LengthAwarePaginator && $quizzes->hasPages())
            <div class="pagination-wrapper" aria-label="{{ App\Helpers\TranslationHelper::trans('progressive-quizzes.aria_label_pagination') }}">
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
        
        // Auto-submit search with debounce
        const searchInput = document.querySelector('.search-input');
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

        // Smooth scroll to quizzes when searching
        const searchForm = document.querySelector('.search-form');
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

        // Animation on scroll for quiz cards and stat cards
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

        // Observe all quiz cards and stat cards
        document.querySelectorAll('.quiz-card, .stat-card').forEach(el => {
            observer.observe(el);
        });

        // Animation pause for reduced motion
        if (prefersReducedMotion) {
            const animatedElements = document.querySelectorAll('.hero-particle, .empty-icon');
            animatedElements.forEach(element => {
                if (element.style) {
                    element.style.animation = 'none';
                }
            });
        }

        // Touch optimizations for mobile
        if ('ontouchstart' in window) {
            const touchElements = document.querySelectorAll('.btn-start, .btn-login, .btn-clear, .page-link, .stats-header');
            
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