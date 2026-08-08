@extends('layouts.app')

@section('content')

<style>

body{
    background:#f5f7fb;
    font-family:Inter,sans-serif;
}

/*==========================
    PAGE
==========================*/

.report-wrapper{

    background:#fff;
    border-radius:28px;
    padding:35px;
    box-shadow:0 10px 45px rgba(15,23,42,.06);

}

/*==========================
    HEADER
==========================*/

.report-header{

    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:40px;

}

.report-left{

    display:flex;
    align-items:center;
    gap:18px;

}

.report-icon{

    width:56px;
    height:56px;
    border-radius:18px;
    background:#edf3ff;
    display:flex;
    align-items:center;
    justify-content:center;

}

.report-icon i{

    color:#3563ff;
    font-size:26px;

}

.report-title h2{

    margin:0;
    font-size:44px;
    font-weight:700;
    color:#0f172a;

}

.report-title span{

    color:#8d97ae;
    font-size:20px;

}

/*==========================
RIGHT AREA
==========================*/

.report-actions{

    display:flex;
    gap:16px;
    align-items:center;

}

.date-box{

    height:52px;
    min-width:170px;

    border-radius:26px;

    background:#f3f5fb;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:16px;

    color:#475569;

    font-weight:600;

}

.date-box i{

    margin-right:10px;
    color:#64748b;

}

.search-box{

    width:280px;
    height:52px;

    border-radius:26px;

    background:#f3f5fb;

    display:flex;

    align-items:center;

    padding:0 18px;

}

.search-box i{

    color:#94a3b8;
    margin-right:12px;

}

.search-box input{

    border:none;

    background:transparent;

    width:100%;

    outline:none;

    color:#475569;

}

.export-btn{

    height:52px;

    padding:0 28px;

    border:none;

    border-radius:26px;

    background:#3563ff;

    color:#fff;

    font-weight:600;

    transition:.25s;

}

.export-btn:hover{

    background:#2954eb;

}

/*==========================
SUMMARY
==========================*/

.summary{

    display:flex;

    gap:60px;

    margin-bottom:30px;

}

.summary-item{

    display:flex;

    gap:10px;

    align-items:center;

}

.summary-item span{

    color:#64748b;

    font-size:18px;

}

.summary-item strong{

    font-size:16px;

    color:#0f172a;

}

/*==========================
SEARCH PANEL
==========================*/

.filter-panel{

    margin-top:30px;

    padding:22px;

    border:1px solid #edf2f7;

    border-radius:20px;

    background:#fff;

}

.filter-panel .form-label{

    font-weight:600;

    color:#64748b;

    font-size:12px;

    margin-bottom:8px;

}

.filter-panel .form-control{

    height:50px;

    border-radius:14px;

    border:1px solid #dbe4ee;

    box-shadow:none;

}

.filter-panel .form-control:focus{

    border-color:#3563ff;

    box-shadow:0 0 0 .15rem rgba(53,99,255,.15);

}

.search-btn{

    width:100%;

    height:50px;

    border:none;

    border-radius:14px;

    background:#3563ff;

    color:#fff;

    font-weight:600;

}

.search-btn:hover{

    background:#2853ec;

}

/* autocomplete */

.suggestion-box{

    border-radius:15px;

    overflow:hidden;

    background:#fff;

    border:1px solid #e5e7eb;

    box-shadow:0 10px 25px rgba(0,0,0,.08);

    z-index:9999;

}

.suggestion-box a{

    padding:12px 16px;

}

.suggestion-box a:hover{

    background:#edf3ff;

}
.modern-table{

    border-collapse:separate;
    border-spacing:0;
    overflow:hidden;
    border-radius:22px;
    background:#fff;

}

.modern-table thead th{

    background:#f7f8fc;
    color:#5b6785;
    font-size:13px;
    letter-spacing:.08em;
    font-weight:700;
    padding:18px 24px;
    border-top:1px solid #edf1f7;
    border-bottom:1px solid #edf1f7;

}

.modern-table tbody td{

    padding:18px 24px;
    border-bottom:1px solid #edf1f7;
    vertical-align:middle;

}

.modern-table tbody tr{

    transition:.25s;

}

.modern-table tbody tr:hover{

    background:#fafcff;

}

.item-title{

    font-size:18px;
    font-weight:700;
    color:#1f2937;

}

.badge-gsm{

    background:#eef3ff;
    color:#3563ff;
    border-radius:30px;
    padding:8px 16px;
    font-size:13px;
    font-weight:700;
    border:1px solid #dbe7ff;

}

.badge-desc{

    background:#f8fafc;
    color:#5b6785;
    border:1px solid #d9e1ec;
    border-radius:30px;
    padding:8px 16px;
    font-size:13px;
    font-weight:600;

}

.modern-table tfoot td{

    background:#fbfcfe;
    padding:18px 24px;
    border-top:2px solid #e5ebf5;
    font-size:15px;
}
.table-heading {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    white-space: nowrap;
}

.table-heading i {
    font-size: 15px;
    line-height: 1;
    flex-shrink: 0;
}
</style>

<div class="container-fluid">

<div class="report-wrapper">

<div class="report-header">

<div class="report-left">

<div class="report-icon">

<i class="mdi mdi-package-variant-closed"></i>

</div>

<div class="report-title">

<h2>Stock Report</h2>

<span>inventory summary</span>

</div>

</div>

<div class="report-actions">

<div class="date-box">

<i class="mdi mdi-calendar-month"></i>

{{ date('Y-m-d') }}

</div>

<div class="search-box">

<i class="mdi mdi-magnify"></i>

<input type="text"

placeholder="Search...">

</div>

<button

type="button"

class="export-btn"

onclick="printTable()">

<i class="mdi mdi-printer"></i>

&nbsp;

Export PDF

</button>

</div>

</div>

<div class="summary">

<div class="summary-item">

<span>Total items</span>

<strong>{{ count($boxboardData) }}</strong>

</div>

<div class="summary-item">

<span>Unique products</span>

<strong>{{ count($boxboardData) }}</strong>

</div>

<div class="summary-item">

<span>Total quantity</span>

<strong>{{ number_format($boxboardData->sum('remain_qty'),2) }}</strong>

</div>

</div>

<hr class="mb-4">

<div class="filter-panel">

<form

action="{{ route('report.boxboard_stock') }}"

method="GET"

id="search-form">

<div class="row">

<div class="col-xl-2">

<label class="form-label">

Start Date

</label>

<input

type="date"

class="form-control"

id="start_date"

name="start_date"

value="{{ request('start_date') }}">

</div>

<div class="col-xl-2">

<label class="form-label">

End Date

</label>

<input

type="date"

class="form-control"

id="end_date"

name="end_date"

value="{{ request('end_date') }}">

</div>

<div class="col-xl-3 position-relative">

<label class="form-label">

Item Name

</label>

<input

type="text"

class="form-control"

id="item_name"

value="{{ request('item_name') }}"

placeholder="Search Item">

<input

type="hidden"

id="item_id"

name="item_id"

value="{{ request('item_id') }}">

<div

id="item_suggestions"

class="suggestion-box list-group position-absolute w-100">

</div>

</div>
                        <div class="col-xl-2">

                            <label class="form-label">

                                GSM

                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="garmmage"
                                name="garmmage"
                                value="{{ request('garmmage') }}"
                                placeholder="GSM">

                        </div>

                        <div class="col-xl-2">

                            <label class="form-label">

                                Length

                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="length"
                                name="length"
                                value="{{ request('length') }}"
                                placeholder="Length">

                        </div>

                        <div class="col-xl-2">

                            <label class="form-label">

                                Width

                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="width"
                                name="width"
                                value="{{ request('width') }}"
                                placeholder="Width">

                        </div>

                        <div class="col-xl-1 d-flex align-items-end">

                            <button
                                type="submit"
                                class="search-btn">

                                <i class="mdi mdi-magnify"></i>

                            </button>

                        </div>

                    </div>

                </form>

            </div>

            @php

                $totalQty=$boxboardData->sum('remain_qty');

                $totalWeight=$boxboardData->sum('total_wt');

            @endphp

            <div class="mt-5">

                <div class="table-responsive">

                    <table
                        id="combined-data-table-boxboard"
                        class="table modern-table">

                      <thead>
    <tr>

        <th>
            <span class="table-heading">
                <i class="mdi mdi-tag-outline"></i>
                <span>ITEM NAME</span>
            </span>
        </th>

        <th>
            <span class="table-heading">
                <i class="mdi mdi-arrow-left-right"></i>
                <span>LENGTH</span>
            </span>
        </th>

        <th>
            <span class="table-heading">
                <i class="mdi mdi-arrow-expand-horizontal"></i>
                <span>WIDTH</span>
            </span>
        </th>

        <th>
            <span class="table-heading">
                <i class="mdi mdi-weight"></i>
                <span>GSM</span>
            </span>
        </th>

        <th>
            <span class="table-heading">
                <i class="mdi mdi-pound"></i>
                <span>QTY</span>
            </span>
        </th>

        <th>
            <span class="table-heading">
                <i class="mdi mdi-note-text-outline"></i>
                <span>DESCRIPTION</span>
            </span>
        </th>

    </tr>
