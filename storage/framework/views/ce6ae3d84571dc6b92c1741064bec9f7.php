<?php $__env->startSection('title', config('app.name', 'StAutoparts')); ?>
<?php $__env->startSection('content'); ?>

<!-- hero section start -->
<section class="hero-slider-wrapper">
    <?php if($heroSection && $heroSection->status): ?>
        <div class="gs-hero-section" style="background-image: url('<?php echo e($heroSection->image ? asset('assets/images/home/' . $heroSection->image) : asset('assets/images/sliders/1730872837Hero03-minpng.png')); ?>'); background-size: cover; background-position: center; min-height: 520px; display: flex; align-items: center;">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="hero-content">
                            <?php if($heroSection->subtitle): ?>
                                <h6 class="subtitle wow-replaced" style="color:var(--hov-primary)"><?php echo e($heroSection->subtitle); ?></h6>
                            <?php endif; ?>
                            <?php if($heroSection->title): ?>
                                <h1 class="title wow-replaced" data-wow-delay=".1s" style="color:#090909; font-weight: 800;"><?php echo e($heroSection->title); ?></h1>
                            <?php endif; ?>
                            <?php if($heroSection->description): ?>
                                <p class="des wow-replaced" data-wow-delay=".2s" style="color:#000000">
                                    <?php echo e($heroSection->description); ?>

                                </p>
                            <?php endif; ?>
                            <?php if($heroSection->button_text && $heroSection->button_url): ?>
                                <a class="template-btn hero-shop-now-btn steve-btn wow-replaced" data-wow-delay=".3s" href="<?php echo e($heroSection->button_url); ?>">
                                    <?php echo e($heroSection->button_text); ?>

                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="gs-hero-section" style="background-image: url('<?php echo e(asset('assets/images/sliders/1730872837Hero03-minpng.png')); ?>'); background-size: cover; background-position: center; min-height: 520px; display: flex; align-items: center;">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="hero-content">
                            <h6 class="subtitle wow-replaced" style="color:var(--hov-primary)">Dive In and Explore</h6>
                            <h1 class="title wow-replaced" data-wow-delay=".1s" style="color:#090909; font-weight: 800;">Start Shopping Now!</h1>
                            <p class="des wow-replaced" data-wow-delay=".2s" style="color:#000000">
                                Explore our curated collections and find the perfect item that speaks to your style and needs. With just a click, begin your journey.
                            </p>
                            <a class="template-btn hero-shop-now-btn steve-btn wow-replaced" data-wow-delay=".3s" href="<?php echo e(route('shop')); ?>" style="background-color: var(--hov-primary);">
                                Shop Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</section>
<!-- hero section end -->

<!-- categories section start -->
<div class="gs-cate-section">
    <div class="container wow-replaced section-with-padding">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3><?php echo e($sections->get('categories_heading')?->title ??  'All Categories'); ?></h3>
            <div class="slider-nav">
                <button class="cate-prev steve-btn">
                    <i class="fas fa-chevron-left"></i>
                </button>

                <button class="cate-next steve-btn">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>

        <!-- Slider -->
        <div class="swiper home-cate-slider">
            <div class="swiper-wrapper">
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="swiper-slide px-2">
                <a href="<?php echo e(route('category', $category['slug'])); ?>">
                    <div class="gs-single-cat">
                        <div class="gs-single-cat">
                            <div class="category-image">
                                <?php $categoryImage = $category['image'] ?? 'assets/images/placeholder.png'; ?>
                                <?php echo imgTag($categoryImage, $category['name']); ?>

                            </div>
                            <h6 class="title"><?php echo e($category['name']); ?></h6>
                            <p class="des"> 
                                (<?php echo e($category['count'] ?? 0); ?>) Products
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

    </div>
</div>
<!-- categories section end -->

