

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
                <h4 class="page-title">Product Freezing</h4>
            </div>
        </div>
    </div>

    <!-- Validation Errors -->
    <?php if($errors->any()): ?>
    <div class="alert alert-danger">
        <strong>Please fix the following errors:</strong>
        <ul class="mb-0 mt-2">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
    <?php endif; ?>

    <!-- Form -->
    <div class="row">
        <div class="col-lg-12">

            <div class="card">

                <div class="card-body">

                    <form action="<?php echo e(route('product-freezing.store')); ?>" method="POST">

                        <?php echo csrf_field(); ?>

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
                                    value="<?php echo e(old('date',date('Y-m-d'))); ?>"
                                    required>
                            </div>

                            <!-- Slip No -->
                            <div class="col-md-3 mb-3">

                                <label class="form-label">
                                    Slip No
                                </label>

                                <input
                                    type="text"
                                    name="slip_no"
                                    class="form-control"
                                    value="<?php echo e($slipNo); ?>"
                                    readonly>

                            </div>

                            <!-- Product -->
                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Product
                                </label>
<select
    name="product_id"
    id="product_id"
    class="form-control select2"
    data-toggle="select2"
    required>

    <option value="">Select Product</option>

    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

    <option
        value="<?php echo e($product->id); ?>"
        data-status="<?php echo e($product->status); ?>"
        <?php echo e(old('product_id')==$product->id ? 'selected' : ''); ?>>

        <?php echo e($product->prod_name); ?>


    </option>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</select>

                            </div>

                            <!-- Status -->
                            <div class="col-md-3 mb-3">

                                <label class="form-label" >
                                    Status
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    value="Inactive">

                            </div>

                            <!-- Description -->
                            <div class="col-md-12 mb-3">

                                <label class="form-label">
                                    Description
                                </label>

                                <textarea
                                    name="description"
                                    class="form-control"
                                    rows="5"
                                    placeholder="Enter Reason for Product Freezing"><?php echo e(old('description')); ?></textarea>

                            </div>

                        </div>

                        <hr>

                        <button
                            type="submit"
                            class="btn btn-primary">

                            Save

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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function () {

    $('#product_id').on('change', function () {

        if($(this).data('status') != ''){
            $('#status').val('Inactive');
            console.log("inactive");
        }else{
            $('#status').val('');
            console.log("active");
        }

    });

});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\probox\resources\views/product_freezing/create.blade.php ENDPATH**/ ?>