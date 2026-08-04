<?php $__env->startSection('page-id', 'admin-contact-detail-page'); ?>
<?php $__env->startSection('page-class', 'admin-contact-detail-page'); ?>
<?php $__env->startSection('page-title', 'Contact Detail'); ?>
<?php $__env->startSection('content'); ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0">Contact #<?php echo e($contact->id); ?></h4>
    <!-- <a href="<?php echo e(route('admin.contacts.index')); ?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a> -->
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h6 class="mb-0 fw-semibold">Message Details</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold text-muted small">Subject</label>
                    <p class="mb-0"><?php echo e($contact->subject); ?></p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold text-muted small">Message</label>
                    <div class="p-3 bg-light rounded" style="white-space: pre-wrap; line-height: 1.8;"><?php echo e($contact->message); ?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h6 class="mb-0 fw-semibold">Contact Info</h6>
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <small class="text-muted">Name</small>
                    <p class="mb-0 fw-semibold"><?php echo e($contact->name); ?></p>
                </div>
                <div class="mb-2">
                    <small class="text-muted">Email</small>
                    <p class="mb-0"><a href="mailto:<?php echo e($contact->email); ?>"><?php echo e($contact->email); ?></a></p>
                </div>
                <?php if($contact->phone): ?>
                <div class="mb-2">
                    <small class="text-muted">Phone</small>
                    <p class="mb-0"><?php echo e($contact->phone); ?></p>
                </div>
                <?php endif; ?>
                <div class="mb-2">
                    <small class="text-muted">Date</small>
                    <p class="mb-0"><?php echo e($contact->created_at->format('M d, Y h:i A')); ?></p>
                </div>
                <?php if($contact->user): ?>
                <div class="mb-2">
                    <small class="text-muted">User</small>
                    <p class="mb-0"><a href="<?php echo e(route('admin.users.index')); ?>"><?php echo e($contact->user->name); ?> (<?php echo e($contact->user->email); ?>)</a></p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if($contact->product): ?>
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h6 class="mb-0 fw-semibold">Product</h6>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <?php if($contact->product->image): ?>
                        <img src="<?php echo e(asset('assets/images/thumbnails/' . $contact->product->image)); ?>" alt="" style="width:60px;height:60px;object-fit:cover;border-radius:8px;">
                    <?php endif; ?>
                    <div>
                        <a href="<?php echo e(route('product', $contact->product->slug)); ?>" target="_blank" class="fw-semibold text-dark text-decoration-none"><?php echo e($contact->product->name); ?></a>
                        <div class="text-muted small"><?php echo e(currency_format($contact->product->price)); ?></div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form action="<?php echo e(route('admin.contacts.destroy', $contact->id)); ?>" method="POST" onsubmit="return confirm('Delete this contact permanently?')">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-outline-danger w-100"><i class="fas fa-trash me-1"></i> Delete Contact</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/stautoparts/resources/views/admin/contacts/show.blade.php ENDPATH**/ ?>