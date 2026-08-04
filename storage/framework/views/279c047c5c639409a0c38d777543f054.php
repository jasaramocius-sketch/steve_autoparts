<?php $__env->startSection('page-id', 'dashboard-page'); ?>
<?php $__env->startSection('page-class', 'dashboard-page'); ?>    
<?php $__env->startSection('content'); ?>

<h3>
    Welcome,
    <?php echo e(session('user_profile.name')); ?>

</h3>

<p>
    Role :
    <?php echo e(ucfirst(session('user_profile.role'))); ?>

</p>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/stautoparts/resources/views/dashboard/index.blade.php ENDPATH**/ ?>