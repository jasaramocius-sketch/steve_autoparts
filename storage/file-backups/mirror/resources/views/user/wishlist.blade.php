@extends('user.layouts.dashboard')
{{-- Add your custom page ID and classes right here --}}
@section('page-id', 'user-wishlist-page')
@section('page-class', 'user-wishlist-page')
@section('dashboard-content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">My Wishlist</h3>
    @if(count($wishlist) > 0)
    <form action="{{ route('wishlist.clear') }}" method="POST">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger btn-sm steve-btn">
            <i class="fas fa-trash"></i> Clear All
        </button>
    </form>
    @endif
</div>

<div class="row wishlist-page-products">    
    @forelse($wishlist as $item)
    <div class="wishlist-page-products-items">
        @php
            $product = $item->product ?? $item;
            $wishlistId = isset($item->id) ? $item->id : null;
        @endphp

        @include('partials.product-card', [
            'product' => $product,
            'wishlistItemId' => $wishlistId,
            'showRemoveWishlistIcon' => true,
            'colClass' => 'col-lg-4 col-md-6 mb-4',
        ])
    </div>
    @empty
    </div>
        <div class="col-12">
            <div class="alert alert-info">
                No products in wishlist.
            </div>
        </div>
    @endforelse

@endsection