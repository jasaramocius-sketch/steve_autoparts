@extends('layouts.app')
{{-- Add your custom page ID and classes right here --}}
@section('page-id', 'cart-page')
@section('page-class', 'cart-page')
@section('title', 'Cart' . ' - ' . config('app.name', 'StAutoparts'))
@section('content')

<!-- Banner Hero Section -->
<section class="gs-breadcrumb-section" style="background-image: url('{{ asset('assets/images/1724480495Imagexxxxxpng.png') }}'); background-size: cover; background-position: center;">
  <div class="container">
    <div class="content-wrapper">
      <h2 class="breadcrumb-title">Cart</h2>
      <ul class="bread-menu">
        <li><a href="{{ route('home') }}">Home</a></li>
        <li style="color: var(--primary)">Cart</li>
      </ul>
    </div>
  </div>
</section>

<!-- Cart Section -->
<section class="gs-cart-section">
  <div class="container gs-cart-container">
    @if(count($cart) > 0)
    <div class="row gs-cart-row">
      <!-- Cart Table Column -->
      <div class="col-lg-8">
        <div class="cart-table">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <div>
              <button type="button" id="remove-selected" class="btn btn-sm btn-danger" disabled data-confirm-msg="Remove :count item(s) from cart?">
                <i class="fas fa-trash-alt"></i> Remove Selected
              </button>
            </div>
            <form action="{{ route('cart.removeSelected') }}" method="POST" id="bulk-remove-form">
              @csrf
              <input type="hidden" name="product_ids" id="selected-product-ids">
            </form>
          </div>
          <table class="table">
            <thead>
              <tr>
                <th scope="col" style="width: 40px;">
                  <input type="checkbox" id="select-all">
                </th>
                <th scope="col">Product</th>
                <th scope="col">Price</th>
                <th scope="col">Quantity</th>
                <th scope="col">Subtotal</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($cart as $item)
              <tr class="cart-item" data-id="{{ $item['id'] }}">
                <td>
                  <input type="checkbox" class="cart-checkbox" value="{{ $item['id'] }}">
                </td>
                <td class="cart-product-area">
                  <div class="cart-product d-flex align-items-center">
                    {!! imgTag('assets/images/thumbnails/' . basename($item['image']), $item['name'], 'product-img') !!}
                    <div class="cart-product-info">
                      <a href="/stautoparts/item/{{ $item['id'] }}" class="cart-title d-inline-block">{{ $item['name'] }}</a>
                    </div>
                  </div>
                </td>
                <td>
                  <span class="cart-price">{{ currency_format($item['price']) }}</span>
                </td>
                <td class="cart-quantity-col">
                  <div class="cart-quantity d-flex align-items-center justify-content-center">
                    <button type="button" class="btn cart-quantity-btn quantity-down change-qty" data-action="decrease">-</button>
                    <input type="text" class="borderless qty-input" value="{{ $item['qty'] }}" readonly>
                    <button type="button" class="btn cart-quantity-btn quantity-up change-qty" data-action="increase">+</button>
                  </div>
                </td>
                <td>
                  <span class="cart-price subtotal-val" id="prc{{ $item['id'] }}">{{ currency_format($item['price'] * $item['qty']) }}</span>
                </td>
                <td class="table-action-col">
                  <form action="{{ route('cart.remove') }}" method="POST" class="d-inline">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                    <button type="submit" class="border-0 bg-transparent text-dark" style="cursor: pointer; font-size: 18px;">
                      <i class="fas fa-trash-alt"></i>
                    </button>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

      <!-- Cart Summary Column -->
      <div class="col-lg-4">
        <div class="cart-summary">
          <h4 class="cart-summary-title">Cart Summary</h4>
          <div class="cart-summary-content">
            <div class="cart-summary-item d-flex justify-content-between">
              <span class="cart-summary-subtitle">SUBTOTAL</span>
              <span class="cart-summary-price total-cart-price-sub">{{ currency_format($total) }}</span>
            </div>
            <div class="cart-summary-item d-flex justify-content-between">
              <span class="cart-summary-subtitle">Discount</span>
              <span class="cart-summary-price">{{ currency_format(0) }}</span>
            </div>
            <div class="cart-summary-item d-flex justify-content-between">
              <span class="cart-summary-subtitle">Total</span>
              <span class="cart-summary-price total-cart-price total-cart-price-val">{{ currency_format($total) }}</span>
            </div>
          </div>
          <div class="cart-summary-btn">
            <a href="{{ route('checkout') }}" class="template-btn w-100 btn-checkout" style="background-color: var(--primary); border-color: var(--primary); color: #fff; height: 50px; font-weight: 500; border-radius: 4px; display: flex; align-items: center; justify-content: center; text-decoration: none;">Proceed To Checkout</a>
          </div>
        </div>
      </div>
    </div>
    @else
    <!-- Empty Cart Section -->
    <div class="row">
      <div class="col-md-12 text-center py-5">
        <div class="empty-cart-icon mb-4">
          <i class="fas fa-shopping-cart" style="font-size: 5rem; color: #ddd;"></i>
        </div>
        <h4 class="text-muted mb-4">Your cart is empty.</h4>
        <a href="{{ route('shop') }}" class="template-btn" style="background-color: var(--primary); border-color: var(--primary); color: #fff; padding: 12px 30px; font-weight: 600; border-radius: 4px; text-decoration: none; display: inline-block; line-height: 1.2rem; height: auto;">Shop Now</a>
      </div>
    </div>
    @endif
  </div>
</section>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
  const $selectAll = $('#select-all');
  const $checkboxes = $('.cart-checkbox');
  const $removeBtn = $('#remove-selected');

  $selectAll.on('change', function() {
    $checkboxes.prop('checked', this.checked);
    toggleRemoveBtn();
  });

  $checkboxes.on('change', function() {
    const allChecked = $checkboxes.length === $checkboxes.filter(':checked').length;
    $selectAll.prop('checked', allChecked);
    toggleRemoveBtn();
  });

  function toggleRemoveBtn() {
    $removeBtn.prop('disabled', $checkboxes.filter(':checked').length === 0);
  }

  $removeBtn.on('click', function() {
    const ids = $checkboxes.filter(':checked').map(function() {
      return $(this).val();
    }).get();

    if (ids.length === 0) return;

    const msg = "Remove :count item(s) from cart?" .replace(':count', ids.length);
    if (confirm(msg)) {
      $('#selected-product-ids').val(JSON.stringify(ids));
      $('#bulk-remove-form').submit();
    }
  });
});
</script>
@endsection
