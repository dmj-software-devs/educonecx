@extends('layouts.admin')

@section('title', 'Manage Questions - Level ' . $progressiveLevel->level_number)
@section('page-title', 'Level ' . $progressiveLevel->level_number . ': ' . $progressiveLevel->title)

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center gap-3">
        <div class="bg-primary bg-opacity-10 rounded-3 p-3">
            <i class="fas fa-question-circle fa-2x text-primary"></i>
        </div>
        <div>
            <h2 class="mb-1">{{ $progressiveLevel->title }}</h2>
            <p class="text-muted mb-0">
                <i class="fas fa-list me-2"></i>Manage questions for this level
            </p>
        </div>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.progressive-quizzes.levels', $progressiveLevel->quiz) }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i> Back to Levels
        </a>
        <a href="{{ route('admin.progressive-quizzes.edit', $progressiveLevel->quiz) }}" class="btn btn-primary">
            <i class="fas fa-edit me-2"></i> Edit Quiz
        </a>
    </div>
</div>

<!-- Level Info Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-primary bg-opacity-10 text-primary rounded-3 p-3 me-3">
                    <i class="fas fa-layer-group fa-2x"></i>
                </div>
                <div>
                    <span class="text-muted text-uppercase small fw-bold">Level</span>
                    <h3 class="mb-0 fw-bold">{{ $progressiveLevel->level_number }}</h3>
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
                    <span class="text-muted text-uppercase small fw-bold">Questions</span>
                    <h3 class="mb-0 fw-bold">{{ $progressiveLevel->questions->count() }}</h3>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-warning bg-opacity-10 text-warning rounded-3 p-3 me-3">
                    <i class="fas fa-star fa-2x"></i>
                </div>
                <div>
                    <span class="text-muted text-uppercase small fw-bold">Total Points</span>
                    <h3 class="mb-0 fw-bold">{{ $progressiveLevel->questions->sum('points') }}</h3>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-info bg-opacity-10 text-info rounded-3 p-3 me-3">
                    <i class="fas fa-percent fa-2x"></i>
                </div>
                <div>
                    <span class="text-muted text-uppercase small fw-bold">Pass Required</span>
                    <h3 class="mb-0 fw-bold">{{ $progressiveLevel->min_percentage }}%</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Add Question Form Column -->
    <div class="col-lg-5 mb-4">
        <div class="card sticky-top" style="top: 20px; z-index: 100;">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-plus-circle me-2 text-primary"></i>Add New Question
                </h5>
                <span class="badge bg-primary rounded-pill px-3 py-2">{{ $progressiveLevel->questions->count() + 1 }}</span>
            </div>
            
            <div class="card-body" style="max-height: 800px; overflow-y: auto;">
                <form action="{{ route('admin.progressive-quizzes.questions.store', ['progressiveQuiz' => $progressiveLevel->quiz->id, 'progressiveLevel' => $progressiveLevel->id]) }}" 
                      method="POST" enctype="multipart/form-data" id="questionForm">
                    @csrf
                    
                    <div id="errorContainer" class="alert alert-danger alert-dismissible fade show" style="display: none;">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Please fix the following errors:</strong>
                        <ul id="errorList" class="mb-0 mt-2">
                        </ul>
                        <button type="button" class="btn-close" onclick="document.getElementById('errorContainer').style.display='none'"></button>
                    </div>
                    
                    <!-- Question Type -->
                    <div class="mb-3">
                        <label class="form-label fw-medium">
                            <i class="fas fa-tag me-2"></i>Question Type <span class="text-danger">*</span>
                        </label>
                        <select name="question_type" id="questionType" class="form-select" required>
                            <option value="multiple_choice">Multiple Choice (Select all that apply)</option>
                            <option value="single_choice">Single Choice (Select one)</option>
                            <option value="true_false">True/False</option>
                            <option value="fill_blank">Fill in the Blank</option>
                            <option value="matching">Matching</option>
                            <option value="image_selection">Image Selection</option>
                        </select>
                    </div>

                    <!-- Question Text -->
                    <div class="mb-3">
                        <label class="form-label fw-medium">
                            <i class="fas fa-paragraph me-2"></i>Question Text <span class="text-danger">*</span>
                        </label>
                        <textarea name="question_text" id="questionText" class="form-control" rows="3" 
                                  placeholder="Enter your question here..." required>{{ old('question_text') }}</textarea>
                    </div>

                    <!-- Explanation -->
                    <div class="mb-3">
                        <label class="form-label fw-medium">
                            <i class="fas fa-info-circle me-2"></i>Explanation (Optional)
                        </label>
                        <textarea name="explanation" class="form-control" rows="2" placeholder="Explain why the answer is correct...">{{ old('explanation') }}</textarea>
                    </div>

                    <!-- Points & Image Row -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">
                                <i class="fas fa-coins me-2"></i>Points
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-star text-warning"></i></span>
                                <input type="number" name="points" class="form-control" value="{{ old('points', 1) }}" min="1">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label fw-medium">
                                <i class="fas fa-image me-2"></i>Question Image
                            </label>
                            <input type="file" name="image" id="image" class="form-control" accept="image/*">
                            <small class="text-muted">PNG, JPG, GIF up to 2MB</small>
                        </div>
                    </div>

                    <!-- Options Section (for Multiple Choice, Single Choice, True/False) -->
                    <div id="optionsSection" class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label fw-medium mb-0">
                                <i class="fas fa-list-ul me-2"></i>Answer Options
                            </label>
                            <span class="badge bg-light text-dark" id="optionsCount">2 options</span>
                        </div>
                        
                        <div id="optionsContainer" class="mb-2">
                            <!-- Options will be added here dynamically -->
                        </div>
                        
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="addOption()">
                            <i class="fas fa-plus me-1"></i> Add Option
                        </button>
                    </div>

                    <!-- Image Selection Section -->
                    <div id="imageSelectionSection" class="mb-3" style="display: none;">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label fw-medium mb-0">
                                <i class="fas fa-images me-2"></i>Image Options
                            </label>
                            <span class="badge bg-light text-dark" id="imageOptionsCount">2 images</span>
                        </div>
                        
                        <div id="imageOptionsContainer" class="mb-2">
                            <!-- Image options will be added here dynamically -->
                        </div>
                        
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="addImageOption()">
                            <i class="fas fa-plus me-1"></i> Add Image Option
                        </button>
                    </div>

                    <!-- Fill in the Blanks Section -->
                    <div id="fillBlanksSection" class="mb-3" style="display: none;">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label fw-medium mb-0">
                                <i class="fas fa-pencil-alt me-2"></i>Correct Answers
                            </label>
                            <span class="badge bg-light text-dark" id="blanksCount">1 answer</span>
                        </div>
                        
                        <div id="fillBlanksContainer" class="mb-2">
                            <!-- Fill blanks will be added here dynamically -->
                        </div>
                        
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="addFillBlank()">
                            <i class="fas fa-plus me-1"></i> Add Answer
                        </button>
                    </div>

                    <!-- Matching Section -->
                    <div id="matchingSection" class="mb-3" style="display: none;">
                        <div class="alert alert-info py-2 mb-3">
                            <i class="fas fa-info-circle me-2"></i>
                            <small>Define the matching pairs below. Each pair consists of a left item and its corresponding right item.</small>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label fw-medium mb-0">
                                <i class="fas fa-link me-2"></i>Matching Pairs
                            </label>
                            <span class="badge bg-light text-dark" id="matchingCount">2 pairs</span>
                        </div>
                        
                        <div id="matchingPairsContainer" class="mb-2">
                            <!-- Matching pairs will be added here dynamically -->
                        </div>
                        
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="addMatchingPair()">
                            <i class="fas fa-plus me-1"></i> Add Matching Pair
                        </button>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary w-100" id="submitBtn">
                        <i class="fas fa-plus-circle me-2"></i>Add Question
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Questions List Column -->
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <i class="fas fa-list text-primary"></i>
                    <div>
                        <h5 class="mb-0">Questions List</h5>
                        <small class="text-muted">{{ $progressiveLevel->questions->count() }} total questions</small>
                    </div>
                </div>
                <div class="bg-light rounded-3 px-3 py-2">
                    <span class="text-muted small">Total Points:</span>
                    <span class="fw-bold ms-1">{{ $progressiveLevel->questions->sum('points') }}</span>
                </div>
            </div>

            <div class="questions-list p-3" id="questionsList" style="max-height: 800px; overflow-y: auto;">
                @forelse($progressiveLevel->questions as $question)
                <div class="question-card card mb-3 border-0 shadow-sm" id="question-{{ $question->id }}" data-id="{{ $question->id }}" data-order="{{ $question->sort_order }}">
                    <div class="card-body">
                        <div class="d-flex align-items-start gap-3">
                            <div class="question-drag-handle text-muted" style="cursor: move; margin-top: 8px;">
                                <i class="fas fa-grip-vertical fa-lg"></i>
                            </div>
                            
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div class="d-flex gap-2 flex-wrap">
                                        <span class="badge bg-primary rounded-pill px-3 py-2">Q{{ $loop->iteration }}</span>
                                        <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3 py-2">
                                            {{ str_replace('_', ' ', ucfirst($question->question_type)) }}
                                        </span>
                                        <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-2">
                                            {{ $question->points }} pts
                                        </span>
                                    </div>
                                    
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-sm btn-outline-primary" onclick="editQuestion({{ $question->id }})" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger" onclick="deleteQuestion({{ $question->id }})" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <p class="mb-2">{{ $question->question_text }}</p>
                                    
                                    @if($question->explanation)
                                    <div class="bg-info bg-opacity-10 text-info p-2 rounded-3 small mb-2">
                                        <i class="fas fa-info-circle me-1"></i> {{ $question->explanation }}
                                    </div>
                                    @endif
                                    
                                    @if($question->image)
                                    <div class="mb-2">
                                        <img src="{{ Storage::url($question->image) }}" alt="Question image" class="rounded-3" style="max-width: 200px; max-height: 150px;">
                                    </div>
                                    @endif
                                    
                                    <div class="answers-preview">
                                        @if(in_array($question->question_type, ['multiple_choice', 'single_choice', 'true_false']))
                                            @foreach($question->options as $option)
                                            <div class="d-flex align-items-center gap-2 mb-1">
                                                <span class="fw-medium text-muted" style="min-width: 25px;">{{ chr(65 + $loop->index) }}</span>
                                                <span class="flex-grow-1">{{ $option->option_text }}</span>
                                                @if($option->is_correct)
                                                    <i class="fas fa-check-circle text-success"></i>
                                                @endif
                                            </div>
                                            @endforeach
                                        
                                        @elseif($question->question_type == 'image_selection')
                                            <div class="row g-2">
                                                @foreach($question->options as $option)
                                                <div class="col-md-6">
                                                    <div class="border rounded-3 p-2 {{ $option->is_correct ? 'border-success' : '' }}">
                                                        @if($option->image)
                                                            <img src="{{ Storage::url($option->image) }}" alt="{{ $option->option_text }}" class="img-fluid rounded-2 mb-1" style="max-height: 60px;">
                                                        @endif
                                                        <small>{{ $option->option_text }}</small>
                                                        @if($option->is_correct)
                                                            <span class="badge bg-success ms-1">Correct</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        
                                        @elseif($question->question_type == 'fill_blank')
                                            @foreach($question->fillBlanks as $blank)
                                            <div class="d-flex align-items-center gap-2 mb-1">
                                                <i class="fas fa-pencil-alt text-muted"></i>
                                                <span>"{{ $blank->correct_answer }}"</span>
                                                @if($blank->case_sensitive)
                                                    <span class="badge bg-secondary">Case Sensitive</span>
                                                @endif
                                            </div>
                                            @endforeach
                                        
                                        @elseif($question->question_type == 'matching')
                                            <div class="table-responsive">
                                                <table class="table table-sm mb-0">
                                                    @foreach($question->matchingPairs as $pair)
                                                    <tr>
                                                        <td class="border-0">{{ $pair->left_item }}</td>
                                                        <td class="border-0 text-muted"><i class="fas fa-arrow-right"></i></td>
                                                        <td class="border-0">{{ $pair->right_item }}</td>
                                                    </tr>
                                                    @endforeach
                                                </table>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-5">
                    <div class="bg-light rounded-circle d-inline-flex p-4 mb-3">
                        <i class="fas fa-question-circle fa-3x text-muted"></i>
                    </div>
                    <h5>No Questions Yet</h5>
                    <p class="text-muted mb-3">Start by adding your first question using the form</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Delete Form -->
<form id="deleteForm" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>

<!-- Edit Question Modal -->
<div class="modal fade" id="editQuestionModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-edit me-2 text-primary"></i>Edit Question
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="editQuestionContent">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success Message Toast -->
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="successToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-success text-white">
            <i class="fas fa-check-circle me-2"></i>
            <strong class="me-auto">Success</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body" id="successMessage">
            Question added successfully!
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Additional styles for question management */
.stat-icon {
    transition: transform 0.2s;
}

.stat-card:hover .stat-icon {
    transform: scale(1.1);
}

.question-card {
    transition: all 0.3s ease;
    border-left: 4px solid transparent;
}

.question-card:hover {
    border-left-color: var(--bs-primary);
    transform: translateX(4px);
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15) !important;
}

.question-drag-handle {
    opacity: 0.5;
    transition: opacity 0.2s;
}

.question-card:hover .question-drag-handle {
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

/* Option item styles */
.option-item {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #f8f9fa;
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 8px;
}

.option-drag {
    color: #adb5bd;
    cursor: move;
}

.option-input-group {
    flex: 1;
    display: flex;
    align-items: center;
    gap: 10px;
}

.option-field {
    flex: 1;
}

.option-text {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid #dee2e6;
    border-radius: 6px;
}

.option-check {
    min-width: 100px;
}

.option-remove {
    width: 32px;
    height: 32px;
    border: none;
    background: #fee2e2;
    color: #dc2626;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.2s;
}

.option-remove:hover {
    background: #dc2626;
    color: white;
}

/* Image option styles */
.image-option-item {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 10px;
}

.image-option-content {
    display: flex;
    align-items: flex-start;
    gap: 15px;
}

.image-upload-box {
    width: 100px;
    height: 100px;
}

.image-option-input {
    display: none;
}

.image-preview-box {
    width: 100px;
    height: 100px;
    border: 2px dashed #dee2e6;
    border-radius: 8px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
}

.image-preview-box:hover {
    border-color: var(--bs-primary);
    background: #e3f2fd;
}

.image-preview-box i {
    font-size: 24px;
    color: #adb5bd;
    margin-bottom: 5px;
}

.image-preview-box span {
    font-size: 10px;
    color: #6c757d;
    text-align: center;
}

.image-option-details {
    flex: 1;
}

.image-option-text {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    margin-bottom: 8px;
}

/* Blank item styles */
.blank-item {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #f8f9fa;
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 8px;
}

.blank-drag {
    color: #adb5bd;
    cursor: move;
}

.blank-input-group {
    flex: 1;
    display: flex;
    align-items: center;
    gap: 10px;
}

.blank-field {
    flex: 1;
}

.blank-text {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid #dee2e6;
    border-radius: 6px;
}

.blank-case {
    min-width: 140px;
}

.blank-remove {
    width: 32px;
    height: 32px;
    border: none;
    background: #fee2e2;
    color: #dc2626;
    border-radius: 6px;
    cursor: pointer;
}

.blank-remove:hover {
    background: #dc2626;
    color: white;
}

/* Matching item styles */
.matching-item {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 10px;
}

.matching-input-group {
    display: flex;
    align-items: center;
    gap: 15px;
}

.matching-left, .matching-right {
    flex: 1;
}

.matching-left-input, .matching-right-input {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid #dee2e6;
    border-radius: 6px;
}

.matching-arrow {
    color: #adb5bd;
    font-size: 20px;
}

.matching-badge {
    background: #d1fae5;
    color: #059669;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.matching-remove {
    width: 32px;
    height: 32px;
    border: none;
    background: #fee2e2;
    color: #dc2626;
    border-radius: 6px;
    cursor: pointer;
}

.matching-remove:hover {
    background: #dc2626;
    color: white;
}

/* Radio button styling for single choice */
.radio-label {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
}

.radio-label input[type="radio"] {
    display: none;
}

.radio-custom {
    width: 18px;
    height: 18px;
    border: 2px solid #dee2e6;
    border-radius: 50%;
    position: relative;
}

.radio-label input[type="radio"]:checked + .radio-custom::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background-color: var(--bs-primary);
}

/* Checkbox styling */
.checkbox-label {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
}

.checkbox-label input[type="checkbox"] {
    display: none;
}

.checkbox-custom {
    width: 18px;
    height: 18px;
    border: 2px solid #dee2e6;
    border-radius: 4px;
    position: relative;
}

.checkbox-label input[type="checkbox"]:checked + .checkbox-custom::after {
    content: '\f00c';
    font-family: 'Font Awesome 6 Free';
    font-weight: 900;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 12px;
    color: var(--bs-primary);
}

.checkbox-text {
    font-size: 14px;
    color: #495057;
}

/* Toast styles */
.toast-container {
    z-index: 9999;
}

/* Responsive */
@media (max-width: 992px) {
    .sticky-top {
        position: relative !important;
        top: 0 !important;
    }
    
    .image-option-content {
        flex-direction: column;
    }
    
    .image-upload-box {
        width: 100%;
        height: auto;
    }
    
    .image-preview-box {
        width: 100%;
        height: 120px;
    }
    
    .matching-input-group {
        flex-direction: column;
    }
    
    .matching-arrow {
        transform: rotate(90deg);
    }
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
// Get IDs from Laravel
const levelId = {{ $progressiveLevel->id }};
const quizId = {{ $progressiveLevel->quiz->id }};
let currentEditId = null;

document.addEventListener('DOMContentLoaded', function() {
    // Initialize with default options
    addOption(); // Add first option
    addOption(); // Add second option
    
    addImageOption();
    addImageOption();
    
    addFillBlank();
    
    addMatchingPair();
    addMatchingPair();
    
    // Initialize Sortable for options
    const optionsContainer = document.getElementById('optionsContainer');
    if (optionsContainer) {
        new Sortable(optionsContainer, {
            handle: '.option-drag',
            animation: 150,
            onEnd: updateOptionsIndices
        });
    }
    
    // Initialize Sortable for questions
    const questionsList = document.getElementById('questionsList');
    if (questionsList) {
        new Sortable(questionsList, {
            handle: '.question-drag-handle',
            animation: 150,
            ghostClass: 'sortable-ghost',
            dragClass: 'sortable-drag',
            onEnd: updateQuestionsOrder
        });
    }
    
    // Question type toggle
    const questionType = document.getElementById('questionType');
    if (questionType) {
        toggleSections(questionType.value);
        questionType.addEventListener('change', function() {
            toggleSections(this.value);
        });
    }
    
    // Image preview
    document.getElementById('image').addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Optional: Show image preview
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    });
    
    // Setup AJAX form submission
    setupAjaxForm();
});

function toggleSections(type) {
    const optionsSection = document.getElementById('optionsSection');
    const imageSection = document.getElementById('imageSelectionSection');
    const blanksSection = document.getElementById('fillBlanksSection');
    const matchingSection = document.getElementById('matchingSection');
    
    // First, remove 'required' attribute from all fields in all sections
    removeRequiredAttributes();
    
    // Hide all sections
    optionsSection.style.display = 'none';
    imageSection.style.display = 'none';
    blanksSection.style.display = 'none';
    matchingSection.style.display = 'none';
    
    // Show and set required attributes for the selected section
    if (type === 'fill_blank') {
        blanksSection.style.display = 'block';
        setRequiredForFillBlanks(true);
    } else if (type === 'matching') {
        matchingSection.style.display = 'block';
        setRequiredForMatching(true);
    } else if (type === 'image_selection') {
        imageSection.style.display = 'block';
        setRequiredForImageOptions(true);
    } else {
        optionsSection.style.display = 'block';
        setRequiredForOptions(true);
    }
    
    // Disable all inputs in hidden sections to prevent them from being submitted
    disableHiddenSections();
}

function disableHiddenSections() {
    // Disable all inputs in hidden sections
    document.querySelectorAll('#optionsSection input, #optionsSection select, #optionsSection textarea').forEach(input => {
        if (document.getElementById('optionsSection').style.display === 'none') {
            input.disabled = true;
        } else {
            input.disabled = false;
        }
    });
    
    document.querySelectorAll('#imageSelectionSection input, #imageSelectionSection select, #imageSelectionSection textarea').forEach(input => {
        if (document.getElementById('imageSelectionSection').style.display === 'none') {
            input.disabled = true;
        } else {
            input.disabled = false;
        }
    });
    
    document.querySelectorAll('#fillBlanksSection input, #fillBlanksSection select, #fillBlanksSection textarea').forEach(input => {
        if (document.getElementById('fillBlanksSection').style.display === 'none') {
            input.disabled = true;
        } else {
            input.disabled = false;
        }
    });
    
    document.querySelectorAll('#matchingSection input, #matchingSection select, #matchingSection textarea').forEach(input => {
        if (document.getElementById('matchingSection').style.display === 'none') {
            input.disabled = true;
        } else {
            input.disabled = false;
        }
    });
}

function removeRequiredAttributes() {
    // Remove required from all option text inputs
    document.querySelectorAll('#optionsContainer .option-text').forEach(input => {
        input.required = false;
    });
    
    // Remove required from all image option inputs
    document.querySelectorAll('#imageOptionsContainer .image-option-input, #imageOptionsContainer .image-option-text').forEach(input => {
        input.required = false;
    });
    
    // Remove required from all blank text inputs
    document.querySelectorAll('#fillBlanksContainer .blank-text').forEach(input => {
        input.required = false;
    });
    
    // Remove required from all matching inputs
    document.querySelectorAll('#matchingPairsContainer .matching-left-input, #matchingPairsContainer .matching-right-input').forEach(input => {
        input.required = false;
    });
}

function setRequiredForOptions(required) {
    document.querySelectorAll('#optionsContainer .option-text').forEach(input => {
        input.required = required;
    });
}

function setRequiredForImageOptions(required) {
    // For image options, we only require the first two text inputs
    document.querySelectorAll('#imageOptionsContainer .image-option-text').forEach((input, index) => {
        // Only require text for first two options
        input.required = required && index < 2;
    });
}

function setRequiredForFillBlanks(required) {
    document.querySelectorAll('#fillBlanksContainer .blank-text').forEach(input => {
        input.required = required;
    });
}

function setRequiredForMatching(required) {
    document.querySelectorAll('#matchingPairsContainer .matching-left-input, #matchingPairsContainer .matching-right-input').forEach(input => {
        input.required = required;
    });
}

