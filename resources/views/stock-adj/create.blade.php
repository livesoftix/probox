@extends('layouts.app')

@section('title', 'Add Stock Adjustment')


    <style>
        /* PXI Dropdown Styles */
        .pxi-wrap {
            position: relative;
            width: 100%;
        }

        .pxi-display {
            width: 100%;
            padding: 0.5rem 0.75rem;
            background: #fff;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            text-align: left;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .pxi-arrow {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
        }

        .pxi-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: #fff;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            z-index: 1000;
            display: none;
            max-height: 250px;
            overflow-y: auto;
        }

        .pxi-dropdown.open {
            display: block;
        }

        .pxi-search-wrap {
            padding: 8px;
            border-bottom: 1px solid #e9ecef;
        }

        .pxi-search {
            width: 100%;
            padding: 0.375rem 0.75rem;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
        }

        .pxi-list {
            max-height: 200px;
            overflow-y: auto;
        }

        .pxi-option {
            padding: 0.5rem 0.75rem;
            cursor: pointer;
            transition: background 0.2s;
        }

        .pxi-option:hover {
            background-color: #f8f9fa;
        }

        .remove-row {
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 0.25rem 0.5rem;
            cursor: pointer;
        }

        .remove-row:hover {
            background: #c82333;
        }
    </style>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function () {
            let rowIndex = 0;

            // Get today's date in YYYY-MM-DD format
            const todayDate = new Date().toISOString().split('T')[0];

            // ── PXI: Build item options HTML ───────────────────────────────────────
            function pxiBuildItemOptionsHtml(selectedValue = null) {
              const items = {!! json_encode($items) !!};
                let html = `<div class="pxi-option" data-value="" data-rate="0">-- Select Item --</div>`;
                items.forEach(item => {
                    // const rate = item.purchase ?? 0;
                    // const displayText = (item.item_code ?? item.id) + (item.description ? ' - ' + item.description : '');
                    const rate = item.purchase ? item.purchase : 0;

const displayText =
    (item.item_code ? item.item_code : item.id) +
    (item.description ? ' - ' + item.description : '');
                    html += `<div class="pxi-option"
                            data-value="${item.id}"
                            data-rate="${rate}">
                            ${displayText}
                        </div>`;
                });
                return html;
            }

            // ── PXI: Initialise a dropdown ────────────────────────────────────────
            function initPxiDropdown(wrap, selectedValue = null) {
                const display = wrap.querySelector('.pxi-display');
                const dropdown = wrap.querySelector('.pxi-dropdown');
                const hidden = wrap.querySelector('input[type="hidden"]');
                const searchInput = wrap.querySelector('.pxi-search');
                let options = wrap.querySelectorAll('.pxi-option');

                // If selectedValue provided, set display and hidden
                if (selectedValue !== null) {
                    const matchedOption = Array.from(options).find(opt => opt.getAttribute('data-value') == selectedValue);
                    if (matchedOption) {
                        display.innerText = matchedOption.innerText;
                        if (hidden) hidden.value = selectedValue;
                        // Also set rate in the row
                        const row = wrap.closest('tr');
                        if (row) {
                            const rate = matchedOption.getAttribute('data-rate');
                            row.querySelector('.rate-input').value = rate;
                        }
                    }
                }

                // Toggle dropdown
                display.addEventListener('click', (e) => {
                    e.stopPropagation();
                    document.querySelectorAll('.pxi-dropdown').forEach(d => {
                        if (d !== dropdown) d.classList.remove('open');
                    });
                    dropdown.classList.toggle('open');
                    if (dropdown.classList.contains('open') && searchInput) {
                        searchInput.focus();
                        searchInput.value = '';
                        filterOptions('');
                    }
                });

                // Filter on search
                if (searchInput) {
                    searchInput.addEventListener('input', (e) => {
                        filterOptions(e.target.value.toLowerCase());
                    });
                }

                function filterOptions(searchTerm) {
                    options.forEach(opt => {
                        const text = opt.innerText.toLowerCase();
                        if (searchTerm === '' || text.includes(searchTerm)) {
                            opt.style.display = '';
                        } else {
                            opt.style.display = 'none';
                        }
                    });
                }

                // Select option
                options.forEach(opt => {
                    opt.addEventListener('click', () => {
                        const val = opt.getAttribute('data-value');
                        const text = opt.innerText;
                        display.innerText = text;
                        if (hidden) hidden.value = val;
                        dropdown.classList.remove('open');
                        // Update rate in the row
                        const row = wrap.closest('tr');
                        if (row) {
                            const rate = opt.getAttribute('data-rate');
                            row.querySelector('.rate-input').value = rate;
                        }
                        // Dispatch change event if needed
                        const changeEvent = new Event('change', { bubbles: true });
                        if (hidden) hidden.dispatchEvent(changeEvent);
                    });
                });

                // Close when clicking outside
                document.addEventListener('click', (e) => {
                    if (!wrap.contains(e.target)) {
                        dropdown.classList.remove('open');
                    }
                });
            }

            // ── Create new row ────────────────────────────────────────────────────
          function createRow(index) {

    const items = {!! json_encode($items) !!};

    let options = '<option value="">Select Item</option>';

    items.forEach(function(item) {

        let rate = item.purchase ? item.purchase : 0;

        let itemCode = item.item_code ? item.item_code : item.id;

        let description = item.description ? ' - ' + item.description : '';

        options += `
        <option 
    value="${item.id}" 
    data-rate="${rate}"
    data-stock="${item.current_stock}">
                ${itemCode}${description}
            </option>
        `;
    });

    return `
        <tr>

            <td style="width:45%">
                <select
                    name="details[${index}][item_id]"
                    class="form-control item-select"
                    required>

                    ${options}

                </select>
            </td>

            <td style="width:25%">
                <input type="number"
                    step="0.01"
                    min="-999999"
                    name="details[${index}][qty]"
                    class="form-control qty"
                    required>
            </td>

            <td style="width:20%">
                <input type="number"
                    step="0.01"
                    name="details[${index}][rate]"
                    class="form-control rate-input"
                    required>
            </td>

            <td style="width:10%">
                <button type="button"
                    class="btn btn-danger remove-row">
                    Remove
                </button>
            </td>

        </tr>
    `;
}

            // ── Add new row ────────────────────────────────────────────────────────
           $('#addRow').click(function () {

    const tbody = document.querySelector('#detailsTable tbody');

    const rowHtml = createRow(rowIndex++);

    tbody.insertAdjacentHTML('beforeend', rowHtml);

    $('.item-select').select2({
        width: '100%'
    });

});
// AUTO FILL RATE ON ITEM SELECT
// $(document).on('change', '.item-select', function () {

//     let selectedOption = $(this).find(':selected');

//     let rate = selectedOption.data('rate');

//     $(this)
//         .closest('tr')
//         .find('.rate-input')
//         .val(rate);

// });
$(document).on('change', '.item-select', function () {

    let selectedOption = $(this).find(':selected');

    let rate = selectedOption.data('rate');

    let stock = selectedOption.data('stock');

    let row = $(this).closest('tr');

    row.find('.rate-input').val(rate);
    // console.log("Stock for selected item:", stock); // Debug log to check stock value

    row.find('.qty').val(stock);

});

            // ── Remove row ────────────────────────────────────────────────────────
            $(document).on('click', '.remove-row', function () {
                $(this).closest('tr').remove();
            });

            // ── Set voucher date to today ─────────────────────────────────────────
            $('input[name="v_date"]').val(todayDate);
            $('#addRow').trigger('click');
        });
    </script>


