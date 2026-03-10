@extends('layouts.main')

@section('title', 'Reset Password - EDUCONECX')

@section('meta_description', 'Set a new password for your EDUCONECX account.')

@section('content')
<style>
    /* Reuse the same styles from forgot password page */
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

    .login-page-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .login-page-header h1 {
        font-size: 32px !important;
        font-weight: 700 !important;
        color: #1f2937 !important;
        margin: 0 0 8px 0 !important;
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
    }

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

    .login-page-form-group {
        margin-bottom: 24px;
        width: 100%;
    }

    .login-page-form-group label {
        display: block !important;
        margin: 0 0 8px 0 !important;
        font-size: 14px !important;
        font-weight: 500 !important;
        color: #1f2937 !important;
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
    }

    .login-page-input-wrapper input:focus {
        outline: none !important;
        border-color: #2563eb !important;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1) !important;
    }

    .login-page-input-wrapper input.is-invalid {
        border-color: #dc2626 !important;
    }

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
    }

    .login-page-password-toggle:hover {
        color: #2563eb !important;
    }

    .login-page-error-message {
        color: #dc2626 !important;
        font-size: 13px !important;
        margin-top: 6px !important;
        display: block !important;
    }

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
        margin-bottom: 16px !important;
    }

    .login-page-btn-submit:hover {
        background: #1d4ed8 !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.2) !important;
    }

    .login-page-btn-submit:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

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

    .password-requirements {
        margin-top: 8px;
        font-size: 12px;
        color: #6b7280;
    }

    @media (max-width: 480px) {
        .login-page-container {
            padding: 32px 24px;
        }
    }
</style>

<section class="login-page-section">
    <div class="login-page-container">
        <div class="login-page-header">
            <h1>Set new password</h1>
            <p>Please enter your new password below.</p>
        </div>

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

        <form method="POST" action="{{ route('password.update') }}" id="resetPasswordForm">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="login-page-form-group">
                <label for="email">Email address <span>*</span></label>
                <div class="login-page-input-wrapper">
                    <input type="email"
                        id="email"
                        name="email"
                        value="{{ $email ?? old('email') }}"
                        class="@error('email') is-invalid @enderror"
                        required
                        readonly>
                </div>
            </div>

            <div class="login-page-form-group">
                <label for="password">New password <span>*</span></label>
                <div class="login-page-input-wrapper">
                    <input type="password"
                        id="password"
                        name="password"
                        placeholder="Enter new password"
                        class="@error('password') is-invalid @enderror"
                        required>
                    <button type="button"
                        class="login-page-password-toggle"
                        onclick="togglePassword('password')"
                        tabindex="-1">
                        👁️
                    </button>
                </div>
                <div class="password-requirements">
                    Password must be at least 8 characters long.
                </div>
            </div>

            <div class="login-page-form-group">
                <label for="password_confirmation">Confirm new password <span>*</span></label>
                <div class="login-page-input-wrapper">
                    <input type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Confirm new password"
                        required>
                    <button type="button"
                        class="login-page-password-toggle"
                        onclick="togglePassword('password_confirmation')"
                        tabindex="-1">
                        👁️
                    </button>
                </div>
            </div>

            <button type="submit" class="login-page-btn-submit" id="submitBtn">
                Reset password
            </button>
        </form>
    </div>
</section>

<script>
    window.togglePassword = function(fieldId) {
        const field = document.getElementById(fieldId);
        const button = field.nextElementSibling;
        const type = field.type === 'password' ? 'text' : 'password';
        field.type = type;
        button.textContent = type === 'password' ? '👁️' : '🔒';
    };

    document.getElementById('resetPasswordForm')?.addEventListener('submit', function() {
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.innerHTML = '<span class="login-page-spinner"></span> Resetting password...';
        submitBtn.disabled = true;
    });
</script>
@endsection