

<?php $__env->startSection('content'); ?>

<div class="container-fluid">

    <div class="page-title-box d-flex justify-content-between">

        <h4 class="page-title">
            Edit Purchase Order
        </h4>

        <a href="<?php echo e(route('purchase_orders.index')); ?>"
           class="btn btn-secondary">
            Back
        </a>

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


    <form action="<?php echo e(route('purchase_orders.update', $purchaseOrder)); ?>"
          method="POST">

        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>


        <div class="card">

            <div class="card-body">

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Party Name *
                        </label>

                        <input type="text"
                               name="party_name"
                               class="form-control"
                               value="<?php echo e(old('party_name', $purchaseOrder->party_name)); ?>"
                               required>

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            PO Code
                        </label>

                        <input type="text"
                               class="form-control"
                               value="<?php echo e($purchaseOrder->po_code); ?>"
                               readonly>

                    </div>


                    <div class="col-md-12 mb-3">

                        <label class="form-label">
                            Party Address
                        </label>

                        <textarea name="party_address"
                                  class="form-control"
                                  rows="2"><?php echo e(old('party_address', $purchaseOrder->party_address)); ?></textarea>

                    </div>


                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            PO Date *
                        </label>

                        <input type="date"
                               name="po_date"
                               class="form-control"
                               value="<?php echo e(old('po_date', $purchaseOrder->po_date->format('Y-m-d'))); ?>"
                               required>

                    </div>


                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Delivery Date
                        </label>

                        <input type="date"
                               name="delivery_date"
                               class="form-control"
                               value="<?php echo e(old(
                                   'delivery_date',
                                   $purchaseOrder->delivery_date
                                       ? $purchaseOrder->delivery_date->format('Y-m-d')
                                       : ''
                               )); ?>">

                    </div>


                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Assign To
                        </label>

                        <input type="text"
                               name="assign_to"
                               class="form-control"
                               value="<?php echo e(old('assign_to', $purchaseOrder->assign_to)); ?>">

                    </div>


                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Prepared By
                        </label>

                        <input type="text"
                               class="form-control"
                               value="<?php echo e($purchaseOrder->preparedBy->name ?? ''); ?>"
                               readonly>

                    </div>


                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Print By
                        </label>

                        <input type="text"
                               name="print_by"
                               class="form-control"
                               value="<?php echo e(old('print_by', $purchaseOrder->print_by)); ?>">

                    </div>


                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Machine Size *
                        </label>

                        <select name="machine_size"
                                class="form-select"
                                required>

                            <?php $__currentLoopData = [
                                '28 x 40',
                                '4 color',
                                '5 color',
                                '25 x 36',
                                '20 x 28'
                            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $machineSize): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <option value="<?php echo e($machineSize); ?>"
                                    <?php echo e(old(
                                        'machine_size',
                                        $purchaseOrder->machine_size
                                    ) == $machineSize ? 'selected' : ''); ?>>

                                    <?php echo e($machineSize); ?>


                                </option>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </select>

                    </div>

                </div>

            </div>

        </div>


        <div class="card mt-3">

            <div class="card-body">

                <div class="d-flex justify-content-between mb-3">

                    <h4 class="header-title">
                        Items
                    </h4>

                    <button type="button"
                            class="btn btn-primary"
                            id="addItem">

                        + Add Item

                    </button>

                </div>


                <div class="table-responsive">

                    <table class="table table-bordered">

                        <thead>

                            <tr>

                                <th width="60">
                                    #
                                </th>

                                <th>
                                    Item Name
                                </th>

                                <th width="220">
                                    Quantity
                                </th>

                                <th width="80">
                                    Action
                                </th>

                            </tr>

                        </thead>

                        <tbody id="itemsBody">

                            <?php $__currentLoopData = $purchaseOrder->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <tr class="item-row">

                                    <td class="row-number">
                                        <?php echo e($index + 1); ?>

                                    </td>

                                    <td>

                                        <input type="text"
                                               name="items[<?php echo e($index); ?>][item_name]"
                                               class="form-control"
                                               value="<?php echo e($item->item_name); ?>"
                                               required>

                                    </td>

                                    <td>

                                        <input type="number"
                                               name="items[<?php echo e($index); ?>][quantity]"
                                               class="form-control quantity"
                                               value="<?php echo e($item->quantity); ?>"
                                               min="1"
                                               required>

                                    </td>

                                    <td class="text-center">

                                        <button type="button"
                                                class="btn btn-danger btn-sm remove-item">

                                            <i class="mdi mdi-delete"></i>

                                        </button>

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

                                    <input type="text"
                                           id="totalQuantity"
                                           class="form-control fw-bold"
                                           value="<?php echo e($purchaseOrder->total_quantity); ?>"
                                           readonly>

                                </th>

                                <th></th>

                            </tr>

                        </tfoot>

                    </table>

                </div>


                <div class="text-end mt-3">

                    <a href="<?php echo e(route('purchase_orders.index')); ?>"
                       class="btn btn-light">

                        Cancel

                    </a>

                    <button type="submit"
                            class="btn btn-success">

                        Update Purchase Order

                    </button>

                </div>

            </div>

        </div>

    </form>

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {

    let itemIndex = <?php echo e($purchaseOrder->items->count()); ?>;

    const body = document.getElementById('itemsBody');

    const total = document.getElementById('totalQuantity');


    function calculateTotal() {

        let sum = 0;

        body.querySelectorAll('.quantity').forEach(input => {

            sum += parseInt(input.value) || 0;

        });

        total.value = sum;

    }


    function updateRows() {

        const rows = body.querySelectorAll('.item-row');

        rows.forEach((row, index) => {

            row.querySelector('.row-number').textContent = index + 1;

        });

        const buttons = body.querySelectorAll('.remove-item');

        buttons.forEach(button => {

            button.disabled = buttons.length === 1;

        });

    }


    document.getElementById('addItem')
        .addEventListener('click', function () {

            const row = document.createElement('tr');

            row.className = 'item-row';

            row.innerHTML = `

                <td class="row-number"></td>

                <td>

                    <input type="text"
                           name="items[${itemIndex}][item_name]"
                           class="form-control"
                           required>

                </td>

                <td>

                    <input type="number"
                           name="items[${itemIndex}][quantity]"
                           class="form-control quantity"
                           min="1"
                           value="1"
                           required>

                </td>

                <td class="text-center">

                    <button type="button"
                            class="btn btn-danger btn-sm remove-item">

                        <i class="mdi mdi-delete"></i>

                    </button>

                </td>

            `;

            body.appendChild(row);

            itemIndex++;

            updateRows();

            calculateTotal();

        });


    body.addEventListener('click', function (event) {

        const button =
            event.target.closest('.remove-item');

        if (!button) return;

        button.closest('.item-row').remove();

        updateRows();

        calculateTotal();

    });


    body.addEventListener('input', function (event) {

        if (event.target.classList.contains('quantity')) {

            calculateTotal();

        }

    });


    updateRows();

    calculateTotal();

});

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\probox\resources\views/purchase_orders/edit.blade.php ENDPATH**/ ?>