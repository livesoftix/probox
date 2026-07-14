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
                            <li class="breadcrumb-item active">Edit Stock Adjustment</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Edit Stock Adjustment</h4>
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
                                    <form id="voucherForm" action="{{ route('stock-adj.update',$master->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <meta name="csrf-token" content="{{ csrf_token() }}">

                                        <div class="col-6">
                                            <input type="hidden" id="invoice_type" class="form-control" name="v_type"
                                                value="DPN" required readonly>
                                            <input type="hidden" id="invoice" class="form-control" name="invoice_number"
                                                required>
                                            
                                            <div class="mb-3">
                                                <label for="entryDate" class="form-label">Date</label>
                                                <input type="date" id="entryDate" class="form-control" name="date" value="{{ $master->v_date }}">
                                            </div>

                                            <div class="mb-3" >
                                                <label for="preparedBy" class="form-label">Prepared By</label>
                                                <input type="text" id="preparedBy" class="form-control"
                                                    value="{{ $loggedInUser->name }}" name="prepared_by" readonly>
                                            </div>

                                            
                                            
                                            <div class="mb-3">
                                                <label for="product_type" class="sr-only">Voucher Type</label>
                                                <select name="product_type" class="form-control select2" data-toggle="select2" id="product_type">
                                                    <option value="">Select</option>
                                                    <option value="Purchase Boxboard" >Purchase Boxboard</option>
                                                    <option value="Purchase Plate" >Purchase Plate</option>
                                                    <option value="Glue Purchase" >Glue Purchase</option>
                                                    <option value="Ink Purchase" >Ink Purchase</option>
                                                    <option value="Lamination Purchase" >Lamination Purchase</option>
                                                    <option value="Corrugation Purchase" >Corrugation Purchase</option>
                                                    <option value="Shipper Purchase" >Shipper Purchase</option>
                                                    <option value="Dye Purchase">Dye Purchase</option>
                                                    <option value="Others">Others</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="item_name" class="form-label">Item Title</label>
                                                <select name="item_name" class="form-control select2" data-toggle="select2" id="item_name" >
                                                    <option value="" selected></option>
                                                </select>
                                                <input type="hidden" name="item_id" id="item_id">
                                            </div>

                                            <!-- Boxboard Fields -->
                                            <div class="row" id="purchase_boxboard" style="">
                                                <div class="col-md-6 mb-3">
                                                    <label for="length" class="form-label">Length</label>
                                                    <input type="number" id="length" class="form-control" name="length" step="any" value="">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="width" class="form-label">Width</label>
                                                    <input type="number" id="width" class="form-control" name="width" step="any" value="" >
                                                </div>
                                            </div>

                                            <!-- Plate Fields -->
                                            <div class="row" id="purchase_plate" style="display:none;">
                                                <div class="col-md-6 mb-3">
                                                    <label for="product_name" class="form-label">Product Name</label>
                                                    <input type="text" id="product_name" class="form-control" name="product_name" value="">
                                                </div>
                                                <div class="col-md-6 mb-3" style="display:none">
                                                    <label for="country_name" class="form-label">Country</label>
                                                    <input type="text" id="country_name" class="form-control" name="country_name" value="">
                                                </div>
                                            </div>

                                            <!-- Size Fields (for Lamination/Corrugation) -->
                                            <div class="row" id="size_fields" style="display:none;">
                                                <div class="mb-3">
                                                    <label for="size" class="form-label">Size</label>
                                                    <input type="number" id="size" class="form-control" name="size" step="any" value="" >
                                                </div>
                                            </div>
                                            <!-- Common Quantity Field -->
                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <label for="total_qty" class="form-label">Total Qty</label>
                                                    <input type="number" id="total_qty" class="form-control" name="total_qty" step="any" value="" readonly>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label for="qty" class="form-label">Quantity</label>
                                                    <input type="number" id="qty" class="form-control" name="qty" step="any" value="">
                                                </div>
                                                <div class="col-md-4 mb-3"  >
    <label>Adjustment Type</label>

    <select class="form-control select2" id="adjustment_type" data-toggle="select2">
        <option value="OUT">OUT</option>
        <option value="IN">IN</option>
    </select>
