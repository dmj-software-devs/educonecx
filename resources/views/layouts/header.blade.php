<header>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
            <div class="top-bar-content">
                <div class="contact-info">
                    <a href="tel:+18335338228"><i class="fas fa-phone-alt"></i> <span class="translate-text" data-original="+1 (833) 533-8228">+1 (833) 533-8228</span></a>
                    <a href="mailto:contact@educonecx.com"><i class="fas fa-envelope"></i> <span class="translate-text" data-original="contact@educonecx.com">contact@educonecx.com</span></a>
                </div>
                <div class="social-links">
                    <a href="https://www.facebook.com/profile.php?id=61584601012851" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.tiktok.com/@educonecx.officia" target="_blank"><i class="fab fa-tiktok"></i></a>
                    <a href="https://www.instagram.com/educonecx/" target="_blank"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.youtube.com/@EDUCONECX" target="_blank"><i class="fab fa-youtube"></i></a>
                    <a href="https://wa.me/18335338228" target="_blank"><i class="fab fa-whatsapp"></i></a>
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
                        <span class="logo-text">EDUCONECX</span>
                    </a>
                </div>

                <!-- Navigation Menu -->
                <nav class="main-nav" id="mainNav">
                    <ul class="nav-menu">
                        <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}"><span class="translate-text" data-original="Home">Home</span></a></li>
                        <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}"><span class="translate-text" data-original="About">About</span></a></li>
                        <li><a href="{{ route('academy') }}" class="{{ request()->routeIs('academy') ? 'active' : '' }}"><span class="translate-text" data-original="Academy">Academy</span></a></li>
                        <li><a href="{{ route('courses') }}" class="{{ request()->routeIs('courses') || request()->routeIs('courses.*') ? 'active' : '' }}"><span class="translate-text" data-original="All Courses">All Courses</span></a></li>
                        <li><a href="{{ route('blog') }}" class="{{ request()->routeIs('blog') || request()->routeIs('blog.show') ? 'active' : '' }}"><span class="translate-text" data-original="Blog">Blog</span></a></li>
                        <li><a href="{{ route('our-team') }}" class="{{ request()->routeIs('our-team') ? 'active' : '' }}"><span class="translate-text" data-original="Our Team">Our Team</span></a></li>
                        <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}"><span class="translate-text" data-original="Contact">Contact</span></a></li>

                        <!-- Quiz Link - Only shown to authenticated users -->
                        @auth
                        <li><a href="{{ route('quiz') }}" class="{{ request()->routeIs('quiz') ? 'active' : '' }}"><span class="translate-text" data-original="Quiz">Quiz</span></a></li>
                        @endauth
                    </ul>
                </nav>

                <!-- Right Section -->
                <div class="header-right">
                    <!-- Language Selector -->
                    <div class="language-selector-container">
                        <div class="language-dropdown">
                            <button class="language-toggle" id="languageToggle">
                                <span class="current-flag" id="currentFlag">🇺🇸</span>
                                <span class="current-language" id="currentLanguage">English</span>
                                <i class="fas fa-chevron-down"></i>
                            </button>

                            <div class="language-menu" id="languageMenu">
                                <div class="language-search">
                                    <i class="fas fa-search"></i>
                                    <input type="text" placeholder="Search languages..." id="languageSearch">
                                </div>

                                <div class="language-list" id="languageList">
                                    <!-- Languages will be populated by JavaScript -->
                                </div>
                            </div>
                        </div>
                    </div>

                    @auth
                    <!-- Profile Dropdown (for authenticated users) -->
                    <div class="profile-dropdown">
                        <button class="profile-btn">
                            @if(Auth::user()->avatar)
                            <img src="{{ Storage::url(Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="profile-page-avatar-image">
                            @else
                            <div class="profile-page-avatar-placeholder">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            @endif
                            <span class="profile-name">{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a href="{{ route('dashboard') }}"><i class="fas fa-user"></i> <span class="translate-text" data-original="Dashboard">Dashboard</span></a>
                            <a href="{{ route('profile') }}"><i class="fas fa-cog"></i> <span class="translate-text" data-original="Settings">Settings</span></a>
                            <a href="{{ route('my-courses') }}"><i class="fas fa-book-open"></i> <span class="translate-text" data-original="My Courses">My Courses</span></a>
                            <a href="{{ route('certificates') }}"><i class="fas fa-certificate"></i> <span class="translate-text" data-original="Certificates">Certificates</span></a>
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i> <span class="translate-text" data-original="Logout">Logout</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                    @else
                    <!-- Login/Register Buttons (for guests) -->
                    <div class="auth-buttons">
                        <a href="{{ route('login') }}" class="btn-login">
                            <i class="fas fa-sign-in-alt"></i>
                            <span class="translate-text" data-original="Login">Login</span>
                        </a>
                        <a href="{{ route('register') }}" class="btn-register">
                            <span class="translate-text" data-original="Register">Register</span>
                            <i class="fas fa-user-plus"></i>
                        </a>
                    </div>
                    @endauth

                    <!-- Mobile Menu Toggle -->
                    <button class="mobile-toggle" id="mobileToggle">
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
        <ul class="mobile-nav-menu">
            <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}"><span class="translate-text" data-original="Home">Home</span></a></li>
            <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}"><span class="translate-text" data-original="About">About</span></a></li>
            <li><a href="{{ route('academy') }}" class="{{ request()->routeIs('academy') ? 'active' : '' }}"><span class="translate-text" data-original="Academy">Academy</span></a></li>
            <li><a href="{{ route('courses') }}" class="{{ request()->routeIs('courses') || request()->routeIs('courses.*') ? 'active' : '' }}"><span class="translate-text" data-original="All Courses">All Courses</span></a></li>
            <li><a href="{{ route('blog') }}" class="{{ request()->routeIs('blog') || request()->routeIs('blog.show') ? 'active' : '' }}"><span class="translate-text" data-original="Blog">Blog</span></a></li>
            <li><a href="{{ route('our-team') }}" class="{{ request()->routeIs('our-team') ? 'active' : '' }}"><span class="translate-text" data-original="Our Team">Our Team</span></a></li>
            <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}"><span class="translate-text" data-original="Contact">Contact</span></a></li>

            <!-- Quiz Link - Only shown to authenticated users in mobile menu -->
            @auth
            <li><a href="{{ route('quiz') }}" class="{{ request()->routeIs('quiz') ? 'active' : '' }}"><span class="translate-text" data-original="Quiz">Quiz</span></a></li>
            @endauth
        </ul>

        <!-- Mobile Auth Links -->
        @auth
        <div class="mobile-auth">
            <div class="mobile-user-info">
                @if(Auth::user()->avatar)
                <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" class="mobile-avatar">
                @else
                <div class="mobile-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                @endif
                <div class="mobile-user-details">
                    <span class="mobile-user-name">{{ Auth::user()->name }}</span>
                    <span class="mobile-user-email">{{ Auth::user()->email }}</span>
                </div>
            </div>
            <ul class="mobile-nav-menu">
                <li><a href="{{ route('dashboard') }}"><i class="fas fa-user"></i> <span class="translate-text" data-original="Dashboard">Dashboard</span></a></li>
                <li><a href="{{ route('profile') }}"><i class="fas fa-cog"></i> <span class="translate-text" data-original="Settings">Settings</span></a></li>
                <li><a href="{{ route('my-courses') }}"><i class="fas fa-book-open"></i> <span class="translate-text" data-original="My Courses">My Courses</span></a></li>
                <li><a href="{{ route('certificates') }}"><i class="fas fa-certificate"></i> <span class="translate-text" data-original="Certificates">Certificates</span></a></li>
            </ul>
        </div>
        @else
        <div class="mobile-auth-buttons">
            <a href="{{ route('login') }}" class="mobile-btn-login">
                <i class="fas fa-sign-in-alt"></i> <span class="translate-text" data-original="Login">Login</span>
            </a>
            <a href="{{ route('register') }}" class="mobile-btn-register">
                <i class="fas fa-user-plus"></i> <span class="translate-text" data-original="Register">Register</span>
            </a>
        </div>
        @endauth

        <div class="mobile-contact">
            <a href="tel:+18335338228"><i class="fas fa-phone-alt"></i> <span class="translate-text" data-original="+1 (833) 533-8228">+1 (833) 533-8228</span></a>
            <a href="mailto:contact@educonecx.com"><i class="fas fa-envelope"></i> <span class="translate-text" data-original="contact@educonecx.com">contact@educonecx.com</span></a>
        </div>
    </div>

    <style>
        /* Top Bar */
        .top-bar {
            background: var(--dark);
            color: var(--white);
            padding: 8px 0;
            font-size: 0.9rem;
        }

        .top-bar-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .contact-info a {
            margin-right: 20px;
            color: var(--white);
            opacity: 0.8;
            transition: var(--transition);
        }

        .contact-info a:hover {
            opacity: 1;
        }

        .contact-info i {
            margin-right: 5px;
            color: var(--secondary);
        }

        .social-links a {
            color: var(--white);
            margin-left: 15px;
            opacity: 0.8;
            transition: var(--transition);
            display: inline-block;
        }

        .social-links a:hover {
            opacity: 1;
            transform: translateY(-2px);
        }

        /* Main Header */
        .main-header {
            background: var(--white);
            box-shadow: var(--shadow-sm);
            position: sticky;
            top: 0;
            z-index: 1000;
            transition: var(--transition);
        }

        .main-header.scrolled {
            padding: 10px 0;
            box-shadow: var(--shadow-md);
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 0;
        }

        /* Logo */
        .logo a {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo-img {
            height: 50px;
            width: auto;
            transition: var(--transition);
        }

        .logo-text {
            font-size: 1.5rem;
            font-weight: 800;
            background: var(--gradient-1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: none;
        }

        @media (min-width: 768px) {
            .logo-text {
                display: block;
            }
        }

        /* Navigation */
        .main-nav {
            flex: 1;
            margin: 0 30px;
        }

        .nav-menu {
            display: flex;
            list-style: none;
            justify-content: center;
            gap: 20px;
        }

        .nav-menu li a {
            font-weight: 500;
            padding: 8px 0;
            position: relative;
            color: var(--dark);
        }

        .nav-menu li a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background: var(--gradient-1);
            transition: var(--transition);
        }

        .nav-menu li a:hover::after,
        .nav-menu li a.active::after {
            width: 100%;
        }

        .nav-menu li a.active {
            color: var(--primary);
        }

        /* Header Right */
        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        /* Language Selector Styles */
        .language-selector-container {
            position: relative;
            display: inline-block;
        }

        .language-dropdown {
            position: relative;
        }

        .language-toggle {
            background: var(--white);
            border: 1px solid var(--gray-light);
            border-radius: var(--border-radius-full);
            padding: 8px 16px;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: var(--transition);
            min-width: 120px;
        }

        .language-toggle:hover {
            border-color: var(--primary);
            box-shadow: var(--shadow-sm);
        }

        .language-toggle .current-flag {
            font-size: 1.2rem;
        }

        .language-toggle .current-language {
            font-weight: 500;
            color: var(--dark);
            flex: 1;
        }

        .language-toggle i {
            color: var(--gray);
            font-size: 0.8rem;
            transition: transform 0.3s;
        }

        .language-dropdown.active .language-toggle i {
            transform: rotate(180deg);
        }

        .language-menu {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            width: 280px;
            background: var(--white);
            border-radius: var(--border-radius-md);
            box-shadow: var(--shadow-lg);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: var(--transition);
            z-index: 1000;
            border: 1px solid var(--gray-light);
            overflow: hidden;
        }

        .language-dropdown.active .language-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .language-search {
            padding: 12px;
            border-bottom: 1px solid var(--gray-light);
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--light);
        }

        .language-search i {
            color: var(--gray);
            font-size: 0.9rem;
        }

        .language-search input {
            border: none;
            background: transparent;
            width: 100%;
            outline: none;
            font-size: 0.9rem;
        }

        .language-search input::placeholder {
            color: var(--gray);
        }

        .language-list {
            max-height: 300px;
            overflow-y: auto;
            padding: 8px;
        }

        .language-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: var(--border-radius-sm);
            cursor: pointer;
            transition: var(--transition);
        }

        .language-item:hover {
            background: var(--light);
        }

        .language-item.active {
            background: rgba(67, 97, 238, 0.1);
            color: var(--primary);
        }

        .language-item .flag {
            font-size: 1.2rem;
        }

        .language-item .language-name {
            flex: 1;
            font-weight: 500;
        }

        .language-item .native-name {
            color: var(--gray);
            font-size: 0.85rem;
        }

        .language-item i {
            color: var(--primary);
            opacity: 0;
            transition: var(--transition);
        }

        .language-item.active i {
            opacity: 1;
        }

        /* Auth Buttons */
        .auth-buttons {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-login,
        .btn-register {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: var(--border-radius-full);
            font-weight: 600;
            font-size: 0.95rem;
            transition: var(--transition);
            text-decoration: none;
        }

        .btn-login {
            background: transparent;
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .btn-login:hover {
            background: var(--primary);
            color: var(--white);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-register {
            background: var(--gradient-1);
            color: var(--white);
            border: 2px solid transparent;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        /* Profile Dropdown */
        .profile-dropdown {
            position: relative;
        }

        .profile-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            background: none;
            border: none;
            cursor: pointer;
            padding: 5px 10px;
            border-radius: var(--border-radius-full);
            transition: var(--transition);
        }

        .profile-btn:hover {
            background: var(--light);
        }

        .profile-btn img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary);
        }

        .profile-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--gradient-1);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1.1rem;
            border: 2px solid var(--primary);
        }

        .profile-name {
            font-weight: 600;
            color: var(--dark);
            max-width: 120px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: var(--white);
            border-radius: var(--border-radius-md);
            box-shadow: var(--shadow-lg);
            min-width: 220px;
            padding: 10px 0;
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px);
            transition: var(--transition);
            z-index: 1000;
        }

        .profile-dropdown:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(10px);
        }

        .dropdown-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            color: var(--dark);
            transition: var(--transition);
            font-size: 0.95rem;
        }

        .dropdown-menu a:hover {
            background: var(--light);
            color: var(--primary);
            padding-left: 25px;
        }

        .dropdown-menu i {
            width: 20px;
            color: var(--primary);
            font-size: 1rem;
        }

        .dropdown-divider {
            height: 1px;
            background: var(--gray-light);
            margin: 8px 0;
        }

        /* Mobile Toggle */
        .mobile-toggle {
            display: none;
            flex-direction: column;
            gap: 6px;
            background: none;
            border: none;
            cursor: pointer;
            padding: 5px;
        }

        .mobile-toggle span {
            display: block;
            width: 25px;
            height: 3px;
            background: var(--dark);
            border-radius: 3px;
            transition: var(--transition);
        }

        .mobile-toggle.active span:nth-child(1) {
            transform: rotate(45deg) translate(6px, 6px);
        }

        .mobile-toggle.active span:nth-child(2) {
            opacity: 0;
        }

        .mobile-toggle.active span:nth-child(3) {
            transform: rotate(-45deg) translate(6px, -6px);
        }

        /* Mobile Menu */
        .mobile-menu {
            display: none;
            background: var(--white);
            padding: 20px;
            box-shadow: var(--shadow-lg);
            border-top: 1px solid var(--gray-light);
            max-height: 80vh;
            overflow-y: auto;
        }

        .mobile-menu.active {
            display: block;
        }

        .mobile-nav-menu {
            list-style: none;
        }

        .mobile-nav-menu li a {
            display: block;
            padding: 12px 0;
            border-bottom: 1px solid var(--gray-light);
            color: var(--dark);
            transition: var(--transition);
        }

        .mobile-nav-menu li a:hover,
        .mobile-nav-menu li a.active {
            color: var(--primary);
            padding-left: 10px;
        }

        /* Mobile Auth */
        .mobile-auth {
            margin: 20px 0;
            padding: 15px;
            background: var(--light);
            border-radius: var(--border-radius-md);
        }

        .mobile-user-info {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--gray-light);
        }

        .mobile-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--gradient-1);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1.2rem;
        }

        .mobile-user-details {
            flex: 1;
        }

        .mobile-user-name {
            display: block;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 3px;
        }

        .mobile-user-email {
            display: block;
            font-size: 0.85rem;
            color: var(--gray);
        }

        .mobile-auth-buttons {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin: 20px 0;
        }

        .mobile-btn-login,
        .mobile-btn-register {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 14px;
            border-radius: var(--border-radius-md);
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
        }

        .mobile-btn-login {
            background: transparent;
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .mobile-btn-login:hover {
            background: var(--primary);
            color: var(--white);
        }

        .mobile-btn-register {
            background: var(--gradient-1);
            color: var(--white);
        }

        .mobile-btn-register:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .mobile-contact {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid var(--gray-light);
        }

        .mobile-contact a {
            display: block;
            padding: 8px 0;
            color: var(--dark);
            opacity: 0.8;
        }

        .mobile-contact i {
            margin-right: 10px;
            color: var(--primary);
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .main-nav {
                display: none;
            }

            .mobile-toggle {
                display: flex;
            }

            .profile-name {
                display: none;
            }

            .btn-login span,
            .btn-register span {
                display: none;
            }

            .btn-login,
            .btn-register {
                padding: 8px 12px;
            }

            .btn-login i,
            .btn-register i {
                font-size: 1.1rem;
                margin: 0;
            }

            .language-toggle .current-language {
                display: none;
            }

            .language-toggle {
                min-width: auto;
                padding: 8px 12px;
            }
        }

        @media (max-width: 768px) {
            .top-bar-content {
                flex-direction: column;
                gap: 10px;
                text-align: center;
            }

            .contact-info a {
                margin: 0 10px;
            }

            .language-menu {
                width: 250px;
                right: -50px;
            }
        }

        @media (max-width: 576px) {
            .language-menu {
                position: fixed;
                top: auto;
                bottom: 0;
                left: 0;
                right: 0;
                width: 100%;
                max-height: 80vh;
                border-radius: var(--border-radius-lg) var(--border-radius-lg) 0 0;
                transform: translateY(100%);
            }

            .language-dropdown.active .language-menu {
                transform: translateY(0);
            }

            .language-list {
                max-height: 60vh;
            }
        }
    </style>

    <script>
        // Sticky Header
        window.addEventListener('scroll', function() {
            const header = document.getElementById('mainHeader');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // Mobile Menu Toggle
        const mobileToggle = document.getElementById('mobileToggle');
        const mobileMenu = document.getElementById('mobileMenu');

        mobileToggle.addEventListener('click', function() {
            this.classList.toggle('active');
            mobileMenu.classList.toggle('active');
            document.body.classList.toggle('menu-open');
        });

        // Close mobile menu on link click
        document.querySelectorAll('.mobile-nav-menu a, .mobile-btn-login, .mobile-btn-register, .mobile-auth a').forEach(link => {
            link.addEventListener('click', () => {
                mobileToggle.classList.remove('active');
                mobileMenu.classList.remove('active');
                document.body.classList.remove('menu-open');
            });
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            if (window.innerWidth <= 1024) {
                if (!mobileMenu.contains(event.target) && !mobileToggle.contains(event.target)) {
                    mobileToggle.classList.remove('active');
                    mobileMenu.classList.remove('active');
                    document.body.classList.remove('menu-open');
                }
            }
        });

        // Language Selector JavaScript - FIXED VERSION
        document.addEventListener('DOMContentLoaded', function() {
            // Language data
            const languages = {
                'en': { name: 'English', flag: '🇺🇸', native: 'English' },
                'es': { name: 'Spanish', flag: '🇪🇸', native: 'Español' },
                'fr': { name: 'French', flag: '🇫🇷', native: 'Français' },
                'de': { name: 'German', flag: '🇩🇪', native: 'Deutsch' },
                'it': { name: 'Italian', flag: '🇮🇹', native: 'Italiano' },
                'pt': { name: 'Portuguese', flag: '🇵🇹', native: 'Português' },
                'nl': { name: 'Dutch', flag: '🇳🇱', native: 'Nederlands' },
                'pl': { name: 'Polish', flag: '🇵🇱', native: 'Polski' },
                'ru': { name: 'Russian', flag: '🇷🇺', native: 'Русский' },
                'ja': { name: 'Japanese', flag: '🇯🇵', native: '日本語' },
                'zh': { name: 'Chinese', flag: '🇨🇳', native: '中文' }
            };

            let currentLanguage = 'en';

            // Function to update active state in dropdown
            function updateActiveLanguageInDropdown(activeLang) {
                const items = document.querySelectorAll('.language-item');
                items.forEach(item => {
                    const code = item.dataset.lang;
                    if (code === activeLang) {
                        item.classList.add('active');
                        // Add checkmark
                        const checkIcon = item.querySelector('i.fa-check');
                        if (!checkIcon) {
                            item.innerHTML += '<i class="fas fa-check"></i>';
                        }
                    } else {
                        item.classList.remove('active');
                        // Remove checkmark
                        const checkIcon = item.querySelector('i.fa-check');
                        if (checkIcon) {
                            checkIcon.remove();
                        }
                    }
                });
            }

            // Fetch current language from server
            fetch('/api/current-language')
                .then(response => response.json())
                .then(data => {
                    currentLanguage = data.current;
                    updateLanguageDisplay(currentLanguage, data.info);
                    populateLanguageList(currentLanguage);
                })
                .catch(error => {
                    console.error('Error fetching language:', error);
                    // Fallback to English
                    populateLanguageList('en');
                });

            // Toggle dropdown
            const toggle = document.getElementById('languageToggle');
            const dropdown = document.querySelector('.language-dropdown');

            if (toggle) {
                toggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    dropdown.classList.toggle('active');
                });
            }

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (dropdown && !dropdown.contains(e.target)) {
                    dropdown.classList.remove('active');
                }
            });

            // Search functionality
            const searchInput = document.getElementById('languageSearch');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    filterLanguages(this.value);
                });
            }

            // Populate language list
            function populateLanguageList(activeLang) {
                const list = document.getElementById('languageList');
                if (!list) return;

                list.innerHTML = '';

                Object.entries(languages).forEach(([code, lang]) => {
                    const item = document.createElement('div');
                    item.className = `language-item ${code === activeLang ? 'active' : ''}`;
                    item.dataset.lang = code;

                    item.innerHTML = `
                        <span class="flag">${lang.flag}</span>
                        <span class="language-name">${lang.name}</span>
                        <span class="native-name">${lang.native}</span>
                        ${code === activeLang ? '<i class="fas fa-check"></i>' : ''}
                    `;

                    item.addEventListener('click', function() {
                        switchLanguage(code);
                    });

                    list.appendChild(item);
                });
            }

            // Filter languages based on search
            function filterLanguages(searchTerm) {
                const items = document.querySelectorAll('.language-item');
                const term = searchTerm.toLowerCase();

                items.forEach(item => {
                    const name = item.querySelector('.language-name').textContent.toLowerCase();
                    const native = item.querySelector('.native-name').textContent.toLowerCase();

                    if (name.includes(term) || native.includes(term)) {
                        item.style.display = 'flex';
                    } else {
                        item.style.display = 'none';
                    }
                });
            }

            // Switch language - FIXED VERSION
            function switchLanguage(lang) {
                // Show loading indicator on the toggle button
                const toggle = document.getElementById('languageToggle');
                const originalContent = toggle.innerHTML;
                toggle.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                toggle.disabled = true;

                // Close dropdown
                document.querySelector('.language-dropdown').classList.remove('active');

                // Use the global translation system
                if (window.translationSystem) {
                    // First, update the server session silently
                    fetch(`/language/${lang}`, {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    }).catch(err => console.log('Session update error:', err));

                    // Then translate the page
                    window.translationSystem.translatePage(lang).then(() => {
                        // AFTER translation completes, update the language display
                        updateLanguageDisplay(lang, languages[lang]);
                        
                        // Update active state in dropdown
                        updateActiveLanguageInDropdown(lang);
                        
                        // Update current language variable
                        currentLanguage = lang;

                        // Reset toggle button to show the new language
                        toggle.innerHTML = `<span class="current-flag">${languages[lang].flag}</span><span class="current-language">${languages[lang].native}</span><i class="fas fa-chevron-down"></i>`;
                        toggle.disabled = false;

                        console.log('Language switched to:', lang);
                    }).catch(error => {
                        console.error('Translation error:', error);
                        // Revert the toggle button on error
                        toggle.innerHTML = originalContent;
                        toggle.disabled = false;
                        // Fallback to redirect
                        window.location.href = `/language/${lang}`;
                    });
                } else {
                    // Fallback to redirect if translation system not available
                    window.location.href = `/language/${lang}`;
                }
            }

            // Update language display
            function updateLanguageDisplay(code, info) {
                const flagEl = document.getElementById('currentFlag');
                const langEl = document.getElementById('currentLanguage');

                if (flagEl) flagEl.textContent = info.flag;
                if (langEl) langEl.textContent = info.native;
            }
        });
    </script>
</header>