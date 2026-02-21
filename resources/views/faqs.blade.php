@extends('layouts.main')

@section('title', 'FAQs - EDUCONECX')

@section('meta_description', 'Find answers to frequently asked questions about EDUCONECX courses, payments, subscriptions, and digital services. Need more help? Contact our support team.')

@push('styles')
<style>
    /* FAQ Header */
    .faq-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 80px 0;
        text-align: center;
        margin-bottom: 60px;
    }
    
    .faq-title {
        font-size: 48px;
        margin-bottom: 20px;
        animation: slideUp 0.8s ease-out;
    }
    
    .faq-subtitle {
        font-size: 18px;
        opacity: 0.9;
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.6;
        animation: slideUp 0.8s ease-out 0.2s both;
    }
    
    /* FAQ Section */
    .faq-section {
        padding: 0 0 80px;
    }
    
    .faq-description {
        text-align: center;
        max-width: 800px;
        margin: 0 auto 50px;
        font-size: 18px;
        color: #666;
        line-height: 1.8;
    }
    
    .faq-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .faq-column {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    
    /* FAQ Item */
    .faq-item {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        transition: all 0.3s;
    }
    
    .faq-item:hover {
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }
    
    .faq-question {
        padding: 20px 25px;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 600;
        color: var(--text-color);
        transition: background-color 0.3s;
        font-size: 16px;
    }
    
    .faq-question:hover {
        background-color: #f8f9fa;
    }
    
    .faq-question i {
        color: var(--primary-color);
        transition: transform 0.3s;
        font-size: 14px;
    }
    
    .faq-item.active .faq-question i {
        transform: rotate(180deg);
    }
    
    .faq-answer {
        padding: 0 25px 20px;
        color: #666;
        line-height: 1.8;
        display: none;
        font-size: 15px;
    }
    
    .faq-item.active .faq-answer {
        display: block;
        animation: fadeIn 0.5s ease-out;
    }
    
    .faq-answer a {
        color: var(--primary-color);
        text-decoration: none;
    }
    
    .faq-answer a:hover {
        text-decoration: underline;
    }
    
    .faq-answer p {
        margin-bottom: 10px;
    }
    
    .faq-answer p:last-child {
        margin-bottom: 0;
    }
    
    .faq-answer strong {
        color: var(--text-color);
    }
    
    /* Contact Support Section */
    .support-section {
        background: #f8f9fa;
        padding: 60px 0;
        margin-top: 40px;
        text-align: center;
    }
    
    .support-content {
        max-width: 700px;
        margin: 0 auto;
    }
    
    .support-title {
        font-size: 28px;
        margin-bottom: 15px;
        color: var(--text-color);
    }
    
    .support-text {
        color: #666;
        margin-bottom: 30px;
        line-height: 1.8;
        font-size: 16px;
    }
    
    .support-btn {
        display: inline-block;
        padding: 15px 40px;
        background: var(--primary-color);
        color: white;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s;
    }
    
    .support-btn:hover {
        background: var(--primary-hover);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(1,123,254,0.3);
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .faq-header {
            padding: 60px 0;
        }
        
        .faq-title {
            font-size: 36px;
        }
        
        .faq-grid {
            grid-template-columns: 1fr;
            gap: 20px;
            padding: 0 20px;
        }
        
        .faq-question {
            padding: 15px 20px;
            font-size: 15px;
        }
        
        .faq-answer {
            padding: 0 20px 15px;
            font-size: 14px;
        }
        
        .support-title {
            font-size: 24px;
        }
        
        .support-btn {
            padding: 12px 30px;
        }
    }
</style>
@endpush

@section('content')
    <!-- FAQ Header -->
    <section class="faq-header">
        <div class="container">
            <h1 class="faq-title">FAQs</h1>
            <p class="faq-subtitle">Your questions, answered simply</p>
        </div>
    </section>
    
    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="container">
            <div class="faq-description">
                Explore clear answers about courses, payments, subscriptions, and digital services. Need more help? Contact our support team anytime.
            </div>
            
            <div class="faq-grid">
                <!-- Left Column -->
                <div class="faq-column">
                    @foreach($faqColumns['left'] as $index => $faq)
                        <div class="faq-item {{ isset($faq['open']) && $faq['open'] ? 'active' : '' }}" data-index="left-{{ $index }}">
                            <div class="faq-question">
                                <span>{{ $faq['question'] }}</span>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                            <div class="faq-answer">
                                {!! $faq['answer'] !!}
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Right Column -->
                <div class="faq-column">
                    @foreach($faqColumns['right'] as $index => $faq)
                        <div class="faq-item" data-index="right-{{ $index }}">
                            <div class="faq-question">
                                <span>{{ $faq['question'] }}</span>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                            <div class="faq-answer">
                                {!! $faq['answer'] !!}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    
    <!-- Contact Support Section -->
    <section class="support-section">
        <div class="container">
            <div class="support-content">
                <h2 class="support-title">Still have questions?</h2>
                <p class="support-text">
                    Can't find the answer you're looking for? Our support team is here to help you with any questions about courses, payments, or technical issues.
                </p>
                <a href="{{ route('contact') }}" class="support-btn">
                    <i class="fas fa-envelope"></i> Contact Support
                </a>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get all FAQ items
        const faqItems = document.querySelectorAll('.faq-item');
        
        // Add click event to each FAQ question
        faqItems.forEach(item => {
            const question = item.querySelector('.faq-question');
            
            question.addEventListener('click', () => {
                // Toggle active class on clicked item
                item.classList.toggle('active');
                
                // Optional: Close other items in the same column
                // Uncomment the following code if you want only one item open per column
                
                /*
                const column = item.closest('.faq-column');
                const otherItems = column.querySelectorAll('.faq-item:not([data-index="' + item.dataset.index + '"])');
                
                otherItems.forEach(otherItem => {
                    otherItem.classList.remove('active');
                });
                */
            });
        });
        
        // Optional: Add animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);
        
        // Apply initial styles and observe FAQ items
        faqItems.forEach(item => {
            item.style.opacity = '0';
            item.style.transform = 'translateY(20px)';
            item.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            observer.observe(item);
        });
    });
</script>
@endpush