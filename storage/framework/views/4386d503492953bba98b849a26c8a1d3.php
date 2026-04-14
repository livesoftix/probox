<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <!-- Start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Softix</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Reports</a></li>
                            <li class="breadcrumb-item active">Edit Disposable Purchase</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Edit Disposable Purchase</h4>
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

        <?php if(session('success')): ?>
            <div class="alert alert-success">
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
                                    <form id="voucherForm"
                                        action="<?php echo e(route('disposable_purchase.update', $v_no)); ?>"
                                        method="POST" enctype="multipart/form-data">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                        <div class="col-6">
                                            <input type="hidden" id="invoice_type" class="form-control" name="v_type"
                                                value="DPN" required readonly>
                                            <input type="hidden" id="totalAmount" name="total_amount" value="0">
                                            
                                            <div class="mb-3">
                                                <label>Voucher ID: <?php echo e($v_no); ?></label>
                                            </div><hr>

                                            <div class="mb-3">
                                                <label for="entryDate" class="form-label">Date</label>
                                                <input type="date" id="entryDate" class="form-control" name="date" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="preparedBy" class="form-label">Prepared By</label>
                                                <input type="text" id="preparedBy" class="form-control"
                                                    name="prepared_by" value="<?php echo e($loggedInUser->name ?? 'N/A'); ?>" readonly>
                                            </div>

                                            <div class="mb-3">
                                                <label for="entryParty" class="form-label">Supplier</label>
                                                <select name="supplier" class="form-control select2" data-toggle="select2" id="entryParty" required>
                                                    <option value="">Select Supplier</option>
                                                    <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($supplier->id); ?>">
                                                            <?php echo e($supplier->title); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="item_id" class="form-label">Item</label>
                                                <select name="item_id" class="form-control select2" data-toggle="select2" id="item_id" required>
                                                    <option value="">Select Item</option>
                                                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($item->id); ?>" data-rate="<?php echo e($item->purchase ?? 0); ?>">
                                                            <?php echo e($item->item_code); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="qty" class="form-label">Quantity</label>
                                                <input type="number" id="qty" class="form-control" name="qty" step="0.01" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="weight_type" class="form-label">Unit</label>
                                                <select id="weight_type" class="form-control" name="weight_type" required>
                                                    <option value="">Select Unit</option>
                                                    <option value="litre">Litre (L)</option>
                                                    <option value="ml">Millilitre (ml)</option>
                                                    <option value="kg">Kilogram (kg)</option>
                                                    
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="rate" class="form-label">Rate</label>
                                                <input type="number" id="rate" class="form-control" name="rate" step="0.01" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="image" class="form-label">Image</label>
                                                <input type="file" id="image" class="form-control" accept="image/*">
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
                                                        <th>Item</th>
                                                        <th>Quantity</th>
                                                        <th>Unit</th>
                                                        <th>Rate</th>
                                                        <th>Amount</th>
                                                        <th>Image</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="entriesBody">
                                                    <?php
                                                        $totalEntries = 0;
                                                    ?>

                                                    <?php if($voucherEntries->isNotEmpty()): ?>
                                                        <?php $__currentLoopData = $voucherEntries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trndtl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php
                                                                $purchaseDetail = $trndtl->disposablepurchase;
                                                                $totalEntries++;
                                                            ?>
                                                            <tr>
                                                                <td><?php echo e($totalEntries); ?></td>
                                                                <td><?php echo e(\Carbon\Carbon::parse($trndtl->date)->format('Y-m-d') ?? 'N/A'); ?></td>
                                                                <td><?php echo e($trndtl->accounts->title ?? 'N/A'); ?></td>
                                                                <td><?php echo e($purchaseDetail->item->item_code ?? 'N/A'); ?></td>
                                                                <td><?php echo e($purchaseDetail->qty); ?></td>
                                                                <td><?php echo e($purchaseDetail->weight_type); ?></td>
                                                                <td><?php echo e($purchaseDetail->rate); ?></td>
                                                                <td><?php echo e($purchaseDetail->amount); ?></td>
                                                                <td>
                                                                    <?php if($purchaseDetail->image): ?>
                                                                        <img src="<?php echo e(asset('storage/' . $purchaseDetail->image)); ?>" style="width:50px;height:50px;object-fit:cover;" onclick="showImageModal('<?php echo e(asset('storage/' . $purchaseDetail->image)); ?>')" id="img<?php echo e($purchaseDetail->id); ?>"> 
                                                                        <input type="file" name="entries[<?php echo e($purchaseDetail->id); ?>][image]" accept="image/*" style="display:none;" id="imageInput<?php echo e($purchaseDetail->id); ?>" onchange="updateExistingImage(<?php echo e($purchaseDetail->id); ?>)">
                                                                        <button type="button" class="btn btn-sm btn-secondary" onclick="document.getElementById('imageInput<?php echo e($purchaseDetail->id); ?>').click()">Change</button>
                                                                    <?php else: ?>
                                                                        <input type="file" name="entries[<?php echo e($purchaseDetail->id); ?>][image]" accept="image/*" class="form-control" style="width:100px;" id="imageInput<?php echo e($purchaseDetail->id); ?>" onchange="updateExistingImage(<?php echo e($purchaseDetail->id); ?>)">
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td>
                                                                    <!-- Hidden inputs for existing entries -->
                                                                    <input type="hidden" name="entries[<?php echo e($purchaseDetail->id); ?>][r_id]" value="<?php echo e($purchaseDetail->id); ?>">
                                                                    <input type="hidden" name="entries[<?php echo e($purchaseDetail->id); ?>][date]" value="<?php echo e($trndtl->date); ?>">
                                                                    <input type="hidden" name="entries[<?php echo e($purchaseDetail->id); ?>][supplier]" value="<?php echo e($trndtl->account_id); ?>">
                                                                    <input type="hidden" name="entries[<?php echo e($purchaseDetail->id); ?>][item_id]" value="<?php echo e($purchaseDetail->item_id); ?>">
                                                                    <input type="hidden" name="entries[<?php echo e($purchaseDetail->id); ?>][qty]" value="<?php echo e($purchaseDetail->qty); ?>">
                                                                    <input type="hidden" name="entries[<?php echo e($purchaseDetail->id); ?>][weight_type]" value="<?php echo e($purchaseDetail->weight_type); ?>">
                                                                    <input type="hidden" name="entries[<?php echo e($purchaseDetail->id); ?>][rate]" value="<?php echo e($purchaseDetail->rate); ?>">
                                                                    <input type="hidden" name="entries[<?php echo e($purchaseDetail->id); ?>][amount]" value="<?php echo e($purchaseDetail->amount); ?>">
                                                                    <input type="hidden" name="entries[<?php echo e($purchaseDetail->id); ?>][prepared_by]" value="<?php echo e($trndtl->preparedby); ?>">
                                                                    <!-- Delete Entry Button -->
                                                                    <a href="<?php echo e(route('disposable_purchase.destroy', $trndtl->id)); ?>"
                                                                        class="btn btn-danger btn-sm"
                                                                        onclick="event.preventDefault();
                                                                            if(confirm('Are you sure you want to delete this transaction?')) {
                                                                                window.location.href='<?php echo e(route('disposable_purchase.destroy', $trndtl->id)); ?>';
                                                                            }">Delete</a>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php else: ?>
                                                        <tr>
                                                            <td colspan="10">No transaction details available for this voucher.</td>
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
    
    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Image Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" style="max-width: 100%; height: auto;">
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        // Auto-populate rate when item is selected
        $('#item_id').change(function() {
            var selectedOption = $('#item_id option:selected');
            var rate = selectedOption.data('rate');

            if(rate !== undefined && rate !== null && !isNaN(rate)) {
                $('#rate').val(rate);
            }
        });
    });

    // Set current date
    const today = new Date().toISOString().split('T')[0];
    if (!document.getElementById('entryDate').value) {
        document.getElementById('entryDate').value = today;
    }

    document.addEventListener('DOMContentLoaded', function() {
        const entriesTable = document.getElementById('entriesBody');
        const addUpdateButton = document.getElementById('addUpdateEntry');
        const entryDateInput = document.getElementById('entryDate');
        const supplierSelect = document.getElementById('entryParty');
        const itemSelect = document.getElementById('item_id');
        const qtyInput = document.getElementById('qty');
        const weightTypeSelect = document.getElementById('weight_type');
        const rateInput = document.getElementById('rate');
        const preparedByInput = document.getElementById('preparedBy');
        const totalAmountField = document.getElementById('totalAmount');
        const voucherForm = document.getElementById('voucherForm');
        let isDateAndSupplierDisabled = false;

        // Calculate initial total amount from existing entries
        let initialTotalAmount = 0;
        const existingRows = entriesTable.querySelectorAll('tr');
        existingRows.forEach(row => {
            const amountCell = row.cells[7];
            if (amountCell) {
                const amountText = amountCell.textContent || amountCell.innerText;
                const amount = parseFloat(amountText);
                if (!isNaN(amount)) {
                    initialTotalAmount += amount;
                }
            }
        });
        totalAmountField.value = initialTotalAmount.toFixed(2);

        addUpdateButton.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Get form values
            const date = entryDateInput.value;
            const qty = parseFloat(qtyInput.value);
            const weightType = weightTypeSelect.value;
            const prepared = preparedByInput.value;
            const rate = parseFloat(rateInput.value);

            const supplier = supplierSelect;
            let selectedSupplier = supplier.options[supplier.selectedIndex];
            let supplierTitleValue = selectedSupplier.text;
            let supplierIdValue = selectedSupplier.value;

            const item = itemSelect;
            let selectedOption = item.options[item.selectedIndex];
            let itemTitleValue = selectedOption.text;
            let itemIdValue = selectedOption.value;

            // Validation
            if (!date || !supplierIdValue || !itemIdValue || isNaN(qty) || qty <= 0 || !weightType || isNaN(rate) || rate < 0) {
                alert('Please fill all fields correctly.');
                return;
            }

            const amount = qty * rate;
            const uniqueId = 'new_' + Date.now();
            const imageFile = document.getElementById('image').files[0];
            let imagePreview = 'No Image';
            
            if (imageFile) {
                imagePreview = `<img src="${URL.createObjectURL(imageFile)}" style="width:50px;height:50px;object-fit:cover;">`;
            }

            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td></td>
                <td>${date}</td>
                <td>${supplierTitleValue}</td>
                <td>${itemTitleValue}</td>
                <td>${qty}</td>
                <td>${weightType}</td>
                <td>${rate}</td>
                <td>${amount.toFixed(2)}</td>
                <td>${imagePreview}</td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm delete-entry">Delete</button>
                    <input type="hidden" name="entries[${uniqueId}][date]" value="${date}">
                    <input type="hidden" name="entries[${uniqueId}][supplier]" value="${supplierIdValue}">
                    <input type="hidden" name="entries[${uniqueId}][item_id]" value="${itemIdValue}">
                    <input type="hidden" name="entries[${uniqueId}][qty]" value="${qty}">
                    <input type="hidden" name="entries[${uniqueId}][weight_type]" value="${weightType}">
                    <input type="hidden" name="entries[${uniqueId}][rate]" value="${rate}">
                    <input type="hidden" name="entries[${uniqueId}][amount]" value="${amount}">
                    <input type="hidden" name="entries[${uniqueId}][prepared_by]" value="${prepared}">
                </td>
            `;
            
            // Add image file to the row if present
            if (imageFile) {
                const fileInput = document.createElement('input');
                fileInput.type = 'file';
                fileInput.name = `entries[${uniqueId}][image]`;
                fileInput.style.display = 'none';
                const dt = new DataTransfer();
                dt.items.add(imageFile);
                fileInput.files = dt.files;
                newRow.querySelector('td:last-child').appendChild(fileInput);
            }

            entriesTable.appendChild(newRow);
            updateSerialNumbers();

            // Update total amount
            totalAmountField.value = (parseFloat(totalAmountField.value) || 0) + amount;

            // Reset input fields
            qtyInput.value = '';
            weightTypeSelect.value = '';
            rateInput.value = '';
            itemSelect.value = '';
            document.getElementById('image').value = '';

            // Disable date and supplier after first entry
            if (!isDateAndSupplierDisabled) {
                entryDateInput.disabled = true;
                supplierSelect.disabled = true;
                isDateAndSupplierDisabled = true;
            }

            // Add delete functionality
            const deleteButton = newRow.querySelector('.delete-entry');
            deleteButton.addEventListener('click', function() {
                entriesTable.removeChild(newRow);
                updateSerialNumbers();
                
                const rowAmount = parseFloat(newRow.cells[7].innerText);
                totalAmountField.value = (parseFloat(totalAmountField.value) || 0) - rowAmount;

                // Re-enable date and supplier if no entries left
                if (entriesTable.rows.length === 0) {
                    entryDateInput.disabled = false;
                    supplierSelect.disabled = false;
                    isDateAndSupplierDisabled = false;
                }
            });

            // Submit form via AJAX to auto-save
            var form = document.getElementById('voucherForm');
            var formData = new FormData(form);
            // $.ajax({
            //     url: form.action,
            //     method: form.method,
            //     data: formData,
            //     processData: false,
            //     contentType: false,
            //     success: function(response) {
            //         // Show success message
            //         alert(response.success || 'Update successful!');
            //     },
            //     error: function(xhr, status, error) {
            //         // Show error message
            //         alert('Error updating: ' + (xhr.responseJSON?.error || error));
            //     }
            // });
        });

        // Function to update serial numbers
        function updateSerialNumbers() {
            const rows = entriesTable.rows;
            for (let i = 0; i < rows.length; i++) {
                rows[i].cells[0].innerText = i + 1;
            }
        }

        // Initialize serial numbers on page load
        updateSerialNumbers();
    });
    
    // Function to show image in modal
    function showImageModal(imageSrc) {
        document.getElementById('modalImage').src = imageSrc;
        var imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
        imageModal.show();
    }
    
    // Function to update existing image automatically
    function updateExistingImage(purchaseId) {
        const fileInput = document.getElementById('imageInput' + purchaseId);
        const file = fileInput.files[0];
        
        if (!file) return;
        
        const formData = new FormData();
        formData.append('_token', document.querySelector('input[name="_token"]').value);
        formData.append('image', file);
        
        $.ajax({
            url: '/probox/disposable-purchase/update-image/' + purchaseId,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // Update image preview
                const imgElement = document.getElementById('img' + purchaseId);
                if (imgElement) {
                    // Update existing image
                    imgElement.src = URL.createObjectURL(file);
                } else {
                    // Create new image preview for rows that didn't have images
                    const imageCell = fileInput.closest('td');
                    const newImg = document.createElement('img');
                    newImg.src = URL.createObjectURL(file);
                    newImg.style.cssText = 'width:50px;height:50px;object-fit:cover;cursor:pointer;';
                    newImg.id = 'img' + purchaseId;
                    newImg.onclick = function() { showImageModal(this.src); };
                    
                    // Replace file input with image and change button
                    imageCell.innerHTML = '';
                    imageCell.appendChild(newImg);
                    
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'file';
                    hiddenInput.name = 'entries[' + purchaseId + '][image]';
                    hiddenInput.accept = 'image/*';
                    hiddenInput.style.display = 'none';
                    hiddenInput.id = 'imageInput' + purchaseId;
                    hiddenInput.onchange = function() { updateExistingImage(purchaseId); };
                    imageCell.appendChild(hiddenInput);
                    
                    const changeBtn = document.createElement('button');
                    changeBtn.type = 'button';
                    changeBtn.className = 'btn btn-sm btn-secondary';
                    changeBtn.textContent = 'Change';
                    changeBtn.onclick = function() { hiddenInput.click(); };
                    imageCell.appendChild(changeBtn);
                }
                alert('Image updated successfully!');
            },
            error: function(xhr, status, error) {
                alert('Error updating image: ' + (xhr.responseJSON?.error || error));
            }
        });
    }
</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\probox\resources\views/disposable_purchase/edit.blade.php ENDPATH**/ ?>