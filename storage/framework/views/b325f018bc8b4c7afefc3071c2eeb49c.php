<?php $__env->startSection('page-id', 'admin-staff-index-page'); ?>
<?php $__env->startSection('page-class', 'admin-staff-index-page'); ?>
<?php $__env->startSection('page-title', 'Staff'); ?>
<?php $__env->startSection('content'); ?>

<div class="container-fluid">

    <div class="card border-0 shadow-sm">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="fw-bold mb-0">Staff Management</h4>

            <?php if(Auth::check() && in_array(Auth::user()->role, ['master_admin', 'admin'])): ?>
                <a href="<?php echo e(route('admin.staff.create')); ?>" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add Staff
                </a>
            <?php endif; ?>
        </div>

        <div class="card-body">

            <?php $staffList = $users ?? $staffs ?? collect(); ?>

            <div class="d-flex justify-content-between align-items-center px-0 pb-2">
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
                    Showing <?php echo e($staffList->firstItem()); ?>-<?php echo e($staffList->lastItem()); ?> of <?php echo e($staffList->total()); ?>

                </div>
            </div>

            <div class="table-responsive">

                <table class="table table-hover mb-0">

                    <thead class="table-light">
                        <tr>
                            <th><a href="<?php echo e(sortUrl('id', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark">ID <?php echo sortIndicator('id', $sortBy, $sortDir); ?></a></th>
                            <th>Image</th>
                            <th><a href="<?php echo e(sortUrl('name', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark">Name <?php echo sortIndicator('name', $sortBy, $sortDir); ?></a></th>
                            <th><a href="<?php echo e(sortUrl('email', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark">Email Address <?php echo sortIndicator('email', $sortBy, $sortDir); ?></a></th>
                            <th><a href="<?php echo e(sortUrl('role', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark">Role <?php echo sortIndicator('role', $sortBy, $sortDir); ?></a></th>
                            <th><a href="<?php echo e(sortUrl('created_at', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark">Joined <?php echo sortIndicator('created_at', $sortBy, $sortDir); ?></a></th>
                            <th width="180">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php $__empty_1 = true; $__currentLoopData = $staffList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                            <tr>

                                <td><?php echo e($user->id); ?></td>

                                <td>
                                    <img
                                        src="<?php echo e(asset('assets/images/customers/' . ($user->image ?? 'default.png'))); ?>"
                                        width="60"
                                        class="rounded"
                                        alt="<?php echo e($user->name); ?>">
                                </td>

                                <td><?php echo e($user->name); ?></td>

                                <td><?php echo e($user->email); ?></td>

                                <td>
                                    <span class="badge bg-light text-primary border border-primary-subtle">
                                        <?php echo e(ucfirst($user->role)); ?>

                                    </span>
                                </td>

                                <td>
                                    <?php echo e($user->created_at->format('d M Y')); ?>

                                </td>

                                <td class="table-action-col pe-3">
                                    <div class="action-buttons">
                                    <a href="<?php echo e(route('admin.staff.edit', $user->id)); ?>" class="action-btn btn-edit" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Edit"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></a>

                                    <form action="<?php echo e(route('admin.staff.destroy', $user->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Delete this staff member?')">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button class="action-btn btn-cancel" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Delete"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg></button>
                                    </form>
                                    </div>

                                </td>

                            </tr>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">No results found.</td>
                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

            <?php if($staffList->hasPages()): ?>
                <div class="d-flex justify-content-center"><?php echo e($staffList->links()); ?></div>
            <?php endif; ?>

        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/stautoparts/resources/views/admin/staff/index.blade.php ENDPATH**/ ?>