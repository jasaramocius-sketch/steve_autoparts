<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomePageSection;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function index(Request $request)
    {
        $sortBy = in_array($request->sort_by, ['section_name', 'title', 'status', 'order', 'created_at']) ? $request->sort_by : 'order';
        $sortDir = $request->sort_dir === 'asc' ? 'asc' : 'desc';
        $perPage = in_array((int)$request->per_page, [10, 20, 50, 100]) ? (int)$request->per_page : 10;

        $sections = HomePageSection::orderBy($sortBy, $sortDir)->paginate($perPage);
        $sections->appends($request->query())->onEachSide(1);

        return view('admin.home-page.index', compact('sections', 'sortBy', 'sortDir'));
    }

    public function edit($id)
    {
        $section = HomePageSection::findOrFail($id);
        return view('admin.home-page.edit', compact('section'));
    }

    public function update(Request $request, $id)
    {
        $section = HomePageSection::findOrFail($id);

        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'button_text' => 'nullable|string|max:100',
            'button_url' => 'nullable|string|max:255',
            'status' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'tabs' => 'nullable|array',
            'tabs.*.label' => 'nullable|string|max:255',
            'tabs.*.product_ids' => 'nullable|array',
            'tabs.*.product_ids.*' => 'integer|exists:products,id',
        ]);

        $validated['status'] = $request->has('status') ? 1 : 0;

        if ($request->hasFile('image')) {
            $validated['image'] = saveImageWithWebp($request->file('image'), 'assets/images/home');
        } elseif ($request->filled('image_from_manager')) {
            $imgPath = $request->image_from_manager;
            $sourcePath = file_exists(storage_path('app/public/' . $imgPath))
                ? storage_path('app/public/' . $imgPath)
                : (file_exists(public_path($imgPath)) ? public_path($imgPath) : null);
            if ($sourcePath) {
                $filename = time() . '_' . uniqid() . '.' . pathinfo($imgPath, PATHINFO_EXTENSION);
                $destDir = public_path('assets/images/home');
                if (!is_dir($destDir)) mkdir($destDir, 0755, true);
                copy($sourcePath, $destDir . '/' . $filename);
                $validated['image'] = $filename;
            }
        }

        if ($request->has('tabs')) {
            $tabs = $request->input('tabs');
            // Clean up empty tabs
            $tabs = array_values(array_filter($tabs, fn($t) => !empty(trim($t['label'] ?? ''))));
            $validated['extra_data'] = ['tabs' => $tabs];
        }

        $existing = $section->extra_data ?? [];

        if ($request->filled('brands_limit')) {
            $existing['brands_limit'] = $request->brands_limit;
        }

        if ($request->has('brand_ids')) {
            $existing['brand_ids'] = array_values(array_filter(array_map('intval', (array) $request->input('brand_ids', []))));
        }

        if ($request->filled('posts_count')) {
            $existing['posts_count'] = (int) $request->posts_count;
        }

        if ($request->filled('countdown')) {
            $existing['countdown'] = $request->countdown;
        }

        if ($section->section_name === 'offers' && $request->has('banners')) {
            $savedBanners = [];
            foreach ((array) $request->input('banners') as $row) {
                if (!is_array($row)) {
                    continue;
                }

                $imageFromManager = $row['image_from_manager'] ?? null;
                $existingImage = $row['existing_image'] ?? null;
                $newImage = null;

                if ($imageFromManager) {
                    // Check both storage/app/public and public_path (for images stored in either location)
                    $sourcePath = null;
                    if (file_exists(storage_path('app/public/' . $imageFromManager))) {
                        $sourcePath = storage_path('app/public/' . $imageFromManager);
                    } elseif (file_exists(public_path($imageFromManager))) {
                        $sourcePath = public_path($imageFromManager);
                    }

                    if ($sourcePath) {
                        $filename = time() . '_' . uniqid() . '.' . pathinfo($imageFromManager, PATHINFO_EXTENSION);
                        $destDir = public_path('assets/images/home');
                        if (!is_dir($destDir)) {
                            mkdir($destDir, 0755, true);
                        }
                        copy($sourcePath, $destDir . '/' . $filename);
                        $newImage = $filename;
                    }
                }

                if (!$newImage && $existingImage) {
                    $newImage = $existingImage;
                }

                $savedBanners[] = [
                    'image' => $newImage,
                    'title' => $row['title'] ?? '',
                    'subtitle' => $row['subtitle'] ?? '',
                    'button_text' => $row['button_text'] ?? '',
                    'button_url' => $row['button_url'] ?? '',
                ];
            }

            $savedBanners = array_values(array_filter($savedBanners, function ($b) {
                return $b['image'] || $b['title'] || $b['subtitle'] || $b['button_text'] || $b['button_url'];
            }));

            $existing['banners'] = $savedBanners;
        }

        $extraChanged = $request->filled('brands_limit')
            || $request->has('brand_ids')
            || $request->filled('posts_count')
            || $request->filled('countdown')
            || ($section->section_name === 'offers' && $request->has('banners'));

        if ($extraChanged) {
            $validated['extra_data'] = $existing;
        }

        $section->update($validated);

        return redirect()->route('admin.home-page.index')
            ->with('success', 'Section updated successfully!');
    }

    public function toggleStatus($id)
    {
        $section = HomePageSection::findOrFail($id);
        $section->status = !$section->status;
        $section->save();

        return back()->with('success', 'Section status updated successfully.');
    }

    public function reorder(Request $request)
    {
        $order = $request->get('order', []);
        
        foreach ($order as $position => $id) {
            HomePageSection::where('id', $id)->update(['order' => $position]);
        }

        return response()->json(['success' => true]);
    }
}
