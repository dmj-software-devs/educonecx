<?php

namespace App\Http\Controllers;

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
        return view('home');
    }

    public function about()
    {
        return view('about');
    }

    public function academy()
    {
        return view('academy');
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
        return view('faqs');
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
