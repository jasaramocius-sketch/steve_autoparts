<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Seller;
use App\Models\Image;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $sortBy = $request->query('sort_by', 'created_at');
        $sortDir = $request->query('sort_dir', 'desc');

        if (!in_array($sortBy, ['id', 'name', 'price', 'old_price', 'stock', 'category_id', 'featured', 'status', 'created_at'])) {
            $sortBy = 'created_at';
        }
        $sortDir = $sortDir === 'asc' ? 'asc' : 'desc';

        $perPage = $request->query('per_page', 10);
        if ($perPage === 'all') {
            $perPage = Product::count() ?: 10;
        } else {
            $perPage = (int) $perPage;
            if (!in_array($perPage, [10, 20, 50, 100])) {
                $perPage = 10;
            }
        }

        if ($request->has('trashed')) {
            $query = Product::onlyTrashed()->with('category');
        } else {
            $query = Product::with('category');
        }

        if ($search = $request->query('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        $products = $query->orderBy($sortBy, $sortDir)->paginate($perPage);

        $products->appends($request->query())->onEachSide(1);
        return view('admin.products.index', compact('products', 'sortBy', 'sortDir'));
    }

    public function restore($id)
    {
        Product::onlyTrashed()->findOrFail($id)->restore();
        return redirect()->route('admin.products.index')->with('success', 'Product restored successfully!');
    }

    public function forceDelete($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->forceDelete();
        return redirect()->route('admin.products.index')->with('success', 'Product permanently deleted!');
    }

    public function show($slug)
    {
        $product = Product::with(['galleryImages', 'category.parent'])->where('slug', $slug)->where('status', true)->firstOrFail();
        $related = Product::with('category')->where('status', true)->where('id', '!=', $product->id)->take(4)->get();

        $activeCategoryUrls = [];
        if ($product->category) {
            $activeCategoryUrls[] = url('/category/' . $product->category->slug);
            if ($product->category->parent) {
                $activeCategoryUrls[] = url('/category/' . $product->category->parent->slug);
            }
        }
        view()->share('activeCategoryUrls', $activeCategoryUrls);

        $wishedProductIds = [];
        if (session('user_profile.id')) {
            $wishedProductIds = Wishlist::where('user_id', session('user_profile.id'))
                ->pluck('product_id')
                ->toArray();
        } else {
            $wishedProductIds = session('guest_wishlist', []);
        }
        $inWishlist = in_array($product->id, $wishedProductIds);

        $hasPurchased = \App\Http\Controllers\ReviewController::hasPurchased(auth()->id(), $product->id);

        return view('product.show', compact('product', 'related', 'inWishlist', 'wishedProductIds', 'hasPurchased'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $brands = Brand::where('status', true)->orderBy('name')->get();
        $sellers = Seller::orderBy('name')->get();
        return view('admin.products.create', compact('categories', 'brands', 'sellers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'seller_id' => 'nullable|exists:sellers,id',
            'year' => 'nullable|integer|min:1900|max:2026',
            'make' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'tab_label_1' => 'nullable|string|max:100',
            'tab_label_2' => 'nullable|string|max:100',
            'tab_label_3' => 'nullable|string|max:100',
            'policy_text' => 'nullable|string',
            'features' => 'nullable|string',
            'reviews_data' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $data = $request->only(['name', 'description', 'price', 'old_price', 'category_id', 'brand_id', 'seller_id', 'year', 'make', 'model', 'badge', 'product_type', 'stock', 'status', 'tab_label_1', 'tab_label_2', 'tab_label_3', 'policy_text']);
        $data['featured'] = $request->boolean('featured');
        $data['added_by'] = 'admin';
        $data['features'] = $request->filled('features') ? array_filter(explode("\n", str_replace("\r", "", $request->features))) : null;
        $data['reviews_data'] = $request->filled('reviews_data') ? json_decode($request->reviews_data, true) : null;
        $data['slug'] = Str::slug($request->name) . '-' . time();

        if ($request->filled('image_from_manager')) {
            $data['image'] = 'storage/' . ltrim($request->image_from_manager, '/');
        } elseif ($request->hasFile('image')) {
            $data['image'] = saveImageWithWebp($request->file('image'));
        }

        $product = Product::create($data);

        if ($request->filled('image_from_manager')) {
            Image::markUsed($request->image_from_manager);
        }

        $this->attachGalleryImagesFromManager($product, $request->gallery_images_from_manager);

        $this->attachGalleryUploads($product, $request->file('gallery_images'));

        if ($product->category_id) {
            $userIds = \App\Models\Wishlist::whereHas('product', fn($q) => $q->where('category_id', $product->category_id))
                ->where('user_id', '!=', auth()->id())
                ->pluck('user_id')
                ->unique()
                ->toArray();
            $category = \App\Models\Category::find($product->category_id);
            foreach ($userIds as $uid) {
                $user = \App\Models\User::find($uid);
                if ($user) {
                    \App\Helpers\NotificationHelper::newProductInCategory($user, $product, $category);
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }

    public function details($id)
    {
        $product = Product::with(['category', 'brand', 'galleryImages'])->findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::orderBy('name')->get();
        $brands = Brand::where('status', true)->orderBy('name')->get();
        $sellers = Seller::orderBy('name')->get();
        return view('admin.products.edit', compact('product', 'categories', 'brands', 'sellers'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'seller_id' => 'nullable|exists:sellers,id',
            'year' => 'nullable|integer|min:1900|max:2026',
            'make' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'tab_label_1' => 'nullable|string|max:100',
            'tab_label_2' => 'nullable|string|max:100',
            'tab_label_3' => 'nullable|string|max:100',
            'policy_text' => 'nullable|string',
            'features' => 'nullable|string',
            'reviews_data' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $data = $request->only(['name', 'description', 'price', 'old_price', 'category_id', 'brand_id', 'seller_id', 'year', 'make', 'model', 'badge', 'product_type', 'stock', 'status', 'tab_label_1', 'tab_label_2', 'tab_label_3', 'policy_text']);
        $data['featured'] = $request->boolean('featured');
        $data['features'] = $request->filled('features') ? array_filter(explode("\n", str_replace("\r", "", $request->features))) : null;
        $data['reviews_data'] = $request->filled('reviews_data') ? json_decode($request->reviews_data, true) : null;

        if ($request->filled('image_from_manager')) {
            $data['image'] = 'storage/' . ltrim($request->image_from_manager, '/');
        } elseif ($request->hasFile('image')) {
            $data['image'] = saveImageWithWebp($request->file('image'));
        }

        $product->update($data);

        if ($request->filled('image_from_manager')) {
            Image::markUsed($request->image_from_manager);
        }

        if ($request->has('delete_gallery_ids')) {
            $this->detachGalleryImages($product, $request->delete_gallery_ids);
        }

        $this->attachGalleryUploads($product, $request->file('gallery_images'));

        $this->attachGalleryImagesFromManager($product, $request->gallery_images_from_manager);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    private function attachGalleryUploads(Product $product, $files): void
    {
        if (!$files) {
            return;
        }

        foreach ($files as $file) {
            if ($file->isValid()) {
                $image = Image::storeFromUpload($file, 'products/gallery', $product);
                $product->galleryImages()->attach($image->id);
            }
        }
    }

    private function detachGalleryImages(Product $product, array $imageIds): void
    {
        $product->galleryImages()->detach($imageIds);

        foreach ($imageIds as $imageId) {
            $image = Image::find($imageId);
            if (!$image) {
                continue;
            }

            $hasOtherOwners = DB::table('image_product')->where('image_id', $imageId)->exists();

            if (
                !$hasOtherOwners
                && $image->attachable_type === Product::class
                && (int) $image->attachable_id === (int) $product->id
            ) {
                $image->attachable_type = null;
                $image->attachable_id = null;
                $image->is_unused = true;
                $image->save();
            }
        }
    }

    private function attachGalleryImagesFromManager(Product $product, ?string $galleryImagesFromManager): void
    {
        if (!$galleryImagesFromManager) {
            return;
        }

        $paths = json_decode($galleryImagesFromManager, true);
        if (!is_array($paths)) {
            $paths = [$galleryImagesFromManager];
        }

        foreach ($paths as $imgPath) {
            if (!$imgPath) {
                continue;
            }

            try {
                Image::attachToProduct($imgPath, $product);
            } catch (\Throwable $e) {
                \Log::warning('Unable to attach gallery image to product', [
                    'product_id' => $product->id,
                    'path' => $imgPath,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }

    public function toggleStatus($id)
    {
        $product = Product::findOrFail($id);
        $product->status = !$product->status;
        $product->save();
        return back()->with('success', 'Product status updated successfully.');
    }

    public function toggleFeatured($id)
    {
        $product = Product::findOrFail($id);
        $product->featured = !$product->featured;
        $product->save();
        return back()->with('success', 'Product featured status updated successfully.');
    }

    public function contactSeller(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20|regex:/^[0-9+\-\s()]*$/',
            'message' => 'required|string|max:2000',
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::find($request->product_id);

        \App\Models\Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => 'Seller Contact: ' . ($product->name ?? 'Product Inquiry'),
            'message' => "Product: {$product->name}\nProduct URL: " . route('product', $product->slug) . "\n\n{$request->message}",
            'user_id' => auth()->id(),
            'product_id' => $product->id,
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Your message has been sent to the seller.']);
        }

        return back()->with('success', 'Your message has been sent to the seller.');
    }

    public function importForm()
    {
        return view('admin.products.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:5120',
        ]);

        $file = $request->file('csv_file');
        $handle = fopen($file->getRealPath(), 'r');
        $header = fgetcsv($handle, 0, ',');

        $header = array_map('trim', $header);
        $expected = ['id', 'name', 'price', 'old_price', 'category', 'stock', 'description', 'badge', 'product_type', 'status', 'featured', 'image', 'brand', 'year', 'make', 'model', 'gallery_images'];

        $colMap = [];
        foreach ($header as $i => $col) {
            $colLower = strtolower(preg_replace('/[^a-zA-Z0-9_]/', '', $col));
            if (in_array($colLower, $expected)) {
                $colMap[$i] = $colLower;
            }
        }

        if (!isset($colMap[array_search('name', $colMap)]) || !isset($colMap[array_search('price', $colMap)])) {
            fclose($handle);
            return back()->with('error', 'CSV must contain at least "name" and "price" columns.');
        }

        $categories = Category::all()->keyBy(function ($cat) {
            return strtolower(trim($cat->name));
        });

        $brands = Brand::all()->keyBy(function ($brand) {
            return strtolower(trim($brand->name));
        });

        $imported = 0;
        $categoriesCreated = 0;
        $brandsCreated = 0;
        $galleryImported = 0;
        $errors = [];
        $rowNum = 1;

        while (($row = fgetcsv($handle, 0, ',')) !== false) {
            $rowNum++;
            $row = array_map('trim', $row);
            $data = [];

            foreach ($colMap as $colIdx => $colName) {
                $data[$colName] = $row[$colIdx] ?? '';
            }

            if (empty($data['name'])) {
                $errors[] = "Row {$rowNum}: name is required.";
                continue;
            }
            if (!is_numeric($data['price']) || $data['price'] < 0) {
                $errors[] = "Row {$rowNum}: price must be a positive number.";
                continue;
            }

            $existingProduct = null;
            if (!empty($data['id']) && is_numeric($data['id'])) {
                $existingProduct = Product::find((int)$data['id']);
            }

            $categoryId = null;
            if (!empty($data['category'])) {
                $catKey = strtolower(trim($data['category']));
                if (isset($categories[$catKey])) {
                    $categoryId = $categories[$catKey]->id;
                } else {
                    $newCat = Category::create([
                        'name' => trim($data['category']),
                        'slug' => Str::slug(trim($data['category'])),
                        'status' => true,
                    ]);
                    $categories[$catKey] = $newCat;
                    $categoryId = $newCat->id;
                    $categoriesCreated++;
                }
            }

            $brandId = null;
            if (!empty($data['brand'])) {
                $brandKey = strtolower(trim($data['brand']));
                if (isset($brands[$brandKey])) {
                    $brandId = $brands[$brandKey]->id;
                } else {
                    $newBrand = Brand::create([
                        'name' => trim($data['brand']),
                        'slug' => Str::slug(trim($data['brand'])),
                        'status' => true,
                    ]);
                    $brands[$brandKey] = $newBrand;
                    $brandId = $newBrand->id;
                    $brandsCreated++;
                }
            }

            $insertData = [
                'name' => $data['name'],
                'price' => $data['price'],
                'old_price' => (!empty($data['old_price']) && is_numeric($data['old_price'])) ? $data['old_price'] : null,
                'category_id' => $categoryId,
                'brand_id' => $brandId,
                'year' => (!empty($data['year']) && is_numeric($data['year'])) ? (int)$data['year'] : null,
                'make' => $data['make'] ?? null,
                'model' => $data['model'] ?? null,
                'stock' => (!empty($data['stock']) && is_numeric($data['stock'])) ? (int)$data['stock'] : 0,
                'description' => $data['description'] ?? '',
                'badge' => $data['badge'] ?? null,
                'product_type' => in_array($data['product_type'] ?? '', ['physical', 'digital']) ? $data['product_type'] : 'none',
                'status' => in_array(($data['status'] ?? ''), ['1', 'yes', 'active', 'true'], true) ? true : false,
                'featured' => in_array(($data['featured'] ?? ''), ['1', 'yes', 'active', 'true'], true) ? true : false,
            ];

            if ($existingProduct) {
                $insertData['slug'] = $existingProduct->slug;
            } else {
                $insertData['slug'] = Str::slug($data['name']) . '-' . time() . '-' . $imported;
                $insertData['added_by'] = 'admin';
            }

            if (!empty($data['image']) && filter_var($data['image'], FILTER_VALIDATE_URL)) {
                $saved = saveImageFromUrlWithWebp($data['image']);
                if ($saved) {
                    $insertData['image'] = $saved;
                } else {
                    $errors[] = "Row {$rowNum}: image URL could not be downloaded or was not a valid image.";
                }
            }

            try {
                if ($existingProduct) {
                    $existingProduct->update($insertData);
                    $product = $existingProduct;
                    $action = 'updated';
                } else {
                    $product = Product::create($insertData);
                    $action = 'created';
                }
                $imported++;

                if (!empty($data['gallery_images'])) {
                    $galleryUrls = array_filter(array_map('trim', explode('|', $data['gallery_images'])));
                    $subdir = 'uploads/' . now()->format('Y/m');
                    $destDir = storage_path('app/public/' . $subdir);
                    if (!is_dir($destDir)) mkdir($destDir, 0775, true);
                    foreach ($galleryUrls as $imgUrl) {
                        if (!filter_var($imgUrl, FILTER_VALIDATE_URL)) continue;
                        $response = \Illuminate\Support\Facades\Http::get($imgUrl);
                        if ($response->failed()) continue;
                        $contentType = $response->header('Content-Type');
                        if (!str_contains($contentType, 'image/')) continue;
                        $ext = 'jpg';
                        if (str_contains($contentType, 'png')) $ext = 'png';
                        elseif (str_contains($contentType, 'webp')) $ext = 'webp';
                        elseif (str_contains($contentType, 'gif')) $ext = 'gif';
                        $filename = time() . '_' . uniqid() . '.' . $ext;
                        file_put_contents($destDir . '/' . $filename, $response->body());
                        Image::create([
                            'original_name' => $filename,
                            'filename' => $filename,
                            'path' => $subdir . '/' . $filename,
                            'url' => 'storage/' . $subdir . '/' . $filename,
                            'mime_type' => $contentType,
                            'size' => filesize($destDir . '/' . $filename),
                            'width' => null,
                            'height' => null,
                            'is_unused' => false,
                            'attachable_type' => Product::class,
                            'attachable_id' => $product->id,
                        ]);
                        $galleryImported++;
                    }
                }
            } catch (\Exception $e) {
                $errors[] = "Row {$rowNum}: " . $e->getMessage();
            }
        }

        fclose($handle);

        $message = "Imported {$imported} product(s) successfully.";
        $extras = [];
        if ($categoriesCreated > 0) {
            $extras[] = "{$categoriesCreated} new category(ies) created";
        }
        if ($brandsCreated > 0) {
            $extras[] = "{$brandsCreated} new brand(s) created";
        }
        if ($galleryImported > 0) {
            $extras[] = "{$galleryImported} gallery image(s) imported";
        }
        if (!empty($extras)) {
            $message .= ' (' . implode(', ', $extras) . ')';
        }
        if (!empty($errors)) {
            $message .= ' ' . count($errors) . ' error(s): ' . implode('; ', array_slice($errors, 0, 10));
            if (count($errors) > 10) {
                $message .= ' (and ' . (count($errors) - 10) . ' more)';
            }
        }

        return redirect()->route('admin.products.index')->with('success', $message);
    }

    public function downloadSampleCsv()
    {
        $headers = ['id', 'name', 'price', 'old_price', 'category', 'stock', 'description', 'badge', 'product_type', 'status', 'featured', 'image', 'brand', 'year', 'make', 'model', 'gallery_images'];
        $rows = [
            ['', 'Brake Pads Set', '49.99', '69.99', 'Brakes', '100', 'High quality ceramic brake pads', 'New', 'physical', '1', '1', 'https://example.com/images/brake-pads.jpg', 'Duralast', '2020', 'Toyota', 'Camry', 'https://example.com/images/brake-pads-2.jpg|https://example.com/images/brake-pads-3.jpg'],
            ['', 'Oil Filter', '12.99', '', 'Engine', '250', '', 'Sale', 'physical', '1', '0', '', 'Apex Gasket', '2019', 'Honda', 'Civic', ''],
            ['', 'LED Headlight Bulb', '29.99', '39.99', 'Lighting', '75', 'Bright 12000LM LED bulbs', '', 'physical', '1', '1', '', '', '', '', '', ''],
        ];

        $callback = function () use ($headers, $rows) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $headers);
            foreach ($rows as $row) {
                fputcsv($handle, $row);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="sample-products-import.csv"',
        ]);
    }

    public function exportCsv()
    {
        $headers = ['id', 'name', 'price', 'old_price', 'category', 'stock', 'description', 'badge', 'product_type', 'status', 'featured', 'image', 'brand', 'year', 'make', 'model', 'gallery_images'];

        $products = Product::with('category', 'brand', 'galleryImages')->get();

        $callback = function () use ($headers, $products) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $headers);

            foreach ($products as $p) {
                $galleryUrls = $p->galleryImages->map(function ($img) {
                    return $img->url ? url($img->url) : '';
                })->filter()->values()->implode('|');

                fputcsv($handle, [
                    $p->id,
                    $p->name,
                    $p->price,
                    $p->old_price ?? '',
                    $p->category->name ?? '',
                    $p->stock ?? 0,
                    $p->description ?? '',
                    $p->badge ?? '',
                    $p->product_type ?? 'none',
                    $p->status ? '1' : '0',
                    $p->featured ? '1' : '0',
                    $p->image ? url(storedPath($p->image, 'assets/images/thumbnails')) : '',
                    $p->brand->name ?? '',
                    $p->year ?? '',
                    $p->make ?? '',
                    $p->model ?? '',
                    $galleryUrls,
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="products-export-' . date('Y-m-d') . '.csv"',
        ]);
    }
}
