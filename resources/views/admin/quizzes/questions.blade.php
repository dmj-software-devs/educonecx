@extends('layouts.admin')

@section('title', 'Quiz Questions')
@section('page-title', 'Quiz Questions: ' . $quiz->title)

@section('content')
<!-- Header Section -->
<div class="header-section">
    <div class="header-content">
        <h2>{{ $quiz->title }}</h2>
        <p>Manage questions for this quiz</p>
    </div>
    <div class="header-actions">
        <a href="{{ route('admin.quizzes.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back to Quizzes
        </a>
        <a href="{{ route('admin.quizzes.edit', $quiz) }}" class="btn btn-outline-primary">
            <i class="fas fa-edit"></i> Edit Quiz
        </a>
    </div>
</div>

<!-- Quiz Info Bar -->
<div class="info-bar">
    <div class="info-bar-item">
        <i class="fas fa-puzzle-piece text-primary"></i>
        <div>
            <small>Quiz Type</small>
            <strong>{{ ucfirst($quiz->type) }}</strong>
        </div>
    </div>
    <div class="info-bar-item">
        <i class="fas fa-question-circle text-success"></i>
        <div>
            <small>Total Questions</small>
            <strong>{{ $quiz->questions->count() }}</strong>
        </div>
    </div>
    <div class="info-bar-item">
        <i class="fas fa-star text-warning"></i>
        <div>
            <small>Total Points</small>
            <strong>{{ $quiz->questions->sum('points') }}</strong>
        </div>
    </div>
    <div class="info-bar-item">
        <i class="fas fa-percent text-info"></i>
        <div>
            <small>Pass Percentage</small>
            <strong>{{ $quiz->pass_percentage ?? 0 }}%</strong>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Add Question Form Column -->
    <div class="col-xl-4 col-lg-5">
        <div class="form-card sticky-form">
            <div class="form-card-header">
                <h5><i class="fas fa-plus-circle me-2"></i>Add New Question</h5>
                <span class="badge bg-primary">{{ $quiz->questions->count() + 1 }}</span>
            </div>
            
            <div class="form-card-body">
                <form action="{{ route('admin.quizzes.questions.store', $quiz) }}" method="POST" enctype="multipart/form-data" id="questionForm">
                    @csrf
                    
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            <strong>Please fix the following errors:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    <!-- Question Type -->
                    <div class="form-group mb-4">
                        <label class="form-label">Question Type <span class="text-danger">*</span></label>
                        <select name="question_type" class="form-select" id="questionType" required>
                            <option value="multiple_choice" {{ old('question_type') == 'multiple_choice' ? 'selected' : '' }}>Multiple Choice (Select all that apply)</option>
                            <option value="single_choice" {{ old('question_type') == 'single_choice' ? 'selected' : '' }}>Single Choice (Select one)</option>
                            <option value="true_false" {{ old('question_type') == 'true_false' ? 'selected' : '' }}>True/False</option>
                            <option value="fill_blank" {{ old('question_type') == 'fill_blank' ? 'selected' : '' }}>Fill in the Blank</option>
                            <option value="matching" {{ old('question_type') == 'matching' ? 'selected' : '' }}>Matching</option>
                            <option value="image_selection" {{ old('question_type') == 'image_selection' ? 'selected' : '' }}>Image Selection</option>
                        </select>
                    </div>

                    <!-- Question Text -->
                    <div class="form-group mb-4">
                        <label class="form-label">Question Text <span class="text-danger">*</span></label>
                        <textarea name="question_text" id="questionText" class="form-control" rows="3" placeholder="Enter your question here..." required>{{ old('question_text') }}</textarea>
                        <div class="char-counter"><span id="questionCounter">{{ strlen(old('question_text') ?? '') }}</span>/500</div>
                    </div>

                    <!-- Points & Image Row -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Points</label>
                                <input type="number" name="points" id="points" class="form-control" value="{{ old('points', 1) }}" min="1">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Image</label>
                                <div class="file-input-wrapper">
                                    <input type="file" name="image" id="image" class="file-input" accept="image/*">
                                    <div class="file-input-preview" id="imagePreview">
                                        <i class="fas fa-image"></i>
                                        <span>Click to upload</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Options Section (Multiple Choice, Single Choice, True/False) -->
                    <div id="optionsSection" class="mb-4">
                        <div class="section-label">
                            <label class="form-label">Answer Options</label>
                            <span class="badge bg-light text-dark" id="optionsCount">2 options</span>
                        </div>
                        <div id="optionsContainer" class="options-container">
                            @php
                                $oldOptions = old('options', [
                                    ['text' => '', 'is_correct' => false],
                                    ['text' => '', 'is_correct' => false]
                                ]);
                            @endphp
                            
                            @foreach($oldOptions as $index => $option)
                            <div class="option-row" data-index="{{ $index }}">
                                <div class="option-drag">
                                    <i class="fas fa-grip-vertical text-muted"></i>
                                </div>
                                <div class="option-content">
                                    <div class="option-input-wrapper">
                                        <input type="text" 
                                               name="options[{{ $index }}][text]" 
                                               class="form-control option-input" 
                                               placeholder="Option {{ $index + 1 }}"
                                               value="{{ $option['text'] ?? '' }}">
                                    </div>
                                    <div class="option-correct">
                                        <div class="form-check">
                                            <input type="checkbox" 
                                                   name="options[{{ $index }}][is_correct]" 
                                                   id="option{{ $index }}Correct" 
                                                   class="form-check-input" 
                                                   value="1"
                                                   {{ isset($option['is_correct']) && $option['is_correct'] ? 'checked' : '' }}>
                                            <label class="form-check-label" for="option{{ $index }}Correct">
                                                Correct
                                            </label>
                                        </div>
                                    </div>
                                    <button type="button" class="option-remove" onclick="removeOption(this)">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="addOption()">
                            <i class="fas fa-plus me-1"></i> Add Option
                        </button>
                    </div>

                    <!-- Fill in the Blanks Section -->
                    <div id="fillBlanksSection" style="display: none;" class="mb-4">
                        <div class="section-label">
                            <label class="form-label">Correct Answers</label>
                            <span class="badge bg-light text-dark" id="blanksCount">1 answer</span>
                        </div>
                        <div id="fillBlanksContainer" class="blanks-container">
                            @php
                                $oldFillBlanks = old('fill_blanks', [
                                    ['answer' => '', 'case_sensitive' => false]
                                ]);
                            @endphp
                            
                            @foreach($oldFillBlanks as $index => $blank)
                            <div class="blank-row" data-index="{{ $index }}">
                                <div class="blank-drag">
                                    <i class="fas fa-grip-vertical text-muted"></i>
                                </div>
                                <div class="blank-content">
                                    <div class="blank-input-wrapper">
                                        <input type="text" 
                                               name="fill_blanks[{{ $index }}][answer]" 
                                               class="form-control blank-input" 
                                               placeholder="Answer"
                                               value="{{ $blank['answer'] ?? '' }}">
                                    </div>
                                    <div class="blank-case">
                                        <div class="form-check">
                                            <input type="checkbox" 
                                                   name="fill_blanks[{{ $index }}][case_sensitive]" 
                                                   id="blank{{ $index }}Case" 
                                                   class="form-check-input" 
                                                   value="1"
                                                   {{ isset($blank['case_sensitive']) && $blank['case_sensitive'] ? 'checked' : '' }}>
                                            <label class="form-check-label" for="blank{{ $index }}Case">
                                                Case Sensitive
                                            </label>
                                        </div>
                                    </div>
                                    <button type="button" class="blank-remove" onclick="removeBlank(this)">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="addFillBlank()">
                            <i class="fas fa-plus me-1"></i> Add Answer
                        </button>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary w-100" id="submitBtn">
                            <i class="fas fa-plus-circle me-2"></i>Add Question
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Questions List Column -->
    <div class="col-xl-8 col-lg-7">
        <div class="questions-card">
            <div class="questions-card-header">
                <div>
                    <h5><i class="fas fa-list me-2"></i>Questions List</h5>
                    <p class="text-muted">{{ $quiz->questions->count() }} total questions</p>
                </div>
                <div class="questions-stats">
                    <div class="stat">
                        <span class="label">Total Points</span>
                        <span class="value">{{ $quiz->questions->sum('points') }}</span>
                    </div>
                </div>
            </div>

            <div class="questions-list">
                @forelse($quiz->questions as $question)
                <div class="question-item" id="question-{{ $question->id }}">
                    <div class="question-drag">
                        <i class="fas fa-grip-vertical text-muted"></i>
                    </div>
                    <div class="question-content">
                        <div class="question-header">
                            <div class="question-badges">
                                <span class="badge bg-primary">Q{{ $loop->iteration }}</span>
                                <span class="type-badge type-{{ $question->question_type }}">
                                    {{ str_replace('_', ' ', ucfirst($question->question_type)) }}
                                </span>
                                <span class="badge bg-info">{{ $question->points }} pts</span>
                            </div>
                            <div class="question-actions">
                                <button type="button" class="action-btn edit-btn" onclick="editQuestion({{ $question->id }})" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="action-btn delete-btn" onclick="deleteQuestion({{ $question->id }})" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        <div class="question-text">
                            {{ $question->question_text }}
                        </div>
                        @if($question->image)
                        <div class="question-image">
                            <img src="{{ Storage::url($question->image) }}" alt="Question image">
                        </div>
                        @endif
                        <div class="question-answers">
                            @if(in_array($question->question_type, ['multiple_choice', 'single_choice', 'true_false']))
                                @foreach($question->options as $option)
                                <div class="answer-item {{ $option->is_correct ? 'correct' : '' }}">
                                    <span class="answer-marker">{{ chr(65 + $loop->index) }}</span>
                                    <span class="answer-text">{{ $option->option_text }}</span>
                                    @if($option->is_correct)
                                        <i class="fas fa-check-circle text-success ms-auto"></i>
                                    @endif
                                </div>
                                @endforeach
                            @elseif($question->question_type == 'fill_blank')
                                @foreach($question->fillBlanks as $blank)
                                <div class="answer-item correct">
                                    <i class="fas fa-pencil-alt me-2"></i>
                                    <span class="answer-text">{{ $blank->correct_answer }}</span>
                                    @if($blank->case_sensitive)
                                        <span class="badge bg-warning ms-2">Case Sensitive</span>
                                    @endif
                                </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-question-circle"></i>
                    </div>
                    <h5>No Questions Yet</h5>
                    <p class="text-muted">Start by adding your first question using the form</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Delete Form -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<!-- Edit Question Modal -->
