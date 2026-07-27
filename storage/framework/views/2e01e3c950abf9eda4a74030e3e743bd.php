<?php $__env->startSection('title', (isset($pageTitle) ? $pageTitle : (isset($currentChildcategory) ? $currentChildcategory->name : (isset($currentSubcategory) ? $currentSubcategory->name : (isset($currentCategory) ? $currentCategory->name : 'Shop')))) . ' - StAutoparts'); ?>

<?php $__env->startSection('content'); ?>
<style>
  .gs-product-sidebar-wrapper .price-range .ui-slider-handle {
    background-color: #ffffff !important;
    border: 2px solid var(--primary) !important;
    outline: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  }
  .gs-product-sidebar-wrapper .price-range .ui-slider-handle:hover,
  .gs-product-sidebar-wrapper .price-range .ui-slider-handle.ui-state-active {
    background-color: var(--primary) !important;
  }
  .product-nav-wrapper .btn-wrapper .view-btn {
    width: 42px;
    height: 42px;
    border: 1px solid var(--primary);
    background: #fff;
    color: var(--primary);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px; 
    padding: 9px 18px;
  }
  .product-nav-wrapper .btn-wrapper .view-btn.active {
    background: var(--primary);
    color: #fff;
  }
  .recent-post-item:hover .recent-post-content a {
    color: var(--primary) !important;
  }
  /* Accordion +/- toggle */
  .cat-toggle-btn .fa-minus { display: none; }
  .cat-toggle-btn .fa-plus { display: inline; }
  .cat-toggle-btn:not(.collapsed) .fa-minus { display: inline; }
  .cat-toggle-btn:not(.collapsed) .fa-plus { display: none; }
</style>

<!-- Banner Hero Section -->
<section class="gs-breadcrumb-section" style="background-image: url('<?php echo e(asset('assets/images/1724480495Imagexxxxxpng.png')); ?>'); background-size: cover; background-position: center;">
  <div class="container">
    <div class="content-wrapper">
      <h2 class="breadcrumb-title">
        <?php if(isset($pageTitle)): ?>
          <?php echo e($pageTitle); ?>

        <?php elseif(isset($currentChildcategory)): ?>
          <?php echo e($currentChildcategory->name); ?>

        <?php elseif(isset($currentSubcategory)): ?>
          <?php echo e($currentSubcategory->name); ?>

        <?php elseif(isset($currentCategory)): ?>
          <?php echo e($currentCategory->name); ?>

        <?php else: ?>
          Shop
        <?php endif; ?>
      </h2>
      <ul class="bread-menu">
    <li><a href="<?php echo e(route('home')); ?>">Home</a></li>
    <li><a href="<?php echo e(route('shop')); ?>">Shop</a></li>

    <?php if(isset($currentCategory)): ?>
        <?php if(isset($currentSubcategory) || isset($currentChildcategory)): ?>
            <li>
                <a href="<?php echo e(route('category', ['slug' => $currentCategory->slug])); ?>">
                    <?php echo e($currentCategory->name); ?>

                </a>
            </li>
        <?php else: ?>
            <li style="color: var(--primary);"><?php echo e($currentCategory->name); ?></li>
        <?php endif; ?>
    <?php endif; ?>

    <?php if(isset($currentSubcategory)): ?>
        <?php if(isset($currentChildcategory)): ?>
            <li>
                <a href="<?php echo e(route('subcategory', [
                    'parent' => $currentCategory->slug,
                    'child' => $currentSubcategory->slug
                ])); ?>">
                    <?php echo e($currentSubcategory->name); ?>

                </a>
            </li>
        <?php else: ?>
            <li style="color: var(--primary);"><?php echo e($currentSubcategory->name); ?></li>
        <?php endif; ?>
    <?php endif; ?>

    <?php if(isset($currentChildcategory)): ?>
        <li style="color: var(--primary);"><?php echo e($currentChildcategory->name); ?></li>
    <?php endif; ?>
</ul>
    </div>
  </div>
</section>

