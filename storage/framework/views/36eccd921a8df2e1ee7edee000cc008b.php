<?php $__env->startSection('page-id', 'admin-home-edit-page'); ?>
<?php $__env->startSection('page-class', 'admin-home-edit-page'); ?>
<?php $__env->startSection('page-title', 'Edit' . ' ' . ucfirst(str_replace('_', ' ', $section->section_name))); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Edit <?php echo e(ucfirst(str_replace('_', ' ', $section->section_name))); ?></h2>
                <a href="<?php echo e(route('admin.home-page.index')); ?>" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div> -->

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Section Details</h5>
                </div>
                <div class="card-body">
                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <?php if($section->section_name === 'offers'): ?>
                        <div class="alert alert-info">
                            <strong>Special Offer section:</strong> The heading is controlled by <strong>Title</strong> (default: "Special Offer") and the intro text below it by <strong>Description</strong>. The offer banners are managed below under <strong>Offer Banners</strong>.
                        </div>
                    <?php endif; ?>

                    <?php if($section->section_name === 'deal_of_day'): ?>
                        <div class="alert alert-info">
                            <strong>!! Special Offer !! section:</strong> <strong>Title</strong>, <strong>Subtitle</strong> and <strong>Description</strong> now drive the heading, sub-heading and paragraph. <strong>Button Text</strong>, <strong>Button URL</strong> and <strong>Image</strong> work as before, and the countdown end date/time is set below.
                        </div>
                    <?php endif; ?>

                    <?php if($section->section_name === 'latest_post'): ?>
                        <div class="alert alert-info">
                            <strong>Latest Post section:</strong> <strong>Title</strong> = section heading, <strong>Description</strong> = intro text. The posts themselves come from published blog posts (manage them under the Blog menu); use the posts-count field below to control how many are shown.
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo e(route('admin.home-page.update', $section->id)); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="form-group mb-3">
                            <label for="title" class="form-label"><strong>Title</strong></label>
                            <input type="text" name="title" id="title" class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   value="<?php echo e(old('title', $section->title)); ?>" placeholder="Enter section title">
                            <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="form-group mb-3">
                            <label for="subtitle" class="form-label"><strong>Subtitle</strong></label>
                            <input type="text" name="subtitle" id="subtitle" class="form-control <?php $__errorArgs = ['subtitle'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   value="<?php echo e(old('subtitle', $section->subtitle)); ?>" placeholder="Enter section subtitle">
                            <?php $__errorArgs = ['subtitle'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="form-group mb-3">
                            <label for="description" class="form-label"><strong>Description</strong></label>
                            <textarea name="description" id="description" class="form-control texteditor <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                      rows="4" placeholder="Enter section description"><?php echo e(old('description', $section->description)); ?></textarea>
                            <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="form-group mb-3">
                            <label for="button_text" class="form-label"><strong>Button Text</strong></label>
                            <input type="text" name="button_text" id="button_text" class="form-control <?php $__errorArgs = ['button_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   value="<?php echo e(old('button_text', $section->button_text)); ?>" placeholder="e.g., Shop Now, Learn More">
                            <?php $__errorArgs = ['button_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="form-group mb-3">
                            <label for="button_url" class="form-label"><strong>Button URL</strong></label>
                            <input type="text" name="button_url" id="button_url" class="form-control <?php $__errorArgs = ['button_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   value="<?php echo e(old('button_url', $section->button_url)); ?>" placeholder="e.g., /shop, /products">
                            <?php $__errorArgs = ['button_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <?php if($section->section_name === 'offers'): ?>
                        <?php
                            $extra = $section->extra_data ?? [];
                            $banners = $extra['banners'] ?? [];
                            $maxBanners = 3;
                            $allBannerSlotsFilled = count($banners) >= $maxBanners;
                        ?>
                        <div class="card mb-3 border-warning">
                            <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Offer Banners</h5>
                                <button type="button" class="btn btn-sm btn-dark steve-btn <?php echo e($allBannerSlotsFilled ? 'd-none' : ''); ?>" id="add-banner-btn">
                                    <i class="fas fa-plus me-1"></i> Add Banner
                                </button>
                            </div>
                            <div class="card-body">
                                <p class="text-muted small">Banners shown below the "Special Offer" heading on the home page (max <?php echo e($maxBanners); ?>).</p>
                                <div id="banners-container">
                                    <?php for($i = 0; $i < $maxBanners; $i++): ?>
                                    <?php $banner = $banners[$i] ?? null; ?>
                                    <div class="banner-row border rounded p-3 mb-3 bg-light <?php echo e($banner ? '' : 'd-none'); ?>">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <strong>Banner #<?php echo e($i + 1); ?></strong>
                                            <button type="button" class="btn btn-sm btn-danger steve-btn remove-banner-btn"><i class="fas fa-times me-1"></i>Remove</button>
                                        </div>
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-1"><strong>Image</strong></label>
                                                <?php if($banner && !empty($banner['image'])): ?>
                                                    <?php
                                                        $previewImg = 'assets/images/home/' . $banner['image'];
                                                        if (!file_exists(public_path($previewImg))) {
                                                            $previewImg = 'assets/images/categories/' . $banner['image'];
                                                        }
                                                    ?>
                                                    <div class="mb-1">
                                                        <img src="<?php echo e(asset($previewImg)); ?>" width="100" style="border-radius:4px;border:1px solid #ddd;" onerror="this.onerror=null;this.src='<?php echo e(asset('assets/images/placeholder.png')); ?>'">
                                                    </div>
                                                <?php endif; ?>
                                                <input type="hidden" name="banners[<?php echo e($i); ?>][image_from_manager]" id="banners_image_from_manager_<?php echo e($i); ?>">
                                                <input type="hidden" name="banners[<?php echo e($i); ?>][existing_image]" value="<?php echo e($banner['image'] ?? ''); ?>">
                                                <div id="impPreview_banner_<?php echo e($i); ?>" class="d-none mt-1"></div>
                                                <button type="button" class="btn btn-sm btn-outline-primary mt-1" onclick="impOpen_banner_<?php echo e($i); ?>()">
                                                    <i class="fas fa-images me-1"></i> Browse Image Manager
                                                </button>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="row g-2">
                                                    <div class="col-md-6">
                                                        <label class="form-label mb-1"><strong>Title</strong></label>
                                                        <input type="text" name="banners[<?php echo e($i); ?>][title]" class="form-control" value="<?php echo e($banner['title'] ?? ''); ?>">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label mb-1"><strong>Subtitle</strong></label>
                                                        <input type="text" name="banners[<?php echo e($i); ?>][subtitle]" class="form-control" value="<?php echo e($banner['subtitle'] ?? ''); ?>">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label mb-1"><strong>Button Text</strong></label>
                                                        <input type="text" name="banners[<?php echo e($i); ?>][button_text]" class="form-control" value="<?php echo e($banner['button_text'] ?? ''); ?>">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label mb-1"><strong>Button URL</strong></label>
                                                        <input type="text" name="banners[<?php echo e($i); ?>][button_url]" class="form-control" value="<?php echo e($banner['button_url'] ?? ''); ?>" placeholder="/shop">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endfor; ?>
                                </div>
                                <p id="banners-full-note" class="text-muted small <?php echo e($allBannerSlotsFilled ? '' : 'd-none'); ?>">Maximum <?php echo e($maxBanners); ?> banners reached.</p>
                            </div>
                        </div>

                        <script>
                        document.getElementById('add-banner-btn')?.addEventListener('click', function() {
                            var hidden = document.querySelectorAll('#banners-container .banner-row.d-none');
                            if (hidden.length === 0) {
                                var note = document.getElementById('banners-full-note');
                                if (note) {
                                    note.classList.remove('d-none');
                                    setTimeout(function() { note.classList.add('d-none'); }, 2500);
                                }
                                return;
                            }
                            hidden[0].classList.remove('d-none');
                            if (document.querySelectorAll('#banners-container .banner-row').length === document.querySelectorAll('#banners-container .banner-row:not(.d-none)').length) {
                                document.getElementById('add-banner-btn').classList.add('d-none');
                                document.getElementById('banners-full-note').classList.remove('d-none');
                            }
                        });
                        document.querySelectorAll('.remove-banner-btn').forEach(function(btn) {
                            btn.addEventListener('click', function() {
                                var row = btn.closest('.banner-row');
                                row.querySelectorAll('input').forEach(function(inp) { inp.value = ''; });
                                row.classList.add('d-none');
                                document.getElementById('add-banner-btn').classList.remove('d-none');
                                document.getElementById('banners-full-note').classList.add('d-none');
                            });
                        });
                        </script>
                        <?php endif; ?>

                        <?php if($section->section_name === 'deal_of_day'): ?>
                        <?php $extra = $section->extra_data ?? []; ?>
                        <div class="form-group mb-3">
                            <label for="countdown" class="form-label"><strong>Countdown End Date/Time</strong></label>
                            <input type="datetime-local" name="countdown" id="countdown" class="form-control" value="<?php echo e($extra['countdown'] ?? ''); ?>">
                            <small class="text-muted d-block">Sets the date/time shown in the countdown. Leave empty to use the default end date.</small>
                        </div>
                        <?php endif; ?>

                        <?php if($section->section_name === 'latest_post'): ?>
                        <?php $extra = $section->extra_data ?? []; ?>
                        <div class="form-group mb-3">
                            <label for="posts_count" class="form-label"><strong>Number of Posts to Show</strong></label>
                            <select name="posts_count" id="posts_count" class="form-control">
                                <?php $__currentLoopData = [2, 3, 4, 6]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($n); ?>" <?php echo e((int)($extra['posts_count'] ?? 2) === $n ? 'selected' : ''); ?>><?php echo e($n); ?> Posts</option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <small class="text-muted d-block">How many latest published blog posts to display on the home page.</small>
                        </div>
                        <?php endif; ?>

                        <?php if(in_array($section->section_name, ['top_brands_heading', 'top_brands', 'brands_section'])): ?>
                        <?php
                            $extra = $section->extra_data ?? [];
                            $brandsLimit = $extra['brands_limit'] ?? '6';
                            $selectedBrandIds = collect($extra['brand_ids'] ?? [])->map(fn($id) => (int) $id)->all();
                            $allBrands = \App\Models\Brand::where('status', true)->orderBy('name')->get();
                        ?>
                        <div class="form-group mb-3">
                            <label for="brands_limit" class="form-label"><strong>Number of Brands to Show</strong></label>
                            <select name="brands_limit" id="brands_limit" class="form-control">
                                <option value="6" <?php echo e($brandsLimit == '6' ? 'selected' : ''); ?>>6 Brands</option>
                                <option value="9" <?php echo e($brandsLimit == '9' ? 'selected' : ''); ?>>9 Brands</option>
                                <option value="12" <?php echo e($brandsLimit == '12' ? 'selected' : ''); ?>>12 Brands</option>
                                <option value="18" <?php echo e($brandsLimit == '18' ? 'selected' : ''); ?>>18 Brands</option>
                                <option value="all" <?php echo e($brandsLimit == 'all' ? 'selected' : ''); ?>>All Brands</option>
                            </select>
                            <small class="text-muted d-block">How many brands to display on the home page if no specific brands are selected</small>
                        </div>

                        <div class="form-group mb-3">
                            <label for="brand_ids" class="form-label"><strong>Select Brands for Home Page</strong></label>
                            <select name="brand_ids[]" id="brand_ids" class="form-control" multiple size="8">
                                <?php $__currentLoopData = $allBrands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($brand->id); ?>" <?php echo e(in_array($brand->id, $selectedBrandIds) ? 'selected' : ''); ?>>
                                        <?php echo e($brand->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <small class="text-muted d-block">Hold Ctrl/Cmd to select multiple brands. Leave empty to use the count-based setting above.</small>
                        </div>
                        <?php endif; ?>

                        <?php if($section->section_name === 'explore_products'): ?>
                        <?php
                            $extra = $section->extra_data ?? [];
                            $tabs = $extra['tabs'] ?? [];
                            $allProducts = \App\Models\Product::where('status', true)->orderBy('name')->get();
                        ?>
                        <div class="card mb-3 border-info">
                            <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Tab-wise Product Selection</h5>
                                <button type="button" class="btn btn-sm btn-light steve-btn" onclick="addTab()">+ Add Tab</button>
                            </div>
                            <div class="card-body" id="tabs-container">
                                <p class="text-muted small">Manage the tabs shown in the Explore Our Products section. Each tab shows up to 8 products.</p>
                                <?php $__currentLoopData = $tabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $tab): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="tab-row border rounded p-3 mb-3 bg-light">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="flex-grow-1 me-3">
                                            <label class="form-label mb-0 fw-600">Tab Heading</label>
                                            <input type="text" name="tabs[<?php echo e($i); ?>][label]" class="form-control" value="<?php echo e($tab['label'] ?? ''); ?>" placeholder="e.g., New Arrivals">
                                        </div>
                                        <button type="button" class="btn btn-sm btn-danger mt-4 steve-btn" onclick="this.closest('.tab-row').remove()">x</button>
                                    </div>
                                    <label class="form-label mb-0 fw-600">Products</label>
                                    <select name="tabs[<?php echo e($i); ?>][product_ids][]" class="form-control" multiple size="5">
                                        <?php $__currentLoopData = $allProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($product->id); ?>" <?php echo e(in_array($product->id, $tab['product_ids'] ?? []) ? 'selected' : ''); ?>>
                                                <?php echo e($product->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <small class="text-muted">Hold Ctrl/Cmd to select multiple products</small>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                    <?php $__currentLoopData = $allProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($product->id); ?>"><?php echo e($product->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <small class="text-muted">Hold Ctrl/Cmd to select multiple products</small>
                            </div>
                        </template>

                        <script>
                        let tabIndex = <?php echo e(count($tabs)); ?>;
                        function addTab() {
                            const html = document.getElementById('tab-template').innerHTML.replace(/__INDEX__/g, tabIndex++);
                            const div = document.createElement('div');
                            div.innerHTML = html;
                            document.getElementById('tabs-container').appendChild(div.firstElementChild);
                        }
                        </script>
                        <?php endif; ?>

                        <div class="form-group mb-3">
                            <label for="image" class="form-label"><strong>Image</strong></label>
                            <div class="mb-2">
                                <?php if($section->image): ?>
                                    <div class="mb-2">
                                        <img src="<?php echo e(asset('assets/images/home/' . $section->image)); ?>" alt="Current image" 
                                             style="max-width: 300px; height: auto; border-radius: 4px; border: 1px solid #ddd;">
                                    </div>
                                <?php endif; ?>
                            </div>
                            <input type="hidden" name="image_from_manager" id="image_from_manager_home_image">
                            <div id="impPreview_home_image" class="d-none mt-2"></div>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="impOpen_home_image()">
                                <i class="fas fa-images me-1"></i> Browse Image Manager
                            </button>
                            <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback d-block"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="form-group mb-3">
                            <label for="status" class="form-label">
                                <input type="checkbox" name="status" id="status" value="1" 
                                       <?php echo e(old('status', $section->status) ? 'checked' : ''); ?>>
                                <strong>Active</strong>
                            </label>
                            <small class="text-muted d-block">Check this to display this section on the home page</small>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary steve-btn">
                                <i class="fa fa-save"></i> Save Changes
                            </button>
                            <a href="<?php echo e(route('admin.home-page.index')); ?>" class="btn btn-secondary">
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
                        <?php echo e(ucfirst(str_replace('_', ' ', $section->section_name))); ?>

                    </p>
                    <p>
                        <strong>Order:</strong><br>
                        <?php echo e($section->order); ?>

                    </p>
                    <p>
                        <strong>Status:</strong><br>
                        <span class="badge <?php echo e($section->status ? 'bg-light text-success border border-success-subtle' : 'bg-light text-danger border border-danger-subtle'); ?>">
                            <?php echo e($section->status ? 'Active' : 'Inactive'); ?>

                        </span>
                    </p>
                    <p>
                        <strong>Joined:</strong><br>
                        <?php echo e($section->created_at->format('M d, Y H:i')); ?>

                    </p>
                    <p>
                        <strong>Last Updated:</strong><br>
                        <?php echo e($section->updated_at->format('M d, Y H:i')); ?>

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

<?php echo $__env->make('admin.partials.image-manager-picker', ['pickerId' => 'home_image', 'targetInput' => 'image_from_manager'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php for($i = 0; $i < 3; $i++): ?>
<?php echo $__env->make('admin.partials.image-manager-picker', ['pickerId' => 'banner_' . $i, 'targetInput' => 'banners[' . $i . '][image_from_manager]'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endfor; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/stautoparts/resources/views/admin/home-page/edit.blade.php ENDPATH**/ ?>