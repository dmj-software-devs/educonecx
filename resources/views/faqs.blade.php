@extends('layouts.main')

@section('title', 'Frequently Asked Questions - EDUCONECX')

@section('meta_description', 'Find answers to frequently asked questions about EDUCONECX courses, payments, subscriptions, and digital services. Need more help? Contact our support team.')

@push('styles')
<style>
    /* Hero Section */
    .faq-hero {
        position: relative;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 100px 0;
        overflow: hidden;
        color: var(--white);
    }

    .faq-hero-particles {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    .faq-hero-particle {
        position: absolute;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .faq-hero-particle:nth-child(1) {
        width: 300px;
        height: 300px;
        top: -100px;
        right: -100px;
        animation: float 8s ease-in-out infinite;
    }

    .faq-hero-particle:nth-child(2) {
        width: 200px;
        height: 200px;
        bottom: -50px;
        left: -50px;
        animation: float 10s ease-in-out infinite reverse;
    }

    .faq-hero-particle:nth-child(3) {
        width: 150px;
        height: 150px;
        top: 30%;
        left: 20%;
        animation: float 12s ease-in-out infinite;
    }

    .faq-hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
        max-width: 800px;
        margin: 0 auto;
    }

    .faq-hero-badge {
        display: inline-block;
        padding: 8px 20px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: var(--border-radius-full);
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 25px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        animation: fadeInDown 1s ease-out;
    }

    .faq-hero-title {
        font-size: clamp(2.5rem, 8vw, 4rem);
        font-weight: 800;
        margin-bottom: 20px;
        line-height: 1.1;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        animation: fadeInUp 1s ease-out 0.2s both;
    }

    .faq-hero-text {
        font-size: clamp(1.1rem, 3vw, 1.3rem);
        opacity: 0.9;
        line-height: 1.8;
        max-width: 700px;
        margin: 0 auto;
        animation: fadeInUp 1s ease-out 0.4s both;
    }

    /* Search Section */
    .faq-search-section {
        margin-top: -50px;
        position: relative;
        z-index: 10;
        margin-bottom: 60px;
    }

    .faq-search-container {
        max-width: 600px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .faq-search-form {
        background: var(--white);
        border-radius: 60px;
        box-shadow: var(--shadow-lg);
        display: flex;
        align-items: center;
        padding: 5px;
    }

    .faq-search-input {
        flex: 1;
        border: none;
        padding: 15px 25px;
        font-size: 1rem;
        border-radius: 60px;
        outline: none;
        background: transparent;
    }

    .faq-search-input:focus {
        box-shadow: none;
    }

    .faq-search-button {
        background: var(--gradient-1);
        color: var(--white);
        border: none;
        padding: 12px 30px;
        border-radius: 50px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 10px;
        white-space: nowrap;
    }

    .faq-search-button:hover {
        transform: translateX(-5px);
        box-shadow: var(--shadow-md);
    }

    /* FAQ Section */
    .faq-section {
        padding: 60px 0;
        background: var(--light);
    }

    .faq-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* FAQ Grid */
    .faq-grid {
        display: flex;
        flex-direction: column;
        gap: 20px;
        margin-bottom: 40px;
    }

    .faq-column-title {
        font-size: 1.8rem;
        font-weight: 700;
        margin: 40px 0 20px;
        color: var(--dark);
        display: flex;
        align-items: center;
        gap: 15px;
        padding-bottom: 10px;
        border-bottom: 3px solid var(--primary);
    }

    .faq-column-title:first-of-type {
        margin-top: 0;
    }

    .faq-column-title i {
        color: var(--primary);
        font-size: 1.8rem;
    }

    /* FAQ Item */
    .faq-item {
        background: var(--white);
        border-radius: var(--border-radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        border: 1px solid var(--gray-light);
    }

    .faq-item:hover {
        box-shadow: var(--shadow-lg);
        border-color: transparent;
    }

    .faq-item.active {
        border-color: var(--primary);
        box-shadow: var(--shadow-md);
    }

    .faq-question {
        padding: 22px 30px;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 600;
        color: var(--dark);
        transition: var(--transition);
        font-size: 1.1rem;
        position: relative;
    }

    .faq-question::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 0;
        background: var(--gradient-1);
        border-radius: 0 var(--border-radius-full) var(--border-radius-full) 0;
        transition: var(--transition);
    }

    .faq-item.active .faq-question::before {
        height: 70%;
    }

    .faq-question:hover {
        background-color: var(--light);
    }

    .faq-question span {
        flex: 1;
        padding-right: 20px;
    }

    .faq-question i {
        color: var(--primary);
        transition: var(--transition);
        font-size: 1rem;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--light);
        border-radius: 50%;
    }

    .faq-item.active .faq-question i {
        transform: rotate(180deg);
        background: var(--primary);
        color: var(--white);
    }

    .faq-answer {
        padding: 0 30px 25px;
        color: var(--gray);
        line-height: 1.8;
        display: none;
        font-size: 1rem;
        border-top: 1px solid var(--gray-light);
        margin-top: 5px;
    }

    .faq-item.active .faq-answer {
        display: block;
        animation: fadeIn 0.5s ease-out;
    }

    .faq-answer a {
        color: var(--primary);
        text-decoration: none;
        font-weight: 500;
    }

    .faq-answer a:hover {
        text-decoration: underline;
    }

    .faq-answer p {
        margin-bottom: 15px;
    }

    .faq-answer p:last-child {
        margin-bottom: 0;
    }

    .faq-answer ul,
    .faq-answer ol {
        margin-bottom: 15px;
        padding-left: 20px;
    }

    .faq-answer li {
        margin-bottom: 8px;
    }

    .faq-answer strong {
        color: var(--dark);
    }

    /* No Results */
    .no-results {
        text-align: center;
        padding: 60px 20px;
        background: var(--white);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-sm);
        display: none;
    }

    .no-results.show {
        display: block;
    }

    .no-results-icon {
        width: 100px;
        height: 100px;
        background: var(--light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px;
        font-size: 2.5rem;
        color: var(--gray);
    }

    .no-results h3 {
        font-size: 1.8rem;
        margin-bottom: 10px;
        color: var(--dark);
    }

    .no-results p {
        color: var(--gray);
        margin-bottom: 25px;
        font-size: 1.1rem;
    }

    .reset-search {
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
        border: none;
        cursor: pointer;
    }

    .reset-search:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-lg);
    }

    /* Quick Help */
    .quick-help {
        background: var(--white);
        border-radius: var(--border-radius-lg);
        padding: 30px;
        margin-top: 40px;
        box-shadow: var(--shadow-md);
    }

    .quick-help-title {
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 20px;
        color: var(--dark);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .quick-help-title i {
        color: var(--primary);
    }

    .quick-help-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .quick-help-item {
        padding: 15px;
        background: var(--light);
        border-radius: var(--border-radius-md);
        text-align: center;
        transition: var(--transition);
        cursor: pointer;
    }

    .quick-help-item:hover {
        background: var(--primary);
        color: var(--white);
        transform: translateY(-5px);
    }

    .quick-help-item i {
        font-size: 1.5rem;
        margin-bottom: 8px;
        color: var(--primary);
        transition: var(--transition);
    }

    .quick-help-item:hover i {
        color: var(--white);
    }

    .quick-help-item span {
        display: block;
        font-size: 0.95rem;
        font-weight: 500;
    }

    /* Contact Support Section */
    .support-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 80px 0;
        text-align: center;
        position: relative;
        overflow: hidden;
        color: var(--white);
        margin-top: 40px;
    }

    .support-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 10s ease-in-out infinite;
    }

    .support-section::after {
        content: '';
        position: absolute;
        bottom: -50%;
        left: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 8s ease-in-out infinite reverse;
    }

    .support-content {
        position: relative;
        z-index: 2;
        max-width: 700px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .support-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 20px;
    }

    .support-text {
        font-size: 1.2rem;
        opacity: 0.9;
        margin-bottom: 30px;
        line-height: 1.8;
    }

    .support-btn {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        padding: 18px 45px;
        background: var(--white);
        color: var(--primary);
        border-radius: var(--border-radius-full);
        text-decoration: none;
        font-weight: 600;
        font-size: 1.1rem;
        transition: var(--transition);
        box-shadow: var(--shadow-lg);
    }

    .support-btn:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-hover);
        background: transparent;
        color: var(--white);
        border: 2px solid var(--white);
        padding: 16px 43px;
    }

    .support-btn i {
        font-size: 1.2rem;
    }

    /* Animations */
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .faq-hero {
            padding: 60px 0;
        }

        .faq-search-form {
            flex-direction: column;
            border-radius: 30px;
        }

        .faq-search-input {
            width: 100%;
            padding: 15px 20px;
        }

        .faq-search-button {
            width: 100%;
            border-radius: 30px;
            justify-content: center;
        }

        .faq-question {
            padding: 18px 20px;
            font-size: 1rem;
        }

        .faq-answer {
            padding: 0 20px 20px;
            font-size: 0.95rem;
        }

        .support-title {
            font-size: 2rem;
        }

        .support-text {
            font-size: 1.1rem;
        }

        .support-btn {
            padding: 15px 35px;
            font-size: 1rem;
        }

        .quick-help-grid {
            grid-template-columns: 1fr;
        }

        .faq-column-title {
            font-size: 1.5rem;
            margin: 30px 0 15px;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="faq-hero">
    <div class="faq-hero-particles">
        <div class="faq-hero-particle"></div>
        <div class="faq-hero-particle"></div>
        <div class="faq-hero-particle"></div>
    </div>

    <div class="container">
        <div class="faq-hero-content">
            <span class="faq-hero-badge">Got Questions?</span>
            <h1 class="faq-hero-title">Frequently Asked Questions</h1>
            <p class="faq-hero-text">
                Find clear answers about courses, payments, subscriptions, and digital services
            </p>
        </div>
    </div>
</section>

<!-- Search Section -->
<div class="faq-search-section">
    <div class="faq-search-container">
        <form class="faq-search-form" id="faqSearchForm">
            <input
                type="text"
                class="faq-search-input"
                placeholder="Search FAQs..."
                id="faqSearchInput"
                autocomplete="off">
            <button type="submit" class="faq-search-button">
                <i class="fas fa-search"></i>
                <span>Search</span>
            </button>
        </form>
    </div>
</div>

<!-- FAQ Section -->
<section class="faq-section">
    <div class="faq-container">
        <!-- Left Column FAQs -->
        <h2 class="faq-column-title">
            <i class="fas fa-question-circle"></i>
            General Questions
        </h2>
        <div class="faq-grid" id="leftColumnFaqs">
            @foreach($faqColumns['left'] as $index => $faq)
            <div class="faq-item {{ isset($faq['open']) && $faq['open'] ? 'active' : '' }}" data-index="left-{{ $index }}">
                <div class="faq-question">
                    <span>{{ $faq['question'] }}</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    {!! $faq['answer'] !!}
                </div>
            </div>
            @endforeach
        </div>

        <!-- Right Column FAQs -->
        <h2 class="faq-column-title">
            <i class="fas fa-info-circle"></i>
            More Information
        </h2>
        <div class="faq-grid" id="rightColumnFaqs">
            @foreach($faqColumns['right'] as $index => $faq)
            <div class="faq-item" data-index="right-{{ $index }}">
                <div class="faq-question">
                    <span>{{ $faq['question'] }}</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    {!! $faq['answer'] !!}
                </div>
            </div>
            @endforeach
        </div>

        <!-- No Results -->
        <div class="no-results" id="noResults">
            <div class="no-results-icon">
                <i class="fas fa-search"></i>
            </div>
            <h3>No Results Found</h3>
            <p>We couldn't find any FAQs matching your search. Try different keywords.</p>
            <button class="reset-search" id="resetSearch">
                <i class="fas fa-redo-alt"></i> Clear Search
            </button>
        </div>

        <!-- Quick Help -->
        <div class="quick-help" data-aos="fade-up">
            <h3 class="quick-help-title">
                <i class="fas fa-bolt"></i>
                Quick Help Topics
            </h3>
            <div class="quick-help-grid">
                <div class="quick-help-item" data-search="what is educonecx">
                    <i class="fas fa-info-circle"></i>
                    <span>What is EDUCONECX?</span>
                </div>
                <div class="quick-help-item" data-search="get started">
                    <i class="fas fa-rocket"></i>
                    <span>Getting Started</span>
                </div>
                <div class="quick-help-item" data-search="payment methods">
                    <i class="fas fa-credit-card"></i>
                    <span>Payments</span>
                </div>
                <div class="quick-help-item" data-search="contact support">
                    <i class="fas fa-headset"></i>
                    <span>Contact Support</span>
                </div>
                <div class="quick-help-item" data-search="refund policy">
                    <i class="fas fa-undo-alt"></i>
                    <span>Refund Policy</span>
                </div>
                <div class="quick-help-item" data-search="certificates">
                    <i class="fas fa-certificate"></i>
                    <span>Certificates</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Support Section -->
<section class="support-section">
    <div class="container">
        <div class="support-content">
            <h2 class="support-title">Still have questions?</h2>
            <p class="support-text">
                Can't find the answer you're looking for? Our support team is here to help you with any questions about courses, payments, or technical issues.
            </p>
            <a href="{{ route('contact') }}" class="support-btn">
                <i class="fas fa-headset"></i> Contact Support
            </a>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // FAQ Accordion
        const faqItems = document.querySelectorAll('.faq-item');

        faqItems.forEach(item => {
            const question = item.querySelector('.faq-question');

            question.addEventListener('click', () => {
                // Toggle current item
                item.classList.toggle('active');
            });
        });

        // Search Functionality
        const searchInput = document.getElementById('faqSearchInput');
        const searchForm = document.getElementById('faqSearchForm');
        const noResults = document.getElementById('noResults');
        const resetSearch = document.getElementById('resetSearch');
        const leftColumnFaqs = document.getElementById('leftColumnFaqs');
        const rightColumnFaqs = document.getElementById('rightColumnFaqs');

        // Combine all FAQ items for searching
        const allFaqItems = document.querySelectorAll('.faq-item');

        function performSearch() {
            const searchTerm = searchInput.value.toLowerCase().trim();

            if (searchTerm === '') {
                // Show all items
                allFaqItems.forEach(item => {
                    item.style.display = 'block';
                });
                noResults.classList.remove('show');
                return;
            }

            let visibleCount = 0;

            allFaqItems.forEach(item => {
                const question = item.querySelector('.faq-question span').textContent.toLowerCase();
                const answer = item.querySelector('.faq-answer').textContent.toLowerCase();

                if (question.includes(searchTerm) || answer.includes(searchTerm)) {
                    item.style.display = 'block';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            // Show/hide no results message
            if (visibleCount === 0) {
                noResults.classList.add('show');
            } else {
                noResults.classList.remove('show');
            }
        }

        // Debounce function
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        const debouncedSearch = debounce(performSearch, 300);

        searchForm.addEventListener('submit', (e) => {
            e.preventDefault();
            performSearch();
        });

        searchInput.addEventListener('input', debouncedSearch);

        resetSearch.addEventListener('click', () => {
            searchInput.value = '';
            performSearch();
        });

        // Quick help items
        const quickHelpItems = document.querySelectorAll('.quick-help-item');
        quickHelpItems.forEach(item => {
            item.addEventListener('click', () => {
                const searchText = item.dataset.search;
                searchInput.value = searchText;
                performSearch();

                // Scroll to search
                searchInput.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
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

        // Apply initial styles and observe FAQ items
        allFaqItems.forEach(item => {
            item.style.opacity = '0';
            item.style.transform = 'translateY(20px)';
            item.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            observer.observe(item);
        });
    });
</script>
@endpush