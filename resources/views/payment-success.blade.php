@extends('layouts.main')

@section('title', 'Payment Successful')

@section('content')
<div class="success-container">
    <div class="container">
        <div class="success-card">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h1>Payment Successful!</h1>
            <p>Thank you for your purchase. You now have access to your course.</p>
            
            <div class="order-details">
                <h3>Order Details</h3>
                <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
                <p><strong>Total Paid:</strong> ${{ number_format($order->total, 2) }}</p>
                <p><strong>Date:</strong> {{ $order->created_at->format('F j, Y') }}</p>
            </div>

            <div class="course-info">
                <h3>Course Access</h3>
                @foreach($order->items as $item)
                    <div class="course-item">
                        <h4>{{ $item->course_title }}</h4>
                        <a href="{{ route('courses.learning', $item->course->slug) }}" class="btn-start">
                            <i class="fas fa-play-circle"></i>
                            Start Learning
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="action-buttons">
                <a href="{{ route('dashboard') }}" class="btn-dashboard">
                    <i class="fas fa-tachometer-alt"></i>
                    Go to Dashboard
                </a>
                <a href="{{ route('courses') }}" class="btn-browse">
                    <i class="fas fa-search"></i>
                    Browse More Courses
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.success-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 40px 0;
}

.success-card {
    background: white;
    border-radius: 30px;
    padding: 60px;
    max-width: 600px;
    margin: 0 auto;
    text-align: center;
    box-shadow: 0 30px 60px rgba(0,0,0,0.3);
}

.success-icon {
    width: 100px;
    height: 100px;
    background: #28a745;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 30px;
    color: white;
    font-size: 3rem;
    animation: scaleIn 0.5s ease;
}

@keyframes scaleIn {
    from {
        transform: scale(0);
    }
    to {
        transform: scale(1);
    }
}

.success-card h1 {
    font-size: 2.5rem;
    margin-bottom: 15px;
    color: #333;
}

.order-details {
    background: #f8f9fa;
    padding: 25px;
    border-radius: 15px;
    margin: 30px 0;
    text-align: left;
}

.order-details h3 {
    margin-bottom: 20px;
    color: #333;
}

.order-details p {
    margin-bottom: 10px;
    color: #666;
}

.course-info {
    text-align: left;
    margin-bottom: 30px;
}

.course-item {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 15px;
    margin-bottom: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.course-item h4 {
    margin: 0;
    font-size: 1.1rem;
}

.btn-start {
    padding: 10px 20px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    text-decoration: none;
    border-radius: 9999px;
    font-weight: 600;
    transition: all 0.3s;
}

.btn-start:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    color: white;
}

.action-buttons {
    display: flex;
    gap: 15px;
}

.btn-dashboard, .btn-browse {
    flex: 1;
    padding: 15px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s;
}

.btn-dashboard {
    background: #333;
    color: white;
}

.btn-dashboard:hover {
    background: #000;
    color: white;
}

.btn-browse {
    background: #f8f9fa;
    color: #333;
}

.btn-browse:hover {
    background: #e9ecef;
    color: #333;
}

@media (max-width: 768px) {
    .success-card {
        padding: 30px;
    }
    
    .course-item {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }
    
    .action-buttons {
        flex-direction: column;
    }
}
</style>
@endsection