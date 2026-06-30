@extends('user.layouts.dashboard')

@section('dashboard-content')

<!-- Dashboard Section -->
<section>
  <div class="container">
    <!-- Expenditure Banner -->
    <div class="row mb-4">
      <div class="col-12">
        <div class="p-4 rounded" style="background-color: #e53914; color: #fff;">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <small style="opacity:0.9;">Total Expenditure</small>
              <h3 class="mb-0" style="font-weight:700;">{{ currency_format($total_spent ?? 0) }}</h3>
              <a href="{{ route('user.orders') }}" class="text-white mt-2 d-inline-block">View Order History &nbsp;&rsaquo;</a>
            </div>
            <div>
              <!-- optional icon -->
              <div style="width:64px; height:64px; background: rgba(255,255,255,0.12); border-radius:50%; display:flex; align-items:center; justify-content:center;">
                <i class="fas fa-dollar-sign" style="font-size: 24px;"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Info Cards Row -->
    <div class="dashboard-row dashboard-additional-block-2">
      <div class="dashboard-column dashboard-product-cart-count">
        <div style="font-weight:700;">{{ $cartCount ?? 0 }}</div>
        <small class="text-muted">Products in Cart</small>
      </div>
      <div class="dashboard-column dashboard-wishlist-column">
        <div style="font-weight:700;">
        {{ 
        (session('user_logged_in') ? \App\Models\Wishlist::where('user_id', session('user_profile.id'))->count() : count(session('guest_wishlist', [])))
        }}</div>
        <small class="text-muted">Wishlist</small>
      </div>	
      <div class="dashboard-column dashboard-orders-column">
        <div style="font-weight:700;">{{ $total_orders ?? 0 }}</div>
        <small class="text-muted">Total Ordered</small>
      </div>
      <div class="dashboard-column dashboard-other-column">
        <div style="font-weight:700;">0</div>
        <small class="text-muted">Other</small>
      </div>
    </div>
    <div class="dashboard-row dashboard-additional-block-3">
      <div class="dashboard-column dashboard-package-column">
        <div class="p-3 rounded bg-white border shadow-sm text-center">
          <h5 style="margin-top:10px; font-weight:700;">Purchased Package</h5>
          <p class="text-muted">Package Not Found</p>
          <a href="#" class="btn" style="background:#e53914;color:#fff;border-radius:30px;padding:10px 28px;">Upgrade Package</a>
        </div>
      </div>

      <div class="dashboard-column dashboard-shipping-column">
        <div class="p-3 rounded bg-white border shadow-sm text-center">
          <h5 style="margin-top:10px; font-weight:700;">Default Shipping Address</h5>
          <p class="text-muted">No default address found</p>
          <a href="{{ route('user.addresses') }}" class="btn btn-dark" style="border-radius:30px;padding:10px 24px;">Add New Address</a>
        </div>
      </div>
    </div>

    <!-- My Wishlist Thumbnails -->
    <div class="dashboard-row dashboard-wishlist-block-2">
      <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <h5 style="margin:0;">My Wishlist</h5>
          <a href="{{ route('user.wishlist') }}" class="text-danger">View All</a>
        </div>
        <div class="dashboard-inner-row dashboard-wishlist-thumbnails">
            @php
            $wishProducts = collect();
            if (session('user_logged_in') && session('user_profile.id')) {
              // keep wishlist models so we can access wishlist id for removal
              $wishProducts = \App\Models\Wishlist::with('product')
                ->where('user_id', session('user_profile.id'))
                ->latest()
                ->take(6)
                ->get();
            } else {
              $guest = session('guest_wishlist', []);
              if (!empty($guest)) {
                $wishProducts = \App\Models\Product::whereIn('id', $guest)->take(6)->get();
              }
            }
            @endphp

            @if($wishProducts->count() > 0)
            @foreach($wishProducts as $item)
                @php $product = $item->product ?? $item; $wishlistId = isset($item->id) ? $item->id : null; @endphp
                @include('partials.product-card', [
                  'product' => $product,
                  'wishlistItemId' => $wishlistId,
                  'colClass' => 'col-12 col-md-4',
                  'showCompareButton' => false,
                ])
            @endforeach
            @else
            <div class="col-12"><p class="text-muted">No wishlist items yet.</p></div>
            @endif
        </div>
      </div>
    </div>

    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    
</section>

<!-- <style>
  .gs-dashboard-user-sidebar-wrapper li a {
    color: #1f0300 !important;
    background: #ffffff !important;
    transition: all 0.3s ease;
  }
  .gs-dashboard-user-sidebar-wrapper li a:hover,
  .gs-dashboard-user-sidebar-wrapper li a.active {
    background: var(--primary) !important;
    color: #ffffff !important;
  }
  .gs-dashboard-user-sidebar-wrapper .p-4 img.image {
    border: 3px solid #fff3ec;
  }
  .gs-dashboard-user-sidebar-wrapper li a {
    padding: 12px 14px;
    border-radius: 6px;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .gs-dashboard-user-sidebar-wrapper li a .me-2 {
    width: 22px;
    text-align: center;
  }
  .gs-single-statatics {
    box-shadow: 0px 4px 15px rgba(0,0,0,0.02);
    transition: transform 0.3s ease;
  }
  .gs-single-statatics:hover {
    transform: translateY(-5px);
  }
  .ud-page-title-box h3 { color:#1f0300; font-weight:600; }
  .bg-light { background-color: #fcfbfb !important; }
</style> -->

@endsection
