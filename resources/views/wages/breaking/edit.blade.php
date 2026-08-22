@extends('layouts.app')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />

<div class="container-fluid">

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">
                Edit Breaking Department Voucher
            </h4>
        </div>
    </div>
</div>


@if(session('success'))
<div class="alert alert-success alert-dismissible text-bg-success border-0 fade show">

<button type="button"
        class="btn-close btn-close-white"
        data-bs-dismiss="alert"></button>

{{ session('success') }}

</div>
@endif


@if(session('error'))
<div class="alert alert-danger alert-dismissible text-bg-danger border-0 fade show">

<button type="button"
        class="btn-close btn-close-white"
        data-bs-dismiss="alert"></button>

{{ session('error') }}

</div>
@endif


@if($errors->any())

<div class="alert alert-danger">

<ul class="mb-0">

@foreach($errors->all() as $error)

<li>{{ $error }}</li>

@endforeach

</ul>

</div>

@endif



<div class="row">

<div class="col-12">

<div class="card">

<div class="card-body">


<form id="voucherForm"
      action="{{ route('breaking_wage_dc.update',$voucher->b_no) }}"
      method="POST">

@csrf

@method('PUT')



<div class="row">


{{-- Date --}}
<div class="col-md-6 mb-3">

<label class="form-label">
Date
</label>


<input type="date"
       id="entryDate"
       name="date"
       class="form-control"
       value="{{ old('date',$voucher->date) }}">


</div>




{{-- Prepared By --}}
<div class="col-md-6 mb-3">


<label class="form-label">
Prepared By
</label>


<input type="text"
       name="prepared_by"
       class="form-control"
       value="{{ old('prepared_by',$voucher->prepared_by) }}"
       readonly>


</div>
            {{-- Delivery Challan --}}
                            <div class="col-md-6 mb-3">

                              <label class="form-label">
    Product
</label>

<select id="product_id"
        class="form-control select2">

    <option value="">
        Select Product
    </option>

    @foreach ($products as $product)
<option
    value="{{ $product['id'] }}"
    data-batch="{{ $product['batch_no'] }}"
    data-type="{{ $product['type'] }}"
>
    {{ $product['name'] }} ({{ $product['batch_no'] }})
</option>
    @endforeach

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

Update Voucher

</button>


</div>


</div>

{{-- DC Entries Table --}}

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

<th>Rate</th>

<th>Amount</th>

<th>Action</th>

</tr>

</thead>



<tbody id="entriesBody">


@php
$totalQty = 0;
$totalAmount = 0;
@endphp

@foreach($entries as $entry)


@php

$amount = $entry->qty * $entry->clabour;

$totalQty += $entry->qty;

$totalAmount += $amount;


@endphp

@if($entry->prod_id == null)
    @continue
@endif

<tr
    data-key="{{ strtolower(trim($entry->dc_type)) }}-{{ trim($entry->v_no) }}-{{ $entry->prod_id }}"
    data-vno="{{ $entry->v_no }}"
    data-type="{{ strtolower(trim($entry->dc_type)) }}"
    data-prodid="{{ $entry->prod_id }}">



<td>


<input type="hidden"
       name="v_no[]"
       value="{{ $entry->v_no }}">


{{ $entry->v_no }}


</td>





<td>


<input type="hidden"
       name="dc_date[]"
       value="{{ $entry->dc_date }}">


{{ $entry->dc_date }}


</td>






<td>


<input type="hidden"
       name="account_id[]"
       value="{{ $entry->account_id }}">


{{ optional($entry->account)->title ?? $entry->account_id }}


</td>






<td>


<input type="hidden"
       name="product_name[]"
       value="{{ $entry->product_name }}">


<input type="hidden"
       name="prod_id[]"
       value="{{ $entry->prod_id }}">


{{ $entry->product_name }}



</td>
<td>


<input type="hidden"
       name="batch_no[]"
       value="{{ $entry->batch_no }}">

{{ $entry->batch_no }}

</td>





<td>


<input type="hidden"
       name="qty[]"
       class="qty-value"
       value="{{ $entry->qty }}">


{{ number_format($entry->qty,2) }}


</td>







<td>


<input type="hidden"
       name="dc_type[]"
       value="{{ $entry->dc_type }}">


{{ ucfirst($entry->dc_type) }}


</td>








<td>


<input type="hidden"
       name="clabour[]"
       value="{{ $entry->clabour }}">


{{ number_format($entry->clabour,2) }}


</td>








<td>


