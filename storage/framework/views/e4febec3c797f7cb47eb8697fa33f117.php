<div class="pb-field-group">
    <div class="mb-3">
        <label class="form-label pb-field-label">Title</label>
        <input type="text" class="form-control" name="blocks[<?php echo e($blockIndex); ?>][data][title]" value="<?php echo e($blockData['title'] ?? ''); ?>" placeholder="Ready to get started?">
    </div>
    <div class="mb-3">
        <label class="form-label pb-field-label">Subtitle</label>
        <input type="text" class="form-control" name="blocks[<?php echo e($blockIndex); ?>][data][subtitle]" value="<?php echo e($blockData['subtitle'] ?? ''); ?>" placeholder="Shop our best deals today">
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label pb-field-label">Button Text</label>
            <input type="text" class="form-control" name="blocks[<?php echo e($blockIndex); ?>][data][btn_text]" value="<?php echo e($blockData['btn_text'] ?? ''); ?>" placeholder="Shop Now" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label pb-field-label">Button URL</label>
            <input type="text" class="form-control" name="blocks[<?php echo e($blockIndex); ?>][data][btn_url]" value="<?php echo e($blockData['btn_url'] ?? ''); ?>" placeholder="/shop" required>
        </div>
    </div>

    <?php echo $__env->make('page-builder::editor.partials.style-fields', ['prefix' => 'section', 'label' => 'Section Style', 'data' => $blockData, 'show' => ['colors', 'spacing']], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('page-builder::editor.partials.style-fields', ['prefix' => 'title', 'label' => 'Title Style', 'data' => $blockData, 'show' => ['typography', 'colors']], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('page-builder::editor.partials.style-fields', ['prefix' => 'subtitle', 'label' => 'Subtitle Style', 'data' => $blockData, 'show' => ['typography', 'colors']], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('page-builder::editor.partials.style-fields', ['prefix' => 'btn', 'label' => 'Button Style', 'data' => $blockData, 'show' => ['typography', 'colors', 'spacing', 'border']], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div>
<?php /**PATH /var/www/html/laravel-page-builder/resources/views/editor/blocks/cta.blade.php ENDPATH**/ ?>