<div class="pb-field-group">
    <div class="mb-3">
        <label class="form-label pb-field-label">Content</label>
        <textarea class="form-control pb-richtext" name="blocks[<?php echo e($blockIndex); ?>][data][content]" rows="6" placeholder="Enter your text content..."><?php echo e($blockData['content'] ?? ''); ?></textarea>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label pb-field-label">Alignment</label>
            <select class="form-select" name="blocks[<?php echo e($blockIndex); ?>][data][alignment]">
                <option value="left" <?php echo e(($blockData['alignment'] ?? 'left') === 'left' ? 'selected' : ''); ?>>Left</option>
                <option value="center" <?php echo e(($blockData['alignment'] ?? '') === 'center' ? 'selected' : ''); ?>>Center</option>
                <option value="right" <?php echo e(($blockData['alignment'] ?? '') === 'right' ? 'selected' : ''); ?>>Right</option>
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label pb-field-label">Max Width</label>
            <select class="form-select" name="blocks[<?php echo e($blockIndex); ?>][data][max_width]">
                <option value="100%" <?php echo e(($blockData['max_width'] ?? '100%') === '100%' ? 'selected' : ''); ?>>Full Width</option>
                <option value="800px" <?php echo e(($blockData['max_width'] ?? '') === '800px' ? 'selected' : ''); ?>>Narrow (800px)</option>
                <option value="600px" <?php echo e(($blockData['max_width'] ?? '') === '600px' ? 'selected' : ''); ?>>Very Narrow (600px)</option>
            </select>
        </div>
    </div>

    <?php echo $__env->make('page-builder::editor.partials.style-fields', ['prefix' => 'section', 'label' => 'Section Style', 'data' => $blockData, 'show' => ['colors', 'spacing']], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('page-builder::editor.partials.style-fields', ['prefix' => 'content', 'label' => 'Content Style', 'data' => $blockData, 'show' => ['typography', 'colors', 'spacing']], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div>
<?php /**PATH /var/www/html/laravel-page-builder/resources/views/editor/blocks/text.blade.php ENDPATH**/ ?>