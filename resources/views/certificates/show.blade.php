@extends('layouts.main')

@section('title', 'Certificate of Completion - ' . $certificate->course->title)

@section('content')
<div class="certificate-wrapper">
    <div class="certificate-container">
        <!-- Certificate Header Actions -->
        <div class="certificate-actions">
            <a href="{{ route('dashboard') }}" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i>
                <span>Back to Dashboard</span>
            </a>
            <div class="action-buttons">
                <button onclick="window.print()" class="btn btn-outline">
                    <i class="fas fa-print"></i>
                    <span>Print</span>
                </button>
                <a href="{{ route('certificates.download', $certificate->id) }}" class="btn btn-primary">
                    <i class="fas fa-download"></i>
                    <span>Download PDF</span>
                </a>
                <a href="https://www.linkedin.com/profile/add?startTask=CERTIFICATION_NAME&name={{ urlencode($certificate->course->title) }}&organizationName=Educonecx&issueYear={{ $certificate->issue_date->format('Y') }}&issueMonth={{ $certificate->issue_date->format('m') }}" 
                   target="_blank" 
                   class="btn btn-linkedin">
                    <i class="fab fa-linkedin"></i>
                    <span>Add to LinkedIn</span>
                </a>
            </div>
        </div>

        <!-- Main Certificate -->
        <div class="certificate-card" id="certificate-card">
            <!-- Decorative Elements -->
            <div class="certificate-border">
                <div class="certificate-corner corner-tl"></div>
                <div class="certificate-corner corner-tr"></div>
                <div class="certificate-corner corner-bl"></div>
                <div class="certificate-corner corner-br"></div>
            </div>

            <!-- Certificate Content -->
            <div class="certificate-content">
                <!-- Logo & Badge -->
                <div class="certificate-header">
                    <img src="{{ asset('images/logo.png') }}" alt="Educonecx Logo" class="certificate-logo">
                    <div class="certificate-badge">
                        <i class="fas fa-certificate"></i>
                    </div>
                </div>

                <!-- Title -->
                <div class="certificate-title-section">
                    <h1 class="certificate-main-title">Certificate of Completion</h1>
                    <div class="certificate-subtitle">This certificate is proudly presented to</div>
                </div>

                <!-- Recipient Name -->
                <div class="recipient-section">
                    <h2 class="recipient-name">{{ $certificate->user->full_name }}</h2>
                    <div class="recipient-decoration">
                        <span class="decoration-line"></span>
                        <i class="fas fa-star"></i>
                        <span class="decoration-line"></span>
                    </div>
                </div>

                <!-- Course Info -->
                <div class="course-section">
                    <p class="course-label">For successfully completing the course</p>
                    <h3 class="course-title">{{ $certificate->course->title }}</h3>
                    
                    @if($certificate->course->hours)
                    <div class="course-duration">
                        <i class="far fa-clock"></i>
                        <span>{{ $certificate->course->hours }} hours of learning</span>
                    </div>
                    @endif
                </div>

                <!-- Description -->
                <div class="description-section">
                    <p class="certificate-description">
                        This certificate acknowledges the dedication, hard work, and achievement in mastering 
                        the comprehensive curriculum and demonstrating proficiency in all required competencies.
                    </p>
                </div>

                <!-- Certificate Details Grid -->
                <div class="details-grid">
                    <div class="detail-item">
                        <div class="detail-label">Certificate ID</div>
                        <div class="detail-value">{{ $certificate->certificate_number }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Issue Date</div>
                        <div class="detail-value">{{ $certificate->issue_date->format('F d, Y') }}</div>
                    </div>
                    @if($certificate->expiry_date)
                    <div class="detail-item">
                        <div class="detail-label">Valid Until</div>
                        <div class="detail-value {{ $certificate->is_expired ? 'text-warning' : '' }}">
                            {{ $certificate->expiry_date->format('F d, Y') }}
                            @if($certificate->is_expired)
                                <span class="badge-expired">(Expired)</span>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Signatures -->
                <div class="signatures-section">
                    <div class="signature-item">
                        <div class="signature-line"></div>
                        <div class="signature-name">Dr. Sarah Johnson</div>
                        <div class="signature-title">Academic Director</div>
                    </div>
                    <div class="signature-item">
                        <div class="signature-line"></div>
                        <div class="signature-name">Prof. Michael Chen</div>
                        <div class="signature-title">Lead Instructor</div>
                    </div>
                    <div class="signature-item">
                        <div class="signature-seal">
                            <i class="fas fa-circle"></i>
                            <span>Educonecx</span>
                        </div>
                    </div>
                </div>

                <!-- Verification Note -->
                <div class="verification-note">
                    <i class="fas fa-shield-alt"></i>
                    <span>Verify this certificate at: {{ route('certificates.verify', $certificate->certificate_number) }}</span>
                </div>
            </div>
        </div>

        <!-- Share Options -->
        <div class="share-section">
            <h4>Share Your Achievement</h4>
            <div class="share-buttons">
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('certificates.verify', $certificate->certificate_number)) }}" 
                   target="_blank" class="share-btn facebook">
                    <i class="fab fa-facebook-f"></i>
                    <span>Facebook</span>
                </a>
                <a href="https://twitter.com/intent/tweet?text={{ urlencode('I just earned my certificate in ' . $certificate->course->title . ' from Educonecx!') }}&url={{ urlencode(route('certificates.verify', $certificate->certificate_number)) }}" 
                   target="_blank" class="share-btn twitter">
                    <i class="fab fa-twitter"></i>
                    <span>Twitter</span>
                </a>
                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('certificates.verify', $certificate->certificate_number)) }}" 
                   target="_blank" class="share-btn linkedin">
                    <i class="fab fa-linkedin-in"></i>
                    <span>LinkedIn</span>
                </a>
                <a href="whatsapp://send?text={{ urlencode('I just earned my certificate in ' . $certificate->course->title . ' from Educonecx! Check it out: ' . route('certificates.verify', $certificate->certificate_number)) }}" 
                   target="_blank" class="share-btn whatsapp">
                    <i class="fab fa-whatsapp"></i>
                    <span>WhatsApp</span>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
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
    --success-green: #10b981;
    --linkedin-blue: #0077b5;
}

/* Certificate Wrapper */
.certificate-wrapper {
    min-height: 100vh;
    background: linear-gradient(135deg, var(--ivory) 0%, var(--pure-white) 100%);
    padding: 40px 20px;
}

.certificate-container {
    max-width: 1100px;
    margin: 0 auto;
}

/* Certificate Actions */
.certificate-actions {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 30px;
    flex-wrap: wrap;
    gap: 15px;
}

.action-buttons {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    border-radius: 50px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
    cursor: pointer;
    border: none;
    font-size: 0.95rem;
}

.btn-outline {
    background: transparent;
    border: 2px solid var(--regal-navy);
    color: var(--regal-navy);
}

.btn-outline:hover {
    background: var(--regal-navy);
    color: var(--pure-white);
    transform: translateY(-2px);
}

.btn-primary {
    background: linear-gradient(135deg, var(--regal-navy), var(--prussian-blue));
    color: var(--pure-white);
    box-shadow: 0 4px 15px rgba(10, 29, 68, 0.2);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(10, 29, 68, 0.3);
}

.btn-linkedin {
    background: var(--linkedin-blue);
    color: white;
}

.btn-linkedin:hover {
    background: #006097;
    transform: translateY(-2px);
}

/* Certificate Card */
.certificate-card {
    background: var(--pure-white);
    border-radius: 40px;
    padding: 60px;
    position: relative;
    box-shadow: 0 20px 40px rgba(10, 29, 68, 0.15);
    border: 1px solid rgba(251, 198, 12, 0.2);
    margin-bottom: 40px;
    transition: all 0.3s ease;
}

.certificate-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 30px 60px rgba(10, 29, 68, 0.2);
}

/* Certificate Border Decorations */
.certificate-border {
    position: absolute;
    top: 20px;
    left: 20px;
    right: 20px;
    bottom: 20px;
    border: 2px solid rgba(251, 198, 12, 0.3);
    border-radius: 30px;
    pointer-events: none;
}

.certificate-corner {
    position: absolute;
    width: 40px;
    height: 40px;
    border: 3px solid var(--bright-amber);
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
.certificate-content {
    position: relative;
    z-index: 1;
}

/* Header */
.certificate-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 40px;
}

.certificate-logo {
    height: 60px;
    width: auto;
}

.certificate-badge {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--bright-amber), var(--light-gold));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 10px 20px rgba(251, 198, 12, 0.3);
}

.certificate-badge i {
    font-size: 40px;
    color: var(--prussian-blue);
}

/* Title Section */
.certificate-title-section {
    text-align: center;
    margin-bottom: 40px;
}

.certificate-main-title {
    font-size: 3.5rem;
    font-weight: 800;
    background: linear-gradient(135deg, var(--prussian-blue), var(--regal-navy), var(--dark-slate));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 15px;
    letter-spacing: 2px;
}

.certificate-subtitle {
    font-size: 1.3rem;
    color: var(--khaki-beige);
    text-transform: uppercase;
    letter-spacing: 3px;
}

/* Recipient Section */
.recipient-section {
    text-align: center;
    margin-bottom: 40px;
}

.recipient-name {
    font-size: 3.2rem;
    font-weight: 700;
    color: var(--prussian-blue);
    margin-bottom: 20px;
    font-family: 'Playfair Display', serif;
    text-transform: uppercase;
    letter-spacing: 2px;
}

.recipient-decoration {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 20px;
}

.decoration-line {
    width: 100px;
    height: 3px;
    background: linear-gradient(90deg, transparent, var(--bright-amber), transparent);
}

.recipient-decoration i {
    color: var(--bright-amber);
    font-size: 1.5rem;
}

/* Course Section */
.course-section {
    text-align: center;
    margin-bottom: 40px;
}

.course-label {
    font-size: 1.1rem;
    color: var(--khaki-beige);
    margin-bottom: 10px;
}

.course-title {
    font-size: 2.2rem;
    font-weight: 700;
    color: var(--dark-slate);
    margin-bottom: 15px;
    max-width: 800px;
    margin-left: auto;
    margin-right: auto;
}

.course-duration {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 25px;
    background: var(--ivory);
    border-radius: 50px;
    color: var(--prussian-blue);
    font-weight: 500;
}

.course-duration i {
    color: var(--bright-amber);
}

/* Description */
.description-section {
    max-width: 700px;
    margin: 0 auto 40px;
    text-align: center;
}

.certificate-description {
    font-size: 1.1rem;
    color: var(--text-secondary);
    line-height: 1.8;
    font-style: italic;
}

/* Details Grid */
.details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 30px;
    margin-bottom: 50px;
    background: var(--ivory);
    padding: 30px;
    border-radius: 20px;
}

.detail-item {
    text-align: center;
}

.detail-label {
    font-size: 0.9rem;
    color: var(--khaki-beige);
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 8px;
}

.detail-value {
    font-size: 1.2rem;
    font-weight: 600;
    color: var(--prussian-blue);
}

.text-warning {
    color: var(--bright-amber);
}

.badge-expired {
    display: inline-block;
    padding: 2px 8px;
    background: rgba(251, 198, 12, 0.2);
    border-radius: 20px;
    font-size: 0.8rem;
    margin-left: 8px;
    color: var(--khaki-beige);
}

/* Signatures */
.signatures-section {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
    margin-bottom: 40px;
}

.signature-item {
    text-align: center;
}

.signature-line {
    width: 200px;
    height: 2px;
    background: var(--bright-amber);
    margin: 0 auto 15px;
    position: relative;
}

.signature-line::after {
    content: '';
    position: absolute;
    top: -3px;
    left: 50%;
    transform: translateX(-50%);
    width: 8px;
    height: 8px;
    background: var(--bright-amber);
    border-radius: 50%;
}

.signature-name {
    font-weight: 600;
    color: var(--prussian-blue);
    margin-bottom: 5px;
    font-size: 1.1rem;
}

.signature-title {
    font-size: 0.9rem;
    color: var(--khaki-beige);
}

.signature-seal {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
}

.signature-seal i {
    font-size: 40px;
    color: var(--bright-amber);
}

.signature-seal span {
    font-weight: 700;
    color: var(--prussian-blue);
    letter-spacing: 2px;
}

/* Verification Note */
.verification-note {
    text-align: center;
    padding: 20px;
    background: linear-gradient(135deg, var(--prussian-blue), var(--regal-navy));
    color: var(--pure-white);
    border-radius: 50px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    font-size: 0.95rem;
}

.verification-note i {
    color: var(--bright-amber);
}

.verification-note a {
    color: var(--bright-amber);
    text-decoration: none;
    font-weight: 600;
}

.verification-note a:hover {
    text-decoration: underline;
}

/* Share Section */
.share-section {
    text-align: center;
}

.share-section h4 {
    font-size: 1.3rem;
    color: var(--prussian-blue);
    margin-bottom: 20px;
}

.share-buttons {
    display: flex;
    gap: 15px;
    justify-content: center;
    flex-wrap: wrap;
}

.share-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 25px;
    border-radius: 50px;
    text-decoration: none;
    color: white;
    font-weight: 500;
    transition: all 0.3s ease;
}

.share-btn.facebook {
    background: #1877f2;
}

.share-btn.twitter {
    background: #1da1f2;
}

.share-btn.linkedin {
    background: #0077b5;
}

.share-btn.whatsapp {
    background: #25d366;
}

.share-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}

/* Print Styles */
@media print {
    .certificate-actions,
    .share-section,
    .btn,
    .certificate-wrapper {
        background: white;
        padding: 0;
    }

    .certificate-card {
        box-shadow: none;
        border: 2px solid #ddd;
        page-break-inside: avoid;
    }

    .certificate-card:hover {
        transform: none;
    }

    .certificate-badge i,
    .recipient-decoration i,
    .course-duration i {
        color: black !important;
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .certificate-card {
        padding: 30px;
    }

    .certificate-main-title {
        font-size: 2.2rem;
    }

    .recipient-name {
        font-size: 2.2rem;
    }

    .course-title {
        font-size: 1.6rem;
    }

    .signatures-section {
        grid-template-columns: 1fr;
        gap: 30px;
    }

    .signature-line {
        width: 150px;
    }

    .certificate-actions {
        flex-direction: column;
        align-items: stretch;
    }

    .action-buttons {
        justify-content: center;
    }

    .share-buttons {
        flex-direction: column;
        align-items: stretch;
    }

    .share-btn {
        justify-content: center;
    }

    .details-grid {
        grid-template-columns: 1fr;
        gap: 15px;
    }

    .verification-note {
        flex-direction: column;
        text-align: center;
    }
}

@media (max-width: 480px) {
    .certificate-card {
        padding: 20px;
    }

    .certificate-main-title {
        font-size: 1.8rem;
    }

    .recipient-name {
        font-size: 1.8rem;
    }

    .course-title {
        font-size: 1.4rem;
    }

    .decoration-line {
        width: 40px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add animation on scroll
    const certificateCard = document.getElementById('certificate-card');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    });

    if (certificateCard) {
        certificateCard.style.opacity = '0';
        certificateCard.style.transform = 'translateY(20px)';
        certificateCard.style.transition = 'all 0.6s ease';
        observer.observe(certificateCard);
    }

    // Confetti effect for first-time viewing (optional)
    @if(session('showConfetti'))
    setTimeout(() => {
        confetti({
            particleCount: 100,
            spread: 70,
            origin: { y: 0.6 }
        });
    }, 500);
    @endif
});
</script>
@endsection