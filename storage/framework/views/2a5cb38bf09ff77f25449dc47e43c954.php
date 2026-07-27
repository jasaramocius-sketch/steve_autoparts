<?php $__env->startSection('page-title', 'Blog Categories'); ?>
<?php $__env->startSection('content'); ?>

<?php $trashedCount = \App\Models\BlogCategory::onlyTrashed()->count(); ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <!-- <h4 class="fw-bold mb-0">Blog Categories</h4> -->
     <div></div>
    <a href="<?php echo e(route('admin.blog-categories.create')); ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Add Blog Category</a>
</div>

<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a class="nav-link <?php echo e(!request()->has('trashed') ? 'active' : ''); ?>" href="<?php echo e(route('admin.blog-categories.index')); ?>">Active</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php echo e(request()->has('trashed') ? 'active' : ''); ?>" href="<?php echo e(route('admin.blog-categories.index', ['trashed' => 1])); ?>">Trash (<?php echo e($trashedCount); ?>)</a>
    </li>
</ul>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="d-flex justify-content-between align-items-center px-3 pt-3 pb-2">
            <div class="d-flex align-items-center gap-2">
                <span class="text-muted small">Show</span>
                <select class="form-select form-select-sm" style="width: auto;" onchange="window.location.href=this.value">
                    <?php $__currentLoopData = [10, 20, 50, 100]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e(request()->fullUrlWithQuery(['per_page' => $n])); ?>" <?php echo e((int)request('per_page', 10) === $n ? 'selected' : ''); ?>><?php echo e($n); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <span class="text-muted small">per page</span>
            </div>
            <div class="text-muted small">
                Showing <?php echo e($categories->firstItem()); ?>-<?php echo e($categories->lastItem()); ?> of <?php echo e($categories->total()); ?>

            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3"><a href="<?php echo e(sortUrl('id', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark"># <?php echo sortIndicator('id', $sortBy, $sortDir); ?></a></th>
                        <th><a href="<?php echo e(sortUrl('name', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark">Name <?php echo sortIndicator('name', $sortBy, $sortDir); ?></a></th>
                        <th>Parent Category</th>
                        <th><a href="<?php echo e(sortUrl('slug', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark">Slug <?php echo sortIndicator('slug', $sortBy, $sortDir); ?></a></th>
                        <th>Blog</th>
                        <th><a href="<?php echo e(sortUrl('status', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark">Status <?php echo sortIndicator('status', $sortBy, $sortDir); ?></a></th>
                        <th class="pe-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="ps-3"><?php echo e($cat->id); ?></td>
                        <td><?php echo e($cat->name); ?></td>
                        <td><?php echo e($cat->parent?->name ?? "—"); ?></td>
                        <td><code><?php echo e($cat->slug); ?></code></td>
                        <td><?php echo e($cat->blogs_count); ?></td>
                        <td>
                            <?php if(request()->has('trashed')): ?>
                                <span class="badge bg-light text-secondary border border-secondary-subtle">Deleted</span>
                            <?php else: ?>
                                <span class="badge <?php echo e($cat->status === 'active' ? 'bg-light text-success border border-success-subtle' : 'bg-light text-danger border border-danger-subtle'); ?>">
                                    <?php echo e(ucfirst($cat->status)); ?>

                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="pe-3 table-action-col">
                            <div class="action-buttons">
                            <?php if(request()->has('trashed')): ?>
                                <form action="<?php echo e(route('admin.blog-categories.restore', $cat->id)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <button class="action-btn btn-restore" title="Restore"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/></svg></button>
                                </form>
                                <form action="<?php echo e(route('admin.blog-categories.force-delete', $cat->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Permanently delete <?php echo e($cat->name); ?>?')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button class="action-btn btn-cancel" title="Delete Permanently"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg></button>
                                </form>
                            <?php else: ?>
                                <a href="<?php echo e(route('admin.blog-categories.edit', $cat->id)); ?>" class="action-btn btn-edit" title="Edit"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></a>
                                <form action="<?php echo e(route('admin.blog-categories.destroy', $cat->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Delete <?php echo e($cat->name); ?>?')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button class="action-btn btn-cancel" title="Delete"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg></button>
                                </form>
                            <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted"><?php echo e(request()->has('trashed') ? 'Trash is empty.' : 'No results found.'); ?></td>
                    </tr>   
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if($categories->hasPages()): ?>
            <div class="d-flex justify-content-center py-3"><?php echo e($categories->links()); ?></div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/stautoparts/resources/views/admin/blog-categories/index.blade.php ENDPATH**/ ?>