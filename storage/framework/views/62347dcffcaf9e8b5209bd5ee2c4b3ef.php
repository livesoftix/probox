
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
                        <li class="breadcrumb-item active">Form Elements</li>
                    </ol>
                </div>
                <h4 class="page-title">Bank Receipt</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible text-bg-success border-0 fade show" role="alert">
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <form id="voucherForm" action="<?php echo e(route('bank_recipt.store')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>

                        <input type="hidden" id="invoice_type" name="v_type" value="BRV" required readonly>
                        <input type="hidden" id="invoice" name="invoice_number" required>
                        <input type="hidden" id="totalAmount" name="total_amount" value="0">

                        <!-- Date -->
                        <div class="mb-3">
                            <label for="entryDate" class="form-label">Date</label>
                            <input type="date" id="entryDate" class="form-control">
                        </div>

                        <!-- Bank -->
                        <div class="mb-3">
                            <label for="entryCash" class="form-label">Bank</label>
                            <select class="form-control select2" data-toggle="select2" id="entryCash">
                                <option value="">Select</option>
                                <?php $__currentLoopData = $accountMasters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($account->id); ?>"><?php echo e($account->title); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <!-- Account Title -->
                        <div class="mb-3">
                            <label for="entryParty" class="form-label">Account Title</label>
                            <select id="entryParty" class="form-control select2" data-toggle="select2">
                                <option value="">Select</option>
                                <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($account->id); ?>"><?php echo e($account->title); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="entryDescription" class="form-label">Description</label>
                            <textarea id="entryDescription" class="form-control"></textarea>
                        </div>

                        <!-- Amount -->
                        <div class="mb-3">
                            <label for="entryAmount" class="form-label">Amount</label>
                            <input type="number" id="entryAmount" class="form-control">
                        </div>

                        <!-- File Upload -->
                        <div class="mb-3">
                            <label for="uploadFile" class="form-label">Upload File</label>
                            <input type="file" id="uploadFile" class="form-control" name="file">
                            <div id="filePreviewContainer" class="mt-2" style="display:none;">
                                <img id="imagePreview" src="" alt="Image Preview" style="max-width:150px;max-height:150px;display:none;">
                                <span id="fileNamePreview" style="font-size:14px;"></span>
                                <button type="button" id="removeFile" class="btn btn-sm btn-danger">X</button>
                            </div>
                        </div>

                        <button type="button" id="addEntry" class="btn btn-primary">Add Entry</button>
                        <button type="submit" class="btn btn-success">Submit Voucher</button>

                        <!-- Invoice Display -->
                        <h3 class="mt-4">Invoice <span id="invoiceDisplay"></span></h3>

                        <!-- Entries Table -->
                        <div class="col-lg-12">
                            <table class="table mt-4" id="entriesTable">
                                <thead>
                                    <tr>
                                        <th>Sr No</th>
                                        <th>Date</th>
                                        <th>Bank</th>
                                        <th>Account Title</th>
                                        <th>Description</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="entriesBody"></tbody>
                            </table>
                        </div>

                        <!-- Total -->
                        <h4 class="text-end">Total Amount: <span id="totalAmountDisplay">0</span></h4>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('entryDate').value = today;

    const entriesTable = document.getElementById('entriesBody');
    const addEntryButton = document.getElementById('addEntry');
    const totalAmountInput = document.getElementById('totalAmount');
    const totalAmountDisplay = document.getElementById('totalAmountDisplay');
    const invoiceInput = document.getElementById('invoice');
    let invoiceCounter = 1;
    let totalAmount = 0;

    invoiceInput.value = invoiceCounter;

    addEntryButton.addEventListener('click', function () {
        const date = document.getElementById('entryDate').value;
        const cash = document.getElementById('entryCash');
        const party = document.getElementById('entryParty');
        const description = document.getElementById('entryDescription').value;
        const amount = parseFloat(document.getElementById('entryAmount').value);

        if (!date || !description || isNaN(amount)) {
            alert('Please fill all fields.');
            return;
        }
        if (!cash.value) {
            alert('Bank is required');
            return;
        }
        if (!party.value) {
            alert('Account is required');
            return;
        }

        const selectedCashOption = cash.options[cash.selectedIndex].text;
        const selectedCashBank = cash.value;
        const selectedParty = party.options[party.selectedIndex].text;
        const selectedAccountParty = party.value;
        const invoiceNumber = invoiceCounter++;
        invoiceInput.value = invoiceNumber;

        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>${invoiceNumber}</td>
            <td>${date}</td>
            <td>${selectedCashOption}</td>
            <td>${selectedParty}</td>
            <td>${description}</td>
            <td>${amount.toFixed(2)}</td>
            <td>
                <button type="button" class="btn btn-danger delete-entry">Delete</button>
                <input type="hidden" name="entries[${Date.now()}][date]" value="${date}">
                <input type="hidden" name="entries[${Date.now()}][cash]" value="${selectedCashBank}">
                <input type="hidden" name="entries[${Date.now()}][account]" value="${selectedAccountParty}">
                <input type="hidden" name="entries[${Date.now()}][description]" value="${description}">
                <input type="hidden" name="entries[${Date.now()}][credit]" value="${amount.toFixed(2)}">
                <input type="hidden" name="entries[${Date.now()}][v_type]" value="BRV">
            </td>
        `;
        entriesTable.appendChild(newRow);

        totalAmount += amount;
        totalAmountDisplay.textContent = totalAmount.toFixed(2);
        totalAmountInput.value = totalAmount.toFixed(2);

    // Do not lock date, bank, or account fields after entry

        document.getElementById('entryDescription').value = '';
        document.getElementById('entryAmount').value = '';

        newRow.querySelector('.delete-entry').addEventListener('click', function () {
            newRow.remove();
            totalAmount -= amount;
            totalAmountDisplay.textContent = totalAmount.toFixed(2);
            totalAmountInput.value = totalAmount.toFixed(2);

            // Fields remain editable regardless of entry count
        });
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/realerp/public_html/probox/resources/views/bank_recipt/list.blade.php ENDPATH**/ ?>