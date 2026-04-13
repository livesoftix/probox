

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
                            <li class="breadcrumb-item active">Cheque Receipts</li>
                        </ol>
                    </div>
                    <h3 class="page-title">Cheque Receipts</h3>
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
                    <form action="<?php echo e(route('cheque_receipts.reports')); ?>" method="GET" id="search-form">
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
                                <select name="v_no" class="form-select select2"data-toggle="select2">
                                    <option value="">Select Voucher</option>
                                    <?php $__currentLoopData = $vNoList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vNo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($vNo); ?>" <?php echo e(request()->get('v_no') == $vNo ? 'selected' : ''); ?>>
                                            <?php echo e($vNo); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            
                            <div class="col-md-3">
                                <label for="bank" class="form-label">Bank</label>
                                <select name="bank" class="form-select select2"data-toggle="select2">
                                    <option value="">Select Bank</option>
                                    <?php $__currentLoopData = $accountIdList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $account = \App\Models\AccountMaster::find($id);
                                        ?>
                                        <option value="<?php echo e($id); ?>" <?php echo e(request()->get('bank') == $id ? 'selected' : ''); ?>>
                                            <?php echo e($account ? $account->title : 'Unknown Account'); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            
                            <div class="col-md-4">
                                <label for="chq_status" class="form-label">Cheque Status</label>
                                <select name="chq_status" class="form-select select2" data-toggle="select2">
                                    <option value="">Select Cheque</option>
                                    <?php $__currentLoopData = $chqStatusList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vNo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($vNo); ?>" <?php echo e(request()->get('chq_status') == $vNo ? 'selected' : ''); ?>>
                                            <?php echo e($vNo); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            
                            <div class="col-md-4 d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Search</button>
                                <a class="btn btn-success" href="<?php echo e(route('cheque.index')); ?>" onclick="return checkPermission()">
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


        <!-- Combined Data Table -->
        <div class="row">
            <div class="card">
                <div class="card-body">

                    <button type="button" class="btn btn-secondary" style="width: 100px;" onclick="printTable()">Print
                        Table</button>
                    <div class="card mt-2">
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="col-12">
                                    <h4>Cheque Receipts Report</h4>
                                    <h5>Start Date: <?php echo e(request()->get('start_date') ?? 'N/A'); ?> | End Date:
                                        <?php echo e(request()->get('end_date') ?? date('Y-m-d')); ?></h5>
                                    <table id="combined-data-table"
                                        class="table table-striped dt-responsive nowrap w-100 small-font-table ">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>V.No</th>
                                                <th>Chq Status</th>
                                                <th>Party</th>
                                                <th>Bank</th>
                                                <th>Chq Date</th>
                                                <th>Chq No</th>
                                                <th>Chq Amount</th>

                                                <th>description</th>
                                                <th class="no-print">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $cheques; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($data->created_at->format('Y-m-d')); ?></td>
                                                    <td><?php echo e($data->v_type); ?>-<?php echo e($data->v_no); ?></td>
                                                    <td><?php echo e($data->chq_status); ?></td>
                                                    <td><?php echo e($data->account->title ?? 'N/A'); ?></td>
                                                    <td><?php echo e($data->banks->title ?? 'N/A'); ?></td>
                                                    <td><?php echo e($data->chq_date); ?></td>
                                                    <td><?php echo e($data->chq_no); ?></td>
                                                    <td><?php echo e(number_format($data->chq_amt, 2)); ?></td>

                                                    <td><?php echo e($data->description); ?></td>

                                                    <td class="no-print">
                                                        <form
                                                            action="<?php echo e(route('chequeReceipts.destroy', ['id' => $data->id])); ?>"
                                                            method="POST" style="display:inline;"
                                                            onclick="return checkPermissionDel()">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('DELETE'); ?>
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                onclick="return confirm('Are you sure you want to delete this record?')">
                                                                <i class="uil uil-trash-alt"></i>
                                                            </button>
                                                        </form>

                                                        <a href="<?php echo e(route('cheque_receipts.edit', ['v_no' => $data->v_no])); ?>"
                                                            class="btn btn-warning btn-sm"
                                                            onclick="return checkPermissionEdit()">
                                                            <i class="uil uil-edit"></i>
                                                        </a>


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
                        ->where('app_name', 'ChequeReceipt')
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
                        ->where('app_name', 'ChequeReceipt')
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
                        ->where('app_name', 'ChequeReceipt')
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
            // Hide elements with 'no-print' class
            const elementsToHide = document.querySelectorAll('.no-print');
            elementsToHide.forEach(el => el.style.display = 'none');

            // Get all headings (both h4 and h5) and table content
            const headings = document.querySelectorAll('.col-12 h4, .col-12 h5');
            let headingsContent = '';
            headings.forEach(heading => {
                headingsContent += heading.outerHTML;
            });

            const tableContent = document.getElementById('combined-data-table').outerHTML;
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


        function confirmDelete(button) {
            if (confirm('Are you sure you want to delete this record from both tables? This action cannot be undone.')) {
                button.parentElement.submit();
            }
        }

        const today = new Date().toISOString().split('T')[0];

        // Set the value of the input field to the current date
        document.getElementById('end_date').value = today;
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/realerp/public_html/probox/resources/views/cheque/list.blade.php ENDPATH**/ ?>