

<?php $__env->startSection('content'); ?>

<div class="container-fluid">

    <div class="row">
        <div class="col-12">

            <div class="page-title-box d-flex justify-content-between align-items-center">

                <h4 class="page-title">
                    Purchase Orders
                </h4>

                <a href="<?php echo e(route('purchase_orders.create')); ?>"
                   class="btn btn-primary">

                    <i class="mdi mdi-plus"></i>
                    Create Purchase Order

                </a>

            </div>

        </div>
    </div>


    <?php if(session('success')): ?>

        <div class="alert alert-success alert-dismissible fade show">

            <?php echo e(session('success')); ?>


            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    <?php endif; ?>


    <div class="card">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead>

                        <tr>

                            <th>#</th>

                            <th>PO Code</th>

                            <th>Party Name</th>

                            <th>PO Date</th>

                            <th>Delivery Date</th>

                            <th>Machine Size</th>

                            <th>Total Quantity</th>

                            <th>Prepared By</th>

                            <th width="180">
                                Action
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php $__empty_1 = true; $__currentLoopData = $purchaseOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $purchaseOrder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                            <tr>

                                <td>
                                    <?php echo e($loop->iteration + ($purchaseOrders->currentPage() - 1) * $purchaseOrders->perPage()); ?>

                                </td>

                                <td>
                                    <strong>
                                        <?php echo e($purchaseOrder->po_code); ?>

                                    </strong>
                                </td>

                                <td>
                                    <?php echo e($purchaseOrder->party_name); ?>

                                </td>

                                <td>
                                    <?php echo e(optional($purchaseOrder->po_date)->format('d-m-Y')); ?>

                                </td>

                                <td>
                                    <?php echo e(optional($purchaseOrder->delivery_date)->format('d-m-Y') ?? '-'); ?>

                                </td>

                                <td>
                                    <?php echo e($purchaseOrder->machine_size); ?>

                                </td>

                                <td>
                                    <?php echo e(number_format($purchaseOrder->total_quantity)); ?>

                                </td>

                                <td>
                                    <?php echo e($purchaseOrder->preparedBy->name ?? '-'); ?>

                                </td>

                                <td>

                                    <a href="<?php echo e(route('purchase_orders.show', $purchaseOrder)); ?>"
                                       class="btn btn-info btn-sm"
                                       title="View">

                                        <i class="mdi mdi-eye"></i>

                                    </a>


                                    <a href="<?php echo e(route('purchase_orders.edit', $purchaseOrder)); ?>"
                                       class="btn btn-warning btn-sm"
                                       title="Edit">

                                        <i class="mdi mdi-pencil"></i>

                                    </a>


                                    <a href="<?php echo e(route('purchase_orders.print', $purchaseOrder)); ?>"
                                       target="_blank"
                                       class="btn btn-secondary btn-sm"
                                       title="Print">

                                        <i class="mdi mdi-printer"></i>

                                    </a>


                                    <form action="<?php echo e(route('purchase_orders.destroy', $purchaseOrder)); ?>"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this Purchase Order?');">

                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>

                                        <button type="submit"
                                                class="btn btn-danger btn-sm"
                                                title="Delete">

                                            <i class="mdi mdi-delete"></i>

                                        </button>

                                    </form>

                                </td>

                            </tr>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                            <tr>

                                <td colspan="9"
                                    class="text-center py-4">

                                    No Purchase Orders found.

                                </td>

                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>


            <div class="mt-3">

                <?php echo e($purchaseOrders->links()); ?>


            </div>

        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\probox\resources\views/purchase_orders/index.blade.php ENDPATH**/ ?>