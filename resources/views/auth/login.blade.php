@extends('layouts.main')

@section('title', 'Login - EDUCONECX')

@section('meta_description', 'Log in to your EDUCONECX account and continue your learning journey.')

@section('content')
<style>
    /* Login Page Specific Styles - Scoped to prevent conflicts */
    .login-page-section {
        min-height: 100vh;
        display: flex;
        align-items: center;
        background: #ffffff;
        padding: 20px;
        font-family: 'Inter', sans-serif;
    }

    .login-page-container {
        max-width: 440px;
        width: 100%;
        margin: 0 auto;
        background: #ffffff;
        border-radius: 24px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
        padding: 48px 40px;
        border: 1px solid #f0f0f0;
    }

    /* Header */
    .login-page-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .login-page-header h1 {
        font-size: 32px !important;
        font-weight: 700 !important;
        color: #1f2937 !important;
        margin: 0 0 8px 0 !important;
        padding: 0 !important;
        line-height: 1.2 !important;
        background: none !important;
        -webkit-text-fill-color: #1f2937 !important;
    }

    .login-page-header p {
        color: #6b7280 !important;
        font-size: 15px !important;
        margin: 0 !important;
    }

    .login-page-header a {
        color: #2563eb !important;
        font-weight: 500 !important;
        text-decoration: none !important;
        background: none !important;
        padding: 0 !important;
    }

    .login-page-header a:hover {
        text-decoration: underline !important;
    }

    /* Alert Messages */
    .login-page-alert {
        padding: 14px 16px;
        border-radius: 12px;
        margin-bottom: 24px;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .login-page-alert-error {
        background: #fef2f2;
        border: 1px solid #fee2e2;
        color: #dc2626;
    }

    .login-page-alert-success {
        background: #f0fdf4;
        border: 1px solid #dcfce7;
        color: #16a34a;
    }

    /* Form Groups - Fixed Alignment */
    .login-page-form-group {
        margin-bottom: 24px;
        width: 100%;
    }

    .login-page-form-group label {
        display: block !important;
        margin: 0 0 8px 0 !important;
        padding: 0 !important;
        font-size: 14px !important;
        font-weight: 500 !important;
        color: #1f2937 !important;
        text-align: left !important;
        line-height: 1.5 !important;
        float: none !important;
        width: auto !important;
        background: none !important;
        border: none !important;
    }

    .login-page-form-group label span {
        color: #dc2626;
        margin-left: 2px;
    }

    .login-page-input-wrapper {
        position: relative;
        width: 100%;
    }

    .login-page-input-wrapper input {
        width: 100% !important;
        height: 48px !important;
        padding: 0 16px !important;
        border: 2px solid #e5e7eb !important;
        border-radius: 12px !important;
        font-size: 15px !important;
        color: #1f2937 !important;
        background: #ffffff !important;
        transition: all 0.2s ease !important;
        margin: 0 !important;
        box-shadow: none !important;
        line-height: normal !important;
    }

    .login-page-input-wrapper input:hover {
        border-color: #9ca3af !important;
    }

    .login-page-input-wrapper input:focus {
        outline: none !important;
        border-color: #2563eb !important;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1) !important;
    }

    .login-page-input-wrapper input.is-invalid {
        border-color: #dc2626 !important;
    }

    .login-page-error-message {
        color: #dc2626 !important;
        font-size: 13px !important;
        margin-top: 6px !important;
        display: block !important;
    }

    /* Password Toggle - Professional Version */
    .login-page-password-toggle {
        position: absolute !important;
        right: 14px !important;
        top: 50% !important;
        transform: translateY(-50%) !important;
        background: none !important;
        border: none !important;
        color: #9ca3af !important;
        cursor: pointer !important;
        padding: 8px !important;
        width: auto !important;
        height: auto !important;
        line-height: 1 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        border-radius: 8px !important;
        transition: all 0.2s ease !important;
    }

    .login-page-password-toggle:hover {
        color: #2563eb !important;
        background: rgba(37, 99, 235, 0.05) !important;
    }

    .login-page-password-toggle:focus-visible {
        outline: 2px solid #2563eb !important;
        outline-offset: 2px !important;
    }

    .login-page-password-toggle .eye-icon {
        width: 20px;
        height: 20px;
        display: block;
        transition: all 0.2s ease;
    }

    /* Form Options */
    .login-page-form-options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 20px 0 32px;
    }

    .login-page-remember-me {
        display: flex !important;
        align-items: center !important;
        gap: 8px !important;
        cursor: pointer !important;
        font-size: 14px !important;
        color: #1f2937 !important;
        margin: 0 !important;
    }

    .login-page-remember-me input[type="checkbox"] {
        width: 16px !important;
        height: 16px !important;
        cursor: pointer !important;
        accent-color: #2563eb !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .login-page-forgot-link {
        color: #2563eb !important;
        font-size: 14px !important;
        font-weight: 500 !important;
        text-decoration: none !important;
        background: none !important;
        padding: 0 !important;
    }

    .login-page-forgot-link:hover {
        text-decoration: underline !important;
    }

    /* Submit Button */
    .login-page-btn-submit {
        width: 100% !important;
        height: 48px !important;
        background: #2563eb !important;
        border: none !important;
        border-radius: 12px !important;
        color: #ffffff !important;
        font-size: 16px !important;
        font-weight: 600 !important;
        cursor: pointer !important;
        transition: all 0.2s ease !important;
        padding: 0 !important;
        margin: 0 !important;
        line-height: 48px !important;
        text-align: center !important;
    }

    .login-page-btn-submit:hover:not(:disabled) {
        background: #1d4ed8 !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.2) !important;
    }

    .login-page-btn-submit:active:not(:disabled) {
        transform: translateY(0) !important;
    }

    .login-page-btn-submit:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    /* Loading Spinner */
    .login-page-spinner {
        display: inline-block;
        width: 16px;
        height: 16px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        border-top-color: #ffffff;
        animation: login-page-spin 0.8s linear infinite;
        margin-right: 8px;
    }

    @keyframes login-page-spin {
        to {
            transform: rotate(360deg);
        }
    }

    /* Divider */
    .login-page-divider {
        position: relative;
        margin: 32px 0;
        text-align: center;
    }

    .login-page-divider::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background: #e5e7eb;
        z-index: 1;
    }

    .login-page-divider span {
        position: relative;
        z-index: 2;
        background: #ffffff;
        padding: 0 16px;
        color: #6b7280;
        font-size: 14px;
        font-weight: 500;
    }

    /* Google Button */
    .login-page-google-btn {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 12px !important;
        width: 100% !important;
        height: 48px !important;
        padding: 0 20px !important;
        background: #ffffff !important;
        border: 2px solid #e5e7eb !important;
        border-radius: 12px !important;
        color: #1f2937 !important;
        font-size: 15px !important;
        font-weight: 500 !important;
        text-decoration: none !important;
        transition: all 0.2s ease !important;
        margin: 0 !important;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05) !important;
    }

    .login-page-google-btn:hover {
        background: #f9fafb !important;
        border-color: #2563eb !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.15) !important;
    }

    .login-page-google-btn:active {
        transform: translateY(0) !important;
    }

    .login-page-google-btn.loading {
        opacity: 0.7;
        cursor: wait;
        pointer-events: none;
    }

    .login-page-google-icon {
        width: 20px;
        height: 20px;
    }

    /* Google Loading State */
    .login-page-google-loading {
        display: none;
        align-items: center !important;
        justify-content: center !important;
        gap: 12px !important;
        width: 100% !important;
        height: 48px !important;
        padding: 0 20px !important;
        background: #f9fafb !important;
        border: 2px solid #2563eb !important;
        border-radius: 12px !important;
        color: #2563eb !important;
        font-size: 15px !important;
        font-weight: 500 !important;
        margin: 0 !important;
    }

    .login-page-google-loading .spinner {
        width: 20px;
        height: 20px;
        border: 2px solid rgba(37, 99, 235, 0.2);
        border-radius: 50%;
        border-top-color: #2563eb;
        animation: login-page-spin 0.8s linear infinite;
    }

    /* Notification */
    .login-page-notification {
        position: fixed;
        bottom: 24px;
        right: 24px;
        padding: 14px 20px;
        border-radius: 12px;
        color: #ffffff;
        font-size: 14px;
        font-weight: 500;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        z-index: 9999;
        animation: login-page-slideIn 0.3s ease;
    }

    @keyframes login-page-slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    /* Responsive */
    @media (max-width: 480px) {
        .login-page-container {
            padding: 32px 24px;
        }

        .login-page-header h1 {
            font-size: 28px !important;
        }

        .login-page-form-options {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }
    }
