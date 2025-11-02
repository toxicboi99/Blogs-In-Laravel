

<?php $__env->startSection('title', 'Home'); ?>

<?php $__env->startSection('hero'); ?>
<div class="hero-section">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-3">Welcome to Our Blog</h1>
        <p class="lead">Discover amazing stories, insights, and ideas</p>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-8">
        <?php if($posts->count() > 0): ?>
            <div class="row">
                <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-6 mb-4">
                        <div class="card post-card h-100 shadow-sm">
                            <?php if($post->featured_image): ?>
                                <img src="<?php echo e(asset('storage/' . $post->featured_image)); ?>" class="card-img-top" alt="<?php echo e($post->title); ?>" style="height: 200px; object-fit: cover;">
                            <?php endif; ?>
                            <div class="card-body d-flex flex-column">
                                <div class="mb-2">
                                    <span class="badge bg-primary"><?php echo e($post->category->name); ?></span>
                                    <small class="text-muted ms-2"><?php echo e($post->published_at->format('M d, Y')); ?></small>
                                </div>
                                <h5 class="card-title">
                                    <a href="<?php echo e(route('blog.show', $post)); ?>" class="text-decoration-none text-dark">
                                        <?php echo e($post->title); ?>

                                    </a>
                                </h5>
                                <?php if($post->excerpt): ?>
                                    <p class="card-text text-muted"><?php echo e(Str::limit($post->excerpt, 120)); ?></p>
                                <?php endif; ?>
                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <i class="fas fa-user me-1"></i><?php echo e($post->user->name); ?>

                                        </small>
                                        <a href="<?php echo e(route('blog.show', $post)); ?>" class="btn btn-outline-primary btn-sm">
                                            Read More <i class="fas fa-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="d-flex justify-content-center">
                <?php echo e($posts->links()); ?>

            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                <h3 class="text-muted">No posts yet</h3>
                <p class="text-muted">Check back later for new content!</p>
            </div>
        <?php endif; ?>
    </div>

    <div class="col-lg-4">
        <div class="sidebar">
            <h5 class="mb-3">
                <i class="fas fa-tags me-2"></i>Categories
            </h5>
            <?php if($categories->count() > 0): ?>
                <ul class="list-unstyled">
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="mb-2">
                            <a href="<?php echo e(route('blog.category', $category)); ?>" class="text-decoration-none d-flex justify-content-between align-items-center">
                                <span><?php echo e($category->name); ?></span>
                                <span class="badge bg-secondary"><?php echo e($category->posts_count); ?></span>
                            </a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php else: ?>
                <p class="text-muted">No categories available.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('blog.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\Blog\blog-admin\resources\views/blog/index.blade.php ENDPATH**/ ?>