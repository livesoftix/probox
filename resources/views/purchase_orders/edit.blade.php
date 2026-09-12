@extends('layouts.app')

@section('content')

<style>

.po-edit-page {
    background: #f1f4f8;
    min-height: calc(100vh - 70px);
    padding: 30px 15px 60px;
}

.po-card {
    max-width: 1100px;
    margin: 0 auto;
    background: #ffffff;
    border-radius: 20px;
    padding: 40px 42px;
    box-shadow: 0 8px 30px rgba(15, 31, 55, 0.08);
}

/* =========================================================
   HEADER
========================================================= */

.po-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-bottom: 25px;
    margin-bottom: 30px;
    border-bottom: 1px solid #dfe5ec;
}

.company-section {
    display: flex;
    align-items: center;
    gap: 15px;
}

.logo-wrapper {
    width: 60px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.logo-wrapper img {
    display: block;
    object-fit: contain;
}

.brand-info {
    display: flex;
    flex-direction: column;
}

.company-name {
    margin: 0;
    font-size: 26px;
    font-weight: 800;
    color: #000;
    line-height: 1.1;
}

.company-name span {
    color: #e9252b;
}

.premium-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #f1f4f8;
    color: #526d89;
    border-radius: 20px;
    padding: 4px 12px;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: .4px;
    margin-top: 6px;
    width: fit-content;
}

.premium-badge i {
    color: #dda42e;
}

.po-heading {
    text-align: right;
}

.po-label {
    display: block;
    color: #0d1b35;
    font-size: 26px;
    font-weight: 800;
    letter-spacing: 0.5px;
}

/* =========================================================
   FORM LABELS & INPUTS
========================================================= */

.form-label-custom {
    display: block;
    color: #0d1b35;
    font-size: 15px;
    font-weight: 600;
    margin-bottom: 8px;
}

.required {
    color: #e53935;
}

.po-input,
.po-select,
.po-textarea {
    width: 100%;
    border: 1px solid #d8e0e9;
    border-radius: 11px;
    background: #fbfcfe;
    padding: 0 18px;
    color: #17263d;
    font-size: 15px;
    outline: none;
    transition: all 0.2s ease;
}

.po-input,
.po-select {
    height: 48px;
}

.po-textarea {
    padding: 12px 18px;
    min-height: 80px;
    resize: vertical;
}

.po-input:focus,
.po-select:focus,
.po-textarea:focus {
    border-color: #8da0b8;
    background: #ffffff;
    box-shadow: 0 0 0 3px rgba(43, 76, 112, 0.07);
}

.po-input[readonly] {
    background: #f1f4f8;
    color: #52657a;
}

/* =========================================================
   ITEMS SECTION
========================================================= */

.items-section {
    margin-top: 35px;
    background: #f3f6fa;
    border-radius: 14px;
    padding: 24px;
}

.items-header-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 22px;
}

.items-heading {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #0d1b35;
    font-size: 17px;
    font-weight: 700;
    margin: 0;
}

.items-table-header {
    display: grid;
    grid-template-columns: 50px 1fr 200px 50px;
    gap: 14px;
    padding: 0 8px 12px;
    border-bottom: 1px solid #d6dfe9;
}

.items-table-header div {
    color: #52657a;
    font-size: 13px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .3px;
}

.po-item-row {
    display: grid;
    grid-template-columns: 50px 1fr 200px 50px;
    gap: 14px;
    align-items: center;
    padding: 10px 8px;
    border-bottom: 1px solid #d6dfe9;
}

.item-input-field {
    width: 100%;
    height: 42px;
    border: 1px solid #d8e0e9;
    border-radius: 8px;
    background: #ffffff;
    padding: 0 14px;
    color: #17263d;
    font-size: 14px;
    outline: none;
}

.item-input-field:focus {
    border-color: #8da0b8;
    box-shadow: 0 0 0 2px rgba(43, 76, 112, .12);
}

.remove-item-btn {
    border: none;
    background: transparent;
    color: #e7a5aa;
    font-size: 18px;
    cursor: pointer;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 38px;
    width: 38px;
    border-radius: 8px;
    transition: all .2s ease;
}

.remove-item-btn:hover:not(:disabled) {
    color: #dc3545;
    background: #fde8e8;
}

.remove-item-btn:disabled {
    color: #d0d7e2;
    cursor: not-allowed;
}

.add-item-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    height: 38px;
    padding: 0 16px;
    border: 1px dashed #9eafc3;
    background: #ffffff;
    border-radius: 10px;
    color: #0d1b35;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all .2s ease;
}

.add-item-btn:hover {
    background: #0d1b35;
    color: #ffffff;
    border-color: #0d1b35;
}

.items-total-bar {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 15px;
    margin-top: 18px;
    padding-top: 15px;
    border-top: 1px solid #d6dfe9;
}

