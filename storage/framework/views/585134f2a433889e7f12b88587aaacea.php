

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Gate-Pass In</h4>
            </div>
        </div>
    </div>

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
                    <form id="voucherForm" action="<?php echo e(route('gate_pass_in.store')); ?>" method="POST" enctype="multipart/form-data">

                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-6">
                                <input type="hidden" id="lockedDate" value="">
                                <input type="hidden" id="lockedPartyId" value="">
                                <input type="hidden" id="lockedPartyTitle" value="">
                                <input type="hidden" id="invoice_type" name="v_type" value="GPI" readonly>
                                <input type="hidden" id="totalAmount" name="total_amount" value="0">
                                <!-- Date Field -->
                                <div class="mb-3">
                                    <label for="entryDate" class="form-label">Date</label>
                                    <input type="date" id="entryDate" class="form-control" name="date">
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
                                        <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($account->id); ?>"><?php echo e($account->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <!-- Description Field -->
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea id="description" class="form-control" name="description"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="qty" class="form-label">Quantity</label>
                                    <input type="number" id="qty" class="form-control" name="qty" step="any" >
                                </div>
                                <!-- Rate Field -->
                                <div class="mb-3">
                                    <label for="rate" class="form-label">Rate</label>
                                    <input type="number" id="rate" class="form-control" name="rate" step="any" >
                                </div>
                                <div class="mb-3">
                                    <label for="uploadFile" class="form-label">Upload File</label>
                                    <input type="file" id="uploadFile" class="form-control" accept="image/*">
                                    <div id="filePreviewContainer" class="mt-2" style="display:none;">
                                        <img id="imagePreview" src="" alt="Image Preview" style="max-width: 150px; max-height: 150px; display:none;">
                                        <span id="fileNamePreview" style="font-size:14px;"></span>
                                        <button type="button" id="removeFile" class="btn btn-sm btn-danger">X</button>
                                    </div>
                                </div>
                                <button type="button" id="addEntry" class="btn btn-primary">Add Entry</button>
                                <button type="submit" class="btn btn-success">Submit Voucher</button>
                            </div>
                        </div>

                        <!-- Entries Table -->
                        <div class="col-lg-12">
                            <table class="table mt-4" id="entriesTable">
                                <thead>
                                    <tr>
                                        <th>Sr No</th>
                                        <th>Date</th>
                                        <th>Party</th>
                                       
                                        <th>Description</th>
                                        <th>Quantity</th>
                                        <th>Rate</th>
                                        <th>Total</th>
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
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const entriesTable = document.getElementById('entriesBody');
        const addEntryButton = document.getElementById('addEntry');
        const entryDateInput = document.getElementById('entryDate');
        const qtyInput = document.getElementById('qty');
        const rateInput = document.getElementById('rate');
        const descriptionInput = document.getElementById('description');
        const totalAmountInput = document.getElementById('totalAmount');
        const fileInput = document.getElementById('uploadFile');
        const filePreviewContainer = document.getElementById('filePreviewContainer');
        const imagePreview = document.getElementById('imagePreview');
        const fileNamePreview = document.getElementById('fileNamePreview');
        const removeFileButton = document.getElementById('removeFile');
        let invoiceCounter = 1;
        // Store entry data and files
        let entryData = [];

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
            fileInput.value = '';
            filePreviewContainer.style.display = 'none';
            imagePreview.src = '';
            fileNamePreview.textContent = '';
        });

        entryDateInput.value = new Date().toISOString().split('T')[0];

        addEntryButton.addEventListener('click', function() {
            const date = entryDateInput.value;
            const qty = qtyInput.value;
            const rate = rateInput.value;
            const description = descriptionInput.value;
            const prepared = document.getElementById('preparedBy').value;
            const party = document.getElementById('entryParty');
            const partyText = party.options[party.selectedIndex].text;
            const partyValue = party.value;
            const file = fileInput.files[0];
            const total = qty * rate;
            if (!date || !qty || !rate || isNaN(total) || !partyValue || !description) {
                alert('Please fill all fields.');
                return;
            }
            const rowId = Date.now();
            entryData.push({
                rowId,
                date,
                party: partyValue,
                partyText,
                prepared,
                qty,
                rate,
                total: parseFloat(total).toFixed(2),
                description,
                file
            });
            const newRow = document.createElement('tr');
            const imageHtml = file 
                ? `<img src="${URL.createObjectURL(file)}" alt="Image Preview" style="max-width: 50px; max-height: 50px;">`
                : 'No Image';
            newRow.innerHTML = `
                <td>${invoiceCounter}</td>
                <td>${date}</td>
                <td>${partyText}</td>
                <td>${description}</td>
                <td>${qty}</td>
                <td>${rate}</td>
                <td>${parseFloat(total).toFixed(2)}</td>
                <td>${imageHtml}</td>
                <td><button type="button" class="btn btn-danger delete-entry">Delete</button></td>
            `;
            entriesTable.appendChild(newRow);
            invoiceCounter++;
            // Update total amount
            let sum = 0;
            entryData.forEach(e => sum += parseFloat(e.total));
            totalAmountInput.value = sum.toFixed(2);
            // Lock party after first entry
            if (entriesTable.children.length === 1) {
                party.disabled = true;
                document.getElementById('lockedPartyId').value = partyValue;
                document.getElementById('lockedPartyTitle').value = partyText;
            }
            qtyInput.value = '';
            rateInput.value = '';
            descriptionInput.value = '';
            fileInput.value = '';
            filePreviewContainer.style.display = 'none';
            imagePreview.src = '';
            fileNamePreview.textContent = '';
            // Add delete functionality
            newRow.querySelector('.delete-entry').addEventListener('click', function() {
                entriesTable.removeChild(newRow);
                entryData = entryData.filter(e => e.rowId !== rowId);
                // Recalculate total
                let sum = 0;
                entryData.forEach(e => sum += parseFloat(e.total));
                totalAmountInput.value = sum.toFixed(2);
                if (entriesTable.children.length === 0) {
                    party.disabled = false;
                    document.getElementById('lockedPartyId').value = '';
                    document.getElementById('lockedPartyTitle').value = '';
                }
            });
        });

        // Custom form submit to handle files and entries
        document.getElementById('voucherForm').addEventListener('submit', function(e) {
            if (entryData.length === 0) {
                alert('Please add at least one entry.');
                e.preventDefault();
                return false;
            }
            e.preventDefault();
            const form = e.target;
            const formData = new FormData();
            // Add CSRF token
            formData.append('_token', form.querySelector('input[name="_token"]').value);
            formData.append('account', document.getElementById('entryParty').value);
            formData.append('v_type', document.getElementById('invoice_type').value);
            formData.append('total_amount', document.getElementById('totalAmount').value);
            // Add entries
            entryData.forEach((entry, idx) => {
                formData.append(`entries[${idx}][date]`, entry.date);
                formData.append(`entries[${idx}][party]`, entry.party);
                formData.append(`entries[${idx}][prepared_by]`, entry.prepared);
                formData.append(`entries[${idx}][qty]`, entry.qty);
                formData.append(`entries[${idx}][rate]`, entry.rate);
                formData.append(`entries[${idx}][total]`, entry.total);
                formData.append(`entries[${idx}][description]`, entry.description);
                if (entry.file) {
                    formData.append(`entries[${idx}][file]`, entry.file);
                }
            });
            // Submit via AJAX
            fetch(form.action, {
                method: 'POST',
                body: formData,
            })
            .then(response => response.redirected ? window.location.href = response.url : response.text())
            .then(data => {
                if (typeof data === 'string' && data.includes('alert-danger')) {
                    document.body.innerHTML = data;
                }
            })
            .catch(err => {
                alert('Submission failed: ' + err);
            });
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/realerp/public_html/probox/resources/views/sales/gate_pass_in/list.blade.php ENDPATH**/ ?>