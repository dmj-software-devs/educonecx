@extends('layouts.main')

@section('title', $post['title'] . ' - EDUCONECX Blog')

@section('meta_description', $post['excerpt'])

@push('styles')
<style>
    .blog-single {
        padding: 40px 0;
    }
    
    /* Back Link */
    .back-link {
        margin-bottom: 30px;
    }
    
    .back-link a {
        color: var(--primary-color);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .back-link a:hover {
        gap: 12px;
    }
    
    /* Article Header */
    .article-header {
        margin-bottom: 40px;
    }
    
    .article-category {
        display: inline-block;
        padding: 5px 15px;
        background: var(--primary-color);
        color: white;
        border-radius: 5px;
        text-decoration: none;
        font-size: 14px;
        margin-bottom: 20px;
    }
    
    .article-title {
        font-size: 42px;
        line-height: 1.2;
        margin-bottom: 20px;
        color: var(--text-color);
    }
    
    .article-meta {
        display: flex;
        align-items: center;
        gap: 20px;
        color: #666;
    }
    
    .article-author {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .author-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--primary-color);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
    }
    
    .article-date {
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    /* Featured Image */
    .featured-image {
        margin-bottom: 40px;
        border-radius: 15px;
        overflow: hidden;
    }
    
    .featured-image img {
        width: 100%;
        height: auto;
        display: block;
    }
    
    /* Article Content */
    .article-content {
        max-width: 800px;
        margin: 0 auto 60px;
        line-height: 1.8;
        color: #444;
    }
    
    .article-content h2 {
        font-size: 28px;
        margin: 40px 0 20px;
        color: var(--text-color);
    }
    
    .article-content h3 {
        font-size: 22px;
        margin: 30px 0 15px;
        color: var(--text-color);
    }
    
    .article-content p {
        margin-bottom: 20px;
    }
    
    .article-content ul, 
    .article-content ol {
        margin-bottom: 20px;
        padding-left: 20px;
    }
    
    .article-content li {
        margin-bottom: 10px;
    }
    
    .article-content blockquote {
        margin: 30px 0;
        padding: 20px 30px;
        background: #f8f9fa;
        border-left: 4px solid var(--primary-color);
        font-style: italic;
    }
    
    .article-content img {
        max-width: 100%;
        height: auto;
        border-radius: 10px;
        margin: 30px 0;
    }
    
    /* Share Section */
    .share-section {
        max-width: 800px;
        margin: 0 auto 60px;
        padding: 30px 0;
        border-top: 1px solid #eee;
        border-bottom: 1px solid #eee;
    }
    
    .share-title {
        font-size: 18px;
        margin-bottom: 15px;
        color: var(--text-color);
    }
    
    .share-buttons {
        display: flex;
        gap: 15px;
    }
    
    .share-button {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-decoration: none;
        transition: transform 0.3s;
    }
    
    .share-button:hover {
        transform: translateY(-3px);
    }
    
    .share-button.facebook {
        background: #1877f2;
    }
    
    .share-button.twitter {
        background: #1da1f2;
    }
    
    .share-button.linkedin {
        background: #0077b5;
    }
    
    .share-button.whatsapp {
        background: #25d366;
    }
    
    /* Related Posts */
    .related-posts {
        max-width: 800px;
        margin: 0 auto;
    }
    
    .related-title {
        font-size: 24px;
        margin-bottom: 30px;
        text-align: center;
    }
    
    .related-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }
    
    .related-card {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        transition: transform 0.3s;
    }
    
    .related-card:hover {
        transform: translateY(-5px);
    }
    
    .related-image {
        width: 100%;
        height: 150px;
        object-fit: cover;
    }
    
    .related-content {
        padding: 15px;
    }
    
    .related-post-title {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 10px;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    
    .related-post-title a {
        color: var(--text-color);
        text-decoration: none;
    }
    
    .related-post-title a:hover {
        color: var(--primary-color);
    }
    
    .related-date {
        font-size: 12px;
        color: #999;
    }
    
    @media (max-width: 768px) {
        .article-title {
            font-size: 32px;
        }
        
        .article-meta {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
        
        .related-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="container blog-single">
    <!-- Back Link -->
    <div class="back-link">
        <a href="{{ route('blog') }}">
            <i class="fas fa-arrow-left"></i> Back to Blog
        </a>
    </div>
    
    <!-- Article Header -->
    <article>
        <header class="article-header animate-on-scroll">
            <a href="{{ route('blog') }}?category={{ $post['category_slug'] }}" class="article-category">
                {{ $post['category'] }}
            </a>
            <h1 class="article-title">{{ $post['title'] }}</h1>
            
            <div class="article-meta">
                <div class="article-author">
                    <div class="author-avatar">{{ $post['author_avatar'] }}</div>
                    <span>{{ $post['author'] }}</span>
                </div>
                <div class="article-date">
                    <i class="far fa-calendar-alt"></i>
                    {{ \Carbon\Carbon::parse($post['published_at'])->format('F j, Y') }}
                </div>
            </div>
        </header>
        
        <!-- Featured Image -->
        <div class="featured-image animate-on-scroll">
            <img src="{{ $post['featured_image'] }}" alt="{{ $post['title'] }}">
        </div>
        
        <!-- Article Content -->
        <div class="article-content animate-on-scroll">
            <p>{{ $post['excerpt'] }}</p>
            
            <h2>Introduction</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            
            <h2>Main Content</h2>
            <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            
            <blockquote>
                "The beautiful thing about learning is that no one can take it away from you." - B.B. King
            </blockquote>
            
            <h3>Key Takeaways</h3>
            <ul>
                <li>Understanding the importance of continuous learning</li>
                <li>Practical strategies for skill development</li>
                <li>Leveraging technology for educational growth</li>
            </ul>
            
            <h2>Conclusion</h2>
            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
        </div>
    </article>
    
    <!-- Share Section -->
    <div class="share-section animate-on-scroll">
        <h3 class="share-title">Share this article</h3>
        <div class="share-buttons">
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="share-button facebook" title="Share on Facebook">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($post['title']) }}" target="_blank" class="share-button twitter" title="Share on Twitter">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&title={{ urlencode($post['title']) }}" target="_blank" class="share-button linkedin" title="Share on LinkedIn">
                <i class="fab fa-linkedin-in"></i>
            </a>
            <a href="https://wa.me/?text={{ urlencode($post['title'] . ' - ' . url()->current()) }}" target="_blank" class="share-button whatsapp" title="Share on WhatsApp">
                <i class="fab fa-whatsapp"></i>
            </a>
        </div>
    </div>
    
    <!-- Related Posts -->
    @if(count($relatedPosts) > 0)
    <section class="related-posts animate-on-scroll">
        <h2 class="related-title">Related Articles</h2>
        <div class="related-grid">
            @foreach($relatedPosts as $related)
                <div class="related-card">
                    <a href="{{ route('blog.show', $related['slug']) }}">
                        <img src="{{ $related['featured_image'] }}" alt="{{ $related['title'] }}" class="related-image">
                    </a>
                    <div class="related-content">
                        <h3 class="related-post-title">
                            <a href="{{ route('blog.show', $related['slug']) }}">{{ $related['title'] }}</a>
                        </h3>
                        <div class="related-date">
                            {{ \Carbon\Carbon::parse($related['published_at'])->format('M j, Y') }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    @endif
</div>
@endsection