@extends('layouts.main')

@section('title', 'Practice Room Access Required')

@push('styles')
<style>
    .practice-paywall {
        --academy-navy: #0A1D44;
        --academy-navy-2: #18386E;
        --academy-teal: #2E5C61;
        --academy-yellow: #FBC60C;
        --academy-ivory: #F9F7E9;
        --academy-white: #FEFDFE;
        min-height: 70vh;
        background: linear-gradient(135deg, var(--academy-ivory), var(--academy-white));
        padding: 72px 16px;
        color: var(--academy-navy);
    }

    .practice-paywall-card {
        max-width: 920px;
        margin: 0 auto;
        background: var(--academy-white);
        border: 1px solid rgba(10, 29, 68, 0.1);
        border-radius: 28px;
        box-shadow: 0 24px 60px rgba(10, 29, 68, 0.12);
        overflow: hidden;
    }

    .practice-paywall-hero {
        background: radial-gradient(circle at top right, rgba(251, 198, 12, 0.35), transparent 34%),
                    linear-gradient(135deg, var(--academy-navy), var(--academy-navy-2) 55%, var(--academy-teal));
        color: var(--academy-white);
        padding: 46px;
    }

    .practice-paywall-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(251, 198, 12, 0.18);
        color: var(--academy-yellow);
        border: 1px solid rgba(251, 198, 12, 0.35);
        border-radius: 999px;
        padding: 8px 14px;
        font-weight: 800;
        margin-bottom: 18px;
    }

    .practice-paywall-hero h1 {
        font-size: clamp(2rem, 4vw, 3.25rem);
        line-height: 1.05;
        margin: 0 0 16px;
        font-weight: 900;
    }

    .practice-paywall-hero p {
        max-width: 720px;
        margin: 0;
        font-size: 1.08rem;
        line-height: 1.75;
        color: rgba(254, 253, 254, 0.88);
    }

    .practice-paywall-body {
        padding: 36px 46px 44px;
    }

    .practice-paywall-body h2 {
        font-size: 1.55rem;
        margin: 0 0 14px;
        font-weight: 900;
    }

    .practice-paywall-features {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
        margin: 24px 0 30px;
    }

    .practice-paywall-feature {
        background: #fffdf2;
        border: 1px solid rgba(251, 198, 12, 0.32);
        border-radius: 18px;
        padding: 18px;
    }

    .practice-paywall-feature i {
        color: var(--academy-teal);
        font-size: 1.35rem;
        margin-bottom: 10px;
    }

    .practice-paywall-feature strong {
        display: block;
        margin-bottom: 6px;
        font-weight: 900;
    }

    .practice-paywall-feature span {
        color: #5f6878;
        font-size: 0.95rem;
        line-height: 1.55;
    }

    .practice-paywall-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
        align-items: center;
    }

    .practice-paywall-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        border-radius: 999px;
        padding: 13px 22px;
        font-weight: 900;
        text-decoration: none;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .practice-paywall-btn:hover {
        transform: translateY(-2px);
        text-decoration: none;
    }

    .practice-paywall-btn-primary {
        background: var(--academy-yellow);
        color: var(--academy-navy);
        box-shadow: 0 14px 28px rgba(251, 198, 12, 0.28);
    }

    .practice-paywall-btn-secondary {
        background: rgba(10, 29, 68, 0.06);
        color: var(--academy-navy);
    }

    @media (max-width: 768px) {
        .practice-paywall-hero,
        .practice-paywall-body {
            padding: 28px;
        }

        .practice-paywall-features {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<section class="practice-paywall">
    <div class="practice-paywall-card">
        <div class="practice-paywall-hero">
            <div class="practice-paywall-kicker"><i class="fas fa-lock"></i> Subscription required</div>
            <h1>Pay to access the Practice Room</h1>
            <p>The Practice Room is included with the paid-course subscription. Once your payment is complete, you will unlock all paid courses plus the Practice Room page, coach settings, speaking sessions, exams, and performance feedback.</p>
        </div>

        <div class="practice-paywall-body">
            <h2>Please purchase a subscription to continue.</h2>
            <p>Your account does not currently have an active paid subscription. Complete payment to access this module immediately.</p>

            <div class="practice-paywall-features">
                <div class="practice-paywall-feature">
                    <i class="fas fa-book-open"></i>
                    <strong>All paid courses</strong>
                    <span>Unlock the same paid-course access that your subscription already controls.</span>
                </div>
                <div class="practice-paywall-feature">
                    <i class="fas fa-microphone-alt"></i>
                    <strong>Practice Room</strong>
                    <span>Start speaking sessions with your English coach after payment.</span>
                </div>
                <div class="practice-paywall-feature">
                    <i class="fas fa-chart-line"></i>
                    <strong>Performance feedback</strong>
                    <span>Review saved sessions, scores, transcripts, and improvement guidance.</span>
                </div>
            </div>

            <div class="practice-paywall-actions">
                <a href="{{ route('subscription.plans') }}" class="practice-paywall-btn practice-paywall-btn-primary">
                    <i class="fas fa-credit-card"></i> Pay now and unlock access
                </a>
                <a href="{{ route('courses') }}" class="practice-paywall-btn practice-paywall-btn-secondary">
                    <i class="fas fa-arrow-left"></i> Browse courses
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
