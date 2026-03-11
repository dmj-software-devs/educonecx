@extends('layouts.main')

@section('title', $course->title . ' - EDUCONECX')

@section('meta_description', Str::limit($course->excerpt ?? strip_tags($course->description), 160))

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

    /* Hero Section */
    .course-page-hero {
        position: relative;
        background: var(--gradient-1);
        padding: 80px 0;
        overflow: hidden;
        color: var(--pure-white);
    }

    .course-page-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(10, 29, 68, 0.3) 0%, rgba(24, 56, 110, 0.3) 100%);
        z-index: 1;
    }

    .course-page-particles {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    .course-page-particle {
        position: absolute;
        background: rgba(251, 198, 12, 0.1);
        border-radius: 50%;
    }

    .course-page-particle:nth-child(1) {
        width: 300px;
        height: 300px;
        top: -150px;
        right: -150px;
        animation: course-page-float 8s ease-in-out infinite;
    }

    .course-page-particle:nth-child(2) {
        width: 200px;
        height: 200px;
        bottom: -100px;
        left: -100px;
        background: rgba(90, 209, 228, 0.1);
        animation: course-page-float 10s ease-in-out infinite reverse;
    }

    .course-page-particle:nth-child(3) {
        width: 150px;
        height: 150px;
        top: 30%;
        left: 20%;
        background: rgba(235, 215, 137, 0.1);
        animation: course-page-float 12s ease-in-out infinite;
    }

    @keyframes course-page-float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }

    .course-page-hero-content {
        position: relative;
        z-index: 2;
    }

    .course-page-breadcrumb {
        margin-bottom: 20px;
    }

    .course-page-breadcrumb a {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        font-size: 0.95rem;
        transition: var(--transition);
    }

    .course-page-breadcrumb a:hover {
        color: var(--bright-amber);
    }

    .course-page-breadcrumb i {
        font-size: 0.7rem;
        margin: 0 10px;
        color: rgba(255, 255, 255, 0.5);
    }

    .course-page-breadcrumb span {
        color: var(--bright-amber);
        font-size: 0.95rem;
    }

    .course-page-badge-wrapper {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .course-page-badge {
        display: inline-block;
        padding: 6px 16px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: var(--radius-full);
        font-size: 0.85rem;
        font-weight: 600;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(251, 198, 12, 0.3);
    }

    .course-page-badge.featured {
        background: var(--gradient-2);
        color: var(--prussian-blue);
    }

    .course-page-badge.free {
        background: var(--gradient-3);
        color: var(--prussian-blue);
    }

    .course-page-badge.subscription {
        background: var(--gradient-1);
        border-color: var(--bright-amber);
    }

    .course-page-hero-title {
        font-size: clamp(2rem, 5vw, 3rem);
        font-weight: 800;
        margin-bottom: 20px;
        line-height: 1.2;
        color: var(--pure-white);
        text-shadow: 0 2px 4px rgba(10, 29, 68, 0.3);
    }

    .course-page-hero-description {
        font-size: 1.1rem;
        opacity: 0.95;
        margin-bottom: 30px;
        max-width: 800px;
        color: var(--ivory);
        line-height: 1.6;
    }

    .course-page-meta-list {
        display: flex;
        gap: 30px;
        flex-wrap: wrap;
        margin-bottom: 30px;
    }

    .course-page-meta-item {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .course-page-meta-icon {
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.15);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(251, 198, 12, 0.2);
        color: var(--bright-amber);
    }

    .course-page-meta-content h4 {
        font-size: 0.9rem;
        font-weight: 400;
        opacity: 0.8;
        margin: 0 0 5px 0;
        color: var(--ivory);
    }

    .course-page-meta-content p {
        font-size: 1.1rem;
        font-weight: 600;
        margin: 0;
        color: var(--pure-white);
    }

    .course-page-instructor-mini {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-top: 20px;
        padding: 15px 20px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: var(--radius-full);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(251, 198, 12, 0.2);
        max-width: 300px;
    }

    .course-page-instructor-mini-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: var(--gradient-2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        font-weight: 600;
        color: var(--prussian-blue);
    }

    .course-page-instructor-mini-info h4 {
        font-size: 0.9rem;
        font-weight: 400;
        opacity: 0.8;
        margin: 0 0 5px 0;
        color: var(--ivory);
    }

    .course-page-instructor-mini-info p {
        font-size: 1rem;
        font-weight: 600;
        margin: 0;
        color: var(--bright-amber);
    }

    /* Main Content */
    .course-page-main {
        padding: 60px 0;
        background: linear-gradient(135deg, var(--ivory) 0%, var(--pure-white) 100%);
    }

    /* Course Sidebar */
    .course-page-sidebar {
        position: sticky;
        top: 100px;
    }

    .course-page-card {
        background: var(--pure-white);
        border-radius: var(--radius-xl);
        overflow: hidden;
        box-shadow: var(--shadow-lg);
        margin-bottom: 30px;
        border: 1px solid rgba(251, 198, 12, 0.1);
        transition: var(--transition);
    }

    .course-page-card:hover {
        box-shadow: var(--shadow-hover);
        border-color: var(--bright-amber);
    }

    .course-page-thumbnail {
        position: relative;
        aspect-ratio: 16/9;
        overflow: hidden;
    }

    .course-page-thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .course-page-card:hover .course-page-thumbnail img {
        transform: scale(1.05);
    }

    .course-page-preview-btn {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 70px;
        height: 70px;
        background: var(--pure-white);
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--prussian-blue);
        font-size: 1.8rem;
        cursor: pointer;
        transition: var(--transition);
        box-shadow: var(--shadow-lg);
        opacity: 0;
        visibility: hidden;
        z-index: 10;
    }

    .course-page-thumbnail:hover .course-page-preview-btn {
        opacity: 1;
        visibility: visible;
        transform: translate(-50%, -50%) scale(1.1);
    }

    .course-page-preview-btn:hover {
        background: var(--gradient-2);
        color: var(--prussian-blue);
    }

    .course-page-price-box {
        padding: 25px;
        border-bottom: 1px solid rgba(251, 198, 12, 0.1);
        background: var(--ivory);
        text-align: center;
    }

    .course-page-price {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--prussian-blue);
        margin-bottom: 5px;
        line-height: 1;
    }

    .course-page-price.free {
        color: var(--sky-blue);
    }

    .course-page-price.subscription {
        color: var(--prussian-blue);
        font-size: 2rem;
    }

    .course-page-price small {
        font-size: 1rem;
        font-weight: 400;
        color: var(--text-muted);
        text-decoration: line-through;
        margin-left: 10px;
    }

    .course-page-price-label {
        font-size: 0.9rem;
        color: var(--text-muted);
        display: block;
        margin-top: 5px;
    }

    .subscription-badge {
        display: inline-block;
        background: var(--gradient-2);
        color: var(--prussian-blue);
        padding: 4px 12px;
        border-radius: var(--radius-full);
        font-size: 0.8rem;
        font-weight: 600;
        margin-bottom: 10px;
        border: 1px solid rgba(251, 198, 12, 0.3);
    }

    .course-page-actions {
        padding: 25px;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .course-page-btn-enroll {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 16px 30px;
        background: var(--gradient-1);
        color: var(--pure-white);
        border: none;
        border-radius: var(--radius-full);
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        text-decoration: none;
        width: 100%;
        box-shadow: var(--shadow-md);
    }

    .course-page-btn-enroll:hover {
        background: var(--gradient-2);
        color: var(--prussian-blue);
        transform: translateY(-3px);
        box-shadow: var(--shadow-hover);
    }

    .course-page-btn-enroll:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
    }

    .course-page-btn-wishlist {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 14px 30px;
        background: transparent;
        color: var(--text-primary);
        border: 2px solid var(--pale-slate);
        border-radius: var(--radius-full);
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        text-decoration: none;
        width: 100%;
    }

    .course-page-btn-wishlist:hover {
        background: var(--gradient-2);
        color: var(--prussian-blue);
        border-color: transparent;
    }

    .course-page-btn-wishlist.active {
        background: var(--gradient-2);
        color: var(--prussian-blue);
        border-color: transparent;
    }

    .course-page-btn-wishlist.active i {
        color: var(--prussian-blue);
    }

    .course-page-includes {
        padding: 25px;
        background: var(--ivory);
        border-top: 1px solid rgba(251, 198, 12, 0.1);
    }

    .course-page-includes h4 {
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 20px;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .course-page-includes h4 i {
        color: var(--bright-amber);
    }

    .course-page-includes-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .course-page-includes-list li {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px solid rgba(251, 198, 12, 0.1);
    }

    .course-page-includes-list li:last-child {
        border-bottom: none;
    }

    .course-page-includes-list i {
        width: 20px;
        color: var(--bright-amber);
        font-size: 1rem;
    }

    .course-page-includes-list span {
        flex: 1;
        color: var(--text-muted);
        font-size: 0.95rem;
    }

    .course-page-includes-list strong {
        color: var(--text-primary);
        font-weight: 600;
    }

    /* Course Content */
    .course-page-content-wrapper {
        background: var(--pure-white);
        border-radius: var(--radius-xl);
        padding: 40px;
        box-shadow: var(--shadow-lg);
        border: 1px solid rgba(251, 198, 12, 0.1);
    }

    .course-page-tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 30px;
        border-bottom: 2px solid var(--pale-slate);
        padding-bottom: 15px;
        flex-wrap: wrap;
    }

    .course-page-tab-btn {
        padding: 12px 25px;
        background: none;
        border: none;
        border-radius: var(--radius-md);
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-muted);
        cursor: pointer;
        transition: var(--transition);
        position: relative;
    }

    .course-page-tab-btn:hover {
        color: var(--bright-amber);
        background: rgba(251, 198, 12, 0.05);
    }

    .course-page-tab-btn.active {
        color: var(--bright-amber);
        background: rgba(251, 198, 12, 0.1);
    }

    .course-page-tab-btn.active::after {
        content: '';
        position: absolute;
        bottom: -17px;
        left: 0;
        width: 100%;
        height: 2px;
        background: var(--gradient-2);
    }

    .course-page-tab-pane {
        display: none;
    }

    .course-page-tab-pane.active {
        display: block;
        animation: course-page-fadeIn 0.5s ease;
    }

    @keyframes course-page-fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Overview Tab */
    .course-page-overview-section {
        margin-bottom: 40px;
    }

    .course-page-section-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 20px;
        color: var(--text-primary);
        position: relative;
        padding-bottom: 10px;
    }

    .course-page-section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 3px;
        background: var(--gradient-2);
        border-radius: var(--radius-full);
    }

    .course-page-description {
        color: var(--text-muted);
        line-height: 1.8;
        font-size: 1.05rem;
    }

    .course-page-description h1,
    .course-page-description h2,
    .course-page-description h3 {
        color: var(--text-primary);
        margin-top: 30px;
        margin-bottom: 15px;
    }

    .course-page-description p {
        margin-bottom: 15px;
    }

    .course-page-description ul,
    .course-page-description ol {
        margin-bottom: 20px;
        padding-left: 20px;
    }

    .course-page-description li {
        margin-bottom: 8px;
    }

    .course-page-description img {
        max-width: 100%;
        border-radius: var(--radius-lg);
        margin: 20px 0;
        border: 1px solid rgba(251, 198, 12, 0.2);
    }

    .course-page-learning-outcomes {
        background: var(--ivory);
        padding: 30px;
        border-radius: var(--radius-lg);
        margin: 30px 0;
        border-left: 4px solid var(--bright-amber);
    }

    .course-page-outcomes-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
    }

    .course-page-outcome-item {
        display: flex;
        gap: 15px;
        align-items: flex-start;
    }

    .course-page-outcome-icon {
        width: 30px;
        height: 30px;
        background: rgba(251, 198, 12, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--bright-amber);
        font-size: 0.9rem;
        flex-shrink: 0;
    }

    .course-page-outcome-text {
        color: var(--text-secondary);
        font-size: 0.95rem;
        line-height: 1.5;
    }

    /* Curriculum Tab */
    .course-page-curriculum-section {
        margin-bottom: 30px;
    }

    .course-page-curriculum-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .course-page-curriculum-stats {
        display: flex;
        gap: 20px;
        color: var(--text-muted);
        font-size: 0.95rem;
    }

    .course-page-curriculum-stats i {
        color: var(--bright-amber);
        margin-right: 5px;
    }

    .course-page-accordion-item {
        background: var(--pure-white);
        border: 1px solid rgba(251, 198, 12, 0.1);
        border-radius: var(--radius-lg);
        margin-bottom: 15px;
        overflow: hidden;
        transition: var(--transition);
    }

    .course-page-accordion-item:hover {
        border-color: var(--bright-amber);
        box-shadow: var(--shadow-md);
    }

    .course-page-accordion-header {
        padding: 18px 20px;
        background: var(--ivory);
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: var(--transition);
    }

    .course-page-accordion-header:hover {
        background: rgba(251, 198, 12, 0.05);
    }

    .course-page-accordion-header h3 {
        font-size: 1.1rem;
        font-weight: 600;
        margin: 0;
        color: var(--text-primary);
    }

    .course-page-section-meta {
        display: flex;
        align-items: center;
        gap: 15px;
        font-size: 0.9rem;
        color: var(--text-muted);
    }

    .course-page-section-meta i {
        transition: var(--transition);
        color: var(--bright-amber);
    }

    .course-page-accordion-header.active .course-page-section-meta i {
        transform: rotate(180deg);
    }

    .course-page-accordion-content {
        display: none;
        padding: 20px;
        border-top: 1px solid rgba(251, 198, 12, 0.1);
        background: var(--pure-white);
    }

    .course-page-accordion-content.show {
        display: block;
        animation: course-page-slideDown 0.3s ease;
    }

    @keyframes course-page-slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .course-page-lesson-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px;
        border-bottom: 1px solid rgba(251, 198, 12, 0.1);
        transition: var(--transition);
    }

    .course-page-lesson-item:last-child {
        border-bottom: none;
    }

    .course-page-lesson-item:hover {
        background: var(--ivory);
        border-radius: var(--radius-md);
    }

    .course-page-lesson-icon {
        width: 30px;
        color: var(--bright-amber);
        font-size: 1rem;
        text-align: center;
    }

    .course-page-lesson-info {
        flex: 1;
    }

    .course-page-lesson-title {
        font-weight: 500;
        color: var(--text-primary);
        margin-bottom: 5px;
    }

    .course-page-lesson-meta {
        display: flex;
        gap: 15px;
        font-size: 0.85rem;
        color: var(--text-muted);
    }

    .course-page-lesson-meta i {
        margin-right: 5px;
        color: var(--bright-amber);
    }

    .course-page-lesson-preview {
        color: var(--bright-amber);
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        padding: 8px 15px;
        border-radius: var(--radius-full);
        transition: var(--transition);
        border: 1px solid rgba(251, 198, 12, 0.3);
    }

    .course-page-lesson-preview:hover {
        background: var(--gradient-2);
        color: var(--prussian-blue);
        border-color: transparent;
    }

    .course-page-lesson-locked {
        color: var(--text-muted);
        font-size: 1rem;
    }

    /* Instructor Tab */
    .course-page-instructor-profile {
        display: flex;
        gap: 40px;
        flex-wrap: wrap;
    }

    .course-page-instructor-avatar-large {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background: var(--gradient-2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        font-weight: 600;
        color: var(--prussian-blue);
        flex-shrink: 0;
        box-shadow: var(--shadow-lg);
        border: 4px solid var(--bright-amber);
    }

    .course-page-instructor-details {
        flex: 1;
    }

    .course-page-instructor-name {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 5px;
        color: var(--text-primary);
    }

    .course-page-instructor-title {
        font-size: 1.1rem;
        color: var(--bright-amber);
        margin-bottom: 20px;
    }

    .course-page-instructor-bio {
        color: var(--text-muted);
        line-height: 1.8;
        margin-bottom: 25px;
    }

    .course-page-instructor-stats {
        display: flex;
        gap: 40px;
        margin-bottom: 25px;
        padding: 20px 0;
        border-top: 1px solid rgba(251, 198, 12, 0.1);
        border-bottom: 1px solid rgba(251, 198, 12, 0.1);
        flex-wrap: wrap;
    }

    .course-page-stat-item {
        text-align: center;
    }

    .course-page-stat-value {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--bright-amber);
        line-height: 1;
        margin-bottom: 5px;
    }

    .course-page-stat-label {
        font-size: 0.9rem;
        color: var(--text-muted);
    }

    .course-page-instructor-social {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }

    .course-page-social-link {
        width: 45px;
        height: 45px;
        background: var(--ivory);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--bright-amber);
        text-decoration: none;
        transition: var(--transition);
        font-size: 1.2rem;
        border: 1px solid rgba(251, 198, 12, 0.2);
    }

    .course-page-social-link:hover {
        background: var(--gradient-2);
        color: var(--prussian-blue);
        transform: translateY(-3px);
        border-color: transparent;
    }

    /* Related Courses */
    .course-page-related-courses {
        margin-top: 60px;
    }

    .course-page-related-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .course-page-related-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--text-primary);
    }

    .course-page-view-all {
        color: var(--bright-amber);
        text-decoration: none;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 5px;
        padding: 10px 20px;
        border-radius: var(--radius-full);
        transition: var(--transition);
        border: 1px solid rgba(251, 198, 12, 0.3);
    }

    .course-page-view-all:hover {
        background: var(--gradient-2);
        color: var(--prussian-blue);
        border-color: transparent;
        gap: 10px;
    }

    .course-page-related-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 25px;
    }

    .course-page-related-card {
        background: var(--pure-white);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-md);
        transition: var(--transition);
        text-decoration: none;
        color: inherit;
        border: 1px solid rgba(251, 198, 12, 0.1);
    }

    .course-page-related-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-hover);
        border-color: var(--bright-amber);
    }

    .course-page-related-thumbnail {
        aspect-ratio: 16/9;
        overflow: hidden;
    }

    .course-page-related-thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .course-page-related-card:hover .course-page-related-thumbnail img {
        transform: scale(1.1);
    }

    .course-page-related-content {
        padding: 20px;
    }

    .course-page-related-category {
        font-size: 0.8rem;
        color: var(--bright-amber);
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .course-page-related-title {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 10px;
        color: var(--text-primary);
        line-height: 1.4;
    }

    .course-page-related-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .course-page-related-price {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--prussian-blue);
    }

    .course-page-related-price.free {
        color: var(--sky-blue);
    }

    .course-page-related-rating {
        color: var(--bright-amber);
        font-size: 0.9rem;
    }

    /* Video Modal */
    .course-page-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(10, 29, 68, 0.9);
        z-index: 99999;
        align-items: center;
        justify-content: center;
    }

    .course-page-modal.show {
        display: flex;
        animation: course-page-fadeIn 0.3s ease;
    }

    .course-page-modal-content {
        position: relative;
        width: 90%;
        max-width: 900px;
        background: var(--prussian-blue);
        border-radius: var(--radius-lg);
        overflow: hidden;
        border: 2px solid var(--bright-amber);
    }

    .course-page-modal-close {
        position: absolute;
        top: 15px;
        right: 15px;
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.2);
        border: none;
        border-radius: 50%;
        color: var(--pure-white);
        font-size: 1.2rem;
        cursor: pointer;
        transition: var(--transition);
        z-index: 10;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .course-page-modal-close:hover {
        background: var(--gradient-2);
        color: var(--prussian-blue);
        transform: rotate(90deg);
    }

    .course-page-video-container {
        position: relative;
        padding-bottom: 56.25%;
        height: 0;
    }

    .course-page-video-container iframe,
    .course-page-video-container video {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: none;
    }

    /* Notification System */
    .course-page-notification {
        position: fixed;
        bottom: 20px;
        right: 20px;
        padding: 15px 25px;
        border-radius: var(--radius-full);
        box-shadow: var(--shadow-lg);
        z-index: 10000;
        animation: course-page-slideIn 0.3s ease;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 10px;
        max-width: 400px;
        border-left: 4px solid var(--bright-amber);
    }

    .course-page-notification.success {
        background: var(--gradient-1);
        color: var(--pure-white);
    }

    .course-page-notification.error {
        background: var(--gradient-2);
        color: var(--prussian-blue);
    }

    .course-page-notification.info {
        background: var(--gradient-3);
        color: var(--prussian-blue);
    }

    .course-page-notification.warning {
        background: var(--gradient-2);
        color: var(--prussian-blue);
    }

    @keyframes course-page-slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes course-page-slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }

    /* Responsive */
    @media (max-width: 992px) {
        .course-page-sidebar {
            position: static;
            margin-top: 40px;
        }

        .course-page-content-wrapper {
            padding: 30px;
        }

        .course-page-instructor-profile {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .course-page-instructor-stats {
            justify-content: center;
        }

        .course-page-instructor-social {
            justify-content: center;
        }

        .course-page-section-title::after {
            left: 50%;
            transform: translateX(-50%);
        }

        .course-page-hero {
            padding: 60px 0;
        }
    }

    @media (max-width: 768px) {
        .course-page-hero {
            padding: 40px 0;
        }

        .course-page-hero-title {
            font-size: 1.8rem;
        }

        .course-page-meta-list {
            gap: 20px;
        }

        .course-page-meta-item {
            width: 100%;
        }

        .course-page-content-wrapper {
            padding: 20px;
        }

        .course-page-instructor-stats {
            flex-direction: column;
            gap: 20px;
        }

        .course-page-tabs {
            justify-content: center;
        }

        .course-page-tab-btn.active::after {
            display: none;
        }

        .course-page-curriculum-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .course-page-instructor-mini {
            max-width: 100%;
        }

        .course-page-related-header {
            flex-direction: column;
            align-items: flex-start;
        }
    }

    @media (max-width: 576px) {
        .course-page-badge-wrapper {
            justify-content: center;
        }

        .course-page-meta-item {
            flex-direction: column;
            text-align: center;
        }

        .course-page-meta-icon {
            margin: 0 auto;
        }

        .course-page-instructor-mini {
            flex-direction: column;
            text-align: center;
        }

        .course-page-lesson-item {
            flex-wrap: wrap;
        }

        .course-page-lesson-preview {
            width: 100%;
            text-align: center;
        }

        .course-page-actions {
            padding: 20px;
        }

        .course-page-btn-enroll,
        .course-page-btn-wishlist {
            padding: 14px 20px;
            font-size: 1rem;
        }

        .course-page-notification {
            left: 20px;
            right: 20px;
            max-width: none;
        }
    }

    @media (max-width: 380px) {
        .course-page-hero-title {
            font-size: 1.5rem;
        }

        .course-page-meta-icon {
            width: 40px;
            height: 40px;
            font-size: 1.1rem;
        }

        .course-page-meta-content p {
            font-size: 1rem;
        }

        .course-page-section-title {
            font-size: 1.3rem;
        }

        .course-page-tab-btn {
            padding: 8px 16px;
            font-size: 0.9rem;
        }

        .course-page-related-title {
            font-size: 1rem;
        }
    }

    /* Mobile reorder for subscription - subscription comes before other courses */
    @media (max-width: 768px) {
        .row {
            display: flex;
            flex-direction: column;
        }
        
        .col-lg-8 {
            order: 2;
        }
        
        .col-lg-4 {
            order: 1;
            margin-bottom: 30px;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="course-page-hero">
    <div class="course-page-particles">
        <div class="course-page-particle"></div>
        <div class="course-page-particle"></div>
        <div class="course-page-particle"></div>
    </div>

    <div class="container">
        <div class="course-page-hero-content" data-aos="fade-up">
            <!-- Breadcrumb -->
            <div class="course-page-breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <i class="fas fa-chevron-right"></i>
                <a href="{{ route('courses') }}">Courses</a>
                <i class="fas fa-chevron-right"></i>
                @if($course->category)
                <a href="{{ route('courses.category', $course->category->slug) }}">{{ $course->category->name }}</a>
                <i class="fas fa-chevron-right"></i>
                @endif
                <span>{{ $course->title }}</span>
            </div>

            <!-- Badges -->
            <div class="course-page-badge-wrapper">
                @if($course->featured)
                <span class="course-page-badge featured"><i class="fas fa-star"></i> Featured</span>
                @endif
                @if($course->is_free)
                <span class="course-page-badge free"><i class="fas fa-gift"></i> Free Course</span>
                @else
                <span class="course-page-badge subscription"><i class="fas fa-crown"></i> Subscription Required</span>
                @endif
                @if($course->level)
                <span class="course-page-badge"><i class="fas fa-signal"></i> {{ ucfirst($course->level) }}</span>
                @endif
                @if($course->language)
                <span class="course-page-badge"><i class="fas fa-language"></i> {{ ucfirst($course->language) }}</span>
                @endif
            </div>

            <!-- Title -->
            <h1 class="course-page-hero-title">{{ $course->title }}</h1>

            <!-- Description -->
            <p class="course-page-hero-description">{{ $course->excerpt ?? Str::limit(strip_tags($course->description), 200) }}</p>

            <!-- Meta Info -->
            <div class="course-page-meta-list">
                <div class="course-page-meta-item">
                    <div class="course-page-meta-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="course-page-meta-content">
                        <h4>Students Enrolled</h4>
                        <p>{{ number_format($course->total_students ?? 0) }}+</p>
                    </div>
                </div>

                <div class="course-page-meta-item">
                    <div class="course-page-meta-icon">
                        <i class="far fa-clock"></i>
                    </div>
                    <div class="course-page-meta-content">
                        <h4>Duration</h4>
                        <p>{{ $course->duration_hours ?? $course->duration ?? 'Self-Paced' }}</p>
                    </div>
                </div>

                <div class="course-page-meta-item">
                    <div class="course-page-meta-icon">
                        <i class="fas fa-video"></i>
                    </div>
                    <div class="course-page-meta-content">
                        <h4>Lessons</h4>
                        <p>{{ $course->lessons_count ?? $course->total_lessons ?? 0 }}</p>
                    </div>
                </div>

                <div class="course-page-meta-item">
                    <div class="course-page-meta-icon">
                        <i class="fas fa-signal"></i>
                    </div>
                    <div class="course-page-meta-content">
                        <h4>Level</h4>
                        <p>{{ ucfirst($course->level ?? 'All Levels') }}</p>
                    </div>
                </div>
            </div>

            <!-- Instructor Mini -->
            @if($course->instructor)
            <div class="course-page-instructor-mini">
                <div class="course-page-instructor-mini-avatar">
                    {{ substr($course->instructor->name ?? 'EA', 0, 1) }}
                </div>
                <div class="course-page-instructor-mini-info">
                    <h4>Created by</h4>
                    <p>{{ $course->instructor->name ?? 'EDUCONECX ACADEMY' }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="course-page-main">
    <div class="container">
        <div class="row">
            <!-- Left Column - Course Content -->
            <div class="col-lg-8">
                <div class="course-page-content-wrapper" data-aos="fade-right">
                    <!-- Tabs -->
                    <div class="course-page-tabs">
                        <button class="course-page-tab-btn active" data-tab="overview">Overview</button>
                        <button class="course-page-tab-btn" data-tab="curriculum">Curriculum</button>
                        <button class="course-page-tab-btn" data-tab="instructor">Instructor</button>
                        @if($course->reviews_count > 0)
                        <button class="course-page-tab-btn" data-tab="reviews">Reviews ({{ $course->reviews_count }})</button>
                        @endif
                    </div>

                    <!-- Overview Tab -->
                    <div class="course-page-tab-pane active" id="overview">
                        <div class="course-page-overview-section">
                            <h2 class="course-page-section-title">About This Course</h2>
                            <div class="course-page-description">
                                {!! $course->description !!}
                            </div>

                            @if($course->what_you_will_learn)
                            <div class="course-page-learning-outcomes">
                                <h3>What You'll Learn</h3>
                                <div class="course-page-outcomes-grid">
                                    @foreach(explode("\n", $course->what_you_will_learn) as $outcome)
                                    @if(trim($outcome))
                                    <div class="course-page-outcome-item">
                                        <div class="course-page-outcome-icon">
                                            <i class="fas fa-check"></i>
                                        </div>
                                        <div class="course-page-outcome-text">{{ trim($outcome) }}</div>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            @if($course->requirements)
                            <div class="course-page-learning-outcomes">
                                <h3>Requirements</h3>
                                <div class="course-page-outcomes-grid">
                                    @foreach(explode("\n", $course->requirements) as $requirement)
                                    @if(trim($requirement))
                                    <div class="course-page-outcome-item">
                                        <div class="course-page-outcome-icon">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        <div class="course-page-outcome-text">{{ trim($requirement) }}</div>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Curriculum Tab -->
                    <div class="course-page-tab-pane" id="curriculum">
                        <div class="course-page-curriculum-section">
                            <div class="course-page-curriculum-header">
                                <h2 class="course-page-section-title">Course Curriculum</h2>
                                <div class="course-page-curriculum-stats">
                                    <span><i class="far fa-file-video"></i> {{ $course->lessons_count ?? $course->total_lessons ?? 0 }} Lessons</span>
                                    <span><i class="far fa-clock"></i> {{ $course->total_duration ?? $course->duration ?? 'Self-Paced' }}</span>
                                </div>
                            </div>

                            @if(isset($course->sections) && $course->sections->count() > 0)
                            @foreach($course->sections as $sectionIndex => $section)
                            <div class="course-page-accordion-item">
                                <div class="course-page-accordion-header" data-section="{{ $sectionIndex }}">
                                    <h3>{{ $section->title }}</h3>
                                    <div class="course-page-section-meta">
                                        <span>{{ $section->lessons->count() }} lessons</span>
                                        <span>{{ $section->duration ?? '' }}</span>
                                        <i class="fas fa-chevron-down"></i>
                                    </div>
                                </div>
                                <div class="course-page-accordion-content" id="section-{{ $sectionIndex }}">
                                    @if($section->lessons && $section->lessons->count() > 0)
                                    @foreach($section->lessons as $lesson)
                                    <div class="course-page-lesson-item">
                                        <div class="course-page-lesson-icon">
                                            @if($lesson->is_free_preview)
                                            <i class="fas fa-play-circle"></i>
                                            @else
                                            <i class="fas fa-lock"></i>
                                            @endif
                                        </div>
                                        <div class="course-page-lesson-info">
                                            <div class="course-page-lesson-title">{{ $lesson->title }}</div>
                                            <div class="course-page-lesson-meta">
                                                <span><i class="far fa-clock"></i> {{ $lesson->duration ?? 'N/A' }}</span>
                                                @if($lesson->is_free_preview)
                                                <span style="color: var(--sky-blue);"><i class="fas fa-unlock-alt"></i> Free Preview</span>
                                                @endif
                                            </div>
                                        </div>
                                        @if($lesson->is_free_preview)
                                        <a href="#" class="course-page-lesson-preview" data-video="{{ $lesson->video_url ?? '' }}">
                                            Preview <i class="fas fa-arrow-right"></i>
                                        </a>
                                        @else
                                        <div class="course-page-lesson-locked">
                                            <i class="fas fa-lock"></i>
                                        </div>
                                        @endif
                                    </div>
                                    @endforeach
                                    @else
                                    <p class="text-center py-3">No lessons in this section yet.</p>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                            @else
                            <p class="text-center py-4">Curriculum is being updated. Check back soon!</p>
                            @endif
                        </div>
                    </div>

                    <!-- Instructor Tab -->
                    <div class="course-page-tab-pane" id="instructor">
                        @if($course->instructor)
                        <div class="course-page-instructor-profile">
                            <div class="course-page-instructor-avatar-large">
                                {{ substr($course->instructor->name, 0, 1) }}
                            </div>
                            <div class="course-page-instructor-details">
                                <h2 class="course-page-instructor-name">{{ $course->instructor->name }}</h2>
                                <p class="course-page-instructor-title">{{ $course->instructor->title ?? 'Expert Instructor' }}</p>
                                <div class="course-page-instructor-bio">
                                    {{ $course->instructor->bio ?? 'Experienced professional dedicated to helping students achieve their learning goals.' }}
                                </div>
                                <div class="course-page-instructor-stats">
                                    <div class="course-page-stat-item">
                                        <div class="course-page-stat-value">{{ $course->instructor->courses_count ?? 0 }}</div>
                                        <div class="course-page-stat-label">Courses</div>
                                    </div>
                                    <div class="course-page-stat-item">
                                        <div class="course-page-stat-value">{{ $course->instructor->students_count ?? 0 }}</div>
                                        <div class="course-page-stat-label">Students</div>
                                    </div>
                                </div>
                                <div class="course-page-instructor-social">
                                    @if($course->instructor->twitter)
                                    <a href="{{ $course->instructor->twitter }}" class="course-page-social-link" target="_blank">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    @endif
                                    @if($course->instructor->linkedin)
                                    <a href="{{ $course->instructor->linkedin }}" class="course-page-social-link" target="_blank">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                    @endif
                                    @if($course->instructor->website)
                                    <a href="{{ $course->instructor->website }}" class="course-page-social-link" target="_blank">
                                        <i class="fas fa-globe"></i>
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Reviews Tab -->
                    @if(isset($course->reviews_count) && $course->reviews_count > 0)
                    <div class="course-page-tab-pane" id="reviews">
                        <div class="course-page-reviews-section">
                            <h2 class="course-page-section-title">Student Reviews</h2>
                            <!-- Add reviews content here -->
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Related Courses -->
                @if(isset($relatedCourses) && $relatedCourses->count() > 0)
                <div class="course-page-related-courses" data-aos="fade-up">
                    <div class="course-page-related-header">
                        <h2 class="course-page-related-title">Related Courses</h2>
                        <a href="{{ route('courses') }}" class="course-page-view-all">
                            View All <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    <div class="course-page-related-grid">
                        @foreach($relatedCourses as $relatedCourse)
                        <a href="{{ route('courses.show', $relatedCourse->slug) }}" class="course-page-related-card">
                            <div class="course-page-related-thumbnail">
                                <img src="{{ $relatedCourse->thumbnail_url ?? 'https://via.placeholder.com/600x400' }}" alt="{{ $relatedCourse->title }}">
                            </div>
                            <div class="course-page-related-content">
                                <div class="course-page-related-category">{{ $relatedCourse->category->name ?? 'General' }}</div>
                                <h3 class="course-page-related-title">{{ $relatedCourse->title }}</h3>
                                <div class="course-page-related-meta">
                                    <span class="course-page-related-price {{ $relatedCourse->is_free ? 'free' : '' }}">
                                        @if($relatedCourse->is_free)
                                        Free
                                        @else
                                        Subscription
                                        @endif
                                    </span>
                                    <span class="course-page-related-rating">
                                        <i class="fas fa-star"></i> {{ number_format($relatedCourse->average_rating ?? 0, 1) }}
                                    </span>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Column - Course Sidebar -->
            <div class="col-lg-4">
                <div class="course-page-sidebar" data-aos="fade-left">
                    <!-- Course Card -->
                    <div class="course-page-card">
                        <div class="course-page-thumbnail">
                            <img src="{{ $course->thumbnail_url ?? 'https://via.placeholder.com/600x400' }}" alt="{{ $course->title }}">
                            @if($course->video_intro ?? $course->intro_video)
                            <button class="course-page-preview-btn" id="previewVideo" data-video="{{ $course->video_intro_url ?? $course->intro_video }}">
                                <i class="fas fa-play"></i>
                            </button>
                            @endif
                        </div>

                        <div class="course-page-price-box">
                            @if($course->is_free)
                            <div class="course-page-price free">
                                Free
                            </div>
                            <span class="course-page-price-label">No payment required</span>
                            @else
                            <div class="subscription-badge">
                                <i class="fas fa-crown"></i> SUBSCRIPTION REQUIRED
                            </div>
                            <div class="course-page-price subscription">
                                One Payment
                            </div>
                            <span class="course-page-price-label">Get access to ALL paid courses</span>
                            @endif
                        </div>

                        <!-- Course Actions -->
                        <div class="course-page-actions">
                            @auth
                                @if(isset($isEnrolled) && $isEnrolled)
                                <a href="{{ route('courses.learning', $course->slug) }}" class="course-page-btn-enroll" id="continueLearningBtn">
                                    <i class="fas fa-play-circle"></i>
                                    Continue Learning
                                    @if(isset($course->user_progress) && $course->user_progress > 0)
                                    ({{ $course->user_progress }}%)
                                    @endif
                                </a>
                                @elseif($course->is_free)
                                <button class="course-page-btn-enroll" id="enrollBtn" data-course-id="{{ $course->id }}">
                                    <i class="fas fa-graduation-cap"></i>
                                    Enroll Now - Free
                                </button>
                                @else
                                    @if(isset($hasActiveSubscription) && $hasActiveSubscription)
                                    <button class="course-page-btn-enroll" id="enrollBtn" data-course-id="{{ $course->id }}">
                                        <i class="fas fa-graduation-cap"></i>
                                        Enroll Now (With Subscription)
                                    </button>
                                    @else
                                    <a href="{{ route('subscription.plans') }}" class="course-page-btn-enroll">
                                        <i class="fas fa-crown"></i>
                                        Get Subscription to Access
                                    </a>
                                    @endif
                                @endif
                            @else
                            <a href="{{ route('login') }}?redirect={{ url()->current() }}" class="course-page-btn-enroll">
                                <i class="fas fa-sign-in-alt"></i>
                                Login to
                                @if($course->is_free)
                                Enroll
                                @else
                                Get Subscription
                                @endif
                            </a>
                            @endauth

                            <!-- <button class="course-page-btn-wishlist" id="wishlistBtn" data-course-id="{{ $course->id }}">
                                <i class="far fa-heart"></i>
                                Add to Wishlist
                            </button> -->
                        </div>

                        <div class="course-page-includes">
                            <h4><i class="fas fa-gift"></i> This course includes:</h4>
                            <ul class="course-page-includes-list">
                                <li>
                                    <i class="fas fa-video"></i>
                                    <span>{{ $course->lessons_count ?? $course->total_lessons ?? 0 }} on-demand videos</span>
                                </li>
                                <li>
                                    <i class="far fa-file"></i>
                                    <span>{{ $course->total_articles ?? 0 }} articles</span>
                                </li>
                                <li>
                                    <i class="fas fa-download"></i>
                                    <span>{{ $course->total_resources ?? 0 }} downloadable resources</span>
                                </li>
                                <li>
                                    <i class="fas fa-infinity"></i>
                                    <span>Full lifetime access</span>
                                </li>
                                <li>
                                    <i class="fas fa-mobile-alt"></i>
                                    <span>Access on mobile and TV</span>
                                </li>
                                <li>
                                    <i class="fas fa-certificate"></i>
                                    <span>Certificate of completion</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Video Modal -->
<div class="course-page-modal" id="videoModal">
    <div class="course-page-modal-content">
        <button class="course-page-modal-close" id="closeModal">&times;</button>
        <div class="course-page-video-container" id="videoContainer">
            <!-- Video will be inserted here -->
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ========== YOUR BEAUTIFUL COLORS ==========
        const colors = {
            brightAmber: '#FBC60C',
            prussianBlue: '#0A1D44',
            regalNavy: '#18386E',
            skyBlue: '#5AD1E4',
            ivory: '#F9F7E9'
        };

        // ========== TAB SWITCHING ==========
        const tabBtns = document.querySelectorAll('.course-page-tab-btn');
        const tabPanes = document.querySelectorAll('.course-page-tab-pane');

        tabBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const tabId = this.dataset.tab;

                // Remove active class from all tabs and panes
                tabBtns.forEach(b => b.classList.remove('active'));
                tabPanes.forEach(p => p.classList.remove('active'));

                // Add active class to current tab and pane
                this.classList.add('active');
                document.getElementById(tabId).classList.add('active');
            });
        });

        // ========== CURRICULUM ACCORDION ==========
        const accordionHeaders = document.querySelectorAll('.course-page-accordion-header');

        accordionHeaders.forEach(header => {
            header.addEventListener('click', function() {
                const sectionId = this.dataset.section;
                const content = document.getElementById(`section-${sectionId}`);

                // Toggle active class
                this.classList.toggle('active');

                // Toggle content
                if (content.classList.contains('show')) {
                    content.classList.remove('show');
                } else {
                    content.classList.add('show');
                }
            });
        });

        // Open first accordion by default
        if (accordionHeaders.length > 0) {
            setTimeout(() => {
                accordionHeaders[0].click();
            }, 100);
        }

        // ========== VIDEO PREVIEW MODAL ==========
        const modal = document.getElementById('videoModal');
        const previewBtn = document.getElementById('previewVideo');
        const closeBtn = document.getElementById('closeModal');
        const videoContainer = document.getElementById('videoContainer');

        // Helper function to extract YouTube ID
        function extractYoutubeId(url) {
            if (!url) return null;
            const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/;
            const match = url.match(regExp);
            return (match && match[2].length === 11) ? match[2] : null;
        }

        // Helper function to extract Vimeo ID
        function extractVimeoId(url) {
            if (!url) return null;
            const regExp = /vimeo\.com\/(?:video\/)?(\d+)/;
            const match = url.match(regExp);
            return match ? match[1] : null;
        }

        function loadVideo(url) {
            if (!url) return false;

            if (url.includes('youtube.com') || url.includes('youtu.be')) {
                const videoId = extractYoutubeId(url);
                if (videoId) {
                    videoContainer.innerHTML = `<iframe src="https://www.youtube.com/embed/${videoId}?autoplay=1" frameborder="0" allowfullscreen allow="autoplay"></iframe>`;
                    return true;
                }
            } else if (url.includes('vimeo.com')) {
                const vimeoId = extractVimeoId(url);
                if (vimeoId) {
                    videoContainer.innerHTML = `<iframe src="https://player.vimeo.com/video/${vimeoId}?autoplay=1" frameborder="0" allowfullscreen allow="autoplay"></iframe>`;
                    return true;
                }
            } else {
                // Assume it's a local video file
                videoContainer.innerHTML = `<video src="${url}" controls autoplay style="width:100%; height:100%;"></video>`;
                return true;
            }
            return false;
        }

        if (previewBtn) {
            previewBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const videoUrl = this.dataset.video;
                if (videoUrl) {
                    if (loadVideo(videoUrl)) {
                        modal.classList.add('show');
                    } else {
                        showNotification('Invalid video URL', 'error');
                    }
                } else {
                    showNotification('No preview video available', 'info');
                }
            });
        }

        // Preview links from curriculum
        const previewLinks = document.querySelectorAll('.course-page-lesson-preview');
        previewLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const videoUrl = this.dataset.video;
                if (videoUrl) {
                    if (loadVideo(videoUrl)) {
                        modal.classList.add('show');
                    } else {
                        showNotification('Invalid video URL', 'error');
                    }
                } else {
                    showNotification('No preview available for this lesson', 'info');
                }
            });
        });

        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                modal.classList.remove('show');
                setTimeout(() => {
                    videoContainer.innerHTML = ''; // Clear video when closing
                }, 300);
            });
        }

        // Close modal when clicking outside
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.classList.remove('show');
                setTimeout(() => {
                    videoContainer.innerHTML = '';
                }, 300);
            }
        });

        // ========== ENROLLMENT FUNCTIONALITY ==========
        const enrollBtn = document.getElementById('enrollBtn');

        if (enrollBtn) {
            enrollBtn.addEventListener('click', function(e) {
                e.preventDefault();

                @auth
                const courseId = this.dataset.courseId;
                const originalText = this.innerHTML;
                const originalWidth = this.offsetWidth;

                // Save original content and show loading
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enrolling...';
                this.disabled = true;
                this.style.width = originalWidth + 'px';

                // Make AJAX request to enroll
                fetch('{{ route("courses.enroll.ajax", $course->id) }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => {
                                throw err;
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            showNotification(data.message || 'Successfully enrolled!', 'success');

                            // Redirect to learning page
                            setTimeout(() => {
                                window.location.href = data.redirect_url || '{{ route("courses.learning", $course->slug) }}';
                            }, 1500);
                        } else if (data.redirect_to_subscription) {
                            // Redirect to subscription plans
                            showNotification(data.message || 'Subscription required', 'info');
                            setTimeout(() => {
                                window.location.href = data.subscription_url || '{{ route("subscription.plans") }}';
                            }, 1500);
                        } else {
                            showNotification(data.message || 'Enrollment failed', 'error');
                            this.innerHTML = originalText;
                            this.disabled = false;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification(error.message || 'An error occurred. Please try again.', 'error');
                        this.innerHTML = originalText;
                        this.disabled = false;
                    });
                @else
                // Redirect to login with return URL
                showNotification('Please login to enroll in this course', 'info');
                setTimeout(() => {
                    window.location.href = '{{ route("login") }}?redirect={{ url()->current() }}';
                }, 1500);
                @endauth
            });
        }

        // ========== WISHLIST FUNCTIONALITY ==========
        const wishlistBtn = document.getElementById('wishlistBtn');

        if (wishlistBtn) {
            // Check initial wishlist status
            @auth
            @if(isset($course) && ($course->is_wishlisted ?? false))
            wishlistBtn.classList.add('active');
            wishlistBtn.querySelector('i').classList.remove('far');
            wishlistBtn.querySelector('i').classList.add('fas');
            wishlistBtn.innerHTML = '<i class="fas fa-heart"></i> Remove from Wishlist';
            @endif
            @endauth

            wishlistBtn.addEventListener('click', function(e) {
                e.preventDefault();

                @auth
                // Check if user is enrolled (can't wishlist enrolled courses)
                @if(isset($isEnrolled) && $isEnrolled)
                showNotification('You are already enrolled in this course!', 'info');
                return;
                @endif

                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
                this.disabled = true;

                const isActive = this.classList.contains('active');
                const url = isActive ?
                    '{{ route("wishlist.remove", $course->id) }}' :
                    '{{ route("wishlist.add", $course->id) }}';
                const method = isActive ? 'DELETE' : 'POST';

                fetch(url, {
                        method: method,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            if (isActive) {
                                this.classList.remove('active');
                                this.innerHTML = '<i class="far fa-heart"></i> Add to Wishlist';
                                showNotification('Course removed from wishlist', 'info');
                            } else {
                                this.classList.add('active');
                                this.innerHTML = '<i class="fas fa-heart"></i> Remove from Wishlist';
                                showNotification('Course added to wishlist', 'success');
                            }
                        } else {
                            showNotification(data.message || 'Operation failed', 'error');
                            this.innerHTML = originalText;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('Error processing your request', 'error');
                        this.innerHTML = originalText;
                    })
                    .finally(() => {
                        this.disabled = false;
                    });
                @else
                // Store the current page in session to redirect back after login
                sessionStorage.setItem('redirectAfterLogin', window.location.href);
                showNotification('Please login to add to wishlist', 'info');
                setTimeout(() => {
                    window.location.href = '{{ route("login") }}';
                }, 1500);
                @endauth
            });
        }

        // ========== NOTIFICATION SYSTEM ==========
        function showNotification(message, type = 'success') {
            // Remove any existing notifications
            const existingNotifications = document.querySelectorAll('.course-page-notification');
            existingNotifications.forEach(notification => notification.remove());

            const notification = document.createElement('div');
            notification.className = `course-page-notification ${type}`;

            // Add icon
            const icons = {
                success: 'fa-check-circle',
                error: 'fa-exclamation-circle',
                info: 'fa-info-circle',
                warning: 'fa-exclamation-triangle'
            };

            const icon = document.createElement('i');
            icon.className = `fas ${icons[type]}`;
            notification.appendChild(icon);

            // Add message
            const textSpan = document.createElement('span');
            textSpan.textContent = message;
            notification.appendChild(textSpan);

            document.body.appendChild(notification);

            // Auto remove after 3 seconds
            setTimeout(() => {
                notification.style.animation = 'course-page-slideOut 0.3s ease';
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, 3000);
        }

        // ========== ADD SLIDE OUT ANIMATION ==========
        const style = document.createElement('style');
        style.textContent = `
            @keyframes course-page-slideOut {
                from {
                    transform: translateX(0);
                    opacity: 1;
                }
                to {
                    transform: translateX(100%);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);

        // ========== RATING STARS GENERATOR ==========
        function generateRatingStars(rating) {
            const fullStars = Math.floor(rating);
            const halfStar = rating % 1 >= 0.5;
            const emptyStars = 5 - fullStars - (halfStar ? 1 : 0);

            let stars = '';
            for (let i = 0; i < fullStars; i++) stars += '<i class="fas fa-star" style="color: var(--bright-amber);"></i>';
            if (halfStar) stars += '<i class="fas fa-star-half-alt" style="color: var(--bright-amber);"></i>';
            for (let i = 0; i < emptyStars; i++) stars += '<i class="far fa-star" style="color: var(--bright-amber);"></i>';

            return stars;
        }

        // ========== SCROLL TO TOP WHEN TABS CHANGE ==========
        tabBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const contentWrapper = document.querySelector('.course-page-content-wrapper');
                if (contentWrapper) {
                    contentWrapper.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // ========== RESPONSIVE SIDEBAR FIX ==========
        function handleResize() {
            const sidebar = document.querySelector('.course-page-sidebar');
            if (window.innerWidth <= 992) {
                sidebar.style.position = 'static';
            } else {
                sidebar.style.position = 'sticky';
            }
        }

        window.addEventListener('resize', handleResize);
        handleResize();

        console.log('Course page JavaScript initialized successfully');
    });
</script>
@endpush