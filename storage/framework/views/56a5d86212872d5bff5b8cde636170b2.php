<div class="pb-field-group">
    <div class="mb-3">
        <label class="form-label pb-field-label">Images</label>
        <div class="pb-gallery-container">
            <div class="pb-gallery-list" data-field="images">
                <?php $images = $blockData['images'] ?? []; if (is_string($images)) $images = json_decode($images, true) ?? []; ?>
                <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $imgIndex => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="pb-gallery-item" data-index="<?php echo e($imgIndex); ?>">
                        <img src="<?php echo e(asset('storage/' . $image)); ?>" alt="Gallery image">
                        <input type="hidden" name="blocks[<?php echo e($blockIndex); ?>][data][images][<?php echo e($imgIndex); ?>]" value="<?php echo e($image); ?>">
                        <button type="button" class="pb-gallery-remove" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Remove"><i class="fas fa-times"></i></button>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <button type="button" class="btn btn-sm btn-outline-primary pb-gallery-add">
                <i class="fas fa-images me-1"></i>Add Images
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label pb-field-label">Columns</label>
            <select class="form-select" name="blocks[<?php echo e($blockIndex); ?>][data][columns]">
                <option value="2" <?php echo e(($blockData['columns'] ?? '3') === '2' ? 'selected' : ''); ?>>2 Columns</option>
                <option value="3" <?php echo e(($blockData['columns'] ?? '3') === '3' ? 'selected' : ''); ?>>3 Columns</option>
                <option value="4" <?php echo e(($blockData['columns'] ?? '3') === '4' ? 'selected' : ''); ?>>4 Columns</option>
            </select>
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label pb-field-label">Gap (px)</label>
            <input type="number" class="form-control" name="blocks[<?php echo e($blockIndex); ?>][data][gutter]" value="<?php echo e($blockData['gutter'] ?? 15); ?>" min="0" max="50">
        </div>
        <div class="col-md-4 mb-3 d-flex align-items-end">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="blocks[<?php echo e($blockIndex); ?>][data][show_caption]" value="1" <?php echo e(!empty($blockData['show_caption']) ? 'checked' : ''); ?>>
                <label class="form-check-label">Show Captions</label>
            </div>
        </div>
    </div>

    <?php echo $__env->make('page-builder::editor.partials.style-fields', ['prefix' => 'section', 'label' => 'Section Style', 'data' => $blockData, 'show' => ['colors', 'spacing']], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('page-builder::editor.partials.style-fields', ['prefix' => 'image', 'label' => 'Image Style', 'data' => $blockData, 'show' => ['spacing', 'border', 'width_height']], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div>
<?php /**PATH /var/www/html/laravel-page-builder/resources/views/editor/blocks/gallery.blade.php ENDPATH**/ ?>