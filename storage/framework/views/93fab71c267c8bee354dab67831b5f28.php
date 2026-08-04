<div class="pb-field-group">
    <div class="mb-3">
        <label class="form-label pb-field-label">Section Title</label>
        <input type="text" class="form-control" name="blocks[<?php echo e($blockIndex); ?>][data][title]" value="<?php echo e($blockData['title'] ?? 'What Our Customers Say'); ?>" placeholder="Section title">
    </div>

    <div class="pb-repeater" data-field="testimonials">
        <label class="form-label pb-field-label">Testimonials</label>
        <?php $testimonials = $blockData['testimonials'] ?? []; if (is_string($testimonials)) $testimonials = json_decode($testimonials, true) ?? []; ?>
        <?php $__empty_1 = true; $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tIndex => $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="pb-repeater-item" data-index="<?php echo e($tIndex); ?>">
                <div class="pb-repeater-header">
                    <span>Testimonial <?php echo e($tIndex + 1); ?></span>
                    <button type="button" class="btn btn-sm btn-outline-danger pb-repeater-remove"><i class="fas fa-times"></i></button>
                </div>
                <div class="pb-repeater-body">
                    <div class="row g-2">
                        <div class="col-md-4 mb-2">
                            <input type="text" class="form-control form-control-sm" name="blocks[<?php echo e($blockIndex); ?>][data][testimonials][<?php echo e($tIndex); ?>][name]" value="<?php echo e($testimonial['name'] ?? ''); ?>" placeholder="Name">
                        </div>
                        <div class="col-md-4 mb-2">
                            <input type="text" class="form-control form-control-sm" name="blocks[<?php echo e($blockIndex); ?>][data][testimonials][<?php echo e($tIndex); ?>][role]" value="<?php echo e($testimonial['role'] ?? ''); ?>" placeholder="Role">
                        </div>
                        <div class="col-md-4 mb-2">
                            <select class="form-select form-select-sm" name="blocks[<?php echo e($blockIndex); ?>][data][testimonials][<?php echo e($tIndex); ?>][rating]">
                                <?php for($i = 5; $i >= 1; $i--): ?>
                                    <option value="<?php echo e($i); ?>" <?php echo e(($testimonial['rating'] ?? '5') == $i ? 'selected' : ''); ?>><?php echo e($i); ?> Star<?php echo e($i > 1 ? 's' : ''); ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-2">
                        <div class="pb-image-upload" data-field="avatar">
                            <input type="hidden" name="blocks[<?php echo e($blockIndex); ?>][data][testimonials][<?php echo e($tIndex); ?>][avatar]" value="<?php echo e($testimonial['avatar'] ?? ''); ?>" class="pb-image-input">
                            <div class="pb-image-preview pb-image-preview-sm">
                                <?php if(!empty($testimonial['avatar'])): ?>
                                    <img src="<?php echo e(asset('storage/' . $testimonial['avatar'])); ?>" alt="Avatar">
                                <?php endif; ?>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-secondary pb-upload-btn"><i class="fas fa-images me-1"></i> Avatar</button>
                        </div>
                    </div>
                    <div>
                        <textarea class="form-control form-control-sm" name="blocks[<?php echo e($blockIndex); ?>][data][testimonials][<?php echo e($tIndex); ?>][quote]" rows="2" placeholder="Their quote..."><?php echo e($testimonial['quote'] ?? ''); ?></textarea>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <?php endif; ?>
        <button type="button" class="btn btn-sm btn-outline-primary pb-repeater-add" data-template="testimonial">
            <i class="fas fa-plus me-1"></i>Add Testimonial
        </button>
    </div>

    <?php echo $__env->make('page-builder::editor.partials.style-fields', ['prefix' => 'section', 'label' => 'Section Style', 'data' => $blockData, 'show' => ['colors', 'spacing']], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('page-builder::editor.partials.style-fields', ['prefix' => 'title', 'label' => 'Title Style', 'data' => $blockData, 'show' => ['typography', 'colors']], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('page-builder::editor.partials.style-fields', ['prefix' => 'card', 'label' => 'Card Style', 'data' => $blockData, 'show' => ['spacing', 'border', 'colors']], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('page-builder::editor.partials.style-fields', ['prefix' => 'quote', 'label' => 'Quote Style', 'data' => $blockData, 'show' => ['typography', 'colors']], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('page-builder::editor.partials.style-fields', ['prefix' => 'name', 'label' => 'Name Style', 'data' => $blockData, 'show' => ['typography', 'colors']], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div>

<script type="text/html" id="pb-repeater-template-testimonial">
    <div class="pb-repeater-item" data-index="__INDEX__">
        <div class="pb-repeater-header">
            <span>Testimonial __NUM__</span>
            <button type="button" class="btn btn-sm btn-outline-danger pb-repeater-remove"><i class="fas fa-times"></i></button>
        </div>
        <div class="pb-repeater-body">
            <div class="row g-2">
                <div class="col-md-4 mb-2">
                    <input type="text" class="form-control form-control-sm" name="blocks[<?php echo e($blockIndex); ?>][data][testimonials][__INDEX__][name]" value="" placeholder="Name">
                </div>
                <div class="col-md-4 mb-2">
                    <input type="text" class="form-control form-control-sm" name="blocks[<?php echo e($blockIndex); ?>][data][testimonials][__INDEX__][role]" value="" placeholder="Role">
                </div>
                <div class="col-md-4 mb-2">
                    <select class="form-select form-select-sm" name="blocks[<?php echo e($blockIndex); ?>][data][testimonials][__INDEX__][rating]">
                        <option value="5">5 Stars</option>
                        <option value="4">4 Stars</option>
                        <option value="3">3 Stars</option>
                        <option value="2">2 Stars</option>
                        <option value="1">1 Star</option>
                    </select>
                </div>
            </div>
            <div class="mb-2">
                <div class="pb-image-upload" data-field="avatar">
                    <input type="hidden" name="blocks[<?php echo e($blockIndex); ?>][data][testimonials][__INDEX__][avatar]" value="" class="pb-image-input">
                    <div class="pb-image-preview pb-image-preview-sm"></div>
                    <button type="button" class="btn btn-sm btn-outline-secondary pb-upload-btn"><i class="fas fa-images me-1"></i> Avatar</button>
                </div>
            </div>
            <div>
                <textarea class="form-control form-control-sm" name="blocks[<?php echo e($blockIndex); ?>][data][testimonials][__INDEX__][quote]" rows="2" placeholder="Their quote..."></textarea>
            </div>
        </div>
    </div>
</script>
<?php /**PATH /var/www/html/laravel-page-builder/resources/views/editor/blocks/testimonials.blade.php ENDPATH**/ ?>