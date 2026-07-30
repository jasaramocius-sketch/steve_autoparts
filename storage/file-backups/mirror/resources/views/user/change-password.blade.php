@extends('user.layouts.dashboard')
{{-- Add your custom page ID and classes right here --}}
@section('page-id', 'user-password-page')
@section('page-class', 'user-password-page')
@section('dashboard-content')

<form action="{{ route('user.change.password.update') }}" method="POST">
@csrf

<input type="password"
name="current_password"
class="form-control mb-3"
placeholder="Current Password" required>

<input type="password"
name="new_password"
class="form-control mb-3"
placeholder="New Password" required>

<input type="password"
name="new_password_confirmation"
class="form-control mb-3"
placeholder="Confirm Password" required>

<button class="btn btn-primary steve-btn">
Update Password
</button>

</form>
@endsection