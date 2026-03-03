@extends('layouts.main')

@section('title', 'Blog - EDUCONECX | Insights & Updates')

@section('meta_description', 'Explore the latest articles, insights, and updates from EDUCONECX. Stay informed about learning, technology, and digital innovation.')

@push('styles')
<style>
    /* Root Variables - Your Beautiful Colors */
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
        
        /* Text Colors - Fixed for readability */
        --text-primary: #0A1D44;
        --text-secondary: #2E5C61;
        --text-muted: #5f5f5f;
        --text-light: #FEFDFE;
        
        /* Gradients with your colors */
        --gradient-1: linear-gradient(135deg, #0A1D44 0%, #18386E 50%, #2E5C61 100%);
        --gradient-2: linear-gradient(45deg, #FBC60C 0%, #EBD789 50%, #F9F7E9 100%);
        --gradient-3: linear-gradient(135deg, #5AD1E4 0%, #CBD1DA 50%, #FEFDFE 100%);
        
        /* Shadows */
        --shadow-sm: 0 2px 8px rgba(10, 29, 68, 0.08);
        --shadow-md: 0 4px 12px rgba(10, 29, 68, 0.12);
        --shadow-lg: 0 8px 24px rgba(10, 29, 68, 0.15);
        --shadow-hover: 0 12px 28px rgba(251, 198, 12, 0.2);
        
        /* Border Radius */
        --radius-sm: 8px;
        --radius-md: 12px;
        --radius-lg: 16px;
        --radius-xl: 24px;
        --radius-full: 9999px;
        
        /* Transitions */
        --transition: all 0.3s ease;
        --transition-slow: all 0.5s ease;
    }

    /* Hero Section - Fixed for better visibility */
    .blog-hero {
        position: relative;
        background: var(--gradient-1);
        padding: 100px 0;
        overflow: hidden;
        color: var(--pure-white);
    }

    .blog-hero-particles {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    .blog-hero-particle {
        position: absolute;
        background: rgba(251, 198, 12, 0.1);
        border-radius: 50%;
    }

    .blog-hero-particle:nth-child(1) {
        width: 300px;
        height: 300px;
        top: -100px;
        right: -100px;
        animation: float 8s ease-in-out infinite;
    }

    .blog-hero-particle:nth-child(2) {
        width: 200px;
        height: 200px;
        bottom: -50px;
        left: -50px;
        background: rgba(90, 209, 228, 0.1);
        animation: float 10s ease-in-out infinite reverse;
    }

    .blog-hero-particle:nth-child(3) {
        width: 150px;
        height: 150px;
        top: 30%;
        left: 20%;
        background: rgba(235, 215, 137, 0.1);
        animation: float 12s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }

    .blog-hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
        max-width: 800px;
        margin: 0 auto;
    }

    .blog-hero-badge {
        display: inline-block;
        padding: 8px 20px;
        background: rgba(254, 253, 254, 0.2);
        border-radius: var(--radius-full);
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 25px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(251, 198, 12, 0.3);
        animation: fadeInDown 1s ease-out;
        color: var(--pure-white);
    }

    .blog-hero-title {
        font-size: clamp(2.5rem, 8vw, 4rem);
        font-weight: 800;
        margin-bottom: 20px;
        line-height: 1.1;
        text-shadow: 0 2px 10px rgba(10, 29, 68, 0.3);
        animation: fadeInUp 1s ease-out 0.2s both;
        color: var(--pure-white);
    }

    .blog-hero-title span {
        color: var(--bright-amber);
    }

    .blog-hero-text {
        font-size: clamp(1.1rem, 3vw, 1.3rem);
        opacity: 0.95;
        line-height: 1.8;
        max-width: 700px;
        margin: 0 auto;
        animation: fadeInUp 1s ease-out 0.4s both;
        color: var(--ivory);
    }

    /* Search Section */
    .blog-search-section {
        margin-top: -50px;
        position: relative;
        z-index: 10;
        margin-bottom: 60px;
    }

    .blog-search-container {
        max-width: 700px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .blog-search-form {
        background: var(--pure-white);
        border-radius: var(--radius-full);
        box-shadow: var(--shadow-lg);
        display: flex;
        align-items: center;
        padding: 5px;
        animation: slideUp 1s ease-out 0.6s both;
        border: 2px solid transparent;
        transition: var(--transition);
    }

    .blog-search-form:focus-within {
        border-color: var(--bright-amber);
        box-shadow: var(--shadow-hover);
    }

    .blog-search-input {
        flex: 1;
        border: none;
        padding: 16px 25px;
        font-size: 1rem;
        border-radius: var(--radius-full);
        outline: none;
        background: transparent;
        color: var(--text-primary);
    }

    .blog-search-input::placeholder {
        color: var(--khaki-beige);
    }

    .blog-search-button {
        background: var(--gradient-1);
        color: var(--pure-white);
        border: none;
        padding: 12px 30px;
        border-radius: var(--radius-full);
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 10px;
        white-space: nowrap;
    }

    .blog-search-button:hover {
        background: var(--gradient-2);
        color: var(--prussian-blue);
        transform: translateX(-3px);
        box-shadow: var(--shadow-hover);
    }

    .blog-search-button i {
        font-size: 1rem;
    }

    /* Featured Post */
    .featured-post-section {
        padding: 40px 0 60px;
    }

    .featured-post-card {
        background: var(--pure-white);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-lg);
        display: grid;
        grid-template-columns: 1.2fr 0.8fr;
        transition: var(--transition);
        border: 1px solid rgba(251, 198, 12, 0.1);
    }

    .featured-post-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-hover);
        border-color: var(--bright-amber);
    }

    .featured-post-image {
        position: relative;
        overflow: hidden;
        height: 100%;
        min-height: 400px;
    }

    .featured-post-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition-slow);
    }

    .featured-post-card:hover .featured-post-image img {
        transform: scale(1.1);
    }

    .featured-post-image::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to right, transparent 50%, rgba(10, 29, 68, 0.5) 100%);
    }

    .featured-post-content {
        padding: 50px;
        display: flex;
        flex-direction: column;
        background: var(--pure-white);
    }

    .featured-badge {
        display: inline-block;
        padding: 6px 16px;
        background: var(--gradient-2);
        color: var(--prussian-blue);
        border-radius: var(--radius-full);
        font-size: 0.8rem;
        font-weight: 600;
        margin-bottom: 20px;
        align-self: flex-start;
        border: 1px solid rgba(251, 198, 12, 0.3);
    }

    .featured-post-title {
        font-size: clamp(1.5rem, 3vw, 2rem);
        font-weight: 700;
        margin-bottom: 20px;
        line-height: 1.3;
    }

    .featured-post-title a {
        color: var(--text-primary);
        text-decoration: none;
        transition: var(--transition);
    }

    .featured-post-title a:hover {
        color: var(--bright-amber);
    }

    .featured-post-meta {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
        color: var(--text-muted);
        font-size: 0.95rem;
        flex-wrap: wrap;
    }

    .featured-post-meta i {
        color: var(--bright-amber);
        margin-right: 5px;
    }

    .featured-post-excerpt {
        color: var(--text-muted);
        line-height: 1.8;
        margin-bottom: 30px;
        font-size: 1.1rem;
    }

    .featured-post-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: auto;
        flex-wrap: wrap;
        gap: 20px;
    }

    .featured-post-author {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .author-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: var(--gradient-1);
        color: var(--pure-white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 1.2rem;
    }

    .author-info h4 {
        font-size: 1rem;
        margin-bottom: 5px;
        color: var(--text-primary);
    }

    .author-info p {
        font-size: 0.85rem;
        color: var(--text-muted);
    }

    .featured-read-more {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 12px 25px;
        background: var(--gradient-1);
        color: var(--pure-white);
        border-radius: var(--radius-full);
        text-decoration: none;
        font-weight: 600;
        transition: var(--transition);
        white-space: nowrap;
    }

    .featured-read-more:hover {
        background: var(--gradient-2);
        color: var(--prussian-blue);
        transform: translateX(5px);
        box-shadow: var(--shadow-hover);
    }

    /* Section Header */
    .section-header {
        text-align: center;
        margin-bottom: 50px;
    }

    .section-subtitle {
        color: var(--bright-amber);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 0.9rem;
        margin-bottom: 10px;
        display: block;
    }

    .section-title {
        font-size: clamp(2rem, 5vw, 2.5rem);
        font-weight: 800;
        margin-bottom: 15px;
        color: var(--text-primary);
    }

    .section-title span {
        color: var(--bright-amber);
    }

    .section-description {
        color: var(--text-muted);
        max-width: 700px;
        margin: 0 auto;
        font-size: 1.1rem;
        line-height: 1.8;
    }

    /* Blog Grid */
    .blog-grid-section {
        padding: 60px 0;
        background: var(--ivory);
    }

    .blog-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        margin-bottom: 40px;
    }

    .blog-card {
        background: var(--pure-white);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-md);
        transition: var(--transition);
        height: 100%;
        display: flex;
        flex-direction: column;
        border: 1px solid rgba(251, 198, 12, 0.1);
    }

    .blog-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-hover);
        border-color: var(--bright-amber);
    }

    .blog-card-image {
        position: relative;
        overflow: hidden;
        aspect-ratio: 16/9;
    }

    .blog-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition-slow);
    }

    .blog-card:hover .blog-card-image img {
        transform: scale(1.1);
    }

    .blog-card-category {
        position: absolute;
        top: 15px;
        right: 15px;
        padding: 5px 15px;
        background: var(--gradient-2);
        color: var(--prussian-blue);
        border-radius: var(--radius-full);
        font-size: 0.75rem;
        font-weight: 600;
        z-index: 2;
        box-shadow: var(--shadow-md);
        border: 1px solid rgba(251, 198, 12, 0.3);
    }

    .blog-card-content {
        padding: 25px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .blog-card-meta {
        display: flex;
        gap: 15px;
        margin-bottom: 12px;
        color: var(--text-muted);
        font-size: 0.85rem;
        flex-wrap: wrap;
    }

    .blog-card-meta i {
        color: var(--bright-amber);
        margin-right: 5px;
    }

    .blog-card-title {
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 12px;
        line-height: 1.4;
    }

    .blog-card-title a {
        color: var(--text-primary);
        text-decoration: none;
        transition: var(--transition);
    }

    .blog-card-title a:hover {
        color: var(--bright-amber);
    }

    .blog-card-excerpt {
        color: var(--text-muted);
        line-height: 1.7;
        margin-bottom: 20px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        flex: 1;
        font-size: 0.95rem;
    }

    .blog-card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: auto;
        padding-top: 15px;
        border-top: 1px solid rgba(251, 198, 12, 0.2);
        flex-wrap: wrap;
        gap: 10px;
    }

    .blog-card-author {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .blog-card-author .author-avatar {
        width: 35px;
        height: 35px;
        font-size: 0.9rem;
    }

    .blog-card-author .author-info h4 {
        font-size: 0.9rem;
        margin-bottom: 2px;
    }

    .blog-card-author .author-info p {
        font-size: 0.7rem;
    }

    .blog-card-read-more {
        color: var(--bright-amber);
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 5px;
        transition: var(--transition);
        white-space: nowrap;
    }

    .blog-card-read-more:hover {
        gap: 10px;
        color: var(--prussian-blue);
    }

    /* Loading Spinner */
    .loading-spinner {
        text-align: center;
        padding: 40px 0;
        display: none;
    }

    .loading-spinner.active {
        display: block;
    }

    .spinner {
        width: 50px;
        height: 50px;
        border: 4px solid var(--pale-slate);
        border-top-color: var(--bright-amber);
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto 15px;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* No Results */
    .no-results {
        text-align: center;
        padding: 80px 20px;
        background: var(--pure-white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        grid-column: 1 / -1;
        border: 1px solid rgba(251, 198, 12, 0.1);
    }

    .no-results-icon {
        width: 120px;
        height: 120px;
        background: var(--ivory);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px;
        font-size: 3rem;
        color: var(--bright-amber);
        border: 2px solid var(--bright-amber);
    }

    .no-results h3 {
        font-size: 1.8rem;
        margin-bottom: 10px;
        color: var(--text-primary);
    }

    .no-results p {
        color: var(--text-muted);
        margin-bottom: 25px;
        font-size: 1.1rem;
    }

    .reset-search {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 12px 30px;
        background: var(--gradient-1);
        color: var(--pure-white);
        border-radius: var(--radius-full);
        text-decoration: none;
        font-weight: 600;
        transition: var(--transition);
        border: none;
    }

    .reset-search:hover {
        background: var(--gradient-2);
        color: var(--prussian-blue);
        transform: translateY(-3px);
        box-shadow: var(--shadow-hover);
    }

    /* Pagination */
    .pagination {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-top: 40px;
        flex-wrap: wrap;
    }

    .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 40px;
        padding: 0 10px;
        background: var(--pure-white);
        border: 1px solid var(--pale-slate);
        border-radius: var(--radius-md);
        color: var(--text-primary);
        text-decoration: none;
        transition: var(--transition);
        font-weight: 500;
    }

    .page-link:hover {
        background: var(--gradient-2);
        color: var(--prussian-blue);
        border-color: transparent;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .page-item.active .page-link {
        background: var(--gradient-1);
        color: var(--pure-white);
        border-color: transparent;
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

    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }

    /* Notification */
    .notification {
        position: fixed;
        bottom: 20px;
        right: 20px;
        color: var(--pure-white);
        padding: 12px 24px;
        border-radius: var(--radius-full);
        box-shadow: var(--shadow-lg);
        z-index: 10000;
        animation: slideIn 0.3s ease;
        font-weight: 600;
    }

    .notification-success {
        background: var(--gradient-1);
    }

    .notification-error {
        background: var(--gradient-3);
        color: var(--prussian-blue);
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .blog-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 992px) {
        .featured-post-card {
            grid-template-columns: 1fr;
        }

        .featured-post-image {
            min-height: 300px;
        }

        .featured-post-image::after {
            background: linear-gradient(to bottom, transparent 50%, rgba(10, 29, 68, 0.5) 100%);
        }

        .featured-post-content {
            padding: 40px;
        }
    }

    @media (max-width: 768px) {
        .blog-hero {
            padding: 60px 0;
        }

        .blog-search-form {
            flex-direction: column;
            padding: 10px;
        }

        .blog-search-input {
            width: 100%;
            padding: 15px 20px;
        }

        .blog-search-button {
            width: 100%;
            justify-content: center;
        }

        .blog-grid {
            grid-template-columns: 1fr;
        }

        .featured-post-content {
            padding: 30px;
        }

        .featured-post-title {
            font-size: 1.5rem;
        }

        .featured-post-footer {
            flex-direction: column;
            align-items: flex-start;
        }

        .featured-read-more {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 576px) {
        .featured-post-content {
            padding: 25px;
        }

        .featured-post-meta {
            flex-direction: column;
            gap: 10px;
        }

        .blog-card-footer {
            flex-direction: column;
            align-items: flex-start;
        }

        .blog-card-read-more {
            width: 100%;
            justify-content: center;
        }

        .pagination {
            gap: 5px;
        }

        .page-link {
            min-width: 35px;
            height: 35px;
            font-size: 0.9rem;
        }

        .notification {
            left: 20px;
            right: 20px;
            text-align: center;
        }
    }
</style>
@endpush

@section('content')
    <!-- Hero Section -->
    <section class="blog-hero">
        <div class="blog-hero-particles">
            <div class="blog-hero-particle"></div>
            <div class="blog-hero-particle"></div>
            <div class="blog-hero-particle"></div>
        </div>
        
        <div class="container">
            <div class="blog-hero-content">
                <span class="blog-hero-badge">Our Blog</span>
                <h1 class="blog-hero-title">Insights & <span>Updates</span></h1>
                <p class="blog-hero-text">
                    Explore the latest articles, insights, and stories from the EDUCONECX community
                </p>
            </div>
        </div>
    </section>

    <!-- Search Section -->
    <div class="blog-search-section">
        <div class="blog-search-container">
            <form class="blog-search-form" id="searchForm" method="GET" action="{{ route('blog') }}">
                <input 
                    type="text" 
                    name="s" 
                    class="blog-search-input" 
                    placeholder="Search for articles..." 
                    value="{{ $searchTerm ?? '' }}"
                    autocomplete="off"
                >
                <button type="submit" class="blog-search-button">
                    <i class="fas fa-search"></i>
                    <span>Search</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Featured Post Section -->
    @if(isset($featuredPost) && $featuredPost)
    <section class="featured-post-section">
        <div class="container">
            <div class="featured-post-card" data-aos="fade-up">
                <div class="featured-post-image">
                    <img src="{{ $featuredPost['featured_image'] }}" alt="{{ $featuredPost['title'] }}">
                </div>
                <div class="featured-post-content">
                    <span class="featured-badge">Featured Article</span>
                    <h2 class="featured-post-title">
                        <a href="{{ route('blog.show', $featuredPost['slug']) }}">{{ $featuredPost['title'] }}</a>
                    </h2>
                    <div class="featured-post-meta">
                        <span><i class="far fa-calendar-alt"></i> {{ date('M d, Y', strtotime($featuredPost['published_at'])) }}</span>
                        <span><i class="far fa-clock"></i> {{ $featuredPost['read_time'] ?? '5' }} min read</span>
                        <span><i class="far fa-folder"></i> {{ $featuredPost['category'] }}</span>
                    </div>
                    <p class="featured-post-excerpt">{{ $featuredPost['excerpt'] }}</p>
                    <div class="featured-post-footer">
                        <div class="featured-post-author">
                            <div class="author-avatar">
                                {{ $featuredPost['author_avatar'] }}
                            </div>
                            <div class="author-info">
                                <h4>{{ $featuredPost['author'] }}</h4>
                                <p>Author</p>
                            </div>
                        </div>
                        <a href="{{ route('blog.show', $featuredPost['slug']) }}" class="featured-read-more">
                            Read Full Article <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Blog Posts Section -->
    <section class="blog-grid-section">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <span class="section-subtitle">Latest Articles</span>
                <h2 class="section-title">Recent <span>Posts</span></h2>
                <p class="section-description">
                    Stay up to date with the latest insights from our team
                </p>
            </div>

            @if(isset($posts) && $posts->count() > 0)
                <!-- Posts Grid -->
                <div class="blog-grid" id="postsGrid">
                    @foreach($posts as $post)
                        <div class="blog-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                            <div class="blog-card-image">
                                <img src="{{ $post['featured_image'] ?? 'https://via.placeholder.com/600x400' }}" alt="{{ $post['title'] }}">
                                <span class="blog-card-category">{{ $post['category'] ?? 'General' }}</span>
                            </div>
                            <div class="blog-card-content">
                                <div class="blog-card-meta">
                                    <span><i class="far fa-calendar-alt"></i> {{ date('M d, Y', strtotime($post['published_at'] ?? now())) }}</span>
                                    <span><i class="far fa-clock"></i> {{ $post['read_time'] ?? '5' }} min read</span>
                                </div>
                                <h3 class="blog-card-title">
                                    <a href="{{ route('blog.show', $post['slug']) }}">{{ $post['title'] }}</a>
                                </h3>
                                <p class="blog-card-excerpt">{{ $post['excerpt'] ?? Str::limit($post['content'] ?? '', 120) }}</p>
                                <div class="blog-card-footer">
                                    <div class="blog-card-author">
                                        <div class="author-avatar">
                                            {{ $post['author_avatar'] ?? substr($post['author'] ?? 'ED', 0, 1) }}
                                        </div>
                                        <div class="author-info">
                                            <h4>{{ $post['author'] ?? 'EDUCONECX' }}</h4>
                                            <p>Author</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('blog.show', $post['slug']) }}" class="blog-card-read-more">
                                        Read More <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Loading Spinner for Infinite Scroll -->
                <div class="loading-spinner" id="loadingSpinner">
                    <div class="spinner"></div>
                    <p style="color: var(--text-muted);">Loading more articles...</p>
                </div>

                <!-- Pagination (fallback if JavaScript fails) -->
                @if($posts->hasPages())
                    <div class="pagination">
                        {{ $posts->appends(request()->query())->links() }}
                    </div>
                @endif
            @else
                <!-- No Results -->
                <div class="no-results" data-aos="fade-up">
                    <div class="no-results-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3>No Articles Found</h3>
                    <p>We couldn't find any articles matching your search criteria.</p>
                    <a href="{{ route('blog') }}" class="reset-search">
                        <i class="fas fa-redo-alt"></i> Clear Search
                    </a>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get the current page data
    let currentPage = {{ $posts->currentPage() ?? 1 }};
    let lastPage = {{ $posts->lastPage() ?? 1 }};
    let loading = false;
    let hasMore = currentPage < lastPage;
    
    const postsGrid = document.getElementById('postsGrid');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const searchForm = document.getElementById('searchForm');
    const searchInput = document.querySelector('input[name="s"]');
    
    // Infinite Scroll with throttle
    let scrollTimeout;
    let scrollThrottle = false;
    
    window.addEventListener('scroll', function() {
        if (!hasMore || loading || scrollThrottle) return;
        
        scrollThrottle = true;
        
        setTimeout(() => {
            const scrollPosition = window.innerHeight + window.scrollY;
            const threshold = document.documentElement.scrollHeight - 1000;
            
            if (scrollPosition >= threshold) {
                loadMorePosts();
            }
            
            scrollThrottle = false;
        }, 200);
    });
    
    function loadMorePosts() {
        loading = true;
        loadingSpinner.classList.add('active');
        
        const nextPage = currentPage + 1;
        const searchTerm = searchInput ? searchInput.value : '';
        
        let url = '{{ route("blog") }}?page=' + nextPage;
        if (searchTerm) {
            url += '&s=' + encodeURIComponent(searchTerm);
        }
        
        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.html) {
                // Create temporary container
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = data.html;
                
                // Append new posts with animation
                const newPosts = tempDiv.children;
                Array.from(newPosts).forEach((post, index) => {
                    post.style.opacity = '0';
                    post.style.transform = 'translateY(20px)';
                    post.style.transition = 'all 0.5s ease';
                    postsGrid.appendChild(post);
                    
                    // Fade in animation
                    setTimeout(() => {
                        post.style.opacity = '1';
                        post.style.transform = 'translateY(0)';
                    }, index * 100);
                });
                
                currentPage = nextPage;
                hasMore = data.has_more;
            } else {
                hasMore = false;
            }
            
            loading = false;
            loadingSpinner.classList.remove('active');
        })
        .catch(error => {
            console.error('Error loading more posts:', error);
            loading = false;
            loadingSpinner.classList.remove('active');
            
            // Show error notification
            showNotification('Error loading more articles. Please try again.', 'error');
        });
    }
    
    // Search form submission with loading state
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            const button = this.querySelector('button[type="submit"]');
            const originalText = button.innerHTML;
            
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Searching...';
            button.disabled = true;
            
            // Form will submit normally, but we show loading state
            setTimeout(() => {
                button.innerHTML = originalText;
                button.disabled = false;
            }, 1000);
        });
    }
    
    // Search input with debounced validation
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(window.searchTimeout);
            window.searchTimeout = setTimeout(() => {
                if (this.value.length > 0 && this.value.length < 3) {
                    // Optional: Show hint for minimum characters
                }
            }, 500);
        });
    }
    
    // Notification function
    function showNotification(message, type = 'success') {
        // Remove any existing notifications
        const existingNotifications = document.querySelectorAll('.notification');
        existingNotifications.forEach(notification => notification.remove());
        
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 3000);
    }
    
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});
</script>
@endpush