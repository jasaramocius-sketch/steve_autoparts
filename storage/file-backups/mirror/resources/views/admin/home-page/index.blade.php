@extends('admin.layouts.app')
{{-- Add your custom page ID and classes right here --}}
@section('page-id', 'admin-home-index-page')
@section('page-class', 'admin-home-index-page')
@section('page-title', 'Manage Home Page')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0">Home Page Sections</h4>
                <!-- <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Back to Dashboard</a> -->
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <!-- <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Home Page Sections</h5>
                </div> -->
                <div class="card-body">
                    @if($sections->count() > 0)
                        <div class="d-flex justify-content-between align-items-center pb-2">
                            <div class="d-flex align-items-center gap-2">
                                <span class="text-muted small">Show</span>
                                <select class="form-selectge="window.location.href=this.value">
                                    @foreach([10, 20, 50, 100] as $n)
                                        <option value="{{ request()->fullUrlWithQuery(['per_page' => $n]) }}" {{ (int)request('per_page', 10) === $n ? 'selected' : '' }}>{{ $n }}</option>
                                    @endforeach
                                </select>
                                <span class="text-muted small">per page</span>
                            </div>
                            <div class="text-muted small">
                                Showing {{ $sections->firstItem() }}-{{ $sections->lastItem() }} of {{ $sections->total() }}
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th><a href="{{ sortUrl('section_name', $sortBy, $sortDir) }}" class="text-decoration-none text-dark">Section Name {!! sortIndicator('section_name', $sortBy, $sortDir) !!}</a></th>
                                        <th><a href="{{ sortUrl('title', $sortBy, $sortDir) }}" class="text-decoration-none text-dark">Title {!! sortIndicator('title', $sortBy, $sortDir) !!}</a></th>
                                        <th><a href="{{ sortUrl('status', $sortBy, $sortDir) }}" class="text-decoration-none text-dark">Status {!! sortIndicator('status', $sortBy, $sortDir) !!}</a></th>
                                        <th><a href="{{ sortUrl('order', $sortBy, $sortDir) }}" class="text-decoration-none text-dark">Order {!! sortIndicator('order', $sortBy, $sortDir) !!}</a></th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($sections as $section)
                                        <tr>
                                            <td>
                                                <strong>{{ ucfirst(str_replace('_', ' ', $section->section_name)) }}</strong>
                                            </td>
                                            <td>{{ Str::limit($section->title, 50) }}</td>
                                            <td>
                                                <span class="badge {{ $section->status ? 'bg-light text-success border border-success-subtle' : 'bg-light text-danger border border-danger-subtle' }}">
                                                    {{  $section->status ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td>{{ $section->order }}</td>
                                            <td class="pe-3 table-action-col">
                                                <div class="action-buttons">
                                                    <a href="{{ route('admin.home-page.edit', $section->id) }}" class="action-btn btn-edit" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Edit"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-muted">No sections found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if($sections->hasPages())
                            <div class="d-flex justify-content-center py-3">{{ $sections->links() }}</div>
                        @endif
                    @else
                        <div class="alert alert-info">
                            No sections found. Please run migrations to initialize home page sections.
                            <br><br>
                            <code>php artisan migrate</code>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .table-hover tbody tr:hover {
        background-color: #f5f5f5;
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
</style>
@endsection
