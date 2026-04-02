<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Blog::where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('blog.index', [
            'posts' => $posts
        ]);
    }

    public function show($slug)
    {
        $post = Blog::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // Get related posts
        $related = Blog::where('is_published', true)
            ->where('slug', '!=', $slug)
            ->limit(3)
            ->get();

        return view('blog.show', [
            'post' => $post,
            'related' => $related
        ]);
    }
}
