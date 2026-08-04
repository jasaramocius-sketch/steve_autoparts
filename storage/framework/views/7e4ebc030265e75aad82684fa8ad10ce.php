<div class="pb-field-group">
    <div class="mb-3">
        <label class="form-label pb-field-label">Section Title</label>
        <input type="text" class="form-control" name="blocks[<?php echo e($blockIndex); ?>][data][title]" value="<?php echo e($blockData['title'] ?? ''); ?>" placeholder="Why Choose Us">
    </div>
    <div class="mb-3">
        <label class="form-label pb-field-label">Section Subtitle</label>
        <input type="text" class="form-control" name="blocks[<?php echo e($blockIndex); ?>][data][subtitle]" value="<?php echo e($blockData['subtitle'] ?? ''); ?>" placeholder="We offer the best...">
    </div>
    <div class="mb-3">
        <label class="form-label pb-field-label">Columns</label>
        <select class="form-control" name="blocks[<?php echo e($blockIndex); ?>][data][columns]">
            <option value="2" <?php echo e(($blockData['columns'] ?? '3') === '2' ? 'selected' : ''); ?>>2 Columns</option>
            <option value="3" <?php echo e(($blockData['columns'] ?? '3') === '3' ? 'selected' : ''); ?>>3 Columns</option>
            <option value="4" <?php echo e(($blockData['columns'] ?? '3') === '4' ? 'selected' : ''); ?>>4 Columns</option>
        </select>
    </div>

    <div class="pb-repeater" data-field="features">
        <label class="form-label pb-field-label">Features</label>
        <?php $features = $blockData['features'] ?? []; if (is_string($features)) $features = json_decode($features, true) ?? []; ?>
        <?php $__empty_1 = true; $__currentLoopData = $features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fIndex => $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="pb-repeater-item" data-index="<?php echo e($fIndex); ?>">
                <div class="pb-repeater-header">
                    <span>Feature <?php echo e($fIndex + 1); ?></span>
                    <button type="button" class="btn btn-sm btn-outline-danger pb-repeater-remove"><i class="fas fa-times"></i></button>
                </div>
                <div class="pb-repeater-body">
                    <div class="mb-2">
                        <input type="text" class="form-control form-control-sm" name="blocks[<?php echo e($blockIndex); ?>][data][features][<?php echo e($fIndex); ?>][icon]" value="<?php echo e($feature['icon'] ?? ''); ?>" placeholder="Icon class (e.g., fas fa-truck)">
                    </div>
                    <div class="mb-2">
                        <input type="text" class="form-control form-control-sm" name="blocks[<?php echo e($blockIndex); ?>][data][features][<?php echo e($fIndex); ?>][title]" value="<?php echo e($feature['title'] ?? ''); ?>" placeholder="Title">
                    </div>
                    <div class="mb-2">
                        <textarea class="form-control form-control-sm" name="blocks[<?php echo e($blockIndex); ?>][data][features][<?php echo e($fIndex); ?>][description]" rows="2" placeholder="Description"><?php echo e($feature['description'] ?? ''); ?></textarea>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <?php endif; ?>
        <button type="button" class="btn btn-sm btn-outline-primary pb-repeater-add" data-template="feature">
            <i class="fas fa-plus me-1"></i>Add Feature
        </button>
    </div>

    <?php echo $__env->make('page-builder::editor.partials.style-fields', ['prefix' => 'section', 'label' => 'Section Style', 'data' => $blockData, 'show' => ['colors', 'spacing']], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('page-builder::editor.partials.style-fields', ['prefix' => 'sec_title', 'label' => 'Title Style', 'data' => $blockData, 'show' => ['typography', 'colors']], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('page-builder::editor.partials.style-fields', ['prefix' => 'sec_subtitle', 'label' => 'Subtitle Style', 'data' => $blockData, 'show' => ['typography', 'colors']], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('page-builder::editor.partials.style-fields', ['prefix' => 'icon', 'label' => 'Icon Style', 'data' => $blockData, 'show' => ['typography', 'colors']], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('page-builder::editor.partials.style-fields', ['prefix' => 'feat_title', 'label' => 'Feature Title Style', 'data' => $blockData, 'show' => ['typography', 'colors']], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('page-builder::editor.partials.style-fields', ['prefix' => 'feat_desc', 'label' => 'Feature Desc Style', 'data' => $blockData, 'show' => ['typography', 'colors']], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div>

<script type="text/html" id="pb-repeater-template-feature">
    <div class="pb-repeater-item" data-index="__INDEX__">
        <div class="pb-repeater-header">
            <span>Feature __NUM__</span>
            <button type="button" class="btn btn-sm btn-outline-danger pb-repeater-remove"><i class="fas fa-times"></i></button>
        </div>
        <div class="pb-repeater-body">
            <div class="mb-2">
                <input type="text" class="form-control form-control-sm" name="blocks[<?php echo e($blockIndex); ?>][data][features][__INDEX__][icon]" value="" placeholder="Icon class (e.g., fas fa-truck)">
            </div>
            <div class="mb-2">
                <input type="text" class="form-control form-control-sm" name="blocks[<?php echo e($blockIndex); ?>][data][features][__INDEX__][title]" value="" placeholder="Title">
            </div>
            <div class="mb-2">
                <textarea class="form-control form-control-sm" name="blocks[<?php echo e($blockIndex); ?>][data][features][__INDEX__][description]" rows="2" placeholder="Description"></textarea>
            </div>
        </div>
    </div>
</script>
<?php /**PATH /var/www/html/laravel-page-builder/resources/views/editor/blocks/features.blade.php ENDPATH**/ ?>