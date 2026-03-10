<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Certificate of Completion - {{ $certificate->course->title }}</title>
    <style>
        /* PDF optimized styles - matching the original design */
        body {
            font-family: 'DejaVu Sans', 'Helvetica', 'Arial', sans-serif;
            background: #FEFDFE;
            margin: 0;
            padding: 0;
            color: #0A1D44;
            line-height: 1.4;
        }

        .certificate-pdf-wrapper {
            min-height: 100vh;
            background: linear-gradient(135deg, #F9F7E9 0%, #FEFDFE 100%);
            padding: 30px 20px;
        }

        .certificate-pdf-container {
            max-width: 1100px;
            margin: 0 auto;
        }

        /* Certificate Card */
        .certificate-pdf-card {
            background: #FEFDFE;
            border-radius: 40px;
            padding: 50px;
            position: relative;
            border: 1px solid rgba(251, 198, 12, 0.2);
            box-shadow: 0 20px 40px rgba(10, 29, 68, 0.15);
            page-break-inside: avoid;
        }

        /* Certificate Border Decorations */
        .certificate-pdf-border {
            position: absolute;
            top: 20px;
            left: 20px;
            right: 20px;
            bottom: 20px;
            border: 2px solid rgba(251, 198, 12, 0.3);
            border-radius: 30px;
            pointer-events: none;
        }

        .certificate-pdf-corner {
            position: absolute;
            width: 40px;
            height: 40px;
            border: 3px solid #FBC60C;
        }

        .corner-tl {
            top: -2px;
            left: -2px;
            border-right: none;
            border-bottom: none;
            border-radius: 20px 0 0 0;
        }

        .corner-tr {
            top: -2px;
            right: -2px;
            border-left: none;
            border-bottom: none;
            border-radius: 0 20px 0 0;
        }

        .corner-bl {
            bottom: -2px;
            left: -2px;
            border-right: none;
            border-top: none;
            border-radius: 0 0 0 20px;
        }

        .corner-br {
            bottom: -2px;
            right: -2px;
            border-left: none;
            border-top: none;
            border-radius: 0 0 20px 0;
        }

        /* Certificate Content */
        .certificate-pdf-content {
            position: relative;
            z-index: 1;
        }

        /* Header */
        .certificate-pdf-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 40px;
        }

        .certificate-pdf-logo {
            height: 60px;
            width: auto;
        }

        .certificate-pdf-badge {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #FBC60C, #EBD789);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #0A1D44;
        }

        .certificate-pdf-badge span {
            font-size: 40px;
            color: #0A1D44;
            font-weight: bold;
        }

        /* Title Section */
        .certificate-pdf-title-section {
            text-align: center;
            margin-bottom: 40px;
        }

        .certificate-pdf-main-title {
            font-size: 48px;
            font-weight: 800;
            color: #0A1D44;
            margin-bottom: 15px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .certificate-pdf-subtitle {
            font-size: 18px;
            color: #9F9A87;
            text-transform: uppercase;
            letter-spacing: 3px;
        }

        /* Recipient Section */
        .recipient-pdf-section {
            text-align: center;
            margin-bottom: 40px;
        }

        .recipient-pdf-name {
            font-size: 48px;
            font-weight: 700;
            color: #0A1D44;
            margin-bottom: 20px;
            font-family: 'DejaVu Sans', 'Playfair Display', serif;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .recipient-pdf-decoration {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
        }

        .decoration-line {
            width: 100px;
            height: 3px;
            background: linear-gradient(90deg, transparent, #FBC60C, transparent);
        }

        .decoration-star {
            color: #FBC60C;
            font-size: 24px;
        }

        /* Course Section */
        .course-pdf-section {
            text-align: center;
            margin-bottom: 40px;
        }

        .course-pdf-label {
            font-size: 16px;
            color: #9F9A87;
            margin-bottom: 10px;
        }

        .course-pdf-title {
            font-size: 32px;
            font-weight: 700;
            color: #2E5C61;
            margin-bottom: 15px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .course-pdf-duration {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 25px;
            background: #F9F7E9;
            border-radius: 50px;
            color: #0A1D44;
            font-weight: 500;
            border: 1px solid #FBC60C;
        }

        .duration-icon {
            color: #FBC60C;
            font-size: 16px;
        }

        /* Description */
        .description-pdf-section {
            max-width: 700px;
            margin: 0 auto 40px;
            text-align: center;
        }

        .certificate-pdf-description {
            font-size: 16px;
            color: #666;
            line-height: 1.8;
            font-style: italic;
        }

        /* Details Grid */
        .details-pdf-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin-bottom: 50px;
            background: #F9F7E9;
            padding: 30px;
            border-radius: 20px;
            border: 1px solid #FBC60C;
        }

        .detail-pdf-item {
            text-align: center;
        }

        .detail-pdf-label {
            font-size: 12px;
            color: #9F9A87;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .detail-pdf-value {
            font-size: 18px;
            font-weight: 600;
            color: #0A1D44;
        }

        .text-warning {
            color: #FBC60C;
        }

        .badge-expired {
            display: inline-block;
            padding: 2px 8px;
            background: rgba(251, 198, 12, 0.2);
            border-radius: 20px;
            font-size: 12px;
            margin-left: 8px;
            color: #9F9A87;
        }

        /* Verification Note */
        .verification-pdf-note {
            text-align: center;
            padding: 15px;
            background: #0A1D44;
            color: #FEFDFE;
            border-radius: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            font-size: 14px;
            border: 2px solid #FBC60C;
        }

        .verification-pdf-note span {
            color: #FBC60C;
            font-weight: 600;
        }

        .verification-pdf-note a {
            color: #FBC60C;
            text-decoration: none;
            font-weight: 600;
        }

        /* Print-specific styles */
        @media print {
            body {
                background: white;
                padding: 0;
            }
            
            .certificate-pdf-wrapper {
                background: white;
                padding: 0;
            }
            
            .certificate-pdf-card {
                box-shadow: none;
                border: 2px solid #0A1D44;
                page-break-inside: avoid;
            }
            
            .decoration-line {
                background: #FBC60C;
            }
        }

        /* Fallbacks for PDF rendering */
        .text-gradient {
            color: #0A1D44;
        }
        
        .bg-gradient {
            background: #F9F7E9;
        }

        /* Ensure proper spacing */
        .mb-40 {
            margin-bottom: 40px;
        }
    </style>
</head>
<body>
    <div class="certificate-pdf-wrapper">
        <div class="certificate-pdf-container">
            <!-- Main Certificate -->
            <div class="certificate-pdf-card">
                <!-- Decorative Elements -->
                <div class="certificate-pdf-border">
                    <div class="certificate-pdf-corner corner-tl"></div>
                    <div class="certificate-pdf-corner corner-tr"></div>
                    <div class="certificate-pdf-corner corner-bl"></div>
                    <div class="certificate-pdf-corner corner-br"></div>
                </div>

                <!-- Certificate Content -->
                <div class="certificate-pdf-content">
                    <!-- Logo & Badge -->
                    <div class="certificate-pdf-header">
                        <img src="{{ public_path('images/logo.jpg') }}" alt="Educonecx Logo" class="certificate-pdf-logo">
                        <div class="certificate-pdf-badge">
                            <span>🏆</span>
                        </div>
                    </div>

                    <!-- Title -->
                    <div class="certificate-pdf-title-section">
                        <h1 class="certificate-pdf-main-title">Certificate of Completion</h1>
                        <div class="certificate-pdf-subtitle">This certificate is proudly presented to</div>
                    </div>

                    <!-- Recipient Name -->
                    <div class="recipient-pdf-section">
                        <div class="recipient-pdf-name">{{ $certificate->user->full_name }}</div>
                        <div class="recipient-pdf-decoration">
                            <span class="decoration-line"></span>
                            <span class="decoration-star">✦</span>
                            <span class="decoration-line"></span>
                        </div>
                    </div>

                    <!-- Course Info -->
                    <div class="course-pdf-section">
                        <p class="course-pdf-label">For successfully completing the course</p>
                        <h2 class="course-pdf-title">{{ $certificate->course->title }}</h2>
                        
                        @if($certificate->course->hours)
                        <div class="course-pdf-duration">
                            <span class="duration-icon">⏱️</span>
                            <span>{{ $certificate->course->hours }} hours of learning</span>
                        </div>
                        @endif
                    </div>

                    <!-- Description -->
                    <div class="description-pdf-section">
                        <p class="certificate-pdf-description">
                            This certificate acknowledges the dedication, hard work, and achievement in mastering 
                            the comprehensive curriculum and demonstrating proficiency in all required competencies.
                        </p>
                    </div>

                    <!-- Certificate Details Grid -->
                    <div class="details-pdf-grid">
                        <div class="detail-pdf-item">
                            <div class="detail-pdf-label">Certificate ID</div>
                            <div class="detail-pdf-value">{{ $certificate->certificate_number }}</div>
                        </div>
                        <div class="detail-pdf-item">
                            <div class="detail-pdf-label">Issue Date</div>
                            <div class="detail-pdf-value">{{ $certificate->issue_date->format('F d, Y') }}</div>
                        </div>
                        @if($certificate->expiry_date)
                        <div class="detail-pdf-item">
                            <div class="detail-pdf-label">Valid Until</div>
                            <div class="detail-pdf-value {{ $certificate->is_expired ? 'text-warning' : '' }}">
                                {{ $certificate->expiry_date->format('F d, Y') }}
                                @if($certificate->is_expired)
                                    <span class="badge-expired">(Expired)</span>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Verification Note -->
                    <div class="verification-pdf-note">
                        <span>🔒</span>
                        <span>Verify this certificate at: {{ route('certificates.verify', $certificate->certificate_number) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>