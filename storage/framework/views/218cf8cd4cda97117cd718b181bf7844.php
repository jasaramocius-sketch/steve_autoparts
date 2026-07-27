<?php $__env->startSection('page-title', 'Orders'); ?>
<?php $__env->startSection('content'); ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0">All Orders</h4>
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
                Showing <?php echo e($orders->firstItem()); ?>-<?php echo e($orders->lastItem()); ?> of <?php echo e($orders->total()); ?>

            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3"><a href="<?php echo e(sortUrl('id', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark">Order # <?php echo sortIndicator('id', $sortBy, $sortDir); ?></a></th>
                        <th>Customer</th>
                        <th><a href="<?php echo e(sortUrl('total_amount', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark">Total <?php echo sortIndicator('total_amount', $sortBy, $sortDir); ?></a></th>
                        <th><a href="<?php echo e(sortUrl('status', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark">Status <?php echo sortIndicator('status', $sortBy, $sortDir); ?></a></th>
                        <th><a href="<?php echo e(sortUrl('created_at', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark">Date <?php echo sortIndicator('created_at', $sortBy, $sortDir); ?></a></th>
                        <th class="pe-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="ps-3"><?php echo e($order->order_number ?? '#' . $order->id); ?></td>
                        <td><?php echo e($order->user->name ?? 'Guest'); ?></td>
                        <td><?php echo e(currency_format($order->total_amount ?? $order->total ?? 0)); ?></td>
                        <td>
                            <?php
                                $badgeClass = match($order->status) {
                                    'pending' => 'bg-light text-warning border border-warning-subtle',
                                    'processing' => 'bg-light text-info border border-info-subtle',
                                    'shipped' => 'bg-light text-primary border border-primary-subtle',
                                    'delivered' => 'bg-light text-success border border-success-subtle',
                                    'cancelled' => 'bg-light text-danger border border-danger-subtle',
                                    default => 'bg-light text-secondary border border-secondary-subtle',
                                };
                            ?>
                            <span class="badge <?php echo e($badgeClass); ?>"><?php echo e(ucfirst($order->status)); ?></span>
                        </td>
                        <td><?php echo e($order->created_at->format('M d, Y')); ?></td>
                        <td class="pe-3 table-action-col">
                            <div class="action-buttons">
                                <a href="<?php echo e(route('admin.orders.show', $order->id)); ?>" class="action-btn btn-view" title="View Order"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">No orders yet</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if($orders->hasPages()): ?>
            <div class="d-flex justify-content-center py-3"><?php echo e($orders->links()); ?></div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/stautoparts/resources/views/admin/orders/index.blade.php ENDPATH**/ ?>