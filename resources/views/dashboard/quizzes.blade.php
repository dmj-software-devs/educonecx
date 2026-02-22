@extends('layouts.main')

@section('title', 'My Quizzes - EDUCONECX | Track Your Quiz Performance')

@section('meta_description', 'View your quiz attempts, track your scores, and monitor your progress on EDUCONECX quizzes.')

@push('styles')
<style>
    /* Quizzes Container */
    .quizzes-container {
        padding: 40px 0;
        background: var(--light);
        min-height: calc(100vh - 400px);
    }

    /* Page Header */
    .page-header {
        margin-bottom: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--dark);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .page-title i {
        color: var(--primary);
        font-size: 2rem;
        animation: pulse 2s infinite;
    }

    .stats-badge {
        background: var(--gradient-1);
        color: var(--white);
        padding: 10px 25px;
        border-radius: var(--border-radius-full);
        font-weight: 600;
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 10px;
        box-shadow: var(--shadow-md);
    }

    .stats-badge i {
        font-size: 1.1rem;
    }

    /* Sidebar */
    .quizzes-sidebar {
        background: var(--white);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-lg);
        overflow: hidden;
        position: sticky;
        top: 100px;
    }

    .sidebar-header {
        padding: 20px;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-bottom: 1px solid var(--gray-light);
    }

    .sidebar-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--dark);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .sidebar-title i {
        color: var(--primary);
    }

    .sidebar-nav {
        padding: 15px;
    }

    .nav-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 15px;
        border-radius: var(--border-radius-md);
        color: var(--gray);
        text-decoration: none;
        transition: var(--transition);
        margin-bottom: 5px;
    }

    .nav-item i {
        width: 20px;
        font-size: 1.1rem;
        transition: var(--transition);
    }

    .nav-item:hover {
        background: var(--light);
        color: var(--primary);
        transform: translateX(5px);
    }

    .nav-item.active {
        background: var(--gradient-1);
        color: var(--white);
        box-shadow: var(--shadow-md);
    }

    .nav-item.active i {
        color: var(--white);
    }

    .nav-item span {
        flex: 1;
        font-weight: 500;
    }

    .nav-badge {
        background: rgba(255, 255, 255, 0.2);
        padding: 2px 8px;
        border-radius: var(--border-radius-full);
        font-size: 0.75rem;
    }

    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: var(--white);
        border-radius: var(--border-radius-lg);
        padding: 20px;
        box-shadow: var(--shadow-md);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: var(--gradient-1);
        transform: translateX(-100%);
        transition: var(--transition);
    }

    .stat-card:hover::before {
        transform: translateX(0);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }

    .stat-icon {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        margin-bottom: 15px;
    }

    .stat-card.total .stat-icon {
        background: rgba(67, 97, 238, 0.1);
        color: #4361ee;
    }

    .stat-card.passed .stat-icon {
        background: rgba(6, 214, 160, 0.1);
        color: #06d6a0;
    }

    .stat-card.average .stat-icon {
        background: rgba(247, 37, 133, 0.1);
        color: #f72585;
    }

    .stat-value {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 5px;
    }

    .stat-label {
        color: var(--gray);
        font-size: 0.9rem;
        font-weight: 500;
    }

    /* Performance Chart Card */
    .chart-card {
        background: var(--white);
        border-radius: var(--border-radius-lg);
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: var(--shadow-md);
    }

    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .chart-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--dark);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .chart-title i {
        color: var(--primary);
    }

    .chart-legend {
        display: flex;
        gap: 20px;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
    }

    .legend-color {
        width: 12px;
        height: 12px;
        border-radius: 3px;
    }

    .legend-color.passed {
        background: #06d6a0;
    }

    .legend-color.failed {
        background: #ef476f;
    }

    .chart-container {
        height: 200px;
        display: flex;
        align-items: flex-end;
        gap: 15px;
        padding: 10px 0;
    }

    .chart-bar-wrapper {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
    }

    .chart-bar-group {
        width: 100%;
        display: flex;
        gap: 5px;
        height: 150px;
        align-items: flex-end;
    }

    .chart-bar {
        flex: 1;
        min-width: 20px;
        background: linear-gradient(to top, #4361ee, #4895ef);
        border-radius: 6px 6px 0 0;
        transition: height 0.3s ease;
        position: relative;
        cursor: pointer;
    }

    .chart-bar.passed {
        background: linear-gradient(to top, #06d6a0, #0fe6b0);
    }

    .chart-bar.failed {
        background: linear-gradient(to top, #ef476f, #ff6b91);
    }

    .chart-bar:hover {
        transform: scale(1.05);
        box-shadow: var(--shadow-md);
    }

    .chart-bar:hover .chart-tooltip {
        opacity: 1;
        transform: translateY(-30px);
    }

    .chart-tooltip {
        position: absolute;
        top: -25px;
        left: 50%;
        transform: translateX(-50%) translateY(0);
        background: var(--dark);
        color: var(--white);
        padding: 4px 8px;
        border-radius: var(--border-radius-sm);
        font-size: 0.75rem;
        white-space: nowrap;
        opacity: 0;
        transition: var(--transition);
        pointer-events: none;
        z-index: 10;
    }

    .chart-label {
        font-size: 0.8rem;
        color: var(--gray);
        text-align: center;
        max-width: 80px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* Filter Section */
    .filter-section {
        background: var(--white);
        border-radius: var(--border-radius-lg);
        padding: 20px;
        margin-bottom: 25px;
        box-shadow: var(--shadow-md);
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        align-items: center;
    }

    .filter-group {
        display: flex;
        align-items: center;
        gap: 10px;
        flex: 1;
        min-width: 200px;
    }

    .filter-icon {
        color: var(--primary);
        font-size: 1rem;
    }

    .filter-select {
        flex: 1;
        padding: 10px 15px;
        border: 2px solid var(--gray-light);
        border-radius: var(--border-radius-md);
        font-size: 0.95rem;
        background: var(--white);
        cursor: pointer;
        transition: var(--transition);
    }

    .filter-select:focus {
        outline: none;
        border-color: var(--primary);
    }

    .filter-search {
        flex: 2;
        position: relative;
    }

    .filter-search input {
        width: 100%;
        padding: 10px 15px 10px 40px;
        border: 2px solid var(--gray-light);
        border-radius: var(--border-radius-md);
        font-size: 0.95rem;
        transition: var(--transition);
    }

    .filter-search input:focus {
        outline: none;
        border-color: var(--primary);
    }

    .filter-search i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gray);
    }

    /* Table Card */
    .table-card {
        background: var(--white);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-lg);
        overflow: hidden;
    }

    .table-header {
        padding: 20px 25px;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-bottom: 1px solid var(--gray-light);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }

    .table-header h3 {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--dark);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .table-header i {
        color: var(--primary);
    }

    .export-btn {
        padding: 8px 20px;
        background: var(--white);
        color: var(--primary);
        border: 2px solid var(--primary);
        border-radius: var(--border-radius-full);
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .export-btn:hover {
        background: var(--primary);
        color: var(--white);
        transform: translateY(-2px);
    }

    /* Table Styles */
    .table-responsive {
        overflow-x: auto;
    }

    .quiz-table {
        width: 100%;
        border-collapse: collapse;
    }

    .quiz-table thead {
        background: var(--light);
    }

    .quiz-table th {
        padding: 18px 20px;
        text-align: left;
        font-weight: 600;
        color: var(--dark);
        font-size: 0.95rem;
        white-space: nowrap;
    }

    .quiz-table td {
        padding: 16px 20px;
        border-bottom: 1px solid var(--gray-light);
        color: var(--gray);
        font-size: 0.95rem;
    }

    .quiz-table tbody tr {
        transition: var(--transition);
    }

    .quiz-table tbody tr:hover {
        background: var(--light);
    }

    /* Quiz Info */
    .quiz-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .quiz-icon {
        width: 40px;
        height: 40px;
        background: var(--light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        font-size: 1.2rem;
    }

    .quiz-details h4 {
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 4px;
    }

    .quiz-details span {
        font-size: 0.8rem;
        color: var(--gray);
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* Attempt Badge */
    .attempt-badge {
        display: inline-block;
        padding: 4px 12px;
        background: var(--light);
        border-radius: var(--border-radius-full);
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--primary);
    }

    /* Score Styles */
    .score-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .score-circle::before {
        content: '';
        position: absolute;
        width: 40px;
        height: 40px;
        background: var(--white);
        border-radius: 50%;
    }

    .score-text {
        position: relative;
        z-index: 2;
        font-weight: 700;
        font-size: 0.9rem;
        color: var(--dark);
    }

    .score-percentage {
        font-weight: 700;
        color: var(--primary);
    }

    /* Result Badge */
    .result-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 15px;
        border-radius: var(--border-radius-full);
        font-size: 0.85rem;
        font-weight: 600;
    }

    .result-badge.passed {
        background: rgba(6, 214, 160, 0.1);
        color: #06d6a0;
    }

    .result-badge.failed {
        background: rgba(239, 71, 111, 0.1);
        color: #ef476f;
    }

    /* Action Buttons */
    .action-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        background: transparent;
        color: var(--primary);
        border: 2px solid var(--primary);
        border-radius: var(--border-radius-full);
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
    }

    .action-btn:hover {
        background: var(--primary);
        color: var(--white);
        transform: translateX(3px);
    }

    .action-btn i {
        font-size: 0.8rem;
    }

    .retry-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        background: var(--success);
        color: var(--white);
        border: none;
        border-radius: var(--border-radius-full);
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
        margin-left: 8px;
    }

    .retry-btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-icon {
        width: 100px;
        height: 100px;
        background: var(--light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px;
        font-size: 3rem;
        color: var(--gray);
        animation: float 6s ease-in-out infinite;
    }

    .empty-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 10px;
    }

    .empty-text {
        color: var(--gray);
        margin-bottom: 25px;
        font-size: 1rem;
    }

    .empty-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 12px 30px;
        background: var(--gradient-1);
        color: var(--white);
        border-radius: var(--border-radius-full);
        text-decoration: none;
        font-weight: 600;
        transition: var(--transition);
    }

    .empty-btn:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-lg);
    }

    /* Pagination */
    .pagination {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-top: 30px;
    }

    .page-item {
        list-style: none;
    }

    .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 40px;
        padding: 0 10px;
        background: var(--white);
        border: 2px solid var(--gray-light);
        border-radius: var(--border-radius-md);
        color: var(--dark);
        text-decoration: none;
        transition: var(--transition);
        font-weight: 500;
    }

    .page-link:hover {
        background: var(--primary);
        color: var(--white);
        border-color: var(--primary);
    }

    .page-item.active .page-link {
        background: var(--primary);
        color: var(--white);
        border-color: var(--primary);
    }

    .page-item.disabled .page-link {
        background: var(--light);
        color: var(--gray);
        pointer-events: none;
        border-color: var(--gray-light);
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .filter-section {
            flex-direction: column;
        }

        .filter-group {
            width: 100%;
        }

        .table-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .quiz-table th,
        .quiz-table td {
            padding: 12px 15px;
        }

        .action-btn, .retry-btn {
            padding: 6px 12px;
            font-size: 0.8rem;
        }
    }
</style>
@endpush

@section('content')
    <!-- Quizzes Container -->
    <div class="quizzes-container">
        <div class="container">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-lg-3 mb-4 mb-lg-0">
                    <div class="quizzes-sidebar" data-aos="fade-right">
                        <div class="sidebar-header">
                            <h3 class="sidebar-title">
                                <i class="fas fa-puzzle-piece"></i>
                                My Learning
                            </h3>
                        </div>

                        <div class="sidebar-nav">
                            <a href="{{ route('dashboard') }}" class="nav-item">
                                <i class="fas fa-home"></i>
                                <span>Dashboard</span>
                            </a>
                            <a href="{{ route('my-courses') }}" class="nav-item">
                                <i class="fas fa-book"></i>
                                <span>My Courses</span>
                            </a>
                            <a href="{{ route('my-quizzes') }}" class="nav-item active">
                                <i class="fas fa-question-circle"></i>
                                <span>My Quizzes</span>
                                @if(($attempts->total() ?? 0) > 0)
                                    <span class="nav-badge">{{ $attempts->total() }}</span>
                                @endif
                            </a>
                            <a href="{{ route('certificates') }}" class="nav-item">
                                <i class="fas fa-certificate"></i>
                                <span>Certificates</span>
                            </a>
                        </div>

                        <!-- Quick Stats -->
                        <div class="sidebar-header" style="border-radius: 0; border-top: 1px solid var(--gray-light);">
                            <h3 class="sidebar-title">
                                <i class="fas fa-chart-pie"></i>
                                Performance
                            </h3>
                        </div>
                        <div class="p-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Average Score</span>
                                <span class="fw-bold">{{ $averageScore ?? 0 }}%</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Pass Rate</span>
                                <span class="fw-bold text-success">{{ $passRate ?? 0 }}%</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">Best Score</span>
                                <span class="fw-bold text-primary">{{ $bestScore ?? 0 }}%</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-lg-9">
                    <!-- Page Header -->
                    <div class="page-header" data-aos="fade-up">
                        <h1 class="page-title">
                            <i class="fas fa-puzzle-piece"></i>
                            My Quiz Attempts
                        </h1>
                        
                        <div class="stats-badge">
                            <i class="fas fa-chart-line"></i>
                            {{ $attempts->total() ?? 0 }} Total Attempts
                        </div>
                    </div>

                    <!-- Stats Cards -->
                    <div class="stats-grid" data-aos="fade-up">
                        <div class="stat-card total">
                            <div class="stat-icon">
                                <i class="fas fa-puzzle-piece"></i>
                            </div>
                            <div class="stat-value">{{ $totalQuizzes ?? 0 }}</div>
                            <div class="stat-label">Quizzes Taken</div>
                        </div>

                        <div class="stat-card passed">
                            <div class="stat-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="stat-value">{{ $passedQuizzes ?? 0 }}</div>
                            <div class="stat-label">Passed</div>
                        </div>

                        <div class="stat-card average">
                            <div class="stat-icon">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="stat-value">{{ $averageScore ?? 0 }}%</div>
                            <div class="stat-label">Average Score</div>
                        </div>
                    </div>

                    <!-- Performance Chart -->
                    @if(($attempts ?? collect())->count() > 0)
                        <div class="chart-card" data-aos="fade-up">
                            <div class="chart-header">
                                <h3 class="chart-title">
                                    <i class="fas fa-chart-bar"></i>
                                    Recent Performance
                                </h3>
                                <div class="chart-legend">
                                    <div class="legend-item">
                                        <span class="legend-color passed"></span>
                                        <span>Passed</span>
                                    </div>
                                    <div class="legend-item">
                                        <span class="legend-color failed"></span>
                                        <span>Failed</span>
                                    </div>
                                </div>
                            </div>
                            <div class="chart-container">
                                @foreach($recentAttempts ?? [] as $attempt)
                                    <div class="chart-bar-wrapper">
                                        <div class="chart-bar-group">
                                            <div class="chart-bar {{ $attempt->passed ? 'passed' : 'failed' }}" 
                                                 style="height: {{ $attempt->percentage }}px"
                                                 data-score="{{ $attempt->percentage }}%">
                                                <div class="chart-tooltip">
                                                    Score: {{ $attempt->percentage }}%
                                                </div>
                                            </div>
                                        </div>
                                        <span class="chart-label">{{ \Carbon\Carbon::parse($attempt->created_at)->format('M d') }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Filter Section -->
                    <div class="filter-section" data-aos="fade-up">
                        <div class="filter-group">
                            <i class="fas fa-filter filter-icon"></i>
                            <select class="filter-select" id="resultFilter">
                                <option value="">All Results</option>
                                <option value="passed">Passed</option>
                                <option value="failed">Failed</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <i class="fas fa-sort filter-icon"></i>
                            <select class="filter-select" id="sortFilter">
                                <option value="recent">Most Recent</option>
                                <option value="score-high">Highest Score</option>
                                <option value="score-low">Lowest Score</option>
                            </select>
                        </div>
                        <div class="filter-search">
                            <i class="fas fa-search"></i>
                            <input type="text" id="searchInput" placeholder="Search quizzes...">
                        </div>
                    </div>

                    <!-- Quiz Attempts Table -->
                    @if(($attempts ?? collect())->count() > 0)
                        <div class="table-card" data-aos="fade-up">
                            <div class="table-header">
                                <h3>
                                    <i class="fas fa-history"></i>
                                    Attempt History
                                </h3>
                                <button class="export-btn" onclick="exportTableToCSV()">
                                    <i class="fas fa-download"></i>
                                    Export Results
                                </button>
                            </div>

                            <div class="table-responsive">
                                <table class="quiz-table" id="quizTable">
                                    <thead>
                                        <tr>
                                            <th>Quiz</th>
                                            <th>Attempt</th>
                                            <th>Score</th>
                                            <th>Result</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="quizTableBody">
                                        @foreach($attempts as $attempt)
                                            <tr class="quiz-row" 
                                                data-result="{{ $attempt->passed ? 'passed' : 'failed' }}"
                                                data-score="{{ $attempt->percentage }}"
                                                data-date="{{ $attempt->created_at->timestamp }}">
                                                <td>
                                                    <div class="quiz-info">
                                                        <div class="quiz-icon">
                                                            <i class="fas fa-question"></i>
                                                        </div>
                                                        <div class="quiz-details">
                                                            <h4>{{ $attempt->quiz->title ?? 'Quiz Title' }}</h4>
                                                            <span>
                                                                <i class="fas fa-clock"></i>
                                                                {{ $attempt->quiz->duration ?? '15 min' }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="attempt-badge">
                                                        Attempt #{{ $attempt->attempt_number ?? 1 }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="score-circle" style="background: conic-gradient(from 0deg, {{ $attempt->passed ? '#06d6a0' : '#ef476f' }} 0deg, {{ $attempt->passed ? '#06d6a0' : '#ef476f' }} {{ ($attempt->percentage ?? 0) * 3.6 }}deg, #e9ecef {{ ($attempt->percentage ?? 0) * 3.6 }}deg)">
                                                            <span class="score-text">{{ $attempt->percentage ?? 0 }}%</span>
                                                        </div>
                                                        <span class="score-percentage">{{ $attempt->percentage ?? 0 }}%</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="result-badge {{ $attempt->passed ? 'passed' : 'failed' }}">
                                                        <i class="fas {{ $attempt->passed ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                                        {{ $attempt->passed ? 'Passed' : 'Failed' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <i class="far fa-calendar-alt me-1"></i>
                                                    {{ \Carbon\Carbon::parse($attempt->created_at)->format('M d, Y') }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('quizzes.results', ['quiz' => $attempt->quiz->id ?? '#', 'attempt' => $attempt->id ?? '#']) }}" 
                                                       class="action-btn">
                                                        <i class="fas fa-eye"></i>
                                                        View
                                                    </a>
                                                    @if(!$attempt->passed)
                                                        <a href="{{ route('quizzes.take', $attempt->quiz->id ?? '#') }}" 
                                                           class="retry-btn">
                                                            <i class="fas fa-redo-alt"></i>
                                                            Retry
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Pagination -->
                        @if($attempts->hasPages())
                            <div class="pagination">
                                {{ $attempts->appends(request()->query())->links() }}
                            </div>
                        @endif
                    @else
                        <!-- Empty State -->
                        <div class="empty-state" data-aos="fade-up">
                            <div class="empty-icon">
                                <i class="fas fa-puzzle-piece"></i>
                            </div>
                            <h3 class="empty-title">No Quiz Attempts Yet</h3>
                            <p class="empty-text">
                                You haven't taken any quizzes yet. Start testing your knowledge today!
                            </p>
                            <a href="#" class="empty-btn">
                                <i class="fas fa-play"></i>
                                Browse Quizzes
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const resultFilter = document.getElementById('resultFilter');
            const sortFilter = document.getElementById('sortFilter');
            const searchInput = document.getElementById('searchInput');
            const tableBody = document.getElementById('quizTableBody');
            const rows = document.querySelectorAll('.quiz-row');

            // Filter by result
            if (resultFilter) {
                resultFilter.addEventListener('change', filterAndSortRows);
            }

            // Sort rows
            if (sortFilter) {
                sortFilter.addEventListener('change', filterAndSortRows);
            }

            // Search functionality
            if (searchInput) {
                searchInput.addEventListener('input', filterAndSortRows);
            }

            function filterAndSortRows() {
                let filteredRows = Array.from(rows);
                
                // Apply result filter
                const resultValue = resultFilter?.value;
                if (resultValue) {
                    filteredRows = filteredRows.filter(row => 
                        row.dataset.result === resultValue
                    );
                }

                // Apply search filter
                const searchValue = searchInput?.value.toLowerCase().trim();
                if (searchValue) {
                    filteredRows = filteredRows.filter(row => {
                        const quizTitle = row.querySelector('.quiz-details h4')?.textContent.toLowerCase() || '';
                        return quizTitle.includes(searchValue);
                    });
                }

                // Apply sorting
                const sortValue = sortFilter?.value;
                if (sortValue) {
                    filteredRows.sort((a, b) => {
                        if (sortValue === 'score-high') {
                            return b.dataset.score - a.dataset.score;
                        } else if (sortValue === 'score-low') {
                            return a.dataset.score - b.dataset.score;
                        } else if (sortValue === 'recent') {
                            return b.dataset.date - a.dataset.date;
                        }
                    });
                }

                // Update table
                tableBody.innerHTML = '';
                filteredRows.forEach(row => tableBody.appendChild(row));

                // Show empty message if no rows
                if (filteredRows.length === 0) {
                    const emptyRow = document.createElement('tr');
                    emptyRow.innerHTML = `
                        <td colspan="6" style="text-align: center; padding: 40px;">
                            <i class="fas fa-search" style="font-size: 2rem; color: var(--gray); margin-bottom: 10px;"></i>
                            <p style="color: var(--gray);">No matching quiz attempts found</p>
                        </td>
                    `;
                    tableBody.appendChild(emptyRow);
                }
            }

            // Export to CSV
            window.exportTableToCSV = function() {
                const rows = document.querySelectorAll('.quiz-row');
                const csv = [];
                
                // Headers
                csv.push(['Quiz', 'Attempt', 'Score', 'Result', 'Date']);
                
                // Data
                rows.forEach(row => {
                    const quizTitle = row.querySelector('.quiz-details h4')?.textContent || '';
                    const attempt = row.querySelector('.attempt-badge')?.textContent.replace('Attempt #', '') || '';
                    const score = row.querySelector('.score-percentage')?.textContent || '';
                    const result = row.querySelector('.result-badge')?.textContent.trim() || '';
                    const date = row.querySelector('td:nth-child(5)')?.textContent.replace(/\s+/g, ' ').trim() || '';
                    
                    csv.push([quizTitle, attempt, score, result, date]);
                });
                
                // Convert to CSV string
                const csvString = csv.map(row => row.join(',')).join('\n');
                
                // Download
                const blob = new Blob([csvString], { type: 'text/csv' });
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'quiz-attempts.csv';
                a.click();
            };

            // Chart tooltips
            document.querySelectorAll('.chart-bar').forEach(bar => {
                bar.addEventListener('mouseenter', function() {
                    const tooltip = this.querySelector('.chart-tooltip');
                    if (tooltip) {
                        tooltip.style.opacity = '1';
                        tooltip.style.transform = 'translateY(-30px)';
                    }
                });
                
                bar.addEventListener('mouseleave', function() {
                    const tooltip = this.querySelector('.chart-tooltip');
                    if (tooltip) {
                        tooltip.style.opacity = '0';
                        tooltip.style.transform = 'translateY(0)';
                    }
                });
            });

            // Animation on scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Observe elements
            document.querySelectorAll('.stat-card, .chart-card, .filter-section, .table-card').forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                observer.observe(el);
            });
        });
    </script>
    @endpush
@endsection