@extends('admin.layouts.app')
{{-- Add your custom page ID and classes right here --}}
@include('partials.page-attributes', ['pageId' => 'admin-customers-create-page', 'pageClass' => 'admin-customers-create-page'])
@section('page-title', isset($user) ? 'Edit User' : 'Add Customer')
@section('content')

<div class="container-fluid">

<div class="card shadow">

    <!-- <div class="card-header">
        <h3>Add Customer</h3>
    </div> -->

    <div class="card-body">

        <form action="{{ route('admin.customers.store') }}" method="POST">

            @csrf

            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label>Phone</label>
                <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" inputmode="numeric" value="{{ old('phone') }}">
                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-select @error('status') is-invalid @enderror">
                    <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                @include('partials.address-fields', [
                    'prefix' => 'customer_form',
                    'withPhone' => false,
                    'withFullName' => false,
                    'withDefault' => false,
                    'zipName' => 'postal_code',
                    'required' => [],
                ])
            </div>

            <button class="btn btn-success steve-btn">Save</button>
            <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary">Back</a>

        </form>

    </div>

</div>

</div>

@endsection
