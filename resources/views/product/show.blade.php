@extends('layouts.app')
{{-- Add your custom page ID and classes right here --}}
@include('partials.page-attributes', ['pageId' => 'product-page', 'pageClass' => 'product-page'])
@php $prodName = $product['name'] ?? 'Product'; $prodDesc = trim(strip_tags(html_entity_decode($product['description'] ?? ''))); $prodDesc = mb_strlen($prodDesc) > 160 ? mb_substr($prodDesc, 0, 157) . '...' : $prodDesc; @endphp
@section('meta_tags')
    @include('partials.meta-tags', [
        'pageTitle' => $prodName . ' - ' . config('app.name', 'StAutoparts'),
        'metaTitle' => $prodName . ' | ' . config('app.name', 'StAutoparts'),
        'metaDescription' => $prodDesc ?: ('Buy ' . $prodName . ' at ' . config('app.name', 'StAutoparts')),
    ])
@endsection

@section('style')
<style>
/*=====================================
    SHOP DETAILS STYLES
=====================================*/
.shop_details {
    margin-top: 60px;
    margin-bottom: 50px;
}

.details_slider_nav {
    display: block;
    margin-top: 12px;
    opacity: 0;
    transition: opacity 0.3s ease;
}
.details_slider_nav.swiper-initialized {
    opacity: 1;
}
.details_slider_nav .swiper-slide {
    /* margin: 0 6px; */
    width: auto;
    flex-shrink: 0;
}
.details_slider_nav .swiper-slide img {
    /* width: 100%; */
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
}
/* .details_slider_nav_item img {
    width: 100%;
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
} */
.details_slider_nav_item picture {
    display: block;
    width: 100%;
    height: 100%;
}
.details_slider_nav_item {
    background: #F5F5F5;
    overflow: hidden;
    cursor: pointer;
    border: 2px solid #F5F5F5;
    transition: all linear .3s;
    border-radius: 10px;
    height: 84px;
}

.details_slider_nav_item:hover,
.details_slider_nav .swiper-slide-active .details_slider_nav_item,
.swiper-slide-thumb-active {
    border-color: var(--primary, #e62e04);
}

.details_slider_thumb {
    display: block;
    position: relative;
    /* min-height: 450px; */
}
.details_slider_thumb .swiper-slide img {
    width: 100%;
    height: 450px;
    object-fit: cover;
}
.details_slider_thumb .swiper-slide {
    flex-shrink: 0;
}
.details_slider_thumb_item {
    background: #F5F5F5;
    overflow: hidden;
    margin: 0;
    border-radius: 16px;
}
.details_slider_thumb_item picture img{
  height: 100%;
}

/* ── Amazon-style hover zoom ── */
.zoom-wrapper {
    position: relative;
}
.zoom-container {
    position: relative;
    overflow: hidden;
    border-radius: 16px;
    cursor: crosshair;
}
.zoom-container .zoom-lens {
    display: none;
    position: absolute;
    width: 150px;
    height: 150px;
    border: 2px solid rgba(0,0,0,0.15);
    border-radius: 50%;
    background-repeat: no-repeat;
    pointer-events: none;
    z-index: 10;
    box-shadow: 0 0 0 10px rgba(0,0,0,0.04);
}
.zoom-result {
    display: none;
    position: absolute;
    top: 0;
    left: calc(100% + 15px);
    width: 100%;
    height: 100%;
    border: 1px solid #ddd;
    border-radius: 12px;
    background-repeat: no-repeat;
    background-color: #fff;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    z-index: 20;
    overflow: hidden;
}
.zoom-wrapper:hover .zoom-lens {
    display: block;
}
.zoom-wrapper:hover .zoom-result {
    display: block;
}
/* Swiper zoom module styles */
.swiper-zoom-container {
    width: 100%;
    height: 100%;
}
.swiper-zoom-container picture,
.swiper-zoom-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.swiper-slide-zoomed {
    cursor: grab;
}
@media (max-width: 991.98px) {
    .zoom-container .zoom-result {
        display: none !important;
    }
    .zoom-container:hover .zoom-result {
        display: none !important;
    }
}
.shop_details_text {
    padding: 0px 50px;
}

.shop_details_text .category {
    color:var(--secondary);
    font-size: 14px;
    font-weight: 500;
    text-transform: capitalize;
    margin-bottom: 5px;
}

.shop_details_text .details_title {
    font-size: 38px;
    font-weight: 600;
    text-transform: capitalize;
    margin-bottom: 15px;
    margin-top: 7px;
    color: #333;
    font-family: 'Jost', sans-serif;
}

.shop_details_text .stock {
    background: #05a84512;
    color: #05A845;
    padding: 2px 10px;
    margin-right: 15px;
    text-transform: capitalize;
    font-family: 'Jost', sans-serif;
    border-radius: 5px;
    font-size: 14px;
}

.shop_details_text .out_stock {
    color: #DB4437;
    background: #db443712;
}

.shop_details_text .rating svg {
    vertical-align: middle;
    margin-right: 2px;
}

.shop_details_text .rating span {
    font-size: 14px;
    margin-left: 5px;
    text-transform: capitalize;
    color: #7d7b7b;
}

.shop_details_text .price {
    font-size: 30px;
    color: #333;
    font-weight: 600;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 10px;
    margin-top: 15px;
    margin-bottom: 15px;
}

.shop_details_text .price del {
    color: #7d7b7b;
    font-weight: 400;
    font-size: 18px;
}

.shop_details_text .short_description {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    margin-bottom: 35px;
    color: #7d7b7b;
    line-height: 26px;
}

.details_single_variant {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    margin-bottom: 20px;
}

.details_single_variant .variant_title {
    color: #333;
    min-width: 54px;
    font-family: 'Jost', sans-serif;
    font-weight: 500;
    font-size: 15px;
}

.details_variant_color {
    gap: 5px;
    display: flex;
    flex-wrap: wrap;
}

.details_variant_color li {
    width: 25px;
    height: 25px;
    position: relative;
    cursor: pointer;
    border-radius: 50%;
}

.details_variant_color li.active::after {
    position: absolute;
    content: "\f00c";
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
    color: #fff;
    top: 50%;
    left: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    transform: translate(-50%, -50%);
}

.details_variant_size {
    gap: 5px;
    display: flex;
    flex-wrap: wrap;
}

.details_variant_size li {
    height: 25px;
    line-height: 25px;
    width: 45px;
    background: #F5F5F5;
    text-align: center;
    text-transform: uppercase;
    font-size: 14px;
    font-weight: 400;
    color: #333;
    position: relative;
    cursor: pointer;
    transition: all linear .3s;
    border-radius: 5px;
}

.details_variant_size li:hover,
.details_variant_size li.active {
    background: #ffa500;
    color: #fff;
}

.details_qty_input {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    background: #F5F5F5;
    overflow: hidden;
    margin-right: 15px;
    width: 130px;
    border-radius: 8px;
    margin-bottom: 15px;
}

.details_qty_input input {
    width: 60px;
    min-height: 40px;
    padding: 0;
    text-align: center;
    background: none;
    border: none;
    border-right: 1px solid #fff;
    border-left: 1px solid #fff;
    font-size: 14px;
    font-weight: 500;
    color: #333;
    border-radius: 0;
}

.details_qty_input button {
    width: 35px;
    min-height: 40px;
    font-weight: 400;
    color: #333;
    background: #F5F5F5;
    transition: all linear .3s;
    padding: 0;
    font-size: 15px;
    line-height: 40px;
    text-align: center;
    border: none;
    cursor: pointer;
}

.details_qty_input button:hover {
    background: #05A845;
    color: #fff;
}

.details_qty_input button.minus:hover {
    background: #DB4437;
}

.details_qty_input button:disabled {
    opacity: 0.4;
    cursor: not-allowed;
}

.details_qty_input button:disabled:hover {
    background: #F5F5F5;
    color: #333;
}

.details_btn_area {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    flex-wrap: wrap;
    align-items: center;
    gap: 5px;
}
@media (max-width: 400px) {
  .details_btn_area {
    grid-template-columns: 1fr;
  }
}
/* .details_btn_area div{
  width: 49%;
} */
.details_btn_area .buy_now {
    background: #05A845;
}

.common_btn {
    background: #0A69D8;
    padding: 12px 25px;
    color: #fff;
    text-transform: capitalize;
    font-weight: 500;
    font-size: 15px;
    text-align: center;
    position: relative;
    overflow: hidden;
    z-index: 1;
    transition: all .3s ease;
    display: inline-block;
    border: none;
    cursor: pointer;
}

.common_btn i {
    margin-left: 5px;
    transform: rotate(-45deg);
    transition: all 0.3s ease;
}

.common_btn:hover i {
    transform: rotate(0deg);
}

.common_btn::after {
    position: absolute;
    content: "";
    width: 0;
    height: 100%;
    top: 0;
    right: 0;
    z-index: -1;
    background: #333;
    transition: all 0.3s ease;
}

.common_btn:hover::after {
    left: 0;
    width: 100%;
}

.details_list_btn {
    display: inline-flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 10px 20px;
    border-bottom: 1px solid #dddf;
    padding-bottom: 10px;
    margin-top: 20px;
    margin-bottom: 20px;
    list-style: none;
    padding-left: 0;
}

.details_list_btn li a {
    font-size: 16px;
    color: #7d7b7b;
    text-decoration: none;
    transition: all linear .3s;
}

.details_list_btn li a i {
    margin-right: 3px;
}

.details_list_btn li a:hover {
    color: #ffa500;
}

.details_tags_sku {
    display: flex;
    flex-direction: column;
    gap: 5px;
    list-style: none;
    padding-left: 0;
}

.details_tags_sku li {
    color: #7d7b7b;
    font-size: 14px;
    text-transform: capitalize;
}

.details_tags_sku li span {
    color: #333;
    font-size: 15px;
    margin-right: 5px;
    font-family: 'Jost', sans-serif;
    font-weight: 500;
}

.shop_details_shate {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 10px;
    margin-top: 15px;
    list-style: none;
    padding-left: 0;
}

.shop_details_shate li {
    color: #333;
    font-weight: 500;
    font-family: 'Jost', sans-serif;
    font-size: 15px;
}

.shop_details_shate li a {
    text-align: center;
    color: #333;
    font-size: 16px;
    margin-left: 10px;
    text-decoration: none;
    transition: all linear .3s;
}

.shop_details_shate li a:hover {
    color: #ffa500;
}

/* Sidebar */
.shop_details_sidebar_info {
    border: 1px solid #ddd;
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 25px;
}

.shop_details_sidebar_info ul {
    display: flex;
    flex-direction: column;
    gap: 15px;
    list-style: none;
    padding-left: 0;
    margin-bottom: 0;
}

.shop_details_sidebar_info ul li {
    font-size: 13px;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 10px;
    text-transform: capitalize;
    position: relative;
    padding-left: 35px;
    color: #7d7b7b;
}

.shop_details_sidebar_info ul li span,
.shop_details_sidebar_info ul li svg {
    display: inline-block;
    width: 27px;
    height: 22px;
    margin-top: -1px;
    position: absolute;
    left: 0;
    stroke:var(--primary);
}

.shop_details_sidebar_info h5 {
    text-transform: capitalize;
    font-size: 14px;
    font-weight: 600;
    margin-top: 25px;
    margin-bottom: 10px;
    color: #333;
}

.shop_details_sidebar_store {
    background: #edf5ff;
    padding: 20px;
    position: relative;
    border-radius: 10px;
}

.shop_details_sidebar_store .sold_by {
    display: block;
    color: #333;
    font-size: 14px;
    margin-bottom: 5px;
}

.shop_details_sidebar_store .store_name {
    text-transform: capitalize;
    font-size: 18px;
    font-weight: 600;
    color: #333;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
    margin-bottom: 15px;
}

.shop_details_sidebar_store ul {
    display: flex;
    flex-direction: column;
    border-top: 1px solid #ddd;
    gap: 10px;
    padding: 15px 0px;
    list-style: none;
    padding-left: 0;
}

.shop_details_sidebar_store ul li p {
    color: #333;
    font-size: 14px;
    font-weight: 400;
    position: relative;
    margin-bottom: 0;
}
.shop_details_sidebar_store ul li {
      font-size: 13px;
    display: flex;
    flex-wrap: wrap;
    align-items: flex-start;
    gap: 10px;
    text-transform: capitalize;
    position: relative;
    padding-left: 35px;
    color: #7d7b7b;
}
.shop_details_sidebar_store ul li svg {
    display: inline-block;
    /* width: 27px;
    height: 22px; */
    margin-top: -1px;
    position: absolute;
    left: 0;
    stroke: var(--primary);
}

.shop_details_sidebar_store ul li span {
    font-size: 14px;
    font-weight: 400;
    color: #7d7b7b;
}

.shop_details_sidebar_store .go_store {
    width: 100%;
    text-align: center;
    color: #ffa500;
    font-weight: 600;
    font-size: 15px;
    margin-top: 15px;
    text-decoration: underline;
    text-underline-offset: 4px;
    display: block;
}

.shop_details_sidebar_store .go_store:hover {
    color: #333;
}

/* mt/mb spacing */
.mt_60 { margin-top: 60px; }
.mt_90 { margin-top: 90px; }
.mb_70 { margin-bottom: 70px; }
.details_slider_nav .swiper-wrapper {
    display: flex;
}
.details_slider_nav button {
    background-color: white;
    width: 40px;
    height: 40px;
    padding: 0;
    box-shadow: 0px 0px 10px #000;
}
.details_slider_nav button:after{
    font-size: 20px;
    color: var(--primary);
}
.details_slider_nav button:hover{
  background-color: var(--primary);
}
.details_slider_nav button:hover:after{
  color: white !important;
}
/* Responsive adjustments */
@media (max-width: 1199px) {
    .shop_details_text { padding: 0; }
    /* .details_slider_thumb_item { height: 450px; } */
    /* .details_slider_nav_item { width: 78px; height: 90px; } */
    .shop_details_text .details_title { font-size: 28px; }
}
@media (max-width: 991px) {
    .shop_details_text { padding: 0; margin-top: 30px; }
    /* .details_slider_nav_item { width: 70px; height: 80px; margin: 0px 8px 3px 8px; } */
    .shop_details_text .details_title { font-size: 24px; }
    .shop_details_text .price { font-size: 24px; }
    .shop_details_des_area { padding: 30px; }
    /* .shop_details_sidebar_info { margin-top: 25px; } */
    .shop_details_sidebar_store ul { flex-direction: row; }
    .shop_details_sidebar_store ul li { width: 33.33%; }
}
@media (max-width: 767px) {
    .details_slider_thumb_item { height: 350px; }
    /* .details_slider_nav_item { width: 60px; height: 70px; } */
    .details_btn_area { margin-top: 15px; }
    .shop_details_des_area { padding: 20px; }
    .shop_details_des_area .nav-pills button { font-size: 14px; padding: 6px 15px; }
}

@media (max-width: 575px) {
    /* .details_slider_nav_item { width: 50px; height: 60px; margin: 0px 5px 3px 5px; font-size: 12px; } */
}

@media (min-width: 1600px) {
    .details_slider_nav_item { 
      width: 91px; 
      /* height: 108px;  */
    }
}
</style>
@endsection

@section('content')

<!-- SHOP DETAILS START -->
<section class="shop_details">
  <div class="container">
    <div class="row">
      <div class="col-xxl-10">
        <div class="row">
          <!-- Gallery Column -->
          <div class="col-lg-6">
            <div class="shop_details_slider_area">
              <div class="zoom-wrapper">
                <div class="zoom-container">
                  <div class="swiper details_slider_thumb" id="productGallery">
                    <div class="swiper-wrapper">
                    @php
                      $galleryImages = isset($product['galleryImages']) && $product['galleryImages'] ? $product['galleryImages'] : collect();
                    @endphp
                    @if($product['image'])
                      <div class="swiper-slide details_slider_thumb_item swiper-zoom-container">
                        {!! imgTag(storedPath($product['image'], 'assets/images/thumbnails'), $product['name'], 'img-fluid w-100') !!}
                      </div>
                    @endif
                    @foreach($galleryImages as $gi)
                      <div class="swiper-slide details_slider_thumb_item swiper-zoom-container">
                        {!! imgTag(storedPath($gi->path), $product['name'], 'img-fluid w-100') !!}
                      </div>
                    @endforeach
                    </div>
                  </div>
                  <div class="zoom-lens" id="zoomLens"></div>
                </div>
                <div class="zoom-result" id="zoomResult"></div>
              </div>
              <div class="swiper details_slider_nav" id="productGalleryNav">
                <div class="swiper-wrapper">
                @if($product['image'])
                  <div class="swiper-slide details_slider_nav_item">
                    {!! imgTag(storedPath($product['image'], 'assets/images/thumbnails'), $product['name'], 'img-fluid w-100') !!}
                  </div>
                @endif
                @foreach($galleryImages as $gi)
                  <div class="swiper-slide details_slider_nav_item">
                    {!! imgTag(storedPath($gi->path), $product['name'], 'img-fluid w-100') !!}
                  </div>
                @endforeach
                </div>
                <button class="swiper-button-prev" aria-label="Previous"></button>
                <button class="swiper-button-next" aria-label="Next"></button>
              </div>
            </div>
          </div>

          <!-- Product Info Column -->
          <div class="col-lg-6">
            <div class="shop_details_text">
              @if(isset($product['category']) && $product['category'])
                <p class="category">{{ $product['category']['name'] ?? $product['category']->name }}</p>
              @endif
              <h2 class="details_title">{{ $product['name'] }}</h2>

              <div class="d-flex flex-wrap align-items-center">
                <p class="stock">{{ $product['stock'] > 0 ? 'In Stock' : 'Out of Stock' }}</p>
                @php
                  $visibleReviews = collect($product['reviews_data'] ?? [])->where('deleted', false);
                  $avgRating = $visibleReviews->avg('rating');
                  $displayRating = round($avgRating);
                @endphp
                @if($visibleReviews->count() > 0)
                <p class="rating" id="product-rating">
                  @for($i = 0; $i < 5; $i++)
                  <svg xmlns="http://www.w3.org/2000/svg" width="17" height="16" viewBox="0 0 17 16" fill="none">
                      <path d="M8.5 0.5L10.4084 6.37336L16.584 6.37336L11.5878 10.0033L13.4962 15.8766L8.5 12.2467L3.50383 15.8766L5.41219 10.0033L0.416019 6.37336L6.59163 6.37336L8.5 0.5Z" fill="{{ $i < $displayRating ? '#EEAE0B' : '#E2E8F0' }}" />
                  </svg>
                  @endfor
                  <span id="product-review-count">({{ $visibleReviews->count() }})</span>
                </p>
                @endif
              </div>

              @if($product->year && $product->make && $product->model)
                <div class="d-flex flex-wrap align-items-center mb-2" style="gap: 8px;">
                  <span class="badge" style="background: #e3f2fd; color: var(--secondary); font-size: 13px; font-weight: 500; padding: 6px 12px; border-radius: 6px; margin-top:10px;">
                    <i class="las la-car mr-1"></i> Fits: {{ $product->year }} {{ $product->make }} {{ $product->model }}
                  </span>
                </div>
              @endif

              @if(isset($userVehicle) && $userVehicle && $product->year && $product->make && $product->model)
                <div class="mb-2" style="font-size: 13px;">
                  @if($vehicleFit)
                    <span style="color: #2e7d32; font-weight: 600;">
                      <i class="las la-check-circle"></i> Fits your {{ $userVehicle->year }} {{ $userVehicle->make }} {{ $userVehicle->model }}
                    </span>
                  @else
                    <span style="color: #c62828; font-weight: 600;">
                      <i class="las la-times-circle"></i> Does not fit your {{ $userVehicle->year }} {{ $userVehicle->make }} {{ $userVehicle->model }}
                    </span>
                  @endif
                </div>
              @endif

              <h3 class="price">
                {{ currency_format($product['price']) }}
                @if($product['old_price'])
                  <del>{{ currency_format($product['old_price']) }}</del>
                @endif
              </h3>

              <div class="short_description" style="line-height: 1.8; color: #4c3533;">{!! $product['description'] ?? 'Auctor urna nunc id cursus. Scelerisque purus semper eget duis at pharetra vel turpis nunc eget.' !!}</div>

              <form action="{{ route('cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                <input type="hidden" name="product_name" value="{{ $product['name'] }}">
                <input type="hidden" name="product_price" value="{{ $product['price'] }}">
                <input type="hidden" name="product_image" value="{{ storedImageUrl($product['image'], 'assets/images/thumbnails') }}">

                <div class="d-flex flex-wrap align-items-center">
                  <div class="details_qty_input">
                    <button type="button" class="minus" id="qty-minus" onclick="updateQty(-1)" disabled><i class="fas fa-minus"></i></button>
                    <input type="text" readonly id="qty" name="qty" value="1" min="1" max="{{ $product['stock'] }}">
                    <button type="button" class="plus" id="qty-plus" onclick="updateQty(1)"><i class="fas fa-plus"></i></button>
                  </div>                  
                </div>
                <div class="details_btn_area">
                  <div class="buy-now-btn">
                    <button type="submit" name="buy_now" value="1" class="template-btn steve-btn w-100 buy-now">Buy Now</button>
                    </div>
                    <div class="add-cart-btn">
                    <button type="submit" class="template-btn steve-btn w-100">Add to Cart</button>
                    </div>
                  </div>
              </form>

              <ul class="details_list_btn">
                <li>
                  <form action="{{ route('wishlist.add') }}" method="POST" class="wishlist-form d-inline">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button type="button" class="wishlist-btn" style="background:none;border:none;padding:0;font-size:16px;color:#7d7b7b;cursor:pointer;">
                      <i class="{{ $inWishlist ? 'fas' : 'far' }} fa-heart"></i> <span>{{ $inWishlist ? 'Remove Wishlist' : 'Add Wishlist' }}</span>
                    </button>
                  </form>
                </li>
                <li>
                  <a href="javascript:;" data-href="{{ route('compare.add', ['product_id' => $product->id]) }}" class="compare_product"><i class="fas fa-exchange-alt"></i> Compare</a>
                </li>
<li>
                   <a href="javascript:void(0)" id="contact-seller-btn" style="cursor:pointer;"><i class="fas fa-question-circle"></i> Ask a question</a>
                 </li>
              </ul>

              <ul class="details_tags_sku">
                <li><span>SKU:</span> WB44721Fdq{{ $product['id'] }}</li>
                @if(isset($product['category']) && $product['category'])
                <li><span>Category:</span> {{ $product['category']['name'] ?? $product['category']->name }}</li>
                @endif
              </ul>

              <ul class="shop_details_shate">
                <li>Share:</li>
                <li><a href="https://facebook.com" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                <li><a href="https://twitter.com" target="_blank"><i class="fab fa-twitter"></i></a></li>
                <li><a href="https://linkedin.com" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                <li><a href="https://whatsapp.com" target="_blank"><i class="fab fa-whatsapp"></i></a></li>
              </ul>
            </div>
          </div>
        </div>

        <!-- Description & Reviews Tabs -->
        <div class="tab-product-des-wrapper pt-4">
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link template-btn steve-btn active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description-tab-pane" type="button" role="tab" aria-controls="description-tab-pane" aria-selected="true">Description</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link template-btn steve-btn" id="policy-tab" data-bs-toggle="tab" data-bs-target="#policy-tab-pane" type="button" role="tab" aria-controls="policy-tab-pane" aria-selected="false">Buy / Return Policy</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link template-btn steve-btn" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews-tab-pane" type="button" role="tab" aria-controls="reviews-tab-pane" aria-selected="false">Reviews ({{ collect($product['reviews_data'] ?? [])->where('deleted', false)->count() }})</button>
            </li>
          </ul>
          <div class="tab-content border px-4 " id="myTabContent">
            <div class="tab-pane fade show active py-4" id="description-tab-pane" role="tabpanel" aria-labelledby="description-tab" tabindex="0">
              <div style="line-height: 1.8; color: #4c3533;">{!! $product['description'] ?? 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.' !!}</div>
              @if(!empty($product['features']))
                <h5 class="mt-4 mb-3" style="font-weight: 600;">Key Features:</h5>
                <ul style="line-height: 1.8; color: #4c3533; padding-left: 20px;">
                  @foreach($product['features'] ?? [] as $feature)
                    <li>{!! $feature !!}</li>
                  @endforeach
                </ul>
              @endif
            </div>
            <div class="tab-pane fade py-4" id="policy-tab-pane" role="tabpanel" aria-labelledby="policy-tab" tabindex="0">
                <div style="line-height: 1.8; color: #4c3533;">
                  {!! $product['policy_text'] ?? 'No policy information available.' !!}
                </div>
            </div>
            <div class="tab-pane fade py-4" id="reviews-tab-pane" role="tabpanel" aria-labelledby="reviews-tab" tabindex="0">
              <div class="review-tab-content-wrapper bg-white">

                <!-- Review Form (always visible, server validates eligibility) -->
                <div class="write-review-form mb-4 pb-4 border-bottom" id="writeReviewForm">
                  <h5 class="mb-3" style="font-weight: 600;">Write a Review</h5>
                  <div id="reviewFormAlert" class="d-none mb-3"></div>
                  <div class="mb-3">
                    <label class="form-label fw-semibold">Your Rating *</label>
                    <div class="star-picker" id="starPicker">
                      @for($i = 1; $i <= 5; $i++)
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="21" viewBox="0 0 17 16" fill="none" data-rating="{{ $i }}" style="cursor:pointer;transition:fill .2s;">
                          <path d="M8.5 0.5L10.4084 6.37336L16.584 6.37336L11.5878 10.0033L13.4962 15.8766L8.5 12.2467L3.50383 15.8766L5.41219 10.0033L0.416019 6.37336L6.59163 6.37336L8.5 0.5Z" fill="#E2E8F0" />
                        </svg>
                      @endfor
                      <input type="hidden" name="rating" id="reviewRating" value="0">
                    </div>
                  </div>
                  <div class="mb-3">
                    <label class="form-label fw-semibold">Your Review *</label>
                    <textarea class="form-control" id="reviewText" rows="3" maxlength="1000" placeholder="Share your experience with this product..."></textarea>
                  </div>
                  <div class="mb-3">
                    <label class="form-label fw-semibold">Review Images</label>
                    <input type="file" id="reviewImagesInput" multiple accept="image/jpg,image/jpeg,image/png,image/webp" class="d-none">
                    <button type="button" class="btn btn-outline-secondary btn-sm steve-btn" id="reviewImagesBrowseBtn"><i class="fas fa-cloud-upload-alt"></i> Browse</button>
                    <span class="text-muted ms-2" style="font-size:12px;">Max 5 images, 2MB each</span>
                    <div id="reviewImagesPreview" class="d-flex flex-wrap gap-2 mt-2"></div>
                  </div>
                  <button type="button" class="template-btn steve-btn" id="submitReviewBtn">Submit Review</button>
                </div>

                <!-- Reviews List -->
                <div id="reviewsList">
                @php $reviews = collect($product['reviews_data'] ?? [])->where('deleted', false); @endphp
                @forelse($reviews as $review)
                  <div class="d-flex gap-3 mb-4 pb-3 border-bottom review-item" data-review-id="{{ $review['id'] ?? '' }}">
                    <div class="flex-shrink-0">
                      <div class="rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 50px; height: 50px; background: var(--primary); font-weight: 600; font-size: 18px;">{{ substr($review['name'] ?? '?', 0, 1) }}</div>
                    </div>
                    <div class="flex-grow-1">
                      <div class="d-flex align-items-center gap-2 mb-1">
                        <h6 class="mb-0 fw-semibold">{{ $review['name'] ?? 'Anonymous' }}</h6>
                        <small class="text-muted">{{ $review['date'] ?? '' }}</small>
                        @auth
                          @if(($review['user_id'] ?? null) == Auth::id())
                            <button type="button" class="btn btn-sm btn-outline-danger ms-auto delete-review-btn" data-review-id="{{ $review['id'] ?? '' }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Delete review" style="padding:6px 12px;font-size:13px;">
                              <i class="fas fa-trash"></i>
                            </button>
                          @endif
                        @endauth
                      </div>
                      <div class="mb-1">
                        @for($i = 0; $i < 5; $i++)
                          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="13" viewBox="0 0 17 16" fill="none">
                              <path d="M8.5 0.5L10.4084 6.37336L16.584 6.37336L11.5878 10.0033L13.4962 15.8766L8.5 12.2467L3.50383 15.8766L5.41219 10.0033L0.416019 6.37336L6.59163 6.37336L8.5 0.5Z" fill="{{ $i < ($review['rating'] ?? 0) ? '#EEAE0B' : '#E2E8F0' }}" />
                          </svg>
                        @endfor
                      </div>
                      <p class="mb-0" style="color: #4c3533;">{{ $review['text'] ?? '' }}</p>
                      @if(!empty($review['images']) && count($review['images']) > 0)
                        <div class="d-flex flex-wrap gap-2 mt-2">
                          @foreach($review['images'] as $img)
                            <a href="{{ asset($img) }}" target="_blank">
                              <img src="{{ asset($img) }}" alt="Review image" style="width:70px;height:70px;object-fit:cover;border-radius:6px;border:1px solid #ddd;">
                            </a>
                          @endforeach
                        </div>
                      @endif
                    </div>
                  </div>
                @empty
                  <p class="text-muted mb-0" id="noReviewsMsg">No reviews yet. Be the first to review this product!</p>
                @endforelse
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Sidebar -->
      <div class="col-xxl-2">
        <div class="shop_details_sidebar">
          <div class="shop_details_sidebar_info">
            <ul>
              <li>
                <span>
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247" />
                  </svg>
                </span>
                Shipping worldwide
              </li>
              <li>
                <span>
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                  </svg>
                </span>
                Always Authentic
              </li>
              <li>
                <span>
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                  </svg>
                </span>
                Cash on Delivery Available
              </li>
            </ul>
            <h5>Return & Warranty</h5>
            <ul>
              <li>
                <span>
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                  </svg>
                </span>
                14 days easy return
              </li>
              <li>
                <span>
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M12 9v3.75m0-10.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.25-8.25-3.286Zm0 13.036h.008v.008H12v-.008Z" />
                  </svg>
                </span>
                Warranty not available
              </li>
            </ul>
          </div>

          <div class="shop_details_sidebar_store">
            <p class="sold_by">Sold by</p>
            <h4 class="store_name">Genius Store</h4>
            <ul>
              <li>
                  <svg width="24" height="24" viewBox="0 0 128 128" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_iconCarrier"> <path d="M20.5144 27.5569C20.5144 25.51 22.1738 23.8506 24.2208 23.8506H96.2817C98.3286 23.8506 99.988 25.51 99.988 27.5569V70.8851C99.988 72.932 98.3286 74.5914 96.2817 74.5914H24.2208C22.1738 74.5914 20.5144 72.932 20.5144 70.8851V27.5569Z" fill="var(--primary)"></path> <path d="M16.1722 23.2146C16.1722 21.1677 17.8315 19.5083 19.8785 19.5083H91.9394C93.9864 19.5083 95.6457 21.1677 95.6457 23.2146V66.5428C95.6457 68.5898 93.9864 70.2491 91.9394 70.2491H19.8785C17.8315 70.2491 16.1722 68.5898 16.1722 66.5428V23.2146Z" fill="white"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M19.8785 17.6552H91.9394C95.0098 17.6552 97.4989 20.1442 97.4989 23.2146V66.5428C97.4989 69.6132 95.0098 72.1023 91.9394 72.1023H19.8785C16.8081 72.1023 14.319 69.6132 14.319 66.5428V23.2146C14.319 20.1442 16.8081 17.6552 19.8785 17.6552ZM19.8785 19.5083C17.8315 19.5083 16.1722 21.1677 16.1722 23.2146V66.5428C16.1722 68.5898 17.8315 70.2491 19.8785 70.2491H91.9394C93.9864 70.2491 95.6457 68.5898 95.6457 66.5428V23.2146C95.6457 21.1677 93.9864 19.5083 91.9394 19.5083H19.8785Z" fill="var(--primary)"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M31.3161 37.5104C31.991 36.116 33.9773 36.116 34.6522 37.5104L36.06 40.4192L38.9974 40.7527C40.5499 40.9289 41.2008 42.8294 40.0823 43.9205L37.619 46.3235L38.2094 48.7445C38.5994 50.3438 36.8662 51.6197 35.4549 50.7722L32.9841 49.2885L30.5133 50.7722C29.1021 51.6197 27.3689 50.3438 27.7589 48.7445L28.3492 46.3235L25.8859 43.9205C24.7674 42.8294 25.4183 40.9289 26.9709 40.7527L29.9082 40.4192L31.3161 37.5104ZM34.392 41.2265L32.9841 38.3178L31.5763 41.2265C31.2994 41.7986 30.7487 42.1888 30.1172 42.2605L27.1799 42.594L29.6433 44.997C30.1124 45.4546 30.3049 46.1259 30.1496 46.7626L29.5593 49.1835L32.0301 47.6998C32.6172 47.3472 33.351 47.3472 33.9382 47.6998L36.409 49.1835L35.8186 46.7626C35.6633 46.1259 35.8559 45.4546 36.325 44.997L38.7883 42.594L35.851 42.2605C35.2195 42.1888 34.6689 41.7986 34.392 41.2265Z" fill="var(--primary)"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M53.7391 37.5104C54.414 36.116 56.4003 36.116 57.0752 37.5104L58.483 40.4192L61.4203 40.7527C62.9729 40.9289 63.6238 42.8294 62.5053 43.9205L60.042 46.3235L60.6324 48.7445C61.0224 50.3438 59.2892 51.6197 57.8779 50.7722L55.4071 49.2885L52.9363 50.7722C51.5251 51.6197 49.7919 50.3438 50.1819 48.7445L50.7722 46.3235L48.3089 43.9205C47.1904 42.8294 47.8413 40.9289 49.3939 40.7527L52.3312 40.4192L53.7391 37.5104ZM56.815 41.2265L55.4071 38.3178L53.9992 41.2265C53.7224 41.7986 53.1717 42.1888 52.5402 42.2605L49.6029 42.594L52.0663 44.997C52.5354 45.4546 52.7279 46.1259 52.5726 46.7626L51.9823 49.1835L54.4531 47.6998C55.0402 47.3472 55.774 47.3472 56.3612 47.6998L58.832 49.1835L58.2416 46.7626C58.0863 46.1259 58.2789 45.4546 58.748 44.997L61.2113 42.594L58.274 42.2605C57.6425 42.1888 57.0919 41.7986 56.815 41.2265Z" fill="var(--primary)"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M76.162 37.5104C76.8369 36.116 78.8232 36.116 79.4981 37.5104L80.906 40.4192L83.8433 40.7527C85.3959 40.9289 86.0468 42.8294 84.9283 43.9205L82.465 46.3235L83.0553 48.7445C83.4454 50.3438 81.7121 51.6197 80.3009 50.7722L77.8301 49.2885L75.3593 50.7722C73.948 51.6197 72.2148 50.3438 72.6048 48.7445L73.1952 46.3235L70.7319 43.9205C69.6134 42.8294 70.2643 40.9289 71.8169 40.7527L74.7542 40.4192L76.162 37.5104ZM79.238 41.2265L77.8301 38.3178L76.4222 41.2265C76.1454 41.7986 75.5947 42.1888 74.9632 42.2605L72.0259 42.594L74.4892 44.997C74.9583 45.4546 75.1509 46.1259 74.9956 46.7626L74.4052 49.1835L76.876 47.6998C77.4632 47.3472 78.197 47.3472 78.7841 47.6998L81.2549 49.1835L80.6646 46.7626C80.5093 46.1259 80.7018 45.4546 81.1709 44.997L83.6343 42.5943L80.697 42.2605C80.0655 42.1888 79.5148 41.7986 79.238 41.2265Z" fill="var(--primary)"></path> <path d="M81.3273 106.517V103.831C81.3273 101.548 83.3787 99.8274 85.6607 99.8819C93.0903 100.059 98.8905 97.4997 102.559 94.9111C104.512 93.5336 107.416 93.6359 108.854 95.5442L110.006 97.0737C111.062 98.4746 111.004 100.441 109.747 101.665C100.438 110.727 90.0525 110.966 84.0301 109.916C82.4077 109.633 81.3273 108.164 81.3273 106.517Z" fill="var(--primary)"></path> <path d="M76.2206 96.4476C82.0715 102.638 90.3617 101.09 95.0305 99.6788C104.368 96.8564 110.101 90.5379 105.021 73.7306C104.074 70.5984 100.326 68.3131 96.7088 70.5465C95.9242 71.0311 94.913 71.0725 94.0951 70.6464C91.0283 69.0487 88.6768 70.7226 87.3684 72.1581C86.8414 72.7363 85.7675 72.6394 85.4743 71.9141L84.0794 68.4624L82.0569 62.571C80.9986 59.0694 77.6059 56.2735 74.1043 57.3319C70.6028 58.3903 70.8468 63.4118 72.1806 67.8252L77.714 84.5319L73.1543 82.0887C71.6344 81.2743 67.9645 80.0908 65.4455 81.8712C62.9266 83.6516 63.0025 86.4311 64.8753 88.4126C66.748 90.3941 72.4751 92.4845 76.2206 96.4476Z" fill="white"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M74.0296 80.4553L74.4941 80.7042L70.4214 68.4079C70.4163 68.3925 70.4114 68.3769 70.4067 68.3614C69.7059 66.0425 69.2389 63.4115 69.4868 61.121C69.7371 58.8098 70.8083 56.3923 73.5682 55.558C75.965 54.8336 78.2742 55.4589 80.0679 56.7292C81.8312 57.978 83.1744 59.8909 83.8203 62.0002L85.8161 67.8139L86.7614 70.153C87.4662 69.523 88.3681 68.8989 89.4587 68.5162C91.0665 67.952 92.9538 67.9623 94.9513 69.0029C95.1839 69.1241 95.5001 69.115 95.7352 68.9698C98.0819 67.5207 100.576 67.5068 102.631 68.4388C104.629 69.3449 106.168 71.1214 106.794 73.1944C109.392 81.7895 109.361 88.1175 107.098 92.7609C104.811 97.454 100.473 99.9697 95.5667 101.453C90.8609 102.875 81.5362 104.77 74.8738 97.7206C73.1918 95.941 71.0186 94.5373 68.9003 93.281C68.5602 93.0793 68.214 92.877 67.871 92.6766C67.1872 92.2771 66.5159 91.8848 65.9294 91.5184C65.0565 90.9731 64.1716 90.3661 63.5285 89.6856C62.3106 88.3971 61.5695 86.7302 61.6629 84.9684C61.7585 83.1671 62.7136 81.5329 64.3759 80.358C66.1542 79.101 68.2301 78.9619 69.901 79.1677C71.5805 79.3745 73.0964 79.9554 74.0296 80.4553ZM84.0794 68.4624L85.4743 71.9141C85.7674 72.6395 86.8414 72.7364 87.3684 72.1582C88.6768 70.7227 91.0283 69.0487 94.0951 70.6464C94.913 71.0725 95.9241 71.0312 96.7088 70.5466C100.326 68.3131 104.074 70.5984 105.021 73.7306C110.101 90.538 104.368 96.8565 95.0305 99.6789C90.3617 101.09 82.0715 102.638 76.2206 96.4477C74.0265 94.1261 71.1524 92.4472 68.7715 91.0563C67.0879 90.0728 65.651 89.2334 64.8753 88.4127C63.0025 86.4312 62.9266 83.6517 65.4455 81.8713C67.9645 80.0908 71.6344 81.2744 73.1543 82.0888L77.714 84.532L72.1806 67.8253C70.8468 63.4118 70.6028 58.3903 74.1043 57.3319C77.6059 56.2736 80.9986 59.0695 82.0569 62.571L84.0794 68.4624Z" fill="var(--primary)"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M87.2497 77.7961C87.7469 77.6749 88.2482 77.9796 88.3695 78.4768L90.662 87.876C90.7832 88.3732 90.4785 88.8745 89.9813 88.9958C89.4842 89.1171 88.9828 88.8123 88.8616 88.3152L86.5691 78.9159C86.4478 78.4187 86.7525 77.9174 87.2497 77.7961Z" fill="var(--primary)"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M96.4918 76.6615C97.0021 76.6222 97.4475 77.004 97.4867 77.5143L97.9452 83.4748C97.9845 83.985 97.6027 84.4304 97.0925 84.4697C96.5822 84.5089 96.1368 84.1271 96.0975 83.6169L95.639 77.6564C95.5998 77.1462 95.9816 76.7007 96.4918 76.6615Z" fill="var(--primary)"></path> </g></svg>
                  <p>Positive Seller Ratings</p>          
                <span>4.5 (320)</span>
              </li>
              <li>
                <svg width="24" height="24" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">

                <path d="M1.15 8.2H3.55"
                      stroke="var(--primary)"
                      stroke-width="0.85"
                      stroke-linecap="round"/>

                <path d="M0.55 10H3.55"
                      stroke="var(--primary)"
                      stroke-width="0.85"
                      stroke-linecap="round"/>

                <path d="M1.55 11.75H3.55"
                      stroke="var(--primary)"
                      stroke-width="0.85"
                      stroke-linecap="round"/>

                <path d="M4.55 5.92L10.5 2.95L17.05 5.98L11.02 8.98L4.55 5.92Z"
                      stroke="var(--primary)"
                      stroke-width="0.85"
                      stroke-linejoin="round"/>

                <path d="M4.55 5.92V13.78L11.02 16.75V8.98"
                      stroke="var(--primary)"
                      stroke-width="0.85"
                      stroke-linejoin="round"/>

                <path d="M11.02 8.98V16.75L17.05 13.78V5.98"
                      stroke="var(--primary)"
                      stroke-width="0.85"
                      stroke-linejoin="round"/>

                <path d="M7.68 7.4V9.55"
                      stroke="var(--primary)"
                      stroke-width="0.85"
                      stroke-linecap="round"/>

                <path d="M14.05 7.45V9.55"
                      stroke="var(--primary)"
                      stroke-width="0.85"
                      stroke-linecap="round"/>

                <path d="M7.5 13.25V14.75"
                      stroke="var(--primary)"
                      stroke-width="0.85"
                      stroke-linecap="round"/>

                <circle cx="17.05" cy="13.55" r="2.45"
                        fill="white"
                        stroke="var(--primary)"
                        stroke-width="0.85"/>

                <path d="M17.05 11.35V11.65M17.05 15.45V15.75M14.85 13.55H15.15M18.95 13.55H19.25"
                      stroke="var(--primary)"
                      stroke-width="0.65"
                      stroke-linecap="round"/>

                <path d="M15.5 12L15.72 12.22M18.38 14.88L18.6 15.1M18.6 12L18.38 12.22M15.72 14.88L15.5 15.1"
                      stroke="var(--primary)"
                      stroke-width="0.65"
                      stroke-linecap="round"/>

                <path d="M17.05 12.65V13.55L17.48 13.98"
                      stroke="var(--primary)"
                      stroke-width="0.75"
                      stroke-linecap="round"
                      stroke-linejoin="round"/>

                <circle cx="17.05" cy="13.55" r="0.4"
                        fill="var(--primary)"/>
            </svg>
            <p>Ship on Time</p>
            <span>100%</span>
          </li>
          <li>
                <svg width="24" height="24" viewBox="0 0 20 20" fill="none"
     xmlns="http://www.w3.org/2000/svg">

    <!-- Chat bubble -->
    <path d="M3.2 3.4H16.8C17.46 3.4 18 3.94 18 4.6V12.2C18 12.86 17.46 13.4 16.8 13.4H9L5.1 16V13.4H3.2C2.54 13.4 2 12.86 2 12.2V4.6C2 3.94 2.54 3.4 3.2 3.4Z"
          stroke="var(--primary)"
          stroke-width="0.9"
          stroke-linejoin="round"/>

    <!-- Chat lines -->
    <path d="M5.2 6.5H14.8"
          stroke="var(--primary)"
          stroke-width="0.8"
          stroke-linecap="round"/>

    <path d="M5.2 9H12"
          stroke="var(--primary)"
          stroke-width="0.8"
          stroke-linecap="round"/>

    <!-- Response check -->
    <path d="M11.8 10.8L13.1 12.1L15.8 9.4"
          stroke="var(--primary)"
          stroke-width="0.85"
          stroke-linecap="round"
          stroke-linejoin="round"/>
</svg>
                <p>Chat Response Rate</p>
                <span>90%</span>
              </li>
            </ul>
            <!-- <a class="chat" href="javascript:void(0)" id="contact-seller-btn-sidebar" style="position:absolute;top:18px;right:25px;display:flex;align-items:center;gap:5px;color:#0A69D8;font-size:13px;font-weight:600;text-decoration:none;cursor:pointer;">
              <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
              </svg>
              Chat Now
            </a> -->
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- SHOP DETAILS END -->

<!-- Related Products Area -->
@if(isset($related) && $related->count() > 0)
<section class="gs-product-cards-slider-area" style="background-color: #ffffff;">
  <div class="container">
    <div class="title text-center mb-5">
      <h3 style="font-weight: 600;">Related Products</h3>
      <p class="text-muted">Explore other premium products in this category</p>
    </div>
    <div class="related-products-grid d-grid">
      @foreach($related as $rel)
        <div class="grid-item">
          @include("partials.product-card", ["product" => $rel, "cardClass" => "h-100 shadow-sm border overflow-hidden", "titleTag" => "h5", "titleClass" => "mb-2", "priceTag" => "h4", "viewIcon" => "fa", "wishedProductIds" => $wishedProductIds ?? []])
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif

<!-- Contact Seller Modal -->
<div class="modal fade" id="contactSellerModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div id="contactSellerAlert" class="d-none" style="margin:0; border-radius:0;"></div>
      <form action="{{ route('contact.seller') }}" method="POST" id="contactSellerForm">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product['id'] }}">
        <div class="modal-header">
          <h5 class="modal-title">Contact Seller</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Name *</label>
            <input type="text" name="name" class="form-control" required maxlength="255" value="{{ Auth::check() ? Auth::user()->name : '' }}">
          </div>
          <div class="mb-3">
            <label class="form-label">Email *</label>
            <input type="email" name="email" class="form-control" required maxlength="255" value="{{ Auth::check() ? Auth::user()->email : '' }}">
          </div>
          <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="tel" name="phone" class="form-control" inputmode="numeric" maxlength="20" value="{{ Auth::check() ? Auth::user()->phone ?? '' : '' }}">
          </div>
          <div class="mb-3">
            <label class="form-label">Message *</label>
            <textarea name="message" class="form-control" required rows="4" maxlength="2000"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="contactSellerSubmitBtn">
            <span id="contactSellerBtnText">Send Message</span>
            <span id="contactSellerBtnSpinner" class="d-none">
              <span class="spinner-border spinner-border-sm" role="status"></span> Sending...
            </span>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
document.getElementById('contact-seller-btn')?.addEventListener('click', function(e) {
  e.preventDefault();
  var modal = new bootstrap.Modal(document.getElementById('contactSellerModal'));
  modal.show();
});
document.getElementById('contact-seller-btn-sidebar')?.addEventListener('click', function(e) {
  e.preventDefault();
  var modal = new bootstrap.Modal(document.getElementById('contactSellerModal'));
  modal.show();
});

document.getElementById('contactSellerForm')?.addEventListener('submit', function(e) {
  e.preventDefault();
  var form = this;
  var alertBox = document.getElementById('contactSellerAlert');
  var submitBtn = document.getElementById('contactSellerSubmitBtn');
  var btnText = document.getElementById('contactSellerBtnText');
  var btnSpinner = document.getElementById('contactSellerBtnSpinner');

  alertBox.className = 'd-none';
  submitBtn.disabled = true;
  btnText.classList.add('d-none');
  btnSpinner.classList.remove('d-none');

  var formData = new FormData(form);

  fetch(form.action, {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      'X-Requested-With': 'XMLHttpRequest',
      'Accept': 'application/json'
    },
    body: formData
  }).then(function(response) {
    return response.json().then(function(data) {
      return { status: response.status, data: data };
    });
  }).then(function(result) {
    submitBtn.disabled = false;
    btnText.classList.remove('d-none');
    btnSpinner.classList.add('d-none');

    if (result.status === 200 || result.status === 201) {
      toastr.success(result.data.message || 'Message sent successfully!');
      form.reset();
      form.querySelectorAll('input, textarea').forEach(function(el) { el.value = ''; });
      bootstrap.Modal.getInstance(document.getElementById('contactSellerModal')).hide();
    } else if (result.status === 422) {
      var errors = result.data.errors || {};
      var msgs = [];
      Object.values(errors).forEach(function(arr) { arr.forEach(function(m) { msgs.push(m); }); });
      alertBox.className = 'alert alert-danger m-0 rounded-0';
      alertBox.textContent = msgs.join(' ');
    } else {
      alertBox.className = 'alert alert-danger m-0 rounded-0';
      alertBox.textContent = result.data.message || 'Something went wrong. Please try again.';
    }
  }).catch(function() {
    submitBtn.disabled = false;
    btnText.classList.remove('d-none');
    btnSpinner.classList.add('d-none');
    alertBox.className = 'alert alert-danger m-0 rounded-0';
    alertBox.textContent = 'Network error. Please try again.';
  });
});

