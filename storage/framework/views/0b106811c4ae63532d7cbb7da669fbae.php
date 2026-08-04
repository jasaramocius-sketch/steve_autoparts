<?php $__env->startSection('page-id', 'compare-page'); ?>
<?php $__env->startSection('page-class', 'compare-page'); ?>
<?php $__env->startSection('title', 'Compare Products' . ' - ' . config('app.name', 'StAutoparts')); ?>

<?php $__env->startSection('content'); ?>


    <!-- Banner Hero Section -->
<section class="gs-breadcrumb-section" style="background-image: url('<?php echo e(asset('assets/images/1724480495Imagexxxxxpng.png')); ?>'); background-size: cover; background-position: center;">
  <div class="container">
    <div class="content-wrapper">
      <h2 class="breadcrumb-title">Compare Products</h2>
      <ul class="bread-menu">
        <li><a href="<?php echo e(route('home')); ?>">Home</a></li>
        <li style="color: var(--primary)">Compare Products</li>
      </ul>
    </div>
  </div>
</section>
<div class="container pt-5 pb-5 compare-page-products">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div></div>

        <?php if(!$compareItems->isEmpty()): ?>
        <button type="button" class="btn btn-danger steve-btn" id="compare-clear-all"
                data-url="<?php echo e(route('compare.clear')); ?>">
            <i class="fas fa-trash"></i> Clear All
        </button>
        <?php endif; ?>
    </div>
    <?php if($compareItems->isEmpty()): ?>
        <div class="alert alert-info text-center" id="compare-empty-msg">
            No items to compare.
        </div>
    <?php else: ?>
    <div class="alert alert-info text-center" id="compare-empty-msg" style="display:none;">
        No items to compare.
    </div>
    <div class="table-responsive rounded bg-white compare-table-wrapper" id="compare-table-wrapper">
        <table class="table compare-table align-middle text-center mb-0">
            <tr>
                <th width="180">Product Name</th>
                <?php $__currentLoopData = $compareItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <td class="compare-col" data-compare-id="<?php echo e($item->id); ?>">
                    <div>
                        <a href="<?php echo e(route('product',$item->product->slug)); ?>">
                    <?php echo imgTag('assets/images/thumbnails/'.basename($item->product->image), '', 'img-fluid mb-3', 'style="height:170px; object-fit:contain;"'); ?>

                        </a>    
                    </div>

                    

                    <a href="<?php echo e(route('product',$item->product->slug)); ?>"
                       class="text-decoration-none">
                        <?php echo e($item->product->name); ?>

                    </a>
                </td>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tr>
            <tr>
                <th>Price</th>
                <?php $__currentLoopData = $compareItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <td class="fw-bold text-danger compare-col" data-compare-id="<?php echo e($item->id); ?>">
                        <?php echo e(currency_format($item->product->price)); ?>

                    </td>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tr>
            <tr>
                <th>Old Price</th>
                <?php $__currentLoopData = $compareItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <td class="compare-col" data-compare-id="<?php echo e($item->id); ?>">
                        <?php if($item->product->old_price): ?>
                            <del><?php echo e(currency_format($item->product->old_price)); ?></del>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tr>
            <tr>
                <th>Rating</th>
                <?php $__currentLoopData = $compareItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $displayRating = $item->product->rating ?? 0;
                        $displayReviews = $item->product->reviews ?? 0;
                        if ($displayRating == 0 && $displayReviews > 0 && !empty($item->product->reviews_data)) {
                            $visible = collect($item->product->reviews_data)->where('deleted', false);
                            if ($visible->isNotEmpty()) {
                                $displayRating = round($visible->avg('rating'));
                            }
                        }
                    ?>
                    <td class="compare-col" data-compare-id="<?php echo e($item->id); ?>">
                        <?php for($i = 0; $i < 5; $i++): ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="16" viewBox="0 0 17 16" fill="none">
                            <path d="M8.5 0.5L10.4084 6.37336L16.584 6.37336L11.5878 10.0033L13.4962 15.8766L8.5 12.2467L3.50383 15.8766L5.41219 10.0033L0.416019 6.37336L6.59163 6.37336L8.5 0.5Z" fill="<?php echo e($i < $displayRating ? '#EEAE0B' : '#E2E8F0'); ?>" />
                        </svg>
                        <?php endfor; ?>
                        <?php echo e($displayRating > 0 ? number_format($displayRating, 1) : ''); ?>

                        (<?php echo e($displayReviews); ?>)
                    </td>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tr>
            <tr>
                <th>Description</th>
                <?php $__currentLoopData = $compareItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <td style="min-width:300px" class="compare-col" data-compare-id="<?php echo e($item->id); ?>">
                        <?php echo e(Str::limit($item->product->description,150)); ?>

                    </td>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tr>
            <tr>
                <th>Action</th>
                <?php $__currentLoopData = $compareItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <td class="compare-col" data-compare-id="<?php echo e($item->id); ?>">
                        <form action="<?php echo e(route('cart.add')); ?>" method="POST" class="add-cart-form">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="product_id"
                                   value="<?php echo e($item->product->id); ?>">
                            <input type="hidden" name="product_name"
                                   value="<?php echo e($item->product->name); ?>">
                            <input type="hidden" name="product_price"
                                   value="<?php echo e($item->product->price); ?>">
                            <input type="hidden" name="product_image"
                                   value="<?php echo e($item->product->image ? asset('assets/images/thumbnails/' . $item->product->image) : asset('assets/images/placeholder.png')); ?>">
                            <button type="submit" class="btn btn-danger mb-2 steve-btn">
                                Add to Cart
                            </button>
                        </form>
                        <button type="button"
                                class="btn btn-outline-secondary compare-remove-btn steve-btn"
                                data-url="<?php echo e(route('compare.remove', $item->id)); ?>"
                                data-id="<?php echo e($item->id); ?>">
                            Remove
                        </button>
                    </td>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tr>
        </table>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
