@extends('layouts.main')

@section('title', 'Dashboard - EDUCONECX | Your Learning Hub')

@section('meta_description', 'Access your courses, track your progress, and manage your learning journey on your EDUCONECX dashboard.')

@push('styles')
<style>
    /* ===== DASHBOARD VARIABLES ===== */
    :root {
        --sidebar-width: 280px;
        --header-height: 80px; /* Match your header height */
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

    /* ===== DASHBOARD LAYOUT ===== */
    .dashboard-wrapper {
        flex: 1;
        display: flex;
        width: 100%;
        max-width: 1400px;
        margin: 0 auto;
        padding: 30px;
        gap: 30px;
    }

    /* ===== SIDEBAR STYLES - NOW FULLY STATIC ===== */
    .dashboard-sidebar {
        width: var(--sidebar-width);
        background: var(--card-bg);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-lg);
        overflow: hidden;
        height: fit-content;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
        /* Removed position: sticky - now fully static */
    }

    .dashboard-sidebar::-webkit-scrollbar {
        width: 5px;
    }

    .dashboard-sidebar::-webkit-scrollbar-track {
        background: var(--border-color);
    }

    .dashboard-sidebar::-webkit-scrollbar-thumb {
        background: var(--primary-color);
        border-radius: var(--radius-full);
    }

    /* Sidebar Header */
    .sidebar-header {
        padding: 25px 20px;
        background: var(--gradient-1);
        position: relative;
        overflow: hidden;
    }

    .sidebar-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 70%);
        animation: rotate 20s linear infinite;
    }

    .logo-area {
        position: relative;
        z-index: 2;
        text-align: center;
    }

    .logo-text {
        font-size: 1.6rem;
        font-weight: 800;
        color: white;
        text-shadow: 2px 2px 10px rgba(0,0,0,0.2);
        letter-spacing: 1px;
    }

    .logo-subtitle {
        color: rgba(255,255,255,0.8);
        font-size: 0.8rem;
        margin-top: 5px;
    }

    /* Profile Section */
    .profile-section {
        padding: 20px 20px;
        text-align: center;
        border-bottom: 1px solid var(--border-color);
        background: linear-gradient(145deg, #ffffff, #fafafa);
    }

    .avatar-wrapper {
        width: 90px;
        height: 90px;
        margin: 0 auto 12px;
        position: relative;
        cursor: pointer;
    }

    .avatar-image {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid white;
        box-shadow: var(--shadow-md);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .avatar-placeholder {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        background: var(--gradient-1);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
        font-weight: 700;
        margin: 0 auto 12px;
        border: 3px solid white;
        box-shadow: var(--shadow-md);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-transform: uppercase;
    }

    .avatar-wrapper:hover .avatar-image,
    .avatar-wrapper:hover .avatar-placeholder {
        transform: scale(1.1) rotate(5deg);
        box-shadow: var(--shadow-hover);
    }

    .profile-name {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--dark-color);
        margin-bottom: 4px;
    }

    .profile-email {
        font-size: 0.8rem;
        color: var(--gray-color);
        margin-bottom: 12px;
        word-break: break-word;
    }

    .edit-profile-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 18px;
        background: var(--gradient-1);
        color: white;
        border-radius: var(--radius-full);
        font-size: 0.85rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-sm);
    }

    .edit-profile-link:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-hover);
        color: white;
    }

    .edit-profile-link i {
        font-size: 0.85rem;
        transition: transform 0.3s ease;
    }

    .edit-profile-link:hover i {
        transform: rotate(15deg);
    }

    /* Navigation Menu */
    .sidebar-nav {
        padding: 15px 12px;
    }

    .nav-section {
        margin-bottom: 20px;
    }

    .nav-section-title {
        padding: 0 12px;
        margin-bottom: 8px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--gray-color);
    }

    .nav-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        border-radius: var(--radius-md);
        color: var(--gray-color);
        text-decoration: none;
        transition: all 0.3s ease;
        margin-bottom: 4px;
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
        font-size: 1rem;
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
        padding: 2px 6px;
        border-radius: var(--radius-full);
        font-size: 0.65rem;
        font-weight: 600;
    }

    .nav-item.active .nav-badge {
        background: rgba(255,255,255,0.2);
        color: white;
    }

    /* Main Content Area */
    .dashboard-main {
        flex: 1;
        min-width: 0; /* Prevent flex overflow */
    }

    /* Welcome Card */
    .welcome-card {
        background: var(--gradient-1);
        border-radius: var(--radius-xl);
        padding: 30px 40px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-lg);
    }

    .welcome-card::before {
        content: '';
        position: absolute;
        top: -30%;
        right: -5%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 8s ease-in-out infinite;
    }

    .welcome-card::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -2%;
        width: 250px;
        height: 250px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite reverse;
    }

    .welcome-content {
        position: relative;
        z-index: 2;
    }

    .welcome-title {
        font-size: 2.2rem;
        font-weight: 800;
        color: white;
        margin-bottom: 10px;
        text-shadow: 2px 2px 20px rgba(0,0,0,0.2);
    }

    .welcome-text {
        font-size: 1.1rem;
        color: rgba(255,255,255,0.95);
        max-width: 600px;
        line-height: 1.6;
        text-shadow: 1px 1px 10px rgba(0,0,0,0.1);
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
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

    /* Content Cards */
    .content-card {
        background: white;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        margin-bottom: 30px;
        overflow: hidden;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .content-card:hover {
        box-shadow: var(--shadow-lg);
    }

    .card-header {
        padding: 20px 25px;
        background: linear-gradient(145deg, #ffffff, #fafafa);
        border-bottom: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }

    .card-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--dark-color);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-title i {
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

    .view-link {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 600;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 5px;
        transition: all 0.3s ease;
        padding: 8px 16px;
        border-radius: var(--radius-full);
        background: rgba(67, 97, 238, 0.1);
    }

    .view-link:hover {
        background: var(--primary-color);
        color: white;
        gap: 10px;
    }

    .view-link i {
        transition: transform 0.3s ease;
    }

    .view-link:hover i {
        transform: translateX(5px);
    }

    /* Course Items */
    .course-item {
        padding: 20px 25px;
        border-bottom: 1px solid var(--border-color);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .course-item::before {
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

    .course-item:hover::before {
        transform: scaleY(1);
    }

    .course-item:last-child {
        border-bottom: none;
    }

    .course-item:hover {
        background: linear-gradient(145deg, #f8f9fa, #ffffff);
        padding-left: 35px;
    }

    .course-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .course-info {
        flex: 1;
        min-width: 250px;
    }

    .course-title {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .course-title a {
        color: var(--dark-color);
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .course-title a:hover {
        color: var(--primary-color);
    }

    .course-meta {
        display: flex;
        gap: 15px;
        color: var(--gray-color);
        font-size: 0.85rem;
        flex-wrap: wrap;
    }

    .course-meta span {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .course-meta i {
        color: var(--primary-color);
        font-size: 0.9rem;
    }

    .progress-wrapper {
        min-width: 200px;
    }

    .progress-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 5px;
        font-size: 0.85rem;
    }

    .progress-label {
        color: var(--gray-color);
    }

    .progress-percent {
        font-weight: 700;
        color: var(--primary-color);
    }

    .progress-track {
        height: 6px;
        background: var(--border-color);
        border-radius: var(--radius-full);
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: var(--gradient-1);
        border-radius: var(--radius-full);
        transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .progress-fill::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        animation: shimmer 2s infinite;
    }

    .continue-link {
        padding: 8px 20px;
        background: var(--gradient-1);
        color: white;
        border-radius: var(--radius-full);
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        white-space: nowrap;
        box-shadow: var(--shadow-sm);
    }

    .continue-link:hover {
        transform: translateX(5px);
        box-shadow: var(--shadow-hover);
        color: white;
    }

    .continue-link i {
        transition: transform 0.3s ease;
    }

    .continue-link:hover i {
        transform: translateX(3px);
    }

    /* Quiz Items */
    .quiz-item {
        padding: 15px 25px;
        border-bottom: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .quiz-item:last-child {
        border-bottom: none;
    }

    .quiz-item:hover {
        background: linear-gradient(145deg, #f8f9fa, #ffffff);
    }

    .quiz-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }

    .quiz-info h4 {
        font-size: 1rem;
        font-weight: 700;
        margin-bottom: 5px;
        color: var(--dark-color);
    }

    .quiz-date {
        color: var(--gray-color);
        font-size: 0.8rem;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .quiz-score {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .score-badge {
        padding: 4px 12px;
        border-radius: var(--radius-full);
        font-size: 0.85rem;
        font-weight: 600;
    }

    .score-badge.passed {
        background: linear-gradient(145deg, #06d6a0, #05b587);
        color: white;
        box-shadow: 0 3px 10px rgba(6,214,160,0.3);
    }

    .score-badge.failed {
        background: linear-gradient(145deg, #ef476f, #d43f62);
        color: white;
        box-shadow: 0 3px 10px rgba(239,71,111,0.3);
    }

    .score-value {
        font-weight: 700;
        color: var(--dark-color);
        background: linear-gradient(145deg, #f8f9fa, #e9ecef);
        padding: 5px 12px;
        border-radius: var(--radius-md);
    }

    /* Course Grid */
    .course-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        padding: 20px;
    }

    .course-card {
        background: white;
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid var(--border-color);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .course-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-hover);
    }

    .card-image {
        position: relative;
        overflow: hidden;
        aspect-ratio: 16/9;
    }

    .card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .course-card:hover .card-image img {
        transform: scale(1.1);
    }

    .card-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        padding: 4px 12px;
        background: var(--gradient-1);
        color: white;
        border-radius: var(--radius-full);
        font-size: 0.7rem;
        font-weight: 600;
        z-index: 2;
        box-shadow: var(--shadow-sm);
    }

    .card-body {
        padding: 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .card-body h3 {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 10px;
        line-height: 1.4;
    }

    .card-body h3 a {
        color: var(--dark-color);
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .card-body h3 a:hover {
        color: var(--primary-color);
    }

    .card-excerpt {
        color: var(--gray-color);
        font-size: 0.9rem;
        line-height: 1.6;
        margin-bottom: 15px;
        flex: 1;
    }

    .card-footer {
        padding: 0 20px 20px;
    }

    .card-btn {
        display: block;
        padding: 10px;
        background: transparent;
        color: var(--primary-color);
        border: 2px solid var(--primary-color);
        border-radius: var(--radius-full);
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 600;
        text-align: center;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        z-index: 1;
    }

    .card-btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: var(--gradient-1);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
        z-index: -1;
    }

    .card-btn:hover {
        color: white;
        border-color: transparent;
    }

    .card-btn:hover::before {
        width: 300px;
        height: 300px;
    }

    /* Empty States */
    .empty-state {
        padding: 50px 30px;
        text-align: center;
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(145deg, #f8f9fa, #e9ecef);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 2rem;
        color: var(--gray-color);
        transition: all 0.3s ease;
    }

    .empty-state:hover .empty-icon {
        transform: scale(1.1) rotate(5deg);
        background: var(--gradient-1);
        color: white;
    }

    .empty-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--dark-color);
        margin-bottom: 10px;
    }

    .empty-text {
        color: var(--gray-color);
        margin-bottom: 20px;
        max-width: 300px;
        margin-left: auto;
        margin-right: auto;
    }

    .empty-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 25px;
        background: var(--gradient-1);
        color: white;
        border-radius: var(--radius-full);
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-md);
    }

    .empty-btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-hover);
        color: white;
    }

    .empty-btn i {
        transition: transform 0.3s ease;
    }

    .empty-btn:hover i {
        transform: translateX(5px);
    }

    /* Streak Card */
    .streak-card {
        background: linear-gradient(145deg, #f72585, #b5179e);
        border-radius: var(--radius-lg);
        padding: 30px;
        text-align: center;
        color: white;
    }

    .streak-icon {
        font-size: 3rem;
        margin-bottom: 15px;
        animation: pulse 2s infinite;
    }

    .streak-number {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 5px;
    }

    .streak-label {
        font-size: 1rem;
        opacity: 0.9;
    }

    /* Animations */
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }

    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    @keyframes shimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
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
        .dashboard-wrapper {
            padding: 20px;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .course-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 992px) {
        .dashboard-wrapper {
            flex-direction: column;
            padding: 20px;
        }
        
        .dashboard-sidebar {
            width: 100%;
            margin-bottom: 20px;
        }
        
        .welcome-title {
            font-size: 1.8rem;
        }
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .course-grid {
            grid-template-columns: 1fr;
        }
        
        .course-content {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .progress-wrapper {
            width: 100%;
        }
        
        .quiz-content {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .quiz-score {
            width: 100%;
            justify-content: space-between;
        }
        
        .card-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .welcome-card {
            padding: 25px;
        }
        
        .welcome-title {
            font-size: 1.5rem;
        }

        .welcome-text {
            font-size: 1rem;
        }
    }

    @media (max-width: 576px) {
        .dashboard-wrapper {
            padding: 15px;
        }

        .stat-card {
            padding: 20px;
        }

        .stat-value {
            font-size: 1.8rem;
        }

        .course-item {
            padding: 15px 20px;
        }

        .course-item:hover {
            padding-left: 25px;
        }

        .welcome-card {
            padding: 20px;
        }

        .welcome-title {
            font-size: 1.3rem;
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
    
    .mt-3 {
        margin-top: 15px;
    }
    
    .mb-3 {
        margin-bottom: 15px;
    }
    
    .p-4 {
        padding: 20px;
    }
</style>
@endpush

@section('content')
<div class="dashboard-wrapper">
    <!-- Sidebar - Now fully static (moves with page scroll) -->
    <aside class="dashboard-sidebar">
        <div class="sidebar-header">
            <div class="logo-area">
                <div class="logo-text">EDUCONECX</div>
                <div class="logo-subtitle">Learn • Connect • Grow</div>
            </div>
        </div>

        <div class="profile-section">
            <div class="avatar-wrapper">
                @if(Auth::user()->avatar)
                    <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" class="avatar-image">
                @else
                    <div class="avatar-placeholder">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif
            </div>
            
            <h3 class="profile-name">{{ Auth::user()->name }}</h3>
            <p class="profile-email">{{ Auth::user()->email }}</p>
            
            <a href="{{ route('profile') }}" class="edit-profile-link">
                <i class="fas fa-user-edit"></i>
                Edit Profile
            </a>
        </div>

        <div class="sidebar-nav">
            <div class="nav-section">
                <div class="nav-section-title">Main</div>
                <a href="{{ route('dashboard') }}" class="nav-item active">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('my-courses') }}" class="nav-item">
                    <i class="fas fa-book"></i>
                    <span>My Courses</span>
                    @if(($stats['enrolled_courses'] ?? 0) > 0)
                        <span class="nav-badge">{{ $stats['enrolled_courses'] }}</span>
                    @endif
                </a>
                <a href="{{ route('my-quizzes') }}" class="nav-item">
                    <i class="fas fa-question-circle"></i>
                    <span>My Quizzes</span>
                    @if(($stats['quizzes_taken'] ?? 0) > 0)
                        <span class="nav-badge">{{ $stats['quizzes_taken'] }}</span>
                    @endif
                </a>
                <a href="{{ route('certificates') }}" class="nav-item">
                    <i class="fas fa-certificate"></i>
                    <span>Certificates</span>
                    @if(($stats['certificates_earned'] ?? 0) > 0)
                        <span class="nav-badge">{{ $stats['certificates_earned'] }}</span>
                    @endif
                </a>
            </div>

            <div class="nav-section">
                <div class="nav-section-title">Learning</div>
                <a href="{{ route('courses') }}" class="nav-item">
                    <i class="fas fa-search"></i>
                    <span>Browse Courses</span>
                </a>
            </div>

            <div class="nav-section">
                <div class="nav-section-title">Account</div>
                <a href="{{ route('logout') }}" class="nav-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="dashboard-main">
        <!-- Welcome Card -->
        <div class="welcome-card">
            <div class="welcome-content">
                <h1 class="welcome-title">
                    @php
                        $hour = date('H');
                        if($hour < 12) $greeting = 'Good Morning';
                        elseif($hour < 18) $greeting = 'Good Afternoon';
                        else $greeting = 'Good Evening';
                    @endphp
                    {{ $greeting }}, {{ Auth::user()->first_name ?? Auth::user()->name }}! 👋
                </h1>
                <p class="welcome-text">
                    Here's what's happening with your learning journey today. 
                    You're making great progress!
                </p>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card" style="--stat-gradient: linear-gradient(135deg, #4361ee, #3a0ca3);">
                <div class="stat-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <div class="stat-value">{{ $stats['enrolled_courses'] ?? 0 }}</div>
                <div class="stat-label">Enrolled Courses</div>
            </div>

            <div class="stat-card" style="--stat-gradient: linear-gradient(135deg, #06d6a0, #1b9e6d);">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-value">{{ $stats['completed_courses'] ?? 0 }}</div>
                <div class="stat-label">Completed Courses</div>
            </div>

            <div class="stat-card" style="--stat-gradient: linear-gradient(135deg, #4cc9f0, #4895ef);">
                <div class="stat-icon">
                    <i class="fas fa-puzzle-piece"></i>
                </div>
                <div class="stat-value">{{ $stats['quizzes_taken'] ?? 0 }}</div>
                <div class="stat-label">Quizzes Taken</div>
            </div>

            <div class="stat-card" style="--stat-gradient: linear-gradient(135deg, #f72585, #b5179e);">
                <div class="stat-icon">
                    <i class="fas fa-award"></i>
                </div>
                <div class="stat-value">{{ $stats['certificates_earned'] ?? 0 }}</div>
                <div class="stat-label">Certificates</div>
            </div>
        </div>

        <!-- Recent Courses -->
        <div class="content-card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-clock"></i>
                    Continue Learning
                </h2>
                @if(($recentCourses ?? collect())->count() > 0)
                    <a href="{{ route('my-courses') }}" class="view-link">
                        View All <i class="fas fa-arrow-right"></i>
                    </a>
                @endif
            </div>

            @if(($recentCourses ?? collect())->count() > 0)
                <div class="course-list">
                    @foreach($recentCourses as $enrollment)
                        <div class="course-item">
                            <div class="course-content">
                                <div class="course-info">
                                    <h3 class="course-title">
                                        <a href="{{ route('courses.learn', $enrollment->course->slug ?? '#') }}">
                                            {{ $enrollment->course->title ?? 'Course Title' }}
                                        </a>
                                    </h3>
                                    <div class="course-meta">
                                        <span>
                                            <i class="fas fa-signal"></i>
                                            {{ $enrollment->course->level ?? 'All Levels' }}
                                        </span>
                                        <span>
                                            <i class="fas fa-video"></i>
                                            {{ $enrollment->course->lessons_count ?? 12 }} Lessons
                                        </span>
                                        @if(isset($enrollment->course->duration))
                                        <span>
                                            <i class="fas fa-clock"></i>
                                            {{ $enrollment->course->duration }}
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="progress-wrapper">
                                    <div class="progress-header">
                                        <span class="progress-label">Progress</span>
                                        <span class="progress-percent">{{ $enrollment->progress ?? 0 }}%</span>
                                    </div>
                                    <div class="progress-track">
                                        <div class="progress-fill" style="width: {{ $enrollment->progress ?? 0 }}%"></div>
                                    </div>
                                </div>
                                <a href="{{ route('courses.learn', $enrollment->course->slug ?? '#') }}" class="continue-link">
                                    Continue <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <h3 class="empty-title">No courses yet</h3>
                    <p class="empty-text">Start your learning journey by enrolling in a course today!</p>
                    <a href="{{ route('courses') }}" class="empty-btn">
                        Browse Courses <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            @endif
        </div>

        <!-- Recent Quiz Attempts -->
        <div class="content-card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-puzzle-piece"></i>
                    Recent Quiz Attempts
                </h2>
                @if(($recentQuizzes ?? collect())->count() > 0)
                    <a href="{{ route('my-quizzes') }}" class="view-link">
                        View All <i class="fas fa-arrow-right"></i>
                    </a>
                @endif
            </div>

            @if(($recentQuizzes ?? collect())->count() > 0)
                <div class="quiz-list">
                    @foreach($recentQuizzes as $attempt)
                        <div class="quiz-item">
                            <div class="quiz-content">
                                <div class="quiz-info">
                                    <h4>{{ $attempt->quiz->title ?? 'Quiz Title' }}</h4>
                                    <span class="quiz-date">
                                        <i class="far fa-calendar-alt"></i>
                                        {{ \Carbon\Carbon::parse($attempt->created_at ?? now())->format('M d, Y') }}
                                    </span>
                                </div>
                                <div class="quiz-score">
                                    <span class="score-badge {{ ($attempt->passed ?? false) ? 'passed' : 'failed' }}">
                                        {{ ($attempt->passed ?? false) ? 'Passed' : 'Failed' }}
                                    </span>
                                    <span class="score-value">{{ $attempt->percentage ?? 0 }}%</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-puzzle-piece"></i>
                    </div>
                    <h3 class="empty-title">No quiz attempts yet</h3>
                    <p class="empty-text">Test your knowledge by taking a quiz from your courses.</p>
                    <a href="{{ route('courses') }}" class="empty-btn">
                        Browse Quizzes <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            @endif
        </div>

        <!-- Recommended Courses -->
        <div class="content-card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-star"></i>
                    Recommended For You
                </h2>
            </div>

            @if(($recommendedCourses ?? collect())->count() > 0)
                <div class="course-grid">
                    @foreach($recommendedCourses as $course)
                        <div class="course-card">
                            <div class="card-image">
                                <img src="{{ $course->thumbnail_url ?? 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80' }}" 
                                     alt="{{ $course->title ?? 'Course' }}">
                                <span class="card-badge">{{ $course->category ?? 'Course' }}</span>
                            </div>
                            <div class="card-body">
                                <h3>
                                    <a href="{{ route('courses.show', $course->slug ?? '#') }}">
                                        {{ $course->title ?? 'Course Title' }}
                                    </a>
                                </h3>
                                <p class="card-excerpt">
                                    {{ Str::limit($course->excerpt ?? 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 80) }}
                                </p>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('courses.show', $course->slug ?? '#') }}" class="card-btn">
                                    View Course
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <h3 class="empty-title">No recommendations yet</h3>
                    <p class="empty-text">Complete more courses to get personalized recommendations.</p>
                    <a href="{{ route('courses') }}" class="empty-btn">
                        Explore Courses <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            @endif
        </div>

        <!-- Learning Streak -->
        @if(($streak ?? 0) > 0)
        <div class="streak-card">
            <div class="streak-icon">
                <i class="fas fa-fire"></i>
            </div>
            <div class="streak-number">{{ $streak }} Days</div>
            <div class="streak-label">Learning Streak</div>
            <p style="margin-top: 15px; opacity: 0.9;">Keep up the amazing work! 🔥</p>
        </div>
        @endif
    </main>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animate progress bars on scroll
        const progressBars = document.querySelectorAll('.progress-fill');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const width = entry.target.style.width;
                    entry.target.style.width = '0';
                    setTimeout(() => {
                        entry.target.style.width = width;
                    }, 100);
                }
            });
        }, { threshold: 0.5 });

        progressBars.forEach(bar => observer.observe(bar));

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

        const buttons = document.querySelectorAll('.continue-link, .card-btn, .empty-btn, .view-link');
        buttons.forEach(button => {
            button.classList.add('position-relative', 'overflow-hidden');
            button.addEventListener('click', createRipple);
        });

        // Add active class to current nav item
        const currentPath = window.location.pathname;
        const navItems = document.querySelectorAll('.nav-item');
        
        navItems.forEach(item => {
            const href = item.getAttribute('href');
            if (href && currentPath.includes(href) && href !== '#') {
                item.classList.add('active');
            }
        });
    });
</script>
@endpush