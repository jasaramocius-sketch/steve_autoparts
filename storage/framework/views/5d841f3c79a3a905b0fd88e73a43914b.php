<?php $__env->startSection('page-id', 'user-order-details-page'); ?>
<?php $__env->startSection('page-class', 'user-order-details-page'); ?>
<?php $__env->startSection('dashboard-content'); ?>

<?php
    $shipping = is_array($order->shipping_details)
        ? $order->shipping_details
        : json_decode($order->shipping_details, true);

    $shippingFee = $order->shipping_fee ?? 0;
    $taxAmount = $order->tax ?? 0;
    $totalAmount = $order->total_amount ?? 0;
    $subTotal = $totalAmount - $shippingFee - $taxAmount;

    $statusSteps = ['Order Placed', 'On Review', 'On Delivery', 'Delivered'];
    $currentStatus = $order->status ?? 'pending';
    $statusMap = [
        'pending' => 0,
        'processing' => 0,
        'shipped' => 1,
        'delivered' => 3,
        'cancelled' => -1,
    ];
    $currentStep = $statusMap[$currentStatus] ?? 0;
?>
<div class="gs-deposit-title ms-0 mb-4 d-flex align-items-center gap-3">
    <a href="<?php echo e(route('user.orders')); ?>" class="back-btn">
        <i class="fas fa-arrow-left me-1"></i> 
    </a>
    <h2 class="ud-page-title">Purchase Items</h2>   
</div>

<div class="ud-page-title-box" style="justify-content:space-between;">
    <div>
        <h3 style="margin:0;">Order# <?php echo e($order->order_number ?? '#' . $order->id); ?><span style="color:var(--primary);font-weight:400;font-size:24px;margin-left:8px;">[<?php echo e($currentStatus); ?>]</span></h3>
        <p style="margin:4px 0 0 0;color:#796866;">Order Date <?php echo e(optional($order->created_at)->format('d-M-Y')); ?></p>
    </div>
    <div style="display:flex;gap:12px;align-items:flex-start;">
        <a href="<?php echo e(route('user.orders.invoice', $order->id)); ?>" target="_blank" class="template-btn outline-btn lg-btn steve-btn steve-btn-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
            Print Order
        </a>
    </div>
</div>

<div class="gs-checkout-wrapper"    >
    <div class="checkout-step-wrapper" style="margin-bottom:40px;">
        <span class="line"></span>
        <?php
            $statusPercent = $currentStep >= 0 ? ($currentStep / (count($statusSteps) - 1)) * 100 : 0;
        ?>
        <span style="position:absolute;top:31%;z-index:2;width:<?php echo e($statusPercent); ?>%;border-top:2px solid var(--primary);left:50px;transition:width 0.5s;max-width:calc(100% - 100px);"></span>

        <?php $__currentLoopData = $statusSteps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $isActive = $index <= $currentStep;
                $isCurrent = $index == $currentStep;
            ?>
            <div class="single-step <?php echo e($isActive ? 'active' : ''); ?>">
                <div class="step-btn"><?php echo e($index + 1); ?></div>
                <div class="step-txt" style="<?php echo e($isActive ? 'color:var(--primary);' : ''); ?>"><?php echo e($step); ?></div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>

<div class="row g-4 mt-4">
    <div class="col-lg-6">
        <h5 style="font-weight:500;margin-bottom:16px;">Pickup Address</h5>
        <?php if(!empty($shipping)): ?>
            
            <p style="font-size:16px;color:#4c3533;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#796866" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                <?php echo e($shipping['address'] === "old('address')" ? 'Street Address' : $shipping['address']); ?>,
                <?php echo e($shipping['city'] ?? ''); ?>, <?php echo e($shipping['state'] ?? ''); ?> - <?php echo e($shipping['zip_code'] ?? ''); ?>

            </p>
        <?php else: ?>
            <p style="font-size:16px;color:#796866;">Not provided</p>
        <?php endif; ?>
    </div>

    <div class="col-lg-6">
        <h5 style="font-weight:500;margin-bottom:16px;">Billing Address</h5>
        <?php if(!empty($shipping)): ?>
            <div style="display:flex;flex-direction:column;gap:8px;">
                <?php if(!empty($shipping['name'])): ?>
                <div style="display:flex;align-items:center;gap:8px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#796866" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    <p style="margin:0;font-size:16px;color:#4c3533;"><?php echo e($shipping['name']); ?></p>
                </div>
                <?php endif; ?>
                <div style="display:flex;align-items:center;gap:8px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#796866" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                    <p style="margin:0;font-size:16px;color:#4c3533;">
                        <?php echo e($shipping['address'] === "old('address')" ? 'Street Address' : $shipping['address']); ?>,
                        <?php echo e($shipping['city'] ?? ''); ?><?php echo e(!empty($shipping['city']) && !empty($shipping['zip_code']) ? ',' : ''); ?>

                        <?php echo e($shipping['zip_code'] ?? ''); ?>

                    </p>
                </div>
                <?php if(!empty($shipping['phone'])): ?>
                <div style="display:flex;align-items:center;gap:8px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#796866" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                    <p style="margin:0;font-size:16px;color:#4c3533;"><?php echo e($shipping['phone']); ?></p>
                </div>
                <?php endif; ?>
                <?php if(!empty($shipping['email'])): ?>
                <div style="display:flex;align-items:center;gap:8px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#796866" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                    <p style="margin:0;font-size:16px;color:#4c3533;"><?php echo e($shipping['email']); ?></p>
                </div>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <p style="font-size:16px;color:#796866;">Not provided</p>
        <?php endif; ?>
    </div>
