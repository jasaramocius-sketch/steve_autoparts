<?php $__env->startSection('page-title', 'Create New ' . ucfirst($type ?: 'Content')); ?>
<?php $__env->startSection('content'); ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0">
        <i class="fas fa-plus-circle me-2"></i>Create New <?php echo e($type ? ucfirst($type) : 'Content'); ?>

    </h4>
    <a href="<?php echo e(route('page-builder.index')); ?>" class="btn btn-sm btn-outline-secondary steve-btn">
        <i class="fas fa-arrow-left me-1"></i>Back to List
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="<?php echo e(route('page-builder.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            
            <?php if(!$type): ?>
            <div class="mb-3">
                <label class="form-label fw-semibold">Content Type</label>
                <div class="d-flex gap-3">
                    <?php $__currentLoopData = $models; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="form-check form-check-inline border rounded-pill px-3 py-2">
                        <input class="form-check-input" type="radio" name="type" id="type_<?php echo e($key); ?>" value="<?php echo e($key); ?>" <?php echo e($loop->first ? 'checked' : ''); ?>>
                        <label class="form-check-label fw-semibold" for="type_<?php echo e($key); ?>">
                            <i class="fas fa-<?php echo e($key === 'page' ? 'file' : 'blog'); ?> me-1"></i><?php echo e(ucfirst($key)); ?>

                        </label>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php else: ?>
                <input type="hidden" name="type" value="<?php echo e($type); ?>">
            <?php endif; ?>

            
            <div class="mb-3">
                <label for="title" class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                <input type="text" class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="title" name="title" value="<?php echo e(old('title')); ?>" required autofocus>
                <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div class="mb-3">
                <label for="slug" class="form-label fw-semibold">Slug</label>
                <input type="text" class="form-control <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="slug" name="slug" value="<?php echo e(old('slug')); ?>" placeholder="auto-generated from title if empty">
                <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <?php if($type === 'blog' || !$type): ?>
            <div class="blog-fields" style="<?php echo e(!$type ? 'display:none;' : ''); ?>">
                <div class="mb-3">
                    <label for="blog_category_id" class="form-label fw-semibold">Category</label>
                    <select class="form-select" id="blog_category_id" name="blog_category_id">
                        <option value="">— Select Category —</option>
                        <?php $__currentLoopData = $blogCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($cat->id); ?>"><?php echo e($cat->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label fw-semibold">Image URL</label>
                    <input type="text" class="form-control" id="image" name="image" value="<?php echo e(old('image')); ?>" placeholder="Path to blog image">
                </div>
                <div class="mb-3">
                    <label for="details" class="form-label fw-semibold">Details / Excerpt</label>
                    <textarea class="form-control" id="details" name="details" rows="3"><?php echo e(old('details')); ?></textarea>
                </div>
            </div>
            <?php endif; ?>

            
            <?php if($type === 'page'): ?>
            <div class="mb-3">
                <label for="content" class="form-label fw-semibold">Content</label>
                <textarea class="form-control" id="content" name="content" rows="4"><?php echo e(old('content')); ?></textarea>
            </div>
            <?php endif; ?>

            <div class="d-flex gap-2 pt-2">
                <button type="submit" class="btn btn-primary steve-btn">
                    <i class="fas fa-save me-1"></i>Create & Edit Blocks
                </button>
                <a href="<?php echo e(route('page-builder.index')); ?>" class="btn btn-outline-secondary steve-btn">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var titleInput = document.getElementById('title');
    var slugInput = document.getElementById('slug');

    titleInput.addEventListener('input', function() {
        if (!slugInput.value || slugInput.dataset.auto === '1') {
            slugInput.value = this.value.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim();
            slugInput.dataset.auto = '1';
        }
    });

    slugInput.addEventListener('input', function() {
        this.dataset.auto = '0';
    });

    // Toggle blog fields based on type selector
    var typeInputs = document.querySelectorAll('input[name="type"]');
    var blogFields = document.querySelector('.blog-fields');
    if (blogFields) {
        typeInputs.forEach(function(input) {
            input.addEventListener('change', function() {
                blogFields.style.display = this.value === 'blog' ? '' : 'none';
            });
        });
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/laravel-page-builder/resources/views/admin/page-builder/create.blade.php ENDPATH**/ ?>