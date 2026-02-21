@extends('layouts.main')

@section('title', 'Contact - EDUCONECX')

@section('meta_description', 'Get in touch with EDUCONECX. Have questions about our courses, partnerships, or anything else? Our team is here to help.')

@push('styles')
<style>
    /* Contact Header */
    .contact-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 80px 0;
        text-align: center;
        margin-bottom: 60px;
    }
    
    .contact-title {
        font-size: 48px;
        margin-bottom: 20px;
        animation: slideUp 0.8s ease-out;
    }
    
    .contact-subtitle {
        font-size: 18px;
        opacity: 0.9;
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.6;
        animation: slideUp 0.8s ease-out 0.2s both;
    }
    
    /* Contact Section */
    .contact-section {
        padding: 0 0 80px;
    }
    
    .contact-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 50px;
        max-width: 1200px;
        margin: 0 auto;
    }
    
    /* Contact Info */
    .contact-info {
        background: white;
        border-radius: 15px;
        padding: 40px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        animation: slideInLeft 0.8s ease-out;
    }
    
    .info-title {
        font-size: 32px;
        margin-bottom: 15px;
        color: var(--text-color);
    }
    
    .info-subtitle {
        font-size: 20px;
        color: var(--primary-color);
        margin-bottom: 25px;
        font-weight: 600;
    }
    
    .info-description {
        color: #666;
        line-height: 1.8;
        margin-bottom: 30px;
    }
    
    .info-list {
        list-style: none;
        padding: 0;
        margin-bottom: 30px;
    }
    
    .info-list li {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
        color: #555;
        font-size: 16px;
    }
    
    .info-list li i {
        width: 24px;
        color: var(--primary-color);
        font-size: 18px;
    }
    
    .info-list li a {
        color: #555;
        text-decoration: none;
        transition: color 0.3s;
    }
    
    .info-list li a:hover {
        color: var(--primary-color);
    }
    
    .info-highlights {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 25px;
        margin-top: 30px;
    }
    
    .info-highlights h4 {
        font-size: 18px;
        margin-bottom: 15px;
        color: var(--text-color);
    }
    
    .info-highlights ul {
        list-style: none;
        padding: 0;
    }
    
    .info-highlights li {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 12px;
        color: #555;
    }
    
    .info-highlights li i {
        color: var(--primary-color);
        font-size: 14px;
    }
    
    /* Contact Form */
    .contact-form-container {
        background: white;
        border-radius: 15px;
        padding: 40px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        animation: slideInRight 0.8s ease-out;
    }
    
    .form-title {
        font-size: 24px;
        margin-bottom: 30px;
        color: var(--text-color);
        text-align: center;
    }
    
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: var(--text-color);
    }
    
    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 16px;
        transition: all 0.3s;
    }
    
    .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(1,123,254,0.1);
    }
    
    textarea.form-control {
        resize: vertical;
        min-height: 120px;
    }
    
    .submit-btn {
        background: var(--primary-color);
        color: white;
        border: none;
        padding: 15px 40px;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        width: 100%;
    }
    
    .submit-btn:hover {
        background: var(--primary-hover);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(1,123,254,0.3);
    }
    
    /* Success Message */
    .alert-success {
        background: #d4edda;
        color: #155724;
        padding: 15px 20px;
        border-radius: 8px;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 10px;
        animation: slideUp 0.5s ease-out;
    }
    
    .alert-success i {
        font-size: 20px;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .contact-header {
            padding: 60px 0;
        }
        
        .contact-title {
            font-size: 36px;
        }
        
        .contact-grid {
            grid-template-columns: 1fr;
            gap: 30px;
            padding: 0 20px;
        }
        
        .contact-info,
        .contact-form-container {
            padding: 30px;
        }
        
        .form-row {
            grid-template-columns: 1fr;
            gap: 0;
        }
        
        .info-title {
            font-size: 28px;
        }
        
        .info-subtitle {
            font-size: 18px;
        }
    }
</style>
@endpush

@section('content')
    <!-- Contact Header -->
    <section class="contact-header">
        <div class="container">
            <h1 class="contact-title">Contact</h1>
            <p class="contact-subtitle">Got business questions? We're here to help you with any inquiries about our courses, partnerships, or services.</p>
        </div>
    </section>
    
    <!-- Contact Section -->
    <section class="contact-section">
        <div class="container">
            <!-- Success Message -->
            @if(session('success'))
                <div class="alert-success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif
            
            <div class="contact-grid">
                <!-- Contact Information -->
                <div class="contact-info">
                    <h2 class="info-title">Get in Touch</h2>
                    <div class="info-subtitle">We'd love to hear from you</div>
                    
                    <p class="info-description">
                        Whether you have questions about our courses, want to discuss partnership opportunities, or need technical support, our team is ready to assist you.
                    </p>
                    
                    <ul class="info-list">
                        <li>
                            <i class="fas fa-phone-alt"></i>
                            <a href="tel:+18335338228">+1 (833) 533-8228</a>
                        </li>
                        <li>
                            <i class="far fa-envelope-open"></i>
                            <a href="mailto:contact@educonecx.com">contact@educonecx.com</a>
                        </li>
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            <span>1200 Brickell Ave, Miami, FL 33131, USA</span>
                        </li>
                    </ul>
                    
                    <div class="info-highlights">
                        <h4>What you can learn:</h4>
                        <ul>
                            <li><i class="fas fa-check"></i> About our course offerings and pricing</li>
                            <li><i class="fas fa-check"></i> Partnership and collaboration opportunities</li>
                            <li><i class="fas fa-check"></i> Technical support and troubleshooting</li>
                            <li><i class="fas fa-check"></i> Billing and subscription questions</li>
                            <li><i class="fas fa-check"></i> Schedule a demo or consultation</li>
                        </ul>
                    </div>
                </div>
                
                <!-- Contact Form -->
                <div class="contact-form-container">
                    <h2 class="form-title">Send us a Message</h2>
                    
                    <form action="{{ route('contact.submit') }}" method="POST">
                        @csrf
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="first_name" class="form-label">First name *</label>
                                <input 
                                    type="text" 
                                    class="form-control @error('first_name') is-invalid @enderror" 
                                    id="first_name" 
                                    name="first_name" 
                                    placeholder="Type your first name"
                                    value="{{ old('first_name') }}"
                                    required
                                >
                                @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="last_name" class="form-label">Last name *</label>
                                <input 
                                    type="text" 
                                    class="form-control @error('last_name') is-invalid @enderror" 
                                    id="last_name" 
                                    name="last_name" 
                                    placeholder="Type your last name"
                                    value="{{ old('last_name') }}"
                                    required
                                >
                                @error('last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="email" class="form-label">Email Address *</label>
                            <input 
                                type="email" 
                                class="form-control @error('email') is-invalid @enderror" 
                                id="email" 
                                name="email" 
                                placeholder="your@gmail.com"
                                value="{{ old('email') }}"
                                required
                            >
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="message" class="form-label">Message</label>
                            <textarea 
                                class="form-control @error('message') is-invalid @enderror" 
                                id="message" 
                                name="message" 
                                rows="4" 
                                placeholder="Your message here..."
                            >{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <button type="submit" class="submit-btn">
                            Submit
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    // Optional: Add any contact page specific JavaScript here
    // For example, form validation enhancements or map integration
</script>
@endpush