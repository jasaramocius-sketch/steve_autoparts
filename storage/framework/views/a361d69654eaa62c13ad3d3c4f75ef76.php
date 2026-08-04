<?php $__env->startSection('page-id', 'user-followed-sellers-page'); ?>
<?php $__env->startSection('page-class', 'user-followed-sellers-page'); ?>
<?php $__env->startSection('dashboard-content'); ?>

<section>
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>            
            <h4 class="h4-style mb-0">Followed Sellers</h4>
            <p class="text-muted mb-0">Manage the sellers you follow and view their profile summaries.</p>
        </div>
        <!-- <a href="<?php echo e(route('user.wishlist')); ?>" class="btn btn-outline-secondary">Back to Wishlist</a> -->
    </div>

    <div class="row g-4">
        <?php $__empty_1 = true; $__currentLoopData = $followedSellers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seller): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-start gap-3 mb-3">
                            <div class="avatar avatar-lg rounded-circle bg-light d-flex align-items-center justify-content-center" style="width:72px; height:72px;">
                                <span class="fs-4 text-primary"><?php echo e(strtoupper(substr($seller->seller_name, 0, 1))); ?></span>
                            </div>
                            <div>
                                <h5 class="mb-1"><?php echo e($seller->seller_name); ?></h5>
                                <p class="text-muted mb-0"><?php echo e($seller->location); ?></p>
                            </div>
                        </div>

                        <p class="text-secondary" style="line-height:1.6;"><?php echo e($seller->description); ?></p>

                        <div class="d-flex flex-wrap gap-3 mt-4">
                            <div class="badge bg-light text-dark p-2 rounded">
                                <strong><?php echo e($seller->products); ?></strong> Products
                            </div>
                            <div class="badge bg-light text-dark p-2 rounded">
                                <strong><?php echo e(number_format($seller->rating, 1)); ?></strong> Rating
                            </div>
                            <div class="badge bg-light text-dark p-2 rounded">
                                <strong><?php echo e(number_format($seller->followers)); ?></strong> Followers
                            </div>
                        </div>

                        <div class="mt-4 d-flex gap-2">
                            <a href="javascript:;" class="btn btn-primary">View Seller</a>
                            <a href="javascript:;" class="btn btn-outline-danger">Unfollow</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12">
                <div class="alert alert-info">
                    You are not following any sellers yet.
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('user.layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/stautoparts/resources/views/user/followed-sellers.blade.php ENDPATH**/ ?>