<div class="admin-sidebar">
    <div class="brand">
        <a class="d-block py-15px mr-3 ml-0" href="<?php echo e(route('home')); ?>">
                            <img src="<?php echo e(asset('assets/images/' . (\App\Models\Setting::get('header_logo') ?? 'BwSkuSZ7ZYGWPc4Zk3CfeFzcn49dHpx3143n4WKS.png'))); ?>" alt="SteveAutoPartsInc." class="mw-100 h-80px h-md-50px" height="40">
                         STEVE Autoparts</a>
        <button class="sidebar-close-btn d-md-none" id="sidebarCloseBtn" title="Close sidebar">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="nav-wrap">
        <div class="admin-sidebar-scroll-box scroll-box">
        <div class="nav-section">Main</div>
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        <a href="<?php echo e(route('admin.orders.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.orders.*') ? 'active' : ''); ?>">
            <i class="fas fa-shopping-cart"></i> Orders
        </a>
        <a href="<?php echo e(route('admin.products.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.products.*') && !request()->routeIs('admin.products.import-form') ? 'active' : ''); ?>">
            <i class="fas fa-box"></i> Products
        </a>
        <!-- <a href="<?php echo e(route('admin.products.import-form')); ?>" class="nav-item nav-item-sub <?php echo e(request()->routeIs('admin.products.import-form') ? 'active' : ''); ?>">
            <i class="fas fa-upload"></i> Import Products -->
        </a>
        <a href="<?php echo e(route('admin.categories.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.categories.*') ? 'active' : ''); ?>">
            <i class="fas fa-list"></i> Categories
        </a>
        <a href="<?php echo e(route('admin.brands.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.brands.*') ? 'active' : ''); ?>">
            <i class="fas fa-tag"></i> Brands
        </a>

        <div class="nav-section">Content</div>
        <a href="<?php echo e(route('page-builder.index')); ?>" class="nav-item <?php echo e(request()->routeIs('page-builder.*') ? 'active' : ''); ?>">
            <i class="fas fa-puzzle-piece"></i> Page Builder
        </a>
        <a href="<?php echo e(route('admin.images.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.images.*') ? 'active' : ''); ?>">
            <i class="fas fa-images"></i> Image Manager
        </a>
        <a href="<?php echo e(route('admin.blogs.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.blogs.*') ? 'active' : ''); ?>">
            <i class="fas fa-blog"></i> Blog
        </a>
        <a href="<?php echo e(route('admin.blog-categories.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.blog-categories.*') ? 'active' : ''); ?>">
            <i class="fas fa-folder"></i> Blog Categories
        </a>
        <a href="<?php echo e(route('admin.pages.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.pages.*') ? 'active' : ''); ?>">
            <i class="fas fa-file"></i> Pages
        </a>
        <a href="<?php echo e(route('admin.faqs.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.faqs.*') ? 'active' : ''); ?>">
            <i class="fas fa-question-circle"></i> FAQs
        </a>
        <a href="<?php echo e(route('admin.contacts.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.contacts.*') ? 'active' : ''); ?>">
            <i class="fas fa-envelope-open-text"></i> Questions
        </a>
        <a href="<?php echo e(route('admin.coupons.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.coupons.*') ? 'active' : ''); ?>">
            <i class="fas fa-percent"></i> Coupons
        </a>

        <div class="nav-section">Settings</div>
        <a href="<?php echo e(route('admin.home-page.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.home-page.*') ? 'active' : ''); ?>">
            <i class="fas fa-home"></i> Home Page
        </a>
        <a href="<?php echo e(route('admin.settings.header')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.settings.header*') ? 'active' : ''); ?>">
            <i class="fas fa-sliders-h"></i> Header Settings
        </a>
        <a href="<?php echo e(route('admin.logs.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.logs.index') ? 'active' : ''); ?>">
            <i class="fas fa-file-alt"></i> Logs
        </a>
        <a href="<?php echo e(route('admin.revisions.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.revisions.index') ? 'active' : ''); ?>">
            <i class="fas fa-history"></i> Revisions
        </a>
        <a href="<?php echo e(route('admin.file-revisions.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.file-revisions.*') ? 'active' : ''); ?>">
            <i class="fas fa-file-code"></i> File Revisions
        </a>
        <a href="<?php echo e(route('admin.profile')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.profile') ? 'active' : ''); ?>">
            <i class="fas fa-user-cog"></i> My Profile
        </a>

        <div class="nav-section">People</div>
        <a href="<?php echo e(url('/admin/customers')); ?>" class="nav-item <?php echo e(request()->is('admin/customers*') ? 'active' : ''); ?>">
            <i class="fas fa-users"></i> Customers
        </a>

        <!-- <?php if(Auth::check() && in_array(Auth::user()->role, ['master_admin', 'admin'])): ?>
        <a href="<?php echo e(url('/admin/staff')); ?>" class="nav-item <?php echo e(request()->is('admin/staff*') && !request()->is('admin/staffs*') ? 'active' : ''); ?>">
            <i class="fas fa-user-tie"></i> Staff Management
        </a>
        <?php endif; ?> -->

        <?php if(Auth::check() && Auth::user()->role === 'master_admin'): ?>
        <a href="<?php echo e(route('admin.users.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.users.*') ? 'active' : ''); ?>">
            <i class="fas fa-user-cog"></i> All Users
        </a>
        <?php endif; ?>
        </div>
    </div>
</div>
<?php /**PATH /var/www/html/stautoparts/resources/views/admin/partials/sidebar.blade.php ENDPATH**/ ?>