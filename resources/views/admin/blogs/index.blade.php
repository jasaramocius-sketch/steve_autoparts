@extends('admin.layouts.app')
@section('page-title', 'Blog')
@section('content')

@php $trashedCount = \App\Models\Blog::onlyTrashed()->count(); @endphp

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0">All Blogs</h4>
    <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add Blog</a>
</div>

<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a class="nav-link {{ !request()->has('trashed') ? 'active' : '' }}" href="{{ route('admin.blogs.index') }}">Active</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->has('trashed') ? 'active' : '' }}" href="{{ route('admin.blogs.index', ['trashed' => 1]) }}">Trash ({{ $trashedCount }})</a>
    </li>
</ul>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">#</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th class="pe-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($blogs as $blog)
                    <tr>
                        <td class="ps-3">{{ $blog->id }}</td>
                        <td>
                            @if($blog->image)
                                <img src="{{ asset('assets/images/blogs/' . $blog->image) }}" width="50" height="50" style="object-fit:cover; border-radius:4px;">
                            @else
                                <img src="{{ asset('assets/images/blogs/placeholder.jpg') }}" width="50" height="50" style="object-fit:cover; border-radius:4px;">
                            @endif
                        </td>
                        <td>{{ $blog->title ?? 'Untitled' }}</td>
                        <td>
                            @if(request()->has('trashed'))
                                <span class="badge bg-secondary">Deleted</span>
                            @else
                                <form action="{{ route('admin.blogs.toggle-status', $blog->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm border-0 p-0">
                                        <span class="badge {{ $blog->status === 'published' ? 'bg-success' : 'bg-warning text-dark' }}" style="cursor:pointer;">
                                            {{ ucfirst($blog->status ?? 'draft') }}
                                        </span>
                                    </button>
                                </form>
                            @endif
                        </td>
                        <td>{{ $blog->created_at ? $blog->created_at->format('d M Y') : '—' }}</td>
                        <td class="pe-3">
                            @if(request()->has('trashed'))
                                <form action="{{ route('admin.blogs.restore', $blog->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-success" title="Restore"><i class="fas fa-undo"></i></button>
                                </form>
                                <form action="{{ route('admin.blogs.force-delete', $blog->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Permanently delete {{ $blog->title }}?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" title="Delete Permanently"><i class="fas fa-times"></i></button>
                                </form>
                            @else
                                <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this blog?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">{{ request()->has('trashed') ? 'Trash is empty.' : 'No results found.' }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
