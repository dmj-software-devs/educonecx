@extends('layouts.main')

@section('title', $quiz->title . ' - Quiz | EDUCONECX')

@section('meta_description', $quiz->description ?? 'Take this quiz to test your knowledge and track your progress.')

@section('content')
<style>
    /* Quiz Detail Page Specific Styles - Scoped to prevent conflicts */
    :root {
        --quiz-detail-primary: #4361ee;
        --quiz-detail-primary-dark: #3a56d4;
        --quiz-detail-primary-light: #4895ef;
        --quiz-detail-secondary: #4cc9f0;
        --quiz-detail-accent: #f72585;
        --quiz-detail-success: #06d6a0;
        --quiz-detail-warning: #ffd166;
        --quiz-detail-danger: #ef476f;
        --quiz-detail-dark: #1e1e2f;
        --quiz-detail-gray: #6c757d;
        --quiz-detail-gray-light: #e9ecef;
        --quiz-detail-light: #f8f9fa;
        --quiz-detail-white: #ffffff;
        --quiz-detail-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --quiz-detail-gradient-hover: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        --quiz-detail-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        --quiz-detail-shadow-hover: 0 15px 40px rgba(67, 97, 238, 0.15);
        --quiz-detail-radius: 12px;
        --quiz-detail-radius-lg: 20px;
        --quiz-detail-radius-sm: 8px;
        --quiz-detail-radius-full: 9999px;
        --quiz-detail-transition: all 0.3s ease;
    }

    /* Main Container */
    .quiz-detail-container {
        background: var(--quiz-detail-light);
        min-height: 100vh;
        padding: 50px 0;
    }

    /* Back Link */
    .quiz-detail-back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 25px;
        color: var(--quiz-detail-primary);
        text-decoration: none;
        font-size: 0.95rem;
        font-weight: 500;
        transition: var(--quiz-detail-transition);
        padding: 8px 16px;
        background: var(--quiz-detail-white);
        border-radius: var(--quiz-detail-radius-full);
        box-shadow: var(--quiz-detail-shadow);
    }

    .quiz-detail-back-link:hover {
        transform: translateX(-5px);
        color: var(--quiz-detail-primary-dark);
        box-shadow: var(--quiz-detail-shadow-hover);
    }

    .quiz-detail-back-link i {
        font-size: 0.9rem;
    }

    /* Quiz Header */
    .quiz-detail-header {
        margin-bottom: 30px;
    }

    .quiz-detail-title {
        font-size: 2.5rem !important;
        font-weight: 700 !important;
        color: var(--quiz-detail-dark) !important;
        margin-bottom: 15px !important;
        line-height: 1.2 !important;
    }

    .quiz-detail-description {
        color: var(--quiz-detail-gray) !important;
        font-size: 1.1rem !important;
        line-height: 1.6 !important;
        max-width: 800px;
        margin-bottom: 0 !important;
    }

    /* Statistics Cards */
    .quiz-detail-stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }

    .quiz-detail-stat-card {
        background: var(--quiz-detail-white);
        border-radius: var(--quiz-detail-radius-lg);
        padding: 25px 20px;
        box-shadow: var(--quiz-detail-shadow);
        display: flex;
        align-items: center;
        transition: var(--quiz-detail-transition);
        position: relative;
        overflow: hidden;
        height: 100%;
    }

    .quiz-detail-stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: var(--quiz-detail-gradient);
        transform: translateX(-100%);
        transition: var(--quiz-detail-transition);
    }

    .quiz-detail-stat-card:hover::before {
        transform: translateX(0);
    }

    .quiz-detail-stat-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--quiz-detail-shadow-hover);
    }

    .quiz-detail-stat-icon {
        width: 55px;
        height: 55px;
        background: var(--quiz-detail-gradient);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        flex-shrink: 0;
    }

    .quiz-detail-stat-icon i {
        font-size: 22px;
        color: var(--quiz-detail-white);
    }

    .quiz-detail-stat-details {
        flex: 1;
    }

    .quiz-detail-stat-details h3 {
        font-size: 1.8rem !important;
        font-weight: 700 !important;
        color: var(--quiz-detail-dark) !important;
        margin: 0 0 5px 0 !important;
        line-height: 1.2 !important;
    }

    .quiz-detail-stat-details p {
        margin: 0 !important;
        color: var(--quiz-detail-gray) !important;
        font-size: 0.9rem !important;
        font-weight: 500;
    }

    /* Info Card */
    .quiz-detail-info-card,
    .quiz-detail-attempts-card,
    .quiz-detail-start-card,
    .quiz-detail-rules-card {
        background: var(--quiz-detail-white);
        border-radius: var(--quiz-detail-radius-lg);
        padding: 30px;
        box-shadow: var(--quiz-detail-shadow);
        height: 100%;
    }

    .quiz-detail-card-title {
        font-size: 1.25rem !important;
        font-weight: 600 !important;
        color: var(--quiz-detail-dark) !important;
        margin-bottom: 20px !important;
        padding-bottom: 12px;
        border-bottom: 2px solid var(--quiz-detail-gray-light);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .quiz-detail-card-title i {
        color: var(--quiz-detail-primary);
    }

    /* Details Grid */
    .quiz-detail-details-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .quiz-detail-detail-item {
        display: flex;
        flex-direction: column;
        background: var(--quiz-detail-light);
        padding: 15px;
        border-radius: var(--quiz-detail-radius);
        transition: var(--quiz-detail-transition);
    }

    .quiz-detail-detail-item:hover {
        transform: translateY(-2px);
        box-shadow: var(--quiz-detail-shadow);
    }

    .quiz-detail-detail-item .label {
        font-size: 0.8rem;
        color: var(--quiz-detail-gray);
        margin-bottom: 5px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .quiz-detail-detail-item .value {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--quiz-detail-dark);
    }

    .quiz-detail-type-badge {
        display: inline-block;
        padding: 5px 15px;
        border-radius: var(--quiz-detail-radius-full);
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .quiz-detail-type-badge.standalone {
        background: #ff6b6b;
        color: white;
    }

    .quiz-detail-type-badge.course {
        background: #4ecdc4;
        color: white;
    }

    .quiz-detail-type-badge.lesson {
        background: #45b7d1;
        color: white;
    }

    /* Attempts Table */
    .quiz-detail-table-responsive {
        overflow-x: auto;
    }

    .quiz-detail-attempts-table {
        width: 100%;
        border-collapse: collapse;
    }

    .quiz-detail-attempts-table th {
        text-align: left;
        padding: 15px;
        background: var(--quiz-detail-light);
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--quiz-detail-dark);
        border-bottom: 2px solid var(--quiz-detail-gray-light);
    }

    .quiz-detail-attempts-table td {
        padding: 15px;
        border-bottom: 1px solid var(--quiz-detail-gray-light);
        font-size: 0.95rem;
        color: var(--quiz-detail-gray);
    }

    .quiz-detail-attempts-table tr:hover td {
        background: var(--quiz-detail-light);
    }

    .quiz-detail-percentage {
        font-weight: 600;
    }

    .quiz-detail-percentage.success {
        color: var(--quiz-detail-success);
    }

    .quiz-detail-percentage.danger {
        color: var(--quiz-detail-danger);
    }

    .quiz-detail-status-badge {
        display: inline-block;
        padding: 5px 12px;
        border-radius: var(--quiz-detail-radius-full);
        font-size: 0.8rem;
        font-weight: 600;
    }

    .quiz-detail-status-badge.success {
        background: rgba(6, 214, 160, 0.1);
        color: var(--quiz-detail-success);
    }

    .quiz-detail-status-badge.danger {
        background: rgba(239, 71, 111, 0.1);
        color: var(--quiz-detail-danger);
    }

    .quiz-detail-status-badge.warning {
        background: rgba(255, 209, 102, 0.1);
        color: #b85e00;
    }

    .quiz-detail-best-score {
        margin-top: 20px;
        padding: 15px 20px;
        background: var(--quiz-detail-light);
        border-radius: var(--quiz-detail-radius);
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 1rem;
    }

    .quiz-detail-best-score strong {
        color: var(--quiz-detail-primary);
        font-size: 1.2rem;
        margin-left: 10px;
    }

    /* Start Card */
    .quiz-detail-start-card {
        text-align: center;
    }

    .quiz-detail-alert {
        padding: 15px 20px;
        border-radius: var(--quiz-detail-radius);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.95rem;
    }

    .quiz-detail-alert.info {
        background: rgba(67, 97, 238, 0.1);
        color: var(--quiz-detail-primary);
        border: 1px solid rgba(67, 97, 238, 0.2);
    }

    .quiz-detail-alert.warning {
        background: rgba(239, 71, 111, 0.1);
        color: var(--quiz-detail-danger);
        border: 1px solid rgba(239, 71, 111, 0.2);
    }

    .quiz-detail-alert i {
        font-size: 1.1rem;
    }

    .quiz-detail-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 15px 30px;
        border-radius: var(--quiz-detail-radius-full);
        font-size: 1.1rem;
        font-weight: 600;
        text-decoration: none;
        transition: var(--quiz-detail-transition);
        border: none;
        cursor: pointer;
        width: 100%;
    }

    .quiz-detail-btn.primary {
        background: var(--quiz-detail-gradient);
        color: var(--quiz-detail-white);
    }

    .quiz-detail-btn.primary:hover {
        background: var(--quiz-detail-gradient-hover);
        transform: translateY(-2px);
        box-shadow: var(--quiz-detail-shadow-hover);
        color: var(--quiz-detail-white);
    }

    .quiz-detail-btn.secondary {
        background: var(--quiz-detail-gray);
        color: var(--quiz-detail-white);
    }

    .quiz-detail-btn.secondary:hover {
        background: var(--quiz-detail-dark);
        transform: translateY(-2px);
        box-shadow: var(--quiz-detail-shadow-hover);
    }

    .quiz-detail-warnings {
        margin-top: 20px;
        text-align: left;
        background: var(--quiz-detail-light);
        padding: 20px;
        border-radius: var(--quiz-detail-radius);
    }

    .quiz-detail-warnings small {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 12px;
        color: var(--quiz-detail-gray);
        font-size: 0.9rem;
    }

    .quiz-detail-warnings small:last-child {
        margin-bottom: 0;
    }

    .quiz-detail-warnings small i {
        color: var(--quiz-detail-primary);
        width: 18px;
    }

    /* Rules Card */
    .quiz-detail-rules-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .quiz-detail-rules-list li {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 15px;
        color: var(--quiz-detail-gray);
        font-size: 0.95rem;
        padding: 8px 0;
        border-bottom: 1px dashed var(--quiz-detail-gray-light);
    }

    .quiz-detail-rules-list li:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }

    .quiz-detail-rules-list li i {
        color: var(--quiz-detail-success);
        font-size: 1rem;
        width: 20px;
    }

    /* Login Prompt */
    .quiz-detail-login-prompt {
        text-align: center;
    }

    .quiz-detail-login-prompt p {
        margin-top: 15px;
        font-size: 0.9rem;
        color: var(--quiz-detail-gray);
    }

    .quiz-detail-login-prompt a {
        color: var(--quiz-detail-primary);
        font-weight: 600;
        text-decoration: none;
    }

    .quiz-detail-login-prompt a:hover {
        text-decoration: underline;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .quiz-detail-stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .quiz-detail-details-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .quiz-detail-container {
            padding: 30px 0;
        }

        .quiz-detail-title {
            font-size: 2rem !important;
        }

        .quiz-detail-stats-grid {
            grid-template-columns: 1fr;
        }

        .quiz-detail-stat-card {
            margin-bottom: 0;
        }

        .quiz-detail-info-card,
        .quiz-detail-attempts-card,
        .quiz-detail-start-card,
        .quiz-detail-rules-card {
            padding: 20px;
        }

        .quiz-detail-attempts-table th,
        .quiz-detail-attempts-table td {
            padding: 10px;
            font-size: 0.85rem;
        }

        .quiz-detail-best-score {
            flex-direction: column;
            text-align: center;
            gap: 10px;
        }

        .quiz-detail-best-score strong {
            margin-left: 0;
        }
    }

    /* Animations */
    @keyframes quiz-detail-fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .quiz-detail-stat-card,
    .quiz-detail-info-card,
    .quiz-detail-attempts-card,
    .quiz-detail-start-card,
    .quiz-detail-rules-card {
        animation: quiz-detail-fadeIn 0.5s ease-out;
        animation-fill-mode: both;
    }

    .quiz-detail-stat-card:nth-child(1) { animation-delay: 0.1s; }
    .quiz-detail-stat-card:nth-child(2) { animation-delay: 0.2s; }
    .quiz-detail-stat-card:nth-child(3) { animation-delay: 0.3s; }
    .quiz-detail-stat-card:nth-child(4) { animation-delay: 0.4s; }
    .quiz-detail-info-card { animation-delay: 0.2s; }
    .quiz-detail-attempts-card { animation-delay: 0.3s; }
    .quiz-detail-start-card { animation-delay: 0.4s; }
    .quiz-detail-rules-card { animation-delay: 0.5s; }
