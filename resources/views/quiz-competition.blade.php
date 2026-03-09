@extends('layouts.main')

@section('title', __('quiz-competition.title'))

@section('meta_description', __('quiz-competition.meta_description'))

@push('styles')
<style>
    /* Quiz Competition Specific Styles */
    :root {
        --quiz-primary: var(--prussian-blue);
        --quiz-accent: var(--bright-amber);
        --quiz-secondary: var(--sky-blue);
        --quiz-success: #10b981;
        --quiz-warning: #f59e0b;
        --quiz-danger: #ef4444;
        --quiz-dark: var(--prussian-blue);
        --quiz-light: var(--ivory);
    }

    /* Hero Section */
    .quiz-hero {
        background: linear-gradient(135deg, var(--prussian-blue) 0%, var(--regal-navy) 70%, var(--dark-slate) 100%);
        position: relative;
        color: var(--pure-white);
        padding: 80px 0;
        overflow: hidden;
    }

    @media (max-width: 768px) {
        .quiz-hero {
            padding: 60px 0;
        }
    }

    .quiz-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" opacity="0.1"><path d="M20 20 L30 20 L25 30 Z" fill="%23FBC60C"/><circle cx="70" cy="70" r="5" fill="%235AD1E4"/><circle cx="80" cy="30" r="8" fill="%23FBC60C"/><rect x="40" y="60" width="10" height="10" fill="%235AD1E4"/></svg>');
        background-size: 100px 100px;
        z-index: 1;
    }

    .quiz-hero-content {
        position: relative;
        z-index: 2;
        max-width: 800px;
        margin: 0 auto;
        text-align: center;
    }

    .quiz-hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        padding: 8px 20px;
        border-radius: 50px;
        margin-bottom: 30px;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .quiz-hero-badge i {
        color: var(--bright-amber);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }

    .quiz-hero-title {
        font-size: clamp(2rem, 6vw, 3.5rem);
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 20px;
    }

    .quiz-hero-title span {
        color: var(--bright-amber);
        position: relative;
        display: inline-block;
    }

    .quiz-hero-title span::after {
        content: '';
        position: absolute;
        bottom: 5px;
        left: 0;
        width: 100%;
        height: 8px;
        background: rgba(251, 198, 12, 0.3);
        z-index: -1;
    }

    .quiz-hero-text {
        font-size: 1.2rem;
        margin-bottom: 30px;
        opacity: 0.95;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    /* Prize Card */
    .prize-card {
        background: linear-gradient(135deg, var(--bright-amber) 0%, var(--light-gold) 100%);
        border-radius: 20px;
        padding: 30px;
        text-align: center;
        color: var(--prussian-blue);
        box-shadow: 0 20px 40px rgba(251, 198, 12, 0.3);
        margin: 40px 0;
        position: relative;
        overflow: hidden;
    }

    .prize-card::before {
        content: '$';
        position: absolute;
        top: -20px;
        right: -20px;
        font-size: 150px;
        font-weight: 800;
        opacity: 0.1;
        color: var(--prussian-blue);
        transform: rotate(15deg);
    }

    .prize-amount {
        font-size: 4rem;
        font-weight: 800;
        line-height: 1;
        margin-bottom: 10px;
    }

    .prize-label {
        font-size: 1.1rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        opacity: 0.8;
    }

    .prize-meta {
        display: flex;
        justify-content: center;
        gap: 30px;
        margin-top: 20px;
        flex-wrap: wrap;
    }

    .prize-meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .prize-meta-item i {
        font-size: 1.2rem;
    }

    /* Countdown Timer */
    .countdown-container {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 30px;
        margin: 30px 0;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .countdown-title {
        font-size: 1.1rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 20px;
        opacity: 0.9;
    }

    .countdown-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
        max-width: 500px;
        margin: 0 auto;
    }

    @media (max-width: 576px) {
        .countdown-grid {
            gap: 8px;
        }
    }

    .countdown-item {
        background: rgba(255, 255, 255, 0.15);
        border-radius: 15px;
        padding: 15px 5px;
        text-align: center;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .countdown-value {
        font-size: clamp(1.5rem, 4vw, 2.5rem);
        font-weight: 700;
        line-height: 1;
        margin-bottom: 5px;
        color: var(--bright-amber);
    }

    .countdown-label {
        font-size: 0.8rem;
        text-transform: uppercase;
        opacity: 0.8;
    }

    .countdown-note {
        margin-top: 15px;
        font-size: 0.9rem;
        opacity: 0.8;
    }

    /* Video Section */
    .video-section {
        padding: 60px 0;
        background: var(--ivory);
    }

    .video-container {
        position: relative;
        width: 100%;
        padding-bottom: 56.25%; /* 16:9 Aspect Ratio */
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(10, 29, 68, 0.2);
    }

    .video-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: none;
    }

    .video-placeholder {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, var(--prussian-blue) 0%, var(--regal-navy) 100%);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: var(--pure-white);
        cursor: pointer;
        transition: var(--transition);
    }

    .video-placeholder:hover {
        background: linear-gradient(135deg, var(--regal-navy) 0%, var(--prussian-blue) 100%);
    }

    .video-placeholder i {
        font-size: 5rem;
        color: var(--bright-amber);
        margin-bottom: 20px;
        animation: pulse 2s infinite;
    }

    .video-placeholder span {
        font-size: 1.2rem;
        font-weight: 600;
    }

    /* Process Cards */
    .quiz-process-section {
        padding: 80px 0;
        background: var(--pure-white);
    }

    .process-steps {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 30px;
        margin: 50px 0;
    }

    @media (max-width: 992px) {
        .process-steps {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 576px) {
        .process-steps {
            grid-template-columns: 1fr;
        }
    }

    .step-card {
        background: var(--ivory);
        border-radius: 20px;
        padding: 30px;
        text-align: center;
        position: relative;
        transition: var(--transition);
        border: 2px solid transparent;
    }

    .step-card:hover {
        transform: translateY(-10px);
        border-color: var(--bright-amber);
        box-shadow: 0 20px 40px rgba(251, 198, 12, 0.2);
    }

    .step-number {
        width: 50px;
        height: 50px;
        background: var(--bright-amber);
        color: var(--prussian-blue);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.5rem;
        margin: 0 auto 20px;
    }

    .step-icon {
        font-size: 2.5rem;
        color: var(--prussian-blue);
        margin-bottom: 20px;
    }

    .step-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--prussian-blue);
        margin-bottom: 15px;
    }

    .step-text {
        color: var(--text-muted);
        font-size: 0.95rem;
        line-height: 1.6;
    }

    /* Quizzes Grid */
    .quizzes-section {
        padding: 80px 0;
        background: var(--ivory);
    }

    .quizzes-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        margin: 50px 0;
    }

    @media (max-width: 992px) {
        .quizzes-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 576px) {
        .quizzes-grid {
            grid-template-columns: 1fr;
        }
    }

    .quiz-card {
        background: var(--pure-white);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(10, 29, 68, 0.1);
        transition: var(--transition);
        border: 2px solid transparent;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .quiz-card:hover {
        transform: translateY(-10px);
        border-color: var(--bright-amber);
        box-shadow: 0 20px 40px rgba(251, 198, 12, 0.2);
    }

    .quiz-card.locked {
        opacity: 0.8;
        filter: grayscale(0.5);
    }

    .quiz-card.locked:hover {
        transform: none;
        border-color: var(--gray);
    }

    .quiz-header {
        background: linear-gradient(135deg, var(--prussian-blue) 0%, var(--regal-navy) 100%);
        color: var(--pure-white);
        padding: 20px;
        position: relative;
    }

    .quiz-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: var(--bright-amber);
        color: var(--prussian-blue);
        padding: 5px 15px;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .quiz-icon {
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin-bottom: 15px;
        color: var(--bright-amber);
    }

    .quiz-title {
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .quiz-meta {
        display: flex;
        gap: 15px;
        font-size: 0.9rem;
        opacity: 0.9;
    }

    .quiz-meta i {
        color: var(--bright-amber);
        margin-right: 5px;
    }

    .quiz-body {
        padding: 20px;
        flex: 1;
    }

    .quiz-description {
        color: var(--text-muted);
        font-size: 0.95rem;
        margin-bottom: 20px;
        line-height: 1.6;
    }

    .quiz-stats {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--pale-slate);
    }

    .quiz-stat {
        text-align: center;
    }

    .quiz-stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--prussian-blue);
        line-height: 1;
        margin-bottom: 5px;
    }

    .quiz-stat-label {
        font-size: 0.8rem;
        color: var(--text-muted);
    }

    .quiz-footer {
        padding: 20px;
        background: var(--ivory);
        border-top: 1px solid var(--pale-slate);
    }

    .quiz-progress {
        margin-bottom: 15px;
    }

    .progress-info {
        display: flex;
        justify-content: space-between;
        font-size: 0.9rem;
        margin-bottom: 5px;
    }

    .progress-bar-bg {
        height: 8px;
        background: var(--pale-slate);
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-bar-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--bright-amber) 0%, var(--sky-blue) 100%);
        border-radius: 10px;
        width: 0%;
        transition: width 0.3s ease;
    }

    .quiz-btn {
        width: 100%;
        padding: 12px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: var(--transition);
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .quiz-btn-primary {
        background: var(--gradient-liquid-2);
        color: var(--prussian-blue);
    }

    .quiz-btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(251, 198, 12, 0.3);
    }

    .quiz-btn-secondary {
        background: var(--gradient-liquid-1);
        color: var(--pure-white);
    }

    .quiz-btn-secondary:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(10, 29, 68, 0.3);
    }

    .quiz-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
    }

    /* Ranking Table */
    .ranking-section {
        padding: 80px 0;
        background: var(--pure-white);
    }

    .ranking-container {
        background: var(--ivory);
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(10, 29, 68, 0.1);
    }

    .ranking-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 20px;
    }

    .ranking-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--prussian-blue);
    }

    .ranking-badge {
        background: var(--bright-amber);
        color: var(--prussian-blue);
        padding: 8px 20px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .ranking-table {
        width: 100%;
        border-collapse: collapse;
    }

    .ranking-table th {
        text-align: left;
        padding: 15px;
        background: var(--gradient-liquid-1);
        color: var(--pure-white);
        font-weight: 600;
    }

    .ranking-table th:first-child {
        border-radius: 10px 0 0 10px;
    }

    .ranking-table th:last-child {
        border-radius: 0 10px 10px 0;
    }

    .ranking-table td {
        padding: 15px;
        border-bottom: 1px solid var(--pale-slate);
    }

    .ranking-table tr:last-child td {
        border-bottom: none;
    }

    .ranking-table tr:hover td {
        background: rgba(251, 198, 12, 0.05);
    }

    .rank-1 td:first-child {
        color: var(--bright-amber);
        font-weight: 700;
    }

    .rank-1 .rank-position {
        background: var(--bright-amber);
        color: var(--prussian-blue);
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
    }

    .rank-position {
        width: 30px;
        height: 30px;
        background: var(--prussian-blue);
        color: var(--pure-white);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .rank-user {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .rank-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--gradient-liquid-1);
        color: var(--pure-white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
    }

    .rank-name {
        font-weight: 600;
        color: var(--prussian-blue);
    }

    .rank-score {
        font-weight: 700;
        color: var(--prussian-blue);
    }

    .rank-score.highlight {
        color: var(--bright-amber);
        font-size: 1.1rem;
    }

    .rank-badge {
        background: var(--bright-amber);
        color: var(--prussian-blue);
        padding: 3px 10px;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 600;
        margin-left: 10px;
    }

    /* Modal */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(10, 29, 68, 0.8);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(5px);
    }

    .modal.active {
        display: flex;
    }

    .modal-content {
        background: var(--pure-white);
        border-radius: 30px;
        padding: 40px;
        max-width: 500px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        position: relative;
        animation: modalSlideIn 0.3s ease;
    }

    @keyframes modalSlideIn {
        from {
            transform: translateY(-50px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .modal-close {
        position: absolute;
        top: 20px;
        right: 20px;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--ivory);
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition);
    }

    .modal-close:hover {
        background: var(--bright-amber);
        color: var(--prussian-blue);
        transform: rotate(90deg);
    }

    .modal-icon {
        width: 80px;
        height: 80px;
        background: var(--gradient-liquid-2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        color: var(--prussian-blue);
        margin: 0 auto 20px;
    }

    .modal-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--prussian-blue);
        text-align: center;
        margin-bottom: 10px;
    }

    .modal-subtitle {
        color: var(--text-muted);
        text-align: center;
        margin-bottom: 30px;
        font-size: 1rem;
    }

    .terms-box {
        background: var(--ivory);
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 20px;
        max-height: 250px;
        overflow-y: auto;
        border: 1px solid var(--pale-slate);
    }

    .terms-item {
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid var(--pale-slate);
    }

    .terms-item:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }

    .terms-item-title {
        font-weight: 700;
        color: var(--prussian-blue);
        margin-bottom: 5px;
        font-size: 0.95rem;
    }

    .terms-item-desc {
        font-size: 0.9rem;
        color: var(--text-muted);
        line-height: 1.5;
    }

    .checkbox-container {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 25px;
        cursor: pointer;
    }

    .checkbox-container input {
        width: 20px;
        height: 20px;
        cursor: pointer;
    }

    .checkbox-label {
        font-size: 0.95rem;
        color: var(--prussian-blue);
        line-height: 1.4;
    }

    .checkbox-label a {
        color: var(--bright-amber);
        font-weight: 600;
        text-decoration: underline;
    }

    .modal-btn {
        width: 100%;
        padding: 15px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: var(--transition);
        border: none;
        background: var(--gradient-liquid-2);
        color: var(--prussian-blue);
    }

    .modal-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(251, 198, 12, 0.3);
    }

    .modal-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
    }

    /* Notification */
    .quiz-notification {
        position: fixed;
        top: 100px;
        right: 20px;
        background: var(--pure-white);
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 20px 40px rgba(10, 29, 68, 0.2);
        max-width: 400px;
        width: calc(100% - 40px);
        z-index: 9998;
        display: none;
        animation: notificationSlide 0.3s ease;
        border-left: 5px solid var(--bright-amber);
    }

    .quiz-notification.show {
        display: block;
    }

    @keyframes notificationSlide {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    .notification-content {
        display: flex;
        align-items: flex-start;
        gap: 15px;
    }

    .notification-icon {
        width: 40px;
        height: 40px;
        background: var(--gradient-liquid-2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--prussian-blue);
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .notification-message {
        flex: 1;
        color: var(--prussian-blue);
        font-size: 0.95rem;
        line-height: 1.5;
    }

    .notification-close {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: var(--ivory);
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition);
        flex-shrink: 0;
    }

    .notification-close:hover {
        background: var(--bright-amber);
    }

    /* Sound Toggle */
    .sound-toggle {
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: var(--prussian-blue);
        color: var(--pure-white);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 9997;
        box-shadow: 0 10px 20px rgba(10, 29, 68, 0.3);
        transition: var(--transition);
        border: 2px solid var(--bright-amber);
    }

    .sound-toggle:hover {
        transform: scale(1.1);
    }

    .sound-toggle.muted {
        background: var(--gray);
        border-color: var(--text-muted);
    }

    /* Competition Closed Banner */
    .closed-banner {
        background: linear-gradient(135deg, var(--prussian-blue) 0%, var(--regal-navy) 100%);
        color: var(--pure-white);
        padding: 20px;
        border-radius: 15px;
        margin: 30px 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 20px;
        border: 2px solid var(--bright-amber);
    }

    .closed-banner-content {
        display: flex;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    .closed-banner i {
        font-size: 2.5rem;
        color: var(--bright-amber);
    }

    .closed-banner-text {
        font-size: 1.1rem;
        font-weight: 600;
    }

    .closed-banner-text small {
        display: block;
        font-size: 0.9rem;
        opacity: 0.8;
        margin-top: 5px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .prize-amount {
            font-size: 3rem;
        }
        
        .modal-content {
            padding: 30px 20px;
        }
        
        .modal-title {
            font-size: 1.5rem;
        }
        
        .ranking-container {
            padding: 20px;
        }
        
        .ranking-table {
            font-size: 0.9rem;
        }
        
        .ranking-table th,
        .ranking-table td {
            padding: 10px;
        }
        
        .rank-avatar {
            width: 30px;
            height: 30px;
            font-size: 0.8rem;
        }
        
        .rank-badge {
            display: none;
        }
    }

    @media (max-width: 576px) {
        .quiz-hero {
            padding: 40px 0;
        }
        
        .prize-meta {
            flex-direction: column;
            gap: 10px;
            align-items: center;
        }
        
        .countdown-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .ranking-table {
            font-size: 0.8rem;
        }
        
        .ranking-table th:nth-child(3),
        .ranking-table td:nth-child(3) {
            display: none;
        }
        
        .closed-banner-content {
            flex-direction: column;
            text-align: center;
        }
    }
</style>
@endpush

@section('content')
<!-- Quiz Competition Hero Section -->
<section class="quiz-hero">
    <div class="container">
        <div class="quiz-hero-content" data-aos="fade-up">
            <div class="quiz-hero-badge">
                <i class="fas fa-trophy"></i>
                <span>{{ __('quiz-competition.hero_badge') }}</span>
            </div>
            
            <h1 class="quiz-hero-title">
                {{ __('quiz-competition.hero_title_1') }} 
                <span>{{ __('quiz-competition.hero_title_highlight') }}</span>
            </h1>
            
            <p class="quiz-hero-text">
                {{ __('quiz-competition.hero_description') }}
            </p>

            <!-- Prize Card -->
            <div class="prize-card" data-aos="zoom-in">
                <div class="prize-amount">$50</div>
                <div class="prize-label">{{ __('quiz-competition.first_prize') }}</div>
                <div class="prize-meta">
                    <div class="prize-meta-item">
                        <i class="fas fa-users"></i>
                        <span>{{ __('quiz-competition.top_10') }}</span>
                    </div>
                    <div class="prize-meta-item">
                        <i class="fas fa-star"></i>
                        <span>{{ __('quiz-competition.perfect_score') }}</span>
                    </div>
                </div>
            </div>

            <!-- Countdown Timer -->
            <div class="countdown-container" id="countdownContainer" data-aos="fade-up">
                <div class="countdown-title">
                    <i class="fas fa-clock"></i>
                    {{ __('quiz-competition.competition_closes') }}
                </div>
                <div class="countdown-grid" id="countdown">
                    <div class="countdown-item">
                        <div class="countdown-value" id="days">00</div>
                        <div class="countdown-label">{{ __('quiz-competition.days') }}</div>
                    </div>
                    <div class="countdown-item">
                        <div class="countdown-value" id="hours">00</div>
                        <div class="countdown-label">{{ __('quiz-competition.hours') }}</div>
                    </div>
                    <div class="countdown-item">
                        <div class="countdown-value" id="minutes">00</div>
                        <div class="countdown-label">{{ __('quiz-competition.minutes') }}</div>
                    </div>
                    <div class="countdown-item">
                        <div class="countdown-value" id="seconds">00</div>
                        <div class="countdown-label">{{ __('quiz-competition.seconds') }}</div>
                    </div>
                </div>
                <div class="countdown-note">
                    {{ __('quiz-competition.closing_time') }} 
                    <strong id="closingDate">{{ __('common.march_15_2025') }}</strong>
                </div>
            </div>

            <!-- CTA Button -->
            <button class="btn btn-primary" id="participateBtn" data-aos="zoom-in">
                <i class="fas fa-play-circle"></i>
                {{ __('quiz-competition.participate_btn') }}
            </button>
        </div>
    </div>
</section>

<!-- Video Section -->
<section class="video-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-subtitle">{{ __('quiz-competition.video_subtitle') }}</span>
            <h2 class="section-title">{{ __('quiz-competition.video_title') }}</h2>
        </div>

        <div class="video-container" data-aos="zoom-in">
            <div class="video-placeholder" id="videoPlaceholder">
                <i class="fas fa-play-circle"></i>
                <span>{{ __('quiz-competition.watch_video') }}</span>
            </div>
            <iframe id="videoIframe" style="display: none;" src="" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section class="quiz-process-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-subtitle">{{ __('quiz-competition.process_subtitle') }}</span>
            <h2 class="section-title">{{ __('quiz-competition.process_title') }}</h2>
        </div>

        <div class="process-steps">
            <div class="step-card" data-aos="fade-up" data-aos-delay="100">
                <div class="step-number">1</div>
                <div class="step-icon">
                    <i class="fas fa-file-signature"></i>
                </div>
                <h3 class="step-title">{{ __('quiz-competition.step_1_title') }}</h3>
                <p class="step-text">{{ __('quiz-competition.step_1_desc') }}</p>
            </div>

            <div class="step-card" data-aos="fade-up" data-aos-delay="200">
                <div class="step-number">2</div>
                <div class="step-icon">
                    <i class="fas fa-question-circle"></i>
                </div>
                <h3 class="step-title">{{ __('quiz-competition.step_2_title') }}</h3>
                <p class="step-text">{{ __('quiz-competition.step_2_desc') }}</p>
            </div>

            <div class="step-card" data-aos="fade-up" data-aos-delay="300">
                <div class="step-number">3</div>
                <div class="step-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3 class="step-title">{{ __('quiz-competition.step_3_title') }}</h3>
                <p class="step-text">{{ __('quiz-competition.step_3_desc') }}</p>
            </div>

            <div class="step-card" data-aos="fade-up" data-aos-delay="400">
                <div class="step-number">4</div>
                <div class="step-icon">
                    <i class="fas fa-trophy"></i>
                </div>
                <h3 class="step-title">{{ __('quiz-competition.step_4_title') }}</h3>
                <p class="step-text">{{ __('quiz-competition.step_4_desc') }}</p>
            </div>
        </div>
    </div>
</section>

<!-- Available Quizzes Section -->
<section class="quizzes-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-subtitle">{{ __('quiz-competition.quizzes_subtitle') }}</span>
            <h2 class="section-title">{{ __('quiz-competition.quizzes_title') }}</h2>
        </div>

        <div class="quizzes-grid" id="quizzesGrid">
            <!-- Quiz cards will be populated by JavaScript -->
        </div>

        <!-- Competition Closed Banner (Hidden by default) -->
        <div class="closed-banner" id="closedBanner" style="display: none;">
            <div class="closed-banner-content">
                <i class="fas fa-trophy"></i>
                <div class="closed-banner-text">
                    {{ __('quiz-competition.competition_closed_message') }}
                    <small>{{ __('quiz-competition.competition_closed_submessage') }}</small>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Ranking Section -->
<section class="ranking-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-subtitle">{{ __('quiz-competition.ranking_subtitle') }}</span>
            <h2 class="section-title">{{ __('quiz-competition.ranking_title') }}</h2>
        </div>

        <div class="ranking-container" data-aos="fade-up">
            <div class="ranking-header">
                <div class="ranking-title">
                    <i class="fas fa-crown" style="color: var(--bright-amber);"></i>
                    {{ __('quiz-competition.ranking_current') }}
                </div>
                <div class="ranking-badge">
                    <i class="fas fa-users"></i>
                    <span id="participantsCount">0</span> {{ __('quiz-competition.participants') }}
                </div>
            </div>

            <div class="table-responsive">
                <table class="ranking-table" id="rankingTable">
                    <thead>
                        <tr>
                            <th>{{ __('quiz-competition.rank') }}</th>
                            <th>{{ __('quiz-competition.participant') }}</th>
                            <th>{{ __('quiz-competition.attempts') }}</th>
                            <th>{{ __('quiz-competition.score') }}</th>
                            <th>{{ __('quiz-competition.status') }}</th>
                        </tr>
                    </thead>
                    <tbody id="rankingBody">
                        <!-- Ranking rows will be populated by JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Terms & Conditions Modal -->
<div class="modal" id="termsModal">
    <div class="modal-content">
        <button class="modal-close" id="closeModal">
            <i class="fas fa-times"></i>
        </button>
        
        <div class="modal-icon">
            <i class="fas fa-file-contract"></i>
        </div>
        
        <h2 class="modal-title">{{ __('quiz-competition.modal_title') }}</h2>
        
        <p class="modal-subtitle">{{ __('quiz-competition.modal_subtitle') }}</p>
        
        <div class="terms-box">
            <div class="terms-item">
                <div class="terms-item-title">{{ __('quiz-competition.terms_1_title') }}</div>
                <div class="terms-item-desc">{{ __('quiz-competition.terms_1_desc') }}</div>
            </div>
            <div class="terms-item">
                <div class="terms-item-title">{{ __('quiz-competition.terms_2_title') }}</div>
                <div class="terms-item-desc">{{ __('quiz-competition.terms_2_desc') }}</div>
            </div>
            <div class="terms-item">
                <div class="terms-item-title">{{ __('quiz-competition.terms_3_title') }}</div>
                <div class="terms-item-desc">{{ __('quiz-competition.terms_3_desc') }}</div>
            </div>
            <div class="terms-item">
                <div class="terms-item-title">{{ __('quiz-competition.terms_4_title') }}</div>
                <div class="terms-item-desc">{{ __('quiz-competition.terms_4_desc') }}</div>
            </div>
            <div class="terms-item">
                <div class="terms-item-title">{{ __('quiz-competition.terms_5_title') }}</div>
                <div class="terms-item-desc">{{ __('quiz-competition.terms_5_desc') }}</div>
            </div>
        </div>
        
        <label class="checkbox-container">
            <input type="checkbox" id="acceptTerms">
            <span class="checkbox-label">
                {{ __('quiz-competition.accept_terms') }}
            </span>
        </label>
        
        <button class="modal-btn" id="acceptAndPlay" disabled>
            <i class="fas fa-check-circle"></i>
            {{ __('quiz-competition.accept_and_play') }}
        </button>
    </div>
</div>

<!-- Notification -->
<div class="quiz-notification" id="quizNotification">
    <div class="notification-content">
        <div class="notification-icon" id="notificationIcon">
            <i class="fas fa-bell"></i>
        </div>
        <div class="notification-message" id="notificationMessage">
            {{ __('common.notification_message') }}
        </div>
        <button class="notification-close" id="closeNotification">
            <i class="fas fa-times"></i>
        </button>
    </div>
</div>

<!-- Sound Toggle -->
<div class="sound-toggle" id="soundToggle">
    <i class="fas fa-volume-up" id="soundIcon"></i>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ===== COMPETITION DATA (Static - No Database) =====
        const competitionData = {
            closingDate: '2025-03-15T23:59:00Z', // ISO format
            isClosed: false,
            earlyClosed: false,
            perfectScoreCount: 0,
            perfectScoreThreshold: 10,
            participants: [
                { id: 1, name: 'Alex Johnson', avatar: 'AJ', score: 100, attempts: 3, status: 'finalist', rank: 1 },
                { id: 2, name: 'Maria Garcia', avatar: 'MG', score: 98, attempts: 2, status: 'qualified', rank: 2 },
                { id: 3, name: 'James Smith', avatar: 'JS', score: 95, attempts: 4, status: 'qualified', rank: 3 },
                { id: 4, name: 'Sarah Williams', avatar: 'SW', score: 92, attempts: 1, status: 'qualified', rank: 4 },
                { id: 5, name: 'Michael Brown', avatar: 'MB', score: 90, attempts: 5, status: 'qualified', rank: 5 },
                { id: 6, name: 'Emma Davis', avatar: 'ED', score: 88, attempts: 2, status: 'active', rank: 6 },
                { id: 7, name: 'David Miller', avatar: 'DM', score: 85, attempts: 3, status: 'active', rank: 7 },
                { id: 8, name: 'Lisa Wilson', avatar: 'LW', score: 82, attempts: 1, status: 'active', rank: 8 },
                { id: 9, name: 'Robert Taylor', avatar: 'RT', score: 80, attempts: 4, status: 'active', rank: 9 },
                { id: 10, name: 'Jennifer Lee', avatar: 'JL', score: 78, attempts: 2, status: 'active', rank: 10 },
                { id: 11, name: 'Thomas Anderson', avatar: 'TA', score: 75, attempts: 3, status: 'active', rank: 11 },
                { id: 12, name: 'Patricia White', avatar: 'PW', score: 72, attempts: 1, status: 'active', rank: 12 }
            ],
            quizzes: [
                { 
                    id: 1, 
                    title: 'General Knowledge', 
                    icon: 'fa-globe', 
                    questions: 20, 
                    time: 15, 
                    participants: 156, 
                    avgScore: 72, 
                    category: '{{ __('quiz-competition.category_trivia') }}', 
                    description: '{{ __('quiz-competition.quiz_desc_general') }}', 
                    locked: false 
                },
                { 
                    id: 2, 
                    title: 'Science & Technology', 
                    icon: 'fa-flask', 
                    questions: 25, 
                    time: 20, 
                    participants: 98, 
                    avgScore: 68, 
                    category: '{{ __('quiz-competition.category_science') }}', 
                    description: '{{ __('quiz-competition.quiz_desc_science') }}', 
                    locked: false 
                },
                { 
                    id: 3, 
                    title: 'History & Geography', 
                    icon: 'fa-landmark', 
                    questions: 20, 
                    time: 15, 
                    participants: 112, 
                    avgScore: 65, 
                    category: '{{ __('quiz-competition.category_history') }}', 
                    description: '{{ __('quiz-competition.quiz_desc_history') }}', 
                    locked: false 
                },
                { 
                    id: 4, 
                    title: 'Arts & Literature', 
                    icon: 'fa-palette', 
                    questions: 15, 
                    time: 12, 
                    participants: 67, 
                    avgScore: 70, 
                    category: '{{ __('quiz-competition.category_arts') }}', 
                    description: '{{ __('quiz-competition.quiz_desc_arts') }}', 
                    locked: true 
                },
                { 
                    id: 5, 
                    title: 'Sports & Entertainment', 
                    icon: 'fa-futbol', 
                    questions: 20, 
                    time: 15, 
                    participants: 89, 
                    avgScore: 74, 
                    category: '{{ __('quiz-competition.category_sports') }}', 
                    description: '{{ __('quiz-competition.quiz_desc_sports') }}', 
                    locked: true 
                },
                { 
                    id: 6, 
                    title: 'Business & Economics', 
                    icon: 'fa-chart-bar', 
                    questions: 20, 
                    time: 15, 
                    participants: 45, 
                    avgScore: 62, 
                    category: '{{ __('quiz-competition.category_business') }}', 
                    description: '{{ __('quiz-competition.quiz_desc_business') }}', 
                    locked: true 
                }
            ]
        };

        // Translation strings for JavaScript
        const translations = {
            loginRequired: '{{ __("quiz-competition.login_required") }}',
            quizStarted: '{{ __("quiz-competition.quiz_started") }}',
            quizCompleted: '{{ __("quiz-competition.quiz_completed") }}',
            perfectScore: '{{ __("quiz-competition.perfect_score_message") }}',
            termsAccepted: '{{ __("quiz-competition.terms_accepted") }}',
            earlyClose: '{{ __("quiz-competition.notification_early_close") }}',
            scheduledClose: '{{ __("quiz-competition.notification_scheduled_close") }}',
            competitionClosed: '{{ __("quiz-competition.competition_closed") }}',
            
            // Quiz card translations
            quizQuestions: '{{ __("quiz-competition.quiz_questions", ["count" => ":count"]) }}',
            quizTime: '{{ __("quiz-competition.quiz_time", ["count" => ":count"]) }}',
            quizPlayers: '{{ __("quiz-competition.quiz_players") }}',
            avgScore: '{{ __("quiz-competition.avg_score") }}',
            yourProgress: '{{ __("quiz-competition.your_progress") }}',
            locked: '{{ __("quiz-competition.locked") }}',
            playQuiz: '{{ __("quiz-competition.play_quiz") }}',
            
            // Ranking translations
            rank: '{{ __("quiz-competition.rank") }}',
            participant: '{{ __("quiz-competition.participant") }}',
            attempts: '{{ __("quiz-competition.attempts") }}',
            score: '{{ __("quiz-competition.score") }}',
            status: '{{ __("quiz-competition.status") }}',
            qualified: '{{ __("quiz-competition.qualified") }}',
            active: '{{ __("quiz-competition.active") }}',
            finalist: '{{ __("quiz-competition.finalist") }}',
            perfect: '{{ __("quiz-competition.perfect") }}'
        };

        // User session (simulated)
        @auth
        let userSession = {
            isLoggedIn: true,
            hasAcceptedTerms: false,
            userName: '{{ auth()->user()->name }}',
            userId: {{ auth()->id() }},
            userAvatar: '{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}',
            userScore: 0,
            userAttempts: 0,
            userRank: null,
            playedQuizzes: []
        };
        @else
        let userSession = {
            isLoggedIn: false,
            hasAcceptedTerms: false,
            userName: 'Guest',
            userId: 0,
            userAvatar: 'G',
            userScore: 0,
            userAttempts: 0,
            userRank: null,
            playedQuizzes: []
        };
        @endauth

        // Sound effects
        const sounds = {
            click: new Audio('data:audio/wav;base64,UklGRlwAAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YVoAAACAgICAf39/f39/f3+AgICAf39/f39/f3+AgICAf39/f39/f3+AgICAf39/f39/f3+AgICAf39/f39/f3+AgICAf39/f39/f3+AgICAf39/f39/f3+AgICA'),
            success: new Audio('data:audio/wav;base64,UklGRlwAAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YVoAAACAgICAf39/f39/f3+AgICAf39/f39/f3+AgICAf39/f39/f3+AgICAf39/f39/f3+AgICAf39/f39/f3+AgICAf39/f39/f3+AgICAf39/f39/f3+AgICA'),
            error: new Audio('data:audio/wav;base64,UklGRlwAAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YVoAAACAgICAf39/f39/f3+AgICAf39/f39/f3+AgICAf39/f39/f3+AgICAf39/f39/f3+AgICAf39/f39/f3+AgICAf39/f39/f3+AgICAf39/f39/f3+AgICA'),
            achievement: new Audio('data:audio/wav;base64,UklGRlwAAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YVoAAACAgICAf39/f39/f3+AgICAf39/f39/f3+AgICAf39/f39/f3+AgICAf39/f39/f3+AgICAf39/f39/f3+AgICAf39/f39/f3+AgICAf39/f39/f3+AgICA')
        };

        let soundEnabled = true;

        // ===== INITIALIZATION =====
        function init() {
            updateCountdown();
            setInterval(updateCountdown, 1000);
            renderQuizzes();
            renderRanking();
            updateParticipantsCount();
            checkCompetitionStatus();
            setupEventListeners();
            loadUserProgress();
        }

        // ===== COUNTDOWN TIMER =====
        function updateCountdown() {
            const closingDate = new Date(competitionData.closingDate).getTime();
            const now = new Date().getTime();
            const distance = closingDate - now;

            if (distance < 0 || competitionData.isClosed) {
                // Competition closed
                document.getElementById('days').textContent = '00';
                document.getElementById('hours').textContent = '00';
                document.getElementById('minutes').textContent = '00';
                document.getElementById('seconds').textContent = '00';
                
                if (!competitionData.isClosed) {
                    competitionData.isClosed = true;
                    handleCompetitionClose('scheduled');
                }
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById('days').textContent = days.toString().padStart(2, '0');
            document.getElementById('hours').textContent = hours.toString().padStart(2, '0');
            document.getElementById('minutes').textContent = minutes.toString().padStart(2, '0');
            document.getElementById('seconds').textContent = seconds.toString().padStart(2, '0');

            // Check for early closure (10 perfect scores)
            const perfectScores = competitionData.participants.filter(p => p.score === 100).length;
            if (perfectScores >= competitionData.perfectScoreThreshold && !competitionData.earlyClosed && !competitionData.isClosed) {
                competitionData.earlyClosed = true;
                competitionData.isClosed = true;
                handleCompetitionClose('early');
            }
        }

        // ===== COMPETITION CLOSE HANDLER =====
        function handleCompetitionClose(type) {
            // Lock all quizzes
            competitionData.quizzes.forEach(quiz => quiz.locked = true);
            renderQuizzes();
            
            // Show closed banner
            document.getElementById('closedBanner').style.display = 'block';
            
            // Disable participate button
            document.getElementById('participateBtn').disabled = true;
            
            // Send notification
            let message = '';
            if (type === 'early') {
                message = translations.earlyClose;
            } else {
                message = translations.scheduledClose;
            }
            
            showNotification(message, 'trophy');
            
            // Play sound
            playSound('achievement');
            
            // Update finalists status
            competitionData.participants.forEach((p, index) => {
                if (index < 10) {
                    p.status = 'finalist';
                }
            });
            renderRanking();
        }

        // ===== RENDER QUIZZES =====
        function renderQuizzes() {
            const grid = document.getElementById('quizzesGrid');
            grid.innerHTML = '';

            competitionData.quizzes.forEach(quiz => {
                const userProgress = userSession.playedQuizzes.find(q => q.id === quiz.id)?.score || 0;
                const progressPercentage = (userProgress / 100) * 100;

                const questionsText = translations.quizQuestions.replace(':count', quiz.questions);
                const timeText = translations.quizTime.replace(':count', quiz.time);

                const card = document.createElement('div');
                card.className = `quiz-card ${quiz.locked ? 'locked' : ''}`;
                card.dataset.quizId = quiz.id;

                card.innerHTML = `
                    <div class="quiz-header">
                        ${!quiz.locked ? '<div class="quiz-badge">' + quiz.category + '</div>' : ''}
                        <div class="quiz-icon">
                            <i class="fas ${quiz.icon}"></i>
                        </div>
                        <h3 class="quiz-title">${quiz.title}</h3>
                        <div class="quiz-meta">
                            <span><i class="fas fa-question-circle"></i> ${questionsText}</span>
                            <span><i class="fas fa-clock"></i> ${timeText}</span>
                        </div>
                    </div>
                    <div class="quiz-body">
                        <p class="quiz-description">${quiz.description}</p>
                        <div class="quiz-stats">
                            <div class="quiz-stat">
                                <div class="quiz-stat-value">${quiz.participants}</div>
                                <div class="quiz-stat-label">${translations.quizPlayers}</div>
                            </div>
                            <div class="quiz-stat">
                                <div class="quiz-stat-value">${quiz.avgScore}%</div>
                                <div class="quiz-stat-label">${translations.avgScore}</div>
                            </div>
                        </div>
                    </div>
                    <div class="quiz-footer">
                        <div class="quiz-progress">
                            <div class="progress-info">
                                <span>${translations.yourProgress}</span>
                                <span>${userProgress}%</span>
                            </div>
                            <div class="progress-bar-bg">
                                <div class="progress-bar-fill" style="width: ${progressPercentage}%"></div>
                            </div>
                        </div>
                        ${quiz.locked 
                            ? '<button class="quiz-btn quiz-btn-secondary" disabled><i class="fas fa-lock"></i> ' + translations.locked + '</button>'
                            : `<button class="quiz-btn quiz-btn-primary play-quiz-btn" data-quiz-id="${quiz.id}">
                                <i class="fas fa-play"></i> ${translations.playQuiz}
                               </button>`
                        }
                    </div>
                `;

                grid.appendChild(card);
            });

            // Add event listeners to play buttons
            document.querySelectorAll('.play-quiz-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const quizId = this.dataset.quizId;
                    handlePlayQuiz(quizId);
                });
            });
        }

        // ===== RENDER RANKING =====
        function renderRanking() {
            const tbody = document.getElementById('rankingBody');
            tbody.innerHTML = '';

            // Sort by score (descending) and then by attempts (ascending)
            const sortedParticipants = [...competitionData.participants].sort((a, b) => {
                if (b.score !== a.score) return b.score - a.score;
                return a.attempts - b.attempts;
            });

            sortedParticipants.forEach((participant, index) => {
                const row = document.createElement('tr');
                if (index === 0) row.classList.add('rank-1');
                
                let statusBadge = '';
                let statusText = '';
                
                if (participant.status === 'finalist') {
                    statusBadge = '<span class="rank-badge"><i class="fas fa-crown"></i> ' + translations.finalist + '</span>';
                    statusText = '<span style="color: var(--bright-amber); font-weight: 600;">' + translations.qualified + '</span>';
                } else if (participant.score === 100) {
                    statusBadge = '<span class="rank-badge"><i class="fas fa-star"></i> ' + translations.perfect + '</span>';
                    statusText = '<span style="color: var(--bright-amber); font-weight: 600;">' + translations.qualified + '</span>';
                } else if (index < 10) {
                    statusText = '<span style="color: var(--bright-amber); font-weight: 600;">' + translations.qualified + '</span>';
                } else {
                    statusText = '<span style="color: var(--text-muted);">' + translations.active + '</span>';
                }

                row.innerHTML = `
                    <td>
                        <div class="rank-position">${index + 1}</div>
                    </td>
                    <td>
                        <div class="rank-user">
                            <div class="rank-avatar">${participant.avatar}</div>
                            <span class="rank-name">${participant.name}</span>
                            ${index < 10 ? '<i class="fas fa-check-circle" style="color: var(--bright-amber); margin-left: 5px;"></i>' : ''}
                        </div>
                    </td>
                    <td>${participant.attempts}</td>
                    <td>
                        <span class="rank-score ${participant.score === 100 ? 'highlight' : ''}">
                            ${participant.score}/100
                        </span>
                        ${statusBadge}
                    </td>
                    <td>${statusText}</td>
                `;

                tbody.appendChild(row);
            });

            // Update user's rank if logged in
            if (userSession.isLoggedIn && userSession.userId > 0) {
                const userIndex = sortedParticipants.findIndex(p => p.id === userSession.userId);
                if (userIndex !== -1) {
                    userSession.userRank = userIndex + 1;
                }
            }
        }

        // ===== UPDATE PARTICIPANTS COUNT =====
        function updateParticipantsCount() {
            document.getElementById('participantsCount').textContent = competitionData.participants.length;
        }

        // ===== CHECK COMPETITION STATUS =====
        function checkCompetitionStatus() {
            // Check if user has already accepted terms (simulate from localStorage)
            const accepted = localStorage.getItem('quiz_terms_accepted');
            if (accepted === 'true') {
                userSession.hasAcceptedTerms = true;
            }
        }

        // ===== LOAD USER PROGRESS =====
        function loadUserProgress() {
            // Simulate loading user progress from localStorage
            const savedProgress = localStorage.getItem('user_quiz_progress');
            if (savedProgress) {
                try {
                    userSession.playedQuizzes = JSON.parse(savedProgress);
                } catch (e) {
                    console.error('Error loading progress');
                }
            }
        }

        // ===== SAVE USER PROGRESS =====
        function saveUserProgress() {
            localStorage.setItem('user_quiz_progress', JSON.stringify(userSession.playedQuizzes));
        }

        // ===== HANDLE PLAY QUIZ =====
        function handlePlayQuiz(quizId) {
            if (competitionData.isClosed) {
                showNotification(translations.competitionClosed, 'error');
                playSound('error');
                return;
            }

            if (!userSession.isLoggedIn) {
                showNotification(translations.loginRequired, 'error');
                playSound('error');
                
                // Redirect to login after 2 seconds
                setTimeout(() => {
                    window.location.href = '{{ route("login") }}';
                }, 2000);
                return;
            }

            if (!userSession.hasAcceptedTerms) {
                openTermsModal(quizId);
            } else {
                startQuiz(quizId);
            }
        }

        // ===== START QUIZ =====
        function startQuiz(quizId) {
            playSound('click');
            
            // Simulate starting quiz
            showNotification(translations.quizStarted, 'success');
            
            // In a real implementation, you would redirect to the quiz page
            // window.location.href = `/quiz/${quizId}/play`;
            
            // For demo, simulate completing quiz with random score
            setTimeout(() => {
                simulateQuizCompletion(quizId);
            }, 3000);
        }

        // ===== SIMULATE QUIZ COMPLETION (Demo Only) =====
        function simulateQuizCompletion(quizId) {
            const randomScore = Math.floor(Math.random() * 41) + 60; // 60-100
            
            // Update user's played quizzes
            const existingQuiz = userSession.playedQuizzes.find(q => q.id === parseInt(quizId));
            if (existingQuiz) {
                existingQuiz.score = randomScore;
                existingQuiz.attempts = (existingQuiz.attempts || 1) + 1;
            } else {
                userSession.playedQuizzes.push({
                    id: parseInt(quizId),
                    score: randomScore,
                    attempts: 1
                });
            }
            
            // Update user's overall score (average of all quizzes)
            const totalScore = userSession.playedQuizzes.reduce((sum, q) => sum + q.score, 0);
            userSession.userScore = Math.round(totalScore / userSession.playedQuizzes.length);
            userSession.userAttempts = userSession.playedQuizzes.reduce((sum, q) => sum + (q.attempts || 1), 0);
            
            // Update participant in ranking (if exists)
            const userParticipant = competitionData.participants.find(p => p.id === userSession.userId);
            if (userParticipant) {
                userParticipant.score = userSession.userScore;
                userParticipant.attempts = userSession.userAttempts;
            } else {
                // Add new participant
                competitionData.participants.push({
                    id: userSession.userId,
                    name: userSession.userName,
                    avatar: userSession.userAvatar,
                    score: userSession.userScore,
                    attempts: userSession.userAttempts,
                    status: 'active',
                    rank: competitionData.participants.length + 1
                });
            }
            
            // Re-render ranking
            renderRanking();
            updateParticipantsCount();
            
            // Save progress
            saveUserProgress();
            
            // Show result notification
            const message = translations.quizCompleted.replace(':score', randomScore);
            showNotification(message, 'success');
            playSound('achievement');
            
            // Check for perfect score
            if (randomScore === 100) {
                competitionData.perfectScoreCount++;
                showNotification(translations.perfectScore, 'success');
            }
            
            // Re-render quizzes to update progress
            renderQuizzes();
        }

        // ===== OPEN TERMS MODAL =====
        function openTermsModal(quizId) {
            const modal = document.getElementById('termsModal');
            modal.classList.add('active');
            modal.dataset.quizId = quizId;
            
            playSound('click');
        }

        // ===== CLOSE TERMS MODAL =====
        function closeTermsModal() {
            const modal = document.getElementById('termsModal');
            modal.classList.remove('active');
            document.getElementById('acceptTerms').checked = false;
            document.getElementById('acceptAndPlay').disabled = true;
        }

        // ===== SHOW NOTIFICATION =====
        function showNotification(message, type = 'info') {
            const notification = document.getElementById('quizNotification');
            const icon = document.getElementById('notificationIcon');
            const messageEl = document.getElementById('notificationMessage');
            
            // Set icon based on type
            icon.innerHTML = '';
            if (type === 'success') {
                icon.innerHTML = '<i class="fas fa-check-circle"></i>';
                icon.style.background = 'linear-gradient(135deg, #10b981 0%, #059669 100%)';
            } else if (type === 'error') {
                icon.innerHTML = '<i class="fas fa-exclamation-circle"></i>';
                icon.style.background = 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)';
            } else if (type === 'trophy') {
                icon.innerHTML = '<i class="fas fa-trophy"></i>';
                icon.style.background = 'var(--gradient-liquid-2)';
            } else {
                icon.innerHTML = '<i class="fas fa-info-circle"></i>';
                icon.style.background = 'linear-gradient(135deg, #3b82f6 0%, #2563eb 100%)';
            }
            
            messageEl.textContent = message;
            notification.classList.add('show');
            
            // Auto hide after 5 seconds
            setTimeout(() => {
                notification.classList.remove('show');
            }, 5000);
        }

        // ===== PLAY SOUND =====
        function playSound(soundName) {
            if (soundEnabled && sounds[soundName]) {
                sounds[soundName].play().catch(e => console.log('Sound play failed:', e));
            }
        }

        // ===== SETUP EVENT LISTENERS =====
        function setupEventListeners() {
            // Participate button
            document.getElementById('participateBtn').addEventListener('click', function() {
                if (!userSession.isLoggedIn) {
                    showNotification(translations.loginRequired, 'error');
                    playSound('error');
                    
                    setTimeout(() => {
                        window.location.href = '{{ route("login") }}';
                    }, 2000);
                    return;
                }
                
                openTermsModal(null);
            });

            // Modal close button
            document.getElementById('closeModal').addEventListener('click', closeTermsModal);
            
            // Close modal when clicking outside
            window.addEventListener('click', function(e) {
                const modal = document.getElementById('termsModal');
                if (e.target === modal) {
                    closeTermsModal();
                }
            });

            // Accept terms checkbox
            document.getElementById('acceptTerms').addEventListener('change', function() {
                document.getElementById('acceptAndPlay').disabled = !this.checked;
            });

            // Accept and play button
            document.getElementById('acceptAndPlay').addEventListener('click', function() {
                const modal = document.getElementById('termsModal');
                const quizId = modal.dataset.quizId;
                
                userSession.hasAcceptedTerms = true;
                localStorage.setItem('quiz_terms_accepted', 'true');
                
                closeTermsModal();
                playSound('success');
                
                showNotification(translations.termsAccepted, 'success');
                
                if (quizId) {
                    startQuiz(quizId);
                }
            });

            // Close notification
            document.getElementById('closeNotification').addEventListener('click', function() {
                document.getElementById('quizNotification').classList.remove('show');
            });

            // Sound toggle
            document.getElementById('soundToggle').addEventListener('click', function() {
                soundEnabled = !soundEnabled;
                const icon = document.getElementById('soundIcon');
                if (soundEnabled) {
                    icon.className = 'fas fa-volume-up';
                    this.classList.remove('muted');
                } else {
                    icon.className = 'fas fa-volume-mute';
                    this.classList.add('muted');
                }
            });

            // Video placeholder
            document.getElementById('videoPlaceholder').addEventListener('click', function() {
                const iframe = document.getElementById('videoIframe');
                const placeholder = document.getElementById('videoPlaceholder');
                
                // Replace with actual YouTube video ID
                iframe.src = 'https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1';
                iframe.style.display = 'block';
                placeholder.style.display = 'none';
                
                playSound('click');
            });
        }

        // Initialize
        init();
    });
</script>
@endpush