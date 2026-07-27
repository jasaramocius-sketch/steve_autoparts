<?php $__env->startSection('page-title', 'Manage Home Page'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0">Home Page Sections</h4>
                <!-- <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-secondary">Back to Dashboard</a> -->
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <!-- <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Home Page Sections</h5>
                </div> -->
                <div class="card-body">
                    <?php if($sections->count() > 0): ?>
                        <div class="d-flex justify-content-between align-items-center pb-2">
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
                                Showing <?php echo e($sections->firstItem()); ?>-<?php echo e($sections->lastItem()); ?> of <?php echo e($sections->total()); ?>

                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th><a href="<?php echo e(sortUrl('section_name', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark">Section Name <?php echo sortIndicator('section_name', $sortBy, $sortDir); ?></a></th>
                                        <th><a href="<?php echo e(sortUrl('title', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark">Title <?php echo sortIndicator('title', $sortBy, $sortDir); ?></a></th>
                                        <th><a href="<?php echo e(sortUrl('status', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark">Status <?php echo sortIndicator('status', $sortBy, $sortDir); ?></a></th>
                                        <th><a href="<?php echo e(sortUrl('order', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark">Order <?php echo sortIndicator('order', $sortBy, $sortDir); ?></a></th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td>
                                                <strong><?php echo e(ucfirst(str_replace('_', ' ', $section->section_name))); ?></strong>
                                            </td>
                                            <td><?php echo e(Str::limit($section->title, 50)); ?></td>
                                            <td>
                                                <span class="badge <?php echo e($section->status ? 'bg-light text-success border border-success-subtle' : 'bg-light text-danger border border-danger-subtle'); ?>">
                                                    <?php echo e($section->status ? 'Active' : 'Inactive'); ?>

                                                </span>
                                            </td>
                                            <td><?php echo e($section->order); ?></td>
                                            <td class="pe-3 table-action-col">
                                                <div class="action-buttons">
                                                    <a href="<?php echo e(route('admin.home-page.edit', $section->id)); ?>" class="action-btn btn-edit" title="Edit"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-muted">No sections found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php if($sections->hasPages()): ?>
                            <div class="d-flex justify-content-center py-3"><?php echo e($sections->links()); ?></div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="alert alert-info">
                            No sections found. Please run migrations to initialize home page sections.
                            <br><br>
                            <code>php artisan migrate</code>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .table-hover tbody tr:hover {
        background-color: #f5f5f5;
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/stautoparts/resources/views/admin/home-page/index.blade.php ENDPATH**/ ?>