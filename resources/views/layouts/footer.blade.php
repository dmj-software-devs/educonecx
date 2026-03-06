<footer class="footer">
    <!-- Newsletter Section - Liquid Style -->
    <div class="newsletter-section">
        <div class="container">
            <div class="newsletter-content" data-aos="fade-up">
                <div class="newsletter-text">
                    <h3>Stay Updated with <span>EDUCONECX</span></h3>
                    <p>{{ App\Helpers\TranslationHelper::trans('footer.newsletter_desc') }}</p>
                </div>
                <form class="newsletter-form">
                    <div class="form-group">
                        <input type="email" placeholder="{{ App\Helpers\TranslationHelper::trans('footer.your_email') }}" required>
                        <button type="submit" class="btn btn-primary">{{ App\Helpers\TranslationHelper::trans('footer.subscribe') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Footer - Liquid Style -->
    <div class="footer-main">
        <div class="container">
            <div class="footer-grid">
                <!-- Company Info -->
                <div class="footer-col" data-aos="fade-up" data-aos-delay="100">
                    <div class="footer-logo">
                        <img src="{{ asset('images/logo.jpg') }}" alt="EDUCONECX Logo">
                        <span>EDUCONECX</span>
                    </div>
                    <p class="footer-desc">{{ App\Helpers\TranslationHelper::trans('footer.company_desc') ?? 'Empowering learning, connecting futures. International AI-powered educational platform that empowers learners worldwide with practical language and digital business skills.' }}</p>
                    <div class="footer-social">
                        <a href="https://www.facebook.com/profile.php?id=61584601012851" target="_blank" class="social-icon" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.tiktok.com/@educonecx.officia" target="_blank" class="social-icon" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
                        <a href="https://www.instagram.com/educonecx/" target="_blank" class="social-icon" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.youtube.com/@EDUCONECX" target="_blank" class="social-icon" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                        <a href="https://wa.me/18335338228" target="_blank" class="social-icon" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="footer-col" data-aos="fade-up" data-aos-delay="200">
                    <h4>{{ App\Helpers\TranslationHelper::trans('footer.quick_links') }}</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('about') }}"><i class="fas fa-chevron-right"></i> {{ App\Helpers\TranslationHelper::trans('footer.about_us') }}</a></li>
                        <li><a href="{{ route('courses') }}"><i class="fas fa-chevron-right"></i> {{ App\Helpers\TranslationHelper::trans('header.courses') }}</a></li>
                        <li><a href="{{ route('blog') }}"><i class="fas fa-chevron-right"></i> {{ App\Helpers\TranslationHelper::trans('header.blog') }}</a></li>
                        <li><a href="{{ route('our-team') }}"><i class="fas fa-chevron-right"></i> {{ App\Helpers\TranslationHelper::trans('footer.our_team') }}</a></li>
                        <li><a href="{{ route('contact') }}"><i class="fas fa-chevron-right"></i> {{ App\Helpers\TranslationHelper::trans('header.contact') }}</a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div class="footer-col" data-aos="fade-up" data-aos-delay="300">
                    <h4>{{ App\Helpers\TranslationHelper::trans('footer.support') }}</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('faqs') }}"><i class="fas fa-chevron-right"></i> {{ App\Helpers\TranslationHelper::trans('footer.faqs') }}</a></li>
                        <li><a href="{{ route('pricing') }}"><i class="fas fa-chevron-right"></i> {{ App\Helpers\TranslationHelper::trans('footer.pricing') }}</a></li>
                        <li><a href="{{ route('privacy') }}"><i class="fas fa-chevron-right"></i> {{ App\Helpers\TranslationHelper::trans('footer.privacy_policy') }}</a></li>
                        <li><a href="{{ route('refund') }}"><i class="fas fa-chevron-right"></i> {{ App\Helpers\TranslationHelper::trans('footer.refund_policy') }}</a></li>
                        <li><a href="{{ route('terms') }}"><i class="fas fa-chevron-right"></i> {{ App\Helpers\TranslationHelper::trans('footer.terms_conditions') }}</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="footer-col" data-aos="fade-up" data-aos-delay="400">
                    <h4>{{ App\Helpers\TranslationHelper::trans('footer.contact_info') }}</h4>
                    <ul class="footer-contact">
                        <li>
                            <i class="fas fa-phone-alt"></i>
                            <div>
                                <span>{{ App\Helpers\TranslationHelper::trans('common.phone') }}</span>
                                <a href="tel:+18335338228">{{ App\Helpers\TranslationHelper::trans('header.phone') }}</a>
                            </div>
                        </li>
                        <li>
                            <i class="fas fa-envelope"></i>
                            <div>
                                <span>{{ App\Helpers\TranslationHelper::trans('common.email') }}</span>
                                <a href="mailto:contact@educonecx.com">{{ App\Helpers\TranslationHelper::trans('header.email') }}</a>
                            </div>
                        </li>
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            <div>
                                <span>{{ App\Helpers\TranslationHelper::trans('common.address') }}</span>
                                <p>{{ App\Helpers\TranslationHelper::trans('header.address') }}</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="container">
            <div class="footer-bottom-content">
                <p>&copy; {{ date('Y') }} {{ App\Helpers\TranslationHelper::trans('footer.copyright', ['year' => date('Y')]) }}</p>
                <div class="footer-bottom-links">
                    <a href="{{ route('privacy') }}">{{ App\Helpers\TranslationHelper::trans('footer.privacy') }}</a>
                    <a href="{{ route('terms') }}">{{ App\Helpers\TranslationHelper::trans('footer.terms') }}</a>
                    <a href="{{ route('refund') }}">{{ App\Helpers\TranslationHelper::trans('footer.refund_policy') }}</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Back to Top Button -->
    <button class="back-to-top" id="backToTop" aria-label="Back to top">
        <i class="fas fa-arrow-up"></i>
    </button>

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
            --primary-dark: var(--prussian-blue);
            --primary-light: var(--dark-slate);
            --secondary: var(--sky-blue);
            --accent: var(--bright-amber);
            --accent-soft: var(--light-gold);
            --dark: var(--prussian-blue);
            --dark-light: var(--regal-navy);
            --gray: var(--khaki-beige);
            --gray-light: var(--pale-slate);
            --light: var(--ivory);
            --white: var(--pure-white);
            
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
        }

        /* Footer Base */
        .footer {
            background: var(--prussian-blue);
            color: var(--pure-white);
            position: relative;
            overflow: hidden;
        }

        /* Newsletter Section - Liquid Style */
        .newsletter-section {
            background: var(--gradient-1);
            padding: 60px 0;
            position: relative;
            overflow: hidden;
            border-bottom: 1px solid rgba(251, 198, 12, 0.2);
        }

        .newsletter-section::before {
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

        .newsletter-section::after {
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

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        .newsletter-content {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 40px;
            flex-wrap: wrap;
        }

        .newsletter-text {
            flex: 1;
            min-width: 300px;
        }

        .newsletter-text h3 {
            font-size: clamp(1.8rem, 4vw, 2.2rem);
            margin-bottom: 10px;
            color: var(--pure-white);
            font-weight: 700;
        }

        .newsletter-text h3 span {
            color: var(--bright-amber);
        }

        .newsletter-text p {
            opacity: 0.9;
            font-size: 1.1rem;
            color: var(--ivory);
            line-height: 1.6;
        }

        .newsletter-form {
            flex: 1;
            min-width: 300px;
        }

        .form-group {
            display: flex;
            gap: 10px;
            background: rgba(255, 255, 255, 0.1);
            padding: 5px;
            border-radius: var(--radius-full);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(251, 198, 12, 0.2);
        }

        .form-group input {
            flex: 1;
            border: none;
            padding: 15px 20px;
            border-radius: var(--radius-full);
            font-size: 1rem;
            outline: none;
            background: var(--pure-white);
            color: var(--prussian-blue);
        }

        .form-group input::placeholder {
            color: var(--khaki-beige);
        }

        .form-group .btn {
            padding: 15px 30px;
            white-space: nowrap;
            background: var(--gradient-2);
            color: var(--prussian-blue);
            border: none;
            border-radius: var(--radius-full);
            font-weight: 600;
            transition: var(--transition);
        }

        .form-group .btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
        }

        /* Main Footer */
        .footer-main {
            padding: 60px 0 40px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1.5fr;
            gap: 40px;
        }

        /* Footer Columns */
        .footer-col {
            transition: var(--transition);
        }

        .footer-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .footer-logo img {
            height: 45px;
            width: auto;
            border-radius: var(--radius-sm);
        }

        .footer-logo span {
            font-size: 1.5rem;
            font-weight: 700;
            background: var(--gradient-2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .footer-desc {
            margin-bottom: 20px;
            line-height: 1.8;
            opacity: 0.9;
            color: var(--ivory);
            font-size: 0.95rem;
        }

        .footer-social {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .social-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            color: var(--pure-white);
            text-decoration: none;
            border: 1px solid rgba(251, 198, 12, 0.2);
        }

        .social-icon:hover {
            background: var(--bright-amber);
            color: var(--prussian-blue);
            transform: translateY(-5px);
            border-color: transparent;
        }

        .footer-col h4 {
            font-size: 1.2rem;
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 10px;
            color: var(--pure-white);
        }

        .footer-col h4::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 3px;
            background: var(--gradient-2);
            border-radius: var(--radius-full);
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            color: var(--ivory);
            opacity: 0.9;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            font-size: 0.95rem;
        }

        .footer-links a:hover {
            opacity: 1;
            transform: translateX(5px);
            color: var(--bright-amber);
        }

        .footer-links i {
            font-size: 0.75rem;
            color: var(--bright-amber);
        }

        .footer-contact {
            list-style: none;
        }

        .footer-contact li {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .footer-contact li i {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--bright-amber);
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .footer-contact li div {
            flex: 1;
        }

        .footer-contact li span {
            display: block;
            font-size: 0.8rem;
            opacity: 0.7;
            margin-bottom: 5px;
            color: var(--khaki-beige);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .footer-contact li a,
        .footer-contact li p {
            color: var(--pure-white);
            opacity: 0.9;
            transition: var(--transition);
            text-decoration: none;
            font-size: 0.95rem;
            line-height: 1.5;
        }

        .footer-contact li a:hover {
            color: var(--bright-amber);
            opacity: 1;
        }

        /* Footer Bottom */
        .footer-bottom {
            background: rgba(0, 0, 0, 0.2);
            padding: 20px 0;
            border-top: 1px solid rgba(251, 198, 12, 0.1);
        }

        .footer-bottom-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .footer-bottom-content p {
            color: var(--ivory);
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .footer-bottom-links {
            display: flex;
            gap: 25px;
            flex-wrap: wrap;
        }

        .footer-bottom-links a {
            color: var(--ivory);
            opacity: 0.8;
            transition: var(--transition);
            text-decoration: none;
            font-size: 0.9rem;
        }

        .footer-bottom-links a:hover {
            opacity: 1;
            color: var(--bright-amber);
        }

        /* Back to Top Button */
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: var(--gradient-2);
            border: none;
            border-radius: 50%;
            color: var(--prussian-blue);
            font-size: 1.2rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
            z-index: 999;
            box-shadow: var(--shadow-lg);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .back-to-top.show {
            opacity: 1;
            visibility: visible;
        }

        .back-to-top:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
            background: var(--gradient-1);
            color: var(--pure-white);
        }

        /* Responsive Breakpoints */
        @media (max-width: 1200px) {
            .footer-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 30px;
            }
        }

        @media (max-width: 992px) {
            .newsletter-content {
                flex-direction: column;
                text-align: center;
            }

            .newsletter-text {
                text-align: center;
            }

            .newsletter-text h3::after {
                left: 50%;
                transform: translateX(-50%);
            }
        }

        @media (max-width: 768px) {
            .newsletter-section {
                padding: 40px 0;
            }

            .newsletter-text h3 {
                font-size: 1.8rem;
            }

            .newsletter-text p {
                font-size: 1rem;
            }

            .form-group {
                flex-direction: column;
                background: transparent;
                padding: 0;
            }

            .form-group input {
                width: 100%;
            }

            .form-group .btn {
                width: 100%;
            }

            .footer-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .footer-col {
                text-align: center;
            }

            .footer-col h4::after {
                left: 50%;
                transform: translateX(-50%);
            }

            .footer-links a {
                justify-content: center;
            }

            .footer-contact li {
                justify-content: center;
                text-align: left;
            }

            .footer-social {
                justify-content: center;
            }

            .footer-bottom-content {
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }

            .footer-bottom-links {
                justify-content: center;
            }

            .back-to-top {
                bottom: 20px;
                right: 20px;
                width: 45px;
                height: 45px;
                font-size: 1rem;
            }
        }

        @media (max-width: 576px) {
            .footer-main {
                padding: 40px 0 30px;
            }

            .footer-logo {
                justify-content: center;
            }

            .footer-logo img {
                height: 40px;
            }

            .footer-logo span {
                font-size: 1.3rem;
            }

            .footer-desc {
                font-size: 0.9rem;
            }

            .footer-contact li {
                flex-direction: column;
                align-items: center;
                text-align: center;
                gap: 10px;
            }

            .footer-contact li i {
                margin-bottom: 5px;
            }

            .footer-bottom-links {
                gap: 15px;
            }

            .footer-bottom-links a {
                font-size: 0.85rem;
            }

            .footer-bottom-content p {
                font-size: 0.85rem;
            }
        }

        /* Mobile Menu Fix */
        @media (max-width: 480px) {
            .newsletter-text h3 {
                font-size: 1.5rem;
            }

            .footer-bottom-links {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>

    <script>
        // Back to Top Button with throttle
        const backToTop = document.getElementById('backToTop');
        let scrollTimeout;

        window.addEventListener('scroll', function() {
            if (!scrollTimeout) {
                scrollTimeout = setTimeout(function() {
                    if (window.scrollY > 500) {
                        backToTop.classList.add('show');
                    } else {
                        backToTop.classList.remove('show');
                    }
                    scrollTimeout = null;
                }, 100);
            }
        });

        backToTop.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Newsletter Form Submission with validation
        const newsletterForm = document.querySelector('.newsletter-form');
        if (newsletterForm) {
            newsletterForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const emailInput = this.querySelector('input[type="email"]');
                const email = emailInput.value.trim();
                
                // Simple email validation
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                
                if (!emailRegex.test(email)) {
                    alert('Please enter a valid email address.');
                    return;
                }

                // Show success message
                const button = this.querySelector('button');
                const originalText = button.textContent;
                button.textContent = 'Subscribed!';
                button.disabled = true;
                
                setTimeout(() => {
                    button.textContent = originalText;
                    button.disabled = false;
                }, 2000);

                // Reset form
                this.reset();

                // Here you would typically send the email to your server
                console.log('Newsletter subscription:', email);
            });
        }

        // Smooth scroll for footer links (if they point to sections on the same page)
        document.querySelectorAll('.footer-links a[href^="#"]').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Current year in copyright (already handled by Blade)
    </script>
</footer>