@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Reports</a></li>
                        <li class="breadcrumb-item active">Stock Reports</li>
                    </ol>
                </div>
                <h3 class="page-title">Stock Reports</h3>
            </div>
        </div>
    </div>
    <!-- end page title -->
    @if (session('success'))
    <div class="alert alert-success alert-dismissible text-bg-success border-0 fade show" role="alert">
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        {{ session('success') }}
    </div>
    @endif
    <!-- Search Form -->
    <div class="row">
        <div class="card mt-2">
            <div class="card-body">
                <div class="tab-content">
                    <div class="col-12">
                        <form action="{{ route('report.boxboard_stock') }}" method="GET" class="form-inline" id="search-form">
                            <div class="row">
                                <!-- Start Date -->
                                <div class="form-group col-xl-2" style="">
                                    <label for="start_date" class="sr-only">Start Date</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}">
                                </div>
                                <!-- End Date -->
                                <div class="form-group col-xl-2" style="">
                                    <label for="end_date" class="sr-only">End Date</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}" >
                                </div>

                                <div class="form-group col-xl-2 position-relative">
                                     <label for="item_name" class="sr-only">Item Name</label>
   <div class="autocomplete-wrapper">
    <input type="text"
           class="form-control"
           id="item_name"
           
           value="{{ request('item_name') }}"
           placeholder="Item Name">

    <input type="hidden"
           id="item_id"
           name="item_id"
           value="{{ request('item_id') }}">

    <div id="item_suggestions"
         class="suggestion-box list-group position-absolute w-100"></div>
</div>
</div>


                                <div class="form-group col-xl-2">
                                    <label for="garmmage" class="sr-only">Garmmage</label>
                                    <input type="garmmage" class="form-control" id="garmmage" name="garmmage" value="{{ request('garmmage') }}">
                                </div>
                                  <div class="form-group col-xl-2">
                                    <label for="length" class="sr-only">Length</label>
                                    <input type="length" class="form-control" id="length" name="length" value="{{ request('length') }}">
                                </div>
                                  <div class="form-group col-xl-2">
                                    <label for="width" class="sr-only">Width</label>
                                    <input type="width" class="form-control" id="width" name="width" value="{{ request('width') }}">
                                </div>
                                <!-- Voucher No Dropdown -->
                                <div class="form-group col-xl-2" style="display:none;">
                                    <label for="product_type" class="sr-only">Select Purchase</label>
                                    <select name="product_type" class="form-control select2" data-toggle="select2"
                                        id="product_type">
                                        <option value="">Select</option>
                                        <option value="Purchase Boxboard">Purchase Boxboard</option>
                                        <option value="Purchase Plate">Purchase Plate</option>
                                        <option value="Glue Purchase">Glue Purchase</option>
                                        <option value="Ink Purchase">Ink Purchase</option>
                                        <option value="Lamination Purchase">Lamination Purchase</option>
                                        <option value="Corrugation Purchase">Corrugation Purchase</option>
                                        <option value="Shipper Purchase">Shipper Purchase</option>
                                        <option value="Dye Purchase">Dye Purchase</option>
                                        <option value="disposable">Disposable Purchase</option>
                                        
                                    </select>
                                </div>

                               



                                <!-- Search and Add New Buttons -->
                                <div class="form-group mt-3">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Combined Data Table -->
    <div class="row">
        <div class="card">
            <div class="card-body">
                <button type="button" class="btn btn-secondary" style="width: 100px;" onclick="printTable()">Print
                    Table</button>
                <div class="card mt-2">
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="col-12">
                                @if(empty($productType))
                                @php
                                $groupedBoxboardData = [];
                                foreach ($trndtl as $data) {
                                $itemCode = $data->purchasedetails->items->item_code ?? 'N/A';
                                $width = $data->purchasedetails->width ?? 'N/A';
                                $length = $data->purchasedetails->lenght ?? 'N/A';
                                $grammage = $data->purchasedetails->grammage ?? 'N/A';
                                $qty = $data->purchasedetails->qty ?? 0;
                                $weight = $data->purchasedetails->total_wt ?? 0;

                                // Create a unique key combining item_code, width, length, and grammage
                                $key = $itemCode . '|' . $width . '|' . $length . '|' . $grammage;

                                if (!isset($groupedBoxboardData[$key])) {
                                $groupedBoxboardData[$key] = [
                                'item_code' => $itemCode,
                                'width' => $width,
                                'length' => $length,
                                'grammage' => $grammage,
                                'qty' => $qty,
                                'total_wt' => $weight
                                ];
                                } else {
                                $groupedBoxboardData[$key]['qty'] += $qty;
                                $groupedBoxboardData[$key]['total_wt'] += $weight;
                                }
                                }
                                @endphp

                                <table id="combined-data-table-boxboard"
                                    class="table table-striped dt-responsive nowrap w-100">
                                    <hr>
                                    <h2 for="boxboard">Purchase Boxboard Details</h2><hr>
                                    <thead>
                                        <tr>
                                            <th>Item Name</th>
                                            <th>Length</th>
                                            <th>Width</th>
                                            
                                            <th>Grammage</th>
                                            
                                            <th>Weights</th>
                                            <th>Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
    @foreach ($boxboardData as $data)
    <tr>
        <td>{{ $data->item_code }}</td>
        <td>{{ $data->length }}</td>
        <td>{{ $data->width }}</td>
        
        <td>{{ $data->grammage }}</td>
        
        <td>{{ $data->total_wt }}</td>
        <td>{{ $data->remain_qty }}</td>
    </tr>
    @endforeach
