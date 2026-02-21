<header>
    <div class="header-container" style="
        background: var(--white);
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        position: sticky;
        top: 0;
        z-index: 1000;
    ">
        <div class="container" style="
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 20px;
        ">
            <!-- Logo -->
            <div class="logo" style="flex: 0 0 auto;">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('images/logo.jpg') }}" alt="EDUCONECX Logo" style="height: 50px; width: auto;">
                </a>
            </div>

            <!-- Navigation Menu -->
            <nav class="main-nav" style="flex: 1; margin: 0 30px;">
                <ul style="
                    display: flex;
                    list-style: none;
                    justify-content: center;
                    gap: 25px;
                ">
                    <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}" style="font-weight: 500; padding: 5px 0; border-bottom: 2px solid transparent; transition: all 0.3s;">Home</a></li>
                    <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}" style="font-weight: 500; padding: 5px 0; border-bottom: 2px solid transparent; transition: all 0.3s;">About</a></li>
                    <li><a href="{{ route('academy') }}" class="{{ request()->routeIs('academy') ? 'active' : '' }}" style="font-weight: 500; padding: 5px 0; border-bottom: 2px solid transparent; transition: all 0.3s;">Academy</a></li>
                    <!-- In the navigation menu, update the Courses link -->
                    <li><a href="{{ route('courses') }}" class="{{ request()->routeIs('courses') || request()->routeIs('courses.*') ? 'active' : '' }}" style="font-weight: 500; padding: 5px 0; border-bottom: 2px solid transparent; transition: all 0.3s;">All Courses</a></li>
                    <li><a href="{{ route('neo-ed-tech') }}" class="{{ request()->routeIs('neo-ed-tech') ? 'active' : '' }}" style="font-weight: 500; padding: 5px 0; border-bottom: 2px solid transparent; transition: all 0.3s;">NEO ED-TECH</a></li>
                    <!-- In the navigation menu, update the Blog link -->
                    <li><a href="{{ route('blog') }}" class="{{ request()->routeIs('blog') || request()->routeIs('blog.show') ? 'active' : '' }}" style="font-weight: 500; padding: 5px 0; border-bottom: 2px solid transparent; transition: all 0.3s;">Blog</a></li>
                    <li><a href="{{ route('our-team') }}" class="{{ request()->routeIs('our-team') ? 'active' : '' }}" style="font-weight: 500; padding: 5px 0; border-bottom: 2px solid transparent; transition: all 0.3s;">Our Team</a></li>
                    <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}" style="font-weight: 500; padding: 5px 0; border-bottom: 2px solid transparent; transition: all 0.3s;">Contact</a></li>
                    <li><a href="{{ route('quiz') }}" class="{{ request()->routeIs('quiz') ? 'active' : '' }}" style="font-weight: 500; padding: 5px 0; border-bottom: 2px solid transparent; transition: all 0.3s;">Quiz</a></li>
                </ul>
            </nav>

            <!-- Profile -->
            <div class="profile" style="flex: 0 0 auto;">
                <a href="{{ route('dashboard') }}" style="display: flex; align-items: center; gap: 8px;">
                    <img src="https://secure.gravatar.com/avatar/?s=32&d=mm&r=g" alt="Profile" style="width: 32px; height: 32px; border-radius: 50%;">
                    <span>Profile</span>
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <button class="mobile-menu-toggle" style="display: none; background: none; border: none; font-size: 24px;">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>

    <style>
        .main-nav ul li a:hover,
        .main-nav ul li a.active {
            color: var(--primary-color);
            border-bottom-color: var(--primary-color);
        }

        @media (max-width: 1024px) {
            .main-nav {
                display: none;
            }

            .mobile-menu-toggle {
                display: block !important;
            }

            .main-nav.active {
                display: block;
                position: absolute;
                top: 70px;
                left: 0;
                right: 0;
                background: var(--white);
                padding: 20px;
                box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            }

            .main-nav.active ul {
                flex-direction: column;
                gap: 15px;
            }
        }
    </style>

    <script>
        document.querySelector('.mobile-menu-toggle')?.addEventListener('click', function() {
            document.querySelector('.main-nav').classList.toggle('active');
        });
    </script>
</header>