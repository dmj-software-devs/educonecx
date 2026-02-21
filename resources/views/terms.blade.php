@extends('layouts.main')

@section('title', 'Terms & Conditions - EDUCONECX')

@section('meta_description', 'Read our Terms & Conditions governing your use of the EDUCONECX platform, including disclaimers, user agreements, and legal information.')

@push('styles')
<style>
    /* Terms Header */
    .terms-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 80px 0;
        text-align: center;
        margin-bottom: 60px;
    }
    
    .terms-title {
        font-size: 48px;
        margin-bottom: 20px;
        animation: slideUp 0.8s ease-out;
    }
    
    .terms-subtitle {
        font-size: 18px;
        opacity: 0.9;
        max-width: 700px;
        margin: 0 auto;
        line-height: 1.6;
        animation: slideUp 0.8s ease-out 0.2s both;
    }
    
    /* Terms Content */
    .terms-section {
        padding: 0 0 80px;
    }
    
    .terms-container {
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
    
    /* Disclaimer Box */
    .disclaimer-box {
        background: #fff3cd;
        border: 1px solid #ffeeba;
        border-radius: 10px;
        padding: 30px;
        margin-bottom: 40px;
    }
    
    .disclaimer-title {
        font-size: 20px;
        font-weight: 700;
        color: #856404;
        margin-bottom: 15px;
    }
    
    .disclaimer-text {
        color: #856404;
        line-height: 1.8;
        margin-bottom: 15px;
    }
    
    .disclaimer-text:last-child {
        margin-bottom: 0;
    }
    
    .disclaimer-list {
        margin: 15px 0 15px 20px;
        color: #856404;
    }
    
    .disclaimer-list li {
        margin-bottom: 8px;
        line-height: 1.6;
    }
    
    /* Terms Sections */
    .terms-article {
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
        background: #f8f9fa;
        border-left: 4px solid var(--primary-color);
        padding: 15px 20px;
        margin: 20px 0;
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
        .terms-header {
            padding: 60px 0;
        }
        
        .terms-title {
            font-size: 36px;
        }
        
        .terms-container {
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
        
        .disclaimer-box {
            padding: 20px;
        }
    }
</style>
@endpush

@section('content')
    <!-- Terms Header -->
    <section class="terms-header">
        <div class="container">
            <h1 class="terms-title">Terms & Conditions</h1>
            <p class="terms-subtitle">Please read these terms carefully before using our services</p>
        </div>
    </section>
    
    <!-- Terms Content -->
    <section class="terms-section">
        <div class="container">
            <div class="terms-container">
                <div class="last-updated">
                    Last Updated: February 7, 2026
                </div>
                
                <!-- Table of Contents -->
                <div class="toc">
                    <div class="toc-title">Quick Navigation</div>
                    <ul class="toc-list">
                        <li><a href="#disclaimer">Disclaimer – Financial, Freelance, and Educational Training</a></li>
                        <li><a href="#section1">1. Acceptance of Terms</a></li>
                        <li><a href="#section2">2. Description of Services</a></li>
                        <li><a href="#section3">3. User Eligibility and Account Registration</a></li>
                        <li><a href="#section4">4. Acceptable Use</a></li>
                        <li><a href="#section5">5. Payment Terms and Subscriptions</a></li>
                        <li><a href="#section6">6. Refund Policy</a></li>
                        <li><a href="#section7">7. Intellectual Property Rights</a></li>
                        <li><a href="#section8">8. AI Companion Disclaimer</a></li>
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
                    <h2 class="disclaimer-title">⚠️ Disclaimer – Financial, Freelance, and Educational Training</h2>
                    
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
                    <p class="article-content">EDUCONECX provides online educational content focused on digital skills, professional development, and personal growth. Our courses, tools, and learning resources are designed to help users progress academically, socially, and economically. Content is offered in multiple languages and may include videos, digital materials, progress tracking, and AI-powered learning assistance.</p>
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
                    <h2 class="article-title">AI Companion Disclaimer</h2>
                    <p class="article-content">AI features on the platform provide general educational support only. AI guidance is not intended for:</p>
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
                    <p>If you have any questions about these Terms, please contact us at <a href="mailto:contact@educonecx.com" style="color: var(--primary-color);">contact@educonecx.com</a>.</p>
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
                    link.style.fontWeight = '600';
                } else {
                    link.style.fontWeight = 'normal';
                }
            });
        });
    });
</script>
@endpush