@extends('layouts.main')

@section('title', 'Contact Us - EDUCONECX | Get in Touch')

@section('meta_description', 'Get in touch with EDUCONECX. Have questions about our courses, partnerships, or anything else? Our team is here to help.')

@push('styles')
<style>
    /* Hero Section */
    .contact-hero {
        position: relative;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 100px 0;
        overflow: hidden;
        color: var(--white);
    }

    .contact-hero-particles {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    .contact-hero-particle {
        position: absolute;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .contact-hero-particle:nth-child(1) {
        width: 300px;
        height: 300px;
        top: -100px;
        right: -100px;
        animation: float 8s ease-in-out infinite;
    }

    .contact-hero-particle:nth-child(2) {
        width: 200px;
        height: 200px;
        bottom: -50px;
        left: -50px;
        animation: float 10s ease-in-out infinite reverse;
    }

    .contact-hero-particle:nth-child(3) {
        width: 150px;
        height: 150px;
        top: 30%;
        left: 20%;
        animation: float 12s ease-in-out infinite;
    }

    .contact-hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
        max-width: 800px;
        margin: 0 auto;
    }

    .contact-hero-badge {
        display: inline-block;
        padding: 8px 20px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: var(--border-radius-full);
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 25px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        animation: fadeInDown 1s ease-out;
    }

    .contact-hero-title {
        font-size: clamp(2.5rem, 8vw, 4rem);
        font-weight: 800;
        margin-bottom: 20px;
        line-height: 1.1;
        text-shadow: 0 2px 10px rgba(0,0,0,0.3);
        animation: fadeInUp 1s ease-out 0.2s both;
    }

    .contact-hero-text {
        font-size: clamp(1.1rem, 3vw, 1.3rem);
        opacity: 0.9;
        line-height: 1.8;
        max-width: 700px;
        margin: 0 auto;
        animation: fadeInUp 1s ease-out 0.4s both;
    }

    /* Contact Section */
    .contact-section {
        padding: 80px 0;
        background: var(--light);
    }

    .contact-grid {
        display: grid;
        grid-template-columns: 1fr 1.2fr;
        gap: 40px;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Contact Info Cards */
    .contact-info-wrapper {
        display: flex;
        flex-direction: column;
        gap: 30px;
    }

    .contact-info-card {
        background: var(--white);
        border-radius: var(--border-radius-lg);
        padding: 40px;
        box-shadow: var(--shadow-lg);
        position: relative;
        overflow: hidden;
    }

    .contact-info-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 5px;
        height: 100%;
        background: var(--gradient-1);
    }

    .info-icon {
        width: 60px;
        height: 60px;
        background: var(--gradient-1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 25px;
        color: var(--white);
        font-size: 1.5rem;
    }

    .info-title {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 15px;
        color: var(--dark);
    }

    .info-subtitle {
        font-size: 1.1rem;
        color: var(--primary);
        margin-bottom: 20px;
        font-weight: 600;
    }

    .info-description {
        color: var(--gray);
        line-height: 1.8;
        margin-bottom: 30px;
    }

    .info-list {
        list-style: none;
        padding: 0;
        margin-bottom: 30px;
    }

    .info-list li {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 20px;
        color: var(--gray);
        font-size: 1rem;
        transition: var(--transition);
    }

    .info-list li:hover {
        transform: translateX(5px);
    }

    .info-list li i {
        width: 40px;
        height: 40px;
        background: var(--light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        font-size: 1.1rem;
        transition: var(--transition);
    }

    .info-list li:hover i {
        background: var(--primary);
        color: var(--white);
    }

    .info-list li a {
        color: var(--gray);
        text-decoration: none;
        transition: color 0.3s;
        flex: 1;
    }

    .info-list li a:hover {
        color: var(--primary);
    }

    .info-list li span {
        flex: 1;
    }

    /* Business Hours */
    .hours-card {
        background: var(--white);
        border-radius: var(--border-radius-lg);
        padding: 40px;
        box-shadow: var(--shadow-lg);
    }

    .hours-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 25px;
        color: var(--dark);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .hours-title i {
        color: var(--primary);
    }

    .hours-grid {
        display: grid;
        gap: 15px;
    }

    .hours-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid var(--gray-light);
    }

    .hours-item:last-child {
        border-bottom: none;
    }

    .hours-day {
        font-weight: 600;
        color: var(--dark);
    }

    .hours-time {
        color: var(--primary);
        font-weight: 500;
    }

    .hours-note {
        margin-top: 20px;
        padding: 15px;
        background: var(--light);
        border-radius: var(--border-radius-md);
        color: var(--gray);
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .hours-note i {
        color: var(--primary);
    }

    /* Social Links */
    .social-card {
        background: var(--white);
        border-radius: var(--border-radius-lg);
        padding: 30px;
        box-shadow: var(--shadow-lg);
        text-align: center;
    }

    .social-title {
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 20px;
        color: var(--dark);
    }

    .social-grid {
        display: flex;
        justify-content: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    .social-link {
        width: 50px;
        height: 50px;
        background: var(--light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        font-size: 1.3rem;
        transition: var(--transition);
        text-decoration: none;
    }

    .social-link:hover {
        background: var(--primary);
        color: var(--white);
        transform: translateY(-5px);
    }

    /* Contact Form */
    .contact-form-container {
        background: var(--white);
        border-radius: var(--border-radius-lg);
        padding: 50px;
        box-shadow: var(--shadow-lg);
    }

    .form-header {
        margin-bottom: 35px;
        text-align: center;
    }

    .form-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 10px;
        color: var(--dark);
    }

    .form-subtitle {
        color: var(--gray);
        font-size: 1rem;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: var(--dark);
        font-size: 0.95rem;
    }

    .form-label i {
        color: var(--primary);
        margin-right: 5px;
    }

    .form-label .required {
        color: var(--danger);
        margin-left: 3px;
    }

    .form-control {
        width: 100%;
        padding: 14px 18px;
        border: 2px solid var(--gray-light);
        border-radius: var(--border-radius-md);
        font-size: 1rem;
        transition: var(--transition);
        background: var(--white);
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1);
    }

    .form-control.is-invalid {
        border-color: var(--danger);
    }

    .invalid-feedback {
        color: var(--danger);
        font-size: 0.85rem;
        margin-top: 5px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    textarea.form-control {
        resize: vertical;
        min-height: 150px;
    }

    .submit-btn {
        background: var(--gradient-1);
        color: var(--white);
        border: none;
        padding: 16px 40px;
        border-radius: var(--border-radius-full);
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        position: relative;
        overflow: hidden;
    }

    .submit-btn::before {
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
    }

    .submit-btn:hover::before {
        width: 300px;
        height: 300px;
    }

    .submit-btn:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-hover);
    }

    .submit-btn i {
        font-size: 1rem;
        transition: var(--transition);
    }

    .submit-btn:hover i {
        transform: translateX(5px);
    }

    /* Success Message */
    .alert-success {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        color: var(--white);
        padding: 20px 30px;
        border-radius: var(--border-radius-lg);
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 15px;
        animation: slideInDown 0.5s ease-out;
        box-shadow: var(--shadow-lg);
    }

    .alert-success i {
        font-size: 2rem;
    }

    .alert-success-content {
        flex: 1;
    }

    .alert-success-content h4 {
        font-size: 1.2rem;
        margin-bottom: 5px;
        font-weight: 600;
    }

    .alert-success-content p {
        opacity: 0.9;
        font-size: 0.95rem;
    }

    .alert-close {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: var(--white);
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: var(--transition);
    }

    .alert-close:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: scale(1.1);
    }

    /* Map Section */
    .map-section {
        padding: 0 0 80px;
        background: var(--light);
    }

    .map-container {
        max-width: 1200px;
        margin: 0 auto;
        border-radius: var(--border-radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-lg);
        height: 400px;
    }

    .map-container iframe {
        width: 100%;
        height: 100%;
        border: none;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .contact-grid {
            grid-template-columns: 1fr;
            gap: 30px;
            padding: 0 20px;
        }
    }

    @media (max-width: 768px) {
        .contact-hero {
            padding: 60px 0;
        }

        .contact-info-card,
        .hours-card,
        .social-card,
        .contact-form-container {
            padding: 30px;
        }

        .form-row {
            grid-template-columns: 1fr;
            gap: 0;
        }

        .info-title {
            font-size: 1.5rem;
        }

        .form-title {
            font-size: 1.8rem;
        }

        .map-container {
            height: 300px;
            margin: 0 20px;
        }
    }

    /* Animations */
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideInDown {
        from {
            transform: translateY(-100%);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    @keyframes slideInLeft {
        from {
            transform: translateX(-50px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideInRight {
        from {
            transform: translateX(50px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
</style>
@endpush

@section('content')
    <!-- Hero Section -->
    <section class="contact-hero">
        <div class="contact-hero-particles">
            <div class="contact-hero-particle"></div>
            <div class="contact-hero-particle"></div>
            <div class="contact-hero-particle"></div>
        </div>
        
        <div class="container">
            <div class="contact-hero-content">
                <span class="contact-hero-badge">Get in Touch</span>
                <h1 class="contact-hero-title">We're Here to Help</h1>
                <p class="contact-hero-text">
                    Have questions about our courses, partnerships, or anything else? 
                    Our team is ready to assist you.
                </p>
            </div>
        </div>
    </section>
    
    <!-- Contact Section -->
    <section class="contact-section">
        <div class="container">
            <!-- Success Message -->
            @if(session('success'))
                <div class="alert-success" id="successAlert">
                    <i class="fas fa-check-circle"></i>
                    <div class="alert-success-content">
                        <h4>Message Sent Successfully!</h4>
                        <p>{{ session('success') }}</p>
                    </div>
                    <button class="alert-close" onclick="this.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif
            
            <div class="contact-grid">
                <!-- Left Column - Contact Information -->
                <div class="contact-info-wrapper">
                    <!-- Main Contact Card -->
                    <div class="contact-info-card" data-aos="fade-right">
                        <div class="info-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <h2 class="info-title">Let's Connect</h2>
                        <p class="info-description">
                            Whether you have questions about our courses, want to discuss partnership 
                            opportunities, or need technical support, our team is ready to assist you.
                        </p>
                        
                        <ul class="info-list">
                            <li>
                                <i class="fas fa-phone-alt"></i>
                                <a href="tel:+18335338228">+1 (833) 533-8228</a>
                            </li>
                            <li>
                                <i class="far fa-envelope"></i>
                                <a href="mailto:contact@educonecx.com">contact@educonecx.com</a>
                            </li>
                            <li>
                                <i class="fas fa-map-marker-alt"></i>
                                <span>1200 Brickell Ave, Miami, FL 33131, USA</span>
                            </li>
                        </ul>

                        <div class="info-highlights">
                            <h4><i class="fas fa-star"></i> What You Can Ask Us:</h4>
                            <ul>
                                <li><i class="fas fa-check-circle"></i> Course offerings and pricing</li>
                                <li><i class="fas fa-check-circle"></i> Partnership opportunities</li>
                                <li><i class="fas fa-check-circle"></i> Technical support</li>
                                <li><i class="fas fa-check-circle"></i> Billing inquiries</li>
                                <li><i class="fas fa-check-circle"></i> Schedule a consultation</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Business Hours Card -->
                    <div class="hours-card" data-aos="fade-right" data-aos-delay="100">
                        <h3 class="hours-title">
                            <i class="fas fa-clock"></i>
                            Business Hours
                        </h3>
                        <div class="hours-grid">
                            <div class="hours-item">
                                <span class="hours-day">Monday - Friday</span>
                                <span class="hours-time">9:00 AM - 6:00 PM</span>
                            </div>
                            <div class="hours-item">
                                <span class="hours-day">Saturday</span>
                                <span class="hours-time">10:00 AM - 4:00 PM</span>
                            </div>
                            <div class="hours-item">
                                <span class="hours-day">Sunday</span>
                                <span class="hours-time">Closed</span>
                            </div>
                        </div>
                        <div class="hours-note">
                            <i class="fas fa-info-circle"></i>
                            <span>We respond to all inquiries within 24 hours on business days.</span>
                        </div>
                    </div>

                    <!-- Social Media Card -->
                    <div class="social-card" data-aos="fade-right" data-aos-delay="200">
                        <h3 class="social-title">Follow Us</h3>
                        <div class="social-grid">
                            <a href="https://www.facebook.com/profile.php?id=61584601012851" target="_blank" class="social-link">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://www.tiktok.com/@educonecx.officia" target="_blank" class="social-link">
                                <i class="fab fa-tiktok"></i>
                            </a>
                            <a href="https://www.instagram.com/educonecx/" target="_blank" class="social-link">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="https://www.youtube.com/@EDUCONECX" target="_blank" class="social-link">
                                <i class="fab fa-youtube"></i>
                            </a>
                            <a href="https://wa.me/18335338228" target="_blank" class="social-link">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Right Column - Contact Form -->
                <div class="contact-form-container" data-aos="fade-left">
                    <div class="form-header">
                        <h2 class="form-title">Send Us a Message</h2>
                        <p class="form-subtitle">We'll get back to you within 24 hours</p>
                    </div>
                    
                    <form action="{{ route('contact.submit') }}" method="POST" id="contactForm">
                        @csrf
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="first_name" class="form-label">
                                    <i class="fas fa-user"></i> First Name <span class="required">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    class="form-control @error('first_name') is-invalid @enderror" 
                                    id="first_name" 
                                    name="first_name" 
                                    placeholder="John"
                                    value="{{ old('first_name') }}"
                                    required
                                >
                                @error('first_name')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="last_name" class="form-label">
                                    <i class="fas fa-user"></i> Last Name <span class="required">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    class="form-control @error('last_name') is-invalid @enderror" 
                                    id="last_name" 
                                    name="last_name" 
                                    placeholder="Doe"
                                    value="{{ old('last_name') }}"
                                    required
                                >
                                @error('last_name')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope"></i> Email Address <span class="required">*</span>
                            </label>
                            <input 
                                type="email" 
                                class="form-control @error('email') is-invalid @enderror" 
                                id="email" 
                                name="email" 
                                placeholder="john.doe@example.com"
                                value="{{ old('email') }}"
                                required
                            >
                            @error('email')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="phone" class="form-label">
                                <i class="fas fa-phone"></i> Phone Number (Optional)
                            </label>
                            <input 
                                type="tel" 
                                class="form-control @error('phone') is-invalid @enderror" 
                                id="phone" 
                                name="phone" 
                                placeholder="+1 (833) 533-8228"
                                value="{{ old('phone') }}"
                            >
                            @error('phone')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="subject" class="form-label">
                                <i class="fas fa-tag"></i> Subject (Optional)
                            </label>
                            <select class="form-control" id="subject" name="subject">
                                <option value="">Select a subject</option>
                                <option value="course-inquiry">Course Inquiry</option>
                                <option value="partnership">Partnership Opportunity</option>
                                <option value="technical-support">Technical Support</option>
                                <option value="billing">Billing Question</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="message" class="form-label">
                                <i class="fas fa-comment"></i> Message <span class="required">*</span>
                            </label>
                            <textarea 
                                class="form-control @error('message') is-invalid @enderror" 
                                id="message" 
                                name="message" 
                                rows="5" 
                                placeholder="How can we help you?"
                                required
                            >{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <button type="submit" class="submit-btn" id="submitBtn">
                            <span>Send Message</span>
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="map-section">
        <div class="container">
            <div class="map-container" data-aos="fade-up">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3593.210407431367!2d-80.192964684382!3d25.761989583629!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x88d9b682b0b1b1b1%3A0x1b1b1b1b1b1b1b1b!2s1200%20Brickell%20Ave%2C%20Miami%2C%20FL%2033131%2C%20USA!5e0!3m2!1sen!2sus!4v1620000000000!5m2!1sen!2sus" 
                    allowfullscreen="" 
                    loading="lazy"
                    title="EDUCONECX Location"
                ></iframe>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contactForm');
    const submitBtn = document.getElementById('submitBtn');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            // Show loading state
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span>Sending...</span> <i class="fas fa-spinner fa-spin"></i>';
            submitBtn.disabled = true;
            
            // Form will submit normally, but we show loading state
            // The page will reload with success/error messages
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 5000); // Timeout after 5 seconds in case of error
        });
    }
    
    // Auto-hide success message after 5 seconds
    const successAlert = document.getElementById('successAlert');
    if (successAlert) {
        setTimeout(() => {
            successAlert.style.transition = 'opacity 0.5s ease';
            successAlert.style.opacity = '0';
            setTimeout(() => {
                successAlert.remove();
            }, 500);
        }, 5000);
    }
    
    // Phone number formatting (optional)
    const phoneInput = document.getElementById('phone');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 0) {
                if (value.length <= 3) {
                    value = value;
                } else if (value.length <= 6) {
                    value = value.slice(0, 3) + '-' + value.slice(3);
                } else {
                    value = value.slice(0, 3) + '-' + value.slice(3, 6) + '-' + value.slice(6, 10);
                }
                e.target.value = value;
            }
        });
    }
    
    // Form validation enhancement
    const inputs = form.querySelectorAll('.form-control');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.hasAttribute('required') && !this.value) {
                this.classList.add('is-invalid');
            } else if (this.type === 'email' && this.value) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(this.value)) {
                    this.classList.add('is-invalid');
                } else {
                    this.classList.remove('is-invalid');
                }
            } else if (this.value) {
                this.classList.remove('is-invalid');
            }
        });
        
        input.addEventListener('input', function() {
            if (this.classList.contains('is-invalid') && this.value) {
                this.classList.remove('is-invalid');
            }
        });
    });
});
</script>
@endpush