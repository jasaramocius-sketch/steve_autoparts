@extends('admin.layouts.app')
@include('partials.page-attributes', ['pageId' => 'admin-images-index-page', 'pageClass' => 'admin-images-index-page'])
@section('page-title', 'Image Manager')
@section('content')
<style>
    .image-card { cursor: pointer; transition: border-color 0.15s, box-shadow 0.15s; position: relative; }
    .image-card:hover { box-shadow: 0 0.25rem 0.5rem rgba(0,0,0,0.08); }
    .image-card.selected { border: 2px solid #0d6efd !important; box-shadow: 0 0 0 0.2rem rgba(13,110,253,0.15); }
    .select-overlay {
        display: none; position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(13,110,253,0.08); z-index: 5; align-items: center; justify-content: center;
    }
    .image-card.selected .select-overlay { display: flex; }
    .select-overlay .check-circle {
        width: 36px; height: 36px; background: #0d6efd; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 2px 6px rgba(0,0,0,0.25);
    }
    .select-overlay .check-circle svg { width: 20px; height: 20px; }
    body.img-bulk-mode .image-card .image-edit-link { pointer-events: none; }
    body.img-bulk-mode .image-card:hover { border-color: #0d6efd !important; }
    .view-toggle .btn { padding: 5px 10px; font-size: 13px; }
    .view-toggle .btn.active { background: #0d6efd; color: #fff; border-color: #0d6efd; }
    #images-container.list-view { display: flex; flex-direction: column; gap: 0; }
    #images-container.list-view .grid-item { width: 100%; }
    #images-container.list-view .image-card { display: flex; align-items: center; border-radius: 0; border-left: none; border-right: none; border-top: none; }
    #images-container.list-view .grid-item + .grid-item { border-top: 1px solid #dee2e6; }
    #images-container.list-view .image-card .thumb-wrap {
        width: 56px; height: 56px; min-width: 56px; border-radius: 6px;
        overflow: hidden; background: #f8f9fa; display: flex; align-items: center; justify-content: center;
    }
    #images-container.list-view .image-card .thumb-wrap img { width: 100%; height: 100%; object-fit: cover; }
    #images-container.list-view .image-card .card-info { flex: 1; padding: 8px 16px; min-width: 0; display: flex; align-items: center; gap: 24px; }
    #images-container.list-view .image-card .card-info .info-name { flex: 2; min-width: 0; }
    #images-container.list-view .image-card .card-info .info-name .text-truncate { font-size: 13px; font-weight: 500; color: #212529; }
    #images-container.list-view .image-card .card-info .info-meta { flex: 1; font-size: 12px; color: #6c757d; white-space: nowrap; }
    #images-container.list-view .image-card .card-info .info-type { flex: 0 0 60px; }
    #images-container.list-view .image-card .card-info .info-usage { flex: 1; }
    #images-container.list-view .image-card .card-info .info-webp { flex: 0 0 70px; text-align: center; }
    #images-container.list-view .image-card .card-info .info-edit { flex: 0 0 40px; text-align: center; }
    #images-container.list-view .image-card .card-info .info-edit a { color: #0d6efd; font-size: 13px; }
    #images-container.list-view .image-card .card-badges { display: none; }
    #images-container.list-view .image-card .select-overlay { width: 56px; height: 56px; min-width: 56px; border-radius: 6px; }
    .list-header {
        display: flex; align-items: center; padding: 8px 16px; background: #f8f9fa;
        border: 1px solid #dee2e6; border-radius: 6px; margin-bottom: 4px; font-size: 11px;
        font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: #6c757d;
    }
    .list-header .lh-name { flex: 2; padding-left: 72px; }
    .list-header .lh-meta { flex: 1; }
    .list-header .lh-type { flex: 0 0 60px; }
    .list-header .lh-usage { flex: 1; }
    .list-header .lh-webp { flex: 0 0 70px; text-align: center; }
    .list-header .lh-edit { flex: 0 0 40px; text-align: center; }
    .list-view-only { display: none; }
    body.list-view-active .list-view-only { display: flex; }
    body.list-view-active .grid-view-only { display: none; }
    #images-container.grid-view {
        display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 16px;
    }
    #images-container.grid-view .grid-item { width: 100%; }
    .bulk-header-normal, .bulk-header-actions { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
    .bulk-header-actions { display: none !important; }
    body.img-bulk-mode .bulk-header-normal { display: none !important; }
    body.img-bulk-mode .bulk-header-actions { display: flex !important; }
    .selected-count { font-weight: 600; color: #0d6efd; }
</style>

<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap flex-md-nowrap">
        <div></div>
        <button type="button" class="btn btn-primary steve-btn" data-bs-toggle="modal" data-bs-target="#uploadModal">
            <i class="fas fa-upload"></i> Upload Images
        </button>
    </div>

    @php $queryParams = array_filter(request()->only(['search', 'sort', 'order'])); @endphp
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <a href="{{ route('admin.images.index', $queryParams) }}" class="text-decoration-none image-manager-stats-card">
                <div class="card border-0 shadow-sm p-3 text-center">
                    <h5 class="fw-bold mb-1">{{ $stats['total'] }}</h5>
                    <small class="text-muted">Total Images</small>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('admin.images.index', ['filter' => 'attached'] + $queryParams) }}" class="text-decoration-none image-manager-stats-card">
                <div class="card border-0 shadow-sm p-3 text-center">
                    <h5 class="fw-bold mb-1">{{ $stats['attached'] }}</h5>
                    <small class="text-muted">Attached</small>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('admin.images.index', ['filter' => 'unused'] + $queryParams) }}" class="text-decoration-none image-manager-stats-card">
                <div class="card border-0 shadow-sm p-3 text-center" style="border-left:3px solid #dc3545;">
                    <h5 class="fw-bold mb-1 text-danger">{{ $stats['unused'] }}</h5>
                    <small class="text-danger">Unused</small>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('admin.images.index', ['filter' => 'convertible'] + $queryParams) }}" class="text-decoration-none image-manager-stats-card">
                <div class="card border-0 shadow-sm p-3 text-center">
                    <h5 class="fw-bold mb-1">{{ $stats['convertible'] }}</h5>
                    <small class="text-muted">Not Yet Converted</small>
                </div>
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-3 flex-wrap flex-md-nowrap">
        <div class="card-body d-flex d-sm-flex gap-1 col-sm-12 col-lg-12 flex-wrap align-items-end">
            <div class="col-lg-4 col-md-12 col-sm-12">
                    <label class="form-label small">Search</label>
                    @include('admin.partials.search-form', [
                        'route' => route('admin.images.index'),
                        'placeholder' => 'Search images...'
                    ])
                </div>
            <form method="GET" class="row align-items-end col-md-12 g-1 col-lg-8 col-sm-12">
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <label class="form-label small">Filter</label>
                    <select name="filter" class="form-select" onchange="this.form.submit()">
                        <option value="">All</option>
                        <option value="attached" {{ request('filter')=='attached'?'selected':'' }}>Attached</option>
                        <option value="unused" {{ request('filter')=='unused'?'selected':'' }}>Unused</option>
                        <option value="convertible" {{ request('filter')=='convertible'?'selected':'' }}>Convertible</option>
                    </select>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <label class="form-label small">Sort</label>
                    <select name="sort" class="form-select">
                        <option value="created_at" {{ request('sort')=='created_at'?'selected':'' }}>Date</option>
                        <option value="original_name" {{ request('sort')=='original_name'?'selected':'' }}>Name</option>
                        <option value="size" {{ request('sort')=='size'?'selected':'' }}>Size</option>
                    </select>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <label class="form-label small">Order</label>
                    <select name="order" class="form-select">
                        <option value="desc" {{ request('order')=='desc'?'selected':'' }}>DESC</option>
                        <option value="asc" {{ request('order')=='asc'?'selected':'' }}>ASC</option>
                    </select>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <button type="submit" class="btn btn-primary w-100 steve-btn"><i class="fas fa-search"></i> Filter</button>
                    @if(request()->hasAny(['search', 'filter', 'sort', 'order']))
                        <a href="{{ route('admin.images.index') }}" class="btn btn-outline-secondary w-100 mt-1 steve-btn"><i class="fas fa-times"></i> Clear Filters</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    @if($images->count())
    <form id="bulk-form" method="POST" action="">
        @csrf
        <div id="bulk-inputs"></div>
        <input type="hidden" name="_method" id="bulk-method" value="POST">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center" style="min-height:48px;">
                <div class="bulk-header-normal">
                    <span>{{ $images->total() }} images found</span>
                    <button type="button" class="btn btn-sm btn-outline-primary steve-btn" onclick="enterBulkMode()">
                        <i class="fas fa-check-double"></i> Bulk Select
                    </button>
                    @if(request('filter') === 'convertible')
                        <button type="button" class="btn btn-sm btn-success steve-btn" onclick="convertAllUnconverted('{{ route('admin.images.bulk-convert') }}')">
                            <i class="fas fa-bolt"></i> Convert All to WebP
                        </button>
                    @endif
                </div>
                <div class="bulk-header-actions">
                    <span><span class="selected-count" id="selected-count">0</span> selected</span>
                    <button type="button" class="btn btn-sm btn-success steve-btn" onclick="bulkAction('{{ route('admin.images.bulk-convert') }}')">
                        <i class="fas fa-exchange-alt"></i> Convert to WebP
                    </button>
                    <button type="button" class="btn btn-sm btn-warning steve-btn" onclick="bulkAction('{{ route('admin.images.bulk-mark-unused') }}')">
                        <i class="fas fa-tag"></i> Mark Unused
                    </button>
                    <button type="button" class="btn btn-sm btn-danger steve-btn" onclick="if(confirm('Delete selected images permanently? This will also delete the physical file.')) bulkAction('{{ route('admin.images.bulk-delete') }}')">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary steve-btn" onclick="exitBulkMode()">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                </div>
                <div class="d-flex gap-1 view-toggle">
                    <button type="button" class="btn btn-outline-secondary btn-sm" id="view-grid-btn" onclick="setView('grid')" title="Grid View">
                        <i class="fas fa-th"></i>
                    </button>
                    <button type="button" class="btn btn-outline-secondary btn-sm" id="view-list-btn" onclick="setView('list')" title="List View">
                        <i class="fas fa-list"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-3">
                <div id="images-header" class="list-header list-view-only" style="display:none;">
                    <div class="lh-name">Name</div>
                    <div class="lh-meta">Size</div>
                    <div class="lh-type">Type</div>
                    <div class="lh-usage">Usage</div>
                    <div class="lh-webp">WebP</div>
                    <div class="lh-edit"><i class="fas fa-pen"></i></div>
                </div>
                <div id="images-container" class="grid-view">
                    @foreach($images as $image)
                    @php $hasWebp = $image->hasWebpVersion(); @endphp
                    <div class="grid-item">
                        <div class="card border h-100 image-card" data-id="{{ $image->id }}" onclick="handleCardClick(this, {{ $image->id }})">
                            <div class="select-overlay">
                                <div class="check-circle">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                </div>
                            </div>
                            @if($hasWebp)
                                <span class="position-absolute top-0 end-0 m-2 badge bg-success" style="z-index:6;" title="Already converted to WebP"><i class="fas fa-check"></i> WebP</span>
                            @endif
                            <a href="{{ route('admin.images.edit', $image->id) }}" class="text-decoration-none text-dark image-edit-link">
                                <div class="thumb-wrap" style="height:140px;overflow:hidden;background:#f8f9fa;display:flex;align-items:center;justify-content:center;">
                                    <img src="{{ $image->thumb_url }}" alt="{{ $image->alt_text ?? $image->original_name }}" style="max-width:100%;max-height:100%;object-fit:contain;" loading="lazy" onerror="this.onerror=null;this.src='{{ asset("assets/images/placeholder.png") }}'">
                                </div>
                                <div class="card-info p-2 small">
                                    <div class="info-name">
                                        <div class="text-truncate fw-medium" title="{{ $image->original_name }}">{{ $image->original_name }}</div>
                                    </div>
                                    <div class="info-meta grid-view-only">{{ $image->size_in_kb }}</div>
                                    <div class="info-meta grid-view-only">{{ $image->width }}x{{ $image->height }}</div>
                                    <div class="card-badges d-flex justify-content-between mt-1 gap-1 flex-wrap grid-view-only">
                                        <span class="badge {{ $image->attachable_type ? 'bg-light text-success border border-success-subtle' : 'bg-light text-secondary border border-secondary-subtle' }}">
                                            {{ $image->attachable_type ? class_basename($image->attachable_type) : 'Unused' }}
                                        </span>
                                        @if(in_array($image->mime_type, ['image/jpeg', 'image/pjpeg', 'image/jpg']))
                                            <span class="badge bg-light text-warning border border-warning-subtle">JPEG</span>
                                        @elseif($image->mime_type === 'image/png')
                                            <span class="badge bg-light text-primary border border-primary-subtle">PNG</span>
                                        @elseif($image->mime_type === 'image/gif')
                                            <span class="badge bg-light text-purple border border-purple-subtle" style="color:#9b59b6;border-color:#d7bde2;">GIF</span>
                                        @elseif($image->mime_type === 'image/webp')
                                            <span class="badge bg-light text-info border border-info-subtle">WebP</span>
                                        @elseif($image->mime_type === 'image/svg+xml')
                                            <span class="badge bg-light text-secondary border border-secondary-subtle">SVG</span>
                                        @endif
                                    </div>
                                    <div class="info-meta list-view-only" style="display:none;">{{ $image->size_in_kb }} | {{ $image->width }}x{{ $image->height }}</div>
                                    <div class="info-type list-view-only" style="display:none;">
                                        @if(in_array($image->mime_type, ['image/jpeg', 'image/pjpeg', 'image/jpg']))
                                            <span class="badge bg-light text-warning border border-warning-subtle">JPEG</span>
                                        @elseif($image->mime_type === 'image/png')
                                            <span class="badge bg-light text-primary border border-primary-subtle">PNG</span>
                                        @elseif($image->mime_type === 'image/gif')
                                            <span class="badge bg-light border" style="color:#9b59b6;border-color:#d7bde2;">GIF</span>
                                        @elseif($image->mime_type === 'image/webp')
                                            <span class="badge bg-light text-info border border-info-subtle">WebP</span>
                                        @elseif($image->mime_type === 'image/svg+xml')
                                            <span class="badge bg-light text-secondary border border-secondary-subtle">SVG</span>
                                        @endif
                                    </div>
                                    <div class="info-usage list-view-only" style="display:none;">
                                        <span class="badge {{ $image->attachable_type ? 'bg-light text-success border border-success-subtle' : 'bg-light text-secondary border border-secondary-subtle' }}">
                                            {{ $image->attachable_type ? class_basename($image->attachable_type) : 'Unused' }}
                                        </span>
                                    </div>
                                    <div class="info-webp list-view-only" style="display:none;">
                                        @if($hasWebp)
                                            <span class="badge bg-success text-white"><i class="fas fa-check"></i></span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </div>
                                    <div class="info-edit list-view-only" style="display:none;">
                                        <a href="{{ route('admin.images.edit', $image->id) }}"><i class="fas fa-pen"></i></a>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </form>

    <div class="mt-3 d-flex justify-content-center">
        {{ $images->links() }}
    </div>
    @else
    <div class="card border-0 shadow-sm">
        <div class="card-body text-center py-5 text-muted">
            <i class="fas fa-image fa-3x mb-3 flex-wrap flex-md-nowrap"></i>
            <p>No images found.</p>
        </div>
    </div>
    @endif
