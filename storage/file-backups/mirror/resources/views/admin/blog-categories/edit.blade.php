@extends('admin.layouts.app')
@section('page-title', 'Edit Blog Category')
@section('content')

<div class="card border-0 shadow-sm">
    <!-- <div class="card-header bg-white">
        <h5 class="mb-0">Edit Blog Category</h5>
    </div> -->
    <div class="card-body">
        <form action="{{ route('admin.blog-categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Name *</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $category->name) }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control @error('status') is-invalid @enderror">
                        <option value="active" {{ (old('status', $category->status) ?? 'active') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ (old('status', $category->status) ?? 'active') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label">Parent Category</label>
                    <select name="parent_id" class="form-control @error('parent_id') is-invalid @enderror">
                        <option value="">— None (Top Level) —</option>
                        @foreach($parents as $p)
                            <option value="{{ $p->id }}" {{ (old('parent_id', $category->parent_id ?? '') == $p->id) ? 'selected' : '' }}>
                                {{ $p->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('parent_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mt-4">
                <button class="btn btn-primary steve-btn"><i class="fas fa-save"></i> Update</button>
                <a href="{{ route('admin.blog-categories.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection
