@extends('layouts.main')

@section('title', 'Our Team - EDUCONECX | Meet the Minds Behind the Platform')

@section('meta_description', 'Meet the passionate minds behind EDUCONECX - a team of educators, creators, and AI visionaries working together to break language barriers and build a brighter, more inclusive future.')

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
        --transition-slow: all 0.5s ease;
    }

    /* Hero Section */
    .team-hero {
        position: relative;
        background: var(--gradient-1);
        padding: 100px 0;
        overflow: hidden;
        color: var(--pure-white);
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
        background: rgba(251, 198, 12, 0.1);
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
        background: rgba(90, 209, 228, 0.1);
        animation: float 10s ease-in-out infinite reverse;
    }

    .team-hero-particle:nth-child(3) {
        width: 150px;
        height: 150px;
        top: 30%;
        left: 20%;
        background: rgba(235, 215, 137, 0.1);
        animation: float 12s ease-in-out infinite;
    }

    .team-hero-particle:nth-child(4) {
        width: 100px;
        height: 100px;
        bottom: 20%;
        right: 15%;
        background: rgba(10, 29, 68, 0.1);
        animation: float 9s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
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
        background: rgba(254, 253, 254, 0.2);
        border-radius: var(--radius-full);
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 25px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(251, 198, 12, 0.3);
        animation: fadeInDown 1s ease-out;
        color: var(--pure-white);
    }

    .team-hero-title {
        font-size: clamp(2.5rem, 8vw, 4rem);
        font-weight: 800;
        margin-bottom: 25px;
        line-height: 1.1;
        text-shadow: 0 2px 10px rgba(10, 29, 68, 0.3);
        animation: fadeInUp 1s ease-out 0.2s both;
        color: var(--pure-white);
    }

    .team-hero-title span {
        color: var(--bright-amber);
    }

    .team-hero-text {
        font-size: clamp(1.1rem, 3vw, 1.3rem);
        opacity: 0.95;
        line-height: 1.8;
        max-width: 800px;
        margin: 0 auto;
        animation: fadeInUp 1s ease-out 0.4s both;
        color: var(--ivory);
    }

    .team-hero-text p {
        margin-bottom: 15px;
    }

    .team-hero-text p:last-child {
        margin-bottom: 0;
    }

    .team-hero-text strong {
        color: var(--bright-amber);
        font-weight: 700;
    }

    /* Mission Statement */
    .mission-statement {
        background: var(--pure-white);
        padding: 60px 0;
        text-align: center;
        border-bottom: 1px solid rgba(251, 198, 12, 0.2);
    }

    .mission-content {
        max-width: 900px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .mission-quote {
        font-size: clamp(1.5rem, 4vw, 1.8rem);
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 20px;
        line-height: 1.4;
        position: relative;
    }

    .mission-quote i {
        color: var(--bright-amber);
        opacity: 0.2;
        font-size: 3rem;
        position: absolute;
        top: -20px;
        left: -20px;
    }

    .mission-text {
        font-size: clamp(1rem, 3vw, 1.2rem);
        color: var(--text-muted);
        line-height: 1.8;
        max-width: 700px;
        margin: 0 auto;
    }

    /* Team Stats */
    .team-stats {
        background: var(--ivory);
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
        background: var(--pure-white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        transition: var(--transition);
        border: 1px solid rgba(251, 198, 12, 0.1);
    }

    .stat-item:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-hover);
        border-color: var(--bright-amber);
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
        color: var(--pure-white);
        font-size: 1.8rem;
        transition: var(--transition);
    }

    .stat-item:hover .stat-icon {
        background: var(--gradient-2);
        color: var(--prussian-blue);
        transform: scale(1.1);
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--prussian-blue);
        margin-bottom: 5px;
    }

    .stat-label {
        color: var(--text-muted);
        font-size: 1rem;
        font-weight: 500;
    }

    /* Team Grid Section */
    .team-section {
        padding: 80px 0;
        background: var(--pure-white);
    }

    .section-header {
        text-align: center;
        margin-bottom: 50px;
    }

    .section-subtitle {
        color: var(--bright-amber);
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
        color: var(--text-primary);
    }

    .section-title span {
        color: var(--bright-amber);
    }

    .section-description {
        color: var(--text-muted);
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
        background: var(--pure-white);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-lg);
        transition: var(--transition);
        text-align: center;
        position: relative;
        border: 1px solid rgba(251, 198, 12, 0.1);
    }

    .team-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-hover);
        border-color: var(--bright-amber);
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
        background: linear-gradient(to bottom, transparent 0%, rgba(10, 29, 68, 0.8) 100%);
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
        background: var(--pure-white);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--prussian-blue);
        font-size: 1.1rem;
        transition: var(--transition);
        text-decoration: none;
    }

    .social-link:hover {
        background: var(--bright-amber);
        color: var(--prussian-blue);
        transform: translateY(-3px);
    }

    .team-card-content {
        padding: 25px;
        background: var(--pure-white);
    }

    .team-name {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 5px;
        color: var(--text-primary);
    }

    .team-position {
        font-size: 1rem;
        color: var(--bright-amber);
        font-weight: 600;
        margin-bottom: 15px;
        letter-spacing: 0.5px;
    }

    .team-bio {
        color: var(--text-muted);
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
        background: var(--ivory);
        border-radius: var(--radius-full);
        font-size: 0.8rem;
        color: var(--text-secondary);
        font-weight: 500;
        border: 1px solid rgba(251, 198, 12, 0.2);
    }

    /* Values Section */
    .values-section {
        padding: 80px 0;
        background: var(--ivory);
    }

    .values-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        margin-top: 50px;
    }

    .value-card {
        background: var(--pure-white);
        padding: 40px 30px;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        transition: var(--transition);
        text-align: center;
        border: 1px solid rgba(251, 198, 12, 0.1);
    }

    .value-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-hover);
        border-color: var(--bright-amber);
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
        color: var(--pure-white);
        font-size: 2rem;
        transition: var(--transition);
    }

    .value-card:hover .value-icon {
        background: var(--gradient-2);
        color: var(--prussian-blue);
        transform: rotateY(180deg);
    }

    .value-title {
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 15px;
        color: var(--text-primary);
    }

    .value-text {
        color: var(--text-muted);
        line-height: 1.8;
    }

    /* Join Team CTA */
    .join-team {
        padding: 80px 0;
        background: var(--gradient-1);
        color: var(--pure-white);
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
        background: rgba(251, 198, 12, 0.1);
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
        background: rgba(90, 209, 228, 0.1);
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
        color: var(--pure-white);
    }

    .join-team h2 span {
        color: var(--bright-amber);
    }

    .join-team p {
        font-size: 1.2rem;
        opacity: 0.95;
        margin-bottom: 30px;
        color: var(--ivory);
    }

    .join-team .btn {
        background: var(--gradient-2);
        color: var(--prussian-blue);
        padding: 15px 40px;
        font-size: 1.1rem;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        border-radius: var(--radius-full);
        font-weight: 600;
        transition: var(--transition);
        cursor: pointer;
        text-decoration: none;
    }

    .join-team .btn:hover {
        background: transparent;
        color: var(--pure-white);
        border: 2px solid var(--bright-amber);
        transform: translateY(-3px);
        box-shadow: var(--shadow-hover);
    }

    .join-team .btn i {
        font-size: 1.1rem;
        transition: var(--transition);
    }

    .join-team .btn:hover i {
        transform: translateX(5px);
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

    /* Responsive */
    @media (max-width: 1024px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            max-width: 800px;
        }

        .values-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 992px) {
        .team-grid {
            gap: 30px;
            padding: 0 20px;
        }

        .team-name {
            font-size: 1.4rem;
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
        }

        .values-grid {
            grid-template-columns: 1fr;
        }

        .team-name {
            font-size: 1.3rem;
        }

        .team-position {
            font-size: 0.9rem;
        }

        .join-team .btn {
            padding: 12px 30px;
            font-size: 1rem;
        }
    }

    @media (max-width: 576px) {
        .team-hero {
            padding: 50px 0;
        }

        .team-hero-title {
            font-size: 2.2rem;
        }

        .team-hero-text {
            font-size: 1rem;
        }

        .mission-statement {
            padding: 40px 0;
        }

        .mission-quote {
            font-size: 1.3rem;
        }

        .stat-item {
            padding: 25px 15px;
        }

        .stat-number {
            font-size: 2rem;
        }

        .stat-label {
            font-size: 0.9rem;
        }

        .team-card-content {
            padding: 20px;
        }

        .team-name {
            font-size: 1.2rem;
        }

        .team-bio {
            font-size: 0.9rem;
        }

        .expertise-tag {
            font-size: 0.7rem;
            padding: 3px 10px;
        }

        .value-card {
            padding: 30px 20px;
        }

        .value-title {
            font-size: 1.2rem;
        }

        .value-text {
            font-size: 0.95rem;
        }

        .join-team {
            padding: 60px 0;
        }

        .join-team h2 {
            font-size: 2rem;
        }

        .join-team p {
            font-size: 1rem;
        }

        .join-team .btn {
            padding: 10px 25px;
            font-size: 0.95rem;
        }
    }

    /* Extra Small Devices */
    @media (max-width: 380px) {
        .team-hero-title {
            font-size: 2rem;
        }

        .team-hero-badge {
            font-size: 0.8rem;
            padding: 6px 16px;
        }

        .team-social {
            gap: 10px;
        }

        .social-link {
            width: 35px;
            height: 35px;
            font-size: 1rem;
        }

        .expertise-tag {
            font-size: 0.65rem;
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
                <h1 class="team-hero-title">Meet the Minds Behind <span>EDUCONECX</span></h1>
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
                <h2 class="section-title">The Passionate Minds <span>Behind the Platform</span></h2>
                <p class="section-description">
                    Dedicated professionals committed to transforming education through technology and innovation
                </p>
            </div>

            <div class="team-grid">
                @foreach($teamMembers as $member)
                    <div class="team-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="team-card-image">
                            <img src="{{ $member['image'] ?? 'https://via.placeholder.com/400x400' }}" alt="{{ $member['name'] }}">
                            <div class="team-card-overlay">
                                <div class="team-social">
                                    <a href="{{ $member['linkedin'] ?? '#' }}" class="social-link" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                                    <a href="{{ $member['twitter'] ?? '#' }}" class="social-link" target="_blank"><i class="fab fa-twitter"></i></a>
                                    <a href="mailto:{{ $member['email'] ?? '#' }}" class="social-link"><i class="fas fa-envelope"></i></a>
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
                <h2 class="section-title">What <span>Guides</span> Our Work</h2>
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
                <h2>Join <span>Our Mission</span></h2>
                <p>We're always looking for passionate individuals to join our team</p>
                <a href="{{ route('contact') }}" class="btn">
                    <i class="fas fa-paper-plane"></i> Get in Touch
                </a>
            </div>
        </div>
    </section>
@endsection