@extends('layouts.main')

@section('title', $course->title . ' - EDUCONECX')

@section('meta_description', Str::limit($course->excerpt ?? strip_tags($course->description), 160))

@section('content')
<style>
    /* Course Page Specific Styles - Scoped to prevent conflicts */
    .course-page-hero {
        position: relative;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 60px 0;
        color: #ffffff;
        overflow: hidden;
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
        background: rgba(255, 255, 255, 0.1);
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
        animation: course-page-float 10s ease-in-out infinite reverse;
    }

    .course-page-particle:nth-child(3) {
        width: 150px;
        height: 150px;
        top: 30%;
        left: 20%;
        animation: course-page-float 12s ease-in-out infinite;
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
        transition: all 0.3s ease;
    }

    .course-page-breadcrumb a:hover {
        color: #ffffff;
    }

    .course-page-breadcrumb i {
        font-size: 0.7rem;
        margin: 0 10px;
        color: rgba(255, 255, 255, 0.5);
    }

    .course-page-breadcrumb span {
        color: #ffffff;
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
        border-radius: 9999px;
        font-size: 0.85rem;
        font-weight: 600;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .course-page-badge.featured {
        background: #f72585;
    }

    .course-page-badge.free {
        background: #06d6a0;
    }

    .course-page-hero-title {
        font-size: clamp(1.8rem, 4vw, 2.5rem) !important;
        font-weight: 800 !important;
        margin-bottom: 15px !important;
        line-height: 1.2 !important;
        color: #ffffff !important;
    }

    .course-page-hero-description {
        font-size: 1.1rem !important;
        opacity: 0.9;
        margin-bottom: 25px !important;
        max-width: 800px;
        color: #ffffff !important;
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
    }

    .course-page-meta-content h4 {
        font-size: 0.9rem !important;
        font-weight: 400 !important;
        opacity: 0.8;
        margin: 0 0 5px 0 !important;
        color: #ffffff !important;
    }

    .course-page-meta-content p {
        font-size: 1.1rem !important;
        font-weight: 600 !important;
        margin: 0 !important;
        color: #ffffff !important;
    }

    .course-page-instructor-mini {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-top: 20px;
    }

    .course-page-instructor-mini-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: 600;
        color: #ffffff;
    }

    .course-page-instructor-mini-info h4 {
        font-size: 1rem !important;
        font-weight: 400 !important;
        opacity: 0.8;
        margin: 0 0 5px 0 !important;
        color: #ffffff !important;
    }

    .course-page-instructor-mini-info p {
        font-size: 1.2rem !important;
        font-weight: 600 !important;
        margin: 0 !important;
        color: #ffffff !important;
    }

    /* Main Content */
    .course-page-main {
        padding: 60px 0;
        background: #f8f9fa;
    }

    /* Course Sidebar */
    .course-page-sidebar {
        position: sticky;
        top: 100px;
    }

    .course-page-card {
        background: #ffffff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
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

    .course-page-preview-btn {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 70px;
        height: 70px;
        background: #ffffff;
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #667eea;
        font-size: 1.8rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        opacity: 0;
        visibility: hidden;
    }

    .course-page-thumbnail:hover .course-page-preview-btn {
        opacity: 1;
        visibility: visible;
        transform: translate(-50%, -50%) scale(1.1);
    }

    .course-page-preview-btn:hover {
        background: #667eea;
        color: #ffffff;
    }

    .course-page-price-box {
        padding: 25px;
        border-bottom: 1px solid #e9ecef;
    }

    .course-page-price {
        font-size: 2.5rem !important;
        font-weight: 800 !important;
        color: #667eea !important;
        margin-bottom: 5px !important;
    }

    .course-page-price.free {
        color: #06d6a0 !important;
    }

    .course-page-price small {
        font-size: 1rem !important;
        font-weight: 400 !important;
        color: #6c757d !important;
        text-decoration: line-through;
        margin-left: 10px;
    }

    .course-page-price-label {
        font-size: 0.9rem !important;
        color: #6c757d !important;
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
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        color: #ffffff !important;
        border: none !important;
        border-radius: 9999px !important;
        font-size: 1.1rem !important;
        font-weight: 600 !important;
        cursor: pointer !important;
        transition: all 0.3s ease !important;
        text-decoration: none;
        width: 100%;
    }

    .course-page-btn-enroll:hover {
        transform: translateY(-3px);
        box-shadow: 0 20px 40px rgba(102, 126, 234, 0.3) !important;
        color: #ffffff !important;
    }

    .course-page-btn-wishlist {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 14px 30px;
        background: #f8f9fa !important;
        color: #1e1e2f !important;
        border: 2px solid #e9ecef !important;
        border-radius: 9999px !important;
        font-size: 1rem !important;
        font-weight: 600 !important;
        cursor: pointer !important;
        transition: all 0.3s ease !important;
        text-decoration: none;
        width: 100%;
    }

    .course-page-btn-wishlist:hover {
        background: #667eea !important;
        color: #ffffff !important;
        border-color: #667eea !important;
    }

    .course-page-btn-wishlist.active {
        background: #667eea !important;
        color: #ffffff !important;
        border-color: #667eea !important;
    }

    .course-page-includes {
        padding: 25px;
        background: #f8f9fa;
    }

    .course-page-includes h4 {
        font-size: 1.2rem !important;
        font-weight: 700 !important;
        margin-bottom: 20px !important;
        color: #1e1e2f !important;
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
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .course-page-includes-list li:last-child {
        border-bottom: none;
    }

    .course-page-includes-list i {
        width: 20px;
        color: #667eea;
        font-size: 1rem;
    }

    .course-page-includes-list span {
        flex: 1;
        color: #6c757d;
        font-size: 0.95rem;
    }

    .course-page-includes-list strong {
        color: #1e1e2f;
        font-weight: 600;
    }

    /* Course Content */
    .course-page-content-wrapper {
        background: #ffffff;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .course-page-tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 30px;
        border-bottom: 2px solid #e9ecef;
        padding-bottom: 15px;
        flex-wrap: wrap;
    }

    .course-page-tab-btn {
        padding: 12px 25px;
        background: none;
        border: none;
        border-radius: 10px;
        font-size: 1rem !important;
        font-weight: 600 !important;
        color: #6c757d;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
    }

    .course-page-tab-btn:hover {
        color: #667eea;
    }

    .course-page-tab-btn.active {
        color: #667eea;
        background: rgba(102, 126, 234, 0.1);
    }

    .course-page-tab-btn.active::after {
        content: '';
        position: absolute;
        bottom: -17px;
        left: 0;
        width: 100%;
        height: 2px;
        background: #667eea;
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
        font-size: 1.5rem !important;
        font-weight: 700 !important;
        margin-bottom: 20px !important;
        color: #1e1e2f !important;
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
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 3px;
    }

    .course-page-description {
        color: #6c757d !important;
        line-height: 1.8 !important;
        font-size: 1.05rem !important;
    }

    .course-page-description h3 {
        font-size: 1.3rem !important;
        color: #1e1e2f !important;
        margin: 30px 0 15px !important;
    }

    .course-page-description h4 {
        font-size: 1.1rem !important;
        color: #1e1e2f !important;
        margin: 25px 0 10px !important;
    }

    .course-page-description p {
        margin-bottom: 15px !important;
    }

    .course-page-description ul,
    .course-page-description ol {
        margin-bottom: 20px !important;
        padding-left: 20px !important;
    }

    .course-page-description li {
        margin-bottom: 8px !important;
    }

    .course-page-description img {
        max-width: 100%;
        border-radius: 12px;
        margin: 20px 0;
    }

    .course-page-learning-outcomes {
        background: #f8f9fa;
        padding: 30px;
        border-radius: 20px;
        margin: 30px 0;
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
        background: rgba(102, 126, 234, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #667eea;
        font-size: 0.9rem;
        flex-shrink: 0;
    }

    .course-page-outcome-text {
        color: #1e1e2f !important;
        font-size: 0.95rem !important;
        line-height: 1.5 !important;
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
    }

    .course-page-curriculum-stats {
        display: flex;
        gap: 20px;
        color: #6c757d;
        font-size: 0.95rem;
    }

    .course-page-curriculum-stats i {
        color: #667eea;
        margin-right: 5px;
    }

    .course-page-accordion-item {
        background: #ffffff;
        border: 1px solid #e9ecef;
        border-radius: 12px;
        margin-bottom: 15px;
        overflow: hidden;
    }

    .course-page-accordion-header {
        padding: 18px 20px;
        background: #f8f9fa;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.3s ease;
    }

    .course-page-accordion-header:hover {
        background: rgba(102, 126, 234, 0.05);
    }

    .course-page-accordion-header h3 {
        font-size: 1.1rem !important;
        font-weight: 600 !important;
        margin: 0 !important;
        color: #1e1e2f !important;
    }

    .course-page-section-meta {
        display: flex;
        align-items: center;
        gap: 15px;
        font-size: 0.9rem;
        color: #6c757d;
    }

    .course-page-section-meta i {
        transition: all 0.3s ease;
    }

    .course-page-accordion-header.active .course-page-section-meta i {
        transform: rotate(180deg);
    }

    .course-page-accordion-content {
        display: none;
        padding: 20px;
        border-top: 1px solid #e9ecef;
    }

    .course-page-accordion-content.show {
        display: block;
    }

    .course-page-lesson-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 12px 15px;
        border-bottom: 1px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .course-page-lesson-item:last-child {
        border-bottom: none;
    }

    .course-page-lesson-item:hover {
        background: #f8f9fa;
    }

    .course-page-lesson-icon {
        width: 30px;
        color: #667eea;
        font-size: 1rem;
        text-align: center;
    }

    .course-page-lesson-info {
        flex: 1;
    }

    .course-page-lesson-title {
        font-weight: 500 !important;
        color: #1e1e2f !important;
        margin-bottom: 5px !important;
    }

    .course-page-lesson-meta {
        display: flex;
        gap: 15px;
        font-size: 0.85rem !important;
        color: #6c757d !important;
    }

    .course-page-lesson-meta i {
        margin-right: 5px;
    }

    .course-page-lesson-preview {
        color: #667eea !important;
        text-decoration: none !important;
        font-size: 0.9rem !important;
        font-weight: 500 !important;
    }

    .course-page-lesson-preview:hover {
        text-decoration: underline !important;
    }

    .course-page-lesson-locked {
        color: #6c757d;
        font-size: 1rem;
    }

    /* Instructor Tab */
    .course-page-instructor-profile {
        display: flex;
        gap: 30px;
        flex-wrap: wrap;
    }

    .course-page-instructor-avatar-large {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        font-weight: 600;
        color: #ffffff;
        flex-shrink: 0;
    }

    .course-page-instructor-details {
        flex: 1;
    }

    .course-page-instructor-name {
        font-size: 2rem !important;
        font-weight: 700 !important;
        margin-bottom: 5px !important;
        color: #1e1e2f !important;
    }

    .course-page-instructor-title {
        font-size: 1.1rem !important;
        color: #667eea !important;
        margin-bottom: 20px !important;
    }

    .course-page-instructor-bio {
        color: #6c757d !important;
        line-height: 1.8 !important;
        margin-bottom: 25px !important;
    }

    .course-page-instructor-stats {
        display: flex;
        gap: 40px;
        margin-bottom: 25px;
        padding: 20px 0;
        border-top: 1px solid #e9ecef;
        border-bottom: 1px solid #e9ecef;
    }

    .course-page-stat-item {
        text-align: center;
    }

    .course-page-stat-value {
        font-size: 1.8rem !important;
        font-weight: 700 !important;
        color: #667eea !important;
        line-height: 1;
        margin-bottom: 5px !important;
    }

    .course-page-stat-label {
        font-size: 0.9rem !important;
        color: #6c757d !important;
    }

    .course-page-instructor-social {
        display: flex;
        gap: 15px;
    }

    .course-page-social-link {
        width: 45px;
        height: 45px;
        background: #f8f9fa;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6c757d;
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: 1.2rem;
    }

    .course-page-social-link:hover {
        background: #667eea;
        color: #ffffff;
        transform: translateY(-3px);
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
    }

    .course-page-related-title {
        font-size: 1.8rem !important;
        font-weight: 700 !important;
        color: #1e1e2f !important;
    }

    .course-page-view-all {
        color: #667eea !important;
        text-decoration: none !important;
        font-weight: 600 !important;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .course-page-view-all:hover {
        gap: 10px;
    }

    .course-page-related-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 25px;
    }

    .course-page-related-card {
        background: #ffffff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        text-decoration: none;
        color: inherit;
    }

    .course-page-related-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
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
        font-size: 0.8rem !important;
        color: #667eea !important;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
        margin-bottom: 8px !important;
    }

    .course-page-related-title {
        font-size: 1.1rem !important;
        font-weight: 700 !important;
        margin-bottom: 10px !important;
        color: #1e1e2f !important;
    }

    .course-page-related-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .course-page-related-price {
        font-size: 1.2rem !important;
        font-weight: 700 !important;
        color: #667eea !important;
    }

    .course-page-related-price.free {
        color: #06d6a0 !important;
    }

    .course-page-related-rating {
        color: #ffc107;
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
        background: rgba(0, 0, 0, 0.8);
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
        background: #1e1e2f;
        border-radius: 20px;
        overflow: hidden;
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
        color: #ffffff;
        font-size: 1.2rem;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 10;
    }

    .course-page-modal-close:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: rotate(90deg);
    }

    .course-page-video-container {
        position: relative;
        padding-bottom: 56.25%;
        height: 0;
    }

    .course-page-video-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }

    /* Animations */
    @keyframes course-page-float {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-20px);
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
    }

    @media (max-width: 768px) {
        .course-page-hero {
            padding: 40px 0;
        }

        .course-page-hero-title {
            font-size: 1.8rem !important;
        }

        .course-page-meta-list {
            gap: 20px;
        }

        .course-page-content-wrapper {
            padding: 20px;
        }

        .course-page-instructor-stats {
            flex-direction: column;
            gap: 20px;
        }
    }
