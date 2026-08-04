<?php $__env->startSection('page-id', 'user-password-page'); ?>
<?php $__env->startSection('page-class', 'user-password-page'); ?>
<?php $__env->startSection('dashboard-content'); ?>

<form action="<?php echo e(route('user.change.password.update')); ?>" method="POST">
<?php echo csrf_field(); ?>

<input type="password"
name="current_password"
class="form-control mb-3"
placeholder="Current Password" required>

<input type="password"
name="new_password"
class="form-control mb-3"
placeholder="New Password" required>

<input type="password"
name="new_password_confirmation"
class="form-control mb-3"
placeholder="Confirm Password" required>

<button class="btn btn-primary steve-btn">
Update Password
</button>

</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('user.layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/stautoparts/resources/views/user/change-password.blade.php ENDPATH**/ ?>