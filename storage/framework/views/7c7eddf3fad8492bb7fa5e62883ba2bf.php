<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Hyper</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Forms</a></li>
                        <li class="breadcrumb-item active">Edit Wastage Sale</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Wastage Sale</h4>
            </div>
        </div>
    </div>
    <!-- End page title -->

    <!-- Error Display -->
    <?php if(session('error')): ?>
    <div class="alert alert-danger">
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
                                <form id="voucherForm" action="<?php echo e(route('wastage_sale.update', $voucher->first()->v_no)); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <div class="col-6">
                            <input type="hidden" id="invoice_type" name="v_type" value="WSN" readonly>
                        <input type="hidden" id="totalAmount" name="total_amount" value="0">

                        <!-- Date Field -->
                        <div class="mb-3">
                            <label for="entryDate" class="form-label">Date</label>
                            <input type="date" id="entryDate" class="form-control" name="date" value="<?php echo e(now()->toDateString()); ?>">
                        </div>

                        <!-- Prepared By Field -->
                        <div class="mb-3">
                            <label for="preparedBy" class="form-label">Prepared By</label>
                            <input type="text" id="preparedBy" class="form-control" name="prepared_by" value="<?php echo e($loggedInUser->name); ?>" readonly>
                        </div>

                        <!-- Party Selection -->
                        <div class="mb-3">
                            <label for="entryParty" class="form-label">Party</label>
                            <select name="account" class="form-control select2" id="entryParty" data-toggle="select2" required>
                                <option value="">Select</option>
                                <?php $__currentLoopData = $accountMasters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($account->id); ?>"><?php echo e($account->title); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

  <div class="mb-3">
     
                                                <label for="itemTitle" class="form-label">Item Title</label>
                                                <select name="item" class="form-control select2" data-toggle="select2"
                                                    id="itemTitle" required>
                                                    
                                                    <option value="">Select</option> 
                                                   
                                                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                      
                                                        <option value="<?php echo e($item->id); ?>"><?php echo e($item->item_code); ?></option>
                                                        
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                            
                        <!-- Description Field -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea id="description" class="form-control" name="description"></textarea>
                        </div>

                        <!-- Weight Field -->
                        <div class="mb-3">
                            <label for="weight" class="form-label">Weight</label>
                            <input type="number" id="weight" class="form-control" name="weight" step="any">
                        </div>

                        <!-- Rate Field -->
                        <div class="mb-3" hidden>
                            <label for="rate" class="form-label">Rate</label>
                            <input type="number" id="rate" class="form-control" name="rate" step="any">
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

                        <!-- Entries Table -->
                        <div class="mt-4">
                            <table class="table" id="entriesTable">
                                <thead>
                                    <tr>
                                        <th>Sr No</th>
                                        <th>Date</th>
                                        <th>Party</th>
                                        <th>Item Title</th>
                                        <th>Description</th>
                                        <th>Weight</th>
                                        <th>Img</th>
                                        <th hidden>Rate</th>
                                        <th hidden>Total</th>
                                        
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="entriesBody">
                                    <?php
                                    $totalEntries = 0; // Initialize a counter for rows
                                    ?>

                                    <?php if($voucher->isNotEmpty()): ?>
                                    <?php $__currentLoopData = $voucher; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trndtl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e(++$totalEntries); ?></td>
                                        <!-- Format Date -->
                                        <td>
                                            <?php echo e(\Carbon\Carbon::parse($trndtl->date)->format('d-m-Y')); ?>

                                            <input type="hidden" name="date[]" value="<?php echo e($trndtl->date); ?>">
                                        </td>
                                        <!-- Account Title (Party) -->
                                        <td>
                                            <?php echo e(optional($trndtl->accounts)->title ?? 'N/A'); ?>

                                            <input type="hidden" name="supplier[]" value="<?php echo e(optional($trndtl->accounts)->title); ?>">
                                        </td>
                                          <td>
                                            <?php echo e(optional($trndtl->wastagesales->items)->item_code ?? 'N/A'); ?>

                                            <input type="hidden" name="supplier[]" value="<?php echo e(optional($trndtl->accounts)->title); ?>">
                                        </td>

                                        <!-- Description -->
                                        <td>
                                            <?php echo e($trndtl->description ?? 'N/A'); ?>

                                            <input type="hidden" name="description[]" value="<?php echo e($trndtl->description); ?>">
                                        </td>
                                        <!-- Weight -->
                                        <td>
                                            <?php echo e($trndtl->wastagesales->weight ?? 'N/A'); ?>

                                            <input type="hidden" name="weight[]" value="<?php echo e($trndtl->wastagesales->weight); ?>">
                                        </td>
                                        
                                         <td>
    <?php if(!empty($trndtl->wastagesales->file_path)): ?>
        <a href="<?php echo e(asset('storage/' . $trndtl->wastagesales->file_path)); ?>" target="_blank">
            <img src="<?php echo e(asset('storage/' . $trndtl->wastagesales->file_path)); ?>" alt="Image" style="width: 50px; height: auto;">
        </a>
    <?php else: ?>
        <p>No Img</p>
    <?php endif; ?>
    <input type="hidden" name="file_path[]" value="<?php echo e($trndtl->wastagesales->file_path ?? ''); ?>">
