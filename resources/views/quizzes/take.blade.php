@extends('layouts.main')

@section('title', 'Taking Quiz: ' . $quiz->title . ' - EDUCONECX')

@section('meta_description', 'Take the quiz and test your knowledge.')

@section('content')
<style>
    /* Quiz Taking Page Specific Styles - Scoped to prevent conflicts */
    :root {
        --quiz-take-primary: #4361ee;
        --quiz-take-primary-dark: #3a56d4;
        --quiz-take-primary-light: #4895ef;
        --quiz-take-secondary: #4cc9f0;
        --quiz-take-accent: #f72585;
        --quiz-take-success: #06d6a0;
        --quiz-take-warning: #ffd166;
        --quiz-take-danger: #ef476f;
        --quiz-take-dark: #1e1e2f;
        --quiz-take-gray: #6c757d;
        --quiz-take-gray-light: #e9ecef;
        --quiz-take-light: #f8f9fa;
        --quiz-take-white: #ffffff;
        --quiz-take-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --quiz-take-gradient-hover: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        --quiz-take-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        --quiz-take-shadow-hover: 0 15px 40px rgba(67, 97, 238, 0.15);
        --quiz-take-radius: 12px;
        --quiz-take-radius-lg: 20px;
        --quiz-take-radius-sm: 8px;
        --quiz-take-radius-full: 9999px;
        --quiz-take-transition: all 0.3s ease;
    }

    /* Main Container */
    .quiz-take-container {
        background: var(--quiz-take-light);
        min-height: 100vh;
        padding: 40px 0;
    }

    /* Quiz Header */
    .quiz-take-header {
        background: var(--quiz-take-white);
        border-radius: var(--quiz-take-radius-lg);
        padding: 25px 30px;
        box-shadow: var(--quiz-take-shadow);
        margin-bottom: 30px;
    }

    .quiz-take-header h1 {
        font-size: 1.8rem !important;
        font-weight: 700 !important;
        color: var(--quiz-take-dark) !important;
        margin-bottom: 8px !important;
    }

    .quiz-take-header .text-muted {
        color: var(--quiz-take-gray) !important;
        font-size: 1rem !important;
    }

    .quiz-take-timer {
        background: var(--quiz-take-gradient);
        color: var(--quiz-take-white);
        padding: 12px 25px;
        border-radius: var(--quiz-take-radius-full);
        display: inline-flex;
        align-items: center;
        gap: 10px;
        font-size: 1.5rem;
        font-weight: 600;
        box-shadow: var(--quiz-take-shadow);
    }

    .quiz-take-timer i {
        font-size: 1.3rem;
    }

    .quiz-take-timer.warning {
        background: var(--quiz-take-danger);
        animation: quiz-take-pulse 1s infinite;
    }

    @keyframes quiz-take-pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    .quiz-take-progress {
        margin-top: 15px;
    }

    .quiz-take-progress-bar {
        height: 10px;
        background: var(--quiz-take-gray-light);
        border-radius: var(--quiz-take-radius-full);
        overflow: hidden;
        position: relative;
    }

    .quiz-take-progress-fill {
        height: 100%;
        background: var(--quiz-take-gradient);
        border-radius: var(--quiz-take-radius-full);
        transition: width 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .quiz-take-progress-fill::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(
            90deg,
            transparent,
            rgba(255, 255, 255, 0.3),
            transparent
        );
        animation: quiz-take-shimmer 2s infinite;
    }

    @keyframes quiz-take-shimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }

    .quiz-take-progress-stats {
        display: flex;
        justify-content: space-between;
        margin-top: 8px;
        font-size: 0.9rem;
        color: var(--quiz-take-gray);
    }

    /* Language Selector */
    .quiz-take-language-selector {
        background: var(--quiz-take-white);
        border-radius: var(--quiz-take-radius-full);
        padding: 5px;
        display: inline-flex;
        gap: 5px;
        box-shadow: var(--quiz-take-shadow);
        margin-left: 15px;
    }

    .quiz-take-language-btn {
        padding: 8px 20px;
        border: none;
        border-radius: var(--quiz-take-radius-full);
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--quiz-take-transition);
        background: transparent;
        color: var(--quiz-take-gray);
    }

    .quiz-take-language-btn:hover {
        background: var(--quiz-take-light);
    }

    .quiz-take-language-btn.active {
        background: var(--quiz-take-gradient);
        color: var(--quiz-take-white);
    }

    /* Question Card */
    .quiz-take-question-card {
        background: var(--quiz-take-white);
        border-radius: var(--quiz-take-radius-lg);
        padding: 35px;
        box-shadow: var(--quiz-take-shadow);
        margin-bottom: 30px;
    }

    .quiz-take-question-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        padding-bottom: 20px;
        border-bottom: 2px solid var(--quiz-take-gray-light);
    }

    .quiz-take-question-badge {
        background: var(--quiz-take-gradient);
        color: var(--quiz-take-white);
        padding: 6px 18px;
        border-radius: var(--quiz-take-radius-full);
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .quiz-take-question-points {
        background: rgba(67, 97, 238, 0.1);
        color: var(--quiz-take-primary);
        padding: 6px 15px;
        border-radius: var(--quiz-take-radius-full);
        font-size: 0.9rem;
        font-weight: 600;
    }

    .quiz-take-question-text {
        font-size: 1.4rem !important;
        font-weight: 600 !important;
        color: var(--quiz-take-dark) !important;
        margin-bottom: 25px !important;
        line-height: 1.5 !important;
    }

    .quiz-take-question-image {
        margin-bottom: 30px;
        text-align: center;
    }

    .quiz-take-question-image img {
        max-width: 100%;
        max-height: 400px;
        border-radius: var(--quiz-take-radius);
        box-shadow: var(--quiz-take-shadow);
    }

    /* Options List */
    .quiz-take-options-list {
        margin-top: 20px;
    }

    .quiz-take-option-item {
        margin-bottom: 15px;
        padding: 18px 20px;
        border: 2px solid var(--quiz-take-gray-light);
        border-radius: var(--quiz-take-radius);
        transition: var(--quiz-take-transition);
        cursor: pointer;
        background: var(--quiz-take-white);
    }

    .quiz-take-option-item:hover {
        border-color: var(--quiz-take-primary);
        background: rgba(67, 97, 238, 0.02);
        transform: translateX(5px);
    }

    .quiz-take-option-item.selected {
        border-color: var(--quiz-take-primary);
        background: rgba(67, 97, 238, 0.05);
        box-shadow: 0 5px 15px rgba(67, 97, 238, 0.1);
    }

    .quiz-take-option-item .form-check {
        display: flex;
        align-items: center;
        margin: 0;
        padding: 0;
    }

    .quiz-take-option-item .form-check-input {
        width: 22px;
        height: 22px;
        margin-right: 15px;
        cursor: pointer;
        border: 2px solid var(--quiz-take-gray);
    }

    .quiz-take-option-item .form-check-input:checked {
        background-color: var(--quiz-take-primary);
        border-color: var(--quiz-take-primary);
    }

    .quiz-take-option-item .form-check-label {
        flex: 1;
        cursor: pointer;
        font-size: 1.1rem;
        color: var(--quiz-take-dark);
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .quiz-take-option-image {
        width: 60px;
        height: 60px;
        border-radius: var(--quiz-take-radius-sm);
        overflow: hidden;
        flex-shrink: 0;
    }

    .quiz-take-option-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .quiz-take-option-text {
        flex: 1;
    }

    /* Fill in the Blank */
    .quiz-take-fill-blank {
        margin-top: 20px;
    }

    .quiz-take-fill-blank .form-control {
        border: 2px solid var(--quiz-take-gray-light);
        border-radius: var(--quiz-take-radius);
        padding: 15px 20px;
        font-size: 1.1rem;
        transition: var(--quiz-take-transition);
    }

    .quiz-take-fill-blank .form-control:focus {
        border-color: var(--quiz-take-primary);
        box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1);
    }

    .quiz-take-fill-blank small {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 10px;
        color: var(--quiz-take-gray);
    }

    .quiz-take-fill-blank small i {
        color: var(--quiz-take-primary);
    }

    /* Matching Section */
    .quiz-take-matching {
        margin-top: 20px;
    }

    .quiz-take-matching-instruction {
        background: var(--quiz-take-light);
        padding: 15px 20px;
        border-radius: var(--quiz-take-radius);
        margin-bottom: 25px;
        color: var(--quiz-take-gray);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .quiz-take-matching-instruction i {
        color: var(--quiz-take-primary);
        font-size: 1.2rem;
    }

    .quiz-take-matching-row {
        background: var(--quiz-take-light);
        border-radius: var(--quiz-take-radius);
        padding: 20px;
        margin-bottom: 15px;
        transition: var(--quiz-take-transition);
    }

    .quiz-take-matching-row:hover {
        transform: translateX(5px);
        box-shadow: var(--quiz-take-shadow);
    }

    .quiz-take-matching-left {
        font-weight: 600;
        color: var(--quiz-take-dark);
        padding: 10px;
        background: var(--quiz-take-white);
        border-radius: var(--quiz-take-radius);
        text-align: center;
        border: 1px dashed var(--quiz-take-primary-light);
    }

    .quiz-take-matching-arrow {
        text-align: center;
        color: var(--quiz-take-gray);
    }

    .quiz-take-matching-select {
        width: 100%;
        padding: 10px 15px;
        border: 2px solid var(--quiz-take-gray-light);
        border-radius: var(--quiz-take-radius);
        background: var(--quiz-take-white);
        cursor: pointer;
        transition: var(--quiz-take-transition);
    }

    .quiz-take-matching-select:focus {
        border-color: var(--quiz-take-primary);
        box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1);
    }

    /* Image Selection */
    .quiz-take-image-selection {
        margin-top: 20px;
    }

    .quiz-take-image-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-top: 20px;
    }

    .quiz-take-image-option {
        border: 2px solid var(--quiz-take-gray-light);
        border-radius: var(--quiz-take-radius);
        overflow: hidden;
        cursor: pointer;
        transition: var(--quiz-take-transition);
    }

    .quiz-take-image-option:hover {
        transform: translateY(-5px);
        box-shadow: var(--quiz-take-shadow);
    }

    .quiz-take-image-option.selected {
        border-color: var(--quiz-take-primary);
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.3);
    }

    .quiz-take-image-option img {
        width: 100%;
        height: 150px;
        object-fit: cover;
    }

    .quiz-take-image-option p {
        text-align: center;
        padding: 10px;
        margin: 0;
        background: var(--quiz-take-light);
        font-weight: 500;
    }

    /* Translation Loading */
    .quiz-take-translation-loading {
        position: fixed;
        top: 20px;
        right: 20px;
        background: var(--quiz-take-primary);
        color: white;
        padding: 10px 20px;
        border-radius: var(--quiz-take-radius-full);
        box-shadow: var(--quiz-take-shadow);
        z-index: 1000;
        display: none;
        align-items: center;
        gap: 10px;
    }

    .quiz-take-translation-loading.show {
        display: flex;
    }

    .quiz-take-translation-loading i {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Question Footer */
    .quiz-take-question-footer {
        margin-top: 35px;
        padding-top: 25px;
        border-top: 2px solid var(--quiz-take-gray-light);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .quiz-take-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 14px 30px;
        border-radius: var(--quiz-take-radius-full);
        font-size: 1rem;
        font-weight: 600;
        text-decoration: none;
        transition: var(--quiz-take-transition);
        border: none;
        cursor: pointer;
    }

    .quiz-take-btn.primary {
        background: var(--quiz-take-gradient);
        color: var(--quiz-take-white);
    }

    .quiz-take-btn.primary:hover {
        background: var(--quiz-take-gradient-hover);
        transform: translateX(5px);
        box-shadow: var(--quiz-take-shadow-hover);
    }

    .quiz-take-btn.secondary {
        background: var(--quiz-take-light);
        color: var(--quiz-take-gray);
        border: 2px solid var(--quiz-take-gray-light);
    }

    .quiz-take-btn.secondary:hover {
        background: var(--quiz-take-gray-light);
        color: var(--quiz-take-dark);
        transform: translateX(-5px);
    }

    .quiz-take-btn.success {
        background: var(--quiz-take-success);
        color: var(--quiz-take-white);
    }

    .quiz-take-btn.success:hover {
        background: #05b586;
        transform: translateY(-2px);
        box-shadow: var(--quiz-take-shadow);
    }

    /* Navigator Card */
    .quiz-take-navigator-card,
    .quiz-take-info-card {
        background: var(--quiz-take-white);
        border-radius: var(--quiz-take-radius-lg);
        padding: 25px;
        box-shadow: var(--quiz-take-shadow);
        margin-bottom: 25px;
    }

    .quiz-take-navigator-title {
        font-size: 1.2rem !important;
        font-weight: 600 !important;
        color: var(--quiz-take-dark) !important;
        margin-bottom: 20px !important;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .quiz-take-navigator-title i {
        color: var(--quiz-take-primary);
    }

    .quiz-take-question-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 10px;
    }

    .quiz-take-question-dot {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: var(--quiz-take-light);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--quiz-take-gray);
        cursor: pointer;
        transition: var(--quiz-take-transition);
        border: 2px solid transparent;
    }

    .quiz-take-question-dot:hover {
        transform: scale(1.1);
        border-color: var(--quiz-take-primary);
    }

    .quiz-take-question-dot.answered {
        background: var(--quiz-take-success);
        color: var(--quiz-take-white);
    }

    .quiz-take-question-dot.current {
        background: var(--quiz-take-primary);
        color: var(--quiz-take-white);
        transform: scale(1.1);
        box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
    }

    .quiz-take-info-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .quiz-take-info-list li {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px solid var(--quiz-take-gray-light);
    }

    .quiz-take-info-list li:last-child {
        border-bottom: none;
    }

    .quiz-take-info-list li i {
        width: 24px;
        color: var(--quiz-take-primary);
        font-size: 1.1rem;
    }

    .quiz-take-info-list li span {
        flex: 1;
        color: var(--quiz-take-gray);
    }

    .quiz-take-info-list li strong {
        color: var(--quiz-take-dark);
        font-weight: 600;
    }

    /* Complete Card */
    .quiz-take-complete-card {
        background: var(--quiz-take-white);
        border-radius: var(--quiz-take-radius-lg);
        padding: 60px 40px;
        box-shadow: var(--quiz-take-shadow);
        text-align: center;
    }

    .quiz-take-complete-icon {
        font-size: 5rem;
        color: var(--quiz-take-success);
        margin-bottom: 25px;
        animation: quiz-take-bounce 1s ease;
    }

    @keyframes quiz-take-bounce {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.2); }
    }

    .quiz-take-complete-card h2 {
        font-size: 2.2rem !important;
        font-weight: 700 !important;
        color: var(--quiz-take-dark) !important;
        margin-bottom: 15px !important;
    }

    .quiz-take-complete-card p {
        color: var(--quiz-take-gray) !important;
        font-size: 1.1rem !important;
        margin-bottom: 30px !important;
    }

    /* Error Alert */
    .quiz-take-error-alert {
        background: rgba(239, 71, 111, 0.1);
        color: var(--quiz-take-danger);
        padding: 15px 20px;
        border-radius: var(--quiz-take-radius);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        border: 1px solid rgba(239, 71, 111, 0.2);
    }

    .quiz-take-error-alert i {
        font-size: 1.2rem;
    }

    .quiz-take-success-alert {
        background: rgba(6, 214, 160, 0.1);
        color: var(--quiz-take-success);
        padding: 15px 20px;
        border-radius: var(--quiz-take-radius);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        border: 1px solid rgba(6, 214, 160, 0.2);
    }

    /* Responsive */
    @media (max-width: 992px) {
        .quiz-take-question-footer {
            flex-direction: column;
            gap: 15px;
        }

        .quiz-take-btn {
            width: 100%;
            justify-content: center;
        }

        .quiz-take-image-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .quiz-take-header {
            text-align: center;
        }

        .quiz-take-timer {
            margin-top: 15px;
        }

        .quiz-take-question-text {
            font-size: 1.2rem !important;
        }

        .quiz-take-question-grid {
            grid-template-columns: repeat(4, 1fr);
        }

        .quiz-take-option-item .form-check-label {
            flex-direction: column;
            text-align: center;
        }

        .quiz-take-image-grid {
            grid-template-columns: 1fr;
        }

        .quiz-take-complete-card {
            padding: 40px 20px;
        }

        .quiz-take-language-selector {
            margin-left: 0;
            margin-top: 15px;
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="quiz-take-container">
    <div class="container">
        <!-- Translation Loading Indicator -->
        <div class="quiz-take-translation-loading" id="translationLoading">
            <i class="fas fa-spinner"></i>
            <span>Translating...</span>
        </div>

        <!-- Display any session messages -->
        @if(session('error'))
        <div class="quiz-take-error-alert">
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ session('error') }}</span>
        </div>
        @endif

        @if(session('success'))
        <div class="quiz-take-success-alert">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        <!-- Quiz Header -->
        <div class="quiz-take-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 id="quizTitle" data-original="{{ $quiz->title }}">{{ $quiz->title }}</h1>
                    <p class="text-muted">
                        <i class="fas fa-question-circle me-2"></i>
                        <span id="questionCountText" data-original="Question {{ $attempt->answers->count() + 1 }} of {{ $questions->count() }}">
                            Question {{ $attempt->answers->count() + 1 }} of {{ $questions->count() }}
                        </span>
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <!-- Language Selector -->
                    <div class="quiz-take-language-selector">
                        <button class="quiz-take-language-btn active" onclick="changeLanguage('en')" id="langEn">English</button>
                        <button class="quiz-take-language-btn" onclick="changeLanguage('es')" id="langEs">Español</button>
                        <button class="quiz-take-language-btn" onclick="changeLanguage('fr')" id="langFr">Français</button>
                    </div>
                    
                    @if($remainingTime)
                    <div class="quiz-take-timer {{ $remainingTime < 300 ? 'warning' : '' }}" id="timer" data-remaining="{{ $remainingTime }}">
                        <i class="far fa-clock"></i>
                        <span id="timerDisplay">{{ gmdate('H:i:s', $remainingTime) }}</span>
                    </div>
                    @endif
                    
                    <div class="quiz-take-progress">
                        <div class="quiz-take-progress-bar">
                            @php
                                $progress = ($attempt->answers->count() / $questions->count()) * 100;
                            @endphp
                            <div class="quiz-take-progress-fill" style="width: {{ $progress }}%;"></div>
                        </div>
                        <div class="quiz-take-progress-stats">
                            <span id="answeredCount" data-original="{{ $attempt->answers->count() }} answered">{{ $attempt->answers->count() }} answered</span>
                            <span id="remainingCount" data-original="{{ $questions->count() - $attempt->answers->count() }} remaining">{{ $questions->count() - $attempt->answers->count() }} remaining</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 mb-4 mb-lg-0">
                <!-- Current Question -->
                @php
                    $currentQuestion = $questions[$attempt->answers->count()] ?? null;
                @endphp

                @if($currentQuestion)
                <div class="quiz-take-question-card">
                    <form action="{{ route('quizzes.submit', ['quiz' => $quiz->id, 'attempt' => $attempt->id]) }}" method="POST" id="quizForm">
                        @csrf
                        
                        <div class="quiz-take-question-header">
                            <span class="quiz-take-question-badge" id="questionType" data-original="{{ str_replace('_', ' ', ucfirst($currentQuestion->question_type)) }}">
                                {{ str_replace('_', ' ', ucfirst($currentQuestion->question_type)) }}
                            </span>
                            <span class="quiz-take-question-points">
                                <i class="fas fa-star me-1"></i>
                                <span id="questionPoints" data-original="{{ $currentQuestion->points }} points">{{ $currentQuestion->points }} points</span>
                            </span>
                        </div>

                        <div class="quiz-take-question-content">
                            <h3 class="quiz-take-question-text" 
                                id="questionText" 
                                data-question-id="{{ $currentQuestion->id }}"
                                data-original="{{ $currentQuestion->question_text }}">
                                {{ $currentQuestion->question_text }}
                            </h3>

                            @if($currentQuestion->image)
                            <div class="quiz-take-question-image">
                                <img src="{{ $currentQuestion->image_url }}" alt="Question image">
                            </div>
                            @endif

                            <!-- Multiple Choice / Single Choice / True False Options -->
                            @if(in_array($currentQuestion->question_type, ['multiple_choice', 'single_choice', 'true_false']))
                                <div class="quiz-take-options-list" id="optionsList">
                                    @foreach($currentQuestion->options as $option)
                                    <div class="quiz-take-option-item" onclick="selectOption(this, '{{ $option->id }}')">
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
                                                    <div class="quiz-take-option-image">
                                                        <img src="{{ $option->image_url }}" alt="Option image">
                                                    </div>
                                                @endif
                                                <span class="quiz-take-option-text option-text" 
                                                      data-option-id="{{ $option->id }}"
                                                      data-original="{{ $option->option_text }}">
                                                    {{ $option->option_text }}
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Fill in the Blank -->
                            @if($currentQuestion->question_type == 'fill_blank')
                                <div class="quiz-take-fill-blank">
                                    <div class="form-group">
                                        <input type="text" 
                                               class="form-control form-control-lg" 
                                               name="answers[{{ $currentQuestion->id }}]" 
                                               id="fill_blank_answer"
                                               placeholder="Type your answer here..."
                                               value="{{ old('answers.'.$currentQuestion->id) }}"
                                               required>
                                    </div>
                                    @if($currentQuestion->fillBlanks->count() > 1)
                                        <small id="fillBlankHint" data-original="Any of the correct answers will be accepted.">
                                            <i class="fas fa-info-circle"></i>
                                            Any of the correct answers will be accepted.
                                        </small>
                                    @endif
                                </div>
                            @endif

                            <!-- Matching -->
                            @if($currentQuestion->question_type == 'matching')
                                <div class="quiz-take-matching">
                                    <div class="quiz-take-matching-instruction" id="matchingInstruction" data-original="Match the items from the left column with the right column">
                                        <i class="fas fa-arrows-alt-h"></i>
                                        Match the items from the left column with the right column
                                    </div>
                                    
                                    @foreach($currentQuestion->matchingPairs as $pair)
                                    <div class="quiz-take-matching-row">
                                        <div class="row align-items-center">
                                            <div class="col-md-5">
                                                <div class="quiz-take-matching-left matching-left-item" 
                                                     data-pair-id="{{ $pair->id }}"
                                                     data-original="{{ $pair->left_item }}">
                                                    {{ $pair->left_item }}
                                                </div>
                                            </div>
                                            <div class="col-md-2 quiz-take-matching-arrow">
                                                <i class="fas fa-arrow-right"></i>
                                            </div>
                                            <div class="col-md-5">
                                                <select class="quiz-take-matching-select matching-select" 
                                                        name="answers[{{ $currentQuestion->id }}][pair_{{ $pair->id }}]" 
                                                        required>
                                                    <option value="" data-original="Select match">Select match</option>
                                                    @foreach($currentQuestion->matchingPairs->shuffle() as $rightItem)
                                                        <option value="{{ $rightItem->right_item }}" 
                                                                data-original="{{ $rightItem->right_item }}"
                                                                class="matching-option">
                                                            {{ $rightItem->right_item }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Image Selection -->
                            @if($currentQuestion->question_type == 'image_selection')
                                <div class="quiz-take-image-selection">
                                    <div class="quiz-take-image-grid">
                                        @foreach($currentQuestion->options as $option)
                                        <div class="quiz-take-image-option" onclick="toggleImageSelection(this, '{{ $option->id }}')">
                                            <input type="{{ $currentQuestion->question_type == 'multiple_choice' ? 'checkbox' : 'radio' }}" 
                                                   name="answers[{{ $currentQuestion->id }}]{{ $currentQuestion->question_type == 'multiple_choice' ? '[]' : '' }}" 
                                                   value="{{ $option->id }}"
                                                   id="image_option_{{ $option->id }}"
                                                   style="display: none;">
                                            @if($option->image)
                                                <img src="{{ $option->image_url }}" alt="{{ $option->option_text }}">
                                                <p class="image-option-text" 
                                                   data-option-id="{{ $option->id }}"
                                                   data-original="{{ $option->option_text }}">
                                                    {{ $option->option_text }}
                                                </p>
                                            @endif
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="quiz-take-question-footer">
                            <button type="submit" name="action" value="next" class="quiz-take-btn primary" id="nextBtn">
                                @if($attempt->answers->count() + 1 == $questions->count())
                                    <span id="submitText" data-original="Submit Quiz">Submit Quiz</span>
                                    <i class="fas fa-check-circle"></i>
                                @else
                                    <span id="nextText" data-original="Next Question">Next Question</span>
                                    <i class="fas fa-arrow-right"></i>
                                @endif
                            </button>
                            
                            @if($attempt->answers->count() > 0)
                            <button type="submit" name="action" value="previous" class="quiz-take-btn secondary" id="previousBtn">
                                <i class="fas fa-arrow-left"></i>
                                <span id="previousText" data-original="Previous">Previous</span>
                            </button>
                            @endif
                        </div>
                    </form>
                </div>
                @else
                    <!-- Quiz Complete -->
                    <div class="quiz-take-complete-card">
                        <i class="fas fa-check-circle quiz-take-complete-icon"></i>
                        <h2 id="completeTitle" data-original="Quiz Completed!">Quiz Completed!</h2>
                        <p id="completeMessage" data-original="You have answered all questions. Click below to submit your quiz.">You have answered all questions. Click below to submit your quiz.</p>
                        <form action="{{ route('quizzes.submit', ['quiz' => $quiz->id, 'attempt' => $attempt->id]) }}" method="POST">
                            @csrf
                            <input type="hidden" name="action" value="complete">
                            <button type="submit" class="quiz-take-btn success" style="padding: 15px 40px; font-size: 1.2rem;" id="submitQuizBtn">
                                <i class="fas fa-check-circle me-2"></i>
                                <span data-original="Submit Quiz">Submit Quiz</span>
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            <div class="col-lg-4">
                <!-- Question Navigator -->
                <div class="quiz-take-navigator-card">
                    <h5 class="quiz-take-navigator-title">
                        <i class="fas fa-th"></i>
                        <span id="navigatorTitle" data-original="Question Navigator">Question Navigator</span>
                    </h5>
                    <div class="quiz-take-question-grid">
                        @foreach($questions as $index => $question)
                            @php
                                $isAnswered = $attempt->answers->contains('question_id', $question->id);
                                $isCurrent = $index == $attempt->answers->count();
                            @endphp
                            <div class="quiz-take-question-dot {{ $isAnswered ? 'answered' : '' }} {{ $isCurrent ? 'current' : '' }}">
                                {{ $index + 1 }}
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Quiz Info -->
                <div class="quiz-take-info-card">
                    <h5 class="quiz-take-navigator-title">
                        <i class="fas fa-info-circle"></i>
                        <span id="infoTitle" data-original="Quiz Information">Quiz Information</span>
                    </h5>
                    <ul class="quiz-take-info-list">
                        <li>
                            <i class="fas fa-clock"></i>
                            <span id="timeRemainingLabel" data-original="Time Remaining:">Time Remaining:</span>
                            <strong id="timeRemainingValue">{{ $remainingTime ? gmdate('H:i:s', $remainingTime) : 'No limit' }}</strong>
                        </li>
                        <li>
                            <i class="fas fa-question-circle"></i>
                            <span id="questionsAnsweredLabel" data-original="Questions Answered:">Questions Answered:</span>
                            <strong id="questionsAnsweredValue">{{ $attempt->answers->count() }}/{{ $questions->count() }}</strong>
                        </li>
                        <li>
                            <i class="fas fa-star"></i>
                            <span id="totalPointsLabel" data-original="Total Points:">Total Points:</span>
                            <strong id="totalPointsValue">{{ $questions->sum('points') }}</strong>
                        </li>
                        @if($quiz->pass_percentage)
                        <li>
                            <i class="fas fa-trophy"></i>
                            <span id="passingScoreLabel" data-original="Passing Score:">Passing Score:</span>
                            <strong id="passingScoreValue">{{ $quiz->pass_percentage }}%</strong>
                        </li>
                        @endif
                        <li>
                            <i class="fas fa-redo"></i>
                            <span id="attemptLabel" data-original="Attempt:">Attempt:</span>
                            <strong id="attemptValue">#{{ $attempt->attempt_number }}</strong>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Auto-submit when timer expires -->
@if($remainingTime)
<form id="timeoutForm" action="{{ route('quizzes.submit', ['quiz' => $quiz->id, 'attempt' => $attempt->id]) }}" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="action" value="timeout">
</form>
@endif

<!-- Add CSRF token meta tag for AJAX if needed -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
// Translation API endpoint (proxy through Laravel)
const TRANSLATE_API_URL = "{{ route('translate') }}";

// Current language (default: English)
let currentLanguage = 'en';

// Cache for translations
const translationCache = new Map();

// Store original texts for all translatable elements
const translatableElements = [];

document.addEventListener('DOMContentLoaded', function() {
    // Initialize translatable elements
    initializeTranslatableElements();
    
    // Timer functionality
    @if($remainingTime)
    let remainingSeconds = {{ $remainingTime }};
    const timerDisplay = document.getElementById('timerDisplay');
    const timer = document.getElementById('timer');
    const timeoutForm = document.getElementById('timeoutForm');
    
    const timerInterval = setInterval(function() {
        remainingSeconds--;
        
        if (remainingSeconds <= 0) {
            clearInterval(timerInterval);
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
            
            // Add warning class when less than 5 minutes
            if (remainingSeconds < 300 && !timer.classList.contains('warning')) {
                timer.classList.add('warning');
            }
        }
    }, 1000);
    @endif

    // Select option function
    window.selectOption = function(element, optionId) {
        const checkbox = element.querySelector('input[type="checkbox"], input[type="radio"]');
        if (checkbox) {
            if (checkbox.type === 'radio') {
                // Remove selected class from other radio options
                const name = checkbox.name;
                document.querySelectorAll(`input[name="${name}"]`).forEach(input => {
                    input.closest('.quiz-take-option-item')?.classList.remove('selected');
                });
            }
            
            checkbox.checked = !checkbox.checked;
            element.classList.toggle('selected', checkbox.checked);
        }
    };

    // Image selection toggle
    window.toggleImageSelection = function(element, optionId) {
        const input = element.querySelector('input');
        if (input) {
            if (input.type === 'radio') {
                // Remove selected class from other image options
                const name = input.name;
                document.querySelectorAll(`input[name="${name}"]`).forEach(inp => {
                    inp.closest('.quiz-take-image-option')?.classList.remove('selected');
                });
            }
            
            input.checked = !input.checked;
            element.classList.toggle('selected', input.checked);
        }
    };

    // Form submission warning
    const quizForm = document.getElementById('quizForm');
    if (quizForm) {
        quizForm.addEventListener('submit', function(e) {
            const action = e.submitter?.value;
            
            // Check if any answer is selected for required questions
            const currentQuestionType = '{{ $currentQuestion->question_type ?? '' }}';
            const isMultipleChoice = currentQuestionType === 'multiple_choice';
            const isSingleChoice = ['single_choice', 'true_false'].includes(currentQuestionType);
            
            if ((isSingleChoice || isMultipleChoice) && !hasSelectedAnswer()) {
                e.preventDefault();
                alert('Please select an answer before proceeding.');
                return false;
            }
            
            if (action === 'complete' || (action === 'next' && {{ $attempt->answers->count() + 1 }} == {{ $questions->count() }})) {
                if (!confirm('Are you sure you want to submit your quiz? You cannot change your answers after submission.')) {
                    e.preventDefault();
                    return false;
                }
            }
            
            // Show loading state on button
            const submitBtn = e.submitter;
            if (submitBtn) {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Saving...';
                submitBtn.disabled = true;
            }
        });
    }

    // Helper function to check if any answer is selected
    function hasSelectedAnswer() {
        const inputs = document.querySelectorAll('input[type="radio"]:checked, input[type="checkbox"]:checked');
        return inputs.length > 0;
    }

    // Question dot navigation (visual only)
    document.querySelectorAll('.quiz-take-question-dot').forEach((dot, index) => {
        dot.addEventListener('click', function() {
            // Visual feedback only - actual navigation would require AJAX
            this.style.transform = 'scale(1.2)';
            setTimeout(() => {
                this.style.transform = '';
            }, 200);
        });
    });

    // Auto-save functionality (optional)
    let autoSaveTimer;
    const autoSave = function() {
        // Implement auto-save if needed
        console.log('Auto-saving answers...');
    };

    // Save on option change
    document.querySelectorAll('input[type="radio"], input[type="checkbox"]').forEach(input => {
        input.addEventListener('change', function() {
            clearTimeout(autoSaveTimer);
            autoSaveTimer = setTimeout(autoSave, 5000);
        });
    });

    // Prevent double form submission
    let formSubmitted = false;
    quizForm?.addEventListener('submit', function() {
        if (formSubmitted) {
            e.preventDefault();
            return false;
        }
        formSubmitted = true;
    });
});

// Initialize all translatable elements
function initializeTranslatableElements() {
    // Clear the array
    translatableElements.length = 0;
    
    // Helper function to add element
    function addElement(id) {
        const el = document.getElementById(id);
        if (el && el.dataset.original) {
            translatableElements.push({
                element: el,
                original: el.dataset.original
            });
        }
    }
    
    // Add all elements with data-original attributes
    addElement('quizTitle');
    addElement('questionCountText');
    addElement('questionText');
    addElement('questionType');
    addElement('questionPoints');
    addElement('fillBlankHint');
    addElement('matchingInstruction');
    addElement('navigatorTitle');
    addElement('infoTitle');
    addElement('timeRemainingLabel');
    addElement('questionsAnsweredLabel');
    addElement('totalPointsLabel');
    addElement('passingScoreLabel');
    addElement('attemptLabel');
    addElement('answeredCount');
    addElement('remainingCount');
    addElement('completeTitle');
    addElement('completeMessage');
    addElement('nextText');
    addElement('previousText');
    addElement('submitText');
    
    // Add option texts
    document.querySelectorAll('.option-text').forEach(el => {
        if (el.dataset.original) {
            translatableElements.push({
                element: el,
                original: el.dataset.original
            });
        }
    });
    
    // Add matching left items
    document.querySelectorAll('.matching-left-item').forEach(el => {
        if (el.dataset.original) {
            translatableElements.push({
                element: el,
                original: el.dataset.original
            });
        }
    });
    
    // Add matching options
    document.querySelectorAll('.matching-option').forEach(el => {
        if (el.dataset.original) {
            translatableElements.push({
                element: el,
                original: el.dataset.original
            });
        }
    });
    
    // Add image option texts
    document.querySelectorAll('.image-option-text').forEach(el => {
        if (el.dataset.original) {
            translatableElements.push({
                element: el,
                original: el.dataset.original
            });
        }
    });
    
    // Add submit button span
    const submitBtnSpan = document.querySelector('#submitQuizBtn span');
    if (submitBtnSpan && submitBtnSpan.dataset.original) {
        translatableElements.push({
            element: submitBtnSpan,
            original: submitBtnSpan.dataset.original
        });
    }
}

// Change language function
async function changeLanguage(lang) {
    if (lang === currentLanguage) return;
    
    console.log('Changing language from', currentLanguage, 'to', lang);
    
    // Get loading indicator
    const loadingEl = document.getElementById('translationLoading');
    if (loadingEl) {
        loadingEl.classList.add('show');
    }
    
    try {
        // Update active button state
        document.querySelectorAll('.quiz-take-language-btn').forEach(btn => btn.classList.remove('active'));
        const activeBtn = document.getElementById(`lang${lang.toUpperCase()}`);
        if (activeBtn) {
            activeBtn.classList.add('active');
        }
        
        console.log('Elements to translate:', translatableElements.length);
        
        // Translate all elements
        for (const item of translatableElements) {
            if (item.element) {
                try {
                    console.log('Translating:', item.original);
                    const translated = await translateText(item.original, currentLanguage, lang);
                    console.log('Translated to:', translated);
                    
                    // Simple approach: just update the text content of the element
                    // This will work for elements that don't have complex HTML inside
                    if (item.element.tagName === 'SPAN' || 
                        item.element.tagName === 'H1' || 
                        item.element.tagName === 'H2' || 
                        item.element.tagName === 'H3' || 
                        item.element.tagName === 'P' || 
                        item.element.tagName === 'SMALL' ||
                        item.element.tagName === 'OPTION') {
                        item.element.textContent = translated;
                    }
                } catch (error) {
                    console.error('Translation error for element:', error);
                }
            }
        }
        
        // Update current language
        currentLanguage = lang;
        console.log('Language changed to', lang);
        
    } catch (error) {
        console.error('Translation error:', error);
        alert('Translation failed. Please try again.');
    } finally {
        // Hide loading indicator
        if (loadingEl) {
            loadingEl.classList.remove('show');
        }
    }
}

// Translate text using the Laravel proxy
async function translateText(text, sourceLang, targetLang) {
    // Check cache first
    const cacheKey = `${text}_${sourceLang}_${targetLang}`;
    if (translationCache.has(cacheKey)) {
        console.log('Using cached translation for:', text);
        return translationCache.get(cacheKey);
    }
    
    // Don't translate if source and target are the same
    if (sourceLang === targetLang) return text;
    
    // Don't translate empty or very short texts
    if (!text || text.trim().length < 2) return text;
    
    try {
        console.log('Fetching translation from API:', {text, sourceLang, targetLang});
        
        const response = await fetch(TRANSLATE_API_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                q: text,
                source: sourceLang,
                target: targetLang
            })
        });
        
        if (!response.ok) {
            throw new Error(`Translation failed with status: ${response.status}`);
        }
        
        const data = await response.json();
        console.log('API response:', data);
        
        const translatedText = data.translatedText || text;
        
        // Cache the result
        translationCache.set(cacheKey, translatedText);
        
        return translatedText;
    } catch (error) {
        console.error('Translation error:', error);
        return text; // Return original text on error
    }
}

// Function to update translations when navigating to next/previous question
function updateQuestionTranslations() {
    console.log('Updating question translations');
    // Re-initialize translatable elements
    initializeTranslatableElements();
    
    // Translate to current language if not English
    if (currentLanguage !== 'en') {
        changeLanguage(currentLanguage);
    }
}

// Call this after loading new question via AJAX
window.updateQuestionTranslations = updateQuestionTranslations;
</script>

@endsection