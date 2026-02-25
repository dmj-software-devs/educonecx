@extends('layouts.main')

@section('title', 'Quiz Results - ' . $quiz->title . ' - EDUCONECX')

@section('meta_description', 'View your quiz results and performance.')

@push('styles')
<style>
    /* Quiz Results Page Styles - Scoped with rs- prefix to prevent conflicts */
    .rs-results-section {
        background: linear-gradient(135deg, #f5f7ff 0%, #f0f3ff 100%);
        min-height: 100vh;
        padding: 40px 0;
        font-family: 'Inter', sans-serif;
    }

    /* Alerts */
    .rs-alert {
        padding: 16px 20px;
        border-radius: 16px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 0.95rem;
        animation: rs-slideDown 0.3s ease;
        border: 1px solid transparent;
    }

    .rs-alert-success {
        background: rgba(6, 214, 160, 0.08);
        color: #0b8e6d;
        border-color: rgba(6, 214, 160, 0.2);
    }

    .rs-alert-info {
        background: rgba(67, 97, 238, 0.08);
        color: #4361ee;
        border-color: rgba(67, 97, 238, 0.2);
    }

    .rs-alert-warning {
        background: rgba(247, 37, 133, 0.08);
        color: #b5179e;
        border-color: rgba(247, 37, 133, 0.2);
    }

    .rs-alert i {
        font-size: 1.2rem;
    }

    /* Main Results Card */
    .rs-card {
        background: #ffffff;
        border-radius: 32px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        padding: 40px;
        margin-bottom: 24px;
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .rs-card:hover {
        box-shadow: 0 30px 60px rgba(67, 97, 238, 0.12);
    }

    /* Header */
    .rs-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .rs-icon {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px;
        font-size: 3rem;
        animation: rs-pop 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .rs-icon-passed {
        background: rgba(6, 214, 160, 0.15);
        color: #06d6a0;
    }

    .rs-icon-failed {
        background: rgba(239, 71, 111, 0.15);
        color: #ef476f;
    }

    @keyframes rs-pop {
        0% { transform: scale(0); }
        70% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }

    .rs-title {
        font-size: 2.2rem;
        font-weight: 700;
        color: #1e1e2f;
        margin-bottom: 8px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .rs-subtitle {
        color: #6c757d;
        font-size: 1.1rem;
        font-weight: 400;
    }

    /* Score Section - FIXED */
    .rs-score-container {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 50px;
        margin-bottom: 50px;
        flex-wrap: wrap;
    }

    .rs-score-circle {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: white;
        box-shadow: 0 15px 35px rgba(102, 126, 234, 0.3);
        position: relative;
        animation: rs-float 3s ease-in-out infinite;
        padding: 0 15px; /* Added padding to prevent text overflow */
        text-align: center;
    }

    .rs-score-circle::before {
        content: '';
        position: absolute;
        top: 8px;
        left: 8px;
        right: 8px;
        bottom: 8px;
        border-radius: 50%;
        border: 2px solid rgba(255, 255, 255, 0.3);
        animation: rs-pulse 2s ease-in-out infinite;
        pointer-events: none;
    }

    @keyframes rs-float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    @keyframes rs-pulse {
        0%, 100% { transform: scale(1); opacity: 0.5; }
        50% { transform: scale(1.05); opacity: 0.8; }
    }

    .rs-score-percentage {
        font-size: 3.2rem; /* Slightly reduced */
        font-weight: 700;
        line-height: 1.1;
        margin-bottom: 5px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        max-width: 100%;
        word-break: break-word;
        display: block;
        width: 100%;
    }

    .rs-score-label {
        font-size: 0.95rem;
        opacity: 0.9;
        letter-spacing: 1px;
        text-transform: uppercase;
        display: block;
        width: 100%;
    }

    .rs-score-details {
        text-align: left;
        flex: 1;
        min-width: 200px;
    }

    .rs-score-points {
        font-size: 2rem;
        font-weight: 700;
        color: #1e1e2f;
        margin-bottom: 8px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .rs-score-passing {
        color: #6c757d;
        font-size: 1rem;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .rs-score-passing i {
        color: #4361ee;
        font-size: 1rem;
    }

    .rs-score-status {
        display: inline-block;
        padding: 10px 30px;
        border-radius: 9999px;
        font-weight: 600;
        font-size: 1.1rem;
        letter-spacing: 1px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .rs-score-status-passed {
        background: rgba(6, 214, 160, 0.15);
        color: #06d6a0;
        border: 1px solid rgba(6, 214, 160, 0.3);
    }

    .rs-score-status-failed {
        background: rgba(239, 71, 111, 0.15);
        color: #ef476f;
        border: 1px solid rgba(239, 71, 111, 0.3);
    }

    /* Stats Grid */
    .rs-stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 50px;
    }

    .rs-stat-item {
        background: #f8f9fa;
        border-radius: 20px;
        padding: 25px 15px;
        text-align: center;
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.03);
    }

    .rs-stat-item:hover {
        transform: translateY(-5px);
        background: #ffffff;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        border-color: transparent;
    }

    .rs-stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: #4361ee;
        margin-bottom: 8px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .rs-stat-label {
        color: #6c757d;
        font-size: 0.9rem;
        font-weight: 500;
    }

    /* Questions Section */
    .rs-questions-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e1e2f;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .rs-questions-title i {
        color: #4361ee;
        font-size: 1.3rem;
    }

    .rs-question-item {
        background: #f8f9fa;
        border-radius: 20px;
        padding: 25px;
        margin-bottom: 20px;
        border-left: 4px solid transparent;
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.03);
    }

    .rs-question-item:hover {
        transform: translateX(5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        background: #ffffff;
    }

    .rs-question-correct {
        border-left-color: #06d6a0;
    }

    .rs-question-incorrect {
        border-left-color: #ef476f;
    }

    .rs-question-partial {
        border-left-color: #ffd166;
    }

    .rs-question-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .rs-question-meta {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .rs-question-number {
        background: #ffffff;
        padding: 4px 12px;
        border-radius: 9999px;
        font-size: 0.8rem;
        font-weight: 600;
        color: #4361ee;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .rs-question-type {
        background: #ffffff;
        padding: 4px 12px;
        border-radius: 9999px;
        font-size: 0.8rem;
        color: #6c757d;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .rs-question-points {
        padding: 4px 15px;
        border-radius: 9999px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .rs-points-correct {
        background: rgba(6, 214, 160, 0.15);
        color: #06d6a0;
    }

    .rs-points-incorrect {
        background: rgba(239, 71, 111, 0.15);
        color: #ef476f;
    }

    .rs-points-partial {
        background: rgba(255, 209, 102, 0.15);
        color: #b85e00;
    }

    .rs-question-text {
        font-size: 1.1rem;
        font-weight: 500;
        color: #1e1e2f;
        margin-bottom: 20px;
        line-height: 1.5;
    }

    .rs-answer-box {
        background: #ffffff;
        border-radius: 16px;
        padding: 15px;
        margin-bottom: 10px;
        border: 1px solid rgba(0, 0, 0, 0.03);
    }

    .rs-answer-label {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.9rem;
        color: #6c757d;
        margin-bottom: 8px;
    }

    .rs-answer-label i {
        color: #4361ee;
        font-size: 0.9rem;
    }

    .rs-answer-value {
        padding: 12px 15px;
        background: #f8f9fa;
        border-radius: 12px;
        color: #1e1e2f;
        font-size: 0.95rem;
        border: 1px solid rgba(0, 0, 0, 0.03);
    }

    .rs-correct-answer {
        padding: 12px 15px;
        background: rgba(6, 214, 160, 0.05);
        border-radius: 12px;
        color: #06d6a0;
        font-weight: 500;
        border: 1px solid rgba(6, 214, 160, 0.2);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .rs-correct-answer i {
        color: #06d6a0;
        font-size: 1rem;
    }

    /* Action Buttons */
    .rs-actions {
        display: flex;
        gap: 15px;
        justify-content: center;
        margin-top: 40px;
        flex-wrap: wrap;
    }

    .rs-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 14px 32px;
        border-radius: 9999px;
        font-size: 0.95rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        min-width: 160px;
        position: relative;
        overflow: hidden;
    }

    .rs-btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .rs-btn:hover::before {
        width: 300px;
        height: 300px;
    }

    .rs-btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
    }

    .rs-btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
    }

    .rs-btn-secondary {
        background: #f8f9fa;
        color: #6c757d;
        border: 1px solid #e9ecef;
    }

    .rs-btn-secondary:hover {
        background: #ffffff;
        color: #4361ee;
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
    }

    /* Share Card */
    .rs-share-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 32px;
        padding: 40px;
        text-align: center;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .rs-share-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: rs-float 6s ease-in-out infinite;
    }

    .rs-share-card::after {
        content: '';
        position: absolute;
        bottom: -50%;
        left: -10%;
        width: 250px;
        height: 250px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: rs-float 8s ease-in-out infinite reverse;
    }

    .rs-share-content {
        position: relative;
        z-index: 2;
    }

    .rs-share-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 10px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .rs-share-text {
        opacity: 0.9;
        margin-bottom: 25px;
        font-size: 1rem;
    }

    .rs-share-buttons {
        display: flex;
        gap: 15px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .rs-share-btn {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: 1.2rem;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .rs-share-btn:hover {
        transform: translateY(-5px) scale(1.1);
        background: rgba(255, 255, 255, 0.25);
    }

    /* Loading States */
    .rs-loading {
        text-align: center;
        padding: 50px;
    }

    .rs-spinner {
        width: 50px;
        height: 50px;
        border: 3px solid #f0f3ff;
        border-top-color: #4361ee;
        border-radius: 50%;
        animation: rs-spin 1s linear infinite;
        margin: 0 auto 15px;
    }

    @keyframes rs-spin {
        to { transform: rotate(360deg); }
    }

    /* Responsive Design - Updated for better mobile handling */
    @media (max-width: 992px) {
        .rs-card {
            padding: 30px;
        }

        .rs-stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }
        
        .rs-score-percentage {
            font-size: 3rem;
        }
    }

    @media (max-width: 768px) {
        .rs-results-section {
            padding: 30px 0;
        }

        .rs-card {
            padding: 25px;
            border-radius: 24px;
        }

        .rs-title {
            font-size: 1.8rem;
        }

        .rs-subtitle {
            font-size: 1rem;
        }

        .rs-score-container {
            flex-direction: column;
            gap: 30px;
            text-align: center;
        }

        .rs-score-details {
            text-align: center;
        }

        .rs-score-passing {
            justify-content: center;
        }

        .rs-score-circle {
            width: 180px;
            height: 180px;
        }

        .rs-score-percentage {
            font-size: 2.8rem;
        }

        .rs-score-label {
            font-size: 0.9rem;
        }

        .rs-stats-grid {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .rs-stat-item {
            padding: 20px;
        }

        .rs-actions {
            flex-direction: column;
            gap: 12px;
        }

        .rs-btn {
            width: 100%;
            min-width: auto;
        }

        .rs-question-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .rs-question-meta {
            width: 100%;
        }

        .rs-share-card {
            padding: 30px 20px;
        }

        .rs-share-buttons {
            gap: 10px;
        }

        .rs-share-btn {
            width: 45px;
            height: 45px;
            font-size: 1rem;
        }
    }

    @media (max-width: 576px) {
        .rs-results-section {
            padding: 20px 0;
        }

        .rs-card {
            padding: 20px;
            border-radius: 20px;
        }

        .rs-icon {
            width: 70px;
            height: 70px;
            font-size: 2.2rem;
        }

        .rs-title {
            font-size: 1.4rem;
        }

        .rs-subtitle {
            font-size: 0.9rem;
        }

        .rs-score-container {
            margin-bottom: 30px;
        }

        .rs-score-circle {
            width: 150px;
            height: 150px;
        }

        .rs-score-percentage {
            font-size: 2.4rem;
        }

        .rs-score-label {
            font-size: 0.8rem;
        }

        .rs-score-points {
            font-size: 1.5rem;
        }

        .rs-score-status {
            padding: 8px 20px;
            font-size: 0.95rem;
        }

        .rs-stat-value {
            font-size: 1.5rem;
        }

        .rs-stat-label {
            font-size: 0.85rem;
        }

        .rs-questions-title {
            font-size: 1.2rem;
        }

        .rs-question-item {
            padding: 18px;
        }

        .rs-question-text {
            font-size: 0.95rem;
        }

        .rs-question-meta {
            gap: 8px;
        }

        .rs-question-number,
        .rs-question-type {
            font-size: 0.75rem;
            padding: 3px 10px;
        }

        .rs-question-points {
            font-size: 0.75rem;
            padding: 3px 12px;
        }

        .rs-answer-value,
        .rs-correct-answer {
            font-size: 0.85rem;
            padding: 10px 12px;
        }

        .rs-share-title {
            font-size: 1.2rem;
        }

        .rs-share-text {
            font-size: 0.85rem;
            margin-bottom: 20px;
        }

        .rs-share-btn {
            width: 40px;
            height: 40px;
            font-size: 0.95rem;
        }
    }

    /* Print Styles */
    @media print {
        .rs-results-section {
            background: white;
            padding: 20px;
        }

        .rs-card {
            box-shadow: none;
            border: 1px solid #ddd;
        }

        .rs-actions,
        .rs-share-card {
            display: none;
        }
    }
</style>
@endpush

@section('content')
<div class="rs-results-section">
    <div class="container">
        <!-- Alert Messages -->
        @if(session('success'))
        <div class="rs-alert rs-alert-success">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        @if(session('info'))
        <div class="rs-alert rs-alert-info">
            <i class="fas fa-info-circle"></i>
            <span>{{ session('info') }}</span>
        </div>
        @endif

        @if(session('error'))
        <div class="rs-alert rs-alert-warning">
            <i class="fas fa-exclamation-triangle"></i>
            <span>{{ session('error') }}</span>
        </div>
        @endif

        <!-- Main Results Card -->
        <div class="rs-card">
            <!-- Header with Status -->
            <div class="rs-header">
                <div class="rs-icon {{ $passed ? 'rs-icon-passed' : 'rs-icon-failed' }}">
                    <i class="fas {{ $passed ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                </div>
                <h1 class="rs-title">Quiz Completed!</h1>
                <p class="rs-subtitle">{{ $quiz->title }}</p>
            </div>

            <!-- Score Section -->
            <div class="rs-score-container">
                <div class="rs-score-circle">
                    <span class="rs-score-percentage">{{ $percentage }}%</span>
                    <span class="rs-score-label">Score</span>
                </div>
                <div class="rs-score-details">
                    <div class="rs-score-points">{{ $earnedPoints }}/{{ $totalPoints }}</div>
                    <div class="rs-score-passing">
                        <i class="fas fa-flag-checkered"></i>
                        Passing Score: {{ $quiz->pass_percentage }}%
                    </div>
                    <div class="rs-score-status {{ $passed ? 'rs-score-status-passed' : 'rs-score-status-failed' }}">
                        {{ $passed ? 'PASSED' : 'FAILED' }}
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="rs-stats-grid">
                <div class="rs-stat-item">
                    <div class="rs-stat-value">{{ $attempt->answers->count() }}</div>
                    <div class="rs-stat-label">Questions Answered</div>
                </div>
                <div class="rs-stat-item">
                    <div class="rs-stat-value">{{ $quiz->questions->count() }}</div>
                    <div class="rs-stat-label">Total Questions</div>
                </div>
                <div class="rs-stat-item">
                    <div class="rs-stat-value">#{{ $attempt->attempt_number }}</div>
                    <div class="rs-stat-label">Attempt Number</div>
                </div>
                <div class="rs-stat-item">
                    <div class="rs-stat-value">{{ $attempt->completed_at ? $attempt->completed_at->format('M d, Y') : 'N/A' }}</div>
                    <div class="rs-stat-label">Completed On</div>
                </div>
            </div>

            <!-- Questions Review -->
            @if($quiz->show_answers)
            <div class="rs-questions-review">
                <h2 class="rs-questions-title">
                    <i class="fas fa-clipboard-list"></i>
                    Question Review
                </h2>

                @foreach($quiz->questions as $index => $question)
                @php
                $answer = $answers[$question->id] ?? null;
                $isCorrect = $answer ? $answer->is_correct : false;
                $pointsEarned = $answer ? $answer->points_earned : 0;
                $statusClass = $isCorrect ? 'rs-question-correct' : ($pointsEarned > 0 ? 'rs-question-partial' : 'rs-question-incorrect');
                $pointsClass = $isCorrect ? 'rs-points-correct' : ($pointsEarned > 0 ? 'rs-points-partial' : 'rs-points-incorrect');
                @endphp
                <div class="rs-question-item {{ $statusClass }}">
                    <div class="rs-question-header">
                        <div class="rs-question-meta">
                            <span class="rs-question-number">Q{{ $index + 1 }}</span>
                            <span class="rs-question-type">{{ str_replace('_', ' ', ucfirst($question->question_type)) }}</span>
                        </div>
                        <span class="rs-question-points {{ $pointsClass }}">
                            {{ $pointsEarned }}/{{ $question->points }} points
                        </span>
                    </div>

                    <div class="rs-question-text">{{ $question->question_text }}</div>

                    @if($question->image)
                    <div style="margin-bottom: 15px;">
                        <img src="{{ $question->image_url }}" alt="Question image" style="max-width: 100%; max-height: 200px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                    </div>
                    @endif

                    @if($answer && $answer->answer_data)
                    <div class="rs-answer-box">
                        <div class="rs-answer-label">
                            <i class="fas fa-user"></i>
                            Your Answer:
                        </div>
                        <div class="rs-answer-value">
                            @php
                            $answerData = json_decode($answer->answer_data, true);
                            @endphp
                            @if(is_array($answerData))
                                @foreach($answerData as $key => $value)
                                    @if(is_numeric($key) && strpos($key, 'pair_') === false)
                                        @php
                                        $option = $question->options->where('id', $value)->first();
                                        @endphp
                                        {{ $option ? $option->option_text : $value }}
                                    @elseif(strpos($key, 'pair_') === 0)
                                        {{ $value }}
                                    @else
                                        {{ $value }}
                                    @endif
                                    @if(!$loop->last), @endif
                                @endforeach
                            @else
                                {{ $answerData }}
                            @endif
                        </div>
                    </div>
                    @endif

                    @if($quiz->show_answers && !$isCorrect)
                        @if(in_array($question->question_type, ['multiple_choice', 'single_choice', 'true_false']))
                            @php
                            $correctOptions = $question->options->where('is_correct', true);
                            @endphp
                            @if($correctOptions->count() > 0)
                            <div class="rs-answer-box">
                                <div class="rs-answer-label">
                                    <i class="fas fa-check-circle" style="color: #06d6a0;"></i>
                                    Correct Answer:
                                </div>
                                <div class="rs-correct-answer">
                                    <i class="fas fa-check-circle"></i>
                                    @foreach($correctOptions as $option)
                                        {{ $option->option_text }}@if(!$loop->last), @endif
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        @elseif($question->question_type == 'fill_blank' && $question->fillBlanks->count() > 0)
                            <div class="rs-answer-box">
                                <div class="rs-answer-label">
                                    <i class="fas fa-check-circle" style="color: #06d6a0;"></i>
                                    Correct Answer:
                                </div>
                                <div class="rs-correct-answer">
                                    <i class="fas fa-check-circle"></i>
                                    @foreach($question->fillBlanks as $blank)
                                        {{ $blank->answer }}@if(!$loop->last) or @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
                @endforeach
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="rs-actions">
                @if($quiz->can_attempt)
                <form method="POST" action="{{ route('quizzes.start', $quiz->id) }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="rs-btn rs-btn-primary">
                        <i class="fas fa-redo-alt"></i>
                        Try Again
                    </button>
                </form>
                @endif

                <a href="{{ route('quiz') }}" class="rs-btn rs-btn-secondary">
                    <i class="fas fa-th-large"></i>
                    More Quizzes
                </a>

                @if(Auth::user())
                <a href="{{ route('dashboard') }}" class="rs-btn rs-btn-secondary">
                    <i class="fas fa-chart-pie"></i>
                    Dashboard
                </a>
                @endif

                <button onclick="window.print()" class="rs-btn rs-btn-secondary">
                    <i class="fas fa-print"></i>
                    Print
                </button>
            </div>
        </div>

        <!-- Share Results Card -->
        <div class="rs-share-card">
            <div class="rs-share-content">
                <h3 class="rs-share-title">Share Your Achievement</h3>
                <p class="rs-share-text">Show the world your {{ $percentage }}% score on {{ $quiz->title }}</p>
                <div class="rs-share-buttons">
                    <a href="https://twitter.com/intent/tweet?text=I scored {{ $percentage }}% on the {{ $quiz->title }} quiz at EDUCONECX! 🎓&url={{ url()->current() }}"
                        target="_blank"
                        class="rs-share-btn"
                        title="Share on Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}"
                        target="_blank"
                        class="rs-share-btn"
                        title="Share on Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ url()->current() }}&title={{ $quiz->title }} Results&summary=I scored {{ $percentage }}% on this quiz at EDUCONECX!"
                        target="_blank"
                        class="rs-share-btn"
                        title="Share on LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="mailto:?subject=My Quiz Results at EDUCONECX&body=I scored {{ $percentage }}% on the {{ $quiz->title }} quiz! Check it out: {{ url()->current() }}"
                        class="rs-share-btn"
                        title="Share via Email">
                        <i class="fas fa-envelope"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animate stats cards on scroll
        const statItems = document.querySelectorAll('.rs-stat-item');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

        statItems.forEach((item, index) => {
            item.style.opacity = '0';
            item.style.transform = 'translateY(20px)';
            item.style.transition = 'all 0.5s ease';
            item.style.transitionDelay = (index * 0.1) + 's';
            observer.observe(item);
        });

        // Confetti effect for passed quizzes
        @if($passed)
        const colors = ['#06d6a0', '#4361ee', '#f72585', '#ffd166', '#667eea'];
        
        function createConfetti() {
            for (let i = 0; i < 50; i++) {
                setTimeout(() => {
                    const confetti = document.createElement('div');
                    confetti.style.position = 'fixed';
                    confetti.style.left = Math.random() * 100 + '%';
                    confetti.style.top = '-10px';
                    confetti.style.width = '8px';
                    confetti.style.height = '8px';
                    confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                    confetti.style.borderRadius = '50%';
                    confetti.style.zIndex = '9999';
                    confetti.style.pointerEvents = 'none';
                    confetti.style.animation = `confetti-fall ${Math.random() * 2 + 2}s linear`;
                    document.body.appendChild(confetti);

                    setTimeout(() => confetti.remove(), 4000);
                }, i * 50);
            }
        }

        // Add keyframe animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes confetti-fall {
                to {
                    transform: translateY(100vh) rotate(360deg);
                }
            }
        `;
        document.head.appendChild(style);

        // Trigger confetti after page load
        setTimeout(createConfetti, 500);
        @endif

        // Question hover effect
        const questionItems = document.querySelectorAll('.rs-question-item');
        questionItems.forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.backgroundColor = '#ffffff';
            });
            item.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '';
            });
        });

        // Print functionality
        window.printResults = function() {
            window.print();
        };

        console.log('Quiz results page initialized');
    });
</script>
@endpush