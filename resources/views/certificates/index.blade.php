@extends('layouts.main')

@section('title', 'My Certificates')

@section('content')
<div class="certificates-page">
    <!-- Header Section -->
    <div class="page-header">
        <div class="container">
            <div class="header-content">
                <h1 class="page-title">My Certificates</h1>
                <p class="page-description">View and download all your course completion certificates</p>
            </div>
        </div>
    </div>

    <!-- Certificates Grid -->
    <div class="container">
        @if($certificates->count() > 0)
            <div class="certificates-grid">
                @foreach($certificates as $certificate)
                    <div class="certificate-card">
                        <!-- Certificate Preview -->
                        <div class="certificate-preview">
                            <div class="preview-badge">
                                <i class="fas fa-certificate"></i>
                            </div>
                            <div class="preview-content">
                                <h3 class="course-title">{{ $certificate->course->title }}</h3>
                                <p class="issue-date">Issued: {{ $certificate->issue_date->format('F d, Y') }}</p>
                                @if($certificate->expiry_date)
                                    <p class="expiry-date {{ $certificate->is_expired ? 'expired' : '' }}">
                                        Valid until: {{ $certificate->expiry_date->format('F d, Y') }}
                                        @if($certificate->is_expired)
                                            <span class="badge expired">Expired</span>
                                        @endif
                                    </p>
                                @endif
                            </div>
                        </div>

                        <!-- Certificate Details -->
                        <div class="certificate-details">
                            <div class="certificate-number">
                                <i class="fas fa-hashtag"></i>
                                <span>{{ $certificate->certificate_number }}</span>
                            </div>
                            <div class="recipient-name">
                                <i class="fas fa-user"></i>
                                <span>{{ $certificate->user->name }}</span>
                            </div>
                        </div>

                        <!-- Certificate Actions -->
                        <div class="certificate-actions">
                            <a href="{{ route('certificates.show', $certificate->id) }}" class="btn-view">
                                <i class="fas fa-eye"></i>
                                <span>View</span>
                            </a>
                            <a href="{{ route('certificates.download', $certificate->id) }}" class="btn-download">
                                <i class="fas fa-download"></i>
                                <span>Download PDF</span>
                            </a>
                            <button onclick="shareCertificate('{{ $certificate->certificate_number }}')" class="btn-share">
                                <i class="fas fa-share-alt"></i>
                                <span>Share</span>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="pagination-wrapper">
                {{ $certificates->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-certificate"></i>
                </div>
                <h2>No Certificates Yet</h2>
                <p>Complete your first course to earn a certificate and showcase your achievement!</p>
                <a href="{{ route('courses') }}" class="btn-browse">
                    <i class="fas fa-book-open"></i>
                    <span>Browse Courses</span>
                </a>
            </div>
        @endif
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
    --danger-red: #ef4444;
}

/* Page Layout */
.certificates-page {
    min-height: 100vh;
    background: linear-gradient(135deg, var(--ivory) 0%, var(--pure-white) 100%);
    padding-bottom: 60px;
}

/* Header Section */
.page-header {
    background: var(--gradient-1);
    padding: 60px 0;
    margin-bottom: 40px;
    position: relative;
    overflow: hidden;
}

.page-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 200%;
    background: radial-gradient(circle, rgba(251,198,12,0.1) 0%, transparent 70%);
    transform: rotate(30deg);
}

.page-header::after {
    content: '';
    position: absolute;
    bottom: -50%;
    left: -50%;
    width: 100%;
    height: 200%;
    background: radial-gradient(circle, rgba(90,209,228,0.1) 0%, transparent 70%);
    transform: rotate(-30deg);
}

.header-content {
    position: relative;
    z-index: 1;
    text-align: center;
    color: var(--pure-white);
}

.page-title {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 15px;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
}

.page-description {
    font-size: 1.1rem;
    opacity: 0.9;
    max-width: 600px;
    margin: 0 auto;
}

/* Certificates Grid */
.certificates-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 30px;
    margin-bottom: 40px;
}

/* Certificate Card */
.certificate-card {
    background: var(--pure-white);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(10, 29, 68, 0.1);
    transition: all 0.3s ease;
    border: 1px solid rgba(251, 198, 12, 0.1);
    position: relative;
}

.certificate-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(10, 29, 68, 0.15);
    border-color: var(--bright-amber);
}

/* Certificate Preview */
.certificate-preview {
    padding: 30px;
    background: linear-gradient(135deg, var(--prussian-blue), var(--regal-navy));
    position: relative;
    display: flex;
    align-items: center;
    gap: 20px;
}

.preview-badge {
    width: 60px;
    height: 60px;
    background: var(--bright-amber);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 5px 15px rgba(251, 198, 12, 0.3);
}

.preview-badge i {
    font-size: 30px;
    color: var(--prussian-blue);
}

.preview-content {
    flex: 1;
}

.course-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: var(--pure-white);
    margin-bottom: 8px;
    line-height: 1.4;
}

.issue-date {
    font-size: 0.9rem;
    color: var(--pale-slate);
    margin-bottom: 5px;
}

.expiry-date {
    font-size: 0.9rem;
    color: var(--pale-slate);
}

.expiry-date.expired {
    color: var(--danger-red);
}

.badge.expired {
    display: inline-block;
    padding: 2px 8px;
    background: rgba(239, 68, 68, 0.2);
    border-radius: 20px;
    font-size: 0.75rem;
    margin-left: 8px;
}

/* Certificate Details */
.certificate-details {
    padding: 20px;
    background: var(--ivory);
    border-bottom: 1px solid rgba(251, 198, 12, 0.1);
}

.certificate-number,
.recipient-name {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;
    font-size: 0.95rem;
    color: var(--text-secondary);
}

