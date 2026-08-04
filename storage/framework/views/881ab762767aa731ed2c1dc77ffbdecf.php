<?php
    use SteveStore\PageBuilder\Helpers\StyleHelper;

    $d = $block['data'];
    $title = $d['title'] ?? '';
    $subtitle = $d['subtitle'] ?? '';
    $features = $d['features'] ?? [];
    if (is_string($features)) $features = json_decode($features, true) ?? [];
    $columns = $d['columns'] ?? '3';
?>

<section class="pb-features-section py-5" style="<?php echo e(StyleHelper::spacing($d, 'section')); ?>">
    <div class="container">
        <?php if($title || $subtitle): ?>
            <div class="text-center mb-5">
                <?php if($title): ?>
                    <h2 class="fw-bold" style="<?php echo e(StyleHelper::build($d, 'sec_title')); ?>"><?php echo e($title); ?></h2>
                <?php endif; ?>
                <?php if($subtitle): ?>
                    <p class="text-muted" style="<?php echo e(StyleHelper::build($d, 'sec_subtitle')); ?>"><?php echo e($subtitle); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <?php if(!empty($features)): ?>
            <div class="row g-4">
                <?php $__currentLoopData = $features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-<?php echo e(12 / (int)$columns); ?>">
                        <div class="text-center p-4">
                            <?php if(!empty($feature['icon'])): ?>
                                <div class="mb-3">
                                    <i class="<?php echo e($feature['icon']); ?>" style="font-size:2rem;color:var(--primary,#e62e04);<?php echo e(StyleHelper::build($d, 'icon')); ?>"></i>
                                </div>
                            <?php endif; ?>
                            <?php if(!empty($feature['title'])): ?>
                                <h5 class="fw-bold" style="<?php echo e(StyleHelper::build($d, 'feat_title')); ?>"><?php echo e($feature['title']); ?></h5>
                            <?php endif; ?>
                            <?php if(!empty($feature['description'])): ?>
                                <p class="mb-0" style="<?php echo e(StyleHelper::build($d, 'feat_desc')); ?>"><?php echo e($feature['description']); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php /**PATH /var/www/html/laravel-page-builder/resources/views/frontend/blocks/features.blade.php ENDPATH**/ ?>