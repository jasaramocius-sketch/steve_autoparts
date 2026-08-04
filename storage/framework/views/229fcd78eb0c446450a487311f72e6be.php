<?php
  $checkoutSteps = [
    1 => ['1. My Cart', 'las la-shopping-cart', route('cart')],
    2 => ['2. Shipping info', 'las la-map', route('checkout')],
    3 => ['3. Delivery info', 'las la-truck', route('checkout.delivery-info')],
    4 => ['4. Payment', 'las la-credit-card', route('checkout.payment')],
    5 => ['5. Confirmation', 'las la-check-circle', route('checkout.confirmed')],
  ];
?>
<section class="pt-5 mb-4" id="cart-summary">
  <div class="container">
    <div class="row">
      <div class="mx-auto">
        <div class="row gutters-5 sm-gutters-10">
          <?php $__currentLoopData = $checkoutSteps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $step => $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php ($label = $info[0]); ?>
            <?php ($icon = $info[1]); ?>
            <?php ($url = $info[2]); ?>

            <?php if($step < $activeStep): ?>
              <div class="col done">
                <a href="<?php echo e($url); ?>" class="d-block text-reset">
                  <div class="text-center border border-bottom-6px p-2 text-success">
                    <i class="la-3x mb-2 <?php echo e($icon); ?>"></i>
                    <h3 class="fs-14 fw-600 d-none d-lg-block"><?php echo e($label); ?></h3>
                  </div>
                </a>
              </div>
            <?php elseif($step == $activeStep): ?>
              <div class="col active">
                <div class="text-center border border-bottom-6px p-2 text-primary">
                  <i class="la-3x mb-2 <?php echo e($icon); ?> cart-animate"></i>
                  <h3 class="fs-14 fw-600 d-none d-lg-block"><?php echo e($label); ?></h3>
                </div>
              </div>
            <?php else: ?>
              <div class="col">
                <div class="text-center border border-bottom-6px p-2">
                  <i class="la-3x mb-2 opacity-50 <?php echo e($icon); ?>"></i>
                  <h3 class="fs-14 fw-600 d-none d-lg-block opacity-50"><?php echo e($label); ?></h3>
                </div>
              </div>
            <?php endif; ?>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        </div>
    </div>
  </div>
</section>
<?php /**PATH /var/www/html/stautoparts/resources/views/partials/checkout-steps.blade.php ENDPATH**/ ?>