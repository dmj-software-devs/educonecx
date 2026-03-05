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
        // OPTIMIZED: Initialize AOS with better settings
        document.addEventListener('DOMContentLoaded', function() {
            // Check if user prefers reduced motion
            const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            AOS.init({
                duration: prefersReducedMotion ? 0 : 800, // Reduced from 1000
                once: true,
                offset: 50, // Reduced from 100
                easing: 'ease-out', // Simpler easing
                disable: function() {
                    return window.innerWidth < 768;
                }
            });

            // Auto-hide notifications after 5 seconds (reduced from 8)
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

    <!-- OPTIMIZED: Global Translation System - Simplified and more efficient -->
    <!-- OPTIMIZED: Global Translation System - Fixed and Improved -->
    <script>
        // Translation API endpoint - make sure this is correct
        const TRANSLATE_API_URL = "{{ route('translate') }}";

        // Current language (will be set from server)
        let currentLanguage = '{{ app()->getLocale() }}';

        // Cache for translations
        const translationCache = new Map();

        // Flag to prevent multiple simultaneous translations
        let isTranslating = false;

        // Store translatable elements
        let translatableElements = [];

        // IMPORTANT: Only translate when target language is NOT English
        const TRANSLATABLE_SELECTORS = [
            'h1:not(.no-translate)',
            'h2:not(.no-translate)',
            'h3:not(.no-translate)',
            'h4:not(.no-translate)',
            'h5:not(.no-translate)',
            'h6:not(.no-translate)',
            'p:not(.no-translate)',
            '.btn:not(.no-translate)',
            '.section-title:not(.no-translate)',
            '.card-title:not(.no-translate)',
            '.card-text:not(.no-translate)',
            '.badge:not(.no-translate)',
            'a:not(.no-translate):not(.btn)',
            'span.translate-text:not(.no-translate)',
            'div:not(.no-translate) p:not(.no-translate)',
            'label:not(.no-translate)',
            'li:not(.no-translate)'
        ];

        // Batch settings
        const BATCH_SIZE = 10;
        const BATCH_DELAY = 200;

        // Language display mapping
        const languageDisplay = {
            'en': {
                flag: '🇺🇸',
                code: 'EN'
            },
            'es': {
                flag: '🇪🇸',
                code: 'ES'
            },
            'fr': {
                flag: '🇫🇷',
                code: 'FR'
            },
            'de': {
                flag: '🇩🇪',
                code: 'DE'
            },
            'it': {
                flag: '🇮🇹',
                code: 'IT'
            },
            'pt': {
                flag: '🇵🇹',
                code: 'PT'
            },
            'zh': {
                flag: '🇨🇳',
                code: 'ZH'
            }
        };

        document.addEventListener('DOMContentLoaded', function() {
            // Small delay to ensure everything is loaded
            setTimeout(() => {
                initializeTranslatableElements();

                // IMPORTANT: Only translate if current language is not English
                if (currentLanguage && currentLanguage !== 'en') {
                    console.log(`Auto-translating page to ${currentLanguage}`);
                    translatePage(currentLanguage);
                }

                updateLanguageDisplay(currentLanguage);
            }, 300);
        });

        // Initialize elements that can be translated
        function initializeTranslatableElements() {
            translatableElements = [];

            TRANSLATABLE_SELECTORS.forEach(selector => {
                document.querySelectorAll(selector).forEach(element => {
                    // Skip if inside excluded areas
                    if (element.closest('.language-selector, .user-menu, .profile-dropdown, script, style')) {
                        return;
                    }

                    // Get clean text content
                    let text = element.textContent.trim();

                    // Skip empty or very short texts
                    if (!shouldTranslate(text)) return;

                    // Store original if not already stored
                    if (!element.hasAttribute('data-original')) {
                        element.setAttribute('data-original', text);
                    }

                    // Add class for styling
                    element.classList.add('translate-text');

                    translatableElements.push({
                        el: element,
                        original: text
                    });
                });
            });

            console.log(`Found ${translatableElements.length} translatable elements`);
        }

        // Check if text should be translated
        function shouldTranslate(text) {
            if (!text || text.trim().length < 2) return false;

            // Skip if it's just numbers, email, phone, or URLs
            if (/^[\d\s]+$/.test(text)) return false;
            if (text.includes('@') && text.includes('.')) return false; // email
            if (text.match(/[\d-+()\s]{7,}/)) return false; // phone
            if (text.startsWith('http') || text.includes('://')) return false; // URL
            if (text.match(/^[A-Z]{2,5}$/)) return false; // acronyms like EN, ES, etc.

            return true;
        }

        // Update language display in UI
        function updateLanguageDisplay(lang) {
            const display = languageDisplay[lang] || languageDisplay['en'];
            const flagEl = document.getElementById('currentFlag');
            const langEl = document.getElementById('currentLang');

            if (flagEl) flagEl.textContent = display.flag;
            if (langEl) langEl.textContent = display.code;
        }

        async function translatePage(targetLang) {
            if (isTranslating || translatableElements.length === 0) return;

            // Don't translate to English (source language)
            if (targetLang === 'en') {
                resetToOriginal();
                currentLanguage = targetLang;
                updateLanguageDisplay(targetLang);
                return;
            }

            isTranslating = true;

            const loadingEl = document.getElementById('globalTranslationLoading');
            if (loadingEl) {
                loadingEl.classList.add('show');
                loadingEl.innerHTML = '<i class="fas fa-spinner"></i><span>Translating...</span>';
            }

            // Longer timeout for quota issues
            const timeoutId = setTimeout(() => {
                if (loadingEl) {
                    loadingEl.innerHTML = '<i class="fas fa-exclamation-triangle"></i><span>Translation service busy. Showing original text.</span>';
                }
            }, 8000);

            try {
                // Update session
                fetch(`/language/${targetLang}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                }).catch(() => {});

                // Get all texts to translate
                const textsToTranslate = translatableElements.map(item => item.original);

                // Process in batches
                const totalBatches = Math.ceil(textsToTranslate.length / BATCH_SIZE);

                for (let batchIndex = 0; batchIndex < totalBatches; batchIndex++) {
                    const start = batchIndex * BATCH_SIZE;
                    const end = Math.min(start + BATCH_SIZE, textsToTranslate.length);
                    const batchTexts = textsToTranslate.slice(start, end);

                    try {
                        const batchResults = await translateBatch(batchTexts, 'en', targetLang);

                        // Apply translations
                        for (let i = 0; i < batchResults.length; i++) {
                            const itemIndex = start + i;
                            if (itemIndex < translatableElements.length) {
                                const item = translatableElements[itemIndex];
                                const translated = batchResults[i];

                                if (item.el && translated && translated !== item.original) {
                                    item.el.textContent = translated;
                                }
                            }
                        }

                        // Delay between batches
                        if (batchIndex < totalBatches - 1) {
                            await new Promise(resolve => setTimeout(resolve, BATCH_DELAY));
                        }
                    } catch (error) {
                        console.error(`Batch ${batchIndex + 1} failed:`, error);
                    }
                }

                currentLanguage = targetLang;
                updateLanguageDisplay(targetLang);

            } catch (error) {
                console.error('Translation error:', error);
            } finally {
                clearTimeout(timeoutId);
                setTimeout(() => {
                    if (loadingEl) loadingEl.classList.remove('show');
                }, 1000);
                isTranslating = false;
            }
        }
        // Reset to original text (when switching back to English)
        function resetToOriginal() {
            translatableElements.forEach(item => {
                if (item.el) {
                    item.el.textContent = item.original;
                }
            });
        }

        async function translateBatch(texts, sourceLang, targetLang) {
            if (texts.length === 0 || sourceLang === targetLang) return texts;

            // Check cache first
            const results = [];
            const uncachedTexts = [];
            const uncachedIndices = [];

            texts.forEach((text, index) => {
                const cacheKey = `${text}_${sourceLang}_${targetLang}`;
                if (translationCache.has(cacheKey)) {
                    results[index] = translationCache.get(cacheKey);
                } else {
                    uncachedIndices.push(index);
                    uncachedTexts.push(text);
                }
            });

            if (uncachedTexts.length === 0) return results;

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

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
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        q: uncachedTexts,
                        source: sourceLang,
                        target: targetLang,
                        batch: true
                    })
                });

                const data = await response.json();

                if (data.translatedTexts && Array.isArray(data.translatedTexts)) {
                    data.translatedTexts.forEach((translated, idx) => {
                        const originalIndex = uncachedIndices[idx];
                        const finalTranslation = translated || uncachedTexts[idx];
                        results[originalIndex] = finalTranslation;

                        // Cache the result
                        const cacheKey = `${uncachedTexts[idx]}_${sourceLang}_${targetLang}`;
                        translationCache.set(cacheKey, finalTranslation);
                    });
                } else if (data.error) {
                    console.warn('Translation API warning:', data.error);
                    // Return original texts
                    uncachedIndices.forEach((idx, i) => results[idx] = uncachedTexts[i]);
                } else {
                    // Fallback to original texts
                    uncachedIndices.forEach((idx, i) => results[idx] = uncachedTexts[i]);
                }

                return results;
            } catch (error) {
                console.error('Batch translation error:', error);
                // Return original texts for failed batch
                uncachedIndices.forEach((idx, i) => results[idx] = uncachedTexts[i]);
                return results;
            }
        }
        // Public API
        window.translationSystem = {
            translatePage: translatePage,
            currentLanguage: () => currentLanguage,
            resetToOriginal: resetToOriginal
        };
    </script>

    <script>
        // DEBUG: Check if translation is working
        function debugTranslationNow() {
            console.group('Translation Debug Info');
            console.log('API URL:', TRANSLATE_API_URL);
            console.log('Current Language:', currentLanguage);
            console.log('Translatable Elements:', translatableElements.length);

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            console.log('CSRF Token exists:', !!csrfToken);

            // Test a simple translation
            fetch(TRANSLATE_API_URL, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        q: ['Hello world'],
                        source: 'en',
                        target: 'es',
                        batch: true
                    })
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    return response.json().catch(() => response.text());
                })
                .then(data => {
                    console.log('Response data:', data);
                    if (data.translatedTexts) {
                        console.log('✅ Translation successful:', data.translatedTexts[0]);
                    } else {
                        console.error('❌ Translation failed - no translatedTexts in response');
                    }
                })
                .catch(error => {
                    console.error('❌ Fetch error:', error);
                });

            console.groupEnd();
        }

        // Run debug after 2 seconds
        setTimeout(debugTranslationNow, 2000);
    </script>
    @stack('scripts')
</body>

</html>