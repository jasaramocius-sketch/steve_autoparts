@extends('layouts.app')
@section('title', 'Rider Register - StAutoparts')
@section('content')

<!-- Banner Hero Section -->
<section class="gs-breadcrumb-section" style="background-image: url('{{ asset('assets/images/1724480495Imagexxxxxpng.png') }}'); background-size: cover; background-position: center;">
  <div class="container">
    <div class="content-wrapper">
      <h2 class="breadcrumb-title">Rider Register</h2>
      <ul class="bread-menu">
        <li><a href="{{ route('home') }}">Home</a></li>
        <li><a href="#">Rider Register</a></li>
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
          <h4 class="text-center">Create Rider Account</h4>
          
          @if($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
          @endif

          <form action="{{ route('rider.register.post') }}" method="POST">
            @csrf
            <div class="form-group">
              <label for="name">Full Name</label>
              <input type="text" name="name" class="form-control" id="name" placeholder="Enter your full name" required>

              <label for="email">Email Address</label>
              <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" required>
              
              <label for="create-password">Your Password</label>
              <div class="pass-wrapper">
                <input type="password" name="password" class="form-control" id="create-password" placeholder="Enter your password" required>
              </div>
            </div>
            
            <button type="submit" class="template-btn btn-forms" style="background-color: var(--primary); border-color: var(--primary); color: #fff; height: 50px; font-weight: 500; border-radius: 4px;">Register</button>
            <p class="text-center login-or">Or</p>
            <br>
            <p class="login-redirect">Already have an account? <span><a href="{{ route('rider.login') }}">Login Now</a></span></p>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection
