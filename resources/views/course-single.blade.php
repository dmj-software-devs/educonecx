@extends('layouts.main')

@section('title', $course->title . ' - EDUCONECX')

@section('meta_description', Str::limit($course->excerpt ?? strip_tags($course->description), 160))

@push('styles')
<style>
    /* Course Hero Section */
    .course-hero {
        position: relative;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 60px 0;
        color: var(--white);
        overflow: hidden;
    }

    .course-hero-particles {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    .course-hero-particle {
        position: absolute;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .course-hero-particle:nth-child(1) {
        width: 300px;
        height: 300px;
        top: -150px;
        right: -150px;
        animation: float 8s ease-in-out infinite;
    }

    .course-hero-particle:nth-child(2) {
        width: 200px;
        height: 200px;
        bottom: -100px;
        left: -100px;
        animation: float 10s ease-in-out infinite reverse;
    }

    .course-hero-particle:nth-child(3) {
        width: 150px;
        height: 150px;
        top: 30%;
        left: 20%;
        animation: float 12s ease-in-out infinite;
    }

    .course-hero-content {
        position: relative;
        z-index: 2;
    }

    .course-breadcrumb {
        margin-bottom: 20px;
    }

    .course-breadcrumb a {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        font-size: 0.95rem;
        transition: var(--transition);
    }

    .course-breadcrumb a:hover {
        color: var(--white);
    }

    .course-breadcrumb i {
        font-size: 0.7rem;
        margin: 0 10px;
        color: rgba(255, 255, 255, 0.5);
    }

    .course-breadcrumb span {
        color: var(--white);
        font-size: 0.95rem;
    }

    .course-badge-wrapper {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .course-badge {
        display: inline-block;
        padding: 6px 16px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: var(--border-radius-full);
        font-size: 0.85rem;
        font-weight: 600;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .course-badge.featured {
        background: var(--accent);
    }

    .course-badge.free {
        background: var(--success);
    }

    .course-hero-title {
        font-size: clamp(1.8rem, 4vw, 2.5rem);
        font-weight: 800;
        margin-bottom: 15px;
        line-height: 1.2;
    }

    .course-hero-description {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 25px;
        max-width: 800px;
    }

    .course-meta-list {
        display: flex;
        gap: 30px;
        flex-wrap: wrap;
        margin-bottom: 30px;
    }

    .course-meta-item {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .meta-icon {
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

    .meta-content h4 {
        font-size: 0.9rem;
        font-weight: 400;
        opacity: 0.8;
        margin: 0 0 5px 0;
    }

    .meta-content p {
        font-size: 1.1rem;
        font-weight: 600;
        margin: 0;
    }

    .instructor-mini {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-top: 20px;
    }

    .instructor-mini-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: var(--gradient-1);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--white);
    }

    .instructor-mini-info h4 {
        font-size: 1rem;
        font-weight: 400;
        opacity: 0.8;
        margin: 0 0 5px 0;
    }

    .instructor-mini-info p {
        font-size: 1.2rem;
        font-weight: 600;
        margin: 0;
    }

    /* Main Content */
    .course-main {
        padding: 60px 0;
        background: var(--light);
    }

    /* Course Sidebar */
    .course-sidebar {
        position: sticky;
        top: 100px;
    }

    .course-card {
        background: var(--white);
        border-radius: var(--border-radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-lg);
        margin-bottom: 30px;
    }

    .course-thumbnail {
        position: relative;
        aspect-ratio: 16/9;
        overflow: hidden;
    }

    .course-thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .course-preview-btn {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 70px;
        height: 70px;
        background: var(--white);
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        font-size: 1.8rem;
        cursor: pointer;
        transition: var(--transition);
        box-shadow: var(--shadow-lg);
        opacity: 0;
        visibility: hidden;
    }

    .course-thumbnail:hover .course-preview-btn {
        opacity: 1;
        visibility: visible;
        transform: translate(-50%, -50%) scale(1.1);
    }

    .course-preview-btn:hover {
        background: var(--primary);
        color: var(--white);
    }

    .course-price-box {
        padding: 25px;
        border-bottom: 1px solid var(--gray-light);
    }

    .course-price {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--primary);
        margin-bottom: 5px;
    }

    .course-price.free {
        color: var(--success);
    }

    .course-price small {
        font-size: 1rem;
        font-weight: 400;
        color: var(--gray);
        text-decoration: line-through;
        margin-left: 10px;
    }

    .price-label {
        font-size: 0.9rem;
        color: var(--gray);
    }

    .course-actions {
        padding: 25px;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .btn-enroll {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 16px 30px;
        background: var(--gradient-1);
        color: var(--white);
        border: none;
        border-radius: var(--border-radius-full);
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        text-decoration: none;
        width: 100%;
    }

    .btn-enroll:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-lg);
        color: var(--white);
    }

    .btn-wishlist {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 14px 30px;
        background: var(--light);
        color: var(--dark);
        border: 2px solid var(--gray-light);
        border-radius: var(--border-radius-full);
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        text-decoration: none;
        width: 100%;
    }

    .btn-wishlist:hover {
        background: var(--primary);
        color: var(--white);
        border-color: var(--primary);
    }

    .btn-wishlist.active {
        background: var(--primary);
        color: var(--white);
        border-color: var(--primary);
    }

    .course-includes {
        padding: 25px;
        background: var(--light);
    }

    .course-includes h4 {
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 20px;
        color: var(--dark);
    }

    .includes-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .includes-list li {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .includes-list li:last-child {
        border-bottom: none;
    }

    .includes-list i {
        width: 20px;
        color: var(--primary);
        font-size: 1rem;
    }

    .includes-list span {
        flex: 1;
        color: var(--gray);
        font-size: 0.95rem;
    }

    .includes-list strong {
        color: var(--dark);
        font-weight: 600;
    }

    /* Course Content */
    .course-content-wrapper {
        background: var(--white);
        border-radius: var(--border-radius-lg);
        padding: 40px;
        box-shadow: var(--shadow-sm);
    }

    .course-tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 30px;
        border-bottom: 2px solid var(--gray-light);
        padding-bottom: 15px;
        flex-wrap: wrap;
    }

    .tab-btn {
        padding: 12px 25px;
        background: none;
        border: none;
        border-radius: var(--border-radius-md);
        font-size: 1rem;
        font-weight: 600;
        color: var(--gray);
        cursor: pointer;
        transition: var(--transition);
        position: relative;
    }

    .tab-btn:hover {
        color: var(--primary);
    }

    .tab-btn.active {
        color: var(--primary);
        background: rgba(102, 126, 234, 0.1);
    }

    .tab-btn.active::after {
        content: '';
        position: absolute;
        bottom: -17px;
        left: 0;
        width: 100%;
        height: 2px;
        background: var(--primary);
    }

    .tab-pane {
        display: none;
    }

    .tab-pane.active {
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

    /* Overview Tab */
    .overview-section {
        margin-bottom: 40px;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 20px;
        color: var(--dark);
        position: relative;
        padding-bottom: 10px;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 3px;
        background: var(--gradient-1);
        border-radius: 3px;
    }

    .course-description {
        color: var(--gray);
        line-height: 1.8;
        font-size: 1.05rem;
    }

    .course-description h3 {
        font-size: 1.3rem;
        color: var(--dark);
        margin: 30px 0 15px;
    }

    .course-description h4 {
        font-size: 1.1rem;
        color: var(--dark);
        margin: 25px 0 10px;
    }

    .course-description p {
        margin-bottom: 15px;
    }

    .course-description ul,
    .course-description ol {
        margin-bottom: 20px;
        padding-left: 20px;
    }

    .course-description li {
        margin-bottom: 8px;
    }

    .course-description img {
        max-width: 100%;
        border-radius: var(--border-radius-md);
        margin: 20px 0;
    }

    .learning-outcomes {
        background: var(--light);
        padding: 30px;
        border-radius: var(--border-radius-lg);
        margin: 30px 0;
    }

    .outcomes-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
    }

    .outcome-item {
        display: flex;
        gap: 15px;
        align-items: flex-start;
    }

    .outcome-icon {
        width: 30px;
        height: 30px;
        background: rgba(102, 126, 234, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        font-size: 0.9rem;
        flex-shrink: 0;
    }

    .outcome-text {
        color: var(--dark);
        font-size: 0.95rem;
        line-height: 1.5;
    }

    /* Curriculum Tab */
    .curriculum-section {
        margin-bottom: 30px;
    }

    .curriculum-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .curriculum-stats {
        display: flex;
        gap: 20px;
        color: var(--gray);
        font-size: 0.95rem;
    }

    .curriculum-stats i {
        color: var(--primary);
        margin-right: 5px;
    }

    .accordion-item {
        background: var(--white);
        border: 1px solid var(--gray-light);
        border-radius: var(--border-radius-md);
        margin-bottom: 15px;
        overflow: hidden;
    }

    .accordion-header {
        padding: 18px 20px;
        background: var(--light);
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: var(--transition);
    }

    .accordion-header:hover {
        background: rgba(102, 126, 234, 0.05);
    }

    .accordion-header h3 {
        font-size: 1.1rem;
        font-weight: 600;
        margin: 0;
        color: var(--dark);
    }

    .section-meta {
        display: flex;
        align-items: center;
        gap: 15px;
        font-size: 0.9rem;
        color: var(--gray);
    }

    .section-meta i {
        transition: var(--transition);
    }

    .accordion-header.active .section-meta i {
        transform: rotate(180deg);
    }

    .accordion-content {
        display: none;
        padding: 20px;
        border-top: 1px solid var(--gray-light);
    }

    .accordion-content.show {
        display: block;
    }

    .lesson-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 12px 15px;
        border-bottom: 1px solid var(--gray-light);
        transition: var(--transition);
    }

    .lesson-item:last-child {
        border-bottom: none;
    }

    .lesson-item:hover {
        background: var(--light);
    }

    .lesson-icon {
        width: 30px;
        color: var(--primary);
        font-size: 1rem;
        text-align: center;
    }

    .lesson-info {
        flex: 1;
    }

    .lesson-title {
        font-weight: 500;
        color: var(--dark);
        margin-bottom: 5px;
    }

    .lesson-meta {
        display: flex;
        gap: 15px;
        font-size: 0.85rem;
        color: var(--gray);
    }

    .lesson-meta i {
        margin-right: 5px;
    }

    .lesson-preview {
        color: var(--primary);
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .lesson-preview:hover {
        text-decoration: underline;
    }

    .lesson-locked {
        color: var(--gray);
        font-size: 1rem;
    }

    /* Instructor Tab */
    .instructor-profile {
        display: flex;
        gap: 30px;
        flex-wrap: wrap;
    }

    .instructor-avatar-large {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background: var(--gradient-1);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        font-weight: 600;
        color: var(--white);
        flex-shrink: 0;
    }

    .instructor-details {
        flex: 1;
    }

    .instructor-name {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 5px;
        color: var(--dark);
    }

    .instructor-title {
        font-size: 1.1rem;
        color: var(--primary);
        margin-bottom: 20px;
    }

    .instructor-bio {
        color: var(--gray);
        line-height: 1.8;
        margin-bottom: 25px;
    }

    .instructor-stats {
        display: flex;
        gap: 40px;
        margin-bottom: 25px;
        padding: 20px 0;
        border-top: 1px solid var(--gray-light);
        border-bottom: 1px solid var(--gray-light);
    }

    .stat-item {
        text-align: center;
    }

    .stat-value {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--primary);
        line-height: 1;
        margin-bottom: 5px;
    }

    .stat-label {
        font-size: 0.9rem;
        color: var(--gray);
    }

    .instructor-social {
        display: flex;
        gap: 15px;
    }

    .social-link {
        width: 45px;
        height: 45px;
        background: var(--light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--gray);
        text-decoration: none;
        transition: var(--transition);
        font-size: 1.2rem;
    }

    .social-link:hover {
        background: var(--primary);
        color: var(--white);
        transform: translateY(-3px);
    }

    /* Related Courses */
    .related-courses {
        margin-top: 60px;
    }

    .related-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .related-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--dark);
    }

    .view-all {
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .view-all:hover {
        gap: 10px;
    }

    .related-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 25px;
    }

    .related-course-card {
        background: var(--white);
        border-radius: var(--border-radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        text-decoration: none;
        color: inherit;
    }

    .related-course-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-lg);
    }

    .related-thumbnail {
        aspect-ratio: 16/9;
        overflow: hidden;
    }

    .related-thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition-slow);
    }

    .related-course-card:hover .related-thumbnail img {
        transform: scale(1.1);
    }

    .related-content {
        padding: 20px;
    }

    .related-category {
        font-size: 0.8rem;
        color: var(--primary);
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .related-title {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 10px;
        color: var(--dark);
    }

    .related-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .related-price {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--primary);
    }

    .related-price.free {
        color: var(--success);
    }

    .related-rating {
        color: #ffc107;
        font-size: 0.9rem;
    }

    /* Video Modal */
    .modal {
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

    .modal.show {
        display: flex;
        animation: fadeIn 0.3s ease;
    }

    .modal-content {
        position: relative;
        width: 90%;
        max-width: 900px;
        background: var(--dark);
        border-radius: var(--border-radius-lg);
        overflow: hidden;
    }

    .modal-close {
        position: absolute;
        top: 15px;
        right: 15px;
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.2);
        border: none;
        border-radius: 50%;
        color: var(--white);
        font-size: 1.2rem;
        cursor: pointer;
        transition: var(--transition);
        z-index: 10;
    }

    .modal-close:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: rotate(90deg);
    }

    .video-container {
        position: relative;
        padding-bottom: 56.25%;
        height: 0;
    }

    .video-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .course-sidebar {
            position: static;
            margin-top: 40px;
        }

        .course-content-wrapper {
            padding: 30px;
        }

        .instructor-profile {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .instructor-stats {
            justify-content: center;
        }

        .instructor-social {
            justify-content: center;
        }

        .section-title::after {
            left: 50%;
            transform: translateX(-50%);
        }
    }

    @media (max-width: 768px) {
        .course-hero {
            padding: 40px 0;
        }

        .course-hero-title {
            font-size: 1.8rem;
        }

        .course-meta-list {
            gap: 20px;
        }

        .course-content-wrapper {
            padding: 20px;
        }

        .instructor-stats {
            flex-direction: column;
            gap: 20px;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="course-hero">
    <div class="course-hero-particles">
        <div class="course-hero-particle"></div>
        <div class="course-hero-particle"></div>
        <div class="course-hero-particle"></div>
    </div>

    <div class="container">
        <div class="course-hero-content" data-aos="fade-up">
            <!-- Breadcrumb -->
            <div class="course-breadcrumb">
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
            <div class="course-badge-wrapper">
                @if($course->featured)
                <span class="course-badge featured">Featured</span>
                @endif
                @if($course->price == 0 || ($course->sale_price == 0))
                <span class="course-badge free">Free Course</span>
                @endif
                @if($course->level)
                <span class="course-badge">{{ $course->level }}</span>
                @endif
            </div>

            <!-- Title -->
            <h1 class="course-hero-title">{{ $course->title }}</h1>

            <!-- Description -->
            <p class="course-hero-description">{{ $course->excerpt ?? Str::limit(strip_tags($course->description), 200) }}</p>

            <!-- Meta Info -->
            <div class="course-meta-list">
                <div class="course-meta-item">
                    <div class="meta-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="meta-content">
                        <h4>Students Enrolled</h4>
                        <p>{{ number_format($course->enrollments_count ?? 0) }}+</p>
                    </div>
                </div>

                <div class="course-meta-item">
                    <div class="meta-icon">
                        <i class="far fa-clock"></i>
                    </div>
                    <div class="meta-content">
                        <h4>Duration</h4>
                        <p>{{ $course->duration ?? 'Self-Paced' }}</p>
                    </div>
                </div>

                <div class="course-meta-item">
                    <div class="meta-icon">
                        <i class="fas fa-video"></i>
                    </div>
                    <div class="meta-content">
                        <h4>Lessons</h4>
                        <p>{{ $course->total_lessons ?? 0 }}</p>
                    </div>
                </div>

                <div class="course-meta-item">
                    <div class="meta-icon">
                        <i class="fas fa-signal"></i>
                    </div>
                    <div class="meta-content">
                        <h4>Level</h4>
                        <p>{{ $course->level ?? 'All Levels' }}</p>
                    </div>
                </div>
            </div>

            <!-- Instructor Mini -->
            @if($course->instructor)
            <div class="instructor-mini">
                <div class="instructor-mini-avatar">
                    {{ substr($course->instructor->name ?? 'EA', 0, 1) }}
                </div>
                <div class="instructor-mini-info">
                    <h4>Created by</h4>
                    <p>{{ $course->instructor->name ?? 'EDUCONECX ACADEMY' }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="course-main">
    <div class="container">
        <div class="row">
            <!-- Left Column - Course Content -->
            <div class="col-lg-8">
                <div class="course-content-wrapper" data-aos="fade-right">
                    <!-- Tabs (removed Reviews tab) -->
                    <div class="course-tabs">
                        <button class="tab-btn active" data-tab="overview">Overview</button>
                        <button class="tab-btn" data-tab="curriculum">Curriculum</button>
                        <button class="tab-btn" data-tab="instructor">Instructor</button>
                    </div>

                    <!-- Overview Tab -->
                    <div class="tab-pane active" id="overview">
                        <div class="overview-section">
                            <h2 class="section-title">About This Course</h2>
                            <div class="course-description">
                                {!! $course->description !!}
                            </div>

                            @if($course->what_you_will_learn)
                            <div class="learning-outcomes">
                                <h3>What You'll Learn</h3>
                                <div class="outcomes-grid">
                                    @foreach(explode("\n", $course->what_you_will_learn) as $outcome)
                                    @if(trim($outcome))
                                    <div class="outcome-item">
                                        <div class="outcome-icon">
                                            <i class="fas fa-check"></i>
                                        </div>
                                        <div class="outcome-text">{{ trim($outcome) }}</div>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            @if($course->requirements)
                            <div class="learning-outcomes">
                                <h3>Requirements</h3>
                                <div class="outcomes-grid">
                                    @foreach(explode("\n", $course->requirements) as $requirement)
                                    @if(trim($requirement))
                                    <div class="outcome-item">
                                        <div class="outcome-icon">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        <div class="outcome-text">{{ trim($requirement) }}</div>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Curriculum Tab -->
                    <div class="tab-pane" id="curriculum">
                        <div class="curriculum-section">
                            <div class="curriculum-header">
                                <h2 class="section-title">Course Curriculum</h2>
                                <div class="curriculum-stats">
                                    <span><i class="far fa-file-video"></i> {{ $course->total_lessons ?? 0 }} Lessons</span>
                                    <span><i class="far fa-clock"></i> {{ $course->total_duration ?? 'Self-Paced' }}</span>
                                </div>
                            </div>

                            @if($course->sections && $course->sections->count() > 0)
                            @foreach($course->sections as $sectionIndex => $section)
                            <div class="accordion-item">
                                <div class="accordion-header" data-section="{{ $sectionIndex }}">
                                    <h3>{{ $section->title }}</h3>
                                    <div class="section-meta">
                                        <span>{{ $section->lessons->count() }} lessons</span>
                                        <span>{{ $section->duration ?? '' }}</span>
                                        <i class="fas fa-chevron-down"></i>
                                    </div>
                                </div>
                                <div class="accordion-content" id="section-{{ $sectionIndex }}">
                                    @if($section->lessons && $section->lessons->count() > 0)
                                    @foreach($section->lessons as $lesson)
                                    <div class="lesson-item">
                                        <div class="lesson-icon">
                                            @if($lesson->is_free_preview)
                                            <i class="fas fa-play-circle"></i>
                                            @else
                                            <i class="fas fa-lock"></i>
                                            @endif
                                        </div>
                                        <div class="lesson-info">
                                            <div class="lesson-title">{{ $lesson->title }}</div>
                                            <div class="lesson-meta">
                                                <span><i class="far fa-clock"></i> {{ $lesson->duration ?? 'N/A' }}</span>
                                                @if($lesson->is_free_preview)
                                                <span class="text-success"><i class="fas fa-unlock-alt"></i> Free Preview</span>
                                                @endif
                                            </div>
                                        </div>
                                        @if($lesson->is_free_preview)
                                        <a href="#" class="lesson-preview" data-video="{{ $lesson->video_url ?? '' }}">
                                            Preview <i class="fas fa-arrow-right"></i>
                                        </a>
                                        @else
                                        <div class="lesson-locked">
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
                    <div class="tab-pane" id="instructor">
                        @if($course->instructor)
                        <div class="instructor-profile">
                            <div class="instructor-avatar-large">
                                {{ substr($course->instructor->name, 0, 1) }}
                            </div>
                            <div class="instructor-details">
                                <h2 class="instructor-name">{{ $course->instructor->name }}</h2>
                                <p class="instructor-title">{{ $course->instructor->title ?? 'Expert Instructor' }}</p>
                                <div class="instructor-bio">
                                    {{ $course->instructor->bio ?? 'Experienced professional dedicated to helping students achieve their learning goals.' }}
                                </div>
                                <div class="instructor-stats">
                                    <div class="stat-item">
                                        <div class="stat-value">{{ $course->instructor->courses_count ?? 0 }}</div>
                                        <div class="stat-label">Courses</div>
                                    </div>
                                    <div class="stat-item">
                                        <div class="stat-value">{{ $course->instructor->students_count ?? 0 }}</div>
                                        <div class="stat-label">Students</div>
                                    </div>
                                </div>
                                <div class="instructor-social">
                                    @if($course->instructor->twitter)
                                    <a href="{{ $course->instructor->twitter }}" class="social-link" target="_blank">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    @endif
                                    @if($course->instructor->linkedin)
                                    <a href="{{ $course->instructor->linkedin }}" class="social-link" target="_blank">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                    @endif
                                    @if($course->instructor->website)
                                    <a href="{{ $course->instructor->website }}" class="social-link" target="_blank">
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
                @if($relatedCourses->count() > 0)
                <div class="related-courses" data-aos="fade-up">
                    <div class="related-header">
                        <h2 class="related-title">Related Courses</h2>
                        <a href="{{ route('courses') }}" class="view-all">
                            View All <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    <div class="related-grid">
                        @foreach($relatedCourses as $relatedCourse)
                        <a href="{{ route('courses.show', $relatedCourse->slug) }}" class="related-course-card">
                            <div class="related-thumbnail">
                                <img src="{{ $relatedCourse->thumbnail_url }}" alt="{{ $relatedCourse->title }}">
                            </div>
                            <div class="related-content">
                                <div class="related-category">{{ $relatedCourse->category->name ?? 'General' }}</div>
                                <h3 class="related-title">{{ $relatedCourse->title }}</h3>
                                <div class="related-meta">
                                    <span class="related-price {{ $relatedCourse->price == 0 ? 'free' : '' }}">
                                        @if($relatedCourse->sale_price && $relatedCourse->sale_price < $relatedCourse->price)
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
                <div class="course-sidebar" data-aos="fade-left">
                    <!-- Course Card -->
                    <div class="course-card">
                        <div class="course-thumbnail">
                            <img src="{{ $course->thumbnail_url }}" alt="{{ $course->title }}">
                            @if($course->video_intro)
                            <button class="course-preview-btn" id="previewVideo">
                                <i class="fas fa-play"></i>
                            </button>
                            @endif
                        </div>

                        <div class="course-price-box">
                            <div class="course-price {{ $course->price == 0 ? 'free' : '' }}">
                                @if($course->sale_price && $course->sale_price < $course->price)
                                    ${{ number_format($course->sale_price, 2) }}
                                    <small>${{ number_format($course->price, 2) }}</small>
                                    @elseif($course->price > 0)
                                    ${{ number_format($course->price, 2) }}
                                    @else
                                    Free
                                    @endif
                            </div>
                            <span class="price-label">one-time payment, lifetime access</span>
                        </div>

                        <div class="course-actions">
                            @auth
                            @if($course->is_enrolled)
                            <a href="{{ route('courses.learning', $course->slug) }}" class="btn-enroll" id="continueLearningBtn">
                                <i class="fas fa-play-circle"></i>
                                Continue Learning ({{ $course->user_progress }}%)
                            </a>
                            @else
                            <button class="btn-enroll" id="enrollBtn" data-course-id="{{ $course->id }}">
                                <i class="fas fa-graduation-cap"></i>
                                Enroll Now
                            </button>
                            @endif
                            @else
                            <a href="{{ route('login') }}?redirect={{ url()->current() }}" class="btn-enroll">
                                <i class="fas fa-sign-in-alt"></i>
                                Login to Enroll
                            </a>
                            @endauth

                            <button class="btn-wishlist" id="wishlistBtn">
                                <i class="far fa-heart"></i>
                                Add to Wishlist
                            </button>
                        </div>

                        <div class="course-includes">
                            <h4>This course includes:</h4>
                            <ul class="includes-list">
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
<div class="modal" id="videoModal">
    <div class="modal-content">
        <button class="modal-close" id="closeModal">&times;</button>
        <div class="video-container" id="videoContainer">
            <!-- Video will be inserted here -->
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ========== TAB SWITCHING ==========
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabPanes = document.querySelectorAll('.tab-pane');

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
    const accordionHeaders = document.querySelectorAll('.accordion-header');

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

            // Example: If you have a YouTube video URL
            const videoUrl = this.dataset.video || '{{ $course->video_intro_url ?? "" }}';
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

                        // Change button to continue learning
                        setTimeout(() => {
                            window.location.href = data.redirect_url;
                        }, 1500);
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
        // Check if course is already in wishlist (you'll need to implement this check)
        @auth
            // You can add an initial check here
            // For example, if the course is in wishlist, add 'active' class
        @endauth

        wishlistBtn.addEventListener('click', function(e) {
            e.preventDefault();

            @auth
                // Check if user is enrolled (can't wishlist enrolled courses)
                @if(isset($course) && $course->is_enrolled)
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
    const previewLinks = document.querySelectorAll('.lesson-preview');

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

    // ========== SHARE COURSE FUNCTIONALITY ==========
    const shareBtn = document.getElementById('shareCourseBtn');
    if (shareBtn) {
        shareBtn.addEventListener('click', function() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ $course->title }}',
                    text: '{{ $course->excerpt ?? "Check out this course on EDUCONECX" }}',
                    url: window.location.href
                })
                .catch(console.error);
            } else {
                // Fallback - copy to clipboard
                navigator.clipboard.writeText(window.location.href)
                    .then(() => showNotification('Course link copied to clipboard!', 'success'))
                    .catch(() => showNotification('Could not copy link', 'error'));
            }
        });
    }

    // ========== NOTIFICATION SYSTEM ==========
    function showNotification(message, type = 'success') {
        // Remove any existing notifications
        const existingNotifications = document.querySelectorAll('.notification');
        existingNotifications.forEach(notification => notification.remove());

        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;

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
            animation: slideIn 0.3s ease;
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
            notification.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 3000);
    }

    // ========== LOADING STATES ==========
    function showLoading(button) {
        if (button) {
            button.dataset.originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
            button.disabled = true;
        }
    }

    function hideLoading(button) {
        if (button && button.dataset.originalText) {
            button.innerHTML = button.dataset.originalText;
            button.disabled = false;
        }
    }

    // ========== ADD TO CART FUNCTIONALITY (Optional) ==========
    const addToCartBtn = document.getElementById('addToCartBtn');
    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', function(e) {
            e.preventDefault();

            @auth
                @if(isset($course) && !$course->is_enrolled)
                    const courseId = this.dataset.courseId;
                    showLoading(this);

                    fetch(`/cart/add/${courseId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        hideLoading(this);
                        if (data.success) {
                            showNotification('Course added to cart!', 'success');
                            // Update cart count in header
                            const cartCount = document.querySelector('.cart-count');
                            if (cartCount) {
                                cartCount.textContent = data.cartCount;
                            }
                        } else {
                            showNotification(data.message || 'Error adding to cart', 'error');
                        }
                    })
                    .catch(error => {
                        hideLoading(this);
                        showNotification('Error adding to cart', 'error');
                    });
                @elseif(isset($course) && $course->is_enrolled)
                    showNotification('You are already enrolled in this course!', 'info');
                @endif
            @else
                window.location.href = '{{ route("login") }}?redirect={{ url()->current() }}';
            @endauth
        });
    }

    // ========== SCROLL TO SECTION ==========
    const scrollLinks = document.querySelectorAll('a[href^="#"]');
    scrollLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;

            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // ========== ADD ANIMATION STYLES ==========
    const style = document.createElement('style');
    style.textContent = `
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

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .btn-enroll:disabled,
        .btn-wishlist:disabled,
        .add-to-cart:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .notification {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.95rem;
        }

        .notification i {
            font-size: 1.2rem;
        }
    `;
    document.head.appendChild(style);

    // ========== TRACK USER INTERACTION (Optional) ==========
    // Track when user views the course
    if (typeof gtag !== 'undefined') {
        gtag('event', 'view_item', {
            currency: 'USD',
            value: {{ $course->price ?? 0 }},
            items: [{
                item_id: '{{ $course->id }}',
                item_name: '{{ $course->title }}',
                item_category: '{{ $course->category->name ?? "General" }}',
                price: {{ $course->price ?? 0 }}
            }]
        });
    }

    console.log('Course page JavaScript initialized successfully');
});
</script>
@endpush