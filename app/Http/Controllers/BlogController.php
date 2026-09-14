<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Page;
use App\Models\Tag;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $blogsQuery = Blog::with('category', 'tags')->where('status', 'published');
        if ($search) {
            $blogsQuery->where('title', 'like', "%{$search}%");
        }
        $blogs = $blogsQuery->latest()->paginate(6)->onEachSide(2);
        $recentBlogs = Blog::where('status', 'published')->latest()->take(5)->get();
        $categories = BlogCategory::withCount(['blogs' => fn ($q) => $q->where('status', 'published')])
            ->with(['children' => fn ($q) => $q->withCount(['blogs' => fn ($q2) => $q2->where('status', 'published')])])
            ->whereNull('parent_id')
            ->where('status', 'active')
            ->get();
        $tags = Tag::withCount(['blogs' => fn ($q) => $q->where('status', 'published')])
            ->having('blogs_count', '>', 0)
            ->orderByDesc('blogs_count')
            ->take(15)
            ->get();
        $page = Page::where('slug', 'blog')->where('status', true)->first();

        return view('blog.index', compact('blogs', 'recentBlogs', 'categories', 'tags', 'search', 'page'));
    }

    public function show($slug)
    {
        $blog = Blog::with('category', 'tags')->where('slug', $slug)->where('status', 'published')->firstOrFail();
        $previous = Blog::where('status', 'published')->where('id', '<', $blog->id)->orderBy('id', 'desc')->first();
        $next = Blog::where('status', 'published')->where('id', '>', $blog->id)->orderBy('id', 'asc')->first();
        $recentBlogs = Blog::where('status', 'published')->latest()->take(5)->get();
        $categories = BlogCategory::withCount(['blogs' => fn ($q) => $q->where('status', 'published')])
            ->with(['children' => fn ($q) => $q->withCount(['blogs' => fn ($q2) => $q2->where('status', 'published')])])
            ->whereNull('parent_id')
            ->where('status', 'active')
            ->get();
        $tags = Tag::withCount(['blogs' => fn ($q) => $q->where('status', 'published')])
            ->having('blogs_count', '>', 0)
            ->orderByDesc('blogs_count')
            ->take(15)
            ->get();

        return view('blog.show', compact('blog', 'previous', 'next', 'recentBlogs', 'categories', 'tags'));
    }

    public function category($slug)
    {
        $category = BlogCategory::where('slug', $slug)->firstOrFail();
        $search = request()->input('search');
        $sort = in_array(request()->input('sort'), ['latest', 'oldest']) ? request()->input('sort') : 'latest';
        $blogsQuery = Blog::with('category', 'tags')->where('blog_category_id', $category->id)->where('status', 'published');
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
        $categories = BlogCategory::withCount(['blogs' => fn ($q) => $q->where('status', 'published')])->with('children')
            ->whereNull('parent_id')
            ->where('status', 'active')
            ->get();
        $tags = Tag::withCount(['blogs' => fn ($q) => $q->where('status', 'published')])
            ->having('blogs_count', '>', 0)
            ->orderByDesc('blogs_count')
            ->take(15)
            ->get();
        $page = Page::where('slug', 'blog')->where('status', true)->first();

        return view('blog.index', compact('blogs', 'recentBlogs', 'categories', 'tags', 'category', 'search', 'sort', 'page'));
    }

    public function tag($slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();
        $search = request()->input('search');
        $sort = in_array(request()->input('sort'), ['latest', 'oldest']) ? request()->input('sort') : 'latest';
        $blogsQuery = Blog::with('category', 'tags')->whereHas('tags', fn ($q) => $q->where('tags.id', $tag->id))->where('status', 'published');
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
        $categories = BlogCategory::withCount(['blogs' => fn ($q) => $q->where('status', 'published')])->with('children')
            ->whereNull('parent_id')
            ->where('status', 'active')
            ->get();
        $tags = Tag::withCount(['blogs' => fn ($q) => $q->where('status', 'published')])
            ->having('blogs_count', '>', 0)
            ->orderByDesc('blogs_count')
            ->take(15)
            ->get();
        $page = Page::where('slug', 'blog')->where('status', true)->first();

        return view('blog.index', compact('blogs', 'recentBlogs', 'categories', 'tags', 'tag', 'search', 'sort', 'page'));
    }
}
