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
    <div class="col-xl-5 col-lg-6">
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
                        <select name="question_type" class="form-select form-select-lg" id="questionType" required>
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
                        <textarea name="question_text" id="questionText" class="form-control form-control-lg" rows="3" placeholder="Enter your question here..." required>{{ old('question_text') }}</textarea>
                        <div class="char-counter"><span id="questionCounter">{{ strlen(old('question_text') ?? '') }}</span>/500</div>
                    </div>

                    <!-- Points & Image Row -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Points</label>
                                <input type="number" name="points" id="points" class="form-control form-control-lg" value="{{ old('points', 1) }}" min="1">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Image</label>
                                <div class="file-input-wrapper">
                                    <input type="file" name="image" id="image" class="file-input" accept="image/*">
                                    <div class="file-input-preview" id="imagePreview">
                                        <i class="fas fa-image"></i>
                                        <span>Click to upload image</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Options Section (Multiple Choice, Single Choice, True/False) -->
                    <div id="optionsSection" class="mb-4">
                        <div class="section-label">
                            <label class="form-label fw-bold">Answer Options</label>
                            <span class="badge bg-primary" id="optionsCount">2 options</span>
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
                                               placeholder="Enter option {{ $index + 1 }}"
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
                        <button type="button" class="btn btn-sm btn-outline-primary mt-3" onclick="addOption()">
                            <i class="fas fa-plus me-1"></i> Add Option
                        </button>
                    </div>

                    <!-- Fill in the Blanks Section -->
                    <div id="fillBlanksSection" style="display: none;" class="mb-4">
                        <div class="section-label">
                            <label class="form-label fw-bold">Correct Answers</label>
                            <span class="badge bg-primary" id="blanksCount">1 answer</span>
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
                                               placeholder="Enter correct answer"
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
                        <button type="button" class="btn btn-sm btn-outline-primary mt-3" onclick="addFillBlank()">
                            <i class="fas fa-plus me-1"></i> Add Answer
                        </button>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-actions mt-4">
                        <button type="submit" class="btn btn-primary btn-lg w-100" id="submitBtn">
                            <i class="fas fa-plus-circle me-2"></i>Add Question
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Questions List Column -->
    <div class="col-xl-7 col-lg-6">
        <div class="questions-card">
            <div class="questions-card-header">
                <div>
                    <h5><i class="fas fa-list me-2"></i>Questions List</h5>
                    <p class="text-muted mb-0">{{ $quiz->questions->count() }} total questions</p>
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
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
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
    --primary: #4361ee;
    --secondary: #3f37c9;
    --success: #4cc9f0;
    --danger: #f72585;
    --warning: #f8961e;
    --info: #4895ef;
    --dark: #1e1b4b;
    --light: #f8f9fa;
}

/* Header Section */
.header-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    flex-wrap: wrap;
    gap: 20px;
    background: white;
    padding: 25px 30px;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}

.header-content h2 {
    font-size: 1.8rem;
    font-weight: 700;
    margin: 0 0 5px;
    color: var(--dark);
    letter-spacing: -0.02em;
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
    padding: 12px 24px;
    font-weight: 500;
    border-radius: 12px;
    transition: all 0.3s;
}

.header-actions .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

/* Info Bar */
.info-bar {
    background: white;
    border-radius: 20px;
    padding: 25px 30px;
    margin-bottom: 30px;
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
    gap: 25px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}

.info-bar-item {
    display: flex;
    align-items: center;
    gap: 15px;
}

.info-bar-item i {
    font-size: 2.2rem;
}

.info-bar-item div {
    display: flex;
    flex-direction: column;
}

.info-bar-item small {
    color: #6c757d;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-bar-item strong {
    font-size: 1.3rem;
    color: var(--dark);
    font-weight: 700;
}

/* Form Card */
.form-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    overflow: hidden;
    position: sticky;
    top: 20px;
    border: 1px solid rgba(0,0,0,0.05);
}

