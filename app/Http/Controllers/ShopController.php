<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ShopController extends Controller
{
    private function filterProducts(Request $request, $query)
    {
        $search = $request->get('search', '');
        $sort = $request->get('sort', 'default');
        $minPrice = $request->get('min_price', '');
        $maxPrice = $request->get('max_price', '');

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

        return [
            'categoryTree' => $categoryTree,
            'recentProducts' => Product::where('status', true)->latest()->take(5)->get(),
        ];
    }

    private function computeCategoryTotals($category, $productCounts)
    {
        $total = $productCounts->get($category->id, 0);
        foreach ($category->children as $child) {
            $total += $this->computeCategoryTotals($child, $productCounts);
        }
        $category->descendant_count = $total;
        return $total;
    }

    public function index(Request $request)
    {
        $productsQuery = Product::where('status', true);
        $this->filterProducts($request, $productsQuery);
        $products = $productsQuery->paginate(9)->withQueryString();

        return view('shop', array_merge(
            compact('products'),
            $this->getSharedData()
        ));
    }

    public function customerProducts(Request $request)
    {
        $productsQuery = Product::where('status', true);
        $this->filterProducts($request, $productsQuery);
        $products = $productsQuery->paginate(9)->withQueryString();
        $pageTitle = 'Classified Products';

        return view('shop', array_merge(
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
        $this->filterProducts($request, $productsQuery);
        $products = $productsQuery->paginate(9)->withQueryString();

        return view('shop', array_merge(
            compact('products', 'currentCategory'),
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
        $this->filterProducts($request, $productsQuery);
        $products = $productsQuery->paginate(9)->withQueryString();

        return view('shop', array_merge(
            compact('products', 'currentCategory', 'currentSubcategory', 'currentChildcategory'),
            $this->getSharedData()
        ));
    }

    public function product($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        return view('product', compact('product'));
    }
}
