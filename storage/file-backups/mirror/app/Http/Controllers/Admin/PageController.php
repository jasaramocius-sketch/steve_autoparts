<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $sortBy = in_array($request->sort_by, ['id', 'title', 'slug', 'status', 'updated_at', 'created_at']) ? $request->sort_by : 'created_at';
        $sortDir = $request->sort_dir === 'asc' ? 'asc' : 'desc';
        $perPage = in_array((int)$request->per_page, [10, 20, 50, 100]) ? (int)$request->per_page : 10;

        if ($request->has('trashed')) {
            $pages = Page::onlyTrashed()->orderBy($sortBy, $sortDir)->paginate($perPage);
        } else {
            $pages = Page::orderBy($sortBy, $sortDir)->paginate($perPage);
        }
        $pages->appends($request->query())->onEachSide(1);

        return view('admin.pages.index', compact('pages', 'sortBy', 'sortDir'));
    }

    public function restore($id)
    {
        Page::onlyTrashed()->findOrFail($id)->restore();
        return redirect()->route('admin.pages.index')->with('success', 'Page restored successfully.');
    }

    public function forceDelete($id)
    {
        Page::onlyTrashed()->findOrFail($id)->forceDelete();
        return redirect()->route('admin.pages.index')->with('success', 'Page permanently deleted.');
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $data = $request->only(['title', 'content', 'meta_title', 'meta_description']);
        $data['slug'] = Str::slug($request->title);
        $data['status'] = $request->boolean('status');

        Page::create($data);

        return redirect()->route('admin.pages.index')->with('success', 'Page created successfully.');
    }

    public function edit($id)
    {
        $page = Page::findOrFail($id);
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, $id)
    {
        $page = Page::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $data = $request->only(['title', 'content', 'meta_title', 'meta_description']);
        $data['status'] = $request->boolean('status');

        $page->update($data);

        return redirect()->route('admin.pages.index')->with('success', 'Page updated successfully.');
    }

    public function toggleStatus($id)
    {
        $page = Page::findOrFail($id);
        $page->status = !$page->status;
        $page->save();
        return back()->with('success', 'Page status updated successfully.');
    }

    public function destroy($id)
    {
        Page::findOrFail($id)->delete();
        return redirect()->route('admin.pages.index')->with('success', 'Page deleted successfully.');
    }
}
