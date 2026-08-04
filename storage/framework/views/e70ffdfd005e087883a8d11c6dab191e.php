<?php
    use SteveStore\PageBuilder\Helpers\StyleHelper;

    $d = $block['data'];
    $content = $d['content'] ?? '';
    $alignment = $d['alignment'] ?? 'left';
    $maxWidth = $d['max_width'] ?? '100%';
?>

<section class="pb-text-section py-5" style="<?php echo e(StyleHelper::spacing($d, 'section')); ?>">
    <div class="container">
        <div style="max-width:<?php echo e($maxWidth); ?>; margin:0 auto; text-align:<?php echo e($alignment); ?>;<?php echo e(StyleHelper::build($d, 'content')); ?>">
            <?php echo $content; ?>

        </div>
    </div>
</section>
<?php /**PATH /var/www/html/laravel-page-builder/src/../resources/views/frontend/blocks/text.blade.php ENDPATH**/ ?>