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
                            <li class="breadcrumb-item active">Plate Return</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Plate Return</h4>
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

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane show active" id="input-types-preview">
                                <div class="row">
                                    <form id="voucherForm" action="<?php echo e(route('plate_return.store')); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <div class="col-6">
                                            <!-- Hidden fields for locking values -->
                                            <input type="hidden" id="lockedDate" value="">
                                            <input type="hidden" id="lockedSupplierId" value="">
                                            <input type="hidden" id="lockedSupplierTitle" value="">
                                            
                                            <input type="hidden" id="invoice_type" class="form-control" name="v_type" value="PRN" required readonly>
                                            <input type="hidden" id="invoice" class="form-control" name="invoice_number" required>
                                            <input type="hidden" id="totalAmount" name="total_amount" value="0">
                                            <input type="hidden" id="totalWeight" name="total_weight" value="0">
                                            <input type="hidden" id="entryCash" class="form-control" name="cash" value="<?php echo e($purchaseAccount ? $purchaseAccount->id : ''); ?>">

                                            <div class="mb-3">
                                                <label for="entryDate" class="form-label">Date</label>
                                                <input type="date" id="entryDate" class="form-control" name="date">
                                            </div>

                                            <div class="mb-3">
                                                <label for="preparedBy" class="form-label">Prepared By</label>
                                                <input type="text" id="preparedBy" class="form-control" value="<?php echo e($loggedInUser->name); ?>" name="prepared_by" readonly>
                                            </div>

                                            <div class="mb-3">
                                                <label for="entryParty" class="form-label">Supplier</label>
                                                <select name="account" class="form-control select2" data-toggle="select2" id="entryParty" required>
                                                    <option value="">Select</option>
                                                    <?php $__currentLoopData = $accountSuppliers->whereIn('level2_id', [4, 23]); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $accountSupplie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($accountSupplie->id); ?>"><?php echo e($accountSupplie->title); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="itemTitle" class="form-label">Item Title</label>
                                                <select name="item" class="form-control select2" data-toggle="select2" id="itemTitle" required>
                                                    <option value="">Select</option>
                                                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if($item->type_id == 5): ?>
                                                            <option value="<?php echo e($item->id); ?>"><?php echo e($item->item_code); ?></option>
                                                        <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="country" class="form-label">Country</label>
                                                <select name="country" class="form-control select2" id="country" data-toggle="select2" required>
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
                                                <label for="description" class="form-label">Description</label>
                                                <textarea type="text" id="description" class="form-control" name="description"></textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label for="quantity" class="form-label">Quantity</label>
                                                <input type="number" id="quantity" class="form-control" name="quantity">
                                            </div>

                                            <div class="mb-3">
                                                <label for="rate" class="form-label">Rate</label>
                                                <input type="number" id="rate" class="form-control" name="rate">
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
                                                        <th>Country</th>
                                                        <th>Product Name</th>
                                                        <th>Description</th>
                                                        <th>Quantity</th>
                                                        <th>Rate</th>
                                                        <th>Amount</th>
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
        $(document).ready(function() {
            // Initialize Select2 for all select elements
            $('.select2').select2();

            // Set today's date as default
            const today = new Date().toISOString().split('T')[0];
            $('#entryDate').val(today);

            // Initialize variables
            const entriesTable = $('#entriesBody');
            const addEntryButton = $('#addEntry');
            const invoiceInput = $('#invoice');
            const entryDateInput = $('#entryDate');
            const supplierSelect = $('#entryParty');
            let invoiceCounter = 1;

            invoiceInput.val(invoiceCounter);

            // Country change event to update products
            $('#country').on('change', function() {
                updateProducts();
            });

            // Item change event to fetch item details
            $('#itemTitle').on('change', function() {
                var selectedItemId = $(this).val();
                
                if (selectedItemId) {
                    $.ajax({
                        url: '/probox/get-item-details/' + selectedItemId,
                        method: 'GET',
                        success: function(response) {
                            if (response && response.purchase) {
                                $('#rate').val(response.purchase);
                            }
                            if (response && response.gramage) {
                                $('#gramage').val(response.gramage);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Error fetching item details:", error);
                        }
                    });
                }
            });

            // Add entry button click handler
            addEntryButton.on('click', function() {
                const date = entryDateInput.val();
                const countrySelect = $('#country');
                const countryText = countrySelect.find('option:selected').text();
                const countryIdValue = countrySelect.val();

                const productSelect = $('#product');
                const productText = productSelect.find('option:selected').text();
                const productIdValue = productSelect.val();

                const description = $('#description').val();
                const quantity = parseFloat($('#quantity').val());
                const rate = parseFloat($('#rate').val());
                const cash = $('#entryCash').val();
                const prepared = $('#preparedBy').val();
                
                const item = $('#itemTitle');
                const itemTitleValue = item.find('option:selected').text();
                const itemIdValue = item.val();
                
                const supplier = $('#entryParty');
                const supplierTitleValue = supplier.find('option:selected').text();
                const supplierIdValue = supplier.val();

                const amount = quantity * rate;

                // Validation
                if (!date || !countryIdValue || !productIdValue || !description || !quantity || !rate || isNaN(amount)) {
                    alert('Please fill all fields with valid values.');
                    return;
                }

                // Add new row to table
                const rowId = Date.now();
                const newRow = `
                    <tr>
                        <td>${invoiceCounter}</td>
                        <td>${date}</td>
                        <td>${supplierTitleValue}</td>
                        <td>${itemTitleValue}</td>
                        <td>${countryText}</td>
                        <td>${productText}</td>
                        <td>${description}</td>
                        <td>${quantity}</td>
                        <td>${rate}</td>
                        <td>${Math.round(amount)}</td>
                        <td>
                            <button type="button" class="btn btn-danger delete-entry">Delete</button>
                            <input type="hidden" name="entries[${rowId}][date]" value="${date}">
                            <input type="hidden" name="entries[${rowId}][cash]" value="${cash}">
                            <input type="hidden" name="entries[${rowId}][supplier]" value="${supplierIdValue}">
                            <input type="hidden" name="entries[${rowId}][item]" value="${itemIdValue}">
                            <input type="hidden" name="entries[${rowId}][country]" value="${countryIdValue}">
                            <input type="hidden" name="entries[${rowId}][product]" value="${productIdValue}">
                            <input type="hidden" name="entries[${rowId}][prepared_by]" value="${prepared}">
                            <input type="hidden" name="entries[${rowId}][description]" value="${description}">
                            <input type="hidden" name="entries[${rowId}][quantity]" value="${quantity}">
                            <input type="hidden" name="entries[${rowId}][rate]" value="${rate}">
                            <input type="hidden" name="entries[${rowId}][amount]" value="${Math.round(amount)}">
                        </td>
                    </tr>
                `;

                entriesTable.append(newRow);
                invoiceCounter++;
                
                // Update totals
                const currentTotal = parseFloat($('#totalAmount').val());
                $('#totalAmount').val(currentTotal + amount);
                
                const currentWeight = parseFloat($('#totalWeight').val());
                $('#totalWeight').val(currentWeight + (parseFloat(description) * quantity));

                // Lock date and supplier after first entry
                if (entriesTable.children().length === 1) {
                    entryDateInput.prop('disabled', true);
                    supplierSelect.prop('disabled', true);
                    
                    // Store locked values
                    $('#lockedDate').val(date);
                    $('#lockedSupplierId').val(supplierIdValue);
                    $('#lockedSupplierTitle').val(supplierTitleValue);
                }

                // Reset input fields
                $('#description').val('');
                $('#quantity').val('');

                // Attach delete handler to new row
                entriesTable.find('.delete-entry').last().on('click', function() {
                    const row = $(this).closest('tr');
                    const rowAmount = parseFloat(row.find('td:eq(9)').text());
                    
                    // Update totals
                    $('#totalAmount').val(parseFloat($('#totalAmount').val()) - rowAmount);
                    
                    // Remove row
                    row.remove();

                    // Unlock date and supplier if no entries left
                    if (entriesTable.children().length === 0) {
                        entryDateInput.prop('disabled', false);
                        supplierSelect.prop('disabled', false);
                        $('#lockedDate').val('');
                        $('#lockedSupplierId').val('');
                        $('#lockedSupplierTitle').val('');
                    }
                });
            });

            // Function to update products based on selected country
            function updateProducts() {
                var countryId = $('#country').val();
                
                if (countryId) {
                    $.ajax({
                        url: '/probox/get-products-by-country',
                        type: 'GET',
                        data: { country_id: countryId },
                        success: function(response) {
                            // Destroy and recreate Select2 to avoid issues
                            $('#product').select2('destroy').empty();
                            $('#product').append('<option value="">Select</option>');
                            
                            $.each(response, function(key, value) {
                                $('#product').append('<option value="' + value.id + '">' + value.prod_name + '</option>');
                            });
                            
                            $('#product').select2({ dataToggle: 'select2' });
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText);
                        }
                    });
                } else {
                    $('#product').select2('destroy').empty();
                    $('#product').append('<option value="">Select</option>');
                    $('#product').select2({ dataToggle: 'select2' });
                }
            }
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\probox\resources\views/plate_return/list.blade.php ENDPATH**/ ?>