</style>

<section class="login-page-section">
    <div class="login-page-container">
        <div class="login-page-header">
            <h1>Welcome back</h1>
            <p>Don't have an account? <a href="{{ route('register') }}">Sign up</a></p>
        </div>

        <!-- Success Message for Registration -->
        @if(session('success'))
        <div class="login-page-alert login-page-alert-success">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20 6L9 17l-5-5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            {{ session('success') }}
        </div>
        @endif

        @if(session('status'))
        <div class="login-page-alert login-page-alert-success">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20 6L9 17l-5-5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            {{ session('status') }}
        </div>
        @endif

        <!-- Google Session Messages -->
        @if(session('google_success'))
        <div class="login-page-alert login-page-alert-success">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20 6L9 17l-5-5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            {{ session('google_success') }}
        </div>
        @endif

        @if(session('google_error'))
        <div class="login-page-alert login-page-alert-error">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10" />
                <line x1="12" y1="8" x2="12" y2="12" />
                <line x1="12" y1="16" x2="12.01" y2="16" />
            </svg>
            {{ session('google_error') }}
        </div>
        @endif

        <!-- Error Messages -->
        @if($errors->any())
        <div class="login-page-alert login-page-alert-error">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10" />
                <line x1="12" y1="8" x2="12" y2="12" />
                <line x1="12" y1="16" x2="12.01" y2="16" />
            </svg>

            @if($errors->first() == 'Please verify your email address before logging in.' && session('unverified_email'))
            {{ $errors->first() }}
            <a href="{{ route('verification.resend') }}?email={{ session('unverified_email') }}"
                style="color: #2563eb; text-decoration: underline; margin-left: 5px; display: inline-block;">
                Resend verification email
            </a>
            @else
            {{ $errors->first() }}
            @endif
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}" id="loginForm">
            @csrf

            <div class="login-page-form-group">
                <label for="email">Email <span>*</span></label>
                <div class="login-page-input-wrapper">
                    <input type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="name@example.com"
                        class="@error('email') is-invalid @enderror"
                        required>
                </div>
                @error('email')
                <div class="login-page-error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="login-page-form-group">
                <label for="password">Password <span>*</span></label>
                <div class="login-page-input-wrapper">
                    <input type="password"
                        id="password"
                        name="password"
                        placeholder="Enter your password"
                        class="@error('password') is-invalid @enderror"
                        required>
                    <button type="button"
                        class="login-page-password-toggle"
                        onclick="togglePassword('password')"
                        tabindex="-1"
                        aria-label="Toggle password visibility">
                        <!-- Eye closed icon (default) -->
                        <svg class="eye-icon eye-closed" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                        <!-- Eye open icon (hidden by default) -->
                        <svg class="eye-icon eye-open" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: none;">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                            <line x1="1" y1="1" x2="23" y2="23"></line>
                        </svg>
                    </button>
                </div>
                @error('password')
                <div class="login-page-error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="login-page-form-options">
                <label class="login-page-remember-me">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <span>Remember me</span>
                </label>
                <!-- In your login.blade.php, update the forgot password link -->
                <a href="{{ route('password.request') }}" class="login-page-forgot-link">
                    Forgot password?
                </a>
            </div>

            <button type="submit" class="login-page-btn-submit" id="submitBtn">
                <span>Log in</span>
            </button>
        </form>

        <!-- Divider -->
        <div class="login-page-divider">
            <span>Or continue with</span>
        </div>

        <!-- Google Login Button Container -->
        <div id="googleButtonContainer" class="mt-2">
            <a href="{{ route('google.login') }}"
                class="login-page-google-btn"
                id="googleLoginBtn">
                <svg class="login-page-google-icon" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                </svg>
                <span>Sign in with Google</span>
            </a>
        </div>

        <!-- Trust Badge -->
        <div style="text-align: center; margin-top: 24px;">
            <p style="color: #9ca3af; font-size: 12px; margin: 0;">
                <svg style="display: inline; width: 12px; height: 12px; margin-right: 4px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                </svg>
                Your information is secure and encrypted
            </p>
        </div>
    </div>
