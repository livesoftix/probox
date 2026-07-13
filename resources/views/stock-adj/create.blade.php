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
                    <h4 class="page-title">Stock Adjustment</h4>
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

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible text-bg-danger border-0 fade show" role="alert">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                {{ session('error') }}
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane show active" id="input-types-preview">
                                <div class="row">
                                    <form id="voucherForm" action="{{ route('stock-adj.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <meta name="csrf-token" content="{{ csrf_token() }}">

                                        <div class="col-6">
                                            <input type="hidden" id="invoice_type" class="form-control" name="v_type"
                                                value="DPN" required readonly>
                                            <input type="hidden" id="invoice" class="form-control" name="invoice_number"
                                                required>
                                            
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
    <label for="product_type" class="sr-only">Voucher Type</label>
    <select name="product_type" class="form-control select2" data-toggle="select2" id="product_type">
        <option value="">Select</option>
        <option value="Purchase Boxboard">Purchase Boxboard</option>
        <option value="Purchase Plate">Purchase Plate</option>
        <option value="Glue Purchase">Glue Purchase</option>
        <option value="Ink Purchase">Ink Purchase</option>
        <option value="Lamination Purchase">Lamination Purchase</option>
        <option value="Corrugation Purchase">Corrugation Purchase</option>
        <option value="Shipper Purchase">Shipper Purchase</option>
        <option value="Dye Purchase">Dye Purchase</option>
        <option value="Others">Others</option>
    </select>
</div>

<div class="mb-3">
    <label for="item_name" class="form-label">Item Title</label>
    <select name="item_name" class="form-control select2" data-toggle="select2" id="item_name" required>
        <option value="">Select</option>
    </select>
    <input type="hidden" name="item_id" id="item_id">
</div>

<!-- Boxboard Fields -->
<div class="row" id="purchase_boxboard" style="display:none;">
    <div class="col-md-6 mb-3">
        <label for="length" class="form-label">Length</label>
        <input type="number" id="length" class="form-control" name="length" step="any" readonly>
    </div>
    <div class="col-md-6 mb-3">
        <label for="width" class="form-label">Width</label>
        <input type="number" id="width" class="form-control" name="width" step="any" readonly>
    </div>
</div>

<!-- Plate Fields -->
<div class="row" id="purchase_plate" style="display:none;">
    <div class="col-md-6 mb-3">
        <label for="product_name" class="form-label">Product Name</label>
        <input type="text" id="product_name" class="form-control" name="product_name" readonly>
    </div>
    <div class="col-md-6 mb-3">
        <label for="country_name" class="form-label">Country</label>
        <input type="text" id="country_name" class="form-control" name="country_name" readonly>
    </div>
</div>

<!-- Size Fields (for Lamination/Corrugation) -->
<div class="row" id="size_fields" style="display:none;">
    <div class="mb-3">
        <label for="size" class="form-label">Size</label>
        <input type="number" id="size" class="form-control" name="size" step="any" readonly>
    </div>
</div>


<!-- Common Quantity Field -->
<div class="row">
    <div class="col-md-4 mb-3">
        <label for="total_qty" class="form-label">Total Qty</label>
        <input type="number" id="total_qty" class="form-control" name="total_qty" step="any" readonly>
    </div>
    <div class="col-md-4 mb-3"  >
    <label>Adjustment Type</label>

    <select class="form-control select2" id="adjustment_type" data-toggle="select2">
        <option value="OUT">OUT</option>
        <option value="IN">IN</option>
    </select>
</div>
    <div class="col-md-4 mb-3">
        <label for="qty" class="form-label">Quantity</label>
        <input type="number" id="qty" class="form-control" name="qty" step="any">
    </div>
