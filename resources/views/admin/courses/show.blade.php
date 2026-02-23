@extends('layouts.admin')

@section('title', $course->title . ' - Preview')
@section('page-title', 'Course Preview')

@section('content')
<!-- Header Section -->
<div class="header-section">
    <div class="header-content">
        <h2>{{ $course->title }}</h2>
        <p>Course preview and overview</p>
    </div>
    <div class="header-actions">
        <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back to Courses
        </a>
        <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-primary">
            <i class="fas fa-edit"></i> Edit Course
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Main Content -->
    <div class="col-xl-8">
        <!-- Course Thumbnail -->
        <div class="preview-card">
            @if($course->thumbnail)
            <img src="{{ $course->thumbnail_url }}" alt="{{ $course->title }}" class="course-thumbnail">
            @else
            <div class="course-thumbnail-placeholder">
                <i class="fas fa-image fa-4x"></i>
                <p>No thumbnail uploaded</p>
            </div>
            @endif
        </div>

        <!-- Course Description -->
        <div class="preview-card mt-4">
            <div class="preview-card-header">
                <h5><i class="fas fa-align-left me-2"></i>Course Description</h5>
            </div>
            <div class="preview-card-body">
                <p class="course-description">{{ $course->description }}</p>
            </div>
        </div>

        <!-- Course Curriculum -->
        <div class="preview-card mt-4">
            <div class="preview-card-header">
                <h5><i class="fas fa-book-open me-2"></i>Course Curriculum</h5>
                <span class="badge bg-info">{{ $course->sections->count() }} sections</span>
            </div>
            <div class="preview-card-body p-0">
                @forelse($course->sections as $index => $section)
                <div class="curriculum-section">
                    <div class="section-header" data-bs-toggle="collapse" href="#section{{ $section->id }}">
                        <div>
                            <h6>Section {{ $index + 1 }}: {{ $section->title }}</h6>
                            <small class="text-muted">{{ $section->lessons->count() }} lessons</small>
                        </div>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="collapse show" id="section{{ $section->id }}">
                        <div class="lessons-list">
                            @forelse($section->lessons as $lesson)
                            <div class="lesson-item">
                                <div class="lesson-info">
                                    <i class="fas fa-play-circle text-primary"></i>
                                    <span>{{ $lesson->title }}</span>
                                </div>
                                <span class="lesson-duration">{{ $lesson->duration_formatted ?? '5:00' }}</span>
                            </div>
                            @empty
                            <div class="lesson-item text-muted">
                                <i class="fas fa-ban"></i>
                                <span>No lessons in this section</span>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-5">
                    <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                    <p class="text-muted">No curriculum added yet</p>
                    <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Add Sections
                    </a>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Instructor Info -->
        <div class="preview-card mt-4">
            <div class="preview-card-header">
                <h5><i class="fas fa-user-tie me-2"></i>Instructor</h5>
            </div>
            <div class="preview-card-body">
                <div class="instructor-info">
                    <div class="instructor-avatar">
                        {{ strtoupper(substr($course->instructor->name ?? 'Unknown', 0, 1)) }}
                    </div>
                    <div>
                        <h6 class="mb-1">{{ $course->instructor->name ?? 'Unknown Instructor' }}</h6>
                        <p class="text-muted small mb-0">{{ $course->instructor->email ?? '' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-xl-4">
        <!-- Course Info Card -->
        <div class="preview-card sticky-card">
            <div class="preview-card-header">
                <h5><i class="fas fa-info-circle me-2"></i>Course Information</h5>
            </div>
            <div class="preview-card-body">
                <div class="info-list">
                    <div class="info-item">
                        <span class="info-label">Status</span>
                        @php
                        $statusColors = [
                        'published' => 'success',
                        'draft' => 'warning',
                        'archived' => 'secondary'
                        ];
                        $statusColor = $statusColors[$course->status] ?? 'secondary';
                        @endphp
                        <span class="badge bg-{{ $statusColor }}">{{ ucfirst($course->status) }}</span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Category</span>
                        <span class="info-value">{{ $course->category->name ?? 'Uncategorized' }}</span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Level</span>
                        <span class="info-value">{{ ucfirst($course->level ?? 'All Levels') }}</span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Language</span>
                        <span class="info-value">{{ $course->language ?? 'English' }}</span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Total Students</span>
                        <span class="info-value">{{ number_format($course->total_students ?? 0) }}</span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Average Rating</span>
                        <span class="info-value">
                            <span class="rating">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <=round($course->average_rating ?? 0))
                                    <i class="fas fa-star text-warning"></i>
                                    @else
                                    <i class="far fa-star text-warning"></i>
                                    @endif
                                    @endfor
                                    ({{ number_format($course->average_rating ?? 0, 1) }})
                            </span>
                        </span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Created At</span>
                        <span class="info-value">{{ $course->created_at->format('M d, Y') }}</span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Last Updated</span>
                        <span class="info-value">{{ $course->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pricing Card -->
        <div class="preview-card mt-4">
            <div class="preview-card-header">
                <h5><i class="fas fa-tag me-2"></i>Pricing</h5>
            </div>
            <div class="preview-card-body">
                <div class="pricing-display">
                    @if($course->is_free)
                    <div class="free-course">
                        <i class="fas fa-gift fa-3x mb-3" style="color: var(--success);"></i>
                        <div class="free-label">FREE COURSE</div>
                        <p class="text-muted mt-2">No payment required</p>
                    </div>
                    @elseif($course->sale_price && $course->sale_price < $course->price)
                        <div class="original-price">${{ number_format($course->price, 2) }}</div>
                        <div class="sale-price">${{ number_format($course->sale_price, 2) }}</div>
                        <div class="discount-badge">Save ${{ number_format($course->price - $course->sale_price, 2) }}</div>
                        @else
                        <div class="regular-price">${{ number_format($course->price, 2) }}</div>
                        @endif
                </div>
            </div>
        </div>

        <!-- Tags Card -->
        @if($course->tags->count() > 0)
        <div class="preview-card mt-4">
            <div class="preview-card-header">
                <h5><i class="fas fa-tags me-2"></i>Tags</h5>
            </div>
            <div class="preview-card-body">
                <div class="tags-list">
                    @foreach($course->tags as $tag)
                    <span class="tag">{{ $tag->name }}</span>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Features Card -->
        <div class="preview-card mt-4">
            <div class="preview-card-header">
                <h5><i class="fas fa-star me-2"></i>Features</h5>
            </div>
            <div class="preview-card-body">
                <div class="features-list">
                    @if($course->featured)
                    <div class="feature-item">
                        <i class="fas fa-check-circle text-success"></i>
                        <span>Featured Course</span>
                    </div>
                    @endif
                    @if($course->popular)
                    <div class="feature-item">
                        <i class="fas fa-check-circle text-success"></i>
                        <span>Popular Course</span>
                    </div>
                    @endif
                    @if(!$course->featured && !$course->popular)
                    <p class="text-muted small mb-0">No special features</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    :root {
        --primary: #017bfe;
        --secondary: #6c5ce7;
        --success: #00b894;
        --danger: #e74c3c;
        --warning: #f39c12;
        --info: #3498db;
        --dark: #2c3e50;
    }

    /* Header Section */
    .header-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 20px;
    }

    .header-content h2 {
        font-size: 1.8rem;
        font-weight: 700;
        margin: 0 0 5px;
        color: var(--dark);
    }

    .header-content p {
        margin: 0;
        color: #6c757d;
        font-size: 0.95rem;
    }

    .header-actions {
        display: flex;
        gap: 12px;
    }

    .header-actions .btn {
        padding: 10px 20px;
        font-weight: 500;
    }

    /* Preview Cards */
    .preview-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .preview-card-header {
        padding: 20px 24px;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #f8f9fa;
    }

    .preview-card-header h5 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--dark);
    }

    .preview-card-body {
        padding: 24px;
    }

    /* Course Thumbnail */
    .course-thumbnail {
        width: 100%;
        height: auto;
        max-height: 400px;
        object-fit: cover;
    }

    .course-thumbnail-placeholder {
        width: 100%;
        height: 300px;
        background: #f8f9fa;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #adb5bd;
    }

    .course-thumbnail-placeholder i {
        margin-bottom: 15px;
    }

    .course-thumbnail-placeholder p {
        margin: 0;
    }

    /* Course Description */
    .course-description {
        line-height: 1.8;
        color: #495057;
        margin: 0;
        white-space: pre-line;
    }

    /* Curriculum */
    .curriculum-section {
        border-bottom: 1px solid #e9ecef;
    }

    .curriculum-section:last-child {
        border-bottom: none;
    }

    .section-header {
        padding: 16px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
        transition: background 0.3s;
    }

    .section-header:hover {
        background: #f8f9fa;
    }

    .section-header h6 {
        margin: 0 0 4px;
        font-weight: 600;
        color: var(--dark);
    }

    .lessons-list {
        background: #f8f9fa;
        padding: 8px 0;
    }

    .lesson-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 24px;
        border-bottom: 1px solid #e9ecef;
    }

    .lesson-item:last-child {
        border-bottom: none;
    }

    .lesson-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .lesson-info i {
        width: 20px;
    }

    .lesson-duration {
        color: #6c757d;
        font-size: 0.85rem;
    }

    /* Instructor Info */
    .instructor-info {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .instructor-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: 600;
    }

    /* Info List */
    .info-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 12px;
        border-bottom: 1px dashed #e9ecef;
    }

    .info-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .info-label {
        color: #6c757d;
        font-size: 0.9rem;
    }

    .info-value {
        font-weight: 500;
        color: var(--dark);
    }

    /* Pricing Display */
    .pricing-display {
        text-align: center;
    }

    .original-price {
        color: #6c757d;
        text-decoration: line-through;
        font-size: 1.2rem;
        margin-bottom: 8px;
    }

    .sale-price {
        color: var(--danger);
        font-size: 2.5rem;
        font-weight: 700;
        line-height: 1.2;
    }

    .regular-price {
        color: var(--dark);
        font-size: 2.5rem;
        font-weight: 700;
        line-height: 1.2;
    }

    .discount-badge {
        background: rgba(231, 76, 60, 0.1);
        color: var(--danger);
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 600;
        display: inline-block;
        margin-top: 12px;
    }

    /* Tags */
    .tags-list {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .tag {
        background: #f1f3f5;
        color: #495057;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
    }

    /* Features */
    .features-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .feature-item {
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--dark);
    }

    .feature-item i {
        font-size: 1.1rem;
    }

    /* Rating */
    .rating i {
        margin-right: 2px;
        font-size: 0.9rem;
    }

    /* Sticky Card */
    .sticky-card {
        position: sticky;
        top: 20px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .header-section {
            flex-direction: column;
            align-items: flex-start;
        }

        .header-actions {
            width: 100%;
        }

        .header-actions .btn {
            flex: 1;
        }

        .sticky-card {
            position: static;
        }

        .info-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 5px;
        }
    }

    @media (max-width: 576px) {
        .preview-card-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .section-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .lesson-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }

        .instructor-info {
            flex-direction: column;
            text-align: center;
        }
    }

    .free-course {
        text-align: center;
        padding: 20px;
    }

    .free-label {
        font-size: 2rem;
        font-weight: 700;
        color: var(--success);
        text-transform: uppercase;
        letter-spacing: 2px;
    }
</style>
@endpush