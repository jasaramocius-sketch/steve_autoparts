<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Image;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $sortBy = in_array($request->sort_by, ['id', 'title', 'status', 'created_at']) ? $request->sort_by : 'created_at';
        $sortDir = $request->sort_dir === 'asc' ? 'asc' : 'desc';
        $perPage = in_array((int) $request->per_page, [10, 20, 50, 100]) ? (int) $request->per_page : 10;

        $query = Blog::query();
        if ($search = $request->query('search')) {
            $query->where('title', 'like', "%{$search}%");
        }
        if ($request->has('trashed')) {
            $query->onlyTrashed();
        }
        $blogs = $query->orderBy($sortBy, $sortDir)->paginate($perPage);
        $blogs->appends($request->query())->onEachSide(1);

        return view('admin.blogs.index', compact('blogs', 'sortBy', 'sortDir'));
    }

    public function restore($id)
    {
        Blog::onlyTrashed()->findOrFail($id)->restore();

        return redirect()->route('admin.blogs.index')->with('success', 'Blog restored successfully.');
    }

    public function forceDelete($id)
    {
        $blog = Blog::onlyTrashed()->findOrFail($id);
        $blog->forceDelete();

        return redirect()->route('admin.blogs.index')->with('success', 'Blog permanently deleted.');
    }

    public function create()
    {
        $blogCategories = BlogCategory::with('children')
            ->whereNull('parent_id')
            ->where('status', 'active')
            ->get();
        $allTagsString = Tag::pluck('name')->implode(',');

        return view('admin.blogs.create', compact('blogCategories', 'allTagsString'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'details' => 'nullable|string',
            'status' => 'required|in:published,draft',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image_url' => 'nullable|url',
            'blog_category_id' => 'nullable|exists:blog_categories,id',
        ]);

        $data = $request->only(['title', 'details', 'status', 'blog_category_id']);
        $slug = Str::slug($request->title);
        $counter = 1;
        while (Blog::where('slug', $slug)->exists()) {
            $slug = Str::slug($request->title).'-'.$counter++;
        }
        $data['slug'] = $slug;

        if ($request->filled('image_from_manager')) {
            $data['image'] = 'storage/'.ltrim($request->image_from_manager, '/');
        } elseif ($request->hasFile('image')) {
            $data['image'] = saveImageWithWebp($request->file('image'));
        } elseif ($request->filled('image_url')) {
            try {
                $url = $request->input('image_url');
                $filename = saveImageFromUrlWithWebp($url);
                if ($filename === null) {
                    return back()->withInput()->withErrors(['image_url' => 'Could not download image from the provided URL.']);
                }
                $data['image'] = $filename;
            } catch (\Exception $e) {
                return back()->withInput()->withErrors(['image_url' => 'An error occurred while downloading the image: '.$e->getMessage()]);
            }
        }

        $blog = Blog::create($data);

        $this->syncTags($request, $blog);

        if ($request->filled('image_from_manager')) {
            Image::markUsed($request->image_from_manager, $blog);
        }

        return redirect()->route('admin.blogs.index')->with('success', 'Blog created successfully.');
    }

    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        $blogCategories = BlogCategory::with('children')
            ->whereNull('parent_id')
            ->where('status', 'active')
            ->get();
        $tagsString = $blog->tags()->pluck('name')->join(',');
        $allTagsString = Tag::pluck('name')->implode(',');

        return view('admin.blogs.edit', compact('blog', 'blogCategories', 'tagsString', 'allTagsString'));
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'details' => 'nullable|string',
            'status' => 'required|in:published,draft',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image_url' => 'nullable|url',
            'blog_category_id' => 'nullable|exists:blog_categories,id',
        ]);

        $data = $request->only(['title', 'details', 'status', 'blog_category_id']);

        if ($request->filled('image_from_manager')) {
            $data['image'] = 'storage/'.ltrim($request->image_from_manager, '/');
        } elseif ($request->hasFile('image')) {
            $data['image'] = saveImageWithWebp($request->file('image'));
        } elseif ($request->filled('image_url')) {
            try {
                $url = $request->input('image_url');
                $filename = saveImageFromUrlWithWebp($url);
                if ($filename === null) {
                    return back()->withInput()->withErrors(['image_url' => 'Could not download image from the provided URL.']);
                }
                $data['image'] = $filename;
            } catch (\Exception $e) {
                return back()->withInput()->withErrors(['image_url' => 'An error occurred while downloading the image: '.$e->getMessage()]);
            }
        }

        $blog->update($data);

        $this->syncTags($request, $blog);

        if ($request->filled('image_from_manager')) {
            Image::markUsed($request->image_from_manager, $blog);
        }

        return redirect()->route('admin.blogs.index')->with('success', 'Blog updated successfully.');
    }

    protected function syncTags(Request $request, Blog $blog)
    {
        $names = collect(explode(',', (string) $request->input('tags')))
            ->map(fn ($tag) => trim($tag))
            ->filter()
            ->unique(fn ($tag) => mb_strtolower($tag))
            ->values();

        $tagIds = [];
        foreach ($names as $name) {
            $tag = Tag::whereRaw('LOWER(name) = ?', [mb_strtolower($name)])->first();
            if (! $tag) {
                $tag = Tag::create(['name' => $name]);
            }
            $tagIds[] = $tag->id;
        }

        $blog->tags()->sync($tagIds);
    }

    public function toggleStatus($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->status = $blog->status === 'published' ? 'draft' : 'published';
        $blog->save();

        return back()->with('success', 'Blog status updated successfully.');
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();

        return redirect()->route('admin.blogs.index')->with('success', 'Blog deleted successfully.');
    }
}
