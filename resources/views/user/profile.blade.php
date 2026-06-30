@extends('user.layouts.dashboard')

@section('dashboard-content')


<!-- Account Details Panel -->
<div class="acc-info-wrapper rounded p-4" style="background-color: #fcfbfb; border: 1px solid #eee;">
    <h4 style="color: #1f0300; font-weight: 600;" class="mb-3">Account Details</h4>
    <div class="list-wrapper">
    <div class="row w-100">
        <div class="col-md-6">
        <ul class="list-unstyled d-flex flex-column gap-2">
            <li><strong class="text-secondary" style="font-size: 14px;">Full Name:</strong> <span style="font-weight: 500;">{{ $profile['name'] }}</span></li>
            <li><strong class="text-secondary" style="font-size: 14px;">Email Address:</strong> <span style="font-weight: 500;">{{ $profile['email'] }}</span></li>
            <li><strong class="text-secondary" style="font-size: 14px;">Phone:</strong> <span style="font-weight: 500;">{{ $profile['phone'] }}</span></li>
        </ul>
        </div>
        <div class="col-md-6">
        <ul class="list-unstyled d-flex flex-column gap-2">
            <li><strong class="text-secondary" style="font-size: 14px;">Address:</strong> <span style="font-weight: 500;">{{ $profile['address'] }}</span></li>
            <li><strong class="text-secondary" style="font-size: 14px;">City:</strong> <span style="font-weight: 500;">{{ $profile['city'] }}</span></li>
            <li><strong class="text-secondary" style="font-size: 14px;">Country:</strong> <span style="font-weight: 500;">{{ $profile['country'] }}</span></li>
        </ul>
        </div>
    </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4>Profile Settings</h4>
    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('user.profile.update') }}"
              method="POST">

            @csrf

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label>Name</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           value="{{ session('user_profile.name') }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Email Address</label>
                    <input type="email"
                           name="email"
                           class="form-control"
                           value="{{ old('email', $profile->email) }}">
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label>Phone</label>
                    <input type="text"
                           name="phone"
                           class="form-control"
                           value="{{ session('user_profile.phone') }}">
                    @error('phone')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label>City</label>
                    <input type="text"
                           name="city"
                           class="form-control"
                           value="{{ session('user_profile.city') }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Country</label>
                    <input type="text"
                           name="country"
                           class="form-control"
                           value="{{ session('user_profile.country') }}">
                </div>

                <div class="col-md-12 mb-3">
                    <label>Address</label>
                    <textarea name="address"
                              class="form-control">{{ session('user_profile.address') }}</textarea>
                </div>

            </div>

            <button class="btn btn-primary">
                Update Profile
            </button>

        </form>

    </div>
    <div class="card mt-4">

        <div class="card-header">
            <h4>Change Password</h4>
        </div>

        <div class="card-body">

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('user.change.password.update') }}" method="POST">

                @csrf

                <div class="mb-3">
                    <label>Current Password</label>
                    <input type="password"
                        name="current_password"
                        class="form-control"
                        required>
                </div>

                <div class="mb-3">
                    <label>New Password</label>
                    <input type="password"
                        name="new_password"
                        class="form-control"
                        required>
                </div>

                <div class="mb-3">
                    <label>Confirm Password</label>
                    <input type="password"
                        name="new_password_confirmation"
                        class="form-control"
                        required>
                </div>

                <button type="submit"
                        class="btn btn-primary">
                    Change Password
                </button>

            </form>

        </div>

    </div>
</div>

@endsection