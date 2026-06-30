@extends('layouts.app')
@section('title', ($product['name'] ?? Product) . ' - ' . config('app.name', 'StAutoparts'))
@section('content')

<!-- Banner Hero Section -->
<!-- <section class="gs-breadcrumb-section" style="background-image: url('{{ asset('assets/images/1724480495Imagexxxxxpng.png') }}'); background-size: cover; background-position: center;">
  <div class="container">
    <div class="content-wrapper">
      <h2 class="breadcrumb-title">{{ $product['name'] }}</h2>
      <ul class="bread-menu">
        <li><a href="{{ route('home') }}">Home</a></li>
        <li><a href="{{ route('shop') }}">Shop</a></li>
        <li><p class="active">{{ $product['name'] }}</p></li>
      </ul>
    </div>
  </div>
</section> -->

<!-- Main Product Details Area -->
<section class="single-product-details-content-wrapper" style="background-color: #F9F8F8;">
  <div class="container">
    
    <!-- Breadcrumb Area -->
    <ul class="product-breadcrumb mb-5 list-unstyled">
      <li><a href="{{ route('home') }}">Home</a></li>
      <li><a href="{{ route('shop') }}">Shop</a></li>
      <li><p class="active">{{ $product['name'] }}</p></li>
    </ul>

    <div class="row g-4">
      
      <!-- Gallery Left Column -->
      <div class="col-lg-6">
        <div class="gs-product-details-gallery-wrapper">
          @if($product['badge'])
            <div class="gal-badge">{{ $product['badge'] }}</div>
          @endif
          <div class="main-img-wrapper border rounded bg-white p-3">
            {!! imgTag('assets/images/thumbnails/' . basename($product['image']), $product['name'], 'main-img w-100 img-fluid', 'id="main-product-img"') !!}
          </div>
          <div class="product-page-product-nav-slider">
          @for($i=0; $i<4; $i++)
            <div>
              <div class="thumb-box border rounded bg-white p-2"
                  onclick="document.getElementById('main-product-img').src=this.querySelector('img').src;">
                  {!! imgTag('assets/images/thumbnails/' . basename($product['image']), '', 'nav-img') !!}
              </div>
            </div>
            @endfor
        </div>
        </div>
      </div>

      <!-- Info Right Column -->
      <div class="col-lg-6">
        <div class="product-info-wrapper ps-lg-4">
          <h3>{{ $product['name'] }}</h3>

          <div class="price-wrapper align-items-center mb-3">
            <h4 class="text-danger mb-0" style="font-size: 28px; font-weight: 600;">{{ currency_format($product['price']) }}</h4>
            @if($product['old_price'])
              <h5 class="mb-0 text-muted" style="font-size: 20px;"><del>{{ currency_format($product['old_price']) }}</del></h5>
            @endif
          </div>

          <div class="rating-wrapper d-flex align-items-center gap-2 mb-4">
            <div class="stars">
              @for($i=0; $i<5; $i++)
                <i class="{{ $i < floor($product['rating']) ? 'fas' : 'far' }} fa-star text-warning" style="font-size: 14px;"></i>
              @endfor
            </div>
            <span class="text-muted" style="font-size: 14px;">({{ $product['reviews'] }} Reviews)</span>
          </div>

          <hr>

          <div class="product-stocks-wraper mb-4">
            <ul class="list-unstyled mb-0">
              <li class="mb-2"><span><b>Availability :</b> <span class="text-success" style="font-weight: 600;">{{  $product['stock'] > 0 ? 'In Stock' : 'Out of Stock' }}</span></span></li>
              <li class="mb-2"><span><b>Estimated Shipping Time :</b> {{ '72hrs' }}</span></li>
              <li class="mb-2"><span><b>SKU :</b> WB44721Fdq{{ $product['id'] }}</span></li>
              @if(isset($product['category']) && $product['category'])
              <li class="mb-2"><span><b>Category :</b> <a href="{{ route('category', $product['category']['slug'] ?? $product['category']->slug) }}" style="color: var(--primary); font-weight: 600;">{{ $product['category']['name'] ?? $product['category']->name }}</a></span></li>
              @endif
            </ul>
          </div>

          <hr>

          <form action="{{ route('cart.add') }}" method="POST" class="mt-4">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product['id'] }}">
            <input type="hidden" name="product_name" value="{{ $product['name'] }}">
            <input type="hidden" name="product_price" value="{{ $product['price'] }}">
            <input type="hidden" name="product_image" value="{{ asset($product['image']) }}">

            <div class="mb-4">
              <div class="d-flex align-items-center gap-3 mb-3">
                <span class="varition-title" style="font-size: 16px; font-weight: 500; color: #1f0300;">Quantity :</span>
                <div class="product-input-wrapper border rounded overflow-hidden bg-white" style="display: flex; align-items: center;">
                  <button type="button" class="action-btn border-0" onclick="let q=document.getElementById('qty'); if(q.value>1)q.value--">-</button>
                  <input type="text" readonly class="qty-input" id="qty" name="qty" value="1" min="1" max="{{ $product['stock'] }}">
                  <button type="button" class="action-btn border-0" onclick="let q=document.getElementById('qty'); if(q.value<{{ $product['stock'] }})q.value++">+</button>
                </div>
              </div>

              <div class="d-flex gap-3">
                <button type="submit" class="btn text-white px-4" style="background-color: #030712; border-color: #030712; height: 50px; font-weight: 600; min-width: 50%; font-size: 16px; border-radius: 4px;">
                  Add to Cart
                </button>
                <button type="submit" name="buy_now" value="1" class="btn text-white px-4" style="background-color: var(--primary); border-color: var(--primary); height: 50px; font-weight: 600; min-width: 50%; font-size: 16px; border-radius: 4px;">
                  Buy Now
                </button>
              </div>
            </div>
          </form>

          <div class="wish-compare-report-wrapper d-flex gap-4 mt-4">
            <form action="{{ route('wishlist.add') }}" method="POST" class="wishlist-form d-inline">
                @csrf
              <input type="hidden" name="product_id" value="{{ $product->id }}">

              <?php
                $isWished = false;
                if (session('user_logged_in') && session('user_profile.id')) {
                  $isWished = \App\Models\Wishlist::where('user_id', session('user_profile.id'))
                    ->where('product_id', $product->id)
                    ->exists();
                } else {
                  $isWished = in_array($product->id, session('guest_wishlist', []));
                }
              ?>

              <button type="button"
                class="wishlist-btn link text-decoration-none d-flex align-items-center gap-2 border-0 bg-transparent">
                <i class="{{ $isWished ? 'fas' : 'far' }} fa-heart wish-icon"></i>
                <span>Add to Wishlist</span>
              </button>
            </form>
            <a href="javascript:;" data-href="{{ route('compare.add', ['product_id' => $product->id]) }}" class="compare_product link text-decoration-none d-flex align-items-center gap-2">
              <i class="fas fa-exchange-alt" style="font-size: 18px;"></i>
              <span class="title">Compare</span>
            </a>
            <a href="{{ route('login') }}" class="link text-decoration-none d-flex align-items-center gap-2">
              <i class="far fa-flag" style="font-size: 18px;"></i>
              <span class="title">Report This Item</span>
            </a>
          </div>

          <hr>

          <div class="share-links d-flex align-items-center gap-3 mb-4">
            <span style="font-weight: 500; font-size: 20px; color: #1f0300;">Share:</span>
            <div class="share-links-wrapper d-flex gap-2">
              <a href="https://facebook.com" target="_blank" class="d-flex align-items-center justify-content-center text-white" style="width: 36px; height: 36px; background-color: #3b5998; border-radius: 50%;"><i class="fab fa-facebook-f"></i></a>
              <a href="https://twitter.com" target="_blank" class="d-flex align-items-center justify-content-center text-white" style="width: 36px; height: 36px; background-color: #1da1f2; border-radius: 50%;"><i class="fab fa-twitter"></i></a>
              <a href="https://linkedin.com" target="_blank" class="d-flex align-items-center justify-content-center text-white" style="width: 36px; height: 36px; background-color: #0077b5; border-radius: 50%;"><i class="fab fa-linkedin-in"></i></a>
              <a href="https://whatsapp.com" target="_blank" class="d-flex align-items-center justify-content-center text-white" style="width: 36px; height: 36px; background-color: #25d366; border-radius: 50%;"><i class="fab fa-whatsapp"></i></a>
            </div>
          </div>

          <div class="store-seller-wrapper rounded mb-4">
            <span>Sold By : <b>Genius Store</b></span>
            <span>Total Items : <b>22</b></span>
            <div class="action-btns-wrapper">
              <button id="contact-seller-btn" data-logged-in="{{ session('user_logged_in') ? 'true' : 'false' }}">Contact Seller</button>
            </div>
          </div>

        </div>
      </div>

    </div>

    <!-- Description & Reviews Tabs -->
    <div class="tab-product-des-wrapper mt-5 pt-4">
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description-tab-pane" type="button" role="tab" aria-controls="description-tab-pane" aria-selected="true">Description</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="policy-tab" data-bs-toggle="tab" data-bs-target="#policy-tab-pane" type="button" role="tab" aria-controls="policy-tab-pane" aria-selected="false">Buy / Return Policy</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews-tab-pane" type="button" role="tab" aria-controls="reviews-tab-pane" aria-selected="false">Reviews ({{ $product['reviews'] }})</button>
        </li>
      </ul>
      <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active py-4" id="description-tab-pane" role="tabpanel" aria-labelledby="description-tab" tabindex="0">
          <p style="line-height: 1.8; color: #4c3533;">{{ $product['description'] ?? 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.' }}</p>
          <h5 class="mt-4 mb-3" style="font-weight: 600;">Key Features:</h5>
          <ul style="line-height: 1.8; color: #4c3533; padding-left: 20px;">
            <li>Exact Fit: Built to match OEM specifications, making installation smooth and hassle-free.</li>
            <li>Enhanced Durability: Constructed from heat-resistant material for longer lifespan and reduced wear.</li>
            <li>Improved Performance: Engineered to provide optimal efficiency and safety compliance.</li>
          </ul>
        </div>
        <div class="tab-pane fade py-4" id="policy-tab-pane" role="tabpanel" aria-labelledby="policy-tab" tabindex="0">
          <div style="line-height: 1.8; color: #4c3533;">
            <p>Thank you for shopping with us! We are committed to a fair and transparent shopping experience. If you are not satisfied with your purchase, we offer a straightforward return policy to ensure your peace of mind.</p>
            <h5 class="mt-3 mb-2" style="font-weight: 600;">1. Purchasing Policy</h5>
            <p>- Order Confirmation: You will receive an email confirmation after placing your order.</p>
            <p>- Payment: Full payment is required to process and ship your order.</p>
            <h5 class="mt-3 mb-2" style="font-weight: 600;">2. Return and Exchange Policy</h5>
            <p>- Returns are accepted within 30 days of delivery for unused items in original packaging.</p>
            <p>- Refunds will be processed within 5-7 business days after we receive the returned item.</p>
          </div>
        </div>
        <div class="tab-pane fade py-4" id="reviews-tab-pane" role="tabpanel" aria-labelledby="reviews-tab" tabindex="0">
          <div class="review-tab-content-wrapper bg-white p-4 rounded border">
            @php
              $dummyReviews = [
                ['name' => 'John D.', 'rating' => 5, 'date' => '2026-05-15', 'text' => 'Excellent product! Fits perfectly on my 2025 Honda Accord. Highly recommend this to anyone looking for quality auto parts.'],
                ['name' => 'Sarah M.', 'rating' => 4, 'date' => '2026-05-10', 'text' => 'Good quality and fast shipping. The part was exactly as described. Would buy again.'],
                ['name' => 'Mike R.', 'rating' => 5, 'date' => '2026-04-28', 'text' => 'Great value for money. Installation was straightforward and the quality is top-notch.'],
                ['name' => 'Emily K.', 'rating' => 4, 'date' => '2026-04-20', 'text' => 'Very satisfied with the purchase. The customer service was also very helpful.'],
                ['name' => 'David L.', 'rating' => 5, 'date' => '2026-04-12', 'text' => 'Perfect fit and durable material. Exceeded my expectations!'],
              ];
            @endphp
            @foreach($dummyReviews as $review)
              <div class="d-flex gap-3 mb-4 pb-3 border-bottom">
                <div class="flex-shrink-0">
                  <div class="rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 50px; height: 50px; background: var(--primary); font-weight: 600; font-size: 18px;">{{ substr($review['name'], 0, 1) }}</div>
                </div>
                <div class="flex-grow-1">
                  <div class="d-flex align-items-center gap-2 mb-1">
                    <h6 class="mb-0 fw-semibold">{{ $review['name'] }}</h6>
                    <small class="text-muted">{{ $review['date'] }}</small>
                  </div>
                  <div class="mb-1">
                    @for($i = 1; $i <= 5; $i++)
                      <i class="fa fa-star{{ $i <= $review['rating'] ? ' text-warning' : '-o text-muted' }}"></i>
                    @endfor
                  </div>
                  <p class="mb-0" style="color: #4c3533;">{{ $review['text'] }}</p>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>

  </div>
</section>

<!-- Related Products Area -->
@if(isset($related) && $related->count() > 0)
<section class="gs-product-cards-slider-area" style="background-color: #ffffff;">
  <div class="container">
    <div class="title text-center mb-5">
      <h3 style="font-weight: 600;">Related Products</h3>
      <p class="text-muted">Explore other premium products in this category</p>
    </div>
    <div class="row g-4">
      @foreach($related as $rel)
        <div class="col-md-6 col-lg-3">
          <div class="single-product h-100 shadow-sm border rounded overflow-hidden">
            <div class="img-wrapper">
              <form action="{{ route('wishlist.add') }}" method="POST" class="wishlist-form">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button type="button" class="add-to-wishlist-btn wishlist-btn border-0 bg-transparent">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9932 5.13581C9.9938 2.7984 6.65975 2.16964 4.15469 4.31001C1.64964 6.45038 1.29697 10.029 3.2642 12.5604C4.89982 14.6651 9.84977 19.1041 11.4721 20.5408C11.6536 20.7016 11.7444 20.7819 11.8502 20.8135C11.9426 20.8411 12.0437 20.8411 12.1361 20.8135C12.2419 20.7819 12.3327 20.7016 12.5142 20.5408C14.1365 19.1041 19.0865 14.6651 20.7221 12.5604C22.6893 10.029 22.3797 6.42787 19.8316 4.31001C17.2835 2.19216 13.9925 2.7984 11.9932 5.13581Z" stroke="#030712" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                </button>
              </form>
              <div class="product-badges-category">
                @if($rel['badge'])
                  <span class="product-badge">{{ $rel['badge'] }}</span>
                @endif
                @if($rel->relationLoaded('category') && $rel['category'])
                  <!-- <span class="product-badge product-cat">{{ $rel['category']->name }}</span> -->
                @endif
              </div>
              {!! imgTag('assets/images/thumbnails/' . basename($rel['image']), $rel['name'], 'product-img') !!}
              <div class="add-to-cart">
                <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                  @csrf
                  <input type="hidden" name="product_id" value="{{ $rel['id'] }}">
                  <input type="hidden" name="product_name" value="{{ $rel['name'] }}">
                  <input type="hidden" name="product_price" value="{{ $rel['price'] }}">
                  <input type="hidden" name="product_image" value="{{ asset($rel['image']) }}">
                </form>
                <a href="javascript:void(0)" class="compare compare_product" data-href="{{ route('compare.add', ['product_id' => $rel['id']]) }}">
                  <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                      <path d="M18.1777 8C23.2737 8 23.2737 16 18.1777 16C13.0827 16 11.0447 8 5.43875 8C0.85375 8 0.85375 16 5.43875 16C11.0447 16 13.0828 8 18.1788 8H18.1777Z" stroke="#030712" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                </a>
                <a href="javascript:void(0)" class="add-cart border-0">Add to Cart</a>  
                <a href="{{ route('product', $rel['slug']) }}" class="details">
                  <span class="icon"><i class="fas fa-eye text-dark"></i></span>
                </a>
              </div>
            </div>
            <div class="content-wrapper">
              <h5 class="product-title mb-2">
                <a href="{{ route('product', $rel['slug']) }}" class="text-decoration-none">{{ $rel['name'] }}</a>
              </h5>
              <div class="price-wrapper mb-2">
                <h4>{{ currency_format($rel['price']) }}</h4>
                @if($rel['old_price'])
                  <h4><del>{{ currency_format($rel['old_price']) }}</del></h4>
                @endif
              </div>
              <div class="ratings-wrapper">
                <div class="stars me-1">
                  @for($i=0; $i<5; $i++)
                    <i class="{{ $i < floor($rel['rating']) ? 'fas' : 'far' }} fa-star text-warning" style="font-size: 11px;"></i>
                  @endfor
                </div>
                <span class="rating-title">({{ $rel['reviews'] }})</span>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif
<!-- Contact Seller Modal -->
<div class="modal fade" id="contactSellerModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('contact.seller') }}" method="POST" id="contactSellerForm">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product['id'] }}">
        <div class="modal-header">
          <h5 class="modal-title">Contact Seller</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
          @endif
          <div class="mb-3">
            <label class="form-label">Name *</label>
            <input type="text" name="name" class="form-control" required maxlength="255" value="{{ old('name') }}">
            @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
          </div>
          <div class="mb-3">
            <label class="form-label">Email *</label>
            <input type="email" name="email" class="form-control" required maxlength="255" value="{{ old('email') }}">
            @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
          </div>
          <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" maxlength="20" value="{{ old('phone') }}">
          </div>
          <div class="mb-3">
            <label class="form-label">Message *</label>
            <textarea name="message" class="form-control" required rows="4" maxlength="2000">{{ old('message') }}</textarea>
            @error('message') <div class="text-danger small">{{ $message }}</div> @enderror
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn text-white" style="background-color:var(--primary);">Send Message</button>
        </div>
      </form>
    </div>
  </div>
</div>

@section('scripts')
<script>
document.getElementById('contact-seller-btn')?.addEventListener('click', function() {
  var modal = new bootstrap.Modal(document.getElementById('contactSellerModal'));
  modal.show();
});
</script>
@endsection

<style>
  .product-nav-slider .slick-slide{
    margin:0 5px;
}

.product-nav-slider img{
    border-radius:8px;
}

.product-nav-slider .slick-track{
    display:flex !important;
}
</style>
@endsection
