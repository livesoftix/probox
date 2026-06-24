@extends('layouts.app')

@section('content')

<style>
.a4-sheet{
    width:280mm;
    min-height:297mm;
    margin:auto;
    background:#fff;
    padding:12mm;
    box-shadow:0 0 10px rgba(0,0,0,.15);
}

@media print{
    .a4-sheet{
        width:210mm;
        min-height:297mm;
        box-shadow:none;
        padding:10mm;
    }
}
</style>

<div class="container-fluid">

    <div class="card">
        <div class="card-body">

            <div class="a4-sheet">

            <form action="{{ route('tempjob.store') }}" method="POST">
                @csrf

                <div class="row">

                    {{-- DATE --}}
                    <div class="col-md-4 mb-3">
                        <label>Date</label>
                        <input type="date" name="date" class="form-control">
                    </div>

                    {{-- PREPARED BY --}}
                    <div class="col-md-4 mb-3">
                        <label>Prepared By</label>
                        <input type="text" class="form-control" name="preparedby"
                               >
                    </div>

                    {{-- JOB NO --}}
                    <div class="col-md-4 mb-3">
                        <label>Job No</label>
                        <input type="text" name="job_no" class="form-control"
                               value="{{ $jobNo ?? '' }}">
                    </div>

                    {{-- JOB NAME --}}
                   <div class="col-md-12 mb-3">
    <label>Job Name</label>
    <select name="job_id" id="job_id" class="form-control select2">
        <option value="">Select Job</option>
        @foreach($products as $product)
            <option value="{{ $product->id }}">
                {{ $product->prod_name }}
            </option>
        @endforeach
    </select>
</div>
                   <div class="col-md-6 mb-3">
    <label>Printing For</label>
    <select name="printing_for" id="printing_for" class="form-control">
        <option value="">Select</option>
        
            <option value="Proofing">
                Proofing
            </option>
         <option value="Job Production">
                Job Production
            </option>
       
    </select>
</div>

                    {{-- SIZE --}}
                    <div class="col-md-6 mb-3">
                        <label>Size</label>
                        <input type="text" name="size"  class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Ups</label>
                        <input type="number" name="ups" id="ups" class="form-control">
                    </div>

                    {{-- QTY --}}
                    <div class="col-md-6 mb-3">
                        <label>Qty Of Boxes</label>
                        <input type="number" name="qty" id="qty_boxes" class="form-control">
                    </div>

                    {{-- P.SIZE --}}
                    <div class="col-md-6 mb-3">
                        <label>P.Size</label>
                        <input type="text" name="p_size" id="p_size" class="form-control">
                    </div>

                    {{-- REAM / PKT --}}
                    <div class="col-md-6 mb-3" style="display:none">
                        <label>No Of Used Rims/ Pkt</label>
                        <input type="text" name="ream_pkt" class="form-control">
                    </div>

                    {{-- BOXBOARD --}}
                    <div class="col-12">
                        <hr>
                        <h5>Boxboard Details</h5>
                    </div>

                    <div class="col-12">
                        <div id="boxboard-wrapper">

                            {{-- ROW TEMPLATE --}}
                            <!-- <div class="row item-row mb-3">

                                <div class="col-md-5">
                                    <label>Item</label>
                                    <select class="form-control item-selection" name="box_item[]">
                                        <option value="">Select Item</option>
                                        @foreach($boxboardData as $item)
                                            <option value="{{ $item->item_id }}_{{ $item->width }}_{{ $item->length }}"
                                                data-stock="{{ $item->remain_qty }}">
                                                {{ $item->item_code }} (L:{{ $item->length }} x W:{{ $item->width }})
                                            </option>
                                        @endforeach
                                    </select>

                                    <input type="hidden" name="box_item_id[]">
                                    <input type="hidden" name="box_length[]">
                                    <input type="hidden" name="box_width[]">
                                </div>

                                <div class="col-md-2">
                                    <label>Stock</label>
                                    <input type="number" class="form-control box-total-stock" readonly>
                                </div>

                                <div class="col-md-2">
                                    <label>Qty</label>
                                    <input type="number" class="form-control box-stock" name="box_qty[]">
                                </div>

                                <div class="col-md-3 d-flex align-items-end gap-2">
                                    <button type="button" class="btn btn-success add-row">+</button>
                                    <button type="button" class="btn btn-danger remove-row">×</button>
                                </div>

                            </div> -->

                            <div class="row item-row mb-3">

    {{-- ITEM --}}
    <div class="col-md-5">
        <label>Item</label>
        <select class="form-control item-selection" name="box_item[]">
            <option value="">Select Item</option>
            @foreach($boxboardData as $item)
             <option
    value="{{ $item->v_no }}_{{ $item->item_id }}_{{ $item->width }}_{{ $item->length }}"
    data-stock="{{ $item->remain_qty }}"
    data-itemid="{{ $item->item_id }}">
    {{ $item->item_code }}
    (L:{{ $item->length }} x W:{{ $item->width }})
</option>
            @endforeach
        </select>
        <input type="hidden" name="purchase_vno[]" class="purchase-vno">
    </div>

    {{-- LENGTH (VISIBLE) --}}
    <div class="col-md-3">
        <label>Length</label>
        <input type="text" class="form-control box-length" name="box_length[]" readonly>
    </div>

    {{-- WIDTH (VISIBLE) --}}
    <div class="col-md-3">
        <label>Width</label>
        <input type="text" class="form-control box-width" name="box_width[]" readonly>
    </div>

    {{-- STOCK --}}
    <div class="col-md-3">
        <label>T.Stock</label>
        <input type="number" class="form-control total-stock" readonly>
    </div>
    

    {{-- QTY --}}
    <div class="col-md-3">
        <label>No Of Used Rims / Pkt</label>
        <input type="number" class="form-control box-stock" name="box_qty[]">
    </div>
    <div class="col-md-3">
        <label>Remainig Stock</label>
        <input type="number" class="form-control box-total-stock" readonly>
    </div>

    {{-- ACTION --}}
    <div class="col-md-2 d-flex align-items-end gap-2 mt-2">
        <button type="button" class="btn btn-success add-row">+</button>
        <button type="button" class="btn btn-danger remove-row">×</button>
    </div>

</div>

                        </div>
                    </div>

                    {{-- PROCESS --}}
                    <div class="col-12"><hr><h5>Process Details</h5></div>

                    <div class="col-md-2 mb-3">
                        <label>Lami</label>
                        <input type="text" name="lami" class="form-control">
                    </div>

                    <div class="col-md-2 mb-3">
                        <label>Emb</label>
                        <input type="text" name="emb" class="form-control">
                    </div>

                    <div class="col-md-2 mb-3">
                        <label>Var</label>
                        <input type="text" name="varnish" class="form-control">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Colour</label>
                        <input type="text" name="colour" class="form-control">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>UV</label>
                        <input type="text" name="uv" class="form-control">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Note</label>
                        <textarea name="note" rows="3" class="form-control"></textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>M.Date</label>
                        <input type="date" name="m_date" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>E.Date</label>
                        <input type="date" name="e_date" class="form-control">
                    </div>

                    <div class="col-12">
                        <button class="btn btn-success">Save Job Sheet</button>
                    </div>

                </div>

            </form>

            </div>

        </div>
    </div>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
 $(document).ready(function () {
    $('#job_id').select2({
        placeholder: 'Select Job',
        allowClear: true,
        width: '100%'
    });
});
$(document).ready(function(){
    function initSelect2(scope){
        scope.find('.item-selection').select2();
    }

    initSelect2($(document));

    let today = new Date().toISOString().split('T')[0];
    $('[name="date"]').val(today);

    // ADD ROW
    $(document).on('click', '.add-row', function(){

        let newRow = $('.item-row:first').clone();

        newRow.find('select').val('');
        newRow.find('.total-stock').val('');
        newRow.find('.box-total-stock').val('');
        newRow.find('.box-stock').val('');

        newRow.find('.select2-container').remove();

        $('#boxboard-wrapper').append(newRow);

        initSelect2(newRow);
    });

    // REMOVE ROW
    $(document).on('click', '.remove-row', function(){
        if($('.item-row').length > 1){
            $(this).closest('.item-row').remove();
        }
    });
    function calculateBoxes(){

    console.log("sxn");
    let ups = parseFloat($('#ups').val()) || 0;

    let firstRowQty =
        parseFloat($('.item-row:first .box-stock').val()) || 0;
    let sheets=(firstRowQty*100);

    $('#qty_boxes').val(ups * sheets);
}

    // ITEM CHANGE
    $(document).on('change', '.item-selection', function(){

        let row = $(this).closest('.item-row');

        let parts = $(this).val() ? $(this).val().split('_') : [];

        let stock = parseFloat($(this).find(':selected').data('stock')) || 0;

        row.find('.total-stock').val(stock);
        row.find('.box-total-stock').val(stock);

        if(parts.length){
            // row.find('input[name="box_item_id[]"]').val(parts[0]);
            // row.find('input[name="box_length[]"]').val(parts[2]);
            // row.find('input[name="box_width[]"]').val(parts[1]);
            row.find('.purchase-vno').val(parts[0]);
row.find('input[name="box_item_id[]"]').val(parts[1]);
row.find('input[name="box_width[]"]').val(parts[2]);
row.find('input[name="box_length[]"]').val(parts[3]);
        }
    });

    // QTY CHANGE
    $(document).on('input', '.box-stock', function(){
        // console.log("jxn");

        let row = $(this).closest('.item-row');

        let total = parseFloat(row.find('.total-stock').val()) || 0;
        let qty = parseFloat($(this).val()) || 0;

        if(qty > total){
            alert('Stock exceed!');
            $(this).val('');
            qty = 0;
        }
        row.find('.box-total-stock').val(total - qty);
        // ONLY FIRST ROW
    if(row.is($('.item-row:first'))){
        calculateBoxes();
    }
        
    });
    $('#job_id').on('change', function () {

    let productId = $(this).val();

    if(productId){

        $.ajax({
            url: '/probox/product-details/' + productId,
            type: 'GET',
            success: function(res){

                let length = parseFloat(res.length) || 0;
                let width  = parseFloat(res.width) || 0;
                let ups  = parseFloat(res.ups) || 0;
                let itemId  = parseFloat(res.item_id) || 0;

                let size = length + " x " + width;
                

                $('#p_size').val(size);
                $('#ups').val(ups);
                 let firstRow = $('.item-row:first');
                 console.log(res);

    firstRow.find('.item-selection option').each(function(){

        if($(this).data('itemid') == res.item_id){

            firstRow.find('.item-selection')
                .val($(this).val())
                .trigger('change');

            return false;
        }
    });

    
            }
        });

    } else {
        $('#p_size').val('');
    }

});
$(document).on('input', '#ups', function(){
    calculateBoxes();
});



});
</script>

@endsection