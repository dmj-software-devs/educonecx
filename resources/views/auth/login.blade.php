@extends('layouts.main')

@section('title', 'Login - EDUCONECX')

@section('meta_description', 'Log in to your EDUCONECX account and continue your learning journey.')

@section('content')
<style>
    /* Simple Login Page Styles */
    :root {
        --primary: #4361ee;
        --primary-dark: #3a56d4;
        --danger: #ef476f;
        --success: #06d6a0;
        --dark: #1e1e2f;
        --gray: #6c757d;
        --gray-light: #e9ecef;
    }

    .login-section {
        padding: 60px 0;
        min-height: calc(100vh - 400px);
        background: linear-gradient(135deg, #f5f7fa 0%, #f8f9fa 100%);
    }

    .login-container {
        max-width: 480px;
        margin: 0 auto;
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        padding: 40px;
    }

    .login-header {
        text-align: center;
        margin-bottom: 35px;
    }

    .login-header h1 {
        font-size: 2rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 8px;
    }

    .login-header p {
        color: var(--gray);
        font-size: 0.95rem;
    }

    .login-header a {
        color: var(--primary);
        font-weight: 600;
        text-decoration: none;
    }

    .login-header a:hover {
        text-decoration: underline;
    }

    /* Form Styles */
    .form-group {
        margin-bottom: 20px;
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

    /* Form Options */
    .form-options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 20px 0 25px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .remember-me {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        color: var(--gray);
        font-size: 0.9rem;
    }

    .remember-me input[type="checkbox"] {
        width: 16px;
        height: 16px;
        cursor: pointer;
        accent-color: var(--primary);
    }

    .forgot-password {
        color: var(--primary);
        font-size: 0.9rem;
        font-weight: 500;
        text-decoration: none;
    }

    .forgot-password:hover {
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

    /* Demo Credentials */
    .demo-credentials {
        margin-top: 25px;
        padding-top: 20px;
        border-top: 1px solid var(--gray-light);
    }

    .demo-credentials h4 {
        font-size: 0.9rem;
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
        font-size: 0.85rem;
        padding: 8px 10px;
        border-radius: 8px;
        background: var(--gray-light);
        opacity: 0.8;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .demo-item:hover {
        opacity: 1;
        transform: translateX(5px);
    }

    .demo-item strong {
        color: var(--dark);
        min-width: 50px;
    }

    .demo-item span {
        font-family: monospace;
        background: white;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 0.8rem;
    }

    .demo-item i {
        margin-left: auto;
        color: var(--primary);
    }

    .demo-note {
        font-size: 0.8rem;
        color: var(--gray);
        margin-top: 10px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .demo-note i {
        color: var(--primary);
        font-size: 0.8rem;
    }

    /* Responsive */
    @media (max-width: 576px) {
        .login-section {
            padding: 40px 0;
        }
        
        .login-container {
            padding: 30px 20px;
            margin: 0 15px;
        }
        
        .form-options {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<section class="login-section">
    <div class="container">
        <div class="login-container">
            <div class="login-header">
                <h1>Welcome Back</h1>
                <p>Don't have an account? <a href="{{ route('register') }}">Sign up</a></p>
            </div>

            @if(session('status'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf

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
                               placeholder="Enter your password"
                               class="@error('password') is-invalid @enderror"
                               required>
                        <button type="button" class="toggle-password" onclick="togglePassword('password')" tabindex="-1">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span>Remember me</span>
                    </label>
                    <a href="#" class="forgot-password" onclick="showNotification('Password reset coming soon!', 'info')">
                        Forgot password?
                    </a>
                </div>

                <button type="submit" class="btn-submit" id="submitBtn">
                    <span>Log in</span>
                </button>
            </form>

            <!-- Demo Credentials (for development) -->
            <div class="demo-credentials">
                <h4>
                    <i class="fas fa-info-circle"></i>
                    Demo Credentials
                </h4>
                <div class="demo-item" onclick="fillDemoCredentials('admin@educonecx.com', 'password')">
                    <strong>Admin:</strong>
                    <span>admin@educonecx.com</span>
                    <span>password</span>
                    <i class="fas fa-copy" onclick="copyCredentials(event, 'admin@educonecx.com', 'password')"></i>
                </div>
                <div class="demo-item" onclick="fillDemoCredentials('user@educonecx.com', 'password')">
                    <strong>User:</strong>
                    <span>user@educonecx.com</span>
                    <span>password</span>
                    <i class="fas fa-copy" onclick="copyCredentials(event, 'user@educonecx.com', 'password')"></i>
                </div>
                <div class="demo-note">
                    <i class="fas fa-lightbulb"></i>
                    Click on any demo account to auto-fill
                </div>
            </div>
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

    // Fill demo credentials
    function fillDemoCredentials(email, password) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = password;
        
        // Highlight effect
        document.getElementById('email').style.backgroundColor = '#e8f5e9';
        document.getElementById('password').style.backgroundColor = '#e8f5e9';
        
        setTimeout(() => {
            document.getElementById('email').style.backgroundColor = '';
            document.getElementById('password').style.backgroundColor = '';
        }, 500);
        
        showNotification('Credentials filled!', 'success');
    }

    // Copy credentials
    function copyCredentials(event, email, password) {
        event.stopPropagation();
        const text = `Email: ${email}\nPassword: ${password}`;
        navigator.clipboard.writeText(text).then(() => {
            showNotification('Credentials copied!', 'success');
        });
    }

    // Show notification
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.style.cssText = `
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: ${type === 'success' ? '#06d6a0' : type === 'error' ? '#ef476f' : '#4361ee'};
            color: white;
            padding: 12px 24px;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            z-index: 9999;
            animation: slideIn 0.3s ease;
            font-size: 0.9rem;
        `;
        notification.textContent = message;
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    // Add animations
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
    `;
    document.head.appendChild(style);

    // Form loading state
    document.getElementById('loginForm')?.addEventListener('submit', function(e) {
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Logging in...';
        submitBtn.disabled = true;
    });
</script>
@endpush
@endsection