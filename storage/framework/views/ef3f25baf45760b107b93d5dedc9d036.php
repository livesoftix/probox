

<?php $__env->startSection('content'); ?>

<div class="container-fluid">

    
    <div class="row mb-3">
        <div class="col-12">
            <div class="page-title-box d-flex justify-content-between align-items-center">

                <div>
                    <h4 class="page-title mb-1">Create Quotation</h4>
                    <p class="text-muted mb-0">
                        Create a quotation for your customer
                    </p>
                </div>

                <a href="<?php echo e(route('quotations.index')); ?>"
                   class="btn btn-light border">
                    <i class="mdi mdi-arrow-left me-1"></i>
                    Back
                </a>

            </div>
        </div>
    </div>


    
    <div class="row">

        <div class="col-12">

            <form action="<?php echo e(route('quotations.store')); ?>"
                  method="POST">

                <?php echo csrf_field(); ?>

                <div class="card quotation-form-card">


                    
                    <div class="card-header bg-white border-bottom">

                        <div class="d-flex align-items-center">

                            <div class="section-icon">
                                <i class="mdi mdi-file-document-outline"></i>
                            </div>

                            <div>
                                <h5 class="mb-0">
                                    Quotation Information
                                </h5>

                                <small class="text-muted">
                                    Enter customer and quotation date
                                </small>
                            </div>

                        </div>

                    </div>


                    <div class="card-body">

                        <div class="row g-3">

                            
                            <div class="col-md-4">

                                <label class="form-label">
                                    Date
                                    <span class="text-danger">*</span>
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">
                                        <i class="mdi mdi-calendar-outline"></i>
                                    </span>

                                    <input
                                        type="date"
                                        name="date"
                                        class="form-control"
                                        value="<?php echo e(old('date', date('Y-m-d'))); ?>"
                                        required>

                                </div>

                                <?php $__errorArgs = ['date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <small class="text-danger">
                                        <?php echo e($message); ?>

                                    </small>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                            </div>


                            
                            <div class="col-md-8">

                                <label class="form-label">
                                    Party Name
                                    <span class="text-danger">*</span>
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">
                                        <i class="mdi mdi-account-outline"></i>
                                    </span>

                                    <select
                                        name="party_id"
                                        class="form-control select2"
                                        required>

                                        <option value="">
                                            Select Party
                                        </option>

                                        <?php $__currentLoopData = $parties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $party): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                            <option
                                                value="<?php echo e($party->id); ?>"
                                                <?php echo e(old('party_id') == $party->id ? 'selected' : ''); ?>>

                                                <?php echo e($party->title); ?>


                                            </option>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </select>

                                </div>

                                <?php $__errorArgs = ['party_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <small class="text-danger">
                                        <?php echo e($message); ?>

                                    </small>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                            </div>

                        </div>

                    </div>


                    
                    <div class="card-header bg-white border-top border-bottom">

                        <div class="d-flex justify-content-between align-items-center">

                            <div class="d-flex align-items-center">

                                <div class="section-icon section-icon-blue">
                                    <i class="mdi mdi-package-variant"></i>
                                </div>

                                <div>
                                    <h5 class="mb-0">
                                        Quotation Items
                                    </h5>

                                    <small class="text-muted">
                                        Add one or more items and their rates
                                    </small>
                                </div>

                            </div>


                            <button
                                type="button"
                                id="addItem"
                                class="btn btn-primary">

                                <i class="mdi mdi-plus me-1"></i>
                                Add Item

                            </button>

                        </div>

                    </div>


                    <div class="card-body p-0">

                        <div class="table-responsive">

                            <table
                                class="table quotation-table mb-0"
                                id="quotationItems">

                                <thead>

                                    <tr>

                                        <th class="text-center"
                                            style="width:60px;">
                                            #
                                        </th>

                                        <th style="width:25%;">
                                            Item Name
                                        </th>

                                        <th>
                                            Item Details
                                        </th>

                                        <th style="width:180px;">
                                            Rate
                                        </th>

                                        <th class="text-center"
                                            style="width:70px;">
                                            Action
                                        </th>

                                    </tr>

                                </thead>


                                <tbody>

                                    
                                    <tr>

                                        <td class="text-center item-number">
                                            1
                                        </td>

                                        <td>

                                            <input
                                                type="text"
                                                name="items[0][name]"
                                                class="form-control"
                                                placeholder="Enter item name"
                                                required>

                                        </td>

                                        <td>

                                            <textarea
                                                name="items[0][details]"
                                                class="form-control"
                                                rows="2"
                                                placeholder="Enter item details..."
                                                required></textarea>

                                        </td>

                                        <td>

                                            <div class="input-group">

                                                <span class="input-group-text">
                                                    Rs.
                                                </span>

                                                <input
                                                    type="number"
                                                    name="items[0][rate]"
                                                    class="form-control"
                                                    step="0.01"
                                                    min="0"
                                                    placeholder="0.00"
                                                    required>

                                            </div>

                                        </td>

                                        <td class="text-center">

                                            <button
                                                type="button"
                                                class="btn btn-outline-danger btn-sm remove-item"
                                                title="Remove Item">

                                                <i class="mdi mdi-delete-outline"></i>

                                            </button>

                                        </td>

                                    </tr>

                                </tbody>

                            </table>

                        </div>

                    </div>


                    
                    <div class="card-footer bg-white border-top">

                        <div class="d-flex justify-content-between align-items-center">

                            <div class="text-muted small">

                                <i class="mdi mdi-information-outline me-1"></i>

                                Add all items that you want to include in this quotations.

                            </div>


                            <div class="d-flex gap-2">

                                <a
                                    href="<?php echo e(route('quotations.index')); ?>"
                                    class="btn btn-light border">

                                    Cancel

                                </a>

                                <button
                                    type="submit"
                                    class="btn btn-primary px-4">

                                    <i class="mdi mdi-content-save-outline me-1"></i>

                                    Save Quotation

                                </button>

                            </div>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>

</div>



<script>

document.addEventListener('DOMContentLoaded', function () {

    let itemIndex = 1;

    const tbody = document.querySelector('#quotationItems tbody');

    const addButton = document.getElementById('addItem');


    /*
    |--------------------------------------------------------------------------
    | Add Item
    |--------------------------------------------------------------------------
    */

    addButton.addEventListener('click', function () {

        const row = document.createElement('tr');

        row.innerHTML = `

            <td class="text-center item-number"></td>

            <td>

                <input
                    type="text"
                    name="items[${itemIndex}][name]"
                    class="form-control"
                    placeholder="Enter item name"
                    required>

            </td>

            <td>

                <textarea
                    name="items[${itemIndex}][details]"
                    class="form-control"
                    rows="2"
                    placeholder="Enter item details..."
                    required></textarea>

            </td>

            <td>

                <div class="input-group">

                    <span class="input-group-text">
                        Rs.
                    </span>

                    <input
                        type="number"
                        name="items[${itemIndex}][rate]"
                        class="form-control"
                        step="0.01"
                        min="0"
                        placeholder="0.00"
                        required>

                </div>

            </td>

            <td class="text-center">

                <button
                    type="button"
                    class="btn btn-outline-danger btn-sm remove-item"
                    title="Remove Item">

                    <i class="mdi mdi-delete-outline"></i>

                </button>

            </td>

        `;

        tbody.appendChild(row);

        itemIndex++;

        updateNumbers();

    });


    /*
    |--------------------------------------------------------------------------
    | Remove Item
    |--------------------------------------------------------------------------
    */

    tbody.addEventListener('click', function (event) {

        const button = event.target.closest('.remove-item');

        if (!button) {
            return;
        }

        const rows = tbody.querySelectorAll('tr');

        if (rows.length === 1) {

            alert('At least one item is required.');

            return;
        }

        button.closest('tr').remove();

        updateNumbers();

    });


    /*
    |--------------------------------------------------------------------------
    | Update Serial Numbers
    |--------------------------------------------------------------------------
    */

    function updateNumbers() {

        const rows = tbody.querySelectorAll('tr');

        rows.forEach(function (row, index) {

            const number = row.querySelector('.item-number');

            if (number) {
                number.textContent = index + 1;
            }

        });

    }

});

</script>



<style>

.quotation-form-card {
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
}


/* Section Icon */

.section-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;

    display: flex;
    align-items: center;
    justify-content: center;

    margin-right: 12px;

    background: #eef2ff;
    color: #4f46e5;

    font-size: 20px;
}

