<?php $__env->startSection('page-id', 'user-faq-page'); ?>
<?php $__env->startSection('page-class', 'user-faq-page'); ?>
<?php $__env->startSection('title', 'FAQ' . ' - ' . config('app.name', 'StAutoparts')); ?>
<?php $__env->startSection('content'); ?>
<div class="Faq-hero">    
<!-- Banner Hero Section -->
<section class="gs-breadcrumb-section" style="background-image: url('<?php echo e(asset('assets/images/1724480495Imagexxxxxpng.png')); ?>'); background-size: cover; background-position: center;">
  <div class="container">
    <div class="content-wrapper">
      <h2 class="breadcrumb-title">FAQs</h2>
      <ul class="bread-menu">
        <li><a href="<?php echo e(route('home')); ?>">Home</a></li>
        <li style="color: var(--primary)">FAQs</li>
      </ul>
    </div>
  </div>
</section>  
</div>
<div class="Faqs-page-container">
  <div class="container-fluid px-4">
    <div class="row justify-content-center Faqs-page-row">
      <div class="col-lg-8 Faqs-page-col" id="faqsAccordion">
        <?php $__empty_1 = true; $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="card border-0 shadow-sm mb-3 Faqs-page-items">
          <div class="card-header bg-white collapsed" style="cursor:pointer" data-bs-toggle="collapse" data-bs-target="#faq<?php echo e($faq->id); ?>" aria-expanded="false">
            <h6 class="mb-0 d-flex justify-content-between align-items-center">
              <?php echo e($faq->question); ?>

              <i class="fas fa-chevron-down"></i>
            </h6>
          </div>
          <div id="faq<?php echo e($faq->id); ?>" class="card-body collapse" data-bs-parent="#faqsAccordion">
            <p class="mb-0"><?php echo e($faq->answer); ?></p>
          </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="bg-white rounded shadow-sm p-5 text-center">
          <i class="fas fa-info-circle text-muted mb-3" style="font-size:3rem"></i>
          <h3>No FAQs Available</h3>
          <p class="text-muted">Check back later for frequently asked questions.</p>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<style>
[data-bs-toggle="collapse"] .fa-chevron-down { transition: transform 0.35s ease; }
[data-bs-toggle="collapse"].collapsed .fa-chevron-down { transform: rotate(0deg); }
[data-bs-toggle="collapse"]:not(.collapsed) .fa-chevron-down { transform: rotate(180deg); }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/stautoparts/resources/views/pages/faq.blade.php ENDPATH**/ ?>