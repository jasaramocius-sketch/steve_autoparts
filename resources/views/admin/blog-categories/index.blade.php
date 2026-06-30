@extends('admin.layouts.app')
@section('page-title', 'Blog Categories')
@section('content')

@php $trashedCount = \App\Models\BlogCategory::onlyTrashed()->count(); @endphp

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0">Blog Categories</h4>
    <a href="{{ route('admin.blog-categories.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add Blog Category</a>
</div>

<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a class="nav-link {{ !request()->has('trashed') ? 'active' : '' }}" href="{{ route('admin.blog-categories.index') }}">Active</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->has('trashed') ? 'active' : '' }}" href="{{ route('admin.blog-categories.index', ['trashed' => 1]) }}">Trash ({{ $trashedCount }})</a>
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
                        <th>Name</th>
                        <th>Parent Category</th>
                        <th>Slug</th>
                        <th>Blog</th>
                        <th>Status</th>
                        <th class="pe-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $cat)
                    <tr>
                        <td class="ps-3">{{ $cat->id }}</td>
                        <td>{{ $cat->name }}</td>
                        <td>{{ $cat->parent?->name ?? "—" }}</td>
                        <td><code>{{ $cat->slug }}</code></td>
                        <td>{{ $cat->blogs_count }}</td>
                        <td>
                            @if(request()->has('trashed'))
                                <span class="badge bg-secondary">Deleted</span>
                            @else
                                <span class="badge {{ $cat->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                    {{ ucfirst($cat->status) }}
                                </span>
                            @endif
                        </td>
                        <td class="pe-3">
                            @if(request()->has('trashed'))
                                <form action="{{ route('admin.blog-categories.restore', $cat->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-success" title="Restore"><i class="fas fa-undo"></i></button>
                                </form>
                                <form action="{{ route('admin.blog-categories.force-delete', $cat->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Permanently delete {{ $cat->name }}?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" title="Delete Permanently"><i class="fas fa-times"></i></button>
                                </form>
                            @else
                                <a href="{{ route('admin.blog-categories.edit', $cat->id) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.blog-categories.destroy', $cat->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete {{ $cat->name }}?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">{{ request()->has('trashed') ? 'Trash is empty.' : 'No results found.' }}</td>
                    </tr>   
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
