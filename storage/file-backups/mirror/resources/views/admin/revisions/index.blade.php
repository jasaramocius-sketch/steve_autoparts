@extends('admin.layouts.app')
{{-- Add your custom page ID and classes right here --}}
@section('page-id', 'admin-revisions-index-page')
@section('page-class', 'admin-revisions-index-page')
@section('page-title', 'Revisions')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <!-- <h4 class="fw-bold mb-0">Revisions History</h4> -->
</div>

<div class="card border-0 shadow-sm revisions-page-table">
    <div class="card-body p-0">
        <div class="d-flex justify-content-between align-items-center px-3 pt-3 pb-2">
            <div class="d-flex align-items-center gap-2">
                <span class="text-muted small">Show</span>
                <select class="form-select form-select-sm" style="width: auto;" onchange="window.location.href=this.value">
                    @foreach([10, 20, 50, 100] as $n)
                        <option value="{{ request()->fullUrlWithQuery(['per_page' => $n]) }}" {{ (int)request('per_page', 20) === $n ? 'selected' : '' }}>{{ $n }}</option>
                    @endforeach
                </select>
                <span class="text-muted small">per page</span>
            </div>
            <div class="text-muted small">
                Showing {{ $revisions->firstItem() }}-{{ $revisions->lastItem() }} of {{ $revisions->total() }}
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3"><a href="{{ sortUrl('id', $sortBy, $sortDir) }}" class="text-decoration-none text-dark"># {!! sortIndicator('id', $sortBy, $sortDir) !!}</a></th>
                        <th>User</th>
                        <th><a href="{{ sortUrl('model_type', $sortBy, $sortDir) }}" class="text-decoration-none text-dark">Model {!! sortIndicator('model_type', $sortBy, $sortDir) !!}</a></th>
                        <th>Record ID</th>
                        <th><a href="{{ sortUrl('action', $sortBy, $sortDir) }}" class="text-decoration-none text-dark">Action {!! sortIndicator('action', $sortBy, $sortDir) !!}</a></th>
                        <th>URL</th>
                        <th>Actions</th>
                        <th class="pe-3"><a href="{{ sortUrl('created_at', $sortBy, $sortDir) }}" class="text-decoration-none text-dark">Date {!! sortIndicator('created_at', $sortBy, $sortDir) !!}</a></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($revisions as $rev)
                    <tr>
                        <td class="ps-3">{{ $rev->id }}</td>
                        <td>
                            @if($rev->user)
                                {{ $rev->user->name }}
                                <div class="text-muted small">{{ $rev->user->email }}</div>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $short = class_basename($rev->model_type);
                            @endphp
                            {{ $short }}
                        </td>
                        <td>#{{ $rev->model_id }}</td>
                        <td>
                            @if($rev->action === 'created')
                                <span class="badge bg-light text-success border border-success-subtle">Created</span>
                            @elseif($rev->action === 'updated')
                                <span class="badge bg-light text-primary border border-primary-subtle">Updated</span>
                            @elseif($rev->action === 'deleted')
                                <span class="badge bg-light text-danger border border-danger-subtle">Deleted</span>
                            @else
                                <span class="badge bg-secondary">{{ $rev->action }}</span>
                            @endif
                        </td>
                        <td style="max-width: 250px;">
                            @if($rev->url)
                                <span class="small text-muted" title="{{ $rev->url }}">{{ \Illuminate\Support\Str::limit($rev->url, 40) }}</span>
                            @else
                                <span class="text-muted small">—</span>
                            @endif
                        </td>
                        <td class="table-action-col">
                            <div class="action-buttons revision-action-buttons">
                            <a href="{{ route('admin.revisions.detail', $rev->id) }}" class="btn btn-sm btn-outline-info" title="View Details">
                                <i class="fas fa-code-branch"></i> Diff
                            </a>
                            </div>
                        </td>
                        <td class="pe-3 text-nowrap small text-muted">
                            {{ $rev->created_at->format('d M Y H:i') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">No revisions found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($revisions->hasPages())
            <div class="d-flex justify-content-center py-3">{{ $revisions->links() }}</div>
        @endif
    </div>
</div>

@endsection
