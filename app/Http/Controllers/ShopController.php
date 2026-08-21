<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    private function filterProducts(Request $request, $query)
    {
        $search = $request->get('search', '');
        $sort = $request->get('sort', 'default');
        $minPrice = $request->get('min_price', '');
        $maxPrice = $request->get('max_price', '');
        $brand = $request->get('brand', '');
        $year = $request->get('year', '');
        $make = $request->get('make', '');
        $model = $request->get('model', '');

        if ($search !== '') {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $currency = session('currency', 'USD');
        $rate = config('currencies.' . $currency . '.rate', 1);

        if ($minPrice !== '') {
            $query->where('price', '>=', (float)$minPrice / $rate);
        }

        if ($maxPrice !== '') {
            $query->where('price', '<=', (float)$maxPrice / $rate);
        }

        if ($brand !== '') {
            if (is_numeric($brand)) {
                $query->where('brand_id', (int)$brand);
            } else {
                $brandModel = Brand::where('slug', $brand)->first();
                if ($brandModel) {
                    $query->where('brand_id', $brandModel->id);
                }
            }
        }

        if ($year !== '') {
            $query->where('year', $year);
        }

        if ($make !== '') {
            $query->where('make', $make);
        }

        if ($model !== '') {
            $query->where('model', $model);
        }

        if ($sort === 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($sort === 'price_desc') {
            $query->orderBy('price', 'desc');
        } elseif ($sort === 'rating') {
            $query->orderBy('rating', 'desc');
        } elseif ($sort === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        return $query;
    }

    private function applyVehicleFilter(Request $request, $query, bool $autoFirst = false)
    {
        $selectedVehicle = null;
        $vehicleMatchCount = null;
        $vehicleFilterCleared = session('shop_vehicle_cleared', false);

        if (Auth::check()) {
            $selectedVehicleId = session('selected_vehicle_id');
            if ($selectedVehicleId) {
                $selectedVehicle = Vehicle::where('user_id', Auth::id())->where('id', $selectedVehicleId)->first();
            }
            if (!$selectedVehicle && $autoFirst) {
                $selectedVehicle = Vehicle::where('user_id', Auth::id())->first();
            }
        }

        $hasVehicleFilters = $request->filled('year') || $request->filled('make') || $request->filled('model');

        if ($selectedVehicle && !$hasVehicleFilters && !$vehicleFilterCleared) {
            $request->merge([
                'year' => $selectedVehicle->year,
                'make' => $selectedVehicle->make,
                'model' => $selectedVehicle->model,
            ]);
        }

        if ($vehicleFilterCleared || $hasVehicleFilters) {
            $selectedVehicle = null;
        }

        // When a garage vehicle is applied, count matching products. On zero match,
        // fall back to showing all products but keep the vehicle alert (with the 0
        // count) so the user knows no parts fit their vehicle.
        if ($selectedVehicle) {
            $vehicleQuery = (clone $query);
            $this->filterProducts($request, $vehicleQuery);
            $vehicleMatchCount = $vehicleQuery->count();

            if ($vehicleMatchCount === 0) {
                $request->merge(['year' => '', 'make' => '', 'model' => '']);
            }
        }

        return compact('selectedVehicle', 'vehicleMatchCount');
    }

    private function getSharedData()
    {
        $categoryTree = Category::topLevel()
            ->where('status', true)
            ->with('childrenRecursive')
            ->get();

        $productCounts = Product::where('status', true)
            ->selectRaw('category_id, COUNT(*) as count')
            ->groupBy('category_id')
            ->pluck('count', 'category_id');

        $categoryTree->each(function ($cat) use ($productCounts) {
            $this->computeCategoryTotals($cat, $productCounts);
        });

        $currency = session('currency', 'USD');

        return [
            'categoryTree' => $categoryTree,
            'brands' => Brand::where('status', true)->whereHas('products')->orderBy('name')->get(['id', 'name', 'slug']),
            'years' => Product::where('status', true)->whereNotNull('year')->distinct()->orderBy('year', 'desc')->pluck('year'),
            'makes' => Product::where('status', true)->whereNotNull('make')->distinct()->orderBy('make')->pluck('make'),
            'models' => Product::where('status', true)->whereNotNull('model')->distinct()->orderBy('model')->pluck('model'),
            'vehicleData' => Product::where('status', true)
                ->whereNotNull('year')
                ->whereNotNull('make')
                ->whereNotNull('model')
                ->select('year', 'make', 'model')
                ->distinct()
                ->get(),
            'maxProductPrice' => Product::where('status', true)->max('price') ?? 1000,
            'minProductPrice' => Product::where('status', true)->min('price') ?? 0,
            'currencySymbol' => config('currencies.' . $currency . '.symbol', '$'),
        ];
    }

    private function computeCategoryTotals($category, $productCounts)
    {
        $total = $productCounts->get($category->id, 0);
        foreach ($category->children as $child) {
            // FIXED LINE HERE
            $total += $this->computeCategoryTotals($child, $productCounts);
        }
        $category->descendant_count = $total;
        return $total;
    }

    public function index(Request $request)
    {
        $productsQuery = Product::where('status', true);
        $vehicleData = $this->applyVehicleFilter($request, $productsQuery, true);

        $this->filterProducts($request, $productsQuery);
        $products = $productsQuery->paginate(24)->onEachSide(1)->withQueryString();

        return view('shop.index', array_merge(
            $vehicleData,
            compact('products'),
            $this->getSharedData(),
            ['page' => \App\Models\Page::where('slug', 'shop')->where('status', true)->first()]
        ));
    }

    public function clearVehicleFilter(Request $request)
    {
        session(['shop_vehicle_cleared' => true]);

        $url = $request->headers->get('referer') ?: route('shop');
        $path = $url;
        $query = [];
        if (str_contains($url, '?')) {
            [$path, $qs] = explode('?', $url, 2);
            parse_str($qs, $query);
        }
        unset($query['year'], $query['make'], $query['model'], $query['page']);

        return redirect($path . (!empty($query) ? '?' . http_build_query($query) : ''));
    }

    public function customerProducts(Request $request)
    {
        $productsQuery = Product::where('status', true);
        $this->filterProducts($request, $productsQuery);
        $products = $productsQuery->paginate(24)->onEachSide(1)->withQueryString();
        $pageTitle = 'Classified Products';

        return view('shop.index', array_merge(
            compact('products', 'pageTitle'),
            $this->getSharedData()
        ));
    }

    public function category(Request $request, $slug)
    {
        $category = Category::where('slug', $slug)->where('status', true)->firstOrFail();
        $currentCategory = $category;
        $currentSubcategory = null;
        $currentChildcategory = null;

        if ($category->parent_id) {
            $topLevel = $category;
            while ($topLevel->parent_id) {
                $topLevel = $topLevel->parent;
            }
            $currentCategory = $topLevel->load('children.children');

            if ($category->parent_id == $topLevel->id) {
                $currentSubcategory = $category;
            } else {
                $midLevel = $category->parent;
                while ($midLevel->parent_id != $topLevel->id) {
                    $midLevel = $midLevel->parent;
                }
                $currentSubcategory = $midLevel;
                $currentChildcategory = $category;
            }
        } else {
            $currentCategory->load('children.children');
        }

        $categoryIds = $category->getAllDescendantIds();

        $productsQuery = Product::whereIn('category_id', $categoryIds)->where('status', true);
        $vehicleData = $this->applyVehicleFilter($request, $productsQuery);

        $this->filterProducts($request, $productsQuery);
        $products = $productsQuery->paginate(24)->onEachSide(1)->withQueryString();

        return view('shop.index', array_merge(
            compact('products', 'currentCategory'),
            $vehicleData,
            array_filter(compact('currentSubcategory', 'currentChildcategory')),
            $this->getSharedData()
        ));
    }

    public function subcategory(Request $request, $parent, $child, $subchild = null)
    {
        $parentCat = Category::where('slug', $parent)->where('status', true)->firstOrFail();
        $childCat = Category::where('slug', $child)->where('parent_id', $parentCat->id)->where('status', true)->firstOrFail();

        $currentCategory = $parentCat;
        $currentSubcategory = $childCat;
        $currentChildcategory = null;

        if ($subchild) {
            $subchildCat = Category::where('slug', $subchild)->where('parent_id', $childCat->id)->where('status', true)->firstOrFail();
            $categoryIds = $subchildCat->getAllDescendantIds();
            $currentChildcategory = $subchildCat;
        } else {
            $categoryIds = $childCat->getAllDescendantIds();
        }

        $productsQuery = Product::whereIn('category_id', $categoryIds)->where('status', true);
        $vehicleData = $this->applyVehicleFilter($request, $productsQuery);

        $this->filterProducts($request, $productsQuery);
        $products = $productsQuery->paginate(24)->onEachSide(1)->withQueryString();

        return view('shop.index', array_merge(
            compact('products', 'currentCategory', 'currentSubcategory', 'currentChildcategory'),
            $vehicleData,
            $this->getSharedData()
        ));
    }

    public function product($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        $userVehicle = null;
        $vehicleFit = null;
        if (Auth::check()) {
            $selectedVehicleId = session('selected_vehicle_id');
            if ($selectedVehicleId) {
                $userVehicle = Vehicle::where('user_id', Auth::id())->where('id', $selectedVehicleId)->first();
            }
            if (!$userVehicle) {
                $userVehicle = Vehicle::where('user_id', Auth::id())->first();
            }
            if ($userVehicle && $product->year && $product->make && $product->model) {
                $vehicleFit = (
                    strtolower(trim($userVehicle->year)) === strtolower(trim($product->year)) &&
                    strtolower(trim($userVehicle->make)) === strtolower(trim($product->make)) &&
                    strtolower(trim($userVehicle->model)) === strtolower(trim($product->model))
                );
            }
        }

        return view('product.show', compact('product', 'userVehicle', 'vehicleFit'));
    }

    public function suggestions(Request $request)
    {
        $query = $request->get('query', '');

        if (strlen($query) < 3) {
            return response()->json([]);
        }

        $products = Product::where('status', true)
            ->where('name', 'like', "%{$query}%")
            ->with('category:id,name')
            ->limit(8)
            ->get(['id', 'name', 'slug', 'price', 'old_price', 'image', 'category_id']);

        $results = $products->map(function ($product) {
            return [
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => currency_format($product->price),
                'old_price' => $product->old_price ? currency_format($product->old_price) : null,
                'image' => storedImageUrl($product->image, 'assets/images/thumbnails'),
                'category' => $product->category->name ?? '',
                'url' => route('product', $product->slug),
            ];
        });

        return response()->json($results);
    }
}