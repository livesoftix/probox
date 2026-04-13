

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
                            <li class="breadcrumb-item active">Disposable Purchase</li>
                        </ol>
                    </div>
                    <h3 class="page-title">Disposable Purchase</h3>
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
                        <div class="col-6">
                            <form action="<?php echo e(route('disposable_purchase.reports')); ?>" method="GET" class="form-inline"
                                id="search-form">
                                <div class="row">
                                    <div class="form-group col-xl-4">
                                        <label for="start_date" class="sr-only">Start Date</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date"
                                            value="<?php echo e(request()->get('start_date')); ?>">
                                    </div>
                                    <div class="form-group col-xl-4">
                                        <label for="end_date" class="sr-only">End Date</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date"
                                            value="<?php echo e(request()->get('end_date')); ?>">
                                    </div>
                                    <div class="form-group col-xl-4">
                                        <label for="status" class="sr-only">Status</label>
                                        <select name="status" class="form-control select2">
                                            <option value="">All Statuses</option>
                                            <option value="official"
                                                <?php echo e(request()->get('status') == 'official' ? 'selected' : ''); ?>>Official
                                            </option>
                                            <option value="unofficial"
                                                <?php echo e(request()->get('status') == 'unofficial' ? 'selected' : ''); ?>>Unofficial
                                            </option>
                                        </select>
                                    </div>

                                    <div class="form-group col-xl-4 mt-2">
                                        <label for="v_no" class="sr-only">Voucher Number</label>
                                        <select name="v_no" class="form-control select2" data-toggle="select2">
                                            <option value="">Select Voucher</option>
                                            <?php $__currentLoopData = $vouchers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vNo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($vNo); ?>"
                                                    <?php echo e(request()->get('v_no') == $vNo ? 'selected' : ''); ?>>
                                                    <?php echo e($vNo); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-xl-4 mt-2">
                                        <label for="account_id" class="sr-only">Supplier</label>
                                        <select name="account_id" class="form-control select2" data-toggle="select2">
                                            <option value="">Select Supplier</option>
                                            <?php $__currentLoopData = $accountMasters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($account->id); ?>"
                                                    <?php echo e(request()->get('account_id') == $account->id ? 'selected' : ''); ?>>
                                                    <?php echo e($account->title); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    <div class="form-group mt-3">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                        <a class="btn btn-success" href="<?php echo e(route('disposable_purchase.list')); ?>"
                                            role="button" onclick="return checkPermission()">Add New</a>
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
                                    <h4>Disposable Purchase Details</h4>
                                    <table id="combined-data-table" class="table table-striped dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th class="no-print">Date</th>
                                                <th class="no-print">V. No</th>
                                                <th>Supplier</th>
                                                <th>Item</th>
                                                <th>Quantity</th>
                                                <th>Unit</th>
                                                <th>Rate</th>


                                                <th>Amount</th>
                                                <th>Freight</th>
                                                <th>Image</th>
                                                <th class="no-print">Status</th>
                                                <th class="no-print">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $totalQty = 0;
                                                $totalAmount = 0;
                                            ?>
                                            <?php $__currentLoopData = $trndtlEntries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    $qty = $entry->disposablepurchase->qty ?? 0;
                                                    $amount = $entry->disposablepurchase->amount ?? 0;
                                                    $totalQty += is_numeric($qty) ? $qty : 0;
                                                    $totalAmount += is_numeric($amount) ? $amount : 0;
                                                ?>
                                                <tr>
                                                    <td class="no-print">
                                                        <?php echo e(\Carbon\Carbon::parse($entry->date)->format('d-m-Y')); ?></td>
                                                    <td class="no-print"><?php echo e($entry->v_type); ?>-<?php echo e($entry->v_no); ?></td>
                                                    <td><?php echo e(optional($accountMasters->firstWhere('id', $entry->account_id))->title ?? 'N/A'); ?>

                                                    </td>
                                                    <td><?php echo e($entry->disposablepurchase->item->item_code ?? 'N/A'); ?></td>
                                                    <td><?php echo e($entry->disposablepurchase->qty ?? 'N/A'); ?></td>
                                                    <td><?php echo e($entry->disposablepurchase->weight_type ?? 'N/A'); ?></td>
                                                    <td><?php echo e($entry->disposablepurchase->rate ?? 'N/A'); ?></td>


                                                    <td><?php echo e($entry->disposablepurchase->amount ?? 'N/A'); ?></td>
                                                    <td><?php echo e($entry->disposablepurchase->freight ?? 'N/A'); ?></td>
                                                    <td>
                                                        <?php if($entry->disposablepurchase && $entry->disposablepurchase->image): ?>
                                                            <a href="<?php echo e(asset('storage/' . $entry->disposablepurchase->image)); ?>"
                                                                target="_blank">IMG</a>
                                                        <?php else: ?>
                                                            N/A
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="no-print">
                                                        <input type="checkbox" class="status-checkbox"
                                                            data-id="<?php echo e($entry->id); ?>"
                                                            <?php echo e($entry->status == 'official' ? 'checked' : ''); ?>>
                                                    </td>
                                                    <td class="no-print">
                                                        <div class="d-flex align-items-center gap-1">
                                                            <form
                                                                action="<?php echo e(route('disposable_purchase.delete', ['id' => $entry->id])); ?>"
                                                                method="POST" style="display:inline;"
                                                                onclick="return checkPermissionDel()">
                                                                <?php echo csrf_field(); ?>
                                                                <?php echo method_field('DELETE'); ?>
                                                                <button type="button" class="btn btn-danger btn-sm"
                                                                    onclick="confirmDelete(this)"><i
                                                                        class="uil uil-trash-alt"></i></button>
                                                            </form>
                                                            <a href="<?php echo e(route('disposable_purchase.edit', ['v_no' => $entry->v_no])); ?>"
                                                                class="btn btn-warning btn-sm"
                                                                onclick="return checkPermissionEdit()"><i
                                                                    class="uil uil-edit"></i></a>
                                                            <a href="<?php echo e(route('disposable_purchase.editFreight', ['v_no' => $entry->v_no])); ?>"
                                                                class="btn btn-primary btn-sm" style="cursor:pointer;"><i
                                                                    class="uil uil-truck"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td colspan="7" style="text-align: right; font-weight: bold;">Total
                                                    Quantity:</td>
                                                <td style="font-weight: bold;"><?php echo e(number_format($totalQty, 2)); ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="7" style="text-align: right; font-weight: bold;">Total
                                                    Amount:</td>
                                                <td style="font-weight: bold;"><?php echo e(number_format($totalAmount, 2)); ?></td>
                                            </tr>
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
                        ->where('app_name', 'DisposablePurchase')
                        ->first();
                    $canAdd = $userRights && $userRights->add == 1;
                }
            ?>

            if (!<?php echo json_encode($canAdd, 15, 512) ?>) {
                alert('You do not have Permission to Add');
                return false;
            }
            return true;
        }

        function checkPermissionEdit() {
            <?php
                $isAdmin = auth()->user()->is_admin;
                $canEdit = true;

                if ($isAdmin == 0) {
                    $userRights = \App\Models\Right::where('user_id', auth()->user()->id)
                        ->where('app_name', 'DisposablePurchase')
                        ->first();
                    $canEdit = $userRights && $userRights->edit == 1;
                }
            ?>

            if (!<?php echo json_encode($canEdit, 15, 512) ?>) {
                alert('You do not have Permission to Edit');
                return false;
            }
            return true;
        }

        function checkPermissionDel() {
            <?php
                $isAdmin = auth()->user()->is_admin;
                $canDel = true;

                if ($isAdmin == 0) {
                    $userRights = \App\Models\Right::where('user_id', auth()->user()->id)
                        ->where('app_name', 'DisposablePurchase')
                        ->first();
                    $canDel = $userRights && $userRights->del == 1;
                }
            ?>

            if (!<?php echo json_encode($canDel, 15, 512) ?>) {
                alert('You do not have Permission to Delete');
                return false;
            }
            return true;
        }

        function printTable() {
            const elementsToHide = document.querySelectorAll('.no-print');
            elementsToHide.forEach(el => el.style.display = 'none');

            const h5Element = document.querySelector('h5');
            if (h5Element) {
                h5Element.innerHTML = `
                <span style="flex: 1; font-size: 14px;">
                    Date: <?php echo e($trndtlEntries->isNotEmpty() ? \Carbon\Carbon::parse($trndtlEntries->first()->date)->format('d-m-Y') : 'N/A'); ?>

                </span>
                <span style="margin-left: auto; font-size: 14px;">
                  Voucher No: <?php echo e($trndtlEntries->isNotEmpty() ? $trndtlEntries->first()->v_type : 'N/A'); ?>-<?php echo e($trndtlEntries->isNotEmpty() ? $trndtlEntries->first()->v_no : 'N/A'); ?>

                </span>
            `;
                h5Element.style.display = 'flex';
                h5Element.style.justifyContent = 'space-between';
                h5Element.style.alignItems = 'center';
            }

            const headingContent = document.querySelector('h4').outerHTML;
            const subHeadingContent = document.querySelector('h5').outerHTML;
            const tableContent = document.getElementById('combined-data-table').outerHTML;

            // No freight content for disposable purchases
            const freightContent = ``;

            const originalContents = document.body.innerHTML;

            document.body.innerHTML = `
            <html>
                <head>
                    <title>Print Table</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            font-size: 12px;
                            margin: 0;
                            padding: 0;
                        }

                        table {
                            width: 100%;
                            border-collapse: collapse;
                            margin: 0;
                            padding: 0;
                        }

                        th, td {
                            border: 1px solid #ddd;
                            padding: 2px;
                        }

                        th {
                            background-color: #f2f2f2;
                            text-align: left;
                        }

                        .no-print {
                            display: none;
                        }

                        @media print {
                            @page {
                                margin: 20px;
                            }

                            body {
                                margin: 0;
                                padding: 0;
                            }
                        }
                    </style>
                </head>
                <body>
                    ${headingContent}
                    ${subHeadingContent}
                    ${tableContent}
                    ${freightContent}
                </body>
            </html>
        `;

            window.print();

            document.body.innerHTML = originalContents;

            window.location.reload();
        }

        function confirmDelete(button) {
            if (confirm('Are you sure you want to delete this record? This action cannot be undone.')) {
                button.parentElement.submit();
            }
        }

        const today = new Date().toISOString().split('T')[0];
        document.getElementById('end_date').value = today;
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/realerp/public_html/probox/resources/views/disposable_purchase/reports.blade.php ENDPATH**/ ?>