const qtyInput = document.getElementById('qty');
const qtyMinus = document.getElementById('qty-minus');
const qtyPlus = document.getElementById('qty-plus');
const maxQty = {{ $product['stock'] }};

function updateQty(change) {
  let val = parseInt(qtyInput.value) + change;
  if (val < 1) val = 1;
  if (val > maxQty) val = maxQty;
  qtyInput.value = val;
  qtyMinus.disabled = val <= 1;
  qtyPlus.disabled = val >= maxQty;
}

updateQty(0);


// Star picker
const starPicker = document.getElementById('starPicker');
const reviewRating = document.getElementById('reviewRating');
if (starPicker) {
  const stars = starPicker.querySelectorAll('svg');
  stars.forEach(star => {
    star.addEventListener('mouseenter', () => {
      const val = parseInt(star.dataset.rating);
      stars.forEach(s => {
        s.querySelector('path').setAttribute('fill', parseInt(s.dataset.rating) <= val ? '#EEAE0B' : '#E2E8F0');
      });
    });
    star.addEventListener('click', () => {
      reviewRating.value = star.dataset.rating;
    });
  });
  starPicker.addEventListener('mouseleave', () => {
    const val = parseInt(reviewRating.value) || 0;
    stars.forEach(s => {
      s.querySelector('path').setAttribute('fill', parseInt(s.dataset.rating) <= val ? '#EEAE0B' : '#E2E8F0');
    });
  });
}

// Review images
let reviewPageImages = [];
const reviewImagesInput = document.getElementById('reviewImagesInput');
const reviewImagesBrowseBtn = document.getElementById('reviewImagesBrowseBtn');
const reviewImagesPreview = document.getElementById('reviewImagesPreview');

if (reviewImagesBrowseBtn) {
  reviewImagesBrowseBtn.addEventListener('click', () => reviewImagesInput.click());
}
if (reviewImagesInput) {
  reviewImagesInput.addEventListener('change', (e) => {
    Array.from(e.target.files).forEach(file => {
      if (reviewPageImages.length >= 5) return;
      if (file.size > 2 * 1024 * 1024) { alert(file.name + ' is larger than 2MB.'); return; }
      if (!['image/jpeg','image/png','image/webp'].includes(file.type)) { alert(file.name + ' is not supported.'); return; }
      reviewPageImages.push(file);
    });
    renderReviewPageImages();
    e.target.value = '';
  });
}
function renderReviewPageImages() {
  if (!reviewImagesPreview) return;
  reviewImagesPreview.innerHTML = '';
  reviewPageImages.forEach((file, idx) => {
    const div = document.createElement('div');
    div.style.cssText = 'position:relative;width:60px;height:60px;border-radius:6px;overflow:hidden;border:1px solid #ddd;';
    const img = document.createElement('img');
    img.src = URL.createObjectURL(file);
    img.style.cssText = 'width:100%;height:100%;object-fit:cover;';
    const rm = document.createElement('button');
    rm.innerHTML = '&times;';
    rm.style.cssText = 'position:absolute;top:2px;right:2px;background:rgba(0,0,0,0.6);color:#fff;border:none;border-radius:50%;width:18px;height:18px;font-size:10px;cursor:pointer;display:flex;align-items:center;justify-content:center;';
    rm.addEventListener('click', () => { reviewPageImages.splice(idx, 1); renderReviewPageImages(); });
    div.appendChild(img);
    div.appendChild(rm);
    reviewImagesPreview.appendChild(div);
  });
}

