@extends('layouts.main')

@section('title', 'Login - EDUCONECX | Access Your Account')

@section('meta_description', 'Log in to your EDUCONECX account to access your courses, track your progress, and continue your learning journey.')

@push('styles')
<style>
    /* Auth Hero Section */
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
        animation: fadeInDown 1s ease-out;
    }

    .auth-hero-title {
        font-size: clamp(2rem, 5vw, 2.5rem);
        font-weight: 800;
        margin-bottom: 15px;
        line-height: 1.2;
        animation: fadeInUp 1s ease-out 0.2s both;
    }

    .auth-hero-text {
        font-size: 1.1rem;
        opacity: 0.9;
        max-width: 600px;
        margin: 0 auto;
        animation: fadeInUp 1s ease-out 0.4s both;
    }

    /* Auth Section */
    .auth-section {
        padding: 60px 0;
        background: var(--light);
        min-height: calc(100vh - 400px);
    }

    .auth-container {
        max-width: 500px;
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
        position: relative;
    }

    .auth-subtitle a::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 0;
        height: 2px;
        background: var(--gradient-1);
        transition: var(--transition);
    }

    .auth-subtitle a:hover::after {
        width: 100%;
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
        position: relative;
        overflow: hidden;
    }

    .social-btn::before {
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

    .social-btn:hover::before {
        width: 300px;
        height: 300px;
    }

    .social-btn.google {
        background: #DB4437;
        color: var(--white);
    }

    .social-btn.google:hover {
        background: #c5382b;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(219, 68, 55, 0.3);
    }

    .social-btn.facebook {
        background: #4267B2;
        color: var(--white);
    }

    .social-btn.facebook:hover {
        background: #3a5a9e;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(66, 103, 178, 0.3);
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
        transition: var(--transition);
    }

    .form-control:focus+.input-icon {
        color: var(--primary);
    }

    .form-control {
        width: 100%;
        padding: 14px 45px 14px 45px;
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

    .form-control.is-invalid:focus {
        box-shadow: 0 0 0 4px rgba(239, 71, 111, 0.1);
    }

    .invalid-feedback {
        color: var(--danger);
        font-size: 0.85rem;
        margin-top: 5px;
        display: flex;
        align-items: center;
        gap: 5px;
        animation: shake 0.5s ease-in-out;
    }

    @keyframes shake {

        0%,
        100% {
            transform: translateX(0);
        }

        25% {
            transform: translateX(-5px);
        }

        75% {
            transform: translateX(5px);
        }
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
        z-index: 2;
    }

    .toggle-password:hover {
        color: var(--primary);
        transform: scale(1.1);
    }

    /* Form Options */
    .form-options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .remember-me {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        color: var(--gray);
        font-size: 0.95rem;
        transition: var(--transition);
    }

    .remember-me:hover {
        color: var(--dark);
    }

    .remember-me input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: var(--primary);
        transition: var(--transition);
    }

    .remember-me input[type="checkbox"]:hover {
        transform: scale(1.1);
    }

    .forgot-password {
        color: var(--primary);
        text-decoration: none;
        font-size: 0.95rem;
        font-weight: 500;
        transition: var(--transition);
        position: relative;
    }

    .forgot-password::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 0;
        height: 2px;
        background: var(--gradient-1);
        transition: var(--transition);
    }

    .forgot-password:hover::after {
        width: 100%;
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

    .btn-submit:active {
        transform: translateY(0);
    }

    .btn-submit i {
        font-size: 1rem;
        transition: var(--transition);
    }

    .btn-submit:hover i {
        transform: translateX(5px);
    }

    /* Demo Credentials */
    .demo-credentials {
        background: var(--light);
        border-radius: var(--border-radius-md);
        padding: 20px;
        margin-top: 25px;
        border: 1px solid var(--gray-light);
        transition: var(--transition);
    }

    .demo-credentials:hover {
        box-shadow: var(--shadow-md);
    }

    .demo-credentials h4 {
        font-size: 1rem;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .demo-credentials h4 i {
        color: var(--primary);
        animation: pulse 2s infinite;
    }

    .demo-item {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 8px;
        color: var(--gray);
        font-size: 0.9rem;
        padding: 5px;
        border-radius: var(--border-radius-sm);
        transition: var(--transition);
    }

    .demo-item:hover {
        background: var(--white);
        transform: translateX(5px);
    }

    .demo-item strong {
        color: var(--dark);
        min-width: 60px;
    }

    .demo-item span {
        font-family: 'Monaco', 'Menlo', monospace;
        background: var(--white);
        padding: 4px 8px;
        border-radius: var(--border-radius-sm);
        border: 1px solid var(--gray-light);
        font-size: 0.85rem;
    }

    .demo-note {
        font-size: 0.85rem;
        color: var(--gray);
        margin-top: 10px;
        display: flex;
        align-items: center;
        gap: 5px;
        padding-top: 10px;
        border-top: 1px dashed var(--gray-light);
    }

    .demo-note i {
        color: var(--primary);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.1);
        }
    }

    /* Trust Badges */
    .trust-badges {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid var(--gray-light);
    }

    .trust-badge {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--gray);
        font-size: 0.85rem;
        transition: var(--transition);
    }

    .trust-badge:hover {
        color: var(--primary);
        transform: translateY(-2px);
    }

    .trust-badge i {
        color: var(--primary);
        font-size: 1rem;
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

    @keyframes slideInDown {
        from {
            transform: translateY(-20px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
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

    /* Loading State */
    .btn-submit.loading {
        pointer-events: none;
        opacity: 0.8;
    }

    .btn-submit.loading i {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
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

        .form-options {
            flex-direction: column;
            align-items: flex-start;
        }

        .trust-badges {
            flex-direction: column;
            align-items: center;
            gap: 10px;
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

    @keyframes float {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-20px);
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
        <div class="auth-hero-particle"></div>
    </div>

    <div class="container">
        <div class="auth-hero-content">
            <span class="auth-hero-badge">Welcome Back</span>
            <h1 class="auth-hero-title">Log in to Your Account</h1>
            <p class="auth-hero-text">Access your courses, track your progress, and continue your learning journey</p>
        </div>
    </div>
</section>

<!-- Auth Section -->
<section class="auth-section">
    <div class="container">
        <div class="auth-container" data-aos="fade-up">
            <div class="auth-header">
                <h2 class="auth-title">Login</h2>
                <p class="auth-subtitle">
                    Don't have an account? <a href="{{ route('register') }}">Sign up here</a>
                </p>
            </div>

            <!-- Alert Messages -->
            @if(session('status'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <div class="alert-content">
                    <p>{{ session('status') }}</p>
                </div>
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <div class="alert-content">
                    <h4>Login Failed</h4>
                    <p>{{ $errors->first() }}</p>
                </div>
            </div>
            @endif

            <!-- Social Login -->
            <div class="social-login">
                <a href="#" class="social-btn google" onclick="showNotification('Google Login coming soon!', 'info')">
                    <i class="fab fa-google"></i>
                    Continue with Google
                </a>
                <a href="#" class="social-btn facebook" onclick="showNotification('Facebook Login coming soon!', 'info')">
                    <i class="fab fa-facebook-f"></i>
                    Continue with Facebook
                </a>
            </div>

            <div class="divider">
                <span class="divider-line"></span>
                <span>or login with email</span>
                <span class="divider-line"></span>
            </div>

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="auth-form" id="loginForm">
                @csrf

                <!-- Email -->
                <div class="form-group">
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope"></i> Email Address
                    </label>
                    <div class="input-group">
                        <input
                            type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="your@email.com"
                            required
                            autofocus>
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
                        <i class="fas fa-lock"></i> Password
                    </label>
                    <div class="input-group">
                        <input
                            type="password"
                            class="form-control @error('password') is-invalid @enderror"
                            id="password"
                            name="password"
                            placeholder="••••••••"
                            required>
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
                </div>

                <!-- Form Options -->
                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span>Remember me</span>
                    </label>
                    <a href="#" class="forgot-password" onclick="showNotification('Password reset coming soon!', 'info')">
                        Forgot password?
                    </a>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-submit" id="submitBtn">
                    <span>Log In</span>
                    <i class="fas fa-arrow-right"></i>
                </button>
            </form>

            <!-- Demo Credentials -->
            <div class="demo-credentials">
                <h4>
                    <i class="fas fa-info-circle"></i>
                    Demo Credentials
                </h4>
                <div class="demo-item" onclick="fillDemoCredentials('admin@educonecx.com', 'password')">
                    <strong>Admin:</strong>
                    <span>admin@educonecx.com</span>
                    <span>password</span>
                    <i class="fas fa-copy" style="margin-left: auto; cursor: pointer;" onclick="copyCredentials(event, 'admin@educonecx.com', 'password')"></i>
                </div>
                <div class="demo-item" onclick="fillDemoCredentials('user@educonecx.com', 'password')">
                    <strong>User:</strong>
                    <span>user@educonecx.com</span>
                    <span>password</span>
                    <i class="fas fa-copy" style="margin-left: auto; cursor: pointer;" onclick="copyCredentials(event, 'user@educonecx.com', 'password')"></i>
                </div>
                <div class="demo-note">
                    <i class="fas fa-lightbulb"></i>
                    Click on any demo account to auto-fill credentials
                </div>
            </div>

            <!-- Trust Badges -->
            <div class="trust-badges">
                <div class="trust-badge">
                    <i class="fas fa-shield-alt"></i>
                    <span>Secure Login</span>
                </div>
                <div class="trust-badge">
                    <i class="fas fa-lock"></i>
                    <span>Encrypted Data</span>
                </div>
                <div class="trust-badge">
                    <i class="fas fa-headset"></i>
                    <span>24/7 Support</span>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

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

    // Fill demo credentials
    function fillDemoCredentials(email, password) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = password;

        // Highlight the filled fields
        document.getElementById('email').style.backgroundColor = '#e8f5e9';
        document.getElementById('password').style.backgroundColor = '#e8f5e9';

        setTimeout(() => {
            document.getElementById('email').style.backgroundColor = '';
            document.getElementById('password').style.backgroundColor = '';
        }, 500);

        showNotification('Credentials filled! Click Login to continue', 'success');
    }

    // Copy credentials
    function copyCredentials(event, email, password) {
        event.stopPropagation();
        const text = `Email: ${email}\nPassword: ${password}`;
        navigator.clipboard.writeText(text).then(() => {
            showNotification('Credentials copied to clipboard!', 'success');
        }).catch(() => {
            showNotification('Failed to copy credentials', 'error');
        });
    }

    // Show notification
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.style.cssText = `
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: ${type === 'success' ? 'var(--success)' : type === 'error' ? 'var(--danger)' : 'var(--primary)'};
            color: white;
            padding: 12px 24px;
            border-radius: var(--border-radius-full);
            box-shadow: var(--shadow-lg);
            z-index: 9999;
            animation: slideInRight 0.3s ease;
        `;
        notification.textContent = message;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.animation = 'slideOutRight 0.3s ease';
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 3000);
    }

    // Form submission loading state
    document.getElementById('loginForm')?.addEventListener('submit', function(e) {
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.classList.add('loading');
        submitBtn.innerHTML = '<i class="fas fa-spinner"></i> Logging in...';
    });

    // Add animation styles
    const style = document.createElement('style');
    style.textContent = `
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
        
        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);

    // Add floating animation to particles
    document.querySelectorAll('.auth-hero-particle').forEach((particle, index) => {
        particle.style.animation = `float ${6 + index * 2}s ease-in-out infinite`;
    });

    // Input validation on blur
    document.querySelectorAll('.form-control').forEach(input => {
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
</script>
@endpush