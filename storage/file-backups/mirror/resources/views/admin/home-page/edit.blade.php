@extends('admin.layouts.app')

@section('page-title', 'Edit' . ' ' . ucfirst(str_replace('_', ' ', $section->section_name)))

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Edit {{ ucfirst(str_replace('_', ' ', $section->section_name)) }}</h2>
                <a href="{{ route('admin.home-page.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Section Details</h5>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.home-page.update', $section->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label for="title" class="form-label"><strong>Title</strong></label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" 
                                   value="{{ old('title', $section->title) }}" placeholder="Enter section title">
                            @error('title')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="subtitle" class="form-label"><strong>Subtitle</strong></label>
                            <input type="text" name="subtitle" id="subtitle" class="form-control @error('subtitle') is-invalid @enderror" 
                                   value="{{ old('subtitle', $section->subtitle) }}" placeholder="Enter section subtitle">
                            @error('subtitle')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="description" class="form-label"><strong>Description</strong></label>
                            <textarea name="description" id="description" class="form-control texteditor @error('description') is-invalid @enderror" 
                                      rows="4" placeholder="Enter section description">{{ old('description', $section->description) }}</textarea>
                            @error('description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="button_text" class="form-label"><strong>Button Text</strong></label>
                            <input type="text" name="button_text" id="button_text" class="form-control @error('button_text') is-invalid @enderror" 
                                   value="{{ old('button_text', $section->button_text) }}" placeholder="e.g., Shop Now, Learn More">
                            @error('button_text')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="button_url" class="form-label"><strong>Button URL</strong></label>
                            <input type="text" name="button_url" id="button_url" class="form-control @error('button_url') is-invalid @enderror" 
                                   value="{{ old('button_url', $section->button_url) }}" placeholder="e.g., /shop, /products">
                            @error('button_url')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        @if(in_array($section->section_name, ['top_brands_heading', 'top_brands', 'brands_section']))
                        @php
                            $extra = $section->extra_data ?? [];
                            $brandsLimit = $extra['brands_limit'] ?? '6';
                            $selectedBrandIds = collect($extra['brand_ids'] ?? [])->map(fn($id) => (int) $id)->all();
                            $allBrands = \App\Models\Brand::where('status', true)->orderBy('name')->get();
                        @endphp
                        <div class="form-group mb-3">
                            <label for="brands_limit" class="form-label"><strong>Number of Brands to Show</strong></label>
                            <select name="brands_limit" id="brands_limit" class="form-control">
                                <option value="6" {{ $brandsLimit == '6' ? 'selected' : '' }}>6 Brands</option>
                                <option value="9" {{ $brandsLimit == '9' ? 'selected' : '' }}>9 Brands</option>
                                <option value="12" {{ $brandsLimit == '12' ? 'selected' : '' }}>12 Brands</option>
                                <option value="18" {{ $brandsLimit == '18' ? 'selected' : '' }}>18 Brands</option>
                                <option value="all" {{ $brandsLimit == 'all' ? 'selected' : '' }}>All Brands</option>
                            </select>
                            <small class="text-muted d-block">How many brands to display on the home page if no specific brands are selected</small>
                        </div>

                        <div class="form-group mb-3">
                            <label for="brand_ids" class="form-label"><strong>Select Brands for Home Page</strong></label>
                            <select name="brand_ids[]" id="brand_ids" class="form-control" multiple size="8">
                                @foreach($allBrands as $brand)
                                    <option value="{{ $brand->id }}" {{ in_array($brand->id, $selectedBrandIds) ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted d-block">Hold Ctrl/Cmd to select multiple brands. Leave empty to use the count-based setting above.</small>
                        </div>
                        @endif

                        @if($section->section_name === 'explore_products')
                        @php
                            $extra = $section->extra_data ?? [];
                            $tabs = $extra['tabs'] ?? [];
                            $allProducts = \App\Models\Product::where('status', true)->orderBy('name')->get();
                        @endphp
                        <div class="card mb-3 border-info">
                            <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Tab-wise Product Selection</h5>
                                <button type="button" class="btn btn-sm btn-light steve-btn" onclick="addTab()">+ Add Tab</button>
                            </div>
                            <div class="card-body" id="tabs-container">
                                <p class="text-muted small">Manage the tabs shown in the Explore Our Products section. Each tab shows up to 8 products.</p>
                                @foreach($tabs as $i => $tab)
                                <div class="tab-row border rounded p-3 mb-3 bg-light">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="flex-grow-1 me-3">
                                            <label class="form-label mb-0 fw-600">Tab Heading</label>
                                            <input type="text" name="tabs[{{ $i }}][label]" class="form-control" value="{{ $tab['label'] ?? '' }}" placeholder="e.g., New Arrivals">
                                        </div>
                                        <button type="button" class="btn btn-sm btn-danger mt-4 steve-btn" onclick="this.closest('.tab-row').remove()">x</button>
                                    </div>
                                    <label class="form-label mb-0 fw-600">Products</label>
                                    <select name="tabs[{{ $i }}][product_ids][]" class="form-control" multiple size="5">
                                        @foreach($allProducts as $product)
                                            <option value="{{ $product->id }}" {{ in_array($product->id, $tab['product_ids'] ?? []) ? 'selected' : '' }}>
                                                {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Hold Ctrl/Cmd to select multiple products</small>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <template id="tab-template">
                            <div class="tab-row border rounded p-3 mb-3 bg-light">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="flex-grow-1 me-3">
                                        <label class="form-label mb-0 fw-600">Tab Heading</label>
                                        <input type="text" name="tabs[__INDEX__][label]" class="form-control" placeholder="e.g., New Arrivals">
                                    </div>
                                    <button type="button" class="btn btn-sm btn-danger mt-4 steve-btn" onclick="this.closest('.tab-row').remove()">x</button>
                                </div>
                                <label class="form-label mb-0 fw-600">Products</label>
                                <select name="tabs[__INDEX__][product_ids][]" class="form-control" multiple size="5">
                                    @foreach($allProducts as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Hold Ctrl/Cmd to select multiple products</small>
                            </div>
                        </template>

                        <script>
                        let tabIndex = {{ count($tabs) }};
                        function addTab() {
                            const html = document.getElementById('tab-template').innerHTML.replace(/__INDEX__/g, tabIndex++);
                            const div = document.createElement('div');
                            div.innerHTML = html;
                            document.getElementById('tabs-container').appendChild(div.firstElementChild);
                        }
                        </script>
                        @endif

                        <div class="form-group mb-3">
                            <label for="image" class="form-label"><strong>Image</strong></label>
                            <div class="mb-2">
                                @if($section->image)
                                    <div class="mb-2">
                                        <img src="{{ asset('assets/images/home/' . $section->image) }}" alt="Current image" 
                                             style="max-width: 300px; height: auto; border-radius: 4px; border: 1px solid #ddd;">
                                    </div>
                                @endif
                            </div>
                            <input type="hidden" name="image_from_manager" id="image_from_manager_home_image">
                            <div id="impPreview_home_image" class="d-none mt-2"></div>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="impOpen_home_image()">
                                <i class="fas fa-images me-1"></i> Browse Image Manager
                            </button>
                            @error('image')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="status" class="form-label">
                                <input type="checkbox" name="status" id="status" value="1" 
                                       {{ old('status', $section->status) ? 'checked' : '' }}>
                                <strong>Active</strong>
                            </label>
                            <small class="text-muted d-block">Check this to display this section on the home page</small>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary steve-btn">
                                <i class="fa fa-save"></i> Save Changes
                            </button>
                            <a href="{{ route('admin.home-page.index') }}" class="btn btn-secondary">
                                <i class="fa fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Section Information</h5>
                </div>
                <div class="card-body">
                    <p>
                        <strong>Section Name:</strong><br>
                        {{ ucfirst(str_replace('_', ' ', $section->section_name)) }}
                    </p>
                    <p>
                        <strong>Order:</strong><br>
                        {{ $section->order }}
                    </p>
                    <p>
                        <strong>Status:</strong><br>
                        <span class="badge {{ $section->status ? 'bg-light text-success border border-success-subtle' : 'bg-light text-danger border border-danger-subtle' }}">
                            {{  $section->status ? 'Active' : 'Inactive' }}
                        </span>
                    </p>
                    <p>
                        <strong>Joined:</strong><br>
                        {{ $section->created_at->format('M d, Y H:i') }}
                    </p>
                    <p>
                        <strong>Last Updated:</strong><br>
                        {{ $section->updated_at->format('M d, Y H:i') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }
    .btn {
        margin-right: 0.5rem;
    }
</style>

@include('admin.partials.image-manager-picker', ['pickerId' => 'home_image', 'targetInput' => 'image_from_manager'])

@endsection