.certificate-number:last-child,
.recipient-name:last-child {
    margin-bottom: 0;
}

.certificate-number i,
.recipient-name i {
    width: 20px;
    color: var(--bright-amber);
    font-size: 1rem;
}

.certificate-number span,
.recipient-name span {
    flex: 1;
    word-break: break-all;
}

/* Certificate Actions */
.certificate-actions {
    padding: 20px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}

.btn-view,
.btn-download,
.btn-share {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 10px 15px;
    border-radius: 12px;
    font-size: 0.9rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
    cursor: pointer;
    border: none;
}

.btn-view {
    background: var(--ivory);
    color: var(--prussian-blue);
    border: 1px solid var(--bright-amber);
    grid-column: span 1;
}

.btn-view:hover {
    background: var(--bright-amber);
    transform: translateY(-2px);
}

.btn-download {
    background: var(--gradient-1);
    color: var(--pure-white);
    grid-column: span 1;
}

.btn-download:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(10, 29, 68, 0.3);
}

.btn-share {
    background: var(--sky-blue);
    color: var(--pure-white);
    grid-column: span 2;
}

.btn-share:hover {
    background: var(--dark-slate);
    transform: translateY(-2px);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 80px 20px;
    max-width: 500px;
    margin: 0 auto;
}

.empty-icon {
    width: 120px;
    height: 120px;
    background: var(--ivory);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 30px;
    border: 3px dashed var(--bright-amber);
}

.empty-icon i {
    font-size: 50px;
    color: var(--bright-amber);
}

.empty-state h2 {
    font-size: 2rem;
    color: var(--prussian-blue);
    margin-bottom: 15px;
}

.empty-state p {
    font-size: 1.1rem;
    color: var(--text-secondary);
    margin-bottom: 30px;
    line-height: 1.6;
}

.btn-browse {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 15px 40px;
    background: var(--gradient-1);
    color: var(--pure-white);
    text-decoration: none;
    border-radius: 50px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 5px 20px rgba(10, 29, 68, 0.2);
}

.btn-browse:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(10, 29, 68, 0.3);
}

/* Pagination */
.pagination-wrapper {
    margin-top: 40px;
    display: flex;
    justify-content: center;
}

.pagination-wrapper .pagination {
    display: flex;
    gap: 5px;
    list-style: none;
    padding: 0;
}

.pagination-wrapper .page-item {
    margin: 0;
}

.pagination-wrapper .page-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: var(--pure-white);
    color: var(--prussian-blue);
    text-decoration: none;
    transition: all 0.3s ease;
    border: 1px solid rgba(251, 198, 12, 0.2);
}

.pagination-wrapper .page-link:hover {
    background: var(--ivory);
    border-color: var(--bright-amber);
}

.pagination-wrapper .active .page-link {
    background: var(--bright-amber);
    color: var(--prussian-blue);
    border-color: var(--bright-amber);
}

/* Responsive Design */
@media (max-width: 768px) {
    .page-title {
        font-size: 2rem;
    }

    .page-description {
        font-size: 1rem;
        padding: 0 20px;
    }

    .certificates-grid {
        grid-template-columns: 1fr;
        padding: 0 15px;
    }

    .certificate-actions {
        grid-template-columns: 1fr;
    }

    .btn-view,
    .btn-download,
    .btn-share {
        grid-column: span 1;
    }

    .empty-state {
        padding: 60px 15px;
    }

    .empty-state h2 {
        font-size: 1.5rem;
    }

    .empty-state p {
        font-size: 1rem;
    }
}

@media (max-width: 480px) {
    .certificate-preview {
        flex-direction: column;
        text-align: center;
    }

    .certificate-details {
        text-align: center;
    }

    .certificate-number,
    .recipient-name {
        justify-content: center;
    }
}

/* Share Modal (optional) */
.share-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.5);
    z-index: 1000;
    align-items: center;
    justify-content: center;
}

.share-modal.active {
    display: flex;
}

.modal-content {
    background: var(--pure-white);
    border-radius: 20px;
    padding: 30px;
    max-width: 400px;
    width: 90%;
}

.modal-header {
    text-align: center;
    margin-bottom: 20px;
}

.modal-header h3 {
    color: var(--prussian-blue);
    margin-bottom: 5px;
}

.modal-header p {
    color: var(--text-secondary);
    font-size: 0.9rem;
    word-break: break-all;
}

.share-options {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
    margin-bottom: 20px;
}

.share-option {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 5px;
    padding: 15px;
    border-radius: 10px;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    color: white;
}

.share-option.facebook { background: #1877f2; }
.share-option.twitter { background: #1da1f2; }
.share-option.linkedin { background: #0077b5; }
.share-option.whatsapp { background: #25d366; }

.share-option:hover {
    transform: translateY(-2px);
    opacity: 0.9;
}

.modal-close {
    width: 100%;
    padding: 12px;
    background: var(--ivory);
    border: 1px solid var(--bright-amber);
    border-radius: 10px;
    color: var(--prussian-blue);
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.modal-close:hover {
    background: var(--bright-amber);
}
</style>

<script>
function shareCertificate(certificateNumber) {
    // You can implement a share modal here
    const verifyUrl = `{{ url('/verify-certificate') }}/${certificateNumber}`;
    
    if (navigator.share) {
        navigator.share({
            title: 'My Course Certificate',
            text: 'Check out my course completion certificate from Educonecx!',
            url: verifyUrl
        }).catch(console.error);
    } else {
        // Fallback - copy to clipboard
        navigator.clipboard.writeText(verifyUrl).then(() => {
            alert('Certificate verification link copied to clipboard!');
        }).catch(() => {
            prompt('Copy this link to share your certificate:', verifyUrl);
        });
    }
}
</script>
@endsection