</div>
                                            
                                            
                                            
                                            
                                            
                                            
                                            <div class="mb-3" style="display:none">
                                                <label for="rate" class="form-label">Rate</label>
                                                <input type="number" id="rate" class="form-control" name="rate" step="any">
                                            </div>
                                            
                                            

                                            <div class="mb-3" style="display:none">
                                                <label for="description" class="form-label">Description</label>
                                                <textarea type="text" id="description" class="form-control" name="description"></textarea>
                                            </div>
                                            
 <button type="button" class="btn btn-primary" id="addRow">
    + Add Row
</button>
                                            <button type="submit" class="btn btn-success">Submit Voucher</button>
                                        </div>
    <hr>

<h5>Adjustment Items</h5>

<table class="table table-bordered" id="detailsTable">
    <thead>
        <tr>
            <th>Product Type</th>
            <th>Item</th>
            <th>Length</th>
            <th>Width</th>
            <!-- <th>Size</th> -->
            <th>Stock Qty</th>
            <th>Adjust Qty</th>
            <th>Type</th>
            <th width="80">Action</th>
        </tr>
    </thead>

    <tbody>

    </tbody>
</table>
                                
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
    
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
const today = new Date().toISOString().split('T')[0];
document.getElementById('entryDate').value = today;

document.addEventListener('DOMContentLoaded', function() {
    const totalQtyInput = document.getElementById('total_qty');
    const qtyInput = document.getElementById('qty');
    
    qtyInput.addEventListener('input', function() {
        const totalQty = parseFloat(totalQtyInput.value) || 0;
        const qty = parseFloat(this.value) || 0;
        
        if (qty > totalQty) {
            this.value = totalQty;
            alert('Quantity cannot exceed Total Quantity');
        }
    });
    
    // Optional: Also validate when leaving the field (on blur)
    qtyInput.addEventListener('blur', function() {
        const totalQty = parseFloat(totalQtyInput.value) || 0;
        const qty = parseFloat(this.value) || 0;
        
        if (qty > totalQty) {
            this.value = totalQty;
            alert('Quantity cannot exceed Total Quantity');
        }
    });
});


$('#addRow').click(function () {

    if($('#product_type').val()==''){
        alert('Select Product Type');
        return;
    }

    if($('#item_name').val()==''){
        alert('Select Item');
        return;
    }

    if($('#qty').val()=='' || $('#qty').val()==0){
        alert('Enter Quantity');
        return;
    }

    var row='';

    row += '<tr>';

    row += '<td>'
        + $('#product_type').val()
        + '<input type="hidden" name="product_type[]" value="'+$('#product_type').val()+'">'
        + '</td>';

    row += '<td>'
        + $('#item_name option:selected').text()
        + '<input type="hidden" name="item_name[]" value="'+$('#item_name').val()+'">'
        + '<input type="hidden" name="item_id[]" value="'+$('#item_id').val()+'">'
        + '</td>';

    row += '<td>'
        + $('#length').val()
        + '<input type="hidden" name="length[]" value="'+$('#length').val()+'">'
        + '</td>';

    row += '<td>'
        + $('#width').val()
        + '<input type="hidden" name="width[]" value="'+$('#width').val()+'">'
        + '</td>';

    // row += '<td>'
    //     + $('#size').val()
    //     + '<input type="hidden" name="size[]" value="'+$('#size').val()+'">'
    //     + '</td>';

    row += '<td>'
        + $('#total_qty').val()
        + '</td>';

    row += '<td>'
        + $('#qty').val()
        + '<input type="hidden" name="qty[]" value="'+$('#qty').val()+'">'
        + '</td>';

    row += '<td>'
        + $('#adjustment_type').val()
        + '<input type="hidden" name="adjustment_type[]" value="'+$('#adjustment_type').val()+'">'
        + '</td>';

    row += '<td>';

    row += '<button type="button" class="btn btn-danger btn-sm removeRow">Delete</button>';

    row += '</td>';
row += '<input type="hidden" name="product_name[]" value="'+$('#product_name').val()+'">';
row += '<input type="hidden" name="country_name[]" value="'+$('#country_name').val()+'">';
row += '<input type="hidden" name="description[]" value="'+$('#description').val()+'">';
    row += '</tr>';

    $('#detailsTable tbody').append(row);

    // Clear form
    $('#product_type').val('').trigger('change');
    $('#item_name').empty().append('<option value="">Select</option>').trigger('change');

    $('#item_id').val('');
    $('#length').val('');
    $('#width').val('');
    // $('#size').val('');
    $('#product_name').val('');
    $('#country_name').val('');
    $('#total_qty').val('');
    $('#qty').val('');
    $('#adjustment_type').val('OUT');

});
$(document).on('click','.removeRow',function(){

    $(this).closest('tr').remove();

});

