<?php $__env->startSection('page-id', 'admin-add-category-page'); ?>
<?php $__env->startSection('page-class', 'admin-add-category-page'); ?>
<?php $__env->startSection('page-title', 'Create Cetegory'); ?>
<?php $__env->startSection('content'); ?>

<div class="container-fluid category-create-page">

<div class="card shadow">


    <div class="card-body">

        <form action="<?php echo e(route('admin.categories.store')); ?>" method="POST" enctype="multipart/form-data">

            <?php echo csrf_field(); ?>

            <div class="mb-3">
                <label>Name</label>

                <input type="text"
                       name="name"
                       class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       value="<?php echo e(old('name')); ?>"
                       required>
                <?php $__errorArgs = ['name'];
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

            <div class="form-rows">
                <div class="mb-3 form-rows-col">
                    <label>Image</label>
                    <input type="hidden" name="image_from_manager" id="image_from_manager_category_image">
                    <div id="impPreview_category_image" class="d-none mt-2"></div>
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="impOpen_category_image()">
                        <i class="fas fa-images me-1"></i> Browse Image Manager
                    </button>
                </div>

            <div class="mb-3 form-rows-col">
                <label>Or Image Download URL</label>
                <input type="url"
                       name="image_url"
                       class="form-control <?php $__errorArgs = ['image_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       value="<?php echo e(old('image_url')); ?>"
                       placeholder="https://example.com/image.png">
                <?php $__errorArgs = ['image_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <small class="form-text text-muted">Provide a direct URL to an image. The server will download and store it locally.</small>
            </div>
                </div>
            <div class="form-rows">
            <div class="mb-3 form-rows-col">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="1" <?php echo e(old('status', '1') == '1' ? 'selected' : ''); ?>>Active</option>
                    <option value="0" <?php echo e(old('status', '1') == '0' ? 'selected' : ''); ?>>Inactive</option>
                </select>
            </div>

            <div class="mb-3 form-rows-col">

                <label>Parent Category</label>

                <select class="form-control" name="parent_id">

                    <option value="">
                        Main Category
                    </option>

                    <?php $__currentLoopData = $parents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <option value="<?php echo e($parent->id); ?>">
                            <?php echo e($parent->name); ?>

                        </option>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </select>

            </div>
            </div>

            <button class="btn btn-success steve-btn">
                Save
            </button>

            <a href="<?php echo e(route('admin.categories.index')); ?>"
               class="btn btn-secondary steve-btn">
                Back
            </a>

        </form>

    </div>

</div>

</div>

<?php echo $__env->make('admin.partials.image-manager-picker', ['pickerId' => 'category_image', 'targetInput' => 'image_from_manager'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/stautoparts/resources/views/admin/categories/create.blade.php ENDPATH**/ ?>