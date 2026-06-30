@extends('layouts.app')
@section('title', 'Register - StAutoparts')
@section('content')

<!-- Banner Hero Section -->
<section class="gs-breadcrumb-section" style="background-image: url('{{ asset('assets/images/1724480495Imagexxxxxpng.png') }}'); background-size: cover; background-position: center;">
  <div class="container">
    <div class="content-wrapper">
      <h2 class="breadcrumb-title">Sign Up</h2>
      <ul class="bread-menu">
        <li><a href="{{ route('home') }}">Home</a></li>
        <li><a href="#">Sign Up</a></li>
      </ul>
    </div>
  </div>
</section>

<!-- Register Form Section -->
<section class="gs-reg-section">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 mx-auto reg-area">
        <div class="reg-content">
          <h4 class="text-center">Create your account</h4>
          
          @if($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
          @endif

          <form action="{{ route('register.post') }}" method="POST">
            @csrf
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" name="name" class="form-control" id="name" placeholder="Enter your full name" value="{{ old('name') }}" required>

              <label for="email">Email Address</label>
              <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" value="{{ old('email') }}" required>
            
                <label for="create-password">Password</label>
                <div class="pass-wrapper">
                    <input type="password" name="password" class="form-control" id="create-password" placeholder="Enter your password" required>
                </div>
                <label for="confirm-password">Confirm Password</label>
                <div class="pass-wrapper">
                    <input type="password" name="password_confirmation" class="form-control" id="confirm-password" placeholder="Confirm your password" required>
                </div>
            </div>
            <br>
            <button type="submit" class="template-btn btn-forms" style="background-color: var(--primary); border-color: var(--primary); color: #fff; height: 50px; font-weight: 500; border-radius: 4px;">Register Now</button>
            <p class="text-center login-or">Or</p>
            <br>
            <p class="login-redirect">Already have an account? <span><a href="{{ route('login') }}">Sign In</a></span></p>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection
