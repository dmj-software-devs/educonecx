<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5, user-scalable=yes">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'EDUCONECX - Learn Connect Grow Together')</title>
    <meta name="description" content="@yield('meta_description', 'EDUCONECX is an international AI-powered educational platform that empowers learners worldwide with practical language and digital business skills.')">

    <link rel="canonical" href="{{ url()->current() }}" />
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Montserrat:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Custom Styles -->
    @stack('styles')

    <style>
        :root {
            /* Your Beautiful Logo Colors - Liquid Theme */
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
            --primary-dark: #0A1D44;
            --primary-light: #2E5C61;
            --secondary: var(--sky-blue);
            --accent: var(--bright-amber);
            --accent-soft: var(--light-gold);
            --success: #5AD1E4;
            --warning: #FBC60C;
            --danger: #EBD789;
            --dark: var(--prussian-blue);
            --dark-light: var(--regal-navy);
            --gray: var(--khaki-beige);
            --gray-light: var(--pale-slate);
            --light: var(--ivory);
            --white: var(--pure-white);
            --black: #0A1D44;
            
            /* Text Colors - Fixed for better visibility */
            --text-on-dark: #FFFFFF;
            --text-on-light: #0A1D44;
            --text-muted: #5f5f5f;
            --text-highlight: #FBC60C;
            
            /* Liquid Gradients - Adjusted for better contrast */
            --gradient-liquid-1: linear-gradient(135deg, #0A1D44 0%, #18386E 50%, #2E5C61 100%);
            --gradient-liquid-2: linear-gradient(45deg, #FBC60C 0%, #EBD789 50%, #F9F7E9 100%);
            --gradient-liquid-3: linear-gradient(135deg, #5AD1E4 0%, #CBD1DA 50%, #FEFDFE 100%);
            --gradient-liquid-4: linear-gradient(225deg, #0A1D44 0%, #2E5C61 50%, #5AD1E4 100%);
            
            /* Hero-specific gradients */
            --gradient-hero: linear-gradient(135deg, #0A1D44 0%, #18386E 70%, #2E5C61 100%);
            --gradient-hero-overlay: linear-gradient(135deg, rgba(10, 29, 68, 0.9) 0%, rgba(24, 56, 110, 0.8) 100%);
            
            /* Liquid Effects */
            --shadow-liquid: 0 20px 40px -15px rgba(10, 29, 68, 0.3);
            --shadow-liquid-hover: 0 30px 50px -15px rgba(251, 198, 12, 0.3);
            --shadow-liquid-glow: 0 0 30px rgba(90, 209, 228, 0.3);
            
            /* Border Radius */
            --border-radius-sm: 12px;
            --border-radius-md: 20px;
            --border-radius-lg: 30px;
            --border-radius-xl: 40px;
            --border-radius-full: 9999px;
            --border-radius-liquid: 40% 60% 30% 70% / 50% 40% 60% 50%;
            
            /* Transitions */
            --transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            --transition-liquid: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
            font-size: 16px;
            overflow-x: hidden;
            width: 100%;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-on-light);
            line-height: 1.6;
            overflow-x: hidden;
            width: 100%;
            position: relative;
            background-color: var(--pure-white);
        }

        /* Typography - Fixed for better readability */
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            line-height: 1.2;
        }

        /* Hero section specific typography - NO gradients on hero */
        .hero-title, .hero-section h1, .hero-section .display-1 {
            color: var(--text-on-dark) !important;
            background: none !important;
            -webkit-background-clip: unset !important;
            -webkit-text-fill-color: unset !important;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .hero-section .hero-title-gradient {
            color: var(--bright-amber) !important;
            background: none !important;
            -webkit-background-clip: unset !important;
            -webkit-text-fill-color: unset !important;
        }

        .hero-section p, .hero-text {
            color: var(--text-on-dark) !important;
            opacity: 0.95;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        }

        /* Regular headings - gradient only for non-hero sections */
        .section-title, .card-title {
            background: var(--gradient-liquid-1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        a {
            text-decoration: none;
            color: inherit;
            transition: var(--transition);
        }

        img {
            max-width: 100%;
            height: auto;
            display: block;
        }

        .container {
            width: 100%;
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 30px;
        }

        @media (max-width: 768px) {
            .container {
                padding: 0 20px;
            }
        }
        
        @media (max-width: 576px) {
            .container {
                padding: 0 15px;
            }
        }

        /* Liquid Background Elements - Fixed z-index */
        .liquid-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
            opacity: 0.6;
        }

        .liquid-blob {
            position: absolute;
            filter: blur(80px);
            opacity: 0.2;
            animation: liquid-float 20s infinite alternate ease-in-out;
        }

        .liquid-blob-1 {
            top: -10%;
            left: -10%;
            width: 600px;
            height: 600px;
            background: var(--bright-amber);
            border-radius: 62% 38% 42% 58% / 37% 53% 47% 63%;
            animation: liquid-morph-1 18s infinite alternate;
        }

        .liquid-blob-2 {
            bottom: -10%;
            right: -10%;
            width: 700px;
            height: 700px;
            background: var(--sky-blue);
            border-radius: 33% 67% 48% 52% / 44% 31% 69% 56%;
            animation: liquid-morph-2 22s infinite alternate;
        }

        .liquid-blob-3 {
            top: 40%;
            right: 20%;
            width: 400px;
            height: 400px;
            background: var(--light-gold);
            border-radius: 67% 33% 59% 41% / 57% 43% 57% 43%;
            animation: liquid-morph-3 25s infinite alternate;
        }

        .liquid-blob-4 {
            bottom: 20%;
            left: 15%;
            width: 500px;
            height: 500px;
            background: var(--prussian-blue);
            opacity: 0.15;
            border-radius: 44% 56% 31% 69% / 58% 29% 71% 42%;
            animation: liquid-morph-4 30s infinite alternate;
        }

        @keyframes liquid-morph-1 {
            0% { border-radius: 62% 38% 42% 58% / 37% 53% 47% 63%; transform: translate(0, 0) rotate(0deg); }
            100% { border-radius: 33% 67% 58% 42% / 53% 41% 59% 47%; transform: translate(100px, 50px) rotate(20deg); }
        }

        @keyframes liquid-morph-2 {
            0% { border-radius: 33% 67% 48% 52% / 44% 31% 69% 56%; transform: translate(0, 0) rotate(0deg); }
            100% { border-radius: 67% 33% 31% 69% / 48% 62% 38% 52%; transform: translate(-80px, -80px) rotate(-15deg); }
        }

        @keyframes liquid-morph-3 {
            0% { border-radius: 67% 33% 59% 41% / 57% 43% 57% 43%; transform: translate(0, 0) scale(1); }
            100% { border-radius: 41% 59% 33% 67% / 43% 62% 38% 57%; transform: translate(60px, -40px) scale(1.2); }
        }

        @keyframes liquid-morph-4 {
            0% { border-radius: 44% 56% 31% 69% / 58% 29% 71% 42%; transform: translate(0, 0) scale(1); }
            100% { border-radius: 56% 44% 69% 31% / 42% 71% 29% 58%; transform: translate(-50px, 30px) scale(0.9); }
        }

        @keyframes liquid-float {
            0% { transform: translate(0, 0); }
            100% { transform: translate(30px, -30px); }
        }

        /* Liquid Typography - Only for non-hero sections */
        .display-1:not(.hero-title), 
        .display-2:not(.hero-title), 
        .section-title:not(.hero-title) {
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 100px;
            height: 4px;
            background: var(--gradient-liquid-2);
            border-radius: var(--border-radius-liquid);
            animation: liquid-line 4s infinite alternate;
        }

        @keyframes liquid-line {
            0% { width: 100px; border-radius: 40% 60% 30% 70% / 50% 40% 60% 50%; }
            100% { width: 150px; border-radius: 60% 40% 70% 30% / 40% 60% 40% 60%; }
        }

        .text-gradient:not(.hero-title-gradient) {
            background: var(--gradient-liquid-1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .text-liquid:not(.hero-title-gradient) {
            background: linear-gradient(135deg, var(--bright-amber), var(--sky-blue), var(--prussian-blue));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            background-size: 200% 200%;
            animation: liquid-text 8s ease infinite;
        }

        @keyframes liquid-text {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Liquid Buttons - Fixed for better visibility */
        .btn {
            display: inline-block;
            padding: 14px 36px;
            border-radius: var(--border-radius-liquid);
            font-weight: 600;
            font-size: 1rem;
            text-align: center;
            cursor: pointer;
            transition: var(--transition-liquid);
            border: none;
            position: relative;
            overflow: hidden;
            z-index: 1;
            background: var(--gradient-liquid-2);
            color: var(--prussian-blue);
            box-shadow: var(--shadow-liquid);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.8s, height 0.8s;
            z-index: -1;
        }

        .btn:hover::before {
            width: 400px;
            height: 400px;
        }

        .btn:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: var(--shadow-liquid-hover);
        }

        .btn-primary {
            background: var(--gradient-liquid-2);
            color: var(--prussian-blue);
        }

        .btn-secondary {
            background: transparent;
            color: var(--pure-white);
            border: 2px solid var(--bright-amber);
        }

        .btn-secondary::before {
            background: var(--gradient-liquid-2);
        }

        .btn-secondary:hover {
            color: var(--prussian-blue);
            border-color: var(--light-gold);
        }

        .btn-outline {
            background: transparent;
            border: 2px solid var(--pale-slate);
            color: var(--regal-navy);
        }

        .btn-outline:hover {
            border-color: var(--sky-blue);
            color: var(--prussian-blue);
            background: rgba(90, 209, 228, 0.1);
        }

        /* Hero Section - Fixed for better contrast */
        .hero-section {
            background: var(--gradient-hero);
            position: relative;
            color: var(--pure-white);
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--gradient-hero-overlay);
            z-index: 1;
        }

        .hero-section .container {
            position: relative;
            z-index: 2;
        }

        .hero-section .hero-content {
            color: var(--pure-white);
        }

        /* Liquid Cards */
        .card {
            background: rgba(254, 253, 254, 0.9);
            backdrop-filter: blur(10px);
            border-radius: var(--border-radius-liquid);
            overflow: hidden;
            box-shadow: var(--shadow-liquid);
            transition: var(--transition-liquid);
            height: 100%;
            border: 1px solid rgba(251, 198, 12, 0.2);
            position: relative;
        }

        .card::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: var(--gradient-liquid-2);
            border-radius: var(--border-radius-liquid);
            opacity: 0;
            transition: opacity 0.4s;
            z-index: -1;
        }

        .card:hover {
            transform: translateY(-15px) scale(1.02);
            box-shadow: var(--shadow-liquid-hover);
            background: rgba(254, 253, 254, 0.95);
        }

        .card:hover::before {
            opacity: 0.3;
        }

        .card-image {
            position: relative;
            overflow: hidden;
            aspect-ratio: 16/9;
            border-radius: var(--border-radius-liquid) var(--border-radius-liquid) 0 0;
        }

        .card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition-liquid);
        }

        .card:hover .card-image img {
            transform: scale(1.15) rotate(2deg);
        }

        .card-content {
            padding: 28px;
        }

        .card-title {
            color: var(--prussian-blue);
            margin-bottom: 12px;
        }

        .card-text {
            color: var(--text-muted);
        }

        /* Liquid Badges */
        .badge {
            display: inline-block;
            padding: 6px 16px;
            border-radius: var(--border-radius-liquid);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background: var(--gradient-liquid-2);
            color: var(--prussian-blue);
            border: 1px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(5px);
        }

        .badge-primary {
            background: var(--gradient-liquid-1);
            color: var(--pure-white);
        }

        .badge-accent {
            background: var(--gradient-liquid-2);
        }

        .badge-success {
            background: var(--gradient-liquid-3);
        }

        /* Liquid Animations */
        @keyframes liquid-wave {
            0% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-20px) scale(1.05); }
            100% { transform: translateY(0) scale(1); }
        }

        @keyframes liquid-pulse {
            0% { opacity: 0.3; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.1); }
            100% { opacity: 0.3; transform: scale(1); }
        }

        .animate-liquid-float {
            animation: liquid-wave 8s ease-in-out infinite;
        }

        .animate-liquid-pulse {
            animation: liquid-pulse 6s ease-in-out infinite;
        }

        /* Glassmorphism */
        .glass-liquid {
            background: rgba(254, 253, 254, 0.2);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(251, 198, 12, 0.2);
            border-radius: var(--border-radius-liquid);
            box-shadow: var(--shadow-liquid);
        }

        .glass-liquid-dark {
            background: rgba(10, 29, 68, 0.2);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(90, 209, 228, 0.2);
            border-radius: var(--border-radius-liquid);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 12px;
        }

        ::-webkit-scrollbar-track {
            background: var(--pale-slate);
            border-radius: var(--border-radius-full);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--gradient-liquid-1);
            border-radius: var(--border-radius-full);
            border: 3px solid var(--pale-slate);
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--gradient-liquid-2);
        }

        /* Loading Spinner */
        .spinner-liquid {
            width: 50px;
            height: 50px;
            border-radius: var(--border-radius-liquid);
            border: 4px solid var(--pale-slate);
            border-top-color: var(--bright-amber);
            border-right-color: var(--sky-blue);
            border-bottom-color: var(--prussian-blue);
            animation: spin-liquid 1.5s infinite linear;
        }

        @keyframes spin-liquid {
            0% { transform: rotate(0deg) scale(1); border-radius: var(--border-radius-liquid); }
            50% { transform: rotate(180deg) scale(1.1); border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; }
            100% { transform: rotate(360deg) scale(1); border-radius: var(--border-radius-liquid); }
        }

        /* Translation Loading Indicator */
        .global-translation-loading {
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--gradient-liquid-2);
            color: var(--prussian-blue);
            padding: 14px 28px;
            border-radius: var(--border-radius-liquid);
            box-shadow: var(--shadow-liquid);
            z-index: 9999;
            display: none;
            align-items: center;
            gap: 14px;
            font-weight: 600;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: slideInLiquid 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            max-width: calc(100% - 40px);
        }

        .global-translation-loading.show {
            display: flex;
        }

        .global-translation-loading i {
            animation: spin-liquid 1.5s infinite linear;
        }

        .global-translation-loading.timeout {
            background: var(--gradient-liquid-1);
            color: var(--pure-white);
        }

        @keyframes slideInLiquid {
            0% { transform: translateX(100%) scale(0.8); opacity: 0; }
            100% { transform: translateX(0) scale(1); opacity: 1; }
        }

        /* Grid */
        .grid {
            display: grid;
            gap: 30px;
            width: 100%;
        }

        .grid-2, .grid-3, .grid-4 {
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        }

        /* Inputs */
        input, textarea, select {
            width: 100%;
            padding: 14px 20px;
            border: 2px solid var(--pale-slate);
            border-radius: var(--border-radius-liquid);
            font-family: 'Inter', sans-serif;
            font-size: 1rem;
            transition: var(--transition-liquid);
            background: rgba(254, 253, 254, 0.8);
            backdrop-filter: blur(5px);
        }

        input:focus, textarea:focus, select:focus {
            outline: none;
            border-color: var(--sky-blue);
            box-shadow: var(--shadow-liquid-glow);
            transform: scale(1.02);
        }

        /* Navigation */
        .nav-liquid {
            background: rgba(254, 253, 254, 0.2);
            backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(251, 198, 12, 0.2);
            border-radius: 0 0 var(--border-radius-liquid) var(--border-radius-liquid);
        }

        .nav-liquid a {
            position: relative;
            padding: 10px 0;
        }

        .nav-liquid a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 3px;
            background: var(--gradient-liquid-2);
            border-radius: var(--border-radius-liquid);
            transition: width 0.4s ease;
        }

        .nav-liquid a:hover::after,
        .nav-liquid a.active::after {
            width: 100%;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .global-translation-loading {
                top: 15px;
                right: 15px;
                padding: 12px 22px;
            }
            
            .btn {
                padding: 12px 28px;
            }
            
            .card-content {
                padding: 20px;
            }
        }
        
        @media (max-width: 576px) {
            .global-translation-loading {
                top: 10px;
                right: 10px;
                left: 10px;
                width: auto;
                padding: 12px 20px;
                justify-content: center;
            }
            
            .btn {
                padding: 10px 24px;
                width: 100%;
                text-align: center;
            }
            
            .card-content {
                padding: 16px;
            }
            
            .display-1 {
                font-size: 2.5rem;
            }
            
            .display-2 {
                font-size: 2rem;
            }
        }
        
        @media (max-width: 375px) {
            .global-translation-loading {
                padding: 10px 16px;
                font-size: 0.9rem;
            }
        }

        /* Dividers */
        .liquid-divider {
            height: 4px;
            background: var(--gradient-liquid-2);
            border-radius: var(--border-radius-liquid);
            margin: 40px 0;
            animation: liquid-pulse 4s infinite;
        }

        /* Fix for white space */
        @media (max-width: 1024px) {
            body, html {
                overflow-x: hidden;
                width: 100%;
                position: relative;
            }
        }
        
        @media (max-width: 768px) {
            body.menu-open {
                overflow: hidden;
                position: fixed;
                width: 100%;
                height: 100%;
            }
        }

        /* Hero Section Helper Classes */
        .hero-section .text-white {
            color: var(--pure-white) !important;
        }

        .hero-section .text-amber {
            color: var(--bright-amber) !important;
        }

        .hero-section h1, 
        .hero-section h2, 
        .hero-section h3 {
            color: var(--pure-white) !important;
        }

        /* Fix for any hero content that might inherit gradient */
        [class*="hero"] h1:not(.text-gradient),
        [class*="hero"] h2:not(.text-gradient),
        [class*="hero"] .display-1:not(.text-gradient),
        [class*="hero"] .display-2:not(.text-gradient) {
            background: none !important;
            -webkit-background-clip: unset !important;
            -webkit-text-fill-color: unset !important;
            color: var(--pure-white) !important;
        }

        /* Translation specific styles */
        .translate-text {
            transition: opacity 0.3s ease;
        }

        .translate-text.translating {
            opacity: 0.7;
        }

        .no-translate {
            /* Elements with this class won't be translated */
        }
    </style>
