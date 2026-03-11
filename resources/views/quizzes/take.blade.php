@extends('layouts.main')

@section('title', App\Helpers\TranslationHelper::trans('quiz-take.page_title', ['title' => $quiz->title]))

@section('meta_description', App\Helpers\TranslationHelper::trans('quiz-take.meta_description'))

@push('styles')
<style>
    /* ===== QUIZ PAGE STYLES - MATCHING YOUR BEAUTIFUL BRAND ===== */
    :root {
        /* Your Beautiful Logo Colors */
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

        /* Extended Palette */
        --primary: var(--regal-navy);
        --primary-dark: var(--prussian-blue);
        --primary-light: var(--dark-slate);
        --secondary: var(--sky-blue);
        --accent: var(--bright-amber);
        --accent-soft: var(--light-gold);
        --success: #10b981;
        --warning: var(--bright-amber);
        --danger: #ef4444;
        --dark: var(--prussian-blue);
        --dark-light: var(--regal-navy);
        --gray: var(--khaki-beige);
        --gray-light: var(--pale-slate);
        --light: var(--ivory);
        --white: var(--pure-white);

        /* Text Colors */
        --text-primary: var(--prussian-blue);
        --text-secondary: var(--dark-slate);
        --text-muted: #5f5f5f;
        --text-light: var(--pure-white);

        /* Gradients - Matching your liquid theme */
        --gradient-primary: linear-gradient(135deg, #0A1D44 0%, #18386E 50%, #2E5C61 100%);
        --gradient-accent: linear-gradient(45deg, #FBC60C 0%, #EBD789 50%, #F9F7E9 100%);
        --gradient-secondary: linear-gradient(135deg, #5AD1E4 0%, #CBD1DA 50%, #FEFDFE 100%);
        
        /* Shadows */
        --shadow-sm: 0 2px 8px rgba(10, 29, 68, 0.08);
        --shadow-md: 0 4px 12px rgba(10, 29, 68, 0.12);
        --shadow-lg: 0 8px 24px rgba(10, 29, 68, 0.15);
        --shadow-xl: 0 20px 40px -10px rgba(10, 29, 68, 0.2);
        
        /* Border Radius */
        --radius-sm: 12px;
        --radius-md: 16px;
        --radius-lg: 24px;
        --radius-xl: 32px;
        --radius-full: 9999px;
        
        /* Transitions */
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        
        /* Layout */
        --sidebar-width: 320px;
    }

    /* ===== QUIZ LAYOUT ===== */
    .quiz-page {
        padding: 40px 0;
        min-height: calc(100vh - 200px);
    }

    .quiz-grid {
        display: grid;
        grid-template-columns: 1fr var(--sidebar-width);
        gap: 30px;
        align-items: start;
    }

    /* ===== MAIN CONTENT AREA ===== */
    .quiz-main {
        min-width: 0;
    }

    /* ===== QUIZ HEADER ===== */
    .quiz-header {
        background: var(--gradient-primary);
        border-radius: var(--radius-lg);
        padding: 30px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-lg);
    }

    .quiz-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(251, 198, 12, 0.1);
        border-radius: 50%;
        pointer-events: none;
    }

    .quiz-header::after {
        content: '';
        position: absolute;
        bottom: -50%;
        left: -10%;
        width: 250px;
        height: 250px;
        background: rgba(90, 209, 228, 0.1);
        border-radius: 50%;
        pointer-events: none;
    }

    .quiz-title {
        font-size: 2rem;
        font-weight: 800;
        color: var(--pure-white);
        margin-bottom: 15px;
        position: relative;
        z-index: 1;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .quiz-meta {
        display: flex;
        align-items: center;
        gap: 20px;
        position: relative;
        z-index: 1;
        flex-wrap: wrap;
    }

    .quiz-meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.95rem;
    }

    .quiz-meta-item i {
        color: var(--bright-amber);
        font-size: 1.1rem;
    }

    /* ===== PROGRESS BAR ===== */
    .progress-section {
        margin-top: 20px;
        position: relative;
        z-index: 1;
    }

    .progress-stats {
        display: flex;
        justify-content: space-between;
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.9rem;
        margin-bottom: 8px;
    }

    .progress-bar-custom {
        height: 8px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: var(--radius-full);
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: var(--gradient-accent);
        border-radius: var(--radius-full);
        transition: width 0.5s ease;
        position: relative;
        overflow: hidden;
    }

    .progress-fill::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        animation: shimmer 2s infinite;
    }

    @keyframes shimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }

    /* ===== QUESTION TIMER ===== */
    .timer-wrapper {
        display: inline-block;
        margin-bottom: 20px;
    }

    .question-timer {
        background: var(--pure-white);
        border-radius: var(--radius-full);
        padding: 8px 20px;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        box-shadow: var(--shadow-md);
        border: 2px solid var(--bright-amber);
    }

    .question-timer.warning {
        border-color: var(--danger);
        background: #fee2e2;
        animation: pulse 1s infinite;
    }

    .question-timer i {
        color: var(--prussian-blue);
        font-size: 1rem;
    }

    .question-timer.warning i {
        color: var(--danger);
    }

    .timer-display {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--prussian-blue);
        font-variant-numeric: tabular-nums;
    }

    .question-timer.warning .timer-display {
        color: var(--danger);
    }

    .timer-label {
        color: var(--text-muted);
        font-size: 0.9rem;
        font-weight: 500;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.02); }
    }

    /* ===== QUESTION CARD ===== */
    .question-card {
        background: var(--pure-white);
        border-radius: var(--radius-lg);
        padding: 30px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--pale-slate);
        margin-bottom: 30px;
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
        color: var(--pure-white);
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
        font-size: 0.9rem;
    }

    .question-text {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 30px;
        line-height: 1.5;
    }

    /* ===== PROFESSIONAL MCQ OPTIONS ===== */
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
        background: var(--pure-white);
        border: 2px solid var(--pale-slate);
        border-radius: var(--radius-md);
        transition: all 0.2s ease;
        position: relative;
        overflow: hidden;
    }

    /* Option letter/number indicator */
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

    /* Option text */
    .option-text {
        font-size: 1.1rem;
        color: var(--text-primary);
        font-weight: 500;
        flex: 1;
        line-height: 1.5;
    }

    /* Hover state */
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

    /* Selected state - Radio */
    .mcq-option input[type="radio"]:checked + .option-content {
        border-color: var(--bright-amber);
        background: linear-gradient(135deg, rgba(251, 198, 12, 0.05), rgba(249, 247, 233, 0.5));
        box-shadow: 0 0 0 4px rgba(251, 198, 12, 0.15);
    }

    .mcq-option input[type="radio"]:checked + .option-content .option-marker {
        background: var(--bright-amber);
        border-color: var(--bright-amber);
        color: var(--prussian-blue);
        position: relative;
    }

    .mcq-option input[type="radio"]:checked + .option-content .option-marker::after {
        content: '✓';
        position: absolute;
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--prussian-blue);
    }

    .mcq-option input[type="radio"]:checked + .option-content .option-marker span {
        opacity: 0;
    }

    /* Selected state - Checkbox */
    .mcq-option input[type="checkbox"]:checked + .option-content {
        border-color: var(--bright-amber);
        background: linear-gradient(135deg, rgba(251, 198, 12, 0.05), rgba(249, 247, 233, 0.5));
        box-shadow: 0 0 0 4px rgba(251, 198, 12, 0.15);
    }

    .mcq-option input[type="checkbox"]:checked + .option-content .option-marker {
        background: var(--bright-amber);
        border-color: var(--bright-amber);
        color: var(--prussian-blue);
        position: relative;
    }

    .mcq-option input[type="checkbox"]:checked + .option-content .option-marker::after {
        content: '✓';
        position: absolute;
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--prussian-blue);
    }

    .mcq-option input[type="checkbox"]:checked + .option-content .option-marker span {
        opacity: 0;
    }

    /* Focus state for accessibility */
    .mcq-option input:focus-visible + .option-content {
        outline: 3px solid var(--bright-amber);
        outline-offset: 2px;
    }

    /* Disabled state */
    .mcq-option input:disabled + .option-content {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .mcq-option input:disabled:hover + .option-content {
        transform: none;
        box-shadow: none;
    }

    /* Multiple choice specific - show square for checkbox */
    .mcq-option input[type="checkbox"] + .option-content .option-marker {
        border-radius: 8px;
    }

    .mcq-option input[type="checkbox"]:checked + .option-content .option-marker::after {
        content: '✓';
    }

    /* True/False specific styling */
    .mcq-option.true-false .option-content {
        justify-content: center;
        text-align: center;
    }

    .mcq-option.true-false .option-marker {
        width: 60px;
        border-radius: var(--radius-full);
    }

    .mcq-option.true-false .option-text {
        text-align: center;
        font-weight: 600;
    }

    /* With images support */
    .mcq-option.with-image .option-content {
        padding: 16px;
    }

    .mcq-option.with-image .option-image {
        width: 60px;
        height: 60px;
        border-radius: var(--radius-sm);
        margin-right: 16px;
        object-fit: cover;
        border: 2px solid var(--pale-slate);
        transition: var(--transition);
    }

    .mcq-option:hover .option-image {
        border-color: var(--bright-amber);
        transform: scale(1.05);
    }

    .mcq-option input:checked + .option-content .option-image {
        border-color: var(--bright-amber);
        box-shadow: 0 0 0 2px rgba(251, 198, 12, 0.3);
    }

    /* Option letters (A, B, C, D) */
    .option-letter {
        font-weight: 700;
    }

    /* Animation for selection */
    @keyframes selectPulse {
        0% {
            box-shadow: 0 0 0 0 rgba(251, 198, 12, 0.4);
        }
        70% {
            box-shadow: 0 0 0 10px rgba(251, 198, 12, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(251, 198, 12, 0);
        }
    }

    .mcq-option input:checked + .option-content {
        animation: selectPulse 0.5s ease-out;
    }

    /* Grid layout for multiple options in a row (for image selection) */
    .mcq-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin: 24px 0;
    }

    .mcq-grid .mcq-option .option-content {
        flex-direction: column;
        text-align: center;
        padding: 20px;
    }

    .mcq-grid .mcq-option .option-marker {
        margin-right: 0;
        margin-bottom: 12px;
    }

    .mcq-grid .mcq-option .option-image {
        width: 100%;
        height: 120px;
        margin-right: 0;
        margin-bottom: 12px;
        border-radius: var(--radius-md);
    }

    /* ===== PRIMARY BUTTON ===== */
    .btn-next {
        width: 100%;
        padding: 16px 30px;
        background: var(--gradient-primary);
        color: var(--pure-white);
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
        background: var(--gradient-primary);
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .btn-next:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .btn-next i {
        font-size: 1.1rem;
        transition: transform 0.3s ease;
    }

    .btn-next:hover i {
        transform: translateX(5px);
    }

    /* ===== SIDEBAR ===== */
    .quiz-sidebar {
        position: sticky;
        top: 100px;
    }

    .sidebar-card {
        background: var(--pure-white);
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
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid var(--pale-slate);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .sidebar-title i {
        color: var(--bright-amber);
        font-size: 1.2rem;
    }

    /* ===== STATISTICS GRID ===== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }

    .stat-item {
        background: var(--ivory);
        padding: 15px;
        border-radius: var(--radius-md);
        text-align: center;
        transition: var(--transition);
    }

    .stat-item:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        background: linear-gradient(135deg, var(--ivory), var(--light-gold));
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
    }

    .nav-item {
        aspect-ratio: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--pure-white);
        border: 2px solid var(--pale-slate);
        border-radius: var(--radius-sm);
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--text-muted);
        transition: var(--transition);
        cursor: default;
    }

    .nav-item.answered {
        background: var(--secondary);
        border-color: var(--secondary);
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

    .nav-item:not(.answered):not(.current):hover {
        border-color: var(--bright-amber);
        color: var(--bright-amber);
        transform: scale(1.05);
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
    }

    .btn-restart-sidebar:hover {
        border-color: var(--bright-amber);
        color: var(--prussian-blue);
        background: var(--ivory);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    /* ===== RESULTS CARD ===== */
    .results-card {
        background: var(--pure-white);
        border-radius: var(--radius-xl);
        padding: 50px;
        text-align: center;
        box-shadow: var(--shadow-xl);
        border: 1px solid var(--pale-slate);
        max-width: 600px;
        margin: 0 auto;
    }

    .score-circle {
        width: 160px;
        height: 160px;
        margin: 0 auto 30px;
        background: var(--gradient-primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        color: var(--pure-white);
        box-shadow: var(--shadow-lg);
        position: relative;
    }

    .score-circle::before {
        content: '';
        position: absolute;
        inset: -5px;
        border-radius: 50%;
        background: var(--gradient-accent);
        opacity: 0.3;
        z-index: -1;
    }

    .score-number {
        font-size: 3rem;
        font-weight: 800;
        line-height: 1;
    }

    .score-percent {
        font-size: 1.2rem;
        opacity: 0.9;
    }

    .results-title {
        font-size: 2.2rem;
        font-weight: 800;
        color: var(--prussian-blue);
        margin-bottom: 15px;
    }

    .results-message {
        color: var(--text-muted);
        font-size: 1.1rem;
        margin-bottom: 30px;
    }

    .results-actions {
        display: flex;
        gap: 15px;
        justify-content: center;
        margin-bottom: 30px;
    }

    .btn-results {
        padding: 14px 30px;
        border: none;
        border-radius: var(--radius-md);
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-results.primary {
        background: var(--gradient-primary);
        color: var(--pure-white);
    }

    .btn-results.secondary {
        background: var(--ivory);
        color: var(--prussian-blue);
        border: 2px solid var(--pale-slate);
    }

    .btn-results:hover {
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
        background: var(--pure-white);
        border-radius: var(--radius-lg);
        padding: 30px;
        max-width: 400px;
        width: 90%;
        box-shadow: var(--shadow-xl);
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

    @keyframes modalSlideIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ===== LOADING SPINNER ===== */
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

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(100%);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
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

    /* ===== RESPONSIVE ===== */
    @media (max-width: 1024px) {
        .quiz-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .quiz-sidebar {
            position: static;
            top: auto;
        }

        .navigator-grid {
            grid-template-columns: repeat(8, 1fr);
        }
    }

    @media (max-width: 768px) {
        .quiz-page {
            padding: 20px 0;
        }

        .quiz-header {
            padding: 20px;
        }

        .quiz-title {
            font-size: 1.5rem;
        }

        .quiz-meta {
            gap: 15px;
        }

        .question-card {
            padding: 20px;
        }

        .question-text {
            font-size: 1.2rem;
        }

        .mcq-option .option-content {
            padding: 16px 20px;
        }

        .option-marker {
            width: 36px;
            height: 36px;
            font-size: 1rem;
        }

        .option-text {
            font-size: 1rem;
        }

        .stats-grid {
            grid-template-columns: repeat(4, 1fr);
        }

        .navigator-grid {
            grid-template-columns: repeat(6, 1fr);
        }

        .results-card {
            padding: 30px 20px;
        }

        .results-title {
            font-size: 1.8rem;
        }

        .results-actions {
            flex-direction: column;
        }
    }

    @media (max-width: 576px) {
        .quiz-meta {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .question-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .mcq-option .option-content {
            padding: 14px 16px;
        }

        .option-marker {
            width: 32px;
            height: 32px;
            font-size: 0.9rem;
            margin-right: 12px;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .navigator-grid {
            grid-template-columns: repeat(4, 1fr);
        }

        .modal-content {
            padding: 20px;
        }

        .modal-actions {
            flex-direction: column;
        }
    }

    /* ===== UTILITY CLASSES ===== */
    .text-gradient {
        background: var(--gradient-primary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .mt-4 { margin-top: 30px; }
    .mb-4 { margin-bottom: 30px; }
    .text-center { text-align: center; }
</style>
@endpush

@section('content')
<div class="quiz-page">
    <div class="container">
        <!-- Loading Toast -->
        <div class="loading-toast" id="translationLoading" style="display: none;">
            <div class="spinner"></div>
            <span>{{ App\Helpers\TranslationHelper::trans('quiz-take.translating') }}</span>
        </div>

        @php
            $isQuizComplete = !($questions[$attempt->answers->count()] ?? null);
            $currentQuestion = !$isQuizComplete ? $questions[$attempt->answers->count()] : null;
            $progress = ($attempt->answers->count() / $questions->count()) * 100;
            $letters = range('A', 'Z');
        @endphp

        @if($isQuizComplete)
            <!-- RESULTS VIEW -->
            <div class="results-card">
                <div class="score-circle">
                    <span class="score-number">{{ $attempt->score ?? 0 }}</span>
                    <span class="score-percent">%</span>
                </div>
                
                <h2 class="results-title">{{ App\Helpers\TranslationHelper::trans('quiz-take.complete_title') }}</h2>
                <p class="results-message">{{ App\Helpers\TranslationHelper::trans('quiz-take.complete_message') }}</p>
                
                <!-- Primary Actions -->
                <div class="results-actions">
                    <button class="btn-results primary" onclick="showRestartModal()">
                        <i class="fas fa-redo-alt"></i>
                        Try Again
                    </button>
                    <a href="{{ route('quizzes.results', $quiz->id) }}" class="btn-results secondary">
                        <i class="fas fa-chart-bar"></i>
                        View Details
                    </a>
                </div>

                <!-- Secondary Info - Collapsible -->
                <div class="sidebar-card" style="text-align: left; margin-top: 30px;">
                    <div class="sidebar-title" onclick="toggleAccordion('resultsDetails')" style="cursor: pointer; margin-bottom: 0; padding-bottom: 0; border-bottom: none;">
                        <i class="fas fa-info-circle"></i>
                        Detailed Results
                        <i class="fas fa-chevron-down chevron" style="margin-left: auto; transition: var(--transition);"></i>
                    </div>
                    <div class="accordion-content" id="resultsDetails" style="display: none; padding-top: 20px;">
                        <div class="stats-grid">
                            <div class="stat-item">
                                <span class="stat-label">Total Questions</span>
                                <span class="stat-value">{{ $questions->count() }}</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Correct</span>
                                <span class="stat-value">{{ $attempt->answers->where('is_correct', true)->count() }}</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Incorrect</span>
                                <span class="stat-value">{{ $attempt->answers->where('is_correct', false)->count() }}</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Points</span>
                                <span class="stat-value">{{ $questions->sum('points') }}</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Time Spent</span>
                                <span class="stat-value small">{{ gmdate('i:s', $attempt->updated_at->diffInSeconds($attempt->created_at)) }}</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Attempt</span>
                                <span class="stat-value small">#{{ $attempt->attempt_number }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- QUIZ TAKING VIEW - GRID LAYOUT -->
            <div class="quiz-grid">
                <!-- MAIN CONTENT -->
                <div class="quiz-main">
                    <!-- Quiz Header -->
                    <div class="quiz-header">
                        <h1 class="quiz-title" id="quizTitle" data-original="{{ $quiz->title }}">{{ $quiz->title }}</h1>
                        
                        <div class="quiz-meta">
                            <div class="quiz-meta-item">
                                <i class="fas fa-question-circle"></i>
                                <span id="questionCount" data-original="Question {{ $attempt->answers->count() + 1 }} of {{ $questions->count() }}">
                                    Question {{ $attempt->answers->count() + 1 }} of {{ $questions->count() }}
                                </span>
                            </div>
                            <div class="quiz-meta-item">
                                <i class="fas fa-star"></i>
                                <span id="questionType" data-original="{{ ucfirst(str_replace('_', ' ', $currentQuestion->question_type)) }}">
                                    {{ ucfirst(str_replace('_', ' ', $currentQuestion->question_type)) }}
                                </span>
                            </div>
                            @if($remainingTime)
                            <div class="quiz-meta-item">
                                <i class="far fa-clock"></i>
                                <span id="overallTimer">{{ gmdate('H:i:s', $remainingTime) }}</span>
                            </div>
                            @endif
                        </div>

                        <!-- Progress Bar -->
                        <div class="progress-section">
                            <div class="progress-stats">
                                <span>Progress</span>
                                <span>{{ round($progress) }}%</span>
                            </div>
                            <div class="progress-bar-custom">
                                <div class="progress-fill" style="width: {{ $progress }}%;"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Question Timer -->
                    <div class="timer-wrapper">
                        <div class="question-timer" id="questionTimer">
                            <i class="far fa-hourglass"></i>
                            <span class="timer-display" id="questionTimerDisplay">00:10</span>
                            <span class="timer-label">remaining</span>
                        </div>
                    </div>

                    <!-- Question Card -->
                    <div class="question-card">
                        <form action="{{ route('quizzes.submit', ['quiz' => $quiz->id, 'attempt' => $attempt->id]) }}" method="POST" id="quizForm">
                            @csrf
                            
                            <div class="question-header">
                                <span class="question-badge" id="questionBadge">
                                    Question {{ $attempt->answers->count() + 1 }}
                                </span>
                                <span class="question-points" id="questionPoints" data-original="{{ $currentQuestion->points }} pts">
                                    <i class="fas fa-star"></i> {{ $currentQuestion->points }} pts
                                </span>
                            </div>
                            
                            <div class="question-text" id="questionText" data-question-id="{{ $currentQuestion->id }}" data-original="{{ $currentQuestion->question_text }}">
                                {{ $currentQuestion->question_text }}
                            </div>

                            <!-- Professional MCQ Options -->
                            @if(in_array($currentQuestion->question_type, ['multiple_choice', 'single_choice', 'true_false']))
                                <div class="mcq-container">
                                    @foreach($currentQuestion->options as $index => $option)
                                    <label class="mcq-option {{ $currentQuestion->question_type == 'true_false' ? 'true-false' : '' }} {{ $option->image ? 'with-image' : '' }}">
                                        @if($currentQuestion->question_type == 'multiple_choice')
                                        <input type="checkbox" 
                                               name="answers[{{ $currentQuestion->id }}][]" 
                                               value="{{ $option->id }}"
                                               onchange="handleMCQSelection(this)">
                                        @else
                                        <input type="radio" 
                                               name="answers[{{ $currentQuestion->id }}]" 
                                               value="{{ $option->id }}"
                                               onchange="handleMCQSelection(this)">
                                        @endif
                                        
                                        <div class="option-content">
                                            <div class="option-marker">
                                                <span class="option-letter">{{ $letters[$index] }}</span>
                                            </div>
                                            
                                            @if($option->image)
                                            <img src="{{ $option->image_url }}" alt="" class="option-image">
                                            @endif
                                            
                                            <span class="option-text" data-option-id="{{ $option->id }}" data-original="{{ $option->option_text }}">
                                                {{ $option->option_text }}
                                            </span>
                                        </div>
                                    </label>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Primary Action Button -->
                            <button type="submit" name="action" value="next" class="btn-next" id="nextBtn">
                                @if($attempt->answers->count() + 1 == $questions->count())
                                <span>Complete Quiz</span>
                                <i class="fas fa-check-circle"></i>
                                @else
                                <span>Next Question</span>
                                <i class="fas fa-arrow-right"></i>
                                @endif
                            </button>
                        </form>
                    </div>
                </div>

                <!-- SIDEBAR - Statistics & Navigator -->
                <div class="quiz-sidebar">
                    <!-- Statistics Card -->
                    <div class="sidebar-card">
                        <h3 class="sidebar-title">
                            <i class="fas fa-chart-pie"></i>
                            Quiz Statistics
                        </h3>
                        
                        <div class="stats-grid">
                            <div class="stat-item">
                                <span class="stat-label">Total Questions</span>
                                <span class="stat-value">{{ $questions->count() }}</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Answered</span>
                                <span class="stat-value">{{ $attempt->answers->count() }}</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Remaining</span>
                                <span class="stat-value">{{ $questions->count() - $attempt->answers->count() }}</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Total Points</span>
                                <span class="stat-value">{{ $questions->sum('points') }}</span>
                            </div>
                            @if($quiz->pass_percentage)
                            <div class="stat-item">
                                <span class="stat-label">Passing Score</span>
                                <span class="stat-value">{{ $quiz->pass_percentage }}%</span>
                            </div>
                            @endif
                            <div class="stat-item">
                                <span class="stat-label">Attempt</span>
                                <span class="stat-value small">#{{ $attempt->attempt_number }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Question Navigator Card -->
                    <div class="sidebar-card">
                        <h3 class="sidebar-title">
                            <i class="fas fa-th"></i>
                            Question Navigator
                        </h3>
                        
                        <div class="navigator-grid">
                            @foreach($questions as $index => $question)
                            @php
                            $isAnswered = $attempt->answers->contains('question_id', $question->id);
                            $isCurrent = $index == $attempt->answers->count();
                            @endphp
                            <div class="nav-item {{ $isAnswered ? 'answered' : '' }} {{ $isCurrent ? 'current' : '' }}">
                                {{ $index + 1 }}
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Restart Option -->
                    @if($attempt->answers->count() > 0)
                    <button class="btn-restart-sidebar" onclick="showRestartModal()">
                        <i class="fas fa-redo-alt"></i>
                        Restart Quiz
                    </button>
                    @endif
                </div>
            </div>
        @endif

        <!-- Restart Modal -->
        <div class="modal-overlay" id="restartModal">
            <div class="modal-content">
                <div class="modal-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <h3 class="modal-title">Restart Quiz?</h3>
                <p class="modal-text">Your current progress will be lost and the quiz will begin from the first question.</p>
                <div class="modal-actions">
                    <button class="modal-btn cancel" onclick="closeRestartModal()">Cancel</button>
                    <form id="restartForm" method="POST" action="{{ route('quizzes.start', $quiz->id) }}" style="flex: 1;">
                        @csrf
                        <button type="submit" class="modal-btn confirm">Restart</button>
                    </form>
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

<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@push('scripts')
<script>
    (function() {
        'use strict';

        // Configuration
        const CONFIG = {
            TRANSLATE_API_URL: "{{ route('translate') }}",
            QUESTION_TIME_LIMIT: 10,
            WARNING_THRESHOLD: 3
        };

        // State
        let currentLanguage = 'en';
        const translationCache = new Map();
        let questionTimeLeft = CONFIG.QUESTION_TIME_LIMIT;
        let questionTimerInterval = null;
        let mainTimerInterval = null;

        // DOM Elements
        const elements = {
            quizForm: document.getElementById('quizForm'),
            questionTimer: document.getElementById('questionTimer'),
            questionTimerDisplay: document.getElementById('questionTimerDisplay'),
            nextBtn: document.getElementById('nextBtn'),
            translationLoading: document.getElementById('translationLoading'),
            restartModal: document.getElementById('restartModal')
        };

        // ===== MCQ SELECTION HANDLER =====
        window.handleMCQSelection = function(input) {
            const optionItem = input.closest('.mcq-option');
            
            if (input.type === 'radio') {
                // Remove selected class from all radio options with same name
                document.querySelectorAll(`input[name="${input.name}"]`).forEach(radio => {
                    radio.closest('.mcq-option')?.classList.remove('selected');
                });
                optionItem?.classList.add('selected');
            } else {
                // Toggle selected class for checkbox
                optionItem?.classList.toggle('selected', input.checked);
            }
        };

        // Initialize selected states on page load
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.mcq-option input:checked').forEach(input => {
                input.closest('.mcq-option')?.classList.add('selected');
            });
        });

        // ===== TIMER MANAGEMENT =====
        class TimerManager {
            static startQuestionTimer() {
                if (questionTimerInterval) {
                    clearInterval(questionTimerInterval);
                }

                questionTimeLeft = CONFIG.QUESTION_TIME_LIMIT;
                TimerManager.updateQuestionTimerDisplay();

                questionTimerInterval = setInterval(() => {
                    questionTimeLeft--;
                    TimerManager.updateQuestionTimerDisplay();

                    if (questionTimeLeft <= CONFIG.WARNING_THRESHOLD) {
                        elements.questionTimer?.classList.add('warning');
                    }

                    if (questionTimeLeft <= 0) {
                        clearInterval(questionTimerInterval);
                        questionTimerInterval = null;
                        TimerManager.autoSubmitQuestion();
                    }
                }, 1000);
            }

            static updateQuestionTimerDisplay() {
                if (elements.questionTimerDisplay) {
                    const seconds = questionTimeLeft < 10 ? '0' + questionTimeLeft : questionTimeLeft;
                    elements.questionTimerDisplay.textContent = `00:${seconds}`;
                }
            }

            static autoSubmitQuestion() {
                if (!elements.quizForm) return;

                const autoSkipInput = document.createElement('input');
                autoSkipInput.type = 'hidden';
                autoSkipInput.name = 'auto_skip';
                autoSkipInput.value = '1';
                elements.quizForm.appendChild(autoSkipInput);

                const noAnswerInput = document.createElement('input');
                noAnswerInput.type = 'hidden';
                noAnswerInput.name = 'no_answer';
                noAnswerInput.value = '1';
                elements.quizForm.appendChild(noAnswerInput);

                if (elements.nextBtn) {
                    elements.nextBtn.disabled = true;
                    elements.nextBtn.innerHTML = '<div class="spinner"></div> Moving to next...';
                }

                elements.quizForm.submit();
            }

            static startMainTimer(remainingSeconds) {
                const timerDisplay = document.getElementById('overallTimer');
                const timeoutForm = document.getElementById('timeoutForm');

                if (!timerDisplay || !timeoutForm) return;

                mainTimerInterval = setInterval(() => {
                    remainingSeconds--;
                    
                    if (remainingSeconds <= 0) {
                        clearInterval(mainTimerInterval);
                        timeoutForm.submit();
                    } else {
                        const hours = Math.floor(remainingSeconds / 3600);
                        const minutes = Math.floor((remainingSeconds % 3600) / 60);
                        const seconds = remainingSeconds % 60;
                        
                        timerDisplay.textContent = 
                            `${hours.toString().padStart(2, '0')}:` +
                            `${minutes.toString().padStart(2, '0')}:` +
                            `${seconds.toString().padStart(2, '0')}`;
                    }
                }, 1000);
            }
        }

        // ===== UI INTERACTIONS =====
        class UIManager {
            static toggleAccordion(id) {
                const content = document.getElementById(id);
                if (!content) return;

                const header = content.previousElementSibling;
                const chevron = header?.querySelector('.chevron');

                if (content.style.display === 'none') {
                    content.style.display = 'block';
                    chevron?.classList.remove('fa-chevron-down');
                    chevron?.classList.add('fa-chevron-up');
                } else {
                    content.style.display = 'none';
                    chevron?.classList.remove('fa-chevron-up');
                    chevron?.classList.add('fa-chevron-down');
                }
            }

            static showRestartModal() {
                elements.restartModal?.classList.add('active');
            }

            static closeRestartModal() {
                elements.restartModal?.classList.remove('active');
            }
        }

        // ===== TRANSLATION SERVICE =====
        class TranslationService {
            static async changeLanguage(lang) {
                if (lang === currentLanguage) return;

                TranslationService.showLoading();

                try {
                    TranslationService.updateLanguageButtons(lang);
                    await TranslationService.translateAllElements(lang);
                    currentLanguage = lang;
                } catch (error) {
                    console.error('Translation failed:', error);
                } finally {
                    TranslationService.hideLoading();
                }
            }

            static async translateAllElements(targetLang) {
                const elements = document.querySelectorAll('[data-original]');
                
                for (const el of elements) {
                    if (el.dataset.original) {
                        const translated = await TranslationService.translateText(
                            el.dataset.original, 
                            currentLanguage, 
                            targetLang
                        );
                        
                        if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') {
                            el.placeholder = translated;
                        } else {
                            el.textContent = translated;
                        }
                    }
                }
            }

            static async translateText(text, sourceLang, targetLang) {
                const cacheKey = `${text}_${sourceLang}_${targetLang}`;
                
                if (translationCache.has(cacheKey)) {
                    return translationCache.get(cacheKey);
                }

                if (sourceLang === targetLang || !text) {
                    return text;
                }

                try {
                    const response = await fetch(CONFIG.TRANSLATE_API_URL, {
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

                    const data = await response.json();
                    const translated = data.translatedText || text;
                    translationCache.set(cacheKey, translated);
                    return translated;
                } catch (error) {
                    console.error('Translation API error:', error);
                    return text;
                }
            }

            static updateLanguageButtons(lang) {
                document.querySelectorAll('.lang-btn').forEach(btn => {
                    btn.classList.remove('active');
                });
                
                const activeBtn = document.querySelector(`.lang-btn[onclick*="${lang}"]`);
                if (activeBtn) activeBtn.classList.add('active');
            }

            static showLoading() {
                if (elements.translationLoading) {
                    elements.translationLoading.style.display = 'flex';
                }
            }

            static hideLoading() {
                if (elements.translationLoading) {
                    elements.translationLoading.style.display = 'none';
                }
            }
        }

        // ===== FORM HANDLING =====
        class FormManager {
            static setupFormSubmission() {
                if (!elements.quizForm) return;

                elements.quizForm.addEventListener('submit', (e) => {
                    if (questionTimerInterval) {
                        clearInterval(questionTimerInterval);
                    }

                    if (elements.nextBtn) {
                        elements.nextBtn.innerHTML = '<div class="spinner"></div> Saving...';
                        elements.nextBtn.disabled = true;
                    }
                });
            }
        }

        // ===== INITIALIZATION =====
        document.addEventListener('DOMContentLoaded', () => {
            // Start question timer if on question page
            if (elements.quizForm) {
                TimerManager.startQuestionTimer();
            }

            // Start main timer if exists
            @if($remainingTime)
            TimerManager.startMainTimer({{ $remainingTime }});
            @endif

            // Setup form submission
            FormManager.setupFormSubmission();

            // Make functions globally available
            window.toggleAccordion = UIManager.toggleAccordion;
            window.showRestartModal = UIManager.showRestartModal;
            window.closeRestartModal = UIManager.closeRestartModal;
            window.changeLanguage = TranslationService.changeLanguage;
        });

        // Cleanup on page unload
        window.addEventListener('beforeunload', () => {
            if (questionTimerInterval) {
                clearInterval(questionTimerInterval);
            }
            if (mainTimerInterval) {
                clearInterval(mainTimerInterval);
            }
        });
    })();
</script>
@endpush