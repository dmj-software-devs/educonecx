@extends('layouts.main')

@section('title', App\Helpers\TranslationHelper::trans('my-quizzes.title'))

@section('meta_description', App\Helpers\TranslationHelper::trans('my-quizzes.meta_description'))

@push('styles')
<style>
    /* ===== QUIZZES VARIABLES ===== */
    :root {
        --sidebar-width: 280px;
        --header-height: 80px;
        --primary-color: #4361ee;
        --secondary-color: #3f37c9;
        --success-color: #4cc9f0;
        --warning-color: #f72585;
        --info-color: #4895ef;
        --dark-color: #1e1e2f;
        --light-color: #f8f9fa;
        --gray-color: #6c757d;
        --border-color: #e9ecef;
        --card-bg: #ffffff;
        --gradient-1: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --gradient-2: linear-gradient(135deg, #f72585 0%, #b5179e 100%);
        --gradient-3: linear-gradient(135deg, #4cc9f0 0%, #4895ef 100%);
        --gradient-4: linear-gradient(135deg, #06d6a0 0%, #1b9e6d 100%);
        --shadow-sm: 0 2px 4px rgba(0,0,0,0.02);
        --shadow-md: 0 5px 15px rgba(0,0,0,0.05);
        --shadow-lg: 0 10px 25px rgba(0,0,0,0.1);
        --shadow-hover: 0 20px 40px rgba(67,97,238,0.15);
        --radius-sm: 8px;
        --radius-md: 12px;
        --radius-lg: 16px;
        --radius-xl: 24px;
        --radius-full: 9999px;
    }

    /* Main layout adjustments */
    body {
        background: linear-gradient(135deg, #f5f7ff 0%, #f0f3ff 100%);
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    main {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    /* ===== QUIZZES LAYOUT ===== */
    .quizzes-wrapper {
        flex: 1;
        display: flex;
        width: 100%;
        max-width: 1400px;
        margin: 0 auto;
        padding: 30px;
        gap: 30px;
    }

    /* ===== SIDEBAR STYLES ===== */
    .quizzes-sidebar {
        width: var(--sidebar-width);
        background: var(--card-bg);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-lg);
        overflow: hidden;
        height: fit-content;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .quizzes-sidebar::-webkit-scrollbar {
        width: 5px;
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
        padding: 20px;
        background: linear-gradient(145deg, #f8f9fa, #e9ecef);
        border-bottom: 1px solid var(--border-color);
    }

    .sidebar-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--dark-color);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .sidebar-title i {
        width: 32px;
        height: 32px;
        background: var(--gradient-1);
        color: white;
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
        color: var(--gray-color);
        text-decoration: none;
        transition: all 0.3s ease;
        margin-bottom: 5px;
        position: relative;
        overflow: hidden;
    }

    .nav-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 3px;
        background: var(--gradient-1);
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
        transition: all 0.3s ease;
    }

    .nav-item:hover {
        background: linear-gradient(145deg, #f8f9fa, #ffffff);
        color: var(--primary-color);
        transform: translateX(5px);
    }

    .nav-item.active {
        background: var(--gradient-1);
        color: white;
        box-shadow: var(--shadow-md);
    }

    .nav-item.active::before {
        display: none;
    }

    .nav-item.active i {
        color: white;
    }

    .nav-item span {
        flex: 1;
        font-weight: 500;
        font-size: 0.95rem;
    }

    .nav-badge {
        background: rgba(0,0,0,0.1);
        padding: 2px 8px;
        border-radius: var(--radius-full);
        font-size: 0.7rem;
        font-weight: 600;
    }

    .nav-item.active .nav-badge {
        background: rgba(255,255,255,0.2);
        color: white;
    }

    /* Quick Stats */
    .quick-stats {
        padding: 20px;
        border-top: 1px solid var(--border-color);
    }

    .stat-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px dashed var(--border-color);
    }

    .stat-row:last-child {
        border-bottom: none;
    }

    .stat-label {
        color: var(--gray-color);
        font-size: 0.9rem;
    }

    .stat-value {
        font-weight: 700;
        color: var(--dark-color);
        font-size: 1rem;
    }

    .stat-value.success {
        color: #06d6a0;
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
        color: var(--dark-color);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .page-title i {
        width: 50px;
        height: 50px;
        background: var(--gradient-1);
        color: white;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        box-shadow: var(--shadow-md);
        animation: pulse 2s infinite;
    }

    .stats-badge {
        background: var(--gradient-1);
        color: white;
        padding: 12px 25px;
        border-radius: var(--radius-full);
        font-weight: 700;
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 10px;
        box-shadow: var(--shadow-md);
    }

    .stats-badge i {
        font-size: 1.1rem;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        border-radius: var(--radius-lg);
        padding: 25px;
        box-shadow: var(--shadow-md);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        border: 1px solid var(--border-color);
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
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: var(--radius-md);
        background: var(--stat-gradient, var(--gradient-1));
        color: white;
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
        color: var(--dark-color);
        margin-bottom: 5px;
        line-height: 1;
    }

    .stat-label {
        color: var(--gray-color);
        font-size: 0.9rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Performance Chart Card */
    .chart-card {
        background: white;
        border-radius: var(--radius-lg);
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-color);
    }

    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .chart-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--dark-color);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .chart-title i {
        width: 35px;
        height: 35px;
        background: var(--gradient-1);
        color: white;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        box-shadow: var(--shadow-sm);
    }

    .chart-legend {
        display: flex;
        gap: 20px;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
        color: var(--gray-color);
    }

    .legend-color {
        width: 12px;
        height: 12px;
        border-radius: var(--radius-sm);
    }

    .legend-color.passed {
        background: linear-gradient(145deg, #06d6a0, #05b587);
    }

    .legend-color.failed {
        background: linear-gradient(145deg, #ef476f, #d43f62);
    }

    .chart-container {
        height: 200px;
        display: flex;
        align-items: flex-end;
        gap: 15px;
        padding: 10px 0;
    }

    .chart-bar-wrapper {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
    }

    .chart-bar-group {
        width: 100%;
        display: flex;
        gap: 5px;
        height: 150px;
        align-items: flex-end;
    }

    .chart-bar {
        flex: 1;
        min-width: 20px;
        background: var(--gradient-1);
        border-radius: var(--radius-md) var(--radius-md) 0 0;
        transition: height 0.3s ease;
        position: relative;
        cursor: pointer;
    }

    .chart-bar.passed {
        background: linear-gradient(145deg, #06d6a0, #05b587);
    }

    .chart-bar.failed {
        background: linear-gradient(145deg, #ef476f, #d43f62);
    }

    .chart-bar:hover {
        transform: scale(1.05);
        box-shadow: var(--shadow-md);
    }

    .chart-bar:hover .chart-tooltip {
        opacity: 1;
        transform: translateY(-35px);
    }

    .chart-tooltip {
        position: absolute;
        top: -30px;
        left: 50%;
        transform: translateX(-50%) translateY(0);
        background: var(--dark-color);
        color: white;
        padding: 6px 12px;
        border-radius: var(--radius-md);
        font-size: 0.75rem;
        white-space: nowrap;
        opacity: 0;
        transition: all 0.3s ease;
        pointer-events: none;
        z-index: 10;
        box-shadow: var(--shadow-md);
    }

    .chart-tooltip::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 50%;
        transform: translateX(-50%);
        width: 0;
        height: 0;
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-top: 5px solid var(--dark-color);
    }

    .chart-label {
        font-size: 0.8rem;
        color: var(--gray-color);
        text-align: center;
        max-width: 80px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* Filter Section */
    .filter-section {
        background: white;
        border-radius: var(--radius-lg);
        padding: 20px;
        margin-bottom: 25px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-color);
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        align-items: center;
    }

    .filter-group {
        display: flex;
        align-items: center;
        gap: 10px;
        flex: 1;
        min-width: 200px;
    }

    .filter-icon {
        width: 35px;
        height: 35px;
        background: linear-gradient(145deg, #f8f9fa, #e9ecef);
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-color);
        font-size: 1rem;
    }

    .filter-select {
        flex: 1;
        padding: 10px 15px;
        border: 2px solid var(--border-color);
        border-radius: var(--radius-md);
        font-size: 0.95rem;
        background: white;
        cursor: pointer;
        transition: all 0.3s ease;
        color: var(--dark-color);
    }

    .filter-select:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1);
    }

    .filter-search {
        flex: 2;
        position: relative;
        min-width: 250px;
    }

    .filter-search input {
        width: 100%;
        padding: 10px 15px 10px 40px;
        border: 2px solid var(--border-color);
        border-radius: var(--radius-md);
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: white;
    }

    .filter-search input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1);
    }

    .filter-search i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gray-color);
    }

    /* Table Card */
    .table-card {
        background: white;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-lg);
        border: 1px solid var(--border-color);
        overflow: hidden;
    }

    .table-header {
        padding: 20px 25px;
        background: linear-gradient(145deg, #ffffff, #fafafa);
        border-bottom: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }

    .table-header h3 {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--dark-color);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .table-header i {
        width: 35px;
        height: 35px;
        background: var(--gradient-1);
        color: white;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        box-shadow: var(--shadow-sm);
    }

    .export-btn {
        padding: 8px 20px;
        background: transparent;
        color: var(--primary-color);
        border: 2px solid var(--primary-color);
        border-radius: var(--radius-full);
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .export-btn:hover {
        background: var(--primary-color);
        color: white;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .export-btn i {
        transition: transform 0.3s ease;
    }

    .export-btn:hover i {
        transform: translateY(-2px);
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
        background: linear-gradient(145deg, #f8f9fa, #f1f3f5);
    }

    .quiz-table th {
        padding: 18px 20px;
        text-align: left;
        font-weight: 700;
        color: var(--dark-color);
        font-size: 0.95rem;
        white-space: nowrap;
        border-bottom: 1px solid var(--border-color);
    }

    .quiz-table td {
        padding: 16px 20px;
        border-bottom: 1px solid var(--border-color);
        color: var(--gray-color);
        font-size: 0.95rem;
    }

    .quiz-table tbody tr {
        transition: all 0.3s ease;
    }

    .quiz-table tbody tr:hover {
        background: linear-gradient(145deg, #f8f9fa, #ffffff);
    }

    .quiz-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Quiz Info */
    .quiz-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .quiz-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(145deg, #f8f9fa, #e9ecef);
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-color);
        font-size: 1.2rem;
    }

    .quiz-details h4 {
        font-weight: 700;
        color: var(--dark-color);
        margin-bottom: 4px;
        font-size: 1rem;
    }

    .quiz-details span {
        font-size: 0.8rem;
        color: var(--gray-color);
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .quiz-details i {
        color: var(--primary-color);
        font-size: 0.75rem;
    }

    /* Attempt Badge */
    .attempt-badge {
        display: inline-block;
        padding: 4px 12px;
        background: linear-gradient(145deg, #f8f9fa, #e9ecef);
        border-radius: var(--radius-full);
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--primary-color);
    }

    /* Score Styles */
    .score-wrapper {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .score-circle {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        background: conic-gradient(from 0deg, var(--score-color) 0deg, var(--score-color) calc(var(--percentage) * 3.6deg), #e9ecef calc(var(--percentage) * 3.6deg));
    }

    .score-circle::before {
        content: '';
        position: absolute;
        width: 35px;
        height: 35px;
        background: white;
        border-radius: 50%;
    }

    .score-text {
        position: relative;
        z-index: 2;
        font-weight: 700;
        font-size: 0.8rem;
        color: var(--dark-color);
    }

    .score-percentage {
        font-weight: 700;
        color: var(--primary-color);
        font-size: 1rem;
    }

    /* Result Badge */
    .result-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 15px;
        border-radius: var(--radius-full);
        font-size: 0.85rem;
        font-weight: 600;
    }

    .result-badge.passed {
        background: rgba(6, 214, 160, 0.1);
        color: #06d6a0;
    }

    .result-badge.failed {
        background: rgba(239, 71, 111, 0.1);
        color: #ef476f;
    }

    .result-badge i {
        font-size: 0.8rem;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        background: transparent;
        color: var(--primary-color);
        border: 2px solid var(--primary-color);
        border-radius: var(--radius-full);
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .action-btn:hover {
        background: var(--primary-color);
        color: white;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .retry-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        background: linear-gradient(145deg, #06d6a0, #05b587);
        color: white;
        border: none;
        border-radius: var(--radius-full);
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-sm);
    }

    .retry-btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-hover);
    }

    .retry-btn i {
        transition: transform 0.3s ease;
    }

    .retry-btn:hover i {
        transform: rotate(180deg);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 30px;
        background: white;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-color);
    }

    .empty-icon {
        width: 100px;
        height: 100px;
        background: linear-gradient(145deg, #f8f9fa, #e9ecef);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px;
        font-size: 3rem;
        color: var(--gray-color);
        animation: float 6s ease-in-out infinite;
    }

    .empty-title {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--dark-color);
        margin-bottom: 10px;
    }

    .empty-text {
        color: var(--gray-color);
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
        color: white;
        border-radius: var(--radius-full);
        text-decoration: none;
        font-weight: 700;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-md);
    }

    .empty-btn:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-hover);
        color: white;
    }

    .empty-btn i {
        transition: transform 0.3s ease;
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
        background: white;
        border: 2px solid var(--border-color);
        border-radius: var(--radius-md);
        color: var(--dark-color);
        text-decoration: none;
        transition: all 0.3s ease;
        font-weight: 600;
    }

    .pagination .page-link:hover {
        background: var(--gradient-1);
        color: white;
        border-color: transparent;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .pagination .page-item.active .page-link {
        background: var(--gradient-1);
        color: white;
        border-color: transparent;
    }

    .pagination .page-item.disabled .page-link {
        background: var(--light-color);
        color: var(--gray-color);
        pointer-events: none;
        border-color: var(--border-color);
        opacity: 0.6;
    }

    /* Animations */
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
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
        .quizzes-wrapper {
            padding: 20px;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 992px) {
        .quizzes-wrapper {
            flex-direction: column;
            padding: 20px;
        }
        
        .quizzes-sidebar {
            width: 100%;
            margin-bottom: 20px;
        }
        
        .page-title {
            font-size: 1.8rem;
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

        .filter-group {
            width: 100%;
        }

        .filter-search {
            width: 100%;
        }

        .table-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .quiz-table th,
        .quiz-table td {
            padding: 12px 15px;
        }

        .action-buttons {
            flex-direction: column;
        }

        .action-btn, .retry-btn {
            width: 100%;
            justify-content: center;
        }

        .chart-container {
            height: 150px;
        }

        .chart-label {
            font-size: 0.7rem;
        }
    }

    @media (max-width: 576px) {
        .quizzes-wrapper {
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

        .stats-badge {
            width: 100%;
            justify-content: center;
        }

        .empty-title {
            font-size: 1.5rem;
        }

        .empty-text {
            font-size: 1rem;
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
            <div class="stat-card" style="--stat-gradient: linear-gradient(135deg, #4361ee, #3a0ca3);">
                <div class="stat-icon">
                    <i class="fas fa-puzzle-piece"></i>
                </div>
                <div class="stat-value">{{ $totalQuizzes ?? 0 }}</div>
                <div class="stat-label">{{ App\Helpers\TranslationHelper::trans('my-quizzes.stats_quizzes_taken') }}</div>
            </div>

            <div class="stat-card" style="--stat-gradient: linear-gradient(135deg, #06d6a0, #1b9e6d);">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-value">{{ $passedQuizzes ?? 0 }}</div>
                <div class="stat-label">{{ App\Helpers\TranslationHelper::trans('my-quizzes.stats_passed') }}</div>
            </div>

            <div class="stat-card" style="--stat-gradient: linear-gradient(135deg, #f72585, #b5179e);">
                <div class="stat-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="stat-value">{{ $averageScore ?? 0 }}%</div>
                <div class="stat-label">{{ App\Helpers\TranslationHelper::trans('my-quizzes.stats_avg_score') }}</div>
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
                                <div class="chart-bar {{ $attempt->passed ? 'passed' : 'failed' }}" 
                                     style="height: {{ $attempt->percentage }}px"
                                     data-score="{{ $attempt->percentage }}%">
                                    <div class="chart-tooltip">
                                        {!! App\Helpers\TranslationHelper::trans('my-quizzes.chart_tooltip', ['score' => $attempt->percentage, 'date' => \Carbon\Carbon::parse($attempt->created_at)->format('M d, Y')]) !!}
                                    </div>
                                </div>
                            </div>
                            <span class="chart-label">{{ \Carbon\Carbon::parse($attempt->created_at)->format('M d') }}</span>
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
                                            <div class="score-circle" style="--percentage: {{ $attempt->percentage ?? 0 }}; --score-color: {{ $attempt->passed ? '#06d6a0' : '#ef476f' }};">
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
                        <td colspan="6" style="text-align: center; padding: 40px;">
                            <i class="fas fa-search" style="font-size: 2rem; color: var(--gray-color); margin-bottom: 10px;"></i>
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
                    tooltip.style.transform = 'translateY(-35px)';
                }
            });
            
            bar.addEventListener('mouseleave', function() {
                const tooltip = this.querySelector('.chart-tooltip');
                if (tooltip) {
                    tooltip.style.opacity = '0';
                    tooltip.style.transform = 'translateY(0)';
                }
            });
        });

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

        const buttons = document.querySelectorAll('.action-btn, .retry-btn, .empty-btn, .export-btn');
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

        // Observe elements
        document.querySelectorAll('.stat-card, .chart-card, .filter-section, .table-card').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
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