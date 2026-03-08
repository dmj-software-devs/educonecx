<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class BlogController extends Controller
{
    /**
     * Display blog listing
     */
    public function index(Request $request)
    {
        // Start query for published posts
        $query = Blog::published()->orderBy('published_at', 'desc');
        
        // Search functionality
        if ($request->has('s') && !empty($request->s)) {
            $query->search($request->s);
        }

        // Category filter
        if ($request->has('category') && !empty($request->category)) {
            $query->byCategory($request->category);
        }

        // Pagination (6 posts per page for infinite scroll)
        $perPage = 6;
        $posts = $query->paginate($perPage);
        
        // Get featured post (only on first page)
        $featuredPost = null;
        if ($request->page <= 1 && !$request->has('s') && !$request->has('category')) {
            $featuredPost = Blog::published()
                ->featured()
                ->orderBy('published_at', 'desc')
                ->first();
        }

        // For AJAX requests (infinite scroll)
        if ($request->ajax()) {
            $html = view('partials.blog-posts', ['posts' => $posts])->render();
            return response()->json([
                'html' => $html,
                'next_page' => $posts->hasMorePages() ? $posts->currentPage() + 1 : null,
                'has_more' => $posts->hasMorePages()
            ]);
        }

        return view('blog', [
            'posts' => $posts,
            'featuredPost' => $featuredPost,
            'searchTerm' => $request->input('s', '')
        ]);
    }

    /**
     * Display single blog post
     */
    /**
 * Display single blog post
 */
public function show($slug)
{
    $post = Blog::published()->where('slug', $slug)->firstOrFail();
    
    // Increment view count
    $post->incrementViews();

    // Get related posts (same category, excluding current)
    $relatedPosts = Blog::published()
        ->where('id', '!=', $post->id)
        ->where('category', $post->category)
        ->orderBy('published_at', 'desc')
        ->limit(3)
        ->get();

    return view('blog-single', [
        'post' => $post,
        'relatedPosts' => $relatedPosts
    ]);
}
}