</style>

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
                <span class="course-page-badge featured">Featured</span>
                @endif
                @if($course->is_free)
                <span class="course-page-badge free">Free Course</span>
                @elseif($course->sale_price && $course->sale_price < $course->price)
                <span class="course-page-badge">Sale</span>
                @endif
                @if($course->level)
                <span class="course-page-badge">{{ ucfirst($course->level) }}</span>
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
                        <p>{{ $course->duration ?? 'Self-Paced' }}</p>
                    </div>
                </div>

                <div class="course-page-meta-item">
                    <div class="course-page-meta-icon">
                        <i class="fas fa-video"></i>
                    </div>
                    <div class="course-page-meta-content">
                        <h4>Lessons</h4>
                        <p>{{ $course->total_lessons ?? 0 }}</p>
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
                                    <span><i class="far fa-file-video"></i> {{ $course->total_lessons ?? 0 }} Lessons</span>
                                    <span><i class="far fa-clock"></i> {{ $course->total_duration ?? 'Self-Paced' }}</span>
                                </div>
                            </div>

                            @if($course->sections && $course->sections->count() > 0)
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
                                                <span class="text-success"><i class="fas fa-unlock-alt"></i> Free Preview</span>
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
                                <img src="{{ $relatedCourse->thumbnail_url }}" alt="{{ $relatedCourse->title }}">
                            </div>
                            <div class="course-page-related-content">
                                <div class="course-page-related-category">{{ $relatedCourse->category->name ?? 'General' }}</div>
                                <h3 class="course-page-related-title">{{ $relatedCourse->title }}</h3>
                                <div class="course-page-related-meta">
                                    <span class="course-page-related-price {{ $relatedCourse->is_free ? 'free' : '' }}">
                                        @if($relatedCourse->is_free)
                                            Free
                                        @elseif($relatedCourse->sale_price && $relatedCourse->sale_price < $relatedCourse->price)
                                            ${{ number_format($relatedCourse->sale_price, 2) }}
                                        @elseif($relatedCourse->price > 0)
                                            ${{ number_format($relatedCourse->price, 2) }}
                                        @else
                                            Free
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

            <!-- Right Column - Course Sidebar -->
            <div class="col-lg-4">
                <div class="course-page-sidebar" data-aos="fade-left">
                    <!-- Course Card -->
                    <div class="course-page-card">
                        <div class="course-page-thumbnail">
                            <img src="{{ $course->thumbnail_url }}" alt="{{ $course->title }}">
                            @if($course->video_intro)
                            <button class="course-page-preview-btn" id="previewVideo" data-video="{{ $course->video_intro_url }}">
                                <i class="fas fa-play"></i>
                            </button>
                            @endif
                        </div>

                        <div class="course-page-price-box">
                            <div class="course-page-price {{ $course->is_free ? 'free' : '' }}">
                                @if($course->is_free)
                                    Free
                                @elseif($course->sale_price && $course->sale_price < $course->price)
                                    ${{ number_format($course->sale_price, 2) }}
                                    <small>${{ number_format($course->price, 2) }}</small>
                                @elseif($course->price > 0)
                                    ${{ number_format($course->price, 2) }}
                                @else
                                    Free
                                @endif
                            </div>
                            <span class="course-page-price-label">one-time payment, lifetime access</span>
                        </div>

                        <!-- Course Actions -->
                        <div class="course-page-actions">
                            @auth
                                @if($course->is_enrolled)
                                    <a href="{{ route('courses.learning', $course->slug) }}" class="course-page-btn-enroll" id="continueLearningBtn">
                                        <i class="fas fa-play-circle"></i>
                                        Continue Learning ({{ $course->user_progress ?? 0 }}%)
                                    </a>
                                @elseif($course->is_free)
                                    <button class="course-page-btn-enroll" id="enrollBtn" data-course-id="{{ $course->id }}" data-course-type="free">
                                        <i class="fas fa-graduation-cap"></i>
                                        Enroll Now - Free
                                    </button>
                                @else
                                    <a href="{{ route('checkout', $course) }}" class="course-page-btn-enroll" id="purchaseBtn">
                                        <i class="fas fa-shopping-cart"></i>
                                        Purchase Now - 
                                        @if($course->sale_price && $course->sale_price < $course->price)
                                            ${{ number_format($course->sale_price, 2) }}
                                        @else
                                            ${{ number_format($course->price, 2) }}
                                        @endif
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('login') }}?redirect={{ url()->current() }}" class="course-page-btn-enroll">
                                    <i class="fas fa-sign-in-alt"></i>
                                    Login to 
                                    @if($course->is_free)
                                        Enroll
                                    @else
                                        Purchase
                                    @endif
                                </a>
                            @endauth

                            <button class="course-page-btn-wishlist" id="wishlistBtn" data-course-id="{{ $course->id }}">
                                <i class="far fa-heart"></i>
                                Add to Wishlist
                            </button>
                        </div>

                        <div class="course-page-includes">
                            <h4>This course includes:</h4>
                            <ul class="course-page-includes-list">
                                <li>
                                    <i class="fas fa-video"></i>
                                    <span>{{ $course->total_lessons ?? 0 }} on-demand videos</span>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
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
            accordionHeaders[0].click();
        }

        // ========== VIDEO PREVIEW MODAL ==========
        const modal = document.getElementById('videoModal');
        const previewBtn = document.getElementById('previewVideo');
        const closeBtn = document.getElementById('closeModal');
        const videoContainer = document.getElementById('videoContainer');

        if (previewBtn) {
            previewBtn.addEventListener('click', function(e) {
                e.preventDefault();
                modal.classList.add('show');

                const videoUrl = this.dataset.video;
                if (videoUrl) {
                    if (videoUrl.includes('youtube.com') || videoUrl.includes('youtu.be')) {
                        // Extract YouTube ID and create embed
                        const videoId = extractYoutubeId(videoUrl);
                        if (videoId) {
                            videoContainer.innerHTML = `<iframe src="https://www.youtube.com/embed/${videoId}" frameborder="0" allowfullscreen></iframe>`;
                        }
                    } else if (videoUrl.includes('vimeo.com')) {
                        // Extract Vimeo ID
                        const vimeoId = videoUrl.split('/').pop();
                        videoContainer.innerHTML = `<iframe src="https://player.vimeo.com/video/${vimeoId}" frameborder="0" allowfullscreen></iframe>`;
                    } else {
                        // Assume it's a local video file
                        videoContainer.innerHTML = `<video src="${videoUrl}" controls style="width:100%; height:100%;"></video>`;
                    }
                }
            });
        }

        // Helper function to extract YouTube ID
        function extractYoutubeId(url) {
            const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/;
            const match = url.match(regExp);
            return (match && match[2].length === 11) ? match[2] : null;
        }

        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                modal.classList.remove('show');
                videoContainer.innerHTML = ''; // Clear video when closing
            });
        }

        // Close modal when clicking outside
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.classList.remove('show');
                videoContainer.innerHTML = '';
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

                // Show loading state
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enrolling...';
                this.disabled = true;

                // Make AJAX request to enroll
                fetch(`/courses/${courseId}/enroll-ajax`, {
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
                            showNotification(data.message, 'success');

                            // Redirect to learning page
                            setTimeout(() => {
                                window.location.href = data.redirect_url;
                            }, 1500);
                        } else if (data.redirect_to_checkout) {
                            // Redirect to checkout for paid courses
                            window.location.href = data.checkout_url;
                        } else {
                            showNotification(data.message, 'error');
                            this.innerHTML = originalText;
                            this.disabled = false;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('An error occurred. Please try again.', 'error');
                        this.innerHTML = originalText;
                        this.disabled = false;
                    });
                @else
                // Redirect to login with return URL
                window.location.href = '{{ route("login") }}?redirect={{ url()->current() }}';
                @endauth
            });
        }

        // ========== WISHLIST FUNCTIONALITY ==========
        const wishlistBtn = document.getElementById('wishlistBtn');

        if (wishlistBtn) {
            // Check initial wishlist status
            @auth
            @if($course->is_wishlisted ?? false)
            wishlistBtn.classList.add('active');
            wishlistBtn.querySelector('i').classList.remove('far');
            wishlistBtn.querySelector('i').classList.add('fas');
            @endif
            @endauth

            wishlistBtn.addEventListener('click', function(e) {
                e.preventDefault();

                @auth
                // Check if user is enrolled (can't wishlist enrolled courses)
                @if(isset($course) && ($course->is_enrolled ?? false))
                showNotification('You are already enrolled in this course!', 'info');
                return;
                @endif

                this.classList.toggle('active');
                const icon = this.querySelector('i');

                if (this.classList.contains('active')) {
                    icon.classList.remove('far');
                    icon.classList.add('fas');

                    // Make AJAX call to add to wishlist
                    fetch('{{ route("wishlist.add", $course->id) }}', {
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
                                showNotification('Course added to wishlist', 'success');
                            } else {
                                showNotification(data.message || 'Error adding to wishlist', 'error');
                                // Revert if failed
                                this.classList.remove('active');
                                icon.classList.remove('fas');
                                icon.classList.add('far');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showNotification('Error adding to wishlist', 'error');
                            // Revert if failed
                            this.classList.remove('active');
                            icon.classList.remove('fas');
                            icon.classList.add('far');
                        });
                } else {
                    icon.classList.remove('fas');
                    icon.classList.add('far');

                    // Make AJAX call to remove from wishlist
                    fetch('{{ route("wishlist.remove", $course->id) }}', {
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
                                showNotification('Course removed from wishlist', 'info');
                            } else {
                                showNotification(data.message || 'Error removing from wishlist', 'error');
                                // Revert if failed
                                this.classList.add('active');
                                icon.classList.remove('far');
                                icon.classList.add('fas');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showNotification('Error removing from wishlist', 'error');
                            // Revert if failed
                            this.classList.add('active');
                            icon.classList.remove('far');
                            icon.classList.add('fas');
                        });
                }
                @else
                // Store the current page in session to redirect back after login
                sessionStorage.setItem('redirectAfterLogin', window.location.href);
                window.location.href = '{{ route("login") }}';
                @endauth
            });
        }

        // ========== LESSON PREVIEW FUNCTIONALITY ==========
        const previewLinks = document.querySelectorAll('.course-page-lesson-preview');

        previewLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();

                const videoUrl = this.dataset.video;
                if (videoUrl && modal) {
                    modal.classList.add('show');

                    if (videoUrl.includes('youtube.com') || videoUrl.includes('youtu.be')) {
                        const videoId = extractYoutubeId(videoUrl);
                        if (videoId) {
                            videoContainer.innerHTML = `<iframe src="https://www.youtube.com/embed/${videoId}" frameborder="0" allowfullscreen></iframe>`;
                        }
                    } else {
                        videoContainer.innerHTML = `<video src="${videoUrl}" controls style="width:100%; height:100%;"></video>`;
                    }
                }
            });
        });

        // ========== NOTIFICATION SYSTEM ==========
        function showNotification(message, type = 'success') {
            // Remove any existing notifications
            const existingNotifications = document.querySelectorAll('.course-page-notification');
            existingNotifications.forEach(notification => notification.remove());

            const notification = document.createElement('div');
            notification.className = 'course-page-notification';

            // Set styles based on type
            const colors = {
                success: '#28a745',
                error: '#dc3545',
                info: '#17a2b8',
                warning: '#ffc107'
            };

            const icons = {
                success: 'fa-check-circle',
                error: 'fa-exclamation-circle',
                info: 'fa-info-circle',
                warning: 'fa-exclamation-triangle'
            };

            notification.style.cssText = `
                position: fixed;
                bottom: 20px;
                right: 20px;
                background: ${colors[type]};
                color: ${type === 'warning' ? '#212529' : 'white'};
                padding: 15px 25px;
                border-radius: 50px;
                box-shadow: 0 5px 20px rgba(0,0,0,0.2);
                z-index: 10000;
                animation: course-page-slideIn 0.3s ease;
                font-weight: 500;
                display: flex;
                align-items: center;
                gap: 10px;
                max-width: 400px;
            `;

            // Add icon
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

        // ========== ADD ANIMATION STYLES ==========
        const style = document.createElement('style');
        style.textContent = `
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

            .course-page-btn-enroll:disabled,
            .course-page-btn-wishlist:disabled {
                opacity: 0.7;
                cursor: not-allowed;
            }

            .course-page-notification {
                display: flex;
                align-items: center;
                gap: 10px;
                font-size: 0.95rem;
            }

            .course-page-notification i {
                font-size: 1.2rem;
            }
        `;
        document.head.appendChild(style);

        console.log('Course page JavaScript initialized successfully');
    });
</script>
@endsection