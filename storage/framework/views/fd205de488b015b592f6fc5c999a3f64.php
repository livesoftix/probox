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
                            <li class="breadcrumb-item active">Edit Corrugation Purchase</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Edit Corrugation Purchase</h4>
                </div>
            </div>
        </div>
        <!-- End page title -->

        <!-- Display any error messages -->
        <?php if(session('error')): ?>
            <div class="alert alert-danger">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <!-- Example for displaying purchase details -->
     
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane show active" id="input-types-preview">
                                <div class="row">
                                    <form id="voucherForm"
                                        action="<?php echo e(route('corrugation_purchase.update', $voucher->first()->v_no)); ?>"
                                        method="POST">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                        <div class="col-6">
                                            <input type="hidden" id="invoice_type" class="form-control" name="v_type"
                                                value="PIN" required readonly>
                                            <input type="hidden" id="invoice" class="form-control" name="invoice_number"
                                                required>
                                            <input type="hidden" id="totalAmount" name="total_amount">
                                            <input type="hidden" id="totalWeight" name="total_weight">
                                            <input type="hidden" id="entryCash" class="form-control" name="cash"
                                                value="<?php echo e($purchaseAccount ? $purchaseAccount->id : ''); ?>">
                                            <div class="mb-3">
                                                <label>Voucher ID: <?php echo e($v_no); ?></label>
                                            </div><hr>
                                            
                                            <div class="mb-3">
                                                <label for="entryDate" class="form-label">Date</label>
                                                <input type="date" id="entryDate" class="form-control" name="date">
                                            </div>

                                            <div class="mb-3">
                                                <label for="preparedBy" class="form-label">Prepared By</label>
                                                <input type="text" id="preparedBy" class="form-control"
                                                    name="prepared_by" value="<?php echo e($loggedInUser->name); ?>" readonly>
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
                                    <label for="item_id" class="form-label">Corrugation Type</label>
                                    <select name="item_id" class="form-control select2" data-toggle="select2" id="item_id">
                                        <option value="">Select</option>
                                        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        
                                        <option value="<?php echo e($item->id); ?>" data-rate="<?php echo e($item->purchase); ?>" data-grammage="<?php echo e($item->grammage); ?>">
                                            <?php echo e($item->item_code); ?>

                                        </option>
                                        
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                           <div class="mb-3">
                                                <label for="size" class="form-label">Size</label>
                                                <input type="number" id="size" class="form-control" name="size" step="any">
                                            </div>



                                            <div class="mb-3">
                                                <label for="qty" class="form-label">Quantity</label>
                                                <input type="number" id="qty" class="form-control" name="qty" step="any">
                                            </div>

                                            <div class="mb-3">
                                                <label for="rate" class="form-label">Rate</label>
                                                <input type="number" id="rate" class="form-control"
                                                    name="rate" step="any">
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="freight" class="form-label">Freight</label>
                                                <input type="number" id="freight" class="form-control" name="freight" value="0" readonly>
                                            </div>
                                          
                                            <button type="button" id="addUpdateEntry" class="btn btn-primary">Add Entry</button>
                                            <button type="submit" class="btn btn-success">Update Invoice</button>
                                        </div>

                                        <!-- Entries Table -->
                                        <div class="col-lg-12">
                                            <table class="table mt-4" id="entriesTable">
                                                <thead>
                                                    <tr>
                                                        <th>Sr No</th>
                                                        <th>Date</th>
                                                        <th>Supplier</th>
                                                        <th>Corrugation Type</th>
                                                        
                                                        <th>Size</th>
                                                        <th>Quantity</th>
                                                        <th>Rate</th>
                                                        <th>Amount</th>
                                                        <th>Freight</th>
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
                                                                <td><?php echo e($trndtl->date ?? 'N/A'); ?></td>
                                                                <!-- Show trndtl date -->
                                                                <td><?php echo e($trndtl->accounts->title ?? 'N/A'); ?></td>
                                                                <!-- Account title -->
                                                                   <td><?php echo e($trndtl->corrugationpurchases->item->item_code ?? 'N/A'); ?></td>
                                                                <td><?php echo e($trndtl->corrugationpurchases->qty); ?></td>
                                                                <td><?php echo e($trndtl->corrugationpurchases->size); ?></td>
                                                                
                                                                <td><?php echo e($trndtl->corrugationpurchases->rate); ?></td>
                                                                <td><?php echo e($trndtl->corrugationpurchases->amount); ?></td>
                                                                <td><?php echo e($trndtl->corrugationpurchases->freight); ?></td>
                                                                <td>
                                                                    <!-- Delete Entry Button -->
                                                                    <a href="<?php echo e(route('corrugation_purchase.destroy', $trndtl->id)); ?>"
                                                                        class="btn btn-danger btn-sm"
                                                                        onclick="event.preventDefault();
                                                                            if(confirm('Are you sure you want to delete this transaction?')) {
                                                                                window.location.href='<?php echo e(route('corrugation_purchase.destroy', $trndtl->id)); ?>';
                                                                            }">Delete</a>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php else: ?>
                                                        <tr>
                                                            <td colspan="13">No transaction details available for this
                                                                purchase.</td>
                                                        </tr>
                                                    <?php endif; ?>
                                                    
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
    </div> <!-- End container -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        // Listen for changes to the item_id dropdown
        $('#item_id').change(function() {
            // Get the selected option
            var selectedOption = $('#item_id option:selected');
            
            // Get the rate from the data-rate attribute of the selected option
            var rate = selectedOption.data('rate');
            
            // Set the rate input field value to the selected rate
            $('#rate').val(rate);
        });
    });
    
    
    
    
    
    
    
    var getItemDetailsUrl = "<?php echo e(route('getItemDetails', '')); ?>";
    const today = new Date().toISOString().split('T')[0];

    // Set the value of the input field to the current date
    document.getElementById('entryDate').value = today;

    document.addEventListener('DOMContentLoaded', function() {
        const entriesTable = document.getElementById('entriesBody');
        const addUpdateButton = document.getElementById('addUpdateEntry');  // Combined button
        const entryDateInput = document.getElementById('entryDate');
        let isDateDisabled = false; // Flag to track date input state

        addUpdateButton.addEventListener('click', function() {
            // Add Entry logic
            const date = entryDateInput.value;
            const qty = document.getElementById('qty').value;
            const size = document.getElementById('size').value;
            const freight = document.getElementById('freight').value;
            const prepared = document.getElementById('preparedBy').value;
            const rate = document.getElementById('rate').value;
            const cash = document.getElementById('entryCash').value;
            const item = document.getElementById('item_id');
            let selectedOption = item.options[item.selectedIndex];
            let itemTitleValue = selectedOption.text;
            let itemIdValue = selectedOption.value;
            const supplier = document.getElementById('entryParty');
            let selectedSupplier = supplier.options[supplier.selectedIndex];
            let supplierTitleValue = selectedSupplier.text;
            let supplierIdValue = selectedSupplier.value;

            const amount = qty * rate *size;

            if (!date || !size || !qty || !rate || isNaN(amount)) {
                alert('Please fill all fields.');
                return;
            }

            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td></td> <!-- Placeholder for Sr No -->
                <td>${date}</td>
                <td>${supplierTitleValue}</td>
                <td>${itemTitleValue}</td>
                <td>${size}</td>
                <td>${qty}</td>
                <td>${rate}</td>
                <td>${Math.round(amount)}</td>
                <td>${freight}</td>
                <td>
                    <button type="button" class="btn btn-danger delete-entry">Delete</button>
                    <input type="hidden" name="entries[${Date.now()}][date]" value="${date}">
                    <input type="hidden" name="entries[${Date.now()}][supplier]" value="${supplierIdValue}">
                    <input type="hidden" name="entries[${Date.now()}][item]" value="${itemIdValue}">
                    <input type="hidden" name="entries[${Date.now()}][prepared_by]" value="${prepared}">
                    <input type="hidden" name="entries[${Date.now()}][size]" value="${size}">
                    <input type="hidden" name="entries[${Date.now()}][cash]" value="${cash}">
                    <input type="hidden" name="entries[${Date.now()}][qty]" value="${qty}">
                    <input type="hidden" name="entries[${Date.now()}][rate]" value="${rate}">
                    <input type="hidden" name="entries[${Date.now()}][freight]" value="${freight}">
                    <input type="hidden" name="entries[${Date.now()}][amount]" value="${Math.round(amount)}">
                </td>
            `;

            entriesTable.appendChild(newRow);
            updateSerialNumbers(); // Update Sr No after adding a new entry
            document.getElementById('totalAmount').value = parseFloat(document.getElementById('totalAmount').value) + amount;
            document.getElementById('totalWeight').value = parseFloat(document.getElementById('totalWeight').value) + parseFloat(width) * parseFloat(length);

            // Reset input fields
            document.getElementById('size').value = '';
            document.getElementById('qty').value = '';
            document.getElementById('freight').value = '0';

            // Disable the date input after the first entry
            if (!isDateDisabled) {
                entryDateInput.disabled = true; // Disable date input
                isDateDisabled = true; // Update the flag
            }

            // Add delete functionality to the newly created delete button
            const deleteButton = newRow.querySelector('.delete-entry');
            deleteButton.addEventListener('click', function() {
                // Remove the row from the table
                entriesTable.removeChild(newRow);
                // Update Sr No for remaining entries
                updateSerialNumbers();
                // Update the total amount by subtracting the row's amount
                const rowAmount = parseFloat(newRow.children[8].innerText);
                document.getElementById('totalAmount').value = parseFloat(document.getElementById('totalAmount').value) - rowAmount;

                // Check if there are no entries left in the table
                if (entriesTable.rows.length === 0) {
                    entryDateInput.disabled = false; // Enable date input if no entries are present
                    isDateDisabled = false; // Reset the flag
                }
            });

            // After adding entry, submit the form using AJAX to update the invoice
            var form = document.getElementById('voucherForm');
            var formData = new FormData(form);
            // $.ajax({
            //     url: form.action,  // Form action URL
            //     method: form.method, // POST method
            //     data: formData, // The form data
            //     processData: false, // Don't process the data
            //     contentType: false, // Don't set content type
            //     success: function(response) {
            //         // Do nothing on success
            //     },
            //     error: function(xhr, status, error) {
            //         // Do nothing on error
            //     }
            // });
        });
    });

    // Function to update serial numbers after a row is added or deleted
    function updateSerialNumbers() {
        const rows = entriesTable.rows;
        for (let i = 0; i < rows.length; i++) {
            rows[i].cells[0].innerText = i + 1; // Update Sr No
        }
    }
</script>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\probox\resources\views/purchase_reports/edit6.blade.php ENDPATH**/ ?>