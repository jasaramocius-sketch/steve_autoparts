@extends('layouts.app')

@section('content')

<h3>
    Welcome,
    {{ session('user_profile.name') }}
</h3>

<p>
    Role :
    {{ ucfirst(session('user_profile.role')) }}
</p>

@endsection