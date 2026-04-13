@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                            <li class="breadcrumb-item active">Data Tables</li>
                        </ol>
                    </div>
                    <h4 class="page-title">General Delivery Challan</h4>
                </div>
            </div>
        </div>

        <!-- end page title -->

        <div class="row">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible text-bg-success border-0 fade show" role="alert">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                    <strong>Success - </strong> {{ session('success') }}
                </div>
            @endif

            <div class="row">

                <div class="card mt-2">
                    <div class="card-body">

                        <div class="tab-content">
                            <div class="col-6">
                                <form action="{{ route('general_delivery_challan.report') }}" method="GET"
                                    class="form-inline" id="search-form">
                                    <div class="row">
                                        <div class="form-group col-xl-4">
                                            <label for="start_date" class="sr-only">Start Date</label>
                                            <input type="date" class="form-control" id="start_date" name="start_date"
                                                value="{{ request()->get('start_date') }}">
                                        </div>
                                        <div class="form-group col-xl-4">
                                            <label for="end_date" class="sr-only">End Date</label>
                                            <input type="date" class="form-control" id="end_date" name="end_date"
                                                value="{{ request()->get('end_date') }}">
                                        </div>
                                        <div class="form-group col-xl-4">
                                            <label for="employee" class="sr-only">Status</label>
                                            <select name="employee" class="form-control select2">
                                                <option value="">All</option>
                                                <option value="official"
                                                    {{ request()->get('employee') == 'official' ? 'selected' : '' }}>
                                                    Official
                                                </option>
                                                <option value="unofficial"
                                                    {{ request()->get('employee') == 'unofficial' ? 'selected' : '' }}>
                                                    Unofficial
                                                </option>
                                            </select>
                                        </div>

                                        <div class="form-group col-xl-4 mt-2">
                                            <label for="v_no" class="form-label">JS No</label>
                                            <select name="v_no" class="form-control select2" data-toggle="select2"
                                                data-placeholder="Select JS No">
                                                <option value="">Select JS No</option>
                                                @foreach ($vNos as $vNo)
                                                    <option value="{{ $vNo }}"
                                                        {{ request()->get('v_no') == $vNo ? 'selected' : '' }}>
                                                        {{ $vNo }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-xl-4 mt-2">
                                            <label for="party_id" class="form-label">Party</label>
                                            <!-- Changed from account_id to party_id -->
                                            <select name="party_id" class="form-control select2" data-toggle="select2"
                                                data-placeholder="Select Customer">
                                                <option value="">Select Party</option>
                                                @foreach ($partyIds as $id => $title)
                                                    <option value="{{ $id }}"
                                                        {{ request()->get('party_id') == $id ? 'selected' : '' }}>
                                                        {{ $title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>



                                        <div class="form-group mt-3">
                                            <button type="submit" class="btn btn-primary">Search</button>
                                            <a class="btn btn-success" href="{{ route('general_delivery_challan.list') }}"
                                                role="button" onclick="return checkPermission()">Add New</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-12">


                <!-- Print Button -->
                <div class="card mt-2">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <button type="button" class="btn btn-secondary" onclick="printTable()"
                                style="min-width: 120px;">
                                Print Table
                            </button>
                            <div class="d-flex align-items-center">
                                <label for="printHeadingSelect" class="me-2 mb-0">Heading:</label>
                                <select id="printHeadingSelect" class="form-select select2" data-toggle="select2"
                                    style="width: 220px;">
                                    <option value="" selected disabled>-- Select Heading --</option>
                                    <option value="Haider Packages GRW">Haider Packages</option>
                                    <option value="ProBox Packages">ProBox Packages</option>
                                    <option value="ProBox Packages official">ProBox Packages official</option>
                                </select>
                            </div>
                        </div>

                        <div class="tab-content">
                            <div class="tab-pane show active" id="basic-datatable-preview">
                                <div style="overflow-x: auto;">

                                    <div class="table-responsive">
                                        <table id="combined-data-tables" class="table table-striped dt-responsive nowrap w-100 small-font-table">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>V No</th>
                                                    <th>Prepared By</th>
                                                    <th>Party Name</th>
                                                    <th>JS No</th>
                                                    <th>Product Type</th>
                                                    <th>Item Name</th>
                                                    <th>Qty</th>
                                                    <th>Rate</th>
                                                    <th>Freight</th>
                                                    <th class="no-print">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($generalDeliveryChallens as $general)
                                                    <tr>
                                                        <td>{{ \Carbon\Carbon::parse($general->updated_at)->format('Y-m-d') ?? 'N/A' }}
                                                        </td>
                                                        <td>{{ $general->v_type ?? 'N/A' }}-{{ $general->v_no ?? 'N/A' }}
                                                        </td>
                                                        <td>{{ $general->prepared_by ?? 'N/A' }}</td>
                                                        <td>{{ $general->party_name ?? 'N/A' }}</td>
                                                        <td>{{ $general->gjs_no ?? 'N/A' }}</td>
                                                        <td>{{ $general->product_type ?? 'N/A' }}</td>
                                                        <td>{{ $general->item_name ?? 'N/A' }}</td>
                                                        <td>{{ $general->qty ?? 'N/A' }}</td>
                                                        <td>{{ $general->rate ?? 'N/A' }}</td>
                                                        <td>{{ $general->freight ?? 'N/A' }}</td>

                                                        <td class="no-print">
                                                            <a href="{{ route('general_delivery_challan.edit', $general->id) }}"
                                                                class="btn btn-warning btn-sm"
                                                                onclick="return checkPermissionEdit()">Edit</a>

                                                            <form
                                                                action="{{ route('general_delivery_challan.destroy', $general->id) }}"
                                                                method="POST" style="display:inline-block;"
                                                                onclick="return checkPermissionDel()">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm"
                                                                    onclick="return confirm('Are you sure you want to delete this transaction?')">Delete</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        <table
                                            class="table table-striped dt-responsive nowrap w-100 print-table show-in-print"
                                            style="display: none;">
                                            <div class="show-in-prints" style="display: none;">
                                                <h2 style="text-align: center; font-weight: bold; margin-bottom: 5px;">
                                                    Delivery Challan</h2>
                                                <div
                                                    style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                                    <div style="text-align: left;">
                                                        <h3 style="margin: 0; font-weight: bold;">Category: General
                                                        </h3>
                                                        <h3 style="margin: 2px 0 0 0; font-weight: bold;">Name:
                                                            {{ $generalDeliveryChallens->unique('party_name')->pluck('party_name')->implode(', ') }}
                                                        </h3>
                                                    </div>
                                                    <div style="text-align: right;">
                                                        <h3 style="margin: 0; font-weight: bold;">Date:
                                                            {{ $generalDeliveryChallens->unique('updated_at')->pluck('updated_at')->map(function ($date) {
                                                                    return \Carbon\Carbon::parse($date)->format('d-m-Y');
                                                                })->implode(', ') }}
                                                        </h3>
                                                        <h3 style="margin: 2px 0 0 0; font-weight: bold;">V.No:
                                                            {{ $generalDeliveryChallens->unique('v_no')->pluck('v_no')->implode(', ') }}
                                                        </h3>
                                                    </div>
                                                </div>
                                            </div>
                                            <thead>
                                                <tr>
                                                    <th style="width: 5%;">Sr.No</th>
                                                    <th colspan="2" style="width: 40%;">Item Name</th>
                                                    <th colspan="2" style="width: 20%;">Product Type</th>
                                                    <th colspan="2" style="width: 10%;">Qty</th>
                                                    <th colspan="2" style="width: 10%;">Rate</th>
                                                    <th colspan="2" style="width: 10%;">Freight</th>
                                                    <th colspan="2" style="width: 5%;">JS No</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($generalDeliveryChallens as $general)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td colspan="2">
                                                            {{ $general->item_name ?? 'N/A' }}
                                                        </td>
                                                        <td colspan="2">
                                                            {{ $general->product_type ?? 'N/A' }}</td>
                                                        <td colspan="2">{{ $general->qty ?? 'N/A' }}
                                                        </td>
                                                        <td colspan="2">
                                                            {{ $general->rate ?? 'N/A' }}</td>
                                                        <td colspan="2">
                                                            {{ $general->freight ?? 'N/A' }}</td>
                                                        <td colspan="2">
                                                            {{ $general->gjs_no ?? 'N/A' }}</td>
                                                    </tr>
                                                @endforeach
                                                {{-- <tr>
                                                    <td colspan="11" style="text-align: right;"><strong>Total
                                                            Qty:</strong></td>
                                                    <td colspan="1">
                                                        {{ $generalDeliveryChallens->sum('qty') }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="11" style="text-align: right;"><strong>Total
                                                            Freight:</strong></td>
                                                    <td colspan="1">
                                                        {{ $generalDeliveryChallens->sum('freight') }}
                                                    </td>
                                                </tr> --}}
                                                <tr>
                                                    <td colspan="12" style="height: 26px; border: none;"></td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                            </tfoot>
                                        </table>
                                    </div>




                                </div>
                            </div> <!-- end preview-->
                        </div> <!-- end tab-content-->
                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div> <!-- end row-->
    </div>
    <!-- Print Function -->
    <script>
        function checkPermission() {
            @php
                $isAdmin = auth()->user()->is_admin;
                $canAdd = true;

                if ($isAdmin == 0) {
                    $userRights = \App\Models\Right::where('user_id', auth()->user()->id)
                        ->where('app_name', 'generaldelivery')
                        ->first();
                    $canAdd = $userRights && $userRights->add == 1;
                }
            @endphp

            if (!@json($canAdd)) {
                alert('You do not have Permission to Add');
                return false; // Prevent the default action (navigation)
            }
            return true; // Allow navigation
        }


        function checkPermissionEdit() {
            @php
                $isAdmin = auth()->user()->is_admin;
                $canAdd = true;

                if ($isAdmin == 0) {
                    $userRights = \App\Models\Right::where('user_id', auth()->user()->id)
                        ->where('app_name', 'generaldelivery')
                        ->first();
                    $canAdd = $userRights && $userRights->edit == 1;
                }
            @endphp

            if (!@json($canAdd)) {
                alert('You do not have Permission to Edit');
                return false; // Prevent the default action (navigation)
            }
            return true; // Allow navigation
        }

        function checkPermissionDel() {

            @php
                $isAdmin = auth()->user()->is_admin;
                $canAdd = true;

                if ($isAdmin == 0) {
                    $userRights = \App\Models\Right::where('user_id', auth()->user()->id)
                        ->where('app_name', 'generaldelivery')
                        ->first();
                    $canAdd = $userRights && $userRights->del == 1;
                }
            @endphp
            if (!@json($canAdd)) {
                alert('You do not have Permission to Delete');
                return false; // Prevent the default action (navigation)
            }
            return true; // Allow navigation
        }


        const today = new Date().toISOString().split('T')[0];

        // Set the value of the input field to the current date
        document.getElementById('end_date').value = today;

       function printTable() {

                const headingSelect = document.getElementById('printHeadingSelect');
                const selectedHeading = headingSelect ? headingSelect.value : '';
                if (!selectedHeading) {
                    alert('Please select a print heading before printing.');
                    headingSelect.focus();
                    return;
                }

                const table = document.querySelector('.show-in-print');
                const tables = document.querySelector('.show-in-prints');
                table.style.display = 'block';
                tables.style.display = 'block';

                // Get the heading and table content you want to print
                const headingContent = document.querySelector('h4').outerHTML;
                const headingContents = document.querySelector('h3').outerHTML;
                const tableContent = table.outerHTML;
                const tableContents = tables.outerHTML;

                let styledHeader = '';
                if (selectedHeading === 'Haider Packages GRW') {
                    styledHeader = `
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-top: 2px; margin-bottom: 2px;">
            <!-- Header Section -->
            <div style="background: #333; color: white; padding: 6px 20px; display: inline-block; -webkit-print-color-adjust: exact; print-color-adjust: exact;">
                <h1 style="margin: 0; font-size: 24px; font-weight: bold; color: white !important; -webkit-print-color-adjust: exact; print-color-adjust: exact;">HAIDER PACKAGES</h1>
                <p style="margin: 4px 0 0 0; font-size: 11px; color: white !important; -webkit-print-color-adjust: exact; print-color-adjust: exact;">A COMPLETE UNIT OF PRINTING & PACKAGING</p>
            </div>
            
            <!-- Contact Info Section -->
            
        </div>
        `;
                } else if (selectedHeading === 'ProBox Packages' || selectedHeading === 'ProBox Packages official') {
                    const logoUrl = "{{ asset('assets/images/proboxlogo.jpg') }}";
                    styledHeader = `
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-top: 2px; margin-bottom: 2px;">
            <!-- Header Section -->
            <div style="display: inline-block;">
                <img src="${logoUrl}" alt="ProBox Logo"
                     style="max-width: 120px; height: auto; display: block;"
                     onerror="this.style.display='none'">
            </div>
            
            
        </div>
        `;
                }

                // Open a new window for printing
                const printWindow = window.open('', '_blank');
                printWindow.document.write(`
<html>
    <head>
        <title>Print Table</title>
        <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
        <style>
            @page {
                
                margin: 3mm 5mm 3mm 5mm;
            }
            body {
                font-family: Arial, sans-serif;
                font-size: 10px;
                padding: 4px 0 0 0;
                margin: 0;
                padding-bottom: 4px;
            }
            .content-wrapper {
                padding-bottom: 8px;
                margin-bottom: 12px; 
            }
            .details-section {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin: 8px 0;
                padding: 3px 0;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 6px;
                margin-bottom: 6px !important;
                page-break-inside: auto;
                font-size: 8px;
            }
            .page {
                page-break-after: always;
            }
            .page:last-child {
                page-break-after: auto;
            }
            thead {
                display: table-header-group;
            }
            tbody {
                display: table-row-group;
            }
            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
            th, td {
                border: 1px solid #ddd;
                padding: 5px;
                page-break-inside: avoid;
                font-size: 9px;
                text-align: center;
            }
            tbody tr {
                height: 26px;
            }
            th {
                background-color: #ffffffff;
                
                font-size: 9px;
                font-weight: bold;
            }
            * {
                color: #000 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            td, th, p, span, div, h1, h2, h3, h4, h5, h6 {
                color: #000 !important;
            }
            .footer {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                background: #ffffffff;
                padding: 2px 12px 2px 12px;
                border-top: 1px solid #000;
                font-size: 11px;
                text-align: center;
                height: 25px;
                z-index: 1000;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            tfoot {
                display: table-footer-group;
            }
            @media print {
                body { 
                    margin: 0;
                    padding: 0;
                    padding-top: 10px;
                }
                .content-wrapper {
                    padding-bottom: 33px !important; 
                }
                table {
                    page-break-after: auto;
                }
                .page { page-break-after: always; }
                thead {
                    display: table-header-group;
                }
                tbody {
                    display: table-row-group;
                }
                tr {
                    page-break-inside: avoid;
                    page-break-after: auto;
                }
                td, th {
                    page-break-inside: avoid;
                }
                .footer {
                    position: fixed;
                    font-weight: bold;
                    bottom: 0;
                    left: 0;
                    right: 0;
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                }
                tfoot {
                    display: table-footer-group;
                }
                * { 
                    -webkit-print-color-adjust: exact !important; 
                    print-color-adjust: exact !important; 
                }
            }
            * { 
                -webkit-print-color-adjust: exact; 
                print-color-adjust: exact; 
            }
        </style>
    </head>
    <body>
        <div class="content-wrapper">
            ${styledHeader}
            ${tableContents}
            ${tableContent}
        </div>
        <div class="footer">
            <div>
                <i class="uil uil-map-marker" style="margin-right: 4px;"></i>
                Address: 126-B Small Industrial Estate 3 (EPZ), Gujranwala. 
                &nbsp;&nbsp;
            </div>
        </div>
    </body>
</html>
`);
            printWindow.document.close();
            printWindow.focus();
            printWindow.onload = () => {
                setTimeout(() => {
                    printWindow.print();
                    printWindow.close();
                }, 500);
            };

            table.style.display = 'none';
            tables.style.display = 'none';
        }

        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endsection
