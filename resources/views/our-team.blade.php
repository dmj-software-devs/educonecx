@extends('layouts.main')

@section('title', 'Our Team - EDUCONECX')

@section('meta_description', 'Meet the passionate minds behind EDUCONECX - a team of educators, creators, and AI visionaries working together to break language barriers and build a brighter, more inclusive future.')

@push('styles')
<style>
    /* Team Header */
    .team-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 80px 0;
        text-align: center;
        margin-bottom: 60px;
    }
    
    .team-title {
        font-size: 48px;
        margin-bottom: 20px;
        animation: slideUp 0.8s ease-out;
    }
    
    .team-subtitle {
        font-size: 18px;
        opacity: 0.9;
        max-width: 700px;
        margin: 0 auto;
        line-height: 1.6;
        animation: slideUp 0.8s ease-out 0.2s both;
    }
    
    .team-subtitle strong {
        color: #fff;
        font-weight: 700;
    }
    
    /* Team Grid */
    .team-section {
        padding: 0 0 80px;
    }
    
    .team-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 30px;
        max-width: 1000px;
        margin: 0 auto;
    }
    
    .team-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        transition: all 0.3s;
        text-align: center;
        padding: 30px;
    }
    
    .team-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }
    
    .team-image {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        object-fit: cover;
        margin: 0 auto 25px;
        border: 5px solid #f8f9fa;
        transition: transform 0.3s;
    }
    
    .team-card:hover .team-image {
        transform: scale(1.05);
    }
    
    .team-name {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 10px;
        color: var(--text-color);
    }
    
    .team-position {
        font-size: 16px;
        color: var(--primary-color);
        font-weight: 600;
        margin-bottom: 15px;
        line-height: 1.5;
    }
    
    .team-bio {
        color: #666;
        font-size: 14px;
        line-height: 1.6;
        max-width: 300px;
        margin: 0 auto;
    }
    
    /* Team Description */
    .team-description {
        text-align: center;
        max-width: 800px;
        margin: 0 auto 50px;
        padding: 0 20px;
    }
    
    .team-description p {
        font-size: 18px;
        line-height: 1.8;
        color: #555;
        margin-bottom: 20px;
    }
    
    .team-description p:last-child {
        margin-bottom: 0;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .team-header {
            padding: 60px 0;
        }
        
        .team-title {
            font-size: 36px;
        }
        
        .team-subtitle {
            font-size: 16px;
            padding: 0 20px;
        }
        
        .team-grid {
            grid-template-columns: 1fr;
            gap: 20px;
            padding: 0 20px;
        }
        
        .team-image {
            width: 150px;
            height: 150px;
        }
        
        .team-name {
            font-size: 20px;
        }
        
        .team-position {
            font-size: 14px;
        }
    }
</style>
@endpush

@section('content')
    <!-- Team Header -->
    <section class="team-header">
        <div class="container">
            <h1 class="team-title">Our Team</h1>
            <div class="team-subtitle">
                <p><strong>Meet the passionate minds behind EDUCONECX</strong></p>
                <p>A team of educators, creators, and AI visionaries working together to break language barriers and build a brighter, more inclusive future.</p>
                <p>We blend technology, heart, and purpose to serve communities with clarity, care, and confidence.</p>
            </div>
        </div>
    </section>
    
    <!-- Team Grid -->
    <section class="team-section">
        <div class="container">
            <div class="team-grid">
                @foreach($teamMembers as $member)
                    <div class="team-card animate-on-scroll">
                        <img src="{{ $member['image'] }}" alt="{{ $member['name'] }}" class="team-image">
                        <h2 class="team-name">{{ $member['name'] }}</h2>
                        <div class="team-position">{{ $member['position'] }}</div>
                        @if(isset($member['bio']))
                            <p class="team-bio">{{ $member['bio'] }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection