@extends('admin.layouts.app')
@section('page-title', 'Image Manager')
@section('content')
<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0"><i class="fas fa-images me-2"></i>Image Manager</h4>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    {{-- Stats Cards --}}
    @php $queryParams = array_filter(request()->only(['search', 'sort', 'order'])); @endphp
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <a href="{{ route('admin.images.index', $queryParams) }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm p-3 text-center">
                    <h5 class="fw-bold mb-1">{{ $stats['total'] }}</h5>
                    <small class="text-muted">Total Images</small>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('admin.images.index', ['filter' => 'attached'] + $queryParams) }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm p-3 text-center">
                    <h5 class="fw-bold mb-1">{{ $stats['attached'] }}</h5>
                    <small class="text-muted">Attached</small>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('admin.images.index', ['filter' => 'unused'] + $queryParams) }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm p-3 text-center" style="border-left:3px solid #dc3545;">
                    <h5 class="fw-bold mb-1 text-danger">{{ $stats['unused'] }}</h5>
                    <small class="text-danger">Unused</small>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('admin.images.index', ['filter' => 'convertible'] + $queryParams) }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm p-3 text-center">
                    <h5 class="fw-bold mb-1">{{ $stats['convertible'] }}</h5>
                    <small class="text-muted">Convertible to WebP</small>
                </div>
            </a>
        </div>
    </div>

    {{-- Filters --}}
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" class="row g-2 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small">Search</label>
                    <input type="text" name="search" class="form-control" placeholder="Filename, alt text, title..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label small">Filter</label>
                    <select name="filter" class="form-select" onchange="this.form.submit()">
                        <option value="">All</option>
                        <option value="attached" {{ request('filter')=='attached'?'selected':'' }}>Attached</option>
                        <option value="unused" {{ request('filter')=='unused'?'selected':'' }}>Unused</option>
                        <option value="convertible" {{ request('filter')=='convertible'?'selected':'' }}>Convertible</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small">Sort</label>
                    <select name="sort" class="form-select">
                        <option value="created_at" {{ request('sort')=='created_at'?'selected':'' }}>Date</option>
                        <option value="original_name" {{ request('sort')=='original_name'?'selected':'' }}>Name</option>
                        <option value="size" {{ request('sort')=='size'?'selected':'' }}>Size</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small">Order</label>
                    <select name="order" class="form-select">
                        <option value="desc" {{ request('order')=='desc'?'selected':'' }}>DESC</option>
                        <option value="asc" {{ request('order')=='asc'?'selected':'' }}>ASC</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i> Filter</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Bulk Actions --}}
    @if($images->count())
    <form id="bulk-form" method="POST" action="">
        @csrf
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <input type="checkbox" id="select-all" class="form-check-input" onchange="toggleSelectAll(this)">
                    <span>{{ $images->total() }} images found</span>
                </div>
                <div class="d-flex gap-2" id="bulk-actions" style="display:none;">
                    <button type="button" class="btn btn-sm btn-success" onclick="bulkAction('{{ route('admin.images.bulk-convert') }}')">
                        <i class="fas fa-exchange-alt"></i> Convert to WebP
                    </button>
                    <button type="button" class="btn btn-sm btn-warning" onclick="bulkAction('{{ route('admin.images.bulk-mark-unused') }}')">
                        <i class="fas fa-tag"></i> Mark Unused
                    </button>
                    <button type="button" class="btn btn-sm btn-danger" onclick="if(confirm('Delete selected images permanently? This will also delete the physical file.')) bulkAction('{{ route('admin.images.bulk-delete') }}')">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </div>
            </div>
            <div class="card-body p-3">
                <div class="row g-3">
                    @foreach($images as $image)
                    <div class="col-md-3 col-lg-2">
                        <div class="card border h-100 position-relative">
                            <label class="position-absolute top-0 start-0 p-2 z-1" style="cursor:pointer;">
                                <input type="checkbox" name="ids[]" value="{{ $image->id }}" class="form-check-input image-checkbox" onchange="toggleBulk()">
                            </label>
                            <a href="{{ route('admin.images.edit', $image->id) }}" class="text-decoration-none text-dark">
                                <div style="height:140px;overflow:hidden;background:#f8f9fa;display:flex;align-items:center;justify-content:center;">
                                    <img src="{{ $image->thumb_url }}" alt="{{ $image->alt_text ?? $image->original_name }}" style="max-width:100%;max-height:100%;object-fit:contain;" loading="lazy" onerror="this.onerror=null;this.src='{{ asset("assets/images/placeholder.png") }}'">
                                </div>
                                <div class="p-2 small">
                                    <div class="text-truncate fw-medium" title="{{ $image->original_name }}">{{ $image->original_name }}</div>
                                    <div class="text-muted">{{ $image->size_in_kb }} | {{ $image->width }}x{{ $image->height }}</div>
                                    <div class="d-flex justify-content-between mt-1">
                                        <span class="badge bg-{{ $image->attachable_type ? 'success' : 'secondary' }}">
                                            {{ $image->attachable_type ? class_basename($image->attachable_type) : 'Unused' }}
                                        </span>
                                        @if(in_array($image->mime_type, ['image/jpeg', 'image/pjpeg']))
                                            <span class="badge bg-warning text-dark">JPEG</span>
                                        @endif
                                        @if($image->mime_type === 'image/webp')
                                            <span class="badge bg-info">WebP</span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <input type="hidden" name="_method" id="bulk-method" value="POST">
    </form>

    <div class="mt-3 d-flex justify-content-center">
        {{ $images->links() }}
    </div>
    @else
    <div class="card border-0 shadow-sm">
        <div class="card-body text-center py-5 text-muted">
            <i class="fas fa-image fa-3x mb-3"></i>
            <p>No images found.</p>
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function toggleSelectAll(master) {
    document.querySelectorAll('.image-checkbox').forEach(cb => {
        cb.checked = master.checked;
    });
    toggleBulk();
}

function toggleBulk() {
    const checked = document.querySelectorAll('.image-checkbox:checked').length;
    const el = document.getElementById('bulk-actions');
    el.style.display = checked > 0 ? 'inline-flex' : 'none';
    document.getElementById('select-all').checked = checked > 0 && checked === document.querySelectorAll('.image-checkbox').length;
}

function bulkAction(url) {
    const form = document.getElementById('bulk-form');
    form.action = url;
    form.submit();
}
</script>
@endpush
