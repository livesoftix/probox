@extends('layouts.app')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />

<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Manual Pasting Department</h4>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible text-bg-success border-0 fade show">
            <button type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="alert"></button>

            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible text-bg-danger border-0 fade show">
            <button type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="alert"></button>

            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">

            <ul class="mb-0">
                @foreach ($errors->all() as $error)
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
                          action="{{ route('manualPasting_wage_dc.store') }}"
                          method="POST">

                        @csrf

                        <div class="row">

                            {{-- Date --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Date
                                </label>

                                <input type="date"
                                       id="entryDate"
                                       name="date"
                                       class="form-control">

                            </div>


                            {{-- Prepared By --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Prepared By
                                </label>

                                <input type="text"
                                       name="prepared_by"
                                       class="form-control"
                                       value="{{ $loggedInUser->name }}"
                                       readonly>

                            </div>


                            {{-- Delivery Challan --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Delivery Challan
                                </label>

                                <select id="delivery_challan"
                                        class="form-control select2">

                                    <option value="">
                                        Select Delivery Challan
                                    </option>

                                    @foreach ($deliverychallans as $dc)

                                        <option value="{{ $dc['v_no'] }}"
                                                data-type="{{ $dc['type'] }}">

                                           {{ $dc['v_no'] }} - {{ $dc['party'] }} ({{ ucfirst($dc['type']) }})
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

                                    Submit Voucher

                                </button>

                            </div>

                        </div>


                        {{-- Entries Table --}}

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
                <th width="30%">Employee</th>
                <th width="20%">Previous Loan</th>
                <th width="20%">Deduction</th>
                <th width="15%">Other Expense</th>
                <th width="20%">Description</th>
                <th width="20%">Remaining</th>
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
        placeholder: 'Select Delivery Challan',
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

            const amt = parseFloat(
                $(this).find('.amt-value').val()
            ) || 0;

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

        const dropdown = $('#delivery_challan');

        const vNo = dropdown.val();

        const type = dropdown
            .find(':selected')
            .data('type');
        const selectedOption = dropdown.find(':selected');
        const optionText = selectedOption.text();


        if (!vNo || !type) {

            alert('Please select Delivery Challan');

            return;

        }


        const uniqueKey = type + '-' + vNo;


        if (
            $(`#entriesBody tr[data-key="${uniqueKey}"]`).length > 0
        ) {

            alert(
                `Delivery Challan ${vNo} is already loaded`
            );

            return;

        }


        const url = "{{ route('manualPasting_wage_dc.vouchers', [
            'type' => 'TYPE',
            'v_no' => 'V_NO'
        ]) }}"
        .replace('TYPE', type)
        .replace('V_NO', encodeURIComponent(vNo));


        $('#entriesBody').append(`

            <tr data-key="${uniqueKey}"
                class="loading-row">

                <td colspan="7"
                    class="text-center">

                    Loading DC ${vNo}...

                </td>

            </tr>

        `);


        $.ajax({

            url: url,

            type: 'GET',

            success: function (data) {

                $(
                    `#entriesBody tr[data-key="${uniqueKey}"]`
                ).remove();


                if (data.length === 0) {

                    alert('No DC details found');

                    return;

                }


                let html = '';


                data.forEach(function (item) {

                    html += `

                        <tr data-key="${uniqueKey}">

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

                                ${item.product_name}

                            </td>


 <td>

                                <input type="hidden"
                                       name="batch_no[]"
                                       value="${item.batch_no}">

                                ${item.batch_no}

                            </td>



                            <td>

                                <input type="hidden"
                                       name="qty[]"
                                       class="qty-value"
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
                                       name="amt[]"
                                       class="amt-value"
                                       value="${item.qty*item.clabour}">

                                ${item.qty*item.clabour}

                            </td>


                            <td>

                                <button type="button"
                                        class="btn btn-sm btn-danger remove-row">

                                    Remove

                                </button>

                            </td>

                        </tr>

                    `;

                });


                $('#entriesBody').append(html);
selectedOption.remove();
dropdown.val(null).trigger('change');

                updateGrandTotal();
            },


            error: function (xhr) {

                $(
                    `#entriesBody tr[data-key="${uniqueKey}"]`
                ).remove();

                console.log(xhr.responseText);

                alert('Error loading Delivery Challan');

            }

        });

    });


 $(document).on('click', '.remove-row', function () {

    let row = $(this).closest('tr');

    let key = row.data('key');              // pharma-123
    let vNo = row.find('input[name="v_no[]"]').val();
    let type = row.find('input[name="dc_type[]"]').val();

    // Agar isi DC ki aur rows bhi hain to sab remove karo
    $('#entriesBody tr[data-key="' + key + '"]').remove();

    // Dropdown me option wapas add karo
    if ($('#delivery_challan option[value="' + vNo + '"]').length === 0) {

        let text = vNo + ' (' + type + ')';

        $('#delivery_challan').append(
            $('<option>', {
                value: vNo,
                text: text,
                'data-type': type
            })
        );
    }

    updateGrandTotal();
});
let employees = @json($employees);
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

$.get('/printingcell/employee/'+employee+'/closing-balance',function(res){

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

    let finalTotal = original - totalDeduction - totalOtherExp;

    $('#grandTotalAmt').text(finalTotal.toFixed(2));
}
$(document).on('click','.removeEmployeeRow',function(){

$(this).closest('tr').remove();
recalculateGrandTotal();

});


});


</script>

@endsection