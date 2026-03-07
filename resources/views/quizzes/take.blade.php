@extends('layouts.main')

@section('title', App\Helpers\TranslationHelper::trans('quiz-take.page_title', ['title' => $quiz->title]))

@section('meta_description', App\Helpers\TranslationHelper::trans('quiz-take.meta_description'))

@section('content')
<style>
    /* ===== LIQUID QUIZ TAKING PAGE - YOUR BEAUTIFUL COLORS ===== */
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

        /* Extended Palette */
        --primary: var(--regal-navy);
        --primary-dark: var(--prussian-blue);
        --primary-light: var(--dark-slate);
        --secondary: var(--sky-blue);
        --accent: var(--bright-amber);
        --accent-soft: var(--light-gold);
        --success: var(--sky-blue);
        --warning: var(--bright-amber);
        --danger: #EBD789;
        --dark: var(--prussian-blue);
        --dark-light: var(--regal-navy);
        --gray: var(--khaki-beige);
        --gray-light: var(--pale-slate);
        --light: var(--ivory);
        --white: var(--pure-white);

        /* Text Colors */
        --text-primary: #0A1D44;
        --text-secondary: #2E5C61;
        --text-muted: #5f5f5f;
        --text-light: #FEFDFE;

        /* Gradients with your colors */
        --gradient-liquid-1: linear-gradient(135deg, #0A1D44 0%, #18386E 50%, #2E5C61 100%);
        --gradient-liquid-2: linear-gradient(45deg, #FBC60C 0%, #EBD789 50%, #F9F7E9 100%);
        --gradient-liquid-3: linear-gradient(135deg, #5AD1E4 0%, #CBD1DA 50%, #FEFDFE 100%);
        --gradient-liquid-4: linear-gradient(225deg, #0A1D44 0%, #2E5C61 50%, #5AD1E4 100%);

        /* Shadows */
        --shadow-sm: 0 2px 8px rgba(10, 29, 68, 0.08);
        --shadow-md: 0 4px 12px rgba(10, 29, 68, 0.12);
        --shadow-lg: 0 8px 24px rgba(10, 29, 68, 0.15);
        --shadow-hover: 0 12px 28px rgba(251, 198, 12, 0.2);

        /* Border Radius */
        --radius-sm: 12px;
        --radius-md: 20px;
        --radius-lg: 30px;
        --radius-full: 9999px;

        /* Transitions */
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* ===== MAIN CONTAINER WITH LIQUID BACKGROUND ===== */
    .liquid-quiz-container {
        background: linear-gradient(135deg, var(--ivory) 0%, var(--pure-white) 100%);
        min-height: 100vh;
        padding: 40px 0;
        position: relative;
        overflow: hidden;
    }

    .liquid-blob {
        position: absolute;
        filter: blur(60px);
        opacity: 0.15;
        transform: translateZ(0);
        backface-visibility: hidden;
        pointer-events: none;
        z-index: 0;
    }

    .liquid-blob-1 {
        top: -5%;
        left: -5%;
        width: 400px;
        height: 400px;
        background: var(--bright-amber);
        border-radius: 62% 38% 42% 58% / 37% 53% 47% 63%;
    }

    .liquid-blob-2 {
        bottom: -5%;
        right: -5%;
        width: 500px;
        height: 500px;
        background: var(--sky-blue);
        border-radius: 33% 67% 48% 52% / 44% 31% 69% 56%;
    }

    .liquid-blob-3 {
        top: 40%;
        right: 10%;
        width: 300px;
        height: 300px;
        background: var(--light-gold);
        border-radius: 53% 47% 32% 68% / 44% 58% 42% 56%;
    }

    @media (max-width: 768px) {
        .liquid-blob {
            filter: blur(40px);
        }
        .liquid-blob-1 { width: 250px; height: 250px; }
        .liquid-blob-2 { width: 300px; height: 300px; }
        .liquid-blob-3 { width: 200px; height: 200px; }
    }

    /* ===== CONTENT WRAPPER ===== */
    .quiz-content {
        position: relative;
        z-index: 2;
    }

    /* ===== TRANSLATION LOADING ===== */
    .translation-loading {
        position: fixed;
        top: 20px;
        right: 20px;
        background: var(--gradient-liquid-2);
        color: var(--prussian-blue);
        padding: 12px 24px;
        border-radius: var(--radius-full);
        box-shadow: var(--shadow-lg);
        z-index: 9999;
        display: none;
        align-items: center;
        gap: 12px;
        font-weight: 600;
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        animation: slideIn 0.3s ease;
    }

    .translation-loading i {
        animation: spin 1s linear infinite;
    }

    @keyframes spin { to { transform: rotate(360deg); } }
    @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }

    /* ===== ALERTS ===== */
    .liquid-alert {
        border-radius: var(--radius-md);
        padding: 16px 20px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 12px;
        border: 1px solid transparent;
        position: relative;
        z-index: 2;
    }

    .liquid-alert-error {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(251, 198, 12, 0.1));
        color: var(--prussian-blue);
        border-left: 4px solid var(--bright-amber);
    }

    .liquid-alert-success {
        background: linear-gradient(135deg, rgba(90, 209, 228, 0.1), rgba(203, 209, 218, 0.1));
        color: var(--prussian-blue);
        border-left: 4px solid var(--sky-blue);
    }

    /* ===== QUIZ HEADER ===== */
    .liquid-quiz-header {
        background: var(--gradient-liquid-1);
        border-radius: var(--radius-lg);
        padding: 30px 35px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-lg);
        color: var(--pure-white);
    }

    .liquid-quiz-header::before {
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

    .liquid-quiz-header::after {
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

    .liquid-quiz-header h1 {
        font-size: 2rem !important;
        font-weight: 800 !important;
        color: var(--pure-white) !important;
        margin-bottom: 8px !important;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    /* ===== TIMER ===== */
    .liquid-timer {
        background: var(--gradient-liquid-2);
        color: var(--prussian-blue);
        padding: 14px 28px;
        border-radius: var(--radius-full);
        display: inline-flex;
        align-items: center;
        gap: 12px;
        font-size: 1.6rem;
        font-weight: 700;
        box-shadow: var(--shadow-lg);
        border: 1px solid rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(8px);
    }

    .liquid-timer.warning {
        background: var(--gradient-liquid-1);
        color: var(--pure-white);
    }

    .liquid-timer i {
        font-size: 1.4rem;
    }

    /* ===== PROGRESS BAR ===== */
    .liquid-progress {
        margin-top: 20px;
    }

    .liquid-progress-bar {
        height: 12px;
        background: var(--pale-slate);
        border-radius: var(--radius-full);
        overflow: hidden;
        margin-bottom: 10px;
    }

    .liquid-progress-fill {
        height: 100%;
        background: var(--gradient-liquid-2);
        border-radius: var(--radius-full);
        transition: width 0.5s ease;
        position: relative;
        overflow: hidden;
    }

    .liquid-progress-fill::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        animation: shimmer 2s infinite;
    }

    @keyframes shimmer { 0% { transform: translateX(-100%); } 100% { transform: translateX(100%); } }

    .liquid-progress-stats {
        display: flex;
        justify-content: space-between;
        color: var(--text-muted);
        font-size: 0.9rem;
    }

    /* ===== LANGUAGE SELECTOR ===== */
    .liquid-language-selector {
        background: var(--pure-white);
        border-radius: var(--radius-full);
        padding: 6px;
        display: inline-flex;
        gap: 6px;
        box-shadow: var(--shadow-md);
        border: 1px solid rgba(251, 198, 12, 0.2);
        margin-bottom: 15px;
    }

    .liquid-language-btn {
        padding: 10px 24px;
        border: none;
        border-radius: var(--radius-full);
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        background: transparent;
        color: var(--text-muted);
    }

    .liquid-language-btn:hover {
        background: var(--ivory);
        color: var(--bright-amber);
    }

    .liquid-language-btn.active {
        background: var(--gradient-liquid-2);
        color: var(--prussian-blue);
        box-shadow: var(--shadow-md);
    }

    /* ===== QUESTION CARD ===== */
    .liquid-question-card {
        background: var(--pure-white);
        border-radius: var(--radius-lg);
        padding: 40px;
        box-shadow: var(--shadow-lg);
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(251, 198, 12, 0.1);
    }

    .liquid-question-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid var(--pale-slate);
    }

    .liquid-question-badge {
        background: var(--gradient-liquid-1);
        color: var(--pure-white);
        padding: 8px 20px;
        border-radius: var(--radius-full);
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .liquid-question-points {
        background: var(--gradient-liquid-2);
        color: var(--prussian-blue);
        padding: 8px 18px;
        border-radius: var(--radius-full);
        font-size: 0.95rem;
        font-weight: 700;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .liquid-question-text {
        font-size: 1.6rem !important;
        font-weight: 600 !important;
        color: var(--text-primary) !important;
        margin-bottom: 30px !important;
        line-height: 1.5 !important;
        padding: 20px;
        background: var(--ivory);
        border-radius: var(--radius-md);
        border-left: 4px solid var(--bright-amber);
    }

    /* ===== OPTIONS - FIXED RADIO/CHECKBOX STYLING ===== */
    .liquid-option-item {
        margin-bottom: 16px;
        padding: 20px 25px;
        border: 2px solid var(--pale-slate);
        border-radius: var(--radius-md);
        transition: var(--transition);
        cursor: pointer;
        background: var(--pure-white);
        position: relative;
        overflow: hidden;
    }

    .liquid-option-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: var(--gradient-liquid-2);
        opacity: 0;
        transition: var(--transition);
    }

    .liquid-option-item:hover {
        border-color: var(--bright-amber);
        background: linear-gradient(135deg, var(--pure-white), var(--ivory));
        transform: translateX(8px);
        box-shadow: var(--shadow-md);
    }

    .liquid-option-item:hover::before {
        opacity: 1;
    }

    .liquid-option-item.selected {
        border-color: var(--bright-amber);
        background: linear-gradient(135deg, var(--ivory), var(--pure-white));
        box-shadow: var(--shadow-md);
    }

    .liquid-option-item.selected::before {
        opacity: 1;
    }

    /* Fixed radio/checkbox styling - more professional size */
    .liquid-option-item .form-check-input {
        width: 18px !important;
        height: 18px !important;
        margin-right: 15px;
        cursor: pointer;
        border: 2px solid var(--gray);
        accent-color: var(--bright-amber); /* This helps with native styling */
    }

    /* Better radio button styling */
    .liquid-option-item .form-check-input[type="radio"] {
        border-radius: 50%;
    }

    .liquid-option-item .form-check-input[type="radio"]:checked,
    .liquid-option-item .form-check-input[type="checkbox"]:checked {
        background-color: var(--bright-amber);
        border-color: var(--bright-amber);
    }

    .liquid-option-item .form-check-label {
        font-size: 1.1rem;
        color: var(--text-primary);
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 15px;
        cursor: pointer;
        width: 100%;
    }

    /* Remove the click event from the form-check div to avoid conflicts */
    .liquid-option-item .form-check {
        display: flex;
        align-items: center;
        margin: 0;
        padding: 0;
        min-height: auto;
        width: 100%;
        cursor: pointer;
    }

    .liquid-option-image {
        width: 60px;
        height: 60px;
        border-radius: var(--radius-sm);
        overflow: hidden;
        flex-shrink: 0;
        border: 2px solid transparent;
        transition: var(--transition);
        box-shadow: var(--shadow-sm);
    }

    .liquid-option-item:hover .liquid-option-image {
        border-color: var(--bright-amber);
        transform: scale(1.05);
    }

    /* ===== FILL IN THE BLANK ===== */
    .liquid-fill-blank .form-control {
        border: 2px solid var(--pale-slate);
        border-radius: var(--radius-md);
        padding: 18px 25px;
        font-size: 1.1rem;
        transition: var(--transition);
        background: linear-gradient(135deg, var(--pure-white), var(--ivory));
    }

    .liquid-fill-blank .form-control:focus {
        border-color: var(--bright-amber);
        box-shadow: 0 0 0 4px rgba(251, 198, 12, 0.1);
        outline: none;
    }

    .liquid-hint {
        display: block;
        margin-top: 10px;
        color: var(--text-muted);
        font-size: 0.9rem;
    }

    .liquid-hint i {
        color: var(--bright-amber);
        margin-right: 5px;
    }

    /* ===== MATCHING ===== */
    .liquid-matching-row {
        background: linear-gradient(135deg, var(--ivory), var(--pure-white));
        border-radius: var(--radius-md);
        padding: 25px;
        margin-bottom: 15px;
        transition: var(--transition);
        border: 1px solid transparent;
    }

    .liquid-matching-row:hover {
        transform: translateX(8px) translateY(-2px);
        box-shadow: var(--shadow-md);
        border-color: var(--bright-amber);
    }

    .liquid-matching-left {
        font-weight: 600;
        color: var(--text-primary);
        padding: 12px;
        background: var(--pure-white);
        border-radius: var(--radius-sm);
        text-align: center;
        border: 2px dashed var(--pale-slate);
        box-shadow: var(--shadow-sm);
    }

    .liquid-matching-arrow {
        text-align: center;
        color: var(--bright-amber);
        font-size: 1.2rem;
    }

    .liquid-matching-select {
        width: 100%;
        padding: 12px 18px;
        border: 2px solid var(--pale-slate);
        border-radius: var(--radius-sm);
        background: var(--pure-white);
        cursor: pointer;
        transition: var(--transition);
        font-weight: 500;
    }

    .liquid-matching-select:focus {
        border-color: var(--bright-amber);
        box-shadow: 0 0 0 4px rgba(251, 198, 12, 0.1);
        outline: none;
    }

    /* ===== IMAGE SELECTION ===== */
    .liquid-image-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
        margin-top: 25px;
    }

    .liquid-image-option {
        border: 2px solid var(--pale-slate);
        border-radius: var(--radius-md);
        overflow: hidden;
        cursor: pointer;
        transition: var(--transition);
        background: var(--pure-white);
        position: relative;
    }

    .liquid-image-option:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: var(--shadow-hover);
        border-color: var(--bright-amber);
    }

    .liquid-image-option.selected {
        border-color: var(--bright-amber);
        box-shadow: 0 0 0 4px rgba(251, 198, 12, 0.2);
    }

    .liquid-image-option img {
        width: 100%;
        height: 160px;
        object-fit: cover;
        transition: var(--transition);
    }

    .liquid-image-option:hover img {
        transform: scale(1.1);
    }

    .liquid-image-option p {
        text-align: center;
        padding: 15px;
        margin: 0;
        background: var(--ivory);
        font-weight: 600;
        color: var(--text-primary);
        border-top: 1px solid rgba(251, 198, 12, 0.1);
    }

    /* ===== BUTTONS ===== */
    .liquid-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        padding: 16px 35px;
        border-radius: var(--radius-full);
        font-size: 1.1rem;
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
        border: none;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        letter-spacing: 0.5px;
    }

    .liquid-btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
        z-index: 0;
    }

    .liquid-btn:hover::before {
        width: 300px;
        height: 300px;
    }

    .liquid-btn i,
    .liquid-btn span {
        position: relative;
        z-index: 1;
    }

    .liquid-btn-primary {
        background: var(--gradient-liquid-1);
        color: var(--pure-white);
        box-shadow: var(--shadow-md);
    }

    .liquid-btn-primary:hover {
        background: var(--gradient-liquid-4);
        transform: translateX(5px) translateY(-2px);
        box-shadow: var(--shadow-hover);
    }

    .liquid-btn-secondary {
        background: var(--pure-white);
        color: var(--text-primary);
        border: 2px solid var(--pale-slate);
    }

    .liquid-btn-secondary:hover {
        background: var(--ivory);
        border-color: var(--bright-amber);
        transform: translateX(-5px) translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .liquid-btn-success {
        background: var(--gradient-liquid-3);
        color: var(--prussian-blue);
        box-shadow: var(--shadow-md);
    }

    .liquid-btn-success:hover {
        background: var(--gradient-liquid-2);
        transform: translateY(-3px);
        box-shadow: var(--shadow-hover);
    }

    .liquid-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    /* ===== NAVIGATOR CARD ===== */
    .liquid-navigator-card,
    .liquid-info-card {
        background: var(--pure-white);
        border-radius: var(--radius-lg);
        padding: 30px;
        box-shadow: var(--shadow-lg);
        margin-bottom: 25px;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(251, 198, 12, 0.1);
    }

    .liquid-navigator-title {
        font-size: 1.3rem !important;
        font-weight: 700 !important;
        color: var(--text-primary) !important;
        margin-bottom: 25px !important;
        display: flex;
        align-items: center;
        gap: 12px;
        border-bottom: 2px solid var(--pale-slate);
        padding-bottom: 15px;
    }

    .liquid-navigator-title i {
        color: var(--bright-amber);
    }

    .liquid-question-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 12px;
    }

    .liquid-question-dot {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--ivory), var(--pure-white));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-muted);
        cursor: pointer;
        transition: var(--transition);
        border: 2px solid transparent;
        box-shadow: var(--shadow-sm);
    }

    .liquid-question-dot:hover {
        transform: scale(1.15) translateY(-3px);
        border-color: var(--bright-amber);
        box-shadow: var(--shadow-hover);
        color: var(--bright-amber);
    }

    .liquid-question-dot.answered {
        background: var(--gradient-liquid-3);
        color: var(--prussian-blue);
        border-color: var(--sky-blue);
    }

    .liquid-question-dot.current {
        background: var(--gradient-liquid-2);
        color: var(--prussian-blue);
        transform: scale(1.15);
        box-shadow: 0 0 0 3px rgba(251, 198, 12, 0.3);
        border: 2px solid var(--pure-white);
    }

    /* ===== INFO LIST ===== */
    .liquid-info-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .liquid-info-list li {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px 0;
        border-bottom: 1px solid var(--pale-slate);
    }

    .liquid-info-list li:last-child {
        border-bottom: none;
    }

    .liquid-info-list li i {
        width: 30px;
        color: var(--bright-amber);
        font-size: 1.2rem;
        text-align: center;
    }

    .liquid-info-list li strong {
        color: var(--text-primary);
        font-weight: 700;
        margin-left: auto;
    }

    /* ===== COMPLETE CARD ===== */
    .liquid-complete-card {
        background: linear-gradient(135deg, var(--ivory), var(--pure-white));
        border-radius: var(--radius-lg);
        padding: 70px 50px;
        box-shadow: var(--shadow-lg);
        text-align: center;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(251, 198, 12, 0.1);
    }

    .liquid-complete-card::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(251, 198, 12, 0.05) 0%, transparent 70%);
        animation: rotate 20s linear infinite;
    }

    @keyframes rotate { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }

    .liquid-complete-icon {
        font-size: 6rem;
        background: var(--gradient-liquid-3);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 25px;
        position: relative;
        display: inline-block;
    }

    .liquid-complete-card h2 {
        font-size: 2.5rem !important;
        font-weight: 800 !important;
        color: var(--text-primary) !important;
        margin-bottom: 15px !important;
    }

    .liquid-complete-card p {
        font-size: 1.2rem !important;
        color: var(--text-muted) !important;
        margin-bottom: 30px !important;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 992px) {
        .liquid-image-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .liquid-question-footer {
            flex-direction: column;
            gap: 15px;
        }
        .liquid-btn {
            width: 100%;
        }
    }

    @media (max-width: 768px) {
        .liquid-quiz-header h1 {
            font-size: 1.5rem !important;
        }
        .liquid-timer {
            font-size: 1.2rem;
            padding: 10px 20px;
        }
        .liquid-question-card {
            padding: 25px;
        }
        .liquid-question-text {
            font-size: 1.2rem !important;
            padding: 15px;
        }
        .liquid-question-grid {
            grid-template-columns: repeat(4, 1fr);
        }
        .liquid-question-dot {
            width: 40px;
            height: 40px;
            font-size: 0.9rem;
        }
    }

    @media (max-width: 576px) {
        .liquid-image-grid {
            grid-template-columns: 1fr;
        }
        .liquid-question-grid {
            grid-template-columns: repeat(3, 1fr);
        }
        .liquid-language-selector {
            width: 100%;
            justify-content: center;
        }
        .liquid-language-btn {
            padding: 8px 16px;
            font-size: 0.85rem;
        }
        .liquid-complete-card {
            padding: 40px 20px;
        }
        .liquid-complete-card h2 {
            font-size: 1.8rem !important;
        }
    }

    /* ===== UTILITY ===== */
    .btn-spinner {
        display: inline-block;
        width: 18px;
        height: 18px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        border-top-color: var(--pure-white);
        animation: spin 1s linear infinite;
    }
</style>

<div class="liquid-quiz-container">
    <div class="liquid-blob liquid-blob-1"></div>
    <div class="liquid-blob liquid-blob-2"></div>
    <div class="liquid-blob liquid-blob-3"></div>

    <div class="container quiz-content">
        <!-- Translation Loading Indicator -->
        <div class="translation-loading" id="translationLoading">
            <i class="fas fa-spinner"></i>
            <span>{{ App\Helpers\TranslationHelper::trans('quiz-take.translating') }}</span>
        </div>

        <!-- Display any session messages -->
        @if(session('error'))
        <div class="liquid-alert liquid-alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ session('error') }}</span>
        </div>
        @endif

        @if(session('success'))
        <div class="liquid-alert liquid-alert-success">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        <!-- Language Selector -->
        <div class="liquid-language-selector">
            <button class="liquid-language-btn active" onclick="changeLanguage('en')" id="langEn">{{ App\Helpers\TranslationHelper::trans('quiz-take.lang_en') }}</button>
            <button class="liquid-language-btn" onclick="changeLanguage('es')" id="langEs">{{ App\Helpers\TranslationHelper::trans('quiz-take.lang_es') }}</button>
            <button class="liquid-language-btn" onclick="changeLanguage('fr')" id="langFr">{{ App\Helpers\TranslationHelper::trans('quiz-take.lang_fr') }}</button>
        </div>

        <!-- Quiz Header -->
        <div class="liquid-quiz-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 id="quizTitle" data-original="{{ $quiz->title }}">{{ $quiz->title }}</h1>
                    <p class="text-white-50">
                        <i class="fas fa-question-circle me-2"></i>
                        <span id="questionCountText" data-original="{{ App\Helpers\TranslationHelper::trans('quiz-take.question_of', ['current' => $attempt->answers->count() + 1, 'total' => $questions->count()]) }}">
                            {{ App\Helpers\TranslationHelper::trans('quiz-take.question_of', ['current' => $attempt->answers->count() + 1, 'total' => $questions->count()]) }}
                        </span>
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    @if($remainingTime)
                    <div class="liquid-timer {{ $remainingTime < 300 ? 'warning' : '' }}" id="timer" data-remaining="{{ $remainingTime }}">
                        <i class="far fa-clock"></i>
                        <span id="timerDisplay">{{ gmdate('H:i:s', $remainingTime) }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <div class="liquid-progress">
                @php
                $progress = ($attempt->answers->count() / $questions->count()) * 100;
                @endphp
                <div class="liquid-progress-bar">
                    <div class="liquid-progress-fill" style="width: {{ $progress }}%;"></div>
                </div>
                <div class="liquid-progress-stats">
                    <span id="answeredCount" data-original="{{ App\Helpers\TranslationHelper::trans('quiz-take.answered_count', ['count' => $attempt->answers->count()]) }}">
                        {{ App\Helpers\TranslationHelper::trans('quiz-take.answered_count', ['count' => $attempt->answers->count()]) }}
                    </span>
                    <span id="remainingCount" data-original="{{ App\Helpers\TranslationHelper::trans('quiz-take.remaining_count', ['count' => $questions->count() - $attempt->answers->count()]) }}">
                        {{ App\Helpers\TranslationHelper::trans('quiz-take.remaining_count', ['count' => $questions->count() - $attempt->answers->count()]) }}
                    </span>
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
                <div class="liquid-question-card">
                    <form action="{{ route('quizzes.submit', ['quiz' => $quiz->id, 'attempt' => $attempt->id]) }}" method="POST" id="quizForm">
                        @csrf

                        <div class="liquid-question-header">
                            <span class="liquid-question-badge" id="questionType" data-original="{{ App\Helpers\TranslationHelper::trans('quiz-take.type_' . $currentQuestion->question_type) }}">
                                {{ App\Helpers\TranslationHelper::trans('quiz-take.type_' . $currentQuestion->question_type) }}
                            </span>
                            <span class="liquid-question-points">
                                <i class="fas fa-star me-1"></i>
                                <span id="questionPoints" data-original="{{ App\Helpers\TranslationHelper::trans('quiz-take.points', ['count' => $currentQuestion->points]) }}">
                                    {{ App\Helpers\TranslationHelper::trans('quiz-take.points', ['count' => $currentQuestion->points]) }}
                                </span>
                            </span>
                        </div>

                        <div class="liquid-question-content">
                            <h3 class="liquid-question-text"
                                id="questionText"
                                data-question-id="{{ $currentQuestion->id }}"
                                data-original="{{ $currentQuestion->question_text }}">
                                {{ $currentQuestion->question_text }}
                            </h3>

                            @if($currentQuestion->image)
                            <div class="text-center mb-4">
                                <img src="{{ $currentQuestion->image_url }}" alt="Question image" class="img-fluid rounded" style="max-height: 300px;">
                            </div>
                            @endif

                            <!-- Multiple Choice / Single Choice / True False Options -->
                            @if(in_array($currentQuestion->question_type, ['multiple_choice', 'single_choice', 'true_false']))
                            <div class="liquid-options-list" id="optionsList">
                                @foreach($currentQuestion->options as $option)
                                <div class="liquid-option-item" onclick="selectOption(this, '{{ $option->id }}')">
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
                                            <div class="liquid-option-image">
                                                <img src="{{ $option->image_url }}" alt="Option image">
                                            </div>
                                            @endif
                                            <span class="option-text"
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
                            <div class="liquid-fill-blank">
                                <div class="form-group">
                                    <input type="text"
                                        class="form-control form-control-lg"
                                        name="answers[{{ $currentQuestion->id }}]"
                                        id="fill_blank_answer"
                                        placeholder="{{ App\Helpers\TranslationHelper::trans('quiz-take.fill_blank_placeholder') }}"
                                        value="{{ old('answers.'.$currentQuestion->id) }}"
                                        required>
                                </div>
                                @if($currentQuestion->fillBlanks->count() > 1)
                                <small class="liquid-hint" id="fillBlankHint" data-original="{{ App\Helpers\TranslationHelper::trans('quiz-take.fill_blank_hint') }}">
                                    <i class="fas fa-info-circle"></i>
                                    {{ App\Helpers\TranslationHelper::trans('quiz-take.fill_blank_hint') }}
                                </small>
                                @endif
                            </div>
                            @endif

                            <!-- Matching -->
                            @if($currentQuestion->question_type == 'matching')
                            <div class="liquid-matching">
                                <div class="liquid-hint mb-4" id="matchingInstruction" data-original="{{ App\Helpers\TranslationHelper::trans('quiz-take.matching_instruction') }}">
                                    <i class="fas fa-arrows-alt-h"></i>
                                    {{ App\Helpers\TranslationHelper::trans('quiz-take.matching_instruction') }}
                                </div>

                                @foreach($currentQuestion->matchingPairs as $pair)
                                <div class="liquid-matching-row">
                                    <div class="row align-items-center">
                                        <div class="col-md-5">
                                            <div class="liquid-matching-left matching-left-item"
                                                data-pair-id="{{ $pair->id }}"
                                                data-original="{{ $pair->left_item }}">
                                                {{ $pair->left_item }}
                                            </div>
                                        </div>
                                        <div class="col-md-2 liquid-matching-arrow">
                                            <i class="fas fa-arrow-right"></i>
                                        </div>
                                        <div class="col-md-5">
                                            <select class="liquid-matching-select matching-select"
                                                name="answers[{{ $currentQuestion->id }}][pair_{{ $pair->id }}]"
                                                required>
                                                <option value="" data-original="{{ App\Helpers\TranslationHelper::trans('quiz-take.matching_select_placeholder') }}">{{ App\Helpers\TranslationHelper::trans('quiz-take.matching_select_placeholder') }}</option>
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
                            <div class="liquid-image-selection">
                                <div class="liquid-image-grid">
                                    @foreach($currentQuestion->options as $option)
                                    <div class="liquid-image-option {{ in_array($option->id, old('answers.'.$currentQuestion->id, [])) ? 'selected' : '' }}" 
                                         onclick="toggleImageSelection(this, '{{ $option->id }}', '{{ $currentQuestion->question_type }}')">
                                        
                                        @if($currentQuestion->question_type == 'multiple_choice')
                                        <input type="checkbox"
                                               name="answers[{{ $currentQuestion->id }}][]"
                                               value="{{ $option->id }}"
                                               id="image_option_{{ $option->id }}"
                                               class="image-selection-input"
                                               {{ in_array($option->id, old('answers.'.$currentQuestion->id, [])) ? 'checked' : '' }}
                                               style="display: none;">
                                        @else
                                        <input type="radio"
                                               name="answers[{{ $currentQuestion->id }}]"
                                               value="{{ $option->id }}"
                                               id="image_option_{{ $option->id }}"
                                               class="image-selection-input"
                                               {{ old('answers.'.$currentQuestion->id) == $option->id ? 'checked' : '' }}
                                               style="display: none;">
                                        @endif
                                        
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

                        <div class="d-flex gap-3 mt-4">
                            <button type="submit" name="action" value="next" class="liquid-btn liquid-btn-primary flex-grow-1" id="nextBtn">
                                @if($attempt->answers->count() + 1 == $questions->count())
                                <span id="submitText" data-original="{{ App\Helpers\TranslationHelper::trans('quiz-take.submit_quiz') }}">{{ App\Helpers\TranslationHelper::trans('quiz-take.submit_quiz') }}</span>
                                <i class="fas fa-check-circle"></i>
                                @else
                                <span id="nextText" data-original="{{ App\Helpers\TranslationHelper::trans('quiz-take.next_question') }}">{{ App\Helpers\TranslationHelper::trans('quiz-take.next_question') }}</span>
                                <i class="fas fa-arrow-right"></i>
                                @endif
                            </button>

                            @if($attempt->answers->count() > 0)
                            <button type="submit" name="action" value="previous" class="liquid-btn liquid-btn-secondary" id="previousBtn">
                                <i class="fas fa-arrow-left"></i>
                                <span id="previousText" data-original="{{ App\Helpers\TranslationHelper::trans('quiz-take.previous_question') }}">{{ App\Helpers\TranslationHelper::trans('quiz-take.previous_question') }}</span>
                            </button>
                            @endif
                        </div>
                    </form>
                </div>
                @else
                <!-- Quiz Complete -->
                <div class="liquid-complete-card">
                    <i class="fas fa-check-circle liquid-complete-icon"></i>
                    <h2 id="completeTitle" data-original="{{ App\Helpers\TranslationHelper::trans('quiz-take.complete_title') }}">{{ App\Helpers\TranslationHelper::trans('quiz-take.complete_title') }}</h2>
                    <p id="completeMessage" data-original="{{ App\Helpers\TranslationHelper::trans('quiz-take.complete_message') }}">{{ App\Helpers\TranslationHelper::trans('quiz-take.complete_message') }}</p>
                    <form action="{{ route('quizzes.submit', ['quiz' => $quiz->id, 'attempt' => $attempt->id]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="action" value="complete">
                        <button type="submit" class="liquid-btn liquid-btn-success" style="padding: 15px 40px; font-size: 1.2rem;" id="submitQuizBtn">
                            <i class="fas fa-check-circle me-2"></i>
                            <span data-original="{{ App\Helpers\TranslationHelper::trans('quiz-take.submit_quiz') }}">{{ App\Helpers\TranslationHelper::trans('quiz-take.submit_quiz') }}</span>
                        </button>
                    </form>
                </div>
                @endif
            </div>

            <div class="col-lg-4">
                <!-- Question Navigator -->
                <div class="liquid-navigator-card">
                    <h5 class="liquid-navigator-title">
                        <i class="fas fa-th"></i>
                        <span id="navigatorTitle" data-original="{{ App\Helpers\TranslationHelper::trans('quiz-take.navigator_title') }}">{{ App\Helpers\TranslationHelper::trans('quiz-take.navigator_title') }}</span>
                    </h5>
                    <div class="liquid-question-grid">
                        @foreach($questions as $index => $question)
                        @php
                        $isAnswered = $attempt->answers->contains('question_id', $question->id);
                        $isCurrent = $index == $attempt->answers->count();
                        @endphp
                        <div class="liquid-question-dot {{ $isAnswered ? 'answered' : '' }} {{ $isCurrent ? 'current' : '' }}">
                            {{ $index + 1 }}
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Quiz Info -->
                <div class="liquid-info-card">
                    <h5 class="liquid-navigator-title">
                        <i class="fas fa-info-circle"></i>
                        <span id="infoTitle" data-original="{{ App\Helpers\TranslationHelper::trans('quiz-take.info_title') }}">{{ App\Helpers\TranslationHelper::trans('quiz-take.info_title') }}</span>
                    </h5>
                    <ul class="liquid-info-list">
                        <li>
                            <i class="fas fa-clock"></i>
                            <span id="timeRemainingLabel" data-original="{{ App\Helpers\TranslationHelper::trans('quiz-take.time_remaining') }}">{{ App\Helpers\TranslationHelper::trans('quiz-take.time_remaining') }}</span>
                            <strong id="timeRemainingValue">{{ $remainingTime ? gmdate('H:i:s', $remainingTime) : App\Helpers\TranslationHelper::trans('quiz-take.no_limit') }}</strong>
                        </li>
                        <li>
                            <i class="fas fa-question-circle"></i>
                            <span id="questionsAnsweredLabel" data-original="{{ App\Helpers\TranslationHelper::trans('quiz-take.questions_answered') }}">{{ App\Helpers\TranslationHelper::trans('quiz-take.questions_answered') }}</span>
                            <strong id="questionsAnsweredValue">{{ $attempt->answers->count() }}/{{ $questions->count() }}</strong>
                        </li>
                        <li>
                            <i class="fas fa-star"></i>
                            <span id="totalPointsLabel" data-original="{{ App\Helpers\TranslationHelper::trans('quiz-take.total_points') }}">{{ App\Helpers\TranslationHelper::trans('quiz-take.total_points') }}</span>
                            <strong id="totalPointsValue">{{ $questions->sum('points') }}</strong>
                        </li>
                        @if($quiz->pass_percentage)
                        <li>
                            <i class="fas fa-trophy"></i>
                            <span id="passingScoreLabel" data-original="{{ App\Helpers\TranslationHelper::trans('quiz-take.passing_score') }}">{{ App\Helpers\TranslationHelper::trans('quiz-take.passing_score') }}</span>
                            <strong id="passingScoreValue">{{ $quiz->pass_percentage }}%</strong>
                        </li>
                        @endif
                        <li>
                            <i class="fas fa-redo"></i>
                            <span id="attemptLabel" data-original="{{ App\Helpers\TranslationHelper::trans('quiz-take.attempt_label') }}">{{ App\Helpers\TranslationHelper::trans('quiz-take.attempt_label') }}</span>
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

<!-- Add CSRF token meta tag for AJAX -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    // Translation API endpoint
    const TRANSLATE_API_URL = "{{ route('translate') }}";

    // Current language (default: English)
    let currentLanguage = 'en';

    // Cache for translations
    const translationCache = new Map();

    // Store original texts for all translatable elements
    let translatableElements = [];

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

        // Select option function - SIMPLIFIED to work with native radio/checkbox behavior
        window.selectOption = function(element, optionId) {
            // Let the browser handle the radio/checkbox click naturally
            // We just need to update the selected class
            const input = element.querySelector('input[type="checkbox"], input[type="radio"]');
            
            if (input) {
                // For radio buttons, remove selected class from other options with the same name
                if (input.type === 'radio') {
                    const name = input.name;
                    document.querySelectorAll(`input[name="${name}"]`).forEach(inp => {
                        const optionDiv = inp.closest('.liquid-option-item');
                        if (optionDiv) {
                            optionDiv.classList.remove('selected');
                        }
                    });
                }
                
                // Add selected class if input is checked
                if (input.checked) {
                    element.classList.add('selected');
                } else {
                    element.classList.remove('selected');
                }
            }
        };

        // Add click handlers to option items that properly handle native checkbox behavior
        document.querySelectorAll('.liquid-option-item').forEach(item => {
            item.addEventListener('click', function(e) {
                // Don't interfere with clicks directly on the input
                if (e.target.tagName === 'INPUT' || e.target.tagName === 'LABEL') {
                    return;
                }
                
                const input = this.querySelector('input[type="checkbox"], input[type="radio"]');
                if (input) {
                    e.preventDefault();
                    
                    if (input.type === 'radio') {
                        input.checked = true;
                    } else {
                        input.checked = !input.checked;
                    }
                    
                    // Trigger change event
                    input.dispatchEvent(new Event('change', { bubbles: true }));
                    
                    // Update selected class
                    if (input.type === 'radio') {
                        // Remove selected class from all radio options with same name
                        const name = input.name;
                        document.querySelectorAll(`input[name="${name}"]`).forEach(inp => {
                            const optionDiv = inp.closest('.liquid-option-item');
                            if (optionDiv) {
                                optionDiv.classList.remove('selected');
                            }
                        });
                    }
                    
                    // Add selected class if input is checked
                    if (input.checked) {
                        this.classList.add('selected');
                    } else {
                        this.classList.remove('selected');
                    }
                }
            });
        });

        // Handle input changes directly
        document.querySelectorAll('.liquid-option-item input[type="checkbox"], .liquid-option-item input[type="radio"]').forEach(input => {
            input.addEventListener('change', function() {
                const optionDiv = this.closest('.liquid-option-item');
                if (!optionDiv) return;
                
                if (this.type === 'radio' && this.checked) {
                    // Remove selected class from all radio options with same name
                    const name = this.name;
                    document.querySelectorAll(`input[name="${name}"]`).forEach(inp => {
                        const div = inp.closest('.liquid-option-item');
                        if (div) {
                            div.classList.remove('selected');
                        }
                    });
                    optionDiv.classList.add('selected');
                } else if (this.type === 'checkbox') {
                    if (this.checked) {
                        optionDiv.classList.add('selected');
                    } else {
                        optionDiv.classList.remove('selected');
                    }
                }
            });
        });

        // Image selection toggle - SIMPLIFIED
        window.toggleImageSelection = function(element, optionId, questionType) {
            const input = element.querySelector('input.image-selection-input');
            if (!input) return;
            
            if (questionType === 'multiple_choice') {
                input.checked = !input.checked;
                element.classList.toggle('selected', input.checked);
            } else {
                const name = input.name;
                document.querySelectorAll(`input[name="${name}"]`).forEach(inp => {
                    inp.closest('.liquid-image-option')?.classList.remove('selected');
                    inp.checked = false;
                });
                input.checked = true;
                element.classList.add('selected');
            }
            input.dispatchEvent(new Event('change', { bubbles: true }));
        };

        // Initialize image selections on page load
        document.querySelectorAll('.liquid-image-option').forEach(option => {
            const input = option.querySelector('input.image-selection-input');
            if (input && input.checked) {
                option.classList.add('selected');
            }
        });

        // Initialize selected class for options
        document.querySelectorAll('.liquid-option-item input[type="radio"]:checked, .liquid-option-item input[type="checkbox"]:checked').forEach(input => {
            const optionDiv = input.closest('.liquid-option-item');
            if (optionDiv) {
                optionDiv.classList.add('selected');
            }
        });

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
                    alert('{{ App\Helpers\TranslationHelper::trans('quiz-take.confirm_no_answer') }}');
                    return false;
                }

                if (action === 'complete' || (action === 'next' && {{ $attempt->answers->count() + 1 }} == {{ $questions->count() }})) {
                    if (!confirm('{{ App\Helpers\TranslationHelper::trans('quiz-take.confirm_submit') }}')) {
                        e.preventDefault();
                        return false;
                    }
                }

                // Show loading state on button
                const submitBtn = e.submitter;
                if (submitBtn) {
                    submitBtn.innerHTML = '<span class="btn-spinner"></span> {{ App\Helpers\TranslationHelper::trans('quiz-take.saving') }}';
                    submitBtn.disabled = true;
                }
            });
        }

        // Helper function to check if any answer is selected
        function hasSelectedAnswer() {
            const inputs = document.querySelectorAll('input[type="radio"]:checked, input[type="checkbox"]:checked');
            return inputs.length > 0;
        }
    });

    // Initialize all translatable elements
    function initializeTranslatableElements() {
        translatableElements = [];

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

        const submitBtnSpan = document.querySelector('#submitQuizBtn span');
        if (submitBtnSpan && submitBtnSpan.dataset.original) {
            translatableElements.push({
                element: submitBtnSpan,
                original: submitBtnSpan.dataset.original
            });
        }

        console.log('Total translatable elements:', translatableElements.length);
    }

    // Change language function
    async function changeLanguage(lang) {
        if (lang === currentLanguage) return;

        const loadingEl = document.getElementById('translationLoading');
        if (loadingEl) {
            loadingEl.style.display = 'flex';
        }

        try {
            // Update active button state
            document.querySelectorAll('.liquid-language-btn').forEach(btn => btn.classList.remove('active'));
            const activeBtn = document.getElementById(`lang${lang.toUpperCase()}`);
            if (activeBtn) {
                activeBtn.classList.add('active');
            }

            initializeTranslatableElements();

            // Translate all elements
            for (const item of translatableElements) {
                if (item.element) {
                    try {
                        const translated = await translateText(item.original, currentLanguage, lang);
                        if (item.element) {
                            item.element.textContent = translated;
                        }
                    } catch (error) {
                        console.error('Translation error for element:', error);
                    }
                }
            }

            currentLanguage = lang;

        } catch (error) {
            console.error('Translation error:', error);
            alert('{{ App\Helpers\TranslationHelper::trans('quiz-take.translation_failed') }}');
        } finally {
            if (loadingEl) {
                loadingEl.style.display = 'none';
            }
        }
    }

    // Translate text using the Laravel proxy
    async function translateText(text, sourceLang, targetLang) {
        const cacheKey = `${text}_${sourceLang}_${targetLang}`;
        if (translationCache.has(cacheKey)) {
            return translationCache.get(cacheKey);
        }

        if (sourceLang === targetLang || !text || text.trim().length < 2) return text;

        try {
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
            const translatedText = data.translatedText || text;
            translationCache.set(cacheKey, translatedText);
            return translatedText;
        } catch (error) {
            console.error('Translation error:', error);
            return text;
        }
    }
</script>
@endsection