</div>
<div class="modal fade" id="uploadModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.images.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-upload me-2"></i>Upload Images</h5>
                    <button type="button" class="btn-close steve-btn" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 flex-wrap flex-md-nowrap">
                        <label class="form-label">Select Images <span class="text-danger">*</span></label>
                        <input type="file" name="images[]" class="form-control" multiple accept="image/*" required>
                        <div class="form-text">Allowed: jpeg, png, jpg, gif, svg, webp. Max 10MB per file.</div>
                    </div>
                    <div id="upload-preview" class="row g-2"></div>
                    <hr>
                    <div class="mb-2">
                        <label class="form-label">Or download from a URL</label>
                        <div class="d-flex gap-2">
                            <input type="url" id="image-url-input" class="form-control" placeholder="https://example.com/image.jpg" autocomplete="off">
                            <button type="button" id="image-url-btn" class="btn btn-outline-secondary text-nowrap">
                                <i class="fas fa-download me-1"></i> Download URL
                            </button>
                        </div>
                        <div id="image-url-error" class="text-danger small mt-1"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary steve-btn" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary steve-btn"><i class="fas fa-upload"></i> Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function() {
    let bulkMode = false;
    const selectedIds = new Set();
    const checkSvg = '<svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>';

    document.querySelector('input[name="images[]"]')?.addEventListener('change', function() {
        const preview = document.getElementById('upload-preview');
        preview.innerHTML = '';
        Array.from(this.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const col = document.createElement('div');
                col.className = 'col-4 col-md-3';
                col.innerHTML = '<div class="card border p-1"><img src="' + e.target.result + '" class="img-fluid rounded" style="height:80px;width:100%;object-fit:cover;"></div>';
                preview.appendChild(col);
            };
            reader.readAsDataURL(file);
        });
    });

    window.enterBulkMode = function() {
        bulkMode = true;
        document.body.classList.add('img-bulk-mode');
    };

    window.exitBulkMode = function() {
        bulkMode = false;
        document.body.classList.remove('img-bulk-mode');
        selectedIds.clear();
        document.querySelectorAll('.image-card.selected').forEach(c => c.classList.remove('selected'));
        syncHiddenInputs();
        updateBulkHeader();
    };

    window.handleCardClick = function(card, id) {
        if (!bulkMode) {
            window.location.href = card.querySelector('.image-edit-link')?.href || '#';
            return;
        }
        if (selectedIds.has(id)) {
            selectedIds.delete(id);
            card.classList.remove('selected');
        } else {
            selectedIds.add(id);
            card.classList.add('selected');
        }
        syncHiddenInputs();
        updateBulkHeader();
    };

    function updateBulkHeader() {
        const count = selectedIds.size;
        document.getElementById('selected-count').textContent = count;
    }

    function syncHiddenInputs() {
        const container = document.getElementById('bulk-inputs');
        container.innerHTML = '';
        selectedIds.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'ids[]';
            input.value = id;
            container.appendChild(input);
        });
    }

    window.bulkAction = function(url) {
        if (selectedIds.size === 0) { alert('Please select at least one image.'); return; }
        document.getElementById('bulk-form').action = url;
        document.getElementById('bulk-form').submit();
    };

    window.convertAllUnconverted = function(url) {
        if (!confirm('Convert all unconverted images on this page to WebP?')) return;
        document.querySelectorAll('.image-card').forEach(card => {
            const id = parseInt(card.dataset.id);
            selectedIds.add(id);
            card.classList.add('selected');
        });
        syncHiddenInputs();
        updateBulkHeader();
        document.getElementById('bulk-form').action = url;
        document.getElementById('bulk-form').submit();
    };

    window.setView = function(mode) {
        const container = document.getElementById('images-container');
        const header = document.getElementById('images-header');
        const gridBtn = document.getElementById('view-grid-btn');
        const listBtn = document.getElementById('view-list-btn');
        localStorage.setItem('image-manager-view', mode);
        if (mode === 'list') {
            container.classList.remove('grid-view');
            container.classList.add('list-view');
            document.body.classList.add('list-view-active');
            listBtn.classList.add('active');
            gridBtn.classList.remove('active');
            if (header) header.style.display = 'flex';
        } else {
            container.classList.remove('list-view');
            container.classList.add('grid-view');
            document.body.classList.remove('list-view-active');
            gridBtn.classList.add('active');
            listBtn.classList.remove('active');
            if (header) header.style.display = 'none';
        }
    };

    const savedView = localStorage.getItem('image-manager-view') || 'grid';
    setView(savedView);

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && bulkMode) exitBulkMode();
    });
})();
</script>
@endpush
