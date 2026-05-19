<?php $__env->startSection('content'); ?>
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
                    <h3 class="page-title no-print">Pharmaceutical</h3>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible text-bg-success border-0 fade show" role="alert">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                    aria-label="Close"></button>
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible text-bg-danger border-0 fade show" role="alert">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                    aria-label="Close"></button>
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>
        <!-- Search Form -->
        <div class="row">
            <div class="card mt-2">
                <div class="card-body">
                    <div class="tab-content">
                        <div class="col-12">
                            <form action="<?php echo e(route('delivery_challan.reports')); ?>" method="GET" class="form-inline"
                                id="search-form">
                                <div class="row">
                                    <!-- Start Date -->
                                    <div class="form-group col-xl-2">
                                        <label for="start_date" class="sr-only">Start Date</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date"
                                            value="<?php echo e(request()->get('start_date')); ?>">
                                    </div>

                                    <!-- End Date -->
                                    <div class="form-group col-xl-2">
                                        <label for="end_date" class="sr-only">End Date</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date"
                                            value="<?php echo e(request()->get('end_date')); ?>">
                                    </div>

                                    <div class="form-group col-xl-2">
                                        <label for="account_title" class="sr-only">Status</label>
                                        <select name="status" class="form-control select2">
                                            <option value="">All</option>

                                            <option value="official" <?php echo e($status == 'official' ? 'selected' : ''); ?>>Official
                                            </option>
                                            <option value="unofficial" <?php echo e($status == 'unofficial' ? 'selected' : ''); ?>>
                                                Unofficial</option>

                                        </select>

                                    </div>

                                    <div class="form-group col-xl-2">
                                        <label for="v_no" class="sr-only">Voucher Number</label>
                                        <select name="v_no" class="form-control select2" data-toggle="select2">
                                            <option value="">Select Voucher</option>
                                            <?php $__currentLoopData = $vNoList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vNo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($vNo); ?>"
                                                    <?php echo e(request()->get('v_no') == $vNo ? 'selected' : ''); ?>>
                                                    <?php echo e($vNo); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <!-- P.O -->



                                    <div class="form-group col-xl-2">
                                        <label for="batch_no" class="sr-only">Batch No</label>
                                        <select name="batch_no" class="form-control select2" data-toggle="select2"
                                            id="batch_no">
                                            <option value="">Select Batch No</option>
                                            <?php $__currentLoopData = $poNumbers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $poNumber): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($poNumber); ?>"
                                                    <?php echo e(request()->get('batch_no') == $poNumber ? 'selected' : ''); ?>>
                                                    <?php echo e($poNumber); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <!-- Item Title -->
                                    <!-- Item Title -->
                                    <div class="form-group col-xl-2">
                                        <label for="itemTitle" class="sr-only">Item Type</label>
                                        <select name="item" class="form-control select2" data-toggle="select2"
                                            id="itemTitle">
                                            <option value="">Select Item</option>
                                            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($item->id); ?>"
                                                    <?php echo e(request()->get('item') == $item->id ? 'selected' : ''); ?>>
                                                    <?php echo e($item->type_title); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <br><br>
                                    <div class="form-group col-xl-2 mt-1">
                                        <label for="accountTitle" class="sr-only">Account Title</label>
                                        <select name="account" class="form-control select2" data-toggle="select2"
                                            id="accountTitle">
                                            <option value="">Select Account</option>
                                            <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($account->id); ?>"
                                                    <?php echo e(request()->get('account') == $account->id ? 'selected' : ''); ?>>
                                                    <?php echo e($account->title); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="form-group mt-3">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                        <a class="btn btn-success" href="<?php echo e(route('delivery_challan.list')); ?>"
                                            role="button" onclick="return checkPermission()">Add New</a>
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
                                        <div style="width: 100%; overflow-x: auto;">
                                            <table id="combined-data-tables"
                                                class="table dt-responsive nowrap w-100 small-font-table">
                                                <h4 class="no-print"></h4>
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>V.No</th>
                                                        <th>Account Title</th>
                                                        <th>Product Name</th>
                                                        <th>Batch No</th>
                                                        <th>CTN</th>
                                                        <th>Pack Qty</th>
                                                        <th>Total</th>
                                                        <th>Freight</th>
                                                        <th class="no-print">Status</th>
                                                        <th class="no-print">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $__currentLoopData = $trndtl; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td><?php echo e(\Carbon\Carbon::parse($data->date)->format('d-m-Y')); ?>

                                                            </td>
                                                            <td><?php echo e($data->v_type); ?>-<?php echo e($data->v_no); ?></td>
                                                            <td><?php echo e($data->accounts->title ?? 'N/A'); ?></td>
                                                            <td><?php echo e($data->deliveryDetails->products->prod_name ?? 'N/A'); ?>

                                                            </td>
                                                            <td><?php echo e($data->deliveryDetails->batch_no ?? 'N/A'); ?></td>
                                                            <td><?php echo e($data->deliveryDetails->box ?? 'N/A'); ?></td>
                                                            <td><?php echo e($data->deliveryDetails->pack_qty ?? 'N/A'); ?></td>
                                                            <td><?php echo e($data->deliveryDetails->total ?? 'N/A'); ?></td>
                                                            <td><?php echo e($data->deliveryDetails->freight ?? 'N/A'); ?></td>
                                                            <td class="no-print" style="display:none;">
                                                                <?php echo e($data->deliveryDetails->itemType->type_title ?? 'N/A'); ?>

                                                            </td>
                                                            <td class="no-print">
                                                                <input type="checkbox" class="status-checkbox"
                                                                    data-id="<?php echo e($data->id); ?>"
                                                                    <?php echo e($data->status == 'official' ? 'checked' : ''); ?>>
                                                            </td>
                                                            <td class="no-print">
                                                                <div
                                                                    class="d-flex justify-content-start align-items-center gap-2">
                                                                    <form
                                                                        action="<?php echo e(route('delivery_challan.delete', ['id' => $data->id])); ?>"
                                                                        method="POST"
                                                                        onsubmit="return checkPermissionDel()"
                                                                        class="m-0 p-0">
                                                                        <?php echo csrf_field(); ?>
                                                                        <?php echo method_field('DELETE'); ?>
                                                                        <button type="submit"
                                                                            class="btn btn-danger btn-sm"
                                                                            onclick="return confirmDelete(this)"
                                                                            title="Delete">
                                                                            <i class="uil uil-trash-alt"></i>
                                                                        </button>
                                                                    </form>

                                                                    <a href="<?php echo e(route('delivery_challan.edit', ['v_no' => $data->v_no])); ?>"
                                                                        class="btn btn-warning btn-sm"
                                                                        onclick="return checkPermissionEdit()"
                                                                        title="Edit">
                                                                        <i class="uil uil-edit"></i>
                                                                    </a>

                                                                    <a href="<?php echo e(route('delivery_challan.editDel', ['v_no' => $data->v_no])); ?>"
                                                                        class="btn btn-primary btn-sm" title="Freight">
                                                                        <i class="uil uil-truck"></i>
                                                                    </a>
                                                                </div>
                                                            </td>


                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            </table>
                                        </div>

                                        <table
                                            class="table table-striped dt-responsive nowrap w-100 print-table show-in-print"
                                            style="display: none;">
                                            <div class="show-in-prints" style="display: none;">
                                                <!-- OPTIMIZED MARGINS HERE: Reduced bottom margin to 5px -->
                                                <h2 style="text-align: center; font-weight: bold; margin-bottom: 5px;">Delivery Challan</h2>
                                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                                    <div style="text-align: left;">
                                                        <h3 style="margin: 0; font-weight: bold;">Category: Pharmaceuticals</h3>
                                                        <!-- OPTIMIZED MARGINS HERE: Reduced top margin to 2px -->
                                                        <h3 style="margin: 2px 0 0 0; font-weight: bold;">Name: <?php echo e($trndtl->unique('accounts.title')->pluck('accounts.title')->implode(', ')); ?></h3>
                                                    </div>
                                                    <div style="text-align: right;">
                                                        <h3 style="margin: 0; font-weight: bold;">Date: <?php echo e($trndtl->unique('date')->pluck('date')->map(function ($date) {
                                                                return \Carbon\Carbon::parse($date)->format('d-m-Y');
                                                            })->implode(', ')); ?></h3>
                                                        <!-- OPTIMIZED MARGINS HERE: Reduced top margin to 2px -->
                                                        <h3 style="margin: 2px 0 0 0; font-weight: bold;">V.No: <?php echo e($trndtl->unique('v_no')->pluck('v_no')->implode(', ')); ?></h3>
                                                    </div>
                                                </div>
                                            </div>
                                            <thead>
                                                <tr>
                                                    <th>Sr.No</th>
                                                    <th colspan="2" style="width: 40%;">Product Name</th>
                                                    <th colspan="2" style="width: 10%;">Batch No</th>
                                                    <th colspan="2" style="width: 10%;">CTN</th>
                                                    <th colspan="2" style="width: 10%;">Pack Qty</th>
                                                    <th colspan="2" style="width: 10%;">Freight</th>
                                                    <th colspan="2"style="width: 20%;">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $trndtl; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td><?php echo e($loop->iteration); ?></td>
                                                        <td colspan="2">
                                                            <?php echo e($data->deliveryDetails->products->prod_name ?? 'N/A'); ?></td>
                                                        <td colspan="2"><?php echo e($data->deliveryDetails->batch_no ?? 'N/A'); ?>

                                                        </td>
                                                        <td colspan="2"><?php echo e($data->deliveryDetails->box ?? 'N/A'); ?></td>
                                                        <td colspan="2"><?php echo e($data->deliveryDetails->pack_qty ?? 'N/A'); ?>

                                                        </td>
                                                        <td colspan="2"><?php echo e($data->deliveryDetails->freight ?? 'N/A'); ?>

                                                        </td>
                                                        <td colspan="2"><?php echo e($data->deliveryDetails->total ?? 'N/A'); ?>

                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="3" style="text-align: left;padding-top:15px !important; padding-botton:10px !important;">  <strong>Driver Name:</strong>
        <!-- <span style="
            display: inline-block;
            width: 180px;
            border-bottom: 1px solid #000;
            margin-left: 6px;
            height: 14px;
        "></span> -->
        </td>
                                                    <td colspan="8" style="text-align: right;"><strong>Total
                                                            CTN:</strong></td>
                                                    <td colspan="1">
                                                        <?php echo e($trndtl->sum(function ($item) {
                                                            return $item->deliveryDetails->box ?? 0;
                                                        })); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" style="text-align: left;padding-top:15px !important; padding-botton:10px !important;">  <strong>Vehicle No:</strong>
        <!-- <span style="
            display: inline-block;
            width: 140px;
            border-bottom: 1px solid #000;
            margin-left: 6px;
            height: 14px;
        "></span> -->
        </td>
                                                    <td colspan="8" style="text-align: right;"><strong>Grand
                                                            Total:</strong></td>
                                                    <td colspan="1">
                                                        <?php echo e($trndtl->sum(function ($item) {
                                                            return $item->deliveryDetails->total ?? 0;
                                                        })); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <!-- CALCULATION: Fixed footer is 25px. 26px is the absolute minimum safe clearance. -->
                                                    <td colspan="12" style="height: 26px; border: none;"></td>
                                                </tr>
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

        <script>
            function checkPermission() {
                <?php
                    $isAdmin = auth()->user()->is_admin;
                    $canAdd = true;

                    if ($isAdmin == 0) {
                        $userRights = \App\Models\Right::where('user_id', auth()->user()->id)
                            ->where('app_name', 'pharmaceuticaldelivery')
                            ->first();
                        $canAdd = $userRights && $userRights->add == 1;
                    }
                ?>

                if (!<?php echo json_encode($canAdd, 15, 512) ?>) {
                    alert('You do not have Permission to Add');
                    return false; // Prevent the default action (navigation)
                }
                return true; // Allow navigation
            }


            function checkPermissionEdit() {
                <?php
                    $isAdmin = auth()->user()->is_admin;
                    $canAdd = true;

                    if ($isAdmin == 0) {
                        $userRights = \App\Models\Right::where('user_id', auth()->user()->id)
                            ->where('app_name', 'pharmaceuticaldelivery')
                            ->first();
                        $canAdd = $userRights && $userRights->edit == 1;
                    }
                ?>

                if (!<?php echo json_encode($canAdd, 15, 512) ?>) {
                    alert('You do not have Permission to Edit');
                    return false; // Prevent the default action (navigation)
                }
                return true; // Allow navigation
            }

            function checkPermissionDel() {




                <?php
                    $isAdmin = auth()->user()->is_admin;
                    $canAdd = true;

                    if ($isAdmin == 0) {
                        $userRights = \App\Models\Right::where('user_id', auth()->user()->id)
                            ->where('app_name', 'pharmaceuticaldelivery')
                            ->first();
                        $canAdd = $userRights && $userRights->del == 1;
                    }
                ?>
                if (!<?php echo json_encode($canAdd, 15, 512) ?>) {
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
            
            
        </div>
        `;
                } else if (selectedHeading === 'ProBox Packages' || selectedHeading === 'ProBox Packages official') {
                    const logoUrl = "<?php echo e(asset('assets/images/proboxlogo.jpg')); ?>";
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
                text-align: center;
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
        <div style="margin-top: 14px; display: flex; gap: 50px; font-size: 12px;">
   
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
        </script>

      <?php $__env->startSection('scripts'); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
function downloadTableJpg() {

    const headingSelect = document.getElementById('printHeadingSelect');
    const selectedHeading = headingSelect ? headingSelect.value : '';

    if (!selectedHeading) {
        alert('Please select heading first');
        headingSelect.focus();
        return;
    }

    const table = document.querySelector('.show-in-print');
    const header = document.querySelector('.show-in-prints');

    table.style.display = 'table';
    header.style.display = 'block';

    // MAIN WRAPPER
    const wrapper = document.createElement('div');
    wrapper.id = "capture-wrapper";
    wrapper.style.background = '#fff';
    wrapper.style.padding = '20px';
    wrapper.style.width = '1200px';
    wrapper.style.fontFamily = 'Arial, sans-serif';

    const headerDiv = document.createElement('div');
    headerDiv.style.marginBottom = '10px';

    // COMMON RENDER FUNCTION
    function renderCanvas() {

        wrapper.innerHTML = '';
        wrapper.appendChild(headerDiv);
        wrapper.appendChild(header.cloneNode(true));
        wrapper.appendChild(table.cloneNode(true));

        // footer
        const footer = document.createElement('div');
        footer.style.marginTop = '15px';
        footer.style.textAlign = 'center';
        footer.style.fontSize = '12px';
        footer.innerHTML = 'Address: 126-B Small Industrial Estate 3 (EPZ), Gujranwala.';
        wrapper.appendChild(footer);

        document.body.appendChild(wrapper);

        setTimeout(() => {

         wrapper.querySelectorAll("*").forEach(el => {
    el.style.setProperty("color", "#000", "important");
    el.style.setProperty("font-family", "Arial, sans-serif", "important");
});

// HEADINGS / TH (VERY IMPORTANT)
wrapper.querySelectorAll("th, h1, h2, h3").forEach(el => {
    el.style.setProperty("color", "#000", "important");
    el.style.setProperty("font-weight", "800", "important");
    el.style.setProperty("font-size", "20px", "important"); // 👈 increase here
});

// TD CONTENT
wrapper.querySelectorAll("td").forEach(el => {
    el.style.setProperty("font-size", "14px", "important");
    el.style.setProperty("color", "#000", "important");
});

// TABLE GLOBAL SIZE
wrapper.querySelectorAll("table").forEach(tbl => {
    tbl.style.setProperty("font-size", "14px", "important");
    tbl.style.setProperty("color", "#000", "important");
});
            html2canvas(wrapper, {
                scale: 3,
                useCORS: true,
                allowTaint: true,
                backgroundColor: "#ffffff",
                windowWidth: wrapper.scrollWidth,
                windowHeight: wrapper.scrollHeight
            }).then(canvas => {

                const link = document.createElement('a');
                link.download = "pharmaceutical_report.jpg";
                link.href = canvas.toDataURL("image/jpeg", 1.0);
                link.click();

                document.body.removeChild(wrapper);
                table.style.display = 'none';
                header.style.display = 'none';

            });

        }, 400);
    }

    // =========================
    // HAIDER PACKAGES (TEXT HEADER)
    // =========================
   if (selectedHeading === 'Haider Packages GRW') {

    const imageUrl = "<?php echo e(asset('assets/images/hlogo.png')); ?>";

    const img = new Image();
    img.crossOrigin = "anonymous";
    img.src = imageUrl;

    img.onload = function () {

        img.style.maxWidth = '180px';
        img.style.height = 'auto';

        headerDiv.appendChild(img);

        setTimeout(() => {
            renderCanvas();
        }, 200);
    };

    img.onerror = function () {
        alert("Haider logo not loading. Check path.");
    };

}

    // =========================
    // PROBOX (IMAGE HEADER FIXED)
    // =========================
    else {

        const imageUrl = "<?php echo e(asset('assets/images/proboxlogo.jpg')); ?>";

        const img = new Image();
        img.crossOrigin = "anonymous";
        img.src = imageUrl;

        img.onload = function () {

            img.style.maxWidth = '150px';
            img.style.height = 'auto';

            headerDiv.appendChild(img);

            setTimeout(() => {
                renderCanvas();
            }, 200);
        };

        img.onerror = function () {
            alert("Logo failed to load. Check path or storage link.");
        };
    }
}
</script>

<?php $__env->stopSection(); ?>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\probox\resources\views/sale_reports/index.blade.php ENDPATH**/ ?>