<div class="modal fade" id="editQuestionModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Question</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="editQuestionContent">
                <!-- Will be loaded via AJAX -->
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
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

/* Form Card */
.form-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    overflow: hidden;
    position: sticky;
    top: 20px;
}

.form-card-header {
    padding: 20px 24px;
    background: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.form-card-header h5 {
    margin: 0;
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--dark);
}

.form-card-body {
    padding: 24px;
}

/* Form Elements */
.form-group {
    margin-bottom: 1rem;
}

.form-label {
    font-weight: 500;
    font-size: 0.9rem;
    color: #495057;
    margin-bottom: 8px;
    display: block;
}

.form-control, .form-select {
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 10px 12px;
    font-size: 0.95rem;
    transition: all 0.3s;
}

.form-control:focus, .form-select:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(1, 123, 254, 0.1);
    outline: none;
}

.char-counter {
    text-align: right;
    font-size: 0.8rem;
    color: #6c757d;
    margin-top: 4px;
}

/* File Input */
.file-input-wrapper {
    position: relative;
    cursor: pointer;
}

.file-input {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
    z-index: 2;
}

.file-input-preview {
    border: 2px dashed #e9ecef;
    border-radius: 8px;
    padding: 20px;
    text-align: center;
    background: #f8f9fa;
    transition: all 0.3s;
}

