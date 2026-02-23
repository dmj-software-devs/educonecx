@extends('layouts.main')

@section('title', 'Quiz Results - ' . $quiz->title . ' - EDUCONECX')

@section('meta_description', 'View your quiz results and performance.')

@section('content')
<style>
    /* Quiz Results Page Styles */
    :root {
        --results-primary: #4361ee;
        --results-success: #06d6a0;
        --results-danger: #ef476f;
        --results-warning: #ffd166;
        --results-dark: #1e1e2f;
        --results-gray: #6c757d;
        --results-gray-light: #e9ecef;
        --results-light: #f8f9fa;
        --results-white: #ffffff;
        --results-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --results-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        --results-shadow-hover: 0 15px 40px rgba(67, 97, 238, 0.15);
        --results-radius: 12px;
        --results-radius-lg: 20px;
        --results-radius-full: 9999px;
        --results-transition: all 0.3s ease;
    }

    .results-container {
        background: var(--results-light);
        min-height: 100vh;
        padding: 50px 0;
    }

    .results-card {
        background: var(--results-white);
        border-radius: var(--results-radius-lg);
        box-shadow: var(--results-shadow);
        padding: 40px;
        margin-bottom: 30px;
    }

    .results-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .results-icon {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px;
        font-size: 3rem;
        animation: results-pop 0.5s ease-out;
    }

    @keyframes results-pop {
        0% {
            transform: scale(0);
        }

        50% {
            transform: scale(1.2);
        }

        100% {
            transform: scale(1);
        }
    }

    .results-icon.passed {
        background: rgba(6, 214, 160, 0.1);
        color: var(--results-success);
    }

    .results-icon.failed {
        background: rgba(239, 71, 111, 0.1);
        color: var(--results-danger);
    }

    .results-title {
        font-size: 2.2rem !important;
        font-weight: 700 !important;
        color: var(--results-dark) !important;
        margin-bottom: 10px !important;
    }

    .results-subtitle {
        color: var(--results-gray) !important;
        font-size: 1.1rem !important;
    }

    /* Score Circle */
    .score-container {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 40px;
        flex-wrap: wrap;
        gap: 30px;
    }

    .score-circle {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background: var(--results-gradient);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: white;
        box-shadow: var(--results-shadow);
        position: relative;
        animation: results-pulse 2s infinite;
    }

    @keyframes results-pulse {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.05);
        }
    }

    .score-circle::before {
        content: '';
        position: absolute;
        top: 10px;
        left: 10px;
        right: 10px;
        bottom: 10px;
        border-radius: 50%;
        border: 3px solid rgba(255, 255, 255, 0.3);
    }

    .score-percentage {
        font-size: 3.5rem;
        font-weight: 700;
        line-height: 1;
        margin-bottom: 5px;
    }

    .score-label {
        font-size: 1rem;
        opacity: 0.9;
    }

    .score-details {
        text-align: center;
    }

    .score-points {
        font-size: 2rem;
        font-weight: 700;
        color: var(--results-dark);
        margin-bottom: 5px;
    }

    .score-passing {
        color: var(--results-gray);
        font-size: 1rem;
    }

    .score-status {
        display: inline-block;
        margin-top: 10px;
        padding: 8px 25px;
        border-radius: var(--results-radius-full);
        font-weight: 600;
        font-size: 1.1rem;
    }

    .score-status.passed {
        background: rgba(6, 214, 160, 0.1);
        color: var(--results-success);
    }

    .score-status.failed {
        background: rgba(239, 71, 111, 0.1);
        color: var(--results-danger);
    }

    /* Stats Grid */
    .results-stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 40px;
    }

    .results-stat-item {
        text-align: center;
        padding: 20px;
        background: var(--results-light);
        border-radius: var(--results-radius);
        transition: var(--results-transition);
    }

    .results-stat-item:hover {
        transform: translateY(-5px);
        box-shadow: var(--results-shadow);
    }

    .results-stat-value {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--results-primary);
        margin-bottom: 5px;
    }

    .results-stat-label {
        color: var(--results-gray);
        font-size: 0.9rem;
    }

    /* Questions Review */
    .questions-title {
        font-size: 1.5rem !important;
        font-weight: 600 !important;
        color: var(--results-dark) !important;
        margin-bottom: 25px !important;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .questions-title i {
        color: var(--results-primary);
    }

    .question-review-item {
        background: var(--results-light);
        border-radius: var(--results-radius);
        padding: 25px;
        margin-bottom: 20px;
        border-left: 4px solid transparent;
        transition: var(--results-transition);
    }

    .question-review-item:hover {
        transform: translateX(5px);
        box-shadow: var(--results-shadow);
    }

    .question-review-item.correct {
        border-left-color: var(--results-success);
    }

    .question-review-item.incorrect {
        border-left-color: var(--results-danger);
    }

    .question-review-item.partial {
        border-left-color: var(--results-warning);
    }

    .question-review-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .question-number {
        font-weight: 600;
        color: var(--results-gray);
        background: var(--results-white);
        padding: 4px 12px;
        border-radius: var(--results-radius-full);
    }

    .question-type {
        font-size: 0.85rem;
        color: var(--results-gray);
        background: var(--results-white);
        padding: 4px 12px;
        border-radius: var(--results-radius-full);
    }

    .question-points {
        padding: 4px 12px;
        border-radius: var(--results-radius-full);
        font-size: 0.85rem;
        font-weight: 500;
    }

    .question-points.correct {
        background: rgba(6, 214, 160, 0.1);
        color: var(--results-success);
    }

    .question-points.incorrect {
        background: rgba(239, 71, 111, 0.1);
        color: var(--results-danger);
    }

    .question-points.partial {
        background: rgba(255, 209, 102, 0.1);
        color: #b85e00;
    }

    .question-text {
        font-size: 1.1rem;
        font-weight: 500;
        color: var(--results-dark);
        margin-bottom: 20px;
        line-height: 1.5;
    }

    .answer-display {
        background: var(--results-white);
        padding: 15px;
        border-radius: var(--results-radius);
        margin-bottom: 10px;
    }

    .answer-label {
        font-size: 0.9rem;
        color: var(--results-gray);
        margin-bottom: 5px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .answer-label i {
        color: var(--results-primary);
    }

    .answer-value {
        font-weight: 500;
        color: var(--results-dark);
        padding: 8px 12px;
        background: var(--results-light);
        border-radius: var(--results-radius-sm);
    }

    .correct-answer {
        color: var(--results-success);
        font-weight: 500;
        padding: 8px 12px;
        background: rgba(6, 214, 160, 0.05);
        border-radius: var(--results-radius-sm);
        border: 1px solid rgba(6, 214, 160, 0.2);
    }

    /* Action Buttons */
    .results-actions {
        display: flex;
        gap: 15px;
        justify-content: center;
        margin-top: 40px;
        flex-wrap: wrap;
    }

    .results-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 15px 30px;
        border-radius: var(--results-radius-full);
        font-size: 1rem;
        font-weight: 600;
        text-decoration: none;
        transition: var(--results-transition);
        border: none;
        cursor: pointer;
    }

    .results-btn.primary {
        background: var(--results-gradient);
        color: white;
    }

    .results-btn.primary:hover {
        transform: translateY(-2px);
        box-shadow: var(--results-shadow-hover);
    }

    .results-btn.secondary {
        background: var(--results-light);
        color: var(--results-gray);
        border: 2px solid var(--results-gray-light);
    }

    .results-btn.secondary:hover {
        background: var(--results-gray-light);
        color: var(--results-dark);
        transform: translateY(-2px);
    }

    .results-btn.success {
        background: var(--results-success);
        color: white;
    }

    .results-btn.success:hover {
        background: #05b586;
        transform: translateY(-2px);
        box-shadow: var(--results-shadow);
    }

    /* Alerts */
    .results-alert {
        padding: 15px 20px;
        border-radius: var(--results-radius);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .results-alert.success {
        background: rgba(6, 214, 160, 0.1);
        color: var(--results-success);
        border: 1px solid rgba(6, 214, 160, 0.2);
    }

    .results-alert.info {
        background: rgba(67, 97, 238, 0.1);
        color: var(--results-primary);
        border: 1px solid rgba(67, 97, 238, 0.2);
    }

    .results-alert.warning {
        background: rgba(255, 209, 102, 0.1);
        color: #b85e00;
        border: 1px solid rgba(255, 209, 102, 0.2);
    }

    /* Responsive */
    @media (max-width: 992px) {
        .results-stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .results-container {
            padding: 30px 0;
        }

        .results-card {
            padding: 25px;
        }

        .results-title {
            font-size: 1.8rem !important;
        }

        .results-stats-grid {
            grid-template-columns: 1fr;
        }

        .results-actions {
            flex-direction: column;
        }

        .results-btn {
            width: 100%;
            justify-content: center;
        }

        .score-container {
            flex-direction: column;
        }

        .question-review-header {
            flex-direction: column;
            align-items: flex-start;
        }
    }

    /* Print Styles */
    @media print {

        .results-actions,
        .results-btn {
            display: none;
        }

        .results-card {
            box-shadow: none;
            border: 1px solid #ddd;
        }
    }
</style>

<div class="results-container">
    <div class="container">
        <!-- Display any session messages -->
        @if(session('success'))
        <div class="results-alert success">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        @if(session('info'))
        <div class="results-alert info">
            <i class="fas fa-info-circle"></i>
            <span>{{ session('info') }}</span>
        </div>
        @endif

        @if(session('error'))
        <div class="results-alert warning">
            <i class="fas fa-exclamation-triangle"></i>
            <span>{{ session('error') }}</span>
        </div>
        @endif

        <div class="results-card">
            <!-- Header with Status -->
            <div class="results-header">
                <div class="results-icon {{ $passed ? 'passed' : 'failed' }}">
                    <i class="fas {{ $passed ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                </div>
                <h1 class="results-title">Quiz Completed!</h1>
                <p class="results-subtitle">{{ $quiz->title }}</p>
            </div>

            <!-- Score Display -->
            <div class="score-container">
                <div class="score-circle">
                    <span class="score-percentage">{{ $percentage }}%</span>
                    <span class="score-label">Score</span>
                </div>
                <div class="score-details">
                    <div class="score-points">{{ $earnedPoints }}/{{ $totalPoints }}</div>
                    <div class="score-passing">Passing Score: {{ $quiz->pass_percentage }}%</div>
                    <div class="score-status {{ $passed ? 'passed' : 'failed' }}">
                        {{ $passed ? 'PASSED' : 'FAILED' }}
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="results-stats-grid">
                <div class="results-stat-item">
                    <div class="results-stat-value">{{ $attempt->answers->count() }}</div>
                    <div class="results-stat-label">Questions Answered</div>
                </div>
                <div class="results-stat-item">
                    <div class="results-stat-value">{{ $quiz->questions->count() }}</div>
                    <div class="results-stat-label">Total Questions</div>
                </div>
                <div class="results-stat-item">
                    <div class="results-stat-value">#{{ $attempt->attempt_number }}</div>
                    <div class="results-stat-label">Attempt Number</div>
                </div>
                <div class="results-stat-item">
                    <div class="results-stat-value">{{ $attempt->completed_at ? $attempt->completed_at->format('M d, Y') : 'N/A' }}</div>
                    <div class="results-stat-label">Completed On</div>
                </div>
            </div>

            <!-- Questions Review -->
            @if($quiz->show_answers)
            <div class="questions-review">
                <h2 class="questions-title">
                    <i class="fas fa-clipboard-list"></i>
                    Question Review
                </h2>

                @foreach($quiz->questions as $index => $question)
                @php
                $answer = $answers[$question->id] ?? null;
                $isCorrect = $answer ? $answer->is_correct : false;
                $pointsEarned = $answer ? $answer->points_earned : 0;
                @endphp
                <div class="question-review-item {{ $isCorrect ? 'correct' : ($pointsEarned > 0 ? 'partial' : 'incorrect') }}">
                    <div class="question-review-header">
                        <div>
                            <span class="question-number">Question {{ $index + 1 }}</span>
                            <span class="question-type">{{ str_replace('_', ' ', ucfirst($question->question_type)) }}</span>
                        </div>
                        <span class="question-points {{ $isCorrect ? 'correct' : ($pointsEarned > 0 ? 'partial' : 'incorrect') }}">
                            {{ $pointsEarned }}/{{ $question->points }} points
                        </span>
                    </div>

                    <div class="question-text">{{ $question->question_text }}</div>

                    @if($question->image)
                    <div class="question-image mb-3">
                        <img src="{{ $question->image_url }}" alt="Question image" style="max-width: 100%; max-height: 200px; border-radius: 8px;">
                    </div>
                    @endif

                    @if($answer && $answer->answer_data)
                    <div class="answer-display">
                        <div class="answer-label">
                            <i class="fas fa-user"></i>
                            Your Answer:
                        </div>
                        <div class="answer-value">
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
                    <div class="answer-display">
                        <div class="answer-label">
                            <i class="fas fa-check-circle" style="color: var(--results-success);"></i>
                            Correct Answer:
                        </div>
                        <div class="correct-answer">
                            @foreach($correctOptions as $option)
                            {{ $option->option_text }}@if(!$loop->last), @endif
                            @endforeach
                        </div>
                    </div>
                    @endif
                    @elseif($question->question_type == 'fill_blank' && $question->fillBlanks->count() > 0)
                    <div class="answer-display">
                        <div class="answer-label">
                            <i class="fas fa-check-circle" style="color: var(--results-success);"></i>
                            Correct Answer:
                        </div>
                        <div class="correct-answer">
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
            <div class="results-actions">
                @if($quiz->can_attempt)
                <form method="POST" action="{{ route('quizzes.start', $quiz->id) }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="results-btn primary">
                        <i class="fas fa-redo"></i>
                        Try Again
                    </button>
                </form>
                @endif

                <a href="{{ route('quiz') }}" class="results-btn secondary">
                    <i class="fas fa-th"></i>
                    More Quizzes
                </a>

                @if(Auth::user())
                <a href="{{ route('dashboard') }}" class="results-btn secondary">
                    <i class="fas fa-tachometer-alt"></i>
                    Dashboard
                </a>
                @endif

                <button onclick="window.print()" class="results-btn secondary">
                    <i class="fas fa-print"></i>
                    Print Results
                </button>
            </div>
        </div>

        <!-- Share Results Card -->
        <div class="results-card" style="margin-top: 20px;">
            <div style="text-align: center;">
                <h3 style="font-size: 1.3rem; margin-bottom: 15px;">Share Your Results</h3>
                <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                    <a href="https://twitter.com/intent/tweet?text=I scored {{ $percentage }}% on the {{ $quiz->title }} quiz at EDUCONECX!&url={{ url()->current() }}"
                        target="_blank"
                        style="width: 50px; height: 50px; border-radius: 50%; background: #1DA1F2; color: white; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: transform 0.3s;"
                        onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}"
                        target="_blank"
                        style="width: 50px; height: 50px; border-radius: 50%; background: #4267B2; color: white; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: transform 0.3s;"
                        onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ url()->current() }}&title={{ $quiz->title }} Results&summary=I scored {{ $percentage }}% on this quiz!"
                        target="_blank"
                        style="width: 50px; height: 50px; border-radius: 50%; background: #0077b5; color: white; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: transform 0.3s;"
                        onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="mailto:?subject=My Quiz Results&body=I scored {{ $percentage }}% on the {{ $quiz->title }} quiz at EDUCONECX. Check it out: {{ url()->current() }}"
                        style="width: 50px; height: 50px; border-radius: 50%; background: #D44638; color: white; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: transform 0.3s;"
                        onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                        <i class="fas fa-envelope"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animate stats cards on scroll
        const statItems = document.querySelectorAll('.results-stat-item');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, {
            threshold: 0.1
        });

        statItems.forEach((item, index) => {
            item.style.opacity = '0';
            item.style.transform = 'translateY(20px)';
            item.style.transition = 'all 0.5s ease';
            item.style.transitionDelay = (index * 0.1) + 's';
            observer.observe(item);
        });

        // Confetti effect for passed quizzes (optional)
        @if($passed)
        // Simple confetti effect
        const colors = ['#06d6a0', '#4361ee', '#f72585', '#ffd166'];

        function createConfetti() {
            for (let i = 0; i < 50; i++) {
                setTimeout(() => {
                    const confetti = document.createElement('div');
                    confetti.style.position = 'fixed';
                    confetti.style.left = Math.random() * 100 + '%';
                    confetti.style.top = '-10px';
                    confetti.style.width = '10px';
                    confetti.style.height = '10px';
                    confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                    confetti.style.borderRadius = '50%';
                    confetti.style.zIndex = '9999';
                    confetti.style.pointerEvents = 'none';
                    confetti.style.animation = `confetti-fall ${Math.random() * 3 + 2}s linear`;
                    document.body.appendChild(confetti);

                    setTimeout(() => confetti.remove(), 5000);
                }, i * 100);
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

        // Print functionality
        window.print = function() {
            window.print();
        };
    });
</script>
@endsection