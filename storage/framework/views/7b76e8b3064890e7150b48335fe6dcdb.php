<?php $__env->startSection('page-title', 'Product Details — ' . $product->name); ?>
<?php $__env->startSection('content'); ?>

<style>
    #productTabs .nav-link {
        border: 1px solid #e9ecef !important;
        border-bottom: none !important;
        margin-right: -1px !important;
        border-radius: 0.375rem 0.375rem 0 0 !important;
        padding: 0.5rem 1rem !important;
        color: #6c757d !important;
    }
    #productTabs .nav-link.active {
        background: #fff !important;
        color: #0d6efd !important;
        border: 1px solid #e9ecef !important;
        border-bottom: 2px solid #0d6efd !important;
        font-weight: 500;
    }
    #productTabs .nav-link:hover:not(.active) {
        background: #f8f9fa !important;
        color: #495057 !important;
    }
    #productTabs .nav-item:first-child .nav-link {
        border-left-start-radius: 0.375rem !important;
    }
    #productTabs .tab-pane {
        padding: 1rem 0;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-3">    
    <!-- <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left"></i> Back</a> -->
    <!-- <a href="<?php echo e(route('admin.products.edit', $product->id)); ?>" class="btn btn-primary steve-btn"><i class="fas fa-edit me-1"></i> Edit Product</a> -->
</div>

<div class="row g-3">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="fas fa-image me-2"></i>Product Image</h5>
            </div>
            <div class="card-body">
                <?php if($product->image): ?>
                    <img src="<?php echo e(asset('assets/images/thumbnails/' . $product->image)); ?>" alt="<?php echo e($product->name); ?>" class="img-fluid rounded" style="max-height:350px;">
                <?php else: ?>
                    <div class="text-muted text-center py-5"><i class="fas fa-image fa-3x mb-2"></i><br>No image uploaded</div>
                <?php endif; ?>

                <?php if($product->galleryImages->count()): ?>
                    <hr>
                    <h6 class="text-muted mb-2">Gallery Images</h6>
                    <div class="d-flex flex-wrap gap-2">
                        <?php $__currentLoopData = $product->galleryImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <img src="<?php echo e($img->thumb_url); ?>" alt="Gallery" class="rounded" style="width:80px;height:80px;object-fit:cover;">
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white py-3">
                <ul class="nav nav-tabs card-header-tabs" id="productTabs">
                    <li class="nav-item">
                        <a class="nav-link active" id="desc-tab" data-bs-toggle="tab" href="#desc" role="tab">
                            <i class="fas fa-file-alt me-1"></i> <?php echo e($product->tab_label_1 ?: 'Description'); ?>

                        </a>
                    </li>
                    <?php if($product->policy_text): ?>
                    <li class="nav-item">
                        <a class="nav-link" id="policy-tab" data-bs-toggle="tab" href="#policy" role="tab">
                            <i class="fas fa-shield-alt me-1"></i> <?php echo e($product->tab_label_2 ?: 'Policy'); ?>

                        </a>
                    </li>
                    <?php endif; ?>
                    <?php if(!empty($product->features) && count($product->features)): ?>
                    <li class="nav-item">
                        <a class="nav-link" id="features-tab" data-bs-toggle="tab" href="#features" role="tab">
                            <i class="fas fa-list-check me-1"></i> Features
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="productTabsContent">
                    <div class="tab-pane fade show active" id="desc" role="tabpanel">
                        <?php echo $product->description ?: '<p class="text-muted">No description</p>'; ?>

                    </div>
                    <?php if($product->policy_text): ?>
                    <div class="tab-pane fade" id="policy" role="tabpanel">
                        <?php echo $product->policy_text; ?>

                    </div>
                    <?php endif; ?>
                    <?php if(!empty($product->features) && count($product->features)): ?>
                    <div class="tab-pane fade" id="features" role="tabpanel">
                        <ul class="mb-0">
                            <?php $__currentLoopData = $product->features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($feature); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Product Summary</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm mb-0">
                    <tr>
                        <th class="text-muted" style="width:45%">Name</th>
                        <td><?php echo e($product->name); ?></td>
                    </tr>
                    <tr>
                        <th class="text-muted">Price</th>
                        <td><?php echo e(currency_format($product->price)); ?></td>
                    </tr>
                    <?php if($product->old_price): ?>
                    <tr>
                        <th class="text-muted">Old Price</th>
                        <td><s class="text-danger"><?php echo e(currency_format($product->old_price)); ?></s></td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <th class="text-muted">Category</th>
                        <td><?php echo e($product->category->name ?? '—'); ?></td>
                    </tr>
                    <tr>
                        <th class="text-muted">Brand</th>
                        <td><?php echo e($product->brand->name ?? '—'); ?></td>
                    </tr>
                    <tr>
                        <th class="text-muted">Stock</th>
                        <td>
                            <?php if($product->stock > 0): ?>
                                <span class="text-success"><?php echo e($product->stock); ?></span>
                            <?php else: ?>
                                <span class="text-danger">Out of Stock</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php if($product->badge): ?>
                    <tr>
                        <th class="text-muted">Badge</th>
                        <td><span class="badge bg-warning text-dark"><?php echo e($product->badge); ?></span></td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <th class="text-muted">Product Type</th>
                        <td><?php echo e(ucfirst($product->product_type ?? 'none')); ?></td>
                    </tr>
                    <tr>
                        <th class="text-muted">Status</th>
                        <td>
                            <?php if($product->status): ?>
                                <span class="badge bg-success">Active</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Inactive</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-muted">Featured</th>
                        <td>
                            <?php if($product->featured): ?>
                                <span class="badge bg-primary">Yes</span>
                            <?php else: ?>
                                <span class="badge bg-light text-dark">No</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-muted">Rating</th>
                        <td><?php echo e(number_format($product->rating, 1)); ?> / 5 (<?php echo e($product->reviews); ?> reviews)</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="fas fa-car me-2"></i>Vehicle Details</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm mb-0">
                    <tr>
                        <th class="text-muted" style="width:45%">Year</th>
                        <td><?php echo e($product->year ?? '—'); ?></td>
                    </tr>
                    <tr>
                        <th class="text-muted">Make</th>
                        <td><?php echo e($product->make ?? '—'); ?></td>
                    </tr>
                    <tr>
                        <th class="text-muted">Model</th>
                        <td><?php echo e($product->model ?? '—'); ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Metadata</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm mb-0">
                    <tr>
                        <th class="text-muted" style="width:45%">ID</th>
                        <td>#<?php echo e($product->id); ?></td>
                    </tr>
                    <tr>
                        <th class="text-muted">Slug</th>
                        <td><code><?php echo e($product->slug); ?></code></td>
                    </tr>
                    <tr>
                        <th class="text-muted">Added By</th>
                        <td><?php echo e($product->added_by ?? '—'); ?></td>
                    </tr>
                    <tr>
                        <th class="text-muted">Created</th>
                        <td><?php echo e($product->created_at ? $product->created_at->format('M d, Y h:i A') : '—'); ?></td>
                    </tr>
                    <tr>
                        <th class="text-muted">Updated</th>
                        <td><?php echo e($product->updated_at ? $product->updated_at->format('M d, Y h:i A') : '—'); ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <a href="<?php echo e(route('admin.products.edit', $product->id)); ?>" class="btn btn-primary steve-btn w-100">
            <i class="fas fa-edit me-1"></i> Edit This Product
        </a>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/stautoparts/resources/views/admin/products/show.blade.php ENDPATH**/ ?>