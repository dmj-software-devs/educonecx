@extends('layouts.main')

@section('title', 'Privacy Policy - EDUCONECX')

@section('meta_description', 'Read our Privacy Policy to understand how EDUCONECX collects, uses, and protects your personal data when you use our educational platform and services.')

@push('styles')
<style>
    /* Privacy Policy Header */
    .privacy-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 80px 0;
        text-align: center;
        margin-bottom: 60px;
    }
    
    .privacy-title {
        font-size: 48px;
        margin-bottom: 20px;
        animation: slideUp 0.8s ease-out;
    }
    
    .privacy-subtitle {
        font-size: 18px;
        opacity: 0.9;
        max-width: 700px;
        margin: 0 auto;
        line-height: 1.6;
        animation: slideUp 0.8s ease-out 0.2s both;
    }
    
    /* Privacy Content */
    .privacy-section {
        padding: 0 0 80px;
    }
    
    .privacy-container {
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
    
    .policy-section {
        margin-bottom: 40px;
    }
    
    .section-number {
        display: inline-block;
        font-size: 18px;
        font-weight: 700;
        color: var(--primary-color);
        margin-right: 10px;
    }
    
    .section-title {
        display: inline-block;
        font-size: 24px;
        font-weight: 700;
        color: var(--text-color);
        margin-bottom: 20px;
        border-bottom: 2px solid var(--primary-color);
        padding-bottom: 5px;
    }
    
    .subsection-title {
        font-size: 18px;
        font-weight: 600;
        color: var(--text-color);
        margin: 20px 0 10px;
    }
    
    .policy-text {
        color: #444;
        line-height: 1.8;
        margin-bottom: 15px;
        font-size: 16px;
    }
    
    .policy-list {
        margin: 15px 0;
        padding-left: 20px;
    }
    
    .policy-list li {
        margin-bottom: 10px;
        color: #555;
        line-height: 1.6;
        position: relative;
        padding-left: 20px;
    }
    
    .policy-list li::before {
        content: "•";
        color: var(--primary-color);
        font-weight: bold;
        position: absolute;
        left: 0;
    }
    
    .numbered-list {
        list-style: none;
        counter-reset: item;
        padding-left: 0;
    }
    
    .numbered-list li {
        counter-increment: item;
        margin-bottom: 10px;
        padding-left: 30px;
        position: relative;
        color: #555;
        line-height: 1.6;
    }
    
    .numbered-list li::before {
        content: counter(item) ".";
        color: var(--primary-color);
        font-weight: 600;
        position: absolute;
        left: 0;
    }
    
    .highlight-box {
        background: #f8f9fa;
        border-left: 4px solid var(--primary-color);
        padding: 20px;
        margin: 20px 0;
        border-radius: 0 10px 10px 0;
    }
    
    .highlight-box p {
        margin-bottom: 10px;
    }
    
    .highlight-box p:last-child {
        margin-bottom: 0;
    }
    
    .contact-details {
        background: #f8f9fa;
        padding: 25px;
        border-radius: 10px;
        margin: 20px 0;
    }
    
    .contact-details p {
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .contact-details i {
        color: var(--primary-color);
        width: 20px;
    }
    
    .contact-details a {
        color: var(--primary-color);
        text-decoration: none;
    }
    
    .contact-details a:hover {
        text-decoration: underline;
    }
    
    hr {
        margin: 40px 0;
        border: none;
        border-top: 1px solid #eee;
    }
    
    /* Accessibility Statement */
    .accessibility-statement {
        margin-top: 60px;
        padding-top: 40px;
        border-top: 2px solid #eee;
    }
    
    .accessibility-title {
        font-size: 28px;
        margin-bottom: 30px;
        color: var(--text-color);
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
    
    .toc-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 10px;
    }
    
    .toc-item {
        color: var(--primary-color);
        text-decoration: none;
        font-size: 14px;
        transition: color 0.3s;
    }
    
    .toc-item:hover {
        color: var(--primary-hover);
        text-decoration: underline;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .privacy-header {
            padding: 60px 0;
        }
        
        .privacy-title {
            font-size: 36px;
        }
        
        .privacy-container {
            padding: 30px 20px;
            margin: 0 15px;
        }
        
        .section-title {
            font-size: 20px;
        }
        
        .toc-grid {
            grid-template-columns: 1fr;
        }
        
        .policy-text {
            font-size: 15px;
        }
    }
</style>
@endpush

@section('content')
    <!-- Privacy Policy Header -->
    <section class="privacy-header">
        <div class="container">
            <h1 class="privacy-title">Privacy Policy</h1>
            <p class="privacy-subtitle">EDUCONECX — "Learn. Connect. Grow"</p>
        </div>
    </section>
    
    <!-- Privacy Content -->
    <section class="privacy-section">
        <div class="container">
            <div class="privacy-container">
                <div class="last-updated">
                    Initial version validated — June 2025
                </div>
                
                <!-- Table of Contents -->
                <div class="toc">
                    <div class="toc-title">Quick Navigation</div>
                    <div class="toc-grid">
                        <a href="#section1" class="toc-item">1. WHO WE ARE</a>
                        <a href="#section2" class="toc-item">2. PERSONAL DATA WE COLLECT</a>
                        <a href="#section3" class="toc-item">3. PURPOSES OF DATA PROCESSING</a>
                        <a href="#section4" class="toc-item">4. DATA SHARING</a>
                        <a href="#section5" class="toc-item">5. AI COMPANION DATA</a>
                        <a href="#section6" class="toc-item">6. USER RIGHTS</a>
                        <a href="#section7" class="toc-item">7. DATA SECURITY</a>
                        <a href="#section8" class="toc-item">8. CONSENT</a>
                        <a href="#section9" class="toc-item">9. CHILDREN</a>
                        <a href="#section10" class="toc-item">10. INTERNATIONAL DATA TRANSFERS</a>
                        <a href="#section11" class="toc-item">11. COOKIES</a>
                        <a href="#section12" class="toc-item">12. DATA RETENTION</a>
                        <a href="#section13" class="toc-item">13. ACCESSIBILITY</a>
                        <a href="#section14" class="toc-item">14. MARKETING COMMUNICATIONS</a>
                        <a href="#section15" class="toc-item">15. STRIPE PAYMENT PROCESSING</a>
                        <a href="#section16" class="toc-item">16. YOUR CALIFORNIA PRIVACY RIGHTS</a>
                        <a href="#section17" class="toc-item">17. LIMITATION OF LIABILITY</a>
                        <a href="#section18" class="toc-item">18. GOVERNING LAW AND DISPUTE RESOLUTION</a>
                        <a href="#section19" class="toc-item">19. CHANGES TO THIS POLICY</a>
                        <a href="#section20" class="toc-item">20. CONTACT US</a>
                        <a href="#accessibility" class="toc-item">Accessibility Statement</a>
                    </div>
                </div>
                
                <!-- Introduction -->
                <p class="policy-text">
                    At EDUCONECX, we are committed to protecting the privacy and personal data of our users. This Privacy Policy explains how we collect, use, share, and protect your personal data when you use our website and services.
                </p>
                
                <!-- Section 1 -->
                <div id="section1" class="policy-section">
                    <h2 class="section-title">
                        <span class="section-number">1.</span> WHO WE ARE
                    </h2>
                    <p class="policy-text">
                        EDUCONECX is an online educational platform based in Florida (USA), serving an international audience. We offer:
                    </p>
                    <ul class="policy-list">
                        <li>Paid and free online English courses</li>
                        <li>AI Companion for self-learning</li>
                        <li>Call center training programs</li>
                        <li>Digital learning programs</li>
                        <li>Educational content</li>
                        <li>Subscription services</li>
                        <li>Email marketing and notifications</li>
                    </ul>
                </div>
                
                <!-- Section 2 -->
                <div id="section2" class="policy-section">
                    <h2 class="section-title">
                        <span class="section-number">2.</span> PERSONAL DATA WE COLLECT
                    </h2>
                    <p class="policy-text">
                        We may collect the following personal data:
                    </p>
                    <ul class="policy-list">
                        <li>Name</li>
                        <li>Email address</li>
                        <li>Preferred language</li>
                        <li>Account information (username, profile details)</li>
                        <li>Payment information (processed by Stripe — we never store full credit card details)</li>
                        <li>Usage data (pages visited, course progress, interactions with the AI Companion)</li>
                        <li>Communication data (support tickets, feedback)</li>
                        <li>Marketing preferences and consent records</li>
                        <li>Course completion certificates and achievements</li>
                        <li>Session recordings (if applicable for training)</li>
                        <li>IP address, location data, browser cookies, and device information</li>
                        <li>Questions and content submitted via the AI Companion</li>
                    </ul>
                </div>
                
                <!-- Section 3 -->
                <div id="section3" class="policy-section">
                    <h2 class="section-title">
                        <span class="section-number">3.</span> PURPOSES OF DATA PROCESSING
                    </h2>
                    <p class="policy-text">
                        We use your personal data for the following purposes and legal bases:
                    </p>
                    <ul class="policy-list">
                        <li>Provide access to courses and services (contractual necessity)</li>
                        <li>Personalize your experience (legitimate interest)</li>
                        <li>Process payments via Stripe (contractual necessity)</li>
                        <li>Manage accounts and learning progress (contractual necessity)</li>
                        <li>Send notifications and marketing emails (consent)</li>
                        <li>Improve our services, including AI Companion (legitimate interest)</li>
                        <li>Comply with legal obligations (legal requirement)</li>
                    </ul>
                </div>
                
                <!-- Section 4 -->
                <div id="section4" class="policy-section">
                    <h2 class="section-title">
                        <span class="section-number">4.</span> DATA SHARING
                    </h2>
                    <p class="policy-text">
                        We only share your personal data with trusted third parties when necessary to provide our services. All third parties are contractually required to protect your data. International data transfers are covered by Standard Contractual Clauses approved by the European Commission.
                    </p>
                    <p class="policy-text">We may share data with:</p>
                    <ul class="policy-list">
                        <li>Stripe, Inc. for payment processing</li>
                        <li>Google Analytics (if enabled) for usage statistics</li>
                        <li>Email marketing platforms (e.g., Mailchimp, Wix Email Marketing)</li>
                        <li>Technical service providers (hosting, security)</li>
                        <li>Legal authorities, when required by law</li>
                    </ul>
                    <p class="policy-text"><strong>We do not sell your personal data.</strong></p>
                </div>
                
                <!-- Section 5 -->
                <div id="section5" class="policy-section">
                    <h2 class="section-title">
                        <span class="section-number">5.</span> AI COMPANION DATA
                    </h2>
                    <p class="policy-text">The AI Companion collects:</p>
                    <ul class="policy-list">
                        <li>User-submitted questions</li>
                        <li>User interactions with the AI</li>
                    </ul>
                    <p class="policy-text">This data is used to:</p>
                    <ul class="policy-list">
                        <li>Provide personalized responses</li>
                        <li>Improve the AI Companion service (anonymized)</li>
                        <li>Evaluate AI performance</li>
                    </ul>
                    <p class="policy-text">You have the right to opt out of AI-based profiling.</p>
                    <p class="policy-text">Data from AI interactions is retained for 2 years.</p>
                    <p class="policy-text">We may use anonymized data to improve our AI models — never identifiable personal data.</p>
                </div>
                
                <!-- Section 6 -->
                <div id="section6" class="policy-section">
                    <h2 class="section-title">
                        <span class="section-number">6.</span> USER RIGHTS
                    </h2>
                    <p class="policy-text">
                        Under GDPR, CCPA, and other applicable laws, you have the right to:
                    </p>
                    <ul class="policy-list">
                        <li>Access your data</li>
                        <li>Correct your data</li>
                        <li>Delete your data</li>
                        <li>Restrict processing</li>
                        <li>Object to marketing uses</li>
                        <li>Data portability</li>
                        <li>Withdraw consent at any time</li>
                        <li>Lodge complaints with a supervisory authority</li>
                    </ul>
                    <p class="policy-text">We will respond to all requests within 30 days.</p>
                    <p class="policy-text">California residents may request information about data sales twice annually.</p>
                    <p class="policy-text">Opt-out mechanisms are provided for all marketing and non-essential data processing.</p>
                </div>
                
                <!-- Section 7 -->
                <div id="section7" class="policy-section">
                    <h2 class="section-title">
                        <span class="section-number">7.</span> DATA SECURITY
                    </h2>
                    <ul class="policy-list">
                        <li>Encryption for data in transit and at rest</li>
                        <li>Access is limited to authorized personnel only</li>
                        <li>Regular security assessments are conducted</li>
                        <li>In the event of a data breach, we will notify affected users within 72 hours of discovery.</li>
                    </ul>
                </div>
                
                <!-- Section 8 -->
                <div id="section8" class="policy-section">
                    <h2 class="section-title">
                        <span class="section-number">8.</span> CONSENT
                    </h2>
                    <p class="policy-text">
                        By using our website and services, you consent to this Privacy Policy. You may withdraw your consent at any time.
                    </p>
                </div>
                
                <!-- Section 9 -->
                <div id="section9" class="policy-section">
                    <h2 class="section-title">
                        <span class="section-number">9.</span> CHILDREN
                    </h2>
                    <p class="policy-text">Our site is not intended for children under 13 years old.</p>
                    <p class="policy-text">If we discover that we have collected personal data from a child under 13, we will delete it immediately.</p>
                    <p class="policy-text">Parents may contact us to review or delete their child's information.</p>
                    <p class="policy-text">We do not knowingly target or market to children under 13.</p>
                </div>
                
                <!-- Section 10 -->
                <div id="section10" class="policy-section">
                    <h2 class="section-title">
                        <span class="section-number">10.</span> INTERNATIONAL DATA TRANSFERS
                    </h2>
                    <p class="policy-text">
                        Your personal data may be transferred and processed outside your country of residence, including in the United States.
                    </p>
                    <p class="policy-text">
                        We ensure adequate protection through Standard Contractual Clauses and other safeguards as required by law.
                    </p>
                </div>
                
                <!-- Section 11 -->
                <div id="section11" class="policy-section">
                    <h2 class="section-title">
                        <span class="section-number">11.</span> COOKIES
                    </h2>
                    <p class="policy-text">We use the following types of cookies:</p>
                    <ul class="policy-list">
                        <li>Essential</li>
                        <li>Functional</li>
                        <li>Analytics</li>
                        <li>Marketing</li>
                    </ul>
                    <p class="policy-text">You can manage your cookie preferences through your browser settings.</p>
                    <p class="policy-text">For more details, please see our full [Cookie Policy].</p>
                    <p class="policy-text">We may use third-party cookies.</p>
                    <p class="policy-text">You can opt out of marketing and analytics cookies at any time.</p>
                </div>
                
                <!-- Section 12 -->
                <div id="section12" class="policy-section">
                    <h2 class="section-title">
                        <span class="section-number">12.</span> DATA RETENTION
                    </h2>
                    <p class="policy-text">We retain personal data as follows:</p>
                    <ul class="policy-list">
                        <li>Account data: duration of account + 3 years</li>
                        <li>Payment records: 7 years (legal requirement)</li>
                        <li>AI interactions: 2 years</li>
                        <li>Marketing data: until consent is withdrawn</li>
                    </ul>
                </div>
                
                <!-- Section 13 -->
                <div id="section13" class="policy-section">
                    <h2 class="section-title">
                        <span class="section-number">13.</span> ACCESSIBILITY
                    </h2>
                    <p class="policy-text">We are committed to digital accessibility (WCAG 2.1 AA standard).</p>
                    <p class="policy-text">If you need this Policy in an alternative format, please contact us.</p>
                    <p class="policy-text">We continuously work to improve accessibility for all users.</p>
                </div>
                
                <!-- Section 14 -->
                <div id="section14" class="policy-section">
                    <h2 class="section-title">
                        <span class="section-number">14.</span> MARKETING COMMUNICATIONS
                    </h2>
                    <ul class="policy-list">
                        <li>You may opt out of marketing emails at any time.</li>
                        <li>We never share your email with third parties for marketing purposes.</li>
                        <li>Transactional emails (such as purchase confirmations) cannot be opted out of.</li>
                    </ul>
                </div>
                
                <!-- Section 15 -->
                <div id="section15" class="policy-section">
                    <h2 class="section-title">
                        <span class="section-number">15.</span> STRIPE PAYMENT PROCESSING
                    </h2>
                    <p class="policy-text">Payments on this site are processed by Stripe, Inc.</p>
                    <p class="policy-text">We never store credit card numbers.</p>
                    <p class="policy-text">
                        See <a href="https://stripe.com/privacy" target="_blank" style="color: var(--primary-color);">Stripe's Privacy Policy</a> for more information.
                    </p>
                </div>
                
                <!-- Section 16 -->
                <div id="section16" class="policy-section">
                    <h2 class="section-title">
                        <span class="section-number">16.</span> YOUR CALIFORNIA PRIVACY RIGHTS
                    </h2>
                    <p class="policy-text">California residents have the right to:</p>
                    <ul class="policy-list">
                        <li>Request disclosure of personal data collected and shared</li>
                        <li>Request deletion of personal data</li>
                        <li>Opt out of the sale of personal data ("Do Not Sell My Personal Information")</li>
                        <li>Limit the use of sensitive personal information</li>
                    </ul>
                    <p class="policy-text">We do not sell personal data.</p>
                    <p class="policy-text">Requests may be submitted up to twice per year.</p>
                </div>
                
                <!-- Section 17 -->
                <div id="section17" class="policy-section">
                    <h2 class="section-title">
                        <span class="section-number">17.</span> LIMITATION OF LIABILITY
                    </h2>
                    <p class="policy-text">
                        We are not responsible for events beyond our control, including unauthorized access to your data due to hacking or other breaches.
                    </p>
                    <p class="policy-text">Use of this site is at your own risk.</p>
                </div>
                
                <!-- Section 18 -->
                <div id="section18" class="policy-section">
                    <h2 class="section-title">
                        <span class="section-number">18.</span> GOVERNING LAW AND DISPUTE RESOLUTION
                    </h2>
                    <p class="policy-text">
                        This Privacy Policy is governed by the laws of the State of Florida, United States.
                    </p>
                    <p class="policy-text">
                        Any disputes arising from this Policy will be subject to the exclusive jurisdiction of the courts located in Florida.
                    </p>
                </div>
                
                <!-- Section 19 -->
                <div id="section19" class="policy-section">
                    <h2 class="section-title">
                        <span class="section-number">19.</span> CHANGES TO THIS POLICY
                    </h2>
                    <p class="policy-text">We reserve the right to update this Privacy Policy.</p>
                    <p class="policy-text">Any changes will be posted here with the date of the update.</p>
                </div>
                
                <!-- Section 20 -->
                <div id="section20" class="policy-section">
                    <h2 class="section-title">
                        <span class="section-number">20.</span> CONTACT US
                    </h2>
                    <p class="policy-text">For any questions about this Privacy Policy or to exercise your rights, please contact:</p>
                    
                    <div class="contact-details">
                        <p>
                            <i class="fas fa-envelope"></i>
                            <a href="mailto:contact@educonecx.com">contact@educonecx.com</a>
                        </p>
                        <p>
                            <i class="fas fa-map-marker-alt"></i>
                            Florida, USA
                        </p>
                    </div>
                </div>
                
                <!-- Accessibility Statement -->
                <div id="accessibility" class="accessibility-statement">
                    <h2 class="accessibility-title">Accessibility Statement</h2>
                    
                    <h3 class="subsection-title">Our Commitment to Accessibility</h3>
                    <p class="policy-text">
                        At EDUCONECX, we believe that quality education should be accessible to everyone, regardless of ability.
                        We are committed to providing an inclusive learning platform that serves our diverse international community, including individuals with disabilities from Haitian, Latino, and other backgrounds.
                    </p>
                    <p class="policy-text">
                        We actively work to ensure our AI-powered English courses, call center training programs, and multilingual educational content meet the highest accessibility standards.
                        Our goal is to comply with:
                    </p>
                    <ul class="policy-list">
                        <li>Web Content Accessibility Guidelines (WCAG 2.2 Level AA)</li>
                        <li>Americans with Disabilities Act (ADA)</li>
                        <li>European Accessibility Act (EAA)</li>
                    </ul>
                    
                    <h3 class="subsection-title">Conformance Status</h3>
                    <p class="policy-text">
                        EDUCONECX is partially conformant with WCAG 2.2 Level AA.
                        This means that while most of our content meets accessibility standards, some areas are still being improved.
                        We are committed to achieving full conformance and continuously enhancing our platform's accessibility.
                    </p>
                    
                    <h3 class="subsection-title">Accessibility Features Currently Implemented</h3>
                    <ul class="policy-list">
                        <li>Full keyboard navigation throughout the platform</li>
                        <li>Screen reader compatibility with NVDA, JAWS, and VoiceOver</li>
                        <li>Alternative text descriptions for all images and graphics</li>
                        <li>Captions and transcripts for video content in English, Spanish, and Haitian Creole</li>
                        <li>Clear heading structure (H1, H2, H3) for easy navigation</li>
                        <li>Consistent page layouts and predictable navigation</li>
                        <li>Adjustable text size and high contrast mode options</li>
                        <li>Skip to the main content links on all pages</li>
                        <li>Focus indicators clearly visible for keyboard users</li>
                        <li>Mobile accessibility optimized for iOS and Android assistive technologies</li>
                        <li>Form labels and error messages clearly associated with input fields</li>
                        <li>Language attributes properly set for multilingual content</li>
                    </ul>
                    
                    <h3 class="subsection-title">AI-Powered Accessibility</h3>
                    <ul class="policy-list">
                        <li>All AI-generated content undergoes human review for accessibility compliance</li>
                        <li>AI Companion responses are structured for screen reader compatibility</li>
                        <li>Alternative formats available for AI-generated learning materials</li>
                        <li>Clear identification when content is AI-generated</li>
                    </ul>
                    
                    <h3 class="subsection-title">Known Limitations and Alternatives</h3>
                    <p class="policy-text"><strong>Current Limitations:</strong></p>
                    <ul class="policy-list">
                        <li>Some older course materials created before 2024 may not fully meet WCAG 2.2 standards</li>
                        <li>Certain embedded content (external videos, payment forms) may have limited accessibility</li>
                        <li>Some AI Companion features may require additional accessibility improvements</li>
                        <li>Real-time captions for live training sessions are not yet available in all languages</li>
                    </ul>
                    
                    <p class="policy-text"><strong>Alternative Access:</strong></p>
                    <p class="policy-text">If you encounter any barriers, we provide:</p>
                    <ul class="policy-list">
                        <li>Alternative formats (PDF, Word, audio) upon request</li>
                        <li>Personal assistance via email</li>
                        <li>Extended time for timed assessments when needed</li>
                        <li>One-on-one support sessions for complex content</li>
                    </ul>
                    
                    <h3 class="subsection-title">Testing and Quality Assurance</h3>
                    <p class="policy-text"><strong>Regular Testing Protocol:</strong></p>
                    <ul class="policy-list">
                        <li>Automated testing using WIX Accessibility Wizard and Axe DevTools</li>
                        <li>Manual testing with keyboard navigation and screen readers</li>
                        <li>Mobile testing on iOS VoiceOver and Android TalkBack</li>
                        <li>User testing with individuals with disabilities (quarterly)</li>
                        <li>AI content review for accessibility before publication</li>
                    </ul>
                    
                    <p class="policy-text"><strong>Audit Schedule:</strong></p>
                    <ul class="policy-list">
                        <li>Monthly automated scans</li>
                        <li>Quarterly manual audits</li>
                        <li>Annual third-party accessibility audit</li>
                        <li>Continuous user feedback integration</li>
                    </ul>
                    
                    <h3 class="subsection-title">Browser Compatibility</h3>
                    <p class="policy-text">Best experience with:</p>
                    <ul class="policy-list">
                        <li>Chrome (version 90+)</li>
                        <li>Firefox (version 88+)</li>
                        <li>Safari (version 14+)</li>
                        <li>Edge (version 90+)</li>
                    </ul>
                    
                    <h3 class="subsection-title">Feedback and Support</h3>
                    <p class="policy-text">
                        We value your feedback and are committed to resolving accessibility issues promptly.
                    </p>
                    <p class="policy-text">For accessibility concerns or assistance, please contact:</p>
                    
                    <div class="contact-details">
                        <p>
                            <i class="fas fa-envelope"></i>
                            <a href="mailto:contact@educonecx.com">contact@educonecx.com</a>
                        </p>
                        <p>
                            <i class="fas fa-map-marker-alt"></i>
                            EDUCONECX, 1200 Brickell Ave, Suite 1250, Miami, FL 33131, USA
                        </p>
                    </div>
                    
                    <p class="policy-text">
                        <strong>Response time:</strong> Initial response within two business days and full resolution plan within five business days.
                    </p>
                    
                    <h3 class="subsection-title">What to Include in Your Feedback</h3>
                    <ul class="policy-list">
                        <li>Page URL or location of the issue</li>
                        <li>Description of the problem</li>
                        <li>Assistive technology used (if applicable)</li>
                        <li>Your contact information for follow-up</li>
                    </ul>
                    
                    <h3 class="subsection-title">Non-Discrimination Statement</h3>
                    <p class="policy-text">
                        EDUCONECX does not discriminate on the basis of disability and is committed to providing equal access to all users.
                    </p>
                    
                    <h3 class="subsection-title">Continuous Improvement</h3>
                    <p class="policy-text">Our Ongoing Commitments:</p>
                    <ul class="policy-list">
                        <li>Regular accessibility training for all content creators and developers</li>
                        <li>Staying current with WCAG updates and legal requirements</li>
                        <li>Exploring new technologies to enhance accessibility</li>
                        <li>Engaging with disability advocacy groups for guidance</li>
                        <li>Publishing accessibility improvements in quarterly updates</li>
                    </ul>
                    
                    <h3 class="subsection-title">Future Roadmap</h3>
                    <ul class="policy-list">
                        <li>Full WCAG 2.2 AA conformance by Q4 2025</li>
                        <li>Real-time captions in multiple languages by Q1 2026</li>
                        <li>Enhanced AI accessibility features by Q2 2026</li>
                    </ul>
                    <p class="policy-text"><em>Note: These targets are subject to revision as we continue to enhance our platform.</em></p>
                    
                    <h3 class="subsection-title">Technical Specifications</h3>
                    <p class="policy-text">For users of assistive technologies, EDUCONECX is designed to work with:</p>
                    <ul class="policy-list">
                        <li>Screen Readers: JAWS 2021+, NVDA 2020+, VoiceOver, TalkBack</li>
                        <li>Voice Recognition: Dragon NaturallySpeaking 15+</li>
                        <li>Screen Magnification: ZoomText 2020+, built-in OS magnifiers</li>
                        <li>Alternative Input: Switch controls, eye-tracking devices</li>
                    </ul>
                    
                    <h3 class="subsection-title">Date of Last Update</h3>
                    <p class="policy-text">
                        This Accessibility Statement was last reviewed and updated on June 19, 2025.
                        We review this statement quarterly and after any major platform updates.
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Smooth scroll for table of contents links
        document.querySelectorAll('.toc-item').forEach(link => {
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
    });
</script>
@endpush