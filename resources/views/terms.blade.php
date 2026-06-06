@extends('layouts.main')

@section('title', 'Terms & Conditions - EDUCONECX')

@section('meta_description', 'Read our Terms & Conditions governing your use of the EDUCONECX platform, including disclaimers, user agreements, and legal information.')

@push('styles')
<style>
    /* Root Variables - Your Beautiful Colors */
    :root {
        --bright-amber: #FBC60C;
        --khaki-beige: #9F9A87;
        --pure-white: #FEFDFE;
        --prussian-blue: #0A1D44;
        --regal-navy: #18386E;
        --sky-blue: #5AD1E4;
        --pale-slate: #CBD1DA;
        --dark-slate: #2E5C61;
        --ivory: #F9F7E9;
        --light-gold: #EBD789;
        
        /* Extended Palette */
        --primary: var(--regal-navy);
        --primary-dark: var(--prussian-blue);
        --primary-light: var(--dark-slate);
        --secondary: var(--sky-blue);
        --accent: var(--bright-amber);
        --accent-soft: var(--light-gold);
        --success: var(--sky-blue);
        --warning: var(--bright-amber);
        
        /* Text Colors */
        --text-primary: #0A1D44;
        --text-secondary: #2E5C61;
        --text-muted: #5f5f5f;
        --text-light: #FEFDFE;
        
        /* Gradients */
        --gradient-1: linear-gradient(135deg, #0A1D44 0%, #18386E 50%, #2E5C61 100%);
        --gradient-2: linear-gradient(45deg, #FBC60C 0%, #EBD789 50%, #F9F7E9 100%);
        --gradient-3: linear-gradient(135deg, #5AD1E4 0%, #CBD1DA 50%, #FEFDFE 100%);
        
        /* Shadows */
        --shadow-sm: 0 2px 8px rgba(10, 29, 68, 0.08);
        --shadow-md: 0 4px 12px rgba(10, 29, 68, 0.12);
        --shadow-lg: 0 8px 24px rgba(10, 29, 68, 0.15);
        --shadow-hover: 0 12px 28px rgba(251, 198, 12, 0.2);
        
        /* Border Radius */
        --radius-sm: 8px;
        --radius-md: 12px;
        --radius-lg: 16px;
        --radius-xl: 24px;
        --radius-full: 9999px;
        
        /* Transitions */
        --transition: all 0.3s ease;
    }

    /* Terms Header */
    .terms-header {
        background: var(--gradient-1);
        color: var(--pure-white);
        padding: 80px 0;
        text-align: center;
        margin-bottom: 60px;
        position: relative;
        overflow: hidden;
    }

    .terms-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: rgba(251, 198, 12, 0.1);
        border-radius: 50%;
        animation: float 10s ease-in-out infinite;
    }

    .terms-header::after {
        content: '';
        position: absolute;
        bottom: -50%;
        left: -10%;
        width: 300px;
        height: 300px;
        background: rgba(90, 209, 228, 0.1);
        border-radius: 50%;
        animation: float 8s ease-in-out infinite reverse;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }

    .terms-header .container {
        position: relative;
        z-index: 2;
    }
    
    .terms-title {
        font-size: clamp(2.5rem, 6vw, 3.5rem);
        font-weight: 800;
        margin-bottom: 20px;
        animation: slideUp 0.8s ease-out;
        color: var(--pure-white);
    }

    .terms-title span {
        color: var(--bright-amber);
    }
    
    .terms-subtitle {
        font-size: clamp(1rem, 3vw, 1.2rem);
        opacity: 0.95;
        max-width: 700px;
        margin: 0 auto;
        line-height: 1.6;
        animation: slideUp 0.8s ease-out 0.2s both;
        color: var(--ivory);
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Terms Content */
    .terms-section {
        padding: 0 0 80px;
    }
    
    .terms-container {
        max-width: 900px;
        margin: 0 auto;
        background: var(--pure-white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-lg);
        padding: 50px;
        border: 1px solid rgba(251, 198, 12, 0.1);
    }
    
    .last-updated {
        text-align: right;
        color: var(--text-muted);
        font-size: 0.9rem;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid rgba(251, 198, 12, 0.2);
    }
    
    /* Disclaimer Box */
    .disclaimer-box {
        background: rgba(251, 198, 12, 0.05);
        border: 1px solid rgba(251, 198, 12, 0.3);
        border-radius: var(--radius-md);
        padding: 30px;
        margin-bottom: 40px;
        border-left: 4px solid var(--bright-amber);
    }
    
    .disclaimer-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--prussian-blue);
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .disclaimer-title i {
        color: var(--bright-amber);
        font-size: 1.5rem;
    }
    
    .disclaimer-text {
        color: var(--text-secondary);
        line-height: 1.8;
        margin-bottom: 15px;
    }
    
    .disclaimer-text:last-child {
        margin-bottom: 0;
    }

    .disclaimer-text strong {
        color: var(--prussian-blue);
    }
    
    .disclaimer-list {
        margin: 15px 0 15px 20px;
        color: var(--text-secondary);
    }
    
    .disclaimer-list li {
        margin-bottom: 8px;
        line-height: 1.6;
    }
    
    /* Terms Sections */
    .terms-article {
        margin-bottom: 40px;
        scroll-margin-top: 100px;
    }
    
    .article-number {
        font-size: 1rem;
        font-weight: 700;
        color: var(--bright-amber);
        margin-bottom: 5px;
        display: block;
    }
    
    .article-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 20px;
        border-bottom: 2px solid var(--gradient-2);
        padding-bottom: 8px;
        display: inline-block;
    }
    
    .article-content {
        color: var(--text-muted);
        line-height: 1.8;
        margin-bottom: 15px;
        font-size: 1rem;
    }
    
    .article-list {
        margin: 15px 0 15px 20px;
        padding-left: 20px;
    }
    
    .article-list li {
        margin-bottom: 10px;
        color: var(--text-muted);
        line-height: 1.7;
        list-style-type: disc;
    }
    
    .article-list li strong {
        color: var(--text-primary);
    }
    
    .article-subsection {
        margin-left: 20px;
        margin-top: 15px;
        margin-bottom: 15px;
        padding-left: 15px;
        border-left: 3px solid var(--gradient-2);
    }
    
    .article-subsection p {
        color: var(--text-muted);
        line-height: 1.7;
        margin-bottom: 10px;
    }
    
    .highlight-box {
        background: rgba(90, 209, 228, 0.05);
        border: 1px solid rgba(90, 209, 228, 0.3);
        border-radius: var(--radius-md);
        padding: 20px;
        margin: 20px 0;
        border-left: 4px solid var(--sky-blue);
    }
    
    .highlight-box p {
        color: var(--text-secondary);
    }
    
    .note-box {
        background: var(--ivory);
        border-left: 4px solid var(--bright-amber);
        border-radius: var(--radius-md);
        padding: 20px 25px;
        margin: 20px 0;
    }
    
    .note-box p {
        margin-bottom: 5px;
        color: var(--text-secondary);
    }
    
    .note-box p:last-child {
        margin-bottom: 0;
    }

    .note-box a {
        color: var(--bright-amber);
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
    }

    .note-box a:hover {
        color: var(--prussian-blue);
        text-decoration: underline;
    }
    
    hr {
        margin: 40px 0;
        border: none;
        border-top: 2px solid var(--gradient-2);
        opacity: 0.3;
    }
    
    /* Table of Contents */
    .toc {
        background: var(--ivory);
        padding: 25px;
        border-radius: var(--radius-md);
        margin-bottom: 40px;
        border: 1px solid rgba(251, 198, 12, 0.2);
    }
    
    .toc-title {
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 20px;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .toc-title i {
        color: var(--bright-amber);
        font-size: 1.3rem;
    }
    
    .toc-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 8px 15px;
    }
    
    .toc-list li {
        margin-bottom: 5px;
    }
    
    .toc-list a {
        color: var(--text-secondary);
        text-decoration: none;
        font-size: 0.9rem;
        transition: var(--transition);
        display: block;
        padding: 6px 10px;
        border-radius: var(--radius-sm);
        border-left: 2px solid transparent;
    }
    
    .toc-list a:hover {
        color: var(--bright-amber);
        background: rgba(251, 198, 12, 0.05);
        border-left-color: var(--bright-amber);
        padding-left: 15px;
    }

    .toc-list a.active {
        color: var(--bright-amber);
        background: rgba(251, 198, 12, 0.05);
        border-left-color: var(--bright-amber);
        font-weight: 600;
    }
    
    /* Responsive */
    @media (max-width: 992px) {
        .terms-header {
            padding: 60px 0;
        }
        
        .terms-container {
            padding: 40px 30px;
            margin: 0 20px;
        }
        
        .toc-list {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .terms-header {
            padding: 50px 0;
            margin-bottom: 40px;
        }
        
        .terms-container {
            padding: 30px 20px;
            margin: 0 15px;
        }
        
        .article-title {
            font-size: 1.3rem;
        }
        
        .toc-list {
            grid-template-columns: 1fr;
        }
        
        .article-content {
            font-size: 0.95rem;
        }
        
        .disclaimer-box {
            padding: 20px;
        }
        
        .disclaimer-title {
            font-size: 1.1rem;
        }

        .toc {
            padding: 20px;
        }
    }

    @media (max-width: 576px) {
        .terms-header {
            padding: 40px 0;
        }

        .terms-title {
            font-size: 2rem;
        }

        .terms-container {
            padding: 25px 15px;
            margin: 0 10px;
        }

        .last-updated {
            font-size: 0.8rem;
            margin-bottom: 20px;
        }

        .article-title {
            font-size: 1.2rem;
        }

        .article-list {
            margin-left: 10px;
            padding-left: 15px;
        }

        .article-list li {
            font-size: 0.9rem;
        }

        .note-box {
            padding: 15px 20px;
        }

        .toc-list a {
            font-size: 0.85rem;
            padding: 8px 10px;
        }
    }

    /* Print Styles */
    @media print {
        .terms-header {
            background: none;
            color: black;
            padding: 20px 0;
        }

        .terms-header::before,
        .terms-header::after {
            display: none;
        }

        .terms-container {
            box-shadow: none;
            border: 1px solid #ddd;
        }

        .toc {
            display: none;
        }
    }
</style>
@endpush

@section('content')
    <!-- Terms Header -->
    <section class="terms-header">
        <div class="container">
            <h1 class="terms-title">Terms & <span>Conditions</span></h1>
            <p class="terms-subtitle">Please read these terms carefully before using our services</p>
        </div>
    </section>
    
    <!-- Terms Content -->
    <section class="terms-section">
        <div class="container">
            <div class="terms-container">
                <div class="last-updated">
                    <i class="far fa-calendar-alt" style="color: var(--bright-amber); margin-right: 5px;"></i>
                    Last Updated: February 7, 2026
                </div>
                
                <!-- Table of Contents -->
                <div class="toc">
                    <div class="toc-title">
                        <i class="fas fa-list-ul"></i>
                        Quick Navigation
                    </div>
                    <ul class="toc-list">
                        <li><a href="#disclaimer">⚠️ Disclaimer – Financial, Freelance, and Educational Training</a></li>
                        <li><a href="#section1">1. Acceptance of Terms</a></li>
                        <li><a href="#section2">2. Description of Services</a></li>
                        <li><a href="#section3">3. User Eligibility and Account Registration</a></li>
                        <li><a href="#section4">4. Acceptable Use</a></li>
                        <li><a href="#section5">5. Payment Terms and Subscriptions</a></li>
                        <li><a href="#section6">6. Refund Policy</a></li>
                        <li><a href="#section7">7. Intellectual Property Rights</a></li>
                        <li><a href="#section8">8. Learning Companion Disclaimer</a></li>
                        <li><a href="#section9">9. User-Generated Content</a></li>
                        <li><a href="#section10">10. Privacy and Data Protection</a></li>
                        <li><a href="#section11">11. Disclaimer of Warranties</a></li>
                        <li><a href="#section12">12. Limitation of Liability</a></li>
                        <li><a href="#section13">13. Indemnification</a></li>
                        <li><a href="#section14">14. International Use and Compliance</a></li>
                        <li><a href="#section15">15. Governing Law and Dispute Resolution</a></li>
                        <li><a href="#section16">16. Modifications to Terms</a></li>
                        <li><a href="#section17">17. Termination</a></li>
                        <li><a href="#section18">18. Entire Agreement</a></li>
                        <li><a href="#section19">19. Severability</a></li>
                    </ul>
                </div>
                
                <!-- Disclaimer Section -->
                <div id="disclaimer" class="disclaimer-box">
                    <h2 class="disclaimer-title">
                        <i class="fas fa-exclamation-triangle"></i>
                        Disclaimer – Financial, Freelance, and Educational Training
                    </h2>
                    
                    <p class="disclaimer-text">All courses, training materials, videos, documents, and educational content provided on this platform are offered strictly for educational and informational purposes only. Nothing contained within any course, including but not limited to training related to finance, cryptocurrencies, investing, trading, business, freelance activities, or any other professional field, should be interpreted as financial, legal, tax, professional, or investment advice.</p>
                    
                    <p class="disclaimer-text">Financial activities, investments, trading, freelance activities, or any commercial initiatives involve risks, including the potential loss of money. The platform, its owners, instructors, partners, and affiliates make no guarantees regarding financial results, income, professional success, employment opportunities, or investment performance.</p>
                    
                    <p class="disclaimer-text">Regarding freelance-related training, users acknowledge that they are responsible for ensuring that their activities comply with the laws, regulations, and tax obligations applicable in their respective country or jurisdiction. The platform shall not be held responsible for any illegal or non-compliant use of the knowledge acquired.</p>
                    
                    <p class="disclaimer-text">By using this platform and accessing the training content, users agree that they are solely responsible for their decisions, actions, and results. The platform shall not be held liable for any direct or indirect loss, damage, or consequence resulting from the use of the educational materials provided.</p>
                    
                    <p class="disclaimer-text"><strong>Users are encouraged to consult licensed financial advisors, legal professionals, or qualified experts before making any financial, professional, or business decisions.</strong></p>
                </div>
                
                <!-- Section 1 -->
                <div id="section1" class="terms-article">
                    <span class="article-number">1.</span>
                    <h2 class="article-title">Acceptance of Terms</h2>
                    <p class="article-content">By accessing or using the EDUCONECX website, platform, or content, you agree to be bound by these Terms & Conditions. If you do not agree, you must discontinue use of the services.</p>
                </div>
                
                <!-- Section 2 -->
                <div id="section2" class="terms-article">
                    <span class="article-number">2.</span>
                    <h2 class="article-title">Description of Services</h2>
                    <p class="article-content">EDUCONECX provides online educational content focused on digital skills, professional development, and personal growth. Our courses, tools, and learning resources are designed to help users progress academically, socially, and economically. Content is offered in multiple languages and may include videos, digital materials, progress tracking, and interactive learning assistance.</p>
                </div>
                
                <!-- Section 3 -->
                <div id="section3" class="terms-article">
                    <span class="article-number">3.</span>
                    <h2 class="article-title">User Eligibility and Account Registration</h2>
                    <p class="article-content">You must be at least 13 years old to use the platform. Users under 18 must have parental consent.</p>
                    <p class="article-content">By creating an account, you agree to:</p>
                    <ul class="article-list">
                        <li>Provide accurate registration information</li>
                        <li>Maintain the confidentiality of your login credentials</li>
                        <li>Be responsible for all activities under your account</li>
                        <li>Notify us immediately of unauthorized use</li>
                    </ul>
                </div>
                
                <!-- Section 4 -->
                <div id="section4" class="terms-article">
                    <span class="article-number">4.</span>
                    <h2 class="article-title">Acceptable Use</h2>
                    <p class="article-content">You may use the services only for lawful purposes. You must not:</p>
                    <ul class="article-list">
                        <li>Violate applicable local, national, or international laws</li>
                        <li>Harass or harm other users</li>
                        <li>Upload malicious code or interfere with platform operations</li>
                        <li>Access, attempt to access, or distribute unauthorized content</li>
                        <li>Impersonate any person or entity</li>
                    </ul>
                </div>
                
                <!-- Section 5 -->
                <div id="section5" class="terms-article">
                    <span class="article-number">5.</span>
                    <h2 class="article-title">Payment Terms and Subscriptions</h2>
                    <ul class="article-list">
                        <li>All payments must be made through approved payment methods</li>
                        <li>Subscriptions renew automatically unless cancelled before the renewal date</li>
                        <li>No partial refunds are provided for unused subscription time</li>
                        <li>Applicable taxes may apply depending on your location</li>
                    </ul>
                </div>
                
                <!-- Section 6 -->
                <div id="section6" class="terms-article">
                    <span class="article-number">6.</span>
                    <h2 class="article-title">Refund Policy</h2>
                    <p class="article-content">Refunds are governed by the separate EDUCONECX Refund Policy.</p>
                    <p class="article-content">Key points:</p>
                    <ul class="article-list">
                        <li>No refunds for subscription payments</li>
                        <li>Refunds may be considered only for qualifying technical issues</li>
                        <li>All refund requests must follow the procedures outlined in the Refund Policy</li>
                    </ul>
                </div>
                
                <!-- Section 7 -->
                <div id="section7" class="terms-article">
                    <span class="article-number">7.</span>
                    <h2 class="article-title">Intellectual Property Rights</h2>
                    <p class="article-content">All content on EDUCONECX is protected by copyright, trademark, and other intellectual property laws. This includes:</p>
                    <ul class="article-list">
                        <li>Video lessons and educational materials</li>
                        <li>Digital files, learning tools, and platform features</li>
                        <li>Logos, branding, and website design</li>
                    </ul>
                    <p class="article-content">You may not copy, redistribute, or create derivative works from any content without permission.</p>
                </div>
                
                <!-- Section 8 -->
                <div id="section8" class="terms-article">
                    <span class="article-number">8.</span>
                    <h2 class="article-title">Learning Companion Disclaimer</h2>
                    <p class="article-content">Interactive learning features on the platform provide general educational support only. Learning guidance is not intended for:</p>
                    <ul class="article-list">
                        <li>Legal, medical, financial, or professional advice</li>
                        <li>Emergency assistance</li>
                        <li>Real-time, high-risk, or time-sensitive decision-making</li>
                    </ul>
                    <p class="article-content">Users are responsible for verifying important information.</p>
                </div>
                
                <!-- Section 9 -->
                <div id="section9" class="terms-article">
                    <span class="article-number">9.</span>
                    <h2 class="article-title">User-Generated Content</h2>
                    <p class="article-content">By submitting content (comments, assignments, uploads), you grant EDUCONECX a license to store, display, and process your content for educational and operational purposes. You retain ownership of your original content.</p>
                </div>
                
                <!-- Section 10 -->
                <div id="section10" class="terms-article">
                    <span class="article-number">10.</span>
                    <h2 class="article-title">Privacy and Data Protection</h2>
                    <p class="article-content">Your use of the platform is subject to the Privacy Policy, which explains how we collect, use, and protect your personal information. By using the services, you consent to the data practices described in the Privacy Policy.</p>
                </div>
                
                <!-- Section 11 -->
                <div id="section11" class="terms-article">
                    <span class="article-number">11.</span>
                    <h2 class="article-title">Disclaimer of Warranties</h2>
                    <p class="article-content">The services are provided "as is" and "as available." EDUCONECX makes no warranties regarding:</p>
                    <ul class="article-list">
                        <li>Accuracy or completeness of content</li>
                        <li>Uninterrupted or error-free service</li>
                        <li>Fitness for a particular purpose</li>
                        <li>Availability or reliability of third-party integrations</li>
                    </ul>
                </div>
                
                <!-- Section 12 -->
                <div id="section12" class="terms-article">
                    <span class="article-number">12.</span>
                    <h2 class="article-title">Limitation of Liability</h2>
                    <p class="article-content">To the maximum extent permitted by law, EDUCONECX shall not be liable for:</p>
                    <ul class="article-list">
                        <li>Indirect, incidental, or consequential damages</li>
                        <li>Loss of data, profits, or opportunities</li>
                        <li>Any damages exceeding the amount paid in the last 12 months</li>
                    </ul>
                </div>
                
                <!-- Section 13 -->
                <div id="section13" class="terms-article">
                    <span class="article-number">13.</span>
                    <h2 class="article-title">Indemnification</h2>
                    <p class="article-content">You agree to indemnify and hold harmless EDUCONECX from claims arising from:</p>
                    <ul class="article-list">
                        <li>Your use of the services</li>
                        <li>Your violation of these Terms</li>
                        <li>Your violation of any third-party rights</li>
                        <li>Your content or activities on the platform</li>
                    </ul>
                </div>
                
                <!-- Section 14 -->
                <div id="section14" class="terms-article">
                    <span class="article-number">14.</span>
                    <h2 class="article-title">International Use and Compliance</h2>
                    <p class="article-content">Users are responsible for complying with local laws regarding online learning, digital content, data use, and payment regulations.</p>
                </div>
                
                <!-- Section 15 -->
                <div id="section15" class="terms-article">
                    <span class="article-number">15.</span>
                    <h2 class="article-title">Governing Law and Dispute Resolution</h2>
                    <p class="article-content">These Terms are governed by the laws of the State of Florida, USA, without regard to conflict-of-law principles. Any disputes shall be resolved in the appropriate state or federal courts located in Miami-Dade County, Florida.</p>
                </div>
                
                <!-- Section 16 -->
                <div id="section16" class="terms-article">
                    <span class="article-number">16.</span>
                    <h2 class="article-title">Modifications to Terms</h2>
                    <p class="article-content">EDUCONECX reserves the right to update these Terms at any time. Changes take effect upon posting. Continued use of the platform after updates constitutes acceptance of the revised Terms.</p>
                </div>
                
                <!-- Section 17 -->
                <div id="section17" class="terms-article">
                    <span class="article-number">17.</span>
                    <h2 class="article-title">Termination</h2>
                    <p class="article-content">You may terminate your account at any time through account settings.</p>
                    <p class="article-content">EDUCONECX may suspend or terminate accounts for:</p>
                    <ul class="article-list">
                        <li>Violation of these Terms</li>
                        <li>Fraudulent or abusive behavior</li>
                        <li>Legal or regulatory requirements</li>
                    </ul>
                    <p class="article-content">Upon termination, access to the services will end immediately.</p>
                </div>
                
                <!-- Section 18 -->
                <div id="section18" class="terms-article">
                    <span class="article-number">18.</span>
                    <h2 class="article-title">Entire Agreement</h2>
                    <p class="article-content">These Terms constitute the complete agreement between you and EDUCONECX regarding the use of the services.</p>
                </div>
                
                <!-- Section 19 -->
                <div id="section19" class="terms-article">
                    <span class="article-number">19.</span>
                    <h2 class="article-title">Severability</h2>
                    <p class="article-content">If any provision is deemed invalid or unenforceable, the remaining provisions remain in effect.</p>
                </div>
                
                <hr>
                
                <!-- Summary Note -->
                <div class="note-box">
                    <p><strong>By using EDUCONECX, you acknowledge that you have read, understood, and agree to be bound by these Terms & Conditions.</strong></p>
                    <p>If you have any questions about these Terms, please contact us at <a href="mailto:contact@educonecx.com">contact@educonecx.com</a>.</p>
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
        const sections = document.querySelectorAll('.terms-article, #disclaimer');
        const tocLinks = document.querySelectorAll('.toc-list a');
        
        // Debounce scroll event
        let scrollTimeout;
        
        window.addEventListener('scroll', () => {
            clearTimeout(scrollTimeout);
            
            scrollTimeout = setTimeout(() => {
                let current = '';
                let currentPosition = window.scrollY + 200;
                
                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    const sectionBottom = sectionTop + section.offsetHeight;
                    
                    if (currentPosition >= sectionTop && currentPosition < sectionBottom) {
                        current = section.getAttribute('id');
                    }
                });
                
                tocLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === '#' + current) {
                        link.classList.add('active');
                    }
                });
            }, 100);
        });

        // Handle hash in URL on page load
        if (window.location.hash) {
            const targetElement = document.querySelector(window.location.hash);
            if (targetElement) {
                setTimeout(() => {
                    targetElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }, 100);
            }
        }
    });
</script>
@endpush