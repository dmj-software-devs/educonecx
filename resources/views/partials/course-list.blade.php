@if(count($courses) > 0)
    <div class="course-grid">
        @foreach($courses as $course)
            <div class="course-card animate-on-scroll">
                <div class="course-thumbnail">
                    <a href="{{ route('courses.show', $course['slug']) }}">
                        <img src="{{ $course['thumbnail'] }}" alt="{{ $course['title'] }}">
                    </a>
                    
                    @auth
                        <div class="course-bookmark">
                            <button class="bookmark-btn" data-course-id="{{ $course['id'] }}">
                                <i class="far fa-bookmark"></i>
                            </button>
                        </div>
                    @endauth
                </div>
                
                <div class="course-content">
                    @if($course['rating'] > 0)
                        <div class="course-ratings">
                            <div class="stars">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $course['rating'])
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="rating-count">({{ $course['reviews_count'] }})</span>
                        </div>
                    @endif
                    
                    <h3 class="course-title">
                        <a href="{{ route('courses.show', $course['slug']) }}">{{ $course['title'] }}</a>
                    </h3>
                    
                    <div class="course-meta">
                        <span><i class="fas fa-users"></i> {{ $course['students_count'] }} students</span>
                    </div>
                    
                    <div class="course-instructor">
                        <div class="instructor-avatar">
                            {{ $course['instructor_avatar'] }}
                        </div>
                        <div class="instructor-info">
                            <a href="#" class="instructor-name">{{ $course['instructor'] }}</a>
                            <div class="course-category">
In <a href="{{ route('courses.category', \Illuminate\Support\Str::slug($course['category_names'][0])) }}">{{ $course['category_names'][0] }}</a>                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="course-footer">
                    <div class="course-price {{ $course['price'] == 0 ? 'free' : '' }}">
                        @if($course['price'] == 0)
                            Free
                        @else
                            <small class="price-label">Starts from</small>
                            ${{ number_format($course['price'], 2) }}
                        @endif
                    </div>
                    
                    @if($course['price'] == 0)
                        <a href="{{ route('courses.show', $course['slug']) }}" class="enroll-btn">Enroll Now</a>
                    @else
                        <a href="{{ route('courses.show', $course['slug']) }}" class="enroll-btn view-details">View Details</a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="no-results">
        <i class="fas fa-search"></i>
        <h3>No Courses Found</h3>
        <p>We couldn't find any courses matching your criteria. Try adjusting your filters or browse all courses.</p>
        <a href="{{ route('courses') }}" class="reset-btn">View All Courses</a>
    </div>
@endif