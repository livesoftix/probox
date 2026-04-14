<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <!-- Start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                            <li class="breadcrumb-item active">Dye Purchase</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Dye Purchase</h4>
                </div>
            </div>
        </div>
        <!-- End page title -->

        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible text-bg-success border-0 fade show" role="alert">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible text-bg-danger border-0 fade show" role="alert">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane show active" id="input-types-preview">
                                <div class="row">
                                    <form id="voucherForm" action="<?php echo e(route('dye_purchase.store')); ?>" method="POST" enctype="multipart/form-data">
                                        <?php echo csrf_field(); ?>
                                        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

                                        <div class="col-6">
                                            <!-- Hidden fields for locking mechanism -->
                                            <input type="hidden" id="lockedDate" value="">
                                            <input type="hidden" id="lockedSupplierId" value="">
                                            <input type="hidden" id="lockedSupplierTitle" value="">
                                            <input type="hidden" id="invoice_type" class="form-control" name="v_type"
                                                value="DPN" required readonly>
                                            <input type="hidden" id="invoice" class="form-control" name="invoice_number"
                                                required>
                                            
                                            <div class="mb-3">
                                                <label for="entryDate" class="form-label">Date</label>
                                                <input type="date" id="entryDate" class="form-control" name="date">
                                            </div>

                                            <div class="mb-3">
                                                <label for="preparedBy" class="form-label">Prepared By</label>
                                                <input type="text" id="preparedBy" class="form-control"
                                                    value="<?php echo e($loggedInUser->name); ?>" name="prepared_by" readonly>
                                            </div>

                                            <div class="mb-3">
                                                <label for="entryParty" class="form-label">Party</label>
                                                <select name="account" class="form-control select2" data-toggle="select2"
                                                    id="entryParty" required>
                                                    <option value="">Select</option>
                                                    <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $accountSupplie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($accountSupplie->id); ?>">
                                                            <?php echo e($accountSupplie->title); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="itemTitle" class="form-label">Item Title</label>
                                                <select name="item" class="form-control select2" data-toggle="select2"
                                                    id="itemTitle" required>
                                                    <option value="">Select</option>
                                                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        
                                                            <option value="<?php echo e($item->id); ?>" data-purchase="<?php echo e($item->purchase); ?>">
                                                                <?php echo e($item->item_code); ?>

                                                            </option>
                                                        
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                            
                                            
                                             <div class="mb-3">
                                                <label for="qty" class="form-label">Qty</label>
                                                <input type="number" id="qty" class="form-control" name="qty" step="any">
                                            </div>
                                            

                                            <div class="mb-3">
                                                <label for="description" class="form-label">Description</label>
                                                <textarea type="text" id="description" class="form-control" name="description"></textarea>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="amount" class="form-label">Amount</label>
                                                <input type="number" id="amount" class="form-control" name="amount" step="any">
                                            </div>

                                            <div class="mb-3">
                                                <label for="uploadFile" class="form-label">Upload File</label>
                                                <input type="file" id="uploadFile" class="form-control" name="file" accept="image/*">
                                                <div id="filePreviewContainer" class="mt-2" style="display:none;">
                                                    <img id="imagePreview" src="" alt="Image Preview" style="max-width: 150px; max-height: 150px; display:none;">
                                                    <span id="fileNamePreview" style="font-size:14px;"></span>
                                                    <button type="button" id="removeFile" class="btn btn-sm btn-danger">X</button>
                                                </div>
                                            </div>

                                            <button type="button" id="addEntry" class="btn btn-primary">Add Entry</button>
                                            <button type="submit" class="btn btn-success">Submit Voucher</button>
                                        </div>

                                        <!-- Display Invoice Number -->
                                        <h3 class="mt-4">Invoice <span id="invoiceDisplay"></span></h3>

                                        <!-- Entries Table -->
                                        <div class="col-lg-12">
                                            <table class="table mt-4" id="entriesTable">
                                                <thead>
                                                    <tr>
                                                        <th>Sr No</th>
                                                        <th>Date</th>
                                                        <th>Supplier</th>
                                                        <th>Item</th>
                                                        <th>Qty</th>
                                                        <th>Description</th>
                                                        <th>Amount</th>
                                                        <th>Img</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="entriesBody">
                                                    <!-- Entries will appear here -->
                                                </tbody>
                                            </table>
                                        </div>

                                    </form>
                                </div>
                                <!-- End row-->
                            </div> <!-- End preview-->
                        </div> <!-- End tab-content-->
                    </div> <!-- End card-body -->
                </div> <!-- End card -->
            </div><!-- End col -->
        </div><!-- End row -->
    </div>
<script>
const today = new Date().toISOString().split('T')[0];
document.getElementById('entryDate').value = today;

