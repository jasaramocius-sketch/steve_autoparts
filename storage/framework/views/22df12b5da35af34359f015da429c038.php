<?php $__env->startSection('dashboard-content'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">My Wishlist</h3>
    <?php if(count($wishlist) > 0): ?>
    <form action="<?php echo e(route('wishlist.clear')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('DELETE'); ?>
        <button class="btn btn-danger btn-sm steve-btn">
            <i class="fas fa-trash"></i> Clear All
        </button>
    </form>
    <?php endif; ?>
</div>

<div class="row wishlist-page-products">    
    <?php $__empty_1 = true; $__currentLoopData = $wishlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="wishlist-page-products-items">
        <?php
            $product = $item->product ?? $item;
            $wishlistId = isset($item->id) ? $item->id : null;
        ?>

        <?php echo $__env->make('partials.product-card', [
            'product' => $product,
            'wishlistItemId' => $wishlistId,
            'showRemoveWishlistIcon' => true,
            'colClass' => 'col-lg-4 col-md-6 mb-4',
        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    </div>
        <div class="col-12">
            <div class="alert alert-info">
                No products in wishlist.
            </div>
        </div>
    <?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('user.layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/stautoparts/resources/views/user/wishlist.blade.php ENDPATH**/ ?>