<!-- product offer section start -->
<section class="gs-offer-section">
    <div class="container section-with-padding">
        <!-- title box -->
        <div class="row mb-60 justify-content-center">
            <div class="col-lg-12">
                <div class="gs-title-box">
                    <h2 class="title wow-replaced">Special Offer</h2>
                </div>
                <div class="gs-title-box">
                    <p class="des mb-0 wow-replaced" data-wow-delay=".1s"><?php echo e($sections->get('offers')?->description ??  'Discover outstanding deals on high-quality auto parts. Upgraded selection and special savings this month only.'); ?></p>
                </div>
            </div>
        </div>

        <!-- main content -->
        <div class="row g-4">
            <?php $__empty_1 = true; $__currentLoopData = $bannerSections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $bannerCount = $bannerSections->count();
                    $colClass = $bannerCount == 1 ? 'col-lg-12' : ($bannerCount == 2 ? 'col-lg-6' : 'col-lg-4');
                ?>
                <div class="<?php echo e($colClass); ?> wow-replaced" data-wow-delay=".2s">
                    <a href="<?php echo e($banner->button_url ?? route('shop')); ?>" class="">
                        <?php if($banner->image): ?>
                            <?php echo imgTag('assets/images/categories/' . $banner->image, 'offer banner', 'w-100 h-100 object-fit-cover'); ?>

                        <?php else: ?>
                            <div class="bg-light p-5 text-center" style="min-height: 300px; display: flex; align-items: center; justify-content: center; border-radius: 4px;">
                                <div>
                                    <h5><?php echo e($banner->title); ?></h5>
                                    <p><?php echo e($banner->subtitle); ?></p>
                                    <button class="btn btn-primary steve-btn"><?php echo e($banner->button_text ??  'Learn More'); ?></button>
                                </div>
                            </div>
                        <?php endif; ?>
                    </a>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-lg-4 wow-replaced" data-wow-delay=".2s">
                    <a href="<?php echo e(route('shop')); ?>" class="">
                        <img class="w-100 h-100 object-fit-cover" src="<?php echo e(asset('assets/images/arrival/1730872869Banner12-minpng.png')); ?>" alt="offer product">
                    </a>
                </div>
                <div class="col-md-6 col-lg-4 wow-replaced" data-wow-delay=".2s">
                    <a href="<?php echo e(route('shop')); ?>" class="">
                        <img class="w-100 h-100 object-fit-cover" src="<?php echo e(asset('assets/images/arrival/1730872879Banner13-minpng.png')); ?>" alt="offer product">
                    </a>
                </div>
                <div class="col-md-6 col-lg-4 wow-replaced" data-wow-delay=".2s">
                    <a href="<?php echo e(route('shop')); ?>" class="">
                        <img class="w-100 h-100 object-fit-cover" src="<?php echo e(asset('assets/images/arrival/1730872888Banner14-minpng.png')); ?>" alt="offer product">
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<!-- product offer section end -->
<!-- <div id="unirate-converter"></div> -->
<!-- explore product section start -->
<section class="gs-explore-product-section bg-light-white">
    <div class="container section-with-padding">
        <!-- title box & nav-tab -->
        <div class="row mb-36 justify-content-center">
            <div class="col-12">
                <div class="gs-title-box text-center">
                    <h2 class="title wow-replaced"><?php echo e($sections->get('explore_products')?->title ??  'Explore Our Products'); ?></h2>
                </div>
                <!-- product nav -->
                <ul class="nav explore-tab-navbar wow-replaced" data-wow-delay=".1s" id="myTab" role="tablist">
                    <?php $__currentLoopData = $exploreTabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $tab): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link <?php echo e($i === 0 ? 'active' : ''); ?> steve-btn" id="ex-product-<?php echo e($i + 1); ?>" data-bs-toggle="tab" data-bs-target="#ex-product-<?php echo e($i + 1); ?>-pane" type="button" role="tab" aria-controls="ex-product-<?php echo e($i + 1); ?>-pane" aria-selected="<?php echo e($i === 0 ? 'true' : 'false'); ?>"><?php echo e($tab['label']); ?></button>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        </div>

        <!-- tab content -->
        <div class="tab-content" id="myTabContent">
            <?php $__currentLoopData = $exploreTabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $tab): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="tab-pane fade <?php echo e($i === 0 ? 'show active' : ''); ?>" id="ex-product-<?php echo e($i + 1); ?>-pane" role="tabpanel" aria-labelledby="ex-product-<?php echo e($i + 1); ?>" tabindex="0">
                <div class="row" id="products-wrapper">
                    <?php $__currentLoopData = $tab['products']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-6 col-lg-4 col-xl-3 product-item-col">
                        <div class="single-product">
                            <div class="img-wrapper">
                                
                                <div class="product-badges-category">                    
                                <?php if($product->badge): ?>
                                <span class="product-badge"><?php echo e($product->badge); ?></span>
                                <?php endif; ?>
                                <!-- <span class="product-badge product-cat"><?php echo e($product->category?->name); ?></span> -->
                                </div>
                                
                                <?php
                                    $isWished = in_array($product['id'], $wishedProductIds ?? []);
                                ?>
                                <form action="<?php echo e(route('wishlist.add')); ?>" method="POST" class="wishlist-form">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="product_id" value="<?php echo e($product['id']); ?>">

                                    <button type="button"
                                        class="add-to-wishlist-btn wishlist-btn border-0 bg-transparent steve-btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9932 5.13581C9.9938 2.7984 6.65975 2.16964 4.15469 4.31001C1.64964 6.45038 1.29697 10.029 3.2642 12.5604C4.89982 14.6651 9.84977 19.1041 11.4721 20.5408C11.6536 20.7016 11.7444 20.7819 11.8502 20.8135C11.9426 20.8411 12.0437 20.8411 12.1361 20.8135C12.2419 20.7819 12.3327 20.7016 12.5142 20.5408C14.1365 19.1041 19.0865 14.6651 20.7221 12.5604C22.6893 10.029 22.3797 6.42787 19.8316 4.31001C17.2835 2.19216 13.9925 2.7984 11.9932 5.13581Z" fill="<?php echo e($isWished ? '#E63946' : 'none'); ?>" stroke="<?php echo e($isWished ? 'none' : 'var(--primary)'); ?>" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </button>
                                </form>
                                <a href="<?php echo e(route('product', $product['slug'])); ?>">
                                <?php echo imgTag('assets/images/thumbnails/' . $product['image'], $product['name'], 'product-img'); ?>

                                </a>

                                <div class="add-to-cart">
                                    <a class="compare_product" href="javascript:;" data-href="<?php echo e(route('compare.add', ['product_id' => $product['id']])); ?>">
                                        <div class="compare">
                                            <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M18.1777 8C23.2737 8 23.2737 16 18.1777 16C13.0827 16 11.0447 8 5.43875 8C0.85375 8 0.85375 16 5.43875 16C11.0447 16 13.0828 8 18.1788 8H18.1777Z" stroke="#030712" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </div>
                                    </a>

                                    <form action="<?php echo e(route('cart.add')); ?>" method="POST" class="add-cart-form d-inline">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="product_id" value="<?php echo e($product['id']); ?>">
                                        <input type="hidden" name="product_name" value="<?php echo e($product['name']); ?>">
                                        <input type="hidden" name="product_price" value="<?php echo e($product['price']); ?>">
                                        <input type="hidden" name="product_image" value="<?php echo e(asset($product['image'])); ?>">

                                        <button type="submit" class="add-cart border-0 steve-btn">
                                            Add to Cart
                                        </button>
                                    </form>  

                                    <a href="<?php echo e(route('product', $product['slug'])); ?>">
                                        <div class="details">
                                            <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M2.42012 12.7132C2.28394 12.4975 2.21584 12.3897 2.17772 12.2234C2.14909 12.0985 2.14909 11.9015 2.17772 11.7766C2.21584 11.6103 2.28394 11.5025 2.42012 11.2868C3.54553 9.50484 6.8954 5 12.0004 5C17.1054 5 20.4553 9.50484 21.5807 11.2868C21.7169 11.5025 21.785 11.6103 21.8231 11.7766C21.8517 11.9015 21.8517 12.0985 21.8231 12.2234C21.785 12.3897 21.7169 12.4975 21.5807 12.7132C20.4553 14.4952 17.1054 19 12.0004 19C6.8954 19 3.54553 14.4952 2.42012 12.7132Z" stroke="#030712" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M12.0004 15C13.6573 15 15.0004 13.6569 15.0004 12C15.0004 10.3431 13.6573 9 12.0004 9C10.3435 9 9.0004 10.3431 9.0004 12C9.0004 13.6569 10.3435 15 12.0004 15Z" stroke="#030712" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="content-wrapper">
                                <a href="<?php echo e(route('product', $product['slug'])); ?>">
                                    <h6 class="product-title"><?php echo e($product['name']); ?></h6>
                                </a>
                                <div class="price-wrapper">
                                    <h6><?php echo e(currency_format($product['price'])); ?></h6>
                                    <?php if($product['old_price']): ?>
                                    <h6><del><?php echo e(currency_format($product['old_price'])); ?></del></h6>
                                    <?php endif; ?>
                                </div>
                                <div class="ratings-wrapper">
                                    <?php
                                        $displayRating = $product['rating'] ?? 0;
                                        $displayReviews = $product['reviews'] ?? 0;
                                        if ($displayRating == 0 && $displayReviews > 0 && !empty($product['reviews_data'])) {
                                            $visible = collect($product['reviews_data'])->where('deleted', false);
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
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>

<!-- Deal of the Day -->
<section class="gs-deal-of-day gs-deal-of-day-home2">
    <div class="container section-with-padding">
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="deal-of-day-wrapper">
                    <div class="deal-of-day-content">
                        <?php $deal = $sections->get('deal_of_day'); ?>
                        <h2 class="title wow-replaced">!! Special Offer !!</h2>
                        <h6 class="sub-title wow-replaced" data-wow-delay=".1s">CLICK SHOP NOW FOR ALL DEAL OF THE PRODUCT</h6>
                        <p class="deal-description wow-replaced" data-wow-delay=".2s">Donec condimentum Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam at risus nec urna facilisis tincidunt.</p>
                        <div class="countdown-wrapper flex-wrap " id="countdown">
                            <div class="countdown-item-wrapper d-flex">
                                <div class="countdown-item wow-replaced" data-wow-delay=".3s">
                                    <h6 class="countdown-number" id="days"><span class="countdown-title">Day</span></h6>
                                    <span class="countdown-title">Day</span>
                                </div>
                                <div class="countdown-item wow-replaced" data-wow-delay=".4s">
                                    <h6 class="countdown-number" id="hours"><span class="countdown-title">Hour</span></h6>
                                    <span class="countdown-title">Hour</span>
                                </div>
                                <div class="countdown-item wow-replaced" data-wow-delay=".5s">
                                    <h6 class="countdown-number" id="minutes"><span class="countdown-title">Min</span></h6>
                                    <span class="countdown-title">Min</span>
                                </div>
                                <div class="countdown-item wow-replaced" data-wow-delay=".6s">
                                    <h6 class="countdown-number" id="seconds"><span class="countdown-title">Sec</span></h6>
                                    <span class="countdown-title">Sec</span>
                                </div>
                            </div>
                            <a href="<?php echo e($deal?->button_url ?? route('shop')); ?>" class="template-btn steve-btn w-100 wow-replaced" data-wow-delay=".7s"><?php echo e($deal?->button_text ??  'Shop Now'); ?></a>
                        </div>
                    </div>
                </div>
            </div>
            <?php $dealRelPath = $deal?->image ? 'assets/images/home/'.$deal->image : 'assets/images/1730873933bANNER2png.png'; ?>
            <div class="col-lg-6 d-lg-none col-md-12 res-deal-img">
                <?php echo imgTag($dealRelPath, 'deal of the day', 'img-fluid'); ?>

            </div>
            <div class="deal-of-day-img h-100">
                <?php echo imgTag($dealRelPath, 'deal of the day', 'wow-replaced h-100'); ?>

            </div>
        </div>
    </div>
    <input type="hidden" id="countdown-date" value="2026-12-31T23:59:59">
</section>
<!-- Deal of the Day Completed -->

<!-- Featured Products Section Started -->
<section class="gs-explore-product-section bg-white">
    <div class="container section-with-padding">

        <div class="d-flex justify-content-between align-items-center mb-4 featured-title-row-first">
            <div class="gs-title-box">
                <h2 class="title mb-0"><?php echo e($sections->get('featured_products_heading')?->title ??  'Featured Products'); ?></h2>
            </div>

            <div class="featured-nav slider-nav">
                <button class="featured-prev steve-btn">
                    <i class="fas fa-chevron-left"></i>
                </button>

                <button class="featured-next steve-btn">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>

        <div class="swiper featured-products product-cards-slider">
            <div class="swiper-wrapper">
            <?php $__currentLoopData = $featuredProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="swiper-slide"><?php echo $__env->make('partials.product-card', ['product' => $product], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

    </div>
</section>
<!-- Featured Product Section Completed -->

<!-- Service Section -->
<section class="gs-service-section px-4 bg-light-white">
    <div class="container section-with-padding">
        <div class="row service-row">
            <div class="col-lg-3 col-md-6 col-sm-12 services-area wow-removed">
                <div class="single-service d-flex flex-lg-column flex-xl-row text-lg-center text-xl-start">
                    <div class="icon-wrapper">
                        <img src="<?php echo e(asset('assets/images/services/1667473770badgepng.png')); ?>" alt="service">
                    </div>
                    <div class="service-content">
                        <h6 class="service-title">Manage Quality</h6>
                        <p class="service-desc">Best Quality Guarantee</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 services-area wow-removed">
                <div class="single-service d-flex flex-lg-column flex-xl-row text-lg-center text-xl-start">
                    <div class="icon-wrapper">
                        <img src="<?php echo e(asset('assets/images/services/1667473742carts1png.png')); ?>" alt="service">
                    </div>
                    <div class="service-content">
                        <h6 class="service-title">Win $100 To Shop</h6>
                        <p class="service-desc">Enter Now</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 services-area wow-removed">
                <div class="single-service d-flex flex-lg-column flex-xl-row text-lg-center text-xl-start">
                    <div class="icon-wrapper">
                        <img src="<?php echo e(asset('assets/images/services/1667473728customer-service-agentpng.png')); ?>" alt="service">
                    </div>
                    <div class="service-content">
                        <h6 class="service-title">Best Online Support</h6>
                        <p class="service-desc">Hour: 10:00AM - 5:00PM</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 services-area wow-removed">
                <div class="single-service d-flex flex-lg-column flex-xl-row text-lg-center text-xl-start">
                    <div class="icon-wrapper">
                        <img src="<?php echo e(asset('assets/images/services/1667473683money-bagpng.png')); ?>" alt="service">
                    </div>
                    <div class="service-content">
                        <h6 class="service-title">Money Back Guarantee</h6>
                        <p class="service-desc">With A 30 Days</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Service Section Completed -->

<!-- Best Selling Section -->
<section class="gs-explore-product-section">
    <div class="container section-with-padding">
        <div class="row mb-40 best-selling-title-row">
            <div class="gs-title-box">
                    <h2 class="title wow-replaced"><?php echo e($sections->get('best_selling')?->title ??  'Best Selling'); ?></h2>
                </div>
                <div class="gs-title-box">
                    <p class="des mb-0 wow-replaced" data-wow-delay=".1s"><?php echo e($sections->get('best_selling')?->description ??  'Discover our top-performing products that customers love most. Quality parts, verified performance, and exceptional ratings.'); ?></p>
                </div>
                <div class="best-selling-nav slider-nav">
                    <button class="best-selling-prev steve-btn ">
                        <i class="fas fa-chevron-left"></i>
                    </button>

                    <button class="best-selling-next steve-btn">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
        </div>
        <div class="swiper best-selling product-cards-slider">
            <div class="swiper-wrapper">
            <?php $__currentLoopData = $bestSelling; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="swiper-slide"><?php echo $__env->make('partials.product-card', ['product' => $product], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</section>
<!-- Best Selling Section Completed -->

<!-- Latest Post Section -->
<section class="gs-latest-post-section bg-light-white py-120 mt-0 mb-0">
    <div class="container section-with-padding">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="gs-title-box text-center">
                    <h2 class="title wow-replaced"><?php echo e($sections->get('latest_post')?->title ??  'Latest Post'); ?></h2>
                    <p class="des mb-0 wow-replaced" data-wow-delay=".1s"><?php echo e($sections->get('latest_post')?->description ??  'Stay updated with our latest maintenance guides, tips, and insights from professional automotive mechanics.'); ?></p>
                </div>
            </div>
        </div>
        <div class="gy-5 latest-post-area m-0 latest-post-section-items">
            <?php $__empty_1 = true; $__currentLoopData = $latestPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="posts-area wow-replaced" data-wow-delay=".2s">
                <a href="<?php echo e(route('blog.show', $post->slug)); ?>" class="single-post h2-single-post">
                    <div class="post-img">
                        <?php echo imgTag('assets/images/blogs/' . ($post->image ?? 'placeholder.jpg'), $post->title); ?>

                    </div>
                    <div class="blog-overlay"></div>
                    <div class="post-content home-2">
                        <h5 class="post-title"><?php echo e($post->title); ?></h5>
                        <p class="date"><?php echo e($post->created_at->format('d M, Y')); ?></p>
                        <p class="post-desc"><?php echo e(Str::limit(strip_tags($post->details), 150)); ?></p>
                        <span class="read-more">Read More</span>
                    </div>
                </a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12 text-center">
                <p>No posts available yet.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<!-- Latest Post Section Completed -->

<!-- Top Brands Section -->
<section class="gs-brands-section">
    <div class="container section-with-padding">
        <div class="brands-section-row-first mb-30">
            <div class="flex">
                <div class="gs-title-box flex-column">
                    <h2 class="title wow-replaced"><?php echo e($sections->get('top_brands_heading')?->title ??  'Top Brands'); ?></h2>
                    <p class="des mb-0 wow-replaced" data-wow-delay=".1s"><?php echo e($sections->get('top_brands_heading')?->description ??  'Explore our curated selection of premium auto part brands known for quality and reliability.'); ?></p>
                </div>
                <div class="brands-page-nav flex-column">
                    <a href="<?php echo e(route('brands')); ?>" class="a-tag-hover-color">
                        View All
                        <i class="fas fa-arrow-right ms-1"></i> 
                    </a>                       
                </div>
            </div>
        </div>
        <div class="gs-brands row justify-content-center">
            <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-lg-4 col-md-6 col-sm-6 wow-replaced p-0" data-wow-delay=".1s">
                <a href="<?php echo e($brand->website ?: route('shop', ['brand' => $brand->slug])); ?>">
                    <div class="single-brands">
                        <img src="<?php echo e(asset('assets/images/brands/' . $brand->image)); ?>" alt="<?php echo e($brand->name); ?>">
                    </div>
                </a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<!-- Top Brands Section Completed -->

<!-- Partner Section -->
<section class="gs-partner-section">
    <div class="container section-with-padding">
        <div class="row mb-60 justify-content-center">
            <div class="col-lg-7">
                <div class="gs-title-box text-center">
                    <h2 class="title wow-replaced"><?php echo e($sections->get('partners_heading')?->title ??  'Our Partners'); ?></h2>
                    <p class="des mb-0 wow-replaced" data-wow-delay=".1s"><?php echo e($sections->get('partners_heading')?->description ??  'We collaborate with world-class manufacturers to provide the highest-grade auto parts and accessories.'); ?></p>
                </div>
            </div>
        </div>
        <div class="gs-partnerss row justify-content-center">
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 wow-replaced p-0" data-wow-delay=".1s">
                <a href="#">
                    <div class="single-partner">
                        <img src="<?php echo e(asset('assets/images/partner/1571289583p1.jpg')); ?>" alt="partner">
                    </div>
                </a>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 wow-replaced p-0" data-wow-delay=".1s">
                <a href="#">
                    <div class="single-partner">
                        <img src="<?php echo e(asset('assets/images/partner/1571289601p2.jpg')); ?>" alt="partner">
                    </div>
                </a>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 wow-replaced p-0" data-wow-delay=".1s">
                <a href="#">
                    <div class="single-partner">
                        <img src="<?php echo e(asset('assets/images/partner/1571289608p3.jpg')); ?>" alt="partner">
                    </div>
                </a>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 wow-replaced p-0" data-wow-delay=".1s">
                <a href="#">
                    <div class="single-partner">
                        <img src="<?php echo e(asset('assets/images/partner/1571289614p4.jpg')); ?>" alt="partner">
                    </div>
                </a>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 wow-replaced p-0" data-wow-delay=".1s">
                <a href="#">
                    <div class="single-partner">
                        <img src="<?php echo e(asset('assets/images/partner/1571289621p5.jpg')); ?>" alt="partner">
                    </div>
                </a>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 wow-replaced p-0" data-wow-delay=".1s">
                <a href="#">
                    <div class="single-partner">
                        <img src="<?php echo e(asset('assets/images/partner/1571289627p6.jpg')); ?>" alt="partner">
                    </div>
                </a>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 wow-replaced p-0" data-wow-delay=".1s">
                <a href="#">
                    <div class="single-partner">
                        <img src="<?php echo e(asset('assets/images/partner/1571289634p7.jpg')); ?>" alt="partner">
                    </div>
                </a>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 wow-replaced p-0" data-wow-delay=".1s">
                <a href="#">
                    <div class="single-partner">
                        <img src="<?php echo e(asset('assets/images/partner/1571289642p8.jpg')); ?>" alt="partner">
                    </div>
                </a>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 wow-replaced p-0" data-wow-delay=".1s">
                <a href="#">
                    <div class="single-partner">
                        <img src="<?php echo e(asset('assets/images/partner/1571289650p9.jpg')); ?>" alt="partner">
                    </div>
                </a>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 wow-replaced p-0" data-wow-delay=".1s">
                <a href="#">
                    <div class="single-partner">
                        <img src="<?php echo e(asset('assets/images/partner/1571289657p10.jpg')); ?>" alt="partner">
                    </div>
                </a>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 wow-replaced p-0" data-wow-delay=".1s">
                <a href="#">
                    <div class="single-partner">
                        <img src="<?php echo e(asset('assets/images/partner/1571289669p12.jpg')); ?>" alt="partner">
                    </div>
                </a>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 wow-replaced p-0" data-wow-delay=".1s">
                <a href="#">
                    <div class="single-partner">
                        <img src="<?php echo e(asset('assets/images/partner/1571289675p13.jpg')); ?>" alt="partner">
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>
<!-- Partner Section Completed -->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    $(document).ready(function() {
        if ($('.home-cate-slider').length) {
            new Swiper('.home-cate-slider', {
                slidesPerView: 6,
                spaceBetween: 20,
                freeMode: true,
                grabCursor: true,
                navigation: {
                    prevEl: '.cate-prev',
                    nextEl: '.cate-next',
                },
                breakpoints: {
                    1200: { slidesPerView: 5 },
                    992: { slidesPerView: 4 },
                    670: { slidesPerView: 3 },
                    460: { slidesPerView: 2 },
                    0: { slidesPerView: 1 },
                },
            });
        }
    });

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/stautoparts/resources/views/home.blade.php ENDPATH**/ ?>