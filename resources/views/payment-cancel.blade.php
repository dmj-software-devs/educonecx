@extends('layouts.main')

@section('title', 'Payment Cancelled')

@section('content')
<div class="cancel-container">
    <div class="container">
        <div class="cancel-card">
            <div class="cancel-icon">
                <i class="fas fa-times-circle"></i>
            </div>
            <h1>Payment Cancelled</h1>
            <p>Your payment was cancelled. No charges were made.</p>
            
            <div class="action-buttons">
                <a href="javascript:history.back()" class="btn-try-again">
                    <i class="fas fa-redo"></i>
                    Try Again
                </a>
                <a href="{{ route('courses') }}" class="btn-browse">
                    <i class="fas fa-search"></i>
                    Browse Courses
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.cancel-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 40px 0;
}

.cancel-card {
    background: white;
    border-radius: 30px;
    padding: 60px;
    max-width: 500px;
    margin: 0 auto;
    text-align: center;
    box-shadow: 0 30px 60px rgba(0,0,0,0.1);
}

.cancel-icon {
    width: 100px;
    height: 100px;
    background: #dc3545;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 30px;
    color: white;
    font-size: 3rem;
    animation: scaleIn 0.5s ease;
}

.cancel-card h1 {
    font-size: 2rem;
    margin-bottom: 15px;
    color: #333;
}

.cancel-card p {
    color: #666;
    margin-bottom: 30px;
}

.action-buttons {
    display: flex;
    gap: 15px;
}

.btn-try-again, .btn-browse {
    flex: 1;
    padding: 15px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s;
}

.btn-try-again {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.btn-try-again:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
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
    .cancel-card {
        padding: 30px;
    }
    
    .action-buttons {
        flex-direction: column;
    }
}
</style>
@endsection