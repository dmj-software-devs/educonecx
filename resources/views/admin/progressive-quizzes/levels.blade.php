@extends('layouts.admin')

@section('title', 'Manage Levels - ' . $progressiveQuiz->title)
@section('page-title', 'Manage Levels: ' . $progressiveQuiz->title)

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center gap-3">
        <div class="bg-primary bg-opacity-10 rounded-3 p-3">
            <i class="fas fa-layer-group fa-2x text-primary"></i>
        </div>
        <div>
            <h2 class="mb-1">{{ $progressiveQuiz->title }}</h2>
            <p class="text-muted mb-0">
                <i class="fas fa-tasks me-2"></i>Configure progressive levels for this quiz
            </p>
        </div>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.progressive-quizzes.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i> Back to Quizzes
        </a>
        <a href="{{ route('admin.progressive-quizzes.edit', $progressiveQuiz) }}" class="btn btn-primary">
            <i class="fas fa-edit me-2"></i> Edit Quiz
        </a>
    </div>
</div>

<!-- Quiz Info Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-primary bg-opacity-10 text-primary rounded-3 p-3 me-3">
                    <i class="fas fa-layer-group fa-2x"></i>
                </div>
                <div>
                    <span class="text-muted text-uppercase small fw-bold">Total Levels</span>
                    <h3 class="mb-0 fw-bold">{{ $progressiveQuiz->levels->count() }}</h3>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-success bg-opacity-10 text-success rounded-3 p-3 me-3">
                    <i class="fas fa-question-circle fa-2x"></i>
                </div>
                <div>
                    <span class="text-muted text-uppercase small fw-bold">Total Questions</span>
                    <h3 class="mb-0 fw-bold">{{ $progressiveQuiz->total_questions }}</h3>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-warning bg-opacity-10 text-warning rounded-3 p-3 me-3">
                    <i class="fas fa-percent fa-2x"></i>
                </div>
                <div>
                    <span class="text-muted text-uppercase small fw-bold">Pass Percentage</span>
                    <h3 class="mb-0 fw-bold">{{ $progressiveQuiz->pass_percentage }}%</h3>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-info bg-opacity-10 text-info rounded-3 p-3 me-3">
                    <i class="fas fa-clock fa-2x"></i>
                </div>
                <div>
                    <span class="text-muted text-uppercase small fw-bold">Time Limit</span>
                    <h3 class="mb-0 fw-bold">{{ $progressiveQuiz->time_limit_formatted }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Level Form -->
<div class="card mb-4">
    <div class="card-header bg-white">
        <h5 class="mb-0">
            <i class="fas fa-plus-circle me-2 text-primary"></i>Add New Level
        </h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.progressive-quizzes.levels.store', $progressiveQuiz) }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-medium">Level Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                           value="{{ old('title') }}" placeholder="e.g., Beginner Level" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-medium">Badge Icon</label>
                    <input type="file" name="badge_icon" class="form-control @error('badge_icon') is-invalid @enderror" 
                           accept="image/*">
                    <small class="text-muted">Optional badge image for this level</small>
                    @error('badge_icon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-medium">Description</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                              rows="2" placeholder="Describe what this level contains...">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-medium">Min. Pass Percentage</label>
                    <div class="input-group">
                        <input type="number" name="min_percentage" class="form-control @error('min_percentage') is-invalid @enderror" 
                               value="{{ old('min_percentage', $progressiveQuiz->pass_percentage) }}" min="0" max="100">
                        <span class="input-group-text">%</span>
                    </div>
                    <small class="text-muted">Leave empty to use quiz default ({{ $progressiveQuiz->pass_percentage }}%)</small>
                    @error('min_percentage')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-medium">Time Limit (minutes)</label>
                    <input type="number" name="time_limit" class="form-control @error('time_limit') is-invalid @enderror" 
                           value="{{ old('time_limit') }}" min="1">
                    <small class="text-muted">Leave empty to use quiz time limit</small>
                    @error('time_limit')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-medium">Unlock Message</label>
                    <input type="text" name="unlock_message" class="form-control @error('unlock_message') is-invalid @enderror" 
                           value="{{ old('unlock_message') }}" placeholder="e.g., Great! Level 1 completed!">
                    @error('unlock_message')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-12 mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="pass_required" class="form-check-input" 
                               value="1" {{ old('pass_required', true) ? 'checked' : '' }} id="passRequired">
                        <label class="form-check-label" for="passRequired">
                            Must pass to unlock next level
                        </label>
                    </div>
                </div>
                
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus-circle me-2"></i>Add Level
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Levels List -->
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-list me-2 text-primary"></i>Progressive Levels
        </h5>
        <span class="badge bg-info rounded-pill px-3 py-2">{{ $progressiveQuiz->levels->count() }} Levels Total</span>
    </div>
    
    <div class="levels-list p-3" id="levelsList">
        @forelse($progressiveQuiz->levels->sortBy('level_number') as $level)
        <div class="level-card card mb-3 border-0 shadow-sm" data-id="{{ $level->id }}" data-level="{{ $level->level_number }}">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <div class="level-drag-handle text-muted" style="cursor: move;">
                        <i class="fas fa-grip-vertical fa-lg"></i>
                    </div>
                    
                    <div class="level-number bg-primary text-white rounded-pill px-3 py-2 fw-semibold" style="min-width: 100px; text-align: center;">
                        Level {{ $level->level_number }}
                    </div>
                    
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="d-flex align-items-center gap-2">
                                @if($level->badge_icon)
                                    <img src="{{ Storage::url($level->badge_icon) }}" class="rounded" width="32" height="32" style="object-fit: cover;" alt="">
                                @endif
                                <h5 class="mb-0">{{ $level->title }}</h5>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <span class="badge bg-light text-dark rounded-pill px-3 py-2">
                                    <i class="fas fa-question-circle text-primary me-1"></i> {{ $level->question_count }} Questions
                                </span>
                                <span class="badge bg-light text-dark rounded-pill px-3 py-2">
                                    <i class="fas fa-percent text-success me-1"></i> {{ $level->min_percentage }}% Pass
                                </span>
                                @if($level->time_limit)
                                <span class="badge bg-light text-dark rounded-pill px-3 py-2">
                                    <i class="fas fa-clock text-info me-1"></i> {{ $level->time_limit }} min
                                </span>
                                @endif
                            </div>
                        </div>
                        
                        @if($level->description)
                        <p class="text-muted mb-2">{{ $level->description }}</p>
                        @endif
                        
                        @if($level->unlock_message)
                        <div class="bg-success bg-opacity-10 text-success rounded-3 p-2 d-inline-flex align-items-center gap-2">
                            <i class="fas fa-unlock-alt"></i>
                            <span>"{{ $level->unlock_message }}"</span>
                        </div>
                        @endif
                    </div>
                    
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.progressive-quizzes.questions', ['progressiveQuiz' => $level->quiz->id, 'progressiveLevel' => $level->id]) }}"
                           class="btn btn-sm btn-info text-white" title="Manage Questions">
                            <i class="fas fa-list"></i>
                        </a>
                        
                        <button type="button" class="btn btn-sm btn-primary" 
                                onclick="editLevel({{ $level->id }}, '{{ addslashes($level->title) }}', '{{ addslashes($level->description) }}', {{ $level->min_percentage }}, {{ $level->time_limit ?? 'null' }}, {{ $level->pass_required ? 'true' : 'false' }}, '{{ addslashes($level->unlock_message) }}')">
                            <i class="fas fa-edit"></i>
                        </button>
                        
                        <button type="button" class="btn btn-sm btn-danger" 
                                onclick="deleteLevel({{ $level->id }}, '{{ addslashes($level->title) }}')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-5">
            <div class="bg-light rounded-circle d-inline-flex p-4 mb-3">
                <i class="fas fa-layer-group fa-3x text-muted"></i>
            </div>
            <h5>No Levels Created Yet</h5>
            <p class="text-muted mb-3">Add your first level using the form above</p>
        </div>
        @endforelse
    </div>
</div>

<!-- Edit Level Modal -->
<div class="modal fade" id="editLevelModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-edit me-2 text-primary"></i>Edit Level
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editLevelForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-medium">Level Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="edit_title" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-medium">Description</label>
                        <textarea name="description" id="edit_description" class="form-control" rows="2"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-medium">Min. Pass Percentage</label>
                        <div class="input-group">
                            <input type="number" name="min_percentage" id="edit_min_percentage" 
                                   class="form-control" min="0" max="100">
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-medium">Time Limit (minutes)</label>
                        <input type="number" name="time_limit" id="edit_time_limit" class="form-control" min="1">
                        <small class="text-muted">Leave empty to use quiz default</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-medium">Unlock Message</label>
                        <input type="text" name="unlock_message" id="edit_unlock_message" class="form-control">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-medium">Badge Icon</label>
                        <input type="file" name="badge_icon" class="form-control" accept="image/*">
                        <small class="text-muted">Upload new icon to replace existing</small>
                    </div>
                    
                    <div class="form-check">
                        <input type="checkbox" name="pass_required" class="form-check-input" value="1" id="edit_pass_required">
                        <label class="form-check-label" for="edit_pass_required">
                            Must pass to unlock next level
                        </label>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Level</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Form -->
<form id="deleteLevelForm" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('styles')
<style>
/* Additional styles for level management */
.stat-icon {
    transition: transform 0.2s;
}

.stat-card:hover .stat-icon {
    transform: scale(1.1);
}

.level-card {
    transition: all 0.3s ease;
    border-left: 4px solid transparent;
}

.level-card:hover {
    border-left-color: var(--bs-primary);
    transform: translateX(4px);
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15) !important;
}

.level-drag-handle {
    opacity: 0.5;
    transition: opacity 0.2s;
}

.level-card:hover .level-drag-handle {
    opacity: 1;
}

.sortable-ghost {
    opacity: 0.4;
    background-color: var(--bs-primary);
    border: 2px dashed var(--bs-primary);
}

.sortable-drag {
    opacity: 0.8;
    transform: rotate(2deg);
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.2);
}

