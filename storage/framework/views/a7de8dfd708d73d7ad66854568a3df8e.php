<?php $__env->startSection('page-id', 'user-notifications-page'); ?>
<?php $__env->startSection('page-class', 'user-notifications-page'); ?>
<?php $__env->startSection('dashboard-content'); ?>
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <h4 class="h4-style mb-0">Notifications
        <?php if($unreadCount > 0): ?>
        <span class="badge bg-danger ms-2"><?php echo e($unreadCount); ?></span>
        <?php endif; ?>
    </h4>
    <?php if($unreadCount > 0): ?>
    <form action="<?php echo e(route('user.notifications.read-all')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <button class="btn btn-outline-secondary steve-btn">Mark All as Read</button>
    </form>
    <?php endif; ?>
</div>

<div class="list-group">
<?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<div class="list-group-item d-flex justify-content-between align-items-start <?php echo e($notification->is_read ? '' : 'fw-bold bg-light'); ?>">
    <div class="me-3">
        <div><?php echo e($notification->title); ?></div>
        <small class="text-muted"><?php echo str_contains($notification->message, '<a')
                ? $notification->message
                : preg_replace('/#(ORD[A-Z0-9]+)/i', '<a href="' . url('/user/orders/$1') . '" class="text-decoration-underline">$0</a>', e($notification->message)); ?></small>
        <br><small class="text-muted"><?php echo e($notification->created_at->diffForHumans()); ?></small>
    </div>
<?php if (! ($notification->is_read)): ?>
    <div class="action-buttons">
        <form action="<?php echo e(route('user.notifications.read', $notification->id)); ?>" method="POST" class="d-inline">
            <?php echo csrf_field(); ?>
            <button class="action-btn btn-view-live" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Mark Read">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
            </button>
        </form>
    </div>
<?php endif; ?>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
<div class="card">
    <div class="card-body text-center py-5">
        <p class="text-muted mb-0">No notifications yet.</p>
    </div>
</div>
<?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('user.layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/stautoparts/resources/views/user/notifications.blade.php ENDPATH**/ ?>