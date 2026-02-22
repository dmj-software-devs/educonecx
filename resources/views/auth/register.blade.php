@extends('layouts.main')

@section('title', 'Register - EDUCONECX')

@section('meta_description', 'Create your EDUCONECX account and start your learning journey today.')

@section('content')
<style>
    /* Simple Register Page Styles */
    :root {
        --primary: #4361ee;
        --primary-dark: #3a56d4;
        --danger: #ef476f;
        --success: #06d6a0;
        --dark: #1e1e2f;
        --gray: #6c757d;
        --gray-light: #e9ecef;
    }

    .register-section {
        padding: 60px 0;
        min-height: calc(100vh - 400px);
        background: linear-gradient(135deg, #f5f7fa 0%, #f8f9fa 100%);
    }

    .register-container {
        max-width: 480px;
        margin: 0 auto;
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        padding: 40px;
    }

    .register-header {
        text-align: center;
        margin-bottom: 35px;
    }

    .register-header h1 {
        font-size: 2rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 8px;
    }

    .register-header p {
        color: var(--gray);
        font-size: 0.95rem;
    }

    .register-header a {
        color: var(--primary);
        font-weight: 600;
        text-decoration: none;
    }

    .register-header a:hover {
        text-decoration: underline;
    }

    /* Form Styles */
    .form-group {
        margin-bottom: 20px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-bottom: 5px;
    }

    label {
        display: block;
        margin-bottom: 6px;
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--dark);
    }

    .required {
        color: var(--danger);
        margin-left: 3px;
    }

    input {
        width: 100%;
        height: 45px;
        padding: 0 15px;
        border: 1.5px solid var(--gray-light);
        border-radius: 10px;
        font-size: 0.95rem;
        color: var(--dark);
        background: white;
        transition: all 0.2s ease;
    }

    input:hover {
        border-color: #cbd5e1;
    }

    input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1);
    }

    input.is-invalid {
        border-color: var(--danger);
    }

    .invalid-feedback {
        color: var(--danger);
        font-size: 0.8rem;
        margin-top: 5px;
    }

    /* Password Field */
    .password-wrapper {
        position: relative;
    }

    .toggle-password {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: var(--gray);
        cursor: pointer;
        font-size: 1.1rem;
        padding: 0;
        display: flex;
        align-items: center;
    }

    .toggle-password:hover {
        color: var(--primary);
    }

    /* Password Strength */
    .password-strength {
        margin-top: 10px;
    }

    .strength-meter {
        display: flex;
        gap: 5px;
        margin-bottom: 5px;
    }

    .strength-segment {
        flex: 1;
        height: 4px;
        background: var(--gray-light);
        border-radius: 4px;
        transition: background 0.2s;
    }

    .strength-segment.weak { background: var(--danger); }
    .strength-segment.medium { background: #f59e0b; }
    .strength-segment.strong { background: var(--success); }

    .strength-text {
        font-size: 0.75rem;
        color: var(--gray);
        font-weight: 500;
    }

    /* Terms Checkbox */
    .terms-checkbox {
        margin: 25px 0 20px;
    }

    .checkbox-wrapper {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        cursor: pointer;
    }

    .checkbox-wrapper input[type="checkbox"] {
        width: 18px;
        height: 18px;
        margin-top: 2px;
        border: 1.5px solid var(--gray-light);
        border-radius: 4px;
        cursor: pointer;
        accent-color: var(--primary);
    }

    .checkbox-text {
        font-size: 0.9rem;
        color: var(--dark);
        line-height: 1.5;
    }

    .checkbox-text a {
        color: var(--primary);
        font-weight: 600;
        text-decoration: none;
    }

    .checkbox-text a:hover {
        text-decoration: underline;
    }

    /* Submit Button */
    .btn-submit {
        width: 100%;
        height: 48px;
        background: var(--primary);
        border: none;
        border-radius: 10px;
        color: white;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-submit:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(67, 97, 238, 0.2);
    }

    .btn-submit:active {
        transform: translateY(0);
    }

    /* Alert */
    .alert {
        padding: 12px 15px;
        border-radius: 10px;
        margin-bottom: 25px;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .alert-error {
        background: #fef2f2;
        border: 1px solid #fee2e2;
        color: #b91c1c;
    }

    .alert-success {
        background: #f0fdf4;
        border: 1px solid #dcfce7;
        color: #166534;
    }

    /* Responsive */
    @media (max-width: 576px) {
        .register-section {
            padding: 40px 0;
        }
        
        .register-container {
            padding: 30px 20px;
            margin: 0 15px;
        }
        
        .form-row {
            grid-template-columns: 1fr;
            gap: 0;
        }
    }
</style>

<section class="register-section">
    <div class="container">
        <div class="register-container">
            <div class="register-header">
                <h1>Create Account</h1>
                <p>Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
            </div>

            @if($errors->any())
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" id="registerForm">
                @csrf

                <div class="form-row">
                    <div class="form-group">
                        <label for="first_name">
                            First name <span class="required">*</span>
                        </label>
                        <input type="text" 
                               id="first_name" 
                               name="first_name" 
                               value="{{ old('first_name') }}" 
                               placeholder="John"
                               class="@error('first_name') is-invalid @enderror"
                               required>
                        @error('first_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="last_name">
                            Last name <span class="required">*</span>
                        </label>
                        <input type="text" 
                               id="last_name" 
                               name="last_name" 
                               value="{{ old('last_name') }}" 
                               placeholder="Doe"
                               class="@error('last_name') is-invalid @enderror"
                               required>
                        @error('last_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">
                        Email address <span class="required">*</span>
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           placeholder="you@example.com"
                           class="@error('email') is-invalid @enderror"
                           required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">
                        Password <span class="required">*</span>
                    </label>
                    <div class="password-wrapper">
                        <input type="password" 
                               id="password" 
                               name="password" 
                               placeholder="Create a password"
                               class="@error('password') is-invalid @enderror"
                               required>
                        <button type="button" class="toggle-password" onclick="togglePassword('password')" tabindex="-1">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    
                    <div class="password-strength" id="passwordStrength" style="display: none;">
                        <div class="strength-meter">
                            <div class="strength-segment" id="strength1"></div>
                            <div class="strength-segment" id="strength2"></div>
                            <div class="strength-segment" id="strength3"></div>
                            <div class="strength-segment" id="strength4"></div>
                        </div>
                        <span class="strength-text" id="strengthText"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">
                        Confirm password <span class="required">*</span>
                    </label>
                    <div class="password-wrapper">
                        <input type="password" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               placeholder="Re-enter password"
                               required>
                        <button type="button" class="toggle-password" onclick="togglePassword('password_confirmation')" tabindex="-1">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="terms-checkbox">
                    <label class="checkbox-wrapper">
                        <input type="checkbox" name="terms" {{ old('terms') ? 'checked' : '' }} required>
                        <span class="checkbox-text">
                            I agree to the <a href="#">Terms</a> and <a href="#">Privacy Policy</a>
                        </span>
                    </label>
                </div>

                <button type="submit" class="btn-submit">
                    Create account
                </button>
            </form>
        </div>
    </div>
</section>

@push('scripts')
<script>
    // Toggle password visibility
    window.togglePassword = function(fieldId) {
        const field = document.getElementById(fieldId);
        const button = field.closest('.password-wrapper').querySelector('.toggle-password');
        const icon = button.querySelector('i');
        
        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            field.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
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
</script>
@endpush
@endsection