<?php $__env->startSection('page-id', 'admin-settings-header-page'); ?>
<?php $__env->startSection('page-class', 'admin-settings-header-page'); ?>
<?php $__env->startSection('page-title', 'Header Settings'); ?>
<?php $__env->startSection('content'); ?>
<div class="container-fluid admin-settings-header">
    <!-- <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Header Settings</h2>
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-secondary">Back to Dashboard</a>
            </div>

        </div>
    </div> -->

    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Header Configuration</h5>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('admin.settings.header.update')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label"><strong>Header Logo</strong></label>
                                    <div class="mb-2">
                                        <img src="<?php echo e(asset('assets/images/' . ($settings['header_logo'] ?? 'BwSkuSZ7ZYGWPc4Zk3CfeFzcn49dHpx3143n4WKS.png'))); ?>"
                                             alt="Header Logo" style="max-height:60px;border-radius:4px;border:1px solid #ddd;">
                                    </div>
                                    <input type="hidden" name="image_from_manager_header_logo" id="image_from_manager_header_logo">
                                    <div id="impPreview_header_logo" class="d-none mt-2"></div>
                                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="impOpen_header_logo()">
                                        <i class="fas fa-images me-1"></i> Browse Image Manager
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label"><strong>Favicon</strong></label>
                                    <div class="mb-2">
                                        <img src="<?php echo e(asset('assets/images/' . ($settings['header_favicon'] ?? '1730880696Fabpng.png'))); ?>"
                                             alt="Favicon" style="max-height:40px;border-radius:4px;border:1px solid #ddd;">
                                    </div>
                                    <input type="hidden" name="image_from_manager_header_favicon" id="image_from_manager_header_favicon">
                                    <div id="impPreview_header_favicon" class="d-none mt-2"></div>
                                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="impOpen_header_favicon()">
                                        <i class="fas fa-images me-1"></i> Browse Image Manager
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label"><strong>Mobile Menu Logo</strong></label>
                                    <div class="mb-2">
                                        <img src="<?php echo e(asset('assets/images/' . ($settings['mobile_logo'] ?? '1730281141Whitepng.png'))); ?>"
                                             alt="Mobile Logo" style="max-height:50px;border-radius:4px;border:1px solid #ddd;">
                                    </div>
                                    <input type="hidden" name="image_from_manager_mobile_logo" id="image_from_manager_mobile_logo">
                                    <div id="impPreview_mobile_logo" class="d-none mt-2"></div>
                                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="impOpen_mobile_logo()">
                                        <i class="fas fa-images me-1"></i> Browse Image Manager
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label"><strong>Footer Logo</strong></label>
                                    <div class="mb-2">
                                        <img src="<?php echo e(asset('assets/images/' . ($settings['footer_logo'] ?? '1730281141Whitepng.png'))); ?>"
                                             alt="Footer Logo" style="max-height:50px;border-radius:4px;border:1px solid #ddd;">
                                    </div>
                                    <input type="hidden" name="image_from_manager_footer_logo" id="image_from_manager_footer_logo">
                                    <div id="impPreview_footer_logo" class="d-none mt-2"></div>
                                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="impOpen_footer_logo()">
                                        <i class="fas fa-images me-1"></i> Browse Image Manager
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label"><strong>Phone Number</strong></label>
                                    <input type="text" name="header_phone" class="form-control"
                                           value="<?php echo e($settings['header_phone'] ?? '+1 (234) 567-8901'); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label"><strong>Support Text</strong></label>
                                    <input type="text" name="header_support_text" class="form-control"
                                           value="<?php echo e($settings['header_support_text'] ?? 'Contact & Support: 00 000 000 000'); ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label"><strong>Email Address</strong></label>
                                    <input type="email" name="header_email" class="form-control"
                                           value="<?php echo e($settings['header_email'] ?? 'admin@geniusocean.com'); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label"><strong>Address</strong></label>
                                    <input type="text" name="header_address" class="form-control"
                                           value="<?php echo e($settings['header_address'] ?? '3584 Hickory Heights Drive , USA'); ?>">
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label"><strong>Footer Copyright Text</strong></label>
                            <input type="text" name="footer_copyright" class="form-control"
                                   value="<?php echo e($settings['footer_copyright'] ?? 'COPYRIGHT &copy; :year. All Rights Reserved By STautoparts'); ?>">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary steve-btn">
                                <i class="fas fa-save"></i> Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Navigation Menu</h5>
                    <button class="btn btn-sm btn-light steve-btn" type="button" data-bs-toggle="collapse" data-bs-target="#navMenuEditor">
                        Toggle Editor
                    </button>
                </div>
                <div class="collapse show" id="navMenuEditor">
                    <div class="card-body">
                        <form action="<?php echo e(route('admin.settings.header.update')); ?>" method="POST" id="navMenuForm">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="nav_menu" id="navMenuInput" value="<?php echo e($settings['nav_menu'] ?? '[]'); ?>">

                            <p class="text-muted">Add and manage your navigation menu items below.</p>

                            <div id="menuItemsContainer">
                            </div>

                            <button type="button" class="btn btn-success btn-sm mb-3 steve-btn" id="addMenuItem">
                                <i class="fas fa-plus"></i> Add Menu Item
                            </button>

                            <hr>
                            <button type="submit" class="btn btn-primary steve-btn"><i class="fas fa-save"></i> Save Menu</button>
                        </form>
                    </div>
                </div>

                <?php $__env->startPush('scripts'); ?>
                <script>
                    var menuData = <?php echo $settings['nav_menu'] ?? '[]'; ?>;
                    var categoriesData = <?php echo $categories->toJson(); ?>;

                    function buildParentCatOptions(selectedUrl) {
                        var opts = '<option value="">-- Select Category --</option>';
                        for (var c = 0; c < categoriesData.length; c++) {
                            var cat = categoriesData[c];
                            var url = '/category/' + cat.slug;
                            var hasChildren = cat.children && cat.children.length > 0;
                            var sel = '';
                            if (selectedUrl) {
                                if (!hasChildren && selectedUrl === url) sel = ' selected';
                                else if (hasChildren) {
                                    for (var ch = 0; ch < cat.children.length; ch++) {
                                        if (selectedUrl === '/category/' + cat.children[ch].slug) { sel = ' selected'; break; }
                                    }
                                }
                            }
                            opts += '<option value="' + c + '" data-url="' + url + '" data-label="' + cat.name + '" data-has-children="' + (hasChildren ? '1' : '0') + '"' + sel + '>' + cat.name + (hasChildren ? ' ▸' : '') + '</option>';
                        }
                        return opts;
                    }

                    function buildChildCatOptions(parentIndex, selectedUrl) {
                        var parent = categoriesData[parentIndex];
                        if (!parent || !parent.children || parent.children.length === 0) return '';
                        var opts = '<option value="">-- Select Sub Category --</option>';
                        for (var ch = 0; ch < parent.children.length; ch++) {
                            var child = parent.children[ch];
                            var url = '/category/' + child.slug;
                            var sel = (selectedUrl && selectedUrl === url) ? ' selected' : '';
                            opts += '<option value="' + ch + '" data-url="' + url + '" data-label="' + child.name + '"' + sel + '>' + child.name + '</option>';
                        }
                        return opts;
                    }

                    function initCategoryDropdowns($card, col) {
                        var colUrl = (col && col.url) || '';
                        var $parent = $card.find('.column-category-parent');
                        var $childWrap = $card.find('.column-child-wrap');
                        var $child = $card.find('.column-category-child');

                        $parent.html(buildParentCatOptions(colUrl));

                        var matchedParentIndex = null;
                        for (var c = 0; c < categoriesData.length; c++) {
                            var cat = categoriesData[c];
                            if (cat.children) {
                                for (var ch = 0; ch < cat.children.length; ch++) {
                                    if (colUrl === '/category/' + cat.children[ch].slug) {
                                        matchedParentIndex = c;
                                        break;
                                    }
                                }
                            }
                            if (matchedParentIndex !== null) break;
                        }

                        if (matchedParentIndex !== null) {
                            $parent.val(matchedParentIndex);
                            $child.html(buildChildCatOptions(matchedParentIndex, colUrl));
                            $childWrap.show();
                        } else {
                            $childWrap.hide();
                        }
                    }

                    function createChildHtml(child, index, parentIndex, grandparentIndex) {
                        var prefix = grandparentIndex !== undefined
                            ? 'items[' + grandparentIndex + '][children][' + parentIndex + '][children]'
                            : 'items[' + parentIndex + '][children]';
                        var childIndex = index;
                        return '<div class="card mb-1 bg-light child-card border-0 shadow-sm" data-index="' + childIndex + '">' +
                            '<div class="card-body py-1 px-2">' +
                            '<div class="d-flex align-items-center gap-2 flex-wrap">' +
                            '<input type="text" class="form-control form-control-sm child-label" placeholder="Label" value="' + (child.label || '') + '" style="max-width:200px;">' +
                            '<input type="text" class="form-control form-control-sm child-url" placeholder="URL" value="' + (child.url || '') + '" style="max-width:250px;">' +
                            '<button type="button" class="action-btn btn-cancel ms-auto remove-child" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Remove"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>' +
                            '</div></div></div>';
                    }

                    function renderItem(item, index, container) {
                        var children = item.children || [];

                        var hasContent = children.length > 0;
                        var html = '<div class="card mb-2 menu-item-card border-0 shadow-sm" data-index="' + index + '">' +
                            '<div class="card-body py-2 px-3">' +
                            '<div class="d-flex align-items-center gap-2">' +
                            '<span class="drag-handle text-muted" style="cursor:grab"><i class="fas fa-grip-vertical"></i></span>' +
                            '<span class="menu-item-toggle" style="cursor:pointer;width:20px;text-align:center;color:#888;transition:transform 0.3s;' + (hasContent ? '' : 'opacity:0.3;pointer-events:none;') + '"><i class="fas fa-chevron-down"></i></span>' +
                            '<input type="text" class="form-control form-control-sm menu-label" placeholder="Label" value="' + (item.label || '') + '" style="max-width:200px;">' +
                            '<input type="text" class="form-control form-control-sm menu-url" placeholder="URL (e.g. /shop)" value="' + (item.url || '') + '" style="max-width:250px;">' +
                            '<button type="button" class="action-btn btn-cancel ms-auto remove-item" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Remove"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg></button>' +
                            '</div>' +
                            '<div class="children-container ps-4" data-parent="' + index + '" style="' + (hasContent ? '' : 'display:none;') + '">';

                        if (children.length > 0) {
                            var isMegaFormat = children[0] && children[0].children;
                            if (isMegaFormat) {
                                for (var ci = 0; ci < children.length; ci++) {
                                    var col = children[ci];
                                    var subChildren = col.children || [];
                                    html += '<div class="card mb-1 bg-light child-card border-0 shadow-sm" data-child-index="' + ci + '" data-parent="' + index + '">' +
                                        '<div class="card-body py-1 px-2">' +
                                        '<div class="d-flex align-items-center gap-2 mb-1 flex-wrap">' +
                                        '<select class="form-select column-category-parent" style="max-width:170px;font-size:0.8rem;"></select>' +
                                        '<span class="column-child-wrap" style="display:none;"><select class="form-select column-category-child" style="max-width:170px;font-size:0.8rem;"></select></span>' +
                                        '<input type="text" class="form-control form-control-sm child-label" placeholder="Column Label" value="' + (col.label || '') + '" style="max-width:130px;">' +
                                        '<input type="text" class="form-control form-control-sm child-url" placeholder="URL" value="' + (col.url || '') + '" style="max-width:130px;">' +
                                        '<button type="button" class="action-btn btn-cancel remove-child-card" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Remove Column"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>' +
                                        '</div>' +
                                        '<div class="subchildren-container ps-3">';

                                    if (subChildren.length > 0) {
                                        for (var si = 0; si < subChildren.length; si++) {
                                            html += createChildHtml(subChildren[si], si, ci, index);
                                        }
                                    }

                                    html += '</div>' +
                                        '<button type="button" class="btn btn-outline-primary btn-sm mt-1 add-subchild steve-btn" data-parent="' + index + '" data-child="' + ci + '"><i class="fas fa-plus"></i> Add Sub Item</button>' +
                                        '</div></div>';
                                }
                            } else {
                                html += '<div class="card mb-1 bg-light child-card border-0 shadow-sm" data-child-index="0" data-parent="' + index + '">' +
                                    '<div class="card-body py-1 px-2">' +
                                    '<div class="d-flex align-items-center gap-2 mb-1 flex-wrap">' +
                                    '<select class="form-select column-category-parent" style="max-width:170px;font-size:0.8rem;"></select>' +
                                    '<span class="column-child-wrap" style="display:none;"><select class="form-select column-category-child" style="max-width:170px;font-size:0.8rem;"></select></span>' +
                                    '<input type="text" class="form-control form-control-sm child-label" placeholder="Column Label" value="' + (item.label || '') + '" style="max-width:130px;">' +
                                    '<input type="text" class="form-control form-control-sm child-url" placeholder="URL" value="' + (item.url || '') + '" style="max-width:130px;">' +
                                    '<button type="button" class="action-btn btn-cancel remove-child-card" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Remove Column"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>' +
                                    '</div>' +
                                    '<div class="subchildren-container ps-3">';
                                for (var fi = 0; fi < children.length; fi++) {
                                    html += createChildHtml(children[fi], fi, 0, index);
                                }
                                html += '</div>' +
                                    '<button type="button" class="btn btn-outline-primary btn-sm mt-1 add-subchild steve-btn" data-parent="' + index + '" data-child="0"><i class="fas fa-plus"></i> Add Sub Item</button>' +
                                    '</div></div>';
                            }
                        }

                        html += '</div>' +
                            '<button type="button" class="btn btn-outline-primary btn-sm mt-1 add-child steve-btn" data-parent="' + index + '">' +
                            '<i class="fas fa-plus"></i> Add Column' +
                            '</button>' +
                            '</div></div>';

                        if (container) {
                            container.append(html);
                            container.find('[data-bs-toggle="tooltip"]').tooltip();
                        }
                        return html;
                    }

                    function rebuildJson() {
                        var items = [];
                        $('#menuItemsContainer').children('.menu-item-card').each(function() {
                            var $card = $(this);
                            var item = {
                                label: $card.find('.menu-label').val().trim(),
                                url: $card.find('.menu-url').val().trim(),
                                megamenu: true
                            };
                            var children = [];
                            var $container = $card.find('.children-container');

                            $container.find('> .child-card').each(function() {
                                var $col = $(this);
                                var colItem = {
                                    label: $col.find('> .card-body > .d-flex > .child-label').val().trim(),
                                    url: $col.find('> .card-body > .d-flex > .child-url').val().trim(),
                                };
                                var subChildren = [];
                                $col.find('.subchildren-container .child-card').each(function() {
                                    var $sub = $(this);
                                    subChildren.push({
                                        label: $sub.find('.child-label').val().trim(),
                                        url: $sub.find('.child-url').val().trim()
                                    });
                                });
                                if (subChildren.length > 0) {
                                    colItem.children = subChildren;
                                }
                                children.push(colItem);
                            });

                            if (children.length > 0) {
                                item.children = children;
                            }
                            items.push(item);
                        });
                        $('#navMenuInput').val(JSON.stringify(items));
                    }

                    function addEmptyItem() {
                        var index = $('#menuItemsContainer').children('.menu-item-card').length;
                        renderItem({label: '', url: '', children: []}, index, $('#menuItemsContainer'));
                    }

                    $(document).ready(function() {
                        if (menuData && menuData.length > 0) {
                            for (var i = 0; i < menuData.length; i++) {
                                renderItem(menuData[i], i, $('#menuItemsContainer'));
                            }
                        }

                        if ($.fn && $.fn.sortable) {
                            $('#menuItemsContainer').sortable({
                                handle: '.drag-handle',
                                placeholder: 'card mb-2 border border-primary bg-light',
                                update: function() {
                                    $('#menuItemsContainer').children('.menu-item-card').each(function(i) {
                                        $(this).attr('data-index', i);
                                    });
                                }
                            });
                        }

                        $('#addMenuItem').on('click', function() {
                            addEmptyItem();
                        });

                        $(document).on('click', '.remove-item', function() {
                            $(this).closest('.menu-item-card').remove();
                            $('#menuItemsContainer').children('.menu-item-card').each(function(i) {
                                $(this).attr('data-index', i);
                            });
                        });

                        $(document).on('click', '.add-child', function() {
                            var $container = $(this).siblings('.children-container');
                            var parent = $container.data('parent');
                            var count = $container.children('.child-card').length;
                            var html = '<div class="card mb-1 bg-light child-card border-0 shadow-sm" data-child-index="' + count + '" data-parent="' + parent + '">' +
                                '<div class="card-body py-1 px-2">' +
                                '<div class="d-flex align-items-center gap-2 mb-1 flex-wrap">' +
                                '<select class="form-select column-category-parent" style="max-width:170px;font-size:0.8rem;"></select>' +
                                '<span class="column-child-wrap" style="display:none;"><select class="form-select column-category-child" style="max-width:170px;font-size:0.8rem;"></select></span>' +
                                '<input type="text" class="form-control form-control-sm child-label" placeholder="Column Label" value="" style="max-width:130px;">' +
                                '<input type="text" class="form-control form-control-sm child-url" placeholder="URL" value="" style="max-width:130px;">' +
                                '<button type="button" class="action-btn btn-cancel remove-child-card" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Remove Column"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>' +
                                '</div>' +
                                '<div class="subchildren-container ps-3"></div>' +
                                '<button type="button" class="btn btn-outline-primary btn-sm mt-1 add-subchild steve-btn" data-parent="' + parent + '" data-child="' + count + '"><i class="fas fa-plus"></i> Add Sub Item</button>' +
                                '</div></div>';
                            $container.append(html);
                            $container.find('[data-bs-toggle="tooltip"]').tooltip();
                            initCategoryDropdowns($container.find('.child-card').last(), { url: '' });
                            if (!$container.is(':visible')) {
                                $container.slideDown(200);
                            }
                            var $toggle = $(this).closest('.menu-item-card').find('.menu-item-toggle');
                            $toggle.css('opacity', '1').css('pointer-events', 'auto').find('i').css('transform', 'rotate(0deg)');
                        });

                        $(document).on('click', '.remove-child, .remove-child-card', function() {
                            $(this).closest('.child-card').remove();
                        });

                        $(document).on('click', '.menu-item-toggle', function() {
                            var $card = $(this).closest('.menu-item-card');
                            var $container = $card.find('.children-container');
                            $container.slideToggle(200);
                            $(this).find('i').css('transform', $container.is(':visible') ? 'rotate(0deg)' : 'rotate(-90deg)');
                        });

                        $(document).on('click', '.add-subchild', function() {
                            var $container = $(this).siblings('.subchildren-container');
                            var count = $container.children('.child-card').length;
                            var html = '<div class="card mb-1 bg-light child-card border-0 shadow-sm" data-index="' + count + '">' +
                                '<div class="card-body py-1 px-2">' +
                                '<div class="d-flex align-items-center gap-2 flex-wrap">' +
                                '<input type="text" class="form-control form-control-sm child-label" placeholder="Label" value="" style="max-width:200px;">' +
                                '<input type="text" class="form-control form-control-sm child-url" placeholder="URL" value="" style="max-width:250px;">' +
                                '<button type="button" class="action-btn btn-cancel remove-child" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Remove"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>' +
                                '</div></div></div>';
                            $container.append(html);
                            $container.find('[data-bs-toggle="tooltip"]').tooltip();
                        });

                        $(document).on('change', '.column-category-parent', function() {
                            var $card = $(this).closest('.child-card');
                            var $childWrap = $card.find('.column-child-wrap');
                            var $child = $card.find('.column-category-child');
                            var $opt = $(this).find(':selected');
                            var hasChildren = $opt.data('has-children') == '1';
                            var parentIndex = $(this).val();

                            if (hasChildren) {
                                $child.html(buildChildCatOptions(parentIndex, ''));
                                $childWrap.show();

                                var parent = categoriesData[parentIndex];
                                var $subContainer = $card.find('.subchildren-container');
                                var $row = $(this).closest('.d-flex');
                                $row.find('.child-label').val(parent.name);
                                $row.find('.child-url').val('/category/' + parent.slug);
                                if ($subContainer.children('.child-card').length === 0 && parent.children.length > 0) {
                                    for (var ch = 0; ch < parent.children.length; ch++) {
                                        var sub = parent.children[ch];
                                        var subHtml = '<div class="card mb-1 bg-light child-card border-0 shadow-sm" data-index="' + ch + '">' +
                                            '<div class="card-body py-1 px-2">' +
                                            '<div class="d-flex align-items-center gap-2 flex-wrap">' +
                                            '<input type="text" class="form-control form-control-sm child-label" placeholder="Label" value="' + sub.name + '" style="max-width:200px;">' +
                                            '<input type="text" class="form-control form-control-sm child-url" placeholder="URL" value="/category/' + sub.slug + '" style="max-width:250px;">' +
                                            '<button type="button" class="action-btn btn-cancel remove-child" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Remove"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>' +
                                            '</div></div></div>';
                                        $subContainer.append(subHtml);
                                        $subContainer.find('[data-bs-toggle="tooltip"]').tooltip();
                                    }
                                }
                            } else {
                                $childWrap.hide();
                                $child.html('');
                                var $row = $(this).closest('.d-flex');
                                $row.find('.child-label').val($opt.data('label') || '');
                                $row.find('.child-url').val($opt.data('url') || '');
                            }
                        });

                        $(document).on('change', '.column-category-child', function() {
                            var $opt = $(this).find(':selected');
                            var $row = $(this).closest('.d-flex');
                            $row.find('.child-label').val($opt.data('label') || '');
                            $row.find('.child-url').val($opt.data('url') || '');
                        });

                        // Init existing mega menu category dropdowns on load
                        $('.child-card').each(function() {
                            var $card = $(this);
                            var url = $card.find('.child-url').val() || '';
                            initCategoryDropdowns($card, { url: url });
                        });

                        $('#navMenuForm').on('submit', function(e) {
                            rebuildJson();
                        });
                    });
                </script>
                <?php $__env->stopPush(); ?>
            </div>
        </div>
    </div>
</div>

<?php echo $__env->make('admin.partials.image-manager-picker', ['pickerId' => 'header_logo', 'targetInput' => 'image_from_manager_header_logo'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('admin.partials.image-manager-picker', ['pickerId' => 'header_favicon', 'targetInput' => 'image_from_manager_header_favicon'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('admin.partials.image-manager-picker', ['pickerId' => 'mobile_logo', 'targetInput' => 'image_from_manager_mobile_logo'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('admin.partials.image-manager-picker', ['pickerId' => 'footer_logo', 'targetInput' => 'image_from_manager_footer_logo'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/stautoparts/resources/views/admin/settings/header.blade.php ENDPATH**/ ?>