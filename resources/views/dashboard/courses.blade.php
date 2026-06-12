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
        --text-muted: #6B7280;
        --text-light: #FEFDFE;
        
        /* Gradients */
        --gradient-1: linear-gradient(135deg, #0A1D44 0%, #18386E 50%, #2E5C61 100%);
        --gradient-2: linear-gradient(45deg, #FBC60C 0%, #EBD789 50%, #F9F7E9 100%);
        --gradient-3: linear-gradient(135deg, #5AD1E4 0%, #CBD1DA 50%, #FEFDFE 100%);
        --gradient-4: linear-gradient(135deg, #2E5C61 0%, #18386E 100%);
        
        /* Shadows */
        --shadow-sm: 0 1px 3px rgba(10, 29, 68, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(10, 29, 68, 0.1);
        --shadow-lg: 0 10px 15px -3px rgba(10, 29, 68, 0.1);
        --shadow-hover: 0 20px 25px -5px rgba(251, 198, 12, 0.15);
        
        /* Border Radius */
        --radius-sm: 6px;
        --radius-md: 8px;
        --radius-lg: 12px;
        --radius-xl: 16px;
        --radius-full: 9999px;
        
        /* Transitions */
        --transition: all 0.2s ease;
    }

    /* Main layout adjustments */
    body {
        background: linear-gradient(135deg, var(--ivory) 0%, var(--pure-white) 100%);
        min-height: 100vh;
    }

    /* ===== COURSES LAYOUT ===== */
    .courses-wrapper {
        display: flex;
        width: 100%;
        max-width: 1400px;
        margin: 24px auto;
        padding: 0 24px;
        gap: 24px;
    }

    /* ===== SIDEBAR STYLES ===== */
    .courses-sidebar {
        width: 260px;
        background: var(--pure-white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        overflow: hidden;
        height: fit-content;
        border: 1px solid rgba(251, 198, 12, 0.1);
        transition: var(--transition);
    }

    .courses-sidebar::-webkit-scrollbar {
        width: 4px;
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
        padding: 16px;
        background: var(--ivory);
        border-bottom: 1px solid rgba(251, 198, 12, 0.1);
    }

    .sidebar-title {
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .sidebar-title i {
        width: 28px;
        height: 28px;
        background: var(--gradient-1);
        color: var(--pure-white);
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
    }

    /* Navigation Menu */
    .sidebar-nav {
        padding: 12px;
    }

    .nav-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        border-radius: var(--radius-md);
        color: var(--text-muted);
        text-decoration: none;
        transition: var(--transition);
        margin-bottom: 2px;
        font-size: 0.9rem;
    }

    .nav-item i {
        width: 18px;
        font-size: 1rem;
        text-align: center;
    }

    .nav-item:hover {
        background: linear-gradient(145deg, var(--ivory), var(--pure-white));
        color: var(--bright-amber);
    }

    .nav-item.active {
        background: var(--gradient-1);
        color: var(--pure-white);
        box-shadow: var(--shadow-sm);
    }

    .nav-item.active i {
        color: var(--pure-white);
    }

    .nav-item span {
        flex: 1;
        font-weight: 500;
    }

    .nav-badge {
        background: rgba(251, 198, 12, 0.1);
        padding: 2px 6px;
        border-radius: var(--radius-full);
        font-size: 0.7rem;
        font-weight: 500;
        color: var(--bright-amber);
    }

    .nav-item.active .nav-badge {
        background: rgba(255,255,255,0.2);
        color: var(--pure-white);
    }

    /* Quick Stats */
    .quick-stats {
        padding: 16px;
        border-top: 1px solid rgba(251, 198, 12, 0.1);
    }

    .stat-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 6px 0;
        border-bottom: 1px dashed rgba(251, 198, 12, 0.1);
    }

    .stat-row:last-child {
        border-bottom: none;
    }

    .stat-label {
        color: var(--text-muted);
        font-size: 0.85rem;
    }

    .stat-value {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.95rem;
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
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
    }

    .page-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .page-title i {
        width: 40px;
        height: 40px;
        background: var(--gradient-1);
        color: var(--pure-white);
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        box-shadow: var(--shadow-sm);
    }

    .page-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .search-box {
        position: relative;
        min-width: 280px;
    }

    .search-input {
        width: 100%;
        padding: 10px 16px 10px 40px;
        border: 1px solid var(--pale-slate);
        border-radius: var(--radius-full);
        font-size: 0.9rem;
        transition: var(--transition);
        background: var(--pure-white);
        color: var(--text-primary);
    }

    .search-input:focus {
        outline: none;
        border-color: var(--bright-amber);
        box-shadow: 0 0 0 3px rgba(251, 198, 12, 0.1);
    }

    .search-input::placeholder {
        color: var(--khaki-beige);
    }

    .search-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--khaki-beige);
        font-size: 0.9rem;
    }

    .filter-btn {
        padding: 10px 20px;
        background: var(--pure-white);
        border: 1px solid var(--pale-slate);
        border-radius: var(--radius-full);
        color: var(--text-primary);
        font-weight: 500;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        transition: var(--transition);
    }

    .filter-btn:hover {
        border-color: var(--bright-amber);
        color: var(--bright-amber);
        box-shadow: var(--shadow-sm);
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: var(--pure-white);
        border-radius: var(--radius-lg);
        padding: 20px;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        border: 1px solid rgba(251, 198, 12, 0.1);
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        border-color: var(--bright-amber);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: var(--radius-md);
        background: var(--stat-gradient, var(--gradient-1));
        color: var(--pure-white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        box-shadow: var(--shadow-sm);
        flex-shrink: 0;
    }

    .stat-content {
        flex: 1;
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 2px;
        line-height: 1.2;
    }

    .stat-label {
        color: var(--text-muted);
        font-size: 0.85rem;
        font-weight: 500;
    }

    /* Filter Section */
    .filter-section {
        margin-bottom: 24px;
        background: var(--pure-white);
        border-radius: var(--radius-lg);
        padding: 20px;
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(251, 198, 12, 0.1);
        animation: slideInDown 0.2s ease;
    }

    .filter-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 12px;
    }

    .filter-select {
        padding: 10px 12px;
        border: 1px solid var(--pale-slate);
        border-radius: var(--radius-md);
        font-size: 0.85rem;
        color: var(--text-primary);
        background: var(--pure-white);
        cursor: pointer;
        transition: var(--transition);
    }

    .filter-select:focus {
        outline: none;
        border-color: var(--bright-amber);
        box-shadow: 0 0 0 3px rgba(251, 198, 12, 0.1);
    }

    /* Course Grid */
    .course-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-bottom: 24px;
    }

    .course-card {
        background: var(--pure-white);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        border: 1px solid rgba(251, 198, 12, 0.1);
        display: flex;
        flex-direction: column;
        height: 100%;
        position: relative;
    }

    .course-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
        border-color: var(--bright-amber);
    }

    .course-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        z-index: 2;
        padding: 4px 12px;
        border-radius: var(--radius-full);
        font-size: 0.7rem;
        font-weight: 600;
        letter-spacing: 0.3px;
        box-shadow: var(--shadow-sm);
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
        transition: transform 0.4s ease;
    }

    .course-card:hover .course-image img {
        transform: scale(1.05);
    }

    .course-content {
        padding: 16px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .course-meta {
        display: flex;
        gap: 12px;
        margin-bottom: 8px;
        color: var(--text-muted);
        font-size: 0.75rem;
        flex-wrap: wrap;
    }

    .course-meta span {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .course-meta i {
        color: var(--bright-amber);
        font-size: 0.75rem;
    }

    .course-title {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 12px;
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
        margin-bottom: 12px;
    }

    .progress-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 6px;
        font-size: 0.8rem;
    }

    .progress-label {
        color: var(--text-muted);
    }

    .progress-percent {
        font-weight: 600;
        color: var(--bright-amber);
    }

    .progress-percent.completed {
        color: var(--sky-blue);
    }

    .progress-bar-track {
        height: 6px;
        background: var(--pale-slate);
        border-radius: var(--radius-full);
        overflow: hidden;
    }

    .progress-bar-fill {
        height: 100%;
        background: var(--gradient-1);
        border-radius: var(--radius-full);
        transition: width 0.4s ease;
        position: relative;
        overflow: hidden;
    }

    .progress-bar-fill.completed {
        background: var(--gradient-3);
    }

    .course-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 4px;
    }

    .continue-btn {
        padding: 8px 16px;
        background: var(--gradient-1);
        color: var(--pure-white);
        border-radius: var(--radius-full);
        text-decoration: none;
        font-size: 0.8rem;
        font-weight: 500;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 6px;
        box-shadow: var(--shadow-sm);
        border: none;
        cursor: pointer;
    }

    .continue-btn:hover {
        background: var(--gradient-2);
        color: var(--prussian-blue);
        transform: translateX(4px);
        box-shadow: var(--shadow-md);
        text-decoration: none;
    }

    .certificate-btn {
        padding: 6px 14px;
        background: transparent;
        color: var(--sky-blue);
        border: 1px solid var(--sky-blue);
        border-radius: var(--radius-full);
        text-decoration: none;
        font-size: 0.75rem;
        font-weight: 500;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .certificate-btn:hover {
        background: var(--gradient-3);
        color: var(--prussian-blue);
        border-color: transparent;
        text-decoration: none;
    }

    .last-activity {
        color: var(--text-muted);
        font-size: 0.7rem;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .last-activity i {
        color: var(--bright-amber);
        font-size: 0.65rem;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 48px 24px;
        background: var(--pure-white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(251, 198, 12, 0.1);
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        background: var(--ivory);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        font-size: 2rem;
        color: var(--bright-amber);
        border: 1px solid var(--bright-amber);
    }

    .empty-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 8px;
    }

    .empty-text {
        color: var(--text-muted);
        margin-bottom: 20px;
        font-size: 0.9rem;
        max-width: 350px;
        margin-left: auto;
        margin-right: auto;
    }

    .empty-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 24px;
        background: var(--gradient-1);
        color: var(--pure-white);
        border-radius: var(--radius-full);
        text-decoration: none;
        font-weight: 500;
        font-size: 0.9rem;
        transition: var(--transition);
        box-shadow: var(--shadow-sm);
        border: none;
        cursor: pointer;
    }

    .empty-btn:hover {
        background: var(--gradient-2);
        color: var(--prussian-blue);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        text-decoration: none;
    }

    /* Pagination */
    .pagination {
        display: flex;
        justify-content: center;
        gap: 4px;
        margin-top: 24px;
        flex-wrap: wrap;
    }

    .pagination .page-item {
        list-style: none;
    }

    .pagination .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 34px;
        height: 34px;
        padding: 0 8px;
        background: var(--pure-white);
        border: 1px solid var(--pale-slate);
        border-radius: var(--radius-md);
        color: var(--text-primary);
        text-decoration: none;
        transition: var(--transition);
        font-weight: 500;
        font-size: 0.85rem;
    }

    .pagination .page-link:hover {
        background: var(--gradient-1);
        color: var(--pure-white);
        border-color: transparent;
        transform: translateY(-1px);
        box-shadow: var(--shadow-sm);
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
    @keyframes slideInDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
        .courses-wrapper {
            padding: 0 20px;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 992px) {
        .courses-wrapper {
            flex-direction: column;
            padding: 0 16px;
        }
        
        .courses-sidebar {
            width: 100%;
        }
        
        .page-title {
            font-size: 1.3rem;
        }

        .search-box {
            min-width: 240px;
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
    }

    @media (max-width: 576px) {
        .courses-wrapper {
            padding: 0 12px;
        }

        .page-title {
            font-size: 1.2rem;
        }

        .page-title i {
            width: 36px;
            height: 36px;
            font-size: 1rem;
        }

        .stat-card {
            padding: 16px;
        }

        .stat-value {
            font-size: 1.3rem;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }

        .sidebar-header {
            padding: 14px;
        }

        .sidebar-title {
            font-size: 0.9rem;
        }

        .nav-item {
            padding: 8px 10px;
            font-size: 0.85rem;
        }

        .quick-stats {
            padding: 14px;
        }

        .filter-btn {
            padding: 8px 16px;
            font-size: 0.85rem;
        }

        .course-content {
            padding: 14px;
        }

        .course-title {
            font-size: 1rem;
        }

        .pagination .page-link {
            min-width: 32px;
            height: 32px;
            font-size: 0.8rem;
        }

        .empty-icon {
            width: 70px;
            height: 70px;
            font-size: 1.8rem;
        }

        .empty-title {
            font-size: 1.1rem;
        }

        .empty-text {
            font-size: 0.85rem;
        }

        .empty-btn {
            padding: 8px 20px;
            font-size: 0.85rem;
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
            @if(Auth::user()->canAccessPracticeRoom())
            <a href="{{ route('dashboard.educonecx-academy.index') }}" class="nav-item {{ request()->routeIs('dashboard.educonecx-academy.*') || request()->routeIs('educonecx.academy.*') ? 'active' : '' }}">
                <i class="fas fa-graduation-cap"></i>
                <span>Practice Room</span>
            </a>
            @endif
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
                <div class="stat-content">
                    <div class="stat-value">{{ $enrollments->total() ?? 0 }}</div>
                    <div class="stat-label">{{ App\Helpers\TranslationHelper::trans('my-courses.stats_total') }}</div>
                </div>
            </div>

            <div class="stat-card" style="--stat-gradient: linear-gradient(135deg, #5AD1E4, #2E5C61);">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $completedCount ?? 0 }}</div>
                    <div class="stat-label">{{ App\Helpers\TranslationHelper::trans('my-courses.stats_completed') }}</div>
                </div>
            </div>

            <div class="stat-card" style="--stat-gradient: linear-gradient(135deg, #FBC60C, #EBD789);">
                <div class="stat-icon">
                    <i class="fas fa-spinner"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $inProgressCount ?? 0 }}</div>
                    <div class="stat-label">{{ App\Helpers\TranslationHelper::trans('my-courses.stats_in_progress') }}</div>
                </div>
            </div>

            <div class="stat-card" style="--stat-gradient: linear-gradient(135deg, #2E5C61, #18386E);">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $totalHours ?? 0 }}</div>
                    <div class="stat-label">{{ App\Helpers\TranslationHelper::trans('my-courses.stats_hours') }}</div>
                </div>
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
                                    <a href="{{ route('certificates') }}"
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
                const cards = Array.from(courseCards).filter(card => card.style.display !== 'none');
                
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
                        // Default: recent - use data attribute or index
                        return 0;
                    }
                });
                
                // Reorder visible cards
                const visibleCards = Array.from(courseCards).filter(card => card.style.display !== 'none');
                visibleCards.sort((a, b) => {
                    if (sortBy === 'title') {
                        return a.querySelector('.course-title').textContent.localeCompare(b.querySelector('.course-title').textContent);
                    } else if (sortBy === 'progress') {
                        return parseInt(b.querySelector('.progress-percent').textContent) - parseInt(a.querySelector('.progress-percent').textContent);
                    }
                    return 0;
                });
                
                visibleCards.forEach(card => grid.appendChild(card));
            });
        }

        // Animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -30px 0px'
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
            el.style.transform = 'translateY(15px)';
            el.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
            observer.observe(el);
        });
    });
</script>
@endpush