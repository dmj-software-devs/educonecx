@extends('layouts.admin')

@section('title', 'Quiz Questions')
@section('page-title', 'Quiz Questions: ' . $quiz->title)

@section('content')
<!-- Header Section with Gradient -->
<div class="header-wrapper">
    <div class="header-section">
        <div class="header-content">
            <div class="header-icon">
                <i class="fas fa-question-circle"></i>
            </div>
            <div>
                <h2>{{ $quiz->title }}</h2>
                <p><i class="fas fa-file-alt me-2"></i>Manage questions for this quiz</p>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.quizzes.index') }}" class="btn btn-outline-light">
                <i class="fas fa-arrow-left me-2"></i> Back to Quizzes
            </a>
            <a href="{{ route('admin.quizzes.edit', $quiz) }}" class="btn btn-light">
                <i class="fas fa-edit me-2"></i> Edit Quiz
            </a>
        </div>
    </div>
</div>

<!-- Quiz Info Cards -->
<div class="info-cards">
    <div class="info-card info-card-primary">
        <div class="info-card-icon">
            <i class="fas fa-puzzle-piece"></i>
        </div>
        <div class="info-card-content">
            <span class="info-card-label">Quiz Type</span>
            <span class="info-card-value">{{ ucfirst($quiz->type) }}</span>
        </div>
    </div>
    
    <div class="info-card info-card-success">
        <div class="info-card-icon">
            <i class="fas fa-question-circle"></i>
        </div>
        <div class="info-card-content">
            <span class="info-card-label">Total Questions</span>
            <span class="info-card-value">{{ $quiz->questions->count() }}</span>
        </div>
    </div>
    
    <div class="info-card info-card-warning">
        <div class="info-card-icon">
            <i class="fas fa-star"></i>
        </div>
        <div class="info-card-content">
            <span class="info-card-label">Total Points</span>
            <span class="info-card-value">{{ $quiz->questions->sum('points') }}</span>
        </div>
    </div>
    
    <div class="info-card info-card-info">
        <div class="info-card-icon">
            <i class="fas fa-percent"></i>
        </div>
        <div class="info-card-content">
            <span class="info-card-label">Pass Percentage</span>
            <span class="info-card-value">{{ $quiz->pass_percentage ?? 0 }}%</span>
        </div>
    </div>
</div>

<div class="content-grid">
    <!-- Add Question Form Column -->
    <div class="form-column">
        <div class="form-container">
            <div class="form-header">
                <div class="form-header-title">
                    <i class="fas fa-plus-circle"></i>
                    <h3>Add New Question</h3>
                </div>
                <span class="question-number">{{ $quiz->questions->count() + 1 }}</span>
            </div>
            
            <div class="form-body">
                <form action="{{ route('admin.quizzes.questions.store', $quiz) }}" method="POST" enctype="multipart/form-data" id="questionForm">
                    @csrf
                    
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <div class="alert-icon">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <div class="alert-content">
                                <strong>Please fix the following errors:</strong>
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <button type="button" class="alert-close" data-bs-dismiss="alert">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success">
                            <div class="alert-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="alert-content">
                                {{ session('success') }}
                            </div>
                            <button type="button" class="alert-close" data-bs-dismiss="alert">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-error">
                            <div class="alert-icon">
                                <i class="fas fa-exclamation-circle"></i>
                            </div>
                            <div class="alert-content">
                                {{ session('error') }}
                            </div>
                            <button type="button" class="alert-close" data-bs-dismiss="alert">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endif
                    
                    <!-- Question Type -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-tag me-2"></i>Question Type <span class="required">*</span>
                        </label>
                        <div class="select-wrapper">
                            <select name="question_type" id="questionType" required>
                                <option value="multiple_choice" {{ old('question_type') == 'multiple_choice' ? 'selected' : '' }}>Multiple Choice (Select all that apply)</option>
                                <option value="single_choice" {{ old('question_type') == 'single_choice' ? 'selected' : '' }}>Single Choice (Select one)</option>
                                <option value="true_false" {{ old('question_type') == 'true_false' ? 'selected' : '' }}>True/False</option>
                                <option value="fill_blank" {{ old('question_type') == 'fill_blank' ? 'selected' : '' }}>Fill in the Blank</option>
                                <option value="matching" {{ old('question_type') == 'matching' ? 'selected' : '' }}>Matching</option>
                                <option value="image_selection" {{ old('question_type') == 'image_selection' ? 'selected' : '' }}>Image Selection</option>
                            </select>
                            <i class="fas fa-chevron-down select-arrow"></i>
                        </div>
                    </div>

                    <!-- Question Text -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-paragraph me-2"></i>Question Text <span class="required">*</span>
                        </label>
                        <textarea name="question_text" id="questionText" rows="3" placeholder="Enter your question here..." required>{{ old('question_text') }}</textarea>
                        <div class="char-counter">
                            <span id="questionCounter">{{ strlen(old('question_text') ?? '') }}</span>/500 characters
                        </div>
                    </div>

                    <!-- Explanation -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-info-circle me-2"></i>Explanation (Optional)
                        </label>
                        <textarea name="explanation" id="explanation" rows="2" placeholder="Explain why the answer is correct...">{{ old('explanation') }}</textarea>
                    </div>

                    <!-- Points & Image Row -->
                    <div class="form-row">
                        <div class="form-group half">
                            <label class="form-label">
                                <i class="fas fa-coins me-2"></i>Points
                            </label>
                            <div class="input-wrapper">
                                <i class="fas fa-star input-icon"></i>
                                <input type="number" name="points" id="points" value="{{ old('points', 1) }}" min="1">
                            </div>
                        </div>
                        
                        <div class="form-group half">
                            <label class="form-label">
                                <i class="fas fa-image me-2"></i>Question Image
                            </label>
                            <div class="file-upload">
                                <input type="file" name="image" id="image" accept="image/*">
                                <div class="file-preview" id="imagePreview">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span>Click to upload image</span>
                                    <small>PNG, JPG, GIF up to 2MB</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Options Section (for Multiple Choice, Single Choice, True/False) -->
                    <div id="optionsSection" class="options-section">
                        <div class="section-header">
                            <div class="section-title">
                                <i class="fas fa-list-ul"></i>
                                <h4>Answer Options</h4>
                            </div>
                            <span class="options-badge" id="optionsCount">2 options</span>
                        </div>
                        
                        <div id="optionsContainer" class="options-container">
                            @php
                                $oldOptions = old('options', [
                                    ['text' => '', 'is_correct' => false],
                                    ['text' => '', 'is_correct' => false]
                                ]);
                            @endphp
                            
                            @foreach($oldOptions as $index => $option)
                            <div class="option-item" data-index="{{ $index }}">
                                <div class="option-drag">
                                    <i class="fas fa-grip-vertical"></i>
                                </div>
                                <div class="option-input-group">
                                    <div class="option-field">
                                        <input type="text" 
                                               name="options[{{ $index }}][text]" 
                                               class="option-text" 
                                               placeholder="Enter option {{ $index + 1 }}"
                                               value="{{ $option['text'] ?? '' }}">
                                    </div>
                                    <div class="option-check">
                                        <label class="checkbox-label">
                                            <input type="checkbox" 
                                                   name="options[{{ $index }}][is_correct]" 
                                                   value="1"
                                                   class="correct-checkbox"
                                                   data-option-index="{{ $index }}"
                                                   {{ isset($option['is_correct']) && $option['is_correct'] ? 'checked' : '' }}>
                                            <span class="checkbox-custom"></span>
                                            <span class="checkbox-text">Correct</span>
                                        </label>
                                    </div>
                                    <button type="button" class="option-remove" onclick="removeOption(this)">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        <button type="button" class="btn-add" onclick="addOption()">
                            <i class="fas fa-plus"></i>
                            Add Option
                        </button>
                    </div>

                    <!-- Image Selection Section -->
                    <div id="imageSelectionSection" class="image-selection-section" style="display: none;">
                        <div class="section-header">
                            <div class="section-title">
                                <i class="fas fa-images"></i>
                                <h4>Image Options</h4>
                            </div>
                            <span class="options-badge" id="imageOptionsCount">2 images</span>
                        </div>
                        
                        <div id="imageOptionsContainer" class="image-options-container">
                            @php
                                $oldImageOptions = old('options', [
                                    ['text' => '', 'is_correct' => false],
                                    ['text' => '', 'is_correct' => false]
                                ]);
                            @endphp
                            
                            @foreach($oldImageOptions as $index => $option)
                            <div class="image-option-item" data-index="{{ $index }}">
                                <div class="option-drag">
                                    <i class="fas fa-grip-vertical"></i>
                                </div>
                                <div class="image-option-content">
                                    <div class="image-upload-box">
                                        <input type="file" 
                                               name="options[{{ $index }}][image]" 
                                               class="image-option-input" 
                                               accept="image/*"
                                               onchange="previewImageOption(this, {{ $index }})">
                                        <div class="image-preview-box" id="imagePreview{{ $index }}">
                                            <i class="fas fa-cloud-upload-alt"></i>
                                            <span>Upload Image</span>
                                        </div>
                                    </div>
                                    <div class="image-option-details">
                                        <input type="text" 
                                               name="options[{{ $index }}][text]" 
                                               class="image-option-text" 
                                               placeholder="Alt text / Label"
                                               value="{{ $option['text'] ?? '' }}">
                                        <div class="image-option-check">
                                            <label class="checkbox-label">
                                                <input type="checkbox" 
                                                       name="options[{{ $index }}][is_correct]" 
                                                       value="1"
                                                       class="correct-checkbox"
                                                       data-option-index="{{ $index }}"
                                                       {{ isset($option['is_correct']) && $option['is_correct'] ? 'checked' : '' }}>
                                                <span class="checkbox-custom"></span>
                                                <span class="checkbox-text">Correct</span>
                                            </label>
                                        </div>
                                    </div>
                                    <button type="button" class="option-remove" onclick="removeImageOption(this)">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        <button type="button" class="btn-add" onclick="addImageOption()">
                            <i class="fas fa-plus"></i>
                            Add Image Option
                        </button>
                    </div>

                    <!-- Fill in the Blanks Section -->
                    <div id="fillBlanksSection" class="blanks-section" style="display: none;">
                        <div class="section-header">
                            <div class="section-title">
                                <i class="fas fa-pencil-alt"></i>
                                <h4>Correct Answers</h4>
                            </div>
                            <span class="options-badge" id="blanksCount">1 answer</span>
                        </div>
                        
                        <div id="fillBlanksContainer" class="blanks-container">
                            @php
                                $oldFillBlanks = old('fill_blanks', [
                                    ['answer' => '', 'case_sensitive' => false]
                                ]);
                            @endphp
                            
                            @foreach($oldFillBlanks as $index => $blank)
                            <div class="blank-item" data-index="{{ $index }}">
                                <div class="blank-drag">
                                    <i class="fas fa-grip-vertical"></i>
                                </div>
                                <div class="blank-input-group">
                                    <div class="blank-field">
                                        <input type="text" 
                                               name="fill_blanks[{{ $index }}][answer]" 
                                               class="blank-text" 
                                               placeholder="Enter correct answer"
                                               value="{{ $blank['answer'] ?? '' }}">
                                    </div>
                                    <div class="blank-case">
                                        <label class="checkbox-label">
                                            <input type="checkbox" 
                                                   name="fill_blanks[{{ $index }}][case_sensitive]" 
                                                   value="1"
                                                   {{ isset($blank['case_sensitive']) && $blank['case_sensitive'] ? 'checked' : '' }}>
                                            <span class="checkbox-custom"></span>
                                            <span class="checkbox-text">Case Sensitive</span>
                                        </label>
                                    </div>
                                    <button type="button" class="blank-remove" onclick="removeBlank(this)">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        <button type="button" class="btn-add" onclick="addFillBlank()">
                            <i class="fas fa-plus"></i>
                            Add Answer
                        </button>
                    </div>

                    <!-- Matching Section -->
                    <div id="matchingSection" class="matching-section" style="display: none;">
                        <div class="section-header">
                            <div class="section-title">
                                <i class="fas fa-link"></i>
                                <h4>Matching Pairs</h4>
                            </div>
                            <span class="options-badge" id="matchingCount">2 pairs</span>
                        </div>
                        
                        <div class="info-message">
                            <i class="fas fa-info-circle"></i>
                            <span>Define the matching pairs below. Each pair consists of a left item and its corresponding right item. All pairs are considered correct matches.</span>
                        </div>
                        
                        <div id="matchingPairsContainer" class="matching-container">
                            @php
                                $oldMatchingPairs = old('matching_pairs', [
                                    ['left' => '', 'right' => ''],
                                    ['left' => '', 'right' => '']
                                ]);
                            @endphp
                            
                            @foreach($oldMatchingPairs as $index => $pair)
                            <div class="matching-item" data-index="{{ $index }}">
                                <div class="matching-drag">
                                    <i class="fas fa-grip-vertical"></i>
                                </div>
                                <div class="matching-input-group">
                                    <div class="matching-left">
                                        <input type="text" 
                                               name="matching_pairs[{{ $index }}][left]" 
                                               class="matching-left-input" 
                                               placeholder="Left item (e.g., Country)"
                                               value="{{ $pair['left'] ?? '' }}">
                                    </div>
                                    <div class="matching-arrow">
                                        <i class="fas fa-long-arrow-alt-right"></i>
                                    </div>
                                    <div class="matching-right">
                                        <input type="text" 
                                               name="matching_pairs[{{ $index }}][right]" 
                                               class="matching-right-input" 
                                               placeholder="Right item (e.g., Capital)"
                                               value="{{ $pair['right'] ?? '' }}">
                                    </div>
                                    <div class="matching-badge correct">
                                        <i class="fas fa-check-circle"></i>
                                        <span>Correct Pair</span>
                                    </div>
                                    <button type="button" class="matching-remove" onclick="removeMatchingPair(this)">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        <button type="button" class="btn-add" onclick="addMatchingPair()">
                            <i class="fas fa-plus"></i>
                            Add Matching Pair
                        </button>
                        
                        <div class="matching-note">
                            <i class="fas fa-lightbulb"></i>
                            <span>Note: For matching questions, all defined pairs are considered correct. Students will need to match each left item with its correct right item.</span>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-actions">
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-plus-circle"></i>
                            Add Question
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Questions List Column -->
    <div class="list-column">
        <div class="list-container">
            <div class="list-header">
                <div class="list-header-left">
                    <i class="fas fa-list"></i>
                    <div>
                        <h3>Questions List</h3>
                        <p>{{ $quiz->questions->count() }} total questions</p>
                    </div>
                </div>
                <div class="list-stats">
                    <div class="stat-item">
                        <span class="stat-label">Total Points</span>
                        <span class="stat-value">{{ $quiz->questions->sum('points') }}</span>
                    </div>
                </div>
            </div>

            <div class="questions-list" id="questionsList">
                @forelse($quiz->questions as $question)
                <div class="question-card" id="question-{{ $question->id }}" data-id="{{ $question->id }}" data-order="{{ $question->sort_order }}">
                    <div class="question-card-drag">
                        <i class="fas fa-grip-vertical"></i>
                    </div>
                    
                    <div class="question-card-content">
                        <div class="question-card-header">
                            <div class="question-badges">
                                <span class="badge-number">Q{{ $loop->iteration }}</span>
                                <span class="badge-type type-{{ $question->question_type }}">
                                    {{ str_replace('_', ' ', ucfirst($question->question_type)) }}
                                </span>
                                <span class="badge-points">{{ $question->points }} pts</span>
                            </div>
                            
                            <div class="question-card-actions">
                                <button class="action-btn edit" onclick="editQuestion({{ $question->id }})" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="action-btn delete" onclick="deleteQuestion({{ $question->id }})" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="question-card-text">
                            {{ $question->question_text }}
                        </div>
                        
                        @if($question->explanation)
                        <div class="question-explanation">
                            <i class="fas fa-info-circle"></i> {{ $question->explanation }}
                        </div>
                        @endif
                        
                        @if($question->image)
                        <div class="question-card-image">
                            <img src="{{ Storage::url($question->image) }}" alt="Question image">
                        </div>
                        @endif
                        
                        <div class="question-card-answers">
                            @if(in_array($question->question_type, ['multiple_choice', 'single_choice', 'true_false']))
                                @foreach($question->options as $option)
                                <div class="answer-row {{ $option->is_correct ? 'correct' : '' }}">
                                    <span class="answer-letter">{{ chr(65 + $loop->index) }}</span>
                                    <span class="answer-text">{{ $option->option_text }}</span>
                                    @if($option->is_correct)
                                        <i class="fas fa-check-circle correct-icon"></i>
                                    @endif
                                </div>
                                @endforeach
                            
                            @elseif($question->question_type == 'image_selection')
                                <div class="image-options-grid">
                                    @foreach($question->options as $option)
                                    <div class="image-option-preview {{ $option->is_correct ? 'correct' : '' }}">
                                        @if($option->image)
                                            <img src="{{ Storage::url($option->image) }}" alt="{{ $option->option_text }}">
                                        @else
                                            <div class="no-image">{{ $option->option_text }}</div>
                                        @endif
                                        @if($option->is_correct)
                                            <div class="correct-badge"><i class="fas fa-check-circle"></i></div>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                            
                            @elseif($question->question_type == 'fill_blank')
                                @foreach($question->fillBlanks as $blank)
                                <div class="answer-row correct">
                                    <i class="fas fa-pencil-alt answer-icon"></i>
                                    <span class="answer-text">"{{ $blank->correct_answer }}"</span>
                                    @if($blank->case_sensitive)
                                        <span class="case-badge">Case Sensitive</span>
                                    @endif
                                </div>
                                @endforeach
                            
                            @elseif($question->question_type == 'matching')
                                <div class="matching-pairs-preview">
                                    <table class="matching-table">
                                        @foreach($question->matchingPairs as $pair)
                                        <tr>
                                            <td class="left-item">{{ $pair->left_item }}</td>
                                            <td class="arrow"><i class="fas fa-arrow-right"></i></td>
                                            <td class="right-item">{{ $pair->right_item }}</td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-question-circle"></i>
                    </div>
                    <h4>No Questions Yet</h4>
                    <p>Start by adding your first question using the form</p>
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
                <h5 class="modal-title">
                    <i class="fas fa-edit me-2"></i>
                    Edit Question
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body" id="editQuestionContent">
                <div class="loading-spinner">
                    <div class="spinner"></div>
                    <p>Loading question...</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Matching Section Enhancements */
.info-message {
    background: var(--info-light);
    border-left: 4px solid var(--info);
    padding: 12px 16px;
    border-radius: var(--radius-md);
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 12px;
    color: var(--info);
    font-size: 0.9rem;
}

.info-message i {
    font-size: 1.2rem;
}

.matching-badge {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    background: var(--success-light);
    color: var(--success);
    border: 1px solid var(--success);
    white-space: nowrap;
}

.matching-badge i {
    font-size: 0.9rem;
}

.matching-badge.correct {
    background: var(--success-light);
    color: var(--success);
    border-color: var(--success);
}

.matching-arrow i {
    color: var(--primary);
    font-size: 1.4rem;
}

.matching-note {
    margin-top: 16px;
    padding: 12px 16px;
    background: var(--light);
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    gap: 12px;
    color: var(--gray);
    font-size: 0.85rem;
    border: 1px dashed var(--border);
}

.matching-note i {
    color: var(--warning);
    font-size: 1rem;
}

.matching-input-group {
    flex: 1;
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}

.matching-left, .matching-right {
    flex: 2;
    min-width: 200px;
}

@media (max-width: 768px) {
    .matching-input-group {
        flex-direction: column;
        align-items: stretch;
    }
    
    .matching-arrow {
        transform: rotate(90deg);
        align-self: center;
    }
    
    .matching-badge {
        align-self: flex-start;
    }
}

/* Modern CSS Reset and Variables */
:root {
    --primary: #4361ee;
    --primary-dark: #3a56d4;
    --primary-light: #eef2ff;
    --secondary: #3f37c9;
    --success: #06d6a0;
    --success-light: #e3fcf5;
    --danger: #ef476f;
    --danger-light: #fee9ef;
    --warning: #ffb703;
    --warning-light: #fff3d8;
    --info: #4cc9f0;
    --info-light: #e1f5fe;
    --dark: #1e293b;
    --gray: #64748b;
    --light: #f8fafc;
    --border: #e2e8f0;
    --white: #ffffff;
    
    --shadow-sm: 0 2px 4px rgba(0,0,0,0.02);
    --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
    --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05);
    --shadow-xl: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);
    
    --radius-sm: 6px;
    --radius-md: 10px;
    --radius-lg: 16px;
    --radius-xl: 24px;
}

/* Header Wrapper */
.header-wrapper {
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    border-radius: var(--radius-xl);
    margin-bottom: 24px;
    padding: 2px;
}

.header-section {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: var(--radius-xl);
    padding: 24px 32px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
}

.header-content {
    display: flex;
    align-items: center;
    gap: 20px;
}

.header-icon {
    width: 56px;
    height: 56px;
    background: linear-gradient(135deg, var(--primary-light), var(--white));
    border-radius: var(--radius-lg);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    color: var(--primary);
    box-shadow: var(--shadow-md);
}

.header-content h2 {
    font-size: 1.8rem;
    font-weight: 700;
    margin: 0 0 4px;
    color: var(--dark);
}

.header-content p {
    margin: 0;
    color: var(--gray);
    font-size: 0.95rem;
    display: flex;
    align-items: center;
}

.header-actions {
    display: flex;
    gap: 12px;
}

.header-actions .btn {
    padding: 12px 24px;
    border-radius: var(--radius-md);
    font-weight: 500;
    transition: all 0.3s;
    border: none;
    cursor: pointer;
}

.btn-outline-light {
    background: transparent;
    border: 2px solid var(--primary);
    color: var(--primary);
}

.btn-outline-light:hover {
    background: var(--primary);
    color: white;
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.btn-light {
    background: white;
    border: 2px solid var(--primary);
    color: var(--primary);
}

.btn-light:hover {
    background: var(--primary);
    color: white;
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

/* Info Cards */
.info-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.info-card {
    background: var(--white);
    border-radius: var(--radius-lg);
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 16px;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border);
    transition: all 0.3s;
}

.info-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.info-card-icon {
    width: 48px;
    height: 48px;
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}

.info-card-primary .info-card-icon {
    background: var(--primary-light);
    color: var(--primary);
}

.info-card-success .info-card-icon {
    background: var(--success-light);
    color: var(--success);
}

.info-card-warning .info-card-icon {
    background: var(--warning-light);
    color: var(--warning);
}

.info-card-info .info-card-icon {
    background: var(--info-light);
    color: var(--info);
}

.info-card-content {
    display: flex;
    flex-direction: column;
}

.info-card-label {
    font-size: 0.8rem;
    color: var(--gray);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 4px;
}

.info-card-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--dark);
    line-height: 1.2;
}

/* Content Grid */
.content-grid {
    display: grid;
    grid-template-columns: 1.2fr 1.8fr;
    gap: 30px;
}

/* Form Column */
.form-column {
    position: sticky;
    top: 20px;
    align-self: start;
}

.form-container {
    background: var(--white);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-lg);
    overflow: hidden;
    border: 1px solid var(--border);
}

.form-header {
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    padding: 20px 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: white;
}

.form-header-title {
    display: flex;
    align-items: center;
    gap: 12px;
}