function addOption() {
    const container = document.getElementById('optionsContainer');
    const index = container.children.length;
    const isVisible = document.getElementById('optionsSection').style.display !== 'none';
    const questionType = document.getElementById('questionType').value;
    
    // Determine input type based on question type
    const inputType = (questionType === 'multiple_choice') ? 'checkbox' : 'radio';
    const inputName = (questionType === 'multiple_choice') ? `options[${index}][is_correct]` : `correct_option`;
    
    const div = document.createElement('div');
    div.className = 'option-item';
    div.setAttribute('data-index', index);
    
    let inputHtml = '';
    if (questionType === 'multiple_choice') {
        inputHtml = `
            <div class="option-check">
                <label class="checkbox-label">
                    <input type="checkbox" name="options[${index}][is_correct]" value="1" class="correct-checkbox">
                    <span class="checkbox-custom"></span>
                    <span class="checkbox-text">Correct</span>
                </label>
            </div>
        `;
    } else {
        inputHtml = `
            <div class="option-check">
                <label class="radio-label">
                    <input type="radio" name="correct_option" value="${index}" class="correct-radio">
                    <span class="radio-custom"></span>
                    <span class="checkbox-text">Correct</span>
                </label>
            </div>
        `;
    }
    
    div.innerHTML = `
        <div class="option-drag">
            <i class="fas fa-grip-vertical"></i>
        </div>
        <div class="option-input-group">
            <div class="option-field">
                <input type="text" name="options[${index}][text]" class="option-text" placeholder="Enter option ${index + 1}" ${isVisible ? 'required' : ''}>
            </div>
            ${inputHtml}
            <button type="button" class="option-remove" onclick="removeOption(this)">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    container.appendChild(div);
    updateOptionsCount();
    
    // Make sure the new input is disabled if the section is hidden
    if (!isVisible) {
        const newInput = div.querySelector('input');
        newInput.disabled = true;
    }
}

function removeOption(btn) {
    if (document.querySelectorAll('#optionsContainer .option-item').length > 1) {
        const row = btn.closest('.option-item');
        if (row) {
            row.remove();
            updateOptionsIndices();
            updateOptionsCount();
        }
    } else {
        alert('You need at least one option');
    }
}

function updateOptionsIndices() {
    const rows = document.querySelectorAll('#optionsContainer .option-item');
    const questionType = document.getElementById('questionType').value;
    
    rows.forEach((row, index) => {
        row.setAttribute('data-index', index);
        const input = row.querySelector('.option-text');
        if (input) {
            input.name = `options[${index}][text]`;
            input.placeholder = `Enter option ${index + 1}`;
            // Ensure the field is still required if visible
            const isVisible = document.getElementById('optionsSection').style.display !== 'none';
            input.required = isVisible;
            input.disabled = !isVisible;
        }
        
        if (questionType === 'multiple_choice') {
            const checkbox = row.querySelector('input[type="checkbox"]');
            if (checkbox) {
                checkbox.name = `options[${index}][is_correct]`;
                checkbox.disabled = !isVisible;
            }
        } else {
            const radio = row.querySelector('input[type="radio"]');
            if (radio) {
                radio.value = index;
                radio.disabled = !isVisible;
            }
        }
    });
    updateOptionsCount();
}

function updateOptionsCount() {
    const count = document.getElementById('optionsCount');
    if (count) {
        const length = document.querySelectorAll('#optionsContainer .option-item').length;
        count.textContent = length + ' ' + (length === 1 ? 'option' : 'options');
    }
}

function addImageOption() {
    const container = document.getElementById('imageOptionsContainer');
    const index = container.children.length;
    const isVisible = document.getElementById('imageSelectionSection').style.display !== 'none';
    
    const div = document.createElement('div');
    div.className = 'image-option-item';
    div.setAttribute('data-index', index);
    div.innerHTML = `
        <div class="option-drag">
            <i class="fas fa-grip-vertical"></i>
        </div>
        <div class="image-option-content">
            <div class="image-upload-box">
                <input type="file" name="options[${index}][image]" class="image-option-input" id="imageInput${index}" accept="image/*" onchange="previewImageOption(this, ${index})" style="display: none;">
                <div class="image-preview-box" onclick="document.getElementById('imageInput${index}').click()">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <span>Upload Image</span>
                </div>
            </div>
            <div class="image-option-details">
                <input type="text" name="options[${index}][text]" class="image-option-text" placeholder="Alt text / Label" ${isVisible && index < 2 ? 'required' : ''}>
                <div>
                    <label class="checkbox-label">
                        <input type="checkbox" name="options[${index}][is_correct]" value="1" class="correct-checkbox">
                        <span class="checkbox-custom"></span>
                        <span class="checkbox-text">Correct</span>
                    </label>
                </div>
            </div>
            <button type="button" class="option-remove" onclick="removeImageOption(this)">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    container.appendChild(div);
    updateImageOptionsCount();
    
    // Make sure the new inputs are disabled if the section is hidden
    if (!isVisible) {
        const textInput = div.querySelector('.image-option-text');
        const checkbox = div.querySelector('input[type="checkbox"]');
        const fileInput = div.querySelector('.image-option-input');
        if (textInput) textInput.disabled = true;
        if (checkbox) checkbox.disabled = true;
        if (fileInput) fileInput.disabled = true;
    }
}

function removeImageOption(btn) {
    if (document.querySelectorAll('#imageOptionsContainer .image-option-item').length > 1) {
        const row = btn.closest('.image-option-item');
        if (row) {
            row.remove();
            updateImageOptionsIndices();
            updateImageOptionsCount();
        }
    } else {
        alert('You need at least one image option');
    }
}

function updateImageOptionsIndices() {
    const rows = document.querySelectorAll('#imageOptionsContainer .image-option-item');
    rows.forEach((row, index) => {
        row.setAttribute('data-index', index);
        const fileInput = row.querySelector('.image-option-input');
        if (fileInput) {
            fileInput.name = `options[${index}][image]`;
            fileInput.id = `imageInput${index}`;
            fileInput.setAttribute('onchange', `previewImageOption(this, ${index})`);
        }
        const preview = row.querySelector('.image-preview-box');
        if (preview) {
            preview.setAttribute('onclick', `document.getElementById('imageInput${index}').click()`);
        }
        const textInput = row.querySelector('.image-option-text');
        if (textInput) {
            textInput.name = `options[${index}][text]`;
            // Update required based on visibility and index
            const isVisible = document.getElementById('imageSelectionSection').style.display !== 'none';
            textInput.required = isVisible && index < 2;
            textInput.disabled = !isVisible;
        }
        const checkbox = row.querySelector('input[type="checkbox"]');
        if (checkbox) {
            checkbox.name = `options[${index}][is_correct]`;
            checkbox.disabled = !isVisible;
        }
    });
    updateImageOptionsCount();
}

function updateImageOptionsCount() {
    const count = document.getElementById('imageOptionsCount');
    if (count) {
        const length = document.querySelectorAll('#imageOptionsContainer .image-option-item').length;
        count.textContent = length + ' ' + (length === 1 ? 'image' : 'images');
    }
}

