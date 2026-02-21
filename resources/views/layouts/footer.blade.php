<footer class="footer">
    <!-- Newsletter Section -->
    <div class="newsletter-section">
        <div class="container">
            <div class="newsletter-content" data-aos="fade-up">
                <div class="newsletter-text">
                    <h3>Stay Updated with EDUCONECX</h3>
                    <p>Subscribe to our newsletter and get the latest updates, courses, and exclusive offers.</p>
                </div>
                <form class="newsletter-form">
                    <div class="form-group">
                        <input type="email" placeholder="Enter your email address" required>
                        <button type="submit" class="btn btn-primary">Subscribe</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Footer -->
    <div class="footer-main">
        <div class="container">
            <div class="footer-grid">
                <!-- Company Info -->
                <div class="footer-col" data-aos="fade-up" data-aos-delay="100">
                    <div class="footer-logo">
                        <img src="{{ asset('images/logo.jpg') }}" alt="EDUCONECX Logo">
                        <span>EDUCONECX</span>
                    </div>
                    <p class="footer-desc">Empowering learning, connecting futures. International AI-powered educational platform that empowers learners worldwide with practical language and digital business skills.</p>
                    <div class="footer-social">
                        <a href="https://www.facebook.com/profile.php?id=61584601012851" target="_blank" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.tiktok.com/@educonecx.officia" target="_blank" class="social-icon"><i class="fab fa-tiktok"></i></a>
                        <a href="https://www.instagram.com/educonecx/" target="_blank" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.youtube.com/@EDUCONECX" target="_blank" class="social-icon"><i class="fab fa-youtube"></i></a>
                        <a href="https://wa.me/18335338228" target="_blank" class="social-icon"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="footer-col" data-aos="fade-up" data-aos-delay="200">
                    <h4>Quick Links</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('about') }}"><i class="fas fa-chevron-right"></i> About Us</a></li>
                        <li><a href="{{ route('courses') }}"><i class="fas fa-chevron-right"></i> Courses</a></li>
                        <li><a href="{{ route('blog') }}"><i class="fas fa-chevron-right"></i> Blog</a></li>
                        <li><a href="{{ route('our-team') }}"><i class="fas fa-chevron-right"></i> Our Team</a></li>
                        <li><a href="{{ route('contact') }}"><i class="fas fa-chevron-right"></i> Contact</a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div class="footer-col" data-aos="fade-up" data-aos-delay="300">
                    <h4>Support</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('faqs') }}"><i class="fas fa-chevron-right"></i> FAQs</a></li>
                        <li><a href="{{ route('pricing') }}"><i class="fas fa-chevron-right"></i>Pricing</a></li>
                        <li><a href="{{ route('privacy') }}"><i class="fas fa-chevron-right"></i> Privacy Policy</a></li>
                        <li><a href="{{ route('refund') }}"><i class="fas fa-chevron-right"></i> Refund Policy</a></li>
                        <li><a href="{{ route('terms') }}"><i class="fas fa-chevron-right"></i> Terms & Conditions</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="footer-col" data-aos="fade-up" data-aos-delay="400">
                    <h4>Contact Info</h4>
                    <ul class="footer-contact">
                        <li>
                            <i class="fas fa-phone-alt"></i>
                            <div>
                                <span>Phone</span>
                                <a href="tel:+18335338228">+1 (833) 533-8228</a>
                            </div>
                        </li>
                        <li>
                            <i class="fas fa-envelope"></i>
                            <div>
                                <span>Email</span>
                                <a href="mailto:contact@educonecx.com">contact@educonecx.com</a>
                            </div>
                        </li>
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            <div>
                                <span>Address</span>
                                <p>1200 Brickell Ave, Miami, FL 33131, USA</p>
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
                <p>&copy; {{ date('Y') }} EDUCONECX, LLC. All rights reserved.</p>
                <div class="footer-bottom-links">
                    <a href="{{ route('privacy') }}">Privacy</a>
                    <a href="{{ route('terms') }}">Terms</a>
                    <a href="{{ route('refund') }}">Refund Policy</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Back to Top Button -->
    <button class="back-to-top" id="backToTop">
        <i class="fas fa-arrow-up"></i>
    </button>

    <style>
        .footer {
            background: var(--dark);
            color: var(--white);
            position: relative;
        }

        /* Newsletter Section */
        .newsletter-section {
            background: var(--gradient-1);
            padding: 60px 0;
            position: relative;
            overflow: hidden;
        }

        .newsletter-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.1);
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
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 8s ease-in-out infinite reverse;
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

        .newsletter-text h3 {
            font-size: 2rem;
            margin-bottom: 10px;
            color: var(--white);
        }

        .newsletter-text p {
            opacity: 0.9;
            font-size: 1.1rem;
        }

        .newsletter-form {
            flex: 1;
            min-width: 300px;
        }

        .form-group {
            display: flex;
            gap: 10px;
            background: var(--white);
            padding: 5px;
            border-radius: var(--border-radius-full);
            box-shadow: var(--shadow-lg);
        }

        .form-group input {
            flex: 1;
            border: none;
            padding: 15px 20px;
            border-radius: var(--border-radius-full);
            font-size: 1rem;
            outline: none;
        }

        .form-group .btn {
            padding: 15px 30px;
            white-space: nowrap;
        }

        /* Main Footer */
        .footer-main {
            padding: 80px 0 60px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1.5fr;
            gap: 40px;
        }

        @media (max-width: 1024px) {
            .footer-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .footer-grid {
                grid-template-columns: 1fr;
            }
        }

        .footer-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .footer-logo img {
            height: 50px;
            width: auto;
        }

        .footer-logo span {
            font-size: 1.5rem;
            font-weight: 700;
            background: var(--gradient-1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .footer-desc {
            margin-bottom: 20px;
            line-height: 1.8;
            opacity: 0.8;
        }

        .footer-social {
            display: flex;
            gap: 10px;
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
        }

        .social-icon:hover {
            background: var(--primary);
            transform: translateY(-5px);
        }

        .footer-col h4 {
            font-size: 1.2rem;
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 10px;
        }

        .footer-col h4::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 3px;
            background: var(--gradient-1);
            border-radius: var(--border-radius-full);
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            color: var(--white);
            opacity: 0.8;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .footer-links a:hover {
            opacity: 1;
            transform: translateX(5px);
            color: var(--primary);
        }

        .footer-links i {
            font-size: 0.8rem;
            color: var(--primary);
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
            color: var(--primary);
            font-size: 1.1rem;
        }

        .footer-contact li div {
            flex: 1;
        }

        .footer-contact li span {
            display: block;
            font-size: 0.9rem;
            opacity: 0.7;
            margin-bottom: 5px;
        }

        .footer-contact li a,
        .footer-contact li p {
            color: var(--white);
            opacity: 0.9;
            transition: var(--transition);
        }

        .footer-contact li a:hover {
            color: var(--primary);
            opacity: 1;
        }

        /* Footer Bottom */
        .footer-bottom {
            background: rgba(0, 0, 0, 0.2);
            padding: 20px 0;
        }

        .footer-bottom-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .footer-bottom-links {
            display: flex;
            gap: 20px;
        }

        .footer-bottom-links a {
            color: var(--white);
            opacity: 0.7;
            transition: var(--transition);
        }

        .footer-bottom-links a:hover {
            opacity: 1;
            color: var(--primary);
        }

        /* Back to Top Button */
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: var(--gradient-1);
            border: none;
            border-radius: 50%;
            color: var(--white);
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
        }

        .back-to-top.show {
            opacity: 1;
            visibility: visible;
        }

        .back-to-top:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
        }

        @media (max-width: 768px) {
            .newsletter-content {
                flex-direction: column;
                text-align: center;
            }

            .form-group {
                flex-direction: column;
                background: transparent;
            }

            .footer-bottom-content {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>

    <script>
        // Back to Top Button
        const backToTop = document.getElementById('backToTop');

        window.addEventListener('scroll', function() {
            if (window.scrollY > 500) {
                backToTop.classList.add('show');
            } else {
                backToTop.classList.remove('show');
            }
        });

        backToTop.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Newsletter Form Submission
        document.querySelector('.newsletter-form')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const email = this.querySelector('input[type="email"]').value;
            // Add your newsletter subscription logic here
            alert('Thank you for subscribing! We\'ll keep you updated.');
            this.reset();
        });
    </script>
</footer>