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
            <strong>{{ $course->total_duration ?? 'N/A' }}</strong>
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

<!-- Add Section Button -->
<div class="add-section-bar">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSectionModal">
        <i class="fas fa-plus-circle"></i> Add New Section
    </button>
</div>

<!-- Sections List -->
<div class="sections-container">
    @forelse($course->sections as $sectionIndex => $section)
    <div class="section-card" id="section-{{ $section->id }}">
        <div class="section-header">
            <div class="section-title">
                <div>
                    <h5>Section {{ $sectionIndex + 1 }}: {{ $section->title }}</h5>
                    <div class="section-meta">
                        <span><i class="far fa-file-alt"></i> {{ $section->lessons->count() }} lessons</span>
                        <span><i class="far fa-clock"></i> {{ $section->total_duration ?? '0 min' }}</span>
                    </div>
                </div>
            </div>
            <div class="section-actions">
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="editSection({{ $section->id }}, '{{ $section->title }}', '{{ $section->description }}')">
                    <i class="fas fa-edit"></i>
                </button>
                <button type="button" class="btn btn-sm btn-outline-success" onclick="addLesson({{ $section->id }})">
                    <i class="fas fa-plus"></i> Lesson
                </button>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteSection({{ $section->id }}, '{{ $section->title }}')">
                    <i class="fas fa-trash"></i>
                </button>
                <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#lessons-{{ $section->id }}">
                    <i class="fas fa-chevron-down"></i>
                </button>
            </div>
        </div>
        
        <div class="collapse show" id="lessons-{{ $section->id }}">
            <div class="lessons-list">
                @forelse($section->lessons as $lessonIndex => $lesson)
                <div class="lesson-item" id="lesson-{{ $lesson->id }}">
                    <div class="lesson-info">
                        <i class="fas fa-play-circle text-primary"></i>
                        <div>
                            <h6>{{ $lesson->title }}</h6>
                            <div class="lesson-meta">
                                <span><i class="far fa-clock"></i> {{ $lesson->duration_formatted ?? '5:00' }}</span>
                                @if($lesson->is_preview)
                                <span class="badge bg-success">Preview</span>
                                @endif
                                @if($lesson->is_free)
                                <span class="badge bg-info">Free</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="lesson-actions">
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="editLesson({{ $lesson->id }})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteLesson({{ $lesson->id }}, '{{ $lesson->title }}')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                @empty
                <div class="empty-lessons">
                    <i class="fas fa-film fa-2x text-muted mb-2"></i>
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
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description (Optional)</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
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
                        <input type="text" name="title" id="editSectionTitle" class="form-control" required>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.courses.lessons.store', $course) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="section_id" id="lessonSectionId">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Lesson</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">Lesson Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        
                        <div class="col-md-12">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Video URL</label>
                            <input type="url" name="video_url" class="form-control" placeholder="https://...">
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Video Type</label>
                            <select name="video_type" class="form-select">
                                <option value="youtube">YouTube</option>
                                <option value="vimeo">Vimeo</option>
                                <option value="local">Local</option>
                                <option value="external">External</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Duration (minutes)</label>
                            <input type="number" name="duration" class="form-control" min="0" step="1">
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control" value="0">
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-check form-check-inline">
                                <input type="checkbox" name="is_preview" class="form-check-input" id="isPreview" value="1">
                                <label class="form-check-label" for="isPreview">Preview Lesson</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="checkbox" name="is_free" class="form-check-input" id="isFree" value="1">
                                <label class="form-check-label" for="isFree">Free Lesson</label>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editLessonForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Lesson</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">Lesson Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="editLessonTitle" class="form-control" required>
                        </div>
                        
                        <div class="col-md-12">
                            <label class="form-label">Description</label>
                            <textarea name="description" id="editLessonDescription" class="form-control" rows="3"></textarea>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Video URL</label>
                            <input type="url" name="video_url" id="editLessonVideoUrl" class="form-control">
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Video Type</label>
                            <select name="video_type" id="editLessonVideoType" class="form-select">
                                <option value="youtube">YouTube</option>
                                <option value="vimeo">Vimeo</option>
                                <option value="local">Local</option>
                                <option value="external">External</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Duration (minutes)</label>
                            <input type="number" name="duration" id="editLessonDuration" class="form-control" min="0" step="1">
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Sort Order</label>
                            <input type="number" name="sort_order" id="editLessonSortOrder" class="form-control" value="0">
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-check form-check-inline">
                                <input type="checkbox" name="is_preview" id="editLessonIsPreview" class="form-check-input" value="1">
                                <label class="form-check-label" for="editLessonIsPreview">Preview Lesson</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="checkbox" name="is_free" id="editLessonIsFree" class="form-check-input" value="1">
                                <label class="form-check-label" for="editLessonIsFree">Free Lesson</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Lesson</button>
                </div>
            </form>
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
}

.lesson-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px;
    border-bottom: 1px solid #e9ecef;
    transition: background 0.3s;
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
}

.lesson-actions {
    display: flex;
    gap: 6px;
}

/* Empty States */
.empty-lessons {
    text-align: center;
    padding: 30px;
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
}
</style>
@endpush

@push('scripts')
<script>
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
    new bootstrap.Modal(document.getElementById('addLessonModal')).show();
}

// Edit Lesson
function editLesson(id) {
    // You would typically fetch lesson data via AJAX here
    // For now, just show the modal with a generic form
    document.getElementById('editLessonForm').action = '{{ route("admin.courses.lessons.update", "") }}/' + id;
    new bootstrap.Modal(document.getElementById('editLessonModal')).show();
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
</script>
@endpush