.items-total-label {
    font-size: 15px;
    font-weight: 700;
    color: #0d1b35;
}

.items-total-input {
    width: 180px;
    height: 42px;
    border: 1px solid #d8e0e9;
    border-radius: 8px;
    background: #ffffff;
    padding: 0 14px;
    font-weight: 700;
    color: #0d1b35;
    text-align: right;
}

/* =========================================================
   FOOTER
========================================================= */

.po-footer {
    margin-top: 34px;
    padding-top: 24px;
    border-top: 1px solid #dce3eb;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 15px;
}

.save-btn {
    height: 48px;
    padding: 0 27px;
    border: none;
    border-radius: 11px;
    background: #0d1b35;
    color: #ffffff;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all .2s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.save-btn:hover {
    background: #172b4d;
    transform: translateY(-1px);
}

.cancel-btn {
    height: 48px;
    padding: 0 27px;
    border: 1px solid #d6dfe9;
    border-radius: 11px;
    background: #ffffff;
    color: #0d1b35;
    font-size: 16px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.cancel-btn:hover {
    background: #f6f8fa;
    color: #0d1b35;
}

@media (max-width: 768px) {
    .po-edit-page {
        padding: 15px;
    }

    .po-card {
        padding: 25px 18px;
        border-radius: 15px;
    }

    .po-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }

    .po-heading {
        text-align: left;
    }

    .items-table-header,
    .po-item-row {
        min-width: 550px;
    }

    .items-section {
        overflow-x: auto;
    }
}

</style>

