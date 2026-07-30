@extends('layouts.app')

@section('title', 'All Categories' . ' - ' . config('app.name', 'StAutoparts'))

@section('content')
<style>
  
</style>

<!-- Banner Hero Section -->
<section class="gs-breadcrumb-section"
    style="background-image: url('{{ asset('/assets/images/1724480495Imagexxxxxpng.png') }}');
    background-size: cover; background-position: center;">

  <div class="container">
    <div class="content-wrapper">
      <h2 class="breadcrumb-title">All Categories</h2>
      <ul class="bread-menu">
        <li><a href="{{ route('home') }}">Home</a></li>
        <li style="color: var(--primary)">Categories</li>
      </ul>
    </div>
  </div>
</section>

<div class="container mt-5">

    <!-- Toolbar -->
    <div class="category-toolbar mb-4">
        <div class="row align-items-center">

            <div class="col-md-4">
                <form action="{{ route('categories.index') }}" method="GET">
                    <input type="text"
                           class="form-control"
                           name="search"
                           placeholder="Search category..."
                           value="{{ request('search') }}">
                </form>
            </div>

            <div class="col-md-8">
                <div class="toolbar-right category-toolbar-right">
                    <div class="categories-sortby-filter">
                    <span class="sort-label">Sort by:</span>
                    <form method="GET">
                        <input type="hidden" name="search" value="{{ request('search') }}">

                        <select class="form-select sort-select"
                                name="sort"
                                onchange="this.form.submit()">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name A-Z</option>
                        </select>
                    </form>
                    </div>
                    <div class="d-flex align-items-center gap-3 flex-wrap filter-sort-brand-wrapper">
                    <button type="button" id="gridBtn" class="view-btn active steve-btn">
                        <i class="fas fa-th-large"></i>
                    </button>

                    <button type="button" id="listBtn" class="view-btn steve-btn">
                        <i class="fas fa-bars"></i>
                    </button>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- Categories Grid -->
    <div class="row" id="categoryContainer">

    @foreach($categories as $category)

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="category-card">

            <div class="category-image">
                <a href="{{ route('category', $category->slug) }}">
                    @php $categoryImage = $category->getDisplayImagePath(); @endphp
                    {!! imgTag($categoryImage, $category->name) !!}
                </a>
            </div>

            <div class="category-content">
                <a href="{{ route('category', $category->slug) }}">
                    <h5>{{ $category->name }}</h5>
                </a>

                <div class="category-stats">
                    <span class="badge bg-primary">
                        {{ $category->total_products_count }} Products
                    </span>

                    @if($category->children->count() > 0)
                    <span class="badge bg-secondary subcategory-count-badge">
                        {{ $category->children->count() }} Sub Categories
                    </span>
                    @endif
                </div>

                @if($category->children->count() > 0)
                <div class="subcategory-list mt-2">
                        <ul class="list-unstyled mb-0" style="font-size:13px;">
                            @foreach($category->children as $child)
                                <li class="mb-1">
                                    <a href="{{ route('subcategory', ['parent' => $category->slug, 'child' => $child->slug]) }}" class="text-decoration-none" style="color:#1f0300;">
                                        {{ $child->name }}
                                    </a>
                                    <span class="text-muted">({{ $child->total_products_count }})</span>
                                </li>
                            @endforeach
                        </ul>
                </div>
                @endif
            </div>

        </div>
    </div>

    @endforeach

</div>

</div>

@endsection