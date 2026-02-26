@extends('layouts.main')

@section('title', 'Taking Quiz: ' . $quiz->title . ' - EDUCONECX')

@section('meta_description', 'Take the quiz and test your knowledge.')

@section('content')
<style>
    /* Quiz Taking Page Specific Styles - Premium Enhanced Version */
    :root {
        --quiz-take-primary: #4361ee;
        --quiz-take-primary-dark: #3a0ca3;
        --quiz-take-primary-light: #4895ef;
        --quiz-take-secondary: #4cc9f0;
        --quiz-take-accent: #f72585;
        --quiz-take-success: #06d6a0;
        --quiz-take-success-dark: #05b586;
        --quiz-take-warning: #ffd166;
        --quiz-take-danger: #ef476f;
        --quiz-take-dark: #1e1e2f;
        --quiz-take-dark-light: #2d2d44;
        --quiz-take-gray: #6c757d;
        --quiz-take-gray-light: #e9ecef;
        --quiz-take-light: #f8f9fa;
        --quiz-take-white: #ffffff;
        --quiz-take-gradient: linear-gradient(145deg, #4361ee, #3a0ca3);
        --quiz-take-gradient-hover: linear-gradient(145deg, #3a0ca3, #4361ee);
        --quiz-take-gradient-accent: linear-gradient(145deg, #f72585, #b5179e);
        --quiz-take-gradient-success: linear-gradient(145deg, #06d6a0, #05b586);
        --quiz-take-shadow-sm: 0 5px 15px rgba(0, 0, 0, 0.05);
        --quiz-take-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        --quiz-take-shadow-lg: 0 20px 40px rgba(67, 97, 238, 0.12);
        --quiz-take-shadow-hover: 0 25px 50px rgba(67, 97, 238, 0.2);
        --quiz-take-radius: 16px;
        --quiz-take-radius-lg: 24px;
        --quiz-take-radius-sm: 12px;
        --quiz-take-radius-xs: 8px;
        --quiz-take-radius-full: 9999px;
        --quiz-take-transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Main Container with Animated Background */
    .quiz-take-container {
        background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
        min-height: 100vh;
        padding: 40px 0;
        position: relative;
        overflow: hidden;
    }

    .quiz-take-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle at 20% 50%, rgba(67, 97, 238, 0.03) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(247, 37, 133, 0.03) 0%, transparent 50%);
        pointer-events: none;
    }

    /* Quiz Header with Glassmorphism */
    .quiz-take-header {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: var(--quiz-take-radius-lg);
        padding: 30px 35px;
        box-shadow: var(--quiz-take-shadow);
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
    }

    .quiz-take-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--quiz-take-gradient);
    }

    .quiz-take-header h1 {
        font-size: 2rem !important;
        font-weight: 700 !important;
        background: var(--quiz-take-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 8px !important;
        letter-spacing: -0.02em;
    }

    /* Premium Timer */
    .quiz-take-timer {
        background: var(--quiz-take-gradient);
        color: var(--quiz-take-white);
        padding: 14px 28px;
        border-radius: var(--quiz-take-radius-full);
        display: inline-flex;
        align-items: center;
        gap: 12px;
        font-size: 1.6rem;
        font-weight: 700;
        box-shadow: var(--quiz-take-shadow-lg);
        position: relative;
        overflow: hidden;
    }

    .quiz-take-timer::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        animation: quiz-take-shimmer 3s infinite;
    }

    .quiz-take-timer.warning {
        background: linear-gradient(145deg, #ef476f, #d64161);
        animation: quiz-take-pulse 1.5s infinite;
    }

    .quiz-take-timer i {
        font-size: 1.4rem;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
    }

    /* Progress Bar with Premium Effects */
    .quiz-take-progress-bar {
        height: 12px;
        background: var(--quiz-take-gray-light);
        border-radius: var(--quiz-take-radius-full);
        overflow: hidden;
        position: relative;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .quiz-take-progress-fill {
        height: 100%;
        background: var(--quiz-take-gradient);
        border-radius: var(--quiz-take-radius-full);
        transition: width 0.5s cubic-bezier(0.4, 0, 0.2, 1);
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
        background: linear-gradient(90deg,
                transparent,
                rgba(255, 255, 255, 0.4),
                transparent);
        animation: quiz-take-shimmer 2s infinite;
    }

    /* Language Selector with Modern Design */
    .quiz-take-language-selector {
        background: var(--quiz-take-white);
        border-radius: var(--quiz-take-radius-full);
        padding: 6px;
        display: inline-flex;
        gap: 6px;
        box-shadow: var(--quiz-take-shadow);
        border: 1px solid rgba(67, 97, 238, 0.1);
    }

    .quiz-take-language-btn {
        padding: 10px 24px;
        border: none;
        border-radius: var(--quiz-take-radius-full);
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--quiz-take-transition);
        background: transparent;
        color: var(--quiz-take-gray);
        letter-spacing: 0.3px;
    }

    .quiz-take-language-btn:hover {
        background: var(--quiz-take-light);
        color: var(--quiz-take-primary);
        transform: translateY(-1px);
    }

    .quiz-take-language-btn.active {
        background: var(--quiz-take-gradient);
        color: var(--quiz-take-white);
        box-shadow: 0 4px 10px rgba(67, 97, 238, 0.3);
    }

    /* Question Card with Premium Design */
    .quiz-take-question-card {
        background: var(--quiz-take-white);
        border-radius: var(--quiz-take-radius-lg);
        padding: 40px;
        box-shadow: var(--quiz-take-shadow);
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        transition: var(--quiz-take-transition);
    }

    .quiz-take-question-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--quiz-take-shadow-lg);
    }

    .quiz-take-question-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle at 100% 0%, rgba(67, 97, 238, 0.02), transparent 50%);
        pointer-events: none;
    }

    .quiz-take-question-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid rgba(67, 97, 238, 0.1);
    }

    .quiz-take-question-badge {
        background: var(--quiz-take-gradient);
        color: var(--quiz-take-white);
        padding: 8px 20px;
        border-radius: var(--quiz-take-radius-full);
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        box-shadow: 0 4px 10px rgba(67, 97, 238, 0.2);
    }

    .quiz-take-question-points {
        background: linear-gradient(145deg, rgba(247, 37, 133, 0.1), rgba(76, 201, 240, 0.1));
        color: var(--quiz-take-accent);
        padding: 8px 18px;
        border-radius: var(--quiz-take-radius-full);
        font-size: 0.95rem;
        font-weight: 700;
        border: 1px solid rgba(247, 37, 133, 0.2);
        backdrop-filter: blur(5px);
    }

    .quiz-take-question-text {
        font-size: 1.6rem !important;
        font-weight: 600 !important;
        color: var(--quiz-take-dark) !important;
        margin-bottom: 30px !important;
        line-height: 1.5 !important;
        padding: 20px;
        background: rgba(248, 249, 250, 0.5);
        border-radius: var(--quiz-take-radius);
        border-left: 4px solid var(--quiz-take-primary);
    }

    /* Options with Modern Design */
    .quiz-take-option-item {
        margin-bottom: 16px;
        padding: 20px 25px;
        border: 2px solid var(--quiz-take-gray-light);
        border-radius: var(--quiz-take-radius);
        transition: var(--quiz-take-transition);
        cursor: pointer;
        background: var(--quiz-take-white);
        position: relative;
        overflow: hidden;
    }

    .quiz-take-option-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: var(--quiz-take-gradient);
        opacity: 0;
        transition: var(--quiz-take-transition);
    }

    .quiz-take-option-item:hover {
        border-color: var(--quiz-take-primary);
        background: linear-gradient(145deg, white, rgba(67, 97, 238, 0.02));
        transform: translateX(8px);
        box-shadow: var(--quiz-take-shadow-sm);
    }

    .quiz-take-option-item:hover::before {
        opacity: 1;
    }

    .quiz-take-option-item.selected {
        border-color: var(--quiz-take-primary);
        background: linear-gradient(145deg, rgba(67, 97, 238, 0.05), rgba(76, 201, 240, 0.05));
        box-shadow: 0 10px 25px rgba(67, 97, 238, 0.15);
    }

    .quiz-take-option-item.selected::before {
        opacity: 1;
    }

    .quiz-take-option-item .form-check-input {
        width: 24px;
        height: 24px;
        margin-right: 18px;
        cursor: pointer;
        border: 2px solid var(--quiz-take-gray);
        transition: var(--quiz-take-transition);
    }

    .quiz-take-option-item .form-check-input:checked {
        background-color: var(--quiz-take-primary);
        border-color: var(--quiz-take-primary);
        transform: scale(1.1);
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
    }

    .quiz-take-option-item .form-check-label {
        font-size: 1.1rem;
        color: var(--quiz-take-dark);
        font-weight: 500;
    }

    /* Option Image with Premium Style */
    .quiz-take-option-image {
        width: 60px;
        height: 60px;
        border-radius: var(--quiz-take-radius-sm);
        overflow: hidden;
        flex-shrink: 0;
        border: 2px solid transparent;
        transition: var(--quiz-take-transition);
        box-shadow: var(--quiz-take-shadow-sm);
    }

    .quiz-take-option-item:hover .quiz-take-option-image {
        border-color: var(--quiz-take-primary);
        transform: scale(1.05);
    }

    /* Fill in the Blank with Modern Design */
    .quiz-take-fill-blank .form-control {
        border: 2px solid var(--quiz-take-gray-light);
        border-radius: var(--quiz-take-radius);
        padding: 18px 25px;
        font-size: 1.1rem;
        transition: var(--quiz-take-transition);
        background: linear-gradient(145deg, white, var(--quiz-take-light));
    }

    .quiz-take-fill-blank .form-control:focus {
        border-color: var(--quiz-take-primary);
        box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.15);
        background: white;
        transform: translateY(-2px);
    }

    /* Matching Section with Premium Design */
    .quiz-take-matching-row {
        background: linear-gradient(145deg, var(--quiz-take-light), white);
        border-radius: var(--quiz-take-radius);
        padding: 25px;
        margin-bottom: 15px;
        transition: var(--quiz-take-transition);
        border: 1px solid transparent;
    }

    .quiz-take-matching-row:hover {
        transform: translateX(8px) translateY(-2px);
        box-shadow: var(--quiz-take-shadow);
        border-color: var(--quiz-take-primary-light);
        background: white;
    }

    .quiz-take-matching-left {
        font-weight: 600;
        color: var(--quiz-take-dark);
        padding: 12px;
        background: linear-gradient(145deg, white, var(--quiz-take-light));
        border-radius: var(--quiz-take-radius-sm);
        text-align: center;
        border: 2px dashed var(--quiz-take-primary-light);
        box-shadow: var(--quiz-take-shadow-sm);
    }

    .quiz-take-matching-select {
        width: 100%;
        padding: 12px 18px;
        border: 2px solid var(--quiz-take-gray-light);
        border-radius: var(--quiz-take-radius-sm);
        background: white;
        cursor: pointer;
        transition: var(--quiz-take-transition);
        font-weight: 500;
    }

    .quiz-take-matching-select:focus {
        border-color: var(--quiz-take-primary);
        box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.15);
        outline: none;
    }

    /* Image Grid with Premium Design */
    .quiz-take-image-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
        margin-top: 25px;
    }

    .quiz-take-image-option {
        border: 2px solid var(--quiz-take-gray-light);
        border-radius: var(--quiz-take-radius);
        overflow: hidden;
        cursor: pointer;
        transition: var(--quiz-take-transition);
        background: white;
        position: relative;
    }

    .quiz-take-image-option::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: var(--quiz-take-gradient);
        opacity: 0;
        transition: var(--quiz-take-transition);
        pointer-events: none;
        mix-blend-mode: overlay;
    }

    .quiz-take-image-option:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: var(--quiz-take-shadow-lg);
        border-color: var(--quiz-take-primary);
    }

    .quiz-take-image-option:hover::before {
        opacity: 0.1;
    }

    .quiz-take-image-option.selected {
        border-color: var(--quiz-take-primary);
        box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.3);
    }

    .quiz-take-image-option img {
        width: 100%;
        height: 160px;
        object-fit: cover;
        transition: var(--quiz-take-transition);
    }

    .quiz-take-image-option:hover img {
        transform: scale(1.1);
    }

    .quiz-take-image-option p {
        text-align: center;
        padding: 15px;
        margin: 0;
        background: linear-gradient(145deg, var(--quiz-take-light), white);
        font-weight: 600;
        color: var(--quiz-take-dark);
        border-top: 1px solid rgba(67, 97, 238, 0.1);
    }

    /* Buttons with Premium Design */
    .quiz-take-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        padding: 16px 35px;
        border-radius: var(--quiz-take-radius-full);
        font-size: 1.1rem;
        font-weight: 600;
        text-decoration: none;
        transition: var(--quiz-take-transition);
        border: none;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        letter-spacing: 0.5px;
    }

    .quiz-take-btn::before {
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

    .quiz-take-btn:hover::before {
        width: 300px;
        height: 300px;
    }

    .quiz-take-btn.primary {
        background: var(--quiz-take-gradient);
        color: var(--quiz-take-white);
        box-shadow: 0 8px 20px rgba(67, 97, 238, 0.3);
    }

    .quiz-take-btn.primary:hover {
        background: var(--quiz-take-gradient-hover);
        transform: translateX(5px) translateY(-2px);
        box-shadow: 0 15px 30px rgba(67, 97, 238, 0.4);
    }

    .quiz-take-btn.secondary {
        background: white;
        color: var(--quiz-take-gray);
        border: 2px solid var(--quiz-take-gray-light);
    }

    .quiz-take-btn.secondary:hover {
        background: var(--quiz-take-light);
        color: var(--quiz-take-dark);
        transform: translateX(-5px) translateY(-2px);
        border-color: var(--quiz-take-primary);
        box-shadow: var(--quiz-take-shadow);
    }

    .quiz-take-btn.success {
        background: var(--quiz-take-gradient-success);
        color: var(--quiz-take-white);
        box-shadow: 0 8px 20px rgba(6, 214, 160, 0.3);
    }

    .quiz-take-btn.success:hover {
        background: linear-gradient(145deg, #05b586, #06d6a0);
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(6, 214, 160, 0.4);
    }

    /* Navigator Card with Premium Design */
    .quiz-take-navigator-card,
    .quiz-take-info-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: var(--quiz-take-radius-lg);
        padding: 30px;
        box-shadow: var(--quiz-take-shadow);
        margin-bottom: 25px;
        position: relative;
        overflow: hidden;
    }

    .quiz-take-navigator-card::after,
    .quiz-take-info-card::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 150px;
        height: 150px;
        background: radial-gradient(circle, rgba(67, 97, 238, 0.1) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .quiz-take-navigator-title {
        font-size: 1.3rem !important;
        font-weight: 700 !important;
        color: var(--quiz-take-dark) !important;
        margin-bottom: 25px !important;
        display: flex;
        align-items: center;
        gap: 12px;
        border-bottom: 2px solid rgba(67, 97, 238, 0.1);
        padding-bottom: 15px;
    }

    .quiz-take-navigator-title i {
        color: var(--quiz-take-primary);
        font-size: 1.5rem;
    }

    /* Question Dots with Premium Design */
    .quiz-take-question-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 12px;
    }

    .quiz-take-question-dot {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(145deg, var(--quiz-take-light), white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        font-weight: 700;
        color: var(--quiz-take-gray);
        cursor: pointer;
        transition: var(--quiz-take-transition);
        border: 2px solid transparent;
        box-shadow: var(--quiz-take-shadow-sm);
        position: relative;
    }

    .quiz-take-question-dot:hover {
        transform: scale(1.15) translateY(-3px);
        border-color: var(--quiz-take-primary);
        box-shadow: 0 10px 20px rgba(67, 97, 238, 0.2);
        color: var(--quiz-take-primary);
    }

    .quiz-take-question-dot.answered {
        background: var(--quiz-take-gradient-success);
        color: var(--quiz-take-white);
        box-shadow: 0 8px 15px rgba(6, 214, 160, 0.3);
    }

    .quiz-take-question-dot.current {
        background: var(--quiz-take-gradient);
        color: var(--quiz-take-white);
        transform: scale(1.15);
        box-shadow: 0 10px 25px rgba(67, 97, 238, 0.4);
        border: 2px solid white;
    }

    .quiz-take-question-dot.current::after {
        content: '';
        position: absolute;
        top: -5px;
        left: -5px;
        right: -5px;
        bottom: -5px;
        border: 2px solid var(--quiz-take-primary);
        border-radius: 50%;
        animation: quiz-take-pulse 2s infinite;
    }

    /* Info List with Premium Design */
    .quiz-take-info-list li {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px 0;
        border-bottom: 1px solid rgba(67, 97, 238, 0.1);
        transition: var(--quiz-take-transition);
    }

    .quiz-take-info-list li:hover {
        transform: translateX(5px);
        background: rgba(67, 97, 238, 0.02);
        padding-left: 10px;
        border-radius: var(--quiz-take-radius-xs);
    }

    .quiz-take-info-list li i {
        width: 30px;
        color: var(--quiz-take-primary);
        font-size: 1.2rem;
        text-align: center;
    }

    .quiz-take-info-list li strong {
        color: var(--quiz-take-dark);
        font-weight: 700;
        font-size: 1.1rem;
    }

    /* Complete Card with Premium Design */
    .quiz-take-complete-card {
        background: linear-gradient(145deg, white, var(--quiz-take-light));
        border-radius: var(--quiz-take-radius-lg);
        padding: 70px 50px;
        box-shadow: var(--quiz-take-shadow-lg);
        text-align: center;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .quiz-take-complete-card::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(67, 97, 238, 0.05) 0%, transparent 70%);
        animation: rotate 20s linear infinite;
    }

    @keyframes rotate {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    .quiz-take-complete-icon {
        font-size: 6rem;
        background: var(--quiz-take-gradient-success);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 25px;
        animation: quiz-take-bounce 1s ease;
        position: relative;
        display: inline-block;
    }

    .quiz-take-complete-icon::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 100px;
        height: 100px;
        background: radial-gradient(circle, rgba(6, 214, 160, 0.2) 0%, transparent 70%);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        z-index: -1;
        animation: pulse 2s infinite;
    }

    /* Alert Styles */
    .quiz-take-error-alert,
    .quiz-take-success-alert {
        padding: 18px 25px;
        border-radius: var(--quiz-take-radius);
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 12px;
        border: none;
        backdrop-filter: blur(10px);
        animation: slideIn 0.5s ease;
    }

    @keyframes slideIn {
        from {
            transform: translateX(-100%);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    .quiz-take-error-alert {
        background: linear-gradient(145deg, rgba(239, 71, 111, 0.1), rgba(239, 71, 111, 0.05));
        color: var(--quiz-take-danger);
        border-left: 4px solid var(--quiz-take-danger);
    }

    .quiz-take-success-alert {
        background: linear-gradient(145deg, rgba(6, 214, 160, 0.1), rgba(6, 214, 160, 0.05));
        color: var(--quiz-take-success-dark);
        border-left: 4px solid var(--quiz-take-success);
    }

    /* Translation Loading with Premium Animation */
    .quiz-take-translation-loading {
        position: fixed;
        top: 20px;
        right: 20px;
        background: var(--quiz-take-gradient);
        color: white;
        padding: 15px 25px;
        border-radius: var(--quiz-take-radius-full);
        box-shadow: var(--quiz-take-shadow-lg);
        z-index: 1000;
        display: none;
        align-items: center;
        gap: 12px;
        font-weight: 600;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        animation: slideInRight 0.3s ease;
    }

    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    .quiz-take-translation-loading i {
        animation: spin 1s linear infinite;
        font-size: 1.2rem;
    }

    /* Responsive Improvements */
    @media (max-width: 992px) {
        .quiz-take-question-footer {
            flex-direction: column;
            gap: 20px;
        }

        .quiz-take-btn {
            width: 100%;
        }

        .quiz-take-image-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .quiz-take-question-text {
            font-size: 1.4rem !important;
        }
    }

    @media (max-width: 768px) {
        .quiz-take-header {
            padding: 20px;
        }

        .quiz-take-header h1 {
            font-size: 1.6rem !important;
        }

        .quiz-take-timer {
            font-size: 1.3rem;
            padding: 10px 20px;
        }

        .quiz-take-question-card {
            padding: 25px;
        }

        .quiz-take-question-text {
            font-size: 1.2rem !important;
            padding: 15px;
        }

        .quiz-take-question-grid {
            grid-template-columns: repeat(4, 1fr);
        }

        .quiz-take-option-item {
            padding: 15px 18px;
        }

        .quiz-take-option-item .form-check-label {
            font-size: 1rem;
        }

        .quiz-take-complete-card {
            padding: 40px 20px;
        }

        .quiz-take-complete-card h2 {
            font-size: 1.8rem !important;
        }
    }

    @media (max-width: 576px) {
        .quiz-take-image-grid {
            grid-template-columns: 1fr;
        }

        .quiz-take-question-grid {
            grid-template-columns: repeat(3, 1fr);
        }

        .quiz-take-language-selector {
            width: 100%;
            justify-content: center;
        }

        .quiz-take-language-btn {
            padding: 8px 16px;
            font-size: 0.85rem;
        }
    }

    /* Smooth Scrolling */
    html {
        scroll-behavior: smooth;
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 10px;
    }

    ::-webkit-scrollbar-track {
        background: var(--quiz-take-light);
    }

    ::-webkit-scrollbar-thumb {
        background: linear-gradient(145deg, var(--quiz-take-primary), var(--quiz-take-primary-dark));
        border-radius: var(--quiz-take-radius-full);
    }

    ::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(145deg, var(--quiz-take-primary-dark), var(--quiz-take-primary));
    }

    /* Focus Styles */
    *:focus-visible {
        outline: 2px solid var(--quiz-take-primary);
        outline-offset: 2px;
        border-radius: var(--quiz-take-radius-xs);
    }

    /* Loading States */
    .quiz-take-btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        pointer-events: none;
    }

    .quiz-take-btn i.fa-spinner {
        animation: spin 1s linear infinite;
    }

    /* Additional Animations */
    @keyframes float {

        0%,
        100% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-10px);
        }
    }

    .quiz-take-timer {
        animation: float 3s ease-in-out infinite;
    }

    .quiz-take-question-dot.current {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            box-shadow: 0 0 0 0 rgba(67, 97, 238, 0.4);
        }

        50% {
            box-shadow: 0 0 0 10px rgba(67, 97, 238, 0);
        }
    }