.btn-info {
    background-color: #3498db;
    border-color: #3498db;
}

.btn-info:hover {
    background-color: #2980b9;
    border-color: #2980b9;
}

/* Custom badge styles */
.badge.bg-light {
    background-color: #f8f9fa !important;
    color: #495057 !important;
    font-weight: 500;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .level-card .card-body > div {
        flex-direction: column;
        align-items: flex-start !important;
    }
    
    .level-number {
        align-self: flex-start;
    }
    
    .level-card .d-flex.gap-2:last-child {
        align-self: flex-end;
        margin-top: 10px;
    }
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
// Get quiz ID from Laravel
const quizId = {{ $progressiveQuiz->id }};

// Initialize Sortable for levels
const levelsList = document.getElementById('levelsList');
if (levelsList) {
    new Sortable(levelsList, {
        handle: '.level-drag-handle',
        animation: 150,
        ghostClass: 'sortable-ghost',
        dragClass: 'sortable-drag',
        onEnd: function() {
            updateLevelsOrder();
        }
    });
}

function updateLevelsOrder() {
    const levels = document.querySelectorAll('.level-card');
    const orderData = [];
    
    levels.forEach((level, index) => {
        const id = level.getAttribute('data-id');
        orderData.push({
            id: id,
            level_number: index + 1
        });
        
        // Update level number display
        const numberBadge = level.querySelector('.level-number');
        if (numberBadge) {
            numberBadge.textContent = 'Level ' + (index + 1);
        }
    });
    
    // Send to server
    fetch('/admin/progressive-quizzes/' + quizId + '/levels/reorder', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ levels: orderData })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Levels reordered successfully', 'success');
        }
    })
    .catch(error => {
        console.error('Error reordering levels:', error);
        showNotification('Error reordering levels', 'error');
    });
}