.form-header-title i {
    font-size: 24px;
}

.form-header-title h3 {
    margin: 0;
    font-size: 1.2rem;
    font-weight: 600;
}

.question-number {
    background: rgba(255, 255, 255, 0.2);
    padding: 6px 14px;
    border-radius: 30px;
    font-size: 1rem;
    font-weight: 600;
    backdrop-filter: blur(5px);
}

.form-body {
    padding: 24px;
}

/* Form Elements */
.form-group {
    margin-bottom: 24px;
}

.form-label {
    display: flex;
    align-items: center;
    font-weight: 600;
    font-size: 0.9rem;
    color: var(--dark);
    margin-bottom: 8px;
}

.form-label i {
    color: var(--primary);
}

.required {
    color: var(--danger);
    margin-left: 4px;
}

.select-wrapper {
    position: relative;
}

select, textarea, input[type="text"], input[type="number"] {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid var(--border);
    border-radius: var(--radius-md);
    font-size: 0.95rem;
    transition: all 0.3s;
    background: var(--white);
}

select {
    appearance: none;
    padding-right: 40px;
    cursor: pointer;
}

.select-arrow {
    position: absolute;
    right: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gray);
    pointer-events: none;
}

textarea {
    resize: vertical;
    min-height: 60px;
}

textarea#questionText {
    min-height: 100px;
}

select:focus, textarea:focus, input:focus {
    border-color: var(--primary);
    outline: none;
    box-shadow: 0 0 0 4px var(--primary-light);
}

.char-counter {
    text-align: right;
    font-size: 0.8rem;
    color: var(--gray);
    margin-top: 6px;
}

/* Form Row */
.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

.input-wrapper {
    position: relative;
}

.input-icon {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gray);
    pointer-events: none;
}

.input-wrapper input {
    padding-left: 40px;
}

/* File Upload */
.file-upload {
    position: relative;
    cursor: pointer;
}

.file-upload input {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
    z-index: 2;
}

.file-preview {
    border: 2px dashed var(--border);
    border-radius: var(--radius-md);
    padding: 20px;
    text-align: center;
    background: var(--light);
    transition: all 0.3s;
}

.file-preview:hover {
    border-color: var(--primary);
    background: var(--primary-light);
}

.file-preview i {
    font-size: 32px;
    color: var(--primary);
    margin-bottom: 8px;
    display: block;
}

.file-preview span {
    display: block;
    color: var(--dark);
    font-weight: 500;
    margin-bottom: 4px;
}

.file-preview small {
    color: var(--gray);
    font-size: 0.75rem;
}

.file-preview img {
    max-width: 100%;
    max-height: 80px;
    border-radius: var(--radius-sm);
}

/* Options Section */
.options-section, .blanks-section, .image-selection-section, .matching-section {
    background: var(--light);
    border-radius: var(--radius-lg);
    padding: 24px;
    margin-bottom: 20px;
    border: 1px solid var(--border);
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.section-title {
    display: flex;
    align-items: center;
    gap: 10px;
}

.section-title i {
    color: var(--primary);
    font-size: 20px;
}

.section-title h4 {
    margin: 0;
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--dark);
}

.options-badge {
    background: var(--white);
    padding: 6px 14px;
    border-radius: 30px;
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--primary);
    border: 1px solid var(--border);
}

.options-container, .blanks-container, .image-options-container, .matching-container {
    display: flex;
    flex-direction: column;
    gap: 16px;
    margin-bottom: 20px;
    max-height: 400px;
    overflow-y: auto;
    padding: 8px;
}

/* Option Items */
.option-item, .blank-item {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    background: var(--white);
    padding: 20px;
    border-radius: var(--radius-lg);
    border: 2px solid var(--border);
    transition: all 0.3s;
    box-shadow: var(--shadow-sm);
}

.option-item:hover, .blank-item:hover {
    border-color: var(--primary);
    box-shadow: var(--shadow-md);
    transform: translateY(-2px);
}

.option-drag, .blank-drag, .matching-drag {
    cursor: move;
    color: var(--gray);
    padding: 10px 4px;
    font-size: 20px;
}

.option-input-group, .blank-input-group {
    flex: 1;
    display: flex;
    align-items: center;
    gap: 20px;
    flex-wrap: wrap;
}

.option-field, .blank-field {
    flex: 3;
    min-width: 350px;
}

.option-text, .blank-text {
    width: 100%;
    padding: 14px 18px;
    border: 2px solid var(--border);
    border-radius: var(--radius-md);
    font-size: 1rem;
    transition: all 0.3s;
    background: var(--white);
}

.option-text:focus, .blank-text:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 4px var(--primary-light);
    outline: none;
}

.option-check, .blank-case {
    min-width: 120px;
    padding: 8px 0;
}

/* Checkbox */
.checkbox-label {
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    user-select: none;
    padding: 6px 0;
}

.checkbox-label input {
    display: none;
}

.checkbox-custom {
    width: 22px;
    height: 22px;
    border: 2px solid var(--border);
    border-radius: 6px;
    background: var(--white);
    transition: all 0.2s;
    position: relative;
    flex-shrink: 0;
}

.checkbox-label input:checked + .checkbox-custom {
    background: var(--primary);
    border-color: var(--primary);
}

.checkbox-label input:checked + .checkbox-custom::after {
    content: '\f00c';
    font-family: 'Font Awesome 5 Free';
    font-weight: 900;
    color: white;
    font-size: 14px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.checkbox-text {
    font-size: 1rem;
    color: var(--dark);
    font-weight: 500;
}

/* Remove Buttons */
.option-remove, .blank-remove, .matching-remove {
    width: 40px;
    height: 40px;
    border-radius: var(--radius-md);
    border: none;
    background: var(--danger-light);
    color: var(--danger);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s;
    font-size: 1.1rem;
    flex-shrink: 0;
}

.option-remove:hover, .blank-remove:hover, .matching-remove:hover {
    background: var(--danger);
    color: white;
    transform: rotate(90deg);
}

/* Add Button */
.btn-add {
    width: 100%;
    padding: 16px;
    background: var(--white);
    border: 2px dashed var(--primary);
    border-radius: var(--radius-md);
    color: var(--primary);
    font-weight: 600;
    font-size: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    cursor: pointer;
    transition: all 0.3s;
}

.btn-add:hover {
    background: var(--primary-light);
    border-style: solid;
    transform: translateY(-2px);
}

.btn-add i {
    font-size: 1.2rem;
}

/* Submit Button */
.btn-submit {
    width: 100%;
    padding: 18px;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    border: none;
    border-radius: var(--radius-md);
    color: white;
    font-weight: 600;
    font-size: 1.1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    cursor: pointer;
    transition: all 0.3s;
    box-shadow: var(--shadow-md);
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.btn-submit i {
    font-size: 1.2rem;
}

/* List Column */
.list-column {
    position: relative;
}

.list-container {
    background: var(--white);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-lg);
    overflow: hidden;
    border: 1px solid var(--border);
}

.list-header {
    background: linear-gradient(135deg, var(--light), var(--white));
    padding: 20px 24px;
    border-bottom: 1px solid var(--border);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.list-header-left {
    display: flex;
    align-items: center;
    gap: 15px;
}

.list-header-left i {
    font-size: 24px;
    color: var(--primary);
    background: var(--primary-light);
    width: 48px;
    height: 48px;
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
}

.list-header-left h3 {
    margin: 0 0 4px;
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--dark);
}

.list-header-left p {
    margin: 0;
    color: var(--gray);
    font-size: 0.9rem;
}

.list-stats {
    background: var(--white);
    padding: 8px 16px;
    border-radius: var(--radius-md);
    box-shadow: var(--shadow-sm);
}

.stat-item {
    text-align: center;
}

.stat-label {
    display: block;
    font-size: 0.7rem;
    color: var(--gray);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.stat-value {
    font-size: 1.3rem;
    font-weight: 800;
    color: var(--primary);
    line-height: 1.2;
}

/* Questions List */
.questions-list {
    padding: 24px;
    max-height: 700px;
    overflow-y: auto;
}

.question-card {
    display: flex;
    gap: 16px;
    background: var(--light);
    border-radius: var(--radius-lg);
    padding: 20px;
    margin-bottom: 16px;
    border: 1px solid var(--border);
    transition: all 0.3s;
}

.question-card:hover {
    transform: translateX(4px);
    box-shadow: var(--shadow-md);
    border-color: var(--primary);
}

.question-card-drag {
    color: var(--gray);
    padding-top: 4px;
    cursor: move;
    font-size: 18px;
}

.question-card-content {
    flex: 1;
}

.question-card-header {
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

.badge-number {
    background: var(--primary);
    color: white;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
}

.badge-type {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
}

.type-multiple_choice {
    background: var(--primary-light);
    color: var(--primary);
}

.type-single_choice {
    background: var(--success-light);
    color: var(--success);
}

.type-true_false {
    background: var(--warning-light);
    color: var(--warning);
}

.type-fill_blank {
    background: var(--info-light);
    color: var(--info);
}

.type-matching {
    background: var(--secondary);
    color: white;
}

.type-image_selection {
    background: var(--info);
    color: white;
}

.badge-points {
    background: var(--dark);
    color: white;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
}

.question-card-actions {
    display: flex;
    gap: 8px;
}

.action-btn {
    width: 40px;
    height: 40px;
    border-radius: var(--radius-md);
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s;
    font-size: 1.1rem;
}

.action-btn.edit {
    background: var(--primary-light);
    color: var(--primary);
}

.action-btn.edit:hover {
    background: var(--primary);
    color: white;
    transform: translateY(-2px);
}

.action-btn.delete {
    background: var(--danger-light);
    color: var(--danger);
}

.action-btn.delete:hover {
    background: var(--danger);
    color: white;
    transform: translateY(-2px);
}

.question-card-text {
    font-size: 1.1rem;
    color: var(--dark);
    margin-bottom: 15px;
    line-height: 1.6;
    font-weight: 500;
}

.question-explanation {
    background: var(--info-light);
    color: var(--info);
    padding: 10px 16px;
    border-radius: var(--radius-md);
    margin-bottom: 15px;
    font-size: 0.9rem;
    border-left: 4px solid var(--info);
}

.question-card-image {
    margin-bottom: 15px;
}

.question-card-image img {
    max-width: 200px;
    max-height: 150px;
    border-radius: var(--radius-md);
    border: 2px solid var(--border);
}

.question-card-answers {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.answer-row {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    background: var(--white);
    border-radius: var(--radius-md);
    border-left: 4px solid transparent;
    font-size: 0.95rem;
}

.answer-row.correct {
    border-left-color: var(--success);
    background: var(--success-light);
}

.answer-letter {
    width: 28px;
    height: 28px;
    border-radius: 8px;
    background: var(--border);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.9rem;
    font-weight: 700;
    color: var(--dark);
    flex-shrink: 0;
}

.answer-text {
    flex: 1;
    font-size: 1rem;
    color: var(--dark);
    word-break: break-word;
}

.correct-icon {
    color: var(--success);
    font-size: 1.2rem;
    flex-shrink: 0;
}

.answer-icon {
    color: var(--info);
    font-size: 1.1rem;
    width: 28px;
    text-align: center;
    flex-shrink: 0;
}

.case-badge {
    background: var(--warning);
    color: white;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    flex-shrink: 0;
}

/* Image Selection Grid */
.image-options-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
    gap: 12px;
    margin-top: 10px;
}

.image-option-preview {
    position: relative;
    border-radius: var(--radius-md);
    overflow: hidden;
    border: 2px solid var(--border);
    aspect-ratio: 1;
}

.image-option-preview.correct {
    border-color: var(--success);
}

.image-option-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.image-option-preview .no-image {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--light);
    color: var(--gray);
    font-size: 0.8rem;
    text-align: center;
    padding: 8px;
}

.image-option-preview .correct-badge {
    position: absolute;
    top: 4px;
    right: 4px;
    background: var(--success);
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
}

/* Matching Preview */
.matching-pairs-preview {
    background: var(--white);
    border-radius: var(--radius-md);
    overflow: hidden;
}

.matching-table {
    width: 100%;
    border-collapse: collapse;
}

.matching-table tr {
    border-bottom: 1px solid var(--border);
}

.matching-table tr:last-child {
    border-bottom: none;
}

.matching-table td {
    padding: 12px;
}

.matching-table .left-item {
    font-weight: 600;
    color: var(--primary);
    width: 40%;
}

.matching-table .arrow {
    text-align: center;
    color: var(--gray);
    width: 10%;
}

.matching-table .right-item {
    color: var(--dark);
    width: 50%;
}

/* Image Selection Form */
.image-selection-section {
    background: var(--light);
    border-radius: var(--radius-lg);
    padding: 24px;
    margin-bottom: 20px;
    border: 1px solid var(--border);
}

.image-options-container {
    display: flex;
    flex-direction: column;
    gap: 20px;
    margin-bottom: 20px;
    max-height: 500px;
    overflow-y: auto;
    padding: 8px;
}

.image-option-item {
    display: flex;
    gap: 16px;
    background: var(--white);
    padding: 20px;
    border-radius: var(--radius-lg);
    border: 2px solid var(--border);
    transition: all 0.3s;
}

.image-option-item:hover {
    border-color: var(--primary);
    box-shadow: var(--shadow-md);
}

.image-option-content {
    flex: 1;
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}

.image-upload-box {
    width: 120px;
    height: 120px;
    position: relative;
    cursor: pointer;
}

.image-upload-box input {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
    z-index: 2;
}

.image-preview-box {
    width: 100%;
    height: 100%;
    border: 2px dashed var(--border);
    border-radius: var(--radius-md);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: var(--light);
    transition: all 0.3s;
    overflow: hidden;
}

.image-preview-box:hover {
    border-color: var(--primary);
    background: var(--primary-light);
}

.image-preview-box i {
    font-size: 32px;
    color: var(--primary);
    margin-bottom: 8px;
}

.image-preview-box span {
    font-size: 0.8rem;
    color: var(--gray);
    text-align: center;
    padding: 0 8px;
}

.image-preview-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.image-option-details {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 12px;
    min-width: 200px;
}

.image-option-text {
    width: 100%;
    padding: 12px;
    border: 2px solid var(--border);
    border-radius: var(--radius-md);
    font-size: 0.95rem;
}

.image-option-check {
    display: flex;
    align-items: center;
}

/* Matching Form */
.matching-section {
    background: var(--light);
    border-radius: var(--radius-lg);
    padding: 24px;
    margin-bottom: 20px;
    border: 1px solid var(--border);
}

.matching-container {
    display: flex;
    flex-direction: column;
    gap: 16px;
    margin-bottom: 20px;
    max-height: 500px;
    overflow-y: auto;
    padding: 8px;
}

.matching-item {
    display: flex;
    align-items: center;
    gap: 16px;
    background: var(--white);
    padding: 16px;
    border-radius: var(--radius-lg);
    border: 2px solid var(--border);
    transition: all 0.3s;
}

.matching-item:hover {
    border-color: var(--primary);
    box-shadow: var(--shadow-md);
}

.matching-input-group {
    flex: 1;
    display: flex;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
}

.matching-left, .matching-right {
    flex: 1;
    min-width: 200px;
}

.matching-left-input, .matching-right-input {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid var(--border);
    border-radius: var(--radius-md);
    font-size: 0.95rem;
}

.matching-left-input:focus, .matching-right-input:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 4px var(--primary-light);
    outline: none;
}

.matching-arrow {
    color: var(--primary);
    font-size: 20px;
    flex-shrink: 0;
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
    background: var(--light);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
}

.empty-state-icon i {
    font-size: 3rem;
    color: var(--gray);
}

.empty-state h4 {
    color: var(--dark);
    margin-bottom: 8px;
    font-weight: 700;
    font-size: 1.2rem;
}

.empty-state p {
    color: var(--gray);
    margin: 0;
    font-size: 0.95rem;
}

/* Alerts */
.alert {
    display: flex;
    align-items: flex-start;
    gap: 15px;
    padding: 16px 20px;
    border-radius: var(--radius-md);
    margin-bottom: 20px;
    position: relative;
}

.alert-success {
    background: var(--success-light);
    border-left: 4px solid var(--success);
    color: var(--success);
}

.alert-danger {
    background: var(--danger-light);
    border-left: 4px solid var(--danger);
    color: var(--danger);
}

.alert-error {
    background: var(--danger-light);
    border-left: 4px solid var(--danger);
    color: var(--danger);
}

.alert-icon {
    font-size: 1.5rem;
    flex-shrink: 0;
}

.alert-content {
    flex: 1;
}

.alert-content ul {
    margin: 8px 0 0;
    padding-left: 20px;
}

.alert-close {
    background: none;
    border: none;
    color: inherit;
    cursor: pointer;
    opacity: 0.7;
    padding: 4px;
    font-size: 1.1rem;
}

.alert-close:hover {
    opacity: 1;
}

/* Modal */
.modal-content {
    border: none;
    border-radius: var(--radius-xl);
    overflow: hidden;
}

.modal-header {
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    color: white;
    border: none;
    padding: 20px 24px;
}

.modal-header .btn-close {
    background: rgba(255, 255, 255, 0.2);
    border: none;
    width: 40px;
    height: 40px;
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
    cursor: pointer;
    transition: all 0.3s;
}

.modal-header .btn-close:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: rotate(90deg);
}

