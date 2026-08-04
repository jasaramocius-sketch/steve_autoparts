<?php $__env->startSection('page-id', 'blog-page'); ?>
<?php $__env->startSection('page-class', 'blog-page'); ?>
<?php $__env->startSection('title', (isset($category) ? $category->name : 'Blogs') . ' - ' . config('app.name', 'StAutoparts')); ?>

<?php $__env->startSection('content'); ?>

<!-- Breadcrumb -->
<section class="gs-breadcrumb-section" style="background-image: url('<?php echo e(asset('assets/images/1724480495Imagexxxxxpng.png')); ?>'); background-size: cover; background-position: center;">
  <div class="container">
    <div class="row justify-content-center content-wrapper">
      <div class="col-12">
        <h2 class="breadcrumb-title">Blog</h2>
        <ul class="bread-menu">
          <li><a href="<?php echo e(route('home')); ?>">Home</a></li>
          <li style="color: var(--primary)">Blog</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- Blog Wrapper -->
<div class="gs-blog-wrapper">
  <div class="container">
    <div class="row flex-lg-row">

      <!-- Sidebar (first in DOM for mobile stacking) -->
      <div class="col-12 col-lg-4 mt-lg-0">
        <div class="blog-sidebar-overlay"></div>
        <div class="gs-blog-sidebar-wrapper">
          <!-- Close button inside sidebar -->
          <div class="blog-sidebar-close d-lg-none">
            <button type="button" class="bg-transparent p-2 steve-btn justify-content-end" aria-label="Close sidebar">
              <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
              </svg>
            </button>
          </div>

          <!-- Search Widget -->
          <div class="single-blog-widget">
            <?php echo $__env->make('admin.partials.search-form', [
                'route' => route('blog'),
                'placeholder' => 'Search blogs...',
                'showClear' => !empty(request('search')) || isset($category)
            ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
          </div>

          <!-- Categories Widget -->
          <div class="single-blog-widget">
            <h5 class="widget-title">Categories</h5>
            <ul class="cat-wrapper">
              <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <a href="<?php echo e(route('blog.category', $cat->slug)); ?>" class="blog-page-cat-list <?php echo e(isset($category) && $category->id === $cat->id ? 'active' : ''); ?>"><i class="fas fa-arrow-right ms-1"></i> <?php echo e($cat->name); ?> (<?php echo e($cat->blogs_count); ?>)</a>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
          </div>

          <!-- Clear Filters -->
          <?php if(!empty(request('search')) || isset($category)): ?>
          <div class="single-blog-widget">
            <a href="<?php echo e(route('blog')); ?>" class="btn w-100 steve-btn fw-600 btn-primary">
              <i class="fas fa-times me-1"></i> Clear Filters
            </a>
          </div>
          <?php endif; ?>

          <!-- Recent Posts Widget -->
          <div class="single-blog-widget">
            <h5 class="widget-title">Recent Posts</h5>
            <div class="gs-sm-recent-post-wrapper">
              <?php $__currentLoopData = $recentBlogs->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <a href="<?php echo e(route('blog.show', $post->slug)); ?>" class="recent-post d-flex">
                <?php echo imgTag('assets/images/blogs/'.($post->image ?? 'placeholder.jpg'), '', '', 'width="80" height="80"'); ?>

                <div class="recent-post-content">
                  <h6 class="post-title"><?php echo e(Str::limit($post->title, 50)); ?></h6>
                  <span class="post-date">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none">
                      <path d="M8 2V4M16 2V4M3 10.5H21M5 4H19C20.1046 4 21 4.89543 21 6V19C21 20.1046 20.1046 21 19 21H5C3.89543 21 3 20.1046 3 19V6C3 4.89543 3.89543 4 5 4Z" stroke="#4c3533" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <?php echo e($post->created_at->format('M d - Y')); ?>

                  </span>
                </div>
              </a>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
          </div>

        </div>
      </div>

      <!-- Main Blog Content -->
      <div class="col-12 col-lg-8 gs-main-blog-wrapper">

        <?php $__empty_1 = true; $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="gs-main-single-blog">
          <div class="left-side-content">
            <a href="<?php echo e(route('blog.show', $blog->slug)); ?>">
              <?php echo imgTag('assets/images/blogs/'.($blog->image ?? 'placeholder.jpg'), $blog->title, 'blog-img'); ?>

            </a>
          </div>
          <div class="right-side-content">
            <h4>
              <a class="title" href="<?php echo e(route('blog.show', $blog->slug)); ?>">
                <?php echo e(Str::limit($blog->title, 70)); ?>

              </a>
            </h4>
            <p class="des">
              <?php echo e(Str::limit(strip_tags($blog->details ?? ''), 180)); ?>

            </p>
            <div class="date-wrapper">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M8 2V4M16 2V4M3 10.5H21M5 4H19C20.1046 4 21 4.89543 21 6V19C21 20.1046 20.1046 21 19 21H5C3.89543 21 3 20.1046 3 19V6C3 4.89543 3.89543 4 5 4Z" stroke="#292D32" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
              <span class="date-text"><?php echo e($blog->created_at->format('M d - Y')); ?></span>
            </div>
            <a class="template-btn steve-btn outlinee-btn" href="<?php echo e(route('blog.show', $blog->slug)); ?>">read more</a>
          </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="text-center py-5">
          <p class="text-muted">No blog posts found.</p>
        </div>
        <?php endif; ?>

        <!-- Pagination -->
        <?php if($blogs->hasPages()): ?>
        <div class="d-flex justify-content-center mt-60">
          <?php echo e($blogs->links('vendor.pagination.gs-pagination')); ?>

        </div>
        <?php endif; ?>

      </div>

    </div>
  </div>

  <!-- Floating Sidebar Toggle (Mobile) -->
  <button class="blog-sidebar-toggle-float d-lg-none" type="button" aria-label="Toggle sidebar">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <line x1="4" y1="21" x2="4" y2="14"></line>
      <line x1="4" y1="10" x2="4" y2="3"></line>
      <line x1="12" y1="21" x2="12" y2="12"></line>
      <line x1="12" y1="8" x2="12" y2="3"></line>
      <line x1="20" y1="21" x2="20" y2="16"></line>
      <line x1="20" y1="12" x2="20" y2="3"></line>
      <line x1="1" y1="14" x2="7" y2="14"></line>
      <line x1="9" y1="8" x2="15" y2="8"></line>
      <line x1="17" y1="16" x2="23" y2="16"></line>
    </svg>
  </button>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
  var sidebar = document.querySelector('.gs-blog-sidebar-wrapper');
  var overlay = document.querySelector('.blog-sidebar-overlay');
  var toggle = document.querySelector('.blog-sidebar-toggle-float');
  var closeBtn = document.querySelector('.blog-sidebar-close button');

  function openSidebar() {
    sidebar.classList.add('active');
    overlay.classList.add('active');
    document.body.classList.add('overflow-hidden');
  }
  function closeSidebar() {
    sidebar.classList.remove('active');
    overlay.classList.remove('active');
    document.body.classList.remove('overflow-hidden');
  }

  if (toggle) toggle.addEventListener('click', openSidebar);
  if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
  if (overlay) overlay.addEventListener('click', closeSidebar);
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && sidebar && sidebar.classList.contains('active')) closeSidebar();
  });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/stautoparts/resources/views/blog/index.blade.php ENDPATH**/ ?>