.form-card-header {
    padding: 20px 25px;
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    border-bottom: none;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.form-card-header h5 {
    margin: 0;
    font-size: 1.2rem;
    font-weight: 600;
    color: white;
}

.form-card-header .badge {
    background: rgba(255,255,255,0.2) !important;
    color: white;
    font-size: 0.9rem;
    padding: 8px 12px;
}

.form-card-body {
    padding: 25px;
    background: white;
}

/* Form Elements */
.form-group {
    margin-bottom: 1.2rem;
}

.form-label {
    font-weight: 600;
    font-size: 0.9rem;
    color: var(--dark);
    margin-bottom: 8px;
    display: block;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.form-control, .form-select {
    border: 2px solid #e9ecef;
    border-radius: 12px;
    padding: 12px 16px;
    font-size: 0.95rem;
    transition: all 0.3s;
    background: white;
}

.form-control-lg, .form-select-lg {
    padding: 14px 18px;
    font-size: 1rem;
}

.form-control:focus, .form-select:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1);
    outline: none;
}

.char-counter {
    text-align: right;
    font-size: 0.8rem;
    color: #6c757d;
    margin-top: 6px;
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
    border-radius: 12px;
    padding: 20px;
    text-align: center;
    background: #f8f9fa;
    transition: all 0.3s;
    min-height: 80px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.file-input-preview:hover {
    border-color: var(--primary);
    background: rgba(67, 97, 238, 0.02);
}

.file-input-preview i {
    font-size: 2rem;
    color: var(--primary);
    margin-bottom: 8px;
}

.file-input-preview span {
    color: #6c757d;
    font-size: 0.9rem;
}

.file-input-preview img {
    max-width: 100%;
    max-height: 80px;
    border-radius: 8px;
}

/* Options Container */
.options-container, .blanks-container {
    max-height: 350px;
    overflow-y: auto;
    padding: 5px;
    background: #f8f9fa;
    border-radius: 12px;
}

.option-row, .blank-row {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 10px;
    padding: 12px;
    background: white;
    border-radius: 12px;
    transition: all 0.3s;
    border: 1px solid #e9ecef;
    box-shadow: 0 2px 4px rgba(0,0,0,0.02);
}

.option-row:hover, .blank-row:hover {
    border-color: var(--primary);
    box-shadow: 0 5px 15px rgba(67, 97, 238, 0.1);
    transform: translateY(-2px);
}

.option-drag, .blank-drag {
    cursor: move;
    padding: 0 8px;
    color: #adb5bd;
}

.option-content, .blank-content {
    flex: 1;
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}

.option-input-wrapper, .blank-input-wrapper {
    flex: 2;
    min-width: 200px;
}

.option-input, .blank-input {
    border: 2px solid #e9ecef;
    border-radius: 10px;
    padding: 10px 14px;
    font-size: 0.95rem;
    width: 100%;
}

.option-input:focus, .blank-input:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
}

.option-correct, .blank-case {
    min-width: 90px;
}

.form-check {
    padding-left: 1.8rem;
}

.form-check-input {
    width: 1.2rem;
    height: 1.2rem;
    margin-top: 0.15rem;
    border: 2px solid #e9ecef;
}

.form-check-input:checked {
    background-color: var(--primary);
    border-color: var(--primary);
}

.form-check-label {
    font-size: 0.9rem;
    color: #495057;
}

.option-remove, .blank-remove {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    border: none;
    background: rgba(247, 37, 133, 0.1);
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
    transform: rotate(90deg);
}

.section-label {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.section-label .badge {
    font-size: 0.85rem;
    padding: 6px 12px;
}

/* Buttons */
.btn-outline-primary {
    border: 2px solid var(--primary);
    color: var(--primary);
    font-weight: 600;
    padding: 8px 16px;
    border-radius: 10px;
}

.btn-outline-primary:hover {
    background: var(--primary);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    border: none;
    font-weight: 600;
    padding: 14px 28px;
    border-radius: 12px;
    box-shadow: 0 10px 20px rgba(67, 97, 238, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 15px 30px rgba(67, 97, 238, 0.4);
}

/* Questions Card */
.questions-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    overflow: hidden;
    border: 1px solid rgba(0,0,0,0.05);
}

.questions-card-header {
    padding: 20px 25px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 1px solid #dee2e6;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
}

.questions-card-header h5 {
    margin: 0 0 4px;
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--dark);
}

