@extends('layouts.main')

@section('title', App\Helpers\TranslationHelper::trans('certificates.title'))

@section('meta_description', App\Helpers\TranslationHelper::trans('certificates.meta_description'))

@push('styles')
<style>
    /* ===== CERTIFICATES VARIABLES ===== */
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

    /* ===== CERTIFICATES LAYOUT ===== */
    .certificates-wrapper {
        flex: 1;
        display: flex;
        width: 100%;
        max-width: 1400px;
        margin: 0 auto;
        padding: 30px;
        gap: 30px;
    }

    /* ===== SIDEBAR STYLES ===== */
    .certificates-sidebar {
        width: var(--sidebar-width);
        background: var(--card-bg);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-lg);
        overflow: hidden;
        height: fit-content;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .certificates-sidebar::-webkit-scrollbar {
        width: 5px;
    }

    .certificates-sidebar::-webkit-scrollbar-track {
        background: var(--border-color);
    }

    .certificates-sidebar::-webkit-scrollbar-thumb {
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

    /* Stats Card */
    .stats-card {
        background: linear-gradient(145deg, #ffffff, #fafafa);
        border-radius: var(--radius-md);
        padding: 20px;
        margin: 20px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-color);
    }

    .stats-header {
        font-size: 1rem;
        font-weight: 700;
        color: var(--dark-color);
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .stats-header i {
        color: var(--primary-color);
        font-size: 1.1rem;
    }

    .stats-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px dashed var(--border-color);
    }

    .stats-item:last-child {
        border-bottom: none;
    }

    .stats-label {
        color: var(--gray-color);
        font-size: 0.9rem;
    }

    .stats-value {
        font-weight: 700;
        color: var(--primary-color);
        font-size: 1.1rem;
    }

    .stats-value.success {
        color: #06d6a0;
    }

    .stats-value.warning {
        color: #f72585;
    }

    /* Share Card */
    .share-card {
        text-align: center;
        padding: 20px;
        margin: 0 20px 20px;
        background: linear-gradient(145deg, #f8f9fa, #e9ecef);
        border-radius: var(--radius-md);
        border: 1px solid var(--border-color);
    }

    .share-icon {
        width: 50px;
        height: 50px;
        background: var(--gradient-1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        color: white;
        font-size: 1.3rem;
        box-shadow: var(--shadow-md);
    }

    .share-title {
        font-weight: 700;
        color: var(--dark-color);
        margin-bottom: 5px;
    }

    .share-text {
        font-size: 0.85rem;
        color: var(--gray-color);
        margin-bottom: 15px;
    }

    .share-btn {
        width: 100%;
        padding: 10px;
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
        justify-content: center;
        gap: 8px;
    }

    .share-btn:hover {
        background: var(--primary-color);
        color: white;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .share-btn i {
        transition: transform 0.3s ease;
    }

    .share-btn:hover i {
        transform: scale(1.1);
    }

    /* Main Content Area */
    .certificates-main {
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
        animation: float 6s ease-in-out infinite;
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

    /* Achievement Banner */
    .achievement-banner {
        background: var(--gradient-1);
        border-radius: var(--radius-xl);
        padding: 30px;
        margin-bottom: 30px;
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-lg);
    }

    .achievement-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 10s ease-in-out infinite;
    }

    .achievement-banner::after {
        content: '';
        position: absolute;
        bottom: -50%;
        left: -10%;
        width: 250px;
        height: 250px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 8s ease-in-out infinite reverse;
    }

    .achievement-content {
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        gap: 30px;
        flex-wrap: wrap;
    }

    .achievement-icon {
        width: 100px;
        height: 100px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        backdrop-filter: blur(10px);
        border: 2px solid rgba(255, 255, 255, 0.3);
        box-shadow: var(--shadow-lg);
    }

    .achievement-text h3 {
        font-size: 1.8rem;
        font-weight: 800;
        margin-bottom: 10px;
        text-shadow: 2px 2px 20px rgba(0,0,0,0.2);
    }

    .achievement-text p {
        font-size: 1.1rem;
        opacity: 0.95;
        max-width: 500px;
        line-height: 1.6;
    }

    /* Featured Certificate */
    .featured-section {
        margin-bottom: 30px;
    }

    .featured-card {
        background: linear-gradient(145deg, #ffffff, #f8f9fa);
        border: 2px solid var(--primary-color);
        border-radius: var(--radius-lg);
        padding: 30px;
        display: flex;
        align-items: center;
        gap: 30px;
        flex-wrap: wrap;
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-md);
    }

    .featured-card::before {
        content: '★';
        position: absolute;
        top: -20px;
        right: -20px;
        font-size: 10rem;
        color: rgba(67, 97, 238, 0.1);
        font-family: serif;
        transform: rotate(15deg);
        line-height: 1;
    }

    .featured-icon {
        width: 100px;
        height: 100px;
        background: var(--gradient-1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        color: white;
        box-shadow: var(--shadow-lg);
        position: relative;
        z-index: 2;
    }

    .featured-content {
        flex: 1;
        position: relative;
        z-index: 2;
    }

    .featured-label {
        display: inline-block;
        padding: 5px 15px;
        background: var(--primary-color);
        color: white;
        border-radius: var(--radius-full);
        font-size: 0.8rem;
        font-weight: 700;
        margin-bottom: 10px;
        letter-spacing: 0.5px;
    }

    .featured-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--dark-color);
        margin-bottom: 10px;
    }

    .featured-meta {
        color: var(--gray-color);
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .featured-meta i {
        color: var(--primary-color);
    }

    .featured-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 30px;
        background: var(--gradient-1);
        color: white;
        border-radius: var(--radius-full);
        text-decoration: none;
        font-weight: 700;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-md);
    }

    .featured-btn:hover {
        transform: translateX(5px);
        box-shadow: var(--shadow-hover);
        color: white;
    }

    .featured-btn i {
        transition: transform 0.3s ease;
    }

    .featured-btn:hover i {
        transform: translateX(5px);
    }

    /* Certificates Grid */
    .certificates-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
        margin-bottom: 30px;
    }

    .certificate-card {
        background: white;
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-md);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        border: 1px solid var(--border-color);
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .certificate-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-hover);
        border-color: transparent;
    }

    .certificate-ribbon {
        position: absolute;
        top: 20px;
        right: -35px;
        background: var(--gradient-1);
        color: white;
        padding: 8px 40px;
        font-size: 0.8rem;
        font-weight: 700;
        transform: rotate(45deg);
        box-shadow: var(--shadow-md);
        z-index: 2;
        letter-spacing: 0.5px;
    }

    .certificate-ribbon.honor {
        background: var(--gradient-2);
    }

    .certificate-ribbon.latest {
        background: var(--gradient-3);
    }

    .certificate-header {
        background: var(--gradient-1);
        padding: 30px 20px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .certificate-header::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 8s ease-in-out infinite;
    }

    .certificate-header::after {
        content: '';
        position: absolute;
        bottom: -50%;
        right: -50%;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite reverse;
    }

    .certificate-icon {
        font-size: 4rem;
        color: white;
        margin-bottom: 10px;
        position: relative;
        z-index: 2;
        animation: float 6s ease-in-out infinite;
    }

    .certificate-badge {
        display: inline-block;
        padding: 6px 16px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: var(--radius-full);
        color: white;
        font-size: 0.8rem;
        font-weight: 700;
        backdrop-filter: blur(5px);
        position: relative;
        z-index: 2;
        letter-spacing: 0.5px;
    }

    .certificate-body {
        padding: 25px;
        text-align: center;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .certificate-title {
        font-size: 1.3rem;
        font-weight: 800;
        color: var(--dark-color);
        margin-bottom: 15px;
        line-height: 1.4;
    }

    .certificate-meta {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-bottom: 20px;
        color: var(--gray-color);
        font-size: 0.9rem;
        flex-wrap: wrap;
    }

    .certificate-meta span {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .certificate-meta i {
        color: var(--primary-color);
    }

    .certificate-number {
        background: linear-gradient(145deg, #f8f9fa, #e9ecef);
        padding: 12px 15px;
        border-radius: var(--radius-md);
        font-family: 'Monaco', 'Menlo', monospace;
        font-size: 0.9rem;
        color: var(--gray-color);
        margin-bottom: 20px;
        border: 1px solid var(--border-color);
        word-break: break-all;
    }

    .certificate-footer {
        padding: 20px 25px 25px;
        border-top: 1px solid var(--border-color);
        display: flex;
        justify-content: center;
        gap: 10px;
        flex-wrap: wrap;
        background: linear-gradient(145deg, #ffffff, #fafafa);
    }

    .btn-download {
        padding: 10px 20px;
        background: var(--gradient-1);
        color: white;
        border-radius: var(--radius-full);
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: var(--shadow-sm);
    }

    .btn-download:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-hover);
        color: white;
    }

    .btn-share {
        padding: 10px 20px;
        background: transparent;
        color: var(--primary-color);
        border: 2px solid var(--primary-color);
        border-radius: var(--radius-full);
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
    }

    .btn-share:hover {
        background: var(--primary-color);
        color: white;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .btn-view {
        padding: 10px 20px;
        background: linear-gradient(145deg, #f8f9fa, #e9ecef);
        color: var(--dark-color);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-full);
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-view:hover {
        background: var(--primary-color);
        color: white;
        border-color: transparent;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
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
        width: 120px;
        height: 120px;
        background: linear-gradient(145deg, #f8f9fa, #e9ecef);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px;
        font-size: 3.5rem;
        color: var(--gray-color);
        animation: float 6s ease-in-out infinite;
        position: relative;
    }

    .empty-icon::after {
        content: '';
        position: absolute;
        width: 140px;
        height: 140px;
        border: 2px dashed var(--primary-color);
        border-radius: 50%;
        animation: spin 20s linear infinite;
    }

    .empty-title {
        font-size: 2rem;
        font-weight: 800;
        color: var(--dark-color);
        margin-bottom: 15px;
    }

    .empty-text {
        color: var(--gray-color);
        margin-bottom: 30px;
        font-size: 1.1rem;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
        line-height: 1.6;
    }

    .empty-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 15px 40px;
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

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
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

    /* Notification */
    .notification {
        position: fixed;
        bottom: 20px;
        right: 20px;
        padding: 12px 24px;
        border-radius: var(--radius-full);
        color: white;
        font-weight: 600;
        box-shadow: var(--shadow-lg);
        z-index: 9999;
        animation: slideInRight 0.3s ease;
    }

    .notification.success {
        background: linear-gradient(145deg, #06d6a0, #05b587);
    }

    .notification.error {
        background: linear-gradient(145deg, #ef476f, #d43f62);
    }

    /* Print Styles */
    @media print {
        .certificates-sidebar,
        .page-header .stats-badge,
        .btn-share,
        .btn-view,
        .pagination,
        .achievement-banner,
        .featured-section {
            display: none !important;
        }

        .certificate-card {
            break-inside: avoid;
            box-shadow: none !important;
            border: 2px solid #ddd !important;
            page-break-inside: avoid;
        }

        .certificates-wrapper {
            padding: 0;
        }

        .certificates-main {
            width: 100%;
        }

        .certificates-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
        .certificates-wrapper {
            padding: 20px;
        }
    }

    @media (max-width: 992px) {
        .certificates-wrapper {
            flex-direction: column;
            padding: 20px;
        }
        
        .certificates-sidebar {
            width: 100%;
            margin-bottom: 20px;
        }
        
        .page-title {
            font-size: 1.8rem;
        }

        .certificates-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .achievement-content {
            flex-direction: column;
            text-align: center;
        }

        .featured-card {
            flex-direction: column;
            text-align: center;
        }

        .certificates-grid {
            grid-template-columns: 1fr;
        }

        .certificate-footer {
            flex-direction: column;
        }

        .btn-download, .btn-share, .btn-view {
            width: 100%;
            justify-content: center;
        }

        .featured-icon {
            margin: 0 auto;
        }
    }

    @media (max-width: 576px) {
        .certificates-wrapper {
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

        .achievement-text h3 {
            font-size: 1.5rem;
        }

        .featured-title {
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
</style>
@endpush

@section('content')
<div class="certificates-wrapper">
    <!-- Sidebar -->
    <aside class="certificates-sidebar">
        <div class="sidebar-header">
            <h3 class="sidebar-title">
                <i class="fas fa-trophy"></i>
                {{ App\Helpers\TranslationHelper::trans('certificates.sidebar_title') }}
            </h3>
        </div>

        <div class="sidebar-nav">
            <a href="{{ route('dashboard') }}" class="nav-item">
                <i class="fas fa-home"></i>
                <span>{{ App\Helpers\TranslationHelper::trans('certificates.nav_dashboard') }}</span>
            </a>
            <a href="{{ route('dashboard.educonecx-academy.index') }}" class="nav-item {{ request()->routeIs('dashboard.educonecx-academy.*') || request()->routeIs('educonecx.academy.*') ? 'active' : '' }}">
                <i class="fas fa-graduation-cap"></i>
                <span>Practice Room</span>
            </a>
            <a href="{{ route('my-courses') }}" class="nav-item">
                <i class="fas fa-book"></i>
                <span>{{ App\Helpers\TranslationHelper::trans('certificates.nav_my_courses') }}</span>
            </a>
            <a href="{{ route('my-quizzes') }}" class="nav-item">
                <i class="fas fa-question-circle"></i>
                <span>{{ App\Helpers\TranslationHelper::trans('certificates.nav_my_quizzes') }}</span>
            </a>
            <a href="{{ route('certificates') }}" class="nav-item active">
                <i class="fas fa-certificate"></i>
                <span>{{ App\Helpers\TranslationHelper::trans('certificates.nav_certificates') }}</span>
                @if(($certificates->total() ?? 0) > 0)
                    <span class="nav-badge">{{ $certificates->total() }}</span>
                @endif
            </a>
        </div>

        <!-- Stats Card -->
        <div class="stats-card">
            <div class="stats-header">
                <i class="fas fa-chart-line"></i>
                {{ App\Helpers\TranslationHelper::trans('certificates.stats_title') }}
            </div>
            <div class="stats-item">
                <span class="stats-label">{{ App\Helpers\TranslationHelper::trans('certificates.stats_total') }}</span>
                <span class="stats-value">{{ $certificates->total() ?? 0 }}</span>
            </div>
            <div class="stats-item">
                <span class="stats-label">{{ App\Helpers\TranslationHelper::trans('certificates.stats_this_month') }}</span>
                <span class="stats-value success">{{ $thisMonthCount ?? 0 }}</span>
            </div>
            <div class="stats-item">
                <span class="stats-label">{{ App\Helpers\TranslationHelper::trans('certificates.stats_with_honors') }}</span>
                <span class="stats-value warning">{{ $honorsCount ?? 0 }}</span>
            </div>
        </div>

        <!-- Share Profile Card -->
        <div class="share-card">
            <div class="share-icon">
                <i class="fas fa-share-alt"></i>
            </div>
            <h5 class="share-title">{{ App\Helpers\TranslationHelper::trans('certificates.share_title') }}</h5>
            <p class="share-text">{{ App\Helpers\TranslationHelper::trans('certificates.share_text') }}</p>
            <button class="share-btn" onclick="shareAllCertificates()">
                <i class="fab fa-linkedin"></i>
                {{ App\Helpers\TranslationHelper::trans('certificates.share_button') }}
            </button>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="certificates-main">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-certificate"></i>
                {{ App\Helpers\TranslationHelper::trans('certificates.page_title') }}
            </h1>
            
            <div class="stats-badge">
                <i class="fas fa-award"></i>
                @if(($certificates->total() ?? 0) === 1)
                    {{ App\Helpers\TranslationHelper::trans('certificates.badge_single', ['count' => $certificates->total() ?? 0]) }}
                @else
                    {{ App\Helpers\TranslationHelper::trans('certificates.badge_plural', ['count' => $certificates->total() ?? 0]) }}
                @endif
            </div>
        </div>

        <!-- Achievement Banner (shown only if user has certificates) -->
        @if(($certificates ?? collect())->count() > 0)
            <div class="achievement-banner">
                <div class="achievement-content">
                    <div class="achievement-icon">
                        <i class="fas fa-crown"></i>
                    </div>
                    <div class="achievement-text">
                        <h3>{{ App\Helpers\TranslationHelper::trans('certificates.achievement_congrats', ['name' => Auth::user()->first_name ?? 'Learner']) }}</h3>
                        <p>
                            @if(($certificates->total() ?? 0) === 1)
                                {{ App\Helpers\TranslationHelper::trans('certificates.achievement_text_single', ['count' => $certificates->total() ?? 0]) }}
                            @else
                                {{ App\Helpers\TranslationHelper::trans('certificates.achievement_text_plural', ['count' => $certificates->total() ?? 0]) }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Featured Certificate (if there's a recent one) -->
        @if(($featuredCertificate ?? null) && ($certificates ?? collect())->count() > 0)
            <div class="featured-section">
                <div class="featured-card">
                    <div class="featured-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="featured-content">
                        <span class="featured-label">{{ App\Helpers\TranslationHelper::trans('certificates.featured_label') }}</span>
                        <h3 class="featured-title">{{ $featuredCertificate->course->title ?? 'Course Title' }}</h3>
                        <p class="featured-meta">
                            <i class="fas fa-calendar-alt"></i> 
                            {{ App\Helpers\TranslationHelper::trans('certificates.featured_issued', ['date' => \Carbon\Carbon::parse($featuredCertificate->issue_date ?? now())->format('F d, Y')]) }}
                        </p>
                        <a href="{{ route('certificates.show', $featuredCertificate->id ?? '#') }}" class="featured-btn">
                            {{ App\Helpers\TranslationHelper::trans('certificates.featured_button') }} <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <!-- Certificates Grid -->
        @if(($certificates ?? collect())->count() > 0)
            <div class="certificates-grid" id="certificatesGrid">
                @foreach($certificates as $certificate)
                    <div class="certificate-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                        @if($certificate->with_honors ?? false)
                            <div class="certificate-ribbon honor">{{ App\Helpers\TranslationHelper::trans('certificates.badge_with_honors') }}</div>
                        @elseif($loop->first)
                            <div class="certificate-ribbon latest">{{ App\Helpers\TranslationHelper::trans('certificates.badge_latest') }}</div>
                        @endif
                        
                        <div class="certificate-header">
                            <div class="certificate-icon">
                                <i class="fas fa-certificate"></i>
                            </div>
                            <span class="certificate-badge">{{ App\Helpers\TranslationHelper::trans('certificates.badge_completion') }}</span>
                        </div>
                        
                        <div class="certificate-body">
                            <h3 class="certificate-title">{{ $certificate->course->title ?? 'Course Title' }}</h3>
                            
                            <div class="certificate-meta">
                                <span>
                                    <i class="fas fa-calendar-alt"></i>
                                    {{ \Carbon\Carbon::parse($certificate->issue_date ?? now())->format('M d, Y') }}
                                </span>
                                <span>
                                    <i class="fas fa-hashtag"></i>
                                    {{ App\Helpers\TranslationHelper::trans('certificates.certificate_id', ['id' => substr($certificate->certificate_number ?? 'CERT-001', -8)]) }}
                                </span>
                            </div>
                            
                            <div class="certificate-number">
                                {{ App\Helpers\TranslationHelper::trans('certificates.certificate_number', ['number' => $certificate->certificate_number ?? 'EDU-CERT-2025-001']) }}
                            </div>
                        </div>
                        
                        <div class="certificate-footer">
                            @if($certificate->pdf_url ?? false)
                                <a href="{{ $certificate->pdf_url }}" class="btn-download" download>
                                    <i class="fas fa-download"></i> {{ App\Helpers\TranslationHelper::trans('certificates.btn_pdf') }}
                                </a>
                            @endif
                            
                            <button class="btn-share" onclick="shareCertificate('{{ $certificate->certificate_number ?? '' }}')">
                                <i class="fas fa-share-alt"></i> {{ App\Helpers\TranslationHelper::trans('certificates.btn_share') }}
                            </button>
                            
                            <a href="{{ route('certificates.show', $certificate->id ?? '#') }}" class="btn-view">
                                <i class="fas fa-eye"></i> {{ App\Helpers\TranslationHelper::trans('certificates.btn_view') }}
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($certificates->hasPages())
                <div class="pagination">
                    {{ $certificates->appends(request()->query())->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-certificate"></i>
                </div>
                <h2 class="empty-title">{{ App\Helpers\TranslationHelper::trans('certificates.empty_title') }}</h2>
                <p class="empty-text">
                    {{ App\Helpers\TranslationHelper::trans('certificates.empty_text') }}
                </p>
                <a href="{{ route('courses') }}" class="empty-btn">
                    <i class="fas fa-graduation-cap"></i>
                    {{ App\Helpers\TranslationHelper::trans('certificates.empty_button') }}
                </a>
            </div>
        @endif
    </main>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Share certificate function
        window.shareCertificate = function(certificateNumber) {
            const url = window.location.href;
            const text = `I just earned a certificate on EDUCONECX! 🎓 Check out my achievement: ${url}`;
            
            if (navigator.share) {
                navigator.share({
                    title: 'My EDUCONECX Certificate',
                    text: text,
                    url: url,
                }).catch(console.error);
            } else {
                // Fallback - copy to clipboard
                navigator.clipboard.writeText(text).then(() => {
                    showNotification('{{ App\Helpers\TranslationHelper::trans('certificates.notification_copied') }}', 'success');
                }).catch(() => {
                    showNotification('{{ App\Helpers\TranslationHelper::trans('certificates.notification_error') }}', 'error');
                });
            }
        };

        // Share all certificates (profile)
        window.shareAllCertificates = function() {
            const url = window.location.href;
            const text = `Check out my learning achievements on EDUCONECX! I've earned {{ $certificates->total() ?? 0 }} certificates so far. 🎓`;
            
            // LinkedIn sharing
            const linkedinUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(url)}`;
            window.open(linkedinUrl, '_blank', 'width=600,height=400');
        };

        // Show notification
        function showNotification(message, type = 'success') {
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

        const buttons = document.querySelectorAll('.btn-download, .btn-share, .btn-view, .featured-btn, .empty-btn, .share-btn');
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

        // Observe certificate cards and other elements
        document.querySelectorAll('.certificate-card, .achievement-banner, .featured-card').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            observer.observe(el);
        });
    });
</script>
@endpush