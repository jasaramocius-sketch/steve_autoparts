
<?php
    $pageModel = $page ?? null;
    $pageId = optional($pageModel)->id;
    $pageIdPrefix = $pageId !== null ? 'page-' . $pageId : '';
    $pageClassPrefix = optional($pageModel)->title ? ' page-' . Str::slug($pageModel->title) : '';
    $viewPageId = trim($__env->yieldContent('page-id', 'default-page-id'));
    $viewPageClass = trim($__env->yieldContent('page-class', 'default-body-class'));
?>
<body id="<?php echo e(trim($pageIdPrefix . ' ' . $viewPageId)); ?>" class="<?php echo e(trim($pageClassPrefix . ' ' . $viewPageClass)); ?>">
<?php /**PATH /var/www/html/stautoparts/resources/views/partials/page-attributes.blade.php ENDPATH**/ ?>