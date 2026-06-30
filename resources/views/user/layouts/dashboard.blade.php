@extends('layouts.app')

@section('content')
<section class="gs-dashboard-section py-5">
    <div class="container">
        <div class="row">

            @include('user.layouts.sidebar')

            <div class="col-lg-9">
                <div class="bg-white p-4 rounded shadow-sm">
                    @yield('dashboard-content')
                </div>
            </div>

        </div>
    </div>
</section>
@endsection