@extends('layouts.main')

@section('title', 'Verify Email - EDUCONECX')

@section('content')
<section class="verify-email-section">
    <div class="verify-email-container">
        <div class="verify-email-header">
            <h1>Verify Your Email Address</h1>
        </div>

        @if (session('message'))
        <div class="verify-email-alert verify-email-alert-success">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20 6L9 17l-5-5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            {{ session('message') }}
        </div>
        @endif

        <div class="verify-email-content">
            <p>Thanks for signing up! Please verify your email by clicking the link we just sent. If you don't see the verification email in your inbox within 2-3 minutes, check your spam/junk folder and mark it as "Not Spam" so future emails arrive correctly. If it still hasn't arrived, we can send another one below.</p>

            <form method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit" class="verify-email-btn">
                    Resend Verification Email
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="verify-email-logout">
                @csrf
                <button type="submit" class="verify-email-link">
                    Logout
                </button>
            </form>
        </div>
    </div>
</section>

<style>
.verify-email-section {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #ffffff;
    padding: 20px;
    font-family: 'Inter', sans-serif;
}

.verify-email-container {
    max-width: 500px;
    width: 100%;
    background: #ffffff;
    border-radius: 24px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
    padding: 48px 40px;
    border: 1px solid #f0f0f0;
}

.verify-email-header {
    text-align: center;
    margin-bottom: 32px;
}

.verify-email-header h1 {
    font-size: 28px;
    font-weight: 700;
    color: #1f2937;
    margin: 0 0 8px 0;
}

.verify-email-content {
    text-align: center;
}

.verify-email-content p {
    color: #6b7280;
    font-size: 15px;
    line-height: 1.6;
    margin-bottom: 32px;
}

.verify-email-alert {
    padding: 14px 16px;
    border-radius: 12px;
    margin-bottom: 24px;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.verify-email-alert-success {
    background: #f0fdf4;
    border: 1px solid #dcfce7;
    color: #16a34a;
}

.verify-email-btn {
    width: 100%;
    height: 48px;
    background: #2563eb;
    border: none;
    border-radius: 12px;
    color: #ffffff;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    margin-bottom: 16px;
}

.verify-email-btn:hover {
    background: #1d4ed8;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(37, 99, 235, 0.2);
}

.verify-email-link {
    color: #6b7280;
    text-decoration: none;
    font-size: 14px;
    background: none;
    border: none;
    cursor: pointer;
}

.verify-email-link:hover {
    color: #2563eb;
    text-decoration: underline;
}

.verify-email-logout {
    margin-top: 16px;
}
</style>
@endsection