</div>

<div class="row g-4 mt-2">
    <div class="col-lg-6">
        <h5 style="font-weight:500;margin-bottom:16px;">Payment Information</h5>
        <div style="display:flex;flex-direction:column;gap:8px;">
            <p style="margin:0;font-size:16px;color:#4c3533;">
                <span style="font-weight:500;">Payment Status :</span>
                <?php if($currentStatus == 'delivered'): ?>
                    <span style="color:#27be69;">Paid</span>
                <?php elseif($currentStatus == 'cancelled'): ?>
                    <span style="color:#f2415a;">Cancelled</span>
                <?php else: ?>
                    <span style="color:#fac03c;">Unpaid</span>
                <?php endif; ?>
            </p>
            <p style="margin:0;font-size:16px;color:#4c3533;">
                <span style="font-weight:500;">Tax :</span> <?php echo e(currency_format($taxAmount)); ?>

            </p>
            <p style="margin:0;font-size:16px;color:#4c3533;">
                <span style="font-weight:500;">Paid Amount :</span> <?php echo e(currency_format($totalAmount)); ?>

            </p>
            <p style="margin:0;font-size:16px;color:#4c3533;">
                <span style="font-weight:500;">Payment Method :</span> <?php echo e($order->payment_method ? ucfirst(str_replace('_', ' ', $order->payment_method)) : 'Cash On Delivery'); ?>

            </p>
        </div>
    </div>

    <div class="col-lg-6">
        <h5 style="font-weight:500;margin-bottom:16px;">Shipping Method</h5>
        <p style="font-size:16px;color:#4c3533;"><?php echo e($order->delivery_type ?? 'Free Shipping'); ?></p>
    </div>
</div>

<div class="ordered-products">
    <h4 style="margin-top:40px;font-weight:600;">Purchase Items</h4>
    <div class="table-responsive">
        <table class="table">
            <thead class="ordered-tbg">
                <tr>
                    <th width="40%">
                        <span class="title">Product</span>
                    </th>
                    <th>
                        <span class="title">Variation</span>
                    </th>
                    <th>
                        <span class="title">Quantity</span>
                    </th>
                    <th>
                        <span class="title">Delivery Type</span>
                    </th>
                    <th>
                        <span class="title">Price</span>
                    </th>
                    <th>
                        <span class="title">Review</span>
                    </th>
                </tr>
            </thead>
            <tbody class="tbody-product">
                <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="td-product-name">
                        <ul>
                            <li>
                                <span><?php echo e(sprintf('%02d', $key + 1)); ?>.</span>
                                <?php if($item->product): ?>
                                    <a href="<?php echo e(route('product', $item->product->slug ?? '')); ?>" target="_blank" class="text-reset fw-600">
                                        <?php echo e($item->product->name); ?>

                                    </a>
                                <?php else: ?>
                                    <span class="text-muted">Product Unavailable</span>
                                <?php endif; ?>
                            </li>
                        </ul>
                    </td>
                    <td><?php echo e($item->variation ?? '—'); ?></td>
                    <td><?php echo e($item->quantity ?? $item->qty ?? 1); ?></td>
                    <td><?php echo e(ucfirst($order->delivery_type ?? 'Home Delivery')); ?></td>
                    <td><span><?php echo e(currency_format($item->price ?? 0)); ?></span></td>
                    <td>
                        <?php if($order->status == 'delivered'): ?>
                            <a href="#" class="btn btn-sm btn-dark rounded-pill px-3">Write Review</a>
                        <?php else: ?>
                            <span class="text-danger">Not Delivered Yet</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/stautoparts/resources/views/orders/show.blade.php ENDPATH**/ ?>