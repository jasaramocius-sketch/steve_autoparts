<?php $__env->startSection('page-id', 'categories-page'); ?>
<?php $__env->startSection('page-class', 'categories-page'); ?>
<?php $__env->startSection('title', 'All Categories' . ' - ' . config('app.name', 'StAutoparts')); ?>

<?php $__env->startSection('content'); ?>
<style>
  .category-toolbar .view-btn {
    width: 42px;
    height: 42px;
    border: 1px solid var(--primary);
    background: #fff;
    color: var(--primary);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    padding: 9px 18px;
  }
  .category-toolbar .view-btn.active {
    background: var(--primary);
    color: #fff;
  }
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
<section class="product-category py-120 shop-page-product-items" style="background-color: #F9F8F8;">
<div class="container">

    <!-- Toolbar -->
    <div class="category-toolbar mb-4 gap-3 d-grid">
        <div class="d-flex justify-content-between flex-md-row gap-2 flex-sm-row category-toolbar-top">
            <div class="w-auto">
                <?php echo $__env->make('admin.partials.search-form', [
                    'route' => route('categories.index'),
                    'placeholder' => 'Search category...'
                ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
            <div class="w-auto">
                <div class="toolbar-right category-toolbar-right d-flex align-items-center justify-content-md-end gap- flex-wrap">
                    <div class="d-flex align-items-center gap-2">
                        <h5 class="mb-0 small fw-medium">Sort by</h5>
                        <form method="GET">
                            <input type="hidden" name="search" value="<?php echo e(request('search')); ?>">
                            <select class="form-select" name="sort" onchange="this.form.submit()">
                                <option value="latest" <?php echo e(request('sort') == 'latest' ? 'selected' : ''); ?>>Latest</option>
                                <option value="oldest" <?php echo e(request('sort') == 'oldest' ? 'selected' : ''); ?>>Oldest</option>
                                <option value="name" <?php echo e(request('sort') == 'name' ? 'selected' : ''); ?>>Name A-Z</option>
                            </select>
                        </form>
                    </div>
                    <div class="d-flex align-items-center gap-2" style="padding-left:10px;">
                        <?php echo $__env->make('partials.grid-list-toggle', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Grid -->
    <div id="categoryContainer" class="category-container">

    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

    <div class="category-grid-item">
        <div class="category-card">

            <div class="category-image">
                <a href="<?php echo e(route('category', $category->slug)); ?>">
                    <?php $categoryImage = $category->getDisplayImagePath(); ?>
                    <?php echo imgTag($categoryImage, $category->name); ?>

                </a>
            </div>

            <div class="category-content">
                <a href="<?php echo e(route('category', $category->slug)); ?>" class="text-dark">
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

            <?php if(isset($category->preview_products) && $category->preview_products->count() > 0): ?>
            <div class="category-products">
                <!-- <h6 class="category-products-title">Products</h6> -->
                <div class="category-products-list">
                    <?php $__currentLoopData = $category->preview_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $previewProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('product', $previewProduct->slug)); ?>" class="category-product-item">
                        <span class="category-product-img">
                            <?php echo imgTag('assets/images/thumbnails/' . $previewProduct->image, $previewProduct->name); ?>

                        </span>
                        <span class="category-product-info">
                            <span class="category-product-name"><?php echo e($previewProduct->name); ?></span>
                            <span class="category-product-price">
                                <?php echo e(currency_format($previewProduct->price)); ?>

                                <?php if(!empty($previewProduct->old_price) && $previewProduct->old_price > $previewProduct->price): ?>
                                <del class="category-product-old-price"><?php echo e(currency_format($previewProduct->old_price)); ?></del>
                                <?php endif; ?>
                            </span>
                        </span>
                    </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</div>

</div>
</section>
<script>
(function() {
    function applyCategoriesLayout(layout) {
        var container = document.getElementById('categoryContainer');
        if (!container) return;

        if (layout === 'list') {
            document.querySelectorAll('[data-layout="list"]').forEach(function(b) { b.classList.add('active'); });
            document.querySelectorAll('[data-layout="grid"]').forEach(function(b) { b.classList.remove('active'); });
            container.classList.add('categories-list-view');
        } else {
            document.querySelectorAll('[data-layout="grid"]').forEach(function(b) { b.classList.add('active'); });
            document.querySelectorAll('[data-layout="list"]').forEach(function(b) { b.classList.remove('active'); });
            container.classList.remove('categories-list-view');
        }
    }

    var saved = localStorage.getItem('categories_layout');
    applyCategoriesLayout(saved || 'grid');

    function forceGridOnMobile() {
      if (window.innerWidth <= 767) {
        applyCategoriesLayout('grid');
      }
    }
    forceGridOnMobile();
    window.addEventListener('resize', forceGridOnMobile);

    document.querySelectorAll('[data-layout="grid"]').forEach(function(btn) {
        btn.addEventListener('click', function() {
            bootstrap.Tooltip.getInstance(this)?.hide();
            this.blur();
            applyCategoriesLayout('grid');
            localStorage.setItem('categories_layout', 'grid');
        });
    });
    document.querySelectorAll('[data-layout="list"]').forEach(function(btn) {
        btn.addEventListener('click', function() {
            bootstrap.Tooltip.getInstance(this)?.hide();
            this.blur();
            applyCategoriesLayout('list');
            localStorage.setItem('categories_layout', 'list');
        });
    });

    // Disable grid/list tooltips on devices without hover support
    document.addEventListener('DOMContentLoaded', function() {
        if (window.matchMedia && window.matchMedia('(hover: none)').matches) {
            document.querySelectorAll('[data-layout="grid"], [data-layout="list"]').forEach(function(el) {
                var tip = bootstrap.Tooltip.getInstance(el);
                if (tip) tip.disable();
            });
        }
    });
})();
</script>

<style>
#categoryContainer.categories-list-view .category-card {
    display: flex;
    flex-direction: row;
    align-items: center;
    gap: 20px;
}
#categoryContainer.categories-list-view .category-card .category-image {
    flex: 0 0 24%;
}
#categoryContainer.categories-list-view .category-card .category-content {
    flex: 1;
}
#categoryContainer {
  box-sizing: border-box;
  width: 100%;
  max-width: 100%;
  margin-right: auto;
  margin-left: auto;
  overflow-x: hidden;  /* Safety fallback to stop horizontal scroll */
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 24px;
}
@media (max-width: 1199px) {
  #categoryContainer {
    grid-template-columns: repeat(3, 1fr);
  }
}
@media (max-width: 767px) {
  #categoryContainer {
    grid-template-columns: repeat(2, 1fr);
  }
}
@media (max-width: 576px) {
  #categoryContainer {
    grid-template-columns: 1fr;
  }
}
#categoryContainer.categories-list-view {
  grid-template-columns: 1fr;
}
.category-products .category-product-item:hover .category-product-name{
    color: var(--primary);
}
/* #categoryContainer.row .col-lg-3{
    padding: 0;
} */
@media (max-width: 767px) {
    .category-toolbar .view-btn {
        display: none !important;
    }}
@media (max-width: 576px) {
    #categoryContainer.categories-list-view .category-card {
        display: block !important;
    }
    #categoryContainer.categories-list-view .category-card .category-image {
        flex: none !important;
    }
    #categoryContainer.categories-list-view .category-card .category-content {
        flex: none !important;
    }
}
</style>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/stautoparts/resources/views/categories.blade.php ENDPATH**/ ?>