function editLevel(id, title, description, minPercentage, timeLimit, passRequired, unlockMessage) {
    document.getElementById('edit_title').value = title;
    document.getElementById('edit_description').value = description;
    document.getElementById('edit_min_percentage').value = minPercentage;
    document.getElementById('edit_time_limit').value = timeLimit || '';
    document.getElementById('edit_unlock_message').value = unlockMessage || '';
    document.getElementById('edit_pass_required').checked = passRequired;
    
    const form = document.getElementById('editLevelForm');
    form.action = `/admin/progressive-quizzes/${quizId}/levels/${id}`;
    
    const modal = new bootstrap.Modal(document.getElementById('editLevelModal'));
    modal.show();
}

function deleteLevel(id, title) {
    if (confirm(`Are you sure you want to delete "${title}"? This will also delete all questions in this level.`)) {
        const form = document.getElementById('deleteLevelForm');
        form.action = `/admin/progressive-quizzes/${quizId}/levels/${id}`;
        form.submit();
    }
}

function showNotification(message, type) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    
    notification.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} me-2"></i>
            <span>${message}</span>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(notification);
    
    // Auto dismiss after 3 seconds
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Auto-hide alerts
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert:not(.position-fixed)');
        alerts.forEach(function(alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
});
</script>
@endpush