<div class="pb-field-group">
    <div class="mb-3">
        <label class="form-label pb-field-label">Title</label>
        <input type="text" class="form-control" name="blocks[<?php echo e($blockIndex); ?>][data][title]" value="<?php echo e($blockData['title'] ?? ''); ?>" placeholder="Enter hero title">
    </div>
    <div class="mb-3">
        <label class="form-label pb-field-label">Subtitle</label>
        <textarea class="form-control" name="blocks[<?php echo e($blockIndex); ?>][data][subtitle]" rows="2" placeholder="Enter subtitle"><?php echo e($blockData['subtitle'] ?? ''); ?></textarea>
    </div>
    <div class="mb-3">
        <label class="form-label pb-field-label">Background Image</label>
        <div class="pb-image-upload" data-field="background_image">
            <input type="hidden" name="blocks[<?php echo e($blockIndex); ?>][data][background_image]" value="<?php echo e($blockData['background_image'] ?? ''); ?>" class="pb-image-input">
            <div class="pb-image-preview">
                <?php if(!empty($blockData['background_image'])): ?>
                    <img src="<?php echo e(asset('storage/' . $blockData['background_image'])); ?>" alt="Hero">
                <?php endif; ?>
            </div>
            <button type="button" class="btn btn-sm btn-outline-primary pb-upload-btn"><i class="fas fa-images me-1"></i>Choose Image</button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label pb-field-label">Button Text</label>
            <input type="text" class="form-control" name="blocks[<?php echo e($blockIndex); ?>][data][btn_text]" value="<?php echo e($blockData['btn_text'] ?? ''); ?>" placeholder="Shop Now">
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label pb-field-label">Button URL</label>
            <input type="text" class="form-control" name="blocks[<?php echo e($blockIndex); ?>][data][btn_url]" value="<?php echo e($blockData['btn_url'] ?? ''); ?>" placeholder="/shop">
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label pb-field-label">Overlay Opacity</label>
            <input type="number" class="form-control" name="blocks[<?php echo e($blockIndex); ?>][data][overlay_opacity]" value="<?php echo e($blockData['overlay_opacity'] ?? 50); ?>" min="0" max="100">
        </div>
    </div>

    <?php echo $__env->make('page-builder::editor.partials.style-fields', ['prefix' => 'section', 'label' => 'Section Style', 'data' => $blockData, 'show' => ['colors', 'spacing']], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('page-builder::editor.partials.style-fields', ['prefix' => 'title', 'label' => 'Title Style', 'data' => $blockData], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('page-builder::editor.partials.style-fields', ['prefix' => 'subtitle', 'label' => 'Subtitle Style', 'data' => $blockData], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('page-builder::editor.partials.style-fields', ['prefix' => 'btn', 'label' => 'Button Style', 'data' => $blockData, 'show' => ['typography', 'colors', 'spacing', 'border']], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div>
<?php /**PATH /var/www/html/laravel-page-builder/resources/views/editor/blocks/hero.blade.php ENDPATH**/ ?>