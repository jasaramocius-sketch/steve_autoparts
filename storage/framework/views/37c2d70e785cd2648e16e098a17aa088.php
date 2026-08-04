<?php $__env->startSection('page-id', 'admin-products-import-page'); ?>
<?php $__env->startSection('page-class', 'admin-products-import-page'); ?>
<?php $__env->startSection('page-title', 'Import Products'); ?>
<?php $__env->startSection('content'); ?>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Import Products from CSV</h5>
        <a href="<?php echo e(route('admin.products.download-sample-csv')); ?>" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-download"></i> Download Sample CSV
        </a>
    </div>
    <div class="card-body">
        <form action="<?php echo e(route('admin.products.import')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>

            <div class="mb-3">
                <label class="form-label">CSV File *</label>
                <input type="file" name="csv_file" class="form-control <?php $__errorArgs = ['csv_file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" accept=".csv,.txt" required>
                <?php $__errorArgs = ['csv_file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <div class="form-text">Max 5MB. First row must contain column headers.</div>
            </div>

            <div class="alert alert-info">
                <strong>Supported Columns:</strong>
                <code>id</code> (leave empty for new product, provide ID to update existing),
                <code>name</code> (required),
                <code>price</code> (required),
                <code>old_price</code>,
                <code>category</code> (matched by name — <strong>auto-created if missing</strong>),
                <code>stock</code>,
                <code>description</code>,
                <code>badge</code>,
                <code>product_type</code> (<code>physical</code> / <code>digital</code>),
                <code>status</code> (<code>1/0</code> or <code>yes/no</code> or <code>active/inactive</code>),
                <code>featured</code> (<code>1/0</code> or <code>yes/no</code>),
                <code>brand</code> (matched by name — <strong>auto-created if missing</strong>),
                <code>year</code>,
                <code>make</code>,
                <code>model</code>,
                <code>image</code> (URL — will be downloaded and converted to WebP),
                <code>gallery_images</code> (pipe-separated URLs — e.g. <code>url1.jpg|url2.jpg|url3.jpg</code>)
            </div>

            <button type="submit" class="btn btn-primary steve-btn">
                <i class="fas fa-upload"></i> Import Products
            </button>
            <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/stautoparts/resources/views/admin/products/import.blade.php ENDPATH**/ ?>