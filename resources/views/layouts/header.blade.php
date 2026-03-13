<header>
    <!-- Top Bar - Simplified -->
    <div class="top-bar">
        <div class="container">
            <div class="top-bar-content">
                <div class="contact-info">
                    <a href="tel:+18335338228">
                        <i class="fas fa-phone-alt"></i>
                        <span class="translate-text" data-original="{{ App\Helpers\TranslationHelper::trans('header.phone') }}">{{ App\Helpers\TranslationHelper::trans('header.phone') }}</span>
                    </a>
                    <a href="mailto:contact@educonecx.com">
                        <i class="fas fa-envelope"></i>
                        <span class="translate-text" data-original="{{ App\Helpers\TranslationHelper::trans('header.email') }}">{{ App\Helpers\TranslationHelper::trans('header.email') }}</span>
                    </a>
                </div>
                <div class="social-links">
                    <a href="https://www.facebook.com/profile.php?id=61584601012851" target="_blank" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.tiktok.com/@educonecx.officia" target="_blank" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
                    <a href="https://www.instagram.com/educonecx/" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.youtube.com/@EDUCONECX" target="_blank" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                    <a href="https://wa.me/18335338228" target="_blank" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <div class="main-header" id="mainHeader">
        <div class="container">
            <div class="header-content">
                <!-- Logo -->
                <div class="logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('images/logo.jpg') }}" alt="EDUCONECX Logo" class="logo-img">
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <nav class="desktop-nav">
                    <ul class="nav-menu">
                        <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}"><span class="translate-text" data-original="{{ App\Helpers\TranslationHelper::trans('header.home') }}">{{ App\Helpers\TranslationHelper::trans('header.home') }}</span></a></li>
                        <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}"><span class="translate-text" data-original="{{ App\Helpers\TranslationHelper::trans('header.about') }}">{{ App\Helpers\TranslationHelper::trans('header.about') }}</span></a></li>
                        <li><a href="{{ route('academy') }}" class="{{ request()->routeIs('academy') ? 'active' : '' }}"><span class="translate-text" data-original="{{ App\Helpers\TranslationHelper::trans('header.academy') }}">{{ App\Helpers\TranslationHelper::trans('header.academy') }}</span></a></li>
                        <li><a href="{{ route('courses') }}" class="{{ request()->routeIs('courses') || request()->routeIs('courses.*') ? 'active' : '' }}"><span class="translate-text" data-original="{{ App\Helpers\TranslationHelper::trans('header.courses') }}">{{ App\Helpers\TranslationHelper::trans('header.courses') }}</span></a></li>
                        <li><a href="{{ route('neo-ed-tech') }}" class="{{ request()->routeIs('neo-ed-tech') ? 'active' : '' }}"><span class="translate-text" data-original="{{ App\Helpers\TranslationHelper::trans('header.neo_ed_tech') }}">{{ App\Helpers\TranslationHelper::trans('header.neo_ed_tech') }}</span></a></li>
                        <li><a href="{{ route('blog') }}" class="{{ request()->routeIs('blog') || request()->routeIs('blog.show') ? 'active' : '' }}"><span class="translate-text" data-original="{{ App\Helpers\TranslationHelper::trans('header.blog') }}">{{ App\Helpers\TranslationHelper::trans('header.blog') }}</span></a></li>
                        <!-- <li><a href="{{ route('our-team') }}" class="{{ request()->routeIs('our-team') ? 'active' : '' }}"><span class="translate-text" data-original="{{ App\Helpers\TranslationHelper::trans('header.team') }}">{{ App\Helpers\TranslationHelper::trans('header.team') }}</span></a></li> -->
                        <li><a href="{{ route('quiz-competition') }}" class="{{ request()->routeIs('quiz-competition') ? 'active' : '' }}"><span class="translate-text" data-original="{{ App\Helpers\TranslationHelper::trans('header.quiz_competition') }}">Quiz Competition</span></a></li>
                        <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}"><span class="translate-text" data-original="{{ App\Helpers\TranslationHelper::trans('header.contact') }}">{{ App\Helpers\TranslationHelper::trans('header.contact') }}</span></a></li>
                        @auth
                        <li><a href="{{ route('quiz') }}" class="{{ request()->routeIs('quiz') ? 'active' : '' }}"><span class="translate-text" data-original="{{ App\Helpers\TranslationHelper::trans('header.quiz') }}">{{ App\Helpers\TranslationHelper::trans('header.quiz') }}</span></a></li>
                        <li><a href="{{ route('progressive-quizzes.index') }}" class="{{ request()->routeIs('progressive-quizzes.*') ? 'active' : '' }}"><span class="translate-text" data-original="Progressive Quizzes">Progressive Quizzes</span></a></li>

                        @endauth
                    </ul>
                </nav>

                <!-- Right Section -->
                <div class="header-actions">
                    <!-- Language Selector -->
                    <div class="language-selector">
                        <button class="lang-btn" id="langBtn">
                            <span class="current-flag" id="currentFlag">{{ App\Helpers\TranslationHelper::getFlag() }}</span>
                            <span class="current-lang" id="currentLang">{{ App\Helpers\TranslationHelper::getCode() }}</span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="lang-dropdown" id="langDropdown">
                            <div class="lang-search">
                                <i class="fas fa-search"></i>
                                <input type="text" placeholder="{{ App\Helpers\TranslationHelper::trans('common.search') }}" id="langSearch">
                            </div>
                            <div class="lang-list" id="langList"></div>
                        </div>
                    </div>

                    @auth
                    <!-- User Menu -->
                    <div class="user-menu">
                        <button class="user-btn" id="userBtn">
                            @if(Auth::user()->avatar)
                            <img src="{{ Storage::url(Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="user-avatar">
                            @else
                            <div class="user-avatar-placeholder">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            @endif
                            <span class="user-name">{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="user-dropdown" id="userDropdown">
                            <a href="{{ route('dashboard') }}"><i class="fas fa-user"></i> <span class="translate-text" data-original="{{ App\Helpers\TranslationHelper::trans('header.dashboard') }}">{{ App\Helpers\TranslationHelper::trans('header.dashboard') }}</span></a>
                            <a href="{{ route('profile') }}"><i class="fas fa-cog"></i> <span class="translate-text" data-original="{{ App\Helpers\TranslationHelper::trans('header.settings') }}">{{ App\Helpers\TranslationHelper::trans('header.settings') }}</span></a>
                            <a href="{{ route('my-courses') }}"><i class="fas fa-book-open"></i> <span class="translate-text" data-original="{{ App\Helpers\TranslationHelper::trans('header.my_courses') }}">{{ App\Helpers\TranslationHelper::trans('header.my_courses') }}</span></a>
                            <a href="{{ route('certificates') }}"><i class="fas fa-certificate"></i> <span class="translate-text" data-original="{{ App\Helpers\TranslationHelper::trans('header.certificates') }}">{{ App\Helpers\TranslationHelper::trans('header.certificates') }}</span></a>
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i> <span class="translate-text" data-original="{{ App\Helpers\TranslationHelper::trans('header.logout') }}">{{ App\Helpers\TranslationHelper::trans('header.logout') }}</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                        </div>
                    </div>
                    @else
                    <!-- Auth Buttons -->
                    <div class="auth-buttons">
                        <a href="{{ route('login') }}" class="btn-login"><i class="fas fa-sign-in-alt d-md-none"></i><span class="translate-text d-none d-md-inline" data-original="{{ App\Helpers\TranslationHelper::trans('header.login') }}">{{ App\Helpers\TranslationHelper::trans('header.login') }}</span></a>
                        <a href="{{ route('register') }}" class="btn-register"><i class="fas fa-user-plus d-md-none"></i><span class="translate-text d-none d-md-inline" data-original="{{ App\Helpers\TranslationHelper::trans('header.register') }}">{{ App\Helpers\TranslationHelper::trans('header.register') }}</span></a>
                    </div>
                    @endauth

                    <!-- Mobile Menu Toggle -->
                    <button class="menu-toggle" id="menuToggle" aria-label="Menu">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <div class="mobile-menu-header">
            <div class="mobile-user-info">
                @auth
                @if(Auth::user()->avatar)
                <img src="{{ Storage::url(Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="mobile-avatar">
                @else
                <div class="mobile-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                @endif
                <div class="mobile-user-details">
                    <span class="mobile-user-name">{{ Auth::user()->name }}</span>
                    <span class="mobile-user-email">{{ Auth::user()->email }}</span>
                </div>
                @else
                <div class="mobile-guest">
                    <i class="fas fa-user-circle"></i>
                    <span class="translate-text" data-original="{{ App\Helpers\TranslationHelper::trans('header.guest') }}">{{ App\Helpers\TranslationHelper::trans('header.guest') }}</span>
                </div>
                @endauth
                <button class="mobile-menu-close" id="mobileMenuClose">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <nav class="mobile-nav">
            <ul class="mobile-nav-list">
                <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}"><i class="fas fa-home"></i> <span class="translate-text" data-original="{{ App\Helpers\TranslationHelper::trans('header.home') }}">{{ App\Helpers\TranslationHelper::trans('header.home') }}</span></a></li>
                <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}"><i class="fas fa-info-circle"></i> <span class="translate-text" data-original="{{ App\Helpers\TranslationHelper::trans('header.about') }}">{{ App\Helpers\TranslationHelper::trans('header.about') }}</span></a></li>
                <li><a href="{{ route('academy') }}" class="{{ request()->routeIs('academy') ? 'active' : '' }}"><i class="fas fa-graduation-cap"></i> <span class="translate-text" data-original="{{ App\Helpers\TranslationHelper::trans('header.academy') }}">{{ App\Helpers\TranslationHelper::trans('header.academy') }}</span></a></li>
                <li><a href="{{ route('courses') }}" class="{{ request()->routeIs('courses') ? 'active' : '' }}"><i class="fas fa-book"></i> <span class="translate-text" data-original="{{ App\Helpers\TranslationHelper::trans('header.courses') }}">{{ App\Helpers\TranslationHelper::trans('header.courses') }}</span></a></li>
                <li><a href="{{ route('neo-ed-tech') }}" class="{{ request()->routeIs('neo-ed-tech') ? 'active' : '' }}"><i class="fas fa-microchip"></i> <span class="translate-text" data-original="{{ App\Helpers\TranslationHelper::trans('header.neo_ed_tech') }}">{{ App\Helpers\TranslationHelper::trans('header.neo_ed_tech') }}</span></a></li>
                <li><a href="{{ route('blog') }}" class="{{ request()->routeIs('blog') ? 'active' : '' }}"><i class="fas fa-blog"></i> <span class="translate-text" data-original="{{ App\Helpers\TranslationHelper::trans('header.blog') }}">{{ App\Helpers\TranslationHelper::trans('header.blog') }}</span></a></li>
                <!-- <li><a href="{{ route('our-team') }}" class="{{ request()->routeIs('our-team') ? 'active' : '' }}"><i class="fas fa-users"></i> <span class="translate-text" data-original="{{ App\Helpers\TranslationHelper::trans('header.team') }}">{{ App\Helpers\TranslationHelper::trans('header.team') }}</span></a></li> -->
                <li><a href="{{ route('quiz-competition') }}" class="{{ request()->routeIs('quiz-competition') ? 'active' : '' }}"><i class="fas fa-question-circle"></i><span class="translate-text" data-original="{{ App\Helpers\TranslationHelper::trans('header.quiz_competition') }}">Quiz Competition</span></a></li>
                <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}"><i class="fas fa-envelope"></i> <span class="translate-text" data-original="{{ App\Helpers\TranslationHelper::trans('header.contact') }}">{{ App\Helpers\TranslationHelper::trans('header.contact') }}</span></a></li>
                @auth
                <li><a href="{{ route('quiz') }}" class="{{ request()->routeIs('quiz') ? 'active' : '' }}"><i class="fas fa-question-circle"></i> <span class="translate-text" data-original="{{ App\Helpers\TranslationHelper::trans('header.quiz') }}">{{ App\Helpers\TranslationHelper::trans('header.quiz') }}</span></a></li>
                <li><a href="{{ route('progressive-quizzes.index') }}" class="{{ request()->routeIs('progressive-quizzes.*') ? 'active' : '' }}"><span class="translate-text" data-original="Progressive Quizzes">Progressive Quizzes</span></a></li>
                @endauth
            </ul>
        </nav>

        @auth
        <div class="mobile-menu-section">
            <h3 class="mobile-section-title"><span class="translate-text" data-original="{{ App\Helpers\TranslationHelper::trans('header.account') }}">{{ App\Helpers\TranslationHelper::trans('header.account') }}</span></h3>
            <ul class="mobile-nav-list">
                <li><a href="{{ route('dashboard') }}"><i class="fas fa-user"></i> <span class="translate-text" data-original="{{ App\Helpers\TranslationHelper::trans('header.dashboard') }}">{{ App\Helpers\TranslationHelper::trans('header.dashboard') }}</span></a></li>
                <li><a href="{{ route('profile') }}"><i class="fas fa-cog"></i> <span class="translate-text" data-original="{{ App\Helpers\TranslationHelper::trans('header.settings') }}">{{ App\Helpers\TranslationHelper::trans('header.settings') }}</span></a></li>
                <li><a href="{{ route('my-courses') }}"><i class="fas fa-book-open"></i> <span class="translate-text" data-original="{{ App\Helpers\TranslationHelper::trans('header.my_courses') }}">{{ App\Helpers\TranslationHelper::trans('header.my_courses') }}</span></a></li>
                <li><a href="{{ route('certificates') }}"><i class="fas fa-certificate"></i> <span class="translate-text" data-original="{{ App\Helpers\TranslationHelper::trans('header.certificates') }}">{{ App\Helpers\TranslationHelper::trans('header.certificates') }}</span></a></li>
            </ul>
        </div>
        @else
        <div class="mobile-menu-section">
            <h3 class="mobile-section-title"><span class="translate-text" data-original="{{ App\Helpers\TranslationHelper::trans('header.account') }}">{{ App\Helpers\TranslationHelper::trans('header.account') }}</span></h3>
            <div class="mobile-auth-buttons">
                <a href="{{ route('login') }}" class="mobile-btn-login"><i class="fas fa-sign-in-alt"></i> <span class="translate-text" data-original="{{ App\Helpers\TranslationHelper::trans('header.login') }}">{{ App\Helpers\TranslationHelper::trans('header.login') }}</span></a>
                <a href="{{ route('register') }}" class="mobile-btn-register"><i class="fas fa-user-plus"></i> <span class="translate-text" data-original="{{ App\Helpers\TranslationHelper::trans('header.register') }}">{{ App\Helpers\TranslationHelper::trans('header.register') }}</span></a>
            </div>
        </div>
        @endauth

        <div class="mobile-menu-section">
            <h3 class="mobile-section-title"><span class="translate-text" data-original="{{ App\Helpers\TranslationHelper::trans('header.contact') }}">{{ App\Helpers\TranslationHelper::trans('header.contact') }}</span></h3>
            <div class="mobile-contact">
                <a href="tel:+18335338228"><i class="fas fa-phone-alt"></i> <span class="translate-text" data-original="{{ App\Helpers\TranslationHelper::trans('header.phone') }}">{{ App\Helpers\TranslationHelper::trans('header.phone') }}</span></a>
                <a href="mailto:contact@educonecx.com"><i class="fas fa-envelope"></i> <span class="translate-text" data-original="{{ App\Helpers\TranslationHelper::trans('header.email') }}">{{ App\Helpers\TranslationHelper::trans('header.email') }}</span></a>
            </div>
        </div>

        <div class="mobile-menu-section">
            <h3 class="mobile-section-title"><span class="translate-text" data-original="{{ App\Helpers\TranslationHelper::trans('header.follow_us') }}">{{ App\Helpers\TranslationHelper::trans('header.follow_us') }}</span></h3>
            <div class="mobile-social">
                <a href="https://www.facebook.com/profile.php?id=61584601012851" target="_blank"><i class="fab fa-facebook-f"></i></a>
                <a href="https://www.tiktok.com/@educonecx.officia" target="_blank"><i class="fab fa-tiktok"></i></a>
                <a href="https://www.instagram.com/educonecx/" target="_blank"><i class="fab fa-instagram"></i></a>
                <a href="https://www.youtube.com/@EDUCONECX" target="_blank"><i class="fab fa-youtube"></i></a>
                <a href="https://wa.me/18335338228" target="_blank"><i class="fab fa-whatsapp"></i></a>
            </div>
        </div>
    </div>

    <!-- Menu Overlay -->
    <div class="menu-overlay" id="menuOverlay"></div>

    <!-- Keep existing styles - they remain unchanged -->
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
            --primary: var(--regal-navy);
            --accent: var(--bright-amber);
            --text-dark: var(--prussian-blue);
            --text-light: var(--pure-white);
            --bg-light: var(--pure-white);
            --shadow: 0 4px 12px rgba(10, 29, 68, 0.1);
            --shadow-lg: 0 8px 24px rgba(10, 29, 68, 0.15);
            --radius: 8px;
            --radius-lg: 12px;
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Container */
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
            width: 100%;
        }

        @media (max-width: 768px) {
            .container {
                padding: 0 15px;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 0 12px;
            }
        }

        /* Top Bar */
        .top-bar {
            background: var(--prussian-blue);
            color: var(--pure-white);
            padding: 8px 0;
            font-size: 0.9rem;
            position: relative;
            z-index: 1001;
        }

        .top-bar-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .contact-info {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .contact-info a {
            color: var(--pure-white);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
            opacity: 0.9;
            transition: var(--transition);
            font-size: 0.85rem;
        }

        .contact-info a:hover {
            opacity: 1;
            color: var(--bright-amber);
        }

        .contact-info i {
            font-size: 0.8rem;
        }

        .social-links {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .social-links a {
            color: var(--pure-white);
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            transition: var(--transition);
            text-decoration: none;
            font-size: 0.9rem;
        }

        .social-links a:hover {
            background: var(--bright-amber);
            color: var(--prussian-blue);
            transform: translateY(-2px);
        }

        /* Main Header */
        .main-header {
            background: var(--pure-white);
            box-shadow: var(--shadow);
            position: sticky;
            top: 0;
            z-index: 1000;
            transition: var(--transition);
        }

        .main-header.scrolled {
            box-shadow: var(--shadow-lg);
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 0;
            gap: 15px;
        }

        /* Logo */
        .logo a {
            display: block;
        }

        .logo-img {
            height: 45px;
            width: auto;
            display: block;
        }

        @media (max-width: 480px) {
            .logo-img {
                height: 35px;
            }
        }

        /* Desktop Navigation */
        .desktop-nav {
            flex: 1;
            display: flex;
            justify-content: center;
        }

        @media (max-width: 1200px) {
            .desktop-nav {
                display: none;
            }
        }

        .nav-menu {
            display: flex;
            list-style: none;
            gap: 24px;
        }

        .nav-menu li a {
            color: var(--text-dark);
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            padding: 6px 0;
            position: relative;
            transition: var(--transition);
            white-space: nowrap;
        }

        .nav-menu li a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--bright-amber);
            transition: var(--transition);
        }

        .nav-menu li a:hover::after,
        .nav-menu li a.active::after {
            width: 100%;
        }

        .nav-menu li a:hover,
        .nav-menu li a.active {
            color: var(--bright-amber);
        }

        /* Header Actions */
        .header-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        @media (max-width: 480px) {
            .header-actions {
                gap: 6px;
            }
        }

        /* Language Selector */
        .language-selector {
            position: relative;
        }

        .lang-btn {
            background: transparent;
            border: 1px solid var(--pale-slate);
            border-radius: var(--radius-lg);
            padding: 8px 12px;
            display: flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: var(--transition);
            background: var(--pure-white);
            height: 40px;
        }

        .lang-btn:hover {
            border-color: var(--bright-amber);
        }

        .current-flag {
            font-size: 1.1rem;
        }

        .current-lang {
            font-weight: 600;
            color: var(--text-dark);
        }

        .lang-btn i {
            color: var(--bright-amber);
            font-size: 0.7rem;
            transition: var(--transition);
        }

        .language-selector.active .lang-btn i {
            transform: rotate(180deg);
        }

        .lang-dropdown {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            width: 260px;
            background: var(--pure-white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lg);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: var(--transition);
            z-index: 1000;
            border: 1px solid var(--pale-slate);
            overflow: hidden;
        }

        .language-selector.active .lang-dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        @media (max-width: 768px) {
            .lang-dropdown {
                width: 240px;
                right: -10px;
            }
        }

        @media (max-width: 480px) {
            .lang-btn {
                padding: 6px 8px;
            }

            .current-lang {
                display: none;
            }

            .lang-dropdown {
                width: 220px;
            }
        }

        .lang-search {
            padding: 12px;
            border-bottom: 1px solid var(--pale-slate);
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--ivory);
        }

        .lang-search i {
            color: var(--khaki-beige);
            font-size: 0.9rem;
        }

        .lang-search input {
            border: none;
            background: transparent;
            width: 100%;
            outline: none;
            font-size: 0.9rem;
            color: var(--text-dark);
        }

        .lang-search input::placeholder {
            color: var(--khaki-beige);
        }

        .lang-list {
            max-height: 280px;
            overflow-y: auto;
            padding: 8px;
        }

        .lang-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: var(--radius);
            cursor: pointer;
            transition: var(--transition);
            font-size: 0.9rem;
        }

        .lang-item:hover {
            background: var(--ivory);
        }

        .lang-item.active {
            background: rgba(251, 198, 12, 0.1);
            color: var(--bright-amber);
        }

        .lang-item .flag {
            font-size: 1.1rem;
        }

        .lang-item .lang-name {
            flex: 1;
            font-weight: 500;
        }

        .lang-item .lang-native {
            color: var(--khaki-beige);
            font-size: 0.8rem;
        }

        .lang-item i {
            color: var(--bright-amber);
            font-size: 0.8rem;
        }

        /* Auth Buttons */
        .auth-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-login,
        .btn-register {
            padding: 8px 16px;
            border-radius: var(--radius-lg);
            font-size: 0.9rem;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
            white-space: nowrap;
            height: 40px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .btn-login {
            background: transparent;
            color: var(--text-dark);
            border: 1px solid var(--bright-amber);
        }

        .btn-login:hover {
            background: var(--bright-amber);
            color: var(--prussian-blue);
            transform: translateY(-2px);
        }

        .btn-register {
            background: var(--prussian-blue);
            color: var(--pure-white);
            border: 1px solid var(--prussian-blue);
        }

        .btn-register:hover {
            background: var(--bright-amber);
            border-color: var(--bright-amber);
            color: var(--prussian-blue);
            transform: translateY(-2px);
        }

        @media (max-width: 992px) {

            .btn-login span,
            .btn-register span {
                display: none;
            }

            .btn-login,
            .btn-register {
                padding: 8px 12px;
            }
        }

        @media (max-width: 480px) {

            .btn-login,
            .btn-register {
                padding: 6px 10px;
            }
        }

        /* User Menu */
        .user-menu {
            position: relative;
        }

        .user-btn {
            background: transparent;
            border: 1px solid var(--pale-slate);
            border-radius: var(--radius-lg);
            padding: 5px 12px;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: var(--transition);
            height: 40px;
        }

        .user-btn:hover {
            border-color: var(--bright-amber);
        }

        .user-avatar,
        .user-avatar-placeholder {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            object-fit: cover;
        }

        .user-avatar-placeholder {
            background: var(--prussian-blue);
            color: var(--pure-white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .user-name {
            font-weight: 600;
            color: var(--text-dark);
            font-size: 0.9rem;
            max-width: 100px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .user-btn i {
            color: var(--bright-amber);
            font-size: 0.7rem;
            transition: var(--transition);
        }

        .user-menu:hover .user-btn i {
            transform: rotate(180deg);
        }

        .user-dropdown {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            width: 220px;
            background: var(--pure-white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lg);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: var(--transition);
            z-index: 1000;
            border: 1px solid var(--pale-slate);
            overflow: hidden;
        }

        .user-menu:hover .user-dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        @media (max-width: 1200px) {
            .user-name {
                display: none;
            }

            .user-btn {
                padding: 5px 8px;
            }
        }

        .user-dropdown a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: var(--text-dark);
            text-decoration: none;
            transition: var(--transition);
            font-size: 0.9rem;
        }

        .user-dropdown a:hover {
            background: var(--ivory);
            color: var(--bright-amber);
            padding-left: 20px;
        }

        .user-dropdown i {
            width: 18px;
            color: var(--bright-amber);
        }

        .dropdown-divider {
            height: 1px;
            background: var(--pale-slate);
            margin: 4px 0;
        }

        /* Menu Toggle */
        .menu-toggle {
            display: none;
            flex-direction: column;
            gap: 5px;
            background: transparent;
            border: 1px solid var(--pale-slate);
            border-radius: var(--radius);
            padding: 8px;
            width: 40px;
            height: 40px;
            cursor: pointer;
            transition: var(--transition);
        }

        @media (max-width: 1200px) {
            .menu-toggle {
                display: flex;
            }
        }

        @media (max-width: 480px) {
            .menu-toggle {
                width: 36px;
                height: 36px;
                padding: 6px;
            }
        }

        .menu-toggle:hover {
            border-color: var(--bright-amber);
        }

        .menu-toggle span {
            display: block;
            width: 22px;
            height: 2px;
            background: var(--prussian-blue);
            border-radius: 2px;
            transition: var(--transition);
            margin: 0 auto;
        }

        .menu-toggle.active span:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }

        .menu-toggle.active span:nth-child(2) {
            opacity: 0;
        }

        .menu-toggle.active span:nth-child(3) {
            transform: rotate(-45deg) translate(5px, -5px);
        }

        /* Mobile Menu */
        .mobile-menu {
            position: fixed;
            top: 0;
            right: -100%;
            width: 320px;
            height: 100vh;
            background: var(--pure-white);
            z-index: 9999;
            overflow-y: auto;
            transition: right 0.3s ease;
            box-shadow: var(--shadow-lg);
            display: block;
        }

        .mobile-menu.active {
            right: 0;
        }

        @media (max-width: 768px) {
            .mobile-menu {
                width: 280px;
            }
        }

        @media (max-width: 480px) {
            .mobile-menu {
                width: 260px;
            }
        }

        .mobile-menu-header {
            padding: 20px;
            background: var(--ivory);
            border-bottom: 1px solid var(--pale-slate);
        }

        .mobile-user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
        }

        .mobile-menu-close {
            position: absolute;
            top: -10px;
            right: -10px;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: var(--bright-amber);
            border: none;
            color: var(--prussian-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 1rem;
            transition: var(--transition);
        }

        .mobile-menu-close:hover {
            transform: scale(1.1);
            background: var(--prussian-blue);
            color: var(--bright-amber);
        }

        .mobile-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--prussian-blue);
            color: var(--pure-white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1.2rem;
        }

        .mobile-user-details {
            flex: 1;
            min-width: 0;
        }

        .mobile-user-name {
            display: block;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 4px;
            font-size: 1rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .mobile-user-email {
            display: block;
            font-size: 0.8rem;
            color: var(--khaki-beige);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .mobile-guest {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--text-dark);
            font-size: 1rem;
            flex: 1;
        }

        .mobile-guest i {
            font-size: 2rem;
            color: var(--khaki-beige);
        }

        .mobile-nav {
            padding: 20px 0;
        }

        .mobile-nav-list {
            list-style: none;
        }

        .mobile-nav-list li a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 20px;
            color: var(--text-dark);
            text-decoration: none;
            transition: var(--transition);
            border-left: 3px solid transparent;
            font-size: 1rem;
        }

        .mobile-nav-list li a:hover,
        .mobile-nav-list li a.active {
            background: var(--ivory);
            color: var(--bright-amber);
            border-left-color: var(--bright-amber);
            padding-left: 24px;
        }

        .mobile-nav-list li a i {
            width: 20px;
            color: var(--bright-amber);
            font-size: 1.1rem;
        }

        .mobile-menu-section {
            padding: 20px;
            border-top: 8px solid var(--ivory);
        }

        .mobile-section-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--khaki-beige);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
        }

        .mobile-auth-buttons {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .mobile-btn-login,
        .mobile-btn-register {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 14px;
            border-radius: var(--radius-lg);
            text-align: center;
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
            font-size: 1rem;
        }

        .mobile-btn-login {
            background: transparent;
            color: var(--text-dark);
            border: 1px solid var(--bright-amber);
        }

        .mobile-btn-login:hover {
            background: var(--bright-amber);
            color: var(--prussian-blue);
        }

        .mobile-btn-register {
            background: var(--prussian-blue);
            color: var(--pure-white);
            border: 1px solid var(--prussian-blue);
        }

        .mobile-btn-register:hover {
            background: var(--bright-amber);
            border-color: var(--bright-amber);
            color: var(--prussian-blue);
        }

        .mobile-contact {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .mobile-contact a {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--text-dark);
            text-decoration: none;
            transition: var(--transition);
            padding: 8px 0;
            font-size: 0.95rem;
        }

        .mobile-contact a:hover {
            color: var(--bright-amber);
            transform: translateX(5px);
        }

        .mobile-contact i {
            width: 20px;
            color: var(--bright-amber);
        }

        .mobile-social {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .mobile-social a {
            width: 40px;
            height: 40px;
            background: var(--ivory);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--prussian-blue);
            transition: var(--transition);
            text-decoration: none;
            font-size: 1.1rem;
        }

        .mobile-social a:hover {
            background: var(--bright-amber);
            color: var(--prussian-blue);
            transform: translateY(-3px);
        }

        /* Overlay */
        .menu-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(10, 29, 68, 0.5);
            z-index: 9998;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
            backdrop-filter: blur(3px);
        }

        .menu-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Body scroll lock */
        body.menu-open {
            overflow: hidden;
            position: fixed;
            width: 100%;
            height: 100%;
        }

        /* Utility Classes */
        .d-none {
            display: none !important;
        }

        .d-inline {
            display: inline !important;
        }

        .d-md-none {
            display: none !important;
        }

        @media (min-width: 992px) {
            .d-md-none {
                display: none !important;
            }

            .d-md-inline {
                display: inline !important;
            }
        }

        @media (max-width: 991px) {
            .d-md-none {
                display: inline !important;
            }

            .d-md-inline {
                display: none !important;
            }
        }

        /* Responsive Top Bar */
        @media (max-width: 768px) {
            .top-bar-content {
                flex-direction: column;
                text-align: center;
            }

            .contact-info {
                justify-content: center;
                gap: 15px;
            }

            .contact-info a {
                font-size: 0.8rem;
            }

            .social-links {
                justify-content: center;
            }
        }

        @media (max-width: 576px) {
            .contact-info {
                flex-direction: column;
                gap: 8px;
            }

            .contact-info a {
                justify-content: center;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ===== STICKY HEADER =====
            const header = document.getElementById('mainHeader');
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

            // ===== MOBILE MENU =====
            const menuToggle = document.getElementById('menuToggle');
            const mobileMenu = document.getElementById('mobileMenu');
            const menuOverlay = document.getElementById('menuOverlay');
            const mobileMenuClose = document.getElementById('mobileMenuClose');

            function openMenu() {
                menuToggle.classList.add('active');
                mobileMenu.classList.add('active');
                menuOverlay.classList.add('active');
                document.body.classList.add('menu-open');
            }

            function closeMenu() {
                menuToggle.classList.remove('active');
                mobileMenu.classList.remove('active');
                menuOverlay.classList.remove('active');
                document.body.classList.remove('menu-open');
            }

            if (menuToggle) {
                menuToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    if (mobileMenu.classList.contains('active')) {
                        closeMenu();
                    } else {
                        openMenu();
                    }
                });
            }

            if (mobileMenuClose) {
                mobileMenuClose.addEventListener('click', closeMenu);
            }

            if (menuOverlay) {
                menuOverlay.addEventListener('click', closeMenu);
            }

            // Close menu on link click
            document.querySelectorAll('.mobile-nav-list a, .mobile-btn-login, .mobile-btn-register, .mobile-contact a').forEach(link => {
                link.addEventListener('click', closeMenu);
            });

            // Close on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && mobileMenu.classList.contains('active')) {
                    closeMenu();
                }
            });

            // ===== LANGUAGE SELECTOR =====
            const languages = {
                'en': {
                    name: 'English',
                    flag: '🇺🇸',
                    native: 'English'
                },
                'es': {
                    name: 'Spanish',
                    flag: '🇪🇸',
                    native: 'Español'
                },
                'fr': {
                    name: 'French',
                    flag: '🇫🇷',
                    native: 'Français'
                }
            };

            let currentLang = '{{ app()->getLocale() }}';

            function populateLanguages(activeLang) {
                const list = document.getElementById('langList');
                if (!list) return;

                list.innerHTML = '';

                Object.entries(languages).forEach(([code, lang]) => {
                    const item = document.createElement('div');
                    item.className = `lang-item ${code === activeLang ? 'active' : ''}`;
                    item.dataset.lang = code;

                    item.innerHTML = `
                        <span class="flag">${lang.flag}</span>
                        <span class="lang-name">${lang.name}</span>
                        <span class="lang-native">${lang.native}</span>
                        ${code === activeLang ? '<i class="fas fa-check"></i>' : ''}
                    `;

                    item.addEventListener('click', function() {
                        switchLanguage(code);
                    });

                    list.appendChild(item);
                });
            }

            function filterLanguages(searchTerm) {
                const items = document.querySelectorAll('.lang-item');
                const term = searchTerm.toLowerCase();

                items.forEach(item => {
                    const name = item.querySelector('.lang-name').textContent.toLowerCase();
                    const native = item.querySelector('.lang-native').textContent.toLowerCase();

                    if (name.includes(term) || native.includes(term)) {
                        item.style.display = 'flex';
                    } else {
                        item.style.display = 'none';
                    }
                });
            }

            function switchLanguage(code) {
                const langInfo = languages[code];
                if (!langInfo) return;

                // Update button
                document.getElementById('currentFlag').textContent = langInfo.flag;
                document.getElementById('currentLang').textContent = code.toUpperCase();

                // Update active states
                document.querySelectorAll('.lang-item').forEach(item => {
                    item.classList.remove('active');
                    const check = item.querySelector('i.fa-check');
                    if (check) check.remove();

                    if (item.dataset.lang === code) {
                        item.classList.add('active');
                        item.innerHTML += '<i class="fas fa-check"></i>';
                    }
                });

                // Close dropdown
                document.querySelector('.language-selector').classList.remove('active');

                // Redirect to language switch route
                window.location.href = `/language/${code}`;
            }

            // Language selector toggle
            const langBtn = document.getElementById('langBtn');
            const langSelector = document.querySelector('.language-selector');

            if (langBtn) {
                langBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    langSelector.classList.toggle('active');
                });
            }

            // Close on outside click
            document.addEventListener('click', function(e) {
                if (langSelector && !langSelector.contains(e.target)) {
                    langSelector.classList.remove('active');
                }
            });

            // Search functionality
            const langSearch = document.getElementById('langSearch');
            if (langSearch) {
                langSearch.addEventListener('input', function() {
                    filterLanguages(this.value);
                });

                langSearch.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }

            // Initialize languages
            const currentFlag = document.getElementById('currentFlag');
            const currentLangEl = document.getElementById('currentLang');

            // Set initial values from server
            const initialLang = '{{ app()->getLocale() }}';
            const initialFlag = '{{ App\Helpers\TranslationHelper::getFlag() }}';
            const initialCode = '{{ App\Helpers\TranslationHelper::getCode() }}';

            if (currentFlag) currentFlag.textContent = initialFlag;
            if (currentLangEl) currentLangEl.textContent = initialCode;

            populateLanguages(initialLang);
        });
    </script>
</header>