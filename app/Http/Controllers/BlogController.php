<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Category;
use App\Models\BlogCategory;


class BlogController extends Controller{
    public function index()
    {
        $blogs = Blog::with('category')->where('status', 'published')->latest()->paginate(6);
        $recentBlogs = Blog::where('status', 'published')->latest()->take(5)->get();
        $categories = BlogCategory::withCount(['blogs' => fn($q) => $q->where('status', 'published')])
            ->with(['children' => fn($q) => $q->withCount(['blogs' => fn($q2) => $q2->where('status', 'published')])])
            ->whereNull('parent_id')
            ->where('status', 'active')
            ->get();

        return view('blog.index', compact('blogs', 'recentBlogs', 'categories'));
    }
    public function show($slug)
    {
        $blog = Blog::with('category')->where('slug', $slug)->where('status', 'published')->firstOrFail();
        $previous = Blog::where('status', 'published')->where('id', '<', $blog->id)->orderBy('id', 'desc')->first();
        $next = Blog::where('status', 'published')->where('id', '>', $blog->id)->orderBy('id', 'asc')->first();
        return view('blog.show', compact('blog', 'previous', 'next'));
    }
    public function category($slug)
    {
        $category = BlogCategory::where('slug', $slug)->firstOrFail();
        $blogs = Blog::with('category')->where('blog_category_id', $category->id)->where('status', 'published')->latest()->paginate(6);
        $recentBlogs = Blog::where('status', 'published')->latest()->take(5)->get();
        $categories = BlogCategory::withCount(['blogs' => fn($q) => $q->where('status', 'published')])->with('children')
            ->whereNull('parent_id')
            ->where('status', 'active')
            ->get();
        return view('blog.index', compact('blogs', 'recentBlogs', 'categories'));
    }

}