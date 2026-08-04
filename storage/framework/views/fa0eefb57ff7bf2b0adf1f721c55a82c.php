<?php $__env->startSection('page-id', 'admin-blogs-index-page'); ?>
<?php $__env->startSection('page-class', 'admin-blogs-index-page'); ?>
<?php $__env->startSection('page-title', 'All Blogs'); ?>
<?php $__env->startSection('content'); ?>

<?php $trashedCount = \App\Models\Blog::onlyTrashed()->count(); ?>

<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap flex-md-nowrap">
    <div class=""></div>
    <a href="<?php echo e(route('admin.blogs.create')); ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Add Blog</a>
</div>

<ul class="nav nav-tabs mb-3 flex-wrap flex-md-nowrap">
    <li class="nav-item">
        <a class="nav-link <?php echo e(!request()->has('trashed') ? 'active' : ''); ?>" href="<?php echo e(route('admin.blogs.index')); ?>">Active</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php echo e(request()->has('trashed') ? 'active' : ''); ?>" href="<?php echo e(route('admin.blogs.index', ['trashed' => 1])); ?>">Trash (<?php echo e($trashedCount); ?>)</a>
    </li>
    <li class="nav-item search-form ms-lg-auto">
        <?php echo $__env->make('admin.partials.search-form', [
            'route' => route('admin.blogs.index'),
            'placeholder' => 'Search blogs...'
        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </li>
</ul>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="d-flex justify-content-between align-items-center px-3 pt-3 pb-2 flex-wrap flex-md-nowrap mb-3 flex-wrap flex-md-nowrap">
            <div class="d-flex align-items-center gap-2">
                <span class="text-muted small">Show</span>
                <select class="form-select w-auto" onchange="window.location.href=this.value">
                    <?php $__currentLoopData = [10, 20, 50, 100]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e(request()->fullUrlWithQuery(['per_page' => $n])); ?>" <?php echo e((int)request('per_page', 10) === $n ? 'selected' : ''); ?>><?php echo e($n); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <span class="text-muted small">per page</span>
            </div>
            <div class="text-muted small">
                Showing <?php echo e($blogs->firstItem()); ?>-<?php echo e($blogs->lastItem()); ?> of <?php echo e($blogs->total()); ?>

            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3"><a href="<?php echo e(sortUrl('id', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark"># <?php echo sortIndicator('id', $sortBy, $sortDir); ?></a></th>
                        <th>Image</th>
                        <th><a href="<?php echo e(sortUrl('title', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark">Title <?php echo sortIndicator('title', $sortBy, $sortDir); ?></a></th>
                        <th><a href="<?php echo e(sortUrl('status', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark">Status <?php echo sortIndicator('status', $sortBy, $sortDir); ?></a></th>
                        <th><a href="<?php echo e(sortUrl('created_at', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark">Date <?php echo sortIndicator('created_at', $sortBy, $sortDir); ?></a></th>
                        <th class="pe-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="ps-3"><?php echo e($blog->id); ?></td>
                        <td>
                            <?php if($blog->image): ?>
                                <img src="<?php echo e(asset('assets/images/blogs/' . $blog->image)); ?>" width="50" height="50" style="object-fit:cover; border-radius:4px;">
                            <?php else: ?>
                                <img src="<?php echo e(asset('assets/images/blogs/placeholder.jpg')); ?>" width="50" height="50" style="object-fit:cover; border-radius:4px;">
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($blog->title ?? 'Untitled'); ?></td>
                        <td>
                            <?php if(request()->has('trashed')): ?>
                                <span class="badge <?php echo e($blog->status === 'published' ? 'bg-success' : 'bg-light text-warning border border-warning-subtle'); ?>" style="cursor:pointer;">Deleted</span>
                            <?php else: ?>
                                <form action="<?php echo e(route('admin.blogs.toggle-status', $blog->id)); ?>" method="POST" class="d-inline featured-status-btn">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-sm border-0 p-0 steve-btn">
                                        <span class="badge <?php echo e($blog->status === 'published' ? 'bg-success' : 'bg-danger border border-danger-subtle'); ?>" style="cursor:pointer;">
                                            <?php echo e(ucfirst($blog->status ?? 'draft')); ?>

                                        </span>
                                    </button>
                                </form>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($blog->created_at ? $blog->created_at->format('d M Y') : '—'); ?></td>
                        <td class="pe-3 table-action-col">
                            <div class="action-buttons">
                            <?php if(request()->has('trashed')): ?>
                                <form action="<?php echo e(route('admin.blogs.restore', $blog->id)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <button class="action-btn btn-restore" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Restore"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/></svg></button>
                                </form>
                                <form action="<?php echo e(route('admin.blogs.force-delete', $blog->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Permanently delete <?php echo e($blog->title); ?>?')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button class="action-btn btn-cancel" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Delete Permanently"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg></button>
                                </form>
                            <?php else: ?>
                                <a href="<?php echo e(route('admin.blogs.edit', $blog->id)); ?>" class="action-btn btn-edit" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Edit"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></a>
                                <form action="<?php echo e(route('admin.blogs.destroy', $blog->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Delete this blog?')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button class="action-btn btn-cancel" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Delete"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg></button>
                                </form>
                            <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted"><?php echo e(request()->has('trashed') ? 'Trash is empty.' : 'No results found.'); ?></td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if($blogs->hasPages()): ?>
            <div class="d-flex justify-content-center py-3"><?php echo e($blogs->links()); ?></div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/stautoparts/resources/views/admin/blogs/index.blade.php ENDPATH**/ ?>