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

    /* Password Toggle */
    .login-page-password-toggle {
        position: absolute !important;
        right: 14px !important;
        top: 50% !important;
        transform: translateY(-50%) !important;
        background: none !important;
        border: none !important;
        color: #6b7280 !important;
        cursor: pointer !important;
        font-size: 18px !important;
        padding: 4px !important;
        width: auto !important;
        height: auto !important;
        line-height: 1 !important;
    }

    .login-page-password-toggle:hover {
        color: #2563eb !important;
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
    }

    @keyframes login-page-spin {
        to {
            transform: rotate(360deg);
        }
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

        @if(session('status'))
        <div class="login-page-alert login-page-alert-success">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20 6L9 17l-5-5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            {{ session('status') }}
        </div>
        @endif

        @if($errors->any())
        <div class="login-page-alert login-page-alert-error">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10" />
                <line x1="12" y1="8" x2="12" y2="12" />
                <line x1="12" y1="16" x2="12.01" y2="16" />
            </svg>
            {{ $errors->first() }}
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
                        tabindex="-1">
                        👁️
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
                <a href="#" class="login-page-forgot-link" onclick="showNotification('Password reset coming soon!')">
                    Forgot password?
                </a>
            </div>

            <button type="submit" class="login-page-btn-submit" id="submitBtn">
                <span>Log in</span>
            </button>
        </form>
    </div>
</section>

<script>
    // Toggle password visibility
    window.togglePassword = function(fieldId) {
        const field = document.getElementById(fieldId);
        const button = field.nextElementSibling;
        const type = field.type === 'password' ? 'text' : 'password';
        field.type = type;
        button.textContent = type === 'password' ? '👁️' : '🔒';
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
</script>
@endsection