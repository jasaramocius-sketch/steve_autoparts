<?php $__env->startSection('page-title', 'User Management'); ?>
<?php $__env->startSection('content'); ?>
<div class="user-management-page">
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap flex-md-nowrap">
    <div class=""></div>
    <a href="<?php echo e(route('admin.users.create')); ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Add User</a>
</div>

<div class="row g-3 mb-4">
    <?php
        $totalCount = $users->count();
        $adminCount = $users->where('role','master_admin')->count();
        $staffCount = $users->where('role','staff')->count();
        $customerCount = $users->where('role','customer')->count();
    ?>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3 text-center">
            <h5 class="fw-bold mb-1"><?php echo e($totalCount); ?></h5>
            <small class="text-muted">Total Users</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3 text-center">
            <h5 class="fw-bold mb-1"><?php echo e($adminCount); ?></h5>
            <small class="text-muted">Admin</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3 text-center">
            <h5 class="fw-bold mb-1"><?php echo e($staffCount); ?></h5>
            <small class="text-muted">Staff</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3 text-center">
            <h5 class="fw-bold mb-1"><?php echo e($customerCount); ?></h5>
            <small class="text-muted">Customer</small>
        </div>
    </div>
</div>

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
                Showing <?php echo e($users->firstItem()); ?>-<?php echo e($users->lastItem()); ?> of <?php echo e($users->total()); ?>

            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3"><a href="<?php echo e(sortUrl('id', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark"># <?php echo sortIndicator('id', $sortBy, $sortDir); ?></a></th>
                        <th><a href="<?php echo e(sortUrl('name', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark">Name <?php echo sortIndicator('name', $sortBy, $sortDir); ?></a></th>
                        <th><a href="<?php echo e(sortUrl('email', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark">Email Address <?php echo sortIndicator('email', $sortBy, $sortDir); ?></a></th>
                        <th>Phone</th>
                        <th><a href="<?php echo e(sortUrl('role', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark">Role <?php echo sortIndicator('role', $sortBy, $sortDir); ?></a></th>
                        <th><a href="<?php echo e(sortUrl('status', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark">Status <?php echo sortIndicator('status', $sortBy, $sortDir); ?></a></th>
                        <th><a href="<?php echo e(sortUrl('city', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark">City <?php echo sortIndicator('city', $sortBy, $sortDir); ?></a></th>
                        <th><a href="<?php echo e(sortUrl('created_at', $sortBy, $sortDir)); ?>" class="text-decoration-none text-dark">Joined <?php echo sortIndicator('created_at', $sortBy, $sortDir); ?></a></th>
                        <th class="pe-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="ps-3"><?php echo e($user->id); ?></td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div style="width:32px;height:32px;border-radius:50%;background:var(--bs-primary);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px;">
                                    <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

                                </div>
                                <span class="user-name text-transform-capitalize"><?php echo e($user->name); ?></span>
                            </div>
                        </td>
                        <td><?php echo e($user->email); ?></td>
                        <td><?php echo e($user->phone ?? '—'); ?></td>
                        <td>
                            <?php if($user->role === 'master_admin'): ?>
                                <span class="badge bg-light text-danger border border-danger-subtle">Admin</span>
                            <?php elseif($user->role === 'staff'): ?>
                                <span class="badge bg-light text-info border border-info-subtle">Staff</span>
                            <?php else: ?>
                                <span class="badge bg-light text-success border border-success-subtle">Customer</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <form action="<?php echo e(route('admin.users.toggle-status', $user->id)); ?>" method="POST" class="d-inline featured-status-btn">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-sm border-0 p-0 steve-btn">
                                    <span class="badge <?php echo e($user->status === 'active' ? 'bg-success' : 'bg-danger'); ?>" style="cursor:pointer;">
                                        <?php echo e($user->status === 'active' ? 'Active' : 'Inactive'); ?>

                                    </span>
                                </button>
                            </form>
                        </td>
                        <td><?php echo e($user->city ?? '—'); ?></td>
                        <td><?php echo e($user->created_at ? $user->created_at->format('d M Y') : '—'); ?></td>
                        <td class="pe-3 table-action-col">
                            <div class="action-buttons">
                            <a href="<?php echo e(route('admin.users.edit', $user->id)); ?>" class="action-btn btn-edit" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Edit"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></a>
                            <?php if($user->role !== 'master_admin'): ?>
                            <form action="<?php echo e(route('admin.users.destroy', $user->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Delete <?php echo e($user->name); ?>?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button class="action-btn btn-cancel" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Delete"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg></button>
                            </form>
                            <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="9" class="text-center py-4 text-muted">No results found.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if($users->hasPages()): ?>
            <div class="d-flex justify-content-center py-3"><?php echo e($users->links()); ?></div>
        <?php endif; ?>
    </div>
</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/stautoparts/resources/views/admin/users/index.blade.php ENDPATH**/ ?>