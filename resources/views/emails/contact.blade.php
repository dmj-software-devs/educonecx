<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Form Submission</title>
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
            font-size: 24px;
            color: #FBC60C;
        }
        .content {
            padding: 30px;
        }
        .field {
            margin-bottom: 20px;
            padding: 15px;
            background: #F9F7E9;
            border-radius: 8px;
            border-left: 4px solid #FBC60C;
        }
        .field-label {
            font-weight: bold;
            color: #0A1D44;
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
        }
        .field-value {
            color: #2E5C61;
            font-size: 16px;
        }
        .badge {
            display: inline-block;
            padding: 5px 10px;
            background: #FBC60C;
            color: #0A1D44;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            margin-top: 10px;
        }
        .message-box {
            background: #F9F7E9;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
            border: 1px solid #EBD789;
        }
        .message-box h3 {
            color: #0A1D44;
            margin-top: 0;
            margin-bottom: 15px;
            font-size: 18px;
        }
        .message-box p {
            color: #2E5C61;
            margin: 0;
            white-space: pre-wrap;
        }
        .footer {
            background: #CBD1DA;
            padding: 20px;
            text-align: center;
            font-size: 14px;
            color: #0A1D44;
        }
        .footer a {
            color: #18386E;
            text-decoration: none;
            font-weight: bold;
        }
        .footer a:hover {
            color: #FBC60C;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📬 {{ isset($data['form_type']) && $data['form_type'] === 'neo' ? 'New NEO ED-TECH Inquiry' : 'New Contact Form Submission' }}</h1>
            <div class="badge">EDUCONECX</div>
        </div>
        
        <div class="content">
            <div class="field">
                <span class="field-label">👤 Name:</span>
                <span class="field-value">{{ $data['first_name'] }} {{ $data['last_name'] }}</span>
            </div>
            
            <div class="field">
                <span class="field-label">📧 Email:</span>
                <span class="field-value">
                    <a href="mailto:{{ $data['email'] }}" style="color: #18386E;">{{ $data['email'] }}</a>
                </span>
            </div>
            
            @if(!empty($data['phone']))
            <div class="field">
                <span class="field-label">📞 Phone:</span>
                <span class="field-value">{{ $data['phone'] }}</span>
            </div>
            @endif
            
            @if(!empty($data['company']))
            <div class="field">
                <span class="field-label">🏢 Company:</span>
                <span class="field-value">{{ $data['company'] }}</span>
            </div>
            @endif
            
            @if(!empty($data['subject']) && $data['subject'] != '')
            <div class="field">
                <span class="field-label">🏷️ Subject/Service:</span>
                <span class="field-value">{{ ucfirst(str_replace('-', ' ', $data['subject'])) }}</span>
            </div>
            @endif
            
            <div class="message-box">
                <h3>💬 Message:</h3>
                <p>{{ $data['message'] }}</p>
            </div>
        </div>
        
        <div class="footer">
            <p>This message was sent from the {{ isset($data['form_type']) && $data['form_type'] === 'neo' ? 'NEO ED-TECH' : 'EDUCANECX' }} contact form.</p>
            <p>
                <a href="mailto:{{ $data['email'] }}?subject=Re: Your inquiry">✉️ Reply to {{ $data['first_name'] }}</a>
            </p>
            <p style="margin-top: 15px; font-size: 12px; color: #5f5f5f;">
                © {{ date('Y') }} EDUCANECX. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>