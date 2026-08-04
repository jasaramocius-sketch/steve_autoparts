<?php $__env->startSection('page-id', 'order-confirmed-page'); ?>
<?php $__env->startSection('page-class', 'order-confirmed-page'); ?>
<?php $__env->startSection('title', 'Order Confirmed' . ' - ' . config('app.name', 'StAutoparts')); ?>
<?php $__env->startSection('content'); ?>

<?php
  $subtotal = collect($order['items'] ?? [])->sum(fn($item) => $item['price'] * $item['qty']);
  $shipping = max(($order['total'] ?? 0) - $subtotal, 0);
  $paymentLabels = [
    'cod' => 'Cash on Delivery',
    'card' => 'Credit / Debit Card',
    'paypal' => 'Paypal',
  ];
  $paymentMethod = $paymentLabels[$order['payment_method'] ?? 'cod'] ?? ($order['payment_method'] ?? 'Cash on Delivery');
  $orderCode = ltrim($order['id'] ?? '', '#');
?>
<?php echo $__env->make('partials.checkout-steps', ['activeStep' => 5], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<section class="py-4">
  <div class="container text-left">
    <div class="row">
      <div class="mx-auto">
        <div class="text-center py-4 mb-0">
          <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36" class="mb-3">
            <g transform="translate(-978 -481)">
              <circle cx="18" cy="18" r="18" transform="translate(978 481)" fill="#85b567"></circle>
              <g transform="translate(32.439 8.975)">
                <rect width="11" height="3" rx="1.5" transform="translate(955.43 487.707) rotate(45)" fill="#fff"></rect>
                <rect width="3" height="18" rx="1.5" transform="translate(971.692 482.757) rotate(45)" fill="#fff"></rect>
              </g>
            </g>
          </svg>
          <h1 class="mb-2 fs-28 fw-500 text-success">Thank You for Your Order!</h1>
          <p class="fs-13 text-soft-dark">A copy or your order summary has been sent to <strong><?php echo e($order['customer_email'] ?? 'N/A'); ?></strong></p>
        </div>

        <div class="mb-4 bg-white p-4 border">
          <h5 class="fw-600 mb-3 fs-16 text-soft-dark pb-2 border-bottom">Order Summary</h5>
          <div class="row">
            <div class="col-md-6">
              <table class="table fs-14 text-soft-dark mb-0">
                <tbody>
                  <tr>
                    <td class="w-50 fw-600 border-top-0 pl-0 py-2">Order date:</td>
                    <td class="border-top-0 py-2"><?php echo e($order['date'] ?? now()->format('d M, Y')); ?></td>
                  </tr>
                  <tr>
                    <td class="w-50 fw-600 border-top-0 pl-0 py-2">Name:</td>
                    <td class="border-top-0 py-2"><?php echo e($order['customer_name'] ?? 'N/A'); ?></td>
                  </tr>
                  <tr>
                    <td class="w-50 fw-600 border-top-0 pl-0 py-2">Email:</td>
                    <td class="border-top-0 py-2"><?php echo e($order['customer_email'] ?? 'N/A'); ?></td>
                  </tr>
                  <tr>
                    <td class="w-50 fw-600 border-top-0 pl-0 py-2">Shipping address:</td>
                    <td class="border-top-0 py-2"><?php echo e($order['address'] ?? 'N/A'); ?></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="col-md-6">
              <table class="table fs-14 text-soft-dark mb-0">
                <tbody>
                  <tr>
                    <td class="w-50 fw-600 border-top-0 py-2">Order status:</td>
                    <td class="border-top-0 pr-0 py-2"><?php echo e($order['status'] ?? 'Pending'); ?></td>
                  </tr>
                  <tr>
                    <td class="w-50 fw-600 border-top-0 py-2">Total order amount:</td>
                    <td class="border-top-0 pr-0 py-2"><?php echo e(currency_format($order['total'] ?? 0)); ?></td>
                  </tr>
                  <tr>
                    <td class="w-50 fw-600 border-top-0 py-2">Shipping:</td>
                    <td class="border-top-0 pr-0 py-2"><?php echo e($shipping > 0 ? 'Flat shipping rate' : 'Free shipping'); ?></td>
                  </tr>
                  <tr>
                    <td class="w-50 fw-600 border-top-0 py-2">Payment method:</td>
                    <td class="border-top-0 pr-0 py-2"><?php echo e($paymentMethod); ?></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="card shadow-none border rounded-0">
          <div class="card-body">
            <div class="text-center py-1 mb-4">
              <h2 class="h5 fs-20">Order Code: <span class="fw-700 text-primary"><?php echo e($orderCode); ?></span></h2>
            </div>

            <div>
              <h5 class="fw-600 text-soft-dark mb-3 fs-16 pb-2">Order Details</h5>
              <div>
                <table class="table table-responsive-md text-soft-dark fs-14">
                  <thead>
                    <tr>
                      <th class="opacity-60 border-top-0 pl-0">#</th>
                      <th class="opacity-60 border-top-0" width="30%">Product</th>
                      <th class="opacity-60 border-top-0">Variation</th>
                      <th class="opacity-60 border-top-0">Quantity</th>
                      <th class="opacity-60 border-top-0">Delivery Type</th>
                      <th class="text-right opacity-60 border-top-0 pr-0">Price</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $__currentLoopData = $order['items'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                      <td class="border-top-0 border-bottom pl-0"><?php echo e($loop->iteration); ?></td>
                      <td class="border-top-0 border-bottom">
                        <span class="text-reset"><?php echo e($item['name'] ?? 'N/A'); ?></span>
                      </td>
                      <td class="border-top-0 border-bottom"></td>
                      <td class="border-top-0 border-bottom"><?php echo e($item['qty'] ?? 0); ?></td>
                      <td class="border-top-0 border-bottom">Home Delivery</td>
                      <td class="border-top-0 border-bottom pr-0 text-right"><?php echo e(currency_format(($item['price'] ?? 0) * ($item['qty'] ?? 0))); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </tbody>
                </table>
              </div>

              <div class="row">
                <div class="col-xl-5 col-md-6 ml-auto mr-0">
                  <table class="table mb-0">
                    <tbody>
                      <tr>
                        <th class="border-top-0 py-2">Subtotal</th>
                        <td class="text-right border-top-0 pr-0 py-2">
                          <span class="fw-600"><?php echo e(currency_format($subtotal)); ?></span>
                        </td>
                      </tr>
                      <tr>
                        <th class="border-top-0 py-2">Shipping</th>
                        <td class="text-right border-top-0 pr-0 py-2">
                          <span><?php echo e(currency_format($shipping)); ?></span>
                        </td>
                      </tr>
                      <tr>
                        <th class="border-top-0 py-2">Tax</th>
                        <td class="text-right border-top-0 pr-0 py-2">
                          <span><?php echo e(currency_format(0)); ?></span>
                        </td>
                      </tr>
                      <tr>
                        <th class="border-top-0 py-2">Coupon Discount</th>
                        <td class="text-right border-top-0 pr-0 py-2">
                          <span><?php echo e(currency_format(0)); ?></span>
                        </td>
                      </tr>
                      <tr>
                        <th class="py-2"><span class="fw-600">Total</span></th>
                        <td class="text-right pr-0">
                          <strong><span><?php echo e(currency_format($order['total'] ?? 0)); ?></span></strong>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div><div class="text-center mt-4">
          <a href="<?php echo e(route('home')); ?>" class="btn btn-primary fs-14 fw-700 rounded-0 px-4">
            Continue Shopping <i class="las la-arrow-right"></i>
          </a>
        </div>
            </div>
          </div>
        </div>

        
      </div>
    </div>
  </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/stautoparts/resources/views/order-confirmed.blade.php ENDPATH**/ ?>