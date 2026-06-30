@extends('layouts.app')
@section('title', 'Checkout' . ' - ' . config('app.name', 'StAutoparts'))
@section('content')

<!-- Banner Hero Section -->
<section class="gs-breadcrumb-section" style="background-image: url('{{ asset('assets/images/1724480495Imagexxxxxpng.png') }}'); background-size: cover; background-position: center;">
  <div class="container">
    <div class="content-wrapper">
      <h2 class="breadcrumb-title">Checkout</h2>
      <ul class="bread-menu">
        <li><a href="{{ route('home') }}">Home</a></li>
        <li><a href="{{ route('cart') }}">Cart</a></li>
        <li><a href="#">Checkout</a></li>
      </ul>
    </div>
  </div>
</section>

<section class="gs-checkout-section pt-5 pb-5">
  <div class="container">
    <form action="{{ route('checkout.submit') }}" method="POST">
      @csrf
      <div class="row">
        <!-- Billing Details Column -->
        <div class="col-lg-8">
          <div class="billing-details-area shadow-sm p-4 rounded bg-white">
            <h4 class="mb-4" style="color: #1f0300; font-weight: 600;">Billing Details</h4>
            <div class="row">
              <div class="col-md-6 mb-3">
                <div class="input-wrapper">
                  <label class="label-cls" for="name">Full Name *</label>
                  <input type="text" id="name" name="name" class="form-control input-cls @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="John Doe" required>
                  @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <div class="input-wrapper">
                  <label class="label-cls" for="email">Email Address *</label>
                  <input type="email" id="email" name="email" class="form-control input-cls @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="{{ example@mail.com }}" required>
                  @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <div class="input-wrapper">
                  <label class="label-cls" for="phone">Phone *</label>
                  <input type="text" id="phone" name="phone" class="form-control input-cls @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="{{ +1 (234) 567-890 }}" required>
                  @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <div class="col-md-6 mb-3">
                <div class="input-wrapper">
                  <label class="label-cls" for="country">Country *</label>
                  <input type="text" id="country" name="country" class="form-control input-cls @error('country') is-invalid @enderror" value="{{ old('country', 'United States') }}" placeholder="United States" required>
                  @error('country')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <div class="col-md-6 mb-3">
                <div class="input-wrapper">
                  <label class="label-cls" for="city">City *</label>
                  <input type="text" id="city" name="city" class="form-control input-cls @error('city') is-invalid @enderror" value="{{ old('city') }}" placeholder="New York" required>
                  @error('city')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <div class="col-md-6 mb-3">
                <div class="input-wrapper">
                  <label class="label-cls" for="address">Address *</label>
                  <input type="text" id="address" name="address" class="form-control input-cls @error('address') is-invalid @enderror" value="{{ old('address') }}" placeholder="{{ 123 Street Name, Suite 100 }}" required>
                  @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Order Summary Column -->
        <div class="col-lg-4">
          <div class="summary-box rounded shadow-sm">
            <h4 class="summary-title" style="color: #1f0300; font-weight: 600; border-bottom: 2px solid #e9e6e6; padding-bottom: 10px;">Order Summary</h4>
            
            <div class="details-wrapper">
              <!-- Itemized List -->
              @foreach($cart as $item)
              <div class="price-details py-2" style="border-bottom: 1px solid #e9e6e6;">
                <span class="left-side" style="max-width: 70%; font-size: 15px; color: #4c3533;">{{ $item['name'] }} <strong style="color: var(--primary);">x{{ $item['qty'] }}</strong></span>
                <span class="right-side" style="font-weight: 500;">{{ currency_format($item['price'] * $item['qty']) }}</span>
              </div>
              @endforeach

              <div class="price-details pt-3">
                <span>Subtotal</span>
                <span class="right-side font-weight-bold">{{ currency_format($total) }}</span>
              </div>
              <div class="price-details">
                <span>Shipping</span>
                <span class="right-side text-success" style="font-weight: 500;">Free Shipping</span>
              </div>

              <div class="final-price pt-3" style="border-top: 2px solid #e9e6e6; margin-top: 15px;">
                <span>Total</span>
                <span class="total-amount">{{ currency_format($total) }}</span>
              </div>
            </div>

            <!-- Payment Simulation Note -->
            <div class="alert alert-info mt-3" style="background-color: #fcf8f3; border-color: #faebcc; color: #8a6d3b; font-size: 13px; border-radius: 4px; padding: 10px;">
              <i class="fas fa-info-circle me-1"></i> Cash on Delivery is pre-selected for this simulation.
            </div>

            <div class="btn-wrappers mt-4">
              <button type="submit" class="template-btn w-100" style="background-color: var(--primary); border-color: var(--primary); color: #fff; height: 50px; font-weight: 600; border-radius: 4px; display: flex; align-items: center; justify-content: center; border: none; cursor: pointer; text-transform: uppercase;">
                Place Order
              </button>
              <a href="{{ route('cart') }}" class="text-center d-block text-secondary" style="font-size: 14px; text-decoration: underline;">
                Continue Shopping
              </a>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</section>

@endsection