</tbody>
                                </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
// Set default dates
console.log("script running");
let item = document.getElementById('item_name');
// console.log(item);
// $('#item_name').on('keyup', function () {
//     console.log('keyup');
// });
// $(document).on('change', '#item_name', function () {
// console.log("jcbnb");

// });
function setupAutocomplete(inputId, suggestionBoxId, url) {
// console.log("skxn");
    $(inputId).on('keyup', function (e) {

        if (e.keyCode == 38 || e.keyCode == 40 || e.keyCode == 13) {
            return;
        }

        let query = $(this).val();

        if (query.length < 1) {
            $(suggestionBoxId).html('');
            return;
        }

        $.ajax({
            url: url,
            method: "GET",
            data: { term: query },

            success: function (data) {

                let html = '';

                data.forEach(function(item){

    html += `
        <a href="#"
           class="list-group-item list-group-item-action"
           data-id="${item.id}"
           data-name="${item.item_code}">
            ${item.item_code}
        </a>`;

});

                $(suggestionBoxId).html(html);
            }
        });
    });

   $(document).on('click', suggestionBoxId + ' a', function (e) {

    e.preventDefault();

    $('#item_name').val($(this).data('name'));
    $('#item_id').val($(this).data('id'));
    $(suggestionBoxId).html('');
});
    $(document).on('click', function (e) {
        if (!$(e.target).closest(inputId).length &&
            !$(e.target).closest(suggestionBoxId).length) {
            $(suggestionBoxId).html('');
        }
    });
}
$(document).on('keyup', '#item_name', function () {
    console.log('keyup working');
});
setupAutocomplete(
    '#item_name',
    '#item_suggestions',
    "{{ url('/probox/search-items') }}"
);
const today = new Date();
document.getElementById('end_date').valueAsDate = today;

function printTable() {
    // Get the current page title
    const pageTitle = document.querySelector('.page-title').innerText;
    
    // Get search criteria
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;
    const productType = document.getElementById('product_type').value;
    
    // Create a print window
    const printWindow = window.open('', '_blank');
    
    // Create print header with search criteria
    let printContent = `
        <html>
            <head>
                <title>${pageTitle}</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        margin: 20px;
                    }
                    .print-header {
                        text-align: center;
                        margin-bottom: 20px;
                        border-bottom: 1px solid #ddd;
                        padding-bottom: 10px;
                    }
                    .print-header h2 {
                        margin: 0;
                        font-size: 18px;
                    }
                    .print-header div {
                        margin: 5px 0;
                        font-size: 12px;
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                        margin-bottom: 20px;
                        font-size: 12px;
                    }
                    th, td {
                        border: 1px solid #ddd;
                        padding: 6px;
                        text-align: left;
                    }
                    th {
                        background-color: #f2f2f2;
                        font-weight: bold;
                    }
                    .section-title {
                        font-weight: bold;
                        margin: 15px 0 5px 0;
                        font-size: 14px;
                    }
                    @page {
                        size: auto;
                        margin: 10mm;
                    }
                    @media print {
                        body {
                            margin: 0;
                            padding: 0;
                        }
                    }
                </style>
            </head>
            <body>
                <div class="print-header">
                    <h2>${pageTitle}</h2>
                    <div><strong>Date:</strong> ${startDate} to ${endDate}</div>
    `;
    
    if (productType) {
        const typeText = document.querySelector(`#product_type option[value="${productType}"]`).text;
        printContent += `<div><strong>Type:</strong> ${typeText}</div>`;
    }
    
    printContent += `</div>`;
    
    // Get all visible tables
    const visibleTables = document.querySelectorAll('table[id^="combined-data-table-"]');
    
    // If no specific product type is selected, print all tables with their headings
    if (!productType) {
        visibleTables.forEach(table => {
            const heading = table.previousElementSibling;
            if (heading && heading.tagName === 'H4') {
                printContent += `<div class="section-title">${heading.innerText}</div>`;
            }
            printContent += table.outerHTML;
        });
    } else {
        // If specific product type is selected, print just that table
        const tableId = `combined-data-table-${productType.toLowerCase().substring(1)}`;
        const table = document.getElementById(tableId);
        if (table) {
            const heading = table.previousElementSibling;
            if (heading && heading.tagName === 'H4') {
                printContent += `<div class="section-title">${heading.innerText}</div>`;
            }
            printContent += table.outerHTML;
        }
    }
    
    printContent += `</body></html>`;
    
    // Write content to print window
    printWindow.document.open();
    printWindow.document.write(printContent);
    printWindow.document.close();
    
    // Wait for content to load before printing
    printWindow.onload = function() {
        setTimeout(function() {
            printWindow.print();
            printWindow.close();
        }, 200);
    };
}
</script>
@endsection