</thead>

                        <tbody>

                        @foreach($boxboardData as $data)

                        <tr>

                            <td>

                                <div class="item-title">

                                    {{ $data->item_code }}

                                </div>

                            </td>

                            <td>

                                {{ $data->length }}

                            </td>

                            <td>

                                {{ $data->width }}

                            </td>

                            <td>

                                <span class="badge badge-gsm">

                                    {{ $data->grammage }}

                                </span>

                            </td>

                            <td>

                                <strong>

                                    {{ $data->remain_qty }}

                                </strong>

                            </td>

                            <td>

                                <span class="badge badge-desc">

                                    {{ $data->item_code }}

                                </span>

                            </td>

                        </tr>

                        @endforeach

                        </tbody>

                        <tfoot>

                        <tr>

                            <td colspan="4">

                                <strong>Total</strong>

                            </td>

                            <td>

                                <strong>

                                    {{ number_format($totalQty,2) }}

                                </strong>

                            </td>

                            <td>

                                <strong>

                                    {{ number_format($totalWeight,2) }}

                                </strong>

                            </td>

                        </tr>

                        </tfoot>

                    </table>

                </div>

            </div>

        </div>

    </div>
    <link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

setupAutocomplete(
    '#item_name',
    '#item_suggestions',
    "{{ url('/probox/search-items') }}"
);

const today = new Date();

if(!document.getElementById('end_date').value){

    document.getElementById('end_date').valueAsDate=today;

}

function printTable(){

    const table=document.getElementById(
        'combined-data-table-boxboard'
    ).outerHTML;

    const startDate=document.getElementById(
        'start_date'
    ).value;

    const endDate=document.getElementById(
        'end_date'
    ).value;

    const totalItems={{ count($boxboardData) }};

    const totalQty="{{ number_format($boxboardData->sum('remain_qty'),2) }}";

    const printWindow=window.open(
        '',
        '',
        'width=1400,height=900'
    );

    printWindow.document.write(`

<!DOCTYPE html>

<html>

<head>

<title>Stock Report</title>

<link rel="preconnect" href="https://fonts.googleapis.com">

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>

*{

margin:0;
padding:0;
box-sizing:border-box;
font-family:'Inter',sans-serif;

}

body{

background:#f5f7fb;
padding:40px;

}

.report{

background:#fff;
border-radius:26px;
padding:35px;
box-shadow:0 10px 35px rgba(0,0,0,.08);

}

.header{

display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:35px;

}

.left{

display:flex;
align-items:center;
gap:18px;

}

.icon{

width:55px;
height:55px;
background:#edf3ff;
border-radius:18px;
display:flex;
align-items:center;
justify-content:center;
font-size:13px;

}

.icon span{

color:#3563ff;

}

.title h2{

font-size:24px;
color:#0f172a;

}

.title small{

color:#94a3b8;
font-size:16px;

}

.summary{

display:flex;
gap:70px;
margin:30px 0;

}

.summary div{

font-size:15px;
color:#64748b;

}

.summary strong{

display:block;
font-size:28px;
color:#111827;
margin-top:5px;

}

table{

width:100%;
border-collapse:separate;
border-spacing:0;

}

thead th{

background:#f7f8fc;
padding:18px;
text-align:left;
font-size:13px;
color:#64748b;
border-top:1px solid #edf2f7;
border-bottom:1px solid #edf2f7;

}

tbody td{

padding:18px;
border-bottom:1px solid #edf2f7;
font-size:15px;

}

tbody tr:nth-child(even){

background:#fcfcfd;

}

tfoot td{

padding:18px;
font-weight:700;
background:#fafbff;

}

.badge{

display:inline-block;
padding:7px 16px;
border-radius:30px;
background:#eef3ff;
color:#3563ff;
font-weight:700;

}

.footer{

margin-top:30px;
display:flex;
justify-content:space-between;
font-size:14px;
color:#64748b;

}

</style>

</head>

<body>

<div class="report">

<div class="header">

<div class="left">

<div class="icon">

<span>📦</span>

</div>

<div class="title">

<h2>Stock Report</h2>

<small>Inventory Summary</small>

</div>

</div>

<div>

<strong>Period</strong><br>

${startDate} - ${endDate}

</div>

</div>

<div class="summary">

<div>

Total Items

<strong>${totalItems}</strong>

</div>

<div>

Total Quantity

<strong>${totalQty}</strong>

</div>

<div>

Printed

<strong>${new Date().toLocaleDateString()}</strong>

</div>

</div>

${table}

<div class="footer">

<div>

ERP Inventory Report

</div>

<div>

Generated by System

</div>

</div>

</div>

</body>

</html>

`);

    printWindow.document.close();

    setTimeout(function(){

        printWindow.print();

        printWindow.close();

    },500);

}

</script>

@endsection