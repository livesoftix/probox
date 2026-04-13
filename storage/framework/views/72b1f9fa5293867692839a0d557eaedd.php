
<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <!-- Start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Softix</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                            <li class="breadcrumb-item active">Purchase Invoice</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Purchase Plate</h4>
                </div>
            </div>
        </div>
        <!-- End page title -->

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
                                    <form id="voucherForm" action="<?php echo e(route('plate_purchase.store')); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <div class="col-6">
                                            <input type="hidden" id="lockedDate" value="">
                                            <input type="hidden" id="lockedSupplierId" value="">
                                            <input type="hidden" id="lockedSupplierTitle" value="">
                                            <input type="hidden" id="invoice_type" class="form-control" name="v_type"
                                                value="PPN" required readonly>
                                            <input type="hidden" id="invoice" class="form-control" name="invoice_number"
                                                required>
                                            <input type="hidden" id="totalAmount" name="total_amount" value="0">
                                            <input type="hidden" id="totalWeight" name="total_weight" value="0">
                                            <input type="hidden" id="entryCash" class="form-control" name="cash" value="<?php echo e($purchaseAccount ? $purchaseAccount->id : ''); ?>">

                                            <div class="mb-3">
                                                <label for="entryDate" class="form-label">Date</label>
                                                <input type="date" id="entryDate" class="form-control" name="date">
                                            </div>

                                            <div class="mb-3">
                                                <label for="preparedBy" class="form-label">Prepared By</label>
                                                <input type="text" id="preparedBy" class="form-control" value="<?php echo e($loggedInUser->name); ?>"
                                                    name="prepared_by" readonly>
                                            </div>

                                            <div class="mb-3">
                                                <label for="entryParty" class="form-label">Supplier</label>
                                                <select name="account" class="form-control select2" data-toggle="select2"
                                                    id="entryParty" required>
                                                    <option value="">Select</option>
                                                    <?php $__currentLoopData = $accountSuppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $accountSupplie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                                      
                                                        <option value="<?php echo e($item->id); ?>"><?php echo e($item->item_code); ?></option>
                                                       
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>

                                          <div class="mb-3">
    <label for="country" class="form-label">Country</label>
    <select name="country" class="form-control select2" id="country" data-toggle="select2" required onchange="updateProducts()">
        <option value="">Select</option>
        <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($c->id); ?>"><?php echo e($c->country_name); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>

<div class="mb-3">
    <label for="product" class="form-label">Product Name</label>
    <select name="product" class="form-control select2" id="product" data-toggle="select2" required>
        <option value="">Select</option>
        <!-- Products will be populated here dynamically -->
    </select>
</div>

                                            <div class="mb-3">
                                                <label for="length" class="form-label">Description</label>
                                                 <textarea type="text" id="length" class="form-control" name="length"></textarea>
                                            </div>
                                            


                                            <div class="mb-3">
                                                <label for="quantity" class="form-label">Quantity</label>
                                                <input type="number" id="quantity" class="form-control" name="quantity">
                                            </div>

                                            <div class="mb-3">
                                                <label for="rate" class="form-label">Rate</label>
                                                <input type="number" id="rate" class="form-control" name="rate" step="any">
                                            </div>
                                            
                                            <div class="mb-3" style="display: none;">
                                                <label for="freight" class="form-label">Freight</label>
                                                <input type="number" id="freight" class="form-control" name="freight" value="0" readonly>
                                            </div>

                                            <button type="button" id="addEntry" class="btn btn-primary">Add
                                                Entry</button>
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
                                                        <th>Country</th>
                                                        <th>Product Name</th>
                                                        <th>Description</th>
                                                        <th>Quantity</th>
                                                        <th>Rate</th>
                                                        <th>Amount</th>
                                                        <th style="display: none;">Freight</th>
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


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    const today = new Date().toISOString().split('T')[0];

    // Set the value of the input field to the current date
    document.getElementById('entryDate').value = today;

    document.addEventListener('DOMContentLoaded', function() {
        const entriesTable = document.getElementById('entriesBody');
        const addEntryButton = document.getElementById('addEntry');
        const invoiceInput = document.getElementById('invoice');
        const entryDateInput = document.getElementById('entryDate');
        const supplierSelect = document.getElementById('entryParty');
        let invoiceCounter = 1;

        invoiceInput.value = invoiceCounter;

        addEntryButton.addEventListener('click', function() {
            const date = entryDateInput.value;
            const countrySelect = document.getElementById('country');
            const countryText = countrySelect.options[countrySelect.selectedIndex]?.text || '';
            const countryIdValue = countrySelect.value;

            const productSelect = document.getElementById('product');
            const productText = productSelect.options[productSelect.selectedIndex]?.text || '';
            const productIdValue = productSelect.value;

            const length = document.getElementById('length').value;
            const freight = document.getElementById('freight').value;
            const quantity = document.getElementById('quantity').value;
            const rate = document.getElementById('rate').value;
            const cash = document.getElementById('entryCash').value;
            const prepared = document.getElementById('preparedBy').value;
            const item = document.getElementById('itemTitle');
            let selectedOption = item.options[item.selectedIndex];
            let itemTitleValue = selectedOption.text;
            let itemIdValue = selectedOption.value;
            const supplier = document.getElementById('entryParty');
            let selectedSupplier = supplier.options[supplier.selectedIndex];
            let supplierTitleValue = selectedSupplier.text;
            let supplierIdValue = selectedSupplier.value;

            const amount = quantity * rate;

            // Check for missing values
            if (!date || !countryIdValue || !productIdValue || !length || !quantity || !rate || isNaN(amount)) {
                alert('Please fill all fields.');
                return;
            }

            const newRow = document.createElement('tr');
            const seqNo = entriesTable.children.length + 1;
            const rowId = Date.now();  // Unique identifier for hidden inputs
            newRow.innerHTML = `
                <td>${seqNo}</td>
                <td>${date}</td>
                <td>${supplierTitleValue}</td>
                <td>${itemTitleValue}</td>
                <td>${countryText}</td>
                <td>${productText}</td>
                <td>${length}</td>
                <td>${quantity}</td>
                <td>${rate}</td>
                <td>${Math.round(amount)}</td>
                <td style="display: none;">${freight}</td>
                <td>
                    <button type="button" class="btn btn-danger delete-entry">Delete</button>
                    <input type="hidden" name="entries[${rowId}][date]" value="${date}">
                    <input type="hidden" name="entries[${rowId}][cash]" value="${cash}">
                    <input type="hidden" name="entries[${rowId}][supplier]" value="${supplierIdValue}">
                    <input type="hidden" name="entries[${rowId}][item]" value="${itemIdValue}">
                    <input type="hidden" name="entries[${rowId}][country]" value="${countryIdValue}">
                    <input type="hidden" name="entries[${rowId}][product]" value="${productIdValue}">
                    <input type="hidden" name="entries[${rowId}][prepared_by]" value="${prepared}">
                    <input type="hidden" name="entries[${rowId}][length]" value="${length}">
                    <input type="hidden" name="entries[${rowId}][quantity]" value="${quantity}">
                    <input type="hidden" name="entries[${rowId}][rate]" value="${rate}">
                    <input type="hidden" name="entries[${rowId}][freight]" value="${freight}">
                    <input type="hidden" name="entries[${rowId}][amount]" value="${Math.round(amount)}">
                    <input type="hidden" name="entries[${rowId}][sequence_no]" value="${seqNo}">
                </td>
            `;

            entriesTable.appendChild(newRow);
            invoiceCounter++;
            document.getElementById('totalAmount').value = parseFloat(document.getElementById('totalAmount').value) + Number(amount);
            document.getElementById('totalWeight').value = parseFloat(document.getElementById('totalWeight').value) + (parseFloat(length) * parseFloat(quantity));

            // Reset input fields
            entryDateInput.value = today;
            document.getElementById('length').value = '';
            document.getElementById('quantity').value = '';
            document.getElementById('freight').value = '0';

            // Disable the date and supplier input after adding the first entry
            entryDateInput.disabled = true;
            supplierSelect.disabled = true;
        });

        // Delegated delete-entry handler with renumbering and unlock logic
        entriesTable.addEventListener('click', function (e) {
            if (e.target.classList.contains('delete-entry')) {
                const row = e.target.closest('tr');
                const rowAmount = parseFloat(row.children[9].innerText);
                document.getElementById('totalAmount').value = parseFloat(document.getElementById('totalAmount').value) - rowAmount;
                entriesTable.removeChild(row);

                // Renumber sequence numbers
                const rows = entriesTable.querySelectorAll('tr');
                rows.forEach((row, index) => {
                    row.cells[0].textContent = index + 1;
                    const seqInput = row.querySelector('input[name*="[sequence_no]"]');
                    if (seqInput) seqInput.value = index + 1;
                });

                if (entriesTable.children.length === 0) {
                    // Unlock date & supplier if no rows left
                    entryDateInput.disabled = false;
                    supplierSelect.disabled = false;
                    document.getElementById('lockedDate').value = '';
                    document.getElementById('lockedSupplierId').value = '';
                    document.getElementById('lockedSupplierTitle').value = '';
                }
            }
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize select2 after DOM is fully loaded
        $('.select2').select2();

        // Listen for change event on the item dropdown
        $('#itemTitle').on('change', function() {
            // Get the selected value (item ID)
            var selectedItemId = $(this).val();
            
            // Log the selected value to the console
            console.log("Selected Item ID:", selectedItemId);

            // Perform AJAX request to fetch purchase details for the selected item
            if (selectedItemId) {
                $.ajax({
                    url: '/probox/get-item-details/' + selectedItemId,
                    method: 'GET',
                    success: function(response) {
                        // Log the response to the console
                        console.log("Item Details:", response);

                        // Set the rate input field with the purchase value (if exists)
                        if (response && response.purchase) {
                            $('#rate').val(response.purchase);
                        } else {
                            console.log("Purchase (rate) not found in the response.");
                        }

                        // Set the gramage input field with the gramage value (if exists)
                        if (response && response.gramage) {
                            // Assuming you have a field for gramage, set its value here
                            $('#gramage').val(response.gramage);  // Replace #gramage with your actual input ID
                        } else {
                            console.log("Gramage not found in the response.");
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.error("Error fetching item details:", error);
                    }
                });
            } else {
                console.log("No item selected.");
            }
        });
    });
    
     document.getElementById('freight').addEventListener('change', function() {
    this.disabled = true;
});


$(document).ready(function() {
    // Initialize Select2 for both dropdowns
    $('#country').select2({
        dataToggle: 'select2'
    });
    $('#product').select2({
        dataToggle: 'select2'
    });
});


function updateProducts() {
    var countryId = $('#country').val();
    
    if (countryId) {
        $.ajax({
            url: '/probox/get-products-by-country', // Your API endpoint
            type: 'GET',
            data: { country_id: countryId },
            success: function(response) {
                // Destroy Select2 to avoid duplication issues
                $('#product').select2('destroy');
                
                // Clear existing options
                $('#product').empty();
                $('#product').append('<option value="">Select</option>');
                
                // Add new options
                $.each(response, function(key, value) {
                    $('#product').append('<option value="' + value.id + '">' + value.prod_name + '</option>');
                });
                
                // Reinitialize Select2
                $('#product').select2({
                    dataToggle: 'select2' // Reinitialize with the same options
                });
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    } else {
        // Destroy Select2 to avoid duplication issues
        $('#product').select2('destroy');
        
        // Clear existing options
        $('#product').empty();
        $('#product').append('<option value="">Select</option>');
        
        // Reinitialize Select2
        $('#product').select2({
            dataToggle: 'select2' // Reinitialize with the same options
        });
    }
}
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/realerp/public_html/probox/resources/views/plate_purchase/list.blade.php ENDPATH**/ ?>