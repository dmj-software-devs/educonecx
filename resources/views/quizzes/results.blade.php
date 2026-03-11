@extends('layouts.main')

@section('title', App\Helpers\TranslationHelper::trans('quiz-results.page_title', ['title' => $quiz->title]))

@section('meta_description', App\Helpers\TranslationHelper::trans('quiz-results.meta_description'))

@push('styles')
<style>
    /* ===== LIQUID QUIZ RESULTS PAGE - YOUR BEAUTIFUL COLORS ===== */
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
        --danger: #ef4444;
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
    .liquid-results-container {
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

    /* ===== MARKETING BANNER ===== */
    .marketing-banner {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        border-radius: var(--radius-lg);
        padding: 20px 32px;
        margin-bottom: 30px;
        color: var(--white);
        box-shadow: var(--shadow-lg);
        display: flex;
        align-items: center;
        gap: 20px;
        animation: slideInFade 1s ease-out;
        border: 1px solid rgba(251, 198, 12, 0.3);
        position: relative;
        z-index: 2;
    }

    .banner-icon {
        font-size: 3rem;
        color: var(--accent);
        animation: pulse 2s infinite;
    }

    .banner-text {
        font-size: 1.3rem;
        font-weight: 600;
        margin: 0;
        line-height: 1.4;
    }

    .banner-text span {
        color: var(--accent);
        font-weight: 700;
    }

    @keyframes slideInFade {
        0% {
            opacity: 0;
            transform: translateY(-20px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }

    /* ===== CONTENT WRAPPER ===== */
    .results-content {
        position: relative;
        z-index: 2;
    }

    /* ===== ALERTS ===== */
    .liquid-alert {
        border-radius: var(--radius-md);
        padding: 16px 20px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 0.95rem;
        animation: slideDown 0.3s ease;
        border: 1px solid transparent;
        position: relative;
        z-index: 2;
    }

    .liquid-alert-success {
        background: rgba(90, 209, 228, 0.1);
        color: var(--dark-slate);
        border-left: 4px solid var(--sky-blue);
    }

    .liquid-alert-info {
        background: rgba(24, 56, 110, 0.08);
        color: var(--regal-navy);
        border-left: 4px solid var(--regal-navy);
    }

    .liquid-alert-warning {
        background: rgba(251, 198, 12, 0.1);
        color: #b85e00;
        border-left: 4px solid var(--bright-amber);
    }

    .liquid-alert i {
        font-size: 1.2rem;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ===== MAIN CARD ===== */
    .liquid-card {
        background: var(--pure-white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-lg);
        padding: 40px;
        margin-bottom: 24px;
        transition: var(--transition);
        border: 1px solid rgba(251, 198, 12, 0.1);
        position: relative;
        overflow: hidden;
        z-index: 2;
    }

    .liquid-card:hover {
        box-shadow: var(--shadow-hover);
        border-color: var(--bright-amber);
    }

    .liquid-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: var(--gradient-liquid-2);
        transform: scaleX(0);
        transition: transform 0.3s ease;
        transform-origin: left;
    }

    .liquid-card:hover::before {
        transform: scaleX(1);
    }

    /* ===== HEADER ===== */
    .liquid-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .liquid-icon {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px;
        font-size: 3rem;
        animation: pop 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        box-shadow: var(--shadow-lg);
    }

    .liquid-icon-passed {
        background: var(--gradient-liquid-3);
        color: var(--pure-white);
    }

    .liquid-icon-failed {
        background: var(--gradient-liquid-1);
        color: var(--pure-white);
    }

    @keyframes pop {
        0% { transform: scale(0); }
        70% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }

    .liquid-title {
        font-size: 2.2rem;
        font-weight: 800;
        color: var(--text-primary);
        margin-bottom: 8px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .liquid-subtitle {
        color: var(--text-muted);
        font-size: 1.1rem;
        font-weight: 400;
    }

    /* ===== SCORE SECTION ===== */
    .liquid-score-container {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 50px;
        margin-bottom: 50px;
        flex-wrap: wrap;
    }

    .liquid-score-circle {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background: var(--gradient-liquid-2);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: var(--prussian-blue);
        box-shadow: var(--shadow-hover);
        position: relative;
        animation: float 3s ease-in-out infinite;
        padding: 0 15px;
        text-align: center;
    }

    .liquid-score-circle::before {
        content: '';
        position: absolute;
        top: 8px;
        left: 8px;
        right: 8px;
        bottom: 8px;
        border-radius: 50%;
        border: 2px solid rgba(255, 255, 255, 0.3);
        animation: pulse 2s ease-in-out infinite;
        pointer-events: none;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 0.5; }
        50% { transform: scale(1.05); opacity: 0.8; }
    }

    .liquid-score-percentage {
        font-size: 3.2rem;
        font-weight: 800;
        line-height: 1.1;
        margin-bottom: 5px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        max-width: 100%;
        word-break: break-word;
        display: block;
        width: 100%;
        color: var(--prussian-blue);
    }

    .liquid-score-label {
        font-size: 0.95rem;
        opacity: 0.9;
        letter-spacing: 1px;
        text-transform: uppercase;
        display: block;
        width: 100%;
        color: var(--prussian-blue);
    }

    .liquid-score-details {
        text-align: left;
        flex: 1;
        min-width: 200px;
    }

    .liquid-score-points {
        font-size: 2rem;
        font-weight: 800;
        color: var(--text-primary);
        margin-bottom: 8px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .liquid-score-passing {
        color: var(--text-muted);
        font-size: 1rem;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .liquid-score-passing i {
        color: var(--bright-amber);
        font-size: 1rem;
    }

    .liquid-score-status {
        display: inline-block;
        padding: 10px 30px;
        border-radius: var(--radius-full);
        font-weight: 700;
        font-size: 1.1rem;
        letter-spacing: 1px;
        box-shadow: var(--shadow-md);
    }

    .liquid-score-status-passed {
        background: var(--gradient-liquid-3);
        color: var(--prussian-blue);
    }

    .liquid-score-status-failed {
        background: var(--gradient-liquid-1);
        color: var(--pure-white);
    }

    /* ===== STATS GRID ===== */
    .liquid-stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 50px;
    }

    .liquid-stat-item {
        background: linear-gradient(135deg, var(--ivory), var(--pure-white));
        border-radius: var(--radius-md);
        padding: 25px 15px;
        text-align: center;
        transition: var(--transition);
        border: 1px solid rgba(251, 198, 12, 0.1);
    }

    .liquid-stat-item:hover {
        transform: translateY(-5px);
        background: var(--pure-white);
        box-shadow: var(--shadow-hover);
        border-color: var(--bright-amber);
    }

    .liquid-stat-value {
        font-size: 2rem;
        font-weight: 800;
        color: var(--bright-amber);
        margin-bottom: 8px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .liquid-stat-label {
        color: var(--text-muted);
        font-size: 0.9rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* ===== ACCORDION STYLES ===== */
    .accordion-section {
        background: var(--white);
        border-radius: var(--radius-md);
        margin-bottom: 20px;
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(251, 198, 12, 0.1);
        overflow: hidden;
    }

    .accordion-header {
        padding: 20px 25px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: var(--transition);
        border-left: 4px solid var(--accent);
    }

    .accordion-header:hover {
        background: var(--primary-dark);
    }

    .accordion-header h3,
    .accordion-header h4 {
        margin: 0;
        color: var(--white);
        font-size: 1.2rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .accordion-header i {
        color: var(--accent);
        transition: transform 0.3s ease;
        font-size: 1.1rem;
    }

    .accordion-header.collapsed i {
        transform: rotate(180deg);
    }

    .accordion-content {
        padding: 25px;
        background: var(--white);
        border-top: 1px solid var(--gray-light);
        display: block;
    }

    .accordion-content.collapsed {
        display: none;
    }

    /* ===== CORRECT ANSWERS SECTION ===== */
    .correct-answers-section {
        margin-top: 30px;
        display: none;
    }

    .correct-answers-section.visible {
        display: block;
    }

    .correct-answers-header {
        background: var(--gradient-liquid-1);
        color: var(--white);
        padding: 20px 25px;
        border-radius: var(--radius-md);
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
        border-left: 4px solid var(--accent);
    }

    .correct-answers-header h3 {
        margin: 0;
        font-size: 1.3rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .correct-answers-header i {
        color: var(--accent);
        transition: transform 0.3s ease;
    }

    .correct-answers-header.collapsed i {
        transform: rotate(180deg);
    }

    .correct-answers-content {
        display: block;
    }

    .correct-answers-content.collapsed {
        display: none;
    }

    /* ===== QUESTIONS REVIEW ===== */
    .liquid-questions-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--text-primary);
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .liquid-questions-title i {
        color: var(--bright-amber);
        font-size: 1.3rem;
    }

    .liquid-question-item {
        background: linear-gradient(135deg, var(--ivory), var(--pure-white));
        border-radius: var(--radius-md);
        padding: 25px;
        margin-bottom: 20px;
        border-left: 4px solid transparent;
        transition: var(--transition);
        border: 1px solid rgba(251, 198, 12, 0.1);
    }

    .liquid-question-item:hover {
        transform: translateX(5px);
        box-shadow: var(--shadow-hover);
        background: var(--pure-white);
        border-color: var(--bright-amber);
    }

    .liquid-question-correct {
        border-left-color: var(--sky-blue);
    }

    .liquid-question-incorrect {
        border-left-color: var(--danger);
    }

    .liquid-question-partial {
        border-left-color: var(--bright-amber);
    }

    .liquid-question-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .liquid-question-meta {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .liquid-question-number {
        background: var(--pure-white);
        padding: 4px 12px;
        border-radius: var(--radius-full);
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--bright-amber);
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(251, 198, 12, 0.2);
    }

    .liquid-question-type {
        background: var(--pure-white);
        padding: 4px 12px;
        border-radius: var(--radius-full);
        font-size: 0.8rem;
        color: var(--text-muted);
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(251, 198, 12, 0.1);
    }

    .liquid-question-points {
        padding: 4px 15px;
        border-radius: var(--radius-full);
        font-size: 0.8rem;
        font-weight: 600;
    }

    .liquid-points-correct {
        background: var(--gradient-liquid-3);
        color: var(--prussian-blue);
    }

    .liquid-points-incorrect {
        background: var(--gradient-liquid-1);
        color: var(--pure-white);
    }

    .liquid-points-partial {
        background: var(--gradient-liquid-2);
        color: var(--prussian-blue);
    }

    .liquid-question-text {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 20px;
        line-height: 1.5;
    }

    /* ===== LEGEND ===== */
    .liquid-legend {
        display: flex;
        gap: 20px;
        margin-bottom: 15px;
        flex-wrap: wrap;
    }

    .liquid-legend-item {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .liquid-legend-color {
        width: 16px;
        height: 16px;
        border-radius: 4px;
    }

    .liquid-legend-color.correct {
        background: rgba(90, 209, 228, 0.1);
        border: 2px solid var(--sky-blue);
    }

    .liquid-legend-color.incorrect {
        background: rgba(239, 68, 68, 0.1);
        border: 2px solid var(--danger);
    }

    .liquid-legend-color.missed {
        background: rgba(251, 198, 12, 0.1);
        border: 2px solid var(--bright-amber);
    }

    .liquid-legend-text {
        font-size: 0.85rem;
        color: var(--text-muted);
    }

    /* ===== OPTION ITEMS ===== */
    .liquid-option-item {
        transition: var(--transition);
        margin-bottom: 8px;
        padding: 12px;
        border-radius: var(--radius-sm);
        background: var(--pure-white);
        border: 1px solid rgba(251, 198, 12, 0.1);
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .liquid-option-item:hover {
        transform: translateX(5px);
        border-color: var(--bright-amber);
        box-shadow: var(--shadow-sm);
    }

    .liquid-option-correct {
        border-left: 4px solid var(--sky-blue);
    }

    .liquid-option-incorrect {
        border-left: 4px solid var(--danger);
    }

    .liquid-option-missed {
        border-left: 4px solid var(--bright-amber);
    }

    .liquid-option-letter {
        width: 30px;
        height: 30px;
        background: var(--ivory);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: var(--bright-amber);
        flex-shrink: 0;
    }

    .liquid-option-text {
        flex: 1;
        color: var(--text-primary);
        font-size: 0.95rem;
    }

    .liquid-badge {
        display: inline-block;
        padding: 2px 8px;
        border-radius: var(--radius-full);
        font-size: 0.7rem;
        font-weight: 600;
        margin-left: 8px;
        flex-shrink: 0;
    }

    .liquid-badge-correct {
        background: var(--gradient-liquid-3);
        color: var(--prussian-blue);
    }

    .liquid-badge-incorrect {
        background: var(--gradient-liquid-1);
        color: var(--pure-white);
    }

    .liquid-badge-missed {
        background: var(--gradient-liquid-2);
        color: var(--prussian-blue);
    }

    .liquid-badge-user {
        background: var(--regal-navy);
        color: var(--pure-white);
    }

    /* ===== ANSWER BOX ===== */
    .liquid-answer-box {
        background: linear-gradient(135deg, var(--pure-white), var(--ivory));
        border-radius: var(--radius-sm);
        padding: 15px;
        margin-top: 15px;
        border: 1px solid rgba(251, 198, 12, 0.1);
    }

    .liquid-answer-label {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.9rem;
        color: var(--text-muted);
        margin-bottom: 8px;
    }

    .liquid-answer-label i {
        color: var(--bright-amber);
        font-size: 0.9rem;
    }

    .liquid-answer-value {
        padding: 12px 15px;
        background: var(--pure-white);
        border-radius: var(--radius-sm);
        color: var(--text-primary);
        font-size: 0.95rem;
        border: 1px solid rgba(251, 198, 12, 0.1);
    }

    .liquid-correct-answer {
        padding: 12px 15px;
        background: rgba(90, 209, 228, 0.05);
        border-radius: var(--radius-sm);
        color: var(--dark-slate);
        font-weight: 500;
        border: 1px solid rgba(90, 209, 228, 0.2);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .liquid-correct-answer i {
        color: var(--sky-blue);
        font-size: 1rem;
    }

    /* ===== BUTTONS ===== */
    .liquid-actions {
        display: flex;
        gap: 15px;
        justify-content: center;
        margin-top: 40px;
        flex-wrap: wrap;
    }

    .liquid-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 14px 32px;
        border-radius: var(--radius-full);
        font-size: 0.95rem;
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
        border: none;
        cursor: pointer;
        min-width: 160px;
        position: relative;
        overflow: hidden;
    }

    .liquid-btn::before {
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
        transform: translateY(-3px);
        box-shadow: var(--shadow-hover);
    }

    .liquid-btn-secondary {
        background: var(--pure-white);
        color: var(--text-primary);
        border: 2px solid var(--pale-slate);
    }

    .liquid-btn-secondary:hover {
        background: var(--ivory);
        color: var(--bright-amber);
        border-color: var(--bright-amber);
        transform: translateY(-3px);
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

    /* ===== RESTART MODAL ===== */
    .restart-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(10, 29, 68, 0.8);
        z-index: 10000;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(5px);
    }

    .restart-modal.active {
        display: flex;
    }

    .restart-modal-content {
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 40px;
        max-width: 500px;
        width: 90%;
        text-align: center;
        animation: modalSlideIn 0.3s ease;
        border: 1px solid var(--accent);
        box-shadow: var(--shadow-lg);
    }

    .restart-modal-icon {
        font-size: 4rem;
        color: var(--warning);
        margin-bottom: 20px;
    }

    .restart-modal h3 {
        font-size: 1.8rem;
        color: var(--text-primary);
        margin-bottom: 15px;
    }

    .restart-modal p {
        color: var(--text-muted);
        margin-bottom: 30px;
        font-size: 1.1rem;
        line-height: 1.6;
        background: var(--ivory);
        padding: 20px;
        border-radius: var(--radius-md);
        border-left: 4px solid var(--warning);
    }

    .restart-modal-actions {
        display: flex;
        gap: 15px;
        justify-content: center;
    }

    .restart-modal-btn {
        padding: 14px 30px;
        border-radius: var(--radius-full);
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        border: none;
    }

    .restart-modal-btn.cancel {
        background: var(--gray-light);
        color: var(--text-primary);
    }

    .restart-modal-btn.cancel:hover {
        background: var(--gray);
    }

    .restart-modal-btn.confirm {
        background: var(--warning);
        color: var(--prussian-blue);
    }

    .restart-modal-btn.confirm:hover {
        background: var(--bright-amber);
        transform: translateY(-2px);
        box-shadow: var(--shadow-hover);
    }

    @keyframes modalSlideIn {
        from {
            opacity: 0;
            transform: translateY(-50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ===== SHARE CARD ===== */
    .liquid-share-card {
        background: var(--gradient-liquid-2);
        border-radius: var(--radius-lg);
        padding: 40px;
        text-align: center;
        color: var(--prussian-blue);
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-lg);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .liquid-share-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
    }

    .liquid-share-card::after {
        content: '';
        position: absolute;
        bottom: -50%;
        left: -10%;
        width: 250px;
        height: 250px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 8s ease-in-out infinite reverse;
    }

    .liquid-share-content {
        position: relative;
        z-index: 2;
    }

    .liquid-share-title {
        font-size: 1.5rem;
        font-weight: 800;
        margin-bottom: 10px;
        color: var(--prussian-blue);
    }

    .liquid-share-text {
        opacity: 0.9;
        margin-bottom: 25px;
        font-size: 1rem;
        color: var(--prussian-blue);
    }

    .liquid-share-buttons {
        display: flex;
        gap: 15px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .liquid-share-btn {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--prussian-blue);
        text-decoration: none;
        transition: var(--transition);
        font-size: 1.2rem;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .liquid-share-btn:hover {
        transform: translateY(-5px) scale(1.1);
        background: rgba(255, 255, 255, 0.3);
        color: var(--prussian-blue);
    }

    /* ===== LOADING SPINNER ===== */
    .btn-spinner {
        display: inline-block;
        width: 18px;
        height: 18px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        border-top-color: var(--pure-white);
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 992px) {
        .liquid-card {
            padding: 30px;
        }
        .liquid-stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }
        .liquid-score-percentage {
            font-size: 3rem;
        }
    }

    @media (max-width: 768px) {
        .liquid-results-container {
            padding: 30px 0;
        }
        .liquid-card {
            padding: 25px;
        }
        .liquid-title {
            font-size: 1.8rem;
        }
        .liquid-subtitle {
            font-size: 1rem;
        }
        .liquid-score-container {
            flex-direction: column;
            gap: 30px;
            text-align: center;
        }
        .liquid-score-details {
            text-align: center;
        }
        .liquid-score-passing {
            justify-content: center;
        }
        .liquid-score-circle {
            width: 180px;
            height: 180px;
        }
        .liquid-score-percentage {
            font-size: 2.8rem;
        }
        .liquid-stats-grid {
            grid-template-columns: 1fr;
            gap: 12px;
        }
        .liquid-actions {
            flex-direction: column;
            gap: 12px;
        }
        .liquid-btn {
            width: 100%;
            min-width: auto;
        }
        .marketing-banner {
            padding: 16px 20px;
        }
        .banner-text {
            font-size: 1rem;
        }
        .banner-icon {
            font-size: 2rem;
        }
    }

    @media (max-width: 576px) {
        .liquid-results-container {
            padding: 20px 0;
        }
        .liquid-card {
            padding: 20px;
        }
        .liquid-icon {
            width: 70px;
            height: 70px;
            font-size: 2.2rem;
        }
        .liquid-title {
            font-size: 1.4rem;
        }
        .liquid-subtitle {
            font-size: 0.9rem;
        }
        .liquid-score-circle {
            width: 150px;
            height: 150px;
        }
        .liquid-score-percentage {
            font-size: 2.4rem;
        }
        .liquid-score-points {
            font-size: 1.5rem;
        }
        .liquid-score-status {
            padding: 8px 20px;
            font-size: 0.95rem;
        }
        .liquid-stat-value {
            font-size: 1.5rem;
        }
        .liquid-questions-title {
            font-size: 1.2rem;
        }
        .liquid-question-item {
            padding: 18px;
        }
        .liquid-question-text {
            font-size: 0.95rem;
        }
        .liquid-option-item {
            padding: 10px;
        }
        .liquid-option-letter {
            width: 25px;
            height: 25px;
            font-size: 0.8rem;
        }
        .liquid-option-text {
            font-size: 0.85rem;
        }
        .liquid-legend {
            gap: 10px;
        }
        .liquid-legend-item {
            font-size: 0.75rem;
        }
        .liquid-share-card {
            padding: 30px 20px;
        }
        .liquid-share-title {
            font-size: 1.2rem;
        }
        .liquid-share-text {
            font-size: 0.85rem;
        }
        .liquid-share-btn {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }
    }

    /* ===== PRINT STYLES ===== */
    @media print {
        .liquid-results-container {
            background: white;
            padding: 20px;
        }
        .liquid-card {
            box-shadow: none;
            border: 1px solid #ddd;
        }
        .liquid-actions,
        .liquid-share-card,
        .liquid-blob,
        .marketing-banner,
        .restart-modal {
            display: none !important;
        }
    }
</style>
@endpush

@section('content')
<div class="liquid-results-container">
    <div class="liquid-blob liquid-blob-1"></div>
    <div class="liquid-blob liquid-blob-2"></div>
    <div class="liquid-blob liquid-blob-3"></div>

    <div class="container results-content">
        <!-- Marketing Banner -->
        <div class="marketing-banner">
            <div class="banner-icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="banner-text">
                <span>$ Take the Quiz. Hit the Recommended Score. Compete for Weekly Cash Rewards.</span>
            </div>
        </div>

        <!-- Restart Confirmation Modal -->
        <div class="restart-modal" id="restartModal">
            <div class="restart-modal-content">
                <div class="restart-modal-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <h3>Warning</h3>
                <p>Warning: If you restart the quiz, your current progress and score will be permanently lost and the quiz will restart from zero.</p>
                <div class="restart-modal-actions">
                    <button class="restart-modal-btn cancel" onclick="closeRestartModal()">Cancel</button>
                    <form id="restartForm" method="POST" action="{{ route('quizzes.start', $quiz->id) }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="restart-modal-btn confirm">Confirm Restart</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
        <div class="liquid-alert liquid-alert-success">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') ?? App\Helpers\TranslationHelper::trans('quiz-results.success_message') }}</span>
        </div>
        @endif

        @if(session('info'))
        <div class="liquid-alert liquid-alert-info">
            <i class="fas fa-info-circle"></i>
            <span>{{ session('info') ?? App\Helpers\TranslationHelper::trans('quiz-results.info_message') }}</span>
        </div>
        @endif

        @if(session('error'))
        <div class="liquid-alert liquid-alert-warning">
            <i class="fas fa-exclamation-triangle"></i>
            <span>{{ session('error') ?? App\Helpers\TranslationHelper::trans('quiz-results.error_message') }}</span>
        </div>
        @endif

        <!-- Main Results Card -->
        <div class="liquid-card">
            <!-- Header with Status -->
            <div class="liquid-header">
                <div class="liquid-icon {{ $passed ? 'liquid-icon-passed' : 'liquid-icon-failed' }}">
                    <i class="fas {{ $passed ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                </div>
                <h1 class="liquid-title">{{ App\Helpers\TranslationHelper::trans('quiz-results.quiz_completed') }}</h1>
                <p class="liquid-subtitle">{{ $quiz->title }}</p>
            </div>

            <!-- Score Section -->
            <div class="liquid-score-container">
                <div class="liquid-score-circle">
                    <span class="liquid-score-percentage">{{ $percentage }}%</span>
                    <span class="liquid-score-label">{{ App\Helpers\TranslationHelper::trans('quiz-results.score_label') }}</span>
                </div>
                <div class="liquid-score-details">
                    <div class="liquid-score-points">{{ $earnedPoints }}/{{ $totalPoints }}</div>
                    <div class="liquid-score-passing">
                        <i class="fas fa-flag-checkered"></i>
                        {{ App\Helpers\TranslationHelper::trans('quiz-results.passing_score', ['percentage' => $quiz->pass_percentage]) }}
                    </div>
                    <div class="liquid-score-status {{ $passed ? 'liquid-score-status-passed' : 'liquid-score-status-failed' }}">
                        {{ $passed ? App\Helpers\TranslationHelper::trans('quiz-results.passed') : App\Helpers\TranslationHelper::trans('quiz-results.failed') }}
                    </div>
                </div>
            </div>

            <!-- Stats Grid (Collapsible) -->
            <div class="accordion-section">
                <div class="accordion-header" onclick="toggleAccordion('statsAccordion', this)">
                    <h4>
                        <i class="fas fa-chart-bar"></i>
                        Performance Statistics
                    </h4>
                    <i class="fas fa-chevron-up"></i>
                </div>
                <div class="accordion-content" id="statsAccordion">
                    <div class="liquid-stats-grid">
                        <div class="liquid-stat-item">
                            <div class="liquid-stat-value">{{ $attempt->answers->count() }}</div>
                            <div class="liquid-stat-label">{{ App\Helpers\TranslationHelper::trans('quiz-results.questions_answered') }}</div>
                        </div>
                        <div class="liquid-stat-item">
                            <div class="liquid-stat-value">{{ $quiz->questions->count() }}</div>
                            <div class="liquid-stat-label">{{ App\Helpers\TranslationHelper::trans('quiz-results.total_questions') }}</div>
                        </div>
                        <div class="liquid-stat-item">
                            <div class="liquid-stat-value">#{{ $attempt->attempt_number }}</div>
                            <div class="liquid-stat-label">{{ App\Helpers\TranslationHelper::trans('quiz-results.attempt_number') }}</div>
                        </div>
                        <div class="liquid-stat-item">
                            <div class="liquid-stat-value">{{ $attempt->completed_at ? $attempt->completed_at->format(App\Helpers\TranslationHelper::trans('quiz-results.date_format')) : App\Helpers\TranslationHelper::trans('quiz-results.na') }}</div>
                            <div class="liquid-stat-label">{{ App\Helpers\TranslationHelper::trans('quiz-results.completed_on') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Correct Answers Section (Hidden by Default) -->
            @if($quiz->show_answers)
            <div class="correct-answers-section" id="correctAnswersSection">
                <div class="correct-answers-header" onclick="toggleCorrectAnswers()">
                    <h3>
                        <i class="fas fa-check-circle"></i>
                        Correct Answers Review
                    </h3>
                    <i class="fas fa-chevron-up" id="answersChevron"></i>
                </div>
                <div class="correct-answers-content" id="answersContent">
                    @foreach($quiz->questions as $index => $question)
                    @php
                    $answer = $answers[$question->id] ?? null;
                    $isCorrect = $answer ? $answer->is_correct : false;
                    $pointsEarned = $answer ? $answer->points_earned : 0;
                    $statusClass = $isCorrect ? 'liquid-question-correct' : ($pointsEarned > 0 ? 'liquid-question-partial' : 'liquid-question-incorrect');
                    $pointsClass = $isCorrect ? 'liquid-points-correct' : ($pointsEarned > 0 ? 'liquid-points-partial' : 'liquid-points-incorrect');

                    // Decode answer data
                    $answerData = $answer ? $answer->decoded_data : null;
                    @endphp

                    <div class="liquid-question-item {{ $statusClass }}">
                        <div class="liquid-question-header">
                            <div class="liquid-question-meta">
                                <span class="liquid-question-number">{{ App\Helpers\TranslationHelper::trans('quiz-results.question_number', ['number' => $index + 1]) }}</span>
                                <span class="liquid-question-type">{{ str_replace('_', ' ', ucfirst($question->question_type)) }}</span>
                            </div>
                            <span class="liquid-question-points {{ $pointsClass }}">
                                {{ App\Helpers\TranslationHelper::trans('quiz-results.points_earned', ['earned' => $pointsEarned, 'total' => $question->points]) }}
                            </span>
                        </div>

                        <div class="liquid-question-text">{{ $question->question_text }}</div>

                        @if($question->image)
                        <div style="margin-bottom: 15px;">
                            <img src="{{ Storage::url($question->image) }}" alt="Question image" style="max-width: 100%; max-height: 200px; border-radius: var(--radius-sm); box-shadow: var(--shadow-md);">
                        </div>
                        @endif

                        <!-- Show ALL options with user's answers and correct answers -->
                        <div class="liquid-legend">
                            <div class="liquid-legend-item">
                                <span class="liquid-legend-color correct"></span>
                                <span class="liquid-legend-text">{{ App\Helpers\TranslationHelper::trans('quiz-results.legend_correct') }}</span>
                            </div>
                            <div class="liquid-legend-item">
                                <span class="liquid-legend-color incorrect"></span>
                                <span class="liquid-legend-text">{{ App\Helpers\TranslationHelper::trans('quiz-results.legend_incorrect') }}</span>
                            </div>
                            <div class="liquid-legend-item">
                                <span class="liquid-legend-color missed"></span>
                                <span class="liquid-legend-text">{{ App\Helpers\TranslationHelper::trans('quiz-results.legend_missed') }}</span>
                            </div>
                        </div>

                        @include('quizzes.partials.answer-display', [
                        'question' => $question,
                        'answerData' => $answerData,
                        'type' => 'user'
                        ])

                        <!-- Question Explanation -->
                        @if($question->explanation)
                        <div class="liquid-answer-box">
                            <div class="liquid-answer-label">
                                <i class="fas fa-lightbulb" style="color: var(--bright-amber);"></i>
                                {{ App\Helpers\TranslationHelper::trans('quiz-results.explanation') }}
                            </div>
                            <div style="color: var(--text-primary); font-size: 0.95rem; line-height: 1.6; padding: 10px; background: var(--pure-white); border-radius: var(--radius-sm);">
                                {{ $question->explanation }}
                            </div>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="liquid-actions">
                @if($quiz->can_attempt)
                <button class="liquid-btn liquid-btn-primary" onclick="showRestartModal()">
                    <i class="fas fa-redo-alt"></i>
                    <span>Retry Quiz</span>
                </button>
                @endif

                @if($quiz->show_answers)
                <button class="liquid-btn liquid-btn-success" onclick="toggleCorrectAnswers()" id="viewAnswersBtn">
                    <i class="fas fa-eye"></i>
                    <span>View Correct Answers</span>
                </button>
                @endif

                <a href="{{ route('quiz') }}" class="liquid-btn liquid-btn-secondary">
                    <i class="fas fa-th-large"></i>
                    <span>{{ App\Helpers\TranslationHelper::trans('quiz-results.more_quizzes') }}</span>
                </a>

                @if(Auth::user())
                <a href="{{ route('dashboard') }}" class="liquid-btn liquid-btn-secondary">
                    <i class="fas fa-chart-pie"></i>
                    <span>{{ App\Helpers\TranslationHelper::trans('quiz-results.dashboard') }}</span>
                </a>
                @endif

                <button onclick="window.print()" class="liquid-btn liquid-btn-secondary">
                    <i class="fas fa-print"></i>
                    <span>{{ App\Helpers\TranslationHelper::trans('quiz-results.print') }}</span>
                </button>
            </div>
        </div>

        <!-- Share Results Card (Collapsible) -->
        <div class="accordion-section">
            <div class="accordion-header" onclick="toggleAccordion('shareAccordion', this)">
                <h4>
                    <i class="fas fa-share-alt"></i>
                    Share Your Results
                </h4>
                <i class="fas fa-chevron-up"></i>
            </div>
            <div class="accordion-content" id="shareAccordion">
                <div class="liquid-share-card">
                    <div class="liquid-share-content">
                        <h3 class="liquid-share-title">{{ App\Helpers\TranslationHelper::trans('quiz-results.share_title') }}</h3>
                        <p class="liquid-share-text">{{ App\Helpers\TranslationHelper::trans('quiz-results.share_text', ['percentage' => $percentage, 'title' => $quiz->title]) }}</p>
                        <div class="liquid-share-buttons">
                            <a href="https://twitter.com/intent/tweet?text={{ urlencode(App\Helpers\TranslationHelper::trans('quiz-results.share_text', ['percentage' => $percentage, 'title' => $quiz->title])) }}&url={{ url()->current() }}"
                                target="_blank"
                                class="liquid-share-btn"
                                title="{{ App\Helpers\TranslationHelper::trans('quiz-results.share_twitter') }}">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}"
                                target="_blank"
                                class="liquid-share-btn"
                                title="{{ App\Helpers\TranslationHelper::trans('quiz-results.share_facebook') }}">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ url()->current() }}&title={{ $quiz->title }} {{ App\Helpers\TranslationHelper::trans('quiz-results.results') }}&summary={{ App\Helpers\TranslationHelper::trans('quiz-results.share_text', ['percentage' => $percentage, 'title' => $quiz->title]) }}"
                                target="_blank"
                                class="liquid-share-btn"
                                title="{{ App\Helpers\TranslationHelper::trans('quiz-results.share_linkedin') }}">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="mailto:?subject={{ urlencode($quiz->title . ' ' . App\Helpers\TranslationHelper::trans('quiz-results.results')) }}&body={{ urlencode(App\Helpers\TranslationHelper::trans('quiz-results.share_text', ['percentage' => $percentage, 'title' => $quiz->title]) . '\n\n' . url()->current()) }}"
                                class="liquid-share-btn"
                                title="{{ App\Helpers\TranslationHelper::trans('quiz-results.share_email') }}">
                                <i class="fas fa-envelope"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initially collapse all accordion sections
        toggleAccordion('statsAccordion', document.querySelector('#statsAccordion').previousElementSibling);
        
        // Correct answers section is initially hidden
        const correctAnswersSection = document.getElementById('correctAnswersSection');
        if (correctAnswersSection) {
            correctAnswersSection.classList.remove('visible');
        }

        // Animate stats cards on scroll
        const statItems = document.querySelectorAll('.liquid-stat-item');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        statItems.forEach((item, index) => {
            item.style.opacity = '0';
            item.style.transform = 'translateY(20px)';
            item.style.transition = 'all 0.5s ease';
            item.style.transitionDelay = (index * 0.1) + 's';
            observer.observe(item);
        });

        // Confetti effect for passed quizzes
        @if($passed)
        const celebrationMessage = '{{ App\Helpers\TranslationHelper::trans('quiz-results.celebration') }}';
        console.log(celebrationMessage);
        
        function createConfetti() {
            for (let i = 0; i < 50; i++) {
                setTimeout(() => {
                    const confetti = document.createElement('div');
                    confetti.style.position = 'fixed';
                    confetti.style.left = Math.random() * 100 + '%';
                    confetti.style.top = '-10px';
                    confetti.style.width = '8px';
                    confetti.style.height = '8px';
                    confetti.style.backgroundColor = `hsl(${Math.random() * 360}, 70%, 50%)`;
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
        const questionItems = document.querySelectorAll('.liquid-question-item');
        questionItems.forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.backgroundColor = 'var(--pure-white)';
            });
            item.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '';
            });
        });

        // Print functionality
        window.printResults = function() {
            window.print();
        };

        // Option item hover effects
        document.querySelectorAll('.liquid-option-item').forEach(option => {
            option.addEventListener('mouseenter', function() {
                this.style.backgroundColor = 'var(--ivory)';
            });
            option.addEventListener('mouseleave', function() {
                this.style.backgroundColor = 'var(--pure-white)';
            });
        });
    });

    // Accordion Functions
    window.toggleAccordion = function(contentId, header) {
        const content = document.getElementById(contentId);
        const icon = header.querySelector('i');
        
        if (content.classList.contains('collapsed')) {
            content.classList.remove('collapsed');
            header.classList.remove('collapsed');
            if (icon) {
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
            }
        } else {
            content.classList.add('collapsed');
            header.classList.add('collapsed');
            if (icon) {
                icon.classList.remove('fa-chevron-up');
                icon.classList.add('fa-chevron-down');
            }
        }
    };

    // Correct Answers Functions
    window.toggleCorrectAnswers = function() {
        const section = document.getElementById('correctAnswersSection');
        const content = document.getElementById('answersContent');
        const chevron = document.getElementById('answersChevron');
        const btn = document.getElementById('viewAnswersBtn');
        
        if (section) {
            if (section.classList.contains('visible')) {
                section.classList.remove('visible');
                if (btn) {
                    btn.innerHTML = '<i class="fas fa-eye"></i><span>View Correct Answers</span>';
                }
                if (content) {
                    content.classList.add('collapsed');
                }
                if (chevron) {
                    chevron.classList.remove('fa-chevron-up');
                    chevron.classList.add('fa-chevron-down');
                }
            } else {
                section.classList.add('visible');
                if (btn) {
                    btn.innerHTML = '<i class="fas fa-eye-slash"></i><span>Hide Correct Answers</span>';
                }
                if (content) {
                    content.classList.remove('collapsed');
                }
                if (chevron) {
                    chevron.classList.remove('fa-chevron-down');
                    chevron.classList.add('fa-chevron-up');
                }
            }
        }
    };

    // Restart Modal Functions
    window.showRestartModal = function() {
        document.getElementById('restartModal').classList.add('active');
    };

    window.closeRestartModal = function() {
        document.getElementById('restartModal').classList.remove('active');
    };
</script>
@endpush