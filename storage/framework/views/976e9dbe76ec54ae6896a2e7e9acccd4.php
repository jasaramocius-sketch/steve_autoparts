<?php $__env->startSection('title', 'Cart' . ' - ' . config('app.name', 'StAutoparts')); ?>
<?php $__env->startSection('content'); ?>

<section class="pt-5 mb-4" id="cart-summary">
  <div class="container">
    <div class="row">
      <div class="col-xl-8 mx-auto">

        <?php echo $__env->make('partials.checkout-steps', ['activeStep' => 1], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div>
    </div>
  </div>
</section>
<section class="mb-4">
  <div class="container">
    <div class="row cols-xs-space cols-sm-space cols-md-space">
      <div class="col-xxl-8 col-xl-10 mx-auto">
        <?php if(count($cart) > 0): ?>
        <div class="border bg-white p-3 p-lg-4">
          <div class="mb-4">
            <div class="row gutters-5 d-none d-lg-flex border-bottom mb-3 pb-3">
              <div class="col-md-5 fw-600">Product</div>
              <div class="col fw-600">Price</div>
              <div class="col fw-600">Qty</div>
              <div class="col fw-600">Total</div>
              <div class="col-auto fw-600">Remove</div>
            </div>
            <ul class="list-group list-group-flush">
              <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <li class="list-group-item px-0 px-lg-3 cart-item" data-id="<?php echo e($key); ?>">
                <div class="row gutters-5 align-items-center cart-summary-item-group">
                  <div class="col-lg-5 d-flex align-items-center cart-summary-item mb-2 mb-lg-0">
                    <span class="mr-2 ml-0 flex-shrink-0">
                      <?php echo imgTag(
                        'assets/images/thumbnails/'.basename($item['image']),
                        $item['name'],
                        'img-fit size-60px',
                        ''
                      ); ?>

                    </span>
                    <span class="fs-14 opacity-60"><?php echo e($item['name']); ?></span>
                  </div>
                  <div class="col-3 col-lg cart-summary-item">
                    <span class="opacity-60 fs-12 d-block d-lg-none">Price</span>
                    <span class="fw-600 fs-16"><?php echo e(currency_format($item['price'])); ?></span>
                  </div>
                  <div class="col-3 col-lg cart-summary-item">
                    <div class="row g-0 align-items-center aiz-plus-minus mr-2 ml-0">
                      <button class="btn col-auto btn-icon btn-sm btn-circle btn-light change-qty steve-btn" type="button" data-action="decrease" data-id="<?php echo e($key); ?>">
                        <i class="las la-minus"></i>
                      </button>
                      <input type="text" class="col border-0 text-center flex-grow-1 fs-16 qty-input" value="<?php echo e($item['qty']); ?>" readonly>
                      <button class="btn col-auto btn-icon btn-sm btn-circle btn-light change-qty steve-btn" type="button" data-action="increase" data-id="<?php echo e($key); ?>">
                        <i class="las la-plus"></i>
                      </button>
                    </div>
                  </div>
                  <div class="col-3 col-lg cart-summary-item">
                    <span class="opacity-60 fs-12 d-block d-lg-none">Total</span>
                    <span class="fw-600 fs-16" id="prc<?php echo e($key); ?>"><?php echo e(currency_format($item['price'] * $item['qty'])); ?></span>
                  </div>
                  <div class="col-auto cart-summary-item">
                    <form action="<?php echo e(route('cart.remove')); ?>" method="POST" class="d-inline remove-form">
                      <?php echo csrf_field(); ?>
                      <input type="hidden" name="product_id" value="<?php echo e($item['id']); ?>">
                      <button type="submit" class="btn btn-icon btn-sm btn-soft-primary btn-circle steve-btn">
                        <i class="las la-trash"></i>
                      </button>
                    </form>
                  </div>
                </div>
              </li>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
          </div>

          <div class="px-3 py-2 mb-4 border-top d-flex justify-content-between">
            <span class="opacity-60 fs-15">Subtotal</span>
            <span class="fw-600 fs-17 total-cart-price-sub total-cart-price-val"><?php echo e(currency_format($total)); ?></span>
          </div>

          <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
              <a href="<?php echo e(route('shop')); ?>" class="fw-600">
                <i class="las la-arrow-left"></i>
                Return to shop
              </a>
              <a href="<?php echo e(route('checkout')); ?>" class="btn btn-primary fs-14 fw-700 rounded-0 px-4">
                Continue to Shipping
              </a>
          </div>
        </div>
        <?php else: ?>
        <div class="border bg-white p-4">
          <div class="text-center p-3">
            <i class="las la-frown la-3x opacity-60 mb-3"></i>
            <h3 class="h4 fw-700">Your Cart is empty</h3>
          </div>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('style'); ?>
<style>
.cart-summary-item-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
@media (max-width: 991px) {
  .cart-summary-item-group .cart-summary-item {
    margin-bottom: 0.5rem;
  }
  .cart-summary-item-group .cart-summary-item:last-child {
    margin-bottom: 0;
  }
  .cart-summary-item-group .cart-summary-item .qty-input {
    width: 32px;
    font-size: 14px !important;
  }
  .cart-summary-item-group .cart-summary-item .btn-circle {
    width: 30px;
    height: 30px;
  }
  .cart-summary-item-group .cart-summary-item .btn-circle i {
    font-size: 12px;
  }
  .cart-summary-item-group .cart-summary-item .fs-16 {
    font-size: 14px !important;
  }
}
@media (max-width: 575px) {
  .cart-summary-item-group .cart-summary-item {
    padding: 0 4px;
  }
  .cart-summary-item-group .cart-summary-item .opacity-60.fs-12 {
    font-size: 10px !important;
  }
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/stautoparts/resources/views/cart.blade.php ENDPATH**/ ?>