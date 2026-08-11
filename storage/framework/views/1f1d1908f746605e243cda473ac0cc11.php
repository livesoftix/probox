

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
<div class="card mb-3">
    <div class="card-body">

        <form method="GET" action="<?php echo e(route('product-freezing.index')); ?>">

            <div class="row">

                <!-- Start Date -->
                <div class="col-md-3 mb-2">
                    <label class="form-label">Start Date</label>

                    <input type="date"
                           name="start_date"
                           class="form-control"
                           value="<?php echo e(request('start_date')); ?>">
                </div>

                <!-- End Date -->
                <div class="col-md-3 mb-2">
                    <label class="form-label">End Date</label>

                    <input type="date"
                           name="end_date"
                           class="form-control"
                           value="<?php echo e(request('end_date')); ?>">
                </div>

                <!-- Product -->
                <div class="col-md-3 mb-2">
                    <label class="form-label">Product</label>

  <select name="product_id"
        class="form-control product-filter">

    <option value="">All Products</option>

    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <option value="<?php echo e($product->id); ?>"
            <?php echo e(request('product_id') == $product->id ? 'selected' : ''); ?>>

            <?php echo e($product->prod_name); ?>


        </option>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</select>

                </div>

                <!-- Status -->
                <div class="col-md-2 mb-2">

                    <label class="form-label">Status</label>

                    <select name="status"
                            class="form-control">

                        <option value="">All</option>

                        <option value="active"
                            <?php echo e(request('status')=='active' ? 'selected' : ''); ?>>
                            Active
                        </option>

                        <option value="inactive"
                            <?php echo e(request('status')=='inactive' ? 'selected' : ''); ?>>
                            Inactive
                        </option>

                    </select>

                </div>

                <!-- Buttons -->
                <div class="col-md-1 d-flex align-items-end mb-2">

                    <button class="btn btn-primary w-100">

                        <i class="bi bi-search"></i>

                    </button>

                </div>

            </div>

            <div class="mt-2">

                <a href="<?php echo e(route('product-freezing.index')); ?>"
                   class="btn btn-secondary btn-sm">

                    <i class="bi bi-arrow-clockwise"></i>

                    Reset

                </a>

            </div>

        </form>

    </div>
</div>
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
    <span class="badge <?php echo e(strtolower($row->product->status) === 'active' ? 'bg-success' : 'bg-danger'); ?>">
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
<?php if($records->count()): ?>
    <?php echo $__env->make('product_freezing.modal_edit', [
        'records' => $records,
        'products' => $products
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>
<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
 <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
 $(document).ready(function () {

    // Filter dropdown
    $('.product-filter').select2({
        width: '100%',
        placeholder: 'All Products',
        allowClear: true
    });

    // Modal dropdown
    $('#freezeModal .modal-product').select2({
        dropdownParent: $('#freezeModal'),
        width: '100%'
    });

    // Status change inside modal
    $('#freezeModal').on('change', '#product_id', function () {

        let status = $(this).find(':selected').data('status');

        if (status === 'Active') {
            $('#status').val('Inactive');
        } else {
            $('#status').val(status);
        }

    });

});
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\probox\resources\views/product_freezing/index.blade.php ENDPATH**/ ?>