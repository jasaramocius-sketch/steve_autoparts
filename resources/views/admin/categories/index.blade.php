@extends('admin.layouts.app')

@section('content')

@php $trashedCount = \App\Models\Category::onlyTrashed()->count(); @endphp

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>All Categories</h3>

    <div class="d-flex gap-2">
        <form action="{{ route('admin.categories.index') }}" method="GET" class="d-flex gap-2">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Search categories..." value="{{ request('search') }}" style="width:200px;">
            <button class="btn btn-sm btn-outline-primary" type="submit"><i class="fas fa-search"></i></button>
            @if(request('search'))
                <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-outline-secondary"><i class="fas fa-times"></i></a>
            @endif
        </form>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">Add Category</a>
    </div>
</div>

<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a class="nav-link {{ !request()->has('trashed') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">Active</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->has('trashed') ? 'active' : '' }}" href="{{ route('admin.categories.index', ['trashed' => 1]) }}">Trash ({{ $trashedCount }})</a>
    </li>
</ul>

<div class="card">
    <div class="card-body">

        @if(!request()->has('trashed'))
        @php
            $sort = request('orderby', 'id');
            $order = request('order', 'desc');
            $nextOrder = fn($col) => $sort === $col && $order === 'asc' ? 'desc' : 'asc';
            $sortIcon = fn($col) => $sort === $col ? ($order === 'asc' ? ' ↑' : ' ↓') : '';
        @endphp
        @endif

        <table class="table table-bordered align-middle">

            <thead>
            <tr>
                @if(request()->has('trashed'))
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Products</th>
                <th>Parent Category</th>
                <th width="200">Action</th>
                @else
                <th><a href="{{ request()->fullUrlWithQuery(['orderby' => 'id', 'order' => $nextOrder('id')]) }}" class="text-decoration-none text-dark">ID{!! $sortIcon('id') !!}</a></th>
                <th>Image</th>
                <th><a href="{{ request()->fullUrlWithQuery(['orderby' => 'name', 'order' => $nextOrder('name')]) }}" class="text-decoration-none text-dark">Name{!! $sortIcon('name') !!}</a></th>
                <th>Slug</th>
                <th>Status</th>
                <th><a href="{{ request()->fullUrlWithQuery(['orderby' => 'products_count', 'order' => $nextOrder('products_count')]) }}" class="text-decoration-none text-dark">Products{!! $sortIcon('products_count') !!}</a></th>
                <th>Parent Category</th>
                <th width="150">Action</th>
                @endif
            </tr>
            </thead>

            <tbody>

            @forelse($categories as $category)

            <tr class="categoryRow">

                <td>{{ $category->id }}</td>

                <td>
                    <img src="{{ $category->image
                        ? asset('assets/images/categories/'.$category->image)
                        : '' }}"
                        width="50"
                        alt="{{ $category->name }}">
                </td>

                <td>{{ $category->name }}</td>

                <td>{{ $category->slug }}</td>

                <td>
                    @if(request()->has('trashed'))
                        <span class="badge bg-secondary">Deleted</span>
                    @else
                        <form action="{{ route('admin.categories.toggle-status', $category->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm border-0 p-0">
                                <span class="badge {{ $category->status ? 'bg-success' : 'bg-danger' }}" style="cursor:pointer;">
                                    {{  $category->status ? 'Active' : 'Inactive' }}
                                </span>
                            </button>
                        </form>
                    @endif
                </td>

                <td>{{ $category->products_count ?? 0 }}</td>

                <td>
                    {{ $category->parent_category?->name ??  'None' }}
                </td>

                <td>
                    @if(request()->has('trashed'))
                        <form action="{{ route('admin.categories.restore', $category->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-sm btn-outline-success" title="Restore"><i class="fas fa-undo"></i></button>
                        </form>
                        <form action="{{ route('admin.categories.force-delete', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Permanently delete {{ $category->name }}?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" title="Delete Permanently"><i class="fas fa-times"></i></button>
                        </form>
                    @else
                        <a href="{{ route('admin.categories.edit',$category->id) }}"
                           class="btn btn-warning btn-sm">
                            Edit
                        </a>
                        <form action="{{ route('admin.categories.destroy',$category->id) }}"
                              method="POST"
                              class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Delete category?')">
                                Delete
                            </button>
                        </form>
                    @endif
                </td>

            </tr>

            @empty
            <tr>
                <td colspan="8" class="text-center py-4 text-muted">{{ request()->has('trashed') ? 'Trash is empty.' : 'No results found.' }}</td>
            </tr>
            @endforelse

            </tbody>

        </table>

    </div>
</div>

@endsection