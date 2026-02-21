@extends('layouts.main')

@section('title', 'Refund Policy - EDUCONECX')

@section('meta_description', 'Read our Refund Policy to understand the terms and conditions regarding refunds, cancellations, and billing for EDUCONECX services.')

@push('styles')
<style>
    /* Refund Policy Header */
    .refund-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 80px 0;
        text-align: center;
        margin-bottom: 60px;
    }
    
    .refund-title {
        font-size: 48px;
        margin-bottom: 20px;
        animation: slideUp 0.8s ease-out;
    }
    
    .refund-subtitle {
        font-size: 18px;
        opacity: 0.9;
        max-width: 700px;
        margin: 0 auto;
        line-height: 1.6;
        animation: slideUp 0.8s ease-out 0.2s both;
    }
    
    /* Refund Content */
    .refund-section {
        padding: 0 0 80px;
    }
    
    .refund-container {
        max-width: 900px;
        margin: 0 auto;
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        padding: 50px;
    }
    
    .last-updated {
        text-align: right;
        color: #999;
        font-size: 14px;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }
    
    .policy-article {
        margin-bottom: 40px;
    }
    
    .article-number {
        font-size: 18px;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 10px;
        display: block;
    }
    
    .article-title {
        font-size: 24px;
        font-weight: 700;
        color: var(--text-color);
        margin-bottom: 20px;
        border-bottom: 2px solid var(--primary-color);
        padding-bottom: 5px;
        display: inline-block;
    }
    
    .article-content {
        color: #444;
        line-height: 1.8;
        margin-bottom: 15px;
        font-size: 16px;
    }
    
    .article-list {
        margin: 15px 0 15px 20px;
        padding-left: 20px;
    }
    
    .article-list li {
        margin-bottom: 10px;
        color: #555;
        line-height: 1.6;
        list-style-type: disc;
    }
    
    .article-list li strong {
        color: var(--text-color);
    }
    
    .article-subsection {
        margin-left: 20px;
        margin-top: 15px;
        margin-bottom: 15px;
        padding-left: 15px;
        border-left: 3px solid var(--primary-color);
    }
    
    .article-subsection p {
        color: #555;
        line-height: 1.7;
        margin-bottom: 10px;
    }
    
    .contact-info {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 25px;
        margin: 30px 0 20px;
        border-left: 4px solid var(--primary-color);
    }
    
    .contact-info p {
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .contact-info i {
        color: var(--primary-color);
        width: 24px;
        font-size: 18px;
    }
    
    .contact-info a {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
    }
    
    .contact-info a:hover {
        text-decoration: underline;
    }
    
    .business-hours {
        font-size: 14px;
        color: #666;
        margin-top: 5px;
        margin-left: 34px;
    }
    
    .highlight-box {
        background: #f0f7ff;
        border: 1px solid #cce5ff;
        border-radius: 8px;
        padding: 20px;
        margin: 20px 0;
    }
    
    .highlight-box p {
        color: #004085;
    }
    
    .note-box {
        background: #fff3cd;
        border: 1px solid #ffeeba;
        border-radius: 8px;
        padding: 15px;
        margin: 20px 0;
        color: #856404;
    }
    
    .note-box p {
        margin-bottom: 5px;
    }
    
    .note-box p:last-child {
        margin-bottom: 0;
    }
    
    hr {
        margin: 40px 0;
        border: none;
        border-top: 1px solid #eee;
    }
    
    /* Table of Contents */
    .toc {
        background: #f8f9fa;
        padding: 25px;
        border-radius: 10px;
        margin-bottom: 40px;
    }
    
    .toc-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 15px;
        color: var(--text-color);
    }
    
    .toc-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 10px;
    }
    
    .toc-list li {
        margin-bottom: 5px;
    }
    
    .toc-list a {
        color: var(--primary-color);
        text-decoration: none;
        font-size: 14px;
        transition: color 0.3s;
        display: block;
        padding: 5px 0;
    }
    
    .toc-list a:hover {
        color: var(--primary-hover);
        text-decoration: underline;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .refund-header {
            padding: 60px 0;
        }
        
        .refund-title {
            font-size: 36px;
        }
        
        .refund-container {
            padding: 30px 20px;
            margin: 0 15px;
        }
        
        .article-title {
            font-size: 20px;
        }
        
        .toc-list {
            grid-template-columns: 1fr;
        }
        
        .article-content {
            font-size: 15px;
        }
        
        .contact-info p {
            flex-wrap: wrap;
        }
    }
