@extends('user.layouts.dashboard')

@section('dashboard-content')

<form>

<input type="password"
class="form-control mb-3"
placeholder="Current Password">

<input type="password"
class="form-control mb-3"
placeholder="New Password">

<input type="password"
class="form-control mb-3"
placeholder="Confirm Password">

<button class="btn btn-primary">
Update Password
</button>

</form>
@endsection