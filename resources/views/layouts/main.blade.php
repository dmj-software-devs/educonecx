<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5, user-scalable=yes">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'EDUCONECX - Learn Connect Grow Together')</title>
    
    <!-- Favicon - Browser Tab Logo -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('favicon/android-chrome-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('favicon/android-chrome-512x512.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon/apple-touch-icon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon/favicon.ico') }}" type="image/x-icon">
    <link rel="manifest" href="{{ asset('favicon/site.webmanifest') }}">
    <meta name="theme-color" content="#0A1D44">

    <meta name="description" content="@yield('meta_description', 'EDUCONECX is an international interactive educational platform that empowers learners worldwide with practical language and digital business skills.')">

    <!-- Google / Search Engine Tags -->
    <meta itemprop="name" content="@yield('title', 'EDUCONECX - Learn Connect Grow Together')">
    <meta itemprop="description" content="@yield('meta_description', 'EDUCONECX is an international interactive educational platform that empowers learners worldwide with practical language and digital business skills.')">
    <meta itemprop="image" content="@yield('meta_og_image', asset('images/logo.jpg'))">

    <!-- Facebook Meta Tags -->
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title', 'EDUCONECX - Learn Connect Grow Together')">
    <meta property="og:description" content="@yield('meta_description', 'EDUCONECX is an international interactive educational platform that empowers learners worldwide with practical language and digital business skills.')">
    <meta property="og:image" content="@yield('meta_og_image', asset('images/logo.jpg'))">

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'EDUCONECX - Learn Connect Grow Together')">
    <meta name="twitter:description" content="@yield('meta_description', 'EDUCONECX is an international interactive educational platform that empowers learners worldwide with practical language and digital business skills.')">
    <meta name="twitter:image" content="@yield('meta_og_image', asset('images/logo.jpg'))">

    <link rel="canonical" href="{{ url()->current() }}" />
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <!-- Google Fonts - Preconnect and load efficiently -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Montserrat:wght@500;600;700;800&display=swap" rel="stylesheet" media="print" onload="this.media='all'">

    <!-- Bootstrap CSS - Load with media print then switch -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" media="print" onload="this.media='all'">

    <!-- Font Awesome 6 - Load with media print then switch -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" media="print" onload="this.media='all'">

    <!-- AOS Animation Library - Load with media print then switch -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" media="print" onload="this.media='all'">
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
            --success: #10b981;
            --warning: #FBC60C;
            --danger: #ef4444;
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

            /* Notification Gradients */
            --gradient-notification-success: linear-gradient(135deg, #10b981 0%, #059669 100%);
            --gradient-notification-error: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            --gradient-notification-warning: linear-gradient(135deg, #FBC60C 0%, #EBD789 100%);
            --gradient-notification-info: linear-gradient(135deg, #5AD1E4 0%, #CBD1DA 100%);

            /* Hero-specific gradients */
            --gradient-hero: linear-gradient(135deg, #0A1D44 0%, #18386E 70%, #2E5C61 100%);
            --gradient-hero-overlay: linear-gradient(135deg, rgba(10, 29, 68, 0.9) 0%, rgba(24, 56, 110, 0.8) 100%);

            /* Liquid Effects */
            --shadow-liquid: 0 20px 40px -15px rgba(10, 29, 68, 0.3);
            --shadow-liquid-hover: 0 30px 50px -15px rgba(251, 198, 12, 0.3);
            --shadow-liquid-glow: 0 0 30px rgba(90, 209, 228, 0.3);
            --shadow-notification: 0 20px 40px -10px rgba(0, 0, 0, 0.2);

            /* Border Radius */
            --border-radius-sm: 12px;
            --border-radius-md: 20px;
            --border-radius-lg: 30px;
            --border-radius-xl: 40px;
            --border-radius-full: 9999px;
            --border-radius-liquid: 40% 60% 30% 70% / 50% 40% 60% 50%;

            /* Transitions - Reduced motion preferences */
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --transition-liquid: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
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

        @media (max-width: 768px) {
            html {
                font-size: 14px;
            }
        }

        /* Typography - Fixed for better readability */
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            line-height: 1.2;
        }

        /* Hero section specific typography - NO gradients on hero */
        .hero-title,
        .hero-section h1,
        .hero-section .display-1 {
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

        .hero-section p,
        .hero-text {
            color: var(--text-on-dark) !important;
            opacity: 0.95;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        }

        /* Regular headings - gradient only for non-hero sections */
        .section-title,
        .card-title {
            background: var(--gradient-liquid-1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        @media (max-width: 768px) {
            .section-title {
                font-size: 1.8rem;
            }
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

        /* OPTIMIZED: Liquid Background Elements - Reduced to 2 blobs, smaller size, lower opacity */
        .liquid-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
            opacity: 0.3;
            /* Reduced from 0.6 */
            pointer-events: none;
            will-change: transform;
            /* Performance hint */
        }

        .liquid-blob {
            position: absolute;
            filter: blur(60px);
            /* Reduced from 80px */
            opacity: 0.15;
            /* Reduced from 0.2 */
            animation: none;
            /* REMOVED continuous animations - they're too heavy */
            transform: translateZ(0);
            /* Force GPU acceleration */
            backface-visibility: hidden;
        }

        /* OPTIMIZED: Only 2 blobs instead of 4 */
        .liquid-blob-1 {
            top: -5%;
            left: -5%;
            width: 400px;
            /* Reduced from 600px */
            height: 400px;
            /* Reduced from 600px */
            background: var(--bright-amber);
            border-radius: 62% 38% 42% 58% / 37% 53% 47% 63%;
        }

        .liquid-blob-2 {
            bottom: -5%;
            right: -5%;
            width: 500px;
            /* Reduced from 700px */
            height: 500px;
            /* Reduced from 700px */
            background: var(--sky-blue);
            border-radius: 33% 67% 48% 52% / 44% 31% 69% 56%;
        }

        /* REMOVED: liquid-blob-3 and liquid-blob-4 */

        @media (max-width: 768px) {
            .liquid-blob {
                filter: blur(40px);
                /* Reduced from 50px */
            }

            .liquid-blob-1 {
                width: 250px;
                /* Reduced from 300px */
                height: 250px;
                /* Reduced from 300px */
            }

            .liquid-blob-2 {
                width: 300px;
                /* Reduced from 350px */
                height: 300px;
                /* Reduced from 350px */
            }
        }

        /* OPTIMIZED: Removed all complex morph animations */
        /* Kept only simple fade animations for subtle effects */

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
            animation: none;
            /* REMOVED liquid-line animation */
        }

        @media (max-width: 768px) {
            .section-title::after {
                width: 60px;
                height: 3px;
            }
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
            animation: none;
            /* REMOVED liquid-text animation */
        }

        /* Liquid Buttons - Fixed for better visibility */
        .btn {
            display: inline-block;
            padding: 14px 36px;
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
            transition: width 0.6s, height 0.6s;
            /* Reduced from 0.8s */
            z-index: -1;
        }

        .btn:hover::before {
            width: 400px;
            height: 400px;
        }

        .btn:hover {
            transform: translateY(-3px) scale(1.01);
            /* Reduced from -5px and 1.02 */
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

        @media (max-width: 768px) {
            .btn {
                padding: 12px 28px;
                font-size: 0.95rem;
            }
        }

        @media (max-width: 576px) {
            .btn {
                padding: 10px 24px;
                width: 100%;
                text-align: center;
            }
        }

        /* Hero Section - Fixed for better contrast */
        .hero-section {
            background: var(--gradient-hero);
            position: relative;
            color: var(--pure-white);
            min-height: 60vh;
            display: flex;
            align-items: center;
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

        @media (max-width: 768px) {
            .hero-section {
                min-height: 50vh;
                padding: 40px 0;
            }
        }

        /* Liquid Cards */
        .card {
            background: rgba(254, 253, 254, 0.9);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: var(--border-radius-liquid);
            overflow: hidden;
            box-shadow: var(--shadow-liquid);
            transition: var(--transition-liquid);
            height: 100%;
            border: 1px solid rgba(251, 198, 12, 0.2);
            position: relative;
            transform: translateZ(0);
            /* GPU acceleration */
            will-change: transform;
            /* Performance hint */
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
            transition: opacity 0.3s;
            /* Reduced from 0.4s */
            z-index: -1;
        }

        .card:hover {
            transform: translateY(-8px) scale(1.01);
            /* Reduced from -15px and 1.02 */
            box-shadow: var(--shadow-liquid-hover);
            background: rgba(254, 253, 254, 0.95);
        }

        .card:hover::before {
            opacity: 0.2;
            /* Reduced from 0.3 */
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
            transition: transform 0.5s;
            /* Reduced from var(--transition-liquid) */
        }

        .card:hover .card-image img {
            transform: scale(1.08) rotate(1deg);
            /* Reduced from 1.15 and 2deg */
        }

        .card-content {
            padding: 28px;
        }

        @media (max-width: 768px) {
            .card-content {
                padding: 20px;
            }
        }

        @media (max-width: 576px) {
            .card-content {
                padding: 16px;
            }
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

        /* ========== NOTIFICATION STYLES ========== */
        .edu-notification-wrapper {
            max-width: 1280px;
            margin: 0 auto;
            padding: 20px 30px 0;
            position: relative;
            z-index: 100;
        }

        @media (max-width: 768px) {
            .edu-notification-wrapper {
                padding: 15px 20px 0;
            }
        }

        @media (max-width: 576px) {
            .edu-notification-wrapper {
                padding: 10px 15px 0;
            }
        }

        .edu-notification {
            border-radius: var(--border-radius-lg);
            padding: 16px 20px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: var(--shadow-notification);
            position: relative;
            overflow: hidden;
            animation: edu-notification-slide 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(8px);
            /* Reduced from 10px */
            color: white;
        }

        .edu-notification::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(90deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0) 100%);
            z-index: 0;
        }

        .edu-notification-content {
            display: flex;
            align-items: center;
            gap: 16px;
            position: relative;
            z-index: 1;
            flex: 1;
        }

        .edu-notification-icon {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            backdrop-filter: blur(3px);
            /* Reduced from 5px */
            flex-shrink: 0;
        }

        .edu-notification-message {
            font-weight: 500;
            font-size: 15px;
            line-height: 1.5;
            flex: 1;
        }

        .edu-notification-close {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.15);
            border: none;
            color: white;
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            position: relative;
            z-index: 2;
            backdrop-filter: blur(3px);
            /* Reduced from 5px */
            flex-shrink: 0;
        }

        .edu-notification-close:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.05);
            /* Reduced from 1.1 */
        }

        /* Notification Types */
        .edu-notification-success {
            background: var(--gradient-notification-success);
        }

        .edu-notification-error {
            background: var(--gradient-notification-error);
        }

        .edu-notification-warning {
            background: var(--gradient-notification-warning);
            color: var(--prussian-blue);
        }

        .edu-notification-info {
            background: var(--gradient-notification-info);
            color: var(--prussian-blue);
        }

        /* OPTIMIZED: Removed liquid blob animation in notification */
        .edu-notification::after {
            display: none;
            /* Removed decorative element */
        }

        @keyframes edu-notification-slide {
            0% {
                transform: translateY(-100%) scale(0.9);
                opacity: 0;
            }

            100% {
                transform: translateY(0) scale(1);
                opacity: 1;
            }
        }

        /* Mobile notification adjustments */
        @media (max-width: 576px) {
            .edu-notification {
                padding: 14px 16px;
            }

            .edu-notification-content {
                gap: 12px;
            }

            .edu-notification-icon {
                width: 24px;
                height: 24px;
                font-size: 12px;
            }

            .edu-notification-message {
                font-size: 14px;
            }

            .edu-notification-close {
                width: 28px;
                height: 28px;
                font-size: 12px;
            }
        }

        /* REMOVED: All complex animations */
        /* .animate-liquid-float, .animate-liquid-pulse removed */

        /* Glassmorphism - Reduced blur */
        .glass-liquid {
            background: rgba(254, 253, 254, 0.2);
            backdrop-filter: blur(10px);
            /* Reduced from 15px */
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(251, 198, 12, 0.2);
            border-radius: var(--border-radius-liquid);
            box-shadow: var(--shadow-liquid);
        }

        .glass-liquid-dark {
            background: rgba(10, 29, 68, 0.2);
            backdrop-filter: blur(10px);
            /* Reduced from 15px */
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(90, 209, 228, 0.2);
            border-radius: var(--border-radius-liquid);
        }

        /* Custom Scrollbar - Simplified */
        ::-webkit-scrollbar {
            width: 10px;
            /* Reduced from 12px */
        }

        ::-webkit-scrollbar-track {
            background: var(--pale-slate);
            border-radius: var(--border-radius-full);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--gradient-liquid-1);
            border-radius: var(--border-radius-full);
            border: 2px solid var(--pale-slate);
            /* Reduced from 3px */
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--gradient-liquid-2);
        }

        /* Loading Spinner - Simplified */
        .spinner-liquid {
            width: 40px;
            /* Reduced from 50px */
            height: 40px;
            /* Reduced from 50px */
            border-radius: var(--border-radius-liquid);
            border: 3px solid var(--pale-slate);
            /* Reduced from 4px */
            border-top-color: var(--bright-amber);
            border-right-color: var(--sky-blue);
            border-bottom-color: var(--prussian-blue);
            animation: spin-liquid 1s infinite linear;
            /* Faster animation */
        }

        @keyframes spin-liquid {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }

            /* REMOVED complex border-radius changes */
        }

        /* Translation Loading Indicator - Optimized */
        .global-translation-loading {
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--gradient-liquid-2);
            color: var(--prussian-blue);
            padding: 12px 24px;
            /* Reduced from 14px 28px */
            border-radius: var(--border-radius-liquid);
            box-shadow: var(--shadow-liquid);
            z-index: 9999;
            display: none;
            align-items: center;
            gap: 12px;
            /* Reduced from 14px */
            font-weight: 600;
            backdrop-filter: blur(8px);
            /* Reduced from 10px */
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: slideInLiquid 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            max-width: calc(100% - 40px);
        }

        .global-translation-loading.show {
            display: flex;
        }

        .global-translation-loading i {
            animation: spin-liquid 1s infinite linear;
        }

        .global-translation-loading.timeout {
            background: var(--gradient-liquid-1);
            color: var(--pure-white);
        }

        @keyframes slideInLiquid {
            0% {
                transform: translateX(100%) scale(0.9);
                opacity: 0;
            }

            100% {
                transform: translateX(0) scale(1);
                opacity: 1;
            }
        }

        @media (max-width: 768px) {
            .global-translation-loading {
                top: 15px;
                right: 15px;
                padding: 10px 20px;
                /* Reduced from 12px 22px */
            }
        }

        @media (max-width: 576px) {
            .global-translation-loading {
                top: 10px;
                right: 10px;
                left: 10px;
                width: auto;
                padding: 10px 18px;
                /* Reduced from 12px 20px */
                justify-content: center;
            }
        }

        @media (max-width: 375px) {
            .global-translation-loading {
                padding: 8px 14px;
                /* Reduced from 10px 16px */
                font-size: 0.9rem;
            }
        }

        /* Grid */
        .grid {
            display: grid;
            gap: 30px;
            width: 100%;
        }

        .grid-2,
        .grid-3,
        .grid-4 {
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        }

        @media (max-width: 768px) {
            .grid {
                gap: 20px;
            }
        }

        /* Inputs - Reduced transitions */
        input,
        textarea,
        select {
            width: 100%;
            padding: 14px 20px;
            border: 2px solid var(--pale-slate);
            border-radius: var(--border-radius-liquid);
            font-family: 'Inter', sans-serif;
            font-size: 1rem;
            transition: border-color 0.3s, box-shadow 0.3s;
            /* Simplified from var(--transition-liquid) */
            background: rgba(254, 253, 254, 0.8);
            backdrop-filter: blur(3px);
            /* Added for consistency, reduced */
        }

        input:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: var(--sky-blue);
            box-shadow: var(--shadow-liquid-glow);
            transform: scale(1.01);
            /* Reduced from 1.02 */
        }

        @media (max-width: 768px) {

            input,
            textarea,
            select {
                padding: 12px 16px;
            }
        }

        /* Dividers - Simplified */
        .liquid-divider {
            height: 3px;
            /* Reduced from 4px */
            background: var(--gradient-liquid-2);
            border-radius: var(--border-radius-liquid);
            margin: 40px 0;
            /* REMOVED animation */
        }

        /* Fix for white space */
        @media (max-width: 1024px) {

            body,
            html {
                overflow-x: hidden;
                width: 100%;
                position: relative;
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
            transition: opacity 0.2s ease;
            /* Reduced from 0.3s */
        }

        .translate-text.translating {
            opacity: 0.8;
            /* Reduced from 0.7 (less change) */
        }

        .no-translate {
            /* Elements with this class won't be translated */
        }

        /* Bootstrap override for mobile */
        @media (max-width: 768px) {
            .row {
                margin-right: -10px;
                margin-left: -10px;
            }

            .col,
            [class*="col-"] {
                padding-right: 10px;
                padding-left: 10px;
            }
        }

        /* Footer responsiveness */
        .footer {
            background: var(--prussian-blue);
            color: var(--pure-white);
            padding: 60px 0 30px;
        }

        @media (max-width: 768px) {
            .footer {
                padding: 40px 0 20px;
            }

            .footer .row>div {
                margin-bottom: 30px;
            }
        }

        /* Page content padding */
        main {
            min-height: 60vh;
        }

        @media (max-width: 768px) {
            main {
                padding: 30px 0;
            }
        }

        @media (max-width: 576px) {
            main {
                padding: 20px 0;
            }
        }

        /* Add will-change for elements that animate */
        .card,
        .btn,
        .global-translation-loading {
            will-change: transform, opacity;
        }
    </style>
</head>

<body>
    <!-- OPTIMIZED: Liquid Background Elements - Only 2 instead of 4 -->
    <div class="liquid-bg">
        <div class="liquid-blob liquid-blob-1"></div>
        <div class="liquid-blob liquid-blob-2"></div>
        <!-- Removed liquid-blob-3 and liquid-blob-4 -->
    </div>

    <!-- Global Translation Loading Indicator -->
    <div class="global-translation-loading" id="globalTranslationLoading">
        <i class="fas fa-spinner"></i>
        <span>Translating page...</span>
    </div>

    @include('layouts.header')

    <main>

        {{-- Session Notifications --}}
        @if(session('success') || session('google_success'))
        <div class="edu-notification-wrapper">
            <div class="edu-notification edu-notification-success" role="alert">
                <div class="edu-notification-content">
                    <div class="edu-notification-icon">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="edu-notification-message">
                        {{ session('success') ?? session('google_success') }}
                    </div>
                </div>
                <button type="button" class="edu-notification-close" onclick="this.closest('.edu-notification').remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        @endif

        @if(session('error') || session('google_error'))
        <div class="edu-notification-wrapper">
            <div class="edu-notification edu-notification-error" role="alert">
                <div class="edu-notification-content">
                    <div class="edu-notification-icon">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                    <div class="edu-notification-message">
                        {{ session('error') ?? session('google_error') }}
                    </div>
                </div>
                <button type="button" class="edu-notification-close" onclick="this.closest('.edu-notification').remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        @endif

        @if(session('status'))
        <div class="edu-notification-wrapper">
            <div class="edu-notification edu-notification-info" role="alert">
                <div class="edu-notification-content">
                    <div class="edu-notification-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <div class="edu-notification-message">
                        {{ session('status') }}
                    </div>
                </div>
                <button type="button" class="edu-notification-close" onclick="this.closest('.edu-notification').remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        @endif

        @if(session('warning'))
        <div class="edu-notification-wrapper">
            <div class="edu-notification edu-notification-warning" role="alert">
                <div class="edu-notification-content">
                    <div class="edu-notification-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="edu-notification-message">
                        {{ session('warning') }}
                    </div>
                </div>
                <button type="button" class="edu-notification-close" onclick="this.closest('.edu-notification').remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        @endif

        @yield('content')
    </main>

    @include('layouts.footer')

    <!-- Scripts - Load with defer to not block rendering -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js" defer></script>

    <!-- Initialize AOS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check if user prefers reduced motion
            const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            AOS.init({
                duration: prefersReducedMotion ? 0 : 800,
                once: true,
                offset: 50,
                easing: 'ease-out',
                disable: function() {
                    return window.innerWidth < 768;
                }
            });

            // Auto-hide notifications after 5 seconds
            setTimeout(function() {
                document.querySelectorAll('.edu-notification').forEach(function(notification) {
                    notification.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                    notification.style.opacity = '0';
                    notification.style.transform = 'translateY(-20px)';
                    setTimeout(function() {
                        if (notification.parentNode) {
                            notification.remove();
                        }
                    }, 300);
                });
            }, 5000);
        });
    </script>

    <!-- Language Switcher JavaScript is already in the header -->
    <!-- All DeepL translation scripts have been removed -->

    @stack('scripts')
</body>

</html>