.file-input-preview:hover {
    border-color: var(--primary);
    background: rgba(1, 123, 254, 0.02);
}

.file-input-preview i {
    font-size: 2rem;
    color: var(--primary);
    margin-bottom: 8px;
    display: block;
}

.file-input-preview span {
    color: #6c757d;
    font-size: 0.9rem;
}

/* Options Container */
.options-container, .blanks-container {
    max-height: 300px;
    overflow-y: auto;
    padding: 4px;
}

.option-row, .blank-row {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 10px;
    padding: 8px;
    background: #f8f9fa;
    border-radius: 8px;
    transition: all 0.3s;
}

.option-row:hover, .blank-row:hover {
    background: #e9ecef;
}

.option-drag, .blank-drag {
    cursor: move;
    padding: 0 4px;
}

.option-content, .blank-content {
    flex: 1;
    display: flex;
    align-items: center;
    gap: 8px;
}

.option-input-wrapper, .blank-input-wrapper {
    flex: 1;
}

.option-correct, .blank-case {
    min-width: 80px;
}

.option-remove, .blank-remove {
    width: 28px;
    height: 28px;
    border-radius: 6px;
    border: none;
    background: rgba(231, 76, 60, 0.1);
    color: var(--danger);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s;
}

.option-remove:hover, .blank-remove:hover {
    background: var(--danger);
    color: white;
}