@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Breadcrumb --}}
    <div class="row heading-bg" style="display:flex; align-items:center; padding:10px 15px; margin-bottom:10px;">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12" style="display:flex; align-items:center;">
            <h5 class="txt-primary" style="margin:0; font-weight:700; font-size:15px; letter-spacing:0.3px;">
                &nbsp;Add Stock Adjustment
            </h5>
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12"
            style="display:flex; align-items:center; justify-content:flex-end;">
            <ol class="breadcrumb" style="margin:0; padding:0; background:none; font-size:12px;">
                <li><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('stock-adj.index') }}">Stock Adjustment</a></li>
                <li class="active"><span class="txt-primary">Add Stock Adjustment</span></li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
    <div class="card-body">
                <div >
                    <div >
                        <div class="form-wrap">
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('stock-adj.store') }}" method="POST">
                                @csrf

                                {{-- Hidden fields --}}
                                <input type="hidden" name="v_no" value="{{ $nextVNo ?? '' }}">
                                <input type="hidden" name="prepared_by" value="{{ $preparedByCid ?? '' }}">
                                <input type="hidden" name="cid" value="{{ auth()->user()->id }}">

                                {{-- Voucher Date --}}
                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <label class="control-label mb-10 text-left txt-primary">Voucher Date</label>
                                        <input type="date" name="v_date" class="form-control" required>
                                    </div>
                                </div>

                                {{-- Item Details Table --}}
                                <h5 class="mt-4 mb-3 txt-primary">Item Details</h5>
                                <div class="table-wrap">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="detailsTable">
                                            <thead class="table-light">
                                                <tr>
                                                    <th style="width:45%">Item</th>
                                                    <th style="width:25%">Qty (-)</th>
                                                    <th style="width:20%">Rate</th>
                                                    <th style="width:10%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {{-- Rows will be added dynamically --}}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="form-group mt-20 mb-0">
                                    <button type="button" id="addRow" class="btn btn-primary btn-anim mr-10">
                                        <i class="fa fa-plus"></i>
                                        <span class="btn-text">Add Row</span>
                                    </button>
                                    <button type="submit" class="btn btn-success btn-anim mr-10">
                                        <i class="icon-rocket"></i>
                                        <span class="btn-text">Save</span>
                                    </button>
                                    <a href="{{ route('stock-adj.index') }}" class="btn btn-default btn-anim">
                                        <i class="fa fa-times"></i>
                                        <span class="btn-text">Cancel</span>
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
</div>
        </div>
    </div>
@endsection