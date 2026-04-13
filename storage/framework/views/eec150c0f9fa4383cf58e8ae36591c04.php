
<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- start page title -->
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
                <h4 class="page-title">Ledger</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <!-- Search Form -->
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="tab-content">
                    <div class="col-12">
                        <form action="<?php echo e(route('ledger.list')); ?>" method="GET" class="form-inline col-xl-12" id="search-form">
                            <div class="row">
                                <div class="form-group col-xl-3">
                                    <label for="start_date" class="sr-only">Start Date</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date"
                                        value="<?php echo e(request()->get('start_date')); ?>">
                                </div>
                                <div class="form-group col-xl-3">
                                    <label for="end_date" class="sr-only">End Date</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date"
                                        value="<?php echo e(request()->get('end_date')); ?>">
                                </div>
                                <div class="form-group col-xl-3">
                                    <label for="account_title" class="sr-only">Account Title</label>
                                    <select name="account_title" id="account_title" class="form-control select2"
                                        data-toggle="select2">
                                        <option value="">Select Account</option>
                                        <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($account->id); ?>" <?php echo e(isset($accountId) && $accountId==$account->id ? 'selected' : ''); ?>>
                                            <?php echo e($account->title); ?>

                                        </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="form-group col-xl-3">
                                    <label for="account_title" class="sr-only">Status</label>
                                    <select name="status" class="form-control select2">
                                        <option value="">All</option>
                                        <option value="official" <?php echo e($status=='official' ? 'selected' : ''); ?>>Official</option>
                                        <option value="unofficial" <?php echo e($status=='unofficial' ? 'selected' : ''); ?>>Unofficial</option>
                                    </select>
                                </div>
                                <div class="col-xl-3">
                                    <button type="submit" class="btn btn-primary mb-2 mt-3">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ledger Table -->
    <div class="row">
        <div class="card mt-2">
            <div class="card-body">

                <div id="print-header" style="display:none;">
                    <?php
                    $selectedAccount = $accounts->firstWhere('id', request()->get('account_title'));
                    ?>
                    <h3>Ledger Details</h3>
                    <div>
                        <h5 style="display: inline-block;">Start Date: 
                            <span id="display-start-date"><?php echo e(request()->get('start_date') ?? 'N/A'); ?></span>
                        </h5>
                        <h5 style="display: inline-block; float: right;">Name: 
                            <span id="display-party-name"><?php echo e($selectedAccount ? $selectedAccount->title : 'N/A'); ?></span>
                        </h5>
                    </div>
                    <h5>End Date: 
                        <span id="display-end-date"><?php echo e(request()->get('end_date') ?? date('Y-m-d')); ?></span>
                    </h5>
                </div>

                <!-- Buttons -->
                <button type="button" class="btn btn-secondary" style="width: 100px;" onclick="printTable()">Print</button>
                <button type="button" class="btn btn-success" style="width: 120px;" onclick="downloadPDF()">Download</button>

                <div class="card mt-2">
                    <div class="card-body">
                        <div class="tab-content">
                            <div id="ledger">
                                <div>
                                    <h3>Ledger Details</h3>
                                    <div>
                                        <h4 style="display: inline-block;">Start Date: 
                                            <span id="display-start-date">
                                                <?php if(request()->get('start_date')): ?>
                                                    <?php echo e(date_format(date_create(request()->get('start_date')), 'd-m-Y')); ?>

                                                <?php else: ?>
                                                    N/A
                                                <?php endif; ?>
                                            </span>  ||
                                        </h4>
                                        <h4 style="display: inline-block;">End Date: 
                                            <span id="display-end-date">
                                                <?php if(request()->get('end_date')): ?>
                                                    <?php echo e(date_format(date_create(request()->get('end_date')), 'd-m-Y')); ?>

                                                <?php else: ?>
                                                    <?php echo e(date('d-m-Y')); ?>

                                                <?php endif; ?>
                                            </span>
                                        </h4>
                                    </div>
                                </div>

                                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Voucher Type</th>
                                            <th>Description</th>
                                            <th>Debit</th>
                                            <th>Credit</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th colspan="3" class="text-end">Opening Balance</th>
                                            <th></th>
                                            <th></th>
                                            <th>
                                                <?php if($openingBalance >= 0): ?>
                                                    <?php echo e(number_format(($openingBalance), 2)); ?> Dr
                                                <?php else: ?>
                                                    <?php echo e(number_format(($openingBalance), 2)); ?> Cr
                                                <?php endif; ?>
                                            </th>
                                        </tr>
                                        <?php
                                        $runningTotal = $openingBalance;
                                        $totalDebit = 0;
                                        $totalCredit = 0;
                                        $sortedTrndtls = $trndtls->sortBy('date');
                                        ?>

                                        <?php $__currentLoopData = $sortedTrndtls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trndtl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $debit = $trndtl->debit;
                                            $credit = $trndtl->credit;

                                            if ($trndtl->cash_id == $accountId && $trndtl->account_id != $accountId) {
                                                $credit = $trndtl->debit;
                                                $debit = $trndtl->credit;
                                            }

                                            $totalDebit += $debit;
                                            $totalCredit += $credit;
                                            $difference = $debit - $credit;
                                            $runningTotal += $difference;
                                        ?>
                                        <tr>
                                            <td><?php echo e(\Carbon\Carbon::parse($trndtl->date)->format('d-m-Y')); ?></td>
                                            <td><?php echo e($trndtl->v_type); ?>-<?php echo e($trndtl->v_no); ?></td>
                                            <td><?php echo e($trndtl->description); ?></td>
                                            <td><?php echo e(number_format($debit, 2)); ?></td>
                                            <td><?php echo e(number_format($credit, 2)); ?></td>
                                            <td>
                                                <?php if($runningTotal > 0): ?>
                                                    <?php echo e(number_format($runningTotal, 2)); ?> Dr
                                                <?php elseif($runningTotal < 0): ?>
                                                    <?php echo e(number_format(abs($runningTotal), 2)); ?> Cr
                                                <?php else: ?>
                                                    <?php echo e(number_format($runningTotal, 2)); ?>

                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        <tr>
                                            <th colspan="3" class="text-end">Total:</th>
                                            <td><?php echo e(number_format($totalDebit, 2)); ?></td>
                                            <td><?php echo e(number_format($totalCredit, 2)); ?></td>
                                            <td>
                                                <?php if($runningTotal > 0): ?>
                                                    <?php echo e(number_format($runningTotal, 2)); ?> Dr
                                                <?php elseif($runningTotal < 0): ?>
                                                    <?php echo e(number_format(abs($runningTotal), 2)); ?> Cr
                                                <?php else: ?>
                                                    <?php echo e(number_format($runningTotal, 2)); ?>

                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> <!-- inner card -->
            </div>
        </div>
    </div>
</div>

<!-- jsPDF libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.29/jspdf.plugin.autotable.min.js"></script>

<script>
const today = new Date();
const endDate = formatDate(today);
const startDate = formatDate(new Date(today.getFullYear(), today.getMonth(), 1));

const startInput = document.getElementById('start_date');
const endInput = document.getElementById('end_date');

if (!startInput.value) startInput.value = startDate;
if (!endInput.value) endInput.value = endDate;

function formatDate(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}

function printTable() {
    const elementsToHide = document.querySelectorAll('.no-print');
    elementsToHide.forEach(el => el.style.display = 'none');

    const hiddenDiv = document.querySelector('div[style="display:none;"]');
    const headingContent = hiddenDiv.querySelector('h3').outerHTML;
    const subHeadings = hiddenDiv.querySelectorAll('h5');
    const subHeadingContent = Array.from(subHeadings).map(h5 => h5.outerHTML).join('');

    const printContents = document.getElementById('basic-datatable').outerHTML;
    const originalContents = document.body.innerHTML;

    document.body.innerHTML = `
        <html>
            <head>
                <title>Print Table</title>
                <style>
                    table { width: 100%; border-collapse: collapse; }
                    th, td { border: 1px solid #ddd; padding: 8px; }
                    th { background-color: #f2f2f2; text-align: left; }
                </style>
            </head>
            <body>
                ${headingContent}
                ${subHeadingContent}
                ${printContents}
            </body>
        </html>
    `;

    window.print();
    document.body.innerHTML = originalContents;
    window.location.reload();
}

function downloadPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    doc.setFontSize(14);
    doc.text("Ledger Details", 14, 15);

    const startDate = document.getElementById("display-start-date")?.innerText || "N/A";
    const endDate = document.getElementById("display-end-date")?.innerText || "N/A";
    const partyName = document.getElementById("display-party-name")?.innerText || "N/A";

    doc.setFontSize(10);
    doc.text(`Start Date: ${startDate}`, 14, 25);
    doc.text(`End Date: ${endDate}`, 100, 25);
    doc.text(`Name: ${partyName}`, 14, 32);

    doc.autoTable({
        html: '#basic-datatable',
        startY: 40,
        styles: { fontSize: 9, cellPadding: 2 },
        headStyles: { fillColor: [52, 73, 94], textColor: 255 },
    });

    doc.save(`ledger_${partyName}_${startDate}_to_${endDate}.pdf`);
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/realerp/public_html/probox/resources/views/ledger/list.blade.php ENDPATH**/ ?>