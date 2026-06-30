@extends('admin.layouts.app')
@section('page-title', 'Edit Product')
@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0">Edit Product</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Name *</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label">Price *</label>
                    <input type="number" step="0.01" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $product->price) }}" required>
                    @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label">Old Price</label>
                    <input type="number" step="0.01" name="old_price" class="form-control" value="{{ old('old_price', $product->old_price) }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Stock</label>
                    <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}" min="0">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-control">
                        <option value="">None</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ (old('category_id', $product->category_id) == $cat->id) ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Badge</label>
                    <input type="text" name="badge" class="form-control" value="{{ old('badge', $product->badge) }}" placeholder="New, Sale">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Section</label>
                    <select name="product_type" class="form-control">
                        <option value="none" {{ old('product_type', $product->product_type) == 'none' ? 'selected' : '' }}>None</option>
                        <option value="new_arrival" {{ old('product_type', $product->product_type) == 'new_arrival' ? 'selected' : '' }}>New Arrivals</option>
                        <option value="trending" {{ old('product_type', $product->product_type) == 'trending' ? 'selected' : '' }}>Trending</option>
                        <option value="best_selling" {{ old('product_type', $product->product_type) == 'best_selling' ? 'selected' : '' }}>Best Selling</option>
                        <option value="popular" {{ old('product_type', $product->product_type) == 'popular' ? 'selected' : '' }}>Popular</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="1" {{ old('status', $product->status) == '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('status', $product->status) == '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <div class="form-check mt-2">
                        <input type="checkbox" name="featured" value="1" class="form-check-input" id="featured" {{ old('featured', $product->featured) ? 'checked' : '' }}>
                        <label class="form-check-label" for="featured">Featured</label>
                    </div>
                </div>

                <div class="col-md-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Image</label>
                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                    @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    @if($product->image)
                        <div class="mt-2">
                            <img src="{{ asset('assets/images/thumbnails/' . $product->image) }}" width="80" style="border-radius:4px;">
                            <small class="text-muted ms-2">Current Image</small>
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-4">
                <button class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection
