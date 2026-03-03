@extends('layouts.main')

@section('title', 'Profile - EDUCONECX | Your Account Settings')

@section('meta_description', 'Manage your profile information, update your avatar, change password, and customize your account settings on EDUCONECX.')

@section('content')
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
        
        /* Text Colors */
        --text-primary: #0A1D44;
        --text-secondary: #2E5C61;
        --text-muted: #5f5f5f;
        --text-light: #FEFDFE;
        
        /* Gradients */
        --gradient-1: linear-gradient(135deg, #0A1D44 0%, #18386E 50%, #2E5C61 100%);
        --gradient-2: linear-gradient(45deg, #FBC60C 0%, #EBD789 50%, #F9F7E9 100%);
        --gradient-3: linear-gradient(135deg, #5AD1E4 0%, #CBD1DA 50%, #FEFDFE 100%);
        
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

    /* Profile Page Section */
    .profile-page-section {
        min-height: calc(100vh - 400px);
        background: linear-gradient(135deg, var(--ivory) 0%, var(--pure-white) 100%);
        padding: 40px 20px;
        font-family: 'Inter', sans-serif;
    }

    .profile-page-container {
        max-width: 1400px;
        width: 100%;
        margin: 0 auto;
        display: flex;
        gap: 30px;
    }

    /* Enhanced Sidebar Styles */
    .profile-page-sidebar {
        width: 320px;
        background: var(--pure-white);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-lg);
        overflow: hidden;
        height: fit-content;
        border: 1px solid rgba(251, 198, 12, 0.1);
        flex-shrink: 0;
        position: relative;
        backdrop-filter: blur(10px);
        transition: var(--transition);
    }

    .profile-page-sidebar:hover {
        box-shadow: var(--shadow-hover);
    }

    .profile-page-cover {
        height: 140px;
        background: var(--gradient-1);
        position: relative;
        overflow: hidden;
    }

    .profile-page-cover::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 30% 50%, rgba(251, 198, 12, 0.2) 0%, transparent 50%);
    }

    .profile-page-cover::after {
        content: '';
        position: absolute;
        width: 200%;
        height: 200%;
        top: -50%;
        left: -50%;
        background: linear-gradient(to bottom right,
                transparent 30%,
                rgba(251, 198, 12, 0.1) 50%,
                transparent 70%);
        animation: profile-page-shine 6s ease-in-out infinite;
    }

    @keyframes profile-page-shine {
        0% {
            transform: translateX(-100%) translateY(-100%) rotate(30deg);
        }
        100% {
            transform: translateX(100%) translateY(100%) rotate(30deg);
        }
    }

    .profile-page-avatar-section {
        position: relative;
        margin-top: -60px;
        padding: 0 24px;
        display: flex;
        justify-content: center;
        z-index: 10;
    }

    .profile-page-avatar-wrapper {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 4px solid var(--pure-white);
        box-shadow: var(--shadow-lg);
        background: var(--pure-white);
        overflow: hidden;
        position: relative;
        cursor: pointer;
        transition: var(--transition);
    }

    .profile-page-avatar-wrapper:hover {
        transform: scale(1.08) rotate(2deg);
        box-shadow: var(--shadow-hover);
    }

    .profile-page-avatar-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-page-avatar-placeholder {
        width: 100%;
        height: 100%;
        background: var(--gradient-1);
        color: var(--pure-white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3.2rem;
        font-weight: 700;
        text-transform: uppercase;
        font-family: 'Inter', sans-serif;
    }

    .profile-page-avatar-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom, rgba(10, 29, 68, 0.3), rgba(10, 29, 68, 0.7));
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: var(--transition);
        backdrop-filter: blur(2px);
    }

    .profile-page-avatar-wrapper:hover .profile-page-avatar-overlay {
        opacity: 1;
    }

    .profile-page-avatar-overlay i {
        color: var(--pure-white);
        font-size: 1.8rem;
        transform: translateY(0);
        transition: var(--transition);
    }

    .profile-page-avatar-wrapper:hover .profile-page-avatar-overlay i {
        transform: translateY(-3px);
    }

    .profile-page-info {
        padding: 20px 24px 16px;
        text-align: center;
        border-bottom: 1px solid rgba(251, 198, 12, 0.1);
    }

    .profile-page-name {
        font-size: 1.5rem !important;
        font-weight: 800 !important;
        color: var(--text-primary) !important;
        margin: 0 0 6px 0 !important;
        padding: 0 !important;
        line-height: 1.3 !important;
        background: none !important;
        -webkit-text-fill-color: var(--text-primary) !important;
        letter-spacing: -0.5px;
    }

    .profile-page-email {
        color: var(--text-muted) !important;
        font-size: 0.9rem !important;
        margin: 0 0 16px 0 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 6px !important;
        background: var(--ivory) !important;
        padding: 8px 14px !important;
        border-radius: var(--radius-full) !important;
        width: fit-content !important;
        margin-left: auto !important;
        margin-right: auto !important;
        border: 1px solid rgba(251, 198, 12, 0.2) !important;
    }

    .profile-page-email i {
        color: var(--bright-amber) !important;
        font-size: 0.8rem !important;
    }

    .profile-page-badge {
        display: inline-flex !important;
        align-items: center !important;
        gap: 8px !important;
        padding: 8px 16px !important;
        background: linear-gradient(145deg, var(--ivory), var(--pure-white)) !important;
        border-radius: var(--radius-full) !important;
        font-size: 0.8rem !important;
        color: var(--bright-amber) !important;
        font-weight: 600 !important;
        border: 1px solid rgba(251, 198, 12, 0.2) !important;
        box-shadow: var(--shadow-sm) !important;
    }

    .profile-page-badge i {
        color: var(--sky-blue) !important;
    }

    .profile-page-stats {
        display: flex;
        justify-content: space-around;
        padding: 20px 16px;
        border-bottom: 1px solid rgba(251, 198, 12, 0.1);
        background: var(--ivory);
    }

    .profile-page-stat-item {
        text-align: center;
        position: relative;
        flex: 1;
    }

    .profile-page-stat-item:not(:last-child)::after {
        content: '';
        position: absolute;
        right: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 1px;
        height: 30px;
        background: linear-gradient(to bottom, transparent, var(--bright-amber), transparent);
    }

    .profile-page-stat-value {
        font-size: 1.6rem !important;
        font-weight: 800 !important;
        background: var(--gradient-1) !important;
        -webkit-background-clip: text !important;
        -webkit-text-fill-color: transparent !important;
        background-clip: text !important;
        margin: 0 0 4px 0 !important;
        line-height: 1 !important;
    }

    .profile-page-stat-label {
        color: var(--text-muted) !important;
        font-size: 0.75rem !important;
        font-weight: 600 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px !important;
    }

    /* Enhanced Avatar Upload */
    .profile-page-avatar-upload {
        background: var(--ivory);
        border-radius: var(--radius-lg);
        padding: 20px;
        margin: 16px;
        border: 2px dashed var(--bright-amber);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }

    .profile-page-avatar-upload::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(145deg, rgba(251, 198, 12, 0.02), rgba(90, 209, 228, 0.02));
        opacity: 0;
        transition: var(--transition);
    }

    .profile-page-avatar-upload:hover::before {
        opacity: 1;
    }

    .profile-page-avatar-upload:hover {
        border-color: var(--bright-amber);
        background: var(--pure-white);
        transform: translateY(-2px);
        box-shadow: var(--shadow-hover);
    }

    .profile-page-file-input {
        position: relative;
        margin-bottom: 12px;
    }

    .profile-page-file-input input {
        position: absolute;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
        z-index: 3;
    }

    .profile-page-file-label {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 10px !important;
        padding: 14px !important;
        background: var(--pure-white) !important;
        border: 1px solid rgba(251, 198, 12, 0.2) !important;
        border-radius: var(--radius-md) !important;
        font-weight: 600 !important;
        color: var(--text-secondary) !important;
        transition: var(--transition) !important;
        cursor: pointer !important;
        position: relative !important;
        z-index: 2 !important;
        margin: 0 !important;
        font-size: 0.95rem !important;
        box-shadow: var(--shadow-sm) !important;
    }

    .profile-page-file-label:hover {
        border-color: var(--bright-amber) !important;
        color: var(--bright-amber) !important;
        transform: translateY(-2px) !important;
        box-shadow: var(--shadow-md) !important;
    }

    .profile-page-file-label i {
        font-size: 1.2rem !important;
        color: var(--sky-blue) !important;
        transition: var(--transition) !important;
    }

    .profile-page-file-label:hover i {
        transform: scale(1.1) rotate(5deg) !important;
    }

    .profile-page-upload-btn {
        width: 100% !important;
        padding: 14px !important;
        background: var(--gradient-1) !important;
        color: var(--pure-white) !important;
        border: none !important;
        border-radius: var(--radius-md) !important;
        font-weight: 700 !important;
        cursor: pointer !important;
        transition: var(--transition) !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 8px !important;
        box-shadow: var(--shadow-md) !important;
        font-size: 0.95rem !important;
        position: relative !important;
        overflow: hidden !important;
    }

    .profile-page-upload-btn::before {
        content: '';
        position: absolute;
        inset: 0;
        background: var(--gradient-2);
        opacity: 0;
        transition: var(--transition);
    }

    .profile-page-upload-btn:hover::before {
        opacity: 1;
    }

    .profile-page-upload-btn:hover {
        transform: translateY(-2px) !important;
        box-shadow: var(--shadow-hover) !important;
    }

    .profile-page-upload-btn i {
        transition: var(--transition) !important;
        position: relative;
        z-index: 1;
    }

    .profile-page-upload-btn:hover i {
        transform: translateY(-3px) !important;
    }

    .profile-page-upload-note {
        font-size: 0.75rem !important;
        color: var(--text-muted) !important;
        margin-top: 12px !important;
        display: flex !important;
        align-items: center !important;
        gap: 6px !important;
        padding: 6px 10px !important;
        background: rgba(203, 213, 225, 0.2) !important;
        border-radius: var(--radius-full) !important;
        width: fit-content !important;
    }

    .profile-page-upload-note i {
        color: var(--sky-blue) !important;
    }

    /* Enhanced Profile Menu */
    .profile-page-menu {
        padding: 16px;
    }

    .profile-page-menu-item {
        display: flex !important;
        align-items: center !important;
        gap: 14px !important;
        padding: 14px 16px !important;
        border-radius: var(--radius-md) !important;
        color: var(--text-secondary) !important;
        text-decoration: none !important;
        transition: var(--transition) !important;
        margin-bottom: 4px !important;
        cursor: pointer !important;
        position: relative !important;
        font-size: 0.95rem !important;
        font-weight: 500 !important;
        border: 1px solid transparent !important;
    }

    .profile-page-menu-item::before {
        content: '';
        position: absolute;
        left: -1px;
        top: 8px;
        height: calc(100% - 16px);
        width: 4px;
        background: var(--gradient-2);
        border-radius: 0 4px 4px 0;
        transform: scaleX(0);
        transition: var(--transition);
        opacity: 0.5;
    }

    .profile-page-menu-item:hover::before {
        transform: scaleX(1);
    }

    .profile-page-menu-item i {
        width: 24px;
        font-size: 1.1rem;
        color: var(--khaki-beige);
        transition: var(--transition);
        text-align: center;
    }

    .profile-page-menu-item span {
        flex: 1;
        transition: var(--transition);
    }

    .profile-page-menu-item:hover {
        background: linear-gradient(145deg, var(--pure-white), var(--ivory));
        border-color: rgba(251, 198, 12, 0.2);
        color: var(--text-primary);
        transform: translateX(5px);
        box-shadow: var(--shadow-sm);
    }

    .profile-page-menu-item:hover i {
        color: var(--bright-amber);
        transform: scale(1.1);
    }

    .profile-page-menu-item:hover span {
        transform: translateX(3px);
    }

    .profile-page-menu-item.active {
        background: linear-gradient(145deg, var(--ivory), rgba(251, 198, 12, 0.05));
        border-color: var(--bright-amber);
        color: var(--bright-amber);
        font-weight: 600;
        box-shadow: var(--shadow-md);
    }

    .profile-page-menu-item.active::before {
        transform: scaleX(1);
        opacity: 1;
    }

    .profile-page-menu-item.active i {
        color: var(--bright-amber);
    }

    .profile-page-menu-item::after {
        content: '→';
        position: absolute;
        right: 16px;
        opacity: 0;
        transform: translateX(-10px);
        transition: var(--transition);
        color: var(--sky-blue);
        font-weight: 600;
    }

    .profile-page-menu-item:hover::after {
        opacity: 1;
        transform: translateX(0);
    }

    .profile-page-menu-item.active::after {
        content: '';
        position: absolute;
        right: 16px;
        width: 6px;
        height: 6px;
        background: var(--bright-amber);
        border-radius: 50%;
        opacity: 1;
        box-shadow: 0 0 0 3px rgba(251, 198, 12, 0.15);
        animation: profile-page-pulse 2s infinite;
    }

    @keyframes profile-page-pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(251, 198, 12, 0.4);
        }
        70% {
            box-shadow: 0 0 0 6px rgba(251, 198, 12, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(251, 198, 12, 0);
        }
    }

    /* Main Content */
    .profile-page-main {
        flex: 1;
        min-width: 0;
    }

    .profile-page-header {
        margin-bottom: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .profile-page-title {
        font-size: 2rem !important;
        font-weight: 800 !important;
        color: var(--text-primary) !important;
        margin: 0 !important;
        display: flex !important;
        align-items: center !important;
        gap: 12px !important;
    }

    .profile-page-title i {
        width: 50px !important;
        height: 50px !important;
        background: var(--gradient-1) !important;
        color: var(--pure-white) !important;
        border-radius: var(--radius-md) !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        font-size: 1.5rem !important;
        box-shadow: var(--shadow-lg) !important;
    }

    .profile-page-back-btn {
        display: inline-flex !important;
        align-items: center !important;
        gap: 8px !important;
        padding: 12px 25px !important;
        background: var(--pure-white) !important;
        color: var(--text-primary) !important;
        border: 2px solid var(--pale-slate) !important;
        border-radius: var(--radius-full) !important;
        text-decoration: none !important;
        font-weight: 600 !important;
        transition: var(--transition) !important;
        box-shadow: var(--shadow-sm) !important;
        font-size: 0.95rem !important;
    }

    .profile-page-back-btn:hover {
        background: var(--gradient-1) !important;
        color: var(--pure-white) !important;
        border-color: transparent !important;
        transform: translateX(-5px) !important;
        box-shadow: var(--shadow-hover) !important;
    }

    .profile-page-back-btn i {
        transition: var(--transition) !important;
    }

    .profile-page-back-btn:hover i {
        transform: translateX(-3px) !important;
    }

    /* Form Cards */
    .profile-page-form-card {
        background: var(--pure-white);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-lg);
        border: 1px solid rgba(251, 198, 12, 0.1);
        overflow: hidden;
        margin-bottom: 30px;
    }

    .profile-page-form-header {
        padding: 20px 25px;
        background: linear-gradient(145deg, var(--pure-white), var(--ivory));
        border-bottom: 1px solid rgba(251, 198, 12, 0.1);
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .profile-page-form-header i {
        width: 40px;
        height: 40px;
        background: var(--gradient-1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--pure-white);
        font-size: 1.2rem;
        box-shadow: var(--shadow-sm);
    }

    .profile-page-form-header h3 {
        font-size: 1.3rem !important;
        font-weight: 700 !important;
        color: var(--text-primary) !important;
        margin: 0 !important;
        padding: 0 !important;
        background: none !important;
    }

    .profile-page-form-body {
        padding: 30px;
    }

    .profile-page-form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-bottom: 20px;
    }

    .profile-page-form-group {
        margin-bottom: 20px;
    }

    .profile-page-full-width {
        grid-column: span 2;
    }

    .profile-page-form-label {
        display: block !important;
        margin: 0 0 8px 0 !important;
        padding: 0 !important;
        font-weight: 700 !important;
        color: var(--text-primary) !important;
        font-size: 0.95rem !important;
        text-align: left !important;
        line-height: 1.5 !important;
    }

    .profile-page-form-label i {
        color: var(--bright-amber) !important;
        margin-right: 8px !important;
        width: 16px !important;
    }

    .profile-page-input {
        width: 100% !important;
        padding: 12px 15px !important;
        border: 2px solid var(--pale-slate) !important;
        border-radius: var(--radius-md) !important;
        font-size: 0.95rem !important;
        transition: var(--transition) !important;
        background: var(--pure-white) !important;
        color: var(--text-primary) !important;
        margin: 0 !important;
        box-sizing: border-box !important;
    }

    .profile-page-input:focus {
        outline: none !important;
        border-color: var(--bright-amber) !important;
        box-shadow: 0 0 0 4px rgba(251, 198, 12, 0.1) !important;
    }

    .profile-page-input.is-invalid {
        border-color: var(--bright-amber) !important;
    }

    textarea.profile-page-input {
        resize: vertical;
        min-height: 100px;
    }

    select.profile-page-input {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23FBC60C' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 15px center;
        background-size: 16px;
        padding-right: 45px;
    }

    .profile-page-input-group {
        position: relative;
        display: flex;
        align-items: center;
    }

    .profile-page-input-group .profile-page-input {
        padding-right: 45px;
    }

    .profile-page-toggle-password {
        position: absolute !important;
        right: 12px !important;
        background: none !important;
        border: none !important;
        color: var(--khaki-beige) !important;
        cursor: pointer !important;
        padding: 5px !important;
        transition: var(--transition) !important;
        font-size: 1rem !important;
    }

    .profile-page-toggle-password:hover {
        color: var(--bright-amber) !important;
    }

    .profile-page-error-feedback {
        color: var(--bright-amber) !important;
        font-size: 0.85rem !important;
        margin-top: 5px !important;
        display: flex !important;
        align-items: center !important;
        gap: 5px !important;
    }

    .profile-page-error-feedback i {
        font-size: 0.8rem !important;
    }

    .profile-page-alert {
        padding: 16px 20px;
        border-radius: var(--radius-md);
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 12px;
        animation: profile-page-slideInDown 0.5s ease-out;
        border: 1px solid transparent;
    }

    .profile-page-alert-success {
        background: rgba(90, 209, 228, 0.1);
        color: var(--dark-slate);
        border-color: rgba(90, 209, 228, 0.3);
        border-left: 4px solid var(--sky-blue);
    }

    .profile-page-alert-danger {
        background: rgba(251, 198, 12, 0.1);
        color: var(--prussian-blue);
        border-color: rgba(251, 198, 12, 0.3);
        border-left: 4px solid var(--bright-amber);
    }

    .profile-page-alert i {
        font-size: 1.2rem;
    }

    .profile-page-alert-content {
        flex: 1;
    }

    .profile-page-alert-content h4 {
        font-weight: 700;
        margin: 0 0 5px 0;
        font-size: 1rem;
        color: var(--text-primary);
    }

    .profile-page-alert-content p {
        font-size: 0.95rem;
        opacity: 0.9;
        margin: 0;
        color: var(--text-secondary);
    }

    .profile-page-alert-content ul {
        margin: 8px 0 0 0;
        padding-left: 20px;
        color: var(--text-secondary);
    }

    .profile-page-alert-content li {
        margin-bottom: 3px;
    }

    .profile-page-alert-close {
        background: none;
        border: none;
        color: currentColor;
        cursor: pointer;
        opacity: 0.5;
        transition: var(--transition);
        padding: 5px;
    }

    .profile-page-alert-close:hover {
        opacity: 1;
    }

    .profile-page-form-actions {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid rgba(251, 198, 12, 0.1);
    }

    .profile-page-btn-primary {
        padding: 12px 30px !important;
        background: var(--gradient-1) !important;
        color: var(--pure-white) !important;
        border: none !important;
        border-radius: var(--radius-full) !important;
        font-weight: 700 !important;
        cursor: pointer !important;
        transition: var(--transition) !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 8px !important;
        box-shadow: var(--shadow-md) !important;
        font-size: 0.95rem !important;
    }

    .profile-page-btn-primary:hover {
        background: var(--gradient-2) !important;
        color: var(--prussian-blue) !important;
        transform: translateY(-2px) !important;
        box-shadow: var(--shadow-hover) !important;
    }

    .profile-page-btn-primary i {
        transition: var(--transition) !important;
    }

    .profile-page-btn-primary:hover i {
        transform: translateX(3px) !important;
    }

    .profile-page-btn-secondary {
        padding: 12px 30px !important;
        background: transparent !important;
        color: var(--text-muted) !important;
        border: 2px solid var(--pale-slate) !important;
        border-radius: var(--radius-full) !important;
        font-weight: 700 !important;
        cursor: pointer !important;
        transition: var(--transition) !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 8px !important;
        font-size: 0.95rem !important;
    }

    .profile-page-btn-secondary:hover {
        border-color: var(--bright-amber) !important;
        color: var(--bright-amber) !important;
        transform: translateY(-2px) !important;
        box-shadow: var(--shadow-sm) !important;
    }

    .profile-page-btn-warning {
        padding: 12px 30px !important;
        background: var(--gradient-1) !important;
        color: var(--pure-white) !important;
        border: none !important;
        border-radius: var(--radius-full) !important;
        font-weight: 700 !important;
        cursor: pointer !important;
        transition: var(--transition) !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 8px !important;
        box-shadow: var(--shadow-md) !important;
        font-size: 0.95rem !important;
    }

    .profile-page-btn-warning:hover {
        background: var(--gradient-2) !important;
        color: var(--prussian-blue) !important;
        transform: translateY(-2px) !important;
        box-shadow: var(--shadow-hover) !important;
    }

    .profile-page-btn-warning i {
        transition: var(--transition) !important;
    }

    .profile-page-btn-warning:hover i {
        transform: rotate(20deg) !important;
    }

    /* Password Strength */
    .profile-page-password-strength {
        margin-top: 12px;
    }

    .profile-page-strength-meter {
        display: flex;
        gap: 5px;
        margin-bottom: 8px;
    }

    .profile-page-strength-segment {
        height: 4px;
        flex: 1;
        background: var(--pale-slate);
        border-radius: var(--radius-full);
        transition: all 0.3s ease;
    }

    .profile-page-strength-segment.active.weak {
        background: var(--bright-amber) !important;
    }

    .profile-page-strength-segment.active.medium {
        background: var(--sky-blue) !important;
    }

    .profile-page-strength-segment.active.strong {
        background: var(--dark-slate) !important;
    }

    .profile-page-strength-text {
        font-size: 0.8rem !important;
        color: var(--text-muted) !important;
        font-weight: 600 !important;
    }

    /* Checkbox */
    .profile-page-checkbox {
        display: flex !important;
        align-items: flex-start !important;
        gap: 12px !important;
        padding: 10px !important;
        background: linear-gradient(145deg, var(--ivory), var(--pure-white)) !important;
        border-radius: var(--radius-md) !important;
        border: 1px solid rgba(251, 198, 12, 0.1) !important;
        transition: var(--transition) !important;
        cursor: pointer !important;
        margin: 0 !important;
    }

    .profile-page-checkbox:hover {
        border-color: var(--bright-amber) !important;
        transform: translateY(-2px) !important;
        box-shadow: var(--shadow-sm) !important;
    }

    .profile-page-checkbox input[type="checkbox"] {
        width: 20px !important;
        height: 20px !important;
        margin: 2px 0 0 0 !important;
        accent-color: var(--bright-amber) !important;
        cursor: pointer !important;
        flex-shrink: 0;
    }

    .profile-page-checkbox span {
        font-weight: 600 !important;
        color: var(--text-primary) !important;
        display: block !important;
        margin-bottom: 3px !important;
        font-size: 0.95rem !important;
    }

    .profile-page-checkbox small {
        color: var(--text-muted) !important;
        font-size: 0.8rem !important;
        display: block !important;
        font-weight: normal !important;
    }

    /* Animations */
    @keyframes profile-page-float {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-20px);
        }
    }

    @keyframes profile-page-slideInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes profile-page-spin {
        to {
            transform: rotate(360deg);
        }
    }

    /* Ripple Effect */
    .profile-page-ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
        transform: scale(0);
        animation: profile-page-ripple-animation 0.6s linear;
        pointer-events: none;
    }

    @keyframes profile-page-ripple-animation {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }

    /* Spinner */
    .profile-page-spinner {
        display: inline-block;
        width: 16px;
        height: 16px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        border-top-color: var(--bright-amber);
        animation: profile-page-spin 0.8s linear infinite;
    }

    /* Utility Classes */
    .profile-page-position-relative {
        position: relative;
    }

    .profile-page-overflow-hidden {
        overflow: hidden;
    }

    .profile-page-text-center {
        text-align: center;
    }

    .profile-page-small {
        font-size: 0.85rem !important;
    }

    .profile-page-text-muted {
        color: var(--text-muted) !important;
    }

    .profile-page-mt-2 {
        margin-top: 8px !important;
    }

    .profile-page-mb-0 {
        margin-bottom: 0 !important;
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .profile-page-section {
            padding: 30px 20px;
        }
    }

    @media (max-width: 992px) {
        .profile-page-container {
            flex-direction: column;
        }

        .profile-page-sidebar {
            width: 100%;
        }

        .profile-page-title {
            font-size: 1.8rem !important;
        }

        .profile-page-form-grid {
            grid-template-columns: 1fr;
        }

        .profile-page-full-width {
            grid-column: span 1;
        }
    }

    @media (max-width: 768px) {
        .profile-page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .profile-page-form-actions {
            flex-direction: column;
        }

        .profile-page-btn-primary,
        .profile-page-btn-secondary,
        .profile-page-btn-warning {
            width: 100%;
            justify-content: center;
        }

        .profile-page-form-body {
            padding: 20px;
        }

        .profile-page-stats {
            padding: 15px;
        }

        .profile-page-stat-value {
            font-size: 1.3rem !important;
        }
    }

    @media (max-width: 576px) {
        .profile-page-section {
            padding: 20px 15px;
        }

        .profile-page-title {
            font-size: 1.5rem !important;
        }

        .profile-page-title i {
            width: 40px !important;
            height: 40px !important;
            font-size: 1.2rem !important;
        }

        .profile-page-back-btn {
            width: 100%;
            justify-content: center;
        }

        .profile-page-name {
            font-size: 1.2rem !important;
        }

        .profile-page-avatar-wrapper {
            width: 100px;
            height: 100px;
        }

        .profile-page-avatar-placeholder {
            font-size: 2.5rem;
        }

        .profile-page-avatar-upload {
            margin: 12px;
            padding: 15px;
        }

        .profile-page-menu-item {
            padding: 12px !important;
        }

        .profile-page-menu-item i {
            font-size: 1rem;
        }
    }