// Submit review
const submitReviewBtn = document.getElementById('submitReviewBtn');
if (submitReviewBtn) {
  submitReviewBtn.addEventListener('click', () => {
    const rating = parseInt(reviewRating.value);
    const text = document.getElementById('reviewText').value.trim();
    const alertEl = document.getElementById('reviewFormAlert');

    if (!rating || rating < 1 || rating > 5) {
      alertEl.className = 'alert alert-danger';
      alertEl.textContent = 'Please select a rating.';
      alertEl.classList.remove('d-none');
      return;
    }
    if (!text) {
      alertEl.className = 'alert alert-danger';
      alertEl.textContent = 'Please write your review.';
      alertEl.classList.remove('d-none');
      return;
    }

    submitReviewBtn.disabled = true;
    submitReviewBtn.textContent = 'Submitting...';

    const formData = new FormData();
    formData.append('rating', rating);
    formData.append('text', text);
    reviewPageImages.forEach(file => formData.append('images[]', file));

    fetch('{{ route("product.review", $product->slug) }}', {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: formData
    })
    .then(r => r.json().then(body => ({ status: r.status, body })))
    .then(({ status, body }) => {
      if (status === 401) {
        alertEl.className = 'alert alert-danger';
        alertEl.innerHTML = 'Please <a href="{{ route("login") }}">login</a> to write a review.';
        alertEl.classList.remove('d-none');
        submitReviewBtn.disabled = false;
        submitReviewBtn.textContent = 'Submit Review';
      } else if (status === 403) {
        alertEl.className = 'alert alert-danger';
        alertEl.textContent = body.message || 'You must purchase this product to write a review.';
        alertEl.classList.remove('d-none');
        submitReviewBtn.disabled = false;
        submitReviewBtn.textContent = 'Submit Review';
      } else if (body.success) {
        const review = body.review;
        const svgTpl = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="13" viewBox="0 0 17 16" fill="none"><path d="M8.5 0.5L10.4084 6.37336L16.584 6.37336L11.5878 10.0033L13.4962 15.8766L8.5 12.2467L3.50383 15.8766L5.41219 10.0033L0.416019 6.37336L6.59163 6.37336L8.5 0.5Z" fill="FILL_COLOR"></path></svg>';
        const starsHtml = Array.from({length: 5}, (_, i) =>
          svgTpl.replace('FILL_COLOR', i < review.rating ? '#EEAE0B' : '#E2E8F0')
        ).join('');

        let imagesHtml = '';
        if (review.images && review.images.length > 0) {
          imagesHtml = '<div class="d-flex flex-wrap gap-2 mt-2">' +
            review.images.map(img => '<a href="' + '{{ asset("/") }}' + img + '" target="_blank"><img src="' + '{{ asset("/") }}' + img + '" alt="Review image" style="width:70px;height:70px;object-fit:cover;border-radius:6px;border:1px solid #ddd;"></a>').join('') +
            '</div>';
        }

        const html = `
          <div class="d-flex gap-3 mb-4 pb-3 border-bottom review-item" data-review-id="${review.id}">
            <div class="flex-shrink-0">
              <div class="rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 50px; height: 50px; background: var(--primary); font-weight: 600; font-size: 18px;">${review.name.charAt(0)}</div>
            </div>
            <div class="flex-grow-1">
              <div class="d-flex align-items-center gap-2 mb-1">
                <h6 class="mb-0 fw-semibold">${review.name}</h6>
                <small class="text-muted">${review.date}</small>
                <button type="button" class="btn btn-sm btn-outline-danger ms-auto delete-review-btn" data-review-id="${review.id}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Delete review" style="padding:2px 8px;font-size:12px;">
                  <i class="fas fa-trash"></i>
                </button>
              </div>
              <div class="mb-1">${starsHtml}</div>
              <p class="mb-0" style="color: #4c3533;">${review.text}</p>
              ${imagesHtml}
            </div>
          </div>`;

        const noMsg = document.getElementById('noReviewsMsg');
        if (noMsg) noMsg.remove();

        document.getElementById('reviewsList').insertAdjacentHTML('afterbegin', html);
        updateProductRating(body.rating, body.count);

        // Reset form
        document.getElementById('reviewText').value = '';
        reviewRating.value = 0;
        reviewPageImages = [];
        renderReviewPageImages();
        starPicker.querySelectorAll('svg').forEach(s => {
          s.querySelector('path').setAttribute('fill', '#E2E8F0');
        });
        alertEl.classList.add('d-none');
        submitReviewBtn.disabled = false;
        submitReviewBtn.textContent = 'Submit Review';

        // Update tab count
        document.getElementById('reviews-tab').textContent = `Reviews (${body.count})`;
      } else {
        alertEl.className = 'alert alert-danger';
        alertEl.textContent = body.message || 'You are not eligible to review this product.';
        alertEl.classList.remove('d-none');
        submitReviewBtn.disabled = false;
        submitReviewBtn.textContent = 'Submit Review';
      }
    })
    .catch(() => {
      alertEl.className = 'alert alert-danger';
      alertEl.textContent = 'Something went wrong. Please try again.';
      alertEl.classList.remove('d-none');
      submitReviewBtn.disabled = false;
      submitReviewBtn.textContent = 'Submit Review';
    });
  });
}

