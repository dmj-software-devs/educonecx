@extends('layouts.main')

@section('title', 'Subscription Successful - EDUCONECX')

@section('content')
<div class="success-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="success-card">
                    <!-- Success Icon -->
                    <div class="success-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    
                    <h1 class="success-title">Subscription Successful!</h1>
                    <p class="success-message">Thank you for subscribing to EDUCONECX. You now have unlimited access to all paid courses.</p>
                    
                    <div class="order-details">
                        <h3>Order Details</h3>
                        
                        <div class="detail-row">
                            <span class="detail-label">Order Number:</span>
                            <span class="detail-value">{{ $order->order_number }}</span>
                        </div>
                        
                        <div class="detail-row">
                            <span class="detail-label">Plan:</span>
                            <span class="detail-value">{{ $order->subscription->name }}</span>
                        </div>
                        
                        <div class="detail-row">
                            <span class="detail-label">Amount Paid:</span>
                            <span class="detail-value">${{ number_format($order->total, 2) }}</span>
                        </div>
                        
                        <div class="detail-row">
                            <span class="detail-label">Payment Method:</span>
                            <span class="detail-value">{{ ucfirst($order->payment_method) }}</span>
                        </div>
                        
                        <div class="detail-row">
                            <span class="detail-label">Payment Status:</span>
                            <span class="detail-value status-badge status-{{ $order->payment_status }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>
                        
                        <div class="detail-row">
                            <span class="detail-label">Valid Until:</span>
                            <span class="detail-value">{{ $order->userSubscription->end_date->format('F d, Y') }}</span>
                        </div>
                    </div>
                    
                    <div class="subscription-info">
                        <i class="fas fa-info-circle"></i>
                        <div>
                            <strong>You've been automatically enrolled in all paid courses!</strong>
                            <p>You can start learning immediately. Your progress will be saved automatically.</p>
                        </div>
                    </div>
                    
                    <div class="action-buttons">
                        <a href="{{ route('dashboard') }}" class="btn btn-primary">
                            <i class="fas fa-tachometer-alt"></i>
                            Go to Dashboard
                        </a>
                        <a href="{{ route('courses') }}" class="btn btn-outline">
                            <i class="fas fa-play-circle"></i>
                            Browse Courses
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.success-container {
    padding: 80px 0;
    background: linear-gradient(135deg, #f5f7ff 0%, #f0f3ff 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
}

.success-card {
    background: white;
    border-radius: 30px;
    padding: 50px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
    text-align: center;
    position: relative;
    overflow: hidden;
}

.success-card::before {
    content: '';
    position: absolute;
    top: -50px;
    right: -50px;
    width: 200px;
    height: 200px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    opacity: 0.05;
    border-radius: 50%;
    z-index: 0;
}

.success-card::after {
    content: '';
    position: absolute;
    bottom: -50px;
    left: -50px;
    width: 200px;
    height: 200px;
    background: linear-gradient(135deg, #06d6a0 0%, #05b587 100%);
    opacity: 0.05;
    border-radius: 50%;
    z-index: 0;
}

.success-icon {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, #06d6a0 0%, #05b587 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 30px;
    color: white;
    font-size: 3rem;
    box-shadow: 0 10px 30px rgba(6, 214, 160, 0.3);
    position: relative;
    z-index: 1;
    animation: scaleIn 0.5s ease;
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

.success-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: #1e1e2f;
    margin-bottom: 15px;
    position: relative;
    z-index: 1;
}

.success-message {
    color: #6c757d;
    font-size: 1.1rem;
    line-height: 1.6;
    margin-bottom: 40px;
    position: relative;
    z-index: 1;
}

.order-details {
    background: #f8f9fa;
    border-radius: 20px;
    padding: 30px;
    margin-bottom: 30px;
    text-align: left;
    position: relative;
    z-index: 1;
}

.order-details h3 {
    font-size: 1.3rem;
    font-weight: 700;
    color: #1e1e2f;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid #e9ecef;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px dashed #e9ecef;
}

.detail-row:last-child {
    border-bottom: none;
}

.detail-label {
    color: #6c757d;
    font-size: 0.95rem;
}

.detail-value {
    color: #1e1e2f;
    font-weight: 600;
    font-size: 1rem;
}

.status-badge {
    display: inline-block;
    padding: 5px 12px;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 600;
}

.status-paid {
    background: rgba(6, 214, 160, 0.1);
    color: #06d6a0;
}

.status-pending {
    background: rgba(255, 193, 7, 0.1);
    color: #ffc107;
}

.status-failed {
    background: rgba(247, 37, 133, 0.1);
    color: #f72585;
}

.subscription-info {
    background: rgba(102, 126, 234, 0.1);
    border-radius: 15px;
    padding: 20px;
    margin-bottom: 30px;
    display: flex;
    align-items: center;
    gap: 15px;
    text-align: left;
    position: relative;
    z-index: 1;
}

.subscription-info i {
    color: #667eea;
    font-size: 2rem;
    flex-shrink: 0;
}

.subscription-info strong {
    color: #1e1e2f;
    font-size: 1rem;
    display: block;
    margin-bottom: 5px;
}

.subscription-info p {
    color: #6c757d;
    font-size: 0.9rem;
    margin: 0;
}

.action-buttons {
    display: flex;
    gap: 15px;
    justify-content: center;
    position: relative;
    z-index: 1;
}

.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 15px 35px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    border-radius: 50px;
    font-size: 1rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
}

.btn-outline {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 15px 35px;
    background: transparent;
    color: #667eea;
    border: 2px solid #667eea;
    border-radius: 50px;
    font-size: 1rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-outline:hover {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    border-color: transparent;
}

@media (max-width: 768px) {
    .success-container {
        padding: 40px 20px;
    }
    
    .success-card {
        padding: 30px 20px;
    }
    
    .success-title {
        font-size: 2rem;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .btn-primary,
    .btn-outline {
        width: 100%;
        justify-content: center;
    }
    
    .detail-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
    }
}
</style>
@endsection