@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h4 class="page-title">Opening Balance</h4>
        </div>
    </div>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible text-bg-success border-0 fade show" role="alert">
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
            aria-label="Close"></button>
       {{ session('success') }}
    </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form id="voucherForm" action="{{ route('open_bal.store') }}" method="POST">
                        @csrf
                        <div class="col-xl-6">
                            <!-- Date field -->
                            <div class="mb-3">
                                <label for="entryDate" class="form-label">Opening Date</label>
                                <input type="date" id="entryDate" class="form-control" name="date" required>
                            </div>

                            <!-- Account Title Dropdown -->
                            <div class="mb-3">
                                <label for="accountTitle" class="form-label">Account Title</label>
                                <select id="accountTitle" class="form-control select2" data-toggle="select2"  name="account_id" >
                                    <option value="">Select Account</option>
                                    @foreach($accounts as $account)
                                    <option value="{{ $account->id }}">{{ $account->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Debit and Credit Amounts -->
                            <div class="mb-3">
                                <label for="debitAmount" class="form-label">Debit Amount</label>
                                <input type="number" id="debitAmount" class="form-control" placeholder="Enter Debit">
                            </div>
                            <div class="mb-3">
                                <label for="creditAmount" class="form-label">Credit Amount</label>
                                <input type="number" id="creditAmount" class="form-control" placeholder="Enter Credit">
                            </div>

                            <!-- Description Field -->
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea id="description" class="form-control" placeholder="Enter Description"></textarea>
                            </div>

                            <!-- Add Entry Button -->
                            <button type="button" id="addEntry" class="btn btn-primary">Add Entry</button>
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
                                    <th>Description</th>
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

                        <!-- Hidden inputs for total debit and credit -->
                        <input type="hidden" id="totalDebitInput" name="total_debit">
                        <input type="hidden" id="totalCreditInput" name="total_credit">

                        <!-- Submit Button -->
                        <button type="submit" id="submitVoucher" class="btn btn-success mt-3">Submit Voucher</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('entryDate').value = today;

    const entryTableBody = document.getElementById('entryTableBody');
    const debitTotalField = document.getElementById('debitTotal');
    const creditTotalField = document.getElementById('creditTotal');
    const totalDebitInput = document.getElementById('totalDebitInput');
    const totalCreditInput = document.getElementById('totalCreditInput');

    const accountTitle = document.getElementById('accountTitle');
    const debitAmountField = document.getElementById('debitAmount');
    const creditAmountField = document.getElementById('creditAmount');
    const entryDate = document.getElementById('entryDate');
    const descriptionField = document.getElementById('description');
    const addEntryButton = document.getElementById('addEntry');
    const submitVoucher = document.getElementById('submitVoucher');

    let entryCount = 0;

    // Function to calculate totals
    function calculateTotal() {
        let debitTotal = 0;
        let creditTotal = 0;

        document.querySelectorAll('.entry-debit').forEach(input => debitTotal += parseFloat(input.value) || 0);
        document.querySelectorAll('.entry-credit').forEach(input => creditTotal += parseFloat(input.value) || 0);

        debitTotalField.value = debitTotal;
        creditTotalField.value = creditTotal;

        totalDebitInput.value = debitTotal;
        totalCreditInput.value = creditTotal;
    }

    // Disable mutually exclusive fields in add-entry form
    debitAmountField.addEventListener('input', function() {
        creditAmountField.disabled = !!debitAmountField.value;
    });
    creditAmountField.addEventListener('input', function() {
        debitAmountField.disabled = !!creditAmountField.value;
    });

    // Add new entry
    addEntryButton.addEventListener('click', function() {
        const selectedOption = accountTitle.options[accountTitle.selectedIndex];
        const accountId = selectedOption.value;
        const accountText = selectedOption.text;
        const debitValue = parseFloat(debitAmountField.value) || '';
        const creditValue = parseFloat(creditAmountField.value) || '';
        const entryDateValue = entryDate.value;
        const descriptionValue = descriptionField.value;

        // Validation
        if (!entryDateValue) { alert('Please select a date'); return; }
        if (!accountId) { alert('Please select an account'); return; }
        if (!descriptionValue) { alert('Please enter description'); return; }
        if (debitValue && creditValue) { alert('Only one of Debit or Credit can be entered'); return; }
        if (!debitValue && !creditValue) { alert('Enter Debit or Credit value'); return; }

        entryCount++;

        const row = document.createElement('tr');
        row.id = `entryRow${entryCount}`;
        row.innerHTML = `
            <td>${entryCount}</td>
            <td>
                <input type="hidden" name="entry_date[]" value="${entryDateValue}">
                <span>${entryDateValue}</span>
            </td>
            <td>
                <input type="hidden" name="entry_account_title[]" value="${accountId}">
                <span>${accountText}</span>
            </td>
            <td>
                <input type="hidden" name="entry_debit[]" class="entry-debit" value="${debitValue}">
                <span>${debitValue}</span>
            </td>
            <td>
                <input type="hidden" name="entry_credit[]" class="entry-credit" value="${creditValue}">
                <span>${creditValue}</span>
            </td>
            <td>
                <input type="hidden" name="entry_description[]" value="${descriptionValue}">
                <span>${descriptionValue}</span>
            </td>
            <td>
                <button type="button" class="btn btn-danger remove-entry">Remove</button>
            </td>
        `;
        entryTableBody.appendChild(row);

        // Reset fields
        debitAmountField.value = '';
        creditAmountField.value = '';
        debitAmountField.disabled = false;
        creditAmountField.disabled = false;
        descriptionField.value = '';
        accountTitle.selectedIndex = 0;

        calculateTotal();
    });

    // Handle remove-entry button
    entryTableBody.addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-entry')) {
            const row = event.target.closest('tr');
            row.remove();
            calculateTotal();
            entryCount--;
        }
    });

    // Validate form before submission
    submitVoucher.addEventListener('click', function(event) {
        if (entryCount === 0) {
            alert('Please add at least one entry');
            event.preventDefault();
            return;
        }
        const debitTotal = parseFloat(debitTotalField.value) || 0;
        const creditTotal = parseFloat(creditTotalField.value) || 0;

        if (debitTotal !== creditTotal) {
            alert('Total Debit and Credit must be equal');
            event.preventDefault();
        }
    });
});
</script>
@endsection
