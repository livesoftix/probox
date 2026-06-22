

<?php $__env->startSection('content'); ?>

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

            <form action="<?php echo e(route('tempjob.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <div class="row">

                    
                    <div class="col-md-4 mb-3">
                        <label>Date</label>
                        <input type="date" name="date" class="form-control">
                    </div>

                    
                    <div class="col-md-4 mb-3">
                        <label>Prepared By</label>
                        <input type="text" class="form-control"
                               value="<?php echo e(auth()->user()->name); ?>" readonly>
                    </div>

                    
                    <div class="col-md-4 mb-3">
                        <label>Job No</label>
                        <input type="text" name="job_no" class="form-control"
                               value="<?php echo e($jobNo ?? ''); ?>">
                    </div>

                    
                    <div class="col-md-12 mb-3">
                        <label>Job Name</label>
                        <input type="text" name="job_name" class="form-control">
                    </div>

                    
                    <div class="col-md-6 mb-3">
                        <label>Size</label>
                        <input type="text" name="size" class="form-control">
                    </div>

                    
                    <div class="col-md-6 mb-3">
                        <label>Qty</label>
                        <input type="number" name="qty" class="form-control">
                    </div>

                    
                    <div class="col-md-6 mb-3">
                        <label>P.Size</label>
                        <input type="text" name="p_size" class="form-control">
                    </div>

                    
                    <div class="col-md-6 mb-3">
                        <label>No Of Ream / Pkt</label>
                        <input type="text" name="ream_pkt" class="form-control">
                    </div>

                    
                    <div class="col-12">
                        <hr>
                        <h5>Boxboard Details</h5>
                    </div>

                    <div class="col-12">
                        <div id="boxboard-wrapper">

                            
                            <!-- <div class="row item-row mb-3">

                                <div class="col-md-5">
                                    <label>Item</label>
                                    <select class="form-control item-selection" name="box_item[]">
                                        <option value="">Select Item</option>
                                        <?php $__currentLoopData = $boxboardData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($item->item_id); ?>_<?php echo e($item->width); ?>_<?php echo e($item->length); ?>"
                                                data-stock="<?php echo e($item->remain_qty); ?>">
                                                <?php echo e($item->item_code); ?> (L:<?php echo e($item->length); ?> x W:<?php echo e($item->width); ?>)
                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

    
    <div class="col-md-4">
        <label>Item</label>
        <select class="form-control item-selection" name="box_item[]">
            <option value="">Select Item</option>
            <?php $__currentLoopData = $boxboardData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($item->item_id); ?>_<?php echo e($item->width); ?>_<?php echo e($item->length); ?>"
                data-stock="<?php echo e($item->remain_qty); ?>">
                <?php echo e($item->item_code); ?> (L:<?php echo e($item->length); ?> x W:<?php echo e($item->width); ?>)
                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>

    
    <div class="col-md-2">
        <label>Length</label>
        <input type="text" class="form-control box-length" name="box_length[]" readonly>
    </div>

    
    <div class="col-md-2">
        <label>Width</label>
        <input type="text" class="form-control box-width" name="box_width[]" readonly>
    </div>

    
    <div class="col-md-2">
        <label>Stock</label>
        <input type="number" class="form-control box-total-stock" readonly>
    </div>

    
    <div class="col-md-2">
        <label>Qty</label>
        <input type="number" class="form-control box-stock" name="box_qty[]">
    </div>

    
    <div class="col-md-2 d-flex align-items-end gap-2 mt-2">
        <button type="button" class="btn btn-success add-row">+</button>
        <button type="button" class="btn btn-danger remove-row">×</button>
    </div>

</div>

                        </div>
                    </div>

                    
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

    // ITEM CHANGE
    $(document).on('change', '.item-selection', function(){

        let row = $(this).closest('.item-row');

        let parts = $(this).val() ? $(this).val().split('_') : [];

        let stock = parseFloat($(this).find(':selected').data('stock')) || 0;

        row.find('.box-total-stock').val(stock);

        if(parts.length){
            row.find('input[name="box_item_id[]"]').val(parts[0]);
            row.find('input[name="box_length[]"]').val(parts[2]);
            row.find('input[name="box_width[]"]').val(parts[1]);
        }
    });

    // QTY CHANGE
    $(document).on('input', '.box-stock', function(){

        let row = $(this).closest('.item-row');

        let total = parseFloat(row.find('.box-total-stock').val()) || 0;
        let qty = parseFloat($(this).val()) || 0;

        if(qty > total){
            alert('Stock exceed!');
            $(this).val('');
            qty = 0;
        }

        row.find('.box-total-stock').val(total - qty);
    });

});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\probox\resources\views/temp_job_sheet/list.blade.php ENDPATH**/ ?>