</head>

<body>
    <!-- Liquid Background Elements -->
    <div class="liquid-bg">
        <div class="liquid-blob liquid-blob-1"></div>
        <div class="liquid-blob liquid-blob-2"></div>
        <div class="liquid-blob liquid-blob-3"></div>
        <div class="liquid-blob liquid-blob-4"></div>
    </div>

    <!-- Global Translation Loading Indicator -->
    <div class="global-translation-loading" id="globalTranslationLoading">
        <i class="fas fa-spinner"></i>
        <span>Translating page...</span>
    </div>

    @include('layouts.header')

    <main>
        @yield('content')
    </main>

    @include('layouts.footer')

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- Initialize AOS -->
    <script>
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100,
            easing: 'cubic-bezier(0.34, 1.56, 0.64, 1)'
        });
    </script>

    <!-- Global Translation System - Enhanced -->
    <script>
        // Translation API endpoint
        const TRANSLATE_API_URL = "{{ route('translate') }}";

        // Current language (will be set from server)
        let currentLanguage = '{{ app()->getLocale() }}';

        // Cache for translations
        const translationCache = new Map();

        // Store original texts for all translatable elements
        let translatableElements = [];

        // Flag to prevent multiple simultaneous translations
        let isTranslating = false;

        // Store the base English texts
        let englishTexts = new Map();

        // Language display mapping
        const languageDisplay = {
            'en': { flag: '🇺🇸', code: 'EN', name: 'English' },
            'es': { flag: '🇪🇸', code: 'ES', name: 'Español' },
            'fr': { flag: '🇫🇷', code: 'FR', name: 'Français' },
            'de': { flag: '🇩🇪', code: 'DE', name: 'Deutsch' },
            'it': { flag: '🇮🇹', code: 'IT', name: 'Italiano' },
            'pt': { flag: '🇵🇹', code: 'PT', name: 'Português' },
            'zh': { flag: '🇨🇳', code: 'ZH', name: '中文' }
        };

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize translatable elements
            initializeTranslatableElements();
            
            // Store English texts as base
            storeEnglishTexts();

            // Auto-translate if current language is not English
            if (currentLanguage !== 'en') {
                // Small delay to ensure DOM is fully ready
                setTimeout(() => {
                    translatePage(currentLanguage);
                }, 100);
            }

            // Update language display in header
            updateLanguageDisplay(currentLanguage);
        });

        // Store all original English texts
        function storeEnglishTexts() {
            translatableElements.forEach(item => {
                if (item.element && item.baseOriginal) {
                    englishTexts.set(item.element, item.baseOriginal);
                }
            });
            console.log('English texts stored:', englishTexts.size);
        }

        // Update language display in header
        function updateLanguageDisplay(lang) {
            const display = languageDisplay[lang] || languageDisplay['en'];
            const flagEl = document.getElementById('currentFlag');
            const langEl = document.getElementById('currentLang');
            
            if (flagEl) flagEl.textContent = display.flag;
            if (langEl) langEl.textContent = display.code;
        }

        // Initialize all translatable elements and preserve original texts
        function initializeTranslatableElements() {
            translatableElements = [];

            // Find all elements with text content that should be translated
            const selectors = [
                'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
                'p', 'span:not(.no-translate):not(.flag):not(.current-flag):not(.current-lang):not(.user-name)',
                'a:not(.no-translate):not(.btn):not(.lang-btn):not(.user-btn):not(.menu-toggle)',
                '.btn', '.section-title', '.card-title', '.card-text',
                '.nav-menu a', '.contact-info a', '.footer-links a',
                'label', '.badge', '.alert', '.hero-title', '.hero-subtitle',
                '.mobile-nav-list a', '.mobile-section-title', '.mobile-guest span',
                '.mobile-contact a', '.auth-buttons a'
            ];

            selectors.forEach(selector => {
                document.querySelectorAll(selector).forEach(element => {
                    // Skip elements that should not be translated
                    if (element.closest('.language-selector') ||
                        element.closest('.user-menu') ||
                        element.closest('.profile-dropdown') ||
                        element.classList.contains('no-translate') ||
                        element.classList.contains('flag') ||
                        element.classList.contains('current-flag') ||
                        element.classList.contains('current-lang') ||
                        element.classList.contains('user-name') ||
                        element.id === 'currentFlag' ||
                        element.id === 'currentLang' ||
                        element.id === 'langBtn') {
                        return;
                    }

                    // Skip elements with no text or only whitespace
                    const text = element.textContent?.trim();
                    if (!text || text.length < 2) return;

                    // Skip elements that contain only numbers or special characters
                    if (/^[\d\s\W]+$/.test(text)) return;

                    // Skip elements that have the translate-text class already
                    if (element.classList.contains('translate-text')) {
                        // Get the original text from data-original
                        let originalText = element.getAttribute('data-original');
                        if (!originalText) {
                            originalText = text;
                            element.setAttribute('data-original', text);
                        }
                        
                        // Store base English text
                        if (!element.hasAttribute('data-base-original')) {
                            element.setAttribute('data-base-original', text);
                        }

                        translatableElements.push({
                            element: element,
                            original: originalText,
                            baseOriginal: element.getAttribute('data-base-original')
                        });
                        return;
                    }

                    // For elements without translate-text class, add it
                    element.classList.add('translate-text');
                    
                    // Get the original text
                    let originalText = element.getAttribute('data-original');
                    
                    // If no data-original attribute, use current text and store it
                    if (!originalText) {
                        originalText = text;
                        element.setAttribute('data-original', text);
                    }
                    
                    // Store base English text
                    if (!element.hasAttribute('data-base-original')) {
                        element.setAttribute('data-base-original', text);
                    }

                    // Add to translatable elements
                    translatableElements.push({
                        element: element,
                        original: originalText,
                        baseOriginal: element.getAttribute('data-base-original')
                    });
                });
            });

            console.log('Translatable elements found:', translatableElements.length);
        }

        // Translate the entire page
        async function translatePage(targetLang) {
            if (isTranslating) return;
            isTranslating = true;

            // Show loading indicator
            const loadingEl = document.getElementById('globalTranslationLoading');
            if (loadingEl) {
                loadingEl.classList.add('show');
                loadingEl.classList.remove('timeout');
                loadingEl.innerHTML = '<i class="fas fa-spinner"></i><span>Translating page...</span>';
            }

            // Add translating class to all translatable elements
            translatableElements.forEach(item => {
                if (item.element) {
                    item.element.classList.add('translating');
                }
            });

            // Set a timeout to show warning if translation takes too long
            const timeoutId = setTimeout(() => {
                if (loadingEl) {
                    loadingEl.classList.add('timeout');
                    loadingEl.innerHTML = '<i class="fas fa-exclamation-triangle"></i><span>Translation taking longer than expected...</span>';
                }
            }, 8000);

            try {
                // Update session silently
                fetch(`/language/${targetLang}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                }).catch(err => console.log('Session update error:', err));

                console.log(`Translating page from ${currentLanguage} to ${targetLang}`);
                console.log(`Elements to translate: ${translatableElements.length}`);

                // Use base English texts as source for translation
                const textsToTranslate = translatableElements.map(item => item.baseOriginal).filter(text => text && text.trim().length >= 2);

                if (textsToTranslate.length === 0) {
                    console.log('No elements to translate');
                    return true;
                }

                // Perform batch translation
                const translatedTexts = await translateBatch(textsToTranslate, 'en', targetLang);

                // Apply translations
                let appliedCount = 0;
                let translationIndex = 0;
                
                translatableElements.forEach((item, index) => {
                    if (item.element && item.baseOriginal && item.baseOriginal.trim().length >= 2) {
                        const translated = translatedTexts[translationIndex];
                        translationIndex++;
                        
                        if (translated && translated.trim().length > 0) {
                            const currentContent = item.element.textContent;
                            
                            // Only update if the translation is different
                            if (translated !== currentContent) {
                                item.element.textContent = translated;
                                item.element.setAttribute('data-original', translated);
                                appliedCount++;
                                
                                // Log first few translations for debugging
                                if (appliedCount <= 5) {
                                    console.log(`Element ${index}: "${currentContent}" -> "${translated}"`);
                                }
                            }
                        }
                    }
                });

                // Update current language
                currentLanguage = targetLang;
                
                // Update language display in header
                updateLanguageDisplay(targetLang);

                console.log(`Translation complete: ${appliedCount}/${translatableElements.length} elements updated`);
                
                return true;

            } catch (error) {
                console.error('Page translation error:', error);
                throw error;
            } finally {
                clearTimeout(timeoutId);
                
                // Remove translating class
                translatableElements.forEach(item => {
                    if (item.element) {
                        item.element.classList.remove('translating');
                    }
                });
                
                if (loadingEl) {
                    loadingEl.classList.remove('show', 'timeout');
                }
                isTranslating = false;
            }
        }

        // Batch translate multiple texts
        async function translateBatch(texts, sourceLang, targetLang) {
            if (texts.length === 0) return [];
            if (sourceLang === targetLang) return texts;

            // Check cache
            const uncachedIndices = [];
            const uncachedTexts = [];
            const results = new Array(texts.length);

            texts.forEach((text, index) => {
                const cacheKey = `${text}_${sourceLang}_${targetLang}`;
                if (translationCache.has(cacheKey)) {
                    results[index] = translationCache.get(cacheKey);
                } else if (text && text.trim().length >= 2) {
                    uncachedIndices.push(index);
                    uncachedTexts.push(text);
                } else {
                    results[index] = text;
                }
            });

            if (uncachedTexts.length === 0) {
                return results;
            }

            try {
                console.log(`Translating ${uncachedTexts.length} texts to ${targetLang}...`);

                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                
                if (!csrfToken) {
                    console.error('CSRF token not found');
                    uncachedIndices.forEach((idx, i) => results[idx] = uncachedTexts[i]);
                    return results;
                }

                const response = await fetch(TRANSLATE_API_URL, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        q: uncachedTexts,
                        source: sourceLang,
                        target: targetLang,
                        batch: true
                    })
                });

                if (!response.ok) {
                    throw new Error(`Translation failed: ${response.status}`);
                }

                const data = await response.json();
                console.log(`Received ${data.translatedTexts?.length || 0} translations`);

                if (data.translatedTexts && Array.isArray(data.translatedTexts)) {
                    data.translatedTexts.forEach((translated, idx) => {
                        const originalIndex = uncachedIndices[idx];
                        results[originalIndex] = translated;

                        // Cache the result
                        const cacheKey = `${uncachedTexts[idx]}_${sourceLang}_${targetLang}`;
                        translationCache.set(cacheKey, translated);
                    });
                } else {
                    uncachedIndices.forEach((idx, i) => results[idx] = uncachedTexts[i]);
                }

                return results;
            } catch (error) {
                console.error('Batch translation error:', error);
                uncachedIndices.forEach((idx, i) => results[idx] = uncachedTexts[i]);
                return results;
            }
        }

        // Reset to English
        window.resetToEnglish = function() {
            translatableElements.forEach(item => {
                if (item.element && item.baseOriginal) {
                    item.element.textContent = item.baseOriginal;
                    item.element.setAttribute('data-original', item.baseOriginal);
                }
            });
            currentLanguage = 'en';
            
            // Update language display
            updateLanguageDisplay('en');
            
            console.log('Reset to English');
        };

        // Debug function
        window.testTranslation = async function() {
            console.log('Testing translation API...');
            console.log('Current language:', currentLanguage);
            console.log('Elements:', translatableElements.length);
            
            try {
                const response = await fetch(TRANSLATE_API_URL, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        q: 'Hello world',
                        source: 'en',
                        target: 'es',
                        batch: false
                    })
                });
                
                const data = await response.json();
                console.log('Test translation:', data);
            } catch (error) {
                console.error('Test error:', error);
            }
        };

        // Force refresh translatable elements (useful for dynamically loaded content)
        window.refreshTranslatableElements = function() {
            initializeTranslatableElements();
            storeEnglishTexts();
            console.log('Translatable elements refreshed:', translatableElements.length);
        };

        // Expose for debugging
        window.translationSystem = {
            translatePage,
            resetToEnglish: window.resetToEnglish,
            currentLanguage: () => currentLanguage,
            elements: () => translatableElements.length,
            refresh: window.refreshTranslatableElements,
            test: window.testTranslation,
            apiUrl: TRANSLATE_API_URL
        };

        console.log('Translation system initialized. Current language:', currentLanguage);
    </script>

    @stack('scripts')
</body>

</html>