$(document).ready(function() {
    // Initialize select2 once
    $('.select2').select2();

    // Hide all purchase-specific fields initially
    $('[id^="purchase_"]').hide();
    $('#size_fields').hide();

    // Product type change handler
    $('#product_type').change(function() {
        var selectedType = $(this).val();
        
        // Hide all fields first
        $('[id^="purchase_"]').hide();
        $('#size_fields').hide();
        $('#length, #width, #product_name, #country_name, #size, #total_qty').val('');
        
        // Clear and disable item dropdown
        $('#item_name').empty().append('<option value="">Select</option>').prop('disabled', true);
        
        if (selectedType) {
            $('#item_name').prop('disabled', false);
            loadItems(selectedType);
            
            // Show relevant fields based on selection
            switch(selectedType) {
                case 'Purchase Boxboard':
                    $('#purchase_boxboard').show();
                    break;
                case 'Purchase Plate':
                    $('#purchase_plate').show();
                    break;
                case 'Lamination Purchase':
                case 'Corrugation Purchase':
                    $('#size_fields').show();
                    break;
                case 'Others':
                    $('#size_fields').show();
                    break;
            }
        }
    });

   // Item name change handler - using proper Select2 event
$('#item_name').on('select2:select', function(e) {
    var selectedType = $('#product_type').val();
    
    var itemValue = $(this).val();
    
    // Clear quantity when item changes
    $('#qty').val('0');
    $('#item_id').val('');
    
    if (selectedType && itemValue) {
        loadItemDetails(selectedType, itemValue);
    }
});

// Product type change handler
$('#product_type').change(function() {
    var selectedType = $(this).val();
    $('#item_id').val('');
    // Hide all fields first
    $('[id^="purchase_"]').hide();
    $('#size_fields').hide();
    $('#length, #width, #product_name, #country_name, #size, #total_qty').val('');
    
    // Clear quantity when product type changes
    $('#qty').val('0');
    
    // Clear and disable item dropdown
    $('#item_name').empty().append('<option value="">Select</option>').prop('disabled', true);
    
    if (selectedType) {
        $('#item_name').prop('disabled', false);
        loadItems(selectedType);
        
        // Show relevant fields based on selection
        switch(selectedType) {
            case 'Purchase Boxboard':
                $('#purchase_boxboard').show();
                break;
            case 'Purchase Plate':
                $('#purchase_plate').show();
                break;
            case 'Lamination Purchase':
            case 'Corrugation Purchase':
                $('#size_fields').show();
                break;
        }
    }
});

   function loadItems(purchaseType) {


  // OTHERS - ALL ITEM MASTER
    // ============================
       if (purchaseType === 'Others') {

        $.ajax({
            url: '/probox/get-all-items',
            type: 'GET',
            dataType: 'json',

            success: function (data) {

                let $select = $('#item_name')
                    .empty()
                    .append('<option value="">Select</option>');

                $.each(data, function (key, item) {

                    $select.append($('<option>', {
                        value: item.item_code,
                        text: item.item_code,
                        'data-item-id': item.id,
                        'data-remain-qty': 0
                    }));
                });

                $select.trigger('change');
            },

            error: function (xhr) {
                console.error(xhr.responseText);
            }
        });

        return;
    }



    var viewMap = {
        'Purchase Boxboard': { view: 'boxboard_view', itemColumn: 'item_code' },
        'Purchase Plate': { view: 'plate_view', itemColumn: 'item_code' },
        'Glue Purchase': { view: 'glue_view', itemColumn: 'item' },
        'Ink Purchase': { view: 'ink_view', itemColumn: 'item' },
        'Lamination Purchase': { view: 'lamination_view', itemColumn: 'item_name' },
        'Corrugation Purchase': { view: 'corrugation_view', itemColumn: 'item_name' },
        'Shipper Purchase': { view: 'shipper_view', itemColumn: 'item' },
        'Dye Purchase': { view: 'dye_view', itemColumn: 'item_name' }
    };
    
    var config = viewMap[purchaseType];
    
    $.ajax({
        url: '/probox/get-purchased-items',
        type: 'GET',
        data: { 
            purchase_type: purchaseType,
            view: config.view,
            item_column: config.itemColumn
        },
        dataType: 'json',
        success: function(data) {
            console.log("Items loaded:", data);
            var $select = $('#item_name').empty().append('<option value="">Select</option>');
            
            $.each(data, function(key, value) {
                var itemValue = value[config.itemColumn];
                var displayText = itemValue;
                
                if (purchaseType === 'Purchase Boxboard') {
                    displayText = value.item_code + ' (L:' + value.length + ' x W:' + value.width + ')';
                    $select.append($('<option>', {
                        value: itemValue,
                        text: displayText,
                        'data-length': value.length,
                        'data-width': value.width,
                        'data-item-id': value.item_id,
                        'data-remain-qty': value.remain_qty || 0
                    }));
                } else if (purchaseType === 'Lamination Purchase' || purchaseType === 'Corrugation Purchase') {
                    // For Lamination/Corrugation, include size in display
                    displayText = value.item_name + ' | ' + (value.size || '');
                    $select.append($('<option>', {
                        value: itemValue,
                        text: displayText,
                        'data-item-id': value.item_id,
                        'data-remain-qty': value.remain_qty || 0,
                        'data-size': value.size || ''
                    }));
                } else {
                    $select.append($('<option>', {
                        value: itemValue,
                        text: displayText,
                        'data-item-id': value.item_id,
                        'data-remain-qty': value.remain_qty || 0
                    }));
                }
            });
            
            // Refresh Select2 safely
            if ($select.hasClass('select2-hidden-accessible')) {
                $select.select2('destroy');
            }
            $select.select2();
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", status, error, xhr.responseText);
            alert('Failed to load items. Error: ' + (xhr.responseJSON?.error || 'Unknown error'));
        }
    });
}
    
    function loadItemDetails(purchaseType, itemValue) {
        var selectedOption = $('#item_name option:selected');
        var remainQty = selectedOption.data('remain-qty') || 0;
        var itemId = selectedOption.data('item-id') || 0;
        
        $('#total_qty').val(remainQty);
        $('#item_id').val(itemId);
        
        if (purchaseType === 'Purchase Boxboard') {
            $('#length').val(selectedOption.data('length'));
            $('#width').val(selectedOption.data('width'));
        } 
        else if (purchaseType === 'Purchase Plate') {
            $.ajax({
                url: '/probox/get-purchase-item-details',
                type: 'GET',
                data: { 
                    purchase_type: purchaseType,
                    view: 'plate_view',
                    item_column: 'item_code',
                    item_value: itemValue
                },
                dataType: 'json',
                success: function(data) {
                    $('#product_name').val(data.product_name || '');
                    $('#country_name').val(data.country_name || '');
                },
                error: function(xhr) {
                    console.error("Error fetching details:", xhr.responseText);
                }
            });
        }
        else if (purchaseType === 'Lamination Purchase' || purchaseType === 'Corrugation Purchase' ||  purchaseType === 'Others') {
            $('#size').val(selectedOption.data('size') || '');
        }
    }
});
</script>
@endsection