.modal-title {
    display: flex;
    align-items: center;
    font-weight: 600;
    font-size: 1.2rem;
}

.modal-body {
    padding: 24px;
    max-height: 70vh;
    overflow-y: auto;
}

/* Loading Spinner */
.loading-spinner {
    text-align: center;
    padding: 40px;
}

.spinner {
    width: 50px;
    height: 50px;
    border: 4px solid var(--border);
    border-top-color: var(--primary);
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 0 auto 20px;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* Current Image in Edit Modal */
.current-image {
    margin-bottom: 15px;
}

.current-image img {
    max-width: 200px;
    max-height: 150px;
    border-radius: var(--radius-md);
    border: 2px solid var(--border);
}

/* Scrollbar */
::-webkit-scrollbar {
    width: 10px;
    height: 10px;
}

::-webkit-scrollbar-track {
    background: var(--light);
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
@media (max-width: 1400px) {
    .option-field, .blank-field {
        min-width: 280px;
    }
}

@media (max-width: 1200px) {
    .content-grid {
        grid-template-columns: 1fr;
    }
    
    .form-column {
        position: static;
    }
    
    .option-field, .blank-field {
        min-width: 250px;
    }
}

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
    
    .info-cards {
        grid-template-columns: 1fr;
    }
    
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .option-input-group, .blank-input-group {
        flex-direction: column;
        align-items: stretch;
    }
    
    .option-field, .blank-field {
        min-width: 100%;
    }
    
    .option-check, .blank-case {
        min-width: auto;
    }
    
    .question-card-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .question-card-actions {
        width: 100%;
        justify-content: flex-end;
    }
    
    .image-option-content {
        flex-direction: column;
        align-items: center;
    }
    
    .image-upload-box {
        width: 100%;
        height: 150px;
    }
    
    .matching-input-group {
        flex-direction: column;
        align-items: stretch;
    }
    
    .matching-arrow {
        transform: rotate(90deg);
        align-self: center;
    }
    
    .matching-left, .matching-right {
        min-width: 100%;
    }
}

@media (max-width: 576px) {
    .question-card {
        flex-direction: column;
    }
    
    .question-card-drag {
        align-self: flex-start;
    }
    
    .answer-row {
        flex-wrap: wrap;
    }
    
    .option-item, .blank-item, .image-option-item, .matching-item {
        padding: 16px;
    }
    
    .option-remove, .blank-remove, .matching-remove {
        width: 100%;
    }
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
// Global counters
let optionCount = {{ count(old('options', [['text' => ''], ['text' => '']])) }};
let imageOptionCount = {{ count(old('options', [['text' => ''], ['text' => '']])) }};
let fillBlankCount = {{ count(old('fill_blanks', [['answer' => '']])) }};
let matchingPairCount = {{ count(old('matching_pairs', [['left' => '', 'right' => ''], ['left' => '', 'right' => '']])) }};

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
    
    // Initialize Sortable for image options
    const imageOptionsContainer = document.getElementById('imageOptionsContainer');
    if (imageOptionsContainer) {
        new Sortable(imageOptionsContainer, {
            handle: '.option-drag',
            animation: 150,
            onEnd: updateImageOptionsIndices
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
    
    // Initialize Sortable for matching pairs
    const matchingContainer = document.getElementById('matchingPairsContainer');
    if (matchingContainer) {
        new Sortable(matchingContainer, {
            handle: '.matching-drag',
            animation: 150,
            onEnd: updateMatchingIndices
        });
    }
    
    // Initialize Sortable for questions list
    const questionsList = document.getElementById('questionsList');
    if (questionsList) {
        new Sortable(questionsList, {
            handle: '.question-card-drag',
            animation: 150,
            onEnd: function() {
                updateQuestionsOrder();
            }
        });
    }
    
    // Initialize question type
    const questionType = document.getElementById('questionType');
    if (questionType) {
        toggleSections(questionType.value);
        questionType.addEventListener('change', function() {
            toggleSections(this.value);
        });
    }

    // Initialize correct checkbox listeners for single choice
    initializeCorrectCheckboxListeners();

    // Question text counter
    const questionText = document.getElementById('questionText');
    if (questionText) {
        questionText.addEventListener('input', function() {
            document.getElementById('questionCounter').textContent = this.value.length;
        });
    }

    // Image preview
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');
    
    if (imageInput && imagePreview) {
        imageInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                }
                reader.readAsDataURL(this.files[0]);
            } else {
                imagePreview.innerHTML = `
                    <i class="fas fa-cloud-upload-alt"></i>
                    <span>Click to upload image</span>
                    <small>PNG, JPG, GIF up to 2MB</small>
                `;
            }
        });
    }

    // Form submission
    const form = document.getElementById('questionForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            enableCurrentSectionInputs();
        });
    }
});

// Smart checkbox handling for single choice
function initializeCorrectCheckboxListeners() {
    const questionType = document.getElementById('questionType');
    const optionsContainer = document.getElementById('optionsContainer');
    
    if (optionsContainer) {
        // Remove existing listeners and add new ones
        optionsContainer.querySelectorAll('.correct-checkbox').forEach(checkbox => {
            checkbox.removeEventListener('change', handleCorrectCheckboxChange);
            checkbox.addEventListener('change', handleCorrectCheckboxChange);
        });
    }
}

function handleCorrectCheckboxChange(e) {
    const questionType = document.getElementById('questionType').value;
    
    // Only apply single selection logic for single_choice and true_false
    if (questionType === 'single_choice' || questionType === 'true_false') {
        if (e.target.checked) {
            // Uncheck all other checkboxes
            const allCheckboxes = document.querySelectorAll('#optionsContainer .correct-checkbox');
            allCheckboxes.forEach(checkbox => {
                if (checkbox !== e.target) {
                    checkbox.checked = false;
                }
            });
        }
    }
}

