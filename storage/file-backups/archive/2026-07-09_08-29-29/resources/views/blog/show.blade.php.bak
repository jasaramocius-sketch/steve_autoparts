@extends('layouts.app')

@section('title', $blog->title . ' - ' . config('app.name', 'StAutoparts'))

@section('content')

<div id="blog-id-{{$blog->id}}" class="single-blog container py-5">
<a href="{{ route('blog') }}" class="btn btn-outline-primary single-blog-button">
    Back to Blog
</a>
<h1>{{ $blog->title }}</h1>
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
    <div class="blog-content">
    @if($blog->image)
    <div class="blog-featured-image-dev">
        {!! imgTag('assets/images/blogs/'.$blog->image, '', 'img-fluid mb-4') !!}
    </div>
    @else
    <div class="blog-featured-image-dev">
        {!! imgTag('assets/images/blogs/placeholder.jpg', '', 'img-fluid mb-4') !!}
    </div>
    @endif
    <div class="blog-content-div">

    {!! $blog->details !!}
    </div>
    </div>
    <div class="row mt-5 border-top pt-4">
        <div class="col-md-6">
            @if($previous)
                <small class="text-muted d-block">Previous Post</small>
                <a href="{{ route('blog.show', $previous->slug) }}">
                    {{ $previous->title }}
                </a>
                @else
                <small class="text-muted d-block">Previous Post</small>
            @endif
        </div>

        <div class="col-md-6 text-md-end">
            @if($next)
                <small class="text-muted d-block">Next Post</small>
                <a href="{{ route('blog.show', $next->slug) }}">
                    {{ $next->title }}
                </a>
               @else
               <small class="text-muted d-block">Next Post</small>
            @endif
        </div>
    </div>
</div>
@endsection