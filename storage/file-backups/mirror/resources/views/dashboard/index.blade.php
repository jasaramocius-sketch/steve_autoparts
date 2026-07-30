@extends('layouts.app')
{{-- Add your custom page ID and classes right here --}}
@section('page-id', 'dashboard-page')
@section('page-class', 'dashboard-page')    
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