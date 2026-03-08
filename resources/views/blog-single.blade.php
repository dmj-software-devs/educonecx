@extends('layouts.main')

@section('title', ($post->meta_title ?? $post->title) . ' - EDUCONECX Blog')

@section('meta_description', $post->meta_description ?? $post->excerpt)

@if($post->meta_keywords)
    @section('meta_keywords', $post->meta_keywords)
@endif

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
        transition: var(--transition);
    }
    
    .article-category:hover {
        background: var(--bright-amber);
        color: var(--prussian-blue);
        transform: translateY(-2px);
    }
    
    .article-title {
        font-size: 42px;
        line-height: 1.2;
        margin-bottom: 20px;
        color: var(--text-primary);
    }
    
    .article-meta {
        display: flex;
        align-items: center;
        gap: 20px;
        color: var(--text-muted);
        flex-wrap: wrap;
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
        background: var(--gradient-1);
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
    
    .article-date i {
        color: var(--bright-amber);
    }
    
    .article-read-time {
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    .article-read-time i {
        color: var(--bright-amber);
    }
    
    /* Featured Image */
    .featured-image {
        margin-bottom: 40px;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: var(--shadow-lg);
    }
    
    .featured-image img {
        width: 100%;
        height: auto;
        display: block;
        transition: var(--transition-slow);
    }
    
    .featured-image:hover img {
        transform: scale(1.02);
    }
    
    /* Article Content */
    .article-content {
        max-width: 800px;
        margin: 0 auto 60px;
        line-height: 1.8;
        color: var(--text-secondary);
        font-size: 1.1rem;
    }
    
    .article-content h2 {
        font-size: 28px;
        margin: 40px 0 20px;
        color: var(--text-primary);
    }
    
    .article-content h3 {
        font-size: 22px;
        margin: 30px 0 15px;
        color: var(--text-primary);
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
        background: var(--ivory);
        border-left: 4px solid var(--bright-amber);
        font-style: italic;
        border-radius: 0 var(--radius-md) var(--radius-md) 0;
        color: var(--text-primary);
    }
    
    .article-content img {
        max-width: 100%;
        height: auto;
        border-radius: 10px;
        margin: 30px 0;
        box-shadow: var(--shadow-md);
    }
    
    .article-content a {
        color: var(--bright-amber);
        text-decoration: none;
        font-weight: 600;
    }
    
    .article-content a:hover {
        text-decoration: underline;
    }
    
    .article-content table {
        width: 100%;
        margin: 30px 0;
        border-collapse: collapse;
    }
    
    .article-content th,
    .article-content td {
        padding: 12px;
        border: 1px solid var(--pale-slate);
    }
    
    .article-content th {
        background: var(--gradient-1);
        color: white;
    }
    
    /* Share Section */
    .share-section {
        max-width: 800px;
        margin: 0 auto 60px;
        padding: 30px 0;
        border-top: 1px solid var(--pale-slate);
        border-bottom: 1px solid var(--pale-slate);
    }
    
    .share-title {
        font-size: 18px;
        margin-bottom: 15px;
        color: var(--text-primary);
    }
    
    .share-buttons {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
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
        transition: var(--transition);
    }
    
    .share-button:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-hover);
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
    
    .share-button.pinterest {
        background: #bd081c;
    }
    
    .share-button.email {
        background: var(--primary-color);
    }
    
    /* Views Count */
    .article-views {
        display: flex;
        align-items: center;
        gap: 5px;
        margin-left: auto;
    }
    
    .article-views i {
        color: var(--bright-amber);
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
        color: var(--text-primary);
    }
    
    .related-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }
    
    .related-card {
        background: white;
        border-radius: var(--radius-md);
        overflow: hidden;
        box-shadow: var(--shadow-md);
        transition: var(--transition);
        border: 1px solid rgba(251, 198, 12, 0.1);
    }
    
    .related-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-hover);
        border-color: var(--bright-amber);
    }
    
    .related-image {
        width: 100%;
        height: 150px;
        object-fit: cover;
        transition: var(--transition-slow);
    }
    
    .related-card:hover .related-image {
        transform: scale(1.05);
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
        color: var(--text-primary);
        text-decoration: none;
        transition: var(--transition);
    }
    
    .related-post-title a:hover {
        color: var(--bright-amber);
    }
    
    .related-date {
        font-size: 12px;
        color: var(--text-muted);
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    .related-date i {
        color: var(--bright-amber);
        font-size: 10px;
    }
    
    /* Table of Contents */
    .table-of-contents {
        background: var(--ivory);
        padding: 25px;
        border-radius: var(--radius-md);
        margin-bottom: 40px;
        border-left: 4px solid var(--bright-amber);
    }
    
    .table-of-contents h3 {
        font-size: 18px;
        margin-bottom: 15px;
        color: var(--text-primary);
    }
    
    .table-of-contents ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .table-of-contents li {
        margin-bottom: 8px;
    }
    
    .table-of-contents a {
        color: var(--text-secondary);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .table-of-contents a:hover {
        color: var(--bright-amber);
    }
    
    .table-of-contents a i {
        font-size: 12px;
        color: var(--bright-amber);
    }
    
    /* Tags */
    .post-tags {
        max-width: 800px;
        margin: 0 auto 40px;
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    
    .post-tag {
        padding: 5px 15px;
        background: var(--ivory);
        color: var(--text-secondary);
        border-radius: var(--radius-full);
        font-size: 0.9rem;
        text-decoration: none;
        transition: var(--transition);
        border: 1px solid transparent;
    }
    
    .post-tag:hover {
        background: var(--bright-amber);
        color: var(--prussian-blue);
        border-color: var(--bright-amber);
        transform: translateY(-2px);
    }
    
    /* Author Bio */
    .author-bio {
        max-width: 800px;
        margin: 0 auto 40px;
        padding: 30px;
        background: var(--ivory);
        border-radius: var(--radius-lg);
        display: flex;
        gap: 30px;
        align-items: center;
        border: 1px solid rgba(251, 198, 12, 0.2);
    }
    
    .author-bio-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: var(--gradient-1);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: 600;
        flex-shrink: 0;
    }
    
    .author-bio-content h3 {
        font-size: 20px;
        margin-bottom: 10px;
        color: var(--text-primary);
    }
    
    .author-bio-content p {
        color: var(--text-muted);
        line-height: 1.6;
        margin-bottom: 15px;
    }
    
    .author-bio-social {
        display: flex;
        gap: 10px;
    }
    
    .author-bio-social a {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-primary);
        transition: var(--transition);
    }
    
    .author-bio-social a:hover {
        background: var(--bright-amber);
        color: white;
        transform: translateY(-2px);
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
        
        .author-bio {
            flex-direction: column;
            text-align: center;
            padding: 20px;
        }
        
        .author-bio-social {
            justify-content: center;
        }
        
        .article-views {
            margin-left: 0;
        }
    }

    @media (max-width: 576px) {
        .article-title {
            font-size: 28px;
        }
        
        .share-buttons {
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
<div class="container blog-single">
    <!-- Back Link -->
    <div class="back-link animate-on-scroll">
        <a href="{{ route('blog') }}">
            <i class="fas fa-arrow-left"></i> Back to Blog
        </a>
    </div>
    
    <!-- Article Header -->
    <article>
        <header class="article-header animate-on-scroll">
            <a href="{{ route('blog', ['category' => $post->category_slug]) }}" class="article-category">
                {{ $post->category }}
            </a>
            <h1 class="article-title">{{ $post->title }}</h1>
            
            <div class="article-meta">
                <div class="article-author">
                    <div class="author-avatar">{{ $post->author_avatar }}</div>
                    <span>{{ $post->author }}</span>
                </div>
                <div class="article-date">
                    <i class="far fa-calendar-alt"></i>
                    {{ $post->formatted_published_at }}
                </div>
                @if($post->read_time)
                <div class="article-read-time">
                    <i class="far fa-clock"></i>
                    {{ $post->read_time }} min read
                </div>
                @endif
                <div class="article-views">
                    <i class="far fa-eye"></i>
                    {{ number_format($post->views_count) }} views
                </div>
            </div>
        </header>
        
        <!-- Featured Image -->
        @if($post->featured_image)
        <div class="featured-image animate-on-scroll">
            <img src="{{ $post->featured_image }}" alt="{{ $post->title }}">
        </div>
        @endif
        
        <!-- Table of Contents (optional - can be generated from content) -->
        @if($post->content && str_contains($post->content, '<h2'))
        <div class="table-of-contents animate-on-scroll">
            <h3><i class="fas fa-list"></i> Table of Contents</h3>
            <ul id="toc"></ul>
        </div>
        @endif
        
        <!-- Article Content -->
        <div class="article-content animate-on-scroll">
            {!! $post->content !!}
        </div>
    </article>
    
    <!-- Post Tags -->
    @if($post->meta_keywords)
    <div class="post-tags animate-on-scroll">
        @foreach(explode(',', $post->meta_keywords) as $tag)
            <a href="{{ route('blog', ['s' => trim($tag)]) }}" class="post-tag">
                <i class="fas fa-tag"></i> {{ trim($tag) }}
            </a>
        @endforeach
    </div>
    @endif
    
    <!-- Share Section -->
    <div class="share-section animate-on-scroll">
        <h3 class="share-title">Share this article</h3>
        <div class="share-buttons">
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="share-button facebook" title="Share on Facebook">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->title) }}" target="_blank" class="share-button twitter" title="Share on Twitter">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&title={{ urlencode($post->title) }}" target="_blank" class="share-button linkedin" title="Share on LinkedIn">
                <i class="fab fa-linkedin-in"></i>
            </a>
            <a href="https://wa.me/?text={{ urlencode($post->title . ' - ' . url()->current()) }}" target="_blank" class="share-button whatsapp" title="Share on WhatsApp">
                <i class="fab fa-whatsapp"></i>
            </a>
            <a href="https://pinterest.com/pin/create/button/?url={{ urlencode(url()->current()) }}&media={{ urlencode($post->featured_image) }}&description={{ urlencode($post->title) }}" target="_blank" class="share-button pinterest" title="Share on Pinterest">
                <i class="fab fa-pinterest-p"></i>
            </a>
            <a href="mailto:?subject={{ urlencode($post->title) }}&body={{ urlencode('Check out this article: ' . url()->current()) }}" class="share-button email" title="Share via Email">
                <i class="fas fa-envelope"></i>
            </a>
        </div>
    </div>
    
    <!-- Author Bio Section -->
    <div class="author-bio animate-on-scroll">
        <div class="author-bio-avatar">{{ $post->author_avatar }}</div>
        <div class="author-bio-content">
            <h3>About {{ $post->author }}</h3>
            <p>{{ $post->author }} is a contributor at EDUCONECX, passionate about sharing knowledge and insights in {{ $post->category }} and related fields.</p>
            <div class="author-bio-social">
                <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
                <a href="#" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                <a href="#" title="GitHub"><i class="fab fa-github"></i></a>
                <a href="#" title="Website"><i class="fas fa-globe"></i></a>
            </div>
        </div>
    </div>
    
    <!-- Related Posts -->
    @if($relatedPosts->count() > 0)
    <section class="related-posts animate-on-scroll">
        <h2 class="related-title">Related Articles</h2>
        <div class="related-grid">
            @foreach($relatedPosts as $related)
                <div class="related-card">
                    <a href="{{ route('blog.show', $related->slug) }}">
                        <img src="{{ $related->featured_image ?? 'https://via.placeholder.com/300x200' }}" alt="{{ $related->title }}" class="related-image">
                    </a>
                    <div class="related-content">
                        <h3 class="related-post-title">
                            <a href="{{ route('blog.show', $related->slug) }}">{{ $related->title }}</a>
                        </h3>
                        <div class="related-date">
                            <i class="far fa-calendar-alt"></i>
                            {{ $related->formatted_published_at }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Generate Table of Contents
    const content = document.querySelector('.article-content');
    const toc = document.getElementById('toc');
    
    if (content && toc) {
        const headings = content.querySelectorAll('h2');
        
        headings.forEach((heading, index) => {
            // Add ID to heading if not present
            if (!heading.id) {
                heading.id = 'heading-' + index;
            }
            
            // Create TOC item
            const li = document.createElement('li');
            const a = document.createElement('a');
            a.href = '#' + heading.id;
            a.innerHTML = '<i class="fas fa-chevron-right"></i> ' + heading.textContent;
            
            // Smooth scroll
            a.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.getElementById(this.getAttribute('href').substring(1));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
            
            li.appendChild(a);
            toc.appendChild(li);
        });
    }
    
    // Lazy load images
    const images = document.querySelectorAll('.article-content img');
    images.forEach(img => {
        img.loading = 'lazy';
    });
    
    // Add copy buttons to code blocks
    const codeBlocks = document.querySelectorAll('.article-content pre');
    codeBlocks.forEach(block => {
        const button = document.createElement('button');
        button.className = 'copy-code-btn';
        button.innerHTML = '<i class="fas fa-copy"></i>';
        button.style.cssText = `
            position: absolute;
            top: 10px;
            right: 10px;
            background: var(--bright-amber);
            color: var(--prussian-blue);
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.3s;
        `;
        
        button.addEventListener('click', function() {
            const code = block.querySelector('code').innerText;
            navigator.clipboard.writeText(code).then(() => {
                this.innerHTML = '<i class="fas fa-check"></i>';
                setTimeout(() => {
                    this.innerHTML = '<i class="fas fa-copy"></i>';
                }, 2000);
            });
        });
        
        block.style.position = 'relative';
        block.appendChild(button);
    });
});
</script>
@endpush