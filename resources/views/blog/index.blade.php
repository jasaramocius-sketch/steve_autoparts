@extends('layouts.app')

@section('title', (isset($category) ? $category->name : 'Blogs') . ' - ' . config('app.name', 'StAutoparts'))

@section('content')

<section class="blog-page">
    <!-- Banner Hero Section -->
<section class="gs-breadcrumb-section" style="background-image: url('{{ asset('assets/images/1724480495Imagexxxxxpng.png') }}'); background-size: cover; background-position: center;">
  <div class="container">
    <div class="content-wrapper">
      <h2 class="breadcrumb-title">Blog</h2>
      <ul class="bread-menu">
        <li><a href="{{ route('home') }}">Home</a></li>
        <li style="color: var(--primary)">Blog</li>
      </ul>
    </div>
  </div>
</section>    
<div class="container blog-page-container">

<div class="row">

    <!-- Left -->
    <div class="col-lg-8">

        <div class="blog-grid">

        @foreach($blogs as $blog)

        <div class="blog-card bg-white shadow-sm rounded overflow-hidden">

            <div class="blog-image">
                {!! imgTag('assets/images/blogs/'.($blog->image ?? 'placeholder.jpg'), '', 'w-100') !!}
            </div>

            <div class="p-4">

                <div class="blog-meta mb-3">

                    <span>
                        <i class="far fa-calendar-alt"></i>
                        {{ $blog->created_at->format('d M Y') }}
                    </span>

                    <span class="ms-4">
                        <i class="far fa-user"></i>
                        Admin
                    </span>
                    @if($blog->category)
                    <span class="ms-4">
                        <a href="{{ route('blog.category', $blog->category->slug) }}" class="text-dark">
                            <i class="fas fa-folder"></i>
                            {{ $blog->category->name }}
                        </a>
                    </span>
                    @endif

                </div>
                
                <h3 class="blog-title mb-3">
                    <a href="{{ route('blog.show',$blog->slug) }}">
                        {{ $blog->title }}
                    </a>
                </h3>

                <p class="blog-excerpt mb-4">
                    {{ Str::limit(strip_tags($blog->details ?? ''),180) }}
                </p>

                <a href="{{ route('blog.show',$blog->slug) }}"
                   class="btn btn-danger px-4 primary-btn">
                    Read More
                </a>

            </div>

        </div>

        @endforeach

        </div>

        {{ $blogs->links() }}

    </div>


    <!-- Sidebar -->
    <div class="col-lg-4 blog-sidebar   ">

        <!-- Search -->
        <div class="bg-white shadow-sm rounded p-4 mb-4">

            <h5 class="mb-3">Search</h5>

            <form>
                <div class="input-group">
                    <input type="text"
                           class="form-control"
                           placeholder="Search...">

                    <button class="btn btn-danger">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>

        </div>


        <!-- Recent Posts -->
        <div class="bg-white shadow-sm rounded p-4 mb-4 main-blog-page blog-recent-posts">

            <h5 class="mb-4">Recent Posts</h5>

            @foreach($recentBlogs as $post)

            <div class="d-flex mb-3 blog-featured-image">

                {!! imgTag('assets/images/blogs/'.($post->image ?? 'placeholder.jpg'), '', 'rounded', 'width="90"') !!}

                <div class="ms-3">

                    <a href="{{ route('blog.show',$post->slug) }}"
                       class="fw-semibold text-dark">
                        {{ Str::limit($post->title,50) }}
                    </a>

                    <div class="text-muted small mt-1">
                        {{ $post->created_at->format('d M Y') }}
                    </div>

                </div>

            </div>

            @endforeach

        </div>


        <!-- Categories -->
        <div class="bg-white shadow-sm rounded p-4">
            <h5 class="mb-4">Categories</h5>
            @foreach($categories as $cat)
            <div class="d-flex justify-content-between border-bottom py-2">
                <a href="{{ route('blog.category', $cat->slug) }}" class="text-dark fw-semibold">
                    {{ $cat->name }}
                </a>
                <span>{{ $cat->blogs_count }}</span>
            </div>
            @endforeach
        </div>
        
    </div>

</div>
</div>
</section>

@endsection