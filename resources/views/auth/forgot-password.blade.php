@extends('layouts.main')

@section('title', 'Forgot Password - EDUCONECX')

@section('meta_description', 'Reset your EDUCONECX account password.')

@section('content')
<style>
    /* Reuse the same styles from login page */
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

    .login-page-header a:hover {
        text-decoration: underline !important;
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

    .login-page-alert-success {
        background: #f0fdf4;
        border: 1px solid #dcfce7;
        color: #16a34a;
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

    .login-page-back-link {
        display: block;
        text-align: center;
        color: #6b7280 !important;
        font-size: 14px !important;
        text-decoration: none !important;
    }

    .login-page-back-link:hover {
        color: #2563eb !important;
    }

    .login-page-info-text {
        background: #f8fafc;
        padding: 16px;
        border-radius: 12px;
        margin-bottom: 24px;
        font-size: 14px;
        color: #475569;
        border: 1px solid #e2e8f0;
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
            <h1>Reset password</h1>
            <p>Remember your password? <a href="{{ route('login') }}">Back to login</a></p>
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

        <div class="login-page-info-text">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="float: left; margin-right: 10px;">
                <circle cx="12" cy="12" r="10" />
                <line x1="12" y1="16" x2="12" y2="12" />
                <line x1="12" y1="8" x2="12.01" y2="8" />
            </svg>
            Enter your email address and we'll send you a link to reset your password.
        </div>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="login-page-form-group">
                <label for="email">Email address <span>*</span></label>
                <div class="login-page-input-wrapper">
                    <input type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="name@example.com"
                        class="@error('email') is-invalid @enderror"
                        required
                        autofocus>
                </div>
            </div>

            <button type="submit" class="login-page-btn-submit">
                Send password reset link
            </button>

            <a href="{{ route('login') }}" class="login-page-back-link">
                ← Back to login
            </a>
        </form>
    </div>
</section>
@endsection