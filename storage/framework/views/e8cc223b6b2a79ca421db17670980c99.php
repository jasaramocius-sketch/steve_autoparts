<?php $__env->startSection('page-id', 'user-blog-page'); ?>
<?php $__env->startSection('page-class', 'user-blog-page'); ?>
<?php $__env->startSection('title', 'Blog' . ' - ' . config('app.name', 'StAutoparts')); ?>

<?php $__env->startSection('content'); ?>

<section class="blog-page py-5">
<div class="container">

<div class="row">

    <!-- Left -->
    <div class="col-lg-8">

        <?php $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <div class="blog-card bg-white shadow-sm rounded overflow-hidden mb-5">

            <div class="blog-image">
                <?php echo imgTag('assets/images/blogs/'.($blog->image ?? 'placeholder.jpg'), '', 'w-100'); ?>

            </div>

            <div class="p-4">

                <div class="blog-meta mb-3">

                    <span>
                        <i class="far fa-calendar-alt"></i>
                        <?php echo e($blog->created_at->format('d M Y')); ?>

                    </span>

                    <span class="ms-4">
                        <i class="far fa-user"></i>
                        Admin
                    </span>

                </div>

                <h3 class="blog-title mb-3">
                    <a href="<?php echo e(route('blog.show',$blog->slug)); ?>">
                        <?php echo e($blog->title); ?>

                    </a>
                </h3>

                <p>
                    <?php echo e(Str::limit(strip_tags($blog->description),180)); ?>

                </p>

                <a href="<?php echo e(route('blog.show',$blog->slug)); ?>"
                   class="btn btn-danger px-4 primary-btn">
                    Read More
                </a>

            </div>

        </div>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <?php echo e($blogs->links()); ?>


    </div>


    <!-- Sidebar -->
    <div class="col-lg-4">

        <!-- Search -->
        <div class="bg-white shadow-sm rounded p-4 mb-4">

            <h5 class="mb-3">Search</h5>

            <form>
                <div class="input-group">
                    <input type="text"
                           class="form-control"
                           placeholder="Search...">

                    <button class="btn btn-danger steve-btn">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>

        </div>


        <!-- Recent Posts -->
        <div class="bg-white shadow-sm rounded p-4 mb-4">

            <h5 class="mb-4">Recent Posts</h5>

            <?php $__currentLoopData = $recentBlogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <div class="d-flex mb-3">

                <?php echo imgTag('assets/images/blogs/'.($post->image ?? 'placeholder.jpg'), '', 'rounded', 'width="90"'); ?>


                <div class="ms-3">

                    <a href="<?php echo e(route('blog.show',$post->slug)); ?>"
                       class="fw-semibold text-dark">
                        <?php echo e(Str::limit($post->title,50)); ?>

                    </a>

                    <div class="text-muted small mt-1">
                        <?php echo e($post->created_at->format('d M Y')); ?>

                    </div>

                </div>

            </div>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>


        <!-- Categories -->
        <div class="bg-white shadow-sm rounded p-4">
            <h5 class="mb-4">Categories</h5>

            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="d-flex justify-content-between border-bottom py-2">
                    <span><?php echo e($cat->name); ?></span>
                    <span><?php echo e($cat->blogs_count); ?></span>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>  

    </div>

</div>
</div>
</section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/stautoparts/resources/views/pages/blog.blade.php ENDPATH**/ ?>