

<?php $__env->startSection('title', 'View Post'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>View Post</h2>
    <div>
        <?php if($post->approval_status !== 'approved'): ?>
            <a href="<?php echo e(route('user.posts.edit', $post)); ?>" class="btn btn-warning me-2">
                <i class="fas fa-edit me-2"></i>Edit
            </a>
        <?php endif; ?>
        <a href="<?php echo e(route('user.posts.index')); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Posts
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <?php if($post->featured_image): ?>
                <img src="<?php echo e(asset('storage/' . $post->featured_image)); ?>" class="card-img-top" alt="<?php echo e($post->title); ?>" style="height: 300px; object-fit: cover;">
            <?php endif; ?>
            <div class="card-body">
                <div class="mb-3">
                    <span class="badge bg-primary"><?php echo e($post->category->name); ?></span>
                    <span class="badge bg-<?php echo e($post->status === 'published' ? 'success' : 'warning'); ?> ms-2">
                        <?php echo e(ucfirst($post->status)); ?>

                    </span>
                    <span class="badge bg-<?php echo e($post->approval_status === 'approved' ? 'success' : ($post->approval_status === 'rejected' ? 'danger' : 'warning')); ?> ms-2">
                        <?php echo e(ucfirst($post->approval_status)); ?>

                    </span>
                </div>
                
                <h1 class="h3 mb-4"><?php echo e($post->title); ?></h1>
                
                <?php if($post->excerpt): ?>
                    <div class="lead mb-4"><?php echo e($post->excerpt); ?></div>
                <?php endif; ?>

                <div class="content">
                    <?php echo $post->content; ?>

                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Post Details</h6>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4">Title:</dt>
                    <dd class="col-sm-8"><?php echo e($post->title); ?></dd>
                    
                    <dt class="col-sm-4">Category:</dt>
                    <dd class="col-sm-8"><?php echo e($post->category->name); ?></dd>
                    
                    <dt class="col-sm-4">Status:</dt>
                    <dd class="col-sm-8">
                        <span class="badge bg-<?php echo e($post->status === 'published' ? 'success' : 'warning'); ?>">
                            <?php echo e(ucfirst($post->status)); ?>

                        </span>
                    </dd>
                    
                    <dt class="col-sm-4">Approval:</dt>
                    <dd class="col-sm-8">
                        <span class="badge bg-<?php echo e($post->approval_status === 'approved' ? 'success' : ($post->approval_status === 'rejected' ? 'danger' : 'warning')); ?>">
                            <?php echo e(ucfirst($post->approval_status)); ?>

                        </span>
                    </dd>
                    
                    <dt class="col-sm-4">Created:</dt>
                    <dd class="col-sm-8"><?php echo e($post->created_at->format('M d, Y H:i')); ?></dd>
                    
                    <dt class="col-sm-4">Updated:</dt>
                    <dd class="col-sm-8"><?php echo e($post->updated_at->format('M d, Y H:i')); ?></dd>
                </dl>

                <?php if($post->approval_status === 'pending'): ?>
                    <div class="alert alert-info">
                        <i class="fas fa-clock me-2"></i>
                        <strong>Pending Approval:</strong> Your post is waiting for admin approval.
                    </div>
                <?php elseif($post->approval_status === 'rejected'): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-times me-2"></i>
                        <strong>Rejected:</strong> Your post was not approved by the admin.
                    </div>
                <?php elseif($post->approval_status === 'approved'): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check me-2"></i>
                        <strong>Approved:</strong> Your post has been approved and published!
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\Blog\blog-admin\resources\views/user/posts/show.blade.php ENDPATH**/ ?>