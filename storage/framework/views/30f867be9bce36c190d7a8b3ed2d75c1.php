<?php $__env->startSection('page-id', 'checkout-page'); ?>
<?php $__env->startSection('page-class', 'checkout-page'); ?>
<?php $__env->startSection('title', 'Checkout' . ' - ' . config('app.name', 'StAutoparts')); ?>
<?php $__env->startSection('content'); ?>

<?php echo $__env->make('partials.checkout-steps', ['activeStep' => 2], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<section class="mb-4">
  <div class="container">
    <div class="row cols-xs-space cols-sm-space cols-md-space">
      <div class="mx-auto">
        <form class="form-default" data-toggle="validator" action="<?php echo e(route('checkout.submit')); ?>" role="form" method="POST">
          <?php echo csrf_field(); ?>
          <div class="border bg-white p-4 mb-4">
            <?php $__currentLoopData = $addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="border mb-4">
              <div class="row">
                <div class="col-md-8">
                  <label class="aiz-megabox d-block bg-white mb-0">                    
                    <span class="d-flex p-3 aiz-megabox-elem border-0">
                      <input type="radio" name="address_id" value="<?php echo e($address->id); ?>" <?php echo e($loop->first ? 'checked' : ''); ?> required>
                      <span class="flex-grow-1 pl-3 text-left">
                        <div class="row">
                          <span class="fs-14 text-secondary col-3">Address</span>
                          <span class="fs-14 text-dark fw-500 ml-2 col"><?php echo e($address->address ?? 'N/A'); ?></span>
                        </div>
                        <div class="row">
                          <span class="fs-14 text-secondary col-3">Postal code</span>
                          <span class="fs-14 text-dark fw-500 ml-2 col"><?php echo e($address->zip_code ?? 'N/A'); ?></span>
                        </div>
                        <div class="row">
                          <span class="fs-14 text-secondary col-3">City</span>
                          <span class="fs-14 text-dark fw-500 ml-2 col"><?php echo e($address->city ?? 'N/A'); ?></span>
                        </div>
                        <div class="row">
                          <span class="fs-14 text-secondary col-3">State</span>
                          <span class="fs-14 text-dark fw-500 ml-2 col"><?php echo e($address->state ?? 'N/A'); ?></span>
                        </div>
                        <div class="row">
                          <span class="fs-14 text-secondary col-3">Country</span>
                          <span class="fs-14 text-dark fw-500 ml-2 col"><?php echo e($address->country ?? 'N/A'); ?></span>
                        </div>
                        <div class="row">
                          <span class="fs-14 text-secondary col-3">Phone</span>
                          <span class="fs-14 text-dark fw-500 ml-2 col"><?php echo e($address->phone ?? 'N/A'); ?></span>
                        </div>
                      </span>
                    </span>
                  </label>
                </div>
                <div class="col-md-4 p-3 text-end">
                  <a class="btn btn-sm btn-warning text-white mr-4 rounded-0 px-4" onclick="edit_address('<?php echo e($address->id); ?>')">Change</a>
                </div>
              </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <input type="hidden" name="checkout_type" value="logged">

            <?php if(isset($vehicles) && $vehicles->count() > 0): ?>
            <div class="border p-3 mb-4" style="border-radius: 8px; background: #f8f9fa;">
              <h6 class="fw-700 mb-3" style="font-size: 14px; color: #333;">
                <i class="las la-car mr-1"></i> Select Vehicle (Optional)
              </h6>
              <p class="text-muted mb-3" style="font-size: 12px;">Tell us which vehicle these parts are for:</p>
              <div class="row g-2">
                <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-6 col-lg-4">
                  <label class="aiz-megabox d-block bg-white mb-0" style="border-radius: 6px;">
                    <span class="d-flex p-2 aiz-megabox-elem border-0">
                      <input type="radio" name="vehicle_id" value="<?php echo e($vehicle->id); ?>" <?php echo e($vehicle->id == ($selectedVehicleId ?? null) ? 'checked' : ''); ?>>
                      <span class="flex-grow-1 pl-2 text-left">
                        <span class="fs-13 text-dark fw-500"><?php echo e($vehicle->year); ?> <?php echo e($vehicle->make); ?> <?php echo e($vehicle->model); ?></span>
                        <?php if($vehicle->engine): ?>
                          <span class="fs-12 text-muted d-block"><?php echo e($vehicle->engine); ?></span>
                        <?php endif; ?>
                      </span>
                    </span>
                  </label>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-6 col-lg-4">
                  <label class="aiz-megabox d-block bg-white mb-0" style="border-radius: 6px;">
                    <span class="d-flex p-2 aiz-megabox-elem border-0">
                      <input type="radio" name="vehicle_id" value="" <?php echo e($vehicles->isEmpty() || !$selectedVehicleId ? 'checked' : ''); ?>>
                      <span class="flex-grow-1 pl-2 text-left">
                        <span class="fs-13 text-muted fw-500">Not listed above</span>
                      </span>
                    </span>
                  </label>
                </div>
              </div>
            </div>
            <?php endif; ?>

            <div class="mb-5">
              <div class="border p-3 c-pointer text-center bg-light has-transition hov-bg-soft-light h-100 d-flex flex-column justify-content-center" onclick="add_new_address()">
                <i class="las la-plus la-2x mb-3"></i>
                <div class="alpha-7 fw-700">Add New Address</div>
              </div>
            </div>
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
              <a href="<?php echo e(route('shop')); ?>" class="fw-600 a-tag-hover-color">
                <i class="fas fa-arrow-left"></i>
                Return to shop
              </a>
              <button type="submit" class="btn btn-primary fs-14 fw-700 px-4 steve-btn">Continue to Delivery Info</button>
          </div>            
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

<?php echo $__env->make('partials.address-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
function add_new_address() {
    $('#addressModalLabel').text('Add New Address');
    $('#addressForm').attr('action', '<?php echo e(route("checkout.address.store")); ?>');
    $('#addressFormMethod').val('POST');
    $('#addressForm')[0].reset();
    $('#addressFormSubmit').text('Save Address');
    $('#addressModal').modal('show');
}

function edit_address(id) {
    $.get('<?php echo e(url("/checkout/address")); ?>/' + id + '/edit', function(data) {
        $('#addressModalLabel').text('Edit Address');
        $('#addressForm').attr('action', '<?php echo e(url("/checkout/address")); ?>/' + id);
        $('#addressFormMethod').val('PUT');
        $('#af_phone').val(data.phone);
        $('#af_address').val(data.address);
        $('#af_city').val(data.city);
        $('#af_state').val(data.state);
        $('#af_country').val(data.country);
        $('#af_zip_code').val(data.zip_code);
        $('#af_set_default').prop('checked', !!data.set_default);
        $('#addressFormSubmit').text('Update Address');
        $('#addressModal').modal('show');
    });
}

$(document).ready(function() {
    $('#addressForm').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        var method = $('#addressFormMethod').val();
        var data = form.serialize();

        $.ajax({
            url: url,
            type: method,
            data: data,
            success: function(response) {
                if (response.success) {
                    $('#addressModal').modal('hide');
                    location.reload();
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    var msg = '';
                    $.each(errors, function(key, val) {
                        msg += val[0] + '\n';
                    });
                    alert(msg);
                } else {
                    alert('Something went wrong!');
                }
            }
        });
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/stautoparts/resources/views/checkout.blade.php ENDPATH**/ ?>