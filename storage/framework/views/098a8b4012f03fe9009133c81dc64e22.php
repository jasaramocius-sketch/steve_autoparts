<div class="modal fade" id="addressModal" tabindex="-1" role="dialog" aria-labelledby="addressModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-600" id="addressModalLabel">Add New Address</h5>
        <button type="button" class="btn-close steve-btn" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="addressForm" method="POST">
        <?php echo csrf_field(); ?>
        <div class="modal-body">
          <input type="hidden" name="_method" value="POST" id="addressFormMethod">
          <div class="row">
            <div class="col-md-12 mb-3">
              <label class="form-label fs-14">Phone <span class="text-danger">*</span></label>
              <input type="tel" name="phone" id="af_phone" class="form-control" inputmode="numeric" required placeholder="+1 (234) 567-890">
            </div>
            <div class="col-md-12 mb-3">
              <label class="form-label fs-14">Address <span class="text-danger">*</span></label>
              <input type="text" name="address" id="af_address" class="form-control" required placeholder="123 Street Name">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fs-14">City <span class="text-danger">*</span></label>
              <input type="text" name="city" id="af_city" class="form-control" required placeholder="New York">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fs-14">State</label>
              <input type="text" name="state" id="af_state" class="form-control" placeholder="NY">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fs-14">Country <span class="text-danger">*</span></label>
              <input type="text" name="country" id="af_country" class="form-control" required placeholder="United States">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fs-14">Postal Code <span class="text-danger">*</span></label>
              <input type="text" name="zip_code" id="af_zip_code" class="form-control" inputmode="numeric" required placeholder="10001">
            </div>
            <div class="col-md-12 mb-3">
              <div class="form-check">
                <input type="checkbox" name="set_default" id="af_set_default" class="form-check-input" value="1">
                <label class="form-check-label fs-14" for="af_set_default">Set as default address</label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary fs-14 fw-600 steve-btn" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary fs-14 fw-600 steve-btn" id="addressFormSubmit">Save Address</button>
        </div>
      </form>
    </div>
  </div>
</div><?php /**PATH /var/www/html/stautoparts/resources/views/partials/address-modal.blade.php ENDPATH**/ ?>