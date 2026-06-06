@extends('layouts.main')

@section('title', 'About Us - EDUCONECX | Empowering Global Learners')

@section('meta_description', App\Helpers\TranslationHelper::trans('about.meta_description', [], 'en') ?? 'Learn about EDUCONECX, an international interactive educational platform dedicated to supporting learners worldwide with practical language and digital business skills.')

@push('styles')
<style>
    /* Root Variables - Your Beautiful Logo Colors */
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
        
        /* Extended Palette - Fixed for better readability */
        --primary: var(--regal-navy);
        --primary-dark: var(--prussian-blue);
        --primary-light: var(--dark-slate);
        --secondary: var(--sky-blue);
        --accent: var(--bright-amber);
        --accent-soft: var(--light-gold);
        --success: var(--sky-blue);
        --warning: var(--bright-amber);
        
        /* Text Colors - Enhanced for readability */
        --text-primary: #0A1D44;
        --text-secondary: #2E5C61;
        --text-muted: #5f5f5f;
        --text-light: #FEFDFE;
        
        /* Gradients with your colors */
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

    /* Animations */
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }

    @keyframes pulse {
        0%, 100% { opacity: 0.3; }
        50% { opacity: 0.6; }
    }

    /* Hero Section */
    .about-hero {
        position: relative;
        background: var(--gradient-1);
        padding: 120px 0;
        overflow: hidden;
        color: var(--pure-white);
    }

    @media (max-width: 992px) {
        .about-hero {
            padding: 100px 0;
        }
    }

    @media (max-width: 768px) {
        .about-hero {
            padding: 80px 0;
        }
    }

    @media (max-width: 576px) {
        .about-hero {
            padding: 60px 0;
        }
    }

    .about-hero-particles {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    .about-hero-particle {
        position: absolute;
        background: rgba(251, 198, 12, 0.1);
        border-radius: 50%;
    }

    .about-hero-particle:nth-child(1) {
        width: 300px;
        height: 300px;
        top: -100px;
        right: -100px;
        animation: float 8s ease-in-out infinite;
    }

    @media (max-width: 768px) {
        .about-hero-particle:nth-child(1) {
            width: 200px;
            height: 200px;
            top: -50px;
            right: -50px;
        }
    }

    .about-hero-particle:nth-child(2) {
        width: 200px;
        height: 200px;
        bottom: -50px;
        left: -50px;
        background: rgba(90, 209, 228, 0.1);
        animation: float 10s ease-in-out infinite reverse;
    }

    @media (max-width: 768px) {
        .about-hero-particle:nth-child(2) {
            width: 150px;
            height: 150px;
            bottom: -30px;
            left: -30px;
        }
    }

    .about-hero-particle:nth-child(3) {
        width: 150px;
        height: 150px;
        top: 30%;
        left: 20%;
        background: rgba(235, 215, 137, 0.1);
        animation: float 12s ease-in-out infinite;
    }

    @media (max-width: 768px) {
        .about-hero-particle:nth-child(3) {
            width: 100px;
            height: 100px;
        }
    }

    .about-hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
        max-width: 800px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .about-hero-badge {
        display: inline-block;
        padding: 8px 20px;
        background: rgba(254, 253, 254, 0.2);
        border-radius: var(--radius-full);
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 25px;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(251, 198, 12, 0.3);
        color: var(--pure-white);
    }

    @media (max-width: 576px) {
        .about-hero-badge {
            font-size: 0.8rem;
            padding: 6px 16px;
            margin-bottom: 20px;
        }
    }

    .about-hero-title {
        font-size: clamp(2rem, 8vw, 4rem);
        font-weight: 800;
        margin-bottom: 20px;
        line-height: 1.1;
        text-shadow: 0 2px 10px rgba(10, 29, 68, 0.3);
    }

    @media (max-width: 576px) {
        .about-hero-title {
            margin-bottom: 15px;
        }
    }

    .about-hero-title span {
        color: var(--bright-amber);
    }

    .about-hero-text {
        font-size: clamp(1rem, 3vw, 1.3rem);
        opacity: 0.95;
        line-height: 1.8;
        color: var(--ivory);
        max-width: 600px;
        margin: 0 auto;
    }

    @media (max-width: 576px) {
        .about-hero-text {
            line-height: 1.6;
        }
    }

    /* Mission Section */
    .mission-section {
        padding: 80px 0;
        background: var(--pure-white);
    }

    @media (max-width: 768px) {
        .mission-section {
            padding: 60px 0;
        }
    }

    @media (max-width: 576px) {
        .mission-section {
            padding: 50px 0;
        }
    }

    .mission-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: center;
    }

    @media (max-width: 992px) {
        .mission-grid {
            gap: 40px;
        }
    }

    @media (max-width: 768px) {
        .mission-grid {
            grid-template-columns: 1fr;
            gap: 40px;
        }
    }

    .mission-content {
        padding-right: 40px;
    }

    @media (max-width: 768px) {
        .mission-content {
            padding-right: 0;
        }
    }

    .mission-subtitle {
        color: var(--bright-amber);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 0.9rem;
        margin-bottom: 15px;
        display: block;
    }

    @media (max-width: 576px) {
        .mission-subtitle {
            font-size: 0.8rem;
            letter-spacing: 1px;
        }
    }

    .mission-title {
        font-size: clamp(1.8rem, 5vw, 2.5rem);
        font-weight: 800;
        margin-bottom: 25px;
        line-height: 1.2;
        color: var(--prussian-blue);
    }

    .mission-title span {
        color: var(--bright-amber);
    }

    .mission-text {
        color: var(--text-muted);
        line-height: 1.8;
        margin-bottom: 20px;
        font-size: 1.1rem;
    }

    @media (max-width: 768px) {
        .mission-text {
            font-size: 1rem;
        }
    }

    .mission-stats {
        display: flex;
        gap: 40px;
        margin-top: 40px;
    }

    @media (max-width: 768px) {
        .mission-stats {
            justify-content: center;
            gap: 30px;
        }
    }

    @media (max-width: 576px) {
        .mission-stats {
            flex-direction: column;
            gap: 20px;
            align-items: center;
        }
    }

    .mission-stat {
        text-align: center;
    }

    .mission-stat-number {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--prussian-blue);
        margin-bottom: 5px;
    }

    @media (max-width: 576px) {
        .mission-stat-number {
            font-size: 2rem;
        }
    }

    .mission-stat-label {
        color: var(--text-muted);
        font-size: 0.95rem;
    }

    .mission-image {
        position: relative;
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-lg);
    }

    .mission-image img {
        width: 100%;
        height: auto;
        display: block;
        transition: var(--transition-slow);
    }

    .mission-image:hover img {
        transform: scale(1.05);
    }

    .mission-image-badge {
        position: absolute;
        bottom: 30px;
        left: 30px;
        background: var(--gradient-2);
        color: var(--prussian-blue);
        padding: 15px 25px;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-lg);
        animation: float 6s ease-in-out infinite;
        border: 2px solid rgba(251, 198, 12, 0.3);
    }

    @media (max-width: 576px) {
        .mission-image-badge {
            bottom: 15px;
            left: 15px;
            padding: 10px 15px;
        }
    }

    .mission-image-badge i {
        font-size: 2rem;
        margin-bottom: 5px;
        color: var(--prussian-blue);
    }

    @media (max-width: 576px) {
        .mission-image-badge i {
            font-size: 1.5rem;
        }
    }

    .mission-image-badge span {
        display: block;
        font-weight: 600;
    }

    @media (max-width: 576px) {
        .mission-image-badge span {
            font-size: 0.9rem;
        }
    }

    /* Values Section */
    .values-section {
        padding: 80px 0;
        background: var(--ivory);
    }

    @media (max-width: 768px) {
        .values-section {
            padding: 60px 0;
        }
    }

    @media (max-width: 576px) {
        .values-section {
            padding: 50px 0;
        }
    }

    .section-header {
        text-align: center;
        margin-bottom: 50px;
        padding: 0 20px;
    }

    @media (max-width: 768px) {
        .section-header {
            margin-bottom: 35px;
        }
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

    @media (max-width: 576px) {
        .section-subtitle {
            font-size: 0.8rem;
            letter-spacing: 1px;
        }
    }

    .section-title {
        font-size: clamp(1.8rem, 5vw, 2.5rem);
        font-weight: 800;
        margin-bottom: 15px;
        color: var(--prussian-blue);
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

    @media (max-width: 768px) {
        .section-description {
            font-size: 1rem;
        }
    }

    .values-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        margin-top: 50px;
        padding: 0 20px;
    }

    @media (max-width: 768px) {
        .values-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
    }

    @media (max-width: 576px) {
        .values-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
    }

    .value-card {
        background: var(--pure-white);
        padding: 40px 30px;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        transition: var(--transition);
        text-align: center;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(251, 198, 12, 0.1);
        height: 100%;
    }

    @media (max-width: 768px) {
        .value-card {
            padding: 30px 20px;
        }
    }

    .value-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: var(--gradient-2);
        transform: translateX(-100%);
        transition: var(--transition);
    }

    .value-card:hover::before {
        transform: translateX(0);
    }

    .value-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-hover);
        border-color: var(--bright-amber);
    }

    .value-icon {
        width: 80px;
        height: 80px;
        background: var(--gradient-1);
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px;
        color: var(--pure-white);
        font-size: 2rem;
        transition: var(--transition);
    }

    @media (max-width: 768px) {
        .value-icon {
            width: 70px;
            height: 70px;
            font-size: 1.8rem;
            margin-bottom: 20px;
        }
    }

    .value-card:hover .value-icon {
        transform: scale(1.1);
        background: var(--gradient-2);
        color: var(--prussian-blue);
    }

    .value-title {
        font-size: 1.3rem;
        margin-bottom: 15px;
        font-weight: 700;
        color: var(--prussian-blue);
    }

    @media (max-width: 768px) {
        .value-title {
            font-size: 1.2rem;
            margin-bottom: 12px;
        }
    }

    .value-text {
        color: var(--text-muted);
        line-height: 1.6;
        font-size: 0.95rem;
    }

    /* Story Section */
    .story-section {
        padding: 80px 0;
        background: var(--pure-white);
    }

    @media (max-width: 768px) {
        .story-section {
            padding: 60px 0;
        }
    }

    @media (max-width: 576px) {
        .story-section {
            padding: 50px 0;
        }
    }

    .story-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: center;
    }

    @media (max-width: 992px) {
        .story-grid {
            gap: 40px;
        }
    }

    @media (max-width: 768px) {
        .story-grid {
            grid-template-columns: 1fr;
            gap: 40px;
        }
    }

    .story-image {
        position: relative;
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-lg);
    }

    .story-image img {
        width: 100%;
        height: auto;
        display: block;
        transition: var(--transition-slow);
    }

    .story-image:hover img {
        transform: scale(1.05);
    }

    .story-image::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(10, 29, 68, 0.2) 0%, rgba(24, 56, 110, 0.2) 100%);
        z-index: 1;
    }

    .story-content {
        padding-left: 40px;
    }

    @media (max-width: 768px) {
        .story-content {
            padding-left: 0;
        }
    }

    .story-title {
        font-size: clamp(1.8rem, 5vw, 2.5rem);
        font-weight: 800;
        margin-bottom: 25px;
        line-height: 1.2;
        color: var(--prussian-blue);
    }

    .story-title span {
        color: var(--bright-amber);
    }

    .story-text {
        color: var(--text-muted);
        line-height: 1.8;
        margin-bottom: 20px;
        font-size: 1.1rem;
    }

    @media (max-width: 768px) {
        .story-text {
            font-size: 1rem;
        }
    }

    .story-quote {
        margin: 30px 0;
        padding: 20px 30px;
        background: var(--ivory);
        border-radius: var(--radius-lg);
        position: relative;
        font-style: italic;
        border-left: 4px solid var(--bright-amber);
    }

    @media (max-width: 576px) {
        .story-quote {
            padding: 15px 20px;
            margin: 20px 0;
        }
    }

    .story-quote i {
        position: absolute;
        top: 20px;
        left: 20px;
        font-size: 2rem;
        color: var(--bright-amber);
        opacity: 0.2;
    }

    @media (max-width: 576px) {
        .story-quote i {
            font-size: 1.5rem;
            top: 15px;
            left: 15px;
        }
    }

    .story-quote p {
        margin-left: 30px;
        font-size: 1.1rem;
        color: var(--prussian-blue);
    }

    @media (max-width: 576px) {
        .story-quote p {
            margin-left: 25px;
            font-size: 1rem;
        }
    }

    /* Services Section - IMPROVED CARD ALIGNMENT */
    .services-section {
        padding: 80px 0;
        background: var(--ivory);
    }

    @media (max-width: 768px) {
        .services-section {
            padding: 60px 0;
        }
    }

    @media (max-width: 576px) {
        .services-section {
            padding: 50px 0;
        }
    }

    .services-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        margin-top: 50px;
        padding: 0 20px;
    }

    @media (max-width: 992px) {
        .services-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
    }

    @media (max-width: 768px) {
        .services-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
    }

    .service-card {
        background: var(--pure-white);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-md);
        transition: var(--transition);
        height: 100%;
        display: flex;
        flex-direction: column;
        border: 1px solid rgba(251, 198, 12, 0.1);
    }

    .service-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-hover);
        border-color: var(--bright-amber);
    }

    .service-header {
        background: var(--gradient-1);
        color: var(--pure-white);
        padding: 30px 25px;
        position: relative;
        overflow: hidden;
        min-height: 160px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    @media (max-width: 768px) {
        .service-header {
            padding: 25px 20px;
            min-height: 140px;
        }
    }

    .service-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200px;
        height: 200px;
        background: rgba(251, 198, 12, 0.1);
        border-radius: 50%;
        animation: float 8s ease-in-out infinite;
    }

    .service-icon {
        font-size: 2.5rem;
        margin-bottom: 15px;
        position: relative;
        z-index: 1;
        color: var(--bright-amber);
    }

    @media (max-width: 768px) {
        .service-icon {
            font-size: 2rem;
            margin-bottom: 10px;
        }
    }

    .service-header h3 {
        font-size: 1.4rem;
        margin-bottom: 8px;
        position: relative;
        z-index: 1;
        line-height: 1.3;
        color: var(--pure-white);
    }

    @media (max-width: 768px) {
        .service-header h3 {
            font-size: 1.2rem;
        }
    }

    .service-header p {
        opacity: 0.9;
        font-size: 0.9rem;
        position: relative;
        z-index: 1;
        color: var(--ivory);
    }

    .service-body {
        padding: 30px 25px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    @media (max-width: 768px) {
        .service-body {
            padding: 25px 20px;
        }
    }

    .service-features {
        list-style: none;
        margin-bottom: 25px;
        flex: 1;
    }

    .service-features li {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 16px;
        color: var(--text-muted);
        font-size: 0.95rem;
        line-height: 1.5;
    }

    @media (max-width: 768px) {
        .service-features li {
            font-size: 0.9rem;
            margin-bottom: 12px;
        }
    }

    .service-features li i {
        color: var(--bright-amber);
        font-size: 1rem;
        margin-top: 3px;
        flex-shrink: 0;
    }

    .service-features li span {
        flex: 1;
    }

    .service-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 12px 25px;
        background: var(--gradient-1);
        color: var(--pure-white);
        border-radius: var(--radius-full);
        font-weight: 600;
        font-size: 0.95rem;
        transition: var(--transition);
        text-align: center;
        margin-top: auto;
        align-self: flex-start;
        text-decoration: none;
        border: 1px solid transparent;
        width: 100%;
        max-width: 200px;
    }

    @media (max-width: 576px) {
        .service-btn {
            max-width: 100%;
            padding: 12px 20px;
        }
    }

    .service-btn:hover {
        background: var(--gradient-2);
        color: var(--prussian-blue);
        transform: translateX(5px);
        box-shadow: var(--shadow-hover);
        border-color: var(--bright-amber);
    }

    .service-btn i {
        margin-left: 8px;
        transition: transform 0.3s ease;
    }

    .service-btn:hover i {
        transform: translateX(5px);
    }

    /* NEO Section */
    .neo-section {
        padding: 80px 0;
        background: var(--pure-white);
    }

    @media (max-width: 768px) {
        .neo-section {
            padding: 60px 0;
        }
    }

    @media (max-width: 576px) {
        .neo-section {
            padding: 50px 0;
        }
    }

    .neo-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: center;
    }

    @media (max-width: 992px) {
        .neo-grid {
            gap: 40px;
        }
    }

    @media (max-width: 768px) {
        .neo-grid {
            grid-template-columns: 1fr;
            gap: 40px;
        }
    }

    .neo-content {
        padding-right: 20px;
    }

    @media (max-width: 768px) {
        .neo-content {
            padding-right: 0;
        }
    }

    .neo-subtitle {
        color: var(--bright-amber);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 0.9rem;
        margin-bottom: 15px;
        display: block;
    }

    .neo-title {
        font-size: clamp(1.8rem, 5vw, 2.5rem);
        font-weight: 800;
        margin-bottom: 25px;
        line-height: 1.2;
        color: var(--prussian-blue);
    }

    .neo-title span {
        color: var(--bright-amber);
    }

    .neo-text {
        color: var(--text-muted);
        line-height: 1.8;
        margin-bottom: 20px;
        font-size: 1.1rem;
    }

    @media (max-width: 768px) {
        .neo-text {
            font-size: 1rem;
        }
    }

    .neo-features {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
        margin: 30px 0;
    }

    @media (max-width: 768px) {
        .neo-features {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }
    }

    @media (max-width: 576px) {
        .neo-features {
            grid-template-columns: 1fr;
            gap: 10px;
        }
    }

    .neo-feature {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .neo-feature i {
        color: var(--bright-amber);
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .neo-feature span {
        color: var(--prussian-blue);
        font-size: 0.95rem;
    }

    .neo-image {
        position: relative;
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-lg);
    }

    .neo-image img {
        width: 100%;
        height: auto;
        display: block;
        transition: var(--transition-slow);
    }

    .neo-image:hover img {
        transform: scale(1.05);
    }

    .neo-badge {
        position: absolute;
        top: 30px;
        right: 30px;
        background: var(--gradient-2);
        color: var(--prussian-blue);
        padding: 15px 20px;
        border-radius: var(--radius-lg);
        display: flex;
        align-items: center;
        gap: 10px;
        animation: float 6s ease-in-out infinite;
        border: 2px solid rgba(251, 198, 12, 0.3);
    }

    @media (max-width: 576px) {
        .neo-badge {
            top: 15px;
            right: 15px;
            padding: 10px 15px;
        }
    }

    .neo-badge i {
        font-size: 1.5rem;
        color: var(--prussian-blue);
    }

    @media (max-width: 576px) {
        .neo-badge i {
            font-size: 1.2rem;
        }
    }

    .neo-badge span {
        font-weight: 600;
    }

    @media (max-width: 576px) {
        .neo-badge span {
            font-size: 0.9rem;
        }
    }

    /* Team Section */
    .team-section {
        padding: 80px 0;
        background: var(--ivory);
    }

    @media (max-width: 768px) {
        .team-section {
            padding: 60px 0;
        }
    }

    @media (max-width: 576px) {
        .team-section {
            padding: 50px 0;
        }
    }

    .team-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 30px;
        margin-top: 50px;
        padding: 0 20px;
    }

    @media (max-width: 768px) {
        .team-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
    }

    @media (max-width: 576px) {
        .team-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
    }

    .team-card {
        background: var(--pure-white);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-md);
        transition: var(--transition);
        text-align: center;
        border: 1px solid rgba(251, 198, 12, 0.1);
        height: 100%;
    }

    .team-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-hover);
        border-color: var(--bright-amber);
    }

    .team-image {
        position: relative;
        overflow: hidden;
        aspect-ratio: 1;
    }

    .team-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition-slow);
    }

    .team-card:hover .team-image img {
        transform: scale(1.1);
    }

    .team-social {
        position: absolute;
        bottom: -50px;
        left: 0;
        width: 100%;
        display: flex;
        justify-content: center;
        gap: 10px;
        padding: 15px;
        background: linear-gradient(to top, rgba(10, 29, 68, 0.9), transparent);
        transition: var(--transition);
    }

    .team-card:hover .team-social {
        bottom: 0;
    }

    .team-social a {
        width: 35px;
        height: 35px;
        background: var(--pure-white);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--prussian-blue);
        transition: var(--transition);
        text-decoration: none;
    }

    .team-social a:hover {
        background: var(--bright-amber);
        color: var(--prussian-blue);
        transform: translateY(-3px);
    }

    @media (max-width: 576px) {
        .team-social a {
            width: 32px;
            height: 32px;
            font-size: 0.9rem;
        }
    }

    .team-info {
        padding: 25px 20px;
    }

    @media (max-width: 768px) {
        .team-info {
            padding: 20px 15px;
        }
    }

    .team-name {
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 5px;
        color: var(--prussian-blue);
    }

    @media (max-width: 768px) {
        .team-name {
            font-size: 1.1rem;
        }
    }

    .team-position {
        color: var(--bright-amber);
        font-size: 0.9rem;
        font-weight: 500;
        margin-bottom: 10px;
    }

    .team-bio {
        color: var(--text-muted);
        font-size: 0.9rem;
        line-height: 1.6;
    }

    /* CTA Section */
    .about-cta {
        padding: 80px 0;
        background: var(--gradient-1);
        color: var(--pure-white);
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    @media (max-width: 768px) {
        .about-cta {
            padding: 60px 0;
        }
    }

    @media (max-width: 576px) {
        .about-cta {
            padding: 50px 0;
        }
    }

    .about-cta::before {
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

    .about-cta::after {
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

    .about-cta-content {
        position: relative;
        z-index: 2;
        max-width: 700px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .about-cta h2 {
        font-size: clamp(1.8rem, 5vw, 3rem);
        margin-bottom: 20px;
        color: var(--pure-white);
    }

    .about-cta h2 span {
        color: var(--bright-amber);
    }

    .about-cta p {
        font-size: 1.2rem;
        opacity: 0.95;
        margin-bottom: 30px;
        color: var(--ivory);
    }

    @media (max-width: 768px) {
        .about-cta p {
            font-size: 1.1rem;
        }
    }

    @media (max-width: 576px) {
        .about-cta p {
            font-size: 1rem;
        }
    }

    .about-cta-buttons {
        display: flex;
        gap: 20px;
        justify-content: center;
        flex-wrap: wrap;
    }

    @media (max-width: 576px) {
        .about-cta-buttons {
            flex-direction: column;
            gap: 15px;
        }
    }

    .about-cta-buttons .btn {
        min-width: 200px;
        padding: 14px 28px;
    }

    @media (max-width: 576px) {
        .about-cta-buttons .btn {
            min-width: auto;
            width: 100%;
            padding: 12px 24px;
        }
    }

    .about-cta-buttons .btn-primary {
        background: var(--gradient-2);
        color: var(--prussian-blue);
        border: 2px solid transparent;
    }

    .about-cta-buttons .btn-primary:hover {
        background: transparent;
        color: var(--pure-white);
        border: 2px solid var(--bright-amber);
        transform: translateY(-3px);
    }

    .about-cta-buttons .btn-secondary {
        border: 2px solid var(--pure-white);
        color: var(--pure-white);
        background: transparent;
    }

    .about-cta-buttons .btn-secondary:hover {
        background: var(--pure-white);
        color: var(--prussian-blue);
        border-color: var(--pure-white);
        transform: translateY(-3px);
    }

    /* Container Padding for Mobile */
    .container {
        padding-left: 20px;
        padding-right: 20px;
    }

    @media (max-width: 576px) {
        .container {
            padding-left: 15px;
            padding-right: 15px;
        }
    }

    /* Button Styles */
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 28px;
        border-radius: var(--radius-full);
        font-weight: 600;
        font-size: 1rem;
        transition: var(--transition);
        text-decoration: none;
        cursor: pointer;
        border: 2px solid transparent;
    }

    @media (max-width: 576px) {
        .btn {
            padding: 10px 24px;
            font-size: 0.95rem;
        }
    }

    .btn-primary {
        background: var(--gradient-2);
        color: var(--prussian-blue);
    }

    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-hover);
        background: var(--gradient-2);
    }

    .btn-secondary {
        border: 2px solid var(--prussian-blue);
        color: var(--prussian-blue);
        background: transparent;
    }

    .btn-secondary:hover {
        background: var(--prussian-blue);
        color: var(--pure-white);
        transform: translateY(-3px);
        box-shadow: var(--shadow-hover);
    }

    /* Animation pauses on hover for accessibility */
    .service-header::before,
    .mission-image-badge,
    .neo-badge,
    .about-hero-particle {
        animation-play-state: running;
    }

    @media (prefers-reduced-motion: reduce) {
        .service-header::before,
        .mission-image-badge,
        .neo-badge,
        .about-hero-particle,
        .value-card,
        .service-card,
        .team-card,
        .btn {
            animation: none;
            transition: none;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="about-hero">
    <div class="about-hero-particles">
        <div class="about-hero-particle"></div>
        <div class="about-hero-particle"></div>
        <div class="about-hero-particle"></div>
    </div>

    <div class="container">
        <div class="about-hero-content" data-aos="fade-up">
            <span class="about-hero-badge">{{ App\Helpers\TranslationHelper::trans('about.hero_badge') }}</span>
            <h1 class="about-hero-title">{!! App\Helpers\TranslationHelper::trans('about.hero_title') !!}</h1>
            <p class="about-hero-text">
                {{ App\Helpers\TranslationHelper::trans('about.hero_description') }}
            </p>
        </div>
    </div>
</section>

<!-- Mission Section -->
<section class="mission-section">
    <div class="container">
        <div class="mission-grid">
            <div class="mission-content" data-aos="fade-right">
                <span class="mission-subtitle">{{ App\Helpers\TranslationHelper::trans('about.mission_subtitle') }}</span>
                <h2 class="mission-title">{!! App\Helpers\TranslationHelper::trans('about.mission_title') !!}</h2>
                <p class="mission-text">
                    {{ App\Helpers\TranslationHelper::trans('about.mission_text_1') }}
                </p>
                <p class="mission-text">
                    {{ App\Helpers\TranslationHelper::trans('about.mission_text_2') }}
                </p>

                <div class="mission-stats">
                    <div class="mission-stat">
                        <div class="mission-stat-number">10K+</div>
                        <div class="mission-stat-label">{{ App\Helpers\TranslationHelper::trans('about.mission_stat_1') }}</div>
                    </div>
                    <div class="mission-stat">
                        <div class="mission-stat-number">50+</div>
                        <div class="mission-stat-label">{{ App\Helpers\TranslationHelper::trans('about.mission_stat_2') }}</div>
                    </div>
                    <div class="mission-stat">
                        <div class="mission-stat-number">15+</div>
                        <div class="mission-stat-label">{{ App\Helpers\TranslationHelper::trans('about.mission_stat_3') }}</div>
                    </div>
                </div>
            </div>

            <div class="mission-image" data-aos="fade-left">
                <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="{{ App\Helpers\TranslationHelper::trans('about.mission_subtitle') }}" loading="lazy">
                <div class="mission-image-badge">
                    <i class="fas fa-robot"></i>
                    <span>{{ App\Helpers\TranslationHelper::trans('about.mission_badge') }}</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="values-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-subtitle">{{ App\Helpers\TranslationHelper::trans('about.values_subtitle') }}</span>
            <h2 class="section-title">{!! App\Helpers\TranslationHelper::trans('about.values_title') !!}</h2>
            <p class="section-description">
                {{ App\Helpers\TranslationHelper::trans('about.values_description') }}
            </p>
        </div>

        <div class="values-grid">
            <div class="value-card" data-aos="fade-up" data-aos-delay="100">
                <div class="value-icon">
                    <i class="fas fa-heart"></i>
                </div>
                <h3 class="value-title">{{ App\Helpers\TranslationHelper::trans('about.value_1_title') }}</h3>
                <p class="value-text">{{ App\Helpers\TranslationHelper::trans('about.value_1_text') }}</p>
            </div>

            <div class="value-card" data-aos="fade-up" data-aos-delay="200">
                <div class="value-icon">
                    <i class="fas fa-lightbulb"></i>
                </div>
                <h3 class="value-title">{{ App\Helpers\TranslationHelper::trans('about.value_2_title') }}</h3>
                <p class="value-text">{{ App\Helpers\TranslationHelper::trans('about.value_2_text') }}</p>
            </div>

            <div class="value-card" data-aos="fade-up" data-aos-delay="300">
                <div class="value-icon">
                    <i class="fas fa-handshake"></i>
                </div>
                <h3 class="value-title">{{ App\Helpers\TranslationHelper::trans('about.value_3_title') }}</h3>
                <p class="value-text">{{ App\Helpers\TranslationHelper::trans('about.value_3_text') }}</p>
            </div>

            <div class="value-card" data-aos="fade-up" data-aos-delay="400">
                <div class="value-icon">
                    <i class="fas fa-globe"></i>
                </div>
                <h3 class="value-title">{{ App\Helpers\TranslationHelper::trans('about.value_4_title') }}</h3>
                <p class="value-text">{{ App\Helpers\TranslationHelper::trans('about.value_4_text') }}</p>
            </div>

            <div class="value-card" data-aos="fade-up" data-aos-delay="500">
                <div class="value-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3 class="value-title">{{ App\Helpers\TranslationHelper::trans('about.value_5_title') }}</h3>
                <p class="value-text">{{ App\Helpers\TranslationHelper::trans('about.value_5_text') }}</p>
            </div>

            <div class="value-card" data-aos="fade-up" data-aos-delay="600">
                <div class="value-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3 class="value-title">{{ App\Helpers\TranslationHelper::trans('about.value_6_title') }}</h3>
                <p class="value-text">{{ App\Helpers\TranslationHelper::trans('about.value_6_text') }}</p>
            </div>
        </div>
    </div>
</section>

<!-- Story Section -->
<section class="story-section">
    <div class="container">
        <div class="story-grid">
            <div class="story-image" data-aos="fade-right">
                <img src="https://images.unsplash.com/photo-1557804506-669a67965ba0?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="{{ App\Helpers\TranslationHelper::trans('about.story_subtitle') }}" loading="lazy">
            </div>

            <div class="story-content" data-aos="fade-left">
                <span class="section-subtitle">{{ App\Helpers\TranslationHelper::trans('about.story_subtitle') }}</span>
                <h2 class="story-title">{!! App\Helpers\TranslationHelper::trans('about.story_title') !!}</h2>
                <p class="story-text">
                    {{ App\Helpers\TranslationHelper::trans('about.story_text_1') }}
                </p>
                <p class="story-text">
                    {{ App\Helpers\TranslationHelper::trans('about.story_text_2') }}
                </p>

                <div class="story-quote">
                    <i class="fas fa-quote-left"></i>
                    <p>
                        {{ App\Helpers\TranslationHelper::trans('about.story_quote') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section - IMPROVED WITH PROPERLY ALIGNED CARDS -->
<section class="services-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-subtitle">{{ App\Helpers\TranslationHelper::trans('about.services_subtitle') }}</span>
            <h2 class="section-title">{!! App\Helpers\TranslationHelper::trans('about.services_title') !!}</h2>
            <p class="section-description">
                {{ App\Helpers\TranslationHelper::trans('about.services_description') }}
            </p>
        </div>

        <div class="services-grid">
            <!-- Service 1: Language Programs -->
            <div class="service-card" data-aos="fade-up" data-aos-delay="100">
                <div class="service-header">
                    <div class="service-icon">
                        <i class="fas fa-language"></i>
                    </div>
                    <h3>{{ App\Helpers\TranslationHelper::trans('about.service_1_title') }}</h3>
                    <p>{{ App\Helpers\TranslationHelper::trans('about.service_1_subtitle') }}</p>
                </div>
                <div class="service-body">
                    <ul class="service-features">
                        <li><i class="fas fa-check-circle"></i> <span>{{ App\Helpers\TranslationHelper::trans('about.service_1_feature_1') }}</span></li>
                        <li><i class="fas fa-check-circle"></i> <span>{{ App\Helpers\TranslationHelper::trans('about.service_1_feature_2') }}</span></li>
                        <li><i class="fas fa-check-circle"></i> <span>{{ App\Helpers\TranslationHelper::trans('about.service_1_feature_3') }}</span></li>
                        <li><i class="fas fa-check-circle"></i> <span>{{ App\Helpers\TranslationHelper::trans('about.service_1_feature_4') }}</span></li>
                        <li><i class="fas fa-check-circle"></i> <span>{{ App\Helpers\TranslationHelper::trans('about.service_1_feature_5') }}</span></li>
                    </ul>
                    <a href="{{ route('courses') }}" class="service-btn">{{ App\Helpers\TranslationHelper::trans('about.service_1_btn') }} <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>

            <!-- Service 2: Customer Service Training -->
            <div class="service-card" data-aos="fade-up" data-aos-delay="200">
                <div class="service-header">
                    <div class="service-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3>{{ App\Helpers\TranslationHelper::trans('about.service_2_title') }}</h3>
                    <p>{{ App\Helpers\TranslationHelper::trans('about.service_2_subtitle') }}</p>
                </div>
                <div class="service-body">
                    <ul class="service-features">
                        <li><i class="fas fa-check-circle"></i> <span>{{ App\Helpers\TranslationHelper::trans('about.service_2_feature_1') }}</span></li>
                        <li><i class="fas fa-check-circle"></i> <span>{{ App\Helpers\TranslationHelper::trans('about.service_2_feature_2') }}</span></li>
                        <li><i class="fas fa-check-circle"></i> <span>{{ App\Helpers\TranslationHelper::trans('about.service_2_feature_3') }}</span></li>
                        <li><i class="fas fa-check-circle"></i> <span>{{ App\Helpers\TranslationHelper::trans('about.service_2_feature_4') }}</span></li>
                        <li><i class="fas fa-check-circle"></i> <span>{{ App\Helpers\TranslationHelper::trans('about.service_2_feature_5') }}</span></li>
                    </ul>
                    <a href="{{ route('courses') }}" class="service-btn">{{ App\Helpers\TranslationHelper::trans('about.service_2_btn') }} <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>

            <!-- Service 3: Digital Business Skills -->
            <div class="service-card" data-aos="fade-up" data-aos-delay="300">
                <div class="service-header">
                    <div class="service-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>{{ App\Helpers\TranslationHelper::trans('about.service_3_title') }}</h3>
                    <p>{{ App\Helpers\TranslationHelper::trans('about.service_3_subtitle') }}</p>
                </div>
                <div class="service-body">
                    <ul class="service-features">
                        <li><i class="fas fa-check-circle"></i> <span>{{ App\Helpers\TranslationHelper::trans('about.service_3_feature_1') }}</span></li>
                        <li><i class="fas fa-check-circle"></i> <span>{{ App\Helpers\TranslationHelper::trans('about.service_3_feature_2') }}</span></li>
                        <li><i class="fas fa-check-circle"></i> <span>{{ App\Helpers\TranslationHelper::trans('about.service_3_feature_3') }}</span></li>
                        <li><i class="fas fa-check-circle"></i> <span>{{ App\Helpers\TranslationHelper::trans('about.service_3_feature_4') }}</span></li>
                        <li><i class="fas fa-check-circle"></i> <span>{{ App\Helpers\TranslationHelper::trans('about.service_3_feature_5') }}</span></li>
                    </ul>
                    <a href="{{ route('courses') }}" class="service-btn">{{ App\Helpers\TranslationHelper::trans('about.service_3_btn') }} <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- NEO-EDTECH Section -->
<section class="neo-section">
    <div class="container">
        <div class="neo-grid">
            <div class="neo-content" data-aos="fade-right">
                <span class="neo-subtitle">{{ App\Helpers\TranslationHelper::trans('about.neo_subtitle') }}</span>
                <h2 class="neo-title">{!! App\Helpers\TranslationHelper::trans('about.neo_title') !!}</h2>
                <p class="neo-text">
                    {{ App\Helpers\TranslationHelper::trans('about.neo_text_1') }}
                </p>
                <p class="neo-text">
                    {{ App\Helpers\TranslationHelper::trans('about.neo_text_2') }}
                </p>
                <div class="neo-features">
                    <div class="neo-feature">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ App\Helpers\TranslationHelper::trans('about.neo_feature_1') }}</span>
                    </div>
                    <div class="neo-feature">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ App\Helpers\TranslationHelper::trans('about.neo_feature_2') }}</span>
                    </div>
                    <div class="neo-feature">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ App\Helpers\TranslationHelper::trans('about.neo_feature_3') }}</span>
                    </div>
                    <div class="neo-feature">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ App\Helpers\TranslationHelper::trans('about.neo_feature_4') }}</span>
                    </div>
                </div>
                <a href="{{ route('neo-ed-tech') }}" class="btn btn-primary">
                    {{ App\Helpers\TranslationHelper::trans('about.neo_btn') }} <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div class="neo-image" data-aos="fade-left">
                <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="{{ App\Helpers\TranslationHelper::trans('about.neo_subtitle') }}" loading="lazy">
                <div class="neo-badge">
                    <i class="fas fa-robot"></i>
                    <span>{{ App\Helpers\TranslationHelper::trans('about.neo_badge') }}</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->


