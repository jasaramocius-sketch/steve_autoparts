<?php
    use SteveStore\PageBuilder\Helpers\StyleHelper;

    $d = $block['data'];
    $title = $d['title'] ?? '';
    $subtitle = $d['subtitle'] ?? '';
    $btnText = $d['btn_text'] ?? '';
    $btnUrl = $d['btn_url'] ?? '#';
?>

<section class="pb-cta-section py-5" style="<?php echo e(StyleHelper::spacing($d, 'section')); ?>">
    <div class="container">
        <div class="row align-items-center justify-content-center text-center">
            <div class="col-lg-8">
                <?php if($title): ?>
                    <h2 class="fw-bold mb-2" style="<?php echo e(StyleHelper::build($d, 'title')); ?>"><?php echo e($title); ?></h2>
                <?php endif; ?>
                <?php if($subtitle): ?>
                    <p class="mb-4" style="opacity:0.85;<?php echo e(StyleHelper::build($d, 'subtitle')); ?>"><?php echo e($subtitle); ?></p>
                <?php endif; ?>
                <?php if($btnText): ?>
                    <a href="<?php echo e($btnUrl); ?>" class="btn btn-lg" style="background:#e62e04;color:#fff;border:none;<?php echo e(StyleHelper::build($d, 'btn')); ?>"><?php echo e($btnText); ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php /**PATH /var/www/html/laravel-page-builder/resources/views/frontend/blocks/cta.blade.php ENDPATH**/ ?>