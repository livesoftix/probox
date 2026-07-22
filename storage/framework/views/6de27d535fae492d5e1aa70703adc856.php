

<?php $__env->startSection('content'); ?>

<div class="container-fluid">

    <!-- Page Title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">

                <div class="page-title-right">
                    <a href="<?php echo e(route('product-freezing.index')); ?>" class="btn btn-dark">
                        Back
                    </a>
                </div>

                <h4 class="page-title">
                    Edit Product Freezing
                </h4>

            </div>
        </div>
    </div>

    <?php if($errors->any()): ?>

    <div class="alert alert-danger">

        <ul class="mb-0">

            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <li><?php echo e($error); ?></li>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </ul>

    </div>

    <?php endif; ?>

    <div class="row">

        <div class="col-lg-12">

            <div class="card">

                <div class="card-body">

                    <form action="<?php echo e(route('product-freezing.update',$productFreezing->id)); ?>"
                          method="POST">

                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="row">

                            <!-- Date -->

                            <div class="col-md-3 mb-3">

                                <label class="form-label">
                                    Date
                                </label>

                                <input
                                    type="date"
                                    name="date"
                                    class="form-control"
                                    value="<?php echo e(old('date',$productFreezing->date)); ?>"
                                    required>

                            </div>

                            <!-- Slip -->

                            <div class="col-md-3 mb-3">

                                <label class="form-label">
                                    Slip No
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    value="<?php echo e($productFreezing->slip_no); ?>"
                                    readonly>

                            </div>

                            <!-- Product -->

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Product
                                </label>

                                <select
                                    name="product_id"
                                    class="form-control select2"
                                    required>

                                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <option
                                        value="<?php echo e($product->id); ?>"
                                        <?php echo e($product->id==$productFreezing->product_id ? 'selected':''); ?>>

                                        <?php echo e($product->prod_name); ?>


                                    </option>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </select>

                            </div>

                            <!-- Status -->

                            <div class="col-md-3 mb-3">

                                <label class="form-label">
                                    Status
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    value="Inactive"
                                    readonly>

                            </div>

                            <!-- Description -->

                            <div class="col-md-12 mb-3">

                                <label class="form-label">
                                    Description
                                </label>

                                <textarea
                                    name="description"
                                    rows="5"
                                    class="form-control"><?php echo e(old('description',$productFreezing->description)); ?></textarea>

                            </div>

                        </div>

                        <hr>

                        <button
                            class="btn btn-primary">

                            Update

                        </button>

                        <a
                            href="<?php echo e(route('product-freezing.index')); ?>"
                            class="btn btn-secondary">

                            Cancel

                        </a>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\probox\resources\views/product_freezing/edit.blade.php ENDPATH**/ ?>