// Delete review
document.addEventListener('click', (e) => {
  const btn = e.target.closest('.delete-review-btn');
  if (!btn) return;
  if (!confirm('Are you sure you want to delete this review?')) return;

  const reviewId = btn.dataset.reviewId;
  btn.disabled = true;

  fetch('{{ route("product.review.delete", ["slug" => $product->slug, "reviewId" => "REVIEW_ID"]) }}'.replace('REVIEW_ID', reviewId), {
    method: 'DELETE',
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
      'X-Requested-With': 'XMLHttpRequest'
    }
  })
    .then(r => {
      return r.json().then(data => ({ status: r.status, data: data }));
    })
    .then(result => {
      if (result.status === 401) {
        alertEl.className = 'alert alert-danger';
        alertEl.innerHTML = 'Please <a href="' + window.loginUrl + '">login</a> to write a review.';
        alertEl.classList.remove('d-none');
        submitReviewBtn.disabled = false;
        submitReviewBtn.textContent = 'Submit Review';
      } else if (result.status === 403) {
        alertEl.className = 'alert alert-danger';
        alertEl.textContent = result.data.message || 'You must purchase this product to write a review.';
        alertEl.classList.remove('d-none');
        submitReviewBtn.disabled = false;
        submitReviewBtn.textContent = 'Submit Review';
      } else if (result.data.success) {
      const item = document.querySelector(`.review-item[data-review-id="${reviewId}"]`);
      if (item) {
        item.style.transition = 'opacity 0.3s';
        item.style.opacity = '0';
        setTimeout(() => item.remove(), 300);
      }
      updateProductRating(data.rating, data.count);
      document.getElementById('reviews-tab').textContent = `Reviews (${data.count})`;
    }
  })
  .catch(() => {
    btn.disabled = false;
  });
});