</div>
                                            </div>
                                            
                                            <div class="mb-3" style="display:none">
                                                <label for="rate" class="form-label">Rate</label>
                                                <input type="number" id="rate" class="form-control" name="rate" step="any" value="">
                                            </div>
                                            
                                            
                                            
                                            
                                            
                                            <div class="mb-3">
                                                <label for="description" class="form-label">Description</label>
                                                <textarea type="text" id="description" class="form-control" name="description"></textarea>
                                            </div>
                                            
<button type="button" class="btn btn-primary" id="addRow">
    + Add Row
</button>
                                            <button type="submit" class="btn btn-success">Update Voucher</button>
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
        <th>Qty</th>
        <th>Type</th>
        <th>Action</th>
    </tr>
    </thead>

    <tbody>

@foreach($master->details as $detail)

<tr>

<td>
{{ $detail->product_type }}

<input type="hidden" name="detail_id[]" value="{{ $detail->id }}">
<input type="hidden" name="product_type[]" value="{{ $detail->product_type }}">

</td>

<td>

{{ $detail->item_name }}

<input type="hidden" name="item_name[]" value="{{ $detail->item_name }}">
<input type="hidden" name="item_id[]" value="{{ $detail->item_id }}">

</td>

<td>

{{ $detail->length }}

<input type="hidden" name="length[]" value="{{ $detail->length }}">

</td>

<td>

{{ $detail->width }}

<input type="hidden" name="width[]" value="{{ $detail->width }}">

</td>

<!-- <td>

{{ $detail->size }}

<input type="hidden" name="size[]" value="{{ $detail->size }}">

</td> -->

<td>

{{ $detail->qty }}

<input type="hidden" name="qty[]" value="{{ $detail->qty }}">

</td>

<td>

{{ $detail->adjustment_type }}

<input type="hidden"
name="adjustment_type[]"
value="{{ $detail->adjustment_type }}">

</td>

<td>

<button
type="button"
class="btn btn-danger btn-sm removeRow"
data-id="{{ $detail->id }}">
Delete

</button>

</td>

</tr>

@endforeach

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
let adjustmentType = $('#adjustment_type').val();
$('#addRow').click(function () {

    let productType = $('#product_type').val();
    let itemName    = $('#item_name').val();
    let itemId      = $('#item_name option:selected').data('id');
    let length      = $('#length').val();
    let width       = $('#width').val();
    let size        = $('#size').val();
    let qty         = $('#qty').val();
    let description = $('#description').val();
    console.log("item id " + itemId);

    if(productType == '' || itemName == '' || qty == ''){
        alert('Please fill required fields.');
        return;
    }

    let row = `
    <tr>
        <td>
            ${productType}
            <input type="hidden" name="product_type[]" value="${productType}">
        </td>

        <td>
            ${itemName}
            <input type="hidden" name="item_name[]" value="${itemName}">
             <input type="hidden" name="item_id[]" value="${itemId}">
        </td>

        <td>
            ${length}
            <input type="hidden" name="length[]" value="${length}">
        </td>

        <td>
            ${width}
            <input type="hidden" name="width[]" value="${width}">
        </td>

        

        <td>
            ${qty}
            <input type="hidden" name="qty[]" value="${qty}">
        </td>

       <td>
    ${adjustmentType}
    <input type="hidden" name="adjustment_type[]" value="${adjustmentType}">
</td>

        <td>
            <button type="button" class="btn btn-danger btn-sm removeRow">
                Delete
            </button>
        </td>
    </tr>`;

    $('#detailsTable tbody').append(row);

    // Reset Form
    $('#product_type').val('').trigger('change');
    $('#item_name').empty().append('<option value="">Select</option>').trigger('change');

    $('#item_id').val('');
    $('#length').val('');
    $('#width').val('');
    $('#size').val('');
    $('#product_name').val('');
    $('#country_name').val('');
    $('#qty').val('');
    $('#total_qty').val('');
    $('#description').val('');

    // Hide Optional Fields
    $('#purchase_boxboard').hide();
    $('#purchase_plate').hide();
    $('#size_fields').hide();
});