<input type="hidden"
       name="amt[]"
       class="amt-value"
       value="{{ $amount }}">


{{ number_format($amount,2) }}


</td>







<td>


<button type="button"
        class="btn btn-danger btn-sm remove-row">


Remove

</button>


</td>



</tr>

@endforeach



</tbody>





<tfoot>


<tr>


<th colspan="5"
    class="text-end">

Total Qty:

</th>



<th id="grandTotalQty">

{{ number_format($totalQty,2) }}

</th>




<th colspan="2"
    class="text-end">

Total Amount:

</th>



<input type="hidden"
       id="originalGrandTotal"
       value="{{ $totalAmount }}">



<th id="grandTotalAmt">

{{ number_format($totalAmount,2) }}

</th>



<th></th>


</tr>


</tfoot>



</table>


</div>


</div>


</div>
<hr>

<h5>
    Employee Loan Deduction
</h5>


<div class="table-responsive">


<table class="table table-bordered"
       id="employeeTable">


<thead>

<tr>

<th width="20%">
Employee
</th>

<th width="15%">
Previous Loan
</th>

<th width="15%">
Deduction
</th>

<th width="15%">
Other Expense
</th>

<th width="20%">
Description
</th>

<th width="15%">
Remaining
</th>

<th width="10%">

<button type="button"
        class="btn btn-success btn-sm"
        id="addEmployeeRow">

+

</button>

</th>

</tr>

</thead>



<tbody>



@foreach($employeeRows as $row)


<tr>



<td>


<select name="employee_id[]"
        class="form-control employee-select select2">


<option value="">
Select Employee
</option>



@foreach($employees as $employee)


<option value="{{ $employee->id }}"
@if($employee->id == $row->employee_id)
selected
@endif
>

{{ $employee->fname }}
{{ $employee->lname }}

</option>


@endforeach


</select>


</td>





<td>


<input type="text"
       name="previous_loan[]"
       class="form-control previous-loan"
       value="{{ $row->previous_loan }}"
       readonly>


</td>






<td>


<input type="number"
       step="0.01"
       name="deduction[]"
       class="form-control deduction"
       value="{{ $row->deduction ?? 0 }}">


</td>







<td>


<input type="number"
       step="0.01"
       name="otherExp[]"
       class="form-control otherExp"
       value="{{ $row->other_exp ?? 0 }}">


</td>






<td>


<input type="text"
       name="description[]"
       class="form-control description"
       value="{{ $row->description }}">


</td>







<td>


<input type="text"
       name="remaining[]"
       class="form-control remaining"
       value="{{ $row->remaining_loan }}"
       readonly>


</td>







<td>


<button type="button"
        class="btn btn-danger removeEmployeeRow">

Remove

</button>


</td>



</tr>


@endforeach



</tbody>


</table>


</div>



</div>

</div>

</div>

</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>


<script>