function updateProductRating(rating, count) {
  let container = document.getElementById('product-rating');
  if (!container) {
    if (!count) return;
    const stockP = document.querySelector('p.stock');
    if (!stockP) return;
    container = document.createElement('p');
    container.className = 'rating';
    container.id = 'product-rating';
    stockP.parentNode.appendChild(container);
  }
  const svgTemplate = '<svg xmlns="http://www.w3.org/2000/svg" width="17" height="16" viewBox="0 0 17 16" fill="none"><path d="M8.5 0.5L10.4084 6.37336L16.584 6.37336L11.5878 10.0033L13.4962 15.8766L8.5 12.2467L3.50383 15.8766L5.41219 10.0033L0.416019 6.37336L6.59163 6.37336L8.5 0.5Z" fill="FILL_COLOR"></path></svg>';
  const starsHtml = Array.from({length: 5}, (_, i) =>
    svgTemplate.replace('FILL_COLOR', i < rating ? '#EEAE0B' : '#E2E8F0')
  ).join('');
  container.innerHTML = starsHtml + ` <span>(${count})</span>`;
}

$(document).ready(function() {
  var galleryNav = new Swiper('#productGalleryNav', {
    slidesPerView: 4,
    spaceBetween: 10,
    allowTouchMove: false,
    centeredSlides: true,
    centeredSlidesBounds: true,
    breakpoints: {
      992: { slidesPerView: 3 },
      768: { slidesPerView: 2 },
    },
    navigation: {
        nextEl: '#productGalleryNav .swiper-button-next',
        prevEl: '#productGalleryNav .swiper-button-prev',
    },
  });

  var thumbSwiper = new Swiper('#productGallery', {
    slidesPerView: 1,
    spaceBetween: 0,
    effect: 'fade',
    fadeEffect: { crossFade: true },
    grabCursor: true,
    allowTouchMove: true,
    zoom: {
      maxRatio: 3,
      minRatio: 1,
    },
    thumbs: {
      swiper: galleryNav,
    },
  });

  function centerNavSlide(index) {
    var slide = galleryNav.slides[index];
    if (!slide) return;
    var slideLeft = slide.offsetLeft;
    var slideWidth = slide.offsetWidth;
    var containerWidth = galleryNav.el.offsetWidth;
    var offset = slideLeft - (containerWidth - slideWidth) / 2;
    offset = Math.max(0, Math.min(offset, galleryNav.wrapperEl.scrollWidth - containerWidth));
    galleryNav.wrapperEl.style.transition = 'transform 300ms ease';
    galleryNav.setTranslate(-offset);
  }

  galleryNav.on('click', function(swiper) {
    thumbSwiper.slideTo(swiper.clickedIndex);
  });

  thumbSwiper.on('slideChangeTransitionEnd', function() {
    centerNavSlide(thumbSwiper.activeIndex);
    resetZoom();
  });

  /* ── Amazon-style hover zoom (desktop only) ── */
  var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
  if (!isMobile && window.innerWidth > 991) {
    var wrapper = document.querySelector('.zoom-wrapper');
    var container = document.querySelector('.zoom-container');
    var lens = document.getElementById('zoomLens');
    var result = document.getElementById('zoomResult');
    if (!wrapper || !container || !lens || !result) return;

    var zoomFactor = 3;

    function updateZoom(e) {
      var activeSlide = thumbSwiper.slides[thumbSwiper.activeIndex];
      if (!activeSlide) return;
      var img = activeSlide.querySelector('img');
      if (!img) return;

      var rect = container.getBoundingClientRect();
      var x = e.clientX - rect.left;
      var y = e.clientY - rect.top;

      if (x < 0 || x > rect.width || y < 0 || y > rect.height) {
        resetZoom();
        return;
      }

      var lensX = x - lens.offsetWidth / 2;
      var lensY = y - lens.offsetHeight / 2;
      lens.style.left = lensX + 'px';
      lens.style.top = lensY + 'px';

      var bgW = rect.width * zoomFactor;
      var bgH = rect.height * zoomFactor;
      var bgX = -(x * zoomFactor - result.offsetWidth / 2);
      var bgY = -(y * zoomFactor - result.offsetHeight / 2);

      lens.style.backgroundImage = 'url(' + img.src + ')';
      lens.style.backgroundSize = bgW + 'px ' + bgH + 'px';
      lens.style.backgroundPosition = bgX + 'px ' + bgY + 'px';
      lens.style.display = 'block';

      result.style.backgroundImage = 'url(' + img.src + ')';
      result.style.backgroundSize = bgW + 'px ' + bgH + 'px';
      result.style.backgroundPosition = bgX + 'px ' + bgY + 'px';
      result.style.display = 'block';
    }

    function resetZoom() {
      lens.style.display = 'none';
      result.style.display = 'none';
    }

    wrapper.addEventListener('mousemove', updateZoom);
    wrapper.addEventListener('mouseleave', resetZoom);
  }
});
</script>
@endsection
