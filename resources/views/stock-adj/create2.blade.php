@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <!-- Start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                        <li class="breadcrumb-item active">Stock Adjustment</li>
                    </ol>
                </div>
                <h4 class="page-title">Stock Adjustment </h4>
            </div>
        </div>
    </div>
    <!-- End page title -->

    @if (session('success'))
    <div class="alert alert-success alert-dismissible text-bg-success border-0 fade show" role="alert">
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        {{ session('success') }}
    </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane show active" id="input-types-preview">
                            <div class="row">
                                <form id="voucherForm" action="{{ route('stock-adj.store') }}" method="POST">
                                    @csrf
                                    <div class="col-6">
                                        <input type="hidden" id="lockedDate" value="">
                                        <input type="hidden" id="lockedSupplierId" value="">
                                        <input type="hidden" id="lockedSupplierTitle" value="">



                                        <input type="hidden" id="invoice_type" class="form-control" name="v_type"
                                            value="SA" required readonly>
                                        <input type="hidden" id="invoice" class="form-control" name="invoice_number"
                                            required>
                                        <input type="hidden" id="totalAmount" name="total_amount" value="0">
                                        <input type="hidden" id="totalWeight" name="total_weight" value="0">
                                        <input type="hidden" id="entryCash" class="form-control" name="cash"
                                            value="{{ $purchaseAccount ? $purchaseAccount->id : '' }}">

                                        <div class="mb-3">
                                            <label for="entryDate" class="form-label">Date</label>
                                            <input type="date" id="entryDate" class="form-control" name="date">
                                        </div>
                                        <div class="mb-3">
                                            <label for="preparedBy" class="form-label">Prepared By</label>
                                            <input type="text" id="preparedBy" class="form-control"
                                                value="{{$loggedInUser->name}}" name="prepared_by" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="entryParty" class="form-label">Supplier</label>
                                            <select name="account" class="form-control select2" data-toggle="select2"
                                                id="entryParty" required>
                                                <option value="">Select</option>
                                                @foreach ($accountSuppliers as $accountSupplie)
                                                <option value="{{ $accountSupplie->id }}">
                                                    {{ $accountSupplie->title }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>


                                        <div class="mb-3">
                                            <label for="itemTitle" class="form-label">Item Title</label>
                                            <select name="item" class="form-control select2" data-toggle="select2"
                                                id="itemTitle" required>
                                                <option value="">Select</option>
                                                @foreach ($items as $item)
                                                
                                                <option value="{{ $item->id }}">{{ $item->item_code }}</option>
                                                

                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3" style="display:none">
                                            <label for="width" class="form-label">Width</label>
                                            <input type="number" id="width" class="form-control" name="width">
                                        </div>

                                        <div class="mb-3" style="display:none">
                                            <label for="length" class="form-label">Length</label>
                                            <input type="number" id="length" class="form-control" name="length">
                                        </div>

                                        <div class="mb-3" style="display:none">
                                            <label for="gramage" class="form-label">Gramage</label>
                                            <input type="number" id="gramage" class="form-control" name="gramage"
                                                readonly>
                                        </div>

                                        <div class="mb-3">
                                            <label for="quantity" class="form-label">Quantity</label>
                                            <input type="number" id="quantity" class="form-control" name="quantity">
                                        </div>

                                        <div class="mb-3" style="display:none;">
                                            <label for="rate" class="form-label">Rate</label>
                                            <input type="number" id="rate" class="form-control" name="rate" readonly>
                                        </div>

                                        <div class="mb-3" style="display:none;">
                                            <label for="freight" class="form-label">Freight</label>
                                            <input type="number" id="freight" class="form-control" name="freight"
                                                value="0" readonly>
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
                                                    <th style="display:none;">Width</th>
                                                    <th style="display:none;">Length</th>
                                                    <th style="display:none;">Gramage</th>
                                                    <th>Quantity</th>
                                                    <th style="display:none;">Rate</th>
                                                    <th style="display:none;">Weight</th>
                                                    <th style="display:none;">Amount</th>
                                                    <th style="display:none;">Freight</th>
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

<script>

    const today = new Date().toISOString().split('T')[0];

    // Set the value of the input field to the current date
    document.getElementById('entryDate').value = today;

    document.addEventListener('DOMContentLoaded', function () {
        const entriesTable = document.getElementById('entriesBody');
        const addEntryButton = document.getElementById('addEntry');
        const invoiceInput = document.getElementById('invoice');
        const entryDateInput = document.getElementById('entryDate');
        const supplierSelect = document.getElementById('entryParty');
        let invoiceCounter = 1;

        invoiceInput.value = invoiceCounter;

        addEntryButton.addEventListener('click', function () {
            const date = entryDateInput.value;
            const width = document.getElementById('width').value;
            const length = document.getElementById('length').value;
            const gramage = document.getElementById('gramage').value;
            const quantity = document.getElementById('quantity').value;
            const rate = document.getElementById('rate').value;
            const freight = document.getElementById('freight').value;
            const cash = document.getElementById('entryCash').value;
            const prepared = document.getElementById('preparedBy').value;
            const item = document.getElementById('itemTitle');
            let selectedOption = item.options[item.selectedIndex];
            let itemTitleValue = selectedOption.text; // Account title text
            let itemIdValue = selectedOption.value; // Account ID
            const supplier = document.getElementById('entryParty');
            let selectedSupplier = supplier.options[supplier.selectedIndex];
            let supplierTitleValue = selectedSupplier.text; // Account title text
            let supplierIdValue = selectedSupplier.value; // Account ID

            const weight = ((length * width * gramage) / 15500) * quantity;
            const amount = weight * rate;

            if (!date  || !quantity  ) {
                alert('Please fill all fields.');
                return;
            }

            const newRow = document.createElement('tr');
            const seqNo = entriesTable.children.length + 1;
            const uniqueId = Date.now();
            newRow.innerHTML = `
                    <td>${seqNo}</td>
                    <td>${date}</td>
                    <td>${supplierTitleValue}</td>
                    <td>${itemTitleValue}</td>
                    <td style="display:none;">${width}</td>
                    <td style="display:none;">${length}</td>
                    <td style="display:none;">${gramage}</td>
                    <td >${quantity}</td>
                    <td style="display:none;">${rate}</td>
                    <td style="display:none;">${Math.round(weight)}</td>
                    <td style="display:none;">${Math.round(amount)}</td>
                    <td style="display:none;">${freight}</td>
                    <td>
                        <button type="button" class="btn btn-danger delete-entry">Delete</button>
                        <input type="hidden" name="entries[${uniqueId}][date]" value="${date}">
                        <input type="hidden" name="entries[${uniqueId}][cash]" value="${cash}">
                        <input type="hidden" name="entries[${uniqueId}][supplier]" value="${supplierIdValue}">
                        <input type="hidden" name="entries[${uniqueId}][item]" value="${itemIdValue}">
                        <input type="hidden" name="entries[${uniqueId}][prepared_by]" value="${prepared}">
                        <input type="hidden" name="entries[${uniqueId}][width]" value="${width}">
                        <input type="hidden" name="entries[${uniqueId}][length]" value="${length}">
                        <input type="hidden" name="entries[${uniqueId}][gramage]" value="${gramage}">
                        <input type="hidden" name="entries[${uniqueId}][quantity]" value="${quantity}">
                        <input type="hidden" name="entries[${uniqueId}][rate]" value="${rate}">
                        <input type="hidden" name="entries[${uniqueId}][freight]" value="${freight}">
                        <input type="hidden" name="entries[${uniqueId}][weight]" value="${Math.round(weight)}">
                        <input type="hidden" name="entries[${uniqueId}][amount]" value="${Math.round(amount)}">
                        <input type="hidden" name="entries[${uniqueId}][sequence_no]" value="${seqNo}">
                    </td>
                `;
            entriesTable.appendChild(newRow);

            // Disable the date and supplier input after adding the first entry
            entryDateInput.disabled = true;
            supplierSelect.disabled = true;

            // Clear input fields after adding entry
            document.getElementById('width').value = '';
            document.getElementById('length').value = '';
            document.getElementById('quantity').value = '';
            document.getElementById('freight').value = '0';
        });

        // Delegated delete-entry handler with renumbering and unlock logic
        entriesTable.addEventListener('click', function (e) {
            if (e.target.classList.contains('delete-entry')) {
                e.target.closest('tr').remove();

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

    document.addEventListener('DOMContentLoaded', function () {
        // Initialize select2 after DOM is fully loaded
        $('.select2').select2();

        // Listen for change event on the item dropdown
        $('#itemTitle').on('change', function () {
            // Get the selected value (item ID)
            var selectedItemId = $(this).val();

            // Log the selected value to the console
            console.log("Selected Item ID:", selectedItemId);

            // Perform AJAX request to fetch purchase details for the selected item
            if (selectedItemId) {
                $.ajax({
                    url: '/printingcell/get-item-details/' + selectedItemId,
                    method: 'GET',
                    success: function (response) {
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
                    error: function (xhr, status, error) {
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

</script>

@endsection