function toggleSections(type) {
    const optionsSection = document.getElementById('optionsSection');
    const imageSelectionSection = document.getElementById('imageSelectionSection');
    const fillBlanksSection = document.getElementById('fillBlanksSection');
    const matchingSection = document.getElementById('matchingSection');
    
    if (!optionsSection || !fillBlanksSection || !matchingSection || !imageSelectionSection) return;
    
    // Hide all sections
    optionsSection.style.display = 'none';
    imageSelectionSection.style.display = 'none';
    fillBlanksSection.style.display = 'none';
    matchingSection.style.display = 'none';
    
    // Disable all inputs
    disableAllInputs();
    
    // Show and enable appropriate section
    switch(type) {
        case 'fill_blank':
            fillBlanksSection.style.display = 'block';
            enableFillBlanksInputs();
            break;
        case 'matching':
            matchingSection.style.display = 'block';
            enableMatchingInputs();
            break;
        case 'image_selection':
            imageSelectionSection.style.display = 'block';
            enableImageOptionsInputs();
            break;
        case 'true_false':
            optionsSection.style.display = 'block';
            enableOptionsInputs();
            // Set default True/False options
            setupTrueFalseOptions();
            break;
        default: // multiple_choice, single_choice
            optionsSection.style.display = 'block';
            enableOptionsInputs();
            break;
    }
    
    // Reinitialize checkbox listeners
    initializeCorrectCheckboxListeners();
}

function setupTrueFalseOptions() {
    const container = document.getElementById('optionsContainer');
    if (!container) return;
    
    // Clear existing options
    container.innerHTML = '';
    
    // Add True option
    addTrueFalseOption('True', 0);
    
    // Add False option
    addTrueFalseOption('False', 1);
    
    updateOptionsCount();
}

function addTrueFalseOption(text, index) {
    const container = document.getElementById('optionsContainer');
    
    const div = document.createElement('div');
    div.className = 'option-item';
    div.setAttribute('data-index', index);
    div.innerHTML = `
        <div class="option-drag">
            <i class="fas fa-grip-vertical"></i>
        </div>
        <div class="option-input-group">
            <div class="option-field">
                <input type="text" 
                       name="options[${index}][text]" 
                       class="option-text" 
                       placeholder="Enter option ${index + 1}"
                       value="${text}"
                       readonly>
            </div>
            <div class="option-check">
                <label class="checkbox-label">
                    <input type="checkbox" 
                           name="options[${index}][is_correct]" 
                           value="1"
                           class="correct-checkbox"
                           data-option-index="${index}">
                    <span class="checkbox-custom"></span>
                    <span class="checkbox-text">Correct</span>
                </label>
            </div>
            <button type="button" class="option-remove" onclick="removeOption(this)" style="opacity: 0.5; pointer-events: none;">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    container.appendChild(div);
}

function disableAllInputs() {
    document.querySelectorAll('.option-text, .option-item input[type="checkbox"], .blank-text, .blank-item input[type="checkbox"], .matching-left-input, .matching-right-input, .image-option-text, .image-option-input, .image-option-item input[type="checkbox"]').forEach(input => {
        input.disabled = true;
    });
}

function enableOptionsInputs() {
    document.querySelectorAll('.option-text, .option-item input[type="checkbox"]').forEach(input => {
        input.disabled = false;
    });
    updateOptionsCount();
}

function enableImageOptionsInputs() {
    document.querySelectorAll('.image-option-text, .image-option-input, .image-option-item input[type="checkbox"]').forEach(input => {
        input.disabled = false;
    });
    updateImageOptionsCount();
}

function enableFillBlanksInputs() {
    document.querySelectorAll('.blank-text, .blank-item input[type="checkbox"]').forEach(input => {
        input.disabled = false;
    });
    updateBlanksCount();
}

function enableMatchingInputs() {
    document.querySelectorAll('.matching-left-input, .matching-right-input').forEach(input => {
        input.disabled = false;
    });
    updateMatchingCount();
}

function enableCurrentSectionInputs() {
    const type = document.getElementById('questionType').value;
    switch(type) {
        case 'fill_blank':
            enableFillBlanksInputs();
            break;
        case 'matching':
            enableMatchingInputs();
            break;
        case 'image_selection':
            enableImageOptionsInputs();
            break;
        default:
            enableOptionsInputs();
            break;
    }
}

// Option functions
function addOption() {
    const container = document.getElementById('optionsContainer');
    if (!container) return;
    
    const index = container.children.length;
    
    const div = document.createElement('div');
    div.className = 'option-item';
    div.setAttribute('data-index', index);
    div.innerHTML = `
        <div class="option-drag">
            <i class="fas fa-grip-vertical"></i>
        </div>
        <div class="option-input-group">
            <div class="option-field">
                <input type="text" 
                       name="options[${index}][text]" 
                       class="option-text" 
                       placeholder="Enter option ${index + 1}">
            </div>
            <div class="option-check">
                <label class="checkbox-label">
                    <input type="checkbox" 
                           name="options[${index}][is_correct]" 
                           value="1"
                           class="correct-checkbox"
                           data-option-index="${index}">
                    <span class="checkbox-custom"></span>
                    <span class="checkbox-text">Correct</span>
                </label>
            </div>
            <button type="button" class="option-remove" onclick="removeOption(this)">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    container.appendChild(div);
    
    if (!['fill_blank', 'matching', 'image_selection'].includes(document.getElementById('questionType').value)) {
        div.querySelectorAll('input').forEach(input => input.disabled = false);
    }
    
    // Add event listener for the new checkbox
    const newCheckbox = div.querySelector('.correct-checkbox');
    newCheckbox.addEventListener('change', handleCorrectCheckboxChange);
    
    updateOptionsCount();
}

function removeOption(btn) {
    const questionType = document.getElementById('questionType').value;
    
    // Don't allow removal for true/false questions
    if (questionType === 'true_false') {
        return;
    }
    
    const row = btn.closest('.option-item');
    if (row) {
        row.remove();
        updateOptionsIndices();
        updateOptionsCount();
    }
}

function updateOptionsIndices() {
    const rows = document.querySelectorAll('#optionsContainer .option-item');
    rows.forEach((row, index) => {
        row.setAttribute('data-index', index);
        const inputs = row.querySelectorAll('input[type="text"]');
        inputs.forEach(input => {
            input.name = `options[${index}][text]`;
            if (document.getElementById('questionType').value !== 'true_false') {
                input.readOnly = false;
            }
        });
        
        const checkboxes = row.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            checkbox.name = `options[${index}][is_correct]`;
            checkbox.setAttribute('data-option-index', index);
        });
        
        const placeholder = row.querySelector('input[type="text"]');
        if (placeholder) {
            placeholder.placeholder = `Enter option ${index + 1}`;
        }
    });
}

function updateOptionsCount() {
    const optionsCount = document.getElementById('optionsCount');
    if (optionsCount) {
        optionsCount.textContent = document.querySelectorAll('#optionsContainer .option-item').length + ' options';
    }
}

// Image Option functions
function addImageOption() {
    const container = document.getElementById('imageOptionsContainer');
    if (!container) return;
    
    const index = container.children.length;
    
    const div = document.createElement('div');
    div.className = 'image-option-item';
    div.setAttribute('data-index', index);
    div.innerHTML = `
        <div class="option-drag">
            <i class="fas fa-grip-vertical"></i>
        </div>
        <div class="image-option-content">
            <div class="image-upload-box">
                <input type="file" 
                       name="options[${index}][image]" 
                       class="image-option-input" 
                       accept="image/*"
                       onchange="previewImageOption(this, ${index})">
                <div class="image-preview-box" id="imagePreview${index}">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <span>Upload Image</span>
                </div>
            </div>
            <div class="image-option-details">
                <input type="text" 
                       name="options[${index}][text]" 
                       class="image-option-text" 
                       placeholder="Alt text / Label">
                <div class="image-option-check">
                    <label class="checkbox-label">
                        <input type="checkbox" 
                               name="options[${index}][is_correct]" 
                               value="1"
                               class="correct-checkbox"
                               data-option-index="${index}">
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
    
    if (document.getElementById('questionType').value === 'image_selection') {
        div.querySelectorAll('input').forEach(input => input.disabled = false);
    }
    
    updateImageOptionsCount();
}

function removeImageOption(btn) {
    const row = btn.closest('.image-option-item');
    if (row) {
        row.remove();
        updateImageOptionsIndices();
        updateImageOptionsCount();
    }
}

function updateImageOptionsIndices() {
    const rows = document.querySelectorAll('#imageOptionsContainer .image-option-item');
    rows.forEach((row, index) => {
        row.setAttribute('data-index', index);
        
        const fileInput = row.querySelector('input[type="file"]');
        if (fileInput) {
            fileInput.name = `options[${index}][image]`;
            fileInput.setAttribute('onchange', `previewImageOption(this, ${index})`);
        }
        
        const textInput = row.querySelector('.image-option-text');
        if (textInput) {
            textInput.name = `options[${index}][text]`;
        }
        
        const checkbox = row.querySelector('input[type="checkbox"]');
        if (checkbox) {
            checkbox.name = `options[${index}][is_correct]`;
        }
        
        const previewBox = row.querySelector('.image-preview-box');
        if (previewBox) {
            previewBox.id = `imagePreview${index}`;
        }
    });
}

function updateImageOptionsCount() {
    const imageOptionsCount = document.getElementById('imageOptionsCount');
    if (imageOptionsCount) {
        imageOptionsCount.textContent = document.querySelectorAll('#imageOptionsContainer .image-option-item').length + ' images';
    }
}

function previewImageOption(input, index) {
    const previewBox = document.getElementById(`imagePreview${index}`);
    if (!previewBox) return;
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewBox.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
        }
        reader.readAsDataURL(input.files[0]);
    } else {
        previewBox.innerHTML = `
            <i class="fas fa-cloud-upload-alt"></i>
            <span>Upload Image</span>
        `;
    }
}

// Fill Blank functions
function addFillBlank() {
    const container = document.getElementById('fillBlanksContainer');
    if (!container) return;
    
    const index = container.children.length;
    
    const div = document.createElement('div');
    div.className = 'blank-item';
    div.setAttribute('data-index', index);
    div.innerHTML = `
        <div class="blank-drag">
            <i class="fas fa-grip-vertical"></i>
        </div>
        <div class="blank-input-group">
            <div class="blank-field">
                <input type="text" 
                       name="fill_blanks[${index}][answer]" 
                       class="blank-text" 
                       placeholder="Enter correct answer">
            </div>
            <div class="blank-case">
                <label class="checkbox-label">
                    <input type="checkbox" 
                           name="fill_blanks[${index}][case_sensitive]" 
                           value="1">
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
    
    if (document.getElementById('questionType').value === 'fill_blank') {
        div.querySelectorAll('input').forEach(input => input.disabled = false);
    }
    
    updateBlanksCount();
}

function removeBlank(btn) {
    const row = btn.closest('.blank-item');
    if (row) {
        row.remove();
        updateBlanksIndices();
        updateBlanksCount();
    }
}

function updateBlanksIndices() {
    const rows = document.querySelectorAll('#fillBlanksContainer .blank-item');
    rows.forEach((row, index) => {
        row.setAttribute('data-index', index);
        
        const textInput = row.querySelector('.blank-text');
        if (textInput) {
            textInput.name = `fill_blanks[${index}][answer]`;
        }
        
        const checkbox = row.querySelector('input[type="checkbox"]');
        if (checkbox) {
            checkbox.name = `fill_blanks[${index}][case_sensitive]`;
        }
    });
}

function updateBlanksCount() {
    const blanksCount = document.getElementById('blanksCount');
    if (blanksCount) {
        blanksCount.textContent = document.querySelectorAll('#fillBlanksContainer .blank-item').length + ' answers';
    }
}

