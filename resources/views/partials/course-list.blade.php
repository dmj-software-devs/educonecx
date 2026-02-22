@if($courses->count() > 0)
    <div class="course-grid">
        @foreach($courses as $course)
            <div class="course-card">
                @if($course->featured)
                    <span class="course-badge popular">Popular</span>
                @elseif($course->price == 0 || ($course->sale_price == 0))
                    <span class="course-badge free">Free</span>
                @endif
                
                <div class="course-bookmark">
                    <button class="bookmark-btn" data-course-id="{{ $course->id }}">
                        <i class="far fa-bookmark"></i>
                    </button>
                </div>
                
                <div class="course-thumbnail">
                    <img src="{{ $course->thumbnail_url }}" alt="{{ $course->title }}">
                    <div class="course-overlay">
                        <span class="course-preview"><i class="far fa-play-circle"></i> Preview Course</span>
                    </div>
                </div>
                
                <div class="course-content">
                    <div class="course-meta-top">
                        <span class="course-category">{{ $course->category->name ?? 'General' }}</span>
                        <div class="course-rating">
                            <span class="stars">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($course->average_rating))
                                        <i class="fas fa-star"></i>
                                    @elseif($i - 0.5 <= $course->average_rating)
                                        <i class="fas fa-star-half-alt"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </span>
                            <span class="rating-value">{{ number_format($course->average_rating, 1) }}</span>
                            <span class="rating-count">({{ $course->total_reviews }})</span>
                        </div>
                    </div>
                    
                    <h3 class="course-title">
                        <a href="{{ route('courses.show', $course->slug) }}">{{ $course->title }}</a>
                    </h3>
                    
                    <p class="course-description">{{ $course->excerpt }}</p>
                    
                    <div class="course-meta">
                        <span><i class="far fa-clock"></i> {{ $course->duration }} hours</span>
                        <span><i class="fas fa-signal"></i> {{ $course->level }}</span>
                        <span><i class="fas fa-video"></i> {{ $course->total_lessons }} lessons</span>
                    </div>
                    
                    <div class="course-instructor">
                        <div class="instructor-avatar">
                            {{ substr($course->instructor->name ?? 'EA', 0, 1) }}
                        </div>
                        <div class="instructor-info">
                            <span class="instructor-name">{{ $course->instructor->name ?? 'EDUCONECX ACADEMY' }}</span>
                            <div class="instructor-title">Expert Instructor</div>
                        </div>
                    </div>
                </div>
                
                <div class="course-footer">
                    <div class="course-price {{ $course->price == 0 ? 'free' : '' }}">
                        @if($course->hasDiscount)
                            ${{ number_format($course->sale_price, 2) }}
                            <small>${{ number_format($course->price, 2) }}</small>
                        @elseif($course->price > 0)
                            ${{ number_format($course->price, 2) }}
                        @else
                            Free
                        @endif
                        <span class="price-label">one-time payment</span>
                    </div>
                    <a href="{{ route('courses.show', $course->slug) }}" class="enroll-btn">
                        View Details <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if($courses->hasPages())
        <div class="pagination">
            {{ $courses->appends(request()->query())->links() }}
        </div>
    @endif
@else
    <!-- No Results -->
    <div class="no-results">
        <div class="no-results-icon">
            <i class="fas fa-search"></i>
        </div>
        <h3>No Courses Found</h3>
        <p>We couldn't find any courses matching your criteria. Try adjusting your filters.</p>
        <a href="{{ route('courses') }}" class="reset-btn">
            <i class="fas fa-redo-alt"></i> Reset All Filters
        </a>
    </div>
@endif