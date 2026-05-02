@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Softix</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Reports</a></li>
                            <li class="breadcrumb-item active">Confectionery</li>
                        </ol>
                    </div>
                    <h3 class="page-title no-print">Confectionery</h3>
                </div>
            </div>
        </div>
        <!-- end page title -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible text-bg-success border-0 fade show" role="alert">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                    aria-label="Close"></button>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible text-bg-danger border-0 fade show" role="alert">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                    aria-label="Close"></button>
                {{ session('error') }}
            </div>
        @endif
        <!-- Search Form -->
        <div class="row">
            <div class="card mt-2">
                <div class="card-body">
                    <div class="tab-content">
                        <div class="col-12">
                            <form action="{{ route('confectionery.reports') }}" method="GET" class="form-inline"
                                id="search-form">
                                <div class="row">
                                    <!-- Start Date -->
                                    <div class="form-group col-xl-2">
                                        <label for="start_date" class="sr-only">Start Date</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date"
                                            value="{{ request()->get('start_date') }}">
                                    </div>

                                    <!-- End Date -->
                                    <div class="form-group col-xl-2">
                                        <label for="end_date" class="sr-only">End Date</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date"
                                            value="{{ request()->get('end_date') }}">
                                    </div>

                                    <div class="form-group col-xl-2">
                                        <label for="account_title" class="sr-only">Status</label>
                                        <select name="status" class="form-control select2">
                                            <option value="">All</option>

                                            <option value="official" {{ $status == 'official' ? 'selected' : '' }}>Official
                                            </option>
                                            <option value="unofficial" {{ $status == 'unofficial' ? 'selected' : '' }}>
                                                Unofficial</option>

                                        </select>

                                    </div>

                                    <div class="form-group col-xl-2">
                                        <label for="v_no" class="sr-only">Voucher Number</label>
                                        <select name="v_no" class="form-control select2" data-toggle="select2">
                                            <option value="">Select Voucher</option>
                                            @foreach ($vNoList as $vNo)
                                                <option value="{{ $vNo }}"
                                                    {{ request()->get('v_no') == $vNo ? 'selected' : '' }}>
                                                    {{ $vNo }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- P.O -->


                                    <div class="form-group col-xl-2">
                                        <label for="po_no" class="sr-only">PO No</label>
                                        <select name="po_no" class="form-control select2" data-toggle="select2"
                                            id="po_no">
                                            <option value="">Select PO No</option>
                                            @foreach ($poNumbers as $poNumber)
                                                <option value="{{ $poNumber }}"
                                                    {{ request()->get('batch_no') == $poNumber ? 'selected' : '' }}>
                                                    {{ $poNumber }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- Item Title -->
                                    <!-- Item Title -->
                                    <div class="form-group col-xl-2">
                                        <label for="itemTitle" class="sr-only">Item Type</label>
                                        <select name="item" class="form-control select2" data-toggle="select2"
                                            id="itemTitle">
                                            <option value="">Select Item</option>
                                            @foreach ($items as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ request()->get('item') == $item->id ? 'selected' : '' }}>
                                                    {{ $item->type_title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-xl-2 mt-2">
                                        <label for="accountTitle" class="sr-only">Account Title</label>
                                        <select name="account" class="form-control select2" data-toggle="select2"
                                            id="accountTitle">
                                            <option value="">Select Account</option>
                                            @foreach ($accounts as $account)
                                                <option value="{{ $account->id }}"
                                                    {{ request()->get('account') == $account->id ? 'selected' : '' }}>
                                                    {{ $account->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <!-- Submit Button -->
                                    <div class="form-group mt-2">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                        <a class="btn btn-success" href="{{ route('confectionery.list') }}" role="button"
                                            onclick="return checkPermission()">Add New</a>
                                    </div>
                                </div>
                            </form>


                        </div>
                    </div>
                </div>
            </div>

            <!-- Combined Data Table -->
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <button type="button" class="btn btn-secondary" onclick="printTable()"
                                style="min-width: 120px;">
                                Print Table
                            </button>
                            <button type="button" class="btn btn-success" onclick="downloadTableJpg()">
    Download JPG
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
                        <div class="card mt-2">
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="col-12">
                                        <!--<h4>Transaction and Purchase Details</h4>-->
                                        <table id="combined-data-tables"
                                            class="table table-striped dt-responsive nowrap w-100">
                                            <h4 class="no-print"></h4>
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>V.No</th>
                                                    <th>Account Title</th>

                                                    <th>Product Name</th>
                                                    <th>PO No</th>
                                                    <th>CTN</th>
                                                    <th>Pack Qty</th>

                                                    <th>Total</th>
                                                    <th>Freight</th>
                                                    <th class="no-print">Status</th>
                                                    <th class="no-print">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($trndtl as $data)
                                                    <tr>
                                                        <td>{{ \Carbon\Carbon::parse($data->date)->format('d-m-Y') }}</td>
                                                        <td>{{ $data->v_type }}-{{ $data->v_no }}</td>
                                                        <td>{{ $data->accounts->title ?? 'N/A' }}</td>

                                                        <td>{{ $data->ConfectioneryDetails->products->prod_name ?? 'N/A' }}
                                                        </td>

                                                        <td>{{ $data->confectioneryDetails->po_no ?? 'N/A' }}</td>
                                                        <td>{{ $data->confectioneryDetails->box ?? 'N/A' }}</td>
                                                        <td>{{ $data->confectioneryDetails->pack_qty ?? 'N/A' }}</td>

                                                        <td>{{ $data->confectioneryDetails->total ?? 'N/A' }}</td>
                                                        <td>{{ $data->confectioneryDetails->freight ?? 'N/A' }}</td>
                                                        <td class="no-print" style="display:none;">
                                                            {{ $data->confectioneryDetails->itemType->type_title ?? 'N/A' }}
                                                        </td>
                                                        <td class="no-print">
                                                            <input type="checkbox" class="status-checkbox"
                                                                data-id="{{ $data->id }}"
                                                                {{ $data->status == 'official' ? 'checked' : '' }}>
                                                        </td>
                                                        <td class="no-print">
                                                            <div
                                                                class="d-flex justify-content-start align-items-center gap-1">
                                                                <!-- Delete -->
                                                                <form
                                                                    action="{{ route('confectionery.delete', ['id' => $data->id]) }}"
                                                                    method="POST" onsubmit="return checkPermissionDel()"
                                                                    class="m-0">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                                        onclick="return confirmDelete(this)"
                                                                        title="Delete">
                                                                        <i class="uil uil-trash-alt"></i>
                                                                    </button>
                                                                </form>

                                                                <!-- Edit -->
                                                                <a href="{{ route('confectionery.edit', ['v_no' => $data->v_no]) }}"
                                                                    class="btn btn-warning btn-sm"
                                                                    onclick="return checkPermissionEdit()" title="Edit">
                                                                    <i class="uil uil-edit"></i>
                                                                </a>

                                                                <!-- Freight -->
                                                                <a href="{{ route('confectionery.editCon', ['v_no' => $data->v_no]) }}"
                                                                    class="btn btn-primary btn-sm" title="Freight">
                                                                    <i class="uil uil-truck"></i>
                                                                </a>
                                                            </div>
                                                        </td>


                                                    </tr>
                                                @endforeach
                                            </tbody>

                                        </table>

                                        <table
                                            class="table table-striped dt-responsive nowrap w-100 print-table show-in-print"
                                            style="display: none;">
                                            <div class="show-in-prints" style="display: none;">
                                                <!-- OPTIMIZED MARGINS HERE: Reduced bottom margin to 5px -->
                                                <h2 style="text-align: center; font-weight: bold; margin-bottom: 5px;">
                                                    Delivery Challan</h2>
                                                <div
                                                    style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                                    <div style="text-align: left;">
                                                        <h3 style="margin: 0; font-weight: bold;">Category: Confectionery
                                                        </h3>
                                                        <!-- OPTIMIZED MARGINS HERE: Reduced top margin to 2px -->
                                                        <h3 style="margin: 2px 0 0 0; font-weight: bold;">Name:
                                                            {{ $trndtl->unique('accounts.title')->pluck('accounts.title')->implode(', ') }}
                                                        </h3>
                                                    </div>
                                                    <div style="text-align: right;">
                                                        <h3 style="margin: 0; font-weight: bold;">Date:
                                                            {{ $trndtl->unique('date')->pluck('date')->map(function ($date) {
                                                                    return \Carbon\Carbon::parse($date)->format('d-m-Y');
                                                                })->implode(', ') }}
                                                        </h3>
                                                        <!-- OPTIMIZED MARGINS HERE: Reduced top margin to 2px -->
                                                        <h3 style="margin: 2px 0 0 0; font-weight: bold;">V.No:
                                                            {{ $trndtl->unique('v_no')->pluck('v_no')->implode(', ') }}
                                                        </h3>
                                                    </div>
                                                </div>
                                            </div>
                                            <thead>
                                                <tr>
                                                    <th>Sr.No</th>
                                                    <th colspan="2" style="width: 40%;">Product Name</th>
                                                    <th colspan="2" style="width: 10%;">PO No</th>
                                                    <th colspan="2" style="width: 10%;">CTN</th>
                                                    <th colspan="2" style="width: 10%;">Pack Qty</th>
                                                    <th colspan="2" style="width: 10%;">Freight</th>
                                                    <th colspan="2"style="width: 20%;">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($trndtl as $data)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td colspan="2">
                                                            {{ $data->ConfectioneryDetails->products->prod_name ?? 'N/A' }}
                                                        </td>
                                                        <td colspan="2">
                                                            {{ $data->confectioneryDetails->po_no ?? 'N/A' }}</td>
                                                        <td colspan="2">{{ $data->confectioneryDetails->box ?? 'N/A' }}
                                                        </td>
                                                        <td colspan="2">
                                                            {{ $data->confectioneryDetails->pack_qty ?? 'N/A' }}</td>
                                                        <td colspan="2">
                                                            {{ $data->confectioneryDetails->freight ?? 'N/A' }}</td>
                                                        <td colspan="2">
                                                            {{ $data->confectioneryDetails->total ?? 'N/A' }}</td>
                                                    </tr>
                                                @endforeach
                                                <tr>
                                                    <td colspan="11" style="text-align: right;"><strong>Total
                                                            CTN:</strong></td>
                                                    <td colspan="1">
                                                        {{ $trndtl->sum(function ($item) {
                                                            return $item->confectioneryDetails->box ?? 0;
                                                        }) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="11" style="text-align: right;"><strong>Grand
                                                            Total:</strong></td>
                                                    <td colspan="1">
                                                        {{ $trndtl->sum(function ($item) {
                                                            return $item->confectioneryDetails->total ?? 0;
                                                        }) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="12" style="height: 26px; border: none;"></td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                            </tfoot>
                                        </table>



                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

        <script>
            function checkPermission() {
                @php
                    $isAdmin = auth()->user()->is_admin;
                    $canAdd = true;

                    if ($isAdmin == 0) {
                        $userRights = \App\Models\Right::where('user_id', auth()->user()->id)
                            ->where('app_name', 'confectionerydelivery')
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
                            ->where('app_name', 'confectionerydelivery')
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
                            ->where('app_name', 'confectionerydelivery')
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
            
            <!-- Contact Info Section -->
            
            
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

                // Restore original view
                table.style.display = 'none';
                tables.style.display = 'none';
            }


            function confirmDelete(button) {
                if (confirm('Are you sure you want to delete this record from both tables? This action cannot be undone.')) {
                    button.parentElement.submit();
                }
            }

            const today = new Date().toISOString().split('T')[0];

            // Set the value of the input field to the current date
            document.getElementById('end_date').value = today;
    function downloadTableJpg() {

    const headingSelect = document.getElementById('printHeadingSelect');
    const selectedHeading = headingSelect ? headingSelect.value : '';

    if (!selectedHeading) {
        alert('Please select a print heading before downloading.');
        headingSelect.focus();
        return;
    }

    const table = document.querySelector('.show-in-print');
    const header = document.querySelector('.show-in-prints');

    if (!table) {
        alert('Print table not found');
        return;
    }

    // show hidden content
    table.style.display = 'table';
    header.style.display = 'block';

    // wrapper
    const wrapper = document.createElement('div');
    wrapper.style.background = '#fff';
    wrapper.style.padding = '15px';
    wrapper.style.width = '1200px';

    // ===== HEADER (FIXED) =====
    let headerDiv = document.createElement('div');
    headerDiv.style.marginBottom = '10px';

    if (selectedHeading === 'Haider Packages GRW') {

        const box = document.createElement('div');
        box.style.background = '#333';
        box.style.color = '#fff';
        box.style.padding = '10px 20px';
        box.style.display = 'inline-block';

        const h1 = document.createElement('h1');
        h1.innerText = 'HAIDER PACKAGES';
        h1.style.margin = '0';
        h1.style.fontSize = '24px';
        h1.style.color = '#fff';

        const p = document.createElement('p');
        p.innerText = 'A COMPLETE UNIT OF PRINTING & PACKAGING';
        p.style.margin = '4px 0 0 0';
        p.style.fontSize = '11px';
        p.style.color = '#fff';

        box.appendChild(h1);
        box.appendChild(p);
        headerDiv.appendChild(box);

    } 
    else if (
        selectedHeading === 'ProBox Packages' ||
        selectedHeading === 'ProBox Packages official'
    ) {

        const img = document.createElement('img');
        img.src = "{{ url('assets/images/proboxlogo.jpg') }}"; // IMPORTANT: absolute URL
        img.style.maxWidth = '120px';
        img.style.height = 'auto';
        img.crossOrigin = "anonymous";

        headerDiv.appendChild(img);
    }

    // append everything
    wrapper.appendChild(headerDiv);
    wrapper.appendChild(header.cloneNode(true));
    wrapper.appendChild(table.cloneNode(true));

    document.body.appendChild(wrapper);

    setTimeout(() => {

        html2canvas(wrapper, {
            scale: 3,
            useCORS: true,
            allowTaint: true,
            backgroundColor: "#ffffff"
        }).then(canvas => {

            const link = document.createElement('a');
            link.download = "confectionery_report.jpg";
            link.href = canvas.toDataURL("image/jpeg", 1.0);
            link.click();

            // cleanup
            document.body.removeChild(wrapper);
            table.style.display = 'none';
            header.style.display = 'none';
        });

    }, 800);
}
        </script>
    
    @endsection