<div class="po-edit-page">

    <div class="po-card">

        {{-- HEADER --}}
        <div class="po-header">
            <div class="company-section">
                <div class="logo-wrapper">
                    <img src="{{ asset('assets/images/prologo.jpg') }}" alt="Logo" width="60" height="50">
                </div>
                <div class="brand-info">
                    <h2 class="company-name">
                        Pro-<span>Box</span> Packages
                    </h2>
                    <div class="premium-badge">
                        <i class="fas fa-box"></i>
                        Printing & Packaging Solution
                    </div>
                </div>
            </div>

            <div class="po-heading">
                <div class="po-label">
                    EDIT PURCHASE ORDER
                </div>
            </div>
        </div>

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="alert alert-danger mb-4" style="border-radius: 12px;">
                <strong>Please fix the following errors:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORM --}}
        <form action="{{ route('purchase_orders.update', $purchaseOrder) }}" method="POST" id="poForm">
            @csrf
            @method('PUT')

            <div class="row">
                {{-- Party Name --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label-custom">
                        Party Name <span class="required">*</span>
                    </label>
                    <input type="text"
                           name="party_name"
                           class="po-input"
                           value="{{ old('party_name', $purchaseOrder->party_name) }}"
                           placeholder="Enter party name"
                           required>
                </div>

                {{-- PO Code --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label-custom">
                        PO Code
                    </label>
                    <input type="text"
                           class="po-input"
                           value="{{ $purchaseOrder->po_code }}"
                           readonly>
                </div>

                {{-- Party Address --}}
                <div class="col-md-12 mb-3">
                    <label class="form-label-custom">
                        Party Address
                    </label>
                    <textarea name="party_address"
                              class="po-textarea"
                              rows="2"
                              placeholder="Enter party address">{{ old('party_address', $purchaseOrder->party_address) }}</textarea>
                </div>

                {{-- PO Date --}}
                <div class="col-md-4 mb-3">
                    <label class="form-label-custom">
                        PO Date <span class="required">*</span>
                    </label>
                    <input type="date"
                           name="po_date"
                           class="po-input"
                           value="{{ old('po_date', optional($purchaseOrder->po_date)->format('Y-m-d')) }}"
                           required>
                </div>

                {{-- Delivery Date --}}
                <div class="col-md-4 mb-3">
                    <label class="form-label-custom">
                        Delivery Date
                    </label>
                    <input type="date"
                           name="delivery_date"
                           class="po-input"
                           value="{{ old('delivery_date', optional($purchaseOrder->delivery_date)->format('Y-m-d')) }}">
                </div>

                {{-- Assign To --}}
                <div class="col-md-4 mb-3">
                    <label class="form-label-custom">
                        Assign To
                    </label>
                    <input type="text"
                           name="assign_to"
                           class="po-input"
                           value="{{ old('assign_to', $purchaseOrder->assign_to) }}"
                           placeholder="Enter assigned person">
                </div>

                {{-- Prepared By --}}
                <div class="col-md-4 mb-3">
                    <label class="form-label-custom">
                        Prepared By
                    </label>
                    <input type="text"
                           class="po-input"
                           value="{{ $purchaseOrder->preparedBy->name ?? '' }}"
                           readonly>
                </div>

                {{-- Print By --}}
                <div class="col-md-4 mb-3">
                    <label class="form-label-custom">
                        Print By
                    </label>
                    <input type="text"
                           name="print_by"
                           class="po-input"
                           value="{{ old('print_by', $purchaseOrder->print_by) }}"
                           placeholder="Enter print by">
                </div>

                {{-- Machine Size --}}
                <div class="col-md-4 mb-3">
                    <label class="form-label-custom">
                        Machine Size <span class="required">*</span>
                    </label>
                    <select name="machine_size" class="po-select" required>
                        <option value="">Select Machine Size</option>
                        @foreach([
                            '28 x 40',
                            '4 color',
                            '5 color',
                            '25 x 36',
                            '20 x 28'
                        ] as $machineSize)
                            <option value="{{ $machineSize }}" {{ old('machine_size', $purchaseOrder->machine_size) == $machineSize ? 'selected' : '' }}>
                                {{ $machineSize }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- ITEMS SECTION --}}
            <div class="items-section">
                <div class="items-header-bar">
                    <h3 class="items-heading">
                        <i class="fas fa-list-ul"></i>
                        Purchase Order Items
                    </h3>
                    <button type="button" class="add-item-btn" id="addItem">
                        <i class="fas fa-plus"></i> Add Item
                    </button>
                </div>

                <div class="items-table-header">
                    <div>#</div>
                    <div>Item Name</div>
                    <div>Quantity</div>
                    <div class="text-center">Action</div>
                </div>

                <div id="itemsBody">
                    @foreach($purchaseOrder->items as $index => $item)
                        <div class="po-item-row item-row">
                            <div class="row-number font-weight-bold">{{ $index + 1 }}</div>
                            <div>
                                <input type="text"
                                       name="items[{{ $index }}][item_name]"
                                       class="item-input-field"
                                       value="{{ $item->item_name }}"
                                       placeholder="Enter item name"
                                       required>
                            </div>
                            <div>
                                <input type="number"
                                       name="items[{{ $index }}][quantity]"
                                       class="item-input-field quantity"
                                       min="1"
                                       value="{{ $item->quantity }}"
                                       required>
                            </div>
                            <div class="text-center">
                                <button type="button" class="remove-item-btn remove-item" title="Remove item">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="items-total-bar">
                    <span class="items-total-label">Total Quantity:</span>
                    <input type="text" id="totalQuantity" class="items-total-input" value="{{ $purchaseOrder->total_quantity }}" readonly>
                </div>
            </div>

            {{-- FOOTER ACTIONS --}}
            <div class="po-footer">
                <a href="{{ route('purchase_orders.index') }}" class="cancel-btn">
                    Cancel
                </a>
                <button type="submit" class="save-btn">
                    <i class="fas fa-save"></i>
                    Update Purchase Order
                </button>
            </div>
        </form>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let itemIndex = {{ $purchaseOrder->items->count() }};
    const itemsBody = document.getElementById('itemsBody');
    const addItemButton = document.getElementById('addItem');
    const totalQuantity = document.getElementById('totalQuantity');

    function updateNumbers() {
        const rows = itemsBody.querySelectorAll('.item-row');
        rows.forEach((row, index) => {
            row.querySelector('.row-number').textContent = index + 1;
        });
    }

    function calculateTotal() {
        let total = 0;
        const quantities = itemsBody.querySelectorAll('.quantity');
        quantities.forEach(input => {
            const value = parseInt(input.value) || 0;
            total += value;
        });
        totalQuantity.value = total;
    }

    function updateRemoveButtons() {
        const buttons = itemsBody.querySelectorAll('.remove-item');
        buttons.forEach(button => {
            button.disabled = buttons.length === 1;
        });
    }

    addItemButton.addEventListener('click', function () {
        const row = document.createElement('div');
        row.classList.add('po-item-row', 'item-row');
        row.innerHTML = `
            <div class="row-number font-weight-bold"></div>
            <div>
                <input type="text"
                       name="items[${itemIndex}][item_name]"
                       class="item-input-field"
                       placeholder="Enter item name"
                       required>
            </div>
            <div>
                <input type="number"
                       name="items[${itemIndex}][quantity]"
                       class="item-input-field quantity"
                       min="1"
                       value="1"
                       required>
            </div>
            <div class="text-center">
                <button type="button" class="remove-item-btn remove-item" title="Remove item">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
        `;

        itemsBody.appendChild(row);
        itemIndex++;
        updateNumbers();
        updateRemoveButtons();
        calculateTotal();
    });

    itemsBody.addEventListener('click', function (event) {
        const button = event.target.closest('.remove-item');
        if (!button || button.disabled) {
            return;
        }

        const row = button.closest('.item-row');
        row.remove();
        updateNumbers();
        updateRemoveButtons();
        calculateTotal();
    });

    itemsBody.addEventListener('input', function (event) {
        if (event.target.classList.contains('quantity')) {
            calculateTotal();
        }
    });

    updateNumbers();
    updateRemoveButtons();
    calculateTotal();
});
</script>

@endsection