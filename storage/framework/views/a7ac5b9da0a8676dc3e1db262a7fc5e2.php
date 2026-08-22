<?php $__env->startSection('content'); ?>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />

<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Breaking Department</h4>
            </div>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible text-bg-success border-0 fade show">
            <button type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="alert"></button>

            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible text-bg-danger border-0 fade show">
            <button type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="alert"></button>

            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger">

            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>

        </div>
    <?php endif; ?>


    <div class="row">
        <div class="col-12">

            <div class="card">

                <div class="card-body">

                    <form id="voucherForm"
                          action="<?php echo e(route('breaking_wage_dc.store')); ?>"
                          method="POST">

                        <?php echo csrf_field(); ?>

                        <div class="row">

                            
                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Date
                                </label>

                                <input type="date"
                                       id="entryDate"
                                       name="date"
                                       class="form-control">

                            </div>


                            
                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Prepared By
                                </label>

                                <input type="text"
                                       name="prepared_by"
                                       class="form-control"
                                       value="<?php echo e($loggedInUser->name); ?>"
                                       readonly>

                            </div>


                            
                            <div class="col-md-6 mb-3">

                              <label class="form-label">
    Product
</label>

<select id="product_id"
        class="form-control select2">

    <option value="">
        Select Product
    </option>

    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<option
    value="<?php echo e($product['id']); ?>"
    data-batch="<?php echo e($product['batch_no']); ?>"
    data-type="<?php echo e($product['type']); ?>"
>
    <?php echo e($product['name']); ?> (<?php echo e($product['batch_no']); ?>)
</option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</select>
                            </div>


                            <div class="col-md-6 mb-3 d-flex align-items-end">

                                <button type="button"
                                        id="loadEntry"
                                        class="btn btn-primary me-2">

                                    Load DC

                                </button>

                                <button type="submit"
                                        class="btn btn-success">

                                    Submit Voucher

                                </button>

                            </div>

                        </div>


                        

                        <div class="row mt-4">

                            <div class="col-lg-12">

                                <div class="table-responsive">

                                    <table class="table table-bordered"
                                           id="entriesTable">

                                        <thead>

                                            <tr>

                                                <th>DC No</th>

                                                <th>Date</th>

                                                <th>Account</th>

                                                <th>Product Name</th>
                                                <th>Batch No</th>

                                                <th>Qty</th>

                                                <th>Type</th>
                                                <th>rate</th>
                                                <th>Amount</th>

                                                <th>Action</th>

                                            </tr>

                                        </thead>


                                        <tbody id="entriesBody">

                                        </tbody>


                                        <tfoot>

                                            <tr>

                                                <th colspan="5"
                                                    class="text-end">

                                                    Total Qty:

                                                </th>

                                                <th id="grandTotalQty">
                                                    0.00
                                                </th>

                                                <th colspan="2" class="text-end">Total Amount:</th>
                                                <input type="hidden" id="originalGrandTotal" value="0">
                                                <th id="grandTotalAmt">
                                                    0.00
                                                </th>
                                                <th></th>

                                            </tr>

                                        </tfoot>

                                    </table>

                                </div>
                                  <hr>

<h5>Employee Loan Deduction</h5>

<div class="table-responsive">
    <table class="table table-bordered" id="employeeTable">
        <thead>
            <tr>
                <th width="20%">Employee</th>
                <th width="15%">Previous Loan</th>
                <th width="15%">Deduction</th>
                <th width="15%">Other Expense</th>
                <th width="20%">Description</th>
                <th width="15%">Remaining</th>
                <th width="10%">
                    <button type="button" class="btn btn-success btn-sm" id="addEmployeeRow">
                        +
                    </button>
                </th>
            </tr>
        </thead>

        <tbody>

        </tbody>
    </table>
</div>
                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>
    </div>

</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>


<script>

document.getElementById("entryDate").value =
    new Date().toISOString().split('T')[0];


