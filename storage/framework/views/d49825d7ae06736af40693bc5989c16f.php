<?php $__env->startSection('page-title', 'My Profile'); ?>

<?php $__env->startSection('content'); ?>

<?php if($errors->any()): ?>
    <div class="alert alert-danger">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div><?php echo e($error); ?></div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php endif; ?>
<!-- Account Details Panel -->
<div class="acc-info-wrapper rounded p-4" style="background-color: #fcfbfb; border: 1px solid #eee;">
    <h4 style="color: #1f0300; font-weight: 600;" class="mb-3">Account Details</h4>
    <div class="list-wrapper">
    <div class="row w-100">
        <div class="col-md-6">
        <ul class="list-unstyled d-flex flex-column gap-2">
            <li><strong class="text-secondary" style="font-size: 14px;">Name:</strong> <span class="user-name text-transform-capitalize" style="font-weight: 500;"><?php echo e($user['name']); ?></span></li>
            <li><strong class="text-secondary" style="font-size: 14px;">Email Address:</strong> <span class="user-email text-transform-capitalize" style="font-weight: 500;"><?php echo e($user['email']); ?></span></li>
            <li><strong class="text-secondary" style="font-size: 14px;">Phone:</strong> <span class="user-phone text-transform-capitalize" style="font-weight: 500;"><?php echo e($user['phone']); ?></span></li>
        </ul>
        </div>
        <div class="col-md-6">
        <ul class="list-unstyled d-flex flex-column gap-2">
            <li><strong class="text-secondary" style="font-size: 14px;">Address:</strong> <span class="user-address text-transform-capitalize" style="font-weight: 500;"><?php echo $user['address']; ?></span></li>
            <li><strong class="text-secondary" style="font-size: 14px;">City:</strong> <span class="user-city text-transform-capitalize" style="font-weight: 500;"><?php echo e($user['city']); ?></span></li>
            <li><strong class="text-secondary" style="font-size: 14px;">Country:</strong> <span class="user-country text-transform-capitalize" style="font-weight: 500;"><?php echo e($user['country']); ?></span></li>
        </ul>
        </div>
    </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="card card-box shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">Profile Settings</h5>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('admin.profile.update')); ?>" method="POST">
                    <?php echo csrf_field(); ?>

                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control text-transform-capitalize" value="<?php echo e($user->name); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control text-transform-capitalize" value="<?php echo e($user->email); ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="tel" name="phone" class="form-control text-transform-capitalize" inputmode="numeric" value="<?php echo e($user->phone); ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">City</label>
                        <input type="text" name="city" class="form-control text-transform-capitalize" value="<?php echo e($user->city); ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Country</label>
                        <input type="text" name="country" class="form-control text-transform-capitalize" value="<?php echo e($user->country); ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control text-transform-capitalize" rows="3"><?php echo e($user->address); ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary text-transform-capitalize steve-btn">Update Profile</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card card-box shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">Change Password</h5>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('admin.profile.password')); ?>" method="POST">
                    <?php echo csrf_field(); ?>

                    <div class="mb-3">
                        <label class="form-label">Current Password</label>
                        <input type="password" name="current_password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" name="new_password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" name="new_password_confirmation" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-warning steve-btn">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/stautoparts/resources/views/admin/profile.blade.php ENDPATH**/ ?>