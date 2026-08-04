<?php $__env->startSection('page-id', 'admin-revisions-detail-page'); ?>
<?php $__env->startSection('page-class', 'admin-revisions-detail-page'); ?>
<?php $__env->startSection('page-title', 'Revision #' . $rev->id); ?>
<?php $__env->startSection('content'); ?>

<style>
    .rev-header { background: #f8f9fa; border-bottom: 1px solid #dee2e6; }
    .diff-table { font-family: 'Consolas', 'Monaco', 'Courier New', monospace; font-size: 13px; width: 100%; border-collapse: collapse; }
    .diff-table th { text-align: left; padding: 10px 12px; border-bottom: 2px solid #dee2e6; font-weight: 600; }
    .diff-table td { padding: 8px 12px; border-bottom: 1px solid #f0f0f0; vertical-align: top; }
    .diff-table tr:last-child td { border-bottom: none; }
    .field-name { font-weight: 600; color: #24292e; white-space: nowrap; width: 150px; }
    .val-old { background: #ffeef0; color: #cb2431; }
    .val-new { background: #e6ffed; color: #22863a; }
    .val-cell { font-family: 'Consolas', 'Monaco', 'Courier New', monospace; font-size: 13px; white-space: pre-wrap; word-break: break-all; max-width: 400px; max-height: 200px; overflow-y: auto; }
    .val-same { color: #6a737d; }
    .meta-icon { width: 20px; text-align: center; display: inline-block; }
    .empty-diff { color: #999; padding: 20px; text-align: center; }
</style>
<div class="revision-page">
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0">
        Revision Detail
    </h4>
    <!-- <a href="<?php echo e(route('admin.revisions.index')); ?>" class="btn btn-sm btn-outline-secondary"><i class="fas fa-list"></i> Back to List</a> -->
</div>

<div class="card border-0 shadow-sm mb-3">
    <div class="card-body py-3">
        <div class="row g-3">
            <div class="col-md-3">
                <strong>Model:</strong>
                <span class="ms-1"><?php echo e(class_basename($rev->model_type)); ?></span>
            </div>
            <div class="col-md-2">
                <strong>Record #:</strong>
                <span class="ms-1"><?php echo e($rev->model_id); ?></span>
            </div>
            <div class="col-md-2">
                <strong>Action:</strong>
                <?php if($rev->action === 'created'): ?>
                    <span class="badge bg-success ms-1">Created</span>
                <?php elseif($rev->action === 'updated'): ?>
                    <span class="badge bg-primary ms-1">Updated</span>
                <?php elseif($rev->action === 'deleted'): ?>
                    <span class="badge bg-danger ms-1">Deleted</span>
                <?php else: ?>
                    <span class="badge bg-secondary ms-1"><?php echo e($rev->action); ?></span>
                <?php endif; ?>
            </div>
            <div class="col-md-3">
                <strong>User:</strong>
                <?php if($rev->user): ?>
                    <span class="ms-1"><?php echo e($rev->user->name); ?></span>
                    <span class="text-muted small">(<?php echo e($rev->user->email); ?>)</span>
                <?php else: ?>
                    <span class="text-muted ms-1">—</span>
                <?php endif; ?>
            </div>
            <div class="col-md-2">
                <strong>Date:</strong>
                <span class="ms-1"><?php echo e($rev->created_at->format('d M Y H:i:s')); ?></span>
            </div>
            <?php if($rev->url): ?>
            <div class="col-md-12 mt-2">
                <strong>URL:</strong>
                <span class="ms-1 small text-break text-muted"><?php echo e($rev->url); ?></span>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header rev-header py-2">
        <i class="fas fa-exchange-alt me-1"></i> Field Changes
    </div>
    <div class="card-body p-0">
        <?php if($rev->action === 'created' && $rev->new_values): ?>
            <div class="table-responsive">
            <table class="diff-table">
                <thead><tr><th style="width:150px">Field</th><th>Value (New)</th></tr></thead>
                <tbody>
                    <?php $__currentLoopData = $rev->new_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $valStr = is_scalar($val) ? (string)$val : (is_null($val) ? 'null' : json_encode($val, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)); ?>
                        <tr>
                            <td class="field-name"><?php echo e($field); ?></td>
                            <td class="val-cell val-new"><?php echo e($valStr); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            </div>
        <?php elseif($rev->action === 'deleted' && $rev->old_values): ?>
            <div class="table-responsive">
            <table class="diff-table">
                <thead><tr><th style="width:150px">Field</th><th>Value (Old)</th></tr></thead>
                <tbody>
                    <?php $__currentLoopData = $rev->old_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $valStr = is_scalar($val) ? (string)$val : (is_null($val) ? 'null' : json_encode($val, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)); ?>
                        <tr>
                            <td class="field-name"><?php echo e($field); ?></td>
                            <td class="val-cell val-old"><?php echo e($valStr); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            </div>
        <?php elseif($rev->action === 'updated' && $rev->old_values && $rev->new_values): ?>
            <div class="table-responsive">
            <table class="diff-table">
                <thead><tr><th style="width:150px">Field</th><th>Old Value</th><th>New Value</th></tr></thead>
                <tbody>
                    <?php $hasChanges = false; ?>
                    <?php $__currentLoopData = $rev->new_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $newVal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(array_key_exists($field, $rev->old_values ?? [])): ?>
                            <?php
                                $oldVal = $rev->old_values[$field] ?? '';
                                $oldStr = is_scalar($oldVal) ? (string)$oldVal : (is_null($oldVal) ? 'null' : json_encode($oldVal, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
                                $newStr = is_scalar($newVal) ? (string)$newVal : (is_null($newVal) ? 'null' : json_encode($newVal, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
                                $changed = $oldStr !== $newStr;
                                if ($changed) $hasChanges = true;
                            ?>
                            <?php if($changed): ?>
                                <tr>
                                    <td class="field-name"><?php echo e($field); ?></td>
                                    <td class="val-cell val-old"><?php echo e($oldStr); ?></td>
                                    <td class="val-cell val-new"><?php echo e($newStr); ?></td>
                                </tr>
                            <?php else: ?>
                                <tr>
                                    <td class="field-name"><?php echo e($field); ?></td>
                                    <td class="val-cell val-same" colspan="2"><?php echo e($oldStr); ?></td>
                                </tr>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php if(!$hasChanges): ?>
                        <tr><td colspan="3" class="empty-diff">No field-level changes recorded.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
            </div>
        <?php else: ?>
            <div class="empty-diff">No change data available for this revision.</div>
        <?php endif; ?>
    </div>
</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/stautoparts/resources/views/admin/revisions/detail.blade.php ENDPATH**/ ?>