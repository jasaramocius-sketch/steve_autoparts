<?php
    use SteveStore\PageBuilder\Helpers\StyleHelper;

    $d = $block['data'];
    $title = $d['title'] ?? '';
    $subtitle = $d['subtitle'] ?? '';
    $bgImage = $d['background_image'] ?? '';
    $opacity = $d['overlay_opacity'] ?? 50;
    $btnText = $d['btn_text'] ?? '';
    $btnUrl = $d['btn_url'] ?? '#';

    $bgStyle = $bgImage ? 'background-image:url(' . asset('storage/' . $bgImage) . ');background-size:cover;background-position:center;' : 'background:#333;';
    $overlayStyle = 'background:rgba(0,0,0,' . ($opacity / 100) . ');';
?>

<section class="pb-hero-section" style="<?php echo e($bgStyle); ?> position:relative; min-height:400px; display:flex; align-items:center; <?php echo e(StyleHelper::spacing($d, 'section')); ?>">
    <div style="<?php echo e($overlayStyle); ?> position:absolute; inset:0;"></div>
    <div class="container" style="position:relative; z-index:1;">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <?php if($title): ?>
                    <h1 class="fw-bold mb-3" style="<?php echo e(StyleHelper::build($d, 'title')); ?>"><?php echo e($title); ?></h1>
                <?php endif; ?>
                <?php if($subtitle): ?>
                    <p class="mb-4" style="font-size:1.1rem;opacity:0.9;<?php echo e(StyleHelper::build($d, 'subtitle')); ?>"><?php echo e($subtitle); ?></p>
                <?php endif; ?>
                <?php if($btnText): ?>
                    <a href="<?php echo e($btnUrl); ?>" class="btn btn-lg" style="background:#e62e04;color:#fff;border:none;<?php echo e(StyleHelper::build($d, 'btn')); ?>"><?php echo e($btnText); ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php /**PATH /var/www/html/laravel-page-builder/resources/views/frontend/blocks/hero.blade.php ENDPATH**/ ?>