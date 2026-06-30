@extends('admin.layouts.app')
@section('page-title', 'Products')
@section('content')

@php $trashedCount = \App\Models\Product::onlyTrashed()->count(); @endphp

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0">All Products</h4>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add Product</a>
</div>

<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a class="nav-link {{ !request()->has('trashed') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">Active</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->has('trashed') ? 'active' : '' }}" href="{{ route('admin.products.index', ['trashed' => 1]) }}">Trash ({{ $trashedCount }})</a>
    </li>
</ul>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Old Price</th>
                        <th>Stock</th>
                        <th>Badge</th>
                        <th>Section</th>
                        <th>Featured</th>
                        <th>Status</th>
                        <th class="pe-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td class="ps-3">{{ $product->id }}</td>
                        <td>
                            <img src="{{ asset('assets/images/thumbnails/' . ($product->image ?? 'default.png')) }}" width="50" height="50" style="object-fit:cover; border-radius:4px;">
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name ??  'N/A' }}</td>
                        <td>{{ currency_format($product->price) }}</td>
                        <td>@if($product->old_price) {{ currency_format($product->old_price) }} @else - @endif</td>
                        <td>{{ $product->stock ?? 0 }}</td>
                        <td>@if($product->badge) <span class="badge bg-warning text-dark">{{ $product->badge }}</span> @else - @endif</td>
                        <td><span class="badge bg-info text-white">{{ str_replace('_', ' ', ucfirst($product->product_type ?? 'none')) }}</span></td>
                        <td>
                            @if(!request()->has('trashed'))
                                <form action="{{ route('admin.products.toggle-featured', $product->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm border-0 p-0">
                                        <span class="badge {{ $product->featured ? 'bg-warning text-dark' : 'bg-secondary' }}" style="cursor:pointer;">
                                            {{ $product->featured ? 'Yes' : 'No' }}
                                        </span>
                                    </button>
                                </form>
                            @else
                                <span class="badge bg-secondary">-</span>
                            @endif
                        </td>
                        <td>
                            @if(request()->has('trashed'))
                                <span class="badge bg-secondary">Deleted</span>
                            @else
                                <form action="{{ route('admin.products.toggle-status', $product->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm border-0 p-0">
                                        <span class="badge {{ $product->status ? 'bg-success' : 'bg-danger' }}" style="cursor:pointer;">
                                            {{  $product->status ? 'Active' : 'Inactive' }}
                                        </span>
                                    </button>
                                </form>
                            @endif
                        </td>
                        <td class="pe-3">
                            @if(request()->has('trashed'))
                                <form action="{{ route('admin.products.restore', $product->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-success" title="Restore"><i class="fas fa-undo"></i></button>
                                </form>
                                <form action="{{ route('admin.products.force-delete', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Permanently delete {{ $product->name }}?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" title="Delete Permanently"><i class="fas fa-times"></i></button>
                                </form>
                            @else
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this product?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11" class="text-center py-4 text-muted">{{ request()->has('trashed') ? 'Trash is empty.' : 'No products found.' }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
