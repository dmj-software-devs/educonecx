@if(($practiceCourses ?? collect())->count() > 0 || $courses->count() > 0)
<div class="course-grid">
    @foreach(($practiceCourses ?? collect()) as $practiceCourse)
    @php
        $canAccessPracticeCourse = Auth::check() && (Auth::user()->canAccessPracticeRoom() || Auth::user()->isAdmin());
        $practiceCourseUrl = $canAccessPracticeCourse
            ? route('practice-room.courses.show', $practiceCourse->slug)
            : (Auth::check()
                ? route('educonecx.academy.index')
                : route('login') . '?redirect=' . urlencode(route('educonecx.academy.index')));
    @endphp
    <div class="course-card practice-room-course-card">
        <span class="course-badge" style="background: var(--gradient-2); color: var(--prussian-blue);">
            <i class="fas fa-comments"></i> Practice Room
        </span>

        <div class="course-thumbnail">
            <img src="{{ $practiceCourse->thumbnail_url ?? asset('images/course-placeholder.jpg') }}" alt="{{ $practiceCourse->title }}" loading="lazy">
            <div class="course-overlay">
                <span class="course-preview"><i class="fas fa-external-link-alt"></i> Open in Practice Room</span>
            </div>
        </div>

        <div class="course-content">
            <div class="course-meta-top">
                <span class="course-category">English Practice</span>
            </div>

            <h3 class="course-title">
                <a href="{{ $practiceCourseUrl }}">{{ $practiceCourse->title }}</a>
            </h3>

            <p class="course-description">{{ Str::limit(strip_tags($practiceCourse->description), 100) }}</p>

            <div class="course-meta">
                <span><i class="fas fa-signal"></i> {{ ucfirst($practiceCourse->level ?? 'Beginner') }}</span>
                <span><i class="fas fa-video"></i> {{ App\Helpers\TranslationHelper::trans('courses.course_lessons', ['count' => $practiceCourse->lessons_count ?? 0]) }}</span>
            </div>

            <div class="course-instructor">
                <div class="instructor-avatar">PR</div>
                <div class="instructor-info">
                    <a href="{{ $practiceCourseUrl }}" class="instructor-name">Practice Room</a>
                    <div class="instructor-title">Paid member course</div>
                </div>
            </div>
        </div>

        <div class="course-footer">
            <div class="course-price">
                {{ $canAccessPracticeCourse ? 'Access included' : App\Helpers\TranslationHelper::trans('courses.price_subscription') }}
                <span class="price-label">{{ $canAccessPracticeCourse ? 'Open from the Practice Room' : 'Requires Practice Room access' }}</span>
            </div>

            <a href="{{ $practiceCourseUrl }}" class="enroll-btn" style="background: var(--gradient-3); color: var(--prussian-blue);">
                <i class="fas fa-arrow-right"></i> Go to Practice Room
            </a>
        </div>
    </div>
    @endforeach
    @foreach($courses as $course)
    <div class="course-card">
        @if($course->featured)
        <span class="course-badge popular">{{ App\Helpers\TranslationHelper::trans('courses.badge_popular') }}</span>
        @elseif($course->is_free)
        <span class="course-badge free">{{ App\Helpers\TranslationHelper::trans('courses.badge_free') }}</span>
        @elseif(Auth::check() && Auth::user()->has_active_subscription)
        <span class="course-badge" style="background: var(--gradient-3); color: var(--prussian-blue);">
            <i class="fas fa-check-circle"></i> {{ App\Helpers\TranslationHelper::trans('courses.badge_subscribed') }}
        </span>
        @endif

        <div class="course-bookmark">
            <button class="bookmark-btn" data-course-id="{{ $course->id }}" data-bookmarked="{{ $course->isBookmarked ? 'true' : 'false' }}">
                <i class="{{ $course->isBookmarked ? 'fas' : 'far' }} fa-bookmark"></i>
            </button>
        </div>

        <div class="course-thumbnail">
            <img src="{{ $course->thumbnail_url ?? 'https://via.placeholder.com/600x400' }}" alt="{{ $course->title }}" loading="lazy">
            <div class="course-overlay">
                <span class="course-preview"><i class="far fa-play-circle"></i> {{ App\Helpers\TranslationHelper::trans('courses.preview_course') }}</span>
            </div>
        </div>

        <div class="course-content">
            <div class="course-meta-top">
                <span class="course-category">{{ $course->category->name ?? App\Helpers\TranslationHelper::trans('courses.course_category') }}</span>
                <div class="course-rating">
                    <span class="stars">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($course->average_rating ?? 0))
                            <i class="fas fa-star"></i>
                            @elseif($i - 0.5 <= ($course->average_rating ?? 0))
                                <i class="fas fa-star-half-alt"></i>
                                @else
                                <i class="far fa-star"></i>
                                @endif
                                @endfor
                    </span>
                    <span class="rating-value">{{ number_format($course->average_rating ?? 0, 1) }}</span>
                    <span class="rating-count">({{ $course->reviews_count ?? 0 }})</span>
                </div>
            </div>

            <h3 class="course-title">
                <a href="{{ route('courses.show', $course->slug) }}">{{ $course->title }}</a>
            </h3>

            <p class="course-description">{{ $course->excerpt ?? Str::limit($course->description, 100) }}</p>

            <div class="course-meta">
                <span><i class="far fa-clock"></i> {{ App\Helpers\TranslationHelper::trans('courses.course_hours', ['count' => $course->duration_hours ?? 0]) }}</span>
                <span><i class="fas fa-signal"></i> {{ ucfirst($course->level ?? 'Beginner') }}</span>
                <span><i class="fas fa-video"></i> {{ App\Helpers\TranslationHelper::trans('courses.course_lessons', ['count' => $course->lessons_count ?? 0]) }}</span>
            </div>

            <div class="course-instructor">
                <div class="instructor-avatar">
                    {{ substr($course->instructor->name ?? 'ED', 0, 1) }}
                </div>
                <div class="instructor-info">
                    <a href="#" class="instructor-name">{{ $course->instructor->name ?? App\Helpers\TranslationHelper::trans('courses.instructor_default') }}</a>
                    <div class="instructor-title">{{ App\Helpers\TranslationHelper::trans('courses.instructor_title') }}</div>
                </div>
            </div>
        </div>

        <div class="course-footer">
            <div class="course-price {{ $course->is_free ? 'free' : '' }}">
                @if($course->is_free)
                {{ App\Helpers\TranslationHelper::trans('courses.price_free_label') }}
                @else
                @auth
                {{ Auth::user()->has_active_subscription ? App\Helpers\TranslationHelper::trans('courses.badge_subscribed') : App\Helpers\TranslationHelper::trans('courses.price_subscription') }}
                @else
                {{ App\Helpers\TranslationHelper::trans('courses.price_subscription') }}
                @endauth
                @endif
                <span class="price-label">
                    @if($course->is_free)
                    {{ App\Helpers\TranslationHelper::trans('courses.price_free_detail') }}
                    @else
                    @auth
                    {{ Auth::user()->has_active_subscription ? App\Helpers\TranslationHelper::trans('courses.price_subscribed_detail') : App\Helpers\TranslationHelper::trans('courses.price_subscription_detail') }}
                    @else
                    {{ App\Helpers\TranslationHelper::trans('courses.price_subscription_detail') }}
                    @endauth
                    @endif
                </span>
            </div>

            @auth
            @if(!$course->is_free && Auth::user()->has_active_subscription)
            <a href="{{ route('courses.show', $course->slug) }}" class="enroll-btn" style="background: var(--gradient-3); color: var(--prussian-blue);">
                <i class="fas fa-play-circle"></i> {{ App\Helpers\TranslationHelper::trans('courses.btn_start_learning') }}
            </a>
            @else
            <a href="{{ route('courses.show', $course->slug) }}" class="enroll-btn">
                {{ App\Helpers\TranslationHelper::trans('courses.btn_view_details') }} <i class="fas fa-arrow-right"></i>
            </a>
            @endif
            @else
            <a href="{{ route('courses.show', $course->slug) }}" class="enroll-btn">
                {{ App\Helpers\TranslationHelper::trans('courses.btn_view_details') }} <i class="fas fa-arrow-right"></i>
            </a>
            @endauth
        </div>
    </div>
    @endforeach
</div>

<!-- Pagination -->
@if($courses->hasPages())
<div class="pagination" id="paginationContainer">
    {{ $courses->appends(request()->query())->links() }}
</div>
@endif
@else
<!-- No Results -->
<div class="no-results" data-aos="fade-up">
    <div class="no-results-icon">
        <i class="fas fa-search"></i>
    </div>
    <h3>{{ App\Helpers\TranslationHelper::trans('courses.no_results_title') }}</h3>
    <p>{{ App\Helpers\TranslationHelper::trans('courses.no_results_description') }}</p>
    <a href="{{ route('courses') }}" class="reset-btn" id="resetFiltersBtn">
        <i class="fas fa-redo-alt"></i> {{ App\Helpers\TranslationHelper::trans('courses.btn_reset_filters') }}
    </a>
</div>
@endif