function previewImageOption(input, index) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = input.closest('.image-upload-box').querySelector('.image-preview-box');
            if (preview) {
                preview.innerHTML = `<img src="${e.target.result}" alt="Preview" style="width:100%;height:100%;object-fit:cover;">`;
            }
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function addFillBlank() {
    const container = document.getElementById('fillBlanksContainer');
    const index = container.children.length;
    const isVisible = document.getElementById('fillBlanksSection').style.display !== 'none';
    
    const div = document.createElement('div');
    div.className = 'blank-item';
    div.setAttribute('data-index', index);
    div.innerHTML = `
        <div class="blank-drag">
            <i class="fas fa-grip-vertical"></i>
        </div>
        <div class="blank-input-group">
            <div class="blank-field">
                <input type="text" name="fill_blanks[${index}][answer]" class="blank-text" placeholder="Enter correct answer" ${isVisible ? 'required' : ''}>
            </div>
            <div class="blank-case">
                <label class="checkbox-label">
                    <input type="checkbox" name="fill_blanks[${index}][case_sensitive]" value="1">
                    <span class="checkbox-custom"></span>
                    <span class="checkbox-text">Case Sensitive</span>
                </label>
            </div>
            <button type="button" class="blank-remove" onclick="removeBlank(this)">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    container.appendChild(div);
    updateBlanksCount();
    
    // Make sure the new inputs are disabled if the section is hidden
    if (!isVisible) {
        const textInput = div.querySelector('.blank-text');
        const checkbox = div.querySelector('input[type="checkbox"]');
        if (textInput) textInput.disabled = true;
        if (checkbox) checkbox.disabled = true;
    }
}

function removeBlank(btn) {
    if (document.querySelectorAll('#fillBlanksContainer .blank-item').length > 1) {
        const row = btn.closest('.blank-item');
        if (row) {
            row.remove();
            updateBlanksIndices();
            updateBlanksCount();
        }
    } else {
        alert('You need at least one answer');
    }
}

function updateBlanksIndices() {
    const rows = document.querySelectorAll('#fillBlanksContainer .blank-item');
    rows.forEach((row, index) => {
        row.setAttribute('data-index', index);
        const input = row.querySelector('.blank-text');
        if (input) {
            input.name = `fill_blanks[${index}][answer]`;
            const isVisible = document.getElementById('fillBlanksSection').style.display !== 'none';
            input.disabled = !isVisible;
        }
        const checkbox = row.querySelector('input[type="checkbox"]');
        if (checkbox) {
            checkbox.name = `fill_blanks[${index}][case_sensitive]`;
            const isVisible = document.getElementById('fillBlanksSection').style.display !== 'none';
            checkbox.disabled = !isVisible;
        }
    });
    updateBlanksCount();
}

function updateBlanksCount() {
    const count = document.getElementById('blanksCount');
    if (count) {
        const length = document.querySelectorAll('#fillBlanksContainer .blank-item').length;
        count.textContent = length + ' ' + (length === 1 ? 'answer' : 'answers');
    }
}

function addMatchingPair() {
    const container = document.getElementById('matchingPairsContainer');
    const index = container.children.length;
    const isVisible = document.getElementById('matchingSection').style.display !== 'none';
    
    const div = document.createElement('div');
    div.className = 'matching-item';
    div.setAttribute('data-index', index);
    div.innerHTML = `
        <div class="option-drag">
            <i class="fas fa-grip-vertical"></i>
        </div>
        <div class="matching-input-group">
            <div class="matching-left">
                <input type="text" name="matching_pairs[${index}][left]" class="matching-left-input" placeholder="Left item ${index + 1}" ${isVisible ? 'required' : ''}>
            </div>
            <div class="matching-arrow">
                <i class="fas fa-long-arrow-alt-right"></i>
            </div>
            <div class="matching-right">
                <input type="text" name="matching_pairs[${index}][right]" class="matching-right-input" placeholder="Right item ${index + 1}" ${isVisible ? 'required' : ''}>
            </div>
            <div class="matching-badge">
                <i class="fas fa-check-circle"></i>
                <span>Correct Pair</span>
            </div>
            <button type="button" class="matching-remove" onclick="removeMatchingPair(this)">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    container.appendChild(div);
    updateMatchingCount();
    
    // Make sure the new inputs are disabled if the section is hidden
    if (!isVisible) {
        const leftInput = div.querySelector('.matching-left-input');
        const rightInput = div.querySelector('.matching-right-input');
        if (leftInput) leftInput.disabled = true;
        if (rightInput) rightInput.disabled = true;
    }
}

function removeMatchingPair(btn) {
    if (document.querySelectorAll('#matchingPairsContainer .matching-item').length > 1) {
        const row = btn.closest('.matching-item');
        if (row) {
            row.remove();
            updateMatchingIndices();
            updateMatchingCount();
        }
    } else {
        alert('You need at least one matching pair');
    }
}

function updateMatchingIndices() {
    const rows = document.querySelectorAll('#matchingPairsContainer .matching-item');
    rows.forEach((row, index) => {
        row.setAttribute('data-index', index);
        const left = row.querySelector('.matching-left-input');
        if (left) {
            left.name = `matching_pairs[${index}][left]`;
            left.placeholder = `Left item ${index + 1}`;
            // Update required based on visibility
            const isVisible = document.getElementById('matchingSection').style.display !== 'none';
            left.required = isVisible;
            left.disabled = !isVisible;
        }
        const right = row.querySelector('.matching-right-input');
        if (right) {
            right.name = `matching_pairs[${index}][right]`;
            right.placeholder = `Right item ${index + 1}`;
            // Update required based on visibility
            const isVisible = document.getElementById('matchingSection').style.display !== 'none';
            right.required = isVisible;
            right.disabled = !isVisible;
        }
    });
    updateMatchingCount();
}

function updateMatchingCount() {
    const count = document.getElementById('matchingCount');
    if (count) {
        const length = document.querySelectorAll('#matchingPairsContainer .matching-item').length;
        count.textContent = length + ' ' + (length === 1 ? 'pair' : 'pairs');
    }
}

function updateQuestionsOrder() {
    const questions = document.querySelectorAll('#questionsList .question-card');
    const orderData = [];
    
    questions.forEach((question, index) => {
        const id = question.getAttribute('data-id');
        orderData.push({
            id: id,
            sort_order: index + 1
        });
        
        // Update question number badge
        const badge = question.querySelector('.badge-primary');
        if (badge) {
            badge.textContent = 'Q' + (index + 1);
        }
    });
    
    // Send to server
    fetch('/admin/progressive-questions/reorder', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ questions: orderData })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Questions reordered successfully', 'success');
        }
    })
    .catch(error => {
        console.error('Error reordering questions:', error);
        showNotification('Error reordering questions', 'danger');
    });
}

function deleteQuestion(id) {
    if (confirm('Are you sure you want to delete this question? This action cannot be undone.')) {
        const form = document.getElementById('deleteForm');
        form.action = '/admin/progressive-questions/' + id;
        form.submit();
    }
}

