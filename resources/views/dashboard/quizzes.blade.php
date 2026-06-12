@extends('layouts.main')

@section('title', App\Helpers\TranslationHelper::trans('my-quizzes.title'))

@section('meta_description', App\Helpers\TranslationHelper::trans('my-quizzes.meta_description'))

@push('styles')
<style>
    /* ===== QUIZZES VARIABLES ===== */
    :root {
        --sidebar-width: 260px;
        --header-height: 70px;
        --primary-color: #4361ee;
        --secondary-color: #3f37c9;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
        --info-color: #3b82f6;
        --dark-color: #1f2937;
        --light-color: #f9fafb;
        --gray-color: #6b7280;
        --border-color: #e5e7eb;
        --card-bg: #ffffff;
        --gradient-1: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        --gradient-2: linear-gradient(135deg, #ec4899 0%, #d946ef 100%);
        --gradient-3: linear-gradient(135deg, #06b6d4 0%, #3b82f6 100%);
        --gradient-4: linear-gradient(135deg, #10b981 0%, #059669 100%);
        --shadow-sm: 0 1px 2px rgba(0,0,0,0.05);
        --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.1);
        --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.1);
        --shadow-hover: 0 20px 25px -5px rgba(99,102,241,0.15);
        --radius-sm: 6px;
        --radius-md: 8px;
        --radius-lg: 12px;
        --radius-xl: 16px;
        --radius-full: 9999px;
    }

    /* Main layout adjustments */
    body {
        background: #f3f4f6;
        min-height: 100vh;
    }

    /* ===== QUIZZES LAYOUT ===== */
    .quizzes-wrapper {
        display: flex;
        width: 100%;
        max-width: 1400px;
        margin: 24px auto;
        padding: 0 24px;
        gap: 24px;
    }

    /* ===== SIDEBAR STYLES ===== */
    .quizzes-sidebar {
        width: var(--sidebar-width);
        background: var(--card-bg);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        overflow: hidden;
        height: fit-content;
        border: 1px solid var(--border-color);
        transition: all 0.2s ease;
    }

    .quizzes-sidebar::-webkit-scrollbar {
        width: 4px;
    }

    .quizzes-sidebar::-webkit-scrollbar-track {
        background: var(--border-color);
    }

    .quizzes-sidebar::-webkit-scrollbar-thumb {
        background: var(--primary-color);
        border-radius: var(--radius-full);
    }

    /* Sidebar Header */
    .sidebar-header {
        padding: 16px;
        background: linear-gradient(145deg, #ffffff, #f9fafb);
        border-bottom: 1px solid var(--border-color);
    }

    .sidebar-title {
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--dark-color);
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
        color: white;
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
        color: var(--gray-color);
        text-decoration: none;
        transition: all 0.2s ease;
        margin-bottom: 2px;
        font-size: 0.9rem;
    }

    .nav-item i {
        width: 18px;
        font-size: 1rem;
        text-align: center;
    }

    .nav-item:hover {
        background: #f3f4f6;
        color: var(--primary-color);
    }

    .nav-item.active {
        background: var(--gradient-1);
        color: white;
        box-shadow: var(--shadow-sm);
    }

    .nav-item.active i {
        color: white;
    }

    .nav-item span {
        flex: 1;
        font-weight: 500;
    }

    .nav-badge {
        background: rgba(0,0,0,0.05);
        padding: 2px 6px;
        border-radius: var(--radius-full);
        font-size: 0.7rem;
        font-weight: 500;
    }

    .nav-item.active .nav-badge {
        background: rgba(255,255,255,0.2);
        color: white;
    }

    /* Quick Stats */
    .quick-stats {
        padding: 16px;
        border-top: 1px solid var(--border-color);
    }

    .stat-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 6px 0;
        border-bottom: 1px dashed var(--border-color);
    }

    .stat-row:last-child {
        border-bottom: none;
    }

    .stat-label {
        color: var(--gray-color);
        font-size: 0.85rem;
    }

    .stat-value {
        font-weight: 600;
        color: var(--dark-color);
        font-size: 0.95rem;
    }

    .stat-value.success {
        color: var(--success-color);
    }

    .stat-value.primary {
        color: var(--primary-color);
    }

    /* Main Content Area */
    .quizzes-main {
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
        color: var(--dark-color);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .page-title i {
        width: 40px;
        height: 40px;
        background: var(--gradient-1);
        color: white;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        box-shadow: var(--shadow-sm);
    }

    .stats-badge {
        background: white;
        color: var(--primary-color);
        padding: 8px 16px;
        border-radius: var(--radius-full);
        font-weight: 600;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 8px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-color);
    }

    .stats-badge i {
        font-size: 1rem;
        color: var(--primary-color);
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: white;
        border-radius: var(--radius-lg);
        padding: 20px;
        box-shadow: var(--shadow-sm);
        transition: all 0.2s ease;
        border: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        border-color: var(--primary-color);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: var(--radius-md);
        background: var(--stat-gradient, var(--gradient-1));
        color: white;
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
        color: var(--dark-color);
        margin-bottom: 2px;
        line-height: 1.2;
    }

    .stat-label {
        color: var(--gray-color);
        font-size: 0.85rem;
        font-weight: 500;
    }

    /* Performance Chart Card */
    .chart-card {
        background: white;
        border-radius: var(--radius-lg);
        padding: 20px;
        margin-bottom: 24px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-color);
    }

    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .chart-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--dark-color);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .chart-title i {
        width: 32px;
        height: 32px;
        background: var(--gradient-1);
        color: white;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
    }

    .chart-legend {
        display: flex;
        gap: 16px;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.8rem;
        color: var(--gray-color);
    }

    .legend-color {
        width: 10px;
        height: 10px;
        border-radius: var(--radius-sm);
    }

    .legend-color.passed {
        background: var(--success-color);
    }

    .legend-color.failed {
        background: var(--danger-color);
    }

    .chart-container {
        height: 160px;
        display: flex;
        align-items: flex-end;
        gap: 12px;
        padding: 5px 0;
    }

    .chart-bar-wrapper {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
    }

    .chart-bar-group {
        width: 100%;
        display: flex;
        gap: 4px;
        height: 120px;
        align-items: flex-end;
    }

    .chart-bar {
        flex: 1;
        min-width: 16px;
        background: var(--gradient-1);
        border-radius: var(--radius-sm) var(--radius-sm) 0 0;
        transition: height 0.2s ease;
        position: relative;
        cursor: pointer;
    }

    .chart-bar.passed {
        background: var(--success-color);
    }

    .chart-bar.failed {
        background: var(--danger-color);
    }

    .chart-bar:hover {
        opacity: 0.8;
    }

    .chart-tooltip {
        position: absolute;
        top: -28px;
        left: 50%;
        transform: translateX(-50%);
        background: var(--dark-color);
        color: white;
        padding: 4px 8px;
        border-radius: var(--radius-sm);
        font-size: 0.7rem;
        white-space: nowrap;
        opacity: 0;
        transition: opacity 0.2s ease;
        pointer-events: none;
        z-index: 10;
    }

    .chart-bar:hover .chart-tooltip {
        opacity: 1;
    }

    .chart-label {
        font-size: 0.7rem;
        color: var(--gray-color);
        text-align: center;
        max-width: 70px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* Filter Section */
    .filter-section {
        background: white;
        border-radius: var(--radius-lg);
        padding: 16px;
        margin-bottom: 20px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-color);
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        align-items: center;
    }

    .filter-group {
        display: flex;
        align-items: center;
        gap: 8px;
        flex: 1;
        min-width: 180px;
    }

    .filter-icon {
        width: 32px;
        height: 32px;
        background: #f3f4f6;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-color);
        font-size: 0.9rem;
        flex-shrink: 0;
    }

    .filter-select {
        flex: 1;
        padding: 8px 12px;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        font-size: 0.85rem;
        background: white;
        cursor: pointer;
        transition: all 0.2s ease;
        color: var(--dark-color);
    }

    .filter-select:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
    }

    .filter-search {
        flex: 2;
        position: relative;
        min-width: 220px;
    }

    .filter-search input {
        width: 100%;
        padding: 8px 12px 8px 36px;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        font-size: 0.85rem;
        transition: all 0.2s ease;
        background: white;
    }

    .filter-search input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
    }

    .filter-search i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gray-color);
        font-size: 0.9rem;
    }

    /* Table Card */
    .table-card {
        background: white;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-color);
        overflow: hidden;
    }

    .table-header {
        padding: 16px 20px;
        background: #f9fafb;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .table-header h3 {
        font-size: 1rem;
        font-weight: 600;
        color: var(--dark-color);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .table-header i {
        width: 32px;
        height: 32px;
        background: var(--gradient-1);
        color: white;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
    }

    .export-btn {
        padding: 6px 14px;
        background: transparent;
        color: var(--primary-color);
        border: 1px solid var(--primary-color);
        border-radius: var(--radius-full);
        font-size: 0.8rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .export-btn:hover {
        background: var(--primary-color);
        color: white;
    }

    /* Table Styles */
    .table-responsive {
        overflow-x: auto;
    }

    .quiz-table {
        width: 100%;
        border-collapse: collapse;
    }

    .quiz-table thead {
        background: #f9fafb;
    }

    .quiz-table th {
        padding: 14px 16px;
        text-align: left;
        font-weight: 600;
        color: var(--dark-color);
        font-size: 0.85rem;
        white-space: nowrap;
        border-bottom: 1px solid var(--border-color);
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .quiz-table td {
        padding: 14px 16px;
        border-bottom: 1px solid var(--border-color);
        color: var(--gray-color);
        font-size: 0.9rem;
    }

    .quiz-table tbody tr {
        transition: all 0.2s ease;
    }

    .quiz-table tbody tr:hover {
        background: #f9fafb;
    }

    /* Quiz Info */
    .quiz-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .quiz-icon {
        width: 36px;
        height: 36px;
        background: #f3f4f6;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-color);
        font-size: 1rem;
        flex-shrink: 0;
    }

    .quiz-details h4 {
        font-weight: 600;
        color: var(--dark-color);
        margin-bottom: 2px;
        font-size: 0.9rem;
    }

    .quiz-details span {
        font-size: 0.75rem;
        color: var(--gray-color);
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .quiz-details i {
        color: var(--primary-color);
        font-size: 0.7rem;
    }

    /* Attempt Badge */
    .attempt-badge {
        display: inline-block;
        padding: 3px 8px;
        background: #f3f4f6;
        border-radius: var(--radius-full);
        font-size: 0.75rem;
        font-weight: 500;
        color: var(--gray-color);
    }

    /* Score Styles */
    .score-wrapper {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .score-circle {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: conic-gradient(from 0deg, var(--score-color) 0deg, var(--score-color) calc(var(--percentage) * 3.6deg), #e5e7eb calc(var(--percentage) * 3.6deg));
        position: relative;
        flex-shrink: 0;
    }

    .score-circle::before {
        content: '';
        position: absolute;
        width: 28px;
        height: 28px;
        background: white;
        border-radius: 50%;
    }

    .score-text {
        position: relative;
        z-index: 2;
        font-weight: 600;
        font-size: 0.7rem;
        color: var(--dark-color);
    }

    .score-percentage {
        font-weight: 600;
        color: var(--dark-color);
        font-size: 0.9rem;
    }

    /* Result Badge */
    .result-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        border-radius: var(--radius-full);
        font-size: 0.75rem;
        font-weight: 500;
    }

    .result-badge.passed {
        background: #d1fae5;
        color: #059669;
    }

    .result-badge.failed {
        background: #fee2e2;
        color: #dc2626;
    }

    .result-badge i {
        font-size: 0.7rem;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 6px 12px;
        background: transparent;
        color: var(--primary-color);
        border: 1px solid var(--primary-color);
        border-radius: var(--radius-full);
        font-size: 0.75rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .action-btn:hover {
        background: var(--primary-color);
        color: white;
        text-decoration: none;
    }

    .retry-btn {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 6px 12px;
        background: var(--success-color);
        color: white;
        border: none;
        border-radius: var(--radius-full);
        font-size: 0.75rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .retry-btn:hover {
        background: #059669;
        color: white;
        text-decoration: none;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 48px 24px;
        background: white;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-color);
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        background: #f3f4f6;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        font-size: 2rem;
        color: var(--gray-color);
    }

    .empty-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--dark-color);
        margin-bottom: 8px;
    }

    .empty-text {
        color: var(--gray-color);
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
        color: white;
        border-radius: var(--radius-full);
        text-decoration: none;
        font-weight: 500;
        font-size: 0.9rem;
        transition: all 0.2s ease;
        box-shadow: var(--shadow-sm);
    }

    .empty-btn:hover {
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
        color: white;
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
        background: white;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        color: var(--dark-color);
        text-decoration: none;
        transition: all 0.2s ease;
        font-weight: 500;
        font-size: 0.85rem;
    }

    .pagination .page-link:hover {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .pagination .page-item.active .page-link {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .pagination .page-item.disabled .page-link {
        background: #f3f4f6;
        color: var(--gray-color);
        pointer-events: none;
        border-color: var(--border-color);
        opacity: 0.5;
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
        .quizzes-wrapper {
            padding: 0 20px;
        }
    }

    @media (max-width: 992px) {
        .quizzes-wrapper {
            flex-direction: column;
            padding: 0 16px;
        }
        
        .quizzes-sidebar {
            width: 100%;
        }
        
        .stats-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .filter-section {
            flex-direction: column;
        }

        .filter-group,
        .filter-search {
            width: 100%;
        }

        .table-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .action-buttons {
            flex-direction: column;
        }

        .action-btn, .retry-btn {
            width: 100%;
            justify-content: center;
        }

        .chart-container {
            height: 120px;
        }
    }

    @media (max-width: 576px) {
        .quizzes-wrapper {
            padding: 0 12px;
        }

        .page-title {
            font-size: 1.3rem;
        }

        .stat-card {
            padding: 16px;
        }

        .stat-value {
            font-size: 1.3rem;
        }

        .stats-badge {
            width: 100%;
            justify-content: center;
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
<div class="quizzes-wrapper">
    <!-- Sidebar -->
    <aside class="quizzes-sidebar">
        <div class="sidebar-header">
            <h3 class="sidebar-title">
                <i class="fas fa-puzzle-piece"></i>
                {{ App\Helpers\TranslationHelper::trans('my-quizzes.sidebar_title') }}
            </h3>
        </div>

        <div class="sidebar-nav">
            <a href="{{ route('dashboard') }}" class="nav-item">
                <i class="fas fa-home"></i>
                <span>{{ App\Helpers\TranslationHelper::trans('my-quizzes.nav_dashboard') }}</span>
            </a>
            @if(Auth::user()->canAccessPracticeRoom())
            <a href="{{ route('dashboard.educonecx-academy.index') }}" class="nav-item {{ request()->routeIs('dashboard.educonecx-academy.*') || request()->routeIs('educonecx.academy.*') ? 'active' : '' }}">
                <i class="fas fa-graduation-cap"></i>
                <span>Practice Room</span>
            </a>
            @endif
            <a href="{{ route('my-courses') }}" class="nav-item">
                <i class="fas fa-book"></i>
                <span>{{ App\Helpers\TranslationHelper::trans('my-quizzes.nav_my_courses') }}</span>
            </a>
            <a href="{{ route('my-quizzes') }}" class="nav-item active">
                <i class="fas fa-question-circle"></i>
                <span>{{ App\Helpers\TranslationHelper::trans('my-quizzes.nav_my_quizzes') }}</span>
                @if(($attempts->total() ?? 0) > 0)
                    <span class="nav-badge">{{ $attempts->total() }}</span>
                @endif
            </a>
            <a href="{{ route('certificates') }}" class="nav-item">
                <i class="fas fa-certificate"></i>
                <span>{{ App\Helpers\TranslationHelper::trans('my-quizzes.nav_certificates') }}</span>
            </a>
        </div>

        <!-- Quick Stats -->
        <div class="sidebar-header" style="border-radius: 0; border-top: 1px solid var(--border-color); border-bottom: none;">
            <h3 class="sidebar-title">
                <i class="fas fa-chart-pie"></i>
                {{ App\Helpers\TranslationHelper::trans('my-quizzes.performance_title') }}
            </h3>
        </div>
        <div class="quick-stats">
            <div class="stat-row">
                <span class="stat-label">{{ App\Helpers\TranslationHelper::trans('my-quizzes.stat_avg_score') }}</span>
                <span class="stat-value">{{ $averageScore ?? 0 }}%</span>
            </div>
            <div class="stat-row">
                <span class="stat-label">{{ App\Helpers\TranslationHelper::trans('my-quizzes.stat_pass_rate') }}</span>
                <span class="stat-value success">{{ $passRate ?? 0 }}%</span>
            </div>
            <div class="stat-row">
                <span class="stat-label">{{ App\Helpers\TranslationHelper::trans('my-quizzes.stat_best_score') }}</span>
                <span class="stat-value primary">{{ $bestScore ?? 0 }}%</span>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="quizzes-main">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-puzzle-piece"></i>
                {{ App\Helpers\TranslationHelper::trans('my-quizzes.page_title') }}
            </h1>
            
            <div class="stats-badge">
                <i class="fas fa-chart-line"></i>
                {{ App\Helpers\TranslationHelper::trans('my-quizzes.total_attempts', ['count' => $attempts->total() ?? 0]) }}
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card" style="--stat-gradient: linear-gradient(135deg, #6366f1, #8b5cf6);">
                <div class="stat-icon">
                    <i class="fas fa-puzzle-piece"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $totalQuizzes ?? 0 }}</div>
                    <div class="stat-label">{{ App\Helpers\TranslationHelper::trans('my-quizzes.stats_quizzes_taken') }}</div>
                </div>
            </div>

            <div class="stat-card" style="--stat-gradient: linear-gradient(135deg, #10b981, #059669);">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $passedQuizzes ?? 0 }}</div>
                    <div class="stat-label">{{ App\Helpers\TranslationHelper::trans('my-quizzes.stats_passed') }}</div>
                </div>
            </div>

            <div class="stat-card" style="--stat-gradient: linear-gradient(135deg, #6366f1, #8b5cf6);">
                <div class="stat-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $averageScore ?? 0 }}%</div>
                    <div class="stat-label">{{ App\Helpers\TranslationHelper::trans('my-quizzes.stats_avg_score') }}</div>
                </div>
            </div>
        </div>

        <!-- Performance Chart -->
        @if(($attempts ?? collect())->count() > 0)
            <div class="chart-card">
                <div class="chart-header">
                    <h3 class="chart-title">
                        <i class="fas fa-chart-bar"></i>
                        {{ App\Helpers\TranslationHelper::trans('my-quizzes.chart_title') }}
                    </h3>
                    <div class="chart-legend">
                        <div class="legend-item">
                            <span class="legend-color passed"></span>
                            <span>{{ App\Helpers\TranslationHelper::trans('my-quizzes.chart_legend_passed') }}</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-color failed"></span>
                            <span>{{ App\Helpers\TranslationHelper::trans('my-quizzes.chart_legend_failed') }}</span>
                        </div>
                    </div>
                </div>
                <div class="chart-container">
                    @foreach($recentAttempts ?? [] as $attempt)
                        <div class="chart-bar-wrapper">
                            <div class="chart-bar-group">
                                <div class="chart-bar {{ $attempt['passed'] ? 'passed' : 'failed' }}" 
                                     style="height: {{ $attempt['percentage'] }}px"
                                     data-score="{{ $attempt['percentage'] }}%">
                                    <div class="chart-tooltip">
                                        {!! App\Helpers\TranslationHelper::trans('my-quizzes.chart_tooltip', ['score' => $attempt['percentage'], 'date' => \Carbon\Carbon::parse($attempt['created_at'])->format('M d, Y')]) !!}
                                    </div>
                                </div>
                            </div>
                            <span class="chart-label">{{ \Carbon\Carbon::parse($attempt['created_at'])->format('M d') }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Filter Section -->
            <div class="filter-section">
                <div class="filter-group">
                    <span class="filter-icon"><i class="fas fa-filter"></i></span>
                    <select class="filter-select" id="resultFilter">
                        <option value="">{{ App\Helpers\TranslationHelper::trans('my-quizzes.filter_all_results') }}</option>
                        <option value="passed">{{ App\Helpers\TranslationHelper::trans('my-quizzes.filter_passed') }}</option>
                        <option value="failed">{{ App\Helpers\TranslationHelper::trans('my-quizzes.filter_failed') }}</option>
                    </select>
                </div>
                <div class="filter-group">
                    <span class="filter-icon"><i class="fas fa-sort"></i></span>
                    <select class="filter-select" id="sortFilter">
                        <option value="recent">{{ App\Helpers\TranslationHelper::trans('my-quizzes.filter_sort_recent') }}</option>
                        <option value="score-high">{{ App\Helpers\TranslationHelper::trans('my-quizzes.filter_sort_highest') }}</option>
                        <option value="score-low">{{ App\Helpers\TranslationHelper::trans('my-quizzes.filter_sort_lowest') }}</option>
                    </select>
                </div>
                <div class="filter-search">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="{{ App\Helpers\TranslationHelper::trans('my-quizzes.search_placeholder') }}">
                </div>
            </div>

            <!-- Quiz Attempts Table -->
            <div class="table-card">
                <div class="table-header">
                    <h3>
                        <i class="fas fa-history"></i>
                        {{ App\Helpers\TranslationHelper::trans('my-quizzes.table_title') }}
                    </h3>
                    <button class="export-btn" onclick="exportTableToCSV()">
                        <i class="fas fa-download"></i>
                        {{ App\Helpers\TranslationHelper::trans('my-quizzes.export_btn') }}
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="quiz-table" id="quizTable">
                        <thead>
                            <tr>
                                <th>{{ App\Helpers\TranslationHelper::trans('my-quizzes.col_quiz') }}</th>
                                <th>{{ App\Helpers\TranslationHelper::trans('my-quizzes.col_attempt') }}</th>
                                <th>{{ App\Helpers\TranslationHelper::trans('my-quizzes.col_score') }}</th>
                                <th>{{ App\Helpers\TranslationHelper::trans('my-quizzes.col_result') }}</th>
                                <th>{{ App\Helpers\TranslationHelper::trans('my-quizzes.col_date') }}</th>
                                <th>{{ App\Helpers\TranslationHelper::trans('my-quizzes.col_actions') }}</th>
                            </tr>
                        </thead>
                        <tbody id="quizTableBody">
                            @foreach($attempts as $attempt)
                                <tr class="quiz-row" 
                                    data-result="{{ $attempt->passed ? 'passed' : 'failed' }}"
                                    data-score="{{ $attempt->percentage }}"
                                    data-date="{{ $attempt->created_at->timestamp }}">
                                    <td>
                                        <div class="quiz-info">
                                            <div class="quiz-icon">
                                                <i class="fas fa-question"></i>
                                            </div>
                                            <div class="quiz-details">
                                                <h4>{{ $attempt->quiz->title ?? 'Quiz Title' }}</h4>
                                                <span>
                                                    <i class="fas fa-clock"></i>
                                                    {{ $attempt->quiz->duration ?? '15 min' }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="attempt-badge">
                                            {{ App\Helpers\TranslationHelper::trans('my-quizzes.attempt_number', ['number' => $attempt->attempt_number ?? 1]) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="score-wrapper">
                                            <div class="score-circle" style="--percentage: {{ $attempt->percentage ?? 0 }}; --score-color: {{ $attempt->passed ? '#10b981' : '#ef4444' }};">
                                                <span class="score-text">{{ $attempt->percentage ?? 0 }}%</span>
                                            </div>
                                            <span class="score-percentage">{{ $attempt->percentage ?? 0 }}%</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="result-badge {{ $attempt->passed ? 'passed' : 'failed' }}">
                                            <i class="fas {{ $attempt->passed ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                            {{ $attempt->passed ? App\Helpers\TranslationHelper::trans('my-quizzes.result_passed') : App\Helpers\TranslationHelper::trans('my-quizzes.result_failed') }}
                                        </span>
                                    </td>
                                    <td>
                                        <i class="far fa-calendar-alt me-1" style="color: var(--primary-color);"></i>
                                        {{ \Carbon\Carbon::parse($attempt->created_at)->format('M d, Y') }}
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('quizzes.results', ['quiz' => $attempt->quiz->id, 'attempt' => $attempt->id]) }}" 
                                               class="action-btn">
                                                <i class="fas fa-eye"></i>
                                                {{ App\Helpers\TranslationHelper::trans('my-quizzes.btn_view') }}
                                            </a>
                                            @if(!$attempt->passed)
                                                <a href="{{ route('quizzes.take', ['quiz' => $attempt->quiz->id, 'attempt' => $attempt->id]) }}" 
                                                   class="retry-btn">
                                                    <i class="fas fa-redo-alt"></i>
                                                    {{ App\Helpers\TranslationHelper::trans('my-quizzes.btn_retry') }}
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            @if($attempts->hasPages())
                <div class="pagination">
                    {{ $attempts->appends(request()->query())->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-puzzle-piece"></i>
                </div>
                <h2 class="empty-title">{{ App\Helpers\TranslationHelper::trans('my-quizzes.empty_title') }}</h2>
                <p class="empty-text">
                    {{ App\Helpers\TranslationHelper::trans('my-quizzes.empty_text') }}
                </p>
                <a href="{{ route('courses') }}" class="empty-btn">
                    <i class="fas fa-play"></i>
                    {{ App\Helpers\TranslationHelper::trans('my-quizzes.empty_btn') }}
                </a>
            </div>
        @endif
    </main>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filter and sort functionality
        const resultFilter = document.getElementById('resultFilter');
        const sortFilter = document.getElementById('sortFilter');
        const searchInput = document.getElementById('searchInput');
        const tableBody = document.getElementById('quizTableBody');
        const rows = document.querySelectorAll('.quiz-row');

        if (resultFilter) {
            resultFilter.addEventListener('change', filterAndSortRows);
        }

        if (sortFilter) {
            sortFilter.addEventListener('change', filterAndSortRows);
        }

        if (searchInput) {
            searchInput.addEventListener('input', filterAndSortRows);
        }

        function filterAndSortRows() {
            let filteredRows = Array.from(rows);
            
            // Apply result filter
            const resultValue = resultFilter?.value;
            if (resultValue) {
                filteredRows = filteredRows.filter(row => 
                    row.dataset.result === resultValue
                );
            }

            // Apply search filter
            const searchValue = searchInput?.value.toLowerCase().trim();
            if (searchValue) {
                filteredRows = filteredRows.filter(row => {
                    const quizTitle = row.querySelector('.quiz-details h4')?.textContent.toLowerCase() || '';
                    return quizTitle.includes(searchValue);
                });
            }

            // Apply sorting
            const sortValue = sortFilter?.value;
            if (sortValue) {
                filteredRows.sort((a, b) => {
                    if (sortValue === 'score-high') {
                        return b.dataset.score - a.dataset.score;
                    } else if (sortValue === 'score-low') {
                        return a.dataset.score - b.dataset.score;
                    } else if (sortValue === 'recent') {
                        return b.dataset.date - a.dataset.date;
                    }
                    return 0;
                });
            }

            // Update table
            if (tableBody) {
                tableBody.innerHTML = '';
                if (filteredRows.length === 0) {
                    const emptyRow = document.createElement('tr');
                    emptyRow.innerHTML = `
                        <td colspan="6" style="text-align: center; padding: 32px;">
                            <i class="fas fa-search" style="font-size: 1.5rem; color: var(--gray-color); margin-bottom: 8px;"></i>
                            <p style="color: var(--gray-color);">{{ App\Helpers\TranslationHelper::trans('my-quizzes.no_results') }}</p>
                        </td>
                    `;
                    tableBody.appendChild(emptyRow);
                } else {
                    filteredRows.forEach(row => tableBody.appendChild(row));
                }
            }
        }

        // Chart tooltips
        document.querySelectorAll('.chart-bar').forEach(bar => {
            bar.addEventListener('mouseenter', function() {
                const tooltip = this.querySelector('.chart-tooltip');
                if (tooltip) {
                    tooltip.style.opacity = '1';
                }
            });
            
            bar.addEventListener('mouseleave', function() {
                const tooltip = this.querySelector('.chart-tooltip');
                if (tooltip) {
                    tooltip.style.opacity = '0';
                }
            });
        });

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

        // Observe elements
        document.querySelectorAll('.stat-card, .chart-card, .filter-section, .table-card').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(15px)';
            el.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
            observer.observe(el);
        });
    });

    // Export to CSV
    window.exportTableToCSV = function() {
        const rows = document.querySelectorAll('.quiz-row');
        if (rows.length === 0) return;
        
        const csv = [];
        
        // Headers
        csv.push(['Quiz', 'Attempt', 'Score', 'Result', 'Date']);
        
        // Data
        rows.forEach(row => {
            const quizTitle = row.querySelector('.quiz-details h4')?.textContent || '';
            const attempt = row.querySelector('.attempt-badge')?.textContent.replace('Attempt #', '') || '';
            const score = row.querySelector('.score-percentage')?.textContent || '';
            const result = row.querySelector('.result-badge')?.textContent.trim() || '';
            const date = row.querySelector('td:nth-child(5)')?.textContent.replace(/\s+/g, ' ').trim() || '';
            
            csv.push([quizTitle, attempt, score, result, date]);
        });
        
        // Convert to CSV string
        const csvString = csv.map(row => row.join(',')).join('\n');
        
        // Download
        const blob = new Blob([csvString], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'quiz-attempts.csv';
        a.click();
        window.URL.revokeObjectURL(url);
    };
</script>
@endpush