// Matching functions
function addMatchingPair() {
    const container = document.getElementById('matchingPairsContainer');
    if (!container) return;
    
    const index = container.children.length;
    
    const div = document.createElement('div');
    div.className = 'matching-item';
    div.setAttribute('data-index', index);
    div.innerHTML = `
        <div class="matching-drag">
            <i class="fas fa-grip-vertical"></i>
        </div>
        <div class="matching-input-group">
            <div class="matching-left">
                <input type="text" 
                       name="matching_pairs[${index}][left]" 
                       class="matching-left-input" 
                       placeholder="Left item (e.g., Country)">
            </div>
            <div class="matching-arrow">
                <i class="fas fa-long-arrow-alt-right"></i>
            </div>
            <div class="matching-right">
                <input type="text" 
                       name="matching_pairs[${index}][right]" 
                       class="matching-right-input" 
                       placeholder="Right item (e.g., Capital)">
            </div>
            <div class="matching-badge correct">
                <i class="fas fa-check-circle"></i>
                <span>Correct Pair</span>
            </div>
            <button type="button" class="matching-remove" onclick="removeMatchingPair(this)">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    container.appendChild(div);
    
    if (document.getElementById('questionType').value === 'matching') {
        div.querySelectorAll('input').forEach(input => input.disabled = false);
    }
    
    updateMatchingCount();
}

function removeMatchingPair(btn) {
    if (confirm('Are you sure you want to remove this matching pair?')) {
        const row = btn.closest('.matching-item');
        if (row) {
            row.remove();
            updateMatchingIndices();
            updateMatchingCount();
        }
    }
}

function updateMatchingIndices() {
    const rows = document.querySelectorAll('#matchingPairsContainer .matching-item');
    rows.forEach((row, index) => {
        row.setAttribute('data-index', index);
        
        const leftInput = row.querySelector('.matching-left-input');
        if (leftInput) {
            leftInput.name = `matching_pairs[${index}][left]`;
            leftInput.placeholder = `Left item ${index + 1}`;
        }
        
        const rightInput = row.querySelector('.matching-right-input');
        if (rightInput) {
            rightInput.name = `matching_pairs[${index}][right]`;
            rightInput.placeholder = `Right item ${index + 1}`;
        }
    });
}

function updateMatchingCount() {
    const matchingCount = document.getElementById('matchingCount');
    if (matchingCount) {
        const count = document.querySelectorAll('#matchingPairsContainer .matching-item').length;
        matchingCount.textContent = count + ' ' + (count === 1 ? 'pair' : 'pairs');
    }
}

// Questions order
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
        const badge = question.querySelector('.badge-number');
        if (badge) {
            badge.textContent = 'Q' + (index + 1);
        }
    });
    
    // Send to server
    fetch('{{ route("admin.quizzes.questions.reorder") }}', {
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
    });
}

// Delete question
function deleteQuestion(id) {
    if (confirm('Are you sure you want to delete this question? This action cannot be undone.')) {
        const form = document.getElementById('deleteForm');
        form.action = '{{ url("admin/quizzes/questions") }}/' + id;
        form.submit();
    }
}

// Edit question
function editQuestion(id) {
    const modal = new bootstrap.Modal(document.getElementById('editQuestionModal'));
    const editContent = document.getElementById('editQuestionContent');
    
    if (!editContent) return;
    
    editContent.innerHTML = `
        <div class="loading-spinner">
            <div class="spinner"></div>
            <p>Loading question...</p>
        </div>
    `;
    modal.show();
    
    fetch(`/admin/quizzes/questions/${id}/edit`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => {
                throw new Error(JSON.stringify(err));
            }).catch(() => {
                throw new Error(`HTTP error! status: ${response.status}`);
            });
        }
        return response.json();
    })
    .then(question => {
        console.log('Question data loaded:', question);
        const form = buildEditForm(question);
        editContent.innerHTML = form;
        initializeEditForm(question.id);
        initializeEditCorrectCheckboxListeners();
    })
    .catch(error => {
        console.error('Detailed error:', error);
        editContent.innerHTML = `
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle me-2"></i>
                <div>
                    <strong>Error loading question:</strong>
                    <p>${error.message}</p>
                    <p class="mt-2 small">Please check the console for more details.</p>
                </div>
            </div>
        `;
    });
}

function initializeEditCorrectCheckboxListeners() {
    const questionType = document.getElementById('editQuestionType');
    const optionsContainer = document.getElementById('editOptionsContainer');
    
    if (optionsContainer && questionType && (questionType.value === 'single_choice' || questionType.value === 'true_false')) {
        optionsContainer.querySelectorAll('.correct-checkbox').forEach(checkbox => {
            checkbox.removeEventListener('change', handleEditCorrectCheckboxChange);
            checkbox.addEventListener('change', handleEditCorrectCheckboxChange);
        });
    }
}

function handleEditCorrectCheckboxChange(e) {
    const questionType = document.getElementById('editQuestionType').value;
    
    if (questionType === 'single_choice' || questionType === 'true_false') {
        if (e.target.checked) {
            const allCheckboxes = document.querySelectorAll('#editOptionsContainer .correct-checkbox');
            allCheckboxes.forEach(checkbox => {
                if (checkbox !== e.target) {
                    checkbox.checked = false;
                }
            });
        }
    }
}

function buildEditForm(question) {
    let optionsHtml = '';
    let imageOptionsHtml = '';
    let blanksHtml = '';
    let matchingHtml = '';
    
    // Add null checks for all arrays
    const options = question.options || [];
    const fillBlanks = question.fill_blanks || [];
    const matchingPairs = question.matching_pairs || [];
    
    // Build options HTML for multiple choice, single choice, true/false
    if (['multiple_choice', 'single_choice', 'true_false'].includes(question.question_type)) {
        if (options.length > 0) {
            optionsHtml = options.map((option, index) => `
                <div class="option-item" data-index="${index}">
                    <div class="option-drag">
                        <i class="fas fa-grip-vertical"></i>
                    </div>
                    <div class="option-input-group">
                        <div class="option-field">
                            <input type="text" 
                                   name="options[${index}][text]" 
                                   class="option-text" 
                                   placeholder="Enter option ${index + 1}"
                                   value="${(option.option_text || '').replace(/"/g, '&quot;')}"
                                   ${question.question_type === 'true_false' ? 'readonly' : ''}>
                        </div>
                        <div class="option-check">
                            <label class="checkbox-label">
                                <input type="checkbox" 
                                       name="options[${index}][is_correct]" 
                                       value="1"
                                       class="correct-checkbox"
                                       data-option-index="${index}"
                                       ${option.is_correct ? 'checked' : ''}>
                                <span class="checkbox-custom"></span>
                                <span class="checkbox-text">Correct</span>
                            </label>
                        </div>
                        <button type="button" class="option-remove" onclick="removeOption(this)" ${question.question_type === 'true_false' ? 'style="opacity: 0.5; pointer-events: none;"' : ''}>
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            `).join('');
        } else if (question.question_type === 'true_false') {
            // Default True/False options
            optionsHtml = `
                <div class="option-item" data-index="0">
                    <div class="option-drag"><i class="fas fa-grip-vertical"></i></div>
                    <div class="option-input-group">
                        <div class="option-field">
                            <input type="text" name="options[0][text]" class="option-text" value="True" readonly>
                        </div>
                        <div class="option-check">
                            <label class="checkbox-label">
                                <input type="checkbox" name="options[0][is_correct]" value="1" class="correct-checkbox" data-option-index="0">
                                <span class="checkbox-custom"></span>
                                <span class="checkbox-text">Correct</span>
                            </label>
                        </div>
                        <button type="button" class="option-remove" onclick="removeOption(this)" style="opacity: 0.5; pointer-events: none;"><i class="fas fa-times"></i></button>
                    </div>
                </div>
                <div class="option-item" data-index="1">
                    <div class="option-drag"><i class="fas fa-grip-vertical"></i></div>
                    <div class="option-input-group">
                        <div class="option-field">
                            <input type="text" name="options[1][text]" class="option-text" value="False" readonly>
                        </div>
                        <div class="option-check">
                            <label class="checkbox-label">
                                <input type="checkbox" name="options[1][is_correct]" value="1" class="correct-checkbox" data-option-index="1">
                                <span class="checkbox-custom"></span>
                                <span class="checkbox-text">Correct</span>
                            </label>
                        </div>
                        <button type="button" class="option-remove" onclick="removeOption(this)" style="opacity: 0.5; pointer-events: none;"><i class="fas fa-times"></i></button>
                    </div>
                </div>
            `;
        } else {
            // Default empty options for other types
            optionsHtml = `
                <div class="option-item" data-index="0">
                    <div class="option-drag"><i class="fas fa-grip-vertical"></i></div>
                    <div class="option-input-group">
                        <div class="option-field">
                            <input type="text" name="options[0][text]" class="option-text" placeholder="Enter option 1" value="">
                        </div>
                        <div class="option-check">
                            <label class="checkbox-label">
                                <input type="checkbox" name="options[0][is_correct]" value="1" class="correct-checkbox" data-option-index="0">
                                <span class="checkbox-custom"></span>
                                <span class="checkbox-text">Correct</span>
                            </label>
                        </div>
                        <button type="button" class="option-remove" onclick="removeOption(this)"><i class="fas fa-times"></i></button>
                    </div>
                </div>
                <div class="option-item" data-index="1">
                    <div class="option-drag"><i class="fas fa-grip-vertical"></i></div>
                    <div class="option-input-group">
                        <div class="option-field">
                            <input type="text" name="options[1][text]" class="option-text" placeholder="Enter option 2" value="">
                        </div>
                        <div class="option-check">
                            <label class="checkbox-label">
                                <input type="checkbox" name="options[1][is_correct]" value="1" class="correct-checkbox" data-option-index="1">
                                <span class="checkbox-custom"></span>
                                <span class="checkbox-text">Correct</span>
                            </label>
                        </div>
                        <button type="button" class="option-remove" onclick="removeOption(this)"><i class="fas fa-times"></i></button>
                    </div>
                </div>
            `;
        }
    }
    
    // Build image options HTML
    if (question.question_type === 'image_selection') {
        if (options.length > 0) {
            imageOptionsHtml = options.map((option, index) => `
                <div class="image-option-item" data-index="${index}">
                    <div class="option-drag">
                        <i class="fas fa-grip-vertical"></i>
                    </div>
                    <div class="image-option-content">
                        <div class="image-upload-box">
                            <input type="file" 
                                   name="options[${index}][image]" 
                                   class="image-option-input" 
                                   accept="image/*"
                                   onchange="previewImageOption(this, ${index})">
                            <div class="image-preview-box" id="editImagePreview${index}">
                                ${option.image ? `<img src="/storage/${option.image}" alt="Preview">` : '<i class="fas fa-cloud-upload-alt"></i><span>Upload Image</span>'}
                            </div>
                            ${option.image ? `<input type="hidden" name="options[${index}][existing_image]" value="${option.image}">` : ''}
                        </div>
                        <div class="image-option-details">
                            <input type="text" 
                                   name="options[${index}][text]" 
                                   class="image-option-text" 
                                   placeholder="Alt text / Label"
                                   value="${(option.option_text || '').replace(/"/g, '&quot;')}">
                            <div class="image-option-check">
                                <label class="checkbox-label">
                                    <input type="checkbox" 
                                           name="options[${index}][is_correct]" 
                                           value="1"
                                           class="correct-checkbox"
                                           data-option-index="${index}"
                                           ${option.is_correct ? 'checked' : ''}>
                                    <span class="checkbox-custom"></span>
                                    <span class="checkbox-text">Correct</span>
                                </label>
                            </div>
                        </div>
                        <button type="button" class="option-remove" onclick="removeImageOption(this)">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            `).join('');
        } else {
            // Default empty image options
            imageOptionsHtml = `
                <div class="image-option-item" data-index="0">
                    <div class="option-drag"><i class="fas fa-grip-vertical"></i></div>
                    <div class="image-option-content">
                        <div class="image-upload-box">
                            <input type="file" name="options[0][image]" class="image-option-input" accept="image/*" onchange="previewImageOption(this, 0)">
                            <div class="image-preview-box" id="editImagePreview0">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span>Upload Image</span>
                            </div>
                        </div>
                        <div class="image-option-details">
                            <input type="text" name="options[0][text]" class="image-option-text" placeholder="Alt text / Label" value="">
                            <div class="image-option-check">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="options[0][is_correct]" value="1" class="correct-checkbox" data-option-index="0">
                                    <span class="checkbox-custom"></span>
                                    <span class="checkbox-text">Correct</span>
                                </label>
                            </div>
                        </div>
                        <button type="button" class="option-remove" onclick="removeImageOption(this)"><i class="fas fa-times"></i></button>
                    </div>
                </div>
                <div class="image-option-item" data-index="1">
                    <div class="option-drag"><i class="fas fa-grip-vertical"></i></div>
                    <div class="image-option-content">
                        <div class="image-upload-box">
                            <input type="file" name="options[1][image]" class="image-option-input" accept="image/*" onchange="previewImageOption(this, 1)">
                            <div class="image-preview-box" id="editImagePreview1">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span>Upload Image</span>
                            </div>
                        </div>
                        <div class="image-option-details">
                            <input type="text" name="options[1][text]" class="image-option-text" placeholder="Alt text / Label" value="">
                            <div class="image-option-check">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="options[1][is_correct]" value="1" class="correct-checkbox" data-option-index="1">
                                    <span class="checkbox-custom"></span>
                                    <span class="checkbox-text">Correct</span>
                                </label>
                            </div>
                        </div>
                        <button type="button" class="option-remove" onclick="removeImageOption(this)"><i class="fas fa-times"></i></button>
                    </div>
                </div>
            `;
        }
    }
    
    // Build fill in the blanks HTML
    if (question.question_type === 'fill_blank') {
        if (fillBlanks.length > 0) {
            blanksHtml = fillBlanks.map((blank, index) => `
                <div class="blank-item" data-index="${index}">
                    <div class="blank-drag">
                        <i class="fas fa-grip-vertical"></i>
                    </div>
                    <div class="blank-input-group">
                        <div class="blank-field">
                            <input type="text" 
                                   name="fill_blanks[${index}][answer]" 
                                   class="blank-text" 
                                   placeholder="Enter correct answer"
                                   value="${(blank.correct_answer || '').replace(/"/g, '&quot;')}">
                        </div>
                        <div class="blank-case">
                            <label class="checkbox-label">
                                <input type="checkbox" 
                                       name="fill_blanks[${index}][case_sensitive]" 
                                       value="1"
                                       ${blank.case_sensitive ? 'checked' : ''}>
                                <span class="checkbox-custom"></span>
                                <span class="checkbox-text">Case Sensitive</span>
                            </label>
                        </div>
                        <button type="button" class="blank-remove" onclick="removeBlank(this)">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            `).join('');
        } else {
            blanksHtml = `
                <div class="blank-item" data-index="0">
                    <div class="blank-drag"><i class="fas fa-grip-vertical"></i></div>
                    <div class="blank-input-group">
                        <div class="blank-field">
                            <input type="text" name="fill_blanks[0][answer]" class="blank-text" placeholder="Enter correct answer" value="">
                        </div>
                        <div class="blank-case">
                            <label class="checkbox-label">
                                <input type="checkbox" name="fill_blanks[0][case_sensitive]" value="1">
                                <span class="checkbox-custom"></span>
                                <span class="checkbox-text">Case Sensitive</span>
                            </label>
                        </div>
                        <button type="button" class="blank-remove" onclick="removeBlank(this)"><i class="fas fa-times"></i></button>
                    </div>
                </div>
            `;
        }
    }
    
    // Build matching pairs HTML
    if (question.question_type === 'matching') {
        if (matchingPairs.length > 0) {
            matchingHtml = matchingPairs.map((pair, index) => `
                <div class="matching-item" data-index="${index}">
                    <div class="matching-drag">
                        <i class="fas fa-grip-vertical"></i>
                    </div>
                    <div class="matching-input-group">
                        <div class="matching-left">
                            <input type="text" 
                                   name="matching_pairs[${index}][left]" 
                                   class="matching-left-input" 
                                   placeholder="Left item ${index + 1}"
                                   value="${(pair.left_item || '').replace(/"/g, '&quot;')}">
                        </div>
                        <div class="matching-arrow">
                            <i class="fas fa-long-arrow-alt-right"></i>
                        </div>
                        <div class="matching-right">
                            <input type="text" 
                                   name="matching_pairs[${index}][right]" 
                                   class="matching-right-input" 
                                   placeholder="Right item ${index + 1}"
                                   value="${(pair.right_item || '').replace(/"/g, '&quot;')}">
                        </div>
                        <div class="matching-badge correct">
                            <i class="fas fa-check-circle"></i>
                            <span>Correct Pair</span>
                        </div>
                        <button type="button" class="matching-remove" onclick="removeMatchingPair(this)">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            `).join('');
        } else {
            matchingHtml = `
                <div class="matching-item" data-index="0">
                    <div class="matching-drag"><i class="fas fa-grip-vertical"></i></div>
                    <div class="matching-input-group">
                        <div class="matching-left">
                            <input type="text" name="matching_pairs[0][left]" class="matching-left-input" placeholder="Left item 1" value="">
                        </div>
                        <div class="matching-arrow"><i class="fas fa-long-arrow-alt-right"></i></div>
                        <div class="matching-right">
                            <input type="text" name="matching_pairs[0][right]" class="matching-right-input" placeholder="Right item 1" value="">
                        </div>
                        <div class="matching-badge correct">
                            <i class="fas fa-check-circle"></i>
                            <span>Correct Pair</span>
                        </div>
                        <button type="button" class="matching-remove" onclick="removeMatchingPair(this)"><i class="fas fa-times"></i></button>
                    </div>
                </div>
                <div class="matching-item" data-index="1">
                    <div class="matching-drag"><i class="fas fa-grip-vertical"></i></div>
                    <div class="matching-input-group">
                        <div class="matching-left">
                            <input type="text" name="matching_pairs[1][left]" class="matching-left-input" placeholder="Left item 2" value="">
                        </div>
                        <div class="matching-arrow"><i class="fas fa-long-arrow-alt-right"></i></div>
                        <div class="matching-right">
                            <input type="text" name="matching_pairs[1][right]" class="matching-right-input" placeholder="Right item 2" value="">
                        </div>
                        <div class="matching-badge correct">
                            <i class="fas fa-check-circle"></i>
                            <span>Correct Pair</span>
                        </div>
                        <button type="button" class="matching-remove" onclick="removeMatchingPair(this)"><i class="fas fa-times"></i></button>
                    </div>
                </div>
            `;
        }
    }
    
    // Rest of the function remains the same...
    return `
        <form id="editQuestionForm" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
            <input type="hidden" name="_method" value="PUT">
            
            <div class="form-group">
                <label class="form-label">Question Type</label>
                <div class="select-wrapper">
                    <select name="question_type" class="form-select" id="editQuestionType" required>
                        <option value="multiple_choice" ${question.question_type === 'multiple_choice' ? 'selected' : ''}>Multiple Choice</option>
                        <option value="single_choice" ${question.question_type === 'single_choice' ? 'selected' : ''}>Single Choice</option>
                        <option value="true_false" ${question.question_type === 'true_false' ? 'selected' : ''}>True/False</option>
                        <option value="fill_blank" ${question.question_type === 'fill_blank' ? 'selected' : ''}>Fill in the Blank</option>
                        <option value="matching" ${question.question_type === 'matching' ? 'selected' : ''}>Matching</option>
                        <option value="image_selection" ${question.question_type === 'image_selection' ? 'selected' : ''}>Image Selection</option>
                    </select>
                    <i class="fas fa-chevron-down select-arrow"></i>
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label">Question Text</label>
                <textarea name="question_text" class="form-control" rows="3" required>${(question.question_text || '').replace(/</g, '&lt;')}</textarea>
            </div>
            
            <div class="form-group">
                <label class="form-label">Explanation</label>
                <textarea name="explanation" class="form-control" rows="2">${(question.explanation || '').replace(/</g, '&lt;')}</textarea>
            </div>
            
            <div class="form-group">
                <label class="form-label">Points</label>
                <div class="input-wrapper">
                    <i class="fas fa-star input-icon"></i>
                    <input type="number" name="points" value="${question.points || 1}" min="1">
                </div>
            </div>
            
            ${question.image ? `
                <div class="form-group">
                    <label class="form-label">Current Image</label>
                    <div class="current-image">
                        <img src="/storage/${question.image}" alt="Question image">
                    </div>
                </div>
            ` : ''}
            
            <div class="form-group">
                <label class="form-label">${question.image ? 'Change Image' : 'Image'}</label>
                <div class="file-upload">
                    <input type="file" name="image" accept="image/*">
                    <div class="file-preview">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <span>Click to upload image</span>
                        <small>PNG, JPG, GIF up to 2MB</small>
                    </div>
                </div>
            </div>
            
            <div id="editOptionsSection" class="options-section" style="${!['fill_blank', 'matching', 'image_selection'].includes(question.question_type) ? 'display: block;' : 'display: none;'}">
                <div class="section-header">
                    <div class="section-title">
                        <i class="fas fa-list-ul"></i>
                        <h4>Answer Options</h4>
                    </div>
                    <span class="options-badge" id="editOptionsCount">${options.length || 2} options</span>
                </div>
                <div id="editOptionsContainer" class="options-container">
                    ${optionsHtml}
                </div>
                ${question.question_type !== 'true_false' ? `
                    <button type="button" class="btn-add" onclick="addEditOption()">
                        <i class="fas fa-plus"></i> Add Option
                    </button>
                ` : ''}
            </div>
            
            <div id="editImageSelectionSection" class="image-selection-section" style="${question.question_type === 'image_selection' ? 'display: block;' : 'display: none;'}">
                <div class="section-header">
                    <div class="section-title">
                        <i class="fas fa-images"></i>
                        <h4>Image Options</h4>
                    </div>
                    <span class="options-badge" id="editImageOptionsCount">${options.length || 2} images</span>
                </div>
                <div id="editImageOptionsContainer" class="image-options-container">
                    ${imageOptionsHtml}
                </div>
                <button type="button" class="btn-add" onclick="addEditImageOption()">
                    <i class="fas fa-plus"></i> Add Image Option
                </button>
            </div>
            
            <div id="editFillBlanksSection" class="blanks-section" style="${question.question_type === 'fill_blank' ? 'display: block;' : 'display: none;'}">
                <div class="section-header">
                    <div class="section-title">
                        <i class="fas fa-pencil-alt"></i>
                        <h4>Correct Answers</h4>
                    </div>
                    <span class="options-badge" id="editBlanksCount">${fillBlanks.length || 1} answers</span>
                </div>
                <div id="editBlanksContainer" class="blanks-container">
                    ${blanksHtml}
                </div>
                <button type="button" class="btn-add" onclick="addEditBlank()">
                    <i class="fas fa-plus"></i> Add Answer
                </button>
            </div>
            
            <div id="editMatchingSection" class="matching-section" style="${question.question_type === 'matching' ? 'display: block;' : 'display: none;'}">
                <div class="info-message">
                    <i class="fas fa-info-circle"></i>
                    <span>Define the matching pairs below. Each pair consists of a left item and its corresponding right item. All pairs are considered correct matches.</span>
                </div>
                
                <div class="section-header">
                    <div class="section-title">
                        <i class="fas fa-link"></i>
                        <h4>Matching Pairs</h4>
                    </div>
                    <span class="options-badge" id="editMatchingCount">${matchingPairs.length || 2} pairs</span>
                </div>
                <div id="editMatchingContainer" class="matching-container">
                    ${matchingHtml}
                </div>
                <button type="button" class="btn-add" onclick="addEditMatchingPair()">
                    <i class="fas fa-plus"></i> Add Matching Pair
                </button>
                
                <div class="matching-note">
                    <i class="fas fa-lightbulb"></i>
                    <span>Note: For matching questions, all defined pairs are considered correct. Students will need to match each left item with its correct right item.</span>
                </div>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Update Question
                </button>
            </div>
        </form>
    `;
}
function initializeEditForm(questionId) {
    const form = document.getElementById('editQuestionForm');
    const questionType = document.getElementById('editQuestionType');
    
    if (!form) return;
    
    // Initialize Sortable for edit options
    const optionsContainer = document.getElementById('editOptionsContainer');
    if (optionsContainer) {
        new Sortable(optionsContainer, {
            handle: '.option-drag',
            animation: 150,
            onEnd: updateEditOptionsIndices
        });
    }
    
    // Initialize Sortable for edit image options
    const imageOptionsContainer = document.getElementById('editImageOptionsContainer');
    if (imageOptionsContainer) {
        new Sortable(imageOptionsContainer, {
            handle: '.option-drag',
            animation: 150,
            onEnd: updateEditImageOptionsIndices
        });
    }
    
    // Initialize Sortable for edit blanks
    const blanksContainer = document.getElementById('editBlanksContainer');
    if (blanksContainer) {
        new Sortable(blanksContainer, {
            handle: '.blank-drag',
            animation: 150,
            onEnd: updateEditBlanksIndices
        });
    }
    
    // Initialize Sortable for edit matching
    const matchingContainer = document.getElementById('editMatchingContainer');
    if (matchingContainer) {
        new Sortable(matchingContainer, {
            handle: '.matching-drag',
            animation: 150,
            onEnd: updateEditMatchingIndices
        });
    }
    
    if (questionType) {
        questionType.addEventListener('change', function() {
            const optionsSection = document.getElementById('editOptionsSection');
            const imageSection = document.getElementById('editImageSelectionSection');
            const blanksSection = document.getElementById('editFillBlanksSection');
            const matchingSection = document.getElementById('editMatchingSection');
            
            optionsSection.style.display = 'none';
            imageSection.style.display = 'none';
            blanksSection.style.display = 'none';
            matchingSection.style.display = 'none';
            
            if (this.value === 'fill_blank') {
                blanksSection.style.display = 'block';
            } else if (this.value === 'matching') {
                matchingSection.style.display = 'block';
            } else if (this.value === 'image_selection') {
                imageSection.style.display = 'block';
            } else {
                optionsSection.style.display = 'block';
            }
            
            // Reinitialize checkbox listeners for single choice
            if (this.value === 'single_choice' || this.value === 'true_false') {
                setTimeout(() => {
                    initializeEditCorrectCheckboxListeners();
                }, 100);
            }
        });
    }
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
        submitBtn.disabled = true;
        
        const formData = new FormData(this);
        
        fetch(`/admin/quizzes/questions/${questionId}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                const modal = bootstrap.Modal.getInstance(document.getElementById('editQuestionModal'));
                if (modal) modal.hide();
                
                showNotification('Question updated successfully!', 'success');
                
                setTimeout(() => location.reload(), 1500);
            } else {
                throw new Error(data.message || 'Error updating question');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            
            let errorMessage = 'Error updating question. Please try again.';
            if (error.errors) {
                errorMessage = Object.values(error.errors).flat().join('\n');
            } else if (error.message) {
                errorMessage = error.message;
            }
            
            showNotification(errorMessage, 'error');
            
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    });
}

