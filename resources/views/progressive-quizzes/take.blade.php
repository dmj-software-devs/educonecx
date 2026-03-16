@extends('layouts.main')

@section('title', $progressiveQuiz->title . ' - Level ' . $level->level_number)

@section('meta_description', 'Take Level ' . $level->level_number . ' of ' . $progressiveQuiz->title)

@push('styles')
<style>
    /* ===== PROGRESSIVE QUIZ TAKE PAGE STYLES ===== */
    :root {
        --bright-amber: #FBC60C;
        --khaki-beige: #9F9A87;
        --pure-white: #FEFDFE;
        --prussian-blue: #0A1D44;
        --regal-navy: #18386E;
        --sky-blue: #5AD1E4;
        --pale-slate: #CBD1DA;
        --dark-slate: #2E5C61;
        --ivory: #F9F7E9;
        --light-gold: #EBD789;
        --primary: var(--regal-navy);
        --primary-light: var(--dark-slate);
        --accent: var(--bright-amber);
        --accent-soft: var(--light-gold);
        --success: var(--sky-blue);
        --danger: #ef4444;
        --warning: var(--bright-amber);
        --dark: var(--prussian-blue);
        --gray: var(--khaki-beige);
        --gray-light: var(--pale-slate);
        --light: var(--ivory);
        --white: var(--pure-white);
        --text-primary: var(--prussian-blue);
        --text-muted: #5f5f5f;
        --gradient-primary: linear-gradient(135deg, #0A1D44 0%, #18386E 50%, #2E5C61 100%);
        --gradient-accent: linear-gradient(45deg, #FBC60C 0%, #EBD789 50%, #F9F7E9 100%);
        --gradient-secondary: linear-gradient(135deg, #5AD1E4 0%, #CBD1DA 50%, #FEFDFE 100%);
        --shadow-sm: 0 2px 8px rgba(10, 29, 68, 0.08);
        --shadow-md: 0 4px 12px rgba(10, 29, 68, 0.12);
        --shadow-lg: 0 8px 24px rgba(10, 29, 68, 0.15);
        --radius-sm: 12px;
        --radius-md: 16px;
        --radius-lg: 24px;
        --radius-full: 9999px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        --sidebar-width: 280px;
    }

    /* ===== MAIN CONTAINER ===== */
    .quiz-page {
        padding: 0px 0;
        min-height: calc(100vh - 200px);
        background-color: var(--ivory);
    }

    .quiz-grid {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        gap: 30px;
    }

    .quiz-main {
        max-width: 800px;
        width: 100%;
        min-width: 0;
    }

    /* ===== LEVEL HEADER - THIN LINE STYLE ===== */
    .level-header {
        border-bottom: 1px solid var(--pale-slate);
        padding: 16px 0;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: transparent;
        box-shadow: none;
    }

    .level-header::before,
    .level-header::after {
        display: none;
    }

    .level-badge {
        display: none;
    }

    .level-title {
        font-size: 1.5rem;
        font-weight: 500;
        color: var(--text-primary);
        margin: 0;
        text-shadow: none;
    }

    .quiz-meta {
        display: flex;
        align-items: center;
        gap: 20px;
        color: var(--text-muted);
    }

    .quiz-meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.95rem;
    }

    .quiz-meta-item i {
        color: var(--bright-amber);
    }

    .progress-section {
        width: 200px;
    }

    .progress-stats {
        display: flex;
        justify-content: space-between;
        color: var(--text-muted);
        font-size: 0.85rem;
        margin-bottom: 4px;
    }

    .progress-bar-custom {
        height: 4px;
        background: var(--pale-slate);
        border-radius: var(--radius-full);
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: var(--bright-amber);
        border-radius: var(--radius-full);
        transition: width 0.5s ease;
    }

    .progress-fill::after {
        display: none;
    }

    /* ===== QUESTION TIMER ===== */
    .timer-wrapper {
        margin-bottom: 20px;
    }

    .question-timer {
        background: var(--white);
        border-radius: var(--radius-full);
        padding: 8px 20px;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        box-shadow: var(--shadow-md);
        border: 2px solid var(--bright-amber);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .question-timer::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        background: rgba(251, 198, 12, 0.12);
        border-radius: var(--radius-full);
        transition: width 1s linear;
        width: var(--timer-progress, 100%);
    }

    .question-timer.warning {
        border-color: var(--danger);
        background: #fff5f5;
        animation: pulse 0.8s infinite;
    }

    .question-timer.warning::before {
        background: rgba(239, 68, 68, 0.1);
    }

    .question-timer.critical {
        border-color: var(--danger);
        background: #fee2e2;
        animation: pulse 0.4s infinite;
    }

    .question-timer.critical::before {
        background: rgba(239, 68, 68, 0.15);
    }

    .question-timer i {
        color: var(--prussian-blue);
        position: relative;
        z-index: 1;
    }

    .question-timer.warning i,
    .question-timer.critical i {
        color: var(--danger);
    }

    .timer-display {
        font-size: 1.4rem;
        font-weight: 800;
        color: var(--prussian-blue);
        font-variant-numeric: tabular-nums;
        min-width: 2ch;
        text-align: center;
        position: relative;
        z-index: 1;
    }

    .question-timer.warning .timer-display,
    .question-timer.critical .timer-display {
        color: var(--danger);
    }

    .timer-label {
        color: var(--text-muted);
        font-size: 0.9rem;
        position: relative;
        z-index: 1;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.02); }
    }

    /* ===== QUESTION CARD ===== */
    .question-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 30px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--pale-slate);
        margin-bottom: 30px;
        margin-left: 250px;
    }

    .question-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 25px;
        padding-bottom: 20px;
        border-bottom: 2px solid var(--pale-slate);
        flex-wrap: wrap;
    }

    .question-badge {
        background: var(--gradient-primary);
        color: var(--white);
        padding: 6px 16px;
        border-radius: var(--radius-full);
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .question-points {
        background: var(--gradient-accent);
        color: var(--prussian-blue);
        padding: 6px 16px;
        border-radius: var(--radius-full);
        font-size: 0.95rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .question-points i {
        color: var(--prussian-blue);
    }

    .question-text {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 30px;
        line-height: 1.5;
    }

    /* ===== MCQ OPTIONS ===== */
    .mcq-container {
        display: flex;
        flex-direction: column;
        gap: 16px;
        margin: 24px 0;
    }

    .mcq-option {
        position: relative;
        cursor: pointer;
        transition: var(--transition);
    }

    .mcq-option input {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    .mcq-option .option-content {
        display: flex;
        align-items: center;
        padding: 20px 24px;
        background: var(--white);
        border: 2px solid var(--pale-slate);
        border-radius: var(--radius-md);
        transition: all 0.2s ease;
        position: relative;
        overflow: hidden;
    }

    .option-marker {
        width: 40px;
        height: 40px;
        border-radius: var(--radius-full);
        background: var(--ivory);
        color: var(--text-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.1rem;
        margin-right: 16px;
        transition: var(--transition);
        border: 2px solid var(--pale-slate);
        flex-shrink: 0;
    }

    .option-text {
        font-size: 1.1rem;
        color: var(--text-primary);
        font-weight: 500;
        flex: 1;
        line-height: 1.5;
    }

    .mcq-option:hover .option-content {
        border-color: var(--bright-amber);
        background: var(--ivory);
        transform: translateX(5px);
        box-shadow: var(--shadow-md);
    }

    .mcq-option:hover .option-marker {
        background: var(--bright-amber);
        border-color: var(--bright-amber);
        color: var(--prussian-blue);
    }

    .mcq-option input[type="radio"]:checked + .option-content,
    .mcq-option input[type="checkbox"]:checked + .option-content {
        border-color: var(--bright-amber);
        background: linear-gradient(135deg, rgba(251, 198, 12, 0.05), rgba(249, 247, 233, 0.5));
        box-shadow: 0 0 0 4px rgba(251, 198, 12, 0.15);
    }

    .mcq-option input[type="radio"]:checked + .option-content .option-marker,
    .mcq-option input[type="checkbox"]:checked + .option-content .option-marker {
        background: var(--bright-amber);
        border-color: var(--bright-amber);
        color: var(--prussian-blue);
        position: relative;
    }

    .mcq-option input[type="radio"]:checked + .option-content .option-marker::after,
    .mcq-option input[type="checkbox"]:checked + .option-content .option-marker::after {
        content: '✓';
        position: absolute;
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--prussian-blue);
    }

    .mcq-option input[type="radio"]:checked + .option-content .option-marker span,
    .mcq-option input[type="checkbox"]:checked + .option-content .option-marker span {
        opacity: 0;
    }

    .mcq-option input[type="checkbox"] + .option-content .option-marker {
        border-radius: 8px;
    }

    /* ===== FILL BLANK ===== */
    .fill-blank-container {
        margin: 30px 0;
    }

    .fill-blank-input {
        width: 100%;
        padding: 16px 20px;
        border: 2px solid var(--pale-slate);
        border-radius: var(--radius-md);
        font-size: 1.1rem;
        transition: var(--transition);
    }

    .fill-blank-input:focus {
        border-color: var(--bright-amber);
        outline: none;
        box-shadow: 0 0 0 4px rgba(251, 198, 12, 0.15);
    }

    /* ===== MATCHING ===== */
    .matching-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
        margin: 30px 0;
    }

    .matching-item {
        display: flex;
        align-items: center;
        gap: 20px;
        background: var(--ivory);
        padding: 15px 20px;
        border-radius: var(--radius-md);
        border: 2px solid var(--pale-slate);
    }

    .matching-left {
        flex: 1;
        font-weight: 600;
        color: var(--text-primary);
    }

    .matching-arrow {
        color: var(--bright-amber);
        font-size: 1.2rem;
    }

    .matching-right select {
        width: 200px;
        padding: 12px 16px;
        border: 2px solid var(--pale-slate);
        border-radius: var(--radius-md);
        font-size: 1rem;
        transition: var(--transition);
    }

    .matching-right select:focus {
        border-color: var(--bright-amber);
        outline: none;
        box-shadow: 0 0 0 4px rgba(251, 198, 12, 0.15);
    }

    /* ===== IMAGE SELECTION ===== */
    .image-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 20px;
        margin: 30px 0;
    }

    .image-option {
        position: relative;
        cursor: pointer;
    }

    .image-option input {
        position: absolute;
        opacity: 0;
    }

    .image-content {
        border: 3px solid var(--pale-slate);
        border-radius: var(--radius-md);
        overflow: hidden;
        transition: var(--transition);
    }

    .image-content img {
        width: 100%;
        height: 120px;
        object-fit: cover;
    }

    .image-label {
        padding: 10px;
        text-align: center;
        background: var(--ivory);
        font-size: 0.9rem;
    }

    .image-option input:checked + .image-content {
        border-color: var(--bright-amber);
        box-shadow: 0 0 0 4px rgba(251, 198, 12, 0.2);
    }

    .image-option input:checked + .image-content .image-label {
        background: var(--bright-amber);
        color: var(--prussian-blue);
        font-weight: 600;
    }

    /* ===== PRIMARY BUTTON ===== */
    .btn-next {
        width: 100%;
        padding: 16px 30px;
        background: var(--gradient-primary);
        color: var(--white);
        border: none;
        border-radius: var(--radius-md);
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        position: relative;
        overflow: hidden;
        margin-top: 30px;
    }

    .btn-next::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        transform: translate(-50%, -50%);
        transition: width 0.5s, height 0.5s;
    }

    .btn-next:hover::before {
        width: 400px;
        height: 400px;
    }

    .btn-next:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .btn-next:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .btn-next i {
        transition: transform 0.3s ease;
    }

    .btn-next:hover i {
        transform: translateX(5px);
    }

    /* ===== SIDEBAR ===== */
    .quiz-sidebar {
        position: sticky;
        top: 100px;
        width: var(--sidebar-width);
        flex-shrink: 0;
    }

    .sidebar-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 25px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--pale-slate);
        margin-bottom: 20px;
    }

    .sidebar-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        transition: var(--transition);
    }

    .sidebar-title:hover {
        color: var(--bright-amber);
    }

    .sidebar-title i {
        color: var(--bright-amber);
    }

    .chevron {
        margin-left: auto;
        transition: transform 0.3s ease;
    }

    .chevron.rotated {
        transform: rotate(180deg);
    }

    /* ===== STATISTICS ===== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
        margin-top: 20px;
    }

    .stat-item {
        background: var(--ivory);
        padding: 15px;
        border-radius: var(--radius-md);
        text-align: center;
    }

    .stat-label {
        font-size: 0.8rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 5px;
        display: block;
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--prussian-blue);
        line-height: 1.2;
    }

    .stat-value.small {
        font-size: 1.1rem;
    }

    /* ===== QUESTION NAVIGATOR ===== */
    .navigator-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 8px;
        margin-top: 20px;
    }

    .nav-item {
        aspect-ratio: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--white);
        border: 2px solid var(--pale-slate);
        border-radius: var(--radius-sm);
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--text-muted);
        transition: var(--transition);
        cursor: default;
    }

    .nav-item.answered {
        background: var(--success);
        border-color: var(--success);
        color: var(--prussian-blue);
    }

    .nav-item.current {
        border-color: var(--bright-amber);
        background: var(--bright-amber);
        color: var(--prussian-blue);
        font-weight: 700;
        transform: scale(1.05);
        box-shadow: 0 0 0 3px rgba(251, 198, 12, 0.2);
    }

    /* ===== RESTART BUTTON ===== */
    .btn-restart-sidebar {
        width: 100%;
        padding: 12px;
        background: transparent;
        border: 2px solid var(--pale-slate);
        border-radius: var(--radius-md);
        color: var(--text-muted);
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-top:15px;
    }

    .btn-restart-sidebar:hover {
        border-color: var(--bright-amber);
        color: var(--prussian-blue);
        background: var(--ivory);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    /* ===== EMPTY STATE ===== */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: var(--white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        margin-bottom: 30px;
    }

    .empty-icon {
        width: 100px;
        height: 100px;
        background: var(--ivory);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 3rem;
        color: var(--bright-amber);
        animation: float 6s ease-in-out infinite;
    }

    .empty-state h3 {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 10px;
        color: var(--prussian-blue);
    }

    .empty-state p {
        color: var(--text-muted);
        font-size: 1.1rem;
        margin-bottom: 20px;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 30px;
        background: var(--gradient-primary);
        color: var(--white);
        border: none;
        border-radius: var(--radius-full);
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        text-decoration: none;
    }

    .btn-back:hover {
        background: var(--gradient-accent);
        color: var(--prussian-blue);
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    /* ===== MODAL ===== */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(10, 29, 68, 0.5);
        align-items: center;
        justify-content: center;
        z-index: 9999;
        backdrop-filter: blur(5px);
    }

    .modal-overlay.active {
        display: flex;
    }

    .modal-content {
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 30px;
        max-width: 400px;
        width: 90%;
        box-shadow: var(--shadow-lg);
        animation: modalSlideIn 0.3s ease;
    }

    .modal-icon {
        width: 60px;
        height: 60px;
        background: #fef3c7;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        color: var(--warning);
        font-size: 2rem;
    }

    .modal-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--prussian-blue);
        margin-bottom: 10px;
        text-align: center;
    }

    .modal-text {
        color: var(--text-muted);
        text-align: center;
        margin-bottom: 25px;
        line-height: 1.6;
    }

    .modal-actions {
        display: flex;
        gap: 12px;
    }

    .modal-btn {
        flex: 1;
        padding: 12px;
        border: none;
        border-radius: var(--radius-md);
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
    }

    .modal-btn.cancel {
        background: var(--pale-slate);
        color: var(--text-primary);
    }

    .modal-btn.cancel:hover {
        background: var(--gray);
    }

    .modal-btn.confirm {
        background: var(--warning);
        color: var(--prussian-blue);
    }

    .modal-btn.confirm:hover {
        background: var(--bright-amber);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    /* ===== LOADING ===== */
    .loading-toast {
        position: fixed;
        top: 20px;
        right: 20px;
        background: var(--gradient-accent);
        color: var(--prussian-blue);
        padding: 12px 24px;
        border-radius: var(--radius-full);
        box-shadow: var(--shadow-lg);
        display: flex;
        align-items: center;
        gap: 12px;
        z-index: 10000;
        border: 1px solid rgba(255, 255, 255, 0.2);
        animation: slideIn 0.3s ease;
    }

    .spinner {
        width: 18px;
        height: 18px;
        border: 2px solid rgba(10, 29, 68, 0.2);
        border-top-color: var(--prussian-blue);
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    @keyframes slideIn {
        from { opacity: 0; transform: translateX(100%); }
        to { opacity: 1; transform: translateX(0); }
    }

    @keyframes modalSlideIn {
        from { opacity: 0; transform: translateY(-50px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 1024px) {
        .quiz-grid {
            flex-direction: column;
            align-items: center;
        }
        .quiz-sidebar {
            position: static;
            width: 100%;
            max-width: 800px;
        }
        .navigator-grid {
            grid-template-columns: repeat(8, 1fr);
        }
    }

    @media (max-width: 768px) {
        .quiz-page { padding: 20px 0; }
        .level-header { 
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }
        .progress-section { width: 100%; }
        .question-card { padding: 20px; }
        .question-text { font-size: 1.2rem; }
        .option-marker { width: 36px; height: 36px; }
        .option-text { font-size: 1rem; }
        .navigator-grid { grid-template-columns: repeat(6, 1fr); }
        .matching-item { flex-direction: column; align-items: flex-start; }
        .matching-arrow { transform: rotate(90deg); }
        .matching-right select { width: 100%; }
    }

    @media (max-width: 576px) {
        .question-header { flex-direction: column; align-items: flex-start; }
        .option-marker { width: 32px; height: 32px; font-size: 0.9rem; }
        .navigator-grid { grid-template-columns: repeat(4, 1fr); }
        .modal-actions { flex-direction: column; }
        .image-grid { grid-template-columns: repeat(2, 1fr); }
    }

    .accordion-content {
        display: none;
    }

    .accordion-content.active {
        display: block;
    }
</style>
@endpush

@section('content')
<div class="quiz-page">
    <div class="container">
        <!-- Loading Toast -->
        <div class="loading-toast" id="submittingToast" style="display: none;">
            <div class="spinner"></div>
            <span>Submitting answer...</span>
        </div>

        @php
            $letters = range('A', 'Z');
            // $questions is UNANSWERED questions — always first() not [$answeredCount]
            $currentQuestion = $questions && $questions->isNotEmpty() ? $questions->first() : null;
            $isLevelComplete = !$currentQuestion || $totalQuestions == 0;
            $quizAttempt = $levelAttempt->progressiveQuizAttempt ?? null;
        @endphp

        @if($isLevelComplete)
            <!-- Level Complete - No Questions or All Questions Answered -->
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-trophy"></i>
                </div>
                <h3>Level {{ $level->level_number }} Complete!</h3>
                <p class="mb-4">
                    @if($totalQuestions == 0)
                        This level has no questions yet. Please check back later.
                    @else
                        You have completed all {{ $totalQuestions }} questions in this level!
                        @if($levelAttempt->passed)
                            <br><strong>You passed with {{ $levelAttempt->percentage }}%!</strong>
                        @else
                            <br><strong>You scored {{ $levelAttempt->percentage }}%. You need {{ $level->min_percentage }}% to pass.</strong>
                        @endif
                    @endif
                </p>
                
                @php
                    $nextLevel = $progressiveQuiz->getLevelByNumber($level->level_number + 1);
                @endphp
                
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    {{-- Only show next level link if user PASSED --}}
                    @if($levelAttempt->passed && $nextLevel)
                        <a href="{{ route('progressive-quizzes.take', ['progressiveQuiz' => $progressiveQuiz->id, 'level' => $nextLevel->id]) }}" class="btn-back">
                            <i class="fas fa-play"></i>
                            Continue to Level {{ $nextLevel->level_number }}
                        </a>
                    @elseif($levelAttempt->passed && !$nextLevel)
                        <a href="{{ route('progressive-quizzes.results', $progressiveQuiz) }}" class="btn-back">
                            <i class="fas fa-trophy"></i>
                            View Final Results
                        </a>
                    @elseif(!$levelAttempt->passed)
                        <a href="{{ route('progressive-quizzes.level-results', ['progressiveQuiz' => $progressiveQuiz->id, 'level' => $level->id]) }}" class="btn-back">
                            <i class="fas fa-chart-bar"></i>
                            View Results
                        </a>
                        <a href="{{ route('progressive-quizzes.show', $progressiveQuiz->slug) }}" class="btn-back" style="background: var(--gray-light); color: var(--text-primary);">
                            <i class="fas fa-redo"></i>
                            Try Again
                        </a>
                    @endif
                    
                    <a href="{{ route('progressive-quizzes.show', $progressiveQuiz->slug) }}" class="btn-back" style="background: var(--gray-light); color: var(--text-primary);">
                        <i class="fas fa-arrow-left"></i>
                        Back to Quiz Overview
                    </a>
                </div>
            </div>
        @else
            <!-- QUIZ TAKING VIEW -->
            <div class="quiz-grid">
                <!-- MAIN CONTENT -->
                <div class="quiz-main">
                    <!-- Level Header - Thin Line Style -->
                    <div class="level-header">
                        <h1 class="level-title">{{ $level->title }}</h1>
                        
                        <!-- <div class="quiz-meta">
                            <div class="quiz-meta-item">
                                <i class="fas fa-question-circle"></i>
                                <span>Question {{ $answeredCount + 1 }} of {{ $totalQuestions }}</span>
                            </div>
                            <div class="quiz-meta-item">
                                <i class="fas fa-stopwatch"></i>
                                <span>{{ $questionTimeLimit ?? 27 }}s per question</span>
                            </div>
                        </div> -->

                        <!-- Progress bar -->
                        <!-- <div class="progress-section">
                            <div class="progress-stats">
                                <span>{{ round($progress) }}%</span>
                            </div>
                            <div class="progress-bar-custom">
                                <div class="progress-fill" style="width: {{ $progress }}%;"></div>
                            </div>
                        </div> -->

                        <div class="question-timer" id="questionTimer">
                            <i class="far fa-hourglass"></i>
                            <span class="timer-display" id="timerDisplay">{{ $questionTimeLimit ?? 27 }}</span>
                            <span class="timer-label">seconds for this question</span>
                        </div>
                    </div>

                    <!-- Question Card -->
                    <div class="question-card">
                        <div class="question-header">
                            <span class="question-badge">
                                Question {{ $answeredCount + 1 }}
                            </span>
                            <span class="question-points">
                                <i class="fas fa-star"></i> {{ $currentQuestion->points }} pts
                            </span>
                        </div>
                        
                        <div class="question-text">
                            {{ $currentQuestion->question_text }}
                        </div>

                        @if($currentQuestion->image)
                        <div class="mb-4 text-center">
                            <img src="{{ Storage::url($currentQuestion->image) }}" alt="Question image" style="max-width: 100%; max-height: 300px; border-radius: var(--radius-md); box-shadow: var(--shadow-md);">
                        </div>
                        @endif

                        <!-- Answer Input Based on Question Type -->
                        <form id="quizForm">
                            @csrf
                            <input type="hidden" name="question_id" value="{{ $currentQuestion->id }}" id="questionId">

                            @if(in_array($currentQuestion->question_type, ['multiple_choice', 'single_choice', 'true_false']))
                                <div class="mcq-container">
                                    @foreach($currentQuestion->options as $index => $option)
                                    <label class="mcq-option">
                                        @if($currentQuestion->question_type == 'multiple_choice')
                                        <input type="checkbox" 
                                               name="answer[]" 
                                               value="{{ $option->id }}"
                                               class="option-input">
                                        @else
                                        <input type="radio" 
                                               name="answer" 
                                               value="{{ $option->id }}"
                                               class="option-input">
                                        @endif
                                        
                                        <div class="option-content">
                                            <div class="option-marker">
                                                <span>{{ $letters[$index] }}</span>
                                            </div>
                                            
                                            @if($option->image)
                                            <img src="{{ Storage::url($option->image) }}" alt="" style="width: 50px; height: 50px; object-fit: cover; border-radius: var(--radius-sm); margin-right: 16px;">
                                            @endif
                                            
                                            <span class="option-text">{{ $option->option_text }}</span>
                                        </div>
                                    </label>
                                    @endforeach
                                </div>

                            @elseif($currentQuestion->question_type == 'fill_blank')
                                <div class="fill-blank-container">
                                    <input type="text" 
                                           name="answer" 
                                           class="fill-blank-input" 
                                           placeholder="Type your answer here..."
                                           autocomplete="off">
                                </div>

                            @elseif($currentQuestion->question_type == 'matching')
                                <div class="matching-container">
                                    @foreach($currentQuestion->matchingPairs as $pair)
                                    <div class="matching-item">
                                        <div class="matching-left">{{ $pair->left_item }}</div>
                                        <div class="matching-arrow"><i class="fas fa-arrow-right"></i></div>
                                        <div class="matching-right">
                                            <select name="matching[{{ $pair->id }}]" class="matching-select">
                                                <option value="">Select match</option>
                                                @foreach($currentQuestion->matchingPairs->shuffle() as $option)
                                                <option value="{{ $option->right_item }}">{{ $option->right_item }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                            @elseif($currentQuestion->question_type == 'image_selection')
                                <div class="image-grid">
                                    @foreach($currentQuestion->options as $index => $option)
                                    <label class="image-option">
                                        <input type="checkbox" name="answer[]" value="{{ $option->id }}">
                                        <div class="image-content">
                                            @if($option->image)
                                            <img src="{{ Storage::url($option->image) }}" alt="{{ $option->option_text }}">
                                            @else
                                            <div style="height: 120px; background: var(--ivory); display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-image fa-3x" style="color: var(--gray);"></i>
                                            </div>
                                            @endif
                                            <div class="image-label">{{ $option->option_text }}</div>
                                        </div>
                                    </label>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Submit Button -->
                            <button type="submit" class="btn-next" id="submitBtn">
                                @if($answeredCount + 1 == $totalQuestions)
                                <span>Complete Level</span>
                                <i class="fas fa-check-circle"></i>
                                @else
                                <span>Next Question</span>
                                <i class="fas fa-arrow-right"></i>
                                @endif
                            </button>
                        </form>
                    </div>
                </div>

                <!-- SIDEBAR - ONLY RESTART BUTTON VISIBLE -->
                <div class="quiz-sidebar">
                    <!-- Restart Level Option -->
                    <button class="btn-restart-sidebar" onclick="showRestartModal()">
                        <i class="fas fa-redo-alt"></i>
                        Restart Level
                    </button>
                </div>
            </div>
        @endif

        <!-- Restart Modal -->
        <div class="modal-overlay" id="restartModal">
            <div class="modal-content">
                <div class="modal-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <h3 class="modal-title">Restart Level {{ $level->level_number }}?</h3>
                <p class="modal-text">Your progress in this level will be lost and you'll start from the first question again.</p>
                <div class="modal-actions">
                    <button class="modal-btn cancel" onclick="closeRestartModal()">Cancel</button>
                    <button class="modal-btn confirm" onclick="restartLevel()">Restart Level</button>
                </div>
            </div>
        </div>

        <!-- Level Complete Modal (auto-shown when level completes via AJAX) -->
        <div class="modal-overlay" id="levelCompleteModal">
            <div class="modal-content">
                <div class="modal-icon" style="color: var(--success);">
                    <i class="fas fa-trophy"></i>
                </div>
                <h3 class="modal-title">Level {{ $level->level_number }} Complete!</h3>
                <p class="modal-text" id="levelCompleteMessage">Loading results...</p>
                <div class="modal-actions">
                    <button class="modal-btn confirm" onclick="viewLevelResults()">View Results</button>
                </div>
            </div>
        </div>

        <!-- Hidden form for restart -->
        <form id="restartForm" method="POST" action="{{ route('progressive-quizzes.restart', $progressiveQuiz) }}" style="display: none;">
            @csrf
        </form>
    </div>
</div>

<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@push('scripts')
<script>
    // Configuration
    const CONFIG = {
        levelId: {{ $level->id }},
        levelNumber: {{ $level->level_number }},
        quizId: {{ $progressiveQuiz->id }},
        totalQuestions: {{ $totalQuestions }},
        answeredCount: {{ $answeredCount }},
        remainingTime: null,
        questionTimeLimit: {{ $questionTimeLimit ?? 27 }},
        submitUrl: "{{ route('progressive-quizzes.submit', ['progressiveQuiz' => $progressiveQuiz->id, 'level' => $level->id]) }}",
        levelResultsUrl: "{{ route('progressive-quizzes.level-results', ['progressiveQuiz' => $progressiveQuiz->id, 'level' => $level->id]) }}",
        restartUrl: "{{ route('progressive-quizzes.restart', $progressiveQuiz) }}"
    };

    // State
    let questionTimerInterval = null;
    let questionTimeLeft = CONFIG.questionTimeLimit;
    let isSubmitting = false;

    // DOM Elements
    const elements = {
        form: document.getElementById('quizForm'),
        submitBtn: document.getElementById('submitBtn'),
        toast: document.getElementById('submittingToast'),
        timer: document.getElementById('questionTimer'),
        timerDisplay: document.getElementById('timerDisplay'),
        restartModal: document.getElementById('restartModal'),
        levelCompleteModal: document.getElementById('levelCompleteModal'),
        navigatorGrid: document.getElementById('navigatorGrid')
    };

    console.log('CONFIG:', CONFIG);

    if (elements.form) {

        // ===== PER-QUESTION TIMER =====
        function startQuestionTimer() {
            if (questionTimerInterval) clearInterval(questionTimerInterval);
            questionTimeLeft = CONFIG.questionTimeLimit;
            updateQuestionTimerDisplay();
            updateTimerProgress();

            questionTimerInterval = setInterval(() => {
                questionTimeLeft--;
                updateQuestionTimerDisplay();
                updateTimerProgress();

                if (questionTimeLeft <= 10 && questionTimeLeft > 5) {
                    elements.timer?.classList.add('warning');
                    elements.timer?.classList.remove('critical');
                } else if (questionTimeLeft <= 5) {
                    elements.timer?.classList.remove('warning');
                    elements.timer?.classList.add('critical');
                }

                if (questionTimeLeft <= 0) {
                    clearInterval(questionTimerInterval);
                    questionTimerInterval = null;
                    autoSubmitQuestion();
                }
            }, 1000);
        }

        function updateQuestionTimerDisplay() {
            if (elements.timerDisplay) {
                elements.timerDisplay.textContent = questionTimeLeft;
            }
        }

        function updateTimerProgress() {
            if (elements.timer) {
                const pct = (questionTimeLeft / CONFIG.questionTimeLimit) * 100;
                elements.timer.style.setProperty('--timer-progress', pct + '%');
            }
        }

        function stopQuestionTimer() {
            if (questionTimerInterval) {
                clearInterval(questionTimerInterval);
                questionTimerInterval = null;
            }
        }

        function autoSubmitQuestion() {
            if (isSubmitting) return;
            showToast('⏰ Time\'s up! Moving on...', 'error');
            const questionId = document.getElementById('questionId')?.value;
            if (!questionId) return;
            const formData = new FormData();
            formData.append('question_id', questionId);
            formData.append('answer', '0');
            formData.append('time_spent', CONFIG.questionTimeLimit);
            formData.append('timeout', '1');
            submitAnswer(formData);
        }

        // Start timer immediately on page load
        startQuestionTimer();

        // ===== FORM SUBMISSION =====
        elements.form.addEventListener('submit', function(e) {
            e.preventDefault();
            if (isSubmitting) return;

            const questionId = document.getElementById('questionId').value;
            const formData = new FormData();
            formData.append('question_id', questionId);

            const answerInputs = document.querySelectorAll('[name="answer"], [name="answer[]"], [name^="matching["]');

            if (answerInputs.length === 0) {
                alert('Please select an answer');
                return;
            }

            const firstInput = answerInputs[0];

            if (firstInput.type === 'checkbox' && firstInput.name === 'answer[]') {
                const checkedBoxes = document.querySelectorAll('[name="answer[]"]:checked');
                if (checkedBoxes.length === 0) {
                    alert('Please select at least one option');
                    return;
                }
                checkedBoxes.forEach(box => formData.append('answer[]', box.value));
            }
            else if (firstInput.name === 'answer' && firstInput.type === 'radio') {
                const selectedRadio = document.querySelector('[name="answer"]:checked');
                if (!selectedRadio) {
                    alert('Please select an option');
                    return;
                }
                formData.append('answer', selectedRadio.value);
            }
            else if (firstInput.tagName === 'INPUT' && firstInput.type === 'text') {
                if (!firstInput.value.trim()) {
                    alert('Please enter an answer');
                    return;
                }
                formData.append('answer', firstInput.value.trim());
            }
            else if (firstInput.tagName === 'SELECT') {
                const selects = document.querySelectorAll('[name^="matching["]');
                let allSelected = true;
                selects.forEach(select => {
                    if (!select.value) allSelected = false;
                    formData.append(select.name, select.value);
                });
                if (!allSelected) {
                    alert('Please match all items');
                    return;
                }
            }

            // Record time spent on this question
            formData.append('time_spent', CONFIG.questionTimeLimit - questionTimeLeft);

            stopQuestionTimer();
            elements.submitBtn.disabled = true;
            elements.submitBtn.innerHTML = '<div class="spinner"></div> Submitting...';

            submitAnswer(formData);
        });
    }

    function submitAnswer(formData) {
        if (isSubmitting) return;
        isSubmitting = true;

        showToast('Submitting answer...');

        console.log('Submitting answer to:', CONFIG.submitUrl);
        for (let pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }

        fetch(CONFIG.submitUrl, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
        .then(response => {
            console.log('Response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            hideToast();
            isSubmitting = false;

            if (data.success) {
                if (data.level_completed) {
                    console.log('Level completed!', data);
                    stopQuestionTimer();
                    handleLevelComplete(data);
                } else {
                    if (data.is_correct) {
                        showToast('✓ Correct!', 'success');
                    } else {
                        showToast('✗ Incorrect', 'error');
                    }
                    updateNavigator();
                    // Reload for next question — timer resets automatically on page load
                    setTimeout(() => { location.reload(); }, 900);
                }
            } else {
                if (elements.submitBtn) {
                    elements.submitBtn.disabled = false;
                    elements.submitBtn.innerHTML = elements.submitBtn.innerHTML.includes('Complete')
                        ? 'Complete Level <i class="fas fa-check-circle"></i>'
                        : 'Next Question <i class="fas fa-arrow-right"></i>';
                }
                startQuestionTimer();
                alert(data.error || 'Error submitting answer');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            hideToast();
            isSubmitting = false;
            if (elements.submitBtn) {
                elements.submitBtn.disabled = false;
                elements.submitBtn.innerHTML = elements.submitBtn.innerHTML.includes('Complete')
                    ? 'Complete Level <i class="fas fa-check-circle"></i>'
                    : 'Next Question <i class="fas fa-arrow-right"></i>';
            }
            startQuestionTimer();
            alert('An error occurred. Please try again.');
        });
    }

    function handleLevelComplete(data) {
        console.log('Handling level complete:', data);
        
        if (data.quiz_completed) {
            // Quiz completed - redirect to final results
            console.log('Quiz completed, redirecting to results');
            window.location.href = "{{ route('progressive-quizzes.results', $progressiveQuiz) }}";
        } else {
            // Level completed but quiz continues
            const message = data.next_level?.unlock_message || 
                `Congratulations! You've completed Level ${CONFIG.levelNumber}. ` +
                `Level ${data.next_level?.number} is now unlocked!`;
            document.getElementById('levelCompleteMessage').textContent = message;
            
            const modal = document.getElementById('levelCompleteModal');
            modal.classList.add('active');
            
            console.log('Redirecting to level results in 3 seconds');
            
            // Auto-redirect after 3 seconds
            setTimeout(() => {
                window.location.href = CONFIG.levelResultsUrl;
            }, 3000);
        }
    }

    function updateNavigator() {
        // Update navigator to show one more answered question
        const answered = CONFIG.answeredCount + 1;
        const items = document.querySelectorAll('.nav-item');
        
        items.forEach((item, index) => {
            if (index < answered) {
                item.classList.add('answered');
                item.classList.remove('current');
            } else if (index === answered) {
                item.classList.add('current');
                item.classList.remove('answered');
            } else {
                item.classList.remove('answered', 'current');
            }
        });
        
        // Update counter
        CONFIG.answeredCount = answered;
        console.log('Updated answered count to:', answered);
    }

    // ===== UI FUNCTIONS =====
    function toggleAccordion(id) {
        const content = document.getElementById(id);
        const chevron = id === 'levelStats' ? document.getElementById('statsChevron') : 
                       (id === 'questionNav' ? document.getElementById('navChevron') : 
                       document.getElementById('nextChevron'));
        
        if (content) {
            if (content.classList.contains('active')) {
                content.classList.remove('active');
                if (chevron) chevron.classList.remove('rotated');
            } else {
                content.classList.add('active');
                if (chevron) chevron.classList.add('rotated');
            }
        }
    }

    function showToast(message, type = 'info') {
        if (elements.toast) {
            const toastSpan = elements.toast.querySelector('span');
            toastSpan.textContent = message;
            
            // Change color based on type
            if (type === 'success') {
                elements.toast.style.background = 'linear-gradient(135deg, #10b981, #059669)';
            } else if (type === 'error') {
                elements.toast.style.background = 'linear-gradient(135deg, #ef4444, #dc2626)';
            } else {
                elements.toast.style.background = 'var(--gradient-accent)';
            }
            
            elements.toast.style.display = 'flex';
            
            // Hide after 2 seconds
            setTimeout(() => {
                elements.toast.style.display = 'none';
            }, 2000);
        }
    }

    function hideToast() {
        if (elements.toast) {
            elements.toast.style.display = 'none';
        }
    }

    function showRestartModal() {
        elements.restartModal.classList.add('active');
    }

    function closeRestartModal() {
        elements.restartModal.classList.remove('active');
    }

    function restartLevel() {
        closeRestartModal();
        document.getElementById('restartForm').submit();
    }

    function viewLevelResults() {
        window.location.href = CONFIG.levelResultsUrl;
    }

    // ===== INITIALIZATION =====
    document.addEventListener('DOMContentLoaded', function() {
        // Hide all accordion content by default
        document.querySelectorAll('.accordion-content').forEach(content => {
            content.classList.remove('active');
        });

        // Make functions globally available
        window.toggleAccordion = toggleAccordion;
        window.showRestartModal = showRestartModal;
        window.closeRestartModal = closeRestartModal;
        window.restartLevel = restartLevel;
        window.viewLevelResults = viewLevelResults;

        // Check if this is the last question
        if (CONFIG.answeredCount + 1 === CONFIG.totalQuestions) {
            console.log('This is the last question!');
        }
    });

    // Cleanup on page unload
    window.addEventListener('beforeunload', function() {
        if (questionTimerInterval) {
            clearInterval(questionTimerInterval);
        }
    });
</script>
@endpush