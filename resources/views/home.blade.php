@extends('layouts.main')

@section('title', 'Empower Your Learning Journey Today - EDUCONECX')

@section('meta_description', 'EDUCONECX is an international AI-powered educational platform that empowers learners worldwide with practical language and digital business skills.')

@push('styles')
<style>
    /* Hero Section */
    .hero {
        position: relative;
        min-height: 90vh;
        display: flex;
        align-items: center;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        overflow: hidden;
    }

    .hero-particles {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    .hero-particle {
        position: absolute;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        pointer-events: none;
    }

    .hero-particle:nth-child(1) {
        width: 300px;
        height: 300px;
        top: -100px;
        right: -100px;
        animation: float 8s ease-in-out infinite;
    }

    .hero-particle:nth-child(2) {
        width: 200px;
        height: 200px;
        bottom: -50px;
        left: -50px;
        animation: float 10s ease-in-out infinite reverse;
    }

    .hero-particle:nth-child(3) {
        width: 150px;
        height: 150px;
        top: 50%;
        left: 20%;
        animation: float 12s ease-in-out infinite;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        color: var(--white);
        text-align: center;
        max-width: 900px;
        margin: 0 auto;
        padding: 80px 0;
    }

    .hero-badge {
        display: inline-block;
        padding: 8px 20px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: var(--border-radius-full);
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 30px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .hero-title {
        font-size: clamp(2.5rem, 8vw, 4.5rem);
        font-weight: 800;
        line-height: 1.1;
        margin-bottom: 20px;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
    }

    .hero-title span {
        display: block;
        font-size: clamp(1.5rem, 5vw, 2.5rem);
        font-weight: 400;
        opacity: 0.9;
    }

    .hero-text {
        font-size: clamp(1.1rem, 3vw, 1.5rem);
        margin-bottom: 40px;
        opacity: 0.9;
        max-width: 700px;
        margin-left: auto;
        margin-right: auto;
    }

    .hero-buttons {
        display: flex;
        gap: 20px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .hero-buttons .btn {
        min-width: 200px;
    }

    .hero-buttons .btn-secondary {
        border-color: var(--white);
        color: var(--white);
    }

    .hero-buttons .btn-secondary:hover {
        background: var(--white);
        color: var(--primary);
    }

    .hero-stats {
        display: flex;
        justify-content: center;
        gap: 60px;
        margin-top: 60px;
        flex-wrap: wrap;
    }

    .stat-item {
        text-align: center;
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 5px;
        background: linear-gradient(135deg, #fff, #f0f0f0);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .stat-label {
        font-size: 1rem;
        opacity: 0.8;
    }

    /* Features Section */
    .features-section {
        padding: 80px 0;
        background: var(--white);
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 30px;
        margin-top: 50px;
    }

    .feature-card {
        background: var(--white);
        padding: 40px 30px;
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .feature-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        background: var(--gradient-1);
        transform: translateX(-100%);
        transition: var(--transition);
    }

    .feature-card:hover::before {
        transform: translateX(0);
    }

    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-lg);
    }

    .feature-icon {
        width: 80px;
        height: 80px;
        background: var(--gradient-1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px;
        color: var(--white);
        font-size: 2rem;
        transition: var(--transition);
    }

    .feature-card:hover .feature-icon {
        transform: rotateY(180deg);
    }

    .feature-title {
        font-size: 1.3rem;
        margin-bottom: 15px;
    }

    .feature-text {
        color: var(--gray);
        line-height: 1.6;
    }

    /* Courses Section */
    .courses-section {
        padding: 80px 0;
        background: var(--light);
    }

    .section-header {
        text-align: center;
        margin-bottom: 50px;
    }

    .section-subtitle {
        color: var(--primary);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 0.9rem;
        margin-bottom: 10px;
    }

    .course-card {
        background: var(--white);
        border-radius: var(--border-radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        height: 100%;
    }

    .course-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-lg);
    }

    .course-image {
        position: relative;
        overflow: hidden;
        aspect-ratio: 16/9;
    }

    .course-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition-slow);
    }

    .course-card:hover .course-image img {
        transform: scale(1.1);
    }

    .course-category {
        position: absolute;
        top: 15px;
        right: 15px;
        padding: 5px 15px;
        background: var(--gradient-1);
        color: var(--white);
        border-radius: var(--border-radius-full);
        font-size: 0.8rem;
        font-weight: 600;
        z-index: 1;
    }

    .course-content {
        padding: 25px;
    }

    .course-meta {
        display: flex;
        gap: 15px;
        margin-bottom: 15px;
        color: var(--gray);
        font-size: 0.9rem;
    }

    .course-meta i {
        color: var(--primary);
        margin-right: 5px;
    }

    .course-title {
        font-size: 1.2rem;
        margin-bottom: 15px;
        line-height: 1.4;
    }

    .course-title a {
        color: var(--dark);
    }

    .course-title a:hover {
        color: var(--primary);
    }

    .course-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid var(--gray-light);
    }

    .course-price {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary);
    }

    .course-price small {
        font-size: 0.9rem;
        font-weight: 400;
        color: var(--gray);
        text-decoration: line-through;
        margin-left: 5px;
    }

    .course-btn {
        padding: 8px 20px;
        background: var(--gradient-1);
        color: var(--white);
        border-radius: var(--border-radius-full);
        font-size: 0.9rem;
        font-weight: 600;
        transition: var(--transition);
    }

    .course-btn:hover {
        transform: translateX(5px);
        box-shadow: var(--shadow-md);
    }

    /* Stats Section */
    .stats-section {
        padding: 60px 0;
        background: var(--gradient-1);
        color: var(--white);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 40px;
        text-align: center;
    }

    .stats-item {
        padding: 20px;
    }

    .stats-icon {
        font-size: 2.5rem;
        margin-bottom: 15px;
        opacity: 0.9;
    }

    .stats-number {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 5px;
    }

    .stats-label {
        font-size: 1rem;
        opacity: 0.9;
    }

    /* Testimonials Section */
    .testimonials-section {
        padding: 80px 0;
        background: var(--white);
    }

    .testimonials-slider {
        position: relative;
        max-width: 900px;
        margin: 50px auto 0;
    }

    .testimonial-card {
        background: var(--white);
        padding: 40px;
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-lg);
        margin: 20px;
        position: relative;
    }

    .testimonial-card::before {
        content: '\201C';
        position: absolute;
        top: 20px;
        left: 30px;
        font-size: 6rem;
        color: var(--primary);
        opacity: 0.2;
        font-family: serif;
    }

    .testimonial-rating {
        color: #ffc107;
        font-size: 1.2rem;
        margin-bottom: 20px;
    }

    .testimonial-text {
        font-size: 1.1rem;
        line-height: 1.8;
        margin-bottom: 25px;
        font-style: italic;
    }

    .testimonial-author {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .author-image {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        overflow: hidden;
        border: 3px solid var(--primary);
    }

    .author-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .author-info h4 {
        font-size: 1.1rem;
        margin-bottom: 5px;
    }

    .author-info p {
        color: var(--gray);
        font-size: 0.9rem;
    }

    .slider-dots {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 40px;
    }

    .dot {
        width: 12px;
        height: 12px;
        background: var(--gray-light);
        border-radius: 50%;
        cursor: pointer;
        transition: var(--transition);
    }

    .dot.active {
        background: var(--primary);
        transform: scale(1.2);
    }

    /* CTA Section */
    .cta-section {
        padding: 80px 0;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: var(--white);
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .cta-content {
        position: relative;
        z-index: 2;
        max-width: 700px;
        margin: 0 auto;
    }

    .cta-title {
        font-size: clamp(2rem, 5vw, 3rem);
        margin-bottom: 20px;
    }

    .cta-text {
        font-size: 1.2rem;
        margin-bottom: 30px;
        opacity: 0.9;
    }

    .cta-buttons {
        display: flex;
        gap: 20px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .cta-buttons .btn {
        min-width: 200px;
    }

    .cta-buttons .btn-secondary {
        border-color: var(--white);
        color: var(--white);
    }

    .cta-buttons .btn-secondary:hover {
        background: var(--white);
        color: var(--primary);
    }

    .cta-particles {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    .cta-particle {
        position: absolute;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .cta-particle:nth-child(1) {
        width: 200px;
        height: 200px;
        top: -50px;
        right: -50px;
        animation: float 8s ease-in-out infinite;
    }

    .cta-particle:nth-child(2) {
        width: 150px;
        height: 150px;
        bottom: -50px;
        left: -50px;
        animation: float 10s ease-in-out infinite reverse;
    }

    /* FAQ Section */
    .faq-section {
        padding: 80px 0;
        background: var(--light);
    }

    .faq-grid {
        max-width: 800px;
        margin: 50px auto 0;
    }

    .faq-item {
        background: var(--white);
        border-radius: var(--border-radius-lg);
        margin-bottom: 20px;
        box-shadow: var(--shadow-sm);
        overflow: hidden;
    }

    .faq-question {
        padding: 20px 25px;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 600;
        transition: var(--transition);
    }

    .faq-question:hover {
        background: rgba(67, 97, 238, 0.05);
    }

    .faq-question i {
        transition: var(--transition);
        color: var(--primary);
    }

    .faq-item.active .faq-question i {
        transform: rotate(180deg);
    }

    .faq-answer {
        padding: 0 25px 20px;
        display: none;
        color: var(--gray);
        line-height: 1.8;
    }

    .faq-item.active .faq-answer {
        display: block;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .hero-stats {
            gap: 30px;
        }

        .stat-number {
            font-size: 2rem;
        }

        .testimonial-card {
            padding: 30px 20px;
        }

        .testimonial-text {
            font-size: 1rem;
        }

        .cta-buttons .btn {
            min-width: 150px;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero">
    <div class="hero-particles">
        <div class="hero-particle"></div>
        <div class="hero-particle"></div>
        <div class="hero-particle"></div>
    </div>

    <div class="container">
        <div class="hero-content" data-aos="fade-up">
            <span class="hero-badge">Welcome to EDUCONECX</span>
            <h1 class="hero-title">
                Empower Your Learning
                <span>Journey Today</span>
            </h1>
            <p class="hero-text">
                Join thousands of learners worldwide and master practical language
                and digital business skills with our AI-powered platform.
            </p>
            <div class="hero-buttons">
                <a href="{{ route('academy') }}" class="btn btn-primary">
                    <i class="fas fa-graduation-cap"></i> Join Academy
                </a>
                <!-- <a href="{{ route('neo-ed-tech') }}" class="btn btn-secondary">
                    <i class="fas fa-robot"></i> Explore NEO ED-TECH
                </a> -->
            </div>
            <div class="hero-stats">
                <div class="stat-item">
                    <div class="stat-number">127+</div>
                    <div class="stat-label">Reviews on Capterra</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">4.9</div>
                    <div class="stat-label">Average Rating</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">1000+</div>
                    <div class="stat-label">Students Worldwide</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-subtitle">Why Choose Us</span>
            <h2 class="section-title">Learning Experience Like Never Before</h2>
        </div>
        <div class="features-grid">
            <div class="feature-card" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-icon">
                    <i class="fas fa-brain"></i>
                </div>
                <h3 class="feature-title">AI-Powered Learning</h3>
                <p class="feature-text">Personalized learning paths powered by advanced AI technology adapt to your pace and style.</p>
            </div>
            <div class="feature-card" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-icon">
                    <i class="fas fa-language"></i>
                </div>
                <h3 class="feature-title">Multiple Languages</h3>
                <p class="feature-text">Courses available in English, French, Haitian Creole, and Spanish for global accessibility.</p>
            </div>
            <div class="feature-card" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3 class="feature-title">Practical Skills</h3>
                <p class="feature-text">Learn real-world skills that you can apply immediately in your career or business.</p>
            </div>
            <div class="feature-card" data-aos="fade-up" data-aos-delay="400">
                <div class="feature-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3 class="feature-title">Expert Instructors</h3>
                <p class="feature-text">Learn from industry experts with years of practical experience in their fields.</p>
            </div>
        </div>
    </div>
</section>

<!-- Offer Banner -->
<section class="offer-banner" data-aos="fade-up">
    <div class="container">
        <div class="offer-content">
            <i class="fas fa-gift"></i>
            <h3>Limited Time Offer</h3>
            <p>Unlimited Access To All Courses – Only $22</p>
            <a href="#" class="btn btn-primary">Get Started Now</a>
        </div>
    </div>
</section>

<style>
    .offer-banner {
        background: var(--gradient-2);
        padding: 40px 0;
        color: var(--white);
        text-align: center;
    }

    .offer-content {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 30px;
        flex-wrap: wrap;
    }

    .offer-content i {
        font-size: 3rem;
        animation: pulse 2s ease-in-out infinite;
    }

    .offer-content h3 {
        font-size: 1.8rem;
        font-weight: 700;
    }

    .offer-content p {
        font-size: 1.3rem;
        font-weight: 600;
    }

    .offer-content .btn {
        background: var(--white);
        color: var(--primary);
    }

    .offer-content .btn:hover {
        background: transparent;
        color: var(--white);
        border-color: var(--white);
    }

    @media (max-width: 768px) {
        .offer-content {
            flex-direction: column;
            gap: 15px;
        }

        .offer-content h3 {
            font-size: 1.5rem;
        }

        .offer-content p {
            font-size: 1.1rem;
        }
    }
</style>

<!-- Courses Section -->
<section class="courses-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-subtitle">Our Courses</span>
            <h2 class="section-title">Featured Learning Paths</h2>
        </div>
        <div class="grid grid-3">
            @forelse($featuredCourses as $course)
            <!-- Course Card -->
            <div class="course-card" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                <div class="course-image">
                    <img src="{{ $course->thumbnail_url }}" alt="{{ $course->title }}">
                    <span class="course-category">{{ $course->category->name ?? 'General' }}</span>
                    @if($course->hasDiscount)
                    <span class="course-discount-badge">-{{ $course->discount_percentage }}%</span>
                    @endif
                </div>
                <div class="course-content">
                    <div class="course-meta">
                        <span><i class="far fa-clock"></i> {{ $course->duration }} Hours</span>
                        <span><i class="fas fa-signal"></i> {{ $course->level }}</span>
                        <span><i class="fas fa-language"></i> {{ $course->language }}</span>
                    </div>
                    <h3 class="course-title">
                        <a href="{{ route('courses.show', $course->slug) }}">{{ $course->title }}</a>
                    </h3>
                    <p>{{ $course->excerpt }}</p>

                    @if($course->total_students > 0)
                    <div class="course-stats">
                        <span><i class="fas fa-users"></i> {{ number_format($course->total_students) }} students</span>
                        @if($course->average_rating > 0)
                        <span>
                            <i class="fas fa-star text-warning"></i>
                            {{ number_format($course->average_rating, 1) }} ({{ $course->total_reviews }})
                        </span>
                        @endif
                    </div>
                    @endif

                    <div class="course-footer">
                        <div class="course-price">
                            @if($course->hasDiscount)
                            ${{ number_format($course->sale_price, 2) }}
                            <small>${{ number_format($course->price, 2) }}</small>
                            @elseif($course->price > 0)
                            ${{ number_format($course->price, 2) }}
                            @else
                            Free
                            @endif
                        </div>
                        <a href="{{ route('courses.show', $course->slug) }}" class="course-btn">
                            {{ $course->price > 0 ? 'Enroll Now' : 'Start Learning' }}
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center">
                <p>No featured courses available at the moment.</p>
            </div>
            @endforelse
        </div>
        <div style="text-align: center; margin-top: 50px;">
            <a href="{{ route('courses') }}" class="btn btn-primary">
                View All Courses <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="container">
        <div class="stats-grid">
            <div class="stats-item" data-aos="zoom-in" data-aos-delay="100">
                <div class="stats-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stats-number">10,000+</div>
                <div class="stats-label">Students Enrolled</div>
            </div>
            <div class="stats-item" data-aos="zoom-in" data-aos-delay="200">
                <div class="stats-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <div class="stats-number">50+</div>
                <div class="stats-label">Expert Instructors</div>
            </div>
            <div class="stats-item" data-aos="zoom-in" data-aos-delay="300">
                <div class="stats-icon">
                    <i class="fas fa-globe"></i>
                </div>
                <div class="stats-number">15+</div>
                <div class="stats-label">Countries</div>
            </div>
            <div class="stats-item" data-aos="zoom-in" data-aos-delay="400">
                <div class="stats-icon">
                    <i class="fas fa-award"></i>
                </div>
                <div class="stats-number">4.9</div>
                <div class="stats-label">Average Rating</div>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="about-section">
    <div class="container">
        <div class="about-grid">
            <div class="about-content" data-aos="fade-right">
                <span class="section-subtitle">About Us</span>
                <h2 class="section-title">Empowering learners, connecting futures</h2>
                <p><strong>EDUCONECX</strong> is an international AI-powered educational platform that empowers learners worldwide with practical language and digital business skills.</p>
                <p>Our mission is to help individuals break through language barriers and thrive in today's global digital economy. We combine cutting-edge technology with expert instruction to create an unparalleled learning experience.</p>
                <div class="about-features">
                    <div class="about-feature">
                        <i class="fas fa-check-circle"></i>
                        <span>AI-Powered Learning Paths</span>
                    </div>
                    <div class="about-feature">
                        <i class="fas fa-check-circle"></i>
                        <span>Multi-Language Support</span>
                    </div>
                    <div class="about-feature">
                        <i class="fas fa-check-circle"></i>
                        <span>Practical Skills Focus</span>
                    </div>
                    <div class="about-feature">
                        <i class="fas fa-check-circle"></i>
                        <span>Expert Instructors</span>
                    </div>
                </div>
                <a href="{{ route('about') }}" class="btn btn-primary">
                    Learn More About Us <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="about-image" data-aos="fade-left">
                <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="About EDUCONECX">
                <div class="experience-badge">
                    <span class="years">5+</span>
                    <span class="text">Years of Excellence</span>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .about-section {
        padding: 80px 0;
        background: var(--white);
    }

    .about-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: center;
    }

    .about-content p {
        margin-bottom: 20px;
        color: var(--gray);
        line-height: 1.8;
    }

    .about-features {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
        margin: 30px 0;
    }

    .about-feature {
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--dark);
    }

    .about-feature i {
        color: var(--success);
        font-size: 1.1rem;
    }

    .about-image {
        position: relative;
        border-radius: var(--border-radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-lg);
    }

    .about-image img {
        width: 100%;
        height: auto;
        display: block;
        transition: var(--transition-slow);
    }

    .about-image:hover img {
        transform: scale(1.05);
    }

    .experience-badge {
        position: absolute;
        bottom: 30px;
        right: 30px;
        background: var(--gradient-1);
        color: var(--white);
        padding: 20px;
        border-radius: var(--border-radius-lg);
        text-align: center;
        box-shadow: var(--shadow-lg);
        animation: float 6s ease-in-out infinite;
    }

    .experience-badge .years {
        display: block;
        font-size: 2rem;
        font-weight: 800;
        line-height: 1;
    }

    .experience-badge .text {
        font-size: 0.9rem;
        opacity: 0.9;
    }

    @media (max-width: 768px) {
        .about-grid {
            grid-template-columns: 1fr;
            gap: 40px;
        }

        .about-features {
            grid-template-columns: 1fr;
        }

        .experience-badge {
            bottom: 20px;
            right: 20px;
            padding: 15px;
        }

        .experience-badge .years {
            font-size: 1.5rem;
        }
    }
</style>

<!-- Testimonials Section -->
<section class="testimonials-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-subtitle">Testimonials</span>
            <h2 class="section-title">What Our Students Say</h2>
        </div>

        <div class="testimonials-slider">
            <div class="testimonial-card active" data-aos="fade-up">
                <div class="testimonial-rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="testimonial-text">
                    "The Academy made learning so easy! Courses are practical and well-structured.
                    I was able to learn at my own pace even with slow internet. The AI companion
                    kept me motivated throughout my journey."
                </p>
                <div class="testimonial-author">
                    <div class="author-image">
                        <img src="https://images.unsplash.com/photo-1494790108777-78fdb682e5c7?ixlib=rb-1.2.1&auto=format&fit=crop&w=200&q=80" alt="Sarah M.">
                    </div>
                    <div class="author-info">
                        <h4>Sarah M.</h4>
                        <p>Business Student</p>
                    </div>
                </div>
            </div>

            <div class="testimonial-card" data-aos="fade-up" data-aos-delay="100">
                <div class="testimonial-rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="testimonial-text">
                    "Their guidance is a game-changer. The daily insights and AI companion keep me
                    motivated and focused. It feels personal and uplifting. I've learned more in 3
                    months than in years of traditional learning."
                </p>
                <div class="testimonial-author">
                    <div class="author-image">
                        <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&auto=format&fit=crop&w=200&q=80" alt="Daniel K.">
                    </div>
                    <div class="author-info">
                        <h4>Daniel K.</h4>
                        <p>Graduate Student</p>
                    </div>
                </div>
            </div>

            <div class="testimonial-card" data-aos="fade-up" data-aos-delay="200">
                <div class="testimonial-rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="testimonial-text">
                    "One platform for everything I need. Instead of jumping between sites, I can
                    access courses, guidance, and digital services all in one place. The community
                    support is incredible!"
                </p>
                <div class="testimonial-author">
                    <div class="author-image">
                        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-1.2.1&auto=format&fit=crop&w=200&q=80" alt="Aisha R.">
                    </div>
                    <div class="author-info">
                        <h4>Aisha R.</h4>
                        <p>Entrepreneur</p>
                    </div>
                </div>
            </div>

            <div class="slider-dots">
                <span class="dot active"></span>
                <span class="dot"></span>
                <span class="dot"></span>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="cta-particles">
        <div class="cta-particle"></div>
        <div class="cta-particle"></div>
    </div>

    <div class="container">
        <div class="cta-content" data-aos="zoom-in">
            <h2 class="cta-title">Ready to Start Your Learning Journey?</h2>
            <p class="cta-text">
                Join thousands of students worldwide and transform your skills with our AI-powered platform.
            </p>
            <div class="cta-buttons">
                <a href="{{ route('academy') }}" class="btn btn-primary">
                    <i class="fas fa-graduation-cap"></i> Get Started Free
                </a>
                <a href="{{ route('contact') }}" class="btn btn-secondary">
                    <i class="fas fa-headset"></i> Talk to Advisor
                </a>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="faq-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-subtitle">FAQ</span>
            <h2 class="section-title">Frequently Asked Questions</h2>
        </div>

        <div class="faq-grid">
            <!-- FAQ Item 1 -->
            <div class="faq-item" data-aos="fade-up">
                <div class="faq-question">
                    <span>What is EDUCONECX?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>EDUCONECX is an innovative online educational platform that combines AI-powered learning with specialized training programs. We offer both free and premium educational content designed to accelerate your professional development in language skills and digital business.</p>
                </div>
            </div>

            <!-- FAQ Item 2 -->
            <div class="faq-item" data-aos="fade-up" data-aos-delay="100">
                <div class="faq-question">
                    <span>In which languages are the courses available?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Our courses are available in English, French, Haitian Creole, and Spanish to serve our diverse international community of learners. We're constantly working to add more languages to make education accessible to everyone.</p>
                </div>
            </div>

            <!-- FAQ Item 3 -->
            <div class="faq-item" data-aos="fade-up" data-aos-delay="200">
                <div class="faq-question">
                    <span>How do I get started?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Getting started is simple: create your account, select your preferred course, and begin with our 3-day free trial to explore the platform risk-free. No credit card required for the trial period.</p>
                </div>
            </div>

            <!-- FAQ Item 4 -->
            <div class="faq-item" data-aos="fade-up" data-aos-delay="300">
                <div class="faq-question">
                    <span>Can I access courses on mobile?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Yes! Our platform is fully responsive and optimized for all devices. You can access your courses on desktop, tablet, or smartphone anytime, anywhere. We're also developing dedicated mobile apps for an even better experience.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ JavaScript -->
@push('scripts')
<script>
    // FAQ Accordion
    document.querySelectorAll('.faq-question').forEach(question => {
        question.addEventListener('click', () => {
            const faqItem = question.parentElement;
            faqItem.classList.toggle('active');

            const icon = question.querySelector('i');
            if (faqItem.classList.contains('active')) {
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
            } else {
                icon.classList.remove('fa-chevron-up');
                icon.classList.add('fa-chevron-down');
            }
        });
    });

    // Testimonial Slider
    const testimonials = document.querySelectorAll('.testimonial-card');
    const dots = document.querySelectorAll('.dot');
    let currentSlide = 0;

    function showSlide(index) {
        testimonials.forEach((testimonial, i) => {
            testimonial.style.display = i === index ? 'block' : 'none';
        });

        dots.forEach((dot, i) => {
            dot.classList.toggle('active', i === index);
        });
    }

    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            currentSlide = index;
            showSlide(currentSlide);
        });
    });

    // Auto-rotate testimonials
    setInterval(() => {
        currentSlide = (currentSlide + 1) % testimonials.length;
        showSlide(currentSlide);
    }, 5000);

    // Initialize
    showSlide(0);
</script>
@endpush
@endsection