</style>

<section class="profile-page-section">
    <div class="profile-page-container">
        <!-- Profile Sidebar - Enhanced -->
        <aside class="profile-page-sidebar">
            <div class="profile-page-cover"></div>

            <div class="profile-page-avatar-section">
                <div class="profile-page-avatar-wrapper" onclick="document.getElementById('avatarInput').click()">
                    @if(Auth::user()->avatar)
                    <img src="{{ Storage::url(Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="profile-page-avatar-image">
                    @else
                    <div class="profile-page-avatar-placeholder">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    @endif
                    <div class="profile-page-avatar-overlay">
                        <i class="fas fa-camera"></i>
                    </div>
                </div>
            </div>

            <div class="profile-page-info">
                <h2 class="profile-page-name">{{ Auth::user()->name }}</h2>
                <p class="profile-page-email">
                    <i class="fas fa-envelope"></i>
                    {{ Auth::user()->email }}
                </p>
                <span class="profile-page-badge">
                    <i class="fas fa-calendar-alt"></i>
                    Member since {{ \Carbon\Carbon::parse(Auth::user()->created_at ?? now())->format('M Y') }}
                </span>
            </div>

            <div class="profile-page-stats">
                <div class="profile-page-stat-item">
                    <div class="profile-page-stat-value">{{ $stats['courses_completed'] ?? 0 }}</div>
                    <div class="profile-page-stat-label">Completed</div>
                </div>
                <div class="profile-page-stat-item">
                    <div class="profile-page-stat-value">{{ $stats['certificates'] ?? 0 }}</div>
                    <div class="profile-page-stat-label">Certificates</div>
                </div>
                <div class="profile-page-stat-item">
                    <div class="profile-page-stat-value">{{ $stats['quizzes_taken'] ?? 0 }}</div>
                    <div class="profile-page-stat-label">Quizzes</div>
                </div>
            </div>

            <!-- Avatar Upload Form - Enhanced -->
            <div class="profile-page-avatar-upload">
                <form action="{{ route('profile.avatar') }}" method="POST" enctype="multipart/form-data" id="avatarForm">
                    @csrf
                    <div class="profile-page-file-input">
                        <input type="file" name="avatar" id="avatarInput" accept="image/*" onchange="previewAvatar(this)">
                        <label for="avatarInput" class="profile-page-file-label">
                            <i class="fas fa-cloud-upload-alt"></i>
                            Choose New Avatar
                        </label>
                    </div>
                    <button type="submit" class="profile-page-upload-btn" id="uploadBtn" style="display: none;">
                        <i class="fas fa-upload"></i>
                        Upload Avatar
                    </button>
                </form>
                <div class="profile-page-upload-note">
                    <i class="fas fa-info-circle"></i>
                    Max size: 2MB. Supported: JPG, PNG, GIF
                </div>
            </div>

            <!-- Quick Menu - Enhanced -->
            <div class="profile-page-menu">
                <a href="#profile-info" class="profile-page-menu-item active" onclick="smoothScroll('profile-info')">
                    <i class="fas fa-user"></i>
                    <span>Profile Information</span>
                </a>
                <a href="#change-password" class="profile-page-menu-item" onclick="smoothScroll('change-password')">
                    <i class="fas fa-lock"></i>
                    <span>Change Password</span>
                </a>
                <a href="#notification-settings" class="profile-page-menu-item" onclick="smoothScroll('notification-settings')">
                    <i class="fas fa-bell"></i>
                    <span>Notification Settings</span>
                </a>
                <a href="#privacy-settings" class="profile-page-menu-item" onclick="smoothScroll('privacy-settings')">
                    <i class="fas fa-shield-alt"></i>
                    <span>Privacy Settings</span>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="profile-page-main">
            <!-- Page Header -->
            <div class="profile-page-header">
                <h1 class="profile-page-title">
                    <i class="fas fa-user-circle"></i>
                    My Profile
                </h1>

                <a href="{{ route('dashboard') }}" class="profile-page-back-btn">
                    <i class="fas fa-arrow-left"></i>
                    Back to Dashboard
                </a>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
            <div class="profile-page-alert profile-page-alert-success" id="successAlert">
                <i class="fas fa-check-circle"></i>
                <div class="profile-page-alert-content">
                    <p>{{ session('success') }}</p>
                </div>
                <button class="profile-page-alert-close" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            @endif

            @if($errors->any())
            <div class="profile-page-alert profile-page-alert-danger" id="errorAlert">
                <i class="fas fa-exclamation-circle"></i>
                <div class="profile-page-alert-content">
                    <h4>Please fix the following errors:</h4>
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button class="profile-page-alert-close" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            @endif

            <!-- Profile Information Form -->
            <div id="profile-info" class="profile-page-form-card">
                <div class="profile-page-form-header">
                    <i class="fas fa-user-edit"></i>
                    <h3>Profile Information</h3>
                </div>

                <div class="profile-page-form-body">
                    <form action="{{ route('profile.update') }}" method="POST" id="profileForm">
                        @csrf
                        @method('PUT')

                        <div class="profile-page-form-grid">
                            <div class="profile-page-form-group">
                                <label class="profile-page-form-label">
                                    <i class="fas fa-user"></i>
                                    First Name
                                </label>
                                <input type="text"
                                    name="first_name"
                                    class="profile-page-input @error('first_name') is-invalid @enderror"
                                    value="{{ old('first_name', Auth::user()->first_name) }}"
                                    required>
                                @error('first_name')
                                <div class="profile-page-error-feedback">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="profile-page-form-group">
                                <label class="profile-page-form-label">
                                    <i class="fas fa-user"></i>
                                    Last Name
                                </label>
                                <input type="text"
                                    name="last_name"
                                    class="profile-page-input @error('last_name') is-invalid @enderror"
                                    value="{{ old('last_name', Auth::user()->last_name) }}"
                                    required>
                                @error('last_name')
                                <div class="profile-page-error-feedback">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="profile-page-form-group profile-page-full-width">
                                <label class="profile-page-form-label">
                                    <i class="fas fa-envelope"></i>
                                    Email Address
                                </label>
                                <input type="email"
                                    name="email"
                                    class="profile-page-input @error('email') is-invalid @enderror"
                                    value="{{ old('email', Auth::user()->email) }}"
                                    required>
                                @error('email')
                                <div class="profile-page-error-feedback">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="profile-page-form-group">
                                <label class="profile-page-form-label">
                                    <i class="fas fa-phone"></i>
                                    Phone Number
                                </label>
                                <input type="tel"
                                    name="phone"
                                    class="profile-page-input @error('phone') is-invalid @enderror"
                                    value="{{ old('phone', Auth::user()->phone) }}"
                                    placeholder="+1 (555) 000-0000">
                                @error('phone')
                                <div class="profile-page-error-feedback">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="profile-page-form-group">
                                <label class="profile-page-form-label">
                                    <i class="fas fa-map-marker-alt"></i>
                                    Address
                                </label>
                                <input type="text"
                                    name="address"
                                    class="profile-page-input @error('address') is-invalid @enderror"
                                    value="{{ old('address', Auth::user()->address) }}"
                                    placeholder="Street address">
                                @error('address')
                                <div class="profile-page-error-feedback">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="profile-page-form-group">
                                <label class="profile-page-form-label">
                                    <i class="fas fa-city"></i>
                                    City
                                </label>
                                <input type="text"
                                    name="city"
                                    class="profile-page-input @error('city') is-invalid @enderror"
                                    value="{{ old('city', Auth::user()->city) }}">
                                @error('city')
                                <div class="profile-page-error-feedback">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="profile-page-form-group">
                                <label class="profile-page-form-label">
                                    <i class="fas fa-map"></i>
                                    State
                                </label>
                                <input type="text"
                                    name="state"
                                    class="profile-page-input @error('state') is-invalid @enderror"
                                    value="{{ old('state', Auth::user()->state) }}">
                                @error('state')
                                <div class="profile-page-error-feedback">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="profile-page-form-group">
                                <label class="profile-page-form-label">
                                    <i class="fas fa-mail-bulk"></i>
                                    Postal Code
                                </label>
                                <input type="text"
                                    name="postal_code"
                                    class="profile-page-input @error('postal_code') is-invalid @enderror"
                                    value="{{ old('postal_code', Auth::user()->postal_code) }}">
                                @error('postal_code')
                                <div class="profile-page-error-feedback">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="profile-page-form-group">
                                <label class="profile-page-form-label">
                                    <i class="fas fa-globe"></i>
                                    Country
                                </label>
                                <select name="country" class="profile-page-input @error('country') is-invalid @enderror">
                                    <option value="">Select Country</option>
                                    <option value="US" {{ (old('country', Auth::user()->country) == 'US') ? 'selected' : '' }}>United States</option>
                                    <option value="CA" {{ (old('country', Auth::user()->country) == 'CA') ? 'selected' : '' }}>Canada</option>
                                    <option value="UK" {{ (old('country', Auth::user()->country) == 'UK') ? 'selected' : '' }}>United Kingdom</option>
                                    <option value="AU" {{ (old('country', Auth::user()->country) == 'AU') ? 'selected' : '' }}>Australia</option>
                                    <option value="IN" {{ (old('country', Auth::user()->country) == 'IN') ? 'selected' : '' }}>India</option>
                                </select>
                                @error('country')
                                <div class="profile-page-error-feedback">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="profile-page-form-group profile-page-full-width">
                                <label class="profile-page-form-label">
                                    <i class="fas fa-align-left"></i>
                                    Bio
                                </label>
                                <textarea name="bio"
                                    class="profile-page-input @error('bio') is-invalid @enderror"
                                    rows="4"
                                    placeholder="Tell us a little about yourself...">{{ old('bio', Auth::user()->bio) }}</textarea>
                                @error('bio')
                                <div class="profile-page-error-feedback">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="profile-page-form-actions">
                            <button type="reset" class="profile-page-btn-secondary" onclick="resetForm('profileForm')">
                                <i class="fas fa-undo"></i>
                                Reset
                            </button>
                            <button type="submit" class="profile-page-btn-primary">
                                <i class="fas fa-save"></i>
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Change Password Form -->
            <div id="change-password" class="profile-page-form-card">
                <div class="profile-page-form-header">
                    <i class="fas fa-lock"></i>
                    <h3>Change Password</h3>
                </div>

                <div class="profile-page-form-body">
                    <form action="{{ route('profile.password') }}" method="POST" id="passwordForm">
                        @csrf

                        <div class="profile-page-form-group">
                            <label class="profile-page-form-label">
                                <i class="fas fa-key"></i>
                                Current Password
                            </label>
                            <div class="profile-page-input-group">
                                <input type="password"
                                    name="current_password"
                                    class="profile-page-input @error('current_password') is-invalid @enderror"
                                    id="current_password"
                                    required>
                                <button type="button" class="profile-page-toggle-password" onclick="togglePassword('current_password')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('current_password')
                            <div class="profile-page-error-feedback">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="profile-page-form-group">
                            <label class="profile-page-form-label">
                                <i class="fas fa-lock"></i>
                                New Password
                            </label>
                            <div class="profile-page-input-group">
                                <input type="password"
                                    name="new_password"
                                    class="profile-page-input @error('new_password') is-invalid @enderror"
                                    id="new_password"
                                    oninput="checkPasswordStrength(this.value)"
                                    required>
                                <button type="button" class="profile-page-toggle-password" onclick="togglePassword('new_password')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>

                            <!-- Password Strength Meter -->
                            <div class="profile-page-password-strength" id="passwordStrength">
                                <div class="profile-page-strength-meter">
                                    <div class="profile-page-strength-segment" id="strength1"></div>
                                    <div class="profile-page-strength-segment" id="strength2"></div>
                                    <div class="profile-page-strength-segment" id="strength3"></div>
                                    <div class="profile-page-strength-segment" id="strength4"></div>
                                </div>
                                <span class="profile-page-strength-text" id="strengthText">Enter a password</span>
                            </div>
                            @error('new_password')
                            <div class="profile-page-error-feedback">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="profile-page-form-group">
                            <label class="profile-page-form-label">
                                <i class="fas fa-lock"></i>
                                Confirm New Password
                            </label>
                            <div class="profile-page-input-group">
                                <input type="password"
                                    name="new_password_confirmation"
                                    class="profile-page-input"
                                    id="new_password_confirmation"
                                    required>
                                <button type="button" class="profile-page-toggle-password" onclick="togglePassword('new_password_confirmation')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="profile-page-form-actions">
                            <button type="reset" class="profile-page-btn-secondary" onclick="resetForm('passwordForm')">
                                <i class="fas fa-undo"></i>
                                Reset
                            </button>
                            <button type="submit" class="profile-page-btn-warning">
                                <i class="fas fa-sync-alt"></i>
                                Change Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Notification Settings -->
            <div id="notification-settings" class="profile-page-form-card">
                <div class="profile-page-form-header">
                    <i class="fas fa-bell"></i>
                    <h3>Notification Settings</h3>
                </div>

                <div class="profile-page-form-body">
                    <form action="#" method="POST" id="notificationForm">
                        @csrf

                        <div class="profile-page-form-group">
                            <label class="profile-page-checkbox">
                                <input type="checkbox" name="email_notifications" {{ Auth::user()->email_notifications ? 'checked' : '' }}>
                                <span>
                                    Email Notifications
                                    <small>Receive updates about new courses and promotions</small>
                                </span>
                            </label>
                        </div>

                        <div class="profile-page-form-group">
                            <label class="profile-page-checkbox">
                                <input type="checkbox" name="course_updates" {{ Auth::user()->course_updates ? 'checked' : '' }}>
                                <span>
                                    Course Updates
                                    <small>Get notified when your courses have new content</small>
                                </span>
                            </label>
                        </div>

                        <div class="profile-page-form-group">
                            <label class="profile-page-checkbox">
                                <input type="checkbox" name="achievement_alerts" {{ Auth::user()->achievement_alerts ? 'checked' : '' }}>
                                <span>
                                    Achievement Alerts
                                    <small>Celebrate when you earn new certificates</small>
                                </span>
                            </label>
                        </div>

                        <div class="profile-page-form-actions">
                            <button type="submit" class="profile-page-btn-primary">
                                <i class="fas fa-save"></i>
                                Save Preferences
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Privacy Settings -->
            <div id="privacy-settings" class="profile-page-form-card">
                <div class="profile-page-form-header">
                    <i class="fas fa-shield-alt"></i>
                    <h3>Privacy Settings</h3>
                </div>

                <div class="profile-page-form-body">
                    <form action="#" method="POST" id="privacyForm">
                        @csrf

                        <div class="profile-page-form-group">
                            <label class="profile-page-checkbox">
                                <input type="checkbox" name="public_profile" {{ Auth::user()->public_profile ? 'checked' : '' }}>
                                <span>
                                    Public Profile
                                    <small>Allow others to view your profile and achievements</small>
                                </span>
                            </label>
                        </div>

                        <div class="profile-page-form-group">
                            <label class="profile-page-checkbox">
                                <input type="checkbox" name="show_activity" {{ Auth::user()->show_activity ? 'checked' : '' }}>
                                <span>
                                    Show Activity
                                    <small>Display your learning activity on your profile</small>
                                </span>
                            </label>
                        </div>

                        <div class="profile-page-form-group">
                            <label class="profile-page-checkbox">
                                <input type="checkbox" name="show_certificates" {{ Auth::user()->show_certificates ? 'checked' : '' }}>
                                <span>
                                    Show Certificates
                                    <small>Display your earned certificates publicly</small>
                                </span>
                            </label>
                        </div>

                        <div class="profile-page-form-actions">
                            <button type="submit" class="profile-page-btn-primary">
                                <i class="fas fa-save"></i>
                                Save Preferences
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle password visibility
        window.togglePassword = function(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = event.currentTarget.querySelector('i');

            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        };

        // Password strength checker
        window.checkPasswordStrength = function(password) {
            if (!password) {
                resetStrengthMeter();
                return;
            }

            const strengthSegments = [
                document.getElementById('strength1'),
                document.getElementById('strength2'),
                document.getElementById('strength3'),
                document.getElementById('strength4')
            ];
            const strengthText = document.getElementById('strengthText');

            let score = 0;

            // Length check
            if (password.length >= 8) score++;
            if (password.length >= 12) score++;

            // Contains number
            if (/\d/.test(password)) score++;

            // Contains special character
            if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) score++;

            // Contains uppercase and lowercase
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) score++;

            // Cap at 4
            score = Math.min(score, 4);

            // Reset all segments
            strengthSegments.forEach(segment => {
                segment.classList.remove('active', 'weak', 'medium', 'strong');
            });

            // Update segments based on strength
            for (let i = 0; i < score; i++) {
                strengthSegments[i].classList.add('active');
                if (score <= 2) {
                    strengthSegments[i].classList.add('weak');
                } else if (score === 3) {
                    strengthSegments[i].classList.add('medium');
                } else if (score === 4) {
                    strengthSegments[i].classList.add('strong');
                }
            }

            const messages = ['Very weak', 'Weak', 'Fair', 'Good', 'Strong'];
            strengthText.textContent = messages[score];
        };

        function resetStrengthMeter() {
            const strengthSegments = document.querySelectorAll('.profile-page-strength-segment');
            const strengthText = document.getElementById('strengthText');

            strengthSegments.forEach(segment => {
                segment.classList.remove('active', 'weak', 'medium', 'strong');
            });

            strengthText.textContent = 'Enter a password';
        }

        // Avatar preview
        window.previewAvatar = function(input) {
            const uploadBtn = document.getElementById('uploadBtn');
            if (input.files && input.files[0]) {
                uploadBtn.style.display = 'flex';

                const reader = new FileReader();
                reader.onload = function(e) {
                    // Optional: Show preview
                };
                reader.readAsDataURL(input.files[0]);
            }
        };

        // Smooth scroll to sections
        window.smoothScroll = function(targetId) {
            const target = document.querySelector(targetId);
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        };

        // Reset form
        window.resetForm = function(formId) {
            document.getElementById(formId).reset();
        };

        // Auto-hide alerts after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('.profile-page-alert');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);

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
            ripple.className = 'profile-page-ripple';

            button.appendChild(ripple);

            setTimeout(() => {
                ripple.remove();
            }, 600);
        }

        const buttons = document.querySelectorAll('.profile-page-btn-primary, .profile-page-btn-secondary, .profile-page-btn-warning, .profile-page-upload-btn, .profile-page-back-btn, .profile-page-file-label');
        buttons.forEach(button => {
            button.classList.add('profile-page-position-relative', 'profile-page-overflow-hidden');
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

        // Observe form cards
        document.querySelectorAll('.profile-page-form-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            observer.observe(card);
        });

        // Active menu item on scroll
        window.addEventListener('scroll', function() {
            const sections = ['profile-info', 'change-password', 'notification-settings', 'privacy-settings'];
            const menuItems = document.querySelectorAll('.profile-page-menu-item');

            let current = '';

            sections.forEach(sectionId => {
                const section = document.getElementById(sectionId);
                if (section) {
                    const sectionTop = section.offsetTop - 150;
                    if (window.scrollY >= sectionTop) {
                        current = '#' + sectionId;
                    }
                }
            });

            menuItems.forEach(item => {
                item.classList.remove('active');
                if (item.getAttribute('onclick') && item.getAttribute('onclick').includes(current)) {
                    item.classList.add('active');
                }
            });
        });

        // Form loading state
        document.getElementById('profileForm')?.addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span class="profile-page-spinner"></span> Saving...';
            submitBtn.disabled = true;

            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 3000);
        });

        document.getElementById('passwordForm')?.addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span class="profile-page-spinner"></span> Changing...';
            submitBtn.disabled = true;
        });
    });

    // Prevent double submission
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
@endsection