<!DOCTYPE html>
<html>
<head>
    <title>@yield('page-title', 'Dashboard') - Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/front/css/backend.css') }}?v={{ filemtime(public_path('assets/front/css/backend.css')) }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/nice-select.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-bs5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/front/css/toastr.min.css') }}">

    {{-- Admin-wide layout styles (.admin-sidebar, .main-content, .admin-navbar,
         .admin-content, media queries) live in backend.css --}}
    @stack('page-builder-css')
</head>

<body id="@yield('page-id', 'default-page-id')" class="@yield('page-class', 'default-body-class')">

@include('admin.partials.sidebar')
<div class="admin-sidebar-overlay"></div>

<div class="main-content">

    @include('admin.partials.navbar')

    <div class="admin-content">
        @yield('content')
    </div>

    @include('admin.partials.footer')

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('assets/front/js/jquery-ui.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-bs5.min.js"></script>
<script src="{{ asset('assets/front/js/toastr.min.js') }}"></script>
<script src="{{ asset('assets/front/js/nice-select.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>

<script>
$(document).ready(function() {
    toastr.options = { positionClass: 'toast-top-right', timeOut: 3000, progressBar: true };
    @if(session('success')) toastr.success("{{ session('success') }}"); @endif
    @if(session('error')) toastr.error("{{ session('error') }}"); @endif
    @if(session('warning')) toastr.warning("{{ session('warning') }}"); @endif
    @if(session('info')) toastr.info("{{ session('info') }}"); @endif

    // Bootstrap tooltips for action buttons
    var tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltipTriggerList.forEach(function(el) {
        new bootstrap.Tooltip(el, { trigger: 'hover' });
    });
    // For elements with title that can't have data-bs-toggle="tooltip" (e.g. modal triggers)
    document.querySelectorAll('.action-btn[title]:not([data-bs-toggle="tooltip"])').forEach(function(el) {
        new bootstrap.Tooltip(el, { trigger: 'hover' });
    });

    // FIX: Hide any stuck tooltip on scroll (toggle buttons keep focus otherwise)
    document.addEventListener('scroll', function() {
        document.querySelectorAll('.tooltip.show').forEach(function(el) {
            el.classList.remove('show');
            el.style.pointerEvents = 'none';
        });
    }, true);

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
    img.src = '{{ asset("assets/images/placeholder.png") }}';
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
@stack('page-builder-js')
@stack('scripts')

</body>
</html>