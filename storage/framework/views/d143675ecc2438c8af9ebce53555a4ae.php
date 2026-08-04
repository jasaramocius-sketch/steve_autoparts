<?php
    use SteveStore\PageBuilder\Helpers\StyleHelper;

    $d = $block['data'];
    $title = $d['title'] ?? 'What Our Customers Say';
    $testimonials = $d['testimonials'] ?? [];
    if (is_string($testimonials)) $testimonials = json_decode($testimonials, true) ?? [];
?>

<section class="pb-testimonials-section py-5" style="<?php echo e(StyleHelper::spacing($d, 'section')); ?>">
    <div class="container">
        <?php if($title): ?>
            <div class="text-center mb-5">
                <h2 class="fw-bold" style="<?php echo e(StyleHelper::build($d, 'title')); ?>"><?php echo e($title); ?></h2>
            </div>
        <?php endif; ?>
        <?php if(!empty($testimonials)): ?>
            <div class="row g-4 justify-content-center">
                <?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100" style="<?php echo e(StyleHelper::build($d, 'card')); ?>">
                            <div class="card-body p-4 text-center">
                                <?php if(!empty($testimonial['avatar'])): ?>
                                    <img src="<?php echo e(asset('storage/' . $testimonial['avatar'])); ?>" alt="<?php echo e($testimonial['name'] ?? ''); ?>" class="rounded-circle mb-3" style="width:60px;height:60px;object-fit:cover;">
                                <?php else: ?>
                                    <div class="rounded-circle mb-3 mx-auto d-flex align-items-center justify-content-center" style="width:60px;height:60px;background:var(--primary,#e62e04);color:#fff;font-size:1.2rem;font-weight:700;">
                                        <?php echo e(strtoupper(substr($testimonial['name'] ?? '?', 0, 1))); ?>

                                    </div>
                                <?php endif; ?>
                                <?php if(!empty($testimonial['rating'])): ?>
                                    <div class="mb-2">
                                        <?php for($i = 1; $i <= 5; $i++): ?>
                                            <i class="fas fa-star" style="color:<?php echo e($i <= $testimonial['rating'] ? '#ffc107' : '#ddd'); ?>;"></i>
                                        <?php endfor; ?>
                                    </div>
                                <?php endif; ?>
                                <?php if(!empty($testimonial['quote'])): ?>
                                    <p class="mb-3" style="font-style:italic;color:#555;<?php echo e(StyleHelper::build($d, 'quote')); ?>">"<?php echo e($testimonial['quote']); ?>"</p>
                                <?php endif; ?>
                                <?php if(!empty($testimonial['name'])): ?>
                                    <strong style="<?php echo e(StyleHelper::build($d, 'name')); ?>"><?php echo e($testimonial['name']); ?></strong>
                                <?php endif; ?>
                                <?php if(!empty($testimonial['role'])): ?>
                                    <small class="d-block text-muted"><?php echo e($testimonial['role']); ?></small>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php /**PATH /var/www/html/laravel-page-builder/resources/views/frontend/blocks/testimonials.blade.php ENDPATH**/ ?>