</style>
@endpush

@section('content')
    <!-- Refund Policy Header -->
    <section class="refund-header">
        <div class="container">
            <h1 class="refund-title">Refund Policy</h1>
            <p class="refund-subtitle">Understanding your rights and our policies regarding payments, subscriptions, and refunds</p>
        </div>
    </section>
    
    <!-- Refund Content -->
    <section class="refund-section">
        <div class="container">
            <div class="refund-container">
                <div class="last-updated">
                    Last Updated: December 1, 2025
                </div>
                
                <!-- Table of Contents -->
                <div class="toc">
                    <div class="toc-title">Quick Navigation</div>
                    <ul class="toc-list">
                        <li><a href="#article1">Article 1 — Introduction</a></li>
                        <li><a href="#article2">Article 2 — All Sales Are Final (No Refund Policy)</a></li>
                        <li><a href="#article3">Article 3 — Subscription Billing & Cancellation</a></li>
                        <li><a href="#article4">Article 4 — Consumer Protection Compliance</a></li>
                        <li><a href="#article5">Article 5 — Governing Law</a></li>
                        <li><a href="#article6">Article 6 — Contact Information</a></li>
                    </ul>
                </div>
                
                <!-- Article 1 -->
                <div id="article1" class="policy-article">
                    <span class="article-number">Article 1</span>
                    <h2 class="article-title">Introduction</h2>
                    
                    <p class="article-content">1.1 This Refund Policy forms a legally binding part of the Terms & Conditions governing your use of the EDUCONEXC LLC platform ("we", "us", "our").</p>
                    
                    <p class="article-content">1.2 By creating an account, subscribing, accessing, or using any digital content on our platform, you acknowledge and agree to be bound by this Refund Policy.</p>
                    
                    <p class="article-content">1.3 EDUCONEXC provides digital educational content and subscription-based online learning services.</p>
                </div>
                
                <!-- Article 2 -->
                <div id="article2" class="policy-article">
                    <span class="article-number">Article 2</span>
                    <h2 class="article-title">All Sales Are Final (No Refund Policy)</h2>
                    
                    <p class="article-content">2.1 Due to the immediate delivery of digital content, all purchases, subscriptions, and payments made on EDUCONEXC are final and non-refundable.</p>
                    
                    <p class="article-content">2.2 This applies to all plans, digital services, online courses, memberships, and educational materials offered on the platform.</p>
                    
                    <p class="article-content">2.3 In accordance with U.S. Federal Trade Commission (FTC) guidelines, Florida consumer protection laws, and EU Directive 2019/770, digital content accessed or activated is not eligible for refunds.</p>
                    
                    <div class="highlight-box">
                        <p><strong>Important:</strong> Digital content that has been accessed or downloaded is not eligible for refunds under applicable consumer protection laws.</p>
                    </div>
                    
                    <p class="article-content">2.4 Dissatisfaction, non-use of content, change of mind, or personal circumstances do not qualify for refunds.</p>
                    
                    <div class="note-box">
                        <p><strong>Note:</strong> We encourage you to take advantage of our free trial options before committing to a paid subscription.</p>
                    </div>
                </div>
                
                <!-- Article 3 -->
                <div id="article3" class="policy-article">
                    <span class="article-number">Article 3</span>
                    <h2 class="article-title">Subscription Billing & Cancellation</h2>
                    
                    <p class="article-content">3.1 Subscriptions renew automatically based on the billing cycle selected at checkout.</p>
                    
                    <p class="article-content">3.2 Users may cancel at any time to stop future charges.</p>
                    
                    <p class="article-content">3.3 Cancellation does not generate refunds for previous or current billing periods.</p>
                    
                    <p class="article-content">3.4 Access to digital content continues until the end of the paid billing cycle.</p>
                    
                    <div class="article-subsection">
                        <p><strong>How to Cancel:</strong></p>
                        <ul class="article-list">
                            <li>Log in to your account</li>
                            <li>Navigate to "Account Settings" or "Subscription"</li>
                            <li>Select "Cancel Subscription"</li>
                            <li>Follow the confirmation prompts</li>
                        </ul>
                    </div>
                    
                    <p class="article-content">3.5 These disclosures comply with FTC subscription regulations and Florida automatic renewal laws.</p>
                </div>
                
                <!-- Article 4 -->
                <div id="article4" class="policy-article">
                    <span class="article-number">Article 4</span>
                    <h2 class="article-title">Consumer Protection Compliance</h2>
                    
                    <p class="article-content">4.1 EDUCONEXC complies with all applicable U.S. consumer protection requirements, including:</p>
                    
                    <ul class="article-list">
                        <li><strong>FTC Clear & Conspicuous Disclosure Standards</strong> — Ensuring all terms are clearly communicated before purchase</li>
                        <li><strong>FTC Subscription Rule ("Negative Option Rule")</strong> — Providing clear cancellation methods and renewal disclosures</li>
                        <li><strong>Florida Statutes Chapter 501</strong> — Complying with Florida's consumer protection laws</li>
                    </ul>
                    
                    <p class="article-content">4.2 For EU users, this policy incorporates the EU Digital Content Directive (2019/770), which allows users to waive withdrawal rights upon accessing digital content.</p>
                    
                    <div class="highlight-box">
                        <p><strong>EU Consumer Rights:</strong> Under the EU Digital Content Directive, when you access digital content immediately, you explicitly agree that you lose your right of withdrawal.</p>
                    </div>
                    
                    <p class="article-content">4.3 These laws require clear disclosure, not refund mandates, for digital goods.</p>
                </div>
                
                <!-- Article 5 -->
                <div id="article5" class="policy-article">
                    <span class="article-number">Article 5</span>
                    <h2 class="article-title">Governing Law</h2>
                    
                    <p class="article-content">5.1 This Refund Policy is governed by the laws of the State of Florida, United States, without regard to conflict-of-law principles.</p>
                    
                    <p class="article-content">5.2 Any dispute arising from this policy or services provided by EDUCONEXC shall fall under Florida jurisdiction.</p>
                </div>
                
                <!-- Article 6 -->
                <div id="article6" class="policy-article">
                    <span class="article-number">Article 6</span>
                    <h2 class="article-title">Contact Information (Email Only)</h2>
                    
                    <p class="article-content">For questions regarding this Refund Policy (not refund requests), please contact:</p>
                    
                    <div class="contact-info">
                        <p>
                            <i class="fas fa-envelope"></i>
                            <a href="mailto:support@educonecx.com">support@educonecx.com</a>
                        </p>
                        <div class="business-hours">
                            Business Hours: Monday–Friday, 9:00 AM – 5:00 PM EST
                        </div>
                    </div>
                    
                    <p class="article-content"><em>Note: This email is for policy questions only. For technical support, please use the contact form on our website.</em></p>
                </div>
                
                <hr>
                
                <!-- Summary Box -->
                <div class="highlight-box" style="margin-top: 30px;">
                    <p><strong>Policy Summary:</strong></p>
                    <ul class="article-list" style="margin-top: 10px;">
                        <li>All sales are final for digital content</li>
                        <li>Subscriptions can be canceled anytime to stop future charges</li>
                        <li>No refunds for past billing periods</li>
                        <li>Access continues until the end of your paid billing cycle</li>
                        <li>Compliant with FTC, Florida law, and EU Digital Content Directive</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Smooth scroll for table of contents links
        document.querySelectorAll('.toc-list a').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                
                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
        
        // Add active state to TOC links on scroll
        const sections = document.querySelectorAll('.policy-article');
        const tocLinks = document.querySelectorAll('.toc-list a');
        
        window.addEventListener('scroll', () => {
            let current = '';
            
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                
                if (pageYOffset >= sectionTop - 200) {
                    current = section.getAttribute('id');
                }
            });
            
            tocLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === '#' + current) {
                    link.classList.add('active');
                }
            });
        });
    });
</script>
@endpush