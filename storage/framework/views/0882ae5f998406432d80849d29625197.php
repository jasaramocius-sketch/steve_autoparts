<?php $__env->startSection('page-title', 'Revisions'); ?>
<?php $__env->startSection('content'); ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <!-- <h4 class="fw-bold mb-0">Revisions History</h4> -->
</div>

<div class="card border-0 shadow-sm revisions-page-table">
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
                Showing <?php echo e($revisions->firstItem()); ?>-<?php echo e($revisions->lastItem()); ?> of <?php echo e($revisions->total()); ?>

            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3"><a href="<?php echo e(sortUrl('id', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark"># <?php echo sortIndicator('id', $sortBy, $sortDir); ?></a></th>
                        <th>User</th>
                        <th><a href="<?php echo e(sortUrl('model_type', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark">Model <?php echo sortIndicator('model_type', $sortBy, $sortDir); ?></a></th>
                        <th>Record ID</th>
                        <th><a href="<?php echo e(sortUrl('action', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark">Action <?php echo sortIndicator('action', $sortBy, $sortDir); ?></a></th>
                        <th>URL</th>
                        <th>Actions</th>
                        <th class="pe-3"><a href="<?php echo e(sortUrl('created_at', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark">Date <?php echo sortIndicator('created_at', $sortBy, $sortDir); ?></a></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $revisions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rev): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="ps-3"><?php echo e($rev->id); ?></td>
                        <td>
                            <?php if($rev->user): ?>
                                <?php echo e($rev->user->name); ?>

                                <div class="text-muted small"><?php echo e($rev->user->email); ?></div>
                            <?php else: ?>
                                <span class="text-muted">—</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php
                                $short = class_basename($rev->model_type);
                            ?>
                            <?php echo e($short); ?>

                        </td>
                        <td>#<?php echo e($rev->model_id); ?></td>
                        <td>
                            <?php if($rev->action === 'created'): ?>
                                <span class="badge bg-light text-success border border-success-subtle">Created</span>
                            <?php elseif($rev->action === 'updated'): ?>
                                <span class="badge bg-light text-primary border border-primary-subtle">Updated</span>
                            <?php elseif($rev->action === 'deleted'): ?>
                                <span class="badge bg-light text-danger border border-danger-subtle">Deleted</span>
                            <?php else: ?>
                                <span class="badge bg-secondary"><?php echo e($rev->action); ?></span>
                            <?php endif; ?>
                        </td>
                        <td style="max-width: 250px;">
                            <?php if($rev->url): ?>
                                <span class="small text-muted" title="<?php echo e($rev->url); ?>"><?php echo e(\Illuminate\Support\Str::limit($rev->url, 40)); ?></span>
                            <?php else: ?>
                                <span class="text-muted small">—</span>
                            <?php endif; ?>
                        </td>
                        <td class="table-action-col">
                            <div class="action-buttons revision-action-buttons">
                            <a href="<?php echo e(route('admin.revisions.detail', $rev->id)); ?>" class="btn btn-sm btn-outline-info" title="View Details">
                                <i class="fas fa-code-branch"></i> Diff
                            </a>
                            </div>
                        </td>
                        <td class="pe-3 text-nowrap small text-muted">
                            <?php echo e($rev->created_at->format('d M Y H:i')); ?>

                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">No revisions found.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if($revisions->hasPages()): ?>
            <div class="d-flex justify-content-center py-3"><?php echo e($revisions->links()); ?></div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/stautoparts/resources/views/admin/revisions/index.blade.php ENDPATH**/ ?>