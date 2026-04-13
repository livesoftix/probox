<!-- condition.blade.php -->

<?php if(auth()->check() && auth()->user()->is_admin == 1): ?>
    <?php echo $__env->make('layouts.condition', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> <!-- Admin layout -->
<?php else: ?>
    <?php echo $__env->make('layouts.user_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> <!-- User layout -->
<?php endif; ?>
<?php /**PATH /home/realerp/public_html/probox/resources/views/layouts/app.blade.php ENDPATH**/ ?>