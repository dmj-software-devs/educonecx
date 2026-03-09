@extends('layouts.admin')

@section('title', 'Edit Course')
@section('page-title', 'Edit Course')

@section('content')
<!-- Header Section -->
<div class="header-section">
    <div class="header-content">
        <h2>Edit Course</h2>
        <p>Update your course information</p>
    </div>
    <div class="header-actions">
        <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back to Courses
        </a>
    </div>
</div>

<!-- Edit Form -->
<div class="form-wrapper">
    <form action="{{ route('admin.courses.update', $course) }}" method="POST" enctype="multipart/form-data" class="course-form">
        @csrf
        @method('PUT')

        <!-- Basic Information Section -->
        <div class="form-section">
            <div class="section-header">
                <div class="section-icon">
                    <i class="fas fa-info-circle"></i>
                </div>
                <div>
                    <h3>Basic Information</h3>
                    <p>Essential details about your course</p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="form-group">
                        <label class="form-label">
                            Course Title <span class="text-danger">*</span>
                            <span class="label-hint">(Maximum 100 characters)</span>
                        </label>
                        <input type="text"
                            name="title"
                            class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title', $course->title) }}"
                            placeholder="e.g., Complete Web Development Bootcamp 2024"
                            required
                            maxlength="100">
                        @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="char-counter"><span id="titleCounter">{{ strlen($course->title) }}</span>/100</div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="form-label">
                            Category <span class="text-danger">*</span>
                        </label>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="" disabled>Select category</option>
                            @foreach($categories ?? [] as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id', $course->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <label class="form-label">
                            Course Description <span class="text-danger">*</span>
                            <span class="label-hint">(Minimum 50 characters)</span>
                        </label>
                        <textarea name="description"
                            class="form-control @error('description') is-invalid @enderror"
                            rows="6"
                            placeholder="Provide a detailed description of your course. Include what students will learn, prerequisites, and any other important information..."
                            required>{{ old('description', $course->description) }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="char-counter"><span id="descCounter">{{ strlen($course->description) }}</span>/5000</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pricing Section -->
        <div class="form-section">
            <div class="section-header">
                <div class="section-icon">
                    <i class="fas fa-tag"></i>
                </div>
                <div>
                    <h3>Pricing</h3>
                    <p>Set your course pricing (free or paid)</p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label">Course Type <span class="text-danger">*</span></label>
                        <div class="course-type-options">
                            <label class="type-option">
                                <input type="radio" name="course_type" value="paid" {{ old('course_type', $course->is_free ? 'free' : 'paid') == 'paid' ? 'checked' : '' }} id="typePaid">
                                <div class="type-content">
                                    <i class="fas fa-dollar-sign"></i>
                                    <span>Paid Course</span>
                                    <small>Students pay to access</small>
                                </div>
                            </label>
                            <label class="type-option">
                                <input type="radio" name="course_type" value="free" {{ old('course_type', $course->is_free ? 'free' : 'paid') == 'free' ? 'checked' : '' }} id="typeFree">
                                <div class="type-content">
                                    <i class="fas fa-gift"></i>
                                    <span>Free Course</span>
                                    <small>Completely free for students</small>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col-md-6" id="priceField">
                    <div class="form-group">
                        <label class="form-label">
                            Regular Price ($) <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number"
                                name="price"
                                id="priceInput"
                                class="form-control @error('price') is-invalid @enderror"
                                value="{{ old('price', $course->price) }}"
                                step="0.01"
                                min="0"
                                placeholder="49.99">
                        </div>
                        @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6" id="salePriceField">
                    <div class="form-group">
                        <label class="form-label">
                            Sale Price ($)
                            <span class="label-hint">(Optional)</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number"
                                name="sale_price"
                                id="salePriceInput"
                                class="form-control @error('sale_price') is-invalid @enderror"
                                value="{{ old('sale_price', $course->sale_price) }}"
                                step="0.01"
                                min="0"
                                placeholder="29.99">
                        </div>
                        @error('sale_price')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-hint">
                            <i class="fas fa-info-circle"></i>
                            @if(!$course->is_free && $course->sale_price && $course->sale_price < $course->price)
                                Currently active discount: ${{ number_format($course->sale_price, 2) }} (Save ${{ number_format($course->price - $course->sale_price, 2) }})
                                @else
                                Leave empty if no discount
                                @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Media Section -->
        <div class="form-section">
            <div class="section-header">
                <div class="section-icon">
                    <i class="fas fa-image"></i>
                </div>
                <div>
                    <h3>Course Media</h3>
                    <p>Update course thumbnail and promotional media</p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="form-label">Course Thumbnail</label>
                        <div class="upload-area" id="thumbnailUpload">
                            <input type="file"
                                name="thumbnail"
                                id="thumbnailInput"
                                class="upload-input"
                                accept="image/jpeg,image/png,image/webp">
                            <div class="upload-content" id="thumbnailContent" style="{{ $course->thumbnail ? 'display: none;' : '' }}">
                                <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                <h5>Upload New Thumbnail</h5>
                                <p class="upload-text">Drag & drop or click to browse</p>
                                <p class="upload-hint">Recommended: 1280x720px (16:9), max 2MB</p>
                            </div>
                            <div class="upload-preview" id="thumbnailPreview" style="{{ $course->thumbnail ? 'display: block;' : 'display: none;' }}">
                                <img src="{{ $course->thumbnail_url }}" alt="Current thumbnail">
                                <button type="button" class="remove-upload" onclick="removeThumbnail()">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        @if($course->thumbnail)
                        <div class="current-file d-flex align-items-center gap-2 mt-2">
                            <i class="fas fa-check-circle text-success"></i>
                            <span class="small">Current: {{ basename($course->thumbnail) }}</span>
                        </div>
                        @endif
                        @error('thumbnail')
                        <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="form-label">Intro Video (Optional)</label>
                        <div class="upload-area" id="videoUpload">
                            <input type="file"
                                name="video_intro"
                                id="videoInput"
                                class="upload-input"
                                accept="video/mp4,video/webm">
                            <div class="upload-content">
                                <i class="fas fa-video upload-icon"></i>
                                @if($course->video_intro)
                                <h5>Current: {{ basename($course->video_intro) }}</h5>
                                <p class="upload-text">Click to change video</p>
                                @else
                                <h5>Upload Intro Video</h5>
                                <p class="upload-text">MP4, WebM (max 50MB)</p>
                                @endif
                                <p class="upload-hint">A short preview of your course</p>
                            </div>
                        </div>
                        @error('video_intro')
                        <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Settings Section -->
        <div class="form-section">
            <div class="section-header">
                <div class="section-icon">
                    <i class="fas fa-cog"></i>
                </div>
                <div>
                    <h3>Course Settings</h3>
                    <p>Configure course availability and organization</p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">
                            Status <span class="text-danger">*</span>
                        </label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="draft" {{ old('status', $course->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', $course->status) == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="archived" {{ old('status', $course->status) == 'archived' ? 'selected' : '' }}>Archived</option>
                        </select>
                        <div class="form-hint">
                            <i class="fas fa-info-circle"></i>
                            @if($course->status == 'published')
                            Course is publicly visible
                            @elseif($course->status == 'draft')
                            Course is hidden from public
                            @else
                            Course is archived and hidden
                            @endif
                        </div>
                        @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Tags</label>
                        <select name="tags[]" class="tag-select" multiple>
                            @foreach($tags ?? [] as $tag)
                            <option value="{{ $tag->id }}"
                                {{ collect(old('tags', $course->tags->pluck('id')))->contains($tag->id) ? 'selected' : '' }}>
                                {{ $tag->name }}
                            </option>
                            @endforeach
                        </select>
                        <div class="form-hint">Select multiple tags to help students find your course</div>
                        @error('tags')
                        <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <label class="form-label">Course Level</label>
                        <div class="level-options">
                            <label class="level-option">
                                <input type="radio" name="level" value="beginner"
                                    {{ old('level', $course->level) == 'beginner' ? 'checked' : '' }}>
                                <div class="level-content">
                                    <i class="fas fa-seedling"></i>
                                    <span>Beginner</span>
                                    <small>No prior knowledge needed</small>
                                </div>
                            </label>
                            <label class="level-option">
                                <input type="radio" name="level" value="intermediate"
                                    {{ old('level', $course->level) == 'intermediate' ? 'checked' : '' }}>
                                <div class="level-content">
                                    <i class="fas fa-tree"></i>
                                    <span>Intermediate</span>
                                    <small>Basic knowledge required</small>
                                </div>
                            </label>
                            <label class="level-option">
                                <input type="radio" name="level" value="advanced"
                                    {{ old('level', $course->level) == 'advanced' ? 'checked' : '' }}>
                                <div class="level-content">
                                    <i class="fas fa-mountain"></i>
                                    <span>Advanced</span>
                                    <small>Expert level content</small>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-check">
                        <input type="checkbox" name="featured" id="featured" class="form-check-input" value="1"
                            {{ old('featured', $course->featured) ? 'checked' : '' }}>
                        <label for="featured" class="form-check-label">
                            <strong>Featured Course</strong>
                            <span class="d-block text-muted small">Display this course prominently on the homepage</span>
                        </label>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-check">
                        <input type="checkbox" name="popular" id="popular" class="form-check-input" value="1"
                            {{ old('popular', $course->popular) ? 'checked' : '' }}>
                        <label for="popular" class="form-check-label">
                            <strong>Popular Course</strong>
                            <span class="d-block text-muted small">Mark as popular to highlight in course listings</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Course Statistics -->
        <div class="form-section">
            <div class="section-header">
                <div class="section-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div>
                    <h3>Course Statistics</h3>
                    <p>Current performance metrics</p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-3 col-6">
                    <div class="stat-mini-card">
                        <div class="stat-mini-icon bg-soft-primary">
                            <i class="fas fa-users text-primary"></i>
                        </div>
                        <div class="stat-mini-content">
                            <span class="stat-mini-label">Students</span>
                            <span class="stat-mini-value">{{ number_format($course->total_students ?? 0) }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-6">
                    <div class="stat-mini-card">
                        <div class="stat-mini-icon bg-soft-success">
                            <i class="fas fa-star text-success"></i>
                        </div>
                        <div class="stat-mini-content">
                            <span class="stat-mini-label">Rating</span>
                            <span class="stat-mini-value">{{ number_format($course->average_rating ?? 0, 1) }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-6">
                    <div class="stat-mini-card">
                        <div class="stat-mini-icon bg-soft-info">
                            <i class="fas fa-file-alt text-info"></i>
                        </div>
                        <div class="stat-mini-content">
                            <span class="stat-mini-label">Lessons</span>
                            <span class="stat-mini-value">{{ $course->lessons_count ?? 0 }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-6">
                    <div class="stat-mini-card">
                        <div class="stat-mini-icon bg-soft-warning">
                            <i class="fas fa-clock text-warning"></i>
                        </div>
                        <div class="stat-mini-content">
                            <span class="stat-mini-label">Created</span>
                            <span class="stat-mini-value">{{ $course->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Danger Zone -->
        <div class="form-section danger-zone">
            <div class="section-header">
                <div class="section-icon bg-soft-danger">
                    <i class="fas fa-exclamation-triangle text-danger"></i>
                </div>
                <div>
                    <h3 class="text-danger">Danger Zone</h3>
                    <p class="text-muted">Irreversible actions</p>
                </div>
            </div>

            <div class="danger-actions">
                <div class="danger-action">
                    <div>
                        <h6>Archive this course</h6>
                        <p class="text-muted small">Move this course to archived status. Students will lose access.</p>
                    </div>
                    <button type="button" class="btn btn-outline-warning" onclick="archiveCourse()">
                        Archive Course
                    </button>
                </div>

                <div class="danger-action">
                    <div>
                        <h6>Delete this course</h6>
                        <p class="text-muted small">Permanently delete this course and all associated data.</p>
                    </div>
                    <button type="button" class="btn btn-outline-danger" onclick="confirmDelete()">
                        Delete Course
                    </button>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="form-actions">
            <button type="button" class="btn btn-outline-secondary" onclick="window.location.href='{{ route('admin.courses.index') }}'">
                Cancel
            </button>
            <div>
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    <i class="fas fa-save"></i> Update Course
                </button>
                <button type="submit" name="save_and_continue" value="1" class="btn btn-outline-primary">
                    <i class="fas fa-edit"></i> Save & Continue
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">Delete Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong>{{ $course->title }}</strong>?</p>
                <p class="text-danger small">This action cannot be undone. All lessons, enrollments, and related data will be permanently deleted.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Permanently</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Archive Confirmation Modal -->
<div class="modal fade" id="archiveModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-warning">Archive Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to archive <strong>{{ $course->title }}</strong>?</p>
                <p class="text-warning small">Students will lose access to this course. You can restore it later.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.courses.update', $course) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="archived">
                    <button type="submit" class="btn btn-warning">Archive Course</button>
                </form>
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

    /* Form Wrapper */
    .form-wrapper {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .course-form {
        padding: 30px;
    }

    /* Form Sections */
    .form-section {
        margin-bottom: 40px;
        padding-bottom: 40px;
        border-bottom: 1px solid #e9ecef;
    }

    .form-section:last-of-type {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 25px;
    }

    .section-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: rgba(1, 123, 254, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        font-size: 1.3rem;
    }

    .section-header h3 {
        font-size: 1.2rem;
        font-weight: 600;
        margin: 0 0 4px;
        color: var(--dark);
    }

    .section-header p {
        margin: 0;
        color: #6c757d;
        font-size: 0.9rem;
    }

    /* Form Elements */
    .form-group {
        position: relative;
    }

    .form-label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 500;
        font-size: 0.95rem;
        color: #495057;
        margin-bottom: 8px;
    }

    .label-hint {
        font-weight: 400;
        font-size: 0.8rem;
        color: #6c757d;
    }

    .form-control,
    .form-select {
        border: 1px solid #e9ecef;
        border-radius: 10px;
        padding: 12px 16px;
        font-size: 0.95rem;
        transition: all 0.3s;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(1, 123, 254, 0.1);
        outline: none;
    }

    .input-group {
        border-radius: 10px;
        overflow: hidden;
    }

    .input-group-text {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-right: none;
        color: #6c757d;
        padding: 12px 16px;
    }

    .input-group .form-control {
        border-left: none;
    }

    .char-counter {
        position: absolute;
        right: 12px;
        bottom: -20px;
        font-size: 0.8rem;
        color: #6c757d;
    }

    .form-hint {
        font-size: 0.85rem;
        color: #6c757d;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* Upload Area */
    .upload-area {
        border: 2px dashed #e9ecef;
        border-radius: 12px;
        padding: 30px;
        text-align: center;
        position: relative;
        transition: all 0.3s;
        background: #f8f9fa;
        cursor: pointer;
    }

    .upload-area:hover {
        border-color: var(--primary);
        background: rgba(1, 123, 254, 0.02);
    }

    .upload-input {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }

    .upload-icon {
        font-size: 2.5rem;
        color: var(--primary);
        margin-bottom: 15px;
    }

    .upload-content h5 {
        font-size: 1.1rem;
        font-weight: 600;
        margin: 0 0 8px;
        color: var(--dark);
    }

    .upload-text {
        color: #6c757d;
        margin: 0 0 5px;
        font-size: 0.95rem;
    }

    .upload-hint {
        color: #adb5bd;
        font-size: 0.8rem;
        margin: 0;
    }

    .upload-preview {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-radius: 12px;
        overflow: hidden;
    }

    .upload-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .remove-upload {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: rgba(231, 76, 60, 0.9);
        color: white;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s;
    }

    .remove-upload:hover {
        background: var(--danger);
        transform: scale(1.1);
    }

    /* Level Options */
    .level-options {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }

    .level-option {
        flex: 1;
        min-width: 150px;
        cursor: pointer;
    }

    .level-option input[type="radio"] {
        display: none;
    }

    .level-content {
        padding: 16px;
        border: 1px solid #e9ecef;
        border-radius: 12px;
        text-align: center;
        transition: all 0.3s;
    }

    .level-content i {
        font-size: 1.5rem;
        color: #6c757d;
        margin-bottom: 8px;
    }

    .level-content span {
        display: block;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 4px;
    }

    .level-content small {
        color: #6c757d;
        font-size: 0.8rem;
    }

    .level-option input[type="radio"]:checked+.level-content {
        border-color: var(--primary);
        background: rgba(1, 123, 254, 0.02);
    }

    .level-option input[type="radio"]:checked+.level-content i {
        color: var(--primary);
    }

    /* Checkbox */
    .form-check {
        padding: 16px;
        border: 1px solid #e9ecef;
        border-radius: 10px;
        transition: all 0.3s;
        margin: 0;
    }

    .form-check:hover {
        background: #f8f9fa;
        border-color: #dee2e6;
    }

    /* Form Actions */
    .form-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 40px;
        padding-top: 20px;
        border-top: 1px solid #e9ecef;
    }

    .form-actions .btn {
        padding: 12px 24px;
        font-weight: 500;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        border: none;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(1, 123, 254, 0.2);
    }

    /* Danger Zone */
    .danger-zone {
        background: #fff5f5;
        border-radius: 12px;
        padding: 24px;
        margin: 40px 0;
        border: 1px solid #fecaca;
    }

    .bg-soft-danger {
        background: rgba(231, 76, 60, 0.1);
    }

    .danger-actions {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .danger-action {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px;
        background: white;
        border-radius: 10px;
        border: 1px solid #f1f3f5;
        flex-wrap: wrap;
        gap: 15px;
    }

    .danger-action h6 {
        margin: 0 0 4px;
        font-size: 1rem;
    }

    .danger-action p {
        margin: 0;
    }

    /* Stat Mini Cards */
    .stat-mini-card {
        background: white;
        border-radius: 12px;
        padding: 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .stat-mini-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }

    .stat-mini-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .bg-soft-primary {
        background: rgba(1, 123, 254, 0.1);
    }

    .bg-soft-success {
        background: rgba(0, 184, 148, 0.1);
    }

    .bg-soft-info {
        background: rgba(52, 152, 219, 0.1);
    }

    .bg-soft-warning {
        background: rgba(243, 156, 18, 0.1);
    }

    .stat-mini-content {
        flex: 1;
    }

    .stat-mini-label {
        display: block;
        font-size: 0.75rem;
        color: #6c757d;
        margin-bottom: 4px;
    }

    .stat-mini-value {
        display: block;
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--dark);
        line-height: 1.2;
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

        .course-form {
            padding: 20px;
        }

        .section-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .level-options {
            flex-direction: column;
        }

        .form-actions {
            flex-direction: column;
            gap: 15px;
        }

        .form-actions>div {
            width: 100%;
            display: flex;
            gap: 10px;
        }

        .form-actions .btn {
            flex: 1;
        }

        .danger-action {
            flex-direction: column;
            align-items: flex-start;
        }

        .danger-action .btn {
            width: 100%;
        }
    }

    @media (max-width: 576px) {
        .form-section {
            padding-bottom: 30px;
            margin-bottom: 30px;
        }

        .form-actions>div {
            flex-direction: column;
        }

        .form-check {
            padding: 12px;
        }
    }

    /* Course Type Options */
    .course-type-options {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }

    .type-option {
        flex: 1;
        min-width: 200px;
        cursor: pointer;
    }

    .type-option input[type="radio"] {
        display: none;
    }

    .type-content {
        padding: 20px;
        border: 2px solid #e9ecef;
        border-radius: 12px;
        text-align: center;
        transition: all 0.3s;
    }

    .type-option input[type="radio"]:checked+.type-content {
        border-color: var(--primary);
        background: rgba(1, 123, 254, 0.02);
    }

    .type-content i {
        font-size: 2rem;
        color: #6c757d;
        margin-bottom: 10px;
    }

    .type-content span {
        display: block;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 5px;
    }

    .type-content small {
        color: #6c757d;
        font-size: 0.85rem;
    }

    .type-option input[type="radio"]:checked+.type-content i {
        color: var(--primary);
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize select2 for tags
        if ($.fn.select2) {
            $('.tag-select').select2({
                placeholder: 'Select tags',
                allowClear: true,
                width: '100%',
                tags: false
            });
        }

        // Character counters
        $('input[name="title"]').on('input', function() {
            $('#titleCounter').text($(this).val().length);
        });

        $('textarea[name="description"]').on('input', function() {
            $('#descCounter').text($(this).val().length);
        });

       // Form validation
$('.course-form').on('submit', function(e) {
    let isValid = true;
    let errors = [];

    // Title validation
    const title = $('input[name="title"]').val();
    if (!title || title.length < 5) {
        isValid = false;
        errors.push('Title must be at least 5 characters');
        $('input[name="title"]').addClass('is-invalid');
    } else {
        $('input[name="title"]').removeClass('is-invalid');
    }

    // Description validation
    const description = $('textarea[name="description"]').val();
    if (!description || description.length < 50) {
        isValid = false;
        errors.push('Description must be at least 50 characters');
        $('textarea[name="description"]').addClass('is-invalid');
    } else {
        $('textarea[name="description"]').removeClass('is-invalid');
    }

    // Price validation - ONLY if course type is paid
    const isFree = document.getElementById('typeFree').checked;
    if (!isFree) {
        const price = parseFloat($('input[name="price"]').val());
        if (!price || price <= 0) {
            isValid = false;
            errors.push('Price must be a positive number');
            $('input[name="price"]').addClass('is-invalid');
        } else {
            $('input[name="price"]').removeClass('is-invalid');
        }

        // Sale price validation (if provided)
        const salePrice = parseFloat($('input[name="sale_price"]').val());
        if (salePrice && salePrice > price) {
            isValid = false;
            errors.push('Sale price cannot be greater than regular price');
            $('input[name="sale_price"]').addClass('is-invalid');
        } else {
            $('input[name="sale_price"]').removeClass('is-invalid');
        }
    } else {
        // Clear validation errors for price fields when free
        $('input[name="price"]').removeClass('is-invalid');
        $('input[name="sale_price"]').removeClass('is-invalid');
    }

    if (!isValid) {
        e.preventDefault();
        let errorHtml = '<div class="alert alert-danger alert-dismissible fade show">';
        errorHtml += '<strong>Please fix the following errors:</strong><ul>';
        errors.forEach(error => {
            errorHtml += '<li>' + error + '</li>';
        });
        errorHtml += '</ul>';
        errorHtml += '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
        errorHtml += '</div>';

        $('.form-wrapper').prepend(errorHtml);

        // Scroll to error message
        $('html, body').animate({
            scrollTop: $('.alert-danger').offset().top - 100
        }, 500);
    }
});
    });

    // Thumbnail preview
    $('#thumbnailInput').on('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#thumbnailPreview img').attr('src', e.target.result);
                $('#thumbnailPreview').show();
                $('#thumbnailContent').hide();
            }
            reader.readAsDataURL(file);
        }
    });

    function removeThumbnail() {
        $('#thumbnailInput').val('');
        $('#thumbnailPreview').hide();
        $('#thumbnailContent').show();
    }

    // Video upload feedback
    $('#videoInput').on('change', function() {
        const file = this.files[0];
        if (file) {
            const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
            $('#videoUpload .upload-content h5').text('Selected: ' + file.name);
            $('#videoUpload .upload-content p:first').text(sizeMB + 'MB');
            $('#videoUpload .upload-content .upload-hint').text('Click to change');
        }
    });

    // Delete confirmation
    function confirmDelete() {
        $('#deleteModal').modal('show');
    }

    // Archive confirmation
    function archiveCourse() {
        $('#archiveModal').modal('show');
    }

    // Warn before leaving if changes made
    let formChanged = false;
    $('.course-form input, .course-form textarea, .course-form select').on('change', function() {
        formChanged = true;
    });

    $('.course-form .tag-select').on('change', function() {
        formChanged = true;
    });

    $(window).on('beforeunload', function() {
        if (formChanged) {
            return 'You have unsaved changes. Are you sure you want to leave?';
        }
    });

    $('.course-form').on('submit', function() {
        formChanged = false;
    });

    // Toggle price fields based on course type
    function togglePriceFields() {
        const isFree = document.getElementById('typeFree').checked;
        const priceField = document.getElementById('priceField');
        const salePriceField = document.getElementById('salePriceField');
        const priceInput = document.getElementById('priceInput');
        const salePriceInput = document.getElementById('salePriceInput');

        if (isFree) {
            priceField.style.display = 'none';
            salePriceField.style.display = 'none';
            priceInput.removeAttribute('required');
            priceInput.value = '';
            salePriceInput.value = '';
        } else {
            priceField.style.display = 'block';
            salePriceField.style.display = 'block';
            priceInput.setAttribute('required', 'required');
        }
    }

    // Add event listeners
    document.getElementById('typePaid').addEventListener('change', togglePriceFields);
    document.getElementById('typeFree').addEventListener('change', togglePriceFields);

    // Initialize on page load
    togglePriceFields();
</script>
@endpush