<?php $__env->startSection('page-title', 'All Brands'); ?>
<?php $__env->startSection('content'); ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <div class=""></div>
    <a href="<?php echo e(route('admin.brands.create')); ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Add Brand</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="d-flex justify-content-between align-items-center px-3 pt-3 pb-2">
            <div class="d-flex align-items-center gap-2">
                <span class="text-muted small">Show</span>
                <select class="form-select form-select-sm" style="width: auto;" onchange="window.location.href=this.value">
                    <?php $__currentLoopData = [10, 20, 50, 100]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e(request()->fullUrlWithQuery(['per_page' => $n])); ?>" <?php echo e((int)request('per_page', 10) === $n ? 'selected' : ''); ?>><?php echo e($n); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <span class="text-muted small">per page</span>
            </div>
            <div class="text-muted small">
                Showing <?php echo e($brands->firstItem()); ?>-<?php echo e($brands->lastItem()); ?> of <?php echo e($brands->total()); ?>

            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3"><a href="<?php echo e(sortUrl('id', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark"># <?php echo sortIndicator('id', $sortBy, $sortDir); ?></a></th>
                        <th>Image</th>
                        <th><a href="<?php echo e(sortUrl('name', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark">Name <?php echo sortIndicator('name', $sortBy, $sortDir); ?></a></th>
                        <th>Website</th>
                        <th><a href="<?php echo e(sortUrl('status', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark">Status <?php echo sortIndicator('status', $sortBy, $sortDir); ?></a></th>
                        <th class="pe-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="ps-3"><?php echo e($brand->id); ?></td>
                        <td>
                            <?php if($brand->image): ?>
                                <img src="<?php echo e(asset('assets/images/brands/' . $brand->image)); ?>" width="50" height="50" style="object-fit:cover; border-radius:4px;">
                            <?php else: ?>
                                <span class="text-muted">—</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($brand->name); ?></td>
                        <td>
                            <?php if($brand->website): ?>
                                <a href="<?php echo e($brand->website); ?>" target="_blank"><?php echo e($brand->website); ?></a>
                            <?php else: ?>
                                <span class="text-muted">—</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <form action="<?php echo e(route('admin.brands.toggle-status', $brand->id)); ?>" method="POST" class="d-inline featured-status-btn">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-sm border-0 p-0 steve-btn">
                                    <span class="badge <?php echo e($brand->status ? 'bg-success' : 'bg-danger'); ?>" style="cursor:pointer;">
                                        <?php echo e($brand->status ? 'Active' : 'Inactive'); ?>

                                    </span>
                                </button>
                            </form>
                        </td>
                        <td class="pe-3 table-action-col">
                            <div class="action-buttons">
                            <a href="<?php echo e(route('admin.brands.edit', $brand->id)); ?>" class="action-btn btn-edit" title="Edit">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </a>
                            <form action="<?php echo e(route('admin.brands.destroy', $brand->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Delete <?php echo e($brand->name); ?>?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button class="action-btn btn-cancel" title="Delete">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                </button>
                            </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">No results found.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if($brands->hasPages()): ?>
            <div class="d-flex justify-content-center py-3"><?php echo e($brands->links()); ?></div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/stautoparts/resources/views/admin/brands/index.blade.php ENDPATH**/ ?>