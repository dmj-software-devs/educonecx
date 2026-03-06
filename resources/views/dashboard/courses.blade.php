@extends('layouts.main')

@section('title', App\Helpers\TranslationHelper::trans('my-courses.title'))

@section('meta_description', App\Helpers\TranslationHelper::trans('my-courses.meta_description'))

@push('styles')
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
        
        /* Gradients */
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
    }

    /* Main layout adjustments */
    body {
        background: linear-gradient(135deg, var(--ivory) 0%, var(--pure-white) 100%);
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    main {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    /* ===== COURSES LAYOUT ===== */
    .courses-wrapper {
        flex: 1;
        display: flex;
        width: 100%;
        max-width: 1400px;
        margin: 0 auto;
        padding: 30px;
        gap: 30px;
    }

    /* ===== SIDEBAR STYLES ===== */
    .courses-sidebar {
        width: 280px;
        background: var(--pure-white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-lg);
        overflow: hidden;
        height: fit-content;
        border: 1px solid rgba(251, 198, 12, 0.1);
        transition: var(--transition);
    }

    .courses-sidebar::-webkit-scrollbar {
        width: 5px;
    }

    .courses-sidebar::-webkit-scrollbar-track {
        background: var(--pale-slate);
    }

    .courses-sidebar::-webkit-scrollbar-thumb {
        background: var(--bright-amber);
        border-radius: var(--radius-full);
    }

    /* Sidebar Header */
    .sidebar-header {
        padding: 20px;
        background: var(--ivory);
        border-bottom: 1px solid rgba(251, 198, 12, 0.1);
    }

    .sidebar-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .sidebar-title i {
        width: 32px;
        height: 32px;
        background: var(--gradient-1);
        color: var(--pure-white);
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        box-shadow: var(--shadow-sm);
    }

    /* Navigation Menu */
    .sidebar-nav {
        padding: 15px;
    }

    .nav-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 15px;
        border-radius: var(--radius-md);
        color: var(--text-muted);
        text-decoration: none;
        transition: var(--transition);
        margin-bottom: 5px;
        position: relative;
        overflow: hidden;
        border: 1px solid transparent;
    }

    .nav-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 3px;
        background: var(--gradient-2);
        transform: scaleY(0);
        transition: transform 0.3s ease;
    }

    .nav-item:hover::before {
        transform: scaleY(1);
    }

    .nav-item i {
        width: 20px;
        font-size: 1.1rem;
        text-align: center;
        transition: var(--transition);
    }

    .nav-item:hover {
        background: linear-gradient(145deg, var(--ivory), var(--pure-white));
        color: var(--bright-amber);
        transform: translateX(5px);
        border-color: rgba(251, 198, 12, 0.2);
    }

    .nav-item.active {
        background: var(--gradient-1);
        color: var(--pure-white);
        box-shadow: var(--shadow-md);
    }

    .nav-item.active::before {
        display: none;
    }

    .nav-item.active i {
        color: var(--pure-white);
    }

    .nav-item span {
        flex: 1;
        font-weight: 500;
        font-size: 0.95rem;
    }

    .nav-badge {
        background: rgba(251, 198, 12, 0.1);
        padding: 2px 8px;
        border-radius: var(--radius-full);
        font-size: 0.7rem;
        font-weight: 600;
        color: var(--bright-amber);
    }

    .nav-item.active .nav-badge {
        background: rgba(255,255,255,0.2);
        color: var(--pure-white);
    }

    /* Quick Stats */
    .quick-stats {
        padding: 20px;
        border-top: 1px solid rgba(251, 198, 12, 0.1);
    }

    .stat-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px dashed rgba(251, 198, 12, 0.1);
    }

    .stat-row:last-child {
        border-bottom: none;
    }

    .stat-label {
        color: var(--text-muted);
        font-size: 0.9rem;
    }

    .stat-value {
        font-weight: 700;
        color: var(--text-primary);
        font-size: 1rem;
    }

    .stat-value.success {
        color: var(--sky-blue);
    }

    .stat-value.primary {
        color: var(--bright-amber);
    }

    /* Main Content Area */
    .courses-main {
        flex: 1;
        min-width: 0;
    }

    /* Page Header */
    .page-header {
        margin-bottom: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 800;
        color: var(--text-primary);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .page-title i {
        width: 50px;
        height: 50px;
        background: var(--gradient-1);
        color: var(--pure-white);
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        box-shadow: var(--shadow-md);
    }

    .page-actions {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }

    .search-box {
        position: relative;
        min-width: 300px;
    }

    .search-input {
        width: 100%;
        padding: 12px 20px 12px 45px;
        border: 2px solid var(--pale-slate);
        border-radius: var(--radius-full);
        font-size: 0.95rem;
        transition: var(--transition);
        background: var(--pure-white);
        color: var(--text-primary);
    }

    .search-input:focus {
        outline: none;
        border-color: var(--bright-amber);
        box-shadow: 0 0 0 4px rgba(251, 198, 12, 0.1);
    }

    .search-input::placeholder {
        color: var(--khaki-beige);
    }

    .search-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--khaki-beige);
        font-size: 1rem;
    }

    .filter-btn {
        padding: 12px 25px;
        background: var(--pure-white);
        border: 2px solid var(--pale-slate);
        border-radius: var(--radius-full);
        color: var(--text-primary);
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        transition: var(--transition);
    }

    .filter-btn:hover {
        border-color: var(--bright-amber);
        color: var(--bright-amber);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .filter-btn i {
        transition: var(--transition);
    }

    .filter-btn:hover i {
        transform: rotate(90deg);
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 25px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: var(--pure-white);
        border-radius: var(--radius-lg);
        padding: 25px;
        box-shadow: var(--shadow-md);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(251, 198, 12, 0.1);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--stat-gradient, var(--gradient-1));
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    .stat-card:hover::before {
        transform: scaleX(1);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-hover);
        border-color: var(--bright-amber);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: var(--radius-md);
        background: var(--stat-gradient, var(--gradient-1));
        color: var(--pure-white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 15px;
        box-shadow: var(--shadow-md);
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 800;
        color: var(--text-primary);
        margin-bottom: 5px;
        line-height: 1;
    }

    .stat-label {
        color: var(--text-muted);
        font-size: 0.9rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Filter Section */
    .filter-section {
        margin-bottom: 30px;
        background: var(--pure-white);
        border-radius: var(--radius-lg);
        padding: 25px;
        box-shadow: var(--shadow-md);
        border: 1px solid rgba(251, 198, 12, 0.1);
        animation: slideInDown 0.3s ease;
    }

    .filter-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }

    .filter-select {
        padding: 12px 15px;
        border: 2px solid var(--pale-slate);
        border-radius: var(--radius-md);
        font-size: 0.95rem;
        color: var(--text-primary);
        background: var(--pure-white);
        cursor: pointer;
        transition: var(--transition);
    }

    .filter-select:focus {
        outline: none;
        border-color: var(--bright-amber);
        box-shadow: 0 0 0 4px rgba(251, 198, 12, 0.1);
    }

    /* Course Grid */
    .course-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
        margin-bottom: 30px;
    }

    .course-card {
        background: var(--pure-white);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-md);
        transition: var(--transition);
        border: 1px solid rgba(251, 198, 12, 0.1);
        display: flex;
        flex-direction: column;
        height: 100%;
        position: relative;
    }

    .course-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-hover);
        border-color: var(--bright-amber);
    }

    .course-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        z-index: 2;
        padding: 6px 15px;
        border-radius: var(--radius-full);
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        box-shadow: var(--shadow-md);
    }

    .course-badge.completed {
        background: var(--gradient-3);
        color: var(--prussian-blue);
    }

    .course-badge.in-progress {
        background: var(--gradient-1);
        color: var(--pure-white);
    }

    .course-badge.not-started {
        background: var(--gradient-2);
        color: var(--prussian-blue);
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
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .course-card:hover .course-image img {
        transform: scale(1.1);
    }

    .course-content {
        padding: 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .course-meta {
        display: flex;
        gap: 15px;
        margin-bottom: 10px;
        color: var(--text-muted);
        font-size: 0.85rem;
        flex-wrap: wrap;
    }

    .course-meta span {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .course-meta i {
        color: var(--bright-amber);
        font-size: 0.9rem;
    }

    .course-title {
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 15px;
        line-height: 1.4;
    }

    .course-title a {
        color: var(--text-primary);
        text-decoration: none;
        transition: var(--transition);
    }

    .course-title a:hover {
        color: var(--bright-amber);
    }

    .course-progress {
        margin-top: auto;
    }

    .progress-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
        font-size: 0.9rem;
    }

    .progress-label {
        color: var(--text-muted);
    }

    .progress-percent {
        font-weight: 700;
        color: var(--bright-amber);
    }

    .progress-percent.completed {
        color: var(--sky-blue);
    }

    .progress-bar-track {
        height: 8px;
        background: var(--pale-slate);
        border-radius: var(--radius-full);
        overflow: hidden;
        margin-bottom: 15px;
    }

    .progress-bar-fill {
        height: 100%;
        background: var(--gradient-1);
        border-radius: var(--radius-full);
        transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .progress-bar-fill::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, transparent, rgba(251, 198, 12, 0.3), transparent);
        animation: shimmer 2s infinite;
    }

    .progress-bar-fill.completed {
        background: var(--gradient-3);
    }

    .course-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .continue-btn {
        padding: 10px 25px;
        background: var(--gradient-1);
        color: var(--pure-white);
        border-radius: var(--radius-full);
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 600;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: var(--shadow-sm);
        border: none;
        cursor: pointer;
    }

    .continue-btn:hover {
        background: var(--gradient-2);
        color: var(--prussian-blue);
        transform: translateX(5px);
        box-shadow: var(--shadow-hover);
    }

    .certificate-btn {
        padding: 8px 20px;
        background: transparent;
        color: var(--sky-blue);
        border: 2px solid var(--sky-blue);
        border-radius: var(--radius-full);
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 600;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .certificate-btn:hover {
        background: var(--gradient-3);
        color: var(--prussian-blue);
        border-color: transparent;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .last-activity {
        color: var(--text-muted);
        font-size: 0.8rem;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .last-activity i {
        color: var(--bright-amber);
        font-size: 0.75rem;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 30px;
        background: var(--pure-white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        border: 1px solid rgba(251, 198, 12, 0.1);
    }

    .empty-icon {
        width: 100px;
        height: 100px;
        background: var(--ivory);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px;
        font-size: 3rem;
        color: var(--bright-amber);
        animation: float 6s ease-in-out infinite;
        border: 2px solid var(--bright-amber);
    }

    .empty-title {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--text-primary);
        margin-bottom: 10px;
    }

    .empty-text {
        color: var(--text-muted);
        margin-bottom: 25px;
        font-size: 1.1rem;
        max-width: 400px;
        margin-left: auto;
        margin-right: auto;
    }

    .empty-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 15px 35px;
        background: var(--gradient-1);
        color: var(--pure-white);
        border-radius: var(--radius-full);
        text-decoration: none;
        font-weight: 700;
        transition: var(--transition);
        box-shadow: var(--shadow-md);
        border: none;
        cursor: pointer;
    }

    .empty-btn:hover {
        background: var(--gradient-2);
        color: var(--prussian-blue);
        transform: translateY(-3px);
        box-shadow: var(--shadow-hover);
    }

    .empty-btn i {
        transition: var(--transition);
    }

    .empty-btn:hover i {
        transform: translateX(5px);
    }

    /* Pagination */
    .pagination {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-top: 30px;
        flex-wrap: wrap;
    }

    .pagination .page-item {
        list-style: none;
    }

    .pagination .page-link {
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

    .pagination .page-link:hover {
        background: var(--gradient-1);
        color: var(--pure-white);
        border-color: transparent;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .pagination .page-item.active .page-link {
        background: var(--gradient-1);
        color: var(--pure-white);
        border-color: transparent;
    }

    .pagination .page-item.disabled .page-link {
        background: var(--ivory);
        color: var(--text-muted);
        pointer-events: none;
        border-color: var(--pale-slate);
        opacity: 0.6;
    }

    /* Animations */
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }

    @keyframes shimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }

    @keyframes slideInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Ripple Effect */
    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
        transform: scale(0);
        animation: ripple-animation 0.6s linear;
        pointer-events: none;
    }

    @keyframes ripple-animation {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
        .courses-wrapper {
            padding: 20px;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 992px) {
        .courses-wrapper {
            flex-direction: column;
            padding: 20px;
        }
        
        .courses-sidebar {
            width: 100%;
            margin-bottom: 20px;
        }
        
        .page-title {
            font-size: 1.8rem;
        }

        .search-box {
            min-width: 250px;
        }
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .course-grid {
            grid-template-columns: 1fr;
        }
        
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .page-actions {
            width: 100%;
        }
        
        .search-box {
            width: 100%;
            min-width: auto;
        }
        
        .filter-grid {
            grid-template-columns: 1fr;
        }
        
        .course-footer {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .continue-btn, .certificate-btn {
            width: 100%;
            justify-content: center;
        }

        .empty-icon {
            width: 80px;
            height: 80px;
            font-size: 2.5rem;
        }

        .empty-title {
            font-size: 1.5rem;
        }

        .empty-text {
            font-size: 1rem;
        }
    }

    @media (max-width: 576px) {
        .courses-wrapper {
            padding: 15px;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .page-title i {
            width: 40px;
            height: 40px;
            font-size: 1.2rem;
        }

        .stat-card {
            padding: 20px;
        }

        .stat-value {
            font-size: 1.8rem;
        }

        .sidebar-header {
            padding: 15px;
        }

        .sidebar-title {
            font-size: 1.1rem;
        }

        .nav-item {
            padding: 10px 12px;
            font-size: 0.9rem;
        }

        .quick-stats {
            padding: 15px;
        }

        .filter-btn {
            padding: 10px 20px;
            font-size: 0.9rem;
        }

        .course-content {
            padding: 15px;
        }

        .course-title {
            font-size: 1.1rem;
        }

        .pagination .page-link {
            min-width: 35px;
            height: 35px;
            font-size: 0.9rem;
        }
    }

    /* Utility Classes */
    .position-relative {
        position: relative;
    }
    
    .overflow-hidden {
        overflow: hidden;
    }
    
    .text-center {
        text-align: center;
    }
</style>
@endpush

@section('content')
<div class="courses-wrapper">
    <!-- Sidebar -->
    <aside class="courses-sidebar">
        <div class="sidebar-header">
            <h3 class="sidebar-title">
                <i class="fas fa-user"></i>
                {{ App\Helpers\TranslationHelper::trans('my-courses.sidebar_title') }}
            </h3>
        </div>

        <div class="sidebar-nav">
            <a href="{{ route('dashboard') }}" class="nav-item">
                <i class="fas fa-home"></i>
                <span>{{ App\Helpers\TranslationHelper::trans('my-courses.nav_dashboard') }}</span>
            </a>
            <a href="{{ route('my-courses') }}" class="nav-item active">
                <i class="fas fa-book"></i>
                <span>{{ App\Helpers\TranslationHelper::trans('my-courses.nav_my_courses') }}</span>
                @if(($enrollments->total() ?? 0) > 0)
                    <span class="nav-badge">{{ $enrollments->total() }}</span>
                @endif
            </a>
            <a href="{{ route('my-quizzes') }}" class="nav-item">
                <i class="fas fa-question-circle"></i>
                <span>{{ App\Helpers\TranslationHelper::trans('my-courses.nav_my_quizzes') }}</span>
            </a>
            <a href="{{ route('certificates') }}" class="nav-item">
                <i class="fas fa-certificate"></i>
                <span>{{ App\Helpers\TranslationHelper::trans('my-courses.nav_certificates') }}</span>
            </a>
        </div>

        <!-- Quick Stats -->
        <div class="sidebar-header" style="border-radius: 0; border-top: 1px solid rgba(251, 198, 12, 0.1); border-bottom: none;">
            <h3 class="sidebar-title">
                <i class="fas fa-chart-line"></i>
                {{ App\Helpers\TranslationHelper::trans('my-courses.quick_stats_title') }}
            </h3>
        </div>
        <div class="quick-stats">
            <div class="stat-row">
                <span class="stat-label">{{ App\Helpers\TranslationHelper::trans('my-courses.stat_total_courses') }}</span>
                <span class="stat-value">{{ $enrollments->total() ?? 0 }}</span>
            </div>
            <div class="stat-row">
                <span class="stat-label">{{ App\Helpers\TranslationHelper::trans('my-courses.stat_completed') }}</span>
                <span class="stat-value success">{{ $completedCount ?? 0 }}</span>
            </div>
            <div class="stat-row">
                <span class="stat-label">{{ App\Helpers\TranslationHelper::trans('my-courses.stat_in_progress') }}</span>
                <span class="stat-value primary">{{ $inProgressCount ?? 0 }}</span>
            </div>
            <div class="stat-row">
                <span class="stat-label">{{ App\Helpers\TranslationHelper::trans('my-courses.stat_average_progress') }}</span>
                <span class="stat-value">{{ $averageProgress ?? 0 }}%</span>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="courses-main">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-book-open"></i>
                {{ App\Helpers\TranslationHelper::trans('my-courses.page_title') }}
            </h1>
            
            <div class="page-actions">
                <div class="search-box">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="search-input" placeholder="{{ App\Helpers\TranslationHelper::trans('my-courses.search_placeholder') }}" id="searchCourses">
                </div>
                <button class="filter-btn" id="filterToggle">
                    <i class="fas fa-filter"></i>
                    {{ App\Helpers\TranslationHelper::trans('my-courses.filter_button') }}
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card" style="--stat-gradient: linear-gradient(135deg, #0A1D44, #18386E);">
                <div class="stat-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <div class="stat-value">{{ $enrollments->total() ?? 0 }}</div>
                <div class="stat-label">{{ App\Helpers\TranslationHelper::trans('my-courses.stats_total') }}</div>
            </div>

            <div class="stat-card" style="--stat-gradient: linear-gradient(135deg, #5AD1E4, #2E5C61);">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-value">{{ $completedCount ?? 0 }}</div>
                <div class="stat-label">{{ App\Helpers\TranslationHelper::trans('my-courses.stats_completed') }}</div>
            </div>

            <div class="stat-card" style="--stat-gradient: linear-gradient(135deg, #FBC60C, #EBD789);">
                <div class="stat-icon">
                    <i class="fas fa-spinner"></i>
                </div>
                <div class="stat-value">{{ $inProgressCount ?? 0 }}</div>
                <div class="stat-label">{{ App\Helpers\TranslationHelper::trans('my-courses.stats_in_progress') }}</div>
            </div>

            <div class="stat-card" style="--stat-gradient: linear-gradient(135deg, #2E5C61, #18386E);">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-value">{{ $totalHours ?? 0 }}</div>
                <div class="stat-label">{{ App\Helpers\TranslationHelper::trans('my-courses.stats_hours') }}</div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-section" id="filterSection" style="display: none;">
            <div class="filter-grid">
                <select class="filter-select" id="statusFilter">
                    <option value="">{{ App\Helpers\TranslationHelper::trans('my-courses.filter_all_status') }}</option>
                    <option value="in-progress">{{ App\Helpers\TranslationHelper::trans('my-courses.filter_in_progress') }}</option>
                    <option value="completed">{{ App\Helpers\TranslationHelper::trans('my-courses.filter_completed') }}</option>
                    <option value="not-started">{{ App\Helpers\TranslationHelper::trans('my-courses.filter_not_started') }}</option>
                </select>
                <select class="filter-select" id="categoryFilter">
                    <option value="">{{ App\Helpers\TranslationHelper::trans('my-courses.filter_all_categories') }}</option>
                    <option value="business">{{ App\Helpers\TranslationHelper::trans('my-courses.filter_category_business') }}</option>
                    <option value="technology">{{ App\Helpers\TranslationHelper::trans('my-courses.filter_category_technology') }}</option>
                    <option value="language">{{ App\Helpers\TranslationHelper::trans('my-courses.filter_category_language') }}</option>
                </select>
                <select class="filter-select" id="sortFilter">
                    <option value="recent">{{ App\Helpers\TranslationHelper::trans('my-courses.filter_sort_recent') }}</option>
                    <option value="progress">{{ App\Helpers\TranslationHelper::trans('my-courses.filter_sort_progress') }}</option>
                    <option value="title">{{ App\Helpers\TranslationHelper::trans('my-courses.filter_sort_title') }}</option>
                </select>
            </div>
        </div>

        <!-- Course Grid -->
        @if(($enrollments ?? collect())->count() > 0)
            <div class="course-grid" id="courseGrid">
                @foreach($enrollments as $enrollment)
                    <div class="course-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                        @php
                            $progress = $enrollment->progress ?? 0;
                            $status = $progress >= 100 ? 'completed' : ($progress > 0 ? 'in-progress' : 'not-started');
                        @endphp
                        
                        <span class="course-badge {{ $status }}">
                            @if($status === 'completed')
                                {{ App\Helpers\TranslationHelper::trans('my-courses.badge_completed') }}
                            @elseif($status === 'in-progress')
                                {{ App\Helpers\TranslationHelper::trans('my-courses.badge_in_progress') }}
                            @else
                                {{ App\Helpers\TranslationHelper::trans('my-courses.badge_not_started') }}
                            @endif
                        </span>
                        
                        <div class="course-image">
                            <img src="{{ $enrollment->course->thumbnail_url ?? 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80' }}" 
                                 alt="{{ $enrollment->course->title ?? 'Course' }}">
                        </div>
                        
                        <div class="course-content">
                            <div class="course-meta">
                                <span>
                                    <i class="fas fa-signal"></i>
                                    {{ App\Helpers\TranslationHelper::trans('my-courses.course_level', ['level' => $enrollment->course->level ?? 'All Levels']) }}
                                </span>
                                <span>
                                    <i class="fas fa-video"></i>
                                    {{ App\Helpers\TranslationHelper::trans('my-courses.course_lessons', ['count' => $enrollment->course->lessons_count ?? 12]) }}
                                </span>
                            </div>
                            
                            <h3 class="course-title">
                                <a href="{{ route('courses.show', $enrollment->course->slug ?? '#') }}">
                                    {{ $enrollment->course->title ?? 'Course Title' }}
                                </a>
                            </h3>
                            
                            <div class="course-progress">
                                <div class="progress-header">
                                    <span class="progress-label">{{ App\Helpers\TranslationHelper::trans('my-courses.progress_label') }}</span>
                                    <span class="progress-percent {{ $status === 'completed' ? 'completed' : '' }}">
                                        {{ $progress }}%
                                    </span>
                                </div>
                                <div class="progress-bar-track">
                                    <div class="progress-bar-fill {{ $status === 'completed' ? 'completed' : '' }}" 
                                         style="width: {{ $progress }}%"></div>
                                </div>
                            </div>
                            
                            <div class="course-footer">
                                @if($status === 'completed')
                                    <a href="{{ route('certificates.show', $enrollment->course->id ?? '#') }}" 
                                       class="certificate-btn">
                                        <i class="fas fa-award"></i>
                                        {{ App\Helpers\TranslationHelper::trans('my-courses.btn_certificate') }}
                                    </a>
                                    <a href="{{ route('courses.learn', $enrollment->course->slug ?? '#') }}" 
                                       class="continue-btn">
                                        {{ App\Helpers\TranslationHelper::trans('my-courses.btn_review') }} <i class="fas fa-redo-alt"></i>
                                    </a>
                                @else
                                    <a href="{{ route('courses.learn', $enrollment->course->slug ?? '#') }}" 
                                       class="continue-btn">
                                        {{ App\Helpers\TranslationHelper::trans('my-courses.btn_continue') }} <i class="fas fa-arrow-right"></i>
                                    </a>
                                    <span class="last-activity">
                                        <i class="far fa-clock"></i>
                                        {{ App\Helpers\TranslationHelper::trans('my-courses.last_activity', ['date' => $enrollment->last_activity ?? now()->subDays(rand(1, 10))->format('M d, Y')]) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($enrollments->hasPages())
                <div class="pagination">
                    {{ $enrollments->appends(request()->query())->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <h2 class="empty-title">{{ App\Helpers\TranslationHelper::trans('my-courses.empty_title') }}</h2>
                <p class="empty-text">
                    {{ App\Helpers\TranslationHelper::trans('my-courses.empty_text') }}
                </p>
                <a href="{{ route('courses') }}" class="empty-btn">
                    {{ App\Helpers\TranslationHelper::trans('my-courses.empty_btn') }} <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        @endif
    </main>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filter toggle
        const filterToggle = document.getElementById('filterToggle');
        const filterSection = document.getElementById('filterSection');
        
        if (filterToggle) {
            filterToggle.addEventListener('click', function() {
                if (filterSection.style.display === 'none' || filterSection.style.display === '') {
                    filterSection.style.display = 'block';
                } else {
                    filterSection.style.display = 'none';
                }
            });
        }

        // Search functionality
        const searchInput = document.getElementById('searchCourses');
        const courseCards = document.querySelectorAll('.course-card');
        
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase().trim();
                
                courseCards.forEach(card => {
                    const title = card.querySelector('.course-title').textContent.toLowerCase();
                    const meta = card.querySelector('.course-meta').textContent.toLowerCase();
                    
                    if (title.includes(searchTerm) || meta.includes(searchTerm)) {
                        card.style.display = 'flex';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        }

        // Filter functionality
        const statusFilter = document.getElementById('statusFilter');
        const categoryFilter = document.getElementById('categoryFilter');
        const sortFilter = document.getElementById('sortFilter');
        
        function applyFilters() {
            const status = statusFilter?.value;
            const category = categoryFilter?.value;
            
            courseCards.forEach(card => {
                let show = true;
                
                if (status) {
                    const badge = card.querySelector('.course-badge').textContent.toLowerCase();
                    if (status === 'in-progress' && !badge.includes('progress')) show = false;
                    if (status === 'completed' && !badge.includes('completed')) show = false;
                    if (status === 'not-started' && !badge.includes('not')) show = false;
                }
                
                if (category && show) {
                    const meta = card.querySelector('.course-meta').textContent.toLowerCase();
                    if (!meta.includes(category)) show = false;
                }
                
                card.style.display = show ? 'flex' : 'none';
            });
        }
        
        if (statusFilter) statusFilter.addEventListener('change', applyFilters);
        if (categoryFilter) categoryFilter.addEventListener('change', applyFilters);
        
        if (sortFilter) {
            sortFilter.addEventListener('change', function() {
                const sortBy = this.value;
                const grid = document.getElementById('courseGrid');
                const cards = Array.from(courseCards);
                
                cards.sort((a, b) => {
                    if (sortBy === 'title') {
                        const titleA = a.querySelector('.course-title').textContent;
                        const titleB = b.querySelector('.course-title').textContent;
                        return titleA.localeCompare(titleB);
                    } else if (sortBy === 'progress') {
                        const progressA = parseInt(a.querySelector('.progress-percent').textContent);
                        const progressB = parseInt(b.querySelector('.progress-percent').textContent);
                        return progressB - progressA;
                    } else {
                        // Default: recent - assume they're in order
                        return 0;
                    }
                });
                
                grid.innerHTML = '';
                cards.forEach(card => grid.appendChild(card));
            });
        }

        // Ripple effect on buttons
        function createRipple(event) {
            const button = event.currentTarget;
            const ripple = document.createElement('span');
            const rect = button.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = event.clientX - rect.left - size / 2;
            const y = event.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.className = 'ripple';
            
            button.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        }

        const buttons = document.querySelectorAll('.continue-btn, .certificate-btn, .empty-btn, .filter-btn, .pagination .page-link');
        buttons.forEach(button => {
            button.classList.add('position-relative', 'overflow-hidden');
            button.addEventListener('click', createRipple);
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

        // Observe course cards and stat cards
        document.querySelectorAll('.course-card, .stat-card').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            observer.observe(el);
        });

        // Active menu item highlighting based on scroll
        window.addEventListener('scroll', function() {
            // Not needed for this page, but keeping for consistency
        });
    });
</script>
@endpush