// Edit form helper functions
function addEditOption() {
    const container = document.getElementById('editOptionsContainer');
    if (!container) return;
    
    const index = container.children.length;
    
    const div = document.createElement('div');
    div.className = 'option-item';
    div.setAttribute('data-index', index);
    div.innerHTML = `
        <div class="option-drag">
            <i class="fas fa-grip-vertical"></i>
        </div>
        <div class="option-input-group">
            <div class="option-field">
                <input type="text" 
                       name="options[${index}][text]" 
                       class="option-text" 
                       placeholder="Enter option ${index + 1}">
            </div>
            <div class="option-check">
                <label class="checkbox-label">
                    <input type="checkbox" 
                           name="options[${index}][is_correct]" 
                           value="1"
                           class="correct-checkbox"
                           data-option-index="${index}">
                    <span class="checkbox-custom"></span>
                    <span class="checkbox-text">Correct</span>
                </label>
            </div>
            <button type="button" class="option-remove" onclick="removeOption(this)">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    container.appendChild(div);
    
    const editOptionsCount = document.getElementById('editOptionsCount');
    if (editOptionsCount) {
        editOptionsCount.textContent = container.children.length + ' options';
    }
    
    // Add event listener for single choice
    const questionType = document.getElementById('editQuestionType');
    if (questionType && (questionType.value === 'single_choice' || questionType.value === 'true_false')) {
        const newCheckbox = div.querySelector('.correct-checkbox');
        newCheckbox.addEventListener('change', handleEditCorrectCheckboxChange);
    }
}

function addEditImageOption() {
    const container = document.getElementById('editImageOptionsContainer');
    if (!container) return;
    
    const index = container.children.length;
    
    const div = document.createElement('div');
    div.className = 'image-option-item';
    div.setAttribute('data-index', index);
    div.innerHTML = `
        <div class="option-drag">
            <i class="fas fa-grip-vertical"></i>
        </div>
        <div class="image-option-content">
            <div class="image-upload-box">
                <input type="file" 
                       name="options[${index}][image]" 
                       class="image-option-input" 
                       accept="image/*"
                       onchange="previewImageOption(this, ${index})">
                <div class="image-preview-box" id="editImagePreview${index}">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <span>Upload Image</span>
                </div>
            </div>
            <div class="image-option-details">
                <input type="text" 
                       name="options[${index}][text]" 
                       class="image-option-text" 
                       placeholder="Alt text / Label">
                <div class="image-option-check">
                    <label class="checkbox-label">
                        <input type="checkbox" 
                               name="options[${index}][is_correct]" 
                               value="1"
                               class="correct-checkbox"
                               data-option-index="${index}">
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
    
    const editImageOptionsCount = document.getElementById('editImageOptionsCount');
    if (editImageOptionsCount) {
        editImageOptionsCount.textContent = container.children.length + ' images';
    }
}