</td>
                                        <!-- Rate -->
                                        <td hidden>
                                            <?php echo e($trndtl->wastagesales->rate ?? 'N/A'); ?>

                                            <input type="hidden" name="rate[]" value="<?php echo e($trndtl->wastagesales->rate); ?>">
                                        </td>
                                        <!-- Total -->
                                        <td hidden>
                                            <?php echo e($trndtl->wastagesales->total ?? 'N/A'); ?>

                                            <input type="hidden" name="total[]" value="<?php echo e($trndtl->wastagesales->total); ?>">
                                        </td>
                                       

                                        <!-- Actions -->
                                        <td>
                                                        <!-- Delete Entry Button -->
                                                        <a href="<?php echo e(route('wastage_sale.destroy', $trndtl->id)); ?>"
                                                            class="btn btn-danger btn-sm"
                                                            onclick="event.preventDefault();
                                                                            if(confirm('Are you sure you want to delete this transaction?')) {
                                                                                window.location.href='<?php echo e(route('wastage_sale.destroy', $trndtl->id)); ?>';
                                                                            }">Delete</a>
                                                    </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                    <tr>
                                        <td colspan="9" class="text-center">No transaction details available.</td>
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
</div> <!-- End container -->

<script>
document.addEventListener('DOMContentLoaded', function () {
 const today = new Date();
const offset = today.getTimezoneOffset();
const localDate = new Date(today.getTime() - (offset * 60 * 1000)).toISOString().split('T')[0];
document.getElementById('entryDate').value = localDate;

    const entriesTable = document.getElementById('entriesBody');
    const addEntryButton = document.getElementById('addEntry');
    const entryDateInput = document.getElementById('entryDate');
    const fileInput = document.getElementById('uploadFile');
    const filePreviewContainer = document.getElementById('filePreviewContainer');
    const imagePreview = document.getElementById('imagePreview');
    const fileNamePreview = document.getElementById('fileNamePreview');
    const removeFileButton = document.getElementById('removeFile');
    const voucherForm = document.getElementById('voucherForm');
    let invoiceCounter = 1;

    // Handle file input change
    fileInput.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
                fileNamePreview.textContent = file.name;
                filePreviewContainer.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });

    // Handle file removal
    removeFileButton.addEventListener('click', function () {
        fileInput.value = '';  // Clear the file input
        filePreviewContainer.style.display = 'none';  // Hide the preview container
        imagePreview.src = '';  // Clear the image preview
        fileNamePreview.textContent = '';  // Clear the file name preview
    });

    // Handle adding new entry
    addEntryButton.addEventListener('click', function () {
        const date = entryDateInput.value;
        const weight = document.getElementById('weight').value;
        const description = document.getElementById('description').value;
        const rate = document.getElementById('rate').value;
        const prepared = document.getElementById('preparedBy').value;
        const item = document.getElementById('itemTitle');
        let selectedOption = item.options[item.selectedIndex];
        let itemTitleValue = selectedOption.text;
        let itemIdValue = selectedOption.value;
        const supplier = document.getElementById('entryParty');
        let selectedSupplier = supplier.options[supplier.selectedIndex];
        let supplierTitleValue = selectedSupplier.text;
        let supplierIdValue = selectedSupplier.value;
        const file = fileInput.files[0];

      const parsedWeight = parseFloat(weight); // Convert to float
const parsedRate = parseFloat(rate); // Convert to float

const total = parsedWeight; // Perform multiplication * parsedRate;
const amount = parseFloat(total.toFixed(2)); // Round to 2 decimal places
        // Validate that all required fields are filled and a file is uploaded
        if (!date || !weight  || isNaN(amount) || !file) {    
            alert('Please fill all fields correctly and upload an image.');
            return;
        }

        const rowId = Date.now();
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>${invoiceCounter}</td>
            <td>${date}</td>
            <td>${supplierTitleValue}</td>
            <td>${itemTitleValue}</td>
            <td>${description}</td>
            <td>${weight}</td>
            <td><img src="${URL.createObjectURL(file)}" alt="Image Preview" style="max-width: 50px; max-height: 50px;"></td>
            <td hidden>${rate}</td>
            <td hidden>${(amount)}</td>
            <td>
                <button type="button" class="btn btn-danger delete-entry">Delete</button>
                <input type="hidden" name="entries[${rowId}][date]" value="${date}">
                <input type="hidden" name="entries[${rowId}][supplier]" value="${supplierIdValue}">
                <input type="hidden" name="entries[${rowId}][item]" value="${itemIdValue}">
                <input type="hidden" name="entries[${rowId}][description]" value="${description}">
                <input type="hidden" name="entries[${rowId}][weight]" value="${weight}">
                <input type="hidden" name="entries[${rowId}][rate]" value="${rate}">
                <input type="hidden" name="entries[${rowId}][amount]" value="${(amount)}">
                <input type="hidden" name="entries[${rowId}][file_name]" value="${file.name}">
            </td>
        `;

        // Append the file input to the form but keep it hidden
        const fileInputClone = fileInput.cloneNode(true);
        fileInputClone.name = `entries[${rowId}][file]`;
        fileInputClone.style.display = 'none';  // Hide the file input
        newRow.appendChild(fileInputClone);

        entriesTable.appendChild(newRow);
        invoiceCounter++;

        // Reset form fields after adding entry
        document.getElementById('weight').value = '';
        document.getElementById('description').value = '';
        fileInput.value = '';  // Clear the file input
        filePreviewContainer.style.display = 'none';  // Hide the preview container
        imagePreview.src = '';  // Clear the image preview
        fileNamePreview.textContent = '';  // Clear the file name preview
    });

    // Delete row functionality
    entriesTable.addEventListener('click', function (event) {
        if (event.target.classList.contains('delete-entry')) {
            event.target.closest('tr').remove();
        }
    });

    // Initialize select2 for dropdowns
    //$('.select2').select2();

    // Fetch item details on item change
    $('#itemTitle').on('change', function() {
        const selectedItemId = $(this).val();
        console.log("Selected Item ID:", selectedItemId);

        if (selectedItemId) {
            $.ajax({
                url: '/probox/get-item-details/' + selectedItemId,
                method: 'GET',
                success: function(response) {
                    console.log("Item Details:", response);
                    if (response && response.sale) {
                        $('#rate').val(response.sale);
                    } else {
                        console.log("Purchase (rate) not found in the response.");
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching item details:", error);
                    alert("Failed to fetch item details. Please try again.");
                }
            });
        } else {
            console.log("No item selected.");
        }
    });
});
   
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\probox\resources\views/sale_reports/edit2.blade.php ENDPATH**/ ?>