</section>

<script>
    // Toggle password visibility with professional icons
    window.togglePassword = function(fieldId) {
        const field = document.getElementById(fieldId);
        const button = field.nextElementSibling;
        const eyeClosed = button.querySelector('.eye-closed');
        const eyeOpen = button.querySelector('.eye-open');
        
        if (field.type === 'password') {
            field.type = 'text';
            eyeClosed.style.display = 'none';
            eyeOpen.style.display = 'block';
            button.setAttribute('aria-label', 'Hide password');
        } else {
            field.type = 'password';
            eyeClosed.style.display = 'block';
            eyeOpen.style.display = 'none';
            button.setAttribute('aria-label', 'Show password');
        }
    };

    // Show notification
    window.showNotification = function(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = 'login-page-notification';
        notification.style.background = type === 'success' ? '#10b981' : type === 'error' ? '#ef4444' : '#3b82f6';
        notification.textContent = message;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.animation = 'login-page-slideIn 0.3s reverse';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    };

    // Check if we're returning from Google (has code in URL)
    function isReturningFromGoogle() {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.has('code') || urlParams.has('error');
    }

    // Reset Google button if returning from Google (failed login)
    document.addEventListener('DOMContentLoaded', function() {
        // Only reset if we're on the login page and not in the middle of OAuth flow
        if (!isReturningFromGoogle()) {
            // Ensure Google button is visible
            const container = document.getElementById('googleButtonContainer');
            if (container) {
                container.innerHTML = `
                    <a href="{{ route('google.login') }}"
                        class="login-page-google-btn"
                        id="googleLoginBtn">
                        <svg class="login-page-google-icon" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                        </svg>
                        <span>Sign in with Google</span>
                    </a>
                `;
            }
        }

        // Add click handler to Google button
        document.addEventListener('click', function(e) {
            if (e.target.closest('#googleLoginBtn')) {
                e.preventDefault();

                const container = document.getElementById('googleButtonContainer');
                const googleBtn = e.target.closest('#googleLoginBtn');
                const href = googleBtn.getAttribute('href');

                // Show loading state
                container.innerHTML = `
                    <div class="login-page-google-loading">
                        <div class="spinner"></div>
                        <span>Redirecting to Google...</span>
                    </div>
                `;

                // Redirect after a brief delay to show loading state
                setTimeout(() => {
                    window.location.href = href;
                }, 100);
            }
        });

        // Form loading state
        document.getElementById('loginForm')?.addEventListener('submit', function() {
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.innerHTML = '<span class="login-page-spinner"></span> Logging in...';
            submitBtn.disabled = true;
        });

        // Prevent double submission
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }

        // Auto-hide success messages after 5 seconds
        const alerts = document.querySelectorAll('.login-page-alert-success');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.transition = 'opacity 0.3s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 300);
            }, 5000);
        });
    });
</script>
@endsection