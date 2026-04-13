
<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Softix</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Forms</a></li>
                        <li class="breadcrumb-item active">Edit Bank Payment</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Bank Payment</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible text-bg-success border-0 fade show" role="alert">
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                aria-label="Close"></button>
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form id="voucherForm" 
                          action="<?php echo e(route('bank_payment.update', $voucher->first()->v_no)); ?>" 
                          method="POST" 
                          enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <input type="hidden" name="v_type" value="BPV">
                        <input type="hidden" id="invoice" name="invoice_number">
                        <input type="hidden" id="totalAmount" name="total_amount">

                        <div class="d-flex gap-2 mt-2">
                            <button type="button" id="addEntry" class="btn btn-primary btn-sm">Add Entry</button>
                            <button type="submit" class="btn btn-success btn-sm">Submit</button>
                        </div>

                        <!-- Invoice Display -->
                        <h3 class="mt-4">Invoice <span id="invoiceDisplay"></span></h3>

                        <!-- Entries Table -->
                        <div class="col-lg-12">
                            <table class="table mt-4" id="entriesTable">
                                <thead>
                                    <tr>
                                        <th>Sr No</th>
                                        <th>Date</th>
                                        <th>Cash</th>
                                        <th>Account Title</th>
                                        <th>Description</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="entriesBody">
                                    <?php $__currentLoopData = $voucher; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="sr-no"></td>
                                            <td>
                                                <input type="date" 
                                                       name="entries[<?php echo e($entry->id); ?>][date]" 
                                                       class="form-control" 
                                                       value="<?php echo e($entry->date); ?>">
                                                <input type="hidden" 
                                                       name="entries[<?php echo e($entry->id); ?>][id]" 
                                                       value="<?php echo e($entry->id); ?>">
                                            </td>
                                            <td>
                                                <select name="entries[<?php echo e($entry->id); ?>][cash]" class="form-control select2">
                                                    <option value="">Select</option>
                                                    <?php $__currentLoopData = $accountMasters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($account->id); ?>" 
                                                            <?php if($entry->cash_id == $account->id): echo 'selected'; endif; ?>>
                                                            <?php echo e($account->title); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="entries[<?php echo e($entry->id); ?>][account]" class="form-control select2">
                                                    <option value="">Select</option>
                                                    <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($account->id); ?>" 
                                                            <?php if($entry->account_id == $account->id): echo 'selected'; endif; ?>>
                                                            <?php echo e($account->title); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" 
                                                       name="entries[<?php echo e($entry->id); ?>][description]" 
                                                       class="form-control" 
                                                       value="<?php echo e($entry->description); ?>">
                                            </td>
                                            <td>
                                                <input type="number" 
                                                       name="entries[<?php echo e($entry->id); ?>][debit]" 
                                                       class="form-control" 
                                                       value="<?php echo e($entry->debit); ?>">
                                            </td>
                                            <td>
                                                <button type="button" 
                                                        class="btn btn-danger btn-sm remove-entry" 
                                                        data-id="<?php echo e($entry->id); ?>">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const addEntryButton = document.getElementById('addEntry');
    const entriesTable = document.getElementById('entriesBody');

    // Add new row
    addEntryButton.addEventListener('click', function () {
        const entryKey = 'new_' + Date.now();
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td class="sr-no"></td>
            <td>
                <input type="date" name="entries[${entryKey}][date]" 
                       class="form-control" value="<?php echo e(date('Y-m-d')); ?>">
            </td>
            <td>
                <select name="entries[${entryKey}][cash]" class="form-control select2">
                    <option value="">Select</option>
                    <?php $__currentLoopData = $accountMasters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($account->id); ?>"><?php echo e($account->title); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </td>
            <td>
                <select name="entries[${entryKey}][account]" class="form-control select2">
                    <option value="">Select</option>
                    <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($account->id); ?>"><?php echo e($account->title); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </td>
            <td>
                <input type="text" name="entries[${entryKey}][description]" class="form-control">
            </td>
            <td>
                <input type="number" name="entries[${entryKey}][debit]" class="form-control" value="0">
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm remove-entry">Delete</button>
            </td>
        `;
        entriesTable.appendChild(newRow);
        updateSrNo();
        bindRemove(newRow);
    });

    // Remove row
    function bindRemove(row) {
        row.querySelector('.remove-entry').addEventListener('click', function () {
            const btn = this;
            const entryId = btn.getAttribute('data-id');
            if (entryId) {
                if (confirm('Are you sure you want to delete this entry?')) {
                    fetch(`/probox/bank_payment-delete/${entryId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                    })
                    .then(response => {
                        if (response) {
                            row.remove();
                            updateSrNo();
                        } else {
                            alert('Failed to delete entry.');
                        }
                    })
                    .catch(() => alert('Failed to delete entry.'));
                }
            } else {
                row.remove();
                updateSrNo();
            }
        });
    }

    // Bind remove for existing rows
    entriesTable.querySelectorAll('.remove-entry').forEach(btn => {
        bindRemove(btn.closest('tr'));
    });

    // Update serial numbers
    function updateSrNo() {
        Array.from(entriesTable.rows).forEach((r, i) => {
            r.querySelector('.sr-no').textContent = i + 1;
        });
    }

    updateSrNo();
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/realerp/public_html/probox/resources/views/bank_reports/edit.blade.php ENDPATH**/ ?>