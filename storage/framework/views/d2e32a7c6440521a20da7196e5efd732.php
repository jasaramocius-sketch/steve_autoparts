<?php $__env->startSection('page-id', 'admin-logs-index-page'); ?>
<?php $__env->startSection('page-class', 'admin-logs-index-page'); ?>
<?php $__env->startSection('page-title', 'Logs'); ?>

<?php $__env->startSection('content'); ?>
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0 fw-bold"><i class="fas fa-file-alt me-2"></i>Site Logs</h5>
        <form method="GET" action="<?php echo e(route('admin.logs.index')); ?>" class="d-flex align-items-center gap-2">
            <select name="file" class="form-select" onchange="this.form.submit()">
                <option value="">Select log file</option>
                <?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($file); ?>" <?php echo e($selectedFile === $file ? 'selected' : ''); ?>><?php echo e($file); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </form>
    </div>
    <div class="card-body">
        <?php if($selectedFile): ?>
            <div class="mb-3 text-muted small">Showing: <?php echo e($selectedFile); ?></div>
            <?php if(empty($contents)): ?>
                <div class="alert alert-info mb-0">No entries found in this log file.</div>
            <?php else: ?>
                <pre class="bg-dark text-light p-3 rounded mb-0" style="white-space: pre-wrap; word-break: break-word; max-height: 70vh; overflow:auto;"><?php echo e(implode("\n", $contents)); ?></pre>
            <?php endif; ?>
        <?php else: ?>
            <div class="alert alert-warning mb-0">No log files found yet.</div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/stautoparts/resources/views/admin/logs/index.blade.php ENDPATH**/ ?>