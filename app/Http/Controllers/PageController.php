<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Team members data
     */
    private function getTeamMembers()
    {
        return [
            [
                'name' => 'Loumiel Joseph',
                'position' => 'Chief Executive Officer (Global Vision)',
                'image' => 'https://educonecx.com/wp-content/uploads/2025/09/Our-Team.png',
                'bio' => 'Leading with global vision and strategic direction.',
            ],
            [
                'name' => 'Elyona Raynell',
                'position' => 'Chief Product & Technology Officer (CPT)',
                'image' => 'https://educonecx.com/wp-content/uploads/2025/09/Our-Team-2.png',
                'bio' => 'Driving product innovation and technological excellence.',
            ],
            [
                'name' => 'Garcia Rico',
                'position' => 'Chief Operations & Strategic Partnerships Officer (COSPO)',
                'image' => 'https://educonecx.com/wp-content/uploads/2025/09/18ca3ab7-2f68-40cd-8961-aa6fb9642156.png',
                'bio' => 'Building strategic partnerships and operational efficiency.',
            ],
            [
                'name' => 'Daniella Roy',
                'position' => 'Chief Learning & Academic Officer (CLAO)',
                'image' => 'https://educonecx.com/wp-content/uploads/2025/09/aefd2257-13f8-48f4-aef7-a5f60553a9ec-e1761195154721.png',
                'bio' => 'Shaping learning experiences and academic excellence.',
            ],
        ];
    }

    public function home()
    {
        // Fetch featured courses for the home page
        $featuredCourses = Course::published()
            ->with('category', 'instructor')
            ->featured()
            ->latest('published_at')
            ->take(3)
            ->get();

        // You can also fetch popular courses if needed
        $popularCourses = Course::published()
            ->with('category', 'instructor')
            ->popular()
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('home', compact('featuredCourses', 'popularCourses'));
    }

    public function about()
    {
        return view('about');
    }

    public function academy()
    {
        // Fetch active categories with their courses
        $categories = Category::with(['courses' => function ($query) {
            $query->published()
                ->with('instructor')
                ->latest('published_at')
                ->take(10); // Limit courses per category if needed
        }])
            ->active()
            ->orderBy('sort_order')
            ->get();

        // Calculate stats from database
        $totalCourses = Course::published()->count();
        $totalStudents = Course::published()->sum('total_students');
        $totalCategories = Category::active()->count();
        $averageRating = Course::published()->avg('average_rating');

        // Get learning paths (you can create a separate model for this or use categories with parent/child)
        $learningPaths = Category::with(['courses' => function ($query) {
            $query->published()->with('instructor');
        }])
            ->parents() // Get parent categories as learning paths
            ->active()
            ->orderBy('sort_order')
            ->take(4)
            ->get();

        return view('academy', compact(
            'categories',
            'totalCourses',
            'totalStudents',
            'totalCategories',
            'averageRating',
            'learningPaths'
        ));
    }

    public function neoEdTech()
    {
        return view('neo-ed-tech');
    }

    public function ourTeam()
    {
        $teamMembers = $this->getTeamMembers();
        return view('our-team', compact('teamMembers'));
    }

    public function contact()
    {
        return view('contact');
    }

    public function quiz()
    {
        return view('quiz');
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function pricing()
    {
        $plans = [
            'free' => [
                'name' => 'Free Plan',
                'price' => 0,
                'description' => 'Start learning with free access to selected courses.',
                'features' => [
                    'Sign up and get Access to beginner courses',
                    'Community support',
                    'Mobile-friendly learning'
                ],
                'button_text' => 'Get Started',
                'button_url' => '/checkout?plan=free',
                'highlight' => false
            ],
            'pro' => [
                'name' => 'Pro Plan',
                'price' => 22,
                'description' => 'Unlock all core courses and features for serious learners.',
                'features' => [
                    'Everything in Free',
                    'Access to all courses',
                    'Downloadable resources',
                    'Certificate of completion'
                ],
                'button_text' => 'Get Started',
                'button_url' => '/checkout?plan=pro',
                'highlight' => true,
                'popular' => true
            ],
            'vip' => [
                'name' => 'VIP Plan',
                'price' => 49,
                'description' => 'Premium access with personalized support and bonuses.',
                'features' => [
                    'Everything in Pro',
                    '1-on-1 mentorship',
                    'Exclusive webinars',
                    'Priority support'
                ],
                'button_text' => 'Get Started',
                'button_url' => '/checkout?plan=vip',
                'highlight' => false
            ]
        ];

        return view('pricing', compact('plans'));
    }

    public function faqs()
    {
        // Group FAQs into two columns for display
        $faqColumns = [
            'left' => [
                [
                    'question' => 'What is EDUCONECX?',
                    'answer' => 'EDUCONECX is an innovative online educational platform that combines AI-powered English learning with specialized call center training programs. We offer both free and premium educational content designed to accelerate your professional development. Even if you are already learning English, EDUCONECX is the best platform to stay connected and practice.',
                    'open' => true // First item open by default
                ],
                [
                    'question' => 'In which languages are the courses available?',
                    'answer' => 'Our courses are available in English, French, Haitian Creole, and Spanish to serve our diverse international community of learners.'
                ],
                [
                    'question' => 'How do I get started?',
                    'answer' => 'Getting started is simple: create your account, select your preferred course, and begin with our 3-day free trial to explore the platform risk-free.'
                ],
                [
                    'question' => 'Which devices are compatible with EDUCONECX?',
                    'answer' => 'You can access EDUCONECX seamlessly across all your devices — mobile phones, tablets, and computers — ensuring learning flexibility wherever you are.'
                ],
                [
                    'question' => 'What is the AI Companion?',
                    'answer' => 'The AI Companion is an interactive learning assistant that helps you practice languages, provides instant answers to your questions, and guides you through your educational journey with personalized support.'
                ],
                [
                    'question' => 'Can I cancel my subscription?',
                    'answer' => 'Yes, you have full control over your subscription and may cancel at any time before your next renewal date without any hassle.'
                ],
                [
                    'question' => 'What is the refund policy?',
                    'answer' => 'EDUCONECX provides immediate access to digital content and online learning services. For this reason, all purchases and subscriptions are final and non-refundable. Users may cancel future billing at any time, but past charges cannot be refunded. For full details, please refer to our official Refund Policy section.'
                ],
            ],
            'right' => [
                [
                    'question' => 'Where can I use EDUCONECX?',
                    'answer' => 'EDUCONECX is an international digital learning platform accessible from anywhere in the world. Wherever you are located, you can create your account, access your courses, and use all available services with no geographic restrictions. As long as you have an internet connection, you can enjoy your learning experience globally, 24/7.'
                ],
                [
                    'question' => 'How can I contact support?',
                    'answer' => 'Reach our dedicated support team at <a href="mailto:contact@educonecx.com">contact@educonecx.com</a>. We typically respond within 1-2 business days to ensure you get the assistance you need.'
                ],
                [
                    'question' => 'Do I receive certificates upon completion?',
                    'answer' => 'EDUCONECX offers regional certificates for select courses only. Not all courses include certification, and availability may vary based on the program and region. Courses that provide a certificate will clearly indicate this information before enrollment.'
                ],
                [
                    'question' => 'What payment methods are accepted?',
                    'answer' => 'All payments are processed securely through Stripe, ensuring your financial information remains protected while supporting multiple payment options.'
                ],
                [
                    'question' => 'What should I do if I experience connection issues?',
                    'answer' => 'First, please verify your internet connection. If problems persist, our support team is ready to help troubleshoot and resolve any technical difficulties.'
                ],
                [
                    'question' => 'Where is EDUCONECX headquartered?',
                    'answer' => 'EDUCONECX is proudly headquartered in Miami, Florida, USA, strategically positioned to serve our international community of learners.'
                ],
                [
                    'question' => 'Does EDUCONECX offer call center preparation?',
                    'answer' => 'Absolutely! We provide comprehensive, specialized training programs specifically designed to prepare you for successful call center careers with industry-relevant skills and knowledge. Motivational Tagline: "Transform your potential into success — make learning your daily superpower with EDUCONECX."'
                ],
                [
                    'question' => 'What is NEO-EDTECH?',
                    'answer' => 'NEO-EDTECH is a professional agency that provides <strong>digital marketing, AI-powered solutions, and web services</strong>. Our mission is to help businesses and entrepreneurs grow by offering tools such as website creation, e-commerce support, marketing campaigns, and technology consulting. We focus on combining <strong>linguistic and technological innovation</strong> to deliver modern, results-oriented solutions.'
                ],
            ]
        ];

        return view('faqs', compact('faqColumns'));
    }

    public function privacy()
    {
        return view('privacy');
    }

    public function refund()
    {
        return view('refund');
    }

    public function terms()
    {
        return view('terms');
    }
}
