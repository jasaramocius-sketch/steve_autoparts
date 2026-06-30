<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('trashed')) {
            $products = Product::onlyTrashed()->with('category')->latest()->get();
        } else {
            $products = Product::with('category')->latest()->get();
        }
        return view('admin.products.index', compact('products'));
    }

    public function restore($id)
    {
        Product::onlyTrashed()->findOrFail($id)->restore();
        return redirect()->route('admin.products.index')->with('success', 'Product restored successfully!');
    }

    public function forceDelete($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        deleteImageFiles($product->image, 'assets/images/thumbnails');
        $product->forceDelete();
        return redirect()->route('admin.products.index')->with('success', 'Product permanently deleted!');
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->where('status', true)->firstOrFail();
        $related = Product::with('category')->where('status', true)->where('id', '!=', $product->id)->take(4)->get();
        return view('product', compact('product', 'related'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $data = $request->only(['name', 'description', 'price', 'old_price', 'category_id', 'badge', 'product_type', 'stock', 'status']);
        $data['featured'] = $request->boolean('featured');
        $data['added_by'] = 'admin';
        $data['slug'] = Str::slug($request->name) . '-' . time();

        if ($request->hasFile('image')) {
            $data['image'] = saveImageWithWebp($request->file('image'), 'assets/images/thumbnails');
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::orderBy('name')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $data = $request->only(['name', 'description', 'price', 'old_price', 'category_id', 'badge', 'product_type', 'stock', 'status']);
        $data['featured'] = $request->boolean('featured');

        if ($request->hasFile('image')) {
            deleteImageFiles($product->image, 'assets/images/thumbnails');
            $data['image'] = saveImageWithWebp($request->file('image'), 'assets/images/thumbnails');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
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
            'phone' => 'nullable|string|max:20',
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
        ]);

        return back()->with('success', 'Your message has been sent to the seller.');
    }
}