$(function() {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    // Update header compare badge
    function updateCompareBadge(count) {
        $('.compare-count').html(count);
        $('#compare-count').html(count);
        if (count > 0) {
            $('.compare-badge').css('display', 'inline-block');
        } else {
            $('.compare-badge').css('display', 'none');
        }
    }

    // Check if table is empty and show empty message
    function checkEmpty() {
        var remaining = $('.compare-col[data-compare-id]').length;
        if (remaining === 0) {
            $('#compare-table-wrapper').fadeOut(300, function() {
                $(this).remove();
            });
            $('#compare-clear-all').fadeOut(200);
            $('#compare-empty-msg').fadeIn(300);
        }
    }

    // Remove single item via AJAX
    $(document).on('click', '.compare-remove-btn', function() {
        var $btn = $(this);
        var url = $btn.data('url');
        var itemId = $btn.data('id');

        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

        $.ajax({
            url: url,
            type: 'DELETE',
            data: { _token: csrfToken },
            dataType: 'json',
            success: function(data) {
                // Remove columns for this item
                $('.compare-col[data-compare-id="' + itemId + '"]').fadeOut(300, function() {
                    $(this).remove();
                    checkEmpty();
                });
                updateCompareBadge(data.count);
                toastr.success(data.message || 'Product removed from compare list.');
            },
            error: function() {
                $btn.prop('disabled', false).html('Remove');
                toastr.error('Failed to remove product. Please try again.');
            }
        });
    });

    // Clear all via AJAX
    $(document).on('click', '#compare-clear-all', function() {
        var $btn = $(this);
        var url = $btn.data('url');

        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Clearing...');

        $.ajax({
            url: url,
            type: 'DELETE',
            data: { _token: csrfToken },
            dataType: 'json',
            success: function(data) {
                $('#compare-table-wrapper').fadeOut(300, function() {
                    $(this).remove();
                });
                $btn.fadeOut(200);
                $('#compare-empty-msg').fadeIn(300);
                updateCompareBadge(0);
                toastr.success(data.message || 'Compare list cleared successfully.');
            },
            error: function() {
                $btn.prop('disabled', false).html('<i class="fas fa-trash"></i> Clear All');
                toastr.error('Failed to clear compare list. Please try again.');
            }
        });
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/stautoparts/resources/views/compare.blade.php ENDPATH**/ ?>