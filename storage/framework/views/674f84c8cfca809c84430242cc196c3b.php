<?php $__env->startSection('page-id', 'admin-images-edit-page'); ?>
<?php $__env->startSection('page-class', 'admin-images-edit-page'); ?>
<?php $__env->startSection('page-title', 'Edit Image - ' . $image->original_name); ?>
<?php $__env->startSection('content'); ?>
<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0"><i class="fas fa-image me-2"></i>Edit Image</h4>
        <a href="<?php echo e(route('admin.images.index')); ?>" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Back to Images
        </a>
    </div>

    <div class="row g-4">
        
        <div class="col-md-5">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <img src="<?php echo e($image->thumb_url); ?>" alt="<?php echo e($image->alt_text ?? $image->original_name); ?>" class="img-fluid rounded" style="max-height:400px;" onerror="this.onerror=null;this.src='<?php echo e(asset("assets/images/placeholder.png")); ?>'">
                    <hr>
                    <div class="table-responsive">
                    <table class="table table-sm table-borderless text-start small mb-0">
                        <tr><th class="text-muted">Filename</th><td><?php echo e($image->original_name); ?></td></tr>
                        <tr><th class="text-muted">URL</th><td class="text-break"><a href="<?php echo e($image->thumb_url); ?>" target="_blank"><code><?php echo e($image->thumb_url); ?></code></a></td></tr>
                        <tr><th class="text-muted">MIME Type</th><td><?php echo e($image->mime_type); ?></td></tr>
                        <tr><th class="text-muted">Size</th><td><?php echo e($image->size_in_kb); ?></td></tr>
                        <tr><th class="text-muted">Dimensions</th><td><?php echo e($image->width); ?> x <?php echo e($image->height); ?> px</td></tr>
                        <tr>
                            <th class="text-muted">Attached To</th>
                            <td>
                                <?php if($image->attachable_type && $image->attachable): ?>
                                    <?php echo e(class_basename($image->attachable_type)); ?> #<?php echo e($image->attachable_id); ?>

                                    (<?php echo e($image->attachable->name ?? $image->attachable->title ?? 'N/A'); ?>)
                                <?php else: ?>
                                    <span class="text-danger">Unused</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>
                    </div>
                </div>
            </div>

            
            <?php if(in_array($image->mime_type, ['image/jpeg', 'image/pjpeg'])): ?>
            <div class="card border-0 shadow-sm mt-3">
                <div class="card-body text-center">
                    <form action="<?php echo e(route('admin.images.convert', $image->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-success w-100 steve-btn">
                            <i class="fas fa-exchange-alt"></i> Convert to WebP
                        </button>
                    </form>
                </div>
            </div>
            <?php endif; ?>
        </div>

        
        <div class="col-md-7">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white"><h5 class="mb-0">Image Details</h5></div>
                <div class="card-body">
                    <form action="<?php echo e(route('admin.images.update', $image->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="mb-3">
                            <label class="form-label">Alt Text <small class="text-muted">(for SEO & accessibility)</small></label>
                            <input type="text" name="alt_text" class="form-control" value="<?php echo e(old('alt_text', $image->alt_text)); ?>" placeholder="Describe the image...">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" value="<?php echo e(old('title', $image->title)); ?>" placeholder="Image title">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Caption</label>
                            <textarea name="caption" class="form-control texteditor" rows="3" placeholder="Optional caption"><?php echo e(old('caption', $image->caption)); ?></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary steve-btn">
                            <i class="fas fa-save"></i> Update Details
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/stautoparts/resources/views/admin/images/edit.blade.php ENDPATH**/ ?>