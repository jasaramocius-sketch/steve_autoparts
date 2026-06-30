@extends('user.layouts.dashboard')

@section('dashboard-content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">My Addresses</h4>
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addAddressModal">+ Add Address</button>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button class="btn-close" data-bs-dismiss="alert"></button></div>
@endif

@forelse($addresses as $address)
<div class="card mb-3">
    <div class="card-body d-flex justify-content-between align-items-start">
        <div>
            <h5 class="mb-1">{{ $address->full_name }}</h5>
            <p class="mb-1">{{ $address->address }}, {{ $address->city }}</p>
            <p class="mb-1">{{ $address->state ? $address->state . ', ' : '' }}{{ $address->country }} - {{ $address->zip_code }}</p>
            <p class="mb-0 text-muted">{{ $address->phone }}</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editAddressModal{{ $address->id }}">Edit</button>
            <form action="{{ route('user.addresses.destroy', $address->id) }}" method="POST" onsubmit="return confirm('Remove this address?')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger">Delete</button>
            </form>
        </div>
    </div>
</div>

<!-- Edit Address Modal -->
<div class="modal fade" id="editAddressModal{{ $address->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('user.addresses.update', $address->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title">Edit Address</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="full_name" class="form-control" value="{{ $address->full_name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ $address->phone }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="2" required>{{ $address->address }}</textarea>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">City</label>
                            <input type="text" name="city" class="form-control" value="{{ $address->city }}" required>
                        </div>
                        <div class="col">
                            <label class="form-label">State</label>
                            <input type="text" name="state" class="form-control" value="{{ $address->state }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Country</label>
                            <input type="text" name="country" class="form-control" value="{{ $address->country }}" required>
                        </div>
                        <div class="col">
                            <label class="form-label">Zip Code</label>
                            <input type="text" name="zip_code" class="form-control" value="{{ $address->zip_code }}" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Save Changes</button>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
@empty
<div class="card">
    <div class="card-body text-center py-5">
        <p class="text-muted mb-3">No addresses saved yet.</p>
    </div>
</div>
@endforelse

<!-- Add Address Modal -->
<div class="modal fade" id="addAddressModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('user.addresses.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title">Add Address</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="full_name" class="form-control" placeholder="John Doe" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" placeholder="+1 234 567 890" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="2" placeholder="123 Main St" required></textarea>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">City</label>
                            <input type="text" name="city" class="form-control" placeholder="New York" required>
                        </div>
                        <div class="col">
                            <label class="form-label">State</label>
                            <input type="text" name="state" class="form-control" placeholder="NY">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Country</label>
                            <input type="text" name="country" class="form-control" placeholder="USA" required>
                        </div>
                        <div class="col">
                            <label class="form-label">Zip Code</label>
                            <input type="text" name="zip_code" class="form-control" placeholder="10001" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Save</button>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection