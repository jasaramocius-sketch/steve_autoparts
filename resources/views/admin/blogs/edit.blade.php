@extends('admin.layouts.app')
{{-- Add your custom page ID and classes right here --}}
@include('partials.page-attributes', ['pageId' => 'admin-blog-edit-page', 'pageClass' => 'admin-blog-edit-page'])
@section('page-title', 'Edit Blog')
@section('meta_tags')
    @include('partials.meta-tags', [
        'pageTitle' => 'Edit Blog - Admin Panel',
        'robots' => 'noindex, nofollow',
    ])
@endsection
@section('content')

<div class="card border-0 shadow-sm">
    <!-- <div class="card-header bg-white">
        <h5 class="mb-0">Edit Blog</h5>
    </div> -->
    <div class="card-body">
        <form action="{{ route('admin.blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label">Title *</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $blog->title) }}" required>
                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control @error('status') is-invalid @enderror">
                        <option value="draft" {{ (old('status', $blog->status) ?? 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="scheduled" {{ (old('status', $blog->status) ?? 'draft') === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                        <option value="published" {{ (old('status', $blog->status) ?? 'draft') === 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror

                    <label class="form-label mt-3">Post Date <small class="text-muted">(optional)</small></label>
                    <input type="datetime-local" name="published_at" class="form-control @error('published_at') is-invalid @enderror" value="{{ old('published_at', $blog->published_at?->format('Y-m-d\TH:i')) }}">
                    @error('published_at') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <small class="text-muted">Required when status is Scheduled. Empty + Published = visible now.</small>
                </div>
                <div class="col-md-4">
                    @include('admin.partials.blog-category-field', ['selectedCategoryId' => old('blog_category_id', $blog->blog_category_id ?? '')])
                </div>

                <div class="col-md-8">
                    <label class="form-label">Tags</label>
                    @include('admin.partials.blog-tags-input', [
                        'selectedTags' => old('tags', $tagsString),
                        'allTags' => $allTagsString
                    ])
                </div>

                <div class="col-md-12">
                    <label class="form-label">Content</label>                    
                    <textarea id="editor"
                        name="details"
                        class="form-control texteditor @error('details') is-invalid @enderror"
                        rows="10">{{ old('details', $blog->details) }}</textarea>
                    @error('details') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <!-- <label class="form-label">Image (Upload)</label>
                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"> -->
                    @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    @if($blog->image)
                        <div class="mt-2">
                            <img src="{{ storedImageUrl($blog->image, 'assets/images/blogs') }}" width="80" class="admin-image-thumb" onerror="this.onerror=null;this.src='{{ asset('assets/images/placeholder.png') }}'">
                            <small class="text-muted ms-2">Current Image</small>
                        </div>
                    @endif
                    <input type="hidden" name="image_from_manager" id="image_from_manager_blog_image">
                    <div id="impPreview_blog_image" class="d-none mt-2"></div>
                    <button type="button" class="btn btn-sm btn-outline-primary mt-1" onclick="impOpen_blog_image()">
                        <i class="fas fa-images me-1"></i> Browse Image Manager
                    </button>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Image (URL)</label>
                    <input type="url" name="image_url" class="form-control @error('image_url') is-invalid @enderror" value="{{ old('image_url') }}" placeholder="https://example.com/image.jpg">
                    @error('image_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <small class="text-muted">Provide a URL to download the image from (only if no file uploaded).</small>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button class="btn btn-primary steve-btn gap-1"><i class="fas fa-save"></i> Update</button>
                <a href="{{ route('admin.blogs.index') }}" class="btn btn-primary steve-btn gap-1">Cancel</a>
            </div>
        </form>
    </div>
</div>

@include('admin.partials.image-manager-picker', ['pickerId' => 'blog_image', 'targetInput' => 'image_from_manager'])

@endsection
