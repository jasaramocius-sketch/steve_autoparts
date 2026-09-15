@php $selected = $selectedCategoryId ?? ''; @endphp
<div class="blog-category-field">
    <label class="form-label">Category</label>
    <select name="blog_category_id" class="form-control @error('blog_category_id') is-invalid @enderror">
        <option value="">None</option>
        @foreach($blogCategories as $cat)
            <option value="{{ $cat->id }}" {{ $selected == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @foreach($cat->children as $child)
                <option value="{{ $child->id }}" {{ $selected == $child->id ? 'selected' : '' }}>
                    &nbsp;&nbsp;&nbsp;{{ $child->name }}
                </option>
            @endforeach
        @endforeach
    </select>
    @error('blog_category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror

    <button type="button" class="btn btn-sm btn-outline-secondary mt-1" onclick="var d=this.parentElement.querySelector('.blog-new-category'); if (d) d.classList.toggle('d-none');">
        <i class="fas fa-plus me-1"></i> Add New Category
    </button>

    <div class="blog-new-category {{ old('new_category') ? '' : 'd-none' }} mt-2 p-2 border rounded bg-light">
        <div class="row g-2">
            <div class="col-md-6">
                <label class="form-label small mb-1">New Category Name *</label>
                <input type="text" name="new_category" value="{{ old('new_category') }}" class="form-control form-control-sm @error('new_category') is-invalid @enderror" placeholder="e.g. Suspension" autocomplete="off">
            </div>
            <div class="col-md-6">
                <label class="form-label small mb-1">Parent Category</label>
                <select name="new_category_parent_id" class="form-control form-control-sm">
                    <option value="">— Top Level —</option>
                    @foreach($blogCategories as $cat)
                        <option value="{{ $cat->id }}" {{ old('new_category_parent_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @error('new_category')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>
</div>