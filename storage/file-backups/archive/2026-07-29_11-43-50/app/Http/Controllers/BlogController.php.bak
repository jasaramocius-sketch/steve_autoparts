<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Category;
use App\Models\BlogCategory;


class BlogController extends Controller{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $blogsQuery = Blog::with('category')->where('status', 'published');
        if ($search) {
            $blogsQuery->where('title', 'like', "%{$search}%");
        }
        $blogs = $blogsQuery->latest()->paginate(6)->onEachSide(2);
        $recentBlogs = Blog::where('status', 'published')->latest()->take(5)->get();
        $categories = BlogCategory::withCount(['blogs' => fn($q) => $q->where('status', 'published')])
            ->with(['children' => fn($q) => $q->withCount(['blogs' => fn($q2) => $q2->where('status', 'published')])])
            ->whereNull('parent_id')
            ->where('status', 'active')
            ->get();

        return view('blog.index', compact('blogs', 'recentBlogs', 'categories', 'search'));
    }
    public function show($slug)
    {
        $blog = Blog::with('category')->where('slug', $slug)->where('status', 'published')->firstOrFail();
        $previous = Blog::where('status', 'published')->where('id', '<', $blog->id)->orderBy('id', 'desc')->first();
        $next = Blog::where('status', 'published')->where('id', '>', $blog->id)->orderBy('id', 'asc')->first();
        $recentBlogs = Blog::where('status', 'published')->latest()->take(5)->get();
        $categories = BlogCategory::withCount(['blogs' => fn($q) => $q->where('status', 'published')])
            ->with(['children' => fn($q) => $q->withCount(['blogs' => fn($q2) => $q2->where('status', 'published')])])
            ->whereNull('parent_id')
            ->where('status', 'active')
            ->get();
        return view('blog.show', compact('blog', 'previous', 'next', 'recentBlogs', 'categories'));
    }
    public function category($slug)
    {
        $category = BlogCategory::where('slug', $slug)->firstOrFail();
        $search = request()->input('search');
        $sort = in_array(request()->input('sort'), ['latest', 'oldest']) ? request()->input('sort') : 'latest';
        $blogsQuery = Blog::with('category')->where('blog_category_id', $category->id)->where('status', 'published');
        if ($search) {
            $blogsQuery->where('title', 'like', "%{$search}%");
        }
        if ($sort === 'oldest') {
            $blogsQuery->oldest();
        } else {
            $blogsQuery->latest();
        }
        $blogs = $blogsQuery->paginate(6)->onEachSide(2)->appends(request()->query());
        $recentBlogs = Blog::where('status', 'published')->latest()->take(5)->get();
        $categories = BlogCategory::withCount(['blogs' => fn($q) => $q->where('status', 'published')])->with('children')
            ->whereNull('parent_id')
            ->where('status', 'active')
            ->get();
        return view('blog.index', compact('blogs', 'recentBlogs', 'categories', 'category', 'search', 'sort'));
    }

}