@extends('admin.layouts.app')
{{-- Add your custom page ID and classes right here --}}
@section('page-id', 'admin-images-edit-page')
@section('page-class', 'admin-images-edit-page')
@section('page-title', 'Edit Image - ' . $image->original_name)
@section('content')
<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0"><i class="fas fa-image me-2"></i>Edit Image</h4>
        <a href="{{ route('admin.images.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Back to Images
        </a>
    </div>

    <div class="row g-4">
        {{-- Image Preview --}}
        <div class="col-md-5">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <img src="{{ $image->thumb_url }}" alt="{{ $image->alt_text ?? $image->original_name }}" class="img-fluid rounded" style="max-height:400px;" onerror="this.onerror=null;this.src='{{ asset("assets/images/placeholder.png") }}'">
                    <hr>
                    <div class="table-responsive">
                    <table class="table table-sm table-borderless text-start small mb-0">
                        <tr><th class="text-muted">Filename</th><td>{{ $image->original_name }}</td></tr>
                        <tr><th class="text-muted">URL</th><td class="text-break"><a href="{{ $image->thumb_url }}" target="_blank"><code>{{ $image->thumb_url }}</code></a></td></tr>
                        <tr><th class="text-muted">MIME Type</th><td>{{ $image->mime_type }}</td></tr>
                        <tr><th class="text-muted">Size</th><td>{{ $image->size_in_kb }}</td></tr>
                        <tr><th class="text-muted">Dimensions</th><td>{{ $image->width }} x {{ $image->height }} px</td></tr>
                        <tr>
                            <th class="text-muted">Attached To</th>
                            <td>
                                @if($image->attachable_type && $image->attachable)
                                    {{ class_basename($image->attachable_type) }} #{{ $image->attachable_id }}
                                    ({{ $image->attachable->name ?? $image->attachable->title ?? 'N/A' }})
                                @else
                                    <span class="text-danger">Unused</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                    </div>
                </div>
            </div>

            {{-- Convert --}}
            @if(in_array($image->mime_type, ['image/jpeg', 'image/pjpeg']))
            <div class="card border-0 shadow-sm mt-3">
                <div class="card-body text-center">
                    <form action="{{ route('admin.images.convert', $image->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success w-100 steve-btn">
                            <i class="fas fa-exchange-alt"></i> Convert to WebP
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>

        {{-- Edit Form --}}
        <div class="col-md-7">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white"><h5 class="mb-0">Image Details</h5></div>
                <div class="card-body">
                    <form action="{{ route('admin.images.update', $image->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Alt Text <small class="text-muted">(for SEO & accessibility)</small></label>
                            <input type="text" name="alt_text" class="form-control" value="{{ old('alt_text', $image->alt_text) }}" placeholder="Describe the image...">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $image->title) }}" placeholder="Image title">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Caption</label>
                            <textarea name="caption" class="form-control texteditor" rows="3" placeholder="Optional caption">{{ old('caption', $image->caption) }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary steve-btn">
                            <i class="fas fa-save"></i> Update Details
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
