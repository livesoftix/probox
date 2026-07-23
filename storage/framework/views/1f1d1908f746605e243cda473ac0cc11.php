

<?php $__env->startSection('content'); ?>

<div class="container-fluid">

    <!-- Page Title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Product Freezing List</h4>
            </div>
        </div>
    </div>

    <!-- Search -->
    <div class="row">
        <div class="card">
            <div class="card-body">

                <form action="<?php echo e(route('product-freezing.index')); ?>" method="GET">

                    <div class="row">

                        <div class="col-md-3">
                            <input type="date"
                                   name="date"
                                   value="<?php echo e(request('date')); ?>"
                                   class="form-control">
                        </div>

                        <div class="col-md-4">

                            <select name="product_id"
                                    class="form-control select2">

                                <option value="">Select Product</option>

                                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <option value="<?php echo e($product->id); ?>"
                                    <?php echo e(request('product_id')==$product->id ? 'selected':''); ?>>

                                    <?php echo e($product->prod_name); ?>


                                </option>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </select>

                        </div>

                        <div class="col-md-3">

                            <button class="btn btn-primary">
                                Search
                            </button>

                            <a href="<?php echo e(route('product-freezing.index')); ?>"
                               class="btn btn-secondary">
                                Clear
                            </a>

                        </div>

                    </div>

                </form>

            </div>
        </div>
    </div>

    <!-- Success Message -->

    <?php if(session('success')): ?>

    <div class="alert alert-success mt-2">
        <?php echo e(session('success')); ?>

    </div>

    <?php endif; ?>

    <!-- Listing -->

    <div class="row">

        <div class="col-12">

            <div class="card">

                <div class="card-body">

                    <a href="<?php echo e(route('product-freezing.create')); ?>"
                       class="btn btn-primary">

                        Add Product Freezing

                    </a>

                    <button class="btn btn-secondary"
                            onclick="printTable()">

                        Print Table

                    </button>

                    <br><br>

                    <table id="basic-datatable"
                           class="table table-bordered table-striped">

                        <thead>

                        <tr>

                            <th>Date</th>

                            <th>Slip No</th>

                            <th>Product</th>

                            <th>Status</th>

                            <th>Description</th>

                            <th class="no-print">
                                Action
                            </th>

                        </tr>

                        </thead>

                        <tbody>

                        <?php $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <tr>

                            <td>
                                <?php echo e(date('d-m-Y',strtotime($row->date))); ?>

                            </td>

                            <td>
                                <?php echo e($row->slip_no); ?>

                            </td>

                            <td>
                                <?php echo e($row->product->prod_name); ?>

                            </td>

                          <td>
    <span class="badge <?php echo e($row->product->status == 'active' ? 'bg-success' : 'bg-danger'); ?>">
        <?php echo e($row->product->status); ?>

    </span>
</td>

                            <td>

                                <?php echo e($row->description); ?>


                            </td>

                            <td class="no-print">

    <div class="d-flex">

        <a href="<?php echo e(route('product-freezing.show', $row->id)); ?>"
            class="btn btn-info btn-sm me-1">
            View
        </a>

        <a href="<?php echo e(route('product-freezing.edit', $row->id)); ?>"
            class="btn btn-warning btn-sm me-1">
            Edit
        </a>

        <a href="<?php echo e(route('product-freezing.print', $row->id)); ?>"
            target="_blank"
            class="btn btn-success btn-sm me-1">
            Print
        </a>

        <form action="<?php echo e(route('product-freezing.destroy', $row->id)); ?>"
              method="POST"
              onsubmit="return confirm('Are you sure you want to delete this Product Freezing record?');">

            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>

            <button type="submit" class="btn btn-danger btn-sm">
                Delete
            </button>

        </form>

    </div>

</td>

                        </tr>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

<script>

function printTable(){

    $('.no-print').hide();

    var printContents=document.getElementById('basic-datatable').outerHTML;

    var original=document.body.innerHTML;

    document.body.innerHTML=printContents;

    window.print();

    document.body.innerHTML=original;

    location.reload();

}

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\probox\resources\views/product_freezing/index.blade.php ENDPATH**/ ?>