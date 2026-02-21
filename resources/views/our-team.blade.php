@extends('layouts.main')

@section('title', 'Our Team - EDUCONECX | Meet the Minds Behind the Platform')

@section('meta_description', 'Meet the passionate minds behind EDUCONECX - a team of educators, creators, and AI visionaries working together to break language barriers and build a brighter, more inclusive future.')

@push('styles')
<style>
    /* Hero Section */
    .team-hero {
        position: relative;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 100px 0;
        overflow: hidden;
        color: var(--white);
    }

    .team-hero-particles {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    .team-hero-particle {
        position: absolute;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .team-hero-particle:nth-child(1) {
        width: 300px;
        height: 300px;
        top: -100px;
        right: -100px;
        animation: float 8s ease-in-out infinite;
    }

    .team-hero-particle:nth-child(2) {
        width: 200px;
        height: 200px;
        bottom: -50px;
        left: -50px;
        animation: float 10s ease-in-out infinite reverse;
    }

    .team-hero-particle:nth-child(3) {
        width: 150px;
        height: 150px;
        top: 30%;
        left: 20%;
        animation: float 12s ease-in-out infinite;
    }

    .team-hero-particle:nth-child(4) {
        width: 100px;
        height: 100px;
        bottom: 20%;
        right: 15%;
        animation: float 9s ease-in-out infinite;
    }

    .team-hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
        max-width: 900px;
        margin: 0 auto;
    }

    .team-hero-badge {
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

    .team-hero-title {
        font-size: clamp(2.5rem, 8vw, 4rem);
        font-weight: 800;
        margin-bottom: 25px;
        line-height: 1.1;
        text-shadow: 0 2px 10px rgba(0,0,0,0.3);
        animation: fadeInUp 1s ease-out 0.2s both;
    }

    .team-hero-text {
        font-size: clamp(1.1rem, 3vw, 1.3rem);
        opacity: 0.9;
        line-height: 1.8;
        max-width: 800px;
        margin: 0 auto;
        animation: fadeInUp 1s ease-out 0.4s both;
    }

    .team-hero-text p {
        margin-bottom: 15px;
    }

    .team-hero-text p:last-child {
        margin-bottom: 0;
    }

    .team-hero-text strong {
        color: var(--white);
        font-weight: 700;
        text-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }

    /* Mission Statement */
    .mission-statement {
        background: var(--white);
        padding: 60px 0;
        text-align: center;
        border-bottom: 1px solid var(--gray-light);
    }

    .mission-content {
        max-width: 900px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .mission-quote {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 20px;
        line-height: 1.4;
        position: relative;
    }

    .mission-quote i {
        color: var(--primary);
        opacity: 0.3;
        font-size: 3rem;
        position: absolute;
        top: -20px;
        left: -20px;
    }

    .mission-text {
        font-size: 1.2rem;
        color: var(--gray);
        line-height: 1.8;
        max-width: 700px;
        margin: 0 auto;
    }

    /* Team Stats */
    .team-stats {
        background: var(--light);
        padding: 60px 0;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 30px;
        max-width: 1000px;
        margin: 0 auto;
    }

    .stat-item {
        text-align: center;
        padding: 30px 20px;
        background: var(--white);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
    }

    .stat-item:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-lg);
    }

    .stat-icon {
        width: 70px;
        height: 70px;
        background: var(--gradient-1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        color: var(--white);
        font-size: 1.8rem;
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--primary);
        margin-bottom: 5px;
    }

    .stat-label {
        color: var(--gray);
        font-size: 1rem;
        font-weight: 500;
    }

    /* Team Grid Section */
    .team-section {
        padding: 80px 0;
        background: var(--white);
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

    .team-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 40px;
        max-width: 1000px;
        margin: 0 auto;
    }

    .team-card {
        background: var(--white);
        border-radius: var(--border-radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-lg);
        transition: var(--transition);
        text-align: center;
        position: relative;
    }

    .team-card:hover {
        transform: translateY(-15px);
        box-shadow: var(--shadow-hover);
    }

    .team-card-image {
        position: relative;
        overflow: hidden;
        aspect-ratio: 1;
    }

    .team-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition-slow);
    }

    .team-card:hover .team-card-image img {
        transform: scale(1.1);
    }

    .team-card-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom, transparent 0%, rgba(0,0,0,0.8) 100%);
        opacity: 0;
        transition: var(--transition);
        display: flex;
        align-items: flex-end;
        justify-content: center;
        padding: 30px;
    }

    .team-card:hover .team-card-overlay {
        opacity: 1;
    }

    .team-social {
        display: flex;
        gap: 15px;
        transform: translateY(20px);
        transition: var(--transition);
    }

    .team-card:hover .team-social {
        transform: translateY(0);
    }

    .social-link {
        width: 40px;
        height: 40px;
        background: var(--white);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        font-size: 1.1rem;
        transition: var(--transition);
        text-decoration: none;
    }

    .social-link:hover {
        background: var(--primary);
        color: var(--white);
        transform: translateY(-3px);
    }

    .team-card-content {
        padding: 25px;
        background: var(--white);
    }

    .team-name {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 5px;
        color: var(--dark);
    }

    .team-position {
        font-size: 1rem;
        color: var(--primary);
        font-weight: 600;
        margin-bottom: 15px;
        letter-spacing: 0.5px;
    }

    .team-bio {
        color: var(--gray);
        font-size: 0.95rem;
        line-height: 1.8;
        margin-bottom: 20px;
        max-width: 350px;
        margin-left: auto;
        margin-right: auto;
    }

    .team-expertise {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        justify-content: center;
        margin-bottom: 20px;
    }

    .expertise-tag {
        padding: 4px 12px;
        background: var(--light);
        border-radius: var(--border-radius-full);
        font-size: 0.8rem;
        color: var(--primary);
        font-weight: 500;
    }

    /* Values Section */
    .values-section {
        padding: 80px 0;
        background: var(--light);
    }

    .values-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        margin-top: 50px;
    }

    .value-card {
        background: var(--white);
        padding: 40px 30px;
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        text-align: center;
    }

    .value-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-lg);
    }

    .value-icon {
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

    .value-card:hover .value-icon {
        transform: rotateY(180deg);
    }

    .value-title {
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .value-text {
        color: var(--gray);
        line-height: 1.8;
    }

    /* Join Team CTA */
    .join-team {
        padding: 80px 0;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: var(--white);
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .join-team::before {
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

    .join-team::after {
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

    .join-team-content {
        position: relative;
        z-index: 2;
        max-width: 700px;
        margin: 0 auto;
    }

    .join-team h2 {
        font-size: clamp(2rem, 5vw, 3rem);
        margin-bottom: 20px;
    }

    .join-team p {
        font-size: 1.2rem;
        opacity: 0.9;
        margin-bottom: 30px;
    }

    .join-team .btn {
        background: var(--white);
        color: var(--primary);
        padding: 15px 40px;
        font-size: 1.1rem;
    }

    .join-team .btn:hover {
        background: transparent;
        color: var(--white);
        border-color: var(--white);
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .values-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .team-hero {
            padding: 60px 0;
        }

        .mission-quote {
            font-size: 1.5rem;
        }

        .mission-quote i {
            font-size: 2rem;
            top: -10px;
            left: -10px;
        }

        .stats-grid {
            grid-template-columns: 1fr;
            max-width: 400px;
        }

        .team-grid {
            grid-template-columns: 1fr;
            gap: 30px;
            padding: 0 20px;
        }

        .values-grid {
            grid-template-columns: 1fr;
        }

        .team-name {
            font-size: 1.5rem;
        }

        .team-position {
            font-size: 0.9rem;
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
    <section class="team-hero">
        <div class="team-hero-particles">
            <div class="team-hero-particle"></div>
            <div class="team-hero-particle"></div>
            <div class="team-hero-particle"></div>
            <div class="team-hero-particle"></div>
        </div>
        
        <div class="container">
            <div class="team-hero-content">
                <span class="team-hero-badge">Our Team</span>
                <h1 class="team-hero-title">Meet the Minds Behind EDUCONECX</h1>
                <div class="team-hero-text">
                    <p><strong>A team of educators, creators, and AI visionaries</strong></p>
                    <p>Working together to break language barriers and build a brighter, more inclusive future.</p>
                    <p>We blend technology, heart, and purpose to serve communities with clarity, care, and confidence.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission Statement -->
    <section class="mission-statement">
        <div class="container">
            <div class="mission-content" data-aos="fade-up">
                <div class="mission-quote">
                    <i class="fas fa-quote-left"></i>
                    Our mission is to make quality education accessible to everyone, everywhere.
                </div>
                <p class="mission-text">
                    We believe that the right education, combined with the right technology and the right people, 
                    can transform lives and communities. Our team is dedicated to creating a platform that empowers 
                    learners worldwide to achieve their dreams.
                </p>
            </div>
        </div>
    </section>

    <!-- Team Stats -->
    <section class="team-stats">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-number">15+</div>
                    <div class="stat-label">Team Members</div>
                </div>
                <div class="stat-item" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-icon">
                        <i class="fas fa-globe"></i>
                    </div>
                    <div class="stat-number">8+</div>
                    <div class="stat-label">Countries</div>
                </div>
                <div class="stat-item" data-aos="fade-up" data-aos-delay="300">
                    <div class="stat-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="stat-number">50+</div>
                    <div class="stat-label">Years Combined Experience</div>
                </div>
                <div class="stat-item" data-aos="fade-up" data-aos-delay="400">
                    <div class="stat-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <div class="stat-number">10K+</div>
                    <div class="stat-label">Lives Impacted</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Grid Section -->
    <section class="team-section">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <span class="section-subtitle">Our People</span>
                <h2 class="section-title">The Passionate Minds Behind the Platform</h2>
                <p class="section-description">
                    Dedicated professionals committed to transforming education through technology and innovation
                </p>
            </div>

            <div class="team-grid">
                @foreach($teamMembers as $member)
                    <div class="team-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="team-card-image">
                            <img src="{{ $member['image'] }}" alt="{{ $member['name'] }}">
                            <div class="team-card-overlay">
                                <div class="team-social">
                                    <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                                    <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                                    <a href="#" class="social-link"><i class="fas fa-envelope"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="team-card-content">
                            <h3 class="team-name">{{ $member['name'] }}</h3>
                            <div class="team-position">{{ $member['position'] }}</div>
                            
                            @if(isset($member['expertise']) && is_array($member['expertise']))
                                <div class="team-expertise">
                                    @foreach($member['expertise'] as $skill)
                                        <span class="expertise-tag">{{ $skill }}</span>
                                    @endforeach
                                </div>
                            @endif
                            
                            @if(isset($member['bio']))
                                <p class="team-bio">{{ $member['bio'] }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="values-section">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <span class="section-subtitle">Our Values</span>
                <h2 class="section-title">What Guides Our Work</h2>
                <p class="section-description">
                    The principles that drive our team and shape our platform
                </p>
            </div>

            <div class="values-grid">
                <div class="value-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="value-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h3 class="value-title">Passion for Education</h3>
                    <p class="value-text">
                        We believe in the transformative power of learning and are dedicated to making it accessible to all.
                    </p>
                </div>
                <div class="value-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="value-icon">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <h3 class="value-title">Innovation First</h3>
                    <p class="value-text">
                        We continuously push boundaries to create better learning experiences through technology.
                    </p>
                </div>
                <div class="value-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="value-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="value-title">Community Focused</h3>
                    <p class="value-text">
                        We build with and for our community, ensuring our solutions meet real needs.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Join Team CTA -->
    <section class="join-team">
        <div class="container">
            <div class="join-team-content" data-aos="zoom-in">
                <h2>Join Our Mission</h2>
                <p>We're always looking for passionate individuals to join our team</p>
                <a href="{{ route('contact') }}" class="btn btn-primary">
                    <i class="fas fa-paper-plane"></i> Get in Touch
                </a>
            </div>
        </div>
    </section>
@endsection