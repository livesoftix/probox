

<?php $__env->startSection('content'); ?>

<div class="container-fluid">

    <div class="page-title-box d-flex justify-content-between">

        <h4 class="page-title">
            Purchase Order <?php echo e($purchaseOrder->po_code); ?>

        </h4>

        <div>

            <a href="<?php echo e(route('purchase_orders.edit', $purchaseOrder)); ?>"
               class="btn btn-warning">

                <i class="mdi mdi-pencil"></i>
                Edit

            </a>

            <a href="<?php echo e(route('purchase_orders.print', $purchaseOrder)); ?>"
               target="_blank"
               class="btn btn-secondary">

                <i class="mdi mdi-printer"></i>
                Print

            </a>

            <a href="<?php echo e(route('purchase_orders.index')); ?>"
               class="btn btn-light">

                Back

            </a>

        </div>

    </div>


    <div class="card">

        <div class="card-body">

            <div class="row mb-4">

                <div class="col-md-6">

                    <h5>
                        Party Information
                    </h5>

                    <p class="mb-1">
                        <strong>Party Name:</strong>
                        <?php echo e($purchaseOrder->party_name); ?>

                    </p>

                    <p class="mb-1">
                        <strong>Address:</strong>
                        <?php echo e($purchaseOrder->party_address ?? '-'); ?>

                    </p>

                </div>


                <div class="col-md-6">

                    <h5>
                        Purchase Order Information
                    </h5>

                    <p class="mb-1">
                        <strong>PO Code:</strong>
                        <?php echo e($purchaseOrder->po_code); ?>

                    </p>

                    <p class="mb-1">
                        <strong>PO Date:</strong>
                        <?php echo e($purchaseOrder->po_date->format('d-m-Y')); ?>

                    </p>

                    <p class="mb-1">
                        <strong>Delivery Date:</strong>
                        <?php echo e($purchaseOrder->delivery_date
                            ? $purchaseOrder->delivery_date->format('d-m-Y')
                            : '-'); ?>

                    </p>

                    <p class="mb-1">
                        <strong>Machine Size:</strong>
                        <?php echo e($purchaseOrder->machine_size); ?>

                    </p>

                </div>

            </div>


            <div class="row mb-4">

                <div class="col-md-4">

                    <strong>Assign To:</strong>
                    <?php echo e($purchaseOrder->assign_to ?? '-'); ?>


                </div>

                <div class="col-md-4">

                    <strong>Prepared By:</strong>
                    <?php echo e($purchaseOrder->preparedBy->name ?? '-'); ?>


                </div>

                <div class="col-md-4">

                    <strong>Print By:</strong>
                    <?php echo e($purchaseOrder->print_by ?? '-'); ?>


                </div>

            </div>


            <div class="table-responsive">

                <table class="table table-bordered">

                    <thead>

                        <tr>

                            <th width="80">
                                #
                            </th>

                            <th>
                                Item Name
                            </th>

                            <th width="200">
                                Quantity
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php $__currentLoopData = $purchaseOrder->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <tr>

                                <td>
                                    <?php echo e($loop->iteration); ?>

                                </td>

                                <td>
                                    <?php echo e($item->item_name); ?>

                                </td>

                                <td>
                                    <?php echo e(number_format($item->quantity)); ?>

                                </td>

                            </tr>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </tbody>

                    <tfoot>

                        <tr>

                            <th colspan="2"
                                class="text-end">

                                Total Quantity

                            </th>

                            <th>

                                <?php echo e(number_format($purchaseOrder->total_quantity)); ?>


                            </th>

                        </tr>

                    </tfoot>

                </table>

            </div>

        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\probox\resources\views/purchase_orders/show.blade.php ENDPATH**/ ?>