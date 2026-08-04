<?php
    $currentUrl = url()->current();
    $basePath = rtrim(parse_url(url('/'), PHP_URL_PATH) ?? '', '/');
    $currentPath = parse_url($currentUrl, PHP_URL_PATH) ?? '/';
    $relativePath = $basePath !== '' && str_starts_with($currentPath, $basePath) ? substr($currentPath, strlen($basePath)) : $currentPath;
    $menu = $menu ?? [];
    $megaCategories = $megaCategories ?? collect();
    $activeCategoryUrls = $activeCategoryUrls ?? [];
    $routeAliases = [
        '/product' => ['/shop'],
        '/category' => ['/shop'],
    ];
    $aliasedMenuUrl = '';
    foreach ($routeAliases as $prefix => $targets) {
        if (str_starts_with($relativePath, $prefix . '/') || $relativePath === $prefix) {
            foreach ($targets as $target) {
                $aliasedMenuUrl = url($target);
                break;
            }
            break;
        }
    }
?>
<?php $__currentLoopData = $menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php
        $label = $item['label'] ?? '';
        $url = $item['url'] ?? '#';
        $children = $item['children'] ?? [];
        $hasChildren = !empty($children);
        $menuUrl = $url === '#' ? '' : url($url);
        $isActive = $menuUrl && ($currentUrl === $menuUrl || $currentUrl === $menuUrl . '/');
        if (!$isActive && $menuUrl && $url !== '/' && $url !== '') {
            $isActive = str_starts_with($currentUrl, $menuUrl . '/') || str_starts_with($currentUrl, $menuUrl . '?');
        }
        if (!$isActive && $menuUrl && $aliasedMenuUrl && $menuUrl === $aliasedMenuUrl) {
            $isActive = true;
        }
        if (!$isActive && $menuUrl && !empty($activeCategoryUrls) && in_array($menuUrl, $activeCategoryUrls)) {
            $isActive = true;
        }
        if (!$isActive && $hasChildren) {
            foreach ($children as $child) {
                $childUrl = $child['url'] ?? '';
                if ($childUrl === '' || $childUrl === '#') continue;
                $childFullUrl = url($childUrl);
                if ($childUrl !== '/' && ($currentUrl === $childFullUrl || str_starts_with($currentUrl, $childFullUrl . '/') || str_starts_with($currentUrl, $childFullUrl . '?'))) {
                    $isActive = true;
                    break;
                }
                if (!$isActive && !empty($activeCategoryUrls) && in_array($childFullUrl, $activeCategoryUrls)) {
                    $isActive = true;
                    break;
                }
                if (!$isActive && $aliasedMenuUrl && $childFullUrl === $aliasedMenuUrl) {
                    $isActive = true;
                    break;
                }
                if (!empty($child['children'])) {
                    foreach ($child['children'] as $subChild) {
                        $subUrl = $subChild['url'] ?? '';
                        if ($subUrl === '' || $subUrl === '#') continue;
                        $subFullUrl = url($subUrl);
                        if ($subUrl !== '/' && ($currentUrl === $subFullUrl || str_starts_with($currentUrl, $subFullUrl . '/') || str_starts_with($currentUrl, $subFullUrl . '?'))) {
                            $isActive = true;
                            break 2;
                        }
                        if (!$isActive && !empty($activeCategoryUrls) && in_array($subFullUrl, $activeCategoryUrls)) {
                            $isActive = true;
                            break 2;
                        }
                    }
                }
            }
        }
        $liClass = $hasChildren ? 'has-megamenu' : '';
        if ($isActive) $liClass .= ' active';
        $isMegaFormat = $hasChildren && isset($children[0]['children']);
    ?>

    <li class="<?php echo e($liClass); ?>">
        <div class="menu-item-with-icon">
        <a href="<?php echo e($url === '#' ? 'javascript:void(0)' : url($url)); ?>" class="nav-link<?php echo e($isActive ? ' active' : ''); ?>"><?php echo e($label); ?></a>
        <?php if($hasChildren): ?>
            <span class="has-submenu-icon">
                <i class="fas fa-chevron-down"></i>
            </span></div>
            <div class="megamenu cat-megamenu">
                <div class="row w-100">
                    <?php if($isMegaFormat): ?>
                        <?php $__currentLoopData = $children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $colFullUrl = url($col['url'] ?? '#');
                                $colIsActive = !empty($activeCategoryUrls) && in_array($colFullUrl, $activeCategoryUrls);
                            ?>
                            <div class="col-lg-4">
                                <div class="single-menu mt-30">
                                    <h5><a href="<?php echo e($colFullUrl); ?>" class="<?php echo e($colIsActive ? 'active' : ''); ?>"><?php echo e($col['label'] ?? ''); ?></a></h5>
                                    <?php if(!empty($col['children'])): ?>
                                        <ul>
                                            <?php $__currentLoopData = $col['children']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    $childFullUrl = url($child['url'] ?? '#');
                                                    $childIsActive = !empty($activeCategoryUrls) && in_array($childFullUrl, $activeCategoryUrls);
                                                ?>
                                                <li><a href="<?php echo e($childFullUrl); ?>" class="<?php echo e($childIsActive ? 'active' : ''); ?>"><?php echo e($child['label'] ?? ''); ?></a></li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <div class="col-lg-4">
                            <div class="single-menu mt-30">
                                <ul>
                                    <?php $__currentLoopData = $children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $childFullUrl = url($child['url'] ?? '#');
                                            $childIsActive = !empty($activeCategoryUrls) && in_array($childFullUrl, $activeCategoryUrls);
                                        ?>
                                        <li><a href="<?php echo e($childFullUrl); ?>" class="<?php echo e($childIsActive ? 'active' : ''); ?>"><?php echo e($child['label'] ?? ''); ?></a></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php else: ?>
            </div>
        <?php endif; ?>
    </li>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /var/www/html/stautoparts/resources/views/partials/nav-menu.blade.php ENDPATH**/ ?>