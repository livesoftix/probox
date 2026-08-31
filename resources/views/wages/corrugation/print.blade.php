<!DOCTYPE html>
<html>

<head>

<meta charset="utf-8">

<title>Corrugation Wage Voucher</title>

<style>

body{
    font-family:Arial,Helvetica,sans-serif;
    font-size:13px;
    margin:20px;
    color:#000;
}

.header{
    text-align:center;
    margin-bottom:15px;
}

.header h2{
    margin:0;
}

.header h4{
    margin:5px 0;
}

.info{
    width:100%;
    border-collapse:collapse;
    margin-bottom:20px;
}

.info td{
    border:1px solid #000;
    padding:8px;
}

table{
    width:100%;
    border-collapse:collapse;
    margin-top:10px;
}

table th,
table td{
    border:1px solid #000;
    padding:6px;
}

th{
    background:#efefef;
}

.text-right{
    text-align:right;
}

.section-title{
    margin-top:25px;
    margin-bottom:5px;
    font-size:16px;
    font-weight:bold;
}

.footer{
    margin-top:60px;
    width:100%;
}

.footer td{
    border:none;
    text-align:center;
}

</style>

</head>

<body onload="window.print()">

<div class="header">

<h2>PRINTING CELL</h2>

<h4>Corrugation Wage Voucher</h4>

</div>


<table class="info">

<tr>

<td width="20%"><b>Voucher No</b></td>
<td>{{ $voucher->b_no }}</td>

<td width="20%"><b>Date</b></td>
<td>{{ date('d-m-Y',strtotime($voucher->date)) }}</td>

</tr>

<tr>

<td><b>Prepared By</b></td>
<td>{{ $voucher->prepared_by }}</td>

<td><b>Total Amount</b></td>
<td>{{ number_format($voucher->total_amount,2) }}</td>

</tr>

</table>


<div class="section-title">

Product Detail

</div>

<table>

<thead>

<tr>
<th>Sr No.</th>
<th width="15%">DC No</th>
<th>Product</th>
<th width="12%">Qty</th>
<th width="12%">Rate</th>
<th width="15%">Amount</th>

</tr>

</thead>

<tbody>

@php

$totalQty=0;
$totalAmount=0;
$i=0;

@endphp

@foreach($products as $row)

@php
$i++;
$totalQty += $row->qty;
$totalAmount += $row->amount;

@endphp

<tr>
<td>{{ $i }}</td>
<td>{{ $row->dc_no }}</td>

<td>{{ $row->product_name }}</td>

<td class="text-right">

{{ number_format($row->qty,2) }}

</td>

<td class="text-right">

{{ number_format($row->rate,3) }}

</td>

<td class="text-right">

{{ number_format($row->amount,2) }}

</td>

</tr>

@endforeach

</tbody>

<tfoot>

<tr>

<th colspan="3">Grand Total</th>

<th class="text-right">

{{ number_format($totalQty,2) }}

</th>

<th></th>

<th class="text-right">

{{ number_format($totalAmount,2) }}

</th>

</tr>

</tfoot>

</table>


<div class="section-title">

Employee Loan Deduction

</div>

<table>

<thead>

<tr>

<th>Employee</th>

<th width="18%">Previous Loan</th>

<th width="18%">Deduction</th>
<th width="18%">Other Expense</th>
<th width="18%">Description</th>

<th width="18%">Remaining Loan</th>

</tr>

</thead>

<tbody>

@forelse($employees as $emp)

<tr>

<td>

{{ optional($emp->employee)->fname }}
{{ optional($emp->employee)->lname }}

</td>

<td class="text-right">

{{ number_format($emp->previous_loan,2) }}

</td>

<td class="text-right">

{{ number_format($emp->deduction,2) }}


</td>
<td class="text-right">

{{ number_format($emp->other_exp,2) }}


</td>

<td class="text-right">

{{ $emp->description }}


</td>


<td class="text-right">

{{ number_format($emp->remaining_loan,2) }}

</td>

</tr>

@empty

<tr>

<td colspan="4" style="text-align:center">

No Employee Deduction

</td>

</tr>

@endforelse
   </tbody>

</table>
<div class="section-title">
    Foreman Detail
</div>

<table>

    <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th >Credit Amount</th>
            <th >Clsoing Balance</th>
        </tr>
    </thead>

    <tbody>

        @if($contractor)

        <tr>
            <td>{{ $contractor->accounts->title }}</td>
            <td>{{ $contractor->description }}</td>

            <td class="text-right">
                {{ number_format($contractor->credit,2) }}
            </td>
            <td class="text-right">{{ number_format($contractorClosingBalance, 2) }}</td>
        </tr>

        @else

        <tr>
            <td colspan="4" style="text-align:center">
                No Foreman Entry Found
            </td>
        </tr>

        @endif

 

</tbody>

</table>


<table class="footer">

<tr>

<td>

_________________________

<br>

Prepared By

</td>

<td>

_________________________

<br>

Checked By

</td>

<td>

_________________________

<br>

Approved By

</td>

</tr>

</table>

</body>

</html>