

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Gate-Pass Out</h4>
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
                    <form id="voucherForm" action="<?php echo e(route('gate_pass_out.store')); ?>" method="POST" enctype="multipart/form-data">
                        <!-- Hidden fields for locking mechanism (party only) -->
                        <input type="hidden" id="lockedPartyId" value="">
                        <input type="hidden" id="lockedPartyTitle" value="">

                        <?php echo csrf_field(); ?>
                        <div class="col-6">
                            <input type="hidden" id="invoice_type" name="v_type" value="GPO" readonly>
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
        
        // Automatically set the date to today
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

            // Create a new row
            const newRow = document.createElement('tr');
            const rowId = Date.now();

            // Create image HTML only if file exists
            const imageHtml = file 
                ? `<img src="${URL.createObjectURL(file)}" alt="Image Preview" style="max-width: 50px; max-height: 50px;">`
                : 'No Image';

            // Create file name only if file exists
            const fileName = file ? file.name : '';

            newRow.innerHTML = `
                <td>${invoiceCounter}</td>
                <td>${date}</td>
                <td>${partyText}</td>
                <td>${description}</td>
                <td>${qty}</td>
                <td>${rate}</td>
                <td>${parseFloat(total).toFixed(2)}</td>
                <td>${imageHtml}</td>
                <td>
                    <button type="button" class="btn btn-danger delete-entry">Delete</button>
                    <input type="hidden" class="entry-date" value="${date}">
                    <input type="hidden" class="entry-party" value="${partyValue}">
                    <input type="hidden" class="entry-file-name" value="${fileName}">
                    <input type="hidden" class="entry-prepared-by" value="${prepared}">
                    <input type="hidden" class="entry-qty" value="${qty}">
                    <input type="hidden" class="entry-rate" value="${rate}">
                    <input type="hidden" class="entry-total" value="${Math.round(total)}">
                    <input type="hidden" class="entry-description" value="${description}">
                </td>
            `;

            // Attach file object to row for later serialization
            if (file) {
                newRow.fileObj = file;
            }

            entriesTable.appendChild(newRow);
            invoiceCounter++;

            // Lock party after first entry
            if (entriesTable.children.length === 1) {
                document.getElementById('entryParty').disabled = true;
                document.getElementById('lockedPartyId').value = partyValue;
                document.getElementById('lockedPartyTitle').value = partyText;
            }

            // Update total amount
            totalAmountInput.value = parseFloat(totalAmountInput.value) + parseFloat(total);

            // Reset input fields
            qtyInput.value = '';
            rateInput.value = '';
            descriptionInput.value = '';
            fileInput.value = '';
            filePreviewContainer.style.display = 'none';
            imagePreview.src = '';
            fileNamePreview.textContent = '';

            // Add delete functionality
            newRow.querySelector('.delete-entry').addEventListener('click', function() {
                const rowTotal = parseFloat(newRow.children[6].innerText);
                totalAmountInput.value = parseFloat(totalAmountInput.value) - rowTotal;
                entriesTable.removeChild(newRow);

                // Renumber sequence numbers
                Array.from(entriesTable.children).forEach(function(tr, idx) {
                    tr.children[0].innerText = idx + 1;
                });

                // Unlock party if no rows left
                if (entriesTable.children.length === 0) {
                    document.getElementById('entryParty').disabled = false;
                    document.getElementById('lockedPartyId').value = '';
                    document.getElementById('lockedPartyTitle').value = '';
                }
            });
        });
        // --- Custom Form Submission for Dynamic Rows and Files ---
        document.getElementById('voucherForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            const formData = new FormData();

            // Add CSRF token
            const csrf = form.querySelector('input[name="_token"]');
            if (csrf) formData.append('_token', csrf.value);

            // Add static fields
            formData.append('account', document.getElementById('entryParty').value);
            formData.append('v_type', document.getElementById('invoice_type').value);
            formData.append('total_amount', document.getElementById('totalAmount').value);

            // Gather dynamic entries
            const rows = entriesTable.querySelectorAll('tr');
            if (rows.length === 0) {
                alert('Please add at least one entry.');
                return;
            }
            let entryIdx = 0;
            rows.forEach(function(row) {
                // Use class selectors to get values
                const get = cls => row.querySelector('.' + cls)?.value || '';
                formData.append(`entries[${entryIdx}][date]`, get('entry-date'));
                formData.append(`entries[${entryIdx}][party]`, get('entry-party'));
                formData.append(`entries[${entryIdx}][file_name]`, get('entry-file-name'));
                formData.append(`entries[${entryIdx}][prepared_by]`, get('entry-prepared-by'));
                formData.append(`entries[${entryIdx}][qty]`, get('entry-qty'));
                formData.append(`entries[${entryIdx}][rate]`, get('entry-rate'));
                formData.append(`entries[${entryIdx}][total]`, get('entry-total'));
                formData.append(`entries[${entryIdx}][description]`, get('entry-description'));
                // Attach file if present
                if (row.fileObj) {
                    formData.append(`entries[${entryIdx}][file]`, row.fileObj);
                }
                entryIdx++;
            });

            // Submit via AJAX
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
            })
            .then(response => {
                if (response.redirected) {
                    window.location.href = response.url;
                    return;
                }
                // If not redirected, fallback to index route
                window.location.href = "<?php echo e(route('gate_pass_out.reports')); ?>";
            })
            .catch(err => {
                alert('Submission failed: ' + err);
            });
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/realerp/public_html/probox/resources/views/sales/gate_pass_out/list.blade.php ENDPATH**/ ?>