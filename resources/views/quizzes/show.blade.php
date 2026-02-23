@extends('layouts.main')

@section('title', $quiz->title . ' - Quiz')

@section('content')
<div class="container" style="padding: 60px 0;">
    <!-- Quiz Header -->
    <div class="quiz-header mb-4">
        <a href="{{ route('quiz') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to Quizzes
        </a>
        <h1 class="quiz-title">{{ $quiz->title }}</h1>
        @if($quiz->description)
            <p class="quiz-description">{{ $quiz->description }}</p>
        @endif
    </div>

    <!-- Quiz Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-question-circle"></i>
                </div>
                <div class="stat-details">
                    <h3>{{ $quiz->questions_count ?? $quiz->questions->count() }}</h3>
                    <p>Total Questions</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-details">
                    <h3>{{ $quiz->time_limit ? $quiz->time_limit . ' min' : 'No limit' }}</h3>
                    <p>Time Limit</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-trophy"></i>
                </div>
                <div class="stat-details">
                    <h3>{{ $quiz->pass_percentage }}%</h3>
                    <p>Pass Percentage</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-redo"></i>
                </div>
                <div class="stat-details">
                    <h3>{{ $quiz->attempts_allowed == 0 ? '∞' : $quiz->attempts_allowed }}</h3>
                    <p>Attempts Allowed</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quiz Info and Start Button -->
    <div class="row">
        <div class="col-md-8">
            <!-- Quiz Details Card -->
            <div class="info-card mb-4">
                <h4 class="card-title">Quiz Details</h4>
                <div class="details-grid">
                    <div class="detail-item">
                        <span class="label">Type:</span>
                        <span class="value badge-type-{{ $quiz->type }}">{{ ucfirst($quiz->type) }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Shuffle Questions:</span>
                        <span class="value">{{ $quiz->shuffle_questions ? 'Yes' : 'No' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Randomize Options:</span>
                        <span class="value">{{ $quiz->randomize_options ? 'Yes' : 'No' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Show Results:</span>
                        <span class="value">{{ $quiz->show_results ? 'Yes' : 'No' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Show Answers:</span>
                        <span class="value">{{ $quiz->show_answers ? 'Yes' : 'No' }}</span>
                    </div>
                </div>
            </div>

            <!-- User's Previous Attempts -->
            @if(isset($attempts) && $attempts->count() > 0)
            <div class="attempts-card">
                <h4 class="card-title">Your Previous Attempts</h4>
                <div class="table-responsive">
                    <table class="attempts-table">
                        <thead>
                            <tr>
                                <th>Attempt #</th>
                                <th>Score</th>
                                <th>Percentage</th>
                                <th>Status</th>
                                <th>Completed</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attempts as $attempt)
                            <tr>
                                <td>Attempt {{ $attempt->attempt_number }}</td>
                                <td>{{ $attempt->score }}/{{ $quiz->questions->sum('points') }}</td>
                                <td>
                                    <span class="percentage {{ $attempt->passed ? 'text-success' : 'text-danger' }}">
                                        {{ $attempt->percentage }}%
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $attempt->passed ? 'badge-success' : 'badge-danger' }}">
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
                <div class="best-score">
                    <strong>Best Score:</strong> {{ $bestScore }} points
                </div>
                @endif
            </div>
            @endif
        </div>

        <div class="col-md-4">
            <!-- Start Quiz Card -->
            <div class="start-card">
                <h4 class="card-title">Ready to Start?</h4>
                
                @auth
                    @if(isset($canAttempt) && $canAttempt)
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            You have {{ $quiz->attempts_allowed == 0 ? 'unlimited' : $quiz->attempts_allowed - ($attempts->count() ?? 0) }} attempts remaining.
                        </div>
                        
                        <form action="{{ route('quizzes.start', $quiz) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-lg btn-block">
                                <i class="fas fa-play"></i> Start Quiz
                            </button>
                        </form>
                        
                        <div class="quiz-warnings">
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
                                    Options will be randomized.
                                </small>
                            @endif
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            You have reached the maximum number of attempts for this quiz.
                        </div>
                        
                        @if($quiz->show_results && $quiz->show_answers)
                            <a href="{{ route('quizzes.results', $quiz) }}" class="btn btn-secondary btn-block">
                                <i class="fas fa-chart-bar"></i> View Results
                            </a>
                        @endif
                    @endif
                @else
                    <div class="alert alert-info">
                        <i class="fas fa-lock"></i>
                        Please login to take this quiz.
                    </div>
                    
                    <a href="{{ route('login') }}" class="btn btn-primary btn-block">
                        <i class="fas fa-sign-in-alt"></i> Login to Start
                    </a>
                    
                    <div class="mt-3 text-center">
                        <small>Don't have an account? <a href="{{ route('register') }}">Register here</a></small>
                    </div>
                @endauth
            </div>

            <!-- Quiz Rules Card -->
            <div class="rules-card mt-4">
                <h5 class="card-title">Quiz Rules</h5>
                <ul class="rules-list">
                    <li><i class="fas fa-check-circle"></i> Read each question carefully</li>
                    <li><i class="fas fa-check-circle"></i> You cannot pause once started</li>
                    @if($quiz->time_limit)
                        <li><i class="fas fa-check-circle"></i> Timer starts when you begin</li>
                    @endif
                    <li><i class="fas fa-check-circle"></i> All questions are required</li>
                    @if($quiz->pass_percentage)
                        <li><i class="fas fa-check-circle"></i> Need {{ $quiz->pass_percentage }}% to pass</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .quiz-header {
        margin-bottom: 30px;
    }
    
    .back-link {
        display: inline-block;
        margin-bottom: 20px;
        color: #667eea;
        text-decoration: none;
        font-size: 14px;
    }
    
    .back-link:hover {
        text-decoration: underline;
    }
    
    .quiz-title {
        font-size: 32px;
        font-weight: 700;
        color: #333;
        margin-bottom: 10px;
    }
    
    .quiz-description {
        color: #666;
        line-height: 1.6;
    }
    
    /* Statistics Cards */
    .stat-card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        transition: transform 0.3s;
        height: 100%;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
    }
    
    .stat-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
    }
    
    .stat-icon i {
        font-size: 20px;
        color: white;
    }
    
    .stat-details h3 {
        font-size: 24px;
        font-weight: 700;
        margin: 0;
        color: #333;
    }
    
    .stat-details p {
        margin: 5px 0 0;
        color: #666;
        font-size: 13px;
    }
    
    /* Info Card */
    .info-card, .attempts-card, .start-card, .rules-card {
        background: white;
        border-radius: 10px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    
    .card-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 20px;
        color: #333;
        padding-bottom: 10px;
        border-bottom: 2px solid #f0f0f0;
    }
    
    .details-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }
    
    .detail-item {
        display: flex;
        flex-direction: column;
    }
    
    .detail-item .label {
        font-size: 12px;
        color: #999;
        margin-bottom: 5px;
    }
    
    .detail-item .value {
        font-size: 16px;
        font-weight: 500;
        color: #333;
    }
    
    .badge-type-standalone {
        background: #ff6b6b;
        color: white;
        padding: 3px 10px;
        border-radius: 15px;
        display: inline-block;
        font-size: 12px;
    }
    
    .badge-type-course {
        background: #4ecdc4;
        color: white;
        padding: 3px 10px;
        border-radius: 15px;
        display: inline-block;
        font-size: 12px;
    }
    
    .badge-type-lesson {
        background: #45b7d1;
        color: white;
        padding: 3px 10px;
        border-radius: 15px;
        display: inline-block;
        font-size: 12px;
    }
    
    /* Attempts Table */
    .attempts-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .attempts-table th {
        text-align: left;
        padding: 12px;
        background: #f8f9fa;
        font-size: 13px;
        font-weight: 600;
        color: #666;
    }
    
    .attempts-table td {
        padding: 12px;
        border-bottom: 1px solid #f0f0f0;
        font-size: 14px;
    }
    
    .percentage {
        font-weight: 600;
    }
    
    .text-success {
        color: #10b981;
    }
    
    .text-danger {
        color: #ef4444;
    }
    
    .badge-success {
        background: #10b981;
        color: white;
        padding: 3px 8px;
        border-radius: 12px;
        font-size: 11px;
    }
    
    .badge-danger {
        background: #ef4444;
        color: white;
        padding: 3px 8px;
        border-radius: 12px;
        font-size: 11px;
    }
    
    .best-score {
        margin-top: 20px;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 8px;
        text-align: center;
        font-size: 16px;
    }
    
    .best-score strong {
        color: #667eea;
    }
    
    /* Start Card */
    .start-card {
        text-align: center;
    }
    
    .btn-block {
        width: 100%;
        padding: 12px;
        font-size: 16px;
        border-radius: 8px;
        margin-top: 15px;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    }
    
    .btn-secondary {
        background: #6c757d;
        border: none;
        color: white;
    }
    
    .quiz-warnings {
        margin-top: 20px;
        text-align: left;
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
    }
    
    .quiz-warnings small {
        display: block;
        margin-bottom: 8px;
        color: #666;
    }
    
    .quiz-warnings small i {
        color: #667eea;
        width: 20px;
    }
    
    /* Rules Card */
    .rules-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .rules-list li {
        margin-bottom: 12px;
        font-size: 14px;
        color: #666;
        display: flex;
        align-items: center;
    }
    
    .rules-list li i {
        color: #10b981;
        margin-right: 10px;
        font-size: 16px;
    }
    
    /* Alerts */
    .alert {
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
    
    .alert-info {
        background: #e3f2fd;
        color: #0d47a1;
    }
    
    .alert-warning {
        background: #fff3e0;
        color: #e65100;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .quiz-title {
            font-size: 24px;
        }
        
        .details-grid {
            grid-template-columns: 1fr;
        }
        
        .stat-card {
            margin-bottom: 15px;
        }
        
        .attempts-table {
            font-size: 12px;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add any confirmation or warning before starting
        const startForm = document.querySelector('form[action*="start"]');
        if (startForm) {
            startForm.addEventListener('submit', function(e) {
                const confirmed = confirm('Are you ready to start the quiz? Once started, you cannot pause it.');
                if (!confirmed) {
                    e.preventDefault();
                }
            });
        }
    });
</script>
@endsection