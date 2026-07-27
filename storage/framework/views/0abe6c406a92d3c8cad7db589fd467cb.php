<?php $__env->startSection('page-title', 'Page Builder'); ?>
<?php $__env->startSection('content'); ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0"><i class="fas fa-puzzle-piece me-2"></i>Page Builder</h4>
    <div class="d-flex gap-2">
        <a href="<?php echo e(route('page-builder.create', 'page')); ?>" class="btn btn-sm btn-outline-primary steve-btn">
            <i class="fas fa-plus me-1"></i>New Page
        </a>
        <a href="<?php echo e(route('page-builder.create', 'blog')); ?>" class="btn btn-sm btn-outline-success steve-btn">
            <i class="fas fa-plus me-1"></i>New Blog
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">#</th>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Blocks</th>
                        <th>Last Updated</th>
                        <th class="pe-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="ps-3"><?php echo e($item->id); ?></td>
                        <td>
                            <span class="fw-semibold"><?php echo e($item->title); ?></span>
                            <?php if($item->slug): ?>
                                <br><small class="text-muted">/<?php echo e($item->slug); ?></small>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="badge <?php echo e($item->type === 'page' ? 'bg-primary-subtle text-primary' : 'bg-success-subtle text-success'); ?> border">
                                <?php echo e(ucfirst($item->type)); ?>

                            </span>
                        </td>
                        <td>
                            <?php if($item->block_count > 0): ?>
                                <span class="badge bg-warning-subtle text-warning border"><?php echo e($item->block_count); ?> blocks</span>
                            <?php else: ?>
                                <span class="text-muted small">No blocks</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($item->updated_at ? $item->updated_at->diffForHumans() : '—'); ?></td>
                        <td class="pe-3 table-action-col">
                            <div class="action-buttons">
                                <a href="<?php echo e($item->edit_url); ?>" class="action-btn btn-view" title="Edit & Build">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </a>
                                <?php if($item->view_url): ?>
                                <a href="<?php echo e($item->view_url); ?>" target="_blank" class="action-btn btn-view-live" title="View Live Page">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            <i class="fas fa-puzzle-piece fa-2x mb-2 d-block"></i>
                            No pages or blogs found. Create content first, then use the Page Builder to add blocks.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/laravel-page-builder/src/../resources/views/admin/page-builder/index.blade.php ENDPATH**/ ?>