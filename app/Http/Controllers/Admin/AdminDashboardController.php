<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function index()
    {
        return view('admin.dashboard');
    }

    /**
     * Show analytics page
     */
    public function analytics()
    {
        return view('admin.analytics');
    }
}