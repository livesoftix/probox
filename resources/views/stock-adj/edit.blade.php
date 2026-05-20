@extends('layouts.app')

@section('title', 'Edit Stock Adjustment')


   <style>
    .table-responsive {
        overflow-x: auto;   /* only horizontal scroll allowed */
        overflow-y: visible;
    }

    .table-wrap {
        overflow: visible;
    }

    tr, td {
        position: relative;
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
    position: fixed !important;   /* 🔥 important change */
    z-index: 999999 !important;
    display: none;
    max-height: 250px;
    overflow-y: auto;
    background: #fff;
    border: 1px solid #ced4da;
    border-radius: 4px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.18);
    
}
    .pxi-dropdown.open {
        display: block !important;
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

    .pxi-option {
        padding: 0.5rem 0.75rem;
        cursor: pointer;
    }

    .pxi-option:hover {
        background: #f8f9fa;
    }
    .pxi-wrap {
    position: relative;
}


</style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {

    let rowIndex = {{ $stock_adj->details->count() ?? 0 }};

    // -----------------------------
    // OPEN DROPDOWN
    // -----------------------------
   $(document).on('click', '.pxi-display', function (e) {
    e.stopPropagation();

    const wrap = this.closest('.pxi-wrap');
    const dropdown = wrap.querySelector('.pxi-dropdown');

    // close others
    document.querySelectorAll('.pxi-dropdown').forEach(d => {
        if (d !== dropdown) d.classList.remove('open');
    });

    dropdown.classList.toggle('open');

    // ✅ FIX WIDTH HERE
    const rect = this.getBoundingClientRect();
    dropdown.style.width = rect.width + 'px';

    const search = wrap.querySelector('.pxi-search');
    if (search) search.focus();
});

    // -----------------------------
    // CLOSE OUTSIDE CLICK
    // -----------------------------
    $(document).on('click', function () {
        document.querySelectorAll('.pxi-dropdown')
            .forEach(d => d.classList.remove('open'));
    });

    // -----------------------------
    // SEARCH FILTER (FIXED)
    // -----------------------------
    $(document).on('input', '.pxi-search', function () {
        const val = this.value.toLowerCase();
        const dropdown = this.closest('.pxi-dropdown');

        dropdown.querySelectorAll('.pxi-option').forEach(opt => {
            opt.style.display =
                opt.innerText.toLowerCase().includes(val) ? '' : 'none';
        });
    });

    // -----------------------------
    // SELECT ITEM (MOST IMPORTANT FIX)
    // -----------------------------
    $(document).on('click', '.pxi-option', function () {

        const wrap = this.closest('.pxi-wrap');
        const display = wrap.querySelector('.pxi-display');
        const hidden = wrap.querySelector('.pxi-hidden-val');
        const rateInput = wrap.closest('tr').querySelector('.rate-input');
        const qtyInput = wrap.closest('tr').querySelector('.qty-input');

        display.innerText = this.innerText;
        hidden.value = this.dataset.value;
        rateInput.value = this.dataset.rate;
        console.log("Stock for selected item:", this.dataset.stock); // Debug log to check stock value
        qtyInput.value = this.dataset.stock;

        wrap.querySelector('.pxi-dropdown').classList.remove('open');
    });

    // -----------------------------
    // ADD ROW (FIXED)
    // -----------------------------
    $('#addRow').on('click', function () {

        const tbody = document.querySelector('#detailsTable tbody');

        const items = @json($items);

        let options = '';

        items.forEach(item => {
            options += `
                <div class="pxi-option"
                    data-value="${item.id}"
                    data-rate="${item.purchase ?? 0}"
                    data-stock="${item.current_stock ?? 0}">
                    ${item.item_code ?? item.id}
                </div>
            `;
        });

        const html = `
        <tr>
            <td>
                <div class="pxi-wrap">
                    <div class="pxi-display">-- Select Item --</div>

                    <div class="pxi-dropdown">
                        <div class="pxi-search-wrap">
                            <input type="text" class="pxi-search" placeholder="Search item...">
                        </div>
                        ${options}
                    </div>

                    <input type="hidden"
                        name="details[${rowIndex}][item_id]"
                        class="pxi-hidden-val">
                </div>
            </td>

            <td>
                <input type="number" step="0.01"
                    name="details[${rowIndex}][qty]"
                    class="form-control qty-input" >
            </td>

            <td>
                <input type="number" step="0.01"
                    name="details[${rowIndex}][rate]"
                    class="form-control rate-input">
            </td>

            <td>
                <button type="button" class="btn btn-danger btn-sm remove-row">X</button>
            </td>
        </tr>`;

        tbody.insertAdjacentHTML('beforeend', html);

        rowIndex++;
    });

    // -----------------------------
    // REMOVE ROW
    // -----------------------------
    $(document).on('click', '.remove-row', function () {
        $(this).closest('tr').remove();
    });

    const rect = this.getBoundingClientRect();

document.body.appendChild(dropdown);

dropdown.style.display = 'block';
dropdown.style.left = rect.left + 'px';
dropdown.style.top = (rect.bottom + window.scrollY) + 'px';
dropdown.style.width = rect.width + 'px';   // ✅ THIS FIXES WIDTH
dropdown.style.width = this.offsetWidth + 'px';
});
</script>
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Breadcrumb --}}
    <div class="row heading-bg" style="display:flex; align-items:center; padding:10px 15px; margin-bottom:10px;">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12" style="display:flex; align-items:center;">
            <h5 class="txt-primary" style="margin:0; font-weight:700; font-size:15px; letter-spacing:0.3px;">
                &nbsp;Edit Stock Adjustment — {{ $stock_adj->v_no }}
            </h5>
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12"
            style="display:flex; align-items:center; justify-content:flex-end;">
            <ol class="breadcrumb" style="margin:0; padding:0; background:none; font-size:12px;">
                <li><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('stock-adj.index') }}">Stock Adjustment</a></li>
                <li class="active"><span class="txt-primary">Edit Stock Adjustment</span></li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="">
                <div class=""></div>
                <div class="">
                    <div class="">
                        <div class="">
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('stock-adj.update', $stock_adj->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                {{-- Hidden fields --}}
                                <input type="hidden" name="v_no" value="{{ $stock_adj->v_no }}">
                                <input type="hidden" name="prepared_by" value="{{ $stock_adj->prepared_by }}">

                                {{-- Voucher Date --}}
                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <label class="control-label mb-10 text-left txt-primary">Voucher Date</label>
                                        <input type="date" name="v_date" class="form-control"
                                            value="{{ $stock_adj->v_date }}" required>
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
                                                    <th style="width:25%">Qty (+/-)</th>
                                                    <th style="width:20%">Rate</th>
                                                    <th style="width:10%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($stock_adj->details as $i => $detail)
                                                    <tr class="stock-adjustment-row">
                                                        <td>
                                                            <div class="pxi-wrap">
                                                                <button type="button" class="pxi-display">
                                                                    @php
                                                                        $selectedItem = $items->firstWhere('id', $detail->item_id);
                                                                    @endphp
                                                                    {{ $selectedItem ? $selectedItem->item_code : '-- Select Item --' }}
                                                                </button>
                                                                <span class="pxi-arrow">
                                                                    <svg width="10" height="6" viewBox="0 0 10 6" fill="none">
                                                                        <path d="M1 1L5 5L9 1" stroke="#888" stroke-width="1.5"
                                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                                    </svg>
                                                                </span>
                                                                <div class="pxi-dropdown">
                                                                    <div class="pxi-search-wrap">
                                                                        <input type="text" class="pxi-search"
                                                                            placeholder="Search item...">
                                                                    </div>
                                                                    <div class="pxi-list">
                                                                        @foreach($items as $item)
                                                                            @php
                                                                                $rate = $item->purchase ?? 0;
                                                                            @endphp
                                                                            <div class="pxi-option" data-value="{{ $item->id }}"
                                                                                data-rate="{{ $rate }}" {{ $detail->item_id == $item->id ? 'data-selected="true"' : '' }} data-stock="{{ $item->current_stock ?? 0 }}">
                                                                                {{ $item->item_code ?? $item->id }}
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                                <input type="hidden" name="details[{{ $i }}][item_id]"
                                                                    class="pxi-hidden-val" value="{{ $detail->item_id }}"
                                                                    required>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input type="number" step="0.01" min="-999999"
                                                                name="details[{{ $i }}][qty]" class="form-control qty-input"
                                                                value="{{ $detail->qty }}" required>
                                                        </td>
                                                        <td>
                                                            <input type="number" step="0.01" name="details[{{ $i }}][rate]"
                                                                class="form-control rate-input" value="{{ $detail->rate }}"
                                                                required>
                                                        </td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-danger btn-sm remove-row"><i
                                                                    class="fa fa-close"></i></button>
                                                        </td>
                                                    </tr>
                                                @endforeach
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
                                        <span class="btn-text">Update</span>
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
@endsection