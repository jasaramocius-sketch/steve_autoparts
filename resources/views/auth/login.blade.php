@extends('layouts.app')
@section('title', 'Login - StAutoparts')
@section('content')

<!-- Banner Hero Section -->
<!-- <section class="gs-breadcrumb-section" style="background-image: url('{{ asset('assets/images/1724480495Imagexxxxxpng.png') }}'); background-size: cover; background-position: center;">
  <div class="container">
    <div class="content-wrapper">
      <h2 class="breadcrumb-title">Customer Login</h2>
      <ul class="bread-menu">
        <li><a href="{{ route('home') }}">Home</a></li>
        <li style="color: #fff;">Customer Login</li>
      </ul>
    </div>
  </div>
</section> -->

<!-- Login Form Section -->
<section class="gs-reg-section">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 mx-auto reg-area">
        <div class="reg-content">
          <h4 class="text-center">Welcome Back</h4>
          
          @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
          @endif
          @if($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
          @endif

          <form action="{{ route('login.submit') }}" method="POST">
            @csrf
            
            @if(request()->query('redirect'))
              <input type="hidden" name="redirect" value="{{ request()->query('redirect') }}">
            @endif

            <div class="form-group">
              <label for="email">Email Address</label>
              <input type="email" name="email" class="form-control" value="" id="email" placeholder="Enter your email" required>
              
              <label for="create-password">Password</label>
              <div class="pass-wrapper">
                <input type="password" name="password" class="form-control" value="" id="create-password" placeholder="Enter your password" required>
              </div>
            </div>
            
            <div class="row mb-1 mt-2">
              <div class="col d-flex">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="remember_me">
                  <label class="form-check-label" for="remember_me">Remember Me</label>
                </div>
              </div>
              <div class="col d-flex justify-content-end login-forgot">
                <a href="javascript:void(0)" onclick="toastr.info('Password reset is not enabled for local testing.')">Forgot Password?</a>
              </div>
            </div>
            
            <button type="submit" class="template-btn btn-forms" style="background-color: var(--primary); border-color: var(--primary); color: #fff; height: 50px; font-weight: 500; border-radius: 4px;">Sign In</button>
            <p class="text-center login-or">Or</p>
            <br>
            <p class="login-redirect">Don't have an account? <span><a href="{{ route('register') }}">Register Now</a></span></p>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection
