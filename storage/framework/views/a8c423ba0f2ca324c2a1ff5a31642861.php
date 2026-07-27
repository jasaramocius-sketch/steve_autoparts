<?php $__env->startSection('title', 'All Brands' . ' - ' . config('app.name', 'StAutoparts')); ?>

<?php $__env->startSection('content'); ?>

<!-- Banner Hero Section -->
<section class="gs-breadcrumb-section"
    style="background-image: url('<?php echo e(asset('/assets/images/1724480495Imagexxxxxpng.png')); ?>');
    background-size: cover; background-position: center;">

  <div class="container">
    <div class="content-wrapper">
      <h2 class="breadcrumb-title">All Brands</h2>
      <ul class="bread-menu">
        <li><a href="<?php echo e(route('home')); ?>">Home</a></li>
        <li><a href="<?php echo e(route('brands')); ?>">Brands</a></li>
      </ul>
    </div>
  </div>
</section>

<div class="container mt-5 mb-5">

    <!-- Toolbar -->
    <div class="category-toolbar mb-4">
        <div class="row align-items-center">
            <div class="col-md-4">
                <form action="<?php echo e(route('brands')); ?>" method="GET">
                    <input type="text"
                           class="form-control"
                           name="search"
                           placeholder="Search brands..."
                           value="<?php echo e($search); ?>">
                </form>
            </div>
            <div class="col-md-8">
                <div class="toolbar-right">
                    <span class="sort-label">Sort by:</span>
                    <form method="GET">
                        <input type="hidden" name="search" value="<?php echo e($search); ?>">
                        <select class="form-select sort-select"
                                name="sort"
                                onchange="this.form.submit()">
                            <option value="latest" <?php echo e($sort == 'latest' ? 'selected' : ''); ?>>Latest</option>
                            <option value="oldest" <?php echo e($sort == 'oldest' ? 'selected' : ''); ?>>Oldest</option>
                            <option value="name" <?php echo e($sort == 'name' ? 'selected' : ''); ?>>Name A-Z</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Brands Grid -->
    <div class="row">
    <?php $__empty_1 = true; $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="category-card">
            <div class="category-image">
                <a href="<?php echo e(route('shop', ['brand' => $brand->slug])); ?>">
                    <?php if($brand->image): ?>
                        <img src="<?php echo e(asset('assets/images/brands/' . $brand->image)); ?>" alt="<?php echo e($brand->name); ?>" style="width:100%;height:200px;object-fit:cover;">
                    <?php else: ?>
                        <div style="width:100%;height:200px;background:#f0f0f0;display:flex;align-items:center;justify-content:center;">
                            <i class="fas fa-tag fa-3x text-muted"></i>
                        </div>
                    <?php endif; ?>
                </a>
            </div>
            <div class="category-content">
                <a href="<?php echo e(route('shop', ['brand' => $brand->slug])); ?>">
                    <h5><?php echo e($brand->name); ?></h5>
                </a>
                <div class="category-stats">
                    <span class="badge bg-primary">
                        <?php echo e($brand->products_count); ?> Products
                    </span>
                </div>
                <?php if($brand->description): ?>
                <p class="mt-2" style="font-size:13px;color:#666;"><?php echo Str::limit(strip_tags($brand->description), 100); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="col-12 text-center py-5">
        <i class="fas fa-tag fa-3x text-muted mb-3"></i>
        <p class="text-muted">No brands found.</p>
    </div>
    <?php endif; ?>
    </div>

    <?php if($brands->hasPages()): ?>
    <div class="d-flex justify-content-center mt-5 shop-page-pagination">
        <?php echo e($brands->links('pagination::gs-pagination')); ?>

    </div>
    <?php endif; ?>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/stautoparts/resources/views/brands.blade.php ENDPATH**/ ?>