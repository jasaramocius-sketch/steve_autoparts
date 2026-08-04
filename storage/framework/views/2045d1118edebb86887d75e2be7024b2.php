<!DOCTYPE html>
<html>
<head>
    <title><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?> - Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('assets/front/css/backend.css')); ?>">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-bs5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('assets/front/css/toastr.min.css')); ?>">

    <style>
        body { background:#f4f6f9; font-family:'Inter',sans-serif; }
        .admin-sidebar { width:260px; height:100vh; position:fixed; background:#1e1e2d; color:#fff; z-index:1001; display:flex; flex-direction:column; transition:transform .25s; }
        .admin-sidebar .brand { padding:18px 20px; border-bottom:1px solid rgba(255,255,255,.08); font-size:18px; font-weight:700; letter-spacing:.5px; white-space:nowrap; display:flex; align-items:center; justify-content:space-between; }
        .admin-sidebar .brand a { flex:1; font-size:1rem;}
        .sidebar-close-btn { display:none; background:none; border:none; color:rgba(255,255,255,.6); font-size:18px; cursor:pointer; padding:4px 8px; border-radius:6px; transition:all .15s; }
        .sidebar-close-btn:hover { color:#fff; background:rgba(255,255,255,.1); }
        .admin-sidebar .brand i { color:#4bc5e7; }
        .admin-sidebar .nav-wrap { flex:1; overflow-y:auto; padding:12px 0; direction: rtl;}
        .admin-sidebar .nav-wrap { scrollbar-width: thin; scrollbar-color: var(--primary) transparent; }
        .admin-sidebar .nav-wrap::-webkit-scrollbar { width:1px; }
        .admin-sidebar .nav-wrap::-webkit-scrollbar-thumb { background: var(--hov-primary); border-radius:4px; }
        .scroll-box::-webkit-scrollbar-thumb:hover {background: var(--hov-primary);}
        .admin-sidebar-scroll-box.scroll-box {direction: ltr;}
        .admin-sidebar .nav-section { font-size:10px; text-transform:uppercase; letter-spacing:1.2px; color:rgba(255,255,255,.3); padding:16px 20px 6px; font-weight:600; }
        .admin-sidebar .nav-item { display:flex; align-items:center; gap:12px; padding:10px 20px; color:rgba(255,255,255,.6); text-decoration:none; font-size:14px; transition:all .15s; border-left:3px solid transparent; }
        .admin-sidebar .nav-item:hover { background:rgba(255,255,255,.05); color:#fff; }
        .admin-sidebar .nav-item.active { background:rgba(255,255,255,.1); color:#fff; border-left-color:#4bc5e7; }
        .admin-sidebar .nav-item i { width:18px; text-align:center; font-size:15px; }
        .main-content { margin-left:260px; min-height:100vh; display:flex; flex-direction:column; }
        .admin-navbar { background:#fff; padding:0 24px; height:60px; display:flex; align-items:center; justify-content:space-between; border-bottom:1px solid #e9ecef; position:sticky; top:0; z-index:999; }
        .admin-navbar .page-title { font-size:18px; font-weight:600; color:#1e1e2d; }
        .admin-navbar .nav-actions { display:flex; align-items:center; gap:12px; }
        .admin-navbar .user-dropdown { display:flex; align-items:center; gap:8px; cursor:pointer; padding:6px 12px; border-radius:8px; transition:background .15s; text-decoration:none; color:#1e1e2d; }
        .admin-navbar .user-dropdown:hover { background:#f4f6f9; }
        .admin-navbar .user-avatar { width:34px; height:34px; border-radius:50%; background:#1e1e2d; color:#fff; display:flex; align-items:center; justify-content:center; font-weight:600; font-size:14px; overflow:hidden; flex-shrink:0; }
        .admin-navbar .user-avatar img { width:100%; height:100%; object-fit:cover; }
        .admin-content { flex:1; padding:24px; }
        .card-box { border-radius:12px; }

        .admin-sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.5);
            z-index: 1000;
        }
        body.sidebar-open .admin-sidebar-overlay {
            display: block;
        }

        @media (max-width:767px) {
            .admin-sidebar { transform:translateX(-100%); }
            .admin-sidebar.open { transform:translateX(0); }
            .main-content { margin-left:0; }
            .admin-content { padding:16px; }
            .admin-navbar { padding:0 16px; gap:8px; }
            .admin-navbar .page-title { font-size:15px; }
            .admin-navbar .nav-actions { gap:8px; }
            .admin-navbar .user-dropdown > div:not(.user-avatar) { display:none; }
            .admin-navbar .user-dropdown { padding:4px 8px; }
            .admin-content .card-body h3 { font-size:1.2rem; }
            .dashboard-progress { width:100% !important; }
            .admin-content .table { font-size:13px; }
            .admin-content .table th,
            .admin-content .table td { padding:0.5rem 0.4rem; white-space:nowrap; }
            .admin-content .card-header h5 { font-size:1rem; }
            .admin-content .card-header .btn { font-size:14px; padding:6px 12px; }
            .sidebar-close-btn { display:inline-flex; }
            .admin-product-page-important-btn a {padding: 6px 12px;font-size: 14px;line-height: 1;}
        }
        @media (max-width:575px) {
            .admin-sidebar { width:90%; }
            .admin-content { padding:12px; }
            .admin-navbar { padding:0 12px; }
        }
        @media (max-width:360px) {
            .admin-content { padding:8px; }
            .admin-navbar { padding:0 8px; min-height:50px; }
            .admin-navbar .page-title { font-size:12px; }
            .admin-navbar .nav-actions { gap:4px; }
            .admin-navbar .user-dropdown { padding:2px 4px; }
            .admin-content .card-body h3 { font-size:1rem; }
            .admin-content .card-body .small { font-size:10px; }
            .admin-content .card-body .fa-2x { font-size:1.2em; }
            .admin-content .card-body .rounded-3 { padding:8px !important; }
            .admin-content .card-header h5 { font-size:14px; }
            .admin-content .card-header .btn { font-size:12px; padding:5px 10px; }
            .admin-content .table { font-size:12px; }
            .admin-content .table th,
            .admin-content .table td { padding:0.4rem 0.3rem; }
            .admin-content .table th:first-child,
            .admin-content .table td:first-child { padding-left:0.4rem; }
            .admin-content .card-body .d-flex.justify-content-between.mb-3 {
                flex-wrap: wrap;
                gap: 4px;
            }
            .admin-content .card-body .d-flex.gap-3 {
                gap: 6px !important;
            }
            .dashboard-progress { flex:1; min-width:60px; }
            .dashboard-progress .progress { height:6px !important; }
        }
    </style>
    <?php echo $__env->yieldPushContent('page-builder-css'); ?>
</head>

<?php echo $__env->make('partials.page-attributes', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php echo $__env->make('admin.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<div class="admin-sidebar-overlay"></div>

<div class="main-content">

    <?php echo $__env->make('admin.partials.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="admin-content">
        <?php echo $__env->yieldContent('content'); ?>
    </div>

    <?php echo $__env->make('admin.partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="<?php echo e(asset('assets/front/js/jquery-ui.js')); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-bs5.min.js"></script>
<script src="<?php echo e(asset('assets/front/js/toastr.min.js')); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>

<script>
$(document).ready(function() {
    toastr.options = { positionClass: 'toast-top-right', timeOut: 3000, progressBar: true };
    <?php if(session('success')): ?> toastr.success("<?php echo e(session('success')); ?>"); <?php endif; ?>
    <?php if(session('error')): ?> toastr.error("<?php echo e(session('error')); ?>"); <?php endif; ?>
    <?php if(session('warning')): ?> toastr.warning("<?php echo e(session('warning')); ?>"); <?php endif; ?>
    <?php if(session('info')): ?> toastr.info("<?php echo e(session('info')); ?>"); <?php endif; ?>

    // Bootstrap tooltips for action buttons
    var tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltipTriggerList.forEach(function(el) {
        new bootstrap.Tooltip(el);
    });
    // For elements with title that can't have data-bs-toggle="tooltip" (e.g. modal triggers)
    document.querySelectorAll('.action-btn[title]:not([data-bs-toggle="tooltip"])').forEach(function(el) {
        new bootstrap.Tooltip(el);
    });

    // FIX: Dismiss tooltip on right-click (contextmenu) before browser menu opens
    document.addEventListener('contextmenu', function(e) {
        var trigger = e.target.closest('[data-bs-toggle="tooltip"], .action-btn[title]');
        if (trigger) {
            var tooltipInstance = bootstrap.Tooltip.getInstance(trigger);
            if (tooltipInstance) tooltipInstance.hide();
        }
    });

    // FIX: Dismiss ALL stuck tooltips on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.tooltip.show').forEach(function(tooltipEl) {
                tooltipEl.classList.remove('show');
                tooltipEl.style.display = '';
            });
        }
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var sidebar = document.querySelector('.admin-sidebar');
    var toggle = document.getElementById('sidebarToggle');
    var overlay = document.querySelector('.admin-sidebar-overlay');
    var closeBtn = document.getElementById('sidebarCloseBtn');

    function closeSidebar() {
        sidebar.classList.remove('open');
        document.body.classList.remove('sidebar-open');
    }

    if (toggle) {
        toggle.addEventListener('click', function() {
            sidebar.classList.toggle('open');
            document.body.classList.toggle('sidebar-open');
        });
    }

    if (closeBtn) {
        closeBtn.addEventListener('click', closeSidebar);
    }

    if (overlay) {
        overlay.addEventListener('click', closeSidebar);
    }

    document.addEventListener('click', function(e) {
        if (window.innerWidth < 768 && sidebar.classList.contains('open') && !sidebar.contains(e.target) && e.target !== toggle && !toggle.contains(e.target)) {
            closeSidebar();
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && sidebar.classList.contains('open')) {
            closeSidebar();
        }
    });
});
</script>

<script>
$(document).ready(function() {
    $('textarea.texteditor, textarea#editor').summernote({
        placeholder: 'WYSIWYG rich text editor',
        tabsize: 2,
        height: 250
    });
});
</script>

<script>
document.addEventListener('error', function(e) {
    var img = e.target;
    if (img.tagName !== 'IMG') return;
    if (img.hasAttribute('data-fallback')) return;
    img.setAttribute('data-fallback', '1');
    img.src = '<?php echo e(asset("assets/images/placeholder.png")); ?>';
}, true);
</script>
<script>
var closeFormSelects = function() {
    document.querySelectorAll('.form-select-wrapper.focused').forEach(function(w) {
        w.classList.remove('focused');
    });
};

document.querySelectorAll('.form-select').forEach(function(el) {
    var wrapper = document.createElement('span');
    wrapper.className = 'form-select-wrapper';
    el.parentNode.insertBefore(wrapper, el);
    wrapper.appendChild(el);

    el.addEventListener('mousedown', function() {
        wrapper.classList.toggle('focused');
    });
    el.addEventListener('blur', function() {
        wrapper.classList.remove('focused');
    });
    el.addEventListener('change', function() {
        wrapper.classList.remove('focused');
    });
    el.addEventListener('keydown', function(e) {
        if (e.key === ' ' || e.key === 'Enter') {
            wrapper.classList.toggle('focused');
        }
    });
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeFormSelects();
}, true);
document.addEventListener('keyup', function(e) {
    if (e.key === 'Escape') closeFormSelects();
}, true);

document.addEventListener('scroll', function() {
    closeFormSelects();
}, true);

document.addEventListener('click', function(e) {
    if (!e.target.closest('.form-select-wrapper')) {
        closeFormSelects();
    }
});
</script>
<?php echo $__env->yieldPushContent('page-builder-js'); ?>
<?php echo $__env->yieldPushContent('scripts'); ?>

</body>
</html><?php /**PATH /var/www/html/stautoparts/resources/views/admin/layouts/app.blade.php ENDPATH**/ ?>