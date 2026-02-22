<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\Order;
use App\Models\Quiz;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Perform global search.
     */
    public function index(Request $request)
    {
        $query = $request->q;

        if (empty($query) || strlen($query) < 2) {
            return redirect()->back()->with('error', 'Please enter at least 2 characters to search.');
        }

        $results = [
            'users' => User::where('name', 'like', "%{$query}%")
                ->orWhere('email', 'like', "%{$query}%")
                ->orWhere('phone', 'like', "%{$query}%")
                ->limit(5)
                ->get(),

            'courses' => Course::where('title', 'like', "%{$query}%")
                ->orWhere('excerpt', 'like', "%{$query}%")
                ->limit(5)
                ->get(),

            'orders' => Order::with('user')
                ->where('order_number', 'like', "%{$query}%")
                ->orWhere('transaction_id', 'like', "%{$query}%")
                ->limit(5)
                ->get(),

            'quizzes' => Quiz::where('title', 'like', "%{$query}%")
                ->limit(5)
                ->get(),
        ];

        $totalCount = collect($results)->sum(function ($items) {
            return $items->count();
        });

        return view('admin.search.results', compact('query', 'results', 'totalCount'));
    }
}