$(document).on('click','.removeRow',function(){

    if(confirm('Delete this row?')){
        $(this).closest('tr').remove();
    }

});
$(document).ready(function() {
    loadUpdatedStock();

function loadUpdatedStock()
{
    $.ajax({
        url: "{{ route('stock-adj.updated-stock') }}",
        type: "GET",
        data: {
            purchase_type: $('#product_type').val(),
            item_id: $('#item_name').val()
        },
        success: function(res) {

            $('#total_qty').val(res.remain_qty);

            if(res.length){
                $('#length').val(res.length);
            }

            if(res.width){
                $('#width').val(res.width);
            }

            if(res.size){
                $('#size').val(res.size);
            }

            if(res.product_name){
                $('#product_name').val(res.product_name);
            }

            if(res.country_name){
                $('#country_name').val(res.country_name);
            }

        },
        error:function(xhr){
            console.log(xhr.responseText);
        }
    });
}
    // Initialize select2 once
    $('.select2').select2();

    // Store original product type for comparison
    const originalProductType = $('#product_type').val();

    // Product type change handler
    $('#product_type').change(function() {
        var selectedType = $(this).val();
         if (selectedType === 'Others') {
    $('#total_qty')
        .prop('readonly', false)
        .val('');
} else {
    $('#total_qty')
        .prop('readonly', true)
        .val('');
}
        
        // Hide all fields first
        $('[id^="purchase_"]').hide();
        $('#size_fields').hide();
        
        // Clear fields when changing product type (except when reverting to original)
        if (selectedType !== originalProductType) {
            $('#length, #width, #product_name, #country_name, #size, #total_qty').val('');
            $('#item_name').empty().append('<option value="">Select</option>');
        }
        
        // Clear quantity when product type changes
        $('#qty').val('0');
        
        if (selectedType) {
            // Only load items if changing to a different product type
            if (selectedType !== originalProductType) {
                loadItems(selectedType);
            }
            
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


    $('#product_type').change(function () {

    var selectedType = $(this).val();

    // Hide all
    $('[id^="purchase_"]').hide();
    $('#size_fields').hide();

    // Clear previous values
    $('#length,#width,#product_name,#country_name,#size,#total_qty').val('');

    switch(selectedType){

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
               $('#purchase_boxboard').show();

               $('#length, #width').prop('readonly', false);
               break;
        
    }

    if(selectedType){
        loadItems(selectedType);
    }

});

    // Item name change handler - using proper Select2 event
    $('#item_name').on('select2:select', function(e) {
        var selectedType = $('#product_type').val();
        var itemValue = $(this).val();
        
        // Clear quantity when item changes
        $('#qty').val('0');
        
        if (selectedType && itemValue) {
            loadItemDetails(selectedType, itemValue);
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
    'data-id': value.item_id,   // <-- Add this
    'data-length': value.length,
    'data-width': value.width,
    'data-remain-qty': value.remain_qty || 0
}));
                    } else if (purchaseType === 'Lamination Purchase' || purchaseType === 'Corrugation Purchase') {
                        displayText = value.item_name + ' | ' + (value.size || '');
                        $select.append($('<option>', {
                            value: itemValue,
                            text: displayText,
                            'data-remain-qty': value.remain_qty || 0,
                            'data-size': value.size || ''
                        }));
                    } else {
                        $select.append($('<option>', {
                            value: itemValue,
                            text: displayText,
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
        else if (purchaseType === 'Lamination Purchase' || purchaseType === 'Corrugation Purchase') {
            $('#size').val(selectedOption.data('size') || '');
        }
    }
});
</script>
@endsection