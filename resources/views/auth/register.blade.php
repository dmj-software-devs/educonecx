@extends('layouts.main')

@section('title', 'Register - EDUCONECX')

@section('meta_description', 'Create your EDUCONECX account and start your learning journey today.')

@section('content')
<style>
    /* Register Page Specific Styles - Scoped to prevent conflicts */
    .register-page-section {
        min-height: 100vh;
        display: flex;
        align-items: center;
        background: linear-gradient(135deg, #f5f7fa 0%, #f8f9fa 100%);
        padding: 40px 20px;
        font-family: 'Inter', sans-serif;
    }

    .register-page-container {
        max-width: 520px;
        width: 100%;
        margin: 0 auto;
        background: #ffffff;
        border-radius: 24px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        padding: 48px 40px;
    }

    /* Header */
    .register-page-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .register-page-header h1 {
        font-size: 32px !important;
        font-weight: 700 !important;
        color: #1f2937 !important;
        margin: 0 0 8px 0 !important;
        padding: 0 !important;
        line-height: 1.2 !important;
        background: none !important;
        -webkit-text-fill-color: #1f2937 !important;
    }

    .register-page-header p {
        color: #6b7280 !important;
        font-size: 15px !important;
        margin: 0 !important;
    }

    .register-page-header a {
        color: #2563eb !important;
        font-weight: 500 !important;
        text-decoration: none !important;
        background: none !important;
        padding: 0 !important;
    }

    .register-page-header a:hover {
        text-decoration: underline !important;
    }

    /* Alert Messages */
    .register-page-alert {
        padding: 14px 16px;
        border-radius: 12px;
        margin-bottom: 24px;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .register-page-alert-error {
        background: #fef2f2;
        border: 1px solid #fee2e2;
        color: #dc2626;
    }

    .register-page-alert-success {
        background: #f0fdf4;
        border: 1px solid #dcfce7;
        color: #16a34a;
    }

    /* Form Groups - Fixed Alignment */
    .register-page-form-group {
        margin-bottom: 20px;
        width: 100%;
    }

    .register-page-form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-bottom: 5px;
    }

    .register-page-form-group label {
        display: block !important;
        margin: 0 0 6px 0 !important;
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

    .register-page-form-group label .required {
        color: #dc2626;
        margin-left: 2px;
    }

    .register-page-input-wrapper {
        position: relative;
        width: 100%;
    }

    .register-page-input-wrapper input {
        width: 100% !important;
        height: 45px !important;
        padding: 0 16px !important;
        border: 2px solid #e5e7eb !important;
        border-radius: 10px !important;
        font-size: 15px !important;
        color: #1f2937 !important;
        background: #ffffff !important;
        transition: all 0.2s ease !important;
        margin: 0 !important;
        box-shadow: none !important;
        line-height: normal !important;
    }

    .register-page-input-wrapper input:hover {
        border-color: #9ca3af !important;
    }

    .register-page-input-wrapper input:focus {
        outline: none !important;
        border-color: #2563eb !important;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1) !important;
    }

    .register-page-input-wrapper input.is-invalid {
        border-color: #dc2626 !important;
    }

    .register-page-error-message {
        color: #dc2626 !important;
        font-size: 13px !important;
        margin-top: 4px !important;
        display: block !important;
    }

    /* Password Toggle */
    .register-page-password-toggle {
        position: absolute !important;
        right: 12px !important;
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
        display: flex !important;
        align-items: center !important;
    }

    .register-page-password-toggle:hover {
        color: #2563eb !important;
    }

    /* Password Strength */
    .register-page-password-strength {
        margin-top: 10px;
    }

    .register-page-strength-meter {
        display: flex;
        gap: 5px;
        margin-bottom: 5px;
    }

    .register-page-strength-segment {
        flex: 1;
        height: 4px;
        background: #e5e7eb;
        border-radius: 4px;
        transition: background 0.2s;
    }

    .register-page-strength-segment.weak { 
        background: #dc2626 !important; 
    }
    
    .register-page-strength-segment.medium { 
        background: #f59e0b !important; 
    }
    
    .register-page-strength-segment.strong { 
        background: #10b981 !important; 
    }

    .register-page-strength-text {
        font-size: 12px !important;
        color: #6b7280 !important;
        font-weight: 500;
    }

    /* Terms Checkbox */
    .register-page-terms-checkbox {
        margin: 25px 0 20px;
    }

    .register-page-checkbox-wrapper {
        display: flex !important;
        align-items: flex-start !important;
        gap: 10px !important;
        cursor: pointer !important;
        margin: 0 !important;
    }

    .register-page-checkbox-wrapper input[type="checkbox"] {
        width: 18px !important;
        height: 18px !important;
        margin: 2px 0 0 0 !important;
        border: 2px solid #e5e7eb !important;
        border-radius: 4px !important;
        cursor: pointer !important;
        accent-color: #2563eb !important;
        padding: 0 !important;
        flex-shrink: 0;
    }

    .register-page-checkbox-text {
        font-size: 14px !important;
        color: #1f2937 !important;
        line-height: 1.5 !important;
    }

    .register-page-checkbox-text a {
        color: #2563eb !important;
        font-weight: 500 !important;
        text-decoration: none !important;
    }

    .register-page-checkbox-text a:hover {
        text-decoration: underline !important;
    }

    /* Submit Button */
    .register-page-btn-submit {
        width: 100% !important;
        height: 48px !important;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        border: none !important;
        border-radius: 10px !important;
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

    .register-page-btn-submit:hover:not(:disabled) {
        transform: translateY(-2px) !important;
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3) !important;
    }

    .register-page-btn-submit:active:not(:disabled) {
        transform: translateY(0) !important;
    }

    .register-page-btn-submit:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    /* Loading Spinner */
    .register-page-spinner {
        display: inline-block;
        width: 16px;
        height: 16px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        border-top-color: #ffffff;
        animation: register-page-spin 0.8s linear infinite;
    }

    @keyframes register-page-spin {
        to {
            transform: rotate(360deg);
        }
    }

    /* Responsive */
    @media (max-width: 576px) {
        .register-page-container {
            padding: 32px 24px;
        }

        .register-page-header h1 {
            font-size: 28px !important;
        }

        .register-page-form-row {
            grid-template-columns: 1fr;
            gap: 0;
        }
    }
</style>

<section class="register-page-section">
    <div class="register-page-container">
        <div class="register-page-header">
            <h1>Create Account</h1>
            <p>Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
        </div>

        @if($errors->any())
        <div class="register-page-alert register-page-alert-error">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10" />
                <line x1="12" y1="8" x2="12" y2="12" />
                <line x1="12" y1="16" x2="12.01" y2="16" />
            </svg>
            <span>{{ $errors->first() }}</span>
        </div>
        @endif

        <form method="POST" action="{{ route('register') }}" id="registerForm">
            @csrf

            <div class="register-page-form-row">
                <div class="register-page-form-group">
                    <label for="first_name">First name <span class="required">*</span></label>
                    <div class="register-page-input-wrapper">
                        <input type="text"
                            id="first_name"
                            name="first_name"
                            value="{{ old('first_name') }}"
                            placeholder="John"
                            class="@error('first_name') is-invalid @enderror"
                            required>
                    </div>
                    @error('first_name')
                    <div class="register-page-error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="register-page-form-group">
                    <label for="last_name">Last name <span class="required">*</span></label>
                    <div class="register-page-input-wrapper">
                        <input type="text"
                            id="last_name"
                            name="last_name"
                            value="{{ old('last_name') }}"
                            placeholder="Doe"
                            class="@error('last_name') is-invalid @enderror"
                            required>
                    </div>
                    @error('last_name')
                    <div class="register-page-error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="register-page-form-group">
                <label for="email">Email address <span class="required">*</span></label>
                <div class="register-page-input-wrapper">
                    <input type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="you@example.com"
                        class="@error('email') is-invalid @enderror"
                        required>
                </div>
                @error('email')
                <div class="register-page-error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="register-page-form-group">
                <label for="password">Password <span class="required">*</span></label>
                <div class="register-page-input-wrapper">
                    <input type="password"
                        id="password"
                        name="password"
                        placeholder="Create a password"
                        class="@error('password') is-invalid @enderror"
                        required>
                    <button type="button"
                        class="register-page-password-toggle"
                        onclick="togglePassword('password')"
                        tabindex="-1">
                        👁️
                    </button>
                </div>
                @error('password')
                <div class="register-page-error-message">{{ $message }}</div>
                @enderror

                <div class="register-page-password-strength" id="passwordStrength" style="display: none;">
                    <div class="register-page-strength-meter">
                        <div class="register-page-strength-segment" id="strength1"></div>
                        <div class="register-page-strength-segment" id="strength2"></div>
                        <div class="register-page-strength-segment" id="strength3"></div>
                        <div class="register-page-strength-segment" id="strength4"></div>
                    </div>
                    <span class="register-page-strength-text" id="strengthText"></span>
                </div>
            </div>

            <div class="register-page-form-group">
                <label for="password_confirmation">Confirm password <span class="required">*</span></label>
                <div class="register-page-input-wrapper">
                    <input type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Re-enter password"
                        required>
                    <button type="button"
                        class="register-page-password-toggle"
                        onclick="togglePassword('password_confirmation')"
                        tabindex="-1">
                        👁️
                    </button>
                </div>
            </div>

            <div class="register-page-terms-checkbox">
                <label class="register-page-checkbox-wrapper">
                    <input type="checkbox" name="terms" {{ old('terms') ? 'checked' : '' }} required>
                    <span class="register-page-checkbox-text">
                        I agree to the <a href="#">Terms</a> and <a href="#">Privacy Policy</a>
                    </span>
                </label>
            </div>

            <button type="submit" class="register-page-btn-submit" id="submitBtn">
                <span>Create account</span>
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

    // Password strength indicator
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.getElementById('password');
        const strengthDiv = document.getElementById('passwordStrength');
        const segments = [
            document.getElementById('strength1'),
            document.getElementById('strength2'),
            document.getElementById('strength3'),
            document.getElementById('strength4')
        ];
        const strengthText = document.getElementById('strengthText');

        function resetSegments() {
            segments.forEach(seg => {
                seg.classList.remove('weak', 'medium', 'strong');
            });
        }

        passwordInput.addEventListener('input', function() {
            const val = this.value;

            if (val.length === 0) {
                strengthDiv.style.display = 'none';
                return;
            }

            strengthDiv.style.display = 'block';

            // Strength criteria
            let score = 0;
            if (val.length >= 8) score++;
            if (/[a-z]/.test(val)) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^a-zA-Z0-9]/.test(val)) score++;

            // Calculate filled segments (1-4)
            let filledSegments = 0;
            if (score >= 1) filledSegments = 1;
            if (score >= 3) filledSegments = 2;
            if (score >= 4) filledSegments = 3;
            if (score >= 5) filledSegments = 4;

            resetSegments();

            // Apply appropriate class
            for (let i = 0; i < filledSegments; i++) {
                if (filledSegments <= 2) segments[i].classList.add('weak');
                else if (filledSegments === 3) segments[i].classList.add('medium');
                else segments[i].classList.add('strong');
            }

            // Set strength text
            const strengthLabels = ['Very weak', 'Weak', 'Fair', 'Good', 'Strong'];
            strengthText.textContent = strengthLabels[filledSegments] || '';
        });
    });

    // Form loading state
    document.getElementById('registerForm')?.addEventListener('submit', function() {
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.innerHTML = '<span class="register-page-spinner"></span> Creating account...';
        submitBtn.disabled = true;
    });

    // Prevent double submission
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
@endsection