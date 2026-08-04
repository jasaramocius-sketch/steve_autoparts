<?php $__env->startSection('page-id', 'admin-orders-show-page'); ?>
<?php $__env->startSection('page-class', 'admin-orders-show-page'); ?>
<?php $__env->startSection('page-title', 'Order Number' . ' #' . $order->order_number); ?>

<?php $__env->startSection('content'); ?>

<!-- <div class="d-flex justify-content-between align-items-center mb-3">
    <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left"></i> Back</a>
</div> -->

<div class="row g-3">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="fas fa-box me-2"></i>Order Items</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Product Name</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th class="pe-3">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="ps-3"><?php echo e($item->product->name ?? 'Product #' . $item->product_id); ?></td>
                                <td><?php echo e(currency_format($item->price)); ?></td>
                                <td><?php echo e($item->qty); ?></td>
                                <td class="pe-3"><?php echo e(currency_format($item->price * $item->qty)); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">No results found.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="3" class="text-end fw-bold ps-3">Total:</td>
                                <td class="pe-3 fw-bold"><?php echo e(currency_format($order->total_amount)); ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Order Summary</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <th class="text-muted">Order Number</th>
                        <td><?php echo e($order->order_number); ?></td>
                    </tr>
                    <tr>
                        <th class="text-muted">Date</th>
                        <td><?php echo e($order->created_at->format('M d, Y h:i A')); ?></td>
                    </tr>
                    <tr>
                        <th class="text-muted">Status</th>
                        <td>
                            <?php $badge = match($order->status) { 'pending' => 'warning', 'processing' => 'info', 'shipped' => 'primary', 'delivered' => 'success', 'cancelled' => 'danger', default => 'secondary' }; ?>
                            <span class="badge bg-<?php echo e($badge); ?>"><?php echo e(ucfirst($order->status)); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-muted">Customer</th>
                        <td><?php echo e($order->user->name ?? 'Guest'); ?></td>
                    </tr>
                    <tr>
                        <th class="text-muted">Email Address</th>
                        <td><?php echo e($order->user->email ?? '—'); ?></td>
                    </tr>
                    <tr>
                        <th class="text-muted">Total</th>
                        <td class="fw-bold"><?php echo e(currency_format($order->total_amount)); ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Update Status</h5>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('admin.orders.update-status', $order->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <select name="status" class="form-control">
                            <option value="pending" <?php echo e($order->status === 'pending' ? 'selected' : ''); ?>>Pending</option>
                            <option value="processing" <?php echo e($order->status === 'processing' ? 'selected' : ''); ?>>Processing</option>
                            <option value="shipped" <?php echo e($order->status === 'shipped' ? 'selected' : ''); ?>>Shipped</option>
                            <option value="delivered" <?php echo e($order->status === 'delivered' ? 'selected' : ''); ?>>Delivered</option>
                            <option value="cancelled" <?php echo e($order->status === 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                        </select>
                    </div>
                    <button class="btn btn-primary w-100 steve-btn"><i class="fas fa-sync"></i> Update Status</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/stautoparts/resources/views/admin/orders/show.blade.php ENDPATH**/ ?>