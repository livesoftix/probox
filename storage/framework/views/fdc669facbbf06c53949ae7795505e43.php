

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">ProBox</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                        <li class="breadcrumb-item active">Data Tables</li>
                    </ol>
                </div>
                <h4 class="page-title">Journal Voucher</h4>
            </div>
        </div>
    </div>

    
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-none">
                <div class="card-body">
                    <form id="voucherForm" action="<?php echo e(route('journal_voucher.store')); ?>" method="POST">
                        <div class="col-xl-6">
                            <?php echo csrf_field(); ?>

                            <!-- Date field -->
                            <div class="mb-3">
                                <label for="entryDate" class="form-label">Opening Date</label>
                                <input type="date" id="entryDate" class="form-control" name="voucher_date" required>
                                <input type="hidden" id="lockedDateInput" name="locked_date">
                            </div>
                            <input type="hidden" id="invoice_type" class="form-control" name="v_type" value="JV"
                                required readonly>
                            <!-- Account Title Dropdown -->
                            <div class="mb-3">
                                <label for="accountTitle" class="form-label">Account Title</label>
                                <select id="accountTitle" class="form-control select2" data-toggle="select2" name="account_id">
                                    <option value="">Select Account</option>

                                    <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($account->id); ?>"><?php echo e($account->title); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <!-- Debit and Credit Amounts -->
                            <div class="mb-3">
                                <label for="debitAmount" class="form-label">Debit Amount</label>
                                <input type="number" id="debitAmount" class="form-control" name="debit"
                                    placeholder="Enter Debit">
                            </div>
                            <div class="mb-3">
                                <label for="creditAmount" class="form-label">Credit Amount</label>
                                <input type="number" id="creditAmount" class="form-control" name="credit"
                                    placeholder="Enter Credit">
                            </div>

                            <!-- Description Field -->
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea id="description" class="form-control" name="description[]"></textarea>
                            </div>

                            <!-- Add Entry Button -->
                            <button type="button" id="addEntry" class="btn btn-primary">Add Entry</button>
                            <button type="submit" id="submitVoucher" class="btn btn-success">Submit Voucher</button>
                        </div>
                        <!-- Entry Table -->
                        <table class="table table-bordered mt-4">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Account Title</th>
                                    <th>Debit</th>
                                    <th>Credit</th>
                                    <th>Desciption</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="entryTableBody">
                                <!-- Entries will appear here -->
                            </tbody>
                        </table>

                        <!-- Totals -->
                        <div class="row">
                            <div class="col-md-6">
                                <label>Total Debit:</label>
                                <input type="text" id="debitTotal" class="form-control" readonly>
                            </div>
                            <div class="col-md-6">
                                <label>Total Credit:</label>
                                <input type="text" id="creditTotal" class="form-control" readonly>
                            </div>
                        </div>

                        <!-- Hidden inputs for total debit and total credit -->
                        <input type="hidden" id="totalDebitInput" name="total_debit">
                        <input type="hidden" id="totalCreditInput" name="total_credit">
                        <input type="hidden" id="descriptionValue" name="description">


                        <!-- Submit Button -->

                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script>
        const today = new Date().toISOString().split('T')[0];

        // Set the value of the input field to the current date
        document.getElementById('entryDate').value = today;

        document.addEventListener('DOMContentLoaded', function() {
            let entryTableBody = document.getElementById('entryTableBody');
            let debitTotalField = document.getElementById('debitTotal');
            let creditTotalField = document.getElementById('creditTotal');
            let accountTitle = document.getElementById('accountTitle');
            let debitAmountField = document.getElementById('debitAmount');
            let creditAmountField = document.getElementById('creditAmount');
            let entryDate = document.getElementById('entryDate');
            let lockedDateInput = document.getElementById('lockedDateInput');
            let date = entryDate.value;
            let addEntryButton = document.getElementById('addEntry');
            let submitVoucher = document.getElementById('submitVoucher');

            let totalDebitInput = document.getElementById('totalDebitInput');
            let totalCreditInput = document.getElementById('totalCreditInput');

            let entryCount = 0;
            let lockedDate = null;
            let isDateLocked = false;

            // Function to calculate the total amounts for debit and credit
            function calculateTotal() {
                let debitTotal = 0;
                let creditTotal = 0;

                document.querySelectorAll('.entry-debit').forEach(function(debitField) {
                    debitTotal += parseFloat(debitField.value) || 0;
                });

                document.querySelectorAll('.entry-credit').forEach(function(creditField) {
                    creditTotal += parseFloat(creditField.value) || 0;
                });

                debitTotalField.value = debitTotal.toFixed(2);
                creditTotalField.value = creditTotal.toFixed(2);

                totalDebitInput.value = debitTotal;
                totalCreditInput.value = creditTotal;
            }

            // Event listener to add a new entry to the table
            addEntryButton.addEventListener('click', function() {
                let selectedOption = accountTitle.options[accountTitle.selectedIndex];
                let accountTitleValue = selectedOption.text;
                let accountIdValue = selectedOption.value;

                let debitAmount = parseFloat(debitAmountField.value) || 0;
                let creditAmount = parseFloat(creditAmountField.value) || 0;
                let entryDateValue = entryDate.value;
                let descriptionValue = document.getElementById('description').value;

                date = entryDateValue;

                if (!entryDateValue) {
                    alert('Please select a date.');
                    return;
                }
                if (!accountTitle.value) {
                    alert('Please select an Account Title.');
                    return;
                }
                if (!accountTitleValue || (debitAmount <= 0 && creditAmount <= 0)) {
                    alert('Please fill all fields and enter a valid amount for debit or credit.');
                    return;
                }
                if (isNaN(debitAmount) && isNaN(creditAmount)) {
                    alert('Please enter a valid amount for either Debit or Credit.');
                    return;
                }
                if (debitAmount > 0 && creditAmount > 0) {
                    alert('You can only enter an amount in either Debit or Credit, not both.');
                    return;
                }

                // Lock date after first entry
                if (entryCount === 0) {
                    lockedDate = entryDateValue;
                    isDateLocked = true;
                    entryDate.disabled = true;
                    lockedDateInput.value = lockedDate;
                }

                entryCount++;
                let debitValue = debitAmount > 0 ? debitAmount : '';
                let creditValue = creditAmount > 0 ? creditAmount : '';

                let html = `
                <tr id="entryRow${entryCount}">
                    <td>${entryCount}</td>
                    <td>
                        <input type="hidden" name="entry_date[]" value="${lockedDate || date}" class='entry-date'>
                        <span class="entry-date-display">${lockedDate || date}</span>
                    </td>
                    <td>
                        <input type="hidden" name="entry_account_title[]" value="${accountIdValue}">
                        <span>${accountTitleValue}</span>
                    </td>
                    <td>
                        <input type="hidden" name="entry_debit[]" class="entry-debit" value="${debitValue}">
                        <span>${debitValue || ''}</span>
                    </td>
                    <td>
                        <input type="hidden" name="entry_credit[]" class="entry-credit" value="${creditValue}">
                        <span>${creditValue || ''}</span>
                    </td>
                    <td>
                        <input type="hidden" name="entry_description[]" value="${descriptionValue}">
                        <span>${descriptionValue}</span>
                    </td>
                    <td><button type="button" class="btn btn-danger remove-entry">Remove</button></td>
                </tr>
            `;

                entryTableBody.insertAdjacentHTML('beforeend', html);

                // ✅ Clear form fields after adding entry
                debitAmountField.value = '';
                creditAmountField.value = '';
                document.getElementById('description').value = '';
                accountTitle.value = ""; // reset native select
                if (typeof $ !== 'undefined' && $.fn.select2) {
                    $('#accountTitle').val('').trigger('change'); // reset Select2
                }

                debitAmountField.disabled = false;
                creditAmountField.disabled = false;

                calculateTotal();
            });

            // Disable one field if the other is filled
            debitAmountField.addEventListener('input', function() {
                if (debitAmountField.value) {
                    creditAmountField.disabled = true;
                    creditAmountField.value = '';
                } else {
                    creditAmountField.disabled = false;
                }
            });

            creditAmountField.addEventListener('input', function() {
                if (creditAmountField.value) {
                    debitAmountField.disabled = true;
                    debitAmountField.value = '';
                } else {
                    debitAmountField.disabled = false;
                }
            });

            // Remove entry
            entryTableBody.addEventListener('click', function(event) {
                if (event.target && event.target.classList.contains('remove-entry')) {
                    let row = event.target.closest('tr');
                    row.remove();
                    calculateTotal();
                    entryCount--;
                    let rows = entryTableBody.querySelectorAll('tr');
                    rows.forEach((row, index) => {
                        row.cells[0].textContent = index + 1;
                    });

                    // Unlock date if no entries remain
                    if (entryCount === 0) {
                        isDateLocked = false;
                        lockedDate = null;
                        entryDate.disabled = false;
                        lockedDateInput.value = '';
                    }

                    // ✅ Reset form fields when entry removed
                    debitAmountField.value = '';
                    creditAmountField.value = '';
                    document.getElementById('description').value = '';
                    accountTitle.value = "";
                    if (typeof $ !== 'undefined' && $.fn.select2) {
                        $('#accountTitle').val('').trigger('change');
                    }
                    debitAmountField.disabled = false;
                    creditAmountField.disabled = false;
                }
            });

            // Form submit validation
            submitVoucher.addEventListener('click', function(event) {
                event.preventDefault();
                
                let allEntriesValid = true;
                let debitTotal = parseFloat(debitTotalField.value) || 0;
                let creditTotal = parseFloat(creditTotalField.value) || 0;

                if (entryCount === 0) {
                    alert('Please add at least one entry before submitting the voucher.');
                    return;
                }

                document.querySelectorAll('tr[id^="entryRow"]').forEach(function(row) {
                    let debitValue = parseFloat(row.querySelector('.entry-debit').value) || 0;
                    let creditValue = parseFloat(row.querySelector('.entry-credit').value) || 0;
                    if (debitValue === 0 && creditValue === 0) {
                        allEntriesValid = false;
                    }
                });

                if (!allEntriesValid) {
                    alert('Please ensure that all entries have valid debit or credit values.');
                    return;
                }

                if (Math.abs(debitTotal - creditTotal) > 0.01) {
                    alert('The total debit and credit amounts must be equal.');
                    return;
                }

                if (submitVoucher.disabled) {
                    return;
                }
                
                // Enable date field before submission
                if (isDateLocked) {
                    entryDate.disabled = false;
                }
                
                submitVoucher.disabled = true;
                submitVoucher.textContent = 'Submitting...';
                document.getElementById("voucherForm").submit();
            });

            // Update all rows' dates when voucher date changes (only if not locked)
            entryDate.addEventListener('change', function() {
                if (isDateLocked) return;
                
                const newDate = this.value;
                if (!newDate) return;

                document.querySelectorAll('#entryTableBody .entry-date').forEach(function(hiddenInput) {
                    hiddenInput.value = newDate;
                    const td = hiddenInput.closest('td');
                    const span = td.querySelector('.entry-date-display');
                    if (span) {
                        span.textContent = newDate;
                    }
                });
                date = newDate;
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/realerp/public_html/probox/resources/views/journal_voucher/list.blade.php ENDPATH**/ ?>