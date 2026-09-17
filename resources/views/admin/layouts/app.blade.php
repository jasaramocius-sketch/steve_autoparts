<!DOCTYPE html>
<html>
<head>
    @hasSection('meta_tags')
    @yield('meta_tags')
    @else
    <title>@yield('page-title', 'Dashboard') - Admin Panel</title>
    @endif
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/front/css/backend.css') }}?v={{ filemtime(public_path('assets/front/css/backend.css')) }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/nice-select.css') }}">
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="stylesheet" href="{{ asset('assets/front/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/style.css') }}?v={{ filemtime(public_path('assets/front/css/style.css')) }}">

    <style>
        .admin-editor-tabs {
            align-items: flex-end;
            border-bottom: 1px solid #dfe3ea;
            display: flex;
            gap: 2px;
            margin-bottom: -1px;
            position: relative;
            z-index: 2;
        }
        .admin-editor-tab {
            background: transparent;
            border: 1px solid transparent;
            border-bottom: 0;
            color: #687386;
            cursor: pointer;
            font-size: 13px;
            padding: 7px 12px;
            border-radius: 5px 5px 0 0;
            width:65px;
        }
        .admin-editor-tab.active {
            background: #ffffff;
            border-color: #dfe3ea;
            border-radius: 5px 5px 0 0;
            color: #1f2937;
            font-weight: 600;
        }
        .admin-rich-editor .tox-tinymce {
            border: 1px solid #dfe3ea;
            border-radius: 0 6px 6px 6px;
            min-height: 260px;
        }
        .admin-rich-editor .tox-editor-header {
            box-shadow: none;
        }
        .admin-rich-editor .tox-edit-area__iframe {
            min-height: 220px;
        }
        .tox .tox-toolbar__group{
            padding: 0px !important;
        }
        .tox .tox-toolbar-overlord .tox-toolbar{
            padding: 0 11px 0 12px;
        }
    </style>

    {{-- Admin-wide layout styles (.admin-sidebar, .main-content, .admin-navbar,
         .admin-content, media queries) live in backend.css --}}
    @stack('page-builder-css')
</head>

<body id="@yield('page-id', 'default-page-id')" class="site-root @yield('page-class', 'default-body-class')"
    data-success="{{ session('success') }}" data-error="{{ session('error') }}"
    data-warning="{{ session('warning') }}" data-info="{{ session('info') }}">

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
<script src="https://cdn.jsdelivr.net/npm/tinymce@7.9.1/tinymce.min.js"></script>
<script src="{{ asset('assets/front/js/marked.min.js') }}"></script>
<script src="{{ asset('assets/front/js/toastr.min.js') }}"></script>
<script src="{{ asset('assets/front/js/nice-select.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
<script src="{{ asset('assets/front/js/backend.js') }}?v={{ filemtime(public_path('assets/front/js/backend.js')) }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('textarea.texteditor').forEach(function(textarea, index) {
            var id = textarea.id || 'admin-editor-' + index;
            textarea.id = id;
            var wrapper = document.createElement('div');
            wrapper.className = 'admin-rich-editor';
            textarea.parentNode.insertBefore(wrapper, textarea);
            wrapper.appendChild(textarea);

            var tabs = document.createElement('div');
            tabs.className = 'admin-editor-tabs';
            tabs.setAttribute('role', 'tablist');
            tabs.innerHTML = '<button type="button" class="admin-editor-tab active" data-editor-mode="visual" role="tab">Visual</button>' +
                '<button type="button" class="admin-editor-tab" data-editor-mode="code" role="tab">Code</button>';
            wrapper.insertBefore(tabs, textarea);

            tinymce.init({
                target: textarea,
                license_key: 'gpl',
                height: 260,
                menubar: false,
                branding: false,
                promotion: false,
                toolbar_mode: 'wrap',
                statusbar: true,
                plugins: 'advlist autolink lists link image table code fullscreen help wordcount charmap textcolor',
                toolbar1: 'blocks | bold italic underline | bullist numlist | link | fullscreen | extendedtoolbar',
                toolbar2: 'strikethrough forecolor backcolor | blockquote hr | alignleft aligncenter alignright | outdent indent | undo redo removeformat | charmap help | image table code',
                toolbar: false,
                content_style: '#tinymce.mce-content-body { padding: 0 !important; } body { font-family: Arial, sans-serif; font-size: 15px; line-height: 1.65; }',
                setup: function(editor) {
                    editor.ui.registry.addButton('extendedtoolbar', {
                        icon: 'more-drawer',
                        tooltip: 'Extended toolbar',
                        onAction: function() {
                            var toolbar = editor.getContainer().querySelector('.tox-toolbar:nth-child(2)');
                            if (toolbar) toolbar.hidden = !toolbar.hidden;
                        }
                    });
                    editor.on('change keyup', function() { editor.save(); });
                    editor.on('init', function() {
                        var container = editor.getContainer();
                        var codeMode = false;
                        var toolbarRows = container.querySelectorAll('.tox-toolbar');
                        if (toolbarRows[1]) toolbarRows[1].hidden = true;
                        tabs.addEventListener('click', function(event) {
                            var tab = event.target.closest('.admin-editor-tab');
                            if (!tab) return;
                            codeMode = tab.dataset.editorMode === 'code';
                            tabs.querySelectorAll('.admin-editor-tab').forEach(function(item) {
                                item.classList.toggle('active', item === tab);
                                item.setAttribute('aria-selected', item === tab ? 'true' : 'false');
                            });
                            if (codeMode) {
                                editor.save();
                                textarea.style.display = 'block';
                                textarea.style.minHeight = '260px';
                                textarea.style.width = '100%';
                                container.style.display = 'none';
                            } else {
                                editor.setContent(textarea.value || '');
                                textarea.style.display = 'none';
                                container.style.display = '';
                            }
                        });
                    });
                }
            });
        });

        document.querySelectorAll('form').forEach(function(form) {
            form.addEventListener('submit', function() {
                if (window.tinymce) tinymce.triggerSave();
            });
        });
    });
</script>

{{-- Common admin behavior lives in backend.js. --}}
{{--
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
    document.querySelectorAll('.action-btn[title]:not([data-bs-toggle="tooltip"]), .footer-remove-btn[title]:not([data-bs-toggle="tooltip"])').forEach(function(el) {
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
--}}
@stack('page-builder-js')
@stack('scripts')

</body>
</html>