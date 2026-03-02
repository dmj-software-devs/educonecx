@extends('layouts.main')

@section('title', 'Payment Successful - All-Access Pass')

@section('content')
<style>
    .success-container {
        min-height: 60vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 60px 20px;
    }

    .success-card {
        background: white;
        border-radius: 24px;
        padding: 50px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        max-width: 600px;
        width: 100%;
        text-align: center;
    }

    .success-icon {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #06d6a0 0%, #1b9e6d 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 30px;
        color: white;
        font-size: 3rem;
        animation: scaleIn 0.5s ease;
    }

    .success-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 15px;
        color: #333;
        animation: fadeInUp 0.5s ease 0.2s both;
    }

    .success-message {
        font-size: 1.2rem;
        color: #6c757d;
        margin-bottom: 30px;
        animation: fadeInUp 0.5s ease 0.4s both;
    }

    .order-details {
        background: #f8f9fa;
        border-radius: 16px;
        padding: 25px;
        margin-bottom: 30px;
        animation: fadeInUp 0.5s ease 0.6s both;
    }

    .order-detail-item {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #e9ecef;
    }

    .order-detail-item:last-child {
        border-bottom: none;
    }

    .order-label {
        color: #6c757d;
        font-weight: 500;
    }

    .order-value {
        font-weight: 600;
        color: #333;
    }

    .btn-group {
        display: flex;
        gap: 15px;
        justify-content: center;
        animation: fadeInUp 0.5s ease 0.8s both;
    }

    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 15px 30px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        text-decoration: none;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(102,126,234,0.3);
    }

    .btn-secondary {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 15px 30px;
        background: #f8f9fa;
        color: #333;
        text-decoration: none;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: 2px solid #e9ecef;
    }

    .btn-secondary:hover {
        background: #e9ecef;
        transform: translateY(-3px);
    }

    @keyframes scaleIn {
        from {
            transform: scale(0);
            opacity: 0;
        }
        to {
            transform: scale(1);
            opacity: 1;
        }
    }

    @keyframes fadeInUp {
        from {
            transform: translateY(20px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    @media (max-width: 576px) {
        .success-card {
            padding: 30px 20px;
        }

        .btn-group {
            flex-direction: column;
        }

        .success-title {
            font-size: 2rem;
        }
    }
</style>

<div class="success-container">
    <div class="success-card">
        <div class="success-icon">
            <i class="fas fa-check"></i>
        </div>
        
        <h1 class="success-title">Payment Successful!</h1>
        <p class="success-message">Thank you for purchasing the All-Access Pass. You now have unlimited access to all our paid courses.</p>
        
        <div class="order-details">
            <div class="order-detail-item">
                <span class="order-label">Order Number:</span>
                <span class="order-value">{{ $order->order_number }}</span>
            </div>
            <div class="order-detail-item">
                <span class="order-label">Date:</span>
                <span class="order-value">{{ $order->created_at->format('F j, Y') }}</span>
            </div>
            <div class="order-detail-item">
                <span class="order-label">Amount Paid:</span>
                <span class="order-value">${{ number_format($order->total, 2) }}</span>
            </div>
            <div class="order-detail-item">
                <span class="order-label">Payment Method:</span>
                <span class="order-value">{{ ucfirst($order->payment_method) }}</span>
            </div>
            <div class="order-detail-item">
                <span class="order-label">Courses Unlocked:</span>
                <span class="order-value">{{ \App\Models\Course::where('is_free', false)->count() }} courses</span>
            </div>
        </div>
        
        <div class="btn-group">
            <a href="{{ route('courses') }}" class="btn-primary">
                <i class="fas fa-book"></i> Browse Courses
            </a>
            <a href="{{ route('dashboard') }}" class="btn-secondary">
                <i class="fas fa-user"></i> Go to Dashboard
            </a>
        </div>
        
        <p class="text-muted small mt-4">
            <i class="fas fa-envelope"></i> A confirmation email has been sent to your email address.
        </p>
    </div>
</div>
@endsection