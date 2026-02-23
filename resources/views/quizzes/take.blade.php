@extends('layouts.main')

@section('title', 'Taking Quiz: ' . $quiz->title)

@section('content')
<div class="container" style="padding: 60px 0;">
    <!-- Quiz Taking Header -->
    <div class="quiz-take-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1>{{ $quiz->title }}</h1>
                <p class="text-muted">Question {{ $attempt->answers->count() + 1 }} of {{ $questions->count() }}</p>
            </div>
            <div class="col-md-6 text-end">
                @if($remainingTime)
                <div class="timer-card" id="timer" data-remaining="{{ $remainingTime }}">
                    <i class="far fa-clock"></i>
                    <span id="timerDisplay">{{ gmdate('H:i:s', $remainingTime) }}</span>
                </div>
                @endif
                <div class="progress mt-2" style="height: 10px;">
                    @php
                        $progress = ($attempt->answers->count() / $questions->count()) * 100;
                    @endphp
                    <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%;" 
                         aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <!-- Current Question -->
            @php
                $currentQuestion = $questions[$attempt->answers->count()] ?? null;
            @endphp

            @if($currentQuestion)
            <div class="question-card">
                <form action="{{ route('quizzes.submit', ['quiz' => $quiz, 'attempt' => $attempt]) }}" method="POST" id="quizForm">
                    @csrf
                    
                    <div class="question-header">
                        <span class="question-type-badge">{{ str_replace('_', ' ', ucfirst($currentQuestion->question_type)) }}</span>
                        <span class="question-points">{{ $currentQuestion->points }} points</span>
                    </div>

                    <div class="question-content">
                        <h3 class="question-text">{{ $currentQuestion->question_text }}</h3>

                        @if($currentQuestion->image)
                        <div class="question-image mb-4">
                            <img src="{{ $currentQuestion->image_url }}" alt="Question image" class="img-fluid rounded">
                        </div>
                        @endif

                        <!-- Multiple Choice / Single Choice / True False Options -->
                        @if(in_array($currentQuestion->question_type, ['multiple_choice', 'single_choice', 'true_false']))
                            <div class="options-list">
                                @foreach($currentQuestion->options as $option)
                                <div class="option-item">
                                    <div class="form-check">
                                        @if($currentQuestion->question_type == 'multiple_choice')
                                            <input class="form-check-input" 
                                                   type="checkbox" 
                                                   name="answers[{{ $currentQuestion->id }}][]" 
                                                   value="{{ $option->id }}"
                                                   id="option_{{ $option->id }}">
                                        @else
                                            <input class="form-check-input" 
                                                   type="radio" 
                                                   name="answers[{{ $currentQuestion->id }}]" 
                                                   value="{{ $option->id }}"
                                                   id="option_{{ $option->id }}">
                                        @endif
                                        
                                        <label class="form-check-label" for="option_{{ $option->id }}">
                                            @if($option->image)
                                                <div class="option-image">
                                                    <img src="{{ $option->image_url }}" alt="Option image" class="img-thumbnail">
                                                </div>
                                            @endif
                                            <span class="option-text">{{ $option->option_text }}</span>
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- Fill in the Blank -->
                        @if($currentQuestion->question_type == 'fill_blank')
                            <div class="fill-blank-section">
                                <div class="form-group">
                                    <label for="fill_blank_answer" class="form-label">Your Answer:</label>
                                    <input type="text" 
                                           class="form-control form-control-lg" 
                                           name="answers[{{ $currentQuestion->id }}]" 
                                           id="fill_blank_answer"
                                           placeholder="Type your answer here..."
                                           required>
                                </div>
                                @if($currentQuestion->fillBlanks->count() > 1)
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle"></i> 
                                        Any of the correct answers will be accepted.
                                    </small>
                                @endif
                            </div>
                        @endif

                        <!-- Matching -->
                        @if($currentQuestion->question_type == 'matching')
                            <div class="matching-section">
                                <p class="matching-instruction">Match the items from left column with right column:</p>
                                <div class="matching-grid">
                                    @foreach($currentQuestion->matchingPairs as $pair)
                                    <div class="matching-row mb-3">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="left-item">{{ $pair->left_item }}</div>
                                            </div>
                                            <div class="col-md-2 text-center">
                                                <i class="fas fa-arrows-alt-h text-muted"></i>
                                            </div>
                                            <div class="col-md-5">
                                                <select class="form-select" name="answers[{{ $currentQuestion->id }}][pair_{{ $pair->id }}]" required>
                                                    <option value="">Select match</option>
                                                    @foreach($currentQuestion->matchingPairs->shuffle() as $rightItem)
                                                        <option value="{{ $rightItem->right_item }}">{{ $rightItem->right_item }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Image Selection -->
                        @if($currentQuestion->question_type == 'image_selection')
                            <div class="image-selection-section">
                                <p class="mb-3">Select the correct image(s):</p>
                                <div class="row">
                                    @foreach($currentQuestion->options as $option)
                                    <div class="col-md-4 mb-3">
                                        <div class="image-option-card" onclick="toggleImageSelection(this, '{{ $option->id }}')">
                                            <input type="{{ $currentQuestion->question_type == 'multiple_choice' ? 'checkbox' : 'radio' }}" 
                                                   name="answers[{{ $currentQuestion->id }}]{{ $currentQuestion->question_type == 'multiple_choice' ? '[]' : '' }}" 
                                                   value="{{ $option->id }}"
                                                   id="image_option_{{ $option->id }}"
                                                   style="display: none;">
                                            @if($option->image)
                                                <img src="{{ $option->image_url }}" alt="{{ $option->option_text }}" class="img-fluid rounded">
                                                <p class="mt-2 text-center">{{ $option->option_text }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="question-footer">
                        <button type="submit" name="action" value="next" class="btn btn-primary btn-lg">
                            @if($attempt->answers->count() + 1 == $questions->count())
                                Submit Quiz <i class="fas fa-check"></i>
                            @else
                                Next Question <i class="fas fa-arrow-right"></i>
                            @endif
                        </button>
                        
                        @if($attempt->answers->count() > 0)
                        <button type="submit" name="action" value="previous" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-arrow-left"></i> Previous
                        </button>
                        @endif
                    </div>
                </form>
            </div>
            @else
                <!-- Quiz Complete -->
                <div class="complete-card text-center">
                    <i class="fas fa-check-circle complete-icon"></i>
                    <h2>Quiz Completed!</h2>
                    <p>You have answered all questions. Click below to submit your quiz.</p>
                    <form action="{{ route('quizzes.submit', ['quiz' => $quiz, 'attempt' => $attempt]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="action" value="complete">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-check-circle"></i> Submit Quiz
                        </button>
                    </form>
                </div>
            @endif
        </div>

        <div class="col-md-4">
            <!-- Question Navigator -->
            <div class="navigator-card">
                <h5>Question Navigator</h5>
                <div class="question-grid">
                    @foreach($questions as $index => $question)
                        @php
                            $isAnswered = $attempt->answers->contains('question_id', $question->id);
                            $isCurrent = $index == $attempt->answers->count();
                        @endphp
                        <div class="question-dot {{ $isAnswered ? 'answered' : '' }} {{ $isCurrent ? 'current' : '' }}">
                            {{ $index + 1 }}
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Quiz Info -->
            <div class="info-card mt-4">
                <h5>Quiz Information</h5>
                <ul class="info-list">
                    <li>
                        <i class="fas fa-clock"></i>
                        <span>Time Remaining: <strong>{{ $remainingTime ? gmdate('H:i:s', $remainingTime) : 'No limit' }}</strong></span>
                    </li>
                    <li>
                        <i class="fas fa-question-circle"></i>
                        <span>Questions Answered: <strong>{{ $attempt->answers->count() }}/{{ $questions->count() }}</strong></span>
                    </li>
                    <li>
                        <i class="fas fa-star"></i>
                        <span>Total Points: <strong>{{ $questions->sum('points') }}</strong></span>
                    </li>
                    @if($quiz->pass_percentage)
                    <li>
                        <i class="fas fa-trophy"></i>
                        <span>Passing Score: <strong>{{ $quiz->pass_percentage }}%</strong></span>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Auto-submit when timer expires -->
@if($remainingTime)
<form id="timeoutForm" action="{{ route('quizzes.submit', ['quiz' => $quiz, 'attempt' => $attempt]) }}" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="action" value="timeout">
</form>
@endif
@endsection

@section('styles')
<style>
    .quiz-take-header {
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }

    .timer-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 10px 20px;
        border-radius: 50px;
        display: inline-block;
        font-size: 20px;
        font-weight: 600;
    }

    .timer-card i {
        margin-right: 10px;
    }

    .progress {
        background: #f0f0f0;
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-bar {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        transition: width 0.3s ease;
    }

    /* Question Card */
    .question-card {
        background: white;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }

    .question-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f0f0f0;
    }

    .question-type-badge {
        background: #f0f0f0;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 14px;
        color: #666;
    }

    .question-points {
        color: #667eea;
        font-weight: 600;
    }

    .question-text {
        font-size: 20px;
        margin-bottom: 20px;
        color: #333;
    }

    .question-image img {
        max-width: 100%;
        max-height: 300px;
    }

    /* Options */
    .options-list {
        margin-top: 20px;
    }

    .option-item {
        margin-bottom: 15px;
        padding: 15px;
        border: 2px solid #f0f0f0;
        border-radius: 10px;
        transition: all 0.3s;
    }

    .option-item:hover {
        border-color: #667eea;
        background: #f8f9ff;
    }

    .form-check-input:checked + .form-check-label {
        color: #667eea;
        font-weight: 600;
    }

    .option-image {
        margin-bottom: 10px;
    }

    .option-image img {
        max-width: 100px;
        max-height: 100px;
    }

    .option-text {
        font-size: 16px;
    }

    /* Fill Blank */
    .fill-blank-section {
        margin-top: 20px;
    }

    .fill-blank-section .form-control {
        border: 2px solid #f0f0f0;
        padding: 15px;
        font-size: 18px;
    }

    .fill-blank-section .form-control:focus {
        border-color: #667eea;
        box-shadow: none;
    }

    /* Matching */
    .matching-section {
        margin-top: 20px;
    }

    .matching-instruction {
        color: #666;
        margin-bottom: 20px;
    }

    .matching-row {
        padding: 15px;
        background: #f8f9fa;
        border-radius: 8px;
    }

    .left-item {
        font-weight: 600;
        color: #333;
        padding: 10px;
        background: white;
        border-radius: 5px;
        text-align: center;
    }

    /* Image Selection */
    .image-option-card {
        border: 2px solid #f0f0f0;
        border-radius: 10px;
        padding: 15px;
        cursor: pointer;
        transition: all 0.3s;
        text-align: center;
    }

    .image-option-card.selected {
        border-color: #667eea;
        background: #f8f9ff;
        transform: scale(1.02);
    }

    .image-option-card img {
        width: 100%;
        height: 150px;
        object-fit: cover;
        border-radius: 5px;
    }

    .image-option-card p {
        margin-top: 10px;
        color: #333;
    }

    /* Question Footer */
    .question-footer {
        margin-top: 30px;
        padding-top: 20px;
        border-top: 2px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
    }

    .btn-lg {
        padding: 12px 30px;
        font-size: 16px;
    }

    /* Navigator */
    .navigator-card, .info-card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }

    .question-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 10px;
        margin-top: 15px;
    }

    .question-dot {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 600;
        color: #666;
        cursor: pointer;
        transition: all 0.3s;
    }

    .question-dot.answered {
        background: #10b981;
        color: white;
    }

    .question-dot.current {
        background: #667eea;
        color: white;
        transform: scale(1.1);
    }

    .question-dot:hover {
        transform: scale(1.1);
    }

    .info-list {
        list-style: none;
        padding: 0;
        margin: 15px 0 0;
    }

    .info-list li {
        display: flex;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .info-list li:last-child {
        border-bottom: none;
    }

    .info-list li i {
        width: 30px;
        color: #667eea;
    }

    /* Complete Card */
    .complete-card {
        background: white;
        border-radius: 10px;
        padding: 60px 30px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }

    .complete-icon {
        font-size: 80px;
        color: #10b981;
        margin-bottom: 20px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .quiz-take-header {
            text-align: center;
        }
        
        .timer-card {
            margin-top: 15px;
        }
        
        .question-footer {
            flex-direction: column;
            gap: 10px;
        }
        
        .question-footer .btn {
            width: 100%;
        }
        
        .question-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }
</style>
@endsection

@section('scripts')
<script>
    // Timer functionality
    @if($remainingTime)
    let remainingSeconds = {{ $remainingTime }};
    const timerDisplay = document.getElementById('timerDisplay');
    const timeoutForm = document.getElementById('timeoutForm');
    
    const timer = setInterval(function() {
        remainingSeconds--;
        
        if (remainingSeconds <= 0) {
            clearInterval(timer);
            if (timeoutForm) {
                timeoutForm.submit();
            }
        } else {
            const hours = Math.floor(remainingSeconds / 3600);
            const minutes = Math.floor((remainingSeconds % 3600) / 60);
            const seconds = remainingSeconds % 60;
            
            timerDisplay.textContent = 
                (hours < 10 ? '0' + hours : hours) + ':' +
                (minutes < 10 ? '0' + minutes : minutes) + ':' +
                (seconds < 10 ? '0' + seconds : seconds);
        }
    }, 1000);
    @endif

    // Image selection toggle
    function toggleImageSelection(element, optionId) {
        const checkbox = element.querySelector('input[type="checkbox"], input[type="radio"]');
        if (checkbox) {
            checkbox.checked = !checkbox.checked;
            element.classList.toggle('selected', checkbox.checked);
        }
    }

    // Form submission warning
    document.getElementById('quizForm')?.addEventListener('submit', function(e) {
        const action = e.submitter?.value;
        
        if (action === 'complete' || action === 'submit') {
            if (!confirm('Are you sure you want to submit your quiz? You cannot change your answers after submission.')) {
                e.preventDefault();
            }
        }
    });

    // Question dot navigation (you'll need to implement this with AJAX if you want this feature)
    document.querySelectorAll('.question-dot').forEach((dot, index) => {
        dot.addEventListener('click', function() {
            // This would require AJAX to save current answer and load different question
            // For now, we'll just show a message
            alert('Quick navigation is not available in this version. Please use Next/Previous buttons.');
        });
    });
</script>
@endsection