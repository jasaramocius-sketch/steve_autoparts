<?php $__env->startSection('page-id', 'auth-vendor-register-page'); ?>
<?php $__env->startSection('page-class', 'auth-vendor-register-page'); ?>
<?php $__env->startSection('page-title', 'Vendor Register - StAutoparts'); ?>
<?php $__env->startSection('content'); ?>

<!-- Banner Hero Section -->
<section class="gs-breadcrumb-section" style="background-image: url('<?php echo e(asset('assets/images/1724480495Imagexxxxxpng.png')); ?>'); background-size: cover; background-position: center;">
  <div class="container">
    <div class="content-wrapper">
      <h2 class="breadcrumb-title">Vendor Register</h2>
      <ul class="bread-menu">
        <li><a href="<?php echo e(route('home')); ?>">Home</a></li>
        <li><a href="#">Vendor Register</a></li>
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
          <h4 class="text-center">Create Vendor Account</h4>
          
          <?php if($errors->any()): ?>
            <div class="alert alert-danger"><?php echo e($errors->first()); ?></div>
          <?php endif; ?>

          <form action="<?php echo e(route('vendor.register.post')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="form-group">
              <label for="name">Full Name</label>
              <input type="text" name="name" class="form-control" id="name" placeholder="Enter your full name" required>

              <label for="email">Email Address</label>
              <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" required>
              
              <label for="create-password">Your Password</label>
              <div class="pass-wrapper" style="position:relative">
                <input type="password" name="password" class="form-control" id="create-password" placeholder="Enter your password" required>
                <span style="position:absolute;right:12px;top:50%;transform:translateY(-50%);cursor:pointer;z-index:5" onclick="togglePassword('create-password',this)">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                </span>
              </div>
            </div>
            
            <button type="submit" class="template-btn btn-forms steve-btn" style="background-color: var(--primary); border-color: var(--primary); color: #fff; font-weight: 500; border-radius: 4px;">Register</button>
            <p class="text-center login-or">Or</p>
            <br>
            <p class="login-redirect">Already have an account? <span><a href="<?php echo e(route('vendor.login')); ?>">Login Now</a></span></p>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
function togglePassword(id, btn) {
  var inp = document.getElementById(id);
  if (inp.type === 'password') { inp.type = 'text'; btn.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>'; }
  else { inp.type = 'password'; btn.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>'; }
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/stautoparts/resources/views/auth/vendor-register.blade.php ENDPATH**/ ?>