@extends('admin.layouts.app')
@section('page-title', 'Brands')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0">All Brands</h4>
    <a href="{{ route('admin.brands.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add Brand</a>
</div>

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
                        <th>Name</th>
                        <th>Website</th>
                        <th>Status</th>
                        <th class="pe-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($brands as $brand)
                    <tr>
                        <td class="ps-3">{{ $brand->id }}</td>
                        <td>
                            @if($brand->image)
                                <img src="{{ asset('assets/images/brands/' . $brand->image) }}" width="50" height="50" style="object-fit:cover; border-radius:4px;">
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>{{ $brand->name }}</td>
                        <td>
                            @if($brand->website)
                                <a href="{{ $brand->website }}" target="_blank">{{ $brand->website }}</a>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('admin.brands.toggle-status', $brand->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm border-0 p-0">
                                    <span class="badge {{ $brand->status ? 'bg-success' : 'bg-danger' }}" style="cursor:pointer;">
                                        {{  $brand->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </button>
                            </form>
                        </td>
                        <td class="pe-3">
                            <a href="{{ route('admin.brands.edit', $brand->id) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete {{ $brand->name }}?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">No results found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
