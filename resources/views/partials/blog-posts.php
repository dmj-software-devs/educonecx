@if(isset($posts) && count($posts) > 0)
    @foreach($posts as $post)
        <article class="blog-card animate-on-scroll">
            <a href="{{ route('blog.show', $post['slug']) }}" class="blog-image-link">
                <img src="{{ $post['featured_image'] ?? 'https://via.placeholder.com/800x437' }}" alt="{{ $post['title'] }}" class="blog-image">
            </a>
            
            <div class="blog-content">
                <div class="blog-meta">
                    <a href="{{ route('blog') }}?category={{ $post['category_slug'] ?? '' }}" class="blog-category">
                        {{ $post['category'] ?? 'Uncategorized' }}
                    </a>
                    <span class="blog-date">
                        {{ isset($post['published_at']) ? \Carbon\Carbon::parse($post['published_at'])->format('F j, Y') : date('F j, Y') }}
                    </span>
                </div>
                
                <h2 class="blog-post-title">
                    <a href="{{ route('blog.show', $post['slug']) }}">
                        {{ $post['title'] }}
                    </a>
                </h2>
                
                <p class="blog-excerpt">{{ $post['excerpt'] ?? '' }}</p>
                
                <a href="{{ route('blog.show', $post['slug']) }}" class="read-more">
                    Explore <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </article>
    @endforeach
@else
    <div class="no-results">
        <i class="fas fa-search"></i>
        <h3>No Articles Found</h3>
        <p>We couldn't find any articles matching your search. Try different keywords or browse all articles.</p>
        <a href="{{ route('blog') }}" class="reset-search">View All Articles</a>
    </div>
@endif