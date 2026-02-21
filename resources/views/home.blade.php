@extends('layouts.main')

@section('title', 'Empower Your Learning Journey Today - EDUCONECX')

@section('meta_description', 'EDUCONECX is an international AI-powered educational platform that empowers learners worldwide with practical language and digital business skills.')

@push('styles')
<style>
    /* Hero Section */
    .hero-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 100px 0;
        text-align: center;
    }
    
    .hero-title {
        font-size: 48px;
        font-weight: 700;
        margin-bottom: 20px;
        animation: slideUp 1s ease-out;
    }
    
    .hero-subtitle {
        font-size: 24px;
        opacity: 0.9;
        animation: slideUp 1s ease-out 0.2s both;
    }
    
    /* CTA Section */
    .cta-section {
        background: var(--white);
        padding: 40px 0;
    }
    
    .cta-buttons {
        display: flex;
        gap: 20px;
        justify-content: center;
        flex-wrap: wrap;
    }
    
    .btn {
        display: inline-block;
        padding: 15px 40px;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s;
        border: none;
        cursor: pointer;
    }
    
    .btn-primary {
        background: var(--primary-color);
        color: white;
    }
    
    .btn-primary:hover {
        background: var(--primary-hover);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(1,123,254,0.3);
    }
    
    .btn-secondary {
        background: transparent;
        color: var(--primary-color);
        border: 2px solid var(--primary-color);
    }
    
    .btn-secondary:hover {
        background: var(--primary-color);
        color: white;
        transform: translateY(-2px);
    }
    
    /* Offer Banner */
    .offer-banner {
        background: linear-gradient(45deg, #f093fb 0%, #f5576c 100%);
        color: white;
        padding: 20px;
        text-align: center;
        font-size: 24px;
        font-weight: 600;
    }
    
    /* Courses Section */
    .courses-section {
        padding: 60px 0;
        background: #f8f9fa;
    }
    
    .section-title {
        text-align: center;
        font-size: 36px;
        margin-bottom: 40px;
        position: relative;
    }
    
    .section-title:after {
        content: '';
        display: block;
        width: 60px;
        height: 3px;
        background: var(--primary-color);
        margin: 20px auto 0;
    }
    
    .course-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
    }
    
    .course-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        transition: all 0.3s;
    }
    
    .course-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.15);
    }
    
    .course-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }
    
    .course-content {
        padding: 20px;
    }
    
    .course-title {
        font-size: 20px;
        margin-bottom: 10px;
    }
    
    .course-btn {
        display: inline-block;
        padding: 10px 20px;
        background: var(--primary-color);
        color: white;
        border-radius: 5px;
        margin-top: 15px;
    }
    
    /* Stats Section */
    .stats-section {
        padding: 60px 0;
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 30px;
        text-align: center;
    }
    
    .stat-number {
        font-size: 48px;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 10px;
    }
    
    /* Testimonials */
    .testimonials-section {
        background: #f8f9fa;
        padding: 60px 0;
    }
    
    .testimonials-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
    }
    
    .testimonial-card {
        background: white;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    
    .rating {
        color: #ffc107;
        margin-bottom: 15px;
    }
    
    .testimonial-text {
        font-style: italic;
        margin-bottom: 20px;
        line-height: 1.6;
    }
    
    .testimonial-author {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .author-img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
    }
    
    .author-name {
        font-weight: 600;
    }
    
    .author-title {
        font-size: 14px;
        color: #666;
    }
    
    /* Team Section */
    .team-section {
        padding: 60px 0;
    }
    
    .team-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 30px;
    }
    
    .team-card {
        text-align: center;
    }
    
    .team-img {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 15px;
    }
    
    /* FAQ Section */
    .faq-section {
        background: #f8f9fa;
        padding: 60px 0;
    }
    
    .faq-grid {
        max-width: 800px;
        margin: 0 auto;
    }
    
    .faq-item {
        background: white;
        margin-bottom: 15px;
        border-radius: 10px;
        overflow: hidden;
    }
    
    .faq-question {
        padding: 20px;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 600;
    }
    
    .faq-answer {
        padding: 0 20px 20px;
        display: none;
    }
    
    .faq-item.active .faq-answer {
        display: block;
    }
    
    /* Quiz Section */
    .quiz-section {
        padding: 60px 0;
    }
    
    .quiz-container {
        max-width: 800px;
        margin: 0 auto;
        background: white;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    
    .quiz-title {
        text-align: center;
        margin-bottom: 30px;
    }
    
    .quiz-option {
        display: block;
        width: 100%;
        padding: 15px;
        margin-bottom: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .quiz-option:hover {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }
    
    .quiz-option.selected {
        background: var(--primary-color);
        color: white;
    }
    
    .quiz-btn {
        background: var(--primary-color);
        color: white;
        border: none;
        padding: 15px 30px;
        border-radius: 5px;
        cursor: pointer;
        font-weight: 600;
        margin-top: 20px;
    }
    
    .quiz-btn:hover {
        background: var(--primary-hover);
    }
    
    @media (max-width: 768px) {
        .hero-title {
            font-size: 36px;
        }
        
        .hero-subtitle {
            font-size: 20px;
        }
        
        .section-title {
            font-size: 28px;
        }
    }
</style>
@endpush

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1 class="hero-title">Empower Your Learning Journey Today</h1>
            <p class="hero-subtitle">Learn Connect Grow together</p>
        </div>
    </section>
    
    <!-- CTA Section -->
    <section class="cta-section animate-on-scroll">
        <div class="container">
            <div class="cta-buttons">
                <a href="{{ route('academy') }}" class="btn btn-primary">Join Academy</a>
                <a href="{{ route('neo-ed-tech') }}" class="btn btn-secondary">Work with NEO ED-TECH</a>
            </div>
        </div>
    </section>
    
    <!-- Offer Banner -->
    <section class="offer-banner animate-on-scroll">
        <div class="container">
            <p>Unlimited Access To All Courses – Only $22</p>
        </div>
    </section>
    
    <!-- Courses Section -->
    <section class="courses-section">
        <div class="container">
            <h2 class="section-title">Featured Courses</h2>
            <div class="course-grid">
                <!-- Course Card 1 -->
                <div class="course-card animate-on-scroll">
                    <img src="https://via.placeholder.com/400x200" alt="Course" class="course-image">
                    <div class="course-content">
                        <h3 class="course-title">Smartphone Videography Masterclass</h3>
                        <p>Learn professional video creation using just your smartphone.</p>
                        <a href="#" class="course-btn">See details</a>
                    </div>
                </div>
                
                <!-- Course Card 2 -->
                <div class="course-card animate-on-scroll" style="animation-delay: 0.2s;">
                    <img src="https://via.placeholder.com/400x200" alt="Course" class="course-image">
                    <div class="course-content">
                        <h3 class="course-title">Build a Profitable International Business</h3>
                        <p>Learn how to build a profitable international family business.</p>
                        <a href="#" class="course-btn">See details</a>
                    </div>
                </div>
                
                <!-- Course Card 3 -->
                <div class="course-card animate-on-scroll" style="animation-delay: 0.4s;">
                    <img src="https://via.placeholder.com/400x200" alt="Course" class="course-image">
                    <div class="course-content">
                        <h3 class="course-title">The Canva Success System</h3>
                        <p>Master Canva and create stunning professional designs.</p>
                        <a href="#" class="course-btn">See details</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- About Section -->
    <section class="stats-section">
        <div class="container">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 50px; align-items: center;">
                <div>
                    <h2 class="section-title" style="text-align: left;">About EDUCONECX</h2>
                    <p><strong>EDUCONECX</strong> is an international AI-powered educational platform that empowers learners worldwide with practical language and digital business skills.</p>
                    <p>Our mission is to help individuals break through language barriers and thrive in today's global digital economy.</p>
                    <a href="{{ route('about') }}" class="btn btn-primary" style="margin-top: 20px;">Read more about us</a>
                </div>
                <div>
                    <img src="https://via.placeholder.com/600x400" alt="About Us" style="width: 100%; border-radius: 10px;">
                </div>
            </div>
        </div>
    </section>
    
    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item animate-on-scroll">
                    <div class="stat-number">127+</div>
                    <div>Reviews on Capterra</div>
                </div>
                <div class="stat-item animate-on-scroll" style="animation-delay: 0.2s;">
                    <div class="stat-number">4.9</div>
                    <div>Average Rating</div>
                </div>
                <div class="stat-item animate-on-scroll" style="animation-delay: 0.4s;">
                    <div class="stat-number">1000+</div>
                    <div>Students Worldwide</div>
                </div>
                <div class="stat-item animate-on-scroll" style="animation-delay: 0.6s;">
                    <div class="stat-number">50+</div>
                    <div>Expert Instructors</div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Testimonials Section -->
    <section class="testimonials-section">
        <div class="container">
            <h2 class="section-title">What Our Students Are Saying</h2>
            <div class="testimonials-grid">
                <!-- Testimonial 1 -->
                <div class="testimonial-card animate-on-scroll">
                    <div class="rating">
                        ★★★★★
                    </div>
                    <p class="testimonial-text">"The Academy made learning so easy! Courses are practical and well-structured. I was able to learn at my own pace even with slow internet."</p>
                    <div class="testimonial-author">
                        <img src="https://via.placeholder.com/50" alt="Sarah M." class="author-img">
                        <div>
                            <div class="author-name">Sarah M.</div>
                            <div class="author-title">Business Student</div>
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial 2 -->
                <div class="testimonial-card animate-on-scroll" style="animation-delay: 0.2s;">
                    <div class="rating">
                        ★★★★★
                    </div>
                    <p class="testimonial-text">"Their guidance is a game-changer. The daily insights and AI companion keep me motivated and focused. It feels personal and uplifting."</p>
                    <div class="testimonial-author">
                        <img src="https://via.placeholder.com/50" alt="Daniel K." class="author-img">
                        <div>
                            <div class="author-name">Daniel K.</div>
                            <div class="author-title">Graduate Student</div>
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial 3 -->
                <div class="testimonial-card animate-on-scroll" style="animation-delay: 0.4s;">
                    <div class="rating">
                        ★★★★★
                    </div>
                    <p class="testimonial-text">"One platform for everything I need. Instead of jumping between sites, I can access courses, guidance, and digital services all in one place."</p>
                    <div class="testimonial-author">
                        <img src="https://via.placeholder.com/50" alt="Aisha R." class="author-img">
                        <div>
                            <div class="author-name">Aisha R.</div>
                            <div class="author-title">Entrepreneur</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="container">
            <h2 class="section-title">Frequently Asked Questions</h2>
            <div class="faq-grid">
                <!-- FAQ Item 1 -->
                <div class="faq-item animate-on-scroll">
                    <div class="faq-question">
                        <span>What is EDUCONECX?</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>EDUCONECX is an innovative online educational platform that combines AI-powered English learning with specialized training programs. We offer both free and premium educational content designed to accelerate your professional development.</p>
                    </div>
                </div>
                
                <!-- FAQ Item 2 -->
                <div class="faq-item animate-on-scroll">
                    <div class="faq-question">
                        <span>In which languages are the courses available?</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Our courses are available in English, French, Haitian Creole, and Spanish to serve our diverse international community of learners.</p>
                    </div>
                </div>
                
                <!-- FAQ Item 3 -->
                <div class="faq-item animate-on-scroll">
                    <div class="faq-question">
                        <span>How do I get started?</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Getting started is simple: create your account, select your preferred course, and begin with our 3-day free trial to explore the platform risk-free.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- FAQ JavaScript -->
    @push('scripts')
    <script>
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
    </script>
    @endpush
@endsection