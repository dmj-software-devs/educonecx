@extends('layouts.main')

@section('title', App\Helpers\TranslationHelper::trans('dashboard.title'))

@section('meta_description', App\Helpers\TranslationHelper::trans('dashboard.meta_description'))

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

    /* ===== DASHBOARD LAYOUT ===== */
    .dashboard-wrapper {
        display: flex;
        width: 100%;
        max-width: 1400px;
        margin: 24px auto;
        padding: 0 24px;
        gap: 24px;
    }

    /* ===== SIDEBAR STYLES ===== */
    .dashboard-sidebar {
        width: 260px;
        background: var(--pure-white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        overflow: hidden;
        height: fit-content;
        border: 1px solid rgba(251, 198, 12, 0.1);
        transition: var(--transition);
    }

    .dashboard-sidebar::-webkit-scrollbar {
        width: 4px;
    }

    .dashboard-sidebar::-webkit-scrollbar-track {
        background: var(--pale-slate);
    }

    .dashboard-sidebar::-webkit-scrollbar-thumb {
        background: var(--bright-amber);
        border-radius: var(--radius-full);
    }

    /* Sidebar Header */
    .sidebar-header {
        padding: 20px 16px;
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
        background: radial-gradient(circle, rgba(251, 198, 12, 0.2) 0%, transparent 70%);
        animation: rotate 20s linear infinite;
    }

    .logo-area {
        position: relative;
        z-index: 2;
        text-align: center;
    }

    .logo-text {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--pure-white);
        text-shadow: 0 2px 4px rgba(10, 29, 68, 0.2);
        letter-spacing: 0.5px;
    }

    .logo-subtitle {
        color: var(--ivory);
        font-size: 0.7rem;
        margin-top: 4px;
        opacity: 0.9;
    }

    /* Profile Section */
    .profile-section {
        padding: 16px;
        text-align: center;
        border-bottom: 1px solid rgba(251, 198, 12, 0.1);
        background: linear-gradient(145deg, var(--pure-white), var(--ivory));
    }

    .avatar-wrapper {
        width: 70px;
        height: 70px;
        margin: 0 auto 10px;
        position: relative;
        cursor: pointer;
    }

    .avatar-image {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--pure-white);
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
    }

    .avatar-placeholder {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: var(--gradient-1);
        color: var(--pure-white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        font-weight: 600;
        margin: 0 auto 10px;
        border: 2px solid var(--pure-white);
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        text-transform: uppercase;
    }

    .avatar-wrapper:hover .avatar-image,
    .avatar-wrapper:hover .avatar-placeholder {
        transform: scale(1.05);
        box-shadow: var(--shadow-md);
    }

    .profile-name {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 2px;
    }

    .profile-email {
        font-size: 0.75rem;
        color: var(--text-muted);
        margin-bottom: 10px;
        word-break: break-word;
    }

    .edit-profile-link {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 5px 14px;
        background: var(--gradient-1);
        color: var(--pure-white);
        border-radius: var(--radius-full);
        font-size: 0.75rem;
        font-weight: 500;
        text-decoration: none;
        transition: var(--transition);
        box-shadow: var(--shadow-sm);
    }

    .edit-profile-link:hover {
        background: var(--gradient-2);
        color: var(--prussian-blue);
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
        text-decoration: none;
    }

    .edit-profile-link i {
        font-size: 0.7rem;
    }

    /* Navigation Menu */
    .sidebar-nav {
        padding: 12px 10px;
    }

    .nav-section {
        margin-bottom: 16px;
    }

    .nav-section-title {
        padding: 0 10px;
        margin-bottom: 6px;
        font-size: 0.65rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--text-muted);
    }

    .nav-item {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 10px;
        border-radius: var(--radius-md);
        color: var(--text-muted);
        text-decoration: none;
        transition: var(--transition);
        margin-bottom: 2px;
        font-size: 0.85rem;
    }

    .nav-item i {
        width: 18px;
        font-size: 0.9rem;
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
        padding: 2px 5px;
        border-radius: var(--radius-full);
        font-size: 0.6rem;
        font-weight: 500;
        color: var(--bright-amber);
    }

    .nav-item.active .nav-badge {
        background: rgba(255, 255, 255, 0.2);
        color: var(--pure-white);
    }

    /* Main Content Area */
    .dashboard-main {
        flex: 1;
        min-width: 0;
    }

    /* Welcome Card */
    .welcome-card {
        background: var(--gradient-1);
        border-radius: var(--radius-lg);
        padding: 24px 28px;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-md);
    }

    .welcome-card::before {
        content: '';
        position: absolute;
        top: -20%;
        right: -5%;
        width: 250px;
        height: 250px;
        background: rgba(251, 198, 12, 0.1);
        border-radius: 50%;
        animation: float 8s ease-in-out infinite;
    }

    .welcome-card::after {
        content: '';
        position: absolute;
        bottom: -20%;
        left: -2%;
        width: 200px;
        height: 200px;
        background: rgba(90, 209, 228, 0.1);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite reverse;
    }

    .welcome-content {
        position: relative;
        z-index: 2;
    }

    .welcome-title {
        font-size: clamp(1.3rem, 2.5vw, 1.8rem);
        font-weight: 700;
        color: var(--pure-white);
        margin-bottom: 6px;
        text-shadow: 0 2px 4px rgba(10, 29, 68, 0.2);
    }

    .welcome-text {
        font-size: 0.95rem;
        color: var(--ivory);
        max-width: 550px;
        line-height: 1.5;
        opacity: 0.95;
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
        padding: 18px;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        border: 1px solid rgba(251, 198, 12, 0.1);
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        border-color: var(--bright-amber);
    }

    .stat-icon {
        width: 44px;
        height: 44px;
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
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 2px;
        line-height: 1.2;
    }

    .stat-label {
        color: var(--text-muted);
        font-size: 0.8rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    /* Content Cards */
    .content-card {
        background: var(--pure-white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        margin-bottom: 24px;
        overflow: hidden;
        border: 1px solid rgba(251, 198, 12, 0.1);
        transition: var(--transition);
    }

    .content-card:hover {
        box-shadow: var(--shadow-md);
        border-color: var(--bright-amber);
    }

    .card-header {
        padding: 16px 20px;
        background: linear-gradient(145deg, var(--pure-white), var(--ivory));
        border-bottom: 1px solid rgba(251, 198, 12, 0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .card-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .card-title i {
        width: 32px;
        height: 32px;
        background: var(--gradient-1);
        color: var(--pure-white);
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        box-shadow: var(--shadow-sm);
    }

    .view-link {
        color: var(--bright-amber);
        text-decoration: none;
        font-weight: 500;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 4px;
        transition: var(--transition);
        padding: 5px 12px;
        border-radius: var(--radius-full);
        background: rgba(251, 198, 12, 0.1);
    }

    .view-link:hover {
        background: var(--gradient-1);
        color: var(--pure-white);
        gap: 6px;
        text-decoration: none;
    }

    .view-link i {
        transition: var(--transition);
        font-size: 0.75rem;
    }

    .view-link:hover i {
        transform: translateX(3px);
    }

    /* Course Items */
    .course-item {
        padding: 16px 20px;
        border-bottom: 1px solid rgba(251, 198, 12, 0.1);
        transition: var(--transition);
    }

    .course-item:last-child {
        border-bottom: none;
    }

    .course-item:hover {
        background: linear-gradient(145deg, var(--ivory), var(--pure-white));
    }

    .course-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
    }

    .course-info {
        flex: 1;
        min-width: 220px;
    }

    .course-title {
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .course-title a {
        color: var(--text-primary);
        text-decoration: none;
        transition: var(--transition);
    }

    .course-title a:hover {
        color: var(--bright-amber);
    }

    .course-meta {
        display: flex;
        gap: 12px;
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
        font-size: 0.7rem;
    }

    .progress-wrapper {
        min-width: 160px;
    }

    .progress-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 4px;
        font-size: 0.75rem;
    }

    .progress-label {
        color: var(--text-muted);
    }

    .progress-percent {
        font-weight: 600;
        color: var(--bright-amber);
    }

    .progress-track {
        height: 4px;
        background: var(--pale-slate);
        border-radius: var(--radius-full);
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: var(--gradient-1);
        border-radius: var(--radius-full);
        transition: width 0.4s ease;
    }

    .continue-link {
        padding: 6px 14px;
        background: var(--gradient-1);
        color: var(--pure-white);
        border-radius: var(--radius-full);
        text-decoration: none;
        font-size: 0.8rem;
        font-weight: 500;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 4px;
        white-space: nowrap;
        box-shadow: var(--shadow-sm);
        border: none;
        cursor: pointer;
    }

    .continue-link:hover {
        background: var(--gradient-2);
        color: var(--prussian-blue);
        transform: translateX(3px);
        box-shadow: var(--shadow-md);
        text-decoration: none;
    }

    .continue-link i {
        font-size: 0.7rem;
    }

    /* Quiz Items */
    .quiz-item {
        padding: 12px 20px;
        border-bottom: 1px solid rgba(251, 198, 12, 0.1);
        transition: var(--transition);
    }

    .quiz-item:last-child {
        border-bottom: none;
    }

    .quiz-item:hover {
        background: linear-gradient(145deg, var(--ivory), var(--pure-white));
    }

    .quiz-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .quiz-info h4 {
        font-size: 0.95rem;
        font-weight: 600;
        margin-bottom: 4px;
        color: var(--text-primary);
    }

    .quiz-date {
        color: var(--text-muted);
        font-size: 0.7rem;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .quiz-date i {
        font-size: 0.65rem;
        color: var(--bright-amber);
    }

    .quiz-score {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .score-badge {
        padding: 3px 10px;
        border-radius: var(--radius-full);
        font-size: 0.7rem;
        font-weight: 500;
    }

    .score-badge.passed {
        background: var(--gradient-3);
        color: var(--prussian-blue);
    }

    .score-badge.failed {
        background: var(--gradient-2);
        color: var(--prussian-blue);
    }

    .score-value {
        font-weight: 600;
        color: var(--text-primary);
        background: var(--ivory);
        padding: 3px 10px;
        border-radius: var(--radius-md);
        font-size: 0.8rem;
    }

    /* Course Grid */
    .course-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        padding: 16px;
    }

    .course-card {
        background: var(--pure-white);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        border: 1px solid rgba(251, 198, 12, 0.1);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .course-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
        border-color: var(--bright-amber);
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
        transition: transform 0.4s ease;
    }

    .course-card:hover .card-image img {
        transform: scale(1.05);
    }

    .card-badge {
        position: absolute;
        top: 8px;
        right: 8px;
        padding: 3px 10px;
        background: var(--gradient-2);
        color: var(--prussian-blue);
        border-radius: var(--radius-full);
        font-size: 0.65rem;
        font-weight: 600;
        z-index: 2;
        box-shadow: var(--shadow-sm);
    }

    .card-body {
        padding: 14px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .card-body h3 {
        font-size: 0.95rem;
        font-weight: 600;
        margin-bottom: 6px;
        line-height: 1.4;
    }

    .card-body h3 a {
        color: var(--text-primary);
        text-decoration: none;
        transition: var(--transition);
    }

    .card-body h3 a:hover {
        color: var(--bright-amber);
    }

    .card-excerpt {
        color: var(--text-muted);
        font-size: 0.8rem;
        line-height: 1.5;
        margin-bottom: 12px;
        flex: 1;
    }

    .card-footer {
        padding: 0 14px 14px;
    }

    .card-btn {
        display: block;
        padding: 7px;
        background: transparent;
        color: var(--bright-amber);
        border: 1px solid var(--bright-amber);
        border-radius: var(--radius-full);
        text-decoration: none;
        font-size: 0.8rem;
        font-weight: 500;
        text-align: center;
        transition: var(--transition);
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
        transition: width 0.4s, height 0.4s;
        z-index: -1;
    }

    .card-btn:hover {
        color: var(--pure-white);
        border-color: transparent;
        text-decoration: none;
    }

    .card-btn:hover::before {
        width: 250px;
        height: 250px;
    }

    /* Empty States */
    .empty-state {
        padding: 40px 24px;
        text-align: center;
    }

    .empty-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(145deg, var(--ivory), var(--pale-slate));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        font-size: 1.8rem;
        color: var(--text-muted);
        transition: var(--transition);
    }

    .empty-state:hover .empty-icon {
        transform: scale(1.05);
        background: var(--gradient-1);
        color: var(--pure-white);
    }

    .empty-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 6px;
    }

    .empty-text {
        color: var(--text-muted);
        margin-bottom: 16px;
        font-size: 0.85rem;
        max-width: 280px;
        margin-left: auto;
        margin-right: auto;
    }

    .empty-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 20px;
        background: var(--gradient-1);
        color: var(--pure-white);
        border-radius: var(--radius-full);
        text-decoration: none;
        font-weight: 500;
        font-size: 0.85rem;
        transition: var(--transition);
        box-shadow: var(--shadow-sm);
        border: none;
        cursor: pointer;
    }

    .empty-btn:hover {
        background: var(--gradient-2);
        color: var(--prussian-blue);
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
        text-decoration: none;
    }

    .empty-btn i {
        font-size: 0.75rem;
    }

    /* Streak Card */
    .streak-card {
        background: var(--gradient-2);
        border-radius: var(--radius-lg);
        padding: 20px;
        text-align: center;
        color: var(--prussian-blue);
        border: 1px solid rgba(251, 198, 12, 0.3);
        margin-top: 20px;
    }

    .streak-icon {
        font-size: 2.2rem;
        margin-bottom: 8px;
        animation: pulse 2s infinite;
    }

    .streak-number {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 2px;
    }

    .streak-label {
        font-size: 0.85rem;
        opacity: 0.9;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .streak-card p {
        color: var(--prussian-blue);
        font-size: 0.8rem;
        margin-top: 10px;
        opacity: 0.9;
    }

    /* Animations */
    @keyframes float {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-15px);
        }
    }

    @keyframes rotate {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }

    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
        .dashboard-wrapper {
            padding: 0 20px;
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
            padding: 0 16px;
        }

        .dashboard-sidebar {
            width: 100%;
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
            padding: 20px;
        }

        .welcome-title {
            font-size: 1.2rem;
        }

        .welcome-text {
            font-size: 0.85rem;
        }
    }

    @media (max-width: 576px) {
        .dashboard-wrapper {
            padding: 0 12px;
        }

        .stat-card {
            padding: 14px;
        }

        .stat-value {
            font-size: 1.2rem;
        }

        .stat-icon {
            width: 38px;
            height: 38px;
            font-size: 1rem;
        }

        .card-header {
            padding: 14px 16px;
        }

        .card-title {
            font-size: 1rem;
        }

        .card-title i {
            width: 28px;
            height: 28px;
            font-size: 0.8rem;
        }

        .course-item {
            padding: 14px 16px;
        }

        .quiz-item {
            padding: 10px 16px;
        }

        .empty-icon {
            width: 60px;
            height: 60px;
            font-size: 1.5rem;
        }

        .empty-title {
            font-size: 0.95rem;
        }

        .empty-text {
            font-size: 0.8rem;
        }

        .streak-card {
            padding: 16px;
        }

        .streak-number {
            font-size: 1.8rem;
        }

        .streak-icon {
            font-size: 2rem;
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
        margin-top: 12px;
    }

    .mb-3 {
        margin-bottom: 12px;
    }

    .p-4 {
        padding: 16px;
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
                <div class="logo-subtitle">{{ App\Helpers\TranslationHelper::trans('dashboard.logo_subtitle') }}</div>
            </div>
        </div>

        <div class="profile-section">
            <div class="avatar-wrapper">
                @if(Auth::user()->avatar)
                <img src="{{ Storage::url(Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="avatar-image">
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
                {{ App\Helpers\TranslationHelper::trans('dashboard.edit_profile') }}
            </a>
        </div>

        <div class="sidebar-nav">
            <div class="nav-section">
                <div class="nav-section-title">{{ App\Helpers\TranslationHelper::trans('dashboard.nav_main') }}</div>
                <a href="{{ route('dashboard') }}" class="nav-item active">
                    <i class="fas fa-home"></i>
                    <span>{{ App\Helpers\TranslationHelper::trans('dashboard.nav_dashboard') }}</span>
                </a>
                <a href="{{ route('my-courses') }}" class="nav-item">
                    <i class="fas fa-book"></i>
                    <span>{{ App\Helpers\TranslationHelper::trans('dashboard.nav_my_courses') }}</span>
                    @if(($stats['enrolled_courses'] ?? 0) > 0)
                    <span class="nav-badge">{{ $stats['enrolled_courses'] }}</span>
                    @endif
                </a>
                <a href="{{ route('my-quizzes') }}" class="nav-item">
                    <i class="fas fa-question-circle"></i>
                    <span>{{ App\Helpers\TranslationHelper::trans('dashboard.nav_my_quizzes') }}</span>
                    @if(($stats['quizzes_taken'] ?? 0) > 0)
                    <span class="nav-badge">{{ $stats['quizzes_taken'] }}</span>
                    @endif
                </a>
                <a href="{{ route('certificates') }}" class="nav-item">
                    <i class="fas fa-certificate"></i>
                    <span>{{ App\Helpers\TranslationHelper::trans('dashboard.nav_certificates') }}</span>
                    @if(($stats['certificates_earned'] ?? 0) > 0)
                    <span class="nav-badge">{{ $stats['certificates_earned'] }}</span>
                    @endif
                </a>
            </div>

            <div class="nav-section">
                <div class="nav-section-title">{{ App\Helpers\TranslationHelper::trans('dashboard.nav_learning') }}</div>
                <a href="{{ route('courses') }}" class="nav-item">
                    <i class="fas fa-search"></i>
                    <span>{{ App\Helpers\TranslationHelper::trans('dashboard.nav_browse_courses') }}</span>
                </a>
            </div>

            <div class="nav-section">
                <div class="nav-section-title">{{ App\Helpers\TranslationHelper::trans('dashboard.nav_account') }}</div>
                <a href="{{ route('profile') }}" class="nav-item">
                    <i class="fas fa-cog"></i>
                    <span>{{ App\Helpers\TranslationHelper::trans('dashboard.nav_settings') }}</span>
                </a>
                <a href="{{ route('logout') }}" class="nav-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>{{ App\Helpers\TranslationHelper::trans('dashboard.nav_logout') }}</span>
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
                    if($hour < 12) $greeting = App\Helpers\TranslationHelper::trans('dashboard.greeting_morning');
                        elseif($hour < 18) $greeting = App\Helpers\TranslationHelper::trans('dashboard.greeting_afternoon');
                        else $greeting = App\Helpers\TranslationHelper::trans('dashboard.greeting_evening');
                        @endphp
                        {{ $greeting }}, {{ Auth::user()->first_name ?? Auth::user()->name }}! 👋
                        </h1>
                        <p class="welcome-text">
                            {{ App\Helpers\TranslationHelper::trans('dashboard.welcome_text') }}
                        </p>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card" style="--stat-gradient: linear-gradient(135deg, #0A1D44, #18386E);">
                <div class="stat-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $stats['enrolled_courses'] ?? 0 }}</div>
                    <div class="stat-label">{{ App\Helpers\TranslationHelper::trans('dashboard.stat_enrolled') }}</div>
                </div>
            </div>

            <div class="stat-card" style="--stat-gradient: linear-gradient(135deg, #5AD1E4, #2E5C61);">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $stats['completed_courses'] ?? 0 }}</div>
                    <div class="stat-label">{{ App\Helpers\TranslationHelper::trans('dashboard.stat_completed') }}</div>
                </div>
            </div>

            <div class="stat-card" style="--stat-gradient: linear-gradient(135deg, #FBC60C, #EBD789);">
                <div class="stat-icon">
                    <i class="fas fa-puzzle-piece"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $stats['quizzes_taken'] ?? 0 }}</div>
                    <div class="stat-label">{{ App\Helpers\TranslationHelper::trans('dashboard.stat_quizzes') }}</div>
                </div>
            </div>

            <div class="stat-card" style="--stat-gradient: linear-gradient(135deg, #2E5C61, #18386E);">
                <div class="stat-icon">
                    <i class="fas fa-award"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $stats['certificates_earned'] ?? 0 }}</div>
                    <div class="stat-label">{{ App\Helpers\TranslationHelper::trans('dashboard.stat_certificates') }}</div>
                </div>
            </div>
        </div>

        <!-- Recent Courses -->
        <div class="content-card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-clock"></i>
                    {{ App\Helpers\TranslationHelper::trans('dashboard.recent_title') }}
                </h2>
                @if(($recentCourses ?? collect())->count() > 0)
                <a href="{{ route('my-courses') }}" class="view-link">
                    {{ App\Helpers\TranslationHelper::trans('dashboard.view_all') }} <i class="fas fa-arrow-right"></i>
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
                                    {{ App\Helpers\TranslationHelper::trans('dashboard.course_level', ['level' => $enrollment->course->level ?? 'All Levels']) }}
                                </span>
                                <span>
                                    <i class="fas fa-video"></i>
                                    {{ App\Helpers\TranslationHelper::trans('dashboard.course_lessons', ['count' => $enrollment->course->lessons_count ?? 12]) }}
                                </span>
                                @if(isset($enrollment->course->duration))
                                <span>
                                    <i class="fas fa-clock"></i>
                                    {{ App\Helpers\TranslationHelper::trans('dashboard.course_duration', ['duration' => $enrollment->course->duration]) }}
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="progress-wrapper">
                            <div class="progress-header">
                                <span class="progress-label">{{ App\Helpers\TranslationHelper::trans('dashboard.progress_label') }}</span>
                                <span class="progress-percent">{{ $enrollment->progress ?? 0 }}%</span>
                            </div>
                            <div class="progress-track">
                                <div class="progress-fill" style="width: {{ $enrollment->progress ?? 0 }}%"></div>
                            </div>
                        </div>
                        <a href="{{ route('courses.learn', $enrollment->course->slug ?? '#') }}" class="continue-link">
                            {{ App\Helpers\TranslationHelper::trans('dashboard.continue_btn') }} <i class="fas fa-arrow-right"></i>
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
                <h3 class="empty-title">{{ App\Helpers\TranslationHelper::trans('dashboard.empty_courses_title') }}</h3>
                <p class="empty-text">{{ App\Helpers\TranslationHelper::trans('dashboard.empty_courses_text') }}</p>
                <a href="{{ route('courses') }}" class="empty-btn">
                    {{ App\Helpers\TranslationHelper::trans('dashboard.empty_courses_btn') }} <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            @endif
        </div>

        <!-- Recent Quiz Attempts -->
        <div class="content-card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-puzzle-piece"></i>
                    {{ App\Helpers\TranslationHelper::trans('dashboard.quizzes_title') }}
                </h2>
                @if(($recentQuizzes ?? collect())->count() > 0)
                <a href="{{ route('my-quizzes') }}" class="view-link">
                    {{ App\Helpers\TranslationHelper::trans('dashboard.view_all') }} <i class="fas fa-arrow-right"></i>
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
                                {{ \Carbon\Carbon::parse($attempt->created_at ?? now())->format(App\Helpers\TranslationHelper::trans('dashboard.quiz_date')) }}
                            </span>
                        </div>
                        <div class="quiz-score">
                            <span class="score-badge {{ ($attempt->passed ?? false) ? 'passed' : 'failed' }}">
                                {{ ($attempt->passed ?? false) ? App\Helpers\TranslationHelper::trans('dashboard.quiz_passed') : App\Helpers\TranslationHelper::trans('dashboard.quiz_failed') }}
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
                <h3 class="empty-title">{{ App\Helpers\TranslationHelper::trans('dashboard.empty_quizzes_title') }}</h3>
                <p class="empty-text">{{ App\Helpers\TranslationHelper::trans('dashboard.empty_quizzes_text') }}</p>
                <a href="{{ route('courses') }}" class="empty-btn">
                    {{ App\Helpers\TranslationHelper::trans('dashboard.empty_quizzes_btn') }} <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            @endif
        </div>

        <!-- Recommended Courses -->
        <div class="content-card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-star"></i>
                    {{ App\Helpers\TranslationHelper::trans('dashboard.recommended_title') }}
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
                            {{ Str::limit($course->excerpt ?? 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 70) }}
                        </p>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('courses.show', $course->slug ?? '#') }}" class="card-btn">
                            {{ App\Helpers\TranslationHelper::trans('dashboard.recommended_btn') }}
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
                <h3 class="empty-title">{{ App\Helpers\TranslationHelper::trans('dashboard.empty_recommended_title') }}</h3>
                <p class="empty-text">{{ App\Helpers\TranslationHelper::trans('dashboard.empty_recommended_text') }}</p>
                <a href="{{ route('courses') }}" class="empty-btn">
                    {{ App\Helpers\TranslationHelper::trans('dashboard.empty_recommended_btn') }} <i class="fas fa-arrow-right"></i>
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
            <div class="streak-number">{{ App\Helpers\TranslationHelper::trans('dashboard.streak_days', ['count' => $streak]) }}</div>
            <div class="streak-label">{{ App\Helpers\TranslationHelper::trans('dashboard.streak_label') }}</div>
            <p>{{ App\Helpers\TranslationHelper::trans('dashboard.streak_message') }}</p>
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
                    }, 50);
                }
            });
        }, {
            threshold: 0.3
        });

        progressBars.forEach(bar => observer.observe(bar));

        // Add active class to current nav item
        const currentPath = window.location.pathname;
        const navItems = document.querySelectorAll('.nav-item');

        navItems.forEach(item => {
            if (item.getAttribute('href') === currentPath) {
                item.classList.add('active');
            }
        });
    });
</script>
@endpush