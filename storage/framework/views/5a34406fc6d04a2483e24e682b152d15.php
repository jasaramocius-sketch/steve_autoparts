<?php $__env->startSection('page-id', 'admin-products-edit-page'); ?>
<?php $__env->startSection('page-class', 'admin-products-edit-page'); ?>
<?php $__env->startSection('page-title', 'Edit Product'); ?>
<?php $__env->startSection('content'); ?>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0">Edit Product</h5>
    </div>
    <div class="card-body">
        <form action="<?php echo e(route('admin.products.update', $product->id)); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

            <!-- Tab Navigation -->
            <ul class="nav nav-tabs nav-fill mb-4" id="productTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic-info" type="button" role="tab" aria-controls="basic-info" aria-selected="true">
                        <i class="fas fa-info-circle me-1"></i> Basic Info
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="vehicle-tab" data-bs-toggle="tab" data-bs-target="#vehicle-details" type="button" role="tab" aria-controls="vehicle-details" aria-selected="false">
                        <i class="fas fa-car me-1"></i> Vehicle Details
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="content-tab" data-bs-toggle="tab" data-bs-target="#content-details" type="button" role="tab" aria-controls="content-details" aria-selected="false">
                        <i class="fas fa-file-alt me-1"></i> Content & Descriptions
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="media-tab" data-bs-toggle="tab" data-bs-target="#media-details" type="button" role="tab" aria-controls="media-details" aria-selected="false">
                        <i class="fas fa-images me-1"></i> Media
                    </button>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content" id="productTabsContent">
                
                <!-- Tab 1: Basic Info -->
                <div class="tab-pane fade show active" id="basic-info" role="tabpanel" aria-labelledby="basic-tab">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Name *</label>
                            <input type="text" name="name" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('name', $product->name)); ?>" required>
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Price *</label>
                            <input type="number" step="0.01" name="price" class="form-control <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('price', $product->price)); ?>" required>
                            <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Old Price</label>
                            <input type="number" step="0.01" name="old_price" class="form-control" value="<?php echo e(old('old_price', $product->old_price)); ?>">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Category</label>
                            <select name="category_id" class="form-select">
                                <option value="">None</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($cat->id); ?>" <?php echo e((old('category_id', $product->category_id) == $cat->id) ? 'selected' : ''); ?>><?php echo e($cat->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Brand</label>
                            <select name="brand_id" class="form-select">
                                <option value="">None</option>
                                <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($b->id); ?>" <?php echo e((old('brand_id', $product->brand_id) == $b->id) ? 'selected' : ''); ?>><?php echo e($b->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Stock</label>
                            <input type="number" name="stock" class="form-control" value="<?php echo e(old('stock', $product->stock)); ?>" min="0">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Badge</label>
                            <input type="text" name="badge" class="form-control" value="<?php echo e(old('badge', $product->badge)); ?>" placeholder="e.g. New, Sale">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Section</label>
                            <select name="product_type" class="form-select">
                                <option value="none" <?php echo e(old('product_type', $product->product_type) == 'none' ? 'selected' : ''); ?>>None</option>
                                <option value="new_arrival" <?php echo e(old('product_type', $product->product_type) == 'new_arrival' ? 'selected' : ''); ?>>New Arrivals</option>
                                <option value="trending" <?php echo e(old('product_type', $product->product_type) == 'trending' ? 'selected' : ''); ?>>Trending</option>
                                <option value="best_selling" <?php echo e(old('product_type', $product->product_type) == 'best_selling' ? 'selected' : ''); ?>>Best Selling</option>
                                <option value="popular" <?php echo e(old('product_type', $product->product_type) == 'popular' ? 'selected' : ''); ?>>Popular</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="1" <?php echo e(old('status', $product->status) == '1' ? 'selected' : ''); ?>>Active</option>
                                <option value="0" <?php echo e(old('status', $product->status) == '0' ? 'selected' : ''); ?>>Inactive</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label d-block">&nbsp;</label>
                            <div class="form-check form-switch mt-1">
                                <input type="checkbox" name="featured" value="1" class="form-check-input" id="featured" <?php echo e(old('featured', $product->featured) ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="featured">Featured Product</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab 2: Vehicle Details -->
                <div class="tab-pane fade" id="vehicle-details" role="tabpanel" aria-labelledby="vehicle-tab">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Year</label>
                            <input type="number" name="year" class="form-control" value="<?php echo e(old('year', $product->year)); ?>" min="1900" max="2026" placeholder="e.g. 2020">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Make</label>
                            <input type="text" name="make" class="form-control" value="<?php echo e(old('make', $product->make)); ?>" placeholder="e.g. Toyota">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Model</label>
                            <input type="text" name="model" class="form-control" value="<?php echo e(old('model', $product->model)); ?>" placeholder="e.g. Camry">
                        </div>
                    </div>
                </div>

                <!-- Tab 3: Content & Descriptions -->
                <div class="tab-pane fade" id="content-details" role="tabpanel" aria-labelledby="content-tab">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Tab 1 Label</label>
                            <input type="text" name="tab_label_1" class="form-control" value="<?php echo e(old('tab_label_1', $product->tab_label_1)); ?>" placeholder="Description">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tab 2 Label</label>
                            <input type="text" name="tab_label_2" class="form-control" value="<?php echo e(old('tab_label_2', $product->tab_label_2)); ?>" placeholder="Policy">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tab 3 Label</label>
                            <input type="text" name="tab_label_3" class="form-control" value="<?php echo e(old('tab_label_3', $product->tab_label_3)); ?>" placeholder="Reviews">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control texteditor" rows="4"><?php echo e(old('description', $product->description)); ?></textarea>
                        </div>
                        
                        <div class="col-md-12">
                            <label class="form-label">Policy Text</label>
                            <textarea name="policy_text" class="form-control texteditor" rows="4"><?php echo e(old('policy_text', $product->policy_text)); ?></textarea>
                        </div>
                        
                        <div class="col-md-12">
                            <label class="form-label">Key Features</label>
                            <textarea name="features" class="form-control" rows="4" placeholder="Enter one feature per line..."><?php echo e(old('features', is_array($product->features) ? implode("\n", $product->features) : '')); ?></textarea>
                        </div>
                        
                        <div class="col-md-12">
                            <label class="form-label">Reviews Data (JSON array)</label>
                            <textarea name="reviews_data" class="form-control text-monospace" rows="4" placeholder='[{"name":"John","rating":5,"text":"Great product!"}]'><?php echo e(old('reviews_data', is_array($product->reviews_data) ? json_encode($product->reviews_data, JSON_PRETTY_PRINT) : '')); ?></textarea>
                            <small class="text-muted">Format: [{"name":"John","rating":5,"text":"Great product!"}]</small>
                        </div>
                    </div>
                </div>

                <!-- Tab 4: Media -->
                <div class="tab-pane fade" id="media-details" role="tabpanel" aria-labelledby="media-tab">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Primary Image</label>
                            <div class="card p-3 border-dashed h-100">
                                <?php if($product->image): ?>
                                    <div class="mb-3 d-flex align-items-center bg-light p-2 rounded">
                                        <img src="<?php echo e(asset('assets/images/thumbnails/' . $product->image)); ?>" width="60" height="60" style="object-fit:cover; border-radius:4px; border:1px solid #ddd;">
                                        <div class="ms-3">
                                            <small class="text-muted d-block fw-bold">Current Primary Image</small>
                                            <small class="text-muted">Upload a new one below to replace.</small>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- <input type="file" name="image" class="form-control mb-2 <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> -->
                                
                                <input type="hidden" name="image_from_manager" id="image_from_manager_product_image">
                                <div id="impPreview_product_image" class="d-none my-2"></div>
                                <div>
                                    <button type="button" class="btn btn-sm btn-outline-primary mt-1" onclick="impOpen_product_image()">
                                        <i class="fas fa-folder-open me-1"></i> Browse Image Manager
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Gallery Images</label>
                            <div class="card p-3 border-dashed h-100">
                                <?php if($product->galleryImages->count() > 0): ?>
                                    <div class="mb-3">
                                        <small class="text-muted d-block fw-bold mb-2">Existing Gallery Images</small>
                                        <div class="row g-2" id="existing-gallery">
                                            <?php $__currentLoopData = $product->galleryImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="col-auto position-relative text-center">
                                                       <img src="<?php echo e($img->thumb_url); ?>" width="60" height="60" style="object-fit:cover; border-radius:4px; border:1px solid #ddd;">
                                                    <div class="form-check mt-1 d-flex justify-content-center">
                                                        <input type="checkbox" name="delete_gallery_ids[]" value="<?php echo e($img->id); ?>" class="form-check-input me-1" id="del_img_<?php echo e($img->id); ?>">
                                                        <label class="form-check-label text-danger small" style="cursor:pointer;" for="del_img_<?php echo e($img->id); ?>">Remove</label>
                                                    </div>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                        <!-- <hr class="my-3 text-muted">    -->
                                    </div>
                                <?php endif; ?>

                                <!-- <input type="file" name="gallery_images[]" class="form-control mb-2" multiple accept="image/*"> -->
                                <input type="hidden" name="gallery_images_from_manager" id="gallery_images_from_manager">
                                <div id="impPreview_gallery_images" class="d-none my-2"></div>
                                
                                <div>
                                    <button type="button" class="btn btn-sm btn-outline-primary mt-1" onclick="impOpen_gallery_images()">
                                        <i class="fas fa-folder-open me-1"></i> Browse Image Manager
                                    </button>
                                    <small class="text-muted mt-2 d-block">Pick multiple from Image Manager, or upload files above.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div> <!-- End Tab Content -->

            <hr class="mt-5 mb-4">
            
            <!-- Form Actions -->
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary steve-btn px-4"><i class="fas fa-save me-1"></i> Update Product</button>
                <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-secondary steve-btn px-4">Cancel</a>
            </div>
            
        </form>
    </div>
</div>

<?php echo $__env->make('admin.partials.image-manager-picker', ['pickerId' => 'product_image', 'targetInput' => 'image_from_manager'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('admin.partials.image-manager-picker', ['pickerId' => 'gallery_images', 'targetInput' => 'gallery_images_from_manager', 'multiple' => true], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/stautoparts/resources/views/admin/products/edit.blade.php ENDPATH**/ ?>