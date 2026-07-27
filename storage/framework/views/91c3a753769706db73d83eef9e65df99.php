<?php $__env->startSection('dashboard-content'); ?>

<div class="gs-order-track-section">
    <div class="ud-page-title-box">
        <h3 style="margin:0;">Order Tracking</h3>
    </div>

    <p style="margin-top:12px;font-size:18px;color:#4c3533;">Track your order status by entering your order number below.</p>

    <div class="order-track-area">
        <div class="order-track-title">
            <h4>Track Your Order</h4>
        </div>

        <form method="POST" action="<?php echo e(route('user.order.tracking')); ?>">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label for="order_number">Order Number / ID</label>
                <input type="text" name="order_number" id="order_number" class="form-control" value="<?php echo e(old('order_number', request('order_number'))); ?>" placeholder="Enter your order number or ID">
                <?php $__errorArgs = ['order_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <small style="color:#f2415a;margin-top:4px;display:block;"><?php echo e($message); ?></small>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group">
                <button type="submit" class="template-btn btn-forms steve-btn">Track Order</button>
            </div>
        </form>
    </div>

    <?php if(request()->isMethod('post') && isset($order)): ?>
        <?php if($order): ?>
            <?php
                $shipping = is_array($order->shipping_details)
                    ? $order->shipping_details
                    : json_decode($order->shipping_details, true);

                $statusSteps = ['Order Placed', 'On Review', 'On Delivery', 'Delivered'];
                $statusMap = [
                    'pending' => 0,
                    'processing' => 0,
                    'shipped' => 1,
                    'delivered' => 3,
                    'cancelled' => -1,
                ];
                $currentStep = $statusMap[$order->status] ?? 0;
            ?>

            <div class="order-track-area" style="margin-top:32px;">
                <h5 style="margin-bottom:24px;">Order #<?php echo e($order->order_number ?? $order->id); ?> <span style="font-weight:400;color:#796866;">— <?php echo e(ucfirst($order->status)); ?></span></h5>

                <div class="gs-checkout-wrapper">
                    <div class="checkout-step-wrapper" style="margin-bottom:0;">
                        <span class="line"></span>
                        <?php $pct = $currentStep >= 0 ? ($currentStep / (count($statusSteps) - 1)) * 100 : 0; ?>
                        <span style="position:absolute;top:30%;z-index:2;width:<?php echo e($pct); ?>%;border-top:2px solid var(--primary);left:50px;transition:width 0.5s;max-width:calc(100% - 100px);"></span>

                        <?php $__currentLoopData = $statusSteps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="single-step <?php echo e($i <= $currentStep ? 'active' : ''); ?>">
                                <div class="step-btn"><?php echo e($i + 1); ?></div>
                                <div class="step-txt" style="<?php echo e($i <= $currentStep ? 'color:var(--primary);' : ''); ?>"><?php echo e($step); ?></div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <div style="margin-top:32px;">
                    <p style="font-size:16px;color:#4c3533;"><strong>Order Date:</strong> <?php echo e(optional($order->created_at)->format('d-M-Y')); ?></p>
                    <p style="font-size:16px;color:#4c3533;"><strong>Total Amount:</strong> <?php echo e(currency_format($order->total_amount ?? 0)); ?></p>
                    <p style="font-size:16px;color:#4c3533;"><strong>Delivery Type:</strong> <?php echo e($order->delivery_type ?? 'Free Shipping'); ?></p>
                </div>

                <div class="ordered-products" style="margin-top:24px;">
                    <h5>Ordered Products</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="ordered-tbg">
                                <tr>
                                    <th><span class="title">Product</span></th>
                                    <th><span class="title">Variation</span></th>
                                    <th><span class="title">Qty</span></th>
                                    <th><span class="title">Price</span></th>
                                </tr>
                            </thead>
                            <tbody class="tbody-product">
                                <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="td-product-name">
                                        <ul><li><span><?php echo e($item->product->name ?? 'Product Unavailable'); ?></span></li></ul>
                                    </td>
                                    <td><?php echo e($item->variation ?? '—'); ?></td>
                                    <td><?php echo e($item->quantity ?? $item->qty ?? 1); ?></td>
                                    <td><span><?php echo e(currency_format($item->price ?? 0)); ?></span></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="order-track-area" style="margin-top:32px;">
                <div style="text-align:center;padding:40px;">
                    <h5 style="color:#f2415a;">Order Not Found</h5>
                    <p style="color:#796866;margin-top:8px;">No order found with the provided order number. Please check and try again.</p>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/stautoparts/resources/views/user/orders/tracking.blade.php ENDPATH**/ ?>