document.addEventListener('DOMContentLoaded', function() {
    const entriesTable = document.getElementById('entriesBody');
    const addEntryButton = document.getElementById('addEntry');
    const invoiceInput = document.getElementById('invoice');
    const entryDateInput = document.getElementById('entryDate');
    const supplierSelect = document.getElementById('entryParty');
    const fileInput = document.getElementById('uploadFile');
    const filePreviewContainer = document.getElementById('filePreviewContainer');
    const imagePreview = document.getElementById('imagePreview');
    const fileNamePreview = document.getElementById('fileNamePreview');
    const removeFileButton = document.getElementById('removeFile');
    let invoiceCounter = 1;
    invoiceInput.value = invoiceCounter;

    // Initialize select2
    $('.select2').select2();

    // Set amount when item is selected
    $('#itemTitle').on('change', function() {
        const selectedOption = $(this).find(':selected');
        const purchaseAmount = selectedOption.data('purchase');
        if (purchaseAmount) {
            $('#amount').val(purchaseAmount);
        } else {
            $('#amount').val('');
        }
    });

    // File upload preview
    fileInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
                fileNamePreview.textContent = file.name;
                filePreviewContainer.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });

    // Remove file
    removeFileButton.addEventListener('click', function() {
        fileInput.value = '';
        filePreviewContainer.style.display = 'none';
        imagePreview.src = '';
        fileNamePreview.textContent = '';
    });

    addEntryButton.addEventListener('click', function() {
        const date = entryDateInput.value;
        const preparedBy = document.getElementById('preparedBy').value;
        const description = document.getElementById('description').value;
        const amount = parseFloat(document.getElementById('amount').value);
        const qty = parseFloat(document.getElementById('qty').value);
        const itemSelect = document.getElementById('itemTitle');
        const selectedItem = itemSelect.options[itemSelect.selectedIndex];
        const itemTitleValue = selectedItem.text;
        const itemIdValue = selectedItem.value;
        const supplierSelect = document.getElementById('entryParty');
        const selectedSupplier = supplierSelect.options[supplierSelect.selectedIndex];
        const supplierTitleValue = selectedSupplier.text;
        const supplierIdValue = selectedSupplier.value;
        const file = fileInput.files[0];

        if (!date || !supplierIdValue || !itemIdValue || isNaN(amount) || !file || isNaN(qty)) {
            alert('Please fill all required fields with valid values and upload a file.');
            return;
        }

        const seqNo = entriesTable.children.length + 1;
        const uniqueId = Date.now();
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>${seqNo}</td>
            <td>${date}</td>
            <td>${supplierTitleValue}</td>
            <td>${itemTitleValue}</td>
            <td>${qty}</td>
            <td>${description}</td>
            <td>${amount.toFixed(2)}</td>
            <td><img src="${URL.createObjectURL(file)}" alt="Image Preview" style="max-width: 50px; max-height: 50px;"></td>
            <td>
                <button type="button" class="btn btn-danger delete-entry">Delete</button>
                <input type="hidden" name="entries[${uniqueId}][date]" value="${date}">
                <input type="hidden" name="entries[${uniqueId}][account]" value="${supplierIdValue}">
                <input type="hidden" name="entries[${uniqueId}][item]" value="${itemIdValue}">
                <input type="hidden" name="entries[${uniqueId}][prepared_by]" value="${preparedBy}">
                <input type="hidden" name="entries[${uniqueId}][description]" value="${description}">
                <input type="hidden" name="entries[${uniqueId}][amount]" value="${amount.toFixed(2)}">
                <input type="hidden" name="entries[${uniqueId}][qty]" value="${qty}">
                <input type="hidden" name="entries[${uniqueId}][file_name]" value="${file.name}">
                <input type="hidden" name="entries[${uniqueId}][sequence_no]" value="${seqNo}">
            </td>
        `;

        // Append the file input to the form but keep it hidden
        const fileInputClone = fileInput.cloneNode(true);
        fileInputClone.name = `entries[${uniqueId}][file]`;
        fileInputClone.style.display = 'none';
        newRow.appendChild(fileInputClone);

        entriesTable.appendChild(newRow);
        invoiceCounter++;
        invoiceInput.value = invoiceCounter;

        // LOCKING MECHANISM: Disable the date and supplier input after adding the first entry
        entryDateInput.disabled = true;
        supplierSelect.disabled = true;

        // Reset form fields after adding entry
        document.getElementById('description').value = '';
        document.getElementById('amount').value = '';
        document.getElementById('qty').value = '';
        fileInput.value = '';
        filePreviewContainer.style.display = 'none';
        imagePreview.src = '';
        fileNamePreview.textContent = '';
    });

    // Delegated delete-entry handler with renumbering and unlock logic
    entriesTable.addEventListener('click', function (e) {
        if (e.target.classList.contains('delete-entry')) {
            const row = e.target.closest('tr');
            entriesTable.removeChild(row);

            // Renumber sequence numbers
            const rows = entriesTable.querySelectorAll('tr');
            rows.forEach((row, index) => {
                row.cells[0].textContent = index + 1;
                const seqInput = row.querySelector('input[name*="[sequence_no]"]');
                if (seqInput) seqInput.value = index + 1;
            });

            // UNLOCK MECHANISM: If no rows left, unlock date & supplier
            if (entriesTable.children.length === 0) {
                entryDateInput.disabled = false;
                supplierSelect.disabled = false;
                document.getElementById('lockedDate').value = '';
                document.getElementById('lockedSupplierId').value = '';
                document.getElementById('lockedSupplierTitle').value = '';
            }
        }
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.condition', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\probox\resources\views/dye_purchase/list.blade.php ENDPATH**/ ?>