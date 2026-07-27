<div class="col-lg-3 mb-4 position-relative">

    <button class="dashboard-sidebar-toggle d-lg-none border-0 bg-transparent p-2 mb-3 steve-btn" type="button" aria-label="Toggle sidebar" style="display:none;">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="3" y1="6" x2="21" y2="6"></line>
            <line x1="3" y1="12" x2="21" y2="12"></line>
            <line x1="3" y1="18" x2="21" y2="18"></line>
        </svg>
        <span class="ms-2 fw-500">Menu</span>
    </button>

    <div class="dashboard-sidebar-overlay"></div>

    <div class="user-dashboard-sidebar">
        <div class="dashboard-sidebar-close-div">
        <button class="dashboard-sidebar-close d-lg-none border-0 bg-transparent p-2 steve-btn justify-content-end" type="button" aria-label="Close sidebar">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
        </div>

        <ul class="gs-dashboard-user-sidebar-wrapper nav flex-column p-0">
            <div class="p-4 text-center mb-4 border-bottom position-relative bg-white rounded">
                <span class="avatar avatar-md mb-3">
                    <img src="<?php echo e(auth()->user() && auth()->user()->avatar ? asset(auth()->user()->avatar) : asset('assets/images/avatar-place.png')); ?>" class="image rounded-circle" onerror="this.onerror=null;this.src='<?php echo e(asset('assets/images/avatar-place.png')); ?>';" width="100">
                </span>
                <h4 class="h5 fs-14 mb-1 fw-700 text-dark"><?php echo e(auth()->user()->name ?? session('user_profile.name')); ?></h4>
                <div class="text-truncate opacity-60 fs-12"><?php echo e(auth()->user()->email ?? session('user_profile.email')); ?></div>
            </div>

            <li><a class="nav-link <?php echo e(request()->routeIs('user.dashboard') ? 'active' : ''); ?>" href="<?php echo e(route('user.dashboard')); ?>"><i class="fas fa-th-large me-2"></i>Dashboard</a></li>

            <li><a class="nav-link <?php echo e(request()->routeIs('user.orders') ? 'active' : ''); ?>" href="<?php echo e(route('user.orders')); ?>"><i class="fas fa-shopping-bag me-2"></i>Orders</a></li>

            <li><a class="nav-link <?php echo e(request()->routeIs('user.reviews') ? 'active' : ''); ?>" href="<?php echo e(route('user.reviews')); ?>"><i class="fas fa-star me-2"></i>My Reviews</a></li>

            <li><a class="nav-link <?php echo e(request()->routeIs('user.order.tracking') ? 'active' : ''); ?>" href="<?php echo e(route('user.order.tracking')); ?>"><i class="fas fa-search me-2"></i>Order Tracking</a></li>

            <li><a class="nav-link <?php echo e(request()->routeIs('user.wishlist') ? 'active' : ''); ?>" href="<?php echo e(route('user.wishlist')); ?>"><i class="fas fa-heart me-2"></i>My Wishlist</a></li>

            <!-- <li><a class="nav-link <?php echo e(request()->routeIs('compare.index') ? 'active' : ''); ?>" href="<?php echo e(route('compare.index')); ?>"><i class="fas fa-exchange-alt me-2"></i>Compare Products</a></li> -->

            <li><a class="nav-link <?php echo e(request()->routeIs('user.followed-sellers') ? 'active' : ''); ?>" href="<?php echo e(route('user.followed-sellers')); ?>"><i class="fas fa-user-friends me-2"></i>Followed Sellers</a></li>

            <li><a class="nav-link <?php echo e(request()->routeIs('user.vehicles') ? 'active' : ''); ?>" href="<?php echo e(route('user.vehicles')); ?>"><i class="fas fa-car me-2"></i>My Vehicles</a></li>

            <li><a class="nav-link <?php echo e(request()->routeIs('user.addresses') ? 'active' : ''); ?>" href="<?php echo e(route('user.addresses')); ?>"><i class="fas fa-map-marker-alt me-2"></i>My Addresses</a></li>

            <li><a class="nav-link <?php echo e(request()->routeIs('user.notifications') ? 'active' : ''); ?>" href="<?php echo e(route('user.notifications')); ?>"><i class="fas fa-bell me-2"></i>Notifications</a></li>
            <li class="nav-item mb-2">
            <a class="nav-link <?php echo e(request()->routeIs('user.profile') ? 'active' : ''); ?>" href="<?php echo e(route('user.profile')); ?>">
                <i class="fas fa-user-cog"></i>
                My Profile
            </a>
            </li>
            <?php if(($profile['role'] ?? '') === 'master_admin'): ?>
            <li class="nav-item mb-2">
            <a class="nav-link d-flex align-items-center gap-2" href="<?php echo e(route('admin.users.index')); ?>" style="text-decoration: none; border-radius: 6px; font-weight: 500; background:#fff3ec; color:var(--primary);">
                <i class="fas fa-users-cog"></i> <span>User Management</span>
            </a>
            </li>
            <?php endif; ?>
            <li class="nav-item mt-4">
            <form action="<?php echo e(route('logout')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <button type="submit" class="w-100 border-0 text-white steve-btn user-dashboard-page-logout-btn nav-link" >
                <i class="fas fa-sign-out-alt me-2"></i> Logout
                </button>
            </form>
            </li>
        </ul>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var sidebar = document.querySelector('.user-dashboard-sidebar');
    var overlay = document.querySelector('.dashboard-sidebar-overlay');
    var toggle = document.querySelector('.dashboard-sidebar-toggle');
    var close = document.querySelector('.dashboard-sidebar-close');

    function openSidebar() {
        sidebar.classList.add('active');
        overlay.classList.add('active');
        document.body.classList.add('overflow-hidden');
    }

    function closeSidebar() {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
        document.body.classList.remove('overflow-hidden');
    }

    if (toggle) toggle.addEventListener('click', openSidebar);
    if (close) close.addEventListener('click', closeSidebar);
    if (overlay) overlay.addEventListener('click', closeSidebar);

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && sidebar && sidebar.classList.contains('active')) {
            closeSidebar();
        }
    });
});
</script><?php /**PATH /var/www/html/stautoparts/resources/views/user/layouts/sidebar.blade.php ENDPATH**/ ?>