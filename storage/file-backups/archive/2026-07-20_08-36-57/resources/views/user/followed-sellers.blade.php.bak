@extends('user.layouts.dashboard')

@section('dashboard-content')

<section>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-1">Followed Sellers</h3>
            <p class="text-muted mb-0">Manage the sellers you follow and view their profile summaries.</p>
        </div>
        <a href="{{ route('user.wishlist') }}" class="btn btn-outline-secondary">Back to Wishlist</a>
    </div>

    <div class="row g-4">
        @forelse($followedSellers as $seller)
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-start gap-3 mb-3">
                            <div class="avatar avatar-lg rounded-circle bg-light d-flex align-items-center justify-content-center" style="width:72px; height:72px;">
                                <span class="fs-4 text-primary">{{ strtoupper(substr($seller->seller_name, 0, 1)) }}</span>
                            </div>
                            <div>
                                <h5 class="mb-1">{{ $seller->seller_name }}</h5>
                                <p class="text-muted mb-0">{{ $seller->location }}</p>
                            </div>
                        </div>

                        <p class="text-secondary" style="line-height:1.6;">{{ $seller->description }}</p>

                        <div class="d-flex flex-wrap gap-3 mt-4">
                            <div class="badge bg-light text-dark p-2 rounded">
                                <strong>{{ $seller->products }}</strong> Products
                            </div>
                            <div class="badge bg-light text-dark p-2 rounded">
                                <strong>{{ number_format($seller->rating, 1) }}</strong> Rating
                            </div>
                            <div class="badge bg-light text-dark p-2 rounded">
                                <strong>{{ number_format($seller->followers) }}</strong> Followers
                            </div>
                        </div>

                        <div class="mt-4 d-flex gap-2">
                            <a href="javascript:;" class="btn btn-primary">View Seller</a>
                            <a href="javascript:;" class="btn btn-outline-danger">Unfollow</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    You are not following any sellers yet.
                </div>
            </div>
        @endforelse
    </div>
</section>

@endsection