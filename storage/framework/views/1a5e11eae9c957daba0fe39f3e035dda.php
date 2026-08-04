<?php
    use SteveStore\PageBuilder\Helpers\StyleHelper;

    $d = $block['data'];
    $images = $d['images'] ?? [];
    if (is_string($images)) $images = json_decode($images, true) ?? [];
    $columns = $d['columns'] ?? '3';
    $gutter = $d['gutter'] ?? 15;
    $showCaption = $d['show_caption'] ?? false;
    $imageStyle = StyleHelper::build($d, 'image');
?>

<section class="pb-gallery-section py-5" style="<?php echo e(StyleHelper::spacing($d, 'section')); ?>">
    <div class="container">
        <?php if(!empty($images)): ?>
            <div class="row" style="gap:<?php echo e($gutter); ?>px;">
                <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-<?php echo e(12 / (int)$columns); ?>" style="padding:<?php echo e($gutter / 2); ?>px;">
                        <div class="pb-gallery-item" style="border-radius:8px;overflow:hidden;<?php echo e($imageStyle); ?>">
                            <img src="<?php echo e(asset('storage/' . $image)); ?>" alt="Gallery" style="width:100%;height:250px;object-fit:cover;">
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php /**PATH /var/www/html/laravel-page-builder/resources/views/frontend/blocks/gallery.blade.php ENDPATH**/ ?>