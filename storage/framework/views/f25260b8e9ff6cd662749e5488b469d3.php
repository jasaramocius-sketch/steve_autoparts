<?php $__env->startSection('page-title', isset($user) ? 'Edit User' : 'Add User'); ?>
<?php $__env->startSection('content'); ?>

<div class="card border-0 shadow-sm">
    <!-- <div class="card-header bg-white">
        <h5 class="mb-0"><?php echo e(isset($user) ? 'Edit User: ' . $user->name : 'Add User'); ?></h5>
    </div> -->
    <div class="card-body">
        <form action="<?php echo e(isset($user) ? route('admin.users.update', $user->id) : route('admin.users.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php if(isset($user)): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('name', $user->name ?? '')); ?>" required>
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email Address <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('email', $user->email ?? '')); ?>" required>
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Role <span class="text-danger">*</span></label>
                    <?php if(isset($user) && $user->role === 'master_admin'): ?>
                        <input type="hidden" name="role" value="master_admin">
                        <input type="text" class="form-control" value="Admin" disabled>
                        <div class="form-text text-warning"><i class="fas fa-lock"></i> Master admin role cannot be changed.</div>
                    <?php else: ?>
                    <select name="role" class="form-select <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                        <option value="">None</option>
                        <option value="master_admin" <?php echo e(old('role', $user->role ?? '') === 'master_admin' ? 'selected' : ''); ?>>Admin</option>
                        <option value="staff" <?php echo e(old('role', $user->role ?? '') === 'staff' ? 'selected' : ''); ?>>Staff</option>
                        <option value="customer" <?php echo e(old('role', $user->role ?? '') === 'customer' ? 'selected' : ''); ?>>Customer</option>
                    </select>
                    <?php endif; ?>
                    <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <?php if(isset($user) && $user->role === 'master_admin'): ?>
                        <input type="hidden" name="status" value="active">
                        <input type="text" class="form-control" value="Active" disabled>
                        <div class="form-text text-warning"><i class="fas fa-lock"></i> Master admin status is always active.</div>
                    <?php else: ?>
                    <select name="status" class="form-select <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <option value="active" <?php echo e(old('status', $user->status ?? 'active') === 'active' ? 'selected' : ''); ?>>Active</option>
                        <option value="inactive" <?php echo e(old('status', $user->status ?? '') === 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                    </select>
                    <?php endif; ?>
                    <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Phone</label>
                    <input type="tel" name="phone" class="form-control" inputmode="numeric" value="<?php echo e(old('phone', $user->phone ?? '')); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Password <?php if(!isset($user)): ?><span class="text-danger">*</span><?php endif; ?></label>
                    <input type="password" name="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(isset($user) ? 'Leave blank to keep current' : 'Min 6 characters'); ?>" <?php echo e(!isset($user) ? 'required' : ''); ?>>
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="col-md-6">
                    <label class="form-label">City</label>
                    <input type="text" name="city" class="form-control" value="<?php echo e(old('city', $user->city ?? '')); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Country</label>
                    <input type="text" name="country" class="form-control" value="<?php echo e(old('country', $user->country ?? '')); ?>">
                </div>
                <div class="col-md-12">
                    <label class="form-label">Address</label>
                    <input type="text" name="address" class="form-control" value="<?php echo e(old('address', $user->address ?? '')); ?>">
                </div>
            </div>

            <div class="mt-4">
                <button class="btn btn-primary steve-btn"><i class="fas fa-save"></i> <?php echo e(isset($user) ? 'Update' : 'Save'); ?></button>
                <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/stautoparts/resources/views/admin/users/form.blade.php ENDPATH**/ ?>