</style>

<!-- Rest of your HTML remains exactly the same -->
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
    let translatableElements = [];

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize translatable elements
        initializeTranslatableElements();

        // Timer functionality
        @if($remainingTime)
        let remainingSeconds = {
            {
                $remainingTime
            }
        };
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
                const currentQuestionType = '{{ $currentQuestion->question_type ?? '
                ' }}';
                const isMultipleChoice = currentQuestionType === 'multiple_choice';
                const isSingleChoice = ['single_choice', 'true_false'].includes(currentQuestionType);

                if ((isSingleChoice || isMultipleChoice) && !hasSelectedAnswer()) {
                    e.preventDefault();
                    alert('Please select an answer before proceeding.');
                    return false;
                }

                if (action === 'complete' || (action === 'next' && {
                        {
                            $attempt - > answers - > count() + 1
                        }
                    } == {
                        {
                            $questions - > count()
                        }
                    })) {
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
        translatableElements = [];

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

        // Add option texts - these are the dynamic question options
        document.querySelectorAll('.option-text').forEach(el => {
            if (el.dataset.original) {
                console.log('Found option text:', el.dataset.original);
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

        console.log('Total translatable elements:', translatableElements.length);
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

            // Re-initialize translatable elements to catch any new dynamic content
            initializeTranslatableElements();

            console.log('Elements to translate:', translatableElements.length);

            // Translate all elements
            for (const item of translatableElements) {
                if (item.element) {
                    try {
                        console.log('Translating:', item.original);
                        const translated = await translateText(item.original, currentLanguage, lang);
                        console.log('Translated to:', translated);

                        // Update the text content - works for all text elements
                        if (item.element) {
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
            console.log('Fetching translation from API:', {
                text,
                sourceLang,
                targetLang
            });

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

        // Small delay to ensure DOM is updated
        setTimeout(() => {
            // Re-initialize translatable elements
            initializeTranslatableElements();

            // Translate to current language if not English
            if (currentLanguage !== 'en') {
                changeLanguage(currentLanguage);
            }
        }, 100);
    }

    // Call this after loading new question via AJAX
    window.updateQuestionTranslations = updateQuestionTranslations;

    // Intercept form submissions to update translations after navigation
    document.addEventListener('submit', function(e) {
        if (e.target.id === 'quizForm') {
            const action = e.submitter?.value;
            if (action === 'next' || action === 'previous') {
                // Let the form submit normally, but we'll update translations after the page reloads
                // The page will reload with the new question, and DOMContentLoaded will handle translations
            }
        }
    });
</script>

@endsection