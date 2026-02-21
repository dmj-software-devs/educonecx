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
    }

    .remember-me input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: var(--primary);
    }

    .forgot-password {
        color: var(--primary);
        text-decoration: none;
        font-size: 0.95rem;
        font-weight: 500;
        transition: var(--transition);
    }

    .forgot-password:hover {
        color: var(--primary-dark);
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

    /* Demo Credentials */
    .demo-credentials {
        background: var(--light);
        border-radius: var(--border-radius-md);
        padding: 20px;
        margin-top: 25px;
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
    }

    .demo-item {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 8px;
        color: var(--gray);
        font-size: 0.9rem;
    }

    .demo-item strong {
        color: var(--dark);
        min-width: 60px;
    }

    .demo-item span {
        font-family: monospace;
        background: var(--white);
        padding: 4px 8px;
        border-radius: var(--border-radius-sm);
    }

    .demo-note {
        font-size: 0.85rem;
        color: var(--gray);
        margin-top: 10px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .demo-note i {
        color: var(--primary);
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
                    <a href="#" class="social-btn google">
                        <i class="fab fa-google"></i>
                        Continue with Google
                    </a>
                    <a href="#" class="social-btn facebook">
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
                <form method="POST" action="{{ route('login') }}" class="auth-form">
                    @csrf

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope"></i> Email Address
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
                                autofocus
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
                            <i class="fas fa-lock"></i> Password
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
                    </div>

                    <!-- Form Options -->
                    <div class="form-options">
                        <label class="remember-me">
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span>Remember me</span>
                        </label>
                        <a href="#" class="forgot-password">
                            Forgot password?
                        </a>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-submit">
                        <span>Log In</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </form>

                <!-- Demo Credentials (remove in production) -->
                <div class="demo-credentials">
                    <h4>
                        <i class="fas fa-info-circle"></i>
                        Demo Credentials
                    </h4>
                    <div class="demo-item">
                        <strong>Admin:</strong>
                        <span>admin@educonecx.com</span>
                        <span>password</span>
                    </div>
                    <div class="demo-item">
                        <strong>User:</strong>
                        <span>user@educonecx.com</span>
                        <span>password</span>
                    </div>
                    <div class="demo-note">
                        <i class="fas fa-lightbulb"></i>
                        These are demo credentials. In production, use your own account.
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

    @push('scripts')
    <script>
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
    </script>
    @endpush
@endsection