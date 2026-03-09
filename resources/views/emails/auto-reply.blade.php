<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank you for contacting EDUCANECX</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #0A1D44;
            background-color: #F9F7E9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #FEFDFE;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(10, 29, 68, 0.12);
        }
        .header {
            background: linear-gradient(135deg, #0A1D44 0%, #18386E 50%, #2E5C61 100%);
            color: #FEFDFE;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            color: #FBC60C;
        }
        .content {
            padding: 30px;
        }
        .greeting {
            font-size: 20px;
            color: #0A1D44;
            margin-bottom: 20px;
        }
        .message {
            color: #2E5C61;
            margin-bottom: 30px;
        }
        .info-box {
            background: #F9F7E9;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            border-left: 4px solid #FBC60C;
        }
        .contact-details {
            background: #F9F7E9;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }
        .contact-details a {
            color: #18386E;
            text-decoration: none;
            font-weight: bold;
        }
        .contact-details a:hover {
            color: #FBC60C;
        }
        .footer {
            background: #CBD1DA;
            padding: 20px;
            text-align: center;
            font-size: 14px;
            color: #0A1D44;
        }
        .social-links {
            margin-top: 15px;
        }
        .social-links a {
            display: inline-block;
            margin: 0 10px;
            color: #0A1D44;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✨ Thank You for Contacting Us!</h1>
        </div>
        
        <div class="content">
            <div class="greeting">
                Dear {{ $data['first_name'] }} {{ $data['last_name'] }},
            </div>
            
            <div class="message">
                <p>Thank you for reaching out to EDUCANECX. We have received your message and appreciate your interest in our services.</p>
                <p>Our team will review your inquiry and get back to you within 24-48 hours during business days.</p>
            </div>
            
            <div class="info-box">
                <h3 style="margin-top: 0; color: #0A1D44;">📋 Your Message Summary:</h3>
                <p><strong>Subject:</strong> {{ ucfirst(str_replace('-', ' ', $data['subject'] ?? 'General Inquiry')) }}</p>
                <p><strong>Message:</strong> {{ $data['message'] }}</p>
            </div>
            
            <div class="contact-details">
                <h3 style="margin-top: 0; color: #0A1D44;">📞 Need Immediate Assistance?</h3>
                <p>Call us at: <a href="tel:+18335338228">+1 (833) 533-8228</a></p>
                <p>Email us directly: <a href="mailto:contact@educonecx.com">contact@educonecx.com</a></p>
                
                <div class="social-links">
                    <p>Follow us on social media:</p>
                    <a href="https://www.facebook.com/profile.php?id=61584601012851">Facebook</a> |
                    <a href="https://www.instagram.com/educonecx/">Instagram</a> |
                    <a href="https://www.tiktok.com/@educonecx.officia">TikTok</a> |
                    <a href="https://www.youtube.com/@EDUCONECX">YouTube</a>
                </div>
            </div>
        </div>
        
        <div class="footer">
            <p>Best regards,<br><strong>The EDUCANECX Team</strong></p>
            <p style="margin-top: 15px; font-size: 12px; color: #5f5f5f;">
                © {{ date('Y') }} EDUCANECX. All rights reserved.<br>
                1200 Brickell Ave, Miami, FL 33131, USA
            </p>
        </div>
    </div>
</body>
</html>