<!-- CTA Section -->
<section class="about-cta">
    <div class="container">
        <div class="about-cta-content" data-aos="zoom-in">
            <h2>{!! App\Helpers\TranslationHelper::trans('about.cta_title') !!}</h2>
            <p>{{ App\Helpers\TranslationHelper::trans('about.cta_description') }}</p>
            <div class="about-cta-buttons">
                <a href="{{ route('academy') }}" class="btn btn-primary">
                    <i class="fas fa-graduation-cap"></i> {{ App\Helpers\TranslationHelper::trans('about.cta_btn_academy') }}
                </a>
                <a href="{{ route('contact') }}" class="btn btn-secondary">
                    <i class="fas fa-headset"></i> {{ App\Helpers\TranslationHelper::trans('about.cta_btn_contact') }}
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // AOS initialization with mobile optimization
        if (typeof AOS !== 'undefined') {
            AOS.init({
                duration: window.innerWidth < 768 ? 400 : 800,
                once: true,
                offset: window.innerWidth < 768 ? 20 : 50,
                disable: window.innerWidth < 576 // Disable on very small screens for performance
            });
        }

        // Handle touch events for mobile
        if ('ontouchstart' in window) {
            const touchElements = document.querySelectorAll('.btn, .service-btn, .team-social a, .value-card, .service-card, .team-card');
            
            touchElements.forEach(element => {
                element.addEventListener('touchstart', function() {
                    this.style.opacity = '0.8';
                }, { passive: true });
                
                element.addEventListener('touchend', function() {
                    this.style.opacity = '1';
                }, { passive: true });
                
                element.addEventListener('touchcancel', function() {
                    this.style.opacity = '1';
                }, { passive: true });
            });
        }

        // Animation pause for users who prefer reduced motion
        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        
        if (prefersReducedMotion) {
            const animatedElements = document.querySelectorAll('.service-header::before, .mission-image-badge, .neo-badge, .about-hero-particle');
            
            animatedElements.forEach(element => {
                if (element.style) {
                    element.style.animation = 'none';
                    element.style.transition = 'none';
                }
            });
        }

        // Lazy loading for images
        if ('loading' in HTMLImageElement.prototype) {
            // Browser supports native lazy loading
            const images = document.querySelectorAll('img[loading="lazy"]');
            images.forEach(img => {
                img.loading = 'lazy';
            });
        }

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                
                if (href !== '#') {
                    e.preventDefault();
                    
                    const target = document.querySelector(href);
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                }
            });
        });

        // Header scroll effect
        const header = document.querySelector('header');
        
        if (header) {
            let scrollTimeout;
            
            window.addEventListener('scroll', function() {
                if (!scrollTimeout) {
                    scrollTimeout = setTimeout(function() {
                        if (window.scrollY > 50) {
                            header.classList.add('scrolled');
                        } else {
                            header.classList.remove('scrolled');
                        }
                        scrollTimeout = null;
                    }, 10);
                }
            });
        }

        // Team social links hover effect for touch devices
        const teamSocialLinks = document.querySelectorAll('.team-social a');
        
        teamSocialLinks.forEach(link => {
            link.addEventListener('touchstart', function() {
                this.style.transform = 'translateY(-3px)';
            }, { passive: true });
            
            link.addEventListener('touchend', function() {
                this.style.transform = 'translateY(0)';
            }, { passive: true });
        });
    });

    // Window resize handler for AOS
    let resizeTimeout;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(function() {
            if (typeof AOS !== 'undefined') {
                if (window.innerWidth < 576) {
                    AOS.init({ disable: true });
                } else {
                    AOS.init({ 
                        disable: false,
                        duration: window.innerWidth < 768 ? 400 : 800,
                        offset: window.innerWidth < 768 ? 20 : 50
                    });
                }
            }
        }, 250);
    });
</script>
@endpush