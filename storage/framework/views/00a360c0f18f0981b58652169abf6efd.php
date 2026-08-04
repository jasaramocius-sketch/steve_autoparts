<div class="item-pagination-container px-1">
<?php if($paginator->hasPages()): ?>
    <div class="small text-muted">
        <?php echo __('Showing'); ?>

        <span class="fw-semibold"><?php echo e($paginator->firstItem()); ?></span>
        <?php echo __('to'); ?>

        <span class="fw-semibold"><?php echo e($paginator->lastItem()); ?></span>
        <?php echo __('of'); ?>

        <span class="fw-semibold"><?php echo e($paginator->total()); ?></span>
        <?php echo __('results'); ?>

    </div>
    <div class="d-flex justify-content-between align-items-center">
        <ul class="gs-pagination mb-0">
            
            <?php if($paginator->onFirstPage()): ?>
                <li class="disabled" aria-disabled="true" aria-label="First page">
                    <span>&laquo;</span>
                </li>
            <?php else: ?>
                <li>
                    <a href="<?php echo e($paginator->url(1)); ?>" aria-label="First page">&laquo;</a>
                </li>
            <?php endif; ?>

            
            <?php if($paginator->onFirstPage()): ?>
                <li class="disabled" aria-disabled="true" aria-label="<?php echo app('translator')->get('pagination.previous'); ?>">
                    <span>&lsaquo;</span>
                </li>
            <?php else: ?>
                <li>
                    <a href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev" aria-label="<?php echo app('translator')->get('pagination.previous'); ?>">&lsaquo;</a>
                </li>
            <?php endif; ?>

            
            <?php
    $current = $paginator->currentPage();
    $last = $paginator->lastPage();
    $window = 5;
    $half = floor($window / 2);

    if ($last <= $window) {
        $start = 1; $end = $last;
    } elseif ($current <= $half + 1) {
        $start = 1; $end = $window;
    } elseif ($current >= $last - $half) {
        $start = $last - $window + 1; $end = $last;
    } else {
        $start = $current - $half; $end = $current + $half;
    }
?>

<?php for($page = $start; $page <= $end; $page++): ?>
    <li class="<?php echo e($page == $current ? 'active' : ''); ?>">
        <?php if($page == $current): ?>
            <span><?php echo e($page); ?></span>
        <?php else: ?>
            <a href="<?php echo e($paginator->url($page)); ?>"><?php echo e($page); ?></a>
        <?php endif; ?>
    </li>
<?php endfor; ?>

            
            <?php if($paginator->hasMorePages()): ?>
                <li>
                    <a href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next" aria-label="<?php echo app('translator')->get('pagination.next'); ?>">&rsaquo;</a>
                </li>
            <?php else: ?>
                <li class="disabled" aria-disabled="true" aria-label="<?php echo app('translator')->get('pagination.next'); ?>">
                    <span>&rsaquo;</span>
                </li>
            <?php endif; ?>

            
            <?php if($paginator->hasMorePages()): ?>
                <li>
                    <a href="<?php echo e($paginator->url($last)); ?>" aria-label="Last page">&raquo;</a>
                </li>
            <?php else: ?>
                <li class="disabled" aria-disabled="true" aria-label="Last page">
                    <span>&raquo;</span>
                </li>
            <?php endif; ?>
        </ul>
    </div>
<?php endif; ?>
</div><?php /**PATH /var/www/html/stautoparts/resources/views/vendor/pagination/gs-pagination.blade.php ENDPATH**/ ?>