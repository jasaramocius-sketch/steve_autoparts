<link rel="stylesheet" href="<?php echo e(asset('vendor/page-builder/css/page-builder.css')); ?>">

<?php echo $__env->make('admin.partials.image-manager-picker', ['pickerId' => 'pb_single', 'multiple' => false], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('admin.partials.image-manager-picker', ['pickerId' => 'pb_multi', 'multiple' => true], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div id="page-builder-app" data-model-type="<?php echo e($modelType); ?>" data-model-id="<?php echo e($model->id); ?>" data-save-url="<?php echo e(route('page-builder.save')); ?>" data-upload-url="<?php echo e(route('page-builder.upload')); ?>" data-form-url="<?php echo e(route('page-builder.block-form')); ?>" data-storage-url="<?php echo e(asset('storage/')); ?>">
    <div class="pb-toolbar">
        <div class="pb-toolbar-left">
            <h5 class="mb-0 fw-bold"><i class="fas fa-puzzle-piece me-2"></i>Page Builder</h5>
        </div>
        <div class="pb-toolbar-right d-flex gap-2">
            <button type="button" class="btn btn-sm btn-outline-secondary" id="pb-preview-btn">
                <i class="fas fa-eye me-1"></i>Preview
            </button>
            <button type="button" class="btn btn-sm btn-primary steve-btn" id="pb-save-btn">
                <i class="fas fa-save me-1"></i>Save Blocks
            </button>
        </div>
    </div>

    <div class="pb-blocks-container" id="pb-blocks-list">
        <?php $__empty_1 = true; $__currentLoopData = $blocks ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $block): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $blockInstance = \SteveStore\PageBuilder\PageBuilder::get($block['type'] ?? 'text');
            ?>
            <div class="pb-block-item" data-index="<?php echo e($index); ?>" data-type="<?php echo e($block['type']); ?>">
                <div class="pb-block-header">
                    <span class="pb-drag-handle"><i class="fas fa-grip-vertical"></i></span>
                    <span class="pb-block-label">
                        <i class="<?php echo e($blockInstance->icon ?? 'fas fa-cube'); ?> me-1"></i>
                        <?php echo e($blockInstance->label ?? $block['type']); ?>

                    </span>
                    <div class="pb-block-actions">
                        <button type="button" class="pb-action-btn pb-toggle-btn" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Toggle"><i class="fas fa-chevron-down"></i></button>
                        <button type="button" class="pb-action-btn pb-duplicate-btn" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Duplicate"><i class="fas fa-clone"></i></button>
                        <button type="button" class="pb-action-btn pb-delete-btn" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Delete"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
                <div class="pb-block-body">
                    <?php echo $__env->make($blockInstance->adminView(), [
                        'blockData' => $block['data'] ?? [],
                        'blockIndex' => $index,
                    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <?php endif; ?>
    </div>

    <div class="pb-add-block-area">
        <div class="pb-add-block-dropdown">
            <button type="button" class="btn btn-outline-primary steve-btn" id="pb-add-block-btn">
                <i class="fas fa-plus me-1"></i>Add Block
            </button>
            <div class="pb-block-picker" id="pb-block-picker" style="display:none;">
                <?php $__currentLoopData = $availableBlocks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group => $groupBlocks): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="pb-picker-group">
                        <div class="pb-picker-group-title"><?php echo e(ucfirst($group)); ?></div>
                        <?php $__currentLoopData = $groupBlocks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blockType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <button type="button" class="pb-picker-item" data-type="<?php echo e($blockType->name); ?>">
                                <i class="<?php echo e($blockType->icon); ?>"></i>
                                <span><?php echo e($blockType->label); ?></span>
                            </button>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>

    <div class="pb-empty-state" <?php if(!empty($blocks)): ?> style="display:none;" <?php endif; ?>>
        <i class="fas fa-puzzle-piece"></i>
        <p>No blocks added yet. Click "Add Block" to get started.</p>
    </div>
</div>
<?php /**PATH /var/www/html/laravel-page-builder/resources/views/editor/index.blade.php ENDPATH**/ ?>