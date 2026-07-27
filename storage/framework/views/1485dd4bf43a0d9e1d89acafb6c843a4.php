<?php $__env->startSection('page-title', 'Coupons'); ?>
<?php $__env->startSection('content'); ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0">All Coupons</h4>
    <a href="<?php echo e(route('admin.coupons.create')); ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Add Coupon</a>
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
                Showing <?php echo e($coupons->firstItem()); ?>-<?php echo e($coupons->lastItem()); ?> of <?php echo e($coupons->total()); ?>

            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3"><a href="<?php echo e(sortUrl('id', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark"># <?php echo sortIndicator('id', $sortBy, $sortDir); ?></a></th>
                        <th><a href="<?php echo e(sortUrl('code', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark">Code <?php echo sortIndicator('code', $sortBy, $sortDir); ?></a></th>
                        <th><a href="<?php echo e(sortUrl('type', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark">Type <?php echo sortIndicator('type', $sortBy, $sortDir); ?></a></th>
                        <th><a href="<?php echo e(sortUrl('value', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark">Value <?php echo sortIndicator('value', $sortBy, $sortDir); ?></a></th>
                        <th>Min Order</th>
                        <th>Uses</th>
                        <th><a href="<?php echo e(sortUrl('expires_at', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark">Expires <?php echo sortIndicator('expires_at', $sortBy, $sortDir); ?></a></th>
                        <th><a href="<?php echo e(sortUrl('status', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark">Status <?php echo sortIndicator('status', $sortBy, $sortDir); ?></a></th>
                        <th class="pe-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $coupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coupon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="ps-3"><?php echo e($coupon->id); ?></td>
                        <td><strong><?php echo e($coupon->code); ?></strong></td>
                        <td><?php echo e(ucfirst($coupon->type)); ?></td>
                        <td>
                            <?php if($coupon->type === 'percentage'): ?>
                                <?php echo e($coupon->value); ?>%
                            <?php else: ?>
                                <?php echo e(currency_format($coupon->value)); ?>

                            <?php endif; ?>
                        </td>
                        <td><?php echo e($coupon->min_order_amount ? currency_format($coupon->min_order_amount) : '—'); ?></td>
                        <td><?php echo e($coupon->used_count); ?><?php echo e($coupon->max_uses ? ' / ' . $coupon->max_uses : ''); ?></td>
                        <td><?php echo e($coupon->expires_at ? $coupon->expires_at->format('d M Y') : '—'); ?></td>
                        <td>
                            <span class="badge <?php echo e($coupon->status ? 'bg-light text-success border border-success-subtle' : 'bg-light text-danger border border-danger-subtle'); ?>">
                                <?php echo e($coupon->status ? 'Active' : 'Inactive'); ?>

                            </span>
                        </td>
                        <td class="pe-3 table-action-col">
                            <div class="action-buttons">
                            <a href="<?php echo e(route('admin.coupons.edit', $coupon->id)); ?>" class="action-btn btn-edit" title="Edit"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></a>
                            <form action="<?php echo e(route('admin.coupons.destroy', $coupon->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Delete coupon <?php echo e($coupon->code); ?>?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button class="action-btn btn-cancel" title="Delete"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg></button>
                            </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="9" class="text-center py-4 text-muted">No results found.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if($coupons->hasPages()): ?>
            <div class="d-flex justify-content-center py-3"><?php echo e($coupons->links()); ?></div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/stautoparts/resources/views/admin/coupons/index.blade.php ENDPATH**/ ?>