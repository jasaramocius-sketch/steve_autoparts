@extends('admin.layouts.app')
{{-- Add your custom page ID and classes right here --}}
@include('partials.page-attributes', ['pageId' => 'admin-file-revisions-page', 'pageClass' => 'admin-file-revisions-page'])
@section('page-title', 'File Revisions')
@section('meta_tags')
    @include('partials.meta-tags', [
        'pageTitle' => 'File Revisions - Admin Panel',
        'robots' => 'noindex, nofollow',
    ])
@endsection
@section('content')

<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap flex-md-nowrap">
    <!-- <h4 class="fw-bold mb-0">File Revisions</h4> -->
    <div>
        <span class="text-muted small me-2">Next scan: via cron</span>
        <a href="{{ route('admin.file-revisions.index') }}" class="btn btn-sm btn-outline-secondary"><i class="fas fa-sync"></i> Refresh</a>
    </div>
</div>

<div class="card border-0 shadow-sm mb-3">
    <div class="card-header bg-white py-2 d-flex justify-content-between align-items-center" data-bs-toggle="collapse" data-bs-target="#maintenancePanel" style="cursor:pointer;">
        <span class="small fw-semibold"><i class="fas fa-broom me-1"></i> Maintenance</span>
        <i class="fas fa-chevron-down small text-muted"></i>
    </div>
    <div id="maintenancePanel" class="collapse">
        <div class="card-body">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card border bg-light h-100">
                        <div class="card-body">
                            <h6 class="card-title fw-semibold small"><i class="fas fa-compress-alt me-1"></i> Per-File Limit</h6>
                            <p class="text-muted small mb-2">Keep only the last N revisions per file. Older diffs are truncated to 200 chars. Rows and backup files are preserved.</p>
                            <form action="{{ route('admin.file-revisions.truncate-per-file') }}" method="POST" class="d-flex gap-2 align-items-end"
                                  onsubmit="return confirm('This will truncate diff text beyond the per-file limit. Revisions and backups are preserved. Continue?')">
                                @csrf
                                <div>
                                    <label class="form-label small">Keep last (per file)</label>
                                    <input type="number" name="keep_per_file" value="50" min="5" max="500" class="form-control form-control-sm" style="width:120px;">
                                </div>
                                <button type="submit" class="btn btn-warning btn-sm"><i class="fas fa-filter me-1"></i> Apply Limit</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border bg-light h-100">
                        <div class="card-body">
                            <h6 class="card-title fw-semibold small"><i class="fas fa-clock me-1"></i> Age-Based Truncate</h6>
                            <p class="text-muted small mb-2">Replace large diff text on rows older than N days with a 200-char summary. Revisions and backup files are preserved.</p>
                            <form action="{{ route('admin.file-revisions.truncate-diffs') }}" method="POST" class="d-flex gap-2 align-items-end"
                                  onsubmit="return confirm('This will truncate diff text on rows older than N days. Revisions and backups are preserved. Continue?')">
                                @csrf
                                <div>
                                    <label class="form-label small">Older than (days)</label>
                                    <input type="number" name="older_than_days" value="90" min="1" max="3650" class="form-control form-control-sm" style="width:120px;">
                                </div>
                                <button type="submit" class="btn btn-warning btn-sm"><i class="fas fa-compress-alt me-1"></i> Truncate Diffs</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm file-revisions-table">
    <div class="card-body p-0">
        <div class="d-flex justify-content-between align-items-center px-3 pt-3 pb-2 flex-wrap flex-md-nowrap flex-wrap flex-md-nowrap">
            <div class="d-flex align-items-center gap-2">
                <span class="text-muted small">Show</span>
                <select class="form-select w-auto" onchange="window.location.href=this.value">
                    @foreach([10, 20, 50, 100] as $n)
                        <option value="{{ request()->fullUrlWithQuery(['per_page' => $n, 'page' => null]) }}" {{ (int)request('per_page', 20) === $n ? 'selected' : '' }}>{{ $n }}</option>
                    @endforeach
                </select>
                <span class="text-muted small">per page</span>
            </div>
            @include('admin.partials.date-range-filter', ['filterRoute' => 'admin.file-revisions.index'])
            <div class="text-muted small">
                Showing {{ $fileRevisions->firstItem() }}-{{ $fileRevisions->lastItem() }} of {{ $fileRevisions->total() }}
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3"><a href="{{ sortUrl('id', $sortBy, $sortDir) }}" class="text-decoration-none text-dark"># {!! sortIndicator('id', $sortBy, $sortDir) !!}</a></th>
                        <th><a href="{{ sortUrl('file_path', $sortBy, $sortDir) }}" class="text-decoration-none text-dark">File {!! sortIndicator('file_path', $sortBy, $sortDir) !!}</a></th>
                        <th><a href="{{ sortUrl('event', $sortBy, $sortDir) }}" class="text-decoration-none text-dark">Event {!! sortIndicator('event', $sortBy, $sortDir) !!}</a></th>
                        <th>User</th>
                        <th>Actions</th>
                        <th class="pe-3"><a href="{{ sortUrl('created_at', $sortBy, $sortDir) }}" class="text-decoration-none text-dark">Date {!! sortIndicator('created_at', $sortBy, $sortDir) !!}</a></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($fileRevisions as $rev)
                    <tr>
                        <td class="ps-3">{{ $rev->id }}</td>
                        <td class="file-path-cell">
                            <code>{{ $rev->file_path }}</code>
                        </td>
                        <td>
                            @if($rev->event === 'created')
                                <span class="badge bg-light text-success border border-success-subtle">Created</span>
                            @elseif($rev->event === 'updated')
                                <span class="badge bg-light text-primary border border-primary-subtle">Updated</span>
                            @elseif($rev->event === 'deleted')
                                <span class="badge bg-light text-danger border border-danger-subtle">Deleted</span>
                            @else
                                <span class="badge bg-light text-secondary border border-secondary-subtle">{{ $rev->event }}</span>
                            @endif
                        </td>
                        <td>
                            @if($rev->user)
                                {{ $rev->user->name }}
                            @else
                                <span class="text-muted small">System</span>
                            @endif
                        </td>
                        <td class="table-action-col">
                            <div class="d-flex gap-1 action-buttons revision-action-buttons">
                                <a href="{{ route('admin.file-revisions.diff', $rev->id) }}" class="btn btn-outline-info steve-btn" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="View Diff">
                                    <i class="fas fa-code-branch"></i>
                                </a>
                                @if($rev->backup_path)
                                    <a href="{{ route('admin.file-revisions.download', $rev->id) }}" class="btn btn-outline-secondary steve-btn" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Download backup">
                                        <i class="fas fa-download"></i>
                                    </a>
                                @endif
                            </div>
                        </td>
                        <td class="pe-3 text-nowrap small text-muted">
                            {{ $rev->created_at->format('d M Y H:i') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">No file revisions recorded yet. Run <code>php artisan file:audit --watch</code> or set up a cron job.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($fileRevisions->hasPages())
            <div class="d-flex justify-content-center py-3">{{ $fileRevisions->links('vendor.pagination.gs-pagination') }}</div>
        @endif
    </div>
</div>

@endsection
