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

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Hero Section */
    .course-page-hero {
        position: relative;
        background: var(--gradient-1);
        padding: 60px 0 40px;
        overflow: hidden;
        color: var(--pure-white);
    }

    @media (min-width: 768px) {
        .course-page-hero {
            padding: 80px 0 60px;
        }
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
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 5px;
    }

    .course-page-breadcrumb a {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        font-size: 0.85rem;
        transition: var(--transition);
    }

    @media (min-width: 768px) {
        .course-page-breadcrumb a {
            font-size: 0.95rem;
        }
    }

    .course-page-breadcrumb a:hover {
        color: var(--bright-amber);
    }

    .course-page-breadcrumb i {
        font-size: 0.7rem;
        margin: 0 5px;
        color: rgba(255, 255, 255, 0.5);
    }

    .course-page-breadcrumb span {
        color: var(--bright-amber);
        font-size: 0.85rem;
    }

    @media (min-width: 768px) {
        .course-page-breadcrumb span {
            font-size: 0.95rem;
        }
    }

    .course-page-badge-wrapper {
        display: flex;
        gap: 8px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .course-page-badge {
        display: inline-block;
        padding: 4px 12px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: var(--radius-full);
        font-size: 0.75rem;
        font-weight: 600;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(251, 198, 12, 0.3);
    }

    @media (min-width: 768px) {
        .course-page-badge {
            padding: 6px 16px;
            font-size: 0.85rem;
        }
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
        font-size: 1.8rem;
        font-weight: 800;
        margin-bottom: 15px;
        line-height: 1.2;
        color: var(--pure-white);
        text-shadow: 0 2px 4px rgba(10, 29, 68, 0.3);
    }

    @media (min-width: 768px) {
        .course-page-hero-title {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }
    }

    @media (min-width: 992px) {
        .course-page-hero-title {
            font-size: 3rem;
        }
    }

    .course-page-hero-description {
        font-size: 0.95rem;
        opacity: 0.95;
        margin-bottom: 25px;
        max-width: 800px;
        color: var(--ivory);
        line-height: 1.6;
    }

    @media (min-width: 768px) {
        .course-page-hero-description {
            font-size: 1.1rem;
            margin-bottom: 30px;
        }
    }

    .course-page-meta-list {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
        margin-bottom: 25px;
    }

    @media (min-width: 480px) {
        .course-page-meta-list {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    .course-page-meta-item {
        display: flex;
        align-items: center;
        gap: 10px;
        background: rgba(255, 255, 255, 0.1);
        padding: 10px;
        border-radius: var(--radius-lg);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(251, 198, 12, 0.2);
    }

    @media (min-width: 768px) {
        .course-page-meta-item {
            padding: 12px;
            gap: 12px;
        }
    }

    .course-page-meta-icon {
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.15);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        color: var(--bright-amber);
        flex-shrink: 0;
    }

    @media (min-width: 768px) {
        .course-page-meta-icon {
            width: 50px;
            height: 50px;
            font-size: 1.3rem;
        }
    }

    .course-page-meta-content {
        min-width: 0;
    }

    .course-page-meta-content h4 {
        font-size: 0.7rem;
        font-weight: 400;
        opacity: 0.8;
        margin: 0 0 3px 0;
        color: var(--ivory);
        white-space: nowrap;
    }

    @media (min-width: 768px) {
        .course-page-meta-content h4 {
            font-size: 0.8rem;
            margin-bottom: 5px;
        }
    }

    .course-page-meta-content p {
        font-size: 0.85rem;
        font-weight: 600;
        margin: 0;
        color: var(--pure-white);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    @media (min-width: 768px) {
        .course-page-meta-content p {
            font-size: 1rem;
        }
    }

    .course-page-instructor-mini {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        padding: 12px 20px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: var(--radius-full);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(251, 198, 12, 0.2);
        max-width: 100%;
    }

    @media (min-width: 768px) {
        .course-page-instructor-mini {
            padding: 15px 20px;
            max-width: 300px;
        }
    }

    .course-page-instructor-mini-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--gradient-2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--prussian-blue);
        flex-shrink: 0;
    }

    @media (min-width: 768px) {
        .course-page-instructor-mini-avatar {
            width: 50px;
            height: 50px;
            font-size: 1.3rem;
        }
    }

    .course-page-instructor-mini-info h4 {
        font-size: 0.8rem;
        font-weight: 400;
        opacity: 0.8;
        margin: 0 0 3px 0;
        color: var(--ivory);
    }

    @media (min-width: 768px) {
        .course-page-instructor-mini-info h4 {
            font-size: 0.9rem;
            margin-bottom: 5px;
        }
    }

    .course-page-instructor-mini-info p {
        font-size: 0.9rem;
        font-weight: 600;
        margin: 0;
        color: var(--bright-amber);
    }

    @media (min-width: 768px) {
        .course-page-instructor-mini-info p {
            font-size: 1rem;
        }
    }

    /* Main Content */
    .course-page-main {
        padding: 30px 0;
        background: linear-gradient(135deg, var(--ivory) 0%, var(--pure-white) 100%);
    }

    @media (min-width: 768px) {
        .course-page-main {
            padding: 60px 0;
        }
    }

    /* Course Card - Mobile First */
    .course-page-course-card {
        background: var(--pure-white);
        border-radius: var(--radius-xl);
        overflow: hidden;
        box-shadow: var(--shadow-lg);
        margin-bottom: 30px;
        border: 1px solid rgba(251, 198, 12, 0.1);
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
    }

    .course-page-price-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: var(--gradient-2);
        color: var(--prussian-blue);
        padding: 6px 12px;
        border-radius: var(--radius-full);
        font-size: 0.85rem;
        font-weight: 700;
        z-index: 2;
        box-shadow: var(--shadow-md);
    }

    .course-page-price-badge.free {
        background: var(--gradient-3);
    }

    .course-page-preview-btn {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 50px;
        height: 50px;
        background: var(--pure-white);
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--prussian-blue);
        font-size: 1.3rem;
        cursor: pointer;
        transition: var(--transition);
        box-shadow: var(--shadow-lg);
        z-index: 10;
        border: 2px solid var(--bright-amber);
    }

    @media (min-width: 768px) {
        .course-page-preview-btn {
            width: 70px;
            height: 70px;
            font-size: 1.8rem;
            opacity: 0;
            visibility: hidden;
        }

        .course-page-thumbnail:hover .course-page-preview-btn {
            opacity: 1;
            visibility: visible;
            transform: translate(-50%, -50%) scale(1.1);
        }
    }

    .course-page-preview-btn:hover {
        background: var(--gradient-2);
        color: var(--prussian-blue);
    }

    /* Course Info Accordion */
    .course-page-info-accordion {
        border-top: 1px solid rgba(251, 198, 12, 0.1);
    }

    .course-page-accordion-item {
        border-bottom: 1px solid rgba(251, 198, 12, 0.1);
    }

    .course-page-accordion-header {
        padding: 16px 20px;
        background: var(--pure-white);
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: var(--transition);
        font-weight: 600;
        color: var(--text-primary);
    }

    .course-page-accordion-header:hover {
        background: rgba(251, 198, 12, 0.05);
    }

    .course-page-accordion-header i {
        transition: var(--transition);
        color: var(--bright-amber);
    }

    .course-page-accordion-header.active i {
        transform: rotate(180deg);
    }

    .course-page-accordion-content {
        display: none;
        padding: 20px;
        background: var(--ivory);
        border-top: 1px solid rgba(251, 198, 12, 0.1);
    }

    .course-page-accordion-content.show {
        display: block;
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Course Actions */
    .course-page-actions {
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .course-page-btn-enroll {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 14px 20px;
        background: var(--gradient-1);
        color: var(--pure-white);
        border: none;
        border-radius: var(--radius-full);
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        text-decoration: none;
        width: 100%;
        box-shadow: var(--shadow-md);
    }

    @media (min-width: 768px) {
        .course-page-btn-enroll {
            padding: 16px 30px;
            font-size: 1.1rem;
            gap: 10px;
        }
    }

    .course-page-btn-enroll:hover {
        background: var(--gradient-2);
        color: var(--prussian-blue);
        transform: translateY(-2px);
        box-shadow: var(--shadow-hover);
    }

    .course-page-btn-wishlist {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 20px;
        background: transparent;
        color: var(--text-primary);
        border: 2px solid var(--pale-slate);
        border-radius: var(--radius-full);
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        text-decoration: none;
        width: 100%;
    }

    @media (min-width: 768px) {
        .course-page-btn-wishlist {
            padding: 14px 30px;
            font-size: 1rem;
            gap: 10px;
        }
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

    /* Includes List */
    .course-page-includes-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .course-page-includes-list li {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid rgba(251, 198, 12, 0.1);
        color: var(--text-muted);
        font-size: 0.9rem;
    }

    @media (min-width: 768px) {
        .course-page-includes-list li {
            font-size: 0.95rem;
            padding: 12px 0;
        }
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
    }

    /* Main Tabs */
    .course-page-tabs-wrapper {
        background: var(--pure-white);
        border-radius: var(--radius-xl);
        overflow: hidden;
        box-shadow: var(--shadow-lg);
        margin-bottom: 30px;
        border: 1px solid rgba(251, 198, 12, 0.1);
    }

    .course-page-tabs {
        display: flex;
        gap: 5px;
        padding: 15px 15px 0;
        background: var(--ivory);
        border-bottom: 1px solid rgba(251, 198, 12, 0.1);
        overflow-x: auto;
        scrollbar-width: thin;
        white-space: nowrap;
    }

    @media (min-width: 768px) {
        .course-page-tabs {
            padding: 20px 20px 0;
            gap: 10px;
            overflow-x: visible;
            flex-wrap: wrap;
        }
    }

    .course-page-tab-btn {
        padding: 10px 16px;
        background: none;
        border: none;
        border-radius: var(--radius-md) var(--radius-md) 0 0;
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--text-muted);
        cursor: pointer;
        transition: var(--transition);
        position: relative;
        white-space: nowrap;
    }

    @media (min-width: 768px) {
        .course-page-tab-btn {
            padding: 12px 25px;
            font-size: 1rem;
        }
    }

    .course-page-tab-btn:hover {
        color: var(--bright-amber);
        background: rgba(251, 198, 12, 0.05);
    }

    .course-page-tab-btn.active {
        color: var(--bright-amber);
        background: var(--pure-white);
    }

    .course-page-tab-btn.active::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        width: 100%;
        height: 2px;
        background: var(--gradient-2);
    }

    .course-page-tab-content {
        padding: 20px;
    }

    @media (min-width: 768px) {
        .course-page-tab-content {
            padding: 30px;
        }
    }

    .course-page-tab-pane {
        display: none;
    }

    .course-page-tab-pane.active {
        display: block;
        animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Section Titles */
    .course-page-section-title {
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 20px;
        color: var(--text-primary);
        position: relative;
        padding-bottom: 10px;
    }

    @media (min-width: 768px) {
        .course-page-section-title {
            font-size: 1.5rem;
            margin-bottom: 25px;
        }
    }

    .course-page-section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 3px;
        background: var(--gradient-2);
        border-radius: var(--radius-full);
    }

    /* Learning Outcomes */
    .course-page-learning-outcomes {
        background: var(--ivory);
        padding: 20px;
        border-radius: var(--radius-lg);
        margin: 25px 0;
        border-left: 4px solid var(--bright-amber);
    }

    @media (min-width: 768px) {
        .course-page-learning-outcomes {
            padding: 30px;
            margin: 30px 0;
        }
    }

    .course-page-outcomes-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 15px;
    }

    @media (min-width: 640px) {
        .course-page-outcomes-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    .course-page-outcome-item {
        display: flex;
        gap: 12px;
        align-items: flex-start;
    }

    .course-page-outcome-icon {
        width: 24px;
        height: 24px;
        background: rgba(251, 198, 12, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--bright-amber);
        font-size: 0.8rem;
        flex-shrink: 0;
    }

    .course-page-outcome-text {
        color: var(--text-secondary);
        font-size: 0.9rem;
        line-height: 1.5;
    }

    @media (min-width: 768px) {
        .course-page-outcome-text {
            font-size: 0.95rem;
        }
    }

    /* Curriculum */
    .course-page-curriculum-header {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-bottom: 20px;
    }

    @media (min-width: 640px) {
        .course-page-curriculum-header {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
    }

    .course-page-curriculum-stats {
        display: flex;
        gap: 15px;
        color: var(--text-muted);
        font-size: 0.9rem;
    }

    .course-page-curriculum-stats i {
        color: var(--bright-amber);
        margin-right: 5px;
    }

    .course-page-lesson-item {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 12px;
        padding: 12px;
        border-bottom: 1px solid rgba(251, 198, 12, 0.1);
        transition: var(--transition);
    }

    @media (min-width: 640px) {
        .course-page-lesson-item {
            flex-wrap: nowrap;
            padding: 15px;
        }
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
        flex-shrink: 0;
    }

    .course-page-lesson-info {
        flex: 1;
        min-width: 200px;
    }

    .course-page-lesson-title {
        font-weight: 500;
        color: var(--text-primary);
        margin-bottom: 5px;
        font-size: 0.95rem;
    }

    @media (min-width: 768px) {
        .course-page-lesson-title {
            font-size: 1rem;
        }
    }

    .course-page-lesson-meta {
        display: flex;
        gap: 12px;
        font-size: 0.8rem;
        color: var(--text-muted);
        flex-wrap: wrap;
    }

    .course-page-lesson-meta i {
        margin-right: 5px;
        color: var(--bright-amber);
    }

    .course-page-lesson-preview {
        color: var(--bright-amber);
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 500;
        padding: 6px 12px;
        border-radius: var(--radius-full);
        transition: var(--transition);
        border: 1px solid rgba(251, 198, 12, 0.3);
        white-space: nowrap;
        margin-left: auto;
    }

    @media (min-width: 768px) {
        .course-page-lesson-preview {
            padding: 8px 15px;
            font-size: 0.9rem;
        }
    }

    .course-page-lesson-preview:hover {
        background: var(--gradient-2);
        color: var(--prussian-blue);
        border-color: transparent;
    }

    .course-page-lesson-locked {
        color: var(--text-muted);
        font-size: 1rem;
        margin-left: auto;
    }

    /* Instructor */
    .course-page-instructor-profile {
        display: flex;
        flex-direction: column;
        gap: 25px;
    }

    @media (min-width: 768px) {
        .course-page-instructor-profile {
            flex-direction: row;
            gap: 40px;
        }
    }

    .course-page-instructor-avatar-large {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: var(--gradient-2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        font-weight: 600;
        color: var(--prussian-blue);
        flex-shrink: 0;
        box-shadow: var(--shadow-lg);
        border: 3px solid var(--bright-amber);
        margin: 0 auto;
    }

    @media (min-width: 768px) {
        .course-page-instructor-avatar-large {
            width: 200px;
            height: 200px;
            font-size: 4rem;
            border-width: 4px;
            margin: 0;
        }
    }

    .course-page-instructor-details {
        flex: 1;
        text-align: center;
    }

    @media (min-width: 768px) {
        .course-page-instructor-details {
            text-align: left;
        }
    }

    .course-page-instructor-name {
        font-size: 1.6rem;
        font-weight: 700;
        margin-bottom: 5px;
        color: var(--text-primary);
    }

    @media (min-width: 768px) {
        .course-page-instructor-name {
            font-size: 2rem;
        }
    }

    .course-page-instructor-title {
        font-size: 1rem;
        color: var(--bright-amber);
        margin-bottom: 15px;
    }

    @media (min-width: 768px) {
        .course-page-instructor-title {
            font-size: 1.1rem;
            margin-bottom: 20px;
        }
    }

    .course-page-instructor-bio {
        color: var(--text-muted);
        line-height: 1.6;
        margin-bottom: 20px;
        font-size: 0.95rem;
    }

    @media (min-width: 768px) {
        .course-page-instructor-bio {
            font-size: 1rem;
            margin-bottom: 25px;
            line-height: 1.8;
        }
    }

    .course-page-instructor-stats {
        display: flex;
        justify-content: center;
        gap: 30px;
        margin-bottom: 20px;
        padding: 15px 0;
        border-top: 1px solid rgba(251, 198, 12, 0.1);
        border-bottom: 1px solid rgba(251, 198, 12, 0.1);
        flex-wrap: wrap;
    }

    @media (min-width: 768px) {
        .course-page-instructor-stats {
            justify-content: flex-start;
            gap: 40px;
            margin-bottom: 25px;
            padding: 20px 0;
        }
    }

    .course-page-stat-item {
        text-align: center;
    }

    .course-page-stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--bright-amber);
        line-height: 1;
        margin-bottom: 5px;
    }

    @media (min-width: 768px) {
        .course-page-stat-value {
            font-size: 1.8rem;
        }
    }

    .course-page-stat-label {
        font-size: 0.8rem;
        color: var(--text-muted);
    }

    @media (min-width: 768px) {
        .course-page-stat-label {
            font-size: 0.9rem;
        }
    }

    .course-page-instructor-social {
        display: flex;
        justify-content: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    @media (min-width: 768px) {
        .course-page-instructor-social {
            justify-content: flex-start;
            gap: 15px;
        }
    }

    .course-page-social-link {
        width: 40px;
        height: 40px;
        background: var(--ivory);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--bright-amber);
        text-decoration: none;
        transition: var(--transition);
        font-size: 1.1rem;
        border: 1px solid rgba(251, 198, 12, 0.2);
    }

    @media (min-width: 768px) {
        .course-page-social-link {
            width: 45px;
            height: 45px;
            font-size: 1.2rem;
        }
    }

    .course-page-social-link:hover {
        background: var(--gradient-2);
        color: var(--prussian-blue);
        transform: translateY(-3px);
        border-color: transparent;
    }

    /* Related Courses */
    .course-page-related-courses {
        margin-top: 30px;
    }

    @media (min-width: 768px) {
        .course-page-related-courses {
            margin-top: 60px;
        }
    }

    .course-page-related-header {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-bottom: 20px;
    }

    @media (min-width: 640px) {
        .course-page-related-header {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
    }

    .course-page-related-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--text-primary);
    }

    @media (min-width: 768px) {
        .course-page-related-title {
            font-size: 1.8rem;
        }
    }

    .course-page-view-all {
        color: var(--bright-amber);
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 8px 16px;
        border-radius: var(--radius-full);
        transition: var(--transition);
        border: 1px solid rgba(251, 198, 12, 0.3);
        font-size: 0.9rem;
    }

    @media (min-width: 768px) {
        .course-page-view-all {
            padding: 10px 20px;
            font-size: 1rem;
        }
    }

    .course-page-view-all:hover {
        background: var(--gradient-2);
        color: var(--prussian-blue);
        border-color: transparent;
        gap: 8px;
    }

    .course-page-related-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 15px;
    }

    @media (min-width: 480px) {
        .course-page-related-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (min-width: 992px) {
        .course-page-related-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }
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
        transform: translateY(-5px);
        box-shadow: var(--shadow-hover);
        border-color: var(--bright-amber);
    }

    @media (min-width: 768px) {
        .course-page-related-card:hover {
            transform: translateY(-8px);
        }
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
        padding: 15px;
    }

    @media (min-width: 768px) {
        .course-page-related-content {
            padding: 20px;
        }
    }

    .course-page-related-category {
        font-size: 0.7rem;
        color: var(--bright-amber);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
        margin-bottom: 5px;
    }

    @media (min-width: 768px) {
        .course-page-related-category {
            font-size: 0.8rem;
            margin-bottom: 8px;
        }
    }

    .course-page-related-title-small {
        font-size: 0.9rem;
        font-weight: 700;
        margin-bottom: 8px;
        color: var(--text-primary);
        line-height: 1.3;
    }

    @media (min-width: 768px) {
        .course-page-related-title-small {
            font-size: 1rem;
            margin-bottom: 10px;
        }
    }

    .course-page-related-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .course-page-related-price-small {
        font-size: 1rem;
        font-weight: 700;
        color: var(--prussian-blue);
    }

    .course-page-related-price-small.free {
        color: var(--sky-blue);
    }

    /* Video Modal */
    .course-page-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(10, 29, 68, 0.95);
        z-index: 99999;
        align-items: center;
        justify-content: center;
        padding: 15px;
    }

    .course-page-modal.show {
        display: flex;
        animation: fadeIn 0.3s ease;
    }

    .course-page-modal-content {
        position: relative;
        width: 100%;
        max-width: 900px;
        background: var(--prussian-blue);
        border-radius: var(--radius-lg);
        overflow: hidden;
        border: 2px solid var(--bright-amber);
    }

    .course-page-modal-close {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 35px;
        height: 35px;
        background: rgba(255, 255, 255, 0.2);
        border: none;
        border-radius: 50%;
        color: var(--pure-white);
        font-size: 1.1rem;
        cursor: pointer;
        transition: var(--transition);
        z-index: 10;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    @media (min-width: 768px) {
        .course-page-modal-close {
            top: 15px;
            right: 15px;
            width: 40px;
            height: 40px;
            font-size: 1.2rem;
        }
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
        left: 20px;
        padding: 15px 20px;
        border-radius: var(--radius-full);
        box-shadow: var(--shadow-lg);
        z-index: 10000;
        animation: slideIn 0.3s ease;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 10px;
        max-width: none;
        border-left: 4px solid var(--bright-amber);
    }

    @media (min-width: 640px) {
        .course-page-notification {
            left: auto;
            right: 20px;
            max-width: 400px;
        }
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

    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }

    /* Responsive Layout - Mobile First */
    .row {
        display: flex;
        flex-direction: column;
        gap: 30px;
    }

    /* Mobile Order (default) */
    .col-lg-8 {
        order: 2;
    }
    
    .col-lg-4 {
        order: 1;
    }

    /* Desktop Order */
    @media (min-width: 992px) {
        .row {
            flex-direction: row;
            gap: 30px;
        }
        
        .col-lg-8 {
            flex: 0 0 calc(66.666% - 15px);
            max-width: calc(66.666% - 15px);
            order: 1;
        }
        
        .col-lg-4 {
            flex: 0 0 calc(33.333% - 15px);
            max-width: calc(33.333% - 15px);
            order: 2;
        }
    }

    /* Hide extra content behind accordion */
    .course-page-hidden-content {
        display: none;
    }

    /* Print styles */
    @media print {
        .course-page-hero,
        .course-page-actions,
        .course-page-tabs,
        .course-page-modal,
        .course-page-notification {
            display: none;
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
                <span class="course-page-badge free"><i class="fas fa-gift"></i> Free</span>
                @else
                <span class="course-page-badge subscription"><i class="fas fa-crown"></i> Premium</span>
                @endif
                @if($course->level)
                <span class="course-page-badge"><i class="fas fa-signal"></i> {{ ucfirst($course->level) }}</span>
                @endif
            </div>

            <!-- Title -->
            <h1 class="course-page-hero-title">{{ $course->title }}</h1>

            <!-- Description -->
            <p class="course-page-hero-description">{{ $course->excerpt ?? Str::limit(strip_tags($course->description), 150) }}</p>

            <!-- Meta Info -->
            <div class="course-page-meta-list">
                <div class="course-page-meta-item">
                    <div class="course-page-meta-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="course-page-meta-content">
                        <h4>Students</h4>
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
                        <p>{{ ucfirst($course->level ?? 'All') }}</p>
                    </div>
                </div>
            </div>

            <!-- Instructor Mini -->
            @if($course->instructor)
            <div class="course-page-instructor-mini">
                <div class="course-page-instructor-mini-avatar">
                    {{ substr($course->instructor->name ?? 'E', 0, 1) }}
                </div>
                <div class="course-page-instructor-mini-info">
                    <h4>Created by</h4>
                    <p>{{ $course->instructor->name ?? 'EDUCONECX' }}</p>
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
            <!-- Right Column - Course Sidebar (mobile: appears first) -->
            <div class="col-lg-4">
                <div class="course-page-sidebar" data-aos="fade-left">
                    <!-- Course Card -->
                    <div class="course-page-course-card">
                        <div class="course-page-thumbnail">
                            <img src="{{ $course->thumbnail_url ?? 'https://via.placeholder.com/600x400' }}" alt="{{ $course->title }}">
                            <span class="course-page-price-badge {{ $course->is_free ? 'free' : '' }}">
                                @if($course->is_free)
                                <i class="fas fa-gift"></i> Free
                                @else
                                <i class="fas fa-crown"></i> Premium
                                @endif
                            </span>
                            @if($course->video_intro ?? $course->intro_video)
                            <button class="course-page-preview-btn" id="previewVideo" data-video="{{ $course->video_intro_url ?? $course->intro_video }}">
                                <i class="fas fa-play"></i>
                            </button>
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
                                        Enroll Now
                                    </button>
                                    @else
                                    <a href="{{ route('subscription.plans') }}" class="course-page-btn-enroll">
                                        <i class="fas fa-crown"></i>
                                        Get Subscription
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
                                Access
                                @endif
                            </a>
                            @endauth

                            <!-- <button class="course-page-btn-wishlist" id="wishlistBtn" data-course-id="{{ $course->id }}">
                                <i class="far fa-heart"></i>
                                Add to Wishlist
                            </button> -->
                        </div>

                        <!-- Accordion for Course Details -->
                        <!-- <div class="course-page-info-accordion">
                            <div class="course-page-accordion-item">
                                <div class="course-page-accordion-header active" data-accordion="includes">
                                    <span>What's Included</span>
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                                <div class="course-page-accordion-content show" id="accordion-includes">
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

                            @if($course->requirements)
                            <div class="course-page-accordion-item">
                                <div class="course-page-accordion-header" data-accordion="requirements">
                                    <span>Requirements</span>
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                                <div class="course-page-accordion-content" id="accordion-requirements">
                                    <ul class="course-page-includes-list">
                                        @foreach(explode("\n", $course->requirements) as $requirement)
                                        @if(trim($requirement))
                                        <li>
                                            <i class="fas fa-check-circle"></i>
                                            <span>{{ trim($requirement) }}</span>
                                        </li>
                                        @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            @endif

                            <div class="course-page-accordion-item">
                                <div class="course-page-accordion-header" data-accordion="target">
                                    <span>Target Audience</span>
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                                <div class="course-page-accordion-content" id="accordion-target">
                                    <p class="text-muted mb-0">{{ $course->target_audience ?? 'Anyone interested in learning this subject' }}</p>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>

            <!-- Left Column - Course Content (mobile: appears after sidebar) -->
            <div class="col-lg-8">
                <!-- Main Tabs -->
                <div class="course-page-tabs-wrapper" data-aos="fade-right">
                    <div class="course-page-tabs">
                        <button class="course-page-tab-btn active" data-tab="overview">Overview</button>
                        <button class="course-page-tab-btn" data-tab="curriculum">Curriculum</button>
                        <button class="course-page-tab-btn" data-tab="instructor">Instructor</button>
                        @if($course->reviews_count > 0)
                        <button class="course-page-tab-btn" data-tab="reviews">Reviews ({{ $course->reviews_count }})</button>
                        @endif
                    </div>

                    <div class="course-page-tab-content">
                        <!-- Overview Tab -->
                        <div class="course-page-tab-pane active" id="overview">
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

                        <!-- Curriculum Tab -->
                        <div class="course-page-tab-pane" id="curriculum">
                            <div class="course-page-curriculum-header">
                                <h2 class="course-page-section-title">Curriculum</h2>
                                <div class="course-page-curriculum-stats">
                                    <span><i class="far fa-file-video"></i> {{ $course->lessons_count ?? $course->total_lessons ?? 0 }} Lessons</span>
                                    <span><i class="far fa-clock"></i> {{ $course->total_duration ?? $course->duration ?? 'Self-Paced' }}</span>
                                </div>
                            </div>

                            @if(isset($course->sections) && $course->sections->count() > 0)
                            @foreach($course->sections as $sectionIndex => $section)
                            <div class="course-page-accordion-item">
                                <div class="course-page-accordion-header" data-section="{{ $sectionIndex }}">
                                    <span>{{ $section->title }}</span>
                                    <div class="course-page-section-meta">
                                        <span>{{ $section->lessons->count() }} lessons</span>
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
                                                <span><i class="fas fa-unlock-alt"></i> Preview</span>
                                                @endif
                                            </div>
                                        </div>
                                        @if($lesson->is_free_preview)
                                        <a href="#" class="course-page-lesson-preview" data-video="{{ $lesson->video_url ?? '' }}">
                                            Preview
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
                            <h2 class="course-page-section-title">Student Reviews</h2>
                            <!-- Add reviews content here -->
                        </div>
                        @endif
                    </div>
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
                                <h3 class="course-page-related-title-small">{{ $relatedCourse->title }}</h3>
                                <div class="course-page-related-meta">
                                    <span class="course-page-related-price-small {{ $relatedCourse->is_free ? 'free' : '' }}">
                                        @if($relatedCourse->is_free)
                                        Free
                                        @else
                                        Premium
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
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
        // ========== TAB SWITCHING ==========
        const tabBtns = document.querySelectorAll('.course-page-tab-btn');
        const tabPanes = document.querySelectorAll('.course-page-tab-pane');

        tabBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const tabId = this.dataset.tab;

                tabBtns.forEach(b => b.classList.remove('active'));
                tabPanes.forEach(p => p.classList.remove('active'));

                this.classList.add('active');
                document.getElementById(tabId).classList.add('active');
            });
        });

        // ========== ACCORDION (Main & Sidebar) ==========
        const accordionHeaders = document.querySelectorAll('.course-page-accordion-header');

        accordionHeaders.forEach(header => {
            header.addEventListener('click', function(e) {
                e.preventDefault();
                
                // For curriculum accordion
                if (this.dataset.section) {
                    const sectionId = this.dataset.section;
                    const content = document.getElementById(`section-${sectionId}`);
                    
                    this.classList.toggle('active');
                    
                    if (content.classList.contains('show')) {
                        content.classList.remove('show');
                    } else {
                        // Close other sections in the same accordion group
                        if (this.closest('.course-page-curriculum-section')) {
                            document.querySelectorAll('.course-page-accordion-header[data-section]').forEach(h => {
                                if (h !== this) {
                                    h.classList.remove('active');
                                    const otherContent = document.getElementById(`section-${h.dataset.section}`);
                                    if (otherContent) otherContent.classList.remove('show');
                                }
                            });
                        }
                        content.classList.add('show');
                    }
                } 
                // For sidebar accordion
                else if (this.dataset.accordion) {
                    const accordionId = this.dataset.accordion;
                    const content = document.getElementById(`accordion-${accordionId}`);
                    
                    this.classList.toggle('active');
                    
                    if (content.classList.contains('show')) {
                        content.classList.remove('show');
                    } else {
                        content.classList.add('show');
                    }
                }
            });
        });

        // Open first curriculum section by default
        const firstCurriculumHeader = document.querySelector('.course-page-curriculum-section .course-page-accordion-header');
        if (firstCurriculumHeader) {
            setTimeout(() => {
                firstCurriculumHeader.click();
            }, 100);
        }

        // ========== VIDEO PREVIEW MODAL ==========
        const modal = document.getElementById('videoModal');
        const previewBtn = document.getElementById('previewVideo');
        const closeBtn = document.getElementById('closeModal');
        const videoContainer = document.getElementById('videoContainer');

        function extractYoutubeId(url) {
            if (!url) return null;
            const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/;
            const match = url.match(regExp);
            return (match && match[2].length === 11) ? match[2] : null;
        }

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
                    videoContainer.innerHTML = '';
                }, 300);
            });
        }

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

                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enrolling...';
                this.disabled = true;

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
                            return response.json().then(err => { throw err; });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            showNotification(data.message || 'Successfully enrolled!', 'success');
                            setTimeout(() => {
                                window.location.href = data.redirect_url || '{{ route("courses.learning", $course->slug) }}';
                            }, 1500);
                        } else if (data.redirect_to_subscription) {
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
            const existingNotifications = document.querySelectorAll('.course-page-notification');
            existingNotifications.forEach(notification => notification.remove());

            const notification = document.createElement('div');
            notification.className = `course-page-notification ${type}`;

            const icons = {
                success: 'fa-check-circle',
                error: 'fa-exclamation-circle',
                info: 'fa-info-circle',
                warning: 'fa-exclamation-triangle'
            };

            const icon = document.createElement('i');
            icon.className = `fas ${icons[type]}`;
            notification.appendChild(icon);

            const textSpan = document.createElement('span');
            textSpan.textContent = message;
            notification.appendChild(textSpan);

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, 3000);
        }

        // ========== ADD SLIDE OUT ANIMATION ==========
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideOut {
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

        // ========== SCROLL TO TOP WHEN TABS CHANGE ==========
        tabBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const tabsWrapper = document.querySelector('.course-page-tabs-wrapper');
                if (tabsWrapper && window.innerWidth <= 768) {
                    tabsWrapper.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        console.log('Course page JavaScript initialized successfully');
    });
</script>
@endpush