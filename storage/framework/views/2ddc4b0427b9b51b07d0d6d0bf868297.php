<?php $__env->startSection('page-title', 'All Categories'); ?>
<?php $__env->startPush('page-builder-css'); ?>
<style>
    @media (max-width:575px) {
        .cat-topbar { flex-wrap:wrap; gap:8px; }
        .cat-topbar form { flex:1; min-width:0; }
        .cat-topbar form .form-control { width:100% !important; }
        .cat-topbar .btn-primary { flex-shrink:0; }
        .cat-controls { flex-wrap:wrap; gap:4px; }
        .cat-controls .text-muted { white-space:nowrap; }
    }
    @media (max-width:360px) {
        .cat-topbar { flex-direction:column; }
        .cat-topbar form { width:100%; }
        .cat-topbar .btn-primary { width:100%; justify-content:center; }
        .cat-topbar .btn-primary i { display:none; }
        .cat-controls { flex-direction:column; gap:4px; }
    }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>

<?php $trashedCount = \App\Models\Category::onlyTrashed()->count(); ?>

<div class="d-flex justify-content-between align-items-center mb-3 cat-topbar">
    <form action="<?php echo e(route('admin.categories.index')); ?>" method="GET" class="d-flex gap-2">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Search categories..." value="<?php echo e(request('search')); ?>" style="width:200px;">
            <button class="btn btn-sm btn-outline-primary steve-btn" type="submit"><i class="fas fa-search"></i></button>
            <?php if(request('search')): ?>
                <a href="<?php echo e(route('admin.categories.index')); ?>" class="btn btn-sm btn-outline-secondary"><i class="fas fa-times"></i></a>
            <?php endif; ?>
        </form>

    <div class="d-flex gap-2">
        
        <a href="<?php echo e(route('admin.categories.create')); ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Add Category</a>
    </div>
</div>

<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a class="nav-link <?php echo e(!request()->has('trashed') ? 'active' : ''); ?>" href="<?php echo e(route('admin.categories.index')); ?>">Active</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php echo e(request()->has('trashed') ? 'active' : ''); ?>" href="<?php echo e(route('admin.categories.index', ['trashed' => 1])); ?>">Trash (<?php echo e($trashedCount); ?>)</a>
    </li>
</ul>

<div class="card border-0 shadow-sm">
    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center pb-2 cat-controls">
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
        <table class="table table-hover mb-0">

            <thead class="table-light">
            <tr>
                <?php if(request()->has('trashed')): ?>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Products</th>
                <th>Parent Category</th>
                <th width="200">Action</th>
                <?php else: ?>
                <th><a href="<?php echo e(sortUrl('id', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark">ID <?php echo sortIndicator('id', $sortBy, $sortDir); ?></a></th>
                <th>Image</th>
                <th><a href="<?php echo e(sortUrl('name', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark">Name <?php echo sortIndicator('name', $sortBy, $sortDir); ?></a></th>
                <th>Slug</th>
                <th><a href="<?php echo e(sortUrl('status', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark">Status <?php echo sortIndicator('status', $sortBy, $sortDir); ?></a></th>
                <th><a href="<?php echo e(sortUrl('products_count', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark">Products <?php echo sortIndicator('products_count', $sortBy, $sortDir); ?></a></th>
                <th>Parent Category</th>
                <th width="">Action</th>
                <?php endif; ?>
            </tr>
            </thead>

            <tbody>

            <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

            <tr class="categoryRow">

                <td><?php echo e($category->id); ?></td>

                <td>
                    <img src="<?php echo e($category->image
                        ? asset('assets/images/categories/'.$category->image)
                        : ''); ?>"
                        width="50"
                        alt="<?php echo e($category->name); ?>">
                </td>

                <td><?php echo e($category->name); ?></td>

                <td><?php echo e($category->slug); ?></td>

                <td>
                    <?php if(request()->has('trashed')): ?>
                        <span class="badge bg-light text-secondary border border-secondary-subtle">Deleted</span>
                    <?php else: ?>
                        <form action="<?php echo e(route('admin.categories.toggle-status', $category->id)); ?>" method="POST" class="d-inline featured-status-btn">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-sm border-0 p-0 steve-btn">
                                <span class="badge <?php echo e($category->status ? 'bg-success' : 'bg-danger'); ?>" style="cursor:pointer;">
                                    <?php echo e($category->status ? 'Active' : 'Inactive'); ?>

                                </span>
                            </button>
                        </form>
                    <?php endif; ?>
                </td>

                <td><?php echo e($category->products_count ?? 0); ?></td>

                <td>
                    <?php echo e($category->parent_category?->name ??  'None'); ?>

                </td>

                <td class="table-action-col">
                  <div class="action-buttons">
                    <?php if(request()->has('trashed')): ?>
                        <form action="<?php echo e(route('admin.categories.restore', $category->id)); ?>" method="POST" class="d-inline">
                            <?php echo csrf_field(); ?>
                            <button class="action-btn btn-restore" title="Restore"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/></svg></button>
                        </form>
                        <form action="<?php echo e(route('admin.categories.force-delete', $category->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Permanently delete <?php echo e($category->name); ?>?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="action-btn btn-cancel" title="Delete Permanently"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg></button>
                        </form>
                    <?php else: ?>
                        <a href="<?php echo e(route('admin.categories.edit',$category->id)); ?>" class="action-btn btn-edit" title="Edit"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></a>
                        <form action="<?php echo e(route('admin.categories.destroy',$category->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Delete category?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="action-btn btn-cancel" title="Delete"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg></button>
                        </form>
                    <?php endif; ?>
                    </div>
                </td>

            </tr>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="8" class="text-center py-4 text-muted"><?php echo e(request()->has('trashed') ? 'Trash is empty.' : 'No results found.'); ?></td>
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
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/stautoparts/resources/views/admin/categories/index.blade.php ENDPATH**/ ?>