function editQuestion(id) {
    const modal = new bootstrap.Modal(document.getElementById('editQuestionModal'));
    const content = document.getElementById('editQuestionContent');
    currentEditId = id;
    
    modal.show();
    
    fetch('/admin/progressive-questions/' + id + '/edit', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(question => {
        // Build edit form with populated data
        let html = `
            <form id="editQuestionForm" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
                <input type="hidden" name="_method" value="PUT">
                
                <div class="mb-3">
                    <label class="form-label fw-medium">Question Type</label>
                    <select name="question_type" class="form-select" id="editQuestionType" onchange="toggleEditSections(this.value)">
                        <option value="multiple_choice" ${question.question_type === 'multiple_choice' ? 'selected' : ''}>Multiple Choice</option>
                        <option value="single_choice" ${question.question_type === 'single_choice' ? 'selected' : ''}>Single Choice</option>
                        <option value="true_false" ${question.question_type === 'true_false' ? 'selected' : ''}>True/False</option>
                        <option value="fill_blank" ${question.question_type === 'fill_blank' ? 'selected' : ''}>Fill in the Blank</option>
                        <option value="matching" ${question.question_type === 'matching' ? 'selected' : ''}>Matching</option>
                        <option value="image_selection" ${question.question_type === 'image_selection' ? 'selected' : ''}>Image Selection</option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-medium">Question Text</label>
                    <textarea name="question_text" class="form-control" rows="3" required>${question.question_text.replace(/<[^>]*>/g, '')}</textarea>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-medium">Explanation</label>
                    <textarea name="explanation" class="form-control" rows="2">${question.explanation ? question.explanation.replace(/<[^>]*>/g, '') : ''}</textarea>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Points</label>
                        <input type="number" name="points" class="form-control" value="${question.points || 1}" min="1">
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        ${question.image ? '<small class="text-muted d-block mt-1">Current image exists. Upload new to replace.</small><div class="mt-2"><img src="/storage/' + question.image + '" class="img-thumbnail" style="max-height: 100px;"></div>' : ''}
                    </div>
                </div>
        `;
        
        // Add options section based on question type
        if (question.question_type === 'multiple_choice' || question.question_type === 'single_choice' || question.question_type === 'true_false') {
            const isMultipleChoice = question.question_type === 'multiple_choice';
            const inputType = isMultipleChoice ? 'checkbox' : 'radio';
            
            html += `<div id="editOptionsSection" class="mb-3">`;
            html += `<div class="d-flex justify-content-between align-items-center mb-2">`;
            html += `<label class="form-label fw-medium mb-0">Answer Options</label>`;
            html += `<span class="badge bg-light text-dark">${question.options.length} options</span>`;
            html += `</div>`;
            html += `<div id="editOptionsContainer" class="mb-2">`;
            
            // Find the correct option index for single choice
            let correctIndex = -1;
            if (!isMultipleChoice) {
                question.options.forEach((option, idx) => {
                    if (option.is_correct) correctIndex = idx;
                });
            }
            
            question.options.forEach((option, index) => {
                const checked = isMultipleChoice ? (option.is_correct ? 'checked' : '') : (correctIndex === index ? 'checked' : '');
                
                html += `
                    <div class="option-item mb-2" data-index="${index}">
                        <div class="option-drag">
                            <i class="fas fa-grip-vertical"></i>
                        </div>
                        <div class="option-input-group flex-grow-1">
                            <div class="option-field flex-grow-1">
                                <input type="text" name="options[${index}][text]" class="form-control" value="${option.option_text}" placeholder="Enter option ${index + 1}" required>
                            </div>
                            <div class="option-check">
                                <label class="${inputType === 'checkbox' ? 'checkbox-label' : 'radio-label'}">
                                    <input type="${inputType}" name="${isMultipleChoice ? `options[${index}][is_correct]` : 'correct_option'}" value="${isMultipleChoice ? '1' : index}" ${checked}>
                                    <span class="${inputType === 'checkbox' ? 'checkbox-custom' : 'radio-custom'}"></span>
                                    <span class="checkbox-text">Correct</span>
                                </label>
                            </div>
                            <button type="button" class="btn btn-sm btn-danger" onclick="removeEditOption(this)">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                `;
            });
            
            html += `</div>`;
            html += `<button type="button" class="btn btn-sm btn-outline-primary" onclick="addEditOption('${question.question_type}')">`;
            html += `<i class="fas fa-plus me-1"></i> Add Option`;
            html += `</button>`;
            html += `</div>`;
        }
        
        if (question.question_type === 'image_selection') {
            html += `<div id="editImageSelectionSection" class="mb-3">`;
            html += `<div class="d-flex justify-content-between align-items-center mb-2">`;
            html += `<label class="form-label fw-medium mb-0">Image Options</label>`;
            html += `<span class="badge bg-light text-dark">${question.options.length} images</span>`;
            html += `</div>`;
            html += `<div id="editImageOptionsContainer" class="mb-2">`;
            
            question.options.forEach((option, index) => {
                const imageUrl = option.image ? '/storage/' + option.image : '';
                html += `
                    <div class="image-option-item mb-2" data-index="${index}">
                        <div class="option-drag">
                            <i class="fas fa-grip-vertical"></i>
                        </div>
                        <div class="image-option-content">
                            <div class="image-upload-box">
                                <input type="file" name="options[${index}][image]" class="image-option-input" id="editImageInput${index}" accept="image/*" onchange="previewEditImageOption(this, ${index})" style="display: none;">
                                <input type="hidden" name="options[${index}][existing_image]" value="${option.image || ''}">
                                <div class="image-preview-box" onclick="document.getElementById('editImageInput${index}').click()">
                                    ${imageUrl ? `<img src="${imageUrl}" alt="Preview" style="width:100%;height:100%;object-fit:cover;">` : 
                                    `<i class="fas fa-cloud-upload-alt"></i><span>Upload Image</span>`}
                                </div>
                            </div>
                            <div class="image-option-details">
                                <input type="text" name="options[${index}][text]" class="image-option-text form-control" placeholder="Alt text / Label" value="${option.option_text || ''}">
                                <div class="mt-2">
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="options[${index}][is_correct]" value="1" ${option.is_correct ? 'checked' : ''}>
                                        <span class="checkbox-custom"></span>
                                        <span class="checkbox-text">Correct</span>
                                    </label>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-danger" onclick="removeEditImageOption(this)">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                `;
            });
            
            html += `</div>`;
            html += `<button type="button" class="btn btn-sm btn-outline-primary" onclick="addEditImageOption()">`;
            html += `<i class="fas fa-plus me-1"></i> Add Image Option`;
            html += `</button>`;
            html += `</div>`;
        }
        
        if (question.question_type === 'fill_blank') {
            html += `<div id="editFillBlanksSection" class="mb-3">`;
            html += `<div class="d-flex justify-content-between align-items-center mb-2">`;
            html += `<label class="form-label fw-medium mb-0">Correct Answers</label>`;
            html += `<span class="badge bg-light text-dark">${question.fill_blanks.length} answers</span>`;
            html += `</div>`;
            html += `<div id="editFillBlanksContainer" class="mb-2">`;
            
            question.fill_blanks.forEach((blank, index) => {
                html += `
                    <div class="blank-item mb-2" data-index="${index}">
                        <div class="blank-drag">
                            <i class="fas fa-grip-vertical"></i>
                        </div>
                        <div class="blank-input-group flex-grow-1">
                            <div class="blank-field flex-grow-1">
                                <input type="text" name="fill_blanks[${index}][answer]" class="form-control" value="${blank.correct_answer}" placeholder="Enter correct answer" required>
                            </div>
                            <div class="blank-case">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="fill_blanks[${index}][case_sensitive]" value="1" ${blank.case_sensitive ? 'checked' : ''}>
                                    <span class="checkbox-custom"></span>
                                    <span class="checkbox-text">Case Sensitive</span>
                                </label>
                            </div>
                            <button type="button" class="btn btn-sm btn-danger" onclick="removeEditBlank(this)">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                `;
            });
            
            html += `</div>`;
            html += `<button type="button" class="btn btn-sm btn-outline-primary" onclick="addEditFillBlank()">`;
            html += `<i class="fas fa-plus me-1"></i> Add Answer`;
            html += `</button>`;
            html += `</div>`;
        }
        
        if (question.question_type === 'matching') {
            html += `<div id="editMatchingSection" class="mb-3">`;
            html += `<div class="alert alert-info py-2 mb-3">`;
            html += `<i class="fas fa-info-circle me-2"></i>`;
            html += `<small>Define the matching pairs below. Each pair consists of a left item and its corresponding right item.</small>`;
            html += `</div>`;
            html += `<div class="d-flex justify-content-between align-items-center mb-2">`;
            html += `<label class="form-label fw-medium mb-0">Matching Pairs</label>`;
            html += `<span class="badge bg-light text-dark">${question.matching_pairs.length} pairs</span>`;
            html += `</div>`;
            html += `<div id="editMatchingPairsContainer" class="mb-2">`;
            
            question.matching_pairs.forEach((pair, index) => {
                html += `
                    <div class="matching-item mb-2" data-index="${index}">
                        <div class="option-drag">
                            <i class="fas fa-grip-vertical"></i>
                        </div>
                        <div class="matching-input-group">
                            <div class="matching-left">
                                <input type="text" name="matching_pairs[${index}][left]" class="form-control" value="${pair.left_item}" placeholder="Left item ${index + 1}" required>
                            </div>
                            <div class="matching-arrow">
                                <i class="fas fa-long-arrow-alt-right"></i>
                            </div>
                            <div class="matching-right">
                                <input type="text" name="matching_pairs[${index}][right]" class="form-control" value="${pair.right_item}" placeholder="Right item ${index + 1}" required>
                            </div>
                            <div class="matching-badge">
                                <i class="fas fa-check-circle"></i>
                                <span>Correct Pair</span>
                            </div>
                            <button type="button" class="btn btn-sm btn-danger" onclick="removeEditMatchingPair(this)">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                `;
            });
            
            html += `</div>`;
            html += `<button type="button" class="btn btn-sm btn-outline-primary" onclick="addEditMatchingPair()">`;
            html += `<i class="fas fa-plus me-1"></i> Add Matching Pair`;
            html += `</button>`;
            html += `</div>`;
        }
        
        html += `
                <div class="text-end">
                    <button type="button" class="btn btn-outline-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Question</button>
                </div>
            </form>`;
        
        content.innerHTML = html;
        
        // Initialize Sortable for edit options if they exist
        const editOptionsContainer = document.getElementById('editOptionsContainer');
        if (editOptionsContainer) {
            new Sortable(editOptionsContainer, {
                handle: '.option-drag',
                animation: 150,
                onEnd: updateEditOptionsIndices
            });
        }
        
        const editImageOptionsContainer = document.getElementById('editImageOptionsContainer');
        if (editImageOptionsContainer) {
            new Sortable(editImageOptionsContainer, {
                handle: '.option-drag',
                animation: 150,
                onEnd: updateEditImageOptionsIndices
            });
        }
        
        const editFillBlanksContainer = document.getElementById('editFillBlanksContainer');
        if (editFillBlanksContainer) {
            new Sortable(editFillBlanksContainer, {
                handle: '.blank-drag',
                animation: 150,
                onEnd: updateEditFillBlanksIndices
            });
        }
        
        const editMatchingPairsContainer = document.getElementById('editMatchingPairsContainer');
        if (editMatchingPairsContainer) {
            new Sortable(editMatchingPairsContainer, {
                handle: '.option-drag',
                animation: 150,
                onEnd: updateEditMatchingIndices
            });
        }
        
        // Initialize form submission
        document.getElementById('editQuestionForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Updating...';
            submitBtn.disabled = true;
            
            fetch('/admin/progressive-questions/' + currentEditId, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    modal.hide();
                    showNotification('Question updated successfully', 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showNotification('Error updating question', 'danger');
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error updating question', 'danger');
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        });
    })
    .catch(error => {
        console.error('Error:', error);
        content.innerHTML = '<div class="alert alert-danger">Error loading question data</div>';
    });
}

function toggleEditSections(type) {
    const optionsSection = document.getElementById('editOptionsSection');
    const imageSection = document.getElementById('editImageSelectionSection');
    const fillBlanksSection = document.getElementById('editFillBlanksSection');
    const matchingSection = document.getElementById('editMatchingSection');
    
    if (optionsSection) optionsSection.style.display = 'none';
    if (imageSection) imageSection.style.display = 'none';
    if (fillBlanksSection) fillBlanksSection.style.display = 'none';
    if (matchingSection) matchingSection.style.display = 'none';
    
    if (type === 'fill_blank') {
        if (fillBlanksSection) fillBlanksSection.style.display = 'block';
    } else if (type === 'matching') {
        if (matchingSection) matchingSection.style.display = 'block';
    } else if (type === 'image_selection') {
        if (imageSection) imageSection.style.display = 'block';
    } else {
        if (optionsSection) optionsSection.style.display = 'block';
    }
}

function addEditOption(questionType) {
    const container = document.getElementById('editOptionsContainer');
    const index = container.children.length;
    const isMultipleChoice = questionType === 'multiple_choice';
    const inputType = isMultipleChoice ? 'checkbox' : 'radio';
    
    const div = document.createElement('div');
    div.className = 'option-item mb-2';
    div.setAttribute('data-index', index);
    
    const inputHtml = isMultipleChoice 
        ? `<input type="checkbox" name="options[${index}][is_correct]" value="1">`
        : `<input type="radio" name="correct_option" value="${index}">`;
    
    div.innerHTML = `
        <div class="option-drag">
            <i class="fas fa-grip-vertical"></i>
        </div>
        <div class="option-input-group flex-grow-1">
            <div class="option-field flex-grow-1">
                <input type="text" name="options[${index}][text]" class="form-control" placeholder="Enter option ${index + 1}" required>
            </div>
            <div class="option-check">
                <label class="${inputType === 'checkbox' ? 'checkbox-label' : 'radio-label'}">
                    ${inputHtml}
                    <span class="${inputType === 'checkbox' ? 'checkbox-custom' : 'radio-custom'}"></span>
                    <span class="checkbox-text">Correct</span>
                </label>
            </div>
            <button type="button" class="btn btn-sm btn-danger" onclick="removeEditOption(this)">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    container.appendChild(div);
    updateEditOptionsCount();
}

function removeEditOption(btn) {
    const container = document.getElementById('editOptionsContainer');
    if (container.children.length > 1) {
        const row = btn.closest('.option-item');
        if (row) {
            row.remove();
            updateEditOptionsIndices();
            updateEditOptionsCount();
        }
    } else {
        alert('You need at least one option');
    }
}

function updateEditOptionsIndices() {
    const rows = document.querySelectorAll('#editOptionsContainer .option-item');
    const questionType = document.getElementById('editQuestionType').value;
    const isMultipleChoice = questionType === 'multiple_choice';
    
    rows.forEach((row, index) => {
        row.setAttribute('data-index', index);
        const input = row.querySelector('input[type="text"]');
        if (input) {
            input.name = `options[${index}][text]`;
            input.placeholder = `Enter option ${index + 1}`;
        }
        
        if (isMultipleChoice) {
            const checkbox = row.querySelector('input[type="checkbox"]');
            if (checkbox) {
                checkbox.name = `options[${index}][is_correct]`;
                checkbox.value = '1';
            }
        } else {
            const radio = row.querySelector('input[type="radio"]');
            if (radio) {
                radio.name = 'correct_option';
                radio.value = index;
            }
        }
    });
    updateEditOptionsCount();
}

function updateEditOptionsCount() {
    const container = document.getElementById('editOptionsContainer');
    const badge = document.querySelector('#editOptionsSection .badge');
    if (badge) {
        badge.textContent = container.children.length + ' options';
    }
}

function addEditImageOption() {
    const container = document.getElementById('editImageOptionsContainer');
    const index = container.children.length;
    
    const div = document.createElement('div');
    div.className = 'image-option-item mb-2';
    div.setAttribute('data-index', index);
    div.innerHTML = `
        <div class="option-drag">
            <i class="fas fa-grip-vertical"></i>
        </div>
        <div class="image-option-content">
            <div class="image-upload-box">
                <input type="file" name="options[${index}][image]" class="image-option-input" id="editImageInput${index}" accept="image/*" onchange="previewEditImageOption(this, ${index})" style="display: none;">
                <input type="hidden" name="options[${index}][existing_image]" value="">
                <div class="image-preview-box" onclick="document.getElementById('editImageInput${index}').click()">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <span>Upload Image</span>
                </div>
            </div>
            <div class="image-option-details">
                <input type="text" name="options[${index}][text]" class="image-option-text form-control" placeholder="Alt text / Label">
                <div class="mt-2">
                    <label class="checkbox-label">
                        <input type="checkbox" name="options[${index}][is_correct]" value="1">
                        <span class="checkbox-custom"></span>
                        <span class="checkbox-text">Correct</span>
                    </label>
                </div>
            </div>
            <button type="button" class="btn btn-sm btn-danger" onclick="removeEditImageOption(this)">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    container.appendChild(div);
    updateEditImageOptionsCount();
}

function removeEditImageOption(btn) {
    const container = document.getElementById('editImageOptionsContainer');
    if (container.children.length > 1) {
        const row = btn.closest('.image-option-item');
        if (row) {
            row.remove();
            updateEditImageOptionsIndices();
            updateEditImageOptionsCount();
        }
    } else {
        alert('You need at least one image option');
    }
}

function updateEditImageOptionsIndices() {
    const rows = document.querySelectorAll('#editImageOptionsContainer .image-option-item');
    rows.forEach((row, index) => {
        row.setAttribute('data-index', index);
        const fileInput = row.querySelector('.image-option-input');
        if (fileInput) {
            fileInput.name = `options[${index}][image]`;
            fileInput.id = `editImageInput${index}`;
            fileInput.setAttribute('onchange', `previewEditImageOption(this, ${index})`);
        }
        const hiddenInput = row.querySelector('input[type="hidden"]');
        if (hiddenInput) {
            hiddenInput.name = `options[${index}][existing_image]`;
        }
        const preview = row.querySelector('.image-preview-box');
        if (preview) {
            preview.setAttribute('onclick', `document.getElementById('editImageInput${index}').click()`);
        }
        const textInput = row.querySelector('.image-option-text');
        if (textInput) {
            textInput.name = `options[${index}][text]`;
        }
        const checkbox = row.querySelector('input[type="checkbox"]');
        if (checkbox) {
            checkbox.name = `options[${index}][is_correct]`;
        }
    });
    updateEditImageOptionsCount();
}

function updateEditImageOptionsCount() {
    const container = document.getElementById('editImageOptionsContainer');
    const badge = document.querySelector('#editImageSelectionSection .badge');
    if (badge) {
        badge.textContent = container.children.length + ' images';
    }
}

function previewEditImageOption(input, index) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = input.closest('.image-upload-box').querySelector('.image-preview-box');
            if (preview) {
                preview.innerHTML = `<img src="${e.target.result}" alt="Preview" style="width:100%;height:100%;object-fit:cover;">`;
            }
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function addEditFillBlank() {
    const container = document.getElementById('editFillBlanksContainer');
    const index = container.children.length;
    
    const div = document.createElement('div');
    div.className = 'blank-item mb-2';
    div.setAttribute('data-index', index);
    div.innerHTML = `
        <div class="blank-drag">
            <i class="fas fa-grip-vertical"></i>
        </div>
        <div class="blank-input-group flex-grow-1">
            <div class="blank-field flex-grow-1">
                <input type="text" name="fill_blanks[${index}][answer]" class="form-control" placeholder="Enter correct answer" required>
            </div>
            <div class="blank-case">
                <label class="checkbox-label">
                    <input type="checkbox" name="fill_blanks[${index}][case_sensitive]" value="1">
                    <span class="checkbox-custom"></span>
                    <span class="checkbox-text">Case Sensitive</span>
                </label>
            </div>
            <button type="button" class="btn btn-sm btn-danger" onclick="removeEditBlank(this)">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    container.appendChild(div);
    updateEditFillBlanksCount();
}

function removeEditBlank(btn) {
    const container = document.getElementById('editFillBlanksContainer');
    if (container.children.length > 1) {
        const row = btn.closest('.blank-item');
        if (row) {
            row.remove();
            updateEditFillBlanksIndices();
            updateEditFillBlanksCount();
        }
    } else {
        alert('You need at least one answer');
    }
}

function updateEditFillBlanksIndices() {
    const rows = document.querySelectorAll('#editFillBlanksContainer .blank-item');
    rows.forEach((row, index) => {
        row.setAttribute('data-index', index);
        const input = row.querySelector('input[type="text"]');
        if (input) {
            input.name = `fill_blanks[${index}][answer]`;
        }
        const checkbox = row.querySelector('input[type="checkbox"]');
        if (checkbox) {
            checkbox.name = `fill_blanks[${index}][case_sensitive]`;
        }
    });
    updateEditFillBlanksCount();
}

function updateEditFillBlanksCount() {
    const container = document.getElementById('editFillBlanksContainer');
    const badge = document.querySelector('#editFillBlanksSection .badge');
    if (badge) {
        badge.textContent = container.children.length + ' answers';
    }
}

function addEditMatchingPair() {
    const container = document.getElementById('editMatchingPairsContainer');
    const index = container.children.length;
    
    const div = document.createElement('div');
    div.className = 'matching-item mb-2';
    div.setAttribute('data-index', index);
    div.innerHTML = `
        <div class="option-drag">
            <i class="fas fa-grip-vertical"></i>
        </div>
        <div class="matching-input-group">
            <div class="matching-left">
                <input type="text" name="matching_pairs[${index}][left]" class="form-control" placeholder="Left item ${index + 1}" required>
            </div>
            <div class="matching-arrow">
                <i class="fas fa-long-arrow-alt-right"></i>
            </div>
            <div class="matching-right">
                <input type="text" name="matching_pairs[${index}][right]" class="form-control" placeholder="Right item ${index + 1}" required>
            </div>
            <div class="matching-badge">
                <i class="fas fa-check-circle"></i>
                <span>Correct Pair</span>
            </div>
            <button type="button" class="btn btn-sm btn-danger" onclick="removeEditMatchingPair(this)">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    container.appendChild(div);
    updateEditMatchingCount();
}

function removeEditMatchingPair(btn) {
    const container = document.getElementById('editMatchingPairsContainer');
    if (container.children.length > 1) {
        const row = btn.closest('.matching-item');
        if (row) {
            row.remove();
            updateEditMatchingIndices();
            updateEditMatchingCount();
        }
    } else {
        alert('You need at least one matching pair');
    }
}

function updateEditMatchingIndices() {
    const rows = document.querySelectorAll('#editMatchingPairsContainer .matching-item');
    rows.forEach((row, index) => {
        row.setAttribute('data-index', index);
        const left = row.querySelector('.matching-left-input');
        if (left) {
            left.name = `matching_pairs[${index}][left]`;
            left.placeholder = `Left item ${index + 1}`;
        }
        const right = row.querySelector('.matching-right-input');
        if (right) {
            right.name = `matching_pairs[${index}][right]`;
            right.placeholder = `Right item ${index + 1}`;
        }
    });
    updateEditMatchingCount();
}

function updateEditMatchingCount() {
    const container = document.getElementById('editMatchingPairsContainer');
    const badge = document.querySelector('#editMatchingSection .badge');
    if (badge) {
        badge.textContent = container.children.length + ' pairs';
    }
}

function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
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

function setupAjaxForm() {
    const form = document.getElementById('questionForm');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent normal form submission
        
        const questionType = document.getElementById('questionType').value;
        
        // Ensure all option text fields have values before submitting
        if (questionType === 'multiple_choice' || questionType === 'single_choice' || questionType === 'true_false') {
            const options = document.querySelectorAll('#optionsContainer .option-text');
            let allFilled = true;
            let emptyFields = [];
            
            options.forEach((option, index) => {
                // Get the current value
                const value = option.value.trim();
                console.log(`Option ${index + 1} value:`, value);
                console.log(`Option ${index + 1} name:`, option.name);
                
                if (!value) {
                    allFilled = false;
                    emptyFields.push(index + 1);
                    option.style.borderColor = 'red';
                    option.style.borderWidth = '2px';
                    option.style.backgroundColor = '#fff0f0';
                } else {
                    option.style.borderColor = '';
                    option.style.borderWidth = '';
                    option.style.backgroundColor = '';
                }
            });
            
            if (!allFilled) {
                alert('Please fill in all option text fields. Empty fields: ' + emptyFields.join(', '));
                return false;
            }
        }
        
        // Submit via AJAX
        const submitBtn = document.getElementById('submitBtn');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Saving...';
        submitBtn.disabled = true;
        
        const formData = new FormData(form);
        
        // Log the final form data
        console.log('Final FormData entries:');
        for (let pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }
        
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                showNotification('Question added successfully!', 'success');
                
                // Reset form
                form.reset();
                
                // Clear and reinitialize options
                document.getElementById('optionsContainer').innerHTML = '';
                addOption();
                addOption();
                
                // Reload page after 1 second to show new question
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                // Show validation errors
                const errorContainer = document.getElementById('errorContainer');
                const errorList = document.getElementById('errorList');
                errorList.innerHTML = '';
                
                if (data.errors) {
                    for (const [field, messages] of Object.entries(data.errors)) {
                        messages.forEach(message => {
                            const li = document.createElement('li');
                            li.textContent = message;
                            errorList.appendChild(li);
                        });
                    }
                } else {
                    const li = document.createElement('li');
                    li.textContent = data.message || 'An error occurred';
                    errorList.appendChild(li);
                }
                
                errorContainer.style.display = 'block';
                
                // Scroll to error
                errorContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('An error occurred. Please try again.', 'danger');
        })
        .finally(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    });
}
</script>
@endpush