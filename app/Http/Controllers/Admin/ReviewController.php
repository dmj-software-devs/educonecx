<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of reviews.
     */
    public function index(Request $request)
    {
        $query = Review::with(['user', 'course']);

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->has('rating') && $request->rating !== 'all') {
            $query->where('rating', $request->rating);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('course', function($q) use ($search) {
                      $q->where('title', 'like', "%{$search}%");
                  });
            });
        }

        $reviews = $query->latest()->paginate(15);

        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Display the specified review.
     */
    public function show(Review $review)
    {
        $review->load('user', 'course');
        return view('admin.reviews.show', compact('review'));
    }

    /**
     * Approve the specified review.
     */
    public function approve(Review $review)
    {
        $review->update(['status' => 'approved']);

        // Update course average rating
        $course = $review->course;
        $course->average_rating = Review::where('course_id', $course->id)
            ->where('status', 'approved')
            ->avg('rating');
        $course->save();

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review approved successfully.');
    }

    /**
     * Reject the specified review.
     */
    public function reject(Review $review)
    {
        $review->update(['status' => 'rejected']);

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review rejected successfully.');
    }

    /**
     * Remove the specified review.
     */
    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review deleted successfully.');
    }
}