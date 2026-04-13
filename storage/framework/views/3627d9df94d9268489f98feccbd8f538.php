
<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <!-- start page title -->
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
                    <h3 class="page-title">Bank Receipt</h3>
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
    <div class="card">
        <div class="card-body">
            <div class="tab-content">
                <div class="col-12">
                    <form action="<?php echo e(route('bank_recipt.reports')); ?>" method="GET" id="search-form">
                        <div class="row g-2 align-items-end">

                            
                            <div class="col-md-3">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="start_date" name="start_date"
                                    value="<?php echo e(request()->get('start_date')); ?>">
                            </div>

                            
                            <div class="col-md-3">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="end_date" name="end_date"
                                    value="<?php echo e(request()->get('end_date')); ?>">
                            </div>

                            
                            <div class="col-md-3">
                                <label for="v_no" class="form-label">Voucher Number</label>
                                <select name="v_no" class="form-select select2" data-toggle="select2">
                                    <option value="">Select Voucher</option>
                                    <?php $__currentLoopData = $vNoList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vNo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($vNo); ?>" <?php echo e(request()->get('v_no') == $vNo ? 'selected' : ''); ?>>
                                            <?php echo e($vNo); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            
                            <div class="col-md-3">
                                <label for="account_id" class="form-label">Account Title</label>
                                <select name="account_id" class="form-select select2" data-toggle="select2">
                                    <option value="">Select Account</option>
                                    <?php $__currentLoopData = $accountIdList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $account = \App\Models\AccountMaster::find($id);
                                        ?>
                                        <option value="<?php echo e($id); ?>" <?php echo e(request()->get('account_id') == $id ? 'selected' : ''); ?>>
                                            <?php echo e($account ? $account->title : 'Unknown Account'); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            
                            <div class="col-md-4 d-flex gap-2 mt-2">
                                <button type="submit" class="btn btn-primary">Search</button>
                                <a class="btn btn-success" href="<?php echo e(route('bank_recipt.list')); ?>" onclick="return checkPermission()">
                                    Add New
                                </a>
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
            <div class="card">
                <div class="card-body">


                    <button type="button" class="btn btn-secondary" style="width: 100px;" onclick="printTable()">Print
                        Table</button>
                    <div class="card mt-2">
                        <div class="card-body">

                            <div class="tab-content">
                                <div class="col-12">
                                    <!--<h5>Start Date: <span id="display-start-date"><?php echo e(\Carbon\Carbon::parse($startDate)->format('d-m-Y')); ?></span></h5>-->
                                    <!--<h5>End Date: <span id="display-end-date"><?php echo e(\Carbon\Carbon::parse($endDate)->format('d-m-Y')); ?></span></h5>-->

                                    <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                                        <h4>Bank Receipt Details</h4>
                                        <h5>Start Date: <?php echo e(request()->get('start_date') ?? 'N/A'); ?> | End Date:
                                            <?php echo e(request()->get('end_date') ?? date('Y-m-d')); ?></h5>

                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>User</th>
                                                <th>V. No</th>
                                                <th>Cash</th>
                                                <th>Account Title</th>
                                                <th>Description</th>
                                                <th>Amount</th>
                                                <th class="no-print">Image</th>
                                                <th class="no-print">Status</th>
                                                <th class="no-print">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            

                                            <?php $__currentLoopData = $trndtls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trndtl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e(\Carbon\Carbon::parse($trndtl->date)->format('d-m-Y')); ?></td>
                                                    <td><?php echo e($trndtl->preparedby); ?></td>
                                                    <td><?php echo e($trndtl->v_type); ?>-<?php echo e($trndtl->v_no); ?></td>
                                                    <td><?php echo e($trndtl->cashes ? $trndtl->cashes->title : 'N/A'); ?></td>
                                                    <td><?php echo e($trndtl->accounts ? $trndtl->accounts->title : 'N/A'); ?></td>
                                                    <!-- Assuming account relation -->
                                                    <td><?php echo e($trndtl->description); ?></td>
                                                    <td><?php echo e(number_format($trndtl->credit, 2)); ?></td>
                                                    <td class="no-print">
                                                        <?php if(!empty($trndtl->file_id)): ?>
                                                            <a href="<?php echo e(asset('storage/' . $trndtl->file_id)); ?>"
                                                                target="_blank">
                                                                <p>Img</p>
                                                            </a>
                                                        <?php else: ?>
                                                            <p>No Img</p>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="no-print">
                                                        <input type="checkbox" class="status-checkbox"
                                                            data-id="<?php echo e($trndtl->id); ?>"
                                                            <?php echo e($trndtl->status == 'official' ? 'checked' : ''); ?>>
                                                    </td>
                                                    <td class="no-print">
                                                        <!-- Edit button -->
                                                        <a href="<?php echo e(route('bank_recipt.edit', $trndtl->v_no)); ?>"
                                                            class="btn btn-warning btn-sm"
                                                            onclick="return checkPermissionEdit()">Edit</a>
                                                        
                                                        <!-- Delete button (use form for method spoofing) -->
                                                        <form action="<?php echo e(route('bank_recipt.delete', $trndtl->id)); ?>"
                                                            method="POST" style="display:inline-block;"
                                                            onclick="return checkPermissionDel()">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('DELETE'); ?>
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                onclick="return confirm('Are you sure you want to delete this transaction?')">Delete</button>
                                                        </form>
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

    <script>
        function checkPermission() {
            <?php
                $isAdmin = auth()->user()->is_admin;
                $canAdd = true;

                if ($isAdmin == 0) {
                    $userRights = \App\Models\Right::where('user_id', auth()->user()->id)
                        ->where('app_name', 'BankReceipt')
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
                        ->where('app_name', 'BankReceipt')
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
                        ->where('app_name', 'BankReceipt')
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




        const today = new Date().toISOString().split('T')[0];

        document.getElementById('end_date').value = today;


        function printTable() {
            // Hide elements with 'no-print' class
            const elementsToHide = document.querySelectorAll('.no-print');
            elementsToHide.forEach(el => el.style.display = 'none');

            // Get all headings (both h4 and h5) and table content
            const headings = document.querySelectorAll('.col-12 h4, .col-12 h5');
            let headingsContent = '';
            headings.forEach(heading => {
                headingsContent += heading.outerHTML;
            });

            const tableContent = document.getElementById('basic-datatable').outerHTML;
            const originalContents = document.body.innerHTML;

            // Replace body content with the headings and table HTML for printing
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
                    .no-print {
                        display: none;
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

            // Trigger print dialog
            window.print();

            // Restore the original page content after printing
            document.body.innerHTML = originalContents;

            // Reattach event listeners or reload the page if needed
            window.location.reload();
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/realerp/public_html/probox/resources/views/bank_reports/index2.blade.php ENDPATH**/ ?>