function addEditBlank() {
    const container = document.getElementById('editBlanksContainer');
    if (!container) return;
    
    const index = container.children.length;
    
    const div = document.createElement('div');
    div.className = 'blank-item';
    div.setAttribute('data-index', index);
    div.innerHTML = `
        <div class="blank-drag">
            <i class="fas fa-grip-vertical"></i>
        </div>
        <div class="blank-input-group">
            <div class="blank-field">
                <input type="text" 
                       name="fill_blanks[${index}][answer]" 
                       class="blank-text" 
                       placeholder="Enter correct answer">
            </div>
            <div class="blank-case">
                <label class="checkbox-label">
                    <input type="checkbox" 
                           name="fill_blanks[${index}][case_sensitive]" 
                           value="1">
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
    
    const editBlanksCount = document.getElementById('editBlanksCount');
    if (editBlanksCount) {
        editBlanksCount.textContent = container.children.length + ' answers';
    }
}

function addEditMatchingPair() {
    const container = document.getElementById('editMatchingContainer');
    if (!container) return;
    
    const index = container.children.length;
    
    const div = document.createElement('div');
    div.className = 'matching-item';
    div.setAttribute('data-index', index);
    div.innerHTML = `
        <div class="matching-drag">
            <i class="fas fa-grip-vertical"></i>
        </div>
        <div class="matching-input-group">
            <div class="matching-left">
                <input type="text" 
                       name="matching_pairs[${index}][left]" 
                       class="matching-left-input" 
                       placeholder="Left item ${index + 1}">
            </div>
            <div class="matching-arrow">
                <i class="fas fa-long-arrow-alt-right"></i>
            </div>
            <div class="matching-right">
                <input type="text" 
                       name="matching_pairs[${index}][right]" 
                       class="matching-right-input" 
                       placeholder="Right item ${index + 1}">
            </div>
            <div class="matching-badge correct">
                <i class="fas fa-check-circle"></i>
                <span>Correct Pair</span>
            </div>
            <button type="button" class="matching-remove" onclick="removeMatchingPair(this)">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    container.appendChild(div);
    
    const editMatchingCount = document.getElementById('editMatchingCount');
    if (editMatchingCount) {
        editMatchingCount.textContent = container.children.length + ' pairs';
    }
}

function updateEditOptionsIndices() {
    const rows = document.querySelectorAll('#editOptionsContainer .option-item');
    rows.forEach((row, index) => {
        row.setAttribute('data-index', index);
        const inputs = row.querySelectorAll('input[type="text"]');
        inputs.forEach(input => {
            input.name = `options[${index}][text]`;
        });
        
        const checkboxes = row.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            checkbox.name = `options[${index}][is_correct]`;
            checkbox.setAttribute('data-option-index', index);
        });
        
        const placeholder = row.querySelector('input[type="text"]');
        if (placeholder) {
            placeholder.placeholder = `Enter option ${index + 1}`;
        }
    });
}

function updateEditImageOptionsIndices() {
    const rows = document.querySelectorAll('#editImageOptionsContainer .image-option-item');
    rows.forEach((row, index) => {
        row.setAttribute('data-index', index);
        
        const fileInput = row.querySelector('input[type="file"]');
        if (fileInput) {
            fileInput.name = `options[${index}][image]`;
            fileInput.setAttribute('onchange', `previewImageOption(this, ${index})`);
        }
        
        const textInput = row.querySelector('.image-option-text');
        if (textInput) {
            textInput.name = `options[${index}][text]`;
        }
        
        const checkbox = row.querySelector('input[type="checkbox"]');
        if (checkbox) {
            checkbox.name = `options[${index}][is_correct]`;
            checkbox.setAttribute('data-option-index', index);
        }
        
        const previewBox = row.querySelector('.image-preview-box');
        if (previewBox) {
            previewBox.id = `editImagePreview${index}`;
        }
    });
}

function updateEditBlanksIndices() {
    const rows = document.querySelectorAll('#editBlanksContainer .blank-item');
    rows.forEach((row, index) => {
        row.setAttribute('data-index', index);
        
        const textInput = row.querySelector('.blank-text');
        if (textInput) {
            textInput.name = `fill_blanks[${index}][answer]`;
        }
        
        const checkbox = row.querySelector('input[type="checkbox"]');
        if (checkbox) {
            checkbox.name = `fill_blanks[${index}][case_sensitive]`;
        }
    });
}

function updateEditMatchingIndices() {
    const rows = document.querySelectorAll('#editMatchingContainer .matching-item');
    rows.forEach((row, index) => {
        row.setAttribute('data-index', index);
        
        const leftInput = row.querySelector('.matching-left-input');
        if (leftInput) {
            leftInput.name = `matching_pairs[${index}][left]`;
            leftInput.placeholder = `Left item ${index + 1}`;
        }
        
        const rightInput = row.querySelector('.matching-right-input');
        if (rightInput) {
            rightInput.name = `matching_pairs[${index}][right]`;
            rightInput.placeholder = `Right item ${index + 1}`;
        }
    });
}

// Notification function
function showNotification(message, type = 'success') {
    const existingNotifications = document.querySelectorAll('.notification');
    existingNotifications.forEach(notification => notification.remove());
    
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
            <span>${message}</span>
        </div>
    `;
    
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 300px;
        padding: 16px 20px;
        border-radius: 10px;
        background: ${type === 'success' ? 'linear-gradient(135deg, #06d6a0, #05b586)' : 'linear-gradient(135deg, #ef476f, #d63e62)'};
        color: white;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        transform: translateX(400px);
        transition: transform 0.3s ease;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    setTimeout(() => {
        notification.style.transform = 'translateX(400px)';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
    
    notification.addEventListener('click', function() {
        notification.style.transform = 'translateX(400px)';
        setTimeout(() => notification.remove(), 300);
    });
}
</script>
@endpush