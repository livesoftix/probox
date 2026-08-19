<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">General Delivery Challen</h4>
            </div>
        </div>
    </div>

  <?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible text-bg-success border-0 fade show" role="alert">
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>
    
<?php if(session('error')): ?>
    <div class="alert alert-danger alert-dismissible text-bg-danger border-0 fade show" role="alert">
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        <?php echo e(session('error')); ?>

    </div>
<?php endif; ?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form id="voucherForm" action="<?php echo e(route('general_delivery_challan.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="col-6">
                            <input type="hidden" id="invoice_type" name="v_type" value="GDC" readonly>

                            <!-- Date Field -->
                            <div class="mb-3">
                                <label for="entryDate" class="form-label">Date</label>
                                <input type="date" id="entryDate" class="form-control" name="date">
                            </div>
                            <div class="mb-3">
                                <label for="preparedBy" class="form-label">Prepared By</label>
                                <input type="text" id="preparedBy" class="form-control" name="prepared_by"
                                    value="<?php echo e($loggedInUser->name); ?>" readonly>
                            </div>

                             <!-- Delivery Challen -->
                             <div class="mb-3">
    <label for="gjs_no" class="form-label">GJS No</label>
    <select name="gjs_no" class="form-control select2" id="gjs_no" data-toggle="select2" required>
        <option value="">Select</option>
        <?php $__currentLoopData = $generals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $general): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $isSelected = in_array($general->v_no, $selectedGjsNos);
            ?>
            <option value="<?php echo e($general->v_no); ?>" <?php if($isSelected): ?> disabled <?php endif; ?>>
                <?php echo e($general->v_no); ?> <?php if($isSelected): ?> (Selected) <?php endif; ?>
            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>




                            <div class="mb-3">
                                <label for="party_name" class="form-label">Party Name</label>
                                <input type="name" id="party_name" class="form-control" name="party_name" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="product_type" class="form-label">Product Type</label>
                                <input type="name" id="product_type" class="form-control" name="product_type" readonly>
                            </div>
                            
                            
                            <div class="mb-3">
                                <label for="item_name" class="form-label">Item Name</label>
                                <input type="name" id="item_name" class="form-control" name="item_name" readonly>
                            </div>
                            
                            

                            <div class="mb-3">
                                <label for="qty" class="form-label">Qty</label>
                                <input type="name" id="qty" class="form-control" name="qty" readonly>
                            </div>
                            
                            <div class="mb-3">
                                <label for="rate" class="form-label">Rate</label>
                                <input type="name" id="rate" class="form-control" name="rate" readonly>
                            </div>


                            <div class="mb-3">
                                <label for="freight" class="form-label">Freight</label>
                                <input type="number" id="freight" class="form-control" name="freight" value="0"
                                    >
                            </div>
                             <div class="mb-3">
            <label for="driver_name" class="form-label">Driver Name</label>
            <input type="text" id="driver_name" class="form-control" name="driver_name">
            <input type="hidden" id="lockedDriverName" value="">

        </div>
    

 
        <div class="mb-3">
            <label for="vehicle_number" class="form-label">Vehicle Number</label>
            <input type="text" id="vehicle_number" class="form-control" name="vehicle_number">
            <input type="hidden" id="lockedVehicleNumber" value="">
        </div>

                            <button type="submit" class="btn btn-success">Submit Voucher</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Select2 CSS -->
<!--<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />-->

<!-- jQuery (Required for Select2) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('entryDate').valueAsDate = new Date();
});
$(document).ready(function() {
    $('#gjs_no').change(function() {
        var v_no = $(this).val();
        
        if (v_no) {
            $.ajax({
                url: '/probox/get-general-job-sheet-data',
                type: 'GET',
                data: { v_no: v_no },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#party_name').val(response.data.party_name); // Now shows name instead of ID
                        $('#item_name').val(response.data.item_name);
                        $('#product_type').val(response.data.product_type);
                        $('#qty').val(response.data.qty);
                        $('#rate').val(response.data.rate);
                    } else {
                        alert(response.message);
                        clearFields();
                    }
                },
                error: function(xhr) {
                    alert('Error fetching data. Please check console for details.');
                    console.error('Error:', xhr.responseText);
                    clearFields();
                }
            });
        } else {
            clearFields();
        }
    });
    
    function clearFields() {
        $('#party_name').val('');
        $('#item_name').val('');
        $('#product_type').val('');
        $('#qty').val('');
        $('#rate').val('');
    }
});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\probox\resources\views/general_delivery_challan/list.blade.php ENDPATH**/ ?>