</style>

<div class="quiz-detail-container">
    <div class="container">
        <!-- Back Link -->
        <a href="{{ route('quiz') }}" class="quiz-detail-back-link">
            <i class="fas fa-arrow-left"></i>
            Back to Quizzes
        </a>

        <!-- Quiz Header -->
        <div class="quiz-detail-header">
            <h1 class="quiz-detail-title">{{ $quiz->title }}</h1>
            @if($quiz->description)
                <p class="quiz-detail-description">{{ $quiz->description }}</p>
            @endif
        </div>

        <!-- Statistics Cards -->
        <div class="quiz-detail-stats-grid">
            <div class="quiz-detail-stat-card">
                <div class="quiz-detail-stat-icon">
                    <i class="fas fa-question-circle"></i>
                </div>
                <div class="quiz-detail-stat-details">
                    <h3>{{ $quiz->questions_count ?? $quiz->questions->count() }}</h3>
                    <p>Total Questions</p>
                </div>
            </div>

            <div class="quiz-detail-stat-card">
                <div class="quiz-detail-stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="quiz-detail-stat-details">
                    <h3>{{ $quiz->time_limit ? $quiz->time_limit . ' min' : 'No limit' }}</h3>
                    <p>Time Limit</p>
                </div>
            </div>

            <div class="quiz-detail-stat-card">
                <div class="quiz-detail-stat-icon">
                    <i class="fas fa-trophy"></i>
                </div>
                <div class="quiz-detail-stat-details">
                    <h3>{{ $quiz->pass_percentage }}%</h3>
                    <p>Pass Percentage</p>
                </div>
            </div>

            <div class="quiz-detail-stat-card">
                <div class="quiz-detail-stat-icon">
                    <i class="fas fa-redo"></i>
                </div>
                <div class="quiz-detail-stat-details">
                    <h3>{{ $quiz->attempts_allowed == 0 ? '∞' : $quiz->attempts_allowed }}</h3>
                    <p>Attempts Allowed</p>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Left Column - Details and Attempts -->
            <div class="col-lg-8 mb-4 mb-lg-0">
                <!-- Quiz Details Card -->
                <div class="quiz-detail-info-card mb-4">
                    <h4 class="quiz-detail-card-title">
                        <i class="fas fa-info-circle"></i>
                        Quiz Details
                    </h4>
                    
                    <div class="quiz-detail-details-grid">
                        <div class="quiz-detail-detail-item">
                            <span class="label">Type</span>
                            <span class="value">
                                <span class="quiz-detail-type-badge {{ $quiz->type }}">
                                    {{ ucfirst($quiz->type) }}
                                </span>
                            </span>
                        </div>

                        <div class="quiz-detail-detail-item">
                            <span class="label">Shuffle Questions</span>
                            <span class="value">{{ $quiz->shuffle_questions ? 'Yes' : 'No' }}</span>
                        </div>

                        <div class="quiz-detail-detail-item">
                            <span class="label">Randomize Options</span>
                            <span class="value">{{ $quiz->randomize_options ? 'Yes' : 'No' }}</span>
                        </div>

                        <div class="quiz-detail-detail-item">
                            <span class="label">Show Results</span>
                            <span class="value">{{ $quiz->show_results ? 'Yes' : 'No' }}</span>
                        </div>

                        <div class="quiz-detail-detail-item">
                            <span class="label">Show Answers</span>
                            <span class="value">{{ $quiz->show_answers ? 'Yes' : 'No' }}</span>
                        </div>

                        <div class="quiz-detail-detail-item">
                            <span class="label">Category</span>
                            <span class="value">{{ $quiz->category ?? 'General' }}</span>
                        </div>
                    </div>
                </div>

                <!-- User's Previous Attempts -->
                @if(isset($attempts) && $attempts->count() > 0)
                <div class="quiz-detail-attempts-card">
                    <h4 class="quiz-detail-card-title">
                        <i class="fas fa-history"></i>
                        Your Previous Attempts
                    </h4>

                    <div class="quiz-detail-table-responsive">
                        <table class="quiz-detail-attempts-table">
                            <thead>
                                <tr>
                                    <th>Attempt</th>
                                    <th>Score</th>
                                    <th>Percentage</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attempts as $attempt)
                                <tr>
                                    <td>#{{ $attempt->attempt_number }}</td>
                                    <td>{{ $attempt->score }}/{{ $quiz->questions->sum('points') }}</td>
                                    <td>
                                        <span class="quiz-detail-percentage {{ $attempt->passed ? 'success' : 'danger' }}">
                                            {{ $attempt->percentage }}%
                                        </span>
                                    </td>
                                    <td>
                                        <span class="quiz-detail-status-badge {{ $attempt->passed ? 'success' : 'danger' }}">
                                            {{ $attempt->passed ? 'Passed' : 'Failed' }}
                                        </span>
                                    </td>
                                    <td>{{ $attempt->completed_at ? $attempt->completed_at->format('M d, Y') : 'In Progress' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    @if(isset($bestScore) && $bestScore > 0)
                    <div class="quiz-detail-best-score">
                        <span>🏆 Best Score</span>
                        <strong>{{ $bestScore }} points</strong>
                    </div>
                    @endif
                </div>
                @endif
            </div>

            <!-- Right Column - Start Quiz and Rules -->
            <div class="col-lg-4">
                <!-- Start Quiz Card -->
                <div class="quiz-detail-start-card mb-4">
                    <h4 class="quiz-detail-card-title">
                        <i class="fas fa-play-circle"></i>
                        Ready to Start?
                    </h4>
                    
                    @auth
                        @if(isset($canAttempt) && $canAttempt)
                            <div class="quiz-detail-alert info">
                                <i class="fas fa-info-circle"></i>
                                <span>
                                    You have {{ $quiz->attempts_allowed == 0 ? 'unlimited' : $quiz->attempts_allowed - ($attempts->count() ?? 0) }} 
                                    attempt{{ ($quiz->attempts_allowed - ($attempts->count() ?? 0)) != 1 ? 's' : '' }} remaining.
                                </span>
                            </div>
                            
                            <form action="{{ route('quizzes.start', $quiz) }}" method="POST" id="startQuizForm">
                                @csrf
                                <button type="submit" class="quiz-detail-btn primary" id="startQuizBtn">
                                    <i class="fas fa-play"></i>
                                    Start Quiz Now
                                </button>
                            </form>
                            
                            <div class="quiz-detail-warnings">
                                @if($quiz->time_limit)
                                    <small>
                                        <i class="fas fa-hourglass-half"></i>
                                        You have {{ $quiz->time_limit }} minutes to complete this quiz.
                                    </small>
                                @endif
                                
                                @if($quiz->shuffle_questions)
                                    <small>
                                        <i class="fas fa-random"></i>
                                        Questions will be shuffled.
                                    </small>
                                @endif
                                
                                @if($quiz->randomize_options)
                                    <small>
                                        <i class="fas fa-shuffle"></i>
                                        Answer options will be randomized.
                                    </small>
                                @endif
                            </div>
                        @else
                            <div class="quiz-detail-alert warning">
                                <i class="fas fa-exclamation-triangle"></i>
                                <span>You have reached the maximum number of attempts for this quiz.</span>
                            </div>
                            
                            @if($quiz->show_results && $quiz->show_answers)
                                <a href="{{ route('quizzes.results', $quiz) }}" class="quiz-detail-btn secondary">
                                    <i class="fas fa-chart-bar"></i>
                                    View Results
                                </a>
                            @endif
                        @endif
                    @else
                        <div class="quiz-detail-alert info">
                            <i class="fas fa-lock"></i>
                            <span>Please login to take this quiz.</span>
                        </div>
                        
                        <a href="{{ route('login') }}" class="quiz-detail-btn primary">
                            <i class="fas fa-sign-in-alt"></i>
                            Login to Start
                        </a>
                        
                        <div class="quiz-detail-login-prompt">
                            <p>Don't have an account? <a href="{{ route('register') }}">Register here</a></p>
                        </div>
                    @endauth
                </div>

                <!-- Quiz Rules Card -->
                <div class="quiz-detail-rules-card">
                    <h4 class="quiz-detail-card-title">
                        <i class="fas fa-gavel"></i>
                        Quiz Rules
                    </h4>
                    
                    <ul class="quiz-detail-rules-list">
                        <li>
                            <i class="fas fa-check-circle"></i>
                            Read each question carefully
                        </li>
                        <li>
                            <i class="fas fa-check-circle"></i>
                            You cannot pause once started
                        </li>
                        @if($quiz->time_limit)
                        <li>
                            <i class="fas fa-check-circle"></i>
                            Timer starts immediately
                        </li>
                        @endif
                        <li>
                            <i class="fas fa-check-circle"></i>
                            All questions are required
                        </li>
                        @if($quiz->pass_percentage)
                        <li>
                            <i class="fas fa-check-circle"></i>
                            Need {{ $quiz->pass_percentage }}% to pass
                        </li>
                        @endif
                        <li>
                            <i class="fas fa-check-circle"></i>
                            Results shown after completion
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Confirmation before starting quiz
    const startForm = document.getElementById('startQuizForm');
    const startBtn = document.getElementById('startQuizBtn');
    
    if (startForm) {
        startForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Create custom confirmation dialog
            const timeWarning = {{ $quiz->time_limit ?? 'null' }} ? 
                `\n\n⏱️ You have ${ {{ $quiz->time_limit }} } minutes to complete this quiz.` : '';
            
            const confirmation = confirm(
                `Ready to start "${ {{ json_encode($quiz->title) }} }"?` +
                `\n\n📝 Questions: {{ $quiz->questions_count ?? $quiz->questions->count() }}` +
                timeWarning +
                `\n\n⚠️ Once started, you cannot pause or restart.` +
                `\n\nDo you want to begin now?`
            );
            
            if (confirmation) {
                // Show loading state
                startBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Starting...';
                startBtn.disabled = true;
                
                // Submit the form
                this.submit();
            }
        });
    }

    // Animate cards on scroll
    const cards = document.querySelectorAll(
        '.quiz-detail-stat-card, .quiz-detail-info-card, .quiz-detail-attempts-card, ' +
        '.quiz-detail-start-card, .quiz-detail-rules-card'
    );

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });

    cards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'all 0.5s ease';
        observer.observe(card);
    });

    // Hover effects for stat cards
    const statCards = document.querySelectorAll('.quiz-detail-stat-card');
    statCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Auto-refresh attempts data (optional)
    @if(isset($attempts) && $attempts->count() > 0)
    // Check for any in-progress attempts every 30 seconds
    const hasInProgress = {{ $attempts->contains(function($attempt) { return !$attempt->completed_at; }) ? 'true' : 'false' }};
    
    if (hasInProgress) {
        setInterval(function() {
            location.reload();
        }, 30000); // Refresh every 30 seconds
    }
    @endif
});
</script>
@endsection