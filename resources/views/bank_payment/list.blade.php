@extends('layouts.app')
@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Softix</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                            <li class="breadcrumb-item active">Form Elements</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Bank Payment</h4>
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




                        <div class="tab-content">
                            <div class="tab-pane show active" id="input-types-preview">
                                <div class="row">



                                        <form id="voucherForm" action="{{ route('bank_payment.store') }}" method="POST" enctype="multipart/form-data">
                                            <div class="col-xl-6">

                                                @csrf
                                                <!-- Image Upload Field -->
                                                <!-- Upload Image Section -->

                                                <input type="hidden" id="invoice_type" class="form-control" name="v_type"
                                                    value="BPV" required readonly>
                                                <input type="hidden" id="invoice" class="form-control"
                                                    name="invoice_number" required>

                                                <!-- Add a hidden input for total amount -->
                                                <input type="hidden" id="totalAmount" name="total_amount" value="0">

                                                <!-- Other fields for voucher entry -->
                                                <div class="mb-3">
                                                    <label for="entryDate" class="form-label">Date</label>
                                                    <input type="date" id="entryDate" class="form-control">
                                                </div>
                                                {{-- <div class="mb-3">
                                            <label for="entryCash" class="form-label">Bank</label>
                                            <input type="text" id="entryCash" class="form-control">
                                        </div> --}}
                                                <div class="mb-3">
                                                    <label for="entryParty" class="form-label">Bank</label>
                                                    <select name="account" class="form-control select2"
                                                        data-toggle="select2" id="entryCash">
                                                        <option value="">Select</option>
                                                        @foreach ($accountMasters as $account)
                                                            <option value="{{ $account->id }}">{{ $account->title }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <!-- Account Title Select (Single for all entries) -->
                                                <div class="mb-3">
                                                    <label for="mainAccountTitle" class="form-label">Account Title</label>
                                                    <select name="main_account" id="mainAccountTitle" class="form-control select2" data-toggle="select2">
                                                        <option value="">Select</option>
                                                        @foreach ($accounts as $account)
                                                            <option value="{{ $account->id }}">{{ $account->title }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="entryDescription" class="form-label">Description</label>
                                                    <textarea id="entryDescription" class="form-control"></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="entryAmount" class="form-label">Amount</label>
                                                    <input type="number" id="entryAmount" class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="uploadFile" class="form-label">Upload File</label>
                                                <input type="file" id="uploadFile" class="form-control" name="file">
                                                <div id="filePreviewContainer" class="mt-2" style="display:none;">
                                                    <img id="imagePreview" src="" alt="Image Preview" style="max-width: 150px; max-height: 150px; display:none;">
                                                    <span id="fileNamePreview" style="font-size:14px;"></span>
                                                    <button type="button" id="removeFile" class="btn btn-sm btn-danger">X</button>
                                                </div>
                                                </div>
                                                <button type="button" id="addEntry" class="btn btn-primary">Add
                                                    Entry</button>
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
                                                            <th>Cash</th>
                                                            <th>Account Title</th>
                                                            <th>Description</th>
                                                            <th>Amount</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="entriesBody">
                                                        <!-- Entries will appear here -->
                                                    </tbody>
                                                </table>
                                            </div>

                                            <!-- Total Amount Display -->
                                            <h4 class="text-end">Total Amount: <span id="totalAmountDisplay">0</span></h4>



                                        </form>
                                        {{-- <h1 id="totalAmount">Total Amount: 0.00</h1> --}}






                                </div>
                                <!-- end row-->
                            </div> <!-- end preview-->


                        </div> <!-- end tab-content-->
                    </div> <!-- end card-body -->
                </div> <!-- end card -->
            </div><!-- end col -->
        </div><!-- end row -->



    </div>
   <script>
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('entryDate').value = today;

    document.addEventListener('DOMContentLoaded', function () {
        const fileInput = document.getElementById('uploadFile');
        const imagePreview = document.getElementById('imagePreview');
        const fileNamePreview = document.getElementById('fileNamePreview');
        const filePreviewContainer = document.getElementById('filePreviewContainer');
        const removeFileButton = document.getElementById('removeFile');

        // File preview
        fileInput.addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (file) {
                const fileType = file.type;
                if (fileType.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        imagePreview.src = e.target.result;
                        imagePreview.style.display = 'block';
                        fileNamePreview.style.display = 'none';
                    };
                    reader.readAsDataURL(file);
                } else {
                    imagePreview.style.display = 'none';
                    fileNamePreview.textContent = file.name;
                    fileNamePreview.style.display = 'block';
                }
                filePreviewContainer.style.display = 'block';
            }
        });

        // Remove file
        removeFileButton.addEventListener('click', function () {
            fileInput.value = '';
            imagePreview.src = '';
            fileNamePreview.textContent = '';
            filePreviewContainer.style.display = 'none';
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const entriesTable = document.getElementById('entriesBody');
        const addEntryButton = document.getElementById('addEntry');
        const totalAmountInput = document.getElementById('totalAmount');
        const totalAmountDisplay = document.getElementById('totalAmountDisplay');
        const invoiceInput = document.getElementById('invoice');
        let invoiceCounter = 1;
        let totalAmount = 0;

        invoiceInput.value = invoiceCounter;

        addEntryButton.addEventListener('click', function () {
            const date = document.getElementById('entryDate').value;
            const cash = document.getElementById('entryCash');
            let selectedCash = cash.options[cash.selectedIndex];
            const selectedCashOption = selectedCash.text;
            const selectedCashBank = selectedCash.value;

            const mainAccount = document.getElementById('mainAccountTitle');
            let selectedOption = mainAccount.options[mainAccount.selectedIndex];
            const selectedParty = selectedOption.text;
            const selectedAccountParty = selectedOption.value;

            const description = document.getElementById('entryDescription').value;
            const amount = parseFloat(document.getElementById('entryAmount').value);
            const invoiceType = document.getElementById('invoice_type').value;

            if (!date || !description || isNaN(amount)) {
                alert('Please fill all fields.');
                return;
            }
            if (!cash.value) {
                alert('Cash Is Required');
                return;
            }
            if (!mainAccount.value) {
                alert('Account Title Is Required');
                return;
            }

            const invoiceNumber = invoiceCounter++;
            invoiceInput.value = invoiceNumber;

            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>${invoiceNumber}</td>
                <td>${date}</td>
                <td>${selectedCashOption}</td>
                <td>${selectedParty}</td>
                <td>${description}</td>
                <td>${amount.toFixed(2)}</td>
                <td>
                    <button type="button" class="btn btn-danger delete-entry">Delete</button>
                    <input type="hidden" name="entries[${Date.now()}][date]" value="${date}">
                    <input type="hidden" name="entries[${Date.now()}][cash]" value="${selectedCashBank}">
                    <input type="hidden" name="entries[${Date.now()}][account]" value="${selectedAccountParty}">
                    <input type="hidden" name="entries[${Date.now()}][description]" value="${description}">
                    <input type="hidden" name="entries[${Date.now()}][debit]" value="${amount.toFixed(2)}">
                    <input type="hidden" name="entries[${Date.now()}][v_type]" value="${invoiceType}">
                </td>
            `;
            entriesTable.appendChild(newRow);

            totalAmount += amount;
            totalAmountDisplay.textContent = totalAmount.toFixed(2);
            totalAmountInput.value = totalAmount.toFixed(2);

            // Do not lock Date, Cash, or Account Title fields after entry

            // Clear only entry-specific fields
            document.getElementById('entryDescription').value = '';
            document.getElementById('entryAmount').value = '';

            // Delete entry functionality
            newRow.querySelector('.delete-entry').addEventListener('click', function () {
                newRow.remove();

                totalAmount -= amount;
                totalAmountDisplay.textContent = totalAmount.toFixed(2);
                totalAmountInput.value = totalAmount.toFixed(2);

                // Fields remain editable regardless of entry count
            });
        });
    });
</script>


@endsection
