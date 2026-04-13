@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Softix</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Forms</a></li>
                        <li class="breadcrumb-item active">Edit Bank Payment</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Bank Payment</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

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
                    <form id="voucherForm" 
                          action="{{ route('bank_payment.update', $voucher->first()->v_no) }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="v_type" value="BPV">
                        <input type="hidden" id="invoice" name="invoice_number">
                        <input type="hidden" id="totalAmount" name="total_amount">

                        <div class="d-flex gap-2 mt-2">
                            <button type="button" id="addEntry" class="btn btn-primary btn-sm">Add Entry</button>
                            <button type="submit" class="btn btn-success btn-sm">Submit</button>
                        </div>

                        <!-- Invoice Display -->
                        <h3 class="mt-4">Invoice <span id="invoiceDisplay"></span></h3>

                        <!-- Entries Table -->
                        <div class="col-lg-12">
                            <table class="table mt-4" id="entriesTable">
                                <thead>
                                    <tr>
                                        <th>Sr No</th>
                                        <th>Date</th>
                                        <th>Cash</th>
                                        <th>Account Title</th>
                                        <th>Description</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="entriesBody">
                                    @foreach ($voucher as $entry)
                                        <tr>
                                            <td class="sr-no"></td>
                                            <td>
                                                <input type="date" 
                                                       name="entries[{{ $entry->id }}][date]" 
                                                       class="form-control" 
                                                       value="{{ $entry->date }}">
                                                <input type="hidden" 
                                                       name="entries[{{ $entry->id }}][id]" 
                                                       value="{{ $entry->id }}">
                                            </td>
                                            <td>
                                                <select name="entries[{{ $entry->id }}][cash]" class="form-control select2">
                                                    <option value="">Select</option>
                                                    @foreach ($accountMasters as $account)
                                                        <option value="{{ $account->id }}" 
                                                            @selected($entry->cash_id == $account->id)>
                                                            {{ $account->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="entries[{{ $entry->id }}][account]" class="form-control select2">
                                                    <option value="">Select</option>
                                                    @foreach ($accounts as $account)
                                                        <option value="{{ $account->id }}" 
                                                            @selected($entry->account_id == $account->id)>
                                                            {{ $account->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" 
                                                       name="entries[{{ $entry->id }}][description]" 
                                                       class="form-control" 
                                                       value="{{ $entry->description }}">
                                            </td>
                                            <td>
                                                <input type="number" 
                                                       name="entries[{{ $entry->id }}][debit]" 
                                                       class="form-control" 
                                                       value="{{ $entry->debit }}">
                                            </td>
                                            <td>
                                                <button type="button" 
                                                        class="btn btn-danger btn-sm remove-entry" 
                                                        data-id="{{ $entry->id }}">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
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
document.addEventListener('DOMContentLoaded', function () {
    const addEntryButton = document.getElementById('addEntry');
    const entriesTable = document.getElementById('entriesBody');

    // Add new row
    addEntryButton.addEventListener('click', function () {
        const entryKey = 'new_' + Date.now();
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td class="sr-no"></td>
            <td>
                <input type="date" name="entries[${entryKey}][date]" 
                       class="form-control" value="{{ date('Y-m-d') }}">
            </td>
            <td>
                <select name="entries[${entryKey}][cash]" class="form-control select2">
                    <option value="">Select</option>
                    @foreach ($accountMasters as $account)
                        <option value="{{ $account->id }}">{{ $account->title }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <select name="entries[${entryKey}][account]" class="form-control select2">
                    <option value="">Select</option>
                    @foreach ($accounts as $account)
                        <option value="{{ $account->id }}">{{ $account->title }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="text" name="entries[${entryKey}][description]" class="form-control">
            </td>
            <td>
                <input type="number" name="entries[${entryKey}][debit]" class="form-control" value="0">
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm remove-entry">Delete</button>
            </td>
        `;
        entriesTable.appendChild(newRow);
        updateSrNo();
        bindRemove(newRow);
    });

    // Remove row
    function bindRemove(row) {
        row.querySelector('.remove-entry').addEventListener('click', function () {
            const btn = this;
            const entryId = btn.getAttribute('data-id');
            if (entryId) {
                if (confirm('Are you sure you want to delete this entry?')) {
                    fetch(`/probox/bank_payment-delete/${entryId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                    })
                    .then(response => {
                        if (response) {
                            row.remove();
                            updateSrNo();
                        } else {
                            alert('Failed to delete entry.');
                        }
                    })
                    .catch(() => alert('Failed to delete entry.'));
                }
            } else {
                row.remove();
                updateSrNo();
            }
        });
    }

    // Bind remove for existing rows
    entriesTable.querySelectorAll('.remove-entry').forEach(btn => {
        bindRemove(btn.closest('tr'));
    });

    // Update serial numbers
    function updateSrNo() {
        Array.from(entriesTable.rows).forEach((r, i) => {
            r.querySelector('.sr-no').textContent = i + 1;
        });
    }

    updateSrNo();
});
</script>
@endsection
