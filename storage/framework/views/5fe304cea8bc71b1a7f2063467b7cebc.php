<?php $__env->startSection('title', 'All Categories' . ' - ' . config('app.name', 'StAutoparts')); ?>

<?php $__env->startSection('content'); ?>
<style>
  
</style>

<!-- Banner Hero Section -->
<section class="gs-breadcrumb-section"
    style="background-image: url('<?php echo e(asset('/assets/images/1724480495Imagexxxxxpng.png')); ?>');
    background-size: cover; background-position: center;">

  <div class="container">
    <div class="content-wrapper">
      <h2 class="breadcrumb-title">All Categories</h2>
      <ul class="bread-menu">
        <li><a href="<?php echo e(route('home')); ?>">Home</a></li>
        <li style="color: var(--primary)">Categories</li>
      </ul>
    </div>
  </div>
</section>

<div class="container mt-5">

    <!-- Toolbar -->
    <div class="category-toolbar mb-4">
        <div class="row align-items-center">

            <div class="col-md-4">
                <form action="<?php echo e(route('categories.index')); ?>" method="GET">
                    <input type="text"
                           class="form-control"
                           name="search"
                           placeholder="Search category..."
                           value="<?php echo e(request('search')); ?>">
                </form>
            </div>

            <div class="col-md-8">
                <div class="toolbar-right category-toolbar-right">
                    <div class="categories-sortby-filter">
                    <span class="sort-label">Sort by:</span>
                    <form method="GET">
                        <input type="hidden" name="search" value="<?php echo e(request('search')); ?>">

                        <select class="form-select sort-select"
                                name="sort"
                                onchange="this.form.submit()">
                            <option value="latest" <?php echo e(request('sort') == 'latest' ? 'selected' : ''); ?>>Latest</option>
                            <option value="oldest" <?php echo e(request('sort') == 'oldest' ? 'selected' : ''); ?>>Oldest</option>
                            <option value="name" <?php echo e(request('sort') == 'name' ? 'selected' : ''); ?>>Name A-Z</option>
                        </select>
                    </form>
                    </div>
                    <div class="d-flex align-items-center gap-3 flex-wrap filter-sort-brand-wrapper">
                    <button type="button" id="gridBtn" class="view-btn active steve-btn">
                        <i class="fas fa-th-large"></i>
                    </button>

                    <button type="button" id="listBtn" class="view-btn steve-btn">
                        <i class="fas fa-bars"></i>
                    </button>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- Categories Grid -->
    <div class="row" id="categoryContainer">

    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="category-card">

            <div class="category-image">
                <a href="<?php echo e(route('category', $category->slug)); ?>">
                    <?php $categoryImage = $category->getDisplayImagePath(); ?>
                    <?php echo imgTag($categoryImage, $category->name); ?>

                </a>
            </div>

            <div class="category-content">
                <a href="<?php echo e(route('category', $category->slug)); ?>">
                    <h5><?php echo e($category->name); ?></h5>
                </a>

                <div class="category-stats">
                    <span class="badge bg-primary">
                        <?php echo e($category->total_products_count); ?> Products
                    </span>

                    <?php if($category->children->count() > 0): ?>
                    <span class="badge bg-secondary subcategory-count-badge">
                        <?php echo e($category->children->count()); ?> Sub Categories
                    </span>
                    <?php endif; ?>
                </div>

                <?php if($category->children->count() > 0): ?>
                <div class="subcategory-list mt-2">
                        <ul class="list-unstyled mb-0" style="font-size:13px;">
                            <?php $__currentLoopData = $category->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="mb-1">
                                    <a href="<?php echo e(route('subcategory', ['parent' => $category->slug, 'child' => $child->slug])); ?>" class="text-decoration-none" style="color:#1f0300;">
                                        <?php echo e($child->name); ?>

                                    </a>
                                    <span class="text-muted">(<?php echo e($child->total_products_count); ?>)</span>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                </div>
                <?php endif; ?>
            </div>

        </div>
    </div>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/stautoparts/resources/views/categories.blade.php ENDPATH**/ ?>