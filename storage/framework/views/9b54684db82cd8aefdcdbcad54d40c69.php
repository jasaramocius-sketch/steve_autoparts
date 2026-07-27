<?php $__env->startSection('page-title', 'All Products'); ?>
<?php $__env->startSection('content'); ?>

<?php $trashedCount = \App\Models\Product::onlyTrashed()->count(); ?>

<div class="d-flex justify-content-between align-items-center mb-3 gap-2">
    <div class=""></div>
    <div class="d-flex gap-2 flex-wrap admin-product-page-important-btn">
        <a href="<?php echo e(route('admin.products.import-form')); ?>" class="btn btn-outline-primary product-import-export-btn"><i class="fas fa-upload"></i> Import</a>
        <a href="<?php echo e(route('admin.products.export-csv')); ?>" class="btn btn-outline-secondary product-import-export-btn"><i class="fas fa-download"></i> Export CSV</a>
        <a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Add Product</a>
    </div>
</div>

<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a class="nav-link <?php echo e(!request()->has('trashed') ? 'active' : ''); ?>" href="<?php echo e(route('admin.products.index')); ?>">Active</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php echo e(request()->has('trashed') ? 'active' : ''); ?>" href="<?php echo e(route('admin.products.index', ['trashed' => 1])); ?>">Trash (<?php echo e($trashedCount); ?>)</a>
    </li>
</ul>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="d-flex justify-content-between align-items-center px-3 pt-3 pb-2">
            <div class="d-flex align-items-center gap-2">
                <span class="text-muted small">Show</span>
                <select class="form-select form-select-sm" style="width: auto;" onchange="window.location.href=this.value">
                    <?php $currentPerPage = request('per_page', '10'); ?>
                    <?php $__currentLoopData = [10, 20, 50, 100]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e(request()->fullUrlWithQuery(['per_page' => $n])); ?>" <?php echo e($currentPerPage == $n ? 'selected' : ''); ?>><?php echo e($n); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e(request()->fullUrlWithQuery(['per_page' => 'all'])); ?>" <?php echo e($currentPerPage === 'all' ? 'selected' : ''); ?>>All</option>
                </select>
                <span class="text-muted small">per page</span>
            </div>
            <!-- <div class="text-muted small">
                Showing <?php echo e($products->firstItem()); ?>-<?php echo e($products->lastItem()); ?> of <?php echo e($products->total()); ?>

            </div> -->
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3"><a href="<?php echo e(sortUrl('id', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark">
                            # <?php echo sortIndicator('id', $sortBy, $sortDir); ?>

                        </a></th>
                        <th>Image</th>
                        <th><a href="<?php echo e(sortUrl('name', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark">
                            Name <?php echo sortIndicator('name', $sortBy, $sortDir); ?>

                        </a></th>
                        <th>Category</th>
                        <th><a href="<?php echo e(sortUrl('price', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark">
                            Price <?php echo sortIndicator('price', $sortBy, $sortDir); ?>

                        </a></th>
                        <th>Old Price</th>
                        <th><a href="<?php echo e(sortUrl('stock', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark">
                            Stock <?php echo sortIndicator('stock', $sortBy, $sortDir); ?>

                        </a></th>
                        <th>Badge</th>
                        <th>Section</th>
                        <th><a href="<?php echo e(sortUrl('featured', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark">
                            Featured <?php echo sortIndicator('featured', $sortBy, $sortDir); ?>

                        </a></th>
                        <th><a href="<?php echo e(sortUrl('status', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark">
                            Status <?php echo sortIndicator('status', $sortBy, $sortDir); ?>

                        </a></th>
                        <th class="pe-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="ps-3"><?php echo e($product->id); ?></td>
                        <td>
                            <img src="<?php echo e(asset('assets/images/thumbnails/' . ($product->image ?? 'default.png'))); ?>" width="50" height="50" style="object-fit:cover; border-radius:4px;">
                        </td>
                        <td><?php echo e($product->name); ?></td>
                        <td><?php echo e($product->category->name ??  'N/A'); ?></td>
                        <td><?php echo e(currency_format($product->price)); ?></td>
                        <td><?php if($product->old_price): ?> <?php echo e(currency_format($product->old_price)); ?> <?php else: ?> - <?php endif; ?></td>
                        <td><?php echo e($product->stock ?? 0); ?></td>
                        <td><?php if($product->badge): ?> <span class="badge bg-light text-warning border border-warning-subtle"><?php echo e($product->badge); ?></span> <?php else: ?> - <?php endif; ?></td>
                        <td><span class="badge bg-light text-info border border-info-subtle"><?php echo e(str_replace('_', ' ', ucfirst($product->product_type ?? 'none'))); ?></span></td>
                        <td>
                            <?php if(!request()->has('trashed')): ?>
                                <form action="<?php echo e(route('admin.products.toggle-featured', $product->id)); ?>" method="POST" class="d-inline featured-status-btn">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-sm border-0 p-0 steve-btn">
                                        <span class="badge <?php echo e($product->featured ? 'bg-warning' : 'bg-secondary'); ?>" style="cursor:pointer;">
                                            <?php echo e($product->featured ? 'Yes' : 'No'); ?>

                                        </span>
                                    </button>
                                </form>
                            <?php else: ?>
                                <span class="badge bg-secondary">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if(request()->has('trashed')): ?>
                                <span class="badge bg-secondary">Deleted</span>
                            <?php else: ?>
                                <form action="<?php echo e(route('admin.products.toggle-status', $product->id)); ?>" method="POST" class="d-inline featured-status-btn">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-sm border-0 p-0 steve-btn">
                                        <span class="badge <?php echo e($product->status ? 'bg-success' : 'bg-danger'); ?>" style="cursor:pointer;">
                                            <?php echo e($product->status ? 'Active' : 'Inactive'); ?>

                                        </span>
                                    </button>
                                </form>
                            <?php endif; ?>
                        </td>
                        <td class="pe-3 table-action-col">
                            <div class="action-buttons">
                            <?php if(request()->has('trashed')): ?>
                                <form action="<?php echo e(route('admin.products.restore', $product->id)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <button class="action-btn btn-restore" title="Restore"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/></svg></button>
                                </form>
                                <form action="<?php echo e(route('admin.products.force-delete', $product->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Permanently delete <?php echo e($product->name); ?>?')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button class="action-btn btn-cancel" title="Delete Permanently"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg></button>
                                </form>
                            <?php else: ?>
                                <a href="<?php echo e(route('admin.products.details', $product->id)); ?>" class="action-btn btn-view" title="View Details"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></a>
                                <a href="<?php echo e(route('admin.products.edit', $product->id)); ?>" class="action-btn btn-edit" title="Edit"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></a>
                                <form action="<?php echo e(route('admin.products.destroy', $product->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Delete this product?')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button class="action-btn btn-cancel" title="Delete"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg></button>
                                </form>
                            <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="12" class="text-center py-4 text-muted"><?php echo e(request()->has('trashed') ? 'Trash is empty.' : 'No products found.'); ?></td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if($products->hasPages()): ?>
            <div class="d-flex justify-content-center py-3">
                <?php echo e($products->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/stautoparts/resources/views/admin/products/index.blade.php ENDPATH**/ ?>