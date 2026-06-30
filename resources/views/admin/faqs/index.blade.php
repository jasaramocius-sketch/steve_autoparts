@extends('admin.layouts.app')
@section('page-title', 'FAQs')
@section('content')

@php $trashedCount = \App\Models\Faq::onlyTrashed()->count(); @endphp

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0">All FAQs</h4>
    <a href="{{ route('admin.faqs.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add FAQ</a>
</div>

<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a class="nav-link {{ !request()->has('trashed') ? 'active' : '' }}" href="{{ route('admin.faqs.index') }}">Active</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->has('trashed') ? 'active' : '' }}" href="{{ route('admin.faqs.index', ['trashed' => 1]) }}">Trash ({{ $trashedCount }})</a>
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
                        <th>Question</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th>Updated</th>
                        <th class="pe-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($faqs as $faq)
                    <tr>
                        <td class="ps-3">{{ $faq->id }}</td>
                        <td>{{ Str::limit($faq->question, 60) }}</td>
                        <td>{{ $faq->order }}</td>
                        <td>
                            @if(request()->has('trashed'))
                                <span class="badge bg-secondary">Deleted</span>
                            @else
                                <form action="{{ route('admin.faqs.toggle-status', $faq->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm border-0 p-0">
                                        <span class="badge {{ $faq->status ? 'bg-success' : 'bg-danger' }}" style="cursor:pointer;">
                                            {{ $faq->status ? 'Active' : 'Inactive' }}
                                        </span>
                                    </button>
                                </form>
                            @endif
                        </td>
                        <td>{{ $faq->updated_at ? $faq->updated_at->format('d M Y') : '—' }}</td>
                        <td class="pe-3">
                            @if(request()->has('trashed'))
                                <form action="{{ route('admin.faqs.restore', $faq->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-success" title="Restore"><i class="fas fa-undo"></i></button>
                                </form>
                                <form action="{{ route('admin.faqs.force-delete', $faq->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Permanently delete this FAQ?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" title="Delete Permanently"><i class="fas fa-times"></i></button>
                                </form>
                            @else
                                <a href="{{ route('admin.faqs.edit', $faq->id) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.faqs.destroy', $faq->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this FAQ?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">{{ request()->has('trashed') ? 'Trash is empty.' : 'No FAQs found.' }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
