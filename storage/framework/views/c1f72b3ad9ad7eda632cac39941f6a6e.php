<link rel="stylesheet" href="<?php echo e(asset('assets/front/css/style.css')); ?>?v=<?php echo e(filemtime(public_path('assets/front/css/style.css'))); ?>">
<div class="admin-navbar admin-dashboard-header">
    <div class="d-flex align-items-center gap-3">
        <button class="btn btn-sm btn-outline-secondary d-md-none steve-btn" id="sidebarToggle" title="Toggle sidebar">
            <i class="fas fa-bars"></i>
        </button>
        <a href="<?php echo e(url()->previous()); ?>" class="btn btn-outline-secondary steve-btn btn-sm">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="page-title"><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></div>
    </div>
    <div class="nav-actions">
        <a href="<?php echo e(route('home')); ?>" target="_blank" class="btn btn-sm btn-outline-primary d-none d-md-inline-block" title="View Site">
            <i class="fas fa-external-link-alt"></i>
        </a>
        <a href="<?php echo e(route('admin.clear.cache')); ?>" class="btn btn-sm btn-outline-danger"
           onclick="return confirm('Clear all cache?')" title="Clear Cache">
            <i class="fas fa-broom"></i>
        </a>
        <div class="dropdown">
            <a href="#" class="user-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="user-avatar">
                    <?php if(Auth::user()->avatar): ?>
                        <img src="<?php echo e(asset(Auth::user()->avatar)); ?>" alt="<?php echo e(Auth::user()->name); ?>">
                    <?php else: ?>
                        <?php echo e(strtoupper(substr(Auth::user()->name, 0, 1))); ?>

                    <?php endif; ?>
                </div>
                <div>
                    <div class="login-user-labels text-transform-capitalize" style="font-size:14px;font-weight:500;line-height:1.2;"><?php echo e(Auth::user()->name); ?></div>
                    <div style="font-size:11px;color:#6c757d;">
                        <?php
                            $roleLabel = match(Auth::user()->role) {
                                'master_admin' => 'Admin',
                                'admin' => 'Admin',
                                'staff' => 'Staff',
                                default => 'Customer',
                            };
                            $roleBadge = match(Auth::user()->role) {
                                'master_admin' => 'danger',
                                'admin' => 'danger',
                                'staff' => 'info',
                                default => 'success',
                            };
                        ?>
                        <span class="badge bg-light border border-<?php echo e($roleBadge); ?>-subtle text-<?php echo e($roleBadge); ?>" style="font-size:10px;"><?php echo e($roleLabel); ?></span>
                    </div>
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                <li><a class="dropdown-item" href="<?php echo e(route('admin.profile')); ?>"><i class="fas fa-user-cog fa-fw me-2"></i>My Profile</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="<?php echo e(route('logout')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="dropdown-item steve-btn"><i class="fas fa-sign-out-alt fa-fw me-2"></i>Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
<?php /**PATH /var/www/html/stautoparts/resources/views/admin/partials/navbar.blade.php ENDPATH**/ ?>