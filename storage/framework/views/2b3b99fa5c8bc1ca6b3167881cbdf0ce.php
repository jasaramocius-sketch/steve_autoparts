<?php $__env->startSection('page-id', 'user-privacy-policy-page'); ?>
<?php $__env->startSection('page-class', 'user-privacy-policy-page'); ?>
<?php $__env->startSection('title', 'Privacy Policy' . ' - ' . config('app.name', 'StAutoparts')); ?>
<?php $__env->startSection('content'); ?>
<div class="shop-hero py-4">
  <div class="container-fluid px-4">
    <h1 class="mb-1">Privacy Policy</h1>
    <nav><ol class="breadcrumb mb-0"><li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Home</a></li><li class="breadcrumb-item active">Privacy Policy</li></ol></nav>
  </div>
</div>
<div class="py-5"><div class="container-fluid px-4">
  <div class="bg-white rounded shadow-sm p-5 text-center">
    <i class="fas fa-tools text-danger mb-3" style="font-size:3rem"></i>
    <h3>Page Coming Soon</h3>
    <p class="text-muted">This page is coming soon. Please check back later.</p>
    <a href="<?php echo e(route('home')); ?>" class="steve-btn mt-3"><i class="fas fa-home me-2"></i>Back <?php echo e('to'); ?> Home</a>
  </div>
</div></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/stautoparts/resources/views/pages/privacy.blade.php ENDPATH**/ ?>