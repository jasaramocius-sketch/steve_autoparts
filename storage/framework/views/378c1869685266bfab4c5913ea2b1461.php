<?php if(!empty($blocks)): ?>
    <?php $__currentLoopData = $blocks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $block): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $blockType = $block['type'] ?? null;
            $viewPath = 'page-builder::frontend.blocks.' . $blockType;
        ?>
        <?php if(view()->exists($viewPath)): ?>
            <?php echo $__env->make($viewPath, ['block' => $block], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<?php /**PATH /var/www/html/laravel-page-builder/resources/views/components/blocks.blade.php ENDPATH**/ ?>