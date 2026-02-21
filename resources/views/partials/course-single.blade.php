@extends('layouts.main')

@section('title', $course['title'] . ' - EDUCONECX')

@section('meta_description', $course['excerpt'])

@push('styles')
<style>
    .course-single {
        padding: 40px 0;
    }
    
    .course-header {
        margin-bottom: 30px;
    }
    
    .course-title {
        font-size: 36px;
        margin-bottom: 15px;
    }
    
    .course-meta {
        display: flex;
        gap: 20px;
        color: #666;
        margin-bottom: 20px;
    }
    
    .course-meta i {
        margin-right: 5px;
        color: var(--primary-color);
    }
    
    .course-content {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 30px;
    }
    
    .course-main {
        background: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .course-sidebar {
        background: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        height: fit-content;
        position: sticky;
        top: 100px;
    }
    
    .course-price-box {
        text-align: center;
        margin-bottom: 30px;
    }
    
    .course-price-box .price {
        font-size: 48px;
        font-weight: 700;
        color: var(--primary-color);
    }
    
    .course-price-box .price.free {
        color: #28a745;
    }
    
    .enroll-now-btn {
        display: block;
        width: 100%;
        padding: 15px;
        background: var(--primary-color);
        color: #fff;
        text-align: center;
        text-decoration: none;
        border-radius: 5px;
        font-weight: 600;
        margin: 20px 0;
    }
    
    .enroll-now-btn:hover {
        background: var(--primary-hover);
    }
    
    .course-features {
        list-style: none;
        padding: 0;
    }
    
    .course-features li {
        padding: 10px 0;
        border-bottom: 1px solid #eee;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .course-features i {
        color: var(--primary-color);
        width: 20px;
    }
    
    @media (max-width: 768px) {
        .course-content {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="container course-single">
    <div class="course-header">
        <h1 class="course-title">{{ $course['title'] }}</h1>
        <div class="course-meta">
            <span><i class="fas fa-users"></i> {{ $course['students_count'] }} students enrolled</span>
            <span><i class="fas fa-clock"></i> Lifetime access</span>
        </div>
    </div>
    
    <div class="course-content">
        <div class="course-main animate-on-scroll">
            <h2>About This Course</h2>
            <p>{{ $course['description'] }}</p>
            
            <h3>What You'll Learn</h3>
            <ul>
                <li>Professional video creation techniques</li>
                <li>Lighting and composition basics</li>
                <li>Audio recording and editing</li>
                <li>Post-production and editing</li>
            </ul>
            
            <h3>Requirements</h3>
            <ul>
                <li>A smartphone with camera</li>
                <li>Basic understanding of your phone's camera</li>
                <li>Willingness to learn and practice</li>
            </ul>
        </div>
        
        <div class="course-sidebar animate-on-scroll">
            <div class="course-price-box">
                @if($course['price'] == 0)
                    <div class="price free">Free</div>
                @else
                    <small class="price-label">Starts from</small>
                    <div class="price">${{ number_format($course['price'], 2) }}</div>
                @endif
                
                <a href="#" class="enroll-now-btn">Enroll Now</a>
                <p>30-Day Money-Back Guarantee</p>
            </div>
            
            <h4>This Course Includes:</h4>
            <ul class="course-features">
                <li><i class="fas fa-play-circle"></i> 10 hours on-demand video</li>
                <li><i class="fas fa-file"></i> 15 downloadable resources</li>
                <li><i class="fas fa-mobile-alt"></i> Access on mobile and TV</li>
                <li><i class="fas fa-certificate"></i> Certificate of completion</li>
            </ul>
        </div>
    </div>
</div>
@endsection