<!-- Product Category Listing Section -->
<section class="product-category py-120 shop-page-product-items" style="background-color: #F9F8F8;">
  <div class="container">
    <div class="row g-4">

      <!-- Sidebar -->
      <div class="col-lg-3">
        <div class="shop-sidebar-wrapper">
        <div class="btn-wrapper d-flex gap-2 sidebar-grid-list-view-wrapper d-lg-none">
          <button type="button" class="view-btn active steve-btn" data-layout="grid" title="Grid View">
            <i class="fas fa-th-large"></i>
          </button>
          <button type="button" class="view-btn steve-btn" data-layout="list" title="List View">
            <i class="fas fa-bars"></i>
          </button>
        </div>
        </div>
        <div class="shop-sidebar-overlay"></div>
        <div class="gs-product-sidebar-wrapper">
          <div class="shop-sidebar-close-div">
            <button class="shop-sidebar-close bg-transparent p-2 steve-btn justify-content-end" type="button" aria-label="Close filters">
              <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
              </svg>
              <!-- <span class="ms-1" style="font-size:14px;">Close</span> -->
            </button>
          </div>

          <!-- Categories Widget -->
          <div class="single-product-widget shadow-sm rounded border">
            <h4 class="widget-title">Categories</h4>
            <div class="product-cat-widget">
              <ul class="list-unstyled mb-0">
                <?php if(isset($currentCategory)): ?>
                <li class="mb-3 pb-2 border-bottom">
                  <a href="<?php echo e(route('shop')); ?>" class="text-decoration-none fw-600" style="color: #1f0300; font-size:15px;">
                    All Categories
                  </a>
                </li>
                <?php endif; ?>
                <?php $__currentLoopData = $categoryTree; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php
                    $isTopActive = isset($currentCategory) && $currentCategory->id === $topCat->id;
                  ?>
                  <?php if(!isset($currentCategory) || $isTopActive): ?>
                  <li class="main-list mb-3">
                    <div class="d-flex justify-content-between align-items-center gap-3">
                      <?php if($topCat->descendant_count > 0 || $isTopActive): ?>
                        <a href="<?php echo e(route('category', ['slug' => $topCat->slug])); ?>" class="text-decoration-none flex-grow-1" style="color: <?php echo e($isTopActive ? 'var(--primary)' : '#1f0300'); ?>; font-weight: <?php echo e($isTopActive ? '600' : '400'); ?>;">
                          <?php echo e($topCat->name); ?>

                          <span class="text-muted" style="font-size: 13px; font-weight: 400;">(<?php echo e($topCat->descendant_count); ?>)</span>
                        </a>
                      <?php else: ?>
                        <span class="flex-grow-1 cat-no-products">
                          <?php echo e($topCat->name); ?>

                          <span class="text-muted" style="font-size: 13px; font-weight: 400;">(0)</span>
                        </span>
                      <?php endif; ?>
                      <?php if($topCat->children->count() > 0): ?>
                        <button class="btn p-0 border-0 cat-toggle-btn <?php echo e($isTopActive ? '' : 'collapsed'); ?> steve-btn" data-bs-toggle="collapse" data-bs-target="#cat_<?php echo e($topCat->id); ?>">
                          <i class="fa-solid fa-plus" style="font-size: 11px;"></i>
                          <i class="fa-solid fa-minus" style="font-size: 11px;"></i>
                        </button>
                      <?php endif; ?>
                    </div>

                    <?php if($topCat->children->count() > 0): ?>
                      <ul id="cat_<?php echo e($topCat->id); ?>" class="collapse ms-3 mt-2 list-unstyled <?php echo e($isTopActive ? 'show' : ''); ?>">
                        <?php $__currentLoopData = $topCat->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <?php
                            $isSubActive = isset($currentSubcategory) && $currentSubcategory->id === $subCat->id;
                            $showSubChildren = $isSubActive;
                          ?>
                          <li class="mb-2">
                            <div class="d-flex justify-content-between align-items-center gap-3">
                              <?php if($subCat->descendant_count > 0 || $isSubActive): ?>
                                <a href="<?php echo e(route('subcategory', ['parent' => $topCat->slug, 'child' => $subCat->slug])); ?>" class="text-decoration-none flex-grow-1" style="color: <?php echo e($isSubActive && !isset($currentChildcategory) ? 'var(--primary)' : '#1f0300'); ?>; font-weight: <?php echo e($isSubActive ? '600' : '400'); ?>; font-size: 15px;">
                                  <?php echo e($subCat->name); ?>

                                  <span class="text-muted" style="font-size: 12px; font-weight: 400;">(<?php echo e($subCat->descendant_count); ?>)</span>
                                </a>
                              <?php else: ?>
                                <span class="flex-grow-1 cat-no-products" style="font-size: 15px;">
                                  <?php echo e($subCat->name); ?>

                                  <span class="text-muted" style="font-size: 12px; font-weight: 400;">(0)</span>
                                </span>
                              <?php endif; ?>
                              <?php if($subCat->children->count() > 0): ?>
                                <button class="btn p-0 border-0 cat-toggle-btn <?php echo e($showSubChildren ? '' : 'collapsed'); ?> steve-btn" data-bs-toggle="collapse" data-bs-target="#cat_<?php echo e($subCat->id); ?>">
                                  <i class="fa-solid fa-plus" style="font-size: 9px;"></i>
                                  <i class="fa-solid fa-minus" style="font-size: 9px;"></i>
                                </button>
                              <?php endif; ?>
                            </div>

                            <?php if($subCat->children->count() > 0): ?>
                              <ul id="cat_<?php echo e($subCat->id); ?>" class="collapse ms-3 mt-1 list-unstyled <?php echo e($showSubChildren ? 'show' : ''); ?>">
                                <?php $__currentLoopData = $subCat->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $childCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <?php
                                    $isChildActive = isset($currentChildcategory) && $currentChildcategory->id === $childCat->id;
                                  ?>
                                  <li class="my-1">
                                    <?php if($childCat->descendant_count > 0 || $isChildActive): ?>
                                      <a href="<?php echo e(route('subcategory', ['parent' => $topCat->slug, 'child' => $subCat->slug, 'subchild' => $childCat->slug])); ?>" class="text-decoration-none" style="color: <?php echo e($isChildActive ? 'var(--primary)' : '#1f0300'); ?>; font-weight: <?php echo e($isChildActive ? '600' : '400'); ?>; font-size: 14px;">
                                        <?php echo e($childCat->name); ?>

                                        <span class="text-muted" style="font-size: 12px; font-weight: 400;">(<?php echo e($childCat->descendant_count); ?>)</span>
                                      </a>
                                    <?php else: ?>
                                      <span class="cat-no-products" style="font-size: 14px;">
                                        <?php echo e($childCat->name); ?>

                                        <span class="text-muted" style="font-size: 12px; font-weight: 400;">(0)</span>
                                      </span>
                                    <?php endif; ?>
                                  </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </ul>
                            <?php endif; ?>
                          </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </ul>
                    <?php endif; ?>
                  </li>
                  <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </ul>
            </div>
          </div>

          <!-- Price Filter Widget -->
          <div class="single-product-widget shadow-sm rounded border">
            <h4 class="widget-title">Price Range</h4>
            <form id="price-filter-form" action="<?php echo e(url()->current()); ?>" method="GET">
              <?php $__currentLoopData = request()->except(['min_price', 'max_price', 'page']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(is_array($value)): ?>
                  <?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <input type="hidden" name="<?php echo e($name); ?>[]" value="<?php echo e($item); ?>">
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                  <input type="hidden" name="<?php echo e($name); ?>" value="<?php echo e($value); ?>">
                <?php endif; ?>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <div class="price-range">
                <div id="price-slider" class="mb-3" style="margin-top: 15px;"></div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <span class="text-muted" style="font-size: 14px;">Range:</span>
                  <span id="price-range-label" style="font-weight: 600; color: #1f0300;"><?php echo e(currency_format(0)); ?> - <?php echo e(currency_format(1000)); ?></span>
                </div>
                <?php
                    $rate = config('currencies.' . session('currency', 'USD') . '.rate', 1);
                ?>
                <input type="hidden" id="price-min" name="min_price" value="<?php echo e(request('min_price', 0 * $rate)); ?>">
                <input type="hidden" id="price-max" name="max_price" value="<?php echo e(request('max_price', 1000 * $rate)); ?>">
                <input type="hidden" id="price-rate" name="price_rate" value="<?php echo e($rate); ?>">
                <div class="price-range-actions apply-clear-action-btn d-flex gap-2">
                  <button type="submit" class="btn btn-sm w-100 text-white steve-btn" id="apply-price-filter">Apply Filter</button>
                  <?php if(request()->has('min_price') || request()->has('max_price')): ?>
                    <button type="button" class="btn btn-sm btn-outline-secondary w-100 steve-btn" id="clear-price-filter">Clear</button>
                  <?php endif; ?>
                </div>
              </div>
            </form>
          </div>

          <!-- Vehicle Filter Widgets (Year, Make, Model) -->
          <div class="single-product-widget shadow-sm rounded border mb-4">
            <form id="vehicle-filter-form" action="<?php echo e(url()->current()); ?>" class="d-flex flex-column gap-2" method="GET" class="vehicle-filter-form">
            <?php $__currentLoopData = request()->except(['brand', 'year', 'make', 'model', 'page']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <?php if(is_array($value)): ?>
                <?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <input type="hidden" name="<?php echo e($name); ?>[]" value="<?php echo e($item); ?>">
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php else: ?>
                <input type="hidden" name="<?php echo e($name); ?>" value="<?php echo e($value); ?>">
              <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>            
              <?php if($years->isNotEmpty()): ?>
                <span class="shop-page-widget-title">Year</span>
                <select name="year" class="form-select filter-select" id="filter-year">
                  <option value="">All Years</option>
                  <?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($year); ?>" <?php echo e(request('year') == $year ? 'selected' : ''); ?>><?php echo e($year); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php endif; ?>
                <?php if($makes->isNotEmpty()): ?>
                <span class="shop-page-widget-title">Make</span>
                <select name="make" class="form-select filter-select" id="filter-make">
                  <option value="">All Makes</option>
                  <?php $__currentLoopData = $makes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $make): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($make); ?>" <?php echo e(request('make') == $make ? 'selected' : ''); ?>><?php echo e($make); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php endif; ?>
                <?php if($models->isNotEmpty()): ?>
                <span class="shop-page-widget-title">Model</span>
                <select name="model" class="form-select filter-select" id="filter-model">
                  <option value="">All Models</option>
                  <?php $__currentLoopData = $models; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $model): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($model); ?>" <?php echo e(request('model') == $model ? 'selected' : ''); ?>><?php echo e($model); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php endif; ?>
                <div class="vehicle-filter-form-actions apply-clear-action-btn d-flex flex-row gap-2">
                <button type="submit" class="btn btn-sm w-100 text-white steve-btn">Apply Filter</button>
                <?php if(request()->hasAny(['year', 'make', 'model'])): ?>
                  <a href="<?php echo e(url()->current()); ?>" class="btn btn-outline-secondary btn-sm w-100 mt-2 steve-btn">Clear Filter</a>
                <?php endif; ?>
                </div>
              

            <!-- <?php if($makes->isNotEmpty()): ?>
              <div class="single-product-widget shadow-sm rounded border mb-4">
                <span class="shop-page-widget-title">Make</span>
                <select name="make" class="form-select filter-select" id="filter-make">
                  <option value="">All Makes</option>
                  <?php $__currentLoopData = $makes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $make): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($make); ?>" <?php echo e(request('make') == $make ? 'selected' : ''); ?>><?php echo e($make); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>
            <?php endif; ?>

            <?php if($models->isNotEmpty()): ?>
              <div class="single-product-widget shadow-sm rounded border mb-2">
                <span class="shop-page-widget-title">Model</span>
                <select name="model" class="form-select filter-select" id="filter-model">
                  <option value="">All Models</option>
                  <?php $__currentLoopData = $models; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $model): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($model); ?>" <?php echo e(request('model') == $model ? 'selected' : ''); ?>><?php echo e($model); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>
            <?php endif; ?>
            <div class="vehicle-filter-form-actions apply-clear-action-btn d-flex flex-row gap-2 mt-3">
            <button type="submit" class="btn btn-primary btn-sm w-100 mt-2 steve-btn">Apply Filters</button>
            <?php if(request()->hasAny(['year', 'make', 'model'])): ?>
              <a href="<?php echo e(url()->current()); ?>" class="btn btn-outline-secondary btn-sm w-100 mt-2 steve-btn">Clear Filters</a>
            <?php endif; ?>
            </div> -->
          </form>

          <?php if($vehicleData->isNotEmpty()): ?>
          </div>
          <script>
          (function() {
            var vehicleData = <?= json_encode($vehicleData) ?>;
            var yearEl = document.getElementById('filter-year');
            var makeEl = document.getElementById('filter-make');
            var modelEl = document.getElementById('filter-model');

            function getMakes(year) {
              if (!year) return [...new Set(vehicleData.map(function(v) { return v.make; }))];
              return [...new Set(vehicleData.filter(function(v) { return v.year == year; }).map(function(v) { return v.make; }))];
            }

            function getModels(year, make) {
              var filtered = vehicleData;
              if (year) filtered = filtered.filter(function(v) { return v.year == year; });
              if (make) filtered = filtered.filter(function(v) { return v.make == make; });
              return [...new Set(filtered.map(function(v) { return v.model; }))];
            }

            function populateSelect(el, values, selected) {
              var current = el.value;
              el.innerHTML = '<option value="">All ' + el.name.charAt(0).toUpperCase() + el.name.slice(1) + 's</option>';
              values.forEach(function(v) {
                var opt = document.createElement('option');
                opt.value = v;
                opt.textContent = v;
                if (v == selected || v == current) opt.selected = true;
                el.appendChild(opt);
              });
            }

            function cascade() {
              var selYear = yearEl ? yearEl.value : '';
              var selMake = makeEl ? makeEl.value : '';
              var selModel = modelEl ? modelEl.value : '';

              if (yearEl) {
                var makes = getMakes(selYear);
                populateSelect(makeEl, makes, selMake);
              }
              if (makeEl || yearEl) {
                var models = getModels(selYear, selMake);
                populateSelect(modelEl, models, selModel);
              }
            }

            if (yearEl) yearEl.addEventListener('change', function() {
              makeEl.value = '';
              modelEl.value = '';
              cascade();
            });
            if (makeEl) makeEl.addEventListener('change', function() {
              modelEl.value = '';
              cascade();
            });

            cascade();
          })();
          </script>
          <?php endif; ?>

        </div>        
      </div>

      <!-- Floating Filter Toggle Button (Mobile) -->
      <button class="shop-sidebar-toggle-float d-lg-none" type="button" aria-label="Toggle filters">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <line x1="4" y1="21" x2="4" y2="14"></line>
          <line x1="4" y1="10" x2="4" y2="3"></line>
          <line x1="12" y1="21" x2="12" y2="12"></line>
          <line x1="12" y1="8" x2="12" y2="3"></line>
          <line x1="20" y1="21" x2="20" y2="16"></line>
          <line x1="20" y1="12" x2="20" y2="3"></line>
          <line x1="1" y1="14" x2="7" y2="14"></line>
          <line x1="9" y1="8" x2="15" y2="8"></line>
          <line x1="17" y1="16" x2="23" y2="16"></line>
        </svg>
      </button>
      <script>
      document.addEventListener('DOMContentLoaded', function() {
        var sidebar = document.querySelector('.gs-product-sidebar-wrapper');
        var overlay = document.querySelector('.shop-sidebar-overlay');
        var toggle = document.querySelector('.shop-sidebar-toggle-float');
        var close = document.querySelector('.shop-sidebar-close');

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
          if (e.key === 'Escape' && sidebar && sidebar.classList.contains('active')) closeSidebar();
        });
      });
      </script>

      <!-- Products Grid Area -->
      <div class="col-lg-9 products-grid-area">

        <!-- Sort & Nav Header -->
        <div class="product-nav-wrapper shadow-sm rounded border mb-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
          
            <div class="d-flex align-items-center gap-3 flex-wrap filter-sort-brand-wrapper">
              <div class="d-flex align-items-center gap-2 filter-sort-wrapper">
                <h5 class="mb-0" style="font-size: 14px; font-weight: 500;">Sort by</h5>
                <select class="form-select form-select-sm" style="width:180px; border:1px solid #c7c0bf; border-radius:4px;" id="sort-select">
                  <option value="default" <?php echo e(request('sort') == 'default' ? 'selected' : ''); ?>>Newest</option>
                  <option value="oldest" <?php echo e(request('sort') == 'oldest' ? 'selected' : ''); ?>>Oldest</option>
                  <option value="price_asc" <?php echo e(request('sort') == 'price_asc' ? 'selected' : ''); ?>>Price: Low to High</option>
                  <option value="price_desc" <?php echo e(request('sort') == 'price_desc' ? 'selected' : ''); ?>>Price: High to Low</option>
                  <option value="rating" <?php echo e(request('sort') == 'rating' ? 'selected' : ''); ?>>Top Rated</option>
                </select>
              </div>
              <div class="d-flex align-items-center gap-2 filter-brand-wrapper">
                <h5 class="mb-0" style="font-size: 14px; font-weight: 500;">Brand</h5>
                <form id="brand-filter-form" action="<?php echo e(url()->current()); ?>" method="GET" class="d-flex align-items-center gap-2">
                  <?php $__currentLoopData = request()->except(['brand', 'page']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(is_array($value)): ?>
                      <?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <input type="hidden" name="<?php echo e($name); ?>[]" value="<?php echo e($item); ?>">
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                      <input type="hidden" name="<?php echo e($name); ?>" value="<?php echo e($value); ?>">
                    <?php endif; ?>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <select name="brand" class="form-select form-select-sm" style="width:180px; border:1px solid #c7c0bf; border-radius:4px;">
                    <option value="">All Brands</option>
                    <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($brand->slug); ?>" <?php echo e(request('brand') == $brand->slug ? 'selected' : ''); ?>><?php echo e($brand->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
                </form>
              </div>
            </div>
            <div class="btn-wrapper d-flex gap-2 grid-list-view-wrapper d-none d-lg-flex">
              <button type="button" class="view-btn active steve-btn" data-layout="grid" title="Grid View">
                <i class="fas fa-th-large"></i>
              </button>
              <button type="button" class="view-btn steve-btn" data-layout="list" title="List View">
                <i class="fas fa-bars"></i>
              </button>
            </div>
        </div>

        <?php if(isset($selectedVehicle) && $selectedVehicle && !isset($currentCategory)): ?>
          <div class="alert alert-dismissible d-flex align-items-center mb-3 py-2 px-3" style="background: linear-gradient(135deg, #e8f5e9, #f1f8e9); border: 1px solid #a5d6a7; border-radius: 8px; font-size: 14px;">
            <i class="las la-car mr-2" style="font-size: 20px; color: #2e7d32;"></i>
            <span class="text-dark">
              Showing parts for <strong><?php echo e($selectedVehicle->year); ?> <?php echo e($selectedVehicle->make); ?> <?php echo e($selectedVehicle->model); ?></strong>
            </span>
            <form method="POST" action="<?php echo e(route('shop.clear-vehicle')); ?>" class="ml-auto">
              <?php echo csrf_field(); ?>
              <button type="submit" class="text-danger fw-600 text-decoration-none border-0 bg-transparent p-0" title="Clear vehicle filter" style="font-size: 13px; cursor: pointer;">
                <i class="las la-times"></i> Clear
              </button>
            </form>
          </div>
        <?php endif; ?>

        <?php if(count($products) > 0): ?>
          <div class="row" id="products-wrapper">
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <div class="col-md-6 col-lg-4 col-xl-4 product-item-col">
                <div class="single-product">
                  <div class="img-wrapper single-product-col">
                    <div class="product-badges-category">                    
                      <?php if($product->badge): ?>
                      <span class="product-badge"><?php echo e($product->badge); ?></span>
                      <?php endif; ?>
                      <?php if($product->category): ?>
                      <!-- <span class="product-badge product-cat"><?php echo e($product->category->name); ?></span> -->
                      <?php endif; ?>
                    </div>
                    <?php
                      $isWished = in_array($product->id, $wishedProductIds ?? []);
                    ?>
                    <form action="<?php echo e(route('wishlist.add')); ?>" method="POST" class="wishlist-form">
                      <?php echo csrf_field(); ?>
                      <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                      <button type="button" class="add-to-wishlist-btn wishlist-btn border-0 bg-transparent steve-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                          <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9932 5.13581C9.9938 2.7984 6.65975 2.16964 4.15469 4.31001C1.64964 6.45038 1.29697 10.029 3.2642 12.5604C4.89982 14.6651 9.84977 19.1041 11.4721 20.5408C11.6536 20.7016 11.7444 20.7819 11.8502 20.8135C11.9426 20.8411 12.0437 20.8411 12.1361 20.8135C12.2419 20.7819 12.3327 20.7016 12.5142 20.5408C14.1365 19.1041 19.0865 14.6651 20.7221 12.5604C22.6893 10.029 22.3797 6.42787 19.8316 4.31001C17.2835 2.19216 13.9925 2.7984 11.9932 5.13581Z" fill="<?php echo e($isWished ? '#E63946' : 'none'); ?>" stroke="<?php echo e($isWished ? 'none' : 'var(--primary)'); ?>" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                      </button>
                    </form>
                    <a href="<?php echo e(route('product', $product['slug'])); ?>">
                     <?php echo imgTag('assets/images/thumbnails/' . $product->image, $product->name, 'product-img'); ?>

                     </a>
                    <div class="add-to-cart">
                      <a class="compare_product" href="javascript:;" data-href="<?php echo e(route('compare.add', ['product_id' => $product->id])); ?>">
                        <div class="compare">
                          <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M18.1777 8C23.2737 8 23.2737 16 18.1777 16C13.0827 16 11.0447 8 5.43875 8C0.85375 8 0.85375 16 5.43875 16C11.0447 16 13.0828 8 18.1788 8H18.1777Z" stroke="#030712" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                          </svg>
                        </div>
                      </a>

                      <form action="<?php echo e(route('cart.add')); ?>" method="POST" class="d-inline add-cart-form">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                        <input type="hidden" name="product_name" value="<?php echo e($product->name); ?>">
                        <input type="hidden" name="product_price" value="<?php echo e($product->price); ?>">
                        <input type="hidden" name="product_image" value="<?php echo e($product->image ? asset('assets/images/thumbnails/' . $product->image) : asset('assets/images/placeholder.png')); ?>">
                        <button type="submit" class="add-cart border-0 steve-btn">
                          Add to Cart
                        </button>
                      </form>

                      <a href="<?php echo e(route('product', $product->slug)); ?>">
                        <div class="details">
                          <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M2.42012 12.7132C2.28394 12.4975 2.21584 12.3897 2.17772 12.2234C2.14909 12.0985 2.14909 11.9015 2.17772 11.7766C2.21584 11.6103 2.28394 11.5025 2.42012 11.2868C3.54553 9.50484 6.8954 5 12.0004 5C17.1054 5 20.4553 9.50484 21.5807 11.2868C21.7169 11.5025 21.785 11.6103 21.8231 11.7766C21.8517 11.9015 21.8517 12.0985 21.8231 12.2234C21.785 12.3897 21.7169 12.4975 21.5807 12.7132C20.4553 14.4952 17.1054 19 12.0004 19C6.8954 19 3.54553 14.4952 2.42012 12.7132Z" stroke="#030712" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M12.0004 15C13.6573 15 15.0004 13.6569 15.0004 12C15.0004 10.3431 13.6573 9 12.0004 9C10.3435 9 9.0004 10.3431 9.0004 12C9.0004 13.6569 10.3435 15 12.0004 15Z" stroke="#030712" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                          </svg>
                        </div>
                      </a>
                    </div>
                  </div>
                  <div class="content-wrapper single-product-col">
                    <a href="<?php echo e(route('product', $product->slug)); ?>">
                      <h6 class="product-title"><?php echo e($product->name); ?></h6>
                    </a>
                    <div class="price-wrapper">
                      <h6><?php echo e(currency_format($product->price)); ?></h6>
                      <?php if($product->old_price): ?>
                        <h6><del><?php echo e(currency_format($product->old_price)); ?></del></h6>
                      <?php endif; ?>
                    </div>
                    <div class="ratings-wrapper">
                      <?php
                          $displayRating = $product->rating ?? 0;
                          $displayReviews = $product->reviews ?? 0;
                          if ($displayRating == 0 && $displayReviews > 0 && !empty($product->reviews_data)) {
                              $visible = collect($product->reviews_data)->where('deleted', false);
                              if ($visible->isNotEmpty()) {
                                  $displayRating = round($visible->avg('rating'));
                              }
                          }
                      ?>
                      <?php for($i = 0; $i < 5; $i++): ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="16" viewBox="0 0 17 16" fill="none">
                          <path d="M8.5 0.5L10.4084 6.37336L16.584 6.37336L11.5878 10.0033L13.4962 15.8766L8.5 12.2467L3.50383 15.8766L5.41219 10.0033L0.416019 6.37336L6.59163 6.37336L8.5 0.5Z" fill="<?php echo e($i < $displayRating ? '#EEAE0B' : '#E2E8F0'); ?>" />
                        </svg>
                      <?php endfor; ?>
                      <span class="rating-title"><?php echo e($displayRating > 0 ? number_format($displayRating, 1) . ' ' : ''); ?>(<?php echo e($displayReviews); ?>)</span>
                    </div>
                    <div class="add-to-cart">
                      <a class="compare_product" href="javascript:;" data-href="<?php echo e(route('compare.add', ['product_id' => $product->id])); ?>">
                        <div class="compare">
                          <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M18.1777 8C23.2737 8 23.2737 16 18.1777 16C13.0827 16 11.0447 8 5.43875 8C0.85375 8 0.85375 16 5.43875 16C11.0447 16 13.0828 8 18.1788 8H18.1777Z" stroke="#030712" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                          </svg>
                        </div>
                      </a>

                      <form action="<?php echo e(route('cart.add')); ?>" method="POST" class="d-inline add-cart-form">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                        <input type="hidden" name="product_name" value="<?php echo e($product->name); ?>">
                        <input type="hidden" name="product_price" value="<?php echo e($product->price); ?>">
                        <input type="hidden" name="product_image" value="<?php echo e($product->image ? asset('assets/images/thumbnails/' . $product->image) : asset('assets/images/placeholder.png')); ?>">
                        <button type="submit" class="add-cart border-0 steve-btn">
                          Add to Cart
                        </button>
                      </form>

                      <a href="<?php echo e(route('product', $product->slug)); ?>">
                        <div class="details">
                          <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M2.42012 12.7132C2.28394 12.4975 2.21584 12.3897 2.17772 12.2234C2.14909 12.0985 2.14909 11.9015 2.17772 11.7766C2.21584 11.6103 2.28394 11.5025 2.42012 11.2868C3.54553 9.50484 6.8954 5 12.0004 5C17.1054 5 20.4553 9.50484 21.5807 11.2868C21.7169 11.5025 21.785 11.6103 21.8231 11.7766C21.8517 11.9015 21.8517 12.0985 21.8231 12.2234C21.785 12.3897 21.7169 12.4975 21.5807 12.7132C20.4553 14.4952 17.1054 19 12.0004 19C6.8954 19 3.54553 14.4952 2.42012 12.7132Z" stroke="#030712" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M12.0004 15C13.6573 15 15.0004 13.6569 15.0004 12C15.0004 10.3431 13.6573 9 12.0004 9C10.3435 9 9.0004 10.3431 9.0004 12C9.0004 13.6569 10.3435 15 12.0004 15Z" stroke="#030712" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                          </svg>
                        </div>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>

          <div class="d-flex justify-content-center mt-5 shop-page-pagination">
            <?php echo e($products->links()); ?>

          </div>
        <?php else: ?>
          <div class="text-center py-5 bg-white rounded shadow-sm border">
            <i class="fas fa-box-open text-muted mb-3" style="font-size:4rem"></i>
            <h4 class="text-muted">No products found.</h4>
            <a href="<?php echo e(route('shop')); ?>" class="btn mt-3 text-white steve-btn" style="background-color:var(--primary);">View All</a>
          </div>
        <?php endif; ?>

      </div>

    </div>
  </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
$(document).ready(function() {
    // Sort Handler
    $('#sort-select').on('change', function() {
        var url = new URL(window.location.href);
        url.searchParams.set('sort', this.value);
        url.searchParams.delete('page');
        window.location.href = url.toString();
    });

    // Brand Filter Auto-Submit
    $('#brand-filter-form select[name="brand"]').on('change', function() {
        $('#brand-filter-form').submit();
    });

    // jQuery UI Price Slider
    var minPrice = parseInt("<?php echo e(request('min_price', 0)); ?>") || 0;
    var maxPrice = parseInt("<?php echo e(request('max_price', 1000)); ?>") || 1000;

    $("#price-slider").slider({
        range: true, min: 0, max: 1000,
        values: [minPrice, maxPrice],
        slide: function(event, ui) {
            $("#price-min").val(ui.values[0]);
            $("#price-max").val(ui.values[1]);
            $("#price-range-label").text("$" + ui.values[0] + " - $" + ui.values[1]);
        }
    });
    $("#price-range-label").text("$" + $("#price-slider").slider("values", 0) + " - $" + $("#price-slider").slider("values", 1));

    $("#clear-price-filter").click(function() {
        $("#price-min, #price-max").val("").prop('disabled', true);
        $("#price-filter-form").submit();
    });

    // Grid/List Toggle
    function applyLayout(layout) {
        if (layout === 'list') {
            $('[data-layout="list"]').addClass('active');
            $('[data-layout="grid"]').removeClass('active');
            $('#products-wrapper').addClass('list-view-active');
            $('#products-wrapper > .product-item-col').removeClass('col-md-6 col-lg-4 col-xl-4').addClass('col-12');
            $('#products-wrapper .single-product').removeClass('single-product').addClass('single-product-list-view');
            localStorage.setItem('shop_layout', 'list');
        } else {
            $('[data-layout="grid"]').addClass('active');
            $('[data-layout="list"]').removeClass('active');
            $('#products-wrapper').removeClass('list-view-active');
            $('#products-wrapper > .product-item-col').removeClass('col-12').addClass('col-md-6 col-lg-4 col-xl-4');
            $('#products-wrapper .single-product-list-view').removeClass('single-product-list-view').addClass('single-product');
            localStorage.setItem('shop_layout', 'grid');
        }
    }

    applyLayout(localStorage.getItem('shop_layout') || 'grid');
    $(document).on('click', '[data-layout="grid"]', function(e) { e.preventDefault(); applyLayout('grid'); });
    $(document).on('click', '[data-layout="list"]', function(e) { e.preventDefault(); applyLayout('list'); });

    // Force grid view on mobile (≤992px)
    function checkMobileLayout() {
      if (window.innerWidth <= 992) {
        applyLayout('grid');
      }
    }
    checkMobileLayout();
    $(window).on('resize', checkMobileLayout);

    // Accordion: close other main-list categories when one opens
    document.querySelectorAll('.main-list > .collapse').forEach(function(el) {
        el.addEventListener('show.bs.collapse', function() {
            document.querySelectorAll('.main-list > .collapse.show').forEach(function(other) {
                if (other !== el) {
                    bootstrap.Collapse.getInstance(other)?.hide();
                }
            });
        });
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/stautoparts/resources/views/shop.blade.php ENDPATH**/ ?>