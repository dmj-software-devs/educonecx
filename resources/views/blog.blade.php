@extends('layouts.main')

@section('title', 'Blog - EDUCONECX | Insights & Updates')

@section('meta_description', 'Explore the latest articles, insights, and updates from EDUCONECX. Stay informed about learning, technology, and digital innovation.')

@push('styles')
<style>
    /* Hero Section */
    .blog-hero {
        position: relative;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 100px 0;
        overflow: hidden;
        color: var(--white);
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
        background: rgba(255, 255, 255, 0.1);
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
        animation: float 10s ease-in-out infinite reverse;
    }

    .blog-hero-particle:nth-child(3) {
        width: 150px;
        height: 150px;
        top: 30%;
        left: 20%;
        animation: float 12s ease-in-out infinite;
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
        background: rgba(255, 255, 255, 0.2);
        border-radius: var(--border-radius-full);
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 25px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        animation: fadeInDown 1s ease-out;
    }

    .blog-hero-title {
        font-size: clamp(2.5rem, 8vw, 4rem);
        font-weight: 800;
        margin-bottom: 20px;
        line-height: 1.1;
        text-shadow: 0 2px 10px rgba(0,0,0,0.3);
        animation: fadeInUp 1s ease-out 0.2s both;
    }

    .blog-hero-text {
        font-size: clamp(1.1rem, 3vw, 1.3rem);
        opacity: 0.9;
        line-height: 1.8;
        max-width: 700px;
        margin: 0 auto;
        animation: fadeInUp 1s ease-out 0.4s both;
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
        background: var(--white);
        border-radius: 60px;
        box-shadow: var(--shadow-lg);
        display: flex;
        align-items: center;
        padding: 5px;
        animation: slideUp 1s ease-out 0.6s both;
    }

    .blog-search-input {
        flex: 1;
        border: none;
        padding: 18px 25px;
        font-size: 1rem;
        border-radius: 60px;
        outline: none;
        background: transparent;
    }

    .blog-search-input:focus {
        box-shadow: none;
    }

    .blog-search-button {
        background: var(--gradient-1);
        color: var(--white);
        border: none;
        padding: 14px 35px;
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

    .blog-search-button:hover {
        transform: translateX(-5px);
        box-shadow: var(--shadow-md);
    }

    .blog-search-button i {
        font-size: 1rem;
    }

    /* Featured Post */
    .featured-post-section {
        padding: 40px 0 60px;
    }

    .featured-post-card {
        background: var(--white);
        border-radius: var(--border-radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-lg);
        display: grid;
        grid-template-columns: 1.2fr 0.8fr;
        transition: var(--transition);
    }

    .featured-post-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-hover);
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
        background: linear-gradient(to right, transparent 50%, rgba(0,0,0,0.5) 100%);
    }

    .featured-post-content {
        padding: 50px;
        display: flex;
        flex-direction: column;
        background: var(--white);
    }

    .featured-badge {
        display: inline-block;
        padding: 5px 15px;
        background: var(--gradient-1);
        color: var(--white);
        border-radius: var(--border-radius-full);
        font-size: 0.8rem;
        font-weight: 600;
        margin-bottom: 20px;
        align-self: flex-start;
    }

    .featured-post-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 20px;
        line-height: 1.3;
    }

    .featured-post-title a {
        color: var(--dark);
        text-decoration: none;
        transition: var(--transition);
    }

    .featured-post-title a:hover {
        color: var(--primary);
    }

    .featured-post-meta {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
        color: var(--gray);
        font-size: 0.95rem;
    }

    .featured-post-meta i {
        color: var(--primary);
        margin-right: 5px;
    }

    .featured-post-excerpt {
        color: var(--gray);
        line-height: 1.8;
        margin-bottom: 30px;
        font-size: 1.1rem;
    }

    .featured-post-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: auto;
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
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 1.2rem;
    }

    .author-info h4 {
        font-size: 1rem;
        margin-bottom: 5px;
    }

    .author-info p {
        font-size: 0.85rem;
        color: var(--gray);
    }

    .featured-read-more {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 12px 25px;
        background: var(--gradient-1);
        color: var(--white);
        border-radius: var(--border-radius-full);
        text-decoration: none;
        font-weight: 600;
        transition: var(--transition);
    }

    .featured-read-more:hover {
        transform: translateX(5px);
        box-shadow: var(--shadow-md);
    }

    /* Blog Grid Section */
    .blog-grid-section {
        padding: 60px 0;
        background: var(--light);
    }

    .section-header {
        text-align: center;
        margin-bottom: 50px;
    }

    .section-subtitle {
        color: var(--primary);
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
    }

    .section-description {
        color: var(--gray);
        max-width: 700px;
        margin: 0 auto;
        font-size: 1.1rem;
        line-height: 1.8;
    }

    .blog-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        margin-bottom: 40px;
    }

    .blog-card {
        background: var(--white);
        border-radius: var(--border-radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .blog-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-lg);
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
        background: var(--gradient-1);
        color: var(--white);
        border-radius: var(--border-radius-full);
        font-size: 0.75rem;
        font-weight: 600;
        z-index: 2;
        box-shadow: var(--shadow-md);
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
        margin-bottom: 15px;
        color: var(--gray);
        font-size: 0.85rem;
    }

    .blog-card-meta i {
        color: var(--primary);
        margin-right: 5px;
    }

    .blog-card-title {
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 15px;
        line-height: 1.4;
    }

    .blog-card-title a {
        color: var(--dark);
        text-decoration: none;
        transition: var(--transition);
    }

    .blog-card-title a:hover {
        color: var(--primary);
    }

    .blog-card-excerpt {
        color: var(--gray);
        line-height: 1.8;
        margin-bottom: 20px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        flex: 1;
    }

    .blog-card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: auto;
        padding-top: 15px;
        border-top: 1px solid var(--gray-light);
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
        font-size: 0.75rem;
    }

    .blog-card-read-more {
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 5px;
        transition: var(--transition);
    }

    .blog-card-read-more:hover {
        gap: 10px;
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
        border: 4px solid var(--gray-light);
        border-top-color: var(--primary);
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
        background: var(--white);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-sm);
        grid-column: 1 / -1;
    }

    .no-results-icon {
        width: 120px;
        height: 120px;
        background: var(--light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px;
        font-size: 3rem;
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
    }

    .reset-search:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-lg);
    }

    /* Pagination */
    .pagination {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-top: 40px;
    }

    .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 40px;
        padding: 0 10px;
        background: var(--white);
        border: 1px solid var(--gray-light);
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

    /* Responsive */
    @media (max-width: 1024px) {
        .blog-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .featured-post-card {
            grid-template-columns: 1fr;
        }

        .featured-post-image {
            min-height: 300px;
        }

        .featured-post-image::after {
            background: linear-gradient(to bottom, transparent 50%, rgba(0,0,0,0.5) 100%);
        }
    }

    @media (max-width: 768px) {
        .blog-hero {
            padding: 60px 0;
        }

        .blog-search-form {
            flex-direction: column;
            border-radius: 30px;
        }

        .blog-search-input {
            width: 100%;
            padding: 15px 20px;
        }

        .blog-search-button {
            width: 100%;
            border-radius: 30px;
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
            gap: 20px;
            align-items: flex-start;
        }
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
                <h1 class="blog-hero-title">Insights & Updates</h1>
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

    <!-- Blog Posts Section -->
    <section class="blog-grid-section">
        <div class="container">
            @if(isset($posts) && $posts->count() > 0)
                <!-- Posts Grid -->
                <div class="blog-grid" id="postsGrid">
                    @foreach($posts as $post)
                        <div class="blog-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                            <div class="blog-card-image">
                                <img src="{{ $post['featured_image'] }}" alt="{{ $post['title'] }}">
                                <span class="blog-card-category">{{ $post['category'] }}</span>
                            </div>
                            <div class="blog-card-content">
                                <div class="blog-card-meta">
                                    <span><i class="far fa-calendar-alt"></i> {{ date('M d, Y', strtotime($post['published_at'])) }}</span>
                                    <span><i class="far fa-clock"></i> 5 min read</span>
                                </div>
                                <h3 class="blog-card-title">
                                    <a href="{{ route('blog.show', $post['slug']) }}">{{ $post['title'] }}</a>
                                </h3>
                                <p class="blog-card-excerpt">{{ $post['excerpt'] }}</p>
                                <div class="blog-card-footer">
                                    <div class="blog-card-author">
                                        <div class="author-avatar">
                                            {{ $post['author_avatar'] }}
                                        </div>
                                        <div class="author-info">
                                            <h4>{{ $post['author'] }}</h4>
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
                    <p style="color: var(--gray);">Loading more articles...</p>
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
    
    // Infinite Scroll
    let scrollTimeout;
    window.addEventListener('scroll', function() {
        if (!hasMore || loading) return;
        
        // Debounce scroll events
        clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(() => {
            const scrollPosition = window.innerHeight + window.scrollY;
            const threshold = document.documentElement.scrollHeight - 1000;
            
            if (scrollPosition >= threshold) {
                loadMorePosts();
            }
        }, 100);
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
        .then(response => response.json())
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
                    postsGrid.appendChild(post);
                    
                    // Fade in animation
                    setTimeout(() => {
                        post.style.transition = 'all 0.5s ease';
                        post.style.opacity = '1';
                        post.style.transform = 'translateY(0)';
                    }, index * 100);
                });
                
                currentPage = nextPage;
                hasMore = data.has_more;
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
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.style.cssText = `
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: ${type === 'success' ? 'var(--success)' : 'var(--danger)'};
            color: white;
            padding: 12px 24px;
            border-radius: var(--border-radius-full);
            box-shadow: var(--shadow-lg);
            z-index: 10000;
            animation: slideIn 0.3s ease;
        `;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 3000);
    }
    
    // Add animation styles
    const style = document.createElement('style');
    style.textContent = `
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
    `;
    document.head.appendChild(style);
});
</script>
@endpush