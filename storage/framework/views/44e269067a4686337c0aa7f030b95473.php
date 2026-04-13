
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
                        <li class="breadcrumb-item active">Edit Bank Receipt</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Bank Receipt</h4>
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
                    <form id="voucherForm" action="<?php echo e(route('bank_recipt.update', $voucher->first()->v_no)); ?>"
                          method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <input type="hidden" name="v_type" value="BRV">
                        <input type="hidden" name="invoice_number">
                        <input type="hidden" id="totalAmount" name="total_amount">

                        <div class="d-flex gap-2 mt-2">
                            <button type="button" id="addEntry" class="btn btn-primary btn-sm">Add Entry</button>
                            <button type="submit" class="btn btn-success btn-sm">Submit</button>
                        </div>

                        <h3 class="mt-4">Invoice <span id="invoiceDisplay"></span></h3>

                        <div class="table-responsive mt-4">
                            <table class="table table-bordered" id="entriesTable">
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
                                            <td class="sr-no"><?php echo e($loop->iteration); ?></td>
                                            <td>
                                                <input type="date" class="form-control" name="entries[<?php echo e($entry->id); ?>][date]" value="<?php echo e($entry->date); ?>">
                                                <input type="hidden" name="entries[<?php echo e($entry->id); ?>][id]" value="<?php echo e($entry->id); ?>">
                                            </td>
                                            <td>
                                                <select class="form-control select2" name="entries[<?php echo e($entry->id); ?>][cash]">
                                                    <?php $__currentLoopData = $accountMasters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($account->id); ?>" <?php if($entry->cash_id == $account->id): echo 'selected'; endif; ?>>
                                                            <?php echo e($account->title); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control select2" name="entries[<?php echo e($entry->id); ?>][account]">
                                                    <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($account->id); ?>" <?php if($entry->account_id == $account->id): echo 'selected'; endif; ?>>
                                                            <?php echo e($account->title); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="entries[<?php echo e($entry->id); ?>][description]" class="form-control" value="<?php echo e($entry->description); ?>">
                                            </td>
                                            <td>
                                                <input type="number" name="entries[<?php echo e($entry->id); ?>][credit]" class="form-control" value="<?php echo e($entry->credit); ?>">
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm remove-entry" data-id="<?php echo e($entry->id); ?>">Delete</button>
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


<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

<script>
document.addEventListener('DOMContentLoaded', function () {
    const addEntryButton = document.getElementById('addEntry');
    const entriesTable = document.getElementById('entriesBody');
    let lockedGlobals = null;

    function lockGlobalsFromFirstRow() {
        if (entriesTable.rows.length === 0) return;

        const firstRow = entriesTable.rows[0];
        const date = firstRow.querySelector('.lock-date').value;
        const cash = firstRow.querySelector('.lock-cash').value;
        const account = firstRow.querySelector('.lock-account').value;

        lockedGlobals = {date, cash, account};

        // Hidden globals so Laravel always receives them
        addOrUpdateHidden('lockedDate', date);
        addOrUpdateHidden('lockedCash', cash);
        addOrUpdateHidden('lockedAccount', account);
    }

    function addOrUpdateHidden(name, value) {
        let hidden = document.getElementById(name);
        if (!hidden) {
            hidden = document.createElement('input');
            hidden.type = 'hidden';
            hidden.name = name;
            hidden.id = name;
            document.getElementById('voucherForm').appendChild(hidden);
        }
        hidden.value = value;
    }

    // Add new row
    addEntryButton.addEventListener('click', function () {
        const entryKey = 'new_' + Date.now();
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td class="sr-no"></td>
            <td>
                <input type="date" class="form-control" name="entries[${entryKey}][date]" value="<?php echo e(date('Y-m-d')); ?>">
            </td>
            <td>
                <select class="form-control select2" name="entries[${entryKey}][cash]">
                    <?php $__currentLoopData = $accountMasters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($account->id); ?>"><?php echo e($account->title); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </td>
            <td>
                <select class="form-control select2" name="entries[${entryKey}][account]">
                    <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($account->id); ?>"><?php echo e($account->title); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </td>
            <td><input type="text" name="entries[${entryKey}][description]" class="form-control"></td>
            <td><input type="number" name="entries[${entryKey}][credit]" class="form-control" value="0"></td>
            <td><button type="button" class="btn btn-danger btn-sm remove-entry">Delete</button></td>
        `;
        entriesTable.appendChild(newRow);
        updateSrNo();
        bindRemove(newRow);
    });

    // Remove entry
    function bindRemove(row) {
        row.querySelector('.remove-entry').addEventListener('click', function () {
            const btn = this;
            const entryId = btn.getAttribute('data-id');
            if (entryId) {
                if (confirm('Are you sure you want to delete this entry?')) {
                    fetch(`/probox/bank_recipt-delete/${entryId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                        },
                    }).then(() => {
                                        alert('Entry deleted.');

                        row.remove();
                        updateSrNo();
                        if (entriesTable.rows.length === 0) resetGlobals();
                    }).catch(() => alert('Failed to delete entry.'));
                }
            } else {
                row.remove();
                updateSrNo();
                if (entriesTable.rows.length === 0) resetGlobals();
            }
        });
    }

    function resetGlobals() {
        lockedGlobals = null;
        ['lockedDate','lockedCash','lockedAccount'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.remove();
        });
    }

    function updateSrNo() {
        Array.from(entriesTable.rows).forEach((r, i) => {
            r.querySelector('.sr-no').textContent = i + 1;
        });
    }

    // Attach remove to existing rows
    entriesTable.querySelectorAll('.remove-entry').forEach(btn => {
        bindRemove(btn.closest('tr'));
    });

    updateSrNo();
    lockGlobalsFromFirstRow();
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/realerp/public_html/probox/resources/views/bank_reports/edit2.blade.php ENDPATH**/ ?>