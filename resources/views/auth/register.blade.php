@extends('layouts.main')

@section('title', 'Register - EDUCONECX | Create Your Account')

@section('meta_description', 'Create your EDUCONECX account to start learning with our AI-powered platform. Access courses, track progress, and join our global learning community.')

@push('styles')
<style>
    /* Auth Hero Section (reusing styles from login) */
    .auth-hero {
        position: relative;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 60px 0;
        overflow: hidden;
        color: var(--white);
    }

    .auth-hero-particles {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    .auth-hero-particle {
        position: absolute;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .auth-hero-particle:nth-child(1) {
        width: 300px;
        height: 300px;
        top: -100px;
        right: -100px;
        animation: float 8s ease-in-out infinite;
    }

    .auth-hero-particle:nth-child(2) {
        width: 200px;
        height: 200px;
        bottom: -50px;
        left: -50px;
        animation: float 10s ease-in-out infinite reverse;
    }

    .auth-hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
        max-width: 800px;
        margin: 0 auto;
    }

    .auth-hero-badge {
        display: inline-block;
        padding: 8px 20px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: var(--border-radius-full);
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 20px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .auth-hero-title {
        font-size: clamp(2rem, 5vw, 2.5rem);
        font-weight: 800;
        margin-bottom: 15px;
        line-height: 1.2;
    }

    .auth-hero-text {
        font-size: 1.1rem;
        opacity: 0.9;
        max-width: 600px;
        margin: 0 auto;
    }

    /* Auth Section */
    .auth-section {
        padding: 60px 0;
        background: var(--light);
        min-height: calc(100vh - 400px);
    }

    .auth-container {
        max-width: 600px;
        margin: 0 auto;
        background: var(--white);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-lg);
        padding: 40px;
        position: relative;
        overflow: hidden;
    }

    .auth-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        background: var(--gradient-1);
    }

    .auth-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .auth-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 10px;
    }

    .auth-subtitle {
        color: var(--gray);
        font-size: 0.95rem;
    }

    .auth-subtitle a {
        color: var(--primary);
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
    }

    .auth-subtitle a:hover {
        color: var(--primary-dark);
        text-decoration: underline;
    }

    /* Social Login */
    .social-login {
        display: flex;
        flex-direction: column;
        gap: 15px;
        margin-bottom: 25px;
    }

    .social-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        padding: 14px;
        border-radius: var(--border-radius-md);
        font-weight: 600;
        font-size: 1rem;
        text-decoration: none;
        transition: var(--transition);
        border: 2px solid transparent;
    }

    .social-btn.google {
        background: #DB4437;
        color: var(--white);
    }

    .social-btn.google:hover {
        background: #c5382b;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .social-btn.facebook {
        background: #4267B2;
        color: var(--white);
    }

    .social-btn.facebook:hover {
        background: #3a5a9e;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .social-btn i {
        font-size: 1.2rem;
    }

    .divider {
        display: flex;
        align-items: center;
        gap: 15px;
        margin: 25px 0;
        color: var(--gray);
        font-size: 0.9rem;
    }

    .divider-line {
        flex: 1;
        height: 1px;
        background: var(--gray-light);
    }

    /* Auth Form */
    .auth-form {
        margin-bottom: 25px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-bottom: 15px;
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
        margin-right: 8px;
    }

    .form-label .required {
        color: var(--danger);
        margin-left: 3px;
    }

    .input-group {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-icon {
        position: absolute;
        left: 15px;
        color: var(--gray);
        font-size: 1rem;
        z-index: 2;
    }

    .form-control {
        width: 100%;
        padding: 14px 15px 14px 45px;
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

    .toggle-password {
        position: absolute;
        right: 15px;
        background: none;
        border: none;
        color: var(--gray);
        cursor: pointer;
        font-size: 1rem;
        transition: var(--transition);
    }

    .toggle-password:hover {
        color: var(--primary);
    }

    /* Password Strength */
    .password-strength {
        margin-top: 8px;
    }

    .strength-meter {
        display: flex;
        gap: 5px;
        margin-bottom: 5px;
    }

    .strength-segment {
        height: 4px;
        flex: 1;
        background: var(--gray-light);
        border-radius: 2px;
        transition: var(--transition);
    }

    .strength-segment.active {
        background: var(--success);
    }

    .strength-segment.active.weak {
        background: var(--danger);
    }

    .strength-segment.active.medium {
        background: var(--warning);
    }

    .strength-segment.active.strong {
        background: var(--success);
    }

    .strength-text {
        font-size: 0.8rem;
        color: var(--gray);
    }

    .password-hint {
        font-size: 0.8rem;
        color: var(--gray);
        margin-top: 5px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .password-hint i {
        color: var(--primary);
        font-size: 0.8rem;
    }

    /* Terms Checkbox */
    .terms-checkbox {
        margin-bottom: 25px;
    }

    .terms-label {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        cursor: pointer;
        color: var(--gray);
        font-size: 0.95rem;
    }

    .terms-label input[type="checkbox"] {
        width: 18px;
        height: 18px;
        margin-top: 2px;
        cursor: pointer;
        accent-color: var(--primary);
    }

    .terms-label a {
        color: var(--primary);
        text-decoration: none;
        font-weight: 500;
    }

    .terms-label a:hover {
        text-decoration: underline;
    }

    /* Submit Button */
    .btn-submit {
        width: 100%;
        padding: 16px;
        background: var(--gradient-1);
        color: var(--white);
        border: none;
        border-radius: var(--border-radius-md);
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        position: relative;
        overflow: hidden;
    }

    .btn-submit::before {
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

    .btn-submit:hover::before {
        width: 300px;
        height: 300px;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .btn-submit i {
        font-size: 1rem;
        transition: var(--transition);
    }

    .btn-submit:hover i {
        transform: translateX(5px);
    }

    /* Benefits List */
    .benefits-list {
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid var(--gray-light);
    }

    .benefits-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .benefits-title i {
        color: var(--primary);
    }

    .benefits-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }

    .benefit-item {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--gray);
        font-size: 0.9rem;
    }

    .benefit-item i {
        color: var(--success);
        font-size: 0.9rem;
    }

    /* Alert Messages */
    .alert {
        padding: 15px 20px;
        border-radius: var(--border-radius-md);
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 12px;
        animation: slideInDown 0.5s ease-out;
    }

    .alert-danger {
        background: #fef2f2;
        color: var(--danger);
        border: 1px solid #fee2e2;
    }

    .alert-success {
        background: #f0fdf4;
        color: var(--success);
        border: 1px solid #dcfce7;
    }

    .alert i {
        font-size: 1.2rem;
    }

    .alert-content {
        flex: 1;
    }

    .alert-content h4 {
        font-weight: 600;
        margin-bottom: 3px;
    }

    .alert-content p {
        font-size: 0.95rem;
        opacity: 0.9;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .auth-hero {
            padding: 40px 0;
        }

        .auth-container {
            padding: 30px 20px;
            margin: 0 15px;
        }

        .auth-title {
            font-size: 1.8rem;
        }

        .form-row {
            grid-template-columns: 1fr;
            gap: 0;
        }

        .benefits-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
    <!-- Auth Hero Section -->
    <section class="auth-hero">
        <div class="auth-hero-particles">
            <div class="auth-hero-particle"></div>
            <div class="auth-hero-particle"></div>
        </div>
        
        <div class="container">
            <div class="auth-hero-content">
                <span class="auth-hero-badge">Start Your Journey</span>
                <h1 class="auth-hero-title">Create Your Account</h1>
                <p class="auth-hero-text">Join thousands of learners worldwide and transform your skills with AI-powered education</p>
            </div>
        </div>
    </section>

    <!-- Auth Section -->
    <section class="auth-section">
        <div class="container">
            <div class="auth-container" data-aos="fade-up">
                <div class="auth-header">
                    <h2 class="auth-title">Sign Up</h2>
                    <p class="auth-subtitle">
                        Already have an account? <a href="{{ route('login') }}">Log in here</a>
                    </p>
                </div>

                <!-- Alert Messages -->
                @if($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        <div class="alert-content">
                            <h4>Registration Failed</h4>
                            <p>Please check the form below for errors.</p>
                        </div>
                    </div>
                @endif

                <!-- Social Registration -->
                <div class="social-login">
                    <a href="#" class="social-btn google">
                        <i class="fab fa-google"></i>
                        Sign up with Google
                    </a>
                    <a href="#" class="social-btn facebook">
                        <i class="fab fa-facebook-f"></i>
                        Sign up with Facebook
                    </a>
                </div>

                <div class="divider">
                    <span class="divider-line"></span>
                    <span>or sign up with email</span>
                    <span class="divider-line"></span>
                </div>

                <!-- Registration Form -->
                <form method="POST" action="{{ route('register') }}" class="auth-form">
                    @csrf

                    <!-- Name Fields -->
                    <div class="form-row">
                        <div class="form-group">
                            <label for="first_name" class="form-label">
                                <i class="fas fa-user"></i> First Name <span class="required">*</span>
                            </label>
                            <div class="input-group">
                                <i class="fas fa-user input-icon"></i>
                                <input 
                                    type="text" 
                                    class="form-control @error('first_name') is-invalid @enderror" 
                                    id="first_name" 
                                    name="first_name" 
                                    value="{{ old('first_name') }}" 
                                    placeholder="John"
                                    required
                                >
                            </div>
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
                            <div class="input-group">
                                <i class="fas fa-user input-icon"></i>
                                <input 
                                    type="text" 
                                    class="form-control @error('last_name') is-invalid @enderror" 
                                    id="last_name" 
                                    name="last_name" 
                                    value="{{ old('last_name') }}" 
                                    placeholder="Doe"
                                    required
                                >
                            </div>
                            @error('last_name')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope"></i> Email Address <span class="required">*</span>
                        </label>
                        <div class="input-group">
                            <i class="fas fa-envelope input-icon"></i>
                            <input 
                                type="email" 
                                class="form-control @error('email') is-invalid @enderror" 
                                id="email" 
                                name="email" 
                                value="{{ old('email') }}" 
                                placeholder="your@email.com"
                                required
                            >
                        </div>
                        @error('email')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock"></i> Password <span class="required">*</span>
                        </label>
                        <div class="input-group">
                            <i class="fas fa-lock input-icon"></i>
                            <input 
                                type="password" 
                                class="form-control @error('password') is-invalid @enderror" 
                                id="password" 
                                name="password" 
                                placeholder="••••••••"
                                required
                            >
                            <button type="button" class="toggle-password" onclick="togglePassword('password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                        
                        <!-- Password Strength Meter -->
                        <div class="password-strength" id="passwordStrength">
                            <div class="strength-meter">
                                <div class="strength-segment" id="strength1"></div>
                                <div class="strength-segment" id="strength2"></div>
                                <div class="strength-segment" id="strength3"></div>
                                <div class="strength-segment" id="strength4"></div>
                            </div>
                            <span class="strength-text" id="strengthText">Enter a password</span>
                            <div class="password-hint">
                                <i class="fas fa-info-circle"></i>
                                Min. 8 characters with letters & numbers
                            </div>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">
                            <i class="fas fa-lock"></i> Confirm Password <span class="required">*</span>
                        </label>
                        <div class="input-group">
                            <i class="fas fa-lock input-icon"></i>
                            <input 
                                type="password" 
                                class="form-control" 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                placeholder="••••••••"
                                required
                            >
                            <button type="button" class="toggle-password" onclick="togglePassword('password_confirmation')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Terms Checkbox -->
                    <div class="terms-checkbox">
                        <label class="terms-label">
                            <input type="checkbox" name="terms" required>
                            <span>
                                I agree to the <a href="{{ route('terms') }}" target="_blank">Terms of Service</a> 
                                and <a href="{{ route('privacy') }}" target="_blank">Privacy Policy</a>
                            </span>
                        </label>
                        @error('terms')
                            <div class="invalid-feedback" style="display: block;">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-submit">
                        <span>Create Account</span>
                        <i class="fas fa-user-plus"></i>
                    </button>
                </form>

                <!-- Benefits -->
                <div class="benefits-list">
                    <h4 class="benefits-title">
                        <i class="fas fa-star"></i>
                        What you get when you join:
                    </h4>
                    <div class="benefits-grid">
                        <div class="benefit-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Access to free courses</span>
                        </div>
                        <div class="benefit-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Track your progress</span>
                        </div>
                        <div class="benefit-item">
                            <i class="fas fa-check-circle"></i>
                            <span>AI-powered learning</span>
                        </div>
                        <div class="benefit-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Earn certificates</span>
                        </div>
                        <div class="benefit-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Join community</span>
                        </div>
                        <div class="benefit-item">
                            <i class="fas fa-check-circle"></i>
                            <span>24/7 support</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
    <script>
        // Toggle password visibility
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = event.currentTarget.querySelector('i');
            
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Password strength checker
        const passwordInput = document.getElementById('password');
        const strengthSegments = [
            document.getElementById('strength1'),
            document.getElementById('strength2'),
            document.getElementById('strength3'),
            document.getElementById('strength4')
        ];
        const strengthText = document.getElementById('strengthText');

        passwordInput.addEventListener('input', function() {
            const password = this.value;
            const strength = checkPasswordStrength(password);
            
            // Reset all segments
            strengthSegments.forEach(segment => {
                segment.classList.remove('active', 'weak', 'medium', 'strong');
            });
            
            // Update segments based on strength
            for (let i = 0; i < strength.score; i++) {
                strengthSegments[i].classList.add('active');
                if (strength.score <= 2) {
                    strengthSegments[i].classList.add('weak');
                } else if (strength.score === 3) {
                    strengthSegments[i].classList.add('medium');
                } else if (strength.score === 4) {
                    strengthSegments[i].classList.add('strong');
                }
            }
            
            strengthText.textContent = strength.message;
        });

        function checkPasswordStrength(password) {
            if (!password) {
                return { score: 0, message: 'Enter a password' };
            }
            
            let score = 0;
            
            // Length check
            if (password.length >= 8) score++;
            if (password.length >= 12) score++;
            
            // Contains number
            if (/\d/.test(password)) score++;
            
            // Contains special character
            if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) score++;
            
            // Contains uppercase and lowercase
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) score++;
            
            // Cap at 4
            score = Math.min(score, 4);
            
            const messages = [
                'Very weak',
                'Weak',
                'Fair',
                'Good',
                'Strong'
            ];
            
            return { score, message: messages[score] };
        }
    </script>
    @endpush
@endsection