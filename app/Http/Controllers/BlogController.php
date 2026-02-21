<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class BlogController extends Controller
{
    /**
     * Sample blog post data - In a real application, this would come from a database
     */
    private function getPosts()
    {
        return [
            [
                'id' => 1,
                'title' => 'Creating a Unified Learning Ecosystem with EDUCONECX',
                'slug' => 'creating-a-unified-learning-ecosystem-with-educonecx',
                'excerpt' => 'Managing multiple platforms for learning, guidance, and digital services can be confusing and inefficient. Discover how EDUCONECX unifies all three under a single, lightweight, mobile-friendly ecosystem — making learning, self-discovery, and digital solutions accessible to everyone.',
                'content' => 'Full content here...',
                'featured_image' => 'https://via.placeholder.com/800x437',
                'category' => 'Technology',
                'category_slug' => 'technology',
                'published_at' => '2025-08-29',
                'author' => 'EDUCONECX Team',
                'author_avatar' => 'ET',
            ],
            [
                'id' => 2,
                'title' => 'Mobile-First Design and Lightweight Platforms: Why They Matter',
                'slug' => 'mobile-first-design-and-lightweight-platforms-why-they-matter',
                'excerpt' => 'Learn why mobile-first design, offline caching, and lightweight platforms are essential for modern users. Discover how EDUCONECX ensures fast, accessible, and practical solutions for learners and professionals worldwide.',
                'content' => 'Full content here...',
                'featured_image' => 'https://via.placeholder.com/800x448',
                'category' => 'Web Development',
                'category_slug' => 'web-development',
                'published_at' => '2025-08-29',
                'author' => 'EDUCONECX Team',
                'author_avatar' => 'ET',
            ],
            [
                'id' => 3,
                'title' => 'NEO ED-TECH: Transforming Digital Services for Businesses',
                'slug' => 'neo-ed-tech-transforming-digital-services-for-businesses',
                'excerpt' => 'NEO ED-TECH provides professional services in web design, e-commerce, AI, and digital marketing. Learn how a modern, flexible, and integrated approach can help your business grow efficiently in a competitive digital landscape.',
                'content' => 'Full content here...',
                'featured_image' => 'https://via.placeholder.com/800x534',
                'category' => 'Digital Services',
                'category_slug' => 'digital-services',
                'published_at' => '2025-08-29',
                'author' => 'EDUCONECX Team',
                'author_avatar' => 'ET',
            ],
            [
                'id' => 4,
                'title' => 'The Power of Lifelong Learning in the Digital Age',
                'slug' => 'the-power-of-lifelong-learning-in-the-digital-age',
                'excerpt' => 'In a rapidly changing world, lifelong learning has become essential for personal and professional growth. Discover why continuous education in English, finance, business, and technology is the key to thriving in the digital age — and how EDUCONECX Academy is making it accessible for everyone.',
                'content' => 'Full content here...',
                'featured_image' => 'https://via.placeholder.com/800x548',
                'category' => 'Education',
                'category_slug' => 'education',
                'published_at' => '2025-08-29',
                'author' => 'EDUCONECX Team',
                'author_avatar' => 'ET',
            ],
        ];
    }

    /**
     * Display blog listing
     */
    public function index(Request $request)
    {
        $posts = $this->getPosts();
        
        // Search functionality
        if ($request->has('s') && !empty($request->s)) {
            $searchTerm = strtolower($request->s);
            $posts = array_filter($posts, function ($post) use ($searchTerm) {
                return strpos(strtolower($post['title']), $searchTerm) !== false ||
                       strpos(strtolower($post['excerpt']), $searchTerm) !== false ||
                       strpos(strtolower($post['category']), $searchTerm) !== false;
            });
        }

        // Sort by published date (newest first)
        usort($posts, function ($a, $b) {
            return strtotime($b['published_at']) - strtotime($a['published_at']);
        });

        // Pagination (6 posts per page for infinite scroll)
        $perPage = 6;
        $currentPage = $request->input('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        
        $paginatedPosts = new LengthAwarePaginator(
            array_slice($posts, $offset, $perPage),
            count($posts),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        // For AJAX requests (infinite scroll)
        if ($request->ajax()) {
            $html = view('partials.blog-posts', ['posts' => $paginatedPosts])->render();
            return response()->json([
                'html' => $html,
                'next_page' => $paginatedPosts->hasMorePages() ? $currentPage + 1 : null,
                'has_more' => $paginatedPosts->hasMorePages()
            ]);
        }

        return view('blog', [
            'posts' => $paginatedPosts,
            'searchTerm' => $request->input('s', '')
        ]);
    }

    /**
     * Display single blog post
     */
    public function show($slug)
    {
        $posts = $this->getPosts();
        $post = collect($posts)->firstWhere('slug', $slug);
        
        if (!$post) {
            abort(404);
        }

        // Get related posts (same category, excluding current)
        $relatedPosts = array_filter($posts, function ($p) use ($post) {
            return $p['id'] !== $post['id'] && $p['category'] === $post['category'];
        });

        return view('blog-single', [
            'post' => $post,
            'relatedPosts' => array_slice($relatedPosts, 0, 3)
        ]);
    }
}