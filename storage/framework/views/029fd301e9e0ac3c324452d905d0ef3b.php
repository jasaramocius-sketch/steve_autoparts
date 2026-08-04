<?php $__env->startSection('page-title', 'Page Builder — ' . $model->title); ?>

<?php $__env->startSection('content'); ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h4 class="fw-bold mb-0">
            <i class="fas fa-puzzle-piece me-2"></i><?php echo e($model->title); ?>

            <span class="badge <?php echo e($modelType === 'page' ? 'bg-primary-subtle text-primary' : 'bg-success-subtle text-success'); ?> border ms-2"><?php echo e(ucfirst($modelType)); ?></span>
        </h4>
    </div>
    <div class="d-flex gap-2">
        <?php
            $viewUrl = $model->slug ? ($modelType === 'blog' ? route('blog.show', $model->slug) : route('page.show', $model->slug)) : null;
        ?>
        <?php if($viewUrl): ?>
        <a href="<?php echo e($viewUrl); ?>" target="_blank" class="btn btn-sm btn-outline-success steve-btn">
            <i class="fas fa-external-link-alt me-1"></i>View Live
        </a>
        <?php endif; ?>
        <a href="<?php echo e(route('page-builder.index')); ?>" class="btn btn-sm btn-outline-secondary steve-btn">
            <i class="fas fa-arrow-left me-1"></i>Back to List
        </a>
    </div>
</div>

<style>
    #page-builder-app { background: #fff; border: 1px solid #e2e5e9; border-radius: 12px; overflow: hidden; }
</style>

<?php if (isset($component)) { $__componentOriginale1a534cded3807d97665894f65b422e0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale1a534cded3807d97665894f65b422e0 = $attributes; } ?>
<?php $component = SteveStore\PageBuilder\View\Components\Editor::resolve(['model' => $model] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-builder'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\SteveStore\PageBuilder\View\Components\Editor::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale1a534cded3807d97665894f65b422e0)): ?>
<?php $attributes = $__attributesOriginale1a534cded3807d97665894f65b422e0; ?>
<?php unset($__attributesOriginale1a534cded3807d97665894f65b422e0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale1a534cded3807d97665894f65b422e0)): ?>
<?php $component = $__componentOriginale1a534cded3807d97665894f65b422e0; ?>
<?php unset($__componentOriginale1a534cded3807d97665894f65b422e0); ?>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('page-builder-js'); ?>
<script src="<?php echo e(asset('vendor/page-builder/js/page-builder.js')); ?>?v=101"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/laravel-page-builder/resources/views/admin/page-builder/editor.blade.php ENDPATH**/ ?>