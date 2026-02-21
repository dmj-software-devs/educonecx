@extends('layouts.main')

@section('title', 'Blog - EDUCONECX')

@section('meta_description', 'Explore the latest articles, insights, and updates from EDUCONECX. Stay informed about learning, technology, and digital innovation.')

@push('styles')
<style>
    /* Blog Header */
    .blog-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 60px 0;
        text-align: center;
        margin-bottom: 40px;
    }
    
    .blog-title {
        font-size: 48px;
        margin-bottom: 15px;
        animation: slideUp 0.8s ease-out;
    }
    
    .blog-subtitle {
        font-size: 18px;
        opacity: 0.9;
        max-width: 600px;
        margin: 0 auto;
        animation: slideUp 0.8s ease-out 0.2s both;
    }
    
    /* Search Section */
    .search-section {
        margin: -30px auto 40px;
        max-width: 600px;
        position: relative;
        z-index: 10;
    }
    
    .search-form {
        background: white;
        border-radius: 50px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        display: flex;
        overflow: hidden;
        animation: slideUp 0.8s ease-out 0.4s both;
    }
    
    .search-input {
        flex: 1;
        border: none;
        padding: 15px 25px;
        font-size: 16px;
        outline: none;
    }
    
    .search-button {
        background: var(--primary-color);
        color: white;
        border: none;
        padding: 0 30px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.3s;
    }
    
    .search-button:hover {
        background: var(--primary-hover);
    }
    
    /* Blog Grid */
    .blog-section {
        padding: 20px 0 60px;
    }
    
    .blog-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 30px;
        margin-bottom: 40px;
    }
    
    .blog-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        transition: all 0.3s;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .blog-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }
    
    .blog-image {
        width: 100%;
        height: 240px;
        object-fit: cover;
        transition: transform 0.3s;
    }
    
    .blog-card:hover .blog-image {
        transform: scale(1.05);
    }
    
    .blog-content {
        padding: 25px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    
    .blog-meta {
        display: flex;
        gap: 15px;
        margin-bottom: 15px;
        font-size: 14px;
        color: #666;
    }
    
    .blog-category {
        color: var(--primary-color);
        font-weight: 600;
        text-decoration: none;
    }
    
    .blog-category:hover {
        text-decoration: underline;
    }
    
    .blog-date {
        position: relative;
        padding-left: 15px;
    }
    
    .blog-date:before {
        content: '•';
        position: absolute;
        left: 5px;
        color: #999;
    }
    
    .blog-post-title {
        font-size: 20px;
        font-weight: 600;
        line-height: 1.4;
        margin-bottom: 15px;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    
    .blog-post-title a {
        color: var(--text-color);
        text-decoration: none;
        transition: color 0.3s;
    }
    
    .blog-post-title a:hover {
        color: var(--primary-color);
    }
    
    .blog-excerpt {
        color: #666;
        line-height: 1.6;
        margin-bottom: 20px;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
    }
    
    .read-more {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 600;
        margin-top: auto;
        transition: gap 0.3s;
    }
    
    .read-more:hover {
        gap: 12px;
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
        border: 3px solid #f3f3f3;
        border-top: 3px solid var(--primary-color);
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    /* No Results */
    .no-results {
        text-align: center;
        padding: 60px 20px;
        background: #f8f9fa;
        border-radius: 15px;
        grid-column: 1 / -1;
    }
    
    .no-results i {
        font-size: 60px;
        color: #ccc;
        margin-bottom: 20px;
    }
    
    .no-results h3 {
        font-size: 24px;
        margin-bottom: 10px;
        color: var(--text-color);
    }
    
    .no-results p {
        color: #666;
        margin-bottom: 20px;
    }
    
    .reset-search {
        display: inline-block;
        padding: 10px 30px;
        background: var(--primary-color);
        color: white;
        border-radius: 5px;
        text-decoration: none;
        transition: background 0.3s;
    }
    
    .reset-search:hover {
        background: var(--primary-hover);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .blog-title {
            font-size: 36px;
        }
        
        .blog-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        
        .search-form {
            flex-direction: column;
            border-radius: 10px;
            margin: 0 15px;
        }
        
        .search-button {
            padding: 12px;
        }
        
        .blog-image {
            height: 200px;
        }
    }
</style>
@endpush

@section('content')
    <!-- Blog Header -->
    <section class="blog-header">
        <div class="container">
            <h1 class="blog-title">Blog</h1>
            <p class="blog-subtitle">Insights, updates, and stories from the EDUCONECX community</p>
        </div>
    </section>
    
    <!-- Search Section -->
    <div class="search-section">
        <div class="container">
            <form class="search-form" id="searchForm" method="GET" action="{{ route('blog') }}">
                <input 
                    type="text" 
                    name="s" 
                    class="search-input" 
                    placeholder="Search for an article..." 
                    value="{{ $searchTerm ?? '' }}"
                    autocomplete="off"
                >
                <button type="submit" class="search-button">
                    <i class="fas fa-search"></i> Search
                </button>
            </form>
        </div>
    </div>
    
    <!-- Blog Posts Section -->
    <section class="blog-section">
        <div class="container">
            <!-- Posts Grid -->
            <div class="blog-grid" id="postsGrid">
                @include('partials.blog-posts')
            </div>
            
            <!-- Loading Spinner -->
            <div class="loading-spinner" id="loadingSpinner">
                <div class="spinner"></div>
                <p style="margin-top: 15px; color: #666;">Loading more articles...</p>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentPage = {{ $posts->currentPage() ?? 1 }};
    let lastPage = {{ $posts->lastPage() ?? 1 }};
    let loading = false;
    let hasMore = currentPage < lastPage;
    
    const postsGrid = document.getElementById('postsGrid');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const searchForm = document.getElementById('searchForm');
    const searchInput = document.querySelector('input[name="s"]');
    
    // Infinite Scroll
    window.addEventListener('scroll', function() {
        if (!hasMore || loading) return;
        
        const scrollPosition = window.innerHeight + window.scrollY;
        const threshold = document.documentElement.scrollHeight - 1000;
        
        if (scrollPosition >= threshold) {
            loadMorePosts();
        }
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
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.html) {
                // Append new posts
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = data.html;
                postsGrid.appendChild(tempDiv.firstElementChild);
                
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
        });
    }
    
    // Search form submission
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            // Form submits normally
        });
    }
});
</script>
@endpush