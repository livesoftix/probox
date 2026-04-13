@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <h4 class="page-title">Edit Opening Balance</h4>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('open_bal.update', $voucher->first()->v_no) }}" method="POST" id="editVoucherForm">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="entryDate" class="form-label">Opening Date</label>
                            <input type="date" id="entryDate" class="form-control" name="voucher_date" value="{{ $voucher->first()->date ?? '' }}" required>
                        </div>
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
                                @foreach ($voucher as $index => $entry)
                                <tr>
                                    <td>{{ $loop->iteration }}
                                        <input type="hidden" name="entry_id[{{ $index }}]" value="{{ $entry->id }}">
                                    </td>
                                    <td>
                                        <input type="date" name="entry_date[{{ $index }}]" class="form-control" value="{{ $entry->date }}" required>
                                    </td>
                                    <td>
                                        <select name="entry_account_title[{{ $index }}]" class="form-control" required>
                                            <option value="">Select Account</option>
                                            @foreach($accounts as $account)
                                                <option value="{{ $account->id }}" {{ $entry->account_id == $account->id ? 'selected' : '' }}>
                                                    {{ $account->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="entry_debit[{{ $index }}]" class="form-control entry-debit" value="{{ $entry->debit }}" min="0">
                                    </td>
                                    <td>
                                        <input type="number" name="entry_credit[{{ $index }}]" class="form-control entry-credit" value="{{ $entry->credit }}" min="0">
                                    </td>
                                    <td>
                                        <input type="text" name="description[{{ $index }}]" class="form-control" value="{{ $entry->description }}">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="deleteRow(this)">Delete</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-primary" onclick="addEntryRow()">Add Entry</button>
                        <button type="submit" class="btn btn-success">Update Voucher</button>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label>Total Debit:</label>
                                <input type="text" id="debitTotal" class="form-control" value="0" readonly>
                            </div>
                            <div class="col-md-6">
                                <label>Total Credit:</label>
                                <input type="text" id="creditTotal" class="form-control" value="0" readonly>
                            </div>
                        </div>
                    </form>

                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div><!-- end col -->
    </div><!-- end row -->

</div>
<script>
    function calculateTotal() {
        let debitTotal = 0;
        let creditTotal = 0;
        document.querySelectorAll('.entry-debit').forEach(function(input) {
            debitTotal += parseFloat(input.value) || 0;
        });
        document.querySelectorAll('.entry-credit').forEach(function(input) {
            creditTotal += parseFloat(input.value) || 0;
        });
        document.getElementById('debitTotal').value = debitTotal;
        document.getElementById('creditTotal').value = creditTotal;
    }

    function toggleDebitCredit(e) {
        const row = e.target.closest('tr');
        if (!row) return;
        const debitInput = row.querySelector('.entry-debit');
        const creditInput = row.querySelector('.entry-credit');
        if (e.target === debitInput) {
            if (debitInput.value && parseFloat(debitInput.value) > 0) {
                creditInput.disabled = true;
            } else {
                creditInput.disabled = false;
            }
        } else if (e.target === creditInput) {
            if (creditInput.value && parseFloat(creditInput.value) > 0) {
                debitInput.disabled = true;
            } else {
                debitInput.disabled = false;
            }
        }
    }

    document.addEventListener('input', function(e) {
        calculateTotal();
        if (e.target.classList.contains('entry-debit') || e.target.classList.contains('entry-credit')) {
            toggleDebitCredit(e);
        }
    });
    
    document.addEventListener('DOMContentLoaded', function() {
        calculateTotal();
        // On page load, set correct disabled state for all rows
        document.querySelectorAll('#entryTableBody tr').forEach(function(row) {
            const debitInput = row.querySelector('.entry-debit');
            const creditInput = row.querySelector('.entry-credit');
            if (debitInput && creditInput) {
                if (debitInput.value && parseFloat(debitInput.value) > 0) {
                    creditInput.disabled = true;
                } else {
                    creditInput.disabled = false;
                }
                if (creditInput.value && parseFloat(creditInput.value) > 0) {
                    debitInput.disabled = true;
                } else {
                    debitInput.disabled = false;
                }
            }
        });
    });

    function deleteRow(btn) {
        let row = btn.closest('tr');
        row.remove();
        calculateTotal();
    }

    function addEntryRow() {
        let tbody = document.getElementById('entryTableBody');
        let rowCount = tbody.children.length + 1;

        // Prepare account options from Blade
        let accountOptions = `@foreach($accounts as $account)
            <option value="{{ $account->id }}">{{ $account->title }}</option>
        @endforeach`;

        let row = document.createElement('tr');
        row.innerHTML = `
            <td>${rowCount}</td>
            <td><input type="date" name="entry_date[]" class="form-control" value="{{ date('Y-m-d') }}" required></td>
            <td>
                <select name="entry_account_title[]" class="form-control" required>
                    <option value="">Select Account</option>
                    \${accountOptions}
                </select>
            </td>
            <td><input type="number" name="entry_debit[]" class="form-control entry-debit" min="0"></td>
            <td><input type="number" name="entry_credit[]" class="form-control entry-credit" min="0"></td>
            <td><input type="text" name="description[]" class="form-control"></td>
            <td><button type="button" class="btn btn-danger btn-sm" onclick="deleteRow(this)">Delete</button></td>
        `;
        tbody.appendChild(row);

        calculateTotal();
    }

    document.getElementById('editVoucherForm').addEventListener('submit', function(e) {
        let debit = parseFloat(document.getElementById('debitTotal').value) || 0;
        let credit = parseFloat(document.getElementById('creditTotal').value) || 0;
        if (debit !== credit) {
            alert('Total debit and credit must be equal.');
            e.preventDefault();
        }
    });
</script>
@endsection