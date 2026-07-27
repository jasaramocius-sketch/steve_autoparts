<?php $__env->startSection('page-id', 'user-orders-page'); ?>
<?php $__env->startSection('page-class', 'user-orders-page'); ?>
<?php $__env->startSection('dashboard-content'); ?>

<?php
    $currentStatus = request('status', '');
    $statuses = ['', 'pending', 'processing', 'shipped', 'delivered', 'cancelled'];
    $statusLabels = ['' => 'All', 'pending' => 'Pending', 'processing' => 'Processing', 'shipped' => 'Shipped', 'delivered' => 'Delivered', 'cancelled' => 'Cancelled'];
    $deliveryBadges = [
        'pending' => 'badge--warning',
        'processing' => 'badge--info',
        'shipped' => 'badge--primary',
        'delivered' => 'badge--success',
        'cancelled' => 'badge--danger',
    ];
?>
<div class="user-order-page">
<div class="dashboard-topbar">
    <h4 class="mb-0" style="font-size:1.5rem;font-weight:600;color:#1f0300;">Purchase History</h4>
    <a href="<?php echo e(route('shop')); ?>" class="btn btn-primary steve-btn">Continue Shopping</a>
</div>

<div class="dashboard-filter">
    <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e($s ? route('user.orders', ['status' => $s]) : route('user.orders')); ?>"
           class="dashboard-filter__link<?php echo e($currentStatus === $s ? ' active' : ''); ?>">
            <?php echo e($statusLabels[$s]); ?>

        </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<div class="table-responsive">
    <table class="table table--custom table--responsive-lg">
        <thead>
            <tr>
                <th>Order Code</th>
                <th>Date</th>
                <th>Amount</th>
                <th>Delivery Status</th>
                <th>Payment</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $status = strtolower($order->status ?? 'pending');
                    $badge = $deliveryBadges[$status] ?? 'badge--secondary';
                    $isPaid = $order->payment_method && $order->payment_method !== 'cod';
                ?>
                <tr>
                    <td data-label="Order Code" class="order-code">
                        <a href="<?php echo e(route('user.orders.show', $order->id)); ?>">
                            <?php echo e($order->order_number ?? '#' . $order->id); ?>

                        </a>
                    </td>
                    <td data-label="Date">
                        <div>
                        <span><?php echo e(optional($order->created_at)->format('d-m-Y')); ?></span>
                        <span class="d-block" style="font-size:0.8125rem;color:#8a7b79;"><?php echo e(optional($order->created_at)->format('h:i A')); ?></span></div>
                    </td>
                    <td data-label="Amount">
                        <span style="font-weight:600;"><?php echo e(currency_format($order->total_amount ?? 0)); ?></span>
                    </td>
                    <td data-label="Delivery Status">
                        <span class="badge <?php echo e($badge); ?>"><?php echo e($statusLabels[$status] ?? ucfirst($status)); ?></span>
                    </td>
                    <td data-label="Payment">
                        <span class="badge <?php echo e($isPaid ? 'badge--success' : 'badge--danger'); ?>"><?php echo e($isPaid ? 'Paid' : 'Unpaid'); ?></span>
                    </td>
                    <td data-label="Action" class="table-action-col">
                        <div class="action-buttons" style="justify-content:flex-end;">
                            <form action="<?php echo e(route('user.orders.destroy', $order->id)); ?>" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to cancel this order?');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="action-btn btn-cancel" title="Cancel Order">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    </svg>
                                </button>
                            </form>
                            <a href="<?php echo e(route('user.orders.show', $order->id)); ?>" class="action-btn btn-view" title="View Details">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </a>
                            <a href="<?php echo e(route('user.orders.invoice', $order->id)); ?>" target="_blank" class="action-btn btn-invoice" title="Download Invoice">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="7 10 12 15 17 10"></polyline>
                                    <line x1="12" y1="15" x2="12" y2="3"></line>
                                </svg>
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="100%">
                        <div class="empty-section">
                            <div class="empty-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" y1="8" x2="12" y2="12"></line>
                                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                </svg>
                            </div>
                            <h5>No orders found</h5>
                            <p>Your purchased orders will appear here.</p>
                        </div>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php if(method_exists($orders, 'links')): ?>
    <div class="pagination-wrapper">
        <?php echo e($orders->links()); ?>

    </div>
<?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('user.layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/stautoparts/resources/views/user/orders.blade.php ENDPATH**/ ?>