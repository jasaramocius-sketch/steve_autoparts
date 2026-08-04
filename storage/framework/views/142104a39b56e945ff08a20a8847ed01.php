<?php $__env->startSection('page-id', 'checkout-delivery-info'); ?>
<?php $__env->startSection('page-class', 'checkout-page delivery-step-body bg-light'); ?>
<?php $__env->startSection('title', 'Delivery Info' . ' - ' . config('app.name', 'StAutoparts')); ?>
<?php $__env->startSection('content'); ?>

<?php echo $__env->make('partials.checkout-steps', ['activeStep' => 3], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<section class="py-4">
  <div class="container">
    <div class="row">
      <div class="mx-auto">
        <div class="border bg-white p-4 mb-4">
          <form class="form-default" action="<?php echo e(route('checkout.delivery-info.store')); ?>" role="form" method="POST">
            <?php echo csrf_field(); ?>

            <div class="card mb-5 border-0 rounded-0 shadow-none">
              <div class="card-header py-3 px-0 border-bottom-0 bg-white">
                <h5 class="fs-16 fw-700 text-dark mb-0">SteveAutoPartsInc. Inhouse Products</h5>
              </div>
              <div class="card-body p-0">
                <ul class="list-group list-group-flush border p-3 mb-3">
                  <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <li class="list-group-item px-0 px-md-3">
                    <div class="d-flex align-items-center delivery-info-page-products">
                      <span class="mr-2 mr-md-3 flex-shrink-0">
                        <?php echo imgTag(
                          'assets/images/thumbnails/'.basename($item['image']),
                          $item['name'],
                          'img-fit size-60px',
                          ''
                        ); ?>

                      </span>
                      <span class="fs-14 fw-400 text-dark">
                        <?php echo e($item['name']); ?>

                        <br>
                      </span>
                    </div>
                  </li>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>

                <div class="row pt-3">
                  <div class="col-md-6">
                    <h6 class="fs-14 fw-700 mt-3">Choose Delivery Type</h6>
                  </div>
                  <div class="col-md-6">
                    <div class="row gutters-5 justify-content-end">
                      <div class="col-6">
                        <label class="aiz-megabox d-block bg-white mb-0">
                          <input type="radio" name="shipping_method" value="free" checked class="d-none">
                          <span class="d-flex aiz-megabox-elem rounded-0" style="padding: 0.75rem 1.2rem;">
                            <span class="aiz-rounded-check flex-shrink-0 mt-1"></span>
                            <span class="flex-grow-1 pl-3 fw-600">Home Delivery</span>
                          </span>
                        </label>
                      </div>
                    </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="pt-4 d-flex justify-content-between align-items-center">
              <a href="<?php echo e(route('shop')); ?>" class="btn-link fw-700 px-0 a-tag-hover-color">
                <i class="fas fa-arrow-left fs-16"></i>
                Return to shop
              </a>
              <button type="submit" class="btn btn-primary fw-700 px-4 steve-btn">Continue to Payment</button>
            </div>
            </div>

            
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/stautoparts/resources/views/delivery-info.blade.php ENDPATH**/ ?>