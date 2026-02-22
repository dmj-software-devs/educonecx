@extends('layouts.main')

@section('title', 'My Certificates - EDUCONECX | Your Achievements')

@section('meta_description', 'View and download your earned certificates from EDUCONECX. Track your achievements and showcase your learning progress.')

@push('styles')
<style>
    /* Certificates Container */
    .certificates-container {
        padding: 40px 0;
        background: var(--light);
        min-height: calc(100vh - 400px);
    }

    /* Page Header */
    .page-header {
        margin-bottom: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--dark);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .page-title i {
        color: var(--primary);
        font-size: 2rem;
        animation: float 6s ease-in-out infinite;
    }

    .stats-badge {
        background: var(--gradient-1);
        color: var(--white);
        padding: 8px 20px;
        border-radius: var(--border-radius-full);
        font-weight: 600;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 8px;
        box-shadow: var(--shadow-md);
    }

    .stats-badge i {
        font-size: 1rem;
    }

    /* Sidebar */
    .certificates-sidebar {
        background: var(--white);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-lg);
        overflow: hidden;
        position: sticky;
        top: 100px;
    }

    .sidebar-header {
        padding: 20px;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-bottom: 1px solid var(--gray-light);
    }

    .sidebar-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--dark);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .sidebar-title i {
        color: var(--primary);
    }

    .sidebar-nav {
        padding: 15px;
    }

    .nav-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 15px;
        border-radius: var(--border-radius-md);
        color: var(--gray);
        text-decoration: none;
        transition: var(--transition);
        margin-bottom: 5px;
    }

    .nav-item i {
        width: 20px;
        font-size: 1.1rem;
        transition: var(--transition);
    }

    .nav-item:hover {
        background: var(--light);
        color: var(--primary);
        transform: translateX(5px);
    }

    .nav-item.active {
        background: var(--gradient-1);
        color: var(--white);
        box-shadow: var(--shadow-md);
    }

    .nav-item.active i {
        color: var(--white);
    }

    .nav-item span {
        flex: 1;
        font-weight: 500;
    }

    .nav-badge {
        background: rgba(255, 255, 255, 0.2);
        padding: 2px 8px;
        border-radius: var(--border-radius-full);
        font-size: 0.75rem;
    }

    /* Stats Card */
    .stats-card {
        background: var(--white);
        border-radius: var(--border-radius-lg);
        padding: 20px;
        margin: 20px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--gray-light);
    }

    .stats-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid var(--gray-light);
    }

    .stats-item:last-child {
        border-bottom: none;
    }

    .stats-label {
        color: var(--gray);
        font-size: 0.9rem;
    }

    .stats-value {
        font-weight: 700;
        color: var(--primary);
        font-size: 1.1rem;
    }

    /* Achievement Banner */
    .achievement-banner {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: var(--border-radius-lg);
        padding: 30px;
        margin-bottom: 30px;
        color: var(--white);
        position: relative;
        overflow: hidden;
    }

    .achievement-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 10s ease-in-out infinite;
    }

    .achievement-banner::after {
        content: '';
        position: absolute;
        bottom: -50%;
        left: -10%;
        width: 250px;
        height: 250px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 8s ease-in-out infinite reverse;
    }

    .achievement-content {
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        gap: 30px;
        flex-wrap: wrap;
    }

    .achievement-icon {
        width: 100px;
        height: 100px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        backdrop-filter: blur(10px);
        border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .achievement-text h3 {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .achievement-text p {
        font-size: 1.1rem;
        opacity: 0.9;
        max-width: 500px;
    }

    /* Certificates Grid */
    .certificates-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
        margin-bottom: 30px;
    }

    .certificate-card {
        background: var(--white);
        border-radius: var(--border-radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-lg);
        transition: var(--transition);
        position: relative;
        border: 1px solid var(--gray-light);
    }

    .certificate-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-hover);
        border-color: transparent;
    }

    .certificate-ribbon {
        position: absolute;
        top: 20px;
        right: -30px;
        background: var(--gradient-1);
        color: var(--white);
        padding: 8px 40px;
        font-size: 0.8rem;
        font-weight: 600;
        transform: rotate(45deg);
        box-shadow: var(--shadow-md);
        z-index: 2;
    }

    .certificate-ribbon.honor {
        background: linear-gradient(135deg, #f72585 0%, #b5179e 100%);
    }

    .certificate-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 30px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .certificate-header::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .certificate-icon {
        font-size: 4rem;
        color: var(--white);
        margin-bottom: 10px;
        position: relative;
        z-index: 2;
        animation: float 6s ease-in-out infinite;
    }

    .certificate-badge {
        display: inline-block;
        padding: 5px 15px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: var(--border-radius-full);
        color: var(--white);
        font-size: 0.8rem;
        font-weight: 600;
        backdrop-filter: blur(5px);
        position: relative;
        z-index: 2;
    }

    .certificate-body {
        padding: 25px;
        text-align: center;
    }

    .certificate-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 15px;
        line-height: 1.4;
    }

    .certificate-meta {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-bottom: 20px;
        color: var(--gray);
        font-size: 0.9rem;
    }

    .certificate-meta i {
        color: var(--primary);
        margin-right: 5px;
    }

    .certificate-number {
        background: var(--light);
        padding: 10px 15px;
        border-radius: var(--border-radius-md);
        font-family: 'Monaco', 'Menlo', monospace;
        font-size: 0.9rem;
        color: var(--gray);
        margin-bottom: 20px;
        border: 1px solid var(--gray-light);
    }

    .certificate-footer {
        padding: 20px;
        border-top: 1px solid var(--gray-light);
        display: flex;
        justify-content: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    .btn-download {
        padding: 12px 25px;
        background: var(--gradient-1);
        color: var(--white);
        border-radius: var(--border-radius-full);
        text-decoration: none;
        font-size: 0.95rem;
        font-weight: 600;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-download:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .btn-share {
        padding: 12px 25px;
        background: transparent;
        color: var(--primary);
        border: 2px solid var(--primary);
        border-radius: var(--border-radius-full);
        text-decoration: none;
        font-size: 0.95rem;
        font-weight: 600;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-share:hover {
        background: var(--primary);
        color: var(--white);
        transform: translateY(-2px);
    }

    .btn-view {
        padding: 12px 25px;
        background: var(--light);
        color: var(--dark);
        border-radius: var(--border-radius-full);
        text-decoration: none;
        font-size: 0.95rem;
        font-weight: 600;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-view:hover {
        background: var(--primary);
        color: var(--white);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: var(--white);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-md);
    }

    .empty-icon {
        width: 120px;
        height: 120px;
        background: var(--light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px;
        font-size: 3.5rem;
        color: var(--gray);
        animation: float 6s ease-in-out infinite;
        position: relative;
    }

    .empty-icon::after {
        content: '';
        position: absolute;
        width: 140px;
        height: 140px;
        border: 2px dashed var(--primary);
        border-radius: 50%;
        animation: spin 20s linear infinite;
    }

    .empty-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 15px;
    }

    .empty-text {
        color: var(--gray);
        margin-bottom: 30px;
        font-size: 1.1rem;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
    }

    .empty-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 15px 40px;
        background: var(--gradient-1);
        color: var(--white);
        border-radius: var(--border-radius-full);
        text-decoration: none;
        font-weight: 600;
        transition: var(--transition);
    }

    .empty-btn:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-lg);
    }

    /* Featured Certificate */
    .featured-certificate {
        margin-bottom: 30px;
    }

    .featured-card {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border: 2px solid var(--primary);
        border-radius: var(--border-radius-lg);
        padding: 30px;
        display: flex;
        align-items: center;
        gap: 30px;
        flex-wrap: wrap;
        position: relative;
        overflow: hidden;
    }

    .featured-card::before {
        content: '★';
        position: absolute;
        top: -20px;
        right: -20px;
        font-size: 10rem;
        color: rgba(67, 97, 238, 0.1);
        font-family: serif;
        transform: rotate(15deg);
    }

    .featured-icon {
        width: 100px;
        height: 100px;
        background: var(--gradient-1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        color: var(--white);
        box-shadow: var(--shadow-lg);
        position: relative;
        z-index: 2;
    }

    .featured-content {
        flex: 1;
        position: relative;
        z-index: 2;
    }

    .featured-label {
        display: inline-block;
        padding: 5px 15px;
        background: var(--primary);
        color: var(--white);
        border-radius: var(--border-radius-full);
        font-size: 0.8rem;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .featured-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 10px;
    }

    .featured-meta {
        color: var(--gray);
        margin-bottom: 15px;
    }

    .featured-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 25px;
        background: var(--gradient-1);
        color: var(--white);
        border-radius: var(--border-radius-full);
        text-decoration: none;
        font-weight: 600;
        transition: var(--transition);
    }

    .featured-btn:hover {
        transform: translateX(5px);
        box-shadow: var(--shadow-md);
    }

    /* Pagination */
    .pagination {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-top: 30px;
    }

    .page-item {
        list-style: none;
    }

    .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 40px;
        padding: 0 10px;
        background: var(--white);
        border: 2px solid var(--gray-light);
        border-radius: var(--border-radius-md);
        color: var(--dark);
        text-decoration: none;
        transition: var(--transition);
        font-weight: 500;
    }

    .page-link:hover {
        background: var(--primary);
        color: var(--white);
        border-color: var(--primary);
    }

    .page-item.active .page-link {
        background: var(--primary);
        color: var(--white);
        border-color: var(--primary);
    }

    .page-item.disabled .page-link {
        background: var(--light);
        color: var(--gray);
        pointer-events: none;
        border-color: var(--gray-light);
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .certificates-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .achievement-content {
            flex-direction: column;
            text-align: center;
        }

        .featured-card {
            flex-direction: column;
            text-align: center;
        }

        .certificate-footer {
            flex-direction: column;
        }

        .btn-download, .btn-share, .btn-view {
            width: 100%;
            justify-content: center;
        }
    }

    /* Print Styles */
    @media print {
        .certificates-sidebar,
        .page-header .stats-badge,
        .btn-share,
        .btn-view,
        .pagination {
            display: none;
        }

        .certificate-card {
            break-inside: avoid;
            box-shadow: none;
            border: 1px solid #ddd;
        }
    }
</style>
@endpush

@section('content')
    <!-- Certificates Container -->
    <div class="certificates-container">
        <div class="container">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-lg-3 mb-4 mb-lg-0">
                    <div class="certificates-sidebar" data-aos="fade-right">
                        <div class="sidebar-header">
                            <h3 class="sidebar-title">
                                <i class="fas fa-trophy"></i>
                                My Achievements
                            </h3>
                        </div>

                        <div class="sidebar-nav">
                            <a href="{{ route('dashboard') }}" class="nav-item">
                                <i class="fas fa-home"></i>
                                <span>Dashboard</span>
                            </a>
                            <a href="{{ route('my-courses') }}" class="nav-item">
                                <i class="fas fa-book"></i>
                                <span>My Courses</span>
                            </a>
                            <a href="{{ route('my-quizzes') }}" class="nav-item">
                                <i class="fas fa-question-circle"></i>
                                <span>My Quizzes</span>
                            </a>
                            <a href="{{ route('certificates') }}" class="nav-item active">
                                <i class="fas fa-certificate"></i>
                                <span>Certificates</span>
                                @if(($certificates->total() ?? 0) > 0)
                                    <span class="nav-badge">{{ $certificates->total() }}</span>
                                @endif
                            </a>
                        </div>

                        <!-- Stats Card -->
                        <div class="stats-card">
                            <h4 style="font-size: 1rem; font-weight: 600; margin-bottom: 15px; color: var(--dark);">
                                <i class="fas fa-chart-line" style="color: var(--primary); margin-right: 8px;"></i>
                                Certificate Stats
                            </h4>
                            <div class="stats-item">
                                <span class="stats-label">Total Earned</span>
                                <span class="stats-value">{{ $certificates->total() ?? 0 }}</span>
                            </div>
                            <div class="stats-item">
                                <span class="stats-label">This Month</span>
                                <span class="stats-value">{{ $thisMonthCount ?? 0 }}</span>
                            </div>
                            <div class="stats-item">
                                <span class="stats-label">With Honors</span>
                                <span class="stats-value">{{ $honorsCount ?? 0 }}</span>
                            </div>
                        </div>

                        <!-- Share Profile Card -->
                        <div class="stats-card" style="text-align: center;">
                            <i class="fas fa-share-alt" style="font-size: 2rem; color: var(--primary); margin-bottom: 10px;"></i>
                            <h5 style="font-weight: 600; margin-bottom: 5px;">Share Your Achievements</h5>
                            <p style="font-size: 0.85rem; color: var(--gray); margin-bottom: 15px;">Showcase your certificates on LinkedIn</p>
                            <button class="btn-share" style="width: 100%; justify-content: center;" onclick="shareAllCertificates()">
                                <i class="fab fa-linkedin"></i>
                                Share Profile
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-lg-9">
                    <!-- Page Header -->
                    <div class="page-header" data-aos="fade-up">
                        <h1 class="page-title">
                            <i class="fas fa-certificate"></i>
                            My Certificates
                        </h1>
                        
                        <div class="stats-badge">
                            <i class="fas fa-award"></i>
                            {{ $certificates->total() ?? 0 }} Certificate{{ ($certificates->total() ?? 0) !== 1 ? 's' : '' }} Earned
                        </div>
                    </div>

                    <!-- Achievement Banner (shown only if user has certificates) -->
                    @if(($certificates ?? collect())->count() > 0)
                        <div class="achievement-banner" data-aos="fade-up">
                            <div class="achievement-content">
                                <div class="achievement-icon">
                                    <i class="fas fa-crown"></i>
                                </div>
                                <div class="achievement-text">
                                    <h3>Congratulations, {{ Auth::user()->first_name ?? 'Learner' }}! 🎉</h3>
                                    <p>You've earned {{ $certificates->total() }} certificate{{ ($certificates->total() ?? 0) !== 1 ? 's' : '' }}. Keep up the great work!</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Featured Certificate (if there's a recent one) -->
                    @if(($featuredCertificate ?? null) && ($certificates ?? collect())->count() > 0)
                        <div class="featured-certificate" data-aos="fade-up">
                            <div class="featured-card">
                                <div class="featured-icon">
                                    <i class="fas fa-star"></i>
                                </div>
                                <div class="featured-content">
                                    <span class="featured-label">Most Recent</span>
                                    <h3 class="featured-title">{{ $featuredCertificate->course->title ?? 'Course Title' }}</h3>
                                    <p class="featured-meta">
                                        <i class="fas fa-calendar"></i> 
                                        Issued on {{ \Carbon\Carbon::parse($featuredCertificate->issue_date ?? now())->format('F d, Y') }}
                                    </p>
                                    <a href="{{ route('certificates.show', $featuredCertificate->id ?? '#') }}" class="featured-btn">
                                        View Certificate <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Certificates Grid -->
                    @if(($certificates ?? collect())->count() > 0)
                        <div class="certificates-grid" id="certificatesGrid">
                            @foreach($certificates as $certificate)
                                <div class="certificate-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                                    @if($certificate->with_honors ?? false)
                                        <div class="certificate-ribbon honor">With Honors</div>
                                    @elseif($loop->first)
                                        <div class="certificate-ribbon">Latest</div>
                                    @endif
                                    
                                    <div class="certificate-header">
                                        <div class="certificate-icon">
                                            <i class="fas fa-certificate"></i>
                                        </div>
                                        <span class="certificate-badge">Certificate of Completion</span>
                                    </div>
                                    
                                    <div class="certificate-body">
                                        <h3 class="certificate-title">{{ $certificate->course->title ?? 'Course Title' }}</h3>
                                        
                                        <div class="certificate-meta">
                                            <span>
                                                <i class="fas fa-calendar-alt"></i>
                                                {{ \Carbon\Carbon::parse($certificate->issue_date ?? now())->format('M d, Y') }}
                                            </span>
                                            <span>
                                                <i class="fas fa-hashtag"></i>
                                                ID: {{ substr($certificate->certificate_number ?? 'CERT-001', -8) }}
                                            </span>
                                        </div>
                                        
                                        <div class="certificate-number">
                                            {{ $certificate->certificate_number ?? 'EDU-CERT-2025-001' }}
                                        </div>
                                        
                                        <div class="certificate-footer">
                                            @if($certificate->pdf_url ?? false)
                                                <a href="{{ $certificate->pdf_url }}" class="btn-download" download>
                                                    <i class="fas fa-download"></i> PDF
                                                </a>
                                            @endif
                                            
                                            <button class="btn-share" onclick="shareCertificate('{{ $certificate->certificate_number ?? '' }}')">
                                                <i class="fas fa-share-alt"></i> Share
                                            </button>
                                            
                                            <a href="{{ route('certificates.show', $certificate->id ?? '#') }}" class="btn-view">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        @if($certificates->hasPages())
                            <div class="pagination">
                                {{ $certificates->appends(request()->query())->links() }}
                            </div>
                        @endif
                    @else
                        <!-- Empty State -->
                        <div class="empty-state" data-aos="fade-up">
                            <div class="empty-icon">
                                <i class="fas fa-certificate"></i>
                            </div>
                            <h2 class="empty-title">No Certificates Yet</h2>
                            <p class="empty-text">
                                Complete courses and pass quizzes to earn certificates. Start learning today to build your achievement portfolio!
                            </p>
                            <a href="{{ route('courses') }}" class="empty-btn">
                                <i class="fas fa-graduation-cap"></i>
                                Browse Courses
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Share certificate function
        window.shareCertificate = function(certificateNumber) {
            const url = window.location.href;
            const text = `I just earned a certificate on EDUCONECX! 🎓 Check out my achievement: ${url}`;
            
            if (navigator.share) {
                navigator.share({
                    title: 'My EDUCONECX Certificate',
                    text: text,
                    url: url,
                }).catch(console.error);
            } else {
                // Fallback - copy to clipboard
                navigator.clipboard.writeText(text).then(() => {
                    showNotification('Certificate link copied to clipboard!', 'success');
                }).catch(() => {
                    showNotification('Could not share certificate', 'error');
                });
            }
        };

        // Share all certificates (profile)
        window.shareAllCertificates = function() {
            const url = window.location.href;
            const text = `Check out my learning achievements on EDUCONECX! I've earned {{ $certificates->total() ?? 0 }} certificates so far. 🎓`;
            
            // LinkedIn sharing
            const linkedinUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(url)}`;
            window.open(linkedinUrl, '_blank', 'width=600,height=400');
        };

        // Show notification
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `notification notification-${type}`;
            notification.style.cssText = `
                position: fixed;
                bottom: 20px;
                right: 20px;
                background: ${type === 'success' ? 'var(--success)' : 'var(--danger)'};
                color: white;
                padding: 12px 24px;
                border-radius: var(--border-radius-full);
                box-shadow: var(--shadow-lg);
                z-index: 9999;
                animation: slideInRight 0.3s ease;
            `;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.animation = 'slideOutRight 0.3s ease';
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, 3000);
        }

        // Add animation styles
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideInRight {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            
            @keyframes slideOutRight {
                from {
                    transform: translateX(0);
                    opacity: 1;
                }
                to {
                    transform: translateX(100%);
                    opacity: 0;
                }
            }
            
            @keyframes spin {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }
        `;
        document.head.appendChild(style);

        // Animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe certificate cards
        document.querySelectorAll('.certificate-card, .achievement-banner, .featured-card').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            observer.observe(el);
        });
    });
</script>
@endpush