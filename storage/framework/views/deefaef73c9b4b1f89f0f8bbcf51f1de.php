
<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Start Page Title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Softix</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                        <li class="breadcrumb-item active">Data Tables</li>
                    </ol>
                </div>
                <h4 class="page-title">Payables</h4>
            </div>
        </div>
    </div>
    <!-- End Page Title -->

    <!-- Show Form -->
    <div class="row">
        <div class="col-12">
            <div class="card mt-2">
                <div class="card-body">
                    <form action="<?php echo e(route('payables.list')); ?>" method="GET" class="form-inline" id="search-form">
                        <div class="row">
                            <div class="form-group col-xl-3">
                                <label for="end_date" class="sr-only">End Date</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo e(request('end_date')); ?>">
                            </div>
                            <div class="col-xl-3">
                                <button type="submit" class="btn btn-primary mb-2 mt-3">Show</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Ledger Table -->
    <?php if(request('end_date')): ?>
    <div class="row">
        <div class="col-12">
            <div class="card mt-2">
                <div class="card-body">
                    <button type="button" class="btn btn-secondary" style="width: 100px;" onclick="printTable()">Print Table</button>
                    <div class="card mt-2">
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane show active" id="basic-datatable-preview">
                                    <h5>End Date: <?php echo e(request('end_date')); ?></h5>
                                    <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>Account Title</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody id="ledger-tbody">
                                            <?php $__currentLoopData = $balances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($account->title); ?></td>
                                                    <td class="running-total">
                                                        <?php if($account->balance >= 0): ?>
                                                            <?php echo e(number_format($account->balance, 2)); ?> Dr
                                                        <?php else: ?>
                                                            <?php echo e(number_format(abs($account->balance), 2)); ?> Cr
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
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
    <?php endif; ?>
</div>

<script>
function printTable() {
    const elementsToHide = document.querySelectorAll('.no-print');
    elementsToHide.forEach(el => el.style.display = 'none');

    const headings = document.querySelectorAll('.col-12 h4, .col-12 h5');
    let headingsContent = '';
    headings.forEach(heading => {
        headingsContent += heading.outerHTML;
    });
    
    const tableContent = document.getElementById('basic-datatable').outerHTML;
    const originalContents = document.body.innerHTML;

    document.body.innerHTML = `
        <html>
            <head>
                <title>Print Table</title>
                <style>
                    table {
                        width: 100%;
                        border-collapse: collapse;
                    }
                    th, td {
                        border: 1px solid #ddd;
                        padding: 8px;
                    }
                    th {
                        background-color: #f2f2f2;
                        text-align: left;
                    }
                    h4, h5 {
                        margin: 5px 0;
                    }
                </style>
            </head>
            <body>
                ${headingsContent}
                ${tableContent}
            </body>
        </html>
    `;

    window.print();
    document.body.innerHTML = originalContents;
    window.location.reload();
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/realerp/public_html/probox/resources/views/payables/list.blade.php ENDPATH**/ ?>