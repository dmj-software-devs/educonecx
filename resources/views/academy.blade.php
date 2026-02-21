@extends('layouts.main')

@section('title', 'EDUCONECX Academy - Practical Online Courses for Digital Success')

@section('meta_description', 'Join EDUCONECX Academy for practical online courses in English, finance, business, and technology. Learn practical skills with AI-powered guidance and expert instruction.')

@push('styles')
<style>
    /* Hero Section */
    .academy-hero {
        position: relative;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 120px 0;
        overflow: hidden;
        color: var(--white);
    }

    .academy-hero-particles {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    .academy-hero-particle {
        position: absolute;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .academy-hero-particle:nth-child(1) {
        width: 400px;
        height: 400px;
        top: -200px;
        right: -100px;
        animation: float 10s ease-in-out infinite;
    }

    .academy-hero-particle:nth-child(2) {
        width: 300px;
        height: 300px;
        bottom: -150px;
        left: -100px;
        animation: float 12s ease-in-out infinite reverse;
    }

    .academy-hero-particle:nth-child(3) {
        width: 200px;
        height: 200px;
        top: 30%;
        left: 20%;
        animation: float 8s ease-in-out infinite;
    }

    .academy-hero-particle:nth-child(4) {
        width: 150px;
        height: 150px;
        bottom: 20%;
        right: 15%;
        animation: float 9s ease-in-out infinite reverse;
    }

    .academy-hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
        max-width: 900px;
        margin: 0 auto;
    }

    .academy-hero-badge {
        display: inline-block;
        padding: 8px 20px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: var(--border-radius-full);
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 25px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        animation: fadeInDown 1s ease-out;
    }

    .academy-hero-title {
        font-size: clamp(2.5rem, 8vw, 4rem);
        font-weight: 800;
        margin-bottom: 20px;
        line-height: 1.1;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        animation: fadeInUp 1s ease-out 0.2s both;
    }

    .academy-hero-text {
        font-size: clamp(1.1rem, 3vw, 1.3rem);
        opacity: 0.9;
        line-height: 1.8;
        max-width: 700px;
        margin: 0 auto 40px;
        animation: fadeInUp 1s ease-out 0.4s both;
    }

    .academy-hero-stats {
        display: flex;
        justify-content: center;
        gap: 60px;
        flex-wrap: wrap;
        animation: fadeInUp 1s ease-out 0.6s both;
    }

    .hero-stat-item {
        text-align: center;
    }

    .hero-stat-number {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 5px;
        background: linear-gradient(135deg, #fff, #f0f0f0);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .hero-stat-label {
        font-size: 0.95rem;
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
        border: 1px solid var(--gray-light);
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
        border-color: transparent;
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
        background: var(--gradient-2);
    }

    .feature-title {
        font-size: 1.3rem;
        margin-bottom: 15px;
        font-weight: 700;
    }

    .feature-text {
        color: var(--gray);
        line-height: 1.6;
    }

    /* Categories Section */
    .categories-section {
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
        display: block;
    }

    .section-title {
        font-size: clamp(2rem, 5vw, 2.5rem);
        font-weight: 800;
        margin-bottom: 15px;
    }

    .section-description {
        color: var(--gray);
        max-width: 700px;
        margin: 0 auto;
        font-size: 1.1rem;
        line-height: 1.8;
    }

    .category-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 30px;
        margin-top: 50px;
    }

    .category-card {
        background: var(--white);
        border-radius: var(--border-radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        height: 100%;
        position: relative;
    }

    .category-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-lg);
    }

    .category-image {
        position: relative;
        overflow: hidden;
        aspect-ratio: 16/9;
    }

    .category-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition-slow);
    }

    .category-card:hover .category-image img {
        transform: scale(1.1);
    }

    .category-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom, transparent 0%, rgba(0, 0, 0, 0.7) 100%);
        opacity: 0;
        transition: var(--transition);
        display: flex;
        align-items: flex-end;
        padding: 20px;
    }

    .category-card:hover .category-overlay {
        opacity: 1;
    }

    .category-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        padding: 5px 15px;
        background: var(--gradient-1);
        color: var(--white);
        border-radius: var(--border-radius-full);
        font-size: 0.8rem;
        font-weight: 600;
        z-index: 2;
        box-shadow: var(--shadow-md);
    }

    .category-icon {
        position: absolute;
        bottom: 20px;
        left: 20px;
        width: 50px;
        height: 50px;
        background: var(--white);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        font-size: 1.5rem;
        transform: translateY(20px);
        opacity: 0;
        transition: var(--transition);
        box-shadow: var(--shadow-lg);
    }

    .category-card:hover .category-icon {
        transform: translateY(0);
        opacity: 1;
    }

    .category-content {
        padding: 25px;
    }

    .category-name {
        font-size: 0.9rem;
        color: var(--primary);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 10px;
        font-weight: 600;
    }

    .category-title {
        font-size: 1.5rem;
        margin-bottom: 15px;
        font-weight: 700;
        line-height: 1.3;
    }

    .category-description {
        color: var(--gray);
        line-height: 1.8;
        margin-bottom: 20px;
    }

    .category-meta {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--gray-light);
    }

    .category-meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--gray);
        font-size: 0.95rem;
    }

    .category-meta-item i {
        color: var(--primary);
    }

    .category-link {
        color: var(--primary);
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: var(--transition);
    }

    .category-link:hover {
        gap: 12px;
        color: var(--primary-dark);
    }

    /* Learning Paths Section */
    .paths-section {
        padding: 80px 0;
        background: var(--white);
    }

    .paths-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        margin-top: 50px;
    }

    .path-card {
        background: var(--white);
        border-radius: var(--border-radius-lg);
        padding: 40px 30px;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        border: 1px solid var(--gray-light);
    }

    .path-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 100px;
        height: 100px;
        background: var(--gradient-1);
        border-radius: 50%;
        transform: translate(50px, -50px);
        opacity: 0.1;
        transition: var(--transition);
    }

    .path-card:hover::before {
        transform: translate(30px, -30px) scale(1.5);
        opacity: 0.15;
    }

    .path-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-lg);
        border-color: transparent;
    }

    .path-icon {
        width: 70px;
        height: 70px;
        background: var(--gradient-1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 25px;
        color: var(--white);
        font-size: 1.8rem;
        transition: var(--transition);
    }

    .path-card:hover .path-icon {
        transform: scale(1.1) rotate(5deg);
    }

    .path-title {
        font-size: 1.4rem;
        margin-bottom: 15px;
        font-weight: 700;
    }

    .path-description {
        color: var(--gray);
        line-height: 1.8;
        margin-bottom: 20px;
    }

    .path-features {
        list-style: none;
        margin-bottom: 25px;
    }

    .path-features li {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 12px;
        color: var(--gray);
    }

    .path-features li i {
        color: var(--success);
        font-size: 1rem;
    }

    .path-level {
        display: inline-block;
        padding: 5px 15px;
        background: var(--light);
        border-radius: var(--border-radius-full);
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--primary);
    }

    /* CTA Section */
    .academy-cta {
        padding: 80px 0;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: var(--white);
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .academy-cta::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 10s ease-in-out infinite;
    }

    .academy-cta::after {
        content: '';
        position: absolute;
        bottom: -50%;
        left: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 8s ease-in-out infinite reverse;
    }

    .academy-cta-content {
        position: relative;
        z-index: 2;
        max-width: 700px;
        margin: 0 auto;
    }

    .academy-cta h2 {
        font-size: clamp(2rem, 5vw, 3rem);
        margin-bottom: 20px;
    }

    .academy-cta p {
        font-size: 1.2rem;
        opacity: 0.9;
        margin-bottom: 30px;
    }

    .academy-cta-buttons {
        display: flex;
        gap: 20px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .academy-cta-buttons .btn {
        min-width: 200px;
    }

    .academy-cta-buttons .btn-secondary {
        border-color: var(--white);
        color: var(--white);
    }

    .academy-cta-buttons .btn-secondary:hover {
        background: var(--white);
        color: var(--primary);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .academy-hero-stats {
            gap: 30px;
        }

        .hero-stat-number {
            font-size: 1.5rem;
        }

        .category-grid {
            grid-template-columns: 1fr;
        }

        .paths-grid {
            grid-template-columns: 1fr;
        }

        .academy-cta-buttons .btn {
            min-width: 150px;
        }
    }

    /* Animations */
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="academy-hero">
    <div class="academy-hero-particles">
        <div class="academy-hero-particle"></div>
        <div class="academy-hero-particle"></div>
        <div class="academy-hero-particle"></div>
        <div class="academy-hero-particle"></div>
    </div>

    <div class="container">
        <div class="academy-hero-content">
            <span class="academy-hero-badge">EDUCONECX Academy</span>
            <h1 class="academy-hero-title">Master Practical Skills for the Digital Economy</h1>
            <p class="academy-hero-text">
                Practical online courses in English, finance, business, and technology.
                Learn with AI-powered guidance and expert instruction.
            </p>

            <div class="academy-hero-stats">
                <div class="hero-stat-item">
                    <div class="hero-stat-number">50+</div>
                    <div class="hero-stat-label">Expert-Led Courses</div>
                </div>
                <div class="hero-stat-item">
                    <div class="hero-stat-number">10K+</div>
                    <div class="hero-stat-label">Active Students</div>
                </div>
                <div class="hero-stat-item">
                    <div class="hero-stat-number">15+</div>
                    <div class="hero-stat-label">Countries</div>
                </div>
                <div class="hero-stat-item">
                    <div class="hero-stat-number">4.9</div>
                    <div class="hero-stat-label">Student Rating</div>
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
            <h2 class="section-title">The Academy Advantage</h2>
            <p class="section-description">
                Experience a unique learning approach that combines AI technology with practical skills training
            </p>
        </div>

        <div class="features-grid">
            <div class="feature-card" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-icon">
                    <i class="fas fa-robot"></i>
                </div>
                <h3 class="feature-title">AI-Powered Learning</h3>
                <p class="feature-text">Personalized learning paths that adapt to your pace and style with intelligent recommendations.</p>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <h3 class="feature-title">Learn at Your Pace</h3>
                <p class="feature-text">Self-paced courses with lifetime access. Study anytime, anywhere, on any device.</p>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-icon">
                    <i class="fas fa-award"></i>
                </div>
                <h3 class="feature-title">Industry Certification</h3>
                <p class="feature-text">Earn recognized certificates upon completion to boost your career prospects.</p>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="400">
                <div class="feature-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3 class="feature-title">Expert Instructors</h3>
                <p class="feature-text">Learn from industry professionals with real-world experience and proven track records.</p>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="categories-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-subtitle">Our Programs</span>
            <h2 class="section-title">Explore Learning Categories</h2>
            <p class="section-description">
                Choose from our comprehensive range of practical courses designed for your success
            </p>
        </div>

        <div class="category-grid">
            <!-- Business Essentials -->
            <div class="category-card" data-aos="fade-up" data-aos-delay="100">
                <div class="category-image">
                    <img src="https://images.unsplash.com/photo-1557804506-669a67965ba0?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Business Essentials">
                    <div class="category-overlay"></div>
                    <span class="category-badge">Popular</span>
                    <div class="category-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
                <div class="category-content">
                    <div class="category-name">Business</div>
                    <h3 class="category-title">📊 Business Essentials</h3>
                    <p class="category-description">
                        Learn the core principles of business, from entrepreneurship and management to
                        strategy and leadership, designed to help you succeed in today's competitive world.
                    </p>
                    <div class="category-meta">
                        <div class="category-meta-item">
                            <i class="far fa-clock"></i>
                            <span>24+ Hours</span>
                        </div>
                        <div class="category-meta-item">
                            <i class="fas fa-signal"></i>
                            <span>All Levels</span>
                        </div>
                        <div class="category-meta-item">
                            <i class="fas fa-video"></i>
                            <span>15 Courses</span>
                        </div>
                    </div>
                    <a href="{{ route('courses') }}" class="category-link">
                        Explore Business Courses <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- Finance Made Simple -->
            <div class="category-card" data-aos="fade-up" data-aos-delay="200">
                <div class="category-image">
                    <img src="https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Finance Made Simple">
                    <div class="category-overlay"></div>
                    <span class="category-badge">New</span>
                    <div class="category-icon">
                        <i class="fas fa-coins"></i>
                    </div>
                </div>
                <div class="category-content">
                    <div class="category-name">Finance</div>
                    <h3 class="category-title">💰 Finance Made Simple</h3>
                    <p class="category-description">
                        Understand money management, investments, and financial planning. This course helps
                        you make smarter financial decisions for personal and professional growth.
                    </p>
                    <div class="category-meta">
                        <div class="category-meta-item">
                            <i class="far fa-clock"></i>
                            <span>18+ Hours</span>
                        </div>
                        <div class="category-meta-item">
                            <i class="fas fa-signal"></i>
                            <span>Beginner</span>
                        </div>
                        <div class="category-meta-item">
                            <i class="fas fa-video"></i>
                            <span>12 Courses</span>
                        </div>
                    </div>
                    <a href="{{ route('courses') }}" class="category-link">
                        Explore Finance Courses <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- English for Everyone -->
            <div class="category-card" data-aos="fade-up" data-aos-delay="300">
                <div class="category-image">
                    <img src="https://images.unsplash.com/photo-1546410531-bb4caa6b424d?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="English for Everyone">
                    <div class="category-overlay"></div>
                    <span class="category-badge">Featured</span>
                    <div class="category-icon">
                        <i class="fas fa-language"></i>
                    </div>
                </div>
                <div class="category-content">
                    <div class="category-name">Language</div>
                    <h3 class="category-title">📘 English for Everyone</h3>
                    <p class="category-description">
                        Build strong communication skills with practical English lessons. Improve your speaking,
                        writing, and comprehension for everyday use, academics, and the workplace.
                    </p>
                    <div class="category-meta">
                        <div class="category-meta-item">
                            <i class="far fa-clock"></i>
                            <span>30+ Hours</span>
                        </div>
                        <div class="category-meta-item">
                            <i class="fas fa-signal"></i>
                            <span>All Levels</span>
                        </div>
                        <div class="category-meta-item">
                            <i class="fas fa-video"></i>
                            <span>20 Courses</span>
                        </div>
                    </div>
                    <a href="{{ route('courses') }}" class="category-link">
                        Explore English Courses <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- Technology & Innovation -->
            <div class="category-card" data-aos="fade-up" data-aos-delay="400">
                <div class="category-image">
                    <img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Technology & Innovation">
                    <div class="category-overlay"></div>
                    <span class="category-badge">Trending</span>
                    <div class="category-icon">
                        <i class="fas fa-microchip"></i>
                    </div>
                </div>
                <div class="category-content">
                    <div class="category-name">Technology</div>
                    <h3 class="category-title">💻 Technology & Innovation</h3>
                    <p class="category-description">
                        Discover the latest in digital tools, software, and emerging technologies. Gain
                        hands-on knowledge to stay ahead in the fast-changing tech landscape.
                    </p>
                    <div class="category-meta">
                        <div class="category-meta-item">
                            <i class="far fa-clock"></i>
                            <span>25+ Hours</span>
                        </div>
                        <div class="category-meta-item">
                            <i class="fas fa-signal"></i>
                            <span>Intermediate</span>
                        </div>
                        <div class="category-meta-item">
                            <i class="fas fa-video"></i>
                            <span>18 Courses</span>
                        </div>
                    </div>
                    <a href="{{ route('courses') }}" class="category-link">
                        Explore Tech Courses <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- Digital Marketing -->
            <div class="category-card" data-aos="fade-up" data-aos-delay="500">
                <div class="category-image">
                    <img src="https://images.unsplash.com/photo-1432888498266-38ffec3eaf0a?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Digital Marketing">
                    <div class="category-overlay"></div>
                    <div class="category-icon">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                </div>
                <div class="category-content">
                    <div class="category-name">Marketing</div>
                    <h3 class="category-title">📱 Digital Marketing Mastery</h3>
                    <p class="category-description">
                        Master social media, SEO, content marketing, and analytics. Learn to build and
                        execute effective digital marketing strategies for business growth.
                    </p>
                    <div class="category-meta">
                        <div class="category-meta-item">
                            <i class="far fa-clock"></i>
                            <span>22+ Hours</span>
                        </div>
                        <div class="category-meta-item">
                            <i class="fas fa-signal"></i>
                            <span>All Levels</span>
                        </div>
                        <div class="category-meta-item">
                            <i class="fas fa-video"></i>
                            <span>14 Courses</span>
                        </div>
                    </div>
                    <a href="{{ route('courses') }}" class="category-link">
                        Explore Marketing Courses <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- Leadership & Management -->
            <div class="category-card" data-aos="fade-up" data-aos-delay="600">
                <div class="category-image">
                    <img src="https://images.unsplash.com/photo-1552581234-26160f608093?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Leadership & Management">
                    <div class="category-overlay"></div>
                    <div class="category-icon">
                        <i class="fas fa-users-cog"></i>
                    </div>
                </div>
                <div class="category-content">
                    <div class="category-name">Leadership</div>
                    <h3 class="category-title">👥 Leadership & Management</h3>
                    <p class="category-description">
                        Develop essential leadership skills, team management techniques, and strategies
                        to inspire and guide others toward success.
                    </p>
                    <div class="category-meta">
                        <div class="category-meta-item">
                            <i class="far fa-clock"></i>
                            <span>20+ Hours</span>
                        </div>
                        <div class="category-meta-item">
                            <i class="fas fa-signal"></i>
                            <span>Intermediate</span>
                        </div>
                        <div class="category-meta-item">
                            <i class="fas fa-video"></i>
                            <span>10 Courses</span>
                        </div>
                    </div>
                    <a href="{{ route('courses') }}" class="category-link">
                        Explore Leadership Courses <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Learning Paths Section -->
<section class="paths-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-subtitle">Learning Paths</span>
            <h2 class="section-title">Structured Programs for Your Goals</h2>
            <p class="section-description">
                Follow curated learning paths designed to take you from beginner to expert
            </p>
        </div>

        <div class="paths-grid">
            <!-- Path 1: Business -->
            <div class="path-card" data-aos="fade-up" data-aos-delay="100">
                <div class="path-icon">
                    <i class="fas fa-briefcase"></i>
                </div>
                <h3 class="path-title">Business Professional</h3>
                <p class="path-description">
                    Complete business training for entrepreneurs and professionals
                </p>
                <ul class="path-features">
                    <li><i class="fas fa-check-circle"></i> Business Fundamentals</li>
                    <li><i class="fas fa-check-circle"></i> Strategic Management</li>
                    <li><i class="fas fa-check-circle"></i> Entrepreneurship</li>
                    <li><i class="fas fa-check-circle"></i> Business Communication</li>
                </ul>
                <span class="path-level">12 Courses • 45 Hours</span>
            </div>

            <!-- Path 2: Finance -->
            <div class="path-card" data-aos="fade-up" data-aos-delay="200">
                <div class="path-icon">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <h3 class="path-title">Financial Analyst</h3>
                <p class="path-description">
                    Master financial analysis and investment strategies
                </p>
                <ul class="path-features">
                    <li><i class="fas fa-check-circle"></i> Financial Accounting</li>
                    <li><i class="fas fa-check-circle"></i> Investment Analysis</li>
                    <li><i class="fas fa-check-circle"></i> Risk Management</li>
                    <li><i class="fas fa-check-circle"></i> Corporate Finance</li>
                </ul>
                <span class="path-level">8 Courses • 32 Hours</span>
            </div>

            <!-- Path 3: English -->
            <div class="path-card" data-aos="fade-up" data-aos-delay="300">
                <div class="path-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <h3 class="path-title">English Mastery</h3>
                <p class="path-description">
                    Complete English language program for all levels
                </p>
                <ul class="path-features">
                    <li><i class="fas fa-check-circle"></i> Business English</li>
                    <li><i class="fas fa-check-circle"></i> Academic Writing</li>
                    <li><i class="fas fa-check-circle"></i> Conversation Practice</li>
                    <li><i class="fas fa-check-circle"></i> Pronunciation</li>
                </ul>
                <span class="path-level">15 Courses • 50 Hours</span>
            </div>

            <!-- Path 4: Technology -->
            <div class="path-card" data-aos="fade-up" data-aos-delay="400">
                <div class="path-icon">
                    <i class="fas fa-code"></i>
                </div>
                <h3 class="path-title">Tech Innovator</h3>
                <p class="path-description">
                    Comprehensive technology and innovation training
                </p>
                <ul class="path-features">
                    <li><i class="fas fa-check-circle"></i> Web Development</li>
                    <li><i class="fas fa-check-circle"></i> AI & Machine Learning</li>
                    <li><i class="fas fa-check-circle"></i> Cloud Computing</li>
                    <li><i class="fas fa-check-circle"></i> Cybersecurity</li>
                </ul>
                <span class="path-level">10 Courses • 40 Hours</span>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="academy-cta">
    <div class="container">
        <div class="academy-cta-content" data-aos="zoom-in">
            <h2>Ready to Transform Your Future?</h2>
            <p>Join thousands of students and start mastering practical skills today</p>
            <div class="academy-cta-buttons">
                <a href="{{ route('courses') }}" class="btn btn-primary">
                    <i class="fas fa-play-circle"></i> Start Learning Free
                </a>
                <a href="{{ route('contact') }}" class="btn btn-secondary">
                    <i class="fas fa-calendar-alt"></i> Schedule Consultation
                </a>
            </div>
        </div>
    </div>
</section>
@endsection