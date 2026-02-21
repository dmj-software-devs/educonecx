<header>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
            <div class="top-bar-content">
                <div class="contact-info">
                    <a href="tel:+18335338228"><i class="fas fa-phone-alt"></i> +1 (833) 533-8228</a>
                    <a href="mailto:contact@educonecx.com"><i class="fas fa-envelope"></i> contact@educonecx.com</a>
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
                        <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
                        <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About</a></li>
                        <li><a href="{{ route('academy') }}" class="{{ request()->routeIs('academy') ? 'active' : '' }}">Academy</a></li>
                        <li><a href="{{ route('courses') }}" class="{{ request()->routeIs('courses') || request()->routeIs('courses.*') ? 'active' : '' }}">All Courses</a></li>
                        <li><a href="{{ route('neo-ed-tech') }}" class="{{ request()->routeIs('neo-ed-tech') ? 'active' : '' }}">NEO ED-TECH</a></li>
                        <li><a href="{{ route('blog') }}" class="{{ request()->routeIs('blog') || request()->routeIs('blog.show') ? 'active' : '' }}">Blog</a></li>
                        <li><a href="{{ route('our-team') }}" class="{{ request()->routeIs('our-team') ? 'active' : '' }}">Our Team</a></li>
                        <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a></li>
                        <li><a href="{{ route('quiz') }}" class="{{ request()->routeIs('quiz') ? 'active' : '' }}">Quiz</a></li>
                    </ul>
                </nav>

                <!-- Right Section -->
                <div class="header-right">
                    <!-- Profile Dropdown -->
                    <div class="profile-dropdown">
                        <button class="profile-btn">
                            <img src="https://secure.gravatar.com/avatar/?s=40&d=mm&r=g" alt="Profile">
                            <span>Profile</span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a href="{{ route('dashboard') }}"><i class="fas fa-user"></i> Dashboard</a>
                            <a href="#"><i class="fas fa-cog"></i> Settings</a>
                            <a href="#"><i class="fas fa-sign-out-alt"></i> Logout</a>
                        </div>
                    </div>

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
            <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
            <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About</a></li>
            <li><a href="{{ route('academy') }}" class="{{ request()->routeIs('academy') ? 'active' : '' }}">Academy</a></li>
            <li><a href="{{ route('courses') }}" class="{{ request()->routeIs('courses') || request()->routeIs('courses.*') ? 'active' : '' }}">All Courses</a></li>
            <li><a href="{{ route('neo-ed-tech') }}" class="{{ request()->routeIs('neo-ed-tech') ? 'active' : '' }}">NEO ED-TECH</a></li>
            <li><a href="{{ route('blog') }}" class="{{ request()->routeIs('blog') || request()->routeIs('blog.show') ? 'active' : '' }}">Blog</a></li>
            <li><a href="{{ route('our-team') }}" class="{{ request()->routeIs('our-team') ? 'active' : '' }}">Our Team</a></li>
            <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a></li>
            <li><a href="{{ route('quiz') }}" class="{{ request()->routeIs('quiz') ? 'active' : '' }}">Quiz</a></li>
        </ul>
        <div class="mobile-contact">
            <a href="tel:+18335338228"><i class="fas fa-phone-alt"></i> +1 (833) 533-8228</a>
            <a href="mailto:contact@educonecx.com"><i class="fas fa-envelope"></i> contact@educonecx.com</a>
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

        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: var(--white);
            border-radius: var(--border-radius-md);
            box-shadow: var(--shadow-lg);
            min-width: 200px;
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
            gap: 10px;
            padding: 10px 20px;
            color: var(--dark);
            transition: var(--transition);
        }

        .dropdown-menu a:hover {
            background: var(--light);
            color: var(--primary);
        }

        .dropdown-menu i {
            width: 20px;
            color: var(--primary);
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

            .profile-btn span {
                display: none;
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

            .profile-btn span {
                display: none;
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
        document.querySelectorAll('.mobile-nav-menu a').forEach(link => {
            link.addEventListener('click', () => {
                mobileToggle.classList.remove('active');
                mobileMenu.classList.remove('active');
                document.body.classList.remove('menu-open');
            });
        });
    </script>
</header>