.section-label {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
}

/* Questions Card */
.questions-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    overflow: hidden;
}

.questions-card-header {
    padding: 20px 24px;
    background: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
}

.questions-card-header h5 {
    margin: 0 0 4px;
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--dark);
}

.questions-card-header p {
    margin: 0;
}

.questions-stats {
    display: flex;
    gap: 20px;
}

.questions-stats .stat {
    text-align: center;
}

.questions-stats .stat .label {
    display: block;
    font-size: 0.75rem;
    color: #6c757d;
}

.questions-stats .stat .value {
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--dark);
}

/* Questions List */
.questions-list {
    padding: 20px;
}

.question-item {
    display: flex;
    gap: 12px;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 12px;
    margin-bottom: 16px;
    transition: all 0.3s;
}

.question-item:hover {
    transform: translateX(4px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.question-drag {
    cursor: move;
    padding-top: 4px;
}

.question-content {
    flex: 1;
}

.question-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 12px;
    flex-wrap: wrap;
    gap: 10px;
}

.question-badges {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.question-badges .badge {
    padding: 6px 12px;
    font-weight: 500;
}

.type-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 500;
}

.type-multiple_choice {
    background: rgba(1, 123, 254, 0.1);
    color: var(--primary);
}

.type-single_choice {
    background: rgba(0, 184, 148, 0.1);
    color: var(--success);
}

.type-true_false {
    background: rgba(243, 156, 18, 0.1);
    color: var(--warning);
}

.type-fill_blank {
    background: rgba(108, 92, 231, 0.1);
    color: var(--secondary);
}

.question-text {
    font-size: 1rem;
    color: var(--dark);
    margin-bottom: 12px;
    line-height: 1.5;
}

.question-image {
    margin-bottom: 12px;
}

.question-image img {
    max-width: 200px;
    max-height: 150px;
    border-radius: 8px;
    border: 1px solid #e9ecef;
}

.question-answers {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.answer-item {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 12px;
    background: white;
    border-radius: 6px;
    border-left: 3px solid transparent;
}

.answer-item.correct {
    border-left-color: var(--success);
    background: rgba(0, 184, 148, 0.05);
}

.answer-marker {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: #e9ecef;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
    font-weight: 600;
    color: #495057;
}

.answer-text {
    flex: 1;
    font-size: 0.95rem;
}

/* Action Buttons */
.question-actions {
    display: flex;
    gap: 6px;
}

.action-btn {
    width: 32px;
    height: 32px;
    border-radius: 6px;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s;
    cursor: pointer;
}

.action-btn:hover {
    transform: translateY(-2px);
}

.edit-btn {
    background: rgba(1, 123, 254, 0.1);
    color: var(--primary);
}

.edit-btn:hover {
    background: var(--primary);
    color: white;
}

.delete-btn {
    background: rgba(231, 76, 60, 0.1);
    color: var(--danger);
}

.delete-btn:hover {
    background: var(--danger);
    color: white;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 60px 20px;
}

.empty-state-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
}

.empty-state-icon i {
    font-size: 2.5rem;
    color: #adb5bd;
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
    
    .form-card {
        position: static;
        margin-bottom: 20px;
    }
    
    .questions-stats {
        width: 100%;
        justify-content: space-around;
    }
    
    .option-content, .blank-content {
        flex-wrap: wrap;
    }
    
    .option-correct, .blank-case {
        min-width: auto;
    }
}

@media (max-width: 576px) {
    .question-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .question-actions {
        width: 100%;
        justify-content: flex-end;
    }
    
    .answer-item {
        flex-wrap: wrap;
    }
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
let optionCount = {{ count(old('options', [['text' => ''], ['text' => '']])) }};
let fillBlankCount = {{ count(old('fill_blanks', [['answer' => '']])) }};

document.addEventListener('DOMContentLoaded', function() {
    // Initialize Sortable for options
    const optionsContainer = document.getElementById('optionsContainer');
    if (optionsContainer) {
        new Sortable(optionsContainer, {
            handle: '.option-drag',
            animation: 150,
            onEnd: updateOptionsIndices
        });
    }
    
    // Initialize Sortable for blanks
    const blanksContainer = document.getElementById('fillBlanksContainer');
    if (blanksContainer) {
        new Sortable(blanksContainer, {
            handle: '.blank-drag',
            animation: 150,
            onEnd: updateBlanksIndices
        });
    }
    
    // Initialize question type
    const questionType = document.getElementById('questionType');
    toggleSections(questionType.value);
    
    // Add change event listener
    questionType.addEventListener('change', function() {
        toggleSections(this.value);
    });

    // Question text counter
    const questionText = document.getElementById('questionText');
    questionText.addEventListener('input', function() {
        document.getElementById('questionCounter').textContent = this.value.length;
    });

    // Image preview
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');
    
    imageInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.innerHTML = `
                    <img src="${e.target.result}" alt="Preview" style="max-width: 100%; max-height: 100px; border-radius: 4px;">
                `;
            }
            reader.readAsDataURL(this.files[0]);
        } else {
            imagePreview.innerHTML = `
                <i class="fas fa-image"></i>
                <span>Click to upload</span>
            `;
        }
    });

    // Form submission
    const form = document.getElementById('questionForm');
    form.addEventListener('submit', function(e) {
        enableCurrentSectionInputs();
    });
});

