<?php
    $size = $size ?? null;
    $showClear = $showClear ?? (bool)request('search');
    $clearRoute = $clearRoute ?? $route;
?>
<form action="<?php echo e($route); ?>" method="GET" class="d-flex gap-2 align-items-center">
    <div class="input-group <!--<?php echo e($size ? ' input-group-' . $size : ''); ?>-->">
        <button type="submit" class="input-group-text bg-white">
            <i class="fas fa-search"></i>
        </button>
        <input type="text"
               name="search"
               class="form-control"
               placeholder="<?php echo e($placeholder); ?>"
               value="<?php echo e(request('search')); ?>">
    </div>
    <?php if($showClear): ?>
        <a href="<?php echo e($clearRoute); ?>" class="btn btn-lg btn-outline-danger d-flex align-items-center">
            <i class="fas fa-times"></i>
        </a>
    <?php endif; ?>
</form>
<?php /**PATH /var/www/html/stautoparts/resources/views/admin/partials/search-form.blade.php ENDPATH**/ ?>