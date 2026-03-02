@extends('layouts.admin')

@section('title', 'Create Course')
@section('page-title', 'Create New Course')

@section('content')
<!-- Header Section -->
<div class="header-section">
    <div class="header-content">
        <h2>Create New Course</h2>
        <p>Fill in the details below to create your course</p>
    </div>
    <div class="header-actions">
        <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back to Courses
        </a>
    </div>
</div>

<!-- Create Form -->
<div class="form-wrapper">
    <form action="{{ route('admin.courses.store') }}" method="POST" enctype="multipart/form-data" class="course-form">
        @csrf

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
                            value="{{ old('title') }}"
                            placeholder="e.g., Complete Web Development Bootcamp 2024"
                            required
                            maxlength="100"
                            id="titleInput">
                        @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="char-counter"><span id="titleCounter">0</span>/100</div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="form-label">
                            Category <span class="text-danger">*</span>
                        </label>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="" disabled selected>Select category</option>
                            @foreach($categories ?? [] as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                            required
                            id="descriptionInput">{{ old('description') }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="char-counter"><span id="descCounter">0</span>/5000</div>
                    </div>
                </div>

                <!-- Excerpt -->
                <div class="col-12">
                    <div class="form-group">
                        <label class="form-label">Excerpt (Short Description)</label>
                        <textarea name="excerpt" class="form-control" rows="3" maxlength="500" placeholder="A brief summary of your course (max 500 characters)">{{ old('excerpt') }}</textarea>
                        <div class="char-counter"><span id="excerptCounter">0</span>/500</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Course Content Details Section -->
        <div class="form-section">
            <div class="section-header">
                <div class="section-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div>
                    <h3>Course Details</h3>
                    <p>What students will learn and need</p>
                </div>
            </div>

            <div class="row g-4">
                <!-- What You'll Learn -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">What You'll Learn</label>
                        <textarea name="what_you_will_learn" class="form-control" rows="5" placeholder="Enter each learning outcome on a new line&#10;e.g.:&#10;• Build complete web applications&#10;• Master PHP and Laravel&#10;• Deploy applications to production">{{ old('what_you_will_learn') }}</textarea>
                        <div class="form-hint">
                            <i class="fas fa-info-circle"></i> Enter each point on a new line. Bullet points will be added automatically.
                        </div>
                    </div>
                </div>

                <!-- Prerequisites -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Prerequisites</label>
                        <textarea name="prerequisites" class="form-control" rows="5" placeholder="What students need to know before taking this course&#10;e.g.:&#10;• Basic HTML knowledge&#10;• Familiarity with CSS&#10;• JavaScript fundamentals">{{ old('prerequisites') }}</textarea>
                        <div class="form-hint">
                            <i class="fas fa-info-circle"></i> Enter each prerequisite on a new line.
                        </div>
                    </div>
                </div>

                <!-- Requirements -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Requirements</label>
                        <textarea name="requirements" class="form-control" rows="4" placeholder="Technical requirements, software, etc.&#10;e.g.:&#10;• Computer with 8GB RAM&#10;• Internet connection&#10;• Code editor (VS Code recommended)">{{ old('requirements') }}</textarea>
                    </div>
                </div>

                <!-- Target Audience -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Target Audience</label>
                        <textarea name="target_audience" class="form-control" rows="4" placeholder="Who is this course for?&#10;e.g.:&#10;• Beginner developers&#10;• Career switchers&#10;• Self-taught programmers">{{ old('target_audience') }}</textarea>
                    </div>
                </div>

                <!-- Material Includes -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Material Includes</label>
                        <textarea name="material_includes" class="form-control" rows="4" placeholder="What's included&#10;e.g.:&#10;• 20 hours on-demand video&#10;• 15 articles&#10;• 10 downloadable resources">{{ old('material_includes') }}</textarea>
                    </div>
                </div>

                <!-- Language -->
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label">Language</label>
                        <input type="text" name="language" class="form-control" value="{{ old('language', 'English') }}" placeholder="e.g., English, Spanish">
                    </div>
                </div>

                <!-- Level -->
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label">Course Level</label>
                        <select name="level" class="form-select">
                            <option value="beginner" {{ old('level') == 'beginner' ? 'selected' : '' }}>Beginner</option>
                            <option value="intermediate" {{ old('level') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                            <option value="advanced" {{ old('level') == 'advanced' ? 'selected' : '' }}>Advanced</option>
                            <option value="all-levels" {{ old('level') == 'all-levels' ? 'selected' : '' }}>All Levels</option>
                        </select>
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
                    <h3>Course Type</h3>
                    <p>Select whether this course is free or requires subscription</p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label">Course Type <span class="text-danger">*</span></label>
                        <div class="course-type-options">
                            <label class="type-option">
                                <input type="radio" name="course_type" value="paid" {{ old('course_type', 'paid') == 'paid' ? 'checked' : '' }} id="typePaid">
                                <div class="type-content">
                                    <i class="fas fa-crown"></i>
                                    <span>Subscription Required</span>
                                    <small>Users need a subscription to access</small>
                                </div>
                            </label>
                            <label class="type-option">
                                <input type="radio" name="course_type" value="free" {{ old('course_type') == 'free' ? 'checked' : '' }} id="typeFree">
                                <div class="type-content">
                                    <i class="fas fa-gift"></i>
                                    <span>Free Course</span>
                                    <small>Completely free for all users</small>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Price fields (for display only, not used for payment) -->
                <div class="col-md-6" id="priceField" style="display: none;">
                    <div class="form-group">
                        <label class="form-label">
                            Display Price ($) <span class="label-hint">(Optional, for reference only)</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number"
                                name="price"
                                id="priceInput"
                                class="form-control"
                                value="{{ old('price', '49.99') }}"
                                step="0.01"
                                min="0"
                                placeholder="49.99">
                        </div>
                        <div class="form-hint">
                            <i class="fas fa-info-circle"></i> This is for display only. Users pay a one-time subscription for all courses.
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
                    <p>Upload course thumbnail and promotional media</p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="form-label">Course Thumbnail <span class="text-danger">*</span></label>
                        <div class="upload-area" id="thumbnailUpload">
                            <input type="file"
                                name="thumbnail"
                                id="thumbnailInput"
                                class="upload-input @error('thumbnail') is-invalid @enderror"
                                accept="image/jpeg,image/png,image/jpg,image/webp"
                                required>
                            <div class="upload-content">
                                <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                <h5>Upload Thumbnail</h5>
                                <p class="upload-text">Drag & drop or click to browse</p>
                                <p class="upload-hint">Recommended: 1280x720px (16:9), max 2MB</p>
                                <p class="upload-hint">Formats: JPG, PNG, WEBP</p>
                            </div>
                            <div class="upload-preview" id="thumbnailPreview" style="display: none;">
                                <img src="" alt="Thumbnail preview">
                                <button type="button" class="remove-upload" onclick="removeThumbnail()">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
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
                                class="upload-input @error('video_intro') is-invalid @enderror"
                                accept="video/mp4,video/webm">
                            <div class="upload-content">
                                <i class="fas fa-video upload-icon"></i>
                                <h5>Upload Intro Video</h5>
                                <p class="upload-text">MP4, WebM (max 50MB)</p>
                                <p class="upload-hint">A short preview of your course (30-60 seconds recommended)</p>
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
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">
                            Status <span class="text-danger">*</span>
                        </label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                        </select>
                        <div class="form-hint">
                            <i class="fas fa-info-circle"></i>
                            Draft: Only visible to admins | Published: Visible to everyone | Archived: Hidden
                        </div>
                        @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">Tags</label>
                        <select name="tags[]" class="tag-select" multiple>
                            @foreach($tags ?? [] as $tag)
                            <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', [])) ? 'selected' : '' }}>
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

                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">Instructor</label>
                        <select name="instructor_id" class="form-select">
                            <option value="{{ auth()->id() }}" selected>{{ auth()->user()->name }} (You)</option>
                            @if(auth()->user()->isAdmin() && isset($instructors))
                            @foreach($instructors as $instructor)
                            <option value="{{ $instructor->id }}">{{ $instructor->name }}</option>
                            @endforeach
                            @endif
                        </select>
                        <div class="form-hint">Select the course instructor</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-check">
                        <input type="checkbox" name="featured" id="featured" class="form-check-input" value="1" {{ old('featured') ? 'checked' : '' }}>
                        <label for="featured" class="form-check-label">
                            <strong>Featured Course</strong>
                            <span class="d-block text-muted small">Display this course prominently on the homepage</span>
                        </label>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-check">
                        <input type="checkbox" name="popular" id="popular" class="form-check-input" value="1" {{ old('popular') ? 'checked' : '' }}>
                        <label for="popular" class="form-check-label">
                            <strong>Popular Course</strong>
                            <span class="d-block text-muted small">Mark as popular to highlight in course listings</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- SEO Section -->
        <div class="form-section">
            <div class="section-header">
                <div class="section-icon">
                    <i class="fas fa-search"></i>
                </div>
                <div>
                    <h3>SEO Settings</h3>
                    <p>Optimize your course for search engines</p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-12">
                    <div class="form-group">
                        <label class="form-label">SEO Title</label>
                        <input type="text" name="seo_title" class="form-control" value="{{ old('seo_title') }}" maxlength="255" placeholder="Custom title for search engines">
                        <div class="char-counter"><span id="seoTitleCounter">0</span>/255</div>
                        <div class="form-hint">Leave empty to use course title</div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <label class="form-label">SEO Description</label>
                        <textarea name="seo_description" class="form-control" rows="3" maxlength="500" placeholder="Meta description for search engines">{{ old('seo_description') }}</textarea>
                        <div class="char-counter"><span id="seoDescCounter">0</span>/500</div>
                        <div class="form-hint">Leave empty to use course excerpt or description</div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <label class="form-label">SEO Keywords</label>
                        <input type="text" name="seo_keywords" class="form-control" value="{{ old('seo_keywords') }}" placeholder="course, learning, education, web development, ...">
                        <div class="form-hint">Separate keywords with commas</div>
                    </div>
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
                    <i class="fas fa-save"></i> Create Course
                </button>
                <button type="submit" name="save_and_continue" value="1" class="btn btn-outline-primary">
                    <i class="fas fa-edit"></i> Save & Continue Editing
                </button>
            </div>
        </div>
    </form>
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
        min-height: 250px;
        display: flex;
        align-items: center;
        justify-content: center;
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
        z-index: 10;
    }

    .remove-upload:hover {
        background: var(--danger);
        transform: scale(1.1);
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

    /* Tag Select */
    .tag-select {
        width: 100%;
        min-height: 100px;
        border: 1px solid #e9ecef;
        border-radius: 10px;
        padding: 8px;
    }

    .select2-container--default .select2-selection--multiple {
        border: 1px solid #e9ecef;
        border-radius: 10px;
        min-height: 50px;
    }

    .select2-container--default.select2-container--focus .select2-selection--multiple {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(1, 123, 254, 0.1);
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

    .btn-outline-primary {
        border: 2px solid var(--primary);
        color: var(--primary);
    }

    .btn-outline-primary:hover {
        background: var(--primary);
        color: white;
        transform: translateY(-2px);
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
            width: 100%;
        }

        .course-form {
            padding: 20px;
        }

        .section-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .course-type-options {
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

        .type-option {
            min-width: 100%;
        }
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
        $('#titleInput').on('input', function() {
            $('#titleCounter').text($(this).val().length);
        });

        $('#descriptionInput').on('input', function() {
            $('#descCounter').text($(this).val().length);
        });

        $('textarea[name="excerpt"]').on('input', function() {
            $('#excerptCounter').text($(this).val().length);
        });

        $('input[name="seo_title"]').on('input', function() {
            $('#seoTitleCounter').text($(this).val().length);
        });

        $('textarea[name="seo_description"]').on('input', function() {
            $('#seoDescCounter').text($(this).val().length);
        });

        // Initialize counters with old values if any
        $('#titleCounter').text($('#titleInput').val().length);
        $('#descCounter').text($('#descriptionInput').val().length);
        $('#excerptCounter').text($('textarea[name="excerpt"]').val().length);
        $('#seoTitleCounter').text($('input[name="seo_title"]').val().length);
        $('#seoDescCounter').text($('textarea[name="seo_description"]').val().length);

        // Form validation
        $('.course-form').on('submit', function(e) {
            let isValid = true;
            let errors = [];

            // Title validation
            const title = $('#titleInput').val();
            if (!title || title.length < 5) {
                isValid = false;
                errors.push('Title must be at least 5 characters');
                $('#titleInput').addClass('is-invalid');
            } else {
                $('#titleInput').removeClass('is-invalid');
            }

            // Description validation
            const description = $('#descriptionInput').val();
            if (!description || description.length < 50) {
                isValid = false;
                errors.push('Description must be at least 50 characters');
                $('#descriptionInput').addClass('is-invalid');
            } else {
                $('#descriptionInput').removeClass('is-invalid');
            }

            // Thumbnail validation
            const thumbnail = $('#thumbnailInput').val();
            if (!thumbnail && !$('#thumbnailPreview').is(':visible')) {
                isValid = false;
                errors.push('Course thumbnail is required');
                $('#thumbnailUpload').addClass('border-danger');
            } else {
                $('#thumbnailUpload').removeClass('border-danger');
            }

            // Price validation for paid courses
            if ($('#typePaid').is(':checked')) {
                const price = parseFloat($('#priceInput').val());
                if (!price || price <= 0) {
                    isValid = false;
                    errors.push('Price must be a positive number for paid courses');
                    $('#priceInput').addClass('is-invalid');
                } else {
                    $('#priceInput').removeClass('is-invalid');
                }

                // Sale price validation (if provided)
                const salePrice = parseFloat($('#salePriceInput').val());
                if (salePrice && salePrice > price) {
                    isValid = false;
                    errors.push('Sale price cannot be greater than regular price');
                    $('#salePriceInput').addClass('is-invalid');
                } else {
                    $('#salePriceInput').removeClass('is-invalid');
                }
            }

            if (!isValid) {
                e.preventDefault();
                let errorHtml = '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                errorHtml += '<strong>Please fix the following errors:</strong><ul>';
                errors.forEach(error => {
                    errorHtml += '<li>' + error + '</li>';
                });
                errorHtml += '</ul>';
                errorHtml += '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
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
            // Check file size
            if (file.size > 2 * 1024 * 1024) {
                alert('File size must be less than 2MB');
                this.value = '';
                return;
            }

            // Check file type
            const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
            if (!validTypes.includes(file.type)) {
                alert('Please upload a valid image file (JPG, PNG, WEBP)');
                this.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                $('#thumbnailPreview img').attr('src', e.target.result);
                $('#thumbnailPreview').show();
                $('#thumbnailUpload .upload-content').hide();
            }
            reader.readAsDataURL(file);
        }
    });

    function removeThumbnail() {
        $('#thumbnailInput').val('');
        $('#thumbnailPreview').hide();
        $('#thumbnailUpload .upload-content').show();
    }

    // Video upload feedback
    $('#videoInput').on('change', function() {
        const file = this.files[0];
        if (file) {
            // Check file size
            if (file.size > 50 * 1024 * 1024) {
                alert('File size must be less than 50MB');
                this.value = '';
                return;
            }

            // Check file type
            const validTypes = ['video/mp4', 'video/webm'];
            if (!validTypes.includes(file.type)) {
                alert('Please upload a valid video file (MP4, WebM)');
                this.value = '';
                return;
            }

            const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
            $('#videoUpload .upload-content h5').text('Selected: ' + file.name);
            $('#videoUpload .upload-content p:first').text(sizeMB + 'MB');
            $('#videoUpload .upload-content .upload-hint').text('Click to change');
        } else {
            $('#videoUpload .upload-content h5').text('Upload Intro Video');
            $('#videoUpload .upload-content p:first').text('MP4, WebM (max 50MB)');
            $('#videoUpload .upload-content .upload-hint').text('A short preview of your course');
        }
    });

    // Toggle price fields based on course type (for display only)
    function togglePriceFields() {
        const isFree = document.getElementById('typeFree').checked;
        const priceField = document.getElementById('priceField');

        if (isFree) {
            priceField.style.display = 'none';
        } else {
            priceField.style.display = 'block';
        }
    }

    document.getElementById('typePaid').addEventListener('change', togglePriceFields);
    document.getElementById('typeFree').addEventListener('change', togglePriceFields);
    togglePriceFields();
    // Add event listeners
    document.getElementById('typePaid').addEventListener('change', togglePriceFields);
    document.getElementById('typeFree').addEventListener('change', togglePriceFields);

    // Initialize on page load
    togglePriceFields();

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
</script>
@endpush