$(document).ready(function(){



$('.select2').select2({

    width:'100%'

});
function refreshProductDropdown() {

    $('#product_id option').show();

    $('#entriesBody tr').each(function () {

        let prodId = $(this).find('input[name="prod_id[]"]').val();
        let batch  = $(this).find('input[name="batch_no[]"]').val();

        $('#product_id option').each(function () {

            if (
                $(this).val() == prodId &&
                $(this).data('batch') == batch
            ) {

                $(this).hide();

            }

        });

    });

}

refreshProductDropdown();

$('#delivery_challan').trigger('change');
function updateGrandTotal(){


let qty = 0;

let amount = 0;



$('#entriesBody tr').each(function(){


qty += parseFloat(
    $(this).find('.qty-value').val()
) || 0;



amount += parseFloat(
    $(this).find('.amt-value').val()
) || 0;



});



$('#grandTotalQty').text(
    qty.toFixed(2)
);



$('#grandTotalAmt').text(
    amount.toFixed(2)
);



$('#originalGrandTotal').val(
    amount.toFixed(2)
);



recalculateGrandTotal();


}







$('#loadEntry').click(function () {
console.log("jnn");
       const product = $('#product_id option:selected');

const productId = product.val();
const batchNo  = product.data('batch');
const type     = product.data('type');

    // let vNo = dropdown.val();

    // let type = dropdown.find(':selected').data('type');

   if (!productId  || !type) {

    alert('Please select Product');

    return;
}


     const url = "{{ route('breaking_wage_dc.product') }}"
            + '?product_id=' + productId
            + '&batch_no=' + encodeURIComponent(batchNo)
            + '&type=' + type;

    $.get(url,function(data){

        if(data.length==0){

            alert('No remaining products found.');

            return;

        }

        let html='';

        data.forEach(function(item){

            let uniqueKey =
                item.type.toLowerCase().trim()
                + '-'
                + item.v_no
                + '-'
                + item.prod_id
                + '-'
                + item.batch_no;

            if($('#entriesBody tr[data-key="'+uniqueKey+'"]').length){

                return;

            }

            let amount =
                parseFloat(item.qty) *
                parseFloat(item.clabour);

            html += `

<tr
data-key="${uniqueKey}"
data-vno="${item.v_no}"
data-type="${item.type.toLowerCase().trim()}"
data-prodid="${item.prod_id}">

<td>

<input type="hidden"
name="v_no[]"
value="${item.v_no}">

${item.v_no}

</td>

<td>

<input type="hidden"
name="dc_date[]"
value="${item.date}">

${item.date}

</td>

<td>

<input type="hidden"
name="account_id[]"
value="${item.account_id}">

${item.account_name}

</td>

<td>

<input type="hidden"
name="product_name[]"
value="${item.product_name}">

<input type="hidden"
name="prod_id[]"
value="${item.prod_id}">

${item.product_name}

</td>

<td>

<input type="hidden"
name="batch_no[]"
value="${item.batch_no}">

${item.batch_no}

</td>

<td>

<input
type="hidden"
name="qty[]"
class="qty-value"
value="${item.qty}">

${item.qty}

</td>

<td>

<input
type="hidden"
name="dc_type[]"
value="${item.type}">

${item.type}

</td>

<td>

<input
type="hidden"
name="clabour[]"
value="${item.clabour}">

${item.clabour}

</td>

<td>

<input
type="hidden"
name="amt[]"
class="amt-value"
value="${amount}">

${amount.toFixed(2)}

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

    //    $('#product_id').val(null).trigger('change');

        updateGrandTotal();
$('#product_id option:selected').remove();

$('#product_id')
    .val(null)
    .trigger('change');


    });

});
$(document).on('click','.remove-row',function(){

$(this).closest('tr').remove();

refreshProductDropdown();

updateGrandTotal();

});
let employees = @json($employees);
function employeeRow(){
return `


<tr>


<td>


<select name="employee_id[]"
class="form-control employee-select select2">


<option value="">

Select Employee

</option>


${employees.map(emp=>`


<option value="${emp.id}">

${emp.fname} ${emp.lname}

</option>


`).join('')}


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
class="form-control">

</td>




<td>

<input type="text"
name="remaining[]"
class="form-control remaining"
readonly>

</td>



<td>

<button type="button"
class="btn btn-danger removeEmployeeRow">

Remove

</button>

</td>



</tr>


`;

}




$('#addEmployeeRow').click(function(){



$('#employeeTable tbody')
.append(employeeRow());



$('.select2').select2({

width:'100%'

});


});


$(document).on(
'change',
'.employee-select',
function(){


let row=$(this).closest('tr');


let employee=$(this).val();



if(!employee){

row.find('.previous-loan').val('');

row.find('.remaining').val('');

return;

}




$.get(
'/probox/employee/'+employee+'/closing-balance',
function(res){


row.find('.previous-loan')
.val(res.balance);



row.find('.remaining')
.val(res.balance);



});


});







$(document).on(
'keyup change',
'.deduction,.otherExp',
function(){


let row=$(this).closest('tr');



let previous =
parseFloat(
row.find('.previous-loan').val()
) || 0;



let deduction =
parseFloat(
row.find('.deduction').val()
) || 0;



let remaining =
previous - deduction;



row.find('.remaining')
.val(
remaining.toFixed(2)
);



recalculateGrandTotal();



});







function recalculateGrandTotal(){



let original =
parseFloat(
$('#originalGrandTotal').val()
) || 0;




let deduction = 0;

let other = 0;





$('#employeeTable tbody tr').each(function(){



deduction += parseFloat(
$(this).find('.deduction').val()
) || 0;




other += parseFloat(
$(this).find('.otherExp').val()
) || 0;




});





let finalAmount =
original - deduction + other;




$('#grandTotalAmt')
.text(
finalAmount.toFixed(2)
);



}







$(document).on(
'click',
'.removeEmployeeRow',
function(){


$(this)
.closest('tr')
.remove();



recalculateGrandTotal();



});






// initial calculation on edit load

updateGrandTotal();

recalculateGrandTotal();



});

</script>


@endsection