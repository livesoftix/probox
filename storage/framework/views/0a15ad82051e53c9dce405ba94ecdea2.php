

<?php $__env->startSection('content'); ?>

<div class="container-fluid">

    <div class="row">
        <div class="col-12">

            <div class="page-title-box d-flex justify-content-between align-items-center">

                <div>
                    <h4 class="page-title">
                        Create Purchase Order
                    </h4>
                </div>

                <div>
                    <a href="<?php echo e(route('purchase_orders.index')); ?>"
                       class="btn btn-secondary">
                        <i class="mdi mdi-arrow-left"></i>
                        Back
                    </a>
                </div>

            </div>

        </div>
    </div>


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


    <form action="<?php echo e(route('purchase_orders.store')); ?>"
          method="POST">

        <?php echo csrf_field(); ?>

        <div class="card">

            <div class="card-body">

                <h4 class="header-title mb-4">
                    Purchase Order Details
                </h4>


                <div class="row">

                    
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Party Name <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               name="party_name"
                               class="form-control"
                               value="<?php echo e(old('party_name')); ?>"
                               placeholder="Enter party name"
                               required>

                    </div>


                    
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            PO Code
                        </label>

                        <input type="text"
                               name="po_code"
                               class="form-control"
                               value="<?php echo e($poCode); ?>"
                               readonly>

                    </div>


                    
                    <div class="col-md-12 mb-3">

                        <label class="form-label">
                            Party Address
                        </label>

                        <textarea name="party_address"
                                  class="form-control"
                                  rows="2"
                                  placeholder="Enter party address"><?php echo e(old('party_address')); ?></textarea>

                    </div>


                    
                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            PO Date <span class="text-danger">*</span>
                        </label>

                        <input type="date"
                               name="po_date"
                               class="form-control"
                               value="<?php echo e(old('po_date', date('Y-m-d'))); ?>"
                               required>

                    </div>


                    
                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Delivery Date
                        </label>

                        <input type="date"
                               name="delivery_date"
                               class="form-control"
                               value="<?php echo e(old('delivery_date')); ?>">

                    </div>


                    
                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Assign To
                        </label>

                        <input type="text"
                               name="assign_to"
                               class="form-control"
                               value="<?php echo e(old('assign_to')); ?>"
                               placeholder="Enter assigned person">

                    </div>


                    
                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Prepared By
                        </label>

                        <input type="text"
                               class="form-control"
                               value="<?php echo e(auth()->user()->name ?? ''); ?>"
                               readonly>

                    </div>


                    
                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Print By
                        </label>

                        <input type="text"
                               name="print_by"
                               class="form-control"
                               value="<?php echo e(old('print_by')); ?>"
                               placeholder="Enter print by">

                    </div>


                    
                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Machine Size <span class="text-danger">*</span>
                        </label>

                        <select name="machine_size"
                                class="form-select"
                                required>

                            <option value="">
                                Select Machine Size
                            </option>

                            <?php $__currentLoopData = [
                                '28 x 40',
                                '4 color',
                                '5 color',
                                '25 x 36',
                                '20 x 28'
                            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $machineSize): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <option value="<?php echo e($machineSize); ?>"
                                    <?php echo e(old('machine_size') == $machineSize ? 'selected' : ''); ?>>

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

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <h4 class="header-title mb-0">
                        Purchase Order Items
                    </h4>

                    <button type="button"
                            class="btn btn-primary"
                            id="addItem">

                        <i class="mdi mdi-plus"></i>
                        Add Item

                    </button>

                </div>


                <div class="table-responsive">

                    <table class="table table-bordered"
                           id="itemsTable">

                        <thead>

                            <tr>

                                <th style="width: 60px;">
                                    #
                                </th>

                                <th>
                                    Item Name
                                </th>

                                <th style="width: 220px;">
                                    Quantity
                                </th>

                                <th style="width: 80px;">
                                    Action
                                </th>

                            </tr>

                        </thead>


                        <tbody id="itemsBody">

                            <tr class="item-row">

                                <td class="row-number">
                                    1
                                </td>

                                <td>

                                    <input type="text"
                                           name="items[0][item_name]"
                                           class="form-control"
                                           placeholder="Enter item name"
                                           required>

                                </td>

                                <td>

                                    <input type="number"
                                           name="items[0][quantity]"
                                           class="form-control quantity"
                                           min="1"
                                           value="1"
                                           required>

                                </td>

                                <td class="text-center">

                                    <button type="button"
                                            class="btn btn-danger btn-sm remove-item"
                                            disabled>

                                        <i class="mdi mdi-delete"></i>

                                    </button>

                                </td>

                            </tr>

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
                                           value="1"
                                           readonly>

                                </th>

                                <th></th>

                            </tr>

                        </tfoot>

                    </table>

                </div>


                <div class="mt-4 text-end">

                    <a href="<?php echo e(route('purchase_orders.index')); ?>"
                       class="btn btn-light me-2">

                        Cancel

                    </a>

                    <button type="submit"
                            class="btn btn-success">

                        <i class="mdi mdi-content-save"></i>
                        Save Purchase Order

                    </button>

                </div>

            </div>

        </div>

    </form>

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {

    let itemIndex = 1;

    const itemsBody = document.getElementById('itemsBody');

    const addItemButton = document.getElementById('addItem');

    const totalQuantity = document.getElementById('totalQuantity');


    function updateNumbers() {

        const rows = itemsBody.querySelectorAll('.item-row');

        rows.forEach((row, index) => {

            row.querySelector('.row-number').textContent = index + 1;

        });

    }


    function calculateTotal() {

        let total = 0;

        const quantities = itemsBody.querySelectorAll('.quantity');

        quantities.forEach(input => {

            const value = parseInt(input.value) || 0;

            total += value;

        });

        totalQuantity.value = total;

    }


    function updateRemoveButtons() {

        const buttons =
            itemsBody.querySelectorAll('.remove-item');

        buttons.forEach(button => {

            button.disabled = buttons.length === 1;

        });

    }


    addItemButton.addEventListener('click', function () {

        const row = document.createElement('tr');

        row.classList.add('item-row');

        row.innerHTML = `

            <td class="row-number"></td>

            <td>

                <input type="text"
                       name="items[${itemIndex}][item_name]"
                       class="form-control"
                       placeholder="Enter item name"
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

        itemsBody.appendChild(row);

        itemIndex++;

        updateNumbers();

        updateRemoveButtons();

        calculateTotal();

    });


    itemsBody.addEventListener('click', function (event) {

        const button =
            event.target.closest('.remove-item');

        if (!button) {
            return;
        }

        const row = button.closest('.item-row');

        row.remove();

        updateNumbers();

        updateRemoveButtons();

        calculateTotal();

    });


    itemsBody.addEventListener('input', function (event) {

        if (event.target.classList.contains('quantity')) {

            calculateTotal();

        }

    });


    updateNumbers();

    updateRemoveButtons();

    calculateTotal();

});

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\probox\resources\views/purchase_orders/create.blade.php ENDPATH**/ ?>