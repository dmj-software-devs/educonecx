<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>EDUCONECX | Thank You for Contacting Us</title>
    <style>
        /* Reset & Base Styles for Email Clients */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #F4F7FC;
            margin: 0;
            padding: 20px 0;
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }
        .email-wrapper {
            max-width: 600px;
            margin: 0 auto;
            background-color: #FFFFFF;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 35px -12px rgba(0, 0, 0, 0.08), 0 0 0 1px rgba(0, 0, 0, 0.02);
        }
        /* Header with Logo */
        .email-header {
            background: #FFFFFF;
            padding: 32px 32px 24px 32px;
            text-align: center;
            border-bottom: 1px solid #EFF3F8;
        }
        .logo-container {
            margin-bottom: 8px;
        }
        .logo {
            max-width: 200px;
            height: auto;
            display: inline-block;
            width: 100%;
        }
        /* Hero Section (no emojis, clean) */
        .hero-section {
            padding: 0 32px 24px 32px;
            text-align: center;
            background: #FFFFFF;
        }
        .hero-title {
            font-size: 28px;
            font-weight: 600;
            color: #0A2540;
            letter-spacing: -0.3px;
            margin-bottom: 12px;
            line-height: 1.3;
        }
        .hero-subtitle {
            font-size: 16px;
            color: #5A6E7C;
            border-top: 1px solid #EFF3F8;
            display: inline-block;
            padding-top: 16px;
            font-weight: 400;
        }
        /* Main Content */
        .main-content {
            padding: 8px 32px 32px 32px;
            background: #FFFFFF;
        }
        .greeting {
            font-size: 18px;
            font-weight: 600;
            color: #0A2540;
            margin-bottom: 16px;
        }
        .message-text {
            color: #2C3E4E;
            margin-bottom: 28px;
            font-size: 16px;
            line-height: 1.55;
        }
        /* Structured Summary Card - Clean Corporate Style */
        .summary-card {
            background: #F9FBFD;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 32px;
            border: 1px solid #EFF3F8;
            box-shadow: 0 1px 2px rgba(0,0,0,0.02);
        }
        .summary-title {
            font-size: 16px;
            font-weight: 600;
            color: #0A2540;
            letter-spacing: -0.2px;
            margin-bottom: 20px;
            padding-bottom: 8px;
            border-bottom: 2px solid #E2E8F0;
            display: inline-block;
        }
        .summary-item {
            display: flex;
            margin-bottom: 16px;
            align-items: flex-start;
        }
        .summary-label {
            width: 85px;
            font-weight: 600;
            color: #1F4A6E;
            font-size: 14px;
            flex-shrink: 0;
        }
        .summary-value {
            flex: 1;
            color: #2C3E4E;
            font-size: 15px;
            line-height: 1.45;
            word-break: break-word;
        }
        .message-content {
            background: #FFFFFF;
            padding: 12px 16px;
            border-radius: 12px;
            border-left: 3px solid #0057A3;
            margin-top: 6px;
            font-size: 14px;
            color: #1F2F3A;
        }
        /* Contact & Support Section - Corporate */
        .support-section {
            background: #F9FBFD;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 8px;
            text-align: center;
            border: 1px solid #EFF3F8;
        }
        .support-title {
            font-size: 18px;
            font-weight: 600;
            color: #0A2540;
            margin-bottom: 12px;
        }
        .support-details {
            margin: 12px 0 16px 0;
        }
        .contact-link {
            color: #0057A3;
            text-decoration: none;
            font-weight: 500;
            font-size: 16px;
            transition: opacity 0.2s;
        }
        .contact-link:hover {
            text-decoration: underline;
            opacity: 0.85;
        }
        .support-phone {
            font-weight: 600;
            font-size: 18px;
            letter-spacing: -0.2px;
        }
        .divider-light {
            height: 1px;
            background: #E2E8F0;
            margin: 20px 0;
        }
        /* Social Links - minimal corporate style */
        .social-links {
            margin-top: 16px;
        }
        .social-links p {
            font-size: 13px;
            color: #5A6E7C;
            margin-bottom: 12px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .social-link-item {
            display: inline-block;
            margin: 0 12px;
            font-size: 14px;
            font-weight: 500;
            color: #2C5F8A;
            text-decoration: none;
            border-bottom: 1px dotted transparent;
        }
        .social-link-item:hover {
            border-bottom-color: #0057A3;
        }
        /* Footer - Corporate, clean */
        .email-footer {
            background: #F9FBFD;
            padding: 28px 32px 24px;
            text-align: center;
            border-top: 1px solid #EFF3F8;
        }
        .footer-text {
            font-size: 13px;
            color: #5A6E7C;
            margin-bottom: 8px;
            line-height: 1.5;
        }
        .footer-address {
            font-size: 12px;
            color: #7F8C8D;
            margin-top: 12px;
        }
        .copyright {
            font-size: 12px;
            color: #8A99A6;
            margin-top: 16px;
        }
        /* Responsive adjustments */
        @media only screen and (max-width: 560px) {
            .email-wrapper {
                border-radius: 16px;
            }
            .email-header {
                padding: 24px 20px 20px 20px;
            }
            .hero-section {
                padding: 0 20px 20px 20px;
            }
            .main-content {
                padding: 8px 20px 28px 20px;
            }
            .summary-item {
                flex-direction: column;
            }
            .summary-label {
                width: auto;
                margin-bottom: 6px;
            }
            .hero-title {
                font-size: 24px;
            }
            .support-title {
                font-size: 18px;
            }
            .email-footer {
                padding: 24px 20px;
            }
        }
        /* Ensure images are responsive */
        img {
            max-width: 100%;
            height: auto;
        }
        /* preserve spacing */
        .mt-2 { margin-top: 8px; }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <!-- HEADER with Official Logo (Brand consistency: EDUCONECX) -->
        <div class="email-header">
            <div class="logo-container">
                <!-- Placeholder for official EDUCONECX Logo - high resolution, centered, responsive -->
                <!-- Replace src with actual logo URL. For demonstration, we use an inline SVG placeholder representing a premium brand identity, 
                     but final version will point to your official logo asset. I'm embedding a data-URL vector logo concept that says "EDUCONECX" in corporate style -->
                <img class="logo" src="https://placehold.co/600x120/0A2540/FFFFFF?text=EDUCONECX+ACADEMY" 
                     alt="EDUCONECX ACADEMY" 
                     style="display: block; margin: 0 auto; max-width: 240px; width: 100%; height: auto;">
                <!-- IMPORTANT: Replace placeholder with actual official logo URL (e.g., https://www.educonecx.com/logo.png) 
                     Ensures high-DPI and retina ready -->
            </div>
        </div>

        <!-- Hero (No excessive emojis, premium corporate look) -->
        <div class="hero-section">
            <h1 class="hero-title">Thank You for Reaching Out</h1>
            <div class="hero-subtitle">We appreciate your interest in EDUCONECX</div>
        </div>

        <!-- Main Message Content -->
        <div class="main-content">
            <!-- Greeting with dynamic name -->
            <div class="greeting">
                Dear {{ $data['first_name'] }} {{ $data['last_name'] }},
            </div>
            
            <div class="message-text">
                <p style="margin-bottom: 16px;">Thank you for contacting EDUCONECX. We have received your inquiry and our team will carefully review your request. We are committed to providing a prompt and thorough response.</p>
                <p>One of our specialists will get back to you within <strong>24–48 business hours</strong>. Should your matter require immediate attention, please use the contact details below.</p>
            </div>

            <!-- Structured Message Summary (clean card, professional) -->
            <div class="summary-card">
                <div class="summary-title">Inquiry Summary</div>
                <div class="summary-item">
                    <div class="summary-label">Subject</div>
                    <div class="summary-value">
                        {{ ucfirst(str_replace('-', ' ', $data['subject'] ?? 'General Inquiry')) }}
                    </div>
                </div>
                <div class="summary-item">
                    <div class="summary-label">Message</div>
                    <div class="summary-value">
                        <div class="message-content">
                            {{ $data['message'] }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Support & Quick Assistance Section - Corporate style -->
            <div class="support-section">
                <div class="support-title">Need Immediate Assistance?</div>
                <div class="support-details">
                    <p style="margin-bottom: 8px; color: #2C3E4E;">Our support team is available to assist you</p>
                    <p style="margin: 10px 0 6px 0;">
                        <a href="tel:+18335338228" class="contact-link support-phone">+1 (833) 533-8228</a>
                    </p>
                    <p>
                        <a href="mailto:contact@educonecx.com" class="contact-link">contact@educonecx.com</a>
                    </p>
                </div>
                <div class="divider-light"></div>
                <div class="social-links">
                    <p>Connect with us</p>
                    <div>
                        <a href="https://www.tiktok.com/@educonecx.official04?_r=1&_t=ZP-94pVYyt1sQI" class="social-link-item">TikTok</a>
                        <a href="https://www.youtube.com/@EDUCONECX" class="social-link-item">YouTube</a>
                        <!-- Additional social channels can be added but keep minimal for professionalism -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer with consistent brand name, address, copyright -->
        <div class="email-footer">
            <div class="footer-text">
                <strong>EDUCONECX ACADEMY</strong> — Empowering Global Education
            </div>
            <div class="footer-address">
                1200 Brickell Ave, Suite 1950, Miami, FL 33131, USA
            </div>
            <div class="copyright">
                © {{ date('Y') }} EDUCONECX. All rights reserved.
            </div>
        </div>
    </div>
</body>
</html>