.questions-card-header p {
    margin: 0;
    font-size: 0.9rem;
}

.questions-stats {
    display: flex;
    gap: 25px;
}

.questions-stats .stat {
    text-align: center;
    background: white;
    padding: 8px 16px;
    border-radius: 12px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.02);
}

.questions-stats .stat .label {
    display: block;
    font-size: 0.7rem;
    color: #6c757d;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.questions-stats .stat .value {
    font-size: 1.3rem;
    font-weight: 800;
    color: var(--primary);
    line-height: 1.2;
}

/* Questions List */
.questions-list {
    padding: 25px;
    max-height: 600px;
    overflow-y: auto;
}

.question-item {
    display: flex;
    gap: 15px;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 16px;
    margin-bottom: 20px;
    transition: all 0.3s;
    border: 1px solid #e9ecef;
    position: relative;
}

.question-item:hover {
    transform: translateX(5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    border-color: var(--primary);
}

.question-drag {
    cursor: move;
    padding-top: 8px;
    color: #adb5bd;
}

.question-content {
    flex: 1;
}

.question-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 15px;
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
    font-weight: 600;
    font-size: 0.75rem;
    border-radius: 8px;
}

.type-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.type-multiple_choice {
    background: rgba(67, 97, 238, 0.1);
    color: var(--primary);
}

.type-single_choice {
    background: rgba(76, 201, 240, 0.1);
    color: var(--success);
}

.type-true_false {
    background: rgba(248, 150, 30, 0.1);
    color: var(--warning);
}

.type-fill_blank {
    background: rgba(63, 55, 201, 0.1);
    color: var(--secondary);
}

.question-text {
    font-size: 1rem;
    color: var(--dark);
    margin-bottom: 15px;
    line-height: 1.6;
    font-weight: 500;
}

.question-image {
    margin-bottom: 15px;
}

