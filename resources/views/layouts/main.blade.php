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
            --primary: #4361ee;
            --primary-dark: #3a56d4;
            --primary-light: #4895ef;
            --secondary: #4cc9f0;
            --accent: #f72585;
            --success: #06d6a0;
            --warning: #ffd166;
            --danger: #ef476f;
            --dark: #1e1e2f;
            --dark-light: #2d2d44;
            --gray: #6c757d;
            --gray-light: #e9ecef;
            --light: #f8f9fa;
            --white: #ffffff;
            --black: #000000;
            --gradient-1: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-2: linear-gradient(45deg, #f093fb 0%, #f5576c 100%);
            --gradient-3: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            --shadow-sm: 0 5px 15px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 10px 30px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 20px 40px rgba(0, 0, 0, 0.15);
            --shadow-hover: 0 30px 50px rgba(67, 97, 238, 0.2);
            --border-radius-sm: 8px;
            --border-radius-md: 12px;
            --border-radius-lg: 20px;
            --border-radius-xl: 30px;
            --border-radius-full: 9999px;
            --transition: all 0.3s ease;
            --transition-slow: all 0.5s ease;
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
            color: var(--dark);
            line-height: 1.6;
            overflow-x: hidden;
            width: 100%;
            position: relative;
            background-color: var(--white);
        }

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
        
        @media (max-width: 375px) {
            .container {
                padding: 0 12px;
            }
        }

        /* Typography */
        .display-1 {
            font-size: clamp(2.5rem, 8vw, 4.5rem);
            font-weight: 800;
            line-height: 1.1;
        }

        .display-2 {
            font-size: clamp(2rem, 6vw, 3.5rem);
            font-weight: 700;
        }

        .section-title {
            font-size: clamp(1.8rem, 5vw, 2.5rem);
            font-weight: 800;
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
        }

        .section-title:after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 80px;
            height: 4px;
            background: var(--gradient-1);
            border-radius: var(--border-radius-full);
        }

        .text-gradient {
            background: var(--gradient-1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Buttons */
        .btn {
            display: inline-block;
            padding: 12px 32px;
            border-radius: var(--border-radius-full);
            font-weight: 600;
            font-size: 1rem;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
            border: none;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
            z-index: -1;
        }

        .btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-primary {
            background: var(--gradient-1);
            color: var(--white);
            box-shadow: var(--shadow-md);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-hover);
        }

        .btn-secondary {
            background: transparent;
            color: var(--primary);
            border: 2px solid var(--primary);
            position: relative;
            z-index: 1;
            overflow: hidden;
        }

        .btn-secondary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: var(--primary);
            transition: left 0.3s;
            z-index: -1;
        }

        .btn-secondary:hover {
            color: var(--white);
        }

        .btn-secondary:hover::before {
            left: 0;
        }

        .btn-outline {
            background: transparent;
            color: var(--dark);
            border: 2px solid var(--gray-light);
        }

        .btn-outline:hover {
            border-color: var(--primary);
            color: var(--primary);
            transform: translateY(-3px);
        }

        /* Cards */
        .card {
            background: var(--white);
            border-radius: var(--border-radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            height: 100%;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-lg);
        }

        .card-image {
            position: relative;
            overflow: hidden;
            aspect-ratio: 16/9;
        }

        .card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition-slow);
        }

        .card:hover .card-image img {
            transform: scale(1.1);
        }

        .card-content {
            padding: 24px;
        }

        /* Badges */
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: var(--border-radius-full);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-primary {
            background: var(--primary-light);
            color: var(--white);
        }

        .badge-accent {
            background: var(--accent);
            color: var(--white);
        }

        .badge-success {
            background: var(--success);
            color: var(--white);
        }

        /* Animations */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        @keyframes shimmer {
            0% {
                background-position: -1000px 0;
            }

            100% {
                background-position: 1000px 0;
            }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animate-pulse-slow {
            animation: pulse 4s ease-in-out infinite;
        }

        /* Loading Skeleton */
        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 2s infinite;
        }

        /* Responsive Grid */
        .grid {
            display: grid;
            gap: 30px;
            width: 100%;
        }

        .grid-2 {
            grid-template-columns: repeat(2, 1fr);
        }

        .grid-3 {
            grid-template-columns: repeat(3, 1fr);
        }

        .grid-4 {
            grid-template-columns: repeat(4, 1fr);
        }

        @media (max-width: 1024px) {
            .grid-4 {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 768px) {

            .grid-3,
            .grid-4 {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .grid {
                gap: 20px;
            }
        }

        @media (max-width: 576px) {

            .grid-2,
            .grid-3,
            .grid-4 {
                grid-template-columns: 1fr;
            }
            
            .grid {
                gap: 15px;
            }
        }

        /* Spacing */
        .section-padding {
            padding: 80px 0;
        }

        @media (max-width: 768px) {
            .section-padding {
                padding: 60px 0;
            }
        }
        
        @media (max-width: 576px) {
            .section-padding {
                padding: 40px 0;
            }
        }

        /* Glassmorphism */
        .glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .glass-dark {
            background: rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: var(--light);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: var(--border-radius-full);
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-dark);
        }
        
        @media (max-width: 768px) {
            ::-webkit-scrollbar {
                width: 6px;
            }
        }

        /* Loading Spinner */
        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid var(--gray-light);
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @media (max-width: 576px) {
            .spinner {
                width: 30px;
                height: 30px;
                border-width: 3px;
            }
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Translation Loading Indicator - Enhanced Mobile Responsive */
        .global-translation-loading {
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--gradient-1);
            color: white;
            padding: 12px 24px;
            border-radius: var(--border-radius-full);
            box-shadow: var(--shadow-lg);
            z-index: 9999;
            display: none;
            align-items: center;
            gap: 12px;
            font-weight: 600;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: slideInRight 0.3s ease;
            max-width: calc(100% - 40px);
        }

        .global-translation-loading.show {
            display: flex;
        }

        .global-translation-loading i {
            animation: spin 1s linear infinite;
        }

        .global-translation-loading.timeout {
            background: var(--danger);
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        /* Mobile Responsive Styles for Translation Loading */
        @media (max-width: 768px) {
            .global-translation-loading {
                top: 15px;
                right: 15px;
                padding: 10px 18px;
                font-size: 0.9rem;
                gap: 8px;
            }
        }
        
        @media (max-width: 576px) {
            .global-translation-loading {
                top: 10px;
                right: 10px;
                left: 10px;
                width: auto;
                padding: 10px 16px;
                font-size: 0.85rem;
                gap: 8px;
                border-radius: 50px;
                justify-content: center;
            }
            
            .global-translation-loading i {
                font-size: 0.9rem;
            }
        }
        
        @media (max-width: 375px) {
            .global-translation-loading {
                padding: 8px 14px;
                font-size: 0.8rem;
            }
        }

        /* Additional mobile optimizations */
        @media (max-width: 576px) {
            .card-content {
                padding: 16px;
            }
            
            .card-content h3 {
                font-size: 1.2rem;
            }
            
            .btn {
                padding: 10px 24px;
                font-size: 0.9rem;
            }
        }
        
        /* Fix for white space on right side - Keep this but make it less aggressive */
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
            
            /* Allow dropdowns to work properly */
            .language-menu, 
            .dropdown-menu {
                max-width: 90vw;
                z-index: 10000;
            }
        }
        
        @media (max-width: 576px) {
            .row, [class*="col-"] {
                margin-left: 0;
                margin-right: 0;
            }
        }
        
        /* Fix for z-index issues */
        .language-selector-container {
            z-index: 1001;
        }
        
        .language-menu {
            z-index: 1002;
        }
        
        .mobile-menu {
            z-index: 999;
        }
        
        .main-header {
            z-index: 1000;
        }
    </style>
</head>

<body>
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
            easing: 'ease-in-out'
        });
    </script>

    <!-- Global Translation System -->
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

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize translatable elements
            initializeTranslatableElements();
            
            // Store English texts as base
            storeEnglishTexts();

            // Auto-translate if current language is not English
            if (currentLanguage !== 'en') {
                translatePage(currentLanguage);
            }
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

        // Initialize all translatable elements and preserve original texts
        function initializeTranslatableElements() {
            translatableElements = [];

            // Find all elements with text content that should be translated
            const selectors = [
                'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
                'p', 'span:not(.no-translate):not(.flag):not(.current-flag)',
                'a:not(.no-translate):not(.btn):not(.language-toggle)',
                '.btn', '.section-title', '.card-title', '.card-text',
                '.nav-menu a', '.contact-info a', '.footer-links a',
                'label', '.badge', '.alert', '.hero-title', '.hero-subtitle'
            ];

            selectors.forEach(selector => {
                document.querySelectorAll(selector).forEach(element => {
                    // Skip elements that should not be translated
                    if (element.closest('.language-selector-container') ||
                        element.closest('.profile-dropdown') ||
                        element.classList.contains('no-translate') ||
                        element.classList.contains('flag') ||
                        element.classList.contains('current-flag') ||
                        element.id === 'currentFlag' ||
                        element.id === 'currentLanguage') {
                        return;
                    }

                    // Skip elements with no text or only whitespace
                    const text = element.textContent?.trim();
                    if (!text || text.length < 2) return;

                    // Skip elements that contain only numbers or special characters
                    if (/^[\d\s\W]+$/.test(text)) return;

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
                const textsToTranslate = translatableElements.map(item => item.baseOriginal);

                if (textsToTranslate.length === 0) {
                    console.log('No elements to translate');
                    return true;
                }

                // Perform batch translation
                const translatedTexts = await translateBatch(textsToTranslate, 'en', targetLang);

                // Apply translations
                let appliedCount = 0;
                translatedTexts.forEach((translated, index) => {
                    if (translatableElements[index] && translatableElements[index].element) {
                        const element = translatableElements[index].element;
                        
                        if (translated && translated.trim().length > 0) {
                            const currentContent = element.textContent;
                            
                            // Only update if the translation is different
                            if (translated !== currentContent) {
                                element.textContent = translated;
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

                console.log(`Translation complete: ${appliedCount}/${translatableElements.length} elements updated`);
                
                return true;

            } catch (error) {
                console.error('Page translation error:', error);
                throw error;
            } finally {
                clearTimeout(timeoutId);
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
            const flagEl = document.getElementById('currentFlag');
            const langEl = document.getElementById('currentLanguage');
            if (flagEl) flagEl.textContent = '🇺🇸';
            if (langEl) langEl.textContent = 'English';
            
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

        // Expose for debugging
        window.translationSystem = {
            translatePage,
            resetToEnglish: window.resetToEnglish,
            currentLanguage: () => currentLanguage,
            elements: () => translatableElements.length,
            test: window.testTranslation,
            apiUrl: TRANSLATE_API_URL
        };

        console.log('Translation system initialized. Current language:', currentLanguage);
    </script>

    @stack('scripts')
</body>

</html>