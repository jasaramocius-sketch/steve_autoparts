<?php $__env->startSection('title', $blog->title . ' - ' . config('app.name', 'StAutoparts')); ?>

<?php $__env->startSection('content'); ?>

<!-- Breadcrumb -->
<section class="gs-breadcrumb-section" style="background-image: url('<?php echo e(asset('assets/images/1724480495Imagexxxxxpng.png')); ?>'); background-size: cover; background-position: center;">
  <div class="container">
    <div class="row justify-content-center content-wrapper">
      <div class="col-12">
        <h2 class="breadcrumb-title">Blog Details</h2>
        <ul class="bread-menu">
          <li><a href="<?php echo e(route('home')); ?>">Home</a></li>
          <li><a href="<?php echo e(route('blog')); ?>">Blog</a></li>
          <li style="color: var(--primary)"><?php echo e(Str::limit($blog->title, 40)); ?></li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- Blog Wrapper -->
<div class="gs-blog-wrapper">
  <div class="container">
    <a href="<?php echo e(route('blog')); ?>" class="btn btn-outline-primary single-blog-button steve-btn w-auto mb-2">
        Back to Blog
    </a>
    <div class="row">      
      <!-- Main Content -->
      <div class="col-12 col-lg-8 gs-main-blog-wrapper">
        <div class="gs-blog-details-wrapper">
          <div class="gs-blog-card">

            <!-- Featured Image -->
            <img class="fea-img img-fluid"
                 src="<?php echo e(asset('assets/images/blogs/'.($blog->image ?? 'placeholder.jpg'))); ?>"
                 alt="<?php echo e($blog->title); ?>">

            <!-- Meta Info -->
            <div class="meta-info-wrapper">
              <div class="single-meta">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                  <path d="M20 21V19C20 17.9391 19.5786 16.9217 18.8284 16.1716C18.0783 15.4214 17.0609 15 16 15H8C6.93913 15 5.92172 15.4214 5.17157 16.1716C4.42143 16.9217 4 17.9391 4 19V21" stroke="#292D32" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z" stroke="#292D32" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="meta-title">By: Admin</span>
              </div>
              <div class="single-meta">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                  <path d="M8 2V4M16 2V4M3 10.5H21M5 4H19C20.1046 4 21 4.89543 21 6V19C21 20.1046 20.1046 21 19 21H5C3.89543 21 3 20.1046 3 19V6C3 4.89543 3.89543 4 5 4Z" stroke="#292D32" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="meta-title"><?php echo e($blog->created_at->format('M d - Y')); ?></span>
              </div>
              <?php if($blog->category): ?>
              <div class="single-meta">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                  <path d="M1 12C1 12 5 4 12 4C19 4 23 12 23 12C23 12 19 20 12 20C5 20 1 12 1 12Z" stroke="#292D32" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  <circle cx="12" cy="12" r="3" stroke="#292D32" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <a href="<?php echo e(route('blog.category', $blog->category->slug)); ?>" class="meta-title"><?php echo e($blog->category->name); ?></a>
              </div>
              <?php endif; ?>
            </div>

            <!-- Post Title -->
            <h4 class="fea-title mb-24"><?php echo e($blog->title); ?></h4>

            <!-- Post Content -->
            <div class="blog-content-body">
              <?php echo $blog->details; ?>

            </div>

          </div>
        </div>

        <?php if (isset($component)) { $__componentOriginalf8446d12475031d632e761b16f53f033 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8446d12475031d632e761b16f53f033 = $attributes; } ?>
<?php $component = SteveStore\PageBuilder\View\Components\Blocks::resolve(['model' => $blog] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-blocks'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\SteveStore\PageBuilder\View\Components\Blocks::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf8446d12475031d632e761b16f53f033)): ?>
<?php $attributes = $__attributesOriginalf8446d12475031d632e761b16f53f033; ?>
<?php unset($__attributesOriginalf8446d12475031d632e761b16f53f033); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf8446d12475031d632e761b16f53f033)): ?>
<?php $component = $__componentOriginalf8446d12475031d632e761b16f53f033; ?>
<?php unset($__componentOriginalf8446d12475031d632e761b16f53f033); ?>
<?php endif; ?>

        <div class="row mt-5 border-top pt-4 single-blog-content-navigation">
          <div class="col-md-6">
            <?php if($previous): ?>
              <small class="text-muted d-block">Previous Post</small>
              <div class="a-tag-hover-color">
                <i class="fas fa-arrow-left"></i>
                <a href="<?php echo e(route('blog.show', $previous->slug)); ?>"><?php echo e($previous->title); ?></a>
              </div>
            <?php else: ?>
              <small class="text-muted d-block">Previous Post</small>
            <?php endif; ?>  
          </div>
          <div class="col-md-6 text-md-end">
            <?php if($next): ?>
              <small class="text-muted d-block">Next Post</small>
              <div class="a-tag-hover-color">
                <a href="<?php echo e(route('blog.show', $next->slug)); ?>"><?php echo e($next->title); ?></a>
                <i class="fas fa-arrow-right"></i>            
              </div>
            <?php else: ?>
              <small class="text-muted d-block">Next Post</small>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <!-- Sidebar -->
      <div class="col-12 col-lg-4 mt-40 mt-lg-0">
        <button class="blog-sidebar-toggle d-lg-none border-0 bg-transparent p-2 steve-btn" type="button" style="border-radius:6px; background:#fff; box-shadow:0 0 0 1px rgba(0,0,0,0.08);">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="3" y1="6" x2="21" y2="6"></line>
            <line x1="3" y1="12" x2="21" y2="12"></line>
            <line x1="3" y1="18" x2="21" y2="18"></line>
          </svg>
          <span class="ms-2 fw-500">Sidebar</span>
        </button>
        <div class="blog-sidebar-overlay"></div>
        <div class="gs-blog-sidebar-wrapper right-side">

          <!-- Search Widget -->
          <!-- <div class="single-blog-widget">
            <h5 class="widget-title">Search</h5>
            <form class="search-form" action="<?php echo e(route('blog')); ?>" method="GET">
              <input class="input-box" type="text" name="search" placeholder="Find anything...">
              <button type="submit">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <path d="M21 21L16.65 16.65M19 11C19 15.4183 15.4183 19 11 19C6.58172 19 3 15.4183 3 11C3 6.58172 6.58172 3 11 3C15.4183 3 19 6.58172 19 11Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </button>
            </form>
          </div> -->

          <!-- Categories Widget -->
          <!-- <div class="single-blog-widget">
            <h5 class="widget-title">Categories</h5>
            <ul class="cat-wrapper">
              <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <li><a href="<?php echo e(route('blog.category', $cat->slug)); ?>"><?php echo e($cat->name); ?> (<?php echo e($cat->blogs_count); ?>)</a></li>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
          </div> -->

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

    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
  var sidebar = document.querySelector('.gs-blog-sidebar-wrapper');
  var overlay = document.querySelector('.blog-sidebar-overlay');
  var toggle = document.querySelector('.blog-sidebar-toggle');

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
  if (overlay) overlay.addEventListener('click', closeSidebar);
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && sidebar && sidebar.classList.contains('active')) closeSidebar();
  });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/stautoparts/resources/views/blog/show.blade.php ENDPATH**/ ?>