.question-image img {
    max-width: 200px;
    max-height: 150px;
    border-radius: 12px;
    border: 2px solid white;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.question-answers {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.answer-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 15px;
    background: white;
    border-radius: 10px;
    border-left: 4px solid transparent;
    transition: all 0.3s;
}

.answer-item.correct {
    border-left-color: var(--success);
    background: rgba(76, 201, 240, 0.05);
}

.answer-marker {
    width: 28px;
    height: 28px;
    border-radius: 8px;
    background: #e9ecef;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.85rem;
    font-weight: 700;
    color: #495057;
}

.answer-text {
    flex: 1;
    font-size: 0.95rem;
    color: #495057;
}

/* Action Buttons */
.question-actions {
    display: flex;
    gap: 8px;
}

.action-btn {
    width: 36px;
    height: 36px;
    border-radius: 10px;
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
    background: rgba(67, 97, 238, 0.1);
    color: var(--primary);
}

.edit-btn:hover {
    background: var(--primary);
    color: white;
    box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
}

.delete-btn {
    background: rgba(247, 37, 133, 0.1);
    color: var(--danger);
}

.delete-btn:hover {
    background: var(--danger);
    color: white;
    box-shadow: 0 5px 15px rgba(247, 37, 133, 0.3);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 60px 20px;
}

.empty-state-icon {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 25px;
}

.empty-state-icon i {
    font-size: 3rem;
    color: #adb5bd;
}

.empty-state h5 {
    color: var(--dark);
    margin-bottom: 10px;
    font-weight: 700;
}

/* Modal */
.modal-content {
    border-radius: 20px;
    border: none;
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
}

.modal-header {
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    color: white;
    border-radius: 20px 20px 0 0;
    padding: 20px 25px;
}

.modal-header .btn-close {
    filter: brightness(0) invert(1);
}

.modal-body {
    padding: 25px;
    max-height: 70vh;
    overflow-y: auto;
}

/* Scrollbar Styling */
::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb {
    background: var(--primary);
    border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
    background: var(--secondary);
}

/* Responsive */
@media (max-width: 1200px) {
    .option-content, .blank-content {
        flex-direction: column;
        align-items: stretch;
    }
    
    .option-correct, .blank-case {
        min-width: auto;
    }
}

@media (max-width: 768px) {
    .header-section {
        flex-direction: column;
        align-items: flex-start;
        padding: 20px;
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
        padding: 20px;
    }
    
    .info-bar-item {
        width: 100%;
    }
    
    .form-card {
        position: static;
        margin-bottom: 20px;
    }
    
    .questions-stats {
        width: 100%;
        justify-content: space-around;
    }
    
    .questions-card-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .question-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .question-actions {
        width: 100%;
        justify-content: flex-end;
    }
}

@media (max-width: 576px) {
    .questions-stats {
        flex-direction: column;
        gap: 10px;
    }
    
    .questions-stats .stat {
        text-align: left;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .questions-stats .stat .label {
        display: inline-block;
        margin-right: 10px;
    }
    
    .answer-item {
        flex-wrap: wrap;
    }
    
    .option-remove, .blank-remove {
        width: 100%;
        margin-top: 5px;
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
                <span>Click to upload image</span>
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
                       placeholder="Enter option ${index + 1}">
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
            placeholder.placeholder = `Enter option ${index + 1}`;
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
                       placeholder="Enter correct answer">
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
    // Show modal with loading spinner
    const modal = new bootstrap.Modal(document.getElementById('editQuestionModal'));
    document.getElementById('editQuestionContent').innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    `;
    modal.show();
    
    // Fetch question data
    fetch(`/admin/quizzes/questions/${id}/edit`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(question => {
        // Build the edit form
        const form = buildEditForm(question);
        document.getElementById('editQuestionContent').innerHTML = form;
        
        // Initialize form handlers
        initializeEditForm(question.id);
    })
    .catch(error => {
        document.getElementById('editQuestionContent').innerHTML = `
            <div class="alert alert-danger">
                Error loading question. Please try again.
            </div>
        `;
    });
}

function buildEditForm(question) {
    let optionsHtml = '';
    let blanksHtml = '';
    
    // Build options HTML for multiple choice/single choice/true false
    if (['multiple_choice', 'single_choice', 'true_false'].includes(question.question_type)) {
        optionsHtml = question.options.map((option, index) => `
            <div class="option-row" data-index="${index}">
                <div class="option-drag">
                    <i class="fas fa-grip-vertical text-muted"></i>
                </div>
                <div class="option-content">
                    <div class="option-input-wrapper">
                        <input type="text" 
                               name="options[${index}][text]" 
                               class="form-control option-input" 
                               placeholder="Enter option ${index + 1}"
                               value="${option.option_text.replace(/"/g, '&quot;')}">
                    </div>
                    <div class="option-correct">
                        <div class="form-check">
                            <input type="checkbox" 
                                   name="options[${index}][is_correct]" 
                                   id="option${index}Correct" 
                                   class="form-check-input" 
                                   value="1"
                                   ${option.is_correct ? 'checked' : ''}>
                            <label class="form-check-label" for="option${index}Correct">
                                Correct
                            </label>
                        </div>
                    </div>
                    <button type="button" class="option-remove" onclick="removeOption(this)">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        `).join('');
    }
    
    // Build fill blanks HTML
    if (question.question_type === 'fill_blank') {
        blanksHtml = question.fill_blanks.map((blank, index) => `
            <div class="blank-row" data-index="${index}">
                <div class="blank-drag">
                    <i class="fas fa-grip-vertical text-muted"></i>
                </div>
                <div class="blank-content">
                    <div class="blank-input-wrapper">
                        <input type="text" 
                               name="fill_blanks[${index}][answer]" 
                               class="form-control blank-input" 
                               placeholder="Enter correct answer"
                               value="${blank.correct_answer.replace(/"/g, '&quot;')}">
                    </div>
                    <div class="blank-case">
                        <div class="form-check">
                            <input type="checkbox" 
                                   name="fill_blanks[${index}][case_sensitive]" 
                                   id="blank${index}Case" 
                                   class="form-check-input" 
                                   value="1"
                                   ${blank.case_sensitive ? 'checked' : ''}>
                            <label class="form-check-label" for="blank${index}Case">
                                Case Sensitive
                            </label>
                        </div>
                    </div>
                    <button type="button" class="blank-remove" onclick="removeBlank(this)">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        `).join('');
    }
    
    // Build the complete form
    return `
        <form id="editQuestionForm" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
            <input type="hidden" name="_method" value="PUT">
            
            <!-- Question Type -->
            <div class="form-group mb-4">
                <label class="form-label">Question Type</label>
                <select name="question_type" class="form-select form-select-lg" id="editQuestionType" required>
                    <option value="multiple_choice" ${question.question_type === 'multiple_choice' ? 'selected' : ''}>Multiple Choice (Select all that apply)</option>
                    <option value="single_choice" ${question.question_type === 'single_choice' ? 'selected' : ''}>Single Choice (Select one)</option>
                    <option value="true_false" ${question.question_type === 'true_false' ? 'selected' : ''}>True/False</option>
                    <option value="fill_blank" ${question.question_type === 'fill_blank' ? 'selected' : ''}>Fill in the Blank</option>
                    <option value="matching" ${question.question_type === 'matching' ? 'selected' : ''}>Matching</option>
                    <option value="image_selection" ${question.question_type === 'image_selection' ? 'selected' : ''}>Image Selection</option>
                </select>
            </div>
            
            <!-- Question Text -->
            <div class="form-group mb-4">
                <label class="form-label">Question Text</label>
                <textarea name="question_text" class="form-control form-control-lg" rows="3" required>${question.question_text.replace(/</g, '&lt;')}</textarea>
            </div>
            
            <!-- Points -->
            <div class="form-group mb-4">
                <label class="form-label">Points</label>
                <input type="number" name="points" class="form-control form-control-lg" value="${question.points}" min="1">
            </div>
            
            <!-- Current Image -->
            ${question.image ? `
                <div class="form-group mb-4">
                    <label class="form-label">Current Image</label>
                    <div>
                        <img src="/storage/${question.image}" alt="Question image" style="max-width: 200px; max-height: 150px; border-radius: 12px; border: 2px solid #e9ecef;">
                    </div>
                </div>
            ` : ''}
            
            <!-- New Image -->
            <div class="form-group mb-4">
                <label class="form-label">${question.image ? 'Change Image' : 'Image'}</label>
                <input type="file" name="image" class="form-control form-control-lg" accept="image/*">
            </div>
            
            <!-- Options Section -->
            <div id="editOptionsSection" class="mb-4" style="${question.question_type === 'fill_blank' ? 'display: none;' : 'display: block;'}">
                <div class="section-label">
                    <label class="form-label fw-bold">Answer Options</label>
                    <span class="badge bg-primary" id="editOptionsCount">${question.options ? question.options.length : 2} options</span>
                </div>
                <div id="editOptionsContainer" class="options-container">
                    ${optionsHtml || `
                        <div class="option-row" data-index="0">
                            <div class="option-drag"><i class="fas fa-grip-vertical text-muted"></i></div>
                            <div class="option-content">
                                <div class="option-input-wrapper">
                                    <input type="text" name="options[0][text]" class="form-control option-input" placeholder="Enter option 1">
                                </div>
                                <div class="option-correct">
                                    <div class="form-check">
                                        <input type="checkbox" name="options[0][is_correct]" id="option0Correct" class="form-check-input" value="1">
                                        <label class="form-check-label" for="option0Correct">Correct</label>
                                    </div>
                                </div>
                                <button type="button" class="option-remove" onclick="removeOption(this)"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                        <div class="option-row" data-index="1">
                            <div class="option-drag"><i class="fas fa-grip-vertical text-muted"></i></div>
                            <div class="option-content">
                                <div class="option-input-wrapper">
                                    <input type="text" name="options[1][text]" class="form-control option-input" placeholder="Enter option 2">
                                </div>
                                <div class="option-correct">
                                    <div class="form-check">
                                        <input type="checkbox" name="options[1][is_correct]" id="option1Correct" class="form-check-input" value="1">
                                        <label class="form-check-label" for="option1Correct">Correct</label>
                                    </div>
                                </div>
                                <button type="button" class="option-remove" onclick="removeOption(this)"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                    `}
                </div>
                <button type="button" class="btn btn-sm btn-outline-primary mt-3" onclick="addEditOption()">
                    <i class="fas fa-plus me-1"></i> Add Option
                </button>
            </div>
            
            <!-- Fill Blanks Section -->
            <div id="editFillBlanksSection" class="mb-4" style="${question.question_type === 'fill_blank' ? 'display: block;' : 'display: none;'}">
                <div class="section-label">
                    <label class="form-label fw-bold">Correct Answers</label>
                    <span class="badge bg-primary" id="editBlanksCount">${question.fill_blanks ? question.fill_blanks.length : 1} answers</span>
                </div>
                <div id="editBlanksContainer" class="blanks-container">
                    ${blanksHtml || `
                        <div class="blank-row" data-index="0">
                            <div class="blank-drag"><i class="fas fa-grip-vertical text-muted"></i></div>
                            <div class="blank-content">
                                <div class="blank-input-wrapper">
                                    <input type="text" name="fill_blanks[0][answer]" class="form-control blank-input" placeholder="Enter correct answer">
                                </div>
                                <div class="blank-case">
                                    <div class="form-check">
                                        <input type="checkbox" name="fill_blanks[0][case_sensitive]" id="blank0Case" class="form-check-input" value="1">
                                        <label class="form-check-label" for="blank0Case">Case Sensitive</label>
                                    </div>
                                </div>
                                <button type="button" class="blank-remove" onclick="removeBlank(this)"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                    `}
                </div>
                <button type="button" class="btn btn-sm btn-outline-primary mt-3" onclick="addEditBlank()">
                    <i class="fas fa-plus me-1"></i> Add Answer
                </button>
            </div>
            
            <!-- Submit Button -->
            <div class="form-actions mt-4">
                <button type="submit" class="btn btn-primary btn-lg w-100">
                    <i class="fas fa-save me-2"></i>Update Question
                </button>
            </div>
        </form>
    `;
}

function initializeEditForm(questionId) {
    const form = document.getElementById('editQuestionForm');
    const questionType = document.getElementById('editQuestionType');
    
    // Initialize Sortable
    const optionsContainer = document.getElementById('editOptionsContainer');
    if (optionsContainer) {
        new Sortable(optionsContainer, {
            handle: '.option-drag',
            animation: 150,
            onEnd: function() {
                updateEditOptionsIndices();
            }
        });
    }
    
    const blanksContainer = document.getElementById('editBlanksContainer');
    if (blanksContainer) {
        new Sortable(blanksContainer, {
            handle: '.blank-drag',
            animation: 150,
            onEnd: function() {
                updateEditBlanksIndices();
            }
        });
    }
    
    // Handle question type change
    questionType.addEventListener('change', function() {
        const optionsSection = document.getElementById('editOptionsSection');
        const blanksSection = document.getElementById('editFillBlanksSection');
        
        if (this.value === 'fill_blank') {
            optionsSection.style.display = 'none';
            blanksSection.style.display = 'block';
        } else {
            optionsSection.style.display = 'block';
            blanksSection.style.display = 'none';
        }
    });
    
    // Handle form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch(`/admin/quizzes/questions/${questionId}`, {
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
                // Close modal
                bootstrap.Modal.getInstance(document.getElementById('editQuestionModal')).hide();
                
                // Show success message
                alert('Question updated successfully!');
                
                // Reload the page to show updated question
                location.reload();
            }
        })
        .catch(error => {
            alert('Error updating question. Please check the form and try again.');
        });
    });
}

// Helper functions for edit form
function addEditOption() {
    const container = document.getElementById('editOptionsContainer');
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
                       placeholder="Enter option ${index + 1}">
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
    document.getElementById('editOptionsCount').textContent = container.children.length + ' options';
}

function addEditBlank() {
    const container = document.getElementById('editBlanksContainer');
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
                       placeholder="Enter correct answer">
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
    document.getElementById('editBlanksCount').textContent = container.children.length + ' answers';
}

function updateEditOptionsIndices() {
    const rows = document.querySelectorAll('#editOptionsContainer .option-row');
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
            placeholder.placeholder = `Enter option ${index + 1}`;
        }
    });
}

function updateEditBlanksIndices() {
    const rows = document.querySelectorAll('#editBlanksContainer .blank-row');
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
</script>
@endpush