@extends('layouts.main')

@section('title', 'Academy - EDUCONECX')

@push('styles')
<style>
    .academy-hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 80px 0;
        text-align: center;
    }
    
    .academy-title {
        font-size: 48px;
        margin-bottom: 20px;
    }
    
    .academy-subtitle {
        font-size: 20px;
        opacity: 0.9;
        max-width: 600px;
        margin: 0 auto;
    }
    
    .academy-categories {
        padding: 60px 0;
    }
    
    .category-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
    }
    
    .category-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        transition: all 0.3s;
    }
    
    .category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.15);
    }
    
    .category-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }
    
    .category-content {
        padding: 25px;
    }
    
    .category-name {
        font-size: 14px;
        color: var(--primary-color);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 10px;
    }
    
    .category-title {
        font-size: 24px;
        margin-bottom: 15px;
    }
    
    .category-description {
        color: #666;
        line-height: 1.6;
        margin-bottom: 20px;
    }
    
    .category-link {
        color: var(--primary-color);
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    
    .category-link:hover {
        gap: 10px;
    }
    
    @media (max-width: 768px) {
        .academy-title {
            font-size: 36px;
        }
    }
</style>
@endpush

@section('content')
    <!-- Hero Section -->
    <section class="academy-hero animate-on-scroll">
        <div class="container">
            <h1 class="academy-title">EDUCONECX Academy</h1>
            <p class="academy-subtitle">Practical online courses in English, finance, business, and technology.</p>
        </div>
    </section>
    
    <!-- Categories Section -->
    <section class="academy-categories">
        <div class="container">
            <div class="category-grid">
                <!-- Business Essentials -->
                <div class="category-card animate-on-scroll">
                    <img src="https://via.placeholder.com/400x200" alt="Business Essentials" class="category-image">
                    <div class="category-content">
                        <div class="category-name">Academy</div>
                        <h2 class="category-title">📊 Business Essentials</h2>
                        <p class="category-description">Learn the core principles of business, from entrepreneurship and management to strategy and leadership, designed to help you succeed in today's competitive world.</p>
                        <a href="{{ route('courses') }}" class="category-link">
                            View Courses <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Finance Made Simple -->
                <div class="category-card animate-on-scroll" style="animation-delay: 0.2s;">
                    <img src="https://via.placeholder.com/400x200" alt="Finance Made Simple" class="category-image">
                    <div class="category-content">
                        <div class="category-name">Academy</div>
                        <h2 class="category-title">💰 Finance Made Simple</h2>
                        <p class="category-description">Understand money management, investments, and financial planning. This course helps you make smarter financial decisions for personal and professional growth.</p>
                        <a href="{{ route('courses') }}" class="category-link">
                            View Courses <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                
                <!-- English for Everyone -->
                <div class="category-card animate-on-scroll" style="animation-delay: 0.4s;">
                    <img src="https://via.placeholder.com/400x200" alt="English for Everyone" class="category-image">
                    <div class="category-content">
                        <div class="category-name">Academy</div>
                        <h2 class="category-title">📘 English for Everyone</h2>
                        <p class="category-description">Build strong communication skills with practical English lessons. Improve your speaking, writing, and comprehension for everyday use, academics, and the workplace.</p>
                        <a href="{{ route('courses') }}" class="category-link">
                            View Courses <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Technology & Innovation -->
                <div class="category-card animate-on-scroll" style="animation-delay: 0.6s;">
                    <img src="https://via.placeholder.com/400x200" alt="Technology & Innovation" class="category-image">
                    <div class="category-content">
                        <div class="category-name">Academy</div>
                        <h2 class="category-title">💻 Technology & Innovation</h2>
                        <p class="category-description">Discover the latest in digital tools, software, and emerging technologies. Gain hands-on knowledge to stay ahead in the fast-changing tech landscape.</p>
                        <a href="{{ route('courses') }}" class="category-link">
                            View Courses <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection