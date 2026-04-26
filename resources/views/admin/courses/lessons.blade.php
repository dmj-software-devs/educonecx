@extends('layouts.admin')

@section('title', 'Manage Lessons - ' . $course->title)
@section('page-title', 'Manage Lessons')

@section('content')
<!-- Header Section -->
<div class="header-section">
    <div class="header-content">
        <h2>{{ $course->title }}</h2>
        <p>Manage course lessons and sections</p>
    </div>
    <div class="header-actions">
        <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-outline-primary">
            <i class="fas fa-edit"></i> Edit Course
        </a>
        <a href="{{ route('admin.courses.show', $course) }}" class="btn btn-outline-info" target="_blank">
            <i class="fas fa-eye"></i> Preview
        </a>
        <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back to Courses
        </a>
    </div>
</div>

<!-- Course Info Bar -->
<div class="info-bar">
    <div class="info-bar-item">
        <i class="fas fa-book-open text-primary"></i>
        <div>
            <small>Total Sections</small>
            <strong>{{ $course->sections->count() }}</strong>
        </div>
    </div>
    <div class="info-bar-item">
        <i class="fas fa-play-circle text-success"></i>
        <div>
            <small>Total Lessons</small>
            <strong>{{ $course->sections->sum(function($section) { return $section->lessons->count(); }) }}</strong>
        </div>
    </div>
    <div class="info-bar-item">
        <i class="fas fa-clock text-warning"></i>
        <div>
            <small>Total Duration</small>
            <strong>{{ $course->formatted_duration }}</strong>
        </div>
    </div>
    <div class="info-bar-item">
        <i class="fas fa-users text-info"></i>
        <div>
            <small>Students</small>
            <strong>{{ number_format($course->total_students ?? 0) }}</strong>
        </div>
    </div>
</div>

<!-- Add Section Button and Controls -->
<div class="add-section-bar">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSectionModal">
        <i class="fas fa-plus-circle"></i> Add New Section
    </button>
    <button type="button" class="btn btn-outline-secondary" id="expandAll">
        <i class="fas fa-expand-alt"></i> Expand All
    </button>
    <button type="button" class="btn btn-outline-secondary" id="collapseAll">
        <i class="fas fa-compress-alt"></i> Collapse All
    </button>
</div>

<!-- Sections List -->
<div class="sections-container" id="sectionsContainer">
    @forelse($course->sections as $sectionIndex => $section)
    <div class="section-card" id="section-{{ $section->id }}" data-section-id="{{ $section->id }}" data-sort-order="{{ $section->sort_order }}">
        <div class="section-header">
            <div class="section-title">
                <i class="fas fa-grip-vertical drag-handle" style="cursor: move; color: #adb5bd;"></i>
                <div>
                    <h5>Section {{ $sectionIndex + 1 }}: {{ $section->title }}</h5>
                    <div class="section-meta">
                        <span><i class="far fa-file-alt"></i> {{ $section->lessons->count() }} lessons</span>
                        <span><i class="far fa-clock"></i> {{ $section->duration_formatted }}</span>
                        @if($section->published_lessons_count < $section->lessons_count)
                            <span class="badge bg-warning">{{ $section->published_lessons_count }}/{{ $section->lessons_count }} published</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="section-actions">
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="editSection({{ $section->id }}, '{{ $section->title }}', '{{ addslashes($section->description) }}')" title="Edit Section">
                    <i class="fas fa-edit"></i>
                </button>
                <button type="button" class="btn btn-sm btn-outline-success" onclick="addLesson({{ $section->id }})" title="Add Lesson">
                    <i class="fas fa-plus"></i> Lesson
                </button>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteSection({{ $section->id }}, '{{ $section->title }}')" title="Delete Section">
                    <i class="fas fa-trash"></i>
                </button>
                <button class="btn btn-sm btn-outline-secondary toggle-section" type="button" data-bs-toggle="collapse" data-bs-target="#lessons-{{ $section->id }}" title="Toggle Section">
                    <i class="fas fa-chevron-down"></i>
                </button>
            </div>
        </div>
        
        <div class="collapse show" id="lessons-{{ $section->id }}">
            <div class="lessons-list" data-section-id="{{ $section->id }}">
                @forelse($section->lessons as $lessonIndex => $lesson)
                <div class="lesson-item" id="lesson-{{ $lesson->id }}" data-lesson-id="{{ $lesson->id }}" data-sort-order="{{ $lesson->sort_order }}">
                    <div class="lesson-info">
                        <i class="fas fa-grip-vertical drag-handle" style="cursor: move; color: #adb5cd;"></i>
                        <i class="fas {{ $lesson->status == 'published' ? 'fa-play-circle text-success' : 'fa-pause-circle text-warning' }}"></i>
                        <div>
                            <h6>{{ $lesson->title }}</h6>
                            <div class="lesson-meta">
                                <span><i class="far fa-clock"></i> {{ $lesson->duration_formatted }}</span>
                                @if($lesson->is_preview)
                                <span class="badge bg-success">Preview</span>
                                @endif
                                @if($lesson->is_free)
                                <span class="badge bg-info">Free</span>
                                @endif
                                @if($lesson->status == 'draft')
                                <span class="badge bg-warning">Draft</span>
                                @endif
                                @if($lesson->video_type == 'local')
                                <span class="badge bg-secondary">Uploaded</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="lesson-actions">
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="editLesson({{ $lesson->id }})" title="Edit Lesson">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-info" onclick="previewLesson({{ $lesson->id }})" title="Preview">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteLesson({{ $lesson->id }}, '{{ $lesson->title }}')" title="Delete Lesson">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                @empty
                <div class="empty-lessons">
                    <i class="fas fa-film fa-3x text-muted mb-3"></i>
                    <p class="text-muted">No lessons in this section yet</p>
                    <button type="button" class="btn btn-sm btn-primary" onclick="addLesson({{ $section->id }})">
                        <i class="fas fa-plus"></i> Add First Lesson
                    </button>
                </div>
                @endforelse
            </div>
        </div>
    </div>
    @empty
    <div class="empty-state">
        <i class="fas fa-layer-group fa-4x text-muted mb-3"></i>
        <h5>No Sections Yet</h5>
        <p class="text-muted">Start by creating your first course section</p>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSectionModal">
            <i class="fas fa-plus-circle"></i> Create First Section
        </button>
    </div>
    @endforelse
</div>

<!-- Add Section Modal -->
<div class="modal fade" id="addSectionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.courses.sections.store', $course) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add New Section</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Section Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" required maxlength="255">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description (Optional)</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="What will students learn in this section?"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Section</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Section Modal -->
<div class="modal fade" id="editSectionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editSectionForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Section</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Section Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="editSectionTitle" class="form-control" required maxlength="255">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="editSectionDescription" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Section</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Lesson Modal -->
<div class="modal fade" id="addLessonModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{ route('admin.courses.lessons.store', $course) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="section_id" id="lessonSectionId">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Lesson</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs mb-3" id="lessonTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button" role="tab">Basic Info</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="video-tab" data-bs-toggle="tab" data-bs-target="#video" type="button" role="tab">Video & Content</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="settings-tab" data-bs-toggle="tab" data-bs-target="#settings" type="button" role="tab">Settings</button>
                        </li>
                    </ul>
                    
                    <div class="tab-content">
                        <!-- Basic Info Tab -->
                        <div class="tab-pane fade show active" id="basic" role="tabpanel">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label">Lesson Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control" required maxlength="255">
                                </div>
                                
                                <div class="col-md-12">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" class="form-control" rows="3" placeholder="Brief description of this lesson"></textarea>
                                </div>
                                
                                <div class="col-md-12">
                                    <label class="form-label">Content (Optional)</label>
                                    <textarea name="content" class="form-control" rows="5" placeholder="Additional text content, notes, or transcript"></textarea>
                                    <div class="form-hint">HTML content, notes, or lesson transcript</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Video Tab -->
                        <div class="tab-pane fade" id="video" role="tabpanel">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Video Source</label>
                                    <select name="video_type" class="form-select" id="videoType">
                                        <option value="youtube">YouTube</option>
                                        <option value="vimeo">Vimeo</option>
                                        <option value="local">Upload Video</option>
                                        <option value="external">External URL</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">Video Duration (seconds)</label>
                                    <input type="number" name="video_duration" class="form-control" min="0" step="1" placeholder="e.g., 300 for 5 minutes">
                                    <div class="form-hint">Enter duration in seconds</div>
                                </div>
                                
                                <div class="col-md-12" id="videoUrlField">
                                    <label class="form-label">Video URL</label>
                                    <input type="url" name="video_url" class="form-control" placeholder="https://www.youtube.com/watch?v=...">
                                </div>
                                
                                <div class="col-md-12" id="videoFileField" style="display: none;">
                                    <label class="form-label">Upload Video File</label>
                                    <input type="file" name="video_file" class="form-control" accept="video/mp4,video/webm">
                                    <div class="form-hint">Max size: 500MB. Supported formats: MP4, WebM</div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">Video Thumbnail</label>
                                    <input type="file" name="video_thumbnail" class="form-control" accept="image/jpeg,image/png,image/jpg">
                                    <div class="form-hint">Recommended size: 1280x720px, max 2MB</div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">Attachment (Optional)</label>
                                    <input type="file" name="attachment" class="form-control" accept=".pdf,.zip,.doc,.docx,.ppt,.pptx">
                                    <div class="form-hint">PDF, ZIP, DOC, PPT. Max size: 10MB</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Settings Tab -->
                        <div class="tab-pane fade" id="settings" role="tabpanel">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select" required>
                                        <option value="draft">Draft</option>
                                        <option value="published">Published</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">Sort Order</label>
                                    <input type="number" name="sort_order" class="form-control" value="0" min="0">
                                    <div class="form-hint">Leave 0 for auto-ordering</div>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="form-check form-switch mb-3">
                                        <input type="checkbox" name="is_preview" class="form-check-input" id="isPreview" value="1">
                                        <label class="form-check-label" for="isPreview">Preview Lesson</label>
                                        <div class="form-hint">Non-enrolled users can preview this lesson</div>
                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="form-check form-switch">
                                        <input type="checkbox" name="is_free" class="form-check-input" id="isFree" value="1">
                                        <label class="form-check-label" for="isFree">Free Lesson</label>
                                        <div class="form-hint">Available for free even in paid courses</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Lesson</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Lesson Modal -->
<div class="modal fade" id="editLessonModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="editLessonForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Lesson</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="editLessonContent">
                    <!-- Will be populated via JavaScript -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Lesson</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Preview Lesson Modal -->
<div class="modal fade" id="previewLessonModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Preview Lesson</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="previewLessonContent">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Loading preview...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p id="deleteMessage"></p>
                <p class="text-danger small">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
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

/* Info Bar */
.info-bar {
    background: white;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 30px;
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
    gap: 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.info-bar-item {
    display: flex;
    align-items: center;
    gap: 12px;
}

.info-bar-item i {
    font-size: 2rem;
}

.info-bar-item div {
    display: flex;
    flex-direction: column;
}

.info-bar-item small {
    color: #6c757d;
    font-size: 0.8rem;
}

.info-bar-item strong {
    font-size: 1.2rem;
    color: var(--dark);
}

/* Add Section Bar */
.add-section-bar {
    display: flex;
    gap: 12px;
    margin-bottom: 30px;
    flex-wrap: wrap;
}

.add-section-bar .btn {
    padding: 12px 24px;
}

/* Sections Container */
.sections-container {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

/* Section Card */
.section-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    overflow: hidden;
    transition: all 0.3s ease;
}

.section-card:hover {
    box-shadow: 0 8px 16px rgba(0,0,0,0.1);
}

.section-header {
    padding: 20px;
    background: #f8f9fa;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
    border-bottom: 1px solid #e9ecef;
}

.section-title {
    display: flex;
    align-items: center;
    gap: 12px;
    flex: 1;
}

.drag-handle {
    color: #adb5bd;
    cursor: move;
    font-size: 1.2rem;
}

.drag-handle:hover {
    color: var(--primary);
}

.section-title h5 {
    margin: 0 0 5px;
    font-weight: 600;
    color: var(--dark);
}

.section-meta {
    display: flex;
    gap: 15px;
    font-size: 0.85rem;
    color: #6c757d;
    flex-wrap: wrap;
}

.section-meta span i {
    margin-right: 4px;
}

.section-actions {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

/* Lessons List */
.lessons-list {
    padding: 10px 20px;
    background: white;
    min-height: 50px;
}

.lesson-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px;
    border-bottom: 1px solid #e9ecef;
    transition: background 0.3s;
    cursor: move;
}

.lesson-item:hover {
    background: #f8f9fa;
}

.lesson-item:last-child {
    border-bottom: none;
}

.lesson-info {
    display: flex;
    align-items: center;
    gap: 12px;
    flex: 1;
}

.lesson-info h6 {
    margin: 0 0 4px;
    font-weight: 600;
    color: var(--dark);
}

.lesson-meta {
    display: flex;
    gap: 10px;
    font-size: 0.8rem;
    color: #6c757d;
    align-items: center;
    flex-wrap: wrap;
}

.lesson-actions {
    display: flex;
    gap: 6px;
}

/* Empty States */
.empty-lessons {
    text-align: center;
    padding: 40px;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.empty-state h5 {
    color: var(--dark);
    margin-bottom: 8px;
}

/* Drag and Drop */
.sortable-ghost {
    opacity: 0.4;
    background: #e9ecef;
}

.sortable-drag {
    opacity: 0.8;
    transform: rotate(2deg);
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
}

/* Modal Tabs */
.nav-tabs .nav-link {
    color: var(--dark);
    font-weight: 500;
}

.nav-tabs .nav-link.active {
    color: var(--primary);
    border-bottom: 2px solid var(--primary);
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
    
    .info-bar {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .section-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .section-actions {
        width: 100%;
        justify-content: flex-start;
    }
    
    .lesson-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }
    
    .lesson-actions {
        width: 100%;
        justify-content: flex-end;
    }
}

@media (max-width: 576px) {
    .section-meta {
        flex-direction: column;
        gap: 5px;
    }
    
    .lesson-info {
        flex-wrap: wrap;
    }
    
    .lesson-meta {
        flex-direction: column;
        align-items: flex-start;
    }
}

/* Form Hints */
.form-hint {
    font-size: 0.85rem;
    color: #6c757d;
    margin-top: 4px;
}

/* Badges */
.badge {
    padding: 4px 8px;
    font-weight: 500;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    // Initialize Sortable for sections
    const sectionsContainer = document.getElementById('sectionsContainer');
    if (sectionsContainer) {
        new Sortable(sectionsContainer, {
            animation: 150,
            handle: '.drag-handle',
            ghostClass: 'sortable-ghost',
            dragClass: 'sortable-drag',
            onEnd: function(evt) {
                // Update sort orders
                const sections = document.querySelectorAll('.section-card');
                const order = [];
                sections.forEach((section, index) => {
                    const sectionId = section.dataset.sectionId;
                    order.push({
                        id: sectionId,
                        order: index + 1
                    });
                });
                
                // Send to server
                fetch('{{ route("admin.courses.sections.reorder") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ order: order })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update section numbers in display
                        sections.forEach((section, index) => {
                            const titleElement = section.querySelector('h5');
                            const titleText = titleElement.textContent;
                            const newTitle = titleText.replace(/Section \d+:/, `Section ${index + 1}:`);
                            titleElement.textContent = newTitle;
                        });
                    }
                });
            }
        });
    }

    // Initialize Sortable for lessons in each section
    document.querySelectorAll('.lessons-list').forEach(lessonList => {
        new Sortable(lessonList, {
            animation: 150,
            handle: '.drag-handle',
            ghostClass: 'sortable-ghost',
            dragClass: 'sortable-drag',
            group: 'lessons',
            onEnd: function(evt) {
                const sectionId = lessonList.dataset.sectionId;
                const lessons = lessonList.querySelectorAll('.lesson-item');
                const order = [];
                lessons.forEach((lesson, index) => {
                    const lessonId = lesson.dataset.lessonId;
                    order.push({
                        id: lessonId,
                        order: index + 1
                    });
                });
                
                // Send to server
                fetch('{{ route("admin.courses.lessons.reorder") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ order: order })
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        alert('Failed to reorder lessons');
                    }
                });
            }
        });
    });

    // Expand/Collapse all
    document.getElementById('expandAll')?.addEventListener('click', function() {
        document.querySelectorAll('.collapse').forEach(collapse => {
            collapse.classList.add('show');
        });
    });

    document.getElementById('collapseAll')?.addEventListener('click', function() {
        document.querySelectorAll('.collapse').forEach(collapse => {
            collapse.classList.remove('show');
        });
    });

    // Edit Section
    function editSection(id, title, description) {
        document.getElementById('editSectionTitle').value = title;
        document.getElementById('editSectionDescription').value = description;
        document.getElementById('editSectionForm').action = '{{ route("admin.courses.sections.update", "") }}/' + id;
        new bootstrap.Modal(document.getElementById('editSectionModal')).show();
    }

    // Add Lesson
    function addLesson(sectionId) {
        document.getElementById('lessonSectionId').value = sectionId;
        document.getElementById('addLessonModal').querySelector('form').reset();
        
        // Reset tabs to first tab
        const tabTrigger = new bootstrap.Tab(document.querySelector('#basic-tab'));
        tabTrigger.show();
        
        new bootstrap.Modal(document.getElementById('addLessonModal')).show();
    }

    // Edit Lesson
    function editLesson(id) {
        const modal = new bootstrap.Modal(document.getElementById('editLessonModal'));
        const contentDiv = document.getElementById('editLessonContent');
        
        // Show loading
        contentDiv.innerHTML = `
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Loading lesson data...</p>
            </div>
        `;
        
        modal.show();
        
        // Fetch lesson data
        fetch(`/admin/courses/lessons/${id}/edit-data`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                throw new Error(data.error);
            }
            
            // Build the form HTML with populated data
            const formHtml = buildEditLessonForm(data);
            contentDiv.innerHTML = formHtml;
            
            // Set the form action
            document.getElementById('editLessonForm').action = '{{ route("admin.courses.lessons.update", "") }}/' + id;
            
            // Initialize video type toggle
            initializeVideoTypeToggle();
            
            // Reinitialize any necessary plugins (like select2, etc.)
            if (typeof $ !== 'undefined' && $.fn.select2) {
                $('.select2').select2();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            contentDiv.innerHTML = `
                <div class="alert alert-danger m-3">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Failed to load lesson data. Please try again.
                    <button type="button" class="btn-close float-end" data-bs-dismiss="alert"></button>
                </div>
            `;
        });
    }

    // Build the edit lesson form HTML
    function buildEditLessonForm(data) {
        return `
            <input type="hidden" name="section_id" value="${data.section_id}">
            <ul class="nav nav-tabs mb-3" id="editLessonTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="edit-basic-tab" data-bs-toggle="tab" data-bs-target="#edit-basic" type="button" role="tab">Basic Info</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="edit-video-tab" data-bs-toggle="tab" data-bs-target="#edit-video" type="button" role="tab">Video & Content</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="edit-settings-tab" data-bs-toggle="tab" data-bs-target="#edit-settings" type="button" role="tab">Settings</button>
                </li>
            </ul>
            
            <div class="tab-content">
                <!-- Basic Info Tab -->
                <div class="tab-pane fade show active" id="edit-basic" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">Lesson Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" value="${escapeHtml(data.title)}" required maxlength="255">
                        </div>
                        
                        <div class="col-md-12">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3">${escapeHtml(data.description || '')}</textarea>
                        </div>
                        
                        <div class="col-md-12">
                            <label class="form-label">Content</label>
                            <textarea name="content" class="form-control" rows="5">${escapeHtml(data.content || '')}</textarea>
                        </div>
                    </div>
                </div>
                
                <!-- Video Tab -->
                <div class="tab-pane fade" id="edit-video" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Video Source</label>
                            <select name="video_type" class="form-select" id="editVideoType">
                                <option value="youtube" ${data.video_type == 'youtube' ? 'selected' : ''}>YouTube</option>
                                <option value="vimeo" ${data.video_type == 'vimeo' ? 'selected' : ''}>Vimeo</option>
                                <option value="local" ${data.video_type == 'local' ? 'selected' : ''}>Upload Video</option>
                                <option value="external" ${data.video_type == 'external' ? 'selected' : ''}>External URL</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Video Duration (seconds)</label>
                            <input type="number" name="video_duration" class="form-control" value="${data.video_duration || 0}" min="0" step="1">
                        </div>
                        
                        <div class="col-md-12" id="editVideoUrlField" style="${data.video_type == 'local' ? 'display:none;' : ''}">
                            <label class="form-label">Video URL</label>
                            <input type="url" name="video_url" class="form-control" value="${escapeHtml(data.video_url || '')}">
                        </div>
                        
                        <div class="col-md-12" id="editVideoFileField" style="${data.video_type == 'local' ? '' : 'display:none;'}">
                            <label class="form-label">Upload New Video File</label>
                            <input type="file" name="video_file" class="form-control" accept="video/mp4,video/webm">
                            ${data.video_url ? '<p class="small text-muted mt-1">Current video: ' + data.video_url.split('/').pop() + '</p>' : ''}
                            <div class="form-hint">Max size: 500MB. Leave empty to keep current video.</div>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Video Thumbnail</label>
                            <input type="file" name="video_thumbnail" class="form-control" accept="image/jpeg,image/png,image/jpg">
                            ${data.video_thumbnail ? '<p class="small text-muted mt-1">Current thumbnail exists</p>' : ''}
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Attachment</label>
                            <input type="file" name="attachment" class="form-control">
                            ${data.attachment ? '<p class="small text-muted mt-1">Current attachment exists</p>' : ''}
                        </div>
                    </div>
                </div>
                
                <!-- Settings Tab -->
                <div class="tab-pane fade" id="edit-settings" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="draft" ${data.status == 'draft' ? 'selected' : ''}>Draft</option>
                                <option value="published" ${data.status == 'published' ? 'selected' : ''}>Published</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control" value="${data.sort_order || 0}" min="0">
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-check form-switch mb-3">
                                <input type="checkbox" name="is_preview" class="form-check-input" id="editIsPreview" value="1" ${data.is_preview ? 'checked' : ''}>
                                <label class="form-check-label" for="editIsPreview">Preview Lesson</label>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-check form-switch">
                                <input type="checkbox" name="is_free" class="form-check-input" id="editIsFree" value="1" ${data.is_free ? 'checked' : ''}>
                                <label class="form-check-label" for="editIsFree">Free Lesson</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    // Helper function to escape HTML
    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function syncVideoSourceFields(videoTypeSelect, urlField, fileField) {
        if (!videoTypeSelect || !urlField || !fileField) return;

        const urlInput = urlField.querySelector('input[name="video_url"]');
        const fileInput = fileField.querySelector('input[name="video_file"]');
        const isLocal = videoTypeSelect.value === 'local';

        if (isLocal) {
            urlField.style.display = 'none';
            fileField.style.display = 'block';
            if (urlInput) {
                urlInput.disabled = true;
                urlInput.type = 'text';
            }
            if (fileInput) fileInput.disabled = false;
        } else {
            urlField.style.display = 'block';
            fileField.style.display = 'none';
            if (urlInput) {
                urlInput.disabled = false;
                urlInput.type = 'url';
            }
            if (fileInput) fileInput.disabled = true;
        }
    }

    // Initialize video type toggle for edit modal
    function initializeVideoTypeToggle() {
        const videoTypeSelect = document.getElementById('editVideoType');
        const urlField = document.getElementById('editVideoUrlField');
        const fileField = document.getElementById('editVideoFileField');

        syncVideoSourceFields(videoTypeSelect, urlField, fileField);

        if (videoTypeSelect) {
            videoTypeSelect.addEventListener('change', function() {
                syncVideoSourceFields(this, urlField, fileField);
            });
        }
    }

    // Preview Lesson
    function previewLesson(id) {
        const modal = new bootstrap.Modal(document.getElementById('previewLessonModal'));
        const contentDiv = document.getElementById('previewLessonContent');
        
        modal.show();
        
        // Fetch preview
        fetch(`/admin/courses/lessons/${id}/preview`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            contentDiv.innerHTML = html;
        })
        .catch(error => {
            contentDiv.innerHTML = '<div class="alert alert-danger">Failed to load preview.</div>';
        });
    }

    // Delete Section
    function deleteSection(id, title) {
        document.getElementById('deleteMessage').innerText = `Are you sure you want to delete section "${title}"? All lessons in this section will also be deleted.`;
        document.getElementById('deleteForm').action = '{{ route("admin.courses.sections.destroy", "") }}/' + id;
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    }

    // Delete Lesson
    function deleteLesson(id, title) {
        document.getElementById('deleteMessage').innerText = `Are you sure you want to delete lesson "${title}"?`;
        document.getElementById('deleteForm').action = '{{ route("admin.courses.lessons.destroy", "") }}/' + id;
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    }

    // Toggle video fields based on selection for add modal
    document.addEventListener('DOMContentLoaded', function() {
        const videoTypeSelect = document.getElementById('videoType');
        const urlField = document.getElementById('videoUrlField');
        const fileField = document.getElementById('videoFileField');

        syncVideoSourceFields(videoTypeSelect, urlField, fileField);

        if (videoTypeSelect) {
            videoTypeSelect.addEventListener('change', function() {
                syncVideoSourceFields(this, urlField, fileField);
            });
        }
    });

    // Warn before leaving if changes made
    let formChanged = false;
    document.querySelectorAll('.course-form input, .course-form textarea, .course-form select').forEach(element => {
        element.addEventListener('change', function() {
            formChanged = true;
        });
    });

    window.addEventListener('beforeunload', function(e) {
        if (formChanged) {
            e.preventDefault();
            e.returnValue = 'You have unsaved changes. Are you sure you want to leave?';
            return e.returnValue;
        }
    });

    document.querySelectorAll('.course-form').forEach(form => {
        form.addEventListener('submit', function() {
            formChanged = false;
        });
    });
</script>
@endpush