$(document).ready(function () {

    $('.select2').select2({
        placeholder: 'Select Product',
        allowClear: true,
        width: '100%'
    });


    function updateGrandTotal() {

        let totalQty = 0;
        let totalAmt = 0;

        $('#entriesBody tr').each(function () {

            const qty = parseFloat(
                $(this).find('.qty-value').val()
            ) || 0;
            // console.log(qty);
            const amt = parseFloat(
                $(this).find('.amt-value').val()
            ) || 0;
            // console.log(amt);

            totalQty += qty;
            totalAmt += amt;

        });

        $('#grandTotalQty').text(
            totalQty.toFixed(2)
        );
        $('#grandTotalAmt').text(
            totalAmt.toFixed(2)
        );
        $('#originalGrandTotal').val(totalAmt.toFixed(2));

    }


   $('#loadEntry').click(function () {

    const product = $('#product_id option:selected');

const productId = product.val();
const batchNo  = product.data('batch');
const type     = product.data('type');

   if (!productId  || !type) {

    alert('Please select Product');

    return;
}
    const url = "<?php echo e(route('breaking_wage_dc.product')); ?>"
            + '?product_id=' + productId
            + '&batch_no=' + encodeURIComponent(batchNo)
            + '&type=' + type;
    $('#entriesBody').append(`
        <tr class="loading-row">
            <td colspan="10" class="text-center">
                Loading...
            </td>
        </tr>
    `);

    $.ajax({

        url: url,

        type: 'GET',

        success: function (data) {

            $('.loading-row').remove();

            if (data.length === 0) {

                alert('No pending Delivery Challans found');

                return;

            }

            let html = '';

            data.forEach(function (item) {

                const uniqueKey = item.type + '-' + item.v_no + '-' + item.batch_no + '-' + item.prod_id;

                if ($(`#entriesBody tr[data-key="${uniqueKey}"]`).length) {
                    return;
                }

                html += `

<tr data-key="${uniqueKey}">

<td>
<input type="hidden" name="v_no[]" value="${item.v_no}">
${item.v_no}
</td>

<td>
<input type="hidden" name="dc_date[]" value="${item.date}">
${item.date}
</td>

<td>
<input type="hidden" name="account_id[]" value="${item.account_id}">
${item.account_name}
</td>

<td>
<input type="hidden" name="product_name[]" value="${item.product_name}">
${item.product_name}
</td>

<td>
<input type="hidden" name="batch_no[]" value="${item.batch_no}">
${item.batch_no}
</td>

<td>
<input type="hidden"
class="qty-value"
name="qty[]"
value="${item.qty}">
${item.qty}

<input type="hidden"
name="prod_id[]"
value="${item.prod_id}">

<input type="hidden"
name="clabour[]"
value="${item.clabour}">
</td>

<td>
<input type="hidden"
name="dc_type[]"
value="${item.type}">
${item.type}
</td>

<td>

<input type="hidden"
name="rate[]"
value="${item.clabour}">

${item.clabour}

</td>

<td>

<input type="hidden"
class="amt-value"
name="amt[]"
value="${item.qty*item.clabour}">

${item.qty*item.clabour}

</td>

<td>

<button
type="button"
class="btn btn-danger btn-sm remove-row">

Remove

</button>

</td>

</tr>

`;

            });

            $('#entriesBody').append(html);

            updateGrandTotal();
            $('#product_id option:selected').remove();

$('#product_id')
    .val(null)
    .trigger('change');

        },

        error: function () {

            $('.loading-row').remove();

            alert('Error loading product.');

        }

    });

});

$(document).on('click','.remove-row',function(){

    let key=$(this).closest('tr').data('key');

    $('#entriesBody tr[data-key="'+key+'"]').remove();

    updateGrandTotal();

});

let employees = <?php echo json_encode($employees, 15, 512) ?>;
function employeeRow() {

return `
<tr>

<td>

<select name="employee_id[]" class="form-control employee-select select2">

<option value="">Select Employee</option>

${employees.map(emp=>`
<option value="${emp.id}">
${emp.fname} ${emp.lname}
</option>`).join('')}

</select>

</td>

<td>
<input type="text"
name="previous_loan[]"
class="form-control previous-loan"
readonly>
</td>

<td>
<input type="number"
name="deduction[]"
class="form-control deduction"
value="0">
</td>
<td>
<input type="number"
name="otherExp[]"
class="form-control otherExp"
value="0">
</td>
<td>
<input type="text"
name="description[]"
class="form-control description"
>
</td>
<td>
<input type="text"
name="remaining[]"
class="form-control remaining"
readonly>
</td>


<td>

<button type="button" class="btn btn-danger removeEmployeeRow">
Remove
</button>

</td>

</tr>
`;
}

$('#addEmployeeRow').click(function(){

$('#employeeTable tbody').append(employeeRow());

$('.select2').select2({
width:'100%'
});

});
$(document).on('change','.employee-select',function(){

let row=$(this).closest('tr');

let employee=$(this).val();

$.get('/probox/employee/'+employee+'/closing-balance',function(res){

row.find('.previous-loan').val(res.balance);

row.find('.remaining').val(res.balance);

});

});
$(document).on('keyup change', '.deduction, .otherExp', function () {

    let row = $(this).closest('tr');

    let previous = parseFloat(row.find('.previous-loan').val()) || 0;
    let deduction = parseFloat(row.find('.deduction').val()) || 0;

    let remaining = previous - deduction;
    row.find('.remaining').val(remaining.toFixed(2));
    recalculateGrandTotal();

});
function recalculateGrandTotal() {

    let original = parseFloat($('#originalGrandTotal').val()) || 0;

    let totalDeduction = 0;
    let totalOtherExp = 0;

    $('#employeeTable tbody tr').each(function () {

        totalDeduction += parseFloat($(this).find('.deduction').val()) || 0;
        totalOtherExp += parseFloat($(this).find('.otherExp').val()) || 0;

    });

    let finalTotal = original - totalDeduction + totalOtherExp;

    $('#grandTotalAmt').text(finalTotal.toFixed(2));
}
$(document).on('click','.removeEmployeeRow',function(){

$(this).closest('tr').remove();
    recalculateGrandTotal();


});
});

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\probox\resources\views/wages/breaking/list.blade.php ENDPATH**/ ?>