function toggleSections(type) {
    const optionsSection = document.getElementById('optionsSection');
    const fillBlanksSection = document.getElementById('fillBlanksSection');
    
    // First, disable all inputs in both sections
    disableAllInputs();
    
    if (type === 'fill_blank') {
        optionsSection.style.display = 'none';
        fillBlanksSection.style.display = 'block';
        enableFillBlanksInputs();
    } else {
        optionsSection.style.display = 'block';
        fillBlanksSection.style.display = 'none';
        enableOptionsInputs();
    }
}

function disableAllInputs() {
    document.querySelectorAll('.option-input, .option-row input[type="checkbox"], .blank-input, .blank-row input[type="checkbox"]').forEach(input => {
        input.disabled = true;
    });
}

function enableOptionsInputs() {
    document.querySelectorAll('.option-input, .option-row input[type="checkbox"]').forEach(input => {
        input.disabled = false;
    });
    document.getElementById('optionsCount').textContent = document.querySelectorAll('.option-row').length + ' options';
}

function enableFillBlanksInputs() {
    document.querySelectorAll('.blank-input, .blank-row input[type="checkbox"]').forEach(input => {
        input.disabled = false;
    });
    document.getElementById('blanksCount').textContent = document.querySelectorAll('.blank-row').length + ' answers';
}

function enableCurrentSectionInputs() {
    const type = document.getElementById('questionType').value;
    if (type === 'fill_blank') {
        enableFillBlanksInputs();
    } else {
        enableOptionsInputs();
    }
}

function addOption() {
    const container = document.getElementById('optionsContainer');
    const index = container.children.length;
    
    const div = document.createElement('div');
    div.className = 'option-row';
    div.setAttribute('data-index', index);
    div.innerHTML = `
        <div class="option-drag">
            <i class="fas fa-grip-vertical text-muted"></i>
        </div>
        <div class="option-content">
            <div class="option-input-wrapper">
                <input type="text" 
                       name="options[${index}][text]" 
                       class="form-control option-input" 
                       placeholder="Option ${index + 1}">
            </div>
            <div class="option-correct">
                <div class="form-check">
                    <input type="checkbox" 
                           name="options[${index}][is_correct]" 
                           id="option${index}Correct" 
                           class="form-check-input" 
                           value="1">
                    <label class="form-check-label" for="option${index}Correct">
                        Correct
                    </label>
                </div>
            </div>
            <button type="button" class="option-remove" onclick="removeOption(this)">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    container.appendChild(div);
    
    // Enable inputs if needed
    if (document.getElementById('questionType').value !== 'fill_blank') {
        div.querySelectorAll('input').forEach(input => input.disabled = false);
    }
    
    document.getElementById('optionsCount').textContent = container.children.length + ' options';
}

function removeOption(btn) {
    const row = btn.closest('.option-row');
    row.remove();
    updateOptionsIndices();
    document.getElementById('optionsCount').textContent = document.querySelectorAll('.option-row').length + ' options';
}

function updateOptionsIndices() {
    const rows = document.querySelectorAll('#optionsContainer .option-row');
    rows.forEach((row, index) => {
        row.setAttribute('data-index', index);
        const inputs = row.querySelectorAll('input[type="text"]');
        inputs.forEach(input => {
            input.name = `options[${index}][text]`;
        });
        
        const checkboxes = row.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach((checkbox, cbIndex) => {
            checkbox.name = `options[${index}][is_correct]`;
            checkbox.id = `option${index}Correct`;
            const label = row.querySelector(`label[for="option${cbIndex}Correct"]`);
            if (label) {
                label.htmlFor = `option${index}Correct`;
            }
        });
        
        const placeholder = row.querySelector('input[type="text"]');
        if (placeholder) {
            placeholder.placeholder = `Option ${index + 1}`;
        }
    });
}

function addFillBlank() {
    const container = document.getElementById('fillBlanksContainer');
    const index = container.children.length;
    
    const div = document.createElement('div');
    div.className = 'blank-row';
    div.setAttribute('data-index', index);
    div.innerHTML = `
        <div class="blank-drag">
            <i class="fas fa-grip-vertical text-muted"></i>
        </div>
        <div class="blank-content">
            <div class="blank-input-wrapper">
                <input type="text" 
                       name="fill_blanks[${index}][answer]" 
                       class="form-control blank-input" 
                       placeholder="Answer">
            </div>
            <div class="blank-case">
                <div class="form-check">
                    <input type="checkbox" 
                           name="fill_blanks[${index}][case_sensitive]" 
                           id="blank${index}Case" 
                           class="form-check-input" 
                           value="1">
                    <label class="form-check-label" for="blank${index}Case">
                        Case Sensitive
                    </label>
                </div>
            </div>
            <button type="button" class="blank-remove" onclick="removeBlank(this)">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    container.appendChild(div);
    
    // Enable inputs if needed
    if (document.getElementById('questionType').value === 'fill_blank') {
        div.querySelectorAll('input').forEach(input => input.disabled = false);
    }
    
    document.getElementById('blanksCount').textContent = container.children.length + ' answers';
}

function removeBlank(btn) {
    const row = btn.closest('.blank-row');
    row.remove();
    updateBlanksIndices();
    document.getElementById('blanksCount').textContent = document.querySelectorAll('.blank-row').length + ' answers';
}

function updateBlanksIndices() {
    const rows = document.querySelectorAll('#fillBlanksContainer .blank-row');
    rows.forEach((row, index) => {
        row.setAttribute('data-index', index);
        const inputs = row.querySelectorAll('input[type="text"]');
        inputs.forEach(input => {
            input.name = `fill_blanks[${index}][answer]`;
        });
        
        const checkboxes = row.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach((checkbox, cbIndex) => {
            checkbox.name = `fill_blanks[${index}][case_sensitive]`;
            checkbox.id = `blank${index}Case`;
            const label = row.querySelector(`label[for="blank${cbIndex}Case"]`);
            if (label) {
                label.htmlFor = `blank${index}Case`;
            }
        });
    });
}

function deleteQuestion(id) {
    if (confirm('Are you sure you want to delete this question? This action cannot be undone.')) {
        const form = document.getElementById('deleteForm');
        form.action = '{{ url("admin/quizzes/questions") }}/' + id;
        form.submit();
    }
}

function editQuestion(id) {
    // You would typically load the question data via AJAX here
    // For now, just show an alert
    alert('Edit functionality will be implemented with AJAX');
}
</script>
@endpush