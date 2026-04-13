
<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Softix</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                            <li class="breadcrumb-item active">Edit Cash Receipt</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Edit Cash Receipt</h4>
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
                        <div class="tab-content">
                            <div class="tab-pane show active" id="input-types-preview">
                                <div class="row">
                                    <form id="voucherForm" action="<?php echo e(route('cash.update', $voucher->first()->v_no)); ?>"
                                        method="POST" enctype="multipart/form-data">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>

                                        <input type="hidden" name="v_type" value="CRV">
                                        <input type="hidden" name="invoice_number" value="<?php echo e($voucher->first()->v_no); ?>">
                                        <input type="hidden" id="totalAmount" name="total_amount">

                                        <div class="row mb-3">
                                            <div class="col-auto">
                                                <button type="button" id="addEntry" class="btn btn-primary btn-sm">Add
                                                    Entry</button>
                                            </div>
                                            <div class="col-auto">
                                                <button type="submit" class="btn btn-success btn-sm">Update
                                                    Entries</button>
                                            </div>
                                        </div>


                                        <!-- Invoice Display -->
                                        <h3 class="mt-4">Invoice <span
                                                id="invoiceDisplay"><?php echo e($voucher->first()->v_no); ?></span></h3>

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
                                                    <?php if($voucher && count($voucher) > 0): ?>
                                                        <?php $__currentLoopData = $voucher; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td><?php echo e($loop->iteration); ?></td>
                                                                <td>
                                                                    <input type="date"
                                                                        name="entries[<?php echo e($entry->id); ?>][date]"
                                                                        class="form-control" value="<?php echo e($entry->date); ?>">
                                                                </td>
                                                                <td>
                                                                    <select name="entries[<?php echo e($entry->id); ?>][cash]"
                                                                        class="form-control select2">
                                                                        <option value="">Select</option>
                                                                        <?php $__currentLoopData = $accountMasters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <option value="<?php echo e($account->id); ?>"
                                                                                <?php if($entry->cash_id == $account->id): ?> selected <?php endif; ?>>
                                                                                <?php echo e($account->title); ?></option>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select name="entries[<?php echo e($entry->id); ?>][account]"
                                                                        class="form-control select2">
                                                                        <option value="">Select</option>
                                                                        <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <option value="<?php echo e($account->id); ?>"
                                                                                <?php if($entry->account_id == $account->id): ?> selected <?php endif; ?>>
                                                                                <?php echo e($account->title); ?></option>
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
                                                                        name="entries[<?php echo e($entry->id); ?>][credit]"
                                                                        class="form-control" value="<?php echo e($entry->credit); ?>">
                                                                </td>
                                                                <td>
                                                                    <button type="button"
                                                                        class="btn btn-danger btn-sm remove-entry"
                                                                        data-id="<?php echo e($entry->id); ?>">Delete</button>
                                                                    <input type="hidden"
                                                                        name="entries[<?php echo e($entry->id); ?>][id]"
                                                                        value="<?php echo e($entry->id); ?>">
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php else: ?>
                                                        <tr>
                                                            <td colspan="7">No entries found for this voucher.</td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const voucherForm = document.getElementById('voucherForm');
    const addEntryButton = document.getElementById('addEntry');
    const entriesTable = document.getElementById('entriesBody');

    let locked = {};

    function updateSrNo() {
        Array.from(entriesTable.rows).forEach((r, i) => r.cells[0].textContent = i + 1);
    }

    function updateTotalAmount() {
        let sum = 0;
        entriesTable.querySelectorAll('input[name*="[credit]"]').forEach(el => {
            const v = parseFloat(el.value);
            if (!isNaN(v)) sum += v;
        });
        document.getElementById('totalAmount').value = sum;
    }

    // Helper to create and append a hidden input
    function appendHidden(name, value, id) {
        if (document.getElementById(id)) {
            document.getElementById(id).value = value;
            return;
        }
        const h = document.createElement('input');
        h.type = 'hidden';
        h.name = name;
        h.value = value;
        h.id = id;
        voucherForm.appendChild(h);
    }

    // Helper to remove hidden by id (if exists)
    function removeHidden(id) {
        const el = document.getElementById(id);
        if (el) el.remove();
    }

    // Protect a single existing row (disable visible fields and create per-row hidden inputs)
    function protectExistingRow(row) {
        // detect DB entry id (we render a hidden input entries[ID][id] in blade)
        const idHidden = row.querySelector('input[type="hidden"][name$="[id]"]');
        if (!idHidden) return null;
        const entryId = idHidden.value || idHidden.getAttribute('value');
        if (!entryId) return null;

        // No fields are locked now

        return entryId;
    }

    // Rebuild per-row protection for all existing rows (call at start)
    function protectAllExistingRows() {
        Array.from(entriesTable.rows).forEach(row => {
            protectExistingRow(row);
        });
    }

    // Lock voucher-level globals from the current first row
    function lockGlobalsFromFirstRow() {
        if (entriesTable.rows.length === 0) return;

        // Take the first row's entry id (the blade-rendered rows include entries[ID][id])
        const firstRow = entriesTable.rows[0];
        const idHidden = firstRow.querySelector('input[type="hidden"][name$="[id]"]');
        // No global locking for cash field
    }

    // Initial protection of existing rows and creation of globals
    protectAllExistingRows();
    lockGlobalsFromFirstRow();

    // Add Entry (new row) behavior
    addEntryButton.addEventListener('click', function() {
        const entryKey = Date.now();
        const newRow = entriesTable.insertRow();
        newRow.innerHTML = `
            <td></td>
            <td><input type="date" class="form-control" name="entries[${entryKey}][date]" value="<?php echo e(date('Y-m-d')); ?>"></td>
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
            <td><input type="text" class="form-control" name="entries[${entryKey}][description]"></td>
            <td><input type="number" class="form-control" name="entries[${entryKey}][credit]" value="0"></td>
            <td><button type="button" class="btn btn-danger btn-sm remove-entry">Delete</button></td>
        `;

        updateSrNo();
        updateTotalAmount();

        // No locking for cash field in new rows

        // Wire delete for this new row
        newRow.querySelector('.remove-entry').addEventListener('click', function() {
            // remove any locked_new hidden inputs for this row
        // No hidden cash lock to remove

            alert('Entry deleted.');
            newRow.remove();
            updateSrNo();
            updateTotalAmount();
            // if no rows remain, remove voucher-level globals and unlock
            if (entriesTable.rows.length === 0) {
                // No global cash lock to remove
            }
        });

        // Recalculate total on amount change
        newRow.querySelector(`input[name="entries[${entryKey}][credit]"]`).addEventListener('input', updateTotalAmount);
    });

    // Wire delete for existing DB rows (buttons with data-id)
    entriesTable.querySelectorAll('.remove-entry').forEach(btn => {
        btn.addEventListener('click', function() {
            const row = btn.closest('tr');
            const entryId = btn.getAttribute('data-id'); // DB id if present

            if (entryId) {
                if (!confirm('Are you sure you want to delete this entry?')) return;

                fetch(`/probox/cash-delete/${entryId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    },
                })
                .then(response => {
                    if (response) {
                        alert('Entry deleted.');
                        // remove row and its locked per-row hidden inputs
                        row.remove();
                        // No hidden cash lock to remove

                        // Rebuild voucher globals from new first row (if any)
                        ['lockedDate', 'lockedCash', 'lockedAccount'].forEach(removeHidden);
                        locked = { date: false, cash: false, account: false };
                        protectAllExistingRows();
                        lockGlobalsFromFirstRow();

                        updateSrNo();
                        updateTotalAmount();
                    } else {
                        alert('Failed to delete entry on server.');
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Network error deleting entry.');
                });
            } else {
                // not a DB row (just remove)
                alert('Entry deleted.');
                row.remove();
                updateSrNo();
                updateTotalAmount();
            }

            // if no rows remain, remove voucher-level globals and unlock
            if (entriesTable.rows.length === 0) {
                // No global cash lock to remove
            }
        });
    });

    // Wire recalc for existing credit inputs
    entriesTable.querySelectorAll('input[name*="[credit]"]').forEach(input => {
        input.addEventListener('input', updateTotalAmount);
    });

    // initial numbering & totals
    updateSrNo();
    updateTotalAmount();
});
</script>


    <!-- CSRF Token for AJAX -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/realerp/public_html/probox/resources/views/cash_reports/edit.blade.php ENDPATH**/ ?>