@extends('admin.layouts.app')
{{-- Add your custom page ID and classes right here --}}
@section('page-id', 'admin-pages-edit-page')
@section('page-class', 'admin-pages-edit-page')
@section('page-title', 'Edit Page')
@section('content')

<div class="card border-0 shadow-sm">
    <!-- <div class="card-header bg-white">
        <h5 class="mb-0">Edit Page</h5>
    </div> -->
    <div class="card-body">
        <form action="{{ route('admin.pages.update', $page->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label">Title *</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $page->title) }}" required>
                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                    <div class="col-md-6">
                        <label class="form-label">Short Description</label>
                        <input type="text" name="short_description" class="form-control @error('short_description') is-invalid @enderror" value="{{ old('short_description', $page->short_description) }}">
                        @error('short_description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                <div class="col-md-4">
                    <label class="form-label">&nbsp;</label>
                    <div class="form-check mt-2">
                        <input type="checkbox" name="status" value="1" class="form-check-input" id="status" {{ $page->status ? 'checked' : '' }}>
                        <label class="form-check-label" for="status">Active</label>
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Meta Title</label>
                    <input type="text" name="meta_title" class="form-control @error('meta_title') is-invalid @enderror" value="{{ old('meta_title', $page->meta_title) }}">
                    @error('meta_title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Meta Description</label>
                    <textarea name="meta_description" class="form-control texteditor @error('meta_description') is-invalid @enderror" rows="2">{{ old('meta_description', $page->meta_description) }}</textarea>
                    @error('meta_description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-12">
                    <label class="form-label">Content</label>
                    <textarea name="content" class="form-control texteditor @error('content') is-invalid @enderror" rows="12">{{ old('content', $page->content) }}</textarea>
                    @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mt-4">
                <button class="btn btn-primary steve-btn"><i class="fas fa-save"></i> Update</button>
                <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection
