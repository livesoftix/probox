<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Reports</a></li>
                            <li class="breadcrumb-item active">Purchase Invoice</li>
                        </ol>
                    </div>
                    <h3 class="page-title">Confectionery Billing</h3>
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

        <!-- Search Form -->
        <div class="row">
            <div class="card mt-2">
                <div class="card-body">
                    <div class="tab-content">
                        <div class="col-12">
                            <form action="<?php echo e(route('confect_billing.reports')); ?>" method="GET" class="form-inline"
                                id="search-form">
                                <div class="row">
                                    <!-- Start Date -->
                                    <div class="form-group col-xl-2">
                                        <label for="start_date" class="sr-only">Start Date</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date"
                                            value="<?php echo e($startDate); ?>">
                                    </div>
                                    <!-- End Date -->
                                    <div class="form-group col-xl-2">
                                        <label for="end_date" class="sr-only">End Date</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date"
                                            value="<?php echo e($endDate); ?>">
                                    </div>
                                    <!-- Status Dropdown -->
                                    <div class="form-group col-xl-2">
                                        <label for="account_title" class="sr-only">Status</label>
                                        <select name="status" class="form-control select2" data-toggle="select2">
                                            <option value="">All</option>
                                            <option value="official" <?php echo e($status == 'official' ? 'selected' : ''); ?>>Official
                                            </option>
                                            <option value="unofficial" <?php echo e($status == 'unofficial' ? 'selected' : ''); ?>>
                                                Unofficial</option>
                                        </select>
                                    </div>
                                    <!-- Voucher No Dropdown -->
                                    <div class="form-group col-xl-2">
                                        <label for="v_no" class="sr-only">Billing Number</label>
                                        <select name="v_no" class="form-control select2" data-toggle="select2">
                                            <option value="">Select Billing</option>
                                            <?php $__currentLoopData = $vNoList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vNo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($vNo); ?>"
                                                    <?php echo e(request()->get('v_no') == $vNo ? 'selected' : ''); ?>>
                                                    <?php echo e($vNo); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    <!-- Item Dropdown -->
                                    <div class="form-group col-xl-2">
                                        <label for="item" class="sr-only">Item</label>
                                        <select name="item" class="form-control select2" data-toggle="select2">
                                            <option value="">Select Item</option>
                                            <?php $__currentLoopData = $itemList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $itemId => $itemTitle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($itemId); ?>"
                                                    <?php echo e(request()->get('item') == $itemId ? 'selected' : ''); ?>>
                                                    <?php echo e($itemTitle ?? 'N/A'); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    <!-- Account (Party) Dropdown -->
                                    <div class="form-group col-xl-2">
                                        <label for="account_id" class="sr-only">Party</label>
                                        <select name="account_id" class="form-control select2" data-toggle="select2">
                                            <option value="">Select Party</option>
                                            <?php $__currentLoopData = $accountList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $accountId => $accountTitle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($accountId); ?>"
                                                    <?php echo e(request()->get('account_id') == $accountId ? 'selected' : ''); ?>>
                                                    <?php echo e($accountTitle ?? 'N/A'); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    <!-- Show Previous Balance Option -->
                                    <div class="form-group col-xl-2">
                                        <label class="form-label">Show Previous Balance?</label><br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="show_prev_balance"
                                                id="showPrevYes" value="1"
                                                <?php echo e(request()->get('show_prev_balance', '1') == '1' ? 'checked' : ''); ?>>
                                            <label class="form-check-label" for="showPrevYes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="show_prev_balance"
                                                id="showPrevNo" value="0"
                                                <?php echo e(request()->get('show_prev_balance', '1') == '0' ? 'checked' : ''); ?>>
                                            <label class="form-check-label" for="showPrevNo">No</label>
                                        </div>
                                    </div>


                                    <!-- Search and Add New Buttons -->
                                    <div class="form-group mt-3">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                        <a class="btn btn-success" href="<?php echo e(route('confect_billing.list')); ?>"
                                            role="button" onclick="return checkPermission()">Add
                                            New</a>
                                    </div>
                                </div>
                            </form>
                        </div>
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

                    <!-- First Table -->
                    <div class="card mt-2">
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="col-12">
                                    <table id="combined-data-table"
                                        class="table table-striped dt-responsive nowrap w-100">
                                        <h3>Confectionery Billing Details</h3>
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Invoice #</th>
                                                <th>Party</th>
                                                <th>Item</th>
                                                <th>Amount</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $trnDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    $saleInvoicesForVNo = $saleInvoices->where('v_no', $data1->v_no);
                                                    $uniqueItemTitles = []; // Array to store unique item titles for the current v_no
                                                    $itemTitles = ''; // Initialize the itemTitles variable outside the loop
                                                ?>
                                                <?php $__currentLoopData = $saleInvoicesForVNo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $saleInvoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                        $itemTitle = $saleInvoice->itemType->type_title ?? 'N/A';
                                                    ?>

                                                    <?php if($itemTitle !== 'N/A' && !in_array($itemTitle, $uniqueItemTitles)): ?>
                                                        <?php
                                                            $uniqueItemTitles[] = $itemTitle;
                                                        ?>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                <!-- Only display the row if either itemTitle or itemTitles is not 'N/A' -->
                                                <?php if(count($uniqueItemTitles) > 0): ?>
                                                    <tr>
                                                        <td><?php echo e(\Carbon\Carbon::parse($data1->date)->format('d-m-Y') ?? 'N/A'); ?>

                                                        </td>
                                                        <td><?php echo e(strtoupper(substr($data1->accounts->title ?? 'N/A', 0, 1)) . strtoupper(substr(explode(' ', $data1->accounts->title ?? 'N/A')[1] ?? '', 0, 1))); ?>

                                                            -<?php echo e($data1->v_no); ?></td>
                                                        <td><?php echo e($data1->accounts->title ?? 'N/A'); ?></td>
                                                        <td><?php echo e(implode(', ', $uniqueItemTitles) ?? 'N/A'); ?></td>
                                                         <?php
    $grandTotal = $saleInvoices
        ->where('v_no', $data1->v_no)
        ->sum(function ($invoice) {
            return ($invoice->rate ?? 0) * ($invoice->total ?? 0);
        });
?>
                                                        <!-- <td><?php echo e(number_format($data1->debit ?? 'N/A')); ?></td> -->
                                                         <td><?php echo e(number_format($grandTotal, 2)); ?>mm</td>
                                                        <td>
                                                            <?php
                                                                $billingNo =
                                                                    $data1->r_id ??
                                                                    \App\Models\ConfectBilling::where(
                                                                        'v_no',
                                                                        $data1->v_no,
                                                                    )->value('billing_no');
                                                            ?>
                                                            <?php if($billingNo): ?>
                                                                <form
                                                                    action="<?php echo e(route('confect_billing.destroy', ['billing_no' => $billingNo])); ?>"
                                                                    method="POST" onclick="return checkPermissionDel()">
                                                                    <?php echo csrf_field(); ?>
                                                                    <?php echo method_field('DELETE'); ?>
                                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                                        onclick="return confirm('Are you sure you want to delete this item?');">Delete</button>
                                                                </form>
                                                            <?php else: ?>
                                                                <button type="button" class="btn btn-danger btn-sm"
                                                                    disabled
                                                                    title="Delete unavailable: missing billing number">Delete</button>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>








                                    </table>
                                    <!-- Second Table -->
                                    <table id="combined-data-table-2"
                                        class="table table-striped dt-responsive nowrap w-100" style="display: none;">
                                        <h1 id="print-header" style="display: none;"></h1>
                                        <?php
                                            $displayedVNos = collect(); // To keep track of already displayed v_no values
                                            $vNoList = ''; // String to accumulate unique v_no values
                                        ?>

                                        <?php $__currentLoopData = $trnDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $vNo = $data1->v_no; // Get the v_no from the current record
                                            ?>

                                            <?php if(!$displayedVNos->contains($vNo)): ?>
                                                <?php
                                                    if ($vNoList !== '') {
                                                        $vNoList .= ', '; // Add a comma before appending another v_no
                                                    }
                                                    $vNoList .= $vNo; // Accumulate unique v_no values
                                                    $displayedVNos->push($vNo); // Mark this v_no as displayed
                                                ?>
                                            <?php endif; ?>


                                            <div
                                                style="display: flex; justify-content: space-between; align-items: center; margin: 10px 0;">
                                                <h3 id="print-header1" style="margin: 0; display: none;">
                                                    Date:
                                                    <?php echo e(\Carbon\Carbon::parse($data1->v_date)->format('d-m-Y') ?? 'N/A'); ?>

                                                </h3>

                                                <?php if($vNoList): ?>
                                                    <h3 id="print-header3"
                                                        style="margin: 0; padding-top: 0; display: none;">
                                                        Invoice #: <?php echo e($vNoList); ?>

                                                    </h3>
                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        <?php
                                            $displayedAccounts = collect(); // To keep track of already displayed account titles
                                            $accountTitles = ''; // String to accumulate account titles
                                        ?>

                                        <?php $__currentLoopData = $trnDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $saleInvoice = $saleInvoices->firstWhere('v_no', $data1->v_no);
                                                $itemTitle = $saleInvoice->itemType->type_title ?? 'N/A';
                                                $accountTitle = $data1->accounts->title ?? 'N/A';
                                            ?>

                                            <?php if($itemTitle !== 'N/A' && !$displayedAccounts->contains($accountTitle)): ?>
                                                <?php
                                                    if ($accountTitles !== '') {
                                                        $accountTitles .= ', '; // Add a comma before appending another account title
                                                    }
                                                    $accountTitles .= $accountTitle; // Accumulate account titles
                                                    $displayedAccounts->push($accountTitle); // Mark this account as displayed
                                                ?>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        <?php if($accountTitles): ?>
                                            <h2 id="print-header2" style="display: none;">Name: <?php echo e($accountTitles); ?></h2>
                                        <?php endif; ?>



                                        <thead>
                                            <tr id="default-headers">
                                                <th>Date</th>
                                                <th style="display: none;">OLD V.No</th>
                                                <th>V.No</th>
                                                <th>PO No</th>
                                                <th>Product Name</th>
                                                <th>Quantity</th>
                                                <th>Rate</th>
                                                <th>Amount</th>
                                                <th style="display: none;">item</th>
                                                <th style="display: none;">party</th>
                                            </tr>
                                            <tr id="official-headers" style="display: none;">
                                                
                                                <th>Product Name</th>
                                                <th>Quantity</th>
                                                <th>Rate</th>
                                                <th>Amount</th>
                                                <th>Rate of sales tax</th>
                                                <th>Total sales tax payable</th>
                                                <th>Value including sales tax</th>
                                                <th style="display: none;">item</th>
                                                <th style="display: none;">party</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $selectedAccountId = request()->get('account_id');
                                            ?>
                                            <?php if($selectedAccountId): ?>
                                                <p style="display: none;">Selected Account ID: <?php echo e($selectedAccountId); ?>

                                                </p>
                                            <?php endif; ?>

                                            <?php
                                                $currentVNo = null;
                                                // Filter invoices based on selected account
                                                $filteredInvoices = $selectedAccountId
                                                    ? $saleInvoices->where('account_id', $selectedAccountId)->values()
                                                    : $saleInvoices->values();
                                            ?>

                                            <?php
                                                $grandTotalByVNo = [];
                                                $grandSalesTaxByVNo = [];
                                                $grandValueWithTaxByVNo = [];
                                                foreach ($filteredInvoices as $invoice) {
                                                    $amount = ($invoice->rate ?? 0) * ($invoice->total ?? 0);
                                                    $salesTax = $invoice->st_amount ?? 0;
                                                    $valueWithTax = $amount + ($invoice->st_amount ?? 0);

                                                    if (!isset($grandTotalByVNo[$invoice->v_no])) {
                                                        $grandTotalByVNo[$invoice->v_no] = 0;
                                                        $grandSalesTaxByVNo[$invoice->v_no] = 0;
                                                        $grandValueWithTaxByVNo[$invoice->v_no] = 0;
                                                    }
                                                    $grandTotalByVNo[$invoice->v_no] += $amount;
                                                    $grandSalesTaxByVNo[$invoice->v_no] += $salesTax;
                                                    $grandValueWithTaxByVNo[$invoice->v_no] += $valueWithTax;
                                                }
                                            ?>

                                            <?php $__currentLoopData = $filteredInvoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    $trnDetail = $trnDetails->firstWhere('v_no', $data->v_no);
                                                    $acc = $trnDetail->accounts->title ?? 'N/A';
                                                    $gt = $grandTotalByVNo[$data->v_no] ?? 0;
                                                    $pb = $trnDetail->pre_balance ?? 'N/A';
                                                    $rateMissing = !isset($data->rate) || $data->rate === null;
                                                    $amountMissing = !isset($data->total) || $data->total === null;
                                                ?>

                                                <?php if($rateMissing || $amountMissing): ?>
                                                    <script>
                                                        alert('Warning: Rate or Amount is missing for Invoice #: <?php echo e($data->v_no); ?>');
                                                    </script>
                                                <?php endif; ?>

                                                <?php if($acc !== 'N/A' && $gt !== 'N/A'): ?>
                                                    <?php
                                                        $amount = ($data->rate ?? 0) * ($data->total ?? 0);
                                                        $salesTax = $amount * 0.18;
                                                        $totalWithTax = $amount + $salesTax;
                                                    ?>
                                                    <tr class="default-row">
                                                        <td><?php echo e(\Carbon\Carbon::parse($data->v_date)->format('d-m-Y') ?? 'N/A'); ?>

                                                        </td>
                                                        <td><?php echo e($data->old_vno); ?></td>
                                                        <td style="display: none;"><?php echo e($data->v_no); ?></td>
                                                        <td><?php echo e($data->po_no ?? 'N/A'); ?></td>
                                                        <td><?php echo e($data->product->prod_name ?? 'N/A'); ?></td>
                                                        <td><?php echo e(number_format($data->total ?? 0, 2)); ?></td>
                                                        <td><?php echo e(isset($data->rate) ? number_format((float) $data->rate, 2) : 'N/A'); ?>

                                                        </td>
                                                        <td><?php echo e(number_format($amount, 2)); ?></td>
                                                        <td style="display: none;">z
                                                            <?php echo e($data->itemType->type_title ?? 'N/A'); ?></td>
                                                        <td style="display: none;"><?php echo e($acc); ?></td>
                                                        <td style="display: none;"><?php echo e($data->account_id ?? 'N/A'); ?></td>
                                                    </tr>
                                                    <tr class="official-row" style="display: none;">
                                                        
                                                        <td><?php echo e($data->product->prod_name ?? 'N/A'); ?></td>
                                                        <td><?php echo e(number_format($data->total ?? 0, 2)); ?></td>
                                                        <td><?php echo e(isset($data->rate) ? number_format((float) $data->rate, 2) : 'N/A'); ?>

                                                        </td>
                                                        <td><?php echo e(number_format($amount, 2)); ?></td>
                                                        <td><?php echo e($data->st_rate ?? 0); ?>%</td>
                                                        <td><?php echo e(number_format($data->st_amount ?? 0, 2)); ?></td>
                                                        <td><?php echo e(number_format($amount + ($data->st_amount ?? 0), 2)); ?></td>
                                                        <td style="display: none;">
                                                            <?php echo e($data->itemType->type_title ?? 'N/A'); ?></td>
                                                        <td style="display: none;"><?php echo e($acc); ?></td>
                                                        <td style="display: none;"><?php echo e($data->account_id ?? 'N/A'); ?></td>
                                                    </tr>
                                                <?php endif; ?>

                                                
                                                <?php
                                                    $isLast = $index === count($filteredInvoices) - 1;
                                                    $nextVNoDifferent =
                                                        !$isLast && $filteredInvoices[$index + 1]->v_no !== $data->v_no;
                                                ?>

                                                <?php if($gt !== 'N/A' && ($isLast || $nextVNoDifferent)): ?>
                                                    <tr class="default-row">
                                                        <td colspan="6" style="text-align: right; font-weight: bold;">
                                                            Grand Total: </td>
                                                        <td colspan="2" style="font-weight: bold;">
                                                            <?php echo e(number_format($gt, 2)); ?></td>
                                                    </tr>
                                                    
                                                    <tr class="official-row" style="display: none;">
                                                        <td colspan="6" style="text-align: right; font-weight: bold;">
                                                            Total S.Tax Amount:</td>
                                                        <td style="font-weight: bold;">
                                                            <?php echo e(number_format($grandValueWithTaxByVNo[$data->v_no] ?? 0, 2)); ?>

                                                        </td>

                                                    </tr>
                                                    
                                                    
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>


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
                        ->where('app_name', 'confectionerybilling')
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
                        ->where('app_name', 'confectionerybilling')
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
                        ->where('app_name', 'confectionerybilling')
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

            const secondTable = document.getElementById('combined-data-table-2');
            const printHeader1 = document.getElementById('print-header1');
            const printHeader2 = document.getElementById('print-header2');
            const printHeader3 = document.getElementById('print-header3');
            const defaultHeaders = document.getElementById('default-headers');
            const officialHeaders = document.getElementById('official-headers');
            const defaultRows = document.querySelectorAll('.default-row');
            const officialRows = document.querySelectorAll('.official-row');

            secondTable.style.display = 'table';
            printHeader1.style.display = 'block';
            printHeader2.style.display = 'block';
            printHeader3.style.display = 'block';

            // Toggle headers and rows based on selection
            if (selectedHeading === 'ProBox Packages official') {
                defaultHeaders.style.display = 'none';
                officialHeaders.style.display = 'table-row';
                defaultRows.forEach(row => row.style.display = 'none');
                officialRows.forEach(row => row.style.display = 'table-row');
            } else {
                defaultHeaders.style.display = 'table-row';
                officialHeaders.style.display = 'none';
                defaultRows.forEach(row => row.style.display = 'table-row');
                officialRows.forEach(row => row.style.display = 'none');
            }

            const headerContent1 = printHeader1.outerHTML;
            const headerContent2 = printHeader2.outerHTML;
            const headerContent3 = printHeader3.outerHTML;

            // Build paginated table HTML: 9 rows for first page, 23 rows for subsequent pages
            const rowsToPrint = Array.from(secondTable.querySelectorAll(selectedHeading === 'ProBox Packages official' ? '.official-row' : '.default-row'));
            const headerHtml = selectedHeading === 'ProBox Packages official' ? officialHeaders.outerHTML : defaultHeaders.outerHTML;

            let paginatedTableHtml = '';
            if (rowsToPrint.length === 0) {
                const tfootHtml = `<tfoot><tr><td colspan="${selectedHeading === 'ProBox Packages official' ? '7' : '8'}" style="height: 50px; border: none;"></td></tr></tfoot>`;
                paginatedTableHtml = `<table style="width:100%; border-collapse: collapse;">${headerHtml}<tbody><tr><td colspan="${selectedHeading === 'ProBox Packages official' ? '7' : '8'}">No records found</td></tr></tbody>${tfootHtml}</table>`;
            } else {
                let i = 0;
                let pageNumber = 1;
                
                const tbodyHtml = `<tbody>` + rowsToPrint.map(r => r.outerHTML).join('') + `</tbody>`;
                const tfootHtml = `<tfoot><tr><td colspan="${selectedHeading === 'ProBox Packages official' ? '7' : '8'}" style="height: 50px; border: none;"></td></tr></tfoot>`;
                paginatedTableHtml = `<table style="width:100%; border-collapse: collapse;">` + headerHtml + tbodyHtml + tfootHtml + `</table>`;
            }

            let styledHeader = '';
            if (selectedHeading === 'Haider Packages GRW') {
                styledHeader = `
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-top: 20px; margin-bottom: 30px;">
            <!-- Header Section -->
            <div style="background: #333; color: white; padding: 10px 30px; display: inline-block; -webkit-print-color-adjust: exact; print-color-adjust: exact;">
                <h1 style="margin: 0; font-size: 32px; font-weight: bold; color: white !important; -webkit-print-color-adjust: exact; print-color-adjust: exact;">HAIDER PACKAGES</h1>
                <p style="margin: 8px 0 0 0; font-size: 14px; color: white !important; -webkit-print-color-adjust: exact; print-color-adjust: exact;">A COMPLETE UNIT OF PRINTING & PACKAGING</p>
            </div>
            
            <!-- Contact Info Section -->
            <div style="text-align: right; font-size: 16px; color: #000; padding-top: 10px; font-weight: bold;">
                <div style="margin-bottom: 6px;"><i class="uil uil-globe" style="margin-right: 8px; font-size: 18px;"></i>www.proboxpackages.com</div>
                <div style="margin-bottom: 6px;"><i class="uil uil-phone" style="margin-right: 8px; font-size: 18px;"></i>+92339-6451006</div>
                <div><i class="uil uil-envelope" style="margin-right: 8px; font-size: 18px;"></i>sales@proboxpackages.com</div>
            </div>
        </div>
        `;
            } else if (selectedHeading === 'ProBox Packages' || selectedHeading === 'ProBox Packages official') {
                const logoUrl = "<?php echo e(asset('assets/images/proboxlogo.jpg')); ?>";
                styledHeader = `
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-top: 20px; margin-bottom: 30px;">
            <!-- Header Section -->
            <div style="display: inline-block;">
                <img src="${logoUrl}" alt="ProBox Logo"
                     style="max-width: 200px; height: auto; display: block;"
                     onerror="this.style.display='none'">
            </div>
            
            <!-- Contact Info Section -->
            <div style="text-align: right; font-size: 16px; color: #000; padding-top: 10px;">
                <div style="margin-bottom: 6px;"><i class="uil uil-globe" style="margin-right: 8px; font-size: 18px;"></i>www.proboxpackages.com</div>
                <div style="margin-bottom: 6px;"><i class="uil uil-phone" style="margin-right: 8px; font-size: 18px;"></i>+92339-6451006</div>
                <div><i class="uil uil-envelope" style="margin-right: 8px; font-size: 18px;"></i>sales@proboxpackages.com</div>
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
                margin: 0mm 9mm 3mm 9mm;
            }
            body {
                font-family: Arial, sans-serif;
                font-size: 12px;
                padding: 10px 0 0 0;
                margin: 0;
                padding-bottom: 10px;
            }
            .content-wrapper {
                padding-bottom: 10px;
                margin-bottom: 20px; 
            }
            .details-section {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin: 20px 0;
                padding: 10px 0;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 10px;
                margin-bottom: 10px !important;
                page-break-inside: auto;
            }
            /* Each printed page wrapper */
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
                padding: 8px;
                page-break-inside: avoid;
            }
            tbody tr {
                height: 40px;
            }
            th:nth-child(1), td:nth-child(1) { /* Date column */
                width: 15%;
                min-width: 100px;
            }
            th:nth-child(5), td:nth-child(5) { /* Product Name column */
                width: 25%;
                min-width: 150px;
            }
            /* Official table column widths */
            #official-headers th:nth-child(1), .official-row td:nth-child(1) { /* Product Name */
                width: 35%;
                min-width: 200px;
            }
            #official-headers th:nth-child(5), .official-row td:nth-child(5) { /* Rate of sales tax */
                width: 8%;
                min-width: 60px;
            }
            th {
                background-color: #ffffffff;
                text-align: left;
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
                padding: 2px 20px 1px 20px;
                border-top: 2px solid #000;
                font-size: 13px;
                text-align: center;
                height: 40px; /* Fixed height */
                z-index: 1000;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            @media print {
                body { 
                    margin: 0;
                    padding: 0;
                    padding-top: 10px;
                }
                .content-wrapper {
                    padding-bottom:10px !important; 
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
            <!-- Header Section -->
            ${styledHeader}
            
            <!-- Details Section -->
            <div class="details-section">
                ${headerContent1}
                ${headerContent3}
            </div>
            <div style="margin-bottom: 50px;">
                ${headerContent2}
            </div>
            
            <!-- Table Section -->
            ${paginatedTableHtml}
        </div>
        <div class="footer">
            <div>
                <i class="uil uil-map-marker" style="margin-right: 4px;"></i>
                Address: 126-B Small Industrial Estate 3 (EPZ), Gujranwala. 
                &nbsp;&nbsp;
                <i class="uil uil-mobile-android" style="margin-right: 4px;"></i>
                Cell: 055-4286542 
                &nbsp;&nbsp;
                <i class="uil uil-phone" style="margin-right: 4px;"></i>
                PH: 0321-7421207
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
            secondTable.style.display = 'none';
            printHeader1.style.display = 'none';
            printHeader2.style.display = 'none';
            printHeader3.style.display = 'none';
            defaultHeaders.style.display = 'table-row';
            officialHeaders.style.display = 'none';
            defaultRows.forEach(row => row.style.display = 'table-row');
            officialRows.forEach(row => row.style.display = 'none');
        }

        const today = new Date().toISOString().split('T')[0];

        // Set the value of the input field to the current date
        document.getElementById('end_date').value = today;
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\probox\resources\views/sale_reports/index7.blade.php ENDPATH**/ ?>