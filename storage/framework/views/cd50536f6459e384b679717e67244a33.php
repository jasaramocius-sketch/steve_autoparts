<?php $cart = session('cart', []); ?>
<?php if(count($cart) > 0): ?>
    <div style="max-height: 300px; overflow-y: auto;">
        <ul class="list-group list-group-flush">
            <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="list-group-item d-flex align-items-center gap-3 px-3 py-3 cart-icon-dropdown-items">
                    <?php echo imgTag('assets/images/thumbnails/'.basename($item['image']), $item['name'], 'cart-icon-dropdown-item-img', 'style="width:50px;height:50px;object-fit:cover;"'); ?>

                    <div class="flex-grow-1 min-w-0 cart-icon-dropdown-item-details">
                        <a href="<?php echo e(route('cart')); ?>" class="text-dark fw-600 fs-14 text-truncate d-block"><?php echo e($item['name']); ?></a>
                        <div class="fs-13 text-secondary">
                            <?php echo e($item['qty']); ?> x <?php echo e(currency_format($item['price'])); ?>

                        </div>
                    </div>
                    <form action="<?php echo e(route('cart.remove')); ?>" method="POST" class="m-0 gs-mini-cart-remove-form">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="product_id" value="<?php echo e($item['id']); ?>">
                        <button type="submit" class="btn btn-sm p-0 border-0 fs-16 text-secondary steve-btn">
                            <i class="las la-times"></i>
                        </button>
                    </form>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
    <div class="px-3 py-3 border-top">
        <div class="d-flex justify-content-between mb-3 fs-14 fw-600">
            <span>Subtotal</span>
            <span class="text-primary cart-total-price"><?php echo e(currency_format($cartTotal ?? 0)); ?></span>
        </div>
        <div class="d-flex gap-2 border-top cart-actions pt-3 mini-cart-actions">
            <a href="<?php echo e(route('cart')); ?>" class="btn btn-warning btn-sm btn-block rounded-4 text-white w-100">
                View Cart
            </a>
            <a href="<?php echo e(route('checkout')); ?>" class="btn btn-primary btn-sm btn-block rounded-4 text-white w-100">
                Checkout
            </a>
        </div>
    </div>
<?php else: ?>
    <div class="text-center p-3">
        <i class="las la-frown la-3x opacity-60 mb-3" style="font-size:3rem;color:#b5b5bf;"></i>
        <h3 class="h6 fw-700">Your Cart is empty</h3>
    </div>
<?php endif; ?><?php /**PATH /var/www/html/stautoparts/resources/views/partials/mini-cart.blade.php ENDPATH**/ ?>