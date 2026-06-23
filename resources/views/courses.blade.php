@extends('layouts.main')

@section('title', App\Helpers\TranslationHelper::trans('courses.title'))

@section('meta_description', App\Helpers\TranslationHelper::trans('courses.meta_description'))

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
        
        /* Layout */
        --sidebar-width: 280px;
        --header-height: 80px;
        
        /* Transitions */
        --transition: all 0.3s ease;
        --transition-slow: all 0.5s ease;
    }

    /* Video Modal Styles */
    .video-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(10, 29, 68, 0.95);
        z-index: 10000;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(5px);
    }

    .video-modal.active {
        display: flex;
        animation: fadeIn 0.3s ease;
    }

    .video-modal-content {
        position: relative;
        width: 90%;
        max-width: 1000px;
        background: var(--pure-white);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-lg);
    }

    .video-modal-header {
        padding: 15px 20px;
        background: var(--gradient-1);
        color: var(--pure-white);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .video-modal-header h3 {
        font-size: 1.1rem;
        margin: 0;
        font-weight: 600;
    }

    .video-modal-close {
        background: none;
        border: none;
        color: var(--pure-white);
        font-size: 1.2rem;
        cursor: pointer;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition);
    }

    .video-modal-close:hover {
        background: rgba(255,255,255,0.2);
        transform: rotate(90deg);
    }

    .video-modal-body {
        position: relative;
        padding-top: 56.25%; /* 16:9 Aspect Ratio */
        background: #000;
    }

    .video-modal-body video {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .video-modal-footer {
        padding: 15px 20px;
        background: var(--ivory);
        color: var(--text-muted);
        font-size: 0.9rem;
    }

    .course-preview {
        color: var(--pure-white);
        font-size: 0.9rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        background: rgba(251, 198, 12, 0.2);
        border-radius: var(--radius-full);
        backdrop-filter: blur(5px);
        border: 1px solid rgba(251, 198, 12, 0.3);
        transition: var(--transition);
    }

    .course-preview:hover {
        background: var(--bright-amber);
        color: var(--prussian-blue);
        transform: translateX(5px);
    }

    .course-preview i {
        font-size: 1rem;
        margin-right: 5px;
    }

    .course-preview.disabled {
        opacity: 0.5;
        cursor: not-allowed;
        background: rgba(0,0,0,0.3);
        border-color: transparent;
        pointer-events: none;
    }

    .course-preview.disabled:hover {
        transform: none;
        background: rgba(0,0,0,0.3);
        color: var(--pure-white);
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
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

    /* ===== BASE STYLES ===== */
    body {
        background: linear-gradient(135deg, var(--ivory) 0%, var(--pure-white) 100%);
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        color: var(--text-primary);
    }

    main {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    /* ===== HERO SECTION ===== */
    .courses-hero {
        position: relative;
        background: var(--gradient-1);
        padding: 80px 0;
        overflow: hidden;
        color: var(--pure-white);
    }

    @media (max-width: 768px) {
        .courses-hero {
            padding: 60px 0;
        }
    }

    @media (max-width: 576px) {
        .courses-hero {
            padding: 50px 0;
        }
    }

    .courses-hero-particles {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    .courses-hero-particle {
        position: absolute;
        background: rgba(251, 198, 12, 0.1);
        border-radius: 50%;
    }

    .courses-hero-particle:nth-child(1) {
        width: 300px;
        height: 300px;
        top: -100px;
        right: -100px;
        animation: float 8s ease-in-out infinite;
    }

    @media (max-width: 768px) {
        .courses-hero-particle:nth-child(1) {
            width: 200px;
            height: 200px;
            top: -50px;
            right: -50px;
        }
    }

    .courses-hero-particle:nth-child(2) {
        width: 200px;
        height: 200px;
        bottom: -50px;
        left: -50px;
        background: rgba(90, 209, 228, 0.1);
        animation: float 10s ease-in-out infinite reverse;
    }

    @media (max-width: 768px) {
        .courses-hero-particle:nth-child(2) {
            width: 150px;
            height: 150px;
            bottom: -30px;
            left: -30px;
        }
    }

    .courses-hero-particle:nth-child(3) {
        width: 150px;
        height: 150px;
        top: 30%;
        left: 20%;
        background: rgba(235, 215, 137, 0.1);
        animation: float 12s ease-in-out infinite;
    }

    @media (max-width: 768px) {
        .courses-hero-particle:nth-child(3) {
            width: 100px;
            height: 100px;
        }
    }

    .courses-hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
        max-width: 800px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .courses-hero-badge {
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
        .courses-hero-badge {
            font-size: 0.8rem;
            padding: 6px 16px;
        }
    }

    .courses-hero-title {
        font-size: clamp(1.8rem, 6vw, 3rem);
        font-weight: 800;
        margin-bottom: 15px;
        line-height: 1.2;
    }

    .courses-hero-title span {
        color: var(--bright-amber);
    }

    .courses-hero-text {
        font-size: clamp(1rem, 3vw, 1.2rem);
        opacity: 0.95;
        margin-bottom: 30px;
        color: var(--ivory);
    }

    .courses-hero-search {
        max-width: 600px;
        margin: 0 auto;
        position: relative;
    }

    .courses-hero-search input {
        width: 100%;
        padding: 16px 60px 16px 25px;
        border: 2px solid transparent;
        border-radius: var(--radius-full);
        font-size: 1rem;
        box-shadow: var(--shadow-lg);
        transition: var(--transition);
        color: var(--text-primary);
        background: var(--pure-white);
    }

    @media (max-width: 576px) {
        .courses-hero-search input {
            padding: 14px 50px 14px 20px;
            font-size: 0.95rem;
        }
    }

    .courses-hero-search input:focus {
        outline: none;
        border-color: var(--bright-amber);
        box-shadow: var(--shadow-hover);
    }

    .courses-hero-search button {
        position: absolute;
        right: 5px;
        top: 5px;
        width: 46px;
        height: 46px;
        background: var(--gradient-1);
        border: none;
        border-radius: 50%;
        color: var(--pure-white);
        font-size: 1.1rem;
        cursor: pointer;
        transition: var(--transition);
    }

    @media (max-width: 576px) {
        .courses-hero-search button {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }
    }

    .courses-hero-search button:hover {
        background: var(--gradient-2);
        color: var(--prussian-blue);
        transform: scale(1.1);
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

    @media (max-width: 1200px) {
        .courses-wrapper {
            padding: 20px;
        }
    }

    @media (max-width: 992px) {
        .courses-wrapper {
            flex-direction: column;
            padding: 20px;
        }
    }

    @media (max-width: 576px) {
        .courses-wrapper {
            padding: 15px;
        }
    }

    /* ===== SIDEBAR STYLES ===== */
    .courses-sidebar {
        width: var(--sidebar-width);
        background: var(--pure-white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-lg);
        overflow: hidden;
        height: fit-content;
        border: 1px solid rgba(251, 198, 12, 0.1);
        transition: var(--transition);
    }

    @media (max-width: 992px) {
        .courses-sidebar {
            position: fixed;
            top: 0;
            left: -100%;
            width: 300px;
            height: 100vh;
            z-index: 9999;
            border-radius: 0;
            overflow-y: auto;
            transition: left 0.3s ease;
            box-shadow: var(--shadow-lg);
        }

        .courses-sidebar.active {
            left: 0;
        }
    }

    @media (max-width: 576px) {
        .courses-sidebar {
            width: 280px;
        }
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
        border-bottom: 1px solid rgba(251, 198, 12, 0.2);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    @media (max-width: 576px) {
        .sidebar-header {
            padding: 15px;
        }
    }

    .sidebar-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--prussian-blue);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    @media (max-width: 576px) {
        .sidebar-title {
            font-size: 1.1rem;
        }
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
    }

    @media (max-width: 576px) {
        .sidebar-title i {
            width: 28px;
            height: 28px;
            font-size: 0.9rem;
        }
    }

    .clear-filters {
        color: var(--text-muted);
        font-size: 0.9rem;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 5px;
        transition: var(--transition);
        padding: 5px 10px;
        border-radius: var(--radius-full);
        background: var(--pure-white);
    }

    @media (max-width: 576px) {
        .clear-filters {
            font-size: 0.8rem;
            padding: 4px 8px;
        }
    }

    .clear-filters:hover {
        color: var(--bright-amber);
        transform: translateX(5px);
    }

    /* Filter Section */
    .filter-section {
        padding: 20px;
        border-bottom: 1px solid rgba(251, 198, 12, 0.1);
    }

    @media (max-width: 576px) {
        .filter-section {
            padding: 15px;
        }
    }

    .filter-section:last-child {
        border-bottom: none;
    }

    .filter-section-title {
        font-size: 1rem;
        font-weight: 700;
        color: var(--prussian-blue);
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .filter-section-title i {
        color: var(--bright-amber);
        font-size: 1rem;
        width: 20px;
    }

    .filter-options {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .filter-option {
        margin-bottom: 10px;
    }

    .filter-option label {
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        font-size: 0.95rem;
        color: var(--text-muted);
        transition: var(--transition);
        padding: 6px 10px;
        border-radius: var(--radius-md);
    }

    @media (max-width: 576px) {
        .filter-option label {
            font-size: 0.9rem;
            padding: 8px 10px; /* Larger touch target */
        }
    }

    .filter-option label:hover {
        color: var(--bright-amber);
        background: var(--ivory);
        transform: translateX(3px);
    }

    .filter-option input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: var(--bright-amber);
    }

    @media (max-width: 576px) {
        .filter-option input[type="checkbox"] {
            width: 20px;
            height: 20px; /* Larger touch target */
        }
    }

    .filter-count {
        margin-left: auto;
        background: var(--ivory);
        padding: 2px 8px;
        border-radius: var(--radius-full);
        font-size: 0.7rem;
        font-weight: 600;
        color: var(--text-muted);
    }

    /* Stats Card */
    .stats-card {
        background: var(--ivory);
        border-radius: var(--radius-md);
        padding: 20px;
        margin: 20px;
        border: 1px solid rgba(251, 198, 12, 0.2);
    }

    @media (max-width: 576px) {
        .stats-card {
            padding: 15px;
            margin: 15px;
        }
    }

    .stats-header {
        font-size: 1rem;
        font-weight: 700;
        color: var(--prussian-blue);
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .stats-header i {
        color: var(--bright-amber);
        font-size: 1.1rem;
    }

    .stats-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px dashed rgba(251, 198, 12, 0.3);
    }

    .stats-item:last-child {
        border-bottom: none;
    }

    .stats-label {
        color: var(--text-muted);
        font-size: 0.9rem;
    }

    .stats-value {
        font-weight: 700;
        color: var(--prussian-blue);
        font-size: 1.1rem;
    }

    .stats-value.success {
        color: var(--sky-blue);
    }

    /* ===== MAIN CONTENT AREA ===== */
    .courses-main {
        flex: 1;
        min-width: 0;
    }

    /* Sort Bar */
    .sort-bar {
        background: var(--pure-white);
        border-radius: var(--radius-lg);
        padding: 15px 20px;
        margin-bottom: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        box-shadow: var(--shadow-md);
        border: 1px solid rgba(251, 198, 12, 0.1);
    }

    @media (max-width: 768px) {
        .sort-bar {
            flex-direction: column;
            align-items: stretch;
            padding: 15px;
        }
    }

    @media (max-width: 576px) {
        .sort-bar {
            padding: 12px;
            margin-bottom: 20px;
        }
    }

    .results-count {
        color: var(--text-muted);
        font-size: 0.95rem;
    }

    @media (max-width: 576px) {
        .results-count {
            font-size: 0.9rem;
            text-align: center;
        }
    }

    .results-count strong {
        color: var(--bright-amber);
        font-size: 1.1rem;
    }

    .sort-select {
        padding: 10px 40px 10px 15px;
        border: 2px solid var(--pale-slate);
        border-radius: var(--radius-md);
        font-size: 0.95rem;
        background: var(--pure-white);
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23FBC60C' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 10px center;
        transition: var(--transition);
        font-weight: 500;
        color: var(--text-primary);
    }

    @media (max-width: 768px) {
        .sort-select {
            width: 100%;
        }
    }

    @media (max-width: 576px) {
        .sort-select {
            padding: 12px 40px 12px 15px; /* Larger touch target */
            font-size: 0.95rem;
        }
    }

    .sort-select:focus {
        outline: none;
        border-color: var(--bright-amber);
        box-shadow: var(--shadow-md);
    }

    /* ===== COURSE GRID ===== */
    .course-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 30px;
        margin-bottom: 40px;
    }

    @media (max-width: 992px) {
        .course-grid {
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }
    }

    @media (max-width: 768px) {
        .course-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
    }

    @media (max-width: 576px) {
        .course-grid {
            gap: 15px;
        }
    }

    .course-card {
        background: var(--pure-white);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-md);
        transition: var(--transition);
        height: 100%;
        display: flex;
        flex-direction: column;
        position: relative;
        border: 1px solid rgba(251, 198, 12, 0.1);
    }

    .course-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-hover);
        border-color: var(--bright-amber);
    }

    .course-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        z-index: 3;
        padding: 5px 15px;
        background: var(--gradient-1);
        color: var(--pure-white);
        border-radius: var(--radius-full);
        font-size: 0.8rem;
        font-weight: 600;
        box-shadow: var(--shadow-md);
        pointer-events: none;
        max-width: calc(100% - 30px);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    @media (max-width: 576px) {
        .course-badge {
            top: 10px;
            left: 10px;
            padding: 4px 12px;
            font-size: 0.7rem;
            max-width: calc(100% - 20px);
        }
    }

    .course-badge.free {
        background: var(--gradient-3);
        color: var(--prussian-blue);
    }

    .course-badge.popular {
        background: var(--gradient-2);
        color: var(--prussian-blue);
    }

    .course-bookmark {
        position: absolute;
        top: 15px;
        right: 15px;
        z-index: 2;
    }

    @media (max-width: 576px) {
        .course-bookmark {
            top: 10px;
            right: 10px;
        }
    }

    .bookmark-btn {
        width: 40px;
        height: 40px;
        background: var(--pure-white);
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: var(--text-muted);
        transition: var(--transition);
        box-shadow: var(--shadow-md);
    }

    @media (max-width: 576px) {
        .bookmark-btn {
            width: 36px;
            height: 36px;
            font-size: 0.9rem;
        }
    }

    .bookmark-btn:hover {
        background: var(--bright-amber);
        color: var(--prussian-blue);
        transform: scale(1.1);
    }

    .bookmark-btn.active {
        background: var(--bright-amber);
        color: var(--prussian-blue);
    }

    .course-thumbnail {
        position: relative;
        overflow: hidden;
        aspect-ratio: 16/9;
    }

    .course-thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition-slow);
    }

    .course-card:hover .course-thumbnail img {
        transform: scale(1.1);
    }

    .course-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom, transparent 0%, rgba(10, 29, 68, 0.9) 100%);
        opacity: 0;
        transition: var(--transition);
        display: flex;
        align-items: flex-end;
        padding: 20px;
    }

    .course-card:hover .course-overlay {
        opacity: 1;
    }

    .course-content {
        padding: 25px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    @media (max-width: 768px) {
        .course-content {
            padding: 20px;
        }
    }

    @media (max-width: 576px) {
        .course-content {
            padding: 15px;
        }
    }

    .course-meta-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .course-category {
        font-size: 0.8rem;
        color: var(--bright-amber);
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 700;
    }

    .course-rating {
        display: flex;
        align-items: center;
        gap: 5px;
        flex-wrap: wrap;
    }

    .course-rating .stars {
        color: var(--bright-amber);
        font-size: 0.9rem;
    }

    .course-rating .rating-value {
        font-weight: 700;
        color: var(--text-primary);
    }

    .course-rating .rating-count {
        color: var(--text-muted);
        font-size: 0.8rem;
    }

    .course-title {
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 10px;
        line-height: 1.4;
    }

    @media (max-width: 576px) {
        .course-title {
            font-size: 1.1rem;
        }
    }

    .course-title a {
        color: var(--prussian-blue);
        text-decoration: none;
        transition: var(--transition);
    }

    .course-title a:hover {
        color: var(--bright-amber);
    }

    .course-description {
        color: var(--text-muted);
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 15px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    @media (max-width: 576px) {
        .course-description {
            font-size: 0.9rem;
        }
    }

    .course-meta {
        display: flex;
        gap: 15px;
        margin-bottom: 15px;
        color: var(--text-muted);
        font-size: 0.9rem;
        flex-wrap: wrap;
    }

    @media (max-width: 576px) {
        .course-meta {
            gap: 12px;
            font-size: 0.85rem;
        }
    }

    .course-meta i {
        color: var(--bright-amber);
        margin-right: 5px;
    }

    .course-instructor {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: auto;
        margin-bottom: 15px;
        padding-top: 15px;
        border-top: 1px solid rgba(251, 198, 12, 0.2);
    }

    .instructor-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--gradient-1);
        color: var(--pure-white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 1rem;
        flex-shrink: 0;
    }

    @media (max-width: 576px) {
        .instructor-avatar {
            width: 36px;
            height: 36px;
            font-size: 0.9rem;
        }
    }

    .instructor-info {
        flex: 1;
        min-width: 0;
    }

    .instructor-name {
        font-weight: 600;
        font-size: 0.95rem;
        color: var(--prussian-blue);
        text-decoration: none;
        transition: var(--transition);
        display: block;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .instructor-name:hover {
        color: var(--bright-amber);
    }

    .instructor-title {
        font-size: 0.8rem;
        color: var(--text-muted);
    }

    .course-footer {
        padding: 15px 20px;
        border-top: 1px solid rgba(251, 198, 12, 0.2);
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: var(--ivory);
        flex-wrap: wrap;
        gap: 10px;
    }

    @media (max-width: 576px) {
        .course-footer {
            flex-direction: column;
            align-items: flex-start;
            padding: 15px;
        }
    }

    .course-price {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--prussian-blue);
    }

    @media (max-width: 576px) {
        .course-price {
            font-size: 1.2rem;
        }
    }

    .course-price.free {
        color: var(--sky-blue);
    }

    .price-label {
        font-size: 0.7rem;
        font-weight: 400;
        color: var(--text-muted);
        display: block;
        line-height: 1;
    }

    .course-price small {
        font-size: 0.9rem;
        font-weight: 400;
        color: var(--text-muted);
        text-decoration: line-through;
        margin-left: 5px;
    }

    .enroll-btn {
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
        .enroll-btn {
            width: 100%;
            justify-content: center;
            padding: 12px 20px;
        }
    }

    .enroll-btn:hover {
        background: var(--gradient-2);
        color: var(--prussian-blue);
        transform: translateX(5px);
        box-shadow: var(--shadow-hover);
    }

    .enroll-btn i {
        font-size: 0.8rem;
        transition: var(--transition);
    }

    .enroll-btn:hover i {
        transform: translateX(5px);
    }

    /* ===== NO RESULTS ===== */
    .no-results {
        text-align: center;
        padding: 60px 20px;
        background: var(--pure-white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        border: 1px solid rgba(251, 198, 12, 0.1);
    }

    @media (max-width: 576px) {
        .no-results {
            padding: 40px 15px;
        }
    }

    .no-results-icon {
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
        .no-results-icon {
            width: 100px;
            height: 100px;
            font-size: 2.5rem;
        }
    }

    .no-results h3 {
        font-size: 1.8rem;
        margin-bottom: 10px;
        color: var(--prussian-blue);
    }

    @media (max-width: 576px) {
        .no-results h3 {
            font-size: 1.5rem;
        }
    }

    .no-results p {
        color: var(--text-muted);
        margin-bottom: 25px;
        font-size: 1.1rem;
    }

    @media (max-width: 576px) {
        .no-results p {
            font-size: 1rem;
        }
    }

    .reset-btn {
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
    }

    @media (max-width: 576px) {
        .reset-btn {
            width: 100%;
            justify-content: center;
            padding: 12px 20px;
        }
    }

    .reset-btn:hover {
        background: var(--gradient-2);
        color: var(--prussian-blue);
        transform: translateY(-3px);
        box-shadow: var(--shadow-hover);
    }

    .reset-btn i {
        transition: var(--transition);
    }

    .reset-btn:hover i {
        transform: rotate(180deg);
    }

    /* ===== PAGINATION ===== */
    .pagination {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-top: 40px;
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

    @media (max-width: 576px) {
        .pagination .page-link {
            min-width: 36px;
            height: 36px;
            font-size: 0.9rem;
        }
    }

    .pagination .page-link:hover {
        background: var(--gradient-2);
        color: var(--prussian-blue);
        border-color: transparent;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .pagination .active .page-link {
        background: var(--gradient-1);
        color: var(--pure-white);
        border-color: transparent;
    }

    .pagination .disabled .page-link {
        background: var(--ivory);
        color: var(--text-muted);
        pointer-events: none;
        border-color: var(--pale-slate);
        opacity: 0.6;
    }

    /* ===== MOBILE FILTER ===== */
    .mobile-filter-toggle {
        display: none;
        margin-bottom: 20px;
    }

    @media (max-width: 992px) {
        .mobile-filter-toggle {
            display: block;
        }
    }

    .filter-toggle-btn {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        padding: 15px 20px;
        background: var(--pure-white);
        border: 2px solid var(--pale-slate);
        border-radius: var(--radius-md);
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        color: var(--prussian-blue);
    }

    @media (max-width: 576px) {
        .filter-toggle-btn {
            padding: 12px 15px;
            font-size: 0.95rem;
        }
    }

    .filter-toggle-btn:hover {
        border-color: var(--bright-amber);
        box-shadow: var(--shadow-md);
    }

    .filter-toggle-btn i {
        transition: var(--transition);
        color: var(--bright-amber);
    }

    .filter-toggle-btn.active i {
        transform: rotate(180deg);
    }

    /* Filter Overlay */
    .filter-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(10, 29, 68, 0.5);
        z-index: 9998;
        opacity: 0;
        transition: opacity 0.3s;
        backdrop-filter: blur(3px);
        -webkit-backdrop-filter: blur(3px);
    }

    .filter-overlay.active {
        opacity: 1;
    }

    /* ===== LOADING SPINNER ===== */
    .loading-spinner {
        display: none;
        text-align: center;
        padding: 40px;
    }

    .loading-spinner.show {
        display: block;
    }

    .spinner {
        width: 50px;
        height: 50px;
        border: 4px solid var(--pale-slate);
        border-top-color: var(--bright-amber);
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto;
    }

    /* ===== NOTIFICATION ===== */
    .notification {
        position: fixed;
        bottom: 20px;
        right: 20px;
        padding: 12px 24px;
        border-radius: var(--radius-full);
        color: var(--pure-white);
        font-weight: 600;
        box-shadow: var(--shadow-lg);
        z-index: 10000;
        animation: slideInRight 0.3s ease;
        border: 1px solid rgba(251, 198, 12, 0.3);
        max-width: 90%;
    }

    @media (max-width: 576px) {
        .notification {
            left: 20px;
            right: 20px;
            text-align: center;
            padding: 12px 20px;
        }
    }

    .notification.success {
        background: var(--gradient-1);
    }

    .notification.error {
        background: var(--gradient-4);
    }

    .notification.info {
        background: var(--gradient-3);
        color: var(--prussian-blue);
    }

    /* ===== UTILITY CLASSES ===== */
    .position-relative { position: relative; }
    .overflow-hidden { overflow: hidden; }
    .text-center { text-align: center; }

    /* ===== RIPPLE EFFECT ===== */
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

    /* ===== ANIMATION ON SCROLL ===== */
    .course-card {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.5s ease, transform 0.5s ease;
    }

    .course-card.visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* ===== TOUCH OPTIMIZATIONS ===== */
    @media (hover: none) and (pointer: coarse) {
        .filter-option label:hover,
        .bookmark-btn:hover,
        .enroll-btn:hover {
            transform: none;
        }
        
        .filter-option label:active,
        .bookmark-btn:active,
        .enroll-btn:active {
            opacity: 0.7;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="courses-hero">
    <div class="courses-hero-particles">
        <div class="courses-hero-particle"></div>
        <div class="courses-hero-particle"></div>
        <div class="courses-hero-particle"></div>
    </div>

    <div class="container">
        <div class="courses-hero-content" data-aos="fade-up">
            <span class="courses-hero-badge">{{ App\Helpers\TranslationHelper::trans('courses.hero_badge') }}</span>
            <h1 class="courses-hero-title">{!! App\Helpers\TranslationHelper::trans('courses.hero_title') !!}</h1>
            <p class="courses-hero-text">
                {{ App\Helpers\TranslationHelper::trans('courses.hero_description') }}
            </p>

            <form id="searchForm" method="GET" action="{{ route('courses') }}" class="courses-hero-search">
                <input type="text" name="keyword" id="searchInput" placeholder="{{ App\Helpers\TranslationHelper::trans('courses.hero_search_placeholder') }}" value="{{ $filters['keyword'] ?? '' }}" autocomplete="off">
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="courses-main">
    <div class="container">
        <div class="courses-wrapper">
            <!-- Mobile Filter Toggle -->
            <div class="mobile-filter-toggle">
                <button class="filter-toggle-btn" id="filterToggle">
                    <span><i class="fas fa-sliders-h"></i> {{ App\Helpers\TranslationHelper::trans('courses.filter_toggle') }}</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
            </div>

            <!-- Filter Sidebar -->
            <aside class="courses-sidebar" id="filterSidebar">
                <div class="sidebar-header">
                    <h3 class="sidebar-title">
                        <i class="fas fa-filter"></i>
                        {{ App\Helpers\TranslationHelper::trans('courses.sidebar_title') }}
                    </h3>
                    <a href="{{ route('courses') }}" class="clear-filters" id="clearAllFilters">
                        <i class="fas fa-times"></i> {{ App\Helpers\TranslationHelper::trans('courses.clear_all') }}
                    </a>
                </div>

                <!-- Categories Filter -->
                <div class="filter-section">
                    <h4 class="filter-section-title">
                        <i class="fas fa-folder"></i> {{ App\Helpers\TranslationHelper::trans('courses.categories_title') }}
                    </h4>
                    <ul class="filter-options" id="categoryFilter">
                        @foreach($categories as $category)
                        <li class="filter-option">
                            <label>
                                <input type="checkbox" name="categories[]" value="{{ $category['id'] }}" class="category-checkbox"
                                    {{ in_array($category['id'], $filters['categories'] ?? []) ? 'checked' : '' }}>
                                {{ $category['name'] }}
                                <span class="filter-count">{{ $category['count'] }}</span>
                            </label>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Price Filter -->
                <div class="filter-section">
                    <h4 class="filter-section-title">
                        <i class="fas fa-tag"></i> {{ App\Helpers\TranslationHelper::trans('courses.price_title') }}
                    </h4>
                    <ul class="filter-options" id="priceFilter">
                        <li class="filter-option">
                            <label>
                                <input type="checkbox" name="price[]" value="free" class="price-checkbox"
                                    {{ in_array('free', $filters['price'] ?? []) ? 'checked' : '' }}>
                                {{ App\Helpers\TranslationHelper::trans('courses.price_free') }}
                                <span class="filter-count">{{ $freeCoursesCount }}</span>
                            </label>
                        </li>
                        <li class="filter-option">
                            <label>
                                <input type="checkbox" name="price[]" value="paid" class="price-checkbox"
                                    {{ in_array('paid', $filters['price'] ?? []) ? 'checked' : '' }}>
                                {{ App\Helpers\TranslationHelper::trans('courses.price_paid') }}
                                <span class="filter-count">{{ $paidCoursesCount }}</span>
                            </label>
                        </li>
                    </ul>
                </div>

                <!-- Stats Card -->
                <div class="stats-card">
                    <div class="stats-header">
                        <i class="fas fa-chart-line"></i>
                        {{ App\Helpers\TranslationHelper::trans('courses.stats_title') }}
                    </div>
                    <div class="stats-item">
                        <span class="stats-label">{{ App\Helpers\TranslationHelper::trans('courses.stats_total') }}</span>
                        <span class="stats-value" id="totalCoursesCount">{{ ($paginatedCourses->total() ?? 0) + ($practiceCourses ?? collect())->count() }}</span>
                    </div>
                    <div class="stats-item">
                        <span class="stats-label">{{ App\Helpers\TranslationHelper::trans('courses.stats_free') }}</span>
                        <span class="stats-value success" id="freeCoursesCount">{{ $freeCoursesCount ?? 0 }}</span>
                    </div>
                    <div class="stats-item">
                        <span class="stats-label">{{ App\Helpers\TranslationHelper::trans('courses.stats_categories') }}</span>
                        <span class="stats-value">{{ count($categories) }}</span>
                    </div>
                </div>
            </aside>

            <!-- Courses Grid -->
            <main class="courses-main">
                <!-- Sort Bar -->
                <div class="sort-bar" data-aos="fade-up">
                    <div class="results-count">
                        {!! App\Helpers\TranslationHelper::trans('courses.results_showing', [
                            'from' => '<strong id="showingFrom">' . ($paginatedCourses->firstItem() ?? 0) . '</strong>',
                            'to' => '<strong id="showingTo">' . ($paginatedCourses->lastItem() ?? 0) . '</strong>',
                            'total' => '<strong id="totalResults">' . ($paginatedCourses->total() + ($practiceCourses ?? collect())->count()) . '</strong>'
                        ]) !!}
                    </div>

                    <div class="sort-wrapper">
                        <select name="sort" class="sort-select" id="sortSelect">
                            <option value="newest_first" {{ ($filters['sort'] ?? '') == 'newest_first' ? 'selected' : '' }}>{{ App\Helpers\TranslationHelper::trans('courses.sort_newest') }}</option>
                            <option value="oldest_first" {{ ($filters['sort'] ?? '') == 'oldest_first' ? 'selected' : '' }}>{{ App\Helpers\TranslationHelper::trans('courses.sort_oldest') }}</option>
                            <option value="course_title_az" {{ ($filters['sort'] ?? '') == 'course_title_az' ? 'selected' : '' }}>{{ App\Helpers\TranslationHelper::trans('courses.sort_title_az') }}</option>
                            <option value="course_title_za" {{ ($filters['sort'] ?? '') == 'course_title_za' ? 'selected' : '' }}>{{ App\Helpers\TranslationHelper::trans('courses.sort_title_za') }}</option>
                            <option value="popular" {{ ($filters['sort'] ?? '') == 'popular' ? 'selected' : '' }}>{{ App\Helpers\TranslationHelper::trans('courses.sort_popular') }}</option>
                            <option value="top_rated" {{ ($filters['sort'] ?? '') == 'top_rated' ? 'selected' : '' }}>{{ App\Helpers\TranslationHelper::trans('courses.sort_rated') }}</option>
                        </select>
                    </div>
                </div>

                <!-- Loading Spinner -->
                <div class="loading-spinner" id="loadingSpinner">
                    <div class="spinner"></div>
                </div>

                <!-- Courses Container -->
                <div id="coursesContainer">
                    @include('partials.course-list', ['courses' => $paginatedCourses, 'practiceCourses' => $practiceCourses ?? collect(), 'hasActiveSubscription' => $hasActiveSubscription])
                </div>
            </main>
        </div>
    </div>
</section>

<!-- Video Preview Modal -->
<div class="video-modal" id="videoModal">
    <div class="video-modal-content">
        <div class="video-modal-header">
            <h3 id="videoModalTitle">Course Preview</h3>
            <button class="video-modal-close" onclick="closeVideoModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="video-modal-body">
            <video id="videoPlayer" controls controlsList="nodownload">
                <source src="" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
        <div class="video-modal-footer">
            <i class="fas fa-info-circle"></i> Preview of the course content
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Video Preview Modal Functions
    function openVideoPreview(event, videoUrl, courseTitle) {
        event.preventDefault();
        
        const modal = document.getElementById('videoModal');
        const videoPlayer = document.getElementById('videoPlayer');
        const modalTitle = document.getElementById('videoModalTitle');
        
        // Set video source
        videoPlayer.querySelector('source').src = videoUrl;
        videoPlayer.load();
        
        // Set modal title
        modalTitle.textContent = courseTitle ? `Preview: ${courseTitle}` : 'Course Preview';
        
        // Show modal
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
        
        // Play video
        videoPlayer.play().catch(e => console.log('Autoplay prevented:', e));
    }

    function closeVideoModal() {
        const modal = document.getElementById('videoModal');
        const videoPlayer = document.getElementById('videoPlayer');
        
        // Pause video
        videoPlayer.pause();
        videoPlayer.currentTime = 0;
        
        // Hide modal
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeVideoModal();
            }
        });

        // Close modal when clicking outside
        document.getElementById('videoModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeVideoModal();
            }
        });

        // ========== MOBILE FILTER TOGGLE ==========
        const filterToggle = document.getElementById('filterToggle');
        const filterSidebar = document.getElementById('filterSidebar');
        let filterOverlay = null;

        if (filterToggle) {
            filterToggle.addEventListener('click', function() {
                this.classList.toggle('active');
                filterSidebar.classList.toggle('active');

                if (filterSidebar.classList.contains('active')) {
                    // Create overlay
                    filterOverlay = document.createElement('div');
                    filterOverlay.className = 'filter-overlay';
                    document.body.appendChild(filterOverlay);

                    // Fade in overlay
                    setTimeout(() => {
                        filterOverlay.classList.add('active');
                    }, 10);

                    // Close on overlay click
                    filterOverlay.addEventListener('click', closeFilterSidebar);

                    document.body.style.overflow = 'hidden';
                } else {
                    closeFilterSidebar();
                }
            });
        }

        function closeFilterSidebar() {
            if (filterToggle) filterToggle.classList.remove('active');
            if (filterSidebar) filterSidebar.classList.remove('active');

            if (filterOverlay) {
                filterOverlay.classList.remove('active');
                setTimeout(() => {
                    filterOverlay?.remove();
                    filterOverlay = null;
                }, 300);
            }

            document.body.style.overflow = '';
        }

        // Close filter sidebar on window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 992 && filterSidebar?.classList.contains('active')) {
                closeFilterSidebar();
            }
        });

        // Close on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && filterSidebar?.classList.contains('active')) {
                closeFilterSidebar();
            }
        });

        // ========== FILTERING FUNCTIONALITY ==========
        const filterInputs = document.querySelectorAll('.category-checkbox, .price-checkbox');
        const sortSelect = document.getElementById('sortSelect');
        const searchForm = document.getElementById('searchForm');
        const searchInput = document.getElementById('searchInput');
        const loadingSpinner = document.getElementById('loadingSpinner');
        const coursesContainer = document.getElementById('coursesContainer');
        const clearAllBtn = document.getElementById('clearAllFilters');
        const resetFiltersBtn = document.getElementById('resetFiltersBtn');

        let filterTimeout;

        // Function to update URL with current filters
        function updateURL(params) {
            const newUrl = `${window.location.pathname}?${params.toString()}`;
            window.history.pushState({}, '', newUrl);
        }

      function updateCourses() {
    // Show loading spinner
    loadingSpinner.classList.add('show');
    if (coursesContainer) coursesContainer.style.opacity = '0.5';

    // Collect filter values
    const categories = [];
    document.querySelectorAll('.category-checkbox:checked').forEach(input => {
        categories.push(input.value);
    });

    const prices = [];
    document.querySelectorAll('.price-checkbox:checked').forEach(input => {
        prices.push(input.value);
    });

    const keyword = searchInput?.value || '';
    const sort = sortSelect?.value || 'newest_first';

    // Build URL with filters
    const params = new URLSearchParams();

    if (keyword) params.append('keyword', keyword);
    if (sort) params.append('sort', sort);

    categories.forEach(cat => params.append('categories[]', cat));
    prices.forEach(price => params.append('price[]', price));

    // Update URL
    updateURL(params);

    // Log the URL being fetched
    console.log('Fetching:', `/courses/filter?${params.toString()}`);

    // Make AJAX request
    fetch(`/courses/filter?${params.toString()}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => {
        console.log('Response status:', response.status);
        if (!response.ok) {
            return response.text().then(text => {
                console.error('Error response text:', text);
                throw new Error(`Network response was not ok: ${response.status}`);
            });
        }
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            // Update courses container
            coursesContainer.innerHTML = data.html;

            // Update stats
            if (data.count !== undefined) {
                const totalResults = document.getElementById('totalResults');
                const totalCoursesCount = document.getElementById('totalCoursesCount');
                
                if (totalResults) totalResults.textContent = data.count;
                if (totalCoursesCount) totalCoursesCount.textContent = data.count;
            }

            // Reinitialize bookmark buttons for new content
            initializeBookmarkButtons();
            // Reinitialize ripple effects
            initializeRippleEffects();
            // Reinitialize pagination links
            initializePaginationLinks();
            // Reinitialize course card observers
            initializeCardObservers();

            // Close mobile filter sidebar after filter
            if (window.innerWidth <= 992) {
                closeFilterSidebar();
            }

            // Hide loading spinner
            loadingSpinner.classList.remove('show');
            if (coursesContainer) coursesContainer.style.opacity = '1';

            // Show notification
            showNotification('Filters applied successfully', 'success');
        } else {
            console.error('Server returned error:', data.message);
            throw new Error(data.message || 'Invalid response from server');
        }
    })
    .catch(error => {
        console.error('Error in updateCourses:', error);
        loadingSpinner.classList.remove('show');
        if (coursesContainer) coursesContainer.style.opacity = '1';
        showNotification('Error applying filters: ' + error.message, 'error');

        // Don't fallback to form submission - this causes page reload
        // if (searchForm) {
        //     searchForm.submit();
        // }
    });
}
        // Debounced update function
        function debounce(func, wait) {
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(filterTimeout);
                    func(...args);
                };
                clearTimeout(filterTimeout);
                filterTimeout = setTimeout(later, wait);
            };
        }

        const debouncedUpdate = debounce(updateCourses, 500);

        // Event listeners for filters
        filterInputs.forEach(input => {
            input.addEventListener('change', function() {
                debouncedUpdate();
            });
        });

        // Sort change
        if (sortSelect) {
            sortSelect.addEventListener('change', function() {
                updateCourses();
            });
        }

        // Search form submission
        if (searchForm) {
            searchForm.addEventListener('submit', function(e) {
                e.preventDefault();
                updateCourses();
            });
        }

        // Search input with debounce
        if (searchInput) {
            searchInput.addEventListener('input', debouncedUpdate);
        }

        // Clear all filters
        if (clearAllBtn) {
            clearAllBtn.addEventListener('click', function(e) {
                e.preventDefault();

                // Uncheck all checkboxes
                document.querySelectorAll('.category-checkbox, .price-checkbox').forEach(input => {
                    input.checked = false;
                });

                // Clear search input
                if (searchInput) {
                    searchInput.value = '';
                }

                // Reset sort to default
                if (sortSelect) {
                    sortSelect.value = 'newest_first';
                }

                // Update courses
                updateCourses();
            });
        }

        // Reset filters button (in no results)
        if (resetFiltersBtn) {
            resetFiltersBtn.addEventListener('click', function(e) {
                e.preventDefault();

                // Uncheck all checkboxes
                document.querySelectorAll('.category-checkbox, .price-checkbox').forEach(input => {
                    input.checked = false;
                });

                // Clear search input
                if (searchInput) {
                    searchInput.value = '';
                }

                // Reset sort to default
                if (sortSelect) {
                    sortSelect.value = 'newest_first';
                }

                // Redirect to courses page
                window.location.href = '{{ route("courses") }}';
            });
        }

        // Initialize pagination links
        function initializePaginationLinks() {
            const paginationLinks = document.querySelectorAll('.pagination a');
            paginationLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Show loading spinner
                    loadingSpinner.classList.add('show');
                    if (coursesContainer) coursesContainer.style.opacity = '0.5';

                    // Get the URL
                    const url = this.href;

                    // Fetch the page
                    fetch(url, {
                            method: 'GET',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                coursesContainer.innerHTML = data.html;
                                initializeBookmarkButtons();
                                initializeRippleEffects();
                                initializePaginationLinks();
                                initializeCardObservers();

                                // Scroll to top of courses
                                document.querySelector('.courses-main').scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'start'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            window.location.href = url; // Fallback
                        })
                        .finally(() => {
                            loadingSpinner.classList.remove('show');
                            if (coursesContainer) coursesContainer.style.opacity = '1';
                        });
                });
            });
        }

        // Initialize pagination on page load
        initializePaginationLinks();

        // ========== BOOKMARK FUNCTIONALITY ==========
        function initializeBookmarkButtons() {
            const bookmarkBtns = document.querySelectorAll('.bookmark-btn');

            bookmarkBtns.forEach(btn => {
                btn.classList.add('position-relative', 'overflow-hidden');

                // Set initial state
                const isBookmarked = btn.dataset.bookmarked === 'true';
                const icon = btn.querySelector('i');
                
                if (isBookmarked) {
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                    btn.classList.add('active');
                }

                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    createRipple(e);
                    
                    const courseId = this.dataset.courseId;

                    // Check if user is logged in
                    @auth
                    // Toggle active class
                    this.classList.toggle('active');

                    // Update icon
                    const icon = this.querySelector('i');
                    const isAdding = this.classList.contains('active');

                    if (isAdding) {
                        icon.classList.remove('far');
                        icon.classList.add('fas');

                        // Make AJAX call to add to wishlist
                        fetch(`/wishlist/add/${courseId}`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    showNotification('{{ App\Helpers\TranslationHelper::trans('courses.notification_bookmark_added') }}', 'success');
                                } else {
                                    // Revert if failed
                                    this.classList.remove('active');
                                    icon.classList.remove('fas');
                                    icon.classList.add('far');
                                    showNotification(data.message || '{{ App\Helpers\TranslationHelper::trans('courses.notification_bookmark_error') }}', 'error');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                // Revert on error
                                this.classList.remove('active');
                                icon.classList.remove('fas');
                                icon.classList.add('far');
                                showNotification('{{ App\Helpers\TranslationHelper::trans('courses.notification_bookmark_error') }}', 'error');
                            });

                    } else {
                        icon.classList.remove('fas');
                        icon.classList.add('far');

                        // Make AJAX call to remove from wishlist
                        fetch(`/wishlist/remove/${courseId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    showNotification('{{ App\Helpers\TranslationHelper::trans('courses.notification_bookmark_removed') }}', 'info');
                                } else {
                                    showNotification(data.message || '{{ App\Helpers\TranslationHelper::trans('courses.notification_bookmark_remove_error') }}', 'error');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                showNotification('{{ App\Helpers\TranslationHelper::trans('courses.notification_bookmark_remove_error') }}', 'error');
                            });
                    }
                    @else
                    // Redirect to login
                    showNotification('{{ App\Helpers\TranslationHelper::trans('courses.notification_bookmark_login') }}', 'info');
                    setTimeout(() => {
                        window.location.href = '{{ route("login") }}';
                    }, 1500);
                    @endauth
                });
            });
        }

        // Initialize bookmark buttons on page load
        initializeBookmarkButtons();

        // ========== RIPPLE EFFECT ==========
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

        function initializeRippleEffects() {
            const rippleButtons = document.querySelectorAll('.enroll-btn, .reset-btn, .filter-toggle-btn, .bookmark-btn, .pagination .page-link');
            rippleButtons.forEach(button => {
                button.classList.add('position-relative', 'overflow-hidden');
                button.removeEventListener('click', createRipple);
                button.addEventListener('click', createRipple);
            });
        }

        // Initialize ripple effects on page load
        initializeRippleEffects();

        // ========== NOTIFICATION FUNCTION ==========
        function showNotification(message, type = 'success') {
            // Remove any existing notifications
            const existingNotifications = document.querySelectorAll('.notification');
            existingNotifications.forEach(notification => notification.remove());

            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.textContent = message;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.animation = 'slideOutRight 0.3s ease';
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, 3000);
        }

        // ========== ANIMATION ON SCROLL ==========
        function initializeCardObservers() {
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

            // Observe course cards
            document.querySelectorAll('.course-card').forEach(el => {
                observer.observe(el);
            });
        }

        // Initialize card observers
        initializeCardObservers();

        // ========== HANDLE BROWSER BACK/FORWARD ==========
        window.addEventListener('popstate', function() {
            // Reload the page with the previous URL state
            window.location.reload();
        });

        // ========== INITIALIZE ACTIVE FILTERS FROM URL ==========
        function initializeFiltersFromURL() {
            const urlParams = new URLSearchParams(window.location.search);

            // Set categories
            const categoryValues = urlParams.getAll('categories[]');
            document.querySelectorAll('.category-checkbox').forEach(checkbox => {
                checkbox.checked = categoryValues.includes(checkbox.value);
            });

            // Set prices
            const priceValues = urlParams.getAll('price[]');
            document.querySelectorAll('.price-checkbox').forEach(checkbox => {
                checkbox.checked = priceValues.includes(checkbox.value);
            });

            // Set sort
            const sort = urlParams.get('sort');
            if (sort && sortSelect) {
                sortSelect.value = sort;
            }

            // Set keyword
            const keyword = urlParams.get('keyword');
            if (keyword && searchInput) {
                searchInput.value = keyword;
            }
        }

        // Initialize filters from URL on page load
        initializeFiltersFromURL();

        // ========== TOUCH OPTIMIZATIONS ==========
        if ('ontouchstart' in window) {
            const touchElements = document.querySelectorAll('.btn, .enroll-btn, .bookmark-btn, .filter-toggle-btn, .filter-option label');
            
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

        // ========== ANIMATION PAUSE FOR REDUCED MOTION ==========
        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        
        if (prefersReducedMotion) {
            const animatedElements = document.querySelectorAll('.courses-hero-particle, .no-results-icon');
            
            animatedElements.forEach(element => {
                if (element.style) {
                    element.style.animation = 'none';
                }
            });
        }
    });
</script>
@endpush