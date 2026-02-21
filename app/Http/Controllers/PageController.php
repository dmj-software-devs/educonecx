<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
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

    // Remove the blog method from here since we're using BlogController
    // public function blog()
    // {
    //     return view('blog');
    // }

    public function ourTeam()
    {
        return view('our-team');
    }

    public function contact()
    {
        return view('contact');
    }

    public function courses()
    {
        return view('courses');
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
        return view('pricing');
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