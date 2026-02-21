@extends('layouts.main')

@section('title', 'About - EDUCONECX')

@section('meta_description', 'Learn about EDUCONECX, an international AI-powered educational platform dedicated to supporting learners worldwide with practical language and digital business skills.')

@push('styles')
<style>
    .about-section {
        padding: 60px 0;
    }
    
    .about-content {
        max-width: 900px;
        margin: 0 auto;
    }
    
    .about-section-title {
        font-size: 32px;
        margin-bottom: 30px;
        color: var(--primary-color);
    }
    
    .about-paragraph {
        margin-bottom: 25px;
        line-height: 1.8;
        color: #444;
    }
    
    .about-highlight {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 40px;
        border-radius: 15px;
        margin: 40px 0;
    }
    
    .values-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 30px;
        margin: 40px 0;
    }
    
    .value-card {
        background: #f8f9fa;
        padding: 30px;
        border-radius: 10px;
        text-align: center;
        transition: transform 0.3s;
    }
    
    .value-card:hover {
        transform: translateY(-5px);
    }
    
    .value-icon {
        font-size: 40px;
        color: var(--primary-color);
        margin-bottom: 20px;
    }
    
    .value-title {
        font-size: 20px;
        margin-bottom: 15px;
    }
</style>
@endpush

@section('content')
    <div class="container about-section">
        <div class="about-content animate-on-scroll">
            <h1 class="about-section-title">Who We Are</h1>
            <p class="about-paragraph">EDUCONECX is an international, AI-powered educational platform dedicated to supporting learners worldwide with practical language and digital business skills. Our mission is to help individuals overcome language barriers, build real-world competencies, and succeed in today's global digital economy.</p>
            
            <p class="about-paragraph">EDUCONECX operates as an educational platform focused on skill development, learning guidance, and practical application. We support learners, freelancers, and entrepreneurs by helping them combine structured learning programs to build projects, develop businesses, and grow in fields such as AI, linguistics, technology, and digital entrepreneurship.</p>
            
            <p class="about-paragraph">Our learning programs are curated from trusted and recognized educational sources and platforms. All content is reviewed, updated, and organized to ensure relevance, practicality, and alignment with real-world needs. Instead of requiring learners to search for and invest in multiple separate trainings, EDUCONECX brings essential knowledge together in one accessible platform, offering a comprehensive learning experience supported by tools and resources.</p>
            
            <p class="about-paragraph">In addition to the educational platform, EDUCONECX also operates NEO-EDTECH, a professional agency providing digital marketing, AI-powered solutions, web and e-commerce services, and business support. This initiative complements the learning experience by helping individuals and organizations apply knowledge in practical contexts and translate skills into measurable outcomes.</p>
            
            <p class="about-paragraph">EDUCONECX serves a global audience and focuses on effective, results-oriented programs designed for individuals who are motivated to apply what they learn and grow through real-world implementation.</p>
        </div>
        
        <div class="about-highlight animate-on-scroll">
            <h2 style="font-size: 28px; margin-bottom: 20px;">Who We Serve</h2>
            <p style="font-size: 18px; line-height: 1.8;">EDUCONECX supports learners, professionals, and entrepreneurs who seek to grow and adapt in a rapidly evolving digital world. The platform is designed for individuals who want to develop practical skills across areas such as technology, digital business, AI integration, communication, and professional development.</p>
            <p style="font-size: 18px; line-height: 1.8; margin-top: 20px;">Whether learners are beginning their journey or advancing existing skills, EDUCONECX provides structured learning paths, educational resources, and interactive experiences that support confident and continuous growth.</p>
        </div>
        
        <div class="about-content animate-on-scroll">
            <h2 class="about-section-title">Why We Created This Platform</h2>
            <p class="about-paragraph">We believe access to practical education is essential for personal and economic growth. Many individuals face challenges due to limited access to relevant learning resources or training that connects directly to real-world applications.</p>
            
            <p class="about-paragraph">EDUCONECX was created to address this gap. By combining AI-powered learning tools with a practical, skill-focused approach, the platform helps learners build capabilities that open opportunities in areas such as customer service, freelancing, online business, and global professional collaboration.</p>
        </div>
        
        <div class="about-content animate-on-scroll">
            <h2 class="about-section-title">Our Services</h2>
            <p class="about-paragraph">Empowering Learners with Practical Language and Digital Business Skills</p>
            
            <p class="about-paragraph">EDUCONECX offers AI-powered educational services designed to support success in the global digital economy. The platform provides flexible learning experiences for individuals seeking to improve communication skills, prepare for customer-facing roles, or develop digital and entrepreneurial capabilities.</p>
            
            <h3 style="font-size: 24px; margin: 30px 0 15px;">Language Learning Programs</h3>
            <p class="about-paragraph">Our language programs focus on practical communication skills designed for professional, digital, and everyday use. Learners develop confidence in real-world interactions, workplace communication, and global collaboration through structured and adaptable learning paths.</p>
            
            <h3 style="font-size: 24px; margin: 30px 0 15px;">Call Center & Customer Service Training</h3>
            <p class="about-paragraph">EDUCONECX provides training programs focused on communication skills, customer engagement, and professional readiness for customer support and service-based roles in international and remote environments.</p>
        </div>
    </div>
@endsection