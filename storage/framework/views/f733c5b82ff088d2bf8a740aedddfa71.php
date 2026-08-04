<?php $__env->startSection('page-id', 'user-show-page'); ?>
<?php $__env->startSection('page-class', 'user-show-page'); ?>
<?php $__env->startSection('title', $page->title); ?>
<?php $__env->startSection('content'); ?>

<div class="container py-5"> 
    <div class="row justify-content-center">
        <div class="col-lg-12 mb-4">
            <h1 class=""><?php echo e($page->title); ?></h1>
            <?php if($page->short_description): ?>
                <p class="lead page-short-description"><?php echo e($page->short_description); ?></p>
            <?php endif; ?>
        </div>
        <div class="col-lg-12">
            <div class="page-content">
                <?php echo $page->content; ?>

            </div>
        </div>
    </div>
</div>

<?php if (isset($component)) { $__componentOriginalf8446d12475031d632e761b16f53f033 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8446d12475031d632e761b16f53f033 = $attributes; } ?>
<?php $component = SteveStore\PageBuilder\View\Components\Blocks::resolve(['model' => $page] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-blocks'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\SteveStore\PageBuilder\View\Components\Blocks::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf8446d12475031d632e761b16f53f033)): ?>
<?php $attributes = $__attributesOriginalf8446d12475031d632e761b16f53f033; ?>
<?php unset($__attributesOriginalf8446d12475031d632e761b16f53f033); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf8446d12475031d632e761b16f53f033)): ?>
<?php $component = $__componentOriginalf8446d12475031d632e761b16f53f033; ?>
<?php unset($__componentOriginalf8446d12475031d632e761b16f53f033); ?>
<?php endif; ?>

<style>
    .page-content p { margin-bottom: 1rem; line-height: 1.8; }
    .page-content img { max-width: 100%; height: auto; border-radius: 8px; margin: 1rem 0; }
</style>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/stautoparts/resources/views/pages/show.blade.php ENDPATH**/ ?>