<?php $__env->startSection('page-title', 'File Revisions'); ?>
<?php $__env->startSection('content'); ?>

<style>
    .file-path-cell { max-width: 400px; word-break: break-all; }
</style>

<div class="d-flex justify-content-between align-items-center mb-3">
    <!-- <h4 class="fw-bold mb-0">File Revisions</h4> -->
    <div>
        <span class="text-muted small me-2">Next scan: via cron</span>
        <a href="<?php echo e(route('admin.file-revisions.index')); ?>" class="btn btn-sm btn-outline-secondary"><i class="fas fa-sync"></i> Refresh</a>
    </div>
</div>

<div class="card border-0 shadow-sm file-revisions-table">
    <div class="card-body p-0">
        <div class="d-flex justify-content-between align-items-center px-3 pt-3 pb-2">
            <div class="d-flex align-items-center gap-2">
                <span class="text-muted small">Show</span>
                <select class="form-select form-select-sm" style="width: auto;" onchange="window.location.href=this.value">
                    <?php $__currentLoopData = [10, 20, 50, 100]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e(request()->fullUrlWithQuery(['per_page' => $n])); ?>" <?php echo e((int)request('per_page', 20) === $n ? 'selected' : ''); ?>><?php echo e($n); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <span class="text-muted small">per page</span>
            </div>
            <div class="text-muted small">
                Showing <?php echo e($fileRevisions->firstItem()); ?>-<?php echo e($fileRevisions->lastItem()); ?> of <?php echo e($fileRevisions->total()); ?>

            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3"><a href="<?php echo e(sortUrl('id', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark"># <?php echo sortIndicator('id', $sortBy, $sortDir); ?></a></th>
                        <th><a href="<?php echo e(sortUrl('file_path', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark">File <?php echo sortIndicator('file_path', $sortBy, $sortDir); ?></a></th>
                        <th><a href="<?php echo e(sortUrl('event', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark">Event <?php echo sortIndicator('event', $sortBy, $sortDir); ?></a></th>
                        <th>User</th>
                        <th>Actions</th>
                        <th class="pe-3"><a href="<?php echo e(sortUrl('created_at', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark">Date <?php echo sortIndicator('created_at', $sortBy, $sortDir); ?></a></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $fileRevisions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rev): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="ps-3"><?php echo e($rev->id); ?></td>
                        <td class="file-path-cell">
                            <code><?php echo e($rev->file_path); ?></code>
                        </td>
                        <td>
                            <?php if($rev->event === 'created'): ?>
                                <span class="badge bg-light text-success border border-success-subtle">Created</span>
                            <?php elseif($rev->event === 'updated'): ?>
                                <span class="badge bg-light text-primary border border-primary-subtle">Updated</span>
                            <?php elseif($rev->event === 'deleted'): ?>
                                <span class="badge bg-light text-danger border border-danger-subtle">Deleted</span>
                            <?php else: ?>
                                <span class="badge bg-secondary"><?php echo e($rev->event); ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($rev->user): ?>
                                <?php echo e($rev->user->name); ?>

                            <?php else: ?>
                                <span class="text-muted small">System</span>
                            <?php endif; ?>
                        </td>
                        <td class="table-action-col">
                            <div class="d-flex gap-1 action-buttons revision-action-buttons">
                                <a href="<?php echo e(route('admin.file-revisions.diff', $rev->id)); ?>" class="btn btn-sm btn-outline-info steve-btn" title="View Diff">
                                    <i class="fas fa-code-branch"></i>
                                </a>
                                <?php if($rev->backup_path): ?>
                                    <a href="<?php echo e(route('admin.file-revisions.download', $rev->id)); ?>" class="btn btn-sm btn-outline-secondary steve-btn" title="Download backup">
                                        <i class="fas fa-download"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td class="pe-3 text-nowrap small text-muted">
                            <?php echo e($rev->created_at->format('d M Y H:i')); ?>

                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">No file revisions recorded yet. Run <code>php artisan file:audit --watch</code> or set up a cron job.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if($fileRevisions->hasPages()): ?>
            <div class="d-flex justify-content-center py-3"><?php echo e($fileRevisions->links()); ?></div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/stautoparts/resources/views/admin/file-revisions/index.blade.php ENDPATH**/ ?>