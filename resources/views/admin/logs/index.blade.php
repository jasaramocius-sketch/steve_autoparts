@extends('admin.layouts.app')
{{-- Add your custom page ID and classes right here --}}
@include('partials.page-attributes', ['pageId' => 'admin-logs-index-page', 'pageClass' => 'admin-logs-index-page'])
@section('page-title', 'Logs')
@section('meta_tags')
    @include('partials.meta-tags', [
        'pageTitle' => 'Logs - Admin Panel',
        'robots' => 'noindex, nofollow',
    ])
@endsection

@section('content')

@php
    $badgeColors = [
        'change'   => 'bg-warning-subtle text-warning border border-warning-subtle',
        'request'  => 'bg-info-subtle text-info border border-info-subtle',
        'info'     => 'bg-primary-subtle text-primary border border-primary-subtle',
        'auth'     => 'bg-primary-subtle text-primary border border-primary-subtle',
        'created'  => 'bg-success-subtle text-success border border-success-subtle',
        'modified' => 'bg-secondary-subtle text-secondary border border-secondary-subtle',
        'deleted'  => 'bg-danger-subtle text-danger border border-danger-subtle',
        'error'    => 'bg-danger-subtle text-danger border border-danger-subtle',
        'warning'  => 'bg-warning-subtle text-warning border border-warning-subtle',
    ];
@endphp

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom d-flex flex-wrap gap-2 justify-content-between align-items-center py-3">
        <h5 class="mb-0 fw-bold"><i class="fas fa-file-alt me-2"></i>Site Logs</h5>
        <form method="GET" action="{{ route('admin.logs.index') }}" class="d-flex flex-wrap align-items-end gap-2">
            <div>
                <label class="form-label small mb-1 d-block">Log File</label>
                <select name="file" class="form-select" onchange="this.form.submit()">
                    <option value="">Select log file</option>
                    @foreach($files as $file)
                        <option value="{{ $file }}" {{ $selectedFile === $file ? 'selected' : '' }}>{{ $file }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label small mb-1 d-block">Type</label>
                <select name="type" class="form-select" onchange="this.form.submit()">
                    <option value="all" {{ ($typeFilter ?? 'change') === 'all' ? 'selected' : '' }}>All types</option>
                    @foreach($types as $type)
                        <option value="{{ $type }}" {{ ($typeFilter ?? 'change') === $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label small mb-1 d-block">Search</label>
                <input type="text" name="search" value="{{ $search ?? '' }}" class="form-control" placeholder="Search logs..." style="width:200px">
            </div>
            <button type="submit" class="btn btn-primary steve-btn gap-1"><i class="fas fa-search"></i> Search</button>
            @if(!empty($search) || !empty($typeFilter))
                <a href="{{ route('admin.logs.index', ['file' => $selectedFile]) }}" class="btn btn-outline-secondary steve-btn gap-1"><i class="fas fa-times"></i> Clear</a>
            @endif
        </form>
    </div>
    <div class="card-body">
        @if($selectedFile)
            <div class="mb-2 text-muted small">Showing: {{ $selectedFile }} <span class="mx-1">|</span> {{ $entries->total() }} entries</div>

            @if($entries->total())
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">#</th>
                                <th style="width:200px">Timestamp</th>
                                <th style="width:110px">Type</th>
                                <th>Message</th>
                                <th>User</th>
                                <th class="pe-3">Context</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($entries as $entry)
                            <tr>
                                <td class="ps-3 text-muted">{{ $entries->firstItem() + $loop->index }}</td>
                                <td class="text-nowrap small">
                                    @if($entry['timestamp'])
                                        {{ \Illuminate\Support\Carbon::parse($entry['timestamp'])->format('Y-m-d H:i:s') }}
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $badgeColors[$entry['type']] ?? 'bg-light text-secondary border border-secondary-subtle' }} border">
                                        {{ ucfirst($entry['type']) }}
                                    </span>
                                </td>
                                <td>{{ $entry['message'] }}</td>
                                <td class="text-nowrap small">
                                    @if(!empty($entry['context']['user_id']))
                                        <span class="fw-semibold">{{ $entry['context']['user_name'] ?? 'User #' . $entry['context']['user_id'] }}</span>
                                        @if(!empty($entry['context']['user_email']))
                                            <br><span class="text-muted">{{ $entry['context']['user_email'] }}</span>
                                        @endif
                                    @else
                                        <span class="text-muted">Guest</span>
                                    @endif
                                </td>
                                <td class="pe-3">
                                    @if(!empty($entry['context']))
                                        <button type="button" class="btn btn-sm btn-outline-secondary steve-btn" data-bs-toggle="collapse" data-bs-target="#log-context-{{ $loop->index }}">View</button>
                                    @else
                                        <span class="text-muted small">—</span>
                                    @endif
                                </td>
                            </tr>
                            @if(!empty($entry['context']))
                            <tr class="collapse" id="log-context-{{ $loop->index }}">
                                <td colspan="6" class="ps-3">
                                    <pre class="admin-code-block bg-dark text-light p-3 rounded mb-0"><code>{{ json_encode($entry['context'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) }}</code></pre>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($entries->hasPages())
                    <div class="d-flex justify-content-center py-3">{{ $entries->links('vendor.pagination.gs-pagination') }}</div>
                @endif
            @else
                <div class="alert alert-info mb-0">No entries found for this file / search.</div>
            @endif
        @else
            <div class="alert alert-warning mb-0">No log files found yet.</div>
        @endif
    </div>
</div>

@endsection