.section-icon-blue {
    background: #eff6ff;
    color: #2563eb;
}


/* Labels */

.form-label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 7px;
}


/* Inputs */

.form-control,
.input-group-text,
.select2-container .select2-selection--single {
    border-color: #dfe3e8;
}


.form-control:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 0.15rem rgba(99, 102, 241, 0.10);
}


/* Table */

.quotation-table {
    border-collapse: separate;
    border-spacing: 0;
}


.quotation-table thead th {
    background: #f8fafc;
    color: #475569;
    font-size: 13px;
    font-weight: 700;

    padding: 13px 14px;

    border-bottom: 1px solid #e5e7eb;
    white-space: nowrap;
}


.quotation-table tbody td {
    padding: 14px;
    vertical-align: middle;
    border-bottom: 1px solid #edf0f3;
}


.quotation-table tbody tr:hover {
    background: #fafbfc;
}


.item-number {
    font-weight: 600;
    color: #64748b;
}


/* Textarea */

.quotation-table textarea {
    resize: vertical;
    min-height: 60px;
}


/* Footer */

.card-footer {
    padding: 16px 20px;
}


/* Mobile */

@media (max-width: 768px) {

    .card-footer > div {
        flex-direction: column;
        align-items: stretch !important;
        gap: 15px;
    }

    .quotation-table {
        min-width: 850px;
    }

}

</style>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\probox\resources\views/quotations/form.blade.php ENDPATH**/ ?>