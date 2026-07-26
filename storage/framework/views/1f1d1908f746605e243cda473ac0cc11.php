

<?php $__env->startSection('content'); ?>

<div class="container-fluid mt-5">

    <div class="row mb-3">
        <div class="col-md-6">
            <h4 class="page-title"><i class="bi bi-snow me-2"></i>Product Freezing</h4>
        </div>

        <div class="col-md-6 text-end">

            <button
                class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#freezeModal">

                <i class="mdi mdi-plus"></i>
                New Slip

            </button>

        </div>
    </div>

    <div class="card">

        <div class="card-body">

            <table class="table table-bordered table-striped">

                <thead>

                <tr>

                    <th>Date</th>
                    <th>Slip No</th>
                    <th>Product</th>
                    <th>Status</th>
                    <th>Description</th>
                    <th width="180">Action</th>

                </tr>

                </thead>

                <tbody>

                <?php $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <tr>

                    <td><?php echo e(date('d-m-Y',strtotime($row->date))); ?></td>

                    <td><?php echo e($row->slip_no); ?></td>

                    <td><?php echo e($row->product->prod_name); ?></td>

                    <td>

                        <span class="badge bg-danger">

                            <?php echo e(ucfirst($row->product->status)); ?>


                        </span>

                    </td>

                    <td><?php echo e($row->description); ?></td>
<td>

    <!-- View -->

    <a href="<?php echo e(route('product-freezing.show', $row->id)); ?>"
       class="btn btn-info btn-sm"
       title="View">

        <i class="bi bi-eye-fill"></i>

        View

    </a>

    <!-- Edit -->

    <button type="button"
            class="btn btn-warning btn-sm"
            data-bs-toggle="modal"
            data-bs-target="#editModal<?php echo e($row->id); ?>"
            title="Edit">

        <i class="bi bi-pencil-square"></i>

        Edit

    </button>

    <!-- Delete -->

    <form action="<?php echo e(route('product-freezing.destroy', $row->id)); ?>"
          method="POST"
          class="d-inline"
          onsubmit="return confirm('Are you sure you want to delete this Product Freezing Slip?');">

        <?php echo csrf_field(); ?>
        <?php echo method_field('DELETE'); ?>

        <button type="submit"
                class="btn btn-danger btn-sm"
                title="Delete">

            <i class="bi bi-trash-fill"></i>

            Delete

        </button>

    </form>

</td>
                </tr>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php echo $__env->make('product_freezing.modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('product_freezing.modal_edit', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
 <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>

    $(function () {

    $('.select2').select2({
        dropdownParent: $('#freezeModal')
    });

    $('#product_id').change(function () {

        let status = $(this).find(':selected').data('status');

        if(status=="active")
        {
            $('#status').val('Inactive');
        }
        else
        {
            $('#status').val(status);
        }

    });

});
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\probox\resources\views/product_freezing/index.blade.php ENDPATH**/ ?>